<?php
	add_shortcode('TS-VCSC-Circliful', 'TS_VCSC_Circliful_Function');
	add_shortcode('TS_VCSC_Circliful', 'TS_VCSC_Circliful_Function');
	function TS_VCSC_Circliful_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndWaypoints == "true") {
			if (wp_script_is('waypoints', $list = 'registered')) {
				wp_enqueue_script('waypoints');
			} else {
				wp_enqueue_script('ts-extend-waypoints');
			}
		}
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndCountUp == "true") {
			wp_enqueue_script('ts-extend-countup');
		}
		wp_enqueue_script('ts-extend-circliful');
		wp_enqueue_style('ts-extend-simptip');
		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'color_foreground'					=> '#117d8b',
			'color_background'					=> '#eeeeee',
			'circle_border'						=> 'default',
			'circle_fill'						=> 'false',
			'circle_inside'						=> '#ffffff',
			'circle_half'						=> 'false',
			'circle_responsive'					=> 'true',
			'circle_maxsize'					=> 250,
			'circle_dimension'					=> 200,
			'circle_thickness'					=> 15,
			
			'circle_percent_by_shortcode'		=> 'false',
			'circle_percent'					=> 15,
			'circle_percent_shortcode'			=> '',
			
			'circle_speed'						=> 0.5,
			
			'circle_value_text_by_shortcode'	=> 'false',
			'circle_value_text'					=> '',
			'circle_value_text_shortcode'		=> '',
			
			'circle_value_pre'					=> '',
			'circle_value_post'					=> '',
			'circle_value_info'					=> '',			
			'circle_value_group'				=> ',',
			'circle_value_seperator'			=> '.',
			'circle_value_decimals'				=> 0,
			
			'circle_font_size'					=> 30,
			'circle_font_color'					=> '#676767',
			'circle_info_size'					=> 15,
			'circle_info_color'					=> '#999999',
			
			'circle_icon_replace'				=> 'false',
			'circle_icon'						=> '',
			'circle_image'						=> '',
			'circle_icon_position'				=> 'left',
			'circle_icon_color'					=> '#dddddd',
			'circle_icon_size'					=> 30,
			
			'margin_top'						=> 0,
			'margin_bottom'						=> 0,
			'el_id' 							=> '',
			'el_class' 							=> '',
			'css'								=> '',
		), $atts ));
		
		if (!empty($el_id)) {
			$circliful_id						= $el_id;
		} else {
			$circliful_id						= 'ts-vcsc-circliful-' . mt_rand(999999, 9999999);
		}
		
		$output = '';

		if ($circle_fill == "true") {
			$circliful_colors					= 'data-fgcolor="' . $color_foreground . '" data-bgcolor="' . $color_background . '" data-fill="' . $circle_inside . '"';
		} else {
			$circliful_colors					= 'data-fgcolor="' . $color_foreground . '" data-bgcolor="' . $color_background . '"';
		}
		
		// Check for Match in Shortcode
		if (($circle_percent_by_shortcode == "true") && ($circle_value_text_by_shortcode == "true")) {
			if ((rawurldecode(base64_decode(strip_tags($circle_percent_shortcode)))) == (rawurldecode(base64_decode(strip_tags($circle_value_text_shortcode))))) {
				$circle_percent					= rawurldecode(base64_decode(strip_tags($circle_percent_shortcode)));
				$circle_value_text				= $circle_percent;
				// Circle Percent as Shortcode{
				$circle_percent					= do_shortcode($circle_percent);
				$circle_percent					= (int)$circle_percent;
				// Label Value as Shortcode
				$circle_value_text				= $circle_percent;
			} else {
				$circle_percent					= rawurldecode(base64_decode(strip_tags($circle_percent_shortcode)));
				$circle_value_text				= rawurldecode(base64_decode(strip_tags($circle_value_text_shortcode)));
				// Circle Percent as Shortcode
				$circle_percent					= do_shortcode($circle_percent);
				$circle_percent					= (int)$circle_percent;
				// Label Value as Shortcode			
				$circle_value_text				= do_shortcode($circle_value_text);
				$circle_value_text				= (int)$circle_value_text;
			}
		} else if (($circle_percent_by_shortcode == "true") || ($circle_value_text_by_shortcode == "true")) {
			$circle_percent						= rawurldecode(base64_decode(strip_tags($circle_percent_shortcode)));
			$circle_value_text					= rawurldecode(base64_decode(strip_tags($circle_value_text_shortcode)));			
			// Circle Percent as Shortcode
			if ($circle_percent_by_shortcode == "true") {
				$circle_percent					= do_shortcode($circle_percent);
				$circle_percent					= (int)$circle_percent;
			}
			// Label Value as Shortcode
			if (!empty($circle_value_text_shortcode)) {				
				$circle_value_text				= do_shortcode($circle_value_text);
				$circle_value_text				= (int)$circle_value_text;
			} else {
				$circle_value_text				= '';
			}
		}

		// Label Value as Shortcode
		if ($circle_value_text_by_shortcode == "false") {
			if (!empty($circle_value_text)) {
				$circle_value_text				= floatval($circle_value_text);
			} else {
				$circle_value_text				= '';
			}
		}
		
		if (empty($circle_value_text)) {
			$circle_value_text					= '';
		}
		if (empty($circle_percent)) {
			$circle_percent						= '';
		}
		
		if (!empty($circle_value_info)) {
			$circliful_content					= 'data-animationstep="' . $circle_speed . '" data-text="' . $circle_value_text . '" data-seperator="' . $circle_value_seperator . '" data-decimals="' . TS_VCSC_numberOfDecimals(floatval($circle_value_text)) . '" data-prefix="' . $circle_value_pre . '" data-postfix="' . $circle_value_post . '" data-group="' . $circle_value_group . '" data-info="' . $circle_value_info . '"';
		} else {
			$circliful_content					= 'data-animationstep="' . $circle_speed . '" data-text="' . $circle_value_text . '" data-seperator="' . $circle_value_seperator . '" data-decimals="' . TS_VCSC_numberOfDecimals(floatval($circle_value_text)) . '" data-prefix="' . $circle_value_pre . '" data-postfix="' . $circle_value_post . '" data-group="' . $circle_value_group . '" data-info=""';
		}
		
		if ($circle_half == "false") {
			$circliful_half						= 'data-type="full"';
		} else {
			$circliful_half						= 'data-type="half"';
		}
		
		if ($circle_icon_replace == "false") {
			if (!empty($circle_icon)) {
				$circliful_icon					= 'data-icon="' . $circle_icon . '" data-iconsize="' . $circle_icon_size . '" data-iconposition="' . $circle_icon_position . '" data-iconcolor="' . $circle_icon_color . '"';
			} else {
				$circliful_icon					= '';
			}
			$circliful_image					= '';
		} else if ($circle_icon_replace == "true") {
			if (!empty($circle_image)) {
				$icon_image_path 				= wp_get_attachment_image_src($circle_image, 'full');
				$circliful_image				= 'data-image="' . $icon_image_path[0] . '" data-iconsize="' . $circle_icon_size . '" data-iconposition="' . $circle_icon_position . '" data-iconcolor=""';
			} else {
				$circliful_image				= '';
			}
			$circliful_icon						= '';
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-circliful-counter ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Circliful', $atts);
		} else {
			$css_class	= 'ts-circliful-counter ' . $el_class;
		}

		$output .= '<div id="' . $circliful_id . '-parent" class="ts-circliful-counter-parent" style="width: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
			$output .= '<div id="' . $circliful_id . '" data-id="' . $circliful_id . '" class="' . $css_class . '" data-border="' . $circle_border . '" data-responsive="' . $circle_responsive . '" data-fontsize="' . $circle_font_size . '" ' . $circliful_colors . ' data-fontcolor="' . $circle_font_color . '" data-infosize="' . $circle_info_size . '" data-infocolor="' . $circle_info_color . '" ' . $circliful_content . ' ' . $circliful_half . ' ' . $circliful_icon . ' ' . $circliful_image . ' data-view="false" data-dimension="' . $circle_dimension . '" data-maxsize="' . $circle_maxsize . '" data-width="' . $circle_thickness . '" data-percent="' . $circle_percent . '" data-percent-view="' . $circle_percent . '"></div>';
		$output .= '</div>';
	
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_Circliful extends WPBakeryShortCode {};
	}
?>