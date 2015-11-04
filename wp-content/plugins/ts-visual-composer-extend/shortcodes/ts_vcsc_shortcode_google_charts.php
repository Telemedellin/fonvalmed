<?php
	add_shortcode('TS-VCSC-Google-Charts', 'TS_VCSC_Google_Charts_Function');
	add_shortcode('TS_VCSC_Google_Charts', 'TS_VCSC_Google_Charts_Function');
	function TS_VCSC_Google_Charts_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
			$charts_frontend				= "true";
		} else {
			$charts_frontend				= "false";
		}

		wp_enqueue_style('ts-extend-google-charts');
		wp_enqueue_style('ts-visual-composer-extend-front');

		extract( shortcode_atts( array(
			'chart_height'					=> '400',
			'chart_type'					=> 'pie',
			'chart_legend'					=> 'top',
			'chart_title'					=> '',
			'chart_label'					=> 'percentage',
			'chart_image'					=> 'false',
			'chart_transparent'				=> 'true',
			'chart_background'				=> '#ffffff',
			'chart_colors_custom'			=> 'false',
			'chart_colors'					=> '',
			'chart_border_show'				=> 'false',
			'chart_border_color'			=> '#cccccc',
			'chart_border_stroke'			=> 1,			
			'chart_external_doc'			=> 'false',
			'chart_external_key'			=> '',
			'chart_external_sheet'			=> '',
			'chart_external_range'			=> '',
			'chart_external_header'			=> 1,		
			'chart_pie_3d'					=> 'true',
			'chart_pie_hole'				=> 20,
			'chart_pie_data'				=> '',
			'chart_donut_data'				=> '',
			'chart_bar_data'				=> '',
			'chart_bar_stack'				=> 'false',
			'chart_bar_vertical'			=> '',
			'chart_bar_horizontal'			=> '',
			'chart_column_data'				=> '',
			'chart_column_stack'			=> 'false',
			'chart_column_vertical'			=> '',
			'chart_column_horizontal'		=> '',
			'chart_area_data'				=> '',
			'chart_area_vertical'			=> '',
			'chart_area_horizontal'			=> '',
			'chart_line_data'				=> '',
			'chart_line_curved'				=> 'false',
			'chart_line_vertical'			=> '',
			'chart_line_horizontal'			=> '',
			'chart_geo_data'				=> '',
			'chart_geo_region'				=> 'world',
			'chart_geo_colorstart'			=> '#ffff00',
			'chart_geo_colorend'			=> '#ebe5d8',
			'chart_combo_data'				=> '',
			'chart_combo_vertical'			=> '',
			'chart_combo_horizontal'		=> '',
			'chart_org_data'				=> '',						
			'margin_top'					=> 0,
			'margin_bottom'					=> 0,
			'el_id'							=> '',
			'el_class'						=> '',
			'css'							=> '',
		), $atts ));

		if (!empty($el_id)) {
			$google_chart_id				= $el_id;
		} else {
			$google_chart_id				= 'ts_vcsc_google_chart_' . mt_rand(999999, 9999999);
		}
		
		if (($chart_external_doc == 'true') && ($chart_external_key != '')) {
			if ($chart_external_sheet == '') {
				$chart_external_sheet		= 0;
			}
			if ($chart_external_range != '') {
				$chart_external_range		= '&range=' . $chart_external_range;
			}
			if ($chart_external_header != '') {
				$chart_external_header		= '&headers=' . $chart_external_header;
			}
			$chart_external_url				= 'https://docs.google.com/spreadsheet/ccc?key=' . $chart_external_key . '&usp=drive_web' . $chart_external_range . '' . $chart_external_header . '&gid=' . $chart_external_sheet . '#';
		} else {
			$chart_external_url				= '';
		}
		
		if ($charts_frontend == "false") {
			if ($chart_type == "pie"){
				$chart_pie_data					= trim($chart_pie_data);
				$chart_pie_data					= str_replace("<br/>", '', $chart_pie_data);
				$chart_pie_data					= str_replace("<br>", '', $chart_pie_data);
				$chart_pie_data					= str_replace("'", '"', $chart_pie_data);
				$chart_pie_data					= str_replace('``', '"', $chart_pie_data);
				$chart_pie_data					= str_replace('(', '[', $chart_pie_data);
				$chart_pie_data					= str_replace(')', ']', $chart_pie_data);
				$chart_data_array				= $chart_pie_data;
			} else if ($chart_type == "donut"){
				$chart_donut_data				= trim($chart_donut_data);
				$chart_donut_data				= str_replace("<br/>", '', $chart_donut_data);
				$chart_donut_data				= str_replace("<br>", '', $chart_donut_data);
				$chart_donut_data				= str_replace("'", '"', $chart_donut_data);
				$chart_donut_data				= str_replace('``', '"', $chart_donut_data);
				$chart_donut_data				= str_replace('(', '[', $chart_donut_data);
				$chart_donut_data				= str_replace(')', ']', $chart_donut_data);
				$chart_data_array				= $chart_donut_data;
				$chart_pie_hole					= ($chart_pie_hole / 100);
			} else if ($chart_type == "bar"){
				$chart_bar_data					= trim($chart_bar_data);
				$chart_bar_data					= str_replace("<br/>", '', $chart_bar_data);
				$chart_bar_data					= str_replace("<br>", '', $chart_bar_data);
				$chart_bar_data					= str_replace("'", '"', $chart_bar_data);
				$chart_bar_data					= str_replace('``', '"', $chart_bar_data);
				$chart_bar_data					= str_replace('(', '[', $chart_bar_data);
				$chart_bar_data					= str_replace(')', ']', $chart_bar_data);
				$chart_data_array				= $chart_bar_data;
			} else if ($chart_type == "column"){
				$chart_column_data				= trim($chart_column_data);
				$chart_column_data				= str_replace("<br/>", '', $chart_column_data);
				$chart_column_data				= str_replace("<br>", '', $chart_column_data);
				$chart_column_data				= str_replace("'", '"', $chart_column_data);
				$chart_column_data				= str_replace('``', '"', $chart_column_data);
				$chart_column_data				= str_replace('(', '[', $chart_column_data);
				$chart_column_data				= str_replace(')', ']', $chart_column_data);
				$chart_data_array				= $chart_column_data;
			} else if ($chart_type == "area"){
				$chart_area_data				= trim($chart_area_data);
				$chart_area_data				= str_replace("<br/>", '', $chart_area_data);
				$chart_area_data				= str_replace("<br>", '', $chart_area_data);
				$chart_area_data				= str_replace("'", '"', $chart_area_data);
				$chart_area_data				= str_replace('``', '"', $chart_area_data);
				$chart_area_data				= str_replace('(', '[', $chart_area_data);
				$chart_area_data				= str_replace(')', ']', $chart_area_data);
				$chart_data_array				= $chart_area_data;
			} else if ($chart_type == "line"){
				$chart_line_data				= trim($chart_line_data);
				$chart_line_data				= str_replace("<br/>", '', $chart_line_data);
				$chart_line_data				= str_replace("<br>", '', $chart_line_data);
				$chart_line_data				= str_replace("'", '"', $chart_line_data);
				$chart_line_data				= str_replace('``', '"', $chart_line_data);
				$chart_line_data				= str_replace('(', '[', $chart_line_data);
				$chart_line_data				= str_replace(')', ']', $chart_line_data);
				$chart_data_array				= $chart_line_data;
			} else if ($chart_type == "geo"){
				$chart_geo_data					= trim($chart_geo_data);
				$chart_geo_data					= str_replace("<br/>", '', $chart_geo_data);
				$chart_geo_data					= str_replace("<br>", '', $chart_geo_data);
				$chart_geo_data					= str_replace("'", '"', $chart_geo_data);
				$chart_geo_data					= str_replace('``', '"', $chart_geo_data);
				$chart_geo_data					= str_replace('(', '[', $chart_geo_data);
				$chart_geo_data					= str_replace(')', ']', $chart_geo_data);
				$chart_data_array				= $chart_geo_data;
			} else if ($chart_type == "combo"){
				$chart_combo_data				= trim($chart_combo_data);
				$chart_combo_data				= str_replace("<br/>", '', $chart_combo_data);
				$chart_combo_data				= str_replace("<br>", '', $chart_combo_data);
				$chart_combo_data				= str_replace("'", '"', $chart_combo_data);
				$chart_combo_data				= str_replace('``', '"', $chart_combo_data);
				$chart_combo_data				= str_replace('(', '[', $chart_combo_data);
				$chart_combo_data				= str_replace(')', ']', $chart_combo_data);
				$chart_data_array				= $chart_combo_data;
			} else if ($chart_type == "org"){
				$chart_org_data					= trim($chart_org_data);
				$chart_org_data					= str_replace("<br/>", '', $chart_org_data);
				$chart_org_data					= str_replace("<br>", '', $chart_org_data);
				$chart_org_data					= str_replace("'", '"', $chart_org_data);
				$chart_org_data					= str_replace('``', '"', $chart_org_data);
				$chart_org_data					= str_replace('(', '[', $chart_org_data);
				$chart_org_data					= str_replace(')', ']', $chart_org_data);
				$chart_data_array				= $chart_org_data;
			}
			$chart_data_array 				= explode('],', $chart_data_array);
			$chart_data_count 				= count($chart_data_array) - 1;
		}
		
		if (($chart_colors_custom == 'true') && ($chart_colors != '')) {
			$chart_colors 					= trim($chart_colors);
			$chart_colors 					= ltrim($chart_colors, ",");
			$chart_colors 					= rtrim($chart_colors, ",");
		} else {
			$chart_colors					= "";
		}
		
		if ($chart_transparent == "true") {
			$chart_background				= 'transparent';
		} else {
			$chart_background				= $chart_background;
		}
		if ($chart_border_show == "true") {
			$chart_border_stroke			= $chart_border_stroke;
		} else {
			$chart_border_stroke			= 0;
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Google-Charts', $atts);
		} else {
			$css_class	= '';
		}
		
		$output = '';
		
		$output .= '<div class="ts-google-chart-holder" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
			if ($charts_frontend == "false") {
				if ($chart_type == "pie"){
					?>
						<script type="text/javascript">
							google.load('visualization', '1.0', {'packages':['corechart']});
							google.setOnLoadCallback(drawChart_<?php echo $google_chart_id; ?>);
							function drawChart_<?php echo $google_chart_id; ?>() {
								var options = {
									'legend':		{
										'position': 	'<?php echo $chart_legend; ?>',
										'alignment': 	'center'
									},
									'title':    		'',
									'pieSliceText':		'<?php echo $chart_label; ?>', // percentage, value, label, none
									'is3D':				<?php echo $chart_pie_3d; ?>,
									'width':    		'100%',
									'height':   		'<?php echo $chart_height; ?>',
									'backgroundColor': {
										'fill': 		'<?php echo $chart_background; ?>',
										'stroke':		'<?php echo $chart_border_color; ?>',
										'strokeWidth':	<?php echo $chart_border_stroke; ?>,
									},
									<?php echo ($chart_colors != '' ? "'colors': 			[" . $chart_colors . "]," : ""); ?>
									
								};
								var data = query = '';
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									query = new google.visualization.Query('<?php echo rawurldecode($chart_external_url); ?>');
									query.send(handleQueryResponse_<?php echo $google_chart_id; ?>);																	
								<?php } else { ?>
									data = new google.visualization.arrayToDataTable([<?php echo trim ($chart_pie_data); ?>]);
								<?php } ?>
								function resizeChart_<?php echo $google_chart_id; ?>() {
									var chart = new google.visualization.PieChart(document.getElementById('<?php echo $google_chart_id; ?>'));									
									<?php if ($chart_image == 'true') { ?>									
										google.visualization.events.addListener(chart, 'ready', function () {
											jQuery('#<?php echo $google_chart_id; ?>-image').html('<a href="' + chart.getImageURI() + '" target="_blank"><img src="' + chart.getImageURI() + '"></a>');
										});
									<?php } ?>
									chart.draw(data, options);
								}
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									function handleQueryResponse_<?php echo $google_chart_id; ?>(response) {
										if (response.isError()) {
											jQuery("#<?php echo $google_chart_id; ?>").html('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
											return;
										} else {
											data = response.getDataTable();
											resizeChart_<?php echo $google_chart_id; ?>();
										}
									}
								<?php } else { ?>
									window.onload = resizeChart_<?php echo $google_chart_id; ?>();
								<?php } ?>
								jQuery(window).on("debouncedresize", function(event) {
									if (data != '') {
										resizeChart_<?php echo $google_chart_id; ?>();
									}									
								});
							}
						</script>
					<?php
				}
				if ($chart_type == "donut"){
					?>
						<script type="text/javascript">
							google.load('visualization', '1.0', {'packages':['corechart']});
							google.setOnLoadCallback(drawChart_<?php echo $google_chart_id; ?>);
							function drawChart_<?php echo $google_chart_id; ?>() {								
								var options = {
									'legend':		{
										'position': 	'<?php echo $chart_legend; ?>',
										'alignment': 	'center'
									},
									'title':    		'',
									'pieSliceText':		'<?php echo $chart_label; ?>',
									'pieHole':			<?php echo $chart_pie_hole; ?>,
									'width':    		'100%',
									'height':   		'<?php echo $chart_height; ?>',
									'backgroundColor': {
										'fill': 		'<?php echo $chart_background; ?>',
										'stroke':		'<?php echo $chart_border_color; ?>',
										'strokeWidth':	<?php echo $chart_border_stroke; ?>,
									},
									<?php echo ($chart_colors != '' ? "'colors': 			[" . $chart_colors . "]," : ""); ?>
								};
								var data = query = '';
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									query = new google.visualization.Query('<?php echo rawurldecode($chart_external_url); ?>');
									query.send(handleQueryResponse_<?php echo $google_chart_id; ?>);																	
								<?php } else { ?>
									data = new google.visualization.arrayToDataTable([<?php echo trim ($chart_donut_data); ?>]);
								<?php } ?>
								function resizeChart_<?php echo $google_chart_id; ?>() {
									var chart = new google.visualization.PieChart(document.getElementById('<?php echo $google_chart_id; ?>'));
									<?php if ($chart_image == 'true') { ?>									
										google.visualization.events.addListener(chart, 'ready', function () {
											jQuery('#<?php echo $google_chart_id; ?>-image').html('<a href="' + chart.getImageURI() + '" target="_blank"><img src="' + chart.getImageURI() + '"></a>');
										});
									<?php } ?>
									chart.draw(data, options);
								}
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									function handleQueryResponse_<?php echo $google_chart_id; ?>(response) {
										if (response.isError()) {
											jQuery("#<?php echo $google_chart_id; ?>").html('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
											return;
										} else {
											data = response.getDataTable();
											resizeChart_<?php echo $google_chart_id; ?>();
										}
									}
								<?php } else { ?>
									window.onload = resizeChart_<?php echo $google_chart_id; ?>();
								<?php } ?>
								jQuery(window).on("debouncedresize", function(event) {
									if (data != '') {
										resizeChart_<?php echo $google_chart_id; ?>();
									}									
								});
							}
						</script>
					<?php
				}
				if ($chart_type == "bar"){
					?>
						<script type="text/javascript">
							google.load('visualization', '1.0', {'packages':['corechart']});
							google.setOnLoadCallback(drawChart_<?php echo $google_chart_id; ?>);
							function drawChart_<?php echo $google_chart_id; ?>() {								
								var options = {
									'legend':		{
										'position': 	'<?php echo $chart_legend; ?>',
										'alignment': 	'center'
									},
									'title':    		'',
									'width':    		'100%',
									'height':   		'<?php echo $chart_height; ?>',
									'backgroundColor': {
										'fill': 		'<?php echo $chart_background; ?>',
										'stroke':		'<?php echo $chart_border_color; ?>',
										'strokeWidth':	<?php echo $chart_border_stroke; ?>,
									},
									'isStacked':		<?php echo $chart_bar_stack; ?>,
									'orientation':		'vertical',
									'vAxis': {
										//'format':		'###,###',
										'title': 		'<?php echo $chart_bar_vertical; ?>',
									},
									'hAxis': {
										//'format':		'###,###',
										'title':		'<?php echo $chart_bar_horizontal; ?>',
									},
									<?php echo ($chart_colors != '' ? "'colors': 			[" . $chart_colors . "]," : ""); ?>
								};
								var data = query = '';
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									query = new google.visualization.Query('<?php echo rawurldecode($chart_external_url); ?>');
									query.send(handleQueryResponse_<?php echo $google_chart_id; ?>);																	
								<?php } else { ?>
									data = new google.visualization.arrayToDataTable([<?php echo trim ($chart_bar_data); ?>]);
								<?php } ?>
								function resizeChart_<?php echo $google_chart_id; ?>() {
									/*
									// Format hAxis
									var formatter1 = new google.visualization.NumberFormat({pattern:'###,###'});
									formatter1.format(data, 0);
									// Format vAxis
									var formatter2 = new google.visualization.NumberFormat({pattern:'###,###'});
									formatter2.format(data, 1);
									var formatter2 = new google.visualization.NumberFormat({pattern:'###,###'});
									formatter2.format(data, 2);
									*/
									// Create Chart
									var chart = new google.visualization.BarChart(document.getElementById('<?php echo $google_chart_id; ?>'));
									<?php if ($chart_image == 'true') { ?>									
										google.visualization.events.addListener(chart, 'ready', function () {
											jQuery('#<?php echo $google_chart_id; ?>-image').html('<a href="' + chart.getImageURI() + '" target="_blank"><img src="' + chart.getImageURI() + '"></a>');
										});
									<?php } ?>
									chart.draw(data, options);
								}
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									function handleQueryResponse_<?php echo $google_chart_id; ?>(response) {
										if (response.isError()) {
											jQuery("#<?php echo $google_chart_id; ?>").html('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
											return;
										} else {
											data = response.getDataTable();
											resizeChart_<?php echo $google_chart_id; ?>();
										}
									}
								<?php } else { ?>
									window.onload = resizeChart_<?php echo $google_chart_id; ?>();
								<?php } ?>
								jQuery(window).on("debouncedresize", function(event) {
									if (data != '') {
										resizeChart_<?php echo $google_chart_id; ?>();
									}									
								});
							}
						</script>
					<?php
				}
				if ($chart_type == "column"){
					?>
						<script type="text/javascript">
							google.load('visualization', '1.0', {'packages':['corechart']});
							google.setOnLoadCallback(drawChart_<?php echo $google_chart_id; ?>);
							function drawChart_<?php echo $google_chart_id; ?>() {
								var options = {
									'legend':		{
										'position': 	'<?php echo $chart_legend; ?>',
										'alignment': 	'center'
									},
									'title':    		'',
									'width':    		'100%',
									'height':   		'<?php echo $chart_height; ?>',
									'backgroundColor': {
										'fill': 		'<?php echo $chart_background; ?>',
										'stroke':		'<?php echo $chart_border_color; ?>',
										'strokeWidth':	<?php echo $chart_border_stroke; ?>,
									},
									'isStacked': 		<?php echo $chart_column_stack; ?>,
									'orientation':		'horizontal',
									'vAxis': {
										'title': 		'<?php echo $chart_column_vertical; ?>',
									},
									'hAxis': {
										'title':		'<?php echo $chart_column_horizontal; ?>',
									},
									<?php echo ($chart_colors != '' ? "'colors': 			[" . $chart_colors . "]," : ""); ?>
								};
								var data = query = '';
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									query = new google.visualization.Query('<?php echo rawurldecode($chart_external_url); ?>');
									query.send(handleQueryResponse_<?php echo $google_chart_id; ?>);																	
								<?php } else { ?>
									data = new google.visualization.arrayToDataTable([<?php echo trim ($chart_column_data); ?>]);
								<?php } ?>
								function resizeChart_<?php echo $google_chart_id; ?>() {
									var chart = new google.visualization.ColumnChart(document.getElementById('<?php echo $google_chart_id; ?>'));
									<?php if ($chart_image == 'true') { ?>									
										google.visualization.events.addListener(chart, 'ready', function () {
											jQuery('#<?php echo $google_chart_id; ?>-image').html('<a href="' + chart.getImageURI() + '" target="_blank"><img src="' + chart.getImageURI() + '"></a>');
										});
									<?php } ?>
									chart.draw(data, options);
								}
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									function handleQueryResponse_<?php echo $google_chart_id; ?>(response) {
										if (response.isError()) {
											jQuery("#<?php echo $google_chart_id; ?>").html('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
											return;
										} else {
											data = response.getDataTable();
											resizeChart_<?php echo $google_chart_id; ?>();
										}
									}
								<?php } else { ?>
									window.onload = resizeChart_<?php echo $google_chart_id; ?>();
								<?php } ?>
								jQuery(window).on("debouncedresize", function(event) {
									if (data != '') {
										resizeChart_<?php echo $google_chart_id; ?>();
									}									
								});
							}
						</script>
					<?php
				}
				if ($chart_type == "area"){
					?>
						<script type="text/javascript">
							google.load('visualization', '1.0', {'packages':['corechart']});
							google.setOnLoadCallback(drawChart_<?php echo $google_chart_id; ?>);
							function drawChart_<?php echo $google_chart_id; ?>() {								
								var options = {
									'legend':		{
										'position': 	'<?php echo $chart_legend; ?>',
										'alignment': 	'center'
									},
									'title':    		'',
									'width':    		'100%',
									'height':   		'<?php echo $chart_height; ?>',
									'backgroundColor': {
										'fill': 		'<?php echo $chart_background; ?>',
										'stroke':		'<?php echo $chart_border_color; ?>',
										'strokeWidth':	<?php echo $chart_border_stroke; ?>,
									},
									'vAxis': {
										'title': 		'<?php echo $chart_area_vertical; ?>',
									},
									'hAxis': {
										'title':		'<?php echo $chart_area_horizontal; ?>',
									},
									<?php echo ($chart_colors != '' ? "'colors': 			[" . $chart_colors . "]," : ""); ?>
								};
								var data = query = '';
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									query = new google.visualization.Query('<?php echo rawurldecode($chart_external_url); ?>');
									query.send(handleQueryResponse_<?php echo $google_chart_id; ?>);																	
								<?php } else { ?>
									data = new google.visualization.arrayToDataTable([<?php echo trim ($chart_area_data); ?>]);
								<?php } ?>
								function resizeChart_<?php echo $google_chart_id; ?>() {
									var chart = new google.visualization.AreaChart(document.getElementById('<?php echo $google_chart_id; ?>'));
									<?php if ($chart_image == 'true') { ?>									
										google.visualization.events.addListener(chart, 'ready', function () {
											jQuery('#<?php echo $google_chart_id; ?>-image').html('<a href="' + chart.getImageURI() + '" target="_blank"><img src="' + chart.getImageURI() + '"></a>');
										});
									<?php } ?>
									chart.draw(data, options);
								}
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									function handleQueryResponse_<?php echo $google_chart_id; ?>(response) {
										if (response.isError()) {
											jQuery("#<?php echo $google_chart_id; ?>").html('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
											return;
										} else {
											data = response.getDataTable();
											resizeChart_<?php echo $google_chart_id; ?>();
										}
									}
								<?php } else { ?>
									window.onload = resizeChart_<?php echo $google_chart_id; ?>();
								<?php } ?>
								jQuery(window).on("debouncedresize", function(event) {
									if (data != '') {
										resizeChart_<?php echo $google_chart_id; ?>();
									}									
								});
							}
						</script>
					<?php
				}
				if ($chart_type == "line"){
					?>
						<script type="text/javascript">
							google.load('visualization', '1.0', {'packages':['corechart']});
							google.setOnLoadCallback(drawChart_<?php echo $google_chart_id; ?>);
							function drawChart_<?php echo $google_chart_id; ?>() {
								var options = {
									'legend':		{
										'position': 	'<?php echo $chart_legend; ?>',
										'alignment': 	'center'
									},
									'title':    		'',
									'width':    		'100%',
									'curveType': 		'<?php echo ($chart_line_curved == "true" ? "function" : "none"); ?>',
									'interpolateNulls': false,
									'height':   		'<?php echo $chart_height; ?>',
									'backgroundColor': {
										'fill': 		'<?php echo $chart_background; ?>',
										'stroke':		'<?php echo $chart_border_color; ?>',
										'strokeWidth':	<?php echo $chart_border_stroke; ?>,
									},
									'vAxis': {
										'title': 		'<?php echo $chart_line_vertical; ?>',
									},
									'hAxis': {
										'title':		'<?php echo $chart_line_horizontal; ?>',
									},
									<?php echo ($chart_colors != '' ? "'colors': 			[" . $chart_colors . "]," : ""); ?>
								};
								var data = query = '';
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									query = new google.visualization.Query('<?php echo rawurldecode($chart_external_url); ?>');
									query.send(handleQueryResponse_<?php echo $google_chart_id; ?>);																	
								<?php } else { ?>
									data = new google.visualization.arrayToDataTable([<?php echo trim ($chart_line_data); ?>]);
								<?php } ?>
								function resizeChart_<?php echo $google_chart_id; ?>() {
									var chart = new google.visualization.LineChart(document.getElementById('<?php echo $google_chart_id; ?>'));
									<?php if ($chart_image == 'true') { ?>									
										google.visualization.events.addListener(chart, 'ready', function () {
											jQuery('#<?php echo $google_chart_id; ?>-image').html('<a href="' + chart.getImageURI() + '" target="_blank"><img src="' + chart.getImageURI() + '"></a>');
										});
									<?php } ?>
									chart.draw(data, options);
								}
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									function handleQueryResponse_<?php echo $google_chart_id; ?>(response) {
										if (response.isError()) {
											jQuery("#<?php echo $google_chart_id; ?>").html('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
											return;
										} else {
											data = response.getDataTable();
											resizeChart_<?php echo $google_chart_id; ?>();
										}
									}
								<?php } else { ?>
									window.onload = resizeChart_<?php echo $google_chart_id; ?>();
								<?php } ?>
								jQuery(window).on("debouncedresize", function(event) {
									if (data != '') {
										resizeChart_<?php echo $google_chart_id; ?>();
									}									
								});
							}
						</script>
					<?php
				}
				if ($chart_type == "geo"){
					?>
						<script type="text/javascript">
							google.load('visualization', '1.0', {'packages':['geochart']});
							google.setOnLoadCallback(drawChart_<?php echo $google_chart_id; ?>);
							function drawChart_<?php echo $google_chart_id; ?>() {
								var options = {
									'title':    		'',
									'width':    		'100%',
									'height':   		'<?php echo $chart_height; ?>',
									'backgroundColor': {
										'fill': 		'<?php echo $chart_background; ?>',
										'stroke':		'<?php echo $chart_border_color; ?>',
										'strokeWidth':	<?php echo $chart_border_stroke; ?>,
									},
									'region':			'<?php echo $chart_geo_region; ?>',
									'colorAxis': {
										'colors': 		['<?php echo $chart_geo_colorstart; ?>', '<?php echo $chart_geo_colorend; ?>']
									}
								};
								var data = query = '';
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									query = new google.visualization.Query('<?php echo rawurldecode($chart_external_url); ?>');
									query.send(handleQueryResponse_<?php echo $google_chart_id; ?>);																	
								<?php } else { ?>
									data = new google.visualization.arrayToDataTable([<?php echo trim ($chart_geo_data); ?>]);
								<?php } ?>
								function resizeChart_<?php echo $google_chart_id; ?>() {
									var chart = new google.visualization.GeoChart(document.getElementById('<?php echo $google_chart_id; ?>'));
									<?php if ($chart_image == 'true') { ?>									
										google.visualization.events.addListener(chart, 'ready', function () {
											jQuery('#<?php echo $google_chart_id; ?>-image').html('<a href="' + chart.getImageURI() + '" target="_blank"><img src="' + chart.getImageURI() + '"></a>');
										});
									<?php } ?>
									chart.draw(data, options);
								}
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									function handleQueryResponse_<?php echo $google_chart_id; ?>(response) {
										if (response.isError()) {
											jQuery("#<?php echo $google_chart_id; ?>").html('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
											return;
										} else {
											data = response.getDataTable();
											resizeChart_<?php echo $google_chart_id; ?>();
										}
									}
								<?php } else { ?>
									window.onload = resizeChart_<?php echo $google_chart_id; ?>();
								<?php } ?>
								jQuery(window).on("debouncedresize", function(event) {
									if (data != '') {
										resizeChart_<?php echo $google_chart_id; ?>();
									}									
								});
							}
						</script>
					<?php
				}
				if ($chart_type == "combo"){
					?>
						<script type="text/javascript">
							google.load('visualization', '1.0', {'packages':['corechart']});
							google.setOnLoadCallback(drawChart_<?php echo $google_chart_id; ?>);
							function drawChart_<?php echo $google_chart_id; ?>() {
								var options = {
									'legend':		{
										'position': 	'<?php echo $chart_legend; ?>',
										'alignment': 	'center'
									},
									'title':    		'',
									'width':    		'100%',
									'height':   		'<?php echo $chart_height; ?>',
									'backgroundColor': {
										'fill': 		'<?php echo $chart_background; ?>',
										'stroke':		'<?php echo $chart_border_color; ?>',
										'strokeWidth':	<?php echo $chart_border_stroke; ?>,
									},
									'vAxis': {
										'title': 		'<?php echo $chart_bar_vertical; ?>',
									},
									'hAxis': {
										'title':		'<?php echo $chart_bar_horizontal; ?>',
									},
									'seriesType': 		'bars',
									'series': 			{<?php echo $chart_data_count; ?>: {type: "line"}},
									<?php echo ($chart_colors != '' ? "'colors': 			[" . $chart_colors . "]," : ""); ?>
								};
								var data = query = '';
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									query = new google.visualization.Query('<?php echo rawurldecode($chart_external_url); ?>');
									query.send(handleQueryResponse_<?php echo $google_chart_id; ?>);																	
								<?php } else { ?>
									data = new google.visualization.arrayToDataTable([<?php echo trim ($chart_combo_data); ?>]);
								<?php } ?>
								function resizeChart_<?php echo $google_chart_id; ?>() {
									var chart = new google.visualization.ComboChart(document.getElementById('<?php echo $google_chart_id; ?>'));
									<?php if ($chart_image == 'true') { ?>									
										google.visualization.events.addListener(chart, 'ready', function () {
											jQuery('#<?php echo $google_chart_id; ?>-image').html('<a href="' + chart.getImageURI() + '" target="_blank"><img src="' + chart.getImageURI() + '"></a>');
										});
									<?php } ?>
									chart.draw(data, options);
								}
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									function handleQueryResponse_<?php echo $google_chart_id; ?>(response) {
										if (response.isError()) {
											jQuery("#<?php echo $google_chart_id; ?>").html('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
											return;
										} else {
											data = response.getDataTable();
											resizeChart_<?php echo $google_chart_id; ?>();
										}
									}
								<?php } else { ?>
									window.onload = resizeChart_<?php echo $google_chart_id; ?>();
								<?php } ?>
								jQuery(window).on("debouncedresize", function(event) {
									if (data != '') {
										resizeChart_<?php echo $google_chart_id; ?>();
									}									
								});
							}
						</script>
					<?php
				}
				if ($chart_type == "org"){
					?>
						<script type="text/javascript">
							google.load('visualization', '1.0', {'packages':['orgchart']});
							google.setOnLoadCallback(drawChart_<?php echo $google_chart_id; ?>);
							function drawChart_<?php echo $google_chart_id; ?>() {
								var options = {
									'title':    		'',
									'width':    		'100%',
									'height':   		'<?php echo $chart_height; ?>',
									'backgroundColor': {
										'fill': 		'<?php echo $chart_background; ?>',
										'stroke':		'<?php echo $chart_border_color; ?>',
										'strokeWidth':	<?php echo $chart_border_stroke; ?>,
									},
									'allowHtml':		true
								};
								var data = query = '';
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									query = new google.visualization.Query('<?php echo rawurldecode($chart_external_url); ?>');
									query.send(handleQueryResponse_<?php echo $google_chart_id; ?>);																	
								<?php } else { ?>
									data = new google.visualization.arrayToDataTable([<?php echo trim ($chart_org_data); ?>]);
								<?php } ?>
								function resizeChart_<?php echo $google_chart_id; ?>() {
									var chart = new google.visualization.OrgChart(document.getElementById('<?php echo $google_chart_id; ?>'));
									chart.draw(data, options);
								}
								<?php if (($chart_external_doc == 'true') && ($chart_external_url != '')) { ?>
									function handleQueryResponse_<?php echo $google_chart_id; ?>(response) {
										if (response.isError()) {
											jQuery("#<?php echo $google_chart_id; ?>").html('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
											return;
										} else {
											data = response.getDataTable();
											resizeChart_<?php echo $google_chart_id; ?>();
										}
									}
								<?php } else { ?>
									window.onload = resizeChart_<?php echo $google_chart_id; ?>();
								<?php } ?>
								jQuery(window).on("debouncedresize", function(event) {
									if (data != '') {
										resizeChart_<?php echo $google_chart_id; ?>();
									}									
								});
							}
						</script>
					<?php
				}
			} else {
				$output .= '<div style="width: 100%; text-align: center; color: #D10000; font-weight: bold;">TS Google Charts</div>';
				$output .= '<div class="ts-composer-frontedit-message">' . __( 'The chart is currently viewed in front-end edit mode; due to incompatibility of the Google Chart API with the frontend editor, only chart data will be shown but no rendering will take place.', "ts_visual_composer_extend" ) . '</div>';
				if ($chart_title != '') {
					$output .= '<div class="ts-google-chart-title">' . $chart_title . '</div>';
				}
				$output .= '<div class="ts-google-chart-data">';
					$output .= __( "Chart Type", "ts_visual_composer_extend" ) . ': ' . ucwords($chart_type) . '<br/>';
					$output .= __( "Data", "ts_visual_composer_extend" ) . ': ';
					if (($chart_external_doc == 'true') && ($chart_external_url != '')) {					
						$output .= $chart_external_url;					
					} else {
						if ($chart_type == "pie"){
							$output .= $chart_pie_data;
						}
						if ($chart_type == "donut"){
							$output .= $chart_donut_data;
						}
						if ($chart_type == "bar") {
							$output .= $chart_bar_data;
						}
						if ($chart_type == "column") {
							$output .= $chart_column_data;
						}
						if ($chart_type == "area") {
							$output .= $chart_area_data;
						}
						if ($chart_type == "line") {
							$output .= $chart_line_data;
						}
						if ($chart_type == "geo") {
							$output .= $chart_geo_data;
						}
						if ($chart_type == "combo") {
							$output .= $chart_combo_data;
						}
						if ($chart_type == "org") {
							$output .= $chart_org_data;
						}	
					}
				$output .= '</div>';
			}
			if ($charts_frontend == "false") {
				if ($chart_title != '') {
					$output .= '<div class="ts-google-chart-title">' . $chart_title . '</div>';
				}
				$output .= '<div id="' . $google_chart_id . '" class="' . $el_class . ' ts-google-chart-draw ' . $css_class . '">';
					$output .= '<img src="' . TS_VCSC_GetResourceURL('images/other/ajax_loader.gif') . '" style="display: block; margin: 0 auto; padding: 0; width: 128px; height: 128px; text-align: center;">';
				$output .= '</div>';
				if (($chart_image == 'true') && ($chart_type != 'org')) {
					$output .= '<div id="' . $google_chart_id . '-image" class="ts-google-chart-draw-image"></div>';
				}
			}
		$output .= '</div>';
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_Google_Charts extends WPBakeryShortCode {};
	}
?>