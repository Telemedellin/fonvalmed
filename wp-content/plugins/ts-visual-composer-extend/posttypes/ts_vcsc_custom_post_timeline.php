<?php
    // Create Custom Messages
    function TS_VCSC_Timeline_Post_Messages($messages) {
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
	add_filter('post_updated_messages', 'TS_VCSC_Timeline_Post_Messages');
	
    // Add Content for Contextual Help Section
    function TS_VCSC_Timeline_Post_Help( $contextual_help, $screen_id, $screen ) { 
        if ( 'edit-ts_timeline' == $screen->id ) {
            $contextual_help = '<h2>Timeline Sections</h2>
            <p>Timeline sections can be used to create an interactive CSS/jQuery powered timeline with "Composium - Visual Composer Extensions".</p> 
            <p>You can view/edit the details of each timeline section by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
        } else if ('ts_timeline' == $screen->id) {
            $contextual_help = '<h2>Editing Timeline Sections</h2>
            <p>This page allows you to view/modify timeline section details. Please make sure to fill out the available boxes with the appropriate details. Timeline section information can only be used with the Visual Composer Extensions Plugin.</p>';
        }
        return $contextual_help;
    }
	add_action('contextual_help', 'TS_VCSC_Timeline_Post_Help', 10, 3);
	
	// Add Custom Metaboxes to Post Type
	function TS_VCSC_Timeline_Meta_Boxes(array $meta_boxes) {
		$prefixA 			= 'ts_vcsc_timeline_type_';
		$prefixB 			= 'ts_vcsc_timeline_media_';
		$prefixC 			= 'ts_vcsc_timeline_event_';
		$prefixD 			= 'ts_vcsc_timeline_break_';
		$prefixE 			= 'ts_vcsc_timeline_link_';
		$prefixF 			= 'ts_vcsc_timeline_tooltip_';
		$prefixG 			= 'ts_vcsc_timeline_lightbox_';
		
		$availablePages		= TS_VCSC_GetPostOptions(array('post_type' => 'page', 'posts_per_page' => -1));
		$defaultPage = array(
			'name' 			=> 'External Page for Event',
			'value' 		=> 'external'
		);
		array_unshift($availablePages, $defaultPage);
		$defaultPage = array(
			'name' 			=> 'No Link for Event',
			'value' 		=> '-1'
		);
		array_unshift($availablePages, $defaultPage);
		
		// Event Type
		$meta_boxes['ts_vcsc_timeline_type'] = array(
			'id'                		=> 'ts_vcsc_timeline_type',      	// meta box id, unique per meta box 
			'title'             		=> 'Section Type',             		// meta box title
			'pages'             		=> array('ts_timeline'),            // post types, accept custom post types as well, default is array('post'); optional
			'object_types' 				=> array('ts_timeline',),
			'context'           		=> 'normal',                        // where the meta box appear: normal (default), advanced, side; optional
			'priority'          		=> 'high',                          // order of meta box: high (default), low; optional
			'local_images'      		=> false,                           // Use local or hosted images (meta box images for add/remove)
			'use_with_theme'    		=> false,                           // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
			'show_names' 				=> true, 							// Show field names on the left
			'fields' 					=> array(
				array(
					'name'    	=> 'Section Type:',
					'id'      	=> $prefixA . 'type',
					'type'   	=> 'radio_inline',
					'default' 	=> 'event',
					'desc' 		=> 'Check the type of timeline section you wan to create.',
					'options' 	=> array(
						'event' 	=> __( 'Event', 'cmb2' ),
						'break'   	=> __( 'Break', 'cmb2' ),
					),
				),
				array('name' => 'A "Break" section visually interrupts the timeline column layout and can be used to mark the beginning of a new "era" in the timeline.', 'desc' => 'The standard "Event" section is used to display detailed information about an event within the timeline.', 'type' => 'title', 'id' => $prefixA . 'messageA'),
				array( 
					'name'    => 'Border Radius:',
					'desc'    => 'Select what type of border radius should be applied to the timeline event.',
					'id'      => $prefixA . 'radiusborder',
					'type'    => 'select',
					'options' => array(
						"ts-timline-css-radius-none" 				=> __( 'None', "ts_visual_composer_extend" ),
						"ts-timline-css-radius-small" 				=> __( 'Small Radius', "ts_visual_composer_extend" ),
						"ts-timline-css-radius-medium" 				=> __( 'Medium Radius', "ts_visual_composer_extend" ),
						"ts-timline-css-radius-large" 				=> __( 'Large Radius', "ts_visual_composer_extend" ),
					),
					'default' => 'ts-timline-css-radius-none',
				),
			),
		);
		
		// Featured Media
		$meta_boxes['ts_vcsc_timeline_media'] = array(
			'id'                		=> 'ts_vcsc_timeline_media',      	// meta box id, unique per meta box 
			'title'             		=> 'Featured Media',             	// meta box title
			'pages'             		=> array('ts_timeline'),            // post types, accept custom post types as well, default is array('post'); optional
			'object_types' 				=> array('ts_timeline',),
			'context'           		=> 'normal',                        // where the meta box appear: normal (default), advanced, side; optional
			'priority'          		=> 'high',                          // order of meta box: high (default), low; optional
			'local_images'      		=> false,                           // Use local or hosted images (meta box images for add/remove)
			'use_with_theme'    		=> false,                           // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
			'show_names' 				=> true, 							// Show field names on the left
			'fields' 					=> array(
				array(
					'name'    	=> 'Featured Event Section:',
					'id'      	=> $prefixB . 'fullwidth',
					'type'   	=> 'radio_inline',
					'default' 	=> 'false',
					'desc' 		=> 'Check the box if you want this timeline event to be a featured event, displayed full width over both columns.',
					'options' 	=> array(
						'true' 		=> __( 'Yes', 'cmb2' ),
						'false'   	=> __( 'No', 'cmb2' ),
					),
				),				
				array(
					'name'    => 'Featured Media:',
					'desc'    => 'Select the Featured Media Type for the timeline item',
					'id'      => $prefixB . 'featuredmedia',
					'type'    => 'select',
					'options' => array(
						"none" 					=> "None",
						"image" 				=> "Single Image",
						"slider"				=> "Image Slider",
						"youtube_default"		=> "YouTube Video (Lightbox; Auto Cover)",
						"youtube_custom"		=> "YouTube Video (Lightbox; Custom Cover)",
						"youtube_embed"			=> "YouTube Video (Direct iFrame)",
						"dailymotion_default"	=> "DailyMotion Video (Lightbox; Auto Cover)",
						"dailymotion_custom"	=> "DailyMotion Video (Lightbox; Custom Cover)",
						"dailymotion_embed"		=> "DailyMotion Video (Direct iFrame)",
						"vimeo_default"			=> "Vimeo Video (Lightbox; Auto Cover)",
						"vimeo_custom"			=> "Vimeo Video (Lightbox; Custom Cover)",
						"vimeo_embed"			=> "Vimeo Video (Direct iFrame)",
					),
					'default' => 'none',
				),
				// Single Image Selection array('image','youtube_custom','dailymotion_custom','vimeo_custom'))
				array('name' => 'Select Image:', 'desc' => 'Select an image for the timeline item.', 'id' => $prefixB . 'featuredimage', 'type' => 'file', 'allow' => array('attachment')),
				// Custom ALT + Title Attributes
				array('name' => 'Custom ALT Attribute:', 'desc' => 'Enter a custom value for the ALT attribute for the image, otherwise file name will be set.', 'default' => '', 'id' => $prefixB . 'attributealtvalue', 'type' => 'text_medium'),
				array('name' => 'Custom Title Attribute:', 'desc' => 'Enter a custom title for the media item, otherwise the timeline section title will be used.', 'default' => '', 'id' => $prefixB . 'attributetitle', 'type' => 'text_medium'),
				// Slider Selection array('image','slider'))
				array('name' => 'Select Images:', 'desc' => 'Select the images for the event slider; move images to arrange order in which to display. Use "CTRL" to select multiple image at once.', 'id' => $prefixB . 'featuredslider', 'type' => 'file_list', 'preview_size' => array( 50, 50 )),
				array('name' => 'Custom Title Attributes:', 'desc' => 'Enter custom titles for each image; seperate title by line break and use empty lines for images without title.', 'default' => '', 'id' => $prefixB . 'slidertitles', 'type' => 'textarea'),
				array(
					'name'    	=> 'Open in Lightbox:',
					'id'      	=> $prefixB . 'lightboxfeatured',
					'type'    	=> 'radio_inline',
					'desc' 		=> 'Check the box if you want to apply a lightbox to the image(s).',
					'default' 	=> 'true',
					'options' 	=> array(
						'true' 		=> __( 'Yes', 'cmb2' ),
						'false'   	=> __( 'No', 'cmb2' ),
					),
				),				
				array('name' => 'Maximum Image Height:', 'desc' => 'Define the maximum height of the images in the slider in pixels; helpful to prevent unnecessary position adjustments of timeline sections due to various image size ratios.', 'default' => '400', 'id' => $prefixB . 'slidermaxheight', 'type' => 'text_small', 'attributes' => array(
                    'type' 			=> 'number',
					'min'			=> 1,
					'max'			=> 800,
                ),),
				// YouTube Video array('youtube_default','youtube_custom','youtube_embed') )
				array('name' => 'YouTube Video URL:', 'desc' => 'Enter the URL for the YouTube video.', 'default' => '', 'id' => $prefixB . 'featuredyoutubeurl', 'type' => 'text_url'),
				array(
					'name'    	=> 'Show Related Videos:',
					'id'      	=> $prefixB . 'featuredyoutuberelated',
					'type'    	=> 'radio_inline',
					'desc' 		=> 'Check the box if you want to show related videos at the end of the video.',
					'default' 	=> 'false',
					'options' 	=> array(
						'true' 		=> __( 'Yes', 'cmb2' ),
						'false'   	=> __( 'No', 'cmb2' ),
					),
				),
				array(
					'name'    => 'Autoplay Video:',
					'id'      => $prefixB . 'featuredyoutubeplay',
					'type'    => 'radio_inline',
					'desc' 		=> 'Check the box if you want to auto-play the video once opened in the lightbox or on pageload (iFrame).',
					'default' => 'false',
					'options' => array(
						'true' 		=> __( 'Yes', 'cmb2' ),
						'false'   	=> __( 'No', 'cmb2' ),
					),
				),
				// DailyMotion Video array('dailymotion_default','dailymotion_embed','dailymotion_embed') )
				array('name' => 'DailyMotion Video URL:', 'desc' => 'Enter the URL for the DailyMotion video.', 'default' => '', 'id' => $prefixB . 'featureddailymotionurl', 'type' => 'text_url'),
				array(
					'name'    => 'Autoplay Video:',
					'id'      => $prefixB . 'featureddailymotionplay',
					'type'    => 'radio_inline',
					'desc' 		=> 'Check the box if you want to auto-play the video once opened in the lightbox or on pageload (iFrame).',
					'default' => 'false',
					'options' => array(
						'true' 		=> __( 'Yes', 'cmb2' ),
						'false'   	=> __( 'No', 'cmb2' ),
					),
				),
				// Vimeo Video array('vimeo_default','vimeo_custom','vimeo_embed') )
				array('name' => 'Vimeo Video URL:', 'desc' => 'Enter the URL for the Vimeo video.', 'default' => '', 'id' => $prefixB . 'featuredvimeourl', 'type' => 'text_url'),
				array(
					'name'    => 'Autoplay Video:',
					'id'      => $prefixB . 'featuredvimeoplay',
					'type'    => 'radio_inline',
					'desc' 		=> 'Check the box if you want to auto-play the video once opened in the lightbox or on pageload (iFrame).',
					'default' => 'false',
					'options' => array(
						'true' 		=> __( 'Yes', 'cmb2' ),
						'false'   	=> __( 'No', 'cmb2' ),
					),
				),
				// Media Dimensions array('image','youtube_default','youtube_custom','youtube_embed','dailymotion_default','dailymotion_custom','dailymotion_embed','vimeo_default','vimeo_custom','vimeo_embed') )
				array( 
					'name'    => 'Height Setting:',
					'desc'    => 'Select what height setting should be applied to the media element (change only if image height does not display correctly).',
					'id'      => $prefixB . 'featuredmediaheight',
					'type'    => 'select',
					'options' => array(
						"height: 100%;" 				=> __( '100% Height Setting', "ts_visual_composer_extend" ),
						"height: auto;" 				=> __( 'Auto Height Setting', "ts_visual_composer_extend" ),
					),
					'default' => 'height: 100%;',
				),
				array('name' => 'Media Width:', 'desc' => 'Define the media element width in percent (%).', 'default' => '100', 'id' => $prefixB . 'featuredmediawidth', 'type' => 'text_small', 'attributes' => array(
                    'type' 			=> 'number',
					'min'			=> 1,
					'max'			=> 100,
                ),),
				array( 
					'name'    => 'Media Alignment:',
					'desc'    => 'If not full width, select how the media element should be aligned.',
					'id'      => $prefixB . 'featuredmediaalign',
					'type'    => 'select',
					'options' => array(
						"center" 						=> __( 'Center', "ts_visual_composer_extend" ),
						"left" 							=> __( 'Left', "ts_visual_composer_extend" ),
						"right" 						=> __( 'Right', "ts_visual_composer_extend" ),
					),
					'default' => 'center',
				),				
			),
		);
		
		// Lightbox Settings
		$meta_boxes['ts_vcsc_timeline_lightbox'] = array(
			'id'                		=> 'ts_vcsc_timeline_lightbox',     // meta box id, unique per meta box 
			'title'             		=> 'Lightbox Settings',          	// meta box title
			'pages'             		=> array('ts_timeline'),            // post types, accept custom post types as well, default is array('post'); optional
			'object_types' 				=> array('ts_timeline',),
			'context'           		=> 'normal',                        // where the meta box appear: normal (default), advanced, side; optional
			'priority'          		=> 'high',                          // order of meta box: high (default), low; optional
			'local_images'      		=> false,                           // Use local or hosted images (meta box images for add/remove)
			'use_with_theme'    		=> false,                           // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
			'show_names' 				=> true, 							// Show field names on the left
			'fields' 					=> array(
				array(
					'name'    	=> 'Create AutoGroup:',
					'id'      	=> $prefixG . 'lightboxgroup',
					'type'   	=> 'radio_inline',
					'default' 	=> 'true',
					'desc' 		=> 'Switch the toggle if you want the plugin to group this image with all other non-gallery images on the page.',
					'options' 	=> array(
						'true' 		=> __( 'Yes', 'cmb2' ),
						'false'   	=> __( 'No', 'cmb2' ),
					),
				),
				array('name' => 'Group Name:', 'desc' => 'Enter a custom group name to manually build group with other non-gallery items.', 'default' => '', 'id' => $prefixG . 'lightboxgroupname', 'type' => 'text_medium'),
				array( 
					'name'    => 'Transition Effect:',
					'desc'    => 'Select the transition effect to be used for the image in the lightbox.',
					'id'      => $prefixG . 'lightboxeffect',
					'type'    => 'select',
					'options' => array(
						"random" 						=> __( 'Random', "ts_visual_composer_extend" ),
						"swipe"							=> __( 'Swipe', "ts_visual_composer_extend" ),
						"fade"							=> __( 'Fade & Swipe', "ts_visual_composer_extend" ),
						"scale"							=> __( 'Scale', "ts_visual_composer_extend" ),
						"slideUp"						=> __( 'Slide Up', "ts_visual_composer_extend" ),
						"slideDown"						=> __( 'Slide Down', "ts_visual_composer_extend" ),
						"flip"							=> __( 'Flip', "ts_visual_composer_extend" ),
						"skew"							=> __( 'Skew', "ts_visual_composer_extend" ),
						"bounceUp"						=> __( 'Bounce Up', "ts_visual_composer_extend" ),
						"bounceDown"					=> __( 'Bounce Down', "ts_visual_composer_extend" ),
						"breakIn"						=> __( 'Break In', "ts_visual_composer_extend" ),
						"rotateIn"						=> __( 'Rotate In', "ts_visual_composer_extend" ),
						"rotateOut"						=> __( 'Rotate Out', "ts_visual_composer_extend" ),
						"hangLeft"						=> __( 'Hang Left', "ts_visual_composer_extend" ),
						"hangRight"						=> __( 'Hang Right', "ts_visual_composer_extend" ),
						"cicleUp"						=> __( 'Cycle Up', "ts_visual_composer_extend" ),
						"cicleDown"						=> __( 'Cycle Down', "ts_visual_composer_extend" ),
						"zoomIn"						=> __( 'Zoom In', "ts_visual_composer_extend" ),
						"throwIn"						=> __( 'Throw In', "ts_visual_composer_extend" ),
						"fall"							=> __( 'Fall', "ts_visual_composer_extend" ),
						"jump"							=> __( 'Jump', "ts_visual_composer_extend" ),
					),
					'default' => 'random',
				),
				array( 
					'name'    => 'Backlight Effect:',
					'desc'    => 'Select the backlight effect for the image.',
					'id'      => $prefixG . 'lightboxbacklight',
					'type'    => 'select',
					'options' => array(
						"auto" 							=> __( 'Auto Color', "ts_visual_composer_extend" ),
						"custom" 						=> __( 'Custom Color', "ts_visual_composer_extend" ),
						"hideit" 						=> __( 'No Backlight (only for simple Black Lightbox Overlay)', "ts_visual_composer_extend" ),
					),
					'default' => 'auto',
				),
				array('name' => 'Custom Backlight Color:', 'desc' => 'Define the backlight color for the lightbox image.', 'id' => $prefixG . 'lightboxbacklightcolor', 'type' => 'colorpicker', 'default'  => '#ffffff', 'repeatable' => false,),
			),
		);
		
		// Event Content
		$meta_boxes['ts_vcsc_timeline_event'] = array(
			'id'                		=> 'ts_vcsc_timeline_event',      	// meta box id, unique per meta box 
			'title'             		=> 'Event Content',             	// meta box title
			'pages'             		=> array('ts_timeline'),            // post types, accept custom post types as well, default is array('post'); optional
			'object_types' 				=> array('ts_timeline',),
			'context'           		=> 'normal',                        // where the meta box appear: normal (default), advanced, side; optional
			'priority'          		=> 'high',                          // order of meta box: high (default), low; optional
			'local_images'      		=> false,                           // Use local or hosted images (meta box images for add/remove)
			'use_with_theme'    		=> false,                           // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
			'show_names' 				=> true, 							// Show field names on the left
			'fields' 					=> array(
				array('name' => 'Event Date / Time:', 'desc' => 'Enter a date and/or time for the timeline event.', 'default' => '', 'id' => $prefixC . 'eventdatetext', 'type' => 'text_medium'),
				array(
					'name'    	=> 'Date / Time Icon:',
					'desc'    	=> 'Select the icon that should be shown alongside the date / time.',
					'id'      	=> $prefixC . 'eventdateicon',
					'type'    	=> 'radio_inline',
					'std' 		=> 'none',
					'options' 	=> array(
						'clock' 		=> '<i class="dashicons dashicons-clock ts-post-font-icon"></i> ' . 'Clock',
						'calendar'   	=> '<i class="dashicons dashicons-calendar ts-post-font-icon"></i> ' . 'Calendar',
						'info'     		=> '<i class="dashicons dashicons-info ts-post-font-icon"></i> ' . 'Info',
						'location'		=> '<i class="dashicons dashicons-location ts-post-font-icon"></i> ' . 'Pin',
						'heart'			=> '<i class="dashicons dashicons-heart ts-post-font-icon"></i> ' . 'Heart',
						'megaphone'		=> '<i class="dashicons dashicons-megaphone ts-post-font-icon"></i> ' . 'Megaphone',
						'art'			=> '<i class="dashicons dashicons-art ts-post-font-icon"></i> ' . 'Art',
						'none'     		=> 'None',
					),
				),
				array('name' => 'Event Title:', 'desc' => 'Enter the title for the timeline event.', 'default' => '', 'id' => $prefixC . 'eventtitletext', 'type' => 'text'),
				array( 
					'name'    => 'Title Alignment:',
					'desc'    => 'Select how the title in the timeline event should be aligned.',
					'id'      => $prefixC . 'eventtitlealign',
					'type'    => 'select',
					'options' => array(
						"center" 						=> __( 'Center', "ts_visual_composer_extend" ),
						"left" 							=> __( 'Left', "ts_visual_composer_extend" ),
						"right" 						=> __( 'Right', "ts_visual_composer_extend" ),
						"justify" 						=> __( 'Justify', "ts_visual_composer_extend" ),
					),
					'default' => 'center',
				),
				array('name' => 'Title Color:', 'desc' => 'Define the font color for the title in the timeline item.', 'id' => $prefixC . 'eventtitlecolor', 'type' => 'colorpicker', 'default'  => '#7c7979', 'repeatable' => false,),
				array(
					'name' 		=> 'Content',
					'desc' 		=> 'Enter the main content for the timeline event.',
					'id' 		=> $prefixC . 'eventcontent',
					'type' 		=> 'wysiwyg',
					'options' 	=> array(
						'wpautop' 			=> true, 										// use wpautop?
						'media_buttons' 	=> false, 										// show insert/upload button(s)
						'textarea_name' 	=> $prefixC . 'eventcontent', 					// set the textarea name to something different, square brackets [] can be used here
						'textarea_rows' 	=> 10, 											// rows="..."
						'tabindex' 			=> '',
						'editor_css' 		=> '', 											// intended for extra styles for both visual and HTML editors buttons, needs to include the `<style>` tags, can use "scoped".
						'editor_class' 		=> '', 											// add extra class(es) to the editor textarea
						'teeny' 			=> false, 										// output the minimal editor config used in Press This
						'dfw' 				=> false, 										// replace the default fullscreen with DFW (needs specific css)
						'tinymce' 			=> true, 										// load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
						'quicktags' 		=> true 										// load Quicktags, can be used to pass settings directly to Quicktags using an array()  
					),
				),
				array('name' => 'You will be able to assign a font icon to the event when adding the event to a specific timeline in Visual Composer.', 'desc' => 'Aside from selecting an icon, you will also be able to define its color when adding this event to a timeline.', 'type' => 'title', 'id' => $prefixC . 'messageC'),
			),
		);
		
		// Break Content
		$meta_boxes['ts_vcsc_timeline_break'] = array(
			'id'                		=> 'ts_vcsc_timeline_break',      	// meta box id, unique per meta box 
			'title'             		=> 'Break Content',             	// meta box title
			'pages'             		=> array('ts_timeline'),            // post types, accept custom post types as well, default is array('post'); optional
			'object_types' 				=> array('ts_timeline',),
			'context'           		=> 'normal',                        // where the meta box appear: normal (default), advanced, side; optional
			'priority'          		=> 'high',                          // order of meta box: high (default), low; optional
			'local_images'      		=> false,                           // Use local or hosted images (meta box images for add/remove)
			'use_with_theme'    		=> false,                           // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
			'show_names' 				=> true, 							// Show field names on the left
			'fields' 					=> array(
				array('name' => 'Break Title:', 'desc' => 'Enter the title for the timeline break.', 'default' => '', 'id' => $prefixD . 'breaktitletext', 'type' => 'text'),
				array( 
					'name'    => 'Title Alignment:',
					'desc'    => 'Select how the title in the timeline break should be aligned.',
					'id'      => $prefixC . 'breaktitlealign',
					'type'    => 'select',
					'options' => array(
						"center" 						=> __( 'Center', "ts_visual_composer_extend" ),
						"left" 							=> __( 'Left', "ts_visual_composer_extend" ),
						"right" 						=> __( 'Right', "ts_visual_composer_extend" ),
						"justify" 						=> __( 'Justify', "ts_visual_composer_extend" ),
					),
					'default' => 'center',
				),
				array('name' => 'Title Color:', 'desc' => 'Define the font color for the title in the timeline item.', 'id' => $prefixD . 'breaktitlecolor', 'type' => 'colorpicker', 'default'  => '#7c7979', 'repeatable' => false,),
				array(
					'name' 		=> 'Break Content:',
					'desc' 		=> 'Enter the main content for the timeline break.',
					'id' 		=> $prefixD . 'breakcontent',
					'type' 		=> 'wysiwyg',
					'options' 	=> array(
						'wpautop' 			=> true, 										// use wpautop?
						'media_buttons' 	=> false, 										// show insert/upload button(s)
						'textarea_name' 	=> $prefixD . 'breakcontent', 					// set the textarea name to something different, square brackets [] can be used here
						'textarea_rows' 	=> 10, 											// rows="..."
						'tabindex' 			=> '',
						'editor_css' 		=> '', 											// intended for extra styles for both visual and HTML editors buttons, needs to include the `<style>` tags, can use "scoped".
						'editor_class' 		=> '', 											// add extra class(es) to the editor textarea
						'teeny' 			=> false, 										// output the minimal editor config used in Press This
						'dfw' 				=> false, 										// replace the default fullscreen with DFW (needs specific css)
						'tinymce' 			=> true, 										// load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
						'quicktags' 		=> true 										// load Quicktags, can be used to pass settings directly to Quicktags using an array()  
					),
				),
				array('name' => 'Background Color:', 'desc' => 'Define the background color for the break section.', 'id' => $prefixD . 'breakbackground', 'type' => 'colorpicker', 'default'  => '#ededed', 'repeatable' => false,),
				array(
					'name'    	=> 'Make Full Width:',
					'id'      	=> $prefixD . 'breakfull',
					'type'   	=> 'radio_inline',
					'default' 	=> 'false',
					'desc' 		=> 'Select if the break section should be made full width (both columns), or centered at half width.',
					'options' 	=> array(
						'true' 		=> __( 'Yes', 'cmb2' ),
						'false'   	=> __( 'No', 'cmb2' ),
					),
				),
				array('name' => 'You will be able to assign a font icon to the break when adding the break to a specific timeline in Visual Composer.', 'desc' => 'Aside from selecting an icon, you will also be able to define its color when adding this break to a timeline.', 'type' => 'title', 'id' => $prefixD . 'messageD'),
			),
		);
		
		// Event Link		
		$meta_boxes['ts_vcsc_timeline_link'] = array(
			'id'                		=> 'ts_vcsc_timeline_link',      	// meta box id, unique per meta box 
			'title'             		=> 'Event Link',          			// meta box title
			'pages'             		=> array('ts_timeline'),            // post types, accept custom post types as well, default is array('post'); optional
			'object_types' 				=> array('ts_timeline',),
			'context'           		=> 'normal',                        // where the meta box appear: normal (default), advanced, side; optional
			'priority'          		=> 'high',                          // order of meta box: high (default), low; optional
			'local_images'      		=> false,                           // Use local or hosted images (meta box images for add/remove)
			'use_with_theme'    		=> false,                           // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
			'show_names' 				=> true, 							// Show field names on the left
			'fields' 					=> array(
				array('name' => 'Event Page:', 'desc' => 'If existing, select a page that is dedicated to this particular event.', 'id' => $prefixE . 'dedicatedpage', 'type' => 'select', 'options' => $availablePages, 'std' => '-1'),
				array('name' => '<i class="dashicons dashicons-admin-links ts-post-font-icon"></i> External URL:', 'std' => '', 'desc' => '', 'id' => $prefixE . 'dedicatedlink', 'type' => 'text_url'),
				array(
					'name'    => 'Open in New Tab/Window:',
					'id'      => $prefixE . 'dedicatedtarget',
					'type'    => 'radio_inline',
					'desc' 		=> 'Check how the link should be opened.',
					'default' => 'true',
					'options' => array(
						'true' 		=> __( 'Yes', 'cmb2' ),
						'false'   	=> __( 'No', 'cmb2' ),
					),
				),				
				array(
					'name'    	=> 'Button Icon:',
					'desc'    	=> 'Select the icon that should be shown alongside the button label.',
					'id'      	=> $prefixE . 'dedicatedicon',
					'type'    	=> 'radio_inline',
					'std' 		=> 'none',
					'options' 	=> array(
						'visibility' 	=> '<i class="dashicons dashicons-visibility ts-post-font-icon"></i> ' . 'Eye',
						'info' 			=> '<i class="dashicons dashicons-info ts-post-font-icon"></i> ' . 'Info',
						'admin-links' 	=> '<i class="dashicons dashicons-admin-links ts-post-font-icon"></i> ' . 'Link',
						'search' 		=> '<i class="dashicons dashicons-search ts-post-font-icon"></i> ' . 'Search',
						'lightbulb'   	=> '<i class="dashicons dashicons-lightbulb ts-post-font-icon"></i> ' . 'Lightbulb',
						'admin-network'	=> '<i class="dashicons dashicons-admin-network ts-post-font-icon"></i> ' . 'Key',
						'book'   		=> '<i class="dashicons dashicons-book ts-post-font-icon"></i> ' . 'Boook',
						'awards'   		=> '<i class="dashicons dashicons-awards ts-post-font-icon"></i> ' . 'Award',
						'none'     		=> 'None',
					),
				),
				array('name' => 'Icon Color:', 'desc' => '', 'id' => $prefixE . 'dedicatedcolor', 'type' => 'colorpicker', 'default' => '#ffffff'),
				array('name' => 'Button Label:', 'std' => 'Read More', 'desc' => '', 'id' => $prefixE . 'dedicatedlabel', 'type' => 'text_medium'),
				array('name' => 'Button Tooltip:', 'std' => '', 'desc' => '', 'id' => $prefixE . 'dedicatedtooltip', 'type' => 'text'),
				array('name' => 'Button Width:', 'desc' => 'Define the button width in percent (%) of the available space.', 'default' => '100', 'id' => $prefixE . 'dedicatedwidth', 'type' => 'text_small', 'attributes' => array(
                    'type' 			=> 'number',
					'min'			=> 1,
					'max'			=> 100,
                ),),
				array( 
					'name'    => 'Button Alignment:',
					'desc'    => 'Select how the link button should be aligned.',
					'id'      => $prefixE . 'dedicatedalign',
					'type'    => 'select',
					'options' => array(
						"center" 						=> __( 'Center', "ts_visual_composer_extend" ),
						"left" 							=> __( 'Left', "ts_visual_composer_extend" ),
						"right" 						=> __( 'Right', "ts_visual_composer_extend" ),
					),
					'default' => 'center',
				),
				array( 
					'name'    => 'Button Default Style:',
					'desc'    => 'Select the default button style for the "Read More" Link.',
					'id'      => $prefixE . 'dedicateddefault',
					'type'    => 'select',
					'options' => array(
						"ts-dual-buttons-color-default"										=> __( 'No Style', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-sun-flower"									=> __( 'Sun Flower Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-orange-flat"									=> __( 'Orange Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-carrot-flat"									=> __( 'Carot Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-pumpkin-flat"								=> __( 'Pumpkin Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-alizarin-flat"								=> __( 'Alizarin Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-pomegranate-flat"							=> __( 'Pomegranate Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-turquoise-flat"								=> __( 'Turquoise Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-green-sea-flat"								=> __( 'Green Sea Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-emerald-flat"								=> __( 'Emerald Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-nephritis-flat"								=> __( 'Nephritis Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-peter-river-flat"							=> __( 'Peter River Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-belize-hole-flat"							=> __( 'Belize Hole Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-amethyst-flat"								=> __( 'Amethyst Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-wisteria-flat"								=> __( 'Wisteria Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-wet-asphalt-flat"							=> __( 'Wet Asphalt Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-midnight-blue-flat"							=> __( 'Midnight Blue Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-clouds-flat"									=> __( 'Clouds Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-silver-flat"									=> __( 'Silver Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-concrete-flat"								=> __( 'Concrete Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-asbestos-flat"								=> __( 'Asbestos Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-color-graphite-flat"								=> __( 'Graphite Flat', "ts_visual_composer_extend" ),
					),
					'default' => '',
				),
				array( 
					'name'    => 'Button Hover Style:',
					'desc'    => 'Select the hover button style for the "Read More" Link.',
					'id'      => $prefixE . 'dedicatedhover',
					'type'    => 'select',
					'options' => array(
						"ts-dual-buttons-preview-default ts-dual-buttons-hover-default"							=> __( 'No Style', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-sun-flower ts-dual-buttons-hover-sun-flower"					=> __( 'Sun Flower Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-orange-flat ts-dual-buttons-hover-orange-flat"					=> __( 'Orange Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-carrot-flat ts-dual-buttons-hover-carrot-flat"					=> __( 'Carot Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-pumpkin-flat ts-dual-buttons-hover-pumpkin-flat"				=> __( 'Pumpkin Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-alizarin-flat ts-dual-buttons-hover-alizarin-flat"				=> __( 'Alizarin Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-pomegranate-flat ts-dual-buttons-hover-pomegranate-flat"		=> __( 'Pomegranate Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-turquoise-flat ts-dual-buttons-hover-turquoise-flat"			=> __( 'Turquoise Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-green-sea-flat ts-dual-buttons-hover-green-sea-flat"			=> __( 'Green Sea Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-emerald-flat ts-dual-buttons-hover-emerald-flat"				=> __( 'Emerald Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-nephritis-flat ts-dual-buttons-hover-nephritis-flat"			=> __( 'Nephritis Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-peter-river-flat ts-dual-buttons-hover-peter-river-flat"		=> __( 'Peter River Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-belize-hole-flat ts-dual-buttons-hover-belize-hole-flat"		=> __( 'Belize Hole Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-amethyst-flat ts-dual-buttons-hover-amethyst-flat"				=> __( 'Amethyst Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-wisteria-flat ts-dual-buttons-hover-wisteria-flat"				=> __( 'Wisteria Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-wet-asphalt-flat ts-dual-buttons-hover-wet-asphalt-flat"		=> __( 'Wet Asphalt Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-midnight-blue-flat ts-dual-buttons-hover-midnight-blue-flat"	=> __( 'Midnight Blue Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-clouds-flat ts-dual-buttons-hover-clouds-flat"					=> __( 'Clouds Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-silver-flat ts-dual-buttons-hover-silver-flat"					=> __( 'Silver Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-concrete-flat ts-dual-buttons-hover-concrete-flat"				=> __( 'Concrete Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-asbestos-flat ts-dual-buttons-hover-asbestos-flat"				=> __( 'Asbestos Flat', "ts_visual_composer_extend" ),
						"ts-dual-buttons-preview-graphite-flat ts-dual-buttons-hover-graphite-flat"				=> __( 'Graphite Flat', "ts_visual_composer_extend" ),
					),
					'default' => '',
				),
			),
		);
		
		// Event Tooltip
		$meta_boxes['ts_vcsc_timeline_tooltip'] = array(
			'id'                		=> 'ts_vcsc_timeline_tooltip',      // meta box id, unique per meta box 
			'title'             		=> 'Event Tooltip',          		// meta box title
			'pages'             		=> array('ts_timeline'),            // post types, accept custom post types as well, default is array('post'); optional
			'object_types' 				=> array('ts_timeline',),
			'context'           		=> 'normal',                        // where the meta box appear: normal (default), advanced, side; optional
			'priority'          		=> 'high',                          // order of meta box: high (default), low; optional
			'local_images'      		=> false,                           // Use local or hosted images (meta box images for add/remove)
			'use_with_theme'    		=> false,                           // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
			'show_names' 				=> true, 							// Show field names on the left
			'fields' 					=> array(
				array('name' => 'If you want to provide some more information, but do not want to show it in the main content, you can use the optional tooltip for the timeline section.', 'desc' => 'The tooltip will be applied to the overall timeline section.', 'type' => 'title', 'id' => $prefixF . 'messageF'),
				array('name' => 'Tooltip Content:', 'desc' => 'Enter a tooltip for the timeline event. Basic HTML code can be used for styling.', 'default' => '', 'id' => $prefixF . 'tooltiptext', 'type' => 'textarea_code'),
				array( 
					'name'    => 'Tooltip Position:',
					'desc'    => 'Select the tooltip position.',
					'id'      => $prefixF . 'tooltipposition',
					'type'    => 'select',
					'options' => array(
						"top" 							=> __( 'Top', "ts_visual_composer_extend" ),
						"bottom" 						=> __( 'Bottom', "ts_visual_composer_extend" ),
					),
					'default' => 'top',
				),
				array( 
					'name'    => 'Tooltip Style:',
					'desc'    => 'Select the tooltip style.',
					'id'      => $prefixF . 'tooltipstyle',
					'type'    => 'select',
					'options' => array(
						"black" 						=> __( 'Black', "ts_visual_composer_extend" ),
						"gray" 							=> __( 'Gray', "ts_visual_composer_extend" ),
						"green" 						=> __( 'Green', "ts_visual_composer_extend" ),
						"blue" 							=> __( 'Blue', "ts_visual_composer_extend" ),
						"red" 							=> __( 'Red', "ts_visual_composer_extend" ),
						"orange" 						=> __( 'Orange', "ts_visual_composer_extend" ),
						"yellow" 						=> __( 'Yellow', "ts_visual_composer_extend" ),
						"purple" 						=> __( 'Purple', "ts_visual_composer_extend" ),
						"pink" 							=> __( 'Pink', "ts_visual_composer_extend" ),
						"white" 						=> __( 'White', "ts_visual_composer_extend" ),
					),
					'default' => 'black',
				),
			),
		);
		
		return $meta_boxes;
	}
	add_filter('cmb_meta_boxes', 'TS_VCSC_Timeline_Meta_Boxes');
	
	// Load Required JS+CSS Files
	function TS_VCSC_Timeline_Post_Files() {
		global $pagenow;		
		$screen = TS_VCSC_GetCurrentPostType();
		/*
		if (function_exists('get_current_screen')){
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
		}
		*/
		if ($screen == 'ts_timeline') {
			if ($pagenow == 'post-new.php' || $pagenow == 'post.php') {
				if (!wp_script_is('jquery')) {
					wp_enqueue_script('jquery');
				}
				wp_enqueue_style('ts-extend-uitotop');
				wp_enqueue_script('ts-extend-uitotop');
				wp_enqueue_script('jquery-easing');
				wp_enqueue_style('ts-font-teammates');
				wp_enqueue_style('ts-extend-select2');
				wp_enqueue_script('ts-extend-select2');
				wp_enqueue_style('ts-extend-posttypes');
				wp_enqueue_script('ts-extend-posttypes');
			}
		}
	}
	add_action('admin_enqueue_scripts', 						'TS_VCSC_Timeline_Post_Files', 				9999999999);
	
	// Add Featured Image Column
	//add_filter( 'manage_ts_timeline_posts_columns', 			'TS_VCSC_Add_Timeline_Image_Column' );
	//add_action( 'manage_ts_timeline_posts_custom_column', 	'TS_VCSC_Show_Timeline_Image_Column', 10, 2 );
	function TS_VCSC_Add_Timeline_Image_Column( $defaults ){
		$defaults = array_merge(
			array('ts_team_post_thumbs' => __('Thumbnail')),
			$defaults
		);
		return $defaults;
	}
	function TS_VCSC_Show_Timeline_Image_Column( $column_name, $id ) {
		if ( $column_name === 'ts_team_post_thumbs' ) {
			echo the_post_thumbnail('thumbnail');
		}
	}
?>