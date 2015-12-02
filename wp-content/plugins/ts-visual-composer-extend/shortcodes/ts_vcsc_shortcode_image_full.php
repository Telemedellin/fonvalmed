<?php
	add_shortcode('TS_VCSC_Image_Full', 'TS_VCSC_Image_Full_Function');
	function TS_VCSC_Image_Full_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
		
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
			$frontend					= "true";
		} else {
			$frontend					= "false";
		}

		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'type'						=> 'image',
			'image'						=> '',
			'attribute_alt'				=> 'false',
			'attribute_alt_value'		=> '',
			'break_parents'				=> 6,
			'zindex'					=> 0,
			
			'media_link_type'			=> 'none',
			'media_link_data'			=> '',
			'media_link_text'			=> 'Learn More!',
			'media_link_icon'			=> '',
			'media_link_standard'		=> 'ts-dual-buttons-color-sun-flower',
			'media_link_hover'			=> 'ts-dual-buttons-preview-default ts-dual-buttons-hover-default',
			'media_link_width'			=> 'percent',
			'media_link_percent'		=> 25,
			'media_link_fixed'			=> 200,
			
			'slide_images'				=> '',
			'slide_dynamic'				=> 'false',
			'slide_height'				=> 600,
			'slide_auto'				=> 'true',
			'slide_controls'			=> 'true',
			'slide_shuffle'				=> 'false',
			'slide_delay'				=> 5000,
			'slide_bar'					=> 'true',
			'slide_transition'			=> 'random',
			'slide_switch'				=> 2000,
			'slide_animation'			=> 'null',
			'slide_halign'				=> 'center',
			'slide_valign'				=> 'center',
			
			'blur_strength'				=> '',
			'raster_use'				=> 'false',
			'raster_type'				=> '',
			
			'overlay_use'				=> 'false',
			'overlay_color'				=> 'rgba(30,115,190,0.25)',
			
			'svg_top_on'				=> 'false',
			'svg_top_style'				=> '1',
			'svg_top_height'			=> 100,
			'svg_top_flip'				=> 'false',
			'svg_top_position'			=> 0,
			'svg_top_color1'			=> '#ffffff',
			'svg_top_color2'			=> '#ededed',
			
			'svg_bottom_on'				=> 'false',
			'svg_bottom_style'			=> '1',
			'svg_bottom_height'			=> 100,
			'svg_bottom_flip'			=> 'false',
			'svg_bottom_position'		=> 0,
			'svg_bottom_color1'			=> '#ffffff',
			'svg_bottom_color2'			=> '#ededed',
			
			'movement_x_allow'			=> 'false',
			'movement_x_ratio'			=> 20,
			'movement_y_allow'			=> 'false',
			'movement_y_ratio'			=> 20,
			
			'margin_left'				=> 0,
			'margin_right'				=> 0,
			'margin_top'				=> 0,
			'margin_bottom'				=> 0,
			'el_id' 					=> '',
			'el_class'                  => '',
			'css'						=> '',
		), $atts ));
		
		$randomizer						= mt_rand(999999, 9999999);
		
		if (($media_link_type == "flatbutton") && ($type == "image")) {
			wp_enqueue_style('ts-extend-buttonsdual');
		}	
	
		// Check for Front End Editor
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
			$editor_frontend			= "true";
		} else {
			$editor_frontend			= "false";
		}
		
		if ($type == "slideshow") {
			wp_enqueue_style('ts-extend-vegas');
			wp_enqueue_script('ts-extend-vegas');
		}
	
		$full_margin 					= 'margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
		
		$output 						= "";
		
		if (!empty($el_id)) {
			$full_image_id				= $el_id;
		} else {
			$full_image_id				= 'ts-vcsc-image-full-' . $randomizer;
		}
		
		// CSS3 Blur Effect
		if ($blur_strength != '') {
			$blur_class					= "ts-background-blur " . $blur_strength;
			if ($blur_strength == "ts-background-blur-small") {
				$blur_factor			= 2;
			} else if ($blur_strength == "ts-background-blur-medium") {
				$blur_factor			= 5;
			} else if ($blur_strength == "ts-background-blur-strong") {
				$blur_factor			= 8;
			}
		} else {
			$blur_class					= "";
			$blur_factor				= 0;
		}
		
		// Raster (Noise) Overlay
		if (($raster_use == "true") && ($raster_type != '')) {
			$raster_content				= '<div class="ts-background-raster" style="background-image: url(' . $raster_type . ');"></div>';
		} else {
			$raster_content				= '';
		}
		
		// Color Overlay
		if ($overlay_use == "true") {
			$overlay_content			= '<div class="ts-background-overlay" style="background: ' . $overlay_color . ';"></div>';
		} else {
			$overlay_content			= '';
		}
		
		// SVG Shape Overlays
		$svg_enabled					= 'false';
		if ($svg_top_on == "true") {
			$svg_top_content			= '<div id="ts-background-separator-top-' . $randomizer . '" class="ts-background-separator ts-background-separator-top' . ($svg_top_flip == "true" ? "-flip" : "") . '" style="z-index: 99; height: ' . $svg_top_height . 'px; top: ' . $svg_top_position . 'px;">' . TS_VCSC_GetRowSeparator($svg_top_style, $svg_top_color1, $svg_top_color2, $svg_top_height) . '</div>';
			$svg_enabled				= 'true';
		} else {
			$svg_top_content			= '';
		}
		if ($svg_bottom_on == "true") {
			$svg_bottom_content			= '<div id="ts-background-separator-bottom-' . $randomizer . '" class="ts-background-separator ts-background-separator-bottom' . ($svg_bottom_flip == "true" ? "-flip" : "") . '" style="z-index: 99; height: ' . $svg_bottom_height . 'px; bottom: ' . $svg_bottom_position . 'px;">' . TS_VCSC_GetRowSeparator($svg_bottom_style, $svg_bottom_color1, $svg_bottom_color2, $svg_bottom_height) . '</div>';
			$svg_enabled				= 'true';
		} else {
			$svg_bottom_content			= '';
		}
		
		// Movement Effect
		if (($type == 'image') && ($movement_x_allow == "true") || ($movement_x_allow == "true")) {
			wp_enqueue_script('ts-extend-parallaxify');
			$movement_class				= 'ts-image-full-movement';
		} else {
			$movement_class				= '';
		}
		
		// Single Image Data
		if ($type == "image") {
			$full_image					= wp_get_attachment_image_src($image, 'full');
			$image_extension 			= pathinfo($full_image[0], PATHINFO_EXTENSION);		
			if ($attribute_alt == "true") {
				$alt_attribute			= $attribute_alt_value;
			} else {
				$alt_attribute			= basename($full_image[0], "." . $image_extension);
			}
		}
		
		// Link
		if (($media_link_type != 'none') && ($type == "image")) {
			$link 						= ($media_link_data == '||') ? '' : $media_link_data;
			$link 						= vc_build_link($link);
			$a_href						= $link['url'];
			$a_title 					= $link['title'];
			$a_target 					= $link['target'];
			$button_classes				= $media_link_standard . ' ' . $media_link_hover;
			if ($media_link_width == 'percent') {
				$button_style			= 'width: ' . $media_link_percent . '%;';
			} else {
				$button_style			= 'width: ' . $media_link_fixed . 'px;';
			}
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Image_Full', $atts);
		} else {
			$css_class	= '';
		}
		
		$breakouts_data					= 'data-blur="' . $blur_factor . '" data-inline="' . $editor_frontend . '" data-index="' . $zindex . '" data-marginleft="' . $margin_left . '" data-marginright="' . $margin_right . '" data-break-parents="' . esc_attr( $break_parents ) . '"';
		$movement_data					= 'data-allowx="' . $movement_x_allow . '" data-movex="' . $movement_x_ratio . '" data-allowy="' . $movement_y_allow . '" data-movey="' . $movement_y_ratio . '"';
		
		if ($type == "image") {
			$output .= '<div class="ts-image-full-container" style="width: 100%; height: 100%; position: relative;">';
				$output .= $svg_top_content;
				$output .= '<div id="' . $full_image_id . '" class="ts-image-full-frame ' . $el_class . ' ' . $css_class . ' ' . $blur_class . ' ' . $movement_class . '" style="width: 100%; height: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;" data-svgshape="' . $svg_enabled . '" data-random="' . $randomizer . '" ' . $breakouts_data . ' data-image="' . $full_image[0] . '" ' . $movement_data . '>';
					if ($media_link_type == "element") {
						$output .= '<a class="ts-image-full-link" href="' . $a_href . '" target="' . $a_target . '" data-title="' . $a_title . '">';
					}			
						$output .= '<img class="ts-imagefull" src="' . $full_image[0] . '" data-no-lazy="1" alt="' . $alt_attribute . '" style="width: 100%; height: auto;"/>';					
						$output .= $overlay_content;
						$output .= $raster_content;
						if ($media_link_type == "flatbutton") {							
							$output .= '<a class="ts-image-full-button ts-dual-buttons-wrapper" href="' . $a_href . '" target="' . $a_target . '" data-title="' . $a_title . '" style="' . $button_style . '">';
								$output .= '<div id="' . $full_image_id . '-trigger" class="ts-dual-buttons-container clearFixMe ' . $button_classes . '">';
									if (($media_link_icon != '') && ($media_link_icon != 'transparent')) {
										$output .= '<i class="ts-dual-buttons-icon ' . $media_link_icon . '" style=""></i>';
									}
									$output .= '<span class="ts-dual-buttons-title" style="">' . $media_link_text . '</span>';			
								$output .= '</div>';
							$output .= '</a>';
						}					
					if ($media_link_type == "element") {
						$output .= '</a>';
					}
				$output .= '</div>';
				$output .= $svg_bottom_content;
			$output .= '</div>';
		}		
		if ($type == "slideshow") {
			$slider_settings			= 'data-initialized="false" data-random="' . $randomizer . '" data-svgshape="' . $svg_enabled . '" data-dynamic="' . $slide_dynamic . '" data-height="' . $slide_height . '" data-halign="' . $slide_halign . '" data-valign="' . $slide_valign . '" data-autoplay="' .$slide_auto . '" data-playing="' .$slide_auto . '" data-controls="' . $slide_controls . '" data-shuffle="' . $slide_shuffle . '" data-delay="' . $slide_delay . '" data-bar="' . $slide_bar . '" data-transition="' . $slide_transition . '" data-switch="' . $slide_switch . '" data-animation="' . $slide_animation . '"';
			$output .= '<div class="ts-slideshow-full-container" style="width: 100%; height: 100%; position: relative;">';				
				$output .= '<div id="' . $full_image_id . '" class="ts-slideshow-full-frame ' . $css_class . ' ' . $el_class . '" ' . $breakouts_data . ' style="width: 100%; height: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" ' . $slider_settings . '>';
					$slide_images		= explode(',', $slide_images);
					$i					= 0;
					foreach ($slide_images as $single_image) {
						$i++;
						$slide_image	= wp_get_attachment_image_src($single_image, 'full');
						$output .= '<div class="ts-background-slideshow-holder" style="display: none;" data-image="' . $slide_image[0] . '" data-width="' . $slide_image[1] . '" data-height="' . $slide_image[2] . '" data-ratio="' . ($slide_image[1] / $slide_image[2]) . '"></div>';
					}					
					$output .= $svg_top_content;
					$output .= '<div class="ts-background-slideshow-wrapper"></div>';					
					$output .= $overlay_content;
					$output .= $raster_content;					
					if ($slide_controls == 'true') {
						// Left / Right Navigation
						$output .= '<nav id="nav-arrows-' . $randomizer . '" class="nav-arrows">';
							$output .= '<span class="nav-arrow-prev" style="text-indent: -90000px;">Previous</span>';
							$output .= '<span class="nav-arrow-next" style="text-indent: -90000px;">Next</span>';
						$output .= '</nav>';
					}
					if ($slide_auto == 'true') {
						// Auto-Play Controls
						$output .= '<nav id="nav-auto-' . $randomizer . '" class="nav-auto">';
							$output .= '<span class="nav-auto-play" style="display: none; text-indent: -90000px;">Play</span>';
							$output .= '<span class="nav-auto-pause" style="text-indent: -90000px;">Pause</span>';
						$output .= '</nav>';
					}
					$output .= $svg_bottom_content;
				$output .= '</div>';				
			$output .= '</div>';
		}
		
		echo $output;

		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>