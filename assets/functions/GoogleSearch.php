<?php
require_once('Search.php');

/**
 * Execute a search
 */
class KSAS_GoogleSearch extends KSAS_Search {
    /**
     * @param string $index_file index file to search against
     * @returns KSAS_Search
     */
    public function __construct() {
        
    }
    
    /**
     * @param string $query raw search query
     * @param string $baseQueryURL the URL that returns the first page of results (w/o resultsPageNum=)
     * @param integer $resultsPageNum the page of results to display
     * @param integer $resultsPerPage the number of results to display on each page of results
     * @returns KSAS_GoogleSearchResults
     */
    public function query($q, $collection_name, $baseQueryURL, $resultsPageNum = 1, $resultsPerPage = 10) {
        return new KSAS_GoogleSearchResults($this, $q, $collection_name, $baseQueryURL, $resultsPageNum, $resultsPerPage);
    }
}

/**
 * Manage and retrieve search result data
 */
class KSAS_GoogleSearchResults extends KSAS_SearchResults {
    const MAX_RESULTS = 100; // google will match more than this, but won't turn more actual results
    private $baseQueryURL = null;
    private $displayQuery = null;
    private $firstResultNum = 0;
    private $hits = null;
    private $lastResultNum = 0;
    private $lastResultsPageNum = null;
    private $notices = array(); // notices to the user about the search results
    private $paginator = null;
    private $q = null;
    private $collection_name = null;
    private $resultsCounter = 0;
    private $resultsPageNum = null;
    private $searchEngine = null;
    private $start = 0; // corresponds to google's "start" param
    private $xml = null;
    private $sponsored_title = null;
    private $sponsored_url = null;
    /**
     * @param KSAS_GoogleSearch $searchEngine the instance of {@link KSAS_GoogleSearch} that returned these search results
     * @param string $query the user query that produced these search results
     * @param string $baseQueryURL the URL that returns the first page of results (w/o resultsPageNum=)
     * @param integer $resultsPageNum the page of results to display
     * @param integer $resultsPerPage the number of results to display on each page of results
     * @returns KSAS_GoogleSearchResults
     */
    public function __construct(KSAS_GoogleSearch $searchEngine, $q, $collection_name, $baseQueryURL, $resultsPageNum = 1, $resultsPerPage = 10) {
        $this->start = ($resultsPageNum - 1) * $resultsPerPage; // google counts from 0, array style
        
        $this->searchEngine = $searchEngine;
        $searchParams = array(  'q'         => urlencode($q),
                                'num'           => $resultsPerPage,
                                'filter'        => 0,
                                'site' => $collection_name );
        if ($this->start > 0) {
            $searchParams['start'] = $this->start;
        }
        
        $url = "http://search.johnshopkins.edu/search?output=xml&client=ksas_frontend";
        foreach ($searchParams as $key => $value) {
            $url .= "&$key=$value";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $xml = curl_exec($ch);
        if (!$xml) {
            $errorCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $errorMessage = curl_error($ch);
            curl_close($ch);
            throw new \Exception("Unable to retrieve XML from Google Search Appliance: $url => $errorCode: $errorMessage");
        }
        curl_close($ch);
        $xml = new SimpleXMLElement($xml);
        $query = $xml->xpath("//PARAM[@name='q'] | //PARAM[@name='query']");
        if (!$query) {
            throw new \Exception("XML from Google Search Appliance does not contain expected PARAM 'q' or 'query'");
        }
        $query = $query[0];
        $this->query = (string) $query['original_value'];
        $this->displayQuery = htmlspecialchars((string) $query['value']);
        
        if ($xml->RES) {
            $this->hits = (string) $xml->RES->M;
        } else {
            $this->hits = 0;
        }
        if ($this->hits == 0) {
            $this->firstResultNum = 0;
            $this->lastResultNum = 0;
        } else {
            $this->firstResultNum = $xml->RES['SN'];
            $this->lastResultNum = $xml->RES['EN'];
        }
        
        // pagination related stuff
        if (strpos($baseQueryURL, '?')) {
            $this->baseQueryURL = $baseQueryURL . '&amp;';
        } else {
            $this->baseQueryURL = $baseQueryURL . '?';
        }
        // bring resultsPageNum in bounds
        if ($resultsPageNum < 1) {
            $resultsPageNum = 1;
        }
        // Google stops returning results after a certain number
        // So stop showing results pages when that limit is reached
        $resultsShown = min($this->hits, self::MAX_RESULTS);
        $maxResultsPageNum = ($resultsShown - ($resultsShown % $resultsPerPage)) + $resultsPerPage;
        if ($resultsPageNum > $maxResultsPageNum) {
            $this->notices[] = sprintf("We're sorry, we do not serve more than %s results for any query. (You asked for results starting from %s.)", self::MAX_RESULTS, $this->start);
        }
        $this->resultsPageNum = $resultsPageNum;
        $this->lastResultsPageNum = ceil($resultsShown / $resultsPerPage);
        
        $this->xml = $xml;
    }
    
    /**
     * Return a version of the user's query that is
     * safe for display in a web page
     * @returns string
     */
    public function getDisplayQuery() {
        return $this->displayQuery;
    }
    
    /**
     * Return the data for the next search result as an
     * associative arrary with these keys:
            'title'             => Page Title
            'path'              => Full URL path to the page
            'localPath'         => Local part of the URL
            'localURL'          => Local part of the URL including the query part
            'description'       => Page description with query keywords <strong>highlighted</strong>
            'sizeHumanReadable' => eg. "64k"
        );
     * Returns false if there are no more results
     * @returns array|false
     */
    public function getNextResult() {
        if ($this->resultsCounter > ($this->lastResultNum - $this->firstResultNum)) {
            return false;
        }
        $result = $this->xml->RES->R[$this->resultsCounter];
        $this->resultsCounter++;
        
        $path = (string) $result->U;
        // Get just the path part of the URL
        $urlParts = parse_url($path);
        $localPath = $urlParts['path'];
        $localPathAndQuery = $localPath;
        if (array_key_exists('query', $urlParts) && $urlParts['query']) {
            $localPathAndQuery .= '?' . $urlParts['query'];
        }
        $title = $result->T;
        if (!$title) {
            $title = "[no title]";
        }
        $description = (string) $result->S;
        $description = str_replace('<br>', '<br />', $description);
        $size = $result->HAS->C['SZ'];
        if ($result['MIME']) {
            $mimeType = $result['MIME'];
        } else {
            $mimeType = 'text/html';
        }
        $path = htmlspecialchars($path);
        $localPathAndQuery = htmlspecialchars($localPathAndQuery);
        
        return array(
            'title'             => $title,
            'path'              => $path,
            'localPath'         => $localPath,
            'localURL'          => $localPathAndQuery,
            'description'       => $description,
            'sizeHumanReadable' => $size,
            'mimeType'          => $mimeType
        );
    }
    
    
    
    public function getSponsoredResult() {
        
        if (empty($this->xml->GM)) {
            return false;
        }
        $sponsored_result = $this->xml->GM;        
        $sponsored_url = (string) $sponsored_result->GL;
	    $sponsored_title = (string) $sponsored_result->GD;
        return array(
            'sponsored_title'             => $sponsored_title,
            'sponsored_url'             => $sponsored_url,
        );
    }    
    public function getNumHits() {
        return $this->hits;
    }
    
    /**
     * @returns integer the number of the first result
     */
    public function getFirstResultNum() {
        return $this->firstResultNum;
    }
    
    /**
     * @returns integer the number of the last result
     */
    public function getLastResultNum() {
        return $this->lastResultNum;
    }
    
    /**
     * @returns array list of notices to the user about the results
     */
    public function getNotices() {
        return $this->notices;
    }
	
    /**
     * @param string $text text to display as linked
     * @returns string a link to the next page of search results
     */
    public function getNextLink($text = 'next') {
        if ($this->resultsPageNum == $this->lastResultsPageNum) {
            return $text;
        } else {
        	$site_path = site_url('/search?q=');
            $url = $site_path . $this->query . "&resultsPageNum=" . ($this->resultsPageNum + 1);
            return "<a href=\"$url\">$text</a>";
        }
    }
    
    /**
     * Returns an array of links to all the resultset pages with
     * the current page as plain text
     * @param string $text text to display as linked
     * @returns array
     */
    public function getResultsetLinks() {
        $links = array();
        $site_path = site_url('/search?q=');
        for ($resultsPageNum = 1; $resultsPageNum <= $this->lastResultsPageNum; $resultsPageNum++) {
            if ($resultsPageNum == $this->resultsPageNum) {
                $links[] = "<a class=\"current\">$resultsPageNum</a>";
            } else {
                $url = $site_path . $this->query . "&resultsPageNum=" . ($resultsPageNum);
                $links[] = "<a href=\"$url\">$resultsPageNum</a>";
            }
        }
        return $links;
    }
}

?>