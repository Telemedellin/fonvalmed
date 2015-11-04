<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
    if (function_exists('vc_map')) {
        vc_map( array(
            "name"                      		=> __( "TS Quick Skillset", "ts_visual_composer_extend" ),
            "base"                      		=> "TS_VCSC_Quick_Skills",
            "icon" 	                    		=> "icon-wpb-ts_vcsc_quick_skillset",
            "class"                     		=> "",
            "category"                  		=> __( "VC Extensions", "ts_visual_composer_extend" ),
            "description"               		=> __("Place a single skillset element", "ts_visual_composer_extend"),
            "admin_enqueue_js"        			=> "",
            "admin_enqueue_css"       			=> "",
            "params"                    		=> array(
                // Skillset Settings
                array(
                    "type"              		=> "seperator",
                    "heading"           		=> __( "", "ts_visual_composer_extend" ),
                    "param_name"        		=> "seperator_1",
					"value"						=> "",
                    "seperator"         		=> "Skillset Values",
                    "description"       		=> __( "", "ts_visual_composer_extend" )
                ),				
				array(
					'type' 						=> 'param_group',
					'heading' 					=> __( 'Skillset Values', 'ts_visual_composer_extend' ),
					'param_name' 				=> 'skill_values',
					'description' 				=> __( 'Enter values for graph - value, title and color.', 'ts_visual_composer_extend' ),
					'save_always' 				=> true,
					'value' 					=> urlencode(json_encode(array(
						array(
							'skillname' 				=> __( 'Development', 'ts_visual_composer_extend' ),
							'skillvalue' 				=> '90',
							'skillcolor'				=> '#00afd1',
						),
						array(
							'skillname' 				=> __( 'Design', 'ts_visual_composer_extend' ),
							'skillvalue' 				=> '80',
							'skillcolor'				=> '#d30000',
						),
						array(
							'skillname' 				=> __( 'Marketing', 'ts_visual_composer_extend' ),
							'skillvalue' 				=> '70',
							'skillcolor'				=> '#079300',
						),
					))),
					'params' 					=> array(
						array(
							'type' 						=> 'textfield',
							'heading' 					=> __( 'Label', 'ts_visual_composer_extend' ),
							'param_name' 				=> 'skillname',
							'description' 				=> __( 'Enter text used as title of bar.', 'ts_visual_composer_extend' ),
							'admin_label' 				=> true,
						),				
						array(
							"type"              		=> "nouislider",
							"heading"           		=> __( "Value", "ts_visual_composer_extend" ),
							"param_name"        		=> "skillvalue",
							"value"             		=> "0",
							"min"               		=> "0",
							"max"               		=> "100",
							"step"              		=> "1",
							"unit"              		=> '%',
							"admin_label"				=> true,
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),						
						array(
							'type' 						=> 'colorpicker',
							'heading' 					=> __( 'Color', 'ts_visual_composer_extend' ),
							'param_name' 				=> 'skillcolor',
							'value'						=> '#00afd1',
							"admin_label"				=> true,
							'description' 				=> __( 'Select custom single bar background color.', 'ts_visual_composer_extend' ),
						),
					),
				),
                array(
                    "type"              		=> "seperator",
                    "heading"           		=> __( "", "ts_visual_composer_extend" ),
                    "param_name"        		=> "seperator_2",
					"value"						=> "",
                    "seperator"         		=> "Skillset Styling",
                    "description"       		=> __( "", "ts_visual_composer_extend" ),
					"group"						=> "Styling Settings",
                ),
				
				array(
					"type"						=> "dropdown",
					"heading"					=> __( "Skillset Layout", "ts_visual_composer_extend" ),
					"param_name"				=> "skill_layout",
					"value"						=> array(
						"Bars Layout"					=> "bars",
						"Rapheal Layout"				=> "raphael",
					),
					"admin_label"				=> true,
					"description"				=> __( "Select the overall layout for the skillset.", "ts_visual_composer_extend" ),
					"group"						=> "Styling Settings",
				),		
				// Bars Layout
				array(
					"type"						=> "dropdown",
					"heading"					=> __( "Bar Style", "ts_visual_composer_extend" ),
					"param_name"				=> "bar_style",
					"value"						=> array(
						"Style 1"						=> "style1",
						"Style 2"						=> "style2",
						"Style 3"						=> "style3",
					),
					"admin_label"				=> true,
					"description"				=> __( "Select the style for the skill bars.", "ts_visual_composer_extend" ),
					"dependency"                => array( 'element' => "skill_layout", 'value' => 'bars'),
					"group"						=> "Styling Settings",
				),						
				array(
					"type"                      => "nouislider",
					"heading"                   => __( "Bar Height", "ts_visual_composer_extend" ),
					"param_name"                => "bar_height",
					"value"                     => "2",
					"min"                       => "2",
					"max"                       => "75",
					"step"                      => "1",
					"unit"                      => 'px',
					"description"               => __( "Define the height for each individual skill bar.", "ts_visual_composer_extend" ),
					"dependency"                => array( 'element' => "bar_style", 'value' => 'style1'),
					"group"						=> "Styling Settings",
				),
				array(
					"type"                      => "nouislider",
					"heading"                   => __( "Bar Height", "ts_visual_composer_extend" ),
					"param_name"                => "bar_height_2",
					"value"                     => "35",
					"min"                       => "20",
					"max"                       => "75",
					"step"                      => "1",
					"unit"                      => 'px',
					"description"               => __( "Define the height for each individual skill bar.", "ts_visual_composer_extend" ),
					"dependency"                => array( 'element' => "bar_style", 'value' => 'style2'),
					"group"						=> "Styling Settings",
				),
				array(
					"type"                      => "nouislider",
					"heading"                   => __( "Bar Label Width", "ts_visual_composer_extend" ),
					"param_name"                => "bar_label_width",
					"value"                     => "110",
					"min"                       => "100",
					"max"                       => "300",
					"step"                      => "1",
					"unit"                      => 'px',
					"description"               => __( "If necessary, define the width for the skill labels before the skill bars to account for longer skill names.", "ts_visual_composer_extend" ),
					"dependency"                => array( 'element' => "bar_style", 'value' => 'style2'),
					"group"						=> "Styling Settings",
				),		
				array(
					"type"				        => "switch_button",
					"heading"                   => __( "Use Tooltip", "ts_visual_composer_extend" ),
					"param_name"                => "bar_tooltip",
					"value"                     => "false",
					"on"				        => __( 'Yes', "ts_visual_composer_extend" ),
					"off"				        => __( 'No', "ts_visual_composer_extend" ),
					"style"				        => "select",
					"design"			        => "toggle-light",
					"admin_label"		        => true,
					"description"               => __( "Switch the toggle if you want to show the skill value as tooltip.", "ts_visual_composer_extend" ),
					"dependency"                => array( 'element' => "skill_layout", 'value' => 'bars'),
					"group"						=> "Styling Settings",
				),
				array(
					"type"				        => "switch_button",
					"heading"                   => __( "Add Stripes", "ts_visual_composer_extend" ),
					"param_name"                => "bar_stripes",
					"value"                     => "false",
					"on"				        => __( 'Yes', "ts_visual_composer_extend" ),
					"off"				        => __( 'No', "ts_visual_composer_extend" ),
					"style"				        => "select",
					"design"			        => "toggle-light",
					"admin_label"		        => true,
					"description"               => __( "Switch the toggle if you want to add a stripes to the skill bar.", "ts_visual_composer_extend" ),
					"dependency"                => array( 'element' => "skill_layout", 'value' => 'bars'),
					"group"						=> "Styling Settings",
				),
				array(
					"type"				        => "switch_button",
					"heading"                   => __( "Add Stripes Animation", "ts_visual_composer_extend" ),
					"param_name"                => "bar_animation",
					"value"                     => "false",
					"on"				        => __( 'Yes', "ts_visual_composer_extend" ),
					"off"				        => __( 'No', "ts_visual_composer_extend" ),
					"style"				        => "select",
					"design"			        => "toggle-light",
					"description"               => __( "Switch the toggle if you want to add an animation to the striped skill bar.", "ts_visual_composer_extend" ),
					"dependency"                => array( 'element' => "bar_stripes", 'value' => 'true'),
					"group"						=> "Styling Settings",
				),
				// Raphael Layout
				array(
					"type"                      => "textfield",
					"heading"                   => __( "Default Label Text", "ts_visual_composer_extend" ),
					"param_name"                => "text_default",
					"value"                     => "",
					"description"               => __( "Enter a default text for the inner circle label.", "ts_visual_composer_extend" ),
					"dependency"                => array( 'element' => "skill_layout", 'value' => 'raphael'),
					"group"						=> "Styling Settings",
				),
				array(
					"type"              		=> "colorpicker",
					"heading"           		=> __( "Label Text Color", "ts_visual_composer_extend" ),
					"param_name"        		=> "text_color",
					"value"             		=> "#000000",
					"description"       		=> __( "Define the text color for the inner circle label.", "ts_visual_composer_extend" ),
					"dependency"                => array( 'element' => "skill_layout", 'value' => 'raphael'),
					"group"						=> "Styling Settings",
				),		
				array(
					"type"                      => "nouislider",
					"heading"                   => __( "Label Font Size", "ts_visual_composer_extend" ),
					"param_name"                => "text_size",
					"value"                     => "16",
					"min"                       => "10",
					"max"                       => "50",
					"step"                      => "1",
					"unit"                      => 'px',
					"admin_label"		        => true,
					"description"               => __( "Select the font size for the inner circle label.", "ts_visual_composer_extend" ),
					"dependency"                => array( 'element' => "skill_layout", 'value' => 'raphael'),
					"group"						=> "Styling Settings",
				),
				array(
					"type"						=> "switch_button",
					"heading"           		=> __( "Custom Label Background", "ts_visual_composer_extend" ),
					"param_name"        		=> "circle_custom",
					"value"             		=> "false",
					"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"						=> __( 'No', "ts_visual_composer_extend" ),
					"style"						=> "select",
					"design"					=> "toggle-light",
					"description"       		=> __( "Switch the toggle if you want to apply a custom background color to the inner circle label.", "ts_visual_composer_extend" ),
					"dependency"                => array( 'element' => "skill_layout", 'value' => 'raphael'),
					"group"						=> "Styling Settings",
				),
				array(
					"type"              		=> "colorpicker",
					"heading"           		=> __( "Label Background Color", "ts_visual_composer_extend" ),
					"param_name"        		=> "circle_color",
					"value"             		=> "#ffffff",
					"description"       		=> __( "Define the background color for the inner circle label.", "ts_visual_composer_extend" ),
					"dependency"        		=> array( 'element' => "circle_custom", 'value' => 'true' ),
					"group"						=> "Styling Settings",
				),						
				array(
					"type"                      => "nouislider",
					"heading"                   => __( "Max. Circle Stroke Width", "ts_visual_composer_extend" ),
					"param_name"                => "max_stroke",
					"value"                     => "40",
					"min"                       => "10",
					"max"                       => "80",
					"step"                      => "1",
					"unit"                      => 'px',
					"description"               => __( "Select the maximum stroke width for the individual skill circles.", "ts_visual_composer_extend" ),
					"dependency"                => array( 'element' => "skill_layout", 'value' => 'raphael'),
					"group"						=> "Styling Settings",
				),
				array(
					"type"                      => "nouislider",
					"heading"                   => __( "Stroke Spacing", "ts_visual_composer_extend" ),
					"param_name"                => "space_stroke",
					"value"                     => "2",
					"min"                       => "0",
					"max"                       => "10",
					"step"                      => "1",
					"unit"                      => 'px',
					"description"               => __( "Select the spacing between the individual skill circles.", "ts_visual_composer_extend" ),
					"dependency"                => array( 'element' => "skill_layout", 'value' => 'raphael'),
					"group"						=> "Styling Settings",
				),
				// Other Skillset Settings
				array(
					"type"                      => "seperator",
					"heading"                   => __( "", "ts_visual_composer_extend" ),
					"param_name"                => "seperator_3",
					"value"						=> "",
					"seperator"					=> "Other Settings",
					"description"               => __( "", "ts_visual_composer_extend" ),
					"group" 			        => "Other Settings",
				),
				array(
					"type"                      => "dropdown",
					"heading"                   => __( "Viewport Animation", "ts_visual_composer_extend" ),
					"param_name"                => "animation_view",
					"value"                     => array(
						"None"                              => "",
						"Top to Bottom"                     => "top-to-bottom",
						"Bottom to Top"                     => "bottom-to-top",
						"Left to Right"                     => "left-to-right",
						"Right to Left"                     => "right-to-left",
						"Appear from Center"                => "appear",
					),
					"description"               => __( "Select the viewport animation for the element.", "ts_visual_composer_extend" ),
					"group" 			        => "Other Settings",
				),
				array(
					"type"                      => "nouislider",
					"heading"                   => __( "Margin: Top", "ts_visual_composer_extend" ),
					"param_name"                => "margin_top",
					"value"                     => "0",
					"min"                       => "-50",
					"max"                       => "500",
					"step"                      => "1",
					"unit"                      => 'px',
					"description"               => __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
					"group" 			        => "Other Settings",
				),
				array(
					"type"                      => "nouislider",
					"heading"                   => __( "Margin: Bottom", "ts_visual_composer_extend" ),
					"param_name"                => "margin_bottom",
					"value"                     => "0",
					"min"                       => "-50",
					"max"                       => "500",
					"step"                      => "1",
					"unit"                      => 'px',
					"description"               => __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
					"group" 			        => "Other Settings",
				),
				array(
					"type"                      => "textfield",
					"heading"                   => __( "Define ID Name", "ts_visual_composer_extend" ),
					"param_name"                => "el_id",
					"value"                     => "",
					"description"               => __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
					"group" 			        => "Other Settings",
				),
				array(
					"type"                      => "textfield",
					"heading"                   => __( "Extra Class Name", "ts_visual_composer_extend" ),
					"param_name"				=> "el_class",
					"value"						=> "",
					"description"				=> __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
					"group"						=> "Other Settings",
				),
				// Load Custom CSS/JS File
				array(
					"type"             	 		=> "load_file",
					"heading"           		=> __( "", "ts_visual_composer_extend" ),
                    "param_name"        		=> "el_file",
					"value"             		=> "",
					"file_type"         		=> "js",
					"file_path"         		=> "js/ts-visual-composer-extend-element.min.js",
					"description"       		=> __( "", "ts_visual_composer_extend" )
				),
            ))
        );
    }
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_Quick_Skills extends WPBakeryShortCode {};
	}
?>