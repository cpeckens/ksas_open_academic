
					<?php if ( has_post_thumbnail()) { ?> 
						<?php the_post_thumbnail('medium', array('class'	=> "floatleft")); ?>
					<?php } ?>
					<?php $faculty_post_id = get_post_meta($post->ID, 'ecpt_pub_author', true); ?>
				<?php if ( get_post_meta($post->ID, 'ecpt_pub_link', true) ) :?>
					<a href="http://<?php echo get_post_meta($post->ID, 'ecpt_pub_link', true); ?>">
				<?php endif; ?>
						<h5><?php the_title();?></h5>
				<?php if ( get_post_meta($post->ID, 'ecpt_pub_link', true) ) :?></a><?php endif; ?>
				<h6>
					<?php if ( get_post_meta($post->ID, 'ecpt_pub_date', true) ) : echo get_post_meta($post->ID, 'ecpt_pub_date', true);  endif; ?>
					<?php if ( get_post_meta($post->ID, 'ecpt_publisher', true) ) :?>, <?php echo get_post_meta($post->ID, 'ecpt_publisher', true);  endif; ?>
				</h6>
				<p><b><a href="<?php echo get_permalink($faculty_post_id); ?>"><?php echo get_the_title($faculty_post_id); ?> 
				<?php if ( get_post_meta($post->ID, 'ecpt_pub_role', true)) :?>, <?php echo get_post_meta($post->ID, 'ecpt_pub_role', true); endif; ?>
				</a></b></p>
				<?php the_content(); ?>		