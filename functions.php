<?php
//Add Theme Options Page
	if(is_admin()){	
		require_once('assets/functions/theme-options-init.php');
	}
	
	//Collect current theme option values
		function flagship_sub_get_global_options(){
			$flagship_sub_option = array();
			$flagship_sub_option 	= get_option('flagship_sub_options');
		return $flagship_sub_option;
		}
	
	//Function to call theme options in theme files 
		$flagship_sub_option = flagship_sub_get_global_options();

//Add custom background option
	
function academic_flagship_theme_support() {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 125, 125, true );   // default thumb size
	add_image_size( 'rss', 300, 150, true );
	add_image_size( 'directory', 90, 130, true );
	add_theme_support( 'automatic-feed-links' ); // rss thingy
	$bg_args = array(
		'default-color'          => '#e2e1df',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	);
	add_theme_support( 'custom-background', $bg_args  );
	add_theme_support( 'menus' );            
	register_nav_menus(                      
		array( 
			'main_nav' => 'The Main Menu', 
			'search_bar' => 'Search Bar Links',
			'quick_links' => 'Quick Links',
			'footer_links' => 'Footer Links'
		)
	);	
}

// Initiate Theme Support
add_action('after_setup_theme','academic_flagship_theme_support');

//Register Sidebars
	if ( function_exists('register_sidebar') )
		register_sidebar(array(
			'name'          => 'Default Sidebar',
			'id'            => 'page-sb',
			'description'   => 'This is the default sidebar',
			'before_widget' => '<div id="widget" class="widget %2$s row">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="blue_bg widget_title"><h5 class="white">',
			'after_title'   => '</h5></div>' 
			));
	if ( function_exists('register_sidebar') )
		register_sidebar(array(
			'name'          => 'Graduate Sidebar',
			'id'            => 'graduate-sb',
			'description'   => 'This sidebar will appear on pages under Graduate',
			'before_widget' => '<div id="widget" class="widget %2$s row">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="blue_bg widget_title"><h5 class="white">',
			'after_title'   => '</h5></div>' 
			));
	if ( function_exists('register_sidebar') )
		register_sidebar(array(
			'name'          => 'Undergraduate Sidebar',
			'id'            => 'undergrad-sb',
			'description'   => 'This sidebar will appear on pages under Undergraduate',
			'before_widget' => '<div id="widget" class="widget %2$s row">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="blue_bg widget_title"><h5 class="white">',
			'after_title'   => '</h5></div>' 
			));
	if ( function_exists('register_sidebar') )
		register_sidebar(array(
			'name'          => 'Research Sidebar',
			'id'            => 'research-sb',
			'description'   => 'This sidebar will appear on pages under Research',
			'before_widget' => '<div id="widget" class="widget %2$s row">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="blue_bg widget_title"><h5 class="white">',
			'after_title'   => '</h5></div>' 
			));
	if ( function_exists('register_sidebar') )
		register_sidebar(array(
			'name'          => 'Homepage Sidebar',
			'id'            => 'homepage-sb',
			'description'   => 'This sidebar will only appear on the homepage',
			'before_widget' => '<div id="widget" class="widget %2$s row">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="blue_bg widget_title"><h5 class="white">',
			'after_title'   => '</h5></div>' 
			));

	include_once (TEMPLATEPATH . '/assets/functions/page_metabox.php'); 

function get_the_directory_filters($post) {
	$directory_filters = get_the_terms( $post->ID, 'filter' );
					if ( $directory_filters && ! is_wp_error( $directory_filters ) ) : 
						$directory_filter_names = array();
							foreach ( $directory_filters as $directory_filter ) {
								$directory_filter_names[] = $directory_filter->slug;
							}
						$directory_filter_name = join( " ", $directory_filter_names );
						
					endif;
					return $directory_filter_name;
}

function get_the_roles($post) {
	$roles = get_the_terms( $post->ID, 'role' );
					if ( $roles && ! is_wp_error( $roles ) ) : 
						$role_names = array();
							foreach ( $roles as $role ) {
								$role_names[] = $role->slug;
							}
						$role_name = join( " ", $role_names );
						
					endif;
					return $role_name;
}

/**********DELETE TRANSIENTS******************/

function delete_academic_open_transients($post_id) {
	global $post;
	if (isset($_GET['post_type'])) {		
		$post_type = $_GET['post_type'];
	}
	else {
		$post_type = $post->post_type;
	}
	switch($post_type) {
		case 'people' :
			delete_transient('faculty_people_query');
			delete_transient('research_people_query');
			delete_transient('staff_people_query');
			delete_transient('emeriti_people_query');
			delete_transient('job_market_query');
		break;
		
		case 'post' :
			for ($i=1; $i < 5; $i++)
			    { delete_transient('faculty_books_query_' . $i);
			      delete_transient('news_archive_query_' . $i); }
			   
			delete_transient('news_query');
		break;
		
		case 'slider' :
			delete_transient('slider_query');
		break;
		
		case 'course' :
			delete_transient('ksas_course_grad_query');
			delete_transient('ksas_course_undergrad_query');
		break;
		case 'bulletinboard' :
			delete_transient('ksas_bb_undergrad_query');
			delete_transient('ksas_bb_grad_query');
	}
}
	add_action('save_post','delete_academic_open_transients');
	
/**********ADD PEOPLE TO SITEMAPS******************/
function my_sitemap_replacement ($content) {
	//return $content . '<empty>Nothing here</empty>';
	$totalposts = apply_filters('simple_sitemaps-totals_soft_limit', (defined('SIMPLE_SITEMAPS_POST_SOFT_LIMIT') ? SIMPLE_SITEMAPS_POST_SOFT_LIMIT : 50));
	$latestposts = $totalposts ? get_posts( 'post_type=people&numberposts=' . $totalposts . '&orderby=date&order=DESC' ) : array();
	foreach ( $latestposts as $post ) {
		$content .= "	<url>\n";
		$content .= '		<loc>' . get_permalink( $post->ID ) . "</loc>\n";
		$content .= '		<lastmod>' . mysql2date( 'Y-m-d\TH:i:s', $post->post_modified_gmt ) . "+00:00</lastmod>\n";
		$content .= '		<priority>' . number_format( 1, 1 ) . "</priority>\n";
		$content .= "	</url>\n";
	}
	return $content;
}
add_filter('simple_sitemaps-generated_urlset', 'my_sitemap_replacement');

?>