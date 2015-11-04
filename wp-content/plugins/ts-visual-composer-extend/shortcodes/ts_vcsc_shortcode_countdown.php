<?php
	add_shortcode('TS-VCSC-Countdown', 'TS_VCSC_Countdown_Function');
	add_shortcode('TS_VCSC_Countdown', 'TS_VCSC_Countdown_Function');
	function TS_VCSC_Countdown_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-extend-font-roboto');
		wp_enqueue_style('ts-extend-font-unica');
		wp_enqueue_style('ts-extend-countdown');
		wp_enqueue_script('ts-extend-countdown');
		wp_enqueue_script('ts-visual-composer-extend-front');
	
		extract( shortcode_atts( array(
			'style'							=> 'minimum',
			
			'counter_scope'					=> '1',
			'counter_interval'				=> '60',
			'counter_datetime'				=> '',
			'counter_date'					=> '',
			'counter_time'					=> '',
			'counter_zone'					=> 'false',
			'countup'						=> 'true',
			
			'shortcode_date'				=> '',
			'shortcode_datetime'			=> '',
			
			'reset_hours'					=> 0,
			'reset_minutes'					=> 15,
			'reset_seconds'					=> 0,
			'reset_restart'					=> 'true',
			'reset_link'					=> '',

			'date_zeros'					=> 'true',
			'date_days'						=> 'true',
			'date_hours'					=> 'true',
			'date_minutes'					=> 'true',
			'date_seconds'					=> 'true',
			
			'circle_width'					=> 5,
			
			'border_type'					=> '',
			'border_thick'					=> 1,
			'border_radius'					=> '',
			'border_color'					=> '#dddddd',
			
			'column_equal_width'			=> 'true',
			'column_background_color'		=> '#f7f7f7',
			'column_border_type'			=> '',
			'column_border_thick'			=> 1,
			'column_border_radius'			=> '',
			'column_border_color'			=> '#dddddd',
			
			'color_background_basic'		=> '#f7f7f7',
			'color_numbers_basic'			=> '#000000',
			'color_text_basic'				=> '#000000',
			
			'color_background_clock1'		=> '#000000',
			'color_numbers_clock1'			=> '#ffffff',
			
			'color_background_clock2'		=> '#000000',
			'color_numbers_clock2'			=> '#00deff',
			'color_dividers_clock2'			=> '#00deff',
			
			'color_background_bars'			=> '#ffc728',
			'color_numbers_bars'			=> '#ffffff',
			'color_text_bars'				=> '#a76500',
			'color_barback_bars'			=> '#a66600',
			'color_barfore_bars'			=> '#ffffff',
			
			'color_background_circles'		=> '#000000',
			'color_numbers_circles'			=> '#ffffff',
			'color_text_circles'			=> '#929292',
			'color_circleback_all'			=> '#282828',
			'color_circlefore_days'			=> '#117d8b',
			'color_circlefore_hours'		=> '#117d8b',
			'color_circlefore_minutes'		=> '#117d8b',
			'color_circlefore_seconds'		=> '#117d8b',
			
			'color_background_horizontal'	=> '#ffffff',
			'color_flippers_horizontal'		=> '#00bfa0',
			'color_numbers_horizontal'		=> '#ffffff',
			'color_text_horizontal'			=> '#929292',
			
			'color_background_flipboard'	=> '#ffffff',
			
			'margin_top'					=> 0,
			'margin_bottom'					=> 0,
			'el_id' 						=> '',
			'el_class' 						=> '',
			'css'							=> '',
		), $atts ));
	
		$countdown_randomizer				= mt_rand(999999, 9999999);
	
		if (!empty($el_id)) {
			$countdown_id					= $el_id;
		} else {
			$countdown_id					= 'ts-vcsc-countdown-' . $countdown_randomizer;
		}

		$output = '';

		// Link Values
		$reset_link 					= ($reset_link=='||') ? '' : $reset_link;
		$reset_link 					= vc_build_link($reset_link);
		$a_href							= $reset_link['url'];
		$a_title 						= $reset_link['title'];
		$a_target 						= $reset_link['target'];
		
		if ($style == "flipboard") {
			$date_zeros					= "true";
		}

		// Date Settings
		if ((!empty($counter_date)) && ($counter_scope == "1")) {
			$string_date				= strtotime($counter_date);
			$string_date_day			= date("j", $string_date);
			$string_date_month			= date("n", $string_date);
			$string_date_year			= date("Y", $string_date);
			$string_reset				= "false";
		} else if ((!empty($shortcode_date)) && ($counter_scope == "1S")) {
			$shortcode					= rawurldecode(base64_decode(strip_tags($shortcode_date)));
			$shortcode					= do_shortcode($shortcode);
			$string_date				= strtotime($shortcode);			
			$string_date_day			= date("j", $string_date);
			$string_date_month			= date("n", $string_date);
			$string_date_year			= date("Y", $string_date);
			$string_reset				= "false";
		} else if ((!empty($counter_datetime)) && ($counter_scope == "2")) {
			$string_date				= strtotime($counter_datetime);
			$string_date_day			= date("j", $string_date);
			$string_date_month			= date("n", $string_date);
			$string_date_year			= date("Y", $string_date);
			$string_reset				= "false";
		} else if ((!empty($shortcode_datetime)) && ($counter_scope == "2S")) {
			$shortcode					= rawurldecode(base64_decode(strip_tags($shortcode_datetime)));
			$shortcode					= do_shortcode($shortcode);
			$string_date				= strtotime($shortcode);
			$string_date_day			= date("j", $string_date);
			$string_date_month			= date("n", $string_date);
			$string_date_year			= date("Y", $string_date);
			$string_reset				= "false";
		} else if ($counter_scope == "4") {
			$string_date_day			= '';
			$string_date_month			= '';
			$string_date_year			= '';
			$string_reset				= "true";
		} else if (($counter_scope == "3") || ((empty($counter_date)) && (empty($counter_datetime)))) {
			$string_date				= strtotime(date('m/d/Y'));
			$string_date_day			= date("j", $string_date);
			$string_date_month			= date("n", $string_date);
			$string_date_year			= date("Y", $string_date);
			$string_reset				= "false";
		} else {
			$string_date_day			= '';
			$string_date_month			= '';
			$string_date_year			= '';
			$string_reset				= "false";
		}
		
		// Time Settings
		if ((!empty($counter_datetime)) && ($counter_scope == "2")) {
			$string_time				= strtotime($counter_datetime);
			$string_time_hour			= date("G", $string_time);
			$string_time_minute			= date("i", $string_time);
			$string_time_second			= date("s", $string_time);
			$string_repeat				= "false";
		} else if ((!empty($shortcode_datetime)) && ($counter_scope == "2S")) {
			$shortcode					= rawurldecode(base64_decode(strip_tags($shortcode_datetime)));
			$shortcode					= do_shortcode($shortcode);
			$string_time				= strtotime($shortcode);
			$string_time_hour			= date("G", $string_time);
			$string_time_minute			= date("i", $string_time);
			$string_time_second			= date("s", $string_time);
			$string_repeat				= "false";
		} else if ((!empty($counter_time)) && ($counter_scope == "3")) {
			$string_time				= strtotime($counter_time);
			$string_time_hour			= date("G", $string_time);
			$string_time_minute			= date("i", $string_time);
			$string_time_second			= date("s", $string_time);
			$string_repeat				= "true";
		} else {
			$string_time_hour			= '0';
			$string_time_minute			= '0';
			$string_time_second			= '0';
			$string_repeat				= "false";
		}
		
		// Pageload / Repeat CountUp
		if ($counter_scope == "5") {
			$string_pageload			= "true";
			$countup					= "true";
		} else {
			$string_pageload			= "false";
			if (($counter_scope == "3") || ($counter_scope == "4")) {
				$countup				= "false";
			} else {
				$countup				= $countup;
			}
		}
		if ($counter_scope == "4") {
			//$counter_zone				= "false";
		}

		// Countdown Border Settings
		if (!empty($border_type)) {
			$countdown_border			= 'border: ' . $border_thick . 'px ' . $border_type . ' ' . $border_color . ';';
		} else {
			$countdown_border			= '';
		}

		// Column Border Settings
		if ($style == "columns") {
			if (!empty($column_border_type)) {
				$column_border			= 'border: ' . $column_border_thick . 'px ' . $column_border_type . ' ' . $column_border_color . ';';
			} else {
				$column_border			= '';
			}
		}
		
		// Data Attribute Settings
		$countdown_data_main			= 'data-id="' . $countdown_randomizer . '" data-type="' . $style . '" data-zone="' . $counter_zone . '" data-countup="' . $countup . '" data-repeat="' . $string_repeat . '" data-pageload="' . $string_pageload . '" data-zeros="' . $date_zeros . '" data-show-days="' . $date_days . '" data-show-hours="' . $date_hours . '" data-show-minutes="' . $date_minutes . '" data-show-seconds="' . $date_seconds . '"';
		$countdown_data_date			= 'data-day="' . $string_date_day . '" data-month="' . $string_date_month . '" data-year="' . $string_date_year . '"';
		$countdown_data_time			= 'data-hour="' . $string_time_hour . '" data-minute="' . $string_time_minute . '" data-second="' . $string_time_second . '"';
		$countdown_data_reset			= 'data-resethours = "' . $reset_hours . '" data-resetminutes="' . $reset_minutes . '" data-resetseconds="' . $reset_seconds . '" data-resetlink="' . $a_href . '" data-resettarget="' . $a_target . '"';
		if ($style == "circles") {
			$countdown_data_color		= 'data-color-width="' . $circle_width . '" data-color-back="' . $color_circleback_all . '" data-color-days="' . $color_circlefore_days . '" data-color-hours="' . $color_circlefore_hours . '" data-color-minutes="' . $color_circlefore_minutes . '" data-color-seconds="' . $color_circlefore_seconds . '"';
		} else {
			$countdown_data_color		= '';
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Countdown', $atts);
		} else {
			$css_class	= '';
		}
		
		$output .= '<div id="' . $countdown_id . '-container" class="ts-vcsc-countdown-container">';
			// Create Countdown Output
			// Minimum Style (Style 0)
			if ($style == "minimum") {
				$output .= '<div id="' . $countdown_id . '" data-reset="' . $string_reset . '" data-resetrestart="' . $reset_restart . '" ' . $countdown_data_main . ' ' . $countdown_data_reset . ' ' . $countdown_data_date . ' ' . $countdown_data_time . ' ' . $countdown_data_color . ' class="ts-countdown-parent style-0 ' . $el_class . ' ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . '; background: ' . $color_background_basic . '; ' . $countdown_border . '">';
					$output .= '<div id="' . $countdown_id . '_countdown" class="ts-countdown" style="background: ' . $color_background_basic . ';">';
						if (($date_days == "true") && ($string_reset == "false")) {
							$output .= '<span class="ce-days" style="color: ' . $color_numbers_basic . ';"></span> <span class="ce-days-label" style="color: ' . $color_text_basic . ';"></span> ';
						}
						if ($date_hours == "true") {
							$output .= '<span class="ce-hours" style="color: ' . $color_numbers_basic . ';"></span> <span class="ce-hours-label" style="color: ' . $color_text_basic . ';"></span> ';
						}
						if ($date_minutes == "true") {
							$output .= '<span class="ce-minutes" style="color: ' . $color_numbers_basic . ';"></span> <span class="ce-minutes-label" style="color: ' . $color_text_basic . ';"></span> ';
						}
						if ($date_seconds == "true") {
							$output .= '<span class="ce-seconds" style="color: ' . $color_numbers_basic . ';"></span> <span class="ce-seconds-label" style="color: ' . $color_text_basic . ';"></span>';
						}
					$output .= '</div>';
					if ((!empty($a_href)) && ($counter_scope == "4")) {
						$output .= '<a id="' . $countdown_id . '_link" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '" style="display:none !important;">Countdown Link</a>';
					}
				$output .= '</div>';
			}
			// Basic Style with Columns (Style 1)
			if ($style == "columns") {
				$output .= '<div id="' . $countdown_id . '" data-reset="' . $string_reset . '" data-resetrestart="' . $reset_restart . '" data-equalize="' . $column_equal_width . '" ' . $countdown_data_main . ' ' . $countdown_data_reset . ' ' . $countdown_data_date . ' ' . $countdown_data_time . ' ' . $countdown_data_color . ' class="ts-countdown-parent style-1 ' . $el_class . ' ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . '; background: ' . $color_background_basic . '; ' . $countdown_border . '">';
					$output .= '<div id="' . $countdown_id . '_countdown" class="ts-countdown" style="background: ' . $color_background_basic . ';">';
						if (($date_days == "true") && ($string_reset == "false")) {
							$output .= '<div class="col ' . $column_border_radius . '" style="background: ' . $column_background_color . '; ' . $column_border . '"><span class="ce-days" style="color: ' . $color_numbers_basic . ';"></span> <span class="ce-days-label" style="color: ' . $color_text_basic . ';"></span></div>';
						}
						if ($date_hours == "true") {
							$output .= '<div class="col ' . $column_border_radius . '" style="background: ' . $column_background_color . '; ' . $column_border . '"><span class="ce-hours" style="color: ' . $color_numbers_basic . ';"></span> <span class="ce-hours-label" style="color: ' . $color_text_basic . ';"></span></div>';
						}
						if ($date_minutes == "true") {
							$output .= '<div class="col ' . $column_border_radius . '" style="background: ' . $column_background_color . '; ' . $column_border . '"><span class="ce-minutes" style="color: ' . $color_numbers_basic . ';"></span> <span class="ce-minutes-label" style="color: ' . $color_text_basic . ';"></span></div>';
						}
						if ($date_seconds == "true") {
							$output .= '<div class="col ' . $column_border_radius . '" style="background: ' . $column_background_color . '; ' . $column_border . '"><span class="ce-seconds" style="color: ' . $color_numbers_basic . ';"></span> <span class="ce-seconds-label" style="color: ' . $color_text_basic . ';"></span></div>';
						}
					$output .= '</div>';
					if ((!empty($a_href)) && ($counter_scope == "4")) {
						$output .= '<a id="' . $countdown_id . '_link" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '" style="display:none !important;">Countdown Link</a>';
					}
				$output .= '</div>';
			}
			// Bars Style (Style 2)
			if ($style == "bars") {
				$output .= '<div id="' . $countdown_id . '" data-reset="' . $string_reset . '" data-resetrestart="' . $reset_restart . '" ' . $countdown_data_main . ' ' . $countdown_data_date . ' ' . $countdown_data_reset . ' ' . $countdown_data_time . ' ' . $countdown_data_color . ' class="ts-countdown-parent style-2 ' . $el_class . ' ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . '; background: ' . $color_background_bars . '; ' . $countdown_border . '">';
					$output .= '<div id="' . $countdown_id . '_countdown" class="ts-countdown clearfix-float" style="background: ' . $color_background_bars . ';">';
						$output .= '<div class="info clearfix-float" style="">';
							if (($date_days == "true") && ($string_reset == "false")) {
								$output .= '<div style="width: 100%; display: inline-block;">';
									$output .= '<div id="bar-days_' . $countdown_randomizer . '" class="bar bar-days" style="background: ' . $color_barback_bars . ';"><div class="fill" style="background: ' . $color_barfore_bars . ';"></div></div> ';
									$output .= '<span id="ce-days_' . $countdown_randomizer . '" class="ce-days" style="color: ' . $color_numbers_bars . ';"></span> <span class="ce-days-label" style="color: ' . $color_text_bars . ';"></span>';
								$output .= '</div>';
							}
							if ($date_hours == "true") {
								$output .= '<div style="width: 100%; display: inline-block;">';
									$output .= '<div id="bar-hours_' . $countdown_randomizer . '" class="bar bar-hours" style="background: ' . $color_barback_bars . ';"><div class="fill" style="background: ' . $color_barfore_bars . ';"></div></div>';
									$output .= '<span id="ce-hours_' . $countdown_randomizer . '" class="ce-hours" style="color: ' . $color_numbers_bars . ';"></span> <span class="ce-hours-label" style="color: ' . $color_text_bars . ';"></span>';
								$output .= '</div>';
							}
							if ($date_minutes == "true") {
								$output .= '<div style="width: 100%; display: inline-block;">';
									$output .= '<div id="bar-minutes_' . $countdown_randomizer . '" class="bar bar-minutes" style="background: ' . $color_barback_bars . ';"><div class="fill" style="background: ' . $color_barfore_bars . ';"></div></div>';
									$output .= '<span id="ce-minutes_' . $countdown_randomizer . '" class="ce-minutes" style="color: ' . $color_numbers_bars . ';"></span> <span class="ce-minutes-label" style="color: ' . $color_text_bars . ';"></span>';
								$output .= '</div>';
							}
							if ($date_seconds == "true") {
								$output .= '<div style="width: 100%; display: inline-block;">';
									$output .= '<div id="bar-seconds_' . $countdown_randomizer . '" class="bar bar-seconds" style="background: ' . $color_barback_bars . ';"><div class="fill" style="background: ' . $color_barfore_bars . ';"></div></div>';
									$output .= '<span id="ce-seconds_' . $countdown_randomizer . '" class="ce-seconds" style="color: ' . $color_numbers_bars . ';"></span> <span class="ce-seconds-label" style="color: ' . $color_text_bars . ';"></span>';
								$output .= '</div>';
							}
						$output .= '</div>';
					$output .= '</div>';
					if ((!empty($a_href)) && ($counter_scope == "4")) {
						$output .= '<a id="' . $countdown_id . '_link" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '" style="display:none !important;">Countdown Link</a>';
					}
				$output .= '</div>';
			}
			// Digital Clock Style 1 (Style 3)
			if ($style == "clock1") {
				$output .= '<div id="' . $countdown_id . '" data-reset="' . $string_reset . '" data-resetrestart="' . $reset_restart . '" ' . $countdown_data_main . ' ' . $countdown_data_date . ' ' . $countdown_data_reset . ' ' . $countdown_data_time . ' ' . $countdown_data_color . ' class="ts-countdown-parent style-3 ' . $el_class . ' ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . '; background: ' . $color_background_clock1 . '; ' . $countdown_border . '">';
					$output .= '<div id="' . $countdown_id . '_countdown" class="ts-countdown" style="background: ' . $color_background_clock1 . ';">';
						if ($date_hours == "true") {
							$output .= '<span class="number ce-hours" style="color: ' . $color_numbers_clock1 . ';"></span>';
						}
						if ($date_minutes == "true") {
							$output .= '<span class="number ce-minutes" style="color: ' . $color_numbers_clock1 . ';"></span>';
						}
						if ($date_seconds == "true") {
							$output .= '<span class="number ce-seconds" style="color: ' . $color_numbers_clock1 . ';"></span>';
						}
					$output .= '</div>';
					if ((!empty($a_href)) && ($counter_scope == "4")) {
						$output .= '<a id="' . $countdown_id . '_link" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '" style="display:none !important;">Countdown Link</a>';
					}
				$output .= '</div>';
			}
			// Digital Clock Style 2 (Style 7)
			if ($style == "clock2") {
				$output .= '<div id="' . $countdown_id . '" data-reset="' . $string_reset . '" data-resetrestart="' . $reset_restart . '" ' . $countdown_data_main . ' ' . $countdown_data_date . ' ' . $countdown_data_reset . ' ' . $countdown_data_time . ' ' . $countdown_data_color . ' class="ts-countdown-parent style-7 ' . $el_class . ' ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . '; background: ' . $color_background_clock2 . '; ' . $countdown_border . '">';
					$output .= '<div id="' . $countdown_id . '_countdown" class="ts-countdown" style="background: ' . $color_background_clock2 . ';">';
						if ($date_hours == "true") {
							$output .= '<span class="number ce-hours" style="color: ' . $color_numbers_clock2 . ';"></span><span class="ce-separator" style="color: ' . $color_dividers_clock2 . ';">:</span>';
						}
						if ($date_minutes == "true") {
							$output .= '<span class="number ce-minutes" style="color: ' . $color_numbers_clock2 . ';"></span><span class="ce-separator" style="color: ' . $color_dividers_clock2 . ';">:</span>';
						}
						if ($date_seconds == "true") {
							$output .= '<span class="number ce-seconds" style="color: ' . $color_numbers_clock2 . ';"></span>';
						}
					$output .= '</div>';
					if ((!empty($a_href)) && ($counter_scope == "4")) {
						$output .= '<a id="' . $countdown_id . '_link" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '" style="display:none !important;">Countdown Link</a>';
					}
				$output .= '</div>';
			}
			// Circles Style (Style 9)
			if ($style == "circles") {
				$output .= '<div id="' . $countdown_id . '" data-reset="' . $string_reset . '" data-resetrestart="' . $reset_restart . '" ' . $countdown_data_main . ' ' . $countdown_data_date . ' ' . $countdown_data_reset . ' ' . $countdown_data_time . ' ' . $countdown_data_color . ' class="ts-countdown-parent style-9 ' . $el_class . ' ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . '; background: ' . $color_background_circles . '; ' . $countdown_border . '">';
					$output .= '<div id="' . $countdown_id . '_countdown" class="ts-countdown" style="background: ' . $color_background_circles . ';">';
						if (($date_days == "true") && ($string_reset == "false")) {
							$output .= '<div class="circle">';
								$output .= '<canvas id="days_' . $countdown_randomizer . '" width="300" height="300"></canvas>';
								$output .= '<div class="circle__values">';
									$output .= '<span class="ce-digit ce-days" style="color: ' . $color_numbers_circles . ';"></span>';
									$output .= '<span class="ce-label ce-days-label" style="color: ' . $color_text_circles . ';"></span>';
								$output .= '</div>';
							$output .= '</div>';
						}
						if ($date_hours == "true") {
							$output .= '<div class="circle">';
								$output .= '<canvas id="hours_' . $countdown_randomizer . '" width="300" height="300"></canvas>';
								$output .= '<div class="circle__values">';
									$output .= '<span class="ce-digit ce-hours" style="color: ' . $color_numbers_circles . ';"></span>';
									$output .= '<span class="ce-label ce-hours-label" style="color: ' . $color_text_circles . ';"></span>';
								$output .= '</div>';
							$output .= '</div>';
						}
						if ($date_minutes == "true") {
							$output .= '<div class="circle">';
								$output .= '<canvas id="minutes_' . $countdown_randomizer . '" width="300" height="300"></canvas>';
								$output .= '<div class="circle__values">';
									$output .= '<span class="ce-digit ce-minutes" style="color: ' . $color_numbers_circles . ';"></span>';
									$output .= '<span class="ce-label ce-minutes-label" style="color: ' . $color_text_circles . ';"></span>';
								$output .= '</div>';
							$output .= '</div>';
						}
						if ($date_seconds == "true") {
							$output .= '<div class="circle">';
								$output .= '<canvas id="seconds_' . $countdown_randomizer . '" width="300" height="300"></canvas>';
								$output .= '<div class="circle__values">';
									$output .= '<span class="ce-digit ce-seconds" style="color: ' . $color_numbers_circles . ';"></span>';
									$output .= '<span class="ce-label ce-seconds-label" style="color: ' . $color_text_circles . ';"></span>';
								$output .= '</div>';
							$output .= '</div>';
						}
					$output .= '</div>';
					if ((!empty($a_href)) && ($counter_scope == "4")) {
						$output .= '<a id="' . $countdown_id . '_link" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '" style="display:none !important;">Countdown Link</a>';
					}
				$output .= '</div>';
			}
			// 3D Horizontal Flip (Style 6)
			if ($style == "horizontal") {
				$output .= '<div id="' . $countdown_id . '" data-reset="' . $string_reset . '" data-resetrestart="' . $reset_restart . '" ' . $countdown_data_main . ' ' . $countdown_data_date . ' ' . $countdown_data_reset . ' ' . $countdown_data_time . ' ' . $countdown_data_color . ' class="ts-countdown-parent style-6 ' . $el_class . ' ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . '; background: ' . $color_background_horizontal . '; ' . $countdown_border . '">';
					$output .= '<div id="' . $countdown_id . '_countdown" class="ts-countdown" style="background: ' . $color_background_horizontal . ';">';
						if (($date_days == "true") && ($string_reset == "false")) {
							$output .= '<div class="col">';
								$output .= '<div class="ce-days" style="color: ' . $color_numbers_horizontal . ';">';
									$output .= '<div class="ce-flip-wrap">';
										$output .= '<div class="ce-flip-front" style="background: ' . $color_flippers_horizontal . ';"></div>';
										$output .= '<div class="ce-flip-back" style="background: ' . $color_flippers_horizontal . ';"></div>';
									$output .= '</div>';
								$output .= '</div>';
								$output .= '<span class="ce-days-label" style="color: ' . $color_text_horizontal . ';"></span>';
							$output .= '</div>';
						}
						if ($date_hours == "true") {
							$output .= '<div class="col">';
								$output .= '<div class="ce-hours" style="color: ' . $color_numbers_horizontal . ';">';
									$output .= '<div class="ce-flip-wrap">';
										$output .= '<div class="ce-flip-front" style="background: ' . $color_flippers_horizontal . ';"></div>';
										$output .= '<div class="ce-flip-back" style="background: ' . $color_flippers_horizontal . ';"></div>';
									$output .= '</div>';
								$output .= '</div>';
								$output .= '<span class="ce-hours-label" style="color: ' . $color_text_horizontal . ';"></span>';
							$output .= '</div>';
						}
						if ($date_minutes == "true") {
							$output .= '<div class="col">';
								$output .= '<div class="ce-minutes" style="color: ' . $color_numbers_horizontal . ';">';
									$output .= '<div class="ce-flip-wrap">';
										$output .= '<div class="ce-flip-front" style="background: ' . $color_flippers_horizontal . ';"></div>';
										$output .= '<div class="ce-flip-back" style="background: ' . $color_flippers_horizontal . ';"></div>';
									$output .= '</div>';
								$output .= '</div>';
								$output .= '<span class="ce-minutes-label" style="color: ' . $color_text_horizontal . ';"></span>';
							$output .= '</div>';
						}
						if ($date_seconds == "true") {
							$output .= '<div class="col">';
								$output .= '<div class="ce-seconds" style="color: ' . $color_numbers_horizontal . ';">';
									$output .= '<div class="ce-flip-wrap">';
										$output .= '<div class="ce-flip-front" style="background: ' . $color_flippers_horizontal . ';"></div>';
										$output .= '<div class="ce-flip-back" style="background: ' . $color_flippers_horizontal . ';"></div>';
									$output .= '</div>';
								$output .= '</div>';
								$output .= '<span class="ce-seconds-label" style="color: ' . $color_text_horizontal . ';"></span>';
							$output .= '</div>';
						}
					$output .= '</div>';
					if ((!empty($a_href)) && ($counter_scope == "4")) {
						$output .= '<a id="' . $countdown_id . '_link" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '" style="display:none !important;">Countdown Link</a>';
					}
				$output .= '</div>';
			}
			// Flipboard Style (Style 10)
			if ($style == "flipboard") {
				$output .= '<div id="' . $countdown_id . '" data-reset="' . $string_reset . '" data-resetrestart="' . $reset_restart . '" ' . $countdown_data_main . ' ' . $countdown_data_date . ' ' . $countdown_data_reset . ' ' . $countdown_data_time . ' ' . $countdown_data_color . ' class="ts-countdown-parent style-10 ' . $el_class . ' ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . '; background: ' . $color_background_flipboard . '; ' . $countdown_border . '">';
					$output .= '<div id="' . $countdown_id . '_countdown" class="ts-countdown" style="background: ' . $color_background_flipboard . ';">';
						if (($date_days == "true") && ($string_reset == "false")) {
							$output .= '<div class="unit-wrap">';
								$output .= '<div class="days"></div>';
								$output .= '<span class="ce-days-label"></span>';
							$output .= '</div>';
						}
						if ($date_hours == "true") {
							$output .= '<div class="unit-wrap">';
								$output .= '<div class="hours"></div>';
								$output .= '<span class="ce-hours-label"></span>';
							$output .= '</div>';
						}
						if ($date_minutes == "true") {
							$output .= '<div class="unit-wrap">';
								$output .= '<div class="minutes"></div>';
								$output .= '<span class="ce-minutes-label"></span>';
							$output .= '</div>';
						}
						if ($date_seconds == "true") {
							$output .= '<div class="unit-wrap">';
								$output .= '<div class="seconds"></div>';
								$output .= '<span class="ce-seconds-label"></span>';
							$output .= '</div>';
						}
					$output .= '</div>';
					if ((!empty($a_href)) && ($counter_scope == "4")) {
						$output .= '<a id="' . $countdown_id . '_link" href="' . $a_href . '" target="' . trim($a_target) . '" title="' . $a_title . '" style="display:none !important;">Countdown Link</a>';
					}
				$output .= '</div>';
			}
			
			// Language Settings for Countdown
			$TS_VCSC_Countdown_Language			= get_option('ts_vcsc_extend_settings_translationsCountdown', '');
			if (($TS_VCSC_Countdown_Language == false) || (empty($TS_VCSC_Countdown_Language))) {
				$TS_VCSC_Countdown_Language		= $this->TS_VCSC_Countdown_Language_Defaults;
			}
			$output .= '<script type="text/javascript">';
				$output .= 'var $TS_VCSC_Countdown_DaysLabel 		= "' . $TS_VCSC_Countdown_Language['DayPlural'] 		. '";';
				$output .= 'var $TS_VCSC_Countdown_DayLabel 		= "' . $TS_VCSC_Countdown_Language['DaySingular'] 		. '";';
				$output .= 'var $TS_VCSC_Countdown_HoursLabel 		= "' . $TS_VCSC_Countdown_Language['HourPlural'] 		. '";';
				$output .= 'var $TS_VCSC_Countdown_HourLabel 		= "' . $TS_VCSC_Countdown_Language['HourSingular'] 		. '";';
				$output .= 'var $TS_VCSC_Countdown_MinutesLabel 	= "' . $TS_VCSC_Countdown_Language['MinutePlural'] 		. '";';
				$output .= 'var $TS_VCSC_Countdown_MinuteLabel 		= "' . $TS_VCSC_Countdown_Language['MinuteSingular'] 	. '";';
				$output .= 'var $TS_VCSC_Countdown_SecondsLabel 	= "' . $TS_VCSC_Countdown_Language['SecondPlural'] 		. '";';
				$output .= 'var $TS_VCSC_Countdown_SecondLabel		= "' . $TS_VCSC_Countdown_Language['SecondSingular'] 	. '";';
			$output .= '</script>';
		$output .= '</div>';
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_Countdown extends WPBakeryShortCode {};
	}
?>