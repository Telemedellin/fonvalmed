<?php
	add_shortcode('TS_VCSC_Mixcloud', 'TS_VCSC_Mixcloud_Function');
	function TS_VCSC_Mixcloud_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-visual-composer-extend-front');
	
		extract( shortcode_atts( array(
			'type'						=> 'single', //single,playlist,profile
			'url'						=> '',
		  	'url_single' 				=> '',
			'url_playlist'				=> '',
			'url_profile'				=> '',
			'mini'						=> 'false',
			'light'						=> 'false',
			'color'						=> '#1490e0',
			'artwork'					=> 'true',
			'cover'						=> 'true',
			'tracklist'					=> 'false',
			'autoplay'					=> 'false',
			'followers'					=> 'true',
			'margin_top'				=> 0,
			'margin_bottom'				=> 0,
			'css'						=> '',
		), $atts ));
		
		$output 						= '';		
		
		if ($type == "single") {
			$url 						= urlencode(trailingslashit($url_single));
		} else if ($type == "playlist") {
			$url 						= urlencode(trailingslashit($url_playlist));
		} else if ($type == "profile") {
			$url 						= urlencode(trailingslashit($url_profile));
		}
		
		// Determine Player Height
		if (($type == "single") || ($type == "playlist")) {
			if ($tracklist == "true") {
				if ($mini == "true") {
					$height				= 240;
				} else {
					$height				= 360;
				}
			} else {
				if ($mini == "true") {
					$height				= 60;
				} else {
					$height				= 180;
				}
			}
		} else if ($type == "profile") {
			$height						= 250;
		}
		
		// Convert Player Attributes
		$mini							= ($mini == "false" ? 		0 : 1);
		$light							= ($light == "false" ? 		0 : 1);
		$artwork						= ($artwork == "false" ? 	1 : 0);
		$cover							= ($cover == "false" ? 		1 : 0);
		$tracklist						= ($tracklist == "false" ? 	1 : 0);
		$autoplay						= ($autoplay == "false" ? 	0 : 1);
		$followers						= ($followers == "false" ? 	1 : 0);

		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 					= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Mixcloud', $atts);
		} else {
			$css_class					= '';
		}
		
		if (($type == "single") || ($type == "playlist")) {
			$path 						= set_url_scheme('https://www.mixcloud.com/widget/iframe/?feed=' . $url . '&replace=0&mini=' . $mini . '&autoplay=' . $autoplay . '&hide_artwork=' . $artwork . '&hide_cover=' . $cover . '&hide_tracklist=' . $tracklist . '&light=' . $light . '&stylecolor=' . $color . '&embed_type=widget_standard');
		} else if ($type == "profile") {
			$path 						= set_url_scheme('https://www.mixcloud.com/widget/follow/?u=' . $url . '&followers=' . $followers);
		}
		
		$output .= '<div class="ts-mixcloud-iframe-container" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; width: 100%; height: 100%;">';
			$output .= '<iframe style="width: 100%; height: ' . $height . 'px;" width="100%" height="' . $height . '" allowtransparency="true" scrolling="no" frameborder="no" src="' . $path . '"></iframe>';
		$output .= '</div>';
	
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>