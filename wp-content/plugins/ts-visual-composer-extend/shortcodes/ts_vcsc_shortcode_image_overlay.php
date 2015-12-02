<?php
	add_shortcode('TS_VCSC_Image_Overlay', 'TS_VCSC_Image_Overlay_Function');
	add_shortcode('TS-VCSC-Image-Overlay', 'TS_VCSC_Image_Overlay_Function');
	function TS_VCSC_Image_Overlay_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-extend-simptip');
		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-extend-badonkatrunc');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'image'						=> '',
			'attribute_alt'				=> 'false',
			'attribute_alt_value'		=> '',
			'title'						=> '',
			'message_code'				=> 'false',
			'message'					=> '',
			'message_html'				=> '',
			'message_truncate'			=> 'false',
			'image_fixed'				=> 'false',
			'image_width'				=> 300,
			'image_height'				=> 200,
			'image_position'			=> 'ts-imagefloat-center',
			'hover_type'           		=> 'ts-imagehover-style1',
			'hover_active'				=> 'false',			
			'frame_type'				=> '',
			'frame_thick'				=> 1,
			'frame_color'				=> '#000000',			
			'button_style'				=> 'true',
			'button_text'				=> 'Read More',
			'button_url'				=> '',
			'button_target'				=> '_parent',
			'margin_top'				=> 0,
			'margin_bottom'				=> 0,
			'overlay_trigger'			=> 'ts-trigger-hover',
			'overlay_handle_show'		=> 'true',
			'overlay_handle_color'		=> '#0094FF',
			'tooltip_css'				=> 'false',
			'tooltip_content'			=> '',
			'tooltip_position'			=> 'ts-simptip-position-top',
			'tooltip_style'				=> '',
			'el_id' 					=> '',
			'el_class'                  => '',
			'css'						=> '',
		), $atts ));
	
		$hover_image 					= wp_get_attachment_image_src($image, 'large');
		
		$hover_margin 					= 'margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
		
		$output 						= "";
		
		if (!empty($el_id)) {
			$hover_image_id				= $el_id;
		} else {
			$hover_image_id				= 'ts-vcsc-image-hover-' . mt_rand(999999, 9999999);
		}
		
		// Check for Front End Editor
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
			$hover_frontend				= "true";
			$message_truncate			= "false";
		} else {
			$hover_frontend				= "false";
			$message_truncate			= $message_truncate;
		}
		
		// Border Settings
		if ($frame_type != '') {
			$overlay_border				= 'border: ' . $frame_thick . 'px ' . $frame_type . ' ' . $frame_color;
		} else {
			$overlay_border				= '';
		}
	
		// Handle Padding
		if ($overlay_handle_show == "true") {
			$overlay_padding			= "padding-bottom: 25px;";
			$switch_handle_adjust  		= "";
		} else {
			$overlay_padding			= "";
			$switch_handle_adjust  		= "";
		}
		
		// Handle Icon
		if ($overlay_trigger == "ts-trigger-click") {
			$switch_handle_icon			= 'handle_click';
		} else if ($overlay_trigger == "ts-trigger-hover") {
			$switch_handle_icon			= 'handle_hover';
		}
	
		// Tooltip
		if ($tooltip_css == "true") {
			if (strlen($tooltip_content) != 0) {
				$hover_tooltipclasses	= " ts-simptip-multiline " . $tooltip_style . " " . $tooltip_position;
				$hover_tooltipcontent	= ' data-tstooltip="' . $tooltip_content . '"';
			} else {
				$hover_tooltipclasses	= "";
				$hover_tooltipcontent	= "";
			}
		} else {
			$hover_tooltipclasses		= "";
			if (strlen($tooltip_content) != 0) {
				$hover_tooltipcontent	= ' title="' . $tooltip_content . '"';
			} else {
				$hover_tooltipcontent	= "";
			}
		}
		
		$image_extension 				= pathinfo($hover_image[0], PATHINFO_EXTENSION);
		
		if ($attribute_alt == "true") {
			$alt_attribute				= $attribute_alt_value;
		} else {
			$alt_attribute				= basename($hover_image[0], "." . $image_extension);
		}
		
		if ($message_truncate == "true") {
			$truncate_class				= "ts-imagehover-truncate";
		} else {
			$truncate_class				= "ts-imagehover-static";
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-image-hover-frame ' . $image_position . ' ' . $hover_tooltipclasses . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Image-Overlay', $atts);
		} else {
			$css_class	= 'ts-image-hover-frame ' . $image_position . ' ' . $hover_tooltipclasses . ' ' . $el_class;
		}
		
		if ($image_fixed == "true") {
			$output .= '<div id="' . $hover_image_id . '" class="' . $css_class . ' ts-trigger-hover-adjust" ' . $hover_tooltipcontent . ' style="width: ' . $image_width . 'px; ' . $hover_margin . '">';
				$output .= '<div id="' . $hover_image_id . '-counter" class="ts-fluid-wrapper " style="width: ' . $image_width . 'px; height: auto;">';
					if ($overlay_handle_show == "true") {
						$output .= '<div style="' . $overlay_padding . '">';
					}
						$output .= '<div id="' . $hover_image_id . '-mask" class="ts-imagehover ' . $truncate_class . ' ' . $hover_type . ' ' . $overlay_trigger . ' ' . ((($hover_active == "true") && ($overlay_trigger == "ts-trigger-click")) ? "active" : "") . '" data-trigger="' . $overlay_trigger . '" data-closer="' . $hover_image_id . '-closer" style="width: ' . $image_width . 'px; height: ' . $image_height . 'px; ' . $overlay_border . '">';
							if ($overlay_trigger == "ts-trigger-click") {
								$output .= '<div id="' . $hover_image_id . '-closer" class="ts-imagecloser" data-mask="' . $hover_image_id . '-mask"></div>';
							}
							$output .= '<img src="' . $hover_image[0] . '" data-no-lazy="1" alt="' . $alt_attribute . '" style="width: ' . $image_width . 'px; height: ' . $image_height . 'px;"/>';
							$output .= '<div class="mask" style="width: ' . $image_width . 'px; height: ' . $image_height . 'px; display: ' . ((($hover_active == "false") && ($overlay_trigger == "ts-trigger-click")) ? "none;" : "block;") . '">';
								$output .= '<h2>' . $title . '</h2>';
								if ($message_code == "false") {
									$output .= '<p id="' . $hover_image_id . '-maskcontent" class="maskcontent">' . strip_tags($message) . '</p>';
								} else {
									$output .= '<p id="' . $hover_image_id . '-maskcontent" class="maskcontent">' . rawurldecode(base64_decode(strip_tags($message_html))) . '</p>';
								}
								if (strlen($button_url) != 0) {
									if ($button_style == "true") {
										$output .= '<a id="' . $hover_image_id . '-readmore" href="' . $button_url . '" class="info ts-image-hover-button" target="' . $button_target . '">' . $button_text . '</a>';
									} else {
										$output .= '<a id="' . $hover_image_id . '-readmore" class="ts-imagereadmore" data-mask="' . $hover_image_id . '-mask" href="' . $button_url . '" target="' . $button_target . '"></a>';
									}
								}
							$output .= '</div>';
						$output .= '</div>';
						if ($overlay_handle_show == "true") {
							$output .= '<div class="ts-image-hover-handle" style="' . $switch_handle_adjust . '"><span class="frame_' . $switch_handle_icon . '" style="background-color: ' . $overlay_handle_color . '"><i class="' . $switch_handle_icon . '"></i></span></div>';
						}
					if ($overlay_handle_show == "true") {
						$output .= '</div>';
					}
				$output .= '</div>';
			$output .= '</div>';
		} else {
			$output .= '<div id="' . $hover_image_id . '" class="' . $css_class . ' ts-trigger-hover-adjust" ' . $hover_tooltipcontent . ' style="width: 100%; ' . $hover_margin . '">';
				$output .= '<div id="' . $hover_image_id . '-counter" class="ts-fluid-wrapper " style="width: 100%; height: auto;">';
					if ($overlay_handle_show == "true") {
						$output .= '<div style="' . $overlay_padding . '">';
					}
						$output .= '<div id="' . $hover_image_id . '-mask" class="ts-imagehover ' . $truncate_class . ' ' . $hover_type . ' ' . $overlay_trigger . ' ' . ((($hover_active == "true") && ($overlay_trigger == "ts-trigger-click")) ? "active" : "") . '" data-trigger="' . $overlay_trigger . '" data-closer="' . $hover_image_id . '-closer" style="width: 100%; height: auto; ' . $overlay_border . '">';
							if ($overlay_trigger == "ts-trigger-click") {
								$output .= '<div id="' . $hover_image_id . '-closer" class="ts-imagecloser" data-mask="' . $hover_image_id . '-mask"></div>';
							}
							$output .= '<img src="' . $hover_image[0] . '" data-no-lazy="1" alt="' . $alt_attribute . '" style="width: 100%; height: auto;"/>';
							$output .= '<div class="mask" style="width: 100%; height: 100%; display: ' . ((($hover_active == "false") && ($overlay_trigger == "ts-trigger-click")) ? "none;" : "block;") . '">';
								$output .= '<h2 class="ts-image-hover-title">' . $title . '</h2>';
								if ($message_code == "false") {
									$output .= '<p id="' . $hover_image_id . '-maskcontent" class="maskcontent">' . strip_tags($message) . '</p>';
								} else {
									$output .= '<p id="' . $hover_image_id . '-maskcontent" class="maskcontent">' . rawurldecode(base64_decode(strip_tags($message_html))) . '</p>';
								}
								if (strlen($button_url) != 0) {
									if ($button_style == "true") {
										$output .= '<a id="' . $hover_image_id . '-readmore" href="' . $button_url . '" class="info ts-image-hover-button" target="' . $button_target . '">' . $button_text . '</a>';
									} else {
										$output .= '<a id="' . $hover_image_id . '-readmore" class="ts-imagereadmore" data-mask="' . $hover_image_id . '-mask" href="' . $button_url . '" target="' . $button_target . '"></a>';
									}
								}
							$output .= '</div>';
						$output .= '</div>';
						if ($overlay_handle_show == "true") {
							$output .= '<div class="ts-image-hover-handle" style="' . $switch_handle_adjust . '"><span class="frame_' . $switch_handle_icon . '" style="background-color: ' . $overlay_handle_color . '"><i class="' . $switch_handle_icon . '"></i></span></div>';
						}
					if ($overlay_handle_show == "true") {
						$output .= '</div>';
					}
				$output .= '</div>';
			$output .= '</div>';
		}
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>