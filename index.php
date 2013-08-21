<?php get_header(); ?>
<div class="row sidebar_bg radius10" id="page">
	<div class="nine columns wrapper radius-left offset-topgutter push-three">	
		<?php locate_template('parts-nav-breadcrumbs.php', true, false); 
		$theme_option = flagship_sub_get_global_options(); ?>	
		<section class="content">
		<h2><?php echo $theme_option['flagship_sub_feed_name']; ?> Archive</h2>
		<?php 
			$paged = (get_query_var('paged')) ? (int) get_query_var('paged') : 1;
			if ( false === ( $news_archive_query = get_transient( 'news_archive_query_' . $paged ) ) ) {
				// It wasn't there, so regenerate the data and save the transient
				$news_archive_query = new WP_Query(array(
					'post_type' => 'post',
					'posts_per_page' => 10,
					'paged' => $paged
					)); 
					set_transient( 'news_archive_query_' . $paged, $news_archive_query, 2592000 );
			} 	

		while ($news_archive_query->have_posts()) : $news_archive_query->the_post(); ?>
			<a href="<?php the_permalink(); ?>">	
				<h6><?php the_date(); ?></h6>
				<h5><?php the_title();?></h5>
					<?php if ( has_post_thumbnail()) { ?> 
						<?php the_post_thumbnail('thumbnail', array('class'	=> "floatleft")); ?>
					<?php } ?>
				<?php the_excerpt(); ?>
			</a>
				<hr>
			<?php endwhile; ?>
		<div class="row">
			<?php flagship_pagination($news_archive_query->max_num_pages); ?>		
		</div>	
		</section>
	</div>	<!-- End main content (left) section -->
<?php locate_template('parts-sidebar-nav.php', true, false); ?>
</div> <!-- End #landing -->
<?php get_footer(); ?>