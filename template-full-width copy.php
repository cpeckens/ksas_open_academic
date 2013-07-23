<?php
/*
Template Name: Tester*/
?>
<?php get_header(); ?>
<div class="row wrapper radius10" id="page" role="main">
	<div class="twelve columns">	
		<?php locate_template('parts-nav-breadcrumbs.php', true, false); ?>	
		<section class="content">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<h2><?php the_title();?></h2>

<?php require_once('assets/functions/simple_html_dom.php');
$google = new simple_html_dom;
$google_url = 'http://scholar.google.com/citations?user=yFNrqd8AAAAJ';
$google = file_get_html($google_url);

foreach($google->find('tr.item') as $article) {
    $item['title']  = $article->find('td#col-title a', 0)->plaintext;
    $item['link']	= $article->find('td#col-title a', 0)->href;
    $item['pub']	= $article->find('td#col-title span.cit-gray', 1)->plaintext;
    $item['year']   = $article->find('td#col-year', 0)->plaintext;
    
    ?>
    <p class="pub"><b><a href="http://scholar.google.com<?php echo $item['link'];?>"><?php echo $item['title']; ?></a></b></p>
    <h6><?php echo $item['pub']; ?>, <?php echo $item['year']; ?></h6>
    
    
    <?php } ?>
			<?php endwhile; endif; ?>	
		</section>
	</div>
</div> 
<?php get_footer(); ?>