<?php
if (!class_exists('TS_SlitSlider')){
	class TS_SlitSlider {
		function __construct() {
			global $VISUAL_COMPOSER_EXTENSIONS;
            if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
                add_action('init',                              		array($this, 'TS_VCSC_Add_iPresenter_Elements'), 9999999);
            } else {
                add_action('admin_init',		                		array($this, 'TS_VCSC_Add_iPresenter_Elements'), 9999999);
            }
			add_shortcode('TS_VCSC_SlitSlider_Item',					array($this, 'TS_VCSC_SlitSlider_Item'));
			add_shortcode('TS_VCSC_SlitSlider_Container',       		array($this, 'TS_VCSC_SlitSlider_Container'));
		}

		// Single SlitSlider Item
		function TS_VCSC_SlitSlider_Item ($atts, $content = null) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend_edit					= 'true';
			} else {
				$frontend_edit					= 'false';
			}
		
			extract( shortcode_atts( array(
				'background'					=> 'image',
				'image'							=> '',
				'color'							=> '#cccccc',
				'gradient'						=> '',
				'icon'							=> '',
				'title'							=> '',				
				'cite'							=> '',
				// Animation
				'orientation'					=> 'horizontal',
				'rotation1'						=> -25,
				'rotation2'						=> -25,
				'scale1'						=> 200,
				'scale2'						=> 200,
				// Ken Burns
				'kenburns_effect'				=> '',
				// Icon
				'icon_color'					=> '#4e4e4d',
				'icon_border'					=> 'rgba(150, 150, 150, 0.4)',
				'icon_shadow'					=> '#f7f7f7',
				// Title
				'title_color'					=> '#ffffff',
				'title_size'					=> 75,
				'title_align'					=> 'center',
				// Content
				'content_color'					=> '#ffffff',
				'content_quote'					=> 'false',
				'content_cite'					=> 'rgba(61, 61, 61, 0.65)',
				// Citation
				'cite_color'					=> '#4e4e4d',
				// Fonts
				'font_title_family'				=> 'Default',
				'font_title_type'				=> '',
				'font_content_family'			=> 'Default',
				'font_content_type'				=> '',
				'font_cite_family'				=> 'Default',
				'font_cite_type'				=> '',
				// Link
				'link_slide'					=> '',
				'link_wrapper'					=> 'button',
				'link_text'						=> 'Learn More',
				'link_style'					=> 'empty',
				'link_color'					=> 'white',
				'link_align'					=> 'left',
				// Other
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			), $atts ));
			
			$slitslider_random					= mt_rand(999999, 9999999);
			
			$slitslider_id						= 'ts-slit-slide-' . $slitslider_random;
	
			// Images
			$slitslider_image					= wp_get_attachment_image_src($image, 'full');
			$thumbnail_image					= wp_get_attachment_image_src($image, 'medium');

			$output = $animation = '';
			
			// Font Settings
			if (strpos($font_title_family, 'Default') === false) {
				$google_font_title			= TS_VCSC_GetFontFamily($slitslider_id . " .ts-box-icon-title", $font_title_family, $font_title_type, false, true, false);
			} else {
				$google_font_title			= '';
			}
			if (strpos($font_content_family, 'Default') === false) {
				$google_font_content		= TS_VCSC_GetFontFamily($slitslider_id . " .ts-slit-slide-inner-text", $font_content_family, $font_content_type, false, true, false);
			} else {
				$google_font_content		= '';
			}
			if (strpos($font_cite_family, 'Default') === false) {
				$google_font_cite			= TS_VCSC_GetFontFamily($slitslider_id . " .ts-icon-box-readmore", $font_cite_family, $font_cite_type, false, true, false);
			} else {
				$google_font_cite			= '';
			}
			
			// Link Settings
			if ($link_slide != '') {
				$link 							= ($link_slide == '||') ? '' : $link_slide;
				$link 							= vc_build_link($link);
				$a_href							= $link['url'];
				$a_title 						= $link['title'];
				$a_target 						= $link['target'];
			} else {
				$a_href							= "";
				$a_title 						= "";
				$a_target 						= "";
			}
			
			// Ken Burns Effect
			if ($kenburns_effect == 'random') {
				$kenburns_effects 				= array('kenburns', 'kenburnsLeft', 'kenburnsRight', 'kenburnsUp', 'kenburnsUpLeft', 'kenburnsUpRight', 'kenburnsDown', 'kenburnsDownLeft', 'kenburnsDownRight');
				$kenburns_class					= 'ts-css-animation-' . $kenburns_effects[array_rand($kenburns_effects, 1)];
			} else if ($kenburns_effect != '') {
				$kenburns_class					= 'ts-css-animation-' . $kenburns_effect;
			} else {
				$kenburns_class					= "";
			}

			// CSS Class Style Overrides
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-slit-slide ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_SlitSlider_Item', $atts);
			} else {
				$css_class	= 'ts-slit-slide ' . $el_class;
			}
			
			$output .= '<div id="' . $slitslider_id . '" class="' . $css_class . '" style="display: ' . ($frontend_edit == 'false' ? 'none' : 'block') . ';" data-image="' . $slitslider_image[0] . '" data-kenburns="' . (($background == 'color') ? "false" : ($kenburns_effect != '' ? 'true' : 'false')) . '" data-effect="' . $kenburns_class . '" data-orientation="' . $orientation . '" data-slice1-rotation="' . $rotation1 . '" data-slice2-rotation="' . $rotation2 . '" data-slice1-scale="' . ($scale1 / 100) . '" data-slice2-scale="' . ($scale2 / 100) . '">';
				$output .= '<div class="ts-slit-slide-inner">';
					if ($background == 'image') {
						$output .= '<div class="ts-slit-slide-image ' . $kenburns_class . '" style="background-image: url(' . $slitslider_image[0] . '); background-color: transparent;"></div>';
					} else if ($background == 'color') {
						$output .= '<div class="ts-slit-slide-image" style="background-image: none; background-color: ' . $color . ';"></div>';
					} else if ($background == 'gradient') {
						$output .= '<div class="ts-slit-slide-image ' . $kenburns_class . '" style="background-image: none; background: ' . $gradient . ';"></div>';
					}					
					$output .= '<div class="ts-slit-slide-inner-center">';					
						if (($icon != '') && ($icon != 'transparent') && ($icon != 'none')) {
							$icon_style = '-webkit-box-shadow: inset 0 0 0 5px ' . $icon_shadow . '; -moz-box-shadow: inset 0 0 0 5px ' . $icon_shadow . '; box-shadow: inset 0 0 0 5px ' . $icon_shadow . ';';
							$output .= '<div class="ts-slit-slide-deco" style="color: ' . $icon_color . '; border: 2px dashed ' . $icon_border . ';"><i class="' . $icon . '" style="' . $icon_style . '"></i></div>';
						}
						if ($title != '') {
							if (($a_href != '') && (($link_wrapper == 'title') || ($link_wrapper == 'both'))) {
								$output .= '<a href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '">';
							}
								$output .= '<h2 class="ts-slit-slide-title" style="color: ' . $title_color . '; text-align: ' . $title_align . '; font-size: ' . $title_size . 'px; ' . $google_font_title . ' ' . ((($icon != '') && ($icon != 'transparent') && ($icon != 'none')) ? 'padding-top: 190px;' : '') . '">' . $title . '</h2>';
							if (($a_href != '') && (($link_wrapper == 'title') || ($link_wrapper == 'both'))) {
								$output .= '</a>';
							}
						}
						$output .= '<div class="ts-slit-slide-inner-message" style="color: ' . $content_color . ';">';
							if ($content_quote == 'true') {
								$output .= '<div class="ts-slit-slide-inner-frame">';	
									$output .= '<div class="ts-slit-slide-inner-quote" style="color: ' . $content_cite . ';"></div>';							
							}
								$output .= '<div class="ts-slit-slide-inner-text" style="' . (($content_quote == 'true') ? "padding-left: 60px;" : "") . '' . $google_font_content . '">';
									if (function_exists('wpb_js_remove_wpautop')) {
										$output .= wpb_js_remove_wpautop(do_shortcode($content), true);
									} else {						
										$output .= do_shortcode($content);
									}
								$output .= '</div>';
							if ($content_quote == 'true') {
								$output .= '</div>';
							}
							if ($cite != '') {
								$output .= '<cite style="color: ' . $cite_color . '; ' . $google_font_cite . '">' . $cite . '</cite>';
							}
							if (($a_href != '') && (($link_wrapper == 'button') || ($link_wrapper == 'both'))) {
								$output .= '<a class="ts-slit-slide-button-' . $link_style . ' ' . $link_color . '" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '" style="text-align: ' . $link_align . ';"><span>' . $link_text . '</span></a>';
							}
						$output .= '</div>';					
					$output .= '</div>';					
				$output .= '</div>';
			$output .= '</div>';
	
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
		
		// SlitSlider Container
		function TS_VCSC_SlitSlider_Container ($atts, $content = null){
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();
			
			// Check for Front End Editor
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend_edit					= 'true';
			} else {
				$frontend_edit					= 'false';
			}

			if ($frontend_edit == "false") {				
				wp_enqueue_style('ts-extend-slitslider');
				wp_enqueue_script('ts-extend-slitslider');
				wp_enqueue_style('ts-visual-composer-extend-front');
				wp_enqueue_script('ts-visual-composer-extend-front');
			} else {
				wp_enqueue_style('ts-extend-slitslider');
			}
			
			extract( shortcode_atts( array(
				// General
				'type'							=> 'fixed',
				'height'						=> 600,
				'minimum'						=> 600,
				'offset'						=> 'desktop:0px;tablet:0px;mobile:0px',
				'speed'							=> 1200,
				'fullwidth'						=> 'false',
				'breakouts'						=> 6,
				// NiceScroll
				'nicescroll'					=> 'true',
				'scrollcolor'					=> '#ededed',
				'scrollborder'					=> '#f7f7f7',
				// AutoPlay
				'auto_play'						=> 'false',
				'auto_controls'					=> 'true',
				'auto_delay'					=> 4000,
				'auto_hover'					=> 'true',
				'auto_progress'					=> 'true',
				'auto_color'					=> '#333333',
				'auto_height'					=> 2,
				'auto_position'					=> 'top',
				// Navigation
				'nav_dots'						=> 'true',
				'nav_arrows'					=> 'true',
				'nav_keys'						=> 'true',
				'nav_touch'						=> 'true',
				// Other
				'margin_top'                    => 0,
				'margin_bottom'                 => 0,
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			), $atts ));			
			
			if (($nicescroll == 'true') && ($frontend_edit == 'false')) {
				wp_enqueue_script('ts-extend-nicescroll');
			}
			if (($nav_touch == 'true') && ($frontend_edit == 'false')) {
				wp_enqueue_script('ts-extend-hammer');
			}
			
			$slitslider_random					= mt_rand(999999, 9999999);
			$output 							= '';
			$fullwidth_allow					= "true";
			
			if (!empty($el_id)) {
				$slitslider_id					= $el_id;
			} else {
				$slitslider_id					= 'ts-slit-slider-wrapper-' . $slitslider_random;
			}

			$offset 							= explode(';', $offset);			
			$offsetDesktop						= explode(':', $offset[0]);
			$offsetDesktop						= str_replace("px", "", $offsetDesktop[1]);
			$offsetTablet						= explode(':', $offset[1]);
			$offsetTablet						= str_replace("px", "", $offsetTablet[1]);
			$offsetMobile						= explode(':', $offset[2]);
			$offsetMobile						= str_replace("px", "", $offsetMobile[1]);
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 						= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-slit-slider-wrapper ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_SlitSlider_Container', $atts);
			} else {
				$css_class						= 'ts-slit-slider-wrapper ' . $el_class;
			}
			
			if ($frontend_edit == "false") {
				$data_pageheight				= 'data-pageheight="' . ($type == 'page' ? 'true' : 'false') . '" data-minimum="' . $minimum . '" data-desktop="' . $offsetDesktop . '" data-tablet="' . $offsetTablet . '" data-mobile="' . $offsetMobile . '"';
				$data_general					= 'data-speed="' . $speed . '" data-nicescroll="' . $nicescroll . '" data-scrollcolor="' . $scrollcolor . '" data-scrollborder="' . $scrollborder . '"';
				$data_fullwidth					= 'data-inline="' . $frontend_edit . '" data-fullwidth="' . $fullwidth . '" data-break-parents="' . $breakouts . '"';
				$data_navigation				= 'data-dots="' . $nav_dots . '" data-arrows="' . $nav_arrows . '" data-keys="' . $nav_keys . '" data-touch="' . $nav_touch . '"';
				$data_autoplay					= 'data-play="' . $auto_play . '" data-controls="' . $auto_controls . '" data-delay="' . $auto_delay . '" data-hover="' . $auto_hover . '" data-barprogress="' . $auto_progress . '" data-barposition="' . $auto_position . '" data-barcolor="' . $auto_color . '" data-barheight="' . $auto_height . '"';
				$output .= '<div id="' . $slitslider_id . '" class="' . $css_class . ' clearFixMe ' . (($fullwidth == "true" && $fullwidth_allow == "true") ? "ts-lightbox-nacho-full-frame" : "")  . '" ' . $data_pageheight . ' ' . $data_general . ' ' . $data_fullwidth . ' ' . $data_navigation . ' ' . $data_autoplay . ' style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; height: ' . $height . 'px;">';
					$output .= '<img class="ts-slit-slider-loader" src="' . TS_VCSC_GetResourceURL('images/other/ajax_loader.gif') . '" style="">';
					$output .= '<div class="ts-slit-slider ts-slit-slider-slides clearFixMe" style="width: 100%; height: 100%; display: none;">';
						$output .= do_shortcode($content);
					$output .= '</div>';
					// Left / Right Navigation
					if ($nav_arrows == 'true') {
						$output .= '<nav id="nav-arrows-' . $slitslider_random . '" class="nav-arrows" style="display: none;">';
							$output .= '<span class="nav-arrow-prev" style="text-indent: -90000px;">Previous</span>';
							$output .= '<span class="nav-arrow-next" style="text-indent: -90000px;">Next</span>';
						$output .= '</nav>';
					}
					// Auto-Play Controls
					if (($auto_play == 'true') && ($auto_controls == 'true')) {
						$output .= '<nav id="nav-auto-' . $slitslider_random . '" class="nav-auto" style="display: none;">';
							$output .= '<span class="nav-auto-play" style="display: none; text-indent: -90000px;">Play</span>';
							$output .= '<span class="nav-auto-pause" style="text-indent: -90000px;">Pause</span>';
						$output .= '</nav>';
					}
					// Navigation Dots
					if ($nav_dots == 'true') {
						$output .= '<nav id="nav-dots-' . $slitslider_random . '" class="nav-dots"></nav>';
					}
				$output .= '</div>';
			} else {
				if ($margin_top < 35) {
					$margin_top					= 35;
				}
				$output .= '<div id="' . $slitslider_id . '" class="ts-slit-slider-frontend clearFixMe" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
					$output .= '<div class="ts-slit-slider ts-slit-slider-slides clearFixMe" style="">';
						$output .= do_shortcode($content);
					$output .= '</div>';
				$output .= '</div>';
			}
			
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
	
		// Add SlitSlider Elements
        function TS_VCSC_Add_iPresenter_Elements() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			// Add Single SlitSlider Item
			if (function_exists('vc_map')) {
				vc_map( array(
					"name"                      		=> __( "TS SlitSlider Item", "ts_visual_composer_extend" ),
					"base"                      		=> "TS_VCSC_SlitSlider_Item",
					"icon" 	                    		=> "icon-wpb-ts_vcsc_slitslider_item",
					"class"                     		=> "",
					"content_element"					=> true,
					"as_child"							=> array('only' => 'TS_VCSC_SlitSlider_Container'),
					"category"                  		=> __( 'VC Extensions', "ts_visual_composer_extend" ),
					"description"               		=> __("Place a single iPresenter item", "ts_visual_composer_extend"),
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
					"params"                    		=> array(
						// Main Settings
						array(
							"type"              		=> "seperator",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "seperator_1",
							"value"						=> "",
							"seperator"					=> "Slide Background",
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"						=> "dropdown",
							"heading"					=> __( "Background Type", "ts_visual_composer_extend" ),
							"param_name"				=> "background",
							"width"						=> 150,
							"value"						=> array(
								__( "Image", "ts_visual_composer_extend" )					=> "image",
								__( "Color", "ts_visual_composer_extend" )					=> "color",
								__( "Gradient", "ts_visual_composer_extend" )				=> "gradient",	
							),
							"description"				=> __( "Select the type of background you want to apply to the slide.", "ts_visual_composer_extend" ),							
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Background Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "color",
							"value"             		=> "#cccccc",
							"description"       		=> __( "Define the background color for the slide.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array( 'element' => "background", 'value' => 'color' ),
						),
						array(
							"type" 						=> "advanced_gradient",
							"class" 					=> "",
							"heading" 					=> __("Background Gradient", "ts_visual_composer_extend"),						
							"param_name" 				=> "gradient",
							"description" 				=> __('Define the background gradient for the slide.', 'ts_visual_composer_extend'),
							"dependency" 				=> array(
								"element" 	=> "gradiant_advanced",
								"value" 	=> "true"
							),
							"dependency"		    	=> array( 'element' => "background", 'value' => 'gradient' ),
						),
						array(
							"type"                  	=> "attach_image",
							"holder" 					=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? "img" : ""),
							"heading"              	 	=> __( "Background Image", "ts_visual_composer_extend" ),
							"param_name"            	=> "image",
							"class"						=> "ts_vcsc_holder_image",
							"value"                 	=> "",
							"admin_label"           	=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? false : true),
							"description"           	=> __( "Select the image you want to use for the slide background.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array( 'element' => "background", 'value' => 'image' ),
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Animation Type", "ts_visual_composer_extend" ),
							"param_name"        		=> "kenburns_effect",
							"width"             		=> 300,
							"value"             		=> array(
								__( "None", "ts_visual_composer_extend" )							=> "",
								__( "Random", "ts_visual_composer_extend" )							=> "random",
								__( "KenBurns Center", "ts_visual_composer_extend" )				=> "kenburns",
								__( "KenBurns Left", "ts_visual_composer_extend" )					=> "kenburnsLeft",
								__( "KenBurns Right", "ts_visual_composer_extend" )					=> "kenburnsRight",
								__( "KenBurns Up", "ts_visual_composer_extend" )					=> "kenburnsUp",						
								__( "KenBurns Up Left", "ts_visual_composer_extend" )				=> "kenburnsUpLeft",
								__( "KenBurns Up Right", "ts_visual_composer_extend" )				=> "kenburnsUpRight",
								__( "KenBurns Down", "ts_visual_composer_extend" )					=> "kenburnsDown",
								__( "KenBurns Down Left", "ts_visual_composer_extend" )				=> "kenburnsDownLeft",						
								__( "KenBurns Down Right", "ts_visual_composer_extend" )			=> "kenburnsDownRight",
							),
							"admin_label"				=> true,
							"dependency"		    	=> array( 'element' => "background", 'value' => array('image', 'gradient') ),
							"description"           	=> __( "Select the animation type to be applied to each slide while shown.", "ts_visual_composer_extend" ),
						),
						// Split Settings
						array(
							"type"              		=> "seperator",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "seperator_2",
							"value"						=> "",
							"seperator"					=> "Split Settings",
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"						=> "dropdown",
							"heading"					=> __( "Split Direction", "ts_visual_composer_extend" ),
							"param_name"				=> "orientation",
							"width"						=> 150,
							"value"						=> array(
								__( "Horizontal", "ts_visual_composer_extend" )				=> "horizontal",
								__( "Vertical", "ts_visual_composer_extend" )				=> "vertical",
							),
							"admin_label"           	=> true,
							"description"				=> __( "Select in which direction the slide should split and transition to the next slide.", "ts_visual_composer_extend" ),
						),						
						array(
							"type"              		=> "nouislider",
							"heading"           		=> __( "Rotation Slit 1", "ts_visual_composer_extend" ),
							"param_name"        		=> "rotation1",
							"value"             		=> "-25",
							"min"               		=> "-90",
							"max"               		=> "90",
							"step"              		=> "1",
							"unit"              		=> "",
							"description"       		=> __( "Define the rotation level for the first slit of this slide.", "ts_visual_composer_extend" ),
						),
						array(
							"type"              		=> "nouislider",
							"heading"           		=> __( "Scale Slit 1", "ts_visual_composer_extend" ),
							"param_name"        		=> "scale1",
							"value"             		=> "200",
							"min"               		=> "100",
							"max"               		=> "300",
							"step"              		=> "10",
							"unit"              		=> "",
							"description"       		=> __( "Define the scale level for the first slit of this slide.", "ts_visual_composer_extend" ),
						),
						array(
							"type"              		=> "nouislider",
							"heading"           		=> __( "Rotation Slit 2", "ts_visual_composer_extend" ),
							"param_name"        		=> "rotation2",
							"value"             		=> "-25",
							"min"               		=> "-90",
							"max"               		=> "90",
							"step"              		=> "1",
							"unit"              		=> "",
							"description"       		=> __( "Define the rotation level for the second slit of this slide.", "ts_visual_composer_extend" ),
						),
						array(
							"type"              		=> "nouislider",
							"heading"           		=> __( "Scale Slit 2", "ts_visual_composer_extend" ),
							"param_name"        		=> "scale2",
							"value"             		=> "200",
							"min"               		=> "100",
							"max"               		=> "300",
							"step"              		=> "10",
							"unit"              		=> "",
							"description"       		=> __( "Define the scale level for the second slit of this slide.", "ts_visual_composer_extend" ),
						),
						// Content Settings
						array(
							"type"              		=> "seperator",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "seperator_3",
							"value"						=> "",
							"seperator"					=> "Slide Content",
							"description"       		=> __( "", "ts_visual_composer_extend" ),
							"group" 					=> "Content Settings",
						),
						array(
							'type' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
							'heading' 					=> __( 'Icon', 'ts_visual_composer_extend' ),
							'param_name' 				=> 'icon',
							'value'						=> '',
							'source'					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorValue,
							'settings' 					=> array(
								'emptyIcon' 					=> true,
								'type' 							=> 'extensions',
								'iconsPerPage' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
								'source' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorSource,
							),
							"description"       		=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select an optional icon for the slide.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
							"group" 					=> "Content Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "Title", "ts_visual_composer_extend" ),
							"param_name"        		=> "title",
							"class"						=> "",
							"value"             		=> "",
							"admin_label"           	=> true,
							"description"       		=> __( "Enter a title for the slide.", "ts_visual_composer_extend" ),
							"group" 					=> "Content Settings",
						),
						array(
							"type"						=> "textarea_html",
							"class"						=> "",
							"heading"					=> __( "Content", "ts_visual_composer_extend" ),
							"param_name"				=> "content",
							"value"						=> "",
							"description"				=> __( "Create the content for the slide.", "ts_visual_composer_extend" ),
							"group" 					=> "Content Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "Citation", "ts_visual_composer_extend" ),
							"param_name"        		=> "cite",
							"class"						=> "",
							"value"             		=> "",
							"description"       		=> __( "Enter an optional citation text for the slide.", "ts_visual_composer_extend" ),
							"group" 					=> "Content Settings",
						),
						// Icon Styling
						array(
							"type"              		=> "seperator",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "seperator_4",
							"value"						=> "",
							"seperator"					=> "Icon Style",
							"description"       		=> __( "", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Icon Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "icon_color",
							"value"             		=> "#4e4e4d",
							"description"       		=> __( "Define the color for the slide icon.", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Icon Border", "ts_visual_composer_extend" ),
							"param_name"        		=> "icon_border",
							"value"             		=> "rgba(150, 150, 150, 0.4)",
							"description"       		=> __( "Define the color for the border around the slide icon.", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Icon Shadow", "ts_visual_composer_extend" ),
							"param_name"        		=> "icon_shadow",
							"value"             		=> "#f7f7f7",
							"description"       		=> __( "Define the inner shadow color for the slide icon.", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						// Title Styling
						array(
							"type"              		=> "seperator",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "seperator_5",
							"value"						=> "",
							"seperator"					=> "Title Style",
							"description"       		=> __( "", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						array(
							"type"						=> "fontsmanager",
							"heading"					=> __( "Title Font Family", "ts_visual_composer_extend" ),
							"param_name"				=> "font_title_family",
							"value"						=> "",
							"default"					=> "true",
							"connector"					=> "font_title_type",
							"description"				=> __( "Select the font to be used for the title text.", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						array(
							"type"						=> "hidden_input",
							"param_name"				=> "font_title_type",
							"value"						=> "",
							"description"				=> __( "", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Title Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "title_color",
							"value"             		=> "#ffffff",
							"description"       		=> __( "Define the font color for the title text.", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Title Text Align", "ts_visual_composer_extend" ),
							"param_name"        		=> "title_align",
							"width"             		=> 150,
							"value"             		=> array(
								__( "Center", "ts_visual_composer_extend" )                        	=> "center",
								__( "Left", "ts_visual_composer_extend" )                          	=> "left",
								__( "Right", "ts_visual_composer_extend" )                         	=> "right",
								__( "Justify", "ts_visual_composer_extend" )                        => "justify",
							),
							"description"       		=> __( "Select the alignment for slide title.", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						// Content Styling
						array(
							"type"              		=> "seperator",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "seperator_6",
							"value"						=> "",
							"seperator"					=> "Content Style",
							"description"       		=> __( "", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						array(
							"type"						=> "fontsmanager",
							"heading"					=> __( "Content Font Family", "ts_visual_composer_extend" ),
							"param_name"				=> "font_content_family",
							"value"						=> "",
							"default"					=> "true",
							"connector"					=> "font_content_type",
							"description"				=> __( "Select the font to be used for the content text.", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						array(
							"type"						=> "hidden_input",
							"param_name"				=> "font_content_type",
							"value"						=> "",
							"description"				=> __( "", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Content Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "content_color",
							"value"             		=> "#ffffff",
							"description"       		=> __( "Define the color for the content text.", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						array(
							"type"                  	=> "switch_button",
							"heading"			    	=> __( "Add Quotation Sign", "ts_visual_composer_extend" ),
							"param_name"		    	=> "content_quote",
							"value"                 	=> "false",
							"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
							"style"				    	=> "select",
							"design"			    	=> "toggle-light",
							"description"       		=> __( "Use the switch if you want to add a quotation sign to the content text.", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Quotation Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "content_cite",
							"value"             		=> "rgba(61, 61, 61, 0.65)",
							"description"       		=> __( "Define the color for the quotation sign.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array( 'element' => "content_quote", 'value' => 'true' ),
							"group" 					=> "Style Settings",
						),						
						// Citation Styling
						array(
							"type"              		=> "seperator",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "seperator_7",
							"value"						=> "",
							"seperator"					=> "Citation Style",
							"description"       		=> __( "", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						array(
							"type"						=> "fontsmanager",
							"heading"					=> __( "Citation Font Family", "ts_visual_composer_extend" ),
							"param_name"				=> "font_cite_family",
							"value"						=> "",
							"default"					=> "true",
							"connector"					=> "font_cite_type",
							"description"				=> __( "Select the font to be used for the citation text.", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						array(
							"type"						=> "hidden_input",
							"param_name"				=> "font_cite_type",
							"value"						=> "",
							"description"				=> __( "", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Citation Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "cite_color",
							"value"             		=> "#4e4e4d",
							"description"       		=> __( "Define the font color for the citation text.", "ts_visual_composer_extend" ),
							"group" 					=> "Style Settings",
						),
						// Link Settings
						array(
							"type"              		=> "seperator",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "seperator_8",
							"value"						=> "",
							"seperator"					=> "Link Settings",
							"description"       		=> __( "", "ts_visual_composer_extend" ),
							"group" 					=> "Link Settings",
						),
						array(
							"type" 						=> "vc_link",
							"heading" 					=> __("Link + Title", "ts_visual_composer_extend"),
							"param_name" 				=> "link_slide",
							"description" 				=> __("Provide a link to another site/page to be used for this slide.", "ts_visual_composer_extend"),
							"group" 					=> "Link Settings",
						),
						array(
							"type"						=> "dropdown",
							"heading"					=> __( "Link Wrapper", "ts_visual_composer_extend" ),
							"param_name"				=> "link_wrapper",
							"width"						=> 150,
							"value"						=> array(
								__( "Button", "ts_visual_composer_extend" )							=> "button",
								__( "Title", "ts_visual_composer_extend" )							=> "title",
								__( "Button + Title", "ts_visual_composer_extend" )					=> "both",	
							),
							"description"				=> __( "Select the how the link should be embedded into the slide.", "ts_visual_composer_extend" ),
							"group" 					=> "Link Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "Button Text", "ts_visual_composer_extend" ),
							"param_name"        		=> "link_text",
							"value"             		=> "Learn More",
							"description"       		=> __( "Enter the text to be shown in the link button.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "link_wrapper", 'value' => array('button', 'both') ),
							"group" 					=> "Link Settings",
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Button Align", "ts_visual_composer_extend" ),
							"param_name"        		=> "link_align",
							"width"             		=> 150,
							"value"             		=> array(								
								__( "Left", "ts_visual_composer_extend" )                          	=> "left",
								__( "Center", "ts_visual_composer_extend" )                        	=> "center",
								__( "Right", "ts_visual_composer_extend" )                         	=> "right",
							),
							"description"       		=> __( "Select the alignment for link button.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "link_wrapper", 'value' => array('button', 'both') ),
							"group" 					=> "Link Settings",
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Button Style", "ts_visual_composer_extend" ),
							"param_name"        		=> "link_style",
							"width"             		=> 300,
							"value"             		=> array(
								__( 'Transparent Button', "ts_visual_composer_extend" )          	=> "empty",
								__( 'Full Button', "ts_visual_composer_extend" )					=> "full",
							),
							"description"       		=> __( "Select the type of button for the link.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "link_wrapper", 'value' => array('button', 'both') ),
							"group" 					=> "Link Settings",
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Button Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "link_color",
							"width"             		=> 300,
							"value"             		=> array(
								__( 'White', "ts_visual_composer_extend" )          				=> "white",
								__( 'Gray', "ts_visual_composer_extend" )          					=> "gray",
								__( 'Blue', "ts_visual_composer_extend" )							=> "blue",
								__( 'Green', "ts_visual_composer_extend" )							=> "green",								
								__( 'Red', "ts_visual_composer_extend" )							=> "red",
								__( 'Purple', "ts_visual_composer_extend" )							=> "purple",
								__( 'Orange', "ts_visual_composer_extend" )							=> "orange",
								__( 'Yellow', "ts_visual_composer_extend" )							=> "yellow",
							),
							"description"       		=> __( "Select the button color scheme for the link.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "link_wrapper", 'value' => array('button', 'both') ),
							"group" 					=> "Link Settings",
						),
						// Load Custom CSS/JS File
						array(
							"type"              		=> "load_file",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "el_file",
							"value"             		=> "",
							"file_type"         		=> "js",
							"file_path"         		=> "js/ts-visual-composer-extend-element.min.js",
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),
					))
				);
			}
			// Add Navigation Container
			if (function_exists('vc_map')) {
				vc_map(array(
				    "name"                              => __("TS SlitSlider", "ts_visual_composer_extend"),
				    "base"                              => "TS_VCSC_SlitSlider_Container",
				    "class"                             => "",
				    "icon"                              => "icon-wpb-ts_vcsc_slitslider_container",
				    "category"                          => __("VC Extensions", "ts_visual_composer_extend"),
				    "as_parent"                         => array('only' => 'TS_VCSC_SlitSlider_Item'),
				    "description"                       => __("Build a SlitSlider Element", "ts_visual_composer_extend"),
					"controls" 							=> "full",
					"content_element"                   => true,
					"is_container" 						=> true,
					"container_not_allowed" 			=> false,
					"show_settings_on_create"           => true,
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
				    "params"                            => array(
						// SlitSlider Settings
						array(
							"type"						=> "seperator",
							"heading"					=> __( "", "ts_visual_composer_extend" ),
							"param_name"				=> "seperator_1",
							"value"						=> "",
							"seperator"					=> "General Settings",
							"description"				=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"						=> "dropdown",
							"heading"					=> __( "Background Type", "ts_visual_composer_extend" ),
							"param_name"				=> "type",
							"width"						=> 150,
							"value"						=> array(
								__( "Fixed Height", "ts_visual_composer_extend" )					=> "fixed",
								__( "Full Page Height", "ts_visual_composer_extend" )				=> "page",	
							),
							"description"				=> __( "Select the size setting for the slider.", "ts_visual_composer_extend" ),							
						),
						array(
							"type"              		=> "nouislider",
							"heading"           		=> __( "Slider Fixed Height", "ts_visual_composer_extend" ),
							"param_name"        		=> "height",
							"value"             		=> "600",
							"min"               		=> "400",
							"max"               		=> "1024",
							"step"              		=> "1",
							"unit"              		=> "px",
							"description"       		=> __( "Define the height for the SlitSlider element.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array( 'element' => "type", 'value' => 'fixed' ),
						),
						array(
							"type" 						=> "devicetype_selectors",
							"heading"           		=> __( "Device Type Offset", "ts_visual_composer_extend" ),
							"param_name"        		=> "offset",
							"unit"  					=> "px",
							"collapsed"					=> "false",
							"devices" 					=> array(
								"Desktop"           			=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
								"Tablet"            			=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
								"Mobile"            			=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
							),
							"description"				=> __( "Define an additional offset to account for menu bars and other top fixed elements.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "type", 'value' => 'page' ),
						),
						array(
							"type"              		=> "nouislider",
							"heading"           		=> __( "Slider Minimum Height", "ts_visual_composer_extend" ),
							"param_name"        		=> "mimimum",
							"value"             		=> "600",
							"min"               		=> "400",
							"max"               		=> "1024",
							"step"              		=> "1",
							"unit"              		=> "px",
							"description"       		=> __( "Define the minimum height for the SlitSlider element.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array( 'element' => "type", 'value' => 'page' ),
						),
						array(
							"type"              		=> "nouislider",
							"heading"           		=> __( "Transition Speed", "ts_visual_composer_extend" ),
							"param_name"        		=> "speed",
							"value"             		=> "1200",
							"min"               		=> "200",
							"max"               		=> "4000",
							"step"              		=> "100",
							"unit"              		=> "ms",
							"description"       		=> __( "Define the transition speed between two slides.", "ts_visual_composer_extend" ),
						),
						// NiceScroll Settings
						array(
							"type"                  	=> "switch_button",
							"heading"			    	=> __( "Use NiceScroll", "ts_visual_composer_extend" ),
							"param_name"		    	=> "nicescroll",
							"value"                 	=> "true",
							"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
							"style"				    	=> "select",
							"design"			    	=> "toggle-light",
							"admin_label"				=> true,
							"description"		    	=> __( "Switch the toggle if you want to use the NiceScroll script in order to style any content scrollbars.", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Scrollbar Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "scrollcolor",
							"value"             		=> "#ededed",
							"description"       		=> __( "Define the background color for the scrollbar.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array( 'element' => "nicescroll", 'value' => 'true' ),
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Scrollbar Border", "ts_visual_composer_extend" ),
							"param_name"        		=> "scrollborder",
							"value"             		=> "#f7f7f7",
							"description"       		=> __( "Define the border color for the scrollbar.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array( 'element' => "nicescroll", 'value' => 'true' ),
						),						
						// Full Width Settings
						array(
							"type"						=> "seperator",
							"heading"					=> __( "", "ts_visual_composer_extend" ),
							"param_name"				=> "seperator_2",
							"value"						=> "",
							"seperator"					=> "Full Width Settings",
							"description"				=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"                  	=> "switch_button",
							"heading"			    	=> __( "Full Width Slider", "ts_visual_composer_extend" ),
							"param_name"		    	=> "fullwidth",
							"value"                 	=> "false",
							"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
							"style"				    	=> "select",
							"design"			    	=> "toggle-light",
							"admin_label"				=> true,
							"description"		    	=> __( "Switch the toggle if you want to attempt to make the slider full width.", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
						),
						array(
							"type"						=> "nouislider",
							"heading"					=> __( "Full Width Breakouts", "ts_visual_composer_extend" ),
							"param_name"				=> "breakouts",
							"value"						=> "6",
							"min"						=> "0",
							"max"						=> "99",
							"step"						=> "1",
							"unit"						=> '',
							"description"				=> __( "Define the number of parent containers the slider should attempt to break away from.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array( 'element' => "fullwidth", 'value' => 'true' ),
						),
						// Controls Settings
						array(
							"type"                      => "seperator",
							"heading"                   => __( "", "ts_visual_composer_extend" ),
							"param_name"                => "seperator_3",
							"value"						=> "",
							"seperator"                 => "Controls Settings",
							"description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Controls Settings",
						),
						array(
							"type"                  	=> "switch_button",
							"heading"			    	=> __( "Dots Navigation", "ts_visual_composer_extend" ),
							"param_name"		    	=> "nav_dots",
							"value"                 	=> "true",
							"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
							"style"				    	=> "select",
							"design"			    	=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to provide dot navigation controls.", "ts_visual_composer_extend" ),
							"group" 			        => "Controls Settings",
						),
						array(
							"type"                  	=> "switch_button",
							"heading"			    	=> __( "Arrows Navigation", "ts_visual_composer_extend" ),
							"param_name"		    	=> "nav_arrows",
							"value"                 	=> "true",
							"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
							"style"				    	=> "select",
							"design"			    	=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to provide left/right arrow navigation controls.", "ts_visual_composer_extend" ),
							"group" 			        => "Controls Settings",
						),
						array(
							"type"                  	=> "switch_button",
							"heading"			    	=> __( "Keyboard Navigation", "ts_visual_composer_extend" ),
							"param_name"		    	=> "nav_keys",
							"value"                 	=> "true",
							"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
							"style"				    	=> "select",
							"design"			    	=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to allow for keyboard navigation via left/right buttons.", "ts_visual_composer_extend" ),
							"group" 			        => "Controls Settings",
						),
						array(
							"type"                  	=> "switch_button",
							"heading"			    	=> __( "Touch Navigation", "ts_visual_composer_extend" ),
							"param_name"		    	=> "nav_touch",
							"value"                 	=> "true",
							"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
							"style"				    	=> "select",
							"design"			    	=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to allow for a touch and swipe navigation on supported devices.", "ts_visual_composer_extend" ),
							"group" 			        => "Controls Settings",
						),
						// AutoPlay Settings
						array(
							"type"                      => "seperator",
							"heading"                   => __( "", "ts_visual_composer_extend" ),
							"param_name"                => "seperator_4",
							"value"						=> "",
							"seperator"                 => "AutoPlay Settings",
							"description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "AutoPlay Settings",
						),
						array(
							"type"                  	=> "switch_button",
							"heading"			    	=> __( "AutoPlay Slider", "ts_visual_composer_extend" ),
							"param_name"		    	=> "auto_play",
							"value"                 	=> "false",
							"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
							"style"				    	=> "select",
							"design"			    	=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to apply an auto-play feature to the slider.", "ts_visual_composer_extend" ),
							"group" 			        => "AutoPlay Settings",
						),
						array(
							"type"                  	=> "switch_button",
							"heading"			    	=> __( "AutoPlay Controls", "ts_visual_composer_extend" ),
							"param_name"		    	=> "auto_controls",
							"value"                 	=> "true",
							"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
							"style"				    	=> "select",
							"design"			    	=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to provide play/pause control buttons.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array( 'element' => "auto_play", 'value' => 'true' ),
							"group" 			        => "AutoPlay Settings",
						),
						array(
							"type"                  	=> "switch_button",
							"heading"			    	=> __( "Pause On Hover", "ts_visual_composer_extend" ),
							"param_name"		    	=> "auto_hover",
							"value"                 	=> "true",
							"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
							"style"				    	=> "select",
							"design"			    	=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to pause the autoplay when hovering over the slider.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array( 'element' => "auto_play", 'value' => 'true' ),
							"group" 			        => "AutoPlay Settings",
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "AutoPlay Delay", "ts_visual_composer_extend" ),
							"param_name"                => "auto_delay",
							"value"                     => "4000",
							"min"                       => "1000",
							"max"                       => "10000",
							"step"                      => "100",
							"unit"                      => 'ms',
							"description"               => __( "Define the delay between each slide transition.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array( 'element' => "auto_play", 'value' => 'true' ),
							"group" 			        => "AutoPlay Settings",
						),
						array(
							"type"                  	=> "switch_button",
							"heading"			    	=> __( "AutoPlay Progressbar", "ts_visual_composer_extend" ),
							"param_name"		    	=> "auto_progress",
							"value"                 	=> "true",
							"on"				    	=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"				    	=> __( 'No', "ts_visual_composer_extend" ),
							"style"				    	=> "select",
							"design"			    	=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to show a progressbar for the autoplay timer.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array( 'element' => "auto_play", 'value' => 'true' ),
							"group" 			        => "AutoPlay Settings",
						),
						array(
							"type"						=> "dropdown",
							"heading"					=> __( "Progressbar Position", "ts_visual_composer_extend" ),
							"param_name"				=> "auto_position",
							"width"						=> 150,
							"value"						=> array(
								__( "Top", "ts_visual_composer_extend" )						=> "top",
								__( "Bottom", "ts_visual_composer_extend" )						=> "bottom",	
							),
							"description"               => __( "Select the position of the progressbar for the autoplay timer.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array( 'element' => "auto_progress", 'value' => 'true' ),
							"group" 			        => "AutoPlay Settings",							
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Progressbar Height", "ts_visual_composer_extend" ),
							"param_name"                => "auto_height",
							"value"                     => "2",
							"min"                       => "1",
							"max"                       => "10",
							"step"                      => "1",
							"unit"                      => 'px',
							"description"               => __( "Select the height of the progressbar for the autoplay timer.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array( 'element' => "auto_progress", 'value' => 'true' ),
							"group" 			        => "AutoPlay Settings",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Progressbar Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "auto_color",
							"value"             		=> "#333333",
							"description"               => __( "Select the color of the progressbar for the autoplay timer.", "ts_visual_composer_extend" ),
							"dependency"		    	=> array( 'element' => "auto_progress", 'value' => 'true' ),
							"group" 			        => "AutoPlay Settings",
						),
						// Other Settings
						array(
							"type"                      => "seperator",
							"heading"                   => __( "", "ts_visual_composer_extend" ),
							"param_name"                => "seperator_5",
							"value"						=> "",
							"seperator"                 => "Other Settings",
							"description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Other Settings",
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Margin: Top", "ts_visual_composer_extend" ),
							"param_name"                => "margin_top",
							"value"                     => "0",
							"min"                       => "0",
							"max"                       => "200",
							"step"                      => "1",
							"unit"                      => 'px',
							"description"               => __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
							"group" 			        => "Other Settings",
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Margin: Bottom", "ts_visual_composer_extend" ),
							"param_name"                => "margin_bottom",
							"value"                     => "0",
							"min"                       => "0",
							"max"                       => "200",
							"step"                      => "1",
							"unit"                      => 'px',
							"description"               => __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
							"group" 			        => "Other Settings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Define ID Name", "ts_visual_composer_extend" ),
							"param_name"                => "el_id",
							"value"                     => "",
							"description"               => __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
							"group" 			        => "Other Settings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Extra Class Name", "ts_visual_composer_extend" ),
							"param_name"                => "el_class",
							"value"                     => "",
							"description"               => __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
							"group" 			        => "Other Settings",
						),
						// Load Custom CSS/JS File
                        array(
                            "type"                      => "load_file",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "el_file1",
                            "value"                     => "",
                            "file_type"                 => "js",
							"file_id"         			=> "ts-extend-element",
                            "file_path"                 => "js/ts-visual-composer-extend-element.min.js",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
						array(
							"type"              		=> "load_file",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "el_file2",
							"value"             		=> "",
							"file_type"         		=> "css",
							"file_id"         			=> "ts-extend-animations",
							"file_path"         		=> "css/ts-visual-composer-extend-animations.min.css",
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),
					),
					"js_view"                           => 'VcColumnView'
				));
			}
		}
	}
}
// Register Container and Child Shortcode with Visual Composer
if (class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_TS_VCSC_SlitSlider_Container extends WPBakeryShortCodesContainer {};
}
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_TS_VCSC_SlitSlider_Item extends WPBakeryShortCode {};
}
// Initialize "TS Figure Navigation" Class
if (class_exists('TS_SlitSlider')) {
	$TS_SlitSlider = new TS_SlitSlider;
}