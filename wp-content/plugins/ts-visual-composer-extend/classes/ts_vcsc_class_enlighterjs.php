<?php
	if (!class_exists('TS_VCSC_EnlighterJS_Elements')){
		class TS_VCSC_EnlighterJS_Elements{
			function __construct(){
				global $VISUAL_COMPOSER_EXTENSIONS;
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
					add_action('init',                              		array($this, 'TS_VCENLIGHTER_Register_Elements'), 9999999);
				} else {
					add_action('admin_init',		                		array($this, 'TS_VCENLIGHTER_Register_Elements'), 9999999);
				}
				add_shortcode('TS_EnlighterJS_Snippet_Single',          	array($this, 'TS_VCENLIGHTER_Register_Single'));
				$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements++;
				$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements++;
				add_shortcode('TS_EnlighterJS_Snippet_Group',          		array($this, 'TS_VCENLIGHTER_Register_Group'));
				$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements++;
				$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements++;
				add_shortcode('TS_EnlighterJS_Snippet_Container',          	array($this, 'TS_VCENLIGHTER_Register_Container'));
				$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements++;
				$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements++;
			}
			
			function TS_VCENLIGHTER_Register_Single($atts, $content = null){
				global $VISUAL_COMPOSER_EXTENSIONS;
				ob_start();

				extract(shortcode_atts(array(
					"code_type"						=> "standard",
					"code_theme"					=> "enlighter",
					"code_height"					=> "full",
					"code_fixed"					=> 150,
					"code_content"					=> "",
					"code_lines"					=> "true",
					"code_offset"					=> 1,
					"code_highlight"				=> "",
					"code_indent"					=> 2,
					"code_double"					=> "true",
					"code_window_button"			=> "true",
					"code_window_text"				=> "New Window",
					"code_raw_button"				=> "true",
					"code_raw_text"					=> "RAW Code",
					"code_info_button"				=> "false",
					"code_info_text"				=> "EnlighterJS",
					"code_group"					=> "",
					"code_title"					=> "",
					"margin_top"					=> 0,
					"margin_bottom"					=> 0,
					"el_id"							=> "",
					"el_class"						=> "",
					"css"							=> "",
				), $atts));
				
				$randomizer							= mt_rand(999999, 9999999);
				
				if (!empty($el_id)) {
					$enlighter_id					= $el_id;
				} else {
					$enlighter_id					= 'ts-enlighterjs-container-' . $randomizer;
				}
				
				$output 							= '';
				
				if (($code_theme == "custom") && ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_UseThemeBuider == "false")) {
					$code_theme						= 'enlighter';
				}
	
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
					wp_enqueue_style('ts-extend-syntaxinit');
					$style 							= 'width: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
					$containerclass					= 'ts-enlighterjs-container-single-disabled';
				} else {
					$style 							= 'width: 100%; ' . ($code_height == "fixed" ? "height: " . $code_fixed . "px;" : "") . ' margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
					$containerclass	 				= 'ts-enlighterjs-container-single-enabled';
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndMooTools == "true") {
						wp_enqueue_script('ts-library-mootools');
					}
					wp_enqueue_style('ts-extend-enlighterjs');
					wp_enqueue_script('ts-extend-enlighterjs');
					wp_enqueue_style('ts-extend-syntaxinit');
					wp_enqueue_script('ts-extend-syntaxinit');
				}
				
				if (function_exists('vc_shortcode_custom_css_class')) {
					$css_class 						= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '' . $containerclass . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_EnlighterJS_Snippet_Single', $atts);
				} else {
					$css_class 						= $containerclass . ' ' . $el_class;
				}
				
				if ($code_type == 'no-highlight') {
					$pre_class						= 'ts-enlighterjs-pre-nohighlight';
					$pre_style						= '';
				} else {
					$pre_class						= '';
					$pre_style						= 'white-space: pre-wrap; height: 100%; margin: 0; padding: 0;';
				}
				
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
					$output .= '<div id="' . $enlighter_id . '" class="' . $css_class . '" style="' . $style . '" data-enlighter-doubleclick="' . $code_double . '" data-enlighter-windowbutton="' . $code_window_button . '" data-enlighter-windowtext="' . $code_window_text . '" data-enlighter-rawbutton="' . $code_raw_button . '" data-enlighter-rawtext="' . $code_raw_text . '" data-enlighter-infobutton="' . $code_info_button . '" data-enlighter-infotext="' . $code_info_text . '" data-enlighter-indent="' . $code_indent . '">';
						$output .= '<pre id="ts-enlighterjs-pre-' . $randomizer . '" class="' . $pre_class . '" style="' . $pre_style . '" data-enlighter-language="' . $code_type . '" data-enlighter-theme="' . $code_theme . '" data-enlighter-group="' . $code_group . '" data-enlighter-title="' . $code_title . '" data-enlighter-linenumbers="' . $code_lines . '" data-enlighter-lineoffset="' . $code_offset . '" data-enlighter-highlight="' . $code_highlight . '">';
							$output .= htmlentities(rawurldecode(base64_decode(strip_tags($code_content))));
						$output .= '</pre>';
					$output .= '</div>';
				} else {
					$output .= '<div id="' . $enlighter_id . '" class="ts-editor-enlighterjs-wrapper">';
						$output .= '<div class="ts-editor-enlighterjs-theme">' . $code_theme . '</div>';
						$output .= '<div class="ts-editor-enlighterjs-type">' . $code_type . '</div>';
						$output .= '<pre id="ts-enlighterjs-pre-' . $randomizer . '" class="ts-editor-enlighterjs-pre">';
							$output .= htmlentities(rawurldecode(base64_decode(strip_tags($code_content))));
						$output .= '</pre>';
					$output .= '</div>';
				}
				
				echo $output;
				
				$myvariable = ob_get_clean();
				return $myvariable;
			}
			function TS_VCENLIGHTER_Register_Group($atts, $content = null){
				global $VISUAL_COMPOSER_EXTENSIONS;
				ob_start();

				extract(shortcode_atts(array(
					"code_title"					=> "",
					"code_type"						=> "standard",
					"code_content"					=> "",
					"code_lines"					=> "true",
					"code_offset"					=> 1,
					"code_highlight"				=> "",				
					"css"							=> "",
				), $atts));
				
				$randomizer							= mt_rand(999999, 9999999);
				
				if (!empty($el_id)) {
					$enlighter_id					= $el_id;
				} else {
					$enlighter_id					= 'ts-enlighterjs-group-' . $randomizer;
				}
				
				$output 							= '';
				
				if (function_exists('vc_shortcode_custom_css_class')) {
					$css_class 						= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '' . vc_shortcode_custom_css_class($css, ' '), 'TS_EnlighterJS_Snippet_Group', $atts);
				} else {
					$css_class 						= '';
				}
				
				if ($code_type == 'no-highlight') {
					$pre_class						= 'ts-enlighterjs-pre-nohighlight';
					$pre_style						= '';
				} else {
					$pre_class						= '';
					$pre_style						= 'white-space: pre-wrap; height: 100%; margin: 0; padding: 0;';
				}

				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
					$output .= '<pre id="ts-enlighterjs-pre-' . $randomizer . '" class="' . $pre_class . '" style="' . $pre_style . '" data-enlighter-language="' . $code_type . '" data-enlighter-theme="" data-enlighter-title="' . $code_title . '" data-enlighter-linenumbers="' . $code_lines . '" data-enlighter-lineoffset="' . $code_offset . '" data-enlighter-highlight="' . $code_highlight . '">';
						$output .= htmlentities(rawurldecode(base64_decode(strip_tags($code_content))));
					$output .= '</pre>';
				} else {
					$output .= '<div id="' . $enlighter_id . '" class="ts-editor-enlighterjs-wrapper">';
						$output .= '<div class="ts-editor-enlighterjs-theme">N/A</div>';
						$output .= '<div class="ts-editor-enlighterjs-type">' . $code_type . '</div>';
						$output .= '<pre id="ts-enlighterjs-pre-' . $randomizer . '" class="ts-editor-enlighterjs-pre">';
							$output .= htmlentities(rawurldecode(base64_decode(strip_tags($code_content))));
						$output .= '</pre>';
					$output .= '</div>';
				}
				
				echo $output;
				
				$myvariable = ob_get_clean();
				return $myvariable;
			}
			function TS_VCENLIGHTER_Register_Container($atts, $content = null){
				global $VISUAL_COMPOSER_EXTENSIONS;
				ob_start();

				extract(shortcode_atts(array(
					"code_group"					=> "CodeGroup",
					"code_theme"					=> "enlighter",
					"code_indent"					=> 2,
					"code_double"					=> "true",
					"code_window_button"			=> "true",
					"code_window_text"				=> "New Window",
					"code_raw_button"				=> "true",
					"code_raw_text"					=> "RAW Code",
					"code_info_button"				=> "false",
					"code_info_text"				=> "EnlighterJS",					
					"margin_top"					=> 0,
					"margin_bottom"					=> 0,
					"el_id"							=> "",
					"el_class"						=> "",
					"css"							=> "",
				), $atts));
				
				$randomizer							= mt_rand(999999, 9999999);
				
				if (!empty($el_id)) {
					$enlighter_id					= $el_id;
				} else {
					$enlighter_id					= 'ts-enlighterjs-container-' . $randomizer;
				}
				
				$output 							= '';
				
				if (($code_theme == "custom") && ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_UseThemeBuider == "false")) {
					$code_theme						= 'enlighter';
				}
	
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
					wp_enqueue_style('ts-extend-syntaxinit');
					$style 							= 'width: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
					$containerclass					= 'ts-enlighterjs-container-group-disabled';
				} else {
					$style 							= 'width: 100%; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
					$containerclass	 				= 'ts-enlighterjs-container-group-enabled';
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndMooTools == "true") {
						wp_enqueue_script('ts-library-mootools');
					}
					wp_enqueue_style('ts-extend-enlighterjs');					
					wp_enqueue_script('ts-extend-enlighterjs');
					wp_enqueue_style('ts-extend-syntaxinit');
					wp_enqueue_script('ts-extend-syntaxinit');
				}
				
				if (function_exists('vc_shortcode_custom_css_class')) {
					$css_class 						= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '' . $containerclass . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_EnlighterJS_Snippet_Container', $atts);
				} else {
					$css_class 						= $containerclass . ' ' . $el_class;
				}
				
				$output .= '<div id="' . $enlighter_id . '" class="' . $css_class . '" style="' . $style . '" data-enlighter-randomizer="' . $randomizer . '" data-enlighter-theme="' . $code_theme . '" data-enlighter-group="' . $code_group . '" data-enlighter-doubleclick="' . $code_double . '" data-enlighter-windowbutton="' . $code_window_button . '" data-enlighter-windowtext="' . $code_window_text . '" data-enlighter-rawbutton="' . $code_raw_button . '" data-enlighter-rawtext="' . $code_raw_text . '" data-enlighter-infobutton="' . $code_info_button . '" data-enlighter-infotext="' . $code_info_text . '" data-enlighter-indent="' . $code_indent . '">';
					$output .= do_shortcode($content);
				$output .= '</div>';
				
				echo $output;
				
				$myvariable = ob_get_clean();
				return $myvariable;
			}
			
			function TS_VCENLIGHTER_Register_Elements() {
				global $VISUAL_COMPOSER_EXTENSIONS;
				// Single Code Block Element
				if (function_exists('vc_map')) {
					vc_map( array(
						"name"                      	=> __( "EnlighterJS Single Code", "ts_visual_composer_extend" ),
						"base"                      	=> "TS_EnlighterJS_Snippet_Single",
						"icon" 	                    	=> "icon-wpb-ts_vcsc_enlighter_single",
						"class"                     	=> "",
						"category"                  	=> __( "VC EnlighterJS", "ts_visual_composer_extend" ),
						"description"               	=> __("Place an EnlighterJS single code snippet", "ts_visual_composer_extend"),
						"admin_enqueue_js"            	=> "",
						"admin_enqueue_css"           	=> "",
						"js_view"     					=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorLivePreview == "true" ? "TS_VCSC_CodeSingleViewCustom" : ""),
						"params"                    	=> array(
							// Link Settings
							array(
								"type"              	=> "seperator",
								"heading"           	=> __( "", "ts_visual_composer_extend" ),
								"param_name"        	=> "seperator_1",
								"value"					=> "",
								"seperator"				=> "Snippet Settings",
								"description"       	=> __( "", "ts_visual_composer_extend" )
							),
							array(
								"type"                  => "dropdown",
								"heading"               => __( "Code Type", "ts_visual_composer_extend" ),
								"param_name"            => "code_type",
								"width"                 => 300,
								"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Selector_Types,
								"admin_label"           => true,
								"description"           => __( "Select the type of code snippet you want to highlight.", "ts_visual_composer_extend" ),
								"dependency"        	=> ""
							),
							array(
								"type"                  => "dropdown",
								"heading"               => __( "Code Theme", "ts_visual_composer_extend" ),
								"param_name"            => "code_theme",
								"width"                 => 300,
								"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Selector_Themes,
								"admin_label"           => true,
								"description"           => __( "Select the theme to be used to highlight the code snippet.", "ts_visual_composer_extend" ),
								"dependency"        	=> ""
							),							
							array(
								"type"              	=> "textarea_raw_html",
								"heading"           	=> __( "Code Content", "ts_visual_composer_extend" ),
								"param_name"        	=> "code_content",
								"value"             	=> base64_encode(""),
								"description"      	 	=> __( "Enter the code snippet you want to highlight.", "ts_visual_composer_extend" ),
							),
							// Height Setting
							array(
								"type"				    => "seperator",
								"heading"			    => __( "", "ts_visual_composer_extend" ),
								"param_name"		    => "seperator_2",
								"value"					=> "",
								"seperator"				=> "Height Settings",
								"description"		    => __( "", "ts_visual_composer_extend" ),
							),
							array(
								"type"                  => "dropdown",
								"heading"               => __( "Code Height", "ts_visual_composer_extend" ),
								"param_name"            => "code_height",
								"width"                 => 300,
								"value"                 => array(
									__( 'Full Height', "ts_visual_composer_extend" )		=> "full",
									__( 'Fixed Height', "ts_visual_composer_extend" )		=> "fixed",
								),
								"admin_label"           => true,
								"description"           => __( "Select the height setting for the code snippet block.", "ts_visual_composer_extend" ),
								"dependency"        	=> ""
							),
							array(
								"type"                  => "nouislider",
								"heading"               => __( "Fixed Height", "ts_visual_composer_extend" ),
								"param_name"            => "code_fixed",
								"value"                 => "150",
								"min"                   => "100",
								"max"                   => "1000",
								"step"                  => "1",
								"unit"                  => 'px',
								"description"       	=> __( "Define the fixed height setting for the code snippet block.", "ts_visual_composer_extend" ),
								"dependency"			=> array( 'element' => "code_height", 'value' => 'fixed' )
							),
							// Line Settings
							array(
								"type"				    => "seperator",
								"heading"			    => __( "", "ts_visual_composer_extend" ),
								"param_name"		    => "seperator_3",
								"value"					=> "",
								"seperator"				=> "Line Settings",
								"description"		    => __( "", "ts_visual_composer_extend" ),
							),
							array(
								"type"					=> "switch_button",
								"heading"           	=> __( "Line Numbering", "ts_visual_composer_extend" ),
								"param_name"        	=> "code_lines",
								"value"             	=> "true",
								"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"					=> __( 'No', "ts_visual_composer_extend" ),
								"style"					=> "select",
								"design"				=> "toggle-light",
								"description"       	=> __( "Switch the toggle to apply a line numbering to the code snippet.", "ts_visual_composer_extend" ),
								"admin_label"           => true,
							),
							array(
								"type"                  => "nouislider",
								"heading"               => __( "Line Offset", "ts_visual_composer_extend" ),
								"param_name"            => "code_offset",
								"value"                 => "1",
								"min"                   => "0",
								"max"                   => "1000",
								"step"                  => "1",
								"unit"                  => '',
								"description"       	=> __( "Define the start value for the line numbering.", "ts_visual_composer_extend" ),
								"dependency"			=> array( 'element' => "code_lines", 'value' => 'true' )
							),
							array(
								"type"              	=> "textfield",
								"heading"           	=> __( "Line Highlights", "ts_visual_composer_extend" ),
								"param_name"        	=> "code_highlight",
								"value"             	=> "",
								"description"       	=> __( "Enter a list of lines to point out, comma seperated (ranges are supported) e.g. '2,3,6-10'", "ts_visual_composer_extend" ),
							),
							array(
								"type"                  => "nouislider",
								"heading"               => __( "Line Indentation", "ts_visual_composer_extend" ),
								"param_name"            => "code_indent",
								"value"                 => "2",
								"min"                   => "-1",
								"max"                   => "10",
								"step"                  => "1",
								"unit"                  => '',
								"description"       	=> __( "Define number of spaces to replace tabs with (-1 means no replacement).", "ts_visual_composer_extend" ),
							),
							// Control Settings
							array(
								"type"				    => "seperator",
								"heading"			    => __( "", "ts_visual_composer_extend" ),
								"param_name"		    => "seperator_4",
								"value"					=> "",
								"seperator"				=> "Control Settings",
								"description"		    => __( "", "ts_visual_composer_extend" ),
								"group" 				=> "Control Settings",
							),
							array(
								"type"					=> "switch_button",
								"heading"           	=> __( "Toggle RAW/Highlighted", "ts_visual_composer_extend" ),
								"param_name"        	=> "code_double",
								"value"             	=> "true",
								"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"					=> __( 'No', "ts_visual_composer_extend" ),
								"style"					=> "select",
								"design"				=> "toggle-light",
								"description"       	=> __( "Switch the toggle to use a double click on the code snippet to switch between highlighted and raw display.", "ts_visual_composer_extend" ),
								"group" 				=> "Control Settings",
							),	
							array(
								"type"					=> "switch_button",
								"heading"           	=> __( "Show Window Button", "ts_visual_composer_extend" ),
								"param_name"        	=> "code_window_button",
								"value"             	=> "true",
								"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"					=> __( 'No', "ts_visual_composer_extend" ),
								"style"					=> "select",
								"design"				=> "toggle-light",
								"description"       	=> __( "Switch the toggle to show a button to open raw code in new window.", "ts_visual_composer_extend" ),
								"group" 				=> "Control Settings",
							),
							array(
								"type"                  => "textfield",
								"heading"               => __( "Window Button Text", "ts_visual_composer_extend" ),
								"param_name"            => "code_window_text",
								"value"                 => "New Window",
								"description"           => __( "Enter the tooltip text for the window button.", "ts_visual_composer_extend" ),
								"dependency"			=> array( 'element' => "code_window_button", 'value' => 'true' ),
								"group" 				=> "Control Settings",
							),
							array(
								"type"					=> "switch_button",
								"heading"           	=> __( "Show RAW Button", "ts_visual_composer_extend" ),
								"param_name"        	=> "code_raw_button",
								"value"             	=> "true",
								"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"					=> __( 'No', "ts_visual_composer_extend" ),
								"style"					=> "select",
								"design"				=> "toggle-light",
								"description"       	=> __( "Switch the toggle to show a button to switch between highlighted and raw code.", "ts_visual_composer_extend" ),
								"group" 				=> "Control Settings",
							),
							array(
								"type"                  => "textfield",
								"heading"               => __( "RAW Button Text", "ts_visual_composer_extend" ),
								"param_name"            => "code_raw_text",
								"value"                 => "RAW Code",
								"description"           => __( "Enter the tooltip text for the RAW button.", "ts_visual_composer_extend" ),
								"dependency"			=> array( 'element' => "code_raw_button", 'value' => 'true' ),
								"group" 				=> "Control Settings",
							),
							array(
								"type"					=> "switch_button",
								"heading"           	=> __( "Show Info Button", "ts_visual_composer_extend" ),
								"param_name"        	=> "code_info_button",
								"value"             	=> "false",
								"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"					=> __( 'No', "ts_visual_composer_extend" ),
								"style"					=> "select",
								"design"				=> "toggle-light",
								"description"       	=> __( "Switch the toggle to show a button, linking to the creator of the underlying syntax highlighter.", "ts_visual_composer_extend" ),
								"group" 				=> "Control Settings",
							),
							array(
								"type"                  => "textfield",
								"heading"               => __( "Info Button Text", "ts_visual_composer_extend" ),
								"param_name"            => "code_info_text",
								"value"                 => "EnlighterJS",
								"description"           => __( "Enter the tooltip text for the Info button.", "ts_visual_composer_extend" ),
								"dependency"			=> array( 'element' => "code_info_button", 'value' => 'true' ),
								"group" 				=> "Control Settings",
							),
							// Other Settings
							array(
								"type"				    => "seperator",
								"heading"			    => __( "", "ts_visual_composer_extend" ),
								"param_name"		    => "seperator_5",
								"value"					=> "",
								"seperator"				=> "Other Settings",
								"description"		    => __( "", "ts_visual_composer_extend" ),
								"group" 				=> "Other Settings",
							),
							array(
								"type"                  => "nouislider",
								"heading"               => __( "Margin: Top", "ts_visual_composer_extend" ),
								"param_name"            => "margin_top",
								"value"                 => "0",
								"min"                   => "-50",
								"max"                   => "200",
								"step"                  => "1",
								"unit"                  => 'px',
								"description"           => __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
								"group" 				=> "Other Settings",
							),
							array(
								"type"                  => "nouislider",
								"heading"               => __( "Margin: Bottom", "ts_visual_composer_extend" ),
								"param_name"            => "margin_bottom",
								"value"                 => "0",
								"min"                   => "-50",
								"max"                   => "200",
								"step"                  => "1",
								"unit"                  => 'px',
								"description"           => __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
								"group" 				=> "Other Settings",
							),
							array(
								"type"                  => "textfield",
								"heading"               => __( "Define ID Name", "ts_visual_composer_extend" ),
								"param_name"            => "el_id",
								"value"                 => "",
								"description"           => __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
								"group" 				=> "Other Settings",
							),
							array(
								"type"                  => "textfield",
								"heading"               => __( "Extra Class Name", "ts_visual_composer_extend" ),
								"param_name"            => "el_class",
								"value"                 => "",
								"description"           => __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
								"group" 				=> "Other Settings",
							),
							// Load Custom CSS/JS File
							array(
								"type"              	=> "load_file",
								"heading"           	=> __( "", "ts_visual_composer_extend" ),
								"param_name"        	=> "el_file",
								"value"             	=> "",
								"file_type"         	=> "js",
								"file_path"         	=> "js/ts-visual-composer-extend-element.min.js",
								"description"       	=> __( "", "ts_visual_composer_extend" )
							),
						))
					);
				}
				// Group Code Block Element
				if (function_exists('vc_map')) {
					vc_map( array(
						"name"                      	=> __( "EnlighterJS Group Code", "ts_visual_composer_extend" ),
						"base"                      	=> "TS_EnlighterJS_Snippet_Group",
						"icon" 	                    	=> "icon-wpb-ts_vcsc_enlighter_group",
						"class"                     	=> "",
						"content_element"				=> true,
						"as_child"						=> array('only' => 'TS_EnlighterJS_Snippet_Container'),
						"category"                  	=> __( 'VC EnlighterJS', "ts_visual_composer_extend" ),
						"description"               	=> __("Place an EnlighterJS code group section", "ts_visual_composer_extend"),
						"admin_enqueue_js"            	=> "",
						"admin_enqueue_css"           	=> "",
						"front_enqueue_js"				=> preg_replace( '/\s/', '%20', TS_VCSC_GetResourceURL('/js/frontend/ts-vcsc-frontend-syntax-single.min.js')),
						"front_enqueue_css"				=> "",
						"js_view"     					=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorLivePreview == "true" ? "TS_VCSC_CodeGroupViewCustom" : ""),
						"params"                    	=> array(
							// Link Settings
							array(
								"type"              	=> "seperator",
								"heading"           	=> __( "", "ts_visual_composer_extend" ),
								"param_name"        	=> "seperator_1",
								"value"					=> "",
								"seperator"				=> "Snippet Settings",
								"description"       	=> __( "", "ts_visual_composer_extend" )
							),
							array(
								"type"                  => "textfield",
								"heading"               => __( "Code Title", "ts_visual_composer_extend" ),
								"param_name"            => "code_title",
								"value"                 => "",
								"admin_label"           => true,
								"description"           => __( "Enter a unique title for this code snippet; if empty, the code type will be used instead.", "ts_visual_composer_extend" ),
							),
							array(
								"type"                  => "dropdown",
								"heading"               => __( "Code Type", "ts_visual_composer_extend" ),
								"param_name"            => "code_type",
								"width"                 => 300,
								"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Selector_Types,
								"admin_label"           => true,
								"description"           => __( "Select the type of code snippet you want to highlight.", "ts_visual_composer_extend" ),
								"dependency"        	=> ""
							),
							array(
								"type"              	=> "textarea_raw_html",
								"heading"           	=> __( "Code Content", "ts_visual_composer_extend" ),
								"param_name"        	=> "code_content",
								"value"             	=> base64_encode(""),
								"description"      	 	=> __( "Enter the code snippet you want to highlight.", "ts_visual_composer_extend" ),
							),
							// Line Settings
							array(
								"type"				    => "seperator",
								"heading"			    => __( "", "ts_visual_composer_extend" ),
								"param_name"		    => "seperator_2",
								"value"					=> "",
								"seperator"				=> "Line Settings",
								"description"		    => __( "", "ts_visual_composer_extend" ),
								"group"					=> "Line Settings",
							),
							array(
								"type"					=> "switch_button",
								"heading"           	=> __( "Line Numbering", "ts_visual_composer_extend" ),
								"param_name"        	=> "code_lines",
								"value"             	=> "true",
								"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"					=> __( 'No', "ts_visual_composer_extend" ),
								"style"					=> "select",
								"design"				=> "toggle-light",
								"description"       	=> __( "Switch the toggle to apply a line numbering to the code snippet.", "ts_visual_composer_extend" ),
								"admin_label"           => true,
								"group"					=> "Line Settings",
							),
							array(
								"type"                  => "nouislider",
								"heading"               => __( "Line Offset", "ts_visual_composer_extend" ),
								"param_name"            => "code_offset",
								"value"                 => "1",
								"min"                   => "0",
								"max"                   => "1000",
								"step"                  => "1",
								"unit"                  => '',
								"description"       	=> __( "Define the start value for the line numbering.", "ts_visual_composer_extend" ),
								"dependency"			=> array( 'element' => "code_lines", 'value' => 'true' ),
								"group"					=> "Line Settings",
							),
							array(
								"type"              	=> "textfield",
								"heading"           	=> __( "Line Highlights", "ts_visual_composer_extend" ),
								"param_name"        	=> "code_highlight",
								"value"             	=> "",
								"description"       	=> __( "Enter a list of lines to point out, comma seperated (ranges are supported) e.g. '2,3,6-10'", "ts_visual_composer_extend" ),
								"group"					=> "Line Settings",
							),
							// Load Custom CSS/JS File
							array(
								"type"              	=> "load_file",
								"heading"           	=> __( "", "ts_visual_composer_extend" ),
								"param_name"        	=> "el_file",
								"value"             	=> "",
								"file_type"         	=> "js",
								"file_path"         	=> "js/ts-visual-composer-extend-element.min.js",
								"description"       	=> __( "", "ts_visual_composer_extend" )
							),
						))
					);
				}
				// Container Code Block Element
				if (function_exists('vc_map')) {
					vc_map(array(
						"name"							=> __("EnlighterJS Group Container", "ts_visual_composer_extend"),
						"base"							=> "TS_EnlighterJS_Snippet_Container",
						"class"							=> "",
						"icon"							=> "icon-wpb-ts_vcsc_enlighter_container",
						"category"						=> __("VC EnlighterJS", "ts_visual_composer_extend"),
						"as_parent"						=> array('only' => 'TS_EnlighterJS_Snippet_Group'),
						"description"					=> __("Place an EnlighterJS code group container", "ts_visual_composer_extend"),
						"controls"						=> "full",
						"content_element"				=> true,
						"is_container"					=> true,
						"container_not_allowed"			=> false,
						"show_settings_on_create"		=> true,
						"admin_enqueue_js"				=> "",
						"admin_enqueue_css"				=> "",
						"front_enqueue_js"				=> preg_replace( '/\s/', '%20', TS_VCSC_GetResourceURL('/js/frontend/ts-vcsc-frontend-syntax-container.min.js')),
						"front_enqueue_css"				=> "",
						"js_view"						=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorLivePreview == "true" ? "TS_VCSC_CodeContainerViewCustom" : "VcColumnView"),
						"params"						=> array(
							// Group Name
							array(
								"type"				    => "seperator",
								"heading"			    => __( "", "ts_visual_composer_extend" ),
								"param_name"		    => "seperator_1",
								"value"					=> "",
								"seperator"				=> "Group Settings",
								"description"		    => __( "", "ts_visual_composer_extend" ),
							),
							array(
								"type"                  => "textfield",
								"heading"               => __( "Group Name", "ts_visual_composer_extend" ),
								"param_name"            => "code_group",
								"value"                 => "CodeGroup",
								"admin_label"           => true,
								"description"           => __( "Enter a unique name for the code group you want to create.", "ts_visual_composer_extend" ),
							),
							array(
								"type"                  => "dropdown",
								"heading"               => __( "Code Theme", "ts_visual_composer_extend" ),
								"param_name"            => "code_theme",
								"width"                 => 300,
								"value"                 => $VISUAL_COMPOSER_EXTENSIONS->TS_VCENLIGHTER_Selector_Themes,
								"admin_label"           => true,
								"description"           => __( "Select the theme to be used to highlight the code snippets.", "ts_visual_composer_extend" ),
								"dependency"        	=> ""
							),
							array(
								"type"                  => "nouislider",
								"heading"               => __( "Line Indentation", "ts_visual_composer_extend" ),
								"param_name"            => "code_indent",
								"value"                 => "2",
								"min"                   => "-1",
								"max"                   => "10",
								"step"                  => "1",
								"unit"                  => '',
								"description"       	=> __( "Define number of spaces to replace tabs with (-1 means no replacement).", "ts_visual_composer_extend" ),
							),
							// Control Settings
							array(
								"type"				    => "seperator",
								"heading"			    => __( "", "ts_visual_composer_extend" ),
								"param_name"		    => "seperator_2",
								"value"					=> "",
								"seperator"				=> "Control Settings",
								"description"		    => __( "", "ts_visual_composer_extend" ),
							),
							array(
								"type"					=> "switch_button",
								"heading"           	=> __( "Toggle RAW/Highlighted", "ts_visual_composer_extend" ),
								"param_name"        	=> "code_double",
								"value"             	=> "true",
								"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"					=> __( 'No', "ts_visual_composer_extend" ),
								"style"					=> "select",
								"design"				=> "toggle-light",
								"description"       	=> __( "Switch the toggle to use a double click on the code snippet to switch between highlighted and raw display.", "ts_visual_composer_extend" ),
							),
							array(
								"type"					=> "switch_button",
								"heading"           	=> __( "Show Window Button", "ts_visual_composer_extend" ),
								"param_name"        	=> "code_window_button",
								"value"             	=> "true",
								"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"					=> __( 'No', "ts_visual_composer_extend" ),
								"style"					=> "select",
								"design"				=> "toggle-light",
								"description"       	=> __( "Switch the toggle to show a button to open raw code in new window.", "ts_visual_composer_extend" ),
							),
							array(
								"type"                  => "textfield",
								"heading"               => __( "Window Button Text", "ts_visual_composer_extend" ),
								"param_name"            => "code_window_text",
								"value"                 => "New Window",
								"description"           => __( "Enter the tooltip text for the window button.", "ts_visual_composer_extend" ),
								"dependency"			=> array( 'element' => "code_window_button", 'value' => 'true' ),
							),
							array(
								"type"					=> "switch_button",
								"heading"           	=> __( "Show RAW Button", "ts_visual_composer_extend" ),
								"param_name"        	=> "code_raw_button",
								"value"             	=> "true",
								"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"					=> __( 'No', "ts_visual_composer_extend" ),
								"style"					=> "select",
								"design"				=> "toggle-light",
								"description"       	=> __( "Switch the toggle to show a button to switch between highlighted and raw code.", "ts_visual_composer_extend" ),
							),
							array(
								"type"                  => "textfield",
								"heading"               => __( "RAW Button Text", "ts_visual_composer_extend" ),
								"param_name"            => "code_raw_text",
								"value"                 => "RAW Code",
								"description"           => __( "Enter the tooltip text for the RAW button.", "ts_visual_composer_extend" ),
								"dependency"			=> array( 'element' => "code_raw_button", 'value' => 'true' ),
							),
							array(
								"type"					=> "switch_button",
								"heading"           	=> __( "Show Info Button", "ts_visual_composer_extend" ),
								"param_name"        	=> "code_info_button",
								"value"             	=> "false",
								"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
								"off"					=> __( 'No', "ts_visual_composer_extend" ),
								"style"					=> "select",
								"design"				=> "toggle-light",
								"description"       	=> __( "Switch the toggle to show a button, linking to the creator of the underlying syntax highlighter.", "ts_visual_composer_extend" ),
							),
							array(
								"type"                  => "textfield",
								"heading"               => __( "Info Button Text", "ts_visual_composer_extend" ),
								"param_name"            => "code_info_text",
								"value"                 => "EnlighterJS",
								"description"           => __( "Enter the tooltip text for the Info button.", "ts_visual_composer_extend" ),
								"dependency"			=> array( 'element' => "code_info_button", 'value' => 'true' ),
							),
							// Other Settings
							array(
								"type"				    => "seperator",
								"heading"			    => __( "", "ts_visual_composer_extend" ),
								"param_name"		    => "seperator_3",
								"value"					=> "",
								"seperator"				=> "Other Settings",
								"description"		    => __( "", "ts_visual_composer_extend" ),
								"group" 				=> "Other Settings",
							),
							array(
								"type"                  => "nouislider",
								"heading"               => __( "Margin: Top", "ts_visual_composer_extend" ),
								"param_name"            => "margin_top",
								"value"                 => "0",
								"min"                   => "-50",
								"max"                   => "200",
								"step"                  => "1",
								"unit"                  => 'px',
								"description"           => __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
								"group" 				=> "Other Settings",
							),
							array(
								"type"                  => "nouislider",
								"heading"               => __( "Margin: Bottom", "ts_visual_composer_extend" ),
								"param_name"            => "margin_bottom",
								"value"                 => "0",
								"min"                   => "-50",
								"max"                   => "200",
								"step"                  => "1",
								"unit"                  => 'px',
								"description"           => __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
								"group" 				=> "Other Settings",
							),
							array(
								"type"                  => "textfield",
								"heading"               => __( "Define ID Name", "ts_visual_composer_extend" ),
								"param_name"            => "el_id",
								"value"                 => "",
								"description"           => __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
								"group" 				=> "Other Settings",
							),
							array(
								"type"                  => "textfield",
								"heading"               => __( "Extra Class Name", "ts_visual_composer_extend" ),
								"param_name"            => "el_class",
								"value"                 => "",
								"description"           => __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
								"group" 				=> "Other Settings",
							),
							// Load Custom CSS/JS File
							array(
								"type"              	=> "load_file",
								"heading"           	=> __( "", "ts_visual_composer_extend" ),
								"param_name"        	=> "el_file",
								"value"             	=> "",
								"file_type"         	=> "js",
								"file_path"         	=> "js/ts-visual-composer-extend-element.min.js",
								"description"       	=> __( "", "ts_visual_composer_extend" )
							),
						),						
					));
				}
			}
		}
	}
	
	if (class_exists('WPBakeryShortCodesContainer')) {
		class WPBakeryShortCode_TS_EnlighterJS_Snippet_Container extends WPBakeryShortCodesContainer {};
	}
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_EnlighterJS_Snippet_Single extends WPBakeryShortCode {};
		class WPBakeryShortCode_TS_EnlighterJS_Snippet_Group extends WPBakeryShortCode {};
	}

	// Initialize "TS EnlighterJS Element" Class
	if (class_exists('TS_VCSC_EnlighterJS_Elements')) {
		$TS_VCSC_EnlighterJS_Elements = new TS_VCSC_EnlighterJS_Elements;
	}
?>