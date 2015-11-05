<?php
	add_shortcode('TS_VCSC_Icon_Flat_Button', 'TS_VCSC_Icon_Flat_Button_Function');
	function TS_VCSC_Icon_Flat_Button_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
	
		extract( shortcode_atts( array(
			'link'						=> '',
			'tooltip_html'				=> 'false',
			'tooltip_content'			=> '',
			'tooltip_content_html'		=> '',
			'tooltip_position'			=> 'ts-simptip-position-top',
			'tooltip_style'				=> '',
			'tooltipster_offsetx'		=> 0,
			'tooltipster_offsety'		=> 0,
			
			'button_switch'				=> 'false',
			'button_style'				=> 'ts-color-button-sun-flower',			
			'button_style1'				=> 'ts-dual-buttons-color-default',
			'button_hover1'				=> 'ts-dual-buttons-preview-default ts-dual-buttons-hover-default',
			
			'button_width'				=> 100,
			'button_height'				=> 50,
			'button_align'				=> 'center',
			'button_text'				=> 'Read More',
			'button_change'				=> 'false',
			'button_color'				=> '#ffffff',
			
			'font_size'					=> 20,
			
			'icon'						=> '',
			'icon_change'				=> 'false',
			'icon_color'				=> '#ffffff',

			'margin_top'				=> 20,
			'margin_bottom'				=> 20,
			'el_id' 					=> '',
			'el_class' 					=> '',
			'css'						=> '',
		), $atts ));
		

		wp_enqueue_style('ts-extend-tooltipster');
		wp_enqueue_script('ts-extend-tooltipster');
		if ($button_switch == "true") {
			wp_enqueue_style('ts-extend-buttonsdual');
		} else {
			wp_enqueue_style('ts-extend-buttonsflat');
		}
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');

		// ID
		if (!empty($el_id)) {
			$button_id					= $el_id;
		} else {
			$button_id					= 'ts-vcsc-flatbutton-' . mt_rand(999999, 9999999);
		}
		
		// Link Values
		$link 							= ($link=='||') ? '' : $link;
		$link 							= vc_build_link($link);
		$a_href							= $link['url'];
		$a_title 						= $link['title'];
		$a_target 						= $link['target'];

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
		if (($tooltip_html == "true") && (strlen($tooltip_content_html) != 0)) {
			$Tooltip_Content			= 'data-tooltipster-title="" data-tooltipster-text="' . rawurldecode(base64_decode(strip_tags($tooltip_content_html))) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			$Tooltip_Class				= $tooltipclasses;
		} else if (($tooltip_html == "false") && (strlen($tooltip_content) != 0)) {
			$Tooltip_Content			= 'data-tooltipster-title="" data-tooltipster-text="' . str_replace('<br/>', ' ', $tooltip_content) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			$Tooltip_Class				= $tooltipclasses;
		} else {
			$Tooltip_Content			= '';
			$Tooltip_Class				= '';
		}		
		
		// Button Style
		if ($button_align == "center") {
			$buttonstyle				= "width: " . $button_width . "%; min-height: " . $button_height . "px; margin: 0 auto; float: none;";
		} else if ($button_align == "left") {
			$buttonstyle				= "width: " . $button_width . "%; min-height: " . $button_height . "px; margin: 0 auto; float: left;";
		} else if ($button_align == "right") {
			$buttonstyle				= "width: " . $button_width . "%; min-height: " . $button_height . "px; margin: 0 auto; float: right;";
		}
		
		// Button Class
		if ($button_switch == "true") {
			$buttonclass				= $button_style1 . ' ' . $button_hover1;
		} else {
			$buttonclass				= $button_style;
		}
		
		$iconstyle						= "margin: " . (($button_height - $font_size - 10 - 2) / 2) . "px auto 0px auto";
		$textstyle						= "margin: " . (($button_height - $font_size - 10 - 2) / 2) . "px auto " . (($button_height - $font_size - 10 - 2) / 2) . "px auto";

		$output 						= '';
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Icon_Flat_Button', $atts);
		} else {
			$css_class	= '';
		}
		
		$output .= '<div id="' . $button_id . '" class="ts-flat-button-wrapper clearFixMe ' . $el_class . ' ' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
			$output .= '<a href="' . $a_href . '" target="' . $a_target . '" style="' . $buttonstyle . '" title="' . $a_title . '" class="ts-color-button-container ' . $buttonclass . ' ' . $Tooltip_Class . '" ' . $Tooltip_Content . '>';
				if (($icon != '') && ($icon != 'transparent')) {
					$output .= '<span class="ts-color-button-icon ' . $icon . '" style="' . ($icon_change == "true" ? "color: " . $icon_color . ";" : "") . '; font-size: ' . $font_size . 'px; line-height: ' . $font_size . 'px; ' . $iconstyle . '"></span>';
				}
				$output .= '<span class="ts-color-button-title" style="color: ' . $button_color . '; font-size: ' . $font_size . 'px; line-height: ' . $font_size . 'px; ' . $textstyle . '">' . $button_text . '</span>';
			$output .= '</a>';
		$output .= '</div>';

		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>