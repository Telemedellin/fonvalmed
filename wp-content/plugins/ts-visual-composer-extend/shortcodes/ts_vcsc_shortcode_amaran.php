<?php
	add_shortcode('TS_VCSC_Amaran_Popup', 'TS_VCSC_Amaran_Popup_Function');
	function TS_VCSC_Amaran_Popup_Function ($atts, $content = null) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
		
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndWaypoints == "true") {
			if (wp_script_is('waypoints', $list = 'registered')) {
				wp_enqueue_script('waypoints');
			} else {
				wp_enqueue_script('ts-extend-waypoints');
			}
		}		
		wp_enqueue_style('ts-extend-amaran');
		wp_enqueue_script('ts-extend-amaran');		
		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
	
		extract(shortcode_atts(array(
			'position'					=> 'top left',
			'width'						=> 400,
			'viewport_trigger'			=> 'false',
			'viewport_once'				=> 'true',
			'viewport_wait'				=> 10000,
			'overlay'					=> 'false',
			'overlay_color'				=> '#000000',
			'raster_use'				=> 'false',
			'raster_type'				=> '',
			'background'				=> '#ffffff',
			'entry'						=> 'fadeIn',
			'entry_animation_class'		=> '',
			'entry_css3animations_in'	=> '',
			'exit'						=> 'fadeOut',
			'exit_animation_class'		=> '',
			'exit_css3animations_in'	=> '',
			'sticky'					=> 'false',
			'button'					=> 'true',
			'buttonColor'				=> '#555555',
			'close'						=> 'true',
			'clear'						=> 'clearall',
			'mobile'					=> 'false',
			'icon_replace'				=> 'false',
			'icon'						=> '',
			'icon_color'				=> '#2980b9',
			'icon_image'				=> '',
			'title'						=> '',
			'title_background'			=> '#ededed',
			'title_color'				=> '#555555',
			'info'						=> '',
			'info_background'			=> '#555555',
			'info_color'				=> '#ededed',
			'delay'						=> 0,
			'duration'					=> 5000,
			'margin_top'				=> 10,
			'margin_bottom'				=> 10,
			'margin_left'				=> 10,
			'margin_right'				=> 10,
			'animations'                => 'false',
			'animation_effect'			=> 'ts-hover-css-',
			'animation_class'			=> '',
			'css'						=> '',
		), $atts ));
		
		$randomizer						= mt_rand(999999, 9999999);
		$amaran_id						= 'ts-vcsc-amaran-popup-' . $randomizer;
		
		$output = $notice = $visible = '';
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Amaran_Popup', $atts);
		} else {
			$css_class	= '';
		}
		
		if (!empty($icon_image)) {
			$icon_image_path 			= wp_get_attachment_image_src($icon_image, 'large');
			$icon_image_path			= $icon_image_path[0];
		} else {
			$icon_image_path			= '';
		}
		
		if ($clear == "clearnone") {
			$clearAll					= 'false';
			$clearSticky				= 'false';
		} else if ($clear == "nonsticky") {
			$clearAll					= 'true';
			$clearSticky				= 'false';
		} else if ($clear == "clearall") {
			$clearAll					= 'true';
			$clearSticky				= 'true';
		} else {
			$clearAll					= 'false';
			$clearSticky				= 'false';
		}
		
		if ((!empty($animation_class)) && ($animations == "true")) {
			$animation_icon				= $animation_effect . $animation_class;
		} else {
			$animation_icon				= '';
		}
		
		$margin_data					= 'data-top="'  .$margin_top . '" data-bottom="'  .$margin_bottom . '" data-left="'  .$margin_left . '" data-right="'  .$margin_right . '"';
		$color_data						= 'data-background="' . $background . '" data-buttoncolor="' . $buttonColor . '" data-iconcolor="' . $icon_color . '" data-titlecolor="' . $title_color . '" data-titlebackground="' . $title_background . '" data-infocolor="' . $info_color . '" data-infobackground="' . $info_background . '"';
		$overlay_data					= 'data-overlay="' . $overlay . '" data-overlaycolor="' . $overlay_color . '" data-rasteruse="' . $raster_use . '" data-rastertype="' . $raster_type . '"';
		$viewport_data					= 'data-viewport="' . $viewport_trigger . '" data-viewportonce="' . $viewport_once . '" data-viewportlast="0" data-viewportwait="' . $viewport_wait . '"';
		
		$output .= '<div id="' . $amaran_id . '" class="ts-amaran-popup-main ' . $css_class . '" style="" data-randomizer="' . $randomizer . '" ' . $overlay_data . ' data-position="' . $position . '" data-width="' . $width . '" ' . $viewport_data . ' data-entry="' . $entry . '" data-entryanimate="' . $entry_animation_class . '" data-exit="' . $exit . '" data-exitanimate="' . $exit_animation_class . '" data-sticky="' . $sticky . '" data-button="' . $button . '" data-close="' . $close . '" data-clearall="' . $clearAll . '" data-clearsticky="' . $clearSticky . '" data-mobile="' . $mobile . '" data-delay="' . $delay . '" data-duration="' . $duration . '" data-icon="' . $icon . '" data-image="' . $icon_image_path . '" data-iconanimate="' . $animation_icon . '" data-title="' . $title . '" data-info="' . $info . '" ' . $margin_data . ' ' . $color_data . '>';
			if (function_exists('wpb_js_remove_wpautop')){
				$output .= '<div class="ts-amaran-popup-content">' . wpb_js_remove_wpautop(do_shortcode($content), true) . '</div>';
			} else {
				$output .= '<div class="ts-amaran-popup-content">' . do_shortcode($content) . '</div>';
			}
		$output .= '</div>';
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>