<?php 
	$home_url = home_url();
	$theme_option = flagship_sub_get_global_options();	
	
		if ( is_singular('post') && $theme_option['flagship_sub_breadcrumbs']  == '1') { 
			global $post;
			$article_title = $post->post_title;
			$article_link = $post->guid;
		?>
		<nav role="navigation">
			<ul id="menu-main-menu-2" class="breadcrumbs">
				<li><a href="<?php echo $home_url; ?>">Home</a></li>
				<li><a href="<?php echo $home_url; ?>/about">About</a></li>
				<li><a href="<?php echo $home_url; ?>/about/archive">News Archive</a></li>
				<li><a href="<?php echo $article_link; ?>"><?php echo $article_title; ?></a></li>
			</ul>
		</nav>	<?php } 
		
	elseif ( $theme_option['flagship_sub_breadcrumbs']  == '1' ) { 
	wp_nav_menu( array( 
				'container' => 'nav',
				'container_class' => 'offset-topgutter hide-for-print',
				'theme_location' => 'main_nav',
				'menu_class' => 'breadcrumbs',
				'items_wrap' => '<ul id="%1$s" class="%2$s"><li><a href="' . $home_url . '">' . $theme_option['flagship_sub_breadcrumb_home'] . '</a></li>%3$s</ul>',
				'walker'=> new flagship_bread_crumb )); 
	}
	
?>				
