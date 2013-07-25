<?php
/*
Template Name: Mini Homepage
*/
?>	

<?php get_header(); ?>
	<div class="row sidebar_bg radius10 two_side">
		<div class="nine columns wrapper push-three content">

			<!---Page Content---->
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php if (has_post_thumbnail()) { ?> 
					<div class="row">
						<div class="twelve columns">
							<?php the_post_thumbnail('full'); ?>
						</div>
					</div>
				<?php } ?>
			<div class="row">
			<section class="eight columns">
				<h2><?php the_title();?></h2>
				<?php the_content(); ?>
			<?php endwhile; endif; ?>			
			</section>
			<?php locate_template('parts-second-sidebar.php', true, false); ?>
			</div>
	</div>	<!-- End main content (left) section -->
			<?php locate_template('parts-sidebar-nav.php', true, false); ?>

</div> <!-- End #landing -->
<?php get_footer(); ?>