<?php
	if (!class_exists('TS_Icon_Wall')){
		class TS_Icon_Wall {
			function __construct() {
				global $VISUAL_COMPOSER_EXTENSIONS;
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
					add_action('init',                                  	array($this, 'TS_VCSC_Add_IconWall_Elements'), 9999999);
				} else {
					add_action('admin_init',		                    	array($this, 'TS_VCSC_Add_IconWall_Elements'), 9999999);
				}
				add_shortcode('TS_VCSC_Icon_Wall_Container',              	array($this, 'TS_VCSC_IconWall_Container'));
				add_shortcode('TS_VCSC_Icon_Wall_Item',              		array($this, 'TS_VCSC_IconWall_Item'));
			}
			
			// Icon Wall Container
			function TS_VCSC_IconWall_Container ($atts, $content = null) {
				global $VISUAL_COMPOSER_EXTENSIONS;
				ob_start();
				
				// Check for Front End Editor
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
					$wall_frontend					= "true";
				} else {
					$wall_frontend					= "false";
				}
	
				wp_enqueue_style('ts-extend-iconwall');
				if ($wall_frontend == "false") {					
					wp_enqueue_script('ts-extend-iconwall');
					wp_enqueue_style('ts-extend-tooltipster');
					wp_enqueue_script('ts-extend-tooltipster');
					wp_enqueue_style('ts-extend-animations');
				} 
				wp_enqueue_style('ts-visual-composer-extend-front');
				wp_enqueue_script('ts-visual-composer-extend-front');
				
				$output = $title = $interval = $el_class = '';
				extract(shortcode_atts( array(
					// General Settings
					'current'						=> 0,
					'spacing'						=> 5,
					'width'							=> 100,
					'break_large'					=> 1024,
					'break_medium'					=> 768,
					'break_small'					=> 480,
					'fluid_height'					=> 'true',
					'item_overlap'					=> 'false',
					'item_shuffle'					=> 'false',
					// Style Settings
					'style_shadow'					=> 'true',
					'style_custom'					=> 'true',
					// Color Settings
					'standard_color'				=> '#676767',
					'standard_back'					=> '#ffffff',
					'standard_border'				=> '#cccccc',
					'hover_color'					=> '#676767',
					'hover_back'					=> '#FFD800',
					'hover_border'					=> '#cccccc',
					'active_color'					=> '#ffffff',
					'active_back'					=> '#AE0000',
					'active_border'					=> '#cccccc',
					// AutoPlay Settings
					'autoplay'						=> 'false',
					'delay'							=> 5000,
					'pausehover'					=> 'true',
					'progress_bar'					=> 'true',
					'progress_color'				=> '#f7f7f7',
					'progress_height'				=> 2,
					// Tooltip Settings
					'tooltipster_allow'				=> 'true',
					'tooltipster_animation'			=> 'fade',
					'tooltipster_position'			=> 'top',
					'tooltipster_theme'				=> 'tooltipster-black',
					'tooltipster_offsetx'			=> 0,
					'tooltipster_offsety'			=> 0,
					// Other Settings
					'margin_top'					=> 0,
					'margin_bottom'					=> 0,
					'el_id'							=> '',
					'el_class'						=> '',
					'css'							=> '',
				), $atts ) );
				
				$output = $styles = '';
				
				$wall_random						= mt_rand(999999, 9999999);
				
				if (!empty($el_id)) {
					$wall_id						= $el_id;
				} else {
					$wall_id						= 'ts-icon-wall-container-' . $wall_random;
				}
				

				// Extract Tab titles from $content
				preg_match_all('/TS_VCSC_Icon_Wall_Item([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE);
				$wall_items 						= array();
				if (isset($matches[1])) {
					$wall_items 					= $matches[1];
				}
				
				$el_class 							= str_replace(".", "", $el_class);				
				if (function_exists('vc_shortcode_custom_css_class')) {
					$css_class 						= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Icon_Wall_Container', $atts);
				} else {
					$css_class						= $el_class;
				}
				
				$data_general						= 'data-random="' . $wall_random . '" data-tooltips="' . $tooltipster_allow . '" data-initial="' . $current . '" data-current="' . $current . '" data-overlap="' . $item_overlap . '" data-shuffle="' . $item_shuffle . '" data-offsetx="' . $tooltipster_offsetx . '" data-offsety="' . $tooltipster_offsety . '" data-spacing="' . $spacing . '" data-fluid="' . $fluid_height . '"';
				$data_breaks						= 'data-large="' . $break_large . '" data-medium="' . $break_medium . '" data-small="' . $break_small . '"';
				$data_autoplay						= 'data-autoplay="' . $autoplay . '" data-delay="' . $delay . '" data-pause="false" data-hover="' . $pausehover . '" data-progressbar="' . $progress_bar . '"';
				if ($tooltipster_allow == 'true') {
					$data_tooltips					= 'data-tooltipster-position="' . $tooltipster_position . '" data-tooltipster-theme="' . $tooltipster_theme . '" data-tooltipster-animation="' . $tooltipster_animation . '" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
				} else {
					$data_tooltips					= '';
				}
				
				if ($wall_frontend == "false") {
					if ($style_custom == "true") {
						$styles .= '<style id="ts-icon-wall-' . $wall_random . '-styles" type="text/css">';
							$styles .= 'body #' . $wall_id . '.ts-icon-wall-container .ts-icon-wall-items-icon-single {';
								$styles .= 'color: ' . $standard_color . ';';
								$styles .= 'background-color: ' . $standard_back . ';';
								$styles .= 'border-color: ' . $standard_border . ';';
							$styles .= '}';
							$styles .= 'body #' . $wall_id . '.ts-icon-wall-container .ts-icon-wall-items-icon-single:hover {';
								$styles .= 'color: ' . $hover_color . ';';
								$styles .= 'background-color: ' . $hover_back . ';';
								$styles .= 'border-color: ' . $hover_border . ';';
							$styles .= '}';
							$styles .= 'body #' . $wall_id . '.ts-icon-wall-container .ts-icon-wall-items-icon-single.active {';
								$styles .= 'color: ' . $active_color . ';';
								$styles .= 'background-color: ' . $active_back . ';';
								$styles .= 'border-color: ' . $active_border . ';';
							$styles .= '}';
						$styles .= '</style>';						
					}
					// Style Output
					$output .= $styles;
					$output .= '<div id="' . $wall_id . '" class="ts-icon-wall-container ' . $css_class . '" ' . $data_general . ' ' . $data_breaks . ' ' . $data_autoplay . ' ' . $data_tooltips . ' style="width: ' . $width . '%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
						// Icon Output
						$output .= '<div class="ts-icon-wall-items-icons" style="">';
							$counter				= 0;
							foreach ($wall_items as $item) {
								$item_atts 			= shortcode_parse_atts($item[0]);
								if (isset($item_atts['animation_type']) && ($item_atts['animation_type'] != 'none') && isset($item_atts['animation_class'])) {
									$item_animate	= 'ts-box-icon ts-icon-wall-items-icon-animated';
									$icon_animate	= 'ts-' . $item_atts['animation_type'] . '-css-' . $item_atts['animation_class'] . '';
								} else {
									$item_animate	= '';
									$icon_animate	= '';
								}
								$output .= '<div id="ts-icon-wall-items-icon-single-' . $wall_random . '-' . $counter . '" class="' . $item_animate . ' ts-icon-wall-items-icon-single ' . ($counter == $current ? '' : '') . ' ' . ($style_shadow == 'true' ? 'ts-icon-wall-items-icon-shadow' : '') . ' ' . (((isset($item_atts['title']) && ($tooltipster_allow == 'true'))) ? 'ts-icon-wall-items-icon-tooltip' : '') . '" data-tooltipset="false" data-tooltipster-text="' . ((isset($item_atts['title'])) ? strip_tags($item_atts['title']) : '') . '" data-tooltipster-offsetx="0" data-tooltipster-offsety="0" data-index="' . $counter . '" style="">';
									$output .= '<i class="' . $item_atts['icon'] . ' ' . $icon_animate . '"></i>';
								$output .= '</div>';
								$counter++;
							}							
						$output .= '</div>';
						// Progressbar Output
						if (($autoplay == 'true') && ($progress_bar == 'true')) {
							$output .= '<div id="ts-icon-wall-auto-progressbar-holder-' . $wall_random . '" class="ts-icon-wall-auto-progressbar-holder" style=""><div id="ts-icon-wall-auto-progressbar-animate-' . $wall_random . '" class="ts-icon-wall-auto-progressbar-animate" data-progress="0" style="background: ' . $progress_color . '; height: ' . $progress_height . 'px;"></div></div>';
						}
						// Content Output
						$output .= '<div class="ts-icon-wall-items-contents" style="">';					
							$output .= do_shortcode($content);					
						$output .= '</div>';
					$output .= '</div>';
				} else {
					$output .= '<div id="' . $wall_id . '" class="ts-icon-wall-container-edit">';
						$output .= do_shortcode($content);
					$output .= '</div>';
				}
				
				$wall_items 						= array();
					
				echo $output;
				
				$myvariable = ob_get_clean();
				return $myvariable;
			}    
			// Icon Wall Item
			function TS_VCSC_IconWall_Item ($atts, $content = null) {
				global $VISUAL_COMPOSER_EXTENSIONS;
				ob_start();
				
				extract( shortcode_atts( array(
					// General Settings
					'replace'			=> 'false',
					'icon'				=> '',
					'image'				=> '',
					'title'				=> '',
					'animation_type'	=> 'none',
					'animation_class'	=> '',				
					'el_id' 			=> '',
					'el_class'			=> '',
					'css'				=> '',
				), $atts ) );
				
				// Check for Front End Editor
				if (function_exists('vc_is_inline')){
					if (vc_is_inline()) {
						$wall_frontend			= "true";
					} else {
						$wall_frontend			= "false";
					}
				} else {
					$wall_frontend				= "false";
				}
				
				$output = '';
				
				$el_class 							= str_replace(".", "", $el_class);				
				if (function_exists('vc_shortcode_custom_css_class')) {
					$css_class 						= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Icon_Wall_Item', $atts);
				} else {
					$css_class						= $el_class;
				}
				
				if ($wall_frontend == "false") {
					$output .= '<div id="" class="ts-icon-wall-items-content-single ' . $css_class . '" data-index="" style="display: none;">';
						if ($title != '') {
							$output .= '<h5 class="ts-icon-wall-items-content-title">' . $title . '</h5>';
						}
						$output .= '<div class="ts-icon-wall-items-content-message">';
							$output .= do_shortcode($content);
						$output .= '</div>';
					$output .= '</div>';
				} else {
					$output .= '<div id="" class="ts-icon-wall-items-content-single-edit" data-index="" style="display: block;">';						
						$output .= '<div class="ts-icon-wall-items-icon-single-edit">';
							$output .= '<i class="' . $icon . '"></i>';
						$output .= '</div>';						
						if ($title != '') {
							$output .= '<h5 class="ts-icon-wall-items-content-title">' . $title . '</h5>';
						}
						$output .= '<div class="ts-icon-wall-items-content-message">';
							$output .= do_shortcode($content);
						$output .= '</div>';
					$output .= '</div>';
				}
					
				echo $output;
				
				$myvariable = ob_get_clean();
				return $myvariable;
			}
			
			// Add Icon Wall Elements
			function TS_VCSC_Add_IconWall_Elements() {
				global $VISUAL_COMPOSER_EXTENSIONS;
				// Add Icon Wall Container
				if (function_exists('vc_map')){
					vc_map( array(
						'name'    							=> __('TS Icon Wall') ,		
						'base'    							=> 'TS_VCSC_Icon_Wall_Container',
						"class"                             => "",
						"icon"                              => "icon-wpb-ts_vcsc_icon_wall_container",
						"category"                          => __("VC Extensions", "ts_visual_composer_extend"),
						"as_parent"                         => array('only' => 'TS_VCSC_Icon_Wall_Item'),
						"description"                       => __("Build an Icon Wall Element", "ts_visual_composer_extend"),
						"controls" 							=> "full",
						"content_element"                   => true,
						"is_container" 						=> true,
						"container_not_allowed" 			=> false,
						"show_settings_on_create"           => true,
						"admin_enqueue_js"            		=> "",
						"admin_enqueue_css"           		=> "",
						'params'                  			=> array(
							// General Settings
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_1",
								"value"						=> "",
								"seperator"					=> "General Settings",
								"description"               => __( "", "ts_visual_composer_extend" ),
							),
							array(
								"type"                      => "nouislider",
								"heading"                   => __( "Current Item", "ts_visual_composer_extend" ),
								"param_name"                => "current",
								"value"                     => "0",
								"min"                       => "0",
								"max"                       => "40",
								"step"                      => "1",
								"unit"                      => '',
								"admin_label"				=> true,
								"description"               => __( "Define the current (initial) icon wall element; use 0 (zero) for the first element.", "ts_visual_composer_extend" ),
							),
							array(
								"type"                      => "nouislider",
								"heading"                   => __( "Item Spacing", "ts_visual_composer_extend" ),
								"param_name"                => "spacing",
								"value"                     => "5",
								"min"                       => "0",
								"max"                       => "20",
								"step"                      => "1",
								"unit"                      => 'px',
								"admin_label"				=> true,
								"description"               => __( "Define the spacing between each icon wall element.", "ts_visual_composer_extend" ),
							),
							array(
								"type"                      => "nouislider",
								"heading"                   => __( "Large Breakpoint", "ts_visual_composer_extend" ),
								"param_name"                => "break_large",
								"value"                     => "1024",
								"min"                       => "800",
								"max"                       => "1600",
								"step"                      => "1",
								"unit"                      => 'px',
								"description"               => __( "Define at which size the layout should use the large icon size.", "ts_visual_composer_extend" ),
							),
							array(
								"type"                      => "nouislider",
								"heading"                   => __( "Medium Breakpoint", "ts_visual_composer_extend" ),
								"param_name"                => "break_medium",
								"value"                     => "768",
								"min"                       => "480",
								"max"                       => "1024",
								"step"                      => "1",
								"unit"                      => 'px',
								"description"               => __( "Define at which size the layout should use the medium icon size.", "ts_visual_composer_extend" ),
							),
							array(
								"type"                      => "nouislider",
								"heading"                   => __( "Small Breakpoint", "ts_visual_composer_extend" ),
								"param_name"                => "break_small",
								"value"                     => "480",
								"min"                       => "0",
								"max"                       => "480",
								"step"                      => "1",
								"unit"                      => 'px',
								"description"               => __( "Define at which size the layout should use the smallest icon size.", "ts_visual_composer_extend" ),
							),
							array(
								"type"              	    => "switch_button",
								"heading"                   => __( "Fluid Height", "ts_visual_composer_extend" ),
								"param_name"                => "fluid_height",
								"value"                     => "true",
								"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
								"off"					    => __( 'No', "ts_visual_composer_extend" ),
								"style"					    => "select",
								"design"				    => "toggle-light",
								"admin_label"				=> true,
								"description"               => __( "Switch the toggle if you want to use a fluid height for the overall icon wall, or a fixed height based on tallest content.", "ts_visual_composer_extend" ),
							),
							array(
								"type"              	    => "switch_button",
								"heading"                   => __( "Item Overlap", "ts_visual_composer_extend" ),
								"param_name"                => "item_overlap",
								"value"                     => "false",
								"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
								"off"					    => __( 'No', "ts_visual_composer_extend" ),
								"style"					    => "select",
								"design"				    => "toggle-light",
								"admin_label"				=> true,
								"description"               => __( "Switch the toggle if you want to have the icon elements overlap or placed as simple grid.", "ts_visual_composer_extend" ),
							),
							// Style Settings
							array(
								"type"              		=> "seperator",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "seperator_2",
								"value"						=> "",
								"seperator"            		=> "Style Settings",
								"description"       		=> __( "", "ts_visual_composer_extend" ),
								"group" 					=> "Style Settings",
							),
							array(
								"type"              	    => "switch_button",
								"heading"                   => __( "Add Shadow", "ts_visual_composer_extend" ),
								"param_name"                => "style_shadow",
								"value"                     => "true",
								"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
								"off"					    => __( 'No', "ts_visual_composer_extend" ),
								"style"					    => "select",
								"design"				    => "toggle-light",
								"description"               => __( "Switch the toggle if you want to apply a box shadow to each icon element.", "ts_visual_composer_extend" ),
								"admin_label"				=> true,
								"group" 					=> "Style Settings",
							),
							array(
								"type"              	    => "switch_button",
								"heading"                   => __( "Use Custom Colors", "ts_visual_composer_extend" ),
								"param_name"                => "style_custom",
								"value"                     => "false",
								"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
								"off"					    => __( 'No', "ts_visual_composer_extend" ),
								"style"					    => "select",
								"design"				    => "toggle-light",
								"description"               => __( "Switch the toggle if you want to use custom colors for the icon wall elements.", "ts_visual_composer_extend" ),
								"group" 					=> "Style Settings",
							),
							array(
								'type' 						=> 'colorpicker',
								'heading' 					=> __( 'Standard Icon Color', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'standard_color',
								'value'						=> '#676767',
								'description' 				=> __( 'Define the standard icon color for each element.', 'ts_visual_composer_extend' ),
								"dependency"		    	=> array( 'element' => "style_custom", 'value' => 'true' ),
								"group" 					=> "Style Settings",
							),
							array(
								'type' 						=> 'colorpicker',
								'heading' 					=> __( 'Standard Background Color', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'standard_back',
								'value'						=> '#ffffff',
								'description' 				=> __( 'Define the standard background color for each element.', 'ts_visual_composer_extend' ),
								"dependency"		    	=> array( 'element' => "style_custom", 'value' => 'true' ),
								"group" 					=> "Style Settings",
							),
							array(
								'type' 						=> 'colorpicker',
								'heading' 					=> __( 'Standard Border Color', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'standard_border',
								'value'						=> '#cccccc',
								'description' 				=> __( 'Define the standard border color for each element.', 'ts_visual_composer_extend' ),
								"dependency"		    	=> array( 'element' => "style_custom", 'value' => 'true' ),
								"group" 					=> "Style Settings",
							),							
							array(
								'type' 						=> 'colorpicker',
								'heading' 					=> __( 'Hover Icon Color', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'hover_color',
								'value'						=> '#676767',
								'description' 				=> __( 'Define the hover icon color for each element.', 'ts_visual_composer_extend' ),
								"dependency"		    	=> array( 'element' => "style_custom", 'value' => 'true' ),
								"group" 					=> "Style Settings",
							),
							array(
								'type' 						=> 'colorpicker',
								'heading' 					=> __( 'Hover Background Color', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'hover_back',
								'value'						=> '#FFD800',
								'description' 				=> __( 'Define the hover background color for each element.', 'ts_visual_composer_extend' ),
								"dependency"		    	=> array( 'element' => "style_custom", 'value' => 'true' ),
								"group" 					=> "Style Settings",
							),
							array(
								'type' 						=> 'colorpicker',
								'heading' 					=> __( 'Hover Border Color', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'hover_border',
								'value'						=> '#cccccc',
								'description' 				=> __( 'Define the hover border color for each element.', 'ts_visual_composer_extend' ),
								"dependency"		    	=> array( 'element' => "style_custom", 'value' => 'true' ),
								"group" 					=> "Style Settings",
							),
							array(
								'type' 						=> 'colorpicker',
								'heading' 					=> __( 'Active Icon Color', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'active_color',
								'value'						=> '#ffffff',
								'description' 				=> __( 'Define the active icon color for each element.', 'ts_visual_composer_extend' ),
								"dependency"		    	=> array( 'element' => "style_custom", 'value' => 'true' ),
								"group" 					=> "Style Settings",
							),
							array(
								'type' 						=> 'colorpicker',
								'heading' 					=> __( 'Active Background Color', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'active_back',
								'value'						=> '#AE0000',
								'description' 				=> __( 'Define the active background color for each element.', 'ts_visual_composer_extend' ),
								"dependency"		    	=> array( 'element' => "style_custom", 'value' => 'true' ),
								"group" 					=> "Style Settings",
							),
							array(
								'type' 						=> 'colorpicker',
								'heading' 					=> __( 'Active Border Color', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'active_border',
								'value'						=> '#cccccc',
								'description' 				=> __( 'Define the active border color for each element.', 'ts_visual_composer_extend' ),
								"dependency"		    	=> array( 'element' => "style_custom", 'value' => 'true' ),
								"group" 					=> "Style Settings",
							),
							// AutoPlay Settings
							array(
								"type"              		=> "seperator",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "seperator_3",
								"value"						=> "",
								"seperator"            		=> "Rotate Settings",
								"description"       		=> __( "", "ts_visual_composer_extend" ),
								"group" 					=> "Rotate Settings",
							),
							array(
								"type"              	    => "switch_button",
								"heading"                   => __( "Use Auto Rotation", "ts_visual_composer_extend" ),
								"param_name"                => "autoplay",
								"value"                     => "false",
								"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
								"off"					    => __( 'No', "ts_visual_composer_extend" ),
								"style"					    => "select",
								"design"				    => "toggle-light",
								"description"               => __( "Switch the toggle if you want to apply an auto-rotation to the icon wall element.", "ts_visual_composer_extend" ),
								"admin_label"				=> true,
								"group" 					=> "Rotate Settings",
							),
							array(
								"type"                      => "nouislider",
								"heading"                   => __( "Rotation Delay", "ts_visual_composer_extend" ),
								"param_name"                => "delay",
								"value"                     => "5000",
								"min"                       => "1000",
								"max"                       => "20000",
								"step"                      => "100",
								"unit"                      => 'ms',
								"description"               => __( "Select the delay between each icon rotation.", "ts_visual_composer_extend" ),
								"dependency"				=> array( 'element' => "autoplay", 'value' => 'true' ),
								"group" 			        => "Rotate Settings",
							),
							array(
								"type"                  	=> "switch_button",
								"heading"			    	=> __( "Pause on Hover", "ts_visual_composer_extend" ),
								"param_name"		    	=> "pausehover",
								"value"                 	=> "true",
								"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
								"style"				    	=> "select",
								"design"			    	=> "toggle-light",
								"description"		    	=> __( "Switch the toggle if you want to pause the timer when hovering over the icon wall.", "ts_visual_composer_extend" ),
								"dependency"		    	=> array( 'element' => "autoplay", 'value' => 'true' ),
								"group" 					=> "Rotate Settings",
							),
							array(
								"type"                  	=> "switch_button",
								"heading"			    	=> __( "Show Progressbar", "ts_visual_composer_extend" ),
								"param_name"		    	=> "progress_bar",
								"value"                 	=> "true",
								"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
								"style"				    	=> "select",
								"design"			    	=> "toggle-light",
								"description"		    	=> __( "Switch the toggle if you want to show a progressbar for the delay timer.", "ts_visual_composer_extend" ),
								"dependency"		    	=> array( 'element' => "autoplay", 'value' => 'true' ),
								"group" 					=> "Rotate Settings",
							),
							array(
								'type' 						=> 'colorpicker',
								'heading' 					=> __( 'Progressbar Color', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'progress_color',
								'value'						=> '#f7f7f7',
								'description' 				=> __( 'Define the color for the progressbar.', 'ts_visual_composer_extend' ),
								"dependency"		    	=> array( 'element' => "progress_bar", 'value' => 'true' ),
								"group" 					=> "Rotate Settings",
							),
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Progressbar Height", "ts_visual_composer_extend" ),
								"param_name"				=> "progress_height",
								"value"						=> "2",
								"min"						=> "1",
								"max"						=> "20",
								"step"						=> "1",
								"unit"						=> 'px',
								"description"				=> __( "Define the height of the progressbar.", "ts_visual_composer_extend" ),
								"dependency"		    	=> array( 'element' => "progress_bar", 'value' => 'true' ),
								"group" 					=> "Rotate Settings",
							),
							// Tooltip Settings
							array(
								"type"              		=> "seperator",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "seperator_4",
								"value"						=> "",
								"seperator"            		=> "Tooltip Settings",
								"description"       		=> __( "", "ts_visual_composer_extend" ),
								"group" 					=> "Tooltip Settings",
							),
							array(
								"type"              	    => "switch_button",
								"heading"                   => __( "Show Tooltips", "ts_visual_composer_extend" ),
								"param_name"                => "tooltipster_allow",
								"value"                     => "true",
								"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
								"off"					    => __( 'No', "ts_visual_composer_extend" ),
								"style"					    => "select",
								"design"				    => "toggle-light",
								"description"               => __( "Switch the toggle if you want to show the title for each segment via tooltip when hovering over the icons.", "ts_visual_composer_extend" ),
								"admin_label"				=> true,
								"group" 					=> "Tooltip Settings",
							),
							array(
								"type"						=> "dropdown",
								"class"						=> "",
								"heading"					=> __( "Tooltip Position", "ts_visual_composer_extend" ),
								"param_name"				=> "tooltipster_position",
								"value"						=> array(
									__( "Top", "ts_visual_composer_extend" )                            => "top",
									__( "Bottom", "ts_visual_composer_extend" )                         => "bottom",
								),
								"description"				=> __( "Select the tooltip position in relation to the element.", "ts_visual_composer_extend" ),
								"dependency"				=> array( 'element' => "tooltipster_allow", 'value' => 'true' ),
								"group" 					=> "Tooltip Settings",
							),	
							array(
								"type"						=> "dropdown",
								"class"						=> "",
								"heading"					=> __( "Tooltip Style", "ts_visual_composer_extend" ),
								"param_name"				=> "tooltipster_theme",
								"value"             		=> array(
									__( "Black", "ts_visual_composer_extend" )                          => "tooltipster-black",
									__( "Gray", "ts_visual_composer_extend" )                           => "tooltipster-gray",
									__( "Green", "ts_visual_composer_extend" )                          => "tooltipster-green",
									__( "Blue", "ts_visual_composer_extend" )                           => "tooltipster-blue",
									__( "Red", "ts_visual_composer_extend" )                            => "tooltipster-red",
									__( "Orange", "ts_visual_composer_extend" )                         => "tooltipster-orange",
									__( "Yellow", "ts_visual_composer_extend" )                         => "tooltipster-yellow",
									__( "Purple", "ts_visual_composer_extend" )                         => "tooltipster-purple",
									__( "Pink", "ts_visual_composer_extend" )                           => "tooltipster-pink",
									__( "White", "ts_visual_composer_extend" )                          => "tooltipster-white"
								),
								"description"				=> __( "Select the tooltip style.", "ts_visual_composer_extend" ),
								"dependency"				=> array( 'element' => "tooltipster_allow", 'value' => 'true' ),
								"group" 					=> "Tooltip Settings",
							),							
							array(
								"type"						=> "dropdown",
								"class"						=> "",
								"heading"					=> __( "Tooltip Animation", "ts_visual_composer_extend" ),
								"param_name"				=> "tooltipster_animation",
								"value"             		=> array(
									__( "Fade", "ts_visual_composer_extend" )                          => "fade",
									__( "Grow", "ts_visual_composer_extend" )                          => "grow",
									__( "Swing", "ts_visual_composer_extend" )                         => "swing",
									__( "Slide", "ts_visual_composer_extend" )                         => "slide",
									__( "Fall", "ts_visual_composer_extend" )                          => "fall",
								),
								"description"				=> __( "Select the tooltip entry/exit animation.", "ts_visual_composer_extend" ),
								"dependency"				=> array( 'element' => "tooltipster_allow", 'value' => 'true' ),
								"group" 					=> "Tooltip Settings",
							),							
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Tooltip X-Offset", "ts_visual_composer_extend" ),
								"param_name"				=> "tooltipster_offsetx",
								"value"						=> "0",
								"min"						=> "-100",
								"max"						=> "100",
								"step"						=> "1",
								"unit"						=> 'px',
								"description"				=> __( "Define an optional X-Offset for the tooltip position.", "ts_visual_composer_extend" ),
								"dependency"				=> array( 'element' => "tooltipster_allow", 'value' => 'true' ),
								"group" 					=> "Tooltip Settings",
							),
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Tooltip Y-Offset", "ts_visual_composer_extend" ),
								"param_name"				=> "tooltipster_offsety",
								"value"						=> "0",
								"min"						=> "-100",
								"max"						=> "100",
								"step"						=> "1",
								"unit"						=> 'px',
								"description"				=> __( "Define an optional Y-Offset for the tooltip position.", "ts_visual_composer_extend" ),
								"dependency"				=> array( 'element' => "tooltipster_allow", 'value' => 'true' ),
								"group" 					=> "Tooltip Settings",
							),		
							// Other Settings
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_5",
								"value"						=> "",
								"seperator"					=> "Other Settings",
								"description"               => __( "", "ts_visual_composer_extend" ),
								"group" 			        => "Other Settings",
							),
							array(
								"type"                      => "nouislider",
								"heading"                   => __( "Margin: Top", "ts_visual_composer_extend" ),
								"param_name"                => "margin_top",
								"value"                     => "0",
								"min"                       => "0",
								"max"                       => "200",
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
								"min"                       => "0",
								"max"                       => "200",
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
								"param_name"                => "el_class",
								"value"                     => "",
								"description"               => __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
								"group" 			       	=> "Other Settings",
							),
							// Load Custom CSS/JS File
							array(
								"type"              		=> "load_file",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "el_file",
								"value"             		=> "",
								"file_type"         		=> "js",
								"file_path"         		=> "js/ts-visual-composer-extend-element.min.js",
								"description"       		=> __( "", "ts_visual_composer_extend" )
							),
						),
						"js_view"                           => 'VcColumnView'
					));
				}
				// Add Icon Wall Item
				if (function_exists('vc_map')){
					vc_map( array(
						'name' 								=> __('Icon Wall Item', 'ts_visual_composer_extend'),
						'base' 								=> 'TS_VCSC_Icon_Wall_Item',
						"icon" 	                    		=> "icon-wpb-ts_vcsc_icon_wall_item",
						"class"                     		=> "",
						"content_element"					=> true,
						"controls"							=> "full",						
						'is_container' 						=> false,
						"as_child" 							=> array('only' => 'TS_VCSC_Icon_Wall_Container'),
						'params' 							=> array(
							array(
								"type"              		=> "seperator",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "seperator_1",
								"value"						=> "",
								"seperator"             	=> "General Settings",
								"description"       		=> __( "", "ts_visual_composer_extend" ),
							),
							array(
								'type' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
								'heading' 					=> __( 'Icon', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'icon',
								'value'						=> '',
								'source'					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorValue,
								'settings' 					=> array(
									'emptyIcon' 					=> false,
									'type' 							=> 'extensions',
									'iconsPerPage' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
									'source' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorSource,
								),
								"admin_label"				=> true,
								"description"       		=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon for the tab.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
								"dependency"            	=> "",
							),
							array(
								'type' 						=> 'dropdown',
								'heading' 					=> __( 'Animation Type', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'animation_type',
								'value' => array(
									__('No Animation', 'ts_visual_composer_extend') 	=> 'none',
									__('Hover', 'ts_visual_composer_extend') 			=> 'hover',
									__('Infinite', 'ts_visual_composer_extend')			=> 'infinite',
								),
								"admin_label"				=> true,
								'description' 				=> __( 'Select what animation type the icon should be using.', 'ts_visual_composer_extend' )
							),	
							array(
								"type"						=> "css3animations",
								"class"						=> "",
								"heading"					=> __("Icon Animation", "ts_visual_composer_extend"),
								"param_name"				=> "animation_class",
								"standard"					=> "false",
								"prefix"					=> "",
								"connector"					=> "css3animations_in",
								"noneselect"				=> "true",
								"default"					=> "",
								"value"						=> "",
								"dependency"				=> array( 'element' => "animation_type", 'value' => array('hover', 'infinite') ),
								"description"				=> __("Select the hover animation for the icon.", "ts_visual_composer_extend"),
							),
							array(
								"type"						=> "hidden_input",
								"heading"					=> __( "Icon Animation", "ts_visual_composer_extend" ),
								"param_name"				=> "css3animations_in",
								"value"						=> "",
								"description"				=> __( "", "ts_visual_composer_extend" ),
							),
							array (
								'type' 						=> 'textfield',
								'heading' 					=> __( 'Title', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'title',
								"admin_label"				=> true,
								'description' 				=> __( 'Provide a title or name for this icon wall element.', 'ts_visual_composer_extend' )
							),
							array(
								"type"						=> "textarea_html",
								"class"						=> "",
								"heading"					=> __( "Content", "ts_visual_composer_extend" ),
								"param_name"				=> "content",
								"value"						=> "",
								"description"				=> __( "Create the content for this icon wall element.", "ts_visual_composer_extend" ),
								"dependency"				=> "",
							),
							// Load Custom CSS/JS File
							array(
								"type"						=> "load_file",
								"heading"					=> __( "", "ts_visual_composer_extend" ),
								"value"						=> "",
								"param_name"				=> "el_file1",
								"file_type"					=> "js",
								"file_path"					=> "js/ts-visual-composer-extend-element.min.js",
								"description"				=> __( "", "ts_visual_composer_extend" )
							),
							array(
								"type"						=> "load_file",
								"heading"					=> __( "", "ts_visual_composer_extend" ),
								"value"						=> "",
								"param_name"				=> "el_file2",
								"file_type"					=> "css",
								"file_id"					=> "ts-extend-animations",
								"file_path"					=> "css/ts-visual-composer-extend-animations.min.css",
								"description"				=> __( "", "ts_visual_composer_extend" )
							),
						),
					));
				}		
			}
		}
	}
	
	if (class_exists('WPBakeryShortCodesContainer')) {
		class WPBakeryShortCode_TS_VCSC_Icon_Wall_Container extends WPBakeryShortCodesContainer {};
	}
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_Icon_Wall_Item extends WPBakeryShortCode {};
	}
	// Initialize "TS Icon Wall" Class
	if (class_exists('TS_Icon_Wall')) {
		$TS_Icon_Wall = new TS_Icon_Wall;
	}
?>