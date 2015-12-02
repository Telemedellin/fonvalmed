<?php
	global $VISUAL_COMPOSER_EXTENSIONS;
	$social_array 						= array();
	$social_count 						= 0;	
	$social_stored 						= get_option('ts_vcsc_extend_settings_socialDefaults', '');
	if (($social_stored == false) || (empty($social_stored)) || ($social_stored == "") || (!is_array($social_stored))) {
		$social_stored					= array();
	}
	//var_dump($social_values);	
	foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Social_Networks_Array as $Social_Network => $social) {
		$social_lines = array(
			'network' 					=> $Social_Network,
			'class'						=> $social['class'],
			'icon'						=> $social['icon'],		
			'link'						=> (isset($social_stored[$Social_Network]['link']) ? $social_stored[$Social_Network]['link'] : ""),
			'order' 					=> (isset($social_stored[$Social_Network]['order']) ? $social_stored[$Social_Network]['order'] : $social['order']),		
			'original'					=> $social['order']
		);
		$social_array[] 				= $social_lines;
		$social_count 					= $social_count + 1;
	}	
?>

<div id="ts-settings-social" class="tab-content">
	<div class="ts-vcsc-section-main">
		<div class="ts-vcsc-section-title ts-vcsc-section-show"><i class="dashicons-share"></i>Social Network Links</div>
		<div class="ts-vcsc-section-content">
			<div class="ts-vcsc-notice-field ts-vcsc-success" style="margin-top: 10px; font-size: 13px; text-align: justify;">
				These settings will be used as global settings for all social network buttons used in the element "TS Social Networks". You can drag and drop each network to change the order in which the network buttons will be shown on your website.
			</div>		
			<div>
				<h4>Social Network Links:</h4>				
				<div id="ts-vcsc-social-network-links-restore" class="button-secondary" style="width: 120px; margin-top: 20px; text-align: center;"><img src="<?php echo TS_VCSC_GetResourceURL('images/other/ts_vcsc_sortalpha_icon_16x16.png'); ?>" style="width: 16px; height: 16px; margin-right: 10px;">Restore</div>
			</div>			
			<?php
				TS_VCSC_SortMultiArray($social_array, 'order');		
				// Output Array Input Fields
				$social_networks = '';
				$social_networks .= '<ul id="ts-vcsc-social-network-links" class="ts-social-icons">';				
				foreach ($social_array as $index => $array) {
					$Social_Network 	= $social_array[$index]['network'];
					$Social_Class 		= $social_array[$index]['class'];
					$Social_Icon 		= $social_array[$index]['icon'];
					$Social_Order		= $social_array[$index]['order'];
					$Social_Link		= $social_array[$index]['link'];
					$Social_Original	= $social_array[$index]['original'];
					$social_networks .= '<li style="display: inline-block; width: 100%; margin: 5px 0px;" data-order="' . $Social_Order . '" data-network="' . $Social_Network . '" data-original="' . $Social_Original . '">';
						$social_networks .= '<div style="width: 150px; float: left;"><span style="width: 20px;"><i class="' . $Social_Icon . '"></i></span><label style="margin-left: 10px;" class="Uniform" for="ts_vcsc_social_link_' . $Social_Network . '">' . ucwords($Social_Network) . ':</label></div>';
						if (($Social_Network == "Email") || ($Social_Network == "Paypal")) {
							$social_networks .= '<input class="validate[custom[email]]" data-error="Social Network Links - ' . ucwords($Social_Network) . '" data-order="7" type="text" style="width: 20%;" id="ts_vcsc_social_link_' . $Social_Network . '" name="ts_vcsc_social_link_' . $Social_Network . '" value="'.  $Social_Link . '" size="100">';
						} else if (($Social_Network == "Phone") || ($Social_Network == "Cell")) {
							$social_networks .= '<input class="validate[custom[phone]]" data-error="Social Network Links - ' . ucwords($Social_Network) . '" data-order="7" type="text" style="width: 20%;" id="ts_vcsc_social_link_' . $Social_Network . '" name="ts_vcsc_social_link_' . $Social_Network . '" value="'.  $Social_Link . '" size="100">';
						} else if ($Social_Network == "Skype") {
							$social_networks .= '<input class="validate[custom[onlyClassNames]]" data-error="Social Network Links - ' . ucwords($Social_Network) . '" data-order="7" type="text" style="width: 20%;" id="ts_vcsc_social_link_' . $Social_Network . '" name="ts_vcsc_social_link_' . $Social_Network . '" value="'.  $Social_Link . '" size="100">';
						} else {
							$social_networks .= '<input class="validate[custom[url]]" data-error="Social Network Links - ' . ucwords($Social_Network) . '" data-order="7" type="text" style="width: 20%;" id="ts_vcsc_social_link_' . $Social_Network . '" name="ts_vcsc_social_link_' . $Social_Network . '" value="'.  $Social_Link . '" size="100">';
						}
						$social_networks .= '<input type="hidden" id="ts_vcsc_social_order_' . $Social_Network . '" name="ts_vcsc_social_order_' . $Social_Network . '" value="'.  $Social_Order . '" size="100">';
					$social_networks .= '</li>';
				}				
				$social_networks .= '</ul>';
				echo $social_networks;
			?>
		</div>
	</div>
</div>
