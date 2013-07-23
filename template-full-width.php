<?php
/*
Template Name: Full Width - No Sidebar
*/
?>
<?php get_header(); ?>
<div class="row wrapper radius10" id="page" role="main">
	<div class="twelve columns">	
		<?php locate_template('parts-nav-breadcrumbs.php', true, false); ?>	
		<section class="content">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<h2><?php the_title();?></h2>
					<?php if ( has_post_thumbnail()) { ?> 
						<div class="photo-page-left floatleft seven columns">
							<?php the_post_thumbnail('full',array('class'	=> "radius-topleft")); ?>
						</div>
					<?php } ?>
				<?php the_content(); ?>
			<?php endwhile; endif; ?>	
		</section>
	</div>
</div> 
<?php get_footer(); ?>