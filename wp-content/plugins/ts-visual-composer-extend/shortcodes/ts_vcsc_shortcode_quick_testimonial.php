<?php
	add_shortcode('TS_VCSC_Quick_Testimonial', 'TS_VCSC_Quick_Testimonial_Function');
	function TS_VCSC_Quick_Testimonial_Function ($atts, $content = null) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-visual-composer-extend-front');
	
		extract( shortcode_atts( array(
			'avatar'						=> '',
			'author'						=> '',
			'position'						=> '',
			'style'							=> 'style1',
			'show_author'					=> 'true',
			'show_avatar'					=> 'true',
			'margin_top'                    => 0,
			'margin_bottom'                 => 0,
			'el_id'                         => '',
			'el_class'                      => '',
			'css'							=> '',
		), $atts ));
		
		$output 							= '';
		
		if (!empty($el_id)) {
			$testimonial_block_id			= $el_id;
		} else {
			$testimonial_block_id			= 'ts-vcsc-quick-testimonial-' . mt_rand(999999, 9999999);
		}
		
		if ($avatar != '') {
			$testimonial_avatar          	= wp_get_attachment_image_src($avatar, 'full');
			$testimonial_avatar				= $testimonial_avatar[0];
		} else {
			$testimonial_avatar          	= TS_VCSC_GetResourceURL('images/defaults/default_person.jpg');
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-testimonial-main clearFixMe ' . $style . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Quick_Testimonial', $atts);
		} else {
			$css_class	= 'ts-testimonial-main clearFixMe ' . $style . ' ' . $el_class;
		}
		
		if ($style == "style1") {
			$output .= '<div id="' . $testimonial_block_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
				$output .= '<div class="ts-testimonial-content">';
					if (($show_avatar == "true") || ($show_author == "true")) {
						$output .= '<span class="ts-testimonial-arrow"></span>';
					}
					if (function_exists('wpb_js_remove_wpautop')){
						$output .= '' . wpb_js_remove_wpautop(do_shortcode($content), true) . '';
					} else {
						$output .= '' . do_shortcode($content) . '';
					}
				$output .= '</div>';
				if (($show_avatar == "true") || ($show_author == "true")) {
					$output .= '<div class="ts-testimonial-user">';
						if ($show_avatar == "true") {
							$output .= '<div class="ts-testimonial-user-thumb"><img src="' . $testimonial_avatar . '" alt=""></div>';
						}
						if ($show_author == "true") {
							$output .= '<div class="ts-testimonial-user-name">' . $author . '</div>';
							$output .= '<div class="ts-testimonial-user-meta">' . $position . '</div>';
						}
					$output .= '</div>';
				}
			$output .= '</div>';
		}
		if ($style == "style2") {
			$output .= '<div id="' . $testimonial_block_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
				$output .= '<div class="blockquote">';
					$output .= '<span class="leftq quotes"></span>';
						if (function_exists('wpb_js_remove_wpautop')){
							$output .= '' . wpb_js_remove_wpautop(do_shortcode($content), true) . '';
						} else {
							$output .= '' . do_shortcode($content) . '';
						}
					$output .= '<span class="rightq quotes"></span>';
				$output .= '</div>';
				if (($show_avatar == "true") || ($show_author == "true")) {
					$output .= '<div class="information">';
						if ($show_avatar == "true") {
							$output .= '<img src="' . $testimonial_avatar . '" style="width: 150px; height: auto; " width="150" height="auto" />';
						}
						if ($show_author == "true") {
							$output .= '<div class="author" style="' . ($show_avatar == "false" ? "margin-left: 15px;" : "") . '">' . $author . '</div>';
							$output .= '<div class="metadata">' . $position . '</div>';
						}
					$output .= '</div>';
				}
			$output .= '</div>';
		}
		if ($style == "style3") {
			$output .= '<div id="' . $testimonial_block_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
				if ($show_avatar == "true") {
					$output .= '<div class="photo">';
						$output .= '<img src="' . $testimonial_avatar . '" alt=""/>';
					$output .= '</div>';
				}
				$output .= '<div class="content" style="' . ($show_avatar == "false" ? "margin-left: 0;" : "") . '">';
					$output .= '<span class="laquo"></span>';
						if (function_exists('wpb_js_remove_wpautop')){
							$output .= '' . wpb_js_remove_wpautop(do_shortcode($content), true) . '';
						} else {
							$output .= '' . do_shortcode($content) . '';
						}
					$output .= '<span class="raquo"></span>';
				$output .= '</div>';
				if ($show_author == "true") {
					$output .= '<div class="sign">';
						$output .= '<span class="author">' . $author . '</span>';
						$output .= '<span class="metadata">' . $position . '</span>';
					$output .= '</div>';
				}
			$output .= '</div>';
		}
		if ($style == "style4") {
			$output .= '<div id="' . $testimonial_block_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . ($margin_bottom + 32) . 'px;">';
				if (($show_avatar == "true") || ($show_author == "true")) {
					$output .= '<div class="ts-testimonial-author-info clearfix">';
						if ($show_avatar == "true") {
							$output .= '<div class="ts-testimonial-author-image">';
								$output .= '<img src="' . $testimonial_avatar . '" alt="">';
								$output .= '<span class="ts-testimonial-author-overlay"></span>';
							$output .= '</div>';
						}
						if ($show_author == "true") {
							$output .= '<span class="ts-testimonial-author-name">' . $author . '</span>';
							$output .= '<span class="ts-testimonial-author-position">' . $position . '</span>';
						}
					$output .= '</div>';
				}
				$output .= '<div class="ts-testimonial-statement clearfix">';
					if (function_exists('wpb_js_remove_wpautop')){
						$output .= '' . wpb_js_remove_wpautop(do_shortcode($content), true) . '';
					} else {
						$output .= '' . do_shortcode($content) . '';
					}
				$output .= '</div>';			
				$output .= '<div class="ts-testimonial-bottom-arrow"></div>';
			$output .= '</div>';
		}

		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>