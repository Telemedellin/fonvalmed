<?php
	add_shortcode('TS_VCSC_Title_Flipboard', 'TS_VCSC_Title_Flipboard_Function');
	function TS_VCSC_Title_Flipboard_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
		
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndWaypoints == "true") {
			if (wp_script_is('waypoints', $list = 'registered')) {
				wp_enqueue_script('waypoints');
			} else {
				wp_enqueue_script('ts-extend-waypoints');
			}
		}
		wp_enqueue_script('ts-extend-flipflap');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
	
		extract( shortcode_atts( array(
			'language'					=> 'latin',
			'title'						=> '',
			'start'						=> '',
			'equalize'					=> 'true',
			'dotted'					=> 'true',
			'size'						=> 'large',
			'style'						=> 'dark',
			'speed'						=> 3,
			'restart'					=> 'false',
			'mobile'					=> 'false',
			'wrapper'					=> 'h1',
			'viewport'					=> 'false',
			'delay'						=> 0,
			'margin_top'                => 20,
			'margin_bottom'             => 20,
			'el_id' 					=> '',
			'el_class'                  => '',
			'css'						=> '',
		), $atts ));
		
		$output							= '';

		if ($language == "latin") {
			$title 						= preg_replace('/[^ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz 0123456789.,!?#@()+-=\s]/', '', $title);
			$start 						= preg_replace('/[^ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz 0123456789.,!?#@()+-=\s]/', '', $start);
			$chars						= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ 0123456789.,!?#@()+-=';
		} else if ($language == "greek") {
			$title 						= preg_replace('/[^ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩΆΈΊΎΏΌαβγδεζηθικλμνξοπρστυφχψωάέίύόώϊϋ 0123456789.,!?#@()+-=\s]/', '', $title);
			$start 						= preg_replace('/[^ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩΆΈΊΎΏΌαβγδεζηθικλμνξοπρστυφχψωάέίύόώϊϋ 0123456789.,!?#@()+-=\s]/', '', $start);
			$chars						= 'ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩΆΈΊΎΏΌάέίύόώϊϋ 0123456789.,!?#@()+-=';
		} else if ($language == "russian") {
			$title 						= preg_replace('/[^АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя 0123456789.,!?#@()+-=\s]/', '', $title);
			$start 						= preg_replace('/[^АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя 0123456789.,!?#@()+-=\s]/', '', $start);
			$chars						= 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ 0123456789.,!?#@()+-=';
		}
		
		$background_image				= TS_VCSC_GetResourceURL('images/flipboard/ts_flipflap_' . $language . '_' . $style . '_' . $size . '.png');
		
		// Flipboard Size
		if ($size == 'large') {
			$char_height				= 100;
			$char_width					= 50;
		} else if ($size == 'medium') {
			$char_height				= 70;
			$char_width					= 35;
		} else if ($size == 'small') {
			$char_height				= 40;
			$char_width					= 20;
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Title_Flipboard', $atts);
		} else {
			$css_class	= '';
		}
	
		$output .= '<div class="ts-splitflap-container clearFixMe ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$output .= '<img class="ts-splitflap-image" src="' . TS_VCSC_GetResourceURL('images/other/ts_flipboard_title_' . $style . '.png') . '">';
				$output .= '<div class="ts-splitflap-info">' . __( "Title Text", "ts_visual_composer_extend" ) . ': ' . $title . '</div>';
				$output .= '<div class="ts-splitflap-info">' . __( "Flipboard Size", "ts_visual_composer_extend" ) . ': ' . $size . '</div>';
				$output .= '<div class="ts-splitflap-info">' . __( "Trigger on Viewport", "ts_visual_composer_extend" ) . ': ' . $viewport . '</div>';
			} else {
				$output .= '<div class="ts-splitflap-wrapper" data-frontend="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-restart="' . $restart . '" data-mobile="' . $mobile . '" data-wrapper="' . $wrapper . '" data-text="' . strtoupper($title) . '" data-start="' . strtoupper($start) . '" data-equalize="' . $equalize . '" data-dotted="' . $dotted . '" data-chars="' . $chars . '" data-speed="' . $speed . '" data-size="' . $size . '" data-height="' . $char_height . '" data-width="' . $char_width . '" data-image="' . $background_image . '" data-viewport="' . $viewport . '" data-delay="' . $delay . '">';
					$output .= '' . $title . '';
				$output .= '</div>';
			}
		$output .= '</div>';
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>