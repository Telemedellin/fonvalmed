<?php
	add_shortcode('TS-VCSC-Textillate', 'TS_VCSC_Textillate_Function');
	function TS_VCSC_Textillate_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndWaypoints == "true") {
			if (wp_script_is('waypoints', $list = 'registered')) {
				wp_enqueue_script('waypoints');
			} else {
				wp_enqueue_script('ts-extend-waypoints');
			}
		}
		wp_enqueue_style('ts-extend-textillate');
		wp_enqueue_script('ts-extend-textillate');
		wp_enqueue_style('ts-visual-composer-extend-front');			
		wp_enqueue_script('ts-visual-composer-extend-front');
	
		extract( shortcode_atts( array(
			'textillate'				=> '',
			'font_size'					=> 36,
			'font_color'				=> '#000000',
			'font_weight'				=> 'inherit',
			'font_align'				=> 'left',
			'font_family'				=> '',
			'font_type'					=> '',
			
			'link'						=> '',
			
			'animation_delay'			=> 100,
			'animation_in'				=> 'bounce',
			'animation_out'				=> 'bounce',
			'animation_loop'			=> 'false',
			'animation_pause'			=> 4000,
			'text_order_in'				=> 'sequence',
			'text_order_out'			=> 'sequence',
			
			'margin_bottom'				=> 0,
			'margin_top' 				=> 0,
			'el_id' 					=> '',
			'el_class'                  => '',
			'css'						=> '',
		), $atts ));
		
		if (!empty($el_id)) {
			$textillate_id				= $el_id;
		} else {
			$textillate_id				= 'ts-vcsc-textillate-' . mt_rand(999999, 9999999);
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 					= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Textillate', $atts);
		} else {
			$css_class					= '';
		}
		
		$output 						= '';
		
		if (strpos($font_family, 'Default') == false) {
			$google_font 				= TS_VCSC_GetFontFamily($textillate_id, $font_family, $font_type, false, true, false);
		} else {
			$google_font				= '';
		}
		
		$style_setting					= $google_font . 'color: ' . $font_color . ' !important; font-size: ' . $font_size . 'px; line-height: ' . $font_size . 'px; font-weight: ' . $font_weight . '; text-align: ' . $font_align . '; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
		
		$animation_in_string			= 'data-delay="' . $animation_delay . '" data-in-effect="ts-composer-css-' . $animation_in . '" data-in-sync="' . ($text_order_in == "sync" ? "true" : "false") . '" data-in-shuffle="' . ($text_order_in == "shuffle" ? "true" : "false") . '" data-in-reverse="' . ($text_order_in == "reverse" ? "true" : "false") . '"';
		if ($animation_loop == "true") {
			$animation_out_string		= 'data-pause="' . $animation_pause . '" data-out-effect="ts-composer-css-' . $animation_out . '" data-out-sync="' . ($text_order_out == "sync" ? "true" : "false") . '" data-out-shuffle="' . ($text_order_out == "shuffle" ? "true" : "false") . '" data-out-reverse="' . ($text_order_out == "reverse" ? "true" : "false") . '"';
		} else {
			$animation_out_string		= '';
		}
		
		$output 						.= '<div id="' . $textillate_id . '" class="ts-textillate ' . $el_class . ' ' . $css_class . '" data-loop="' . $animation_loop . '" ' . $animation_in_string . ' ' . $animation_out_string . ' style="' . $style_setting . '">' . $textillate . '</div>';
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>