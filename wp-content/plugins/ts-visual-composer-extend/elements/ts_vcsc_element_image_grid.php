<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
    if (function_exists('vc_map')) {
        vc_map( array(
            "name"                      	=> __( "TS Image Link Grid", "ts_visual_composer_extend" ),
            "base"                      	=> "TS_VCSC_Image_Link_Grid",
            "icon" 	                    	=> "icon-wpb-ts_vcsc_image_link_grid",
            "class"                         => "ts_vcsc_main_lightbox_gallery",
            "category"                  	=> __( "VC Extensions", "ts_visual_composer_extend" ),
            "description"               	=> __("Place a grid with image links", "ts_visual_composer_extend"),
            "admin_enqueue_js"        		=> "",
            "admin_enqueue_css"       		=> "",
            "params"                    	=> array(
                // Grid Settings
				array(
					"type"                  => "seperator",
					"heading"               => __( "", "ts_visual_composer_extend" ),
					"param_name"            => "seperator_1",
					"value"					=> "",
					"seperator"				=> "Gallery Content",
					"description"           => __( "", "ts_visual_composer_extend" )
				),
				array(
					"type"                  => "attach_images",
					"heading"               => __( "Select Images", "ts_visual_composer_extend" ),
					"holder"				=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? "imagelist" : ""),
					"param_name"            => "content_images",
					"value"                 => "",
					"admin_label"           => ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? false : true),
					"description"           => __( "Select the images for your link grid; move images to arrange order in which to display.", "ts_visual_composer_extend" ),
				),
				array(
					"type"                  => "dropdown",
					"heading"               => __( "Image Source", "ts_visual_composer_extend" ),
					"param_name"            => "content_images_size",
					"width"                 => 150,
					"value"                 => array(
						__( 'Medium Size Image', "ts_visual_composer_extend" )		=> "medium",
						__( 'Large Size Image', "ts_visual_composer_extend" )			=> "large",
						__( 'Full Size Image', "ts_visual_composer_extend" )			=> "full",
					),
					"admin_label"           => true,
					"description"           => __( "Select which image size based on WordPress settings should be used for the preview image.", "ts_visual_composer_extend" ),
					"dependency"            => ""
				),
				// Title Settings
				array(
					"type"                  => "exploded_textarea",
					"heading"               => __( "Image Titles", "ts_visual_composer_extend" ),
					"param_name"            => "content_images_titles",
					"value"                 => "",
					"description"           => __( "Enter titles for images; seperate individual images by line break; use an empty line for image without title.", "ts_visual_composer_extend" ),
					"dependency"            => ""
				),
				array(
					"type"              	=> "switch_button",
					"heading"			    => __( "Always Show Post Title", "ts_visual_composer_extend" ),
					"param_name"		    => "data_grid_always",
					"value"				    => "true",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"description"		    => __( "Switch the toggle to always show the post title with the post image.", "ts_visual_composer_extend" ),
				),	
				// Link Settings
				array(
					"type"                  => "seperator",
					"heading"               => __( "", "ts_visual_composer_extend" ),
					"param_name"            => "seperator_2",
					"value"					=> "",
					"seperator"				=> "Link Settings",
					"description"           => __( "", "ts_visual_composer_extend" ),
					"group" 				=> "Link Settings",
				),
				array(
					"type"                  => "exploded_textarea",
					"heading"               => __( "Image Links", "ts_visual_composer_extend" ),
					"param_name"            => "content_images_links",
					"value"                 => "",
					"description"           => __( "Enter links for images; seperate individual images by line break; use an empty line for image without link.", "ts_visual_composer_extend" ),
					"dependency"            => "",
					"group" 				=> "Link Settings",
				),
				array(
					"type"              	=> "dropdown",
					"heading"           	=> __( "Link Target", "ts_visual_composer_extend" ),
					"param_name"        	=> "data_grid_target",
					"value"             	=> array(
						__( "New Window", "ts_visual_composer_extend" )                     		=> "_blank",
						__( "Same Window", "ts_visual_composer_extend" )                    		=> "_parent",
					),
					"description"       	=> __( "Select how the links should be opened.", "ts_visual_composer_extend" ),
					"dependency"            => "",
					"group" 				=> "Link Settings",
				),				
				array(
					"type"              	=> "dropdown",
					"heading"           	=> __( "None-Link Images", "ts_visual_composer_extend" ),
					"param_name"        	=> "data_grid_invalid",
					"value"             	=> array(
						__( "Exclude from Grid", "ts_visual_composer_extend" )                     	=> "exclude",
						__( "Show Image and Open in Lightbox", "ts_visual_composer_extend" )		=> "lightbox",
						__( "Show Image without Click Event", "ts_visual_composer_extend" )			=> "display",
					),
					"description"       	=> __( "Select how images without links should be treated.", "ts_visual_composer_extend" ),
					"admin_label"           => true,
					"group" 				=> "Link Settings",
				),
				// Grid Settings
				array(
					"type"                  => "seperator",
					"heading"               => __( "", "ts_visual_composer_extend" ),
					"param_name"            => "seperator_3",
					"value"					=> "",
					"seperator"				=> "Grid Settings",
					"description"           => __( "", "ts_visual_composer_extend" ),
					"group" 				=> "Grid Settings",
				),
				array(
					"type"              	=> "dropdown",
					"heading"           	=> __( "Grid Render Machine", "ts_visual_composer_extend" ),
					"param_name"        	=> "data_grid_machine",
					"value"             	=> array(
						__( "Rectangle Auto Image Link Grid", "ts_visual_composer_extend" )				=> "internal",
						__( "Freewall Fluid Image Link Grid", "ts_visual_composer_extend" )				=> "freewall",
					),
					"admin_label"       	=> true,
					"description"       	=> __( "Select which script should be used to render the grid layout.", "ts_visual_composer_extend" ),
					"group" 				=> "Grid Settings"
				),
				array(
					"type"                  => "textfield",
					"heading"               => __( "Grid Break Points", "ts_visual_composer_extend" ),
					"param_name"            => "data_grid_breaks",
					"value"                 => "240,480,720,960",
					"description"           => __( "Define the break points (columns) for the grid based on available screen size; seperate by comma.", "ts_visual_composer_extend" ),
					"admin_label"           => true,
					"dependency" 			=> array("element" 	=> "data_grid_machine", "value" => "internal"),
					"group" 				=> "Grid Settings"
				),
				array(
					"type"                  => "nouislider",
					"heading"               => __( "Item Width", "ts_visual_composer_extend" ),
					"param_name"            => "data_grid_width",
					"value"                 => "250",
					"min"                   => "100",
					"max"                   => "500",
					"step"                  => "1",
					"unit"                  => 'px',
					"description"           => __( "Define the desired width of each image in the grid; will be adjusted if necessary.", "ts_visual_composer_extend" ),
					"dependency" 			=> array("element" 	=> "data_grid_machine", "value" => "freewall"),
					"group" 				=> "Grid Settings"
				),
				array(
					"type"                  => "nouislider",
					"heading"               => __( "Grid Space", "ts_visual_composer_extend" ),
					"param_name"            => "data_grid_space",
					"value"                 => "2",
					"min"                   => "0",
					"max"                   => "20",
					"step"                  => "1",
					"unit"                  => 'px',
					"description"           => __( "Define the space between images in grid.", "ts_visual_composer_extend" ),
					"admin_label"           => true,
					"group" 				=> "Grid Settings"
				),
				array(
					"type"              	=> "switch_button",
					"heading"			    => __( "Maintain Image Order", "ts_visual_composer_extend" ),
					"param_name"		    => "data_grid_order",
					"value"				    => "false",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"description"		    => __( "Switch the toggle to keep original image order in grid; it is adviced to have the plugin determine order for best layout.", "ts_visual_composer_extend" ),
					"dependency" 			=> array("element" 	=> "data_grid_machine", "value" => "internal"),
					"group" 				=> "Grid Settings"
				),
				array(
					"type"              	=> "switch_button",
					"heading"               => __( "Make Grid Full-Width", "ts_visual_composer_extend" ),
					"param_name"            => "fullwidth",
					"value"                 => "false",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"description"           => __( "Switch the toggle if you want to attempt showing the gallery in full width (will not work with all themes).", "ts_visual_composer_extend" ),
					"admin_label"           => true,
					"group" 				=> "Grid Settings"
				),
				array(
					"type"                  => "nouislider",
					"heading"               => __( "Full Grid Breakouts", "ts_visual_composer_extend" ),
					"param_name"            => "breakouts",
					"value"                 => "6",
					"min"                   => "0",
					"max"                   => "99",
					"step"                  => "1",
					"unit"                  => '',
					"description"           => __( "Define the number of parent containers the gallery should attempt to break away from.", "ts_visual_composer_extend" ),
					"dependency"            => array( 'element' => "fullwidth", 'value' => 'true' ),
					"group" 				=> "Grid Settings"
				),				
				// Filter Settings
				array(
					"type"                  => "seperator",
					"heading"               => __( "", "ts_visual_composer_extend" ),
					"param_name"            => "seperator_4",
					"value"					=> "",
					"seperator"				=> "Filter Settings",
					"description"           => __( "", "ts_visual_composer_extend" ),
					"group" 				=> "Filter Settings",
				),
				array(
					"type"                  => "exploded_textarea",
					"heading"               => __( "Image Groups", "ts_visual_composer_extend" ),
					"param_name"            => "content_images_groups",
					"value"                 => "",
					"description"           => __( "Enter groups or categories for images; seperate multiple groups for one image with '/' and individual images by line break; use an empty line for image without group.", "ts_visual_composer_extend" ),
					"dependency"            => "",
					"group" 				=> "Filter Settings",
				),
				array(
					"type"                  => "textfield",
					"heading"               => __( "Filter Toggle: Text", "ts_visual_composer_extend" ),
					"param_name"            => "filters_toggle",
					"value"                 => "Toggle Filter",
					"description"           => __( "Enter a text to be used for the filter button.", "ts_visual_composer_extend" ),
					"dependency"            => "",
					"group" 				=> "Filter Settings",
				),
				array(
					"type"                  => "dropdown",
					"heading"               => __( "Filter Toggle: Style", "ts_visual_composer_extend" ),
					"param_name"            => "filters_toggle_style",
					"width"                 => 150,
					"value"                 => array(
						__( 'No Style', "ts_visual_composer_extend" )				=> "",
						__( 'Sun Flower Flat', "ts_visual_composer_extend" )		=> "ts-color-button-sun-flower",
						__( 'Orange Flat', "ts_visual_composer_extend" )			=> "ts-color-button-orange-flat",
						__( 'Carot Flat', "ts_visual_composer_extend" )     		=> "ts-color-button-carrot-flat",
						__( 'Pumpkin Flat', "ts_visual_composer_extend" )			=> "ts-color-button-pumpkin-flat",
						__( 'Alizarin Flat', "ts_visual_composer_extend" )			=> "ts-color-button-alizarin-flat",
						__( 'Pomegranate Flat', "ts_visual_composer_extend" )		=> "ts-color-button-pomegranate-flat",
						__( 'Turquoise Flat', "ts_visual_composer_extend" )			=> "ts-color-button-turquoise-flat",
						__( 'Green Sea Flat', "ts_visual_composer_extend" )			=> "ts-color-button-green-sea-flat",
						__( 'Emerald Flat', "ts_visual_composer_extend" )			=> "ts-color-button-emerald-flat",
						__( 'Nephritis Flat', "ts_visual_composer_extend" )			=> "ts-color-button-nephritis-flat",
						__( 'Peter River Flat', "ts_visual_composer_extend" )		=> "ts-color-button-peter-river-flat",
						__( 'Belize Hole Flat', "ts_visual_composer_extend" )		=> "ts-color-button-belize-hole-flat",
						__( 'Amethyst Flat', "ts_visual_composer_extend" )			=> "ts-color-button-amethyst-flat",
						__( 'Wisteria Flat', "ts_visual_composer_extend" )			=> "ts-color-button-wisteria-flat",
						__( 'Wet Asphalt Flat', "ts_visual_composer_extend" )		=> "ts-color-button-wet-asphalt-flat",
						__( 'Midnight Blue Flat', "ts_visual_composer_extend" )		=> "ts-color-button-midnight-blue-flat",
						__( 'Clouds Flat', "ts_visual_composer_extend" )			=> "ts-color-button-clouds-flat",
						__( 'Silver Flat', "ts_visual_composer_extend" )			=> "ts-color-button-silver-flat",
						__( 'Concrete Flat', "ts_visual_composer_extend" )			=> "ts-color-button-concrete-flat",
						__( 'Asbestos Flat', "ts_visual_composer_extend" )			=> "ts-color-button-asbestos-flat",
						__( 'Graphite Flat', "ts_visual_composer_extend" )			=> "ts-color-button-graphite-flat",
					),
					"description"           => __( "Select the color scheme for the filter button.", "ts_visual_composer_extend" ),
					"dependency"            => "",
					"group" 				=> "Filter Settings",
				),						
				array(
					"type"                  => "textfield",
					"heading"               => __( "Show All Toggle: Text", "ts_visual_composer_extend" ),
					"param_name"            => "filters_showall",
					"value"                 => "Show All",
					"description"           => __( "Enter a text to be used for the show all button.", "ts_visual_composer_extend" ),
					"dependency"            => "",
					"group" 				=> "Filter Settings",
				),
				array(
					"type"                  => "dropdown",
					"heading"               => __( "Show All Toggle: Style", "ts_visual_composer_extend" ),
					"param_name"            => "filters_showall_style",
					"width"                 => 150,
					"value"                 => array(
						__( 'No Style', "ts_visual_composer_extend" )				=> "",
						__( 'Sun Flower Flat', "ts_visual_composer_extend" )		=> "ts-color-button-sun-flower",
						__( 'Orange Flat', "ts_visual_composer_extend" )			=> "ts-color-button-orange-flat",
						__( 'Carot Flat', "ts_visual_composer_extend" )     		=> "ts-color-button-carrot-flat",
						__( 'Pumpkin Flat', "ts_visual_composer_extend" )			=> "ts-color-button-pumpkin-flat",
						__( 'Alizarin Flat', "ts_visual_composer_extend" )			=> "ts-color-button-alizarin-flat",
						__( 'Pomegranate Flat', "ts_visual_composer_extend" )		=> "ts-color-button-pomegranate-flat",
						__( 'Turquoise Flat', "ts_visual_composer_extend" )			=> "ts-color-button-turquoise-flat",
						__( 'Green Sea Flat', "ts_visual_composer_extend" )			=> "ts-color-button-green-sea-flat",
						__( 'Emerald Flat', "ts_visual_composer_extend" )			=> "ts-color-button-emerald-flat",
						__( 'Nephritis Flat', "ts_visual_composer_extend" )			=> "ts-color-button-nephritis-flat",
						__( 'Peter River Flat', "ts_visual_composer_extend" )		=> "ts-color-button-peter-river-flat",
						__( 'Belize Hole Flat', "ts_visual_composer_extend" )		=> "ts-color-button-belize-hole-flat",
						__( 'Amethyst Flat', "ts_visual_composer_extend" )			=> "ts-color-button-amethyst-flat",
						__( 'Wisteria Flat', "ts_visual_composer_extend" )			=> "ts-color-button-wisteria-flat",
						__( 'Wet Asphalt Flat', "ts_visual_composer_extend" )		=> "ts-color-button-wet-asphalt-flat",
						__( 'Midnight Blue Flat', "ts_visual_composer_extend" )		=> "ts-color-button-midnight-blue-flat",
						__( 'Clouds Flat', "ts_visual_composer_extend" )			=> "ts-color-button-clouds-flat",
						__( 'Silver Flat', "ts_visual_composer_extend" )			=> "ts-color-button-silver-flat",
						__( 'Concrete Flat', "ts_visual_composer_extend" )			=> "ts-color-button-concrete-flat",
						__( 'Asbestos Flat', "ts_visual_composer_extend" )			=> "ts-color-button-asbestos-flat",
						__( 'Graphite Flat', "ts_visual_composer_extend" )			=> "ts-color-button-graphite-flat",
					),
					"description"           => __( "Select the color scheme for the show all button.", "ts_visual_composer_extend" ),
					"dependency"            => "",
					"group" 				=> "Filter Settings",
				),	
				array(
					"type"                  => "textfield",
					"heading"               => __( "Text: Available Groups", "ts_visual_composer_extend" ),
					"param_name"            => "filters_available",
					"value"                 => "Available Groups",
					"description"           => __( "Enter a text to be used a header for the section with the available groups.", "ts_visual_composer_extend" ),
					"dependency"            => "",
					"group" 				=> "Filter Settings",
				),
				array(
					"type"                  => "textfield",
					"heading"               => __( "Text: Selected Groups", "ts_visual_composer_extend" ),
					"param_name"            => "filters_selected",
					"value"                 => "Filtered Groups",
					"description"           => __( "Enter a text to be used a header for the section with the selected groups.", "ts_visual_composer_extend" ),
					"dependency"            => "",
					"group" 				=> "Filter Settings",
				),
				array(
					"type"                  => "textfield",
					"heading"               => __( "Text: Ungrouped Images", "ts_visual_composer_extend" ),
					"param_name"            => "filters_nogroups",
					"value"                 => "No Groups",
					"description"           => __( "Enter a text to be used to group images without any other groups applied to it.", "ts_visual_composer_extend" ),
					"dependency"            => "",
					"group" 				=> "Filter Settings",
				),
				// Other Settings
				array(
					"type"                  => "seperator",
					"heading"               => __( "", "ts_visual_composer_extend" ),
					"param_name"            => "seperator_5",
					"value"					=> "",
					"seperator"				=> "Other Settings",
					"description"           => __( "", "ts_visual_composer_extend" ),
					"group" 				=> "Other",
				),
				array(
					"type"                  => "nouislider",
					"heading"               => __( "Margin: Top", "ts_visual_composer_extend" ),
					"param_name"            => "margin_top",
					"value"                 => "0",
					"min"                   => "0",
					"max"                   => "200",
					"step"                  => "1",
					"unit"                  => 'px',
					"description"           => __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
					"group" 				=> "Other",
				),
				array(
					"type"                  => "nouislider",
					"heading"               => __( "Margin: Bottom", "ts_visual_composer_extend" ),
					"param_name"            => "margin_bottom",
					"value"                 => "0",
					"min"                   => "0",
					"max"                   => "200",
					"step"                  => "1",
					"unit"                  => 'px',
					"description"           => __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
					"group" 				=> "Other",
				),
				array(
					"type"                  => "textfield",
					"heading"               => __( "Define ID Name", "ts_visual_composer_extend" ),
					"param_name"            => "el_id",
					"value"                 => "",
					"description"           => __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
					"group" 				=> "Other",
				),
				array(
					"type"                  => "textfield",
					"heading"               => __( "Extra Class Name", "ts_visual_composer_extend" ),
					"param_name"            => "el_class",
					"value"                 => "",
					"description"           => __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
					"group" 				=> "Other",
				),
				// Load Custom CSS/JS File
				array(
					"type"              => "load_file",
					"heading"           => __( "", "ts_visual_composer_extend" ),
                    "param_name"        => "el_file",
					"value"             => "",
					"file_type"         => "js",
					"file_path"         => "js/ts-visual-composer-extend-element.min.js",
					"description"       => __( "", "ts_visual_composer_extend" )
				),
            ))
        );
    }

	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_Image_Link_Grid extends WPBakeryShortCode {
			public function singleParamHtmlHolder($param, $value, $settings = Array(), $atts = Array()) {
				$output 		= '';
				// Compatibility fixes
				$old_names 		= array('yellow_message', 'blue_message', 'green_message', 'button_green', 'button_grey', 'button_yellow', 'button_blue', 'button_red', 'button_orange');
				$new_names 		= array('alert-block', 'alert-info', 'alert-success', 'btn-success', 'btn', 'btn-info', 'btn-primary', 'btn-danger', 'btn-warning');
				$value 			= str_ireplace($old_names, $new_names, $value);
				//$value 		= __($value, "ts_visual_composer_extend");
				//
				$param_name 	= isset($param['param_name']) ? $param['param_name'] : '';
				$heading 		= isset($param['heading']) ? $param['heading'] : '';
				$type 			= isset($param['type']) ? $param['type'] : '';
				$class 			= isset($param['class']) ? $param['class'] : '';
	
				if (isset($param['holder']) === true && in_array($param['holder'], array('div', 'span', 'p', 'pre', 'code'))) {
					$output .= '<'.$param['holder'].' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '">'.$value.'</'.$param['holder'].'>';
				} else if (isset($param['holder']) === true && $param['holder'] == 'input') {
					$output .= '<'.$param['holder'].' readonly="true" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.$value.'">';
				} else if (isset($param['holder']) === true && in_array($param['holder'], array('img', 'iframe'))) {
					if (!empty($value)) {
						$output .= '<'.$param['holder'].' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" src="'.$value.'">';
					}
				} else if (isset($param['holder']) === true && $param['holder'] == 'imagelist') {
					$images_ids = empty($value) ? array() : explode(',', trim($value));
					$output .= '<ul style="margin-top: 5px;" class="attachment-thumbnails'.(empty($images_ids) ? ' image-exists' : '' ).'" data-name="' . $param_name . '">';
						foreach($images_ids as $image) {
							$img = wpb_getImageBySize(array( 'attach_id' => (int)$image, 'thumb_size' => 'thumbnail' ));
							$output .= ( $img ? '<li>'.$img['thumbnail'].'</li>' : '<li><img width="150" height="150" test="'.$image.'" src="' . WPBakeryVisualComposer::getInstance()->assetURL('vc/blank.gif') . '" class="attachment-thumbnail" alt="" title="" /></li>');
						}
					$output .= '</ul>';
					$output .= '<a style="max-width: 100%; display: block;" href="#" class="column_edit_trigger' . ( !empty($images_ids) ? ' image-exists' : '' ) . '" style="margin-bottom: 10px;">' . __( 'Add or Remove Image(s)', "ts_visual_composer_extend" ) . '</a>';
				}
				
				if (isset($param['admin_label']) && $param['admin_label'] === true) {
					$output .= '<span style="max-width: 100%; display: block;" class="vc_admin_label admin_label_'.$param['param_name'].(empty($value) ? ' hidden-label' : '').'"><label>'. $param['heading'] . '</label>: '.$value.'</span>';
				}
	
				return $output;
			}
		}
	}
?>