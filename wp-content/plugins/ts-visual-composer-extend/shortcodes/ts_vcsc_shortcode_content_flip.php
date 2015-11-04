<?php
	add_shortcode('TS-VCSC-Content-Flip', 'TS_VCSC_Content_Flip_Function');
	add_shortcode('TS_VCSC_Content_Flip', 'TS_VCSC_Content_Flip_Function');
	function TS_VCSC_Content_Flip_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
		
		wp_enqueue_style('ts-extend-simptip');
		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'flip_style'				=> 'style1',
			'flip_effect_style1'		=> 'horizontal',
			'flip_effect_style2'		=> 'ts-flip-right',
			'flip_effect_speed'			=> 'medium',
			'flip_trigger'				=> 'hover',
			'flip_size_auto'			=> 'true',
			'flip_size_type'			=> 'fixed',
			'flip_size'					=> 200,
			'flip_size_min'				=> 200,
			'flip_size_max'				=> 200,
			'flip_border_type'			=> '',
			'flip_border_thick'			=> 1,
			'flip_border_radius'		=> '',
			'flip_border_color_front'	=> '#dddddd',
			'flip_border_color_back'	=> '#dddddd',
			'front_icon_replace'		=> 'false',
			'front_icon'				=> '',
			'front_image'				=> '',
			'front_image_full'			=> 'false',
			'front_icon_size'			=> 70,
			'front_icon_color'			=> '#000000',
			'front_icon_background'		=> '',
			'front_padding'				=> 'false',
			'front_icon_padding'		=> 0,
			'front_icon_frame_type'		=> '',
			'front_icon_frame_thick'	=> 1,
			'front_icon_frame_radius'	=> '',
			'front_icon_frame_color'	=> '',
			'front_title'				=> '',
			'front_html'				=> 'false',
			'front_content'				=> '',
			'front_content_html'		=> '',
			'front_color'				=> '#000000',
			'front_color_title'			=> '#000000',
			'front_background'			=> '#ffffff',			
			'font_fronttitle_family'	=> 'Default',
			'font_fronttitle_type'		=> '',
			'font_frontcontent_family'	=> 'Default',
			'font_frontcontent_type'	=> '',			
			'font_backtitle_family'		=> 'Default',
			'font_backtitle_type'		=> '',
			'font_backcontent_family'	=> 'Default',
			'font_backcontent_type'		=> '',
			'font_button_family'		=> 'Default',
			'font_button_type'			=> '',			
			'back_icon'					=> '',
			'back_image'				=> '',
			'back_title'				=> '',
			'back_html'					=> 'false',
			'back_content'				=> '',
			'back_content_html'			=> '',
			'back_color'				=> '#000000',
			'back_color_title'			=> '#000000',
			'back_background'			=> '#ffffff',
			'read_more_link'			=> 'false',
			'read_more_url'				=> '',
			'read_more_txt'				=> 'Read More',
			'read_more_target'			=> '_parent',
			'read_more_color'			=> '#000000',
			'read_more_background'		=> '#dddddd',
			'animation_icon'			=> '',
			'animation_view'            => '',
			'margin_bottom'				=> '20',
			'margin_top' 				=> '0',
			'el_id' 					=> '',
			'el_class'                  => '',
			'css'						=> '',
		), $atts ));
	
		if (!empty($el_id)) {
			$flip_box_id				= $el_id;
		} else {
			$flip_box_id				= 'ts-vcsc-flip-box-' . mt_rand(999999, 9999999);
		}
		
		if (!empty($front_image)) {
			$front_image_path 			= wp_get_attachment_image_src($front_image, 'large');
		}
	
		if ($flip_border_type != '') {
			$flip_border_style_front	= 'border: ' . $flip_border_thick . 'px ' . $flip_border_type . ' ' . $flip_border_color_front . ';';
			$flip_border_style_back		= 'border: ' . $flip_border_thick . 'px ' . $flip_border_type . ' ' . $flip_border_color_back . ';';
		} else {
			$flip_border_style_front	= '';
			$flip_border_style_back		= '';
		}
	
		if ($front_icon_frame_type != '') {
			$front_icon_frame_style		= 'border: ' . $front_icon_frame_thick . 'px ' . $front_icon_frame_type . ' ' . $front_icon_frame_color . ';';
			$front_icon_frame_class		= '';
		} else {
			$front_icon_frame_style		= '';
			$front_icon_frame_class		= '';
		}
		
		if ($front_padding == "true") {
			$front_icon_size_adjust		= ($front_icon_size - 2*$front_icon_padding - 2*$front_icon_frame_thick);
		} else {
			$front_icon_size_adjust		= ($front_icon_size - 2*$front_icon_frame_thick);
		}
		
		$front_icon_style				= 'background-color:' . $front_icon_background . '; width: ' . $front_icon_size . 'px; height: ' . $front_icon_size . 'px; font-size: ' . $front_icon_size_adjust . 'px; line-height: ' . $front_icon_size . 'px;';
		
		if ($flip_trigger == "hover") {
			if ($flip_style == "style1") {
				$flipper_type			= 'flip-container-frame-hover';
			} else if ($flip_style == "style2") {
				$flipper_type			= 'ts-flip-cube-hover';
			}
		} else if ($flip_trigger == "click") {
			if ($flip_style == "style1") {
				$flipper_type			= 'flip-container-frame-click';
			} else if ($flip_style == "style2") {
				$flipper_type			= 'ts-flip-cube-click';
			}
		}
		
		if ($front_image_full == "true") {
			$front_image_style			= 'width: 100%; height: auto; margin: 0px;';
			$front_panel_adjust			= 'padding: 0px;';
		} else {
			$front_image_style			= 'padding: ' . $front_icon_padding . 'px; background-color:' . $front_icon_background . '; width: ' . $front_icon_size . 'px; height: auto; ';
			$front_panel_adjust			= '';
		}
		
		if ($flip_effect_speed == "veryslow") {
			$effectspeed				= 2000;
		} else if ($flip_effect_speed == "slow") {
			$effectspeed				= 1500;
		} else if ($flip_effect_speed == "medium") {
			$effectspeed				= 1000;
		} else if ($flip_effect_speed == "fast") {
			$effectspeed				= 750;
		} else if ($flip_effect_speed == "veryfast") {
			$effectspeed				= 500;
		}
		
		if ($animation_view != '') {
			$animation_css              = TS_VCSC_GetCSSAnimation($animation_view);
		} else {
			$animation_css 				= '';
		}		
		
		// Height Settings
		if ($flip_size_auto == "false") {
			if ($flip_size_type == 'fixed') {
				$content_height			= 'height: ' . $flip_size .  'px;';
			} else if ($flip_size_type == 'minimum') {
				$content_height			= 'min-height: ' . $flip_size .  'px;';
			} else if ($flip_size_type == 'maximum') {
				$content_height			= 'max-height: ' . $flip_size .  'px;';
			}			
		} else {
			$content_height				= '';
		}
		
		// Custom Font Settings
		if (strpos($font_fronttitle_family, 'Default') === false) {
			$google_font_fronttitle		= TS_VCSC_GetFontFamily($flip_box_id . " h3.ts-flip-front-title", $font_fronttitle_family, $font_fronttitle_type, false, true, false);
		} else {
			$google_font_fronttitle		= '';
		}
		if (strpos($font_frontcontent_family, 'Default') === false) {
			$google_font_frontcontent	= TS_VCSC_GetFontFamily($flip_box_id . " .ts-flip-front-content", $font_frontcontent_family, $font_frontcontent_type, false, true, false);
		} else {
			$google_font_frontcontent	= '';
		}		
		if (strpos($font_backtitle_family, 'Default') === false) {
			$google_font_backtitle		= TS_VCSC_GetFontFamily($flip_box_id . " h3.ts-flip-back-title", $font_backtitle_family, $font_backtitle_type, false, true, false);
		} else {
			$google_font_backtitle		= '';
		}
		if (strpos($font_backcontent_family, 'Default') === false) {
			$google_font_backcontent	= TS_VCSC_GetFontFamily($flip_box_id . " .ts-flip-back-content", $font_backcontent_family, $font_backcontent_type, false, true, false);
		} else {
			$google_font_backcontent	= '';
		}
		if (strpos($font_button_family, 'Default') === false) {
			$google_font_button			= TS_VCSC_GetFontFamily($flip_box_id . " .ts-flip-link", $font_button_family, $font_button_type, false, true, false);
		} else {
			$google_font_button			= '';
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Content-Flip', $atts);
		} else {
			$css_class	= '';
		}
		
		$output = '';
		
		if ($flip_style == "style1") {
			$output .= '<div id="' . $flip_box_id . '" class="flip-container-frame ' . $flipper_type . ' ' . $el_class . ' ' . $animation_css . ' ' . ($flip_size_auto == "true" ? "auto" : "fixed") . ' ' . $css_class . '" data-trigger="' . $flip_trigger . '" data-autoheight="' . $flip_size_auto . '" style="' . $content_height . ' width: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
				$output .= '<div class="flip-container-main ' . $flip_effect_style1 . ' ' . $flip_effect_speed . '" data-speed="' . $effectspeed . '">';
					$output .= '<div class="flip-container-flipper">';
						$output .= '<div class="flip-container-flipper-content flip-container-flipper-front ' . $flip_effect_speed . '" style="' . ($flip_size_auto == "true" ? "" : "height: 100%;") . 'width: 100%; background-color: ' . $front_background . '; ' . $flip_border_style_front . '">';
							$output .= '<div class="ts-flip-content" style="color: ' . $front_color . '; ' . $front_panel_adjust . '">';
								if ($front_image_full == "true") {
									$output .= '<img src="' . $front_image_path[0] . '" style="' . $front_image_style . '" class="' . $animation_icon . '">';
								} else {
									if ($front_icon_replace == "false") {
										$output .= '<i style="color:' . $front_icon_color . ';' . $front_icon_style . ' ' . $front_icon_frame_style . ' text-align: center; display: inline-block !important; margin: 10px auto;" class="ts-font-icon ' . $front_icon . ' ' . $front_icon_frame_class . ' ' . $animation_icon . ' ' . $front_icon_frame_radius . '" data-animation="' . $animation_icon . '"></i>';
									} else {
										$output .= '<img src="' . $front_image_path[0] . '" style="' . $front_image_style . ' ' . $front_icon_frame_style . '" class="ts-font-icon ' . $front_icon_frame_class . ' ' . $front_icon_frame_radius . ' ' . $animation_icon . '" data-animation="' . $animation_icon . '">';
									}
									$output .= '<h3 class="ts-flip-front-title" style="color: ' . $front_color_title . '; ' . $google_font_fronttitle . '">' . $front_title . '</h3>';
									if ($back_html == "true") {
										$output .= '<p class="ts-flip-front-content ts-flip-text" style="' . $google_font_frontcontent . '">' . do_shortcode(rawurldecode(base64_decode(strip_tags($front_content_html)))) . '</p>';
									} else {
										$output .= '<p class="ts-flip-front-content ts-flip-text" style="' . $google_font_frontcontent . '">' . strip_tags($front_content) . '</p>';
									}
								}
							$output .= '</div>';
						$output .= '</div>';
						$output .= '<div class="flip-container-flipper-content flip-container-flipper-back ' . $flip_effect_speed . '" style="' . ($flip_size_auto == "true" ? "" : "height: 100%;") . 'width: 100%; background-color: ' . $back_background . '; ' . $flip_border_style_back . '">';
							$output .= '<div class="ts-flip-content" style="color: ' . $back_color . ';">';
								$output .= '<h3 class="ts-flip-back-title" style="color: ' . $back_color_title . '; ' . $google_font_backtitle . '">' . $back_title . '</h3>';
								if ($back_html == "true") {
									$output .= '<p class="ts-flip-back-content ts-flip-text" style="' . $google_font_backcontent . '">' . do_shortcode(rawurldecode(base64_decode(strip_tags($back_content_html)))) . '</p>';
								} else {
									$output .= '<p class="ts-flip-back-content ts-flip-text" style="' . $google_font_backcontent . '">' . strip_tags($back_content) . '</p>';
								}
								if ((!empty($read_more_url)) && ($read_more_link == "true")) {
									$output .= '<p class="ts-flip-link"><a href="' . $read_more_url . '" target="' . $read_more_target . '" class="ts-flip-link-anchor" style="color: ' . $read_more_color . '; background: ' . $read_more_background . '; ' . $google_font_button . '">' . $read_more_txt . '</a></p>';
								}
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
		} else if ($flip_style == "style2") {
			$output .= '<div class="clearfix">';
				$output .= '<div id="' . $flip_box_id . '" class="ts-flip-cube ' . $flip_effect_style2 . ' ' . $flipper_type . ' ' . $el_class . ' ' . $animation_css . ' ' . ($flip_size_auto == "true" ? "auto" : "fixed") . '  ' . $css_class . '" data-trigger="' . $flip_trigger . '" data-autoheight="' . $flip_size_auto . '" style="' . $content_height . 'width: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
					$output .= '<div class="ts-object" style="height: 100%; width: 100%;">';
						$output .= '<div class="ts-front" style="height: 100%; width: 100%; background-color: ' . $front_background . '; ' . $flip_border_style_front . '">';
							$output .= '<div class="ts-flip-content" style="color: ' . $front_color . '; ' . $front_panel_adjust . '">';
								if ($front_image_full == "true") {
									$output .= '<img src="' . $front_image_path[0] . '" style="' . $front_image_style . '" class="' . $animation_icon . '">';
								} else {
									if ($front_icon_replace == "false") {
										$output .= '<i style="color:' . $front_icon_color . ';' . $front_icon_style . ' ' . $front_icon_frame_style . ' text-align: center; display: inline-block !important; margin: 10px auto;" class="ts-font-icon ' . $front_icon . ' ' . $front_icon_frame_class . ' ' . $animation_icon . ' ' . $front_icon_frame_radius . '" data-animation="' . $animation_icon . '"></i>';
									} else {
										$output .= '<img src="' . $front_image_path[0] . '" style="' . $front_image_style . ' ' . $front_icon_frame_style . '" class="ts-font-icon ' . $front_icon_frame_class . ' ' . $front_icon_frame_radius . ' ' . $animation_icon . '" data-animation="' . $animation_icon . '">';
									}
									$output .= '<h3 class="ts-flip-front-title" style="color: ' . $front_color_title . '; ' . $front_panel_adjust . '; ' . $google_font_fronttitle . '">' . $front_title . '</h3>';
									if ($back_html == "true") {
										$output .= '<p class="ts-flip-front-content ts-flip-text" style="' . $google_font_frontcontent . '">' . do_shortcode(rawurldecode(base64_decode(strip_tags($front_content_html)))) . '</p>';
									} else {
										$output .= '<p class="ts-flip-front-content ts-flip-text" style="' . $google_font_frontcontent . '">' . strip_tags($front_content) . '</p>';
									}
								}
							$output .= '</div>';
						$output .= '</div>';
						$output .= '<div class="ts-back" style="height: 100%; width: 100%; background-color: ' . $back_background . '; ' . $flip_border_style_back . '">';
							$output .= '<div class="ts-flip-content" style="color: ' . $back_color . ';">';
								$output .= '<h3 class="ts-flip-back-title" style="color: ' . $back_color_title . '; ' . $google_font_backtitle . '">' . $back_title . '</h3>';
								if ($back_html == "true") {
									$output .= '<p class="ts-flip-back-content ts-flip-text" style="' . $google_font_backcontent . '">' . do_shortcode(rawurldecode(base64_decode(strip_tags($back_content_html)))) . '</p>';
								} else {
									$output .= '<p class="ts-flip-back-content ts-flip-text" style="' . $google_font_backcontent . '">' . strip_tags($back_content) . '</p>';
								}
								if ((!empty($read_more_url)) && ($read_more_link == "true")) {
									$output .= '<p class="ts-flip-link"><a href="' . $read_more_url . '" target="' . $read_more_target . '" class="ts-flip-link-anchor" style="color: ' . $read_more_color . '; background: ' . $read_more_background . '; ' . $google_font_button . '">' . $read_more_txt . '</a></p>';
								}
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
		}
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_Content_Flip extends WPBakeryShortCode {};
	}
?>