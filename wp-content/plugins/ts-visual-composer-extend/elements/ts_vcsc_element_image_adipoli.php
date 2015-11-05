<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
    if (function_exists('vc_map')) {
        vc_map( array(
            "name"                          => __( "TS Image Adipoli", "ts_visual_composer_extend" ),
            "base"                          => "TS-VCSC-Image-Adipoli",
            "icon"                          => "icon-wpb-ts_vcsc_image_adipoli",
            "class"                         => "ts_vcsc_main_image_adipoli",
            "category"                      => __( "VC Extensions", "ts_visual_composer_extend" ),
            "description" 		            => __("Place an image with Adipoli effects", "ts_visual_composer_extend"),
            "admin_enqueue_js"            	=> "",
            "admin_enqueue_css"           	=> "",
            "params"                        => array(
                // Image Selection
                array(
                    "type"                  => "seperator",
                    "heading"               => __( "", "ts_visual_composer_extend" ),
                    "param_name"            => "seperator_1",
					"value"					=> "",
                    "seperator"				=> "Image Selection",
                    "description"           => __( "", "ts_visual_composer_extend" )
                ),
                array(
                    "type"                  => "attach_image",
					"holder" 				=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? "img" : ""),
                    "heading"               => __( "Image", "ts_visual_composer_extend" ),
                    "param_name"            => "image",
					"class"					=> "ts_vcsc_holder_image",
                    "value"                 => "",
                    "admin_label"           => ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? false : true),
                    "description"           => __( "Select the image you want to use.", "ts_visual_composer_extend" )
                ),
				array(
					"type"             	 	=> "switch_button",
					"heading"			    => __( "Add Custom ALT Attribute", "ts_visual_composer_extend" ),
					"param_name"		    => "attribute_alt",
					"value"				    => "false",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"       	=> __( "Switch the toggle if you want add a custom ALT attribute value, otherwise file name will be set.", "ts_visual_composer_extend" ),
                    "dependency"        	=> ""
				),
                array(
                    "type"                  => "textfield",
                    "heading"               => __( "Enter ALT Value", "ts_visual_composer_extend" ),
                    "param_name"            => "attribute_alt_value",
                    "value"                 => "",
                    "description"           => __( "Enter a custom value for the ALT attribute for this image.", "ts_visual_composer_extend" ),
                    "dependency"            => array( 'element' => "attribute_alt", 'value' => 'true' )
                ),
                // Image Selection
                array(
                    "type"                  => "seperator",
                    "heading"               => __( "", "ts_visual_composer_extend" ),
                    "param_name"            => "seperator_2",
					"value"					=> "",
                    "seperator"				=> "Image Dimensions",
                    "description"           => __( "", "ts_visual_composer_extend" )
                ),
				array(
					"type"              	=> "switch_button",
                    "heading"               => __( "Responsive Width", "ts_visual_composer_extend" ),
                    "param_name"            => "image_responsive",
                    "value"                 => "true",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"description"           => __( "Use the toggle if you want to use images with a responsive width (in %).", "ts_visual_composer_extend" ),
					"dependency"        	=> ""
				),
                array(
                    "type"                  => "nouislider",
                    "heading"               => __( "Image Width", "ts_visual_composer_extend" ),
                    "param_name"            => "image_width_percent",
                    "value"                 => "100",
                    "min"                   => "1",
                    "max"                   => "100",
                    "step"                  => "1",
                    "unit"                  => '%',
                    "description"           => __( "Define the image width in %.", "ts_visual_composer_extend" ),
                    "dependency"            => array( 'element' => "image_responsive", 'value' => 'true' )
                ),
                array(
                    "type"                  => "nouislider",
                    "heading"               => __( "Image Width", "ts_visual_composer_extend" ),
                    "param_name"            => "image_width",
                    "value"                 => "300",
                    "min"                   => "100",
                    "max"                   => "1000",
                    "step"                  => "1",
                    "unit"                  => 'px',
                    "description"           => __( "Define the image width.", "ts_visual_composer_extend" ),
					"dependency"            => array( 'element' => "image_responsive", 'value' => 'false' )
                ),
                array(
                    "type"                  => "nouislider",
                    "heading"               => __( "Image Height", "ts_visual_composer_extend" ),
                    "param_name"            => "image_height",
                    "value"                 => "200",
                    "min"                   => "75",
                    "max"                   => "750",
                    "step"                  => "1",
                    "unit"                  => 'px',
                    "description"           => __( "Define the image height; image will be scaled to prevent distortion so actual height might be less.", "ts_visual_composer_extend" ),
                    "dependency"            => array( 'element' => "image_responsive", 'value' => 'false' )
                ),
                array(
                    "type"                  => "dropdown",
                    "heading"               => __( "Height Setting", "ts_visual_composer_extend" ),
                    "param_name"            => "image_height_r",
                    "width"                 => 150,
                    "value"                 => array(
                        __( '100% Height Setting', "ts_visual_composer_extend" )			=> "height: 100%;",
                        __( 'Auto Height Setting', "ts_visual_composer_extend" )     		=> "height: auto;",
                    ),
                    "description"           => __( "Select what CSS height setting should be applied to the image (change only if image height does not display correctly).", "ts_visual_composer_extend" ),
                    "dependency"            => array( 'element' => "image_responsive", 'value' => 'true' )
                ),
                array(
                    "type"                  => "dropdown",
                    "heading"               => __( "Image Position", "ts_visual_composer_extend" ),
                    "param_name"            => "image_position",
                    "width"                 => 300,
                    "value"                 => array(
						__( "Center", "ts_visual_composer_extend" )                         => "ts-imagefloat-center",
						__( "Float Left", "ts_visual_composer_extend" )                     => "ts-imagefloat-left",
						__( "Float Right", "ts_visual_composer_extend" )                    => "ts-imagefloat-right",
                    ),
                    "description"           => __( "Define how to position the image.", "ts_visual_composer_extend" )
                ),
                // Image Styles
                array(
                    "type"                  => "seperator",
                    "heading"               => __( "", "ts_visual_composer_extend" ),
                    "param_name"            => "seperator_3",
					"value"					=> "",
                    "seperator"				=> "Image Styles",
                    "description"           => __( "", "ts_visual_composer_extend" )
                ),
                array(
                    "type"                  => "dropdown",
                    "heading"               => __( "Start Style", "ts_visual_composer_extend" ),
                    "param_name"            => "adipoli_start",
                    "width"                 => 300,
                    "value"                 => array(
						__( "Grayscale (CSS3)", "ts_visual_composer_extend" )               => "grayscale",
						__( "Washout", "ts_visual_composer_extend" )                        => "transparent",
						__( "Simple Overlay", "ts_visual_composer_extend" )                 => "overlay",
                    ),
                    "admin_label"           => true,
                    "description"           => __( "Select the default style for the image.", "ts_visual_composer_extend" )
                ),
                array(
                    "type"                  => "textarea",
                    "class"                 => "",
                    "heading"               => __( "Overlay Text", "ts_visual_composer_extend" ),
                    "param_name"            => "adipoli_text",
                    "value"                 => "",
                    "dependency"            => array( 'element' => "adipoli_start", 'value' => 'overlay' )
                ),
                array(
                    "type"                  => "dropdown",
                    "heading"               => __( "Hover Style", "ts_visual_composer_extend" ),
                    "param_name"            => "adipoli_hover",
                    "width"                 => 300,
                    "value"                 => array(
						__( "Normal", "ts_visual_composer_extend" )                         => "normal",
						__( "Popout", "ts_visual_composer_extend" )                        	=> "popout",
						__( "Slice Down", "ts_visual_composer_extend" )                    	=> "sliceDown",
						__( "Slice Down Left", "ts_visual_composer_extend" )               	=> "sliceDownLeft",
						__( "Slice Up", "ts_visual_composer_extend" )                      	=> "sliceUp",
						__( "Slice Up Left", "ts_visual_composer_extend" )                 	=> "sliceUpLeft",
						__( "Slice Up Random", "ts_visual_composer_extend" )               	=> "sliceUpRandom",
						__( "Slice Up Down", "ts_visual_composer_extend" )                 	=> "sliceUpDown",
						__( "Slice Up Down Left", "ts_visual_composer_extend" )            	=> "sliceUpDownLeft",
						__( "Fold", "ts_visual_composer_extend" )                          	=> "fold",
						__( "Fold Left", "ts_visual_composer_extend" )                     	=> "foldLeft",
						__( "Box Random", "ts_visual_composer_extend" )                    	=> "boxRandom",
						__( "Box Rain", "ts_visual_composer_extend" )                      	=> "boxRain",
						__( "Box Rain Reverse", "ts_visual_composer_extend" )              	=> "boxRainReverse",
						__( "Box Rain Grow", "ts_visual_composer_extend" )                 	=> "boxRainGrow",
						__( "Box Rain Grow Reverse", "ts_visual_composer_extend" )         	=> "boxRainGrowReverse",
                    ),
                    "admin_label"           => true,
                    "description"           => __( "Select the hover style for the image.", "ts_visual_composer_extend" )
                ),
				array(
					"type"             	 	=> "switch_button",
                    "heading"               => __( "Show Adipoli Handle", "ts_visual_composer_extend" ),
                    "param_name"            => "adipoli_handle_show",
                    "value"                 => "true",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"       	=> __( "Use the toggle to show or hide a handle button below the image.", "ts_visual_composer_extend" ),
                    "dependency"        	=> ""
				),
                array(
                    "type"                  => "colorpicker",
                    "heading"               => __( "Handle Color", "ts_visual_composer_extend" ),
                    "param_name"            => "adipoli_handle_color",
                    "value"                 => "#0094FF",
                    "description"           => __( "Define the color for the Adipoli handle button.", "ts_visual_composer_extend" ),
                    "dependency"            => array( 'element' => "adipoli_handle_show", 'value' => 'true' )
                ),
                // Image Link
                array(
                    "type"                  => "seperator",
                    "heading"               => __( "", "ts_visual_composer_extend" ),
                    "param_name"            => "seperator_4",
					"value"					=> "",
                    "seperator"				=> "Image Link",
                    "description"           => __( "", "ts_visual_composer_extend" )
                ),
				array(
					"type"             	 	=> "switch_button",
                    "heading"               => __( "Add Link to Image", "ts_visual_composer_extend" ),
                    "param_name"            => "link_apply",
                    "value"                 => "false",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"       	=> __( "Switch the toggle if you want to apply a link to the image.", "ts_visual_composer_extend" ),
                    "dependency"        	=> ""
				),
                array(
                    "type"                  => "textfield",
                    "class"			        => "",
                    "heading"               => __( "Button: URL", "ts_visual_composer_extend" ),
                    "param_name"	        => "link_url",
                    "value"			        => "",
                    "description"	        => __( "Enter the URL for the image link (start with http://).", "ts_visual_composer_extend" ),
                    "dependency"            => array( 'element' => "link_apply", 'value' => 'true' )
                ),
                array(
                    "type"			        => "dropdown",
                    "class"			        => "",
                    "heading"               => __( "Button: Link Target", "ts_visual_composer_extend" ),
                    "param_name"	        => "link_target",
                    "value"                 => array(
						__( "Same Window", "ts_visual_composer_extend" )                   => "_parent",
						__( "New Window", "ts_visual_composer_extend" )                    => "_blank"
                    ),
                    "description"	        => __( "Select how the image link should be opened.", "ts_visual_composer_extend" ),
                    "dependency"            => array( 'element' => "link_apply", 'value' => 'true' )
                ),
                // Image Tooltip
                array(
                    "type"                  => "seperator",
                    "heading"               => __( "", "ts_visual_composer_extend" ),
                    "param_name"            => "seperator_5",
					"value"					=> "",
                    "seperator"				=> "Image Tooltip",
                    "description"           => __( "", "ts_visual_composer_extend" ),
					"group" 				=> "Tooltip Settings",
                ),
				array(
					"type"             	 	=> "switch_button",
                    "heading"               => __( "Use Advanced Tooltip", "ts_visual_composer_extend" ),
                    "param_name"            => "tooltip_css",
                    "value"                 => "false",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"       	=> __( "Switch the toggle if you want to apply am advanced tooltip to the image.", "ts_visual_composer_extend" ),
                    "dependency"        	=> "",
					"group" 				=> "Tooltip Settings",
				),
                array(
                    "type"                  => "textarea",
                    "class"                 => "",
                    "heading"               => __( "Tooltip Content", "ts_visual_composer_extend" ),
                    "param_name"            => "tooltip_content",
                    "value"                 => "",
                    "description"           => __( "Enter the tooltip content here (do not use quotation marks).", "ts_visual_composer_extend" ),
                    "dependency"            => "",
					"group" 				=> "Tooltip Settings",
                ),
                array(
                    "type"			        => "dropdown",
                    "class"			        => "",
                    "heading"               => __( "Tooltip Style", "ts_visual_composer_extend" ),
                    "param_name"	        => "tooltip_style",
                    "value"                 => array(
						__( "Black", "ts_visual_composer_extend" )                         => "",
						__( "Gray", "ts_visual_composer_extend" )                          => "ts-simptip-style-gray",
						__( "Green", "ts_visual_composer_extend" )                         => "ts-simptip-style-green",
						__( "Blue", "ts_visual_composer_extend" )                          => "ts-simptip-style-blue",
						__( "Red", "ts_visual_composer_extend" )                           => "ts-simptip-style-red",
						__( "Orange", "ts_visual_composer_extend" )                        => "ts-simptip-style-orange",
						__( "Yellow", "ts_visual_composer_extend" )                        => "ts-simptip-style-yellow",
						__( "Purple", "ts_visual_composer_extend" )                        => "ts-simptip-style-purple",
						__( "Pink", "ts_visual_composer_extend" )                          => "ts-simptip-style-pink",
						__( "White", "ts_visual_composer_extend" )                         => "ts-simptip-style-white"
                    ),
                    "description"           => __( "Select the tooltip style.", "ts_visual_composer_extend" ),
                    "dependency"            => array( 'element' => "tooltip_css", 'value' => 'true' ),
					"group" 				=> "Tooltip Settings",
                ),
                // Other Settings
                array(
                    "type"                  => "seperator",
                    "heading"               => __( "", "ts_visual_composer_extend" ),
                    "param_name"            => "seperator_6",
					"value"					=> "",
                    "seperator"				=> "Other Settings",
                    "description"           => __( "", "ts_visual_composer_extend" ),
					"group" 				=> "Other Settings",
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
					"group" 				=> "Other Settings",
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
					"group" 				=> "Other Settings",
                ),
                array(
                    "type"                  => "textfield",
                    "heading"               => __( "Define ID Name", "ts_visual_composer_extend" ),
                    "param_name"            => "el_id",
                    "value"                 => "",
                    "description"           => __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
					"group" 				=> "Other Settings",
                ),
                array(
                    "type"                  => "textfield",
                    "heading"               => __( "Extra Class Name", "ts_visual_composer_extend" ),
                    "param_name"            => "el_class",
                    "value"                 => "",
                    "description"           => __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
					"group" 				=> "Other Settings",
                ),
                // Load Custom CSS/JS File
                array(
                    "type"                  => "load_file",
                    "heading"               => __( "", "ts_visual_composer_extend" ),
                    "param_name"            => "el_file",
                    "value"                 => "",
                    "file_type"             => "js",
                    "file_path"             => "js/ts-visual-composer-extend-element.min.js",
                    "description"           => __( "", "ts_visual_composer_extend" )
                ),
            )
        ));
    }
?>