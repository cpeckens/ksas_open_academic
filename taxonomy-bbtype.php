<?php get_header(); ?>
<div class="row sidebar_bg radius10" id="page">
	<div class="nine columns wrapper radius-left offset-topgutter push-three">	
		<section class="content">
		<?php if(is_tax('bbtype', 'udergrad-bb')){ ?>
		<h2>Undergraduate Bulletin Board</h2>
		<?php } elseif(is_tax('bbtype', 'graduate-bb')){ ?>
		<h2>Graduate Bulletin Boad</h2>
		<?php } else { ?>
		<h2>Bulletin Board</h2>
		<?php } ?>
		<?php while ( have_posts()) : the_post(); ?>
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
			<?php flagship_pagination($wp_query->max_num_pages); ?>		
		</div>	
		</section>
	</div>	<!-- End main content (left) section -->
<?php locate_template('parts-sidebar-nav.php', true, false); ?>
</div> <!-- End #landing -->
<?php get_footer(); ?>