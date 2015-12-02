<?php
	add_shortcode('TS-VCSC-Google-Docs', 'TS_VCSC_Google_Docs_Function');
	add_shortcode('TS_VCSC_Google_Docs', 'TS_VCSC_Google_Docs_Function');
	function TS_VCSC_Google_Docs_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-visual-composer-extend-front');

		extract( shortcode_atts( array(
			'doc_type'					=> 'document',
			'doc_key'					=> '',
			'doc_height'				=> '500',
			'doc_share'					=> 'false',
			'doc_presentation_auto'		=> 'false',
			'doc_presentation_loop'		=> 'false',
			'doc_presentation_speed'	=> 10000,
			'doc_frame_type'			=> '',
			'doc_frame_thick'			=> 1,
			'doc_frame_color'			=> '#dddddd',
			'margin_top'                => 0,
			'margin_bottom'             => 0,
			'el_id' 					=> '',
			'el_class'                  => '',
			'css'						=> '',
		), $atts ));
	
		if (!empty($el_id)) {
			$doc_frame_id				= $el_id;
		} else {
			$doc_frame_id				= 'ts-vcsc-google-doc-' . mt_rand(999999, 9999999);
		}
		
		if ($doc_frame_type != '') {
			$doc_frame_class 	        = ' frame-enabled';
			$doc_frame_style 	        = ' border: ' . $doc_frame_thick . 'px ' . $doc_frame_type . ' ' . $doc_frame_color . ';';
		} else {
			$doc_frame_class			= '';
			$doc_frame_style			= '';
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Google-Docs', $atts);
		} else {
			$css_class	= '';
		}
		
		if ($doc_share == "true") {
			if ($doc_type == "document") {
				$url_doc = 'https://docs.google.com/document/d/' . $doc_key . '/edit?usp=sharing?embedded=true';
				$output = '<iframe id="' . $doc_frame_id . '" class="ts-google-doc ' . $el_class . '' . $doc_frame_class . ' ' . $css_class . '" style="width: 100%; height: ' . $doc_height . 'px; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;' . $doc_frame_style . '" width="100%" height="' . $doc_height . '" frameborder="0" src="' . $url_doc . '"></iframe>';
			} else if ($doc_type == "presentation") {
				$url_doc = 'https://docs.google.com/presentation/d/' . $doc_key . '/edit?usp=sharing?embedded=true';
				$output = '<iframe id="' . $doc_frame_id . '" class="ts-google-doc ' . $el_class . '' . $doc_frame_class . ' ' . $css_class . '" style="width: 100%; height: ' . $doc_height . 'px; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;' . $doc_frame_style . '" width="100%" height="' . $doc_height . '" frameborder="0" src="' . $url_doc . '"></iframe>';
			} else if ($doc_type == "spreadsheet") {
				$url_doc = 'https://docs.google.com/spreadsheet/ccc?key=' . $doc_key . '&usp=sharing?embedded=true';
				$output = '<iframe id="' . $doc_frame_id . '" class="ts-google-doc ' . $el_class . '' . $doc_frame_class . ' ' . $css_class . '" style="width: 100%; height: ' . $doc_height . 'px; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;' . $doc_frame_style . '" width="100%" height="' . $doc_height . '" frameborder="0" src="' . $url_doc . '"></iframe>';
			} else if ($doc_type == "drawing") {
				$url_doc = 'https://docs.google.com/drawings/d/' . $doc_key . '/edit?usp=sharing?embedded=true';
				$output = '<iframe id="' . $doc_frame_id . '" class="ts-google-doc ' . $el_class . '' . $doc_frame_class . ' ' . $css_class . '" style="width: 100%; height: ' . $doc_height . 'px; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;' . $doc_frame_style . '" width="100%" height="' . $doc_height . '" frameborder="0" src="' . $url_doc . '"></iframe>';
			} else if ($doc_type == "form") {
				$url_doc = 'https://docs.google.com/forms/d/' . $doc_key . '/viewform?embedded=true';
				$output = '<iframe id="' . $doc_frame_id . '" class="ts-google-doc ' . $el_class . '' . $doc_frame_class . ' ' . $css_class . '" style="width: 100%; height: ' . $doc_height . 'px; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;' . $doc_frame_style . '" width="100%" height="' . $doc_height . '" frameborder="0" src="' . $url_doc . '">Loading...</iframe>';
			}
		} else {
			if ($doc_type == "document") {
				$url_doc = 'https://docs.google.com/document/d/' . $doc_key . '/pub?embedded=true';
				$output = '<iframe id="' . $doc_frame_id . '" class="ts-google-doc ' . $el_class . '' . $doc_frame_class . ' ' . $css_class . '" style="width: 100%; height: ' . $doc_height . 'px; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;' . $doc_frame_style . '" width="100%" height="' . $doc_height . '" frameborder="0" src="' . $url_doc . '"></iframe>';
			} else if ($doc_type == "presentation") {
				$url_doc = 'https://docs.google.com/presentation/d/' . $doc_key . '/embed?start=' . $doc_presentation_auto . '&loop=' . $doc_presentation_loop . '&delayms=' . $doc_presentation_speed . '';
				$output = '<iframe id="' . $doc_frame_id . '" class="ts-google-doc ' . $el_class . '' . $doc_frame_class . ' ' . $css_class . '" style="width: 100%; height: ' . $doc_height . 'px; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;' . $doc_frame_style . '" src="' . $url_doc . '" frameborder="0" width="100%" height="' . $doc_height . '" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>';
			} else if ($doc_type == "spreadsheet") {
				$url_doc = 'https://docs.google.com/spreadsheet/pub?key=' . $doc_key . '&output=html&widget=true';
				$output = '<iframe id="' . $doc_frame_id . '" class="ts-google-doc ' . $el_class . '' . $doc_frame_class . ' ' . $css_class . '" style="width: 100%; height: ' . $doc_height . 'px; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;' . $doc_frame_style . '" width="100%" height="' . $doc_height . '" frameborder="0" src="' . $url_doc . '"></iframe>';
			} else if ($doc_type == "drawing") {
				$url_doc = 'https://docs.google.com/drawings/d/' . $doc_key . '/pub?w=2048&amp;h=1536';
				$output = '<img id="' . $doc_frame_id . '" class="ts-google-doc ' . $el_class . '' . $doc_frame_class . ' ' . $css_class . '" style="width: 100%; height: auto; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;' . $doc_frame_style . '" src="' . $url_doc . '">';
			} else if ($doc_type == "form") {
				$url_doc = 'https://docs.google.com/forms/d/' . $doc_key . '/viewform?embedded=true';
				$output = '<iframe id="' . $doc_frame_id . '" class="ts-google-doc ' . $el_class . '' . $doc_frame_class . ' ' . $css_class . '" style="width: 100%; height: ' . $doc_height . 'px; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;' . $doc_frame_style . '" width="100%" height="' . $doc_height . '" frameborder="0" src="' . $url_doc . '">Loading...</iframe>';
			}
		}
	
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_Google_Docs extends WPBakeryShortCode {};
	}
?>