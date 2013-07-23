<?php
/*
Template Name: Mobile Calendar
*/
?>
<?php get_header(); ?>
<div class="row wrapper radius10" id="page" role="main">
	<div class="twelve columns">	
		<?php locate_template('parts-nav-breadcrumbs.php', true, false); ?>	
		<section class="content">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<h2><?php the_title();?></h2>
				<?php the_content(); ?>
			<?php endwhile; endif; ?>
			
			<!-- /************Calendar display**************/ -->	
				<div class="row" id="calendar_container"></div>

		</section>
	</div>
</div> 
<?php get_footer(); ?>