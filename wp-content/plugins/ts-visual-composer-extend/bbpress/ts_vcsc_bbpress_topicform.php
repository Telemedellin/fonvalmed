<?php
    if (function_exists('vc_map')) {
		vc_map( array(
			"name" 							=> __("New Topic Form", "ts_visual_composer_extend"),
			"base" 							=> "bbp-topic-form",
			"icon" 							=> "icon-wpb-ts_vcsc_icon_bbpress_topicform", 
			"class" 						=> "", 
			"category" 						=> __('VC bbPress', "ts_visual_composer_extend"),
            "description"					=> __("Place a list of recent topics", "ts_visual_composer_extend"),
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
					"message"            	=> __( "This element will display the 'New Topic' form where you can choose from a drop down menu the forum that this topic is to be associated with.", "ts_visual_composer_extend" ),
					"description"       	=> __( "", "ts_visual_composer_extend" )
				),
				array(
					"type" 					=> "bbpress_forumslist",
					"allforums"				=> "true",
					"heading" 				=> __("List of Forums", "ts_visual_composer_extend"),
					"param_name" 			=> "id"
				)
			)
		));
    }
?>