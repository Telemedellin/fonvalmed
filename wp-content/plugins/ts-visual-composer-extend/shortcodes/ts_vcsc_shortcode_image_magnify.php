<?php
	add_shortcode('TS_VCSC_Image_Magnify', 'TS_VCSC_Image_Magnify_Function');
	function TS_VCSC_Image_Magnify_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
			wp_enqueue_script('ts-extend-hammer');
			wp_enqueue_script('ts-extend-nacho');
			wp_enqueue_style('ts-extend-nacho');
			wp_enqueue_script('ts-extend-zoomer');
			wp_enqueue_style('ts-extend-zoomer');
		}
		wp_enqueue_style('ts-visual-composer-extend-front');			
		wp_enqueue_script('ts-visual-composer-extend-front');
	
		extract( shortcode_atts( array(
			'layout'					=> 'loupe',
			'image'						=> '',
			'image_thumb'				=> 'large',
			'image_zoom'				=> 'full',
			
			'zoom_x'					=> 50,
			'zoom_y'					=> 50,
			'zoom_restore'				=> 'true',
			'zoom_timeout'				=> 6000,
			
			'background_type'       	=> 'color',
			'background_color'      	=> '#ffffff',
			'background_pattern'    	=> '',
			'background_image'			=> '',
			'background_size'			=> 'cover',
			'background_repeat'			=> 'no-repeat',
			
			'zoom_level'				=> 200,
			'zoom_size'					=> 100,
			'zoom_drag'					=> 'true',
			'zoom_circle'				=> 'true',
			'zoom_reflect'				=> 'false',
			'zoom_shadow'				=> 'true',
			'zoom_border'				=> 'true',
			'zoom_effect'				=> 'none',
			
			'zoom_show'					=> 'true',
			'zoom_note'					=> 'true',
			'zoom_outside'				=> 'false',
			'zoom_range'				=> 'true',
			'zoom_mouse'				=> 'false',
			'zoom_wheel'				=> 10,
			'zoom_pinch'				=> 'false',
			'zoom_lightbox'				=> 'true',
			
			'zoom_controls'				=> 'bottom',
			'zoom_scale'				=> 'true',
			'zoom_reset'				=> 'true',
			'zoom_rotate'				=> 'false',
			
			'lightbox_group'			=> 'true',
			'lightbox_group_name'		=> '',
			'lightbox_size'				=> 'full',
			'lightbox_effect'			=> 'random',
			'lightbox_speed'			=> 5000,
			'lightbox_social'			=> 'true',
			'lightbox_backlight'		=> 'auto',
			'lightbox_backlight_color'	=> '#ffffff',
			
			'attribute_alt'				=> 'false',
			'attribute_alt_value'		=> '',
			'attribute_title'			=> '',
			
			'margin_top'				=> 0,
			'margin_bottom'				=> 0,
			'el_id' 					=> '',
			'el_class'                  => '',
			'css'						=> '',
		), $atts ));
		
		// Check for Front End Editor
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
			$editor_frontend			= "true";
			$zoom_drag					= "true";
			$zoom_mouse					= "false";
			$zoom_pinch					= "false";
		} else {
			$editor_frontend			= "false";
			$zoom_drag					= $zoom_drag;
			$zoom_mouse					= $zoom_mouse;
			$zoom_pinch					= $zoom_pinch;
		}
		
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
			if ($zoom_mouse == "true") {
				wp_enqueue_script('ts-extend-mousewheel');
			}
		}
		
		$output = $notice = $visible = $loupeclasses = '';
		
		$randomizer						= mt_rand(999999, 9999999);
		
		if (!empty($el_id)) {
			$image_id					= $el_id;
		} else {
			if ($layout == "loupe") {
				$image_id				= 'ts-vcsc-image-magnify-' . $randomizer;
			} else if ($layout == "buttons") {
				$image_id				= 'ts-vcsc-image-zoomer-' . $randomizer;
			}
		}
	
		
		$small_image					= wp_get_attachment_image_src($image, $image_thumb);
		$full_image						= wp_get_attachment_image_src($image, $image_zoom);
		
		$dimensions_x					= (isset($full_image[1]) ? $full_image[1] : 1);
		$dimensions_y					= (isset($full_image[2]) ? $full_image[2] : 1);
		
		$full_background				= "background: #34383f url('" . $full_image[0] . "') top left no-repeat;";
		$image_extension 				= pathinfo($small_image[0], PATHINFO_EXTENSION);
		
		if ($dimensions_x < $dimensions_y) {
			$image_adjust				= "width: auto; max-height: 100%; height: 100%;";
			$aspect						= "tall";
		} else {
			$image_adjust				= "width: 100%; max-width: 100%; height: auto;";
			$aspect						= "wide";
		}
		$image_ratio					= ($dimensions_x / $dimensions_y);
		
		if ($layout == "buttons") {
			if ($background_type == "pattern") {
				$background_style		= 'background: url(' . $background_pattern . ') repeat;';
			} else if ($background_type == "color") {
				$background_style		= 'background-color: ' . $background_color .';';
			} else if ($background_type == "image") {
				$background_image		= wp_get_attachment_image_src($background_image, 'full');
				$background_image		= $background_image[0];
				$background_style		= 'background: url(' . $background_image . ') ' . $background_repeat . ' 0 0; background-size: ' . $background_size . ';';
			}		
		}
		
		if ($attribute_alt == "true") {
			$alt_attribute				= $attribute_alt_value;
		} else {
			$alt_attribute				= basename($full_image[0], "." . $image_extension);
		}
		
		// Custom Width / Height
		$lightbox_dimensions			= '';
		
		if ($lightbox_backlight == "auto") {
			$nacho_color				= 'data-color=""';
		} else if ($lightbox_backlight == "custom") {
			$nacho_color				= 'data-color="' . $lightbox_backlight_color . '"';
		} else if ($lightbox_backlight == "hideit") {
			$nacho_color				= 'data-color="rgba(0, 0, 0, 0)"';
		}
		
		// Loupe Classes
		if ($zoom_shadow == "true") {
			$loupeclasses				.= ' ts-image-magnify-glass-shadow';
		}
		if ($zoom_border == "true") {
			$loupeclasses				.= ' ts-image-magnify-glass-border';
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Image_Magnify', $atts);
		} else {
			$css_class	= '';
		}
		
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
			if ($layout == "loupe") {
				$output .= '<div id="' . $image_id . '" class="ts-image-magnify-container ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;" data-zoomeffect="' . $zoom_effect . '" data-zoomstartx="' . $zoom_x . '" data-zoomstarty="' . $zoom_y . '" data-zoomrestore="' . $zoom_restore . '" data-zoomtimeout="' . $zoom_timeout . '" data-zoomlevel="' . ($zoom_level / 100) . '" data-zoomrange="' . $zoom_range . '" data-zoomsize="' . $zoom_size . '" data-zoomcircle="' . $zoom_circle . '" data-zoomdrag="' . $zoom_drag . '" data-zoomreflect="' . $zoom_reflect . '" data-zoomshow="' . $zoom_show . '" data-zoomoutside="' . $zoom_outside . '" data-zoommouse="' . $zoom_mouse . '" data-zoomwheel="' . $zoom_wheel . '" data-zoompinch="' . $zoom_pinch . '">';
					if (isset($full_image[0])) {
						if ($zoom_lightbox == "true") {
							$output .= '<a id="' . $image_id . '-trigger" href="' . (isset($full_image[0]) ? $full_image[0] : '') . '" class="ts-image-magnify-link ' . $image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="" data-title="' . $attribute_title . '" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '"></a>';
						}
						if ($zoom_range == "true") {
							$output .= '<div class="ts-image-magnify-scale"></div>';
							$output .= '<input class="ts-image-magnify-range" type="range" min="1" max="10" step="0.1" value="">';
						}
						$output .= '<div class="ts-image-magnify-glass ' . $loupeclasses . '" style="' . $full_background . ' width: ' . $zoom_size . 'px; height: ' . $zoom_size . 'px;" data-zoom="' . ($zoom_level / 100) . '"><div class="ts-image-magnify-zoomed">';
							if ($zoom_note == "true") {
								$output .= '<span class="ts-image-magnify-level"></span>';
							}
						$output .= '</div></div>';
						$output .= '<img class="ts-image-magnify-preview ts-image-magnify-' . $zoom_effect . '" data-no-lazy="1" src="' . $small_image[0] . '" alt="' . $alt_attribute . '"/>';
					} else {
						$output .= '<div style="text-align: justify; color: red; font-weight: bold;">' . __("ERROR: Please assign a valid image to the element.", "ts_visual_composer_extend") . '</div>';
					}
				$output .= '</div>';
			}
			if ($layout == "buttons") {
				$output .= '<div id="' . $image_id . '" class="ts-image-zoomer-container ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;" data-width="' . $dimensions_x . '" data-height="' . $dimensions_y . '" data-aspect="' . $aspect . '" data-ratio="' . $image_ratio . '" data-position="' . $zoom_controls . '" data-scale="' . $zoom_scale . '" data-reset="' . $zoom_reset . '" data-rotate="' . $zoom_rotate . '" data-lightbox="' . $zoom_lightbox . '">';
					if (isset($full_image[0])) {
						if ($zoom_lightbox == "true") {
							$output .= '<a id="' . $image_id . '-trigger" href="' . (isset($full_image[0]) ? $full_image[0] : '') . '" class="ts-image-zoomer-link ' . $image_id . '-parent nch-holder nch-lightbox-media no-ajaxy" ' . $lightbox_dimensions . ' style="display: none;" data-title="' . $attribute_title . '" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '"></a>';
						}
						$output .= '<img class="ts-image-zoomer-holder" src="' . (isset($full_image[0]) ? $full_image[0] : '') . '" data-no-lazy="1" style="display: none; ' . $image_adjust . '" alt="' . $alt_attribute . '">';
						$output .= '<div class="ts-image-zoomer-viewer" style="' . $background_style . '">';
							$output .= '<img class="ts-image-zoomer-preview" src="' . (isset($full_image[0]) ? $full_image[0] : '') . '" alt="' . $alt_attribute . '" style="display: none; ' . $image_adjust . '" data-reset="' . $zoom_reset . '" data-rotate="' . $zoom_rotate . '" data-lightbox="' . $zoom_lightbox . '" data-trigger="' . $image_id . '-trigger">';
						$output .= '</div>';
					} else {
						$output .= '<div style="text-align: justify; color: red; font-weight: bold;">' . __("ERROR: Please assign a valid image to the element.", "ts_visual_composer_extend") . '</div>';
					}
				$output .= '</div>';
			}
		} else {
			$output .= '<div id="' . $image_id . '" class="ts-image-zoomer-edit ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; padding: 0; width: 100%; height: 100%;">';
				$output .= '<div style="text-align: justify; display: block; margin-bottom: 10px; font-style: italic;">' . __("Image Magnify or Zoom effects and controls are not available in front end editor mode.", "ts_visual_composer_extend") . '</div>';
				if ($layout == "loupe") {
					$output .= '<div style="text-align: justify; display: block; margin-bottom: 10px;">' . __( "Layout", "ts_visual_composer_extend" ) . ': ' . __("Loupe Layout", "ts_visual_composer_extend") . '</div>';
				} else if ($layout == "buttons") {
					$output .= '<div style="text-align: justify; display: block; margin-bottom: 10px;">' . __( "Layout", "ts_visual_composer_extend" ) . ': ' . __("Zoom Buttons", "ts_visual_composer_extend") . '</div>';
				}
				if (isset($full_image[0])) {
					$output .= '<img class="ts-image-zoomer-edit ts-image-magnify-' . $zoom_effect . '" data-no-lazy="1" src="' . $full_image[0] . '" alt="' . $alt_attribute . '" style="width: 100%; height: auto; margin: 0; padding: 0;"/>';
				} else {
					$output .= '<div style="text-align: justify; color: red; font-weight: bold;">' . __("ERROR: Please assign a valid image to the element.", "ts_visual_composer_extend") . '</div>';
				}
			$output .= '</div>';
		}
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>