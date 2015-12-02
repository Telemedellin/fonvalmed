<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
	
	if ((isset($_POST['Submit']))) {
		if (isset($_FILES['ts_vcsc_json_settings_import_file'])) {
			if ($_FILES['ts_vcsc_json_settings_import_file']['error'] > 0) {
				TS_VCSC_CustomFontImportMessages('warning', 'The file could not be uploaded. Please try again.');
			} else {
				$file_name 			= $_FILES["ts_vcsc_json_settings_import_file"]["name"];
				$file_source 		= $_FILES["ts_vcsc_json_settings_import_file"]["tmp_name"];
				$file_mime 			= $_FILES["ts_vcsc_json_settings_import_file"]["type"];
				$file_type 			= end((explode(".", $file_name)));
				$file_size 			= $_FILES['ts_vcsc_json_settings_import_file']['size'];
				$name 				= explode(".", $file_name);
				if ((($file_type == "json") || ($file_type == "JSON")) && ($file_size < 500000)) {
					$encode_options = file_get_contents($file_source);
					$encode_options = json_decode($encode_options, true);
					//var_dump($encode_options);
					if ((array_key_exists('settings', $encode_options)) && (array_key_exists('plugin', $encode_options)) && (array_key_exists('version', $encode_options))) {
						if ($encode_options['plugin'] == 'Composium - Visual Composer Extensions') {
							foreach ($encode_options['settings'] as $key => $value) {
								update_option($key, $value);
							}					
							TS_VCSC_CustomFontImportMessages('success', 'All settings for &quot;Composium - Visual Composer Extensions&quot; have been successfully imported and restored.');
						} else {
							TS_VCSC_CustomFontImportMessages('warning', 'The file you are using does not seem to be a valid setting file for &quot;Composium - Visual Composer Extensions&quot. Please try a different file.');
						}
					} else {
						TS_VCSC_CustomFontImportMessages('warning', 'The file you are using does not seem to be a valid setting file for &quot;Composium - Visual Composer Extensions&quot. Please try a different file.');
					}
				} else {
					TS_VCSC_CustomFontImportMessages('warning', 'The file you are trying to upload is not a .json file. Please try again.');
				}
			}
		}
	}
	
	$TS_VCSC_Export_Options 									= array();
	
	// Retrieve Saved or Default Settings
	// ----------------------------------
	$ts_vcsc_extend_settings_tinymceIcon 						= get_option('ts_vcsc_extend_settings_tinymceIcon',					1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_tinymceIcon'] = ($ts_vcsc_extend_settings_tinymceIcon);
	$ts_vcsc_extend_settings_loadForcable						= get_option('ts_vcsc_extend_settings_loadForcable', 				0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_loadForcable'] = ($ts_vcsc_extend_settings_loadForcable);
	$ts_vcsc_extend_settings_loadLightbox						= get_option('ts_vcsc_extend_settings_loadLightbox', 				0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_loadLightbox'] = ($ts_vcsc_extend_settings_loadLightbox);
	$ts_vcsc_extend_settings_loadFonts							= get_option('ts_vcsc_extend_settings_loadFonts', 					0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_loadFonts'] = ($ts_vcsc_extend_settings_loadFonts);
	$ts_vcsc_extend_settings_loadTooltip						= get_option('ts_vcsc_extend_settings_loadTooltip', 				0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_loadTooltip'] = ($ts_vcsc_extend_settings_loadTooltip);
	$ts_vcsc_extend_settings_loadHeader							= get_option('ts_vcsc_extend_settings_loadHeader',					0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_loadHeader'] = ($ts_vcsc_extend_settings_loadHeader);
	$ts_vcsc_extend_settings_loadModernizr						= get_option('ts_vcsc_extend_settings_loadModernizr',				1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_loadModernizr'] = ($ts_vcsc_extend_settings_loadModernizr);
	$ts_vcsc_extend_settings_loadWaypoints						= get_option('ts_vcsc_extend_settings_loadWaypoints',				1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_loadWaypoints'] = ($ts_vcsc_extend_settings_loadWaypoints);
	$ts_vcsc_extend_settings_loadMagnific						= get_option('ts_vcsc_extend_settings_loadMagnific',				1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_loadMagnific'] = ($ts_vcsc_extend_settings_loadMagnific);
	$ts_vcsc_extend_settings_loadjQuery							= get_option('ts_vcsc_extend_settings_loadjQuery',					0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_loadjQuery'] = ($ts_vcsc_extend_settings_loadjQuery);
	$ts_vcsc_extend_settings_loadEnqueue						= get_option('ts_vcsc_extend_settings_loadEnqueue',					1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_loadEnqueue'] = ($ts_vcsc_extend_settings_loadEnqueue);
	$ts_vcsc_extend_settings_loadCountTo						= get_option('ts_vcsc_extend_settings_loadCountTo', 				1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_loadCountTo'] = ($ts_vcsc_extend_settings_loadCountTo);
	$ts_vcsc_extend_settings_loadDetector						= get_option('ts_vcsc_extend_settings_loadDetector', 				1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_loadDetector'] = ($ts_vcsc_extend_settings_loadDetector);
	$ts_vcsc_extend_settings_customWidgets						= get_option('ts_vcsc_extend_settings_customWidgets',				0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_customWidgets'] = ($ts_vcsc_extend_settings_customWidgets);	
	$ts_vcsc_extend_settings_customTeam							= get_option('ts_vcsc_extend_settings_customTeam',					0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_customTeam'] = ($ts_vcsc_extend_settings_customTeam);
	$ts_vcsc_extend_settings_customTestimonial					= get_option('ts_vcsc_extend_settings_customTestimonial',			0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_customTestimonial'] = ($ts_vcsc_extend_settings_customTestimonial);
	$ts_vcsc_extend_settings_customSkillset						= get_option('ts_vcsc_extend_settings_customSkillset',				0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_customSkillset'] = ($ts_vcsc_extend_settings_customSkillset);	
	$ts_vcsc_extend_settings_customTimelines					= get_option('ts_vcsc_extend_settings_customTimelines',				0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_customTimelines'] = ($ts_vcsc_extend_settings_customTimelines);	
	$ts_vcsc_extend_settings_customLogo							= get_option('ts_vcsc_extend_settings_customLogo',					0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_customLogo'] = ($ts_vcsc_extend_settings_customLogo);
	$ts_vcsc_extend_settings_useMenuGenerator					= get_option('ts_vcsc_extend_settings_useMenuGenerator', 			0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_useMenuGenerator'] = ($ts_vcsc_extend_settings_useMenuGenerator);
	$ts_vcsc_extend_settings_useIconGenerator					= get_option('ts_vcsc_extend_settings_useIconGenerator',			0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_useIconGenerator'] = ($ts_vcsc_extend_settings_useIconGenerator);
	$ts_vcsc_extend_settings_useTinyMCEMedia					= get_option('ts_vcsc_extend_settings_useTinyMCEMedia',				1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_useTinyMCEMedia'] = ($ts_vcsc_extend_settings_useTinyMCEMedia);
	$ts_vcsc_extend_settings_dataRestore						= get_option('ts_vcsc_extend_settings_dataRestore', 				0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_dataRestore'] = ($ts_vcsc_extend_settings_dataRestore);
	$ts_vcsc_extend_settings_mainmenu							= get_option('ts_vcsc_extend_settings_mainmenu', 					1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_mainmenu'] = ($ts_vcsc_extend_settings_mainmenu);
	$ts_vcsc_extend_settings_translationsDomain					= get_option('ts_vcsc_extend_settings_translationsDomain', 			1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_translationsDomain'] = ($ts_vcsc_extend_settings_translationsDomain);
	$ts_vcsc_extend_settings_previewImages						= get_option('ts_vcsc_extend_settings_previewImages', 				1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_previewImages'] = ($ts_vcsc_extend_settings_previewImages);
	$ts_vcsc_extend_settings_backendPreview						= get_option('ts_vcsc_extend_settings_backendPreview', 				1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_backendPreview'] = ($ts_vcsc_extend_settings_backendPreview);
	$ts_vcsc_extend_settings_backgroundIndicator				= get_option('ts_vcsc_extend_settings_backgroundIndicator', 		1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_backgroundIndicator'] = ($ts_vcsc_extend_settings_backgroundIndicator);
	$ts_vcsc_extend_settings_visualSelector						= get_option('ts_vcsc_extend_settings_visualSelector', 				1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_visualSelector'] = ($ts_vcsc_extend_settings_visualSelector);	
	$ts_vcsc_extend_settings_nativeSelector						= get_option('ts_vcsc_extend_settings_nativeSelector', 				1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_nativeSelector'] = ($ts_vcsc_extend_settings_nativeSelector);
	$ts_vcsc_extend_settings_nativePaginator					= get_option('ts_vcsc_extend_settings_nativePaginator', 			'200');
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_nativePaginator'] = ($ts_vcsc_extend_settings_nativePaginator);
	$ts_vcsc_extend_settings_dashboard							= get_option('ts_vcsc_extend_settings_dashboard', 					1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_dashboard'] = ($ts_vcsc_extend_settings_dashboard);	
	$ts_vcsc_extend_settings_variablesPriority					= get_option('ts_vcsc_extend_settings_variablesPriority', 			6);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_variablesPriority'] = ($ts_vcsc_extend_settings_variablesPriority);
	$ts_vcsc_extend_settings_frontendEditor						= get_option('ts_vcsc_extend_settings_frontendEditor', 				1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_frontendEditor'] = ($ts_vcsc_extend_settings_frontendEditor);
	$ts_vcsc_extend_settings_builtinLightbox					= get_option('ts_vcsc_extend_settings_builtinLightbox', 			1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_builtinLightbox'] = ($ts_vcsc_extend_settings_builtinLightbox);
	$ts_vcsc_extend_settings_lightboxIntegration				= get_option('ts_vcsc_extend_settings_lightboxIntegration', 		0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_lightboxIntegration'] = ($ts_vcsc_extend_settings_lightboxIntegration);	
	$ts_vcsc_extend_settings_allowGoogleManager					= get_option('ts_vcsc_extend_settings_allowGoogleManager', 			1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_allowGoogleManager'] = ($ts_vcsc_extend_settings_allowGoogleManager);
	$ts_vcsc_extend_settings_allowPageNavigator					= get_option('ts_vcsc_extend_settings_allowPageNavigator', 			0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_allowPageNavigator'] = ($ts_vcsc_extend_settings_allowPageNavigator);
	$ts_vcsc_extend_settings_allowEnlighterJS					= get_option('ts_vcsc_extend_settings_allowEnlighterJS', 			0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_allowEnlighterJS'] = ($ts_vcsc_extend_settings_allowEnlighterJS);
	$ts_vcsc_extend_settings_allowThemeBuilder					= get_option('ts_vcsc_extend_settings_allowThemeBuilder', 			0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_allowThemeBuilder'] = ($ts_vcsc_extend_settings_allowThemeBuilder);
	$ts_vcsc_extend_settings_allowAutoUpdate					= get_option('ts_vcsc_extend_settings_allowAutoUpdate', 			1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_allowAutoUpdate'] = ($ts_vcsc_extend_settings_allowAutoUpdate);
	$ts_vcsc_extend_settings_allowNotification					= get_option('ts_vcsc_extend_settings_allowNotification', 			1);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_allowNotification'] = ($ts_vcsc_extend_settings_allowNotification);

	// Extended Row + Column Settings
	$ts_vcsc_extend_settings_additionsColumns					= get_option('ts_vcsc_extend_settings_additionsColumns',			0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_additionsColumns'] = ($ts_vcsc_extend_settings_additionsColumns);
	$ts_vcsc_extend_settings_additionsSmoothScroll				= get_option('ts_vcsc_extend_settings_additionsSmoothScroll',		0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_additionsSmoothScroll'] = ($ts_vcsc_extend_settings_additionsSmoothScroll);
	$ts_vcsc_extend_settings_additionsRows						= get_option('ts_vcsc_extend_settings_additionsRows',				0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_additionsRows'] = ($ts_vcsc_extend_settings_additionsRows);	
	$ts_vcsc_extend_settings_additionsOffsets					= get_option('ts_vcsc_extend_settings_additionsOffsets',			0);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_additionsOffsets'] = ($ts_vcsc_extend_settings_additionsOffsets);	
	$ts_vcsc_extend_settings_additionsRowEffectsBreak			= get_option('ts_vcsc_extend_settings_additionsRowEffectsBreak',	'600');
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_additionsRowEffectsBreak'] = ($ts_vcsc_extend_settings_additionsRowEffectsBreak);
	$ts_vcsc_extend_settings_rowVisibilityLimits				= get_option('ts_vcsc_extend_settings_rowVisibilityLimits',			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Row_Toggle_Defaults);
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_rowVisibilityLimits'] = ($ts_vcsc_extend_settings_rowVisibilityLimits);	
	
	// VC Extensions Elements Settings
	$TS_VCSC_Extension_Elements 								= get_option('ts_vcsc_extend_settings_StandardElements', 			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements);
	if (!is_array($TS_VCSC_Extension_Elements)) {
		$TS_VCSC_Extension_Elements								= array();
	}
	$TS_VCSC_Extension_Custom									= array();
	foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
		$defaultstatus 	= ($element['default'] == "true" ? 1 : 0);
		$key 			= $element['setting'];
		if (array_key_exists($key, $TS_VCSC_Extension_Elements)) {
			$TS_VCSC_Extension_Custom[$key]						= $TS_VCSC_Extension_Elements[$key];						
		} else {
			$TS_VCSC_Extension_Custom[$key]						= ($element['default'] == "true" ? 1 : 0);
		}
	}
	$TS_VCSC_Extension_Elements									= '';
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_StandardElements'] = ($TS_VCSC_Extension_Custom);
	
	// WooCommerce Settings
	$TS_VCSC_WooCommerce_Elements								= get_option('ts_vcsc_extend_settings_WooCommerceElements', 		$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_WooCommerce_Elements);
	if (!is_array($TS_VCSC_WooCommerce_Elements)) {
		$TS_VCSC_WooCommerce_Elements							= array();
	}
	$TS_VCSC_WooCommerce_Custom									= array();
	foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_WooCommerce_Elements as $ElementName => $element) {
		$defaultstatus 	= ($element['default'] == "true" ? 1 : 0);
		$key 			= $element['setting'];
		if (array_key_exists($key, $TS_VCSC_WooCommerce_Elements)) {
			$TS_VCSC_WooCommerce_Custom[$key]					= $TS_VCSC_WooCommerce_Elements[$key];						
		} else {
			$TS_VCSC_WooCommerce_Custom[$key]					= ($element['default'] == "true" ? 1 : 0);
		}
	}
	$TS_VCSC_WooCommerce_Elements								= '';
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_WooCommerceElements'] = ($TS_VCSC_WooCommerce_Custom);
	
	// bbPress Settings
	$TS_VCSC_bbPress_Elements									= get_option('ts_vcsc_extend_settings_bbPressElements', 			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_bbPress_Elements);
	if (!is_array($TS_VCSC_bbPress_Elements)) {
		$TS_VCSC_bbPress_Elements								= array();
	}
	$TS_VCSC_bbPress_Custom										= array();
	foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_bbPress_Elements as $ElementName => $element) {
		$defaultstatus 	= ($element['default'] == "true" ? 1 : 0);
		$key 			= $element['setting'];
		if (array_key_exists($key, $TS_VCSC_bbPress_Elements)) {
			$TS_VCSC_bbPress_Custom[$key]						= $TS_VCSC_bbPress_Elements[$key];						
		} else {
			$TS_VCSC_bbPress_Custom[$key]						= ($element['default'] == "true" ? 1 : 0);
		}
	}
	$TS_VCSC_bbPress_Elements									= '';
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_bbPressElements'] = ($TS_VCSC_bbPress_Custom);
	
	// Language Settings: Google Map
	$TS_VCSC_Google_Map_Language 								= get_option('ts_vcsc_extend_settings_translationsGoogleMap',		$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults);
    $TS_VCSC_Google_Map_Custom = array(
        'TextCalcShow'                  						=> (isset($TS_VCSC_Google_Map_Language['TextCalcShow']) 			? $TS_VCSC_Google_Map_Language['TextCalcShow'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextCalcShow']),
        'TextCalcHide'                  						=> (isset($TS_VCSC_Google_Map_Language['TextCalcHide']) 			? $TS_VCSC_Google_Map_Language['TextCalcHide'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextCalcHide']),
        'TextDirectionShow'             						=> (isset($TS_VCSC_Google_Map_Language['TextDirectionShow']) 		? $TS_VCSC_Google_Map_Language['TextDirectionShow'] 	: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextDirectionShow']),
        'TextDirectionHide'             						=> (isset($TS_VCSC_Google_Map_Language['TextDirectionHide']) 		? $TS_VCSC_Google_Map_Language['TextDirectionHide'] 	: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextDirectionHide']),
        'TextResetMap'                  						=> (isset($TS_VCSC_Google_Map_Language['TextResetMap']) 			? $TS_VCSC_Google_Map_Language['TextResetMap'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextResetMap']),
        'PrintRouteText' 			    						=> (isset($TS_VCSC_Google_Map_Language['PrintRouteText']) 			? $TS_VCSC_Google_Map_Language['PrintRouteText'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['PrintRouteText']),
        'TextViewOnGoogle'              						=> (isset($TS_VCSC_Google_Map_Language['TextViewOnGoogle']) 		? $TS_VCSC_Google_Map_Language['TextViewOnGoogle'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextViewOnGoogle']),
        'TextButtonCalc'                						=> (isset($TS_VCSC_Google_Map_Language['TextButtonCalc']) 			? $TS_VCSC_Google_Map_Language['TextButtonCalc'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextButtonCalc']),
        'TextSetTarget'                 						=> (isset($TS_VCSC_Google_Map_Language['TextSetTarget']) 			? $TS_VCSC_Google_Map_Language['TextSetTarget'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextSetTarget']),
        'TextGeoLocation'               						=> (isset($TS_VCSC_Google_Map_Language['TextGeoLocation']) 			? $TS_VCSC_Google_Map_Language['TextGeoLocation'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextGeoLocation']),
        'TextTravelMode'                						=> (isset($TS_VCSC_Google_Map_Language['TextTravelMode']) 			? $TS_VCSC_Google_Map_Language['TextTravelMode'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextTravelMode']),
        'TextDriving'                   						=> (isset($TS_VCSC_Google_Map_Language['TextDriving']) 				? $TS_VCSC_Google_Map_Language['TextDriving'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextDriving']),
        'TextWalking'                   						=> (isset($TS_VCSC_Google_Map_Language['TextWalking']) 				? $TS_VCSC_Google_Map_Language['TextWalking'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextWalking']),
        'TextBicy'                      						=> (isset($TS_VCSC_Google_Map_Language['TextBicy']) 				? $TS_VCSC_Google_Map_Language['TextBicy'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextBicy']),
        'TextWP'                        						=> (isset($TS_VCSC_Google_Map_Language['TextWP']) 					? $TS_VCSC_Google_Map_Language['TextWP'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextWP']),
        'TextButtonAdd'                 						=> (isset($TS_VCSC_Google_Map_Language['TextButtonAdd']) 			? $TS_VCSC_Google_Map_Language['TextButtonAdd'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextButtonAdd']),
        'TextDistance'                  						=> (isset($TS_VCSC_Google_Map_Language['TextDistance']) 			? $TS_VCSC_Google_Map_Language['TextDistance']			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextDistance']),
        'TextMapHome'                   						=> (isset($TS_VCSC_Google_Map_Language['TextMapHome']) 				? $TS_VCSC_Google_Map_Language['TextMapHome'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapHome']),
        'TextMapBikes'                  						=> (isset($TS_VCSC_Google_Map_Language['TextMapBikes']) 			? $TS_VCSC_Google_Map_Language['TextMapBikes'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapBikes']),
        'TextMapTraffic'                						=> (isset($TS_VCSC_Google_Map_Language['TextMapTraffic']) 			? $TS_VCSC_Google_Map_Language['TextMapTraffic'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapTraffic']),
        'TextMapSpeedMiles'             						=> (isset($TS_VCSC_Google_Map_Language['TextMapSpeedMiles']) 		? $TS_VCSC_Google_Map_Language['TextMapSpeedMiles'] 	: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapSpeedMiles']),
        'TextMapSpeedKM'                						=> (isset($TS_VCSC_Google_Map_Language['TextMapSpeedKM']) 			? $TS_VCSC_Google_Map_Language['TextMapSpeedKM'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapSpeedKM']),
        'TextMapNoData'                 						=> (isset($TS_VCSC_Google_Map_Language['TextMapNoData']) 			? $TS_VCSC_Google_Map_Language['TextMapNoData'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapNoData']),
        'TextMapMiles'                  						=> (isset($TS_VCSC_Google_Map_Language['TextMapMiles']) 			? $TS_VCSC_Google_Map_Language['TextMapMiles'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapMiles']),
        'TextMapKilometes'              						=> (isset($TS_VCSC_Google_Map_Language['TextMapKilometes']) 		? $TS_VCSC_Google_Map_Language['TextMapKilometes'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapKilometes']),
        'TextMapActivate'               						=> (isset($TS_VCSC_Google_Map_Language['TextMapActivate']) 			? $TS_VCSC_Google_Map_Language['TextMapActivate'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapActivate']),
        'TextMapDeactivate'             						=> (isset($TS_VCSC_Google_Map_Language['TextMapDeactivate']) 		? $TS_VCSC_Google_Map_Language['TextMapDeactivate'] 	: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Google_Map_Language_Defaults['TextMapDeactivate']),
    );
	$TS_VCSC_Google_Map_Language								= '';
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_translationsGoogleMap'] = ($TS_VCSC_Google_Map_Custom);
	
	// Language Settings: Countdown
	$TS_VCSC_Countdown_Language 								= get_option('ts_vcsc_extend_settings_translationsCountdown',		$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults);
	$TS_VCSC_Countdown_Custom = array(
        'DayPlural'                     						=> (isset($TS_VCSC_Countdown_Language['DayPlural']) 				? $TS_VCSC_Countdown_Language['DayPlural'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults['DayPlural']),
        'DaySingular'                   						=> (isset($TS_VCSC_Countdown_Language['DaySingular']) 				? $TS_VCSC_Countdown_Language['DaySingular'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults['DaySingular']),
        'HourPlural'                    						=> (isset($TS_VCSC_Countdown_Language['HourPlural']) 				? $TS_VCSC_Countdown_Language['HourPlural'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults['HourPlural']),
        'HourSingular'                  						=> (isset($TS_VCSC_Countdown_Language['HourSingular']) 				? $TS_VCSC_Countdown_Language['HourSingular'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults['HourSingular']),
        'MinutePlural'                  						=> (isset($TS_VCSC_Countdown_Language['MinutePlural']) 				? $TS_VCSC_Countdown_Language['MinutePlural'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults['MinutePlural']),
        'MinuteSingular'                						=> (isset($TS_VCSC_Countdown_Language['MinuteSingular']) 			? $TS_VCSC_Countdown_Language['MinuteSingular'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults['MinuteSingular']),
        'SecondPlural'                  						=> (isset($TS_VCSC_Countdown_Language['SecondPlural']) 				? $TS_VCSC_Countdown_Language['SecondPlural'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults['SecondPlural']),
        'SecondSingular'                						=> (isset($TS_VCSC_Countdown_Language['SecondSingular']) 			? $TS_VCSC_Countdown_Language['SecondSingular'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Countdown_Language_Defaults['SecondSingular']),
    );
	$TS_VCSC_Countdown_Language									= '';
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_translationsCountdown'] = ($TS_VCSC_Countdown_Custom);
	
	// Language Settings: Image Magnify
	$TS_VCSC_Magnify_Language 									= get_option('ts_vcsc_extend_settings_translationsMagnify',			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults);
	$TS_VCSC_Magnify_Custom = array(
        'ZoomIn'                        						=> (isset($TS_VCSC_Magnify_Language['ZoomIn']) 						? $TS_VCSC_Magnify_Language['ZoomIn'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['ZoomIn']),
        'ZoomOut'                       						=> (isset($TS_VCSC_Magnify_Language['ZoomOut']) 					? $TS_VCSC_Magnify_Language['ZoomOut'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['ZoomOut']),
        'ZoomLevel'                     						=> (isset($TS_VCSC_Magnify_Language['ZoomLevel']) 					? $TS_VCSC_Magnify_Language['ZoomLevel'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['ZoomLevel']),
        'ChangeLevel'                   						=> (isset($TS_VCSC_Magnify_Language['ChangeLevel']) 				? $TS_VCSC_Magnify_Language['ChangeLevel'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['ChangeLevel']),
        'Next'                          						=> (isset($TS_VCSC_Magnify_Language['Next']) 						? $TS_VCSC_Magnify_Language['Next'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['Next']),
        'Previous'                      						=> (isset($TS_VCSC_Magnify_Language['Previous']) 					? $TS_VCSC_Magnify_Language['Previous'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['Previous']),
        'Reset'                         						=> (isset($TS_VCSC_Magnify_Language['Reset']) 						? $TS_VCSC_Magnify_Language['Reset'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['Reset']),
        'Rotate'                        						=> (isset($TS_VCSC_Magnify_Language['Rotate']) 						? $TS_VCSC_Magnify_Language['Rotate'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['Rotate']),
        'Lightbox'                      						=> (isset($TS_VCSC_Magnify_Language['Lightbox']) 					? $TS_VCSC_Magnify_Language['Lightbox'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Magnify_Language_Defaults['Lightbox']),
    );
	$TS_VCSC_Magnify_Language									= '';
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_translationsMagnify'] = ($TS_VCSC_Magnify_Custom);
	
	// Language Settings: Isotope Posts
	$TS_VCSC_Isotope_Posts_Language 							= get_option('ts_vcsc_extend_settings_translationsIsotopePosts',	$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults);
    $TS_VCSC_Isotope_Posts_Custom = array(
        'ButtonFilter'		            						=> (isset($TS_VCSC_Isotope_Posts_Language['ButtonFilter']) 			? $TS_VCSC_Isotope_Posts_Language['ButtonFilter'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['ButtonFilter']),        
        'ButtonLayout'		            						=> (isset($TS_VCSC_Isotope_Posts_Language['ButtonLayout']) 			? $TS_VCSC_Isotope_Posts_Language['ButtonLayout'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['ButtonLayout']),
        'ButtonSort'		            						=> (isset($TS_VCSC_Isotope_Posts_Language['ButtonSort']) 			? $TS_VCSC_Isotope_Posts_Language['ButtonSort'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['ButtonSort']),
        'Date' 				            						=> (isset($TS_VCSC_Isotope_Posts_Language['Date']) 					? $TS_VCSC_Isotope_Posts_Language['Date'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Date']),        
        'Modified' 			            						=> (isset($TS_VCSC_Isotope_Posts_Language['Modified']) 				? $TS_VCSC_Isotope_Posts_Language['Modified'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Modified']),        
        'Title' 			            						=> (isset($TS_VCSC_Isotope_Posts_Language['Title']) 				? $TS_VCSC_Isotope_Posts_Language['Title'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Title']),        
        'Author' 			            						=> (isset($TS_VCSC_Isotope_Posts_Language['Author']) 				? $TS_VCSC_Isotope_Posts_Language['Author'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Author']),        
        'PostID' 			            						=> (isset($TS_VCSC_Isotope_Posts_Language['PostID']) 				? $TS_VCSC_Isotope_Posts_Language['PostID'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['PostID']),        
        'Comments' 			            						=> (isset($TS_VCSC_Isotope_Posts_Language['Comments']) 				? $TS_VCSC_Isotope_Posts_Language['Comments'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Comments']),
        'SeeAll'			            						=> (isset($TS_VCSC_Isotope_Posts_Language['SeeAll']) 				? $TS_VCSC_Isotope_Posts_Language['SeeAll'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['SeeAll']),
        'Timeline' 			            						=> (isset($TS_VCSC_Isotope_Posts_Language['Timeline']) 				? $TS_VCSC_Isotope_Posts_Language['Timeline'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Timeline']),
        'Masonry' 			            						=> (isset($TS_VCSC_Isotope_Posts_Language['Masonry']) 				? $TS_VCSC_Isotope_Posts_Language['Masonry'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Masonry']),
        'FitRows'			            						=> (isset($TS_VCSC_Isotope_Posts_Language['FitRows']) 				? $TS_VCSC_Isotope_Posts_Language['FitRows'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['FitRows']),
        'StraightDown' 		            						=> (isset($TS_VCSC_Isotope_Posts_Language['StraightDown']) 			? $TS_VCSC_Isotope_Posts_Language['StraightDown'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['StraightDown']),
        'WooFilterProducts'             						=> (isset($TS_VCSC_Isotope_Posts_Language['WooFilterProducts']) 	? $TS_VCSC_Isotope_Posts_Language['WooFilterProducts'] 	: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['WooFilterProducts']),
        'WooTitle'                      						=> (isset($TS_VCSC_Isotope_Posts_Language['WooTitle']) 				? $TS_VCSC_Isotope_Posts_Language['WooTitle'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['WooTitle']),
        'WooPrice'                      						=> (isset($TS_VCSC_Isotope_Posts_Language['WooPrice']) 				? $TS_VCSC_Isotope_Posts_Language['WooPrice'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['WooPrice']),
        'WooRating'                     						=> (isset($TS_VCSC_Isotope_Posts_Language['WooRating']) 			? $TS_VCSC_Isotope_Posts_Language['WooRating'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['WooRating']),
        'WooDate'                       						=> (isset($TS_VCSC_Isotope_Posts_Language['WooDate']) 				? $TS_VCSC_Isotope_Posts_Language['WooDate'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['WooDate']),
        'WooModified'                   						=> (isset($TS_VCSC_Isotope_Posts_Language['WooModified']) 			? $TS_VCSC_Isotope_Posts_Language['WooModified'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['WooModified']),
        'Categories'                    						=> (isset($TS_VCSC_Isotope_Posts_Language['Categories']) 			? $TS_VCSC_Isotope_Posts_Language['Categories'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Categories']),
        'Tags'                          						=> (isset($TS_VCSC_Isotope_Posts_Language['Tags']) 					? $TS_VCSC_Isotope_Posts_Language['Tags'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults['Tags']),
    );
	$TS_VCSC_Isotope_Posts_Language								= '';
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_translationsIsotopePosts'] = ($TS_VCSC_Isotope_Posts_Custom);
	
	// Default Settings: Lightbox
	$TS_VCSC_Lightbox_Defaults 									= get_option('ts_vcsc_extend_settings_defaultLightboxSettings',		$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults);
	$TS_VCSC_Lightbox_Custom = array(
        'thumbs'                        						=> 'bottom',
        'thumbsize'                     						=> 50,
        'animation'                     						=> 'random',
        'captions'                      						=> 'data-title',
        'closer'                        						=> ((array_key_exists('closer', $TS_VCSC_Lightbox_Defaults)) 		? $TS_VCSC_Lightbox_Defaults['closer'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['closer']),
        'duration'                      						=> 5000,
        'share'                         						=> ((array_key_exists('share', $TS_VCSC_Lightbox_Defaults)) 		? $TS_VCSC_Lightbox_Defaults['share'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['share']),
        'social' 	                    						=> ((array_key_exists('social', $TS_VCSC_Lightbox_Defaults)) 		? $TS_VCSC_Lightbox_Defaults['social'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['social']),
        'notouch'                       						=> ((array_key_exists('notouch', $TS_VCSC_Lightbox_Defaults)) 		? $TS_VCSC_Lightbox_Defaults['notouch'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['notouch']),
        'bgclose'			            						=> ((array_key_exists('bgclose', $TS_VCSC_Lightbox_Defaults)) 		? $TS_VCSC_Lightbox_Defaults['bgclose'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['bgclose']),
        'nohashes'			            						=> ((array_key_exists('nohashes', $TS_VCSC_Lightbox_Defaults)) 		? $TS_VCSC_Lightbox_Defaults['nohashes'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['nohashes']),
        'keyboard'			            						=> ((array_key_exists('keyboard', $TS_VCSC_Lightbox_Defaults)) 		? $TS_VCSC_Lightbox_Defaults['keyboard'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['keyboard']),
        'fullscreen'		            						=> ((array_key_exists('fullscreen', $TS_VCSC_Lightbox_Defaults)) 	? $TS_VCSC_Lightbox_Defaults['fullscreen'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['fullscreen']),
        'zoom'				            						=> ((array_key_exists('zoom', $TS_VCSC_Lightbox_Defaults)) 			? $TS_VCSC_Lightbox_Defaults['zoom'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['zoom']),
        'fxspeed'			            						=> ((array_key_exists('fxspeed', $TS_VCSC_Lightbox_Defaults)) 		? $TS_VCSC_Lightbox_Defaults['fxspeed']					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['fxspeed']),
        'scheme'			            						=> ((array_key_exists('scheme', $TS_VCSC_Lightbox_Defaults)) 		? $TS_VCSC_Lightbox_Defaults['scheme'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['scheme']),
        'removelight'                   						=> ((array_key_exists('removelight', $TS_VCSC_Lightbox_Defaults)) 	? $TS_VCSC_Lightbox_Defaults['removelight'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['removelight']),
        'customlight'                   						=> ((array_key_exists('customlight', $TS_VCSC_Lightbox_Defaults)) 	? $TS_VCSC_Lightbox_Defaults['customlight'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['customlight']),
        'customcolor'		            						=> ((array_key_exists('customcolor', $TS_VCSC_Lightbox_Defaults)) 	? $TS_VCSC_Lightbox_Defaults['customcolor'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['customcolor']),
        'backlight' 		            						=> ((array_key_exists('backlight', $TS_VCSC_Lightbox_Defaults)) 	? $TS_VCSC_Lightbox_Defaults['backlight'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['backlight']),
        'usecolor' 		                						=> ((array_key_exists('usecolor', $TS_VCSC_Lightbox_Defaults)) 		? $TS_VCSC_Lightbox_Defaults['usecolor'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['usecolor']),
        'background'                       						=> ((array_key_exists('background', $TS_VCSC_Lightbox_Defaults)) 	? $TS_VCSC_Lightbox_Defaults['background'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['background']),
		'repeat'                       							=> ((array_key_exists('repeat', $TS_VCSC_Lightbox_Defaults)) 		? $TS_VCSC_Lightbox_Defaults['repeat'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['repeat']),
		'overlay'                       						=> ((array_key_exists('overlay', $TS_VCSC_Lightbox_Defaults)) 		? $TS_VCSC_Lightbox_Defaults['overlay'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['overlay']),
        'noise'                         						=> ((array_key_exists('noise', $TS_VCSC_Lightbox_Defaults)) 		? $TS_VCSC_Lightbox_Defaults['noise'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['noise']),
        'cors'                          						=> ((array_key_exists('cors', $TS_VCSC_Lightbox_Defaults)) 			? $TS_VCSC_Lightbox_Defaults['cors'] 					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['cors']),
		'tapping'												=> ((array_key_exists('tapping', $TS_VCSC_Lightbox_Defaults)) 		? $TS_VCSC_Lightbox_Defaults['tapping']					: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['tapping']),
		'scrollblock'											=> ((array_key_exists('scrollblock', $TS_VCSC_Lightbox_Defaults)) 	? $TS_VCSC_Lightbox_Defaults['scrollblock']				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Lightbox_Setting_Defaults['scrollblock']),
    );
	$TS_VCSC_Lightbox_Defaults									= '';
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_defaultLightboxSettings'] = ($TS_VCSC_Lightbox_Custom);
	
	// Social Network Settings
	$TS_VCSC_Social_Defaults 									= get_option('ts_vcsc_extend_settings_socialDefaults', $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Social_Networks_Array);
	$TS_VCSC_Social_Custom 										= array();
	foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Social_Networks_Array as $Social_Network => $social) {
		$social_lines = array(
			'network' 											=> $Social_Network,
			'class'												=> $social['class'],
			'icon'												=> $social['icon'],		
			'link'												=> (isset($TS_VCSC_Social_Defaults[$Social_Network]['link']) ? $TS_VCSC_Social_Defaults[$Social_Network]['link'] : ""),
			'order' 											=> (isset($TS_VCSC_Social_Defaults[$Social_Network]['order']) ? $TS_VCSC_Social_Defaults[$Social_Network]['order'] : $social['order']),		
			'original'											=> $social['order']
		);
		$TS_VCSC_Social_Custom[] 								= $social_lines;
	}	
	$TS_VCSC_Social_Defaults									= '';
	TS_VCSC_SortMultiArray($TS_VCSC_Social_Custom, 'order');
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_socialDefaults'] = ($TS_VCSC_Social_Custom);
	
	// Retrieve Setting for each Installed Icon Font
	foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Icon_Font_Settings as $Icon_Font => $iconfont) {
		$default = ($iconfont['default'] == "true" ? 1 : 0);
		${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''}	= get_option('ts_vcsc_extend_settings_tinymce' . $iconfont['setting'],		$default);
		$TS_VCSC_Export_Options['ts_vcsc_extend_settings_tinymce' . $iconfont['setting']] = (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''});
		${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''}		= get_option('ts_vcsc_extend_settings_load' . $iconfont['setting'],			0);
		$TS_VCSC_Export_Options['ts_vcsc_extend_settings_load' . $iconfont['setting']] = (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''});
	}
	
	// Retrieve Setting for each Visual Composer Font
	foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Composer_Font_Settings as $Icon_Font => $iconfont) {
		$default = ($iconfont['default'] == "true" ? 1 : 0);
		${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''}	= get_option('ts_vcsc_extend_settings_tinymce' . $iconfont['setting'],		$default);
		$TS_VCSC_Export_Options['ts_vcsc_extend_settings_tinymce' . $iconfont['setting']] = (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''});
		${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''}		= get_option('ts_vcsc_extend_settings_load' . $iconfont['setting'],			0);
		$TS_VCSC_Export_Options['ts_vcsc_extend_settings_load' . $iconfont['setting']] = (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''});
	}
	
	// Google Fonts Manager
	$TS_VCSC_Google_Defaults 									= get_option('ts_vcsc_extend_settings_fontDefaults', '');
	$TS_VCSC_Export_Options['ts_vcsc_extend_settings_fontDefaults'] = ($TS_VCSC_Google_Defaults);
	
	// Custom CSS Settings
	$TS_VCSC_Custom_CSS 										= get_option('ts_vcsc_extend_custom_css', 	get_option('ts_vcsc_extend_settings_customCSS', ''));
	$TS_VCSC_Export_Options['ts_vcsc_extend_custom_css'] = ($TS_VCSC_Custom_CSS);
	
	// Custom JS Settings
	$TS_VCSC_Custom_JS 											= get_option('ts_vcsc_extend_custom_js', 	get_option('ts_vcsc_extend_settings_customJS', ''));
	$TS_VCSC_Export_Options['ts_vcsc_extend_custom_js'] = ($TS_VCSC_Custom_JS);
	
	// Create Import / Export Array
	$TS_VCSC_JSON_PRETTY_PRINT 	= defined('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : null;
	$TS_VCSC_Export_Options 	= json_encode(array(
		'plugin' 				=> 'Composium - Visual Composer Extensions',
		'version' 				=> TS_VCSC_GetPluginVersion(),
		'date'					=> date('Y-m-d H:i:s'),
		'settings' 				=> $TS_VCSC_Export_Options
	), $TS_VCSC_JSON_PRETTY_PRINT);
	update_option('ts_vcsc_extend_settings_exportSettings', str_replace('<br/>', PHP_EOL, $TS_VCSC_Export_Options));
	//var_dump($TS_VCSC_Export_Options);
?>

<div id="ts-settings-transfers" class="tab-content">
	<form id="ts_vcsc_settings_upload_json_form" enctype="multipart/form-data" action="" method="POST">
		<div class="ts-vcsc-settings-group-header">
			<div class="display_header">
				<h2><span class="dashicons dashicons-migrate"></span>Visual Composer Extensions - Import / Export Settings</h2>
			</div>
			<div class="clear"></div>
		</div>		
		<div class="ts-vcsc-settings-transfer-main">
			<div class="ts-vcsc-section-main">
				<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-desktop"></i>General Information</div>
				<div class="ts-vcsc-section-content">
					<div style="margin-top: 10px;">
						<a class="button-secondary" style="width: 200px; margin: 0 5px 0 0; text-align: center;" href="<?php echo $VISUAL_COMPOSER_EXTENSIONS->settingsLink; ?>" target="_parent"><img src="<?php echo TS_VCSC_GetResourceURL('images/logos/ts_vcsc_menu_icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Back to Plugin Settings</a>
						<a class="button-secondary" style="width: 200px; margin: 0 5px 0 0; text-align: center;" href="http://tekanewascripts.com/vcextensions/documentation/" target="_blank"><img src="<?php echo TS_VCSC_GetResourceURL('images/other/ts_vcsc_manual_icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Manual</a>
						<a class="button-secondary" style="width: 200px; margin: 0 5px 0 0; text-align: center;" href="http://helpdesk.tekanewascripts.com/forums/forum/wordpress-plugins/visual-composer-extensions/" target="_blank"><img src="<?php echo TS_VCSC_GetResourceURL('images/other/ts_vcsc_support_icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Support Forum</a>
						<a class="button-secondary" style="width: 200px; margin: 0 5px 0 0; text-align: center;" href="http://helpdesk.tekanewascripts.com/category/visual-composer-extensions/" target="_blank"><img src="<?php echo TS_VCSC_GetResourceURL('images/other/ts_vcsc_knowledge_icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Knowledge Base</a>
					</div>
					<p>The options below allow you to export your current plugin settings and to import previously exported settings back into the plugin.</p>
					<p>The exported file will be created on the fly as .json file and must not be edited as the plugin requires a specific syntax in order to process an import request.</p>
				</div>
			</div>
			<div class="ts-vcsc-section-main">
				<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-download"></i>Export Settings</div>
				<div class="ts-vcsc-section-content">
					<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">Here you can export the plugin settings in order to import them into another site.</div>
					<?php
						$secret 	= md5(md5(AUTH_KEY . SECURE_AUTH_KEY) . '-' . 'ts-vcsc-extend');
						$link 		= admin_url('admin-ajax.php?action=ts_export_settings&secret=' . $secret );
					?>
					<a href="<?php echo $link; ?>" title="Click here to export settings as JSON file." style="width: 200px; margin-top: 10px; margin-bottom: 20px; text-align: center;" class="button-primary ButtonExport">Export as .JSON File</a>
					<textarea id="ts-vcsc-system-info-textarea" name="ts-vcsc-system-info-textarea" wrap="hard" cols="2" rows="20" style="width: 100%;"><?php echo str_replace('<br/>', PHP_EOL, $TS_VCSC_Export_Options); ?></textarea>
				</div>
			</div>
			<div class="ts-vcsc-section-main">
				<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-upload"></i>Import Settings</div>
				<div class="ts-vcsc-section-content">
					<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">Here you can import plugin settings exported from another site.</div>
						<label for="async-upload" style="font-weight: bold;">Import Plugin Settings from JSON File:</label><br />
						<input type="file" id="ts_vcsc_json_settings_import_file" name="ts_vcsc_json_settings_import_file">
						<?php
							$other_attributes = array( 'id' => 'ts_vcsc_json_settings_import_submit' );
							echo submit_button('Import from .JSON File', 'primary', 'Submit', false, $other_attributes ); 
						?>	
				</div>
			</div>		
		</div>
	</form>
</div>