<?php
if (!class_exists('TS_Timeline_CSS')){
	class TS_Timeline_CSS {
		function __construct() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				add_action('init',                              		array($this, 'TS_VCSC_Add_Timeline_CSS_Elements'), 9999999);
			} else {
				add_action('admin_init',		                		array($this, 'TS_VCSC_Add_Timeline_CSS_Elements'), 9999999);
			}
			add_shortcode('TS_VCSC_Timeline_CSS_Section',         		array($this, 'TS_VCSC_Timeline_CSS_Function_Section'));
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements++;
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements++;
			add_shortcode('TS_VCSC_Timeline_CSS_Container',         	array($this, 'TS_VCSC_Timeline_CSS_Function_Container'));
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements++;
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements++;
		}
		
		// Timeline Section
		function TS_VCSC_Timeline_CSS_Function_Section ($atts) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();
	
			extract( shortcode_atts( array(
				'section'						=> '',
				
				'section_icon'					=> '',
				'icon_color'					=> '#7c7979',
				
				'tooltipster_offsetx'			=> 0,
				'tooltipster_offsety'			=> 0,

				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
			), $atts ));
			
			$media_string						= '';
			$output 							= '';
		
			$randomizer							= mt_rand(999999, 9999999);
		
			if (!empty($el_id)) {
				$timeline_id					= $el_id;
			} else {
				$timeline_id					= 'ts-vcsc-timeline-section-' . $randomizer;
			}
			
            // Retrieve Timeline Post
            $timeline_array						= array();
            $category_fields 	                = array();
            $args = array(
                'no_found_rows' 				=> 1,
                'ignore_sticky_posts' 			=> 1,
                'posts_per_page' 				=> -1,
                'post_type' 					=> 'ts_timeline',
                'post_status' 					=> 'publish',
                'orderby' 						=> 'title',
                'order' 						=> 'ASC',
            );
            $timeline_query = new WP_Query($args);
            if ($timeline_query->have_posts()) {
                foreach($timeline_query->posts as $p) {
                    if ($p->ID == $section) {
						// Retrieve Post Categories
						$section_categories		= get_the_terms($p->ID, 'ts_timeline_category');
						$array_categories		= array();
						if ($section_categories != false) {
							foreach ($section_categories as $category) {
								$array_categories[] = $category->name;
							}
						}
						$section_categories 	= join(",", $array_categories);						
						// Retrieve Post Tags
						$sections_tags			= get_the_terms($p->ID, 'ts_timeline_tags');
						$array_tags				= array();
						if ($sections_tags != false) {
							foreach ($sections_tags as $tag) {
								$array_tags[] 	= $tag->name;
							}
						}
						$sections_tags 			= join(",", $array_tags);
						// Build Data Array
                        $timeline_data = array(
                            'author'			=> $p->post_author,
                            'name'				=> $p->post_name,
                            'title'				=> $p->post_title,
                            'id'				=> $p->ID,
							'categories'		=> $section_categories,
							'tags'				=> $sections_tags
                        );
                        $timeline_array[] 		= $timeline_data;
						$array_categories		= array();
						$array_tags				= array();
                    }
                }
            }
            wp_reset_postdata();
			
			// Section Main Data
            foreach ($timeline_array as $index => $array) {
                $Section_Author					= $timeline_array[$index]['author'];
                $Section_Name 					= $timeline_array[$index]['name'];
                $Section_Title 					= $timeline_array[$index]['title'];
                $Section_ID 					= $timeline_array[$index]['id'];
				$Section_Categories				= $timeline_array[$index]['categories'];
				$Section_Tags					= $timeline_array[$index]['tags'];
            }
			
            // Retrieve Timeline Post Meta Content
            $custom_fields 						= get_post_custom($Section_ID);
            $custom_fields_array				= array();
            foreach ($custom_fields as $field_key => $field_values) {
                if (!isset($field_values[0])) continue;
                if (in_array($field_key, array("_edit_lock", "_edit_last"))) continue;
                if (strpos($field_key, 'ts_vcsc_timeline_') !== false) {
					if ($field_key == "ts_vcsc_timeline_media_featuredimage_id") {
						$field_key				= "ts_vcsc_timeline_media_featuredimageid";
					}
                    $field_key_split 			= explode("_", $field_key);
                    $field_key_length 			= count($field_key_split) - 1;
                    $custom_data = array(
                        'group'					=> $field_key_split[$field_key_length - 1],
                        'name'					=> 'Timeline_' . ucfirst($field_key_split[$field_key_length]),
                        'value'					=> $field_values[0],
                    );
                    $custom_fields_array[] 		= $custom_data;
                }
            }
            foreach ($custom_fields_array as $index => $array) {
                ${$custom_fields_array[$index]['name']} = $custom_fields_array[$index]['value'];
            }
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 						= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-timeline-css-section ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Timeline_CSS_Section', $atts);
			} else {
				$css_class						= 'ts-timeline-css-section ' . $el_class;
			}
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$vc_inline						= 'true';
				$vc_inline_style				= ' display: block;';
			} else {
				$vc_inline						= 'false';
				$vc_inline_style				= '';
			}			
			
			if ($vc_inline == "false") {			
				// Tooltip String
				if (isset($Timeline_Tooltiptext)) {
					if (isset($Timeline_Tooltipstyle)) {
						$tooltip_style				= "tooltipster-" . $Timeline_Tooltipstyle;
					} else {
						$tooltip_style				= "tooltipster-black";
					}
					if (isset($Timeline_Tooltipposition)) {
						$tooltip_position			= $Timeline_Tooltipposition;
					} else {
						$tooltip_position			= 'top';
					}
					$tooltip_content				= 'data-tooltipster-html="true" data-tooltipster-title="" data-tooltipster-text="' . base64_encode($Timeline_Tooltiptext) . '" data-tooltipster-image="" data-tooltipster-position="' . $tooltip_position . '" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="' . $tooltip_style . '" data-tooltipster-animation="swing" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
					$tooltip_class					= 'ts-has-tooltipster-tooltip';
				} else {
					$tooltip_content				= '';
					$tooltip_class					= '';
				}
				
				// Border Radius
				if (isset($Timeline_Radiusborder)) {
					$border_radius					= $Timeline_Radiusborder;
				} else {
					$border_radius					= '';
				}
				
				// Timeline Event
				if ($Timeline_Type == "event") {
					// Feature Media Alignment
					if (isset($Timeline_Featuredmediaalign)) {
						if ($Timeline_Featuredmediaalign == "center") {
							$image_alignment		= "margin: 5px auto; float: none;";
						} else if ($Timeline_Featuredmediaalign == "left") {
							$image_alignment		= "margin: 5px 0; float: left;";
						} else if ($Timeline_Featuredmediaalign == "right") {
							$image_alignment		= "margin: 5px 0; float: right;";
						}
					} else {
						$image_alignment			= "margin: 5px auto; float: none;";
					}
					// Feature Media Dimensions
					$image_dimensions						= 'width: 100%; height: auto;';
					$parent_dimensions						= 'width: ' . $Timeline_Featuredmediawidth . '%; ' . $Timeline_Featuredmediaheight;
					// Lightbox Background Color
					if (isset($Timeline_Lightboxbacklight)) {
						if ($Timeline_Lightboxbacklight == "auto") {
							$nacho_color			= '';
						} else if ($Timeline_Lightboxbacklight == "custom") {
							$nacho_color			= 'data-color="' . $Timeline_Lightboxbacklightcolor . '"';
						} else if ($Timeline_Lightboxbacklight == "hideit") {
							$nacho_color			= 'data-color="#000000"';
						}
					} else {
						$nacho_color				= '';
					}
					// Adjustment for Inline Edit Mode of VC
					if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
						$Timeline_Fullwidth				= 'true';
						$vcinline_active				= 'true';
						$vcinline_class					= '';
						$vcinline_slider				= 'owl-carousel2-edit';
					} else {
						$Timeline_Fullwidth				= $Timeline_Fullwidth;
						$vcinline_active				= 'false';
						$vcinline_class					= '';
						$vcinline_slider				= 'owl-carousel2';
					}
					// Featured Media
					if (isset($Timeline_Featuredmedia)) {
						// Featured Media: Image
						if ($Timeline_Featuredmedia == 'image') {
							if (isset($Timeline_Featuredimageid)) {
								$media_image 				= wp_get_attachment_image_src($Timeline_Featuredimageid, 'large');
								if ($media_image != false) {
									$image_extension 		= pathinfo($media_image[0], PATHINFO_EXTENSION);
									if (isset($Timeline_Attributealtvalue)) {
										$alt_attribute		= $Timeline_Attributealtvalue;
									} else {
										$alt_attribute		= basename($Timeline_Featuredimage, "." . $image_extension);
									}
									if (isset($Timeline_Attributetitle)) {
										$media_title 		= $Timeline_Attributetitle;
									} else if (isset($Timeline_Eventtitletext)) {
										$media_title 		= $Timeline_Eventtitletext;
									} else {
										$media_title		= '';
									}								
									if ($Timeline_Lightboxfeatured == "false") {
										$media_string .= '<div class="ts-timeline-media" style="' . $parent_dimensions . '; ' . $image_alignment . '">';
											$media_string .= '<img class="" src="' . $media_image[0] . '" alt="' . $alt_attribute . '" style="max-width: ' . $media_image[1] . 'px; padding: 0; margin: 0 auto; display: block; ' . $image_dimensions . '">';
										$media_string .= '</div>';
									} else {
										$media_string .= '<div class="ts-timeline-media nchgrid-item nchgrid-tile nch-lightbox-image" style="' . $parent_dimensions . '; ' . $image_alignment . '">';
											$media_string .= '<a href="' . $media_image[0] . '" class="nch-lightbox-media no-ajaxy" data-thumbnail="' . $media_image[0] . '" data-title="' . $media_title . '" rel="' . ($Timeline_Lightboxgroup == "true" ? "timelinegroup" : (isset($Timeline_Lightboxgroupname) ? $Timeline_Lightboxgroupname : "")) . '" data-share="0" data-effect="' . $Timeline_Lightboxeffect . '" data-duration="5000" ' . $nacho_color . '>';
												$media_string .= '<img src="' . $media_image[0] . '" alt="' . $alt_attribute . '" title="" style="max-width: ' . $media_image[1] . 'px; padding: 0; margin: 0 auto; display: block; ' . $image_dimensions . '">';
												$media_string .= '<div class="nchgrid-caption"></div>';
												if ($media_title != '') {
													$media_string .= '<div class="nchgrid-caption-text">' . $media_title . '</div>';
												}
											$media_string .= '</a>';
										$media_string .= '</div>';
									}
								}
							}
						}
						// Featured Media: Image Slider
						if ($Timeline_Featuredmedia == 'slider') {
							if (isset($Timeline_Featuredslider)) {
								if (isset($Timeline_Pagertl)) {
									$page_rtl				= $Timeline_Pagertl;								
								} else {
									$page_rtl				= "false";
								}							
								$featured_slider 			= array();
								$featured_images			= array();
								$featured_maxheight			= (isset($Timeline_Slidermaxheight) ? $Timeline_Slidermaxheight : 400);
								$featured_fixheight			= (isset($Timeline_Sliderfixheight) ? $Timeline_Sliderfixheight : 400);
								$images 					= get_post_meta($Section_ID, 'ts_vcsc_timeline_media_featuredslider', true);
								if ($images) {
									foreach ($images as $attachment_id => $img_full_url) {
										$featured_slider[]	= $attachment_id;
									}
								}
								$i 							= -1;
								$b							= 0;
								$nachoLength 				= count($featured_slider) - 1;								
								if (isset($Timeline_Slidertitles)) {
									$titles_array 			= explode("\n", $Timeline_Slidertitles);
									$titles_array 			= array_filter($titles_array, 'trim');
								} else {
									$titles_array			= array();
								}								
								$media_string .= '<div id="ts-timeline-css-imageslider-' . $randomizer . '" class="ts-timeline-css-imageslider-container ' . $vcinline_slider . '" style="" data-id="' . $randomizer . '" data-parent="' . $timeline_id . '" data-items="' . count($featured_slider) . '" data-maxheight="' . $featured_maxheight . '">';
									$media_string .= '<div class="ts-timeline-css-imageslider-slides">';
										foreach ($featured_slider as $single_image) {
											$i++;
											$modal_image			= wp_get_attachment_image_src($single_image, 'full');
											if ($modal_image != false) {
												$modal_thumb		= wp_get_attachment_image_src($single_image, 'thumb');
												$image_ratio		= $modal_image[1] / $modal_image[2];
												$image_height		= ($modal_image[2] > $featured_maxheight ? $featured_maxheight : $modal_image[2]);
												$image_width		= round($image_height * $image_ratio, 0);
												$image_extension	= pathinfo($modal_image[0], PATHINFO_EXTENSION);
												$featured_images[]	= $modal_thumb[0];
												if ($Timeline_Lightboxfeatured == "false") {
													if ((($i == 0) && ($vcinline_active == "true")) || ($vcinline_active == "false")) {
														$media_string .= '<div id="ts-timeline-css-imageslider-image-' . $single_image .'-parent" class="ts-timeline-css-imageslider-image-parent nchgrid-item nchgrid-tile nch-lightbox-image ts-timeline-css-imageslider-item ' . ($i == 0 ? "ts-timeline-css-slider-view-active" : "ts-timeline-css-slider-view-hidden") . '" data-width="' . $modal_image[1] . '" data-height="' . $modal_image[2] . '" data-ratio="' . ($modal_image[1] / $modal_image[2]) . '" data-order="' . $i . '" data-total="' . count($featured_slider) . '">';
															$media_string .= '<img src="' . $modal_image[0] . '" style="max-width: ' . $image_width . 'px; max-height: ' . $image_height . 'px; padding: 0; margin: 0 auto; display: block; ' . $image_dimensions . '">';
															$media_string .= '<div class="nchgrid-caption"></div>';
															if ((isset($titles_array[$i])) && ($titles_array[$i] != '')) {
																$media_string .= '<div class="nchgrid-caption-text">' . strip_tags($titles_array[$i]) . '</div>';
															}
														$media_string .= '</div>';
													}
												} else {
													if (($i == $nachoLength) && ($vcinline_active == "false")) {
														$media_string .= '<div id="ts-timeline-css-imageslider-image-' . $single_image .'-parent" class="ts-timeline-css-imageslider-image-parent nchgrid-item nchgrid-tile nch-lightbox-image ts-timeline-css-imageslider-item ' . ($i == 0 ? "ts-timeline-css-slider-view-active" : "ts-timeline-css-slider-view-hidden") . '" data-width="' . $modal_image[1] . '" data-height="' . $modal_image[2] . '" data-ratio="' . ($modal_image[1] / $modal_image[2]) . '" data-order="' . $i . '" data-total="' . count($featured_slider) . '">';
															$media_string .= '<a id="' . $timeline_id . '-' . $single_image .'" href="' . $modal_image[0] . '" data-thumbnail="' . $modal_image[0] . '" data-title="' . (((isset($titles_array[$i])) && ($titles_array[$i] != '')) ? strip_tags($titles_array[$i]) : '') . '" class="nch-lightbox-media no-ajaxy ts-hover-image ' . $timeline_id . '-slider-image" rel="' . ($Timeline_Lightboxgroup == "true" ? "timelinegroup" : (isset($Timeline_Lightboxgroupname) ? $Timeline_Lightboxgroupname : "")) . '" data-effect="' . $Timeline_Lightboxeffect . '" data-share="0" data-autoplay="0" data-duration="5000" data-thumbsize="100" data-thumbs="bottom" ' . $nacho_color . '>';
																$media_string .= '<img src="' . $modal_image[0] . '" style="max-width: ' . $image_width . 'px; max-height: ' . $image_height . 'px; padding: 0; margin: 0 auto; display: block; ' . $image_dimensions . '">';
																$media_string .= '<div class="nchgrid-caption"></div>';
																if ((isset($titles_array[$i])) && ($titles_array[$i] != '')) {
																	$media_string .= '<div class="nchgrid-caption-text">' . strip_tags($titles_array[$i]) . '</div>';
																}
															$media_string .= '</a>';
														$media_string .= '</div>';
													} else if ((($i == 0) && ($vcinline_active == "true")) || ($vcinline_active == "false")) {
														$media_string .= '<div id="ts-timeline-css-imageslider-image-' . $single_image .'-parent" class="ts-timeline-css-imageslider-image-parent nchgrid-item nchgrid-tile nch-lightbox-image ts-timeline-css-imageslider-item ' . ($i == 0 ? "ts-timeline-css-slider-view-active" : "ts-timeline-css-slider-view-hidden") . '" data-width="' . $modal_image[1] . '" data-height="' . $modal_image[2] . '" data-ratio="' . ($modal_image[1] / $modal_image[2]) . '" data-order="' . $i . '" data-total="' . count($featured_slider) . '">';
															$media_string .= '<a id="' . $timeline_id . '-' . $single_image .'" href="' . $modal_image[0] . '" data-thumbnail="' . $modal_image[0] . '" data-title="' . (((isset($titles_array[$i])) && ($titles_array[$i] != '')) ? strip_tags($titles_array[$i]) : '') . '" class="nch-lightbox-media no-ajaxy ts-hover-image ' . $timeline_id . '-slider-image" rel="' . ($Timeline_Lightboxgroup == "true" ? "timelinegroup" : (isset($Timeline_Lightboxgroupname) ? $Timeline_Lightboxgroupname : "")) . '" data-effect="' . $Timeline_Lightboxeffect . '" ' . $nacho_color . '>';
																$media_string .= '<img src="' . $modal_image[0] . '" style="max-width: ' . $image_width . 'px; max-height: ' . $image_height . 'px; padding: 0; margin: 0 auto; display: block; ' . $image_dimensions . '">';
																$media_string .= '<div class="nchgrid-caption"></div>';
																if ((isset($titles_array[$i])) && ($titles_array[$i] != '')) {
																	$media_string .= '<div class="nchgrid-caption-text">' . strip_tags($titles_array[$i]) . '</div>';
																}
															$media_string .= '</a>';
														$media_string .= '</div>';
													}
												}												
											}
										}
									$media_string .= '</div>';
									$media_string .= '<div class="ts-timeline-css-imageslider-navigation">';
										$media_string .= '<div class="ts-timeline-css-imageslider-dotholder">';
											$i = -1;
											foreach ($featured_slider as $single_image) {
												$i++;
												$media_string .= '<div class="ts-timeline-css-imageslider-dot ' . ($i == 0 ? "ts-timeline-css-imageslider-dotactive" : "") . ' ts-has-tooltipster-tooltip" data-order="' . $i . '" data-image="' . (isset($featured_images[$i]) ? $featured_images[$i] : "") . '" data-tooltipster-html="false" data-tooltipster-title="" data-tooltipster-text="" data-tooltipster-image="' . (isset($featured_images[$i]) ? $featured_images[$i] : "") . '" data-tooltipster-position="top" data-tooltipster-touch="false" data-tooltipster-arrow="true" data-tooltipster-theme="tooltipster-thumb" data-tooltipster-animation="fade" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"></div>';
											}
										$media_string .= '</div>';
										$media_string .= '<div class="ts-timeline-css-imageslider-prev"><i class="dashicons dashicons-arrow-left-alt2"></i></div>';
										$media_string .= '<div class="ts-timeline-css-imageslider-next"><i class="dashicons dashicons-arrow-right-alt2"></i></div>';
									$media_string .= '</div>';
								$media_string .= '</div>';
								$slider_class				= '';								
							}
						} else {
							$slider_class					= '';
						}
						// Featured Media: YouTube
						if (isset($Timeline_Featuredyoutubeurl) && (($Timeline_Featuredmedia == 'youtube_default') || ($Timeline_Featuredmedia == 'youtube_custom') || ($Timeline_Featuredmedia == 'youtube_embed'))) {
							if (preg_match('~((http|https|ftp|ftps)://|www.)(.+?)~', $Timeline_Featuredyoutubeurl)) {
								$featured_youtube_url		= $Timeline_Featuredyoutubeurl;
							} else {
								$featured_youtube_url		= 'https://www.youtube.com/watch?v=' . $Timeline_Featuredyoutubeurl;
							}
							if (isset($Timeline_Featuredyoutubeplay)) {
								if ($Timeline_Featuredyoutubeplay == "true") {
									$video_autoplay			= 'true';
								} else {
									$video_autoplay			= 'false';
								}
							} else {
								$video_autoplay				= 'false';
							}
							if (isset($Timeline_Featuredyoutuberelated)) {
								if ($Timeline_Featuredyoutuberelated == "true") {
									$video_related			= '&rel=1';
								} else {
									$video_related			= '&rel=0';
								}
							} else {
								$video_related				= '&rel=0';
							}
							if (isset($Timeline_Attributetitle)) {
								$media_title 				= $Timeline_Attributetitle;
							} else if (isset($Timeline_Eventtitletext)) {
								$media_title 				= $Timeline_Eventtitletext;
							} else {
								$media_title				= '';
							}	
							if (($Timeline_Featuredmedia == 'youtube_default')) {
								$media_image 				= TS_VCSC_VideoImage_Youtube($featured_youtube_url);
								$media_string .= '<div class="nch-holder nchgrid-item nchgrid-tile nch-lightbox-youtube" style="' . $parent_dimensions . '; ' . $image_alignment . '">';
									$media_string .= '<a href="' . $featured_youtube_url . '" class="nch-lightbox-media no-ajaxy" data-thumbnail="' . $media_image . '" data-title="' . $media_title . '" data-related="' . $video_related . '" data-videoplay="' . $video_autoplay . '" data-type="youtube" rel="' . ($Timeline_Lightboxgroup == "true" ? "timelinegroup" : (isset($Timeline_Lightboxgroupname) ? $Timeline_Lightboxgroupname : "")) . '" data-share="0" data-effect="' . (isset($Timeline_Lightboxeffect) ? $Timeline_Lightboxeffect : 'random') . '" data-duration="5000" ' . $nacho_color . '>';
										$media_string .= '<img src="' . $media_image . '" title="" style="display: block; ' . $image_dimensions . '">';
										$media_string .= '<div class="nchgrid-caption"></div>';
										if ($media_title != '') {
											$media_string .= '<div class="nchgrid-caption-text">' . $media_title . '</div>';
										}
									$media_string .= '</a>';
								$media_string .= '</div>';
							} else if ($Timeline_Featuredmedia == 'youtube_custom') {
								if (isset($Timeline_Featuredimageid)) {
									$media_image			= wp_get_attachment_image_src($Timeline_Featuredimageid, 'full');
									$media_image			= $media_image[0];
									$image_extension		= pathinfo($media_image, PATHINFO_EXTENSION);
									if (isset($Timeline_Attributealtvalue)) {
										$alt_attribute		= $Timeline_Attributealtvalue;
									} else {
										$alt_attribute		= basename($Timeline_Featuredimage, "." . $image_extension);
									}
								} else {
									$media_image			= TS_VCSC_GetResourceURL('images/defaults/default_youtube.jpg');
									$image_extension		= pathinfo($media_image, PATHINFO_EXTENSION);
									if (isset($Timeline_Attributealtvalue)) {
										$alt_attribute		= $Timeline_Attributealtvalue;
									} else {
										$alt_attribute		= basename($media_image, "." . $image_extension);
									}
								}
								$media_string .= '<div class="nch-holder nchgrid-item nchgrid-tile nch-lightbox-youtube" style="' . $parent_dimensions . '; ' . $image_alignment . '">';
									$media_string .= '<a href="' . $featured_youtube_url . '" class="nch-lightbox-media no-ajaxy" data-thumbnail="' . $media_image . '" data-title="' . $media_title . '" data-related="' . $video_related . '" data-videoplay="' . $video_autoplay . '" data-type="youtube" rel="' . ($Timeline_Lightboxgroup == "true" ? "timelinegroup" : (isset($Timeline_Lightboxgroupname) ? $Timeline_Lightboxgroupname : "")) . '" data-share="0" data-effect="' . (isset($Timeline_Lightboxeffect) ? $Timeline_Lightboxeffect : 'random') . '" data-duration="5000" ' . $nacho_color . '>';
										$media_string .= '<img src="' . $media_image . '" title="" style="display: block; ' . $image_dimensions . '">';
										$media_string .= '<div class="nchgrid-caption"></div>';
										if ($media_title != '') {
											$media_string .= '<div class="nchgrid-caption-text">' . $media_title . '</div>';
										}
									$media_string .= '</a>';
								$media_string .= '</div>';
							} else if ($Timeline_Featuredmedia == 'youtube_embed') {
								$video_id 					= TS_VCSC_VideoID_Youtube($featured_youtube_url);
								if ($video_autoplay == "true") {
									$video_autoplay			= '?autoplay=1';
								} else {
									$video_autoplay			= '?autoplay=0';
								}
								$media_string .= '<div class="ts-video-container" style="' . $parent_dimensions . '; ' . $image_alignment . '">';
									$media_string .= '<iframe width="100%" height="auto" src="//www.youtube.com/embed/' . $video_id . $video_autoplay . $video_related . '&wmode=opaque" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
								$media_string .= '</div>';
							}
						}
						// Featured Media: DailyMotion
						if (isset($Timeline_Featureddailymotionurl) && (($Timeline_Featuredmedia == 'dailymotion_default') || ($Timeline_Featuredmedia == 'dailymotion_custom') || ($Timeline_Featuredmedia == 'dailymotion_embed'))) {
							if (preg_match('~((http|https|ftp|ftps)://|www.)(.+?)~', $Timeline_Featureddailymotionurl)) {
								$featured_dailymotion_url	= $Timeline_Featureddailymotionurl;
							} else {
								$featured_dailymotion_url	= 'http://www.dailymotion.com/video/' . $Timeline_Featureddailymotionurl;
							}
							if (isset($Timeline_Featureddailymotionplay)) {
								if ($Timeline_Featureddailymotionplay == "true") {
									$video_autoplay			= 'true';
								} else {
									$video_autoplay			= 'false';
								}
							} else {
								$video_autoplay				= 'false';
							}
							if (isset($Timeline_Attributetitle)) {
								$media_title 				= $Timeline_Attributetitle;
							} else if (isset($Timeline_Eventtitletext)) {
								$media_title 				= $Timeline_Eventtitletext;
							} else {
								$media_title				= '';
							}	
							if (($Timeline_Featuredmedia == 'dailymotion_default')) {
								$media_image 				= TS_VCSC_VideoImage_Motion($featured_dailymotion_url);
								$media_string .= '<div class="nch-holder nchgrid-item nchgrid-tile nch-lightbox-motion" style="' . $parent_dimensions . '; ' . $image_alignment . '">';
									$media_string .= '<a href="' . $featured_dailymotion_url . '" class="nch-lightbox-media no-ajaxy" data-thumbnail="' . $media_image . '" data-title="' . $media_title . '" data-videoplay="' . $video_autoplay . '" data-type="dailymotion" rel="' . ($Timeline_Lightboxgroup == "true" ? "timelinegroup" : (isset($Timeline_Lightboxgroupname) ? $Timeline_Lightboxgroupname : "")) . '" data-share="0" data-effect="' . (isset($Timeline_Lightboxeffect) ? $Timeline_Lightboxeffect : 'random') . '" data-duration="5000" ' . $nacho_color . '>';
										$media_string .= '<img src="' . $media_image . '" title="" style="display: block; ' . $image_dimensions . '">';
										$media_string .= '<div class="nchgrid-caption"></div>';
										if ($media_title != '') {
											$media_string .= '<div class="nchgrid-caption-text">' . $media_title . '</div>';
										}
									$media_string .= '</a>';
								$media_string .= '</div>';
							} else if ($Timeline_Featuredmedia == 'dailymotion_custom') {
								if (isset($Timeline_Featuredimageid)) {
									$media_image			= wp_get_attachment_image_src($Timeline_Featuredimageid, 'full');
									$media_image			= $media_image[0];
									$image_extension		= pathinfo($media_image, PATHINFO_EXTENSION);
									if (isset($Timeline_Attributealtvalue)) {
										$alt_attribute		= $Timeline_Attributealtvalue;
									} else {
										$alt_attribute		= basename($Timeline_Featuredimage, "." . $image_extension);
									}
								} else {
									$media_image			= TS_VCSC_GetResourceURL('images/defaults/default_motion.jpg');
									$image_extension		= pathinfo($media_image, PATHINFO_EXTENSION);
									if (isset($Timeline_Attributealtvalue)) {
										$alt_attribute		= $Timeline_Attributealtvalue;
									} else {
										$alt_attribute		= basename($media_image, "." . $image_extension);
									}
								}
								$media_string .= '<div class="nch-holder nchgrid-item nchgrid-tile nch-lightbox-motion" style="' . $parent_dimensions . '; ' . $image_alignment . '">';
									$media_string .= '<a href="' . $featured_dailymotion_url . '" class="nch-lightbox-media no-ajaxy" data-thumbnail="' . $media_image . '" data-title="' . $media_title . '" data-videoplay="' . $video_autoplay . '" data-type="dailymotion" rel="' . ($Timeline_Lightboxgroup == "true" ? "timelinegroup" : (isset($Timeline_Lightboxgroupname) ? $Timeline_Lightboxgroupname : "")) . '" data-share="0" data-effect="' . (isset($Timeline_Lightboxeffect) ? $Timeline_Lightboxeffect : 'random') . '" data-duration="5000" ' . $nacho_color . '>';
										$media_string .= '<img src="' . $media_image . '" title="" style="display: block; ' . $image_dimensions . '">';
										$media_string .= '<div class="nchgrid-caption"></div>';
										if ($media_title != '') {
											$media_string .= '<div class="nchgrid-caption-text">' . $media_title . '</div>';
										}
									$media_string .= '</a>';
								$media_string .= '</div>';
							} else if ($Timeline_Featuredmedia == 'dailymotion_embed') {
								$video_id 					= TS_VCSC_VideoID_Motion($featured_dailymotion_url);
								if ($video_autoplay == "true") {
									$video_autoplay			= '?autoplay=1';
								} else {
									$video_autoplay			= '?autoplay=0';
								}
								$media_string .= '<div class="ts-video-container" style="' . $parent_dimensions . '; ' . $image_alignment . '">';
									$media_string .= '<iframe width="100%" height="auto" src="http://www.dailymotion.com/embed/video/' . $video_id . $video_autoplay . '&forcedQuality=hq&wmode=opaque" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
								$media_string .= '</div>';
							}
						}
						// Featured Media: Vimeo
						if (isset($Timeline_Featuredvimeourl) && (($Timeline_Featuredmedia == 'vimeo_default') || ($Timeline_Featuredmedia == 'vimeo_custom') || ($Timeline_Featuredmedia == 'vimeo_embed'))) {
							if (preg_match('~((http|https|ftp|ftps)://|www.)(.+?)~', $Timeline_Featuredvimeourl)) {
								$featured_vimeo_url			= $Timeline_Featuredvimeourl;
							} else {
								$featured_vimeo_url			= 'http://www.vimeo.com/video/' . $Timeline_Featuredvimeourl;
							}
							if (isset($Timeline_Featuredvimeoplay)) {
								if ($Timeline_Featuredvimeoplay == "true") {
									$video_autoplay			= 'true';
								} else {
									$video_autoplay			= 'false';
								}
							} else {
								$video_autoplay				= 'false';
							}
							if (isset($Timeline_Attributetitle)) {
								$media_title 				= $Timeline_Attributetitle;
							} else if (isset($Timeline_Eventtitletext)) {
								$media_title 				= $Timeline_Eventtitletext;
							} else {
								$media_title				= '';
							}	
							if (($Timeline_Featuredmedia == 'vimeo_default')) {
								$media_image 				= TS_VCSC_VideoImage_Vimeo($featured_vimeo_url);
								$media_string .= '<div class="nch-holder nchgrid-item nchgrid-tile nch-lightbox-vimeo" style="' . $parent_dimensions . '; ' . $image_alignment . '">';
									$media_string .= '<a href="' . $featured_vimeo_url . '" class="nch-lightbox-media no-ajaxy" data-thumbnail="' . $media_image . '" data-title="' . $media_title . '" data-videoplay="' . $video_autoplay . '" data-type="vimeo" rel="' . ($Timeline_Lightboxgroup == "true" ? "timelinegroup" : (isset($Timeline_Lightboxgroupname) ? $Timeline_Lightboxgroupname : "")) . '" data-share="0" data-effect="' . (isset($Timeline_Lightboxeffect) ? $Timeline_Lightboxeffect : 'random') . '" data-duration="5000" ' . $nacho_color . '>';
										$media_string .= '<img src="' . $media_image . '" title="" style="display: block; ' . $image_dimensions . '">';
										$media_string .= '<div class="nchgrid-caption"></div>';
										if ($media_title != '') {
											$media_string .= '<div class="nchgrid-caption-text">' . $media_title . '</div>';
										}
									$media_string .= '</a>';
								$media_string .= '</div>';
							} else if ($Timeline_Featuredmedia == 'vimeo_custom') {
								if (isset($Timeline_Featuredimageid)) {
									$media_image			= wp_get_attachment_image_src($Timeline_Featuredimageid, 'full');
									$media_image			= $media_image[0];
									$image_extension		= pathinfo($media_image, PATHINFO_EXTENSION);
									if (isset($Timeline_Attributealtvalue)) {
										$alt_attribute		= $Timeline_Attributealtvalue;
									} else {
										$alt_attribute		= basename($Timeline_Featuredimage, "." . $image_extension);
									}
								} else {
									$media_image			= TS_VCSC_GetResourceURL('images/defaults/default_vimeo.jpg');
									$image_extension		= pathinfo($media_image, PATHINFO_EXTENSION);
									if (isset($Timeline_Attributealtvalue)) {
										$alt_attribute		= $Timeline_Attributealtvalue;
									} else {
										$alt_attribute		= basename($media_image, "." . $image_extension);
									}
								}
								$media_string .= '<div class="nch-holder nchgrid-item nchgrid-tile nch-lightbox-vimeo" style="' . $parent_dimensions . '; ' . $image_alignment . '">';
									$media_string .= '<a href="' . $featured_vimeo_url . '" class="nch-lightbox-media no-ajaxy" data-thumbnail="' . $media_image . '" data-title="' . $media_title . '" data-videoplay="' . $video_autoplay . '" data-type="vimeo" rel="' . ($Timeline_Lightboxgroup == "true" ? "timelinegroup" : (isset($Timeline_Lightboxgroupname) ? $Timeline_Lightboxgroupname : "")) . '" data-share="0" data-effect="' . (isset($Timeline_Lightboxeffect) ? $Timeline_Lightboxeffect : 'random') . '" data-duration="5000" ' . $nacho_color . '>';
										$media_string .= '<img src="' . $media_image . '" title="" style="display: block; ' . $image_dimensions . '">';
										$media_string .= '<div class="nchgrid-caption"></div>';
										if ($media_title != '') {
											$media_string .= '<div class="nchgrid-caption-text">' . $media_title . '</div>';
										}
									$media_string .= '</a>';
								$media_string .= '</div>';
							} else if ($Timeline_Featuredmedia == 'vimeo_embed') {
								$video_id 					= TS_VCSC_VideoID_vimeo($featured_vimeo_url);
								if ($video_autoplay == "true") {
									$video_autoplay			= '?autoplay=1';
								} else {
									$video_autoplay			= '?autoplay=0';
								}
								$media_string .= '<div class="ts-video-container" style="' . $parent_dimensions . '; ' . $image_alignment . '">';
									$media_string .= '<iframe width="100%" height="auto" src="//player.vimeo.com/video/' . $video_id . $video_autoplay . '&wmode=opaque" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
								$media_string .= '</div>';
							}
						}
					} else {
						$media_string						= '';
						$slider_class						= '';
					}
					// Link Button
					if (isset($Timeline_Dedicatedpage) && ($Timeline_Dedicatedpage != -1)) {
						// Link Values
						if ($Timeline_Dedicatedpage == "external") {
							$a_href						= $Timeline_Dedicatedlink;
						} else {
							$a_href						= get_page_link($Timeline_Dedicatedpage);
						}
						if (isset($Timeline_Dedicatedtooltip)) {
							$a_title 					= $Timeline_Dedicatedtooltip;
						} else {
							$a_title					= "";
						}
						if (isset($Timeline_Dedicatedtarget)) {
							if ($Timeline_Dedicatedtarget == true) {
								$a_target				= "_blank";
							} else {
								$a_target				= "_windows";
							}
						} else {
							$a_target					= "_blank";
						}
						// Button Alignment
						if (isset($Timeline_Dedicatedalign)) {
							if ($Timeline_Dedicatedalign == "center") {
								$buttonstyle			= "width: " . (isset($Timeline_Dedicatedwidth) ? $Timeline_Dedicatedwidth : 100) . "%; margin: 0 auto; float: none;";
							} else if ($Timeline_Dedicatedalign == "left") {
								$buttonstyle			= "width: " . (isset($Timeline_Dedicatedwidth) ? $Timeline_Dedicatedwidth : 100) . "%; margin: 0 auto; float: left;";
							} else if ($Timeline_Dedicatedalign == "right") {
								$buttonstyle			= "width: " . (isset($Timeline_Dedicatedwidth) ? $Timeline_Dedicatedwidth : 100) . "%; margin: 0 auto; float: right;";
							}
						} else {
							$buttonstyle				= 'width: 100%; margin: 0 auto; float: none;';
						}
						$button_string					= '';					
						if ((!empty($a_href)) && isset($Timeline_Dedicatedlabel)) {				
							$button_string .= '<div class="ts-timeline-css-button-outer clearFixMe">';
								$button_string .= '<div class="ts-timeline-css-button-wrapper" style="' . $buttonstyle . '%;">';
								if (isset($Timeline_Dedicatedicon)) {
									if ($Timeline_Dedicatedicon != "none") {
										$button_string .= '<a class="ts-timeline-css-button-link ' . $Timeline_Dedicateddefault . ' ' . $Timeline_Dedicatedhover . '" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '"><i class="ts-timeline-css-button-icon dashicons dashicons-' . $Timeline_Dedicatedicon . '" style="' . (isset($Timeline_Dedicatedcolor) ? "color: " . $Timeline_Dedicatedcolor : "") . '"></i>' . $Timeline_Dedicatedlabel . '</a>';
									} else {
										$button_string .= '<a class="ts-timeline-css-button-link ' . $Timeline_Dedicateddefault . ' ' . $Timeline_Dedicatedhover . '" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '">' . $Timeline_Dedicatedlabel . '</a>';
									}
								} else {
									$button_string .= '<a class="ts-timeline-css-button-link ' . $Timeline_Dedicateddefault . ' ' . $Timeline_Dedicatedhover . '" href="' . $a_href . '" target="' . $a_target . '" title="' . $a_title . '">' . $Timeline_Dedicatedlabel . '</a>';
								}
								$button_string .= '</div>';
							$button_string .= '</div>';						
						} else {
							$button_string				= '';
						}
					} else {
						$button_string					= '';
					}
					
					// Event Icon	
					if (((empty($section_icon)) || ($section_icon == "transparent")) && (!isset($Timeline_Eventcontent)) && (!isset($Timeline_Featuredimage))) {
						$title_margin					= 'margin: 0;';
					} else {
						$title_margin					= '';
					}
					
					// Column Adjustment for Full Width Event
					if (($Timeline_Fullwidth == "true") && (!isset($Timeline_Eventtitletext)) && (empty($section_icon) || ($section_icon == "transparent")) && (!isset($Timeline_Eventcontent)) && (!isset($Timeline_Buttontext))) {
						$columnA_adjust					= 'width: 100%; margin: 0;';
						$columnB_adjust					= 'display: none; width: 0;';
					} else if (($Timeline_Fullwidth == "true") && ($Timeline_Featuredmedia == "none")) {
						$columnA_adjust					= 'display: none; width: 0; margin: 0;';
						$columnB_adjust					= 'width: 100%; margin: 0;';
					} else {
						$columnA_adjust					= '';
						$columnB_adjust					= '';
					}
					
					// Final Output
					$output .= '<div id="' . $timeline_id . '" class="' . $css_class . ' ' . $slider_class . ' ' . ($Timeline_Fullwidth == "true" ? "ts-timeline-css-fullwidth" : "ts-timeline-css-event") . ' ts-timeline-css-visible ts-timeline-css-animated ' . (isset($Timeline_Eventdatetext) ? "ts-timeline-css-date-true" : "ts-timeline-css-date-false") . '" style="' . ($Timeline_Fullwidth == "true" ? "width: 98%;" : "") . ' ' . $vc_inline_style . '" data-categories="' . $Section_Categories . '" data-tags="' . $Section_Tags . '" data-filtered-categories="false" data-filtered-tags="false">';
						$output .= '<div class="ts-timeline-css-text-wrap ' . (isset($Timeline_Eventdatetext) ? "ts-timeline-css-text-wrap-date" : "ts-timeline-css-text-wrap-nodate") . ' ' . $border_radius . ' ' . $tooltip_class . '" ' . $tooltip_content . ' style="' . (isset($Timeline_Eventdatetext) ? "padding-top: 35px" : "") . '">';
							if (isset($Timeline_Eventdatetext)) {
								if (isset($Timeline_Eventdateicon)) {
									if ($Timeline_Eventdateicon == "none") {
										$output .= '<div class="ts-timeline-css-date"><span class="ts-timeline-css-date-connect"><span class="ts-timeline-css-date-text">' . $Timeline_Eventdatetext . '</span></span></div>';
									} else {
										$output .= '<div class="ts-timeline-css-date"><span class="ts-timeline-css-date-connect"><span class="ts-timeline-css-date-text"><i class="ts-timeline-css-date-icon dashicons dashicons-' . $Timeline_Eventdateicon . '"></i>' . $Timeline_Eventdatetext . '</span></span></div>';
									}
								} else {
									$output .= '<div class="ts-timeline-css-date"><span class="ts-timeline-css-date-connect"><span class="ts-timeline-css-date-text">' . $Timeline_Eventdatetext . '</span></span></div>';
								}
							}
							if ($Timeline_Fullwidth == "true") {
								$output .= '<div class="ts-timeline-css-fullwidth-colA" style="' . $columnA_adjust . '">';
									$output .= $media_string;
								$output .= '</div>';
								$output .= '<div class="ts-timeline-css-fullwidth-colB" style="' . $columnB_adjust . '">';
									if (isset($Timeline_Eventtitletext)) {
										$output .= '<h3 class="ts-timeline-css-title" style="color: ' . (isset($Timeline_Eventtitlecolor) ? $Timeline_Eventtitlecolor : $title_color) . '; text-align: ' . (isset($Timeline_Eventtitlealign) ? $Timeline_Eventtitlealign : $title_align) . '; ' . (!isset($Timeline_Eventcontent) && (empty($section_icon)) ? "border: none; margin-bottom: 0; padding-bottom: 0;" : "") . ' ' . $title_margin . '">' . $Timeline_Eventtitletext . '</h3>';
									}
									if (((!empty($section_icon)) && (($section_icon) != "transparent")) || (isset($Timeline_Eventcontent)) || (isset($Timeline_Linkurl))) {
										$output .= '<div style="width: 100%; display: block; float: left; position: relative; padding-bottom: ' . (((!empty($a_href)) && (!empty($button_string))) ? 0 : 15) . 'px; ' . (!isset($Timeline_Eventcontent) && !empty($section_icon) ? "height: 60px;" : "") . '">';
											if (isset($Timeline_Eventcontent)) {
												$output .= '<div class="ts-timeline-css-text-wrap-inner" style="' . (empty($section_icon) ? "width: 100%; height: 100%; left: 0;" : " left: 0;") . '">';
													if (function_exists('wpb_js_remove_wpautop')){
														$output .= '<div class="ts-timeline-css-text" style="">' . wpb_js_remove_wpautop(do_shortcode($Timeline_Eventcontent), true) . '</div>';
													} else {
														$output .= '<div class="ts-timeline-css-text" style="">' . do_shortcode($Timeline_Eventcontent) . '</div>';
													}
												$output .= '</div>';
											}
											if ((!empty($section_icon)) && (($section_icon) != "transparent")) {
												$output .= '<div class="ts-timeline-css-icon ts-timeline-css-icon-full" style="' . (!isset($Timeline_Eventcontent) ? "display: inline-block; width: 100%; left: 0; margin: 0 0 0 2%;" : "left: 80%;") . '"><i class="' . $section_icon . '" style="color: ' . $icon_color . ';"></i></div>';
											}
											if ((!empty($a_href)) && (!empty($button_string))) {
												$output .= '<div class="ts-timeline-css-button-container">';
													$output .= $button_string;
												$output .= '</div>';
											}
										$output .= '</div>';
									}
								$output .= '</div>';
								if ($Section_Tags != '') {
									$output .= '<div class="ts-timeline-css-output-tags"><i class="dashicons dashicons-tag"></i><span>' . str_replace(",", ", ", $Section_Tags) . '</span></div>';
								}
								if ($Section_Categories != '') {
									$output .= '<div class="ts-timeline-css-output-cats"><i class="dashicons dashicons-category"></i><span>' . str_replace(",", ", ", $Section_Categories) . '</span></div>';
								}
							} else {
								$output .= $media_string;
								if (isset($Timeline_Eventtitletext)) {
									$output .= '<h3 class="ts-timeline-css-title" style="color: ' . (isset($Timeline_Eventtitlecolor) ? $Timeline_Eventtitlecolor : $title_color) . '; text-align: ' . (isset($Timeline_Eventtitlealign) ? $Timeline_Eventtitlealign : $title_align) . '; ' . (!isset($Timeline_Eventcontent) && (empty($section_icon)) ? "border: none; margin-bottom: 0; padding-bottom: 0;" : "") . ' ' . $title_margin . '">' . $Timeline_Eventtitletext . '</h3>';
								}
								if (((!empty($section_icon)) && (($section_icon) != "transparent")) || (isset($Timeline_Eventcontent))) {
									$output .= '<div style="width: 100%; display: block; float: left; position: relative; padding-bottom: 15px; ' . (!isset($Timeline_Eventcontent) && !empty($section_icon) ? "height: 60px;" : "") . '">';
										if ((!empty($section_icon)) && (($section_icon) != "transparent")) {
											$output .= '<div class="ts-timeline-css-icon ts-timeline-css-icon-half" style="' . (!isset($Timeline_Eventcontent) ? "display: inline-block; width: 100%; left: 0;" : "") . '"><i class="' . $section_icon . '" style="color: ' . $icon_color . ';"></i></div>';
										}
										if (isset($Timeline_Eventcontent)) {
											$output .= '<div class="ts-timeline-css-text-wrap-inner" style="' . (empty($section_icon) ? "width: 100%; height: 100%; left: 0;" : "") . '">';
												if (function_exists('wpb_js_remove_wpautop')){
													$output .= '<div class="ts-timeline-css-text" style="">' . wpb_js_remove_wpautop(do_shortcode($Timeline_Eventcontent), true) . '</div>';
												} else {
													$output .= '<div class="ts-timeline-css-text" style="">' . do_shortcode($Timeline_Eventcontent) . '</div>';
												}
											$output .= '</div>';
										}
									$output .= '</div>';
									if ((!empty($a_href)) && (!empty($button_string))) {
										$output .= '<div class="ts-timeline-css-button-container">';
											$output .= $button_string;
										$output .= '</div>';
									}
								}
								if ($Section_Tags != '') {
									$output .= '<div class="ts-timeline-css-output-tags"><i class="dashicons dashicons-tag"></i><span>' . str_replace(",", ", ", $Section_Tags) . '</span></div>';
								}
								if ($Section_Categories != '') {
									$output .= '<div class="ts-timeline-css-output-cats"><i class="dashicons dashicons-category"></i><span>' . str_replace(",", ", ", $Section_Categories) . '</span></div>';
								}
							}
							$output .= '<div class="clearFixMe"></div>';
						$output .= '</div>';
					$output .= '</div>';				
				}
				// Timeline Break
				if ($Timeline_Type == "break") {
					if (!isset($Timeline_Breakcontent)) {
						$title_margin					= ' margin: 0 !important; padding: 0;';
					} else {
						$title_margin					= '';
					}
					if (isset($Timeline_Breakfull)) {
						if ($Timeline_Breakfull == "true") {
							$break_width				= 'width: 98%; margin-left: 1%; margin-right: 1%;';
							$break_data					= 'true';
						} else {
							$break_width				= 'width: 50%;';
							$break_data					= 'false';
						}
					} else {
						$break_width					= 'width: 50%;';
						$break_data						= 'false';
					}
					if (isset($Timeline_Breakbackground)) {
						$break_background				= 'background: ' . $Timeline_Breakbackground . ';';
					} else {
						$break_background				= '';
					}
					$output .= '<div id="' . $timeline_id . '" class="ts-timeline-css-break ts-timeline-css-visible ' . $css_class . '" style="' . $break_width . ' ' . $vc_inline_style . '" data-fullwidth="' . $break_data . '" data-categories="' . $Section_Categories . '" data-tags="' . $Section_Tags . '" data-filtered-categories="false" data-filtered-tags="false">';
						$output .= '<div class="ts-timeline-css-text-wrap ' . $border_radius . ' ' . $tooltip_class . '" ' . $tooltip_content . ' style="' . $break_background . '">';
							$output .= '<div class="ts-timeline-css-text-wrap-inner" style="width: 100%; left: 0; ' . $title_margin . '">';
								if (isset($Timeline_Breaktitletext)) {
									$output .= '<h3 class="ts-timeline-css-title" style="padding: 0 10px; text-align: ' . (isset($Timeline_Breaktitlealign) ? $Timeline_Breaktitlealign : $title_align) . '; color: ' . (isset($Timeline_Breaktitlecolor) ? $Timeline_Breaktitlecolor : $title_color) . ';' . $title_margin . '">' . $Timeline_Breaktitletext . '</h3>';
								}
								if ((!empty($section_icon)) && (($section_icon) != "transparent")) {
									$output .= '<div class="ts-timeline-css-icon ts-timeline-css-icon-break" style="margin: 10px auto;"><i class="' . $section_icon . '" style="color: ' . $icon_color . ';"></i></div>';
								}
								if (isset($Timeline_Breakcontent)) {
									if (function_exists('wpb_js_remove_wpautop')){
										$output .= '<div class="ts-timeline-css-text">' . wpb_js_remove_wpautop(do_shortcode($Timeline_Breakcontent), true) . '</div>';
									} else {
										$output .= '<div class="ts-timeline-css-text">' . do_shortcode($Timeline_Breakcontent) . '</div>';
									}
								}
							$output .= '</div>';
							$output .= '<div class="clearFixMe"></div>';
						$output .= '</div>';
					$output .= '</div>';
				}
			} else {
				$output .= '<div id="' . $timeline_id . '" class="' . $css_class . ' ts-timeline-css-fullwidth" style="width: 98%; ' . $vc_inline_style . '">';
					$output .= '<div class="ts-timeline-css-text-wrap">';
						$output .= '<div class="ts-timeline-css-text-wrap-inner" style="width: 100%; left: 0; margin: 20px auto;">';
							$output .= '<div>Section ID: ' . $Section_ID . '</div>';
							$output .= '<div>Section Title: ' . $Section_Title . '</div>';
							$output .= '<div>Section Type: ' . (($Timeline_Type == "event") ? "Event" : "Break") . '</div>';
						$output .= '</div>';
						$output .= '<div class="clearFixMe"></div>';
					$output .= '</div>';
				$output .= '</div>';
			}
			
			echo $output;
			
			// Clear Out all Variables
            foreach ($custom_fields_array as $index => $array) {
                ${$custom_fields_array[$index]['name']} = "";
				unset(${$custom_fields_array[$index]['name']});
            }
			$custom_fields_array				= '';
            $timeline_array						= '';
            $category_fields 	                = '';
			$media_string						= '';
			$output 							= '';
			
			$myvariable = ob_get_clean();
			return $myvariable;
		}
		
		// Timeline Container
        function TS_VCSC_Timeline_CSS_Function_Container ($atts, $content = null){
            global $VISUAL_COMPOSER_EXTENSIONS;
            ob_start();
            
			wp_enqueue_style('ts-extend-csstimeline');
			wp_enqueue_script('ts-extend-csstimeline');	
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
				wp_enqueue_script('ts-extend-hammer');
				wp_enqueue_script('ts-extend-nacho');
				wp_enqueue_style('ts-extend-nacho');
				wp_enqueue_style('ts-font-ecommerce');
				wp_enqueue_style('dashicons');
				wp_enqueue_style('ts-extend-tooltipster');
				wp_enqueue_script('ts-extend-tooltipster');	
				wp_enqueue_style('ts-extend-buttonsdual');
				wp_enqueue_script('ts-visual-composer-extend-front');
			}
            
            extract( shortcode_atts( array(
				'timeline_order'				=> 'asc',
				'timeline_sort'					=> 'true',
				'timeline_sort_label'			=> 'Sort Timeline:',
				'timeline_sort_asc'				=> 'Ascending',
				'timeline_sort_desc'			=> 'Descending',
				
				'timeline_lazy'					=> 'false',
				'timeline_trigger'				=> 'scroll',
				'timeline_count'				=> '10',
				'timeline_break'				=> '600',
				'timeline_layout'				=> 'ts-timeline-css-columns', // ts-timeline-css-columns, ts-timeline-css-right, ts-timeline-css-left, ts-timeline-css-responsive
				'timeline_switch'				=> 'ts-timeline-css-responsive',
				
				'timeline_title'				=> '',
				'timeline_title_color'			=> '#7c7979',
				'timeline_title_show'			=> 'true',
				'timeline_load'					=> 'Load More',
				'timeline_start'				=> '',
				'timeline_end'					=> '',
				'timeline_description'			=> '',
				'timeline_description_align'	=> 'center',
				'timeline_description_color'	=> '#7c7979',
				
				'timeline_show_cats'			=> 'true',
				'timeline_show_tags'			=> 'true',
				
				'timeline_filter_allow'			=> 'false',
				'timeline_filter_cats'			=> 'true',
				'timeline_filter_tags'			=> 'true',
				'timeline_filter_labelcats'		=> 'Filter By Categories:',
				'timeline_filter_labeltags'		=> 'Filter By Tags:',
				'timeline_filter_nocats'		=> 'No Categories',
				'timeline_filter_notags'		=> 'No Tags',
				'timeline_filter_selected'		=> 'Selected',
				'timeline_filter_selectall'		=> 'Select All',
				
				'margin_bottom'					=> '0',
				'margin_top' 					=> '0',
				
				'el_id' 						=> '',
				'el_class'                  	=> '',
				'css'							=> '',
            ), $atts ));
			
			if (($timeline_filter_allow == "true") && ($timeline_filter_cats == "false") && ($timeline_filter_tags == "false")) {
				$timeline_filter_allow			= "false";
			}
			
			if (($timeline_filter_allow == "true") || ($timeline_sort == "true")) {
				wp_enqueue_style('ts-extend-sumo');
				wp_enqueue_script('ts-extend-sumo');
			}
            
            $timeline_random                 	= mt_rand(999999, 9999999);
            
            if (!empty($el_id)) {
                $timeline_container_id			= $el_id;
            } else {
                $timeline_container_id			= 'ts-vcsc-timeline-css-container-' . $timeline_random;
            }
            
            $output 							= '';
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$vcinline_class					= 'ts-timeline-css-edit';
				$vcinline_note					= '<div class="ts-composer-frontedit-message">' . __( 'This timeline is currently viewed in Visual Composer front-end editor mode. It is advised to edit such a complex element in back-end edit mode in order to avoid potential conflicts with other files loaded on the front-end of your website. The timeline is not functional in order to ensure display compatibility with the front-end editor.', "ts_visual_composer_extend" ) . '</div>';
				$vcinline_margin				= 35;
				$vcinline_controls				= 'false';
				$timeline_lazy					= 'false';
			} else {
				$vcinline_class					= 'ts-timeline-css-view';
				$vcinline_note					= '';
				$vcinline_margin				= $margin_top;
				$vcinline_controls				= 'true';
				$timeline_lazy					= $timeline_lazy;
			}

			$timeline_class						= 'ts-timeline-css-container-' . str_replace("ts-timeline-css-", "", $timeline_layout);
			
			if ($timeline_filter_allow == "true") {
				$timeline_filter_data			= 'data-filter-allow="' . $timeline_filter_allow . '" data-filter-categories="' . $timeline_filter_cats . '" data-filter-tags="' . $timeline_filter_tags . '" data-filter-nocats="' . $timeline_filter_nocats . '" data-filter-notags="' . $timeline_filter_notags . '" data-filter-selected="' . $timeline_filter_selected . '" data-filter-selectall="' . $timeline_filter_selectall . '"';
			} else {
				$timeline_filter_data			= 'data-filter-allow="' . $timeline_filter_allow . '"';
			}
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-timeline-css-container ts-timeline-css-container-' . $timeline_order . ' clearFixMe ' . $el_class . ' ' . $vcinline_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Timeline_CSS_Container', $atts);
			} else {
				$css_class	= 'ts-timeline-css-container ts-timeline-css-container-' . $timeline_order . ' clearFixMe ' . $el_class . ' ' . $vcinline_class;
			}
			
			$output .= '<div id="' . $timeline_container_id . '" class="' . $css_class . ' ' . $timeline_class . '" data-type="timeline" data-layout="' . $timeline_layout . '" ' . $timeline_filter_data . ' data-sorter="' . $timeline_sort . '" data-switch="' . $timeline_switch . '" data-order="' . $timeline_order .'" data-lazy="' . $timeline_lazy . '" data-count="' . $timeline_count . '" data-trigger="' . $timeline_trigger . '" data-break="' . $timeline_break . '" style="margin-top: ' . $vcinline_margin . 'px; margin-bottom: ' . $margin_bottom . 'px; width: 100%;">';
				$output .= $vcinline_note;
				//$output .= '<div class="ts-timeline-css-preloader"></div>';
				
				// Filter Controls
				if (($timeline_filter_allow == "true") && (($timeline_filter_cats == "true") || ($timeline_filter_tags == "true"))) {
					// Categories Filter
					if ($timeline_filter_cats == "true") {
						$output .= '<div id="ts-timeline-css-filters-cats-' . $timeline_random . '" class="ts-timeline-css-filters-cats ts-timeline-css-filters" data-random="' . $timeline_random . '" data-target="ts-timeline-css-content-' . $timeline_random . '" style="display: none;">';
							$output .= '<label class="ts-timeline-css-filters-cats-label" style="display: inline-block; margin-left: 0;" for="ts-timeline-css-filters-cats-sections-' . $timeline_random . '">' . $timeline_filter_labelcats . '</label>';
								$output .= '<select id="ts-timeline-css-filters-cats-sections-' . $timeline_random . '" class="ts-timeline-css-filters-cats-sections" multiple="multiple" data-option="ts-timeline-css-filters-cats-sections-' . $timeline_random . '" data-target="ts-timeline-css-content-' . $timeline_random . '"></select>';
						$output .= '</div>';
					}
					// Tags Filter
					if ($timeline_filter_tags == "true") {
						$output .= '<div id="ts-timeline-css-filters-tags-' . $timeline_random . '" class="ts-timeline-css-filters-tags ts-timeline-css-filters" data-random="' . $timeline_random . '" data-target="ts-timeline-css-content-' . $timeline_random . '" style="display: none;">';
							$output .= '<label class="ts-timeline-css-filters-tags-label" style="display: inline-block; margin-left: 0;" for="ts-timeline-css-filters-tags-sections-' . $timeline_random . '">' . $timeline_filter_labeltags . '</label>';
							$output .= '<select id="ts-timeline-css-filters-tags-sections-' . $timeline_random . '" class="ts-timeline-css-filters-tags-sections" multiple="multiple" data-option="ts-timeline-css-filters-tags-sections-' . $timeline_random . '" data-target="ts-timeline-css-content-' . $timeline_random . '"></select>';
						$output .= '</div>';
					}
				}
				
				// Sorter Controls
				if (($timeline_sort == "true") && ($vcinline_controls == "true")) {
					$output .= '<div id="ts-timeline-css-sorter-' . $timeline_random . '" class="ts-timeline-css-sorter" data-random="' . $timeline_random . '" data-target="ts-timeline-css-content-' . $timeline_random . '" style="display: none;">';
						$output .= '<label class="ts-timeline-css-sorter-label" style="display: inline-block; margin-left: 0;" for="ts-timeline-css-filters-tags-sections-' . $timeline_random . '">' . $timeline_sort_label . '</label>';
						$output .= '<select id="ts-timeline-css-sorter-sections-' . $timeline_random . '" class="ts-timeline-css-sorter-sections" data-option="ts-timeline-css-sorter-sections-' . $timeline_random . '" data-target="ts-timeline-css-content-' . $timeline_random . '">';
							$output .= '<option value="asc" ' . ($timeline_order == 'asc' ? 'selected="selected"' : '') . '>' . $timeline_sort_asc . '</option>';
							$output .= '<option value="desc" ' . ($timeline_order == 'desc' ? 'selected="selected"' : '') . '>' . $timeline_sort_desc . '</option>';
						$output .= '</select>';
					$output .= '</div>';
				}
				
				// Timeline Title
				if (!empty($timeline_title)) {
					$output .= '<div class="ts-timeline-css-title-wrapper">';
						$output .= '<div class="ts-timeline-css-title-string" style="color: ' . $timeline_title_color . ';">' . $timeline_title . '</div><div class="ts-timeline-css-title-after"></div>';
					$output .= '</div>';
				}
				
				if (!empty($timeline_end)) {
					$output .= '<div class="ts-timeline-css-begin ts-timeline-css-begin-top">';
						$output .= '<div class="ts-timeline-css-begin-text">' . $timeline_end . '</div>';
					$output .= '</div>';
				}
				if ((!empty($timeline_title)) || (!empty($timeline_description)) || (!empty($timeline_end))) {
					$output .= '<div class="ts-timeline-css-header-wrap">';
						if ((!empty($timeline_title)) || (!empty($timeline_description))) {
							$output .= '<div class="ts-timeline-css-header">';
								if ((!empty($timeline_title)) && ($timeline_title_show == "true")) {
									$output .= '<h4 class="ts-timeline-css-header-title" style="color: ' . $timeline_title_color . ';">' . $timeline_title . '</h4>';
								}
								if (!empty($timeline_description)) {
									$output .= '<p class="ts-timeline-css-header-description" style="color: ' . $timeline_description_color . '; text-align: ' . $timeline_description_align . ';">' . rawurldecode(base64_decode(strip_tags($timeline_description))) . '</p>';
								}
							$output .= '</div>';
						}
						if (!empty($timeline_start)) {
							$output .= '<div class="ts-timeline-css-end">';
								$output .= '<div class="ts-timeline-css-end-text">' . $timeline_start . '</div>';
							$output .= '</div>';
						}
					$output .= '</div>';
				}
				
				$output .= '<div class="ts-timeline-css-wrapper ' . $timeline_layout . '">';
					$output .= '<div id="ts-timeline-css-spine-' . $timeline_random . '" class="ts-timeline-css-spine ts-timeline-css-animated"></div>';
					$output .= '<div id="ts-timeline-css-content-' . $timeline_random . '" class="ts-timeline-css-content ' . ($timeline_show_cats == "true" ? "ts-timeline-css-content-show-cats" : "ts-timeline-css-content-hide-cats") . ' ' . ($timeline_show_tags == "true" ? "ts-timeline-css-content-show-tags" : "ts-timeline-css-content-hide-tags") . '">';
						$output .= do_shortcode($content);
					$output .= '</div>';
				$output .= '</div>';
				
				if ($timeline_lazy == "true") {
					$output .= '<div class="ts-timeline-css-showmore-wrap">';
						$output .= '<span class="ts-timeline-css-showmore ts-dual-buttons-color-peter-river-flat ts-dual-buttons-color-belize-hole-flat">' . $timeline_load . '</span>';
					$output .= '</div>';
				}
				
				if ((!empty($timeline_title)) || (!empty($timeline_description)) || (!empty($timeline_end))) {
					$output .= '<div class="ts-timeline-css-footer-wrap">';
						if (!empty($timeline_start)) {
							$output .= '<div class="ts-timeline-css-end">';
								$output .= '<div class="ts-timeline-css-end-text">' . $timeline_start . '</div>';
							$output .= '</div>';
						}
						if ((!empty($timeline_title)) || (!empty($timeline_description))) {
							$output .= '<div class="ts-timeline-css-footer">';
								if (!empty($timeline_title)) {
									$output .= '<h4 class="ts-timeline-css-footer-title" style="color: ' . $timeline_title_color . ';">' . $timeline_title . '</h4>';
								}
								if (!empty($timeline_description)) {
									$output .= '<p class="ts-timeline-css-footer-description" style="color: ' . $timeline_description_color . '; text-align: ' . $timeline_description_align . ';">' . rawurldecode(base64_decode(strip_tags($timeline_description))) . '</p>';
								}
							$output .= '</div>';
						}
					$output .= '</div>';
				}
				if (!empty($timeline_end)) {
					$output .= '<div class="ts-timeline-css-begin ts-timeline-css-begin-bottom">';
						$output .= '<div class="ts-timeline-css-begin-text">' . $timeline_end . '</div>';
					$output .= '</div>';
				}

			$output .= '</div>';
            
            echo $output;
            
            $myvariable = ob_get_clean();
            return $myvariable;
        }
		
		// Add Timeline Elements
        function TS_VCSC_Add_Timeline_CSS_Elements() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			// Add Section Element
			if (function_exists('vc_map')) {
				vc_map( array(
					"name"                      		=> __( "TS Timeline Section", "ts_visual_composer_extend" ),
					"base"                      		=> "TS_VCSC_Timeline_CSS_Section",
					"icon" 	                    		=> "icon-wpb-ts_vcsc_timeline_css_section",
					"class"                     		=> "",
					"category"                  		=> __( 'VC Extensions', "ts_visual_composer_extend" ),
					"description"               		=> __("Place a timeline section element", "ts_visual_composer_extend"),
                    "content_element"					=> true,
                    "as_child"							=> array('only' => 'TS_VCSC_Timeline_CSS_Container'),
					"admin_enqueue_js"					=> "",
					"admin_enqueue_css"					=> "",
					"params"                    		=> array(
						// Timeline Settings
						array(
							"type"              		=> "seperator",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "seperator_1",
							"value"						=> "",
							"seperator"					=> "Timeline Section",
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),
                        array(
                            "type"						=> "custompost",
                            "heading"					=> __( "Timeline Section", "ts_visual_composer_extend" ),
                            "param_name"				=> "section",
                            "posttype"					=> "ts_timeline",
                            "posttaxonomy"				=> "ts_timeline_category",
							"taxonomy"					=> "ts_timeline_category",
							"postsingle"				=> "Timeline Section",
							"postplural"				=> "Timeline Sections",
							"postclass"					=> "timeline",
                            "value"						=> "",
                            "description"				=> __( "", "ts_visual_composer_extend" )
                        ),
                        array(
                            "type"						=> "hidden_input",
                            "heading"					=> __( "Section Title", "ts_visual_composer_extend" ),
                            "param_name"				=> "custompost_name",
                            "value"						=> "",
                            "admin_label"				=> true,
                            "description"				=> __( "", "ts_visual_composer_extend" )
                        ),
						array(
							'type' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
							'heading' 					=> __( 'Section Icon', 'ts_visual_composer_extend' ),
							'param_name' 				=> 'section_icon',
							'value'						=> '',
							'source'					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorValue,
							'settings' 					=> array(
								'emptyIcon' 					=> true,
								'type' 							=> 'extensions',
								'iconsPerPage' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
								'source' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorSource,
							),
							"description"       		=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon to be shown with the section content.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
							"dependency"        		=> array( 'element' => "section", 'not_empty' => true )
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Icon Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "icon_color",
							"value"             		=> "#7c7979",
							"description"       		=> __( "Define the icon color to be used in the timeline item.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "section", 'not_empty' => true )
						),
						// Other Settings
						array(
							"type"              		=> "seperator",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "seperator_2",
							"value"						=> "",
							"seperator"					=> "Other Settings",
							"description"       		=> __( "", "ts_visual_composer_extend" ),
							"group" 					=> "Other Settings",
						),
						array(
							"type"						=> "nouislider",
							"heading"					=> __( "Tooltip X-Offset", "ts_visual_composer_extend" ),
							"param_name"				=> "tooltipster_offsetx",
							"value"						=> "0",
							"min"						=> "-100",
							"max"						=> "100",
							"step"						=> "1",
							"unit"						=> 'px',
							"description"				=> __( "Define an optional X-Offset for any tooltips used in this timeline section.", "ts_visual_composer_extend" ),
							"group" 					=> "Other Settings",
						),
						array(
							"type"						=> "nouislider",
							"heading"					=> __( "Tooltip Y-Offset", "ts_visual_composer_extend" ),
							"param_name"				=> "tooltipster_offsety",
							"value"						=> "0",
							"min"						=> "-100",
							"max"						=> "100",
							"step"						=> "1",
							"unit"						=> 'px',
							"description"				=> __( "Define an optional Y-Offset for any tooltips used in this timeline section.", "ts_visual_composer_extend" ),
							"group" 					=> "Other Settings",
						),	
						array(
							"type"              		=> "textfield",
							"heading"          	 		=> __( "Define ID Name", "ts_visual_composer_extend" ),
							"param_name"        		=> "el_id",
							"value"             		=> "",
							"description"       		=> __( "Enter an unique ID for the element.", "ts_visual_composer_extend" ),
							"group" 					=> "Other Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "Extra Class Name", "ts_visual_composer_extend" ),
							"param_name"        		=> "el_class",
							"value"             		=> "",
							"description"      		 	=> __( "Enter a class name for the element.", "ts_visual_composer_extend" ),
							"group" 					=> "Other Settings",
						),
						// Load Custom CSS/JS File
						array(
							"type"              		=> "load_file",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"value"             		=> "Timeline Files",
							"param_name"        		=> "el_file",
							"file_type"         		=> "js",
							"file_path"         		=> "js/ts-visual-composer-extend-element.min.js",
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),
					))
				);
			}
			// Add Timeline Container Element
            if (function_exists('vc_map')) {
                vc_map(array(
					"name"                              => __("TS CSS Media Timeline", "ts_visual_composer_extend"),
					"base"                              => "TS_VCSC_Timeline_CSS_Container",
					"class"                             => "",
					"icon"                              => "icon-wpb-ts_vcsc_timeline_css_container",
					"category"                          => __("VC Extensions", "ts_visual_composer_extend"),
					"as_parent"                         => array('only' => 'TS_VCSC_Timeline_CSS_Section'),
					"description"                       => __("Build a custom Media Timeline", "ts_visual_composer_extend"),
					"controls" 							=> "full",
					"content_element"                   => true,
					"is_container" 						=> true,
					"container_not_allowed" 			=> false,
					"show_settings_on_create"           => true,
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
					"params"                            => array(
						// General Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_1",
							"value"						=> "",
                            "seperator"					=> "General Setup",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Timeline Standard Layout", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_layout",
							"width"             		=> 200,
							"value"             		=> array(
								__( 'Dual Columns with Center Spine', "ts_visual_composer_extend" )				=> "ts-timeline-css-columns",
								__( 'One Column with Center Spine', "ts_visual_composer_extend" )				=> "ts-timeline-css-responsive",
								__( 'One Column Right with Left Spine', "ts_visual_composer_extend" )			=> "ts-timeline-css-right",
								__( 'One Column Left with Right Spine', "ts_visual_composer_extend" )			=> "ts-timeline-css-left",
							),
							"admin_label"           	=> true,
							"description"       		=> __( "Select the standard layout for the timeline.", "ts_visual_composer_extend" )
						),
                        array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "One Column Breakpoint", "ts_visual_composer_extend" ),
                            "param_name"                => "timeline_break",
                            "value"                     => "600",
                            "min"                       => "100",
                            "max"                       => "2048",
                            "step"                      => "1",
                            "unit"                      => 'px',
							"admin_label"           	=> true,
                            "description"               => __( "Define a breakpoint in pixels at which the timeline should switch to a one column layout.", "ts_visual_composer_extend" )
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Timeline Switch Layout", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_switch",
							"width"             		=> 200,
							"value"             		=> array(
								__( 'One Column with Center Spine', "ts_visual_composer_extend" )				=> "ts-timeline-css-responsive",
								__( 'One Column Right with Left Spine', "ts_visual_composer_extend" )			=> "ts-timeline-css-right",
								__( 'One Column Left with Right Spine', "ts_visual_composer_extend" )			=> "ts-timeline-css-left",
							),
							"admin_label"           	=> true,
							"description"       		=> __( "Select the layout to which the timeline should switch if the breakpoint is triggered.", "ts_visual_composer_extend" )
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Initial Order", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_order",
							"width"             		=> 200,
							"value"             		=> array(
								__( 'Oldest (Top) to Newest (Bottom)', "ts_visual_composer_extend" )		=> "asc",
								__( 'Newest (Top) to Oldest (Bottom)', "ts_visual_composer_extend" )		=> "desc",
							),
							"admin_label"           	=> true,
							"description"       		=> __( "Select in which order the timeline events are arranged in Visual Composer.", "ts_visual_composer_extend" )
						),
						array(
							"type"              		=> "switch_button",
							"heading"			    	=> __( "Lazy-Load Effect", "ts_visual_composer_extend" ),
							"param_name"		    	=> "timeline_lazy",
							"value"             		=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"admin_label"           	=> true,
							"description"		    	=> __( "Switch the toggle if you want to show a limited number of events at a time, showing more the further you scroll.", "ts_visual_composer_extend" ),
							"dependency"            	=> ""
						),
                        array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Number of Events", "ts_visual_composer_extend" ),
                            "param_name"                => "timeline_count",
                            "value"                     => "10",
                            "min"                       => "1",
                            "max"                       => "200",
                            "step"                      => "1",
                            "unit"                      => '',
                            "description"               => __( "Define how many events should be shown per Lazy-Load Event.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_lazy", 'value' => 'true' )
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Lazy-Load Trigger", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_trigger",
							"width"             		=> 200,
							"value"             		=> array(
								__( 'Scroll', "ts_visual_composer_extend" )      		=> "scroll",
								__( 'Click', "ts_visual_composer_extend" )         	=> "click",
							),
							"description"       		=> __( "Select how the Lazy-Load Effect should be triggered for the timeline.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_lazy", 'value' => 'true' )
						),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text for 'Load More' Button", "ts_visual_composer_extend" ),
                            "param_name"                => "timeline_load",
                            "value"                     => "Load More",
                            "description"               => __( "Enter a text to be shown inside the 'Load More' trigger button.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_lazy", 'value' => 'true' )
                        ),
						// Sort Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_2",
							"value"						=> "",
                            "seperator"					=> "Sort Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Sort Settings",
                        ),
						array(
							"type"              		=> "switch_button",
							"heading"			    	=> __( "Sort Buttons", "ts_visual_composer_extend" ),
							"param_name"		    	=> "timeline_sort",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"admin_label"           	=> true,
							"description"		    	=> __( "Switch the toggle if you want to provide sort controls (up/down) for the timeline. Buttons will be hidden until all sections are visible, if lazyload effect has been used.", "ts_visual_composer_extend" ),
							"group" 			        => "Sort Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "Label: Section Sorter", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_sort_label",
							"value"             		=> "Sort Timeline:",
							"description"       		=> __( "Enter the label text for the section sorter.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_sort", 'value' => 'true' ),
							"group" 			        => "Sort Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "String: Ascending", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_sort_asc",
							"value"             		=> "Ascending",
							"description"       		=> __( "Enter the text string to be used inside the sorter to provide the option for an ascending direction.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_sort", 'value' => 'true' ),
							"group" 			        => "Sort Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "String: Descending", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_sort_desc",
							"value"             		=> "Descending",
							"description"       		=> __( "Enter the text string to be used inside the sorter to provide the option for a descending direction.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_sort", 'value' => 'true' ),
							"group" 			        => "Sort Settings",
						),
						// Filter Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_3",
							"value"						=> "",
                            "seperator"					=> "Filter Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Filter Settings",
                        ),
						array(
							"type"              		=> "switch_button",
							"heading"			    	=> __( "Filter Controls", "ts_visual_composer_extend" ),
							"param_name"		    	=> "timeline_filter_allow",
							"value"             		=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"admin_label"           	=> true,
							"description"		    	=> __( "Switch the toggle if you want to provide filter options for the timeline, based on section categories and/or tags.", "ts_visual_composer_extend" ),
							"group" 			        => "Filter Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "String: Selected", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_filter_selected",
							"value"             		=> "Selected",
							"description"       		=> __( "Enter the text string to be used inside the filters to highlight how many items are currently selected.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_filter_allow", 'value' => 'true' ),
							"group" 			        => "Filter Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "String: Select All", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_filter_selectall",
							"value"             		=> "Selected",
							"description"       		=> __( "Enter the text string to be used inside the filters to provide an option to select all options at once.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_filter_allow", 'value' => 'true' ),
							"group" 			        => "Filter Settings",
						),
						array(
							"type"              		=> "switch_button",
							"heading"			    	=> __( "Categories Filter", "ts_visual_composer_extend" ),
							"param_name"		    	=> "timeline_filter_cats",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to provide a filter option for section categories.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_filter_allow", 'value' => 'true' ),
							"group" 			        => "Filter Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "Label: Categories Filter", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_filter_labelcats",
							"value"             		=> "Filter By Categories:",
							"description"       		=> __( "Enter the label text for the categories filter.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_filter_cats", 'value' => 'true' ),
							"group" 			        => "Filter Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "String: No Categories", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_filter_nocats",
							"value"             		=> "No Categories",
							"description"       		=> __( "Enter the text string to be used for sections without categories.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_filter_cats", 'value' => 'true' ),
							"group" 			        => "Filter Settings",
						),
						array(
							"type"              		=> "switch_button",
							"heading"			    	=> __( "Tags Filter", "ts_visual_composer_extend" ),
							"param_name"		    	=> "timeline_filter_tags",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to provide a filter option for section tags.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_filter_allow", 'value' => 'true' ),
							"group" 			        => "Filter Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "Label: Tags Filter", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_filter_labeltags",
							"value"             		=> "Filter By Tags:",
							"description"       		=> __( "Enter the label text for the tags filter.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_filter_tags", 'value' => 'true' ),
							"group" 			        => "Filter Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "String: No Tags", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_filter_notags",
							"value"             		=> "No Tags",
							"description"       		=> __( "Enter the text string to be used for sections without tags.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_filter_tags", 'value' => 'true' ),
							"group" 			        => "Filter Settings",
						),
                        // Additional Info Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_4",
							"value"						=> "",
                            "seperator"					=> "Additional Information",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Additional Info",
                        ),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "Timeline Title", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_title",
							"value"             		=> "",
							"description"       		=> __( "Enter a title for the Isotope Timeline.", "ts_visual_composer_extend" ),
							"group" 			        => "Additional Info",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Title Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_title_color",
							"value"             		=> "#7c7979",
							"description"       		=> __( "Define the font color for the title in the timeline break item.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 			        => "Additional Info",
						),
						array(
							"type"              		=> "switch_button",
							"heading"			    	=> __( "Show Title with Description", "ts_visual_composer_extend" ),
							"param_name"		    	=> "timeline_title_show",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to show the title with the description again, or only at the top of the timeline.", "ts_visual_composer_extend" ),
							"group" 			        => "Additional Info",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "Start Term", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_start",
							"value"             		=> "",
							"description"       		=> __( "Enter an optional start term for the Isotope Timeline.", "ts_visual_composer_extend" ),
							"group" 			        => "Additional Info",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "End Term", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_end",
							"value"             		=> "",
							"description"       		=> __( "Enter an optional end term for the Isotope Timeline.", "ts_visual_composer_extend" ),
							"group" 			        => "Additional Info",
						),
						array(
							"type"              		=> "textarea_raw_html",
							"heading"           		=> __( "Description", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_description",
							"value"             		=> base64_encode(""),
							"description"       		=> __( "Enter a description for the the overall timeline, shown at the beginning; HTML code can be used.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 			        => "Additional Info",
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Alignment", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_description_align",
							"width"             		=> 200,
							"value"             		=> array(
								__( 'Center', "ts_visual_composer_extend" )      	=> "center",
								__( 'Left', "ts_visual_composer_extend" )         => "left",
								__( 'Right', "ts_visual_composer_extend" )       	=> "right",
								__( 'Justify', "ts_visual_composer_extend" )		=> "justify",
							),
							"description"       		=> __( "Select how the description text should be aligned.", "ts_visual_composer_extend" ),
							"group" 			        => "Additional Info",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Content Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_description_color",
							"value"             		=> "#7c7979",
							"description"       		=> __( "Define the font color for the description text.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 			        => "Additional Info",
						),
						array(
							"type"              		=> "switch_button",
							"heading"			    	=> __( "Show Categories for Sections", "ts_visual_composer_extend" ),
							"param_name"		    	=> "timeline_show_cats",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to show the categories assigned to each section below the section content.", "ts_visual_composer_extend" ),
							"group" 			        => "Additional Info",
						),
						array(
							"type"              		=> "switch_button",
							"heading"			    	=> __( "Show Tags for Sections", "ts_visual_composer_extend" ),
							"param_name"		    	=> "timeline_show_tags",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to show the tags assigned to each section below the section content.", "ts_visual_composer_extend" ),
							"group" 			        => "Additional Info",
						),
                        // Other Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_3",
							"value"						=> "",
                            "seperator"					=> "Other Settings",
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
                            "param_name"                => "el_file",
                            "value"                     => "",
                            "file_type"                 => "js",
                            "file_path"                 => "js/ts-visual-composer-extend-element.min.js",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
                    ),
                    "js_view"                           => 'VcColumnView'
                ));
            }
		}
	}
}
// Register Container and Child Shortcode with Visual Composer
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_TS_VCSC_Timeline_CSS_Container extends WPBakeryShortCodesContainer {};
}
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_TS_VCSC_Timeline_CSS_Section extends WPBakeryShortCode {};
}
// Initialize "TS CSS Timeline" Class
if (class_exists('TS_Timeline_CSS')) {
	$TS_Timeline_CSS = new TS_Timeline_CSS;
}