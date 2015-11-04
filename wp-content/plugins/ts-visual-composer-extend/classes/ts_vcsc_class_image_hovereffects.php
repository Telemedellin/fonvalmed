<?php
if (!class_exists('TS_Image_Hover_Effects')){
	class TS_Image_Hover_Effects {
		function __construct() {
			global $VISUAL_COMPOSER_EXTENSIONS;
            if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
                add_action('init',                                  	array($this, 'TS_VCSC_Image_Hover_Effects_Elements'), 9999999);
            } else {
                add_action('admin_init',		                    	array($this, 'TS_VCSC_Image_Hover_Effects_Elements'), 9999999);
            }
            add_shortcode('TS_VCSC_Image_Hover_Effects',				array($this, 'TS_VCSC_Image_Hover_Effects_Function'));
		}
        
        // Image Hover Effects
        function TS_VCSC_Image_Hover_Effects_Function ($atts, $content = null) {
            global $VISUAL_COMPOSER_EXTENSIONS;
            ob_start();

            extract( shortcode_atts( array(
                'hover_image'					=> '',
				'hover_size'					=> 'medium',
				'hover_responsive'				=> 'true',
				'hover_truncate'				=> 'false',
				
				'effect_style_type'				=> 'text',
				'effect_style_text'				=> 'ts-hover-effect-lily',
				'effect_style_icons'			=> 'ts-hover-effect-zoe',
				'effect_permanent'				=> 'false',
				
				'custom_styling'				=> 'false',
				'custom_overlay'				=> '#3085a3',
				
				'size_type'						=> 'auto',
				'size_percent'					=> 100,
				'size_pixels'					=> 400,
				'size_align'					=> 'center',
				
				'title_text'					=> '',
				'title_color'					=> '#ffffff',				
				'content_text'					=> '',
				'content_color_text'			=> '#ffffff',
				'content_color_icons'			=> '#000000',
				'content_color_other'			=> '#ffffff',
				
				'content_icons'					=> '',
				'content_link1'					=> '',
				'content_link1_icon'			=> '',
				'content_link1_tooltip'			=> '',
				'content_link2'					=> '',
				'content_link2_icon'			=> '',
				'content_link2_tooltip'			=> '',
				'content_link3'					=> '',
				'content_link3_icon'			=> '',
				'content_link3_tooltip'			=> '',
				'content_link4'					=> '',
				'content_link4_icon'			=> '',
				'content_link4_tooltip'			=> '',

				'hover_event'					=> 'none',
				'hover_show_title'				=> 'true',
				'hover_link'					=> '',
				'hover_text'					=> '',
				'hover_image'					=> '',
				'hover_link'					=> '',				
				'hover_video_link'				=> '',
				'hover_video_auto'				=> 'true',
				'hover_video_related'			=> 'false',				
				
				'overlay_trigger'				=> 'ts-trigger-hover',
				'overlay_handle_show'			=> 'true',
				'overlay_handle_color'			=> '#0094FF',
				
				'tooltip_html'					=> 'false',
				'tooltip_content'				=> '',
				'tooltip_content_html'			=> '',
				'tooltip_position'				=> 'ts-simptip-position-top',
				'tooltip_style'					=> '',
				'tooltipster_offsetx'			=> 0,
				'tooltipster_offsety'			=> 0,
				
				'lightbox_group'				=> 'false',
				'lightbox_group_name'			=> '',
				'lightbox_size'					=> 'full',
				'lightbox_effect'				=> 'random',
				'lightbox_speed'				=> 5000,
				'lightbox_social'				=> 'false',
				'lightbox_backlight_choice'		=> 'predefined',
				'lightbox_backlight_color'		=> '#0084E2',
				'lightbox_backlight_custom'		=> '#000000',
				
				'lightbox_custom_padding'		=> 15,
				'lightbox_custom_background'	=> 'none',
				'lightbox_background_image'		=> '',
				'lightbox_background_size'		=> 'cover',
				'lightbox_background_repeat'	=> 'no-repeat',
				'lightbox_background_color'		=> '#ffffff',
				
                'margin_top'					=> 0,
                'margin_bottom'					=> 0,
                'el_id' 						=> '',
                'el_class'              		=> '',
				'css'							=> '',
            ), $atts ));
            
            $output                             = '';
			$linkStringStart					= '';
			$linkStringEnd						= '';
			
			// Check for Front End Editor
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$hover_frontent					= "true";
			} else {
				$hover_frontent					= "false";
			}

			if (($hover_frontent == "false") && ($hover_event != 'none')) {
				wp_enqueue_script('ts-extend-hammer');
				wp_enqueue_script('ts-extend-nacho');
				wp_enqueue_style('ts-extend-nacho');
			}	
			wp_enqueue_style('ts-extend-tooltipster');
			wp_enqueue_script('ts-extend-tooltipster');	
			wp_enqueue_style('ts-extend-hovereffects');
			wp_enqueue_script('ts-extend-badonkatrunc');
			wp_enqueue_style('ts-font-teammates');
			wp_enqueue_style('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-front');
        
            if (!empty($el_id)) {
                $hover_image_id					= $el_id;
            } else {
                $hover_image_id					= 'ts-vcsc-hover-effects-' . mt_rand(999999, 9999999);
            }
			
			if ($effect_permanent == "true") {
				$overlay_handle_show			= "false";
			}
			
			// Effect Style
			if ($effect_style_type == "text") {
				$effect_style					= $effect_style_text;
			} else {
				$effect_style					= $effect_style_icons;
			}			
			// Image
			if (!empty($hover_image)) {
				if ($hover_event == "image") {
					$hover_image_link			= wp_get_attachment_image_src($hover_image, $lightbox_size);
				}
				$hover_image					= wp_get_attachment_image_src($hover_image, $hover_size);
			} else {
				$hover_image_link				= array();
			}
			// Content Icon Links
			$link_content1 						= ($content_link1 == '||') ? '' : $content_link1;
			$link_content1 						= vc_build_link($link_content1);
			$a_href_content1					= $link_content1['url'];
			$a_title_content1 					= $link_content1['title'];
			$a_target_content1 					= $link_content1['target'];			
			$link_content2 						= ($content_link2 == '||') ? '' : $content_link2;
			$link_content2 						= vc_build_link($link_content2);
			$a_href_content2					= $link_content2['url'];
			$a_title_content2 					= $link_content2['title'];
			$a_target_content2 					= $link_content2['target'];
			$link_content3 						= ($content_link3 == '||') ? '' : $content_link3;
			$link_content3 						= vc_build_link($link_content3);
			$a_href_content3					= $link_content3['url'];
			$a_title_content3 					= $link_content3['title'];
			$a_target_content3 					= $link_content3['target'];
			$link_content4 						= ($content_link4 == '||') ? '' : $content_link4;
			$link_content4 						= vc_build_link($link_content4);
			$a_href_content4					= $link_content4['url'];
			$a_title_content4 					= $link_content4['title'];
			$a_target_content4 					= $link_content4['target'];			
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
			
			// Backlight Color
			if ($lightbox_backlight_choice == "predefined") {
				$lightbox_backlight_selection	= $lightbox_backlight_color;
			} else {
				$lightbox_backlight_selection	= $lightbox_backlight_custom;
			}
	
			// Custom Width / Height
			$lightbox_dimensions				= '';
			
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
			
			// Handle Padding
			if ($overlay_handle_show == "true") {
				$overlay_padding				= "padding-bottom: 25px;";
				$switch_handle_adjust  			= "";
			} else {
				$overlay_padding				= "";
				$switch_handle_adjust  			= "";
			}
			
			// Handle Icon
			if ($hover_event != "none") {
				$switch_handle_icon				= 'handle_click';
			} else {
				$switch_handle_icon				= 'handle_hover';
			}
			
			// Size Settings
			if ($size_type == 'auto') {
				$element_dimensions				= '';
			} else if ($size_type == 'percent') {
				$element_dimensions				= 'width: ' . $size_percent . '%;';
			} else if ($size_type == 'pixels') {
				$element_dimensions				= 'width: ' . $size_pixels . 'px;';
			}
			if ($size_type != 'auto') {
				if ($size_align == 'center') {
					$element_dimensions			.= 'float: none; margin-left: auto; margin-right: auto;';
				} else if ($size_align == 'left') {
					$element_dimensions			.= 'float: left; margin-left: 0; margin-right: 0;';
				} else if ($size_align == 'right') {
					$element_dimensions			.= 'float: right; margin-left: 0; margin-right: 0;';
				}
			}
			
			// Make Effect Permanent
			if ($effect_permanent == "true") {
				$Permanent_Class			= 'ts-hover-effect-permanent';
				$Permanent_Link				= 'ts-hover-image-link-permanent';
			} else {
				$Permanent_Class			= '';
				$Permanent_Link				= 'ts-hover-image-link-trigger';
			}
			// Link Output
			if (($hover_frontent == "false") && ($effect_style != "ts-hover-effect-zoe") && ($effect_style != "ts-hover-effect-hera") && ($effect_style != "ts-hover-effect-winston") && ($effect_style != "ts-hover-effect-terry") && ($effect_style != "ts-hover-effect-phoebe") && ($effect_style != "ts-hover-effect-kira")) {
				if (($hover_event != "none") && ($hover_event == "popup")) {
					// Modal Popup
					$linkStringStart 	.= '<a id="' . $hover_image_id . '-trigger" href="#' . $hover_image_id . '-modal" class="ts-hover-image-link ' . $Permanent_Link . ' ' . $hover_image_id . '-parent nch-holder nch-lightbox-modal no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $title_text . '" data-type="html" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-share="0" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
					$linkStringEnd		.= '</a>';
				} else if (($hover_event != "none") && ($hover_event == "iframe")) {
					// iFrame Popup
					$linkStringStart 	.= '<a id="' . $hover_image_id . '-trigger" href="' . $a_href . '" target="' . $a_target . '" class="ts-hover-image-link ' . $Permanent_Link . ' ' . $hover_image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $title_text . '" data-type="iframe" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-share="0" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
					$linkStringEnd		.= '</a>';
				} else if (($hover_event != "none") && ($hover_event == "image")) {
					// Image Popup
					$linkStringStart 	.= '<a id="' . $hover_image_id . '-trigger" href="' . $hover_image_link[0] . '" class="ts-hover-image-link ' . $Permanent_Link . ' ' . $hover_image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $title_text . '" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
					$linkStringEnd		.= '</a>';
				} else if (($hover_event != "none") && ($hover_event == "youtube")) {
					// YouTube Popup
					$linkStringStart 	.= '<a id="' . $hover_image_id . '-trigger" href="' . $hover_video_link .'" class="ts-hover-image-link ' . $Permanent_Link . ' ' . $hover_image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $title_text . '" data-related="' . $hover_video_related .'" data-videoplay="' . $hover_video_auto .'" data-type="youtube" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-share="0" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
					$linkStringEnd		.= '</a>';
				} else if (($hover_event != "none") && ($hover_event == "vimeo")) {
					// Vimeo Popup
					$linkStringStart 	.= '<a id="' . $hover_image_id . '-trigger" href="' . $hover_video_link . '" class="ts-hover-image-link ' . $Permanent_Link . ' ' . $hover_image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $title_text . '" data-videoplay="' . $hover_video_auto . '" data-type="vimeo" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-share="0" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
					$linkStringEnd		.= '</a>';
				} else if (($hover_event != "none") && ($hover_event == "dailymotion")) {
					// DailyMotion Popup
					$linkStringStart 	.= '<a id="' . $hover_image_id . '-trigger" href="' . $hover_video_link .'" class="ts-hover-image-link ' . $Permanent_Link . ' ' . $hover_image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $title_text . '" data-videoplay="' . $hover_video_auto . '" data-type="dailymotion" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-share="0" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
					$linkStringEnd		.= '</a>';
				} else if (($hover_event != "none") && ($hover_event == "html5")) {
					// HTML5 Video Popup
					$linkStringStart 	.= '<a id="' . $hover_image_id . '-trigger" href="#' . $hover_image_id . '-modal" class="ts-hover-image-link ' . $Permanent_Link . ' ' . $hover_image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $title_text . '" data-type="html" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-share="0" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
					$linkStringEnd		.= '</a>';
				} else if (($hover_event != "none") && ($hover_event == "link")) {
					// Link Event
					$linkStringStart 	.= '<a id="' . $hover_image_id . '-trigger" class="ts-hover-image-link ' . $Permanent_Link . ' ' . $hover_image_id . '-parent" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '">';
					$linkStringEnd		.= '</a>';
				} else {
					// No Link Event
					$linkStringStart 	= '';
					$linkStringEnd		= '';
				}
			} else {
				$linkStringStart 		= '';
				$linkStringEnd			= '';
			}
			
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
			$tooltip_class					= 'ts-has-tooltipster-tooltip';		
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
			if ($tooltip_html == "true") {
				if (strlen($tooltip_content_html) != 0) {
					$Tooltip_Content		= 'data-tooltipster-html="true" data-tooltipster-title="" data-tooltipster-text="' . rawurldecode(base64_decode(strip_tags($tooltip_content_html))) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
					$Tooltip_Class			= $tooltip_class;
				} else {
					$Tooltip_Content		= '';
					$Tooltip_Class			= '';
				}
			} else {
				if (strlen($tooltip_content) != 0) {
					$Tooltip_Content		= 'data-tooltipster-html="false" data-tooltipster-title="" data-tooltipster-text="' . $tooltip_content . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
					$Tooltip_Class			= $tooltip_class;
				} else {
					$Tooltip_Content		= '';
					$Tooltip_Class			= '';
				}
			}
			// Icon Tooltip
			if (strlen($content_link1_tooltip) != 0) {
				$Tooltip_Link1_Icon			= 'data-tooltipster-html="true" data-tooltipster-title="" data-tooltipster-text="' . strip_tags($content_link1_tooltip) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . ($tooltipster_offsety + 10) . '"';
				$Tooltip_Link1_Class		= $tooltip_class;
			} else {
				$Tooltip_Link1_Icon			= '';
				$Tooltip_Link1_Class		= '';
			}
			if (strlen($content_link2_tooltip) != 0) {
				$Tooltip_Link2_Icon			= 'data-tooltipster-html="true" data-tooltipster-title="" data-tooltipster-text="' . strip_tags($content_link2_tooltip) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . ($tooltipster_offsety + 10) . '"';
				$Tooltip_Link2_Class		= $tooltip_class;
			} else {
				$Tooltip_Link2_Icon			= '';
				$Tooltip_Link2_Class		= '';
			}
			if (strlen($content_link3_tooltip) != 0) {
				$Tooltip_Link3_Icon			= 'data-tooltipster-html="true" data-tooltipster-title="" data-tooltipster-text="' . strip_tags($content_link3_tooltip) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . ($tooltipster_offsety + 10) . '"';
				$Tooltip_Link3_Class		= $tooltip_class;
			} else {
				$Tooltip_Link3_Icon			= '';
				$Tooltip_Link3_Class		= '';
			}
			if (strlen($content_link4_tooltip) != 0) {
				$Tooltip_Link4_Icon			= 'data-tooltipster-html="true" data-tooltipster-title="" data-tooltipster-text="' . strip_tags($content_link4_tooltip) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . ($tooltipster_offsety + 10) . '"';
				$Tooltip_Link4_Class		= $tooltip_class;
			} else {
				$Tooltip_Link4_Icon			= '';
				$Tooltip_Link4Class		= '';
			}
			// Create Final Output
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-hover-effects-container ts-image-effects-frame ts-image-hover-frame ' . $el_class . '' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Image_Hover_Effects', $atts);
			} else {
				$css_class	= 'ts-hover-effects-container ts-image-effects-frame ts-image-hover-frame ' . $el_class . '';
			}
			
			$output .= '<div id="' . $hover_image_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; ' . $element_dimensions . '">';
				if ((strlen($tooltip_content_html) != 0) || (strlen($tooltip_content) != 0)) {
					$output .= '<div class="' . $Tooltip_Class . '" ' . $Tooltip_Content . ' style="width: 100%; height: 100%;">';
				}
					if ($overlay_handle_show == "true") {
						$output .= '<div class="" style="' . $overlay_padding . '">';
					}				
						$output .= '<div class="ts-hover-effects-grid">';					
							$output .= $linkStringStart;
								$output .= '<figure class="' . $effect_style . ' ' . $Permanent_Class . '" style="' . ($custom_styling == "true" ? "background: " . $custom_overlay . ";" : "") . '">';
									$output .= '<img src="' . $hover_image[0] . '" data-no-lazy="1" data-width="' . $hover_image[1] . '" data-height="' . $hover_image[2] . '" data-ratio="' . ($hover_image[1] / $hover_image[2]) . '" alt=""/>';
									$output .= '<figcaption class="ts-hover-effects-figcaption">';
										if (($effect_style == "ts-hover-effect-lily") || ($effect_style == "ts-hover-effect-julia")) {
											$output .= '<div>';
										}
											$output .= '<h2 style="color: ' . $title_color . '">' . $title_text . '</h2>';
											if (($effect_style != "ts-hover-effect-zoe") && ($effect_style != "ts-hover-effect-hera") && ($effect_style != "ts-hover-effect-winston") && ($effect_style != "ts-hover-effect-terry") && ($effect_style != "ts-hover-effect-kira")) {
												$output .= '<p style="color: ' . $content_color_text . '">' . $content_text . '</p>';
											}
											if ($effect_style == "ts-hover-effect-zoe") {
												$output .= '<p class="icon-links" style="color: ' . $content_color_icons . '">';
													if (($a_href_content1 != "") && ($content_link1_icon != "")) {
														$output .= '<a href="' . $a_href_content1 . '" target="' . $a_target_content1 . '" class="' . $Tooltip_Link1_Class . '" title="' . $a_title_content1 . '" ' . $Tooltip_Link1_Icon . '><span style="color: ' . $content_color_icons . '" class="ts-teammate-icon ' . $content_link1_icon . '"></span></a>';
													}
													if (($a_href_content2 != "") && ($content_link2_icon != "")) {
														$output .= '<a href="' . $a_href_content2 . '" target="' . $a_target_content2 . '" class="' . $Tooltip_Link1_Class . '" title="' . $a_title_content2 . '" ' . $Tooltip_Link2_Icon . '><span style="color: ' . $content_color_icons . '" class="ts-teammate-icon ' . $content_link2_icon . '"></span></a>';
													}
													if (($a_href_content3 != "") && ($content_link3_icon != "")) {
														$output .= '<a href="' . $a_href_content3 . '" target="' . $a_target_content3 . '" class="' . $Tooltip_Link1_Class . '" title="' . $a_title_content3 . '" ' . $Tooltip_Link3_Icon . '><span style="color: ' . $content_color_icons . '" class="ts-teammate-icon ' . $content_link3_icon . '"></span></a>';
													}
												$output .= '</p>';
												$output .= '<p class="description" style="color: ' . $content_color_other . '">' . $content_icons . '</p>';
											}
											if (($effect_style == "ts-hover-effect-hera") || ($effect_style == "ts-hover-effect-terry") || ($effect_style == "ts-hover-effect-kira")) {
												$output .= '<p style="color: ' . $content_color_icons . '">';
													if (($a_href_content1 != "") && ($content_link1_icon != "")) {
														$output .= '<a href="' . $a_href_content1 . '" target="' . $a_target_content1 . '" class="' . $Tooltip_Link1_Class . '" title="' . $a_title_content1 . '" ' . $Tooltip_Link1_Icon . '><i style="color: ' . $content_color_icons . '" class="ts-teammate-icon ' . $content_link1_icon . '"></i></a>';
													}
													if (($a_href_content2 != "") && ($content_link2_icon != "")) {
														$output .= '<a href="' . $a_href_content2 . '" target="' . $a_target_content2 . '" class="' . $Tooltip_Link1_Class . '" title="' . $a_title_content2 . '" ' . $Tooltip_Link2_Icon . '><i style="color: ' . $content_color_icons . '" class="ts-teammate-icon ' . $content_link2_icon . '"></i></a>';
													}
													if (($a_href_content3 != "") && ($content_link3_icon != "")) {
														$output .= '<a href="' . $a_href_content3 . '" target="' . $a_target_content3 . '" class="' . $Tooltip_Link1_Class . '" title="' . $a_title_content3 . '" ' . $Tooltip_Link3_Icon . '><i style="color: ' . $content_color_icons . '" class="ts-teammate-icon ' . $content_link3_icon . '"></i></a>';
													}
													if (($a_href_content4 != "") && ($content_link4_icon != "")) {
														$output .= '<a href="' . $a_href_content4 . '" target="' . $a_target_content4 . '" class="' . $Tooltip_Link1_Class . '" title="' . $a_title_content4 . '" ' . $Tooltip_Link4_Icon . '><i style="color: ' . $content_color_icons . '" class="ts-teammate-icon ' . $content_link4_icon . '"></i></a>';
													}
												$output .= '</p>';
											}
											if (($effect_style == "ts-hover-effect-winston") || ($effect_style == "ts-hover-effect-phoebe")) {
												$output .= '<p style="color: ' . $content_color_icons . '">';
													if (($a_href_content1 != "") && ($content_link1_icon != "")) {
														$output .= '<a href="' . $a_href_content1 . '" target="' . $a_target_content1 . '" class="' . $Tooltip_Link1_Class . '" title="' . $a_title_content1 . '" ' . $Tooltip_Link1_Icon . '><i style="color: ' . $content_color_icons . '" class="ts-teammate-icon ' . $content_link1_icon . '"></i></a>';
													}
													if (($a_href_content2 != "") && ($content_link2_icon != "")) {
														$output .= '<a href="' . $a_href_content2 . '" target="' . $a_target_content2 . '" class="' . $Tooltip_Link1_Class . '" title="' . $a_title_content2 . '" ' . $Tooltip_Link2_Icon . '><i style="color: ' . $content_color_icons . '" class="ts-teammate-icon ' . $content_link2_icon . '"></i></a>';
													}
													if (($a_href_content3 != "") && ($content_link3_icon != "")) {
														$output .= '<a href="' . $a_href_content3 . '" target="' . $a_target_content3 . '" class="' . $Tooltip_Link1_Class . '" title="' . $a_title_content3 . '" ' . $Tooltip_Link3_Icon . '><i style="color: ' . $content_color_icons . '" class="ts-teammate-icon ' . $content_link3_icon . '"></i></a>';
													}
												$output .= '</p>';
											}
										if (($effect_style == "ts-hover-effect-lily") || ($effect_style == "ts-hover-effect-julia")) {
											$output .= '</div>';
										}
									$output .= '</figcaption>';	
								$output .= '</figure>';
							$output .= $linkStringEnd;
						$output .= '</div>';				
						if ($overlay_handle_show == "true") {
							$output .= '<div class="ts-image-hover-handle" style="' . $switch_handle_adjust . '"><span class="frame_' . $switch_handle_icon . '" style="background-color: ' . $overlay_handle_color . '"><i class="' . $switch_handle_icon . '"></i></span></div>';
						}
					if ($overlay_handle_show == "true") {
						$output .= '</div>';
					}
				if ((strlen($tooltip_content_html) != 0) || (strlen($tooltip_content) != 0)) {
					$output .= '</div>';
				}
				// Create hidden DIV with Modal Popup Hover Content
				if (($hover_frontent == "false") && ($hover_event == "popup")) {
					$output .= '<div id="' . $hover_image_id . '-modal" class="ts-modal-content nch-hide-if-javascript ' . $el_class . '" style="display: none; padding: ' . $lightbox_custom_padding . 'px; ' . $lightbox_background . '">';
						$output .= '<div class="ts-modal-white-header"></div>';
						$output .= '<div class="ts-modal-white-frame" style="">';
							$output .= '<div class="ts-modal-white-inner">';
								if (($hover_show_title == "true") && ($title_text != "")) {
									$output .= '<h2 style="border-bottom: 1px solid #eeeeee; padding-bottom: 10px; margin-bottom: 10px;">' . $title_text . '</h2>';
								}
								$output .= rawurldecode(base64_decode(strip_tags($hover_text)));
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				}
			$output .= '</div>';
			
            echo $output;
            
            $myvariable = ob_get_clean();
            return $myvariable;
        }    
		// Add Image Hover Effects Elements
        function TS_VCSC_Image_Hover_Effects_Elements() {
            global $VISUAL_COMPOSER_EXTENSIONS;
            if (function_exists('vc_map')) {
                vc_map( array(
                    "name"                              => __( "TS Image Advanced Overlay", "ts_visual_composer_extend" ),
                    "base"                              => "TS_VCSC_Image_Hover_Effects",
                    "icon" 	                            => "icon-wpb-ts_vcsc_image_hovereffects",
                    "class"                             => "",
                    "category"                          => __( 'VC Extensions', "ts_visual_composer_extend" ),
                    "description"                       => __("Place an image with Hover effects", "ts_visual_composer_extend"),
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
                    "params"                            => array(
                        // Style Selection
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_1",
							"value"						=> "",
                            "seperator"					=> "Hover Selection",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
						array(
							"type"                  	=> "attach_image",
							"holder" 					=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? "img" : ""),
							"heading"               	=> __( "Image", "ts_visual_composer_extend" ),
							"param_name"            	=> "hover_image",
							"class"						=> "ts_vcsc_holder_image",
							"value"                 	=> "",
							"admin_label"       		=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? false : true),
							"description"           	=> __( "Select the image you want to use with the Hover effect.", "ts_visual_composer_extend" )
						),
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Image Source", "ts_visual_composer_extend" ),
							"param_name"            	=> "hover_size",
							"width"                 	=> 150,
							"value"                 	=> array(
								__( 'Medium Size Image', "ts_visual_composer_extend" )					=> "medium",
								__( 'Thumbnail Size Image', "ts_visual_composer_extend" )				=> "thumbnail",
								__( 'Large Size Image', "ts_visual_composer_extend" )					=> "large",
								__( 'Full Size Image', "ts_visual_composer_extend" )					=> "full",
							),
							"description"           	=> __( "Select which image size based on WordPress settings should be used for the preview image.", "ts_visual_composer_extend" ),
							"dependency"            	=> ""
						),
						array(
							"type"				    	=> "dropdown",
							"class"				    	=> "",
							"heading"			    	=> __( "Element Sizing", "ts_visual_composer_extend" ),
							"param_name"		    	=> "size_type",
							"value"                 	=> array(
								__("Full Column Width", "ts_visual_composer_extend")					=> "auto",
								__("Width in Percent of Column", "ts_visual_composer_extend")			=> "percent",
								__("Fixed Width in Pixels", "ts_visual_composer_extend")				=> "pixels",
							),
							"description"		    	=> __( "Select the general style for the Hover effect.", "ts_visual_composer_extend" ),
						),
						array(
							"type"						=> "nouislider",
							"heading"					=> __( "Width in Percent", "ts_visual_composer_extend" ),
							"param_name"				=> "size_percent",
							"value"						=> "100",
							"min"						=> "10",
							"max"						=> "100",
							"step"						=> "1",
							"unit"						=> '%',
							"description"				=> __( "Define a width in percent of the column the element is embedded in.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "size_type", 'value' => 'percent' ),
						),	
						array(
							"type"						=> "nouislider",
							"heading"					=> __( "Fixed Width in Pixels", "ts_visual_composer_extend" ),
							"param_name"				=> "size_pixels",
							"value"						=> "400",
							"min"						=> "200",
							"max"						=> "1024",
							"step"						=> "1",
							"unit"						=> 'px',
							"description"				=> __( "Define a fixed width for the element; all responsiveness will be lost.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "size_type", 'value' => 'pixels' ),
						),
						array(
							"type"				    	=> "dropdown",
							"class"				    	=> "",
							"heading"			    	=> __( "Element Alignment", "ts_visual_composer_extend" ),
							"param_name"		    	=> "size_align",
							"value"                 	=> array(
								__("Center", "ts_visual_composer_extend")								=> "center",
								__("Left", "ts_visual_composer_extend")									=> "left",
								__("Right", "ts_visual_composer_extend")								=> "right",
							),
							"description"		    	=> __( "Select how the element should be aligned inside the column.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "size_type", 'value' => array('percent', 'pixels') ),
						),
						array(
							"type"				    	=> "dropdown",
							"class"				    	=> "",
							"heading"			    	=> __( "Effect Style", "ts_visual_composer_extend" ),
							"param_name"		    	=> "effect_style_type",
							"value"                 	=> array(
								__("Overlay with Text", "ts_visual_composer_extend")	=> "text",
								__("Overlay with Icons", "ts_visual_composer_extend")	=> "icons",
							),
							"description"		    	=> __( "Select the general style for the Hover effect.", "ts_visual_composer_extend" ),
							"admin_label"       		=> true,
							"dependency"		    	=> "",
						),
						array(
							"type"				    	=> "dropdown",
							"class"				    	=> "",
							"heading"			    	=> __( "Text Style", "ts_visual_composer_extend" ),
							"param_name"		    	=> "effect_style_text",
							"value"                 	=> array(
								__("Nice Lily", "ts_visual_composer_extend")			=> "ts-hover-effect-lily",
								__("Holy Sadie", "ts_visual_composer_extend")			=> "ts-hover-effect-sadie",
								__("Dreamy Honey", "ts_visual_composer_extend")			=> "ts-hover-effect-honey",
								__("Crazy Layla", "ts_visual_composer_extend")			=> "ts-hover-effect-layla",								
								__("Warm Oscar", "ts_visual_composer_extend")			=> "ts-hover-effect-oscar",
								__("Sweet Marley", "ts_visual_composer_extend")			=> "ts-hover-effect-marley",
								__("Glowing Ruby", "ts_visual_composer_extend")			=> "ts-hover-effect-ruby",
								__("Charming Roxy", "ts_visual_composer_extend")		=> "ts-hover-effect-roxy",
								__("Fresh Bubba", "ts_visual_composer_extend")			=> "ts-hover-effect-bubba",
								__("Wild Romeo", "ts_visual_composer_extend")			=> "ts-hover-effect-romeo",
								__("Strange Dexter", "ts_visual_composer_extend")		=> "ts-hover-effect-dexter",
								__("Free Sarah", "ts_visual_composer_extend")			=> "ts-hover-effect-sarah",
								__("Silly Chico", "ts_visual_composer_extend")			=> "ts-hover-effect-chico",
								__("Faithful Milo", "ts_visual_composer_extend")		=> "ts-hover-effect-milo",
								__("Passionate Julia", "ts_visual_composer_extend")		=> "ts-hover-effect-julia",
								__("Thoughtful Goliath", "ts_visual_composer_extend")	=> "ts-hover-effect-goliath",
								__("Happy Selena", "ts_visual_composer_extend")			=> "ts-hover-effect-selena",
								__("Strong Apollo", "ts_visual_composer_extend")		=> "ts-hover-effect-apollo",
								__("Lonely Steve", "ts_visual_composer_extend")			=> "ts-hover-effect-steve",
								__("Cute Moses", "ts_visual_composer_extend")			=> "ts-hover-effect-moses",
								__("Dynamic Jazz", "ts_visual_composer_extend")			=> "ts-hover-effect-jazz",
								__("Funny Ming", "ts_visual_composer_extend")			=> "ts-hover-effect-ming",
								__("Altruistic Lexi", "ts_visual_composer_extend")		=> "ts-hover-effect-lexi",
								__("Messy Duke", "ts_visual_composer_extend")			=> "ts-hover-effect-duke",
							),
							"description"		    	=> __( "Select the general style for the Hover effect.", "ts_visual_composer_extend" ),
							"admin_label"       		=> true,
							"dependency"            	=> array( 'element' => "effect_style_type", 'value' => 'text' ),
						),
						array(
							"type"				    	=> "dropdown",
							"class"				    	=> "",
							"heading"			    	=> __( "Icon Style", "ts_visual_composer_extend" ),
							"param_name"		    	=> "effect_style_icons",
							"value"                 	=> array(
								__("Creative Zoe", "ts_visual_composer_extend")			=> "ts-hover-effect-zoe",
								__("Tender Hera", "ts_visual_composer_extend")			=> "ts-hover-effect-hera",
								__("Jolly Winston", "ts_visual_composer_extend")		=> "ts-hover-effect-winston",
								__("Noisy Terry", "ts_visual_composer_extend")			=> "ts-hover-effect-terry",
								__("Plain Pheobe", "ts_visual_composer_extend")			=> "ts-hover-effect-phoebe",
								__("Dark Kira", "ts_visual_composer_extend")			=> "ts-hover-effect-kira",
							),
							"description"		    	=> __( "Select the general style for the Hover effect.", "ts_visual_composer_extend" ),
							"admin_label"       		=> true,
							"dependency"            	=> array( 'element' => "effect_style_type", 'value' => 'icons' ),
						),
						array(
							"type"             	 		=> "switch_button",
							"heading"               	=> __( "Always Show Overlay", "ts_visual_composer_extend" ),
							"param_name"            	=> "effect_permanent",
							"value"                 	=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"admin_label"       		=> true,
							"description"       		=> __( "Use the toggle to always show the overlay content or show on hover only.", "ts_visual_composer_extend" ),
						),						
						array(
							"type"             	 		=> "switch_button",
							"heading"               	=> __( "Custom Overlay Background", "ts_visual_composer_extend" ),
							"param_name"            	=> "custom_styling",
							"value"                 	=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Use the toggle to apply a custom background color to the overlay style you selected.", "ts_visual_composer_extend" ),
						),
						array(
							"type"                  	=> "colorpicker",
							"heading"              	 	=> __( "Overlay Background Color", "ts_visual_composer_extend" ),
							"param_name"            	=> "custom_overlay",
							"value"                 	=> "#3085a3",
							"description"           	=> __( "Define the background color for the overlay style you selected.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "custom_styling", 'value' => 'true' ),
						),						
						// Content Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_2",
							"value"						=> "",
                            "seperator"					=> "Hover Content",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Content",
                        ),
						array(
							"type"						=> "textfield",
							"heading"					=> __( "Title", "ts_visual_composer_extend" ),
							"param_name"				=> "title_text",
							"value"						=> "",
							"admin_label"       		=> true,
							"description"				=> __( "Enter a title to be used for the Hover effect.", "ts_visual_composer_extend" ),
							"group" 			        => "Content",
						),
						array(
							"type"                  	=> "colorpicker",
							"heading"              	 	=> __( "Title Color", "ts_visual_composer_extend" ),
							"param_name"            	=> "title_color",
							"value"                 	=> "#ffffff",
							"description"           	=> __( "Define the color for the title text.", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
							"group" 			        => "Content",
						),
						array(
							"type"                  	=> "textarea",
							"class"                 	=> "",
							"heading"               	=> __( "Message", "ts_visual_composer_extend" ),
							"param_name"            	=> "content_text",
							"value"                 	=> "",
							"description"	        	=> __( "Enter a short message to be used for the Hover effect; HTML code can NOT be used.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "effect_style_type", 'value' => 'text' ),
							"group" 					=> "Content",
						),
						array(
							"type"                  	=> "textarea",
							"class"                 	=> "",
							"heading"               	=> __( "Message", "ts_visual_composer_extend" ),
							"param_name"            	=> "content_icons",
							"value"                 	=> "",
							"description"	        	=> __( "Enter a short message to be used for the Hover effect; HTML code can NOT be used.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "effect_style_icons", 'value' => 'ts-hover-effect-zoe' ),
							"group" 					=> "Content",
						),
						array(
							"type"                  	=> "colorpicker",
							"heading"              	 	=> __( "Message Color", "ts_visual_composer_extend" ),
							"param_name"            	=> "content_color_text",
							"value"                 	=> "#ffffff",
							"description"           	=> __( "Define the color for the content text.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "effect_style_type", 'value' => 'text' ),
							"group" 			        => "Content",
						),
						array(
							"type"                  	=> "colorpicker",
							"heading"              	 	=> __( "Message Color", "ts_visual_composer_extend" ),
							"param_name"            	=> "content_color_other",
							"value"                 	=> "#ffffff",
							"description"           	=> __( "Define the color for the content text.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "effect_style_icons", 'value' => 'ts-hover-effect-zoe' ),
							"group" 			        => "Content",
						),
						array(
							"type"                  	=> "colorpicker",
							"heading"              	 	=> __( "Icons Color", "ts_visual_composer_extend" ),
							"param_name"            	=> "content_color_icons",
							"value"                 	=> "#000000",
							"description"           	=> __( "Define the color for the content icons.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "effect_style_type", 'value' => 'icons' ),
							"group" 			        => "Content",
						),					
						array(
							'type' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
							'heading' 					=> __( 'Icon #1', 'ts_visual_composer_extend' ),
							'param_name' 				=> 'content_link1_icon',
							'value'						=> '',
							'source'					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_HoverEffectsIconsSelectionCompliant,
							"fonts"						=> "false",
							"filter"					=> "false",
							"summary"					=> "true",
							"override"					=> "true",
							"custom"					=> "false",
							"height"					=> "105",
							'settings' 					=> array(
								'emptyIcon' 					=> true,
								'type' 							=> 'extensions',
								'iconsPerPage' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
								'source' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_HoverEffectsIconsSelectionCompliant,
							),
							"description"       		=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon you want to display.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
							"dependency"            	=> array( 'element' => "effect_style_icons", 'value' => array("ts-hover-effect-zoe", "ts-hover-effect-hera", "ts-hover-effect-winston", "ts-hover-effect-terry", "ts-hover-effect-phoebe", "ts-hover-effect-kira") ),
							"group" 					=> "Content",
						),
						array(
							"type"              		=> "textarea_raw_html",
							"heading"           		=> __( "Icon #1 Tooltip", "ts_visual_composer_extend" ),
							"param_name"        		=> "content_link1_tooltip",
							"value"             		=> base64_encode(""),
							"description"      	 		=> __( "Enter the tooltip for the icon here; basic HTML code can be used.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "effect_style_icons", 'value' => array("ts-hover-effect-zoe", "ts-hover-effect-hera", "ts-hover-effect-winston", "ts-hover-effect-terry", "ts-hover-effect-phoebe", "ts-hover-effect-kira") ),
							"group" 					=> "Content",
						),
						array(
							"type" 						=> "vc_link",
							"heading" 					=> __("Icon Link + Title #1", "ts_visual_composer_extend"),
							"param_name" 				=> "content_link1",
							"description" 				=> __("Provide a link to another site/page to be used for Icon #1.", "ts_visual_composer_extend"),
							"dependency"            	=> array( 'element' => "effect_style_icons", 'value' => array("ts-hover-effect-zoe", "ts-hover-effect-hera", "ts-hover-effect-winston", "ts-hover-effect-terry", "ts-hover-effect-phoebe", "ts-hover-effect-kira") ),
							"group" 					=> "Content",
						),
						array(
							'type' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
							'heading' 					=> __( 'Icon #2', 'ts_visual_composer_extend' ),
							'param_name' 				=> 'content_link2_icon',
							'value'						=> '',
							'source'					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_HoverEffectsIconsSelectionCompliant,
							"fonts"						=> "false",
							"filter"					=> "false",
							"summary"					=> "true",
							"override"					=> "true",
							"custom"					=> "false",
							"height"					=> "105",
							'settings' 					=> array(
								'emptyIcon' 					=> true,
								'type' 							=> 'extensions',
								'iconsPerPage' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
								'source' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_HoverEffectsIconsSelectionCompliant,
							),
							"description"       		=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon you want to display.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
							"dependency"            	=> array( 'element' => "effect_style_icons", 'value' => array("ts-hover-effect-zoe", "ts-hover-effect-hera", "ts-hover-effect-winston", "ts-hover-effect-terry", "ts-hover-effect-phoebe", "ts-hover-effect-kira") ),
							"group" 					=> "Content",
						),
						array(
							"type"              		=> "textarea_raw_html",
							"heading"           		=> __( "Icon #2 Tooltip", "ts_visual_composer_extend" ),
							"param_name"        		=> "content_link2_tooltip",
							"value"             		=> base64_encode(""),
							"description"      	 		=> __( "Enter the tooltip for the icon here; basic HTML code can be used.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "effect_style_icons", 'value' => array("ts-hover-effect-zoe", "ts-hover-effect-hera", "ts-hover-effect-winston", "ts-hover-effect-terry", "ts-hover-effect-phoebe", "ts-hover-effect-kira") ),
							"group" 					=> "Content",
						),
						array(
							"type" 						=> "vc_link",
							"heading" 					=> __("Icon Link + Title #2", "ts_visual_composer_extend"),
							"param_name" 				=> "content_link2",
							"description" 				=> __("Provide a link to another site/page to be used for Icon #2.", "ts_visual_composer_extend"),
							"dependency"            	=> array( 'element' => "effect_style_icons", 'value' => array("ts-hover-effect-zoe", "ts-hover-effect-hera", "ts-hover-effect-winston", "ts-hover-effect-terry", "ts-hover-effect-phoebe", "ts-hover-effect-kira") ),
							"group" 					=> "Content",
						),
						array(
							'type' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
							'heading' 					=> __( 'Icon #3', 'ts_visual_composer_extend' ),
							'param_name' 				=> 'content_link3_icon',
							'value'						=> '',
							'source'					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_HoverEffectsIconsSelectionCompliant,
							"fonts"						=> "false",
							"filter"					=> "false",
							"summary"					=> "true",
							"override"					=> "true",
							"custom"					=> "false",
							"height"					=> "105",
							'settings' 					=> array(
								'emptyIcon' 					=> true,
								'type' 							=> 'extensions',
								'iconsPerPage' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
								'source' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_HoverEffectsIconsSelectionCompliant,
							),
							"description"       		=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon you want to display.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
							"dependency"            	=> array( 'element' => "effect_style_icons", 'value' => array("ts-hover-effect-zoe", "ts-hover-effect-hera", "ts-hover-effect-winston", "ts-hover-effect-terry", "ts-hover-effect-phoebe", "ts-hover-effect-kira") ),
							"group" 					=> "Content",
						),
						array(
							"type"              		=> "textarea_raw_html",
							"heading"           		=> __( "Icon #3 Tooltip", "ts_visual_composer_extend" ),
							"param_name"        		=> "content_link3_tooltip",
							"value"             		=> base64_encode(""),
							"description"      	 		=> __( "Enter the tooltip for the icon here; basic HTML code can be used.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "effect_style_icons", 'value' => array("ts-hover-effect-zoe", "ts-hover-effect-hera", "ts-hover-effect-winston", "ts-hover-effect-terry", "ts-hover-effect-phoebe", "ts-hover-effect-kira") ),
							"group" 					=> "Content",
						),
						array(
							"type" 						=> "vc_link",
							"heading" 					=> __("Icon Link + Title #3", "ts_visual_composer_extend"),
							"param_name" 				=> "content_link3",
							"description" 				=> __("Provide a link to another site/page to be used for Icon #3.", "ts_visual_composer_extend"),
							"dependency"            	=> array( 'element' => "effect_style_icons", 'value' => array("ts-hover-effect-zoe", "ts-hover-effect-hera", "ts-hover-effect-winston", "ts-hover-effect-terry", "ts-hover-effect-phoebe", "ts-hover-effect-kira") ),
							"group" 					=> "Content",
						),
						array(
							'type' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
							'heading' 					=> __( 'Icon #4', 'ts_visual_composer_extend' ),
							'param_name' 				=> 'content_link4_icon',
							'value'						=> '',
							'source'					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_HoverEffectsIconsSelectionCompliant,
							"fonts"						=> "false",
							"filter"					=> "false",
							"summary"					=> "true",
							"override"					=> "true",
							"custom"					=> "false",
							"height"					=> "105",
							'settings' 					=> array(
								'emptyIcon' 					=> true,
								'type' 							=> 'extensions',
								'iconsPerPage' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
								'source' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_HoverEffectsIconsSelectionCompliant,
							),
							"description"       		=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon you want to display.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
							"dependency"            	=> array( 'element' => "effect_style_icons", 'value' => array("ts-hover-effect-hera", "ts-hover-effect-terry", "ts-hover-effect-kira") ),
							"group" 					=> "Content",
						),
						array(
							"type"              		=> "textarea_raw_html",
							"heading"           		=> __( "Icon #4 Tooltip", "ts_visual_composer_extend" ),
							"param_name"        		=> "content_link4_tooltip",
							"value"             		=> base64_encode(""),
							"description"      	 		=> __( "Enter the tooltip for the icon here; basic HTML code can be used.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "effect_style_icons", 'value' => array("ts-hover-effect-hera", "ts-hover-effect-terry", "ts-hover-effect-kira") ),
							"group" 					=> "Content",
						),
						array(
							"type" 						=> "vc_link",
							"heading" 					=> __("Icon Link + Title #4", "ts_visual_composer_extend"),
							"param_name" 				=> "content_link4",
							"description" 				=> __("Provide a link to another site/page to be used for Icon #4.", "ts_visual_composer_extend"),
							"dependency"            	=> array( 'element' => "effect_style_icons", 'value' => array("ts-hover-effect-hera", "ts-hover-effect-terry", "ts-hover-effect-kira") ),
							"group" 					=> "Content",
						),	
						array(
							"type"             	 		=> "switch_button",
							"heading"               	=> __( "Show Overlay Handle", "ts_visual_composer_extend" ),
							"param_name"            	=> "overlay_handle_show",
							"value"                 	=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Use the toggle to show or hide a handle button below the image.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "effect_permanent", 'value' => 'false' ),
							"group" 			        => "Content",
						),
						array(
							"type"                  	=> "colorpicker",
							"heading"              	 	=> __( "Handle Color", "ts_visual_composer_extend" ),
							"param_name"            	=> "overlay_handle_color",
							"value"                 	=> "#0094FF",
							"description"           	=> __( "Define the color for the overlay handle button.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "overlay_handle_show", 'value' => 'true' ),
							"group" 			        => "Content",
						),
						// Click Events
						array(
							"type"				    	=> "seperator",
							"heading"			    	=> __( "", "ts_visual_composer_extend" ),
							"param_name"		    	=> "seperator_3",
							"value"						=> "",
							"seperator"					=> "Click Event",
							"description"		    	=> __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "effect_style_type", 'value' => 'text' ),
							"group" 					=> "Event",
						),
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Click Event", "ts_visual_composer_extend" ),
							"param_name"            	=> "hover_event",
							"width"                 	=> 150,
							"value" 					=> array(
								__( "None", "ts_visual_composer_extend" )									=> "none",
								__( "Open Image in Lightbox", "ts_visual_composer_extend" )					=> "image",
								__( "Open Popup in Lightbox", "ts_visual_composer_extend" )					=> "popup",
								__( "Open YouTube Video in Lightbox", "ts_visual_composer_extend" )			=> "youtube",
								__( "Open Vimeo Video in Lightbox", "ts_visual_composer_extend" )			=> "vimeo",
								__( "Open DailyMotion Video in Lightbox", "ts_visual_composer_extend" )		=> "dailymotion",
								__( "Open Page in iFrame", "ts_visual_composer_extend" )					=> "iframe",
								__( "Simple Link to Page", "ts_visual_composer_extend" )					=> "link",
							),
							"description"           	=> __( "Select if the Hover image should trigger any other action.", "ts_visual_composer_extend" ),
							"admin_label"       		=> true,
							"dependency"            	=> array( 'element' => "effect_style_type", 'value' => 'text' ),
							"group" 					=> "Event",
						),
						// Lightbox Image
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Lightbox Image Source", "ts_visual_composer_extend" ),
							"param_name"            	=> "lightbox_size",
							"width"                 	=> 150,
							"value"                 	=> array(
								__( 'Full Size Image', "ts_visual_composer_extend" )			=> "full",
								__( 'Large Size Image', "ts_visual_composer_extend" )			=> "large",
								__( 'Medium Size Image', "ts_visual_composer_extend" )			=> "medium",
							),
							"description"           	=> __( "Select which image size based on WordPress settings should be used for the lightbox image.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "hover_event", 'value' => 'image' ),
							"group" 					=> "Event",
						),
						// Modal Popup
						array(
							"type"                  	=> "switch_button",
							"heading"			    	=> __( "Show Hover Title", "ts_visual_composer_extend" ),
							"param_name"		    	=> "hover_show_title",
							"value"                 	=> "true",
							"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
							"style"				    	=> "select",
							"design"			    	=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to show the title in the modal popup.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "hover_event", 'value' => 'popup' ),
							"group" 					=> "Event",
						),
						array(
							"type"              		=> "textarea_raw_html",
							"heading"           		=> __( "Hover Description", "ts_visual_composer_extend" ),
							"param_name"        		=> "hover_text",
							"value"             		=> base64_encode(""),
							"description"       		=> __( "Enter the more detailed description for the modal popup; HTML code can be used.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "hover_event", 'value' => 'popup' ),
							"group" 					=> "Event",
						),
						// YouTube / DailyMotion / Vimeo
						array(
							"type"                  	=> "textfield",
							"heading"               	=> __( "Video URL", "ts_visual_composer_extend" ),
							"param_name"            	=> "hover_video_link",
							"value"                 	=> "",
							"description"           	=> __( "Enter the URL for the video to be shown in a lightbox.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "hover_event", 'value' => array('youtube','dailymotion','vimeo') ),
							"group" 					=> "Event",
						),
						array(
							"type"              		=> "switch_button",
							"heading"			    	=> __( "Show Related Videos", "ts_visual_composer_extend" ),
							"param_name"		    	=> "hover_video_related",
							"value"             		=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to show related videos once the video has finished playing.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "hover_event", 'value' => 'youtube' ),
							"group" 					=> "Event",
						),
						array(
							"type"              		=> "switch_button",
							"heading"			    	=> __( "Autoplay Video", "ts_visual_composer_extend" ),
							"param_name"		    	=> "hover_video_auto",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to auto-play the video once opened in the lightbox.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "hover_event", 'value' => array('youtube','dailymotion','vimeo') ),
							"group" 					=> "Event",
						),
						// Link / iFrame
						array(
							"type" 						=> "vc_link",
							"heading" 					=> __("Link + Title", "ts_visual_composer_extend"),
							"param_name" 				=> "hover_link",
							"description" 				=> __("Provide a link to another site/page to be used for the Hover event.", "ts_visual_composer_extend"),
							"dependency"            	=> array( 'element' => "hover_event", 'value' => array('iframe','link') ),
							"group" 					=> "Event",
						),
						// Tooltip Settings
						array(
							"type"						=> "seperator",
							"heading"					=> __( "", "ts_visual_composer_extend" ),
							"param_name"				=> "seperator_4",
							"value"						=> "",
							"seperator"					=> "Tooltip Settings",
							"description"				=> __( "", "ts_visual_composer_extend" ),
							"group" 					=> "Tooltip",
						),
						array(
							"type"                  	=> "switch_button",
							"heading"			    	=> __( "Use HTML in Tooltip", "ts_visual_composer_extend" ),
							"param_name"		    	=> "tooltip_html",
							"value"                 	=> "false",
							"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
							"style"				    	=> "select",
							"design"			    	=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to allow basic HTML code for the tooltip content.", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
							"group" 					=> "Tooltip",
						),
						array(
							"type"						=> "textarea",
							"class"						=> "",
							"heading"					=> __( "Tooltip Content", "ts_visual_composer_extend" ),
							"param_name"				=> "tooltip_content",
							"value"						=> "",
							"description"		    	=> __( "Enter the tooltip content here (do not use quotation marks or HTML code).", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "tooltip_html", 'value' => 'false' ),
							"group" 					=> "Tooltip",
						),
						array(
							"type"              		=> "textarea_raw_html",
							"heading"           		=> __( "Tooltip Content", "ts_visual_composer_extend" ),
							"param_name"        		=> "tooltip_content_html",
							"value"             		=> base64_encode(""),
							"description"      	 		=> __( "Enter the tooltip content here; HTML code can be used.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "tooltip_html", 'value' => 'true' ),
							"group" 					=> "Tooltip",
						),
						array(
							"type"						=> "dropdown",
							"class"						=> "",
							"heading"					=> __( "Tooltip Style", "ts_visual_composer_extend" ),
							"param_name"				=> "tooltip_style",
							"value"             		=> array(
								__( "Black", "ts_visual_composer_extend" )                          => "",
								__( "Gray", "ts_visual_composer_extend" )                           => "ts-simptip-style-gray",
								__( "Green", "ts_visual_composer_extend" )                          => "ts-simptip-style-green",
								__( "Blue", "ts_visual_composer_extend" )                           => "ts-simptip-style-blue",
								__( "Red", "ts_visual_composer_extend" )                            => "ts-simptip-style-red",
								__( "Orange", "ts_visual_composer_extend" )                         => "ts-simptip-style-orange",
								__( "Yellow", "ts_visual_composer_extend" )                         => "ts-simptip-style-yellow",
								__( "Purple", "ts_visual_composer_extend" )                         => "ts-simptip-style-purple",
								__( "Pink", "ts_visual_composer_extend" )                           => "ts-simptip-style-pink",
								__( "White", "ts_visual_composer_extend" )                          => "ts-simptip-style-white"
							),
							"description"				=> __( "Select the tooltip style.", "ts_visual_composer_extend" ),
							"group" 					=> "Tooltip",
						),
						array(
							"type"						=> "nouislider",
							"heading"					=> __( "Tooltip X-Offset", "ts_visual_composer_extend" ),
							"param_name"				=> "tooltipster_offsetx",
							"value"						=> "0",
							"min"						=> "-100",
							"max"						=> "100",
							"step"						=> "1",
							"unit"						=> 'px',
							"description"				=> __( "Define an optional X-Offset for the tooltip position.", "ts_visual_composer_extend" ),
							"group" 					=> "Tooltip",
						),
						array(
							"type"						=> "nouislider",
							"heading"					=> __( "Tooltip Y-Offset", "ts_visual_composer_extend" ),
							"param_name"				=> "tooltipster_offsety",
							"value"						=> "0",
							"min"						=> "-100",
							"max"						=> "100",
							"step"						=> "1",
							"unit"						=> 'px',
							"description"				=> __( "Define an optional Y-Offset for the tooltip position.", "ts_visual_composer_extend" ),
							"group" 					=> "Tooltip",
						),	
                        // Other Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_5",
							"value"						=> "",
                            "seperator"					=> "Other Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Other Settings",
                        ),
                        array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Margin: Top", "ts_visual_composer_extend" ),
                            "param_name"                => "margin_top",
                            "value"                     => "0",
                            "min"                       => "-50",
                            "max"                       => "500",
                            "step"                      => "1",
                            "unit"                      => 'px',
                            "description"               => __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
                            "group" 			        => "Other Settings",
                        ),
                        array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Margin: Bottom", "ts_visual_composer_extend" ),
                            "param_name"                => "margin_bottom",
                            "value"                     => "0",
                            "min"                       => "-50",
                            "max"                       => "500",
                            "step"                      => "1",
                            "unit"                      => 'px',
                            "description"               => __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
                            "group" 			        => "Other Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Define ID Name", "ts_visual_composer_extend" ),
                            "param_name"                => "el_id",
                            "value"                     => "",
                            "description"               => __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
                            "group" 			        => "Other Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Extra Class Name", "ts_visual_composer_extend" ),
                            "param_name"                => "el_class",
                            "value"                     => "",
                            "description"               => __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
                            "group" 			        => "Other Settings",
                        ),
                        // Load Custom CSS/JS File
                        array(
                            "type"                      => "load_file",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "el_file",
                            "value"                     => "",
                            "file_type"                 => "js",
                            "file_path"                 => "js/ts-visual-composer-extend-element.min.js",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
                    ))
                );
            }
        }
	}
}
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_TS_Image_Hover_Effects extends WPBakeryShortCode {};
}
// Initialize "TS Image Hover Effects" Class
if (class_exists('TS_Image_Hover_Effects')) {
	$TS_Image_Hover_Effects = new TS_Image_Hover_Effects;
}