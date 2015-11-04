<?php
if (!class_exists('TS_Anything_Slider')){
	class TS_Anything_Slider {
		function __construct() {
			global $VISUAL_COMPOSER_EXTENSIONS;
            if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
                add_action('init',                              		array($this, 'TS_VCSC_Anything_Slider_Elements'), 9999999);
            } else {
                add_action('admin_init',		                		array($this, 'TS_VCSC_Anything_Slider_Elements'), 9999999);
            }
			add_shortcode('TS_VCSC_Anything_Slider',       				array($this, 'TS_VCSC_Anything_Slider'));
		}
        
		// Anything Slider
		function TS_VCSC_Anything_Slider ($atts, $content = null){
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();
	
			wp_enqueue_style('ts-font-ecommerce');
			wp_enqueue_style('ts-extend-animations');
			wp_enqueue_style('ts-extend-simptip');
			wp_enqueue_style('ts-extend-buttons');
			wp_enqueue_style('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-front');
			
			extract( shortcode_atts( array(
				'slider_type'					=> 'owlslider',
				'number_teasers'				=> 1,
				'break_custom'					=> 'false',
				'break_string'					=> '1,2,3,4,5,6,7,8',
				'auto_height'                   => 'true',
				'page_rtl'						=> 'false',
				'auto_play'                     => 'false',
				'show_playpause'				=> 'true',
				'show_bar'                      => 'true',
				'bar_color'                     => '#dd3333',
				'show_speed'                    => 5000,
				'stop_hover'                    => 'true',
				'show_navigation'               => 'true',
				'show_dots'						=> 'true',
				'page_numbers'                  => 'false',
				'items_loop'					=> 'true',
				'slide_margin'					=> 10,
				
				'flex_navigation'				=> 'true',
				'flex_animation'				=> 'slide',
				'flex_margin'					=> 10,
				'flex_breaks_single'			=> '240,480,720,960,1280,1600,1980',
				
				'animation_in'					=> 'ts-viewport-css-flipInX',
				'animation_out'					=> 'ts-viewport-css-slideOutDown',
				'animation_mobile'				=> 'false',
				'margin_top'                    => 0,
				'margin_bottom'                 => 0,
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			), $atts ));
			
			$teaser_random                    	= mt_rand(999999, 9999999);
			
			// Check for Front End Editor
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$slider_class					= 'owl-carousel2-edit';
				$flex_class						= 'flex-carousel-edit';
				$slider_message					= '<div class="ts-composer-frontedit-message">' . __( 'The slider is currently viewed in front-end edit mode; slider features are disabled for performance and compatibility reasons.', "ts_visual_composer_extend" ) . '</div>';
				$product_style					= 'width: ' . (100 / $number_teasers) . '%; height: 100%; float: left; margin: 0; padding: 0;';
				$frontend_edit					= 'true';
			} else {
				$slider_class					= 'ts-owlslider-parent owl-carousel2';
				$flex_class						= 'ts-flexslider-parent flex-carousel';
				$slider_message					= '';
				$product_style					= '';
				$frontend_edit					= 'false';
			}
			
			if (!empty($el_id)) {
				$any_slider_id			    	= $el_id;
			} else {
				$any_slider_id			    	= 'ts-vcsc-anyslider-' . $teaser_random;
			}
			
			$output = '';
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-vcsc-anyslider ' . $slider_class . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Anything_Slider', $atts);
			} else {
				$css_class	= 'ts-vcsc-anyslider ' . $slider_class . ' ' . $el_class;
			}			
			
			if ($slider_type == "owlslider") {
				wp_enqueue_style('ts-extend-owlcarousel2');
				wp_enqueue_script('ts-extend-owlcarousel2');
				$output .= '<div id="' . $any_slider_id . '-container" class="ts-vcsc-anyslider-container" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
					// Front-Edit Message
					if ($frontend_edit == "true") {
						$output .= $slider_message;
					}
					// Add Progressbar
					if (($auto_play == "true") && ($show_bar == "true") && ($frontend_edit == "false")) {
						$output .= '<div id="ts-owlslider-progressbar-' . $teaser_random . '" class="ts-owlslider-progressbar-holder" style=""><div class="ts-owlslider-progressbar" style="background: ' . $bar_color . '; height: 100%; width: 0%;"></div></div>';
					}
					// Add Navigation Controls
					if ($frontend_edit == "false") {
						$output .= '<div id="ts-owlslider-controls-' . $teaser_random . '" class="ts-owlslider-controls" style="' . (((($auto_play == "true") && ($show_playpause == "true")) || ($show_navigation == "true")) ? "display: block;" : "display: none;") . '">';
							$output .= '<div id="ts-owlslider-controls-next-' . $teaser_random . '" style="' . (($show_navigation == "true") ? "display: block;" : "display: none;") . '" class="ts-owlslider-controls-next"><span class="ts-ecommerce-arrowright5"></span></div>';
							$output .= '<div id="ts-owlslider-controls-prev-' . $teaser_random . '" style="' . (($show_navigation == "true") ? "display: block;" : "display: none;") . '" class="ts-owlslider-controls-prev"><span class="ts-ecommerce-arrowleft5"></span></div>';
							if (($auto_play == "true") && ($show_playpause == "true")) {
								$output .= '<div id="ts-owlslider-controls-play-' . $teaser_random . '" class="ts-owlslider-controls-play active"><span class="ts-ecommerce-pause"></span></div>';
							}
						$output .= '</div>';
					}
					// Add Slider
					$output .= '<div id="' . $any_slider_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;" data-id="' . $teaser_random . '" data-items="' . $number_teasers . '" data-breakpointscustom="' . $break_custom . '" data-breakpointitems="' . $break_string . '" data-rtl="' . $page_rtl . '" data-loop="' . $items_loop . '" data-navigation="' . $show_navigation . '" data-dots="' . $show_dots . '" data-mobile="' . $animation_mobile . '" data-animationin="' . $animation_in . '" data-animationout="' . $animation_out . '" data-height="' . $auto_height . '" data-play="' . $auto_play . '" data-bar="' . $show_bar . '" data-color="' . $bar_color . '" data-speed="' . $show_speed . '" data-hover="' . $stop_hover . '" data-margin="' . $slide_margin . '">';
						$output .= do_shortcode($content);
					$output .= '</div>';
				$output .= '</div>';
			}
			if ($slider_type == "flexslider") {
				wp_enqueue_style('ts-extend-flexslider2');
				wp_enqueue_script('ts-extend-flexslider2');
				if ($flex_animation == "fade") {
					$number_teasers 		= 1;
					$flex_margin 			= 0;
				}
				//$output .= '<div id="' . $any_slider_id . '-container" class="ts-vcsc-anyslider-container ts-flexslider-container">';
				$output .= '<div id="' . $any_slider_id . '-container" class="ts-flexslider-container ts-anyslider-flexslider-container clearFixMe" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;" data-main="ts-anyslider-flexslider-main-' . $teaser_random . '" data-frontend="' . $frontend_edit . '" data-id="' . $teaser_random . '" data-count="" data-combo="false" data-thumbs="" data-images="" data-margin="' . $flex_margin . '" data-rtl="' . $page_rtl . '" data-navigation="' . $flex_navigation . '" data-animation="' . $flex_animation . '" data-play="' . $auto_play . '" data-bar="' . $show_bar . '" data-color="' . $bar_color . '" data-speed="' . $show_speed . '" data-hover="' . $stop_hover . '">';
					// Front-Edit Message
					if ($frontend_edit == "true") {
						$output .= $slider_message;
					}
					// Add Progressbar
					if (($auto_play == "true") && ($show_bar == "true") && ($frontend_edit == "false")) {
						$output .= '<div id="ts-flexslider-progressbar-container-' . $teaser_random . '" class="ts-flexslider-progressbar-container" style="width: 100%; height: 100%; background: #ededed;"><div id="ts-flexslider-progressbar-' . $teaser_random . '" class="ts-flexslider-progressbar" style="background: ' . $bar_color . '; height: 10px;"></div></div>';
					}
					// Add Slider (Main)
					$output .= '<div id="ts-anyslider-flexslider-main-' . $teaser_random . '" class="' . $flex_class . ' ts-anyslider-flexslider ts-anyslider-flexslider-main" data-id="' . $teaser_random . '" data-breaks="' . $flex_breaks_single . '">';
						$output .= '<div class="slides">';
							$output .= do_shortcode($content);
						$output .= '</div>';
						// Add Play/Pause Control
						if (($auto_play == "true") && ($show_playpause == "true")) {
							$output .= '<div id="ts-flexslider-controls-' . $teaser_random . '" class="ts-flexslider-controls" style="display: none;">';
								$output .= '<div id="ts-flexslider-controls-play-' . $teaser_random . '" class="ts-flexslider-controls-play active"><span class="ts-ecommerce-pause"></span></div>';
							$output .= '</div>';
						}
					$output .= '</div>';
				$output .= '</div>';
			}
			
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
	
		// Add Anything Slider Elements
        function TS_VCSC_Anything_Slider_Elements() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			// Add Anything Slider (Custom Build)
			if (function_exists('vc_map')) {
				vc_map(array(
					"name"                              => __("TS Almost Anything Slider", "ts_visual_composer_extend"),
					"base"                              => "TS_VCSC_Anything_Slider",
					"class"                             => "",
					"icon"                              => "icon-wpb-ts_vcsc_anything_slider",
					"category"                          => __("VC Extensions", "ts_visual_composer_extend"),
					"as_parent"                       	=> array('except' => implode(",", $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_AnySlider_Excluded)),
					"description"                       => __("Build a custom Slider with any content", "ts_visual_composer_extend"),
					"controls" 							=> "full",
					"content_element"                   => true,
					"is_container" 						=> true,
					"container_not_allowed" 			=> false,
					"show_settings_on_create"           => true,
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
					"params"							=> array(
						// Slider Settings
						array(
							"type"                      => "seperator",
							"heading"                   => __( "", "ts_visual_composer_extend" ),
							"param_name"                => "seperator_1",
							"value"						=> "",
							"seperator"					=> "Slider Settings",
							"description"               => __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"              		=> "messenger",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "messenger",
							"color"						=> "#c60000",
							"weight"					=> "normal",
							"size"						=> "14",
							"value"						=> "",
							"border_top"				=> "false",
							"padding_top"				=> 0,
							"margin-top"				=> 0,
							"message"            		=> __( "Not every element is suitable to be used inside another element, such as this slider, and not every element feature or style will work when used inside another element. Please select the elements you want to add to this slider carefully in order to avoid style or feature conflicts.", "ts_visual_composer_extend" ),
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type" 						=> "css3animations",
							"class" 					=> "",
							"heading" 					=> __("In-Animation Type", "ts_visual_composer_extend"),
							"param_name" 				=> "animation_in",
							"standard"					=> "false",
							"prefix"					=> "ts-viewport-css-",
							"connector"					=> "css3animations_in",
							"default"					=> "flipInX",
							"value" 					=> "",
							"admin_label"				=> false,
							"description" 				=> __("Select the CSS3 in-animation you want to apply to the slider.", "ts_visual_composer_extend"),
							"dependency"            	=> "",
						),
						array(
							"type"                      => "hidden_input",
							"heading"                   => __( "In-Animation Type", "ts_visual_composer_extend" ),
							"param_name"                => "css3animations_in",
							"value"                     => "",
							"admin_label"		        => true,
							"description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
						),						
						array(
							"type" 						=> "css3animations",
							"class" 					=> "",
							"heading" 					=> __("Out-Animation Type", "ts_visual_composer_extend"),
							"param_name" 				=> "animation_out",
							"standard"					=> "false",
							"prefix"					=> "ts-viewport-css-",
							"connector"					=> "css3animations_out",
							"default"					=> "slideOutDown",
							"value" 					=> "",
							"admin_label"				=> false,
							"description" 				=> __("Select the CSS3 out-animation you want to apply to the slider.", "ts_visual_composer_extend"),
							"dependency"            	=> "",
						),
						array(
							"type"                      => "hidden_input",
							"heading"                   => __( "Out-Animation Type", "ts_visual_composer_extend" ),
							"param_name"                => "css3animations_out",
							"value"                     => "",
							"admin_label"		        => true,
							"description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
						),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Animate on Mobile", "ts_visual_composer_extend" ),
                            "param_name"                => "animation_mobile",
                            "value"                     => "false",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the CSS3 animations on mobile devices.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                        ),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Auto-Height", "ts_visual_composer_extend" ),
							"param_name"                => "auto_height",
							"value"                     => "true",
							"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"					    => __( 'No', "ts_visual_composer_extend" ),
							"style"					    => "select",
							"design"				    => "toggle-light",
							"admin_label"		        => true,
							"description"               => __( "Switch the toggle if you want the slider to auto-adjust its height.", "ts_visual_composer_extend" ),
							"dependency"                => ""
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Max. Number of Elements", "ts_visual_composer_extend" ),
							"param_name"                => "number_teasers",
							"value"                     => "1",
							"min"                       => "1",
							"max"                       => "50",
							"step"                      => "1",
							"unit"                      => '',
							"description"               => __( "Define the maximum number of elements per slide.", "ts_visual_composer_extend" ),
							"dependency" 				=> ""
						),						
						array(
							"type"						=> "switch_button",
							"heading"					=> __( "Custom Number Settings", "ts_visual_composer_extend" ),
							"param_name"				=> "break_custom",
							"value"						=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"				=> __( "Switch the toggle if you want to define different numbers of elements per slide for pre-defined slider widths.", "ts_visual_composer_extend" ),
						),
						array(
							"type"                  	=> "textfield",
							"heading"               	=> __( "Items per Slide", "ts_visual_composer_extend" ),
							"param_name"            	=> "break_string",
							"value"                 	=> "1,2,3,4,5,6,7,8",
							"description"           	=> __( "Define the number of items per slide based on the following slider widths: 0,360,720,960,1280,1440,1600,1920; seperate by comma (total of 8 values required).", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "break_custom", 'value' => 'true' ),
						),						
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Element Spacing", "ts_visual_composer_extend" ),
							"param_name"                => "slide_margin",
							"value"                     => "10",
							"min"                       => "0",
							"max"                       => "50",
							"step"                      => "1",
							"unit"                      => 'px',
							"description"               => __( "Define the spacing between slide elements (if more than one element is shown per slide).", "ts_visual_composer_extend" ),
							"dependency" 				=> ""
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "RTL Page", "ts_visual_composer_extend" ),
							"param_name"                => "page_rtl",
							"value"                     => "false",
							"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"					    => __( 'No', "ts_visual_composer_extend" ),
							"style"					    => "select",
							"design"				    => "toggle-light",
							"description"               => __( "Switch the toggle if the slider is used on a page with RTL (Right-To-Left) alignment.", "ts_visual_composer_extend" ),
							"dependency"                => ""
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Auto-Play", "ts_visual_composer_extend" ),
							"param_name"                => "auto_play",
							"value"                     => "false",
							"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"					    => __( 'No', "ts_visual_composer_extend" ),
							"style"					    => "select",
							"design"				    => "toggle-light",
							"admin_label"		        => true,
							"description"               => __( "Switch the toggle if you want the auto-play the slider on page load.", "ts_visual_composer_extend" ),
							"dependency"                => ""
						),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Play / Pause", "ts_visual_composer_extend" ),
                            "param_name"                => "show_playpause",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show a play / pause button to control the autoplay.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "auto_play", "value" => "true"),
                        ),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Show Progressbar", "ts_visual_composer_extend" ),
							"param_name"                => "show_bar",
							"value"                     => "true",
							"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"					    => __( 'No', "ts_visual_composer_extend" ),
							"style"					    => "select",
							"design"				    => "toggle-light",
							"description"               => __( "Switch the toggle if you want to show a progressbar during auto-play.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "auto_play", "value" 	=> "true"),
						),
						array(
							"type"                      => "colorpicker",
							"heading"                   => __( "Progressbar Color", "ts_visual_composer_extend" ),
							"param_name"                => "bar_color",
							"value"                     => "#dd3333",
							"description"               => __( "Define the color of the animated progressbar.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "auto_play", "value" 	=> "true"),
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Auto-Play Speed", "ts_visual_composer_extend" ),
							"param_name"                => "show_speed",
							"value"                     => "5000",
							"min"                       => "1000",
							"max"                       => "20000",
							"step"                      => "100",
							"unit"                      => 'ms',
							"description"               => __( "Define the speed used to auto-play the slider.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "auto_play","value" 	=> "true"),
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Stop on Hover", "ts_visual_composer_extend" ),
							"param_name"                => "stop_hover",
							"value"                     => "true",
							"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"					    => __( 'No', "ts_visual_composer_extend" ),
							"style"					    => "select",
							"design"				    => "toggle-light",
							"description"               => __( "Switch the toggle if you want the stop the auto-play while hovering over the slider.", "ts_visual_composer_extend" ),
							"dependency"                => array( 'element' => "auto_play", 'value' => 'true' )
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Show Top Navigation", "ts_visual_composer_extend" ),
							"param_name"                => "show_navigation",
							"value"                     => "true",
							"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"					    => __( 'No', "ts_visual_composer_extend" ),
							"style"					    => "select",
							"design"				    => "toggle-light",
							"description"               => __( "Switch the toggle if you want to show left/right navigation buttons for the slider.", "ts_visual_composer_extend" ),
							"dependency"                => ""
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Show Dots", "ts_visual_composer_extend" ),
							"param_name"                => "show_dots",
							"value"                     => "true",
							"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"					    => __( 'No', "ts_visual_composer_extend" ),
							"style"					    => "select",
							"design"				    => "toggle-light",
							"description"               => __( "Switch the toggle if you want to show dot navigation buttons below the slider.", "ts_visual_composer_extend" ),
							"dependency"                => ""
						),
						// Other Settings
						array(
							"type"                      => "seperator",
							"heading"                   => __( "", "ts_visual_composer_extend" ),
							"param_name"                => "seperator_2",
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
							"group" 			        => "Other Settings",
						),
						// Load Custom CSS/JS File
                        array(
                            "type"                      => "load_file",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "el_file1",
                            "value"                     => "",
                            "file_type"                 => "js",
							"file_id"         			=> "ts-extend-element",
                            "file_path"                 => "js/ts-visual-composer-extend-element.min.js",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
						array(
							"type"              		=> "load_file",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "el_file2",
							"value"             		=> "",
							"file_type"         		=> "css",
							"file_id"         			=> "ts-extend-animations",
							"file_path"         		=> "css/ts-visual-composer-extend-animations.min.css",
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),
					),
					"js_view"                           => 'VcColumnView'
				));
			}
		}
	}
}
// Register Container and Child Shortcode with Visual Composer
if (class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_TS_VCSC_Anything_Slider extends WPBakeryShortCodesContainer {};
}
// Initialize "TS Anything Slider" Class
if (class_exists('TS_Anything_Slider')) {
	$TS_Anything_Slider = new TS_Anything_Slider;
}