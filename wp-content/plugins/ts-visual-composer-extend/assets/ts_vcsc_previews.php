<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
	$output = '';
?>
<div class="ts-vcsc-settings-group-header">
	<div class="display_header">
		<h2><span class="dashicons dashicons-visibility"></span>Visual Composer Extensions - Icon Font Previews</h2>
	</div>
	<div class="clear"></div>
</div>
<div id="ts-settings-generator" style="display: block;">
	<div class="ts-vcsc-icon-preview-wrap" style="margin-top: 0px;">
		<div class="ts-vcsc-section-main">
			<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-info"></i>General Information</div>
			<div class="ts-vcsc-section-content">	
				<a class="button-secondary" style="width: 200px; margin: 20px auto 10px auto; text-align: center;" href="<?php echo $VISUAL_COMPOSER_EXTENSIONS->settingsLink; ?>" target="_parent"><img src="<?php echo TS_VCSC_GetResourceURL('images/logos/ts_vcsc_menu_icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Back to Plugin Settings</a>
				<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
					Use this page to quickly find the class name for a specific icon within a specific font. Selections will be limited to fonts that have been activated in the plugin settings.
				</div>
			</div>		
		</div>
		<div class="ts-vcsc-section-main">
			<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-visibility"></i>Icon Previews</div>
			<div class="ts-vcsc-section-content clearFixMe">	
				<div id="ts_vcsc_fonts_container" style="display: none;">
					<?php
						// Create Hidden List with all Icons per enabled Font
						foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Icon_Font_Settings as $Icon_Font => $iconfont) {
							$default = ($iconfont['default'] == "true" ? 1 : 0);
							if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont['setting'], $default) == 1) && ($iconfont['setting'] != "Custom") && ($iconfont['setting'] != "Dashicons")){
								$output = '';
								$output .= '<div id="ts-vcsc-icons-' . strtolower($iconfont['setting']) . '" data-font="' . $Icon_Font . '" class="">';
									$icon_counter = 0;
									foreach ($VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''} as $group => $icons) {
										if (!is_array($icons) || !is_array(current($icons))) {
											$class_key = key($icons);
											$output .= '<div class="ts-vcsc-icon-preview ts-freewall-active" data-filter="false" data-group="" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($icons)) . '" data-font="' . strtolower($iconfont['setting']) . '" data-count="' . $icon_counter . '" rel="' . esc_html(current($icons)) . '" title="' . esc_html(current($icons)) . '"><span class="ts-vcsc-icon-preview-icon"><i class="' . esc_attr($class_key) . '"></i></span><span class="ts-vcsc-icon-preview-name">' . str_replace(("ts-" . strtolower($iconfont['setting']) . "-"), "", esc_attr($class_key)) . '</span></div>';
											$icon_counter = $icon_counter + 1;
										} else {
											foreach ($icons as $key => $label) {
												$class_key = key($label);
												$output .= '<div class="ts-vcsc-icon-preview ts-freewall-active" data-filter="false" data-group="' . esc_attr($group) . '" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($label)) . '" data-font="' . strtolower($iconfont['setting']) . '" data-count="' . $icon_counter . '" rel="' . esc_html(current($label)) . '" title="' . esc_html(current($label)) . '"><span class="ts-vcsc-icon-preview-icon"><i class="' . esc_attr($class_key) . '"></i></span><span class="ts-vcsc-icon-preview-name">' . str_replace(("ts-" . strtolower($iconfont['setting']) . "-"), "", esc_attr($class_key)) . '</span></div>';
												$icon_counter = $icon_counter + 1;
											}
										}
									}
								$output .= '</div>';
								echo $output;
							} else if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont['setting'], $default) == 1) && ($iconfont['setting'] != "Custom") && ($iconfont['setting'] == "Dashicons")){
								$output = '';
								$output .= '<div id="ts-vcsc-icons-' . strtolower($iconfont['setting']) . '" data-font="' . $Icon_Font . '" class="">';
									$icon_counter = 0;
									foreach ($VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''} as $group => $icons) {
										if (!is_array($icons) || !is_array(current($icons))) {
											$class_key = key($icons);
											$output .= '<div class="ts-vcsc-icon-preview ts-freewall-active" data-filter="false" data-group="" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($icons)) . '" data-font="' . strtolower($iconfont['setting']) . '" data-count="' . $icon_counter . '" rel="' . esc_html(current($icons)) . '" title="' . esc_html(current($icons)) . '"><span class="ts-vcsc-icon-preview-icon"><i class="' . esc_attr($class_key) . '"></i></span><span class="ts-vcsc-icon-preview-name">' . str_replace((strtolower($iconfont['setting']) . "-"), "", esc_attr($class_key)) . '</span></div>';
											$icon_counter = $icon_counter + 1;
										} else {
											foreach ($icons as $key => $label) {
												$class_key = key($label);
												$output .= '<div class="ts-vcsc-icon-preview ts-freewall-active" data-filter="false" data-group="' . esc_attr($group) . '" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($label)) . '" data-font="' . strtolower($iconfont['setting']) . '" data-count="' . $icon_counter . '" rel="' . esc_html(current($label)) . '" title="' . esc_html(current($label)) . '"><span class="ts-vcsc-icon-preview-icon"><i class="' . esc_attr($class_key) . '"></i></span><span class="ts-vcsc-icon-preview-name">' . str_replace((strtolower($iconfont['setting']) . "-"), "", esc_attr($class_key)) . '</span></div>';
												$icon_counter = $icon_counter + 1;
											}
										}
									}
								$output .= '</div>';
								echo $output;
							} else if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont['setting'], $default) == 1) && ($iconfont['setting'] == "Custom")){
								$output = '';
								$output .= '<div id="ts-vcsc-icons-' . strtolower($iconfont['setting']) . '" data-font="' . $Icon_Font . '" class="">';
									$icon_counter = 0;
									foreach ($VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''} as $group => $icons) {
										if (!is_array($icons) || !is_array(current($icons))) {
											$class_key = key($icons);
											$output .= '<div class="ts-vcsc-icon-preview ts-freewall-active" data-filter="false" data-group="" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($icons)) . '" data-font="' . strtolower($iconfont['setting']) . '" data-count="' . $icon_counter . '" rel="' . esc_html(current($icons)) . '" title="' . esc_html(current($icons)) . '"><span class="ts-vcsc-icon-preview-icon"><i class="' . esc_attr($class_key) . '"></i></span><span class="ts-vcsc-icon-preview-name">' . str_replace((strtolower($iconfont['setting']) . "-"), "", esc_attr($class_key)) . '</span></div>';
											$icon_counter = $icon_counter + 1;
										} else {
											foreach ($icons as $key => $label) {
												$class_key = key($label);
												$output .= '<div class="ts-vcsc-icon-preview ts-freewall-active" data-filter="false" data-group="' . esc_attr($group) . '" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($label)) . '" data-font="' . strtolower($iconfont['setting']) . '" data-count="' . $icon_counter . '" rel="' . esc_html(current($label)) . '" title="' . esc_html(current($label)) . '"><span class="ts-vcsc-icon-preview-icon"><i class="' . esc_attr($class_key) . '"></i></span><span class="ts-vcsc-icon-preview-name">' . str_replace((strtolower($iconfont['setting']) . "-"), "", esc_attr($class_key)) . '</span></div>';
												$icon_counter = $icon_counter + 1;
											}
										}
									}
								$output .= '</div>';
								echo $output;
							}
						}
						if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") {
							foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Composer_Font_Settings as $Icon_Font => $iconfont) {
								$default = ($iconfont['default'] == "true" ? 1 : 0);
								if (get_option('ts_vcsc_extend_settings_tinymce' . $iconfont['setting'], $default) == 1){
									$output = '';
									$output .= '<div id="ts-vcsc-icons-' . strtolower($iconfont['setting']) . '" data-font="' . $Icon_Font . '" class="">';
										$icon_counter = 0;
										foreach ($VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''} as $group => $icons) {
											if (!is_array($icons) || !is_array(current($icons))) {
												$class_key = key($icons);
												$output .= '<div class="ts-vcsc-icon-preview ts-freewall-active" data-filter="false" data-group="" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($icons)) . '" data-font="' . strtolower($iconfont['setting']) . '" data-count="' . $icon_counter . '" rel="' . esc_html(current($icons)) . '" title="' . esc_html(current($icons)) . '"><span class="ts-vcsc-icon-preview-icon"><i class="' . esc_attr($class_key) . '"></i></span><span class="ts-vcsc-icon-preview-name">' . str_replace(("ts-" . strtolower($iconfont['setting']) . "-"), "", esc_attr($class_key)) . '</span></div>';
												$icon_counter = $icon_counter + 1;
											} else {
												foreach ($icons as $key => $label) {
													$class_key = key($label);
													$output .= '<div class="ts-vcsc-icon-preview ts-freewall-active" data-filter="false" data-group="' . esc_attr($group) . '" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($label)) . '" data-font="' . strtolower($iconfont['setting']) . '" data-count="' . $icon_counter . '" rel="' . esc_html(current($label)) . '" title="' . esc_html(current($label)) . '"><span class="ts-vcsc-icon-preview-icon"><i class="' . esc_attr($class_key) . '"></i></span><span class="ts-vcsc-icon-preview-name">' . str_replace(("ts-" . strtolower($iconfont['setting']) . "-"), "", esc_attr($class_key)) . '</span></div>';
													$icon_counter = $icon_counter + 1;
												}
											}
										}
									$output .= '</div>';
									echo $output;
								}
							}
						}
					?>
				</div>		
				<div id="ts_vcsc_preview_container">
					<div style="width: 100%; display: inline-block; margin-bottom: 20px; border-bottom: 1px solid #DDDDDD; padding-bottom: 20px;">
						<img src="<?php echo TS_VCSC_GetResourceURL('images/other/icon_fonts.png'); ?>" style="width: 200px; height: 71px;">			
						<button style="height: 28px; <?php echo ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Fonts > 1 ? "display: block;" : "display: none;"); ?>" type="button" value="Dropdown" data-dropdown="#ts-dropdown-fonts" class="dropDownFont button-secondary">Switch Icon Font</button>
						<div id="ts-dropdown-fonts" class="ts-dropdown ts-dropdown-anchor-left ts-dropdown-tip ts-dropdown-relative">
							<ul class="ts-dropdown-menu">
								<?php
									$activeFonts = 0;
									foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Icon_Font_Settings as $Icon_Font => $iconfont) {
										$default = ($iconfont['default'] == "true" ? 1 : 0);
										if (get_option('ts_vcsc_extend_settings_tinymce' . $iconfont['setting'], $default) == 1) {
											if ($iconfont['setting'] != "Custom") {
												$output = '';
												$activeFonts++;
												$output .= '<li class="ts-font-dropdown-item' . ($activeFonts == 1 ? " active" : "") . '" data-name="' . $Icon_Font . '" data-author="' . $iconfont['author'] . '" data-count="' . $VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'} . '" data-code="' . strtolower($iconfont['setting']) . '" title="' . $Icon_Font . '"><a href="#">' . $Icon_Font . ' (' . $VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'} . ' Icons)</a></li>';
												if ($activeFonts < $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Fonts) {
													$output .= '<li class="ts-dropdown-divider"></li>';
												}
											} else {
												$output = '';
												$activeFonts++;
												$output .= '<li class="ts-font-dropdown-item' . ($activeFonts == 1 ? " active" : "") . '" data-name="' . get_option('ts_vcsc_extend_settings_tinymceCustomName', 'Custom User Font') . ' (Upload)" data-author="' . get_option('ts_vcsc_extend_settings_tinymceCustomAuthor', 'Custom User') . ' (Upload)" data-count="' . $VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'} . '" data-code="' . strtolower($iconfont['setting']) . '" title="' . $Icon_Font . '"><a href="#">' . $Icon_Font . ' (' . $VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'} . ' Icons)</a></li>';
												if ($activeFonts < $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Fonts) {
													$output .= '<li class="ts-dropdown-divider"></li>';
												}
											}
											echo $output;
										}
									}
									if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") {
										foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Composer_Font_Settings as $Icon_Font => $iconfont) {
											$default = ($iconfont['default'] == "true" ? 1 : 0);
											if (get_option('ts_vcsc_extend_settings_tinymce' . $iconfont['setting'], $default) == 1) {
												if ($iconfont['setting'] != "Custom") {
													$output = '';
													$activeFonts++;
													$output .= '<li class="ts-font-dropdown-item' . ($activeFonts == 1 ? " active" : "") . '" data-name="' . $Icon_Font . '" data-author="' . $iconfont['author'] . '" data-count="' . $VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'} . '" data-code="' . strtolower($iconfont['setting']) . '" title="' . $Icon_Font . '"><a href="#">' . $Icon_Font . ' (' . $VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'} . ' Icons)</a></li>';
													if ($activeFonts < $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Fonts) {
														$output .= '<li class="ts-dropdown-divider"></li>';
													}
												} else {
													$output = '';
													$activeFonts++;
													$output .= '<li class="ts-font-dropdown-item' . ($activeFonts == 1 ? " active" : "") . '" data-name="' . get_option('ts_vcsc_extend_settings_tinymceCustomName', 'Custom User Font') . ' (Upload)" data-author="' . get_option('ts_vcsc_extend_settings_tinymceCustomAuthor', 'Custom User') . ' (Upload)" data-count="' . $VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'} . '" data-code="' . strtolower($iconfont['setting']) . '" title="' . $Icon_Font . '"><a href="#">' . $Icon_Font . ' (' . $VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'} . ' Icons)</a></li>';
													if ($activeFonts < $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Fonts) {
														$output .= '<li class="ts-dropdown-divider"></li>';
													}
												}
												echo $output;
											}
										}
									}
								?>
							</ul>
						</div>					
					</div>	
					<?php
						$output = '';
						$output .= '<div id="ts-vcsc-extend-preview" class="">';
							$TS_VCSC_FirstFontOutput = "false";
							foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Icon_Font_Settings as $Icon_Font => $iconfont) {
								$default = ($iconfont['default'] == "true" ? 1 : 0);
								if (get_option('ts_vcsc_extend_settings_tinymce' . $iconfont['setting'], $default) == 1) {
									if ($iconfont['setting'] != "Custom") {
										$output .= '<div id="ts-vcsc-extend-preview-name" class="">Font Name: ' . $Icon_Font . '</div>';
										$output .= '<div id="ts-vcsc-extend-preview-author" class="">Font Author: ' . $iconfont['author'] . '</div>';
										$output .= '<div id="ts-vcsc-extend-preview-count" class="">Icon Count: ' . $VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'} . '</div>';
										$TS_VCSC_FirstFontOutput = "true";
										break;
									} else {
										$output .= '<div id="ts-vcsc-extend-preview-name" class="">Font Name: ' . get_option('ts_vcsc_extend_settings_tinymceCustomName', 'Custom User Font') . ' (Upload)</div>';
										$output .= '<div id="ts-vcsc-extend-preview-author" class="">Font Author: ' . get_option('ts_vcsc_extend_settings_tinymceCustomAuthor', 'Custom User') . ' (Upload)</div>';
										$output .= '<div id="ts-vcsc-extend-preview-count" class="">Icon Count: ' . $VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'} . '</div>';
										$TS_VCSC_FirstFontOutput = "true";
										break;
									}
								}
							}
							if (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") && ($TS_VCSC_FirstFontOutput == "false")) {
								foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Composer_Font_Settings as $Icon_Font => $iconfont) {
									$default = ($iconfont['default'] == "true" ? 1 : 0);
									if (get_option('ts_vcsc_extend_settings_tinymce' . $iconfont['setting'], $default) == 1) {
										$output .= '<div id="ts-vcsc-extend-preview-name" class="">Font Name: ' . $Icon_Font . '</div>';
										$output .= '<div id="ts-vcsc-extend-preview-author" class="">Font Author: ' . $iconfont['author'] . '</div>';
										$output .= '<div id="ts-vcsc-extend-preview-count" class="">Icon Count: ' . $VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'} . '</div>';
										$TS_VCSC_FirstFontOutput = "true";
										break;
									}
								}
							}
							$output .= '<div id="ts-vcsc-extend-preview-count" class="">Icon Class:<span id="ts-vcsc-extend-preview-code">...</span></div>';
							$output .= '<div id="ts-vcsc-extend-preview-search">';
								$output .= '<span style="margin-right: 10px; display: inline-block;">' . __( "Filter by Icon:", "ts_visual_composer_extend" ) . '</span>';
								$output .= '<input style="width: 250px; font-weight: normal; display: inline-block;" name="ts-font-icons-search" id="ts-font-icons-search" class="ts-font-icons-search" type="text" placeholder="' . __( "Search ...", "ts_visual_composer_extend" ) . '" />';
								$output .= '<div style="display: inline-block;"><div id="ts-vcsc-extend-preview-clear"></div></div>';
							$output .= '</div>';
							$output .= '<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 30px; margin-bottom: 30px; font-size: 13px; text-align: justify;">';
								$output .= 'Click on an icon to view the full class name for that icon.';
							$output .= '</div>';
							$output .= '<div id="ts-vcsc-extend-preview-list" class="">';
								$TS_VCSC_FirstFontOutput = "false";
								foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Icon_Font_Settings as $Icon_Font => $iconfont) {
									$default = ($iconfont['default'] == "true" ? 1 : 0);
									if (get_option('ts_vcsc_extend_settings_tinymce' . $iconfont['setting'], $default) == 1) {
										if (($iconfont['setting'] != "Custom") && ($iconfont['setting'] != "Dashicons")) {
											$icon_counter = 0;
											foreach ($VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''} as $group => $icons) {
												if (!is_array($icons) || !is_array(current($icons))) {
													$class_key = key($icons);
													$output .= '<div class="ts-vcsc-icon-preview ts-freewall-active" data-filter="false" data-group="" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($icons)) . '" data-font="' . strtolower($iconfont['setting']) . '" data-count="' . $icon_counter . '" rel="' . esc_html(current($icons)) . '" title="' . esc_html(current($icons)) . '"><span class="ts-vcsc-icon-preview-icon"><i class="' . esc_attr($class_key) . '"></i></span><span class="ts-vcsc-icon-preview-name">' . str_replace(("ts-" . strtolower($iconfont['setting']) . "-"), "", esc_attr($class_key)) . '</span></div>';
													$icon_counter = $icon_counter + 1;
												} else {
													foreach ($icons as $key => $label) {
														$class_key = key($label);
														$output .= '<div class="ts-vcsc-icon-preview ts-freewall-active" data-filter="false" data-group="' . esc_attr($group) . '" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($label)) . '" data-font="' . strtolower($iconfont['setting']) . '" data-count="' . $icon_counter . '" rel="' . esc_html(current($label)) . '" title="' . esc_html(current($label)) . '"><span class="ts-vcsc-icon-preview-icon"><i class="' . esc_attr($class_key) . '"></i></span><span class="ts-vcsc-icon-preview-name">' . str_replace(("ts-" . strtolower($iconfont['setting']) . "-"), "", esc_attr($class_key)) . '</span></div>';
														$icon_counter = $icon_counter + 1;
													}
												}												
											}
											$TS_VCSC_FirstFontOutput = "true";
											break;
										} else if (($iconfont['setting'] != "Custom") && ($iconfont['setting'] == "Dashicons")) {
											$icon_counter = 0;
											foreach ($VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''} as $group => $icons) {
												if (!is_array($icons) || !is_array(current($icons))) {
													$class_key = key($icons);
													$output .= '<div class="ts-vcsc-icon-preview ts-freewall-active" data-filter="false" data-group="" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($icons)) . '" data-font="' . strtolower($iconfont['setting']) . '" data-count="' . $icon_counter . '" rel="' . esc_html(current($icons)) . '" title="' . esc_html(current($icons)) . '"><span class="ts-vcsc-icon-preview-icon"><i class="' . esc_attr($class_key) . '"></i></span><span class="ts-vcsc-icon-preview-name">' . str_replace((strtolower($iconfont['setting']) . "-"), "", esc_attr($class_key)) . '</span></div>';
													$icon_counter = $icon_counter + 1;
												} else {
													foreach ($icons as $key => $label) {
														$class_key = key($label);
														$output .= '<div class="ts-vcsc-icon-preview ts-freewall-active" data-filter="false" data-group="' . esc_attr($group) . '" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($label)) . '" data-font="' . strtolower($iconfont['setting']) . '" data-count="' . $icon_counter . '" rel="' . esc_html(current($label)) . '" title="' . esc_html(current($label)) . '"><span class="ts-vcsc-icon-preview-icon"><i class="' . esc_attr($class_key) . '"></i></span><span class="ts-vcsc-icon-preview-name">' . str_replace((strtolower($iconfont['setting']) . "-"), "", esc_attr($class_key)) . '</span></div>';
														$icon_counter = $icon_counter + 1;
													}
												}
											}
											$TS_VCSC_FirstFontOutput = "true";
											break;
										} else {
											$icon_counter = 0;
											foreach ($VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''} as $group => $icons) {
												if (!is_array($icons) || !is_array(current($icons))) {
													$class_key = key($icons);
													$output .= '<div class="ts-vcsc-icon-preview ts-freewall-active" data-filter="false" data-group="" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($icons)) . '" data-font="' . strtolower($iconfont['setting']) . '" data-count="' . $icon_counter . '" rel="' . esc_html(current($icons)) . '" title="' . esc_html(current($icons)) . '"><span class="ts-vcsc-icon-preview-icon"><i class="' . esc_attr($class_key) . '"></i></span><span class="ts-vcsc-icon-preview-name">' . str_replace((strtolower($iconfont['setting']) . "-"), "", esc_attr($class_key)) . '</span></div>';
													$icon_counter = $icon_counter + 1;
												} else {
													foreach ($icons as $key => $label) {
														$class_key = key($label);
														$output .= '<div class="ts-vcsc-icon-preview ts-freewall-active" data-filter="false" data-group="' . esc_attr($group) . '" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($label)) . '" data-font="' . strtolower($iconfont['setting']) . '" data-count="' . $icon_counter . '" rel="' . esc_html(current($label)) . '" title="' . esc_html(current($label)) . '"><span class="ts-vcsc-icon-preview-icon"><i class="' . esc_attr($class_key) . '"></i></span><span class="ts-vcsc-icon-preview-name">' . str_replace((strtolower($iconfont['setting']) . "-"), "", esc_attr($class_key)) . '</span></div>';
														$icon_counter = $icon_counter + 1;
													}
												}
											}
											$TS_VCSC_FirstFontOutput = "true";
											break;
										}
									}
								}
								if (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") && ($TS_VCSC_FirstFontOutput == "false")) {
									foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Composer_Font_Settings as $Icon_Font => $iconfont) {
										$default = ($iconfont['default'] == "true" ? 1 : 0);
										if (get_option('ts_vcsc_extend_settings_tinymce' . $iconfont['setting'], $default) == 1){;
											$icon_counter = 0;
											foreach ($VISUAL_COMPOSER_EXTENSIONS->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''} as $group => $icons) {
												if (!is_array($icons) || !is_array(current($icons))) {
													$class_key = key($icons);
													$output .= '<div class="ts-vcsc-icon-preview ts-freewall-active" data-filter="false" data-group="" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($icons)) . '" data-font="' . strtolower($iconfont['setting']) . '" data-count="' . $icon_counter . '" rel="' . esc_html(current($icons)) . '" title="' . esc_html(current($icons)) . '"><span class="ts-vcsc-icon-preview-icon"><i class="' . esc_attr($class_key) . '"></i></span><span class="ts-vcsc-icon-preview-name">' . str_replace((strtolower($iconfont['setting']) . "-"), "", esc_attr($class_key)) . '</span></div>';
													$icon_counter = $icon_counter + 1;
												} else {
													foreach ($icons as $key => $label) {
														$class_key = key($label);
														$output .= '<div class="ts-vcsc-icon-preview ts-freewall-active" data-filter="false" data-group="' . esc_attr($group) . '" data-name="' . esc_attr($class_key) . '" data-code="' . esc_html(current($label)) . '" data-font="' . strtolower($iconfont['setting']) . '" data-count="' . $icon_counter . '" rel="' . esc_html(current($label)) . '" title="' . esc_html(current($label)) . '"><span class="ts-vcsc-icon-preview-icon"><i class="' . esc_attr($class_key) . '"></i></span><span class="ts-vcsc-icon-preview-name">' . str_replace((strtolower($iconfont['setting']) . "-"), "", esc_attr($class_key)) . '</span></div>';
														$icon_counter = $icon_counter + 1;
													}
												}
											}
											$TS_VCSC_FirstFontOutput = "true";
											break;
										}
									}														
								}
							$output .= '</div>';
						$output .= '</div>';
						echo $output;
					?>
				</div>
			</div>		
		</div>
	</div>
</div>
