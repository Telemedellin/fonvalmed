<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
    if (function_exists('vc_map')) {
        vc_map( array(
            "name"                      	=> __( "TS Mixcloud Widget", "ts_visual_composer_extend" ),
            "base"                      	=> "TS_VCSC_Mixcloud",
            "icon" 	                    	=> "icon-wpb-ts_vcsc_mixcloud",
            "class"                     	=> "",
            "category"                  	=> __( "VC Extensions", "ts_visual_composer_extend" ),
            "description"               	=> __("Place a Mixcloud element", "ts_visual_composer_extend"),
            "admin_enqueue_js"        		=> "",
            "admin_enqueue_css"       		=> "",
            "params"                    	=> array(
                // Soundcloud Settings
                array(
                    "type"              	=> "seperator",
                    "heading"           	=> __( "", "ts_visual_composer_extend" ),
                    "param_name"        	=> "seperator_1",
					"value"					=> "",
                    "seperator"             => "Mixcloud URL",
                    "description"       	=> __( "", "ts_visual_composer_extend" )
                ),				
                array(
                    "type"              	=> "dropdown",
                    "heading"           	=> __( "Widget Type", "ts_visual_composer_extend" ),
                    "param_name"        	=> "type",
                    "width"             	=> 150,
                    "value"             	=> array(
                        __( 'Single Track', "ts_visual_composer_extend" )        	=> "single",
                        __( 'Playlist', "ts_visual_composer_extend" )          		=> "playlist",
                        __( 'User Profile', "ts_visual_composer_extend" )        	=> "profile",
                    ),
					"admin_label"       	=> true,
                    "description"       	=> __( "Select what kind of MixCloud widget you want to show.", "ts_visual_composer_extend" )
                ),
				// Single Track URL
				array (
					"type" 					=> "textfield",
					"class" 				=> "",
					"heading" 				=> __("Mixcloud Track URL", "ts_visual_composer_extend"),
					"param_name" 			=> "url_single",
					"value" 				=> "",
					"description" 			=> __("Enter Mixcloud URL; for example 'https://www.mixcloud.com/ebauche/live-at-the-ice-bar/'.", "ts_visual_composer_extend"),
					"admin_label"       	=> true,
					"dependency"        	=> array( 'element' => "type", 'value' => 'single' )
				),
				// Playlist URL
				array (
					"type" 					=> "textfield",
					"class" 				=> "",
					"heading" 				=> __("Mixcloud Playlist URL", "ts_visual_composer_extend"),
					"param_name" 			=> "url_playlist",
					"value" 				=> "",
					"description" 			=> __("Enter Mixcloud URL; for example 'https://www.mixcloud.com/ebauche/live-at-the-ice-bar/'.", "ts_visual_composer_extend"),
					"admin_label"       	=> true,
					"dependency"        	=> array( 'element' => "type", 'value' => 'playlist' )
				),
				// Single + Playlist Settings
				array(
					"type"					=> "switch_button",
                    "heading"           	=> __( "Show Mini Player", "ts_visual_composer_extend" ),
                    "param_name"        	=> "mini",
                    "value"             	=> "false",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"       	=> __( "Switch the toggle if you want to show the player in its miniature layout.", "ts_visual_composer_extend" ),
                    "dependency"        	=> array( 'element' => "type", 'value' => array('single', 'playlist') )
				),
				array(
					"type"					=> "switch_button",
                    "heading"           	=> __( "Show Light Skin", "ts_visual_composer_extend" ),
                    "param_name"        	=> "light",
                    "value"             	=> "false",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"       	=> __( "Switch the toggle if you want to show the player with its light skin.", "ts_visual_composer_extend" ),
                    "dependency"        	=> array( 'element' => "type", 'value' => array('single', 'playlist') )
				),
				array(
					"type"              	=> "colorpicker",
					"heading"           	=> __( "Text Link Color", "ts_visual_composer_extend" ),
					"param_name"        	=> "color",
					"value"             	=> "#1490e0",
					"description"       	=> __( "Define the color for any text links below the player.", "ts_visual_composer_extend" ),
					"dependency"        	=> array( 'element' => "type", 'value' => array('single', 'playlist') )
				),
				array(
					"type"					=> "switch_button",
                    "heading"           	=> __( "Show Artwork", "ts_visual_composer_extend" ),
                    "param_name"        	=> "artwork",
                    "value"             	=> "true",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"       	=> __( "Switch the toggle if you want to show album or track artwork.", "ts_visual_composer_extend" ),
                    "dependency"        	=> array( 'element' => "type", 'value' => array('single', 'playlist') )
				),
				array(
					"type"					=> "switch_button",
                    "heading"           	=> __( "Show Cover", "ts_visual_composer_extend" ),
                    "param_name"        	=> "cover",
                    "value"             	=> "true",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"       	=> __( "Switch the toggle if you want to show album or track cover.", "ts_visual_composer_extend" ),
                    "dependency"        	=> array( 'element' => "type", 'value' => array('single', 'playlist') )
				),
				array(
					"type"					=> "switch_button",
                    "heading"           	=> __( "Show Tracklist", "ts_visual_composer_extend" ),
                    "param_name"        	=> "tracklist",
                    "value"             	=> "false",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"       	=> __( "Switch the toggle if you want to show any associated tracklists.", "ts_visual_composer_extend" ),
                    "dependency"        	=> array( 'element' => "type", 'value' => array('single', 'playlist') )
				),
				array(
					"type"					=> "switch_button",
                    "heading"           	=> __( "AutoPlay Player", "ts_visual_composer_extend" ),
                    "param_name"        	=> "autoplay",
                    "value"             	=> "false",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"       	=> __( "Switch the toggle if you want to automatically start the player once loaded.", "ts_visual_composer_extend" ),
                    "dependency"        	=> array( 'element' => "type", 'value' => array('single', 'playlist') )
				),
				// Profile URL + Settings
				array (
					"type" 					=> "textfield",
					"class" 				=> "",
					"heading" 				=> __("Mixcloud Profile URL", "ts_visual_composer_extend"),
					"param_name" 			=> "url_profile",
					"value" 				=> "",
					"description" 			=> __("Enter Mixcloud URL; for example 'https://www.mixcloud.com/ebauche'.", "ts_visual_composer_extend"),
					"admin_label"       	=> true,
					"dependency"        	=> array( 'element' => "type", 'value' => 'profile' )
				),
				array(
					"type"					=> "switch_button",
                    "heading"           	=> __( "Show Follower Count", "ts_visual_composer_extend" ),
                    "param_name"        	=> "followers",
                    "value"             	=> "true",
					"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"					=> __( 'No', "ts_visual_composer_extend" ),
					"style"					=> "select",
					"design"				=> "toggle-light",
                    "description"       	=> __( "Switch the toggle if you want the number of followers for the user.", "ts_visual_composer_extend" ),
                    "dependency"        	=> array( 'element' => "type", 'value' => 'profile' )
				),
				// Other Settings
				array(
					"type"				    => "seperator",
					"heading"			    => __( "", "ts_visual_composer_extend" ),
					"param_name"		    => "seperator_2",
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
                    "min"                   => "0",
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
                    "min"                   => "0",
                    "max"                   => "200",
                    "step"                  => "1",
                    "unit"                  => 'px',
                    "description"           => __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
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