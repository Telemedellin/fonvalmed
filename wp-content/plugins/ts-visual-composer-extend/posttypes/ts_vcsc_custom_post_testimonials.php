<?php
    // Create Custom Messages
    function TS_VCSC_Testimonials_Post_Messages($messages) {
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
	add_filter('post_updated_messages', 'TS_VCSC_Testimonials_Post_Messages');
    
    // Add Content for Contextual Help Section
    function TS_VCSC_Testimonials_Post_Help( $contextual_help, $screen_id, $screen ) { 
        if ( 'edit-ts_testimonials' == $screen->id ) {
            $contextual_help = '<h2>Testimonials</h2>
            <p>Testimonials are an easy way to display feedback you received from your customers or to show any other quotes on your website.</p> 
            <p>You can view/edit the details of each testimonial by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
        } else if ('ts_testimonials' == $screen->id) {
            $contextual_help = '<h2>Editing Testimonials</h2>
            <p>This page allows you to view/modify testimonial details. Please make sure to fill out the available boxes with the appropriate details. Testimonial information can only be used with the Visual Composer Extensions Plugin.</p>';
        }
        return $contextual_help;
    }
	add_action('contextual_help', 'TS_VCSC_Testimonials_Post_Help', 10, 3);
	
	// Add Custom Metaboxes to Post Type
	function TS_VCSC_Testimonial_Meta_Boxes(array $meta_boxes) {
		$prefixA 			= 'ts_vcsc_testimonial_basic_';
		// Configure Metabox - Basic Information
		$meta_boxes['ts_vcsc_testimonial_basic'] = array(
			'id'                		=> 'ts_vcsc_testimonial_basic',		// meta box id, unique per meta box 
			'title'             		=> 'Testimonial Information',		// meta box title
			'pages'             		=> array('ts_testimonials'),		// post types, accept custom post types as well, default is array('post'); optional
			'object_types' 				=> array('ts_testimonials',),
			'context'           		=> 'normal',                        // where the meta box appear: normal (default), advanced, side; optional
			'priority'          		=> 'high',                          // order of meta box: high (default), low; optional
			'local_images'      		=> false,                           // Use local or hosted images (meta box images for add/remove)
			'use_with_theme'    		=> false,                           // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
			'show_names' 				=> true, 							// Show field names on the left
			'fields' 					=> array(
				array('name' => 'Author Name:', 'std' => '', 'desc' => 'Enter the name of the person this tesimonial or quote is attributed to.', 'id' => $prefixA . 'author', 'type' => 'text'),
				array('name' => 'Note:', 'std' => '', 'desc' => 'Enter a note (i.e. company, position, etc.) about the person this tesimonial or quote is attributed to.', 'id' => $prefixA . 'position', 'type' => 'text'),
			),
		);
		
		return $meta_boxes;
	}
	add_filter('cmb_meta_boxes', 'TS_VCSC_Testimonial_Meta_Boxes');
	
	// Load Required JS+CSS Files
	function TS_VCSC_Testimonials_Post_Files() {
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
		if ($screen=='ts_testimonials') {
			if ($pagenow=='post-new.php' || $pagenow=='post.php') {
				if (!wp_script_is('jquery')) {
					wp_enqueue_script('jquery');
				}
				wp_enqueue_style('ts-extend-posttypes');
				wp_enqueue_style('ts-font-teammates');
			}
		}
	}
	add_action('admin_enqueue_scripts',							'TS_VCSC_Testimonials_Post_Files', 				9999999999);
	
	// Add Featured Image Column
	add_filter( 'manage_ts_testimonials_posts_columns', 		'TS_VCSC_Add_Testimonials_Image_Column' );
	add_action( 'manage_ts_testimonials_posts_custom_column', 	'TS_VCSC_Show_Testimonials_Image_Column', 10, 2 );
	function TS_VCSC_Add_Testimonials_Image_Column( $defaults ){
		$defaults = array_merge(
			array('ts_testimonials_post_thumbs' => __('Thumbnail')),
			$defaults
		);
		return $defaults;
	}
	function TS_VCSC_Show_Testimonials_Image_Column( $column_name, $id ) {
		if ( $column_name === 'ts_testimonials_post_thumbs' ) {
			echo the_post_thumbnail('thumbnail');
		}
	}
?>