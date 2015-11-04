<?php
	add_shortcode('TS-VCSC-Timeline', 'TS_VCSC_Timeline_Function');
	function TS_VCSC_Timeline_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-extend-simptip');
		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'timeline_style'			=> 'style1',
			'timeline_pattern'			=> 'light',
			'timeline_ulwrap'			=> '',
			'timeline_bottom'			=> 'false',
			'timeline_dots'				=> 'true',
			'timeline_position'			=> 'direction-l',
			'timeline_color'			=> '#ffffff',
			'timeline_background'		=> '#000000',
			'icon_replace'				=> 'false',
			'icon'						=> '',
			'image'						=> '',
			'icon_size'					=> 80,
			'icon_color'				=> '#000000',
			'icon_background'			=> '',
			'icon_frame_type'			=> '',
			'icon_frame_thick'			=> 1,
			'icon_frame_color'			=> '#000000',
			'icon_frame_radius'			=> '',
			'padding'					=> 'false',
			'icon_padding'				=> 0,
			'show_date'					=> 'true',
			'date'						=> '',
			'sub_date'					=> '',
			'title'						=> '',
			'text_code'					=> 'false',
			'text'						=> '',
			'text_html'					=> '',
			'animation_icon'			=> '',
			'animation_view'            => '',
			'margin_bottom'				=> '0',
			'margin_top' 				=> '0',
			'el_id' 					=> '',
			'el_class'                  => '',
			'css'						=> '',
		), $atts ));
	
		if (!empty($el_id)) {
			$timeline_id				= $el_id;
		} else {
			$timeline_id				= 'ts-vcsc-timeline-' . mt_rand(999999, 9999999);
		}
		
		if (!empty($image)) {
			$image_path 				= wp_get_attachment_image_src($image, 'large');
		}
	
		if ($icon_frame_type != '') {
			$icon_border_style			= 'border: ' . $icon_frame_thick . 'px ' . $icon_frame_type . ' ' . $icon_frame_color . ';';
		} else {
			$icon_border_style			= '';
		}
	
		if ($icon_frame_type != '') {
			$icon_frame_style			= 'border: ' . $icon_frame_thick . 'px ' . $icon_frame_type . ' ' . $icon_frame_color . ';';
		} else {
			$icon_frame_style			= '';
		}
		
		$icon_size_adjust				= ($icon_size - 2*$icon_frame_thick - 2*$icon_padding);
		
		if (($timeline_style == 'style1') || ($timeline_style == 'style3')) {
			$icon_style						= 'height: ' . $icon_size_adjust . 'px; width: ' . $icon_size_adjust . 'px; font-size: 50px; line-height: ' . $icon_size_adjust . 'px; padding: ' . $icon_padding . 'px; color: ' . $icon_color . '; background-color:' . $icon_background . ';';
		} else {
			$icon_style						= 'color: ' . $icon_color . '; background-color:' . $icon_background . ';';
		}
		
		if (($timeline_style == 'style1') || ($timeline_style == 'style3')) {
			$image_style					= 'height: ' . $icon_size . 'px; width: ' . $icon_size . 'px; font-size: 50px; line-height: ' . $icon_size . 'px; padding: ' . $icon_padding . 'px; background-color:' . $icon_background . ';';
		} else {
			$image_style					= 'padding: ' . $icon_padding . 'px; background-color:' . $icon_background . ';';
		}
		
		if ($animation_view != '') {
			$animation_css              = TS_VCSC_GetCSSAnimation($animation_view);
		} else {
			$animation_css				= '';
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Timeline', $atts);
		} else {
			$css_class	= '';
		}
		
		$output = '';
		
		if ($timeline_style == 'style1') {
			$output .= '<div id="' . $timeline_id . '" class="ts-timeline-1 clearfix ' . $el_class . ' ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
				$output .= '<div class="ts-timeline-1-date" style="background: ' . $timeline_background . '; color: ' . $timeline_color . ';">';
					$output .= '<div class="day">' . $date . '</div>';
				$output .= '</div>';
				if (($timeline_bottom == "true") && ($timeline_dots == "true")) {
					$output .= '<div class="ts-timeline-1-line" style="background: ' . $timeline_background . ';"></div>';
				} else if ($timeline_bottom == "false") {
					$output .= '<div class="ts-timeline-1-line" style="background: ' . $timeline_background . ';"></div>';
				}				
				$output .= '<div class="ts-timeline-1-hor-line" style="background: ' . $timeline_background . ';"></div>';
				if (($timeline_bottom == "true") && ($timeline_dots == "true")) {
					$output .= '<div class="ts-timeline-1-start-point" style="border-color: ' . $timeline_background . ';"></div>';
				}
				$output .= '<div class="ts-timeline-1-container">';
					if (($icon_replace == "false") && (!empty($icon))) {
						$output .= '<div class="ts-timeline-1-icon">';
							$output .= '<i class="ts-font-icon ' . $icon . ' ' . $animation_css . ' ' . $icon_frame_radius . '" style="' . $icon_style . ' ' . $icon_border_style . '"></i>';
						$output .= '</div>';
					} else if (!empty($image_path[0])) {
						$output .= '<div class="ts-timeline-1-img">';
							$output .= '<img class="' . $animation_css . ' ' . $icon_frame_radius . '" src="' . $image_path[0] . '" alt="" style="' . $image_style . ' ' . $icon_border_style . '">';
						$output .= '</div>';
					}
					$output .= '<div class="ts-timeline-1-content' . (strlen($image_path[0]) > 0 ? " ts-timeline-1-hasimg" : "") . '">';
						$output .= '<h4>' . $title . '</h4>';
						if ($text_code == "true") {
							$output .= '<p>' . rawurldecode(base64_decode(strip_tags($text_html))) . '</p>';
						} else {
							$output .= '<p>' . $text . '</p>';
						}
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
		}
		if ($timeline_style == 'style2') {
			if ($timeline_ulwrap == "top") {
				$output .= '<div class="clearfix ' . $el_class . ' ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
				$output .= '<ul class="ts-timeline-2 ' . $timeline_pattern . ' ' . ($show_date == "true" ? "showdate" : "nodate") . '">';
			}
				if (($timeline_ulwrap == "") || ($timeline_ulwrap == "bottom")) {
					$output .= '<li id="' . $timeline_id . '" class="' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
				} else {
					$output .= '<li id="' . $timeline_id . '" class="' . $el_class . '" style="">';
				}
					if ($show_date == "true") {
						$output .= '<time class="ts-timeline-2-time"><span>' . $date . '</span> <span>' . $sub_date . '</span></time>';
					}
					if (($icon_replace == "false") && (!empty($icon))) {
						$output .= '<i class="ts-font-icon ' . $icon . ' ts-timeline-2-icon ' . $animation_css . '" style="' . $icon_style . '"></i>';
					} else if (!empty($image_path[0])) {
						$output .= '<img class="ts-timeline-2-image ' . $animation_css . ' ' . $icon_frame_radius . '" src="' . $image_path[0] . '" alt="" style="' . $image_style . ' ' . $icon_border_style . '">';
					}
					$output .= '<div class="ts-timeline-2-label">';
						$output .= '<h2>' . $title . '</h2>';
						if ($text_code == "true") {
							$output .= '<p>' . rawurldecode(base64_decode(strip_tags($text_html))) . '</p>';
						} else {
							$output .= '<p>' . $text . '</p>';
						}
					$output .= '</div>';
				$output .= '</li>';
			if ($timeline_ulwrap == "bottom") {
				$output .= '</ul">';
				$output .= '</div>';
			}
		}
		if ($timeline_style == 'style3') {
			if ($timeline_ulwrap == "top") {
				$output .= '<div class="clearFixMe ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; width: 100%;">';
				$output .= '<ul class="ts-timeline-3">';
			}
				if (($timeline_ulwrap == "") || ($timeline_ulwrap == "bottom")) {
					$output .= '<li id="' . $timeline_id . '" class="' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
				} else {
					$output .= '<li id="' . $timeline_id . '" class="' . $el_class . '" style="">';
				}
					$output .= '<div class="' . $timeline_position . '">';
						$output .= '<div class="flag-wrapper">';
							$output .= '<span class="flag">' . $title . '</span>';
						$output .= '</div>';
						$output .= '<div class="time-wrapper"><span class="time">' . $date . '</span></div>';
						$output .= '<div class="desc-wrapper">';
							if (($icon_replace == "false") && (!empty($icon))) {
								$output .= '<i class="ts-font-icon ' . $icon . ' ts-timeline-3-icon ' . $animation_css . ' ' . $icon_frame_radius . '" style="' . $icon_style . ' ' . $icon_border_style . '"></i>';
							} else if (!empty($image_path[0])) {
								$output .= '<img class="ts-timeline-3-image ' . $animation_css . ' ' . $icon_frame_radius . '" src="' . $image_path[0] . '" alt="" style="' . $image_style . ' ' . $icon_border_style . '">';
							}
							if ($text_code == "true") {
								$output .= '<div class="desc">' . rawurldecode(base64_decode(strip_tags($text_html))) . '</div>';
							} else {
								$output .= '<div class="desc">' . $text . '</div>';
							}
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</li>';
			if ($timeline_ulwrap == "bottom") {
				$output .= '</ul">';
				$output .= '</div>';
			}
		}
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>