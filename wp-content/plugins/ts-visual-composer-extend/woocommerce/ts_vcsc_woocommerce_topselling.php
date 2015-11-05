<?php
    if (function_exists('vc_map')) {
		vc_map( array(
			"name" 							=> __("Top Selling Products", "ts_visual_composer_extend"),
			"base" 							=> "best_selling_products",
			"icon" 							=> "icon-wpb-ts_vcsc_icon_commerce_topselling", 
			"class" 						=> "", 
			"category" 						=> __('VC WooCommerce', "ts_visual_composer_extend"),
            "description"					=> __("Place a list of top selling products", "ts_visual_composer_extend"),
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
					"message"            	=> __( "Lists the best selling products currently for sale.", "ts_visual_composer_extend" ),
					"description"       	=> __( "", "ts_visual_composer_extend" )
				),
				array(
					"type"              	=> "nouislider",
					"heading"           	=> __( "Number of Products", "ts_visual_composer_extend" ),
					"param_name"        	=> "per_page",
					"value"             	=> "12",
					"min"               	=> "1",
					"max"               	=> "50",
					"step"              	=> "1",
					"unit"              	=> '',
					"admin_label"       	=> true,
					"description"       	=> __( "Select the number of products to be shown.", "ts_visual_composer_extend" )
				),
				array(
					"type"              	=> "nouislider",
					"heading"           	=> __( "Number of Columns", "ts_visual_composer_extend" ),
					"param_name"        	=> "columns",
					"value"             	=> "4",
					"min"               	=> "1",
					"max"               	=> "10",
					"step"              	=> "1",
					"unit"              	=> '',
					"admin_label"       	=> true,
					"description"       	=> __( "Select the number of columns the products should be shown in.", "ts_visual_composer_extend" )
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