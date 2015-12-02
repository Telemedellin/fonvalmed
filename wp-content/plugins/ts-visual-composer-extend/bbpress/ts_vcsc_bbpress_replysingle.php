<?php
    if (function_exists('vc_map')) {
		vc_map( array(
			"name" 							=> __("Single Reply", "ts_visual_composer_extend"),
			"base" 							=> "bbp-single-reply",
			"icon" 							=> "icon-wpb-ts_vcsc_icon_bbpress_replysingle", 
			"class" 						=> "", 
			"category" 						=> __('VC bbPress', "ts_visual_composer_extend"),
            "description"					=> __("Place a single reply", "ts_visual_composer_extend"),
            "admin_enqueue_js"				=> "",
            "admin_enqueue_css"				=> "",
			"show_settings_on_create" 		=> true,
			"params" 						=> array(
				array(
					"type"              	=> "messenger",
					"heading"           	=> __( "", "ts_visual_composer_extend" ),
					"param_name"        	=> "messenger",
					"color"					=> "#006BB7",
					"weight"				=> "normal",
					"size"					=> "14",
					"value"					=> "",
					"message"            	=> __( "This element will display a single reply.", "ts_visual_composer_extend" ),
					"description"       	=> __( "", "ts_visual_composer_extend" )
				),
				array(
					"type" 					=> "bbpress_replieslist",
					"heading" 				=> __("List of Replies", "ts_visual_composer_extend"),
					"param_name" 			=> "id"
				)
			)
		));
    }
?>