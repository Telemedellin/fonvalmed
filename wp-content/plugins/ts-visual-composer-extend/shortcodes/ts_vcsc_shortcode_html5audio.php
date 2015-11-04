<?php
	add_shortcode('TS_VCSC_HTML5_Audio', 'TS_VCSC_HTML5_Audio_Function');
	function TS_VCSC_HTML5_Audio_Function ($atts, $content = null) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
		
		wp_enqueue_style('ts-extend-tooltipster');
		wp_enqueue_script('ts-extend-tooltipster');				
		wp_enqueue_style('ts-extend-animations');
		wp_enqueue_style('ts-visual-composer-extend-front');
		wp_enqueue_script('ts-visual-composer-extend-front');
		
		extract( shortcode_atts( array(
			'audio_mp3_source'				=> 'true',
			'audio_mp3_remote'				=> '',
			'audio_mp3_local'				=> '',
			'audio_ogg_source'				=> 'true',
			'audio_ogg_remote'				=> '',
			'audio_ogg_local'				=> '',
			
			'audio_bar_only'				=> 'false',
			'audio_fixed'					=> 'false',
			'audio_fixed_show'				=> 'true',	
			'audio_fixed_width'				=> 250,
			'audio_fixed_height'			=> 140,
			'audio_fixed_adjust'			=> 0,
			'audio_fixed_switch'			=> 'toggle',			
			'audio_fixed_position'			=> 'bottomleft',
			
			'audio_poster'					=> '',
			'audio_logo_show'				=> 'logonone',
			'audio_logo_image'				=> '',
			'audio_logo_height'				=> 50,
			'audio_logo_opacity'			=> 50,
			'audio_logo_position'			=> 'left',
			'audio_logo_link'				=> '',
			
			'audio_theme'					=> 'maccaco',
			'audio_title'					=> '',
			'audio_iframe'					=> 'true',
			'audio_auto'					=> 'false',
			'audio_stop'					=> 'true',
			'audio_loop'					=> 'false',
			'audio_fullscreen'				=> 'true',
			'audio_share'					=> 'true',
			'audio_volume'					=> 50,
			
			'content_image_responsive'		=> 'true',
			'content_image_height'			=> 'height: 100%;',
			'content_image_width_r'			=> 100,
			'content_image_width_f'			=> 300,
			'content_image_size'			=> 'large',
			
			'content_tooltip_css'			=> 'false',
			'content_tooltip_title'			=> '',
			'content_tooltip_content'		=> '',
			'content_tooltip_position'		=> 'ts-simptip-position-top',
			
			'tooltipster_offsetx'			=> 0,
			'tooltipster_offsety'			=> 0,

			'margin_top'					=> 0,
			'margin_bottom'					=> 0,
			'el_id'							=> '',
			'el_class'						=> '',
			'css'							=> '',
		), $atts ));
		
		$randomizer							= mt_rand(999999, 9999999);
	
		if (!empty($el_id)) {
			$modal_id						= $el_id;
		} else {
			$modal_id						= 'ts-vcsc-modal-' . $randomizer;
		}

		// Audio Data
		if ($audio_mp3_source == "true") {
			$audio_url 						= wp_get_attachment_url($audio_mp3_local);
		} else {
			$audio_url 						= $audio_mp3_remote;
		}
		$audio_mp3							= $audio_url;		
		if ($audio_ogg_source == "true") {
			$audio_url 						= wp_get_attachment_url($audio_ogg_local);
		} else {
			$audio_url 						= $audio_ogg_remote;
		}
		$audio_ogg							= $audio_url;
		
		// Poster + Logo
		$poster_image 						= wp_get_attachment_image_src($audio_poster, 'full');
		if ($poster_image != false) {
			$poster_image					= $poster_image[0];
		} else {
			$poster_image					= TS_VCSC_GetResourceURL("images/defaults/default_html5.jpg");
		}		
		if ($audio_logo_show != "logonone") {
			$logo_image 					= wp_get_attachment_image_src($audio_logo_image, 'full');
			$logo_image 					= $logo_image[0];
			$audio_logo_link 				= ($audio_logo_link=='||') ? '' : $audio_logo_link;
			$audio_logo_link 				= vc_build_link($audio_logo_link);
			$logo_link_href					= $audio_logo_link['url'];
			$logo_link_title 				= $audio_logo_link['title'];
			$logo_link_target 				= $audio_logo_link['target'];			
		} else {
			$logo_image 					= '';
			$video_logo_link 				= '';
			$logo_link_href					= '';
			$logo_link_title 				= '';
			$logo_link_target 				= '';	
		}

		// Adjustment for Inline Edit Mode of VC
		if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
			$audio_fixed					= 'false';
		} else {
			$audio_fixed					= $audio_fixed;
		}
		
		// Tooltip
		if ($content_tooltip_content != '') {
			if (($content_tooltip_position == "ts-simptip-position-top") || ($content_tooltip_position == "top")) {
				$content_tooltip_position	= "top";
			}
			if (($content_tooltip_position == "ts-simptip-position-left") || ($content_tooltip_position == "left")) {
				$content_tooltip_position	= "left";
			}
			if (($content_tooltip_position == "ts-simptip-position-right") || ($content_tooltip_position == "right")) {
				$content_tooltip_position	= "right";
			}
			if (($content_tooltip_position == "ts-simptip-position-bottom") || ($content_tooltip_position == "bottom")) {
				$content_tooltip_position	= "bottom";
			}
			$tooltip_content 				= 'data-tooltipster-title="' . $content_tooltip_title . '" data-tooltipster-text="' . $content_tooltip_content . '" data-tooltipster-image="" data-tooltipster-position="' . $content_tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="tooltipster-black" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
			$tooltip_class					= 'ts-has-tooltipster-tooltip';			
			if ($audio_fixed_switch != "none") {
				$container_addition			= 40;
			} else {
				$container_addition			= 0;
			}
		} else {
			$tooltip_content				= '';
			$tooltip_class					= '';
			$container_addition				= 0;
		}
		
		if ($audio_bar_only == "true") {
			if ($audio_fixed == "true") {
				$container_adjust 			= 'height: 38px; width: ' . $audio_fixed_width . 'px; padding-bottom: 0; padding-top: 0;';
				$iframe_adjust 				= 'height: 38px; width: ' . $audio_fixed_width . 'px;';
			} else {
				$container_adjust 			= 'height: 38px; padding-bottom: 0; padding-top: 0;';
				$iframe_adjust 				= 'height: 38px;';
			}
		} else {
			if ($audio_fixed == "true") {
				$container_adjust			= 'margin-top: 0px; margin-bottom: 0px; height: ' . $audio_fixed_height . 'px; width: ' . $audio_fixed_width . 'px; padding-bottom: 0; padding-top: 0;';
				$iframe_adjust				= 'height: ' . $audio_fixed_height . 'px; width: ' . $audio_fixed_width . 'px; padding-bottom: 0; padding-top: 0;';
			} else {
				$container_adjust			= 'margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;';
				$iframe_adjust				= '';
			}
		}
		
		if ($audio_fixed == "true") {
			if ($audio_fixed_position == "bottomleft") {
				$container_fixed			= 'position: fixed; bottom: ' . $audio_fixed_adjust . 'px; left: 0; top: auto; right: auto; z-index: 4444;';
				$container_class			= 'ts_html5_audio_fixed_' . $audio_fixed_position . '';				
				if ($audio_bar_only == "true") {
					$container_controls		= 'position: fixed; bottom: ' . $audio_fixed_adjust . 'px; left: ' . ($audio_fixed_width + 2) . 'px; top: auto; right: auto; height: 40px; width: auto;';
					$container_info			= 'float: left;';
					$container_other		= 'float: right;';
				} else {
					$container_controls		= 'position: fixed; bottom: ' . ($audio_fixed_height - 38 + $audio_fixed_adjust - $container_addition) . 'px; left: ' . ($audio_fixed_width + 2) . 'px; top: auto; right: auto; height: auto; width: 40px;';
					$container_info			= '';
					$container_other		= '';
				}
			} else if ($audio_fixed_position == "bottomright") {
				$container_fixed			= 'position: fixed; bottom: ' . $audio_fixed_adjust . 'px; left: auto; top: auto; right: 0; z-index: 4444;';
				$container_class			= 'ts_html5_audio_fixed_' . $audio_fixed_position . '';
				if ($audio_bar_only == "true") {
					$container_controls		= 'position: fixed; bottom: ' . $audio_fixed_adjust . 'px; left: auto; top: auto; right: ' . ($audio_fixed_width + 2) . 'px; height: 40px; width: auto;';
					$container_info			= 'float: right;';
					$container_other		= 'float: left;';
				} else {
					$container_controls		= 'position: fixed; bottom: ' . ($audio_fixed_height - 38 + $audio_fixed_adjust - $container_addition) . 'px; left: auto; top: auto; right: ' . ($audio_fixed_width + 2) . 'px; height: auto; width: 40px;';
					$container_info			= '';
					$container_other		= '';
				}
			} else if ($audio_fixed_position == "topleft") {
				$container_fixed			= 'position: fixed; bottom: auto; left: 0; top: ' . $audio_fixed_adjust . 'px; right: auto; z-index: 4444;';
				$container_class			= 'ts_html5_audio_fixed_' . $audio_fixed_position . '';
				if ($audio_bar_only == "true") {
					$container_controls		= 'position: fixed; bottom: auto; left: ' . ($audio_fixed_width + 2) . 'px; top: ' . $audio_fixed_adjust . 'px; right: auto; height: 40px; width: auto;';
					$container_info			= 'float: left;';
					$container_other		= 'float: right;';
				} else {
					$container_controls		= 'position: fixed; bottom: auto; left: ' . ($audio_fixed_width + 2) . 'px; top: ' . ($audio_fixed_height - 38 + $audio_fixed_adjust - $container_addition) . 'px; right: auto; height: auto; width: 40px;';
					$container_info			= '';
					$container_other		= '';
				}
			} else if ($audio_fixed_position == "topright") {
				$container_fixed			= 'position: fixed; bottom: auto; left: auto; top: ' . $audio_fixed_adjust . 'px; right: 0; z-index: 4444;';
				$container_class			= 'ts_html5_audio_fixed_' . $audio_fixed_position . '';
				if ($audio_bar_only == "true") {
					$container_controls		= 'position: fixed; bottom: auto; left: auto; top: ' . $audio_fixed_adjust . 'px; right: ' . ($audio_fixed_width + 2) . 'px; height: 40px; width: auto;';
					$container_info			= 'float: right;';
					$container_other		= 'float: left;';
				} else {
					$container_controls		= 'position: fixed; bottom: auto; left: auto; top: ' . ($audio_fixed_height - 38 + $audio_fixed_adjust - $container_addition) . 'px; right: ' . ($audio_fixed_width + 2) . 'px; height: auto; width: 40px;';
					$container_info			= '';
					$container_other		= '';
				}
			}			
			$iframe_fixed					= 'position: relative;';
		} else {
			$container_class				= '';
			$container_fixed				= '';
			$iframe_fixed					= '';
			$container_controls				= '';
			$container_info					= '';
			$container_other				= '';
		}
		
		$output = '';
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_HTML5_Audio', $atts);
		} else {
			$css_class	= '';
		}

		if ($audio_fixed == "true") {
			$output .= '<div id="' . $modal_id . '_controls" class="ts_html5_audio_controls" style="' . $container_controls . '">';
				if ($content_tooltip_content != '') {
					$output .= '<div id="' . $modal_id . '_info" class="ts_html5_audio_info ' . $tooltip_class . '" ' . $tooltip_content . ' data-controls="' . $modal_id . '_controls" data-player="' . $modal_id . '_audio" data-position="' . $audio_fixed_position . '" data-width="' . $audio_fixed_width . '" data-adjust="' . $audio_fixed_adjust . '" style="' . $container_info . '"></div>';
				}
				if ($audio_fixed_switch == "remove") {
					$output .= '<div id="' . $modal_id . '_remove" class="ts_html5_audio_remove" data-info="' . $modal_id . '_info" data-controls="' . $modal_id . '_controls" data-player="' . $modal_id . '_audio" data-position="' . $audio_fixed_position . '" data-width="' . $audio_fixed_width . '" data-adjust="' . $audio_fixed_adjust . '" style="' . $container_other . '"></div>';
				} else if ($audio_fixed_switch == "toggle") {
					$output .= '<div id="' . $modal_id . '_hide" class="ts_html5_audio_hide inactive ' . $audio_fixed_position . '" data-show="' . $audio_fixed_show . '" data-info="' . $modal_id . '_info" data-controls="' . $modal_id . '_controls" data-player="' . $modal_id . '_audio" data-position="' . $audio_fixed_position . '" data-width="' . $audio_fixed_width . '" data-adjust="' . $audio_fixed_adjust . '" style="' . $container_other . '"></div>';
				}
			$output .= '</div>';
		}
		$output .= '<div id="' . $modal_id . '_audio" class="ts_audio_container ts_html5_audio_frame ' . $css_class . ' ' . $el_class . ' ' . $container_class . '" style="border: 1px solid #DADADA; ' . $container_adjust . ' ' . $container_fixed . '">';
			$output .= '<iframe id="' . $modal_id . '_iframe" class="ts_html5_audio_frame_insert ts_html5_media_frame_insert" style="margin: 0 auto; ' . $iframe_adjust . ' ' . $iframe_fixed . '" onload=""
				data-id="projekktor' . $randomizer . '"
				data-theme="' . $audio_theme . '"
				data-holder="' . $modal_id . '_iframe"
				data-bar-only="' . $audio_bar_only . '"
				data-auto-play="' . $audio_auto .'"
				data-auto-stop="' . $audio_stop . '"
				data-repeat="' . $audio_loop . '"
				data-poster="' . $poster_image . '"
				data-title="' . $audio_title . '"
				data-logo-show="' . $audio_logo_show . '"
				data-logo-image="' . $logo_image . '"
				data-logo-height="' . $audio_logo_height . '"
				data-logo-opacity="' . $audio_logo_opacity . '"
				data-logo-position="' . $audio_logo_position . '"
				data-logo-url="' . $logo_link_href . '"
				data-logo-title="' . $logo_link_title . '"
				data-logo-target="' . $logo_link_target . '"
				data-audio-mp3="' . $audio_mp3 . '"
				data-audio-ogg="' . $audio_ogg . '"
				data-volume="' . $audio_volume . '"
				data-share="' . $audio_share . '"
				data-fallback="' . TS_VCSC_GetResourceURL("projekktor/swf/StrobeMediaPlayback/StrobeMediaPlayback.swf") . '"
				width="100%" 
				height="auto" 
				scrolling="no" 
				frameborder="0" 
				type="text/html" 
				mozallowfullscreen="mozallowfullscreen" 
				webkitallowfullscreen="webkitallowfullscreen" 
				allowfullscreen="allowfullscreen" 
				src="' . TS_VCSC_GetResourceURL("projekktor/iframe-audio.html") . '">
			</iframe>';
		$output .= '</div>';
		
		echo $output;
	
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>