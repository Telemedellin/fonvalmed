<?php
    if (function_exists('vc_map')) {
		vc_map( array(
		   "name" 							=> __("Multiple Products", "ts_visual_composer_extend"),
		   "base" 							=> "products",
		   "icon" 							=> "icon-wpb-ts_vcsc_icon_commerce_multipleproducts", 
		   "class" 							=> "", 
		   "category" 						=> __('VC WooCommerce', "ts_visual_composer_extend"),
            "description"					=> __("Place a list of products", "ts_visual_composer_extend"),
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
					"message"            	=> __( "Shows multiple selected products.", "ts_visual_composer_extend" ),
					"description"       	=> __( "", "ts_visual_composer_extend" )
				),
				array(
					"type" 					=> "wc_multiple_products",
					"heading" 				=> __("Products", "ts_visual_composer_extend"),
					"param_name" 			=> "ids",
					"admin_label"       	=> true,
					"description" 			=> "Please select the products you want to use or exclude for the element."  
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
						__("Ascending", "ts_visual_composer_extend")		=>	'asc',
						__("Descending", "ts_visual_composer_extend")		=>	'desc',
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