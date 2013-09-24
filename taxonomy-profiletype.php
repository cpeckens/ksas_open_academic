<?php get_header(); ?>
<div class="row sidebar_bg radius10" id="page">
	<div class="nine columns wrapper radius-left offset-topgutter push-three">	
		<section class="content">
		<?php if(is_tax('profiletype', 'spotlight')){ ?>
		<h2>Spotlights</h2>
		<?php } elseif(is_tax('profiletype', 'undergraduate-profile')){ ?>
		<h2>Undergraduate Profiles</h2>
		<?php } elseif(is_tax('profiletype', 'graduate-profile')){ ?>
		<h2>Graduate Profiles</h2>
		<?php } ?>
		<?php while ( have_posts()) : the_post(); ?>
			<a href="<?php the_permalink(); ?>">	
				
				<h5><?php the_title();?></h5>
					<?php if ( has_post_thumbnail()) { ?> 
						<?php the_post_thumbnail('thumbnail', array('class'	=> "floatleft")); ?>
					<?php } ?>
					<?php if (get_post_meta($post->ID, 'ecpt_pull_quote', true)){ ?><blockquote><?php echo get_post_meta($post->ID, 'ecpt_pull_quote', true); ?></blockquote><?php }?>
				<?php the_excerpt(); ?>
			</a>
				<hr>
			<?php endwhile; ?>
		<div class="row">
			<?php flagship_pagination(); ?>		
		</div>	
		</section>
	</div>	<!-- End main content (left) section -->
<?php locate_template('parts-sidebar-nav.php', true, false); ?>
</div> <!-- End #landing -->
<?php get_footer(); ?>