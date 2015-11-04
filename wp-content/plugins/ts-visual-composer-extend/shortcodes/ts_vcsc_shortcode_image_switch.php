<?php
	add_shortcode('TS-VCSC-Image-Switch', 'TS_VCSC_Image_Switch_Function');
	function TS_VCSC_Image_Switch_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
	
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
			wp_enqueue_style('ts-extend-simptip');
			wp_enqueue_style('ts-extend-animations');
		}
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'image_start'					=> '',
			'image_end'						=> '',
			'image_responsive'				=> 'true',
			'image_height'					=> 'height: 100%;',
			'image_width_percent'			=> 100,
			'image_width'					=> 300,
			//'image_height'				=> 200,
			'image_position'				=> 'ts-imagefloat-center',
			'attribute_alt_start'			=> 'false',
			'attribute_alt_value_start'		=> '',
			'attribute_alt_end'				=> 'false',
			'attribute_alt_value_end'		=> '',			
			'string_labels'					=> 'false',
			'string_before_text'			=> 'Before',
			'string_before_color'			=> '#ffffff',
			'string_after_text'				=> 'After',
			'string_after_color'			=> '#ffffff',				
			'switch_type'					=> 'ts-imageswitch-flip',
			'switch_trigger_flip'			=> 'ts-trigger-click',
			'switch_trigger_fade'			=> 'ts-trigger-hover',
			'switch_trigger_slide'			=> 'ts-trigger-hover',
			'switch_handle_show'			=> 'true',
			'switch_handle_center'			=> 'true',
			'switch_handle_color'			=> '#0094FF',			
			'switch_click'					=> 'true',
			'switch_event'					=> 'none',
			'switch_link'					=> '',			
			'link_additions'				=> 'false',
			'link_id'						=> '',
			'link_classes'					=> '',
			'link_attributes'				=> '',
			'lightbox_image'				=> '',
			'lightbox_title'				=> '',
			'lightbox_group'				=> 'true',
			'lightbox_group_name'			=> '',
			'lightbox_size'					=> 'full',
			'lightbox_effect'				=> 'random',
			'lightbox_speed'				=> 5000,
			'lightbox_social'				=> 'false',
			'lightbox_backlight'			=> 'auto',
			'lightbox_backlight_color'		=> '#ffffff',
			'slide_direction'				=> 'ts-switch-direction-horizontal',
			'slide_handle'					=> 'true',
			'slide_start'					=> 50,			
			'switch_overlay'				=> '',
			'overlay_remove'				=> 'false',
			'overlay_text'					=> '',
			'overlay_color'					=> '#ffffff',
			'overlay_image'					=> '',			
			'tooltip_css'					=> 'false',
			'tooltip_content'				=> '',
			'tooltip_position'				=> 'ts-simptip-position-top',
			'tooltip_style'					=> '',
			'margin_top'					=> 0,
			'margin_bottom'					=> 0,
			'el_id' 						=> '',
			'el_class'                  	=> '',
			'css'							=> '',
		), $atts ));
		
		// Slide Effect Attributes
		if ($switch_type == "ts-imageswitch-slide") {
			$switch_data					= 'data-handle="' . $slide_handle . '" data-start="' . $slide_start . '" data-direction="' . $slide_direction . '" data-trigger="' . $switch_trigger_slide . '"';
			$switch_class					= $slide_direction;
		} else {
			$switch_data					= '';
			$switch_class					= '';
		}
	
		$switch_image_start 				= wp_get_attachment_image_src($image_start, 'full');
		$switch_image_end 					= wp_get_attachment_image_src($image_end, 'full');		
		
		$switch_margin 						= 'margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
		
		$randomizer							= mt_rand(999999, 9999999);
		
		$output 							= '';
		$nacho_color						= '';
		
		if (!empty($el_id)) {
			$switch_image_id				= $el_id;
		} else {
			$switch_image_id				= 'ts-vcsc-image-switch-' . $randomizer;
		}
	
		// Handle Adjust
		if ($switch_type == "ts-imageswitch-slide") {
			if ($slide_direction == 'ts-switch-direction-horizontal') {
				$switch_handle_adjust		= "left: ' . $slide_start . '%;";
				$switch_image				= "right: ' . $slide_start . '%;";
			} else if ($slide_direction == 'ts-switch-direction-vertical') {
				$switch_handle_adjust		= "top: ' . $slide_start . '%;";
				$switch_image				= "bottom: ' . $slide_start . '%;";
			}
		} else {
			$switch_handle_adjust 			= "";
			$switch_image					= "";
		}
	
		// Tooltip
		if ($tooltip_css == "true") {
			if (strlen($tooltip_content) != 0) {
				$switch_tooltipclasses		= " ts-simptip-multiline " . $tooltip_style . " " . $tooltip_position;
				$switch_tooltipcontent		= ' data-tstooltip="' . $tooltip_content . '"';
			} else {
				$switch_tooltipclasses		= "";
				$switch_tooltipcontent		= "";
			}
		} else {
			$switch_tooltipclasses			= "";
			if (strlen($tooltip_content) != 0) {
				$switch_tooltipcontent		= ' title="' . $tooltip_content . '"';
			} else {
				$switch_tooltipcontent		= "";
			}
		}
		
		// Handle Padding
		if ($switch_handle_show == "true") {
			if ($switch_type == "ts-imageswitch-slide") {
				$switch_padding				= "padding-bottom: 0px;";
			} else {
				$switch_padding				= "padding-bottom: 25px;";
			}
		} else {
			$switch_padding					= "";
		}
		
		// Trigger
		if ($switch_type == "ts-imageswitch-flip") {
			$switch_trigger 				= $switch_trigger_flip;
		} else if ($switch_type == "ts-imageswitch-slide") {
			$switch_trigger 				= "ts-trigger-slide";
		} else if ($switch_type == "ts-imageswitch-fade") {
			$switch_trigger 				= $switch_trigger_fade;
		} else if ($switch_type == "ts-imageswitch-none") {
			$switch_trigger 				= $switch_trigger_fade;
		}
		
		// Handle Icon
		if ($switch_trigger == "ts-trigger-click") {
			$switch_handle_icon				= 'handle_click';
		} else if ($switch_trigger == "ts-trigger-hover") {
			$switch_handle_icon				= 'handle_hover';
		} else if ($switch_trigger == "ts-trigger-slide") {
			$switch_handle_icon				= 'handle_slide';
		}
		
		$image_extension_start				= pathinfo($switch_image_start[0], PATHINFO_EXTENSION);
		$image_extension_end				= pathinfo($switch_image_end[0], PATHINFO_EXTENSION);

		if ($attribute_alt_start == "true") {
			$alt_attribute_start			= $attribute_alt_value_start;
		} else {
			$alt_attribute_start			= basename($switch_image_start[0], "." . $image_extension_start);
		}		
		if ($attribute_alt_end == "true") {
			$alt_attribute_end				= $attribute_alt_value_end;
		} else {
			$alt_attribute_end				= basename($switch_image_end[0], "." . $image_extension_end);
		}
		
		
		// Decode Link Attributes
		if (($link_additions == 'true') && ($link_attributes != '')) {
			$link_attributes				= rawurldecode(base64_decode(strip_tags($link_attributes)));
		} else {
			$link_attributes				= '';
		}
		if (($link_additions == 'true') && ($link_id != '')) {
			$link_id						= $link_id;
		} else {
			$link_id						= $switch_image_id . "-link";
		}
		if (($link_additions == 'true') && ($link_classes != '')) {
			$link_classes					= $link_classes;
		} else {
			$link_classes					= '';
		}
		
		
		// Lightbox Settings
		if ($lightbox_backlight == "auto") {
			$nacho_color					= '';
		} else if ($lightbox_backlight == "custom") {
			$nacho_color					= 'data-color="' . $lightbox_backlight_color . '"';
		} else if ($lightbox_backlight == "hideit") {
			$nacho_color					= 'data-color="rgba(0, 0, 0, 0)"';
		}
		$nacho_data							= 'rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-share="' . ($lightbox_social == "true" ? 1 : 0) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '';
		
		// Link
		if (($switch_event == "link") && ($switch_link != '')){
			$link 							= ($switch_link == '||') ? '' : $switch_link;
			$link 							= vc_build_link($switch_link);
			$a_href							= $link['url'];
			$a_title 						= $link['title'];
			$a_target 						= $link['target'];
			$linkswitch_start				= '<a id="' . $link_id . '" class="ts-imageswitch-link ' . $link_classes . '" ' . $link_attributes . ' style="margin: 0; padding: 0;" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '" data-random="' . $randomizer . '">';
			$linkswitch_end					= '</a>';
		} else if ($switch_event == "front") {
			$linkswitch_start				= '<a id="' . $link_id . '" class="ts-imageswitch-link ' . $link_classes . ' nch-lightbox-media nofancybox no-ajaxy" ' . $link_attributes . ' style="margin: 0; padding: 0;" href="' . $switch_image_start[0] . '" target="_blank" title="' . $alt_attribute_start . '" data-thumbnail="' . $switch_image_start[0] . '" ' . $nacho_data . ' data-random="' . $randomizer . '">';
			$linkswitch_end					= '</a>';
		} else if ($switch_event == "back") {
			$linkswitch_start				= '<a id="' . $link_id . '" class="ts-imageswitch-link ' . $link_classes . ' nch-lightbox-media nofancybox no-ajaxy" ' . $link_attributes . ' style="margin: 0; padding: 0;" href="' . $switch_image_end[0] . '" target="_blank" title="' . $alt_attribute_end . '" data-thumbnail="' . $switch_image_end[0] . '" ' . $nacho_data . ' data-random="' . $randomizer . '">';
			$linkswitch_end					= '</a>';			
		} else if ($switch_event == "both") {
			$linkswitch_start				= '<a id="' . $link_id . '" class="ts-imageswitch-link ' . $link_classes . ' nch-lightbox-media nofancybox no-ajaxy" ' . $link_attributes . ' style="margin: 0; padding: 0;" href="' . $switch_image_start[0] . '" target="_blank" title="' . $alt_attribute_start . '" data-thumbnail="' . $switch_image_start[0] . '" ' . $nacho_data . ' data-random="' . $randomizer . '">';
			$linkswitch_end					= '</a>';
			$linkswitch_end					.= '<a id="' . $link_id . '" class="ts-imageswitch-link ' . $link_classes . ' nch-lightbox-media nofancybox no-ajaxy" ' . $link_attributes . ' style="margin: 0; padding: 0; display: none;" href="' . $switch_image_end[0] . '" target="_blank" title="' . $alt_attribute_end . '" data-thumbnail="' . $switch_image_end[0] . '" ' . $nacho_data . ' data-random="' . $randomizer . '">' . $alt_attribute_end . '</a>';
		} else if ($switch_event == "other") {
			$linkswitch_image 				= wp_get_attachment_image_src($lightbox_image, 'full');
			$linkswitch_start				= '<a id="' . $link_id . '" class="ts-imageswitch-link ' . $link_classes . ' nch-lightbox-media nofancybox no-ajaxy" ' . $link_attributes . ' style="margin: 0; padding: 0;" href="' . $linkswitch_image[0] . '" target="_blank" title="' . $lightbox_title . '" data-thumbnail="' . $linkswitch_image[0] . '" ' . $nacho_data . ' data-random="' . $randomizer . '">';
			$linkswitch_end					= '</a>';	
		} else {
			$linkswitch_start				= '';
			$linkswitch_end					= '';
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-imageswitch ' . $switch_type . ' ' . $switch_trigger . ' ' . $image_position . $switch_tooltipclasses . ' ts-imageswitch-before ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Image-Switch', $atts);
		} else {
			$css_class	= 'ts-imageswitch ' . $switch_type . ' ' . $switch_trigger . ' ' . $image_position . $switch_tooltipclasses . ' ts-imageswitch-before ' . $el_class;
		}
		
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
			if ($image_responsive == "true") {
				$output .= $linkswitch_start;
					$output .= '<div id="' . $switch_image_id . '" data-trigger="' . $switch_trigger . '" class="' . $css_class . ' ' . $switch_class . '" ' . $switch_tooltipcontent . ' style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; width: ' . $image_width_percent . '%;">';
						$output .= '<div id="' . $switch_image_id . '-counter" class="ts-switch-wrapper " style="width: ' . $image_width_percent . '%; ' . $image_height . '">';
							$output .= '<div style="' . $switch_padding . '" data-link="' . $link_id . '" ' . $switch_data . '>';
								if ($string_labels == 'true') {
									$output .= '<div class="ts-imageswitch-strings-holder">';
										$output .= '<div class="ts-imageswitch-before-string active" style="color: ' . $string_before_color . ';">' . $string_before_text . '</div>';
										$output .= '<div class="ts-imageswitch-after-string ' . ($switch_type == "ts-imageswitch-slide" ? "active" : "") . '" style="color: ' . $string_after_color . ';">' . $string_after_text . '</div>';
									$output .= '</div>';
								}
								$output .= '<ol class="ts-imageswitch-items" style="padding: 0px;">';
									$output .= '<li class="ts-imageswitch__before ' . ((($switch_type == "ts-imageswitch-fade") || ($switch_type == "ts-imageswitch-none")) ? "active" : "") . '" style="' . $image_height . '">';									
										$output .= '<img src="' . $switch_image_start[0] . '" data-no-lazy="1" alt="' . $alt_attribute_start . '" style="width: ' . $image_width_percent . '%; height: auto;" data-status="Before">';
									$output .= '</li>';
									$output .= '<li class="ts-imageswitch__after" style="' . $switch_handle_adjust . '" style="' . $image_height . '">';									
										$output .= '<img src="' . $switch_image_end[0] . '" data-no-lazy="1" alt="' . $alt_attribute_end . '" style="width: ' . $image_width_percent . '%; height: auto;" data-status="After" style="' . $switch_image . '">';
									$output .= '</li>';
								$output .= '</ol>';
								if (($switch_overlay == "text") && ($overlay_text != '')) {
									$output .= '<div id="ts-imageswitch-overlay-' . $randomizer . '" class="ts-imageswitch-overlay active" data-remove="' . $overlay_remove . '"><div class="ts-imageswitch-overlay-text" style="color: ' . $overlay_color . ';">' . $overlay_text . '</div></div>';
								} else if (($switch_overlay == "image") && ($overlay_image != '')) {
									$switch_image_overlay = wp_get_attachment_image_src($overlay_image, 'full');
									$output .= '<div id="ts-imageswitch-overlay-' . $randomizer . '" class="ts-imageswitch-overlay active" data-remove="' . $overlay_remove . '"><img class="ts-imageswitch-overlay-image" data-no-lazy="1" src="' . $switch_image_overlay[0] . '"></div>';
								}
								if ($switch_handle_show == "true") {
									if ($switch_type == "ts-imageswitch-slide") {
										$output .= '<div class="ts-imageswitch__handle ' . $switch_class . '" data-center="' . $switch_handle_center . '" style="' . $switch_handle_adjust . ' background-color: ' . $switch_handle_color . '"><span class="frame_' . $switch_handle_icon . '" style="background-color: ' . $switch_handle_color . '"><i class="' . $switch_handle_icon . '"></i></span>';
									} else {
										$output .= '<div class="ts-imageswitch__handle ' . $switch_class . '" style="' . $switch_handle_adjust . '"><span class="frame_' . $switch_handle_icon . '" style="background-color: ' . $switch_handle_color . '"><i class="' . $switch_handle_icon . '"></i></span>';
									}
									$output .= '</div>';
								} else if ($switch_type == "ts-imageswitch-slide") {
									$output .= '<div class="ts-imageswitch__handle ' . $switch_class . '" data-center="' . $switch_handle_center . '" style="' . $switch_handle_adjust . ' background-color: ' . $switch_handle_color . '"></div>';
								}
							$output .= '</div>';
						$output .= '</div>';				
					$output .= '</div>';
				$output .= $linkswitch_end;
			} else {
				$output .= $linkswitch_start;
					$output .= '<div id="' . $switch_image_id . '" data-trigger="' . $switch_trigger . '" class="' . $css_class . ' ' . $switch_class . '" ' . $switch_tooltipcontent . ' style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; width: ' . $image_width . 'px;">';
						$output .= '<div id="' . $switch_image_id . '-counter" class="ts-switch-wrapper " style="width: ' . $image_width . 'px; ' . $image_height . '">';
							$output .= '<div style="' . $switch_padding . '" data-link="' . $link_id . '" ' . $switch_data . '>';
								$output .= '<ol class="ts-imageswitch-items" style="padding: 0px;">';
									$output .= '<li class="ts-imageswitch__before ' . ((($switch_type == "ts-imageswitch-fade") || ($switch_type == "ts-imageswitch-none")) ? "active" : "") . '" style="' . $image_height . '">';
										$output .= '<img src="' . $switch_image_start[0] . '" data-no-lazy="1" alt="' . $alt_attribute_start . '" style="width: ' . $image_width . 'px; height: auto;" data-status="Before">';
									$output .= '</li>';
									$output .= '<li class="ts-imageswitch__after" style="' . $switch_handle_adjust . '" style="' . $image_height . '">';
										$output .= '<img src="' . $switch_image_end[0] . '" data-no-lazy="1" alt="' . $alt_attribute_end . '" style="width: ' . $image_width . 'px; height: auto;" data-status="After" style="' . $switch_image . '">';
									$output .= '</li>';
								$output .= '</ol>';
								if (($switch_overlay == "text") && ($overlay_text != '')) {
									$output .= '<div id="ts-imageswitch-overlay-' . $randomizer . '" class="ts-imageswitch-overlay active" data-remove="' . $overlay_remove . '"><div class="ts-imageswitch-overlay-text" style="color: ' . $overlay_color . ';">' . $overlay_text . '</div></div>';
								} else if (($switch_overlay == "image") && ($overlay_image != '')) {
									$switch_image_overlay = wp_get_attachment_image_src($overlay_image, 'full');
									$output .= '<div id="ts-imageswitch-overlay-' . $randomizer . '" class="ts-imageswitch-overlay active" data-remove="' . $overlay_remove . '"><img class="ts-imageswitch-overlay-image" data-no-lazy="1" src="' . $switch_image_overlay[0] . '"></div>';
								}
								if ($switch_handle_show == "true") {
									if ($switch_type == "ts-imageswitch-slide") {
										$output .= '<div class="ts-imageswitch__handle ' . $switch_class . '" data-center="' . $switch_handle_center . '" style="' . $switch_handle_adjust . ' background-color: ' . $switch_handle_color . '"><span class="frame_' . $switch_handle_icon . '" style="background-color: ' . $switch_handle_color . '"><i class="' . $switch_handle_icon . '"></i></span>';
									} else {
										$output .= '<div class="ts-imageswitch__handle ' . $switch_class . '" style="' . $switch_handle_adjust . '"><span class="frame_' . $switch_handle_icon . '" style="background-color: ' . $switch_handle_color . '"><i class="' . $switch_handle_icon . '"></i></span>';
									}
									$output .= '</div>';
								} else if ($switch_type == "ts-imageswitch-slide") {
									$output .= '<div class="ts-imageswitch__handle ' . $switch_class . '" data-center="' . $switch_handle_center . '" style="' . $switch_handle_adjust . ' background-color: ' . $switch_handle_color . '"></div>';
								}
							$output .= '</div>';
						$output .= '</div>';				
					$output .= '</div>';
				$output .= $linkswitch_end;
			}
		} else {
			$output .= '<div id="' . $switch_image_id . '" class="ts-imageswitch-edit" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; padding: 0; width: 100%; height: 100%;">';
				$output .= '<div style="text-align: justify; display: block; margin-bottom: 10px; font-style: italic;">' . __("Image Switch effects and controls are not available in front end editor mode.", "ts_visual_composer_extend") . '</div>';
				if ($switch_type == "ts-imageswitch-flip") {
					$output .= '<div style="text-align: justify; display: block; margin-bottom: 10px;">' . __( "Switch Style", "ts_visual_composer_extend" ) . ': ' . __("Flip", "ts_visual_composer_extend") . '</div>';
				} else if ($switch_type == "ts-imageswitch-slide") {
					$output .= '<div style="text-align: justify; display: block; margin-bottom: 10px;">' . __( "Switch Style", "ts_visual_composer_extend" ) . ': ' . __("Slide", "ts_visual_composer_extend") . '</div>';
				} else if ($switch_type == "ts-imageswitch-fade") {
					$output .= '<div style="text-align: justify; display: block; margin-bottom: 10px;">' . __( "Switch Style", "ts_visual_composer_extend" ) . ': ' . __("Fade", "ts_visual_composer_extend") . '</div>';
				}				
				$output .= '<img src="' . $switch_image_start[0] . '" data-no-lazy="1" style="width: 50%; height: auto; margin: 0; padding: 0; display: inline-block;"/>';
				$output .= '<img src="' . $switch_image_end[0] . '" data-no-lazy="1" style="width: 50%; height: auto; margin: 0; padding: 0; display: inline-block;"/>';
			$output .= '</div>';
		}
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>