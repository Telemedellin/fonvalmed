<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
    if (function_exists('vc_map')) {
        vc_map( array(
            "name"                          => __( "TS Pricing Table", "ts_visual_composer_extend" ),
            "base"                          => "TS-VCSC-Pricing-Table",
            "icon"                          => "icon-wpb-ts_vcsc_pricing_table",
            "class"                         => "",
            "category"                      => __( "VC Extensions", "ts_visual_composer_extend" ),
            "description" 		            => __("Place a pricing table", "ts_visual_composer_extend"),
			"js_view"     					=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorLivePreview == "true" ? "TS_VCSC_PricingTableViewCustom" : ""),
            "admin_enqueue_js"            	=> "",
            "admin_enqueue_css"           	=> "",
            "params"                        => array(
				// Pricing Table Settings
				array(
					"type"				    => "seperator",
					"heading"			    => __( "", "ts_visual_composer_extend" ),
					"param_name"		    => "seperator_1",
					"value"					=> "",
					"seperator"				=> "Pricing Table Settings",
					"description"		    => __( "", "ts_visual_composer_extend" ),
                    "dependency"            => "",
				),
                array(
                    "type"			        => "dropdown",
                    "class"			        => "",
                    "heading"               => __( "Design", "ts_visual_composer_extend" ),
                    "param_name"            => "style",
                    "admin_label"           => true,
                    "value"			        => array(
                        __( "Style 1", "")          => "1",
                        __( "Style 2", "" )         => "2",
                        __( "Style 3", "" )         => "3",
                        __( "Style 4", "" )         => "4",
                        __( "Style 5", "" )         => "5",
                    ),
                ),
                array(
                    "type"                  => "switch_button",
                    "heading"               => __( "Featured Table", "ts_visual_composer_extend" ),
                    "param_name"            => "featured",
                    "value"                 => "false",
                    "on"				    => __( 'Yes', "ts_visual_composer_extend" ),
                    "off"				    => __( 'No', "ts_visual_composer_extend" ),
                    "style"				    => "select",
                    "design"			    => "toggle-light",
                    "description"           => __( "Switch the toggle if this table will be a featured table..", "ts_visual_composer_extend" ),
                    "dependency"            => ""
                ),
                array(
                    "type"                  => "textfield",
                    "class"                 => "",
                    "heading"               => __( "Plan", "ts_visual_composer_extend" ),
                    "param_name"            => "featured_text",
                    "value"                 => "Recommended",
                    "dependency"            => array( 'element' => "style", 'value' => "3" )
                ),
                array(
                    "type"                  => "textfield",
                    "class"                 => "",
                    "heading"               => __( "Plan", "ts_visual_composer_extend" ),
                    "param_name"            => "plan",
                    "value"                 => "Basic",
                    "admin_label"           => true,
                ),
                array(
                    "type"                  => "textfield",
                    "class"                 => "",
                    "heading"               => __( "Cost", "ts_visual_composer_extend" ),
                    "param_name"            => "cost",
                    "value"                 => "$20",
                    "admin_label"           => true,
                ),
                array(
                    "type"		            => "textfield",
                    "class"		            => "",
                    "heading"               => __( "Per (optional)", "ts_visual_composer_extend" ),
                    "param_name"            => "per",
                    "value"                 => "/ month",
					"dependency"            => array( 'element' => "style", 'value' => array("1", "3", "4", "5") )
                ),
                array(
                    "type"		            => "textarea_html",
                    "class"		            => "",
                    "heading"               => __( "Features", "ts_visual_composer_extend" ),
                    "param_name"            => "content",
                    "value"                 => "<ul>
                                                <li>30GB Storage</li>
                                                <li>512MB Ram</li>
                                                <li>10 databases</li>
                                                <li>1,000 Emails</li>
                                                <li>25GB Bandwidth</li>
                                            </ul>",
                ),
				// Link Settings
				array(
					"type"				    => "seperator",
					"heading"			    => __( "", "ts_visual_composer_extend" ),
					"param_name"		    => "seperator_2",
					"value"					=> "",
					"seperator"				=> "Link Settings",
					"description"		    => __( "", "ts_visual_composer_extend" ),
                    "dependency"            => "",
					"group" 				=> "Link Settings",
				),
                array(
                    "type"			        => "dropdown",
                    "class"			        => "",
                    "heading"               => __( "Link Style", "ts_visual_composer_extend" ),
                    "param_name"            => "link_type",
                    "admin_label"           => true,
                    "value"			        => array(
                        __( "Default Link Button", "ts_visual_composer_extend")		=> "default",
						__( "Flat Button", "ts_visual_composer_extend")				=> "flat",
                        __( "Custom Code Block", "ts_visual_composer_extend" )		=> "custom",
                        __( "No Link", "ts_visual_composer_extend" )         		=> "none",
                    ),
					"group"					=> "Link Settings"
                ),
                array(
                    "type"			        => "textfield",
                    "class"			        => "",
                    "heading"		        => __( "Button: Text", "ts_visual_composer_extend" ),
                    "param_name"	        => "button_text",
                    "value"			        => "Purchase",
                    "description"	        => __( "Button: Text", "ts_visual_composer_extend" ),
					"dependency"			=> array( 'element' => "link_type", 'value' => array('default', 'flat') ),
					"group"					=> "Link Settings"
                ),
                array(
                    "type"			        => "textfield",
                    "class"			        => "",
                    "heading"		        => __( "Button: URL", "ts_visual_composer_extend" ),
                    "param_name"	        => "button_url",
                    "value"			        => "",
                    "description"	        => __( "Button: URL", "ts_visual_composer_extend" ),
					"dependency"			=> array( 'element' => "link_type", 'value' => array('default', 'flat') ),
					"group"					=> "Link Settings"
                ),
                array(
                    "type"			        => "dropdown",
                    "class"			        => "",
                    "heading"               => __( "Button: Link Target", "ts_visual_composer_extend" ),
                    "param_name"	        => "button_target",
					"value"             => array(
						__( "Same Window", "ts_visual_composer_extend" )                    => "_parent",
						__( "New Window", "ts_visual_composer_extend" )                     => "_blank"
					),
					"dependency"			=> array( 'element' => "link_type", 'value' => array('default', 'flat') ),
					"group"					=> "Link Settings"
                ),
                array(
                    "type"                  => "dropdown",
                    "heading"               => __( "Button Color Style", "ts_visual_composer_extend" ),
                    "param_name"            => "button_style",
                    "width"                 => 300,
					"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Default_Colors,
                    "description"           => __( "Select the general color style for button.", "ts_visual_composer_extend" ),
					"dependency"			=> array( 'element' => "link_type", 'value' => 'flat' ),
					"group"					=> "Link Settings"
                ),
                array(
                    "type"                  => "dropdown",
                    "heading"               => __( "Button Hover Style", "ts_visual_composer_extend" ),
                    "param_name"            => "button_hover",
                    "width"                 => 300,
					"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Hover_Colors,
                    "description"           => __( "Select the general hover style for button.", "ts_visual_composer_extend" ),
					"dependency"			=> array( 'element' => "link_type", 'value' => 'flat' ),
					"group"					=> "Link Settings"
                ),
                array(
                    "type"                  => "nouislider",
                    "heading"               => __( "Button Font Size", "ts_visual_composer_extend" ),
                    "param_name"            => "button_size",
                    "value"                 => "16",
                    "min"                   => "12",
                    "max"                   => "30",
                    "step"                  => "1",
                    "unit"                  => 'px',
                    "description"           => __( "Select the font size for the button.", "ts_visual_composer_extend" ),
					"dependency"			=> array( 'element' => "link_type", 'value' => 'flat' ),
					"group"					=> "Link Settings"
                ),
                array(
                    "type"                  => "nouislider",
                    "heading"               => __( "Button Width", "ts_visual_composer_extend" ),
                    "param_name"            => "button_width",
                    "value"                 => "80",
                    "min"                   => "50",
                    "max"                   => "100",
                    "step"                  => "1",
                    "unit"                  => '%',
                    "description"           => __( "Define the width of the button in relation to the pricing table.", "ts_visual_composer_extend" ),
					"dependency"			=> array( 'element' => "link_type", 'value' => 'flat' ),
					"group"					=> "Link Settings"
                ),
				array(
					"type"              	=> "textarea_raw_html",
					"heading"           	=> __( "Custom Code", "ts_visual_composer_extend" ),
					"param_name"        	=> "button_custom",
					"value"             	=> base64_encode(""),
					"description"       	=> __( "Enter the HTML code to build your custom link (button).", "ts_visual_composer_extend" ),
					"dependency"        	=> array( 'element' => "link_type", 'value' => 'custom' ),
					"group"					=> "Link Settings"
				),
				// Graphic Settings
				array(
					"type"				    => "seperator",
					"heading"			    => __( "", "ts_visual_composer_extend" ),
					"param_name"		    => "seperator_3",
					"value"					=> "",
					"seperator"				=> "Icon / Image Settings",
					"description"		    => __( "", "ts_visual_composer_extend" ),
                    "dependency"            => "",
					"group" 				=> "Style Settings",
				),
                array(
                    "type"			        => "dropdown",
                    "class"			        => "",
                    "heading"               => __( "Icon / Image Addition", "ts_visual_composer_extend" ),
                    "param_name"	        => "graphic_type",
					"value"             	=> array(
						__( "None", "ts_visual_composer_extend" )                    		=> "none",
						__( "Font Icon", "ts_visual_composer_extend" )                     	=> "icon",
						__( "Image", "ts_visual_composer_extend" )                     		=> "image",
					),
					"group"					=> "Style Settings"
                ),
                array(
                    "type"			        => "dropdown",
                    "class"			        => "",
                    "heading"               => __( "Icon / Image Placement", "ts_visual_composer_extend" ),
                    "param_name"	        => "graphic_position",
					"value"             	=> array(
						__( "Above Title", "ts_visual_composer_extend" )					=> "title",
						__( "Above Content", "ts_visual_composer_extend" )					=> "content",
					),
					"dependency"        	=> array( 'element' => "graphic_type", 'value' => array('icon', 'image') ),
					"group"					=> "Style Settings"
                ),
				array(
					'type' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
					'heading' 				=> __( 'Select Icon', 'ts_visual_composer_extend' ),
					'param_name' 			=> 'graphic_icon',
					'value'					=> '',
					'source'				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorValue,
					'settings' 				=> array(
						'emptyIcon' 			=> false,
						'type' 					=> 'extensions',
						'iconsPerPage' 			=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
						'source' 				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorSource,
					),
					"description"       	=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon you want to display.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
					"dependency"        	=> array( 'element' => "graphic_type", 'value' => 'icon' ),
					"group"					=> "Style Settings"
				),
				array(
					"type"                  => "colorpicker",
					"heading"               => __( "Icon Color", "ts_visual_composer_extend" ),
					"param_name"            => "graphic_color",
					"value"                 => "#333333",
					"description"           => __( "Define the color of the icon.", "ts_visual_composer_extend" ),
					"dependency"        	=> array( 'element' => "graphic_type", 'value' => 'icon' ),
					"group"					=> "Style Settings"
				),
				array(
					"type"              	=> "attach_image",
					"heading"           	=> __( "Select Image", "ts_visual_composer_extend" ),
					"param_name"        	=> "graphic_image",
					"value"             	=> "",
					"description"       	=> __( "Image must have equal dimensions for scaling purposes (i.e. 100x100).", "ts_visual_composer_extend" ),
					"dependency"        	=> array( 'element' => "graphic_type", 'value' => 'image' ),
					"group"					=> "Style Settings"
				),
                array(
                    "type"                  => "nouislider",
                    "heading"               => __( "Icon / Image Size", "ts_visual_composer_extend" ),
                    "param_name"            => "graphic_size",
                    "value"                 => "30",
                    "min"                   => "20",
                    "max"                   => "200",
                    "step"                  => "1",
                    "unit"                  => 'px',
                    "description"           => __( "Select the size (width) for the icon or image.", "ts_visual_composer_extend" ),
					"dependency"        	=> array( 'element' => "graphic_type", 'value' => array('icon', 'image') ),
					"group"					=> "Style Settings"
                ),
				// Box Shadow Settings
				array(
					"type"				    => "seperator",
					"heading"			    => __( "", "ts_visual_composer_extend" ),
					"param_name"		    => "seperator_4",
					"value"					=> "",
					"seperator"				=> "Shadow Settings",
					"description"		    => __( "", "ts_visual_composer_extend" ),
                    "dependency"            => "",
					"group" 				=> "Style Settings",
				),
                array(
                    "type"                  => "switch_button",
                    "heading"               => __( "Add Box-Shadow", "ts_visual_composer_extend" ),
                    "param_name"            => "shadow_enabled",
                    "value"                 => "true",
                    "on"				    => __( 'Yes', "ts_visual_composer_extend" ),
                    "off"				    => __( 'No', "ts_visual_composer_extend" ),
                    "style"				    => "select",
                    "design"			    => "toggle-light",
                    "description"           => __( "Switch the toggle if you want to apply a box shadow effect to the table.", "ts_visual_composer_extend" ),
					"group"					=> "Style Settings"
                ),
				array(
					"type"                  => "colorpicker",
					"heading"               => __( "Featured Standard Shadow Color", "ts_visual_composer_extend" ),
					"param_name"            => "shadow_featured_default",
					"value"                 => "rgba(0, 0, 0, 0.15)",
					"description"           => __( "Define the shadow color for the featured pricing table.", "ts_visual_composer_extend" ),
					"dependency"        	=> array( 'element' => "shadow_enabled", 'value' => 'true' ),
					"group"					=> "Style Settings"
				),
				array(
					"type"                  => "colorpicker",
					"heading"               => __( "Featured Hover Shadow Color", "ts_visual_composer_extend" ),
					"param_name"            => "shadow_featured_hover",
					"value"                 => "rgba(129, 215, 66, 0.5)",
					"description"           => __( "Define the hover shadow color for the featured pricing table.", "ts_visual_composer_extend" ),
					"dependency"        	=> array( 'element' => "shadow_enabled", 'value' => 'true' ),
					"group"					=> "Style Settings"
				),
				array(
					"type"                  => "colorpicker",
					"heading"               => __( "Hover Shadow Color", "ts_visual_composer_extend" ),
					"param_name"            => "shadow_standard_hover",
					"value"                 => "rgba(55, 188, 229, 0.5)",
					"description"           => __( "Define the the hover shadow color for the pricing table.", "ts_visual_composer_extend" ),
					"dependency"        	=> array( 'element' => "shadow_enabled", 'value' => 'true' ),
					"group"					=> "Style Settings"
				),
				// Other Settings
				array(
					"type"				    => "seperator",
					"heading"			    => __( "", "ts_visual_composer_extend" ),
					"param_name"		    => "seperator_5",
					"value"					=> "",
					"seperator"				=> "Other Settings",
					"description"		    => __( "", "ts_visual_composer_extend" ),
                    "dependency"            => "",
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
					"type"              	=> "textfield",
					"heading"           	=> __( "Define ID Name", "ts_visual_composer_extend" ),
					"param_name"        	=> "el_id",
					"value"             	=> "",
					"description"       	=> __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
					"group" 				=> "Other Settings",
				),
				array(
					"type"              	=> "textfield",
					"heading"           	=> __( "Extra Class Name", "ts_visual_composer_extend" ),
					"param_name"        	=> "el_class",
					"value"             	=> "",
					"description"       	=> __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
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