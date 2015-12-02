<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
    if (function_exists('vc_map')) {
        vc_map( array(
            "name"                      => __( "TS Processes", "ts_visual_composer_extend" ),
            "base"                      => "TS-VCSC-Timeline",
            "icon"						=> "icon-wpb-ts_vcsc_processes",
            "class"                     => "",
            "category"                  => __( "VC Extensions", "ts_visual_composer_extend" ),
            "description"               => __("Place a process line element", "ts_visual_composer_extend"),
            "admin_enqueue_js"        	=> "",
            "admin_enqueue_css"       	=> "",
            "params"                    => array(
                // Timeline Settings
                array(
                    "type"              => "seperator",
                    "heading"           => __( "", "ts_visual_composer_extend" ),
                    "param_name"        => "seperator_1",
					"value"				=> "",
                    "seperator"			=> "Timeline / Process Settings",
                    "description"       => __( "", "ts_visual_composer_extend" )
                ),
				array(
					"type"              => "dropdown",
					"heading"           => __( "Timeline / Process Style", "ts_visual_composer_extend" ),
					"param_name"        => "timeline_style",
					"width"             => 300,
					"value"             => array(
						__( 'Style 1', "ts_visual_composer_extend" )      => "style1",
                        __( 'Style 2', "ts_visual_composer_extend" )      => "style2",
                        __( 'Style 3', "ts_visual_composer_extend" )      => "style3",
					),
                    "admin_label"       => true,
					"description"       => __( "Select the timeline / process style.", "ts_visual_composer_extend" )
				),
				array(
					"type"              => "dropdown",
					"heading"           => __( "Color Pattern", "ts_visual_composer_extend" ),
					"param_name"        => "timeline_pattern",
					"width"             => 300,
					"value"             => array(
						__( 'Light', "ts_visual_composer_extend" )        => "light",
                        __( 'Dark', "ts_visual_composer_extend" )         => "dark",
                        __( 'Blue', "ts_visual_composer_extend" )         => "blue",
                        __( 'Red', "ts_visual_composer_extend" )          => "red",
					),
					"description"       => __( "Select the color pattern; setting will be applied for top element only.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "timeline_style", 'value' => array('style2') )
				),
				array(
					"type"              => "dropdown",
					"heading"           => __( "Element Position", "ts_visual_composer_extend" ),
					"param_name"        => "timeline_ulwrap",
					"width"             => 300,
					"value"             => array(
						__( 'Default Element', "ts_visual_composer_extend" )          => "default",
                        __( 'Top / First Element', "ts_visual_composer_extend" )      => "top",
                        __( 'Bottom / Last Element', "ts_visual_composer_extend" )    => "bottom",
					),
                    "admin_label"       => true,
					"description"       => __( "Select the element position within the timeline / process.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "timeline_style", 'value' => array('style2', 'style3') )
				),
				array(
					"type"              => "switch_button",
					"heading"           => __( "Timeline / Process Bottom", "ts_visual_composer_extend" ),
					"param_name"        => "timeline_bottom",
					"value"             => "false",
					"on"				=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"				=> __( 'No', "ts_visual_composer_extend" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
                    "description"       => __( "Switch the toggle to mark the bottom element of the timeline / process.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "timeline_style", 'value' => array('style1') )
				),
				array(
					"type"              => "switch_button",
					"heading"           => __( "Bottom Connector", "ts_visual_composer_extend" ),
					"param_name"        => "timeline_dots",
					"value"             => "true",
					"on"				=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"				=> __( 'No', "ts_visual_composer_extend" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
                    "description"       => __( "Switch the toggle to add a connector to the timeline / process bottom.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "timeline_bottom", 'value' => 'true' )
				),
				array(
					"type"              => "dropdown",
					"heading"           => __( "Timeline / Process Position", "ts_visual_composer_extend" ),
					"param_name"        => "timeline_position",
					"width"             => 300,
					"value"             => array(
						__( 'Left', "ts_visual_composer_extend" )         			=> "direction-l",
                        __( 'Right', "ts_visual_composer_extend" )        			=> "direction-r",
					),
					"description"       => __( "Select the timeline / process element position.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "timeline_style", 'value' => array('style3') )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Font Color", "ts_visual_composer_extend" ),
					"param_name"        => "timeline_color",
					"value"             => "#ffffff",
					"description"       => __( "Define the font color for the timeline / process element.", "ts_visual_composer_extend" ),
					"dependency"        => array( 'element' => "timeline_style", 'value' => array('style1') )
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Background Color", "ts_visual_composer_extend" ),
					"param_name"        => "timeline_background",
					"value"             => "#000000",
					"description"       => __( "Define the background color for the timeline / process element.", "ts_visual_composer_extend" ),
					"dependency"        => array( 'element' => "timeline_style", 'value' => array('style1') )
				),
                // Icon / Image Settings
                array(
                    "type"              => "seperator",
                    "heading"           => __( "", "ts_visual_composer_extend" ),
                    "param_name"        => "seperator_2",
					"value"				=> "",
                    "seperator"			=> "Timeline / Process Icon or Image",
                    "description"       => __( "", "ts_visual_composer_extend" ),
					"group"				=> "Process Icon",
                ),
				array(
					"type"              => "switch_button",
					"heading"           => __( "Use Normal Image", "ts_visual_composer_extend" ),
					"param_name"        => "icon_replace",
					"value"             => "false",
					"on"				=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"				=> __( 'No', "ts_visual_composer_extend" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
                    "description"       => __( "Switch the toggle to either use and icon or a normal image on the timeline / process section.", "ts_visual_composer_extend" ),
                    "dependency"        => "",
					"group"				=> "Process Icon",
				),
				array(
					'type' 				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
					'heading' 			=> __( 'Select Icon', 'ts_visual_composer_extend' ),
					'param_name' 		=> 'icon',
					'value'				=> '',
					'source'			=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorValue,
					'settings' 			=> array(
						'emptyIcon' 			=> true,
						'type' 					=> 'extensions',
						'iconsPerPage' 			=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
						'source' 				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorSource,
					),
					"description"       => ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon you want to display.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
                    "dependency"        => array( 'element' => "icon_replace", 'value' => 'false' ),
					"group"				=> "Process Icon",
				),	
                array(
                    "type"              => "attach_image",
                    "heading"           => __( "Select Image", "ts_visual_composer_extend" ),
                    "param_name"        => "image",
                    "value"             => "false",
                    "description"       => __( "Image will be displayed in a fixed size of 80x80 px.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "icon_replace", 'value' => 'true' ),
					"group"				=> "Process Icon",
                ),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Icon Color", "ts_visual_composer_extend" ),
					"param_name"        => "icon_color",
					"value"             => "#cccccc",
					"description"       => __( "Define the color of the icon.", "ts_visual_composer_extend" ),
					"dependency"        => array( 'element' => "icon_replace", 'value' => 'false' ),
					"group"				=> "Process Icon",
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Icon / Image Background Color", "ts_visual_composer_extend" ),
					"param_name"        => "icon_background",
					"value"             => "",
					"description"       => __( "Define the background color for the icon / transparent image.", "ts_visual_composer_extend" ),
					"dependency"        => "",
					"group"				=> "Process Icon",
				),
				array(
					"type"              => "dropdown",
					"heading"           => __( "Viewport Animation", "ts_visual_composer_extend" ),
					"param_name"        => "animation_view",
					"value"             =>  array(
						__( "None", "ts_visual_composer_extend" )                          => "",
						__( "Top to Bottom", "ts_visual_composer_extend" )                 => "top-to-bottom",
						__( "Bottom to Top", "ts_visual_composer_extend" )                 => "bottom-to-top",
						__( "Left to Right", "ts_visual_composer_extend" )                 => "left-to-right",
						__( "Right to Left", "ts_visual_composer_extend" )                 => "right-to-left",
						__( "Appear from Center", "ts_visual_composer_extend" )            => "appear",
					),
					"description"       => __( "Select the viewport animation for the icon / image.", "ts_visual_composer_extend" ),
					"dependency"        => array( 'element' => "animations", 'value' => 'true' ),
					"group"				=> "Process Icon",
				),
				// Icon / Image Border Settings
				array(
					"type"              => "seperator",
					"heading"           => __( "", "ts_visual_composer_extend" ),
					"param_name"        => "seperator_3",
					"value"				=> "",
					"seperator"			=> "Icon / Image Border Settings",
					"description"       => __( "", "ts_visual_composer_extend" ),
					"group"				=> "Process Icon",
				),
				array(
					"type"              => "dropdown",
					"heading"           => __( "Icon / Image Border Type", "ts_visual_composer_extend" ),
					"param_name"        => "icon_frame_type",
					"width"             => 300,
					"value"             => array(
						__( "None", "ts_visual_composer_extend" )                          => "",
						__( "Solid Border", "ts_visual_composer_extend" )                  => "solid",
						__( "Dotted Border", "ts_visual_composer_extend" )                 => "dotted",
						__( "Dashed Border", "ts_visual_composer_extend" )                 => "dashed",
						__( "Double Border", "ts_visual_composer_extend" )                 => "double",
						__( "Grouve Border", "ts_visual_composer_extend" )                 => "groove",
						__( "Ridge Border", "ts_visual_composer_extend" )                  => "ridge",
						__( "Inset Border", "ts_visual_composer_extend" )                  => "inset",
						__( "Outset Border", "ts_visual_composer_extend" )                 => "outset",
					),
					"description"       => __( "Select the type of border around the icon / image.", "ts_visual_composer_extend" ),
					"dependency"        => "",
					"group"				=> "Process Icon",
				),
				array(
					"type"              => "nouislider",
					"heading"           => __( "Icon / Image Border Thickness", "ts_visual_composer_extend" ),
					"param_name"        => "icon_frame_thick",
					"value"             => "1",
					"min"               => "1",
					"max"               => "10",
					"step"              => "1",
					"unit"              => 'px',
					"description"       => __( "Define the thickness of the icon / image border.", "ts_visual_composer_extend" ),
					"dependency"        => array( 'element' => "icon_frame_type", 'value' => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Border_Type_Values ),
					"group"				=> "Process Icon",
				),
				array(
					"type"              => "dropdown",
					"heading"           => __( "Icon / Image Border Radius", "ts_visual_composer_extend" ),
					"param_name"        => "icon_frame_radius",
					"value"             => array(
						__( "None", "ts_visual_composer_extend" )                          => "",
						__( "Small Radius", "ts_visual_composer_extend" )                  => "ts-radius-small",
						__( "Medium Radius", "ts_visual_composer_extend" )                 => "ts-radius-medium",
						__( "Large Radius", "ts_visual_composer_extend" )                  => "ts-radius-large",
						__( "Full Circle", "ts_visual_composer_extend" )                   => "ts-radius-full"
					),
					"description"       => __( "Define the radius of the icon / image border.", "ts_visual_composer_extend" ),
					"dependency"        => array( 'element' => "icon_frame_type", 'value' => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Border_Type_Values ),
					"group"				=> "Process Icon",
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Icon / Image Frame Border Color", "ts_visual_composer_extend" ),
					"param_name"        => "icon_frame_color",
					"value"             => "#000000",
					"description"       => __( "Define the color of the icon / image border.", "ts_visual_composer_extend" ),
					"dependency"        => array( 'element' => "icon_frame_type", 'value' => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Border_Type_Values ),
					"group"				=> "Process Icon",
				),
				array(
					"type"              => "switch_button",
					"heading"           => __( "Apply Padding to Icon / Image", "ts_visual_composer_extend" ),
					"param_name"        => "padding",
					"value"             => "true",
					"on"				=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"				=> __( 'No', "ts_visual_composer_extend" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
                    "description"       => __( "Switch the toggle if you want to apply a padding to the icon / image.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "icon_frame_type", 'value' => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Border_Type_Values ),
					"group"				=> "Process Icon",
				),
				array(
					"type"              => "nouislider",
					"heading"           => __( "Icon / Image Padding", "ts_visual_composer_extend" ),
					"param_name"        => "icon_padding",
					"value"             => "0",
					"min"               => "0",
					"max"               => "50",
					"step"              => "1",
					"unit"              => 'px',
					"description"       => __( "If image instead of icon, increase the image size by padding value.", "ts_visual_composer_extend" ),
					"dependency"        => array( 'element' => "padding", 'value' => 'true' ),
					"group"				=> "Process Icon",
				),
                // Timeline Content
                array(
                    "type"              => "seperator",
                    "heading"           => __( "", "ts_visual_composer_extend" ),
                    "param_name"        => "seperator_4",
					"value"				=> "",
                    "seperator"			=> "Timeline / Process Content",
                    "description"       => __( "", "ts_visual_composer_extend" ),
					"group"				=> "Process Content",
                ),
				array(
					"type"              => "switch_button",
                    "heading"           => __( "Show Date / Step", "ts_visual_composer_extend" ),
                    "param_name"        => "show_date",
					"value"             => "true",
					"on"				=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"				=> __( 'No', "ts_visual_composer_extend" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
                    "description"       => __( "Switch the toggle to either show or hide the section with the date / step.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "timeline_style", 'value' => array('style2') ),
					"group"				=> "Process Content",
				),
                array(
                    "type"              => "textfield",
                    "heading"           => __( "Date / Step", "ts_visual_composer_extend" ),
                    "param_name"        => "date",
                    "value"             => "",
                    "description"       => __( "Enter the date for the timeline / process element.", "ts_visual_composer_extend" ),
					"group"				=> "Process Content",
                ),
                array(
                    "type"              => "textfield",
                    "heading"           => __( "Sub-Date / Step", "ts_visual_composer_extend" ),
                    "param_name"        => "sub_date",
                    "value"             => "",
                    "description"       => __( "Enter the text below the date for the timeline / process element.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "timeline_style", 'value' => array('style2') ),
					"group"				=> "Process Content",
                ),
                array(
                    "type"              => "textfield",
                    "heading"           => __( "Title", "ts_visual_composer_extend" ),
                    "param_name"        => "title",
                    "value"             => "",
                    "description"       => __( "Enter the title for the timeline / process element.", "ts_visual_composer_extend" ),
					"group"				=> "Process Content",
                ),
				array(
					"type"				=> "switch_button",
                    "heading"           => __( "Allow HTML Code", "ts_visual_composer_extend" ),
                    "param_name"        => "text_code",
                    "value"             => "false",
					"on"				=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"				=> __( 'No', "ts_visual_composer_extend" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
					"description"       => __( "Switch the toggle to allow for HTML code to create the icon box content.", "ts_visual_composer_extend" ),
                    "dependency"		=> "",
					"group"				=> "Process Content",
				),
                array(
                    "type"              => "textarea",
                    "heading"           => __( "Text", "ts_visual_composer_extend" ),
                    "param_name"        => "text",
                    "value"             => "",
                    "description"       => __( "Enter the text for the timeline / process element; HTML code is NOT allowed.", "ts_visual_composer_extend" ),
					"dependency"        => array( 'element' => "text_code", 'value' => 'false' ),
					"group"				=> "Process Content",
                ),
				array(
					"type"              => "textarea_raw_html",
					"heading"           => __( "Text", "ts_visual_composer_extend" ),
					"param_name"        => "text_html",
					"value"             => base64_encode(""),
					"description"       => __( "Enter the text for the timeline / process element; HTML code CAN be used.", "ts_visual_composer_extend" ),
					"dependency"        => array( 'element' => "text_code", 'value' => 'true' ),
					"group"				=> "Process Content",
				),
				// Other Icon Settings
				array(
					"type"              => "seperator",
					"heading"           => __( "", "ts_visual_composer_extend" ),
					"param_name"        => "seperator_5",
					"value"				=> "",
					"seperator"			=> "Other Timeline / Process Settings",
					"description"       => __( "", "ts_visual_composer_extend" ),
					"group"				=> "Other Settings",
				),
				array(
					"type"              => "nouislider",
					"heading"           => __( "Margin: Top", "ts_visual_composer_extend" ),
					"param_name"        => "margin_top",
					"value"             => "0",
					"min"               => "-50",
					"max"               => "200",
					"step"              => "1",
					"unit"              => 'px',
					"description"       => __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
					"group"				=> "Other Settings",
				),
				array(
					"type"              => "nouislider",
					"heading"           => __( "Margin: Bottom", "ts_visual_composer_extend" ),
					"param_name"        => "margin_bottom",
					"value"             => "0",
					"min"               => "-50",
					"max"               => "200",
					"step"              => "1",
					"unit"              => 'px',
					"description"       => __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
					"group"				=> "Other Settings",
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Define ID Name", "ts_visual_composer_extend" ),
					"param_name"        => "el_id",
					"value"             => "",
					"description"       => __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
					"group"				=> "Other Settings",
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Extra Class Name", "ts_visual_composer_extend" ),
					"param_name"        => "el_class",
					"value"             => "",
					"description"       => __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
					"group"				=> "Other Settings",
				),
                // Load Custom CSS/JS File
                array(
                    "type"              => "load_file",
                    "heading"           => __( "", "ts_visual_composer_extend" ),
                    "value"             => "Timeline Files",
                    "param_name"        => "el_file",
                    "file_type"         => "js",
                    "file_path"         => "js/ts-visual-composer-extend-element.min.js",
                    "description"       => __( "", "ts_visual_composer_extend" )
                ),
            ))
        );
    }
?>