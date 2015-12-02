<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
    if (function_exists('vc_map')) {
        vc_map( array(
            "name"                      	=> __( "TS Title Typed", "ts_visual_composer_extend" ),
            "base"                      	=> "TS_VCSC_Title_Typed",
            "icon" 	                    	=> "icon-wpb-ts_vcsc_title_typed",
            "class"                     	=> "",
            "category"                  	=> __( "VC Extensions", "ts_visual_composer_extend" ),
            "description"               	=> __("Place a title with type effect", "ts_visual_composer_extend"),
            "admin_enqueue_js"        		=> "",
            "admin_enqueue_css"       		=> "",
            "params"                    	=> array(
                // Content Settings
                array(
                    "type"              	=> "seperator",
                    "heading"           	=> __( "", "ts_visual_composer_extend" ),
                    "param_name"        	=> "seperator_1",
					"value"					=> "",
                    "seperator"				=> "Title Content",
                    "description"       	=> __( "", "ts_visual_composer_extend" )
                ),
				array(
					"type"              	=> "switch_button",
					"heading"               => __( "Add Fixed String", "ts_visual_composer_extend" ),
					"param_name"            => "fixed_addition",
					"value"                 => "false",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"description"           => __( "Switch the toggle if you want to add a fixed pre-string to the animated segments.", "ts_visual_composer_extend" ),
				),
				array(
					"type"              	=> "textfield",
					"heading"           	=> __( "Fixed String", "ts_visual_composer_extend" ),
					"param_name"        	=> "fixed_string",
					"value"             	=> "",
					"description"       	=> __( "Enter an optional fixed text string to be shown before the animated segments.", "ts_visual_composer_extend" ),
					"dependency"        	=> array( 'element' => "fixed_addition", 'value' => 'true' ),
				),				
				array(
					"type"                  => "exploded_textarea",
					"heading"               => __( "Title Strings", "ts_visual_composer_extend" ),
					"param_name"            => "title_strings",
					"value"                 => "",
					"description"           => __( "Enter the individual title strings for the segments to be typed; seperate by line break (NO commas allowed).", "ts_visual_composer_extend" ),
					"dependency"            => ""
				),				
				array(
					"type"              	=> "dropdown",
					"heading"           	=> __( "Whitespace Handling", "ts_visual_composer_extend" ),
					"param_name"        	=> "whitespace",
					"width"             	=> 150,
					"value"             	=> array(
						__( "CSS: Pre-Wrap", "ts_visual_composer_extend" )					=> "pre-wrap",
						__( "CSS: Pre", "ts_visual_composer_extend" )                   	=> "pre",
						__( "CSS: Pre-Line", "ts_visual_composer_extend" )					=> "pre-line",
						__( "CSS: NoWrap", "ts_visual_composer_extend" )                   	=> "nowrap",
						__( "CSS: Normal", "ts_visual_composer_extend" )                   	=> "normal",
					),
					"dependency"        	=> array( 'element' => "mobile", 'value' => 'false' ),
					"description"       	=> __( "Select how white space inside the element should be handled. Learn more here:", "ts_visual_composer_extend" ) . ' <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/white-space" target="_blank">white-space</a>'
				),

				array(
					"type"              	=> "switch_button",
					"heading"               => __( "Show All Segments", "ts_visual_composer_extend" ),
					"param_name"            => "showall",
					"value"                 => "false",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"description"           => __( "Switch the toggle if you want to show all title segments once all animations have finished.", "ts_visual_composer_extend" ),
				),
				array(
					"type"              	=> "switch_button",
					"heading"               => __( "Use on Mobile", "ts_visual_composer_extend" ),
					"param_name"            => "mobile",
					"value"                 => "false",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"admin_label"			=> true,
					"description"           => __( "Switch the toggle if you want to show the animation on mobile devices.", "ts_visual_composer_extend" ),
				),
				array(
					"type"              	=> "dropdown",
					"heading"           	=> __( "Alternative Wrapper", "ts_visual_composer_extend" ),
					"param_name"        	=> "wrapper",
					"width"             	=> 150,
					"value"             	=> array(
						__( "H1", "ts_visual_composer_extend" )                      	=> "h1",
						__( "H2", "ts_visual_composer_extend" )                    		=> "h2",
						__( "H3", "ts_visual_composer_extend" )                   		=> "h3",
						__( "H4", "ts_visual_composer_extend" )                   		=> "h4",
						__( "H5", "ts_visual_composer_extend" )                   		=> "h5",
						__( "H6", "ts_visual_composer_extend" )                   		=> "h6",
					),
					"dependency"        	=> array( 'element' => "mobile", 'value' => 'false' ),
					"description"       	=> __( "Select the alternative wrapper for the title to be used on mobile devices.", "ts_visual_composer_extend" )
				),
				array(
					"type"              	=> "textfield",
					"heading"           	=> __( "Alternative Title", "ts_visual_composer_extend" ),
					"param_name"        	=> "title_mobile",
					"value"             	=> "",
					"dependency"        	=> array( 'element' => "mobile", 'value' => 'false' ),
					"description"       	=> __( "Provide an alternative title to be used on mobile devices.", "ts_visual_composer_extend" )
				),
				// Animation Settings
                array(
                    "type"              	=> "seperator",
                    "heading"           	=> __( "", "ts_visual_composer_extend" ),
                    "param_name"        	=> "seperator_2",
					"value"					=> "",
                    "seperator"				=> "Typing Setting",
                    "description"       	=> __( "", "ts_visual_composer_extend" ),
					"group" 				=> "Typing Settings",
                ),
				array(
					"type"              	=> "switch_button",
					"heading"               => __( "Trigger on Viewport", "ts_visual_composer_extend" ),
					"param_name"            => "viewport",
					"value"                 => "true",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"admin_label"			=> true,
					"description"           => __( "Switch the toggle if you want the animation to be triggered upon viewport entry.", "ts_visual_composer_extend" ),
					"group" 				=> "Typing Settings",
				),
				array(
					"type"                  => "nouislider",
					"heading"               => __( "Start Delay", "ts_visual_composer_extend" ),
					"param_name"            => "startdelay",
					"value"                 => "0",
					"min"                   => "0",
					"max"                   => "10000",
					"step"                  => "1",
					"unit"                  => 'ms',
					"description"           => __( "Define the start delay before the animation begins with the first segment.", "ts_visual_composer_extend" ),
					"group" 				=> "Typing Settings",
				),
				array(
					"type"                  => "nouislider",
					"heading"               => __( "Type Speed", "ts_visual_composer_extend" ),
					"param_name"            => "typespeed",
					"value"                 => "10",
					"min"                   => "0",
					"max"                   => "1000",
					"step"                  => "1",
					"unit"                  => '',
					"admin_label"			=> true,
					"description"           => __( "Define the typing speed for each segment; the higher the value, the slower.", "ts_visual_composer_extend" ),
					"group" 				=> "Typing Settings",
				),
				array(
					"type"                  => "nouislider",
					"heading"               => __( "Back Delay", "ts_visual_composer_extend" ),
					"param_name"            => "backdelay",
					"value"                 => "500",
					"min"                   => "0",
					"max"                   => "10000",
					"step"                  => "1",
					"unit"                  => 'ms',
					"description"           => __( "Define the back delay before the animation moves to the next segment.", "ts_visual_composer_extend" ),
					"group" 				=> "Typing Settings",
				),
				array(
					"type"                  => "nouislider",
					"heading"               => __( "Back Speed", "ts_visual_composer_extend" ),
					"param_name"            => "backspeed",
					"value"                 => "10",
					"min"                   => "0",
					"max"                   => "1000",
					"step"                  => "1",
					"unit"                  => '',
					"admin_label"			=> true,
					"description"           => __( "Define the back space speed for each segment; the higher the value, the slower.", "ts_visual_composer_extend" ),
					"group" 				=> "Typing Settings",
				),				
				array(
					"type"              	=> "switch_button",
					"heading"               => __( "Loop Animation", "ts_visual_composer_extend" ),
					"param_name"            => "loop",
					"value"                 => "false",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"admin_label"			=> true,
					"description"           => __( "Switch the toggle if you want to loop the typing animation.", "ts_visual_composer_extend" ),
					"group" 				=> "Typing Settings",
				),
				array(
					"type"                  => "nouislider",
					"heading"               => __( "Loop Count", "ts_visual_composer_extend" ),
					"param_name"            => "loopcount",
					"value"                 => "0",
					"min"                   => "0",
					"max"                   => "99",
					"step"                  => "1",
					"unit"                  => '',
					"description"           => __( "Define how many times the animation should be looped; set to '0' (zero) for infinite loops.", "ts_visual_composer_extend" ),
					"dependency"            => array( 'element' => "loop", 'value' => 'true' ),
					"group" 				=> "Typing Settings",
				),
				array(
					"type"              	=> "switch_button",
					"heading"               => __( "Show Cursor", "ts_visual_composer_extend" ),
					"param_name"            => "showcursor",
					"value"                 => "true",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"description"           => __( "Switch the toggle if you want to show a typing cursor.", "ts_visual_composer_extend" ),
					"group" 				=> "Typing Settings",
				),
				array(
					"type"              	=> "switch_button",
					"heading"               => __( "Remove Cursor", "ts_visual_composer_extend" ),
					"param_name"            => "removecursor",
					"value"                 => "false",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"description"           => __( "Switch the toggle if you want to remove the typing cursor once all animations have finished.", "ts_visual_composer_extend" ),
					"dependency"            => array( 'element' => "showcursor", 'value' => 'true' ),
					"group" 				=> "Typing Settings",
				),
                // Style Settings
                array(
                    "type"              	=> "seperator",
                    "heading"           	=> __( "", "ts_visual_composer_extend" ),
                    "param_name"        	=> "seperator_3",
					"value"					=> "",
                    "seperator"				=> "Style Settings",
                    "description"       	=> __( "", "ts_visual_composer_extend" ),
					"group" 				=> "Style Settings",
                ),
				array(
					"type"              	=> "switch_button",
                    "heading"           	=> __( "Add Line Effect", "ts_visual_composer_extend" ),
                    "param_name"        	=> "title_lines",
                    "value"             	=> "false",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
					"description"       	=> __( "Switch the toggle if you want to add lines before and after the title.", "ts_visual_composer_extend" ),
                    "dependency"        	=> "",
					"group" 				=> "Style Settings",
				),
                array(
                    "type"              	=> "fontsmanager",
                    "heading"           	=> __( "Font Family", "ts_visual_composer_extend" ),
                    "param_name"        	=> "font_family",
                    "value"             	=> "",
					"default"				=> "true",
					"connector"				=> "font_type",
                    "description"       	=> __( "Select the font to be used for the title text.", "ts_visual_composer_extend" ),
					"group" 				=> "Style Settings",
                ),
                array(
                    "type"              	=> "hidden_input",
                    "param_name"        	=> "font_type",
                    "value"             	=> "",
                    "description"       	=> __( "", "ts_visual_composer_extend" ),
					"group" 				=> "Style Settings",
                ),
                array(
                    "type"              	=> "nouislider",
                    "heading"           	=> __( "Font Size", "ts_visual_composer_extend" ),
                    "param_name"        	=> "font_size",
                    "value"             	=> "36",
                    "min"               	=> "16",
                    "max"               	=> "512",
                    "step"              	=> "1",
                    "unit"              	=> 'px',
					"admin_label"			=> true,
                    "description"       	=> __( "Select the font size for the animated text.", "ts_visual_composer_extend" ),
                    "dependency"        	=> "",
					"group" 				=> "Style Settings",
                ),
                array(
                    "type"              	=> "colorpicker",
                    "heading"           	=> __( "Prefix Font Color", "ts_visual_composer_extend" ),
                    "param_name"        	=> "fixed_color",
                    "value"             	=> "#000000",
                    "description"      	 	=> __( "Define the font color for the fixed pre-text.", "ts_visual_composer_extend" ),
                    "dependency"        	=> array( 'element' => "fixed_addition", 'value' => 'true' ),
					"group" 				=> "Style Settings",
                ),
                array(
                    "type"              	=> "colorpicker",
                    "heading"           	=> __( "Segment Font Color", "ts_visual_composer_extend" ),
                    "param_name"        	=> "font_color",
                    "value"             	=> "#000000",
                    "description"      	 	=> __( "Define the font color for the animated text.", "ts_visual_composer_extend" ),
                    "dependency"        	=> "",
					"group" 				=> "Style Settings",
                ),
                array(
                    "type"              	=> "colorpicker",
                    "heading"           	=> __( "Cursor Color", "ts_visual_composer_extend" ),
                    "param_name"        	=> "cursorcolor",
                    "value"             	=> "#cccccc",
                    "description"      	 	=> __( "Define the color for the animated cursor.", "ts_visual_composer_extend" ),
					"dependency"            => array( 'element' => "showcursor", 'value' => 'true' ),
					"group" 				=> "Style Settings",
                ),
                array(
                    "type"              	=> "dropdown",
                    "heading"           	=> __( "Font Weight", "ts_visual_composer_extend" ),
                    "param_name"        	=> "font_weight",
                    "width"             	=> 150,
                    "value"             	=> array(
                        __( 'Default', "ts_visual_composer_extend" )  => "inherit",
                        __( 'Bold', "ts_visual_composer_extend" )     => "bold",
                        __( 'Bolder', "ts_visual_composer_extend" )   => "bolder",
                        __( 'Normal', "ts_visual_composer_extend" )   => "normal",
                        __( 'Light', "ts_visual_composer_extend" )    => "300",
                    ),
                    "description"       	=> __( "Select the font weight for the animated text.", "ts_visual_composer_extend" ),
					"group" 				=> "Style Settings",
                ),
				array(
					"type"              	=> "dropdown",
					"heading"           	=> __( "Text Align", "ts_visual_composer_extend" ),
					"param_name"        	=> "font_align",
					"width"             	=> 150,
                    "value"             	=> array(
                        __( 'Center', "ts_visual_composer_extend" )   	=> "center",
                        __( 'Left', "ts_visual_composer_extend" )  		=> "left",
                        __( 'Right', "ts_visual_composer_extend" )     	=> "right",
                        __( 'Justify', "ts_visual_composer_extend" )   	=> "justify",
                    ),
					"description"       	=> __( "Select the alignment for the animated text.", "ts_visual_composer_extend" ),
					"dependency"        	=> "",
					"group" 				=> "Style Settings",
				),
				array(
					"type"                  => "nouislider",
					"heading"               => __( "Left / Right Padding", "ts_visual_composer_extend" ),
					"param_name"            => "padding",
					"value"                 => "15",
					"min"                   => "0",
					"max"                   => "100",
					"step"                  => "1",
					"unit"                  => 'px',
					"description"           => __( "Define the left/right padding for the title.", "ts_visual_composer_extend" ),
					"group" 				=> "Style Settings",
				),			
				// Other Settings
				array(
					"type"              	=> "seperator",
					"heading"           	=> __( "", "ts_visual_composer_extend" ),
					"param_name"        	=> "seperator_4",
					"value"					=> "",
					"seperator"             => "Other Settings",
					"description"       	=> __( "", "ts_visual_composer_extend" ),
					"group" 				=> "Other Settings",
				),
				array(
					"type"              	=> "nouislider",
					"heading"           	=> __( "Margin: Top", "ts_visual_composer_extend" ),
					"param_name"        	=> "margin_top",
					"value"             	=> "0",
					"min"               	=> "-50",
					"max"               	=> "200",
					"step"              	=> "1",
					"unit"              	=> 'px',
					"description"       	=> __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
					"group" 				=> "Other Settings",
				),
				array(
					"type"              	=> "nouislider",
					"heading"           	=> __( "Margin: Bottom", "ts_visual_composer_extend" ),
					"param_name"        	=> "margin_bottom",
					"value"             	=> "0",
					"min"               	=> "-50",
					"max"               	=> "200",
					"step"              	=> "1",
					"unit"              	=> 'px',
					"description"       	=> __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
					"group" 				=> "Other Settings",
				),
				array(
					"type"              	=> "textfield",
					"heading"           	=> __( "Define ID Name", "ts_visual_composer_extend" ),
					"param_name"        	=> "el_id",
					"value"             	=> "",
					"description"       	=> __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
					"group" 				=> "Other Settings",
				),
				array(
					"type"              	=> "textfield",
					"heading"           	=> __( "Extra Class Name", "ts_visual_composer_extend" ),
					"param_name"        	=> "el_class",
					"value"             	=> "",
					"description"       	=> __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
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
?>