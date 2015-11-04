<?php
	add_shortcode('TS_VCSC_Star_Rating', 'TS_VCSC_Star_Rating_Function');
	function TS_VCSC_Star_Rating_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-extend-simptip');
		wp_enqueue_style('ts-font-ecommerce');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
	
		extract( shortcode_atts( array(
			'rating_shortcode'			=> 'false',
			'rating_maximum'			=> 5,
			'rating_value'				=> 0,
			'rating_dynamic'			=> '',
			'rating_size'				=> 25,
			'rating_auto'				=> 'true',
			'rating_title'				=> '',
			'rating_position'			=> 'top',
			'rating_rtl'				=> 'false',
			'rating_symbol'				=> 'other',
			'rating_icon'				=> '',
			'color_rated'				=> '#FFD800',
			'color_empty'				=> '#e3e3e3',
			// Rating Settings
			'caption_show'				=> 'true',
			'caption_position'			=> 'left',
			'caption_digits'			=> '.',
			'caption_danger'			=> '#d9534f',
			'caption_warning'			=> '#f0ad4e',
			'caption_info'				=> '#5bc0de',
			'caption_primary'			=> '#428bca',
			'caption_success'			=> '#5cb85c',
			// Tooltip Settings
			'tooltip_css'				=> 'false',
			'tooltip_content'			=> '',
			'tooltip_position'			=> 'ts-simptip-position-top',
			'tooltip_style'				=> '',
			// Other Settings
			'margin_top'				=> 20,
			'margin_bottom'				=> 20,
			'el_id'						=> '',
			'el_class'					=> '',
			'css'						=> '',
		), $atts ));
		
		// Rating as Shortcode
		if ($rating_shortcode == "true") {
			if (TS_VCSC_IsBase64Encoded(strip_tags($rating_dynamic))) {
				$rating_value			= rawurldecode(base64_decode(strip_tags($rating_dynamic)));
			} else {
				$rating_value			= rawurldecode(strip_tags($rating_dynamic));
			}
			$rating_value				= do_shortcode($rating_value);
			$rating_value				= number_format((float)$rating_value, 2, $caption_digits, '');
		} else {
			$rating_value				= number_format($rating_value, 2, $caption_digits, '');
		}
		
		if ($rating_rtl == "false") {
			$rating_width				= $rating_value / $rating_maximum * 100;
		} else {
			$rating_width				= 100 - ($rating_value / $rating_maximum * 100);
		}
		
		if ($rating_symbol == "other") {
			if ($rating_icon == "ts-ecommerce-starfull1") {
				$rating_class			= 'ts-rating-stars-star1';
			} else if ($rating_icon == "ts-ecommerce-starfull2") {
				$rating_class			= 'ts-rating-stars-star2';
			} else if ($rating_icon == "ts-ecommerce-starfull3") {
				$rating_class			= 'ts-rating-stars-star3';
			} else if ($rating_icon == "ts-ecommerce-starfull4") {
				$rating_class			= 'ts-rating-stars-star4';
			} else if ($rating_icon == "ts-ecommerce-heartfull") {
				$rating_class			= 'ts-rating-stars-heart1';
			} else if ($rating_icon == "ts-ecommerce-heart") {
				$rating_class			= 'ts-rating-stars-heart2';
			} else if ($rating_icon == "ts-ecommerce-thumbsup") {
				$rating_class			= 'ts-rating-stars-thumb';
			} else if ($rating_icon == "ts-ecommerce-ribbon4") {
				$rating_class			= 'ts-rating-stars-ribbon';
			}
		} else {
			$rating_class				= 'ts-rating-stars-smile';
		}

		if (($rating_value >= 0) && ($rating_value <= 1)) {
			$caption_class				= 'ts-label-danger';
			$caption_background			= 'background-color: ' . $caption_danger . ';';
		} else if (($rating_value > 1) && ($rating_value <= 2)) {
			$caption_class				= 'ts-label-warning';
			$caption_background			= 'background-color: ' . $caption_warning . ';';
		} else if (($rating_value > 2) && ($rating_value <= 3)) {
			$caption_class				= 'ts-label-info';
			$caption_background			= 'background-color: ' . $caption_info . ';';
		} else if (($rating_value > 3) && ($rating_value <= 4)) {
			$caption_class				= 'ts-label-primary';
			$caption_background			= 'background-color: ' . $caption_primary . ';';
		} else if (($rating_value > 4) && ($rating_value <= 5)) {
			$caption_class				= 'ts-label-success';
			$caption_background			= 'background-color: ' . $caption_success . ';';
		}
		
		// Tooltip
		if ($tooltip_css == "true") {
			if (strlen($tooltip_content) != 0) {
				$rating_tooltipclasses	= " ts-simptip-multiline " . $tooltip_style . " " . $tooltip_position;
				$rating_tooltipcontent	= ' data-tstooltip="' . $tooltip_content . '"';
			} else {
				$rating_tooltipclasses	= "";
				$rating_tooltipcontent	= "";
			}
		} else {
			$rating_tooltipclasses		= "";
			if (strlen($tooltip_content) != 0) {
				$rating_tooltipcontent	= ' title="' . $tooltip_content . '"';
			} else {
				$rating_tooltipcontent	= "";
			}
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Star_Rating', $atts);
		} else {
			$css_class	= '';
		}
		
		$output = '';
	
		$output .= '<div class="ts-rating-stars-frame ' . $el_class . ' ' . $css_class . '" data-auto="' . $rating_auto . '" data-size="' . $rating_size . '" data-width="' . ($rating_size * 5) . '" data-rating="' . $rating_value . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
			if (($rating_position == 'top') && ($rating_title != '')) {
				$output .= '<div class="ts-rating-title ts-rating-title-top">' . $rating_title . '</div>';
			}			
			if ($rating_tooltipcontent != '') {
				$output .= '<div class="ts-rating-tooltip ' . $rating_tooltipclasses . '" ' . $rating_tooltipcontent . '>';
			}			
				$output .= '<div class="ts-star-rating' . ($rating_rtl == "false" ? "" : "-rtl") . ' ts-rating-active " style="font-size: ' . $rating_size . 'px; line-height: ' . ($rating_size + 5) . 'px;">';
					if (($caption_show == "true") && ($caption_position == "left")) {
						$output .= '<div class="ts-rating-caption" style="margin-right: 10px;">';
							if ($rating_rtl == "false") {
								$output .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . $rating_value . ' / ' . number_format($rating_maximum, 2, $caption_digits, '') . '</span>';
							} else {
								$output .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . number_format($rating_maximum, 2, $caption_digits, '') . ' / ' . $rating_value . '</span>';
							}
						$output .= '</div>';
					}
					$output .= '<div class="ts-rating-container' . ($rating_rtl == "false" ? "" : "-rtl") . ' ts-rating-glyph-holder ' . $rating_class . '" style="color: ' . ($rating_rtl == "false" ? $color_empty : $color_rated) . ';">';
						$output .= '<div class="ts-rating-stars ' . $rating_class . '" style="color: ' . ($rating_rtl == "false" ? $color_rated : $color_empty) . '; width: ' . $rating_width . '%;"></div>';
					$output .= '</div>';
					if (($caption_show == "true") && ($caption_position == "right")) {
						$output .= '<div class="ts-rating-caption" style="margin-left: 10px;">';
							if ($rating_rtl == "false") {
								$output .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . $rating_value . ' / ' . number_format($rating_maximum, 2, $caption_digits, '') . '</span>';
							} else {
								$output .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . number_format($rating_maximum, 2, $caption_digits, '') . ' / ' . $rating_value . '</span>';
							}
						$output .= '</div>';
					}
				$output .= '</div>';			
			if ($rating_tooltipcontent != '') {
				$output .= '</div>';
			}			
			if (($rating_position == 'bottom') && ($rating_title != '')) {
				$output .= '<div class="ts-rating-title ts-rating-title-bottom">' . $rating_title . '</div>';
			}
		$output .= '</div>';

		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>