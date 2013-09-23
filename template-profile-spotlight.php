<?php
/*
Template Name: Profiles - Spotlights
*/
?>

<?php get_header(); ?>
<div class="row sidebar_bg radius10" id="page">
	<div class="nine columns wrapper radius-left offset-topgutter push-three">	
		<?php locate_template('parts-nav-breadcrumbs.php', true, false); ?>	
		<section class="content">
 			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?> <!--Start the loop -->
				<h2><?php the_title(); ?>&nbsp;</h2>
				<?php the_content() ?>
			<?php endwhile; endif ?>
			
			<?php 
			// Get any existing copy of our transient data
			if ( false === ( $ksas_profile_spotlight_query = get_transient( 'ksas_profile_spotlight_query' ) ) ) {
			// It wasn't there, so regenerate the data and save the transient
				$ksas_profile_spotlight_query = new WP_Query(array(
					'post-type' => 'profile',
					'profiletype' =>'spotlight',
					'posts_per_page' => 10));
				set_transient( 'ksas_profile_spotlight_query', $ksas_profile_spotlight_query, 86400 );
			} 
			?>
		<?php if($ksas_profile_spotlight_query->have_posts()) : while ($ksas_profile_spotlight_query->have_posts()) : $ksas_profile_spotlight_query->the_post(); ?>
					<a href="<?php the_permalink(); ?>">	
				<h5><?php the_title();?></h5>
					<?php if ( has_post_thumbnail()) { ?> 
						<?php the_post_thumbnail('thumbnail', array('class'	=> "floatleft")); ?>
					<?php } ?>
					<?php if (get_post_meta($post->ID, 'ecpt_pull_quote', true)){ ?><blockquote><?php echo get_post_meta($post->ID, 'ecpt_pull_quote', true); ?></blockquote><?php }?>
				<?php the_excerpt(); ?>			</a>
				<hr>
			<?php endwhile; endif;?>
		<div class="row">
			<?php flagship_pagination($ksas_profile_spotlight_query->max_num_pages); ?>		
		</div>	
		</section>
	</div>	<!-- End main content (left) section -->
<?php locate_template('parts-sidebar-nav.php', true, false); ?>
</div> <!-- End #landing -->
<?php get_footer(); ?>