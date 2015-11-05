<?php
	add_shortcode('TS_VCSC_Icon_Dual_Button', 'TS_VCSC_Icon_Dual_Button_Function');
	function TS_VCSC_Icon_Dual_Button_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-extend-tooltipster');
		wp_enqueue_script('ts-extend-tooltipster');	
		wp_enqueue_style('ts-extend-buttonsdual');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
	
		extract( shortcode_atts( array(
			'button_align'				=> 'ts-dual-buttons-center',
			'button_width'				=> 100,
			'button_radius'				=> 'ts-dual-buttons-radius-large',
			
			'separator_content'			=> 'text',
			'separator_color'			=> '#444444',
			'separator_background'		=> '#ffffff',
			'separator_text'			=> 'or',
			'separator_icon'			=> '',

			'button_link1'				=> '',
			'button_text1'				=> 'Read More 1',
			'button_style1'				=> 'ts-dual-buttons-color-default',
			'button_hover1'				=> 'ts-dual-buttons-preview-default ts-dual-buttons-hover-default',
			'button_link2'				=> '',
			'button_text2'				=> 'Read More 2',
			'button_style2'				=> 'ts-dual-buttons-color-default',
			'button_hover2'				=> 'ts-dual-buttons-preview-default ts-dual-buttons-hover-default',
			
			'tooltip_content1'			=> '',
			'tooltip_content2'			=> '',
			'tooltip_position'			=> 'ts-simptip-position-top',
			'tooltip_style'				=> '',
			'tooltipster_offsetx'		=> 0,
			'tooltipster_offsety'		=> 0,
			
			'margin_top'				=> 20,
			'margin_bottom'				=> 20,
			'el_id' 					=> '',
			'el_class' 					=> '',
			'css'						=> '',
		), $atts ));
		
		$output 						= '';
		
		// ID
		if (!empty($el_id)) {
			$button_id					= $el_id;
		} else {
			$button_id					= 'ts-vcsc-dualbutton-' . mt_rand(999999, 9999999);
		}
		
		// Link Values
		$button_link1 					= ($button_link1 == '||') ? '' : $button_link1;
		$button_link1 					= vc_build_link($button_link1);
		$a1_href						= $button_link1['url'];
		$a1_title 						= $button_link1['title'];
		$a1_target 						= $button_link1['target'];		
		$button_link2 					= ($button_link2 == '||') ? '' : $button_link2;
		$button_link2 					= vc_build_link($button_link2);
		$a2_href						= $button_link2['url'];
		$a2_title 						= $button_link2['title'];
		$a2_target 						= $button_link2['target'];
		
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
		$tooltipclasses					= 'ts-has-tooltipster-tooltip';		
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
		if (strlen($tooltip_content1) != 0) {
			$Tooltip_Content1			= 'data-tooltipster-html="true" data-tooltipster-title="" data-tooltipster-text="' . strip_tags($tooltip_content1) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			$Tooltip_Class1				= $tooltipclasses;
		} else {
			$Tooltip_Content1			= '';
			$Tooltip_Class1				= '';
		}
		if (strlen($tooltip_content2) != 0) {
			$Tooltip_Content2			= 'data-tooltipster-html="true" data-tooltipster-title="" data-tooltipster-text="' . strip_tags($tooltip_content2) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			$Tooltip_Class2				= $tooltipclasses;
		} else {
			$Tooltip_Content2			= '';
			$Tooltip_Class2				= '';
		}		
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Icon_Dual_Button', $atts);
		} else {
			$css_class	= '';
		}
		
		$output .= '<div id="' . $button_id . '" class="ts-dual-buttons-container clearFixMe" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
			$output .= '<div class="ts-dual-buttons-wrapper ' . $button_align . ' ' . $button_radius . '" style="width: ' . $button_width . '%;">';
				$output .= '<a class="ts-dual-buttons-link-left ' . $button_style1 . ' ' . $button_hover1 . ' ' . $Tooltip_Class1 . '" href="' . $a1_href . '" target="' . $a1_target . '" title="' . $a1_title . '" ' . $Tooltip_Content1 . '>' . $button_text1 . '</a>';
				if ($separator_content != 'none') {
					if ($separator_content == "icon") {
						if (($separator_icon != '') && ($separator_icon != 'transparent')) {
							$output .= '<span class="ts-dual-buttons-separator" style="background: ' . $separator_background . ';"><i class="' . $separator_icon . '" style="color: ' . $separator_color . ';"></i></span>';
						} else {
							$output .= '<span class="ts-dual-buttons-separator" style="background: ' . $separator_background . ';"></span>';
						}
					} else if ($separator_content == "text") {
						$output .= '<span class="ts-dual-buttons-separator" style="background: ' . $separator_background . '; color: ' . $separator_color . ';">' . $separator_text . '</span>';
					} else if ($separator_content == "empty") {
						$output .= '<span class="ts-dual-buttons-separator" style="background: ' . $separator_background . ';"></span>';
					}
				}
				$output .= '<a class="ts-dual-buttons-link-right ' . $button_style2 . ' ' . $button_hover2 . ' ' . $Tooltip_Class2 . '" href="' . $a2_href . '" target="' . $a2_target . '" title="' . $a2_title . '" ' . $Tooltip_Content2 . '>' . $button_text2 . '</a>';
			$output .= '</div>';
		$output .= '</div>';

		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>