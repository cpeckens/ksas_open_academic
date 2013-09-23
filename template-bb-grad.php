<?php
/*
Template Name: Bulletin Board - Graduate
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
			if ( false === ( $ksas_bb_grad_query = get_transient( 'ksas_bb_grad_query' ) ) ) {
			// It wasn't there, so regenerate the data and save the transient
				$ksas_bb_grad_query = new WP_Query(array(
					'post-type' => 'bulletinboard',
					'bbtype' =>'graduate-bb',						
					'posts_per_page' => 10));
				set_transient( 'ksas_bb_grad_query', $ksas_bb_grad_query, 86400 );
			} 
			?>
		<?php if($ksas_bb_grad_query->have_posts()) : while ($ksas_bb_grad_query->have_posts()) : $ksas_bb_grad_query->the_post(); ?>
					<a href="<?php the_permalink(); ?>">	
				<h6><?php the_date(); ?></h6>
				<h5><?php the_title();?></h5>
					<?php if ( has_post_thumbnail()) { ?> 
						<?php the_post_thumbnail('thumbnail', array('class'	=> "floatleft")); ?>
					<?php } ?>
				<?php the_excerpt(); ?>
			</a>
				<hr>
			<?php endwhile; endif;?>
		<div class="row">
			<?php flagship_pagination($ksas_bb_grad_query->max_num_pages); ?>		
		</div>	
		</section>
	</div>	<!-- End main content (left) section -->
<?php locate_template('parts-sidebar-nav.php', true, false); ?>
</div> <!-- End #landing -->
<?php get_footer(); ?>