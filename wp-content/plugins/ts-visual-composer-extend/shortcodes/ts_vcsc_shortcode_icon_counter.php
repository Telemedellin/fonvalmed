<?php
	add_shortcode('TS-VCSC-Icon-Counter', 'TS_VCSC_Icon_Counter_Function');
	function TS_VCSC_Icon_Counter_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndWaypoints == "true") {
			if (wp_script_is('waypoints', $list = 'registered')) {
				wp_enqueue_script('waypoints');
			} else {
				wp_enqueue_script('ts-extend-waypoints');
			}
		}
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndCountTo == "true") {
			wp_enqueue_script('ts-extend-countto');
		}
		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'icon'                      	=> '',
			'icon_position'             	=> 'top',
			'icon_size_slide'           	=> 75,
			'icon_margin'					=> 10,
			'icon_color'                	=> '#000000',
			'icon_background'		    	=> '',
			'icon_frame_type' 				=> '',
			'icon_frame_thick'				=> 1,
			'icon_frame_radius'				=> '',
			'icon_frame_color'				=> '#000000',
			'icon_replace'					=> 'false',
			'icon_image'					=> '',
			'padding'						=> 'false',
			'icon_padding'					=> 5,
			
			'link_counter'					=> '',
			'link_data'						=> '',
			'link_buttonstyle'				=> 'ts-dual-buttons-color-sun-flower',
			'link_buttonhover'				=> 'ts-dual-buttons-preview-default ts-dual-buttons-hover-default',
			'link_buttontext' 				=> 'Learn More',
			'link_buttonsize' 				=> 16,
			
			'counter_value_start'			=> 0,			
			'counter_value_by_shortcode'	=> 'false',			
			'counter_value_end'				=> '',
			'counter_value_end_shortcode'	=> '',			
			'counter_value_size'			=> 30,
			'counter_value_color'			=> '#000000',
			'counter_value_format'			=> 'false',
			'counter_value_plus'			=> 'false',
			'counter_value_seperator'		=> '',

			'counter_value_before'			=> '',
			'counter_value_after'			=> '',
			
			'counter_seperator'				=> 'false',
			'counter_note'					=> '',
			'counter_note_size'				=> 15,
			'counter_note_color'			=> '#000000',
			'counter_speed'					=> 2000,
			'counter_viewport'				=> 'true',
			
			'tooltip_html'					=> 'false',
			'tooltip_content'				=> '',
			'tooltip_encoded'				=> '',
			'tooltip_position'				=> 'ts-simptip-position-top',
			'tooltip_style'					=> '',
			'tooltipster_offsetx'			=> 0,
			'tooltipster_offsety'			=> 0,
			
			'animation_icon'				=> '',
			'margin_top'                	=> 0,
			'margin_bottom'             	=> 0,
			'el_id' 						=> '',
			'el_class'                  	=> '',
			'css'							=> '',
		), $atts ));
	
		if (!empty($el_id)) {
			$icon_counter_id			= $el_id;
		} else {
			$icon_counter_id			= 'ts-vcsc-icon-counter-' . mt_rand(999999, 9999999);
		}
		
		if (!empty($icon_image)) {
			$icon_image_path 			= wp_get_attachment_image_src($icon_image, 'large');
		}
		
		$icon_counter_animation			= "ts-viewport-css-" . $animation_icon;
		$icon_hover_animation			= "ts-hover-css-" . $animation_icon;
	
		if ($padding == "true") {
			$icon_frame_padding			= 'padding: ' . $icon_padding . 'px; ';
		} else {
			$icon_frame_padding			= '';
		}	
		
		$icon_style                     = '' . $icon_frame_padding . 'color: ' . $icon_color . '; background-color:' . $icon_background . '; width:' . $icon_size_slide . 'px; height:' . $icon_size_slide . 'px; font-size:' . $icon_size_slide . 'px; line-height:' . $icon_size_slide . 'px;';
		$icon_image_style				= '' . $icon_frame_padding . 'background-color:' . $icon_background . '; width: ' . $icon_size_slide . 'px; height: ' . $icon_size_slide . 'px; ';
	
		if ($icon_frame_type != '') {
			$icon_frame_class 	        = 'frame-enabled';
			$icon_frame_style 	        = 'border: ' . $icon_frame_thick . 'px ' . $icon_frame_type . ' ' . $icon_frame_color . ';';
		} else {
			$icon_frame_class			= '';
			$icon_frame_style			= '';
		}
		
		if ($counter_seperator == "true") {
			$icon_seperator				= ' seperator';
		} else {
			$icon_seperator				= '';
		}
		
		// Counter Link
		if ($link_counter != '') {
			$link 						= ($link_data=='||') ? '' : $link_data;
			$link 						= vc_build_link($link);
			$a_href						= $link['url'];
			$a_title 					= $link['title'];
			$a_target 					= $link['target'];
			$link_start					= '<a href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '" style="border: none; text-decoration: none;">';
			$link_end					= '</a>';
			$link_button				= '';			
			if ($link_counter == "flat") {
				wp_enqueue_style('ts-extend-buttonsdual');
				$button_style			= $link_buttonstyle . ' ' . $link_buttonhover;
				$link_button .= '<a class="ts-dual-buttons-wrapper" href="' . $a_href . '" target="' . $a_target . '" data-title="' . $a_title . '">';
					$link_button .= '<div class="ts-dual-buttons-container clearFixMe ' . $button_style . '" style="display: block; width: 100%; margin-top: 20px; margin-bottom: 20px;">';
						$link_button .= '<span class="ts-dual-buttons-title" style="font-size: ' . $link_buttonsize . 'px; line-height: ' . $link_buttonsize . 'px;">' . $link_buttontext . '</span>';			
					$link_button .= '</div>';
				$link_button .= '</a>';
			}
		} else {
			$link_start					= '';
			$link_end					= '';
			$link_button				= '';
		}
		
		// Number Formatting
		if ($counter_value_format == "true") {
			$format_value_plus			= $counter_value_plus;
			$format_value_seperator		= $counter_value_seperator;
		} else {
			$format_value_plus			= '';
			$format_value_seperator		= '';
		}
		
		// End Value as Shortcode
		if ($counter_value_by_shortcode == "true") {
			$counter_value_end			= rawurldecode(base64_decode(strip_tags($counter_value_end_shortcode)));
			$counter_value_end			= do_shortcode($counter_value_end);
			$counter_value_end			= (int)$counter_value_end;
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
		$icon_tooltipclasses					= 'ts-has-tooltipster-tooltip';		
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
		if ($tooltip_html == "false") {
			if (strlen($tooltip_content) != 0) {
				wp_enqueue_style('ts-extend-tooltipster');
				wp_enqueue_script('ts-extend-tooltipster');	
				$icon_tooltipclasses	= " ts-has-tooltipster-tooltip";
				$icon_tooltipcontent 	= 'data-tooltipster-html="false" data-tooltipster-title="" data-tooltipster-text="' . strip_tags($tooltip_content) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			} else {
				$icon_tooltipclasses	= "";
				$icon_tooltipcontent	= "";
			}
		} else {
			if (strlen($tooltip_encoded) != 0) {
				wp_enqueue_style('ts-extend-tooltipster');
				wp_enqueue_script('ts-extend-tooltipster');	
				$icon_tooltipclasses	= " ts-has-tooltipster-tooltip";
				$icon_tooltipcontent 	= 'data-tooltipster-html="true" data-tooltipster-title="" data-tooltipster-text="' . strip_tags($tooltip_encoded) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			} else {
				$icon_tooltipclasses	= "";
				$icon_tooltipcontent	= "";
			}
		}
		
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Icon-Counter', $atts);
		} else {
			$css_class	= '';
		}
		
		$output = '';
		
		if ($icon_position == 'top') {
			$output .= '<div id="' . $icon_counter_id . '" class="ts-icon-counter ' . $el_class . ' ts-counter-top ' . $icon_seperator . '' . $icon_tooltipclasses . ' ' . $css_class . '" ' . $icon_tooltipcontent . ' style="margiin-bottom: ' . $margin_bottom . 'px; margin-top: ' . $margin_top . 'px;">';
				if (($link_counter == 'element') && ($link_data != '')) {
					$output .= $link_start;
				}
					$output .= '<table class="ts-counter-icon-holder" border="0" style="border: none !important; border-color: transparent !important;">';
						$output .= '<tr>';
							$output .= '<td style="text-align: center;">';
								$output .= '<div class="ts-counter-icon-top">';
									if (($link_counter == 'icon') && ($link_data != '')) {
										$output .= $link_start;
									}
										if ($icon_replace == "false") {
											$output .= '<div class="ts-counter-icon">';
												$output .= '<i class="ts-font-icon ' . $icon . ' ' . $icon_frame_radius . ' ' . $icon_hover_animation . '" style="' . $icon_style . ' ' . $icon_frame_style . '"></i>';
											$output .= '</div>';
										} else {
											$output .= '<div class="ts-counter-image" style="' . $icon_image_style . ';">';
												$output .= '<img class="ts-font-icon ' . $icon_frame_radius . ' ' . $icon_hover_animation . '" src="' . $icon_image_path[0] .'">';
											$output .= '</div>';
										}
									if (($link_counter == 'icon') && ($link_data != '')) {
										$output .= $link_end;
									}
								$output .= '</div>';
							$output .= '</td>';
						$output .= '</tr>';
						$output .= '<tr>';
							$output .= '<td style="text-align: center;">';
								if (($link_counter == 'content') && ($link_data != '')) {
									$output .= $link_start;
								}
									$output .= '<div class="ts-counter-content">';
										$output .= '<div class="ts-counter-value" style="font-size: ' . $counter_value_size . 'px; color: ' . $counter_value_color . ';" data-viewport="' . $counter_viewport . '" data-before="' . $counter_value_before . '" data-after="' . $counter_value_after . '" data-format="' . $counter_value_format . '" data-seperator="' . $format_value_seperator . '" data-plus="' . $format_value_plus . '" data-animation="' . $icon_counter_animation . '" data-start="' . $counter_value_start . '" data-end="' . $counter_value_end . '" data-speed="' . $counter_speed . '">' . $counter_value_before . '' . $counter_value_start . '' . $counter_value_after . '</div>';
										$output .= '<div class="ts-counter-note" style="font-size: ' . $counter_note_size . 'px; color: ' . $counter_note_color . ';">' . $counter_note . '</div>';
									$output .= '</div>';
								if (($link_counter == 'content') && ($link_data != '')) {
									$output .= $link_end;
								}
							$output .= '</td>';
						$output .= '</tr>';
					$output .= '</table>';
					if ($link_counter == "flat") {
						$output .= $link_button;
					}
				if (($link_counter == 'element') && ($link_data != '')) {
					$output .= $link_end;
				}
			$output .= '</div>';
		} else if ($icon_position == 'left') {
			$output .= '<div id="' . $icon_counter_id . '" class="ts-icon-counter ' . $el_class . ' ts-counter-left ' . $icon_seperator . '' . $icon_tooltipclasses . ' ' . $css_class . '" ' . $icon_tooltipcontent . ' style="margiin-bottom: ' . $margin_bottom . 'px; margin-top: ' . $margin_top . 'px;">';
				if (($link_counter == 'element') && ($link_data != '')) {
					$output .= $link_start;
				}
					$output .= '<table class="ts-counter-icon-holder" border="0" style="border: none !important; border-color: transparent !important;">';
						$output .= '<tr>';
							$output .= '<td style="padding-right: 15px; text-align: left;">';
								$output .= '<div class="ts-counter-icon-left">';
									if (($link_counter == 'icon') && ($link_data != '')) {
										$output .= $link_start;
									}
										if ($icon_replace == "false") {
											$output .= '<div class="ts-counter-icon">';
												$output .= '<i class="ts-font-icon ' . $icon . ' ' . $icon_frame_radius . ' ' . $icon_hover_animation . '" style="' . $icon_style . ' ' . $icon_frame_style . '"></i>';
											$output .= '</div>';
										} else {
											$output .= '<div class="ts-counter-image" style="' . $icon_image_style . ';">';
												$output .= '<img class="ts-font-icon ' . $icon_frame_radius . ' ' . $icon_hover_animation . '" src="' . $icon_image_path[0] .'">';
											$output .= '</div>';
										}
									if (($link_counter == 'icon') && ($link_data != '')) {
										$output .= $link_end;
									}
								$output .= '</div>';
							$output .= '</td>';
							$output .= '<td>';
								if (($link_counter == 'content') && ($link_data != '')) {
									$output .= $link_start;
								}
									$output .= '<div class="ts-counter-content">';
										$output .= '<div class="ts-counter-value" style="font-size: ' . $counter_value_size . 'px; color: ' . $counter_value_color . ';" data-viewport="' . $counter_viewport . '" data-before="' . $counter_value_before . '" data-after="' . $counter_value_after . '" data-format="' . $counter_value_format . '" data-seperator="' . $format_value_seperator . '" data-plus="' . $format_value_plus . '" data-animation="' . $icon_counter_animation . '" data-start="' . $counter_value_start . '" data-end="' . $counter_value_end . '" data-speed="' . $counter_speed . '">' . $counter_value_before . '' . $counter_value_start . '' . $counter_value_after . '</div>';
										$output .= '<div class="ts-counter-note" style="font-size: ' . $counter_note_size . 'px; color: ' . $counter_note_color . ';">' . $counter_note . '</div>';
									$output .= '</div>';
								if (($link_counter == 'content') && ($link_data != '')) {
									$output .= $link_end;
								}
							$output .= '</td>';
						$output .= '</tr>';
					$output .= '</table>';
					if ($link_counter == "flat") {
						$output .= $link_button;
					}
				if (($link_counter == 'element') && ($link_data != '')) {
					$output .= $link_end;
				}
			$output .= '</div>';
		} else {
			$output .= '<div id="' . $icon_counter_id . '" class="ts-icon-counter ' . $el_class . ' ts-counter-right ' . $icon_seperator . '' . $icon_tooltipclasses . ' ' . $css_class . '" ' . $icon_tooltipcontent . ' style="margiin-bottom: ' . $margin_bottom . 'px; margin-top: ' . $margin_top . 'px;">';
				if (($link_counter == 'element') && ($link_data != '')) {
					$output .= $link_start;
				}
					$output .= '<table class="ts-counter-icon-holder" border="0" style="border: none !important; border-color: transparent !important;">';
						$output .= '<tr>';
							$output .= '<td style="padding-right: 15px; text-align: right;">';
								if (($link_counter == 'content') && ($link_data != '')) {
									$output .= $link_start;
								}
									$output .= '<div class="ts-counter-content">';
										$output .= '<div class="ts-counter-value" style="font-size: ' . $counter_value_size . 'px; color: ' . $counter_value_color . ';" data-viewport="' . $counter_viewport . '" data-before="' . $counter_value_before . '" data-after="' . $counter_value_after . '" data-format="' . $counter_value_format . '" data-seperator="' . $format_value_seperator . '" data-plus="' . $format_value_plus . '" data-animation="' . $icon_counter_animation . '" data-start="' . $counter_value_start . '" data-end="' . $counter_value_end . '" data-speed="' . $counter_speed . '">' . $counter_value_before . '' . $counter_value_start . '' . $counter_value_after . '</div>';
										$output .= '<div class="ts-counter-note" style="font-size: ' . $counter_note_size . 'px; color: ' . $counter_note_color . ';">' . $counter_note . '</div>';
									$output .= '</div>';
								if (($link_counter == 'content') && ($link_data != '')) {
									$output .= $link_end;
								}
							$output .= '</td>';
							$output .= '<td>';
								$output .= '<div class="ts-counter-icon-right">';
									if (($link_counter == 'icon') && ($link_data != '')) {
										$output .= $link_start;
									}
										if ($icon_replace == "false") {
											$output .= '<div class="ts-counter-icon">';
												$output .= '<i class="ts-font-icon ' . $icon . ' ' . $icon_frame_radius . ' ' . $icon_hover_animation . '" style="' . $icon_style . ' ' . $icon_frame_style . '"></i>';
											$output .= '</div>';
										} else {
											$output .= '<div class="ts-counter-image" style="' . $icon_image_style . '">';
												$output .= '<img class="ts-font-icon ' . $icon_frame_radius . ' ' . $icon_hover_animation . '" src="' . $icon_image_path[0] .'">';
											$output .= '</div>';
										}
									if (($link_counter == 'icon') && ($link_data != '')) {
										$output .= $link_end;
									}
								$output .= '</div>';
							$output .= '</td>';
						$output .= '</tr>';
					$output .= '</table>';
					if ($link_counter == "flat") {
						$output .= $link_button;
					}
				if (($link_counter == 'element') && ($link_data != '')) {
					$output .= $link_end;
				}
			$output .= '</div>';
		}
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>