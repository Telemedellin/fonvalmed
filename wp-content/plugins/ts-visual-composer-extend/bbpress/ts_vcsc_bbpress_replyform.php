<?php
    if (function_exists('vc_map')) {
		vc_map( array(
			"name" 							=> __("Reply Form", "ts_visual_composer_extend"),
			"base" 							=> "bbp-reply-form",
			"icon" 							=> "icon-wpb-ts_vcsc_icon_bbpress_replyform", 
			"class" 						=> "", 
			"category" 						=> __('VC bbPress', "ts_visual_composer_extend"),
            "description"					=> __("Place a reply form", "ts_visual_composer_extend"),
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
					"message"            	=> __( "This element will display the 'New Reply' form.", "ts_visual_composer_extend" ),
					"description"       	=> __( "", "ts_visual_composer_extend" )
				)
			)
		));
    }
?>