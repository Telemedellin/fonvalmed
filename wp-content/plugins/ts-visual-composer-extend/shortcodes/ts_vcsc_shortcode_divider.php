<?php
	add_shortcode('TS-VCSC-Divider', 'TS_VCSC_Divider_Function');
	add_shortcode('TS_VCSC_Divider', 'TS_VCSC_Divider_Function');
	function TS_VCSC_Divider_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');

		extract( shortcode_atts( array(
			'divider_type'				=> 'ts-divider-border',
			
			'divider_border_type'		=> 'solid',
			'divider_border_thick'		=> 1,
			'divider_border_color'		=> '#eeeeee',
			'divider_border_responsive'	=> 'true',
			'divider_border_width'		=> 100,
			'divider_border_fixed'		=> 100,
			'divider_border_radius'		=> '',
			'divider_border_background'	=> '#F2F2F2',
			
			'divider_text_position'		=> 'center',
			'divider_text_content'		=> '',
			'divider_text_color'		=> '#676767',
			'divider_text_border'		=> '#eeeeee',
			'divider_text_size'			=> 20,
			
			'divider_image_position'	=> 'center',
			'divider_image_content'		=> '',
			'divider_image_border'		=> '#eeeeee',
			'divider_image_repeat'		=> 1,
			'divider_image_size'		=> 40,
			
			'divider_icon_position'		=> 'center',
			'divider_icon_content'		=> '',
			'divider_icon_color'		=> '#cccccc',
			'divider_icon_border'		=> '#eeeeee',
			'divider_icon_repeat'		=> 1,
			'divider_icon_size'			=> 40,

			'divider_top_content'		=> '',
			'divider_top_color'			=> '#eeeeee',
			'divider_top_border'		=> '#eeeeee',
			
			'margin_top'				=> 20,
			'margin_bottom'				=> 20,
			'el_id'						=> '',
			'el_class'					=> '',
			'css'						=> '',
		), $atts ));

		if (!empty($el_id)) {
			$divider_id					= $el_id;
		} else {
			$divider_id					= 'ts-vcsc-divider-' . mt_rand(999999, 9999999);
		}

		if ((!empty($divider_image_content)) && ($divider_type == "ts-divider-images")) {
			$divider_image_content_path			= wp_get_attachment_image_src($divider_image_content, 'large');
		}
		
		if ($divider_border_responsive == 'true') {
			$divider_width				= $divider_border_width . '%';
		} else {
			$divider_width				= $divider_border_fixed . 'px';
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-divider-holder ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Divider', $atts);
		} else {
			$css_class	= 'ts-divider-holder';
		}
		
		$output = '';

		if ($divider_type == "ts-divider-border") {
			$divider_border 			= 'width: ' . $divider_width . '; border-top: ' . $divider_border_thick . 'px ' . $divider_border_type . ' ' . $divider_border_color . ';';
			$output .= '<div id="' . $divider_id . '" class="' . $css_class . ' ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-border" style="' . $divider_border . '"></div></div>';
		} else if ($divider_type == "ts-divider-lines") {
			$divider_border 			= 'width: ' . $divider_width . '; border-bottom: ' . $divider_border_thick . 'px ' . $divider_border_type . ' ' . $divider_text_border . ';';
			if ($divider_text_position == "center") {
				$output .= '<div id="' . $divider_id . '" class="' . $css_class . ' ' . $el_class . '" data-border-width="' . $divider_border_thick . '" data-margin-top="' . $margin_top . '" data-margin-bottom="' . $margin_bottom . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-lines" style="' . $divider_border . ';"><div class="ts-divider-text center" style="font-size: ' . $divider_text_size . 'px; line-height: ' . ($divider_text_size + $divider_text_size / 4) . 'px;"><div class="ts-center-help ' . $divider_border_radius . '" style="background: ' . $divider_border_background . '; font-size: ' . $divider_text_size . 'px; line-height: ' . ($divider_text_size + $divider_text_size / 4) . 'px; color: ' . $divider_text_color . '; margin-top: ' . ($divider_border_thick / 2) . 'px;">' . $divider_text_content . '</div></div></div></div>';
			} else if ($divider_text_position == "right") {
				$output .= '<div id="' . $divider_id . '" class="' . $css_class . ' ' . $el_class . '" data-border-width="' . $divider_border_thick . '" data-margin-top="' . $margin_top . '" data-margin-bottom="' . $margin_bottom . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-lines" style="' . $divider_border . ';"><div class="ts-divider-text right" style="font-size: ' . $divider_text_size . 'px; line-height: ' . ($divider_text_size + $divider_text_size / 4) . 'px;"><div class="ts-right-help ' . $divider_border_radius . '" style="background: ' . $divider_border_background . '; font-size: ' . $divider_text_size . 'px; line-height: ' . ($divider_text_size + $divider_text_size / 4) . 'px; color: ' . $divider_text_color . '; margin-top: ' . ($divider_border_thick / 2) . 'px;">' . $divider_text_content . '</div></div></div></div>';
			} else if ($divider_text_position == "left"){
				$output .= '<div id="' . $divider_id . '" class="' . $css_class . ' ' . $el_class . '" data-border-width="' . $divider_border_thick . '" data-margin-top="' . $margin_top . '" data-margin-bottom="' . $margin_bottom . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-lines" style="' . $divider_border . ';"><div class="ts-divider-text left" style="font-size: ' . $divider_text_size . 'px; line-height: ' . ($divider_text_size + $divider_text_size / 4) . 'px;"><div class="ts-left-help ' . $divider_border_radius . '" style="background: ' . $divider_border_background . '; font-size: ' . $divider_text_size . 'px; line-height: ' . ($divider_text_size + $divider_text_size / 4) . 'px; color: ' . $divider_text_color . '; margin-top: ' . ($divider_border_thick / 2) . 'px;">' . $divider_text_content . '</div></div></div></div>';
			}
		} else if ($divider_type == "ts-divider-images") {
			$divider_border 			= 'width: ' . $divider_width . '; border-bottom: ' . $divider_border_thick . 'px ' . $divider_border_type . ' ' . $divider_image_border . ';';
			$imagestyle 				= 'font-size: ' . $divider_image_size . 'px; line-height: ' . $divider_image_size . 'px; height: ' . $divider_image_size . 'px; width: ' . $divider_image_size . 'px;';
			$imagerepeat				= '';
			for ($x = 1; $x <= $divider_image_repeat; $x++) {
				$imagerepeat			.= '<img src="' . $divider_image_content_path[0] . '" style="' . $imagestyle . '">';
			}
			if ($divider_image_position == "center") {
				$output .= '<div id="' . $divider_id . '" class="' . $css_class . ' ' . $el_class . '" data-border-width="' . $divider_border_thick . '" data-margin-top="' . $margin_top . '" data-margin-bottom="' . $margin_bottom . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-images" style="' . $divider_border . ';"><div class="ts-divider-text center"><div class="ts-center-help ' . $divider_border_radius . '" style="height: ' . $divider_image_size . 'px; margin-top: ' . ($divider_border_thick / 2) . 'px; background: ' . $divider_border_background . '">' . $imagerepeat . '</div></div></div></div>';
			} else if ($divider_image_position == "right") {
				$output .= '<div id="' . $divider_id . '" class="' . $css_class . ' ' . $el_class . '" data-border-width="' . $divider_border_thick . '" data-margin-top="' . $margin_top . '" data-margin-bottom="' . $margin_bottom . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-images" style="' . $divider_border . ';"><div class="ts-divider-text right"><div class="ts-right-help ' . $divider_border_radius . '" style="height: ' . $divider_image_size . 'px; margin-top: ' . ($divider_border_thick / 2) . 'px; background: ' . $divider_border_background . '">' . $imagerepeat . '</div></div></div></div>';
			} else if ($divider_image_position == "left") {
				$output .= '<div id="' . $divider_id . '" class="' . $css_class . ' ' . $el_class . '" data-border-width="' . $divider_border_thick . '" data-margin-top="' . $margin_top . '" data-margin-bottom="' . $margin_bottom . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-images" style="' . $divider_border . ';"><div class="ts-divider-text left"><div class="ts-left-help ' . $divider_border_radius . '" style="height: ' . $divider_image_size . 'px; margin-top: ' . ($divider_border_thick / 2) . 'px; background: ' . $divider_border_background . '">' . $imagerepeat . '</div></div></div></div>';
			}
		} else if ($divider_type == "ts-divider-icons") {
			$divider_border 			= 'width: ' . $divider_width . '; border-bottom: ' . $divider_border_thick . 'px ' . $divider_border_type . ' ' . $divider_icon_border . ';';
			$iconstyle 					= 'color: ' . $divider_icon_color . '; margin: 0; font-size: ' . $divider_icon_size . 'px; line-height: ' . $divider_icon_size . 'px; height: ' . $divider_icon_size . 'px; width: ' . $divider_icon_size . 'px;';
			$iconrepeat					= '';
			for ($x = 1; $x <= $divider_icon_repeat; $x++) {
				$iconrepeat				.= '<i class="ts-font-icon ' . $divider_icon_content . '" style="' . $iconstyle . '"></i>';
			}
			if ($divider_icon_position == "center") {
				$output .= '<div id="' . $divider_id . '" class="' . $css_class . ' ' . $el_class . '" data-border-width="' . $divider_border_thick . '" data-margin-top="' . $margin_top . '" data-margin-bottom="' . $margin_bottom . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-icons" style="' . $divider_border . ';"><div class="ts-divider-text center"><div class="ts-center-help ' . $divider_border_radius . '" style="height: ' . $divider_icon_size . 'px; margin-top: ' . ($divider_border_thick / 2) . 'px; background: ' . $divider_border_background . '">' . $iconrepeat . '</div></div></div></div>';
			} else if ($divider_icon_position == "right") {
				$output .= '<div id="' . $divider_id . '" class="' . $css_class . ' ' . $el_class . '" data-border-width="' . $divider_border_thick . '" data-margin-top="' . $margin_top . '" data-margin-bottom="' . $margin_bottom . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-icons" style="' . $divider_border . ';"><div class="ts-divider-text right"><div class="ts-right-help ' . $divider_border_radius . '" style="height: ' . $divider_icon_size . 'px; margin-top: ' . ($divider_border_thick / 2) . 'px; background: ' . $divider_border_background . '">' . $iconrepeat . '</div></div></div></div>';
			} else if ($divider_icon_position == "left") {
				$output .= '<div id="' . $divider_id . '" class="' . $css_class . ' ' . $el_class . '" data-border-width="' . $divider_border_thick . '" data-margin-top="' . $margin_top . '" data-margin-bottom="' . $margin_bottom . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-icons" style="' . $divider_border . ';"><div class="ts-divider-text left"><div class="ts-left-help ' . $divider_border_radius . '" style="height: ' . $divider_icon_size . 'px; margin-top: ' . ($divider_border_thick / 2) . 'px; background: ' . $divider_border_background . '">' . $iconrepeat . '</div></div></div></div>';
			}
		} else if ($divider_type == "ts-divider-top") {
			$divider_border 			= 'width: ' . $divider_width . '; border-bottom: ' . $divider_border_thick . 'px ' . $divider_border_type . ' ' . $divider_top_border . ';';
			if (!empty($divider_top_content)) {
				$output .= '<div id="' . $divider_id . '" class="' . $css_class . ' ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-top" style="' . $divider_border . '"><a href="#top" class="ts-to-top ' . $divider_border_radius . '" style="background: ' . $divider_border_background . ';"><span class="ts-to-top-text">' . $divider_top_content . '</span><span class="ts-to-top-icon"></span></a></div></div>';
			} else {
				$output .= '<div id="' . $divider_id . '" class="' . $css_class . ' ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-top" style="' . $divider_border . '"><a href="#top" class="ts-to-top ' . $divider_border_radius . '" style="background: ' . $divider_border_background . ';"><span class="ts-to-top-icon"></span></a></div></div>';
			}
		} else {
			$output = '<div id="' . $divider_id . '" class="' . $css_class . ' ' . $el_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"><div class="ts-divider-simple ' . $divider_type . '" style="width: ' . $divider_width . ';"></div></div>';
		}
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_Divider extends WPBakeryShortCode {};
	}
?>