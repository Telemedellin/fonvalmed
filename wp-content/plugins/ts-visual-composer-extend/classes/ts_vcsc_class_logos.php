<?php
if (!class_exists('TS_Logos')){
	class TS_Logos {
		function __construct() {
			global $VISUAL_COMPOSER_EXTENSIONS;
            if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
                add_action('init',                              		array($this, 'TS_VCSC_Add_Logo_Elements'), 9999999);
            } else {
                add_action('admin_init',		                		array($this, 'TS_VCSC_Add_Logo_Elements'), 9999999);
            }
            add_shortcode('TS_VCSC_Logo_Layouts_Category', 				array($this, 'TS_VCSC_Logo_Layouts_Category'));
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements++;
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements++;
		}
		
		// Logo Layouts Element
		function TS_VCSC_Logo_Layouts_Category ($atts, $content = null) {
            global $VISUAL_COMPOSER_EXTENSIONS;
            ob_start();
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {				
				wp_enqueue_style('ts-visual-composer-extend-front');
				wp_enqueue_script('ts-visual-composer-extend-front');
			} else {
				wp_enqueue_style('ts-visual-composer-extend-front');
			}

			extract( shortcode_atts( array(
                'logocat'                		=> '',
				'layout'						=> 'honeycombs',
				'target'						=> '_blank',
				// Full Width Settings
				'fullwidth'						=> 'false',
				'breakouts'						=> 6,
				// Honeycombs Settings
				'honeycombs_layout'				=> 'flat',
				'honeycombs_breaks'				=> '1280,960,640',
				'honeycombs_sizes'				=> '340,250,180,100',
				'honeycombs_tooltips'			=> 'true',
				// Tooltip Settings
				'tooltipster_theme'				=> 'tooltipster-black',
				'tooltipster_animation'			=> 'swing',
				'tooltipster_position'			=> 'top',
				'tooltipster_offsetx'			=> 0,
				'tooltipster_offsety'			=> 0,
				// Grid Settings
				'data_grid_breaks'				=> '240,480,720,960',
				'data_grid_width'				=> 250,
				'data_grid_invalid'				=> 'exclude',
				'data_grid_space'				=> 2,
				'data_grid_order'				=> 'false',
				'data_grid_always'				=> 'false',
				// OwlSlider Settings
				'number_images'					=> 4,
				'slide_margin'					=> 10,
				'break_custom'					=> 'false',
				'break_string'					=> '1,2,3,4,5,6,7,8',
				'auto_height'					=> 'true',
				'page_rtl'						=> 'false',
				'auto_play'						=> 'false',
				'show_playpause'				=> 'true',
				'slide_show'					=> 'false',
				'show_bar'						=> 'true',
				'bar_color'						=> '#dd3333',
				'show_speed'					=> 5000,
				'stop_hover'					=> 'true',
				'show_navigation'				=> 'true',
				'dot_navigation'				=> 'true',
				'page_numbers'					=> 'false',
				'items_loop'					=> 'false',				
				'animation_in'					=> 'ts-viewport-css-flipInX',
				'animation_out'					=> 'ts-viewport-css-slideOutDown',
				'animation_mobile'				=> 'false',
				// Filter Settings
				'filters_show'					=> 'false',
				'filters_available'				=> 'Available Groups',
				'filters_selected'				=> 'Filtered Groups',
				'filters_nogroups'				=> 'No Groups',
				'filters_toggle'				=> 'Toggle Filter',
				'filters_toggle_style'			=> '',
				'filters_showall'				=> 'Show All',
				'filters_showall_style'			=> '',
				// Other Settings
                'margin_top'                    => 0,
                'margin_bottom'                 => 0,
                'el_id'                         => '',
                'el_class'                      => '',
				'css'							=> '',
            ), $atts ));
			
            $output								= '';
			$modal_gallery						= '';
			
            $logos_random                 		= mt_rand(999999, 9999999);
			
			if ($logocat == '') {
				
				exit;
			}
            
            if (!empty($el_id)) {
                $logos_layout_id				= $el_id;
            } else {
                $logos_layout_id				= 'ts-vcsc-logos-layout-' . $layout . '-' . $logos_random;
            }
            
            if (!is_array($logocat)) {
                $logocat 						= array_map('trim', explode(',', $logocat));
            }
			
			// Check for Front End Editor
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend_message				= '<div class="ts-composer-frontedit-message">' . __( 'The logos are currently viewed in front-end editor mode; all logo (layout) features are disabled for performance and compatibility reasons.', "ts_visual_composer_extend" ) . '</div>';
				$frontend_edit					= 'true';
			} else {
				$frontend_message				= '';
				$frontend_edit					= 'false';
			}

            // Retrieve Logo Post Main Content
            $logo_array							= array();
            $category_fields 	                = array();
            $args = array(
                'no_found_rows' 				=> 1,
                'ignore_sticky_posts' 			=> 1,
                'posts_per_page' 				=> -1,
                'post_type' 					=> 'ts_logos',
                'post_status' 					=> 'publish',
                'orderby' 						=> 'title',
                'order' 						=> 'ASC',
            );
            $logo_query = new WP_Query($args);
            if ($logo_query->have_posts()) {
                foreach($logo_query->posts as $p) {
                    $categories 				= TS_VCSC_GetTheCategoryByTax($p->ID, 'ts_logos_category');
                    if ($categories && !is_wp_error($categories)) {
                        $category_slugs_arr     = array();
                        $arrayMatch             = 0;
                        foreach ($categories as $category) {
                            if (in_array($category->slug, $logocat)) {
                                $arrayMatch++;
                            }
                            $category_slugs_arr[] = $category->slug;
                            $category_data = array(
                                'slug'			=> $category->slug,
                                'name'			=> $category->cat_name,
                                'number'    	=> $category->term_id,
                            );
                            $category_fields[] 	= $category_data;
                        }
                        $categories_slug_str 	= join(",", $category_slugs_arr);
                    } else {
                        $category_slugs_arr     = array();
                        $arrayMatch             = 0;
                        if (in_array("ts-logo-none-applied", $logocat)) {
                            $arrayMatch++;
                        }
                        $category_slugs_arr[]   = '';
                        $categories_slug_str    = join(",", $category_slugs_arr);
                    }
                    if ($arrayMatch > 0) {
                        $logo_data = array(
                            'name'				=> $p->post_name,
                            'title'				=> $p->post_title,
                            'id'				=> $p->ID,
                            'content'			=> $p->post_content,
                            'categories'        => $categories_slug_str,
                        );
                        $logo_array[] 	= $logo_data;
                    }
                }
            }
            wp_reset_postdata();
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-image-gallery-wrapper ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Logo_Layouts_Category', $atts);
			} else {
				$css_class 	= 'ts-image-gallery-wrapper ' . $el_class;
			}	
			
			$output .= '<div id="' . $logos_layout_id . '" class="ts-vcsc-logos-layout-wrapper ' . $css_class . '" data-layout="' . $layout . '" style="position: relative; width: 100%; display: block;">';
				// Honeycomb-Grid Layout
				if ($layout == 'honeycombs') {
					wp_enqueue_style('ts-extend-tooltipster');
					wp_enqueue_script('ts-extend-tooltipster');
					if ($filters_show == 'true') {
						if ($filters_toggle_style != '') {
							wp_enqueue_style('ts-extend-buttonsflat');
						}
						wp_enqueue_style('ts-extend-multiselect');
						wp_enqueue_script('ts-extend-multiselect');
					}	
					wp_enqueue_style('ts-extend-honeycombs');
					wp_enqueue_script('ts-extend-honeycombs');
					$fullwidth_allow			= "true";
					if ($honeycombs_tooltips == "true") {
						$data_tooltips			= 'data-tooltipster-position="' . $tooltipster_position . '" data-tooltipster-touch="false" data-tooltipster-theme="' . $tooltipster_theme . '" data-tooltipster-animation="' . $tooltipster_animation . '" data-tooltipster-arrow="true" data-tooltipster-trigger="hover" data-tooltipster-offsetx="' . $tooltipster_offsetx . '" data-tooltipster-offsety="' . $tooltipster_offsety . '"';
					} else {
						$data_tooltips			= '';
					}
					$filter_settings			= 'data-gridfilter="' . $filters_show . '" data-gridavailable="' . $filters_available . '" data-gridselected="' . $filters_selected . '" data-gridnogroups="' . $filters_nogroups . '" data-gridtoggle="' . $filters_toggle . '" data-gridtogglestyle="' . $filters_toggle_style . '" data-gridshowall="' . $filters_showall . '" data-gridshowallstyle="' . $filters_showall_style . '"';
					$output .= '<div id="ts-honeycombs-gallery-wrapper-' . $logos_random . '" class="ts-honeycombs-gallery-wrapper" data-inline="' . $frontend_edit . '" data-currentsize="full" data-layout="' . $honeycombs_layout . '" data-tooltips="' . $honeycombs_tooltips . '" ' . $data_tooltips . ' data-fullwidth="' . $fullwidth . '" data-break-parents="' . $breakouts . '" data-breakpoints="' . $honeycombs_breaks . '" data-combsizes="' . $honeycombs_sizes . '" data-margin="' . $data_grid_space . '" data-random="' . $logos_random . '" ' . $filter_settings . '>';
						$output .= '<img id="ts-honeycombs-gallery-loader-' . $logos_random . '" class="ts-honeycombs-gallery-loader" src="' . TS_VCSC_GetResourceURL('images/other/ajax_loader.gif') . '" style="margin: 0 auto;">';
						$output .= '<div class="ts-honeycombs-gallery-inner">';
							// Build Logo Post Main Content
							foreach ($logo_array as $index => $array) {
								$Logo_Name 					= $logo_array[$index]['name'];
								$Logo_Title 				= $logo_array[$index]['title'];
								$Logo_ID 					= $logo_array[$index]['id'];
								$Logo_Content 				= $logo_array[$index]['content'];
								$Logo_Category 				= $logo_array[$index]['categories'];
								if (($filters_show == 'true') && (isset($Logo_Category))) {
									$categories 			= explode(',', $Logo_Category);
									$Logo_Category			= array();
									foreach ($categories as $category) {
										$term 				= get_term_by('slug', $category, 'ts_logos_category');
										$Logo_Category[] 	= $term->name;
									}
									$Logo_Category			= implode(',', $Logo_Category);
								} else {
									$Logo_Category			= '';
								}
								$Logo_Image					= wp_get_attachment_image_src(get_post_thumbnail_id($Logo_ID), 'full');
								if ($Logo_Image == false) {
									$Logo_Image          	= TS_VCSC_GetResourceURL('images/defaults/default_person.jpg');
								} else {
									$Logo_Image          	= $Logo_Image[0];
								}							
								// Retrieve Logo Post Meta Content
								$custom_fields				= get_post_custom($Logo_ID);
								$custom_fields_array		= array();
								foreach ($custom_fields as $field_key => $field_values) {
									if (!isset($field_values[0])) continue;
									if (in_array($field_key, array("_edit_lock", "_edit_last"))) continue;
									if (strpos($field_key, 'ts_vcsc_logo_') !== false) {
										$field_key_split	= explode("_", $field_key);
										$field_key_length	= count($field_key_split) - 1;
										$custom_data = array(
											'group'			=> $field_key_split[$field_key_length - 1],
											'name'			=> 'Logo_' . ucfirst($field_key_split[$field_key_length]),
											'value'			=> $field_values[0],
										);
										$custom_fields_array[] = $custom_data;
									}
								}
								foreach ($custom_fields_array as $index => $array) {
									${$custom_fields_array[$index]['name']} = $custom_fields_array[$index]['value'];
								}
								// Create Tooltip Content
								if ((!empty($Logo_Name)) && ($honeycombs_tooltips == "true")) {
									$thumb_tooltipclasses	= 'ts-honeycombs-gallery-tooltip';
									$thumb_tooltipcontent 	= 'data-tooltipster-title="" data-tooltipster-text="' . $Logo_Name . '" data-tooltipster-image=""';
								} else {
									$thumb_tooltipclasses	= "";
									$thumb_tooltipcontent	= "";
								}
								// Create Single Logo Output
								if (isset($Logo_Link)) {
									$Logo_DOM_TAG			= 'a';
									$Logo_DOM_HREF			= 'href="' . $Logo_Link . '" target="' . $target . '"';
									$Logo_DOM_Class			= 'ts-honeycombs-gallery-link';
								} else {
									$Logo_DOM_TAG			= 'div';
									$Logo_DOM_HREF			= '';
									$Logo_DOM_Class			= 'ts-honeycombs-gallery-none';
								}
								$output .= '<' . $Logo_DOM_TAG . ' id="" ' . $Logo_DOM_HREF . ' data-thumbnail="' . $Logo_Image . '" data-showing="true" data-groups="All,' . (isset($Logo_Category) ? (str_replace('/', ',', $Logo_Category)) : "") . '" data-title="' . (!empty($Logo_Name) ? $Logo_Name : "") . '" class="ts-honeycombs-gallery-comb ts-honeycombs-gallery-active ' . $thumb_tooltipclasses . '" ' . $thumb_tooltipcontent . '>';								
									$output .= '<div class="ts-honeycombs-gallery-hex-left">';
										$output .= '<div class="ts-honeycombs-gallery-hex-right">';
											$output .= '<div class="ts-honeycombs-gallery-hex-inner" style="background-image: url(' . $Logo_Image . ');">';
												$output .= '<div class="ts-honeycombs-gallery-overlay ' . $Logo_DOM_Class . '"></div>';
											$output .= '</div>';
										$output .= '</div>';
									$output .= '</div>';											
								$output .= '</' . $Logo_DOM_TAG . '>';
								// Reset Array
								foreach ($custom_fields_array as $index => $array) {
									unset(${$custom_fields_array[$index]['name']});
								}
							}
						$output .= '</div>';
					$output .= '</div>';
				}				
				// Auto-Grid or Freewall-Grid Layout
				if (($layout == 'grid') || ($layout == 'freewall')) {
					wp_enqueue_script('ts-extend-hammer');
					wp_enqueue_script('ts-extend-nacho');
					wp_enqueue_style('ts-extend-nacho');				
					if ($filters_show == 'true') {
						if ($filters_toggle_style != '') {
							wp_enqueue_style('ts-extend-buttonsflat');
						}
						wp_enqueue_style('ts-extend-multiselect');
						wp_enqueue_script('ts-extend-multiselect');
					}					
					$fullwidth_allow			= "true";
					$valid_images 				= 0;
					$b							= 0;
					if ($layout == 'grid') {
						$class_name				= 'ts-image-link-grid-frame';
						$grid_class				= 'ts-image-link-grid';
					} else if ($layout == 'freewall') {
						wp_enqueue_script('ts-extend-freewall');
						$class_name				= 'ts-image-freewall-grid-frame';
						$grid_class				= 'ts-freewall-link-grid';
					}
					if (!empty($data_grid_breaks)) {
						$data_grid_breaks 		= str_replace(' ', '', $data_grid_breaks);
						$count_columns			= substr_count($data_grid_breaks, ",") + 1;
					} else {
						$count_columns			= 0;
					}
					if ($layout == 'freewall') {
						$filter_settings		= 'data-gridfilter="' . $filters_show . '" data-gridavailable="' . $filters_available . '" data-gridselected="' . $filters_selected . '" data-gridnogroups="' . $filters_nogroups . '" data-gridtoggle="' . $filters_toggle . '" data-gridtogglestyle="' . $filters_toggle_style . '" data-gridshowall="' . $filters_showall . '" data-gridshowallstyle="' . $filters_showall_style . '"';
						$modal_gallery .= '<div id="ts-lightbox-freewall-grid-' . $logos_random . '-container" class="ts-lightbox-freewall-grid-container" data-random="' . $logos_random . '" data-width="' . $data_grid_width . '" data-gutter="' . $data_grid_space . '" ' . $filter_settings . ' style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';		
					}					
						// Build Logo Post Main Content
						$i 						= -1;
						foreach ($logo_array as $index => $array) {
							$i++;							
							$Logo_Name 					= $logo_array[$index]['name'];
							$Logo_Title 				= $logo_array[$index]['title'];
							$Logo_ID 					= $logo_array[$index]['id'];
							$Logo_Content 				= $logo_array[$index]['content'];
							$Logo_Category 				= $logo_array[$index]['categories'];
							if (($filters_show == 'true') && (isset($Logo_Category))) {
								$categories 			= explode(',', $Logo_Category);
								$Logo_Category			= array();
								foreach ($categories as $category) {
									$term 				= get_term_by('slug', $category, 'ts_logos_category');
									$Logo_Category[] 	= $term->name;
								}
								$Logo_Category			= implode(',', $Logo_Category);
							} else {
								$Logo_Category			= '';
							}
							$Logo_Image					= wp_get_attachment_image_src(get_post_thumbnail_id($Logo_ID), 'full');
							if ($Logo_Image == false) {
								$Logo_Image          	= TS_VCSC_GetResourceURL('images/defaults/default_person.jpg');
							} else {
								$Logo_Image          	= $Logo_Image[0];
							}							
							// Retrieve Logo Post Meta Content
							$custom_fields				= get_post_custom($Logo_ID);
							$custom_fields_array		= array();
							foreach ($custom_fields as $field_key => $field_values) {
								if (!isset($field_values[0])) continue;
								if (in_array($field_key, array("_edit_lock", "_edit_last"))) continue;
								if (strpos($field_key, 'ts_vcsc_logo_') !== false) {
									$field_key_split	= explode("_", $field_key);
									$field_key_length	= count($field_key_split) - 1;
									$custom_data = array(
										'group'			=> $field_key_split[$field_key_length - 1],
										'name'			=> 'Logo_' . ucfirst($field_key_split[$field_key_length]),
										'value'			=> $field_values[0],
									);
									$custom_fields_array[] = $custom_data;
								}
							}
							foreach ($custom_fields_array as $index => $array) {
								${$custom_fields_array[$index]['name']} = $custom_fields_array[$index]['value'];
							}
							// Create Single Logo Output
							if ((isset($Logo_Link)) || ($data_grid_invalid != "exclude")) {
								$valid_images++;
								if ($layout == 'grid') {
									$modal_gallery .= '<img id="ts-image-link-picture-' . $logos_random . '-' . $i .'" class="ts-image-link-picture" src="' . $Logo_Image . '" rel="link-group-' . $logos_random . '" data-include="true" data-image="' . (($data_grid_invalid == "lightbox") ? $Logo_Image : '') . '" width="" height="" title="' . (isset($Logo_Name) ? $Logo_Name : "") . '" data-groups="' . (isset($Logo_Category) ? (str_replace('/', ',', $Logo_Category)) : "") . '" data-target="' . $target . '" data-link="' . (isset($Logo_Link) ? $Logo_Link : "") . '">';
								} else if ($layout == 'freewall') {
									if (isset($Logo_Link)) {
										$image_link			= $Logo_Link;
										$image_class		= '';
										$image_icon			= '';
									} else {
										if ($data_grid_invalid == 'lightbox') {
											$image_link		= $Logo_Image;
											$image_class	= 'nch-lightbox-media nofancybox no-ajaxy';
											$image_icon		= 'nchgrid-lightbox';
										} else {
											$image_link		= '';
											$image_class	= '';
											$image_icon		= '';
										}								
									}
									$image_groups			= (isset($Logo_Category) ? (str_replace('/', ',', $Logo_Category)) : "");
									$image_title			= (isset($Logo_Name) ? $Logo_Name : "");
									$modal_gallery .= '<div id="ts-lightbox-freewall-item-' . $logos_random . '-' . $i .'-parent" class="ts-lightbox-freewall-item ts-lightbox-freewall-active nchgrid-item nchgrid-tile ' . $image_icon . '" data-fixSize="false" data-target="' . $target . '" data-link="' . $image_link . '" data-showing="true" data-groups="' . $image_groups . '" style="width: ' . $data_grid_width . 'px; margin: 0; padding: 0;">';
										if ($image_link != '') {
											$modal_gallery .= '<a id="ts-lightbox-freewall-item-' . $logos_random . '-' . $i .'" class="' . $image_class . '" href="' . $image_link . '" target="' . $target . '" title="' . $image_title . '">';
										}
											$modal_gallery .= '<img id="ts-lightbox-freewall-picture-' . $logos_random . '-' . $i .'" class="ts-lightbox-freewall-picture" src="' . $Logo_Image . '" width="100%" height="auto" title="' . $image_title . '">';
											$modal_gallery .= '<div class="nchgrid-caption"></div>';
											if ($image_title != '') {
												$modal_gallery .= '<div class="nchgrid-caption-text ' . ($data_grid_always == 'true' ? 'nchgrid-caption-text-always' : '') . '">' . $image_title . '</div>';
											}
										if ($image_link != '') {
											$modal_gallery .= '</a>';
										}
									$modal_gallery .= '</div>';
								}
							}
							// Reset Array
							foreach ($custom_fields_array as $index => $array) {
								unset(${$custom_fields_array[$index]['name']});
							}
						}					
					if ($layout == 'freewall') {
						$modal_gallery .= '</div>';
					}
					if ($valid_images < $count_columns) {
						$data_grid_string		= explode(',', $data_grid_breaks);
						$data_grid_breaks		= array();
						foreach ($data_grid_string as $single_break) {
							$b++;
							if ($b <= $valid_images) {
								array_push($data_grid_breaks, $single_break);
							} else {
								break;
							}
						}
						$data_grid_breaks		= implode(",", $data_grid_breaks);
					} else {
						$data_grid_breaks 		= $data_grid_breaks;
					}
					$output .= '<div id="" class="' . $class_name . ' ' . $grid_class . ' ' . (($fullwidth == "true" && $fullwidth_allow == "true") ? "ts-lightbox-nacho-full-frame" : "") . '" data-random="' . $logos_random . '" data-grid="' . $data_grid_breaks . '" data-margin="' . $data_grid_space . '" data-always="' . $data_grid_always . '" data-order="' . $data_grid_order . '" data-break-parents="' . $breakouts . '" data-inline="' . $frontend_edit . '" data-gridfilter="' . $filters_show . '" data-gridavailable="' . $filters_available . '" data-gridselected="' . $filters_selected . '" data-gridnogroups="' . $filters_nogroups . '" data-gridtoggle="' . $filters_toggle . '" data-gridtogglestyle="' . $filters_toggle_style . '" data-gridshowall="' . $filters_showall . '" data-gridshowallstyle="' . $filters_showall_style . '" style="margin-top: '  . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px; position: relative;">';
						if ($layout == 'grid') {
							$output .= '<div id="nch-lb-grid-' . $logos_random . '" class="nch-lb-grid" data-filter="nch-lb-filter-' . $logos_random . '" style="" data-toggle="nch-lb-toggle-' . $logos_random . '" data-random="' . $logos_random . '">';
						}
							$output .= $modal_gallery;
						if ($layout == 'grid') {
							$output .= '</div>';
						}
					$output .= '</div>';
				}
				// OwlSlider Layout
				if ($layout == 'owlslider') {
					wp_enqueue_style('ts-font-ecommerce');
					wp_enqueue_style('ts-extend-animations');
					wp_enqueue_style('ts-extend-nacho');
					wp_enqueue_style('ts-extend-owlcarousel2');
					wp_enqueue_script('ts-extend-owlcarousel2');
					$fullwidth_allow			= "true";
					$output .= '<div id="ts-lightbox-gallery-slider-' . $logos_random . '-container" class="ts-lightbox-gallery-container" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';		
						// Add Progressbar
						if (($auto_play == "true") && ($show_bar == "true")) {
							$output .= '<div id="ts-owlslider-progressbar-' . $logos_random . '" class="ts-owlslider-progressbar-holder" style=""><div class="ts-owlslider-progressbar" style="background: ' . $bar_color . '; height: 100%; width: 0%;"></div></div>';
						}
						// Add Navigation Controls
						$output .= '<div id="ts-owlslider-controls-' . $logos_random . '" class="ts-owlslider-controls" style="' . (((($auto_play == "true") && ($show_playpause == "true")) || ($show_navigation == "true")) ? "display: block;" : "display: none;") . '">';
							$output .= '<div id="ts-owlslider-controls-next-' . $logos_random . '" style="' . (($show_navigation == "true") ? "display: block;" : "display: none;") . '" class="ts-owlslider-controls-next" title="Next"><span class="ts-ecommerce-arrowright5"></span></div>';
							$output .= '<div id="ts-owlslider-controls-prev-' . $logos_random . '" style="' . (($show_navigation == "true") ? "display: block;" : "display: none;") . '" class="ts-owlslider-controls-prev" title="Previous"><span class="ts-ecommerce-arrowleft5"></span></div>';							
							if (($auto_play == "true") && ($show_playpause == "true")) {
								$output .= '<div id="ts-owlslider-controls-play-' . $logos_random . '" class="ts-owlslider-controls-play active" title="Play / Pause"><span class="ts-ecommerce-pause"></span></div>';
							}
							$output .= '<div id="ts-owlslider-controls-refresh-' . $logos_random . '" style="display: none;" class="ts-owlslider-controls-refresh" title="Refresh"><span class="ts-ecommerce-cycle"></span></div>';
						$output .= '</div>';
						// Add Slider
						$output .= '<div id="ts-lightbox-gallery-slider-' . $logos_random . '" class="ts-owlslider-parent owl-carousel2 ts-logo-gallery-slider" data-id="' . $logos_random . '" data-items="' . $number_images . '" data-breakpointscustom="' . $break_custom . '" data-breakpointitems="' . $break_string . '" data-rtl="' . $page_rtl . '" data-loop="' . $items_loop . '" data-navigation="' . $show_navigation . '" data-dots="' . $dot_navigation . '" data-mobile="' . $animation_mobile . '" data-animationin="' . $animation_in . '" data-animationout="' . $animation_out . '" data-height="' . $auto_height . '" data-play="' . $auto_play . '" data-bar="' . $show_bar . '" data-color="' . $bar_color . '" data-speed="' . $show_speed . '" data-hover="' . $stop_hover . '" data-margin="' . $slide_margin . '">';
							// Build Logo Post Main Content
							foreach ($logo_array as $index => $array) {
								$Logo_Name 					= $logo_array[$index]['name'];
								$Logo_Title 				= $logo_array[$index]['title'];
								$Logo_ID 					= $logo_array[$index]['id'];
								$Logo_Content 				= $logo_array[$index]['content'];
								$Logo_Category 				= $logo_array[$index]['categories'];
								$Logo_Image					= wp_get_attachment_image_src(get_post_thumbnail_id($Logo_ID), 'full');
								if ($Logo_Image == false) {
									$Logo_Image          	= TS_VCSC_GetResourceURL('images/defaults/default_person.jpg');
								} else {
									$Logo_Image          	= $Logo_Image[0];
								}							
								// Retrieve Logo Post Meta Content
								$custom_fields				= get_post_custom($Logo_ID);
								$custom_fields_array		= array();
								foreach ($custom_fields as $field_key => $field_values) {
									if (!isset($field_values[0])) continue;
									if (in_array($field_key, array("_edit_lock", "_edit_last"))) continue;
									if (strpos($field_key, 'ts_vcsc_logo_') !== false) {
										$field_key_split	= explode("_", $field_key);
										$field_key_length	= count($field_key_split) - 1;
										$custom_data = array(
											'group'			=> $field_key_split[$field_key_length - 1],
											'name'			=> 'Logo_' . ucfirst($field_key_split[$field_key_length]),
											'value'			=> $field_values[0],
										);
										$custom_fields_array[] = $custom_data;
									}
								}
								foreach ($custom_fields_array as $index => $array) {
									${$custom_fields_array[$index]['name']} = $custom_fields_array[$index]['value'];
								}
								// Create Single Logo Output
								if (isset($Logo_Link)) {
									$Logo_DOM_TAG			= 'a';
									$Logo_DOM_HREF			= 'href="' . $Logo_Link . '" target="' . $target . '"';
									$Logo_DOM_Class			= 'nch-logo-link';
								} else {
									$Logo_DOM_TAG			= 'div';
									$Logo_DOM_HREF			= '';
									$Logo_DOM_Class			= 'nch-logo-image';
								}
								$output .= '<div id="" class="nchgrid-item nchgrid-tile ' . $Logo_DOM_Class . '" style="">';
									$output .= '<' . $Logo_DOM_TAG . ' id="" ' . $Logo_DOM_HREF . ' class="">';								
										$output .= '<img src="' . $Logo_Image . '" style="">';
										$output .= '<div class="nchgrid-caption"></div>';
										if (!empty($Logo_Name)) {
											$output .= '<div class="nchgrid-caption-text">' . (!empty($Logo_Name) ? $Logo_Name : "") . '</div>';
										}									
									$output .= '</' . $Logo_DOM_TAG . '>';
								$output .= '</div>';	
								// Reset Array
								foreach ($custom_fields_array as $index => $array) {
									unset(${$custom_fields_array[$index]['name']});
								}
							}
						$output .= '</div>';
					$output .= '</div>';
				}
			$output .= '</div>';
			
			echo $output;
            
            $myvariable = ob_get_clean();
            return $myvariable;
		}

		// Add Logo Elements
        function TS_VCSC_Add_Logo_Elements() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			// Add Logo Layouts Element
			if (function_exists('vc_map')) {
                vc_map( array(
                    "name"                              => __( "TS Logo Layouts", "ts_visual_composer_extend" ),
                    "base"                              => "TS_VCSC_Logo_Layouts_Category",
                    "icon" 	                            => "icon-wpb-ts_vcsc_logo_layouts",
                    "class"                             => "",
                    "category"                          => __( 'VC Extensions', "ts_visual_composer_extend" ),
                    "description"                       => __("Place a Logo layout element", "ts_visual_composer_extend"),
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
                    "params"                            => array(
                        // Logo Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_1",
							"value"						=> "",
                            "seperator"					=> "Main Content",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
                        array(
                            "type"                      => "custompostcat",
                            "heading"                   => __( "Logo Categories", "ts_visual_composer_extend" ),
                            "param_name"                => "logocat",
                            "posttype"                  => "ts_logos",
                            "posttaxonomy"              => "ts_logos_category",
							"taxonomy"              	=> "ts_logos_category",
							"postsingle"				=> "Logo",
							"postplural"				=> "Logos",
							"postclass"					=> "logo",
                            "value"                     => "",
							"admin_label"               => true,
                            "description"               => __( "Please select the logo categories you want to use for the element.", "ts_visual_composer_extend" )
                        ),
                        array(
                            "type"                      => "dropdown",
                            "heading"                   => __( "Layout", "ts_visual_composer_extend" ),
                            "param_name"                => "layout",
                            "value"                     => array(
                                __( 'Honeycombs Grid', "ts_visual_composer_extend" )		=> "honeycombs",
                                __( 'Rectangle Grid', "ts_visual_composer_extend" )			=> "grid",
                                __( 'Freewall Grid', "ts_visual_composer_extend" )			=> "freewall",
								__( 'OwlSlider', "ts_visual_composer_extend" )				=> "owlslider",
                            ),
                            "description"               => __( "Please define what layout you want to use to display the logos.", "ts_visual_composer_extend" ),
                            "admin_label"               => true,
                            "dependency"                => ""
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Logo Links Target", "ts_visual_composer_extend" ),
							"param_name"        		=> "target",
							"value"             		=> array(
								__( "Same Window", "ts_visual_composer_extend" )                    => "_parent",
								__( "New Window", "ts_visual_composer_extend" )                     => "_blank"
							),
							"admin_label"               => true,
							"description"       		=> __( "Define how the logo links should be opened.", "ts_visual_composer_extend" ),
						),	
						// Full Width Settings
						array(
							"type"              		=> "switch_button",
							"heading"               	=> __( "Make Element Full-Width", "ts_visual_composer_extend" ),
							"param_name"            	=> "fullwidth",
							"value"                 	=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"admin_label"               => true,
							"description"           	=> __( "Switch the toggle if you want to attempt showing the element in full width (will not work with all themes).", "ts_visual_composer_extend" ),
						),
						array(
							"type"                  	=> "nouislider",
							"heading"               	=> __( "Full Element Breakouts", "ts_visual_composer_extend" ),
							"param_name"            	=> "breakouts",
							"value"                 	=> "6",
							"min"                   	=> "0",
							"max"                   	=> "99",
							"step"                  	=> "1",
							"unit"                  	=> '',
							"description"           	=> __( "Define the number of parent containers the element should attempt to break away from.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "fullwidth", 'value' => 'true' ),
						),
						// Honeycombs Grid Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_2",
							"value"						=> "",
                            "seperator"					=> "Honeycombs Grid",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'honeycombs' ),
							"group"						=> "Grid Settings"
                        ),
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Comb Alignment", "ts_visual_composer_extend" ),
							"param_name"            	=> "honeycombs_layout",
							"width"                 	=> 150,
							"value"                 	=> array(
								__( 'Flat Comb Side on Top', "ts_visual_composer_extend" )			=> "flat",
								__( 'Comb Corner (Edge) on Top', "ts_visual_composer_extend" )		=> "edge",
							),
							"description"           	=> __( "Select how the honeycomb elements should be aligned inside the honeycomb grid.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'honeycombs' ),
							"group"						=> "Grid Settings"
						),
						array(
							"type"                  	=> "textfield",
							"heading"               	=> __( "Comb Break Points", "ts_visual_composer_extend" ),
							"param_name"            	=> "honeycombs_break",
							"value"                 	=> "1280,960,640",
							"description"          	 	=> __( "Define the break points (width) to trigger different comb sizes; seperate by comma (3 breakpoints required).", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'honeycombs' ),
							"group"						=> "Grid Settings"
						),
						array(
							"type"                  	=> "textfield",
							"heading"               	=> __( "Comb Sizes", "ts_visual_composer_extend" ),
							"param_name"            	=> "honeycombs_sizes",
							"value"                 	=> "340,250,180,100",
							"description"           	=> __( "Define the individual comb sizes, triggered by the breakpoints above; seperate by comma (4 sizes required).", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'honeycombs' ),
							"group"						=> "Grid Settings"
						),
						array(
							"type"              		=> "switch_button",
							"heading"			    	=> __( "Honeycomb Tooltip", "ts_visual_composer_extend" ),
							"param_name"		    	=> "honeycombs_tooltips",
							"value"				    	=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want show a title tooltip with the honeycomb images.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'honeycombs' ),
							"group"						=> "Grid Settings"
						),
						// Tooltip Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_3",
							"value"						=> "",
                            "seperator"					=> "Tooltip Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "honeycombs_tooltips", 'value' => 'true' ),
							"group" 			        => "Grid Settings",
                        ),						
						array(
							"type"						=> "dropdown",
							"class"						=> "",
							"heading"					=> __( "Tooltip Style", "ts_visual_composer_extend" ),
							"param_name"				=> "tooltipster_theme",
							"value"						=> array(
								__( "Black", "ts_visual_composer_extend" )                          => "tooltipster-black",
								__( "Gray", "ts_visual_composer_extend" )                           => "tooltipster-gray",
								__( "Green", "ts_visual_composer_extend" )                          => "tooltipster-green",
								__( "Blue", "ts_visual_composer_extend" )                           => "tooltipster-blue",
								__( "Red", "ts_visual_composer_extend" )                            => "tooltipster-red",
								__( "Orange", "ts_visual_composer_extend" )                         => "tooltipster-orange",
								__( "Yellow", "ts_visual_composer_extend" )                         => "tooltipster-yellow",
								__( "Purple", "ts_visual_composer_extend" )                         => "tooltipster-purple",
								__( "Pink", "ts_visual_composer_extend" )                           => "tooltipster-pink",
								__( "White", "ts_visual_composer_extend" )                          => "tooltipster-white"
							),
							"description"				=> __( "Select the tooltip style.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "honeycombs_tooltips", 'value' => 'true' ),
							"group" 			        => "Grid Settings",
						),
						array(
							"type"				    	=> "dropdown",
							"class"				    	=> "",
							"heading"			    	=> __( "Tooltip Animation", "ts_visual_composer_extend" ),
							"param_name"		    	=> "tooltipster_animation",
							"value"                 	=> array(
								__("Swing", "ts_visual_composer_extend")                    => "swing",
								__("Fall", "ts_visual_composer_extend")                 	=> "fall",
								__("Grow", "ts_visual_composer_extend")                 	=> "grow",
								__("Slide", "ts_visual_composer_extend")                 	=> "slide",
								__("Fade", "ts_visual_composer_extend")                 	=> "fade",
							),
							"description"		    	=> __( "Select how the tooltip entry and exit should be animated once triggered.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "honeycombs_tooltips", 'value' => 'true' ),
							"group" 			        => "Grid Settings",
						),	
						array(
							"type"				    	=> "dropdown",
							"class"				    	=> "",
							"heading"			    	=> __( "Tooltip Position", "ts_visual_composer_extend" ),
							"param_name"		    	=> "tooltipster_position",
							"value"                 	=> array(
								__("Top", "ts_visual_composer_extend")                    			=> "ts-simptip-position-top",
								__("Bottom", "ts_visual_composer_extend")                 			=> "ts-simptip-position-bottom",
								//__("Left", "ts_visual_composer_extend")                   		=> "ts-simptip-position-left",
								//__("Right", "ts_visual_composer_extend")                 			=> "ts-simptip-position-right",
							),
							"description"		    	=> __( "Select the tooltip position in relation to the trigger.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "honeycombs_tooltips", 'value' => 'true' ),
							"group" 			        => "Grid Settings",
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
							"description"				=> __( "Define an optional X-Offset for the tooltip position.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "honeycombs_tooltips", 'value' => 'true' ),
							"group" 			        => "Grid Settings",
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
							"description"				=> __( "Define an optional Y-Offset for the tooltip position.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "honeycombs_tooltips", 'value' => 'true' ),
							"group" 			        => "Grid Settings",
						),
						// Rectangle Grid Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_4",
							"value"						=> "",
                            "seperator"					=> "Rectangle Grid",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'grid' ),
							"group"						=> "Grid Settings"
                        ),
						array(
							"type"                  	=> "textfield",
							"heading"               	=> __( "Grid Break Points", "ts_visual_composer_extend" ),
							"param_name"            	=> "data_grid_breaks",
							"value"                 	=> "240,480,720,960",
							"description"           	=> __( "Define the break points (columns) for the grid based on available screen size; seperate by comma.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'grid' ),
							"group"						=> "Grid Settings"
						),						
						// Freewall Grid Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_5",
							"value"						=> "",
                            "seperator"					=> "Freewall Grid",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'freewall' ),
							"group"						=> "Grid Settings"
                        ),
						array(
							"type"                  	=> "nouislider",
							"heading"               	=> __( "Logo Width", "ts_visual_composer_extend" ),
							"param_name"            	=> "data_grid_width",
							"value"                 	=> "250",
							"min"                   	=> "100",
							"max"                   	=> "500",
							"step"                  	=> "1",
							"unit"                  	=> 'px',
							"description"           	=> __( "Define the desired width of each element in the grid; will be adjusted if necessary.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'freewall' ),
							"group"						=> "Grid Settings"
						),
						// Rectangle + Freewall Grid Settings
						array(
							"type"                  	=> "nouislider",
							"heading"               	=> __( "Grid Space", "ts_visual_composer_extend" ),
							"param_name"            	=> "data_grid_space",
							"value"                 	=> "2",
							"min"                   	=> "0",
							"max"                   	=> "20",
							"step"                  	=> "1",
							"unit"                  	=> 'px',
							"description"           	=> __( "Define the space between elements in the grid.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => array('grid', 'freewall') ),
							"group"						=> "Grid Settings"
						),
						array(
							"type"              		=> "switch_button",
							"heading"			    	=> __( "Always Show Label", "ts_visual_composer_extend" ),
							"param_name"		    	=> "data_grid_always",
							"value"				    	=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"		    	=> __( "Switch the toggle if you want to always show the logo label, or only on hover.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => array('grid', 'freewall') ),
							"group"						=> "Grid Settings"
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "None-Link Logos", "ts_visual_composer_extend" ),
							"param_name"        		=> "data_grid_invalid",
							"value"             		=> array(
								__( "Exclude from Grid", "ts_visual_composer_extend" )                     	=> "exclude",
								__( "Show Logo and Open in Lightbox", "ts_visual_composer_extend" )			=> "lightbox",
								__( "Show Logo without Click Event", "ts_visual_composer_extend" )			=> "display",
							),
							"description"       	=> __( "Select how logos without links should be treated.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => array('grid', 'freewall') ),
							"group"						=> "Grid Settings"
						),
						// OwlSlider Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_6",
							"value"						=> "",
                            "seperator"					=> "OwlSlider Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings"
                        ),
						array(
							"type" 						=> "css3animations",
							"class" 					=> "",
							"heading" 					=> __("In-Animation Type", "ts_visual_composer_extend"),
							"param_name" 				=> "animation_in",
							"standard"					=> "false",
							"prefix"					=> "ts-viewport-css-",
							"connector"					=> "css3animations_in",
							"default"					=> "flipInX",
							"value" 					=> "",
							"admin_label"				=> false,
							"description" 				=> __("Select the CSS3 in-animation you want to apply to the slider.", "ts_visual_composer_extend"),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings"
						),
						array(
							"type"                      => "hidden_input",
							"heading"                   => __( "In-Animation Type", "ts_visual_composer_extend" ),
							"param_name"                => "css3animations_in",
							"value"                     => "",
							"description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings"
						),						
						array(
							"type" 						=> "css3animations",
							"class" 					=> "",
							"heading" 					=> __("Out-Animation Type", "ts_visual_composer_extend"),
							"param_name" 				=> "animation_out",
							"standard"					=> "false",
							"prefix"					=> "ts-viewport-css-",
							"connector"					=> "css3animations_out",
							"default"					=> "slideOutDown",
							"value" 					=> "",
							"admin_label"				=> false,
							"description" 				=> __("Select the CSS3 out-animation you want to apply to the slider.", "ts_visual_composer_extend"),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings"
						),
						array(
							"type"                      => "hidden_input",
							"heading"                   => __( "Out-Animation Type", "ts_visual_composer_extend" ),
							"param_name"                => "css3animations_out",
							"value"                     => "",
							"description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings"
						),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Animate on Mobile", "ts_visual_composer_extend" ),
                            "param_name"                => "animation_mobile",
                            "value"                     => "false",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the CSS3 animations on mobile devices.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings"
                        ),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Auto-Height", "ts_visual_composer_extend" ),
							"param_name"                => "auto_height",
							"value"                     => "true",
							"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"					    => __( 'No', "ts_visual_composer_extend" ),
							"style"					    => "select",
							"design"				    => "toggle-light",
							"description"               => __( "Switch the toggle if you want the slider to auto-adjust its height.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings"
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Max. Number of Elements", "ts_visual_composer_extend" ),
							"param_name"                => "number_images",
							"value"                     => "1",
							"min"                       => "1",
							"max"                       => "50",
							"step"                      => "1",
							"unit"                      => '',
							"description"               => __( "Define the maximum number of elements per slide.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings"
						),						
						array(
							"type"						=> "switch_button",
							"heading"					=> __( "Custom Number Settings", "ts_visual_composer_extend" ),
							"param_name"				=> "break_custom",
							"value"						=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"				=> __( "Switch the toggle if you want to define different numbers of elements per slide for pre-defined slider widths.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings"
						),
						array(
							"type"                  	=> "textfield",
							"heading"               	=> __( "Items per Slide", "ts_visual_composer_extend" ),
							"param_name"            	=> "break_string",
							"value"                 	=> "1,2,3,4,5,6,7,8",
							"description"           	=> __( "Define the number of items per slide based on the following slider widths: 0,360,720,960,1280,1440,1600,1920; seperate by comma (total of 8 values required).", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "break_custom", 'value' => 'true' ),
							"group"						=> "OwlSlider Settings"
						),						
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Element Spacing", "ts_visual_composer_extend" ),
							"param_name"                => "slide_margin",
							"value"                     => "10",
							"min"                       => "0",
							"max"                       => "50",
							"step"                      => "1",
							"unit"                      => 'px',
							"description"               => __( "Define the spacing between slide elements (if more than one element is shown per slide).", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings"
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "RTL Page", "ts_visual_composer_extend" ),
							"param_name"                => "page_rtl",
							"value"                     => "false",
							"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"					    => __( 'No', "ts_visual_composer_extend" ),
							"style"					    => "select",
							"design"				    => "toggle-light",
							"description"               => __( "Switch the toggle if the slider is used on a page with RTL (Right-To-Left) alignment.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings"
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Auto-Play", "ts_visual_composer_extend" ),
							"param_name"                => "auto_play",
							"value"                     => "false",
							"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"					    => __( 'No', "ts_visual_composer_extend" ),
							"style"					    => "select",
							"design"				    => "toggle-light",
							"description"               => __( "Switch the toggle if you want the auto-play the slider on page load.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings"
						),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Play / Pause", "ts_visual_composer_extend" ),
                            "param_name"                => "show_playpause",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show a play / pause button to control the autoplay.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "auto_play", "value" => "true"),
							"group"						=> "OwlSlider Settings"
                        ),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Show Progressbar", "ts_visual_composer_extend" ),
							"param_name"                => "show_bar",
							"value"                     => "true",
							"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"					    => __( 'No', "ts_visual_composer_extend" ),
							"style"					    => "select",
							"design"				    => "toggle-light",
							"description"               => __( "Switch the toggle if you want to show a progressbar during auto-play.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "auto_play", "value" 	=> "true"),
							"group"						=> "OwlSlider Settings"
						),
						array(
							"type"                      => "colorpicker",
							"heading"                   => __( "Progressbar Color", "ts_visual_composer_extend" ),
							"param_name"                => "bar_color",
							"value"                     => "#dd3333",
							"description"               => __( "Define the color of the animated progressbar.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "auto_play", "value" 	=> "true"),
							"group"						=> "OwlSlider Settings"
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Auto-Play Speed", "ts_visual_composer_extend" ),
							"param_name"                => "show_speed",
							"value"                     => "5000",
							"min"                       => "1000",
							"max"                       => "20000",
							"step"                      => "100",
							"unit"                      => 'ms',
							"description"               => __( "Define the speed used to auto-play the slider.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "auto_play","value" 	=> "true"),
							"group"						=> "OwlSlider Settings"
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Stop on Hover", "ts_visual_composer_extend" ),
							"param_name"                => "stop_hover",
							"value"                     => "true",
							"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"					    => __( 'No', "ts_visual_composer_extend" ),
							"style"					    => "select",
							"design"				    => "toggle-light",
							"description"               => __( "Switch the toggle if you want the stop the auto-play while hovering over the slider.", "ts_visual_composer_extend" ),
							"dependency"                => array( 'element' => "auto_play", 'value' => 'true' ),
							"group"						=> "OwlSlider Settings"
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Show Top Navigation", "ts_visual_composer_extend" ),
							"param_name"                => "show_navigation",
							"value"                     => "true",
							"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"					    => __( 'No', "ts_visual_composer_extend" ),
							"style"					    => "select",
							"design"				    => "toggle-light",
							"description"               => __( "Switch the toggle if you want to show left/right navigation buttons for the slider.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings"
						),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Show Dots", "ts_visual_composer_extend" ),
							"param_name"                => "show_dots",
							"value"                     => "true",
							"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"					    => __( 'No', "ts_visual_composer_extend" ),
							"style"					    => "select",
							"design"				    => "toggle-light",
							"description"               => __( "Switch the toggle if you want to show dot navigation buttons below the slider.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => 'owlslider' ),
							"group"						=> "OwlSlider Settings"
						),
                        // Other Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_7",
							"value"						=> "",
                            "seperator"					=> "Filter Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => array('grid', 'freewall', 'honeycombs') ),
							"group" 			        => "Filter Settings",
                        ),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Show Filter", "ts_visual_composer_extend" ),
							"param_name"                => "filters_show",
							"value"                     => "false",
							"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"					    => __( 'No', "ts_visual_composer_extend" ),
							"style"					    => "select",
							"design"				    => "toggle-light",
							"description"               => __( "Switch the toggle if you want to show a filter option (by categories) for the logos.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "layout", 'value' => array('grid', 'freewall', 'honeycombs') ),
							"group" 			        => "Filter Settings",
						),
						array(
							"type"                  	=> "textfield",
							"heading"               	=> __( "Filter Toggle: Text", "ts_visual_composer_extend" ),
							"param_name"            	=> "filters_toggle",
							"value"                 	=> "Toggle Filter",
							"description"           	=> __( "Enter a text to be used for the filter button.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "filters_show", 'value' => 'true' ),
							"group" 			        => "Filter Settings",
						),
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Filter Toggle: Style", "ts_visual_composer_extend" ),
							"param_name"           	 	=> "filters_toggle_style",
							"width"                 	=> 150,
							"value"                 	=> array(
								__( 'No Style', "ts_visual_composer_extend" )				=> "",
								__( 'Sun Flower Flat', "ts_visual_composer_extend" )		=> "ts-color-button-sun-flower",
								__( 'Orange Flat', "ts_visual_composer_extend" )			=> "ts-color-button-orange-flat",
								__( 'Carot Flat', "ts_visual_composer_extend" )     		=> "ts-color-button-carrot-flat",
								__( 'Pumpkin Flat', "ts_visual_composer_extend" )			=> "ts-color-button-pumpkin-flat",
								__( 'Alizarin Flat', "ts_visual_composer_extend" )			=> "ts-color-button-alizarin-flat",
								__( 'Pomegranate Flat', "ts_visual_composer_extend" )		=> "ts-color-button-pomegranate-flat",
								__( 'Turquoise Flat', "ts_visual_composer_extend" )			=> "ts-color-button-turquoise-flat",
								__( 'Green Sea Flat', "ts_visual_composer_extend" )			=> "ts-color-button-green-sea-flat",
								__( 'Emerald Flat', "ts_visual_composer_extend" )			=> "ts-color-button-emerald-flat",
								__( 'Nephritis Flat', "ts_visual_composer_extend" )			=> "ts-color-button-nephritis-flat",
								__( 'Peter River Flat', "ts_visual_composer_extend" )		=> "ts-color-button-peter-river-flat",
								__( 'Belize Hole Flat', "ts_visual_composer_extend" )		=> "ts-color-button-belize-hole-flat",
								__( 'Amethyst Flat', "ts_visual_composer_extend" )			=> "ts-color-button-amethyst-flat",
								__( 'Wisteria Flat', "ts_visual_composer_extend" )			=> "ts-color-button-wisteria-flat",
								__( 'Wet Asphalt Flat', "ts_visual_composer_extend" )		=> "ts-color-button-wet-asphalt-flat",
								__( 'Midnight Blue Flat', "ts_visual_composer_extend" )		=> "ts-color-button-midnight-blue-flat",
								__( 'Clouds Flat', "ts_visual_composer_extend" )			=> "ts-color-button-clouds-flat",
								__( 'Silver Flat', "ts_visual_composer_extend" )			=> "ts-color-button-silver-flat",
								__( 'Concrete Flat', "ts_visual_composer_extend" )			=> "ts-color-button-concrete-flat",
								__( 'Asbestos Flat', "ts_visual_composer_extend" )			=> "ts-color-button-asbestos-flat",
								__( 'Graphite Flat', "ts_visual_composer_extend" )			=> "ts-color-button-graphite-flat",
							),
							"description"           	=> __( "Select the color scheme for the filter button.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "filters_show", 'value' => 'true' ),
							"group" 			        => "Filter Settings",
						),
						array(
							"type"                  	=> "textfield",
							"heading"               	=> __( "Show All Toggle: Text", "ts_visual_composer_extend" ),
							"param_name"           	 	=> "filters_showall",
							"value"                 	=> "Show All",
							"description"           	=> __( "Enter a text to be used for the show all button.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "filters_show", 'value' => 'true' ),
							"group" 			        => "Filter Settings",
						),
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Show All Toggle: Style", "ts_visual_composer_extend" ),
							"param_name"            	=> "filters_showall_style",
							"width"                 	=> 150,
							"value"                 	=> array(
								__( 'No Style', "ts_visual_composer_extend" )				=> "",
								__( 'Sun Flower Flat', "ts_visual_composer_extend" )		=> "ts-color-button-sun-flower",
								__( 'Orange Flat', "ts_visual_composer_extend" )			=> "ts-color-button-orange-flat",
								__( 'Carot Flat', "ts_visual_composer_extend" )     		=> "ts-color-button-carrot-flat",
								__( 'Pumpkin Flat', "ts_visual_composer_extend" )			=> "ts-color-button-pumpkin-flat",
								__( 'Alizarin Flat', "ts_visual_composer_extend" )			=> "ts-color-button-alizarin-flat",
								__( 'Pomegranate Flat', "ts_visual_composer_extend" )		=> "ts-color-button-pomegranate-flat",
								__( 'Turquoise Flat', "ts_visual_composer_extend" )			=> "ts-color-button-turquoise-flat",
								__( 'Green Sea Flat', "ts_visual_composer_extend" )			=> "ts-color-button-green-sea-flat",
								__( 'Emerald Flat', "ts_visual_composer_extend" )			=> "ts-color-button-emerald-flat",
								__( 'Nephritis Flat', "ts_visual_composer_extend" )			=> "ts-color-button-nephritis-flat",
								__( 'Peter River Flat', "ts_visual_composer_extend" )		=> "ts-color-button-peter-river-flat",
								__( 'Belize Hole Flat', "ts_visual_composer_extend" )		=> "ts-color-button-belize-hole-flat",
								__( 'Amethyst Flat', "ts_visual_composer_extend" )			=> "ts-color-button-amethyst-flat",
								__( 'Wisteria Flat', "ts_visual_composer_extend" )			=> "ts-color-button-wisteria-flat",
								__( 'Wet Asphalt Flat', "ts_visual_composer_extend" )		=> "ts-color-button-wet-asphalt-flat",
								__( 'Midnight Blue Flat', "ts_visual_composer_extend" )		=> "ts-color-button-midnight-blue-flat",
								__( 'Clouds Flat', "ts_visual_composer_extend" )			=> "ts-color-button-clouds-flat",
								__( 'Silver Flat', "ts_visual_composer_extend" )			=> "ts-color-button-silver-flat",
								__( 'Concrete Flat', "ts_visual_composer_extend" )			=> "ts-color-button-concrete-flat",
								__( 'Asbestos Flat', "ts_visual_composer_extend" )			=> "ts-color-button-asbestos-flat",
								__( 'Graphite Flat', "ts_visual_composer_extend" )			=> "ts-color-button-graphite-flat",
							),
							"description"           	=> __( "Select the color scheme for the show all button.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "filters_show", 'value' => 'true' ),
							"group" 			        => "Filter Settings",
						),	
						array(
							"type"                  	=> "textfield",
							"heading"               	=> __( "Text: Available Groups", "ts_visual_composer_extend" ),
							"param_name"            	=> "filters_available",
							"value"                 	=> "Available Groups",
							"description"           	=> __( "Enter a text to be used a header for the section with the available groups.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "filters_show", 'value' => 'true' ),
							"group" 			        => "Filter Settings",
						),
						array(
							"type"                  	=> "textfield",
							"heading"               	=> __( "Text: Selected Groups", "ts_visual_composer_extend" ),
							"param_name"            	=> "filters_selected",
							"value"                 	=> "Filtered Groups",
							"description"           	=> __( "Enter a text to be used a header for the section with the selected groups.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "filters_show", 'value' => 'true' ),
							"group" 			        => "Filter Settings",
						),
						array(
							"type"                  	=> "textfield",
							"heading"               	=> __( "Text: Ungrouped Images", "ts_visual_composer_extend" ),
							"param_name"            	=> "filters_nogroups",
							"value"                 	=> "No Groups",
							"description"           	=> __( "Enter a text to be used to group images without any other groups applied to it.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "filters_show", 'value' => 'true' ),
							"group" 			        => "Filter Settings",
						),
                        // Other Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_8",
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
                    ))
                );
			}
			
		}
	}
}
// Register Shortcode with Visual Composer
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_TS_VCSC_Logo_Layouts_Category extends WPBakeryShortCode {};
}
// Initialize "TS Logos" Class
if (class_exists('TS_Logos')) {
	$TS_Logos = new TS_Logos;
}