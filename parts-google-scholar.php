<?php require_once('assets/functions/simple_html_dom.php');
$google_id = get_post_meta($post->ID, 'ecpt_google_id', true);
$google = new simple_html_dom;
$google_url = 'http://scholar.google.com/citations?sortby=pubdate&user=' . $google_id . '&pagesize=100';
$older_pubs = 'http://scholar.google.com/citations?hl=en&user=' . $google_id . '&pagesize=100&sortby=pubdate&view_op=list_works&cstart=100';
$google = file_get_html($google_url);

foreach($google->find('tr.item') as $article) {
    $item['title']  = $article->find('td#col-title a', 0)->plaintext;
    $item['link']	= $article->find('td#col-title a', 0)->href;
    $item['pub']	= $article->find('td#col-title span.cit-gray', 1)->plaintext;
    $item['year']   = $article->find('td#col-year', 0)->plaintext;
    
    ?>
    <p class="pub"><b><a href="http://scholar.google.com<?php echo $item['link'];?>"><?php echo $item['title']; ?></a></b></p>
    <h6 class="pub"><?php echo $item['year']; ?>, <?php echo $item['pub']; ?></h6>
    
    
    <?php } ?>
<p align="right"><b><a href="<?php echo $older_pubs; ?>">View Older Publications</a></b></p>