<?php
	add_shortcode('TS-VCSC-Google-Trends', 'TS_VCSC_Google_Trends_Function');
	add_shortcode('TS_VCSC_Google_Trends', 'TS_VCSC_Google_Trends_Function');
	function TS_VCSC_Google_Trends_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'trend_height'				=> '400',
			'trend_width'				=> '1024',
			'trend_average'				=> 'false',
			'trend_tags'				=> '',
			'trend_geo'					=> 'US',
			'margin_top'				=> 20,
			'margin_bottom'				=> 20,
			'el_id'						=> '',
			'el_class'					=> '',
			'css'						=> '',
		), $atts ));
	
		//format input
		$trend_height	=	(int)$trend_height;
		$trend_width	=	(int)$trend_width;
		$trend_tags		=	esc_attr($trend_tags);
		$trend_geo		=	esc_attr($trend_geo);
		
		$Trends_Array = explode(',', $trend_tags);
		$Trends_Count = count($Trends_Array);
		
		$output = '';
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Google-Trends', $atts);
		} else {
			$css_class	= '';
		}
		
		$output .= '<div id="" class="ts-google-trend ' . $css_class . '" style="width: ' . $trend_width . 'px; height: auto; overflow: hidden; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
			if ($trend_average == "true"){
				$output .= '<script type="text/javascript" src="https://www.google.com/trends/embed.js?hl=en-US&q=' . $trend_tags . '&geo=' . $trend_geo . '&cmpt=q&content=1&cid=TIMESERIES_GRAPH_AVERAGES_CHART&export=5&w=' . $trend_width . '&h=' . $trend_height . '"></script>';
			} else {
				$output .= '<script type="text/javascript" src="https://www.google.com/trends/embed.js?hl=en-US&q=' . $trend_tags . '&geo=' . $trend_geo . '&cmpt=q&content=1&cid=TIMESERIES_GRAPH_0&export=5&w=' . $trend_width . '&h=' . $trend_height . '"></script>';
			}
		$output .= '</div>';
			
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_Google_Trends extends WPBakeryShortCode {};
	}
?>