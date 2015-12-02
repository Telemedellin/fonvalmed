<?php
	global $VISUAL_COMPOSER_EXTENSIONS;

	$Count_Media								= 0;
	$Count_Google								= 0;
	$Count_Buttons								= 0;
	$Count_Counters								= 0;
	$Count_Posts								= 0;
	$Count_Titles								= 0;
	$Count_Popups								= 0;
	$Count_Other								= 0;
	$Count_Beta									= 0;
	$Count_Total								= 0;
	foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
		if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Media')) {
			$Count_Media++;
		} else if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Google')) {
			$Count_Google++;
		} else if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Buttons')) {
			$Count_Buttons++;
		} else if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Counters')) {
			$Count_Counters++;
		} else if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Posts')) {
			$Count_Posts++;
		} else if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Titles')) {
			$Count_Titles++;
		} else if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Popups')) {
			$Count_Popups++;
		} else if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Other')) {
			$Count_Other++;
		} else if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'BETA')) {
			$Count_Beta++;
		}
	}
	$Count_Total								= $Count_Media + $Count_Google + $Count_Buttons + $Count_Counters + $Count_Posts + $Count_Titles + $Count_Popups + $Count_Other + $Count_Beta;
	
	$Count_Deprecated							= TS_VCSC_CountArrayMatches($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements, 'deprecated', 'true');
	$Count_Demos								= TS_VCSC_CountArrayMatches($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements, 'type', 'demos');
	$Count_External								= TS_VCSC_CountArrayMatches($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements, 'type', 'external');
	
	$Count_Fonts								= sizeof($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Fonts_Google);
	
	$MenuPosition_Widgets						= (((is_array($TS_VCSC_Menu_Positions)) && (array_key_exists('ts_widgets', $TS_VCSC_Menu_Positions))) 			? $TS_VCSC_Menu_Positions['ts_widgets'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Menu_Positions_Defaults['ts_widgets']);
	$MenuPosition_Timeline						= (((is_array($TS_VCSC_Menu_Positions)) && (array_key_exists('ts_timeline', $TS_VCSC_Menu_Positions))) 			? $TS_VCSC_Menu_Positions['ts_timeline'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Menu_Positions_Defaults['ts_timeline']);
	$MenuPosition_Team							= (((is_array($TS_VCSC_Menu_Positions)) && (array_key_exists('ts_team', $TS_VCSC_Menu_Positions))) 				? $TS_VCSC_Menu_Positions['ts_team'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Menu_Positions_Defaults['ts_team']);
	$MenuPosition_Testimonials					= (((is_array($TS_VCSC_Menu_Positions)) && (array_key_exists('ts_testimonials', $TS_VCSC_Menu_Positions))) 		? $TS_VCSC_Menu_Positions['ts_testimonials'] 		: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Menu_Positions_Defaults['ts_testimonials']);
	$MenuPosition_Skillsets						= (((is_array($TS_VCSC_Menu_Positions)) && (array_key_exists('ts_skillsets', $TS_VCSC_Menu_Positions))) 		? $TS_VCSC_Menu_Positions['ts_skillsets'] 			: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Menu_Positions_Defaults['ts_skillsets']);
	$MenuPosition_Logos							= (((is_array($TS_VCSC_Menu_Positions)) && (array_key_exists('ts_logos', $TS_VCSC_Menu_Positions))) 			? $TS_VCSC_Menu_Positions['ts_logos'] 				: $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Menu_Positions_Defaults['ts_logos']);

	$memory_recommended							= 20 * 1024 * 1024;
	$memory_required							= 10 * 1024 * 1024;
	$memory_allocated							= ini_get('memory_limit');
	$memory_allocated 							= preg_replace("/[^0-9]/", "", $memory_allocated) * 1024 * 1024;
	$memory_peakusage 							= memory_get_peak_usage(true);
	$memory_remaining							= $memory_allocated - $memory_peakusage;
	$memory_utilization							= $memory_peakusage / $memory_allocated * 100;
	$memory_checkup								= (($memory_remaining < $memory_recommended) ? "false" : "true");
	$memory_minimum								= (($memory_remaining < $memory_required) ? "false" : "true");
	
	if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
		if ((get_site_option('ts_vcsc_extend_settings_demo', 1) == 0) && (get_option('ts_vcsc_extend_settings_extended', 0) == 0) && ((strpos(get_site_option('ts_vcsc_extend_settings_licenseInfo', ''), get_site_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix')) != FALSE))) {
			$autoupdate_allowed					= "true";
		} else {
			$autoupdate_allowed					= "false";
		}
	} else {
		if ((get_option('ts_vcsc_extend_settings_demo', 1) == 0) && (get_option('ts_vcsc_extend_settings_extended', 0) == 0) && ((strpos(get_option('ts_vcsc_extend_settings_licenseInfo', ''), get_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix')) != FALSE))) {
			$autoupdate_allowed					= "true";
		} else {
			$autoupdate_allowed					= "false";
		}
	}
	
	if (TS_VCSC_VersionCompare($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VisualComposer_Version, '4.5.0') >= 0) {
		$visual_composer_link					= 'admin.php?page=vc-general';
	} else {
		$visual_composer_link					= 'options-general.php?page=vc_settings';
	}
?>
<div id="ts-settings-general" class="tab-content">
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-info"></i>General Information</div>
		<div class="ts-vcsc-section-content">
			<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				In order to use this plugin, you MUST have the Visual Composer Plugin installed; either as a normal plugin or as part of your theme. If Visual Composer is part of your theme, please ensure that it has not been modified;
				some theme developers heavily modify Visual Composer in order to allow for certain theme functions. Unfortunately, some of these modification prevent this extension pack from working correctly.
			</div>
			<div style="margin-top: 20px; margin-bottom: 10px;">
				<h4>Visual Composer Extensions</h4>
				<div class="ts-vcsc-notice-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify;">If you are using the "User Groups Access Rules" provided by Visual Composer itself, you MUST enable the new elements in the <a href="<?php echo $visual_composer_link; ?>" target="_parent">settings</a> for the actual Visual Composer Plugin.</div>
				<div style="margin-top: 20px;">
					<a class="button-secondary" style="width: 150px; margin: 0px auto; text-align: center;" href="http://codecanyon.net/item/visual-composer-extensions/7190695" target="_blank"><img src="<?php echo TS_VCSC_GetResourceURL('images/logos/ts_vcsc_menu_icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Buy Plugin</a>
					<a class="button-secondary" style="width: 150px; margin: 0px auto; text-align: center;" href="http://tekanewascripts.com/vcextensions/documentation/" target="_blank"><img src="<?php echo TS_VCSC_GetResourceURL('images/other/ts_vcsc_manual_icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Manual</a>
					<a class="button-secondary" style="width: 150px; margin: 0px auto; text-align: center;" href="http://helpdesk.tekanewascripts.com/forums/forum/wordpress-plugins/visual-composer-extensions/" target="_blank"><img src="<?php echo TS_VCSC_GetResourceURL('images/other/ts_vcsc_support_icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Support Forum</a>
					<a class="button-secondary" style="width: 150px; margin: 0px auto; text-align: center;" href="http://helpdesk.tekanewascripts.com/category/visual-composer-extensions/" target="_blank"><img src="<?php echo TS_VCSC_GetResourceURL('images/other/ts_vcsc_knowledge_icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Knowledge Base</a>
					<a class="button-secondary" style="width: 150px; margin: 0px auto; text-align: center;" href="admin.php?page=TS_VCSC_CSS" target="_parent"><img src="<?php echo TS_VCSC_GetResourceURL('images/other/ts_vcsc_customcss_icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Custom CSS</a>
					<a class="button-secondary" style="width: 150px; margin: 0px auto; text-align: center;" href="admin.php?page=TS_VCSC_JS" target="_parent"><img src="<?php echo TS_VCSC_GetResourceURL('images/other/ts_vcsc_customjs_icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Custom JS</a>
					<?php
						if (get_option('ts_vcsc_extend_settings_extended', 0) == 0) {
							echo '<a class="button-secondary" style="width: 150px; margin: 0px auto; text-align: center;" href="admin.php?page=TS_VCSC_License" target="_parent"><img src="' . TS_VCSC_GetResourceURL('images/other/ts_vcsc_license_icon_16x16.png') . '" style="width: 16px; height: 16px; margin-right: 10px;">License</a>';
						}
					?>
				</div>
			</div>
		</div>		
	</div>
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-admin-generic"></i>Basic Settings</div>
		<div class="ts-vcsc-section-content slideFade" style="display: none;">
			<div style="margin-top: 20px;">
				<h4>Enable Update-Notification:</h4>
				<p style="font-size: 12px;">Define whether you want to use the update notification, where the plugin will create a dashboard page with a notification for an available update and instructions; otherwise, check for available updates <a href="http://helpdesk.tekanewascripts.com/freebies-page/" target="_blank">here</a></p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_allowNotification == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_allowNotification" class="toggle-check ts_vcsc_extend_settings_allowNotification" name="ts_vcsc_extend_settings_allowNotification" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_allowNotification); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_allowNotification == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_allowNotification == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_translationsDomain">Enable Update Notification</label>
			</div>
			<div style="margin-top: 30px; display: <?php echo ($autoupdate_allowed == "true" ? "block" : "none"); ?>;">
				<h4>Enable Auto-Update Feature:</h4>
				<p style="font-size: 12px;">Define whether you want to use the auto-update feature of the plugin, allowing the plugin to be updated through WordPress:</p>
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					If the auto-update procedure fails, it is most likely because your internal WordPress post size and upload limits and or available PHP memory is not sufficient to handle the size of the update file (retrieval,
					extracting, replacing). In that case, you should update the plugin via manual FTP upload, replacing all existing files on your server.
				</div>	
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_allowAutoUpdate == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_allowAutoUpdate" class="toggle-check ts_vcsc_extend_settings_allowAutoUpdate" name="ts_vcsc_extend_settings_allowAutoUpdate" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_allowAutoUpdate); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_allowAutoUpdate == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_allowAutoUpdate == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_allowAutoUpdate">Enable Auto-Update Feature</label>
			</div>
			<div style="margin-top: <?php echo ($autoupdate_allowed == "true" ? "30" : "10"); ?>px;">
				<h4>Placement of Visual Composer Extensions Menu:</h4>
				<p style="font-size: 12px;">Define where the menu for this plugin should be placed in WordPress; if disabled, the main menu will be placed in the 'Settings' section:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_mainmenu == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_mainmenu" class="toggle-check ts_vcsc_extend_settings_mainmenu" name="ts_vcsc_extend_settings_mainmenu" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_mainmenu); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_mainmenu == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_mainmenu == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_mainmenu">Give Visual Composer Extensions its own menu</label>
			</div>		
			<div style="margin-top: 30px;">
				<h4>Use of Language Domain Translations:</h4>
				<p style="font-size: 12px;">Define if the plugin can use its language domain files (stored in the 'locale' folder) in order to automatically be translated into available languages:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_translationsDomain == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_translationsDomain" class="toggle-check ts_vcsc_extend_settings_translationsDomain" name="ts_vcsc_extend_settings_translationsDomain" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_translationsDomain); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_translationsDomain == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_translationsDomain == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_translationsDomain">Use Plugin Language Files</label>
			</div>			
			<div style="margin-top: 30px;">
				<h4>Show Dashboard Panel:</h4>
				<p style="font-size: 12px;">Define if the plugin should show its dashboard panel with basic plugin information:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_dashboard == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_dashboard" class="toggle-check ts_vcsc_extend_settings_dashboard" name="ts_vcsc_extend_settings_dashboard" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_dashboard); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_dashboard == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_dashboard == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_dashboard">Show Dashboard Panel</label>
			</div>			
			<?php
				if (TS_VCSC_CheckUserRole(array('administrator'))) {
					if ((function_exists('vc_enabled_frontend')) && (function_exists('vc_disable_frontend'))) {
						echo '<div style="margin-top: 30px; margin-bottom: 10px;">';
							echo '<h4>Enable Frontend Editor:</h4>';
							echo '<p style="font-size: 12px;">Define if the Frontend-Editor for Visual Composer should be available or not:</p>';
							echo '<div class="ts-vcsc-notice-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify;">';
								echo 'You can disable the Frontend-Editor for Visual Composer by using the option below. <strong>This setting might not work if your theme or another plugin is applying a contradicting setting at
								a later time during the page creation process. </strong>Even with the Frontend-Editor enabled, we always recommend editing pages via the default backend editor as that
								is the way WordPress intends pages to be edited. Due to the complexity of some of our elements, we also can not guaranty full functionality of the Frontend-Editor since that editor is designed
								to handle the basic elements that are native to Visual Composer, but is still not able to fully support more complex elements.';
							echo '</div>';
							echo '<div class="ts-switch-button ts-composer-switch" data-value="' . ($ts_vcsc_extend_settings_frontendEditor == 1 ? 'true' : 'false') . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
								?> <input type="checkbox" style="display: none;" id="ts_vcsc_extend_settings_frontendEditor" class="toggle-check ts_vcsc_extend_settings_frontendEditor" name="ts_vcsc_extend_settings_frontendEditor" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_frontendEditor); ?>/> <?php
								echo '<div class="toggle toggle-light" style="width: 80px; height: 20px;">';
									echo '<div class="toggle-slide">';
										echo '<div class="toggle-inner">';
											echo '<div class="toggle-on ' . ($ts_vcsc_extend_settings_frontendEditor == 1 ? 'active' : '') . '">Yes</div>';
											echo '<div class="toggle-blob"></div>';
											echo '<div class="toggle-off ' . ($ts_vcsc_extend_settings_frontendEditor == 0 ? 'active' : '') . '">No</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
							echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_frontendEditor">Enable Frontend-Editor</label>';
						echo '</div>';
					}
				}
			?>	
			<div style="margin-top: 30px; margin-bottom: 10px;">
				<h4>Show Live Preview in Backend Editor:</h4>
				<p style="font-size: 12px;">Define if the plugin should render a live preview of basic elements when using the backend editor:</p>
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					For some more basic element that don't have any dependencies on JavaScript routines, the plugin can create a live preview of how the element would look like in the frontend while editing in the backend editor.
					Additional attributes like links or CSS3 animations will of course not be shown, just a graphic rendering of the element. Additional stylesheets (CSS) will have to be loaded to define element styling.
				</div>	
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_backendPreview == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_backendPreview" class="toggle-check ts_vcsc_extend_settings_backendPreview" name="ts_vcsc_extend_settings_backendPreview" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_backendPreview); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_backendPreview == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_backendPreview == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_backendPreview">Show Live Preview</label>
			</div>			
			<div style="margin-top: 30px; margin-bottom: 10px;">
				<h4>Show Preview Images in Backend Editor:</h4>
				<p style="font-size: 12px;">Define if the plugin should show preview images for all elements using images, or just the image ID when editing a page in the back-end editor:</p>
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					By default, the plugin will always show a thumbnail preview image for all of its elements that can utilize images. If you have many of those elements on one site, it can slow down loading times while editing on the
					backend as the thumbnail for each image has to be loaded individually via Ajax request. If you prefer, you can therefore disable that preview and you will be provided with the WordPress image ID number instead.
					This setting will not affect the live preview rendering of basic elements as defined above.
				</div>	
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_previewImages == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_previewImages" class="toggle-check ts_vcsc_extend_settings_previewImages" name="ts_vcsc_extend_settings_previewImages" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_previewImages); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_previewImages == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_previewImages == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_previewImages">Show Preview Images</label>
			</div>
			<div style="margin-top: 30px; margin-bottom: 10px;">
				<h4>Use Visual Icon Selector:</h4>
				<p style="font-size: 12px;">Define if the plugin should provide you with a visual icon selector for elements, or if you want to manually enter the icon class name:</p>				
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					While the visual icon selector is more convenient to use as you immediately know how the icon looks like, it might slow down your site if you have too many icons (icon fonts) activated as it takes more time
					to create the visual preview of 1,000+ icons, than it does for 200 icons. In those cases, you can disable the visual icon selector and instead provide your icon of choice by entering its class name.
				</div>	
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_visualSelector == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " data-native="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal; ?>" id="ts_vcsc_extend_settings_visualSelector" class="toggle-check ts_vcsc_extend_settings_visualSelector" name="ts_vcsc_extend_settings_visualSelector" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_visualSelector); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_visualSelector == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_visualSelector == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_visualSelector">Use Visual Icon Selector</label>
			</div>	
			<div id="ts_vcsc_extend_settings_visualSelector_true" data-native="<?php echo $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal; ?>" style="margin-top: 30px; margin-bottom: 10px; margin-left: 25px; display: <?php echo ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") && ($ts_vcsc_extend_settings_visualSelector == 1)) ? "block;" : "none;"); ?>">
				<h4>Use VC Native Icon Selector:</h4>
				<p style="font-size: 12px;">Define if the plugin should use the native icon selector that comes with Visual Composer (v4.4.0+):</p>				
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					This add-on included a visual icon selector from its very first release, while Visual Composer itself didn't have such feature, until the release of v4.4.0. To keep things uniform, this add-on will use the
					native icon selector that is now part of Visual Composer, but you can switch back to the custom version we used before, if you desire to do so.
				</div>	
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_nativeSelector == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_nativeSelector" class="toggle-check ts_vcsc_extend_settings_nativeSelector" name="ts_vcsc_extend_settings_nativeSelector" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_nativeSelector); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_nativeSelector == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_nativeSelector == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_nativeSelector">Use VC Native Icon Selector</label>
			</div>
			<div id="ts_vcsc_extend_settings_nativeSelector_true" class="clearFixMe" style="margin-top: 30px; margin-bottom: 10px; margin-left: 50px; display: <?php echo ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") && ($ts_vcsc_extend_settings_visualSelector == 1) && ($ts_vcsc_extend_settings_nativeSelector == 1)) ? "block;" : "none;"); ?>">
				<h4>Number of Icons per Page:</h4>
				<p style="font-size: 12px;">Define the number of icons that should be shown per page when using the icon picker:</p>
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					The more icons you are showing per page, the slower the icon picker element will initially render, as it takes more time to build a visual preview of 200 icons, than it would for 1,000. The limit set here will
					only apply to the native icon pickers utilized by this add-on; it will not transfer to the same type of icon picker used by Visual Composer itself or other add-ons.
				</div>	
				<div class="ts-nouislider-input-slider">
					<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_nativePaginator" id="ts_vcsc_extend_settings_nativePaginator" class="ts_vcsc_extend_settings_nativePaginator ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="text" value="<?php echo $ts_vcsc_extend_settings_nativePaginator; ?>"/>
					<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">Icons</span>
					<div id="ts_vcsc_extend_settings_nativePaginator_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $ts_vcsc_extend_settings_nativePaginator; ?>" data-min="50" data-max="1000" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
				</div>
			</div>
			<div style="margin-top: 30px; margin-bottom: 10px;" class="clearFixMe">
				<h4>Priority for Output of JS Variables:</h4>
				<p style="font-size: 12px;">Define the priority WordPress should use when outputting plugin settings as JS variables:</p>
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					Some of the plugin settings control how certain JavaScript functions on the frontend work. In order to do so, those settings must be outputted on each page (using the HEAD section of the page), while at the same
					time ensuring that the variables have been generated BEFORE any respective JS function needs it. By default, the plugin will give the variable output a priority of 6, which is the right priority for most websites.
					But if you use a caching plugin for example, the order in which JS files are loaded might be changed, sometimes requiring a different priority for the variable output, which you can change using the option below.
				</div>	
				<div class="ts-nouislider-input-slider">
					<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_variablesPriority" id="ts_vcsc_extend_settings_variablesPriority" class="ts_vcsc_extend_settings_variablesPriority ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="text" value="<?php echo $ts_vcsc_extend_settings_variablesPriority; ?>"/>
					<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit"></span>
					<div id="ts_vcsc_extend_settings_variablesPriority_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $ts_vcsc_extend_settings_variablesPriority; ?>" data-min="1" data-max="999" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
				</div>
			</div>
		</div>		
	</div>
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-shield"></i>Manage Elements</div>
		<div class="ts-vcsc-section-content">
			<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 20px; font-size: 13px; text-align: justify;">
				While you can prevent individual elements from becoming available to certain user groups (using the "User Group Access Rules" in the settings for the original Visual Composer Plugin), the elements are technically still
				loaded in the background. In order to allow for an improved overall site performance, you can completely disable unwanted elements that are part of "Composium - Visual Composer Extensions" here. Once disabled, the element and its
				associated shortcode will not be loaded anymore. <strong>Also, on default, not all elements are activated upon first plugin activation, so please check the list and the select the elements you are planning to use.</strong>
			</div>		
			<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 20px; margin-bottom: 20px; font-size: 13px; text-align: justify;">
				The original Visual Composer Plugin might still require you to enable the elements based on available user roles using the <a href="<?php echo $visual_composer_link; ?>">settings panel</a> for Visual Composer. That settings panel controls
				which users have access to which Visual Composer elements but doesn't stop them from being loaded.
			</div>
			<div class="ts-vcsc-notice-field ts-vcsc-critical" style="margin-top: 20px; margin-bottom: 20px; font-size: 13px; font-weight: bold; text-align: justify;">
				Every additional element (or feature) you activate will increase the memory load this add-on is having on your WordPress site and naturally impact overall Visual Composer performance. Please ensure that your
				server is providing sufficient memory to handle all elements and features you are planning on using!
			</div>			
			<p style="margin: 0;">Allocated Memory: <?php echo number_format(($memory_allocated / 1024 / 1024), 0); ?>MB</p>
			<p style="margin: 0;">Already Utilized Memory: <?php echo number_format(($memory_peakusage / 1024 / 1024), 0); ?>MB</p>
			<p style="margin: 0;">Remaining Memory: <?php echo number_format(($memory_remaining / 1024 / 1024), 0); ?>MB</p>
			<p style="margin: 0;">Utilization Rate: <?php echo number_format($memory_utilization, 2); ?>%</p>
			<p style="font-size: 10px; margin-top: 15px;">The provided summary is using information returned by your server based on php.ini settings. Depending upon your hosting company and hosting package, your server might
			actually provide less memory than requested and shown in the php.ini; please contact your hosting company for more detailed and accurate information.</p>
			<?php
				if ($memory_checkup == "true") {
					echo '<div class="ts-vcsc-info-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify; font-weight: bold;">
						Your site seems to have sufficient PHP memory remaining to use Visual Composer and this add-on without problems. Have in mind that activating additional elements or features of this
						add-on and/or adding new plugins will further increase your memory usage and naturally impact the overall performance of Visual Composer.
					</div>';
				} else {
					echo '<div class="ts-vcsc-info-field ts-vcsc-' . ($memory_minimum == "true" ? "warning" : "critical") . '" style="margin-top: 10px; font-size: 13px; text-align: justify; font-weight: bold;">
						Your site is ' . ($memory_minimum == "true" ? "" : "VERY") . ' close to memory exhaustion. You have only ' . (number_format(($memory_remaining / 1024 / 1024), 0)) . 'MB of memory remaining,
						when in idle mode, which might not be enough once you actually edit a page or post with Visual Composer. In general, it is advised to have around ' . (number_format(($memory_recommended / 1024 / 1024), 0)) , 'MB
						of memory remaining, when idling. Depending upon your theme and other activated plugins, that number might actually be more or less.
					</div>';
				}
			?>
			<div class="clearFixMe" style="margin-top: 30px;">
				<div style="width: 100%; float: left;">
					<h4>Standard Shortcodes</h4>
					<p style="font-size: 12px; text-align: justify;">These are the <?php echo $Count_Total; ?> post type independent elements that are currently fully supported and fully compatible with the current release of Visual Composer.</p>					
					
					<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 20px; margin-bottom: 20px; font-size: 13px; text-align: justify;">
						Other elements are tied to custom post types and are only available if said post types are activated. Use the "Manage Element Custom Post Types" section further below to enable those elements.
					</div>
					
					<div id="ts-vcsc-manage-elements-all-enable" class="button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Total; ?> Element(s)</div>
					<div id="ts-vcsc-manage-elements-all-disable" class="button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Total; ?> Element(s)</div>
					
					<div class="ts-changelog-generator-tabs">
						<ul class="ts-changelog-generator-tab-links">
							<li id="ts-changelog-generator-tab-trigger1" class="active"><a href="#ts-changelog-generator-tab1"><i class="dashicons-format-gallery"></i><span>Media </span><span style="font-size: 12px;">(<?php echo $Count_Media; ?>)</span></a></li>
							<li id="ts-changelog-generator-tab-trigger2"><a href="#ts-changelog-generator-tab2"><i class="dashicons-googleplus"></i><span>Google </span><span style="font-size: 12px;">(<?php echo $Count_Google; ?>)</span></a></li>
							<li id="ts-changelog-generator-tab-trigger3"><a href="#ts-changelog-generator-tab3"><i class="dashicons-admin-links"></i><span>Buttons & Links </span><span style="font-size: 12px;">(<?php echo $Count_Buttons; ?>)</span></a></li>
							<li id="ts-changelog-generator-tab-trigger4"><a href="#ts-changelog-generator-tab4"><i class="dashicons-backup"></i><span>Counters </span><span style="font-size: 12px;">(<?php echo $Count_Counters; ?>)</span></a></li>
							<li id="ts-changelog-generator-tab-trigger5"><a href="#ts-changelog-generator-tab5"><i class="dashicons-format-aside"></i><span>Posts </span><span style="font-size: 12px;">(<?php echo $Count_Posts; ?>)</span></a></li>
							<li id="ts-changelog-generator-tab-trigger6"><a href="#ts-changelog-generator-tab6"><i class="dashicons-megaphone"></i><span>Titles & Teasers </span><span style="font-size: 12px;">(<?php echo $Count_Titles; ?>)</span></a></li>
							<li id="ts-changelog-generator-tab-trigger7"><a href="#ts-changelog-generator-tab7"><i class="dashicons-feedback"></i><span>Popups & Modals </span><span style="font-size: 12px;">(<?php echo $Count_Popups; ?>)</span></a></li>
							<li id="ts-changelog-generator-tab-trigger8"><a href="#ts-changelog-generator-tab8"><i class="dashicons-admin-appearance"></i><span>Various </span><span style="font-size: 12px;">(<?php echo $Count_Other; ?>)</span></a></li>
							<li id="ts-changelog-generator-tab-trigger9"><a href="#ts-changelog-generator-tab9"><i class="dashicons-warning"></i><span>BETA </span><span style="font-size: 12px;">(<?php echo $Count_Beta; ?>)</span></a></li>
						</ul>	 
						<div class="ts-changelog-generator-tab-content">
							<div id="ts-changelog-generator-tab1" class="ts-changelog-generator-tab-single active clearFixMe" data-group="Media" style="padding-top: 10px;">
								<div class="ts-vcsc-manage-elements-group-buttons">									
									<div id="ts-vcsc-manage-elements-media-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Media; ?> Element(s) in Group "Media"</div>
									<div id="ts-vcsc-manage-elements-media-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Media; ?> Element(s) in Group "Media"</div>
								</div>
								<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
									if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Media')) {
										echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
											echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
												echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
												echo '<div class="toggle toggle-light" style="width: 80px; height: 20px;">';
													echo '<div class="toggle-slide">';
														echo '<div class="toggle-inner">';
															echo '<div class="toggle-on ' . ($element['active'] == 'true' ? 'active' : '') . '">Yes</div>';
															echo '<div class="toggle-blob"></div>';
															echo '<div class="toggle-off ' . ($element['active'] == 'false' ? 'active' : '') . '">No</div>';
														echo '</div>';
													echo '</div>';
												echo '</div>';
											echo '</div>';
											echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '"</label>';				
										echo '</div>';
									}
								} ?>
							</div>
							<div id="ts-changelog-generator-tab2" class="ts-changelog-generator-tab-single clearFixMe" data-group="Google" style="padding-top: 10px;">
								<div class="ts-vcsc-manage-elements-group-buttons">									
									<div id="ts-vcsc-manage-elements-google-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Google; ?> Element(s) in Group "Google"</div>
									<div id="ts-vcsc-manage-elements-google-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Google; ?> Element(s) in Group "Google"</div>
								</div>
								<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
									if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Google')) {
										echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
											echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
												echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
												echo '<div class="toggle toggle-light" style="width: 80px; height: 20px;">';
													echo '<div class="toggle-slide">';
														echo '<div class="toggle-inner">';
															echo '<div class="toggle-on ' . ($element['active'] == 'true' ? 'active' : '') . '">Yes</div>';
															echo '<div class="toggle-blob"></div>';
															echo '<div class="toggle-off ' . ($element['active'] == 'false' ? 'active' : '') . '">No</div>';
														echo '</div>';
													echo '</div>';
												echo '</div>';
											echo '</div>';
											echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '"</label>';				
										echo '</div>';
									}
								} ?>
							</div>
							<div id="ts-changelog-generator-tab3" class="ts-changelog-generator-tab-single clearFixMe" data-group="Buttons" style="padding-top: 10px;">
								<div class="ts-vcsc-manage-elements-group-buttons">									
									<div id="ts-vcsc-manage-elements-buttons-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Buttons; ?> Element(s) in Group "Buttons & Links"</div>
									<div id="ts-vcsc-manage-elements-buttons-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Buttons; ?> Element(s) in Group "Buttons & Links"</div>
								</div>
								<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
									if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Buttons')) {
										echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
											echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
												echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
												echo '<div class="toggle toggle-light" style="width: 80px; height: 20px;">';
													echo '<div class="toggle-slide">';
														echo '<div class="toggle-inner">';
															echo '<div class="toggle-on ' . ($element['active'] == 'true' ? 'active' : '') . '">Yes</div>';
															echo '<div class="toggle-blob"></div>';
															echo '<div class="toggle-off ' . ($element['active'] == 'false' ? 'active' : '') . '">No</div>';
														echo '</div>';
													echo '</div>';
												echo '</div>';
											echo '</div>';
											echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '"</label>';				
										echo '</div>';
									}
								} ?>
							</div>
							<div id="ts-changelog-generator-tab4" class="ts-changelog-generator-tab-single clearFixMe" data-group="Counters" style="padding-top: 10px;">
								<div class="ts-vcsc-manage-elements-group-buttons">									
									<div id="ts-vcsc-manage-elements-counters-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Counters; ?> Element(s) in Group "Counters"</div>
									<div id="ts-vcsc-manage-elements-counters-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Counters; ?> Element(s) in Group "Counters"</div>
								</div>
								<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
									if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Counters')) {
										echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
											echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
												echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
												echo '<div class="toggle toggle-light" style="width: 80px; height: 20px;">';
													echo '<div class="toggle-slide">';
														echo '<div class="toggle-inner">';
															echo '<div class="toggle-on ' . ($element['active'] == 'true' ? 'active' : '') . '">Yes</div>';
															echo '<div class="toggle-blob"></div>';
															echo '<div class="toggle-off ' . ($element['active'] == 'false' ? 'active' : '') . '">No</div>';
														echo '</div>';
													echo '</div>';
												echo '</div>';
											echo '</div>';
											echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '"</label>';				
										echo '</div>';
									}
								} ?>
							</div>
							<div id="ts-changelog-generator-tab5" class="ts-changelog-generator-tab-single clearFixMe" data-group="Posts" style="padding-top: 10px;">
								<div class="ts-vcsc-manage-elements-group-buttons">									
									<div id="ts-vcsc-manage-elements-posts-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Posts; ?> Element(s) in Group "Posts"</div>
									<div id="ts-vcsc-manage-elements-posts-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Posts; ?> Element(s) in Group "Posts"</div>
								</div>
								<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
									if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Posts')) {
										echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
											echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
												echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
												echo '<div class="toggle toggle-light" style="width: 80px; height: 20px;">';
													echo '<div class="toggle-slide">';
														echo '<div class="toggle-inner">';
															echo '<div class="toggle-on ' . ($element['active'] == 'true' ? 'active' : '') . '">Yes</div>';
															echo '<div class="toggle-blob"></div>';
															echo '<div class="toggle-off ' . ($element['active'] == 'false' ? 'active' : '') . '">No</div>';
														echo '</div>';
													echo '</div>';
												echo '</div>';
											echo '</div>';
											echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '"</label>';				
										echo '</div>';
									}
								} ?>
							</div>
							<div id="ts-changelog-generator-tab6" class="ts-changelog-generator-tab-single clearFixMe" data-group="Titles" style="padding-top: 10px;">
								<div class="ts-vcsc-manage-elements-group-buttons">									
									<div id="ts-vcsc-manage-elements-titles-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Titles; ?> Element(s) in Group "Titles & Teasers"</div>
									<div id="ts-vcsc-manage-elements-titles-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Titles; ?> Element(s) in Group "Titles & Teasers"</div>
								</div>
								<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
									if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Titles')) {
										echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
											echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
												echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
												echo '<div class="toggle toggle-light" style="width: 80px; height: 20px;">';
													echo '<div class="toggle-slide">';
														echo '<div class="toggle-inner">';
															echo '<div class="toggle-on ' . ($element['active'] == 'true' ? 'active' : '') . '">Yes</div>';
															echo '<div class="toggle-blob"></div>';
															echo '<div class="toggle-off ' . ($element['active'] == 'false' ? 'active' : '') . '">No</div>';
														echo '</div>';
													echo '</div>';
												echo '</div>';
											echo '</div>';
											echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '"</label>';				
										echo '</div>';
									}
								} ?>
							</div>
							<div id="ts-changelog-generator-tab7" class="ts-changelog-generator-tab-single clearFixMe" data-group="Popups" style="padding-top: 10px;">
								<div class="ts-vcsc-manage-elements-group-buttons">									
									<div id="ts-vcsc-manage-elements-popups-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Popups; ?> Element(s) in Group "Popups & Messages"</div>
									<div id="ts-vcsc-manage-elements-popups-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Popups; ?> Element(s) in Group "Popups & Messages"</div>
								</div>
								<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
									if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Popups')) {
										echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
											echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
												echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
												echo '<div class="toggle toggle-light" style="width: 80px; height: 20px;">';
													echo '<div class="toggle-slide">';
														echo '<div class="toggle-inner">';
															echo '<div class="toggle-on ' . ($element['active'] == 'true' ? 'active' : '') . '">Yes</div>';
															echo '<div class="toggle-blob"></div>';
															echo '<div class="toggle-off ' . ($element['active'] == 'false' ? 'active' : '') . '">No</div>';
														echo '</div>';
													echo '</div>';
												echo '</div>';
											echo '</div>';
											echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '"</label>';				
										echo '</div>';
									}
								} ?>
							</div>
							<div id="ts-changelog-generator-tab8" class="ts-changelog-generator-tab-single clearFixMe" data-group="Other" style="padding-top: 10px;">
								<div class="ts-vcsc-manage-elements-group-buttons">									
									<div id="ts-vcsc-manage-elements-other-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Other; ?> Element(s) in Group "Various"</div>
									<div id="ts-vcsc-manage-elements-other-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Other; ?> Element(s) in Group "Various"</div>
								</div>
								<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
									if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'Other')) {
										echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
											echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
												echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
												echo '<div class="toggle toggle-light" style="width: 80px; height: 20px;">';
													echo '<div class="toggle-slide">';
														echo '<div class="toggle-inner">';
															echo '<div class="toggle-on ' . ($element['active'] == 'true' ? 'active' : '') . '">Yes</div>';
															echo '<div class="toggle-blob"></div>';
															echo '<div class="toggle-off ' . ($element['active'] == 'false' ? 'active' : '') . '">No</div>';
														echo '</div>';
													echo '</div>';
												echo '</div>';
											echo '</div>';
											echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '"</label>';				
										echo '</div>';
									}
								} ?>
							</div>
							<div id="ts-changelog-generator-tab9" class="ts-changelog-generator-tab-single clearFixMe" data-group="BETA" style="padding-top: 10px;">
								<div class="ts-vcsc-manage-elements-group-buttons">									
									<div id="ts-vcsc-manage-elements-other-disable" class="ts-vcsc-manage-elements-group-disable button-secondary"><i class="dashicons dashicons-no" style="color: red;"></i>Disable All <?php echo $Count_Beta; ?> Element(s) in Group "BETA"</div>
									<div id="ts-vcsc-manage-elements-other-enable" class="ts-vcsc-manage-elements-group-enable button-secondary"><i class="dashicons dashicons-yes" style="color: green;"></i>Enable All <?php echo $Count_Beta; ?> Element(s) in Group "BETA"</div>
								</div>								
								<div class="ts-vcsc-info-field ts-vcsc-critical" style="margin-top: 0px !important; margin-bottom: 30px !important; font-size: 13px; text-align: justify; float: left;">
									The elements listed in this section are still under development, which means there are still limitations in their usage. Usage of these elements is therefore at your own risk as full
									functionality can not be guaranteed as long as the elements are deemed to be in BETA mode.
								</div>								
								<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
									if (($element['type'] != 'demos') && ($element['deprecated'] == 'false') && ($element['type'] != 'external') && ($element['group'] == 'BETA')) {
										echo '<div style="margin: 0 0 10px 0; width: 30%; float: left; min-width: 360px; margin-right: 3%;">';
											echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
												echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
												echo '<div class="toggle toggle-light" style="width: 80px; height: 20px;">';
													echo '<div class="toggle-slide">';
														echo '<div class="toggle-inner">';
															echo '<div class="toggle-on ' . ($element['active'] == 'true' ? 'active' : '') . '">Yes</div>';
															echo '<div class="toggle-blob"></div>';
															echo '<div class="toggle-off ' . ($element['active'] == 'false' ? 'active' : '') . '">No</div>';
														echo '</div>';
													echo '</div>';
												echo '</div>';
											echo '</div>';
											echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '"</label>';				
										echo '</div>';
									}
								} ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearFixMe" style="margin-top: 20px;">
				<div style="width: 48%; float: left; min-width: 360px; margin-right: 2%;">
					<h4>Deprecated Shortcodes</h4>
					<p style="font-size: 12px; text-align: justify;">These <?php echo $Count_Deprecated; ?> elements have been deprecated in favor of other elements; you should use the new versions instead.</p>
					<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
						if (($element['type'] != 'demos') && ($element['deprecated'] == 'true') && ($element['type'] != 'external')) {
							echo '<div style="margin: 0 0 10px 0;">';
								echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
									echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
									echo '<div class="toggle toggle-light" style="width: 80px; height: 20px;">';
										echo '<div class="toggle-slide">';
											echo '<div class="toggle-inner">';
												echo '<div class="toggle-on ' . ($element['active'] == 'true' ? 'active' : '') . '">Yes</div>';
												echo '<div class="toggle-blob"></div>';
												echo '<div class="toggle-off ' . ($element['active'] == 'false' ? 'active' : '') . '">No</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
								echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '"</label>';	
							echo '</div>';
						}
					} ?>
				</div>
				<div style="width: 48%; float: left; min-width: 360px; margin-left: 2%;">
					<h4>3rd Party Shortcodes</h4>
					<p style="font-size: 12px; text-align: justify;">These <?php echo ($Count_Demos + $Count_External);?> elements require additional (not included) plugins or are just for demo purposes.</p>
					<?php foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
						if (($element['type'] == 'demos') || ($element['type'] == 'external')) {
							echo '<div style="margin: 0 0 10px 0;">';
								echo '<div class="ts-switch-button ts-composer-switch" data-value="' . $element['active'] . '" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
									echo '<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_custom' . $element['setting'] .'" class="toggle-check ts_vcsc_extend_settings_custom' . $element['setting'] . '" name="ts_vcsc_extend_settings_custom' . $element['setting'] . '" value="1" ' . ($element['active'] == "true" ? ' checked="checked"' : '') . '/>';
									echo '<div class="toggle toggle-light" style="width: 80px; height: 20px;">';
										echo '<div class="toggle-slide">';
											echo '<div class="toggle-inner">';
												echo '<div class="toggle-on ' . ($element['active'] == 'true' ? 'active' : '') . '">Yes</div>';
												echo '<div class="toggle-blob"></div>';
												echo '<div class="toggle-off ' . ($element['active'] == 'false' ? 'active' : '') . '">No</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
								echo '<label class="labelToggleBox" for="ts_vcsc_extend_settings_custom' . $element['setting'] . '">Enable "' . $ElementName . '"</label>';	
							echo '</div>';
						}
					} ?>
				</div>
			</div>
		</div>
	</div>
	<?php if (((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_additions', 1) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 0))) { ?>
		<div class="ts-vcsc-section-main">
			<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-schedule"></i>Extended Rows & Columns</div>
			<div class="ts-vcsc-section-content slideFade" style="display: none;">
				<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					Visual Composer Extensions allows you to extend the available options for Row and Column settings, adding features such as viewport animations (row + column) and a variety of background effects (row). If you already use other
					plugins that provide the same or similar options you should decide for either one but not use both at the same time as they can cause contradicting settings. Also, if your theme incorporates Visual Composer by itself, some
					themes already provide you with similar options; in these cases, you should disable the settings below in order to avoid any conflicts.
				</div>		
				<div style="margin-top: 20px; font-weight: bold;">The extended Row and Column Options require a Visual Composer version of 4.1 or higher, in order to function correctly!</div>		
				<div style="margin-top: 20px;">
					<h4>Extend Options for Visual Composer Rows:</h4>
					<p style="font-size: 12px;">Extend Row Options with Background Effects and Viewport Animation Settings:</p>
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_additionsRows == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_additionsRows" class="toggle-check ts_vcsc_extend_settings_additionsRows" name="ts_vcsc_extend_settings_additionsRows" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_additionsRows); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_additionsRows == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_additionsRows == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_additionsRows">Extend Row Options</label>
				</div>				
				<div id="ts_vcsc_extend_settings_additionsRows_true" style="margin-top: 20px; margin-bottom: 10px; margin-left: 25px; <?php echo ($ts_vcsc_extend_settings_additionsRows == 0 ? 'display: none;' : 'display: block;'); ?>">
					<h4>Enable Padding/Margin Options:</h4>
					<p style="font-size: 12px;">When a row background has been applied with the extended row options, a background indicator can be shown next to the row control options:</p>
					<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
						Up until version 4.0.0 of this add-on, the extended row options also included settings to define a top/bottom padding to the row and left/right margins to the background style. Due to the historic names of the setting
						parameters, conflicts with some themes could occur that used the same names for their custom setting options for rows. In order to avoid such problems, the padding and margin options have been disabled by
						default but can easily be re-enabled using the setting below. If you notice any conflicts or layout issues with the option enabled, you should keep it disabled.
					</div>	
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_additionsOffsets == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_additionsOffsets" class="toggle-check ts_vcsc_extend_settings_additionsOffsets" name="ts_vcsc_extend_settings_additionsOffsets" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_additionsOffsets); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_additionsOffsets == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_additionsOffsets == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_additionsRows">Enable Padding/Margin Options</label>	
					<div style="margin-top: 20px;">
						<h4>Show Background Preview Indicator:</h4>
						<p style="font-size: 12px;">When a row background has been applied with the extended row options, a background indicator can be shown next to the row control options:</p>
						<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_backgroundIndicator == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
							<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_backgroundIndicator" class="toggle-check ts_vcsc_extend_settings_backgroundIndicator" name="ts_vcsc_extend_settings_backgroundIndicator" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_backgroundIndicator); ?>/>
							<div class="toggle toggle-light" style="width: 80px; height: 20px;">
								<div class="toggle-slide">
									<div class="toggle-inner">
										<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_backgroundIndicator == 1 ? 'active' : ''); ?>">Yes</div>
										<div class="toggle-blob"></div>
										<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_backgroundIndicator == 0 ? 'active' : ''); ?>">No</div>
									</div>
								</div>
							</div>
						</div>
						<label class="labelToggleBox" for="ts_vcsc_extend_settings_additionsRows">Show Background Indicator</label>
					</div>
					<div style="margin-top: 20px;">
						<h4>Define Breakpoint for Row Backgrounds:</h4>
						<p style="font-size: 12px;">Define the breakpoint (based on row width) to determine if a row background should be used or not:</p>						
						<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
							This plugin provides a variety of background effects that can be applied to rows. Those background effects are automatically removed on mobile devices but you can also define a breakpoint, based on
							row width, that is used on desktop devices to determine when a background effect should be disabled. When a row width falls below the defined breakpoint, the background effect applied to that row will
							be disabled automatically.
						</div>						
						<div class="ts-nouislider-input-slider clearFixMe" style="margin-top: 20px;">
							<h4>Activate Background Effects for Rows larger than:</h4>
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_additionsRowEffectsBreak" id="ts_vcsc_extend_settings_additionsRowEffectsBreak" class="ts_vcsc_extend_settings_additionsRowEffectsBreak ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="text" value="<?php echo $ts_vcsc_extend_settings_additionsRowEffectsBreak; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_additionsRowEffectsBreak_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $ts_vcsc_extend_settings_additionsRowEffectsBreak; ?>" data-min="0" data-max="4096" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
					</div>					
					<div style="margin-top: 20px;">
						<h4>Row Visibility Limits:</h4>
						<p style="font-size: 12px;">Define the minimum screen size limits to be used for the row visibility control settings within the extended row options:</p>						
						<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
							As the row shortcode is actually defined and handled by Visual Composer itself and due to the way Visual Composer allows add-ons to extend row options, it is NOT possible to apply the row visibility
							check server side, but only via JS function (client side).
						</div>						
						<div class="ts-nouislider-input-slider clearFixMe" style="margin-top: 20px;">
							<h4>Large Screen Devices:</h4>
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_rowLimitLarge" id="ts_vcsc_extend_settings_rowLimitLarge" class="ts_vcsc_extend_settings_rowLimitLarge ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="text" value="<?php echo $TS_VCSC_Row_Visibility_Limits['Large Devices']; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_rowLimitLarge_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $TS_VCSC_Row_Visibility_Limits['Large Devices']; ?>" data-min="<?php echo $TS_VCSC_Row_Visibility_Limits['Medium Devices']; ?>" data-max="4096" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
						<div class="ts-nouislider-input-slider clearFixMe" style="margin-top: 20px;">
							<h4>Medium Screen Devices:</h4>
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_rowLimitMedium" id="ts_vcsc_extend_settings_rowLimitMedium" class="ts_vcsc_extend_settings_rowLimitMedium ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="text" value="<?php echo $TS_VCSC_Row_Visibility_Limits['Medium Devices']; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_rowLimitMedium_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $TS_VCSC_Row_Visibility_Limits['Medium Devices']; ?>" data-min="<?php echo $TS_VCSC_Row_Visibility_Limits['Small Devices']; ?>" data-max="<?php echo $TS_VCSC_Row_Visibility_Limits['Large Devices']; ?>" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
						<div class="ts-nouislider-input-slider clearFixMe" style="margin-top: 20px; margin-bottom: 20px;">
							<h4>Small Screen Devices:</h4>
							<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_rowLimitSmall" id="ts_vcsc_extend_settings_rowLimitSmall" class="ts_vcsc_extend_settings_rowLimitSmall ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="text" value="<?php echo $TS_VCSC_Row_Visibility_Limits['Small Devices']; ?>"/>
							<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">px</span>
							<div id="ts_vcsc_extend_settings_rowLimitSmall_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $TS_VCSC_Row_Visibility_Limits['Small Devices']; ?>" data-min="0" data-max="<?php echo $TS_VCSC_Row_Visibility_Limits['Medium Devices']; ?>" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
						</div>
						<h4>Extra Small Screen Devices:</h4>
						<p style="font-size: 12px;">All devices with a screen resolution of less than the minimum resolution defined for "Small Screen Devices" will automatically be treated as "Extra Small Screen Devices".</p>
					</div>
				</div>
				<div style="margin-top: 20px;">
					<h4>Extend Options for Visual Composer Columns:</h4>
					<p style="font-size: 12px;">Extend Column Options with Viewport Animation & Equal Height Settings:</p>
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_additionsColumns == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_additionsColumns" class="toggle-check ts_vcsc_extend_settings_additionsColumns" name="ts_vcsc_extend_settings_additionsColumns" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_additionsColumns); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_additionsColumns == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_additionsColumns == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_additionsColumns">Extend Column Options</label>
				</div>		
				<div style="margin-top: 20px; margin-bottom: 10px;">
					<h4>Smooth Scroll for Pages:</h4>
					<p style="font-size: 12px;">Extend all pages with Smooth Scroll Feature (will not be applied on mobilde devices); do not use if your theme or another plugin is already implementing a smooth scroll feature:</p>
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_additionsSmoothScroll == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_additionsSmoothScroll" class="toggle-check ts_vcsc_extend_settings_additionsSmoothScroll" name="ts_vcsc_extend_settings_additionsSmoothScroll" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_additionsSmoothScroll); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_additionsSmoothScroll == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_additionsSmoothScroll == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_additionsColumns">Extend Pages with Smooth Scroll</label>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesCheckup == "true") {  ?>
		<div class="ts-vcsc-section-main">
			<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-format-aside"></i>Manage Element Custom Post Types</div>
			<div class="ts-vcsc-section-content slideFade" style="display: none;">
				<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 30px; font-size: 13px; text-align: justify;">
					Starting with version 2.0, Visual Composer Extensions introduced custom post types, to be used for some of the elements and for more complex layouts. If your theme or another plugin already provides a similiar post
					type (i.e. a post type for "teams"), you can disable the corresponding custom post type that comes with Visual Composer Extensions. Disabling a custom post type will also disable the corresponding Visual Composer elements
					and shortcodes associated with the post type.
				</div>				
				<?php
					if ((version_compare('1.2.0', $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesClass, '>=')) && ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesInternal == "false")) {
						echo '<div class="ts-vcsc-notice-field ts-vcsc-critical" style="margin-top: 20px; margin-bottom: 20px; font-size: 13px; font-weight: bold; color: red; text-align: justify;">';
							echo 'Another plugin or your theme is loading an OUTDATED version (v' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesClass . ') of the PHP helper class "Custom Metaboxes and Fields", which is
							used to create the custom post types below. Functionality of our custom post types can not be guaranteed with the outdated version your WordPress is currently using.';
						echo '</div>';
					} else if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesInternal == "false") {
						echo '<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 20px; margin-bottom: 20px; font-size: 13px; font-weight: bold; text-align: justify;">';
							echo 'Another plugin or your theme is already loading the PHP helper class "Custom Metaboxes and Fields" (v' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesClass . '), which is
							used to create the custom post types below. Please ensure that the version loaded is not modified or older than v1.2.0 as functionality of our custom post types can otherwise not be guaranteed.';
						echo '</div>';
					}
				?>
				<div style="margin-top: 20px; display: <?php echo (((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypeTimeline', 1) == 0)) ? "none;" : "block;"); ?>">
					<h4>Visual Composer Timeline:</h4>
					<p style="font-size: 12px;">Enable or disable the custom post type "VC Timeline":</p>
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_customTimelines == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_customTimelines" class="toggle-check ts_vcsc_extend_settings_customTimelines" name="ts_vcsc_extend_settings_customTimelines" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_customTimelines); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_customTimelines == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_customTimelines == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_customTimelines">Enable "VC Timeline" Post Type</label>			
				</div>		
				<div style="margin-top: 20px; display: <?php echo (((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypeTeam', 1) == 0)) ? "none;" : "block;"); ?>">
					<h4>Visual Composer Team:</h4>
					<p style="font-size: 12px;">Enable or disable the custom post type "VC Team":</p>
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_customTeam == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_customTeam" class="toggle-check ts_vcsc_extend_settings_customTeam" name="ts_vcsc_extend_settings_customTeam" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_customTeam); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_customTeam == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_customTeam == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_customTeam">Enable "VC Team" Post Type</label>
				</div>
				<div style="margin-top: 20px; display: <?php echo (((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypeTestimonial', 1) == 0)) ? "none;" : "block;"); ?>">
					<h4>Visual Composer Testimonials:</h4>
					<p style="font-size: 12px;">Enable or disable the custom post type "VC Testimonials":</p>
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_customTestimonial == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_customTestimonial" class="toggle-check ts_vcsc_extend_settings_customTestimonial" name="ts_vcsc_extend_settings_customTestimonial" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_customTestimonial); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_customTestimonial == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_customTestimonial == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_customTestimonial">Enable "VC Testimonials" Post Type</label>
				</div>					
				<div style="margin-top: 20px; display: <?php echo (((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypeSkillset', 1) == 0)) ? "none;" : "block;"); ?>">
					<h4>Visual Composer Skillsets:</h4>
					<p style="font-size: 12px;">Enable or disable the custom post type "VC Skillsets":</p>
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_customSkillset == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_customSkillset" class="toggle-check ts_vcsc_extend_settings_customSkillset" name="ts_vcsc_extend_settings_customSkillset" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_customSkillset); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_customSkillset == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_customSkillset == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_customSkillset">Enable "VC Skillsets" Post Type</label>			
				</div>	
				<div style="margin-top: 20px; display: <?php echo (((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypeLogo', 1) == 0)) ? "none;" : "block;"); ?>">
					<h4>Visual Composer Logos:</h4>
					<p style="font-size: 12px;">Enable or disable the custom post type "VC Logos":</p>
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_customLogo == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_customLogo" class="toggle-check ts_vcsc_extend_settings_customLogo" name="ts_vcsc_extend_settings_customLogo" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_customLogo); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_customLogo == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_customLogo == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_customLogo">Enable "VC Logos" Post Type</label>			
				</div>				
				<div style="height: 0px; width: 100%; margin: 0 0 10px 0; padding: 0;"></div>
			</div>
		</div>
	<?php } ?>	
	<?php if (((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypeWidget', 1) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 0))) { ?>
		<div class="ts-vcsc-section-main">
			<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-welcome-widgets-menus"></i>Sidebar Widgets Builder Post Type (BETA)</div>
			<div class="ts-vcsc-section-content slideFade" style="display: none;">
				<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					The custom post type "VC Widgets" will allow you to use any Visual Composer or add-on element when creating its content, which can then be shown in any sidebar via corresponding widget.
					This post type, unlike the ones above, does not have any external dependencies. Any content created with this post type can only be edited with the standard WordPress backend editor and will not be
					available in the Visual Composer frontend editor, once shown in a sidebar, since the frontend editor does not provide access to sidebar content. Whene editing a single "VC Widgets" post type directly,
					the frontend editor will be available, however. In general, this feature is still considered to be in BETA mode!
				</div>
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					Please be aware that Visual Composer itself is NOT designed to be used in a sidebar, as WordPress is treating sidebar and main post/page content differently when rendering a page. As such, certain limitations
					will apply to elements that are used in a sidebar via widget. Please see the usage information in the custom post type "VC Widgets".
				</div>	
				<div style="margin-top: 20px; margin-bottom: 10px;">
					<h4>Visual Composer Widgets:</h4>
					<p style="font-size: 12px;">Enable or disable the custom post type "VC Widgets":</p>
					<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_customWidgets == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
						<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_customWidgets" class="toggle-check ts_vcsc_extend_settings_customWidgets" name="ts_vcsc_extend_settings_customWidgets" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_customWidgets); ?>/>
						<div class="toggle toggle-light" style="width: 80px; height: 20px;">
							<div class="toggle-slide">
								<div class="toggle-inner">
									<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_customWidgets == 1 ? 'active' : ''); ?>">Yes</div>
									<div class="toggle-blob"></div>
									<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_customWidgets == 0 ? 'active' : ''); ?>">No</div>
								</div>
							</div>
						</div>
					</div>
					<label class="labelToggleBox" for="ts_vcsc_extend_settings_customWidgets">Enable "VC Widgets" Post Type</label>			
				</div>
			</div>
		</div>
	<?php } ?>
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-admin-settings"></i>Manage Custom Post Type Menu Positions</div>
		<div class="ts-vcsc-section-content slideFade" style="display: none;">
			<div class="ts-vcsc-notice-field ts-vcsc-critical" style="margin-top: 20px; font-size: 13px; text-align: justify;">
				Provided the associated post types are activated, using the settings above, the plugin will place each custom post type at a pre-determined position in your WordPress admin menu. But if another plugin or your
				theme is claiming the same position for another custom post type, the post type from this plugin might not be visible, as each position can only be used once. In that case, you can use the settings below to
				assign a different position to each custom post type this plugin provides for. <strong>Please ensure, that you assign an unique position to each post type.</strong>
			</div>						
			<div class="ts-nouislider-input-slider clearFixMe" style="margin-top: 20px;">
				<h4>Position: VC Widgets:</h4>
				<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_positionWidgets" id="ts_vcsc_extend_settings_positionWidgets" class="ts_vcsc_extend_settings_positionWidgets ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="1" max="125" step="1" value="<?php echo $MenuPosition_Widgets; ?>"/>
				<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit"></span>
				<div id="ts_vcsc_extend_settings_positionWidgets_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $MenuPosition_Widgets; ?>" data-min="1" data-max="125" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
			</div>
			<div class="ts-nouislider-input-slider clearFixMe" style="margin-top: 20px;">
				<h4>Position: VC Timeline:</h4>
				<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_positionTimeline" id="ts_vcsc_extend_settings_positionTimeline" class="ts_vcsc_extend_settings_positionTimeline ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="1" max="125" step="1" value="<?php echo $MenuPosition_Timeline; ?>"/>
				<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit"></span>
				<div id="ts_vcsc_extend_settings_positionTimeline_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $MenuPosition_Timeline; ?>" data-min="1" data-max="125" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
			</div>
			<div class="ts-nouislider-input-slider clearFixMe" style="margin-top: 20px;">
				<h4>Position: VC Team:</h4>
				<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_positionTeam" id="ts_vcsc_extend_settings_positionTeam" class="ts_vcsc_extend_settings_positionTeam ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="1" max="125" step="1" value="<?php echo $MenuPosition_Team; ?>"/>
				<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit"></span>
				<div id="ts_vcsc_extend_settings_positionTeam_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $MenuPosition_Team; ?>" data-min="1" data-max="125" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
			</div>
			<div class="ts-nouislider-input-slider clearFixMe" style="margin-top: 20px;">
				<h4>Position: VC Testimonials:</h4>
				<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_positionTestimonials" id="ts_vcsc_extend_settings_positionTestimonials" class="ts_vcsc_extend_settings_positionTestimonials ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="1" max="125" step="1" value="<?php echo $MenuPosition_Testimonials; ?>"/>
				<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit"></span>
				<div id="ts_vcsc_extend_settings_positionTestimonials_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $MenuPosition_Testimonials; ?>" data-min="1" data-max="125" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
			</div>
			<div class="ts-nouislider-input-slider clearFixMe" style="margin-top: 20px;">
				<h4>Position: VC Skillsets:</h4>
				<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_positionSkillsets" id="ts_vcsc_extend_settings_positionSkillsets" class="ts_vcsc_extend_settings_positionSkillsets ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="1" max="125" step="1" value="<?php echo $MenuPosition_Skillsets; ?>"/>
				<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit"></span>
				<div id="ts_vcsc_extend_settings_positionSkillsets_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $MenuPosition_Skillsets; ?>" data-min="1" data-max="125" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
			</div>
			<div class="ts-nouislider-input-slider clearFixMe" style="margin-top: 20px;">
				<h4>Position: VC Logos:</h4>
				<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="ts_vcsc_extend_settings_positionLogos" id="ts_vcsc_extend_settings_positionLogos" class="ts_vcsc_extend_settings_positionLogos ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="number" min="1" max="125" step="1" value="<?php echo $MenuPosition_Logos; ?>"/>
				<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit"></span>
				<div id="ts_vcsc_extend_settings_positionLogos_slider" class="ts-nouislider-input ts-nouislider-settings-element" data-value="<?php echo $MenuPosition_Logos; ?>" data-min="1" data-max="125" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>
			</div>
			<div style="height: 0px; width: 100%; margin: 0 0 10px 0; padding: 0;"></div>
		</div>
	</div>
	<div class="ts-vcsc-section-main" style="display: <?php echo ((version_compare(PHP_VERSION, '5.2.0') >= 0) ? "block" : "none"); ?>;">
		<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-googleplus"></i>Google Fonts Manager</div>
		<div class="ts-vcsc-section-content slideFade" style="display: none;">
			<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				Some elements allow you to assign a custom font to titles or content sections of the element. By default, the add-on will give you access to currently <?php echo $Count_Fonts; ?> different Google Fonts. If that is simply too much for you,
				the built-in Google Fonts Manager will allow you to define your custom set of Google Fonts by simply selecting the fonts you want to use, while leaving all other disabled. You can even assign fonts to a "favorite"
				list so that those fonts will always be listed first in the element settings.
			</div>
			<div style="margin-top: 10px; margin-bottom: 10px;">
				<h4>Google Fonts Manager:</h4>
				<p style="font-size: 12px;">Enable or disable the use of the Google Fonts Manager:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_allowGoogleManager == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_allowGoogleManager" class="toggle-check ts_vcsc_extend_settings_allowGoogleManager" name="ts_vcsc_extend_settings_allowGoogleManager" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_allowGoogleManager); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_allowGoogleManager == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_allowGoogleManager == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_allowGoogleManager">Enable Google Fonts Manager</label>
			</div>
		</div>
	</div>	
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-menu"></i>Single Page Navigator Builder</div>
		<div class="ts-vcsc-section-content slideFade" style="display: none;">
			<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				This plugin includes dedicated elements to quickly and easily build navigation bars for a single site, linking rows or any other elements with an ID to a specific menu item, therefore allowing your users to quickly
				navigate a single, but large page. If you do not require such a feature, or your theme or another plugin is already providing a similar one for you, you can disable it here.
			</div>
			<div style="margin-top: 10px; margin-bottom: 10px;">
				<h4>Single Page Navigator Builder:</h4>
				<p style="font-size: 12px;">Enable or disable the use of the Single Page Navigator elements:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_allowPageNavigator == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_allowPageNavigator" class="toggle-check ts_vcsc_extend_settings_allowPageNavigator" name="ts_vcsc_extend_settings_allowPageNavigator" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_allowPageNavigator); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_allowPageNavigator == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_allowPageNavigator == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_allowPageNavigator">Enable Single Page Navigator Builder Elements</label>
			</div>
		</div>
	</div>	
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-editor-code"></i>EnlighterJS - Syntax Highlighter</div>
		<div class="ts-vcsc-section-content slideFade" style="display: none;">
			<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				This plugin includes dedicated elements to quickly and easily highlight code in a variety of programming languages, using multiple available themes. While very useful and important for a variety of uses, it is not
				a feature that every user requires, which is why you can easily enable or disable it, based on your needs.
			</div>
			<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				When enabled and a matching element has been embedded on a page and post, this plugin will load the MooTools library, in addition to the standard jQuery library that WordPress is already loading. Please ensure that
				your theme and other plugins properly enclose and define their jQuery routines in order to prevent any conflicts between both libraries; MooTools will be used in its no-conflict mode.
			</div>
			<div style="margin-top: 10px; margin-bottom: 10px;">
				<h4>EnlighterJS - Syntax Highlighter:</h4>
				<p style="font-size: 12px;">Enable or disable the use of the EnlighterJS - Syntax Highlighter elements:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_allowEnlighterJS == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_allowEnlighterJS" class="toggle-check ts_vcsc_extend_settings_allowEnlighterJS" name="ts_vcsc_extend_settings_allowEnlighterJS" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_allowEnlighterJS); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_allowEnlighterJS == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_allowEnlighterJS == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_allowPageNavigator">Enable EnlighterJS - Syntax Highlighter Elements</label>
			</div>
			<div id="ts_vcsc_extend_settings_allowEnlighterJS_true" style="margin-top: 20px; margin-bottom: 10px; margin-left: 25px; <?php echo ($ts_vcsc_extend_settings_allowEnlighterJS == 0 ? 'display: none;' : 'display: block;'); ?>">
				<h4>Enable Custom Theme Editor:</h4>
				<p style="font-size: 12px;">If the included themes for the syntax highlighter are not enough for you, the optional theme builder allows you to customize the theme styling, based on the default "Enlighter" theme:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_allowThemeBuilder == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_allowThemeBuilder" class="toggle-check ts_vcsc_extend_settings_allowThemeBuilder" name="ts_vcsc_extend_settings_allowThemeBuilder" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_allowThemeBuilder); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_allowThemeBuilder == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_allowThemeBuilder == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_allowThemeBuilder">Enable Custom Theme Builder</label>
			</div>
		</div>
	</div>	
	<?php
	if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
		$license_check = get_site_option('ts_vcsc_extend_settings_demo', 1);
	} else {
		$license_check = get_option('ts_vcsc_extend_settings_demo', 1);
	}
	if (((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_iconicum', 1) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 0) && ($license_check == 0))) {
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconicumStandard == "false") { ?>
			<div class="ts-vcsc-section-main">
				<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-awards"></i>Iconicum - Font Icon Generator</div>
				<div class="ts-vcsc-section-content slideFade" style="display: none;">
					<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
						For licensed users, Visual Composer Extensions includes a bonus plugin "Iconicum - WordPress Icon Fonts". The bonus plugin allows you to use all the font icons that come with Visual Composer Extensions
						outside of the elements that can utilize icons. By using the provided icon generator, you can easily generate icon shortcodes and use those shortcodes anywhere on your site where a standard tinyMCE editor
						field is provided to you.
					</div>					
					<div style="margin-top: 10px; margin-bottom: 20px;">
						<h4>Provide Menu Shortcode Generator for Font Icons:</h4>
						<p style="font-size: 12px;">Adds an icon shortcode generator to the settings menu:</p>
						<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_useMenuGenerator == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
							<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_useMenuGenerator" class="toggle-check ts_vcsc_extend_settings_useMenuGenerator" name="ts_vcsc_extend_settings_useMenuGenerator" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_useMenuGenerator); ?>/>
							<div class="toggle toggle-light" style="width: 80px; height: 20px;">
								<div class="toggle-slide">
									<div class="toggle-inner">
										<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_useMenuGenerator == 1 ? 'active' : ''); ?>">Yes</div>
										<div class="toggle-blob"></div>
										<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_useMenuGenerator == 0 ? 'active' : ''); ?>">No</div>
									</div>
								</div>
							</div>
						</div>
						<label class="labelToggleBox" for="ts_vcsc_extend_settings_useMenuGenerator">Enable Menu Font Icon Generator</label>
					</div>					
					<div style="margin-top: 10px; margin-bottom: 10px;">
						<h4>Provide tinyMCE Shortcode Generator for Font Icons:</h4>
						<p style="font-size: 12px;">Adds a shortcode generator button to any standard tinyMCE editor menu to embed font icons directly into the text editor:</p>
						<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_useIconGenerator == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
							<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_useIconGenerator" class="toggle-check ts_vcsc_extend_settings_useIconGenerator" name="ts_vcsc_extend_settings_useIconGenerator" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_useIconGenerator); ?>/>
							<div class="toggle toggle-light" style="width: 80px; height: 20px;">
								<div class="toggle-slide">
									<div class="toggle-inner">
										<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_useIconGenerator == 1 ? 'active' : ''); ?>">Yes</div>
										<div class="toggle-blob"></div>
										<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_useIconGenerator == 0 ? 'active' : ''); ?>">No</div>
									</div>
								</div>
							</div>
						</div>
						<label class="labelToggleBox" for="ts_vcsc_extend_settings_useIconGenerator">Enable tinyMCE Font Icon Generator</label>
					</div>			
					<div id="ts_vcsc_extend_settings_useIconGenerator_true" style="margin-top: 10px; margin-bottom: 10px; margin-left: 25px; <?php echo ($ts_vcsc_extend_settings_useIconGenerator == 0 ? 'display: none;' : 'display: block;'); ?>">
						<h4>Placement of Shortcode Generator Button:</h4>
						<p style="font-size: 12px;">If the option is disabled, the button will be placed into the tinyMCE menu bar instead:</p>
						<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_useTinyMCEMedia == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
							<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_useTinyMCEMedia" class="toggle-check ts_vcsc_extend_settings_useTinyMCEMedia" name="ts_vcsc_extend_settings_useTinyMCEMedia" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_useTinyMCEMedia); ?>/>
							<div class="toggle toggle-light" style="width: 80px; height: 20px;">
								<div class="toggle-slide">
									<div class="toggle-inner">
										<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_useTinyMCEMedia == 1 ? 'active' : ''); ?>">Yes</div>
										<div class="toggle-blob"></div>
										<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_useTinyMCEMedia == 0 ? 'active' : ''); ?>">No</div>
									</div>
								</div>
							</div>
						</div>
						<label class="labelToggleBox" for="ts_vcsc_extend_settings_useTinyMCEMedia">Place Generator Button next to "Add Media" Button</span></label>
					</div>
				</div>
			</div>
	<?php } else { ?>
		<div class="ts-vcsc-section-main">
			<div class="ts-vcsc-section-title ts-vcsc-section-hide"><i class="dashicons-awards"></i>Iconicum - Font Icon Generator</div>
			<div class="ts-vcsc-section-content slideFade" style="display: none;">
				<div style="margin-top: 10px; margin-bottom: 10px; font-size: 13px; text-align: justify;">
					"Iconicum - WordPress Icon Fonts" is already installed and activated as standalone plugin. Therefore, the version that is included with "Visual Composer Extensions" has been disabled in order to prevent conflicts.
				</div>
			</div>
		</div>
	<?php }} ?>
	<div class="ts-vcsc-section-main" style="display: none;">
		<div class="ts-vcsc-section-title ts-vcsc-section-hide">Other Settings</div>
		<div class="ts-vcsc-section-content slideFade" style="display: none;">
			<div style="margin-top: 10px; margin-bottom: 10px;">
				<h4>Viewing Device Detection:</h4>
				<p style="font-size: 12px;">Enable or disable the use of the Device Detection:</p>
				<input type="hidden" name="ts_vcsc_extend_settings_loadDetector" value="0" />
				<input type="checkbox" name="ts_vcsc_extend_settings_loadDetector" id="ts_vcsc_extend_settings_loadDetector" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_loadDetector); ?> />
				<label class="labelCheckBox" for="ts_vcsc_extend_settings_loadDetector">Use Device Detection</label>
			</div>
		</div>
	</div>
</div>