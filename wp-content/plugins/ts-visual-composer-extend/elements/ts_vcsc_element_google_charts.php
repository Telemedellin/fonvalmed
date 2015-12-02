<?php
    global $VISUAL_COMPOSER_EXTENSIONS;
    if (function_exists('vc_map')) {
        vc_map( array(
            "name"                      => __( "TS Google Charts", "ts_visual_composer_extend" ),
            "base"                      => "TS-VCSC-Google-Charts",
            "icon" 	                    => "icon-wpb-ts_vcsc_google_charts",
            "class"                     => "",
            "category"                  => __( "VC Extensions", "ts_visual_composer_extend" ),
            "description"               => __("Place a Google Charts element", "ts_visual_composer_extend"),
            "admin_enqueue_js"			=> "",
            "admin_enqueue_css"			=> "",
            "params"                    => array(
                // Chart Settings
                array(
                    "type"              => "seperator",
                    "heading"           => __( "", "ts_visual_composer_extend" ),
                    "param_name"        => "seperator_1",
                    "value"             => "",
					"seperator"			=> "General Chart Settings",
                    "description"       => __( "", "ts_visual_composer_extend" )
                ),
                array(
                    "type"              => "dropdown",
                    "heading"           => __( "Chart Type", "ts_visual_composer_extend" ),
                    "param_name"        => "chart_type",
                    "width"             => 150,
                    "value"             => array(
                        __( 'Pie', "ts_visual_composer_extend" )              	=> "pie",
                        __( 'Donut', "ts_visual_composer_extend" )            	=> "donut",
                        __( 'Bar', "ts_visual_composer_extend" )              	=> "bar",
                        __( 'Column', "ts_visual_composer_extend" )           	=> "column",
                        __( 'Area', "ts_visual_composer_extend" )             	=> "area",
						__( 'Line', "ts_visual_composer_extend" )             	=> "line",
                        __( 'Geo', "ts_visual_composer_extend" )              	=> "geo",
                        __( 'Combo', "ts_visual_composer_extend" )            	=> "combo",
                        __( 'Organization', "ts_visual_composer_extend" )     	=> "org",
                    ),
                    "admin_label"       => true,
                    "description"       => __( "Select the chart type.", "ts_visual_composer_extend" )
                ),
                array(
                    "type"              => "nouislider",
                    "heading"           => __( "Height in px", "ts_visual_composer_extend" ),
                    "param_name"        => "chart_height",
                    "value"             => "400",
                    "min"               => "100",
                    "max"               => "2048",
                    "step"              => "1",
                    "unit"              => 'px',
                    "description"       => __( "", "ts_visual_composer_extend" )
                ),
                array(
                    "type"              => "dropdown",
                    "heading"           => __( "Legend Position", "ts_visual_composer_extend" ),
                    "param_name"        => "chart_legend",
                    "width"             => 150,
                    "value"             => array(
                        __( 'Top', "ts_visual_composer_extend" )              	=> "top",
                        __( 'Right', "ts_visual_composer_extend" )            	=> "right",
                        __( 'Bottom', "ts_visual_composer_extend" )           	=> "bottom",
                        __( 'Left', "ts_visual_composer_extend" )             	=> "left",
                        __( 'None', "ts_visual_composer_extend" )             	=> "none",
                    ),
                    "description"       => __( "Select where the legend should be positioned.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => array('pie', 'donut', 'bar', 'area', 'combo') )
                ),
				array(
					"type"              => "switch_button",
					"heading"           => __( "Provide Image Version", "ts_visual_composer_extend" ),
					"param_name"        => "chart_image",
					"value"             => "false",
					"on"				=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"				=> __( 'No', "ts_visual_composer_extend" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
					"admin_label"       => true,
					"description"       => __( "Switch the toggle if you want to provide an image version of the chart for download purposes (requires browser canvas support; IE10+).", "ts_visual_composer_extend" ),
					"dependency"        => array( 'element' => "chart_type", 'value' => array('pie', 'donut', 'bar', 'column', 'area', 'line', 'geo', 'combo') )
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Title", "ts_visual_composer_extend" ),
					"param_name"        => "chart_title",
					"value"             => "",
                    "admin_label"       => true,
					"description"       => __( "Enter a title for your chart.", "ts_visual_composer_extend" ),
				),
				array(
					"type"              => "switch_button",
					"heading"           => __( "External Data Source", "ts_visual_composer_extend" ),
					"param_name"        => "chart_external_doc",
					"value"             => "false",
					"on"				=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"				=> __( 'No', "ts_visual_composer_extend" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
					"description"       => __( "Switch the toggle if you want to use a Google Doc Spreadsheet file as data source for the chart.", "ts_visual_composer_extend" ),                    
				),
				array(
					"type"              => "messenger",
					"heading"           => __( "", "ts_visual_composer_extend" ),
					"param_name"        => "messengerdoc",
					"color"				=> "#C40000",
					"weight"			=> "normal",
					"size"				=> "14",
					"value"				=> "",
					"message"           => __( "When enabling the external data source option, any chart data entered in the type specific chart settings will be ignored.", "ts_visual_composer_extend" ),
					"description"       => __( "", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_external_doc", 'value' => 'true' )
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Google Spreadsheet Key", "ts_visual_composer_extend" ),
					"param_name"        => "chart_external_key",
					"value"             => "",
					"description"       => __( "Enter the alpha-numeric key that identifies the Google Spreadsheet.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_external_doc", 'value' => 'true' )
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Google Spreadsheet Sheet", "ts_visual_composer_extend" ),
					"param_name"        => "chart_external_sheet",
					"value"             => "",
					"description"       => __( "Enter the GID number that identifies the actual sheet in the document that contains the data.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_external_doc", 'value' => 'true' )
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Google Spreadsheet Range", "ts_visual_composer_extend" ),
					"param_name"        => "chart_external_range",
					"value"             => "",
					"description"       => __( "Enter the range that identifies the area in the spreadsheet that contains the source data; for example: A1:C7. Leave empty for automatic search.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_external_doc", 'value' => 'true' )
				),
                array(
                    "type"              => "nouislider",
                    "heading"           => __( "Number of Header Rows", "ts_visual_composer_extend" ),
                    "param_name"        => "chart_external_header",
                    "value"             => "1",
                    "min"               => "0",
                    "max"               => "10",
                    "step"              => "1",
                    "unit"              => '',
                    "description"       => __( "Select how many rows in the data set represent the table header.", "ts_visual_composer_extend" ),
					"dependency"        => array( 'element' => "chart_external_doc", 'value' => 'true' )
                ),				
				// Type Specific Settings
                array(
                    "type"              => "seperator",
                    "heading"           => __( "", "ts_visual_composer_extend" ),
                    "param_name"        => "seperator_2",
                    "value"             => "",
					"seperator"			=> "Type Specific Chart Settings",
                    "description"       => __( "", "ts_visual_composer_extend" )
                ),
                // Pie + Donut Chart
                array(
                    "type"              => "dropdown",
                    "heading"           => __( "Slice Label", "ts_visual_composer_extend" ),
                    "param_name"        => "chart_label",
                    "width"             => 150,
                    "value"             => array(
                        __( 'Percentage', "ts_visual_composer_extend" )       	=> "percentage",
                        __( 'Value', "ts_visual_composer_extend" )            	=> "value",
                        __( 'Label', "ts_visual_composer_extend" )            	=> "label",
                        __( 'None', "ts_visual_composer_extend" )             	=> "none",
                    ),
                    "description"       => __( "Select what information should be shown on/for each slice.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => array('pie', 'donut') )
                ),
				array(
					"type"              => "switch_button",
					"heading"           => __( "3D Chart", "ts_visual_composer_extend" ),
					"param_name"        => "chart_pie_3d",
					"value"             => "true",
					"on"				=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"				=> __( 'No', "ts_visual_composer_extend" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
					"description"       => __( "Switch the toggle to show the chart in 3D.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'pie' )
				),
                array(
                    "type"              => "nouislider",
                    "heading"           => __( "Pie Hole Size", "ts_visual_composer_extend" ),
                    "param_name"        => "chart_pie_hole",
                    "value"             => "20",
                    "min"               => "20",
                    "max"               => "60",
                    "step"              => "1",
                    "unit"              => '%',
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'donut' )
                ),
                // Pie Chart
				array(
					"type"              => "textarea",
					"heading"           => __( "Data", "ts_visual_composer_extend" ),
					"param_name"        => "chart_pie_data",
					"value"             => "",
					"description"       => __( "Sample:", "ts_visual_composer_extend" ) . " ('Task', 'Hours per Day'), ('Work', 11), ('Sleep', 7), ('Eat', 2), ('Commute', 3)",
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'pie' )
				),
                // Donut Chart
				array(
					"type"              => "textarea",
					"heading"           => __( "Data", "ts_visual_composer_extend" ),
					"param_name"        => "chart_donut_data",
					"value"             => "",
					"description"       => __( "Sample:", "ts_visual_composer_extend" ) . " ('Task', 'Hours per Day'), ('Work', 11), ('Sleep', 7), ('Eat', 2), ('Commute', 3)",
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'donut' )
				),
                // Bar Chart
				array(
					"type"              => "textarea",
					"heading"           => __( "Data", "ts_visual_composer_extend" ),
					"param_name"        => "chart_bar_data",
					"value"             => "",
					"description"       => __( "Sample:", "ts_visual_composer_extend" ) . " ('Year', 'Sales', 'Expenses'),('2004', 1000, 400),('2005', 1170, 460),('2006', 660, 1120),('2007', 1030, 540)",
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'bar' )
				),
				array(
					"type"              => "switch_button",
					"heading"           => __( "Stack Values", "ts_visual_composer_extend" ),
					"param_name"        => "chart_bar_stack",
					"value"             => "false",
					"on"				=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"				=> __( 'No', "ts_visual_composer_extend" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
					"description"       => __( "Switch the toggle to stack the values into one bar for each category.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'bar' )
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Title Vertical Axis", "ts_visual_composer_extend" ),
					"param_name"        => "chart_bar_vertical",
					"value"             => "",
					"description"       => __( "Enter a title for the vertical axis of the chart.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'bar' )
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Title Horizontal Axis", "ts_visual_composer_extend" ),
					"param_name"        => "chart_bar_horizontal",
					"value"             => "",
					"description"       => __( "Enter a title for the horizontal axis of the chart.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'bar' )
				),
                // Column Chart
				array(
					"type"              => "textarea",
					"heading"           => __( "Data", "ts_visual_composer_extend" ),
					"param_name"        => "chart_column_data",
					"value"             => "",
					"description"       => __( "Sample:", "ts_visual_composer_extend" ) . " ('Year', 'Sales', 'Expenses'),('2004', 1000, 400),('2005', 1170, 460),('2006', 660, 1120),('2007', 1030, 540)",
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'column' )
				),
				array(
					"type"              => "switch_button",
					"heading"           => __( "Stack Values", "ts_visual_composer_extend" ),
					"param_name"        => "chart_column_stack",
					"value"             => "false",
					"on"				=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"				=> __( 'No', "ts_visual_composer_extend" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
					"description"       => __( "Switch the toggle to stack the values into one bar for each category.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'column' )
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Title Vertical Axis", "ts_visual_composer_extend" ),
					"param_name"        => "chart_column_vertical",
					"value"             => "",
					"description"       => __( "Enter a title for the vertical axis of the chart.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'column' )
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Title Horizontal Axis", "ts_visual_composer_extend" ),
					"param_name"        => "chart_column_horizontal",
					"value"             => "",
					"description"       => __( "Enter a title for the horizontal axis of the chart.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'column' )
				),
                // Area Chart
				array(
					"type"              => "textarea",
					"heading"           => __( "Data", "ts_visual_composer_extend" ),
					"param_name"        => "chart_area_data",
					"value"             => "",
					"description"       => __( "Sample:", "ts_visual_composer_extend" ) . " ('Year', 'Sales', 'Expenses'),('2004', 1000, 400),('2005', 1170, 460),('2006', 660, 1120),('2007', 1030, 540)",
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'area' )
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Title Vertical Axis", "ts_visual_composer_extend" ),
					"param_name"        => "chart_area_vertical",
					"value"             => "",
					"description"       => __( "Enter a title for the vertical axis of the chart.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'area' )
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Title Horizontal Axis", "ts_visual_composer_extend" ),
					"param_name"        => "chart_area_horizontal",
					"value"             => "",
					"description"       => __( "Enter a title for the horizontal axis of the chart.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'area' )
				),
				// Line Chart
				array(
					"type"              => "textarea",
					"heading"           => __( "Data", "ts_visual_composer_extend" ),
					"param_name"        => "chart_line_data",
					"value"             => "",
					"description"       => __( "Sample:", "ts_visual_composer_extend" ) . " ('Year', 'Sales', 'Expenses'),('2004', 1000, 400),('2005', 1170, 460),('2006', 660, 1120),('2007', 1030, 540)",
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'line' )
				),				
				array(
					"type"              => "switch_button",
					"heading"           => __( "Make Lines Curved", "ts_visual_composer_extend" ),
					"param_name"        => "chart_line_curved",
					"value"             => "false",
					"on"				=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"				=> __( 'No', "ts_visual_composer_extend" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
					"description"       => __( "Switch the toggle to show the lines curved instead of straight.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'line' )
				),				
				array(
					"type"              => "textfield",
					"heading"           => __( "Title Vertical Axis", "ts_visual_composer_extend" ),
					"param_name"        => "chart_line_vertical",
					"value"             => "",
					"description"       => __( "Enter a title for the vertical axis of the chart.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'line' )
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Title Horizontal Axis", "ts_visual_composer_extend" ),
					"param_name"        => "chart_line_horizontal",
					"value"             => "",
					"description"       => __( "Enter a title for the horizontal axis of the chart.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'line' )
				),
                // GeoMap Chart
				array(
					"type"              => "textarea",
					"heading"           => __( "Data", "ts_visual_composer_extend" ),
					"param_name"        => "chart_geo_data",
					"value"             => "",
					"description"       => __( "Sample:", "ts_visual_composer_extend" ) . " ('Country', 'Popularity'),('Germany', 200),('United States', 300),('Brazil', 400),('Canada', 500),('France', 600),('Russia', 700)",
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'geo' )
				),
                array(
                    "type"              => "dropdown",
                    "heading"           => __( "Map Region", "ts_visual_composer_extend" ),
                    "param_name"        => "chart_geo_region",
                    "width"             => 150,
                    "value"             => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_GeoMap_Regions,
                    "description"       => __( "Select the region for the GeoMap Chart.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'geo' )
                ),
                // Combo Chart
				array(
					"type"              => "textarea",
					"heading"           => __( "Data", "ts_visual_composer_extend" ),
					"param_name"        => "chart_combo_data",
					"value"             => "",
					"description"       => __( "Sample:", "ts_visual_composer_extend" ) . " ('Month','Bolivia','Ecuador','Madagascar','Papua New Guinea','Rwanda','Average'), ('2004/05',165,938,522,998,450,614.6), ('2005/06',135,1120,599,1268,288,682), ('2006/07',157,1167,587,807,397,623), ('2007/08',139,1110,615,968,215,609.4), ('2008/09',136,691,629,1026,366,569.6)",
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'combo' )
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Title Vertical Axis", "ts_visual_composer_extend" ),
					"param_name"        => "chart_combo_vertical",
					"value"             => "",
					"description"       => __( "Enter a title for the vertical axis of the chart.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'combo' )
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Title Horizontal Axis", "ts_visual_composer_extend" ),
					"param_name"        => "chart_combo_horizontal",
					"value"             => "",
					"description"       => __( "Enter a title for the horizontal axis of the chart.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'combo' )
				),
                // Organization Chart
				array(
					"type"              => "textarea",
					"heading"           => __( "Data", "ts_visual_composer_extend" ),
					"param_name"        => "chart_org_data",
					"value"             => "",
					"description"       => __( "Sample:", "ts_visual_composer_extend" ) . " ('Name','Manager','Tooltip'),('Mike Smith',null,'CEO'),( 'Jim Miller', 'Mike Smith','CFO'),('Alice White', 'Mike Smith','COO'), ('Candice Greer', 'Mike Smith','CAO'),('Robert Evans','Jim Miller',''),('Janet Bergen', 'Robert Evans',''),('Leslie Gray', 'Robert Evans','')",
                    "dependency"        => array( 'element' => "chart_type", 'value' => 'org' )
				),
				// Style Settings
                array(
                    "type"              => "seperator",
                    "heading"           => __( "", "ts_visual_composer_extend" ),
                    "param_name"        => "seperator_3",
                    "value"             => "",
					"seperator"			=> "Style Settings",
                    "description"       => __( "", "ts_visual_composer_extend" ),
					"group" 			=> "Style Settings",
                ),
				array(
					"type"              => "switch_button",
					"heading"           => __( "Transparent Background", "ts_visual_composer_extend" ),
					"param_name"        => "chart_transparent",
					"value"             => "true",
					"on"				=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"				=> __( 'No', "ts_visual_composer_extend" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
					"description"       => __( "Switch the toggle to make the chart background transparent.", "ts_visual_composer_extend" ),
                    "dependency"        => "",
					"group"				=> "Style Settings",
				),
				array(
					"type"				=> "colorpicker",
					"heading"			=> __( "Chart Background", "ts_visual_composer_extend" ),
					"param_name"		=> "chart_background",
					"value"				=> "#ffffff",
					"description"		=> __( "Define the background color for the chart.", "ts_visual_composer_extend" ),
					"dependency"		=> array( 'element' => "chart_transparent", 'value' => 'false' ),
					"group"				=> "Style Settings",
				),
				array(
					"type"              => "switch_button",
					"heading"           => __( "Chart Border", "ts_visual_composer_extend" ),
					"param_name"        => "chart_border_show",
					"value"             => "false",
					"on"				=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"				=> __( 'No', "ts_visual_composer_extend" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
					"description"       => __( "Switch the toggle to add a border to the chart element.", "ts_visual_composer_extend" ),
                    "dependency"        => "",
					"group"				=> "Style Settings",
				),
				array(
					"type"				=> "colorpicker",
					"heading"			=> __( "Border Color", "ts_visual_composer_extend" ),
					"param_name"		=> "chart_border_color",
					"value"				=> "#cccccc",
					"description"		=> __( "Define the background color for the chart.", "ts_visual_composer_extend" ),
					"dependency"		=> array( 'element' => "chart_border_show", 'value' => 'true' ),
					"group"				=> "Style Settings",
				),
                array(
                    "type"              => "nouislider",
                    "heading"           => __( "Border Width", "ts_visual_composer_extend" ),
                    "param_name"        => "chart_border_stroke",
                    "value"             => "1",
                    "min"               => "0",
                    "max"               => "20",
                    "step"              => "1",
                    "unit"              => 'px',
                    "description"       => __( "Select the border width for the chart element.", "ts_visual_composer_extend" ),
					"dependency"		=> array( 'element' => "chart_border_show", 'value' => 'true' ),
					"group"				=> "Style Settings",
                ),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "Start Color", "ts_visual_composer_extend" ),
					"param_name"        => "chart_geo_colorstart",
					"value"             => "#ffff00",
					"description"       => __( "Define the start color for the geo map chart.", "ts_visual_composer_extend" ),
					"dependency"        => array( 'element' => "chart_type", 'value' => 'geo' ),
					"group"				=> "Style Settings",
				),
				array(
					"type"              => "colorpicker",
					"heading"           => __( "End Color", "ts_visual_composer_extend" ),
					"param_name"        => "chart_geo_colorend",
					"value"             => "#ebe5d8",
					"description"       => __( "Define the end color for the geo map chart.", "ts_visual_composer_extend" ),
					"dependency"        => array( 'element' => "chart_type", 'value' => 'geo' ),
					"group"				=> "Style Settings",
				),
				array(
					"type"              => "switch_button",
					"heading"           => __( "Custom Data Colors", "ts_visual_composer_extend" ),
					"param_name"        => "chart_colors_custom",
					"value"             => "false",
					"on"				=> __( 'Yes', "ts_visual_composer_extend" ),
					"off"				=> __( 'No', "ts_visual_composer_extend" ),
					"style"				=> "select",
					"design"			=> "toggle-light",
					"description"       => __( "Switch the toggle if you want to add custom colors to each data set; otherwise automatic colors will be generated.", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_type", 'value' => array('pie', 'donut', 'bar', 'column', 'area', 'line', 'combo') ),
					"group"				=> "Style Settings",
				),
				array(
					"type"              => "messenger",
					"heading"           => __( "", "ts_visual_composer_extend" ),
					"param_name"        => "messenger",
					"color"				=> "#C40000",
					"weight"			=> "normal",
					"size"				=> "14",
					"value"				=> "",
					"message"           => __( "Leave empty for automatic colors; when entering custom colors for the chart sections, please ensure that you follow the sample format and provide one color for each data set. Otherwise, the chart will fail to render.", "ts_visual_composer_extend" ),
					"description"       => __( "", "ts_visual_composer_extend" ),
                    "dependency"        => array( 'element' => "chart_colors_custom", 'value' => 'true' ),
					"group"				=> "Style Settings",
				),
				array(
					"type"              => "textfield",
					"heading"           => __( "Data Colors", "ts_visual_composer_extend" ),
					"param_name"        => "chart_colors",
					"value"             => "",
					"description"       => __( "Sample:", "ts_visual_composer_extend" ) . " '#e0440e', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6'",
                    "dependency"        => array( 'element' => "chart_colors_custom", 'value' => 'true' ),
					"group"				=> "Style Settings",
				),
                // Other Google Chart Settings
                array(
                    "type"              => "seperator",
                    "heading"           => __( "", "ts_visual_composer_extend" ),
                    "param_name"        => "seperator_4",
                    "value"             => "",
					"seperator"			=> "Other Settings",
                    "description"       => __( "", "ts_visual_composer_extend" ),
					"group" 			=> "Other Settings",
                ),
                array(
                    "type"              => "nouislider",
                    "heading"           => __( "Margin: Top", "ts_visual_composer_extend" ),
                    "param_name"        => "margin_top",
                    "value"             => "0",
                    "min"               => "-250",
                    "max"               => "500",
                    "step"              => "1",
                    "unit"              => 'px',
                    "description"       => __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
					"group" 			=> "Other Settings",
                ),
                array(
                    "type"              => "nouislider",
                    "heading"           => __( "Margin: Bottom", "ts_visual_composer_extend" ),
                    "param_name"        => "margin_bottom",
                    "value"             => "0",
                    "min"               => "-250",
                    "max"               => "500",
                    "step"              => "1",
                    "unit"              => 'px',
                    "description"       => __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
					"group" 			=> "Other Settings",
                ),
                array(
                    "type"              => "textfield",
                    "heading"           => __( "Define ID Name", "ts_visual_composer_extend" ),
                    "param_name"        => "el_id",
                    "value"             => "",
                    "description"       => __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
					"group" 			=> "Other Settings",
                ),
                array(
                    "type"              => "textfield",
                    "heading"           => __( "Extra Class Name", "ts_visual_composer_extend" ),
                    "param_name"        => "el_class",
                    "value"             => "",
                    "description"       => __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
					"group" 			=> "Other Settings",
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