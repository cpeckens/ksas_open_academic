<?php get_header(); ?>
<div class="row sidebar_bg radius10" id="page">
	<div class="nine columns wrapper radius-left offset-topgutter push-three">	
		<?php locate_template('parts-nav-breadcrumbs.php', true, false); ?>	
		<section class="content news">
			<?php if (in_category('books')) {
					locate_template('single-category-books.php', true, false);
			} else { ?>
			<h6><?php the_date(); ?></h6>
			<h5><?php the_title(); ?></h5>
			<?php the_content(); } ?>
		</section>
	</div>	<!-- End main content (left) section -->
<?php locate_template('parts-sidebar-nav.php', true, false); ?>
</div> <!-- End #landing -->
<?php get_footer(); ?>