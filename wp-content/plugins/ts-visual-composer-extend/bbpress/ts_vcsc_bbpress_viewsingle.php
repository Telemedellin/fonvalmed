<?php
    if (function_exists('vc_map')) {
		vc_map( array(
			"name" 							=> __("Single View", "ts_visual_composer_extend"),
			"base" 							=> "bbp-single-view",
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
					"message"            	=> __( "This element will display topics associated with a specific view.", "ts_visual_composer_extend" ),
					"description"       	=> __( "", "ts_visual_composer_extend" )
				),
				array(
					"type" 					=> "dropdown",
					"heading" 				=> __("View", "ts_visual_composer_extend"),
					"param_name" 			=> "id",
					"value" 				=> array(
						__("Popular", "ts_visual_composer_extend")			=>'popular',
						__("No replies", "ts_visual_composer_extend")		=>'no-replies'
					)
				)
			)
		));
    }
?>