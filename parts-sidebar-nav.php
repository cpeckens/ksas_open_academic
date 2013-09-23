	<nav class="three columns hide-for-print pull-nine" role="navigation" id="sidebar"> <!-- Begin Sidebar -->
		 	<!-- Start Navigation for Sibling Pages -->	
			<?php 
				wp_reset_query();
				if( is_page() || is_singular() || is_tax() ) { 
					global $post;
						$the_id = $post->ID;
				        $ancestors = get_post_ancestors( $post->ID ); // Get the array of ancestors
				        	//Get the top-level page slug for sidebar/widget content conditionals
							$ancestor_id = ($ancestors) ? $ancestors[count($ancestors)-1]: $post->ID;
					        $the_ancestor = get_page( $ancestor_id );
					        $ancestor_url = $the_ancestor->guid;
					        $ancestor_slug = $the_ancestor->post_name;
					        $ancestor_title = $the_ancestor->post_title;
				     //If there are no ancestors display a menu of children
							if (count($ancestors) >= 1) {	?>						
							<div class="offset-gutter" id="sidebar_header">
								<h5 class="grey">Also in <a href="<?php echo $ancestor_url;?>" class="black bold"><?php echo $ancestor_title ?></a></h5>
							</div>
							<?php
								wp_nav_menu( array( 
									'theme_location' => 'main_nav', 
									'menu_class' => 'nav', 
									'container_class' => 'offset-gutter',
									'submenu' => $ancestor_title,
									'depth' => 2				
								));
							}
							elseif (count($ancestors) == 0 && is_front_page() == false || is_singular() || is_page('news-archive') || is_tax('bbtype') || is_tax('profiletype'))  {
								if (is_singular('people')) {
									$page_name = 'People';
								} elseif (is_singular('post') || is_page('news-archive') || has_term('spotlight', 'profiletype')) { 
									$page_name = 'About';
								} elseif (has_term('undergrad-bb','bbtype') || has_term('undergraduate-profile','profiletype') || is_tax('profiletype', 'undergraduate-profile')) {
									$page_name = 'Undergraduate';
								} elseif (has_term('graduate-bb', 'bbtype') || has_term('graduate-profile', 'profiletype')) {
									$page_name = 'Graduate';
								} else {
									$page_name = $post->post_title;
								}
								$test_menu = wp_nav_menu( array( 
									'theme_location' => 'main_nav', 
									'menu_class' => 'nav',
									'container_class' => 'offset-gutter',
									'items_wrap' =>  '<div id="sidebar_header"><h5 class="grey">Also in <span class="black bold">' . $page_name . '</span></h5></div><ul class="%2$s">%3$s</ul>',				
									'submenu' => $page_name,
									'depth' => 1,
									'echo' => true
								));
							if (strpos($test_menu,'<li id') !== false) : echo $test_menu; endif;
						}
				        //If there are one or more display a menu of siblings
				
										
			} 
			else { ?>
				<div class="offset-gutter" id="sidebar_header">
					<h5 class="grey">Also in <span class="black bold">About</span></h5>
				</div>
			<?php
						wp_nav_menu( array( 
									'theme_location' => 'main_nav', 
									'menu_class' => 'nav', 
									'container_class' => 'offset-gutter',
									'submenu' => 'About',
									'depth' => 2				
								));
				}
			
			?>
			
		<!-- End Navigation for Sibling Pages -->
	
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('under-nav-sb') ) : ?><?php endif; ?>

		<!-- End Widget Content -->
	</nav> <!-- End Sidebar -->
