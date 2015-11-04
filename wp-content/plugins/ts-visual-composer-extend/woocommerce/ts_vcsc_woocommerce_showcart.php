<?php
    if (function_exists('vc_map')) {
		vc_map( array(
			"name" 							=> __("Page - Shopping Cart", "ts_visual_composer_extend"),
			"base" 							=> "woocommerce_cart",
			"icon" 							=> "icon-wpb-ts_vcsc_icon_commerce_cart", 
			"class" 						=> "", 
			"category" 						=> __('VC WooCommerce', "ts_visual_composer_extend"),
            "description"					=> __("Place the 'Shopping Cart' page", "ts_visual_composer_extend"),
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
					"message"            	=> __( "Used on the cart page, the cart shortcode displays the cart contents and interface for coupon codes and other cart bits and pieces.", "ts_visual_composer_extend" ),
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