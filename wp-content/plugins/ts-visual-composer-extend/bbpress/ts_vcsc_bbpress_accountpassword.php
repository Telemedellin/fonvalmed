<?php
    if (function_exists('vc_map')) {
		vc_map( array(
			"name" 							=> __("Lost Password Screen", "ts_visual_composer_extend"),
			"base" 							=> "bbp-lost-pass",
			"icon" 							=> "icon-wpb-ts_vcsc_icon_bbpress_accountpassword", 
			"class" 						=> "", 
			"category" 						=> __('VC bbPress', "ts_visual_composer_extend"),
            "description"					=> __("Place a lost password screen", "ts_visual_composer_extend"),
            "admin_enqueue_js"				=> "",
            "admin_enqueue_css"				=> "",
			"show_settings_on_create" 		=> false,
			"params" 						=> array(
				array(
					"type"              	=> "messenger",
					"heading"           	=> __( "", "ts_visual_composer_extend" ),
					"param_name"        	=> "messenger",
					"color"					=> "#006BB7",
					"weight"				=> "normal",
					"size"					=> "14",
					"value"					=> "",
					"message"            	=> __( "This element will display the lost password screen.", "ts_visual_composer_extend" ),
					"description"       	=> __( "", "ts_visual_composer_extend" )
				),
			)
		));
    }
?>