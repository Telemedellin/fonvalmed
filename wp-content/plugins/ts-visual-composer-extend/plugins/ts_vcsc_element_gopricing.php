<?php
    if (function_exists('vc_map')) {
		
		$pricingtables 					= get_option('go_pricing_tables', array());
		$TS_VCSC_GoPricing 				= array ();
		foreach ($pricingtables as $table) {
            $tableID 					= $pricing_table['table-id'];
            $tableName					= $pricing_table['table-name'];
			$TS_VCSC_GoPricing[$tableName]	= $tableID;
		};
		if (count($TS_VCSC_GoPricing) == 0) {
			$TS_VCSC_GoPricing[__("No Go Pricing Tables found!", "ts_visual_composer_extend")]	= '-1';
		}
		
        vc_map( array(
            "name"                      => __( "GoPricing Table", "ts_visual_composer_extend" ),
            "base"                      => "go_pricing",
            "icon" 	                    => "icon-wpb-ts_vcsc_go_pricing",
            "class"                     => "",
            "category"                  => __( '3rd Party Plugins', "ts_visual_composer_extend" ),
            "description"               => __("Place a GoPricing element", "ts_visual_composer_extend"),
            "admin_enqueue_js"			=> "",
            "admin_enqueue_css"			=> "",
            "params"                    => array(
                // GoPricing Settings
                array(
                    "type"              => "seperator",
                    "heading"           => __( "", "ts_visual_composer_extend" ),
                    "param_name"        => "seperator_1",
					"value"				=> "",
                    "seperator"			=> "GoPricing Tables",
                    "description"       => __( "", "ts_visual_composer_extend" )
                ),
                array(
                    "type"              => "dropdown",
                    "heading"           => __( "Pricing Table", "ts_visual_composer_extend" ),
                    "param_name"        => "id",
                    "width"             => 300,
                    "value"             => $TS_VCSC_GoPricing,
					"admin_label"       => true,
					"save_always" 		=> true,
                    "description"		=> __( "Select the GoPricing Table you want to insert.", "ts_visual_composer_extend" )
                ),
                array(
                    "type"              => "nouislider",
                    "heading"           => __( "Bottom Margin", "ts_visual_composer_extend" ),
                    "param_name"        => "margin_bottom",
                    "value"             => "20",
                    "min"               => "0",
                    "max"               => "500",
                    "step"              => "1",
                    "unit"              => 'px',
                    "description"       => __( "Define a bottom margin for the GoPricing Table.", "ts_visual_composer_extend" )
                ),
                array(
                    "type"              => "messenger",
                    "heading"           => __( "", "ts_visual_composer_extend" ),
                    "param_name"        => "messenger",
					"color"				=> "#FF0000",
					"weight"			=> "bold",
					"value"				=> "",
                    "message"           => __( "Please make sure that the GoPricing Tables Plugin is installed and activated.", "ts_visual_composer_extend" ),
                    "description"       => __( "", "ts_visual_composer_extend" )
                ),
				// Load Custom CSS/JS File
				array(
					"type"              => "load_file",
					"heading"           => __( "", "ts_visual_composer_extend" ),
                    "param_name"        => "el_file",
					"value"             => "",
					"file_type"         => "js",
					"file_path"         => "js/ts-visual-composer-extend-element.min.js",
					"description"       => __( "", "ts_visual_composer_extend" )
				),
            ))
        );
    }
?>