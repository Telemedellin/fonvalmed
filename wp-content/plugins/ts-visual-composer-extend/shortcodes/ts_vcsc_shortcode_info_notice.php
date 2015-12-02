<?php
	add_shortcode('TS_VCSC_Info_Notice', 'TS_VCSC_Info_Notice_Function');
	function TS_VCSC_Info_Notice_Function ($atts, $content = null) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
	
		extract( shortcode_atts( array(
			'icon_replace'					=> 'false',
			'panel_layout'					=> 'info',
			'panel_type'					=> 'normal',
			'panel_icon'					=> '',
			'panel_image'					=> '',
			'panel_size'					=> 50,
			'panel_spacer'					=> 15,
			'panel_title'					=> '',
			'font_title_family'				=> 'Default',
			'font_title_type'				=> '',
			'font_content_family'			=> 'Default',
			'font_content_type'				=> '',
			'color_icon'					=> '#cccccc',
			'color_title'					=> '#666666',
			'color_border'					=> '#cccccc',
			'color_background'				=> '#ffffff',
			'animations'                	=> 'false',
			'animation_effect'				=> 'ts-hover-css-',
			'animation_class'				=> '',
			'margin_top'                	=> 0,
			'margin_bottom'             	=> 0,
			'el_id' 						=> '',
			'el_class'                  	=> '',
			'css'							=> '',
		), $atts ));
		
		if (!empty($el_id)) {
			$info_panel_id					= $el_id;
		} else {
			$info_panel_id					= 'ts-info-notice-panel-' . mt_rand(999999, 9999999);
		}
		
		$output = $notice = $visible = '';
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Info_Notice', $atts);
		} else {
			$css_class	= '';
		}
		
		if ($panel_type == "custom") {
			if ($panel_layout == "info") {
				$custom_color_icon			= 'color: ' . $color_icon . ';';
				$custom_color_title			= 'color: ' . $color_title . ';';
				$custom_color_border		= 'border-color: ' . $color_border . ';';
				$custom_color_background	= 'background-color: ' . $color_background . ';';
			} else {
				$custom_color_icon			= 'color: ' . $color_icon . ';';
				$custom_color_title			= 'color: ' . $color_title . ';';
				$custom_color_border		= 'border-color: ' . $color_border . ';';
				$custom_color_background	= 'background-color: ' . $color_background . ';';
			}
		} else {
			$custom_color_icon				= '';
			$custom_color_title				= '';
			$custom_color_border			= '';
			$custom_color_background		= '';
		}
		
		if (!empty($animation_class)) {
			$animation_icon					= $animation_effect . $animation_class;
		} else {
			$animation_icon					= '';
		}
		
		// Custom Font Settings
		if (strpos($font_title_family, 'Default') === false) {
			$google_font_title				= TS_VCSC_GetFontFamily($info_panel_id . " .ts-" . $panel_layout . "-panel-info-title", $font_title_family, $font_title_type, false, true, false);
		} else {
			$google_font_title				= '';
		}
		if (strpos($font_content_family, 'Default') === false) {
			$google_font_content			= TS_VCSC_GetFontFamily($info_panel_id . " .ts-" . $panel_layout . "-panel-info-main", $font_content_family, $font_content_type, false, true, false);
		} else {
			$google_font_content			= '';
		}
		
		$output .= '<div id="' . $info_panel_id . '" class="ts-info-notice-panel-main ' . $el_class . ' ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
			$output .= '<div class="ts-' . $panel_layout . '-panel-wrapper ts-' . $panel_layout . '-panel-' . $panel_type . '" style="' . $custom_color_background . ' ' . $custom_color_border . '">';
				$output .= '<div class="ts-' . $panel_layout . '-panel-field">';
					if ($icon_replace == "false") {
						if (($panel_icon != "") && ($panel_icon != "transparent")) {
							$output .= '<div class="ts-' . $panel_layout . '-panel-info-icon" style="width: ' . $panel_size . 'px;"><i class="' . $panel_icon . ' ' . $animation_icon . '" style="font-size: ' . $panel_size . 'px; line-height: ' . $panel_size . 'px; ' . $custom_color_icon . '"></i></div>';
							$output .= '<div class="ts-' . $panel_layout . '-panel-info-spacer" style="width: ' . $panel_spacer . 'px;"></div>';
						}
					} else {
						if ($panel_image != "") {
							$panel_image		= wp_get_attachment_image_src($panel_image, 'medium');
							$output .= '<div class="ts-' . $panel_layout . '-panel-info-icon" style="width: ' . $panel_size . 'px;"><img class="' . $animation_icon . '" src="' . $panel_image[0] . '" style="width: ' . $panel_size . 'px; height: ' . $panel_size . 'px;"></div>';
							$output .= '<div class="ts-' . $panel_layout . '-panel-info-spacer" style="width: ' . $panel_spacer . 'px;"></div>';
						}
					}			
					$output .= '<div class="ts-' . $panel_layout . '-panel-info-desc">';
						if ($panel_title != '') {
							$output .= '<div class="ts-' . $panel_layout . '-panel-info-title" style="' . $custom_color_title . ' ' . $google_font_title . '">' . $panel_title . '</div>';
						}
						if (function_exists('wpb_js_remove_wpautop')){
							$output .= '<div class="ts-' . $panel_layout . '-panel-info-main" style="' . $google_font_content . '">' . wpb_js_remove_wpautop(do_shortcode($content), true) . '</div>';
						} else {
							$output .= '<div class="ts-' . $panel_layout . '-panel-info-main" style="' . $google_font_content . '">' . do_shortcode($content) . '</div>';
						}
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>