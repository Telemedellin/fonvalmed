<?php
	add_shortcode('TS-VCSC-Icon-Title', 'TS_VCSC_Icon_Title_Function');
	function TS_VCSC_Icon_Title_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-extend-simptip');
		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'use_encode'				=> 'false',
			'title'						=> '',
			'title_encoded'				=> '',
			'color' 					=> '#3d3d3d',
			'transform'					=> 'none',
			'size' 						=> 30,
			'font_weight' 				=> 'normal',
			'align' 					=> 'left',
			'font_family' 				=> '',
			'font_type' 				=> '',
			// Highlight Settings
			'highlight_allow'			=> 'false',
			'highlight_match'			=> 'words',
			'highlight_strings'			=> '',
			'highlight_items'			=> '',
			'highlight_color'			=> '#2691BD',
			// Pretext Settings
			'pretext_allow'				=> 'false',
			'pretext_string'			=> '',
			'pretext_color'				=> '#dd0808',
			'pretext_size'				=> 40,
			'pretext_weight'			=> 'normal',
			// Global Settings
			'style' 					=> 'true',
			'title_wrap'				=> 'div',
			'title_background_type'		=> 'color',
			'title_background_color'	=> '',
			'title_background_pattern'	=> '',
			'title_border_controls'		=> 'false',
			'title_border_type'			=> '',
			'title_border_bottom'		=> 'false',
			'title_border_color'		=> '#cccccc',
			'title_border_thick'		=> 1,
			'title_border_radius'		=> '',
			'title_border_setting'		=> '',
			'icon_allow'				=> 'true',
			'icon'                      => '',
			'icon_location'             => 'left',
			'icon_margin'				=> 10,
			'icon_size_slide'           => 30,
			'icon_color'                => '#000000',
			'icon_background'		    => '',
			'icon_frame_type' 			=> '',
			'icon_frame_thick'			=> 1,
			'icon_frame_radius'			=> '',
			'icon_frame_color'			=> '#cccccc',
			'icon_replace'				=> 'false',
			'icon_image'				=> '',
			'icon_padding'				=> 0,
			'icon_spacing'				=> 0,
			'title_spacing'				=> 0,
			// Animation Settings
			'animations'                => 'false',
			'animation_icon'		    => '',
			'animation_title'           => '',
			'animation_shadow'          => '',
			'animation_view'            => '',
			// Other Settings
			'margin_bottom'				=> '20',
			'margin_top' 				=> '0',
			'el_id' 					=> '',
			'el_class'                  => '',
			'css'						=> '',
		), $atts ) );
		
		$divider_css = $title_background_style = $title_frame_style = $icon_style = $icon_frame_class = $icon_frame_style = $animation_css = '';
		
		if (!empty($el_id)) {
			$icon_title_id					= $el_id;
		} else {
			$icon_title_id					= 'ts-vcsc-icon-title-parent-' . mt_rand(999999, 9999999);
		}
		
		// Process Encoded Title
		if ($use_encode == "true") {
			$title_encoded					= rawurldecode(base64_decode(strip_tags($title_encoded)));
			$title_decoded					= strip_shortcodes($title_encoded);
			$title							= do_shortcode($title_encoded);
		} else {
			$title_decoded					= $title;
		}
		
		if (($icon_replace == "true") && (!empty($icon_image))) {
			$icon_image_path 				= wp_get_attachment_image_src($icon_image, 'large');
			$icon_offset					= "true";
		} else if (($icon_replace == "true") && (empty($icon_image))) {
			$icon_offset					= "false";
		} else if (($icon_replace == "false") && (!empty($icon))) {
			$icon_offset					= "true";
		} else if (($icon_replace == "false") && (empty($icon))) {
			$icon_offset					= "false";
		} else {
			$icon_offset					= "true";
		}
		
		$output 							= '';
		
		// Strikethrough Pattern	
		if ($style == "false") {
			$style							= 'simple';
		} else if ($style == "true") {
			$style							= 'pattern-dark';
		} else if ($style == "light") {
			$style							= 'pattern-light';
		}
		
		if (strpos($font_family, 'Default') === false) {
			$google_font 					= TS_VCSC_GetFontFamily($icon_title_id, $font_family, $font_type, false, true, false);
		} else {
			$google_font					= '';
		}
		
		if ($animations == "false") {
			$animation_icon		   	 		= '';
			$animation_title          	 	= '';
			$animation_shadow          		= '';
			$animation_view            		= '';
		}
		
		if ($animation_view != '') {
			$animation_css              	= TS_VCSC_GetCSSAnimation($animation_view);
		}
		
		// Title Pretext
		if ($pretext_allow == "true") {
			$title_pretext					= '<span class="ts-icon-title-pretext" style="color: ' . $pretext_color . '; font-weight: ' . $pretext_weight . '; font-size: ' . $pretext_size . 'px; line-height: ' . ($pretext_size * 1.1) . 'px;">' . $pretext_string . '</span>';
		} else {
			$title_pretext					= '';
		}
		$title_pretext						= trim($title_pretext);
		
		// Title Highlights
		if ($highlight_allow == "true") {
			$title_array					= preg_split('/\s+/', $title);
			$title_count					= 0;
			$highlight_strings				= rawurldecode(base64_decode(strip_tags($highlight_strings)));
			$highlight_strings				= str_replace(' ', '', $highlight_strings);
			$highlight_strings				= strtolower($highlight_strings);
			$title_strings					= explode(',', $highlight_strings);
			//$title_strings 				= array_map('strtolower', $title_strings);
			$highlight_items				= str_replace(' ', '', $highlight_items);
			$title_items					= explode(',', $highlight_items);
			$title_string					= '';
			foreach ($title_array as $value) {
				$title_count++;
				if ($highlight_match == "words") {
					if (in_array(strtolower($value), $title_strings)) {
						$title_string		= $title_string . ' <span class="ts-icon-title-highlight" style="color: ' . $highlight_color . ';">' . $value . '</span>';
					} else {
						$title_string		= $title_string . ' ' . $value;
					}
				} else if ($highlight_match == "items") {
					if (in_array($title_count, $title_items)) {
						$title_string		= $title_string . ' <span class="ts-icon-title-highlight" style="color: ' . $highlight_color . ';">' . $value . '</span>';
					} else {
						$title_string		= $title_string . ' ' . $value;
					}
				}
			}
		} else {
			$title_string					= $title;
		}
		$title_string						= trim($title_string);
		
		// Merge Pretext + Main Title
		if ($pretext_allow == "true") {
			$title_string					= $title_pretext . ' ' . $title_string;
		} else {
			$title_string					= $title_string;
		}
		
		// Title Transforms
		if ($transform != "none") {
			$title_capitalize				= 'ts-icon-title-' . $transform;
		} else {
			$title_capitalize				= '';
		}
		
		$icon_style                     	= 'padding: ' . $icon_padding . 'px; background-color:' . $icon_background . '; width: ' . $icon_size_slide . 'px; height: ' . $icon_size_slide . 'px; font-size: ' . $icon_size_slide . 'px; line-height: ' . $icon_size_slide . 'px;';
		$icon_image_style					= 'padding: ' . $icon_padding . 'px; background-color:' . $icon_background . '; width: ' . $icon_size_slide . 'px; height: ' . $icon_size_slide . 'px; ';

		if ($icon_frame_type != '') {
			$icon_frame_class 	        	= 'frame-enabled';
			$icon_frame_style 	        	= 'border: ' . $icon_frame_thick . 'px ' . $icon_frame_type . ' ' . $icon_frame_color . ';';
		}
		
		if ($title_background_type == "pattern") {
			$title_background_style			= 'background: url(' . $title_background_pattern . ') repeat;';
			$title_background_class			= 'ts-icon-title-background';
		} else if (($title_background_type == "color") && ($title_background_color != '')) {
			$title_background_style			= 'background-color: ' . $title_background_color .';';
			$title_background_class			= 'ts-icon-title-background';
		} else {
			$title_background_style			= '';
			$title_background_class			= '';
		}
		
		if ($title_border_controls == 'false') {
			if ($title_border_type != '') {
				if ($title_border_bottom == "true") {
					$title_frame_style			= '' . $title_background_style . ' border-bottom: ' . $title_border_thick . 'px ' . $title_border_type . ' ' . $title_border_color . '';
				} else {
					$title_frame_style			= '' . $title_background_style . ' border: ' . $title_border_thick . 'px ' . $title_border_type . ' ' . $title_border_color . '';
				}
			} else {
				$title_frame_style				= $title_background_style;
			}
		} else {
			$title_frame_style					= $title_background_style . str_replace('|', '', $title_border_setting);
		}

		$title_adjustment				= '';
		
		if (($animation_shadow != '') && (($title_background_type == "pattern") || (($title_background_type == "color") && ($title_background_color != '')))) {
			if (!empty($animation_title)) {
				$shadow_class 				= 'ts-css-shadow ' . $animation_shadow . '';
			} else {
				$shadow_class 				= 'ts-css-shadow ts-css-shadow-single ' . $animation_shadow . '';
			}
		} else {
			$shadow_class 					= '';
		}
		
		if (($icon_location == "top") || ($icon_location == "bottom")) {
			$padding_adjustment				= 'padding: 10px;';
			$border_adjustment				= '';
			$line_adjustment				= '';
			$line_height					= ($size * 1.1);
		} else {
			$padding_adjustment				= 'padding: 0px;';
			$border_adjustment				= '';
			if (($icon_size_slide + $icon_padding * 2) > $size) {
				$line_adjustment			= 'line-height: ' . (($icon_size_slide + $icon_padding * 2) * 1.1) . 'px;';
				$line_height				= (($icon_size_slide + $icon_padding * 2) * 1.1);
			} else {
				$line_adjustment			= 'line-height: ' . ($size * 1.1) . 'px;';
				$line_height				= ($size * 1.1);
			}
		}
		
		if ($icon_location == 'left') {
			$icon_alignment 				= 'float: left;';
			$icon_position					= 'position: absolute; left: ' . $icon_spacing . 'px; top: 50%; margin-top: -' . (($icon_size_slide + $icon_padding * 2) / 2) . 'px;';
			if ($icon_offset == "true") {
				if ($align == 'left') {
					$title_margin			= 'margin-left: ' . (($icon_size_slide + $icon_padding * 2) + $icon_margin + $title_spacing) . 'px;';
				} else if ($align == 'right') {
					$title_margin			= 'margin-left: ' . (($icon_size_slide + $icon_padding * 2) + $icon_margin) . 'px; margin-right: ' . $title_spacing . 'px;';
				} else {
					$title_margin			= 'margin-left: ' . (($icon_size_slide + $icon_padding * 2) + $icon_margin) . 'px;';
				}
			} else {
				$title_margin				= '';
			}
			$title_align					= $align;
		} else if ($icon_location == 'right') {
			$icon_alignment 				= 'float: right;';
			$icon_position					= 'position: absolute; right: ' . $icon_spacing . 'px; top: 50%; margin-top: -' . (($icon_size_slide + $icon_padding * 2) / 2) . 'px;';
			if ($icon_offset == "true") {
				if ($align == 'left') {
					$title_margin			= 'margin-right: ' . (($icon_size_slide + $icon_padding * 2) + $icon_margin) . 'px; margin-left: ' . $title_spacing . 'px;';
				} else if ($align == 'right') {
					$title_margin			= 'margin-right: ' . (($icon_size_slide + $icon_padding * 2) + $icon_margin + $title_spacing) . 'px;';
				} else {
					$title_margin			= 'margin-right: ' . (($icon_size_slide + $icon_padding * 2) + $icon_margin) . 'px;';
				}
			} else {
				$title_margin				= '';
			}
			$title_align					= $align;
		} else {
			$icon_alignment 				= '';
			$icon_position					= '';
			$title_margin					= '';
			$title_align					= 'center';
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-vcsc-icon-title-parent ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Icon-Title', $atts);
		} else {
			$css_class	= 'ts-vcsc-icon-title-parent';
		}
		
		$output .= '<div id="' . $icon_title_id . '" class="' . $css_class . ' ' . $animation_css . ' ' . $el_class . ' ' . $title_background_class . ' clearFixMe ' . $title_border_radius . '" style="height: 100%; margin-top:' . $margin_top . 'px; margin-bottom:' . $margin_bottom . 'px; ' . $google_font . '">';
		
			$output .= (!empty($animation_title) ? '<div class="ts-hover ' . $animation_title . '" style="height: 100%;">' : '');			
				if (($icon_location == "top") || ($icon_location == "bottom")) {
					$output .= '<div class="' . $shadow_class . ' ' . $title_background_class . '" style="height: 100%; ' . $title_background_style . '">';
				}				
					$output .= '<div style="height: 100%; ' . $border_adjustment . '; ' . $padding_adjustment . ' font-size: ' . $size . 'px; text-align: ' . $title_align . '; color: ' . $color . '; font-weight:' . $font_weight . '; ' . $divider_css . '" class="ts-vcsc-icon-title ts-shortcode ' . $title_border_radius . ' ts-icon-title ' . ($animation_title != "" ? $shadow_class : "") . ' ' . $style . '-style">';
						if ($icon_replace == 'false') {
							if ((!empty($icon)) && ($icon_location == "top")) {
								$output .= '<div style="width: 100%; display: block;">';
									$output .= '<i style="color:' . $icon_color . ';' . $icon_style . ' ' . $icon_frame_style . ' text-align: center; display: inline-block !important; margin-bottom: ' . $icon_margin . 'px;" class="ts-font-icon ts-title-icon-' . $icon_location . ' ' . $icon . ' ' . $icon_frame_class . ' ' . $animation_icon . ' ' . $icon_frame_radius . '"></i>';
								$output .= '</div>';
							}
						} else {
							if ((!empty($icon_image)) && ($icon_location == "top")) {
								$output .= '<div style="width: 100%; display: block;">';
									$output .= '<img class="ts-font-icon ts-title-icon-' . $icon_location . ' ' . $icon_frame_class . ' ' . $animation_icon . ' ' . $icon_frame_radius . '" src="' . $icon_image_path[0] . '" style="' . $icon_frame_style . ' ' . $icon_image_style . ' display: inline-block !important; margin-bottom: ' . $icon_margin . 'px;">';
								$output .= '</div>';
							}
						}					
						if ($icon_location == "left") {
							if ($icon_replace == 'false') {						
								$output .= '<div class="" style="width: 100%; ' . $line_adjustment . ' vertical-align: middle;">';
									$output .= '<div class="' . $shadow_class . '" style="">';
										$output .= '<div class="' . $style . '-style ' . $title_border_radius . '" style="' . $title_frame_style . '">';
											if ((!empty($icon)) && ($icon_location == "left")) {
												$output .= '<i style="' . $icon_position . ' color:' . $icon_color . ';' . $icon_style . ' ' . $icon_frame_style . ' display: inline-block !important; ' . $icon_alignment . '" class="ts-font-icon ts-title-icon-' . $icon_location . ' ' . $icon . ' ' . $icon_frame_class . ' ' . $animation_icon . ' ' . $icon_frame_radius . '"></i>';
											}
											$output .= '<div class="ts-icon-title-text ' . $title_capitalize . '" style="' . $title_margin . ' text-align: ' . $align . '; ' . $line_adjustment . ' font-size: ' . $size . 'px; ' . $title_adjustment . '">' . $title_string . '</div>';
										$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';							
							} else {
								$output .= '<div class="" style="width: 100%; ' . $line_adjustment . ' vertical-align: middle;">';
									$output .= '<div class="' . $shadow_class . '" style="">';
										$output .= '<div class="' . $style . '-style ' . $title_border_radius . '" style="' . $title_frame_style . '">';
											if ((!empty($icon_image)) && ($icon_location == "left")) {
												$output .= '<img style="' . $icon_position . ' ' . $icon_frame_style . ' ' . $icon_image_style . ' display: inline-block !important; ' . $icon_alignment . '" class="ts-font-icon ts-title-icon-' . $icon_location . ' ' . $icon_frame_class . ' ' . $animation_icon . ' ' . $icon_frame_radius . '" src="' . $icon_image_path[0] . '">';
											}
											$output .= '<div class="ts-icon-title-text ' . $title_capitalize . '" style="' . $title_margin . ' text-align: ' . $align . '; ' . $line_adjustment . ' font-size: ' . $size . 'px; ' . $title_adjustment . '">' . $title_string . '</div>';
										$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
							}
						} else if ($icon_location == "right") {
							if ($icon_replace == 'false') {
								$output .= '<div class="" style="width: 100%; ' . $line_adjustment . ' vertical-align: middle;">';
									$output .= '<div class="' . $shadow_class . '" style="">';
										$output .= '<div class="' . $style . '-style ' . $title_border_radius . '" style="' . $title_frame_style . '">';
											if ((!empty($icon)) && ($icon_location == "right")) {
												$output .= '<i style="' . $icon_position . ' color:' . $icon_color . ';' . $icon_style . ' ' . $icon_frame_style . ' display: inline-block !important; ' .$icon_alignment . '" class="ts-font-icon ts-title-icon-' . $icon_location . ' ' . $icon . ' ' . $icon_frame_class . ' ' . $animation_icon . ' ' . $icon_frame_radius . '"></i>';
											}
											$output .= '<div class="ts-icon-title-text ' . $title_capitalize . '" style="' . $title_margin . ' text-align: ' . $align . '; ' . $line_adjustment . ' font-size: ' . $size . 'px; ' . $title_adjustment . '">' . $title_string . '</div>';
										$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';							
							} else {
								$output .= '<div class="" style="width: 100%; ' . $line_adjustment . ' vertical-align: middle;">';
									$output .= '<div class="' . $shadow_class . '" style="">';
										$output .= '<div class="' . $style . '-style ' . $title_border_radius . '" style="' . $title_frame_style . '">';
											if ((!empty($icon_image)) && ($icon_location == "right")) {
												$output .= '<img style="' . $icon_position . ' ' . $icon_frame_style . ' ' . $icon_image_style . ' display: inline-block !important; ' .$icon_alignment . '" class="ts-font-icon ts-title-icon-' . $icon_location . ' ' . $icon_frame_class . ' ' . $animation_icon . ' ' . $icon_frame_radius . '" src="' . $icon_image_path[0] . '">';
											}
											$output .= '<div class="ts-icon-title-text ' . $title_capitalize . '" style="' . $title_margin . ' text-align: ' . $align . '; ' . $line_adjustment . ' font-size: ' . $size . 'px; ' . $title_adjustment . '">' . $title_string . '</div>';
										$output .= '</div>';
									$output .= '</div>';
								$output .= '</div>';
							}
						} else {
							$output .= '<div class="ts-icon-title-text ' . $title_capitalize . '" style="width: auto !important; text-align: center;">' . $title_string . '</div>';
						}					
						if ($icon_replace == 'false') {
							if ((!empty($icon)) && ($icon_location == "bottom")) {
								$output .= '<div style="width: 100%; display: block;">';
									$output .= '<i style="color:' . $icon_color . ';' . $icon_style . ' ' . $icon_frame_style . ' display: inline-block !important; margin-top: ' . $icon_margin . 'px;" class="ts-font-icon ts-title-icon-' . $icon_location . ' ' . $icon . ' ' . $icon_frame_class . ' ' . $animation_icon . ' ' . $icon_frame_radius . '"></i>';
								$output .= '</div>';
							}
						} else {
							if ((!empty($icon_image)) && ($icon_location == "bottom")) {
								$output .= '<div style="width: 100%; display: block;">';
									$output .= '<img class="ts-font-icon ts-title-icon-' . $icon_location . ' ' . $icon_frame_class . ' ' . $animation_icon . ' ' . $icon_frame_radius . '" src="' . $icon_image_path[0] . '" style="' . $icon_frame_style . ' ' . $icon_image_style . ' display: inline-block !important; margin-top: ' . $icon_margin . 'px;">';
								$output .= '</div>';
							}
						}					
					$output .= '</div>';				
				if (($icon_location == "top") || ($icon_location == "bottom")) {
					$output .= '</div>';
				}
			$output .= (!empty($animation_title) ? '</div></div>' : '</div>');		
		$output .= '<div class="clearboth"></div>';
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>