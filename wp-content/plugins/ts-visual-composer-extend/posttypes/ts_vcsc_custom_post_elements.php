<?php
    // Create Custom Messages
    function TS_VCSC_Widgets_Post_Messages($messages) {
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
	add_filter('post_updated_messages', 'TS_VCSC_Widgets_Post_Messages');
    
    // Add Content for Contextual Help Section
    function TS_VCSC_Widgets_Post_Help( $contextual_help, $screen_id, $screen ) { 
        if ( 'edit-ts_widgets' == $screen->id ) {
            $contextual_help = '<h2>VC Widgets</h2>
            <p>VC Widgets are an easy way to display any Visual Composer element in your widget sidebar.</p> 
            <p>You can view/edit the details of each widgets by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
        } else if ('ts_testimonials' == $screen->id) {
            $contextual_help = '<h2>Editing VC Widgets</h2>
            <p>This page allows you to view/modify widget details. Please make sure to fill out the available boxes with the appropriate details. Widget information can only be used with the Visual Composer Extensions Plugin.</p>';
        }
        return $contextual_help;
    }
	add_action('contextual_help', 'TS_VCSC_Widgets_Post_Help', 10, 3);
	
	// Create Custom Metaboxes
	add_action('add_meta_boxes', 'TS_VCSC_Widgets_Post_MetaBox' );
	function TS_VCSC_Widgets_Post_MetaBox() {
		add_meta_box('ts_widgets_basic', __( 'Usage Information (BETA)', 'ts_visual_composer_extend' ), 'TS_VCSC_Widgets_Post_MetaContent', 'ts_widgets', 'normal', 'core');
	}
	function TS_VCSC_Widgets_Post_MetaContent($post) {
		echo '<div style="margin-top: 25px;">';
			echo '<div class="ts-posts-widgets-info"><p>Use this custom post type to create content with the standard WordPress editor or Visual Composer, which can be used via widget in any sidebar. In your "Appearance" -> "Widgets"
			section, you will find a matching widget "VCE - Visual Composer Elements", allowing you to select the content created here to be added to any sidebar.</p></div>';
			echo '<div class="ts-posts-widgets-warning"><p>While you will have access to all Visual Composer and add-on elements, <strong>please be aware that not every element is suitable to be used in a narrow sidebar.</p></div>';
			echo '<div class="ts-posts-widgets-critical"><p style="font-weight: bold;">For layout purposes, it is highly advised to only use full-width (one-column) rows, in order to best utilize the narrow width of a sidebar.
			Rows with multiple columns are usually not suitable for sidebars, unless the sidebar has an unusual large width.</p></div>';
		echo '</div>';
	}
	
	// Load Required JS+CSS Files
	function TS_VCSC_Widgets_Post_Files() {
		global $pagenow;
		$screen = TS_VCSC_GetCurrentPostType();
		if ($screen=='ts_widgets') {
			if ($pagenow=='post-new.php' || $pagenow=='post.php') {
				if (!wp_script_is('jquery')) {
					wp_enqueue_script('jquery');
				}
				wp_enqueue_style('ts-extend-posttypes');
			}
		}
	}
	add_action('admin_enqueue_scripts',							'TS_VCSC_Widgets_Post_Files', 				9999999999);
?>