<?php
    if (function_exists('vc_map')) {
		vc_map( array(
			"name" 							=> __("Page - Order Tracking", "ts_visual_composer_extend"),
			"base" 							=> "woocommerce_order_tracking",
			"icon" 							=> "icon-wpb-ts_vcsc_icon_commerce_tracking", 
			"class" 						=> "", 
			"category" 						=> "VC WooCommerce",
            "description"					=> __("Place the 'Order Tracking' page", "ts_visual_composer_extend"),
            "admin_enqueue_js"				=> "",
            "admin_enqueue_css"				=> "",
			"show_settings_on_create" 		=> false,
			"params" => array(
				array(
					"type"              	=> "messenger",
					"heading"           	=> __( "", "ts_visual_composer_extend" ),
					"param_name"        	=> "messenger",
					"color"					=> "#006BB7",
					"weight"				=> "normal",
					"size"					=> "14",
					"value"					=> "",
					"message"            	=> __( "Lets a user see the status of an order by entering their order details.", "ts_visual_composer_extend" ),
					"description"       	=> __( "", "ts_visual_composer_extend" )
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
			)
		));
    }
?>