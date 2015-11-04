<?php
	add_shortcode('TS-VCSC-Pricing-Table', 'TS_VCSC_Pricing_Table_Function');
	function TS_VCSC_Pricing_Table_Function ($atts, $content = null) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-extend-simptip');
		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-extend-pricingtables');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'style'						=> "1",
			'featured'					=> 'false',
			'featured_text'				=> 'Recommended',
			'plan'						=> 'Basic',
			'plan_color_active'			=> '3b86b0',
			'plan_color_inactive'		=> 'e5e5e5',
			'cost'						=> '$20',
			'per'						=> '/ month',
			'cost_color'				=> 'f7f7f7',
			'content_color'				=> 'ffffff',
			
			'shadow_enabled'			=> 'true',
			'shadow_featured_default'	=> 'rgba(0, 0, 0, 0.15)',
			'shadow_featured_hover'		=> 'rgba(129, 215, 66, 0.5)',
			'shadow_standard_hover'		=> 'rgba(55, 188, 229, 0.5)',
			
			'graphic_type'				=> 'none',
			'graphic_icon'				=> '',
			'graphic_image'				=> '',
			'graphic_size'				=> 30,
			'graphic_color'				=> '#333333',
			'graphic_position'			=> 'title',
			
			'link_type'					=> 'default',
			'button_url'				=> '',
			'button_text'				=> 'Purchase',
			'button_target'				=> '_parent',
			'button_style'				=> 'ts-dual-buttons-color-default',
			'button_hover'				=> 'ts-dual-buttons-preview-default ts-dual-buttons-hover-default',
			'button_custom'				=> '',
			'button_size'				=> 16,
			'button_width'				=> 80,
			
			'margin_top'				=> 0,
			'margin_bottom'				=> 0,
			'el_id'						=> '',
			'el_class'					=> '',
			'css'						=> '',
		), $atts ) );
		
		$class							= '';
		
		if ($link_type == 'flat') {
			wp_enqueue_style('ts-extend-buttonsdual');
		}
		
		if (!empty($el_id)) {
			$pricetable_id				= $el_id;
		} else {
			$pricetable_id				= 'ts-vcsc-pricing-table-' . mt_rand(999999, 9999999);
		}
		
		$featured_pricing 				= ($featured == 'true') ? ' featured' : NULL;
		$border_radius_style 			= '';
		$margin_settings				= 'margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
	
		$output 						= '';
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Pricing-Table', $atts);
		} else {
			$css_class	= '';
		}
		
		if (($graphic_type == 'icon') && ($graphic_icon != '') && ($graphic_icon != 'transparent')) {
			$graphic_string				= '<div class="ts-pricing-table-icon" style="display: block; width: 100%; padding: 0; text-align: center; margin: ' . ($graphic_position == 'content' ? '20px auto 0 auto' : '0 auto') . '">';
				$graphic_string 			.= '<i class="ts-font-icon ' . $graphic_icon . '" style="font-size: ' . $graphic_size . 'px; line-height: ' . $graphic_size . 'px; text-align: center; margin: 10px auto; color: ' . $graphic_color . ';"></i>';
			$graphic_string				.= '</div>';
		} else if (($graphic_type == 'image') && ($graphic_image != '')) {
			$graphic_image 				= wp_get_attachment_image_src($graphic_image, 'full');
			$graphic_string				= '<div class="ts-pricing-table-icon" style="display: block; width: 100%; padding: 0; text-align: center; margin: ' . ($graphic_position == 'content' ? '20px auto 0 auto' : '0 auto') . '">';
				$graphic_string 			.= '<img src="' .$graphic_image[0] . '" class="" style="width: ' . $graphic_size . 'px; height: auto; text-align: center; margin: 10px auto;">';
			$graphic_string				.= '</div>';
		} else {
			$graphic_string				= '';
		}
		
		// Box Shadow CSS
		if ($style == "1") {
			$css_standard				= 'body #' . $pricetable_id . '.ts-pricing.style1';
			$css_featured				= 'body #' . $pricetable_id . '.ts-pricing.style1.featured';
		} else if ($style == "2") {
			$css_standard				= 'body #' . $pricetable_id . '.ts-pricing.style2 .plan';
			$css_featured				= 'body #' . $pricetable_id . '.ts-pricing.style2 .plan.featured';
		} else if ($style == "3") {
			$css_standard				= 'body #' . $pricetable_id . '.ts-pricing.style3 .plan';
			$css_featured				= 'body #' . $pricetable_id . '.ts-pricing.style3 .plan-highlight';
		} else if ($style == "4") {
			$css_standard				= 'body #' . $pricetable_id . '.ts-pricing.style4 .plan';
			$css_featured				= 'body #' . $pricetable_id . '.ts-pricing.style4 .plan-tall';
		} else if ($style == "5") {
			$css_standard				= 'body #' . $pricetable_id . '.ts-pricing.style5 .ts-pricing-table';
			$css_featured				= 'body #' . $pricetable_id . '.ts-pricing.style5 .ts-pricing-table.featured';
		}
		$output .= '<style id="' . $pricetable_id . '-styling" type="text/css">';
			if ($shadow_enabled == 'true') {
				$output .= $css_featured . ' {';
					$output .= '-moz-box-shadow: 20px 0 10px -10px ' . $shadow_featured_default . ', -20px 0 10px -10px ' . $shadow_featured_default . ' !important;';
					$output .= '-webkit-box-shadow: 20px 0 10px -10px ' . $shadow_featured_default . ', -20px 0 10px -10px ' . $shadow_featured_default . ' !important;';
					$output .= 'box-shadow: 20px 0 10px -10px ' . $shadow_featured_default . ', -20px 0 10px -10px ' . $shadow_featured_default . ' !important;';
				$output .= '}';
				$output .= $css_standard . ':hover {';
					$output .= '-webkit-box-shadow: 20px 0 10px -10px ' . $shadow_standard_hover . ', -20px 0 10px -10px ' . $shadow_standard_hover . ' !important;';
					$output .= '-moz-box-shadow: 20px 0 10px -10px ' . $shadow_standard_hover . ', -20px 0 10px -10px ' . $shadow_standard_hover . ' !important;';
					$output .= 'box-shadow: 20px 0 10px -10px ' . $shadow_standard_hover . ', -20px 0 10px -10px ' . $shadow_standard_hover . ' !important;';
				$output .= '}';
				$output .= $css_featured . ':hover {';
					$output .= '-moz-box-shadow: 20px 0 10px -10px ' . $shadow_featured_hover . ', -20px 0 10px -10px ' . $shadow_featured_hover . ' !important;';
					$output .= '-webkit-box-shadow: 20px 0 10px -10px ' . $shadow_featured_hover . ', -20px 0 10px -10px ' . $shadow_featured_hover . ' !important;';
					$output .= 'box-shadow: 20px 0 10px -10px ' . $shadow_featured_hover . ', -20px 0 10px -10px ' . $shadow_featured_hover . ' !important;';
				$output .= '}';
			} else {
				$output .= $css_featured . ' {';
					$output .= '-webkit-box-shadow: none !important;';
					$output .= '-moz-box-shadow: none !important;';
					$output .= 'box-shadow: none !important;';
				$output .= '}';
				$output .= $css_standard . ':hover {';
					$output .= '-webkit-box-shadow: none !important;';
					$output .= '-moz-box-shadow: none !important;';
					$output .= 'box-shadow: none !important;';
				$output .= '}';
				$output .= $css_featured . ':hover {';
					$output .= '-moz-box-shadow: none !important;';
					$output .= '-webkit-box-shadow: none !important;';
					$output .= 'box-shadow: none !important;';
				$output .= '}';
			}
		$output .= '</style>';
		
		if ($style == "1") {
			$output .= '<div id="' . $pricetable_id . '" class="ts-pricing style1 clearFixMe' . $featured_pricing . ' ' . $class . ' ' . $css_class . '" style="' . $margin_settings . '">';
				$output .= '<div class="ts-pricing-header" >';
					$output .= '<h5>';
						if ($graphic_position == 'title') {						
							$output .= $graphic_string;
						}
						$output .= $plan;
					$output .='</h5>';
				$output .= '</div>';
				$output .= '<div class="ts-pricing-cost clr">';
					$output .= '<div class="ts-pricing-amount">'. $cost .'</div><div class="ts-pricing-per">'. $per .'</div>';
				$output .= '</div>';
				if ($graphic_position == 'content') {						
					$output .= $graphic_string;
				}
				$output .= '<div class="ts-pricing-content">';
					if (!function_exists('wpb_js_remove_wpautop')){
						$output .= ''. do_shortcode(wpb_js_remove_wpautop($content, true)) . '';
					} else {
						$output .= ''. do_shortcode($content) . '';
					}
				$output .= '</div>';
				if (($link_type == "default") && (!empty($button_url))) {
					$output .= '<div class="ts-pricing-link">';
						$output .= '<a href="'. $button_url .'" target="'. $button_target .'" '. $border_radius_style .' class="ts-pricing-button">'. $button_text .'</a>';
					$output .= '</div>';
				} else if (($link_type == "flat") && (!empty($button_url))) {
					$button_style				= $button_style . ' ' . $button_hover;
					$output .= '<a class="ts-dual-buttons-wrapper" href="' . $button_url . '" target="' . $button_target . '">';
						$output .= '<div class="ts-dual-buttons-container clearFixMe ' . $button_style . '" style="display: block; width: ' . $button_width . '%; margin: 20px auto;">';
							$output .= '<span class="ts-dual-buttons-title" style="font-size: ' . $button_size . 'px; line-height: ' . $button_size . 'px;">' . $button_text . '</span>';			
						$output .= '</div>';
					$output .= '</a>';					
				} else if (($link_type == "custom") && (!empty($button_custom))) {
					$output .= '<div class="ts-pricing-link">' . rawurldecode(base64_decode(strip_tags($button_custom))) . '</div>';
				}
			$output .= '</div>';
		}
		if ($style == "2") {
			if (($link_type == "default") && (!empty($button_url))) {
				$margin_adjust = '';
			} else if (($link_type == "flat") && (!empty($button_url))) {
				$margin_adjust = '';
			} else if (($link_type == "custom") && (!empty($button_custom))) {
				$margin_adjust = '';
			} else {
				$margin_adjust = 'margin-top: 60px;';
			}			
			$output .= '<div id="' . $pricetable_id . '" class="ts-pricing style2 clearFixMe ' . $class . ' ' . $css_class . '" style="' . $margin_settings . '">';
				$output .= '<div class="plan' . $featured_pricing . '">';
					$output .= '<h3>';
						if ($graphic_position == 'title') {						
							$output .= $graphic_string;
						}						
						$output .= '' . $plan . '<span>' . $cost . '</span>';						
					$output .= '</h3>';
					if (($link_type == "default") && (!empty($button_url))) {
						$output .= '<div class="ts-pricing-link" style="margin: 60px auto 0 auto !important;">';
							$output .= '<a class="signup" href="' . $button_url . '" target="'. $button_target .'">' . $button_text . '</a>';
						$output .= '</div>';
					} else if (($link_type == "flat") && (!empty($button_url))) {
						$button_style				= $button_style . ' ' . $button_hover;
						$output .= '<div class="ts-pricing-link" style="margin: 60px auto 0 auto !important;">';
						$output .= '<a class="ts-dual-buttons-wrapper" href="' . $button_url . '" target="' . $button_target . '">';
							$output .= '<div class="ts-dual-buttons-container clearFixMe ' . $button_style . '" style="display: block; width: ' . $button_width . '%; margin: 0 auto;">';
								$output .= '<span class="ts-dual-buttons-title" style="font-size: ' . $button_size . 'px; line-height: ' . $button_size . 'px;">' . $button_text . '</span>';			
							$output .= '</div>';
						$output .= '</a>';
						$output .= '</div>';
					} else if (($link_type == "custom") && (!empty($button_custom))) {
						$output .= '<div class="ts-pricing-link" style="margin: 60px auto 0 auto !important;">' . rawurldecode(base64_decode(strip_tags($button_custom))) . '</div>';
					}
					if ($graphic_position == 'content') {						
						$output .= $graphic_string;
					}
					if (!function_exists('wpb_js_remove_wpautop')){
						$output .= '<div style="' . $margin_adjust . '">'. do_shortcode(wpb_js_remove_wpautop($content, true)) . '</div>';
					} else {
						$output .= '<div style="' . $margin_adjust . '">'. do_shortcode($content) . '</div>';
					}
				$output .= '</div>';
			$output .= '</div>';
		}
		if ($style == "3") {
			$output .= '<div id="' . $pricetable_id . '" class="ts-pricing style3 clearFixMe ' . $class . ' ' . $css_class . '" style="' . $margin_settings . '">';
				$output .= '<div class="plan' . ($featured == "true" ? " plan-highlight" : "") . '">';
					if ($featured == "true") {
						$output .= '<div class="plan-recommended">' . $featured_text . '</div>';
					}
					if ($graphic_position == 'title') {						
						$output .= $graphic_string;
					}
					$output .= '<h3 class="plan-title">' . $plan . '</h3>';
					$output .= '<div class="plan-price">'. $cost .'<span class="plan-unit">'. $per .'</span></div>';
					if ($graphic_position == 'content') {						
						$output .= $graphic_string;
					}
					if (!function_exists('wpb_js_remove_wpautop')){
						$output .= '' . do_shortcode(wpb_js_remove_wpautop($content, true)) . '';
					} else {
						$output .= '' . do_shortcode($content) . '';
					}
					if (($link_type == "default") && (!empty($button_url))) {
						$output .= '<div class="ts-pricing-link"><a href="' . $button_url . '" class="plan-button" target="'. $button_target .'">' . $button_text . '</a></div>';
					} else if (($link_type == "flat") && (!empty($button_url))) {
						$button_style				= $button_style . ' ' . $button_hover;
						$output .= '<a class="ts-dual-buttons-wrapper" href="' . $button_url . '" target="' . $button_target . '">';
							$output .= '<div class="ts-dual-buttons-container clearFixMe ' . $button_style . '" style="display: block; width: ' . $button_width . '%; margin: 20px auto;">';
								$output .= '<span class="ts-dual-buttons-title" style="font-size: ' . $button_size . 'px; line-height: ' . $button_size . 'px;">' . $button_text . '</span>';			
							$output .= '</div>';
						$output .= '</a>';	
					} else if (($link_type == "custom") && (!empty($button_custom))) {
						$output .= '<div class="ts-pricing-link">' . rawurldecode(base64_decode(strip_tags($button_custom))) . '</div>';
					}
				$output .= '</div>';
			$output .= '</div>';
		}
		if ($style == "4") {
			$output .= '<div id="' . $pricetable_id . '" class="ts-pricing style4 clearFixMe ' . $class . ' ' . $css_class . '" style="' . $margin_settings . '">';
				$output .= '<div class="plan ' . ($featured == "true" ? "plan-tall" : "") . '">';
					if ($graphic_position == 'title') {						
						$output .= $graphic_string;
					}
					$output .= '<h2 class="plan-title">' . $plan . '</h2>';
					$output .= '<div class="plan-price">'. $cost .'<span>'. $per .'</span></div>';
					if ($graphic_position == 'content') {						
						$output .= $graphic_string;
					}
					if (!function_exists('wpb_js_remove_wpautop')){
						$output .= '' . do_shortcode(wpb_js_remove_wpautop($content, true)) . '';
					} else {
						$output .= '' . do_shortcode($content) . '';
					}
					if (($link_type == "default") && (!empty($button_url))) {
						$output .= '<div class="ts-pricing-link"><a href="' . $button_url . '" class="plan-button" target="'. $button_target .'">' . $button_text . '</a></div>';
					} else if (($link_type == "flat") && (!empty($button_url))) {
						$button_style				= $button_style . ' ' . $button_hover;
						$output .= '<a class="ts-dual-buttons-wrapper" href="' . $button_url . '" target="' . $button_target . '">';
							$output .= '<div class="ts-dual-buttons-container clearFixMe ' . $button_style . '" style="display: block; width: ' . $button_width . '%; margin: 20px auto;">';
								$output .= '<span class="ts-dual-buttons-title" style="font-size: ' . $button_size . 'px; line-height: ' . $button_size . 'px;">' . $button_text . '</span>';			
							$output .= '</div>';
						$output .= '</a>';	
					} else if (($link_type == "custom") && (!empty($button_custom))) {
						$output .= '<div class="ts-pricing-link">' . rawurldecode(base64_decode(strip_tags($button_custom))) . '</div>';
					}
				$output .= '</div>';
			$output .= '</div>';
		}
		if ($style == "5") {
			$output .= '<div id="' . $pricetable_id . '" class="ts-pricing style5 clearFixMe ' . $class . ' ' . $css_class . '" style="' . $margin_settings . '">';
				$output .= '<div class="ts-pricing-table' . $featured_pricing . '">';
					$output .= '<div class="ts-pricing-table-header">';
						if ($graphic_position == 'title') {						
							$output .= $graphic_string;
						}
						$output .= '<h1>' . $plan . '</h1>';
					$output .= '</div>';
					$output .= '<div class="ts-pricing-table-content">';
						if ($graphic_position == 'content') {						
							$output .= $graphic_string;
						}
						if (!function_exists('wpb_js_remove_wpautop')){
							$output .= '' . do_shortcode(wpb_js_remove_wpautop($content, true)) . '';
						} else {
							$output .= '' . do_shortcode($content) . '';
						}
					$output .= '</div>';
					$output .= '<div class="ts-pricing-table-footer">';
						$output .= '<h2>'. $cost .'</h2>';
						$output .= '<p>'. $per .'</p>';
						if (($link_type == "default") && (!empty($button_url))) {
							$output .= '<div class="ts-pricing-link"><a href="' . $button_url . '" class="plan-button" target="'. $button_target .'">' . $button_text . '</a></div>';
						} else if (($link_type == "flat") && (!empty($button_url))) {
							$button_style				= $button_style . ' ' . $button_hover;
							$output .= '<a class="ts-dual-buttons-wrapper" href="' . $button_url . '" target="' . $button_target . '">';
								$output .= '<div class="ts-dual-buttons-container clearFixMe ' . $button_style . '" style="display: block; width: ' . $button_width . '%; margin: 20px auto;">';
									$output .= '<span class="ts-dual-buttons-title" style="font-size: ' . $button_size . 'px; line-height: ' . $button_size . 'px;">' . $button_text . '</span>';			
								$output .= '</div>';
							$output .= '</a>';	
						} else if (($link_type == "custom") && (!empty($button_custom))) {
							$output .= '<div class="ts-pricing-link">' . rawurldecode(base64_decode(strip_tags($button_custom))) . '</div>';
						}
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
		}
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>
