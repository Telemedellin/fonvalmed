<?php
    if (function_exists('vc_map')) {
		vc_map( array(
			"name" 							=> __("Single Product", "ts_visual_composer_extend"),
			"base" 							=> "product",
			"icon" 							=> "icon-wpb-ts_vcsc_icon_commerce_singleproduct", 
			"class" 						=> "", 
			"category" 						=> __('VC WooCommerce', "ts_visual_composer_extend"),
            "description"					=> __("Place a single product", "ts_visual_composer_extend"),
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
					"message"            	=> __( "Shows a preview for a single selected product.", "ts_visual_composer_extend" ),
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