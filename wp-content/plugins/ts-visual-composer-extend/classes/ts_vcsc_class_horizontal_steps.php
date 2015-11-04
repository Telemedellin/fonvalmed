<?php
if (!class_exists('TS_Horizontal_Steps')){
	class TS_Horizontal_Steps{
		function __construct(){
			global $VISUAL_COMPOSER_EXTENSIONS;
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				add_action('init',                              		array($this, 'TS_VCSC_Add_Horizontal_Steps_Elements'), 9999999);
			} else {
				add_action('admin_init',		                		array($this, 'TS_VCSC_Add_Horizontal_Steps_Elements'), 9999999);
			}
			add_shortcode('TS_VCSC_Horizontal_Steps_Container',			array($this, 'TS_VCSC_Horizontal_Steps_Container'));
			add_shortcode('TS_VCSC_Horizontal_Steps_Item',				array($this, 'TS_VCSC_Horizontal_Steps_Item'));
		}
		
		function TS_VCSC_Horizontal_Steps_Container($atts, $content = null){
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();

			wp_enqueue_style('dashicons');
			wp_enqueue_style('ts-extend-animations');
			wp_enqueue_style('ts-extend-buttonsdual');
			wp_enqueue_style('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-front');
			
			extract(shortcode_atts(array(
				'min_width'						=> 250,
				'icon_size'						=> 75,
				'icon_max'						=> 100,				
				'animation_view' 				=> '',
				'animation_delay' 				=> 0,
				'animation_steps' 				=> 500,
				'animation_mobile'				=> 'false',
				'margin_bottom'					=> 0,
				'margin_top' 					=> 0,
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			),$atts));
			
			if (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndWaypoints == "true") && ($animation_view != "") && ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false")) {
				if (wp_script_is('waypoints', $list = 'registered')) {
					wp_enqueue_script('waypoints');
				} else {
					wp_enqueue_script('ts-extend-waypoints');
				}
			}
			
			if (!empty($el_id)) {
				$steps_id						= $el_id;
			} else {
				$steps_id						= 'ts-vcsc-horizontal-steps-container-' . mt_rand(999999, 9999999);
			}
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend 						= "true";
				$margin_top						= 40;
			} else {
				$frontend 						= "false";
				$margin_top						= $margin_top;
			}
			
			$output 							= '';
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 						= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-horizontal-steps ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Horizontal_Steps_Container', $atts);
			} else {
				$css_class 						= 'ts-horizontal-steps ' . $el_class;
			}
			
			if (($animation_view != "") && ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false")) {
				$animation_class				= 'ts-horizontal-steps-viewport';
				$animation_data					= 'data-animation="' . $animation_view . '" data-mobile="' . $animation_mobile . '" data-delay="' . $animation_delay . '" data-break="' . $animation_steps . '"';
			} else {
				$animation_class				= '';
				$animation_data					= '';
			}
			
			$output .= '<div id="' . $steps_id . '" class="' . $css_class . ' ' . $animation_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;" ' . $animation_data . ' data-lastwidth="0" data-frontend="' . $frontend . '" data-minwidth="' . $min_width . '" data-iconsize="' . $icon_size . '" data-iconmax="' . $icon_max . '">';
				$output .= '<ul class="ts-horizontal-steps-list">';
					$output .= do_shortcode($content);
				$output .= '<div class="clearboth"></div>';
				$output .= '</ul>';				
			$output .= '</div>';
			
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
		
		function TS_VCSC_Horizontal_Steps_Item($atts, $content = null){
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();
			
			extract(shortcode_atts(array(
				'step_replace'					=> 'false',
				'step_icon'						=> '',
				'step_image'					=> '',
				'step_link'						=> '',
				'step_title'					=> '',
				'step_animation'				=> 'ts-hover-css-none',
				'step_content'					=> '',
				
				'button_show'					=> 'false',
				'button_text'					=> 'Read More',
				'button_style'					=> 'ts-dual-buttons-color-default',
				'button_hover'					=> 'ts-dual-buttons-hover-default',
				
				'title_color'					=> '4e4e4e',
				'content_color'					=> '6C6C6C',
				'content_align'					=> 'center',
				'content_size'					=> 14,
				
				'icon_color_default'			=> '#cccccc',
				'icon_color_hover'				=> '#ffffff',
				'icon_back_default'				=> '#ffffff',
				'icon_back_hover'				=> '#ededed',
				'icon_border_default'			=> '',
				'icon_border_hover'				=> '',
				'icon_shadow_default'			=> '#ededed',
				'icon_shadow_hover'				=> 'rgba(0, 0, 0, 0.25)',
				
				'tooltip_content'				=> '',
				'tooltip_position'				=> 'ts-simptip-position-top',
				'tooltip_style'					=> 'ts-simptip-style-black',
				'tooltip_animation'				=> 'swing',
				'tooltipster_offsetx'			=> 0,
				'tooltipster_offsety'			=> 0,

				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			),$atts));
			
			$output								= '';
			$style								= '';
			
			if (!empty($el_id)) {
				$steps_id						= $el_id;
			} else {
				$steps_id						= 'ts-vcsc-horizontal-steps-single-' . mt_rand(999999, 9999999);
			}
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend 						= "true";
			} else {
				$frontend 						= "false";
			}
			
			// Link Values
			$step_link 						= ($step_link == '||') ? '' : $step_link;
			$step_link 						= vc_build_link($step_link);
			$a_href							= $step_link['url'];
			$a_title 						= $step_link['title'];
			$a_target 						= $step_link['target'];
			
			if (($step_replace == "true") && (!empty($step_image))) {
				$step_image_path 			= wp_get_attachment_image_src($step_image, 'large');
			}
			
			$style .= '<style id="' . $steps_id . '-style" type="text/css">';
				$style .= 'body #' . $steps_id . '.ts-horizontal-steps-item .ts-horizontal-step-icon {';
					$style .= 'background: ' . $icon_back_default . ';';
				$style .= '}';
				$style .= 'body #' . $steps_id . '.ts-horizontal-steps-item:hover .ts-horizontal-step-icon {';
					$style .= 'background: ' . $icon_back_hover . ';';
				$style .= '}';
				$style .= 'body #' . $steps_id . '.ts-horizontal-steps-item .ts-horizontal-step-icon i {';
					$style .= 'color: ' . $icon_color_default . ';';
				$style .= '}';
				$style .= 'body #' . $steps_id . '.ts-horizontal-steps-item:hover .ts-horizontal-step-icon i, ';
				$style .= 'body #' . $steps_id . '.ts-horizontal-steps-item:hover .ts-horizontal-step-icon:before {';
					$style .= 'color: ' . $icon_color_hover . ';';
				$style .= '}';
			$style .= '</style>';
			
			// Tooltip
			if (($tooltip_position == "ts-simptip-position-top") || ($tooltip_position == "top")) {
				$tooltip_position			= "top";
			}
			if (($tooltip_position == "ts-simptip-position-left") || ($tooltip_position == "left")) {
				$tooltip_position			= "left";
			}
			if (($tooltip_position == "ts-simptip-position-right") || ($tooltip_position == "right")) {
				$tooltip_position			= "right";
			}
			if (($tooltip_position == "ts-simptip-position-bottom") || ($tooltip_position == "bottom")) {
				$tooltip_position			= "bottom";
			}
			$tooltipclasses					= 'ts-has-tooltipster-tooltip';
			if (($tooltip_style == "") || ($tooltip_style == "ts-simptip-style-black") || ($tooltip_style == "tooltipster-black")) {
				$tooltip_style				= "tooltipster-black";
			}
			if (($tooltip_style == "ts-simptip-style-gray") || ($tooltip_style == "tooltipster-gray")) {
				$tooltip_style				= "tooltipster-gray";
			}
			if (($tooltip_style == "ts-simptip-style-green") || ($tooltip_style == "tooltipster-green")) {
				$tooltip_style				= "tooltipster-green";
			}
			if (($tooltip_style == "ts-simptip-style-blue") || ($tooltip_style == "tooltipster-blue")) {
				$tooltip_style				= "tooltipster-blue";
			}
			if (($tooltip_style == "ts-simptip-style-red") || ($tooltip_style == "tooltipster-red")) {
				$tooltip_style				= "tooltipster-red";
			}
			if (($tooltip_style == "ts-simptip-style-orange") || ($tooltip_style == "tooltipster-orange")) {
				$tooltip_style				= "tooltipster-orange";
			}
			if (($tooltip_style == "ts-simptip-style-yellow") || ($tooltip_style == "tooltipster-yellow")) {
				$tooltip_style				= "tooltipster-yellow";
			}
			if (($tooltip_style == "ts-simptip-style-purple") || ($tooltip_style == "tooltipster-purple")) {
				$tooltip_style				= "tooltipster-purple";
			}
			if (($tooltip_style == "ts-simptip-style-pink") || ($tooltip_style == "tooltipster-pink")) {
				$tooltip_style				= "tooltipster-pink";
			}
			if (($tooltip_style == "ts-simptip-style-white") || ($tooltip_style == "tooltipster-white")) {
				$tooltip_style				= "tooltipster-white";
			}
			if (strip_tags($tooltip_content) != '') {
				wp_enqueue_style('ts-extend-tooltipster');
				wp_enqueue_script('ts-extend-tooltipster');	
				$Tooltip_Content			= 'data-tooltipster-html="true" data-tooltipster-title="" data-tooltipster-text="' . strip_tags($tooltip_content) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="' . $tooltip_animation . '" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
				$Tooltip_Class				= 'ts-has-tooltipster-tooltip';
			} else {
				$Tooltip_Content			= '';
				$Tooltip_Class				= '';
			}
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-horizontal-steps-item ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Horizontal_Steps_Item', $atts);
			} else {
				$css_class 	= 'ts-horizontal-steps-item ' . $el_class;
			}
			
			$output .= '<li id="' . $steps_id . '" class="' . $css_class . ' ts-box-icon ' . ($frontend == "true" ? "ts-horizontal-steps-break" : "") . ' ' . $Tooltip_Class . '" ' . $Tooltip_Content . ' data-frontend="' . $frontend . '" style="' . ($frontend == "true" ? "float: none;" : "") . '">';
			$output .= $style;
				if ($a_href != '') {
					if ($step_replace == "false") {
						$output .= '<a href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '"><span class="ts-horizontal-step-icon"><i class="' . $step_icon . ' ' . $step_animation . '"></i></span></a>';
					} else {
						$output .= '<a href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '"><span class="ts-horizontal-step-icon"><img class="' . $step_animation . '" src="' . $step_image_path[0] . '"></span></a>';
					}
				} else {
					if ($step_replace == "false") {
						$output .= '<span class="ts-horizontal-step-icon"><i class="' . $step_icon . ' ' . $step_animation . '"></i></span>';
					} else {
						$output .= '<span class="ts-horizontal-step-icon"><img class="' . $step_animation . '" src="' . $step_image_path[0] . '"></span>';
					}
				}
				$output .= '<div class="ts-horizontal-step-content">';
					if ($a_href != '') {
						$output .= '<h3 class="ts-horizontal-step-title" style="color: ' . $title_color . ';"><a href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '">' . $step_title . '</a></h3>';
					} else {
						$output .= '<h3 class="ts-horizontal-step-title" style="color: ' . $title_color . ';">' . $step_title . '</h3>';
					}
					$output .= '<div class="clearboth"></div>';
					if ($step_content != '') {
						$output .= '<div class="ts-horizontal-step-description" style="color: ' . $content_color . '; text-align: ' . $content_align . '; font-size: ' . $content_size . 'px;">' . rawurldecode(base64_decode(strip_tags($step_content))) . '</div>';
					}
					if (($button_show == "true") && ($a_href != '')) {
						$output .= '<a class="ts-readmore ' . $button_style . ' ' . $button_hover . '" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '" style="margin: 0 auto; font-size: 14px; padding: 10px 5px;"><span>' . $button_text . '</span></a>';
					}
				$output .= '</div>';
			$output .= '</li>';
			
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
		
		function TS_VCSC_Add_Horizontal_Steps_Elements() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			// Add Single Step Item
			if (function_exists('vc_map')) {
				vc_map(
					array(
						"name"                      		=> __( "TS Steps Item", "ts_visual_composer_extend" ),
						"base"                      		=> "TS_VCSC_Horizontal_Steps_Item",
						"icon" 	                    		=> "icon-wpb-ts_vcsc_horizontal_steps_item",
						"class"                     		=> "",
						"content_element"					=> true,
						"as_child"							=> array('only' => 'TS_VCSC_Horizontal_Steps_Container'),
						"category"                  		=> __( 'VC Extensions', "ts_visual_composer_extend" ),
						"description"               		=> __("Place a single step item", "ts_visual_composer_extend"),
						"admin_enqueue_js"            		=> "",
						"admin_enqueue_css"           		=> "",
						"params"                    		=> array(
							// Main Settings
							array(
								"type"              		=> "seperator",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "seperator_1",
								"value"						=> "",
								"seperator"					=> "Icon Settings",
								"description"       		=> __( "", "ts_visual_composer_extend" )
							),
							array(
								"type"						=> "switch_button",
								"heading"           		=> __( "Use Normal Image", "ts_visual_composer_extend" ),
								"param_name"        		=> "step_replace",
								"value"             		=> "false",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"description"       		=> __( "Switch the toggle to either use and icon or a normal image.", "ts_visual_composer_extend" ),
							),		
							array(
								'type' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
								'heading' 					=> __( 'Step Icon', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'step_icon',
								'value'						=> '',
								'source'					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorValue,
								'settings' 					=> array(
									'emptyIcon' 					=> false,
									'type' 							=> 'extensions',
									'iconsPerPage' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
									'source' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorSource,
								),
								"description"       		=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon you want to display in the handle instead of the automatic numbering.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
								"dependency"        		=> array( 'element' => "step_replace", 'value' => 'false' ),
							),
							array(
								"type"              		=> "attach_image",
								"heading"           		=> __( "Select Image", "ts_visual_composer_extend" ),
								"param_name"        		=> "step_image",
								"value"             		=> "false",
								"description"       		=> __( "Image must have equal dimensions for scaling purposes (i.e. 100x100).", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "step_replace", 'value' => 'true' ),
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Default Icon Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "icon_color_default",
								"value"             		=> "#cccccc",
								"description"       		=> __( "Define the default color for the step icon.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "step_replace", 'value' => 'false' ),
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Hover Icon Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "icon_color_hover",
								"value"             		=> "#ffffff",
								"description"       		=> __( "Define the hover color for the step icon.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "step_replace", 'value' => 'false' ),
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Default Icon Background", "ts_visual_composer_extend" ),
								"param_name"        		=> "icon_back_default",
								"value"             		=> "#ffffff",
								"description"       		=> __( "Define the default background color for the step icon.", "ts_visual_composer_extend" ),
								"dependency"        		=> ""
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Hover Icon Background", "ts_visual_composer_extend" ),
								"param_name"        		=> "icon_back_hover",
								"value"             		=> "#ededed",
								"description"       		=> __( "Define the hover background color for the step icon.", "ts_visual_composer_extend" ),
								"dependency"        		=> ""
							),			
							array(
								"type"						=> "css3animations",
								"class"						=> "",
								"heading"					=> __("Icon Hover Animation", "ts_visual_composer_extend"),
								"param_name"				=> "step_animation",
								"standard"					=> "false",
								"prefix"					=> "ts-hover-css-",
								"connector"					=> "css3animations_name",
								"noneselect"				=> "true",
								"default"					=> "",
								"value"						=> "",
								"admin_label"				=> false,
								"description" 				=> __("Select the CSS3 animation you want to apply to the icon on hover.", "ts_visual_composer_extend"),
							),
							array(
								"type"						=> "hidden_input",
								"heading"					=> __( "Animation Type", "ts_visual_composer_extend" ),
								"param_name"				=> "css3animations_name",
								"value"						=> "",
								"admin_label"				=> true,
								"description"				=> __( "", "ts_visual_composer_extend" ),
							),
							// Content Settings
							array(
								"type"              		=> "seperator",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "seperator_2",
								"value"						=> "",
								"seperator"					=> "Step Content",
								"description"       		=> __( "", "ts_visual_composer_extend" ),
								"group" 					=> "Step Content",
							),
							array(
								"type"              		=> "textfield",
								"heading"           		=> __( "Title", "ts_visual_composer_extend" ),
								"param_name"        		=> "step_title",
								"class"						=> "",
								"value"             		=> "",
								"admin_label"           	=> true,
								"description"       		=> __( "Enter a title for the step item.", "ts_visual_composer_extend" ),
								"group" 					=> "Step Content",
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Title Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "title_color",
								"value"             		=> "#4e4e4d",
								"description"       		=> __( "Define the font color for the step title.", "ts_visual_composer_extend" ),
								"group" 					=> "Step Content",
							),
							array(
								"type"              		=> "textarea_raw_html",
								"heading"           		=> __( "Step Content", "ts_visual_composer_extend" ),
								"param_name"        		=> "step_content",
								"value"             		=> base64_encode(""),
								"description"      	 		=> __( "Enter the step content here; HTML code can be used.", "ts_visual_composer_extend" ),
								"group" 					=> "Step Content",
							),
							array(
								"type"              		=> "dropdown",
								"heading"           		=> __( "Text Align", "ts_visual_composer_extend" ),
								"param_name"        		=> "content_align",
								"width"             		=> 150,
								"value"             		=> array(
									__( "Center", "ts_visual_composer_extend" )                        => "center",
									__( "Left", "ts_visual_composer_extend" )                          => "left",
									__( "Right", "ts_visual_composer_extend" )                         => "right",
									__( "Justify", "ts_visual_composer_extend" )                       => "justify",
								),
								"description"       		=> __( "Select the text alignment for step content.", "ts_visual_composer_extend" ),
								"group" 					=> "Step Content",
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Text Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "content_color",
								"value"             		=> "#6C6C6C",
								"description"       		=> __( "Define the font color for the step content.", "ts_visual_composer_extend" ),
								"group" 					=> "Step Content",
							),
							// Step Link
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_3",
								"value"						=> "",
								"seperator"					=> "Link Settings",
								"description"               => __( "", "ts_visual_composer_extend" ),
								"group" 			        => "Step Link",
							),
							array(
								"type" 						=> "vc_link",
								"heading" 					=> __("Link", "ts_visual_composer_extend"),
								"param_name" 				=> "step_link",
								"description" 				=> __("Provide a link to another site/page for the step element.", "ts_visual_composer_extend"),
								"group" 					=> "Step Link",
							),
							array(
								"type"              	    => "switch_button",
								"heading"                   => __( "Show Button", "ts_visual_composer_extend" ),
								"param_name"                => "button_show",
								"value"                     => "false",
								"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
								"off"					    => __( 'No', "ts_visual_composer_extend" ),
								"style"					    => "select",
								"design"				    => "toggle-light",
								"description"               => __( "Switch the toggle if you want to show a dedicated link button.", "ts_visual_composer_extend" ),
								"group" 					=> "Step Link",
							),
							array(
								"type"              		=> "textfield",
								"heading"           		=> __( "Button Text", "ts_visual_composer_extend" ),
								"param_name"        		=> "button_text",
								"value"             		=> "Read More",
								"description"       		=> __( "Enter a text for the dedicated link button.", "ts_visual_composer_extend" ),
								"dependency"				=> array( 'element' => "button_show", 'value' => 'true' ),
								"group" 					=> "Step Link",
							),
							array(
								"type"                  	=> "dropdown",
								"heading"               	=> __( "Button Style", "ts_visual_composer_extend" ),
								"param_name"            	=> "button_style",
								"width"                 	=> 150,
								"value"                 	=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Default_Colors,
								"description"           	=> __( "Select the color scheme for the link button.", "ts_visual_composer_extend" ),
								"dependency"				=> array( 'element' => "button_show", 'value' => 'true' ),
								"group" 					=> "Step Link",
							),						
							array(
								"type"                  	=> "dropdown",
								"heading"               	=> __( "Button Hover Style", "ts_visual_composer_extend" ),
								"param_name"            	=> "button_hover",
								"width"                 	=> 150,
								"value"                 	=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Hover_Colors,
								"description"           	=> __( "Select the hover color scheme for the link button.", "ts_visual_composer_extend" ),
								"dependency"				=> array( 'element' => "button_show", 'value' => 'true' ),
								"group" 					=> "Step Link",
							),							
							// Tooltip Settings
							array(
								"type"              		=> "seperator",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "seperator_4",
								"value"						=> "",
								"seperator"            		=> "Tooltip Settings",
								"description"       		=> __( "", "ts_visual_composer_extend" ),
								"group" 					=> "Step Tooltip",
							),
							array(
								"type"              		=> "textarea_raw_html",
								"heading"           		=> __( "Tooltip Content", "ts_visual_composer_extend" ),
								"param_name"        		=> "tooltip_content",
								"value"             		=> base64_encode(""),
								"description"      	 		=> __( "Enter the tooltip content for the element; basic HTML code can be used.", "ts_visual_composer_extend" ),
								"group" 					=> "Step Tooltip",
							),
							array(
								"type"						=> "dropdown",
								"class"						=> "",
								"heading"					=> __( "Tooltip Position", "ts_visual_composer_extend" ),
								"param_name"				=> "tooltip_position",
								"value"						=> array(
									__( "Top", "ts_visual_composer_extend" )                            => "ts-simptip-position-top",
									__( "Bottom", "ts_visual_composer_extend" )                         => "ts-simptip-position-bottom",
								),
								"description"				=> __( "Select the tooltip position in relation to the element.", "ts_visual_composer_extend" ),
								"dependency"				=> "",
								"group" 					=> "Step Tooltip",
							),							
							array(
								"type"						=> "dropdown",
								"class"						=> "",
								"heading"					=> __( "Tooltip Style", "ts_visual_composer_extend" ),
								"param_name"				=> "tooltip_style",
								"value"             		=> array(
									__( "Black", "ts_visual_composer_extend" )                          => "ts-simptip-style-black",
									__( "Gray", "ts_visual_composer_extend" )                           => "ts-simptip-style-gray",
									__( "Green", "ts_visual_composer_extend" )                          => "ts-simptip-style-green",
									__( "Blue", "ts_visual_composer_extend" )                           => "ts-simptip-style-blue",
									__( "Red", "ts_visual_composer_extend" )                            => "ts-simptip-style-red",
									__( "Orange", "ts_visual_composer_extend" )                         => "ts-simptip-style-orange",
									__( "Yellow", "ts_visual_composer_extend" )                         => "ts-simptip-style-yellow",
									__( "Purple", "ts_visual_composer_extend" )                         => "ts-simptip-style-purple",
									__( "Pink", "ts_visual_composer_extend" )                           => "ts-simptip-style-pink",
									__( "White", "ts_visual_composer_extend" )                          => "ts-simptip-style-white"
								),
								"description"				=> __( "Select the tooltip style.", "ts_visual_composer_extend" ),
								"group" 					=> "Step Tooltip",
							),							
							array(
								"type"				    	=> "dropdown",
								"class"				    	=> "",
								"heading"			    	=> __( "Tooltip Animation", "ts_visual_composer_extend" ),
								"param_name"		    	=> "tooltip_animation",
								"value"                 	=> array(
									__("Swing", "ts_visual_composer_extend")                    => "swing",
									__("Fall", "ts_visual_composer_extend")                 	=> "fall",
									__("Grow", "ts_visual_composer_extend")                 	=> "grow",
									__("Slide", "ts_visual_composer_extend")                 	=> "slide",
									__("Fade", "ts_visual_composer_extend")                 	=> "fade",
								),
								"description"		    	=> __( "Select how the tooltip entry and exit should be animated once triggered.", "ts_visual_composer_extend" ),
								"group" 					=> "Step Tooltip",
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
								"group" 					=> "Step Tooltip",
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
								"group" 					=> "Step Tooltip",
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
							array(
								"type"              		=> "load_file",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"value"             		=> "Animation Files",
								"param_name"        		=> "el_file2",
								"file_type"         		=> "css",
								"file_id"         			=> "ts-extend-animations",
								"file_path"         		=> "css/ts-visual-composer-extend-animations.min.css",
								"description"       		=> __( "", "ts_visual_composer_extend" )
							),
						)
					)
				);
			}
			// Add Steps Container
			if (function_exists('vc_map')) {
				vc_map( 
					array(
						"name" 								=> __("TS Horizontal Steps", "ts_visual_composer_extend"),
						"base" 								=> "TS_VCSC_Horizontal_Steps_Container",
						"icon" 								=> "icon-wpb-ts_vcsc_horizontal_steps_container",
						"class" 							=> "",
						"as_parent" 						=> array('only' => 'TS_VCSC_Horizontal_Steps_Item'),
						"category" 							=> "VC Extensions",
						"description" 						=> "Place a horizontal steps element.",
						"controls" 							=> "full",
						"content_element"                   => true,
						"is_container" 						=> true,
						"container_not_allowed" 			=> false,
						"show_settings_on_create"           => true,
						"admin_enqueue_js"            		=> "",
						"admin_enqueue_css"           		=> "",
						"params" 							=> array(
							// Step Settings
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_1",
								"value"						=> "",
								"seperator"					=> "Step Settings",
								"description"               => __( "", "ts_visual_composer_extend" ),
							),
							array(
								"type"                      => "nouislider",
								"heading"                   => __( "Min. Width per Step", "ts_visual_composer_extend" ),
								"param_name"                => "min_width",
								"value"                     => "250",
								"min"                       => "100",
								"max"                       => "500",
								"step"                      => "1",
								"unit"                      => 'px',
								"admin_label"           	=> true,
								"description"               => __( "Define the minimum width for each individal step.", "ts_visual_composer_extend" )
							),
							array(
								"type"                      => "nouislider",
								"heading"                   => __( "Default Icon Size", "ts_visual_composer_extend" ),
								"param_name"                => "icon_size",
								"value"                     => "75",
								"min"                       => "50",
								"max"                       => "100",
								"step"                      => "1",
								"unit"                      => '%',
								"admin_label"           	=> true,
								"description"               => __( "Define the height of the icon (in percent), based on step circle size.", "ts_visual_composer_extend" )
							),
							array(
								"type"                      => "nouislider",
								"heading"                   => __( "Max. Icon Size", "ts_visual_composer_extend" ),
								"param_name"                => "icon_max",
								"value"                     => "100",
								"min"                       => "75",
								"max"                       => "200",
								"step"                      => "1",
								"unit"                      => 'px',
								"admin_label"           	=> true,
								"description"               => __( "Define the maximum height for the icon in each step; will overrule default icon size.", "ts_visual_composer_extend" )
							),
							// Animation Settings
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_2",
								"value"						=> "",
								"seperator"					=> "Animation Settings",
								"description"               => __( "", "ts_visual_composer_extend" ),
								"group" 			        => "Animation Settings",
							),
							array(
								"type"						=> "css3animations",
								"class"						=> "",
								"heading"					=> __("Viewport Animation", "ts_visual_composer_extend"),
								"param_name"				=> "animation_view",
								"standard"					=> "false",
								"prefix"					=> "ts-viewport-css-",
								"connector"					=> "css3animations_view",
								"noneselect"				=> "true",
								"default"					=> "",
								"value"						=> "",
								"admin_label"				=> false,
								"description"				=> __("Select the viewport animation for the icon / image.", "ts_visual_composer_extend"),
								"group" 					=> "Animation Settings",
							),
							array(
								"type"						=> "hidden_input",
								"heading"					=> __( "Viewport Animation", "ts_visual_composer_extend" ),
								"param_name"				=> "css3animations_view",
								"value"						=> "",
								"admin_label"				=> true,
								"description"				=> __( "", "ts_visual_composer_extend" ),
								"group" 					=> "Animation Settings",
							),
							array(
								"type"              		=> "nouislider",
								"heading"           		=> __( "Animation Initial Delay", "ts_visual_composer_extend" ),
								"param_name"       		 	=> "animation_delay",
								"value"             		=> "0",
								"min"               		=> "0",
								"max"               		=> "5000",
								"step"              		=> "100",
								"unit"              		=> 'ms',
								"description"       		=> __( "Define an optional initial delay for the viewport animation.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "animation_view", 'not_empty' => true ),
								"group" 					=> "Animation Settings",
							),
							array(
								"type"              		=> "nouislider",
								"heading"           		=> __( "Animation Steps Delay", "ts_visual_composer_extend" ),
								"param_name"       		 	=> "animation_steps",
								"value"             		=> "500",
								"min"               		=> "200",
								"max"               		=> "2000",
								"step"              		=> "100",
								"unit"              		=> 'ms',
								"description"       		=> __( "Define an delay for the viewport animation between each step.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "animation_view", 'not_empty' => true ),
								"group" 					=> "Animation Settings",
							),
							array(
								"type"						=> "switch_button",
								"heading"           		=> __( "Allow on Mobile", "ts_visual_composer_extend" ),
								"param_name"        		=> "animation_mobile",
								"value"             		=> "false",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"description"       		=> __( "Switch the toggle to allow the viewport animation to be used on mobile devices.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "animation_view", 'not_empty' => true ),
								"group" 					=> "Animation Settings",
							),		
							// Other Settings
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
							array(
								"type"              		=> "load_file",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"value"             		=> "Animation Files",
								"param_name"        		=> "el_file2",
								"file_type"         		=> "css",
								"file_id"         			=> "ts-extend-animations",
								"file_path"         		=> "css/ts-visual-composer-extend-animations.min.css",
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
	class WPBakeryShortCode_TS_VCSC_Horizontal_Steps_Container extends WPBakeryShortCodesContainer {};
}
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_TS_VCSC_Horizontal_Steps_Item extends WPBakeryShortCode {};
}

// Initialize "TS Animations" Class
if (class_exists('TS_Horizontal_Steps')) {
	$TS_Horizontal_Steps = new TS_Horizontal_Steps;
}
?>