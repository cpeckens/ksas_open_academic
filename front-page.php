<?php get_header(); locate_template('parts-slider.php', true);?>
<div class="row homepage_bg">
	<div class="eight columns wrapper toplayer content">		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<section>
				<?php the_content(); ?>			
			</section>
		<?php endwhile; endif; ?>	
		
		<?php 
			$theme_option = flagship_sub_get_global_options();
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