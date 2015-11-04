<?php
	add_shortcode('TS_VCSC_Page_Background', 'TS_VCSC_Page_Background_Function');
	function TS_VCSC_Page_Background_Function ($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
		
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
			$frontend					= "true";
		} else {
			$frontend					= "false";
		}
		
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'type'						=> 'image',
			'video_youtube'				=> '',
			'video_mute'				=> 'true',
			'video_loop'				=> 'false',
			'video_start'				=> 'false',
			'video_stop'				=> 'true',
			'video_controls'			=> 'true',
			'video_raster'				=> 'false',
			
			'video_mp4'					=> '',
			'video_ogv'					=> '',
			'video_webm'				=> '',
			'video_image'				=> '',
			
			'fixed_image'				=> '',
			
			'trianglify_colorsx'		=> 'random',
			'trianglify_colorsy'		=> 'match_x',
			'trianglify_generatorx'		=> '',
			'trianglify_generatory'		=> '',
			'trianglify_cellsize'		=> 50,
			'trianglify_variance'		=> 0.75,
			
			'slide_images'				=> '',
			'slide_auto'				=> 'true',
			'slide_controls'			=> 'true',
			'slide_shuffle'				=> 'false',
			'slide_delay'				=> 5000,
			'slide_bar'					=> 'true',
			'slide_transition'			=> 'random',
			'slide_switch'				=> 2000,
			'slide_animation'			=> 'null',
			'slide_halign'				=> 'center',
			'slide_valign'				=> 'center',
			
			'allow_mobile'				=> 'false',
			
			'raster_use'				=> 'false',
			'raster_type'				=> '',
			
			'overlay_use'				=> 'false',
			'overlay_color'				=> 'rgba(30,115,190,0.25)',
			'overlay_opacity'			=> 25,
			
			'el_id' 					=> '',
			'el_class'                  => '',
			'css'						=> '',
		), $atts ));
		
		$randomizer 					= mt_rand(999999, 9999999);
		
		if (!empty($el_id)) {
			$background_id				= $el_id;
		} else {
			$background_id				= 'ts-vcsc-pageback-' . $randomizer;
		}
		
		$output							= '';
		
		if ($frontend == "false") {
			if ($type == "triangle") {
				wp_enqueue_script('ts-extend-trianglify');	
			} else if ($type == "slideshow") {
				wp_enqueue_style('ts-extend-vegas');
				wp_enqueue_script('ts-extend-vegas');
			} else if ($type == "youtube") {
				wp_enqueue_style('ts-extend-ytplayer');
				wp_enqueue_script('ts-extend-ytplayer');
			} else if ($type == "video") {
				wp_enqueue_style('ts-font-mediaplayer');
				wp_enqueue_style('ts-extend-wallpaper');
				wp_enqueue_script('ts-extend-wallpaper');
			}
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, '' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Page_Background', $atts);
		} else {
			$css_class	= '';
		}

		if ($type == "image") {
			if ($frontend == "true") {
				$image_path 			= wp_get_attachment_image_src($fixed_image, 'thumbnail');
			} else if ($frontend == "false") {
				$image_path 			= wp_get_attachment_image_src($fixed_image, 'full');
			}
			$image_path					= $image_path[0];
			if (($raster_use == "true") && ($raster_type != '')) {
				$raster_content			= '<div class="ts-background-raster" style="background-image: url(' . $raster_type . ');"></div>';
			} else {
				$raster_content			= '';
			}
			if (($overlay_use == "true") && ($overlay_color != '')) {
				$overlay_content		= '<div class="ts-background-overlay" style="background: ' . $overlay_color . ';"></div>';
			} else {
				$overlay_content		= '';
			}			
			if ($frontend == "true") {
				$output .= '<div id="' . $background_id . '" class="ts-pageback-image-edit ' . $css_class . ' ' . $el_class . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-image="' . $image_path . '" data-controls="' . $video_controls . '" data-raster="' . $video_raster . '">';
					$output .= '<img class="ts-background-image-holder-edit" src="' . $image_path . '">';
					$output .= '<div class="ts-pageback-title">TS Page Background</div>';
					$output .= '<div class="ts-pageback-notes">' . __( "Background Type", "ts_visual_composer_extend" ) . ': ' . __( "Fixed Image", "ts_visual_composer_extend" ) . '</div>';
					$output .= '<div class="ts-pageback-notes">' . __( "Background Image", "ts_visual_composer_extend" ) . ': ' . $fixed_image . '</div>';
				$output .= '</div>';
			} else {
				$output = '<div id="' . $background_id . '" class="ts-pageback-image ' . $css_class . ' ' . $el_class . '" data-mobile="' . $allow_mobile . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-image="' . $image_path . '" data-controls="' . $video_controls . '" data-raster="' . $video_raster . '">';
					$output .= '<img class="ts-background-image-holder" src="' . $image_path . '">';
					$output .= $overlay_content;
					$output .= $raster_content;
				$output .= '</div>';
			}
		}
		if ($type == "slideshow") {
			if (($raster_use == "true") && ($raster_type != '')) {
				$raster_content			= '<div class="ts-background-raster" style="background-image: url(' . $raster_type . ');"></div>';
			} else {
				$raster_content			= '';
			}
			if (($overlay_use == "true") && ($overlay_color != '')) {
				$overlay_content		= '<div class="ts-background-overlay" style="background: ' . $overlay_color . ';"></div>';
			} else {
				$overlay_content		= '';
			}	
			if ($frontend == "true") {
				$output .= '<div id="' . $background_id . '" class="ts-pageback-slideshow-edit ' . $css_class . ' ' . $el_class . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '">';
					$slide_images 				= explode(',', $slide_images);
					$i 							= 0;
					foreach ($slide_images as $single_image) {
						$i++;
						$slide_image			= wp_get_attachment_image_src($single_image, 'thumbnail');
						$output .= '<img class="ts-background-image-holder-edit" src="' . $slide_image[0] . '" style="display: inline-block; width: 100px; height: 100px; margin: 0 5px 0 0;">';
					}
					$output .= '<div class="ts-pageback-title">TS Page Background</div>';
					$output .= '<div class="ts-pageback-notes">' . __( "Background Type", "ts_visual_composer_extend" ) . ': ' . __( "Fixed Image", "ts_visual_composer_extend" ) . '</div>';
					$output .= '<div class="ts-pageback-notes">' . __( "Background Images", "ts_visual_composer_extend" ) . ': ' . implode(',', $slide_images) . '</div>';
				$output .= '</div>';
			} else {
				$slider_settings		= 'data-initialized="false" data-autoplay="' .$slide_auto . '" data-playing="' .$slide_auto . '" data-halign="' . $slide_halign . '" data-valign="' . $slide_valign . '" data-controls="' . $slide_controls . '" data-shuffle="' . $slide_shuffle . '" data-delay="' . $slide_delay . '" data-bar="' . $slide_bar . '" data-transition="' . $slide_transition . '" data-switch="' . $slide_switch . '" data-animation="' . $slide_animation . '"';
				$output = '<div id="' . $background_id . '" class="ts-pageback-slideshow ' . $css_class . ' ' . $el_class . '" data-mobile="' . $allow_mobile . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" ' . $slider_settings . '>';
					$slide_images 				= explode(',', $slide_images);
					$fixed_image				= '';
					$i 							= 0;
					foreach ($slide_images as $single_image) {
						$i++;
						$slide_image			= wp_get_attachment_image_src($single_image, 'full');
						if ($i == 1) {
							$fixed_image		= $slide_image[0];
						}
						$output .= '<div class="ts-background-slideshow-holder" style="display: none;" data-image="' . $slide_image[0] . '" data-width="' . $slide_image[1] . '" data-height="' . $slide_image[2] . '" data-ratio="' . ($slide_image[1] / $slide_image[2]) . '"></div>';
					}
					$output .= '<div class="ts-background-slideshow-wrapper"></div>';
					$output .= '<img class="ts-background-image-holder" src="' . $fixed_image . '" style="display: none;">';
					$output .= $overlay_content;
					$output .= $raster_content;
					if ($slide_controls == 'true') {
						// Left / Right Navigation
						$output .= '<nav id="nav-arrows-' . $randomizer . '" class="ts-background-slideshow-navigation nav-arrows">';
							$output .= '<span class="nav-arrow-prev" style="text-indent: -90000px;">Previous</span>';
							$output .= '<span class="nav-arrow-next" style="text-indent: -90000px;">Next</span>';
						$output .= '</nav>';
					}
					if ($slide_auto == 'true') {
						// Auto-Play Controls
						$output .= '<nav id="nav-auto-' . $randomizer . '" class="ts-background-slideshow-playpause nav-auto">';
							$output .= '<span class="nav-auto-play" style="display: none; text-indent: -90000px;">Play</span>';
							$output .= '<span class="nav-auto-pause" style="text-indent: -90000px;">Pause</span>';
						$output .= '</nav>';
					}
				$output .= '</div>';
			}
		}
		if ($type == "triangle") {
			$trianglify_predefined = array(
				"YlGn" 			=> "#ffffe5,#f7fcb9,#d9f0a3,#addd8e,#78c679,#41ab5d,#238443,#006837,#004529",                          	// Yellow - Green
				"YlGnBu" 		=> "#ffffd9,#edf8b1,#c7e9b4,#7fcdbb,#41b6c4,#1d91c0,#225ea8,#253494,#081d58",                        	// Yellow - Green - Blue
				"GnBu" 			=> "#f7fcf0,#e0f3db,#ccebc5,#a8ddb5,#7bccc4,#4eb3d3,#2b8cbe,#0868ac,#084081",                          	// Green - Blue
				"BuGn" 			=> "#f7fcfd,#e5f5f9,#ccece6,#99d8c9,#66c2a4,#41ae76,#238b45,#006d2c,#00441b",                          	// Blue - Green
				"PuBuGn" 		=> "#fff7fb,#ece2f0,#d0d1e6,#a6bddb,#67a9cf,#3690c0,#02818a,#016c59,#014636",                        	// Purple - Blue - Green
				"PuBu" 			=> "#fff7fb,#ece7f2,#d0d1e6,#a6bddb,#74a9cf,#3690c0,#0570b0,#045a8d,#023858",                          	// Purple - Blue
				"BuPu" 			=> "#f7fcfd,#e0ecf4,#bfd3e6,#9ebcda,#8c96c6,#8c6bb1,#88419d,#810f7c,#4d004b",                          	// Blue - Purple
				"RdPu" 			=> "#fff7f3,#fde0dd,#fcc5c0,#fa9fb5,#f768a1,#dd3497,#ae017e,#7a0177,#49006a",                          	// Red - Purple
				"PuRd" 			=> "#f7f4f9,#e7e1ef,#d4b9da,#c994c7,#df65b0,#e7298a,#ce1256,#980043,#67001f",                          	// Purple - Red
				"OrRd" 			=> "#fff7ec,#fee8c8,#fdd49e,#fdbb84,#fc8d59,#ef6548,#d7301f,#b30000,#7f0000",                          	// Orange - Red
				"YlOrRd" 		=> "#ffffcc,#ffeda0,#fed976,#feb24c,#fd8d3c,#fc4e2a,#e31a1c,#bd0026,#800026",                        	// Yellow - Orange - Red
				"YlOrBr" 		=> "#ffffe5,#fff7bc,#fee391,#fec44f,#fe9929,#ec7014,#cc4c02,#993404,#662506",                        	// Yellow - Orange - Brown
				"Purples" 		=> "#fcfbfd,#efedf5,#dadaeb,#bcbddc,#9e9ac8,#807dba,#6a51a3,#54278f,#3f007d",                       	// Purples
				"Blues" 		=> "#f7fbff,#deebf7,#c6dbef,#9ecae1,#6baed6,#4292c6,#2171b5,#08519c,#08306b",                         	// Blues
				"Greens" 		=> "#f7fcf5,#e5f5e0,#c7e9c0,#a1d99b,#74c476,#41ab5d,#238b45,#006d2c,#00441b",                        	// Greens
				"Oranges" 		=> "#fff5eb,#fee6ce,#fdd0a2,#fdae6b,#fd8d3c,#f16913,#d94801,#a63603,#7f2704",                       	// Oranges
				"Reds" 			=> "#fff5f0,#fee0d2,#fcbba1,#fc9272,#fb6a4a,#ef3b2c,#cb181d,#a50f15,#67000d",                          	// Reds
				"Greys" 		=> "#ffffff,#f0f0f0,#d9d9d9,#bdbdbd,#969696,#737373,#525252,#252525,#000000",                         	// Greys
				"PuOr" 			=> "#7f3b08,#b35806,#e08214,#fdb863,#fee0b6,#f7f7f7,#d8daeb,#b2abd2,#8073ac,#542788,#2d004b",      		// Orange - Purple
				"BrBG" 			=> "#543005,#8c510a,#bf812d,#dfc27d,#f6e8c3,#f5f5f5,#c7eae5,#80cdc1,#35978f,#01665e,#003c30",      		// Brown - Green
				"PRGn" 			=> "#40004b,#762a83,#9970ab,#c2a5cf,#e7d4e8,#f7f7f7,#d9f0d3,#a6dba0,#5aae61,#1b7837,#00441b",      		// Purple - Green
				"PiYG" 			=> "#8e0152,#c51b7d,#de77ae,#f1b6da,#fde0ef,#f7f7f7,#e6f5d0,#b8e186,#7fbc41,#4d9221,#276419",      		// Pink - Yellow - Green
				"RdBu" 			=> "#67001f,#b2182b,#d6604d,#f4a582,#fddbc7,#f7f7f7,#d1e5f0,#92c5de,#4393c3,#2166ac,#053061",      		// Red - Blue
				"RdGy" 			=> "#67001f,#b2182b,#d6604d,#f4a582,#fddbc7,#ffffff,#e0e0e0,#bababa,#878787,#4d4d4d,#1a1a1a",      		// Red - Grey
				"RdYlBu" 		=> "#a50026,#d73027,#f46d43,#fdae61,#fee090,#ffffbf,#e0f3f8,#abd9e9,#74add1,#4575b4,#313695",    		// Red - Yellow - Blue
				"Spectral" 		=> "#9e0142,#d53e4f,#f46d43,#fdae61,#fee08b,#ffffbf,#e6f598,#abdda4,#66c2a5,#3288bd,#5e4fa2",  			// Spectral
				"RdYlGn" 		=> "#a50026,#d73027,#f46d43,#fdae61,#fee08b,#ffffbf,#d9ef8b,#a6d96a,#66bd63,#1a9850,#006837",     		// Red - Yellow - Green
				"Accent"		=> "#7fc97f,#beaed4,#fdc086,#ffff99,#386cb0,#f0027f,#bf5b17,#666666",									// Accent
				"Dark2" 		=> "#1b9e77,#d95f02,#7570b3,#e7298a,#66a61e,#e6ab02,#a6761d,#666666",									// Dark
				"Paired" 		=> "#a6cee3,#1f78b4,#b2df8a,#33a02c,#fb9a99,#e31a1c,#fdbf6f,#ff7f00,#cab2d6,#6a3d9a,#ffff99,#b15928",	// Paired
				"Pastel1" 		=> "#fbb4ae,#b3cde3,#ccebc5,#decbe4,#fed9a6,#ffffcc,#e5d8bd,#fddaec,#f2f2f2",							// Pastel 1
				"Pastel2" 		=> "#b3e2cd,#fdcdac,#cbd5e8,#f4cae4,#e6f5c9,#fff2ae,#f1e2cc,#cccccc",									// Pastel 2
				"Set1" 			=> "#e41a1c,#377eb8,#4daf4a,#984ea3,#ff7f00,#ffff33,#a65628,#f781bf,#999999",							// Set 1
				"Set2" 			=> "#66c2a5,#fc8d62,#8da0cb,#e78ac3,#a6d854,#ffd92f,#e5c494,#b3b3b3",									// Set 2
				"Set3" 			=> "#8dd3c7,#ffffb3,#bebada,#fb8072,#80b1d3,#fdb462,#b3de69,#fccde5,#d9d9d9,#bc80bd,#ccebc5,#ffed6f",	// Set 3				
			);
			// Horizontal Pattern
			if ($trianglify_colorsx == "random") {
				//$trianglify_random			= rand(0, count($trianglify_predefined) - 1);
				//$trianglify_allkeys			= array_keys($trianglify_predefined)[$trianglify_random];
				//$trianglify_stringx			= $trianglify_predefined[$trianglify_allkeys];				
				$trianglify_stringx				= $trianglify_predefined[array_rand($trianglify_predefined)];
			} else if ($trianglify_colorsx == "custom") {
				$trianglify_array 				= explode(";", $trianglify_generatorx);
				$trianglify_array				= (TS_VCSC_GetContentsBetween($trianglify_array[0], 'color-stop(', ')'));
				$trianglify_stringx				= array();
				$trianglyfy_position			= 0;
				foreach ($trianglify_array as $key => $value) {
					//$trianglify_stringx[]		= "#" . substr($value, (strrpos($value, '#') ? : -1) + 1) . "";
					//$trianglify_stringx[]		= "#" . substr($value, (strrpos($value, '#') ? strrpos($value, '#') : -1) + 1) . "";
					$trianglyfy_position		= TS_VCSC_STRRPOS_String($value, '#', 0);
					$trianglify_stringx[]		= "#" . substr($value, (($trianglyfy_position != false ? $trianglyfy_position : -1) + 1)) . "";			
				}
				$trianglify_stringx				= implode(",", $trianglify_stringx);
			} else {
				$trianglify_stringx				= $trianglify_predefined[$trianglify_colorsx];
			}
			// Vertical Pattern
			if ($trianglify_colorsy == "match_x") {
				$trianglify_stringy				= $trianglify_stringx;
			} else {
				if ($trianglify_colorsy == "random") {
					//$trianglify_random		= rand(0, count($trianglify_predefined) - 1);
					//$trianglify_allkeys		= array_keys($trianglify_predefined)[$trianglify_random];
					//$trianglify_stringy		= $trianglify_predefined[$trianglify_allkeys];
					$trianglify_stringy			= $trianglify_predefined[array_rand($trianglify_predefined)];
				} else if ($trianglify_colorsy == "custom") {
					$trianglify_array 			= explode(";", $trianglify_generatory);
					$trianglify_array			= (TS_VCSC_GetContentsBetween($trianglify_array[0], 'color-stop(', ')'));
					$trianglify_stringy			= array();
					$trianglyfy_position		= 0;
					foreach ($trianglify_array as $key => $value) {
						//$trianglify_stringy[]	= "#" . substr($value, (strrpos($value, '#') ? : -1) + 1) . "";
						//$trianglify_stringy[]	= "#" . substr($value, (strrpos($value, '#') ? strrpos($value, '#') : -1) + 1) . "";
						$trianglyfy_position	= TS_VCSC_STRRPOS_String($value, '#', 0);
						$trianglify_stringy[]	= "#" . substr($value, (($trianglyfy_position != false ? $trianglyfy_position : -1) + 1)) . "";
					}
					$trianglify_stringy			= implode(",", $trianglify_stringy);
				} else {
					$trianglify_stringy			= $trianglify_predefined[$trianglify_colorsy];
				}
			}
			if (($raster_use == "true") && ($raster_type != '')) {
				$raster_content			= '<div class="ts-background-raster" style="background-image: url(' . $raster_type . ');"></div>';
			} else {
				$raster_content			= '';
			}
			if (($overlay_use == "true") && ($overlay_color != '')) {
				$overlay_content		= '<div class="ts-background-overlay" style="background: ' . $overlay_color . ';"></div>';
			} else {
				$overlay_content		= '';
			}
			if ($frontend == "true") {
				$output .= '<div id="' . $background_id . '" class="ts-pageback-trianglify-edit ' . $css_class . ' ' . $el_class . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-raster="' . $video_raster . '">';
					$output .= '<div class="ts-pageback-title">TS Page Background</div>';
					$output .= '<div class="ts-pageback-notes">' . __( "Background Type", "ts_visual_composer_extend" ) . ': ' . __( "Trianglify Pattern", "ts_visual_composer_extend" ) . '</div>';
				$output .= '</div>';
			} else {
				$output = '<div id="' . $background_id . '" class="ts-pageback-trianglify ' . $css_class . ' ' . $el_class . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-cellsize="' . $trianglify_cellsize . '" data-variance="' . $trianglify_variance . '" data-colorsx="' . $trianglify_stringx . '" data-colorsy="' . $trianglify_stringy . '" data-raster="' . $video_raster . '">';
					$output .= '<div class="ts-background-trianglify-holder"></div>';
					$output .= $overlay_content;
					$output .= $raster_content;
				$output .= '</div>';
			}
		}
		if ($type == "youtube") {
			if (preg_match('~((http|https|ftp|ftps)://|www.)(.+?)~', $video_youtube)) {
				$content_youtube		= $video_youtube;
			} else {
				$content_youtube		= 'https://www.youtube.com/watch?v=' . $video_youtube;
			}
			$youtube_image 				= TS_VCSC_VideoImage_Youtube($content_youtube);
			if ($frontend == "true") {
				$output .= '<div id="' . $background_id . '" class="ts-pageback-image-edit ' . $css_class . ' ' . $el_class . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-raster="' . $raster_type . '" data-overlay="' . $overlay_color . '" data-image="' . $youtube_image . '" data-controls="' . $video_controls . '" data-raster="' . $video_raster . '">';
					if ($youtube_image != '') {
						$output .= '<img class="ts-background-image-holder-edit" src="' . $youtube_image . '">';
					}
					$output .= '<div class="ts-pageback-title">TS Page Background</div>';
					$output .= '<div class="ts-pageback-notes">' . __( "Background Type", "ts_visual_composer_extend" ) . ': ' . __( "YouTube Video", "ts_visual_composer_extend" ) . '</div>';
					$output .= '<div class="ts-pageback-notes">' . __( "YouTube Video ID", "ts_visual_composer_extend" ) . ': ' . $video_youtube . '</div>';
				$output .= '</div>';
			} else {
				$output = '<div id="' . $background_id . '" class="ts-pageback-youtube ' . $css_class . ' ' . $el_class . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-image="' . $youtube_image . '" data-video="' . $video_youtube . '" data-controls="' . $video_controls . '" data-start="' . $video_start . '" data-raster="' . $video_raster . '" data-mute="' . $video_mute . '" data-loop="' . $video_loop . '"></div>';
			}
		}
		if ($type == "video") {
			if ($video_image != '') {
				$image_path 			= wp_get_attachment_image_src($video_image, 'full');
				$image_path				= $image_path[0];
			} else {
				$image_path				= '';
			}
			if ($frontend == "true") {
				$output .= '<div id="' . $background_id . '" class="ts-pageback-image-edit ' . $css_class . ' ' . $el_class . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-raster="' . $raster_type . '" data-overlay="' . $overlay_color . '" data-image="' . $image_path . '" data-controls="' . $video_controls . '" data-raster="' . $video_raster . '">';
					if ($image_path != '') {
						$output .= '<img class="ts-background-image-holder-edit" src="' . $image_path . '">';
					}
					$output .= '<div class="ts-pageback-title">TS Page Background</div>';
					$output .= '<div class="ts-pageback-notes">' . __( "Background Type", "ts_visual_composer_extend" ) . ': ' . __( "Selfhosted Video", "ts_visual_composer_extend" ) . '</div>';
					$output .= '<div class="ts-pageback-notes">' . __( "MP4 Video", "ts_visual_composer_extend" ) . ': ' . $video_mp4 . '</div>';
					$output .= '<div class="ts-pageback-notes">' . __( "WEBM Video", "ts_visual_composer_extend" ) . ': ' . $video_webm . '</div>';
					$output .= '<div class="ts-pageback-notes">' . __( "OGV Video", "ts_visual_composer_extend" ) . ': ' . $video_ogv . '</div>';
				$output .= '</div>';
			} else {
				$output = '<div id="' . $background_id . '" class="ts-pageback-video ' . $css_class . ' ' . $el_class . '" data-inline="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode . '" data-raster="' . ((($raster_use == "true") && ($raster_type != '')) ? $raster_type : "") . '" data-overlay="' . ((($overlay_use == "true") && ($overlay_color != '')) ? $overlay_color : "") . '" data-mp4="' . $video_mp4 . '" data-ogv="' . $video_ogv . '" data-webm="' . $video_webm . '" data-image="' . $image_path . '" data-controls="' . $video_controls . '" data-start="' . $video_start . '" data-raster="' . $video_raster . '" data-mute="' . $video_mute . '" data-loop="' . $video_loop . '">';
					$output .= '<div class="ts-background-video-holder"></div>';
				$output .= '</div>';
			}
		}
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
	if (class_exists('WPBakeryShortCode')) {
		class WPBakeryShortCode_TS_VCSC_Page_Background extends WPBakeryShortCode {};
	}
?>