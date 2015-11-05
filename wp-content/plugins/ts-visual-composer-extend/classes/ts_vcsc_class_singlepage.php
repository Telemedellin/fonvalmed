<?php
if (!class_exists('TS_SinglePage_Menu')){
	class TS_SinglePage_Menu{
		function __construct(){
			global $VISUAL_COMPOSER_EXTENSIONS;
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				add_action('init',                              		array($this, 'TS_VCSC_Add_SinglePage_Elements'), 9999999);
			} else {
				add_action('admin_init',		                		array($this, 'TS_VCSC_Add_SinglePage_Elements'), 9999999);
			}
			add_shortcode('TS_VCSC_SinglePage_Container',          		array($this, 'TS_VCSC_SinglePage_Container_Function'));
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements++;
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements++;
			add_shortcode('TS_VCSC_SinglePage_Item',          			array($this, 'TS_VCSC_SinglePage_Item_Function'));
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements++;
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements++;
			add_shortcode('TS_VCSC_SinglePage_ToTop',          			array($this, 'TS_VCSC_SinglePage_ToTop_Function'));
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements++;
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements++;
		}
		
		// Navigator Single Item Shortcode
		function TS_VCSC_SinglePage_Item_Function ($atts){
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();

			extract(shortcode_atts(array(
				// Item Settings
				'icon'							=> '',
				'animation_type'				=> 'hover',
				'animation_class'				=> '',
				'external'						=> 'false',
				'link'							=> '',
				'itemid'						=> '',
				'tooltip'						=> '',
				'background'					=> '#000000',
				'color'							=> '#999999',
				// Other Settings
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			),$atts));
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend						= "true";
			} else {
				$frontend						= "false";
			}
			
			$output 							= '';
			
			if ($animation_class != '') {
				$icon_animation 				= 'ts-' . $animation_type . '-css-' . $animation_class . '';
			} else {
				$icon_animation 				= '';
			}
			
			if ($external == "false") {
				if ($itemid != '') {
					$item_link					= ((substr($itemid, 0, 1) === '#') ? $itemid : "#" . $itemid);
				} else {
					$item_link					= "";
				}				
				$item_target					= "_parent";
			} else {
				$link 							= ($link=='||') ? '' : $link;
				$link 							= vc_build_link($link);
				$a_href							= $link['url'];
				$a_title 						= $link['title'];
				$a_target 						= $link['target'];
				$item_link						= $a_href;
				$item_target					= ($a_target === '' ? '_parent' : $a_target);
				if ((TS_VCSC_checkValidURL($item_link) == false) || (substr($item_link, 0, 1) === '#')) {
					$external					= 'false';
				}
			}
			
			if ($frontend == "false") {
				$output .= '<div class="ts-singlepage-navigator-item" data-icon="' . $icon . '" data-type="standard" data-placement="standard" data-class="' . $el_class . '" data-animation="' . $icon_animation . '" data-external="' . $external . '" data-link="' . $item_link . '" data-target="' . $item_target . '" data-tooltip="' . rawurldecode(base64_decode(strip_tags($tooltip))) . '" data-background="' . $background . '" data-color="' . $color . '"></div>';
			} else {
				$output .= '<div class="ts-singlepage-navigator-item" style="margin: 5px 0; padding: 5px 10px; border: 1px solid #ededed;">';
					$output .= '<div style="display: block;">Icon: ' . $icon . '<i class="' . $icon . '" style="font-size: 14px; margin-left: 10px;"></i></div>';
					$output .= '<div style="display: block;">Animation: ' . ($icon_animation != "" ? $icon_animation : "N/A") . '</div>';
					$output .= '<div style="display: block;">External: ' . $external . '</div>';
					if ($external == 'false') {
						$output .= '<div style="display: block;">Anchor: ' . ($item_link != "" ? $item_link : "N/A") . '</div>';
					} else {
						$output .= '<div style="display: block;">Link: ' . ($item_link != "" ? $item_link : "N/A") . '</div>';
					}
				$output .= '</div>';
			}
			
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
		
		// Navigator ToTop Item Shortcode
		function TS_VCSC_SinglePage_ToTop_Function ($atts){
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();

			extract(shortcode_atts(array(
				// Item Settings
				'icon'							=> '',
				'animation_type'				=> 'hover',
				'animation_class'				=> '',
				'placement'						=> 'last',
				'tooltip'						=> '',
				'background'					=> '#000000',
				'color'							=> '#999999',
				// Other Settings
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			),$atts));
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend						= "true";
			} else {
				$frontend						= "false";
			}
			
			$output 							= '';
			
			if ($animation_class != '') {
				$icon_animation 				= 'ts-' . $animation_type . '-css-' . $animation_class . '';
			} else {
				$icon_animation 				= '';
			}
			
			if ($frontend == "false") {
				$output .= '<div class="ts-singlepage-navigator-item" data-icon="' . $icon . '" data-type="totop" data-placement="' . $placement . '" data-class="' . $el_class . '" data-animation="' . $icon_animation . '" data-external="false" data-link="#ts-singlepage-navigator-totop" data-target="_parent" data-tooltip="' . rawurldecode(base64_decode(strip_tags($tooltip))) . '" data-background="' . $background . '" data-color="' . $color . '"></div>';
			} else {
				$output .= '<div class="ts-singlepage-navigator-item" style="margin: 5px 0; padding: 5px 10px; border: 1px solid #ededed;">';
					$output .= '<div style="display: block;">Icon: ' . $icon . '<i class="' . $icon . '" style="font-size: 14px; margin-left: 10px;"></i></div>';
					$output .= '<div style="display: block;">Animation: ' . ($icon_animation != "" ? $icon_animation : "N/A") . '</div>';
					$output .= '<div style="display: block;">External: false</div>';
					$output .= '<div style="display: block;">Anchor: #</div>';
				$output .= '</div>';
			}
			
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
		// Navigator Container Shortcode
		function TS_VCSC_SinglePage_Container_Function ($atts, $content = null){
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();

			extract(shortcode_atts(array(
				// Menu Settings
				'enable'						=> 'true',
				'position'						=> 'left',
				'pageorder'						=> 'true',
				'empty_ignore'					=> 'false',
				'empty_placement'				=> 'first',
				'page_scrolltime'				=> 2000,
				'page_scrolloffset'				=> 'desktop:0px;tablet:0px;mobile:0px',
				'easing'						=> 'linear',
				'mobile_trigger'				=> 600,
				// Default Styling
				'transparent'					=> 'false',
				'show_icons'					=> 'true',
				'rounded'						=> 'true',
				'size_icon'						=> 20,
				'size_item'						=> 40,
				'border_distance'				=> 10,
				// Default Colors
				'hover_background'				=> '#2e81b0',
				'hover_text'					=> '#ffffff',
				'active_background'				=> '#2e81b0',
				'active_text'					=> '#ffffff',
				'scroll_background'				=> '#000000',
				'scroll_text'					=> '#ffffff',
				// Tooltip Settings
				'tooltip_theme'					=> 'tooltipster-black',
				'tooltip_animation'				=> 'swing',
				'tooltip_offsetx'				=> 0,
				'tooltip_offsety'				=> 0,
				// Other Settings
				'css'							=> '',
			),$atts));
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend						= "true";
				$enable 						= "false";
			} else {
				$frontend						= "false";
				$enable 						= $enable;
			}
			
			if (($enable == "true") && ($frontend == "false")) {
				wp_enqueue_script('jquery-easing');
				wp_enqueue_style('dashicons');
				wp_enqueue_style('ts-extend-animations');
				wp_enqueue_style('ts-extend-tooltipster');
				wp_enqueue_script('ts-extend-tooltipster');
				wp_enqueue_style('ts-extend-singlepage');
				wp_enqueue_script('ts-extend-singlepage');
				wp_enqueue_style('ts-visual-composer-extend-front');
				wp_enqueue_script('ts-visual-composer-extend-front');
			}
			
			$randomizer							= mt_rand(999999, 9999999);
			$navigator_id						= 'ts-vcsc-singlepage-navigator-' . $randomizer;
			$output 							= '';
			
			$page_scrolloffset 					= explode(';', $page_scrolloffset);			
			$offsetDesktop						= explode(':', $page_scrolloffset[0]);
			$offsetDesktop						= str_replace("px", "", $offsetDesktop[1]);
			$offsetTablet						= explode(':', $page_scrolloffset[1]);
			$offsetTablet						= str_replace("px", "", $offsetTablet[1]);
			$offsetMobile						= explode(':', $page_scrolloffset[2]);
			$offsetMobile						= str_replace("px", "", $offsetMobile[1]);

			if ($frontend == "true") {
				$style 							= 'margin: 35px 0 0 0; padding: 10px; display: block; border: 1px solid #ededed; background: #FAFAFA;';
			} else {
				$style 							= 'width: 100%; margin: 0px; padding: 0px; display: none;';
			}
			
			if (($enable == "true") && ($frontend == "false")) {
				$data_offsets					= 'data-offsetdesktop="' . $offsetDesktop . '" data-offsettablet="' . $offsetTablet . '" data-offsetmobile="' . $offsetMobile . '"';
				$data_settings					= 'data-randomizer="' . $randomizer . '" data-position="' . $position . '" data-pageorder="' . $pageorder . '" data-scrolltime="' . $page_scrolltime . '" data-easing="' . $easing . '" data-empty="' . $empty_ignore . '" data-placement="' . $empty_placement . '" data-mobile="' . $mobile_trigger . '"';
				$data_styling					= 'data-transparent="' . $transparent . '" data-showicons="' . $show_icons . '" data-rounded="' . $rounded . '" data-sizeicon="' . $size_icon . '" data-sizeitem="' . $size_item . '" data-margin="' . $border_distance . '"';
				$data_colors					= 'data-hoverbackground="' . $hover_background . '" data-hovertext="' . $hover_text . '" data-activebackground="' . $active_background . '" data-activetext="' . $active_text . '" data-scrollbackground="' . $scroll_background . '" data-scrolltext="' . $scroll_text . '"';
				$data_tooltip					= 'data-theme="' . $tooltip_theme . '" data-animation="' . $tooltip_animation . '" data-offsetx="' . $tooltip_offsetx . '" data-offsety="' . $tooltip_offsety . '"';
				$containerdata					= $data_settings . ' ' . $data_offsets . ' ' . $data_styling . ' ' . $data_colors . ' ' . $data_tooltip;
				$containerclass					= 'ts-singlepage-navigator-enabled';
			} else {
				$containerdata					= '';
				$containerclass					= 'ts-singlepage-navigator-disabled';
			}
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_SinglePage_Container', $atts);
			} else {
				$css_class 	= '';
			}
			
			if ($frontend == "false") {
				if ($enable == "true") {
					$output .= '<div id="' . $navigator_id . '" class="' . $containerclass . ' ' . $css_class . '" style="' . $style . '" ' . $containerdata . '>';
				} else {
					$output .= '<div id="' . $navigator_id . '" class="' . $containerclass . ' ' . $css_class . '" style="' . $style . '">';
				}
					$output .= do_shortcode($content);
				$output .= '</div>';
			} else {
				$output .= '<div id="' . $navigator_id . '" class="' . $containerclass . ' ' . $css_class . '" style="' . $style . '">';
					$output .= '<div style="display: block; font-weight: bold; font-size: 16px;">TS Single Page Navigator</div>';
					$output .= do_shortcode($content);
				$output .= '</div>';
			}
			
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
		function TS_VCSC_Add_SinglePage_Elements() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			// Standard Navigator Items
			if (function_exists('vc_map')) {
				vc_map(
					array(
						"name"                      		=> __( "TS Single Menu Item", "ts_visual_composer_extend" ),
						"base"                      		=> "TS_VCSC_SinglePage_Item",
						"icon" 	                    		=> "icon-wpb-ts_vcsc_singlepage_item",
						"content_element"                	=> true,
						"as_child"                       	=> array('only' => 'TS_VCSC_SinglePage_Container'),
						"category"                  		=> __( 'VC Extensions', "ts_visual_composer_extend" ),
						"params"                    		=> array(
							// Single Menu Item Settings
							array(
								"type"              		=> "seperator",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "seperator_1",
								"value"						=> "",
								"seperator"					=> "Menu Item Settings",
								"description"       		=> __( "", "ts_visual_composer_extend" )
							),
							array(
								'type' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
								'heading' 					=> __( 'Select Icon', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'icon',
								'value'						=> '',
								'source'					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorValue,
								'settings' 					=> array(
									'emptyIcon' 				=> true,
									'type' 						=> 'extensions',
									'iconsPerPage' 				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
									'source' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorSource,
								),
								"admin_label"				=> true,
								"description"       		=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon to be used for this menu item.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
							),
							array(
								'type' 						=> 'dropdown',
								'heading' 					=> __( 'Animation Type', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'animation_type',
								'value' => array(
									__('Hover', 'ts_visual_composer_extend') 			=> 'hover',
									__('Infinite', 'ts_visual_composer_extend')			=> 'infinite',
								),
								'description' 				=> __( 'Select what animation type the icon should be using.', 'ts_visual_composer_extend' )
							),	
							array(
								"type"						=> "css3animations",
								"class"						=> "",
								"heading"					=> __("Icon Animation", "ts_visual_composer_extend"),
								"param_name"				=> "animation_class",
								"standard"					=> "false",
								"prefix"					=> "",
								"connector"					=> "css3animations_in",
								"noneselect"				=> "true",
								"default"					=> "",
								"value"						=> "",
								"description"				=> __("Select the hover animation for the icon.", "ts_visual_composer_extend"),
							),
							array(
								"type"						=> "hidden_input",
								"heading"					=> __( "Icon Animation", "ts_visual_composer_extend" ),
								"param_name"				=> "css3animations_in",
								"value"						=> "",
								"description"				=> __( "", "ts_visual_composer_extend" ),
							),		
							array(
								"type"              		=> "switch_button",
								"heading"			    	=> __( "External Link", "ts_visual_composer_extend" ),
								"param_name"		    	=> "external",
								"value"             		=> "false",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"description"		    	=> __( "Switch the toggle if you want to apply an external link to this menu item.", "ts_visual_composer_extend" ),
							),
							array(
								"type"						=> "textfield",
								"heading"					=> __( "Item Anchor", "ts_visual_composer_extend" ),
								"param_name"				=> "itemid",
								"value"						=> "",
								"admin_label"				=> true,
								"description"				=> __( "Enter the ID of the row or element this menu item should be connected to.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "external", 'value' => 'false' ),
							),
							array(
								"type" 						=> "vc_link",
								"heading" 					=> __("Link + Title", "ts_visual_composer_extend"),
								"param_name" 				=> "link",
								"admin_label"				=> true,
								"description" 				=> __("Provide a link to another site/page for the menu item.", "ts_visual_composer_extend"),
								"dependency"            	=> array( 'element' => "external", 'value' => 'true' ),
							),
							array(
								"type"              		=> "textarea_raw_html",
								"heading"           		=> __( "Tooltip Content", "ts_visual_composer_extend" ),
								"param_name"        		=> "tooltip",
								"value"             		=> base64_encode(""),
								"description"      	 		=> __( "Enter the tooltip content here; HTML code can be used.", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Background Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "background",
								"value"             		=> "#000000",
								"description"       		=> __( "Define the background color for the menu item.", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Text Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "color",
								"value"             		=> "#999999",
								"description"       		=> __( "Define the text color for the menu item.", "ts_visual_composer_extend" ),
							),
							// Load Custom CSS/JS File
							array(
								"type"						=> "load_file",
								"heading"					=> __( "", "ts_visual_composer_extend" ),
								"value"						=> "",
								"param_name"				=> "el_file1",
								"file_type"					=> "js",
								"file_path"					=> "js/ts-visual-composer-extend-element.min.js",
								"description"				=> __( "", "ts_visual_composer_extend" )
							),
							array(
								"type"						=> "load_file",
								"heading"					=> __( "", "ts_visual_composer_extend" ),
								"value"						=> "",
								"param_name"				=> "el_file2",
								"file_type"					=> "css",
								"file_id"					=> "ts-extend-animations",
								"file_path"					=> "css/ts-visual-composer-extend-animations.min.css",
								"description"				=> __( "", "ts_visual_composer_extend" )
							),
						)
					)
				);
			}			
			// ToTop Navigator Item
			if (function_exists('vc_map')) {
				vc_map(
					array(
						"name"                      		=> __( "TS ToTop Menu Item", "ts_visual_composer_extend" ),
						"base"                      		=> "TS_VCSC_SinglePage_ToTop",
						"icon" 	                    		=> "icon-wpb-ts_vcsc_singlepage_totop",
						"content_element"                	=> true,
						"as_child"                       	=> array('only' => 'TS_VCSC_SinglePage_Container'),
						"category"                  		=> __( 'VC Extensions', "ts_visual_composer_extend" ),
						"params"                    		=> array(
							// Single Menu Item Settings
							array(
								"type"              		=> "seperator",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "seperator_1",
								"value"						=> "",
								"seperator"					=> "Menu Item Settings",
								"description"       		=> __( "", "ts_visual_composer_extend" )
							),
							array(
								'type' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
								'heading' 					=> __( 'Select Icon', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'icon',
								'value'						=> '',
								"source"					=> ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") && ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorNativeSelector == "true")) ? "" : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_NavigatorIconsCompliant),
								"settings" 					=> array(
									"emptyIcon" 				=> false,
									"type" 						=> 'extensions',
									"iconsPerPage" 				=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
									"source" 					=> ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") && ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorNativeSelector == "true")) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_NavigatorIconsCompliant : ""),
								),								
								"admin_label"				=> true,
								"description"       		=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon to be used for this menu item.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
							),
							array(
								"type"                 	 	=> "dropdown",
								"heading"               	=> __( "Placement of Item", "ts_visual_composer_extend" ),
								"param_name"            	=> "empty_placement",
								"width"                 	=> 150,
								"value" 					=> array(									
									__( "Last", "ts_visual_composer_extend" )					=> "last",
									__( "First", "ts_visual_composer_extend" )					=> "first",
								),
								"description"           	=> __( "Select where the ToTop menu item should be placed within the menu.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "empty_ignore", 'value' => 'true' ),
							),
							array(
								'type' 						=> 'dropdown',
								'heading' 					=> __( 'Animation Type', 'ts_visual_composer_extend' ),
								'param_name' 				=> 'animation_type',
								'value' => array(
									__('Hover', 'ts_visual_composer_extend') 			=> 'hover',
									__('Infinite', 'ts_visual_composer_extend')			=> 'infinite',
								),
								'description' 				=> __( 'Select what animation type the icon should be using.', 'ts_visual_composer_extend' )
							),	
							array(
								"type"						=> "css3animations",
								"class"						=> "",
								"heading"					=> __("Icon Animation", "ts_visual_composer_extend"),
								"param_name"				=> "animation_class",
								"standard"					=> "false",
								"prefix"					=> "",
								"connector"					=> "css3animations_in",
								"noneselect"				=> "true",
								"default"					=> "",
								"value"						=> "",
								"description"				=> __("Select the hover animation for the icon.", "ts_visual_composer_extend"),
							),
							array(
								"type"						=> "hidden_input",
								"heading"					=> __( "Icon Animation", "ts_visual_composer_extend" ),
								"param_name"				=> "css3animations_in",
								"value"						=> "",
								"description"				=> __( "", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "textarea_raw_html",
								"heading"           		=> __( "Tooltip Content", "ts_visual_composer_extend" ),
								"param_name"        		=> "tooltip",
								"value"             		=> base64_encode(""),
								"description"      	 		=> __( "Enter the tooltip content here; HTML code can be used.", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Background Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "background",
								"value"             		=> "#000000",
								"description"       		=> __( "Define the background color for the menu item.", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Text Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "color",
								"value"             		=> "#999999",
								"description"       		=> __( "Define the text color for the menu item.", "ts_visual_composer_extend" ),
							),
							// Load Custom CSS/JS File
							array(
								"type"						=> "load_file",
								"heading"					=> __( "", "ts_visual_composer_extend" ),
								"value"						=> "",
								"param_name"				=> "el_file1",
								"file_type"					=> "js",
								"file_path"					=> "js/ts-visual-composer-extend-element.min.js",
								"description"				=> __( "", "ts_visual_composer_extend" )
							),
							array(
								"type"						=> "load_file",
								"heading"					=> __( "", "ts_visual_composer_extend" ),
								"value"						=> "",
								"param_name"				=> "el_file2",
								"file_type"					=> "css",
								"file_id"					=> "ts-extend-animations",
								"file_path"					=> "css/ts-visual-composer-extend-animations.min.css",
								"description"				=> __( "", "ts_visual_composer_extend" )
							),
						)
					)
				);
			}			
			// Navigator Container
			if (function_exists('vc_map')) {
				vc_map( 
					array(
						"name" 								=> __("TS SinglePage Navigator", "ts_visual_composer_extend"),
						"base" 								=> "TS_VCSC_SinglePage_Container",
						"icon" 								=> "icon-wpb-ts_vcsc_singlepage_navigator",
						"class" 							=> "",
						"as_parent" 						=> array('only' => 'TS_VCSC_SinglePage_Item,TS_VCSC_SinglePage_ToTop'),
						"category" 							=> "VC Extensions",
						"description" 						=> "Add a singe plage navigation menu.",
						"controls" 							=> "full",
						"content_element"                   => true,
						"is_container" 						=> true,
						"container_not_allowed" 			=> false,
						"show_settings_on_create"           => true,
						"admin_enqueue_js"            		=> "",
						"admin_enqueue_css"           		=> "",
						"params" 							=> array(
							// Global Menu Settings
							array(
								"type"              		=> "seperator",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "seperator_1",
								"value"						=> "",
								"seperator"         		=> "Menu Settings",
								"description"       		=> __( "", "ts_visual_composer_extend" ),
							),
							array(
								"type"              		=> "switch_button",
								"heading"			    	=> __( "Navigator Active", "ts_visual_composer_extend" ),
								"param_name"		    	=> "enable",
								"value"             		=> "true",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"admin_label"		        => true,
								"description"		    	=> __( "Switch the toggle if you want to use the single page navigator menu on this page.", "ts_visual_composer_extend" ),
								"dependency"            	=> ""
							),
							array(
								"type"                 	 	=> "dropdown",
								"heading"               	=> __( "Menu Position", "ts_visual_composer_extend" ),
								"param_name"            	=> "position",
								"width"                 	=> 150,
								"value" 					=> array(
									__( "Left", "ts_visual_composer_extend" )					=> "left",
									__( "Right", "ts_visual_composer_extend" )					=> "right",
									__( "Bottom", "ts_visual_composer_extend" )					=> "bottom",
									__( "Top", "ts_visual_composer_extend" )					=> "top",
								),
								"description"           	=> __( "Select on which side of the screen the menu should be positioned at.", "ts_visual_composer_extend" ),
								"admin_label"       		=> true,
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							array(
								"type"              		=> "switch_button",
								"heading"			    	=> __( "AutoSort by Page Order", "ts_visual_composer_extend" ),
								"param_name"		    	=> "pageorder",
								"value"             		=> "true",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"description"		    	=> __( "Switch the toggle if you want to automatically sort the menu items in the order at which their targets appear on the page.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							array(
								"type"              		=> "switch_button",
								"heading"			    	=> __( "Ignore Empty Items", "ts_visual_composer_extend" ),
								"param_name"		    	=> "empty_ignore",
								"value"             		=> "false",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"description"		    	=> __( "Switch the toggle if you want allow or to automatically discard all menu items without a link or anchor.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							array(
								"type"                 	 	=> "dropdown",
								"heading"               	=> __( "Placement of Empty Items", "ts_visual_composer_extend" ),
								"param_name"            	=> "empty_placement",
								"width"                 	=> 150,
								"value" 					=> array(
									__( "First", "ts_visual_composer_extend" )					=> "first",
									__( "Last", "ts_visual_composer_extend" )					=> "last",
								),
								"description"           	=> __( "If auto-sort is enabled, select where empty menu items should be placed within the menu.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "empty_ignore", 'value' => 'true' ),
							),
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Page Scroll Speed", "ts_visual_composer_extend" ),
								"param_name"				=> "page_scrolltime",
								"value"						=> "2000",
								"min"						=> "100",
								"max"						=> "6000",
								"step"						=> "100",
								"unit"						=> 'ms',
								"description"				=> __( "Define the speed that should be used for a full page scroll.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),							
							array(
								"type"                 	 	=> "dropdown",
								"heading"               	=> __( "Page Scroll Easing", "ts_visual_composer_extend" ),
								"param_name"            	=> "easing",
								"width"                 	=> 150,
								"value" 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CSS_Easings_Array,
								"description"           	=> __( "Select the easing animation that should be applied to the page scroll", "ts_visual_composer_extend" ),
								"admin_label"       		=> true,
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),							
							array(
								"type" 						=> "devicetype_selectors",
								"heading"           		=> __( "Device Type Scroll Offset", "ts_visual_composer_extend" ),
								"param_name"        		=> "page_scrolloffset",
								"unit"  					=> "px",
								"collapsed"					=> "false",
								"devices" 					=> array(
									"Desktop"           			=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
									"Tablet"            			=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
									"Mobile"            			=> array("default" => 0, "min" => 0, "max" => 250, "step" => 1),
								),
								"description"				=> __( "Define an additional scroll offset to account for menu bars and other top fixed elements.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Mobile Mode Switch", "ts_visual_composer_extend" ),
								"param_name"				=> "mobile_trigger",
								"value"						=> "600",
								"min"						=> "240",
								"max"						=> "1280",
								"step"						=> "1",
								"unit"						=> 'px',
								"description"				=> __( "Define the screen size at which the menu should switch into mobile layout.", "ts_visual_composer_extend" ),
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							// Style Settings
							array(
								"type"              		=> "seperator",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "seperator_2",
								"value"						=> "",
								"seperator"         		=> "Style Settings",
								"description"       		=> __( "", "ts_visual_composer_extend" ),
								"group"						=> "Style Settings",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							array(
								"type"              		=> "switch_button",
								"heading"			    	=> __( "Transparent Background", "ts_visual_composer_extend" ),
								"param_name"		    	=> "transparent",
								"value"             		=> "false",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"description"		    	=> __( "Switch the toggle if you want make all item backgrounds transparent; will override background set in individual item settings.", "ts_visual_composer_extend" ),
								"group"						=> "Style Settings",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							array(
								"type"              		=> "switch_button",
								"heading"			    	=> __( "Show Custom Icons", "ts_visual_composer_extend" ),
								"param_name"		    	=> "show_icons",
								"value"             		=> "true",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"description"		    	=> __( "Switch the toggle if you want to use the custom icons set for each individual item, or the same default icon for all items.", "ts_visual_composer_extend" ),
								"group"						=> "Style Settings",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							array(
								"type"              		=> "switch_button",
								"heading"			    	=> __( "Use Rounded Corners", "ts_visual_composer_extend" ),
								"param_name"		    	=> "rounded",
								"value"             		=> "true",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"description"		    	=> __( "Switch the toggle if you want to use rounded corners for the first and last item in the menu.", "ts_visual_composer_extend" ),
								"group"						=> "Style Settings",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Icon Size", "ts_visual_composer_extend" ),
								"param_name"				=> "size_icon",
								"value"						=> "20",
								"min"						=> "10",
								"max"						=> "40",
								"step"						=> "1",
								"unit"						=> 'px',
								"description"				=> __( "Define the size for the icon in each menu item.", "ts_visual_composer_extend" ),
								"group"						=> "Style Settings",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Item Size", "ts_visual_composer_extend" ),
								"param_name"				=> "size_item",
								"value"						=> "40",
								"min"						=> "10",
								"max"						=> "80",
								"step"						=> "1",
								"unit"						=> 'px',
								"description"				=> __( "Define the overall size for the each menu item.", "ts_visual_composer_extend" ),
								"group"						=> "Style Settings",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Side Spacing", "ts_visual_composer_extend" ),
								"param_name"				=> "border_distance",
								"value"						=> "10",
								"min"						=> "0",
								"max"						=> "150",
								"step"						=> "1",
								"unit"						=> 'px',
								"description"				=> __( "Define the space between the menu and the side of the browser window it is aligned to.", "ts_visual_composer_extend" ),
								"group"						=> "Style Settings",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							// Color Settings
							array(
								"type"              		=> "seperator",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "seperator_3",
								"value"						=> "",
								"seperator"         		=> "Color Settings",
								"description"       		=> __( "", "ts_visual_composer_extend" ),
								"group"						=> "Color Settings",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Hover Background Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "hover_background",
								"value"             		=> "#2e81b0",
								"description"       		=> __( "Define the background color to be used when hovering over a menu item.", "ts_visual_composer_extend" ),
								"group"						=> "Color Settings",
								"dependency"            	=> array( 'element' => "transparent", 'value' => 'false' ),
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Hover Text Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "hover_text",
								"value"             		=> "#ffffff",
								"description"       		=> __( "Define the text color to be used when hovering over a menu item.", "ts_visual_composer_extend" ),
								"group"						=> "Color Settings",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),							
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Active Background Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "active_background",
								"value"             		=> "#2e81b0",
								"description"       		=> __( "Define the background color to be used for the currently active menu item.", "ts_visual_composer_extend" ),
								"group"						=> "Color Settings",
								"dependency"            	=> array( 'element' => "transparent", 'value' => 'false' ),
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Active Text Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "active_text",
								"value"             		=> "#ffffff",
								"description"       		=> __( "Define the text color to be used for the currently active menu item.", "ts_visual_composer_extend" ),
								"group"						=> "Color Settings",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Scroll Button Background Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "scroll_background",
								"value"             		=> "#000000",
								"description"       		=> __( "Define the background color for the scroll button that is used when the menu is larger than the screen size allows for.", "ts_visual_composer_extend" ),
								"group"						=> "Color Settings",
								"dependency"            	=> array( 'element' => "transparent", 'value' => 'false' ),
							),
							array(
								"type"              		=> "colorpicker",
								"heading"           		=> __( "Scroll Button Text Color", "ts_visual_composer_extend" ),
								"param_name"        		=> "scroll_text",
								"value"             		=> "#ffffff",
								"description"       		=> __( "Define the text color for the scroll button that is used when the menu is larger than the screen size allows for.", "ts_visual_composer_extend" ),
								"group"						=> "Color Settings",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),							
							// Tooltip Settings
							array(
								"type"              		=> "seperator",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "seperator_4",
								"value"						=> "",
								"seperator"         		=> "Tooltip Settings",
								"description"       		=> __( "", "ts_visual_composer_extend" ),
								"group"						=> "Tooltip Settings",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							array(
								"type"				    	=> "dropdown",
								"class"				    	=> "",
								"heading"			    	=> __( "Tooltip Style", "ts_visual_composer_extend" ),
								"param_name"		    	=> "tooltip_theme",
								"value"                 	=> array(
									__("Black", "ts_visual_composer_extend")                  	=> "tooltipster-black",
									__("Gray", "ts_visual_composer_extend")                   	=> "tooltipster-gray",
									__("Green", "ts_visual_composer_extend")                  	=> "tooltipster-green",
									__("Blue", "ts_visual_composer_extend")                   	=> "tooltipster-blue",
									__("Red", "ts_visual_composer_extend")                    	=> "tooltipster-red",
									__("Orange", "ts_visual_composer_extend")                 	=> "tooltipster-orange",
									__("Yellow", "ts_visual_composer_extend")                 	=> "tooltipster-yellow",
									__("Purple", "ts_visual_composer_extend")                 	=> "tooltipster-purple",
									__("Pink", "ts_visual_composer_extend")                   	=> "tooltipster-pink",
									__("White", "ts_visual_composer_extend")                  	=> "tooltipster-white"
								),
								"description"		    	=> __( "Select the tooltip style.", "ts_visual_composer_extend" ),
								"group"						=> "Tooltip Settings",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							array(
								"type"				    	=> "dropdown",
								"class"				    	=> "",
								"heading"			    	=> __( "Tooltip Animation", "ts_visual_composer_extend" ),
								"param_name"		    	=> "tooltip_animation",
								"value"                 	=> array(
									__("Swing", "ts_visual_composer_extend")                    => "swing",
									__("Fall", "ts_visual_composer_extend")                 	=> "fall",
									__("Grow", "ts_visual_composer_extend")                 	=> "grow",
									__("Slide", "ts_visual_composer_extend")                 	=> "slide",
									__("Fade", "ts_visual_composer_extend")                 	=> "fade",
								),
								"description"		    	=> __( "Select how the tooltip entry and exit should be animated once triggered.", "ts_visual_composer_extend" ),
								"group"						=> "Tooltip Settings",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Tooltip X-Offset", "ts_visual_composer_extend" ),
								"param_name"				=> "tooltip_offsetx",
								"value"						=> "0",
								"min"						=> "-100",
								"max"						=> "100",
								"step"						=> "1",
								"unit"						=> 'px',
								"description"				=> __( "Define an optional X-Offset for the tooltip position.", "ts_visual_composer_extend" ),
								"group"						=> "Tooltip Settings",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),
							array(
								"type"						=> "nouislider",
								"heading"					=> __( "Tooltip Y-Offset", "ts_visual_composer_extend" ),
								"param_name"				=> "tooltip_offsety",
								"value"						=> "0",
								"min"						=> "-100",
								"max"						=> "100",
								"step"						=> "1",
								"unit"						=> 'px',
								"description"				=> __( "Define an optional Y-Offset for the tooltip position.", "ts_visual_composer_extend" ),
								"group"						=> "Tooltip Settings",
								"dependency"            	=> array( 'element' => "enable", 'value' => 'true' ),
							),	
							// Load Custom CSS/JS File
							array(
								"type"              		=> "load_file",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"value"             		=> "Element Files",
								"param_name"        		=> "el_file1",
								"file_type"         		=> "js",
								"file_path"         		=> "js/ts-visual-composer-extend-element.min.js",
								"description"       		=> __( "", "ts_visual_composer_extend" )
							),
						),
						"js_view" => 'VcColumnView'
					)
				);
			}
		}
	}
}
if (class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_TS_VCSC_SinglePage_Container extends WPBakeryShortCodesContainer {};
}
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_TS_VCSC_SinglePage_Item extends WPBakeryShortCode {};
	class WPBakeryShortCode_TS_VCSC_SinglePage_ToTop extends WPBakeryShortCode {};
}

// Initialize "TS SinglePage Menu" Class
if (class_exists('TS_SinglePage_Menu')) {
	$TS_SinglePage_Menu = new TS_SinglePage_Menu;
}
?>