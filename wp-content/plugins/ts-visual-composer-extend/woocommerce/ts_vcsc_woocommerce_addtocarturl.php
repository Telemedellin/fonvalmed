<?php
    if (function_exists('vc_map')) {
		vc_map( array(
			"name" 							=> __("Add to Cart URL", "ts_visual_composer_extend"),
			"base" 							=> "add_to_cart_url",
			"icon" 							=> "icon-wpb-ts_vcsc_icon_commerce_addtocarturl", 
			"class" 						=> "", 
			"category" 						=> __('VC WooCommerce', "ts_visual_composer_extend"),
            "description"					=> __("Place the 'Add to Cart Link' for a product", "ts_visual_composer_extend"),
            "admin_enqueue_js"				=> "",
            "admin_enqueue_css"				=> "",
			"params" 						=> array(
				array(
					"type"              	=> "messenger",
					"heading"           	=> __( "", "ts_visual_composer_extend" ),
					"param_name"        	=> "messenger",
					"color"					=> "#006BB7",
					"weight"				=> "normal",
					"size"					=> "14",
					"value"					=> "",
					"message"            	=> __( "Shows the URL of the add to cart button of a single product by ID.", "ts_visual_composer_extend" ),
					"description"       	=> __( "", "ts_visual_composer_extend" )
				),
				array(
					"type" 					=> "wc_single_product",
					"heading" 				=> __("Product", "ts_visual_composer_extend"),
					"param_name" 			=> "id",
					"admin_label"       	=> true,
					"description"       	=> __( "Select the product you want to utilize.", "ts_visual_composer_extend" ),
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