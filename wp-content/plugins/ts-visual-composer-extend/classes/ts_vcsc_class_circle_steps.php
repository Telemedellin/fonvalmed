<?php
if (!class_exists('TS_Circle_Steps')){
	class TS_Circle_Steps{
		function __construct(){
			global $VISUAL_COMPOSER_EXTENSIONS;
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				add_action('init',                              		array($this, 'TS_VCSC_Add_Circle_Loop_Elements'), 9999999);
			} else {
				add_action('admin_init',		                		array($this, 'TS_VCSC_Add_Circle_Loop_Elements'), 9999999);
			}
			add_shortcode('TS_VCSC_Circle_Steps_Container',				array($this, 'TS_VCSC_Circle_Steps_Container'));
			add_shortcode('TS_VCSC_Circle_Steps_Item',					array($this, 'TS_VCSC_Circle_Steps_Item'));
		}
		
		function TS_VCSC_Circle_Steps_Container($atts, $content = null){
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();

			extract(shortcode_atts(array(
				// Circle Setup
				'circle_initial'				=> 1,
				'circle_position'				=> 'right',
				'circle_direction'				=> 'clockwise',
				'circle_speed'					=> 500,
				'circle_indicator'				=> 'numeric',
				'circle_deeplinking'			=> 'none',
				// Mobile Settings
				'mobile_large'					=> 720,
				'mobile_small'					=> 480,
				// Circle Styling				
				'circle_strength'				=> 2,
				'circle_radius'					=> 220,
				'circle_color'					=> '#CCCCCC',
				'circle_back'					=> '#F7F7F7',
				// Size Settings
				'size_border' 					=> 3,
				'size_normal' 					=> 100,
				'size_selected' 				=> 150,
				'size_icon'						=> 75,
				// Active Icon Settings
				'icon_color_active'				=> '#D63838',
				'icon_back_active'				=> '#FFF782',
				'icon_border_active'			=> '#D63838',
				'icon_shadow_active'			=> 'rgba(0, 0, 0, 0.25)',
				// Hover Icon Settings
				'icon_color_hover'				=> '#333333',
				'icon_back_hover'				=> '#F7F7F7',
				'icon_border_hover'				=> '#636363',
				'icon_shadow_hover'				=> 'rgba(0, 0, 0, 0.25)',
				// AutoRotation Settings
				'automatic_rotation'			=> 'false',
				'automatic_interval'			=> 5000,
				'automatic_controls'			=> 'true',
				'automatic_color'				=> '#636363',
				'automatic_hover'				=> 'true',		
				// NiceScroll Settings
				'scroll_nice'					=> 'true',
				'scroll_color'					=> '#EDEDED',
				'scroll_border'					=> '#CACACA',
				'scroll_offset'					=> 0,
				// Tooltip Settings
				'tooltipster_allow'				=> 'true',
				'tooltipster_position'			=> 'top',
				'tooltipster_style'				=> 'tooltipster-black',
				'tooltipster_effect'			=> 'swing',
				'tooltipster_offsetx'			=> 0,
				'tooltipster_offsety'			=> 0,
				// Other Settings
				'margin_bottom'					=> 0,
				'margin_top' 					=> 0,
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			),$atts));
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
				wp_enqueue_style('dashicons');
				if ($scroll_nice == "true") {
					wp_enqueue_script('ts-extend-nicescroll');
				}
				if ($tooltipster_allow == "true") {
					wp_enqueue_style('ts-extend-tooltipster');
					wp_enqueue_script('ts-extend-tooltipster');
				}
				wp_enqueue_style('ts-extend-circlesteps');
				wp_enqueue_script('ts-extend-circlesteps');
				wp_enqueue_style('ts-visual-composer-extend-front');
				wp_enqueue_script('ts-visual-composer-extend-front');
			} else {
				wp_enqueue_style('ts-extend-circlesteps');
			}
			
			$randomizer							= mt_rand(999999, 9999999);
			
			if (!empty($el_id)) {
				$steps_id						= $el_id;
			} else {
				$steps_id						= 'ts-vcsc-process-loop-steps-container-' . $randomizer;
			}
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend 						= "true";
				$margin_top						= 40;
			} else {
				$frontend 						= "false";
				$margin_top						= $margin_top;
			}
			
			$output 							= '';
			
			$data_circle						= 'data-circle-position="' . $circle_position . '" data-circle-initial="' . ($circle_initial - 1) . '" data-circle-deeplink="' . $circle_deeplinking . '" data-circle-speed="' . $circle_speed . '" data-circle-direction="' . $circle_direction . '" data-circle-strength="' . $circle_strength . '" data-circle-color="' . $circle_color . '" data-circle-radius="' . $circle_radius . '" data-circle-background="' . $circle_back . '" data-circle-indicator="' . $circle_indicator . '"';
			$data_mobile						= 'data-mobile-large="' . $mobile_large . '" data-mobile-small="' . $mobile_small . '"';
			$data_sizes							= 'data-size-border="' . $size_border . '" data-size-normal="' . $size_normal . '" data-size-selected="' . $size_selected . '" data-size-icon="' . $size_icon . '"';
			$data_automatic						= 'data-automatic-allow="' . $automatic_rotation . '" data-automatic-controls="' . $automatic_controls . '" data-automatic-color="' . $automatic_color . '" data-automatic-interval="' . $automatic_interval . '" data-automatic-hover="' . $automatic_hover . '"';
			$data_scroll						= 'data-scroll-nice="' . $scroll_nice . '" data-scroll-color="' . $scroll_color . '" data-scroll-border="' . $scroll_border . '" data-scroll-offset="' . $scroll_offset . '"';
			$data_tooltip						= 'data-tooltipster-enable="' . $tooltipster_allow . '" data-tooltipster-animation="' . $tooltipster_effect . '" data-tooltipster-position="' . $tooltipster_position . '" data-tooltipster-style="' . $tooltipster_style . '" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			$data_icons_active					= 'data-active-color="' . $icon_color_active . '" data-active-border="' . $icon_border_active . '" data-active-background="' . $icon_back_active . '" data-active-shadow="' . $icon_shadow_active . '"';
			$data_icons_hover					= 'data-hover-color="' . $icon_color_hover . '" data-hover-border="' . $icon_border_hover . '" data-hover-background="' . $icon_back_hover . '" data-hover-shadow="' . $icon_shadow_hover . '"';
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 						= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-process-circle-steps-main-wrapper ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Circle_Steps_Container', $atts);
			} else {
				$css_class 						= 'ts-process-circle-steps-main-wrapper ' . $el_class;
			}
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$output .= '<div id="ts-process-circle-fronteditor-wrapper-' . $randomizer . '" class="ts-process-circle-fronteditor-wrapper" data-random="' . $randomizer . '">';
					$output .= '<div id="ts-process-circle-fronteditor-dataset-' . $randomizer . '" class="ts-process-circle-fronteditor-dataset" data-random="' . $randomizer . '">';
						$output .= do_shortcode($content);
					$output .= '</div>';
				$output .= '</div>';
			} else {
				$output .= '<div id="' . $steps_id . '" class="' . $css_class . '" data-random="' . $randomizer . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;" ' . $data_circle . ' ' . $data_mobile . ' ' . $data_sizes . ' ' . $data_automatic . ' ' . $data_scroll . ' ' . $data_tooltip . ' ' . $data_icons_active . ' ' . $data_icons_hover . ' data-frontend="' . $frontend . '">';
					$output .= '<div id="ts-process-circle-preloader-wrapper-' . $randomizer . '" class="ts-process-circle-preloader-wrapper" data-random="' . $randomizer . '" style="display: block;"></div>';
					$output .= '<div id="ts-process-circle-dataset-wrapper-' . $randomizer . '" class="ts-process-circle-dataset-wrapper" data-random="' . $randomizer . '" style="display: none;">';
						$output .= do_shortcode($content);
					$output .= '</div>';
					$output .= '<div id="ts-process-circle-circle-wrapper-' . $randomizer . '" class="ts-process-circle-circle-wrapper ts-process-circle-text-position-' . $circle_position . ' ts-process-circle-circle-rendering" data-init="false" data-hover="false" data-stop="false" data-random="' . $randomizer . '" style="display: block; opacity: 0;"></div>';
				$output .= '</div>';
			}
			
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
		
		function TS_VCSC_Circle_Steps_Item($atts, $content = null){
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();
			
			extract(shortcode_atts(array(
				'step_replace'					=> 'false',
				'step_icon'						=> '',
				'step_image'					=> '',
				'step_title'					=> '',
				// Title + Content Settings
				'title_color'					=> '#4E4E4E',
				'title_align'					=> 'center',
				'title_size'					=> 26,
				'title_weight'					=> '300',
				'content_color'					=> '#6C6C6C',
				'content_align'					=> 'justify',
				'content_size'					=> 18,
				// Icon Settings
				'icon_color_default'			=> '#CCCCCC',
				'icon_back_default'				=> '#FFFFFF',
				'icon_border_default'			=> '#636363',
				'icon_shadow_default'			=> 'rgba(99, 99, 99, 0.25)',
				// Tooltip Settings
				'tooltip_source'				=> 'title',
				'tooltip_content'				=> '',
				// Other Settings
				'hash_id'						=> '',
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			),$atts));
			
			$output								= '';
			$style								= '';
			$randomizer							= mt_rand(999999, 9999999);
			
			if (!empty($el_id)) {
				$steps_id						= $el_id;
			} else {
				$steps_id						= $hash_id;
			}
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend 						= "true";
			} else {
				$frontend 						= "false";
			}
			
			if (($step_replace == "true") && (!empty($step_image))) {
				$step_type						= 'image';
				$step_icon						= '';
				$step_image_path 				= wp_get_attachment_image_src($step_image, 'large');
				$step_image_path				= $step_image_path[0];
			} else {
				$step_type						= 'icon';
				$step_icon						= $step_icon;
				$step_image_path				= '';
			}
			
			// Tooltip
			if ($tooltip_source != 'none') {
				if ($tooltip_source == 'title') {
					$Tooltip_Content			= strip_tags($step_title);
				} else if ($tooltip_source == 'custom') {
					$Tooltip_Content			= rawurldecode(base64_decode(strip_tags($tooltip_content)));
				}
			} else {
				$Tooltip_Content				= '';
			}
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-circle-loop-steps-item ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Circle_Steps_Item', $atts);
			} else {
				$css_class 	= 'ts-circle-loop-steps-item ' . $el_class;
			}
			
			$data_icon							= 'data-icon="' . $step_icon . '" data-image="' . $step_image_path . '" data-icon-color="' . $icon_color_default . '" data-icon-background="' . $icon_back_default . '" data-icon-border="' . $icon_border_default . '" data-icon-shadow="' . $icon_shadow_default . '"';
			$data_title							= 'data-title="' . $step_title . '" data-title-size="' . $title_size . '" data-title-color="' . $title_color . '" data-title-align="' . $title_align . '" data-title-weight="' . $title_weight . '"';
			$data_content						= 'data-content-size="' . $content_size . '" data-content-color="' . $content_color . '" data-content-align="' . $content_align . '"';
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$output .= '<div id="ts-process-circle-fronteditor-single-wrapper-' . $randomizer . '" class="ts-process-circle-fronteditor-single-wrapper">';				
					if (($step_replace == "true") && (!empty($step_image))) {
						$output .= '<div id="ts-process-circle-fronteditor-single-image-' . $randomizer . '" class="ts-process-circle-fronteditor-single-image"><img src="' . $step_image_path . '"/></div>';
					} else if ($step_icon != '') {
						$output .= '<div id="ts-process-circle-fronteditor-single-icon-' . $randomizer . '" class="ts-process-circle-fronteditor-single-icon"><i class="' . $step_icon . '" style="color: ' . $icon_color_default . ';"></i></div>';
					}
					$output .= '<div id="ts-process-circle-fronteditor-single-title-' . $randomizer . '" class="ts-process-circle-fronteditor-title-content" style="color: ' . $title_color . '; text-align: ' . $title_align . '; font-size: ' . $title_size . 'px; line-height: ' . $title_size . 'px; font-weight: ' . $title_weight . ';">' . $step_title . '</div>';
					$output .= '<div id="ts-process-circle-fronteditor-single-content-' . $randomizer . '" class="ts-process-circle-fronteditor-single-content" style="color: ' . $content_color . '; font-size: ' . $content_size . 'px; text-align: ' . $content_align . ';">';
						$output .= do_shortcode($content);
					$output .= '</div>';
				$output .= '</div>';
			} else {
				$output .= '<div id="' . $steps_id . '" class="ts-process-circle-dataset-single ' . $el_class . '" data-type="' . $step_type . '" data-deeplink="' . $hash_id . '" ' . $data_icon . ' ' . $data_title . ' ' . $data_content . '>';
					$output .= '<div id="ts-process-circle-dataset-single-content-' . $randomizer . '" class="ts-process-circle-dataset-single-content">';
						$output .= do_shortcode($content);
					$output .= '</div>';
					$output .= '<div id="ts-process-circle-dataset-single-tooltip-' . $randomizer . '" class="ts-process-circle-dataset-single-tooltip">';
						$output .= $Tooltip_Content;
					$output .= '</div>';
				$output .= '</div>';
			}
			
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
		
		function TS_VCSC_Add_Circle_Loop_Elements() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			// Add Single Circle Step Item
			if (function_exists('vc_map')) {
				vc_map(
					array(
						"name"                      		=> __( "TS Circle Steps Item", "ts_visual_composer_extend" ),
						"base"                      		=> "TS_VCSC_Circle_Steps_Item",
						"icon" 	                    		=> "icon-wpb-ts_vcsc_circle_steps_item",
						"class"                     		=> "",
						"content_element"					=> true,
						"as_child"							=> array('only' => 'TS_VCSC_Circle_Steps_Container'),
						"category"                  		=> __( 'VC Extensions', "ts_visual_composer_extend" ),
						"description"               		=> __("Place a single circle steps item", "ts_visual_composer_extend"),
						"admin_enqueue_js"            		=> "",
						"admin_enqueue_css"           		=> "",
						"js_view"							=> "TS_VCSC_CircleStepSingleViewCustom",
						"front_enqueue_js"					=> preg_replace( '/\s/', '%20', TS_VCSC_GetResourceURL('/js/frontend/ts-vcsc-frontend-circlestep-single.min.js')),
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
								"admin_label"       		=> true,
								"description"       		=> __( "Switch the toggle to either use an icon or a normal image.", "ts_visual_composer_extend" ),
								"dependency"        		=> ""
							),
							array(
								'type' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
								'heading' 					=> __( 'Icon', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'step_icon',
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
								"dependency"        		=> array( 'element' => "step_replace", 'value' => 'false' )
							),
							array(
								"type"              		=> "attach_image",
								"heading"           		=> __( "Select Image", "ts_visual_composer_extend" ),
								"param_name"        		=> "step_image",
								"value"             		=> "",
								"admin_label"       		=> true,
								"description"       		=> __( "Image must have equal dimensions for scaling purposes (i.e. 100x100).", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "step_replace", 'value' => 'true' )
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Icon: Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "icon_color_default",
								"value"             		=> "#CCCCCC",
								"description"       		=> __( "Define the color for the icon.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "step_replace", 'value' => 'false' )
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Icon: Background", "ts_visual_composer_extend" ),
								"param_name"        		=> "icon_back_default",
								"value"             		=> "#FFFFFF",
								"description"       		=> __( "Define the background color for the icon or image.", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Icon: Border", "ts_visual_composer_extend" ),
								"param_name"        		=> "icon_border_default",
								"value"             		=> "#636363",
								"description"       		=> __( "Define the border color for the icon or image.", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Icon: Shadow", "ts_visual_composer_extend" ),
								"param_name"        		=> "icon_shadow_default",
								"value"             		=> "rgba(99, 99, 99, 0.25)",
								"description"       		=> __( "Define the shadow color for the icon or image.", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "dropdown",
								"heading"           		=> __( "Tooltip Source", "ts_visual_composer_extend" ),
								"param_name"        		=> "tooltip_source",
								"width"             		=> 150,
								"value"             		=> array(
									__( "Use Step Title", "ts_visual_composer_extend" )             => "title",
									__( "Enter Custom Tooltip", "ts_visual_composer_extend" )		=> "custom",
									__( "No Tooltip", "ts_visual_composer_extend" )					=> "none",
								),
								"admin_label"       		=> true,
								"description"       		=> __( "Select if and what type of tooltip should be used for the circle step.", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "textarea_raw_html",
								"class"             		=> "",
								"heading"           		=> __( "Tooltip Content", "ts_visual_composer_extend" ),
								"param_name"       	 		=> "tooltip_content",
								"value"             		=> base64_encode(""),
								"description"       		=> __( "Enter the tooltip that should be used for the circle step; HTML code can be used.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "tooltip_source", 'value' => 'custom' ),
							),
							// Title Settings
							array(
								"type"              		=> "seperator",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "seperator_2",
								"value"						=> "",
								"seperator"					=> "Title Settings",
								"description"       		=> __( "", "ts_visual_composer_extend" ),
								"group"						=> "Step Content"
							),
							array (
								'type' 						=> 'textfield',
								'heading' 					=> __( 'Title', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'step_title',
								"admin_label"				=> true,
								'description' 				=> __( 'Provide a title or name for this step element.', 'ts_visual_composer_extend' ),
								"group"						=> "Step Content"
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Title Font Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "title_color",
								"value"             		=> "#4E4E4E",
								"description"       		=> __( "Define the font color for the title.", "ts_visual_composer_extend" ),
								"group"						=> "Step Content"
							),
							array(
								"type"              		=> "nouislider",
								"heading"           		=> __( "Title Font Size", "ts_visual_composer_extend" ),
								"param_name"        		=> "title_size",
								"value"             		=> "26",
								"min"               		=> "16",
								"max"               		=> "60",
								"step"              		=> "1",
								"unit"              		=> 'px',
								"description"       		=> __( "Define the font size for the title.", "ts_visual_composer_extend" ),
								"group"						=> "Step Content"
							),
							array(
								"type"              		=> "dropdown",
								"heading"           		=> __( "Title Font Weight", "ts_visual_composer_extend" ),
								"param_name"        		=> "title_weight",
								"width"             		=> 150,
								"value"             		=> array(
									__( 'Normal', "ts_visual_composer_extend" )   		=> "normal",
									__( 'Bold', "ts_visual_composer_extend" )     		=> "bold",
									__( 'Bolder', "ts_visual_composer_extend" )   		=> "bolder",
									__( 'Light', "ts_visual_composer_extend" )    		=> "300",
									__( 'Lighter', "ts_visual_composer_extend" )		=> "100",
								),
								"std"						=> "300",
								"default"					=> "300",
								"description"       		=> __( "Select the font weight for the title text.", "ts_visual_composer_extend" ),
								"group"						=> "Step Content"
							),
							array(
								"type"              		=> "dropdown",
								"heading"           		=> __( "Title Align", "ts_visual_composer_extend" ),
								"param_name"        		=> "title_align",
								"width"             		=> 150,
								"value"             		=> array(
									__( "Center", "ts_visual_composer_extend" )                   	=> "center",
									__( "Left", "ts_visual_composer_extend" )                      	=> "left",
									__( "Right", "ts_visual_composer_extend" )                    	=> "right",
									__( "Justify", "ts_visual_composer_extend" )                   	=> "justify",

								),
								"std"						=> "center",
								"default"					=> "center",
								"description"       		=> __( "Select how the title text should be aligned.", "ts_visual_composer_extend" ),
								"group"						=> "Step Content"
							),
							// Content Settings
							array(
								"type"              		=> "seperator",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "seperator_3",
								"value"						=> "",
								"seperator"					=> "Content Settings",
								"description"       		=> __( "", "ts_visual_composer_extend" ),
								"group"						=> "Step Content"
							),
							array(
								"type"						=> "textarea_html",
								"class"						=> "",
								"heading"					=> __( "Content", "ts_visual_composer_extend" ),
								"param_name"				=> "content",
								"value"						=> "",
								"description"				=> __( "Create the content for this step element.", "ts_visual_composer_extend" ),
								"group"						=> "Step Content"
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Content Font Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "content_color",
								"value"             		=> "#6C6C6C",
								"description"       		=> __( "Define the font color for the content.", "ts_visual_composer_extend" ),
								"group"						=> "Step Content"
							),
							array(
								"type"              		=> "nouislider",
								"heading"           		=> __( "Content Font Size", "ts_visual_composer_extend" ),
								"param_name"        		=> "content_size",
								"value"             		=> "18",
								"min"               		=> "12",
								"max"               		=> "60",
								"step"              		=> "1",
								"unit"              		=> 'px',
								"description"       		=> __( "Define the font size for the content.", "ts_visual_composer_extend" ),
								"group"						=> "Step Content"
							),
							array(
								"type"              		=> "dropdown",
								"heading"           		=> __( "Content Align", "ts_visual_composer_extend" ),
								"param_name"        		=> "content_align",
								"width"             		=> 150,
								"value"             		=> array(
									__( "Justify", "ts_visual_composer_extend" )                   	=> "justify",
									__( "Center", "ts_visual_composer_extend" )                   	=> "center",
									__( "Left", "ts_visual_composer_extend" )                      	=> "left",
									__( "Right", "ts_visual_composer_extend" )                    	=> "right",
								),
								"std"						=> "justify",
								"default"					=> "justify",
								"description"       		=> __( "Select how the content text should be aligned.", "ts_visual_composer_extend" ),
								"group"						=> "Step Content"
							),
							// Other Settings
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_4",
								"value"						=> "",
								"seperator"					=> "Other Settings",
								"description"               => __( "", "ts_visual_composer_extend" ),
								"group" 			        => "Other Settings",
							),
							array (
								'type' 						=> 'auto_generate',
								'heading' 					=> __( 'Deeplink ID', 'ts_visual_composer_extend' ),
								'param_name' 				=> "hash_id",
								"prefix"					=> 'step-',
								'description' 				=> __( 'This is the automatic identifier used for the optional deeplinking; it can not be changed.', 'ts_visual_composer_extend' ),
								"admin_label"				=> true,
								"group" 					=> "Other Settings",
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
						)
					)
				);
			}
			// Add Steps Container
			if (function_exists('vc_map')) {
				vc_map( 
					array(
						"name" 								=> __("TS Circle Steps", "ts_visual_composer_extend"),
						"base" 								=> "TS_VCSC_Circle_Steps_Container",
						"icon" 								=> "icon-wpb-ts_vcsc_circle_steps_container",
						"class" 							=> "",
						"as_parent" 						=> array('only' => 'TS_VCSC_Circle_Steps_Item'),
						"category" 							=> "VC Extensions",
						"description" 						=> "Place a circle steps element.",
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
								"seperator"					=> "Circle Setup",
								"description"               => __( "", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "dropdown",
								"heading"           		=> __( "Circle Direction", "ts_visual_composer_extend" ),
								"param_name"        		=> "circle_direction",
								"width"             		=> 150,
								"value"             		=> array(
									__( "Clockwise (Right)", "ts_visual_composer_extend" )			=> "clockwise",
									__( "Counterclockwise (Left)", "ts_visual_composer_extend" )	=> "counterclockwise",
								),
								"admin_label"       		=> true,
								"description"       		=> __( "Define in which direction the circle should be rotated.", "ts_visual_composer_extend" ),
							),							
							array(
								"type"              		=> "nouislider",
								"heading"           		=> __( "Circle Speed", "ts_visual_composer_extend" ),
								"param_name"        		=> "circle_speed",
								"value"             		=> "500",
								"min"               		=> "100",
								"max"               		=> "2000",
								"step"              		=> "100",
								"unit"              		=> 'ms',
								"admin_label"       		=> true,
								"description"       		=> __( "Define the speed in ms at which the circle should be rotated.", "ts_visual_composer_extend" ),
							),		
							array(
								"type"              		=> "dropdown",
								"heading"           		=> __( "Text Position", "ts_visual_composer_extend" ),
								"param_name"        		=> "circle_position",
								"width"             		=> 150,
								"value"             		=> array(
									__( "Right", "ts_visual_composer_extend" )             			=> "right",
									__( "Left", "ts_visual_composer_extend" )						=> "left",
									__( "Top", "ts_visual_composer_extend" )						=> "top",
									__( "Bottom", "ts_visual_composer_extend" )						=> "bottom",
								),
								"admin_label"       		=> true,
								"description"       		=> __( "Select where the step content block should be placed in relation to the circle.", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "dropdown",
								"heading"           		=> __( "Step Indicator", "ts_visual_composer_extend" ),
								"param_name"        		=> "circle_indicator",
								"width"             		=> 150,
								"value"             		=> array(
									__( 'Auto Standard Number', "ts_visual_composer_extend" )		=> "number",
									__( 'Auto Roman Number', "ts_visual_composer_extend" )      	=> "roman",
									__( 'Auto Letter', "ts_visual_composer_extend" )      			=> "alpha",
									__( "None", "ts_visual_composer_extend" )						=> "none",
								),
								"admin_label"       		=> true,
								"description"       		=> __( "Select if and what type of indicator should be shown, highlighting the step position in the circle.", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "nouislider",
								"heading"           		=> __( "Initial Step", "ts_visual_composer_extend" ),
								"param_name"        		=> "circle_initial",
								"value"             		=> "1",
								"min"               		=> "1",
								"max"               		=> "20",
								"step"              		=> "1",
								"unit"              		=> '',
								"admin_label"       		=> true,
								"description"       		=> __( "Define the step the circle should initially be starting out.", "ts_visual_composer_extend" ),
							),
							array(
								'type' 						=> 'dropdown',
								'heading' 					=> __( 'Step Deeplinking', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'circle_deeplinking',
								'value' => array(
									__('No Deeplinking', 'ts_visual_composer_extend')				=> 'none',
									__('Only for Active Session', 'ts_visual_composer_extend')		=> 'session',
									__('Page Load + Active Session', 'ts_visual_composer_extend')	=> 'all',
								),
								'description' 				=> __( 'Select what type of deeplinking should be applied to the steps.', 'ts_visual_composer_extend' ),
							),
							// Circle Mobile
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_2",
								"value"						=> "",
								"seperator"					=> "Mobile Settings",
								"description"               => __( "", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "nouislider",
								"heading"           		=> __( "Two Columns Switch", "ts_visual_composer_extend" ),
								"param_name"        		=> "mobile_large",
								"value"             		=> "720",
								"min"               		=> "480",
								"max"               		=> "1280",
								"step"              		=> "1",
								"unit"              		=> "px",
								"description"       		=> __( "Define the width at which the element should switch to a basic two column layout.", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "nouislider",
								"heading"           		=> __( "Single Column Switch", "ts_visual_composer_extend" ),
								"param_name"        		=> "mobile_small",
								"value"             		=> "480",
								"min"               		=> "240",
								"max"               		=> "780",
								"step"              		=> "1",
								"unit"              		=> "px",
								"description"       		=> __( "Define the width at which the element should switch to a basic one column layout.", "ts_visual_composer_extend" ),
							),
							// AutoPlay Settings
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_3",
								"value"						=> "",
								"seperator"					=> "AutoPlay Settings",
								"description"               => __( "", "ts_visual_composer_extend" ),
							),
							array(
								"type"                  	=> "switch_button",
								"heading"			    	=> __( "Use AutoPlay", "ts_visual_composer_extend" ),
								"param_name"		    	=> "automatic_rotation",
								"value"                 	=> "false",
								"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
								"style"				    	=> "select",
								"design"			   	 	=> "toggle-light",
								"admin_label"       		=> true,
								"description"		    	=> __( "Switch the toggle if you want to apply an AutoPlay to the circle steps.", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "nouislider",
								"heading"           		=> __( "AutoPlay Speed", "ts_visual_composer_extend" ),
								"param_name"        		=> "automatic_interval",
								"value"             		=> "5000",
								"min"               		=> "2000",
								"max"               		=> "10000",
								"step"              		=> "100",
								"unit"              		=> "ms",
								"dependency"        		=> array( 'element' => "automatic_rotation", 'value' => 'true' ),
								"description"       		=> __( "Define the autoplay interval speed in ms.", "ts_visual_composer_extend" ),
							),
							array(
								"type"                  	=> "switch_button",
								"heading"			    	=> __( "Show Controls", "ts_visual_composer_extend" ),
								"param_name"		    	=> "automatic_controls",
								"value"                 	=> "true",
								"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
								"style"				    	=> "select",
								"design"			   	 	=> "toggle-light",
								"description"		    	=> __( "Switch the toggle if you want to show play and pause control buttons for the autoplay feature.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "automatic_rotation", 'value' => 'true' ),
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Controls Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "automatic_color",
								"value"             		=> "#CCCCCC",
								"description"       		=> __( "Define the color for the autoplay controls.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "automatic_controls", 'value' => 'true' ),
							),
							array(
								"type"                  	=> "switch_button",
								"heading"			    	=> __( "Stop on Hover", "ts_visual_composer_extend" ),
								"param_name"		    	=> "automatic_hover",
								"value"                 	=> "true",
								"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
								"style"				    	=> "select",
								"design"			   	 	=> "toggle-light",
								"description"		    	=> __( "Switch the toggle if you want to automatically pause the autoplay when hovering over the element.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "automatic_rotation", 'value' => 'true' ),
							),
							// Circle Styling
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_4",
								"value"						=> "",
								"seperator"					=> "Circle Styling",
								"description"               => __( "", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							array(
								"type"              		=> "nouislider",
								"heading"           		=> __( "Circle: Radius", "ts_visual_composer_extend" ),
								"param_name"        		=> "circle_radius",
								"value"             		=> "220",
								"min"               		=> "100",
								"max"               		=> "400",
								"step"              		=> "1",
								"unit"              		=> "px",
								"admin_label"       		=> true,
								"description"       		=> __( "Define the radius for the circle.", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							array(
								"type"              		=> "nouislider",
								"heading"           		=> __( "Circle: Border Strength", "ts_visual_composer_extend" ),
								"param_name"        		=> "circle_strength",
								"value"             		=> "2",
								"min"               		=> "1",
								"max"               		=> "10",
								"step"              		=> "1",
								"unit"              		=> "px",
								"description"       		=> __( "Define the border strength for the circle.", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),		
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Circle: Border Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "circle_color",
								"value"             		=> "#CCCCCC",
								"description"       		=> __( "Define the border color for the circle.", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Circle: Background Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "circle_back",
								"value"             		=> "#F7F7F7",
								"description"       		=> __( "Define the background color for the circle.", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							// Global Step Settings
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_5",
								"value"						=> "",
								"seperator"					=> "Step Styling",
								"description"               => __( "", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							array(
								"type"              		=> "nouislider",
								"heading"           		=> __( "Step: Border Strength", "ts_visual_composer_extend" ),
								"param_name"        		=> "size_border",
								"value"             		=> "3",
								"min"               		=> "1",
								"max"               		=> "6",
								"step"              		=> "1",
								"unit"              		=> "px",
								"description"       		=> __( "Define the border strength for the steps.", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),	
							array(
								"type"              		=> "nouislider",
								"heading"           		=> __( "Step: Normal Size", "ts_visual_composer_extend" ),
								"param_name"        		=> "size_normal",
								"value"             		=> "100",
								"min"               		=> "50",
								"max"               		=> "150",
								"step"              		=> "1",
								"unit"              		=> "px",
								"description"       		=> __( "Define the standard (non-active) size for the steps.", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),	
							array(
								"type"              		=> "nouislider",
								"heading"           		=> __( "Step: Active Size", "ts_visual_composer_extend" ),
								"param_name"        		=> "size_selected",
								"value"             		=> "150",
								"min"               		=> "75",
								"max"               		=> "200",
								"step"              		=> "1",
								"unit"              		=> "px",
								"description"       		=> __( "Define the size for the active step.", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							array(
								"type"              		=> "nouislider",
								"heading"           		=> __( "Step: Icon Size", "ts_visual_composer_extend" ),
								"param_name"        		=> "size_icon",
								"value"             		=> "75",
								"min"               		=> "50",
								"max"               		=> "150",
								"step"              		=> "1",
								"unit"              		=> "px",
								"description"       		=> __( "Define the size for the icon or image in the step; in relation to the active step size.", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							// Active Icon Settings
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_6",
								"value"						=> "",
								"seperator"					=> "Active Icon Styling",
								"description"               => __( "", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Active Icon: Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "icon_color_active",
								"value"             		=> "#D63838",
								"description"       		=> __( "Define the color for the icon in the active step.", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Active Icon: Background Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "icon_back_active",
								"value"             		=> "#FFF782",
								"description"       		=> __( "Define the background color for the icon in the active step.", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Active Icon: Border Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "icon_border_active",
								"value"             		=> "#D63838",
								"description"       		=> __( "Define the border color for the icon in the active step.", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Active Icon: Shadow Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "icon_shadow_active",
								"value"             		=> "rgba(0, 0, 0, 0.25)",
								"description"       		=> __( "Define the shadow color for the icon in the active step.", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							// Hover Icon Settings
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_7",
								"value"						=> "",
								"seperator"					=> "Hover Icon Styling",
								"description"               => __( "", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Hover Icon: Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "icon_color_hover",
								"value"             		=> "#333333",
								"description"       		=> __( "Define the hover color for the icon in a non-active step.", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Hover Icon: Background Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "icon_back_hover",
								"value"             		=> "#F7F7F7",
								"description"       		=> __( "Define the hover background color for the icon in a non-active step.", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Hover Icon: Border Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "icon_border_hover",
								"value"             		=> "#636363",
								"description"       		=> __( "Define the hover border color for the icon in a non-active step.", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Hover Icon: Shadow Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "icon_shadow_hover",
								"value"             		=> "rgba(0, 0, 0, 0.25)",
								"description"       		=> __( "Define the hover shadow color for the icon in a non-active step.", "ts_visual_composer_extend" ),
								"group"						=> "Circle Styling",
							),
							// Tooltip Settings
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_8",
								"value"						=> "",
								"seperator"					=> "Tooltip Settings",
								"description"               => __( "", "ts_visual_composer_extend" ),
								"group"						=> "Additional Effects",
							),
							array(
								"type"                  	=> "switch_button",
								"heading"			    	=> __( "Use Tooltips", "ts_visual_composer_extend" ),
								"param_name"		    	=> "tooltipster_allow",
								"value"                 	=> "true",
								"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
								"style"				    	=> "select",
								"design"			   	 	=> "toggle-light",
								"description"		    	=> __( "Switch the toggle if you want to apply a tooltip to each step icon.", "ts_visual_composer_extend" ),
								"group" 					=> "Additional Effects",
							),
							array(
								"type"				    	=> "dropdown",
								"heading"			    	=> __( "Tooltip Position", "ts_visual_composer_extend" ),
								"param_name"		    	=> "tooltipster_position",
								"value"                 	=> array(
									__("Top", "ts_visual_composer_extend")                    	=> "ts-simptip-position-top",
									__("Bottom", "ts_visual_composer_extend")                 	=> "ts-simptip-position-bottom",
									__("Left", "ts_visual_composer_extend")						=> "ts-simptip-position-left",
									__("Right", "ts_visual_composer_extend")                 	=> "ts-simptip-position-right",
								),
								"description"		    	=> __( "Select the tooltip position in relation to the hotspot.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "tooltipster_allow", 'value' => 'true' ),
								"group" 					=> "Additional Effects",
							),
							array(
								"type"				    	=> "dropdown",
								"heading"			    	=> __( "Tooltip Animation", "ts_visual_composer_extend" ),
								"param_name"		    	=> "tooltipster_effect",
								"value"                 	=> array(
									__("Swing", "ts_visual_composer_extend")                    => "swing",
									__("Fall", "ts_visual_composer_extend")                 	=> "fall",
									__("Grow", "ts_visual_composer_extend")                 	=> "grow",
									__("Slide", "ts_visual_composer_extend")                 	=> "slide",
									__("Fade", "ts_visual_composer_extend")                 	=> "fade",
								),
								"description"		    	=> __( "Select how the tooltip entry and exit should be animated once triggered.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "tooltipster_allow", 'value' => 'true' ),
								"group" 					=> "Additional Effects",
							),
							array(
								"type"				    	=> "dropdown",
								"heading"			    	=> __( "Tooltip Style", "ts_visual_composer_extend" ),
								"param_name"		    	=> "tooltipster_style",
								"value"                 	=> array(
									__("Black", "ts_visual_composer_extend")                  	=> "",
									__("Gray", "ts_visual_composer_extend")                   	=> "ts-simptip-style-gray",
									__("Green", "ts_visual_composer_extend")                  	=> "ts-simptip-style-green",
									__("Blue", "ts_visual_composer_extend")                   	=> "ts-simptip-style-blue",
									__("Red", "ts_visual_composer_extend")                    	=> "ts-simptip-style-red",
									__("Orange", "ts_visual_composer_extend")                 	=> "ts-simptip-style-orange",
									__("Yellow", "ts_visual_composer_extend")                 	=> "ts-simptip-style-yellow",
									__("Purple", "ts_visual_composer_extend")                 	=> "ts-simptip-style-purple",
									__("Pink", "ts_visual_composer_extend")                   	=> "ts-simptip-style-pink",
									__("White", "ts_visual_composer_extend")                  	=> "ts-simptip-style-white"
								),
								"description"		    	=> __( "Select the tooltip style.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "tooltipster_allow", 'value' => 'true' ),
								"group" 					=> "Additional Effects",
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
								"dependency"        		=> array( 'element' => "tooltipster_allow", 'value' => 'true' ),
								"group" 					=> "Additional Effects",
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
								"dependency"        		=> array( 'element' => "tooltipster_allow", 'value' => 'true' ),
								"group" 					=> "Additional Effects",
							),
							// NiceScroll Settings
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_9",
								"value"						=> "",
								"seperator"					=> "NiceScroll Settings",
								"description"               => __( "", "ts_visual_composer_extend" ),
								"group"						=> "Additional Effects",
							),
							array(
								"type"                  	=> "switch_button",
								"heading"			    	=> __( "Use NiceScroll", "ts_visual_composer_extend" ),
								"param_name"		    	=> "scroll_nice",
								"value"                 	=> "true",
								"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
								"style"				    	=> "select",
								"design"			   	 	=> "toggle-light",
								"description"		    	=> __( "Switch the toggle if you want to apply a niceScrollBar to the step content if taller than circle.", "ts_visual_composer_extend" ),
								"group" 					=> "Additional Effects",
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Scrollbar: Background Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "scroll_color",
								"value"             		=> "#EDEDED",
								"description"       		=> __( "Define the background color for the niceScroll scrollbar.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "scroll_nice", 'value' => 'true' ),
								"group" 					=> "Additional Effects",
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Scrollbar: Border Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "scroll_border",
								"value"             		=> "#CACACA",
								"description"       		=> __( "Define the border color for the niceScroll scrollbar.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "scroll_nice", 'value' => 'true' ),
								"group" 					=> "Additional Effects",
							),
							array(
								"type"              		=> "nouislider",
								"heading"           		=> __( "Scrollbar: Offset", "ts_visual_composer_extend" ),
								"param_name"        		=> "scroll_offset",
								"value"             		=> "0",
								"min"               		=> "-100",
								"max"               		=> "100",
								"step"              		=> "1",
								"unit"              		=> 'px',
								"description"       		=> __( "Define an optional offset (top) for the scrollbar.", "ts_visual_composer_extend" ),
								"dependency"        		=> array( 'element' => "scroll_nice", 'value' => 'true' ),
								"group" 					=> "Additional Effects",
							),		
							// Other Settings
							array(
								"type"                      => "seperator",
								"heading"                   => __( "", "ts_visual_composer_extend" ),
								"param_name"                => "seperator_10",
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
	class WPBakeryShortCode_TS_VCSC_Circle_Steps_Container extends WPBakeryShortCodesContainer {};
}
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_TS_VCSC_Circle_Steps_Item extends WPBakeryShortCode {};
}

// Initialize "TS Animations" Class
if (class_exists('TS_Circle_Steps')) {
	$TS_Circle_Steps = new TS_Circle_Steps;
}
?>