<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
?>
<div id="ts-settings-files" class="tab-content">
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-download"></i>External Files Settings</div>
		<div class="ts-vcsc-section-content">
			<div class="ts-vcsc-notice-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify; font-weight: bold;">
				Changes to the default settings done in this section can severely impact the overall functionality of this add-on or WordPress itself. Only make changes if you really know what you are doing and if the add-on is not
				working correctly with the default settings!
			</div>	
			<div>
				<h4>Force Load of jQuery:</h4>
				<p style="font-size: 12px; text-align: justify;">Please define if you want to force a load of jQuery and jQuery Migrate:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_loadjQuery == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_loadjQuery" class="toggle-check ts_vcsc_extend_settings_loadjQuery" name="ts_vcsc_extend_settings_loadjQuery" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_loadjQuery); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_loadjQuery == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_loadjQuery == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_loadjQuery">Force Load of jQuery</label>
			</div>			
			<hr class='style-six' style='margin-top: 20px;'>				
			<div>
				<h4>Load ONLY Lightbox Files on ALL Pages:</h4>
				<p style="font-size: 12px; text-align: justify;">Please define if you want to load the lightbox files on ALL pages, even if no shortcode has been detected:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_loadLightbox == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_loadLightbox" class="toggle-check ts_vcsc_extend_settings_loadLightbox" name="ts_vcsc_extend_settings_loadLightbox" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_loadLightbox); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_loadLightbox == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_loadLightbox == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_loadLightbox">Load Lightbox On All Pages</label></span>
			</div>			
			<hr class='style-six' style='margin-top: 20px;'>				
			<div>
				<h4>Load ONLY Tooltip Files on ALL Pages:</h4>
				<p style="font-size: 12px; text-align: justify;">Please define if you want to load the tooltip files on ALL pages, even if no shortcode has been detected:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_loadTooltip == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_loadTooltip" class="toggle-check ts_vcsc_extend_settings_loadTooltip" name="ts_vcsc_extend_settings_loadTooltip" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_loadTooltip); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_loadTooltip == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_loadTooltip == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_loadTooltip">Load Tooltips On All Pages</label>
			</div>			
			<hr class='style-six' style='margin-top: 20px;'>				
			<div>
				<h4>Load ONLY Icon Font Files on ALL Pages:</h4>
				<p style="font-size: 12px; text-align: justify;">Please define if you want to load the active Icon Font files on ALL pages, even if no shortcode has been detected:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_loadFonts == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_loadFonts" class="toggle-check ts_vcsc_extend_settings_loadFonts" name="ts_vcsc_extend_settings_loadFonts" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_loadFonts); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_loadFonts == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_loadFonts == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_loadFonts">Load active Icon Fonts On All Pages</label>
			</div>		
			<hr class='style-six' style='margin-top: 20px;'>				
			<div>
				<h4>Load ALL Core Files on ALL Pages:</h4>
				<p style="font-size: 12px; text-align: justify;">Please define if you want to load ALL of the plugin's core files on ALL pages, even if no shortcode has been detected:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_loadForcable == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_loadForcable" class="toggle-check ts_vcsc_extend_settings_loadForcable" name="ts_vcsc_extend_settings_loadForcable" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_loadForcable); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_loadForcable == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_loadForcable == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_loadForcable">Load ALL Core Files On All Pages</label>
			</div>			
			<hr class='style-six' style='margin-top: 20px;'>		
			<div>
				<h4>Load External Files in HEAD:</h4>
				<p style="font-size: 12px; text-align: justify;">Please define if you want to attempt to load the JS Files in the HEAD section (final control is with WordPress):</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_loadHeader == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_loadHeader" class="toggle-check ts_vcsc_extend_settings_loadHeader" name="ts_vcsc_extend_settings_loadHeader" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_loadHeader); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_loadHeader == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_loadHeader == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_loadHeader">Load all Files in HEAD</label>
			</div>		
			<hr class='style-six' style='margin-top: 20px;'>		
			<div>
				<h4>Load Files via WordPress Standard:</h4>
				<p style="font-size: 12px; text-align: justify;">Please define if you want to load the script files via "wp_enqueue_script" and "wp_enqueue_style":</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_loadEnqueue == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_loadEnqueue" class="toggle-check ts_vcsc_extend_settings_loadEnqueue" name="ts_vcsc_extend_settings_loadEnqueue" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_loadEnqueue); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_loadEnqueue == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_loadEnqueue == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_loadEnqueue">Load Files with Standard Method</label>
			</div>		
			<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 30px; margin-bottom: 30px; font-size: 13px; text-align: justify;">
				This plugin will load some external CSS and JS files in order to make the content elements work on the front end. Your theme or another plugin might already load the same file, which in some cases
				can cause problems. Use this page to enable/disable the files this plugin should be allowed to load on the front end.
			</div>				
			<div>
				<h4>Load Modernizr File:</h4>
				<p style="font-size: 12px; text-align: justify;">Please define if you want to load the Modernizr file to ensure CSS3 compatibility for most browsers:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_loadModernizr == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_loadModernizr" class="toggle-check ts_vcsc_extend_settings_loadModernizr" name="ts_vcsc_extend_settings_loadModernizr" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_loadModernizr); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_loadModernizr == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_loadModernizr == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_loadModernizr">Load Modernizr</label>
			</div>		
			<hr class='style-six' style='margin-top: 20px;'>				
			<div>
				<h4>Load Waypoints File:</h4>
				<p style="font-size: 12px; text-align: justify;">Please define if you want to load the Waypoints File for Viewport Animations:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_loadWaypoints == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_loadWaypoints" class="toggle-check ts_vcsc_extend_settings_loadWaypoints" name="ts_vcsc_extend_settings_loadWaypoints" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_loadWaypoints); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_loadWaypoints == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_loadWaypoints == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_loadWaypoints">Load WayPoints</label>
			</div>			
			<hr class='style-six' style='margin-top: 20px;'>				
			<div style="<?php echo ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_UseEnlighterJS == "true" ? "" : "margin-bottom: 10px;") ?>;">
				<h4>Load CountTo File:</h4>
				<p style="font-size: 12px; text-align: justify;">Please define if you want to load the CountTo File for the Icon Counter:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_loadCountTo == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_loadCountTo" class="toggle-check ts_vcsc_extend_settings_loadCountTo" name="ts_vcsc_extend_settings_loadCountTo" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_loadCountTo); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_loadCountTo == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_loadCountTo == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_loadCountTo">Load CountTo</label>
			</div>
			<hr class='style-six' style='margin-top: 20px; display: <?php echo ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_UseEnlighterJS == "true" ? "block" : "none") ?>;'>				
			<div style="display: <?php echo ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_UseEnlighterJS == "true" ? "block" : "none") ?>; margin-bottom: 10px;">
				<h4>Load MooTools Library:</h4>
				<p style="font-size: 12px; text-align: justify;">Please define if you want to load the MooTools library for the EnlighterJS - Syntax Highlighter elements:</p>
				<div class="ts-switch-button ts-composer-switch" data-value="<?php echo ($ts_vcsc_extend_settings_loadMooTools == 1 ? 'true' : 'false'); ?>" data-width="80" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">
					<input type="checkbox" style="display: none; " id="ts_vcsc_extend_settings_loadMooTools" class="toggle-check ts_vcsc_extend_settings_loadMooTools" name="ts_vcsc_extend_settings_loadMooTools" value="1" <?php echo checked('1', $ts_vcsc_extend_settings_loadMooTools); ?>/>
					<div class="toggle toggle-light" style="width: 80px; height: 20px;">
						<div class="toggle-slide">
							<div class="toggle-inner">
								<div class="toggle-on <?php echo ($ts_vcsc_extend_settings_loadMooTools == 1 ? 'active' : ''); ?>">Yes</div>
								<div class="toggle-blob"></div>
								<div class="toggle-off <?php echo ($ts_vcsc_extend_settings_loadMooTools == 0 ? 'active' : ''); ?>">No</div>
							</div>
						</div>
					</div>
				</div>
				<label class="labelToggleBox" for="ts_vcsc_extend_settings_loadMooTools">Load MooTools Library</label>
			</div>
		</div>
	</div>
</div>