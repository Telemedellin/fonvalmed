<?php
	add_shortcode('TS-VCSC-Modal-Popup', 'TS_VCSC_Modal_Function');
	function TS_VCSC_Modal_Function ($atts, $content = null) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_script('ts-extend-hammer');
		wp_enqueue_script('ts-extend-nacho');
		wp_enqueue_style('ts-extend-nacho');
		wp_enqueue_style('ts-extend-tooltipster');
		wp_enqueue_script('ts-extend-tooltipster');	
		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'content_image_responsive'		=> 'true',
			'content_image_height'			=> 'height: 100%;',
			'content_image_width_r'			=> 100,
			'content_image_width_f'			=> 300,
			'content_image_size'			=> 'large',

			'lightbox_group'				=> 'false',
			'lightbox_group_name'			=> 'nachogroup',
			'lightbox_size'					=> 'full',
			'lightbox_effect'				=> 'random',
			'lightbox_speed'				=> 5000,
			'lightbox_social'				=> 'true',
			'lightbox_backlight_choice'		=> 'predefined',
			'lightbox_backlight_color'		=> '#0084E2',
			'lightbox_backlight_custom'		=> '#000000',
			
			'lightbox_custom_width'			=> 'false',
			'lightbox_width'				=> 960,
			'lightbox_custom_height'		=> 'false',
			'lightbox_height'				=> 540,
			
			'lightbox_width'				=> 'auto',
			'lightbox_width_percent'		=> 100,
			'lightbox_width_pixel'			=> 1024,
			'lightbox_height'				=> 'auto',
			'lightbox_height_percent'		=> 100,
			'lightbox_height_pixel'			=> 400,
			
			'lightbox_custom_padding'		=> 15,
			'lightbox_custom_background'	=> 'none',
			'lightbox_background_image'		=> '',
			'lightbox_background_size'		=> 'cover',
			'lightbox_background_repeat'	=> 'no-repeat',
			'lightbox_background_color'		=> '#ffffff',
			
			'height'						=> 500,
			'width'							=> 300,
			'content_style'					=> '',
			
			'content_provider'				=> 'custom',
			'content_retrieve'				=> '',
			
			'content_open'					=> 'false',
			'content_open_hide'				=> 'true',
			'content_open_delay'			=> 0,
			
			'content_trigger'				=> 'default',
			'content_title'					=> '',
			'content_subtitle'				=> '',
			'content_image'					=> '',
			'content_image_simple'			=> 'false',
			'content_icon'					=> '',
			'content_iconsize'				=> 30,
			'content_iconcolor' 			=> '#cccccc',
			'content_button'				=> '',
			'content_buttonstyle'			=> 'ts-dual-buttons-color-sun-flower',
			'content_buttonhover'			=> 'ts-dual-buttons-preview-default ts-dual-buttons-hover-default',
			'content_buttontext'			=> 'View Popup',
			'content_buttonsize'			=> 16,
			'content_text'					=> '',
			'content_raw'					=> '',
			
			'content_tooltip_css'			=> 'true',
			'content_tooltip_content'		=> '',
			'content_tooltip_position'		=> 'ts-simptip-position-top',
			'content_tooltip_style'			=> 'ts-simptip-style-black',
			
			'tooltipster_offsetx'			=> 0,
			'tooltipster_offsety'			=> 0,
			
			'content_show_title'			=> 'true',
			'title'							=> '',
			'margin_top'					=> 0,
			'margin_bottom'					=> 0,
			'el_id'							=> '',
			'el_class'						=> '',
			'css'							=> '',
		), $atts ));
	
		if (!empty($el_id)) {
			$modal_id						= $el_id;
		} else {
			$modal_id						= 'ts-vcsc-modal-' . mt_rand(999999, 9999999);
		}
		
		if (($content_provider == "identifier") && ($content_retrieve != '')) {
			$retrieval_id					= $content_retrieve;
		} else {
			$retrieval_id					= $modal_id;
		}
		
		// Tooltip
		if (($content_tooltip_position == "ts-simptip-position-top") || ($content_tooltip_position == "top")) {
			$content_tooltip_position		= "top";
		}
		if (($content_tooltip_position == "ts-simptip-position-left") || ($content_tooltip_position == "left")) {
			$content_tooltip_position		= "left";
		}
		if (($content_tooltip_position == "ts-simptip-position-right") || ($content_tooltip_position == "right")) {
			$content_tooltip_position		= "right";
		}
		if (($content_tooltip_position == "ts-simptip-position-bottom") || ($content_tooltip_position == "bottom")) {
			$content_tooltip_position		= "bottom";
		}
		$tooltipclasses						= 'ts-has-tooltipster-tooltip';		
		if (($content_tooltip_style == "") || ($content_tooltip_style == "ts-simptip-style-black") || ($content_tooltip_style == "tooltipster-black")) {
			$content_tooltip_style			= "tooltipster-black";
		}
		if (($content_tooltip_style == "ts-simptip-style-gray") || ($content_tooltip_style == "tooltipster-gray")) {
			$content_tooltip_style			= "tooltipster-gray";
		}
		if (($content_tooltip_style == "ts-simptip-style-green") || ($content_tooltip_style == "tooltipster-green")) {
			$content_tooltip_style			= "tooltipster-green";
		}
		if (($content_tooltip_style == "ts-simptip-style-blue") || ($content_tooltip_style == "tooltipster-blue")) {
			$content_tooltip_style			= "tooltipster-blue";
		}
		if (($content_tooltip_style == "ts-simptip-style-red") || ($content_tooltip_style == "tooltipster-red")) {
			$content_tooltip_style			= "tooltipster-red";
		}
		if (($content_tooltip_style == "ts-simptip-style-orange") || ($content_tooltip_style == "tooltipster-orange")) {
			$content_tooltip_style			= "tooltipster-orange";
		}
		if (($content_tooltip_style == "ts-simptip-style-yellow") || ($content_tooltip_style == "tooltipster-yellow")) {
			$content_tooltip_style			= "tooltipster-yellow";
		}
		if (($content_tooltip_style == "ts-simptip-style-purple") || ($content_tooltip_style == "tooltipster-purple")) {
			$content_tooltip_style			= "tooltipster-purple";
		}
		if (($content_tooltip_style == "ts-simptip-style-pink") || ($content_tooltip_style == "tooltipster-pink")) {
			$content_tooltip_style			= "tooltipster-pink";
		}
		if (($content_tooltip_style == "ts-simptip-style-white") || ($content_tooltip_style == "tooltipster-white")) {
			$content_tooltip_style			= "tooltipster-white";
		}
		if (($content_tooltip_css == "true") && (strlen($content_tooltip_content) != 0)) {
			$Tooltip_Content				= 'data-tooltipster-title="" data-tooltipster-text="' . str_replace('<br/>', ' ', $content_tooltip_content) . '" data-tooltipster-image="" data-tooltipster-position="' . $content_tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $content_tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			$Tooltip_Class					= $tooltipclasses;
		} else {
			$Tooltip_Class					= "";
			if (strlen($content_tooltip_content) != 0) {
				$Tooltip_Content			= ' title="' . $content_tooltip_content . '"';
			} else {
				$Tooltip_Content			= "";
			}
		}
		
		if ($content_image_responsive == "true") {
			$image_dimensions				= 'width: 100%; height: auto;';
			$parent_dimensions				= 'width: ' . $content_image_width_r . '%; ' . $content_image_height . '';
		} else {
			$image_dimensions				= 'width: 100%; height: auto;';
			$parent_dimensions				= 'width: ' . $content_image_width_f . 'px; ' . $content_image_height . '';
		}
		
		// Auto-Open Class
		if ($content_open == "true") {
			$modal_openclass				= "nch-lightbox-open";
			if ($content_open_hide == "true") {
				$modal_hideclass			= "nch-lightbox-hide";
			} else {
				$modal_hideclass			= "";
			}
		} else {
			$modal_openclass				= "nch-lightbox-modal no-ajaxy";
			$modal_hideclass				= "";
		}
		
		// Backlight Color
		if ($lightbox_backlight_choice == "predefined") {
			$lightbox_backlight_selection	= $lightbox_backlight_color;
		} else {
			$lightbox_backlight_selection	= $lightbox_backlight_custom;
		}

		// Custom Width / Height
		$lightbox_dimensions				= ' ';
		if ($lightbox_width == "auto") {
			$lightbox_dimensions			.= '';
		} else if ($lightbox_width == "widthpercent") {
			$lightbox_dimensions 			.= 'data-width="' . $lightbox_width_percent . '%" ';
		} else if ($lightbox_width == "widthpixel") {
			$lightbox_dimensions 			.= 'data-width="' . $lightbox_width_pixel . '" ';
		}
		if ($lightbox_height == "auto") {
			$lightbox_dimensions			.= '';
		} else if ($lightbox_height == "heightpercent") {
			$lightbox_dimensions 			.= 'data-height="' . $lightbox_height_percent . '%" ';
		} else if ($lightbox_height == "heightpixel") {
			$lightbox_dimensions 			.= 'data-height="' . $lightbox_height_pixel . '" ';
		}
		
		// Background Settings
		if ($lightbox_custom_background == "image") {
			$background_image 				= wp_get_attachment_image_src($lightbox_background_image, 'full');
			$background_image 				= $background_image[0];
			$lightbox_background			= 'background: url(' . $background_image . ') ' . $lightbox_background_repeat . ' 0 0; background-size: ' . $lightbox_background_size . ';';
		} else if ($lightbox_custom_background == "color") {
			$lightbox_background			= 'background: ' . $lightbox_background_color . ';';
		} else {
			$lightbox_background			= '';
		}
		
		$output 							= '';
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Modal-Popup', $atts);
		} else {
			$css_class	= '';
		}
		
		$output .= '<div id="' . $modal_id . '-container" class="ts-vcsc-modal-container">';
			if ($content_trigger == "default") {
				$modal_image = TS_VCSC_GetResourceURL('images/defaults/default_modal.jpg');
				if ($Tooltip_Content != '') {
					$output .= '<div class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $Tooltip_Class . '" ' . $Tooltip_Content . ' style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; ' . $parent_dimensions . '">';
						$output .= '<div id="' . $modal_id . '-trigger" class="' . $el_class . ' nchgrid-item nchgrid-tile nch-lightbox-modal no-ajaxy ' . $css_class . '" style="width: 100%; height: 100%;">';
				} else {
						$output .= '<div id="' . $modal_id . '-trigger" class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $el_class . ' nchgrid-item nchgrid-tile nch-lightbox-modal no-ajaxy ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; ' . $parent_dimensions . '">';
				}
						$output .= '<a href="#' . $retrieval_id . '" class="nch-lightbox-trigger ' . $modal_openclass . '" ' . $lightbox_dimensions . ' data-title="" data-open="' . $content_open . '" data-delay="' . $content_open_delay . '" data-type="html" rel="" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
							$output .= '<img src="' . $modal_image . '" title="" style="display: block; ' . $image_dimensions . '">';
							$output .= '<div class="nchgrid-caption"></div>';
							if (!empty($content_title)) {
								$output .= '<div class="nchgrid-caption-text">' . $content_title . '</div>';
							}
						$output .= '</a>';
					$output .= '</div>';
				if ($Tooltip_Content != '') {
					$output .= '</div>';
				}
			}
			if ($content_trigger == "image") {
				$modal_image = wp_get_attachment_image_src($content_image, 'large');
				$modal_image = $modal_image[0];
				if ($content_image_simple == "false") {
					if ($Tooltip_Content != '') {
						$output .= '<div class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $Tooltip_Class . '" ' . $Tooltip_Content . ' style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; ' . $parent_dimensions . '">';
							$output .= '<div id="' . $modal_id . '-trigger" class="' . $el_class . ' nchgrid-item nchgrid-tile nch-lightbox-modal no-ajaxy ' . $css_class . '" style="width: 100%; height: 100%;">';
					} else {
							$output .= '<div id="' . $modal_id . '-trigger" class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $el_class . ' nchgrid-item nchgrid-tile nch-lightbox-modal no-ajaxy ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; ' . $parent_dimensions . '">';
					}
							$output .= '<a href="#' . $retrieval_id . '" class="nch-lightbox-trigger ' . $modal_openclass . '" ' . $lightbox_dimensions . ' data-title="" data-open="' . $content_open . '" data-delay="' . $content_open_delay . '" data-type="html" rel="" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
								$output .= '<img src="' . $modal_image . '" title="" style="display: block; ' . $image_dimensions . '">';
								$output .= '<div class="nchgrid-caption"></div>';
								if (!empty($content_title)) {
									$output .= '<div class="nchgrid-caption-text">' . $content_title . '</div>';
								}
							$output .= '</a>';
						$output .= '</div>';
					if ($Tooltip_Content != '') {
						$output .= '</div>';
					}
				} else {
					$output .= '<a href="#' . $retrieval_id . '" class="' . $modal_id . '-parent nch-holder nch-lightbox-modal no-ajaxy ' . $Tooltip_Class . '" ' . $Tooltip_Content . ' style="' . $parent_dimensions . '" ' . $lightbox_dimensions . ' data-title="' . $content_title . '" data-type="html" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group) . '" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
						$output .= '<img class="" src="' . $modal_image . '" style="display: block; ' . $image_dimensions . '">';
					$output .= '</a>';
				}
			}
			if ($content_trigger == "icon") {
				$icon_style = 'color: ' . $content_iconcolor . '; width:' . $content_iconsize . 'px; height:' . $content_iconsize . 'px; font-size:' . $content_iconsize . 'px; line-height:' . $content_iconsize . 'px;';
				$output .= '<div id="' . $modal_id . '-trigger" style="" class="' . $modal_id . '-parent nch-holder ts-vcsc-font-icon ts-font-icons ts-shortcode ts-icon-align-center ' . $el_class . ' ' . $css_class . ' ' . $Tooltip_Class . '" ' . $Tooltip_Content . ' style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
					$output .= '<a href="#' . $retrieval_id . '" class="' . $modal_openclass . '" ' . $lightbox_dimensions . ' data-title="" data-open="' . $content_open . '" data-delay="' . $content_open_delay . '" data-type="html" rel="" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
						$output .= '<i class="ts-font-icon ' . $content_icon . '" style="' . $icon_style . '"></i>';
					$output .= '</a>';
				$output .= '</div>';
			}
			if (($content_trigger == "flat") || ($content_trigger == "flaticon")) {
				wp_enqueue_style('ts-extend-buttonsdual');
				$button_style				= $content_buttonstyle . ' ' . $content_buttonhover;				
				$output .= '<a href="#' . $retrieval_id . '" target="_blank" class="ts-dual-buttons-wrapper ' . $modal_openclass . '" ' . $lightbox_dimensions . ' data-open="' . $content_open . '" data-delay="' . $content_open_delay . '" data-type="html" rel="" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
					$output .= '<div id="' . $modal_id . '-trigger" class="ts-dual-buttons-container clearFixMe ' . $button_style . ' ' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $el_class . ' ' . $Tooltip_Class . ' ' . $css_class . '" ' . $Tooltip_Content . ' style="display: block; width: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
						if (($content_icon != '') && ($content_icon != 'transparent') && ($content_trigger == "flaticon")) {
							$output .= '<i class="ts-dual-buttons-icon ' . $content_icon . '" style="font-size: ' . $content_buttonsize . 'px; line-height: ' . $content_buttonsize . 'px;"></i>';
						}
						$output .= '<span class="ts-dual-buttons-title" style="font-size: ' . $content_buttonsize . 'px; line-height: ' . $content_buttonsize . 'px;">' . $content_buttontext . '</span>';			
					$output .= '</div>';
				$output .= '</a>';
			}
			if ($content_trigger == "winged") {
				$output .= '<div id="' . $modal_id . '-trigger" class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $el_class . ' ' . $Tooltip_Class . ' ' . $css_class . '" ' . $Tooltip_Content . ' style="display: block; width: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
					$output .= '<div class="ts-lightbox-button-1 clearFixMe">';
						$output .= '<div class="top">' . $content_title . '</div>';
						$output .= '<div class="bottom">' . $content_subtitle . '</div>';
						$output .= '<a href="#' . $retrieval_id . '" class="icon ' . $modal_openclass . '" ' . $lightbox_dimensions . ' data-open="' . $content_open . '" data-delay="' . $content_open_delay . '" data-type="html" rel="" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '"><span class="popup">' . $content_buttontext . '</span></a>';
					$output .= '</div>';
				$output .= '</div>';
			}
			if ($content_trigger == "simple") {
				$output .= '<div id="' . $modal_id . '-trigger" class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $el_class . ' ' . $Tooltip_Class . ' ' . $css_class . '" ' . $Tooltip_Content . ' style="display: block; width: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
					$output .= '<a href="#' . $retrieval_id . '" class="ts-lightbox-button-2 icon ' . $modal_openclass . '" ' . $lightbox_dimensions . ' data-open="' . $content_open . '" data-delay="' . $content_open_delay . '" data-type="html" rel="" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '"><span class="popup">' . $content_buttontext . '</span></a>';
				$output .= '</div>';
			}
			if ($content_trigger == "text") {
				$output .= '<div id="' . $modal_id . '-trigger" class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $el_class . ' ' . $css_class . ' ' . $Tooltip_Class . '" ' . $Tooltip_Content . ' style="text-align: center; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
					$output .= '<a href="#' . $retrieval_id . '" class="' . $modal_openclass . '" ' . $lightbox_dimensions . ' data-open="' . $content_open . '" data-delay="' . $content_open_delay . '" data-type="html" rel="" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">' . $content_text . '</a>';
				$output .= '</div>';
			}
			if ($content_trigger == "custom") {
				if ($content_raw != "") {
					$content_raw =  rawurldecode(base64_decode(strip_tags($content_raw)));
					$output .= '<div id="' . $modal_id . '-trigger" class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $el_class . ' ' . $css_class . ' ' . $Tooltip_Class . '" ' . $Tooltip_Content . ' style="text-align: center; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
						$output .= '<a href="#' . $retrieval_id . '" class="' . $modal_openclass . '" ' . $lightbox_dimensions . ' data-open="' . $content_open . '" data-delay="' . $content_open_delay . '" data-type="html" rel="" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
							$output .= $content_raw;
						$output .= '</a>';
					$output .= '</div>';
				}
			}
			
			// Create hidden DIV with Modal Content
			if (($content_provider == "custom") || (($content_provider == "identifier") && ($content_retrieve == ''))) {
				$output .= '<div id="' . $modal_id . '" class="ts-modal-content nch-hide-if-javascript ' . $el_class . '" style="display: none; padding: ' . $lightbox_custom_padding . 'px; ' . $lightbox_background . '">';
					$output .= '<div class="ts-modal-white-header"></div>';
					$output .= '<div class="ts-modal-white-frame" style="">';
						$output .= '<div class="ts-modal-white-inner">';
							if (($content_show_title == "true") && ($title != "")) {
								$output .= '<h2 style="border-bottom: 1px solid #eeeeee; padding-bottom: 10px; margin-bottom: 10px;">' . $title . '</h2>';
							}
							if (function_exists('wpb_js_remove_wpautop')){
								$output .= wpb_js_remove_wpautop(do_shortcode($content), true);
							} else {
								$output .= do_shortcode($content);
							}
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
			}
		
		$output .= '</div>';
		
		echo $output;
	
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>