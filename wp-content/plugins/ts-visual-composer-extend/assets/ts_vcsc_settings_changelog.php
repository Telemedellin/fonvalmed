<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
?>
<div id="ts-settings-changelog" class="tab-content">
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-media-text"></i>Changelog</div>
		<div class="ts-vcsc-section-content">
			<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				The plugin is constantly evolving and adding new features. The listing below is a summary of all changes and additions so far.
			</div>	
			<?php
				$changelog = file_get_contents(TS_VCSC_GetResourceURL('Changelog.txt'), true);
				echo nl2br(str_replace('<br/>', PHP_EOL, $changelog));
			?>
		</div>
	</div>
</div>