<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
?>
<div id="ts-settings-iconfont" class="tab-content">
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-index-card"></i>Icon Font Settings</div>
		<div class="ts-vcsc-section-content">
			<p>Here you will find settings that relate to the utilized icon fonts.</p>		
			<div class="ts-vcsc-notice-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				Please be aware that the more icons Visual Composer is handling, the longer the setting panels for elements utilizing said icons will take to load.
			</div>	
			<div style="margin-top: 20px; width: 100%; color: #005DA0; font-size: 13px;">
				<?php
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") {
						$TS_VCSC_TotalIconFontsInstalled = (count($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Installed_Icon_Fonts) + count($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Composer_Icon_Fonts));
					} else {
						$TS_VCSC_TotalIconFontsInstalled = count($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Installed_Icon_Fonts);
					}
					if (get_option('ts_vcsc_extend_settings_tinymceCustomArray', '') != '') {						
						echo '<div>Installed Fonts: ' . $TS_VCSC_TotalIconFontsInstalled . ' / Active Fonts: ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Fonts . '</div>';
					} else {
						echo '<div>Installed Fonts: ' . ($TS_VCSC_TotalIconFontsInstalled - 1) . ' / Active Fonts: ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Fonts . '</div>';
					}
					echo '<div>Installed Icons: ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Total_Icon_Count . ' / Active Icons: ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Count . '</div>';
				?>
			</div>
			<div id="ts_vcsc_extend_settings_tinymceIconFontError" style="display: none;">
				<span id="ts_vcsc_extend_settings_tinymceIconFontCheck">You must select at least one allowable Icon Font!</span>
			</div>
		</div>
	</div>
	<?php if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") { ?>
		<div class="ts-vcsc-section-main">
			<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-vault"></i>Internal Fonts - "Visual Composer v4.4.0+":</div>
			<div class="ts-vcsc-section-content">
				<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					Starting with v4.4.0 of the native Visual Composer plugin, VC started to ship a small set of icon fonts to be used with some of VC's native elements. Some of those icon fonts were already included with
					"Composium - Visual Composer Extensions", such as "Font Awesome Font", "Entypo Font" and "Typicons Font", but using a different class system. If you prefer the icon fonts (and their different class system)
					that are now part of Visual Composer itself, you can enable them here in order to use them with the new elements that are part of "Composium - Visual Composer Extensions".
				</div>
				<div class="ts-vcsc-notice-field ts-vcsc-warning" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					If you are using an icon font that is part of Visual Composer itself, you should deactivate the matching icon font set that is part of "Composium - Visual Composer Extensions" in order to avoid duplications
					and double file loads. For example, you should use either the "Font Awesome" set from Visual Composer OR the matching set from this add-on, but not both at the same time.
				</div>
				<div class="ts-vcsc-notice-field ts-vcsc-critical" style="margin-top: 10px; font-size: 13px; text-align: justify; font-weight: bold;">
					If you used any icons from this add-on prior to Visual Composer releasing v4.4.0 and you now want to use the icon fonts from Visual Composer instead, while deactivating the icon font from this add-on that
					was used before, you will have to reassign the icons to your elements due to the different class name system utilized by Viual Composer and this add-on.
				</div>	
				<div style="margin-top: 20px;" class="ts_vcsc_extend_font_selector_container clearFixMe">
				<?php
					foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Composer_Font_Settings as $Icon_Font => $iconfont) {
						$output = '';
						echo '<div class="ts_vcsc_extend_font_selector ' . $iconfont['type'] . '" data-active="' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? 'true' : 'false') . '" data-icons="' . $iconfont['count'] . '" data-name="' . $iconfont['setting'] . '" data-type="' . $iconfont['type'] . '">';
							echo '<img id="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '_image" data-toggle="ts-switch-toggle-' . $iconfont['setting'] . '" data-load="ts-load-toggle-' . $iconfont['setting'] . '" class="ts_vcsc_check_image' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? " checked" : "") .'" style="" src=' . TS_VCSC_GetResourceURL('images/fonts/font_' . strtolower($iconfont['setting']) . '.jpg') . '>';
							echo '<div class="ts_vcsc_extend_font_summary" style="margin-bottom: 10px;">Created by ' . $iconfont['author'] . '</div>';				
							echo '<div class="ts-switch-button ts-composer-switch" data-value="' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? 'true' : 'false') . '" data-width="60" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
								echo '<input style="display: none; " type="checkbox" data-load="ts_vcsc_extend_settings_load' . $iconfont['setting'] . '" data-image="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '_image" data-check="ts_vcsc_extend_settings_tinymceIconFont" name="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '" id="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '" class="validate[funcCall[checkIconFontSelect]] toggle-check ts_vcsc_extend_settings_font" data-error="Allowable Icon Fonts Selection" data-order="3" value="1" ' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? ' checked="checked"' : '') . ' />';
								echo '<div id="ts-switch-toggle-' . $iconfont['setting'] . '" data-load="ts-load-toggle-' . $iconfont['setting'] . '" data-image="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '_image" class="toggle toggle-light ts-switch-toggle" style="width: 60px; height: 20px;">';
									echo '<div class="toggle-slide">';
										echo '<div class="toggle-inner">';
											echo '<div class="toggle-on ' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? 'active' : '') . '">Yes</div>';
											echo '<div class="toggle-blob"></div>';
											echo '<div class="toggle-off ' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 0 ? 'active' : '') . '">No</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
							echo '<label style="font-weight: bold;" class="labelToggleBox" for="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '">' . $Icon_Font . ' (' . $iconfont['count'] . ' Icons)</label>';
							echo '<span class="ts_tiny_check_load ts_vcsc_extend_settings_load' . $iconfont['setting'] . '_span" style="width: 100%; display: block; margin-top: 5px; margin-bottom: 10px; margin-left: 20px;">';
								echo '<div class="ts-switch-button ts-composer-switch" data-value="' . (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''} == 1 ? 'true' : 'false') . '" data-width="60" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
									echo '<input style="display: none; " type="checkbox" data-font="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '" name="ts_vcsc_extend_settings_load' . $iconfont['setting'] . '" id="ts_vcsc_extend_settings_load' . $iconfont['setting'] . '" class="toggle-check ts_vcsc_extend_settings_load" value="1" ' . (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''} == 1 ? ' checked="checked"' : '') . ' />';
									echo '<div id="ts-load-toggle-' . $iconfont['setting'] . '" data-toggle="ts-switch-toggle-' . $iconfont['setting'] . '" data-image="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '_image" class="toggle toggle-light ts-load-toggle" style="width: 60px; height: 20px;">';
										echo '<div class="toggle-slide">';
											echo '<div class="toggle-inner">';
												echo '<div class="toggle-on ' . (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''} == 1 ? 'active' : '') . '">Yes</div>';
												echo '<div class="toggle-blob"></div>';
												echo '<div class="toggle-off ' . (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''} == 0 ? 'active' : '') . '">No</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
								echo '<label style="font-weight: normal;" class="labelToggleBox" for="ts_vcsc_extend_settings_load' . $iconfont['setting'] . '">Always Load ' . $Icon_Font . '</label>';
							echo '</span>';
						echo '</div>';
					};
				?>
				</div>
			</div>
		</div>
	<?php } ?>
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-vault"></i>Internal Fonts - "Composium - Visual Composer Extensions":</div>
		<div class="ts-vcsc-section-content">
			<div style="margin-top: 20px;" class="ts_vcsc_extend_font_selector_container clearFixMe">
				<?php
					foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Icon_Font_Settings as $Icon_Font => $iconfont) {
						if (($iconfont['setting'] != "Custom") && ($iconfont['setting'] != "Dashicons")) {
							$output = '';
							echo '<div class="ts_vcsc_extend_font_selector ' . $iconfont['type'] . '" data-active="' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? 'true' : 'false') . '" data-icons="' . $iconfont['count'] . '" data-name="' . $iconfont['setting'] . '" data-type="' . $iconfont['type'] . '">';
								echo '<img id="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '_image" data-toggle="ts-switch-toggle-' . $iconfont['setting'] . '" data-load="ts-load-toggle-' . $iconfont['setting'] . '" class="ts_vcsc_check_image' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? " checked" : "") .'" style="" src=' . TS_VCSC_GetResourceURL('images/fonts/font_' . strtolower($iconfont['setting']) . '.jpg') . '>';
								echo '<div class="ts_vcsc_extend_font_summary" style="margin-bottom: 10px;">Created by ' . $iconfont['author'] . '</div>';				
								echo '<div class="ts-switch-button ts-composer-switch" data-value="' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? 'true' : 'false') . '" data-width="60" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
									echo '<input style="display: none; " type="checkbox" data-load="ts_vcsc_extend_settings_load' . $iconfont['setting'] . '" data-image="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '_image" data-check="ts_vcsc_extend_settings_tinymceIconFont" name="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '" id="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '" class="validate[funcCall[checkIconFontSelect]] toggle-check ts_vcsc_extend_settings_font" data-error="Allowable Icon Fonts Selection" data-order="3" value="1" ' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? ' checked="checked"' : '') . ' />';
									echo '<div id="ts-switch-toggle-' . $iconfont['setting'] . '" data-load="ts-load-toggle-' . $iconfont['setting'] . '" data-image="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '_image" class="toggle toggle-light ts-switch-toggle" style="width: 60px; height: 20px;">';
										echo '<div class="toggle-slide">';
											echo '<div class="toggle-inner">';
												echo '<div class="toggle-on ' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? 'active' : '') . '">Yes</div>';
												echo '<div class="toggle-blob"></div>';
												echo '<div class="toggle-off ' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 0 ? 'active' : '') . '">No</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
								echo '<label style="font-weight: bold;" class="labelToggleBox" for="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '">' . $Icon_Font . ' (' . $iconfont['count'] . ' Icons)</label>';
								echo '<span class="ts_tiny_check_load ts_vcsc_extend_settings_load' . $iconfont['setting'] . '_span" style="width: 100%; display: block; margin-top: 5px; margin-bottom: 10px; margin-left: 20px;">';
									echo '<div class="ts-switch-button ts-composer-switch" data-value="' . (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''} == 1 ? 'true' : 'false') . '" data-width="60" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
										echo '<input style="display: none; " type="checkbox" data-font="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '" name="ts_vcsc_extend_settings_load' . $iconfont['setting'] . '" id="ts_vcsc_extend_settings_load' . $iconfont['setting'] . '" class="toggle-check ts_vcsc_extend_settings_load" value="1" ' . (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''} == 1 ? ' checked="checked"' : '') . ' />';
										echo '<div id="ts-load-toggle-' . $iconfont['setting'] . '" data-toggle="ts-switch-toggle-' . $iconfont['setting'] . '" data-image="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '_image" class="toggle toggle-light ts-load-toggle" style="width: 60px; height: 20px;">';
											echo '<div class="toggle-slide">';
												echo '<div class="toggle-inner">';
													echo '<div class="toggle-on ' . (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''} == 1 ? 'active' : '') . '">Yes</div>';
													echo '<div class="toggle-blob"></div>';
													echo '<div class="toggle-off ' . (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''} == 0 ? 'active' : '') . '">No</div>';
												echo '</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';
									echo '<label style="font-weight: normal;" class="labelToggleBox" for="ts_vcsc_extend_settings_load' . $iconfont['setting'] . '">Always Load ' . $Icon_Font . '</label>';
								echo '</span>';
							echo '</div>';
						}
					};
				?>
			</div>
		</div>
	</div>
	<?php if (TS_VCSC_WordPressCheckup('3.8') == "true") { ?>
		<div class="ts-vcsc-section-main">
			<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-wordpress"></i>"Dashicons" - WordPress Icon Font:</div>
			<div class="ts-vcsc-section-content">
				<div style="margin-top: 20px; height: 315px;" class="ts_vcsc_extend_font_selector_container clearFixMe">
				<?php
					foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Icon_Font_Settings as $Icon_Font => $iconfont) {
						if (($iconfont['setting'] != "Custom") && ($iconfont['setting'] == "Dashicons")) {
							$output = '';
							echo '<div class="ts_vcsc_extend_font_selector ' . $iconfont['type'] . '" data-active="' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? 'true' : 'false') . '" data-icons="' . $iconfont['count'] . '" data-name="' . $iconfont['setting'] . '" data-type="' . $iconfont['type'] . '">';
								echo '<img id="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '_image" data-toggle="ts-switch-toggle-' . $iconfont['setting'] . '" data-load="ts-load-toggle-' . $iconfont['setting'] . '" class="ts_vcsc_check_image' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? " checked" : "") .'" style="" src=' . TS_VCSC_GetResourceURL('images/fonts/font_' . strtolower($iconfont['setting']) . '.jpg') . '>';
								echo '<div class="ts_vcsc_extend_font_summary" style="margin-bottom: 10px;">Created by ' . $iconfont['author'] . '</div>';				
								echo '<div class="ts-switch-button ts-composer-switch" data-value="' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? 'true' : 'false') . '" data-width="60" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
									echo '<input style="display: none; " type="checkbox" data-load="ts_vcsc_extend_settings_load' . $iconfont['setting'] . '" data-image="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '_image" data-check="ts_vcsc_extend_settings_tinymceIconFont" name="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '" id="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '" class="validate[funcCall[checkIconFontSelect]] toggle-check ts_vcsc_extend_settings_font" data-error="Allowable Icon Fonts Selection" data-order="3" value="1" ' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? ' checked="checked"' : '') . ' />';
									echo '<div id="ts-switch-toggle-' . $iconfont['setting'] . '" data-load="ts-load-toggle-' . $iconfont['setting'] . '" data-image="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '_image" class="toggle toggle-light ts-switch-toggle" style="width: 60px; height: 20px;">';
										echo '<div class="toggle-slide">';
											echo '<div class="toggle-inner">';
												echo '<div class="toggle-on ' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? 'active' : '') . '">Yes</div>';
												echo '<div class="toggle-blob"></div>';
												echo '<div class="toggle-off ' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 0 ? 'active' : '') . '">No</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
								echo '<label style="font-weight: bold;" class="labelToggleBox" for="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '">' . $Icon_Font . ' (' . $iconfont['count'] . ' Icons)</label>';
								echo '<span class="ts_tiny_check_load ts_vcsc_extend_settings_load' . $iconfont['setting'] . '_span" style="width: 100%; display: block; margin-top: 5px; margin-bottom: 10px; margin-left: 20px;">';
									echo '<div class="ts-switch-button ts-composer-switch" data-value="' . (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''} == 1 ? 'true' : 'false') . '" data-width="60" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
										echo '<input style="display: none; " type="checkbox" data-font="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '" name="ts_vcsc_extend_settings_load' . $iconfont['setting'] . '" id="ts_vcsc_extend_settings_load' . $iconfont['setting'] . '" class="toggle-check ts_vcsc_extend_settings_load" value="1" ' . (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''} == 1 ? ' checked="checked"' : '') . ' />';
										echo '<div id="ts-load-toggle-' . $iconfont['setting'] . '" data-toggle="ts-switch-toggle-' . $iconfont['setting'] . '" data-image="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '_image" class="toggle toggle-light ts-load-toggle" style="width: 60px; height: 20px;">';
											echo '<div class="toggle-slide">';
												echo '<div class="toggle-inner">';
													echo '<div class="toggle-on ' . (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''} == 1 ? 'active' : '') . '">Yes</div>';
													echo '<div class="toggle-blob"></div>';
													echo '<div class="toggle-off ' . (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''} == 0 ? 'active' : '') . '">No</div>';
												echo '</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';
									echo '<label style="font-weight: normal;" class="labelToggleBox" for="ts_vcsc_extend_settings_load' . $iconfont['setting'] . '">Always Load ' . $Icon_Font . '</label>';
								echo '</span>';
							echo '</div>';
						}
					};
				?>
				</div>
			</div>
		</div>
	<?php } ?>
	<div class="ts-vcsc-section-main" style="<?php echo ((get_option('ts_vcsc_extend_settings_tinymceCustomArray', '') != '') ? "" : "display: none;") ?>">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-upload"></i>Custom Uploaded Icon Font:</div>
		<div class="ts-vcsc-section-content">
			<div style="margin-top: 20px; height: 315px;" class="ts_vcsc_extend_font_selector_container clearFixMe">
			<?php
				foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Icon_Font_Settings as $Icon_Font => $iconfont) {
					if ($iconfont['setting'] == "Custom") {
						$output = '';
						if (get_option('ts_vcsc_extend_settings_tinymceCustomArray', '') != '') {
							$output = '';
							echo '<div class="ts_vcsc_extend_font_selector ' . $iconfont['type'] . '" data-active="' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? 'true' : 'false') . '" data-icons="' . $iconfont['count'] . '" data-name="' . $iconfont['setting'] . '" data-type="' . $iconfont['type'] . '">';
								echo '<img id="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '_image" data-toggle="ts-switch-toggle-' . $iconfont['setting'] . '" data-load="ts-load-toggle-' . $iconfont['setting'] . '" class="ts_vcsc_check_image' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? " checked" : "") .'" style="" src=' . TS_VCSC_GetResourceURL('images/fonts/font_' . strtolower($iconfont['setting']) . '.jpg') . '>';
								echo '<div class="ts_vcsc_extend_font_summary" style="margin-bottom: 10px;">Created by ' . get_option('ts_vcsc_extend_settings_tinymceCustomAuthor', 'Custom User') . '</div>';		
								echo '<div class="ts-switch-button ts-composer-switch" data-value="' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? 'true' : 'false') . '" data-width="60" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
									echo '<input style="display: none; " type="checkbox" data-load="ts_vcsc_extend_settings_load' . $iconfont['setting'] . '" data-image="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '_image" data-check="ts_vcsc_extend_settings_tinymceIconFont" name="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '" id="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '" class="validate[funcCall[checkIconFontSelect]] toggle-check ts_vcsc_extend_settings_font" data-error="Allowable Icon Fonts Selection" data-order="3" value="1" ' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? ' checked="checked"' : '') . ' />';
									echo '<div id="ts-switch-toggle-' . $iconfont['setting'] . '" data-load="ts-load-toggle-' . $iconfont['setting'] . '" data-image="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '_image" class="toggle toggle-light ts-switch-toggle" style="width: 60px; height: 20px;">';
										echo '<div class="toggle-slide">';
											echo '<div class="toggle-inner">';
												echo '<div class="toggle-on ' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 1 ? 'active' : '') . '">Yes</div>';
												echo '<div class="toggle-blob"></div>';
												echo '<div class="toggle-off ' . (${'ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . ''} == 0 ? 'active' : '') . '">No</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';				
								echo '<label style="font-weight: bold;" class="labelToggleBox" for="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '">' . get_option('ts_vcsc_extend_settings_tinymceCustomName', 'Custom User Font') . ' (' . $iconfont['count'] . ' Icons)</label>';
								echo '<span class="ts_tiny_check_load ts_vcsc_extend_settings_load' . $iconfont['setting'] . '_span" style="width: 100%; display: block; margin-top: 5px; margin-bottom: 10px; margin-left: 20px;">';
									echo '<div class="ts-switch-button ts-composer-switch" data-value="' . (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''} == 1 ? 'true' : 'false') . '" data-width="60" data-style="compact" data-on="Yes" data-off="No" style="float: left; margin-right: 10px;">';
										echo '<input style="display: none; " type="checkbox" data-font="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '" name="ts_vcsc_extend_settings_load' . $iconfont['setting'] . '" id="ts_vcsc_extend_settings_load' . $iconfont['setting'] . '" class="toggle-check ts_vcsc_extend_settings_load" value="1" ' . (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''} == 1 ? ' checked="checked"' : '') . ' />';
										echo '<div id="ts-load-toggle-' . $iconfont['setting'] . '" data-toggle="ts-switch-toggle-' . $iconfont['setting'] . '" data-image="ts_vcsc_extend_settings_tinymce' . $iconfont['setting'] . '_image" class="toggle toggle-light ts-load-toggle" style="width: 60px; height: 20px;">';
											echo '<div class="toggle-slide">';
												echo '<div class="toggle-inner">';
													echo '<div class="toggle-on ' . (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''} == 1 ? 'active' : '') . '">Yes</div>';
													echo '<div class="toggle-blob"></div>';
													echo '<div class="toggle-off ' . (${'ts_vcsc_extend_settings_load' . $iconfont['setting'] . ''} == 0 ? 'active' : '') . '">No</div>';
												echo '</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';
									echo '<label style="font-weight: normal;" class="labelToggleBox" for="ts_vcsc_extend_settings_load' . $iconfont['setting'] . '">Always Load ' . get_option('ts_vcsc_extend_settings_tinymceCustomName', 'Custom User Font') . '</label>';
								echo '</span>';
							echo '</div>';
						}
					}
				};
			?>
			</div>
		</div>
	</div>
</div>
