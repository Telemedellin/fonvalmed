<?php
    if (function_exists('vc_map')) {
		vc_map( array(
			"name" 							=> __("Single Topic Tags", "ts_visual_composer_extend"),
			"base" 							=> "bbp-single-tag",
			"icon" 							=> "icon-wpb-ts_vcsc_icon_bbpress_tagssingle", 
			"class" 						=> "", 
			"category" 						=> __('VC bbPress', "ts_visual_composer_extend"),
            "description"					=> __("Place a cloud of topic tags", "ts_visual_composer_extend"),
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
					"message"            	=> __( "This element will display a list of all topic tags.", "ts_visual_composer_extend" ),
					"description"       	=> __( "", "ts_visual_composer_extend" )
				),
				array(
					"type" 					=> "bbpress_tagslist",
					"heading" 				=> __("List of Tags", "ts_visual_composer_extend"),
					"param_name" 			=> "id"
				)
			)
		));
    }
?>