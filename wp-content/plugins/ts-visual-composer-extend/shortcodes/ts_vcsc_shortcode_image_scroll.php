<?php
	add_shortcode('TS_VCSC_Image_Scroll', 'TS_VCSC_Image_Scroll_Function');
	function TS_VCSC_Image_Scroll_Function ($atts, $content = null) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
		
		// Check for Front End Editor
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
			$hover_frontent					= "true";
		} else {
			$hover_frontent					= "false";
		}

		wp_enqueue_style('dashicons');
		wp_enqueue_script('ts-extend-hammer');
		wp_enqueue_script('ts-extend-nacho');
		wp_enqueue_style('ts-extend-nacho');
		wp_enqueue_style('ts-extend-tooltipster');
		wp_enqueue_script('ts-extend-tooltipster');	
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'image'							=> '',
			'scroll_height'					=> 250,
			'scroll_speed_down'				=> 4,
			'scroll_speed_up'				=> 1,			
			
			'hover_event'					=> 'none',
			'hover_show_title'				=> 'true',
			'hover_link'					=> '',
			'hover_text'					=> '',
			'hover_title'					=> '',
			'hover_image'					=> '',
			'hover_link'					=> '',				
			'hover_video_link'				=> '',
			'hover_video_auto'				=> 'true',
			'hover_video_related'			=> 'false',				
			
			'overlay_handle_show'			=> 'true',
			'overlay_handle_color'			=> '#0094FF',
			
			'lightbox_group'				=> 'true',
			'lightbox_group_name'			=> '',
			'lightbox_size'					=> 'full',
			'lightbox_effect'				=> 'random',
			'lightbox_speed'				=> 5000,
			'lightbox_social'				=> 'false',
			'lightbox_backlight'			=> 'auto',
			'lightbox_backlight_color'		=> '#ffffff',
			
			'tooltip_html'					=> 'false',
			'tooltip_content'				=> '',
			'tooltip_content_html'			=> '',
			'tooltip_position'				=> 'ts-simptip-position-top',
			'tooltip_style'					=> '',
			'tooltipster_offsetx'			=> 0,
			'tooltipster_offsety'			=> 0,
			
			'margin_top'					=> 0,
			'margin_bottom'					=> 0,
			'el_id' 						=> '',
			'el_class'                  	=> '',
			'css'							=> '',
		), $atts ));
	
		$scroll_image 						= wp_get_attachment_image_src($image, 'full');
	
		$output = "";
		
		if (!empty($el_id)) {
			$scroll_image_id			= $el_id;
		} else {
			$scroll_image_id			= 'ts-vcsc-image-scroll-' . mt_rand(999999, 9999999);
		}

		// Tooltip
		if (($tooltip_position == "ts-simptip-position-top") || ($tooltip_position == "top")) {
			$tooltip_position				= "top";
		}
		if (($tooltip_position == "ts-simptip-position-left") || ($tooltip_position == "left")) {
			$tooltip_position				= "left";
		}
		if (($tooltip_position == "ts-simptip-position-right") || ($tooltip_position == "right")) {
			$tooltip_position				= "right";
		}
		if (($tooltip_position == "ts-simptip-position-bottom") || ($tooltip_position == "bottom")) {
			$tooltip_position				= "bottom";
		}
		$tooltip_class						= 'ts-has-tooltipster-tooltip';		
		if (($tooltip_style == "") || ($tooltip_style == "ts-simptip-style-black") || ($tooltip_style == "tooltipster-black")) {
			$tooltip_style					= "tooltipster-black";
		}
		if (($tooltip_style == "ts-simptip-style-gray") || ($tooltip_style == "tooltipster-gray")) {
			$tooltip_style					= "tooltipster-gray";
		}
		if (($tooltip_style == "ts-simptip-style-green") || ($tooltip_style == "tooltipster-green")) {
			$tooltip_style					= "tooltipster-green";
		}
		if (($tooltip_style == "ts-simptip-style-blue") || ($tooltip_style == "tooltipster-blue")) {
			$tooltip_style					= "tooltipster-blue";
		}
		if (($tooltip_style == "ts-simptip-style-red") || ($tooltip_style == "tooltipster-red")) {
			$tooltip_style					= "tooltipster-red";
		}
		if (($tooltip_style == "ts-simptip-style-orange") || ($tooltip_style == "tooltipster-orange")) {
			$tooltip_style					= "tooltipster-orange";
		}
		if (($tooltip_style == "ts-simptip-style-yellow") || ($tooltip_style == "tooltipster-yellow")) {
			$tooltip_style					= "tooltipster-yellow";
		}
		if (($tooltip_style == "ts-simptip-style-purple") || ($tooltip_style == "tooltipster-purple")) {
			$tooltip_style					= "tooltipster-purple";
		}
		if (($tooltip_style == "ts-simptip-style-pink") || ($tooltip_style == "tooltipster-pink")) {
			$tooltip_style					= "tooltipster-pink";
		}
		if (($tooltip_style == "ts-simptip-style-white") || ($tooltip_style == "tooltipster-white")) {
			$tooltip_style					= "tooltipster-white";
		}
		if ($tooltip_html == "true") {
			if (strlen($tooltip_content_html) != 0) {
				$Tooltip_Content		= 'data-tooltipster-title="" data-tooltipster-text="' . rawurldecode(base64_decode(strip_tags($tooltip_content_html))) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
				$Tooltip_Class			= $tooltip_class;
			} else {
				$Tooltip_Content		= '';
				$Tooltip_Class			= '';
			}
		} else {
			if (strlen($tooltip_content) != 0) {
				$Tooltip_Content		= 'data-tooltipster-title="" data-tooltipster-text="' . $tooltip_content . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
				$Tooltip_Class			= $tooltip_class;
			} else {
				$Tooltip_Content		= '';
				$Tooltip_Class			= '';
			}
		}		
		
		
		// iFrame / Link
		if (($hover_event == "link") || ($hover_event == "iframe")) {
			$link 							= ($hover_link == '||') ? '' : $hover_link;
			$link 							= vc_build_link($link);
			$a_href							= $link['url'];
			$a_title 						= '';
			$a_target 						= $link['target'];
		} else {
			$a_href							= 'javascript:void(0);';
			$a_title						= '';
			$a_target						= '_blank';
		}
		if ($a_href == '') {
			$a_href							= 'javascript:void(0);';
		}		
		// YouTube Video
		if ($hover_event == "youtube") {
			if (preg_match('~((http|https|ftp|ftps)://|www.)(.+?)~', $hover_video_link)) {
				$hover_video_link		= $hover_video_link;
			} else {
				$hover_video_link		= 'https://www.youtube.com/watch?v=' . $hover_video_link;
			}
		}
		// DailyMotion Video
		if ($hover_event == "dailymotion") {
			if (preg_match('~((http|https|ftp|ftps)://|www.)(.+?)~', $hover_video_link)) {
				$hover_video_link	= $hover_video_link;
			} else {			
				$hover_video_link	= $hover_video_link;
			}
		}
		
		// Handle Padding
		if ($overlay_handle_show == "true") {
			$overlay_margin					= "padding-bottom: 15px;";
			$switch_handle_adjust  			= "bottom: 0px;";
		} else {
			$overlay_margin					= "";
			$switch_handle_adjust  			= "";
		}
		$picstrips_margin 					= 'margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
		
		// Custom Width / Height
		$lightbox_dimensions				= '';
		
		if ($lightbox_backlight == "auto") {
			$nacho_color					= '';
		} else if ($lightbox_backlight == "custom") {
			$nacho_color					= 'data-color="' . $lightbox_backlight_color . '"';
		} else if ($lightbox_backlight == "hideit") {
			$nacho_color					= 'data-color="rgba(0, 0, 0, 0)"';
		}
		
		// Animation Speed
		$transition_down					= 'ts-image-scroll-down-' . $scroll_speed_down;
		$transition_up						= 'ts-image-scroll-up-' . $scroll_speed_up;
		
		// Link Output
		$linkString 						= '';
		if ($hover_frontent == "false") {
			if (($hover_event != "none") && ($hover_event == "popup")) {
				// Modal Popup
				$linkString .= '<a id="' . $scroll_image_id . '-trigger" href="#' . $scroll_image_id . '-modal" class="ts-image-scroll-link ts-image-scroll-link-popup ' . $scroll_image_id . '-parent nch-holder nch-lightbox-modal no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $hover_title . '" data-type="html" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '"></a>';
			} else if (($hover_event != "none") && ($hover_event == "iframe")) {
				// iFrame Popup
				$linkString .= '<a id="' . $scroll_image_id . '-trigger" href="' . $a_href . '" target="' . $a_target . '" class="ts-image-scroll-link ts-image-scroll-link-iframe ' . $scroll_image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $hover_title . '" data-type="iframe" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '"></a>';
			} else if (($hover_event != "none") && ($hover_event == "image")) {
				// Image Popup
				$linkString .= '<a id="' . $scroll_image_id . '-trigger" href="' . $scroll_image[0] . '" class="ts-image-scroll-link ts-image-scroll-link-image ' . $scroll_image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $hover_title . '" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '"></a>';
			} else if (($hover_event != "none") && ($hover_event == "youtube")) {
				// YouTube Popup
				$linkString .= '<a id="' . $scroll_image_id . '-trigger" href="' . $hover_video_link .'" class="ts-image-scroll-link ts-image-scroll-link-youtube ' . $scroll_image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $hover_title . '" data-related="' . $hover_video_related .'" data-videoplay="' . $hover_video_auto .'" data-type="youtube" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '"></a>';
			} else if (($hover_event != "none") && ($hover_event == "vimeo")) {
				// Vimeo Popup
				$linkString .= '<a id="' . $scroll_image_id . '-trigger" href="' . $hover_video_link . '" class="ts-image-scroll-link ts-image-scroll-link-vimeo ' . $scroll_image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $hover_title . '" data-videoplay="' . $hover_video_auto . '" data-type="vimeo" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '"></a>';
			} else if (($hover_event != "none") && ($hover_event == "dailymotion")) {
				// DailyMotion Popup
				$linkString .= '<a id="' . $scroll_image_id . '-trigger" href="' . $hover_video_link .'" class="ts-image-scroll-link ts-image-scroll-link-dailymotion ' . $scroll_image_id . '-parent nch-holder nch-lightbox-media" ' . $lightbox_dimensions . ' style="" data-title="' . $hover_title . '" data-videoplay="' . $hover_video_auto . '" data-type="dailymotion" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '"></a>';
			} else if (($hover_event != "none") && ($hover_event == "html5")) {
				// HTML5 Video Popup
				$linkString .= '<a id="' . $scroll_image_id . '-trigger" href="#' . $modal_id . '" class="ts-image-scroll-link ts-image-scroll-link-html5 ' . $scroll_image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $hover_title . '" data-type="html" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '"></a>';
			} else if (($hover_event != "none") && ($hover_event == "link")) {
				// Link Event
				$linkString .= '<a id="' . $scroll_image_id . '-trigger" class="ts-image-scroll-link ts-image-scroll-link-page" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '"></a>';
			} else {
				// No Link Event
				$linkString .= '';
			}
		}		
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Image_Scroll', $atts);
		} else {
			$css_class	= '';
		}
		
		$content_title						= '';

		$output .= '<div id="' . $scroll_image_id . '" class="ts-image-scroll-container ts-image-hover-frame ' . $Tooltip_Class . ' ' . $el_class . ' ' . $css_class . '"' . $Tooltip_Content . ' style="' . $picstrips_margin . '">';
			if ($overlay_handle_show == "true") {
				$output .= '<div class="" style="width: 100%; height: 100%; ' . $overlay_margin . '">';
			}
				// Scroll Image
					$output .= '<div class="ts-image-scroll-wrapper" style="min-height: ' . $scroll_height . 'px;" data-image-height="' . $scroll_height . '" data-image-path="' . $scroll_image[0] . '" data-transition-up="' . $scroll_speed_up . '" data-transition-down="' . $scroll_speed_down . '">';
						$output .= '<div class="ts-image-scroll-inner">';
							$output .= '<div class="ts-image-scroll-holder">';
								$output .= '<div class="ts-image-scroll-background ' . $transition_down . ' ' . $transition_up . '" style="background-image: url(' . $scroll_image[0] . '); min-height: ' . $scroll_height . 'px;"></div>';
								$output .= $linkString;
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				
				// Overlay Handle
				if ($overlay_handle_show == "true") {
					$output .= '<div class="ts-image-hover-handle" style="' . $switch_handle_adjust . '"><span class="frame_handle_hover" style="background-color: ' . $overlay_handle_color . '"><i class="handle_hover"></i></span></div>';
				}
			if ($overlay_handle_show == "true") {
				$output .= '</div>';
			}			
			// Create hidden DIV with Modal Popup iHover Content
			if (($hover_frontent == "false") && ($hover_event == "popup")) {
				$output .= '<div id="' . $scroll_image_id . '-modal" class="ts-modal-content nch-hide-if-javascript" style="display: none; padding: 15px;">';
					$output .= '<div class="ts-modal-white-header"></div>';
					$output .= '<div class="ts-modal-white-frame" style="">';
						$output .= '<div class="ts-modal-white-inner">';
							if ($hover_title != "") {
								$output .= '<h2 style="border-bottom: 1px solid #eeeeee; padding-bottom: 10px; margin-bottom: 10px;">' . $hover_title . '</h2>';
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