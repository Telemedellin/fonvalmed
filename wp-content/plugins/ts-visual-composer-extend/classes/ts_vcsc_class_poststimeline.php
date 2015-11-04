<?php
if (!class_exists('TS_PostsTimeline')){
	class TS_PostsTimeline {
		function __construct() {
			global $VISUAL_COMPOSER_EXTENSIONS;
            if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
                add_action('init',                                  	array($this, 'TS_VCSC_Add_Posts_Timeline_Elements'), 9999999);
            } else {
                add_action('admin_init',		                    	array($this, 'TS_VCSC_Add_Posts_Timeline_Elements'), 9999999);
            }
            add_shortcode('TS_VCSC_Posts_Timeline_Standalone',          array($this, 'TS_VCSC_Posts_Timeline_Standalone'));
		}
		
		// Posts Timeline
		function TS_VCSC_Posts_Timeline_Standalone ($atts) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
				wp_enqueue_style('ts-extend-csstimeline');
				wp_enqueue_script('ts-extend-csstimeline');	
				wp_enqueue_script('ts-extend-hammer');
				wp_enqueue_script('ts-extend-nacho');
				wp_enqueue_style('ts-extend-nacho');
				wp_enqueue_style('ts-font-ecommerce');
				wp_enqueue_style('ts-font-teammates');
				wp_enqueue_style('dashicons');
				wp_enqueue_style('ts-extend-tooltipster');
				wp_enqueue_script('ts-extend-tooltipster');	
				wp_enqueue_style('ts-extend-buttonsdual');
				wp_enqueue_script('ts-visual-composer-extend-front');
			}
	
			extract( shortcode_atts( array(
				// Post Settings
				'post_type'						=> 'post',
				'date_format'					=> 'F j, Y',
				'datetime_translate'			=> 'true',
				'time_format'					=> 'l, g:i A',				
				'limit_posts'					=> 'true',
				'limit_by'						=> 'category',							// post_tag, cust_tax
				'limit_term'					=> '',				
				'filter_by'						=> 'category', 							// post_tag, cust_tax
				'posts_limit'					=> 25,
				// Posts Content
				'content_show'					=> 'excerpt',							// excerpt, cutcharacters, complete
				'content_cutoff'				=> 400,
				// Posts Link Button
				'button_show'					=> 'true',
				'button_text'					=> 'Read Post',
				'button_target'					=> '_blank',
				'button_style'					=> 'ts-dual-buttons-color-default',
				'button_hover'					=> 'ts-dual-buttons-preview-default ts-dual-buttons-hover-default',
				'button_width'					=> 100,
				// Posts Information
				'show_periods'					=> 'true',
				'show_date'						=> 'true',
				'show_featured'					=> 'true',
				'show_share'					=> 'true',
				'show_categories'				=> 'true',
				'show_tags'						=> 'true',
				'show_metadata'					=> 'true',
				'show_avatar'					=> 'true',
				'show_editlinks'				=> 'true',
				// Featured Image
				'featured_link'					=> 'lightbox',
				// Lightbox Settings
				'lightbox_effect'				=> 'random',
				'lightbox_speed'				=> 5000,
				'lightbox_backlight'			=> 'auto',
				'lightbox_backlight_color'		=> '#ffffff',				
				// Timeline Settings
				'timeline_order'				=> 'desc',
				'timeline_sort'					=> 'true',
				'timeline_sort_by'				=> 'postDate',
				'timeline_sort_label'			=> 'Sort Posts:',
				'timeline_sort_asc'				=> 'Ascending',
				'timeline_sort_desc'			=> 'Descending',				
				'timeline_lazy'					=> 'false',
				'timeline_trigger'				=> 'scroll',
				'timeline_count'				=> '10',
				'timeline_break'				=> '600',
				'timeline_layout'				=> 'ts-timeline-css-columns', // ts-timeline-css-columns, ts-timeline-css-right, ts-timeline-css-left, ts-timeline-css-responsive
				'timeline_switch'				=> 'ts-timeline-css-responsive',				
				'timeline_title_text'				=> '',
				'timeline_title_color'			=> '#7c7979',
				'timeline_load'					=> 'Load More',
				'timeline_filter_allow'			=> 'true',
				'timeline_filter_cats'			=> 'true',
				'timeline_filter_tags'			=> 'true',
				'timeline_filter_labelcats'		=> 'Filter By Categories:',
				'timeline_filter_labeltags'		=> 'Filter By Tags:',
				'timeline_filter_nocats'		=> 'No Categories',
				'timeline_filter_notags'		=> 'No Tags',
				'timeline_filter_breaks'		=> 'Timeline Periods',
				'timeline_filter_selected'		=> 'Selected',
				'timeline_filter_selectall'		=> 'Select All',
				// Other Settings
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
			
			// Post Query
			$limit_term 						= str_replace(' ', '', $limit_term);

			if ($limit_by == 'category') {
				$limit_tax 						= 'category';
			} else if ($limit_by == 'post_tag') {
				$limit_tax 						= 'post_tag';
			} else if ($limit_by == 'cust_tax') {
				$limit_tax 						= '';
			}

			$filter_tax 						= '';
			
			// - set the taxonomy for the filter menu -
			if ($filter_by == 'category') {
				$menu_tax 						= 'category';
			} else if ($filter_by == 'post_tag') {
				$menu_tax 						= 'post_tag';
			} else if ($filter_by == 'cust_tax') {
				$menu_tax 						= $filter_tax; 
			}

			// Set the WP Query Arguments
			$args = array(
				'post_type' 					=> $post_type,
				'posts_per_page' 				=> '-1'
			);
			if ($limit_posts == 'true' && taxonomy_exists($limit_tax)) {
				$limited_terms 					= explode(',', $limit_term);
				$args['tax_query'] = array(
					array (
						'taxonomy' 				=> $limit_tax,
						'field' 				=> 'slug',
						'terms' 				=> $limited_terms,
						'operator' 				=> 'NOT IN'
					)
				);
			}
			$timelineposts 						= new WP_Query($args);
			
			// Lightbox Settings
			if ($lightbox_backlight == "auto") {
				$nacho_color					= '';
			} else if ($lightbox_backlight == "custom") {
				$nacho_color					= 'data-color="' . $lightbox_backlight_color . '"';
			} else if ($lightbox_backlight == "hideit") {
				$nacho_color					= 'data-color="rgba(0, 0, 0, 0)"';
			}
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$vc_inline						= 'true';
				$vc_inline_style				= ' display: block;';
			} else {
				$vc_inline						= 'false';
				$vc_inline_style				= '';
			}		
			
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
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				echo '<div id="ts-isotope-posts-grid-frontend-' . $timeline_random . '" class="ts-isotope-posts-grid-frontend" style="border: 1px solid #ededed; padding: 10px;">';
					echo '<div style="font-weight: bold;">"TS Posts Timeline"</div>';
					echo '<div style="margin-bottom: 20px;">The element has been disabled in order to ensure compatiblity with the Visual Composer Front-End Editor.</div>';
					echo '<div>' . __( "Exclude Categories", "ts_visual_composer_extend" ) . ': ' . $limit_posts . '</div>';
					if ($limit_posts == 'true') {
						echo '<div>' . __( "Excluded", "ts_visual_composer_extend" ) . ': ' . (empty($limit_term) ? __( 'None', "ts_visual_composer_extend" ) : $limit_term) . '</div>';
					}
					echo '<div>' . __( "Number of Posts", "ts_visual_composer_extend" ) . ': ' . $posts_limit . '</div>';
					$front_edit_reverse = array(
						"excerpt" 			=> __( 'Excerpt', "ts_visual_composer_extend" ),
						"cutcharacters" 	=> __( 'Character Limited Content', "ts_visual_composer_extend" ),
						"complete" 			=> __( 'Full Content', "ts_visual_composer_extend" ),
					);
					foreach($front_edit_reverse as $key => $value) {
						if ($key == $content_show) {
							echo '<div>' . __( "Content Length", "ts_visual_composer_extend" ) . ': ' . $value . '</div>';
						}
					};
					echo '<div>' . __( "Show 'Read Post' Button", "ts_visual_composer_extend" ) . ': ' . $button_show . '</div>';
					$front_edit_reverse = array(
						"asc"				=> __( 'Bottom to Top', "ts_visual_composer_extend" ),
						"desc"				=> __( 'Top to Bottom', "ts_visual_composer_extend" ),
					);
					foreach($front_edit_reverse as $key => $value) {
						if ($key == $timeline_order) {
							echo '<div>' . __( "Initial Order", "ts_visual_composer_extend" ) . ': ' . $value . '</div>';
						}
					};
				echo '</div>';
			} else {
				echo '<div id="' . $timeline_container_id . '" class="' . $css_class . ' ' . $timeline_class . '" data-type="posts" data-layout="' . $timeline_layout . '" ' . $timeline_filter_data . ' data-sorter="' . $timeline_sort . '" data-switch="' . $timeline_switch . '" data-order="' . $timeline_order .'" data-lazy="' . $timeline_lazy . '" data-count="' . $timeline_count . '" data-trigger="' . $timeline_trigger . '" data-break="' . $timeline_break . '" style="margin-top: ' . $vcinline_margin . 'px; margin-bottom: ' . $margin_bottom . 'px; width: 100%;">';
					echo $vcinline_note;
					
					// Filter Controls
					if (($timeline_filter_allow == "true") && (($timeline_filter_cats == "true") || ($timeline_filter_tags == "true"))) {
						// Categories Filter
						if ($timeline_filter_cats == "true") {
							echo '<div id="ts-timeline-css-filters-cats-' . $timeline_random . '" class="ts-timeline-css-filters-cats ts-timeline-css-filters" data-random="' . $timeline_random . '" data-target="ts-timeline-css-content-' . $timeline_random . '" style="display: none;">';
								echo '<label class="ts-timeline-css-filters-cats-label" style="display: inline-block; margin-left: 0;" for="ts-timeline-css-filters-cats-sections-' . $timeline_random . '">' . $timeline_filter_labelcats . '</label>';
									echo '<select id="ts-timeline-css-filters-cats-sections-' . $timeline_random . '" class="ts-timeline-css-filters-cats-sections" multiple="multiple" data-option="ts-timeline-css-filters-cats-sections-' . $timeline_random . '" data-target="ts-timeline-css-content-' . $timeline_random . '"></select>';
							echo '</div>';
						}
						// Tags Filter
						if ($timeline_filter_tags == "true") {
							echo '<div id="ts-timeline-css-filters-tags-' . $timeline_random . '" class="ts-timeline-css-filters-tags ts-timeline-css-filters" data-random="' . $timeline_random . '" data-target="ts-timeline-css-content-' . $timeline_random . '" style="display: none;">';
								echo '<label class="ts-timeline-css-filters-tags-label" style="display: inline-block; margin-left: 0;" for="ts-timeline-css-filters-tags-sections-' . $timeline_random . '">' . $timeline_filter_labeltags . '</label>';
								echo '<select id="ts-timeline-css-filters-tags-sections-' . $timeline_random . '" class="ts-timeline-css-filters-tags-sections" multiple="multiple" data-option="ts-timeline-css-filters-tags-sections-' . $timeline_random . '" data-target="ts-timeline-css-content-' . $timeline_random . '"></select>';
							echo '</div>';
						}
					}
					
					// Sorter Controls
					if (($timeline_sort == "true") && ($vcinline_controls == "true")) {
						echo '<div id="ts-timeline-css-sorter-' . $timeline_random . '" class="ts-timeline-css-sorter" data-random="' . $timeline_random . '" data-target="ts-timeline-css-content-' . $timeline_random . '" style="display: none;">';
							echo '<label class="ts-timeline-css-sorter-label" style="display: inline-block; margin-left: 0;" for="ts-timeline-css-filters-tags-sections-' . $timeline_random . '">' . $timeline_sort_label . '</label>';
							echo '<select id="ts-timeline-css-sorter-sections-' . $timeline_random . '" class="ts-timeline-css-sorter-sections" data-option="ts-timeline-css-sorter-sections-' . $timeline_random . '" data-target="ts-timeline-css-content-' . $timeline_random . '">';
								echo '<option value="asc" ' . ($timeline_order == 'asc' ? 'selected="selected"' : '') . '>' . $timeline_sort_asc . '</option>';
								echo '<option value="desc" ' . ($timeline_order == 'desc' ? 'selected="selected"' : '') . '>' . $timeline_sort_desc . '</option>';
							echo '</select>';
						echo '</div>';
					}
					
					// Timeline Title
					if (!empty($timeline_title_text)) {
						echo '<div class="ts-timeline-css-title-wrapper">';
							echo '<div class="ts-timeline-css-title-string" style="color: ' . $timeline_title_color . ';">' . $timeline_title_text . '</div><div class="ts-timeline-css-title-after"></div>';
						echo '</div>';
					}
					
					echo '<div class="ts-timeline-css-wrapper ' . $timeline_layout . '">';
						echo '<div id="ts-timeline-css-spine-' . $timeline_random . '" class="ts-timeline-css-spine ts-timeline-css-animated"></div>';
						echo '<div id="ts-timeline-css-content-' . $timeline_random . '" class="ts-timeline-css-content ' . ($show_categories == "true" ? "ts-timeline-css-content-show-cats" : "ts-timeline-css-content-hide-cats") . ' ' . ($show_tags == "true" ? "ts-timeline-css-content-show-tags" : "ts-timeline-css-content-hide-tags") . '">';
							// Create Individual Post Output
							$postBreak				= '';
							$postCounter 			= 0;
							$breakCounter			= 0;
							$postMonths 			= array();
							if (post_type_exists($post_type) && $timelineposts->have_posts()) {
								while ($timelineposts->have_posts() ) :
									$timelineposts->the_post();									
									$matched_terms	= 0;
									if ($matched_terms == 0) {
										$postCounter++;
										$postTitle		= '';
										$postBreak		= '';
										$postLink		= '';
										$postData		= '';
										$postMedia		= '';
										$postCategories = '';
										$postTags		= '';
										if ($postCounter < $posts_limit + 1) {
											$postTitle	= get_the_title();
											$postDate	= get_post_time('U');
											$postLink	= get_permalink();
											if ($show_periods == 'true') {
												$postPeriod 		= get_post_time('F Y');
												if (!in_array($postPeriod, $postMonths)) {
													array_push($postMonths, $postPeriod);
													$breakCounter++;
													$breakMonth		= get_post_time('n');
													$breakYear		= get_post_time('Y');
													$breakStart 	= mktime(0, 0, 1, $breakMonth, 1, $breakYear);
													$breakEnd 		= mktime(23, 59, 59, $breakMonth, cal_days_in_month(CAL_GREGORIAN, $breakMonth, $breakYear), $breakYear);
													$postBreak .= '<div id="ts-vcsc-timeline-section-break-' . $timeline_random . '-' . $breakCounter . '" class="ts-timeline-css-section ts-timeline-css-break ts-timeline-css-visible" style="width: 50%; ' . $vc_inline_style . '" data-full="Break: ' . $postPeriod . '" data-date="' . ($timeline_sort == "asc" ? $breakStart : $breakEnd) . '" data-start="' . $breakStart . '" data-end="' . $breakEnd . '" data-fullwidth="false" data-categories="' . $timeline_filter_breaks . '" data-tags="" data-filtered-categories="false" data-filtered-tags="false">';
														$postBreak .= '<div class="ts-timeline-css-text-wrap" style="">';
															$postBreak .= '<div class="ts-timeline-css-text-wrap-inner" style="width: 100%; left: 0; margin: 0 !important; padding: 0;">';
																$postBreak .= '<h3 class="ts-timeline-css-title" style="padding: 0 10px; text-align: center; color: ' . $timeline_title_color . '; margin: 0 !important; padding: 0;">' . $postPeriod . '</h3>';
																$postBreak .= '<div class="ts-timeline-css-text"></div>';
															$postBreak .= '</div>';
															$postBreak .= '<div class="clearFixMe"></div>';
														$postBreak .= '</div>';
													$postBreak .= '</div>';
													echo $postBreak;
												}
											}										
											$postAttributes = 'data-visible="false" data-full="' . get_post_time($date_format) . '" data-author="' . get_the_author() . '" data-date="' . $postDate . '" data-start="' . $postDate . '" data-end="' . $postDate . '" data-modified="' . get_the_modified_time('U') . '" data-title="' . get_the_title() . '" data-comments="' . get_comments_number() . '" data-id="' .  get_the_ID() . '"';
											// Get Post Categories
											if (taxonomy_exists($menu_tax)) {
												foreach(get_the_terms($timelineposts->post->ID, $menu_tax) as $term) {
													$postCategories .= $term->name . ',';
												};
												$postCategories 	= substr($postCategories, 0, -1);
											}
											// Get Post Tags
											foreach(wp_get_post_tags($timelineposts->post->ID) as $term) {
												$postTags 			.= $term->name . ',';
											};
											$postTags 				= substr($postTags, 0, -1);
											// Build Post Output
											echo '<div id="ts-vcsc-timeline-section-post-' . $timeline_random . '-' . $postCounter . '" class="ts-timeline-css-section ts-timeline-css-event ts-timeline-css-visible ts-timeline-css-animated ' . ($show_date ? "ts-timeline-css-date-true" : "ts-timeline-css-date-false") . '" style="' . $vc_inline_style . '" data-categories="' . $postCategories . '" data-tags="' . $postTags . '" data-filtered-categories="false" data-filtered-tags="false" ' . $postAttributes . '>';
												echo '<div class="ts-timeline-css-text-wrap ' . ($show_date ? "ts-timeline-css-text-wrap-date" : "ts-timeline-css-text-wrap-nodate") . '" style="' . ($show_date ? "padding-top: 35px" : "") . '">';
													if ($show_date == "true") {
														echo '<div class="ts-timeline-css-date"><span class="ts-timeline-css-date-connect"><span class="ts-timeline-css-date-text"><i class="ts-timeline-css-date-icon dashicons dashicons-calendar"></i>' . get_post_time($date_format, false, null, ($datetime_translate == "true" ? true : false)) . '</span></span></div>';
													}													
													if ($show_featured == "true") {
														$postMedia 					= '';
														if ((strlen(get_the_post_thumbnail()) > 0) && (strlen(get_post_thumbnail_id()) > 0)) {
															$media_image 			= wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
															if ($media_image != false) {
																$image_extension 	= pathinfo($media_image[0], PATHINFO_EXTENSION);
																$alt_attribute		= basename($media_image[0], "." . $image_extension);			
																if ($featured_link == "none") {
																	$postMedia .= '<div class="ts-timeline-media" style="max-width: ' . $media_image[1] . 'px; width: 100%; height: auto; margin: 0 auto; float: none;">';
																		$postMedia .= '<img class="" src="' . $media_image[0] . '" alt="' . $alt_attribute . '" style="max-width: ' . $media_image[1] . 'px; padding: 0; margin: 0 auto; display: block; width: 100%; height: auto;">';
																	$postMedia .= '</div>';
																} else if (($featured_link == "current") || ($featured_link == "newone")) {
																	$postMedia .= '<a class="ts-timeline-media" href="' . get_permalink() . '" target="' . (($featured_link == "current") ? '_parent' : '_blank') . '" style="text-decoration: none; border: none; margin: 0; padding: 0;">';
																		$postMedia .= '<div class="ts-timeline-media" style="max-width: ' . $media_image[1] . 'px; width: 100%; height: auto; margin: 0 auto; float: none;">';
																			$postMedia .= '<img class="" src="' . $media_image[0] . '" alt="' . $alt_attribute . '" style="max-width: ' . $media_image[1] . 'px; padding: 0; margin: 0 auto; display: block; width: 100%; height: auto;">';
																		$postMedia .= '</div>';
																	$postMedia .= '</a>';
																} else if ($featured_link == "lightbox") {
																	$postMedia .= '<div class="ts-timeline-media nchgrid-item nchgrid-tile nch-lightbox-image" style="max-width: ' . $media_image[1] . 'px; width: 100%; height: auto; margin: 0 auto; float: none;">';
																		$postMedia .= '<a href="' . $media_image[0] . '" class="nch-lightbox-media no-ajaxy" data-thumbnail="' . $media_image[0] . '" data-title="' . $postTitle . '" rel="timelinegroup" data-share="0" data-effect="' . $lightbox_effect . '" data-social="0" data-duration="'  . $lightbox_speed . '" ' . $nacho_color . '>';
																			$postMedia .= '<img src="' . $media_image[0] . '" alt="' . $alt_attribute . '" title="" style="max-width: ' . $media_image[1] . 'px; padding: 0; margin: 0 auto; display: block; width: 100%; height: auto;">';
																			$postMedia .= '<div class="nchgrid-caption"></div>';
																			$postMedia .= '<div class="nchgrid-caption-text">' . $postTitle . '</div>';
																		$postMedia .= '</a>';
																	$postMedia .= '</div>';
																}
															}
														}
													}
													echo $postMedia;
													echo '<h3 class="ts-timeline-css-title" style="text-align: center; border: none; margin-bottom: 0; padding-bottom: 0;">' . $postTitle . '</h3>';
													echo '<div style="width: 100%; display: block; float: left; position: relative; padding-bottom: 15px;">';
														echo '<div class="ts-timeline-css-text-wrap-inner" style="width: 100%; height: 100%; left: 0;">';
															echo '<div class="ts-timeline-css-text" style="">';														
																if ($content_show == "excerpt") {
																	echo get_the_excerpt();
																} else if ($content_show == "cutcharacters") {
																	$content = apply_filters('the_content', get_the_content());
																	$excerpt = TS_VCSC_TruncateHTML($content, $content_cutoff, '...', false, true);
																	echo $excerpt;
																} else if ($content_show == "complete") {
																	$content = apply_filters('the_content', get_the_content());
																	echo do_shortcode($content);
																}														
															echo '</div>';
														echo '</div>';
													echo '</div>';
													// Post Link Button
													if ($button_show == "true") {
														echo '<div class="ts-timeline-css-button-container">';
															echo '<div class="ts-timeline-css-button-outer clearFixMe" style="width: ' . $button_width . '%; margin-left: auto; margin-right: auto;">';
																echo '<div class="ts-timeline-css-button-wrapper">';
																	echo '<a class="ts-timeline-css-button-link ' . $button_style . ' ' . $button_hover . '" href="' . $postLink . '" target="' . $button_target . '" title="' . $button_text . '">' . $button_text . '</a>';
																echo '</div>';
															echo '</div>';
														echo '</div>';
													}													
													// Post Social Share
													if ($show_share == 'true') {
														echo '<div class="ts-timeline-css-social">';
															echo '<a href="http://pinterest.com/pin/create/link/?url=' . $postLink . '&amp;description=' . $postTitle . '" class="ts-timeline-css-social-holder" rel="external" target="_blank"><span class="ts-timeline-css-social-pinterest"></span></a>';
															echo '<a href="https://plusone.google.com/_/+1/confirm?hl=en&amp;url=' . $postLink . '&amp;name=' . $postTitle . '" class="ts-timeline-css-social-holder" rel="external" target="_blank"><span class="ts-timeline-css-social-google"></span></a>';
															echo '<a href="http://twitter.com/share?text=' . $postTitle . '&url=' . $postLink . '" class="ts-timeline-css-social-holder" rel="external" target="_blank"><span class="ts-timeline-css-social-twitter"></span></a>';
															echo '<a href="http://www.facebook.com/sharer.php?u=' . $postLink . '" class="ts-timeline-css-social-holder" rel="external" target="_blank"><span class="ts-timeline-css-social-facebook"></span></a>';
														echo '</div>';
													}
													// Post Tags
													if (($postTags != '') && ($show_tags == "true")) {
														echo '<div class="ts-timeline-css-output-tags"><i class="dashicons dashicons-tag"></i><span>' . str_replace(",", ", ", $postTags) . '</span></div>';
													}
													// Post Categories
													if (($postCategories != '') && ($show_categories == "true")) {
														echo '<div class="ts-timeline-css-output-cats"><i class="dashicons dashicons-category"></i><span>' . str_replace(",", ", ", $postCategories) . '</span></div>';
													}											
													// Post Time / Author / Type / Comments
													if ($show_metadata == 'true') {
														echo '<div class="ts-timeline-css-metadata clearFixMe" style="' . ((($show_editlinks == 'true') && (is_admin_bar_showing())) ? 'margin-bottom: 0px;' : '') . '">';
															if ($show_avatar == 'true') {
																echo get_avatar(get_the_author_meta('ID'), $size = '40');
															}
															echo '<div class="ts-timeline-css-author">';
																echo get_the_author();
															echo '</div>';
															$format = get_post_format();
															if (false === $format) {
																$format 	= __( 'Standard', "ts_visual_composer_extend" );
																$class 		= 'standard';
															} else {
																$class		= strtolower($format);
															}
															echo '<div class="ts-timeline-css-type ts-timeline-css-type-' . $class . '">';
																echo ucfirst($format);
															echo '</div>';
															echo '<div class="ts-timeline-css-time">';
																echo get_post_time($time_format, false, null, ($datetime_translate == "true" ? true : false));
															echo '</div>';
															echo '<div class="ts-timeline-css-comments">';
																echo get_comments_number();
															echo '</div>';
														echo '</div>';
													}
													// Edit Links
													if (($show_editlinks == 'true') && (is_admin_bar_showing())) {
														echo '<div class="ts-timeline-css-editlinks clearFixMe">';
															echo '<span class="ts-timeline-css-edit"></span>';
															echo '<span class="ts-timeline-css-links">';
																echo edit_post_link();
															echo '</span>';
														echo '</div>';
													}
													echo '<div class="clearFixMe"></div>';
												echo '</div>';
											echo '</div>';
										}
									}
								endwhile;
								wp_reset_postdata();
							} else {
								echo '<p>Nothing found. Please check back soon!</p>';
							}						
						echo '</div>';
					echo '</div>';
					
					// Lazyload Trigger
					if ($timeline_lazy == "true") {
						echo '<div class="ts-timeline-css-showmore-wrap">';
							echo '<span class="ts-timeline-css-showmore ts-dual-buttons-color-peter-river-flat ts-dual-buttons-color-belize-hole-flat">' . $timeline_load . '</span>';
						echo '</div>';
					}
				echo '</div>';
			}
            
            $myvariable = ob_get_clean();
            return $myvariable;
		}		
		
		// Add Timeline Elements
		function TS_VCSC_Add_Posts_Timeline_Elements() {
			global $VISUAL_COMPOSER_EXTENSIONS;
            if (function_exists('vc_map')) {
                vc_map( array(
                    "name"                              => __( "TS Posts Timeline", "ts_visual_composer_extend" ),
                    "base"                              => "TS_VCSC_Posts_Timeline_Standalone",
                    "icon" 	                            => "icon-wpb-ts_vcsc_timeline_posts",
					"class"                     		=> "ts_vcsc_main_timeline_posts",
                    "category"                          => __( 'VC Extensions', "ts_visual_composer_extend" ),
                    "description"                       => __("Place a Posts Timeline element", "ts_visual_composer_extend"),
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
                    "params"                            => array(
                        // Posts Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_1",
							"value"						=> "",
                            "seperator"					=> "Posts Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Exclude Categories", "ts_visual_composer_extend" ),
                            "param_name"                => "limit_posts",
                            "value"                     => "false",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to exclude some post categories for the element.", "ts_visual_composer_extend" ),
                            "dependency"                => ""
                        ),
                        array(
                            "type"                      => "standardpostcat",
                            "heading"                   => __( "Select Excluded Categories", "ts_visual_composer_extend" ),
                            "param_name"                => "limit_term",
                            "posttype"                  => "post",
                            "posttaxonomy"              => "ts_logos_category",
							"taxonomy"              	=> "ts_logos_category",
							"postsingle"				=> "Post",
							"postplural"				=> "Posts",
							"postclass"					=> "post",
                            "value"                     => "",
							"admin_label"		        => true,
                            "description"               => __( "Please select the categories you want to use or exclude for the element.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "limit_posts", "value" 	=> "true"),
                        ),
                        array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Total Number of Posts", "ts_visual_composer_extend" ),
                            "param_name"                => "posts_limit",
                            "value"                     => "25",
                            "min"                       => "1",
                            "max"                       => "250",
                            "step"                      => "1",
                            "unit"                      => '',
							"admin_label"		        => true,
                            "description"               => __( "Select the total number of posts to be retrieved from WordPress.", "ts_visual_composer_extend" ),
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Content Length", "ts_visual_composer_extend" ),
							"param_name"        		=> "content_show",
							"width"             		=> 200,
							"value"             		=> array(
								__( 'Excerpt', "ts_visual_composer_extend" )						=> "excerpt",
								__( 'Character Limited Content', "ts_visual_composer_extend" )		=> "cutcharacters",
								__( 'Full Content', "ts_visual_composer_extend" )					=> "complete",
							),
							"admin_label"		        => true,
							"description"       		=> __( "Select what part of the post content should be shown.", "ts_visual_composer_extend" )
						),
                        array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Character Limit", "ts_visual_composer_extend" ),
                            "param_name"                => "content_cutoff",
                            "value"                     => "400",
                            "min"                       => "100",
                            "max"                       => "1200",
                            "step"                      => "1",
                            "unit"                      => '',
                            "description"               => __( "Select the number of characters to which the post content should be limited to.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "content_show", "value" 	=> "cutcharacters")
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show 'Read Post' Button", "ts_visual_composer_extend" ),
                            "param_name"                => "button_show",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to show a button with a link to read the full post.", "ts_visual_composer_extend" )
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Link Target", "ts_visual_composer_extend" ),
							"param_name"        		=> "button_target",
							"value"             		=> array(
								__( "Same Window", "ts_visual_composer_extend" )                    => "_parent",
								__( "New Window", "ts_visual_composer_extend" )                     => "_blank"
							),
							"description"       		=> __( "Define how the link should be opened.", "ts_visual_composer_extend" ),
							"dependency"        		=> array("element" 	=> "button_show", "value" 	=> "true"),
						),
						array(
							"type"                  	=> "dropdown",
							"heading"              	 	=> __( "Button Color Style", "ts_visual_composer_extend" ),
							"param_name"            	=> "button_style",
							"width"                 	=> 300,
							"value"                 	=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Default_Colors,
							"description"           	=> __( "Select the general color style for the link button.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "button_show", 'value' => 'true' ),
						),
						array(
							"type"                  	=> "dropdown",
							"heading"              	 	=> __( "Button Hover Style", "ts_visual_composer_extend" ),
							"param_name"            	=> "button_hover",
							"width"                 	=> 300,
							"value"                 	=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Flat_Button_Hover_Colors,
							"description"           	=> __( "Select the general hover style for the link button.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "button_show", 'value' => 'true' ),
						),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "'Read Post' Text", "ts_visual_composer_extend" ),
                            "param_name"                => "button_text",
                            "value"                     => "Read Post",
                            "description"               => __( "Enter the text to be shown in the 'Read Post' Link.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "button_show", "value" 	=> "true"),
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Month / Year Headers", "ts_visual_composer_extend" ),
                            "param_name"                => "show_periods",
                            "value"                     => "false",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to show header elements for the timeline layout, grouping posts by month and year.", "ts_visual_composer_extend" ),
                            "dependency"                => ""
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Translate Date/Time Strings", "ts_visual_composer_extend" ),
                            "param_name"                => "datetime_translate",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to auto-translate the date and time strings based on WordPress settings.", "ts_visual_composer_extend" ),
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Date Format", "ts_visual_composer_extend" ),
                            "param_name"                => "date_format",
                            "value"                     => "F j, Y",
                            "description"               => __( "Enter the format in which dates should be shown. You can find more information here:", "ts_visual_composer_extend" ) . '<br/><a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">' . __( "WordPress Date + Time Formats", "ts_visual_composer_extend" ) . '</a>'
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Time Format", "ts_visual_composer_extend" ),
                            "param_name"                => "time_format",
                            "value"                     => "l, g:i A",
                            "description"               => __( "Enter the format in which times should be shown. You can find more information here:", "ts_visual_composer_extend" ) . '<br/><a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">' . __( "WordPress Date + Time Formats", "ts_visual_composer_extend" ) . '</a>'
                        ),
						// Content Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_2",
							"value"						=> "",
                            "seperator"					=> "Content Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Content Settings",
                        ),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "Timeline Title", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_title_text",
							"value"             		=> "",
							"description"       		=> __( "Enter a title for the Isotope Timeline.", "ts_visual_composer_extend" ),
							"group" 			        => "Content Settings",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Title Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_title_color",
							"value"             		=> "#7c7979",
							"description"       		=> __( "Define the font color for the title in the timeline break item.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "timeline_title_text", 'not_empty' => true ),
							"group" 			        => "Content Settings",
						),						
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Featured Image", "ts_visual_composer_extend" ),
                            "param_name"                => "show_featured",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the featured image for each post.", "ts_visual_composer_extend" ),
                            "group" 			        => "Content Settings",
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Alignment", "ts_visual_composer_extend" ),
							"param_name"        		=> "featured_link",
							"width"             		=> 200,
							"value"             		=> array(
								__( "Open Image in Lightbox", "ts_visual_composer_extend" )			=> "lightbox",
								__( "Open Post in New Window", "ts_visual_composer_extend" )		=> "newone",
								__( "Open Post in Current Window", "ts_visual_composer_extend" )	=> "current",
								__( "No Link", "ts_visual_composer_extend" )                    	=> "none",
							),
							"description"       		=> __( "Select how the description text should be aligned.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "show_featured", 'value' => 'true' ),
							"group" 			        => "Content Settings",
						),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Social Share Buttons", "ts_visual_composer_extend" ),
                            "param_name"                => "show_share",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show social share buttons for each post.", "ts_visual_composer_extend" ),
                            "group" 			        => "Content Settings",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Post Categories", "ts_visual_composer_extend" ),
                            "param_name"                => "show_categories",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the categories for each post.", "ts_visual_composer_extend" ),
                            "group" 			        => "Content Settings",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Post Tags", "ts_visual_composer_extend" ),
                            "param_name"                => "show_tags",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the tags for each post.", "ts_visual_composer_extend" ),
                            "group" 			        => "Content Settings",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Post Meta Data", "ts_visual_composer_extend" ),
                            "param_name"                => "show_metadata",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the meta data for each post.", "ts_visual_composer_extend" ),
                            "group" 			        => "Content Settings",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show User Avatar", "ts_visual_composer_extend" ),
                            "param_name"                => "show_avatar",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the meta data for each post.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "show_metadata", "value" 	=> "true"),
                            "group" 			        => "Content Settings",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Post Edit Links", "ts_visual_composer_extend" ),
                            "param_name"                => "show_editlinks",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the edit links for each post (visible only when logged in).", "ts_visual_composer_extend" ),
                            "group" 			        => "Content Settings",
                        ),
						// Layout Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_3",
							"value"						=> "",
                            "seperator"					=> "Layout Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Layout Settings",
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
							"description"       		=> __( "Select the standard layout for the timeline.", "ts_visual_composer_extend" ),
							"group" 			        => "Layout Settings",
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
                            "description"               => __( "Define a breakpoint in pixels at which the timeline should switch to a one column layout.", "ts_visual_composer_extend" ),
							"group" 			        => "Layout Settings",
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
							"description"       		=> __( "Select the layout to which the timeline should switch if the breakpoint is triggered.", "ts_visual_composer_extend" ),
							"group" 			        => "Layout Settings",
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Initial Order", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_order",
							"width"             		=> 200,
							"value"             		=> array(
								__( 'Newest (Top) to Oldest (Bottom)', "ts_visual_composer_extend" )		=> "desc",
								__( 'Oldest (Top) to Newest (Bottom)', "ts_visual_composer_extend" )		=> "asc",
							),
							"admin_label"           	=> true,
							"description"       		=> __( "Select in which order the timeline events are arranged in Visual Composer.", "ts_visual_composer_extend" ),
							"group" 			        => "Layout Settings",
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
							"group" 			        => "Layout Settings",
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
							"dependency"            	=> array( 'element' => "timeline_lazy", 'value' => 'true' ),
							"group" 			        => "Layout Settings",
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
							"dependency"            	=> array( 'element' => "timeline_lazy", 'value' => 'true' ),
							"group" 			        => "Layout Settings",
						),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text for 'Load More' Button", "ts_visual_composer_extend" ),
                            "param_name"                => "timeline_load",
                            "value"                     => "Load More",
                            "description"               => __( "Enter a text to be shown inside the 'Load More' trigger button.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_lazy", 'value' => 'true' ),
							"group" 			        => "Layout Settings",
                        ),
						// Control Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_4",
							"value"						=> "",
                            "seperator"					=> "Sort Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Control Settings",
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
							"group" 			        => "Control Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "Label: Section Sorter", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_sort_label",
							"value"             		=> "Sort Timeline:",
							"description"       		=> __( "Enter the label text for the section sorter.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_sort", 'value' => 'true' ),
							"group" 			        => "Control Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "String: Ascending", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_sort_asc",
							"value"             		=> "Ascending",
							"description"       		=> __( "Enter the text string to be used inside the sorter to provide the option for an ascending direction.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_sort", 'value' => 'true' ),
							"group" 			        => "Control Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "String: Descending", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_sort_desc",
							"value"             		=> "Descending",
							"description"       		=> __( "Enter the text string to be used inside the sorter to provide the option for a descending direction.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_sort", 'value' => 'true' ),
							"group" 			        => "Control Settings",
						),
						// Filter Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_5",
							"value"						=> "",
                            "seperator"					=> "Filter Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Control Settings",
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
							"group" 			        => "Control Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "String: Selected", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_filter_selected",
							"value"             		=> "Selected",
							"description"       		=> __( "Enter the text string to be used inside the filters to highlight how many items are currently selected.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_filter_allow", 'value' => 'true' ),
							"group" 			        => "Control Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "String: Select All", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_filter_selectall",
							"value"             		=> "Selected",
							"description"       		=> __( "Enter the text string to be used inside the filters to provide an option to select all options at once.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_filter_allow", 'value' => 'true' ),
							"group" 			        => "Control Settings",
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
							"group" 			        => "Control Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "Label: Categories Filter", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_filter_labelcats",
							"value"             		=> "Filter By Categories:",
							"description"       		=> __( "Enter the label text for the categories filter.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_filter_cats", 'value' => 'true' ),
							"group" 			        => "Control Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "String: No Categories", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_filter_nocats",
							"value"             		=> "No Categories",
							"description"       		=> __( "Enter the text string to be used for sections without categories.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_filter_cats", 'value' => 'true' ),
							"group" 			        => "Control Settings",
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
							"group" 			        => "Control Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "Label: Tags Filter", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_filter_labeltags",
							"value"             		=> "Filter By Tags:",
							"description"       		=> __( "Enter the label text for the tags filter.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_filter_tags", 'value' => 'true' ),
							"group" 			        => "Control Settings",
						),
						array(
							"type"              		=> "textfield",
							"heading"           		=> __( "String: No Tags", "ts_visual_composer_extend" ),
							"param_name"        		=> "timeline_filter_notags",
							"value"             		=> "No Tags",
							"description"       		=> __( "Enter the text string to be used for sections without tags.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "timeline_filter_tags", 'value' => 'true' ),
							"group" 			        => "Control Settings",
						),
                        // Other Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_6",
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
                            "min"                       => "-50",
                            "max"                       => "500",
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
                            "min"                       => "-50",
                            "max"                       => "500",
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
// Register Container and Child Shortcode with Visual Composer
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_TS_VCSC_Posts_Timeline_Standalone extends WPBakeryShortCode {};
}
// Initialize "TS Posts Timeline" Class
if (class_exists('TS_PostsTimeline')) {
	$TS_PostsTimeline = new TS_PostsTimeline;
}