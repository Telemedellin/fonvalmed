<?php
    if (function_exists('vc_map')) {
		vc_map( array(
			"name" 							=> __("Products in Single Category", "ts_visual_composer_extend"),
			"base" 							=> "product_category",
			"icon" 							=> "icon-wpb-ts_vcsc_icon_commerce_singlecategory", 
			"class" 						=> "", 
			"category" 						=> __('VC WooCommerce', "ts_visual_composer_extend"),
            "description"					=> __("Place a list of products in a category", "ts_visual_composer_extend"),
            "admin_enqueue_js"				=> "",
            "admin_enqueue_css"				=> "",
			"params" => array(
				array(
					"type"              	=> "messenger",
					"heading"           	=> __( "", "ts_visual_composer_extend" ),
					"param_name"        	=> "messenger",
					"color"					=> "#006BB7",
					"weight"				=> "normal",
					"size"					=> "14",
					"value"					=> "",
					"message"            	=> __( "Shows a number of products in one specified category.", "ts_visual_composer_extend" ),
					"description"       	=> __( "", "ts_visual_composer_extend" )
				),
				array(
					"type" 					=> "wc_single_product_category",
					"heading" 				=> __("Category", "ts_visual_composer_extend"),
					"param_name" 			=> "category",
					"admin_label"       	=> true,
					"description"       	=> __( "Select the category that you want to utilize.", "ts_visual_composer_extend" ),
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
				array(
					"type" 					=> "dropdown",
					"heading" 				=> __("Order By", "ts_visual_composer_extend"),
					"param_name" 			=> "orderby",
					"value" 				=> array(
						__("Title", "ts_visual_composer_extend")			=>	'title',
						__("Date", "ts_visual_composer_extend")				=>	'date',
						__("ID", "ts_visual_composer_extend")				=>	'id',
						__("Menu Order", "ts_visual_composer_extend")		=>	'menu_order',
						__("Random", "ts_visual_composer_extend")			=>	'rand',
					),
					"admin_label"       	=> true,
					"description"       	=> __( "Select in by which order criterium the products should be sorted.", "ts_visual_composer_extend" )
				),
				array(
					"type" 					=> "dropdown",
					"heading" 				=> __("Order", "ts_visual_composer_extend"),
					"param_name" 			=> "order",
					"value" 				=> array(
						__("Descending", "ts_visual_composer_extend")		=>	'desc',
						__("Ascending", "ts_visual_composer_extend")		=>	'asc',
					),
					"admin_label"       	=> true,
					"description"       	=> __( "Select in which order the products should be sorted.", "ts_visual_composer_extend" )
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