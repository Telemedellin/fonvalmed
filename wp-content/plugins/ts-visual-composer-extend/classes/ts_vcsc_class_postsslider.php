<?php
if (!class_exists('TS_Postslider')){
	class TS_Postslider {
		function __construct() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				add_action('init',                                  	array($this, 'TS_VCSC_Add_Posts_Slider_Elements'), 9999999);
			} else {
				add_action('admin_init',		                    	array($this, 'TS_VCSC_Add_Posts_Slider_Elements'), 9999999);
			}
            add_shortcode('TS_VCSC_Posts_Slider_Standalone',            array($this, 'TS_VCSC_Posts_Slider_Standalone'));
		}
        
        // Standalone Posts Slider
        function TS_VCSC_Posts_Slider_Standalone ($atts, $content = null) {
            global $VISUAL_COMPOSER_EXTENSIONS;
            ob_start();

			wp_enqueue_style('dashicons');
			wp_enqueue_style('ts-font-ecommerce');
			wp_enqueue_style('ts-font-teammates');
			wp_enqueue_style('ts-extend-animations');
            wp_enqueue_style('ts-visual-composer-extend-front');
            wp_enqueue_script('ts-visual-composer-extend-front');
            
            extract( shortcode_atts( array(
				'post_type'				=> 'post',
				'date_format'			=> 'F j, Y',
				'datetime_translate'	=> 'true',
				'time_format'			=> 'l, g:i A',
				
				'limit_posts'			=> 'true',
				'limit_by'				=> 'category',							// post_tag, cust_tax
				'limit_term'			=> '',
				
				'filter_menu'			=> 'true',
				'layout_menu'			=> 'true',
				'sort_menu'				=> 'false',
				'directions_menu'		=> 'false',
				
				'filter_by'				=> 'category', 							// post_tag, cust_tax
				
				'slider_type'			=> 'owlslider',
				'posts_slide'			=> 4,
                'auto_height'			=> 'false',
				'page_rtl'				=> 'false',
                'auto_play'				=> 'false',
				'show_playpause'		=> 'true',
                'show_bar'				=> 'false',
                'bar_color'				=> '#dd3333',
                'show_speed'			=> 5000,
                'stop_hover'			=> 'true',
                'show_navigation'		=> 'true',
				'show_dots'				=> 'true',
				'items_loop'			=> 'false',
				
				'flex_navigation'		=> 'true',
				'flex_animation'		=> 'slide',
				'flex_margin'			=> 10,
				'flex_breaks_single'	=> '240,480,720,960,1280,1600,1980',
				
				'animation_in'			=> 'ts-viewport-css-flipInX',
				'animation_out'			=> 'ts-viewport-css-slideOutDown',
				'animation_mobile'		=> 'false',
				
				'show_content'			=> 'excerpt',							// excerpt, cutcharacters, complete
				'cutoff_characters'		=> 400,
				'show_button'			=> 'true',
				'content_read'			=> 'Read Post',
				'content_target'		=> '_parent',
				
				'show_featured'			=> 'true',
				'show_share'			=> 'true',
				'show_categories'		=> 'true',
				'show_tags'				=> 'true',
				'show_metadata'			=> 'true',
				'show_avatar'			=> 'true',
				'show_editlinks'		=> 'true',
				
				'posts_limit'			=> 25,
				
                'margin_top'			=> 0,
                'margin_bottom'			=> 0,
                'el_id' 				=> '',
                'el_class'              => '',
				'css'					=> '',
            ), $atts ));
			
			$postslider_random			= mt_rand(999999, 9999999);
			$output						= '';
			
			// Check for Front End Editor
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$slider_class			= 'owl-carousel2-edit';
				$flex_class				= 'flex-carousel-edit';
				$slider_message			= '<div class="ts-composer-frontedit-message">' . __( 'The slider is currently viewed in front-end edit mode; slider features are disabled for performance and compatibility reasons.', "ts_visual_composer_extend" ) . '</div>';
				$product_style			= 'width: ' . (100 / $posts_slide) . '%; height: 100%; float: left; margin: 0; padding: 0;';
				$frontend_edit			= 'true';
				$description_style		= 'display: none;';
			} else {
				$slider_class			= 'ts-owlslider-parent owl-carousel2';
				$flex_class				= 'ts-flexslider-parent flex-carousel';
				$slider_message			= '';
				$product_style			= '';
				$frontend_edit			= 'false';
				$description_style		= 'display: none;';
			}
			
            if (!empty($el_id)) {
                $posts_container_id		= $el_id;
            } else {
                $posts_container_id		= 'ts-posts-slider-parent-' . $postslider_random;
            }
			
			$limit_term 				= str_replace(' ', '', $limit_term);

			if ($limit_by == 'category') {
				$limit_tax 				= 'category';
			} else if ($limit_by == 'post_tag') {
				$limit_tax 				= 'post_tag';
			} else if ($limit_by == 'cust_tax') {
				$limit_tax 				= '';
			}

			$filter_tax 				= '';
			
			// - set the taxonomy for the filter menu -
			if ($filter_by == 'category') {
				$menu_tax 				= 'category';
			} else if ($filter_by == 'post_tag') {
				$menu_tax 				= 'post_tag';
			} else if ($filter_by == 'cust_tax') {
				$menu_tax 				= $filter_tax; 
			}

			// Set the WP Query Arguments
			$args = array(
				'post_type' 			=> $post_type,
				'posts_per_page' 		=> '-1'
			);
			if ($limit_posts == 'true' && taxonomy_exists($limit_tax)) {
				$limited_terms 			= explode(',', $limit_term);
				$args['tax_query'] = array(
					array (
						'taxonomy' 		=> $limit_tax,
						'field' 		=> 'slug',
						'terms' 		=> $limited_terms,
						'operator' 		=> 'NOT IN'
					)
				);
			}
			$isoposts = new WP_Query($args);

			// Language Settings: Isotope Posts
			$TS_VCSC_Isotope_Posts_Language = get_option('ts_vcsc_extend_settings_translationsIsotopePosts', '');
			if (($TS_VCSC_Isotope_Posts_Language == false) || (empty($TS_VCSC_Isotope_Posts_Language))) {
				$TS_VCSC_Isotope_Posts_Language	= $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults;
			}
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Posts_Slider_Standalone', $atts);
			} else {
				$css_class	= '';
			}
			
			if ($frontend_edit == 'true') {
				echo '<div id="ts-isotope-posts-grid-frontend-' . $postslider_random . '" class="ts-isotope-posts-grid-frontend" style="border: 1px solid #ededed; padding: 10px;">';
					echo '<div style="font-weight: bold;">"TS Posts Slider"</div>';
					echo '<div style="margin-bottom: 20px;">The element has been disabled in order to ensure compatiblity with the Visual Composer Front-End Editor.</div>';
					echo '<div>' . __( "Exclude Categories", "ts_visual_composer_extend" ) . ': ' . $limit_posts . '</div>';
					if ($limit_posts == 'true') {
						echo '<div>' . __( "Excluded", "ts_visual_composer_extend" ) . ': ' . (empty($limit_term) ? __( 'None', "ts_visual_composer_extend" ) : $limit_term) . '</div>';
					}
					echo '<div>' . __( "Number of Posts", "ts_visual_composer_extend" ) . ': ' . $posts_limit . '</div>';
					echo '<div>' . __( "Max. Number of Posts per Slide", "ts_visual_composer_extend" ) . ': ' . $posts_slide . '</div>';
					$front_edit_reverse = array(
						"excerpt" 			=> __( 'Excerpt', "ts_visual_composer_extend" ),
						"cutcharacters" 	=> __( 'Character Limited Content', "ts_visual_composer_extend" ),
						"complete" 			=> __( 'Full Content', "ts_visual_composer_extend" ),
					);
					foreach($front_edit_reverse as $key => $value) {
						if ($key == $show_content) {
							echo '<div>' . __( "Content Length", "ts_visual_composer_extend" ) . ': ' . $value . '</div>';
						}
					};
					echo '<div>' . __( "Show 'Read Post' Button", "ts_visual_composer_extend" ) . ': ' . $show_button . '</div>';
					echo '<div>' . __( "Show Featured Image", "ts_visual_composer_extend" ) . ': ' . $show_featured . '</div>';
					echo '<div>' . __( "Show Share Buttons", "ts_visual_composer_extend" ) . ': ' . $show_share . '</div>';
					echo '<div>' . __( "Show Categories", "ts_visual_composer_extend" ) . ': ' . $show_categories . '</div>';
					echo '<div>' . __( "Show Tags", "ts_visual_composer_extend" ) . ': ' . $show_tags . '</div>';
					echo '<div>' . __( "Show Metadata", "ts_visual_composer_extend" ) . ': ' . $show_metadata . '</div>';
					echo '<div>' . __( "Show User Avatar", "ts_visual_composer_extend" ) . ': ' . $show_avatar . '</div>';
				echo '</div>';
			} else {
				if ($slider_type == "owlslider") {
					wp_enqueue_style('ts-extend-owlcarousel2');
					wp_enqueue_script('ts-extend-owlcarousel2');
					echo '<div id="' . $posts_container_id . '-container" class="ts-postsslider-slider-container" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
						// Add Progressbar
						if (($auto_play == "true") && ($show_bar == "true") && ($frontend_edit == "false")) {
							echo '<div id="ts-owlslider-progressbar-' . $postslider_random . '" class="ts-owlslider-progressbar-holder" style=""><div class="ts-owlslider-progressbar" style="background: ' . $bar_color . '; height: 100%; width: 0%;"></div></div>';
						}
						// Add Navigation Controls
						if ($frontend_edit == "false") {
							echo '<div id="ts-owlslider-controls-' . $postslider_random . '" class="ts-owlslider-controls" style="' . (((($auto_play == "true") && ($show_playpause == "true")) || ($show_navigation == "true")) ? "display: block;" : "display: none;") . '">';
								echo '<div id="ts-owlslider-controls-next-' . $postslider_random . '" style="' . (($show_navigation == "true") ? "display: block;" : "display: none;") . '" class="ts-owlslider-controls-next"><span class="ts-ecommerce-arrowright5"></span></div>';
								echo '<div id="ts-owlslider-controls-prev-' . $postslider_random . '" style="' . (($show_navigation == "true") ? "display: block;" : "display: none;") . '" class="ts-owlslider-controls-prev"><span class="ts-ecommerce-arrowleft5"></span></div>';
								if (($auto_play == "true") && ($show_playpause == "true")) {
									echo '<div id="ts-owlslider-controls-play-' . $postslider_random . '" class="ts-owlslider-controls-play active" style="' . (($show_playpause == "true") ? "display: block;" : "display: none;") . '"><span class="ts-ecommerce-pause"></span></div>';
								}
							echo '</div>';
						}					
						// Add Slider
						echo '<div id="' . $posts_container_id . '" class="ts-posts-slider-parent ts-postsslider ts-posts-owlslider ' . $slider_class . ' ' . $css_class . '" data-id="' . $postslider_random . '" data-items="' . $posts_slide . '" data-rtl="' . $page_rtl . '" data-loop="' . $items_loop . '" data-navigation="' . $show_navigation . '" data-dots="' . $show_dots . '" data-mobile="' . $animation_mobile . '" data-animationin="' . $animation_in . '" data-animationout="' . $animation_out . '" data-height="' . $auto_height . '" data-play="' . $auto_play . '" data-bar="' . $show_bar . '" data-color="' . $bar_color . '" data-speed="' . $show_speed . '" data-hover="' . $stop_hover . '">';
							// Create Individual Post Output
							$postCounter 	= 0;
							$postMonths 	= array();
							if (post_type_exists($post_type) && $isoposts->have_posts()) {
									while ($isoposts->have_posts() ) :
										$isoposts->the_post();
										$matched_terms				= 0;
										/*if ($limit_posts == 'true') {
											$limited_terms 			= explode(',', $limit_term);
											$present_terms			= get_the_category();
											foreach ($present_terms as $category) {
												if (in_array(trim($category->slug), $limited_terms)) {
													$matched_terms++;
												}
											}
										}*/
										if ($matched_terms == 0) {
											$postCounter++;
											if ($postCounter < $posts_limit + 1) {
												$postAttributes = 'data-visible="false" data-full="' . get_post_time($date_format) . '" data-author="' . get_the_author() . '" data-date="' . get_post_time('U') . '" data-modified="' . get_the_modified_time('U') . '" data-title="' . get_the_title() . '" data-comments="' . get_comments_number() . '" data-id="' .  get_the_ID() . '"';
											?>
											<div class="ts-postsslider-slide">
												<div class="ts-timeline-list-item ts-timeline-date-true ts-isotope-posts-list-item <?php if ($filter_menu == 'true' && taxonomy_exists($menu_tax)) {foreach(get_the_terms($isoposts->post->ID, $menu_tax) as $term) echo $term->slug.' ';} ?>" <?php echo $postAttributes; ?>>
													<div class="ts-timeline-column">
														<div class="ts-timeline-text-wrap ts-timeline-text-wrap-date" style="position: relative;">
															<?php
																// Post Date
																echo '<div class="ts-timeline-date"><span class="ts-timeline-date-connect"><span class="ts-timeline-date-text">';
																	echo get_post_time($date_format, false, null, ($datetime_translate == "true" ? true : false));
																echo '</span></span></div>';
																// Post Thumbnail
																if ($show_featured == "true") {
																	if ((strlen(get_the_post_thumbnail()) > 0) && (strlen(get_post_thumbnail_id()) > 0)) {
																		$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
																		<div class="ts-isotope-posts-thumb">
																			<a href="<?php the_permalink() ?>"><img src="<?php echo $thumbnail[0]; ?>"></a>
																		</div>
																	<?php }
																}
															?>
															<h2 class="ts-isotope-posts-title" data-title="<?php the_title(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
															<div class="ts-isotope-posts-excerpt">
																<?php
																	if ($show_content == "excerpt") {
																		the_excerpt();
																	} else if ($show_content == "cutcharacters") {
																		$content = apply_filters('the_content', get_the_content());
																		$excerpt = TS_VCSC_TruncateHTML($content, $cutoff_characters, '...', false, true);
																		echo $excerpt;
																	} else if ($show_content == "complete") {
																		the_content();
																	}
																	if ($show_button == 'true') {
																		echo '<a class="ts-isotope-posts-connect" href="' . get_permalink() . '" target="' . $content_target . '">' . $content_read . '</a>';
																	}
																?>
															</div>
															<?php
																if ($show_share == 'true') {
																	$postTitle = get_the_title();
																	echo '<div class="ts-isotope-posts-social">';
																		echo '<a href="http://pinterest.com/pin/create/link/?url=' . get_permalink() . '&amp;description=' . $postTitle . '" class="ts-isotope-posts-social-holder" rel="external" target="_blank"><span class="ts-isotope-posts-social-pinterest"></span></a>';
																		echo '<a href="https://plusone.google.com/_/+1/confirm?hl=en&amp;url=' . get_permalink() . '&amp;name=' . $postTitle . '" class="ts-isotope-posts-social-holder" rel="external" target="_blank"><span class="ts-isotope-posts-social-google"></span></a>';
																		echo '<a href="http://twitter.com/share?text=' . $postTitle . '&url=' . get_permalink() . '" class="ts-isotope-posts-social-holder" rel="external" target="_blank"><span class="ts-isotope-posts-social-twitter"></span></a>';
																		echo '<a href="http://www.facebook.com/sharer.php?u=' . get_permalink() . '" class="ts-isotope-posts-social-holder" rel="external" target="_blank"><span class="ts-isotope-posts-social-facebook"></span></a>';
																	echo '</div>';
																}
															?>
															<?php if (($show_categories == 'true') || ($show_tags == 'true')) {
																echo '<div class="ts-isotope-posts-metadata clearFixMe">';
																	// Post Categories
																	if ($show_categories == 'true') { ?>
																		<div class="ts-isotope-posts-taxonomies">
																			<?php
																				$categories 	= get_the_category();
																				$separator 		= ' / ';
																				$output 		= '';
																				if ($categories){
																					echo '<span class="ts-isotope-posts-taxonomies-title">' . $TS_VCSC_Isotope_Posts_Language['Categories'] . '<br/></span>';
																					foreach($categories as $category) {
																						$output .= '<a href="' . get_category_link($category->term_id) . '" class="ts-isotope-posts-categories" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>' . $separator;
																					}
																					echo trim($output, $separator);
																				}
																			?>
																		</div>
																	<?php }
																	// Post Tags
																	if ($show_tags == 'true') { ?>
																		<div class="ts-isotope-posts-keywords">
																			<?php
																				$posttags 		= get_the_tags();
																				$separator 		= ' / ';
																				$output 		= '';
																				if ($posttags) {
																					echo '<span class="ts-isotope-posts-keywords-title">' . $TS_VCSC_Isotope_Posts_Language['Tags'] . '<br/></span>';
																					foreach($posttags as $tag) {
																						$output .= '<a href="' . get_tag_link($tag->term_id) . '" class="ts-isotope-posts-tags" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $tag->name ) ) . '">'.$tag->name.'</a>' . $separator;
																					}
																					echo trim($output, $separator);
																				}
																			?>
																		</div>
																	<?php } ?>
																</div>
															<?php }
															// Post Time / Author / Type / Comments
															if ($show_metadata == 'true') { ?>
																<div class="ts-isotope-posts-metadata clearFixMe">
																	<?php
																		if ($show_avatar == 'true') {
																			//echo '<div class="ts-isotope-posts-avatar">';
																				echo get_avatar(get_the_author_meta('ID'), $size = '40');
																			//echo '</div>';
																		}
																	?>
																	<div class="ts-isotope-posts-author">
																		<?php echo get_the_author(); ?>
																	</div>
																	<?php
																		$format = get_post_format();
																		if (false === $format) {
																			$format 	= __( 'Standard', "ts_visual_composer_extend" );
																			$class 		= 'standard';
																		} else {
																			$class		= strtolower($format);
																		}
																		echo '<div class="ts-isotope-posts-type ts-isotope-posts-type-' . $class . '">';
																			echo ucfirst($format);
																		echo '</div><br/>';
																	?>
																	<div class="ts-isotope-posts-time">
																		<?php echo get_post_time($time_format, false, null, ($datetime_translate == "true" ? true : false)); ?>
																	</div>
																	<div class="ts-isotope-posts-comments">
																		<?php echo get_comments_number(); ?>
																	</div>
																</div>
															<?php }
															// Edit Links
															if (($show_editlinks == 'true') && (is_admin_bar_showing())) {
																echo '<div class="ts-isotope-posts-editlinks clearFixMe">';
																	echo '<span class="ts-isotope-posts-edit"></span>';
																	echo '<span class="ts-isotope-posts-links">';
																		echo edit_post_link();
																	echo '</span>';
																echo '</div>';
															} ?>
														</div>
													</div>
												</div>
											</div>
										<?php }
									} endwhile; ?>
								<?php
								wp_reset_postdata();
							} else {
								echo '<p>Nothing found. Please check back soon!</p>';
							}
						echo '</div>';
					echo '</div>';
				}
				if ($slider_type == "flexslider") {
					wp_enqueue_style('ts-extend-flexslider2');
					wp_enqueue_script('ts-extend-flexslider2');
					if ($flex_animation == "fade") {
						$posts_slide 			= 1;
						$flex_margin 			= 0;
					}
					echo '<div id="' . $posts_container_id . '-container" class="ts-flexslider-container ts-posts-flexslider-container clearFixMe" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;" data-main="ts-posts-flexslider-main-' . $postslider_random . '" data-frontend="' . $frontend_edit . '" data-id="' . $postslider_random . '" data-count="" data-combo="false" data-thumbs="" data-images="" data-margin="' . $flex_margin . '" data-rtl="' . $page_rtl . '" data-navigation="' . $flex_navigation . '" data-animation="' . $flex_animation . '" data-play="' . $auto_play . '" data-bar="' . $show_bar . '" data-color="' . $bar_color . '" data-speed="' . $show_speed . '" data-hover="' . $stop_hover . '">';
						// Add Progressbar
						if (($auto_play == "true") && ($show_bar == "true") && ($frontend_edit == "false")) {
							echo '<div id="ts-flexslider-progressbar-container-' . $postslider_random . '" class="ts-flexslider-progressbar-container" style="width: 100%; height: 100%; background: #ededed;"><div id="ts-flexslider-progressbar-' . $postslider_random . '" class="ts-flexslider-progressbar" style="background: ' . $bar_color . '; height: 10px;"></div></div>';
						}
						// Add Slider (Main)
						echo '<div id="ts-posts-flexslider-main-' . $postslider_random . '" class="' . $flex_class . ' ts-postsslider ts-posts-flexslider ts-posts-flexslider-main" data-id="' . $postslider_random . '" data-breaks="' . $flex_breaks_single . '">';
							echo '<ul class="slides">';
								// Create Individual Post Output
								$postCounter 	= 0;
								$postMonths 	= array();
								if (post_type_exists($post_type) && $isoposts->have_posts()) {
										while ($isoposts->have_posts() ) :
											$isoposts->the_post();
											$matched_terms				= 0;
											/*if ($limit_posts == 'true') {
												$limited_terms 			= explode(',', $limit_term);
												$present_terms			= get_the_category();
												foreach ($present_terms as $category) {
													if (in_array(trim($category->slug), $limited_terms)) {
														$matched_terms++;
													}
												}
											}*/
											if ($matched_terms == 0) {
												$postCounter++;
												if ($postCounter < $posts_limit + 1) {
													$postAttributes = 'data-visible="false" data-full="' . get_post_time($date_format) . '" data-author="' . get_the_author() . '" data-date="' . get_post_time('U') . '" data-modified="' . get_the_modified_time('U') . '" data-title="' . get_the_title() . '" data-comments="' . get_comments_number() . '" data-id="' .  get_the_ID() . '"';
												?>
												<li class="ts-postsslider-slide" style="margin: 0px <?php echo ((($posts_slide == 1) || ($page_rtl == "true")) ? 0 : $flex_margin); ?>px 0px <?php echo ((($posts_slide == 1) || ($page_rtl == "false")) ? 0 : $flex_margin); ?>px;" data-counter="<?php echo $postCounter; ?>">
													<div class="ts-timeline-list-item ts-timeline-date-true ts-isotope-posts-list-item <?php if ($filter_menu == 'true' && taxonomy_exists($menu_tax)) {foreach(get_the_terms($isoposts->post->ID, $menu_tax) as $term) echo $term->slug.' ';} ?>" <?php echo $postAttributes; ?>>
														<div class="ts-timeline-column">
															<div class="ts-timeline-text-wrap ts-timeline-text-wrap-date" style="position: relative;">
																<?php
																	// Post Date
																	echo '<div class="ts-timeline-date"><span class="ts-timeline-date-connect"><span class="ts-timeline-date-text">';
																		echo get_post_time($date_format, false, null, ($datetime_translate == "true" ? true : false));
																	echo '</span></span></div>';
																	// Post Thumbnail
																	if ($show_featured == "true") {
																		if ('' != get_the_post_thumbnail()) { 
																			$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
																			<div class="ts-isotope-posts-thumb">
																				<a href="<?php the_permalink() ?>"><img src="<?php echo $thumbnail[0]; ?>"></a>
																			</div>
																		<?php }
																	}
																?>
																<h2 class="ts-isotope-posts-title" data-title="<?php the_title(); ?>"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
																<div class="ts-isotope-posts-excerpt">
																	<?php
																		if ($show_content == "excerpt") {
																			the_excerpt();
																		} else if ($show_content == "cutcharacters") {
																			$content = apply_filters('the_content', get_the_content());
																			$excerpt = TS_VCSC_TruncateHTML($content, $cutoff_characters, '...', false, true);
																			echo $excerpt;
																		} else if ($show_content == "complete") {
																			the_content();
																		}
																		if ($show_button == 'true') {
																			echo '<a class="ts-isotope-posts-connect" href="' . get_permalink() . '" target="' . $content_target . '">' . $content_read . '</a>';
																		}
																	?>
																</div>
																<?php
																	if ($show_share == 'true') {
																		$postTitle = get_the_title();
																		echo '<div class="ts-isotope-posts-social">';
																			echo '<a href="http://pinterest.com/pin/create/link/?url=' . get_permalink() . '&amp;description=' . $postTitle . '" class="ts-isotope-posts-social-holder" rel="external" target="_blank"><span class="ts-isotope-posts-social-pinterest"></span></a>';
																			echo '<a href="https://plusone.google.com/_/+1/confirm?hl=en&amp;url=' . get_permalink() . '&amp;name=' . $postTitle . '" class="ts-isotope-posts-social-holder" rel="external" target="_blank"><span class="ts-isotope-posts-social-google"></span></a>';
																			echo '<a href="http://twitter.com/share?text=' . $postTitle . '&url=' . get_permalink() . '" class="ts-isotope-posts-social-holder" rel="external" target="_blank"><span class="ts-isotope-posts-social-twitter"></span></a>';
																			echo '<a href="http://www.facebook.com/sharer.php?u=' . get_permalink() . '" class="ts-isotope-posts-social-holder" rel="external" target="_blank"><span class="ts-isotope-posts-social-facebook"></span></a>';
																		echo '</div>';
																	}
																?>
																<?php if (($show_categories == 'true') || ($show_tags == 'true')) {
																	echo '<div class="ts-isotope-posts-metadata clearFixMe">';
																		// Post Categories
																		if ($show_categories == 'true') { ?>
																			<div class="ts-isotope-posts-taxonomies">
																				<?php
																					$categories 	= get_the_category();
																					$separator 		= ' / ';
																					$output 		= '';
																					if ($categories){
																						echo '<span class="ts-isotope-posts-taxonomies-title">' . $TS_VCSC_Isotope_Posts_Language['Categories'] . '<br/></span>';
																						foreach($categories as $category) {
																							$output .= '<a href="' . get_category_link($category->term_id) . '" class="ts-isotope-posts-categories" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>' . $separator;
																						}
																						echo trim($output, $separator);
																					}
																				?>
																			</div>
																		<?php }
																		// Post Tags
																		if ($show_tags == 'true') { ?>
																			<div class="ts-isotope-posts-keywords">
																				<?php
																					$posttags 		= get_the_tags();
																					$separator 		= ' / ';
																					$output 		= '';
																					if ($posttags) {
																						echo '<span class="ts-isotope-posts-keywords-title">' . $TS_VCSC_Isotope_Posts_Language['Tags'] . '<br/></span>';
																						foreach($posttags as $tag) {
																							$output .= '<a href="' . get_tag_link($tag->term_id) . '" class="ts-isotope-posts-tags" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $tag->name ) ) . '">'.$tag->name.'</a>' . $separator;
																						}
																						echo trim($output, $separator);
																					}
																				?>
																			</div>
																		<?php } ?>
																	</div>
																<?php }
																// Post Time / Author / Type / Comments
																if ($show_metadata == 'true') { ?>
																	<div class="ts-isotope-posts-metadata clearFixMe">
																		<?php
																			if ($show_avatar == 'true') {
																				//echo '<div class="ts-isotope-posts-avatar">';
																					echo get_avatar(get_the_author_meta('ID'), $size = '40');
																				//echo '</div>';
																			}
																		?>
																		<div class="ts-isotope-posts-author">
																			<?php echo get_the_author(); ?>
																		</div>
																		<?php
																			$format = get_post_format();
																			if (false === $format) {
																				$format 	= __( 'Standard', "ts_visual_composer_extend" );
																				$class 		= 'standard';
																			} else {
																				$class		= strtolower($format);
																			}
																			echo '<div class="ts-isotope-posts-type ts-isotope-posts-type-' . $class . '">';
																				echo ucfirst($format);
																			echo '</div><br/>';
																		?>
																		<div class="ts-isotope-posts-time">
																			<?php echo get_post_time($time_format, false, null, ($datetime_translate == "true" ? true : false)); ?>
																		</div>
																		<div class="ts-isotope-posts-comments">
																			<?php echo get_comments_number(); ?>
																		</div>
																	</div>
																<?php }
																// Edit Links
																if (($show_editlinks == 'true') && (is_admin_bar_showing())) {
																	echo '<div class="ts-isotope-posts-editlinks clearFixMe">';
																		echo '<span class="ts-isotope-posts-edit"></span>';
																		echo '<span class="ts-isotope-posts-links">';
																			echo edit_post_link();
																		echo '</span>';
																	echo '</div>';
																} ?>
															</div>
														</div>
													</div>
												</li>
											<?php }
										} endwhile; ?>
									<?php
									wp_reset_postdata();
								} else {
									echo '<p>Nothing found. Please check back soon!</p>';
								}
							echo '</ul>';
							// Add Play/Pause Control
							if (($auto_play == "true") && ($show_playpause == "true")) {
								echo '<div id="ts-flexslider-controls-' . $postslider_random . '" class="ts-flexslider-controls" style="display: none;">';
									echo '<div id="ts-flexslider-controls-play-' . $postslider_random . '" class="ts-flexslider-controls-play active"><span class="ts-ecommerce-pause"></span></div>';
								echo '</div>';
							}
						echo '</div>';
					echo '</div>';
				}
			}
            $myvariable = ob_get_clean();
            return $myvariable;
        }
    
        // Add Posts Slider Elements
        function TS_VCSC_Add_Posts_Slider_Elements() {
            global $VISUAL_COMPOSER_EXTENSIONS;
            // Add Standalone Posts Slider
            if (function_exists('vc_map')) {
                vc_map( array(
                    "name"                              => __( "TS Posts Slider", "ts_visual_composer_extend" ),
                    "base"                              => "TS_VCSC_Posts_Slider_Standalone",
                    "icon" 	                            => "icon-wpb-ts_vcsc_posts_slider",
					"class"                     		=> "ts_vcsc_main_posts_slider",
                    "category"                          => __( 'VC Extensions', "ts_visual_composer_extend" ),
                    "description"                       => __("Place an Posts Slider element", "ts_visual_composer_extend"),
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
                    "params"                            => array(
                        // Isotope Posts Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_1",
							"value"						=> "",
                            "seperator"					=> "Content Settings",
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
                            "max"                       => "100",
                            "step"                      => "1",
                            "unit"                      => '',
							"admin_label"		        => true,
                            "description"               => __( "Select the total number of posts to be retrieved from WordPress.", "ts_visual_composer_extend" ),
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Content Length", "ts_visual_composer_extend" ),
							"param_name"        		=> "show_content",
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
                            "param_name"                => "cutoff_characters",
                            "value"                     => "400",
                            "min"                       => "100",
                            "max"                       => "1200",
                            "step"                      => "1",
                            "unit"                      => '',
                            "description"               => __( "Select the number of characters to which the post content should be limited to.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "show_content", "value" 	=> "cutcharacters")
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show 'Read Post' Button", "ts_visual_composer_extend" ),
                            "param_name"                => "show_button",
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
							"param_name"        		=> "content_target",
							"value"             		=> array(
								__( "Same Window", "ts_visual_composer_extend" )                    => "_parent",
								__( "New Window", "ts_visual_composer_extend" )                     => "_blank"
							),
							"description"       		=> __( "Define how the link should be opened.", "ts_visual_composer_extend" ),
							"dependency"        		=> array("element" 	=> "show_button", "value" 	=> "true"),
						),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "'Read Post' Text", "ts_visual_composer_extend" ),
                            "param_name"                => "content_read",
                            "value"                     => "Read Post",
                            "description"               => __( "Enter the text to be shown in the 'Read Post' Link.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "show_button", "value" 	=> "true"),
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
                        // Layout Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_2",
							"value"						=> "",
                            "seperator"					=> "Layout Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Layout Settings",
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
                            "group" 			        => "Layout Settings",
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
                            "group" 			        => "Layout Settings",
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
                            "group" 			        => "Layout Settings",
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
                            "group" 			        => "Layout Settings",
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
                            "group" 			        => "Layout Settings",
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
                            "group" 			        => "Layout Settings",
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
                            "group" 			        => "Layout Settings",
                        ),
						// Slider Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_3",
							"value"						=> "",
                            "seperator"					=> "Slider Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Slider Settings",
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Slider Type", "ts_visual_composer_extend" ),
							"param_name"        		=> "slider_type",
							"width"             		=> 200,
							"value"             		=> array(
								__( 'Owl Slider', "ts_visual_composer_extend" )						=> "owlslider",
								__( 'Flex Slider', "ts_visual_composer_extend" )					=> "flexslider",
							),
							"admin_label"		        => true,
							"description"       		=> __( "Select which type of slider should be used to display the posts.", "ts_visual_composer_extend" ),
							"dependency" 				=> "",
                            "group" 			        => "Slider Settings",
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Max. Number of Posts per Slide", "ts_visual_composer_extend" ),
							"param_name"                => "posts_slide",
							"value"                     => "4",
							"min"                       => "1",
							"max"                       => "6",
							"step"                      => "1",
							"unit"                      => '',
							"description"               => __( "Define the maximum number of posts per slide.", "ts_visual_composer_extend" ),
							"dependency" 				=> "",
                            "group" 			        => "Slider Settings",
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
							"dependency" 				=> array("element" 	=> "slider_type", "value" 	=> "owlslider"),
                            "group" 			        => "Slider Settings",
						),
						array(
							"type"                      => "hidden_input",
							"heading"                   => __( "In-Animation Type", "ts_visual_composer_extend" ),
							"param_name"                => "css3animations_in",
							"value"                     => "",
							"admin_label"		        => true,
							"description"               => __( "", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "slider_type", "value" 	=> "owlslider"),
                            "group" 			        => "Slider Settings",
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
							"dependency" 				=> array("element" 	=> "slider_type", "value" 	=> "owlslider"),
                            "group" 			        => "Slider Settings",
						),
						array(
							"type"                      => "hidden_input",
							"heading"                   => __( "Out-Animation Type", "ts_visual_composer_extend" ),
							"param_name"                => "css3animations_out",
							"value"                     => "",
							"admin_label"		        => true,
							"description"               => __( "", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "slider_type", "value" 	=> "owlslider"),
                            "group" 			        => "Slider Settings",
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
                            "dependency" 				=> array("element" 	=> "slider_type", "value" 	=> "owlslider"),
                            "group" 			        => "Slider Settings",
                        ),
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Animation Type", "ts_visual_composer_extend" ),
							"param_name"            	=> "flex_animation",
							"width"                 	=> 150,
							"value"                 	=> array(
								__( 'Slide', "ts_visual_composer_extend" )				=> "slide",
								__( 'Fade', "ts_visual_composer_extend" )				=> "fade",
							),
							"description"           	=> __( "Select how the Flexslider should animate between the slides. A 'Fade' transition will set the slider to one item per slide.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "slider_type", "value" 	=> "flexslider"),
                            "group" 			        => "Slider Settings",
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
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want the slider to auto-adjust its height.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                            "group" 			        => "Slider Settings",
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
                            "dependency"                => "",
                            "group" 			        => "Slider Settings",
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
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to auto-play the slider on page load.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                            "group" 			        => "Slider Settings",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Play / Pause", "ts_visual_composer_extend" ),
                            "param_name"                => "show_playpause",
                            "value"                     => "false",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show a play / pause button to control the autoplay.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "auto_play", "value" => "true"),
                            "group" 			        => "Slider Settings",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Progressbar", "ts_visual_composer_extend" ),
                            "param_name"                => "show_bar",
                            "value"                     => "false",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show a progressbar during auto-play.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "auto_play", "value" 	=> "true"),
                            "group" 			        => "Slider Settings",
                        ),
                        array(
                            "type"                      => "colorpicker",
                            "heading"                   => __( "Progressbar Color", "ts_visual_composer_extend" ),
                            "param_name"                => "bar_color",
                            "value"                     => "#dd3333",
                            "description"               => __( "Define the color of the animated progressbar.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "show_bar", "value" 	=> "true"),
                            "group" 			        => "Slider Settings",
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
                            "group" 			        => "Slider Settings",
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
                            "description"               => __( "Switch the toggle if you want to stop the auto-play while hovering over the slider.", "ts_visual_composer_extend" ),
                            "dependency"                => array( 'element' => "auto_play", 'value' => 'true' ),
                            "group" 			        => "Slider Settings",
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
                            "dependency" 				=> array("element" 	=> "slider_type", "value" 	=> "owlslider"),
                            "group" 			        => "Slider Settings",
                        ),
						array(
							"type"              	    => "switch_button",
							"heading"                   => __( "Show Dot Navigation", "ts_visual_composer_extend" ),
							"param_name"                => "show_dots",
							"value"                     => "true",
							"on"					    => __( 'Yes', "ts_visual_composer_extend" ),
							"off"					    => __( 'No', "ts_visual_composer_extend" ),
							"style"					    => "select",
							"design"				    => "toggle-light",
							"description"               => __( "Switch the toggle if you want to show dot navigation buttons below the slider.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "slider_type", "value" 	=> "owlslider"),
                            "group" 			        => "Slider Settings",
						),
						array(
							"type"						=> "switch_button",
							"heading"					=> __( "Show Navigation", "ts_visual_composer_extend" ),
							"param_name"				=> "flex_navigation",
							"value"						=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"				=> __( "Switch the toggle if you want to show dot navigation buttons below the slider.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "slider_type", "value" 	=> "flexslider"),
                            "group" 			        => "Slider Settings",
						),
                        // Other Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_4",
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
                            "param_name"                => "el_file1",
                            "value"                     => "",
                            "file_type"                 => "js",
							"file_id"         			=> "ts-extend-element",
                            "file_path"                 => "js/ts-visual-composer-extend-element.min.js",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
						array(
							"type"              		=> "load_file",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "el_file2",
							"value"             		=> "Animation Files",
							"file_type"         		=> "css",
							"file_id"         			=> "ts-extend-animations",
							"file_path"         		=> "css/ts-visual-composer-extend-animations.min.css",
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),
                    ))
                );
            }
        }
	}
}
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_TS_VCSC_Posts_Slider_Standalone extends WPBakeryShortCode {};
}

// Initialize "TS Postslider" Class
if (class_exists('TS_Postslider')) {
	$TS_Postslider = new TS_Postslider;
}