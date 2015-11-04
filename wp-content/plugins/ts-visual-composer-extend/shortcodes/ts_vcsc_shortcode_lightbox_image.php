<?php
	add_shortcode('TS-VCSC-Lightbox-Image', 'TS_VCSC_Lightbox_Image_Function');
	//add_shortcode('TS_VCSC_Lightbox_Image', 'TS_VCSC_Lightbox_Image_Function');
	function TS_VCSC_Lightbox_Image_Function ($atts, $content = null) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		extract( shortcode_atts( array(
			'featured_image'				=> 'false',
			
			'external_link_usage'			=> 'false', // true, false, featured
			'external_link_lightbox'		=> '',
			'external_link_preview'			=> '',
			
			'content_title'					=> '',			
			'content_image'					=> '',
			'content_align'					=> 'center', // center, left, right
			'content_shape'					=> 'standard', // standard, circle, losange, diamond, hexagon, octagon
			
			'content_image_responsive'		=> 'true',
			'content_image_height'			=> 'height: 100%;',
			'content_image_width_r'			=> 100,
			'content_image_width_f'			=> 300,
			'content_image_size'			=> 'medium',

			'attribute_alt'					=> 'false',
			'attribute_alt_value'			=> '',
			
			'lightbox_alternative'			=> 'false',
			'lightbox_image'				=> '',			
			'lightbox_group'				=> 'true',
			'lightbox_group_name'			=> '',
			'lightbox_size'					=> 'full',
			'lightbox_effect'				=> 'random',
			'lightbox_speed'				=> 5000,
			'lightbox_social'				=> 'false',
			'lightbox_backlight'			=> 'auto',
			'lightbox_backlight_color'		=> '#ffffff',
			'lightbox_nohashes'				=> 'true',

			'margin_top'					=> 0,
			'margin_bottom'					=> 0,
			'el_id'							=> '',
			'el_class'						=> '',
			'css'							=> '',
		), $atts ));
		
		
		wp_enqueue_script('ts-extend-hammer');
		wp_enqueue_script('ts-extend-nacho');
		wp_enqueue_style('ts-extend-nacho');
		wp_enqueue_style('ts-extend-simptip');
		wp_enqueue_style('ts-extend-animations');		
		if ($content_shape != "standard") {
			wp_enqueue_style('ts-extend-imageshapes');
			wp_enqueue_script('ts-extend-imageshapes');
		}
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
	
		if (!empty($el_id)) {
			$modal_id						= $el_id;
		} else {
			$modal_id						= 'ts-vcsc-lightbox-image-' . mt_rand(999999, 9999999);
		}
		
		$output								= '';
		$nacho_color						= '';
		$modal_image						= '';
		$modal_thumb						= '';

		if ($external_link_usage == 'featured') {
			$post_id 						= get_the_ID();
			if ($post_id && has_post_thumbnail($post_id)) {
				$img_id 					= get_post_thumbnail_id($post_id);
			} else {
				$img_id 					= 0;
			}
			if (($post_id == '') || ($img_id == '') || ($img_id == 0)) {
				$myvariable = ob_get_clean();
				return $myvariable;
			} else {
				$modal_image 				= wp_get_attachment_image_src($img_id, $lightbox_size);
				$modal_image				= $modal_image[0];
				$modal_thumb 				= wp_get_attachment_image_src($img_id, $content_image_size);
				$modal_thumb				= $modal_thumb[0];
			}
		} else {		
			if ($external_link_usage == 'true') {
				$modal_image				= $external_link_lightbox;
				$modal_thumb				= $external_link_preview;
			} else {
				if (!empty($content_image)) {
					if ($lightbox_alternative == "true") {
						$modal_image 		= wp_get_attachment_image_src($lightbox_image, $lightbox_size);
						$modal_image		= $modal_image[0];
					} else {
						$modal_image 		= wp_get_attachment_image_src($content_image, $lightbox_size);
						$modal_image		= $modal_image[0];
					}
					$modal_thumb 			= wp_get_attachment_image_src($content_image, $content_image_size);
					$modal_thumb			= $modal_thumb[0];
				} else {
					$myvariable = ob_get_clean();
					return $myvariable;
				}
			}
		}

		if ($lightbox_backlight == "auto") {
			$nacho_color					= 'data-nohashes="' . $lightbox_nohashes . '"';
		} else if ($lightbox_backlight == "custom") {
			$nacho_color					= 'data-color="' . $lightbox_backlight_color . '" data-nohashes="' . $lightbox_nohashes . '"';
		} else if ($lightbox_backlight == "hideit") {
			$nacho_color					= 'data-color="rgba(0, 0, 0, 0)" data-nohashes="' . $lightbox_nohashes . '"';
		}
		
		if ($content_image_responsive == "true") {
			$image_dimensions				= 'width: 100%; height: auto;';
			$parent_dimensions				= 'width: ' . $content_image_width_r . '%; ' . $content_image_height;
		} else {
			$image_dimensions				= 'width: 100%; height: auto;';
			$parent_dimensions				= 'width: ' . $content_image_width_f . 'px; ' . $content_image_height;
		}
		
		$image_extension 					= pathinfo($modal_image, PATHINFO_EXTENSION);
		
		if ($attribute_alt == "true") {
			$alt_attribute					= $attribute_alt_value;
		} else {
			$alt_attribute					= basename($modal_image[0], "." . $image_extension);
		}
		
		if ($content_align == 'center') {
			$parent_alignment				= 'margin-left: auto; margin-right: auto; float: none;';
		} else if ($content_align == 'left') {
			$parent_alignment				= 'margin-left: 0px; margin-right: 0px; float: left;';
		} else if ($content_align == 'right') {
			$parent_alignment				= 'margin-left: 0px; margin-right: 0px; float: right;';
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			if ($content_shape == "standard") {
				$css_class 					= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'nchgrid-item nchgrid-tile nch-lightbox-image ' . $modal_id . '-parent ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Lightbox-Image', $atts);
			} else {
				$css_class 					= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-lightbox-shape-container ' . $modal_id . '-parent ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Lightbox-Image', $atts);
			}
		} else {
			if ($content_shape == "standard") {
				$css_class					= 'nchgrid-item nchgrid-tile nch-lightbox-image ' . $modal_id . '-parent ' . $el_class;
			} else {
				$css_class					= 'ts-lightbox-shape-container ' . $modal_id . '-parent ' . $el_class;
			}
		}
		
		$output .= '<div id="' . $modal_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; ' . $parent_dimensions . ' ' . $parent_alignment . '">';
			$output .= '<a href="' . $modal_image . '" class="nch-lightbox-media nofancybox no-ajaxy" data-title="' . $content_title . '" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-thumbnail="' . $modal_thumb . '" data-share="' . ($lightbox_social == "true" ? 1 : 0) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '>';
				if ($content_shape == "standard") {
					$output .= '<img src="' . $modal_thumb . '" alt="' . $alt_attribute . '" title="" style="display: block; ' . $image_dimensions . '">';
					$output .= '<div class="nchgrid-caption"></div>';
					if (!empty($content_title)) {
						$output .= '<div class="nchgrid-caption-text">' . $content_title . '</div>';
					}
				} else {
					if ($content_shape == "circle") {
						$output .= '<div class="ts-lightbox-shape-padding">';
							$output .= '<div class="ts-lightbox-shape-holder" data-effect="ts-lightbox-shape-' . $content_shape . '" style="">';
								$output .= '<div class="ts-lightbox-shape-inner">';
									$output .= '<img class="ts-lightbox-shape-image" src="' . $modal_thumb . '" data-no-lazy="1" alt="' . $alt_attribute . '" title="" style="">';
									$output .= '<div class="ts-lightbox-shape-caption"></div>';					
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';
					} else if ($content_shape == "losange") {
						$output .= '<div class="ts-lightbox-shape-padding">';
							$output .= '<div class="ts-lightbox-shape-holder" data-effect="ts-lightbox-shape-' . $content_shape . '" style="">';
								$output .= '<div class="ts-lightbox-shape-inner">';
									$output .= '<img class="ts-lightbox-shape-image" src="' . $modal_thumb . '" alt="' . $alt_attribute . '" title="" style="">';
									$output .= '<div class="ts-lightbox-shape-caption"></div>';					
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';
					} else if ($content_shape == "diamond") {
						$output .= '<div class="ts-lightbox-shape-padding">';
							$output .= '<div class="ts-lightbox-shape-holder" data-effect="ts-lightbox-shape-' . $content_shape . '" style="">';
								$output .= '<div class="ts-lightbox-shape-inner">';
									$output .= '<img class="ts-lightbox-shape-image" src="' . $modal_thumb . '" alt="' . $alt_attribute . '" title="" style="">';								
									$output .= '<div class="ts-lightbox-shape-caption"></div>';								
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';
					} else if ($content_shape == "hexagon") {
						$output .= '<div class="ts-lightbox-shape-padding">';
							$output .= '<div class="ts-lightbox-shape-holder" data-effect="ts-lightbox-shape-' . $content_shape . '" style="">';
								$output .= '<div class="ts-lightbox-shape-inner1">';
									$output .= '<div class="ts-lightbox-shape-inner2">';
										$output .= '<img class="ts-lightbox-shape-image" src="' . $modal_thumb . '" alt="' . $alt_attribute . '" title="" style="">';
										$output .= '<div class="ts-lightbox-shape-caption"></div>';
									$output .= '</div>';
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';
					} else if ($content_shape == "octagon") {
						$output .= '<div class="ts-lightbox-shape-padding">';
							$output .= '<div class="ts-lightbox-shape-holder" data-effect="ts-lightbox-shape-' . $content_shape . '" style="">';
								$output .= '<div class="ts-lightbox-shape-inner1">';
									$output .= '<div class="ts-lightbox-shape-inner2">';
										$output .= '<div class="ts-lightbox-shape-inner3">';
											$output .= '<img class="ts-lightbox-shape-image" src="' . $modal_thumb . '" alt="' . $alt_attribute . '" title="" style="">';
											$output .= '<div class="ts-lightbox-shape-caption"></div>';
										$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
							$output .= '</div>';
						$output .= '</div>';
					}
				}
			$output .= '</a>';
		$output .= '</div>';
		
		echo $output;
	
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_Lightbox_Image extends WPBakeryShortCode {};
	}
?>