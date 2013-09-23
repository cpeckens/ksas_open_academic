<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="row">
			<div class="four columns">
				<?php if ( has_post_thumbnail()) { ?> 
						<?php the_post_thumbnail('full'); ?>
					<?php } ?>			    
					
			    <h6><?php echo get_post_meta($post->ID, 'ecpt_position', true); ?></h6>
			
			    <p class="listing">
			    	<?php if ( get_post_meta($post->ID, 'ecpt_office', true) ) : ?>
			    		<span class="icon-location"></span><?php echo get_post_meta($post->ID, 'ecpt_office', true); ?><br>
			    	<?php endif; ?>
			    
			    	<?php if ( get_post_meta($post->ID, 'ecpt_hours', true) ) : ?>
			    		<span class="icon-calendar-2"></span><?php echo get_post_meta($post->ID, 'ecpt_hours', true); ?><br>
			    	<?php endif; ?>
			    
			    	<?php if ( get_post_meta($post->ID, 'ecpt_phone', true) ) : ?>
			    		<span class="icon-mobile"></span><?php echo get_post_meta($post->ID, 'ecpt_phone', true); ?><br>
			    	<?php endif; ?>
			    
			    	<?php if ( get_post_meta($post->ID, 'ecpt_fax', true) ) : ?>
			    		<span class="icon-printer"></span><?php echo get_post_meta($post->ID, 'ecpt_fax', true); ?><br>
			    	<?php endif; ?>
			    
			    	<?php if ( get_post_meta($post->ID, 'ecpt_email', true) ) : $email = get_post_meta($post->ID, 'ecpt_email', true); ?>
											<span class="icon-mail"></span><a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;<?php echo email_munge($email); ?>">
											
											<?php echo email_munge($email); ?> </a><br>
										<?php endif; ?>
			    	
			    	<?php if ( get_post_meta($post->ID, 'ecpt_cv', true) ) : ?>
			    		<a href="<?php echo get_post_meta($post->ID, 'ecpt_cv', true); ?>"><span class="icon-file-pdf"></span>Curriculum Vitae</a><br>
			    	<?php endif; ?>
			    
			    	<?php if ( get_post_meta($post->ID, 'ecpt_website', true) ) : ?>
			    		<a href="<?php echo get_post_meta($post->ID, 'ecpt_website', true); ?>" target="_blank"><span class="icon-globe"></span>Personal Website</a><br>
			    	<?php endif; ?>
			    	<?php if ( get_post_meta($post->ID, 'ecpt_lab_website', true) ) : ?>
			    		<a href="<?php echo get_post_meta($post->ID, 'ecpt_lab_website', true); ?>" target="_blank"><span class="icon-globe"></span>Group Website</a>
			    	<?php endif; ?>
			    </p>
			</div>
			<div class="eight columns">
				<h2><?php the_title() ?></h2>	
								  <p><?php if ( get_post_meta($post->ID, 'ecpt_thesis', true) ) : ?><strong>Thesis Title:</strong>&nbsp;"<?php echo get_post_meta($post->ID, 'ecpt_thesis', true); ?>"<?php endif; ?>
								  <?php if ( get_post_meta($post->ID, 'ecpt_job_abstract', true) ) : ?>&nbsp;- <a href="<?php echo get_post_meta($post->ID, 'ecpt_job_abstract', true); ?>">Download Abstract</a> (PDF)<?php endif; ?></p>
								  <?php if (get_post_meta($post->ID, 'ecpt_fields', true)) : ?><p><strong>Fields:</strong>&nbsp;<?php echo get_post_meta($post->ID, 'ecpt_fields', true); ?></p><?php endif; ?>
								  <?php if (get_post_meta($post->ID, 'ecpt_fields', true)) : ?><p><strong>Main Advisor:</strong>&nbsp;<?php echo get_post_meta($post->ID, 'ecpt_advisor', true); ?></p><?php endif; ?>
								  <?php echo get_post_meta($post->ID, 'ecpt_job_research', true); ?>
			</div>
			</div>
			<?php endwhile; endif; ?>