<?php
	if ( ! defined( 'ABSPATH' ) ) exit;

	global $VISUAL_COMPOSER_EXTENSIONS;
	global $wpdb, $edd_options;
	
	if (!class_exists('Browser')) {
		require_once $VISUAL_COMPOSER_EXTENSIONS->detector_dir . 'ts_browser_detect.php';
	}
	$browser = new Browser();
	if (get_bloginfo('version') < '3.4') {
		$theme_data = get_theme_data(get_stylesheet_directory() . '/style.css');
		$theme      = $theme_data['Name'] . ' ' . $theme_data['Version'];
	} else {
		$theme_data = wp_get_theme();
		$theme      = $theme_data->Name . ' ' . $theme_data->Version;
	}
	$system_summary = '';
	echo '<div class="ts-vcsc-system-information-wrap wrap" style="width: 100%;">';	
		echo '<div class="ts-vcsc-settings-group-header">';
			echo '<div class="display_header">';
				echo '<h2><span class="dashicons dashicons-desktop"></span>Visual Composer Extensions - System Information</h2>';
			echo '</div>';
			echo '<div class="clear"></div>';
		echo '</div>';	
		echo '<div class="ts-vcsc-system-information-main">';
			// Button Section
			echo '<div class="ts-vcsc-section-main">';
				echo '<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-desktop"></i>System Information Summary</div>';
				echo '<div class="ts-vcsc-section-content">';
					echo '<div style="margin-top: 10px;">';
						echo '<a class="button-secondary" style="width: 200px; margin: 0 5px 0 0; text-align: center;" href="' . $VISUAL_COMPOSER_EXTENSIONS->settingsLink . '" target="_parent"><img src="' . TS_VCSC_GetResourceURL('images/logos/ts_vcsc_menu_icon_16x16.png') . '" style="width: 16px; height: 16px; margin-right: 10px;">Back to Plugin Settings</a>';
						echo '<a class="button-secondary" style="width: 200px; margin: 0 5px 0 0; text-align: center;" href="http://tekanewascripts.com/vcextensions/documentation/" target="_blank"><img src="' . TS_VCSC_GetResourceURL('images/other/ts_vcsc_manual_icon_16x16.png') . '" style="width: 16px; height: 16px; margin-right: 10px;">Manual</a>';
						echo '<a class="button-secondary" style="width: 200px; margin: 0 5px 0 0; text-align: center;" href="http://helpdesk.tekanewascripts.com/forums/forum/wordpress-plugins/visual-composer-extensions/" target="_blank"><img src="' . TS_VCSC_GetResourceURL('images/other/ts_vcsc_support_icon_16x16.png') . '" style="width: 16px; height: 16px; margin-right: 10px;">Support Forum</a>';
						echo '<a class="button-secondary" style="width: 200px; margin: 0 5px 0 0; text-align: center;" href="http://helpdesk.tekanewascripts.com/category/visual-composer-extensions/" target="_blank"><img src="' . TS_VCSC_GetResourceURL('images/other/ts_vcsc_knowledge_icon_16x16.png') . '" style="width: 16px; height: 16px; margin-right: 10px;">Knowledge Base</a>';
					echo '</div>';
					echo '<p>The information provided below is a summary of your WordPress and server setup and configuration. It can help when troubleshooting problems and conflicts and you might be asked to provide such information when requesting support.</p>';
					echo '<p>All information represents the data as provided by your server but does not necessarly reflect actual settings since some hosting companies apply internal server settings that might not be available for a basic check as this.</p>';
				echo '</div>';
			echo '</div>';
			// Basic WordPress Info			
			echo '<div class="ts-vcsc-section-main">';
				echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-wordpress"></i>Basic WordPress Info</div>';
				$system_summary .= '/* Basic WordPress Info */<br/>';
				echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';
					echo '<table class="ts-vcsc-system-information-table" style="width: 100%;">';
						echo '<tr><td>WordPress Version:</td><td>' . get_bloginfo('version') . '</td></tr>';
						$system_summary .= 'WordPress Version: ' . get_bloginfo('version') . '<br/>';
						echo '<tr><td>Multisite:</td><td>' . (is_multisite() ? 'Yes' . "\n" : 'No' . "\n") . '</td></tr>';
						$system_summary .= 'Multisite: ' . (is_multisite() ? 'Yes' : 'No') . '<br/>';
						echo '<tr><td>WP Table Prefix Length:</td><td>' . strlen($wpdb->prefix) . ' (Status: ' . ((strlen($wpdb->prefix) > 16) ? "ERROR: Too Long" : "Acceptable") . ')</td></tr>';
						$system_summary .= 'WP Table Prefix Length: ' . strlen($wpdb->prefix) . ' (Status: ' . ((strlen($wpdb->prefix) > 16) ? "ERROR: Too Long" : "Acceptable") . '<br/>';
						echo '<tr><td>Site URL:</td><td>' . site_url() . '</td></tr>';
						$system_summary .= 'Site URL: ' . site_url() . '<br/>';
						echo '<tr><td>Home URL:</td><td>' . home_url() . '</td></tr>';
						$system_summary .= 'Home URL: ' . home_url() . '<br/>';
						echo '<tr><td>Permalink Structure:</td><td>' . get_option('permalink_structure') . '</td></tr>';
						$system_summary .= 'Permalink Structure: ' . get_option('permalink_structure') . '<br/>';
						echo '<tr><td>Host:</td><td>' . gethostbyaddr($_SERVER['REMOTE_ADDR']) . '</td></tr>';
						$system_summary .= 'Host: ' . gethostbyaddr($_SERVER['REMOTE_ADDR']) . '<br/>';
						echo '<tr><td>Registered Post Stati:</td><td>' . implode(', ', get_post_stati()) . '</td></tr>';
						$system_summary .= 'Registered Post Stati: ' . implode(', ', get_post_stati()) . '<br/>';
					echo '</table>';
				echo '</div>';
			echo '</div>';
			$system_summary .= '<br/>';
			// General Info			
			echo '<div class="ts-vcsc-section-main">';
				echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-info"></i>General Info</div>';
				$system_summary .= '/* General Info */<br/>';
				echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';
					echo '<table class="ts-vcsc-system-information-table" style="width: 100%;">';
						echo '<tr><td>PHP Version:</td><td>' . PHP_VERSION . '</td></tr>';
						$system_summary .= 'PHP Version: ' . PHP_VERSION . '<br/>';
						$mysql_version_info 			= "N/A";
						global $wpdb;
						if (function_exists('mysqli_connect')) {
							if (defined('WP_USE_EXT_MYSQL')) {
								$mysql_version_info 	= mysql_get_server_info($wpdb->dbh);
							} elseif (version_compare(phpversion(), '5.5', '>=') || ! function_exists('mysql_connect')) {
								$mysql_version_info 	= mysqli_get_server_info($wpdb->dbh);
							} elseif (false !== strpos($GLOBALS['wp_version'], '-')) {
								$mysql_version_info 	= mysqli_get_server_info($wpdb->dbh);
							}else{
								$mysql_version_info 	= mysql_get_server_info($wpdb->dbh);
							}
						} else {
							$mysql_version_info 		= mysql_get_server_info($wpdb->dbh);
						}
						echo '<tr><td>MySQL Version:</td><td>' . $mysql_version_info . '</td></tr>';
						$system_summary .= 'MySQL Version: ' . $mysql_version_info . '<br/>';
						echo '<tr><td>Web Server Info:</td><td>' . $_SERVER['SERVER_SOFTWARE'] . '</td></tr>';
						$system_summary .= 'Web Server Info: ' . $_SERVER['SERVER_SOFTWARE'] . '<br/>';
						echo '<tr><td>Browser:</td><td>' . $browser . '</td></tr>';
						$system_summary .= 'Browser: ' . $browser . '<br/>';
						echo '<tr><td>PHP Time Limit:</td><td>' . ini_get('max_execution_time') . '</td></tr>';
						$system_summary .= 'PHP Time Limit: ' . ini_get('max_execution_time') . '<br/>';
						echo '<tr><td>PHP Max. Input Vars:</td><td>' . ini_get('max_input_vars') . '</td></tr>';
						$system_summary .= 'PHP Max. Input Vars: ' . ini_get('max_input_vars') . '<br/>';
						echo '<tr><td>PHP Argument Separator:</td><td>' . ini_get('arg_separator.output') . '</td></tr>';
						$system_summary .= 'PHP Argument Separator: ' . ini_get('arg_separator.output') . '<br/>';
					echo '</table>';
				echo '</div>';
			echo '</div>';
			$system_summary .= '<br/>';
			// Debug Info
			echo '<div class="ts-vcsc-section-main">';
				echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-sos"></i>Debug Info</div>';
				$system_summary .= '/* Debug Info */<br/>';
				echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';
					echo '<table class="ts-vcsc-system-information-table" style="width: 100%;">';
						echo '<tr><td>PHP Safe Mode:</td><td>' . (ini_get('safe_mode') ? "Yes" : "No") . '</td></tr>';
						$system_summary .= 'PHP Safe Mode: ' . (ini_get('safe_mode') ? "Yes" : "No") . '<br/>';
						echo '<tr><td>PHP Debug Mode:</td><td>' . (defined('WP_DEBUG') ? WP_DEBUG ? 'Enabled' : 'Disabled' : 'Not set') . '</td></tr>';
						$system_summary .= 'PHP Debug Mode: ' . (defined('WP_DEBUG') ? WP_DEBUG ? 'Enabled' : 'Disabled' : 'Not set') . '<br/>';
						echo '<tr><td>PHP Display Errors:</td><td>' . ((ini_get('display_errors')) ? 'Available (' . ini_get('display_errors') . ')' : 'N/A') . '</td></tr>';
						$system_summary .= 'PHP Display Errors: ' . ((ini_get('display_errors')) ? 'Available (' . ini_get('display_errors') . ')' : 'N/A') . '<br/>';
						echo '<tr><td>SOAP Client:</td><td>' . ((class_exists('SoapClient')) ? "Yes" : "No") . '</td></tr>';
						$system_summary .= 'SOAP Client: ' . ((class_exists('SoapClient')) ? "Yes" : "No") . '<br/>';
					echo '</table>';
				echo '</div>';
			echo '</div>';
			$system_summary .= '<br/>';
			// Memory Info			
			echo '<div class="ts-vcsc-section-main">';
				echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-align-none"></i>Memory Info</div>';
				$system_summary .= '/* Memory Info */<br/>';
				echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';
					echo '<table class="ts-vcsc-system-information-table" style="width: 100%;">';
						echo '<tr><td>WordPress Memory Limit:</td><td>' . (TS_VCSC_LetToNumber(WP_MEMORY_LIMIT)/(1024)) . 'MB</td></tr>';
						$system_summary .= 'WordPress Memory Limit: ' . (TS_VCSC_LetToNumber(WP_MEMORY_LIMIT)/(1024)) . 'MB<br/>';
						echo '<tr><td>PHP Memory Limit:</td><td>' . ini_get('memory_limit') . 'B (based on php.ini settings)</td></tr>';
						$system_summary .= 'PHP Memory Limit: ' . ini_get('memory_limit') . 'B (based on php.ini settings)<br/>';
						$memoryusage 		= TS_VCSC_Memory_Usage();
						echo '<tr><td>PHP Current Memory:</td><td>' . ($memoryusage) . ' MB</td></tr>';
						$system_summary .= 'PHP Current Memory: ' . ($memoryusage) . 'MB<br/>';
						$memoryutilization 	= (number_format((($memoryusage / ini_get('memory_limit')) * 100), 2, '.', ''));
						echo '<tr><td>PHP Memory Utilization:</td><td>' . $memoryutilization . '%</td></tr>';
						$system_summary .= 'PHP Memory Utilization: ' . $memoryutilization . '%<br/>';
						$peakmemory = (number_format(memory_get_peak_usage(false)/1024/1024, 2, '.', ''));
						echo '<tr><td>PHP Peak Memory:</td><td>' . $peakmemory . ' MB</td></tr>';
						$system_summary .= 'PHP Peak Memory: ' . $peakmemory . 'MB<br/>';
						echo '<tr><td>PHP Max. Upload Size:</td><td>' . ini_get('upload_max_filesize') . '</td></tr>';
						$system_summary .= 'PHP Max. Upload Size: ' . ini_get('upload_max_filesize') . '<br/>';
						echo '<tr><td>PHP Max. Post Size:</td><td>' . ini_get('post_max_size') . '</td></tr>';
						$system_summary .= 'PHP Max. Post Size: ' . ini_get('post_max_size') . '<br/>';
					echo '</table>';
				echo '</div>';
			echo '</div>';
			$system_summary .= '<br/>';
			// Remote File Access			
			echo '<div class="ts-vcsc-section-main">';
				echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-migrate"></i>Remote File Access Info</div>';
				$system_summary .= '/* Remote File Access Info */<br/>';
				echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';
					echo '<table class="ts-vcsc-system-information-table" style="width: 100%;">';
						echo '<tr><td>PHP Allow URL File Open:</td><td>' . (ini_get('allow_url_fopen') ? "Yes" : "No") . '</td></tr>';
						$system_summary .= 'PHP Allow URL File Open: ' . (ini_get('allow_url_fopen') ? "Yes" : "No") . '<br/>';
						echo '<tr><td>PHP Allow File Get Contents:</td><td>' . (function_exists('file_get_contents') ? "Yes" : "No") . '</td></tr>';
						$system_summary .= 'PHP Allow File Get Contents: ' . (function_exists('file_get_contents') ? "Yes" : "No") . '<br/>';
						echo '<tr><td>PHP Allow File Put Contents:</td><td>' . (function_exists('file_put_contents') ? "Yes" : "No") . '</td></tr>';
						$system_summary .= 'PHP Allow File Put Contents: ' . (function_exists('file_put_contents') ? "Yes" : "No") . '<br/>';
						echo '<tr><td>PHP Unzip File:</td><td>' . (function_exists('unzip_file') ? "Yes" : "No") . '</td></tr>';
						$system_summary .= 'PHP Unzip File: ' . (function_exists('unzip_file') ? "Yes" : "No") . '<br/>';
						echo '<tr><td>cURL:</td><td>' . ((function_exists('curl_init')) ? 'Yes' : 'No') . '</td></tr>';
						$system_summary .= 'cURL: ' . ((function_exists('curl_init')) ? 'Yes' : 'No') . '<br/>';
						$envato_code	= "ThisIsJustATestRequest";
						$response = wp_remote_post($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_External_URL . $envato_code . '&clienturl=' . site_url());
						if (!is_wp_error($response) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
							$WP_REMOTE_POST =  'Yes';
						} else {
							$WP_REMOTE_POST =  'No';
						}
						echo '<tr><td>WP Remote Post:</td><td>' . $WP_REMOTE_POST . '</td></tr>';
						$system_summary .= 'WP Remote Post: ' . $WP_REMOTE_POST . '<br/>';
						$response = wp_remote_get($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_External_URL . $envato_code . '&clienturl=' . site_url());
						if (!is_wp_error($response) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
							$WP_REMOTE_GET 	=  'Yes';
						} else {
							$WP_REMOTE_GET 	=  'No';
						}
						echo '<tr><td>WP Remote Get:</td><td>' . $WP_REMOTE_GET . '</td></tr>';			
						$system_summary .= 'WP Remote Get: ' . $WP_REMOTE_GET . '<br/>';
						echo '<tr><td>FSOCKOPEN:</td><td>' . ((function_exists('fsockopen')) ? 'Yes' : 'No') . '</td></tr>';
						$system_summary .= 'FSOCKOPEN: ' . ((function_exists('fsockopen')) ? 'Yes' : 'No') . '<br/>';
					echo '</table>';
				echo '</div>';
			echo '</div>';
			$system_summary .= '<br/>';
			// Theme Info			
			echo '<div class="ts-vcsc-section-main">';
				echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-art"></i>Active Theme Info</div>';
				$system_summary .= '/* Theme Info */<br/>';
				echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';
					echo '<table class="ts-vcsc-system-information-table" style="width: 100%;">';
						echo '<tr><td>Active Theme:</td><td>' . $theme . '</td></tr>';
						$system_summary .= 'Active Theme: ' . $theme . '<br/>';
					echo '</table>';
				echo '</div>';
			echo '</div>';
			$system_summary .= '<br/>';
			// Plugin Info			
			echo '<div class="ts-vcsc-section-main">';
				echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-admin-plugins"></i>Active Plugins Info</div>';
				$system_summary .= '/* Subsite Plugins Info */<br/>';
				echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';
					echo '<table class="ts-vcsc-system-information-table" style="width: 100%;">';
						echo '<tr>';
							echo '<td>Subsite Plugins:</td>';
							$plugins 					= get_plugins();
							$active_plugins 			= get_option('active_plugins', array());
							$wpbakery					= 'No';
							$vcextensions				= 'Not Activated';
							echo '<td><ul>';
							foreach ($plugins as $plugin_path => $plugin) {
								// If the plugin isn't active, don't show it.
								if (!in_array($plugin_path, $active_plugins)) {
									continue;
								} else {
									if (stripos($plugin['Name'], 'WPBakery') !== false) {
										$wpbakery		= 'Yes';
									} else if (stripos($plugin['TextDomain'], 'ts_visual_composer_extend') !== false) {
										$vcextensions	= 'v' . $plugin['Version'];
									}
									echo '<li>' . $plugin['Name'] . ' v' . $plugin['Version'] . "</li>";
									$system_summary .= $plugin['Name'] .' v' . $plugin['Version'] . '<br/>';
								}
							}
							echo '</ul></td>';
						echo '</tr>';			
						if (is_multisite()) {
							$system_summary .= '<br/>';
							$system_summary .= '/* Active Networkwide Plugins Info */<br/>';
							echo '<tr>';
								echo '<td>Network Plugins:</td>';
								$plugins 			= wp_get_active_network_plugins();
								$active_plugins 	= get_site_option( 'active_sitewide_plugins', array() );
							echo '<td><ul>';
							foreach ($plugins as $plugin_path) {
								$plugin_base 		= plugin_basename($plugin_path);				
								// If the plugin isn't active, don't show it.
								if (!array_key_exists( $plugin_base, $active_plugins)) {
									continue;
								}				
								$plugin 			= get_plugin_data($plugin_path);				
								echo '<li>' . $plugin['Name'] . ' v' . $plugin['Version'] . "</li>";
								$system_summary .= $plugin['Name'] .' v' . $plugin['Version'] . '<br/>';
							}
							echo '</ul></td>';			
						};
					echo '</table>';
				echo '</div>';
			echo '</div>';
			$system_summary .= '<br/>';
			// Visual Composer Extensions Info			
			echo '<div class="ts-vcsc-section-main">';
				echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-nametag"></i> Composium - Visual Composer Extensions Info</div>';
				$system_summary .= '/* Composium - Visual Composer Extensions Info */<br/>';
				echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';
					echo '<table class="ts-vcsc-system-information-table" style="width: 100%;">';
						if (defined('WPB_VC_VERSION')){
							echo '<tr><td>Visual Composer:</td><td>v' . WPB_VC_VERSION . '</td></tr>';
							$system_summary .= 'Visual Composer: v' . WPB_VC_VERSION . '<br/>';
						}
						echo '<tr><td>Standalone Visual Composer:</td><td>' . $wpbakery . '</td></tr>';
						$system_summary .= 'Standalone Visual Composer: ' . $wpbakery . '<br/>';
						echo '<tr><td>Visual Composer Extensions:</td><td>' . $vcextensions . '</td></tr>';
						$system_summary .= 'Visual Composer Extensions: ' . $vcextensions . '<br/>';						
						if (is_multisite()) {
							echo '<tr><td>Network Activated:</td><td>' . (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") ? "Yes" : "No") . '</td></tr>';
							$system_summary .= 'Network Activated: ' . (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") ? "Yes" : "No") . '<br/>';
						}						
						echo '<tr><td>Available / Active Elements:</td><td>' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements . ' / ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements . '</td></tr>';
						$system_summary .= 'Available / Active Elements: ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements . ' / ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements . '<br/>';				
						if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") {
							$TS_VCSC_TotalIconFontsInstalled = (count($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Installed_Icon_Fonts) + count($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Composer_Icon_Fonts));
						} else {
							$TS_VCSC_TotalIconFontsInstalled = count($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Installed_Icon_Fonts);
						}						
						if (get_option('ts_vcsc_extend_settings_tinymceCustomArray', '') != '') {
							echo '<tr><td>Available / Active Icon Fonts:</td><td>' . $TS_VCSC_TotalIconFontsInstalled . ' / ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Fonts . '</td></tr>';
							$system_summary .= 'Available / Active Icon Fonts: ' . $TS_VCSC_TotalIconFontsInstalled . ' / ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Fonts . '<br/>';
						} else {
							echo '<tr><td>Available / Active Icon Fonts:</td><td>' . ($TS_VCSC_TotalIconFontsInstalled - 1) . ' / ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Fonts . '</td></tr>';
							$system_summary .= 'Available / Active Icon Fonts: ' . ($TS_VCSC_TotalIconFontsInstalled - 1) . ' / ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Fonts . '<br/>';
						}
						echo '<tr><td>Available / Active Icons:</td><td>' . number_format($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Total_Icon_Count) . ' / ' . number_format($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Count) . '</td></tr>';
						$system_summary .= 'Available / Active Icons: ' . number_format($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Total_Icon_Count) . ' / ' . number_format($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Count) . '<br/>';
						echo '<tr><td>"Iconicum - WordPress Icon Fonts":</td><td>' . ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconicumStandard == "false") && (get_option('ts_vcsc_extend_settings_useIconGenerator', 0) == 1)) ? "Enabled" : "Disabled") . '</td></tr>';
						$system_summary .= '"Iconicum - WordPress Icon Fonts": ' . ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconicumStandard == "false") && (get_option('ts_vcsc_extend_settings_useIconGenerator', 0) == 1)) ? "Enabled" : "Disabled") . '<br/>';
						echo '<tr><td>"WooCommerce":</td><td>' . (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_WooCommerceActive == "true") ? "Active" : "Inactive") . '</td></tr>';
						$system_summary .= '"WooCommerce": ' . (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_WooCommerceActive == "true") ? "Active" : "Inactive") . '<br/>';
						echo '<tr><td>"bbPress":</td><td>' . (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_bbPressActive == "true") ? "Active" : "Inactive") . '</td></tr>';
						$system_summary .= '"bbPress": ' . (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_bbPressActive == "true") ? "Active" : "Inactive") . '<br/>';
						echo '<tr><td>Custom Post Types:</td><td>' . ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesLoaded == "true" ? "Active" : "Inactive") . '</td></tr>';
						$system_summary .= 'Custom Post Types: ' . ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesLoaded == "true" ? "Active" : "Inactive") . '<br/>';
						echo '<tr><td>Extended Row Options:</td><td>' . ((get_option('ts_vcsc_extend_settings_additionsRows', 0) == 1) ? "Active" : "Inactive") . '</td></tr>';
						$system_summary .= 'Extended Row Options: ' . ((get_option('ts_vcsc_extend_settings_additionsRows', 0) == 1) ? "Active" : "Inactive") . '<br/>';
						echo '<tr><td>Extended Column Options:</td><td>' . ((get_option('ts_vcsc_extend_settings_additionsColumns', 0) == 1) ? "Active" : "Inactive") . '</td></tr>';
						$system_summary .= 'Extended Column Options: ' . ((get_option('ts_vcsc_extend_settings_additionsColumns', 0) == 1) ? "Active" : "Inactive") . '<br/>';
					echo '</table>';
				echo '</div>';
			echo '</div>';
			// Text Area for Easy Export
			echo '<div class="ts-vcsc-section-main">';
				echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-download"></i>System Information Export</div>';
				echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';
					echo '<form class="ts-vcsc-license-check-wrap" name="oscimp_form" method="post" action="' . str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) . '">';
						echo '<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">';
							echo 'You can copy the full summary of your system information from the textarea below or save a .txt file with your system information by clicking on the button below.';
						echo '</div>';
						$secret 	= md5(md5(AUTH_KEY . SECURE_AUTH_KEY) . '-' . 'ts-vcsc-extend');
						$link 		= admin_url('admin-ajax.php?action=ts_system_download&secret=' . $secret );
						echo '<a href="' . $link . '" title="Click here to download info as txt file." style="width: 200px; margin-top: 10px; margin-bottom: 20px; text-align: center;" class="button-primary ButtonSubmit">Save as .txt File</a>';
						echo '<textarea id="ts-vcsc-system-info-textarea" name="ts-vcsc-system-info-textarea" wrap="hard" cols="2" rows="20" style="width: 100%;">' . str_replace('<br/>', PHP_EOL, $system_summary) . '</textarea>'; 
					echo '</form>';				
				echo '</div>';
			echo '</div>';
			update_option('ts_vcsc_extend_settings_systemInfo', str_replace('<br/>', PHP_EOL, $system_summary));
		echo '</div>';
	echo '</div>';
?>