<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
	$ts_vcsc_extend_settings_licenseKeyed 									= '';
	$ts_vcsc_extend_settings_licenseRemove									= 'false';

	// Check License Key with Envato API
	// ---------------------------------
	if (!function_exists('TS_VCSC_checkEnvatoAPI')){
		function TS_VCSC_checkEnvatoAPI() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
				if (strlen(get_site_option('ts_vcsc_extend_settings_license')) != 0) {
					$envato_code 													= get_site_option('ts_vcsc_extend_settings_license');
				} else {
					$envato_code 													= "";
				}
				$ts_vcsc_extend_settings_licenseKeyed 								= get_site_option('ts_vcsc_extend_settings_licenseKeyed',			'emptydelimiterfix');
			} else {
				if (strlen(get_option('ts_vcsc_extend_settings_license')) != 0) {
					$envato_code 													= get_option('ts_vcsc_extend_settings_license');
				} else {
					$envato_code 													= "";
				}
				$ts_vcsc_extend_settings_licenseKeyed 								= get_option('ts_vcsc_extend_settings_licenseKeyed',				'emptydelimiterfix');
			}		
			if (!in_array(base64_encode($envato_code), $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Avoid_Duplications)) {
				if ((function_exists('wp_remote_get')) && (strlen($envato_code) != 0)) {
					$remoteResponse = wp_remote_get($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_External_URL . $envato_code . '&protocol=' . TS_VCSC_SiteProtocol() . '&clienturl=' . preg_replace('#^https?://#', '', site_url()), array('timeout' => 120, 'user-agent' => 'Composium - Visual Composer Extensions', 'httpversion' => '1.1'));
					$responseText 	= wp_remote_retrieve_body($remoteResponse);
					$responseCode 	= wp_remote_retrieve_response_code($remoteResponse);
				} else if ((function_exists('wp_remote_post')) && (strlen($envato_code) != 0)) {
					$remoteResponse = wp_remote_post($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_External_URL . $envato_code . '&protocol=' . TS_VCSC_SiteProtocol() . '&clienturl=' . preg_replace('#^https?://#', '', site_url()), array('timeout' => 120, 'user-agent' => 'Composium - Visual Composer Extensions', 'httpversion' => '1.1'));
					$responseText 	= wp_remote_retrieve_body($remoteResponse);
					$responseCode 	= wp_remote_retrieve_response_code($remoteResponse);
				} else {
					$remoteResponse = "";
					$responseText	= "";
					$responseCode 	= "";
				}
			} else {
				$remoteResponse = "";
				$responseText	= "";
				$responseCode 	= "";
			}
			if (($responseCode == 200) && (strlen($responseText) != 0)) {
				if ((strlen($envato_code) == 0) || (strpos($responseText, $envato_code) === FALSE)) {
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
						update_site_option('ts_vcsc_extend_settings_licenseValid', 	0);
						update_site_option('ts_vcsc_extend_settings_licenseKeyed', 	'emptydelimiterfix');
						update_site_option('ts_vcsc_extend_settings_licenseInfo', 	((strlen($envato_code) != 0) ? $responseText : ''));
						update_site_option('ts_vcsc_extend_settings_demo', 			1);
					} else {
						update_option('ts_vcsc_extend_settings_licenseValid', 		0);
						update_option('ts_vcsc_extend_settings_licenseKeyed', 		'emptydelimiterfix');
						update_option('ts_vcsc_extend_settings_licenseInfo', 		((strlen($envato_code) != 0) ? $responseText : ''));
						update_option('ts_vcsc_extend_settings_demo', 				1);
					}
					$LicenseCheckStatus = '<div class="clearFixMe" style="color: red; font-weight: bold; padding-bottom: 10px;">License Check has been initiated but was unsuccessful!</div>';
					$LicenseCheckSuccess = 0;
				} else if ((strlen($envato_code) != 0) && (strpos($responseText, $envato_code) != FALSE)) {
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
						update_site_option('ts_vcsc_extend_settings_licenseValid', 	1);
						update_site_option('ts_vcsc_extend_settings_licenseKeyed', 	$envato_code);
						update_site_option('ts_vcsc_extend_settings_licenseInfo', 	str_replace("Link_To_Envato_Image", TS_VCSC_GetResourceURL('images/envato/envato_logo.png'), $responseText));
						update_site_option('ts_vcsc_extend_settings_demo', 			0);
					} else {
						update_option('ts_vcsc_extend_settings_licenseValid', 		1);
						update_option('ts_vcsc_extend_settings_licenseKeyed', 		$envato_code);
						update_option('ts_vcsc_extend_settings_licenseInfo', 		str_replace("Link_To_Envato_Image", TS_VCSC_GetResourceURL('images/envato/envato_logo.png'), $responseText));
						update_option('ts_vcsc_extend_settings_demo', 				0);
					}
					$LicenseCheckStatus = '<div class="clearFixMe" style="color: green; font-weight: bold; padding-bottom: 10px;">License Check has been succesfully completed!</div>';
					$LicenseCheckSuccess = 1;
				} else {
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
						update_site_option('ts_vcsc_extend_settings_licenseValid', 	0);
						update_site_option('ts_vcsc_extend_settings_licenseKeyed', 	'emptydelimiterfix');
						update_site_option('ts_vcsc_extend_settings_licenseInfo', 	((strlen($envato_code) != 0) ? $responseText : ''));
						update_site_option('ts_vcsc_extend_settings_demo', 			1);
					} else {
						update_option('ts_vcsc_extend_settings_licenseValid', 		0);
						update_option('ts_vcsc_extend_settings_licenseKeyed', 		'emptydelimiterfix');
						update_option('ts_vcsc_extend_settings_licenseInfo', 		((strlen($envato_code) != 0) ? $responseText : ''));
						update_option('ts_vcsc_extend_settings_demo', 				1);
					}
					$LicenseCheckStatus = '<div class="clearFixMe" style="color: red; font-weight: bold; padding-bottom: 10px;">License Check has been initiated but was unsuccessful!</div>';
					$LicenseCheckSuccess = 0;
				}
			} else {
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
					update_site_option('ts_vcsc_extend_settings_licenseValid', 		0);
					update_site_option('ts_vcsc_extend_settings_licenseKeyed', 		'emptydelimiterfix');
					update_site_option('ts_vcsc_extend_settings_licenseInfo', 		'');
					update_site_option('ts_vcsc_extend_settings_demo', 				1);
				} else {
					update_option('ts_vcsc_extend_settings_licenseValid', 			0);
					update_option('ts_vcsc_extend_settings_licenseKeyed', 			'emptydelimiterfix');
					update_option('ts_vcsc_extend_settings_licenseInfo', 			'');
					update_option('ts_vcsc_extend_settings_demo', 					1);
				}
				if (in_array(base64_encode($envato_code), $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Avoid_Duplications)) {
					$LicenseCheckStatus = '<div class="clearFixMe" style="color: red; font-weight: bold; padding-bottom: 10px;">The License Key has been revoked by Envato due to a full refund of the purchase price!</div>';
				} else {
					$LicenseCheckStatus = '<div class="clearFixMe" style="color: red; font-weight: bold; padding-bottom: 10px;">License Check could not be initiated - Missing License Key!</div>';
				}
				$LicenseCheckSuccess = 0;
			}
		}
	}
	
	// Get Item Information from Envato
	// --------------------------------
	if (!function_exists('TS_VCSC_SiteProtocol')){
		function TS_VCSC_SiteProtocol() {
			if (stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true) {
				return 'https';
			} else if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) {
				return 'https';
			} else {
				return 'http';
			}
		}
	}
	if (!function_exists('TS_VCSC_ShowInformation')){
		function TS_VCSC_ShowInformation($item_id, $item_vc = true) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			if (($item_vc == true) || ($item_id == "")) {
				$item_id 							= $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_API_ItemID;
			}
			$api_path 								= "https://api.envato.com/v2/market/catalog/item?id=" . $item_id;
			$api_last								= get_option('ts_vcsc_extend_settings_envatoCheck', 	0);
			$api_current							= time();
			$api_data								= get_option('ts_vcsc_extend_settings_envatoData', 		'');
			if (($api_data == "") || (($api_last + 3600) < $api_current)) {
				/* Fetch data using the WordPress function wp_remote_get() */
				if ((function_exists('wp_remote_get')) && (strlen($item_id) != 0)) {
					$response               		= wp_remote_get($api_path, array(
						'user-agent'        		=> 'Visual Composer Extensions (7190695) by Tekanewa Scripts',
						'httpversion' 				=> '1.1',
						'headers'           		=> array(
							'Authorization' 		=> 'Bearer ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_API_Token,
						),
					));
				} else if ((function_exists('wp_remote_post')) && (strlen($item_id) != 0)) {
					$response               		= wp_remote_post($api_path, array(
						'user-agent'        		=> 'Visual Composer Extensions (7190695) by Tekanewa Scripts',
						'httpversion' 				=> '1.1',
						'headers'           		=> array(
							'Authorization' 		=> 'Bearer ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_API_Token,
						),
					));
				}
				/* Check for errors, if there are some errors return false */
				if (is_wp_error($response) or (wp_remote_retrieve_response_code($response) != 200)) {
					$item 							= false;
				} else {
					/* Transform the JSON string into a PHP array */
					$item 							= json_decode(wp_remote_retrieve_body($response), true);
					/* Check for incorrect data */
					if (!is_array($item)) {
						$item						= false;
					}
				}
				if (($item == false) && ($api_data != "")) {
					$item 							= $api_data;
				}
			} else {
				$item								= $api_data;
			}
			if ($item === false) {
				echo '<p style="text-align: justify;">Oops... Something went wrong. Could not retrieve item information from Envato.</p>';
			} else {
				// Parse Item Data
				$ts_vcsc_extend_envatoItem_Data		= array();
				$ts_vcsc_extend_envatoItem_Name     = (isset($item["name"]) 			? $item["name"] 			: "N/A");
				$ts_vcsc_extend_envatoItem_User		= (isset($item["author_username"]) 	? $item["author_username"] 	: "N/A");
				$ts_vcsc_extend_envatoItem_Rating	= (isset($item["rating"]["rating"]) ? $item["rating"]["rating"] : "N/A");
				$ts_vcsc_extend_envatoItem_Votes	= (isset($item["rating"]["count"]) 	? $item["rating"]["count"] 	: "N/A");
				$ts_vcsc_extend_envatoItem_Sales	= (isset($item["number_of_sales"]) 	? $item["number_of_sales"] 	: "N/A");
				$ts_vcsc_extend_envatoItem_Price	= (isset($item["price_cents"]) 		? $item["price_cents"] 		: "N/A");
				$ts_vcsc_extend_envatoItem_Thumb	= (isset($item["thumbnail_url"]) 	? $item["thumbnail_url"] 	: "N/A");
				$ts_vcsc_extend_envatoItem_Link		= (isset($item["url"]) 				? $item["url"] 				: "N/A");
				$ts_vcsc_extend_envatoItem_Release	= (isset($item["published_at"]) 	? $item["published_at"] 	: "N/A");
				$ts_vcsc_extend_envatoItem_Update	= (isset($item["updated_at"]) 		? $item["updated_at"] 		: "N/A");
				$ts_vcsc_extend_envatoItem_Check	= time();
				// Populate Data Array
				$ts_vcsc_extend_envatoItem_Data["name"] 				= $ts_vcsc_extend_envatoItem_Name;
				$ts_vcsc_extend_envatoItem_Data["author_username"]		= $ts_vcsc_extend_envatoItem_User;
				$ts_vcsc_extend_envatoItem_Data["rating"]["rating"]		= $ts_vcsc_extend_envatoItem_Rating;
				$ts_vcsc_extend_envatoItem_Data["rating"]["count"]		= $ts_vcsc_extend_envatoItem_Votes;
				$ts_vcsc_extend_envatoItem_Data["number_of_sales"]		= $ts_vcsc_extend_envatoItem_Sales;
				$ts_vcsc_extend_envatoItem_Data["price_cents"]			= $ts_vcsc_extend_envatoItem_Price;
				$ts_vcsc_extend_envatoItem_Data["thumbnail_url"]		= $ts_vcsc_extend_envatoItem_Thumb;
				$ts_vcsc_extend_envatoItem_Data["url"]					= $ts_vcsc_extend_envatoItem_Link;
				$ts_vcsc_extend_envatoItem_Data["published_at"]			= $ts_vcsc_extend_envatoItem_Release;
				$ts_vcsc_extend_envatoItem_Data["updated_at"]			= $ts_vcsc_extend_envatoItem_Update;
				// Create HTML Output
				$ts_vcsc_extend_envatoItem_HTML 	= '';
				$ts_vcsc_extend_envatoItem_HTML .= '
					<div class="ts_vcsc_envato_item">
						<div class="ts_vcsc_title">' . $ts_vcsc_extend_envatoItem_Name . '</div>
						<div class="ts_vcsc_wrap">
							<div class="ts_vcsc_top">
								<div class="ts_vcsc_rating"><span class="ts_vcsc_desc">Rating</span>' . TS_VCSC_GetEnvatoStars(round($ts_vcsc_extend_envatoItem_Rating)) . '</div>
							</div>
							<div class="ts_vcsc_middle">
								<div class="ts_vcsc_sales">
									<span class="ts_vcsc_img_sales"></span>
									<div class="ts_vcsc_text">
										<span class="ts_vcsc_num">' . number_format($ts_vcsc_extend_envatoItem_Sales, 0) . '</span>
										<span class="ts_vcsc_desc">Sales</span>
									</div>
								</div>
								<div class="ts_vcsc_thumb">
									<img src="' . $ts_vcsc_extend_envatoItem_Thumb . '" alt="' . $ts_vcsc_extend_envatoItem_Name . '" width="80" height="80"/>
								</div>
								<div class="ts_vcsc_price">
									<span class="ts_vcsc_img_price"></span>
									<div class="ts_vcsc_text">
										<span class="ts_vcsc_num"><span>$</span>' . round($ts_vcsc_extend_envatoItem_Price / 100) . '</span>
										<span class="ts_vcsc_desc">only</span>
									</div>
								</div>
							</div>
							<div class="ts_vcsc_bottom">
								<a href="' . $ts_vcsc_extend_envatoItem_Link . '" target="_blank"></a>
							</div>
						</div>
					</div>';
				if ($item_vc == true) {
					update_option('ts_vcsc_extend_settings_envatoData', 	$ts_vcsc_extend_envatoItem_Data);
					update_option('ts_vcsc_extend_settings_envatoInfo', 	$ts_vcsc_extend_envatoItem_HTML);
					update_option('ts_vcsc_extend_settings_envatoLink', 	$ts_vcsc_extend_envatoItem_Link);
					update_option('ts_vcsc_extend_settings_envatoPrice', 	$ts_vcsc_extend_envatoItem_Price);
					update_option('ts_vcsc_extend_settings_envatoRating', 	TS_VCSC_GetEnvatoStars($ts_vcsc_extend_envatoItem_Rating));
					update_option('ts_vcsc_extend_settings_envatoSales', 	$ts_vcsc_extend_envatoItem_Sales);
					update_option('ts_vcsc_extend_settings_envatoCheck', 	$ts_vcsc_extend_envatoItem_Check);
				} else {
					echo $ts_vcsc_extend_envatoItem_HTML;
				}
			}
		}
	}
	if (!function_exists('TS_VCSC_GetItemInfo')){
		function TS_VCSC_GetItemInfo($item_id) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			/* Data cache timeout in seconds - It sends a new request each hour instead of each page refresh */
			$CACHE_EXPIRATION = 3600;
			/* Set the transient ID for caching */
			$transient_id = 'TS_VCSC_Extend_Envato_Item_Data';
			/* Get the cached data */
			$cached_item = get_transient($transient_id);
			/* Check if the function has to send a new API request */
			if (!$cached_item || ($cached_item->item_id != $item_id)) {
				/* Set the API URL, %s will be replaced with the item ID  */
				$api_path 						= "https://api.envato.com/v2/market/catalog/item?id=" . $item_id;
				/* Fetch data using the WordPress function wp_remote_get() */
				if ((function_exists('wp_remote_get')) && (strlen($item_id) != 0)) {
					$response               	= wp_remote_get($api_path, array(
						'user-agent'        	=> 'Visual Composer Extensions (7190695) by Tekanewa Scripts',
						'httpversion' 			=> '1.1',
						'headers'           	=> array(
							'Authorization' 	=> 'Bearer ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_API_Token,
						),
					));
				} else if ((function_exists('wp_remote_post')) && (strlen($item_id) != 0)) {
					$response               	= wp_remote_post($api_path, array(
						'user-agent'        	=> 'Visual Composer Extensions (7190695) by Tekanewa Scripts',
						'httpversion' 			=> '1.1',
						'headers'           	=> array(
							'Authorization' 	=> 'Bearer ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_API_Token,
						),
					));
				}
				/* Check for errors, if there are some errors return false */
				if (is_wp_error($response) or (wp_remote_retrieve_response_code($response) != 200)) {
					return false;
				}
				/* Transform the JSON string into a PHP array */
				$item_data 						= json_decode(wp_remote_retrieve_body($response), true);
				/* Check for incorrect data */
				if (!is_array($item_data)) {
					return false;
				}
				/* Prepare data for caching */
				$data_to_cache = new stdClass();
				$data_to_cache->item_id 		= $item_id;
				$data_to_cache->item_info 		= $item_data;
				/* Set the transient - cache item data*/
				//set_transient($transient_id, $data_to_cache, $CACHE_EXPIRATION);
				/* Return item info array */
				return $item_data;
			}
			/* If the item is already cached return the cached info */
			return $cached_item->item_info;			
		}
	}
	if (!function_exists('TS_VCSC_GetEnvatoStars')){
		function TS_VCSC_GetEnvatoStars($rating) {
			if ((int) $rating == 0) {
				return '<div class="ts_vcsc_not_rating">Not Rated Yet.</div>';
			}
			$return = '<ul class="ts_vcsc_stars">';
			$i=1;
			while ((--$rating) >= 0) {
				$return .= '<li class="ts_vcsc_full_star"></li>';
				$i++;
			}
			if ($rating == -0.5) {
				$return .= '<li class="ts_vcsc_full_star"></li>';
				$i++;
			}
			while ($i <= 5) {
				$return .= '<li class="ts_vcsc_empty_star"></li>';
				$i++;
			}
			$return .= '</ul>';
			return $return;
		}
	}
	
	// Save / Load Parameters
	// ----------------------
	if (isset($_POST['License'])) {		
		echo '<div id="ts_vcsc_extend_settings_save" style="margin: 20px auto 20px auto; width: 128px; height: 128px;">';
			echo '<img style="width: 128px; height: 128px;" src="' . TS_VCSC_GetResourceURL('images/other/ajax_loader.gif') . '">';
		echo '</div>';
		
		$ts_vcsc_extend_settings_license 									= trim ($_POST['ts_vcsc_extend_settings_license']);
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
			$ts_vcsc_extend_settings_licenseKeyed 							= get_site_option('ts_vcsc_extend_settings_licenseKeyed',		'emptydelimiterfix');
			$ts_vcsc_extend_settings_licenseInfo 							= get_site_option('ts_vcsc_extend_settings_licenseInfo',		'');
			update_site_option('ts_vcsc_extend_settings_license', 			$ts_vcsc_extend_settings_license);
			update_site_option('ts_vcsc_extend_settings_licenseUpdate', 	1);
		} else {
			$ts_vcsc_extend_settings_licenseKeyed 							= get_option('ts_vcsc_extend_settings_licenseKeyed',			'emptydelimiterfix');
			$ts_vcsc_extend_settings_licenseInfo 							= get_option('ts_vcsc_extend_settings_licenseInfo',				'');
			update_option('ts_vcsc_extend_settings_license', 				$ts_vcsc_extend_settings_license);
			update_option('ts_vcsc_extend_settings_licenseUpdate', 			1);
		}
		echo '<script> window.location="' . $_SERVER['REQUEST_URI'] . '"; </script> ';
		//Header('Location: '.$_SERVER['REQUEST_URI']);
		Exit();
	} else if (isset($_POST['Unlicense'])) {
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
			update_site_option('ts_vcsc_extend_settings_license', 			'');
			update_site_option('ts_vcsc_extend_settings_licenseKeyed', 		'unlicenseinprogress');
			update_site_option('ts_vcsc_extend_settings_licenseUpdate', 	1);
		} else {
			update_option('ts_vcsc_extend_settings_license', 				'');
			update_option('ts_vcsc_extend_settings_licenseKeyed', 			'unlicenseinprogress');
			update_option('ts_vcsc_extend_settings_licenseUpdate', 			1);
		}
		echo '<script> window.location="' . $_SERVER['REQUEST_URI'] . '"; </script> ';
		//Header('Location: '.$_SERVER['REQUEST_URI']);
		Exit();
	} else {
		TS_VCSC_ShowInformation('7190695');
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
			$ts_vcsc_extend_settings_license 						= get_site_option('ts_vcsc_extend_settings_license',			'');
			$ts_vcsc_extend_settings_licenseKeyed 					= get_site_option('ts_vcsc_extend_settings_licenseKeyed',		'emptydelimiterfix');
			$ts_vcsc_extend_settings_licenseInfo 					= get_site_option('ts_vcsc_extend_settings_licenseInfo',		'');
		} else {
			$ts_vcsc_extend_settings_license 						= get_option('ts_vcsc_extend_settings_license',					'');
			$ts_vcsc_extend_settings_licenseKeyed 					= get_option('ts_vcsc_extend_settings_licenseKeyed',			'emptydelimiterfix');
			$ts_vcsc_extend_settings_licenseInfo 					= get_option('ts_vcsc_extend_settings_licenseInfo',				'');
		}
		
		if ($ts_vcsc_extend_settings_licenseKeyed == 'unlicenseinprogress') {
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
				update_site_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix');
			} else {
				update_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix');
			}
			$ts_vcsc_extend_settings_licenseRemove 					= 'true';
		}
		
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
			if (get_site_option('ts_vcsc_extend_settings_licenseUpdate') == 1) {
				TS_VCSC_checkEnvatoAPI();
				echo "\n";
				echo "<script type='text/javascript'>" . "\n";
				echo "SettingsLicenseUpdate = true;" . "\n";
					if (get_site_option('ts_vcsc_extend_settings_licenseValid') == 1) {
						echo 'VC_Extension_Demo = false;' . "\n";
					} else {
						echo 'VC_Extension_Demo = true;' . "\n";
					}
					if (strlen(get_site_option('ts_vcsc_extend_settings_license')) != 0) {
						echo "SettingsLicenseKey = true;" . "\n";
					} else {
						echo "SettingsLicenseKey = false;" . "\n";
					}
				if ($ts_vcsc_extend_settings_licenseRemove == 'true') {
					echo "SettingsUnLicensing = true;" . "\n";
				} else {
					echo "SettingsUnLicensing = false;" . "\n";
				}
				echo "</script>" . "\n";
			} else {
				echo "\n";
				echo "<script type='text/javascript'>" . "\n";
				echo "SettingsLicenseUpdate = false;" . "\n";
					if (get_site_option('ts_vcsc_extend_settings_licenseValid') == 1) {
						echo 'VC_Extension_Demo = false;' . "\n";
					} else {
						echo 'VC_Extension_Demo = true;' . "\n";
					}
					if (strlen(get_site_option('ts_vcsc_extend_settings_license')) != 0) {
						echo "SettingsLicenseKey = true;" . "\n";
					} else {
						echo "SettingsLicenseKey = false;" . "\n";
					}
				if ($ts_vcsc_extend_settings_licenseRemove == 'true') {
					echo "SettingsUnLicensing = true;" . "\n";
				} else {
					echo "SettingsUnLicensing = false;" . "\n";
				}
				echo "</script>" . "\n";
			}
		} else {
			if (get_option('ts_vcsc_extend_settings_licenseUpdate') == 1) {
				TS_VCSC_checkEnvatoAPI();
				echo "\n";
				echo "<script type='text/javascript'>" . "\n";
				echo "SettingsLicenseUpdate = true;" . "\n";
					if (get_option('ts_vcsc_extend_settings_licenseValid') == 1) {
						echo 'VC_Extension_Demo = false;' . "\n";
					} else {
						echo 'VC_Extension_Demo = true;' . "\n";
					}
					if (strlen(get_option('ts_vcsc_extend_settings_license')) != 0) {
						echo "SettingsLicenseKey = true;" . "\n";
					} else {
						echo "SettingsLicenseKey = false;" . "\n";
					}
				if ($ts_vcsc_extend_settings_licenseRemove == 'true') {
					echo "SettingsUnLicensing = true;" . "\n";
				} else {
					echo "SettingsUnLicensing = false;" . "\n";
				}
				echo "</script>" . "\n";
			} else {
				echo "\n";
				echo "<script type='text/javascript'>" . "\n";
				echo "SettingsLicenseUpdate = false;" . "\n";
					if (get_option('ts_vcsc_extend_settings_licenseValid') == 1) {
						echo 'VC_Extension_Demo = false;' . "\n";
					} else {
						echo 'VC_Extension_Demo = true;' . "\n";
					}
					if (strlen(get_option('ts_vcsc_extend_settings_license')) != 0) {
						echo "SettingsLicenseKey = true;" . "\n";
					} else {
						echo "SettingsLicenseKey = false;" . "\n";
					}
				if ($ts_vcsc_extend_settings_licenseRemove == 'true') {
					echo "SettingsUnLicensing = true;" . "\n";
				} else {
					echo "SettingsUnLicensing = false;" . "\n";
				}
				echo "</script>" . "\n";
			}
		}
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
			update_site_option('ts_vcsc_extend_settings_licenseUpdate', 	0);
		} else {
			update_option('ts_vcsc_extend_settings_licenseUpdate', 			0);
		}
		
		$LicenseCheckStatus = "";
	}
?>

<?php
	echo '<div class="ts-vcsc-settings-group-header">';
		echo '<div class="display_header">';
			echo '<h2><span class="dashicons dashicons-admin-network"></span>Visual Composer Extensions - License Information</h2>';
		echo '</div>';
		echo '<div class="clear"></div>';
	echo '</div>';
?>
<form class="ts-vcsc-license-check-wrap" name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-info"></i>License Information</div>
		<div class="ts-vcsc-section-content">
			<a class="button-secondary" style="width: 200px; margin: 10px auto 10px auto; text-align: center;" href="<?php echo $VISUAL_COMPOSER_EXTENSIONS->settingsLink; ?>" target="_parent"><img src="<?php echo TS_VCSC_GetResourceURL('images/logos/ts_vcsc_menu_icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Back to Plugin Settings</a>
			<?php
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
					if (get_site_option('ts_vcsc_extend_settings_demo', 1) == 1) {
						echo '<div class="ts-vcsc-info-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">Please enter your License Key in order to activate the Auto-Update and the bonus tinyMCE Font Icon Generator features of the plugin!</div>';
					}
				} else {
					if (get_option('ts_vcsc_extend_settings_demo', 1) == 1) {
						echo '<div class="ts-vcsc-info-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">Please enter your License Key in order to activate the Auto-Update and the bonus tinyMCE Font Icon Generator features of the plugin!</div>';
					}
				}
			?>			
			<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				In order to use this plugin, you MUST have the Visual Composer Plugin installed; either as a normal plugin or as part of your theme. If Visual Composer is part of your theme, please ensure that it has not been modified;
				some theme developers heavily modify Visual Composer in order to allow for certain theme functions. Unfortunately, some of these modification prevent this extension pack from working correctly.
			</div>			
			<?php
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
					$envato_code = get_site_option('ts_vcsc_extend_settings_license', '');
					echo '<div class="ts-vcsc-info-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify; font-weight: bold;">';
						echo 'This plugin has been activated network-wide in a WordPress MultiSite environment. Please consider purchasing additional licenses for the plugin as Envato license rules restrict usage to one domain only! Thank you!';
					echo '</div>';
				} else {
					$envato_code = get_option('ts_vcsc_extend_settings_license', '');
				}
				if (in_array(base64_encode($envato_code), $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Avoid_Duplications)) {
					echo '<div class="ts-vcsc-info-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify; font-weight: bold;">';
						echo 'The license key you are attempting to use has been revoked by Envato due to the fact that the buyer received a full refund of the purchase price. Continued usage of the product is illegal!';
					echo '</div>';
				}
			?>
		</div>		
	</div>
	<div class="wrapper" style="min-height: 100px; width: 100%; margin-top: 20px;">
		<table style="border: 1px solid #ededed; min-height: 100px; width: 100%;">
			<tr>
				<td style="width: 250px; padding: 0px 20px 0px 20px; border-right: 1px solid #ededed;"><?php echo get_option('ts_vcsc_extend_settings_envatoInfo'); ?></td>
				<td>
					<div>
						<h4 style="margin-top: 20px;"><span style="margin-left: 10px;">Envato Purchase License Key:</span></h4>
						<p style="margin-top: 5px; margin-left: 10px; margin-bottom: 15px;">Please enter your Envato Purchase License Key here:</p>
						<?php echo $LicenseCheckStatus; ?>
						<label style="margin-left: 10px;" class="Uniform" for="ts_vcsc_extend_settings_license">Envato License Key:</label>
						<input class="<?php
							if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
								echo ((get_site_option('ts_vcsc_extend_settings_licenseValid') == 0) ? "Required" : "");
							} else {
								echo ((get_option('ts_vcsc_extend_settings_licenseValid') == 0) ? "Required" : "");
							}
						?>" type="input" style="width: 20%; height: 30px; margin: 0 10px;" id="ts_vcsc_extend_settings_license" name="ts_vcsc_extend_settings_license" value="<?php echo $ts_vcsc_extend_settings_license; ?>" size="100">
						<?php
							if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
								if (strlen(get_site_option('ts_vcsc_extend_settings_license')) != 0) {
									echo get_site_option('ts_vcsc_extend_settings_licenseInfo');
									if (get_site_option('ts_vcsc_extend_settings_licenseValid') == 0) {
										echo '<div class="ts_vcsc_extend_messi_link clearFixMe" data-title="Retrieve your Envato License Code" data-source="' . TS_VCSC_GetResourceURL('images/envato/envato_find_license_key.png') .'" style="cursor: pointer; margin-left: 10px; margin-top: 10px;">';
											echo '<img style="float: left; border: 1px solid #CCCCCC; margin: 0px auto; max-width: 125px; height: auto;" src="' . TS_VCSC_GetResourceURL('images/envato/envato_find_license_key.png') .'">';
										echo '</div>';
										echo '<div style="margin-left: 10px; margin: 10px 0 20px 10px; width: 100%; float: left;">Click on Image to get Directions to retrieve your Envato License Key.</div>';
									}
								} else {
									echo '<span id="Envato_Key_Missing" style="color: red;">Please enter your Purchase/License Key!</span>';
									echo '<div class="ts_vcsc_extend_messi_link clearFixMe" data-title="Retrieve your Envato License Code" data-source="' . TS_VCSC_GetResourceURL('images/envato/envato_find_license_key.png') .'" style="cursor: pointer; margin-left: 10px; margin-top: 10px;">';
										echo '<img style="float: left; border: 1px solid #CCCCCC; margin: 0px auto; max-width: 125px; height: auto;" src="' . TS_VCSC_GetResourceURL('images/envato/envato_find_license_key.png') .'">';
									echo '</div>';
									echo '<div style="margin-left: 10px; margin: 10px 0 20px 10px; width: 100%; float: left;">Click on Image to get Directions to retrieve your Envato License Key.</div>';
								}
							} else {
								if (strlen(get_option('ts_vcsc_extend_settings_license')) != 0) {
									echo get_option('ts_vcsc_extend_settings_licenseInfo');
									if (get_option('ts_vcsc_extend_settings_licenseValid') == 0) {
										echo '<div class="ts_vcsc_extend_messi_link clearFixMe" data-title="Retrieve your Envato License Code" data-source="' . TS_VCSC_GetResourceURL('images/envato/envato_find_license_key.png') .'" style="cursor: pointer; margin-left: 10px; margin-top: 10px;">';
											echo '<img style="float: left; border: 1px solid #CCCCCC; margin: 0px auto; max-width: 125px; height: auto;" src="' . TS_VCSC_GetResourceURL('images/envato/envato_find_license_key.png') .'">';
										echo '</div>';
										echo '<div style="margin-left: 10px; margin: 10px 0 20px 10px; width: 100%; float: left;">Click on Image to get Directions to retrieve your Envato License Key.</div>';
									}
								} else {
									echo '<span id="Envato_Key_Missing" style="color: red;">Please enter your Purchase/License Key!</span>';
									echo '<div class="ts_vcsc_extend_messi_link clearFixMe" data-title="Retrieve your Envato License Code" data-source="' . TS_VCSC_GetResourceURL('images/envato/envato_find_license_key.png') .'" style="cursor: pointer; margin-left: 10px; margin-top: 10px;">';
										echo '<img style="float: left; border: 1px solid #CCCCCC; margin: 0px auto; max-width: 125px; height: auto;" src="' . TS_VCSC_GetResourceURL('images/envato/envato_find_license_key.png') .'">';
									echo '</div>';
									echo '<div style="margin-left: 10px; margin: 10px 0 20px 10px; width: 100%; float: left;">Click on Image to get Directions to retrieve your Envato License Key.</div>';
								}
							}
						?>
						<div style="height: 20px; display: block;"></div>
					</div>
				</td>
			</tr>
		</table>
		<?php
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
				echo '<div id="ts-settings-summary" style="display: none;" data-extended="' . get_site_option('ts_vcsc_extend_settings_extended', 0) . '" data-summary="' . get_site_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix') . '">' . get_site_option('ts_vcsc_extend_settings_licenseInfo', '') . '</div>';
			} else {
				echo '<div id="ts-settings-summary" style="display: none;" data-extended="' . get_option('ts_vcsc_extend_settings_extended', 0) . '" data-summary="' . get_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix') . '">' . get_option('ts_vcsc_extend_settings_licenseInfo', '') . '</div>';
			}
		?>
	</div>

	<span class="submit">		
		<?php		
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
				if (get_site_option('ts_vcsc_extend_settings_demo', 1) == 0) {
					echo '<input title="Click here to check your Envato License." style="width: 200px; margin-top: 20px;" class="button-primary ButtonSubmit TS_Tooltip" type="submit" name="License" value="Re-Check License" />';
					echo '<input title="Click here to unlicense this installation of Visual Composer Extensions." style="width: 200px; margin-top: 20px; float: right;" class="button-secondary ButtonUnLicense TS_Tooltip" type="submit" name="Unlicense" value="Unlicense Plugin" />';
				} else {
					echo '<input title="Click here to check your Envato License." style="width: 200px; margin-top: 20px;" class="button-primary ButtonSubmit TS_Tooltip" type="submit" name="License" value="Check License" />';
				}
			} else {
				if (get_option('ts_vcsc_extend_settings_demo', 1) == 0) {
					echo '<input title="Click here to check your Envato License." style="width: 200px; margin-top: 20px;" class="button-primary ButtonSubmit TS_Tooltip" type="submit" name="License" value="Re-Check License" />';
					echo '<input title="Click here to unlicense this installation of Visual Composer Extensions." style="width: 200px; margin-top: 20px; float: right;" class="button-secondary ButtonUnLicense TS_Tooltip" type="submit" name="Unlicense" value="Unlicense Plugin" />';
				} else {
					echo '<input title="Click here to check your Envato License." style="width: 200px; margin-top: 20px;" class="button-primary ButtonSubmit TS_Tooltip" type="submit" name="License" value="Check License" />';
				}
			}
		?>
	</span>
</form>
