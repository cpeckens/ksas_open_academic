<?php get_header(); ?>
<?php
	$theme_option = flagship_sub_get_global_options(); 
	if ( false === ( $slider_query = get_transient( 'slider_query' ) ) ) {
		$slider_query = new WP_Query(array(
			'post_type' => 'slider',
			'posts_per_page' => '5'));
		set_transient( 'slider_query', $slider_query, 2592000 );
	} 	
	if ( $slider_query->have_posts() ) :
?>
<div class="row hide-for-mobile">
<div id="slider" class="twelve columns radius10 no-gutter">

<?php while ($slider_query->have_posts()) : $slider_query->the_post(); ?>
<a href="<?php echo get_post_meta($post->ID, 'ecpt_urldestination', true); ?>">
<div class="slide">
	<?php if($theme_option['flagship_sub_slider_style'] == "vertical") { 
		 	locate_template('parts-vertical-slider.php', true, false); 	
		 	}
	 elseif($theme_option['flagship_sub_slider_style'] == "horizontal") { 
	 		locate_template('parts-horizontal-slider.php', true, false); 
	  } ?>
	<img src="<?php echo get_post_meta($post->ID, 'ecpt_slideimage', true); ?>" class="radius-top" />
</div>
</a>
<?php endwhile; ?>
				
					
</div>
</div>

<?php endif; ?>

<div class="row homepage_bg <?php if($theme_option['flagship_sub_slider_style'] == "vertical") { ?>offset-top <?php } ?>">
	<div class="eight columns wrapper <?php if($theme_option['flagship_sub_slider_style'] == "vertical") { ?>offset-top <?php } ?>toplayer">		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<section>
				<?php the_content(); ?>			
			</section>
		<?php endwhile; endif; ?>	
		
		<?php 
			$news_quantity = $theme_option['flagship_sub_news_quantity'];
			if ( false === ( $news_query = get_transient( 'news_query' ) ) ) {
				// It wasn't there, so regenerate the data and save the transient
				$news_query = new WP_Query(array(
					'post_type' => 'post',
					'posts_per_page' => $news_quantity)); 
					set_transient( 'news_query', $news_query, 2592000 );
			} 	
			if ( $news_query->have_posts() ) :
		?>
		<h4><?php echo $theme_option['flagship_sub_feed_name']; ?></h4>
		<?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
		<div class="row">		
		<section class="twelve columns">
				<a href="<?php the_permalink(); ?>">
					<h6><?php the_date(); ?></h6>
					<h5 class="black"><?php the_title();?></h5>
					<?php if ( has_post_thumbnail()) { ?> 
						<?php the_post_thumbnail('thumbnail', array('class'	=> "floatleft")); ?>
					<?php } ?>
					<?php the_excerpt(); ?>
				</a>
				<hr>
		</section>
		</div>
		
		<?php endwhile; ?>
		<div class="row">
		<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"><h5 class="black">View <?php echo $theme_option['flagship_sub_feed_name']; ?> Archive</h5></a>
		</div>
		<?php endif; ?>
		
	
		
	</div>	<!-- End main content (left) section -->
<?php locate_template('parts-homepage-sidebar.php', true, false); ?>	
</div> <!-- End #landing -->
<?php get_footer(); ?>