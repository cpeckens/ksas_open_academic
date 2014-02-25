<?php get_header(); ?>
<div class="row sidebar_bg radius10" id="page">
	<div class="nine columns wrapper radius-left offset-topgutter push-three">	
		<section class="content">
			<?php 
				if (has_term('', 'role') && !has_term('job-market-candidate', 'role')) {
					get_template_part('parts', 'faculty'); } else {
					get_template_part('parts', 'jobmarket'); } 
			 ?>	
		</section>
	</div>	<!-- End main content (left) section -->
<?php locate_template('parts-sidebar-nav.php', true, false); ?>
</div> <!-- End #landing -->
<?php get_footer(); ?>