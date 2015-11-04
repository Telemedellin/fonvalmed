<?php
	add_shortcode('TS_VCSC_Creative_Link', 'TS_VCSC_Creative_Link_Function');

	function TS_VCSC_Creative_Link_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-extend-creativelinks');
		//wp_enqueue_script('ts-extend-creativelinks');
		wp_enqueue_script('ts-visual-composer-extend-front');
	
		extract( shortcode_atts( array(
			// Main Settings
			'link'						=> '',
			'link_effect'				=> 'effect-1',
			'link_base64'				=> 'false',
			'link_content'				=> 'Link Text',
			'link_encoded'				=> '',
			'link_message'				=> 'Link Message',
			'link_uppercase'			=> 'true',
			'link_align'				=> 'center',
			// Link Additions
			'link_additions'			=> 'false',
			'link_id'					=> '',
			'link_classes'				=> '',
			'link_attributes'			=> '',
			// Link Styling
			'link_text_color'			=> '#333333',
			'link_text_hover'			=> '#333333',
			'link_message_color'		=> '#cccccc',
			'link_message_hover'		=> '#cccccc',
			'link_back_color'			=> '#ededed',
			'link_back_hover'			=> '#cccccc',		
			'link_border_type'			=> 'solid',
			'link_border_width'			=> 2,
			'link_border_color'			=> '#cccccc',
			'link_border_hover'			=> '#ededed',
			// Link Tooltip
			'tooltip_content_html'		=> '',
			'tooltip_position'			=> 'ts-simptip-position-top',
			'tooltip_style'				=> '',
			'tooltipster_offsetx'		=> 0,
			'tooltipster_offsety'		=> 0,
			// Other Settings
			'margin_top'				=> 20,
			'margin_bottom'				=> 20,
			'el_id' 					=> '',
			'el_class' 					=> '',
			'css'						=> '',
		), $atts ));
		
		if (($tooltip_content_html != '') && ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndForcable == "false")) {
			wp_enqueue_style('ts-extend-tooltipster');
			wp_enqueue_script('ts-extend-tooltipster');
		}

		// ID
		if (!empty($el_id)) {
			$button_id					= $el_id;
		} else {
			$button_id					= 'ts-vcsc-creativelink-' . mt_rand(999999, 9999999);
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
		if (strlen($tooltip_content_html) != 0) {
			$Tooltip_Content			= 'data-tooltipster-title="" data-tooltipster-text="' . rawurldecode(base64_decode(strip_tags($tooltip_content_html))) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			$Tooltip_Class				= $tooltipclasses;
		} else {
			$Tooltip_Content			= '';
			$Tooltip_Class				= '';
		}
		
		// Decode HTML Title
		if ($link_base64 == "true") {
			$link_encoded				= rawurldecode(base64_decode(strip_tags($link_encoded)));
			$link_content				= do_shortcode($link_encoded);
		}
		
		// Decode Link Attributes
		if (($link_additions == 'true') && ($link_attributes != '')) {
			$link_attributes			= rawurldecode(base64_decode(strip_tags($link_attributes)));
		} else {
			$link_attributes			= '';
		}
		if (($link_additions == 'true') && ($link_id != '')) {
			$link_id					= $link_id;
		} else {
			$link_id					= '';
		}
		if (($link_additions == 'true') && ($link_classes != '')) {
			$link_classes				= $link_classes;
		} else {
			$link_classes				= '';
		}
		
		// Uppercase Text
		if ($link_uppercase == 'true') {
			$link_classes				.= ' ts-creative-link-uppercase';
		}
		
		$output 						= '';
		$styles							= '';
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 					= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Creative_Link', $atts);
		} else {
			$css_class					= '';
		}
		
		$link_data						= 'data-effect="' . $link_effect . '" data-text-color="' . $link_text_color . '" data-text-hover="' . $link_text_hover . '" data-back-color="' . $link_back_color . '" data-back-hover="' . $link_back_hover . '"';
		
		// Create Custom CSS
		$styles .= '<style id="' . $button_id . '-styles" type="text/css">';
			$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav {';
				$styles .= 'text-align: ' . $link_align . ';';
			$styles .= '}';
			$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav a {';
				$styles .= 'color: ' . $link_text_color . ';';
			$styles .= '}';
			$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav a:hover {';
				$styles .= 'color: ' . $link_text_hover . ';';
			$styles .= '}';
			if ($link_effect == 'effect-2') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-2 a span {';
					$styles .= 'background: ' . $link_back_color . ';';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-2 a span:before {';
					$styles .= 'background: ' . TS_VCSC_Color_Average($link_back_color, $link_back_hover, 0.50) . ';';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-2 a:hover span:before,';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-2 a:focus span:before {';
					$styles .= 'background: ' . $link_back_hover . ';';
				$styles .= '}';
			}
			if (($link_effect == 'effect-3') || ($link_effect == 'effect-4')) {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-' . $link_effect . ' a:after {';
					$styles .= 'border-bottom: ' . $link_border_width . 'px ' . $link_border_type . ' ' . $link_border_color . ';';
				$styles .= '}';
			}
			if ($link_effect == 'effect-6') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-6 a:before {';
					$styles .= 'background: ' . $link_border_color . ';';
					$styles .= 'height: ' . $link_border_width . 'px;';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-6 a:after {';
					$styles .= 'background: ' . $link_border_color . ';';
					$styles .= 'height: ' . $link_border_width . 'px;';
					$styles .= 'width: ' . $link_border_width . 'px;';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-6 a:hover:after {';
					$styles .= 'height: 100%;';
				$styles .= '}';
			}
			if ($link_effect == 'effect-7') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-7 a:before, ';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-7 a:after {';
					$styles .= 'background: ' . $link_border_color . ';';
					$styles .= 'height: ' . $link_border_width . 'px;';
				$styles .= '}';
			}
			if ($link_effect == 'effect-8') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-8 a:before {';
					$styles .= 'border: ' . $link_border_width . 'px ' . $link_border_type . ' ' . $link_border_color . ';';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-8 a:after {';
					$styles .= 'border: ' . $link_border_width . 'px ' . $link_border_type . ' ' . $link_border_hover . ';';
				$styles .= '}';
			}
			if ($link_effect == 'effect-9') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-9 a:before, ';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-9 a:after {';
					$styles .= 'background: ' . $link_border_color . ';';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-9 a span:last-child {';
					$styles .= 'color: ' . $link_message_color . ';';
				$styles .= '}';
			}
			if ($link_effect == 'effect-10') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-10 a span {';
					$styles .= 'background: ' . $link_back_color . ';';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-10 a:hover {';
					$styles .= 'color: ' . $link_text_color . ';';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-10 a:before {';
					$styles .= 'color: ' . $link_text_hover . ';';
					$styles .= 'background: ' . $link_back_hover . ';';
				$styles .= '}';
			}
			if ($link_effect == 'effect-11') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-11 a {';
					$styles .= 'border-top: ' . $link_border_width . 'px ' . $link_border_type . ' ' . $link_text_color . ';';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-11 a:hover {';
					$styles .= 'color: ' . $link_text_color . ';';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-11 a:before {';
					$styles .= 'color: ' . $link_text_hover . ';';
					$styles .= 'border-bottom: ' . $link_border_width . 'px ' . $link_border_type . ' ' . $link_text_hover . ';';
				$styles .= '}';
			}
			if ($link_effect == 'effect-12') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-12 a:before,';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-12 a:after {';
					$styles .= 'border-color: ' . $link_border_color . ';';
				$styles .= '}';
			}
			if ($link_effect == 'effect-13') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-13 a:hover:before,';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-13 a:focus:before {';
					$styles .= 'color: ' . $link_border_color . ';';
					$styles .= 'text-shadow: 10px 0 ' . $link_border_color . ', -10px 0 ' . $link_border_color . ';';
				$styles .= '}';
			}
			if ($link_effect == 'effect-14') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-14 a:before,';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-14 a:after {';
					$styles .= 'background: ' . $link_border_color . ';';
				$styles .= '}';
			}
			if ($link_effect == 'effect-15') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-15 a {';
					$styles .= 'color: ' . $link_text_hover . ';';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-15 a:hover {';
					$styles .= 'color: ' . $link_text_hover . ';';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-15 a:before {';
					$styles .= 'color: ' . $link_text_color . ';';
				$styles .= '}';
			}
			if ($link_effect == 'effect-16') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-16 a:before {';
					$styles .= 'color: ' . $link_text_hover . ';';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-16 a:hover {';
					$styles .= 'color: ' . $link_text_color . ';';
				$styles .= '}';
			}
			if ($link_effect == 'effect-17') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-17 a {';
					$styles .= 'color: ' . $link_text_hover . ';';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-17 a:before {';
					$styles .= 'color: ' . $link_text_color . ';';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-17 a:after {';
					$styles .= 'background: ' . $link_text_color . ';';
				$styles .= '}';
			}
			if ($link_effect == 'effect-18') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-18 a:before,';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-18 a:after {';
					$styles .= 'background: ' . $link_border_color . ';';
				$styles .= '}';
			}
			if ($link_effect == 'effect-19') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-19 a span {';
					$styles .= 'background: ' . $link_back_color . ';';
				$styles .= '}';				
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-19 a:hover span {';
					$styles .= 'color: ' . $link_text_color . ';';
				$styles .= '}';				
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-19 a span:before {';
					$styles .= 'background: ' . TS_VCSC_Color_Average($link_back_color, $link_back_hover, 0.50) . ';';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-19 a:hover span:before,';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-19 a:focus span:before {';
					$styles .= 'background: ' . $link_back_hover . ';';
					$styles .= 'color: ' . $link_text_hover . ';';
				$styles .= '}';
			}
			if ($link_effect == 'effect-20') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-20 a span {';
					$styles .= 'background: ' . $link_back_color . ';';
					$styles .= '-webkit-box-shadow: inset 0 3px ' . $link_border_color . ';';
					$styles .= '-moz-box-shadow: inset 0 3px ' . $link_border_color . ';';
					$styles .= 'box-shadow: inset 0 3px ' . $link_border_color . ';';
				$styles .= '}';				
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-20 a:hover span {';
					$styles .= 'color: ' . $link_text_color . ';';
				$styles .= '}';				
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-20 a span:before {';
					$styles .= 'background: ' . TS_VCSC_Color_Average($link_back_color, $link_back_hover, 0.50) . ';';
				$styles .= '}';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-20 a:hover span:before,';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-20 a:focus span:before {';
					$styles .= 'background: ' . $link_back_hover . ';';
					$styles .= 'color: ' . $link_text_hover . ';';
				$styles .= '}';
			}
			if ($link_effect == 'effect-21') {
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-21 a:before,';
				$styles .= '#' . $button_id . '.ts-creativelink-wrapper nav.ts-creative-link-effect-21 a:after {';
					$styles .= 'background: ' . $link_border_color . ';';
				$styles .= '}';
			}
		$styles .= '</style>';
		
		$output .= $styles;
		$output .= '<div id="' . $button_id . '" class="ts-creativelink-wrapper clearFixMe ' . $el_class . ' ' . $css_class . ' ' . $Tooltip_Class . '" ' . $link_data . ' ' . $Tooltip_Content . ' style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
			$output .= '<nav class="ts-creative-link-' . $link_effect . '" style="text-align: ' . $link_align . ';">';
				$output .= '<a id="' . $link_id . '" class="' . $link_classes . '" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '" ' . $link_attributes . ' data-hover="' . $link_content . '">';
					if (($link_effect == 'effect-1') || ($link_effect == 'effect-3') || ($link_effect == 'effect-4') || ($link_effect == 'effect-6') || ($link_effect == 'effect-7') || ($link_effect == 'effect-8') || ($link_effect == 'effect-11') || ($link_effect == 'effect-12') || ($link_effect == 'effect-13') || ($link_effect == 'effect-14') || ($link_effect == 'effect-15') || ($link_effect == 'effect-16') || ($link_effect == 'effect-17') || ($link_effect == 'effect-18') || ($link_effect == 'effect-21')) {
						$output .= $link_content;
					} else {
						$output .= '<span data-hover="' . $link_content . '">' . $link_content . '</span>';
					}
					if ($link_effect == 'effect-9') {
						$output .= '<span>' . $link_message . '</span>';
					}
				$output .= '</a>';
			$output .= '</nav>';			
		$output .= '</div>';
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>