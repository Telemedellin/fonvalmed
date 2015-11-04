<?php
	add_shortcode('TS_VCSC_HTML5_Video', 'TS_VCSC_HTML5_Video_Function');
	function TS_VCSC_HTML5_Video_Function ($atts, $content = null) {
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
			'video_dual_version'			=> 'false',	
			'video_mp4_source'				=> 'true',
			'video_mp4_remote'				=> '',
			'video_mp4_local'				=> '',
			'video_ogg_source'				=> 'true',
			'video_ogg_remote'				=> '',
			'video_ogg_local'				=> '',			
			'video_webm_source'				=> 'true',
			'video_webm_remote'				=> '',
			'video_webm_local'				=> '',
			
			'video_poster'					=> '',
			'video_posterfit'				=> 'aspectratio',
			'video_fixed'					=> 'false',
			'video_fixed_show'				=> 'true',	
			'video_fixed_width'				=> 250,
			'video_fixed_height'			=> 140,
			'video_fixed_adjust'			=> 0,
			'video_fixed_switch'			=> 'toggle',
			'video_fixed_position'			=> 'bottomleft',
			
			'video_logo_show'				=> 'logotop',
			'video_logo_image'				=> '',
			'video_logo_height'				=> 50,
			'video_logo_opacity'			=> 50,
			'video_logo_position'			=> 'left',
			'video_logo_link'				=> '',
			
			'video_theme'					=> 'maccaco',
			'video_title'					=> '',
			'video_iframe'					=> 'true',
			'video_auto'					=> 'false',
			'video_stop'					=> 'true',
			'video_loop'					=> 'false',
			'video_fullscreen'				=> 'true',
			'video_share'					=> 'true',
			'video_volume'					=> 50,
			'video_objectfit'				=> 'aspectratio',
			
			'content_image_responsive'		=> 'true',
			'content_image_height'			=> 'height: 100%;',
			'content_image_width_r'			=> 100,
			'content_image_width_f'			=> 300,
			'content_image_size'			=> 'large',
			
			'frame_border_type'				=> 'none',
			'frame_border_width'			=> 1,
			'frame_border_color'			=> '#dadada',

			'lightbox_group_name'			=> 'nachogroup',
			'lightbox_size'					=> 50,
			'lightbox_effect'				=> 'random',
			'lightbox_speed'				=> 5000,
			'lightbox_social'				=> 'true',
			'lightbox_backlight_choice'		=> 'predefined',
			'lightbox_backlight_color'		=> '#0084E2',
			'lightbox_backlight_custom'		=> '#000000',
			
			'lightbox_width'				=> 'auto',
			'lightbox_width_percent'		=> 100,
			'lightbox_width_pixel'			=> 1024,
			'lightbox_height'				=> 'auto',
			'lightbox_height_percent'		=> 100,
			'lightbox_height_pixel'			=> 400,
			
			'content_lightbox'				=> 'false',
			'content_open'					=> 'false',
			'content_open_hide'				=> 'true',
			'content_open_delay'			=> 0,
			
			'content_trigger'				=> 'poster',
			'content_subtitle'				=> '',
			'content_image'					=> '',
			'content_image_simple'			=> 'false',
			'content_icon'					=> '',
			'content_iconsize'				=> 30,
			'content_iconcolor' 			=> '#cccccc',
			'content_button'				=> '',
			'content_buttonstyle'			=> 'ts-dual-buttons-color-sun-flower',
			'content_buttonhover'			=> 'ts-dual-buttons-preview-default ts-dual-buttons-hover-default',
			'content_buttontext'			=> 'View Video',
			'content_buttonsize'			=> 16,
			'content_text'					=> '',
			'content_raw'					=> '',
			
			'content_tooltip_css'			=> 'false',
			'content_tooltip_content'		=> '',
			'content_tooltip_encoded'		=> '',
			'content_tooltip_position'		=> 'ts-simptip-position-top',
			'content_tooltip_style'			=> '',
			'tooltipster_offsetx'			=> 0,
			'tooltipster_offsety'			=> 0,

			'margin_top'					=> 0,
			'margin_bottom'					=> 0,
			'el_id'							=> '',
			'el_class'						=> '',
			'css'							=> '',
		), $atts ));
		
		$randomizer							= mt_rand(999999, 9999999);
	
		if (!empty($el_id)) {
			$modal_id						= $el_id;
		} else {
			$modal_id						= 'ts-vcsc-modal-' . $randomizer;
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
		if ($content_tooltip_css == "false") {
			if (strlen($content_tooltip_content) != 0) {
				$popup_tooltipclasses		= " ts-has-tooltipster-tooltip";
				$popup_tooltipcontent 		= 'data-tooltipster-html="false" data-tooltipster-title="" data-tooltipster-text="' . strip_tags($content_tooltip_content) . '" data-tooltipster-image="" data-tooltipster-position="' . $content_tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $content_tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			} else {
				$popup_tooltipclasses		= "";
				$popup_tooltipcontent		= "";
			}
		} else {
			if (strlen($content_tooltip_encoded) != 0) {
				$popup_tooltipclasses		= " ts-has-tooltipster-tooltip";
				$popup_tooltipcontent 		= 'data-tooltipster-html="true" data-tooltipster-title="" data-tooltipster-text="' . strip_tags($content_tooltip_encoded) . '" data-tooltipster-image="" data-tooltipster-position="' . $content_tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $content_tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			} else {
				$popup_tooltipclasses		= "";
				$popup_tooltipcontent		= "";
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
			$modal_openclass				= "nch-lightbox-html5 no-ajaxy";
			$modal_hideclass				= "";
		}
		
		// Backlight Color
		if ($lightbox_backlight_choice == "predefined") {
			$lightbox_backlight_selection	= $lightbox_backlight_color;
		} else {
			$lightbox_backlight_selection	= $lightbox_backlight_custom;
		}
		
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
		$nacho_color						.= $lightbox_dimensions;
		
		// Video Data
		if ($video_mp4_source == "true") {
			$video_url 						= wp_get_attachment_url($video_mp4_local);
		} else {
			$video_url 						= $video_mp4_remote;
		}
		$video_mp4							= $video_url;		
		if ($video_webm_source == "true") {
			$video_url 						= wp_get_attachment_url($video_webm_local);
		} else {
			$video_url 						= $video_webm_remote;
		}
		$video_webm							= $video_url;
		//$video_webm 						= pathinfo($video_url, PATHINFO_DIRNAME) . '/' . pathinfo($video_url, PATHINFO_FILENAME) . '.webm';
		if ($video_ogg_source == "true") {
			$video_url 						= wp_get_attachment_url($video_ogg_local);
		} else {
			$video_url 						= $video_ogg_remote;
		}
		$video_ogg							= $video_url;		
		//$video_ogg 						= pathinfo($video_url, PATHINFO_DIRNAME) . '/' . pathinfo($video_url, PATHINFO_FILENAME) . '.ogv';		
		$poster_image 						= wp_get_attachment_image_src($video_poster, 'full');
		if ($poster_image != false) {
			$poster_image					= $poster_image[0];
		} else {
			$poster_image					= TS_VCSC_GetResourceURL("images/defaults/default_html5.jpg");
		}
		if ($video_logo_show != "logonone") {
			$logo_image 					= wp_get_attachment_image_src($video_logo_image, 'full');
			$logo_image 					= $logo_image[0];			
			// Link Values
			$video_logo_link 				= ($video_logo_link=='||') ? '' : $video_logo_link;
			$video_logo_link 				= vc_build_link($video_logo_link);
			$logo_link_href					= $video_logo_link['url'];
			$logo_link_title 				= $video_logo_link['title'];
			$logo_link_target 				= $video_logo_link['target'];			
		} else {
			$logo_image 					= '';
			$video_logo_link 				= '';
			$logo_link_href					= '';
			$logo_link_title 				= '';
			$logo_link_target 				= '';		
		}
		// Frame Border Type
		if ($frame_border_type != 'none') {
			$frame_border_type				= 'border: ' . $frame_border_width . 'px ' . $frame_border_type . ' ' . $frame_border_color . ';';
		} else {
			$frame_border_type				= '';
		}
		
		// Adjustment for Inline Edit Mode of VC
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
			$video_fixed					= 'false';
		} else {
			$video_fixed					= $video_fixed;
		}
		
		if ($video_fixed == "true") {
			$container_adjust				= 'margin-top: 0px; margin-bottom: 0px; height: ' . $video_fixed_height . 'px; width: ' . $video_fixed_width . 'px; padding-bottom: 0; padding-top: 0;';
			$iframe_adjust					= 'height: ' . $video_fixed_height . 'px; width: ' . $video_fixed_width . 'px; padding-bottom: 0; padding-top: 0;';
		} else {
			$container_adjust				= 'margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
			$iframe_adjust					= '';
		}
		if ($video_fixed == "true") {
			if ($video_fixed_position == "bottomleft") {
				$container_fixed			= 'position: fixed; bottom: ' . $video_fixed_adjust . 'px; left: 0; top: auto; right: auto; z-index: 4444;';
				$container_remove			= 'position: fixed; bottom: ' . ($video_fixed_height - 38 + $video_fixed_adjust) . 'px; left: ' . ($video_fixed_width + 2) . 'px; top: auto; right: auto;';
			} else if ($video_fixed_position == "bottomright") {
				$container_fixed			= 'position: fixed; bottom: ' . $video_fixed_adjust . 'px; left: auto; top: auto; right: 0; z-index: 4444;';
				$container_remove			= 'position: fixed; bottom: ' . ($video_fixed_height - 38 + $video_fixed_adjust) . 'px; left: auto; top: auto; right: ' . ($video_fixed_width + 2) . 'px;';
			} else if ($video_fixed_position == "topleft") {
				$container_fixed			= 'position: fixed; bottom: auto; left: 0; top: ' . $video_fixed_adjust . 'px; right: auto; z-index: 4444;';
				$container_remove			= 'position: fixed; bottom: auto; left: ' . ($video_fixed_width + 2) . 'px; top: ' . ($video_fixed_height - 38 + $video_fixed_adjust) . 'px; right: auto;';
			} else if ($video_fixed_position == "topright") {
				$container_fixed			= 'position: fixed; bottom: auto; left: auto; top: ' . $video_fixed_adjust . 'px; right: 0; z-index: 4444;';
				$container_remove			= 'position: fixed; bottom: auto; left: auto; top: ' . ($video_fixed_height - 38 + $video_fixed_adjust) . 'px; right: ' . ($video_fixed_width + 2) . 'px;';
			}			
			$iframe_fixed					= 'position: relative;';
		} else {
			$container_fixed				= '';
			$iframe_fixed					= '';
			$container_remove				= '';
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_HTML5_Video', $atts);
		} else {
			$css_class	= '';
		}
		
		$output = '';
		
		if ($content_lightbox == "true") {
			if ($content_trigger == "poster") {
				if ($popup_tooltipcontent != '') {
					$output .= '<div class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $popup_tooltipclasses . '" ' . $popup_tooltipcontent . ' style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; ' . $parent_dimensions . '">';
						$output .= '<div id="' . $modal_id . '-trigger" class="' . $el_class . ' nchgrid-item nchgrid-tile nch-lightbox-modal no-ajaxy nch-lightbox-video ' . $css_class . '" style="width: 100%; height: 100%;">';
				} else {
						$output .= '<div id="' . $modal_id . '-trigger" class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $el_class . ' nchgrid-item nchgrid-tile nch-lightbox-modal no-ajaxy nch-lightbox-video ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; ' . $parent_dimensions . '">';
				}
						$output .= '<a id="nch-lightbox-trigger-video-' . $randomizer . '" href="#' . $modal_id . '" class="nch-lightbox-trigger ' . $modal_openclass . ' nch-lightbox-trigger-video" data-title="' . $video_title . '" data-open="' . $content_open . '" data-lightbox-size="' . $lightbox_size . '" data-delay="' . $content_open_delay . '" data-type="video" rel="' . $lightbox_group_name . '" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
							$output .= '<img src="' . $poster_image . '" title="" style="display: block; ' . $image_dimensions . '">';
							$output .= '<div class="nchgrid-caption"></div>';
							if (!empty($video_title)) {
								$output .= '<div class="nchgrid-caption-text">' . $video_title . '</div>';
							}
						$output .= '</a>';
					$output .= '</div>';
				if ($popup_tooltipcontent != '') {
					$output .= '</div>';
				}
			}
			if ($content_trigger == "default") {
				$modal_image = TS_VCSC_GetResourceURL('images/defaults/default_html5.jpg');
				if ($popup_tooltipcontent != '') {
					$output .= '<div class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $popup_tooltipclasses . '" ' . $popup_tooltipcontent . ' style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; ' . $parent_dimensions . '">';
						$output .= '<div id="' . $modal_id . '-trigger" class="' . $el_class . ' nchgrid-item nchgrid-tile nch-lightbox-modal no-ajaxy nch-lightbox-video ' . $css_class . '" style="width: 100%; height: 100%;">';
				} else {
						$output .= '<div id="' . $modal_id . '-trigger" class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $el_class . ' nchgrid-item nchgrid-tile nch-lightbox-modal no-ajaxy nch-lightbox-video ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; ' . $parent_dimensions . '">';
				}
						$output .= '<a id="nch-lightbox-trigger-video-' . $randomizer . '" href="#' . $modal_id . '" class="nch-lightbox-trigger ' . $modal_openclass . ' nch-lightbox-trigger-video" data-title="' . $video_title . '" data-open="' . $content_open . '" data-lightbox-size="' . $lightbox_size . '" data-delay="' . $content_open_delay . '" data-type="video" rel="' . $lightbox_group_name . '" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
							$output .= '<img src="' . $modal_image . '" title="" style="display: block; ' . $image_dimensions . '">';
							$output .= '<div class="nchgrid-caption"></div>';
							if (!empty($video_title)) {
								$output .= '<div class="nchgrid-caption-text">' . $video_title . '</div>';
							}
						$output .= '</a>';
					$output .= '</div>';
				if ($popup_tooltipcontent != '') {
					$output .= '</div>';
				}
			}
			if ($content_trigger == "image") {
				$modal_image = wp_get_attachment_image_src($content_image, 'large');
				$modal_image = $modal_image[0];
				if ($content_image_simple == "false") {
					if ($popup_tooltipcontent != '') {
						$output .= '<div class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $popup_tooltipclasses . '" ' . $popup_tooltipcontent . ' style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; ' . $parent_dimensions . '">';
							$output .= '<div id="' . $modal_id . '-trigger" class="' . $el_class . ' nchgrid-item nchgrid-tile nch-lightbox-modal no-ajaxy nch-lightbox-video ' . $css_class . '" style="width: 100%; height: 100%;">';
					} else {
							$output .= '<div id="' . $modal_id . '-trigger" class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $el_class . ' nchgrid-item nchgrid-tile nch-lightbox-modal no-ajaxy nch-lightbox-video ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; ' . $parent_dimensions . '">';
					}
							$output .= '<a id="nch-lightbox-trigger-video-' . $randomizer . '" href="#' . $modal_id . '" class="nch-lightbox-trigger ' . $modal_openclass . ' nch-lightbox-trigger-video" data-title="' . $video_title . '" data-open="' . $content_open . '" data-lightbox-size="' . $lightbox_size . '" data-delay="' . $content_open_delay . '" data-type="video" rel="' . $lightbox_group_name . '" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
								$output .= '<img src="' . $modal_image . '" title="" style="display: block; ' . $image_dimensions . '">';
								$output .= '<div class="nchgrid-caption"></div>';
								if (!empty($video_title)) {
									$output .= '<div class="nchgrid-caption-text">' . $video_title . '</div>';
								}
							$output .= '</a>';
						$output .= '</div>';
					if ($popup_tooltipcontent != '') {
						$output .= '</div>';
					}
				} else {
					$output .= '<a id="nch-lightbox-trigger-video-' . $randomizer . '" href="#' . $modal_id . '" class="' . $modal_id . '-parent nch-holder nch-lightbox ' . $popup_tooltipclasses . ' nch-lightbox-trigger-video" ' . $popup_tooltipcontent . ' style="' . $parent_dimensions . '" data-lightbox-size="' . $lightbox_size . '"  data-title="' . $video_title . '" data-type="video" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group) . '" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
						$output .= '<img class="" src="' . $modal_image . '" style="display: block; ' . $image_dimensions . '">';
					$output .= '</a>';
				}
			}
			if ($content_trigger == "icon") {
				$icon_style = 'color: ' . $content_iconcolor . '; width:' . $content_iconsize . 'px; height:' . $content_iconsize . 'px; font-size:' . $content_iconsize . 'px; line-height:' . $content_iconsize . 'px;';
				$output .= '<div id="' . $modal_id . '-trigger" style="" class="' . $modal_id . '-parent nch-holder ts-vcsc-font-icon ts-font-icons ts-shortcode ts-icon-align-center ' . $el_class . ' ' . $css_class . ' ' . $popup_tooltipclasses . '" ' . $popup_tooltipcontent . ' style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
					$output .= '<a id="nch-lightbox-trigger-video-' . $randomizer . '" href="#' . $modal_id . '" class="' . $modal_openclass . ' nch-lightbox-trigger-video" data-title="' . $video_title . '" data-open="' . $content_open . '" data-lightbox-size="' . $lightbox_size . '" data-delay="' . $content_open_delay . '" data-type="video" rel="' . $lightbox_group_name . '" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
						$output .= '<i class="ts-font-icon ' . $content_icon . '" style="' . $icon_style . '"></i>';
					$output .= '</a>';
				$output .= '</div>';
			}
			if (($content_trigger == "flat") || ($content_trigger == "flaticon")) {
				wp_enqueue_style('ts-extend-buttonsdual');
				$button_style				= $content_buttonstyle . ' ' . $content_buttonhover;				
				$output .= '<a id="nch-lightbox-trigger-video-' . $randomizer . '" href="#' . $modal_id . '" class="ts-dual-buttons-wrapper ' . $modal_openclass . ' nch-lightbox-trigger-video" data-title="' . $video_title . '" data-open="' . $content_open . '" data-lightbox-size="' . $lightbox_size . '" data-delay="' . $content_open_delay . '" data-type="video" rel="' . $lightbox_group_name . '" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
					$output .= '<div id="' . $modal_id . '-trigger" class="ts-dual-buttons-container clearFixMe ' . $button_style . ' ' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $el_class . ' ' . $popup_tooltipclasses . ' ' . $css_class . '" ' . $popup_tooltipcontent . ' style="display: block; width: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
						if (($content_icon != '') && ($content_icon != 'transparent') && ($content_trigger == "flaticon")) {
							$output .= '<i class="ts-dual-buttons-icon ' . $content_icon . '" style="font-size: ' . $content_buttonsize . 'px; line-height: ' . $content_buttonsize . 'px;"></i>';
						}
						$output .= '<span class="ts-dual-buttons-title" style="font-size: ' . $content_buttonsize . 'px; line-height: ' . $content_buttonsize . 'px;">' . $content_buttontext . '</span>';			
					$output .= '</div>';
				$output .= '</a>';
			}
			if ($content_trigger == "winged") {
				$output .= '<div id="' . $modal_id . '-trigger" class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $el_class . ' ' . $popup_tooltipclasses . ' ' . $css_class . '" ' . $popup_tooltipcontent . ' style="display: block; width: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
					$output .= '<div class="ts-lightbox-button-1 clearFixMe">';
						$output .= '<div class="top">' . $video_title . '</div>';
						$output .= '<div class="bottom">' . $content_subtitle . '</div>';
						$output .= '<a id="nch-lightbox-trigger-video-' . $randomizer . '" href="#' . $modal_id . '" class="icon ' . $modal_openclass . ' nch-lightbox-trigger-video" data-open="' . $content_open . '" data-lightbox-size="' . $lightbox_size . '" data-delay="' . $content_open_delay . '" data-type="video" rel="' . $lightbox_group_name . '" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '"><span class="popup">' . $content_buttontext . '</span></a>';
					$output .= '</div>';
				$output .= '</div>';
			}
			if ($content_trigger == "simple") {
				$output .= '<div id="' . $modal_id . '-trigger" class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $el_class . ' ' . $popup_tooltipclasses . ' ' . $css_class . '" ' . $popup_tooltipcontent . ' style="display: block; width: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
					$output .= '<a id="nch-lightbox-trigger-video-' . $randomizer . '" href="#' . $modal_id . '" class="ts-lightbox-button-2 icon ' . $modal_openclass . ' nch-lightbox-trigger-video" data-open="' . $content_open . '" data-lightbox-size="' . $lightbox_size . '" data-delay="' . $content_open_delay . '" data-type="video" rel="' . $lightbox_group_name . '" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '"><span class="popup">' . $content_buttontext . '</span></a>';
				$output .= '</div>';
			}
			if ($content_trigger == "text") {
				$output .= '<div id="' . $modal_id . '-trigger" class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $el_class . ' ' . $css_class . '" style="text-align: center; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
					$output .= '<a id="nch-lightbox-trigger-video-' . $randomizer . '" href="#' . $modal_id . '" class="' . $popup_tooltipclasses . ' ' . $modal_openclass . ' nch-lightbox-trigger-video" ' . $popup_tooltipcontent . ' data-open="' . $content_open . '" data-lightbox-size="' . $lightbox_size . '" data-delay="' . $content_open_delay . '" data-type="video" rel="' . $lightbox_group_name . '" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">' . $content_text . '</a>';
				$output .= '</div>';
			}
			if ($content_trigger == "custom") {
				if ($content_raw != "") {
					$content_raw =  rawurldecode(base64_decode(strip_tags($content_raw)));
					$output .= '<div id="' . $modal_id . '-trigger" class="' . $modal_id . '-parent nch-holder ' . $modal_hideclass . ' ' . $el_class . ' ' . $css_class . '" style="text-align: center; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
						$output .= '<a id="nch-lightbox-trigger-video-' . $randomizer . '" href="#' . $modal_id . '" class="' . $popup_tooltipclasses . ' ' . $modal_openclass . ' nch-lightbox-trigger-video" ' . $popup_tooltipcontent . ' data-open="' . $content_open . '" data-lightbox-size="' . $lightbox_size . '" data-delay="' . $content_open_delay . '" data-type="video" rel="' . $lightbox_group_name . '" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
							$output .= $content_raw;
						$output .= '</a>';
					$output .= '</div>';
				}
			}			
			// Create hidden DIV with Modal Content			
			$output .= '<div id="' . $modal_id . '" class="ts-modal-content nch-hide-if-javascript" style="display: none;">';
				$output .= '<div class="ts-modal-white-header"></div>';
				$output .= '<div class="ts-modal-white-frame">';
					$output .= '<div class="ts-modal-white-inner">';			
						$output .= '<div id="' . $modal_id . '_video" class="ts_video_container ts_html5_video_frame" style="' . $frame_border_type . '">';
							$output .= '<iframe id="' . $modal_id . '_iframe" class="ts_html5_video_frame_insert ts_html5_media_frame_insert" style="margin: 0 auto;" onload=""
								data-id="projekktor' . $randomizer . '"
								data-theme="' . $video_theme . '"
								data-holder="' . $modal_id . '_iframe"
								data-auto-play="' . $video_auto .'"
								data-auto-stop="' . $video_stop . '"
								data-repeat="' . $video_loop . '"
								data-fullscreen="' . $video_fullscreen . '"
								data-poster="' . $poster_image . '"
								data-posterfit="' . $video_posterfit . '"
								data-title="' . $video_title . '"
								data-objectfit="' . $video_objectfit . '"
								data-logo-show="' . $video_logo_show . '"
								data-logo-image="' . $logo_image . '"
								data-logo-height="' . $video_logo_height . '"
								data-logo-opacity="' . $video_logo_opacity . '"
								data-logo-position="' . $video_logo_position . '"
								data-logo-url="' . $logo_link_href . '"
								data-logo-title="' . $logo_link_title . '"
								data-logo-target="' . $logo_link_target . '"
								data-video-mp4="' . $video_mp4 . '"
								data-video-webm="' . $video_webm . '"
								data-video-ogg="' . $video_ogg . '"
								data-volume="' . $video_volume . '"
								data-lightbox="' . $content_lightbox . '"
								data-share="' . $video_share . '"
								data-fallback="' . TS_VCSC_GetResourceURL("projekktor/swf/StrobeMediaPlayback/StrobeMediaPlayback.swf") . '"
								data-lightbox="' . $content_lightbox . '"
								data-screen-size="' . $lightbox_size . '"
								width="100%" 
								height="auto" 
								scrolling="no" 
								frameborder="0" 
								type="text/html" 
								mozallowfullscreen="mozallowfullscreen" 
								webkitallowfullscreen="webkitallowfullscreen" 
								allowfullscreen="allowfullscreen" 
								src="' . TS_VCSC_GetResourceURL("projekktor/iframe-video.html") . '">
							</iframe>';
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';		
		} else {
			if ($video_fixed == "true") {
				if ($video_fixed_switch == "remove") {
					$output .= '<div id="' . $modal_id . '_remove" class="ts_html5_video_remove" data-player="' . $modal_id . '_video" data-position="' . $video_fixed_position . '" data-width="' . $video_fixed_width . '" data-adjust="' . $video_fixed_adjust . '" style="' . $container_remove . '"></div>';
				} else if ($video_fixed_switch == "toggle") {
					$output .= '<div id="' . $modal_id . '_hide" class="ts_html5_video_hide inactive ' . $video_fixed_position . '" data-show="' . $video_fixed_show . '" data-player="' . $modal_id . '_video" data-position="' . $video_fixed_position . '" data-width="' . $video_fixed_width . '" data-adjust="' . $video_fixed_adjust . '" style="' . $container_remove . '"></div>';
				}
			}
			$output .= '<div id="' . $modal_id . '_video" class="ts_video_container ts_html5_video_frame ' . ($video_fixed == 'true' ? 'ts_html5_video_fixed_' . $video_fixed_position : '') . ' ' . $el_class . ' ' . $css_class . '" style="' . $frame_border_type . ' ' . $container_adjust . ' ' . $container_fixed . '">';
				$output .= '<iframe id="' . $modal_id . '_iframe" class="ts_html5_video_frame_insert ts_html5_media_frame_insert" style="margin: 0 auto; ' . $iframe_adjust . ' ' . $iframe_fixed . '" onload=""
					data-id="projekktor' . $randomizer . '"
					data-theme="' . $video_theme . '"
					data-holder="' . $modal_id . '_iframe"
					data-auto-play="' . $video_auto .'"
					data-auto-stop="' . $video_stop . '"
					data-repeat="' . $video_loop . '"
					data-fullscreen="' . $video_fullscreen . '"
					data-poster="' . $poster_image . '"
					data-posterfit="' . $video_posterfit . '"
					data-title="' . $video_title . '"
					data-objectfit="' . $video_objectfit . '"
					data-logo-show="' . $video_logo_show . '"
					data-logo-image="' . $logo_image . '"
					data-logo-height="' . $video_logo_height . '"
					data-logo-opacity="' . $video_logo_opacity . '"
					data-logo-position="' . $video_logo_position . '"
					data-logo-url="' . $logo_link_href . '"
					data-logo-title="' . $logo_link_title . '"
					data-logo-target="' . $logo_link_target . '"
					data-video-mp4="' . $video_mp4 . '"
					data-video-webm="' . $video_webm . '"
					data-video-ogg="' . $video_ogg . '"
					data-volume="' . $video_volume . '"
					data-lightbox="' . $content_lightbox . '"
					data-screen-size="' . $lightbox_size . '"
					data-share="' . $video_share . '"
					data-fallback="' . TS_VCSC_GetResourceURL("projekktor/swf/StrobeMediaPlayback/StrobeMediaPlayback.swf") . '"
					width="100%" 
					height="auto" 
					scrolling="no" 
					frameborder="0" 
					type="text/html" 
					mozallowfullscreen="mozallowfullscreen" 
					webkitallowfullscreen="webkitallowfullscreen" 
					allowfullscreen="allowfullscreen" 
					src="' . TS_VCSC_GetResourceURL("projekktor/iframe-video.html") . '">
				</iframe>';
			$output .= '</div>';
		}
		
		echo $output;
	
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>