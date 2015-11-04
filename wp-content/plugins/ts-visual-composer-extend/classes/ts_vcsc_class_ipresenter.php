<?php
if (!class_exists('TS_iPresenter')){
	class TS_iPresenter {
		function __construct() {
			global $VISUAL_COMPOSER_EXTENSIONS;
            if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
                add_action('init',                              		array($this, 'TS_VCSC_Add_iPresenter_Elements'), 9999999);
            } else {
                add_action('admin_init',		                		array($this, 'TS_VCSC_Add_iPresenter_Elements'), 9999999);
            }
			add_shortcode('TS_VCSC_iPresenter_Item',					array($this, 'TS_VCSC_iPresenter_Item'));
			add_shortcode('TS_VCSC_iPresenter_Container',       		array($this, 'TS_VCSC_iPresenter_Container'));
		}

		// Single iPresenter Item
		function TS_VCSC_iPresenter_Item ($atts, $content = null) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend_edit					= 'true';
			} else {
				$frontend_edit					= 'false';
			}
		
			extract( shortcode_atts( array(
				'image'							=> '',
				'title'							=> '',
				'title_color'					=> '#4e4e4d',				
				// Button
				'button_link'					=> '',
				'button_color'					=> '',
				'button_icon'					=> '',
				'button_text'					=> 'Read More',				
				// Lightbox
				'lightbox_image'				=> 'true',
				'lightbox_group'				=> 'true',
				'lightbox_group_name'			=> '',
				'lightbox_size'					=> 'full',
				'lightbox_effect'				=> 'random',
				'lightbox_speed'				=> 5000,
				'lightbox_social'				=> 'true',
				'lightbox_backlight'			=> 'auto',
				'lightbox_backlight_color'		=> '#ffffff',
				// Animation
				'custom_time'					=> 'false',
				'easing'						=> 'ease-in-out',
				'pause_time'					=> 5000,
				'custom_animation'				=> 'false',
				'translate_x'					=> 0,
				'translate_y'					=> 0,
				'translate_z'					=> 0,
				'rotate_x'						=> 0,
				'rotate_y'						=> 0,
				'rotate_z'						=> 0,
				'scale'							=> 1,
				// Other
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			), $atts ));
			
			$ipresenter_random					= mt_rand(999999, 9999999);
	
			// Images
			$ipresenter_image					= wp_get_attachment_image_src($image, 'full');
			$thumbnail_image					= wp_get_attachment_image_src($image, 'medium');

			$output = $animation = '';
			
			// Link Values
			$button_link 						= ($button_link=='||') ? '' : $button_link;
			$link 								= vc_build_link($button_link);
			$a_href								= $link['url'];
			$a_title 							= $link['title'];
			$a_target 							= $link['target'];
			if ($frontend_edit == 'true') {
				$a_target						= "_blank";
			}

			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-teaser ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_iPresenter_Item', $atts);
			} else {
				$css_class	= 'ts-teaser ' . $el_class;
			}
			
			if ($lightbox_backlight == "auto") {
				$nacho_color					= '';
			} else if ($lightbox_backlight == "custom") {
				$nacho_color					= 'data-color="' . $lightbox_backlight_color . '"';
			} else if ($lightbox_backlight == "hideit") {
				$nacho_color					= 'data-color="rgba(0, 0, 0, 0)"';
			}
			
			if ($custom_time == "true") {
				$pausetime						= '';
			} else {
				$pausetime						= 'data-pausetime="' . $pause_time . '"';
			}

			if ($custom_animation == "true") {
				$animation						= '' . $pausetime . ' data-easing="ease-in-out" data-x="' . $translate_x . '" data-y="' . $translate_y . '" data-z="' . $translate_z . '" data-scale="' . $scale . '" data-rotate-x="' . $rotate_x . '" data-rotate-y="' . $rotate_y . '" 	data-rotate-z="' . $rotate_z . '" data-rotate="' . $rotate_z . '"';
			} else {
				$animation						= '' . $pausetime . ' data-easing="ease-in-out"';
			}
			
			$output .= '<div class="ts-ipresenter-step clearFixMe" ' . $animation . ' data-thumbnail="' . $thumbnail_image[0] . '">';
				if (($lightbox_image == "true") && ($frontend_edit == "false")) {
					$output .= '<a href="' . $ipresenter_image[0] . '" class="ts-ipresenter-lightbox nch-lightbox-media no-ajaxy" data-title="' . $title . '" rel="' . ($lightbox_group == "true" ? "nachogroup" : $lightbox_group_name) . '" data-effect="' . $lightbox_effect . '" data-duration="' . $lightbox_speed . '" ' . $nacho_color . '>';
				}
					$output .= '<img class="ts-ipresenter-image" src="' . $ipresenter_image[0] . '" data-no-lazy="1" />';
				if (($lightbox_image == "true") && ($frontend_edit == "false")) {
					$output .= '</a>';
				}
				$output .= '<h2 class="ts-ipresenter-title clearFixMe" style="color: ' . $title_color . ';">' . $title . '</h2>';
				$output .= '<div class="ts-ipresenter-text clearFixMe" style="">';
					$output .= wpb_js_remove_wpautop(do_shortcode($content), true);
				$output .= '</div>';
				if (($button_text != '') && ($button_link != '')) {
					$output .= '<div class="ts-ipresenter-button clearFixMe">';
						$output .= '<a href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '" class="ts-color-button-container ' . $button_color . '">';
							if (($button_icon != '') && ($button_icon != 'transparent')) {
								$output .= '<span class="ts-color-button-icon ' . $button_icon . '"></span>';
							}
							$output .= '<span class="ts-color-button-title">' . $button_text . '</span>';
						$output .= '</a>';
					$output .= '</div>';
				}
			$output .= '</div>';
	
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
		
		// iPresenter Container
		function TS_VCSC_iPresenter_Container ($atts, $content = null){
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();
			
			// Check for Front End Editor
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend_edit					= 'true';
			} else {
				$frontend_edit					= 'false';
			}

			if ($frontend_edit == "false") {
				wp_enqueue_script('ts-extend-hammer');
				wp_enqueue_script('ts-extend-nacho');
				wp_enqueue_style('ts-extend-nacho');
				wp_enqueue_style('ts-extend-ipresenter');
				wp_enqueue_script('ts-extend-ipresenter');
				wp_enqueue_style('ts-extend-buttonsflat');
				wp_enqueue_script('ts-visual-composer-extend-front');
			} else {
				wp_enqueue_style('ts-extend-ipresenter');
				wp_enqueue_style('ts-extend-buttonsflat');
			}
			
			extract( shortcode_atts( array(
				// General
				'autoheight'					=> 'true',
				'fixedheight'					=> 'false',
				'setheight'						=> 650,
				'animation_allow'				=> 'true',
				'animation_speed'				=> 1000,
				'random_start'					=> 'false',
				'zoomeffect'					=> 'true',
				// Autoplay
				'autoplay'						=> 'true',
				'play_viewport'					=> 'true',
				'play_mobile'					=> 'false',
				'play_position'					=> 'top-left',
				'replay'						=> 'true',
				'pause_on_hover'				=> 'true',
				'pause_time'					=> 5000,
				// Timer
				'timer'							=> '360Bar',
				'timer_position'				=> 'top-right',
				'timer_diameter'				=> 40,
				'timer_background'				=> '#0066bf',
				'timer_color'					=> '#ffffff',
				'timer_opacity'					=> 50,
				// Navigation
				'direction_nav'					=> 'true',
				'bottom_nav'					=> 'thumbs',			
				'keyboard_nav'					=> 'true',
				'touch_nav'						=> 'true',
				// Other
				'margin_top'                    => 0,
				'margin_bottom'                 => 0,
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			), $atts ));
			
			$ipresenter_random					= mt_rand(999999, 9999999);
			$output = '';
			
			if (!empty($el_id)) {
				$ipresenter_id					= $el_id;
			} else {
				$ipresenter_id					= 'ts-vcsc-ipresenter-container-wrap-' . $ipresenter_random;
			}
			
			$cotrol_nav							= "false";
			$control_nav_nextprev				= "false";
			$control_nav_thumbs					= "false";
			$control_nav_tooltip				= "false";
			if ($bottom_nav == "thumbs") {
				$control_nav					= "true";
				$control_nav_nextprev			= "false";
				$control_nav_thumbs				= "true";
				$control_nav_tooltip			= "false";
			} else if ($bottom_nav == "dots") {
				$control_nav					= "true";
				$control_nav_nextprev			= "false";
				$control_nav_thumbs				= "false";
				$control_nav_tooltip			= "false";
			} else if ($bottom_nav == "dotsthumbs") {
				$control_nav					= "true";
				$control_nav_nextprev			= "false";
				$control_nav_thumbs				= "false";
				$control_nav_tooltip			= "true";
			}
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-ipresenter-container-wrap ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_iPresenter_Container', $atts);
			} else {
				$css_class	= 'ts-ipresenter-container-wrap ' . $el_class;
			}
			
			if ($frontend_edit == "false") {
				$general_data					= 'data-allow3d="' . $animation_allow . '" data-autoheight="' . $autoheight . '" data-fixedheight="' . $fixedheight . '" data-setheight="' . $setheight . '" data-height="" data-width="" data-animationspeed="' . $animation_speed . '" data-randomstart="' . $random_start . '" data-zoomeffect="' . $zoomeffect . '"';
				$navigation_data				= 'data-directionnav="' . $direction_nav . '" data-controlnav="' . $control_nav . '" data-controlnavnextprev="' . $control_nav_nextprev . '" data-controlnavthumbs="' . $control_nav_thumbs . '" data-controlnavtooltip="' . $control_nav_tooltip . '" data-keyboardnav="' . $keyboard_nav . '" data-touchnav="' . $touch_nav . '"';
				$autoplay_data					= 'data-autoplay="' . $autoplay . '" data-viewport="' . $play_viewport . '" data-mobile="'  .$play_mobile . '" data-replay="' . $replay . '" data-pausetime="' . $pause_time . '" data-pauseonhover="' . $pause_on_hover . '"';
				$timer_data						= 'data-timer="' . $timer . '" data-timerposition="' . $timer_position . '" data-timerdiameter="' . $timer_diameter . '" data-timerbackground="' . $timer_background . '" data-timercolor="' . $timer_color . '" data-timeropacity="' . $timer_opacity . '"';
				
				$output .= '<div id="' . $ipresenter_id . '" class="' . $css_class . ' clearFixMe" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
					$output .= '<div class="ts-ipresenter-container clearFixMe" style="" ' . $general_data . ' ' . $navigation_data . ' ' . $autoplay_data . ' ' . $timer_data . '>';
						$output .= '<div class="ts-ipresenter-main ' . ($animation_allow == 'true' ? "ts-ipresenter-main-animated" : "ts-ipresenter-main-fade") . ' clearFixMe">';
							$output .= do_shortcode($content);
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
			} else {
				if ($margin_top < 35) {
					$margin_top					= 35;
				}
				$output .= '<div id="' . $ipresenter_id . '" class="' . $css_class . ' clearFixMe" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
					$output .= '<div class="ts-ipresenter-container clearFixMe" style="">';
						$output .= '<div class="ts-ipresenter-main-frontend clearFixMe">';
							$output .= do_shortcode($content);
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';
			}
			
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
	
		// Add iPresenter Elements
        function TS_VCSC_Add_iPresenter_Elements() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			// Add Single iPresenter Item
			if (function_exists('vc_map')) {
				vc_map( array(
					"name"                      		=> __( "TS iPresenter Item", "ts_visual_composer_extend" ),
					"base"                      		=> "TS_VCSC_iPresenter_Item",
					"icon" 	                    		=> "icon-wpb-ts_vcsc_ipresenter_item",
					"class"                     		=> "",
					"content_element"					=> true,
					"as_child"							=> array('only' => 'TS_VCSC_iPresenter_Container'),
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
							"seperator"					=> "Basic Settings",
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"                  	=> "attach_image",
							"holder" 					=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? "img" : ""),
							"heading"              	 	=> __( "Image", "ts_visual_composer_extend" ),
							"param_name"            	=> "image",
							"class"						=> "ts_vcsc_holder_image",
							"value"                 	=> "",
							"admin_label"           	=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorImagePreview == "true" ? false : true),
							"description"           	=> __( "Select the image you want to use for the iPresenter slide.", "ts_visual_composer_extend" )
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Custom Duration", "ts_visual_composer_extend" ),
							"param_name"        		=> "custom_time",
							"value"             		=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to apply a custom duration for an auto-play.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
						),
						array(
							"type"						=> "nouislider",
							"heading"                   => __( "Slide Duration", "ts_visual_composer_extend" ),
							"param_name"                => "pause_time",
							"value"                     => "5000",
							"min"                       => "1000",
							"max"                       => "15000",
							"step"                      => "100",
							"unit"                      => 'ms',
							"description"               => __( "If the presentation is set to auto-play, define a custom duration for this slide.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "custom_time", 'value' => 'true' ),
						),
						// Content Settings
						array(
							"type"              		=> "seperator",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "seperator_2",
							"value"						=> "",
							"seperator"					=> "Navigation Content",
							"description"       		=> __( "", "ts_visual_composer_extend" ),
							"group" 					=> "iPresenter Content",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "Title", "ts_visual_composer_extend" ),
							"param_name"        		=> "title",
							"class"						=> "",
							"value"             		=> "",
							"admin_label"           	=> true,
							"description"       		=> __( "Enter a title for the iPresenter slide.", "ts_visual_composer_extend" ),
							"group" 					=> "iPresenter Content",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Title Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "title_color",
							"value"             		=> "#4e4e4d",
							"description"       		=> __( "Define the font color for the iPresenter title.", "ts_visual_composer_extend" ),
							"group" 					=> "iPresenter Content",
						),
						array(
							"type"						=> "textarea_html",
							"class"						=> "",
							"heading"					=> __( "Content", "ts_visual_composer_extend" ),
							"param_name"				=> "content",
							"value"						=> "",
							"description"				=> __( "Create the content for the iPresenter slide.", "ts_visual_composer_extend" ),
							"dependency"				=> "",
							"group" 					=> "iPresenter Content",
						),
						// Link Settings
						array(
							"type"                  	=> "seperator",
							"heading"               	=> __( "", "ts_visual_composer_extend" ),
							"param_name"            	=> "seperator_3",
							"value"						=> "",
							"seperator"                 => "Link Settings",
							"description"           	=> __( "", "ts_visual_composer_extend" ),
							"group" 					=> "Link Settings",
						),
						array(
							"type" 						=> "vc_link",
							"heading" 					=> __("Link + Title", "ts_visual_composer_extend"),
							"param_name" 				=> "button_link",
							"description" 				=> __("Provide an optional link to another site/page for the slide.", "ts_visual_composer_extend"),
							"dependency"				=> "",
							"group" 					=> "Link Settings",
						),
						array(
							'type' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
							'heading' 					=> __( 'Button Icon', 'ts_visual_composer_extend' ),
							'param_name' 				=> 'button_icon',
							'value'						=> '',
							'source'					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorValue,
							'settings' 					=> array(
								'emptyIcon' 					=> true,
								'type' 							=> 'extensions',
								'iconsPerPage' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
								'source' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorSource,
							),
							"description"       		=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon for the link button.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
							"dependency"            	=> "",
							"group" 					=> "Link Settings",
						),	
						array(
							"type"              		=> "textfield",
							"heading"          			=> __( "Button Text", "ts_visual_composer_extend" ),
							"param_name"        		=> "button_text",
							"value"             		=> "Read More",
							"description"       		=> __( "Enter a title for the link button.", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
							"group" 					=> "Link Settings",
						),
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Button Color", "ts_visual_composer_extend" ),
							"param_name"            	=> "button_color",
							"width"                 	=> 150,
							"value"                 	=> array(
								__( 'No Style', "ts_visual_composer_extend" )				=> "",
								__( 'Sun Flower Flat', "ts_visual_composer_extend" )		=> "ts-color-button-sun-flower",
								__( 'Orange Flat', "ts_visual_composer_extend" )			=> "ts-color-button-orange-flat",
								__( 'Carot Flat', "ts_visual_composer_extend" )     		=> "ts-color-button-carrot-flat",
								__( 'Pumpkin Flat', "ts_visual_composer_extend" )			=> "ts-color-button-pumpkin-flat",
								__( 'Alizarin Flat', "ts_visual_composer_extend" )			=> "ts-color-button-alizarin-flat",
								__( 'Pomegranate Flat', "ts_visual_composer_extend" )		=> "ts-color-button-pomegranate-flat",
								__( 'Turquoise Flat', "ts_visual_composer_extend" )			=> "ts-color-button-turquoise-flat",
								__( 'Green Sea Flat', "ts_visual_composer_extend" )			=> "ts-color-button-green-sea-flat",
								__( 'Emerald Flat', "ts_visual_composer_extend" )			=> "ts-color-button-emerald-flat",
								__( 'Nephritis Flat', "ts_visual_composer_extend" )			=> "ts-color-button-nephritis-flat",
								__( 'Peter River Flat', "ts_visual_composer_extend" )		=> "ts-color-button-peter-river-flat",
								__( 'Belize Hole Flat', "ts_visual_composer_extend" )		=> "ts-color-button-belize-hole-flat",
								__( 'Amethyst Flat', "ts_visual_composer_extend" )			=> "ts-color-button-amethyst-flat",
								__( 'Wisteria Flat', "ts_visual_composer_extend" )			=> "ts-color-button-wisteria-flat",
								__( 'Wet Asphalt Flat', "ts_visual_composer_extend" )		=> "ts-color-button-wet-asphalt-flat",
								__( 'Midnight Blue Flat', "ts_visual_composer_extend" )		=> "ts-color-button-midnight-blue-flat",
								__( 'Clouds Flat', "ts_visual_composer_extend" )			=> "ts-color-button-clouds-flat",
								__( 'Silver Flat', "ts_visual_composer_extend" )			=> "ts-color-button-silver-flat",
								__( 'Concrete Flat', "ts_visual_composer_extend" )			=> "ts-color-button-concrete-flat",
								__( 'Asbestos Flat', "ts_visual_composer_extend" )			=> "ts-color-button-asbestos-flat",
								__( 'Graphite Flat', "ts_visual_composer_extend" )			=> "ts-color-button-graphite-flat",
							),
							"description"           	=> __( "Select the color scheme for the link button.", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
							"group" 					=> "Link Settings",
						),
						/*array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Button Style", "ts_visual_composer_extend" ),
							"param_name"            	=> "button_style",
							"width"                 	=> 150,
							"value"                 	=> array(
								__( 'Simple Box Left', "ts_visual_composer_extend" )			=> "box-left",
								__( 'Simple Box Right', "ts_visual_composer_extend" )			=> "box-right",
								__( 'Arrow In Left', "ts_visual_composer_extend" )     			=> "arrow-in-left",
								__( 'Arrow In Right', "ts_visual_composer_extend" )     		=> "arrow-in-right",
								__( 'Arrow Out Left', "ts_visual_composer_extend" )				=> "arrow-out-left",
								__( 'Arrow Out Right', "ts_visual_composer_extend" )     		=> "arrow-out-right",
								__( 'Slant In Left', "ts_visual_composer_extend" )     			=> "slant-in-left",
								__( 'Slant In Right', "ts_visual_composer_extend" )     		=> "slant-in-right",
								__( 'Slant Out Left', "ts_visual_composer_extend" )				=> "slant-out-left",
								__( 'Slant Out Right', "ts_visual_composer_extend" )     		=> "slant-out-right",
							),
							"description"           	=> __( "Select the general style for the link button.", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
							"group" 					=> "Link Settings",
						),*/
						// Lightbox Settings
						array(
							"type"                  	=> "seperator",
							"heading"               	=> __( "", "ts_visual_composer_extend" ),
							"param_name"            	=> "seperator_4",
							"value"						=> "",
							"seperator"                 => "Lightbox Settings",
							"description"           	=> __( "", "ts_visual_composer_extend" ),
							"group" 					=> "Lightbox Settings",
						),
						array(
							"type"              		=> "switch_button",
							"heading"			    	=> __( "Open Image in Lightbox", "ts_visual_composer_extend" ),
							"param_name"		    	=> "lightbox_image",
							"value"				    	=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to open the main image in a lightbox.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 					=> "Lightbox Settings",
						),
						array(
							"type"              		=> "switch_button",
							"heading"			    	=> __( "Create AutoGroup", "ts_visual_composer_extend" ),
							"param_name"		    	=> "lightbox_group",
							"value"				    	=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want the plugin to group this image with all other non-gallery images on the page.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "lightbox_image", 'value' => 'true' ),
							"group" 					=> "Lightbox Settings",
						),
						array(
							"type"                 	 	=> "textfield",
							"heading"               	=> __( "Group Name", "ts_visual_composer_extend" ),
							"param_name"            	=> "lightbox_group_name",
							"value"                 	=> "",
							"description"           	=> __( "Enter a custom group name to manually build group with other non-gallery items.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "lightbox_group", 'value' => 'false' ),
							"group" 					=> "Lightbox Settings",
						),
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Transition Effect", "ts_visual_composer_extend" ),
							"param_name"            	=> "lightbox_effect",
							"width"                 	=> 150,
							"value"                 	=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Animations,
							"description"           	=> __( "Select the transition effect to be used for the image in the lightbox.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "lightbox_image", 'value' => 'true' ),
							"group" 					=> "Lightbox Settings",
						),
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Backlight Effect", "ts_visual_composer_extend" ),
							"param_name"            	=> "lightbox_backlight",
							"width"                 	=> 150,
							"value"                 	=> array(
								__( 'Auto Color', "ts_visual_composer_extend" )       											=> "auto",
								__( 'Custom Color', "ts_visual_composer_extend" )     											=> "custom",
								__( 'No Backlight (Only for browsers with RGBA Support)', "ts_visual_composer_extend" )     	=> "hideit",
							),
							"description"           	=> __( "Select the backlight effect for the image.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "lightbox_image", 'value' => 'true' ),
							"group" 					=> "Lightbox Settings",
						),
						array(
							"type"                  	=> "colorpicker",
							"heading"               	=> __( "Custom Backlight Color", "ts_visual_composer_extend" ),
							"param_name"            	=> "lightbox_backlight_color",
							"value"                 	=> "#ffffff",
							"description"           	=> __( "Define the backlight color for the lightbox image.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "lightbox_backlight", 'value' => 'custom' ),
							"group" 					=> "Lightbox Settings",
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
			// Add iPresenter Container
			if (function_exists('vc_map')) {
				vc_map(array(
				    "name"                              => __("TS iPresenter", "ts_visual_composer_extend"),
				    "base"                              => "TS_VCSC_iPresenter_Container",
				    "class"                             => "",
				    "icon"                              => "icon-wpb-ts_vcsc_ipresenter_container",
				    "category"                          => __("VC Extensions", "ts_visual_composer_extend"),
				    "as_parent"                         => array('only' => 'TS_VCSC_iPresenter_Item'),
				    "description"                       => __("Build an iPresenter Element", "ts_visual_composer_extend"),
					"controls" 							=> "full",
					"content_element"                   => true,
					"is_container" 						=> true,
					"container_not_allowed" 			=> false,
					"show_settings_on_create"           => true,
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
				    "params"                            => array(
						// Navigation Settings
						array(
							"type"						=> "seperator",
							"heading"					=> __( "", "ts_visual_composer_extend" ),
							"param_name"				=> "seperator_1",
							"value"						=> "",
							"seperator"					=> "iPresenter Settings",
							"description"				=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Use Auto-Height", "ts_visual_composer_extend" ),
							"param_name"        		=> "autoheight",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to automatically adjust the height for each slide.", "ts_visual_composer_extend" ),
							"dependency"				=> "",
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Use Fixed-Height", "ts_visual_composer_extend" ),
							"param_name"        		=> "fixedheight",
							"value"             		=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to apply a fixed height to all slides; otherwise height for tallest slide will be used.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "autoheight", 'value' => 'false' ),
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Fixed Height", "ts_visual_composer_extend" ),
							"param_name"                => "setheight",
							"value"                     => "600",
							"min"                       => "300",
							"max"                       => "1600",
							"step"                      => "1",
							"unit"                      => 'px',
							"description"               => __( "Define the fixed height to be used for all slides.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "fixedheight", 'value' => 'true' ),
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Use 3D Animations", "ts_visual_composer_extend" ),
							"param_name"        		=> "animation_allow",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to use advanced 3D transitions between the slides; otherwise basic fade will be used.", "ts_visual_composer_extend" ),
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Use Zoom Effect", "ts_visual_composer_extend" ),
							"param_name"        		=> "zoomeffect",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to apply a zoom effect when transitioning between the slides.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "animation_allow", 'value' => 'true' ),
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Animation Speed", "ts_visual_composer_extend" ),
							"param_name"                => "animation_speed",
							"value"                     => "1000",
							"min"                       => "250",
							"max"                       => "3000",
							"step"                      => "50",
							"unit"                      => 'ms',
							"admin_label"           	=> true,
							"description"               => __( "Define the transition speed from one slide to another.", "ts_visual_composer_extend" ),
							"dependency" 				=> ""
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Use Random Start", "ts_visual_composer_extend" ),
							"param_name"        		=> "random_start",
							"value"             		=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to start the presentation at a random slide.", "ts_visual_composer_extend" ),
							"dependency"				=> "",
						),
						// Autoplay Settings
						array(
							"type"                      => "seperator",
							"heading"                   => __( "", "ts_visual_composer_extend" ),
							"param_name"                => "seperator_2",
							"value"						=> "",
							"seperator"                 => "Autoplay Settings",
							"description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Autoplay Settings",
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Use Autoplay", "ts_visual_composer_extend" ),
							"param_name"        		=> "autoplay",
							"value"             		=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to apply an autoplay feature to the iPresenter element.", "ts_visual_composer_extend" ),
							"dependency"				=> "",
							"group" 			        => "Autoplay Settings",
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Play on Viewport", "ts_visual_composer_extend" ),
							"param_name"        		=> "play_viewport",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to autoplay the presentation only when it is in viewport.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "autoplay", 'value' => 'true' ),
							"group" 			        => "Autoplay Settings",
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Play on Mobile", "ts_visual_composer_extend" ),
							"param_name"        		=> "play_mobile",
							"value"             		=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to allow autoplay on mobile devices.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "autoplay", 'value' => 'true' ),
							"group" 			        => "Autoplay Settings",
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Play / Pause Position", "ts_visual_composer_extend" ),
							"param_name"        		=> "play_position",
							"width"             		=> 300,
							"value"             		=> array(								
								__( 'Top Left', "ts_visual_composer_extend" )		=> "top-left",
								__( 'Top Right', "ts_visual_composer_extend" )		=> "top-right",								
								__( 'Bottom Left', "ts_visual_composer_extend" )	=> "bottom-left",
								__( 'Bottom Right', "ts_visual_composer_extend" )	=> "bottom-right",
							),
							"description"       		=> __( "Select where the play / pause buttons should be positioned.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "autoplay", 'value' => 'true' ),
							"group" 			        => "Autoplay Settings",
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Loop Presentation", "ts_visual_composer_extend" ),
							"param_name"        		=> "replay",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to loop the presentation once it is finished.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "autoplay", 'value' => 'true' ),
							"group" 			        => "Autoplay Settings",
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Pause On Hover", "ts_visual_composer_extend" ),
							"param_name"        		=> "pause_on_hover",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to pause the presentation on hover.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "autoplay", 'value' => 'true' ),
							"group" 			        => "Autoplay Settings",
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Duration", "ts_visual_composer_extend" ),
							"param_name"                => "pause_time",
							"value"                     => "5000",
							"min"                       => "1000",
							"max"                       => "150000",
							"step"                      => "100",
							"unit"                      => 'ms',
							"description"               => __( "Define the duration for how long each slide should be shown during autoplay.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "autoplay", 'value' => 'true' ),
							"group" 			        => "Autoplay Settings",
						),						
						// Timer Settings
						array(
							"type"                      => "seperator",
							"heading"                   => __( "", "ts_visual_composer_extend" ),
							"param_name"                => "seperator_3",
							"value"						=> "",
							"seperator"                 => "Timer Settings",
							"description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "autoplay", 'value' => 'true' ),
							"group" 			        => "Autoplay Settings",
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Timer Style", "ts_visual_composer_extend" ),
							"param_name"        		=> "timer",
							"width"             		=> 300,
							"value"             		=> array(
								__( '360 Bar', "ts_visual_composer_extend" )      	=> "360Bar",
								__( 'Simple Bar', "ts_visual_composer_extend" )		=> "Bar",
								__( 'Pie Circle', "ts_visual_composer_extend" )		=> "Pie",
							),
							"admin_label"           	=> true,
							"description"       		=> __( "Select the type of timer animation the iPresenter element should use.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "autoplay", 'value' => 'true' ),
							"group" 			        => "Autoplay Settings",
						),						
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Timer Position", "ts_visual_composer_extend" ),
							"param_name"        		=> "timer_position",
							"width"             		=> 300,
							"value"             		=> array(
								__( 'Top Right', "ts_visual_composer_extend" )		=> "top-right",
								__( 'Top Left', "ts_visual_composer_extend" )		=> "top-left",
								__( 'Middle Center', "ts_visual_composer_extend" )	=> "middle-center",
								__( 'Bottom Right', "ts_visual_composer_extend" )	=> "bottom-right",
								__( 'Bottom Left', "ts_visual_composer_extend" )	=> "bottom-left",
							),
							"admin_label"           	=> true,
							"description"       		=> __( "Select where the animated timer should be positioned.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "autoplay", 'value' => 'true' ),
							"group" 			        => "Autoplay Settings",
						),						
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Timer Size", "ts_visual_composer_extend" ),
							"param_name"                => "timer_diameter",
							"value"                     => "40",
							"min"                       => "20",
							"max"                       => "100",
							"step"                      => "1",
							"unit"                      => 'px',
							"description"               => __( "Define the width or diameter for the animated timer.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "autoplay", 'value' => 'true' ),
							"group" 			        => "Autoplay Settings",
						),	
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Timer Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "timer_color",
							"value"             		=> "#ffffff",
							"description"       		=> __( "Define the color for the animated timer.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "autoplay", 'value' => 'true' ),
							"group" 			        => "Autoplay Settings",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Timer Background", "ts_visual_composer_extend" ),
							"param_name"        		=> "timer_background",
							"value"             		=> "#0066bf",
							"description"       		=> __( "Define the background color for the animated timer.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "autoplay", 'value' => 'true' ),
							"group" 			        => "Autoplay Settings",
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Timer Opacity", "ts_visual_composer_extend" ),
							"param_name"                => "timer_opacity",
							"value"                     => "50",
							"min"                       => "10",
							"max"                       => "100",
							"step"                      => "1",
							"unit"                      => '%',
							"description"               => __( "Define the opacity level for the animated timer.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "autoplay", 'value' => 'true' ),
							"group" 			        => "Autoplay Settings",
						),	
						// Navigation Settings
						array(
							"type"                      => "seperator",
							"heading"                   => __( "", "ts_visual_composer_extend" ),
							"param_name"                => "seperator_4",
							"value"						=> "",
							"seperator"                 => "Navigation Settings",
							"description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Navigation Settings",
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Next / Prev Navigation", "ts_visual_composer_extend" ),
							"param_name"        		=> "direction_nav",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to provide buttons for a next and previous navigation.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 			        => "Navigation Settings",
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Keyboard Navigation", "ts_visual_composer_extend" ),
							"param_name"        		=> "keyboard_nav",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to allow for a keyboard navigation.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 			        => "Navigation Settings",
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Swipe Navigation", "ts_visual_composer_extend" ),
							"param_name"        		=> "touch_nav",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to allow for a left / right swipe navigation.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 			        => "Navigation Settings",
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Bottom Navigation", "ts_visual_composer_extend" ),
							"param_name"        		=> "bottom_nav",
							"width"             		=> 300,
							"value"             		=> array(
								__( 'Thumbnail Navigation', "ts_visual_composer_extend" )				=> "thumbs",
								__( 'Simple Dot Navigation', "ts_visual_composer_extend" )				=> "dots",
								__( 'Dot Navigation with Tooltips', "ts_visual_composer_extend" )		=> "dotsthumbs",
								__( 'No Bottom Navigation', "ts_visual_composer_extend" )				=> "none",
							),
							"description"       		=> __( "Select what type of bottom navigation should be provided.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 			        => "Navigation Settings",
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
	class WPBakeryShortCode_TS_VCSC_iPresenter_Container extends WPBakeryShortCodesContainer {};
}
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_TS_VCSC_iPresenter_Item extends WPBakeryShortCode {};
}
// Initialize "TS Figure Navigation" Class
if (class_exists('TS_iPresenter')) {
	$TS_iPresenter = new TS_iPresenter;
}