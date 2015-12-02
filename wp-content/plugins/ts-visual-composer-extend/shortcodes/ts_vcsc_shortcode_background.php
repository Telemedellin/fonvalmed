<?php
	add_shortcode('TS-VCSC-YouTube-Background', 'TS_VCSC_Background_Function');
	add_shortcode('TS_VCSC_YouTube_Background', 'TS_VCSC_Background_Function');
	function TS_VCSC_Background_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
		
		wp_enqueue_style('ts-extend-ytplayer');
		wp_enqueue_script('ts-extend-ytplayer');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'video_youtube'				=> '',
			'video_mute'				=> 'true',
			'video_loop'				=> 'false',
			'video_start'				=> 'false',
			'video_stop'				=> 'true',
			'video_controls'			=> 'true',
			'video_raster'				=> 'false',
			
			'el_id' 					=> '',
			'el_class'                  => '',
			'css'						=> '',
		), $atts ));
		
		if (!empty($el_id)) {
			$background_id				= $el_id;
		} else {
			$background_id				= 'ts-vcsc-pageback-' . mt_rand(999999, 9999999);
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-YouTube-Background', $atts);
		} else {
			$css_class	= '';
		}

		$output = '<div id="' . $background_id . '" class="ts-pageback-youtube ' . $css_class . ' ' . $el_class . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-video="' . $video_youtube . '" data-controls="' . $video_controls . '" data-start="' . $video_start . '" data-raster="' . $video_raster . '" data-mute="' . $video_mute . '" data-loop="' . $video_loop . '"></div>';
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_YouTube_Background extends WPBakeryShortCode {};
	}
?>