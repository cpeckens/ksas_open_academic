<summary class="twelve columns horizontal black_bg" id="caption">
			<h3 class="white no-margin"><?php the_title(); ?></h3>
			<h5 class="white italic floatleft no-margin"><?php echo get_the_content(); ?></h5>
		   	<?php if ( get_post_meta($post->ID, 'ecpt_button', true) ) : ?>				
				<h6 class="yellow floatleft no-margin">Find Out More <span class="icon-arrow-right-2"></span></h6>
			<?php endif;?>
</summary>
