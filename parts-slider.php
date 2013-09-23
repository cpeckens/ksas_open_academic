<?php
	if ( false === ( $slider_query = get_transient( 'slider_query' ) ) ) {
		$slider_query = new WP_Query(array(
			'post_type' => 'slider',
			'posts_per_page' => '5'));
		set_transient( 'slider_query', $slider_query, 2592000 );
	} 	
	if ( $slider_query->have_posts() ) :
?>
<div class="blueslide hide-for-mobile">
<div class="row">
<div id="slider" class="no-gutter">
<?php endif; ?>
<?php if ( $slider_query->have_posts() ) : while ($slider_query->have_posts()) : $slider_query->the_post(); ?>
<a href="<?php echo get_post_meta($post->ID, 'ecpt_urldestination', true); ?>">
<div class="slide">
	<summary class="four columns push-eight vertical <?php echo get_post_meta($post->ID, 'ecpt_slidecolor', true); ?> no-gutter" id="caption">
			<div class="middle">
				<h3 class="white"><?php the_title(); ?></h3>
				<h5 class="white"><?php echo get_the_content(); ?></h5>
			   	<?php if ( get_post_meta($post->ID, 'ecpt_button', true) ) : ?>				
					<div class="button <?php echo get_post_meta($post->ID, 'ecpt_slidecolor', true); ?>"><span class="uppercase">Find Out More</span></div>
				<?php endif;?>
			</div>
	</summary>	
	<img src="<?php echo get_post_meta($post->ID, 'ecpt_slideimage', true); ?>" class="eight columns pull-four no-gutter" />
</div>
</a>
<?php endwhile; ?>
				
					
</div>
</div>
</div>
<div class="slider-break"></div>
<?php endif; ?>

