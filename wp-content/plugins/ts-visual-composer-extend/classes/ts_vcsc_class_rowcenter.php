<?php
if (!class_exists('TS_RowCenter_Block')){
	class TS_RowCenter_Block{
		function __construct(){
			global $VISUAL_COMPOSER_EXTENSIONS;
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				add_action('init',                              		array($this, 'TS_VCSC_RowCenter_Frame_Elements'), 9999999);
			} else {
				add_action('admin_init',		                		array($this, 'TS_VCSC_RowCenter_Frame_Elements'), 9999999);
			}
			add_shortcode('TS_VCSC_RowCenter_Frame',          			array($this, 'TS_VCSC_RowCenter_Frame_Function'));
		}
		
		function TS_VCSC_RowCenter_Frame_Function($atts, $content = null){
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();

			wp_enqueue_style('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-front');
			
			extract(shortcode_atts(array(
				"enable"						=> "true",
				'css'							=> '',
			),$atts));
			
			if (!empty($el_id)) {
				$animation_id					= $el_id;
			} else {
				$animation_id					= 'ts-vcsc-rowcenter-container-' . mt_rand(999999, 9999999);
			}
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$enable 						= "false";
			} else {
				$enable 						= $enable;
			}
			
			$output 							= '';

			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$style 							= 'width: 100%; margin: 35px 0 0 0;';
			} else {
				$style 							= 'width: 100%; margin: 0px;';
			}
			
			if ($enable == "true") {
				$containerclass	 				= 'ts-rowcenter-container-enabled ts-rowcenter-frame';
			} else {
				$containerclass					= 'ts-rowcenter-container-disabled ts-rowcenter-frame';
			}
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '' . $containerclass . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_RowCenter_Frame', $atts);
			} else {
				$css_class 	= $containerclass . ' ' . $el_class;
			}
			
			$output .= '<div id="' . $animation_id . '" class="' . $css_class . '" style="' . $style . '">';
				$output .= '<div class="ts-rowcenter-inner-wrapper">';
					$output .= do_shortcode($content);
				$output .= '</div>';
			$output .= '</div>';
			
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
		function TS_VCSC_RowCenter_Frame_Elements() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			if (function_exists('vc_map')) {
				vc_map( 
					array(
						"name" 								=> __("TS Row Center Frame", "ts_visual_composer_extend"),
						"base" 								=> "TS_VCSC_RowCenter_Frame",
						"icon" 								=> "icon-wpb-ts_vcsc_rowcenter_container",
						"class" 							=> "",
						"as_parent" 						=> array('except' => '
																TS_VCSC_RowCenter_Frame,
																TS_VCSC_Anything_Slider,
																TS_VCSC_Fancy_Tabs_Container,
																TS_VCSC_Fancy_Tabs_Single,
																TS_VCSC_Figure_Navigation_Container,
																TS_VCSC_Figure_Navigation_Item,
																TS_VCSC_Horizontal_Steps_Container,
																TS_VCSC_Horizontal_Steps_Item,
																TS_VCSC_iPresenter_Container,
																TS_VCSC_iPresenter_Item,
																TS_VCSC_Image_Hotspot_Container,
																TS_VCSC_Image_Hotspot_Single,
																TS_VCSC_Image_Hotspot_Label,
																TS_VCSC_Timeline_CSS_Container,
																TS_VCSC_Timeline_CSS_Section,
																TS_VCSC_Timeline_Container,
																TS_VCSC_Timeline_Single,
																TS_VCSC_Timeline_Break,																
																TS_VCSC_Animation_Frame,
																TS_VCSC_SinglePage_Container,
																TS_VCSC_SinglePage_Item,
																TS_VCSC_SinglePage_ToTop
															'),
						"category" 							=> "VC Extensions",
						"description" 						=> "Vertically center elements in a full width row.",
						"controls" 							=> "full",
						"content_element"                   => true,
						"is_container" 						=> true,
						"container_not_allowed" 			=> true,
						"show_settings_on_create"           => false,
						"admin_enqueue_js"            		=> "",
						"admin_enqueue_css"           		=> "",
						"params" 							=> array(
							array(
								"type"              		=> "messenger",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"param_name"        		=> "messenger",
								"color"						=> "#FF0000",
								"weight"					=> "bold",
								"size"						=> "14",
								"value"						=> "",
								"message"            		=> __( "Aside from this container element and the elements you place inside of it, there can NOT be any other elements added to this row and you can use this container only once per row.", "ts_visual_composer_extend" ),
								"description"       		=> __( "", "ts_visual_composer_extend" )
							),
							array(
								"type"              		=> "switch_button",
								"heading"			    	=> __( "Row Center Active", "ts_visual_composer_extend" ),
								"param_name"		    	=> "enable",
								"value"             		=> "true",
								"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"						=> __( 'No', "ts_visual_composer_extend" ),
								"style"						=> "select",
								"design"					=> "toggle-light",
								"admin_label"		        => true,
								"description"		    	=> __( "Switch the toggle if you want to center all elements inside this container inside the row. You MUST set the row to full browser width (breakouts) in order to actually center the content!", "ts_visual_composer_extend" ),
								"dependency"            	=> ""
							),
							// Load Custom CSS/JS File
							array(
								"type"              		=> "load_file",
								"heading"           		=> __( "", "ts_visual_composer_extend" ),
								"value"             		=> "Animation Files",
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
	class WPBakeryShortCode_TS_VCSC_RowCenter_Frame extends WPBakeryShortCodesContainer {};
}

// Initialize "TS Animations" Class
if (class_exists('TS_RowCenter_Block')) {
	$TS_RowCenter_Block = new TS_RowCenter_Block;
}
?>