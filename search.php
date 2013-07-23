<?php
/*
Template Name: Search Results
*/
?>
<?php
require_once TEMPLATEPATH . "/assets/functions/GoogleSearch.php";
get_header(); 
$theme_option = flagship_sub_get_global_options(); 
$collection_name = $theme_option['flagship_sub_search_collection'];
?>

<div class="row wrapper radius10">
	<div class="twelve columns">
		<h2>Search Results</h2>
		<section>

<?php 
try {
    $search = new KSAS_GoogleSearch();
    $resultsPageNum = 1;
    if (array_key_exists('resultsPageNum', $_REQUEST)) {
        $resultsPageNum = $_REQUEST['resultsPageNum'];
    }
    $resultsPerPage = 10;
    $baseQueryURL = 'http://search.johnshopkins.edu/search?&client=ksas_frontend';
    $results = $search->query($_REQUEST['q'], $_REQUEST['site'], $baseQueryURL, $resultsPageNum, $resultsPerPage);
    $hits = $results->getNumHits();
    $displayQuery = $results->getDisplayQuery();
    $docTitle = 'Search Results';
    $sponsored_result = $results->getSponsoredResult();
    ?>

    <?php
    if ($hits > 0) {
        ?>
       <form class="search-form" action="<?php echo site_url('/search'); ?>" method="get">
                    <fieldset>
                        <input type="text" class="input-text" name="q" value="<?php echo $displayQuery ?>" />
                        <label>Search:</label>
                        <input type="radio" name="site" value="<?php echo $collection_name; ?>" checked>This site only
                        <input type="radio" name="site" value="krieger_collection">All of JHU
                        <input type="submit" class="button blue_bg" value="Search Again" />
                    </fieldset>
       </form>        
       <h6>Results <span class="black"><?php echo $results->getFirstResultNum() ?> - <?php echo $results->getLastResultNum() ?></span> of about <span class="black"><?php echo $hits ?></span></h6>
           
        <?php if (empty($sponsored_result) == false) { ?>
	        <div class="panel callout radius10" id="sponsored">
	        	<h6 class="black">Sponsored Result</h6>
	        	<a href="<?php echo $sponsored_result['sponsored_url']; ?>"><h3><?php echo $sponsored_result['sponsored_title']; ?><small class="italic">-- <?php echo $sponsored_result['sponsored_url']; ?></small></h3></a>
	        </div>
         <?php } ?>   
            <div id="search-results">
                <ul>
           
        <?php
        while ($result = $results->getNextResult()) {
            // note what results are PDFs
            $pdfNote = '';
            if (preg_match('{application/pdf}', $result['mimeType'])) {
                $pdfNote = '<span class="black">[PDF]</span> ';
            }
            ?>
                    <li>
                        <h5><?php echo $pdfNote ?><a href="<?php echo $result['path'] ?>"><?php echo $result['title'] ?></a></h5>
            <?php
            if (array_key_exists('description', $result) && $result['description']) {
                ?>
                        <p><?php echo $result['description'] ?></p>
                <?php
            }
            ?>
                        <div class="url"><?php echo $result['path'] ?> - <?php echo $result['sizeHumanReadable'] ?></div>
                    </li>
                    <hr>
            <?php
        }
        ?>
                </ul>
            </div>
             
            <div class="section">
        <?php
            $notices = $results->getNotices();
            foreach ($notices as $notice) {
                ?>
                <p class="notice"><?php echo $notice ?></p>
                <?php
            }
        ?>
                <div class="pagination">
                     
        <?php
        foreach ($results->getResultsetLinks() as $resultsetLink) {
            print "$resultsetLink ";
        }
        ?>
                    <?php echo $results->getNextLink() ?> 
                </div>
                 
            </div>
        <?php
    } else {
        // no hits
        ?>
            </div>
             
        <?php
            $notices = $results->getNotices();
            foreach ($notices as $notice) {
                ?>
            <p class="notice"><?php echo $notice ?></p>
                <?php
            }
        ?>
             
            <p style="font-weight: bold;">There are no pages matching your search.</p>
       <form class="search-form" action="<?php echo site_url('/search'); ?>" method="get">
                    <fieldset>
                        <input type="text" class="input-text" name="q" value="<?php echo $displayQuery ?>" />
                        <label class="inline bold">Search:</label>
                        <input type="radio" name="site" value="<?php echo $collection_name; ?>" checked>This site only
                        <input type="radio" name="site" value="krieger_collection">All JHU websites
                        <input type="submit" class="button blue_bg" value="Search Again" />
                    </fieldset>
       </form>        

        <?php
    }
} catch (KSAS_GoogleSearchException $e) {
    $docTitle = "Search Temporarily Unavailable";
    ?>
    <div class="section">
        <p>We're sorry, the search engine is temporarily unavailable. Please try your search again later.</p>
    </div>
    <?php
} ?>
		</section>
	</div>
</div>

<?php get_footer(); ?>  