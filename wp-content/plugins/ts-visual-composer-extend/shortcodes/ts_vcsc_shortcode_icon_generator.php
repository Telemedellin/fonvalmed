<?php
	add_shortcode('TS_VCSC_Icon_Font', 'TS_VCSC_Icon_Font_Function');
	add_shortcode('TS_TINY_Icon_Font', 'TS_VCSC_Icon_Font_Function');
	function TS_VCSC_Icon_Font_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
		
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndWaypoints == "true") {
			if (wp_script_is('waypoints', $list = 'registered')) {
				wp_enqueue_script('waypoints');
			} else {
				wp_enqueue_script('ts-extend-waypoints');
			}
		}
		
		wp_enqueue_style('ts-extend-simptip');
		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract(shortcode_atts(array(
			'id' 						=> '',
			'class' 					=> '',
			
			'icon' 						=> '',
			'size'           			=> 16,
			
			'color'						=> '#000000',
			'background'				=> '',
			'opacity'					=> 1,
	
			'hoverchanges'				=> 'false',
			'hovercolor'				=> '#000000',
			'hoverbackground'			=> '',
			'hoveropacity'				=> 1,
			
			'animation'					=> '',
			'viewport'					=> '',
			'delay'						=> 0,
			'shadow'					=> '',
			
			'bordershow'				=> 'false',
			'bordertype' 				=> 'solid',
			'borderwidth'				=> 1,
			'borderradius'				=> '',
			'bordercolor'				=> '#cccccc',
			
			'padding'					=> 0,
			'paddingtop'				=> 0,
			'paddingbottom'				=> 0,
			'paddingleft'				=> 0,
			'paddingright'				=> 0,

			'margin'					=> 5,
			'margintop'					=> 5,
			'marginbottom'				=> 5,
			'marginleft'				=> 5,
			'marginright'				=> 5,
			
			'inline'					=> 'true',
			'align' 					=> 'ts-align-center',
			
			'tooltipcontent'			=> '',
			'tooltipcss'				=> 'false',
			'tooltipposition'			=> 'ts-simptip-position-top',
			'tooltipstyle'				=> '',
			
			'link' 						=> '',
			'target'					=> '_parent',
		), $atts));
		
		// Custom ID and Classes for Element
		// ---------------------------------
	
		// Retrieve Class for Icon
		if (strlen($icon) > 0) {
			$icon_icon					= $icon . "";
		} else {
			$icon_icon					= "";
		}
		// Define Custom ID for Element
		if (strlen($id) > 0) {
			$icon_id					= $id;
		} else {
			$icon_id					= 'ts-vcsc-generator-icon-' . mt_rand(999999, 9999999);
		}
		// Define Custom Class Name for Element
		if (strlen($class) > 0) {
			$icon_class					= $class . " ";
		} else {
			$icon_class					= "";
		}
		// Define Class for Border Radius
		if (strlen($borderradius) > 0) {
			$icon_borderradius			= $borderradius . " ";
		} else {
			$icon_borderradius			= "";
		}
		// Define Class for Animation
		if (strlen($animation) > 0) {
			$icon_animation				= $animation . " ";
		} else {
			$icon_animation				= "";
		}
		
		// Style Settings for Element
		// --------------------------
		
		// Define Size for Element
		if ($size != 16) {
			$icon_size					= "height:" . $size . "px; width:" . $size . "px; line-height:" . $size . "px; font-size:" . $size . "px; ";
		} else {
			$icon_size					= "";
		}
		
		// Define Color for Element
		if ($color != "#000000") {
			$icon_color					= "color: " . $color . "; ";
		} else {
			$icon_color					= "";
		}
		
		// Define Background for Element
		if (strlen($background) > 0) {
			$icon_background 			= " background-color: " . $background . "; ";
		} else {
			$icon_background			= "";
		}
		
		// Define Opacity for Element
		if (strlen($opacity) > 0) {
			$icon_opacity				= $opacity;
		} else {
			$icon_opacity				= "1";
		}
		
		if ($hoverchanges == "true") {
			// Define Hover Color for Element
			if (strlen($hovercolor) > 0) {
				$icon_hovercolor		= $hovercolor;
			} else {
				$icon_hovercolor		= $color;
			}
			
			// Define Hover Background for Element
			if (strlen($hoverbackground) > 0) {
				$icon_hoverbackground	= $hoverbackground;
			} else {
				$icon_hoverbackground	= $background;
			}
			
			// Define Hover Opacity for Element
			if (strlen($hoveropacity) > 0) {
				$icon_hoveropacity		= $hoveropacity;
			} else {
				$icon_hoveropacity		= "1";
			}
		}
		
		// Define Border for Element
		if ($bordershow == "true") {
			$icon_border 	        	= "border: " . $borderwidth . "px " . $bordertype . " " . $bordercolor . "; ";
		} else {
			$icon_border				= "";
		}
		
		// Define Paddings for Element
		if ($padding != 0) {
			$icon_paddingtop				= $padding;
			$paddingbottom					= $padding;
			$paddingleft					= $padding;
			$paddingright					= $padding;
		} else {
			if ($paddingtop != 0) {
				$icon_paddingtop			= $paddingtop;
			} else {
				$icon_paddingtop			= 0;
			}
			if ($paddingbottom != 0) {
				$icon_paddingbottom			= $paddingbottom;
			} else {
				$icon_paddingbottom			= 0;
			}
			if ($paddingleft != 0) {
				$icon_paddingleft			= $paddingleft;
			} else {
				$icon_paddingleft			= 0;
			}
			if ($paddingright != 0) {
				$icon_paddingright			= $paddingright;
			} else {
				$icon_paddingright			= 0;
			}
		}
		$icon_padding 					= "padding: " . $icon_paddingtop . "px " . $icon_paddingright . "px " . $icon_paddingbottom . "px " . $icon_paddingleft . "px; ";
		
		// Define Margins for Element
		if ($margintop != 5){
			$icon_margintop				= $margintop;
		} else {
			$icon_margintop				= 5;
		}
		if ($marginbottom != 5){
			$icon_marginbottom			= $marginbottom;
		} else {
			$icon_marginbottom			= 5;
		}
		if ($marginleft != 5){
			$icon_marginleft			= $marginleft;
		} else {
			$icon_marginleft			= 5;
		}
		if ($marginright != 5){
			$icon_marginright			= $marginright;
		} else {
			$icon_marginright			= 5;
		}
		$icon_margin 					= "margin: " . $icon_margintop . "px " . $marginright . "px " . $marginbottom . "px " . $marginleft . "px; ";
		
		// Define Class for Element Align
		if (strlen($align) > 0) {
			$icon_align					= " " . $align;
		} else {
			$icon_align					= "";
		}
		
		// Viewport Animation
		if (strlen($viewport) > 0) {
			$icon_viewport				= $viewport;
			$icon_viewportclass			= "ts-font-icon-generator-viewport";
		} else {
			$icon_viewport				= "";
			$icon_viewportclass			= "";
		}
		
		// Tooltip
		if ($tooltipcss == "true") {
			if (strlen($tooltipcontent) != 0) {
				$icon_tooltipclasses 	= " ts-simptip-multiline " . $tooltipstyle . " " . $tooltipposition;
				$icon_tooltipcontent	= ' data-tstooltip="' . $tooltipcontent . '"';
			} else {
				$icon_tooltipclasses	= "";
				$icon_tooltipcontent	= "";
			}
		} else {
			$icon_tooltipclasses		= "";
			if (strlen($tooltipcontent) != 0) {
				$icon_tooltipcontent	= ' title="' . $tooltipcontent . '"';
			} else {
				$icon_tooltipcontent	= "";
			}
		}
		
		// Calculate Total Item Width
		$icon_totalwidth				= ($size + 2*$padding + $icon_marginleft + $icon_marginright + 2*$borderwidth);
		
		// Create Element Output
		// ---------------------
		if ($inline == "true") {
			$output = '<span class="ts-font-icon-holder ts-align-inline' . $icon_tooltipclasses . '"' . $icon_tooltipcontent . '>';
		} else {
			$output = '<div class="ts-font-icon-holder ' . $align . $icon_tooltipclasses . '"' . $icon_tooltipcontent . '>';
		}
	
		if (strlen($link) > 0) {
			$output .= '<a class="ts-font-icon-link" href="' . $link . '" target="' . $target . '">';
		}
	
		if ($hoverchanges == "true") {
			$output .= '<i id="' . $icon_id . '" class="ts-font-icon ts-font-icon-generator ' . $icon_icon . " " . $icon_borderradius . $icon_animation . $icon_class . $icon_viewportclass . '" data-viewport="' . $icon_viewport . '" data-delay="' . $delay . '" data-hover="true" data-opacity="' . $icon_opacity . '" data-hoveropacity="' . $icon_hoveropacity . '" data-color="' . $color . '" data-hovercolor="' . $icon_hovercolor . '" data-background="' . $background . '" data-hoverbackground="' . $icon_hoverbackground . '" style="' . $icon_size . $icon_color . $icon_background . $icon_border . $icon_padding . $icon_margin . '"><span class="ts-font-icon-inner">' . $icon_icon . '</span></i>';
		} else {
			$output .= '<i id="' . $icon_id . '" class="ts-font-icon ts-font-icon-generator ' . $icon_icon . " " . $icon_borderradius . $icon_animation . $icon_class . $icon_viewportclass . '" data-viewport="' . $icon_viewport . '" data-delay="' . $delay . '" data-hover="false" data-opacity="' . $icon_opacity . '" style="' . $icon_size . $icon_color . $icon_background . $icon_border . $icon_padding . $icon_margin . '"><span class="ts-font-icon-inner">' . $icon_icon . '</span></i>';
		}
		
		if (strlen($link) > 0) {
			$output .= '</a>';
		}
	
		if ($inline == "true") {
			$output .= '</span>';
		} else {
			$output .= '</div>';
		}
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>
