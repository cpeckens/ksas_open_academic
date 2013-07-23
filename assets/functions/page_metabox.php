<?php

$page_sidebar_metabox = array( 
	'id' => 'page_sidebar_meta',
	'title' => 'Sidebar Content',
	'page' => array('page'),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(

				array(
					'name' 			=> 'Sidebar Content',
					'desc' 			=> 'This content will display in the sidebar on this page ONLY.  Please set section titles as [sidebar-title]Heading Name[/sidebar-title]',
					'id' 			=> 'ecpt_page_sidebar',
					'class' 		=> 'ecpt_page_sidebar',
					'type' 			=> 'textarea',
					'rich_editor' 	=> 1,			
					'max' 			=> 0,
					'std'			=> ''													
				),
				

				
));			
			
add_action('admin_menu', 'ecpt_add_page_sidebar_meta_box');
function ecpt_add_page_sidebar_meta_box() {

	global $page_sidebar_metabox;		

	foreach($page_sidebar_metabox['page'] as $page) {
		add_meta_box($page_sidebar_metabox['id'], $page_sidebar_metabox['title'], 'ecpt_show_page_sidebar_box', $page, 'normal', 'default', $page_sidebar_metabox);
	}
}

// function to show meta boxes
function ecpt_show_page_sidebar_box()	{
	global $post;
	global $page_sidebar_metabox;
	global $ecpt_prefix;
	global $wp_version;
	
	// Use nonce for verification
	echo '<input type="hidden" name="ecpt_page_sidebar_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<table class="form-table">';

	foreach ($page_sidebar_metabox['fields'] as $field) {
		// get current post meta data

		$meta = get_post_meta($post->ID, $field['id'], true);
		
		echo '<tr>',
				'<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
				'<td class="ecpt_field_type_' . str_replace(' ', '_', $field['type']) . '">';
		switch ($field['type']) {
			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" /><br/>', '', $field['desc'];
				break;
			case 'textarea':
			
				if($field['rich_editor'] == 1) {
					echo $field['desc'];

					if($wp_version >= 3.3) {
						echo wp_editor($meta, $field['id'], array('textarea_name' => $field['id'], 'wpautop' => false));
					} else {
						// older versions of WP
						$editor = '';
						if(!post_type_supports($post->post_type, 'editor')) {
							$editor = wp_tiny_mce(true, array('editor_selector' => $field['class'], 'remove_linebreaks' => false) );
						}
						$field_html = '<div style="width: 97%; border: 1px solid #DFDFDF;"><textarea name="' . $field['id'] . '" class="' . $field['class'] . '" id="' . $field['id'] . '" cols="60" rows="8" style="width:100%">'. $meta . '</textarea></div><br/>' . __($field['desc']);
						echo $editor . $field_html;
					}
				} else {
					echo '<div style="width: 100%;"><textarea name="', $field['id'], '" class="', $field['class'], '" id="', $field['id'], '" cols="60" rows="8" style="width:97%">', $meta ? $meta : $field['std'], '</textarea></div>', '', $field['desc'];				
				}
				
				break;
			case 'upload':
				echo '<input type="text" class="ecpt_upload_field" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:80%" /><input class="ecpt_upload_image_button" type="button" value="Upload" /><br/>', '', $field['desc'];
				break;
		}
		echo     '<td>',
			'</tr>';
	}
	
	echo '</table>';
}	

add_action('save_post', 'ecpt_page_sidebar_save');

// Save data from meta box
function ecpt_page_sidebar_save($post_id) {
	global $post;
	global $page_sidebar_metabox;
	
	// verify nonce
	if (!isset($_POST['ecpt_page_sidebar_meta_box_nonce']) || !wp_verify_nonce($_POST['ecpt_page_sidebar_meta_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	
	foreach ($page_sidebar_metabox['fields'] as $field) {
	
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		
		if ($new && $new != $old) {
			if($field['type'] == 'date') {
				$new = ecpt_format_date($new);
				update_post_meta($post_id, $field['id'], $new);
			} else {
				update_post_meta($post_id, $field['id'], $new);
				
				
			}
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}


//Add Widget Title shortcode
function sidebar_title_shortcode( $attr, $content = null ) {
  return '<div class="blue_bg widget_title offset-gutter"><h5 class="white">' . $content . '</h5></div>';
}
add_shortcode('sidebar-title', 'sidebar_title_shortcode');
?>
