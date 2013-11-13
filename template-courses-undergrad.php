<?php
/*
Template Name: Courses - Undergraduate
*/
?>

<?php get_header(); ?>
<div class="row sidebar_bg radius10" id="page">
	<div class="nine columns wrapper radius-left offset-topgutter push-three">	
		<?php locate_template('parts-nav-breadcrumbs.php', true, false); ?>	
		<section class="content">
 			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?> <!--Start the loop -->
				<h2><?php the_title(); ?>&nbsp;<a class="acc_expandall">[Expand All]</a></h2>
				<?php the_content() ?>
			<?php endwhile; endif ?>
			
			<?php 
			// Get any existing copy of our transient data
			if ( false === ( $ksas_course_undergrad_query = get_transient( 'ksas_course_undergrad_query' ) ) ) {
			// It wasn't there, so regenerate the data and save the transient
				$ksas_course_undergrad_query = new WP_Query(array(
					'post-type' => 'course',
					'coursetype' => 'undergraduate-course',
					'orderby' => 'title',
					'order' => 'ASC', 
					'posts_per_page' => -1));
				set_transient( 'ksas_course_undergrad_query', $ksas_course_undergrad_query, 86400 );
			} 
			?>
		<?php if($ksas_course_undergrad_query->have_posts()) : ?>
			<ul class="accordion">
		<?php while ($ksas_course_undergrad_query->have_posts()) : $ksas_course_undergrad_query->the_post(); ?>
		<li>
			<div class="title">
				<h5><?php the_title(); ?>
				<?php if ( get_post_meta($post->ID, 'ecpt_credit', true) ) : ?>
					&nbsp;(<?php echo get_post_meta($post->ID, 'ecpt_credit', true); ?> credits)
				<?php endif; ?></h5>
			</div>
			<div class="content course">
				<?php the_content()?>
				<?php if ( get_post_meta($post->ID, 'ecpt_prereqs', true) ) : ?>
					<p><b>Prerequisites:</b> 
					<?php echo get_post_meta($post->ID, 'ecpt_prereqs', true); ?></p>
				<?php endif; ?>
				<p>
				<?php if ( get_post_meta($post->ID, 'ecpt_instructor', true) ) : ?>
					<b>Instructor:</b> 
					<?php echo get_post_meta($post->ID, 'ecpt_instructor', true); ?><br>
				<?php endif; ?>
				
				<?php if ( get_post_meta($post->ID, 'ecpt_course_times', true) ) : ?>
					<b>Course Times:</b> 
					<?php echo get_post_meta($post->ID, 'ecpt_course_times', true); ?><br>
				<?php endif; ?>
				
				<?php if ( get_post_meta($post->ID, 'ecpt_course_limit', true) ) : ?>
					<b>Course Limit:</b> 
					<?php echo get_post_meta($post->ID, 'ecpt_course_limit', true); ?><br>
				<?php endif; ?>
				
				<?php if ( get_post_meta($post->ID, 'ecpt_course_website', true) ) : ?>
					<a href="<?php echo get_post_meta($post->ID, 'ecpt_course_website', true); ?>" target="_blank">View course website/syllabus</a>
				<?php endif; ?>
				</p>
			</div>
		</li>
		
		<?php endwhile; ?>
			</ul>
		<?php endif; ?>
		</section>
	</div>	<!-- End main content (left) section -->
<?php locate_template('parts-sidebar-nav.php', true, false); ?>
</div> <!-- End #landing -->
<?php get_footer(); ?>