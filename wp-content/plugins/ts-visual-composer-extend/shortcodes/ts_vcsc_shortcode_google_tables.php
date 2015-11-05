<?php
	add_shortcode('TS-VCSC-Google-Tables', 'TS_VCSC_Google_Tables_Function');
	add_shortcode('TS_VCSC_Google_Tables', 'TS_VCSC_Google_Tables_Function');
	function TS_VCSC_Google_Tables_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
			$charts_frontend				= "true";
		} else {
			$charts_frontend				= "false";
		}

		wp_enqueue_style('ts-visual-composer-extend-front');

		extract( shortcode_atts( array(
			'table_height'					=> '400',
			'table_title'					=> '',
			'table_external_key'			=> '',
			'table_external_sheet'			=> '',
			'table_external_range'			=> '',
			'table_external_header'			=> 1,			
			'table_allow_html'				=> 'false',
			'table_alternating'				=> 'true',
			'table_rtl'						=> 'false',
			'table_sort_enable'				=> 'true',
			'table_sort_asc'				=> 'true',
			'table_sort_column'				=> 0,
			'table_row_show'				=> 'false',
			'table_row_first'				=> 1,
			'table_page_enable'				=> 'false',
			'table_page_size'				=> 10,
			'table_page_start'				=> 0,			
			'margin_top'					=> 0,
			'margin_bottom'					=> 0,
			'el_id'							=> '',
			'el_class'						=> '',
			'css'							=> '',
		), $atts ));

		if (!empty($el_id)) {
			$google_table_id				= $el_id;
		} else {
			$google_table_id				= 'ts_vcsc_google_table_' . mt_rand(999999, 9999999);
		}
		
		if ($table_external_key != '') {
			if ($table_external_sheet == '') {
				$table_external_sheet		= 0;
			}
			if ($table_external_range != '') {
				$table_external_range		= '&range=' . $table_external_range;
			}
			if ($table_external_header != '') {
				$table_external_header		= '&headers=' . $table_external_header;
			}
			$table_external_url				= 'https://docs.google.com/spreadsheet/ccc?key=' . $table_external_key . '&usp=drive_web' . $table_external_range . '' . $table_external_header . '&gid=' . $table_external_sheet . '#';
		} else {
			$table_external_url				= '';
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Google-Tables', $atts);
		} else {
			$css_class	= '';
		}
		
		$output = '';
		
		$output .= '<div class="ts-google-table-holder" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
			if ($charts_frontend == "false") {
				?>
					<script type="text/javascript">
						google.load('visualization', '1.0', {'packages':['table']});
						google.setOnLoadCallback(drawTable_<?php echo $google_table_id; ?>);
						function drawTable_<?php echo $google_table_id; ?>() {
							var options = {
								'width':    			'100%',
								'height':   			'<?php echo ($table_height > 0 ? $table_height : 'automatic'); ?>',
								'allowHtml':			<?php echo ($table_allow_html == "true" ? "true" : "false"); ?>,
								'alternatingRowStyle':	<?php echo ($table_alternating == "true" ? "true" : "false"); ?>,				
								'page':					<?php echo ($table_page_enable == "true" ? "'enable'" : "'disable'"); ?>,
								'pageSize':				<?php echo $table_page_size; ?>,
								'startPage':			<?php echo $table_page_start; ?>,
								'rtlTable':				<?php echo ($table_rtl == "true" ? "true" : "false"); ?>,
								'showRowNumber':		<?php echo ($table_row_show == "true" ? "true" : "false"); ?>,
								'firstRowNumber':		<?php echo $table_row_first; ?>,
								'sort':					<?php echo ($table_sort_enable == "true" ? "'enable'" : "'disable'"); ?>,
								'sortAscending':		<?php echo ($table_sort_asc == "true" ? "true" : "false"); ?>,
								'sortColumn':			<?php echo $table_sort_column; ?>,
							};
							var data = query = '';
							query = new google.visualization.Query('<?php echo rawurldecode($table_external_url); ?>');
							query.send(handleQueryResponse_<?php echo $google_table_id; ?>);																	
							function resizeTable_<?php echo $google_table_id; ?>() {
								var table = new google.visualization.Table(document.getElementById('<?php echo $google_table_id; ?>'));								
								google.visualization.events.addListener(table, 'ready', function () {
									//console.log("Table '<?php echo $google_table_id . "' (Key: " . $table_external_key . ")"; ?> has been rendered and is ready to be used.");
								});
								<?php if ($table_sort_enable == "true") { ?>
									google.visualization.events.addListener(table, 'sort', function () {
										//console.log("Table '<?php echo $google_table_id . "' (Key: " . $table_external_key . ")"; ?> has triggered a sort event.");
									});
								<?php } ?>
								<?php if ($table_page_enable == "true") { ?>
									google.visualization.events.addListener(table, 'page', function () {
										//console.log("Table '<?php echo $google_table_id . "' (Key: " . $table_external_key . ")"; ?> has triggered a page event.");
									});
								<?php } ?>
								google.visualization.events.addListener(table, 'select', function () {
									//console.log("Table '<?php echo $google_table_id . "' (Key: " . $table_external_key . ")"; ?> has triggered a select event.");
								});								
								table.draw(data, options);
							}
							function handleQueryResponse_<?php echo $google_table_id; ?>(response) {
								if (response.isError()) {
									jQuery("#<?php echo $google_table_id; ?>").html('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
									return;
								} else {
									data = response.getDataTable();
									resizeTable_<?php echo $google_table_id; ?>();
								}
							}
							jQuery(window).on("debouncedresize", function(event) {
								if (data != '') {
									resizeTable_<?php echo $google_table_id; ?>();
								}									
							});
						}
					</script>
				<?php
			} else {
				$output .= '<div style="width: 100%; text-align: center; color: #D10000; font-weight: bold;">TS Google Tables</div>';
				$output .= '<div class="ts-composer-frontedit-message">' . __( 'The table is currently viewed in front-end edit mode; due to incompatibility of the Google Chart API with the frontend editor, only the generated table data URL will be shown but no rendering will take place.', "ts_visual_composer_extend" ) . '</div>';
				if ($table_title != '') {
					$output .= '<div class="ts-google-table-title">' . $table_title . '</div>';
				}
				$output .= '<div class="ts-google-table-data">';
					$output .= __( "URL", "ts_visual_composer_extend" ) . ': ';
					$output .= $table_external_url;
				$output .= '</div>';
			}
			if ($charts_frontend == "false") {
				if ($table_title != '') {
					$output .= '<div class="ts-google-table-title">' . $table_title . '</div>';
				}
				$output .= '<div id="' . $google_table_id . '" class="' . $el_class . ' ts-google-table-draw ' . $css_class . '">';
					$output .= '<img src="' . TS_VCSC_GetResourceURL('images/other/ajax_loader.gif') . '" style="display: block; margin: 0 auto; padding: 0; width: 128px; height: 128px; text-align: center;">';
				$output .= '</div>';
			}
		$output .= '</div>';
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_Google_Tables extends WPBakeryShortCode {};
	}
?>