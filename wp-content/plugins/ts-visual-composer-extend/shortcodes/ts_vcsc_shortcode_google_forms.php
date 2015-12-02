<?php
	add_shortcode('TS-VCSC-Google-Forms', 'TS_VCSC_Google_Forms_Function');
	add_shortcode('TS_VCSC_Google_Forms', 'TS_VCSC_Google_Forms_Function');
	function TS_VCSC_Google_Forms_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'form_id'					=> '',
			'form_height'				=> 500,
			'margin_top'				=> 20,
			'margin_bottom'				=> 20,
			'css'						=> '',
		), $atts ));
		
		$output = '';
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Google-Forms', $atts);
		} else {
			$css_class	= '';
		}
		
		$output .= '<div id="ts-google-form-holder-' . mt_rand(999999, 9999999) . '" class="ts-google-form-holder" style="width: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
			$output .= '<iframe src="https://docs.google.com/forms/d/' . $form_id . '/viewform?embedded=true" width="100%" height="' . $form_height . '" frameborder="0" marginheight="0" marginwidth="0" allowtransparency="true" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		$output .= '</div>';
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_Google_Forms extends WPBakeryShortCode {};
	}
?>