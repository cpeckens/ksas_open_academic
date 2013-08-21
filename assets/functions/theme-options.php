<?php
/**
 * Define our settings sections
 *
 * array key=$id, array value=$title in: add_settings_section( $id, $title, $callback, $page );
 * @return array
 */
function flagship_sub_options_page_sections() {
	
	$sections = array();
	// $sections[$id] 				= __($title, 'flagship_sub_textdomain');
	$sections['homepage_section'] 	= __('Homepage Options', 'flagship_sub_textdomain');
	$sections['select_section'] 	= __('Content Options', 'flagship_sub_textdomain');
	$sections['directory_section']  = __('Directory Search Options', 'flagship_sub_textdomain');
	$sections['footer_section'] 	= __('Footer Options', 'flagship_sub_textdomain');
	$sections['technical_section'] 	= __('Technical Options', 'flagship_sub_textdomain');
	return $sections;	
}

/**
 * Define our form fields (settings) 
 *
 * @return array
 */
function flagship_sub_options_page_fields() {
	// Text Form Fields section
	// Select Form Fields section
	$options[0] =
	array (		
		"section" => "homepage_section",
		"id"      => FLAGSHIP_SUB_SHORTNAME . "_feed_name",
		"title"   => __( 'Homepage Sub-head', 'flagship_sub_textdomain' ),
		"desc"    => __( 'Enter the headline for the news feed on the homepage', 'flagship_sub_textdomain' ),
		"type"    => "text",
		"class"   => "nohtml",
		"std"    => "");
	$options[1] =
	array (		
		"section" => "homepage_section",
		"id"      => FLAGSHIP_SUB_SHORTNAME . "_news_quantity",
		"title"   => __( 'Homepage Posts', 'flagship_sub_textdomain' ),
		"desc"    => __( 'Enter the number of posts you would like displayed on the homepage', 'flagship_sub_textdomain' ),
		"type"    => "text",
		"class"   => "numeric",
		"std"    => "");
	$options[2] =
	array (		
		"section" => "select_section",
		"id"      => FLAGSHIP_SUB_SHORTNAME . "_breadcrumbs",
		"title"   => __( 'Breadcrumbs', 'flagship_sub_textdomain' ),
		"desc"    => __( 'Do you want breadcrumb navigation on your subpages?', 'flagship_sub_textdomain' ),
		"type"    => "checkbox",
		"std"    => "1");
	$options[3] =
	array (		
		"section" => "directory_section",
		"id"      => FLAGSHIP_SUB_SHORTNAME . "_directory_search",
		"title"   => __( 'Directory Search', 'flagship_sub_textdomain' ),
		"desc"    => __( 'Do you want a search box and filter capabilities for your people directory?', 'flagship_sub_textdomain' ),
		"type"    => "checkbox",
		"std"    => "1");	
	$options[4] =
	array (		
		"section" => "select_section",
		"id"      => FLAGSHIP_SUB_SHORTNAME . "_breadcrumb_home",
		"title"   => __( 'Breadcrumb Name', 'flagship_sub_textdomain' ),
		"desc"    => __( 'What do you want Home to be called in your breadcrumb navigation?', 'flagship_sub_textdomain' ),
		"type"    => "text",
		"class"   => "nohtml",
		"std"    => "Home");
	$options[5] =
	array (		
		"section" => "technical_section",
		"id"      => FLAGSHIP_SUB_SHORTNAME . "_google_analytics",
		"title"   => __( 'Google Analytics ID', 'flagship_sub_textdomain' ),
		"desc"    => __( 'Enter your Google Analytics ID ie. UA-2497774-9', 'flagship_sub_textdomain' ),
		"type"    => "text",
		"class"   => "nohtml",
		"std"    => "UA-40512757-1");
	$options[6] =
	array (		
		"section" => "technical_section",
		"id"      => FLAGSHIP_SUB_SHORTNAME . "_search_collection",
		"title"   => __( 'GSA Collection', 'flagship_sub_textdomain' ),
		"desc"    => __( 'Enter the name of the google search appliance collection', 'flagship_sub_textdomain' ),
		"type"    => "text",
		"class"   => "nohtml",
		"std"    => "krieger_collection");
	$options[7] =
	array (		
		"section" => "select_section",
		"id"      => FLAGSHIP_SUB_SHORTNAME . "_calendar_address",
		"title"   => __( 'Calendar URL', 'flagship_sub_textdomain' ),
		"desc"    => __( 'Enter the URL of your Site Executive calendar instance', 'flagship_sub_textdomain' ),
		"type"    => "text",
		"class"   => "nohtml",
		"std"    => "");		
	$options[8] =
	array (		
		"section" => "footer_section",
		"id"      => FLAGSHIP_SUB_SHORTNAME . "_quicklinks",
		"title"   => __( 'Quicklinks', 'flagship_sub_textdomain' ),
		"desc"    => __( 'Do you want to use quicklinks from another site?', 'flagship_sub_textdomain' ),
		"type"    => "checkbox",
		"std"    => "1");		
	$options[9] =
	array (		
		"section" => "footer_section",
		"id"      => FLAGSHIP_SUB_SHORTNAME . "_quicklinks_id",
		"title"   => __( 'Quicklinks Site ID', 'flagship_sub_textdomain' ),
		"desc"    => __( 'Enter the site ID for the quicklinks you would like to use. krieger.jhu.edu is 1', 'flagship_sub_textdomain' ),
		"type"    => "text",
		"class"   => "numeric",
		"std"    => "1");
	$options[10] =
	array (		
		"section" => "footer_section",
		"id"      => FLAGSHIP_SUB_SHORTNAME . "_copyright",
		"title"   => __( 'Department Address', 'flagship_sub_textdomain' ),
		"desc"    => __( 'Enter the department address', 'flagship_sub_textdomain' ),
		"type"    => "textarea",
		"std"    => "Zanvyl Krieger School of Arts & Sciences");
	$options[11] =
	array (		
		"section" => "directory_section",
		"id"      => FLAGSHIP_SUB_SHORTNAME . "_role_search",
		"title"   => __( 'Filter by Role', 'flagship_sub_textdomain' ),
		"desc"    => __( 'Do you want to be able to filter by role (faculty, research staff, emertiti)?', 'flagship_sub_textdomain' ),
		"type"    => "checkbox",
		"std"    => "0");		
	$options[12] =
	array (		
		"section" => "directory_section",
		"id"      => FLAGSHIP_SUB_SHORTNAME . "_research_search",
		"title"   => __( 'Filter by Expertise', 'flagship_sub_textdomain' ),
		"desc"    => __( 'Do you want to be able to filter by expertise/research area?', 'flagship_sub_textdomain' ),
		"type"    => "checkbox",
		"std"    => "0");		
		return $options;
		
}

?>