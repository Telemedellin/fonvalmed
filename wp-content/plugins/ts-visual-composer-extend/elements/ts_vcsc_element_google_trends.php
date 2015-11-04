<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
    if (function_exists('vc_map')) {
        vc_map( array(
            "name"                      => __( "TS Google Trends", "ts_visual_composer_extend" ),
            "base"                      => "TS-VCSC-Google-Trends",
            "icon" 	                    => "icon-wpb-ts_vcsc_google_trends",
            "class"                     => "",
            "category"                  => __( "VC Extensions", "ts_visual_composer_extend" ),
            "description"               => __("Place a Google Trends element", "ts_visual_composer_extend"),
            "admin_enqueue_js"			=> "",
            "admin_enqueue_css"			=> "",
            "params"                    => array(
                // Google Trends Settings
                array(
                    "type"              => "seperator",
                    "heading"           => __( "", "ts_visual_composer_extend" ),
                    "param_name"        => "seperator_1",
					"value"				=> "",
                    "seperator"			=> "Google Trend Settings",
                    "description"       => __( "", "ts_visual_composer_extend" )
                ),
                array(
                    "type"              => "nouislider",
                    "heading"           => __( "Height in px", "ts_visual_composer_extend" ),
                    "param_name"        => "trend_height",
                    "value"             => "400",
                    "min"               => "100",
                    "max"               => "2048",
                    "step"              => "1",
                    "unit"              => 'px',
                    "description"       => __( "", "ts_visual_composer_extend" )
                ),
                array(
                    "type"              => "nouislider",
                    "heading"           => __( "Width in px", "ts_visual_composer_extend" ),
                    "param_name"        => "trend_width",
                    "value"             => "1024",
                    "min"               => "100",
                    "max"               => "2048",
                    "step"              => "1",
                    "unit"              => 'px',
                    "description"       => __( "", "ts_visual_composer_extend" )
                ),
				array(
					"type"              => "switch_button",
					"heading"           => __( "Show Trend Averages", "ts_visual_composer_extend" ),
					"param_name"        => "trend_average",
					"value"             => "false",
					"on"				=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"				=> __( 'No', "ts_visual_composer_extend" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
                    "description"		=> __( "Switch the toggle to show or hide trend averages.", "ts_visual_composer_extend" ),
                    "dependency"		=> ""
				),
				array(
					"type"              => "textarea",
					"heading"           => __( "Tags", "ts_visual_composer_extend" ),
					"param_name"        => "trend_tags",
					"value"             => "",
                    "admin_label"       => true,
					"description"       => __( "Enter the keywords (maximum of 5), seperated by comma.", "ts_visual_composer_extend" )
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Geo-Location", "ts_visual_composer_extend" ),
					"param_name"        => "trend_geo",
					"value"             => "US",
					"description"       => __( "Enter the Geo Location for your trend (default is US).", "ts_visual_composer_extend" )
				),
				// Load Custom CSS/JS File
				array(
					"type"              => "load_file",
					"heading"           => __( "", "ts_visual_composer_extend" ),
                    "param_name"        => "el_file",
					"value"             => "",
					"file_type"         => "js",
					"file_path"         => "js/ts-visual-composer-extend-element.min.js",
					"description"       => __( "", "ts_visual_composer_extend" )
				),
            ))
        );
    }
?>