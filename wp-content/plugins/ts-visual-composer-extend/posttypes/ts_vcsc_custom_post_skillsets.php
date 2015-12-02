<?php
    // Create Custom Messages
    function TS_VCSC_Skillsets_Post_Messages($messages) {
		global $post, $post_ID;
		$post_type = get_post_type( $post_ID );
		$obj = get_post_type_object($post_type);
		$singular = $obj->labels->singular_name;
		$messages[$post_type] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => sprintf( __($singular.' updated.')),
			2 => __('Custom field updated.'),
			3 => __('Custom field deleted.'),
			4 => __($singular.' updated.'),
			5 => isset($_GET['revision']) ? sprintf( __($singular.' restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __($singular.' published.')),
			7 => __('Page saved.'),
			8 => sprintf( __($singular.' submitted.')),
			9 => sprintf( __($singular.' scheduled for: <strong>%1$s</strong>.'), date_i18n( __('M j, Y @ G:i'), strtotime($post->post_date))),
			10 => sprintf( __($singular.' draft updated.')),
		);
		return $messages;
    }
	add_filter('post_updated_messages', 'TS_VCSC_Skillsets_Post_Messages');

    // Add Content for Contextual Help Section
    function TS_VCSC_Skillsets_Post_Help( $contextual_help, $screen_id, $screen ) { 
        if ( 'edit-ts_skillsets' == $screen->id ) {
            $contextual_help = '<h2>Skillsets</h2>
            <p>Skillsets are an easy way to display feedback you received from your customers or to show any other quotes on your website.</p> 
            <p>You can view/edit the details of each testimonial by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
        } else if ('ts_skillsets' == $screen->id) {
            $contextual_help = '<h2>Editing Skillsets</h2>
            <p>This page allows you to view/modify testimonial details. Please make sure to fill out the available boxes with the appropriate details. Skillset information can only be used with the Visual Composer Extensions Plugin.</p>';
        }
        return $contextual_help;
    }
	add_action('contextual_help', 'TS_VCSC_Skillsets_Post_Help', 10, 3);
	
	// Add Custom Metaboxes to Post Type
	function TS_VCSC_Skillset_Meta_Boxes(array $meta_boxes) {
		$prefixA 			= 'ts_vcsc_skillset_basic_';
		// Configure Metabox - Basic Information
		$meta_boxes['ts_vcsc_skillset_basic'] = array(
			'id'         				=> 'ts_vcsc_skillset_basic',
			'title'      				=> 'Skill Sets',
			'pages'      				=> array('ts_skillsets',),
			'object_types' 				=> array('ts_skillsets',),
			'context'           		=> 'normal',                        // where the meta box appear: normal (default), advanced, side; optional
			'priority'          		=> 'low',                          	// order of meta box: high (default), low; optional
			'local_images'      		=> false,                           // Use local or hosted images (meta box images for add/remove)
			'use_with_theme'    		=> false,                           // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
			'show_names' 				=> true, 							// Show field names on the left
			'fields'     				=> array(
				array('name' => 'Add as many skill levels as you need by using the "Add Another Skill" button.', 'desc' => 'Skills can also be re-ordered or removed by using the appropriate buttons.', 'type' => 'title', 'id' => $prefixA . 'title'),
				array(
					'id'          		=> $prefixA . 'group',
					'type'        		=> 'group',
					'description' 		=> '',
					'options'     		=> array(
						'add_button'    => 'Add Another Skill',
						'remove_button' => 'Remove Skill',
						'sortable'      => true,
					),
					'fields'      		=> array(
						array('name' 		=> 'Skill Name:', 'id' => 'skillname', 'type' => 'text_medium',),
						array('name' 		=> 'Skill Value in %:', 'id' => 'skillvalue', 'type' => 'text_medium',),
						array('name'    	=> 'Skill Color:', 'desc' => '', 'id' => 'skillcolor', 'type' => 'colorpicker', 'default' => '#00afd1'),
					),
				),
			),
		);
		
		return $meta_boxes;
	}
	add_filter('cmb_meta_boxes', 'TS_VCSC_Skillset_Meta_Boxes');
	
	// Load Required JS+CSS Files
	function TS_VCSC_Skillsets_Post_Files() {
		global $pagenow;
		$screen = TS_VCSC_GetCurrentPostType();
		/*if (function_exists('get_current_screen')){
			$current 		= get_current_screen();
			$screen			= $current->post_type;
		} else {
			global $typenow;
			if (empty($typenow) && !empty($_GET['post'])) {
				$post 		= get_post($_GET['post']);
				$typenow 	= $post->post_type;
				$screen		= $typenow;
			} else if (empty($typenow) && !empty($_POST['post_ID'])) {
				$post 		= get_post($_POST['post_ID']);
				$typenow 	= $post->post_type;
				$screen		= $typenow;
			}			
		}*/
		if ($screen=='ts_skillsets') {
			if ($pagenow=='post-new.php' || $pagenow=='post.php') {
				if (!wp_script_is('jquery')) {
					wp_enqueue_script('jquery');
				}
				wp_enqueue_style('ts-font-teammates');
			}
		}
	}
	add_action('admin_enqueue_scripts',							'TS_VCSC_Skillsets_Post_Files', 				9999999999);
?>