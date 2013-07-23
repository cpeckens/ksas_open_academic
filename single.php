<?php get_header(); ?>
<div class="row wrapper radius10" id="page" role="main">
	<div class="twelve columns radius-left offset-topgutter">	
		<?php locate_template('parts-nav-breadcrumbs.php', true, false); ?>	
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<section class="content news">
			<?php if (in_category('books')) {
					locate_template('single-category-books.php', true, false);
			} else { ?>
			<h6><?php the_date(); ?>
			<h5><?php the_title(); ?></h5>
			<?php if ( has_post_thumbnail()) { ?> 
				<?php the_post_thumbnail('full', array('class'	=> "floatleft")); ?>
			<?php } ?>
			<?php the_content(); }?>
		</section>
		<?php endwhile; endif; ?>
	</div>	<!-- End main content (left) section -->
</div> <!-- End #page -->
<?php get_footer(); ?>