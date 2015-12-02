<?php
if (!class_exists('TS_Teaser_Blocks')){
	class TS_Teaser_Blocks {
		function __construct() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				add_action('init',                              		array($this, 'TS_VCSC_Add_Teaser_Block_Elements'), 9999999);
			} else {
				add_action('admin_init',		                		array($this, 'TS_VCSC_Add_Teaser_Block_Elements'), 9999999);
			}
			add_shortcode('TS_VCSC_Teaser_Block_Standalone',          	array($this, 'TS_VCSC_Teaser_Block_Standalone'));
			add_shortcode('TS_VCSC_Teaser_Block_Single',              	array($this, 'TS_VCSC_Teaser_Block_Single'));
			add_shortcode('TS_VCSC_Teaser_Block_Slider_Custom',       	array($this, 'TS_VCSC_Teaser_Block_Slider_Custom'));
		}
        
		// Standalone Teaser Block
		function TS_VCSC_Teaser_Block_Standalone ($atts) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();

			wp_enqueue_style('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-front');
		
			extract( shortcode_atts( array(
				'teaser_graphic'				=> 'true',
				'image'							=> '',
				'image_responsive'				=> 'true',
				'image_width'					=> 300,
				'image_height'					=> 200,
				'attribute_alt'					=> 'false',
				'attribute_alt_value'			=> '',
				'overlay'						=> '#0094FF',
				'color_background'				=> '#ffffff',
				'color_separator'				=> '#049cdb',
				'color_title'					=> '#a2a2a2',
				'color_subtitle'				=> '#aaaaaa',
				'title'							=> '',
				'info_position'					=> 'bottom',
				'icon_position'					=> '',
				'icon'							=> '',
				'icon_size'						=> 18,
				'icon_color'					=> '#aaaaaa',
				'subtitle'						=> '',
				'link'							=> '',
				'button_type'					=> '',
				'button_square'					=> 'ts-button-3d',
				'button_rounded'				=> 'ts-button-3d ts-button-rounded',
				'button_pill'					=> 'ts-button-3d ts-button-pill',
				'button_circle'					=> 'ts-button-3d ts-button-circle',
				'button_flat'					=> 'ts-dual-buttons-sun-flower',
				'button_hover'					=> 'ts-dual-buttons-preview-default ts-dual-buttons-hover-default',
				'button_wrapper'				=> 'false',
				'button_text'					=> 'Read More',
				'button_font'					=> 14,
				'font_title_family'				=> 'Default',
				'font_title_type'				=> '',
				'font_title_size'				=> 18,
				'font_content_family'			=> 'Default',
				'font_content_type'				=> '',
				'font_content_size'				=> 14,
				'font_button_family'			=> 'Default',
				'font_button_type'				=> '',
				'margin_top'                    => 0,
				'margin_bottom'                 => 0,				
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			), $atts ));
	
			if (($button_type != '') && ($button_type != 'flat')) {
				wp_enqueue_style('ts-extend-buttons');
			} else if (($button_type != '') && ($button_type == 'flat')) {
				wp_enqueue_style('ts-extend-buttonsdual');
			}
	
			if (!empty($el_id)) {
				$image_teaser_id				= $el_id;
			} else {
				$image_teaser_id				= 'ts-vcsc-image-teaser-' . mt_rand(999999, 9999999);
			}
			
			// Teaser Link
			$link 								= ($link=='||') ? '' : $link;
			$link 								= vc_build_link($link);
			$a_href								= $link['url'];
			$a_title 							= $link['title'];
			$a_target 							= $link['target'];
	
			// Teaser Image
			if ($teaser_graphic == 'false') {
				$info_position					= "top";
				$alt_attribute					= "";
			} else {
				if ($image_responsive == "true") {
					$teaser_image				= wp_get_attachment_image_src($image, 'full');
				} else {
					$teaser_image				= wp_get_attachment_image_src($image, array($image_width, $image_height));
				}
				if ($teaser_image == false) {
					$teaser_image				= TS_VCSC_GetResourceURL('images/defaults/no_image.jpg');
				} else {
					$teaser_image				= $teaser_image[0];
				}
				$image_extension 				= pathinfo($teaser_image, PATHINFO_EXTENSION);
				if ($attribute_alt == "true") {
					$alt_attribute				= $attribute_alt_value;
				} else {
					$alt_attribute				= basename($teaser_image, "." . $image_extension);
				}
			}
			
			// Teaser Button Type
			if ($button_type == "square") {
				$button_style				= 'ts-button ' . $button_square;
				$button_font				= '';
				$button_padding				= '';
			} else if ($button_type == "rounded") {
				$button_style				= 'ts-button ' . $button_rounded;
				$button_font				= '';
				$button_padding				= '';
			} else if ($button_type == "pill"){
				$button_style				= 'ts-button ' . $button_pill;
				$button_font				= '';
				$button_padding				= '';
			} else if ($button_type == "circle") {
				$button_style				= 'ts-button ' . $button_circle;
				$button_font				= 'font-size: ' . $button_font . 'px;';
				$button_padding				= '';
			} else if ($button_type == "flat"){
				$button_flat				= str_replace("ts-color-button", "ts-dual-buttons", $button_flat);
				$button_style				= $button_flat . ' ' . $button_hover;
				$button_font				= 'font-size: ' . $button_font . 'px;';
				$button_padding				= 'padding: 10px 5px;';
			} else {
				$button_style				= '';
				$button_font				= '';
				$button_padding				= '';
			}
			
			// Teaser Icon Settings
			if ((!empty($icon)) && ($icon != "transparent") && ($icon_position != "")) {
				$icon_style                 = 'color: ' . $icon_color . '; width:' . $icon_size . 'px; height:' . $icon_size . 'px; font-size:' . $icon_size . 'px; line-height:' . $icon_size . 'px;';
			} else {
				$icon_style					= '';
			}
			
			// Custom Font Settings		
			if (strpos($font_title_family, 'Default') === false) {
				$google_font_title			= TS_VCSC_GetFontFamily($image_teaser_id . " .ts-teaser-title", $font_title_family, $font_title_type, false, true, false);
			} else {
				$google_font_title			= '';
			}
			if (strpos($font_content_family, 'Default') === false) {
				$google_font_content		= TS_VCSC_GetFontFamily($image_teaser_id . " .ts-teaser-text", $font_content_family, $font_content_type, false, true, false);
			} else {
				$google_font_content		= '';
			}
			if (strpos($font_button_family, 'Default') === false) {
				$google_font_button			= TS_VCSC_GetFontFamily($image_teaser_id . " .ts-readmore", $font_button_family, $font_button_type, false, true, false);
			} else {
				$google_font_button			= '';
			}
			
			$output = '';
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-teaser ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Teaser_Block_Standalone', $atts);
			} else {
				$css_class	= 'ts-teaser ' . $el_class;
			}
			
			$output .= '<div id="' . $image_teaser_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
				$output .= '<div class="ts-teaser-item" style="background: ' . $color_background . ';">';
					$output .= '<div class="ts-teaser-padding">';
						if ($info_position == "top") {
							$output .= '<div class="ts-teaser-head">';
								$output .= '<h2 class="ts-teaser-title" style="' . ($teaser_graphic == 'false' ? 'padding-top: 20px;' : '') . ' border-top: none; margin-top: 0; font-size: ' . $font_title_size . 'px; background: ' . $color_background . '; ' . $google_font_title . '">';
									if ((!empty($icon)) && ($icon != "transparent") && ($icon_position == "top")) {
										$output .= '<span style="display: block; width: 100%; text-align: center; margin-top: 0px; margin-bottom: 10px;"><i style="' . $icon_style . '" class="' . $icon . '"></i></span>';
									} else if ((!empty($icon)) && ($icon != "transparent") && ($icon_position == "left")) {
										$output .= '<i style="margin-right: 5px; ' . $icon_style . '" class="' . $icon . '"></i>';
									}
									$output .= '<a href="' . $a_href . '" target="' . $a_target . '" style=" color: ' . $color_title . ';">' . $title . '</a>';
									if ((!empty($icon)) && ($icon != "transparent") && ($icon_position == "right")) {
										$output .= '<i style="margin-left: 5px; ' . $icon_style . '" class="' . $icon . '"></i>';
									} else if ((!empty($icon)) && ($icon != "transparent") && ($icon_position == "bottom")) {
										$output .= '<span style="display: block; width: 100%; text-align: center; margin-top: 10px; margin-bottom: 0px;"><i style="' . $icon_style . '" class="' . $icon . '"></i></span>';
									}
								$output .= '</h2>';
							$output .= '</div>';
							$output .= '<div class="ts-teaser-seperator" style="background: ' . $color_separator . ';"></div>';
							$output .= '<div class="ts-teaser-text" style="font-size: ' . $font_content_size . 'px; color: ' . $color_subtitle . '; ' . $google_font_content . '">';
								$output .= $subtitle;
							$output .= '</div>';
						}
						if ($teaser_graphic == 'true') {
							if ($info_position == "top") {
								$output .= '<div class="ts-teaser-image-container" style="border-top: 1px solid #dddddd">';
							} else {
								$output .= '<div class="ts-teaser-image-container">';
							}
								$output .= '<a href="' . $a_href . '" target="' . $a_target . '">';
									if ($info_position == "bottom") {
										$output .= '<img src="' . $teaser_image . '" alt="' . $alt_attribute . '" class="ts-teaser-image" style="">';
									} else {
										$output .= '<img src="' . $teaser_image . '" alt="' . $alt_attribute . '" class="ts-teaser-image" style="margin-bottom: -7px;">';
									}
									$output .= '<span class="ts-teaser-hovercontent" style="background-color: ' . $overlay . ';"></span>';
									$output .= '<span class="ts-teaser-hoverimage"></span>';
								$output .= '</a>';
							$output .= '</div>';
						}
						if ($info_position == "bottom") {
							$output .= '<div class="ts-teaser-head">';
								$output .= '<h2 class="ts-teaser-title" style="font-size: ' . $font_title_size . 'px; background: ' . $color_background . '; ' . $google_font_title . '">';
									if ((!empty($icon)) && ($icon != "transparent") && ($icon_position == "top")) {
										$output .= '<span style="display: block; width: 100%; text-align: center; margin-top: 0px; margin-bottom: 10px;"><i style="' . $icon_style . '" class="' . $icon . '"></i></span>';
									} else if ((!empty($icon)) && ($icon != "transparent") && ($icon_position == "left")) {
										$output .= '<i style="margin-right: 5px; ' . $icon_style . '" class="' . $icon . '"></i>';
									}
									$output .= '<a href="' . $a_href . '" target="' . $a_target . '" style=" color: ' . $color_title . ';">' . $title . '</a>';
									if ((!empty($icon)) && ($icon != "transparent") && ($icon_position == "right")) {
										$output .= '<i style="margin-left: 5px; ' . $icon_style . '" class="' . $icon . '"></i>';
									} else if ((!empty($icon)) && ($icon != "transparent") && ($icon_position == "bottom")) {
										$output .= '<span style="display: block; width: 100%; text-align: center; margin-top: 10px; margin-bottom: 0px;"><i style="' . $icon_style . '" class="' . $icon . '"></i></span>';
									}
								$output .= '</h2>';
							$output .= '</div>';
							$output .= '<div class="ts-teaser-seperator" style="background: ' . $color_separator . ';"></div>';
							$output .= '<div class="ts-teaser-text" style="font-size: ' . $font_content_size . 'px; color: ' . $color_subtitle . '; ' . $google_font_content . '">';
								$output .= $subtitle;
							$output .= '</div>';
						}
						if ($button_type != "") {
							if($button_wrapper == "true") {
								$output .= '<div class="ts-readmore-wrap"><span class="ts-button-wrap" style="width: 75%;">';
							}
							$output .= '<a href="' . $a_href . '" target="' . trim($a_target) . '" class="ts-readmore ' . $button_style . '" style="' . $button_font . ' ' . $button_padding . ' ' . $google_font_button . '"><span>' . $button_text . '</span></a>';
							if($button_wrapper == "true") {
								$output .= '</span></div>';
							}
						}
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
	
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
		
		// Single Teaser Block for Custom Slider
		function TS_VCSC_Teaser_Block_Single ($atts) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();

			wp_enqueue_style('ts-extend-simptip');
			wp_enqueue_style('ts-extend-animations');
			wp_enqueue_style('ts-extend-buttons');
			wp_enqueue_style('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-front');
		
			extract( shortcode_atts( array(
				'teaser_graphic'				=> 'true',
				'image'							=> '',
				'image_responsive'				=> 'true',
				'image_width'					=> 300,
				'image_height'					=> 200,
				'attribute_alt'					=> 'false',
				'attribute_alt_value'			=> '',
				'overlay'						=> '#0094FF',
				'color_background'				=> '#ffffff',
				'color_separator'				=> '#049cdb',
				'color_title'					=> '#a2a2a2',
				'color_subtitle'				=> '#aaaaaa',
				'title'							=> '',
				'info_position'					=> 'bottom',
				'icon_position'					=> '',
				'icon'							=> '',
				'icon_size'						=> 18,
				'icon_color'					=> '#aaaaaa',
				'subtitle'						=> '',
				'link'							=> '',
				'button_type'					=> '',
				'button_square'					=> 'ts-button-3d',
				'button_rounded'				=> 'ts-button-3d ts-button-rounded',
				'button_pill'					=> 'ts-button-3d ts-button-pill',
				'button_circle'					=> 'ts-button-3d ts-button-circle',
				'button_flat'					=> 'ts-dual-buttons-sun-flower',
				'button_hover'					=> 'ts-dual-buttons-preview-default ts-dual-buttons-hover-default',
				'button_wrapper'				=> 'false',
				'button_text'					=> 'Read More',
				'button_font'					=> 14,
				'font_title_family'				=> 'Default',
				'font_title_type'				=> '',
				'font_title_size'				=> 18,
				'font_content_family'			=> 'Default',
				'font_content_type'				=> '',
				'font_content_size'				=> 14,
				'font_button_family'			=> 'Default',
				'font_button_type'				=> '',
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			), $atts ));
			
			$image_teaser_id					= 'ts-vcsc-image-teaser-' . mt_rand(999999, 9999999);
			
			// Teaser Link
			$link 								= ($link=='||') ? '' : $link;
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
	
			
			// Teaser Image
			if ($teaser_graphic == 'false') {
				$info_position					= "top";
				$alt_attribute					= "";
			} else {
				if ($image_responsive == "true") {
					$teaser_image				= wp_get_attachment_image_src($image, 'full');
				} else {
					$teaser_image				= wp_get_attachment_image_src($image, array($image_width, $image_height));
				}
				if ($teaser_image == false) {
					$teaser_image				= TS_VCSC_GetResourceURL('images/defaults/no_image.jpg');
				} else {
					$teaser_image				= $teaser_image[0];
				}
				$image_extension 				= pathinfo($teaser_image, PATHINFO_EXTENSION);
				if ($attribute_alt == "true") {
					$alt_attribute				= $attribute_alt_value;
				} else {
					$alt_attribute				= basename($teaser_image, "." . $image_extension);
				}
			}
			
			// Teaser Button Type
			if ($button_type == "square") {
				$button_style				= 'ts-button ' . $button_square;
				$button_font				= '';
				$button_padding				= '';
			} else if ($button_type == "rounded") {
				$button_style				= 'ts-button ' . $button_rounded;
				$button_font				= '';
				$button_padding				= '';
			} else if ($button_type == "pill"){
				$button_style				= 'ts-button ' . $button_pill;
				$button_font				= '';
				$button_padding				= '';
			} else if ($button_type == "circle") {
				$button_style				= 'ts-button ' . $button_circle;
				$button_font				= 'font-size: ' . $button_font . 'px;';
				$button_padding				= '';
			} else if ($button_type == "flat"){
				$button_flat				= str_replace("ts-color-button", "ts-dual-buttons", $button_flat);
				$button_style				= $button_flat . ' ' . $button_hover;
				$button_font				= 'font-size: ' . $button_font . 'px;';
				$button_padding				= 'padding: 10px 5px;';
			} else {
				$button_style				= '';
				$button_font				= '';
				$button_padding				= '';
			}
			
			// Teaser Icon Settings
			if ((!empty($icon)) && ($icon != "transparent") && ($icon_position != "")) {
				$icon_style                 = 'color: ' . $icon_color . '; width:' . $icon_size . 'px; height:' . $icon_size . 'px; font-size:' . $icon_size . 'px; line-height:' . $icon_size . 'px;';
			} else {
				$icon_style					= '';
			}
			
			// Custom Font Settings		
			if (strpos($font_title_family, 'Default') === false) {
				$google_font_title			= TS_VCSC_GetFontFamily($image_teaser_id . " .ts-teaser-title", $font_title_family, $font_title_type, false, true, false);
			} else {
				$google_font_title			= '';
			}
			if (strpos($font_content_family, 'Default') === false) {
				$google_font_content		= TS_VCSC_GetFontFamily($image_teaser_id . " .ts-teaser-text", $font_content_family, $font_content_type, false, true, false);
			} else {
				$google_font_content		= '';
			}
			if (strpos($font_button_family, 'Default') === false) {
				$google_font_button			= TS_VCSC_GetFontFamily($image_teaser_id . " .ts-readmore", $font_button_family, $font_button_type, false, true, false);
			} else {
				$google_font_button			= '';
			}
			
			$output = '';
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-teaser ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Teaser_Block_Single', $atts);
			} else {
				$css_class	= 'ts-teaser ' . $el_class;
			}
			
			$output .= '<div id="' . $image_teaser_id . '" class="' . $css_class . '" style="width: 100%; margin: 0px auto; padding: 0px;">';
				$output .= '<div class="ts-teaser-item" style="background: ' . $color_background . ';">';
					$output .= '<div class="ts-teaser-padding">';
						if ($info_position == "top") {
							$output .= '<div class="ts-teaser-head">';
								$output .= '<h2 class="ts-teaser-title" style="' . ($teaser_graphic == 'false' ? 'padding-top: 20px;' : '') . ' border-top: none; margin-top: 0; font-size: ' . $font_title_size . 'px; background: ' . $color_background . '; ' . $google_font_title . '">';
									if ((!empty($icon)) && ($icon != "transparent") && ($icon_position == "top")) {
										$output .= '<span style="display: block; width: 100%; text-align: center; margin-top: 0px; margin-bottom: 10px;"><i style="' . $icon_style . '" class="' . $icon . '"></i></span>';
									} else if ((!empty($icon)) && ($icon != "transparent") && ($icon_position == "left")) {
										$output .= '<i style="margin-right: 5px; ' . $icon_style . '" class="' . $icon . '"></i>';
									}
									$output .= '<a href="' . $a_href . '" target="' . $a_target . '" style=" color: ' . $color_title . ';">' . $title . '</a>';
									if ((!empty($icon)) && ($icon != "transparent") && ($icon_position == "right")) {
										$output .= '<i style="margin-left: 5px; ' . $icon_style . '" class="' . $icon . '"></i>';
									} else if ((!empty($icon)) && ($icon != "transparent") && ($icon_position == "bottom")) {
										$output .= '<span style="display: block; width: 100%; text-align: center; margin-top: 10px; margin-bottom: 0px;"><i style="' . $icon_style . '" class="' . $icon . '"></i></span>';
									}
								$output .= '</h2>';
							$output .= '</div>';
							$output .= '<div class="ts-teaser-seperator" style="background: ' . $color_separator . ';"></div>';
							$output .= '<div class="ts-teaser-text" style="font-size: ' . $font_content_size . 'px; color: ' . $color_subtitle . '; ' . $google_font_content . '">';
								$output .= $subtitle;
							$output .= '</div>';
						}
						if ($teaser_graphic == 'true') {
							if ($info_position == "top") {
								$output .= '<div class="ts-teaser-image-container" style="border-top: 1px solid #dddddd;">';
							} else {
								$output .= '<div class="ts-teaser-image-container">';
							}
								$output .= '<a href="' . $a_href . '" target="' . $a_target . '">';
									if ($info_position == "bottom") {
										$output .= '<img src="' . $teaser_image . '" alt="' . $alt_attribute . '" class="ts-teaser-image" style="">';
									} else {
										$output .= '<img src="' . $teaser_image . '" alt="' . $alt_attribute . '" class="ts-teaser-image" style="margin-bottom: -7px;">';
									}
									$output .= '<span class="ts-teaser-hovercontent" style="background-color: ' . $overlay . '"></span>';
									$output .= '<span class="ts-teaser-hoverimage"></span>';
								$output .= '</a>';
							$output .= '</div>';
						}
						if ($info_position == "bottom") {
							$output .= '<div class="ts-teaser-head">';
								$output .= '<h2 class="ts-teaser-title" style="font-size: ' . $font_title_size . 'px; background: ' . $color_background . '; ' . $google_font_title . '">';
									if ((!empty($icon)) && ($icon != "transparent") && ($icon_position == "top")) {
										$output .= '<span style="display: block; width: 100%; text-align: center; margin-top: 0px; margin-bottom: 10px;"><i style="' . $icon_style . '" class="' . $icon . '"></i></span>';
									} else if ((!empty($icon)) && ($icon != "transparent") && ($icon_position == "left")) {
										$output .= '<i style="margin-right: 5px; ' . $icon_style . '" class="' . $icon . '"></i>';
									}
									$output .= '<a href="' . $a_href . '" target="' . $a_target . '" style=" color: ' . $color_title . ';">' . $title . '</a>';
									if ((!empty($icon)) && ($icon != "transparent") && ($icon_position == "right")) {
										$output .= '<i style="margin-left: 5px; ' . $icon_style . '" class="' . $icon . '"></i>';
									} else if ((!empty($icon)) && ($icon != "transparent") && ($icon_position == "bottom")) {
										$output .= '<span style="display: block; width: 100%; text-align: center; margin-top: 10px; margin-bottom: 0px;"><i style="' . $icon_style . '" class="' . $icon . '"></i></span>';
									}
								$output .= '</h2>';
							$output .= '</div>';
							$output .= '<div class="ts-teaser-seperator" style="background: ' . $color_separator . ';"></div>';
							$output .= '<div class="ts-teaser-text" style="font-size: ' . $font_content_size . 'px; color: ' . $color_subtitle . '; ' . $google_font_content . '">';
								$output .= $subtitle;
							$output .= '</div>';
						}
						if ($button_type != "") {
							if($button_wrapper == "true") {
								$output .= '<div class="ts-readmore-wrap"><span class="ts-button-wrap" style="width: 75%;">';
							}
							$output .= '<a href="' . $a_href . '" target="' . trim($a_target) . '" class="ts-readmore ' . $button_style . '" style="' . $button_font . ' ' . $button_padding . ' ' . $google_font_button . '"><span>' . $button_text . '</span></a>';
							if ($button_wrapper == "true") {
								$output .= '</span></div>';
							}
						}
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
	
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
		
		// Custom Teaser Block Slider
		function TS_VCSC_Teaser_Block_Slider_Custom ($atts, $content = null){
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();
	
            wp_enqueue_style('ts-extend-owlcarousel2');
            wp_enqueue_script('ts-extend-owlcarousel2');
			wp_enqueue_style('ts-font-ecommerce');
			wp_enqueue_style('ts-extend-buttons');
			wp_enqueue_style('ts-extend-buttonsdual');
			wp_enqueue_style('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-front');
			
			extract( shortcode_atts( array(
				'number_teasers'				=> 1,
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
				$slider_message					= '<div class="ts-composer-frontedit-message">' . __( 'The slider is currently viewed in front-end edit mode; slider features are disabled for performance and compatibility reasons.', "ts_visual_composer_extend" ) . '</div>';
				$product_style					= 'width: ' . (100 / $number_teasers) . '%; height: 100%; float: left; margin: 0; padding: 0;';
				$frontend_edit					= 'true';
			} else {
				$slider_class					= 'ts-owlslider-parent owl-carousel2';
				$slider_message					= '';
				$product_style					= '';
				$frontend_edit					= 'false';
			}
			
			if (!empty($el_id)) {
				$teaser_slider_id			    = $el_id;
			} else {
				$teaser_slider_id			    = 'ts-vcsc-image-teaser-slider-' . $teaser_random;
			}
			
			$output = '';
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-teaser-block-slider ' . $slider_class . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Teaser_Block_Slider_Custom', $atts);
			} else {
				$css_class	= 'ts-teaser-block-slider ' . $slider_class . ' ' . $el_class;
			}
			
			$output .= '<div id="' . $teaser_slider_id . '-container" class="ts-teaser-block-slider-container" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
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
				$output .= '<div id="' . $teaser_slider_id . '" class="' . $css_class . '" data-id="' . $teaser_random . '" data-items="' . $number_teasers . '" data-rtl="' . $page_rtl . '" data-loop="' . $items_loop . '" data-navigation="' . $show_navigation . '" data-dots="' . $show_dots . '" data-mobile="' . $animation_mobile . '" data-animationin="' . $animation_in . '" data-animationout="' . $animation_out . '" data-height="' . $auto_height . '" data-play="' . $auto_play . '" data-bar="' . $show_bar . '" data-color="' . $bar_color . '" data-speed="' . $show_speed . '" data-hover="' . $stop_hover . '">';
					$output .= do_shortcode($content);
				$output .= '</div>';
			$output .= '</div>';
			
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
	
	
		// Add Teaser Block Elements
        function TS_VCSC_Add_Teaser_Block_Elements() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			// Add Standalone Teaser Block
			if (function_exists('vc_map')) {
				vc_map( array(
					"name"                      	=> __( "TS Single Teaser Block", "ts_visual_composer_extend" ),
					"base"                      	=> "TS_VCSC_Teaser_Block_Standalone",
					"icon" 	                    	=> "icon-wpb-ts_vcsc_teaser_block_standalone",
					"class"                     	=> "ts_vcsc_main_teaser_block",
					"category"                  	=> __( 'VC Extensions', "ts_visual_composer_extend" ),
					"description"               	=> __("Place a teaser block element", "ts_visual_composer_extend"),
					"js_view"     					=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorLivePreview == "true" ? "TS_VCSC_TeaserBlockViewCustom" : ""),
					"admin_enqueue_js"            	=> "",
					"admin_enqueue_css"           	=> "",
					"params"                    	=> array(
						// Teaser Settings
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_1",
							"value"					=> "",
							"seperator"				=> "Teaser Content",
							"description"       	=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"                  => "switch_button",
							"heading"			    => __( "Teaser Block Image", "ts_visual_composer_extend" ),
							"param_name"		    => "teaser_graphic",
							"value"                 => "true",
							"on"				    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"				    => __( 'No', "ts_visual_composer_extend" ),
							"style"				    => "select",
							"design"			    => "toggle-light",
							"admin_label"           => true,
							"description"		    => __( "Switch the toggle if you want to use an image to further highlight the teaser block.", "ts_visual_composer_extend" ),
						),
						array(
							"type"                  => "attach_image",
							"holder" 				=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? "img" : ""),
							"heading"               => __( "Image", "ts_visual_composer_extend" ),
							"param_name"            => "image",
							"class"					=> "ts_vcsc_holder_image",
							"value"                 => "",
							"admin_label"           => ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? false : true),
							"dependency"		    => array( 'element' => "teaser_graphic", 'value' => 'true' ),
							"description"           => __( "Select the image you want to use for the teaser.", "ts_visual_composer_extend" )
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Overlay Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "overlay",
							"value"             	=> "#0094FF",
							"description"       	=> __( "Define the hover overlay color for the teaser image.", "ts_visual_composer_extend" ),
							"dependency"		    => array( 'element' => "teaser_graphic", 'value' => 'true' ),
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Background Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "color_background",
							"value"             	=> "#ffffff",
							"description"       	=> __( "Define the background color for the teaser block.", "ts_visual_composer_extend" ),
							"dependency"        	=> ""
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Separator Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "color_separator",
							"value"             	=> "#049cdb",
							"description"       	=> __( "Define the color for the teaser separator.", "ts_visual_composer_extend" ),
							"dependency"        	=> ""
						),
						array(
							"type" 					=> "vc_link",
							"heading" 				=> __("Link", "ts_visual_composer_extend"),
							"param_name" 			=> "link",
							"description" 			=> __("Provide a link to another site/page for the Image Teaser.", "ts_visual_composer_extend")
						),
						// Teaser Header
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_2",
							"value"					=> "",
							"seperator"				=> "Teaser Header",
							"description"       	=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"              	=> "dropdown",
							"heading"           	=> __( "Header Position", "ts_visual_composer_extend" ),
							"param_name"        	=> "info_position",
							"width"             	=> 300,
							"value"             	=> array(								
								__( 'Bottom', "ts_visual_composer_extend" )		=> "bottom",
								__( 'Top', "ts_visual_composer_extend" )      	=> "top",
							),
							"admin_label"           => true,
							"dependency"		    => array( 'element' => "teaser_graphic", 'value' => 'true' ),
							"description"       	=> __( "Select where the header (title + description) should be shown in relation to the teaser image.", "ts_visual_composer_extend" ),
						),
						array(
							"type"              	=> "textfield",
							"heading"           	=> __( "Header", "ts_visual_composer_extend" ),
							"param_name"        	=> "title",
							"class"					=> "ts_vcsc_holder_text_main",
							"value"             	=> "",
							"admin_label"           => true,
							"description"       	=> __( "Enter a title for the image teaser.", "ts_visual_composer_extend" )
						),						
						array(
							"type"					=> "fontsmanager",
							"heading"				=> __( "Font Family", "ts_visual_composer_extend" ),
							"param_name"			=> "font_title_family",
							"value"					=> "",
							"default"				=> "true",
							"connector"				=> "font_title_type",
							"description"			=> __( "Select the font to be used for the title text.", "ts_visual_composer_extend" ),
						),
						array(
							"type"					=> "hidden_input",
							"param_name"			=> "font_title_type",
							"value"					=> "",
							"description"			=> __( "", "ts_visual_composer_extend" ),
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Header Font Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "color_title",
							"value"             	=> "#a2a2a2",
							"description"       	=> __( "Define the font color for the teaser title.", "ts_visual_composer_extend" ),
							"dependency"        	=> ""
						),
						array(
							"type"                  => "nouislider",
							"heading"               => __( "Header Font Size", "ts_visual_composer_extend" ),
							"param_name"            => "font_title_size",
							"value"                 => "18",
							"min"                   => "10",
							"max"                   => "100",
							"step"                  => "1",
							"unit"                  => 'px',
							"description"       	=> __( "Define the font size for the teaser header.", "ts_visual_composer_extend" ),
						),
						// Teaser Message
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_3",
							"value"					=> "",
							"seperator"				=> "Teaser Message",
							"description"       	=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"              	=> "textfield",
							"heading"           	=> __( "Description", "ts_visual_composer_extend" ),
							"param_name"        	=> "subtitle",
							"class"					=> "ts_vcsc_holder_text_sub",
							"value"             	=> "",
							"admin_label"           => true,
							"description"       	=> __( "Enter a short description for the image teaser.", "ts_visual_composer_extend" )
						),
						array(
							"type"					=> "fontsmanager",
							"heading"				=> __( "Font Family", "ts_visual_composer_extend" ),
							"param_name"			=> "font_content_family",
							"value"					=> "",
							"default"				=> "true",
							"connector"				=> "font_content_type",
							"description"			=> __( "Select the font to be used for the description text.", "ts_visual_composer_extend" ),
						),
						array(
							"type"					=> "hidden_input",
							"param_name"			=> "font_content_type",
							"value"					=> "",
							"description"			=> __( "", "ts_visual_composer_extend" ),
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Message Font Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "color_subtitle",
							"value"             	=> "#aaaaaa",
							"description"       	=> __( "Define the font color for the teaser message.", "ts_visual_composer_extend" ),
							"dependency"        	=> ""
						),
						array(
							"type"                  => "nouislider",
							"heading"               => __( "Message Font Size", "ts_visual_composer_extend" ),
							"param_name"            => "font_content_size",
							"value"                 => "14",
							"min"                   => "10",
							"max"                   => "100",
							"step"                  => "1",
							"unit"                  => 'px',
							"description"       	=> __( "Define the font size for the teaser message.", "ts_visual_composer_extend" ),
						),
						// Icon Settings
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_4",
							"value"					=> "",
							"seperator"				=> "Icon Settings",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"group" 				=> "Icon Settings",
						),
						array(
							"type"              	=> "dropdown",
							"heading"           	=> __( "Icon Position", "ts_visual_composer_extend" ),
							"param_name"        	=> "icon_position",
							"width"             	=> 300,
							"value"             	=> array(
								__( 'No Icon', "ts_visual_composer_extend" )      	=> "",
								__( 'Left Icon', "ts_visual_composer_extend" )		=> "left",
								__( 'Right Icon', "ts_visual_composer_extend" )		=> "right",
								__( 'Top Icon', "ts_visual_composer_extend" )			=> "top",
								__( 'Bottom Icon', "ts_visual_composer_extend" )		=> "bottom",
							),
							"description"       	=> __( "Select if and where an icon should be shown in the teaser title.", "ts_visual_composer_extend" ),
							"group" 				=> "Icon Settings",
						),				
						array(
							'type' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
							'heading' 				=> __( 'Title Icon', 'ts_visual_composer_extend' ),
							'param_name' 			=> 'icon',
							'value'					=> '',
							'source'				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorValue,
							'settings' 				=> array(
								'emptyIcon' 				=> false,
								'type' 						=> 'extensions',
								'iconsPerPage' 				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
								'source' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorSource,
							),
							"admin_label"       	=> true,
							"description"       	=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon you want to display in the teaser title.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
							"dependency"			=> array( 'element' => "icon_position", 'value' => array('left', 'right', 'top', 'bottom') ),
							"group" 				=> "Icon Settings",
						),						
						array(
							"type"                  => "nouislider",
							"heading"               => __( "Icon Size", "ts_visual_composer_extend" ),
							"param_name"            => "icon_size",
							"value"                 => "18",
							"min"                   => "4",
							"max"                   => "256",
							"step"                  => "1",
							"unit"                  => 'px',
							"description"       	=> __( "Define the size for the icon in the image teaser.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "icon_position", 'value' => array('left', 'right', 'top', 'bottom') ),
							"group" 				=> "Icon Settings",
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Icon Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "icon_color",
							"value"             	=> "#aaaaaa",
							"description"       	=> __( "Define the color of the icon for the image teaser.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "icon_position", 'value' => array('left', 'right', 'top', 'bottom') ),
							"group" 				=> "Icon Settings",
						),
						// Button Settings
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_5",
							"value"					=> "",
							"seperator"				=> "Button Settings",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"group" 				=> "Link Button",
						),
						array(
							"type"              	=> "dropdown",
							"heading"           	=> __( "Button Type", "ts_visual_composer_extend" ),
							"param_name"        	=> "button_type",
							"width"             	=> 300,
							"value"             	=> array(
								__( 'None', "ts_visual_composer_extend" )      		=> "",
								__( '3D Square', "ts_visual_composer_extend" )		=> "square",
								__( '3D Rounded', "ts_visual_composer_extend" )		=> "rounded",
								__( '3D Pill', "ts_visual_composer_extend" )		=> "pill",
								__( '3D Circle', "ts_visual_composer_extend" )		=> "circle",
								__( 'Flat Button', "ts_visual_composer_extend" )	=> "flat",
							),
							"admin_label"           => true,
							"description"       	=> __( "Select if and what type of link button should be shown.", "ts_visual_composer_extend" ),
							"group" 				=> "Link Button",
						),
						array(
							"type"                  => "dropdown",
							"heading"               => __( "Button Style", "ts_visual_composer_extend" ),
							"param_name"            => "button_square",
							"width"                 => 300,
							"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Button_Square,
							"description"           => __( "Select the actual button style for the 'Read More' Link.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => 'square' ),
							"group" 				=> "Link Button",
						),
						array(
							"type"                  => "dropdown",
							"heading"               => __( "Button Style", "ts_visual_composer_extend" ),
							"param_name"            => "button_rounded",
							"width"                 => 300,
							"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Button_Rounded,
							"description"           => __( "Select the actual button style for the 'Read More' Link.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => 'rounded' ),
							"group" 				=> "Link Button",
						),
						array(
							"type"                  => "dropdown",
							"heading"               => __( "Button Style", "ts_visual_composer_extend" ),
							"param_name"            => "button_pill",
							"width"                 => 300,
							"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Button_Pill,
							"description"           => __( "Select the actual button style for the 'Read More' Link.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => 'pill' ),
							"group" 				=> "Link Button",
						),
						array(
							"type"                  => "dropdown",
							"heading"               => __( "Button Style", "ts_visual_composer_extend" ),
							"param_name"            => "button_circle",
							"width"                 => 300,
							"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Button_Circle,
							"description"           => __( "Select the actual button style for the 'Read More' Link.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => 'circle' ),
							"group" 				=> "Link Button",
						),
						array(
							"type"                  => "dropdown",
							"heading"               => __( "Button Style", "ts_visual_composer_extend" ),
							"param_name"            => "button_flat",
							"width"                 => 150,
							"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Default_Colors,
							"description"           => __( "Select the color scheme for the link button.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => 'flat' ),
							"group" 				=> "Link Button",
						),						
						array(
							"type"                  => "dropdown",
							"heading"               => __( "Button Hover Style", "ts_visual_composer_extend" ),
							"param_name"            => "button_hover",
							"width"                 => 150,
							"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Hover_Colors,
							"description"           => __( "Select the hover color scheme for the link button.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => 'flat' ),
							"group" 				=> "Link Button",
						),						
						array(
							"type"              	=> "dropdown",
							"heading"           	=> __( "Button Size", "ts_visual_composer_extend" ),
							"param_name"        	=> "button_size",
							"width"             	=> 300,
							"value"             	=> array(
								__( 'Normal', "ts_visual_composer_extend" )			=> "ts-button-normal",
								__( 'Small', "ts_visual_composer_extend" )      	=> "ts-button-small",
								__( 'Tiny', "ts_visual_composer_extend" )  			=> "ts-button-tiny",
								__( 'Large', "ts_visual_composer_extend" )  		=> "ts-button-large",
								__( 'Jumbo', "ts_visual_composer_extend" )  		=> "ts-button-jumbo",
							),
							"description"       	=> __( "Select the size for the icon button.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => array('square', 'rounded', 'pill') ),
							"group" 				=> "Link Button",
						),
						array(
							"type"					=> "switch_button",
							"heading"           	=> __( "Add Button Wrapper", "ts_visual_composer_extend" ),
							"param_name"        	=> "button_wrapper",
							"value"             	=> "false",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"description"       	=> __( "Switch the toggle to add a wrapper frame around the 'Read More' button (most suited for 'pill' and 'circle' buttons).", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => array('square', 'rounded', 'pill', 'circle') ),
							"group" 				=> "Link Button",
						),
						array(
							"type"              	=> "textfield",
							"heading"           	=> __( "Button Text", "ts_visual_composer_extend" ),
							"param_name"        	=> "button_text",
							"value"             	=> "Read More",
							"description"       	=> __( "Enter a text for the 'Read More' button.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => array('square', 'rounded', 'pill', 'circle', 'flat') ),
							"group" 				=> "Link Button",
						),						
						array(
							"type"					=> "fontsmanager",
							"heading"				=> __( "Button Text Font", "ts_visual_composer_extend" ),
							"param_name"			=> "font_button_family",
							"value"					=> "",
							"default"				=> "true",
							"connector"				=> "font_button_type",
							"description"			=> __( "Select the font to be used for the link button text.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => array('square', 'rounded', 'pill', 'circle', 'flat') ),
							"group" 				=> "Link Button",
						),
						array(
							"type"					=> "hidden_input",
							"param_name"			=> "font_button_type",
							"value"					=> "",
							"description"			=> __( "", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => array('square', 'rounded', 'pill', 'circle', 'flat') ),
							"group" 				=> "Link Button",
						),						
						array(
							"type"                  => "nouislider",
							"heading"               => __( "Button Font Size", "ts_visual_composer_extend" ),
							"param_name"            => "button_font",
							"value"                 => "14",
							"min"                   => "10",
							"max"                   => "100",
							"step"                  => "1",
							"unit"                  => 'px',
							"description"       	=> __( "Define the font size for the icon / text in the button.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => array('circle', 'flat') ),
							"group" 				=> "Link Button",
						),
						// Other Settings
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_6",
							"value"					=> "",
							"seperator"				=> "Other Settings",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"group" 				=> "Other Settings",
						),
						array(
							"type"              	=> "nouislider",
							"heading"           	=> __( "Margin: Top", "ts_visual_composer_extend" ),
							"param_name"        	=> "margin_top",
							"value"             	=> "0",
							"min"               	=> "-50",
							"max"               	=> "200",
							"step"              	=> "1",
							"unit"              	=> 'px',
							"description"       	=> __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
							"group" 				=> "Other Settings",
						),
						array(
							"type"              	=> "nouislider",
							"heading"           	=> __( "Margin: Bottom", "ts_visual_composer_extend" ),
							"param_name"        	=> "margin_bottom",
							"value"             	=> "0",
							"min"               	=> "-50",
							"max"               	=> "200",
							"step"              	=> "1",
							"unit"              	=> 'px',
							"description"       	=> __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
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
			// Add Single Teaser Block (for Custom Slider)
			if (function_exists('vc_map')) {
				vc_map( array(
					"name"                      	=> __( "TS Teaser Block Slide", "ts_visual_composer_extend" ),
					"base"                      	=> "TS_VCSC_Teaser_Block_Single",
					"icon" 	                    	=> "icon-wpb-ts_vcsc_teaser_block_single",
					"class"                     	=> "ts_vcsc_main_teaser_block",
					"content_element"                => true,
					"as_child"                       => array('only' => 'TS_VCSC_Teaser_Block_Slider_Custom'),
					"category"                  	=> __( 'VC Extensions', "ts_visual_composer_extend" ),
					"description"               	=> __("Place a teaser block element", "ts_visual_composer_extend"),
					"admin_enqueue_js"            	=> "",
					"admin_enqueue_css"           	=> "",
					"params"                    	=> array(
						// Teaser Settings
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_1",
							"value"					=> "",
							"seperator"				=> "Teaser Content",
							"description"       	=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"                  => "switch_button",
							"heading"			    => __( "Teaser Block Image", "ts_visual_composer_extend" ),
							"param_name"		    => "teaser_graphic",
							"value"                 => "true",
							"on"				    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"				    => __( 'No', "ts_visual_composer_extend" ),
							"style"				    => "select",
							"design"			    => "toggle-light",
							"admin_label"           => true,
							"description"		    => __( "Switch the toggle if you want to use an image to further highlight the teaser block.", "ts_visual_composer_extend" ),
						),
						array(
							"type"                  => "attach_image",
							"holder" 				=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? "img" : ""),
							"heading"               => __( "Image", "ts_visual_composer_extend" ),
							"param_name"            => "image",
							"class"					=> "ts_vcsc_holder_image",
							"value"                 => "",
							"admin_label"           => ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? false : true),
							"dependency"		    => array( 'element' => "teaser_graphic", 'value' => 'true' ),
							"description"           => __( "Select the image you want to use for the teaser.", "ts_visual_composer_extend" )
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Overlay Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "overlay",
							"value"             	=> "#0094FF",
							"description"       	=> __( "Define the hover overlay color for the teaser image.", "ts_visual_composer_extend" ),
							"dependency"		    => array( 'element' => "teaser_graphic", 'value' => 'true' ),
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Background Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "color_background",
							"value"             	=> "#ffffff",
							"description"       	=> __( "Define the background color for the teaser block.", "ts_visual_composer_extend" ),
							"dependency"        	=> ""
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Separator Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "color_separator",
							"value"             	=> "#049cdb",
							"description"       	=> __( "Define the color for the teaser separator.", "ts_visual_composer_extend" ),
							"dependency"        	=> ""
						),
						array(
							"type" 					=> "vc_link",
							"heading" 				=> __("Link", "ts_visual_composer_extend"),
							"param_name" 			=> "link",
							"description" 			=> __("Provide a link to another site/page for the Image Teaser.", "ts_visual_composer_extend")
						),
						// Teaser Header
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_2",
							"value"					=> "",
							"seperator"				=> "Teaser Header",
							"description"       	=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"              	=> "dropdown",
							"heading"           	=> __( "Header Position", "ts_visual_composer_extend" ),
							"param_name"        	=> "info_position",
							"width"             	=> 300,
							"value"             	=> array(								
								__( 'Bottom', "ts_visual_composer_extend" )		=> "bottom",
								__( 'Top', "ts_visual_composer_extend" )      	=> "top",
							),
							"admin_label"           => true,
							"dependency"		    => array( 'element' => "teaser_graphic", 'value' => 'true' ),
							"description"       	=> __( "Select where the header (title + description) should be shown in relation to the teaser image.", "ts_visual_composer_extend" ),
						),
						array(
							"type"              	=> "textfield",
							"heading"           	=> __( "Header", "ts_visual_composer_extend" ),
							"param_name"        	=> "title",
							"class"					=> "ts_vcsc_holder_text_main",
							"value"             	=> "Teaser Title",
							"admin_label"           => true,
							"description"       	=> __( "Enter a title for the image teaser.", "ts_visual_composer_extend" )
						),						
						array(
							"type"					=> "fontsmanager",
							"heading"				=> __( "Font Family", "ts_visual_composer_extend" ),
							"param_name"			=> "font_title_family",
							"value"					=> "",
							"default"				=> "true",
							"connector"				=> "font_title_type",
							"description"			=> __( "Select the font to be used for the title text.", "ts_visual_composer_extend" ),
						),
						array(
							"type"					=> "hidden_input",
							"param_name"			=> "font_title_type",
							"value"					=> "",
							"description"			=> __( "", "ts_visual_composer_extend" ),
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Header Font Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "color_title",
							"value"             	=> "#a2a2a2",
							"description"       	=> __( "Define the font color for the teaser title.", "ts_visual_composer_extend" ),
							"dependency"        	=> ""
						),
						array(
							"type"                  => "nouislider",
							"heading"               => __( "Header Font Size", "ts_visual_composer_extend" ),
							"param_name"            => "font_title_size",
							"value"                 => "18",
							"min"                   => "10",
							"max"                   => "100",
							"step"                  => "1",
							"unit"                  => 'px',
							"description"       	=> __( "Define the font size for the teaser header.", "ts_visual_composer_extend" ),
						),
						// Teaser Message
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_3",
							"value"					=> "",
							"seperator"				=> "Teaser Message",
							"description"       	=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"              	=> "textfield",
							"heading"           	=> __( "Description", "ts_visual_composer_extend" ),
							"param_name"        	=> "subtitle",
							"class"					=> "ts_vcsc_holder_text_sub",
							"value"             	=> "Teaser Subtitle",
							"admin_label"           => true,
							"description"       	=> __( "Enter a short description for the image teaser.", "ts_visual_composer_extend" )
						),
						array(
							"type"					=> "fontsmanager",
							"heading"				=> __( "Font Family", "ts_visual_composer_extend" ),
							"param_name"			=> "font_content_family",
							"value"					=> "",
							"default"				=> "true",
							"connector"				=> "font_content_type",
							"description"			=> __( "Select the font to be used for the description text.", "ts_visual_composer_extend" ),
						),
						array(
							"type"					=> "hidden_input",
							"param_name"			=> "font_content_type",
							"value"					=> "",
							"description"			=> __( "", "ts_visual_composer_extend" ),
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Message Font Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "color_subtitle",
							"value"             	=> "#aaaaaa",
							"description"       	=> __( "Define the font color for the teaser message.", "ts_visual_composer_extend" ),
							"dependency"        	=> ""
						),
						array(
							"type"                  => "nouislider",
							"heading"               => __( "Message Font Size", "ts_visual_composer_extend" ),
							"param_name"            => "font_content_size",
							"value"                 => "14",
							"min"                   => "10",
							"max"                   => "100",
							"step"                  => "1",
							"unit"                  => 'px',
							"description"       	=> __( "Define the font size for the teaser message.", "ts_visual_composer_extend" ),
						),
						// Icon Settings
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_4",
							"value"					=> "",
							"seperator"				=> "Icon Settings",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"group" 				=> "Icon Settings",
						),
						array(
							"type"              	=> "dropdown",
							"heading"           	=> __( "Icon Position", "ts_visual_composer_extend" ),
							"param_name"        	=> "icon_position",
							"width"             	=> 300,
							"value"             	=> array(
								__( 'No Icon', "ts_visual_composer_extend" )      	=> "",
								__( 'Left Icon', "ts_visual_composer_extend" )		=> "left",
								__( 'Right Icon', "ts_visual_composer_extend" )		=> "right",
								__( 'Top Icon', "ts_visual_composer_extend" )			=> "top",
								__( 'Bottom Icon', "ts_visual_composer_extend" )		=> "bottom",
							),
							"description"       	=> __( "Select if and where an icon should be shown in the teaser title.", "ts_visual_composer_extend" ),
							"group" 				=> "Icon Settings",
						),				
						array(
							'type' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
							'heading' 				=> __( 'Title Icon', 'ts_visual_composer_extend' ),
							'param_name' 			=> 'icon',
							'value'					=> '',
							'source'				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorValue,
							'settings' 				=> array(
								'emptyIcon' 				=> false,
								'type' 						=> 'extensions',
								'iconsPerPage' 				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
								'source' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorSource,
							),
							"admin_label"       	=> true,
							"description"       	=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon you want to display in the teaser title.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
							"dependency"			=> array( 'element' => "icon_position", 'value' => array('left', 'right', 'top', 'bottom') ),
							"group" 				=> "Icon Settings",
						),						
						array(
							"type"                  => "nouislider",
							"heading"               => __( "Icon Size", "ts_visual_composer_extend" ),
							"param_name"            => "icon_size",
							"value"                 => "18",
							"min"                   => "4",
							"max"                   => "256",
							"step"                  => "1",
							"unit"                  => 'px',
							"description"       	=> __( "Define the size for the icon in the image teaser.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "icon_position", 'value' => array('left', 'right', 'top', 'bottom') ),
							"group" 				=> "Icon Settings",
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Icon Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "icon_color",
							"value"             	=> "#aaaaaa",
							"description"       	=> __( "Define the color of the icon for the image teaser.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "icon_position", 'value' => array('left', 'right', 'top', 'bottom') ),
							"group" 				=> "Icon Settings",
						),
						// Button Settings
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_5",
							"value"					=> "",
							"seperator"				=> "Button Settings",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"group" 				=> "Link Button",
						),
						array(
							"type"              	=> "dropdown",
							"heading"           	=> __( "Button Type", "ts_visual_composer_extend" ),
							"param_name"        	=> "button_type",
							"width"             	=> 300,
							"value"             	=> array(
								__( 'None', "ts_visual_composer_extend" )      		=> "",
								__( '3D Square', "ts_visual_composer_extend" )		=> "square",
								__( '3D Rounded', "ts_visual_composer_extend" )		=> "rounded",
								__( '3D Pill', "ts_visual_composer_extend" )		=> "pill",
								__( '3D Circle', "ts_visual_composer_extend" )		=> "circle",
								__( 'Flat Button', "ts_visual_composer_extend" )	=> "flat",
							),
							"admin_label"           => true,
							"description"       	=> __( "Select if and what type of link button should be shown.", "ts_visual_composer_extend" ),
							"group" 				=> "Link Button",
						),
						array(
							"type"                  => "dropdown",
							"heading"               => __( "Button Style", "ts_visual_composer_extend" ),
							"param_name"            => "button_square",
							"width"                 => 300,
							"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Button_Square,
							"description"           => __( "Select the actual button style for the 'Read More' Link.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => 'square' ),
							"group" 				=> "Link Button",
						),
						array(
							"type"                  => "dropdown",
							"heading"               => __( "Button Style", "ts_visual_composer_extend" ),
							"param_name"            => "button_rounded",
							"width"                 => 300,
							"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Button_Rounded,
							"description"           => __( "Select the actual button style for the 'Read More' Link.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => 'rounded' ),
							"group" 				=> "Link Button",
						),
						array(
							"type"                  => "dropdown",
							"heading"               => __( "Button Style", "ts_visual_composer_extend" ),
							"param_name"            => "button_pill",
							"width"                 => 300,
							"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Button_Pill,
							"description"           => __( "Select the actual button style for the 'Read More' Link.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => 'pill' ),
							"group" 				=> "Link Button",
						),
						array(
							"type"                  => "dropdown",
							"heading"               => __( "Button Style", "ts_visual_composer_extend" ),
							"param_name"            => "button_circle",
							"width"                 => 300,
							"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Button_Circle,
							"description"           => __( "Select the actual button style for the 'Read More' Link.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => 'circle' ),
							"group" 				=> "Link Button",
						),
						array(
							"type"                  => "dropdown",
							"heading"               => __( "Button Style", "ts_visual_composer_extend" ),
							"param_name"            => "button_flat",
							"width"                 => 150,
							"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Default_Colors,
							"description"           => __( "Select the color scheme for the link button.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => 'flat' ),
							"group" 				=> "Link Button",
						),						
						array(
							"type"                  => "dropdown",
							"heading"               => __( "Button Hover Style", "ts_visual_composer_extend" ),
							"param_name"            => "button_hover",
							"width"                 => 150,
							"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Hover_Colors,
							"description"           => __( "Select the hover color scheme for the link button.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => 'flat' ),
							"group" 				=> "Link Button",
						),						
						array(
							"type"              	=> "dropdown",
							"heading"           	=> __( "Button Size", "ts_visual_composer_extend" ),
							"param_name"        	=> "button_size",
							"width"             	=> 300,
							"value"             	=> array(
								__( 'Normal', "ts_visual_composer_extend" )			=> "ts-button-normal",
								__( 'Small', "ts_visual_composer_extend" )      	=> "ts-button-small",
								__( 'Tiny', "ts_visual_composer_extend" )  			=> "ts-button-tiny",
								__( 'Large', "ts_visual_composer_extend" )  		=> "ts-button-large",
								__( 'Jumbo', "ts_visual_composer_extend" )  		=> "ts-button-jumbo",
							),
							"description"       	=> __( "Select the size for the icon button.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => array('square', 'rounded', 'pill') ),
							"group" 				=> "Link Button",
						),
						array(
							"type"					=> "switch_button",
							"heading"           	=> __( "Add Button Wrapper", "ts_visual_composer_extend" ),
							"param_name"        	=> "button_wrapper",
							"value"             	=> "false",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"description"       	=> __( "Switch the toggle to add a wrapper frame around the 'Read More' button (most suited for 'pill' and 'circle' buttons).", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => array('square', 'rounded', 'pill', 'circle') ),
							"group" 				=> "Link Button",
						),
						array(
							"type"              	=> "textfield",
							"heading"           	=> __( "Button Text", "ts_visual_composer_extend" ),
							"param_name"        	=> "button_text",
							"value"             	=> "Read More",
							"description"       	=> __( "Enter a text for the 'Read More' button.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => array('square', 'rounded', 'pill', 'circle', 'flat') ),
							"group" 				=> "Link Button",
						),						
						array(
							"type"					=> "fontsmanager",
							"heading"				=> __( "Button Text Font", "ts_visual_composer_extend" ),
							"param_name"			=> "font_button_family",
							"value"					=> "",
							"default"				=> "true",
							"connector"				=> "font_button_type",
							"description"			=> __( "Select the font to be used for the link button text.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => array('square', 'rounded', 'pill', 'circle', 'flat') ),
							"group" 				=> "Link Button",
						),
						array(
							"type"					=> "hidden_input",
							"param_name"			=> "font_button_type",
							"value"					=> "",
							"description"			=> __( "", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => array('square', 'rounded', 'pill', 'circle', 'flat') ),
							"group" 				=> "Link Button",
						),						
						array(
							"type"                  => "nouislider",
							"heading"               => __( "Button Font Size", "ts_visual_composer_extend" ),
							"param_name"            => "button_font",
							"value"                 => "14",
							"min"                   => "10",
							"max"                   => "100",
							"step"                  => "1",
							"unit"                  => 'px',
							"description"       	=> __( "Define the font size for the icon / text in the button.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "button_type", 'value' => array('circle', 'flat') ),
							"group" 				=> "Link Button",
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
			// Add Teaser Block Slider 1 (Custom Build)
			if (function_exists('vc_map')) {
				vc_map(array(
				    "name"                              => __("TS Teaser Block Slider", "ts_visual_composer_extend"),
				    "base"                              => "TS_VCSC_Teaser_Block_Slider_Custom",
				    "class"                             => "",
				    "icon"                              => "icon-wpb-ts_vcsc_teaser_block_slider_custom",
				    "category"                          => __("VC Extensions", "ts_visual_composer_extend"),
				    "as_parent"                         => array('only' => 'TS_VCSC_Teaser_Block_Single'),
				    "description"                       => __("Build a custom Teaser Block Slider", "ts_visual_composer_extend"),
					"controls" 							=> "full",
					"content_element"                   => true,
					"is_container" 						=> true,
					"container_not_allowed" 			=> false,
					"show_settings_on_create"           => true,
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
				    "params"                            => array(
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
							"type"                      => "nouislider",
							"heading"                   => __( "Max Number of Teasers", "ts_visual_composer_extend" ),
							"param_name"                => "number_teasers",
							"value"                     => "1",
							"min"                       => "1",
							"max"                       => "10",
							"step"                      => "1",
							"unit"                      => '',
							"description"               => __( "Define the maximum number of Teaser Blocks per slide.", "ts_visual_composer_extend" ),
							"dependency" 				=> ""
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
                            "dependency" 				=> array("element" 	=> "auto_play", "value" 	=> "true"),
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
							"description"               => __( "Switch the toggle if you want to show a left/right navigation buttons for the slider.", "ts_visual_composer_extend" ),
							"dependency"                => ""
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Show Dot Navigation", "ts_visual_composer_extend" ),
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
	class WPBakeryShortCode_TS_VCSC_Teaser_Block_Slider_Custom extends WPBakeryShortCodesContainer {};
}
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_TS_VCSC_Teaser_Block_Standalone extends WPBakeryShortCode {};
	class WPBakeryShortCode_TS_VCSC_Teaser_Block_Single extends WPBakeryShortCode {};
}
// Initialize "TS Teaser Blocks" Class
if (class_exists('TS_Teaser_Blocks')) {
	$TS_Teaser_Blocks = new TS_Teaser_Blocks;
}