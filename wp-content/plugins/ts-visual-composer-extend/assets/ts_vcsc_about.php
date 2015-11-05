<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
	$memory_recommended							= 20 * 1024 * 1024;
	$memory_required							= 10 * 1024 * 1024;
	$memory_allocated							= ini_get('memory_limit');
	$memory_allocated 							= preg_replace("/[^0-9]/", "", $memory_allocated) * 1024 * 1024;
	$memory_peakusage 							= memory_get_peak_usage(true);
	$memory_remaining							= $memory_allocated - $memory_peakusage;
	$memory_utilization							= $memory_peakusage / $memory_allocated * 100;
	$memory_checkup								= (($memory_remaining < $memory_recommended) ? "false" : "true");
	$memory_minimum								= (($memory_remaining < $memory_required) ? "false" : "true");
?>
<div id="ts-settings-about" class="tab-content">
	<div class="ts-vcsc-settings-group-header">
		<div class="display_header">
			<h2><span class="dashicons dashicons-info"></span>Welcome to "Composium - Visual Composer Extensions" v<?php echo TS_VCSC_GetPluginVersion(); ?></h2>
		</div>
		<div class="clear"></div>
	</div>		
	<div class="ts-vcsc-settings-transfer-main">
		
		<?php
			if (get_option('ts_vcsc_extend_settings_activation', 0) == 1) {
				echo '<div class="ts-vcsc-info-field ts-vcsc-success" style="margin-top: 10px; text-align: justify;">
					<div style="font-size: 16px; font-weight: bold;margin-bottom: 20px;">Hi there! You successfull installed and activated "Composium - Visual Composer Extensions v' . TS_VCSC_GetPluginVersion() . '"!</div>
					<div style="font-size: 13px; font-weight: bold;">We hope you enjoy using this add-on to Visual Composer; our support (for licenses users) is here to help you with any questions or problems
					you might have.</div>
				</div>';
				echo '<div class="ts-vcsc-info-field ts-vcsc-warning" style="margin-top: 10px; margin-bottom: 30px !important; font-size: 13px; text-align: justify; font-weight: bold;">
					<div style="font-size: 13px; font-weight: normal;">The most common problem users experience is a lack of sufficient available PHP server memory, after having installed a premium theme and
					many other plugins prior to this one, using up the allocated memory already. So we included a <a href="#ts-vcsc-welcome-memory">basic memory</a> check below to let you know where your site stands.</div>
					<div style="font-size: 13px; font-weight: normal; margin-top: 20px;">If everything is greenlighted for you there, your next step should be to take some time and go through the extensive
					<a href="' . $VISUAL_COMPOSER_EXTENSIONS->settingsLink . '" target="_parent">setting options</a> for the add-on and to activate the elements and features your are planning
					on using or to deactivate the ones you do not need. Activating only the things you need will dramatically improve performance, which is why we made this add-on modular.</div>
				</div>';
				update_option('ts_vcsc_extend_settings_activation', 0);
			}
		?>
		
		<div id="ts-vcsc-welcome-about" class="ts-vcsc-section-main">
			<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-info"></i>What is "Composium - Visual Composer Extensions"</div>
			<div class="ts-vcsc-section-content">
				<a class="button-secondary" style="width: 200px; margin: 20px auto 10px auto; text-align: center;" href="<?php echo $VISUAL_COMPOSER_EXTENSIONS->settingsLink; ?>" target="_parent"><img src="<?php echo TS_VCSC_GetResourceURL('images/logos/ts_vcsc_menu_icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Back to Plugin Settings</a>
				<div style="width: 100%; display: block; min-height: 72px; margin-bottom: 40px;">
					<img src="<?php echo TS_VCSC_GetResourceURL('images/logos/tekanewa_scripts.png'); ?>" style="width: 200px; height: auto; float: left; margin-right: 20px;">
					<p style="clear: right;">"Composium - Visual Composer Extensions" is exclusively built as an add-on for the popular WordPress page builder plugin "<a target="_blank" href="http://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431">Visual Composer</a>". Among other things, it will add 80+ new premium
					page elements to the page builder, allowing you to create the most awesome and complex page layouts possible. It will also provide you with access to the 16 built-in icon fonts with over 4,600+
					different icons that can be used in a variety of the new elements.<br/><br/>A built-in exclusive lightbox solution, extended row and column options, custom post types, free updates and much more just add to the already
					awesome package this add-on is providing.</p>
				</div>
				<div class="ts-vcsc-image-banner-container" style="max-width: 600px;">
					<div class="ts-vcsc-image-banner-images">
						<img class="" src="<?php echo TS_VCSC_GetResourceURL('images/other/banner_composium.jpg'); ?>" style="width: 100%; height: auto;">
						<img class="" src="<?php echo TS_VCSC_GetResourceURL('images/other/banner_intro.jpg'); ?>" style="width: 100%; height: auto;">
						<img class="" src="<?php echo TS_VCSC_GetResourceURL('images/other/banner_manager.jpg'); ?>" style="width: 100%; height: auto;">
						<img class="" src="<?php echo TS_VCSC_GetResourceURL('images/other/banner_controls.jpg'); ?>" style="width: 100%; height: auto;">			
						<img class="" src="<?php echo TS_VCSC_GetResourceURL('images/other/banner_support.jpg'); ?>" style="width: 100%; height: auto;">
					</div>
				</div>
			</div>
		</div>
		<div id="ts-vcsc-welcome-memory" class="ts-vcsc-section-main">
			<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-<?php echo ($memory_checkup == "true" ? "yes" : "no"); ?>" style="font-weight: bold; color: <?php echo ($memory_checkup == "true" ? "green" : "red"); ?>"></i>Memory Check</div>
			<div class="ts-vcsc-section-content">
				<p style="font-weight: bold;">Using a complex page builder such as "Visual Composer", along with add-ons like this, increases your website's PHP memory requirements. The following is just a quick check to see if your site
				should be able to handle it all:</p>
				<p>Allocated Memory: <?php echo number_format(($memory_allocated / 1024 / 1024), 0); ?>MB</p>
				<p>Already Utilized Memory: <?php echo number_format(($memory_peakusage / 1024 / 1024), 0); ?>MB</p>
				<p>Remaining Memory: <?php echo number_format(($memory_remaining / 1024 / 1024), 0); ?>MB</p>
				<p>Utilization Rate: <?php echo number_format($memory_utilization, 2); ?>%</p>
				<p style="font-size: 10px;">The provided summary is using information returned by your server based on php.ini settings. Depending upon your hosting company and hosting package, your server might
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
			</div>
		</div>	
		<div id="ts-vcsc-welcome-links" class="ts-vcsc-section-main">
			<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-admin-links"></i>Useful Links</div>
			<div class="ts-vcsc-section-content">
				<div style="margin-top: 10px;">
					<div class="" style="display: inline-block; margin: 0 5px 0 0; width: 200px;">
						<a class="ts-vcsc-image-link" style="display: block; width: 100%; margin: 0; text-align: center; text-decoration: none;" href="<?php echo $VISUAL_COMPOSER_EXTENSIONS->settingsLink; ?>" target="_parent">
							<img src="<?php echo TS_VCSC_GetResourceURL('images/other/composium_settings.png'); ?>" style="width: 100%; height: auto; margin-right: 10px;">
						</a>
					</div>
					<div class="" style="display: none; margin: 0 5px 0 0; width: 200px;">
						<a class="ts-vcsc-image-link" style="display: block; width: 100%; margin: 0; text-align: center; text-decoration: none;" href="admin.php?page=TS_VCSC_License" target="_parent">
							<img src="<?php echo TS_VCSC_GetResourceURL('images/other/composium_license.png'); ?>" style="width: 100%; height: auto; margin-right: 10px;">
						</a>
					</div>
					<div class="" style="display: inline-block; margin: 0 5px 0 0; width: 200px;">
						<a class="ts-vcsc-image-link" style="display: block; width: 100%; margin: 0; text-align: center; text-decoration: none;" href="http://tekanewascripts.com/vcextensions/documentation/" target="_blank">
							<img src="<?php echo TS_VCSC_GetResourceURL('images/other/composium_manual.png'); ?>" style="width: 100%; height: auto; margin-right: 10px;">
						</a>
					</div>
					<div class="" style="display: inline-block; margin: 0 5px 0 0; width: 200px;">
						<a class="ts-vcsc-image-link" style="display: block; width: 100%; margin: 0; text-align: center; text-decoration: none;" href="http://helpdesk.tekanewascripts.com/forums/forum/wordpress-plugins/visual-composer-extensions/" target="_blank">
							<img src="<?php echo TS_VCSC_GetResourceURL('images/other/composium_support.png'); ?>" style="width: 100%; height: auto; margin-right: 10px;">
						</a>
					</div>
					<div class="" style="display: inline-block; margin: 0 5px 0 0; width: 200px;">
						<a class="ts-vcsc-image-link" style="display: block; width: 100%; margin: 0; text-align: center; text-decoration: none;" href="http://codecanyon.net/item/visual-composer-extensions/7190695/comments/" target="_blank">
							<img src="<?php echo TS_VCSC_GetResourceURL('images/other/composium_comments.png'); ?>" style="width: 100%; height: auto; margin-right: 10px;">
						</a>
					</div>
					<div class="" style="display: none; margin: 0 5px 0 0; width: 200px;">
						<a class="ts-vcsc-image-link" style="display: block; width: 100%; margin: 0; text-align: center; text-decoration: none;" href="http://helpdesk.tekanewascripts.com/changelog-composium-visual-composer-extensions/" target="_blank">
							<img src="<?php echo TS_VCSC_GetResourceURL('images/other/composium_changelog.png'); ?>" style="width: 100%; height: auto; margin-right: 10px;">
						</a>
					</div>
					<div class="" style="display: inline-block; margin: 0 5px 0 0; width: 200px;">
						<a class="ts-vcsc-image-link" style="display: block; width: 100%; margin: 0; text-align: center; text-decoration: none;" href="https://www.youtube.com/playlist?list=PL2wGH1HeGNkWvn3wwnkWfriX8fm2QmEDk/" target="_blank">
							<img src="<?php echo TS_VCSC_GetResourceURL('images/other/composium_tutorials.png'); ?>" style="width: 100%; height: auto; margin-right: 10px;">
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
