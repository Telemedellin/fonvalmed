<?php
if (!class_exists('TS_Figure_Navigation')){
	class TS_Figure_Navigation {
		function __construct() {
			global $VISUAL_COMPOSER_EXTENSIONS;
            if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
                add_action('init',                              		array($this, 'TS_VCSC_Add_Figure_Navigation_Elements'), 9999999);
            } else {
                add_action('admin_init',		                		array($this, 'TS_VCSC_Add_Figure_Navigation_Elements'), 9999999);
            }
			add_shortcode('TS_VCSC_Figure_Navigation_Item',				array($this, 'TS_VCSC_Figure_Navigation_Item'));
			add_shortcode('TS_VCSC_Figure_Navigation_Container',       	array($this, 'TS_VCSC_Figure_Navigation_Container'));
		}

		// Single Navigation Item
		function TS_VCSC_Figure_Navigation_Item ($atts, $content = null) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();
			
			wp_enqueue_style('ts-extend-simptip');
			wp_enqueue_style('ts-extend-animations');
			wp_enqueue_style('ts-extend-buttons');
			wp_enqueue_style('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-front');
		
			extract( shortcode_atts( array(
				'figure_active'					=> 'false',
				'figure_background_shape'		=> 'hexagon',
				'figure_background_type'		=> 'color',
				'figure_background_color'		=> '#ffffff',
				'figure_background_image'		=> '',
				'figure_background_pattern'		=> '',
				'figure_background_size'		=> 'cover',
				'figure_background_repeat'		=> 'repeat',
				
				'handle_border_color'			=> '#87CEEB',
				'handle_border_width'			=> 4,
				'handle_text_color'				=> '#000000',
				
				'figure_image'					=> '',
				'figure_maxheight_set'			=> 'false',
				'figure_maxheight_value'		=> '600',
				'figure_title'					=> '',
				'figure_title_color'			=> '#4e4e4d',
				'figure_note'					=> '',
				'figure_note_color'				=> '#787876',
				'figure_icon_handle'			=> 'false',
				'figure_handle_icon'			=> '',
				'figure_handle_text'			=> '',
				
				'button_link'					=> '',
				'button_text'					=> 'Click Here!',
				'button_font'					=> '#ffffff',
				'button_color'					=> '#e9544e',
				
				'tooltip_css'					=> 'true',
				'tooltip_content'				=> '',
				'tooltip_position'				=> 'ts-simptip-position-top',
				'tooltip_style'					=> '',
				
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			), $atts ));
			
			$navigation_random					= mt_rand(999999, 9999999);
			
			// Teaser Link
			$link 								= ($button_link == '||') ? '' : $button_link;
			$link 								= vc_build_link($link);
			$a_href								= $link['url'];
			$a_title 							= $link['title'];
			$a_target 							= $link['target'];
	
			// Check for Front End Editor
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend_edit					= 'true';
			} else {
				$frontend_edit					= 'false';
			}
	
			// Figure Image
			$figure_image						= wp_get_attachment_image_src($figure_image, 'full');
			$figure_background					= 'background-image: url(' . $figure_image[0] . ');';
			
			$figure_border						= 'border-bottom: ' . $handle_border_width . 'px solid ' . $handle_border_color . ';';
			
			// Background Settings
			if ($figure_background_type == "pattern") {
				$figure_background_style		= 'background: url(' . $figure_background_pattern . ') repeat;';
			} else if ($figure_background_type == "color") {
				$figure_background_style		= 'background-color: ' . $figure_background_color .';';
			} else if ($figure_background_type == "image") {
				$background_image				= wp_get_attachment_image_src($figure_background_image, 'full');
				$background_image				= $background_image[0];
				$figure_background_style		= 'background: url(' . $background_image . ') ' . $figure_background_repeat . ' 0 0; background-size: ' . $figure_background_size . ';';
			}
			
			// Tooltip
			if ($tooltip_css == "true") {
				if (strlen($tooltip_content) != 0) {
					$icon_tooltipclasses	= " ts-simptip-multiline " . $tooltip_style . " " . $tooltip_position;
					$icon_tooltipcontent	= ' data-tstooltip="' . $tooltip_content . '"';
				} else {
					$icon_tooltipclasses	= "";
					$icon_tooltipcontent	= "";
				}
			} else {
				$icon_tooltipclasses		= "";
				if (strlen($tooltip_content) != 0) {
					$icon_tooltipcontent	= ' title="' . $tooltip_content . '"';
				} else {
					$icon_tooltipcontent	= "";
				}
			}
			
			// Max Height Settings
			if ($figure_maxheight_set == "true") {
				$image_maxheight			= 'max-height: ' . $figure_maxheight_value . 'px;';
			} else {
				$image_maxheight			= '';
			}
			
			$output = '';
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-teaser ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Figure_Navigation_Item', $atts);
			} else {
				$css_class	= 'ts-teaser ' . $el_class;
			}
			
			$output .= '<div class="ts-figure-navigation-item ' . $icon_tooltipclasses . ' ' . ($frontend_edit=="true" ? "frontend" : "") . '" ' . $icon_tooltipcontent . ' style="width: 25%; height: 100px; ' . $figure_background_style . ';" data-active="' . $figure_active . '" data-frontend="' . $frontend_edit . '">';
				$output .= '<figure class="ts-figure-navigation-figure" style="' . $figure_background . ' ' . $figure_border . ' height: 0px;"></figure>';
				if (isset($figure_image[0])) {
					$output .= '<img class="ts-figure-navigation-image" src="' . $figure_image[0] . '" style="' . $image_maxheight . '">';
				}
				if ($figure_icon_handle == "true") {
					$output .= '<div class="ts-figure-navigation-handle ts-figure-navigation-handle-' . $figure_background_shape . ' ts-figure-navigation-handle-icon" style="background-color: ' . $handle_border_color . '; border-color: ' . $handle_border_color . '; color: ' . $handle_text_color . ';"><i class="' . $figure_handle_icon . '"></i></div>';
				} else if ($figure_handle_text != "") {
					$output .= '<div class="ts-figure-navigation-handle ts-figure-navigation-handle-' . $figure_background_shape . ' ts-figure-navigation-handle-custom" style="background-color: ' . $handle_border_color . '; border-color: ' . $handle_border_color . '; color: ' . $handle_text_color . ';">' . $figure_handle_text . '</div>';
				} else {
					$output .= '<div class="ts-figure-navigation-handle ts-figure-navigation-handle-' . $figure_background_shape . ' ts-figure-navigation-handle-text" style="background-color: ' . $handle_border_color . '; border-color: ' . $handle_border_color . '; color: ' . $handle_text_color . ';"></div>';
				}
				$output .= '<div class="ts-figure-navigation-content" style="height: auto;">';
					$output .= wpb_js_remove_wpautop(do_shortcode($content), true);
				$output .= '</div>';
				if ($a_href != '') {
					$output .= '<a id="ts-figure-navigation-button-' . $navigation_random . '" class="ts-figure-navigation-button" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '" style="background-color: ' . $button_color . '; color: ' . $button_font . ';">' . $button_text . '</a>';
				}
				$output .= '<div class="ts-figure-navigation-title">';
					if ($figure_note != '') {
						$output .= '<span class="ts-figure-navigation-title-note" style="color: ' . $figure_note_color . '">' . $figure_note . '</span>';
					}
					$output .= '<span class="ts-figure-navigation-title-main" style="color: ' . $figure_title_color . '">' . $figure_title . '</span>';
				$output .= '</div>';
			$output .= '</div>';
	
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
		
		// Figure Navigation Container
		function TS_VCSC_Figure_Navigation_Container ($atts, $content = null){
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();

			wp_enqueue_style('ts-extend-simptip');
			wp_enqueue_style('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-front');
			
			extract( shortcode_atts( array(
				'numbering'						=> 'number',
				'start'							=> 1,
				'trigger'						=> 'hover',
				'width_full'					=> 'false',
				'min_width'						=> 250,
				'multiple'						=> 'false',
				'margin_top'                    => 0,
				'margin_bottom'                 => 0,
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			), $atts ));
			
			$navigation_random					= mt_rand(999999, 9999999);
			
			// Check for Front End Editor
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend_edit					= 'true';
			} else {
				$frontend_edit					= 'false';
			}
			
			if (!empty($el_id)) {
				$figure_navigation_id			= $el_id;
			} else {
				$figure_navigation_id			= 'ts-vcsc-figure-navigation-item-' . $navigation_random;
			}
			
			if ($frontend_edit == "true") {
				$trigger 						= "click";
			}
			
			if ($trigger == "hover") {
				$figure_trigger					= 'ts-figure-navigation-hover';	
			} else if ($trigger == "click") {
				$figure_trigger					= 'ts-figure-navigation-click';
			}
			
			$output = '';
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-figure-navigation-container ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Figure_Navigation_Container', $atts);
			} else {
				$css_class	= 'ts-figure-navigation-container ' . $el_class;
			}
			
			$output .= '<section id="' . $figure_navigation_id . '" class="' . $css_class . ' ' . $figure_trigger . ' cover" data-trigger="' . $trigger . '" data-multiple="' . $multiple . '" data-start="' . $start . '" data-widthfull="' . $width_full . '" data-minwidth="' . $min_width . '" data-numbering="' . $numbering . '" data-frontend="' . $frontend_edit . '">';
				$output .= do_shortcode($content);
			$output .= '</section>';
			
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
	
	
		// Add Figure Navigation Elements
        function TS_VCSC_Add_Figure_Navigation_Elements() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			// Add Single Navigation Item
			if (function_exists('vc_map')) {
				vc_map( array(
					"name"                      	=> __( "TS Figure Navigation Item", "ts_visual_composer_extend" ),
					"base"                      	=> "TS_VCSC_Figure_Navigation_Item",
					"icon" 	                    	=> "icon-wpb-ts_vcsc_figure_navigation_item",
					"class"                     	=> "",
					"content_element"				=> true,
					"as_child"						=> array('only' => 'TS_VCSC_Figure_Navigation_Container'),
					"category"                  	=> __( 'VC Extensions', "ts_visual_composer_extend" ),
					"description"               	=> __("Place a single navigation item", "ts_visual_composer_extend"),
					"admin_enqueue_js"            	=> "",
					"admin_enqueue_css"           	=> "",
					"params"                    	=> array(
						// Main Settings
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_1",
							"value"					=> "",
							"seperator"				=> "Basic Settings",
							"description"       	=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"                  => "attach_image",
							"holder" 				=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? "img" : ""),
							"heading"               => __( "Top Image", "ts_visual_composer_extend" ),
							"param_name"            => "figure_image",
							"class"					=> "ts_vcsc_holder_image",
							"value"                 => "",
							"admin_label"           => ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? false : true),
							"description"           => __( "Select the top image you want to use for the figure navigation item.", "ts_visual_composer_extend" )
						),
						array(
							"type"					=> "switch_button",
							"heading"           	=> __( "Set Max. Image Height", "ts_visual_composer_extend" ),
							"param_name"        	=> "figure_maxheight_set",
							"value"             	=> "false",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"description"       	=> __( "Switch the toggle if you want to apply a maximum height to the image; otherwise auto-height will be used.", "ts_visual_composer_extend" ),
							"dependency"			=> "",
						),
						array(
							"type"                  => "nouislider",
							"heading"               => __( "Image Max. Height", "ts_visual_composer_extend" ),
							"param_name"            => "figure_maxheight_value",
							"value"                 => "200",
							"min"                   => "50",
							"max"                   => "1024",
							"step"                  => "1",
							"unit"                  => 'px',
							"description"       	=> __( "Define a maximum height for the image.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "figure_maxheight_set", 'value' => "true" ),
						),
						array(
							"type"					=> "switch_button",
							"heading"           	=> __( "Show on Page Load", "ts_visual_composer_extend" ),
							"param_name"        	=> "figure_active",
							"value"             	=> "false",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"admin_label"       	=> true,
							"description"       	=> __( "Switch the toggle if you want to show this figure navigation item on page load.", "ts_visual_composer_extend" ),
							"dependency"			=> "",
						),
						array(
							"type"					=> "dropdown",
							"heading"				=> __( "Handle Shape", "ts_visual_composer_extend" ),
							"param_name"			=> "figure_background_shape",
							"width"					=> 300,
							"value"					=> array(
								__( 'Hexagon', "ts_visual_composer_extend" )		=> "hexagon",
								__( 'Square', "ts_visual_composer_extend" )      	=> "square",
								__( 'Circle', "ts_visual_composer_extend" )			=> "circle",
							),
							"admin_label"			=> true,
							"description"			=> __( "Select the type of shape that should be applied to the figure navigation handle.", "ts_visual_composer_extend" ),
						),
						array(
							"type"					=> "dropdown",
							"heading"				=> __( "Handle Background", "ts_visual_composer_extend" ),
							"param_name"			=> "figure_background_type",
							"width"					=> 300,
							"value"					=> array(
								__( 'Color', "ts_visual_composer_extend" )			=> "color",
								__( 'Pattern', "ts_visual_composer_extend" )      	=> "pattern",
								__( 'Custom Image', "ts_visual_composer_extend" )	=> "image",
							),
							"admin_label"			=> true,
							"description"			=> __( "Select the type of background that should be applied to the figure navigation handle.", "ts_visual_composer_extend" ),
						),												
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Background Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "figure_background_color",
							"value"             	=> "#ffffff",
							"description"       	=> __( "Define the background color for the figure navigation item.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "figure_background_type", 'value' => "color" ),
						),
						array(
							"type"              	=> "background",
							"heading"           	=> __( "Background Pattern", "ts_visual_composer_extend" ),
							"param_name"        	=> "figure_background_pattern",
							"height"             	=> 200,
							"pattern"             	=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Background_List,
							"value"					=> "",
							"encoding"          	=> "false",
							"description"       	=> __( "Select the background pattern for the figure navigation item.", "ts_visual_composer_extend" ),
							"dependency"        	=> array( 'element' => "figure_background_type", 'value' => 'pattern' )
						),
						array(
							"type"                  => "attach_image",
							"heading"               => __( "Top Image", "ts_visual_composer_extend" ),
							"param_name"            => "figure_background_image",
							"value"                 => "",
							"admin_label"           => false,
							"description"           => __( "Select the custom background image you want to use for the figure navigation item.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "figure_background_type", 'value' => "image" ),
						),
						array(
							"type"					=> "dropdown",
							"heading"				=> __( "Background Size", "ts_visual_composer_extend" ),
							"param_name"			=> "figure_background_size",
							"width"					=> 150,
							"value"					=> array(
								__( "Cover", "ts_visual_composer_extend" ) 			=> "cover",
								__( "150%", "ts_visual_composer_extend" )			=> "150%",
								__( "200%", "ts_visual_composer_extend" )			=> "200%",
								__( "Contain", "ts_visual_composer_extend" ) 		=> "contain",
								__( "Initial", "ts_visual_composer_extend" ) 		=> "initial",
								__( "Auto", "ts_visual_composer_extend" ) 			=> "auto",
							),
							"description"			=> __( "Select how the custom background image should be sized.", "ts_visual_composer_extend" ),
							"dependency"        	=> array( 'element' => "figure_background_type", 'value' => 'image' )
						),
						array(
							"type"					=> "dropdown",
							"heading"				=> __( "Background Repeat", "ts_visual_composer_extend" ),
							"param_name"			=> "figure_background_repeat",
							"width"					=> 150,
							"value"					=> array(
								__( "No Repeat", "ts_visual_composer_extend" )		=> "no-repeat",
								__( "Repeat X + Y", "ts_visual_composer_extend" )	=> "repeat",
								__( "Repeat X", "ts_visual_composer_extend" )		=> "repeat-x",
								__( "Repeat Y", "ts_visual_composer_extend" )		=> "repeat-y"
							),
							"description"			=> __( "Select if and how the background image should be repeated.", "ts_visual_composer_extend" ),
							"dependency"        	=> array( 'element' => "figure_background_type", 'value' => 'image' )
						),
						// Handle Settings
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Handle Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "handle_border_color",
							"value"             	=> "#87CEEB",
							"description"       	=> __( "Define the color for the figure navigation handle.", "ts_visual_composer_extend" ),
							"dependency"        	=> ""
						),
						array(
							"type"                  => "nouislider",
							"heading"               => __( "Handle Width", "ts_visual_composer_extend" ),
							"param_name"            => "handle_border_width",
							"value"                 => "4",
							"min"                   => "1",
							"max"                   => "25",
							"step"                  => "1",
							"unit"                  => 'px',
							"description"       	=> __( "Define the width for the figure navigation handle line.", "ts_visual_composer_extend" ),
							"dependency"			=> "",
						),
						array(
							"type"					=> "switch_button",
							"heading"           	=> __( "Use Icon", "ts_visual_composer_extend" ),
							"param_name"        	=> "figure_icon_handle",
							"value"             	=> "false",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"admin_label"       	=> true,
							"description"       	=> __( "Switch the toggle if you want to use a font icon in the figure navigation handle.", "ts_visual_composer_extend" ),
							"dependency"			=> "",
						),
						array(
							'type' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
							'heading' 				=> __( 'Handle Icon', 'ts_visual_composer_extend' ),
							'param_name' 			=> 'figure_handle_icon',
							'value'					=> '',
							'source'				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorValue,
							'settings' 				=> array(
								'emptyIcon' 				=> false,
								'type' 						=> 'extensions',
								'iconsPerPage' 				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
								'source' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorSource,
							),
							"description"       	=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon you want to display in the handle instead of the automatic numbering.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
							"dependency"			=> array( 'element' => "figure_icon_handle", 'value' => "true" ),
						),	
						array(
							"type"              	=> "textfield",
							"heading"           	=> __( "Custom Handle Number / Letter", "ts_visual_composer_extend" ),
							"param_name"        	=> "figure_handle_text",
							"class"					=> "",
							"value"             	=> "",
							"description"       	=> __( "Enter a custom number or letter for the figure navigation handle; otherwise an automatic number will be applied.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "figure_icon_handle", 'value' => "false" ),
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Handle Icon / Text Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "handle_text_color",
							"value"             	=> "#000000",
							"description"       	=> __( "Define the text or icon color for the figure navigation handle.", "ts_visual_composer_extend" ),
							"dependency"        	=> ""
						),
						// Content Settings
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_2",
							"value"					=> "",
							"seperator"				=> "Navigation Content",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"group" 				=> "Navigation Content",
						),
						array(
							"type"              	=> "textfield",
							"heading"           	=> __( "Title", "ts_visual_composer_extend" ),
							"param_name"        	=> "figure_title",
							"class"					=> "",
							"value"             	=> "",
							"admin_label"           => true,
							"description"       	=> __( "Enter a title for the figure navigation item.", "ts_visual_composer_extend" ),
							"group" 				=> "Navigation Content",
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Title Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "figure_title_color",
							"value"             	=> "#4e4e4d",
							"description"       	=> __( "Define the font color for the figure navigation title.", "ts_visual_composer_extend" ),
							"group" 				=> "Navigation Content",
						),
						array(
							"type"              	=> "textfield",
							"heading"           	=> __( "Description", "ts_visual_composer_extend" ),
							"param_name"        	=> "figure_note",
							"class"					=> "",
							"value"             	=> "",
							"admin_label"           => true,
							"description"       	=> __( "Enter a short description for the figure navigation item.", "ts_visual_composer_extend" ),
							"group" 				=> "Navigation Content",
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Description Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "figure_note_color",
							"value"             	=> "#787876",
							"description"       	=> __( "Define the font color for the figure navigation description.", "ts_visual_composer_extend" ),
							"group" 				=> "Navigation Content",
						),
						array(
							"type"					=> "textarea_html",
							"class"					=> "",
							"heading"				=> __( "Box Content", "ts_visual_composer_extend" ),
							"param_name"			=> "content",
							"value"					=> "",
							"description"			=> __( "Create the content for the figure navigation item.", "ts_visual_composer_extend" ),
							"dependency"			=> "",
							"group" 				=> "Navigation Content",
						),
						// Link Settings
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_3",
							"value"					=> "",
							"seperator"				=> "Link Settings",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"group" 				=> "Link Settings",
						),
						array(
							"type" 					=> "vc_link",
							"heading" 				=> __("Link", "ts_visual_composer_extend"),
							"param_name" 			=> "button_link",
							"description" 			=> __("Provide a link to another site/page for the figure navigation element.", "ts_visual_composer_extend"),
							"group" 				=> "Link Settings",
						),
						array(
							"type"              	=> "textfield",
							"heading"           	=> __( "Button Text", "ts_visual_composer_extend" ),
							"param_name"        	=> "button_text",
							"value"             	=> "Click Here!",
							"description"       	=> __( "Enter a text for the figure navigation link button.", "ts_visual_composer_extend" ),
							"dependency"			=> "",
							"group" 				=> "Link Settings",
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Button Background Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "button_color",
							"value"             	=> "#e9544e",
							"description"       	=> __( "Define the background color for the link button.", "ts_visual_composer_extend" ),
							"dependency"        	=> "",
							"group" 				=> "Link Settings",
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Button Font Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "button_font",
							"value"             	=> "#ffffff",
							"description"       	=> __( "Define the font color for the link button.", "ts_visual_composer_extend" ),
							"dependency"        	=> "",
							"group" 				=> "Link Settings",
						),
						// Tooltip Settings
						array(
							"type"					=> "seperator",
							"heading"				=> __( "", "ts_visual_composer_extend" ),
							"param_name"			=> "seperator_4",
							"value"					=> "",
							"seperator"				=> "Tooltip Settings",
							"description"			=> __( "", "ts_visual_composer_extend" ),
							"group" 				=> "Tooltip Settings",
						),
						array(
							"type"					=> "switch_button",
							"heading"				=> __( "Use Advanced Tooltip", "ts_visual_composer_extend" ),
							"param_name"			=> "tooltip_css",
							"value"					=> "true",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"description"       	=> __( "Switch the toggle if you want to apply am advanced tooltip to the image.", "ts_visual_composer_extend" ),
							"dependency"        	=> "",
							"group" 				=> "Tooltip Settings",
						),
						array(
							"type"					=> "textarea",
							"class"					=> "",
							"heading"				=> __( "Tooltip Content", "ts_visual_composer_extend" ),
							"param_name"			=> "tooltip_content",
							"value"					=> "",
							"description"			=> __( "Enter the tooltip content here (do not use quotation marks).", "ts_visual_composer_extend" ),
							"dependency"			=> "",
							"group" 				=> "Tooltip Settings",
						),
						array(
							"type"					=> "dropdown",
							"class"					=> "",
							"heading"				=> __( "Tooltip Style", "ts_visual_composer_extend" ),
							"param_name"			=> "tooltip_style",
							"value"             	=> array(
								__( "Black", "ts_visual_composer_extend" )                          => "",
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
							"description"			=> __( "Select the tooltip style.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "tooltip_css", 'value' => 'true' ),
							"group" 				=> "Tooltip Settings",
						),
						// Load Custom CSS/JS File
						array(
							"type"              	=> "load_file",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "el_file",
							"value"             	=> "",
							"file_type"         	=> "js",
							"file_path"         	=> "js/ts-visual-composer-extend-element.min.js",
							"description"       	=> __( "", "ts_visual_composer_extend" )
						),
					))
				);
			}
			// Add Navigation Container
			if (function_exists('vc_map')) {
				vc_map(array(
				    "name"                              => __("TS Figure Navigation", "ts_visual_composer_extend"),
				    "base"                              => "TS_VCSC_Figure_Navigation_Container",
				    "class"                             => "",
				    "icon"                              => "icon-wpb-ts_vcsc_figure_navigation_container",
				    "category"                          => __("VC Extensions", "ts_visual_composer_extend"),
				    "as_parent"                         => array('only' => 'TS_VCSC_Figure_Navigation_Item'),
				    "description"                       => __("Build a Figure Navigation Element", "ts_visual_composer_extend"),
					"controls" 							=> "full",
					"content_element"                   => true,
					"is_container" 						=> true,
					"container_not_allowed" 			=> false,
					"show_settings_on_create"           => true,
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
				    "params"                            => array(
						// Navigation Settings
						array(
							"type"						=> "seperator",
							"heading"					=> __( "", "ts_visual_composer_extend" ),
							"param_name"				=> "seperator_1",
							"value"						=> "",
							"seperator"					=> "Figure Navigation Settings",
							"description"				=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Handle Numbering", "ts_visual_composer_extend" ),
							"param_name"        		=> "numbering",
							"width"             		=> 300,
							"value"             		=> array(
								__( 'Auto Standard Number', "ts_visual_composer_extend" )		=> "number",
								__( 'Auto Roman Number', "ts_visual_composer_extend" )      	=> "roman",
								__( 'Auto Letter', "ts_visual_composer_extend" )      			=> "letter",
							),
							"admin_label"           	=> true,
							"description"       		=> __( "Select how the navigation items should be numbered if no custom value has been provided.", "ts_visual_composer_extend" ),
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Start of Auto Numbering", "ts_visual_composer_extend" ),
							"param_name"                => "start",
							"value"                     => "1",
							"min"                       => "1",
							"max"                       => "100",
							"step"                      => "1",
							"unit"                      => '',
							"admin_label"           	=> true,
							"description"               => __( "Define with which number the auto numbering should begin; treat letters as numbers.", "ts_visual_composer_extend" ),
							"dependency" 				=> ""
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Make Full Column Width", "ts_visual_composer_extend" ),
							"param_name"        		=> "width_full",
							"value"             		=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to make each navigation element the full width of its column.", "ts_visual_composer_extend" ),
							"dependency"				=> "",
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Min. Width per Item", "ts_visual_composer_extend" ),
							"param_name"                => "min_width",
							"value"                     => "250",
							"min"                       => "100",
							"max"                       => "2048",
							"step"                      => "1",
							"unit"                      => 'px',
							"admin_label"           	=> true,
							"description"               => __( "Define the minimum width for each individal navigation item.", "ts_visual_composer_extend" ),
							"dependency"				=> array( 'element' => "width_full", 'value' => "false" ),
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Trigger Type", "ts_visual_composer_extend" ),
							"param_name"        		=> "trigger",
							"width"             		=> 300,
							"value"             		=> array(
								__( 'Hover', "ts_visual_composer_extend" )					=> "hover",
								__( 'Click', "ts_visual_composer_extend" )      			=> "click",
							),
							"admin_label"           	=> true,
							"description"       		=> __( "Select by which trigger action the navigation items should be opened.", "ts_visual_composer_extend" ),
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Open Multiple", "ts_visual_composer_extend" ),
							"param_name"        		=> "multiple",
							"value"             		=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to allow that multiple items can be open at the same time.", "ts_visual_composer_extend" ),
							"dependency"				=> "",
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
	class WPBakeryShortCode_TS_VCSC_Figure_Navigation_Container extends WPBakeryShortCodesContainer {};
}
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_TS_VCSC_Figure_Navigation_Item extends WPBakeryShortCode {};
}
// Initialize "TS Figure Navigation" Class
if (class_exists('TS_Figure_Navigation')) {
	$TS_Figure_Navigation = new TS_Figure_Navigation;
}