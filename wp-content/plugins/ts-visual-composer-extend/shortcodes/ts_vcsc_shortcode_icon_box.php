<?php
	add_shortcode('TS-VCSC-Icon-Box', 'TS_VCSC_Font_Iconbox_Function');
	function TS_VCSC_Font_Iconbox_Function ($atts, $content = null) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-extend-simptip');
		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');

		extract(shortcode_atts( array(
			'style'                     => 'icon_left',
			'title'                     => '',
			'title_size'                => '25',
			'title_weight'              => 'inherit',
			'title_color'               => '#000000',
			'title_align'               => 'center',
			'title_margin'              => 0,
			'icon'                      => '',
			'icon_location'             => 'left',
			'icon_size_slide'           => 16,
			'icon_margin'				=> 10,
			'icon_color'                => '#000000',
			'icon_background'		    => '',
			'icon_frame_type' 			=> '',
			'icon_frame_thick'			=> 1,
			'icon_frame_radius'			=> '',
			'icon_frame_color'			=> '#000000',
			'icon_replace'				=> 'false',
			'icon_image'				=> '',
			'icon_padding'				=> 5,
			'content_html'				=> 'false',
			'content_text'				=> '',
			'content_text_html'			=> '',
			'content_color'				=> '#000000',
			'content_align'				=> 'center',
			'box_background_type'       => 'color',
			'box_background_color'      => '#ffffff',
			'box_background_pattern'    => '',
			'box_border'                => 'true',
			'box_border_type'           => '',
			'box_border_color'          => '#000000',
			'box_border_thick'          => 1,
			'box_border_radius'         => '',
			'read_more_link'            => 'false',
			'read_more_txt'             => '',
			'read_more_url'             => '',
			'read_more_target'          => '_parent',
			'read_more_style'           => 1,
			'animations'                => 'false',
			'animation_effect'			=> 'ts-hover-css-',
			'animation_class'			=> '',
			'animation_box'             => '',
			'animation_shadow'          => '',
			'animation_view'            => '',
			'margin_top'                => 0,
			'margin_bottom'             => 0,
			'el_id' 					=> '',
			'el_class'                  => '',
			'css'						=> '',
		), $atts ) );
		
		$output = $icon_style = $icon_frame_style = $icon_frame_class = $icon_frame_adjust = $box_frame_adjust = $box_frame_style = $animation_css = "";
		$icon_frame_top = $icon_frame_left = $box_margin_left = $box_padding_left = "0px";
		
		$icon_padding_vertical          = $icon_padding;
		$icon_padding_horizontal        = $icon_padding;
		
		if (!empty($el_id)) {
			$icon_box_id				= $el_id;
		} else {
			$icon_box_id				= 'ts-vcsc-box-icon-' . mt_rand(999999, 9999999);
		}
	
		if (!empty($icon_image)) {
			$icon_image_path 			= wp_get_attachment_image_src($icon_image, 'large');
		}
	
		$icon_style                     = 'padding: ' . $icon_padding_vertical . 'px ' . $icon_padding_horizontal . 'px; background-color:' . $icon_background . '; width: ' . $icon_size_slide . 'px; height: ' . $icon_size_slide . 'px; font-size: ' . $icon_size_slide . 'px; line-height: ' . $icon_size_slide . 'px;';
		$icon_image_style				= 'padding: ' . $icon_padding_vertical . 'px ' . $icon_padding_horizontal . 'px; background-color:' . $icon_background . '; width: ' . $icon_size_slide . 'px; height: ' . $icon_size_slide . 'px; font-size: ' . $icon_size_slide . 'px; line-height: ' . $icon_size_slide . 'px;';
		
		if ($icon_frame_type != '') {
			$icon_frame_class 	        = 'frame-enabled';
			$icon_frame_style 	        = 'border: ' . $icon_frame_thick . 'px ' . $icon_frame_type . ' ' . $icon_frame_color . ';';
		}
		
		if ($style == "boxed_left") {
			$style = "boxed";
			$icon_location = "left";
		} else  if ($style == "boxed_top") {
			$style = "boxed";
			$icon_location = "top";
		}
		
		if ($style == "boxed") {
			if ($icon_location == "top") {
				$icon_frame_top         = '-' . ($icon_size_slide / 2 + $icon_padding_horizontal + $icon_frame_thick + 5) . 'px';
				$icon_frame_left        = '-' . ($icon_size_slide / 2 + $icon_padding_vertical + $icon_frame_thick) . 'px';
				$icon_frame_adjust      = 'top:' . $icon_frame_top . '; margin-left:' . $icon_frame_left . ';';
				$box_frame_adjust       = '';
				$shadow_frame_adjust    = '';
			} else if ($icon_location == "left") {
				$icon_frame_left        = '-' . ($icon_size_slide / 2 + $icon_padding_horizontal + $icon_frame_thick + 5) . 'px';
				$icon_frame_top         = ((-$icon_size_slide / 2) - $icon_padding_vertical - $title_margin - $icon_frame_thick) . 'px';
				$icon_frame_adjust      = 'left:' . $icon_frame_left . '; margin-top:' . $icon_frame_top . ';';
				$box_margin_left        = ($icon_size_slide / 2) . 'px';
				$box_padding_left       = (($icon_size_slide / 2) + 30) . 'px';
				$box_frame_adjust       = 'margin-left: 0px; padding-left: ' . $box_padding_left . ';';
				$shadow_frame_adjust    = 'margin-left: ' . $box_margin_left . '; ';
			}
		}
		
		if ($box_background_type == "pattern") {
			$box_background_style		= 'background: url(' . $box_background_pattern . ') repeat;';
		} else if ($box_background_type == "color") {
			$box_background_style		= 'background-color: ' . $box_background_color .';';
		}
		
		if ($box_border_type != '') {
			if ($style == "boxed") {
				$box_frame_style        = 'border: ' . $box_border_thick . 'px ' . $box_border_type . ' ' . $box_border_color . ';';
			} else {
				$box_frame_style        = 'padding: 10px; border: ' . $box_border_thick . 'px ' . $box_border_type . ' ' . $box_border_color . ';';
			}
		}
		
		if (!empty($animation_class)) {
			$animation_icon				= $animation_effect . $animation_class;
		} else {
			$animation_icon				= '';
		}
		
		if ($animation_view != '') {
			$animation_css              = TS_VCSC_GetCSSAnimation($animation_view, "false");
		}

		$read_more_button_style			= $read_more_style;
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-vcsc-box-icon ' . $el_class . $animation_css . ' ' . $box_border_radius . ' ' . $style . '-style ts-box-icon ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Icon-Box', $atts);
		} else {
			$css_class	= 'ts-vcsc-box-icon ' . $el_class . $animation_css . ' ' . $box_border_radius . ' ' . $style . '-style ts-box-icon';
		}
		
		if (!empty($read_more_url) && ($read_more_link == "box")) {
			$output .= '<a class="ts-box-icon-link" style="color:' . $title_color . ';" href="'.$read_more_url.'" target="' . $read_more_target . '">';
		}
		$output .= '<div id="' . $icon_box_id . '" class="' . $css_class . '" style="margin-bottom:' . $margin_bottom . 'px; margin-top:' . $margin_top . 'px;">';
		$output .= (!empty($animation_box) ? '<div class="ts-hover ' . $animation_box . '">' : '');
			if ($style == "icon_left") {
				$output .= '<div class="ts-css-shadow ' . $animation_shadow . '" style="' . $box_background_style . '">';
					$output .= '<div class="box-detail-wrapper ' . $box_border_radius . '" style="' . $box_frame_style . '">';
						$output .= '<div class="ts-icon-box-title" style="width: 100%;">';
							$output .= '<table border="0" style="border: none !important; border-color: transparent !important;">';
								$output .= '<tr>';
									$output .= '<td>';
										if ($icon_replace == 'false') {
											if (!empty($icon)) {
												$output .= '<span style="width: auto !important;">';
													$output .= '<i class="' . $icon . ' ts-main-ico ts-font-icon ' . $icon_frame_radius . ' ' . $icon_frame_class . ' ' . $animation_icon .'" style="margin-right: ' . $icon_margin . 'px; color:' . $icon_color . ';' . $icon_style . ' ' . $icon_frame_style . '"></i>';
												$output .= '</span>';
											}
										} else {
											if (!empty($icon_image)) {
												$output .= '<span style="width: auto !important;">';
													$output .= '<img class="ts-main-ico ts-font-icon ' . $icon_frame_class . ' ' . $animation_icon . ' ' . $icon_frame_radius . '" src="' . $icon_image_path[0] . '" style="margin-right: ' . $icon_margin . 'px; ' . $icon_frame_style . ' ' . $icon_image_style . ' display: inline-block !important; margin-right: ' . $icon_margin . 'px;">';
												$output .= '</span>';
											}
										}
									$output .= '</td>';
									$output .= '<td>';
										$output .= '<span class="ts-box-icon-title" style="width: auto !important; color:' . $title_color . '; font-size:' . $title_size . 'px; font-weight:' . $title_weight . '; text-align:' . $title_align . ';">' . $title . '</span>';
									$output .= '</td>';
								$output .= '</tr>';
							$output .= '</table>';
						$output .= '</div>';
						if ($content_html == "true") {
							$output .= '<div class="ts-icon-box-content" style="color: ' . $content_color . '; text-align: ' . $content_align . ';">' . rawurldecode(base64_decode(strip_tags($content_text_html))) . '</div>';
						} else {
							$output .= '<div class="ts-icon-box-content" style="color: ' . $content_color . '; text-align: ' . $content_align . ';">' . strip_tags($content_text) . '</div>';
						}
						if (($read_more_txt) && ($read_more_link == "button")) {
							$output .= '<div class="clearboth"></div><a class="ts-icon-box-readmore style' . $read_more_button_style . '" href="' . $read_more_url . '" target="' . $read_more_target . '">'.$read_more_txt.'</a>';
						}
					$output .= '</div>';
				$output .= '<div class="clearboth"></div></div>';
			}  else if ($style == "icon_top") {
				$output .= '<div class="ts-css-shadow ' . $animation_shadow . ' ' . $box_border_radius . '" style="' . $box_background_style . '">';
					$output .= '<div class="top-side ' . $animation_css . ' ' . $box_border_radius . '" style="' . $box_frame_style . '">';
						if ($icon_replace == 'false') {
							if (!empty($icon)) {
								$output .= '<i style="margin-bottom: ' . $icon_margin . 'px; color:' . $icon_color . ';' . $icon_style . ' ' . $icon_frame_style . ' display: inline-block !important" class="' . $icon . ' ts-main-ico ts-font-icon ' . $icon_frame_class .' ' . $animation_icon . $icon_frame_radius . '"></i>';
							}
						} else {
							if (!empty($icon_image)) {
								$output .= '<img class="ts-main-ico ts-font-icon ' . $icon_frame_class . ' ' . $animation_icon . ' ' . $icon_frame_radius . '" src="' . $icon_image_path[0] . '" style="margin-bottom: ' . $icon_margin . 'px; ' . $icon_frame_style . ' ' . $icon_image_style . ' display: inline-block !important; margin-right: ' . $icon_margin . 'px;">';
							}
						}
						$output .= '<div class="box-detail-wrapper">';
						$output .= '<span class="ts-box-icon-title" style="width: auto !important; color:' . $title_color . '; font-size:' . $title_size . 'px; font-weight:' . $title_weight . '; text-align:' . $title_align . ';">' . $title . '</span>';
						if ($content_html == "true") {
							$output .= '<div class="ts-icon-box-content" style="color: ' . $content_color . '; text-align: ' . $content_align . ';">' . rawurldecode(base64_decode(strip_tags($content_text_html))) . '</div>';
						} else {
							$output .= '<div class="ts-icon-box-content" style="color: ' . $content_color . '; text-align: ' . $content_align . ';">' . strip_tags($content_text) . '</div>';
						}
						if (($read_more_txt) && ($read_more_link == "button")) {
							$output .= '<div class="clearboth"></div><a class="ts-icon-box-readmore style' . $read_more_button_style . '" href="' . $read_more_url . '" target="' . $read_more_target . '">'.$read_more_txt.'</a>';
						}
					$output .= '</div>';
				$output .= '</div><div class="clearboth"></div></div>';
			} else if ($style == "boxed") {
				$output .= '<div class="ts-css-shadow ' . $animation_shadow . ' ' . $box_border_radius . '" style="background-color: ' . $box_background_color .'; ' . $shadow_frame_adjust . '">';
					$output .= '<div class="ts-icon-box-boxed  ' . $icon_location . $animation_css . ' ' . $box_border_radius . '" style="' . $box_frame_style . ' ' . $box_frame_adjust . ' ' . $box_background_style .'">';
						if ($icon_replace == 'false') {
							if (!empty($icon)) {
								$output .= '<i style="' . $icon_style . ' ' . $icon_frame_style . ' ' . $icon_frame_adjust . ' color: '.$icon_color.';" class="' . $icon . ' ts-main-ico ts-font-icon ' . $icon_frame_radius . ' ' . $icon_frame_class . ' ' . $animation_icon . '"></i>';
							}
						} else {
							if (!empty($icon_image)) {
								$output .= '<img class="ts-main-ico ts-font-icon ' . $icon_frame_class . ' ' . $animation_icon . ' ' . $icon_frame_radius . '" src="' . $icon_image_path[0] . '" style="' . $icon_frame_style . ' ' . $icon_image_style . ' ' . $icon_frame_adjust . ' display: inline-block !important; margin-right: ' . $icon_margin . 'px;">';
							}
						}
						$output .= '<div class="ts-box-icon-title" style="color:' . $title_color . '; font-size:' . $title_size . 'px; font-weight:' . $title_weight . '; margin-top:' . $title_margin . 'px; text-align:' . $title_align . ';">' . $title . '</div>';
						if ($content_html == "true") {
							$output .= '<div class="ts-icon-box-content" style="color: ' . $content_color . '; text-align: ' . $content_align . ';">' . rawurldecode(base64_decode(strip_tags($content_text_html))) . '</div>';
						} else {
							$output .= '<div class="ts-icon-box-content" style="color: ' . $content_color . '; text-align: ' . $content_align . ';">' . strip_tags($content_text) . '</div>';
						}
						if (($read_more_txt) && ($read_more_link == "button")) {
							$output .= '<div class="clearboth"></div><a class="ts-icon-box-readmore style' . $read_more_button_style . '" href="' . $read_more_url . '" target="' . $read_more_target . '">'.$read_more_txt.'</a>';
						}
					$output .= '</div>';
				$output .= '<div class="clearboth"></div></div>';
			}
		$output .= (!empty($animation_box) ? '</div>' : '');
		$output .= '</div>';
		if (!empty($read_more_url) && ($read_more_link == "box")) {
			$output .= '</a>';
		}
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>
