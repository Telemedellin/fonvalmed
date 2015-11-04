<?php
	// The Plugin Name
	if (!defined('TS_VCSC_NOTIFIER_PLUGIN_NAME')){
		define('TS_VCSC_NOTIFIER_PLUGIN_NAME', 					'Composium - Visual Composer Extensions');
	}
	// The Plugin short name, only if needed to make the menu item fit
	if (!defined('TS_VCSC_NOTIFIER_PLUGIN_SHORT_NAME')){
		define('TS_VCSC_NOTIFIER_PLUGIN_SHORT_NAME', 			'Composium - VCE');
	}
	// The remote notifier XML file containing the latest version of the plugin and changelog
	if (!defined('TS_VCSC_NOTIFIER_PLUGIN_XML_FILE')){
		define('TS_VCSC_NOTIFIER_PLUGIN_XML_FILE', 				'http://tekanewascripts.com/updates/ts-update-vc-extensions-wp.xml');
	}
	// The time interval for the remote XML cache in the database (43200 seconds = 12 hours)
	if (!defined('TS_VCSC_PLUGIN_NOTIFIER_CACHE_INTERVAL')){
		if ($this->TS_VCSC_PluginIsMultiSiteActive == "true") {
			define('TS_VCSC_PLUGIN_NOTIFIER_CACHE_INTERVAL', 	get_site_option('ts_vcsc_extend_settings_notificationTime', 43200));
		} else {
			define('TS_VCSC_PLUGIN_NOTIFIER_CACHE_INTERVAL', 	get_option('ts_vcsc_extend_settings_notificationTime', 43200));
		}
	}
	
	// Adds an Update Notification to the WordPress Dashboard Menu
	if (!function_exists('TS_VCSC_XML_UpdateNotifierMenuItem')){
		function TS_VCSC_XML_UpdateNotifierMenuItem() {
			if (function_exists('simplexml_load_string')) {
				global $ts_vcsc_update_page;
				$xml 											= TS_VCSC_XML_GetLatestPluginVersion(TS_VCSC_PLUGIN_NOTIFIER_CACHE_INTERVAL);
				$plugin_data 									= get_plugin_data(WP_PLUGIN_DIR . '/' . COMPOSIUM_SLUG);
				if ((string) $xml->latest > (string) $plugin_data['Version']) {
					if (defined('TS_VCSC_NOTIFIER_PLUGIN_SHORT_NAME')) {
						$menu_name 								= TS_VCSC_NOTIFIER_PLUGIN_SHORT_NAME;
					} else {
						$menu_name 								= TS_VCSC_NOTIFIER_PLUGIN_NAME;
					}
					$ts_vcsc_update_page						= add_dashboard_page(TS_VCSC_NOTIFIER_PLUGIN_NAME . ' plugin update', $menu_name . ' <span class="update-plugins count-1"><span class="update-count">New Version!</span></span>', 'administrator', 'TS_VCSC_Notification', 'TS_VCSC_XML_UpdateNotifierPageContent');
				}
			}	
		}
	}
	add_action('admin_menu', 'TS_VCSC_XML_UpdateNotifierMenuItem');  
	
	// Adds an Update Notification to the Admin Bar
	if (!function_exists('TS_VCSC_XML_UpdateNotifierAdminBar')){
		function TS_VCSC_XML_UpdateNotifierAdminBar() {
			if (function_exists('simplexml_load_string')) {
				global $wp_admin_bar, $wpdb;	
				if (!is_super_admin() || !is_admin_bar_showing()) {
					return;
				}	
				$xml 											= TS_VCSC_XML_GetLatestPluginVersion(TS_VCSC_PLUGIN_NOTIFIER_CACHE_INTERVAL);
				$plugin_data 									= get_plugin_data(WP_PLUGIN_DIR . '/' . COMPOSIUM_SLUG);
				if ((string)$xml->latest > (string) $plugin_data['Version']) {
					$wp_admin_bar->add_menu(array(
						'id' 									=> 'TS_VCSC_Notification',
						'title' 								=> '<span>' . TS_VCSC_NOTIFIER_PLUGIN_NAME . ' <span id="ab-updates" style="color: #ffffff; background-color: #d54e21;">New Version!</span></span>',
						'href' 									=> get_admin_url() . 'index.php?page=TS_VCSC_Notification'
					));
				}
			}
		}
	}
	add_action('admin_bar_menu', 'TS_VCSC_XML_UpdateNotifierAdminBar', 1000);
	
	// The Notifier Page
	if (!function_exists('TS_VCSC_XML_UpdateNotifierPageContent')){
		function TS_VCSC_XML_UpdateNotifierPageContent() {
			global $VISUAL_COMPOSER_EXTENSIONS;			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginUsage == "true") {
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
					if ((get_site_option('ts_vcsc_extend_settings_demo', 1) == 0) && (get_option('ts_vcsc_extend_settings_extended', 0) == 0) && ((strpos(get_site_option('ts_vcsc_extend_settings_licenseInfo', ''), get_site_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix')) != FALSE))) {
						$plugin_autoupdate 						= 'true';
					} else {
						$plugin_autoupdate 						= 'false';
					}
				} else {
					if ((get_option('ts_vcsc_extend_settings_demo', 1) == 0) && (get_option('ts_vcsc_extend_settings_extended', 0) == 0) && ((strpos(get_option('ts_vcsc_extend_settings_licenseInfo', ''), get_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix')) != FALSE))) {
						$plugin_autoupdate 						= 'true';
					} else {
						$plugin_autoupdate 						= 'false';
					}
				}
			} else {
				$plugin_autoupdate 								= 'false';
			}
			$xml 												= TS_VCSC_XML_GetLatestPluginVersion(TS_VCSC_PLUGIN_NOTIFIER_CACHE_INTERVAL);
			$plugin_data 										= get_plugin_data(WP_PLUGIN_DIR . '/' . COMPOSIUM_SLUG);
			echo '<div class="wrap ts-settings" id="ts_vcsc_extend_frame" style="direction: ltr; margin-top: 25px;">' . "\n";
				echo '<div class="ts-vcsc-settings-group-header">';
					echo '<div class="display_header">';
						echo '<h2><span class="dashicons dashicons-admin-network"></span>' . TS_VCSC_NOTIFIER_PLUGIN_NAME . ': Plugin Update Available</h2>';
					echo '</div>';
					echo '<div class="clear"></div>';
				echo '</div>';
				echo '<div class="ts-vcsc-notification-check-wrap">';
					echo '<div class="ts-vcsc-section-main">';
						echo '<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-cloud"></i>Update Retrieval</div>';
						echo '<div class="ts-vcsc-section-content">';
							echo '<div class="ts-vcsc-info-field ts-vcsc-success" style="margin-top: 10px; font-size: 16px; text-align: justify; padding-top: 10px; padding-bottom: 10px;">';
								echo '<strong>There is a new version of "' . TS_VCSC_NOTIFIER_PLUGIN_NAME . '" available.</strong> You have version <b>' . $plugin_data['Version'] . '</b> installed. Update to version <b>' .  $xml->latest . '</b>.';
							echo '</div>';

							echo '<div style="text-align: justify; margin-bottom: 20px;">Depending upon the released update, the new plugin version will be made available to you via multiple channels. Each update will ALWAYS be available in our support
							forum, provided you created an account and registered your license key for authorization (one time only). All updates will also (eventually) be delivered via auto-update, provided you entered and confirmed your
							license key in the plugin settings. Lastly, most critical or major updates will be uploaded to CodeCanyon as well, but normal maintenance updates will not be available on CodeCanyon. If and when we make an
							update available on CodeCanyon, it will also be delayed due to the internal update approval process conducted by Envato Marketplaces.</div>';
	
							// Support Forum
							echo '<div style="text-align: justify; margin-bottom: 20px;">';
								if ((string) $xml->latest <= (string) $xml->forum) {
									echo '<div style="font-weight: bold;">Support Forum Version: ' . $xml->forum . ' (<span style="color: green;">Available</span>)</div>';
									echo '<div>To download the updated version, login to our <a href="http://helpdesk.tekanewascripts.com/" target="_blank"">Support Forum</a>, head over to the <a href="http://helpdesk.tekanewascripts.com/freebies-page/" target="_blank"><strong>Freebies</strong></a> page and download the plugin from the provided listing of plugin releases.</div>';
								} else {
									echo '<div style="font-weight: bold;">Support Forum Version: ' . $xml->forum . ' (<span style="color: red;">NOT Available</span>)</div>';
									echo '<div>This update is currently not yet available in our Support Forum. Please check back later.</div>';
								}
							echo '</div>';
							
							// Auto Update
							echo '<div style="text-align: justify; margin-bottom: 20px;">';
								if ((string) $xml->latest <= (string) $xml->autoupdate) {
									echo '<div style="font-weight: bold;">AutoUpdate Version: ' . $xml->autoupdate . ' (<span style="color: green;">Available</span>)</div>';
									if ($plugin_autoupdate == "false") {									
										echo '<div class="ts-vcsc-info-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify; padding-top: 10px; padding-bottom: 10px;">';
											echo 'This installation of "' . TS_VCSC_NOTIFIER_PLUGIN_NAME . '" does currently not qualify for the auto-update routine. Please enter or check your license key in the plugin settings.';
										echo '</div>';
									} else {
										if (get_option('ts_vcsc_extend_settings_allowAutoUpdate', 1) == 1) {
											echo '<div class="ts-vcsc-info-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify; padding-top: 10px; padding-bottom: 10px;">';
												echo 'This installation of "' . TS_VCSC_NOTIFIER_PLUGIN_NAME . '" qualifies for the auto-update routine, and the feature has been enabled in the plugin settings.';
											echo '</div>';
										} else {
											echo '<div class="ts-vcsc-info-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify; padding-top: 10px; padding-bottom: 10px;">';
												echo 'This installation of "' . TS_VCSC_NOTIFIER_PLUGIN_NAME . '" qualifies for the auto-update routine, but the feature has been disabled in the plugin settings.';
											echo '</div>';
										}
									}
									echo 'If you entered and confirmed your license key in the plugin settings, you can also use the auto-update feature through WordPress, which will prompt you to update once it detects the
									new update package. Depending upon the next time WordPress is cycling its next update check, the auto-update trigger can be delayed up to 24 hours, but will prompt eventually.';
								} else {
									echo '<div style="font-weight: bold;">AutoUpdate Version: ' . $xml->autoupdate . ' (<span style="color: red;">NOT Available</span>)</div>';
									echo '<div>This update is currently not yet available via auto update. Please check back later.</div>';
								}
							echo '</div>';
							
							// CodeCanyon
							echo '<div style="text-align: justify; margin-bottom: 20px;">';
								if ((string) $xml->latest <= (string) $xml->codecanyon) {
									echo '<div style="font-weight: bold;">CodeCanyon Version: ' . $xml->codecanyon . ' (<span style="color: green;">Available</span>)</div>';
									echo '<div>To download the updated version, log into <a href="//codecanyon.net/?ref=Tekanewa" target="_blank"">CodeCanyon</a>, head over to your <a href="http://codecanyon.net/downloads" target="_blank"><strong>Downloads</strong></a> section and re-download the plugin like you did when you first bought it.</div>';
								} else {
									echo '<div style="font-weight: bold;">CodeCanyon Version: ' . $xml->codecanyon . ' (<span style="color: red;">NOT Available</span>)</div>';
									echo '<div>This update is currently not yet available on CodeCanyon. Please check back later.</div>';
								}
							echo '</div>';
						echo '</div>';
					echo '</div>';
					
					echo '<div class="ts-vcsc-section-main">';
						echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-media-text"></i>Update Changes</div>';
						echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';
							echo $xml->changelog;
						echo '</div>';
					echo '</div>';
					
					echo '<div class="ts-vcsc-section-main">';
						echo '<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-info"></i>Update Steps</div>';
						echo '<div class="ts-vcsc-section-content slideFade" style="display: none;">';
							echo '<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify; padding-top: 10px; padding-bottom: 10px;">';
								echo 'If you made any changes to plugin files, it is advised to make a <strong>backup</strong> of the existing plugin version inside your WordPress installation folder.';
							echo '</div>';
							// Path
							echo '<div>Plugin Installation Path: <strong>' . COMPOSIUM_EXTENSIONS . '</strong></div>';
							// FTP
							echo '<div style="font-weight: bold; margin: 20px auto;">Manual Update via FTP:</div>';
							echo '<ul>';
								echo '<li>Download the updated version using the available ressources listed in the "Update Retrieval" section above</li>';
								echo '<li>Extract the downloaded zip archive</li>';
								echo '<li>Upload the extracted folders including all subfolders and files using FTP to the installation folder listed above</li>';
								echo '<li>If prompted, confirm overwriting the existing folders and files (or at least the ones with a different date or size)</li>';
							echo '</ul>';
							echo '<div>If you did not make any changes to the plugin files, you are free to overwrite them with the new ones without the risk of losing any plugins settings, and backwards compatibility is
							guaranteed, unless noted otherwise in the changelog below.</div>';
							// WordPress
							echo '<div style="font-weight: bold; margin: 20px auto;">Manual Update via WordPress:</div>';
							echo '<div class="ts-vcsc-info-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify; padding-top: 10px; padding-bottom: 10px;">';
								echo 'Since the plugin is already installed, you can NOT simply install it again, as WordPress will produce an error, informing you that the plugin folder already exists! You will have to uninstall the
								existing version first but be aware that uninstalling the existing version will also remove all plugin settings you made! <strong>It is highly recommend to conduct manual updates only via the
								FTP method described above!</strong>';
							echo '</div>';
							echo '<ul>';
								echo '<li>Download the updated version using the available ressources listed in the "Update Retrieval" section above</li>';
								echo '<li>Deactivate and uninstall the existing plugin version via the WordPress "<a href="' . ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true" ? network_admin_url() : admin_url()) . 'plugins.php" target="_blank">Plugins</a>" page</li>';
								echo '<li>On the "<a href="' . ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true" ? network_admin_url() : admin_url()) . 'plugins.php" target="_blank">Plugins</a>" page, click the "Add New" button at the top of the page</li>';
								echo '<li>On the "<a href="' . ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true" ? network_admin_url() : admin_url()) . 'plugin-install.php" target="_blank">Add Plugins</a>" page, click the "Upload Plugin" button at the top of the page</li>';
								echo '<li>Click on the "Browse" button and navigate to the folder on your harddrive, where you saved the downloaded .zip archive that contains the update</li>';
								echo '<li>Select the downloaded .zip archive that contains the update</li>';
								echo '<li>Click on "Open"</li>';
								echo '<li>Click on "Install Now" and follow instructions</li>';
							echo '</ul>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}
	}
	
	// Get the remote XML file contents and return its data (Version and Changelog)
	// Uses the cached version if available and inside the time interval defined
	if (!function_exists('TS_VCSC_XML_GetLatestPluginVersion')){
		function TS_VCSC_XML_GetLatestPluginVersion($interval) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			$notifier_file_url 								= TS_VCSC_NOTIFIER_PLUGIN_XML_FILE;	
			$db_cache_field 								= 'ts_vcsc_extend_settings_notificationCache';
			$db_cache_field_last_updated 					= 'ts_vcsc_extend_settings_notificationLast';
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
				$last 										= get_site_option($db_cache_field_last_updated, '');
			} else {
				$last 										= get_option($db_cache_field_last_updated, '');
			}
			$now 											= time();
			// Check the Cache
			if (!$last || (($now - $last) > $interval)) {
				// Cache doesn't exist, or is old, so refresh it
				if (function_exists('curl_init')) {
					$ch 									= curl_init($notifier_file_url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_TIMEOUT, 10);
					$cache 									= curl_exec($ch);
					curl_close($ch);
				} else {
					$cache 									= file_get_contents($notifier_file_url);
				}
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
					if ($cache) {
						update_site_option($db_cache_field, $cache);
						update_site_option($db_cache_field_last_updated, time());
					} 
					$notifier_data 							= get_site_option($db_cache_field, '');
				} else {
					if ($cache) {
						update_option($db_cache_field, $cache);
						update_option($db_cache_field_last_updated, time());
					} 
					$notifier_data 							= get_option($db_cache_field, '');
				}
			} else {
				// Cache File is fresh enough, so read from it
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
					$notifier_data 							= get_site_option($db_cache_field, '');
				} else {
					$notifier_data 							= get_option($db_cache_field, '');
				}
			}
			// Let's see if the $xml data was returned as we expected it to.
			// If it didn't, use the default 1.0 as the latest version so that we don't have problems when the remote server hosting the XML file is down
			if (strpos((string) $notifier_data, '<notifier>') === false) {
				$notifier_data = '<?xml version="1.0" encoding="UTF-8"?><notifier><latest>1.0.0</latest><date>N/A</date><codecanyon>1.0.0</codecanyon><autoupdate>1.0.0</autoupdate><forum>1.0.0</forum><changelog>N/A</changelog></notifier>';
			}
			// Load the remote XML data into a variable and return it
			$xml = simplexml_load_string($notifier_data);
			return $xml;
		}
	}
?>