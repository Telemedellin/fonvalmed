<?php
	add_shortcode('TS_VCSC_Icon_Button', 'TS_VCSC_Icon_Button_Function');
	function TS_VCSC_Icon_Button_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-extend-buttons');
		wp_enqueue_style('ts-extend-simptip');
		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
	
		extract( shortcode_atts( array(
			'link'						=> '',
			'tooltip_css'				=> 'false',
			'tooltip_position'			=> 'ts-simptip-position-top',
			'tooltip_style'				=> '',
			
			'button_align'				=> 'center',
			'button_width'				=> 100,
			'button_type'				=> 'square',
			'button_square'				=> 'ts-button-3d',
			'button_rounded'			=> 'ts-button-3d ts-button-rounded',
			'button_pill'				=> 'ts-button-3d ts-button-pill',
			'button_circle'				=> 'ts-button-3d ts-button-circle',
			'button_size'				=> '',
			'button_wrapper'			=> 'false',
			'button_text'				=> 'Read More',
			'button_change'				=> 'false',
			'button_color'				=> '#666666',
			'button_font'				=> 18,
			
			'icon'						=> '',
			'icon_change'				=> 'false',
			'icon_color'				=> '#666666',

			'margin_top'				=> 20,
			'margin_bottom'				=> 20,
			'el_id' 					=> '',
			'el_class' 					=> '',
			'css'						=> '',
		), $atts ));

		// ID
		if (!empty($el_id)) {
			$button_id					= $el_id;
		} else {
			$button_id					= 'ts-vcsc-button-' . mt_rand(999999, 9999999);
		}
		
		// Link Values
		$link 							= ($link=='||') ? '' : $link;
		$link 							= vc_build_link($link);
		$a_href							= $link['url'];
		$a_title 						= $link['title'];
		$a_target 						= $link['target'];

		// Tooltip
		if ($tooltip_css == "true") {
			if (strlen($a_title) != 0) {
				$button_tooltipclasses	= " ts-simptip-multiline " . $tooltip_style . " " . $tooltip_position;
				$button_tooltipcontent	= ' data-tstooltip="' . $a_title . '"';
			} else {
				$button_tooltipclasses	= "";
				$button_tooltipcontent	= "";
			}
		} else {
			$button_tooltipclasses		= "";
			if (strlen($a_title) != 0) {
				$button_tooltipcontent	= ' title="' . $a_title . '"';
			} else {
				$button_tooltipcontent	= "";
			}
		}
		
		// Button Type
		if ($button_type == "square") {
			$button_style				= $button_square;
			$button_font				= '';
		} else if ($button_type == "rounded") {
			$button_style				= $button_rounded;
			$button_font				= '';
		} else if ($button_type == "pill"){
			$button_style				= $button_pill;
			$button_font				= '';
		} else if ($button_type == "circle") {
			$button_style				= $button_circle;
			$button_font				= 'font-size: ' . $button_font . 'px;';
		}
		
		// Button Alignment
		if ($button_align == "center") {
			$button_align				= 'text-align: center;';
		} else if ($button_align == "left") {
			$button_align				= 'text-align: left';
		} else if ($button_align == "right") {
			$button_align				= 'text-align: right';
		}
		
		// Button Text Color
		if ($button_change == "true") {
			$button_color				= 'color: ' . $button_color . ';';
		} else {
			$button_color				= '';
		}

		// Icon Style
		$icon_style                     = 'display: inline; ' . ($icon_change == "true" ? "color: " . $icon_color . ";" : "") . ';';
		
		$output 						= '';
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Icon_Button', $atts);
		} else {
			$css_class	= '';
		}
		
		$output .= '<div id="' . $button_id . '" class="ts-button-parent ts-button-type-' . $button_type . ' ' . $el_class . ' ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; ' . $button_align . '">';
			if ($button_wrapper == "true") {
				$output .= '<div class="ts-button-wrap" style="">';
			}
				$output .= '<a href="' . $a_href . '" target="' . trim($a_target) . '" style="' . $button_font . ' width: ' . $button_width . '%;" class="ts-button ' . $button_style . ' ' . $button_size . ' ' . $button_tooltipclasses . '" ' . $button_tooltipcontent . '>';
					
					if (!empty($icon) && ($icon != "transparent")) {
						$output .= '<i class="' . $icon . '" style="margin-right: 5px; ' . $icon_style . '"></i>';
					}
					$output .= '<span class="ts-button-text" style="display: inline; ' . $button_color . '">' . $button_text . '</span>';
				
				$output .= '</a>';
			if ($button_wrapper == "true") {
				$output .= '</div>';
			}
		$output .= '</div>';

		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>