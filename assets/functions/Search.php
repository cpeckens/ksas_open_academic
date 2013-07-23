<?php
/**
 * Abstract base class for implementing searches.
 * Look in Search/ for concrete implementations.
 */

/**
 * Execute a search
 */
abstract class KSAS_Search {
    /**
     * @param string $query raw search query
     * @returns KSAS_Search_Results
     */
    abstract public function query($query, $collection_name, $baseQueryURL, $resultsPageNum = 1, $resultsPerPage = 10);
}

/**
 * Manage and retrieve search result data
 */
abstract class KSAS_SearchResults {
    /**
     * Return a version of the user's query that is
     * safe for display in a web page
     * @returns string
     */
    abstract public function getDisplayQuery();
    
    /**
     * Return the data for the next search result as an
     * associative arrary with these keys:
            'title'             => Page Title
            'path'              => Full URL path to the page
            'localPath'         => Local part of the URL
            'localURL'          => Local part of the URL including the query part
            'description'       => Page description with query keywords <span class="highlighted">highlighted</span>
            'sizeHumanReadable' => eg. "64k" or "This page is no longer available"
        );
     * Returns false if there are no more results
     * @returns array|false
     */
    abstract public function getNextResult();
    
    abstract public function getNumHits();
    
    /**
     * @returns integer the number of the first result
     */
    abstract public function getFirstResultNum();
    
    /**
     * @returns integer the number of the last result
     */
    abstract public function getLastResultNum();
    
    /**
     * @returns array list of notices to the user about the results
     */
    abstract public function getNotices();
    
    /**
     * @param string $text text to display as linked
     * @returns string a link to the next page of search results
     */
    public function getNextLink($text = 'next') {
        if ($this->resultsPageNum == $this->lastResultsPageNum) {
            return $text;
        } else {
            $url = $this->baseQueryURL . "resultsPageNum=" . ($this->resultsPageNum + 1);
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
        for ($resultsPageNum = 1; $resultsPageNum <= $this->lastResultsPageNum; $resultsPageNum++) {
            if ($resultsPageNum == $this->resultsPageNum) {
                $links[] = $resultsPageNum;
            } else {
                $url = $this->baseQueryURL . "resultsPageNum=" . ($resultsPageNum);
                $links[] = "<a href=\"$url\">$resultsPageNum</a>";
            }
        }
        return $links;
    }
}

/**
 * Paginate a set of search results
 */
class KSAS_SearchResultsPaginator {
    private $baseQueryURL = null;
    private $hits = null;
    private $lastResultsPageNum = null;
    private $results = null;
    private $resultsPageNum = null;
    private $resultsPerPage = null;
    
    /**
     * @param KSAS_Search_Results $results the resultset this will paginate
     * @param string $baseQueryURL the URL that returns the first page of results (w/o resultsPageNum=)
     * @param integer $resultsPageNum the page of results to display
     * @param integer $resultsPerPage the number of results to display on each page of results
     * @returns KSAS_Search_Results_Paginator
     */
    function __construct(KSAS_SearchResults $results, $baseQueryURL, $resultsPageNum = 1, $resultsPerPage = 10) {
        $this->results = $results;
        $this->hits = $results->getNumHits();
        if (strpos($baseQueryURL, '?')) {
            $this->baseQueryURL = $baseQueryURL . '&amp;';
        } else {
            $this->baseQueryURL = $baseQueryURL . '?';
        }
        // bring resultsPageNum in bounds
        if ($resultsPageNum < 1) {
            $resultsPageNum = 1;
        }
        $maxResultsPageNum = ($this->hits - ($this->hits % $resultsPerPage)) + $resultsPerPage;
        if ($maxResultsPageNum < $resultsPageNum * $resultsPerPage) {
            $resultsPageNum = $maxResultsPageNum;
        }
        $this->resultsPageNum = $resultsPageNum;
        $this->resultsPerPage = $resultsPerPage;
        $this->lastResultsPageNum = ceil($this->hits / $resultsPerPage);
    }
    
    /**
     * @returns integer the number of the first result on this page
     */
    function getFirstResultNum() {
        if ($this->hits == 0) {
            return 0;
        } else {
            return (($this->resultsPageNum - 1) * $this->resultsPerPage) + 1;
        }
    }
    
    /**
     * @returns integer the number of the last result on this page
     */
    function getLastResultNum() {
        $lastResultNum = $this->resultsPageNum * $this->resultsPerPage;
        if ($lastResultNum > $this->hits) {
            $lastResultNum = $this->hits;
        }
        return $lastResultNum;
    }
    
    /**
     * @param string $text text to display as linked
     * @returns string a link to the next page of search results
     */
    function getNextLink($text = 'next') {
        if ($this->resultsPageNum == $this->lastResultsPageNum) {
            return $text;
        } else {
            $url = $this->baseQueryURL . "resultsPageNum=" . ($this->resultsPageNum + 1);
            return "<a href=\"$url\">$text</a>";
        }
    }
    
    /**
     * Returns an array of links to all the resultset pages with
     * the current page as plain text
     * @param string $text text to display as linked
     * @returns array
     */
    function getResultsetLinks() {
        $links = array();
        for ($resultsPageNum = 1; $resultsPageNum <= $this->lastResultsPageNum; $resultsPageNum++) {
            if ($resultsPageNum == $this->resultsPageNum) {
                $links[] = $resultsPageNum;
            } else {
                $url = $this->baseQueryURL . "resultsPageNum=" . ($resultsPageNum);
                $links[] = "<a href=\"$url\">$resultsPageNum</a>";
            }
        }
        return $links;
    }
}
?>