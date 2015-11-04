<?php
	add_shortcode('TS_VCSC_Quick_Skills', 'TS_VCSC_Quick_Skills_Function');
	function TS_VCSC_Quick_Skills_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

        wp_enqueue_style('ts-visual-composer-extend-front');
        wp_enqueue_script('ts-visual-composer-extend-front');
	
		extract( shortcode_atts( array(
			'skill_values'			=> '',
			'skill_layout'			=> 'bars',
			// Bar Layout Settings
			'bar_style'				=> 'style1',
			'bar_tooltip'			=> 'false',
			'bar_height'            => 2,
			'bar_height_2'			=> 35,
			'bar_height_3'			=> 40,
			'bar_label_width'		=> 110,
			'bar_stripes'           => 'false',
			'bar_animation'         => 'false',
			'bar_delay'				=> 250,
			'tooltip_style'			=> '',
			// Raphael Layout Settings
			'circle_custom'			=> 'false',
			'circle_color' 			=> '#ffffff',
			'text_default' 			=> '',
			'text_color' 			=> '#000000',
			'text_size'				=> 16,
			'max_stroke'			=> 40,
			'space_stroke'			=> 2,
			'random_start'			=> 'true',
			// Other Settings
			'animation_view'		=> '',
			'margin_top'			=> 0,
			'margin_bottom'			=> 0,
			'el_id' 				=> '',
			'el_class'              => '',
			'css'					=> '',
		), $atts ));
		
		// Process Group Values		
		if (isset($skill_values) && strlen($skill_values) > 0 ) {			
			$skill_entries 			= json_decode(urldecode($skill_values), true);
			if (!is_array($skill_entries)) {
				$temp 				= explode(',', $skill_values);
				$paramValues 		= array();
				foreach ($temp as $value) {
					$data 			= explode( '|', $value );
					$colorIndex 	= 2;
					$newLine 		= array();
					$newLine['skillvalue'] 		= isset($data[0]) ? $data[0] : 0;
					$newLine['skillname'] 		= isset($data[1]) ? $data[1] : '';
					if (isset($data[1]) && preg_match('/^\d{1,3}\%$/', $data[1])) {
						$colorIndex += 1;
						$newLine['skillvalue'] 	= (float) str_replace('%', '', $data[1]);
						$newLine['skillname'] 	= isset($data[2]) ? $data[2] : '';
					}
					if (isset($data[ $colorIndex])) {
						$newLine['skillcolor'] 	= $data[$colorIndex];
					}
					$paramValues[] 	= $newLine;
				}
				$skill_values 		= urlencode(json_encode($paramValues));
			}
		}
		
        $output                             = '';
        $bar_classes                        = '';
		
		// Check for Skillset and End Shortcode if Empty
		if (empty($skill_entries)) {
			$output .= '<div style="text-align: justify; font-weight: bold; font-size: 14px; color: red;">Please define at least one skillset in the element settings!</div>';
			echo $output;
			$myvariable = ob_get_clean();
			return $myvariable;
		}

		if ($bar_stripes == "true") {
			$bar_classes                    .= ' striped';
			if ($bar_animation == "true") {
				$bar_classes                .= ' animated';
			}
		}
	
		if (!empty($el_id)) {
			$skill_block_id					= $el_id;
		} else {
			$skill_block_id					= 'ts-vcsc-skillset-' . mt_rand(999999, 9999999);
		}
	
		if ($animation_view != '') {
			$animation_css              	= TS_VCSC_GetCSSAnimation($animation_view);
		} else {
			$animation_css					= '';
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			if ($skill_layout == "bars") {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-post-skills ' . $animation_css . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Quick_Skills', $atts);
			} else if ($skill_layout == "raphael") {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-skillset-raphael-container ' . $animation_css . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Quick_Skills', $atts);
			}
		} else {
			if ($skill_layout == "bars") {
				$css_class	= 'ts-post-skills ' . $animation_css . ' ' . $el_class;
			} else if ($skill_layout == "raphael") {
				$css_class	= 'ts-skillset-raphael-container ' . $animation_css . ' ' . $el_class;
			}
		}
		
		// Build Skillset
		$team_skills 		= '';
		$team_skills_count	= 0;
		if ($skill_layout == "bars") {
			if ($bar_style == "style1") {
				$skill_background 	= '';
				$team_skills		.= '<div id="' . $skill_block_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
					foreach ((array) $skill_entries as $key => $entry) {
						$skill_name = $skill_value = $skill_color = '';
						if (isset($entry['skillname'])) {
							$skill_name      = esc_html($entry['skillname']);
						}
						if (isset($entry['skillvalue'])) {
							$skill_value     = esc_html($entry['skillvalue']);
						}
						if (isset($entry['skillcolor'])) {
							$skill_color     = esc_html($entry['skillcolor']);
						}
						if ((strlen($skill_name) != 0) && (strlen($skill_value) != 0)) {
							$team_skills_count++;
							if ((strlen($skill_color) != 0) && ($skill_color != '#')) {
								$skill_background = 'background-color: ' . $skill_color . ';';
							} else {
								$skill_background = 'background-color: #00afd1;';
							}
							if ($bar_tooltip == "true") {
								$line_height		= 'line-height: 25px;';	
							} else {
								$line_height		= '';
							}
							$team_skills .= '<div class="ts-skillbars-style1-wrapper clearfix">';
								$team_skills .= '<div class="ts-skillbars-style1-name" style="' . $line_height . '">' . $skill_name . '';
									if ($bar_tooltip == "false") {
										$team_skills .= '<span>(' . $skill_value . '%)</span>';
									}
								$team_skills .= '</div>';
								$team_skills .= '<div class="ts-skillbars-style1-skillbar" style="height: ' . $bar_height . 'px;">';
									$team_skills .= '<div class="ts-skillbars-style1-value' . $bar_classes . '" data-color="' . $skill_color . '" data-level="' . $skill_value . '%" style="width: ' . $skill_value . '%; ' . $skill_background . '">';
										if ($bar_tooltip == "true") {
											$team_skills .= '<span class="ts-skillbars-style1-tooltip">' . $skill_value . '%</span>';
										}
									$team_skills .= '</div>';
								$team_skills .= '</div>';
							$team_skills .= '</div>';
						}
					}
				$team_skills		.= '</div>';
			}
			if ($bar_style == "style2") {
				$skill_background 	= '';
				$team_skills		.= '<div id="' . $skill_block_id . '" class="' . $css_class . ' progress-bars">';
					foreach ((array) $skill_entries as $key => $entry) {
						$skill_name = $skill_value = $skill_color = '';
						if (isset($entry['skillname'])) {
							$skill_name      = esc_html($entry['skillname']);
						}
						if (isset($entry['skillvalue'])) {
							$skill_value     = esc_html($entry['skillvalue']);
						}
						if (isset($entry['skillcolor'])) {
							$skill_color     = esc_html($entry['skillcolor']);
						}
						if ((strlen($skill_name) != 0) && (strlen($skill_value) != 0)) {
							$team_skills_count++;
							if ((strlen($skill_color) != 0) && ($skill_color != '#')) {
								$skill_background = 'background-color: ' . $skill_color . ';';
							} else {
								$skill_background = 'background-color: #00afd1;';
							}					
							if (($team_skills_count == 1) && ($bar_tooltip == "true")) {
								$margin_adjust	= 'margin-top: 30px;';
							} else if ($bar_tooltip == "true") {
								$margin_adjust	= 'margin-top: 20px;';
							} else {
								$margin_adjust	= '';
							}
							$team_skills .= '<div class="ts-skillbars-style2-wrapper clearfix" style="height: ' . $bar_height_2 . 'px; ' . $margin_adjust . '">';
								$team_skills .= '<div class="ts-skillbars-style2-title" style="height: ' . $bar_height_2 . 'px; width: ' . $bar_label_width . 'px;' . $skill_background . '"><span style="line-height: ' . $bar_height_2 . 'px; height: ' . $bar_height_2 . 'px;">' . $skill_name . '</span></div>';
								$team_skills .= '<div class="ts-skillbars-style2-area" style="">';
									$team_skills .= '<div class="ts-skillbars-style2-skillbar' . $bar_classes . '" style="width: ' . $skill_value . '%; height: ' . $bar_height_2 . 'px; ' . $skill_background . '" data-level="' . $skill_value . '">';
										if ($bar_tooltip == "true") {
											$team_skills .= '<span class="ts-skillbars-style2-tooltip">' . $skill_value . '%</span>';
										}
									$team_skills .= '</div>';
								$team_skills .= '</div>';
								if ($bar_tooltip == "false") {
									$team_skills .= '<div class="ts-skillbars-style2-percent" style="line-height: ' . $bar_height_2 . 'px; height: ' . $bar_height_2 . 'px;">' . $skill_value . '%</div>';
								}
							$team_skills .= '</div>';
						}
					}
				$team_skills		.= '</div>';
			}
			if ($bar_style == "style3") {
				$skill_background 	= '';
				$team_skills		.= '<div id="' . $skill_block_id . '" class="' . $css_class . ' progress-bars">';
					foreach ((array) $skill_entries as $key => $entry) {
						$skill_name = $skill_value = $skill_color = '';
						if (isset($entry['skillname'])) {
							$skill_name      = esc_html($entry['skillname']);
						}
						if (isset($entry['skillvalue'])) {
							$skill_value     = esc_html($entry['skillvalue']);
						}
						if (isset($entry['skillcolor'])) {
							$skill_color     = esc_html($entry['skillcolor']);
						}
						if ((strlen($skill_name) != 0) && (strlen($skill_value) != 0)) {
							$team_skills_count++;
							if ((strlen($skill_color) != 0) && ($skill_color != '#')) {
								$skill_background = 'background-color: ' . $skill_color . ';';
							} else {
								$skill_background = 'background-color: #00afd1;';
							}					
							if (($team_skills_count == 1) && ($bar_tooltip == "true")) {
								$margin_adjust	= 'margin-top: 30px;';
							} else if ($bar_tooltip == "true") {
								$margin_adjust	= 'margin-top: 20px;';
							} else {
								$margin_adjust	= '';
							}
							$team_skills .= '<div class="ts-skillbars-style3-wrapper clearfix" style="height: ' . $bar_height_3 . 'px;">';
								$team_skills .= '<div class="ts-skillbars-style3-skillbar" style="height: ' . $bar_height_3 . 'px;">';
									$team_skills .= '<div class="ts-skillbars-style3-countbar' . $bar_classes . '" data-level="' . $skill_value . '" style="height: ' . $bar_height_3 . 'px; width: ' . $skill_value . '%; ' . $skill_background . '">';
										$team_skills .= '<div class="ts-skillbars-style3-title" style="line-height: ' . ($bar_height_3 - 10) . 'px;">' . $skill_name . '</div>';
										if ($bar_tooltip == "true") {
											$team_skills .= '<span class="ts-skillbars-style3-tooltip">' . $skill_value . '%</span>';
										} else {
											$team_skills .= '<div class="ts-skillbars-style3-value style="line-height: ' . ($bar_height_3 - 10) . 'px;""><span>' . $skill_value . '%</span></div>';
										}
										$team_skills .= '<div class="ts-skillbars-style3-indicator"></div>';
									$team_skills .= '</div>';
								$team_skills .= '</div>';
							$team_skills .= '</div>';	
						}
					}
				$team_skills		.= '</div>';
			}
		} else if ($skill_layout == "raphael") {
			wp_enqueue_script('ts-extend-raphael');
			$skill_background 	= '';
			$team_skills		.= '<div id="' . $skill_block_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
				foreach ((array) $skill_entries as $key => $entry) {
					$skill_name = $skill_value = $skill_color = '';
					if (isset($entry['skillname'])) {
						$skill_name      = esc_html($entry['skillname']);
					}
					if (isset($entry['skillvalue'])) {
						$skill_value     = esc_html($entry['skillvalue']);
					}
					if (isset($entry['skillcolor'])) {
						$skill_color     = esc_html($entry['skillcolor']);
					}
					if ((strlen($skill_name) != 0) && (strlen($skill_value) != 0)) {
						$team_skills_count++;
						$team_skills .= '<div class="ts-skillset-raphael-arch">
							<input type="hidden" class="name" value="' . $skill_name . '" />
							<input type="hidden" class="percent" value="' . $skill_value . '" />
							<input type="hidden" class="color" value="' . $skill_color . '" />
						</div>';					
					}
				}
				$team_skills .= '<div id="" class="ts-skillset-raphael-chart" data-raphael="' . $skill_block_id . '" data-randomstart="' . $random_start . '" data-spacestroke="' . $space_stroke . '" data-maxstroke="' . $max_stroke . '" data-circlecustom="' . $circle_custom . '" data-circlecolor="' . $circle_color . '" data-textsize="' . $text_size . '" data-textcolor="' . $text_color . '" data-textdefault="' . $text_default . '"></div>';
			$team_skills		.= '</div>';
		}

		// Create Output
		$output = $team_skills;
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>