<?php
if (!class_exists('TS_Element_Focus')){
	class TS_Element_Focus{
		function __construct(){
			global $VISUAL_COMPOSER_EXTENSIONS;
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				add_action('init',                              		array($this, 'TS_VCSC_Add_Focus_Element'), 9999999);
			} else {
				add_action('admin_init',		                		array($this, 'TS_VCSC_Add_Focus_Element'), 9999999);
			}
			add_shortcode('TS_VCSC_Element_Focus',          			array($this, 'TS_VCSC_Focus_Frame_Function'));
		}
		
		function TS_VCSC_Focus_Frame_Function($atts, $content = null){
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();

			extract(shortcode_atts(array(
				// Focus Settings
				"enable"						=> "true",
				"delay"							=> 0,
				"timer"							=> 0,
				"wait"							=> 5000,
				"opacity"						=> 50,
				"speed"							=> "medium",
				"focus_color"					=> "#066BC0",
				"frame_strength"				=> 10,
				"frame_color"					=> "#cccccc",
				"viewport_show"					=> "false",
				"viewport_once"					=> "true",
				"pageload"						=> "false",
				"repeat"						=> "false",
				"padding_x"						=> 20,
				"padding_y"						=> 20,
				"mobile"						=> "false",
				"raster_use"					=> "false",
				"raster_type"					=> "",
				'margin_bottom'					=> 0,
				'margin_top' 					=> 0,
				// Popup Setting
				'popup_show'					=> "true",
				'popup_type'					=> "",
				'popup_position'				=> "centercenter",
				'popup_title'					=> "",
				"popup_html"					=> "",
				"popup_image"					=> "",
				"popup_icon"					=> "",
				"popup_color"					=> "#000000",
				"popup_button"					=> "true",
				"popup_confirm"					=> "OK",
				"popup_close"					=> "false",
				"popup_timer"					=> 0,
				// Other Settings
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			),$atts));
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend						= "true";
				$enable 						= "false";
			} else {
				$frontend						= "false";
				$enable 						= $enable;
			}
			
			if (($enable == "true") && ($viewport_show == "true") && ($pageload == "false") && ($frontend == "false")) {
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndWaypoints == "true") {
					if (wp_script_is('waypoints', $list = 'registered')) {
						wp_enqueue_script('waypoints');
					} else {
						wp_enqueue_script('ts-extend-waypoints');
					}
				}
			}
			if (($popup_show == "true") && ($frontend == "false")) {
				wp_enqueue_style('ts-extend-sweetalert');
				wp_enqueue_script('ts-extend-sweetalert');	
			}
			if (($enable == "true") && ($frontend == "false")) {
				wp_enqueue_style('ts-visual-composer-extend-front');
				wp_enqueue_script('ts-visual-composer-extend-front');
			}
			
			$randomizer							= mt_rand(999999, 9999999);
			if (!empty($el_id)) {
				$spotlight_id					= $el_id;
			} else {
				$spotlight_id					= 'ts-vcsc-focus-frame-' . $randomizer;
			}
			
			$output 							= '';

			if ($frontend == "true") {
				$style 							= 'width: 100%; margin-top: ' . ($margin_top < 35 ? 35 : $margin_top) . 'px; margin-bottom: ' . $margin_bottom . 'px;';
			} else {
				$style 							= 'width: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
			}
			
			if (($enable == "true") && ($frontend == "false")) {
				$containerclass	 				= 'ts-element-focus-container';
				$containerdata					= 'data-focus-random="' . $randomizer . '" data-focus-rasteruse="' . $raster_use . '" data-focus-rastertype="' . $raster_type . '" data-focus-delay="' . $delay . '" data-focus-timer="' . $timer . '" data-focus-wait="' . $wait . '" data-focus-opacity="' . $opacity . '" data-focus-speed="' . $speed . '" data-focus-focuscolor="' . $focus_color . '" data-focus-framecolor="' . $frame_color . '" data-focus-framestrength="' . $frame_strength . '" data-focus-viewportshow="' . $viewport_show . '" data-focus-viewportonce="' . $viewport_once . '" data-focus-pageload="' . $pageload . '" data-focus-repeat="' . $repeat . '" data-focus-paddingx="' . $padding_x . '" data-focus-paddingy="' . $padding_y . '" data-focus-mobile="' . $mobile . '"';
				if (($popup_show == "true") && ($popup_html != '')) {
					if ((!empty($popup_image)) && ($popup_type == "image")) {
						$popup_image 			= wp_get_attachment_image_src($popup_image, 'full');
						$popup_image			= $popup_image[0];
					} else if ((empty($popup_image)) && ($popup_type == "image")) {
						$popup_type				= "";
						$popup_image			= "";
					} else {
						$popup_image			= "";
					}
					$popupdata					= 'data-popup-show="true" data-popup-timer="' . $popup_timer . '" data-popup-title="' . $popup_title . '" data-popup-html="' . strip_tags($popup_html) . '" data-popup-position="' . $popup_position . '" data-popup-type="' . $popup_type . '" data-popup-close="' . $popup_close . '" data-popup-title="' . $popup_title . '" data-popup-image="' . $popup_image . '" data-popup-icon="' . ($popup_type == "icon" ? $popup_icon : "") . '" data-popup-color="' . ($popup_type == "icon" ? $popup_color : "") . '" data-popup-button="' . $popup_button . '" data-popup-confirm="' . $popup_confirm . '"';
				} else {
					$popupdata					= 'data-popup-show="false"';
				}
			} else {
				$containerclass	 				= 'ts-element-focus-disabled';
				$containerdata					= '';
				$popupdata						= '';
			}
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '' . $containerclass . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Element_Focus', $atts);
			} else {
				$css_class 	= $containerclass . ' ' . $el_class;
			}
			
			if ($enable == "true") {
				$output .= '<div id="' . $spotlight_id . '" class="' . $css_class . '" data-focus-active="false" data-focus-shown="0" data-focus-last="0" style="' . $style . '" ' . $containerdata . ' ' . $popupdata . '>';
			} else {
				$output .= '<div id="' . $spotlight_id . '" class="' . $css_class . '" style="' . $style . '" ' . $containerdata . '>';
			}
				$output .= do_shortcode($content);
			$output .= '</div>';
			
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
		function TS_VCSC_Add_Focus_Element() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			if (function_exists('vc_map')) {
				vc_map( 
					array(
						"name" 								=> __("TS Element Focus", "ts_visual_composer_extend"),
						"base" 								=> "TS_VCSC_Element_Focus",
						"icon" 								=> "icon-wpb-ts_vcsc_element_focus",
						"class" 							=> "",
						"as_parent" 						=> array('except' => implode(",", $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Focus_Excluded)),
						"category" 							=> "VC Extensions",
						"description" 						=> "Apply a focus to other elements.",
						"controls" 							=> "full",
						"content_element"                   => true,
						"is_container" 						=> true,
						"container_not_allowed" 			=> false,
						"show_settings_on_create"           => true,
						"admin_enqueue_js"            		=> "",
						"admin_enqueue_css"           		=> "",
						"params" 							=> array(
							array(
								"type"              		=> "seperator",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "seperator_1",
								"value"						=> "",
								"seperator"         		=> "Focus Settings",
								"description"       		=> __( "", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "switch_button",
								"heading"			    	=> __( "Focus Active", "ts_visual_composer_extend" ),
								"param_name"		    	=> "enable",
								"value"             		=> "true",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"admin_label"		        => true,
								"description"		    	=> __( "Switch the toggle if you want to use the focus effect with this container element.", "ts_visual_composer_extend" ),
								"dependency"            	=> ""
							),
							array(
								"type"              		=> "switch_button",
								"heading"			    	=> __( "Viewport Trigger", "ts_visual_composer_extend" ),
								"param_name"		    	=> "viewport_show",
								"value"             		=> "false",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"admin_label"           	=> true,
								"description"		    	=> __( "Switch the toggle if you want to trigger the focus effect automatically once the element comes into viewport.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' )
							),
							array(
								"type"              		=> "switch_button",
								"heading"			    	=> __( "One-Time Viewport", "ts_visual_composer_extend" ),
								"param_name"		    	=> "viewport_once",
								"value"             		=> "true",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"admin_label"           	=> true,
								"description"		    	=> __( "Switch the toggle if you want the viewport trigger to only run once or repeatedly.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "viewport_show", 'value' => 'true' )
							),
							array(
								"type"              		=> "switch_button",
								"heading"			    	=> __( "Show on Pageload", "ts_visual_composer_extend" ),
								"param_name"		    	=> "pageload",
								"value"             		=> "false",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"admin_label"           	=> true,
								"description"		    	=> __( "Switch the toggle if the focus should automatically be applied on pageload (only applied to the first such focus on page).", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "viewport_show", 'value' => 'false' )
							),
							array(
								"type"              		=> "switch_button",
								"heading"			    	=> __( "Focus Repeats", "ts_visual_composer_extend" ),
								"param_name"		    	=> "repeat",
								"value"             		=> "false",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"description"		    	=> __( "Switch the toggle if you want to allow the focus to be retriggered again.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' )
							),
							array(
								"type"              		=> "switch_button",
								"heading"			    	=> __( "Animate on Mobile", "ts_visual_composer_extend" ),
								"param_name"		    	=> "mobile",
								"value"             		=> "false",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"admin_label"           	=> true,
								"description"		    	=> __( "Switch the toggle if you want to show the CSS3 animations on mobile devices.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' )
							),
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Delay", "ts_visual_composer_extend" ),
								"param_name"				=> "delay",
								"value"						=> "0",
								"min"						=> "0",
								"max"						=> "5000",
								"step"						=> "100",
								"unit"						=> 'ms',
								"admin_label"           	=> true,
								"description"				=> __( "Define how long the focus effect should be delayed after it has been triggered.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' )
							),
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Auto Removal", "ts_visual_composer_extend" ),
								"param_name"				=> "timer",
								"value"						=> "0",
								"min"						=> "0",
								"max"						=> "10000",
								"step"						=> "100",
								"unit"						=> 'ms',
								"admin_label"           	=> true,
								"description"				=> __( "Define after what time the focus should be removed automatically; set to Zero (0) to force manual removal.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' )
							),
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Wait Time", "ts_visual_composer_extend" ),
								"param_name"				=> "wait",
								"value"						=> "5000",
								"min"						=> "0",
								"max"						=> "60000",
								"step"						=> "100",
								"unit"						=> 'ms',
								"admin_label"           	=> true,
								"description"				=> __( "Define how long one has to wait until the same focus can be retriggered once last closed.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "repeat", 'value' => 'true' )
							),
							// Styling Settings
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_2",
								"value"						=> "",
								"seperator"                 => "Style Settings",
								"description"               => __( "", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
								"group" 			        => "Style Settings",
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Overlay Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "focus_color",
								"value"             		=> "#066BC0",
								"description"       		=> __( "Select the background color for the focus overlay; RGB(A) will be converted to HEX.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
								"group" 			        => "Style Settings",
							),
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Opacity", "ts_visual_composer_extend" ),
								"param_name"				=> "opacity",
								"value"						=> "50",
								"min"						=> "0",
								"max"						=> "100",
								"step"						=> "1",
								"unit"						=> '%',
								"admin_label"           	=> true,
								"description"				=> __( "Define the opacity for the focus overlay layer.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
								"group" 			        => "Style Settings",
							),							
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Padding: Left / Right", "ts_visual_composer_extend" ),
								"param_name"				=> "padding_x",
								"value"						=> "20",
								"min"						=> "0",
								"max"						=> "100",
								"step"						=> "1",
								"unit"						=> 'px',
								"description"				=> __( "Define an additional left and right padding for the focus frame.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
								"group" 			        => "Style Settings",
							),
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Padding: Top / Bottom", "ts_visual_composer_extend" ),
								"param_name"				=> "padding_y",
								"value"						=> "20",
								"min"						=> "0",
								"max"						=> "100",
								"step"						=> "1",
								"unit"						=> 'px',
								"description"				=> __( "Define an additional top and bottom padding for the focus frame.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
								"group" 			        => "Style Settings",
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Frame Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "frame_color",
								"value"             		=> "#cccccc",
								"description"       		=> __( "Select the border color for the frame around the focus element.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
								"group" 			        => "Style Settings",
							),
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Frame Strength", "ts_visual_composer_extend" ),
								"param_name"				=> "frame_strength",
								"value"						=> "10",
								"min"						=> "1",
								"max"						=> "50",
								"step"						=> "1",
								"unit"						=> 'px',
								"description"       		=> __( "Select the border strength for the frame around the focus element.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
								"group" 			        => "Style Settings",
							),
							/*array(
								"type"						=> "switch_button",
								"heading"					=> __( "Raster Overlay", "ts_visual_composer_extend" ),
								"param_name"				=> "raster_use",
								"value"						=> "false",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"description"				=> __( "Switch the toggle if you want to use a raster with the focus canvas overlay; canvas cutout will be filled as well.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
								"group" 			        => "Style Settings",
							),
							array(
								"type"						=> "background",
								"heading"					=> __( "Raster Type", "ts_visual_composer_extend" ),
								"param_name"				=> "raster_type",
								"height"					=> 200,
								"pattern"					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Rasters_List,
								"value"						=> "",
								"encoding"					=> "false",
								"asimage"					=> "false",
								"thumbsize"					=> 40,
								"description"				=> __( "Select an optional raster pattern for the focus overlay.", "ts_visual_composer_extend" ),
								"dependency"				=> array( 'element' => "raster_use", 'value' => 'true' ),
								"group" 			        => "Style Settings",
							),*/
							// Popup Settings
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_3",
								"value"						=> "",
								"seperator"                 => "Popup Settings",
								"description"               => __( "", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
								"group" 			        => "Popup Settings",
							),
							array(
								"type"						=> "switch_button",
								"heading"					=> __( "Show Popup", "ts_visual_composer_extend" ),
								"param_name"				=> "popup_show",
								"value"						=> "false",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
								"description"				=> __( "Switch the toggle if you want to show a popup with additional info for the focus element.", "ts_visual_composer_extend" ),
								"group" 			        => "Popup Settings",
							),
							array(
								"type"						=> "textfield",
								"heading"					=> __( "Popup Title", "ts_visual_composer_extend" ),
								"param_name"				=> "popup_title",
								"value"						=> "",
								"description"				=> __( "Enter a title for the focus popup here.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "popup_show", 'value' => 'true' ),
								"group" 			        => "Popup Settings",
							),
							array(
								"type"              		=> "textarea_raw_html",
								"heading"           		=> __( "Popup Content", "ts_visual_composer_extend" ),
								"param_name"        		=> "popup_html",
								"value"             		=> base64_encode(""),
								"description"      	 		=> __( "Enter the content for the focus popup here; HTML code can be used.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "popup_show", 'value' => 'true' ),
								"group" 			        => "Popup Settings",
							),
							array(
								"type"						=> "switch_button",
								"heading"					=> __( "Popup Button", "ts_visual_composer_extend" ),
								"param_name"				=> "popup_button",
								"value"						=> "true",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"description"				=> __( "Switch the toggle if you want to show a close button inside the focus popup.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "popup_show", 'value' => 'true' ),
								"group" 			        => "Popup Settings",
							),
							array(
								"type"						=> "textfield",
								"heading"					=> __( "Popup Button Text", "ts_visual_composer_extend" ),
								"param_name"				=> "popup_confirm",
								"value"						=> "OK",
								"description"				=> __( "Enter a text for the close button used in the focus popup.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "popup_button", 'value' => 'true' ),
								"group" 			        => "Popup Settings",
							),
							array(
								"type"				    	=> "dropdown",
								"class"				    	=> "",
								"heading"			    	=> __( "Popup Position", "ts_visual_composer_extend" ),
								"param_name"		    	=> "popup_position",
								"value"                 	=> array(
									__("Center Center", "ts_visual_composer_extend")                    	=> "centercenter",
									__("Center Left", "ts_visual_composer_extend")                 			=> "centerleft",
									__("Center Right", "ts_visual_composer_extend")							=> "centerright",
									__("Top Center", "ts_visual_composer_extend")                    		=> "topcenter",
									__("Top Left", "ts_visual_composer_extend")                 			=> "topleft",
									__("Top Right", "ts_visual_composer_extend")							=> "topright",
									__("Bottom Center", "ts_visual_composer_extend")                    	=> "bottomcenter",
									__("Bottom Left", "ts_visual_composer_extend")                 			=> "bottomleft",
									__("Bottom Right", "ts_visual_composer_extend")							=> "bottomright",									
								),
								"description"		    	=> __( "Select where the info popup for the focus should be placed on the screen.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "popup_show", 'value' => 'true' ),
								"group" 			        => "Popup Settings",
							),
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Auto-Close Popup", "ts_visual_composer_extend" ),
								"param_name"				=> "popup_timer",
								"value"						=> "0",
								"min"						=> "0",
								"max"						=> "20000",
								"step"						=> "100",
								"unit"						=> 'ms',
								"description"				=> __( "Define a time after which the popup should be closed automatically; set to Zero (0) to disable.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "popup_show", 'value' => 'true' ),
								"group" 			        => "Popup Settings",
							),
							array(
								"type"						=> "switch_button",
								"heading"					=> __( "Close Focus", "ts_visual_composer_extend" ),
								"param_name"				=> "popup_close",
								"value"						=> "false",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"description"				=> __( "Switch the toggle if you want to also close the focus when closing the popup.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "popup_show", 'value' => 'true' ),
								"group" 			        => "Popup Settings",
							),
							array(
								"type"				    	=> "dropdown",
								"class"				    	=> "",
								"heading"			    	=> __( "Popup Type", "ts_visual_composer_extend" ),
								"param_name"		    	=> "popup_type",
								"value"                 	=> array(
									__("No Icon / Image", "ts_visual_composer_extend")                    	=> "",
									__("Custom Image", "ts_visual_composer_extend")                 		=> "image",
									__("Custom Icon", "ts_visual_composer_extend")                 			=> "icon",	
									__("Success Icon", "ts_visual_composer_extend")                    		=> "success",
									__("Error Icon", "ts_visual_composer_extend")                 			=> "error",
									__("Warning Icon", "ts_visual_composer_extend")							=> "warning",
									__("Info Icon", "ts_visual_composer_extend")                    		=> "info",							
								),
								"description"		    	=> __( "Select what type of popup window should be shown for the focus element.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "popup_show", 'value' => 'true' ),
								"group" 			        => "Popup Settings",
							),							
							array(
								"type"                  	=> "attach_image",
								"heading"               	=> __( "Popup Image", "ts_visual_composer_extend" ),
								"param_name"            	=> "popup_image",
								"value"                 	=> "",
								"description"           	=> __( "Select the custom image you want to show at the top of the focus popup (should have square dimensions).", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "popup_type", 'value' => 'image' ),
								"group" 			        => "Popup Settings",
							),							
							array(
								'type' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
								'heading' 					=> __( 'Select Icon', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'popup_icon',
								'value'						=> '',
								'source'					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorValue,
								'settings' 					=> array(
									'emptyIcon' 					=> false,
									'type' 							=> 'extensions',
									'iconsPerPage' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
									'source' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorSource,
								),
								"description"       		=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon to be shown at the top of the focus popup.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
								"dependency"        		=> array( 'element' => "popup_type", 'value' => 'icon' ),
								"group" 			        => "Popup Settings",
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Icon Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "popup_color",
								"value"             		=> "#000000",
								"description"       		=> __( "Define the color for the icon to be shown at the top of the focus popup.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "popup_type", 'value' => 'icon' ),
								"group" 			        => "Popup Settings",
							),
							// Other Settings
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_4",
								"value"						=> "",
								"seperator"                 => "Other Settings",
								"description"               => __( "", "ts_visual_composer_extend" ),
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
								"value"             		=> "Element Files",
								"param_name"        		=> "el_file1",
								"file_type"         		=> "js",
								"file_path"         		=> "js/ts-visual-composer-extend-element.min.js",
								"description"       		=> __( "", "ts_visual_composer_extend" )
							),
						),
						"js_view" => 'VcColumnView'
					)
				);
			}
		}
	}
}
if (class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_TS_VCSC_Element_Focus extends WPBakeryShortCodesContainer {};
}

// Initialize "TS Element Spotlight" Class
if (class_exists('TS_Element_Focus')) {
	$TS_Element_Focus = new TS_Element_Focus;
}
?>