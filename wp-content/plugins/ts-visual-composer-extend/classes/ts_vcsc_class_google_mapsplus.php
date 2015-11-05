<?php
if (!class_exists('TS_Google_Maps_Plus')){
	class TS_Google_Maps_Plus {
		function __construct() {
			global $VISUAL_COMPOSER_EXTENSIONS;
            if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
                add_action('init',                              		array($this, 'TS_VCSC_Add_GoogleMapsPlus_Elements'), 9999999);
            } else {
                add_action('admin_init',		                		array($this, 'TS_VCSC_Add_GoogleMapsPlus_Elements'), 9999999);
            }
			add_shortcode('TS_VCSC_GoogleMapsPlus_Marker',              array($this, 'TS_VCSC_GoogleMapsPlus_Marker'));
			add_shortcode('TS_VCSC_GoogleMapsPlus_Overlay',             array($this, 'TS_VCSC_GoogleMapsPlus_Overlay'));
			add_shortcode('TS_VCSC_GoogleMapsPlus_Container',       	array($this, 'TS_VCSC_GoogleMapsPlus_Container'));
		}

		// Google Maps Marker
		function TS_VCSC_GoogleMapsPlus_Marker ($atts, $content = null) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();
		
			extract( shortcode_atts( array(
				// Marker Location
				'marker_position'				=> 'coordinates',		// coordinates, address
				'marker_address'				=> '',
				'marker_latitude'				=> '',
				'marker_longitude'				=> '',
				// Marker Style
				'marker_style'					=> 'default',			// default, internal, image
				'marker_internal'				=> '',
				'marker_image'					=> '',				
				'marker_animation'				=> 'false',
				'marker_entry'					=> 'drop',
				// Infowindow Content
				'marker_group'					=> '',
				'marker_title'					=> '',
				'marker_include'				=> 'true',
				'marker_popup'					=> 'false',
				'marker_draggable'				=> 'false',
				'marker_streetview'				=> 'false',
				// Infowindow Buttons
				'marker_directions'				=> 'false',
				'marker_directions_text'		=> 'Get Directions',
				'marker_viewer'					=> 'false',
				'marker_viewer_text'			=> 'View on Google Maps',
				'marker_link'					=> 'false',
				'marker_url'					=> '',
				'marker_button'					=> 'Learn More!',
				// Other Settings
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			), $atts ));
			
			$map_random                    		= mt_rand(999999, 9999999);
			$map_valid							= "false";
			$output 							= '';
			
			// Check for Missing Location
			if (($marker_position == "coordinates") && (($marker_latitude == "") || ($marker_longitude == ""))) {
				$map_valid						= "false";
			} else if (($marker_position == "address") && ($marker_address == '')) {
				$map_valid						= "false";
			} else {
				$map_valid						= "true";
			}
			if ($map_valid == "false") {
				echo $output;
				$myvariable 					= ob_get_clean();
				return $myvariable;
			}
			
			if (!empty($el_id)) {
				$marker_id						= $el_id;
			} else {
				$marker_id						= 'ts-advanced-google-map-marker-single-' . $map_random;
			}

			
			// Link Values
			if ($marker_link = "true") {
				$link 							= ($marker_url == '||') ? '' : $marker_url;
				$link 							= vc_build_link($link);
				$a_href							= $link['url'];
				$a_title 						= $link['title'];
				$a_target 						= $link['target'];
			} else {
				$a_href							= '';
				$a_title 						= '';
				$a_target 						= '';
			}

			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-advanced-google-map-marker-single ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_GoogleMapsPlus_Marker', $atts);
			} else {
				$css_class	= 'ts-advanced-google-map-marker-single ' . $el_class;
			}
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
				if (($marker_style == "internal") && ($marker_internal != '')) {
					$marker_icon				= urlencode(TS_VCSC_GetResourceURL('images/marker/' . $marker_internal));
				} else if (($marker_style == "image") && ($marker_image != '')) {
					$marker_icon 				= wp_get_attachment_image_src($marker_image, 'full');
					$marker_icon				= urlencode($marker_icon[0]);
				} else {
					$marker_icon				= '';
				}
			} else {
				$marker_icon					= '';
			}
			
			$marker_data						= 'data-id="map-marker-single-' . $map_random . '" data-processed="false" data-group="' . $marker_group . '" data-streetview="' . $marker_streetview . '" data-draggable="' . $marker_draggable . '" data-title="' . $marker_title . '" data-icon="' . $marker_icon . '" data-animation-allow="' . $marker_animation . '" data-animation-type="' . $marker_entry . '" data-latitude="' . ($marker_position == 'coordinates' ? $marker_latitude : '') . '" data-longitude="' . ($marker_position == 'coordinates' ? $marker_longitude : '') . '" data-address="' . ($marker_position == 'address' ? $marker_address : '') . '" data-draggable="false" data-popup="' . $marker_popup . '"';
			
			if ($marker_position == "coordinates") {
				$google_directions				= 'https://www.google.com/maps?saddr=My+Location&daddr=' . $marker_latitude . ',' . $marker_longitude . '';
				$google_viewer					= 'https://www.google.com/maps?q=' . $marker_latitude . ',' . $marker_longitude . '';
			} else if ($marker_position == "address") {
				$google_directions				= 'https://www.google.com/maps?saddr=My+Location&daddr=' . urlencode($marker_address) . '';
				$google_viewer					= 'https://www.google.com/maps?q=' . urlencode($marker_address) . '';
			}
			
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
				$output .= '<div id="' . $marker_id . '" class="' . $css_class . '" ' . $marker_data . '>';
					if (($marker_include == "true") && ($marker_title != '')) {
						$output .= '<div class="ts-advanced-google-map-marker-title">' . $marker_title . '</div>';
					}
					if (($content != '') || ($marker_directions == "true") || ($marker_viewer == "true") || (($marker_link == "true") && ($a_href != ''))) {
						$output .= '<div class="ts-advanced-google-map-marker-content">';
							if ($content != '') {
								$output .= do_shortcode($content);
							}
							if (($marker_directions == "true") || ($marker_viewer == "true") || (($marker_link == "true") && ($a_href != ''))) {
								$output .= '<div class="ts-advanced-google-map-marker-controls">';
									if ($marker_directions == "true") {
										$output .= '<a class="ts-advanced-google-map-marker-directions" href="' . $google_directions . '" target="_blank">' . $marker_directions_text . '</a>';
									}
									if ($marker_viewer == "true") {
										$output .= '<a class="ts-advanced-google-map-marker-viewer" href="' . $google_viewer . '" target="_blank">' . $marker_viewer_text . '</a>';
									}
									if (($marker_link == "true") && ($a_href != '')) {
										$output .= '<a class="ts-advanced-google-map-marker-link" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '">' . $marker_button . '</a>';
									}
								$output .= '</div>';
							}
						$output .= '</div>';
					}
				$output .= '</div>';
			} else {
				$output .= '<div class="ts-advanced-google-map-settings-edit-marker">';
					if ($marker_style == "default") {
						$marker_icon			= TS_VCSC_GetResourceURL('images/defaults/default_mapmarker.png');
					} else if ($marker_style == "internal") {
						$marker_icon			= TS_VCSC_GetResourceURL('images/marker/' . $marker_internal);
					} else if ($marker_style == "image") {
						$marker_icon			= wp_get_attachment_image_src($markerimage, 'full');
						$marker_icon			= $marker_icon[0];
					}
					$output .= '<img class="ts-advanced-google-map-settings-edit-icon" src="' . $marker_icon . '">';
					$output .= '<div class="ts-advanced-google-map-settings-edit-excerpt">';
						$output .= 'Title: ' . ($marker_title != '' ? $marker_title : 'N/A') . '<br/>';
						$output .= 'Group: ' . ($marker_group != '' ? $marker_group : 'N/A') . '<br/>';
						if ($marker_position == 'address') {
							$output .= 'Address: ' . $marker_address . '<br/>';
						} else if ($marker_position == 'coordinates') {
							$output .= 'Coordinates: Latitude ' . $marker_latitude . ' / Longitude ' . $marker_longitude . '<br/>';
						}
					$output .= '</div>';
				$output .= '</div>';
			}
			
			echo $output;
			
			$myvariable 						= ob_get_clean();
			return $myvariable;
		}
		
		// Google Maps Overlay
		function TS_VCSC_GoogleMapsPlus_Overlay ($atts, $content = null) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();
			
			extract( shortcode_atts( array(
				// Overlay Settings
				'overlay_type'					=> 'circle', // circle, rectangle, polygon, polyline
				'overlay_title'					=> '',
				'overlay_group'					=> '',
				'overlay_include'				=> 'true',
				'overlay_popup'					=> 'false',
				'overlay_editable'				=> 'false',
				'overlay_output'				=> '',
				'overlay_draggable'				=> 'false',
				// Infowindow Button
				'overlay_link'					=> 'false',
				'overlay_url'					=> '',
				'overlay_button'				=> 'Learn More!',
				// Style Settings
				'style_stroke_rgba'				=> 'rgba(255, 0, 0, 1)',
				'style_stroke_weight'			=> 2,
				'style_fill_rgba'				=> 'rgba(255, 0, 0, 0.2)',
				// Circle Settings
				'circle_latitude'				=> '',
				'circle_longitude'				=> '',
				'circle_radius_miles'			=> 10,
				'circle_radius_feet'			=> 10000,
				'circle_radius_km'				=> 10,
				'circle_radius_meters'			=> 1000,				
				'circle_radius_unit'			=> 'miles',
				// Rectangle Settings
				'rectangle_nelatitude'			=> '',
				'rectangle_nelongitude'			=> '',
				'rectangle_swlatitude'			=> '',
				'rectangle_swlongitude'			=> '',
				// Polygon + Polyline Settings
				'polytype_input'				=> 'group',
				'polytype_coordinates'			=> '',
				'polytype_datasets'				=> '',
				// Other Settings
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			), $atts ));
			
			$map_random                    		= mt_rand(999999, 9999999);
			$map_valid							= "false";
			$output 							= '';
			$poly_coordinates					= '';
			
			// Check for Missing Location
			if (($overlay_type == "circle") && (($circle_latitude == "") || ($circle_longitude == ""))) {
				$map_valid						= "false";
			} else if (($overlay_type == "rectangle") && (($rectangle_nelatitude == "") || ($rectangle_nelongitude == "") || ($rectangle_swlatitude == "") || ($rectangle_swlongitude == ""))) {
				$map_valid						= "false";
			} else if ((($overlay_type == "polygon") || ($overlay_type == "polyline")) && ($polytype_coordinates == "") && ($polytype_input == "group")) {
				$map_valid						= "false";
			} else if ((($overlay_type == "polygon") || ($overlay_type == "polyline")) && ($polytype_datasets == "") && ($polytype_input == "exploded")) {
				$map_valid						= "false";
			} else {
				$map_valid						= "true";
			}
			if ($map_valid == "false") {
				echo $output;
				$myvariable 					= ob_get_clean();
				return $myvariable;
			}
			
			if (!empty($el_id)) {
				$overlay_id						= $el_id;
			} else {
				$overlay_id						= 'ts-advanced-google-map-overlay-single-' . $map_random;
			}

			// Link Values
			if ($overlay_link = "true") {
				$link 							= ($overlay_url == '||') ? '' : $overlay_url;
				$link 							= vc_build_link($link);
				$a_href							= $link['url'];
				$a_title 						= $link['title'];
				$a_target 						= $link['target'];
			} else {
				$a_href							= '';
				$a_title 						= '';
				$a_target 						= '';
			}
			
			// Adjust Circle Radius
			if ($overlay_type == "circle") {
				if ($circle_radius_unit == 'miles') {
					$circle_radius				= ($circle_radius_miles * 1000 * 1.609344001);
				} else if ($circle_radius_unit == 'feet') {
					$circle_radius				= ($circle_radius_feet / 3.2808399);
				} else if ($circle_radius_unit == 'kilometers') {
					$circle_radius				= ($circle_radius_km * 1000);
				} else if ($circle_radius_unit == 'meters') {
					$circle_radius				= $circle_radius_meters;
				}
			}
			
			// Process Group Values
			if (($overlay_type == "polygon" || $overlay_type == "polyline") && isset($polytype_coordinates) && strlen($polytype_coordinates) > 0 && ($polytype_input == "group")) {
				$coordinates 					= json_decode(urldecode($polytype_coordinates), true);
				if (is_array($coordinates)) {	
					foreach ((array) $coordinates as $key => $entry) {
						if (isset($entry['coordinates'])) {
							$poly_location      = esc_html($entry['coordinates']);
						}
						if (strlen($poly_location) != 0) {
							$poly_coordinates 	.= $poly_location . '/';
						}
					}
					$poly_coordinates 			= rtrim($poly_coordinates, '/');
				}
				$poly_coordinates				= preg_replace('/\s+/', '', $poly_coordinates);
			}
			
			// Process Exploded Textarea
			if (($overlay_type == "polygon" || $overlay_type == "polyline") && isset($polytype_datasets) && strlen($polytype_datasets) > 0 && ($polytype_input == "exploded")) {
				$coordinates 					= preg_replace('/,+/', ',', $polytype_datasets);
				$coordinates 					= explode(',', $polytype_datasets);
				if (is_array($coordinates)) {
					foreach ((array) $coordinates as $key => $entry) {
						$poly_coordinates 		.= str_replace('/', ',', $entry) . '/';
					}
					$poly_coordinates 			= rtrim($poly_coordinates, '/');
				}
				$poly_coordinates				= preg_replace('/\s+/', '', $poly_coordinates);
			}
			
			// Create Data Strings
			$data_style							= 'data-style-strokergba="' . $style_stroke_rgba . '" data-style-strokeweight="' . $style_stroke_weight . '" data-style-fillrgba="' . $style_fill_rgba . '"';
			$data_total							= 'data-id="map-overlay-single-' . $map_random . '" data-processed="false" data-popup="' . $overlay_popup . '" data-editable="' . $overlay_editable . '" data-output="' . $overlay_output . '" data-draggable="' . $overlay_draggable . '" data-group="' . $overlay_group . '" data-title="' . $overlay_title . '" data-overlay-type="' . $overlay_type . '" ' . $data_style . ' ';
			if ($overlay_type == "circle") {
				$data_total						.= 'data-circle-latitude="' . $circle_latitude . '" data-circle-longitude="' . $circle_longitude . '" data-circle-radius="' . $circle_radius . '" data-circle-unit="' . $circle_radius_unit . '"';
			} else if ($overlay_type == "rectangle") {
				$data_total						.= 'data-rectangle-swlatitude="' . $rectangle_swlatitude . '" data-rectangle-swlongitude="' . $rectangle_swlongitude . '" data-rectangle-nelatitude="' . $rectangle_nelatitude . '" data-rectangle-nelongitude="' . $rectangle_nelongitude . '"';
			} else if ($overlay_type == "polygon") {
				$data_total						.= 'data-polygon-coordinates="' . $poly_coordinates . '"';
			} else if ($overlay_type == "polyline") {
				$data_total						.= 'data-polyline-coordinates="' . $poly_coordinates . '"';
			}
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-advanced-google-map-overlay-single ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_GoogleMapsPlus_Overlay', $atts);
			} else {
				$css_class	= 'ts-advanced-google-map-overlay-single ' . $el_class;
			}
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
				$output .= '<div id="' . $overlay_id . '" class="' . $css_class . '" ' . $data_total . '>';
					if (($overlay_include == "true") && ($overlay_title != '')) {
						$output .= '<div class="ts-advanced-google-map-overlay-title">' . $overlay_title . '</div>';
					}
					if (($content != '') || (($overlay_link == "true") && ($a_href != ''))) {
						$output .= '<div class="ts-advanced-google-map-overlay-content">';
							if ($content != '') {
								$output .= do_shortcode($content);
							}
							if (($overlay_link == "true") && ($a_href != '')) {
								$output .= '<div class="ts-advanced-google-map-overlay-controls">';
									$output .= '<a class="ts-advanced-google-map-overlay-link" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '">' . $overlay_button . '</a>';
								$output .= '</div>';
							}
						$output .= '</div>';
					}
				$output .= '</div>';
			} else {
				$output .= '<div class="ts-advanced-google-map-settings-edit-overlay">';
					$output .= '<span style="font-weight: bold;">Overlay Type: ' . ucfirst($overlay_type) . '</span><br/>';
					$output .= 'Title: ' . ($overlay_title != '' ? $overlay_title : 'N/A') . '<br/>';
					$output .= 'Group: ' . ($overlay_group != '' ? $overlay_group : 'N/A') . '<br/>';
				$output .= '</div>';
			}
			
			echo $output;
			
			$myvariable 						= ob_get_clean();
			return $myvariable;
		}
		
		// Google Maps Container
		function TS_VCSC_GoogleMapsPlus_Container ($atts, $content = null) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();
			
			extract( shortcode_atts( array(
				// Main Settings
				'googlemap_api'					=> 'true',
				'googlemap_location'			=> 'false',
				'googlemap_openlayers'			=> 'true',
				'googlemap_listeners'			=> 'false',
				'googlemap_type'				=> 'ROAD',
				'googlemap_style'				=> 'style_default',
				'googlemap_resize'				=> '',
				'googlemap_height'				=> 450,
				'googlemap_street'				=> 450,
				'googlemap_delay'				=> 200,
				'googlemap_zoom'				=> 12,
				'googlemap_clusters'			=> 'false',				
				'googlemap_singleinfo'			=> 'true',
				'googlemap_metric'				=> 'false',
				'googlemap_tiles'				=> 'false',
				'googlemap_mobile'				=> 'false',
				'googlemap_full'				=> 'false',
				'googlemap_breaks'				=> 6,
				// Map Center
				'center_type'					=> 'markers',
				'center_address'				=> '',
				'center_latitude'				=> '',
				'center_longitude'				=> '',
				// Map Controls
				'controls_styler'				=> 'false',
				'controls_groups'				=> 'false',
				'controls_select'				=> 'false',
				'controls_search'				=> 'false',
				'controls_street'				=> 'true',
				'controls_scaler'				=> 'true',
				'controls_pan'					=> 'true',
				'controls_zoomer'				=> 'true',
				'controls_wheel'				=> 'true',
				'controls_types'				=> 'true',
				'controls_home'					=> 'true',
				// Draggable Breakpoint
				'draggable_allow'				=> 'toggle', // toggle, all, desktop, mobile, screen, none
				'draggable_width'				=> 480,
				// Layer Settings
				'layers_biking'					=> 'true',
				'layers_traffic'				=> 'true',
				'layers_transit'				=> 'false',
				// Language Settings
				'string_mobile_show'			=> 'Show Google Map',
				'string_mobile_hide'			=> 'Hide Google Map',
				'string_listeners_start'		=> 'Start Listeners',
				'string_listeners_stop'			=> 'Stop Listeners',
				'string_filter_all'				=> 'All Groups',
				'string_filter_label'			=> 'Filter by Groups',
				'string_select_label'			=> 'Zoom to Location',
				'string_style_default'			=> 'Google Standard',
				'string_style_label'			=> 'Change Map Style',
				'string_controls_osm'			=> 'Open Street',
				'string_controls_home'			=> 'Home',
				'string_controls_bike'			=> 'Bicycle Trails',
				'string_controls_traffic'		=> 'Traffic',
				'string_controls_transit'		=> 'Transit',
				'string_traffic_miles'			=> 'Miles per Hour',
				'string_traffic_kilometer'		=> 'Kilometers per Hour',
				'string_traffic_none'			=> 'No Data Available',
				'string_search_button'			=> 'Search Location',
				'string_search_holder'			=> 'Enter address to search for ...',
				'string_search_google'			=> 'View on Google Maps',
				'string_search_directions'		=> 'Get Directions',
				// Other Settings
				'margin_top'                    => 0,
				'margin_bottom'                 => 0,
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			), $atts ));
			
			$map_random                    		= mt_rand(999999, 9999999);			
			
			wp_enqueue_style('dashicons');
			wp_enqueue_style('ts-extend-sumo');
			wp_enqueue_script('ts-extend-sumo');
			wp_enqueue_style('ts-visual-composer-extend-front');
			wp_enqueue_script('ts-visual-composer-extend-front');
			wp_enqueue_style('ts-extend-googlemapsplus');
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
				if ($googlemap_api == "true") {
					if ($googlemap_location == "true") {
						wp_enqueue_script('ts-extend-mapapi-geo');
					} else {
						wp_enqueue_script('ts-extend-mapapi-none');
					}
				}
				if (($googlemap_clusters == "true") && ($content != '')) {
					wp_enqueue_script('ts-extend-markerclusterer');
				}
				wp_enqueue_script('ts-extend-googlemapsplus');
			}
			
			if (!empty($el_id)) {
				$map_id			    			= $el_id;
			} else {
				$map_id			    			= 'ts-advanced-google-map-container-' . $map_random;
			}			

			$output = '';
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-advanced-google-map-container ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_GoogleMapsPlus_Container', $atts);
			} else {
				$css_class	= 'ts-advanced-google-map-container ' . $el_class;
			}
			
			// Compile Main Data
			$map_data							= 'data-initialized="false" data-mapheight="' . $googlemap_height . '" data-singleinfo="' . $googlemap_singleinfo . '" data-listeners="' . $googlemap_listeners . '" data-delay="' . $googlemap_delay . '" data-mapsearch="' . $controls_search . '" data-activate="' . $googlemap_mobile . '" data-metric="' . $googlemap_metric . '" data-centertype="' . $center_type . '" data-latitude="' . ($center_type == 'coordinates' ? $center_latitude : '') . '" data-longitude="' . ($center_type == 'coordinates' ? $center_longitude : '') . '" data-address="' . ($center_type == 'address' ? $center_address : '') . '" data-zoom="' . $googlemap_zoom . '" data-maptype="' . $googlemap_type . '" data-mapstyle="' . $googlemap_style . '" data-openlayers="' . $googlemap_openlayers . '" data-mapclusters="' . $googlemap_clusters . '" data-mapresize="' . $googlemap_resize . '"';
			$map_controls						= 'data-controls-home="' . $controls_home . '" data-controls-types="' . $controls_types . '" data-controls-pan="' . $controls_pan . '" data-controls-zoomer="' . $controls_zoomer . '" data-controls-wheel="' . $controls_wheel . '" data-controls-styler="' . $controls_styler . '" data-controls-groups="' . $controls_groups . '" data-controls-select="' . $controls_select . '" data-controls-street="' . $controls_street . '" data-controls-scaler="' . $controls_scaler . '"';
			$map_draggable						= 'data-draggable-allow="' . $draggable_allow . '" data-draggable-width="' . $draggable_width . '"';
			$map_layers							= 'data-layers-biking="' . $layers_biking . '" data-layers-traffic="' . $layers_traffic . '" data-layers-transit="' . $layers_transit . '"';
			$map_fullwidth						= 'data-fullwidth="' . $googlemap_full . '" data-break-parents="' . $googlemap_breaks . '"';
			
			// Compile Language Settings
			$map_language						= '';			
			$map_language						.= 'data-string-mobileshow="' . $string_mobile_show . '" data-string-mobilehide="' . $string_mobile_hide . '" data-string-listenersstart="' . $string_listeners_start . '" data-string-listenersstop="' . $string_listeners_stop . '" ';
			$map_language						.= 'data-string-filterall="' . $string_filter_all . '" data-string-filterlabel="' . $string_filter_label . '" data-string-selectlabel="' . $string_select_label . '" ';	
			$map_language						.= 'data-string-styledefault="' . $string_style_default . '" data-string-stylelabel="' . $string_style_label . '" ';
			$map_language						.= 'data-string-controlsosm="' . $string_controls_osm . '" data-string-controlshome="' . $string_controls_home . '" data-string-controlsbike="' . $string_controls_bike . '" data-string-controlstraffic="' . $string_controls_traffic . '" data-string-controlstransit="' . $string_controls_transit . '" ';
			$map_language 						.= 'data-string-trafficmiles="' . $string_traffic_miles . '" data-string-traffickilometers="' . $string_traffic_kilometer . '" data-string-trafficnone="' . $string_traffic_none . '" ';
			$map_language 						.= 'data-string-searchbutton="' . $string_search_button . '" data-string-searchholder="' . $string_search_holder . '" data-string-searchgoogle="' . $string_search_google . '" data-string-searchdirect="' . $string_search_directions . '"';

			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
				$output .= '<div id="' . $map_id . '" class="' . $css_class . '" data-random="' . $map_random . '" ' . $map_fullwidth . ' style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
					$output .= '<div id="ts-advanced-google-map-contents-' . $map_random . '" class="ts-advanced-google-map-contents" style="display: none;">';
						$output .= do_shortcode($content);
					$output .= '</div>';
					$output .= '<div id="ts-advanced-google-map-controls-' . $map_random . '" class="ts-advanced-google-map-controls"></div>';
					$output .= '<div id="ts-advanced-google-map-directions-' . $map_random . '" class="ts-advanced-google-map-directions" style="display: none;"></div>';
					if ($googlemap_listeners == "true") {
						$output .= '<div id="ts-advanced-google-map-listeners-' . $map_random . '" class="ts-advanced-google-map-listeners" style="display: block;" data-visible="true">';					
							$output .= '<table id="ts-advanced-google-map-listeners-details-' . $map_random . '" class="ts-advanced-google-map-listeners-details"><tbody>
								<tr>
									<td width="120">Mouse Position:</td>
									<td width="200" id="d_mouseLatLon" class="ts-advanced-google-map-listeners-details-mouseposition">N/A</td>
									<td width="40">&nbsp;</td>
									<td width="120">Map Center:</td>
									<td width="200" id="d_mapcenter" class="ts-advanced-google-map-listeners-details-mapcenter">N/A</td>
								</tr>
								<tr>
									<td>Mouse Tile:</td>
									<td class="ts-advanced-google-map-listeners-details-mousetile">N/A</td>
									<td></td>
									<td>Map NE:</td>
									<td class="ts-advanced-google-map-listeners-details-mapnortheast">N/A</td>
								</tr>
								<tr>
									<td>Mouse Pixels:</td>
									<td class="ts-advanced-google-map-listeners-details-mousepixels">N/A</td>
									<td></td>
									<td>Map SW:</td>
									<td class="ts-advanced-google-map-listeners-details-mapsouthwest">N/A</td>
								</tr>
								<tr>
									<td>Mouse Click Coordinates:</td>
									<td class="ts-advanced-google-map-listeners-details-mouseclick">N/A</td>
									<td></td>
									<td>Map Zoom:</td>
									<td class="ts-advanced-google-map-listeners-details-mapzoom">N/A</td>
								<tr>
									<td>Mouse Click Address (Approximated):</td>
									<td colspan="4" class="ts-advanced-google-map-listeners-details-mouseaddress">N/A</td>
								</tr>								
							</tbody></table>';					
						$output .= '</div>';
					}
					$output .= '<div id="ts-advanced-google-map-streetview-' . $map_random . '" class="ts-advanced-google-map-streetview" style="display: none; height: ' . $googlemap_street . 'px;"></div>';
					$output .= '<div id="ts-advanced-google-map-wrapper-' . $map_random . '" class="ts-advanced-google-map-wrapper ' . ($googlemap_tiles == 'true' ? 'ts-advanced-google-map-tiled' : '') . '" style="height: ' . $googlemap_height . 'px;" ' . $map_data . ' ' . $map_controls . ' ' . $map_layers . ' ' . $map_draggable . ' ' . $map_language . '></div>';
				$output .= '</div>';
			} else {
				$output .= '<div id="' . $map_id . '" class="ts-advanced-google-map-container-edit" style="margin-top: 40px; margin-bottom: 40px;">';
					$output .= '<div class="ts-advanced-google-map-settings-edit-main">';
						$output .= '<img class="ts-advanced-google-map-settings-edit-image" src="' . TS_VCSC_GetResourceURL('images/defaults/default_googlemap.jpg') . '">';
						$output .= '<div class="ts-advanced-google-map-settings-edit-values">';
							$output .= 'Map Type: ' . $googlemap_type . '<br/>';
							$output .= 'Map Height: ' . $googlemap_height . 'px<br/>';
							$output .= 'Initial Zoom: ' . $googlemap_zoom . '<br/>';
							if ($center_type == 'coordinates') {
								$output .= 'Map Center (Coordinates): Latitude ' . ($center_latitude != '' ? $center_latitude : 'N/A') . ' / Longitude ' . ($center_longitude != '' ? $center_longitude : 'N/A') . '<br/>';								
							} else if ($center_type == 'address') {
								$output .= 'Map Center (Address): ' . ($center_address != '' ? $center_address : 'N/A') . '<br/>';
							} else if ($center_type == 'markers') {
								$output .= 'Map Center: Set automatically based on map markers.';
							}
						$output .= '</div>';
					$output .= '</div>';
					$output .= '<div class="ts-advanced-google-map-settings-edit-content">';
						$output .= do_shortcode($content);
					$output .= '</div>';
				$output .= '</div>';
			}
			
			echo $output;
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
	
		// Add Google Maps Elements
        function TS_VCSC_Add_GoogleMapsPlus_Elements() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			// Add Google Maps Marker
			if (function_exists('vc_map')) {
				vc_map( array(
					"name"                      	=> __( "TS Google Maps Marker", "ts_visual_composer_extend" ),
					"base"                      	=> "TS_VCSC_GoogleMapsPlus_Marker",
					"icon" 	                    	=> "icon-wpb-ts_vcsc_google_maps_marker",
					"class"                     	=> "",
					"content_element"               => true,
					"as_child"                      => array('only' => 'TS_VCSC_GoogleMapsPlus_Container'),
					"description"               	=> __("Place a marker to this Google Map", "ts_visual_composer_extend"),
					"category"                  	=> __( 'VC Extensions', "ts_visual_composer_extend" ),
					"admin_enqueue_js"        		=> "",
					"admin_enqueue_css"       		=> "",
					"front_enqueue_js"				=> "",
					"front_enqueue_css"				=> "",
					"params"                    	=> array(
						// Marker Location
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_1",
							"value"					=> "",
							"seperator"				=> "Marker Location",
							"description"       	=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Marker Title", "ts_visual_composer_extend" ),
							"param_name"            => "marker_title",
							"value"                 => "",
							"admin_label"           => true,
							"description"	        => __( "Please provide a title for the infowindow."),
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Marker Group", "ts_visual_composer_extend" ),
							"param_name"            => "marker_group",
							"value"                 => "",
							"admin_label"           => true,
							"description"	        => __( "Optionally, please provide the name of a group (single) this marker belongs to."),
						),
						array(
							"type"			        => "dropdown",
							"class"			        => "",
							"heading"               => __( "Marker Location", "ts_visual_composer_extend" ),
							"param_name"            => "marker_position",
							"value"			        => array(
								__( "Coordinates", "ts_visual_composer_extend")           	=> "coordinates",
								__( "Address", "ts_visual_composer_extend" )        		=> "address",
							),
							"description"           => __( "Please define how you want to provide the location for this marker.", "ts_visual_composer_extend" ),
						),						
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Marker Latitude", "ts_visual_composer_extend" ),
							"param_name"            => "marker_latitude",
							"value"                 => "",
							"admin_label"           => true,
							"description"	        => __( "Please provide the latitude for the map marker."),
							"dependency"            => array( 'element' => "marker_position", 'value' => 'coordinates' ),
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Marker Longitude", "ts_visual_composer_extend" ),
							"param_name"            => "marker_longitude",
							"value"                 => "",
							"admin_label"           => true,
							"description"	        => __( "Please provide the longitude for the map marker."),
							"dependency"            => array( 'element' => "marker_position", 'value' => 'coordinates' ),
						),						
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Marker Address", "ts_visual_composer_extend" ),
							"param_name"            => "marker_address",
							"value"                 => "",
							"admin_label"           => true,
							"description"	        => __( "Please provide the address for the map marker."),
							"dependency"            => array( 'element' => "marker_position", 'value' => 'address' ),
						),
						array(
							"type"              	=> "switch_button",
							"heading"               => __( "Trigger Streetview", "ts_visual_composer_extend" ),
							"param_name"            => "marker_streetview",
							"value"                 => "false",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"description"           => __( "Switch the toggle if clicking the marker should also open a streetview, along with the optional infowindow.", "ts_visual_composer_extend" ),
						),
						// Marker Content
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_2",
							"value"					=> "",
							"seperator"				=> "Infowindow Content",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"group"					=> "Marker Infowindow",
						),
						array(
							"type"              	=> "switch_button",
							"heading"               => __( "Auto-Show Infowindow", "ts_visual_composer_extend" ),
							"param_name"            => "marker_popup",
							"value"                 => "false",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"description"           => __( "Switch the toggle if the infowindow should be shown automatically after the map has been rendered; should not be used when marker clustering is enabled and limit to one such popup per map.", "ts_visual_composer_extend" ),
							"group"					=> "Marker Infowindow",
						),
						array(
							"type"              	=> "switch_button",
							"heading"               => __( "Show Title in InfoWindow", "ts_visual_composer_extend" ),
							"param_name"            => "marker_include",
							"value"                 => "true",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"description"           => __( "Switch the toggle if the marker title should also be shown in the infowindow.", "ts_visual_composer_extend" ),
							"group"					=> "Marker Infowindow",
						),
						array(
							"type"		            => "textarea_html",
							"class"					=> "",
							"heading"               => __( "Marker Content", "ts_visual_composer_extend" ),
							"param_name"            => "content",
							"value"                 => "",
							"admin_label"			=> false,
							"description"           => __( "Enter the infowindow content but keep its limited size on the map in mind.", "ts_visual_composer_extend" ),
							"group"					=> "Marker Infowindow",
						),
						// Infowindow Buttons
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_3",
							"value"					=> "",
							"seperator"				=> "Infowindow Buttons",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"group"					=> "Marker Infowindow",
						),
						array(
							"type"              	=> "switch_button",
							"heading"               => __( "Show Directions Button", "ts_visual_composer_extend" ),
							"param_name"            => "marker_directions",
							"value"                 => "false",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"description"           => __( "Switch the toggle if you want to show a link to generate directions inside the infowindow.", "ts_visual_composer_extend" ),
							"group"					=> "Marker Infowindow",
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Button Text", "ts_visual_composer_extend" ),
							"param_name"            => "marker_directions_text",
							"value"                 => "Get Directions",
							"description"	        => __( "Please provide the text string for the directions link button inside the infowindow."),
							"dependency"            => array( 'element' => "marker_directions", 'value' => 'true' ),
							"group"					=> "Marker Infowindow",
						),	
						array(
							"type"              	=> "switch_button",
							"heading"               => __( "Show Google Button", "ts_visual_composer_extend" ),
							"param_name"            => "marker_viewer",
							"value"                 => "false",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"description"           => __( "Switch the toggle if you want to show a link to view the marker on an official Google map.", "ts_visual_composer_extend" ),
							"group"					=> "Marker Infowindow",
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Button Text", "ts_visual_composer_extend" ),
							"param_name"            => "marker_viewer_text",
							"value"                 => "View on Google Maps",
							"description"	        => __( "Please provide the text string for the Google link button inside the infowindow."),
							"dependency"            => array( 'element' => "marker_viewer", 'value' => 'true' ),
							"group"					=> "Marker Infowindow",
						),	
						array(
							"type"              	=> "switch_button",
							"heading"               => __( "Show Extra Button", "ts_visual_composer_extend" ),
							"param_name"            => "marker_link",
							"value"                 => "false",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"description"           => __( "Switch the toggle if you want to provide another custom link button inside the infowindow.", "ts_visual_composer_extend" ),
							"group"					=> "Marker Infowindow",
						),
						array(
							"type" 					=> "vc_link",
							"heading" 				=> __("Link + Title", "ts_visual_composer_extend"),
							"param_name" 			=> "marker_url",
							"description" 			=> __("Provide an optional link to another site/page, to be used for the extra button inside the infowindow.", "ts_visual_composer_extend"),
							"dependency"            => array( 'element' => "marker_link", 'value' => 'true' ),
							"group"					=> "Marker Infowindow",
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Button Text", "ts_visual_composer_extend" ),
							"param_name"            => "marker_button",
							"value"                 => "Learn More!",
							"description"	        => __( "Please provide the text string for the extra link button inside the infowindow."),
							"dependency"            => array( 'element' => "marker_link", 'value' => 'true' ),
							"group"					=> "Marker Infowindow",
						),						
						// Marker Style
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_4",
							"value"					=> "",
							"seperator"				=> "Marker Settings",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"group"					=> "Marker Style",
						),
						array(
							"type"			        => "dropdown",
							"class"			        => "",
							"heading"               => __( "Marker Style", "ts_visual_composer_extend" ),
							"param_name"            => "marker_style",
							"value"			        => array(
								__( "Google Default", "ts_visual_composer_extend")           => "default",
								__( "Marker Selection", "ts_visual_composer_extend" )        => "internal",
								__( "Custom Image", "ts_visual_composer_extend" )            => "image",
							),
							"description"           => __( "", "ts_visual_composer_extend" ),
							"group"					=> "Marker Style",
						),
						array(
							"type"                  => "attach_image",
							"heading"               => __( "Custom Marker Image", "ts_visual_composer_extend" ),
							"param_name"            => "marker_image",
							"value"                 => "",
							"description"           => __( "Select the image you want to use as marker; should have a maximum equal dimension of 64x64.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "marker_style", 'value' => 'image' ),
							"group"					=> "Marker Style",
						),
						array(
							"type"		            => "mapmarker",
							"class"		            => "",
							"heading"               => __( "Map Marker", "ts_visual_composer_extend" ),
							"param_name"            => "marker_internal",
							"value"                 => "",
							"description"	        => __( "", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "marker_style", 'value' => 'internal' ),
							"group"					=> "Marker Style",
						),
						array(
							"type"              	=> "switch_button",
							"heading"               => __( "Marker Animation", "ts_visual_composer_extend" ),
							"param_name"            => "marker_animation",
							"value"                 => "false",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"description"           => __( "Switch the toggle if you want to animate the marker when it enters the map.", "ts_visual_composer_extend" ),
							"group"					=> "Marker Style",
						),
						array(
							"type"			        => "dropdown",
							"class"			        => "",
							"heading"               => __( "Animation Type", "ts_visual_composer_extend" ),
							"param_name"            => "marker_entry",
							"value"			        => array(
								__( "Drop", "ts_visual_composer_extend")                 => "drop",
								__( "Bounce", "ts_visual_composer_extend" )              => "bounce",
							),
							"description"           => __( "Select the type of animation the marker should have when it enters the map.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "marker_animation", 'value' => 'true' ),
							"group"					=> "Marker Style",
						),						
						// Load Custom CSS/JS File
						array(
							"type"              	=> "load_file",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "el_file",
							"value"             	=> "",
							"file_type"         	=> "js",
							"file_path"         	=> "js/ts-visual-composer-extend-element.min.js",
							"description"       	=> __( "", "ts_visual_composer_extend" )
						),
					))
				);
			}
			// Add Google Maps Overlay
			if (function_exists('vc_map')) {
				vc_map( array(
					"name"                      	=> __( "TS Google Maps Overlay", "ts_visual_composer_extend" ),
					"base"                      	=> "TS_VCSC_GoogleMapsPlus_Overlay",
					"icon" 	                    	=> "icon-wpb-ts_vcsc_google_maps_overlay",
					"class"                     	=> "",
					"content_element"               => true,
					"as_child"                      => array('only' => 'TS_VCSC_GoogleMapsPlus_Container'),
					"description"               	=> __("Place an overlay to this Google Map", "ts_visual_composer_extend"),
					"category"                  	=> __( 'VC Extensions', "ts_visual_composer_extend" ),
					"admin_enqueue_js"        		=> "",
					"admin_enqueue_css"       		=> "",
					"front_enqueue_js"				=> "",
					"front_enqueue_css"				=> "",
					"params"                    	=> array(
						// Overlay Settings
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_1",
							"value"					=> "",
							"seperator"				=> "Overlay Settings",
							"description"       	=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"					=> "dropdown",
							"heading"				=> __( "Overlay Type", "ts_visual_composer_extend" ),
							"param_name"			=> "overlay_type",
							"value"					=> array(
								"Circle"						=> "circle",
								"Rectangle"						=> "rectangle",
								"Polygon"						=> "polygon",
								"Polyline"						=> "polyline",
							),
							"admin_label"			=> true,
							"description"			=> __( "Select what type of overlay you want to create.", "ts_visual_composer_extend" ),							
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Overlay Title", "ts_visual_composer_extend" ),
							"param_name"            => "overlay_title",
							"value"                 => "",
							"admin_label"           => true,
							"description"	        => __( "Please provide a title for the infowindow."),
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Overlay Group", "ts_visual_composer_extend" ),
							"param_name"            => "overlay_group",
							"value"                 => "",
							"admin_label"           => true,
							"description"	        => __( "Optionally, please provide the name of a group (single) this overlay belongs to."),
						),	
						// Circle Settings
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_2",
							"value"					=> "",
							"seperator"				=> "Circle Settings",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "overlay_type", 'value' => 'circle' ),
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Circle Latitude", "ts_visual_composer_extend" ),
							"param_name"            => "circle_latitude",
							"value"                 => "",
							"description"	        => __( "Please provide the latitude for the circle center."),
							"dependency"            => array( 'element' => "overlay_type", 'value' => 'circle' ),
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Circle Longitude", "ts_visual_composer_extend" ),
							"param_name"            => "circle_longitude",
							"value"                 => "",
							"description"	        => __( "Please provide the longitude for the circle center."),
							"dependency"            => array( 'element' => "overlay_type", 'value' => 'circle' ),
						),
						array(
							"type"					=> "dropdown",
							"heading"				=> __( "Radius Unit", "ts_visual_composer_extend" ),
							"param_name"			=> "circle_radius_unit",
							"value"					=> array(
								"Miles"						=> "miles",
								"Feet"						=> "feet",
								"Meters"					=> "meters",
								"Kilometers"				=> "kilometers",
							),
							"admin_label"			=> true,
							"description"			=> __( "Select what unit you want to apply to the circle radius.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "overlay_type", 'value' => 'circle' ),
						),
						array(
							"type"              	=> "nouislider",
							"heading"           	=> __( "Circle Radius", "ts_visual_composer_extend" ),
							"param_name"        	=> "circle_radius_miles",
							"value"             	=> "10",
							"min"               	=> "1",
							"max"               	=> "500",
							"step"              	=> "1",
							"unit"              	=> 'Mi',
							"description"       	=> __( "Define the radius for the circle overlay.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "circle_radius_unit", 'value' => 'miles' ),
						),
						array(
							"type"              	=> "nouislider",
							"heading"           	=> __( "Circle Radius", "ts_visual_composer_extend" ),
							"param_name"        	=> "circle_radius_feet",
							"value"             	=> "10000",
							"min"               	=> "1",
							"max"               	=> "100000",
							"step"              	=> "100",
							"unit"              	=> 'ft',
							"description"       	=> __( "Define the radius for the circle overlay.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "circle_radius_unit", 'value' => 'feet' ),
						),
						array(
							"type"              	=> "nouislider",
							"heading"           	=> __( "Circle Radius", "ts_visual_composer_extend" ),
							"param_name"        	=> "circle_radius_km",
							"value"             	=> "10",
							"min"               	=> "1",
							"max"               	=> "1000",
							"step"              	=> "1",
							"unit"              	=> 'KM',
							"description"       	=> __( "Define the radius for the circle overlay.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "circle_radius_unit", 'value' => 'kilometers' ),
						),
						array(
							"type"              	=> "nouislider",
							"heading"           	=> __( "Circle Radius", "ts_visual_composer_extend" ),
							"param_name"        	=> "circle_radius_meters",
							"value"             	=> "1000",
							"min"               	=> "1",
							"max"               	=> "10000",
							"step"              	=> "10",
							"unit"              	=> 'm',
							"description"       	=> __( "Define the radius for the circle overlay.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "circle_radius_unit", 'value' => 'meters' ),
						),
						// Rectangle Settings
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_3",
							"value"					=> "",
							"seperator"				=> "Rectangle North-East (Upper Right) Settings",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "overlay_type", 'value' => 'rectangle' ),
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "North-East Latitude", "ts_visual_composer_extend" ),
							"param_name"            => "rectangle_nelatitude",
							"value"                 => "",
							"description"	        => __( "Please provide the north-east latitude for the rectangle (upper right corner)."),
							"dependency"            => array( 'element' => "overlay_type", 'value' => 'rectangle' ),
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "North-East Longitude", "ts_visual_composer_extend" ),
							"param_name"            => "rectangle_nelongitude",
							"value"                 => "",
							"description"	        => __( "Please provide the north-east longitude for the rectangle (upper right corner)."),
							"dependency"            => array( 'element' => "overlay_type", 'value' => 'rectangle' ),
						),						
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_4",
							"value"					=> "",
							"seperator"				=> "Rectangle South-West (Lower Left) Settings",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "overlay_type", 'value' => 'rectangle' ),
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "South-West Latitude", "ts_visual_composer_extend" ),
							"param_name"            => "rectangle_swlatitude",
							"value"                 => "",
							"description"	        => __( "Please provide the south-west latitude for the rectangle (lower left corner)."),
							"dependency"            => array( 'element' => "overlay_type", 'value' => 'rectangle' ),
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "South-West Longitude", "ts_visual_composer_extend" ),
							"param_name"            => "rectangle_swlongitude",
							"value"                 => "",
							"description"	        => __( "Please provide the south-west longitude for the rectangle (lower left corner)."),
							"dependency"            => array( 'element' => "overlay_type", 'value' => 'rectangle' ),
						),
						// Polygon + Polyline Group
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_5",
							"value"					=> "",
							"seperator"				=> "Poly-Object Settings",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "overlay_type", 'value' => array('polygon', 'polyline') ),
						),						
						array(
							"type"					=> "dropdown",
							"heading"				=> __( "Coordinates Input", "ts_visual_composer_extend" ),
							"param_name"			=> "polytype_input",
							"value"					=> array(
								"Repeatable Group Entry"		=> "group",
								"Quick Entry (Line Break)"		=> "exploded",
							),
							"dependency"			=> array( 'element' => "overlay_type", 'value' => array('polygon', 'polyline')),
							"description"			=> __( "Select how you want to provide the coordinates for hte polygon or polyline.", "ts_visual_composer_extend" ),							
						),						
						array(
							'type'					=> 'param_group',
							'heading'				=> __( 'Polygon + Polyline Coordinates', 'ts_visual_composer_extend' ),
							'param_name'			=> 'polytype_coordinates',
							'description'			=> __( 'Enter at least three coordinates for a polygon or two for a polyline, using the repeatable group below.', 'ts_visual_composer_extend' ),
							'save_always'			=> true,
							'value'					=> urlencode(json_encode(array(
								array(
									'coordinates' 				=> '',
								),
							))),
							'params'				=> array(
								array(
									'type' 						=> 'textfield',
									'heading' 					=> __( 'Latitude / Longitude', 'ts_visual_composer_extend' ),
									'param_name' 				=> 'coordinates',
									'description' 				=> __( 'Enter the coordinates (latitude + latitude; separated by comma) of this location in the polygon or polyline.', 'ts_visual_composer_extend' ),
									'admin_label' 				=> true,
								),
							),
							"dependency"			=> array( 'element' => "polytype_input", 'value' => 'group'),
						),
						array(
							"type"                  => "exploded_textarea",
							"heading"               => __( "Polygon + Polyline Coordinates", "ts_visual_composer_extend" ),
							"param_name"            => "polytype_datasets",
							"value"                 => "",
							"description"           => __( "Enter the coordinate sets like '52.49477475/13.52567196' (Latitude/Longitude); separate individual coordinate sets by line break and do not use commas.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "polytype_input", 'value' => 'exploded'),
						),
						// Overlay Style
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_6",
							"value"					=> "",
							"seperator"				=> "Overlay Style",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"group"					=> "Overlay Style",
						),
						array(
							"type"              	=> "nouislider",
							"heading"           	=> __( "Stroke Strength", "ts_visual_composer_extend" ),
							"param_name"        	=> "style_stroke_weight",
							"value"             	=> "2",
							"min"               	=> "1",
							"max"               	=> "10",
							"step"              	=> "1",
							"unit"              	=> 'px',
							"description"       	=> __( "Define the stroke strength of the overlay outline.", "ts_visual_composer_extend" ),
							"group"					=> "Overlay Style",
						),
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Stroke Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "style_stroke_rgba",
							"value"             	=> "rgba(255, 0, 0, 1)",
							"description"       	=> __( "Define the stroke color for the overlay outline.", "ts_visual_composer_extend" ),
							"dependency"        	=> "",
							"group"					=> "Overlay Style",
						),		
						array(
							"type"              	=> "colorpicker",
							"heading"           	=> __( "Fill Color", "ts_visual_composer_extend" ),
							"param_name"        	=> "style_fill_rgba",
							"value"             	=> "rgba(255, 0, 0, 0.2)",
							"description"       	=> __( "Define the fill color for the overlay.", "ts_visual_composer_extend" ),
							"dependency"        	=> "",
							"dependency"			=> array( 'element' => "overlay_type", 'value' => array('circle', 'rectangle', 'polygon')),
							"group"					=> "Overlay Style",
						),						
						// Infowindow Content
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_7",
							"value"					=> "",
							"seperator"				=> "Overlay Content",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "overlay_type", 'value' => array('circle', 'rectangle', 'polygon', 'polyline')),
							"group"					=> "Overlay Infowindow",
						),
						array(
							"type"              	=> "switch_button",
							"heading"               => __( "Show Infowindow", "ts_visual_composer_extend" ),
							"param_name"            => "overlay_popup",
							"value"                 => "false",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"description"           => __( "Switch the toggle if the infowindow should be shown automatically after the map has been rendered; should not be used when marker clustering is enabled and limit to one such popup per map.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "overlay_type", 'value' => array('circle', 'rectangle', 'polygon', 'polyline')),
							"group"					=> "Overlay Infowindow",
						),
						array(
							"type"		            => "textarea_html",
							"class"					=> "",
							"heading"               => __( "Overlay Content", "ts_visual_composer_extend" ),
							"param_name"            => "content",
							"value"                 => "",
							"admin_label"			=> false,
							"description"           => __( "Enter the infowindow content but keep its limited size on the map in mind.", "ts_visual_composer_extend" ),
							"dependency"			=> array( 'element' => "overlay_type", 'value' => array('circle', 'rectangle', 'polygon', 'polyline')),
							"group"					=> "Overlay Infowindow",
						),
						// Infowindow Button
						array(
							"type"              	=> "switch_button",
							"heading"               => __( "Show Extra Button", "ts_visual_composer_extend" ),
							"param_name"            => "overlay_link",
							"value"                 => "false",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"description"           => __( "Switch the toggle if you want to provide another custom link button inside the infowindow.", "ts_visual_composer_extend" ),
							"group"					=> "Overlay Infowindow",
						),
						array(
							"type" 					=> "vc_link",
							"heading" 				=> __("Link + Title", "ts_visual_composer_extend"),
							"param_name" 			=> "overlay_url",
							"description" 			=> __("Provide an optional link to another site/page, to be used for the extra button inside the infowindow.", "ts_visual_composer_extend"),
							"dependency"            => array( 'element' => "overlay_link", 'value' => 'true' ),
							"group"					=> "Overlay Infowindow",
						),
						array(
							"type"		            => "textfield",
							"class"		            => "",
							"heading"               => __( "Button Text", "ts_visual_composer_extend" ),
							"param_name"            => "overlay_button",
							"value"                 => "Learn More!",
							"description"	        => __( "Please provide the text string for the extra link button inside the infowindow."),
							"dependency"            => array( 'element' => "overlay_link", 'value' => 'true' ),
							"group"					=> "Overlay Infowindow",
						),			
						// Other Settings
						array(
							"type"              	=> "seperator",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "seperator_8",
							"value"					=> "",
							"seperator"				=> "Other Settings",
							"description"       	=> __( "", "ts_visual_composer_extend" ),
							"group"					=> "Other Settings",
						),
						array(
							"type"              	=> "switch_button",
							"heading"               => __( "Overlay Draggable", "ts_visual_composer_extend" ),
							"param_name"            => "overlay_draggable",
							"value"                 => "false",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"admin_label"			=> true,
							"description"           => __( "Switch the toggle if the overlay should be made draggable on the map.", "ts_visual_composer_extend" ),
							"group"					=> "Other Settings",
						),
						array(
							"type"              	=> "switch_button",
							"heading"               => __( "Overlay Editable", "ts_visual_composer_extend" ),
							"param_name"            => "overlay_editable",
							"value"                 => "false",
							"on"					=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"					=> __( 'No', "ts_visual_composer_extend" ),
							"style"					=> "select",
							"design"				=> "toggle-light",
							"admin_label"			=> true,
							"description"           => __( "Switch the toggle if the overlay should be made editable on the map.", "ts_visual_composer_extend" ),
							"group"					=> "Other Settings",
						),						
						array(
							"type"					=> "dropdown",
							"heading"				=> __( "Output Edit Changes", "ts_visual_composer_extend" ),
							"param_name"			=> "overlay_output",
							"value"					=> array(
								"None"							=> "",
								"Console Log"					=> "rectangle",
								"Info Window"					=> "popup",
							),							
							"description"			=> __( "Select if and how any relevant changes to the overlay should be communicated after editing.", "ts_visual_composer_extend" ),
							"dependency"            => array( 'element' => "overlay_editable", 'value' => 'true' ),
							"group"					=> "Other Settings",
						),				
						// Load Custom CSS/JS File
						array(
							"type"              	=> "load_file",
							"heading"           	=> __( "", "ts_visual_composer_extend" ),
							"param_name"        	=> "el_file",
							"value"             	=> "",
							"file_type"         	=> "js",
							"file_path"         	=> "js/ts-visual-composer-extend-element.min.js",
							"description"       	=> __( "", "ts_visual_composer_extend" )
						),
					))
				);
			}
			// Add Google Maps Container
			if (function_exists('vc_map')) {
				vc_map(array(
					"name"                              => __("TS Google Maps PLUS", "ts_visual_composer_extend"),
					"base"                              => "TS_VCSC_GoogleMapsPlus_Container",
					"class"                             => "",
					"icon"                              => "icon-wpb-ts_vcsc_google_maps_container",
					"category"                          => __("VC Extensions", "ts_visual_composer_extend"),
					"as_parent"                         => array('only' => 'TS_VCSC_GoogleMapsPlus_Marker,TS_VCSC_GoogleMapsPlus_Overlay'),
					"description"                       => __("Create an advanced Google Map", "ts_visual_composer_extend"),
					"js_view"                           => "VcColumnView",
					"controls" 							=> "full",
					"content_element"                   => true,
					"is_container" 						=> true,
					"container_not_allowed" 			=> false,
					"show_settings_on_create"           => true,
					"admin_enqueue_js"        			=> "",
					"admin_enqueue_css"       			=> "",
					"front_enqueue_js"					=> "",
					"front_enqueue_css"					=> "",
					"params"                            => array(
						// Map Settings
						array(
							"type"                      => "seperator",
							"heading"                   => __( "", "ts_visual_composer_extend" ),
							"param_name"                => "seperator_1",
							"value"						=> "",
							"seperator"                 => "Map Settings",
							"description"               => __( "", "ts_visual_composer_extend" ),
						),						
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Map Listeners Panel", "ts_visual_composer_extend" ),
							"param_name"            	=> "googlemap_listeners",
							"value"                 	=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want to show a panel that provides map and mouse status information; useful for creating the map and finding locations, but should not be used for public map due to extensive listener events.", "ts_visual_composer_extend" ),
						),						
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Show Map Tiles", "ts_visual_composer_extend" ),
							"param_name"            	=> "googlemap_tiles",
							"value"                 	=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want to show the outline of the individual tiles that make up the map", "ts_visual_composer_extend" ),
						),						
						array(
							"type"                  	=> "dropdown",
							"class"                 	=> "",
							"heading"               	=> __("Map Type", "ts_visual_composer_extend"),
							"param_name"            	=> "googlemap_type",
							"admin_label"           	=> true,
							"value"                 	=> array(
								__("Road Map", "ts_visual_composer_extend")                  => "ROADMAP",
								__("Satellite Map", "ts_visual_composer_extend")             => "SATELLITE",
								__("Hybrid Map", "ts_visual_composer_extend")                => "HYBRID",
								__("Terrain Map", "ts_visual_composer_extend")               => "TERRAIN",
								__("Open Street Map", "ts_visual_composer_extend")           => "OSM",
							),
							"description"           	=> __( "Select the map type the map should initially be shown with.", "ts_visual_composer_extend" )
						),
						array(
							"type"			        	=> "dropdown",
							"class"			        	=> "",
							"heading"               	=> __( "Road Map Style", "ts_visual_composer_extend" ),
							"param_name"            	=> "googlemap_style",
							"admin_label"           	=> true,
							"value"			        	=> array(
								__( "Default", "ts_visual_composer_extend") 				=> "style_default",
								__( "Apple Maps-Esque", "ts_visual_composer_extend") 		=> "style_apple_mapsesque",
								__( "Avocado World", "ts_visual_composer_extend") 			=> "style_avocado_world",
								__( "Become A Dinosaur", "ts_visual_composer_extend") 		=> "style_become_dinosaur",
								__( "Bentley", "ts_visual_composer_extend") 				=> "style_bentley",
								__( "Black And White", "ts_visual_composer_extend") 		=> "style_black_white",
								__( "Blue Essence", "ts_visual_composer_extend") 			=> "style_blue_essence",
								__( "Blue Gray", "ts_visual_composer_extend") 				=> "style_blue_gray",
								__( "Blue Water", "ts_visual_composer_extend") 				=> "style_blue_water",
								__( "Bright & Bubbly", "ts_visual_composer_extend") 		=> "style_bright_bubbly",
								__( "Clean Cut", "ts_visual_composer_extend") 				=> "style_clean_cut",
								__( "Cobalt", "ts_visual_composer_extend") 					=> "style_cobalt",
								__( "Cool Gray", "ts_visual_composer_extend") 				=> "style_cool_gray",
								__( "Countries", "ts_visual_composer_extend") 				=> "style_countries",
								__( "Flat Green", "ts_visual_composer_extend") 				=> "style_flat_green",
								__( "Flat Map", "ts_visual_composer_extend") 				=> "style_flat_map",
								__( "Gowalla", "ts_visual_composer_extend") 				=> "style_gowalla",
								__( "Greyscale", "ts_visual_composer_extend") 				=> "style_greyscale",
								__( "Hopper", "ts_visual_composer_extend") 					=> "style_hopper",
								__( "Icy Blue", "ts_visual_composer_extend") 				=> "style_icy_blue",
								__( "Light Monochrome", "ts_visual_composer_extend") 		=> "style_light_monochrome",
								__( "Lunar Landscape", "ts_visual_composer_extend") 		=> "style_lunar_landscape",
								__( "Map Box", "ts_visual_composer_extend") 				=> "style_mapbox",
								__( "Midnight Commander", "ts_visual_composer_extend") 		=> "style_midnight_commander",
								__( "Nature", "ts_visual_composer_extend") 					=> "style_nature",
								__( "Neutral Blue", "ts_visual_composer_extend") 			=> "style_neutral_blue",
								__( "Old Timey", "ts_visual_composer_extend") 				=> "style_old_timey",
								__( "Pale Dawn", "ts_visual_composer_extend") 				=> "style_pale_dawn",
								__( "Paper", "ts_visual_composer_extend") 					=> "style_paper",
								__( "Red Alert", "ts_visual_composer_extend") 				=> "style_red_alert",
								__( "Red Hues", "ts_visual_composer_extend") 				=> "style_red_hues",
								__( "Retro", "ts_visual_composer_extend") 					=> "style_retro",
								__( "Route XL", "ts_visual_composer_extend") 				=> "style_route_xl",
								__( "Shades of Grey", "ts_visual_composer_extend") 			=> "style_shades_grey",
								__( "Shift Worker", "ts_visual_composer_extend") 			=> "style_shift_worker",
								__( "Snazzy Maps", "ts_visual_composer_extend") 			=> "style_snazzy_maps",
								__( "Subtle", "ts_visual_composer_extend") 					=> "style_subtle",
								__( "Subtle Grayscale", "ts_visual_composer_extend") 		=> "style_subtle_grayscale",
								__( "Unimposed Topography", "ts_visual_composer_extend") 	=> "style_unimposed_topo",
								__( "Vintage", "ts_visual_composer_extend") 				=> "style_vintage",
							),
							"description"           	=> __( "Select the color style for the road map layout.", "ts_visual_composer_extend" )
						),
						array(
							"type"                  	=> "nouislider",
							"heading"               	=> __( "Map Height", "ts_visual_composer_extend" ),
							"param_name"            	=> "googlemap_height",
							"value"                 	=> "450",
							"min"                   	=> "100",
							"max"                   	=> "2048",
							"step"                  	=> "1",
							"unit"                  	=> 'px',
							"admin_label"           	=> true,
							"description"           	=> __( "Define the height in pixel for the map.", "ts_visual_composer_extend" )
						),
						array(
							"type"                  	=> "nouislider",
							"heading"               	=> __( "Streetview Height", "ts_visual_composer_extend" ),
							"param_name"            	=> "googlemap_street",
							"value"                 	=> "450",
							"min"                   	=> "100",
							"max"                   	=> "2048",
							"step"                  	=> "1",
							"unit"                  	=> 'px',
							"description"           	=> __( "Define the height in pixel for the streetview container (for markers with streetview enabled).", "ts_visual_composer_extend" )
						),	
						array(
							"type"			        	=> "dropdown",
							"class"			        	=> "",
							"heading"               	=> __( "Map Center / Zoom", "ts_visual_composer_extend" ),
							"param_name"            	=> "center_type",
							"value"			        	=> array(
								__( "First Marker", "ts_visual_composer_extend" )        	=> "markers",
								__( "Coordinates", "ts_visual_composer_extend")           	=> "coordinates",
								__( "Address", "ts_visual_composer_extend" )        		=> "address",
								__( "Fit All Markers", "ts_visual_composer_extend" )        => "fitall",
							),
							"description"           	=> __( "Please define how the center of the map should be determined.", "ts_visual_composer_extend" ),
						),
						array(
							"type"                  	=> "nouislider",
							"heading"               	=> __( "Zoom Level", "ts_visual_composer_extend" ),
							"param_name"            	=> "googlemap_zoom",
							"value"                 	=> "12",
							"min"                   	=> "0",
							"max"                   	=> "21",
							"step"                  	=> "1",
							"unit"                  	=> '',
							"admin_label"           	=> true,
							"description"           	=> __( "Define the initial zoom level for the map.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "center_type", 'value' => array('markers', 'coordinates', 'address') ),
						),		
						array(
							"type"		            	=> "textfield",
							"class"		            	=> "",
							"heading"               	=> __( "Center Latitude", "ts_visual_composer_extend" ),
							"param_name"            	=> "center_latitude",
							"value"                	 	=> "",
							"admin_label"           	=> true,
							"description"	        	=> __( "Please provide the latitude for the map center."),
							"dependency"            	=> array( 'element' => "center_type", 'value' => 'coordinates' ),
						),
						array(
							"type"		            	=> "textfield",
							"class"		            	=> "",
							"heading"               	=> __( "Center Longitude", "ts_visual_composer_extend" ),
							"param_name"            	=> "center_longitude",
							"value"                 	=> "",
							"admin_label"           	=> true,
							"description"	        	=> __( "Please provide the longitude for the map center."),
							"dependency"            	=> array( 'element' => "center_type", 'value' => 'coordinates' ),
						),						
						array(
							"type"		            	=> "textfield",
							"class"		            	=> "",
							"heading"               	=> __( "Center Address", "ts_visual_composer_extend" ),
							"param_name"            	=> "center_address",
							"value"                	 	=> "",
							"admin_label"           	=> true,
							"description"	        	=> __( "Please provide the address for the map center."),
							"dependency"            	=> array( 'element' => "center_type", 'value' => 'address' ),
						),								
						array(
							"type"                  	=> "dropdown",
							"class"                 	=> "",
							"heading"               	=> __("Resize Event", "ts_visual_composer_extend"),
							"param_name"            	=> "googlemap_resize",
							"admin_label"           	=> true,
							"value"                 	=> array(
								__("No Change", "ts_visual_composer_extend")                  	=> "none",
								__("Set Map to Initial State", "ts_visual_composer_extend")		=> "redraw",
								__("Fit Map to Show All Markers", "ts_visual_composer_extend")	=> "fitmarkers",
							),
							"description"           	=> __( "Select how the map should react if a window resize event has been detected.", "ts_visual_composer_extend" )
						),						
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Require Activate on Mobile", "ts_visual_composer_extend" ),
							"param_name"            	=> "googlemap_mobile",
							"value"                 	=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if the map should require activation on mobile devices to ease scrolling.", "ts_visual_composer_extend" ),
							"dependency"        		=> ""
						),						
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "One Infowindow Only", "ts_visual_composer_extend" ),
							"param_name"            	=> "googlemap_singleinfo",
							"value"                 	=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want to have only one marker or overlay infowindow open at any time.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
						),						
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Use Marker Clusterer", "ts_visual_composer_extend" ),
							"param_name"            	=> "googlemap_clusters",
							"value"                 	=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want to apply an automatic marker clusterer to the map.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
						),
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Use Metric Dimensions", "ts_visual_composer_extend" ),
							"param_name"            	=> "googlemap_metric",
							"value"                 	=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want to use metric dimensions for distances and speeds.", "ts_visual_composer_extend" ),
							"dependency"        		=> ""
						),						
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Make Map Full-Width", "ts_visual_composer_extend" ),
							"param_name"            	=> "googlemap_full",
							"value"                 	=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want attempt showing the map in full width (will not work with all themes).", "ts_visual_composer_extend" ),
							"dependency"        		=> ""
						),
						array(
							"type"                  	=> "nouislider",
							"heading"               	=> __( "Full Width Breakouts", "ts_visual_composer_extend" ),
							"param_name"            	=> "googlemap_breakss",
							"value"                 	=> "6",
							"min"                   	=> "0",
							"max"                   	=> "99",
							"step"                  	=> "1",
							"unit"                  	=> '',
							"description"           	=> __( "Define the number of parent containers the map should attempt to break away from.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "googlemap_full", 'value' => 'true' )
						),
						// API Settings
						array(
							"type"                      => "seperator",
							"heading"                   => __( "", "ts_visual_composer_extend" ),
							"param_name"                => "seperator_2",
							"value"						=> "",
							"seperator"                 => "API Settings",
							"description"               => __( "", "ts_visual_composer_extend" ),
						),
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Load Google Map API", "ts_visual_composer_extend" ),
							"param_name"            	=> "googlemap_api",
							"value"                 	=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want to load the Google Map API; disable only if the API is already loaded by another plugin or theme as it is required for the map.", "ts_visual_composer_extend" ),
							"dependency"        		=> ""
						),						
						array(
							"type"                  	=> "nouislider",
							"heading"               	=> __( "Geocode Delay", "ts_visual_composer_extend" ),
							"param_name"            	=> "googlemap_delay",
							"value"                 	=> "200",
							"min"                   	=> "0",
							"max"                   	=> "1000",
							"step"                  	=> "10",
							"unit"                  	=> 'ms',
							"description"           	=> __( "Define the delay in ms between each address geocoding request that will be sent to Google.", "ts_visual_composer_extend" )
						),						
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Load OpenLayersMap API", "ts_visual_composer_extend" ),
							"param_name"            	=> "googlemap_openlayers",
							"value"                 	=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want to load the OpenLayersMap API in order to add the OpenLayers style option to the map.", "ts_visual_composer_extend" ),
							"dependency"        		=> ""
						),
						// Standard Controls
						array(
							"type"                      => "seperator",
							"heading"                   => __( "", "ts_visual_composer_extend" ),
							"param_name"                => "seperator_3",
							"value"						=> "",
							"seperator"                 => "Standard Controls",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Standard Controls",
						),
						array(
							"type"              		=> "switch_button",
							"heading"              	 	=> __( "Show Type Selector", "ts_visual_composer_extend" ),
							"param_name"            	=> "controls_types",
							"value"                 	=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want show the selector for the map types.", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
							"group"						=> "Standard Controls",
						),
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Show Zoom Controls", "ts_visual_composer_extend" ),
							"param_name"            	=> "controls_zoomer",
							"value"                 	=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want show the map zoom controls.", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
							"group"						=> "Standard Controls",
						),						
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Show Pan Controls", "ts_visual_composer_extend" ),
							"param_name"            	=> "controls_pan",
							"value"                 	=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want show the map pan controls.", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
							"group"						=> "Standard Controls",
						),						
						array(
							"type"			        	=> "dropdown",
							"class"			        	=> "",
							"heading"               	=> __( "Allow Map Dragging", "ts_visual_composer_extend" ),
							"param_name"            	=> "draggable_allow",
							"value"			        	=> array(
								__( "Provide On/Off Toggle", "ts_visual_composer_extend" )	=> "toggle",
								__( "All Devices", "ts_visual_composer_extend" )        	=> "all",
								__( "Desktop Devices", "ts_visual_composer_extend")			=> "desktop",
								__( "Mobile Devices", "ts_visual_composer_extend" )			=> "mobile",
								__( "Based on Screen Width", "ts_visual_composer_extend" )	=> "screen",
								__( "No Dragging", "ts_visual_composer_extend" )        	=> "none",
							),
							"description"           	=> __( "Please define if and on which devices the map can be dragged.", "ts_visual_composer_extend" ),
							"group"						=> "Standard Controls",
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Minimum Screen Width", "ts_visual_composer_extend" ),
							"param_name"                => "draggable_width",
							"value"                     => "480",
							"min"                       => "240",
							"max"                       => "1280",
							"step"                      => "1",
							"unit"                      => 'px',
							"description"               => __( "Define the minimum screen width at which the map should be draggable.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "draggable_allow", 'value' => 'screen' ),
                            "group"						=> "Standard Controls",
						),
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Allow Mouse Wheel Zoom", "ts_visual_composer_extend" ),
							"param_name"            	=> "controls_wheel",
							"value"                 	=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want to allow users to use the mouse wheel to zoom in/out.", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
							"group"						=> "Standard Controls",
						),
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Show StreetView Controls", "ts_visual_composer_extend" ),
							"param_name"            	=> "controls_street",
							"value"                 	=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want show the map streetview controls.", "ts_visual_composer_extend" ),
							"dependency"           	 	=> "",
							"group"						=> "Standard Controls",
						),
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Show Scale Controls", "ts_visual_composer_extend" ),
							"param_name"            	=> "controls_scaler",
							"value"                 	=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want show the map scale controls.", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
							"group"						=> "Standard Controls",
						),
						// Custom Controls
						array(
							"type"                      => "seperator",
							"heading"                   => __( "", "ts_visual_composer_extend" ),
							"param_name"                => "seperator_4",
							"value"						=> "",
							"seperator"                 => "Custom Controls",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Custom Controls",
						),
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Show Style Selector", "ts_visual_composer_extend" ),
							"param_name"            	=> "controls_styler",
							"value"                 	=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want to provide a selector so users can apply different styles to the map.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
                            "group" 			        => "Custom Controls",
						),		
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Show Group Filter", "ts_visual_composer_extend" ),
							"param_name"            	=> "controls_groups",
							"value"                 	=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want to provide a filter option to filter markers based on their assigned groups.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
                            "group" 			        => "Custom Controls",
						),
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Show Marker Selector", "ts_visual_composer_extend" ),
							"param_name"            	=> "controls_select",
							"value"                 	=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want to provide a control option to directly go to an existing marker on the map.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
                            "group" 			        => "Custom Controls",
						),				
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Show Search Input", "ts_visual_composer_extend" ),
							"param_name"            	=> "controls_search",
							"value"                 	=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want to provide a search option for users to find new addresses or coordinates on the map.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
                            "group" 			        => "Custom Controls",
						),
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Show Home Reset", "ts_visual_composer_extend" ),
							"param_name"            	=> "controls_home",
							"value"                 	=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want to provide a button to recenter and zoom the map to its initial center coordinates.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
                            "group" 			        => "Custom Controls",
						),						
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Layer: Bicycles", "ts_visual_composer_extend" ),
							"param_name"            	=> "layers_biking",
							"value"                 	=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want to provide a button to add a layer with biking trails to the map.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
                            "group" 			        => "Custom Controls",
						),
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Layer: Traffic", "ts_visual_composer_extend" ),
							"param_name"            	=> "layers_traffic",
							"value"                 	=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want to provide a button to add a layer with traffic information to the map.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
                            "group" 			        => "Custom Controls",
						),
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Layer: Transit", "ts_visual_composer_extend" ),
							"param_name"            	=> "layers_transit",
							"value"                 	=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"           	=> __( "Switch the toggle if you want to provide a button to add a layer with public transit information to the map.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
                            "group" 			        => "Custom Controls",
						),
						// Text Strings
						array(
							"type"                      => "seperator",
							"heading"                   => __( "", "ts_visual_composer_extend" ),
							"param_name"                => "seperator_5",
							"value"						=> "",
							"seperator"                 => "Text Strings",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"              		=> "messenger",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "messenger",
							"color"						=> "#006BB7",
							"weight"					=> "normal",
							"size"						=> "14",
							"value"						=> "",
							"message"            		=> __( "The map will use some text strings for buttons and other control elements. You can translate or change those text strings using the options provided below.", "ts_visual_composer_extend" ),
							"description"       		=> __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Show Google Map", "ts_visual_composer_extend" ),
							"param_name"                => "string_mobile_show",
							"value"                     => "Show Google Map",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Hide Google Map", "ts_visual_composer_extend" ),
							"param_name"                => "string_mobile_hide",
							"value"                     => "Hide Google Map",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Start Listeners", "ts_visual_composer_extend" ),
							"param_name"                => "string_listeners_start",
							"value"                     => "Start Listeners",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Stop Listeners", "ts_visual_composer_extend" ),
							"param_name"                => "string_listeners_stop",
							"value"                     => "Stop Listeners",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),						
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Google Standard", "ts_visual_composer_extend" ),
							"param_name"                => "string_style_default",
							"value"                     => "Google Standard",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Change Map Style", "ts_visual_composer_extend" ),
							"param_name"                => "string_style_label",
							"value"                     => "Change Map Style",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),						
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: All Groups", "ts_visual_composer_extend" ),
							"param_name"                => "string_filter_all",
							"value"                     => "All Groups",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Filter by Groups", "ts_visual_composer_extend" ),
							"param_name"                => "string_filter_label",
							"value"                     => "Filter by Groups",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Zoom to Location", "ts_visual_composer_extend" ),
							"param_name"                => "string_select_label",
							"value"                     => "Zoom to Location",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Open Street", "ts_visual_composer_extend" ),
							"param_name"                => "string_controls_osm",
							"value"                     => "Open Street",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Home", "ts_visual_composer_extend" ),
							"param_name"                => "string_controls_home",
							"value"                     => "Home",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Bicycle Trails", "ts_visual_composer_extend" ),
							"param_name"                => "string_controls_bike",
							"value"                     => "Bicycle Trails",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Transit", "ts_visual_composer_extend" ),
							"param_name"                => "string_controls_transit",
							"value"                     => "Transit",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Traffic", "ts_visual_composer_extend" ),
							"param_name"                => "string_controls_traffic",
							"value"                     => "Traffic",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Miles per Hour", "ts_visual_composer_extend" ),
							"param_name"                => "string_traffic_miles",
							"value"                     => "Miles per Hour",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Kilometers per Hour", "ts_visual_composer_extend" ),
							"param_name"                => "string_traffic_kilometer",
							"value"                     => "Kilometers per Hour",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: No Data Available", "ts_visual_composer_extend" ),
							"param_name"                => "string_traffic_none",
							"value"                     => "No Data Available",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Search Location", "ts_visual_composer_extend" ),
							"param_name"                => "string_search_button",
							"value"                     => "Search Location",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),						
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Enter address to search for ...", "ts_visual_composer_extend" ),
							"param_name"                => "string_search_holder",
							"value"                     => "Enter address to search for ...",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: View on Google Maps", "ts_visual_composer_extend" ),
							"param_name"                => "string_search_google",
							"value"                     => "View on Google Maps",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Text: Get Directions", "ts_visual_composer_extend" ),
							"param_name"                => "string_search_directions",
							"value"                     => "Get Directions",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Text Strings",
						),		
						// Other Settings
						array(
							"type"                      => "seperator",
							"heading"                   => __( "", "ts_visual_composer_extend" ),
							"param_name"                => "seperator_6",
							"value"						=> "",
							"seperator"                 => "Other Settings",
							"description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Other Settings",
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Margin: Top", "ts_visual_composer_extend" ),
							"param_name"                => "margin_top",
							"value"                     => "0",
							"min"                       => "0",
							"max"                       => "200",
							"step"                      => "1",
							"unit"                      => 'px',
							"description"               => __( "Select the top margin for the element.", "ts_visual_composer_extend" ),
                            "group" 			        => "Other Settings",
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Margin: Bottom", "ts_visual_composer_extend" ),
							"param_name"                => "margin_bottom",
							"value"                     => "0",
							"min"                       => "0",
							"max"                       => "200",
							"step"                      => "1",
							"unit"                      => 'px',
							"description"               => __( "Select the bottom margin for the element.", "ts_visual_composer_extend" ),
                            "group" 			        => "Other Settings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Define ID Name", "ts_visual_composer_extend" ),
							"param_name"                => "el_id",
							"value"                     => "",
							"description"               => __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
                            "group" 			        => "Other Settings",
						),
						array(
							"type"                      => "textfield",
							"heading"                   => __( "Extra Class Name", "ts_visual_composer_extend" ),
							"param_name"                => "el_class",
							"value"                     => "",
							"description"               => __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
                            "group" 			        => "Other Settings",
						),
						// Load Custom CSS/JS File
                        array(
                            "type"                      => "load_file",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "el_file1",
                            "value"                     => "",
                            "file_type"                 => "js",
							"file_id"         			=> "ts-extend-element",
                            "file_path"                 => "js/ts-visual-composer-extend-element.min.js",
                            "description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Other Settings",
                        ),
					),
				));
			}
		}
	}
}
// Register Container and Child Shortcode with Visual Composer
if (class_exists('WPBakeryShortCodesContainer')) {
	class WPBakeryShortCode_TS_VCSC_GoogleMapsPlus_Container extends WPBakeryShortCodesContainer {};
}
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_TS_VCSC_GoogleMapsPlus_Marker extends WPBakeryShortCode {};
	class WPBakeryShortCode_TS_VCSC_GoogleMapsPlus_Overlay extends WPBakeryShortCode {};
}
// Initialize "TS Google Maps Plus" Class
if (class_exists('TS_Google_Maps_Plus')) {
	$TS_Google_Maps_Plus = new TS_Google_Maps_Plus;
}