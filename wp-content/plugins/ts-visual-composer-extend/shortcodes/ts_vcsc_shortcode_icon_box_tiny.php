<?php
	add_shortcode('TS-VCSC-Icon-Box-Tiny', 'TS_VCSC_Font_Iconbox_Tiny_Function');
	add_shortcode('TS_VCSC_Icon_Box_Tiny', 'TS_VCSC_Font_Iconbox_Tiny_Function');
	function TS_VCSC_Font_Iconbox_Tiny_Function ($atts, $content = null) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract(shortcode_atts( array(
			'style'                     => 'icon_left',
			'height'					=> 'auto',
			'min_height'				=> 200,
			'max_height'				=> 200,
			'fix_height'				=> 200,
			'title'                     => '',
			'title_size'                => '25',
			'title_weight'              => 'inherit',
			'title_color'               => '#000000',
			'title_align'               => 'center',
			'title_margin'              => 0,
			'title_wrap'				=> 'div',
			'line_height'				=> 14,
			'font_size'					=> 14,
			'padding_top'				=> 10,
			'padding_bottom'			=> 10,
			'padding_left'				=> 10,
			'padding_right'				=> 10,
			'padding_custom'			=> 'false',
			'padding_outside'			=> 60,
			'icon'                      => '',
			'icon_location'             => 'left',
			'icon_placement'			=> 'center',
			'icon_size_slide'           => 36,
			'icon_margin'				=> 10,
			'icon_color'                => '#000000',
			'icon_background'		    => '',
			'icon_frame_type' 			=> '',
			'icon_frame_thick'			=> 1,
			'icon_frame_radius'			=> '',
			'icon_frame_color'			=> '#000000',
			'icon_replace'				=> 'false',
			'icon_image'				=> '',
			'icon_padding'				=> 5,
			'box_background_type'       => 'color',
			'box_background_color'      => '#ffffff',
			'box_background_pattern'    => '',
			'box_background_image'		=> '',
			'box_background_size'		=> 'cover',
			'box_background_repeat'		=> 'no-repeat',
			'box_border_controls'		=> 'false',
			'box_border_type'           => '',
			'box_border_color'          => '#000000',
			'box_border_thick'          => 1,
			'box_border_radius'         => '',
			'box_border_setting'		=> '',
			'font_title_family'			=> 'Default',
			'font_title_type'			=> '',
			'font_content_family'		=> 'Default',
			'font_content_type'			=> '',
			'font_button_family'		=> 'Default',
			'font_button_type'			=> '',
			'separator_type'			=> '',
			'separator_thick'			=> 1,
			'separator_color'			=> '#000000',
			'read_more_link'            => 'false',
			'read_more_txt'             => '',
			'read_more_url'             => '',
			'read_more_target'          => '_parent',
			'read_more_type'			=> 'basic',
			'read_more_style'           => 1,
			'read_more_flat_default'	=> 'ts-dual-buttons-color-default',
			'read_more_flat_hover'		=> 'ts-dual-buttons-preview-default ts-dual-buttons-hover-default',
			'read_more_width'			=> 50,
			'read_more_align'			=> 'center',
			'tooltip_content'			=> '',
			'tooltip_position'			=> 'ts-simptip-position-top',
			'tooltip_style'				=> '',
			'tooltipster_offsetx'		=> 0,
			'tooltipster_offsety'		=> 0,
			'animations'                => 'false',
			'animation_effect'			=> 'ts-hover-css-',
			'animation_class'			=> '',
			'animation_box'             => '',
			'animation_shadow'          => '',
			'animation_view'            => '',
			'margin_top'                => 0,
			'margin_bottom'             => 0,
			'el_id' 					=> '',
			'el_class'                  => '',
			'css'						=> '',
		), $atts ) );
		
		$output = $icon_style = $icon_frame_style = $icon_frame_class = $icon_frame_adjust = $box_frame_adjust = $box_frame_style = $separator_style = $animation_css = "";
		$icon_frame_top = $icon_frame_left = $box_margin_left = $box_padding_left = "0px";
		
		$icon_padding_vertical          = $icon_padding;
		$icon_padding_horizontal        = $icon_padding;
		
		if (!empty($el_id)) {
			$icon_box_id				= $el_id;
		} else {
			$icon_box_id				= 'ts-vcsc-box-icon-' . mt_rand(999999, 9999999);
		}
	
		if (!empty($icon_image)) {
			$icon_image_path 			= wp_get_attachment_image_src($icon_image, 'large');
		}
	
		$icon_style                     = 'padding: ' . $icon_padding_vertical . 'px ' . $icon_padding_horizontal . 'px; background-color:' . $icon_background . '; width: ' . $icon_size_slide . 'px; height: ' . $icon_size_slide . 'px; font-size: ' . $icon_size_slide . 'px; line-height: ' . $icon_size_slide . 'px;';
		$icon_image_style				= 'padding: ' . $icon_padding_vertical . 'px ' . $icon_padding_horizontal . 'px; background-color:' . $icon_background . '; width: ' . $icon_size_slide . 'px; height: ' . $icon_size_slide . 'px; font-size: ' . $icon_size_slide . 'px; line-height: ' . $icon_size_slide . 'px;';
		
		// Tooltip
		if (($tooltip_position == "ts-simptip-position-top") || ($tooltip_position == "top")) {
			$tooltip_position			= "top";
		}
		if (($tooltip_position == "ts-simptip-position-left") || ($tooltip_position == "left")) {
			$tooltip_position			= "left";
		}
		if (($tooltip_position == "ts-simptip-position-right") || ($tooltip_position == "right")) {
			$tooltip_position			= "right";
		}
		if (($tooltip_position == "ts-simptip-position-bottom") || ($tooltip_position == "bottom")) {
			$tooltip_position			= "bottom";
		}
		$tooltipclasses					= 'ts-has-tooltipster-tooltip';		
		if (($tooltip_style == "") || ($tooltip_style == "ts-simptip-style-black") || ($tooltip_style == "tooltipster-black")) {
			$tooltip_style				= "tooltipster-black";
		}
		if (($tooltip_style == "ts-simptip-style-gray") || ($tooltip_style == "tooltipster-gray")) {
			$tooltip_style				= "tooltipster-gray";
		}
		if (($tooltip_style == "ts-simptip-style-green") || ($tooltip_style == "tooltipster-green")) {
			$tooltip_style				= "tooltipster-green";
		}
		if (($tooltip_style == "ts-simptip-style-blue") || ($tooltip_style == "tooltipster-blue")) {
			$tooltip_style				= "tooltipster-blue";
		}
		if (($tooltip_style == "ts-simptip-style-red") || ($tooltip_style == "tooltipster-red")) {
			$tooltip_style				= "tooltipster-red";
		}
		if (($tooltip_style == "ts-simptip-style-orange") || ($tooltip_style == "tooltipster-orange")) {
			$tooltip_style				= "tooltipster-orange";
		}
		if (($tooltip_style == "ts-simptip-style-yellow") || ($tooltip_style == "tooltipster-yellow")) {
			$tooltip_style				= "tooltipster-yellow";
		}
		if (($tooltip_style == "ts-simptip-style-purple") || ($tooltip_style == "tooltipster-purple")) {
			$tooltip_style				= "tooltipster-purple";
		}
		if (($tooltip_style == "ts-simptip-style-pink") || ($tooltip_style == "tooltipster-pink")) {
			$tooltip_style				= "tooltipster-pink";
		}
		if (($tooltip_style == "ts-simptip-style-white") || ($tooltip_style == "tooltipster-white")) {
			$tooltip_style				= "tooltipster-white";
		}
		if (strip_tags($tooltip_content) != '') {
			wp_enqueue_style('ts-extend-tooltipster');
			wp_enqueue_script('ts-extend-tooltipster');	
			$Tooltip_Content			= 'data-tooltipster-html="true" data-tooltipster-title="" data-tooltipster-text="' . strip_tags($tooltip_content) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			$Tooltip_Class				= 'ts-has-tooltipster-tooltip';
		} else {
			$Tooltip_Content			= '';
			$Tooltip_Class				= '';
		}
		
		if ($icon_frame_type != '') {
			$icon_frame_class 	        = 'frame-enabled';
			$icon_frame_style 	        = 'border: ' . $icon_frame_thick . 'px ' . $icon_frame_type . ' ' . $icon_frame_color . ';';
		}

		if ($style == "boxed_left") {
			$style 						= "boxed";
			$icon_location 				= "left";
		} else  if ($style == "boxed_top") {
			$style 						= "boxed";
			$icon_location 				= "top";
		}
		
		if ($style == "boxed") {
			if ($icon_location == "top") {
				$icon_frame_top         = '-' . ($icon_size_slide / 2 + $icon_padding_horizontal + $icon_frame_thick + 5) . 'px';
				$icon_frame_left        = '-' . ($icon_size_slide / 2 + $icon_padding_vertical + $icon_frame_thick) . 'px';
				$icon_frame_adjust      = 'top:' . $icon_frame_top . '; margin-left:' . $icon_frame_left . ';';
				$box_frame_adjust       = '';
				$shadow_frame_adjust    = '';
				if ($padding_custom == "true") {
					$box_padding_top	= 'padding-top: ' . $padding_outside . 'px;';
				} else {
					$box_padding_top	= '';
				}
				if ($separator_type != '') {
					$separator_style	= 'border-top: ' . $separator_thick . 'px ' . $separator_type . ' ' . $separator_color . '; padding-top: ' . abs(($icon_size_slide / 2 + $icon_padding_horizontal + $icon_frame_thick + 5)) . 'px;';
				}
			} else if ($icon_location == "left") {
				$icon_frame_left        = '-' . ($icon_size_slide / 2 + $icon_padding_horizontal + $icon_frame_thick + 5) . 'px';
				$icon_frame_top         = ((-$icon_size_slide / 2) - $icon_padding_vertical - $title_margin - $icon_frame_thick) . 'px';
				if ($icon_placement == 'center') {
					$icon_frame_adjust	= 'left:' . $icon_frame_left . '; margin-top:' . $icon_frame_top . ';';
				} else if ($icon_placement == 'top') {
					$icon_frame_adjust	= 'left:' . $icon_frame_left . '; top: 0px; bottom: auto;';
				} else if ($icon_placement == 'bottom') {
					$icon_frame_adjust	= 'left:' . $icon_frame_left . '; top: auto; bottom: 0px;';
				}
				$box_margin_left        = ($icon_size_slide / 2) . 'px';
				$box_padding_top		= '';
				if ($padding_custom == "true") {
					$box_padding_left	= $padding_outside . 'px';
				} else {
					$box_padding_left	= (($icon_size_slide / 2) + 30) . 'px';
				}				
				if ($box_border_type == '') {
					$box_frame_adjust	= 'margin-left: 0px; padding: 0 0 0 ' . $box_padding_left . ';';
				} else {
					$box_frame_adjust	= 'margin-left: 0px; padding-left: ' . $box_padding_left . ';';
				}
				$shadow_frame_adjust    = 'margin-left: ' . $box_margin_left . '; ';
				if ($separator_type != '') {
					$separator_style	= 'border-left: ' . $separator_thick . 'px ' . $separator_type . ' ' . $separator_color . '; padding-left: ' . abs(($icon_size_slide / 2 + $icon_padding_horizontal + $icon_frame_thick + 5)) . 'px;';
				}
			}
		}

		if ($box_background_type == "pattern") {
			$box_background_style		= 'background: url(' . $box_background_pattern . ') repeat;';
		} else if ($box_background_type == "color") {
			$box_background_style		= 'background-color: ' . $box_background_color .';';
		} else if ($box_background_type == "image") {
			$background_image			= wp_get_attachment_image_src($box_background_image, 'full');
			$background_image			= $background_image[0];
			$box_background_style		= 'background: transparent url(' . $background_image . ') ' . $box_background_repeat . ' center center; -webkit-background-size: ' . $box_background_size . '; -moz-background-size: ' . $box_background_size . '; -o-background-size: ' . $box_background_size . '; background-size: ' . $box_background_size . ';';
		}		
		
		if ($box_border_controls == "false") {
			if ($box_border_type != '') {
				$box_frame_style        = 'border: ' . $box_border_thick . 'px ' . $box_border_type . ' ' . $box_border_color . ';';
			} else {
				$box_frame_style		= '';
			}
		} else {
			$box_frame_style			= str_replace('|', '', $box_border_setting);
		}
		
		if ($style == "boxed") {
			$box_inner_padding			= '';
		} else {
			$box_inner_padding        	= 'padding: ' . $padding_top . 'px ' . $padding_right . 'px ' . $padding_bottom . 'px ' . $padding_left . 'px;';
		}		
		
		if (!empty($animation_class)) {
			$animation_icon				= $animation_effect . $animation_class;
		} else {
			$animation_icon				= '';
		}
		
		if ($animation_view != '') {
			$animation_css              = TS_VCSC_GetCSSAnimation($animation_view);
		}
		
		// Height Settings
		if ($height == 'minheight') {
			if ($min_height > 0) {
				$height_setting			= 'min-height: ' . $min_height . 'px;';
				$height_class			= 'ts-icon-box-minheight';
			} else {
				$height_setting			= '';
				$height_class			= '';
			}
		} else if ($height == 'maxheight') {
			if ($max_height > 0) {
				$height_setting			= 'max-height: ' . $max_height . 'px;';
				$height_class			= 'ts-icon-box-maxheight';
			} else {
				$height_setting			= '';
				$height_class			= '';
			}
		} else if ($height == 'fixheight') {
			if ($fix_height > 0) {
				$height_setting			= 'height: ' . $fix_height . 'px;';
				$height_class			= 'ts-icon-box-fixheight';
			} else {
				$height_setting			= '';
				$height_class			= '';
			}
		} else {
			$height_setting				= '';
			$height_class				= '';
		}
		
		// Custom Font Settings		
		if (strpos($font_title_family, 'Default') === false) {
			if ($style == "icon_left") {
				$google_font_title		= TS_VCSC_GetFontFamily($icon_box_id . " .ts-box-icon-title-text", $font_title_family, $font_title_type, false, true, false);
			} else {
				$google_font_title		= TS_VCSC_GetFontFamily($icon_box_id . " .ts-box-icon-title", $font_title_family, $font_title_type, false, true, false);
			}
		} else {
			$google_font_title			= '';
		}
		if (strpos($font_content_family, 'Default') === false) {
			$google_font_content		= TS_VCSC_GetFontFamily($icon_box_id . " .ts-icon-box-content", $font_content_family, $font_content_type, false, true, false);
		} else {
			$google_font_content		= '';
		}
		if (strpos($font_button_family, 'Default') === false) {
			$google_font_button			= TS_VCSC_GetFontFamily($icon_box_id . " .ts-icon-box-readmore", $font_button_family, $font_button_type, false, true, false);
		} else {
			$google_font_button			= '';
		}

		if ($read_more_type == "basic") {
			$read_more_button_style		= "style" . $read_more_style;
		} else if ($read_more_type == "flat") {
			wp_enqueue_style('ts-extend-buttonsdual');
			$read_more_button_style		= $read_more_flat_default . ' ' . $read_more_flat_hover;
		}		
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-vcsc-box-icon ' . $el_class . $animation_css . ' ' . $box_border_radius . ' ' . $style . '-style ts-box-icon ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Icon-Box-Tiny', $atts);
		} else {
			$css_class	= 'ts-vcsc-box-icon ' . $el_class . $animation_css . ' ' . $box_border_radius . ' ' . $style . '-style ts-box-icon';
		}

		if (($read_more_url != '') && ($read_more_link == "box")) {
			$output .= '<a class="ts-box-icon-link" style="color:' . $title_color . ';" href="'.$read_more_url.'" target="' . $read_more_target . '">';
		}
			$output .= '<div id="' . $icon_box_id . '" class="' . $css_class . ' ' . $Tooltip_Class . '" ' . $Tooltip_Content . ' style="margin-bottom:' . $margin_bottom . 'px; margin-top:' . $margin_top . 'px;">';
				$output .= (!empty($animation_box) ? '<div class="ts-hover ' . $animation_box . '">' : '');
					if ($style == "icon_left") {
						$output .= '<div class="ts-css-shadow ' . $animation_shadow . ' ' . $box_border_radius . '" style="' . $box_background_style . '">';
							$output .= '<div class="ts-icon-box-inner box-detail-wrapper ' . $box_border_radius . ' ' . $height_class . '" style="' . $box_frame_style . ' ' . $box_inner_padding . ' ' . $height_setting . '">';
								$output .= '<div class="ts-box-icon-title-holder" style="display: table; margin: 0 auto; float: ' . ($title_align == 'center' ? 'none' : $title_align) . ';">';
									if ($icon_replace == 'false') {
										if (!empty($icon)) {
											$output .= '<i class="ts-box-icon-title-icon ' . $icon . ' ts-main-ico ts-font-icon ' . $icon_frame_radius . ' ' . $icon_frame_class . ' ' . $animation_icon .'" style="margin-left: 0; margin-right: ' . $icon_margin . 'px; color:' . $icon_color . ';' . $icon_style . ' ' . $icon_frame_style . '"></i>';
										}
									} else {
										if (!empty($icon_image)) {
											$output .= '<div style="width: auto !important; display: table-cell;">';
												$output .= '<img class="ts-box-icon-title-image ts-main-ico ts-font-icon ' . $icon_frame_class . ' ' . $animation_icon . ' ' . $icon_frame_radius . '" src="' . $icon_image_path[0] . '" style="margin-left: 0; margin-right: ' . $icon_margin . 'px; ' . $icon_frame_style . ' ' . $icon_image_style . ' display: inline-block !important; margin-right: ' . $icon_margin . 'px;">';
											$output .= '</div>';
										}
									}
									if (($read_more_url != '') && (($read_more_link == "buttontitle") || ($read_more_link == "title"))) {
										$output .= '<a class="ts-box-icon-link" style="text-decoration: none;" href="' . $read_more_url . '" target="' . $read_more_target . '">';
									}
										$output .= '<' . $title_wrap . ' class="ts-box-icon-title-text" style="display: table-cell; vertical-align: middle; width: auto !important; color:' . $title_color . '; font-size:' . $title_size . 'px; font-weight:' . $title_weight . '; text-align: ' . $title_align . '; ' . $google_font_title . '">' . $title . '</' . $title_wrap . '>';
									if (($read_more_url != '') && (($read_more_link == "buttontitle") || ($read_more_link == "title"))) {
										$output .= '</a>';
									}								
								$output .= '</div>';
								if (function_exists('wpb_js_remove_wpautop')){
									$output .= '<div class="ts-icon-box-content" style="clear: both; font-size: ' . $font_size . 'px; line-height: ' . $line_height . 'px; ' . $google_font_content . '">' . wpb_js_remove_wpautop(do_shortcode($content), true) . '</div>';
								} else {
									$output .= '<div class="ts-icon-box-content" style="clear: both; font-size: ' . $font_size . 'px; line-height: ' . $line_height . 'px; ' . $google_font_content . '">' . do_shortcode($content) . '</div>';
								}
								if (($read_more_url != '') && ($read_more_txt != '') && (($read_more_link == "button") || ($read_more_link == "buttontitle"))) {
									$output .= '<a class="ts-icon-box-readmore ' . $read_more_button_style . '" style="display: block; width: ' . ($read_more_width == 100 ? 'auto' : $read_more_width . '%') . '; float:  ' . ($read_more_align == 'center' ? 'none' : $read_more_align) . '; ' . $google_font_button . '" href="' . $read_more_url . '" target="' . $read_more_target . '">'.$read_more_txt.'</a><div class="clearboth"></div>';
								}
							$output .= '</div>';
						$output .= '<div class="clearboth"></div></div>';
					}
					if ($style == "icon_top") {
						$output .= '<div class="ts-css-shadow ' . $animation_shadow . ' ' . $box_border_radius . '" style="' . $box_background_style . '">';
							$output .= '<div class="ts-icon-box-inner top-side ' . $animation_css . ' ' . $box_border_radius . ' ' . $height_class . '" style="' . $box_frame_style . ' ' . $box_inner_padding . ' ' . $height_setting . '">';
								if ($title_align == 'center') {
									$icon_float = 'margin: 0 auto ' . $icon_margin . 'px auto; float: none;';
								} else if ($title_align == 'left') {
									$icon_float = 'margin: 0 auto ' . $icon_margin . 'px auto; float: left;';
								} if ($title_align == 'right') {
									$icon_float = 'margin: 0 auto ' . $icon_margin . 'px auto; float: right;';
								}
								if ($icon_replace == 'false') {
									if (!empty($icon)) {
										$output .= '<i style="' . $icon_float . '; color:' . $icon_color . ';' . $icon_style . ' ' . $icon_frame_style . '" class="ts-box-icon-title-icon ' . $icon . ' ts-main-ico ts-font-icon ' . $icon_frame_class .' ' . $animation_icon . $icon_frame_radius . '"></i>';
									}
								} else {
									if (!empty($icon_image)) {
										$output .= '<img class="ts-box-icon-title-image ts-main-ico ts-font-icon ' . $icon_frame_class . ' ' . $animation_icon . ' ' . $icon_frame_radius . '" src="' . $icon_image_path[0] . '" style="' . $icon_float . ' ' . $icon_frame_style . ' ' . $icon_image_style . ' display: inline-block !important;">';
									}
								}
								$output .= '<div class="box-detail-wrapper" style="clear: both;">';
									if (($read_more_url != '') && (($read_more_link == "buttontitle") || ($read_more_link == "title"))) {
										$output .= '<a class="ts-box-icon-link" style="text-decoration: none;" href="' . $read_more_url . '" target="' . $read_more_target . '">';
									}
										$output .= '<' . $title_wrap . ' class="ts-box-icon-title" style="width: auto !important; color:' . $title_color . '; font-size:' . $title_size . 'px; font-weight:' . $title_weight . '; text-align:' . $title_align . '; ' . $google_font_title . '">' . $title . '</' . $title_wrap . '>';
									if (($read_more_url != '') && (($read_more_link == "buttontitle") || ($read_more_link == "title"))) {
										$output .= '</a>';
									}	
								if (function_exists('wpb_js_remove_wpautop')){
									$output .= '<div class="ts-icon-box-content" style="margin-top: 10px; font-size: ' . $font_size . 'px; line-height: ' . $line_height . 'px; ' . $google_font_content . '">' . wpb_js_remove_wpautop(do_shortcode($content), true) . '</div>';
								} else {
									$output .= '<div class="ts-icon-box-content" style="margin-top: 10px; font-size: ' . $font_size . 'px; line-height: ' . $line_height . 'px; ' . $google_font_content . '">' . do_shortcode($content) . '</div>';
								}
								if (($read_more_url != '') && ($read_more_txt != '') && (($read_more_link == "button") || ($read_more_link == "buttontitle"))) {
									$output .= '<a class="ts-icon-box-readmore ' . $read_more_button_style . '" style="display: block; width: ' . ($read_more_width == 100 ? 'auto' : $read_more_width . '%') . '; float:  ' . ($read_more_align == 'center' ? 'none' : $read_more_align) . '; ' . $google_font_button . '" href="' . $read_more_url . '" target="' . $read_more_target . '">' . $read_more_txt . '</a><div class="clearboth"></div>';
								}
							$output .= '</div>';
						$output .= '</div><div class="clearboth"></div></div>';
					}
					if ($style == "boxed") {
						$output .= '<div class="ts-css-shadow ' . $animation_shadow . ' ' . $box_border_radius . '" style="background-color: ' . $box_background_color .'; ' . $shadow_frame_adjust . '">';
							$output .= '<div class="ts-icon-box-boxed  ' . $icon_location . $animation_css . ' ' . $box_border_radius . '" style="' . $box_frame_style . ' ' . $box_inner_padding . ' ' . $box_padding_top . ' ' . $box_frame_adjust . ' ' . $box_background_style . '">';
								if ($separator_type != '') {
									$output .= '<div class="ts-icon-box-separator" style="' . $separator_style . ' ' . $height_setting . '">';
								}
									if ($icon_replace == 'false') {
										if (!empty($icon)) {
											$output .= '<i style="' . $icon_style . ' ' . $icon_frame_style . ' ' . $icon_frame_adjust . ' color: ' . $icon_color . ';" class="ts-box-icon-title-icon ' . $icon . ' ts-main-ico ts-font-icon ' . $icon_frame_radius . ' ' . $icon_frame_class . ' ' . $animation_icon . '"></i>';
										}
									} else {
										if (!empty($icon_image)) {
											$output .= '<img class="ts-box-icon-title-image ts-main-ico ts-font-icon ' . $icon_frame_class . ' ' . $animation_icon . ' ' . $icon_frame_radius . '" src="' . $icon_image_path[0] . '" style="' . $icon_frame_style . ' ' . $icon_image_style . ' ' . $icon_frame_adjust . ' display: inline-block !important; margin-right: ' . $icon_margin . 'px;">';
										}
									}									
									$output .= '<div class="ts-icon-box-inner ' . $height_class . '" style="' . $height_setting . '">';
										if (($read_more_url != '') && (($read_more_link == "buttontitle") || ($read_more_link == "title"))) {
											$output .= '<a class="ts-box-icon-link" style="text-decoration: none;" href="' . $read_more_url . '" target="' . $read_more_target . '">';
										}
											$output .= '<' . $title_wrap . ' class="ts-box-icon-title" style="color:' . $title_color . '; font-size:' . $title_size . 'px; font-weight:' . $title_weight . '; margin-top:' . $title_margin . 'px; text-align:' . $title_align . '; ' . $google_font_title . '">' . $title . '</' . $title_wrap . '>';
										if (($read_more_url != '') && (($read_more_link == "buttontitle") || ($read_more_link == "title"))) {
											$output .= '</a>';
										}	
										if (function_exists('wpb_js_remove_wpautop')){
											$output .= '<div class="ts-icon-box-content" style="margin-top: 10px; font-size: ' . $font_size . 'px; line-height: ' . $line_height . 'px; ' . $google_font_content . '">' . wpb_js_remove_wpautop(do_shortcode($content), true) . '</div>';
										} else {
											$output .= '<div class="ts-icon-box-content" style="margin-top: 10px; font-size: ' . $font_size . 'px; line-height: ' . $line_height . 'px; ' . $google_font_content . '">' . do_shortcode($content) . '</div>';
										}
										if (($read_more_url != '') && ($read_more_txt != '') && (($read_more_link == "button") || ($read_more_link == "buttontitle"))) {
											if (($separator_type != '') && ($box_border_type == '')) {
												$button_margin_adjust 	= 'margin-bottom: 0px;';
											} else {
												$button_margin_adjust	= 'margin-bottom: 0px;';
											}
											$output .= '<a class="ts-icon-box-readmore ' . $read_more_button_style . '" style="' . $button_margin_adjust . ' display: block; width: ' . ($read_more_width == 100 ? 'auto' : $read_more_width . '%') . '; float:  ' . ($read_more_align == 'center' ? 'none' : $read_more_align) . '; ' . $google_font_button . '" href="' . $read_more_url . '" target="' . $read_more_target . '">' . $read_more_txt . '</a><div class="clearboth"></div>';
										}										
									$output .= '</div>';									
								if ($separator_type != '') {
									$output .= '</div>';
								}
							$output .= '</div>';
						$output .= '<div class="clearboth"></div></div>';
					}
				$output .= (!empty($animation_box) ? '</div>' : '');
			$output .= '</div>';
		if (($read_more_url != '') && ($read_more_link == "box")) {
			$output .= '</a>';
		}
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>
