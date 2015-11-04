<?php
    if (function_exists('vc_map')) {
		vc_map( array(
			"name" 							=> __("Page - My Account", "ts_visual_composer_extend"),
			"base" 							=> "woocommerce_my_account",
			"icon" 							=> "icon-wpb-ts_vcsc_icon_commerce_myaccount", 
			"class" 						=> "", 
			"category" 						=> __('VC WooCommerce', "ts_visual_composer_extend"),
            "description"					=> __("Place the 'My Account' page", "ts_visual_composer_extend"),
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
					"message"            	=> __( "Shows the 'My Account' section where the customer can view past orders and update their information.", "ts_visual_composer_extend" ),
					"description"       	=> __( "", "ts_visual_composer_extend" )
				),
				array(
					"type"              	=> "nouislider",
					"heading"           	=> __( "Number of Orders", "ts_visual_composer_extend" ),
					"param_name"        	=> "order_count",
					"value"             	=> "15",
					"min"               	=> "-1",
					"max"               	=> "50",
					"step"              	=> "1",
					"unit"              	=> '',
					"admin_label"       	=> true,
					"description"       	=> __( "Select the number of orders to be shown; (use -1 to display all orders).", "ts_visual_composer_extend" )
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