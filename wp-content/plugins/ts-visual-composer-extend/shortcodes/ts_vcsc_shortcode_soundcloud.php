<?php
	add_shortcode('TS_VCSC_Soundcloud', 'TS_VCSC_Soundcloud_Function');
	function TS_VCSC_Soundcloud_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-visual-composer-extend-front');
	
		extract( shortcode_atts( array(
		  	'url' 						=> '',
			'iframe' 					=> 'true',
			'width' 					=> '100%',
			'height' 					=> 166,
			
			'auto_play' 				=> 'false',
			'color' 					=> '#ff7700',
			'show_user'					=> 'true',
			'show_artwork'				=> 'true',
			'show_playcount'			=> 'true',
			
			'show_comments' 			=> 'true',
			'show_reposts'				=> 'false',
			'hide_related'				=> 'false',
			
			'sharing'					=> 'true',
			'download'					=> 'true',
			'liking'					=> 'true',
			'buying'					=> 'true',

			'start_track'				=> 0,

			'margin_top'				=> 0,
			'margin_bottom'				=> 0,
			'css'						=> '',
		), $atts ));
		
		$output = $notice = $visible = '';
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Soundcloud', $atts);
		} else {
			$css_class	= '';
		}
		
		$color 							= str_replace("#", "", $color);
	
		if ($iframe == 'true'){
			// Use iFrame
			$path 						= set_url_scheme('http://w.soundcloud.com/player?url=' . $url . '&amp;color=' . $color . '&amp;auto_play=' . $auto_play . '&amp;hide_related=' . $hide_related . '&amp;show_comments=' . $show_comments . '&amp;show_user=' . $show_user . '&amp;start_track=' . $start_track . '&amp;show_playcount=' . $show_playcount . '&amp;show_artwork=' . $show_artwork . '&amp;buying=' . $buying . '&amp;download=' . $download . '&amp;liking=' . $liking . '&amp;sharing=' . $sharing . '&amp;show_reposts=' . $show_reposts . '');
			$output .= '<div class="ts-soundcloud-iframe-container" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; width: 100%; height: 100%;">';
				//$output .= '<iframe style="width: 100%; height: ' . $height . 'px;" width="100%" height="' . $height . '" allowtransparency="true" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player?url=' . $url . '&amp;color=' . $color . '&amp;auto_play=' . $auto_play . '&amp;hide_related=' . $hide_related . '&amp;show_comments=' . $show_comments . '&amp;show_user=' . $show_user . '&amp;start_track=' . $start_track . '&amp;show_playcount=' . $show_playcount . '&amp;show_artwork=' . $show_artwork . '&amp;buying=' . $buying . '&amp;download=' . $download . '&amp;liking=' . $liking . '&amp;sharing=' . $sharing . '&amp;show_reposts=' . $show_reposts . '"></iframe>';
				$output .= '<iframe style="width: 100%; height: ' . $height . 'px;" width="100%" height="' . $height . '" allowtransparency="true" scrolling="no" frameborder="no" src="' . $path . '"></iframe>';
			$output .= '</div>';
		} else {
			// Use Flash
			$url = 'https://player.soundcloud.com/player.swf?' . http_build_query($atts);
			$output .= '<div class="ts-soundcloud-flash-container" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; width: 100%; height: 100%;">';
				$output .= '<object width="' . $width . '" height="' . $height . '">';
					$output .= '<param name="movie" value="' . $url . '"></param>';
					$output .= '<param name="allowscriptaccess" value="always"></param>';
					$output .= '<embed width="' . $width . '" height="' . $height . '" src="' . $url . '" allowscriptaccess="always" type="application/x-shockwave-flash"></embed>';
				$output .= '</object>';
			$output .= '</div>';
		}	
	
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>