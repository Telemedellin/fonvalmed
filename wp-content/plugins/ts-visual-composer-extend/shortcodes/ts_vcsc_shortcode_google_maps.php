<?php
	//add_action('wp_enqueue_scripts', 		'TS_VCSC_Google_Maps_Front');
	function TS_VCSC_Google_Maps_Front(){
		if ((get_option('ts_vcsc_extend_settings_loadHeader', 0) == 0)) {
			$FOOTER = true;
		} else {
			$FOOTER = false;
		}
		global $post;
		$postdata = get_post($post->ID);
		$shortcode_exist = preg_match( '#\[ *TS-VCSC-Google-Maps([^\]])*\]#i', $postdata->post_content );
		if ($shortcode_exist){}
	}
	
	add_shortcode('TS-VCSC-Google-Maps', 	'TS_VCSC_Google_Maps_Function');
	add_shortcode('TS_VCSC_Google_Maps', 	'TS_VCSC_Google_Maps_Function');
	function TS_VCSC_Google_Maps_Function ($atts, $content = null) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
		
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'googlemap_api'				=> 'true',
			'height'					=> '400',
			'coordinates'				=> '',
			'geolocation'				=> 'true',
			'autocomplete'				=> 'false',
			'geolayer'					=> '1',
			'maptype'					=> 'ROADMAP',
			'mapstyle'					=> 'style_default',
			'mapfullwidth'				=> 'false',
			'mapfullwrapper'			=> 'false',
			'breakouts'					=> 6,
			'mobileactivate'			=> 'true',
			'metric'					=> 'false',
			'controls_wheel'			=> 'true',
			'controls_pan'				=> 'true',
			'controls_zoom'				=> 'true',
			'controls_scale'			=> 'true',
			'controls_street'			=> 'true',
			'controls_style'			=> 'false',
			'directions'				=> 'true',
			'showgoogle'				=> 'true',
			'tooltipvisible'			=> 'false',
			'markerstyle'				=> 'default',
			'markerzoom'				=> 17,
			'markerimage'				=> '',
			'markerinternal'			=> '',
			'markeranimation'			=> 'true',
			'markeranimationtype'		=> 'drop',
			'margin_top'				=> 20,
			'margin_bottom'				=> 20,
			'el_id'						=> '',
			'el_class'					=> '',
			'css'						=> '',
		), $atts ));
		
		// Check for Front End Editor
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
			$editor_frontend			= "true";
		} else {
			$editor_frontend			= "false";
		}

		$randomizer						= mt_rand(999999, 9999999);
		
		if ($googlemap_api == "true") {
			if ($geolocation == "true") {
				wp_enqueue_script('ts-extend-mapapi-geo');
			} else {
				wp_enqueue_script('ts-extend-mapapi-none');
			}
		}
		wp_enqueue_script('ts-extend-infobox');
		wp_enqueue_script('ts-extend-googlemap');
		
		if (!empty($el_id)) {
			$map_id						= $el_id;
		} else {
			$map_id						= 'ts-vcsc-google-map-' . $randomizer;
		}
	
		if ($markerstyle == "image") {
			$marker_image 				= wp_get_attachment_image_src($markerimage, 'full');
			$marker_image				= $marker_image[0];
		} else if ($markerstyle == "marker") {
			$marker_image				= TS_VCSC_GetResourceURL('images/marker/' . $markerinternal);
		} else {
			$marker_image				= '';
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS-VCSC-Google-Maps', $atts);
		} else {
			$css_class	= '';
		}
		
		$output 						= '';

		if (($mapfullwidth == "true") && ($mapfullwrapper == "true")) {
			$output .= '<div class="ts-map-wrapper" style="width: 100%; height: 100%; position: relative; display: block;">';
		}
			$output .= '<div id="' . $map_id . '" class="ts-map-frame ' . $css_class . ' clearFixMe" data-height="' . $height . '" data-activate="false" data-inline="' . $editor_frontend . '" data-break-parents="' . $breakouts . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;"></div>';
		if (($mapfullwidth == "true") && ($mapfullwrapper == "true")) {
			$output .= '</div>';
		}

		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					<?php if ($editor_frontend == "true") { ?>
						var $style_default = [];
					<?php } ?>
					if (typeof jQuery.fn.TSGM_Map !== 'undefined') {
						jQuery('#<?php echo $map_id; ?>').TSGM_Map({
							TSGM_Height: 			'<?php echo $height; ?>',
							TSGM_Width:				'100',
							TSGM_MobileActivate:	<?php echo $mobileactivate; ?>,
							TSGM_AutoComplete:		<?php echo $autocomplete; ?>,
							TSGM_MapFullWidth:		<?php echo $mapfullwidth; ?>,
							TSGM_MapType:			'<?php echo $maptype; ?>',
							TSGM_MapStyle:			<?php echo ($editor_frontend == "true" ? "$" . "style_default" : "$" . $mapstyle); ?>,
							TSGM_MapCustom:			'<?php echo ($editor_frontend == "true" ? "style_default" : $mapstyle); ?>',
							TSGM_GeoLocation:		<?php echo $geolocation; ?>,
							TSGM_GeoLayer:			<?php echo $geolayer; ?>,
							TSGM_ScrollWheel:		<?php echo $controls_wheel; ?>,
							TSGM_PanControl:		<?php echo $controls_pan; ?>,
							TSGM_ZoomControl:		<?php echo $controls_zoom; ?>,
							TSGM_ScaleControl:		<?php echo $controls_scale; ?>,
							TSGM_StreetControl:		<?php echo $controls_street; ?>,
							TSGM_StyleControl:		<?php echo $controls_style; ?>,
							TSGM_Metric:			<?php echo $metric; ?>,
							TSGM_MapIcon:			'<?php echo $marker_image; ?>',
							TSGM_MapDirections:		<?php echo $directions; ?>,
							TSGM_MapGoogle:			<?php echo $showgoogle; ?>,
							TSGM_ZoomStartPoint:	<?php echo $markerzoom; ?>,
							TSGM_StartOpacity: 		8,
							TSGM_Animation:			<?php echo $markeranimation; ?>,
							TSGM_AnimationType:		'<?php echo $markeranimationtype; ?>',
							TSGM_ShowTarget:  		false,
							TSGM_ShowBouncer:  		true,
							TSGM_StartPanel: 		true,
							TSGM_TexStartPoint:		'',
							TSGM_Fixdestination:	'<?php echo $coordinates; ?>',
							TSGM_TooltipContent:	'<div class="ts-map-infobox"><?php echo trim(preg_replace('/\s+/', ' ', do_shortcode($content))); ?></div>',
							TSGM_TooltipVisible:	<?php echo $tooltipvisible; ?>,
							TSGM_TextResetMap:		$TS_VCSC_GoogleMap_TextResetMap,
							TSGM_TextCalcShow:		$TS_VCSC_GoogleMap_TextCalcShow,
							TSGM_TextCalcHide:		$TS_VCSC_GoogleMap_TextCalcHide,
							TSGM_TextDirectionShow:	$TS_VCSC_GoogleMap_TextDirectionShow,
							TSGM_TextDirectionHide:	$TS_VCSC_GoogleMap_TextDirectionHide,
							TSGM_PrintRouteText:	$TS_VCSC_GoogleMap_PrintRouteText,
							TSGM_TextViewOnGoogle:	$TS_VCSC_GoogleMap_TextViewOnGoogle,
							TSGM_TextButtonCalc:	$TS_VCSC_GoogleMap_TextButtonCalc,
							TSGM_TextSetTarget:		$TS_VCSC_GoogleMap_TextSetTarget,
							TSGM_TextButtonGeo:		$TS_VCSC_GoogleMap_TextGeoLocation,
							TSGM_TextTravelMode:	$TS_VCSC_GoogleMap_TextTravelMode,
							TSGM_TextDriving:		$TS_VCSC_GoogleMap_TextDriving,
							TSGM_TextWalking:		$TS_VCSC_GoogleMap_TextWalking,
							TSGM_TextBicy:			$TS_VCSC_GoogleMap_TextBicy,
							TSGM_TextWP:			$TS_VCSC_GoogleMap_TextWP,
							TSGM_TextButtonAdd:		$TS_VCSC_GoogleMap_TextButtonAdd,
							TSGM_TextButtonShow:	$TS_VCSC_GoogleMap_TextActivate,
							TSGM_TextButtonHide:	$TS_VCSC_GoogleMap_TextDeactivate,
						});
					}
				});
			</script>
		<?php
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_Google_Maps extends WPBakeryShortCode {};
	}
?>