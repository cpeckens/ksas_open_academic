	<aside class="four columns hide-for-print sidebar-right" id="sidebar"> <!-- Begin Sidebar -->
		<!-- Page Specific Sidebar -->
		<?php if ( have_posts() && get_post_meta($post->ID, 'ecpt_page_sidebar', true) ) : while ( have_posts() ) : the_post(); 
				echo apply_filters('the_content', get_post_meta($post->ID, 'ecpt_page_sidebar', true));
			endwhile; endif; ?>
		<!-- END Page Specific Sidebar -->
		
		<!-- Start Widget Content -->
			<?php
			if ( is_front_page() ) {    
				dynamic_sidebar( 'homepage-sb' );
							
			} elseif ( have_posts() && get_post_meta($post->ID, 'ecpt_page_sidebar', true) ) {
			
			} elseif ( is_page( 'graduate' ) || $ancestor_slug == 'graduate' ) {    
				dynamic_sidebar( 'graduate-sb' );
			
			} elseif ( is_page( 'research' ) || $ancestor_slug == 'research' ) {    
				dynamic_sidebar( 'research-sb' );
			
			} elseif ( is_page( 'undergraduate' ) || $ancestor_slug == 'undergraduate' ) {    
				dynamic_sidebar( 'undergrad-sb' ); 
			
			} else { 
				dynamic_sidebar( 'page-sb' );
			}	
			
			wp_reset_query();
			?>
	</aside>