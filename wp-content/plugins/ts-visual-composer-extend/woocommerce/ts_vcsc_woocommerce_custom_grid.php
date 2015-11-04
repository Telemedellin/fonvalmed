<?php
if (!class_exists('TS_WooCommerce_Grid_Basic')){
	class TS_WooCommerce_Grid_Basic {
		function __construct() {
			global $VISUAL_COMPOSER_EXTENSIONS;
            if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
                add_action('init',                                  	array($this, 'TS_VCSC_WooCommerce_Grid_Basic_Elements'), 9999999);
            } else {
                add_action('admin_init',		                    	array($this, 'TS_VCSC_WooCommerce_Grid_Basic_Elements'), 9999999);
            }
            add_shortcode('TS_VCSC_WooCommerce_Grid_Basic',				array($this, 'TS_VCSC_WooCommerce_Grid_Basic_Function'));
		}
		
		// Load Isotope Customization at Page End
		function TS_VCSC_WooCommerce_Grid_Function_Isotope () {
			echo '<script data-cfasync="false" type="text/javascript" src="' . TS_VCSC_GetResourceURL('js/jquery.vcsc.isotope.custom.min.js') . '"></script>';
		}
        
        // Standalone Products Grid
        function TS_VCSC_WooCommerce_Grid_Basic_Function ($atts, $content = null) {
            global $VISUAL_COMPOSER_EXTENSIONS;
			global $product;
			global $woocommerce;
            ob_start();

			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndForcable == "false") {
					wp_enqueue_style('ts-visual-composer-extend-front');
				}
			} else {
				wp_enqueue_script('ts-extend-hammer');
				wp_enqueue_script('ts-extend-nacho');
				wp_enqueue_style('ts-extend-nacho');
				wp_enqueue_style('ts-extend-dropdown');
				wp_enqueue_script('ts-extend-dropdown');					
				wp_enqueue_style('ts-font-ecommerce');
				wp_enqueue_style('ts-extend-animations');
				wp_enqueue_style('dashicons');
				wp_enqueue_style('ts-extend-buttons');
				wp_enqueue_style('ts-visual-composer-extend-front');
				wp_enqueue_script('ts-extend-isotope');
				wp_enqueue_script('ts-visual-composer-extend-front');
				add_action('wp_footer', 											array($this, 'TS_VCSC_WooCommerce_Grid_Function_Isotope'), 9999);
			}
            
            extract( shortcode_atts( array(
				'selection'						=> 'recent_products',
				'category'						=> '',
				'ids'							=> '',
				'orderby'						=> 'date',
				'order'							=> 'desc',
				'products_total'				=> 12,
				'exclude_outofstock'			=> 'false',
				
				'show_image'					=> 'true',
				'show_link'						=> 'true',
				'link_page'						=> 'false',
				'link_target'					=> '_parent',
				'show_rating'					=> 'true',
				'show_stock'					=> 'true',
				'show_price'					=> 'true',
				'show_cart'						=> 'true',
				'show_info'						=> 'true',
				'show_content'					=> 'excerpt',
				'cutoff_characters'				=> 400,
				
				'lightbox_group_name'			=> 'nachogroup',
				'lightbox_size'					=> 'full',
				'lightbox_effect'				=> 'random',
				'lightbox_speed'				=> 5000,
				'lightbox_social'				=> 'true',
				'lightbox_backlight_choice'		=> 'predefined',
				'lightbox_backlight_color'		=> '#0084E2',
				'lightbox_backlight_custom'		=> '#000000',
				
				'image_position'				=> 'ts-imagefloat-center',
				'hover_type'           			=> 'ts-imagehover-style1',
				'hover_active'					=> 'false',
				'overlay_trigger'				=> 'ts-trigger-hover',
				
				// Rating Settings
				'rating_maximum'				=> 5,
				'rating_value'					=> 0,
				'rating_dynamic'				=> '',
				'rating_quarter'				=> 'true',
				'rating_size'					=> 16,
				'rating_auto'					=> 'false',
				'rating_rtl'					=> 'false',
				'rating_symbol'					=> 'other',
				'rating_icon'					=> 'ts-ecommerce-starfull1',
				'color_rated'					=> '#FFD800',
				'color_empty'					=> '#e3e3e3',
				'caption_show'					=> 'false',
				'caption_position'				=> 'left',
				'caption_digits'				=> '.',
				'caption_danger'				=> '#d9534f',
				'caption_warning'				=> '#f0ad4e',
				'caption_info'					=> '#5bc0de',
				'caption_primary'				=> '#428bca',
				'caption_success'				=> '#5cb85c',
				
				'post_type'						=> 'product',
				'date_format'					=> 'F j, Y',
				'time_format'					=> 'l, g:i A',
				
				'filter_menu'					=> 'true',
				'layout_menu'					=> 'true',
				'sort_menu'						=> 'false',
				'directions_menu'				=> 'false',
				
				'filter_by'						=> 'product_cat', 						// post_tag, cust_tax
				
				'layout'						=> 'masonry',							// spineTimeline, masonry, fitRows, straightDown
				'column_width'					=> 285,
				'layout_break'					=> 600,
				'show_periods'					=> 'false',
				'sort_by'						=> 'postName',							// name, postDate
				'sort_order'					=> 'asc',
				
				'posts_limit'					=> 25,
				'posts_lazy'					=> 'false',
				'posts_ajax'					=> 10,
				'posts_load'					=> 'Show More',
				'posts_trigger'					=> 'click',
				
                'margin_top'					=> 0,
                'margin_bottom'					=> 0,
                'el_id' 						=> '',
                'el_class'              		=> '',
				'css'							=> '',
            ), $atts ));
			
			$postsgrid_random					= mt_rand(999999, 9999999);
			$opening = $closing = $controls = $products	= '';
			
			$posts_limit						= $products_total;
			
            if (!empty($el_id)) {
                $posts_container_id				= $el_id;
            } else {
                $posts_container_id				= 'ts-vcsc-woocommerce-grid-' . $postsgrid_random;
            }
			
			// Backlight Color
			if ($lightbox_backlight_choice == "predefined") {
				$lightbox_backlight_selection	= $lightbox_backlight_color;
			} else {
				$lightbox_backlight_selection	= $lightbox_backlight_custom;
			}
			
			// Check for Front End Editor
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$product_style					= '';
				$frontend_edit					= 'true';
				$description_style				= 'display: none; padding: 15px;';
			} else {
				$product_style					= '';
				$frontend_edit					= 'false';
				$description_style				= 'display: none; padding: 15px;';
			}
			
			$meta_query 						= '';
			// Recent Products
			if ($selection == "recent_products"){
				$meta_query 					= WC()->query->get_meta_query();
			}
			// Featured Products
			if ($selection == "featured_products"){
				$meta_query = array(
					array(
						'key' 					=> '_visibility',
						'value' 	  			=> array('catalog', 'visible'),
						'compare'				=> 'IN'
					),
					array(
						'key' 					=> '_featured',
						'value' 	  			=> 'yes'
					)
				);
			}
			// Top Rated Products
			if ($selection == "top_rated_products"){
				add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
				$meta_query = WC()->query->get_meta_query();
			}
			
			// Final Query Arguments
			$args = array(
				'post_type'						=> 'product',
				'post_status'		  			=> 'publish',
				'ignore_sticky_posts'  			=> 1,
				'posts_per_page' 	   			=> $products_total,
				'orderby' 			  			=> $orderby,
				'order' 						=> $order,
				'paged' 						=> 1,
				'meta_query' 		   			=> $meta_query
			);
			
			// Products on Sale
			if ($selection == "sale_products") {
				$product_ids_on_sale 			= woocommerce_get_product_ids_on_sale();
				$meta_query 					= array();
				$meta_query[] 					= $woocommerce->query->visibility_meta_query();
				$meta_query[] 					= $woocommerce->query->stock_status_meta_query();
				$args['meta_query'] 			= $meta_query;
				$args['post__in'] 				= $product_ids_on_sale;
			}
			// Best Selling Products
			if ($selection == "best_selling_products") {
				$args['meta_key'] 				= 'total_sales';
				$args['orderby'] 				= 'meta_value_num';
				$args['meta_query'] = array(
					array(
						'key' 				=> '_visibility',
						'value' 			=> array( 'catalog', 'visible' ),
						'compare' 			=> 'IN'
					)
				);
			}
			// Products in Single Category
			if ($selection == "product_category"){
				$args['tax_query'] = array(
					array(
						'taxonomy' 				=> 'product_cat',
						'terms' 				=> 	array(esc_attr($category)),
						'field' 				=> 'slug',
						'operator' 	 			=> 'IN'
					)
				);
			}
			// Products in Multiple Categories
			if ($selection == "product_categories"){
				$args['tax_query'] = array(
					array(
						'taxonomy' 	 			=> 'product_cat',
						'terms' 				=> 	explode(",", $ids),
						'field' 				=> 'term_id',
						'operator' 	 			=> 'IN'
					)
				);
			}
			
			$menu_tax							= 'product_cat';
			$limit_tax							= 'product_cat';

			// Start WordPress Query
			$loop = new WP_Query($args);
			
			// Language Settings: Isotope Posts
			$TS_VCSC_Isotope_Posts_Language = get_option('ts_vcsc_extend_settings_translationsIsotopePosts', '');
			if (($TS_VCSC_Isotope_Posts_Language == false) || (empty($TS_VCSC_Isotope_Posts_Language))) {
				$TS_VCSC_Isotope_Posts_Language	= $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Isotope_Posts_Language_Defaults;
			}
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_WooCommerce_Grid_Basic', $atts);
			} else {
				$css_class	= '';
			}
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == 'false') {
				$isotope_posts_list_class	= 'ts-posts-timeline-view';
			} else {
				$isotope_posts_list_class	= 'ts-posts-timeline-edit';
			}
			
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == 'true') {
				echo '<div id="ts-isotope-posts-grid-frontend-' . $postsgrid_random . '" class="ts-isotope-posts-grid-frontend" style="border: 1px solid #ededed; padding: 10px;">';
					echo '<div style="font-weight: bold;">"Basic Products Isotope Grid"</div>';
					echo '<div style="margin-bottom: 20px;">The element has been disabled in order to ensure compatiblity with the Visual Composer Front-End Editor.</div>';
					echo '<div>' . __( "Number of Products", "ts_visual_composer_extend" ) . ': ' . $posts_limit . '</div>';
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
					$front_edit_reverse = array(
						"masonry"			=> __( 'Centered Masonry', "ts_visual_composer_extend" ),
						"fitRows"			=> __( 'Fit Rows', "ts_visual_composer_extend" ),
						"straightDown"		=> __( 'Straight Down', "ts_visual_composer_extend" ),
					);
					foreach($front_edit_reverse as $key => $value) {
						if ($key == $layout) {
							echo '<div>' . __( "Content", "ts_visual_composer_extend" ) . ': ' . $value . '</div>';
						}
					};
					$front_edit_reverse = array(
						"postName"			=> __( 'Product Name', "ts_visual_composer_extend" ),
						"postPrice"			=> __( 'Product Price', "ts_visual_composer_extend" ),
						"postRating"		=> __( 'Product Rating', "ts_visual_composer_extend" ),
						"postDate"			=> __( 'Product Date', "ts_visual_composer_extend" ),
						"postModified"		=> __( 'Product Modified', "ts_visual_composer_extend" ),
					);
					foreach($front_edit_reverse as $key => $value) {
						if ($key == $sort_by) {
							echo '<div>' . __( "Sort Criterion", "ts_visual_composer_extend" ) . ': ' . $value . '</div>';
						}
					};
					$front_edit_reverse = array(
						"asc"				=> __( 'Bottom to Top', "ts_visual_composer_extend" ),
						"desc"				=> __( 'Top to Bottom', "ts_visual_composer_extend" ),
					);
					foreach($front_edit_reverse as $key => $value) {
						if ($key == $sort_order) {
							echo '<div>' . __( "Initial Order", "ts_visual_composer_extend" ) . ': ' . $value . '</div>';
						}
					};
					echo '<div>' . __( "Show Filter Button", "ts_visual_composer_extend" ) . ': ' . $filter_menu . '</div>';
					echo '<div>' . __( "Show Layout Button", "ts_visual_composer_extend" ) . ': ' . $layout_menu . '</div>';
					echo '<div>' . __( "Show Sort Criterion Button", "ts_visual_composer_extend" ) . ': ' . $sort_menu . '</div>';
					echo '<div>' . __( "Show Directions Buttons", "ts_visual_composer_extend" ) . ': ' . $directions_menu . '</div>';
				echo '</div>';
			} else {
				$opening .= '<div id="' . $posts_container_id . '" class="ts-isotope-posts-grid-parent ' . ($layout == 'spineTimeline' ? 'ts-timeline ' : 'ts-postsgrid ') . 'ts-timeline-' . $sort_order . ' ts-posts-timeline ' . $isotope_posts_list_class . ' ' . $css_class . '" style="margin-top: ' . $margin_top. 'px; margin-bottom: ' . $margin_bottom . ';" data-lazy="' . $posts_lazy . '" data-count="' . $posts_limit . '" data-ajax="' . $posts_ajax . '" data-trigger="' . $posts_trigger . '" data-column="' . $column_width . '" data-layout="' . $layout . '" data-sort="' . $sort_by . '" data-order="' . $sort_order . '" data-break="' . $layout_break . '" data-type="' . $post_type . '">';			
					// Create Individual Post Output
					$postCounter 		= 0;
					$postCategories 	= array();
					$categoriesCount	= 0;
					if (post_type_exists($post_type) && $loop->have_posts()) {
						$products .= '<div class="ts-timeline-content">';
							$products .= '<ul id="ts-isotope-posts-grid-' . $postsgrid_random . '" class="ts-isotope-posts-grid ts-timeline-list" data-layout="' . $layout . '" data-key="' . $postsgrid_random . '">';								
								while ($loop->have_posts()) : $loop->the_post();
									$postCounter++;
									$product_id 		= get_the_ID();
									$product_title 		= get_the_title($product_id);
									$post 				= get_post($product_id);
									$product 			= new WC_Product($product_id);
									$attachment_ids 	= $product->get_gallery_attachment_ids();
									$price 				= $product->get_price_html();
									$product_sku		= $product->get_sku();
									$attributes 		= $product->get_attributes();
									$stock 				= $product->is_in_stock() ? 'true' : 'false';
									$onsale 			= $product->is_on_sale() ? 'true' : 'false';
									// Rating Settings
									$rating_html		= $product->get_rating_html();
									$rating				= $product->get_average_rating();
									if ($rating == '') {
										$rating			= 0;
									}
									if ($rating_quarter == "true") {
										$rating_value	= floor($rating * 4) / 4;
									} else {
										$rating_value	= $rating;
									}
									$rating_value		= number_format($rating_value, 2, $caption_digits, '');
									if ($rating_rtl == "false") {
										$rating_width	= $rating_value / $rating_maximum * 100;
									} else {
										$rating_width	= 100 - ($rating_value / $rating_maximum * 100);
									}							
									if ($rating_symbol == "other") {
										if ($rating_icon == "ts-ecommerce-starfull1") {
											$rating_class			= 'ts-rating-stars-star1';
										} else if ($rating_icon == "ts-ecommerce-starfull2") {
											$rating_class			= 'ts-rating-stars-star2';
										} else if ($rating_icon == "ts-ecommerce-starfull3") {
											$rating_class			= 'ts-rating-stars-star3';
										} else if ($rating_icon == "ts-ecommerce-starfull4") {
											$rating_class			= 'ts-rating-stars-star4';
										} else if ($rating_icon == "ts-ecommerce-heartfull") {
											$rating_class			= 'ts-rating-stars-heart1';
										} else if ($rating_icon == "ts-ecommerce-heart") {
											$rating_class			= 'ts-rating-stars-heart2';
										} else if ($rating_icon == "ts-ecommerce-thumbsup") {
											$rating_class			= 'ts-rating-stars-thumb';
										} else if ($rating_icon == "ts-ecommerce-ribbon4") {
											$rating_class			= 'ts-rating-stars-ribbon';
										}
									} else {
										$rating_class				= 'ts-rating-stars-smile';
									}					
									if (($rating_value >= 0) && ($rating_value <= 1)) {
										$caption_class				= 'ts-label-danger';
										$caption_background			= 'background-color: ' . $caption_danger . ';';
									} else if (($rating_value > 1) && ($rating_value <= 2)) {
										$caption_class				= 'ts-label-warning';
										$caption_background			= 'background-color: ' . $caption_warning . ';';
									} else if (($rating_value > 2) && ($rating_value <= 3)) {
										$caption_class				= 'ts-label-info';
										$caption_background			= 'background-color: ' . $caption_info . ';';
									} else if (($rating_value > 3) && ($rating_value <= 4)) {
										$caption_class				= 'ts-label-primary';
										$caption_background			= 'background-color: ' . $caption_primary . ';';
									} else if (($rating_value > 4) && ($rating_value <= 5)) {
										$caption_class				= 'ts-label-success';
										$caption_background			= 'background-color: ' . $caption_success . ';';
									}
									if (has_post_thumbnail($loop->post->ID)){
										$featured 		= wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
										$thumbnail 		= wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
										$featured		= $featured[0];
										$thumbnail		= $thumbnail[0];
									} else {
										$featured		= woocommerce_placeholder_img_src();
										$thumbnail		= $featured;
									}
									$title 				= get_the_title();
									// Create Output
									if ($postCounter < $posts_limit + 1) {
										$postAttributes = 'data-visible="false" data-price="' . TS_VCSC_CleanNumberData($product->price) . '" data-rating="' . TS_VCSC_CleanNumberData($rating) . '" data-full="' . get_post_time($date_format) . '" data-author="' . get_the_author() . '" data-date="' . get_post_time('U') . '" data-modified="' . get_the_modified_time('U') . '" data-title="' . get_the_title() . '" data-comments="' . get_comments_number() . '" data-id="' .  get_the_ID() . '"';
										if ((($exclude_outofstock == "true") && ($stock == "true")) || ($exclude_outofstock == "false")) {
											$product_categories = '';
											if ($filter_menu == 'true' && taxonomy_exists($menu_tax)) {
												foreach (get_the_terms($loop->post->ID, $menu_tax) as $term) {
													$product_categories .= $term->slug . ' ';
													$category_check = 0;
													foreach ($postCategories as $index => $array) {
														if ($postCategories[$index]['slug'] == $term->slug) {
															$category_check++;
														}
													}
													if ($category_check == 0) {
														$categoriesCount++;
														$categories_array = array(
															'slug' 					=> $term->slug,
															'name'					=> $term->name,
														);
														$postCategories[] = $categories_array;
													}
												}
											}
											$product_categories .= 'rating-' . TS_VCSC_CleanNumberData($rating) . ' ';
											$products .= '<li class="ts-timeline-list-item ts-timeline-date-true ts-isotope-posts-list-item ' . $product_categories . '" ' . $postAttributes . ' style="margin: 10px;">';
												$products .= '<div class="ts-woocommerce-product-slide" style="' . $product_style . '" data-hash="' . $product_id . '">';
													$products .= '<div id="ts-woocommerce-product-' . $product_id . '" class="ts-image-hover-frame ' . $image_position . ' ts-trigger-hover-adjust" style="width: 100%;">';
														$products .= '<div id="ts-woocommerce-product-' . $product_id . '-counter" class="ts-fluid-wrapper " style="width: 100%; height: auto;">';
																$products .= '<div id="ts-woocommerce-product-' . $product_id . '-mask" class="ts-imagehover ' . $hover_type . ' ts-trigger-hover" data-trigger="ts-trigger-hover" data-closer="" style="width: 100%; height: auto;">';
																	// Product Thumbnail
																	$products .= '<div class="ts-woocommerce-product-preview">';
																		$products .= '<img class="ts-woocommerce-product-image" src="' . $featured . '" alt="" />';
																	$products .='</div>';
																	// Sale Ribbon
																	if ($onsale == "true") {
																		$products .= '<div class="ts-woocommerce-product-ribbon"></div>';
																		$products .= '<i style="" class="ts-woocommerce-product-icon ts-woocommerce-product-sale ts-ecommerce-tagsale"></i>';
																	}
																	$products .= '<div class="ts-woocommerce-product-main">';
																	$products .= '<div class="mask" style="width: 100%; display: block;">';													
																		$products .= '<div id="ts-woocommerce-product-' . $product_id . '-maskcontent" class="maskcontent" style="margin: 0; padding: 0;">';
																			// Product Thubmnail
																			if ($show_image == "true") {
																				if ($link_page == "false") {
																					$products .= '<div class="ts-woocommerce-link-wrapper"><a id="" class="nch-lightbox-media no-ajaxy" data-title="' . $title . '" rel="" href="' . $featured . '" target="' . $link_target . '">';
																						$products .= '<div class="ts-woocommerce-product-thumbnail" style="background-image: url(' . $thumbnail . ');"></div>';
																					$products .= '</a></div>';
																				} else {
																					$products .= '<div class="ts-woocommerce-link-wrapper"><a id="" class="" data-title="' . $title . '" rel="" href="' . get_permalink() . '" target="' . $link_target . '">';
																						$products .= '<div class="ts-woocommerce-product-thumbnail" style="background-image: url(' . $thumbnail . ');"></div>';
																					$products .= '</a></div>';
																				}
																			}
																			// Product Page Link
																			if ($show_link == "true") {
																				$products .= '<div class="ts-woocommerce-link-wrapper"><a href="' . get_permalink() . '" class="ts-woocommerce-product-link" target="_blank"><i style="" class="ts-woocommerce-product-icon ts-woocommerce-product-view ts-ecommerce-forward"></i></a></div>';
																			}
																			// Product Rating
																			if ($show_rating == "true") {
																				$products .= '<div class="ts-rating-stars-frame" data-auto="' . $rating_auto . '" data-size="' . $rating_size . '" data-width="' . ($rating_size * 5) . '" data-rating="' . $rating_value . '" style="margin: 10px 0 0 10px; float: left;">';
																					$products .= '<div class="ts-star-rating' . ($rating_rtl == "false" ? "" : "-rtl") . ' ts-rating-active " style="font-size: ' . $rating_size . 'px; line-height: ' . ($rating_size + 5) . 'px;">';
																						if (($caption_show == "true") && ($caption_position == "left")) {
																							$products .= '<div class="ts-rating-caption" style="margin-right: 10px;">';
																								if ($rating_rtl == "false") {
																									$products .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . $rating_value . ' / ' . number_format($rating_maximum, 2, $caption_digits, '') . '</span>';
																								} else {
																									$products .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . number_format($rating_maximum, 2, $caption_digits, '') . ' / ' . $rating_value . '</span>';
																								}
																							$products .= '</div>';
																						}
																						$products .= '<div class="ts-rating-container' . ($rating_rtl == "false" ? "" : "-rtl") . ' ts-rating-glyph-holder ' . $rating_class . '" style="color: ' . ($rating_rtl == "false" ? $color_empty : $color_rated) . ';">';
																							$products .= '<div class="ts-rating-stars ' . $rating_class . '" style="color: ' . ($rating_rtl == "false" ? $color_rated : $color_empty) . '; width: ' . $rating_width . '%;"></div>';
																						$products .= '</div>';
																						if (($caption_show == "true") && ($caption_position == "right")) {
																							$products .= '<div class="ts-rating-caption" style="margin-left: 10px;">';
																								if ($rating_rtl == "false") {
																									$products .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . $rating_value . ' / ' . number_format($rating_maximum, 2, $caption_digits, '') . '</span>';
																								} else {
																									$products .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . number_format($rating_maximum, 2, $caption_digits, '') . ' / ' . $rating_value . '</span>';
																								}
																							$products .= '</div>';
																						}
																					$products .= '</div>';
																				$products .= '</div>';
																			}
																			// Product Price
																			if ($show_price == "true") {
																				$products .= '<div class="ts-woocommerce-product-price">';
																					$products .= '<i style="" class="ts-woocommerce-product-icon ts-woocommerce-product-cost ts-ecommerce-pricetag3"></i>';
																					if ($product->price > 0) {
																						if ($product->price && isset($product->regular_price)) {
																							$from 	= $product->regular_price;
																							$to 	= $product->price;
																							if ($from != $to) {
																								$products .= '<div class="ts-woocommerce-product-regular"><del>' . ((is_numeric($from)) ? woocommerce_price($from) : $from) . '</del> | </div><div class="ts-woocommerce-product-special">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</div>';
																							} else {
																								$products .= '<div class="ts-woocommerce-product-current">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</div>';
																							}
																						} else {
																							$to = $product->price;
																							$products .= '<div class="ts-woocommerce-product-current">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</div>';
																						}
																					} else {
																						$to = $product->price;
																						$products .= '<div class="ts-woocommerce-product-current">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</div>';
																					}
																				$products .='</div>';
																			}
																			
																			$products .= '<div class="ts-woocommerce-product-line"></div>';
																			// Add to Cart Button (Icon)
																			if ($show_cart == "true") {
																				$products .= '<div class="ts-woocommerce-link-wrapper"><a class="ts-woocommerce-product-purchase" href="?add-to-cart=' . $product_id . '" rel="nofollow" data-id="' . $product_id . '" data-sku="' . $product_sku . '"><i style="" class="ts-woocommerce-product-icon ts-woocommerce-product-cart ts-ecommerce-cart4"></i></a></div>';
																			}
																			// View Description Button
																			if ($show_info == "true") {
																				$products .= '<div id="ts-vcsc-modal-' . $product_id . '-trigger" style="" class="ts-vcsc-modal-' . $product_id . '-parent nch-holder ts-vcsc-font-icon ts-font-icons ts-shortcode ts-icon-align-center" style="">';
																					$products .= '<a href="#ts-vcsc-modal-' . $product_id . '" class="nch-lightbox-modal" data-title="" data-open="false" data-delay="0" data-type="html" rel="" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
																						$products .= '<span class="">';
																							$products .= '<i class="ts-font-icon ts-woocommerce-product-icon ts-woocommerce-product-info ts-ecommerce-information1" style=""></i>';
																						$products .= '</span>';
																					$products .= '</a>';
																				$products .= '</div>';
																			}
																			// Product In-Stock or Unavailable
																			if ($show_stock == "true") {
																				$products .= '<div class="ts-woocommerce-product-status">';
																					if ($stock == 'false') {
																						$products .= '<div class="ts-woocommerce-product-stock"><span class="ts-woocommerce-product-outofstock">' . __('Out of Stock', 'woocommerce') . '</span></div>';							
																					} else if ($stock == 'true') {
																						$products .= '<div class="ts-woocommerce-product-stock"><span class="ts-woocommerce-product-instock">' . __('In Stock', 'woocommerce') . '</span></div>';
																					}
																				$products .='</div>';
																			}
																		$products .= '</div>';
																	$products .= '</div>';
																	$products .= '</div>';
																$products .= '</div>';
														$products .= '</div>';
													$products .= '</div>';
													// Product Title
													$products .='<h2 class="ts-woocommerce-product-title">';
														$products .= $title;
													$products .='</h2>';
													// Product Description
													if ($show_info == "true") {
														$products .= '<div id="ts-vcsc-modal-' . $product_id . '" class="ts-modal-content nch-hide-if-javascript" style="' . $description_style . '">';
															$products .= '<div class="ts-modal-white-header"></div>';
															$products .= '<div class="ts-modal-white-frame">';
																$products .= '<div class="ts-modal-white-inner">';
																	$products .= '<h2 style="border-bottom: 1px solid #eeeeee; padding-bottom: 10px; line-height: 32px; font-size: 24px; text-align: left;">' . $title . '</h2>';											
																	$products .= '<div class="ts-woocommerce-lightbox-frame" style="width: 100%; height: 32px; margin: 10px auto; padding: 0;">';
																		$products .= '<a style="position: inherit; margin-left: 10px; float: right;" class="ts-woocommerce-product-purchase" href="?add-to-cart=' . $product_id . '" rel="nofollow" data-id="' . $product_id . '" data-sku="' . $product_sku . '"><i style="color: #000000;" class="ts-woocommerce-product-icon ts-woocommerce-product-cart ts-ecommerce-cart4"></i></a>';
																		$products .= '<a href="' . get_permalink() . '" target="_parent" style="position: inherit; margin-left: 10px; float: right;" class="ts-woocommerce-product-link"><i style="color: #000000;" class="ts-woocommerce-product-icon ts-woocommerce-product-view ts-ecommerce-forward"></i></a>';
																		$products .= '<div class="ts-rating-stars-frame" data-auto="' . $rating_auto . '" data-size="' . $rating_size . '" data-width="' . ($rating_size * 5) . '" data-rating="' . $rating_value . '" style="margin: 0; float: right;">';
																			$products .= '<div class="ts-star-rating' . ($rating_rtl == "false" ? "" : "-rtl") . ' ts-rating-active " style="font-size: ' . $rating_size . 'px; line-height: ' . ($rating_size + 5) . 'px;">';
																				if (($caption_show == "true") && ($caption_position == "left")) {
																					$products .= '<div class="ts-rating-caption" style="margin-right: 10px;">';
																						if ($rating_rtl == "false") {
																							$products .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . $rating_value . ' / ' . number_format($rating_maximum, 2, $caption_digits, '') . '</span>';
																						} else {
																							$products .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . number_format($rating_maximum, 2, $caption_digits, '') . ' / ' . $rating_value . '</span>';
																						}
																					$products .= '</div>';
																				}
																				$products .= '<div class="ts-rating-container' . ($rating_rtl == "false" ? "" : "-rtl") . ' ts-rating-glyph-holder ' . $rating_class . '" style="color: ' . ($rating_rtl == "false" ? $color_empty : $color_rated) . ';">';
																					$products .= '<div class="ts-rating-stars ' . $rating_class . '" style="color: ' . ($rating_rtl == "false" ? $color_rated : $color_empty) . '; width: ' . $rating_width . '%;"></div>';
																				$products .= '</div>';
																				if (($caption_show == "true") && ($caption_position == "right")) {
																					$products .= '<div class="ts-rating-caption" style="margin-left: 10px;">';
																						if ($rating_rtl == "false") {
																							$products .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . $rating_value . ' / ' . number_format($rating_maximum, 2, $caption_digits, '') . '</span>';
																						} else {
																							$products .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . number_format($rating_maximum, 2, $caption_digits, '') . ' / ' . $rating_value . '</span>';
																						}
																					$products .= '</div>';
																				}
																			$products .= '</div>';
																		$products .= '</div>';
																		$products .= '<div class="ts-woocommerce-product-price" style="position: inherit; margin-right: 10px; float: left; width: auto; margin-top: 0;">';
																			$products .= '<i style="color: #000000; margin: 0 10px 0 0;" class="ts-woocommerce-product-icon ts-woocommerce-product-cost ts-ecommerce-pricetag3"></i>';
																			if ($product->price > 0) {
																				if ($product->price && isset($product->regular_price)) {
																					$from 	= $product->regular_price;
																					$to 	= $product->price;
																					if ($from != $to) {
																						$products .= '<div class="ts-woocommerce-product-regular"><del style="color: #7F0000;">' . ((is_numeric($from)) ? woocommerce_price($from) : $from) . '</del> | </div><div class="ts-woocommerce-product-special">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</div>';
																					} else {
																						$products .= '<div class="ts-woocommerce-product-current">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</div>';
																					}
																				} else {
																					$to = $product->price;
																					$products .= '<div class="ts-woocommerce-product-current">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</div>';
																				}
																			} else {
																				$to = $product->price;
																				$products .= '<div class="ts-woocommerce-product-current">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</div>';
																			}
																		$products .='</div>';											
																	$products .='</div>';
																	$products .= '<div class="ts-woocommerce-product-seperator" style="border-bottom: 1px solid #eeeeee; margin: 10px auto 20px auto; width: 100%;"></div>';	
																		$products .= '<img style="width: 100%; max-width: 250px; height: auto; margin: 10px auto;" class="ts-woocommerce-product-image" src="' . $featured . '" alt="" />';												
																		$products .= '<div class="ts-woocommerce-product-seperator" style="border-bottom: 1px solid #eeeeee; margin: 20px auto 10px auto; width: 100%;"></div>';													
																		$products .= '<div style="margin-top: 20px; text-align: justify;">';
																			if ($show_content == "excerpt") {
																				$products .= get_the_excerpt();
																			} else if ($show_content == "cutcharacters") {
																				$content = apply_filters('the_content', get_the_content());
																				$excerpt = TS_VCSC_TruncateHTML($content, $cutoff_characters, '...', false, true);
																				$products .= $excerpt;
																			} else if ($show_content == "complete") {
																				$products .= get_the_content();
																			}
																		$products .='</div>';											
																$products .= '</div>';
															$products .= '</div>';
														$products .= '</div>';
													}
													
												$products .= '</div>';
											$products .= '</li>';
										}										
									}
								endwhile;
							$products .= '</ul>';
						$products .= '</div>';
						if ($posts_lazy == "true") {
							$products .= '<div class="ts-load-more-wrap">';
								$products .= '<span class="ts-timeline-load-more">' . $posts_load . '</span>';
							$products .= '</div>';
						}
						wp_reset_postdata();
					} else {
						$products .= '<p>Nothing found. Please check back soon!</p>';
					}
					// Create Post Controls (Filter, Sort)
					$controls .= '<div id="ts-isotope-posts-grid-controls-' . $postsgrid_random . '" class="ts-isotope-posts-grid-controls">';
						if (($directions_menu == 'true') && ($posts_lazy == 'false')) {
							$controls .= '<div class="ts-button ts-button-flat ts-timeline-controls-desc ts-isotope-posts-controls-desc ' . ($sort_order == "desc" ? "active" : "") . '"><span class="ts-isotope-posts-controls-desc-image"></span></div>';
							$controls .= '<div class="ts-button ts-button-flat ts-timeline-controls-asc ts-isotope-posts-controls-asc ' . ($sort_order == "asc" ? "active" : "") . '"><span class="ts-isotope-posts-controls-asc-image"></span></div>';
						}
						$controls .= '<div class="ts-isotope-posts-grid-controls-menus">';
							if ($filter_menu == 'true') {
								if ($categoriesCount > 1) {
									$controls .= '<div id="ts-isotope-posts-filter-trigger-' . $postsgrid_random . '" class="ts-isotope-posts-filter-trigger" data-dropdown="#ts-isotope-posts-filter-' . $postsgrid_random . '" data-horizontal-offset="0" data-vertical-offset="0"><span>' . $TS_VCSC_Isotope_Posts_Language['WooFilterProducts'] . '</span></div>';
									$controls .= '<div id="ts-isotope-posts-filter-' . $postsgrid_random . '" class="ts-dropdown ts-dropdown-tip ts-dropdown-relative ts-dropdown-anchor-left" style="left: 0px;">';
										$controls .= '<ul id="" class="ts-dropdown-menu">';
											$controls .= '<li><label style="font-weight: bold;"><input class="ts-isotope-posts-filter ts-isotope-posts-filter-all" type="checkbox" style="margin-right: 10px;" checked="checked" data-type="all" data-key="' . $postsgrid_random . '" data-filter="*">' . $TS_VCSC_Isotope_Posts_Language['SeeAll'] . '</label></li>';
											$controls .= '<li class="ts-dropdown-divider"></li>';
											foreach ($postCategories as $index => $array) {												
												$controls .= '<li><label><input class="ts-isotope-posts-filter ts-isotope-posts-filter-single" type="checkbox" style="margin-right: 10px;" data-type="single" data-key="' . $postsgrid_random . '" data-filter=".'. $postCategories[$index]['slug'] .'">' . $postCategories[$index]['name'] . '</label></li>';
											}
										$controls .= '</ul>';
									$controls .= '</div>';
								}
							}
							if ($layout_menu == 'true') {
								$controls .= '<div id="ts-isotope-posts-layout-trigger-' . $postsgrid_random . '" class="ts-isotope-posts-layout-trigger" data-dropdown="#ts-isotope-posts-layout-' . $postsgrid_random . '" data-horizontal-offset="0" data-vertical-offset="0"><span>' . $TS_VCSC_Isotope_Posts_Language['ButtonLayout'] . '</span></div>';
								$controls .= '<div id="ts-isotope-posts-layout-' . $postsgrid_random . '" class="ts-dropdown ts-dropdown-tip ts-dropdown-relative ts-dropdown-anchor-left" style="left: 0px;">';
									$controls .= '<ul id="" class="ts-dropdown-menu">';
										$controls .= '<li><label><input class="ts-isotope-posts-layout" type="radio" name="radio-group-' . $postsgrid_random . '" data-layout="masonry" style="margin-right: 10px;" ' . ($layout == 'masonry' ? 'checked="checked"' : '') . '>' . $TS_VCSC_Isotope_Posts_Language['Masonry'] . '</label></li>';
										$controls .= '<li><label><input class="ts-isotope-posts-layout" type="radio" name="radio-group-' . $postsgrid_random . '" data-layout="fitRows" style="margin-right: 10px;" ' . ($layout == 'fitRows' ? 'checked="checked"' : '') . '>' . $TS_VCSC_Isotope_Posts_Language['FitRows'] . '</label></li>';
										$controls .= '<li><label><input class="ts-isotope-posts-layout" type="radio" name="radio-group-' . $postsgrid_random . '" data-layout="straightDown" style="margin-right: 10px;" ' . ($layout == 'straightDown' ? 'checked="checked"' : '') . '>' . $TS_VCSC_Isotope_Posts_Language['StraightDown'] . '</label></li>';
									$controls .= '</ul>';
								$controls .= '</div>';
							}
							if ($sort_menu == 'true') {
								$controls .= '<div id="ts-isotope-posts-sort-trigger-' . $postsgrid_random . '" class="ts-isotope-posts-sort-trigger" data-dropdown="#ts-isotope-posts-sort-' . $postsgrid_random . '" data-horizontal-offset="0" data-vertical-offset="0"><span>' . $TS_VCSC_Isotope_Posts_Language['ButtonSort'] . '</span></div>';
								$controls .= '<div id="ts-isotope-posts-sort-' . $postsgrid_random . '" class="ts-dropdown ts-dropdown-tip ts-dropdown-relative ts-dropdown-anchor-left" style="left: 0px;">';
									$controls .= '<ul id="" class="ts-dropdown-menu">';
										$controls .= '<li><label><input class="ts-isotope-posts-sort" type="radio" name="radio-sort-' . $postsgrid_random . '" data-sort="postName" style="margin-right: 10px;" ' . ($sort_by == 'postName' ? 'checked="checked"' : '') . '>' . $TS_VCSC_Isotope_Posts_Language['WooTitle'] . '</label></li>';
										$controls .= '<li><label><input class="ts-isotope-posts-sort" type="radio" name="radio-sort-' . $postsgrid_random . '" data-sort="postPrice" style="margin-right: 10px;" ' . ($sort_by == 'postPrice' ? 'checked="checked"' : '') . '>' . $TS_VCSC_Isotope_Posts_Language['WooPrice'] . '</label></li>';
										$controls .= '<li><label><input class="ts-isotope-posts-sort" type="radio" name="radio-sort-' . $postsgrid_random . '" data-sort="postRatings" style="margin-right: 10px;" ' . ($sort_by == 'postRatings' ? 'checked="checked"' : '') . '>' . $TS_VCSC_Isotope_Posts_Language['WooRating'] . '</label></li>';
										$controls .= '<li><label><input class="ts-isotope-posts-sort" type="radio" name="radio-sort-' . $postsgrid_random . '" data-sort="postDate" style="margin-right: 10px;" ' . ($sort_by == 'postDate' ? 'checked="checked"' : '') . '>' . $TS_VCSC_Isotope_Posts_Language['WooDate'] . '</label></li>';
										$controls .= '<li><label><input class="ts-isotope-posts-sort" type="radio" name="radio-sort-' . $postsgrid_random . '" data-sort="postModified" style="margin-right: 10px;" ' . ($sort_by == 'postModified' ? 'checked="checked"' : '') . '>' . $TS_VCSC_Isotope_Posts_Language['WooModified'] . '</label></li>';
									$controls .= '</ul>';
								$controls .= '</div>';
							}
						$controls .= '</div>';
						$controls .= '<div class="clearFixMe" style="clear:both;"></div>';
					$controls .= '</div>';
				$closing .= '</div>';

				echo $opening;
				echo $controls;
				echo $products;
				echo $closing;
			}
            $myvariable = ob_get_clean();
            return $myvariable;
        }
    
        // Add Isotope Posts Grid Elements
        function TS_VCSC_WooCommerce_Grid_Basic_Elements() {
            global $VISUAL_COMPOSER_EXTENSIONS;
            // Add Standalone Products Grid
            if (function_exists('vc_map')) {
                vc_map( array(
                    "name"                              => __( "Basic Products Isotope Grid", "ts_visual_composer_extend" ),
                    "base"                              => "TS_VCSC_WooCommerce_Grid_Basic",
                    "icon" 	                            => "icon-wpb-ts_vcsc_icon_commerce_grid_basic",
                    "class"                             => "",
                    "category"                          => __( 'VC WooCommerce', "ts_visual_composer_extend" ),
                    "description"                       => __("Place a basic products Isotope grid", "ts_visual_composer_extend"),
                    "admin_enqueue_js"                	=> "",
                    "admin_enqueue_css"               	=> "",
                    "params"                            => array(
                        // Isotope Posts Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_1",
                            "value"                     => "",
							"seperator"					=> "Product Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
                        ),
                        array(
                            "type"                      => "dropdown",
                            "heading"                   => __( "Product Selection", "ts_visual_composer_extend" ),
                            "param_name"                => "selection",
                            "width"                     => 150,
                            "value"                     => array(
                                __( 'Recent Products', "ts_visual_composer_extend" )		    	=> "recent_products",
                                __( 'Featured Products', "ts_visual_composer_extend" )		        => "featured_products",
                                __( 'Top Rated Products', "ts_visual_composer_extend" )		        => "top_rated_products",
                                __( 'Products on Sale', "ts_visual_composer_extend" )		    	=> "sale_products",
								__( 'Best Selling Products', "ts_visual_composer_extend" )		    => "best_selling_products",
								__( 'Products in Single Categories', "ts_visual_composer_extend" )	=> "product_category",
								__( 'Products by Categories', "ts_visual_composer_extend" )		    => "product_categories",
                            ),
                            "description"               => __( "Select which products should be shown in the slider.", "ts_visual_composer_extend" ),
                            "admin_label"		        => true,
                        ),						
						array(
							"type" 						=> "wc_single_product_category",
							"heading" 					=> __("Category", "ts_visual_composer_extend"),
							"param_name" 				=> "category",
							"admin_label"       		=> true,
							"description"       		=> __( "Select the category that you want to utilize.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "selection", 'value' => 'product_category' ),
						),						
						array(
							"type" 						=> "wc_multiple_product_categories",
							"heading" 					=> __("Categories", "ts_visual_composer_extend"),
							"param_name" 				=> "ids",
							"admin_label"       		=> true,
							"description"       		=> __( "Select the categories that you want to utilize.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "selection", 'value' => 'product_categories' ),
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Total Number of Products", "ts_visual_composer_extend" ),
							"param_name"                => "products_total",
							"value"                     => "12",
							"min"                       => "1",
							"max"                       => "100",
							"step"                      => "1",
							"unit"                      => '',
							"description"               => __( "Define the total number of products to be used for the slider.", "ts_visual_composer_extend" ),
							"dependency" 				=> ""
						),
						array(
							"type" 						=> "dropdown",
							"heading" 					=> __("Retrieve Ordered By", "ts_visual_composer_extend"),
							"param_name" 				=> "orderby",
							"value" 					=> array(
								__("Date", "ts_visual_composer_extend")				=>	'date',
								__("Title", "ts_visual_composer_extend")			=>	'title',
								__("ID", "ts_visual_composer_extend")				=>	'id',
								__("Menu Order", "ts_visual_composer_extend")		=>	'menu_order',
								__("Random", "ts_visual_composer_extend")			=>	'rand',
							),
							"admin_label"       		=> true,
							"description"       		=> __( "Select in by which order criterium the products should be retrieved from WordPress.", "ts_visual_composer_extend" )
						),
						array(
							"type" 						=> "dropdown",
							"heading" 					=> __("Retrieve Order", "ts_visual_composer_extend"),
							"param_name" 				=> "order",
							"value" 					=> array(
								__("Descending", "ts_visual_composer_extend")		=>	'desc',
								__("Ascending", "ts_visual_composer_extend")		=>	'asc',
							),
							"admin_label"       		=> true,
							"description"       		=> __( "Select in which order direction the products should be retrieved from WordPress.", "ts_visual_composer_extend" )
						),
						// Lazy Load Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_2",
                            "value"                     => "",
							"seperator"					=> "LazyLoad Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "'Lazy Load' Effect", "ts_visual_composer_extend" ),
                            "param_name"                => "posts_lazy",
                            "value"                     => "false",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to imitate a lazy load effect for the posts.", "ts_visual_composer_extend" ),
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Lazy-Load Trigger", "ts_visual_composer_extend" ),
							"param_name"        		=> "posts_trigger",
							"width"             		=> 200,
							"value"             		=> array(
								__( 'Scroll', "ts_visual_composer_extend" )      	=> "scroll",
								__( 'Click', "ts_visual_composer_extend" )         	=> "click",
							),
							"description"       		=> __( "Select how the Lazy-Load Effect should be triggered for the posts.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "posts_lazy", 'value' => 'true' )
						),
                        array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Number of Posts per LazyLoad", "ts_visual_composer_extend" ),
                            "param_name"                => "posts_ajax",
                            "value"                     => "10",
                            "min"                       => "1",
                            "max"                       => "25",
                            "step"                      => "1",
                            "unit"                      => '',
							"dependency" 				=> array("element" 	=> "posts_lazy", "value" 	=> "true"),
                            "description"               => __( "Select the number of posts to be initially shown and then added per LazyLoad event.", "ts_visual_composer_extend" ),
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                  	 => __( "'Show More' Text", "ts_visual_composer_extend" ),
                            "param_name"                => "posts_load",
                            "value"                     => "Show More",
                            "description"               => __( "Enter the text to be shown in the 'Show More' LazyLoad trigger.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "posts_lazy", "value" 	=> "true"),
                        ),
                        // Layout Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_3",
                            "value"                     => "",
							"seperator"					=> "General Layout",
                            "description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Layout",
                        ),
                        array(
                            "type"                      => "dropdown",
                            "heading"                   => __( "Content", "ts_visual_composer_extend" ),
                            "param_name"                => "layout",
                            "value"                     => array(
								__( 'Centered Masonry', "ts_visual_composer_extend" )	=> "masonry",
                                __( 'Fit Rows', "ts_visual_composer_extend" )          	=> "fitRows",
								__( 'Straight Down', "ts_visual_composer_extend" )		=> "straightDown",
                            ),
                            "description"               => __( "Select the layout in which the posts should initially be shown.", "ts_visual_composer_extend" ),
                            "admin_label"               => true,
                            "group" 			        => "Layout",
                        ),
                        array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Column Width", "ts_visual_composer_extend" ),
                            "param_name"                => "column_width",
                            "value"                     => "285",
                            "min"                       => "100",
                            "max"                       => "1200",
                            "step"                      => "1",
                            "unit"                      => 'px',
                            "description"               => __( "Select the column width for the individual posts.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "layout", "value" 	=> array("masonry", "fitRows")),
                            "group" 			        => "Layout",
                        ),
                        array(
                            "type"                      => "dropdown",
                            "heading"                  	=> __( "Sort Criterion", "ts_visual_composer_extend" ),
                            "param_name"                => "sort_by",
                            "value"                     => array(
                                __( 'Product Name', "ts_visual_composer_extend" )          		=> "postName",
								__( 'Product Price', "ts_visual_composer_extend" )				=> "postPrice",
								__( 'Product Rating', "ts_visual_composer_extend" )				=> "postRating",
                                __( 'Product Date', "ts_visual_composer_extend" )				=> "postDate",
                                __( 'Product Modified', "ts_visual_composer_extend" )			=> "postModified",
                            ),
                            "description"               => __( "Select the criterion by which posts should initially be sorted.", "ts_visual_composer_extend" ),
                            "admin_label"               => true,
                            "group" 			        => "Layout",
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Initial Order", "ts_visual_composer_extend" ),
							"param_name"        		=> "sort_order",
							"width"             		=> 200,
							"value"             		=> array(
								__("Ascending", "ts_visual_composer_extend")		=>	'asc',
								__("Descending", "ts_visual_composer_extend")		=>	'desc',
							),
							"admin_label"               => true,
							"description"       		=> __( "Select in which order the posts should initially be shown.", "ts_visual_composer_extend" ),
                            "group" 			        => "Layout",
						),
						// User Control Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_4",
                            "value"                     => "",
							"seperator"					=> "User Controls",
                            "description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Layout",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Filter Button", "ts_visual_composer_extend" ),
                            "param_name"                => "filter_menu",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to show a category filter for the posts.", "ts_visual_composer_extend" ),
                            "group" 			        => "Layout",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Layout Button", "ts_visual_composer_extend" ),
                            "param_name"                => "layout_menu",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to show a layout changer for the posts.", "ts_visual_composer_extend" ),
                            "group" 			        => "Layout",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Sort Criterion Button", "ts_visual_composer_extend" ),
                            "param_name"                => "sort_menu",
                            "value"                     => "false",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to show a sort criterion changer for the posts.", "ts_visual_composer_extend" ),
                            "group" 			        => "Layout",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Directions Buttons", "ts_visual_composer_extend" ),
                            "param_name"                => "directions_menu",
                            "value"                     => "false",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to show directions buttons for the posts.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "posts_lazy", "value" 	=> "false"),
                            "group" 			        => "Layout",
                        ),
                        // Content Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_5",
                            "value"                     => "",
							"seperator"					=> "Content Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Content",
                        ),
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Hover Style", "ts_visual_composer_extend" ),
							"param_name"            	=> "hover_type",
							"width"                 	=> 300,
							"value"						=> array(
								__( "Style 1", "ts_visual_composer_extend" )                        => "ts-imagehover-style1",
								__( "Style 2", "ts_visual_composer_extend" )                        => "ts-imagehover-style2",
								__( "Style 3", "ts_visual_composer_extend" )                        => "ts-imagehover-style3",
								__( "Style 4", "ts_visual_composer_extend" )                        => "ts-imagehover-style4",
								__( "Style 5", "ts_visual_composer_extend" )                        => "ts-imagehover-style5",
								__( "Style 6", "ts_visual_composer_extend" )                        => "ts-imagehover-style6",
								__( "Style 7", "ts_visual_composer_extend" )                        => "ts-imagehover-style7",
								__( "Style 8", "ts_visual_composer_extend" )                        => "ts-imagehover-style8",
							),
							"admin_label"           	=> true,
							"description"           	=> __( "Select the overlay effect for the product.", "ts_visual_composer_extend" ),
                            "group" 			        => "Content",
						),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Info", "ts_visual_composer_extend" ),
                            "param_name"                => "show_info",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show a more detailed product description in a lightbox.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                            "group" 			        => "Content",
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
							"dependency" 				=> array("element" 	=> "show_info", "value" 	=> "true"),
							"description"       		=> __( "Select what part of the post content should be shown.", "ts_visual_composer_extend" ),
                            "group" 			        => "Content",
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
                            "dependency" 				=> array("element" 	=> "show_content", "value" 	=> "cutcharacters"),
                            "group" 			        => "Content",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Featured Image", "ts_visual_composer_extend" ),
                            "param_name"                => "show_image",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the products featured image inside the overlay.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                            "group" 			        => "Content",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Link Image to Page", "ts_visual_composer_extend" ),
                            "param_name"                => "link_page",
                            "value"                     => "false",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to link the product image to the product page instead of showing the image in a lightbox.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "show_image", "value" 	=> "true"),
                            "group" 			        => "Content",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Link", "ts_visual_composer_extend" ),
                            "param_name"                => "show_link",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the product page link in the overlay.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                            "group" 			        => "Content",
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Link Target", "ts_visual_composer_extend" ),
							"param_name"        		=> "link_target",
							"value"             		=> array(
								__( "Same Window", "ts_visual_composer_extend" )                    => "_parent",
								__( "New Window", "ts_visual_composer_extend" )                     => "_blank"
							),
							"description"       		=> __( "Select how the link should be opened.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                            "group" 			        => "Content",
						),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Rating", "ts_visual_composer_extend" ),
                            "param_name"                => "show_rating",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the product rating in the overlay.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                            "group" 			        => "Content",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Price", "ts_visual_composer_extend" ),
                            "param_name"                => "show_price",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the product price in the overlay.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                            "group" 			        => "Content",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Cart", "ts_visual_composer_extend" ),
                            "param_name"                => "show_cart",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the add to cart link in the overlay.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                            "group" 			        => "Content",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Stock", "ts_visual_composer_extend" ),
                            "param_name"                => "show_stock",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the product stock status in the overlay.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                            "group" 			        => "Content",
                        ),
                        // Rating Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_6",
                            "value"                     => "",
							"seperator"					=> "Rating Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Rating",
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Symbol", "ts_visual_composer_extend" ),
							"param_name"        		=> "rating_symbol",
							"value"             		=> array(
								__( "Other Icon", "ts_visual_composer_extend" )                 => "other",
								__( "Smileys", "ts_visual_composer_extend" )                    => "smile",
							),
							"description"       		=> __( "Select how you want to display the rating.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 			        => "Rating",
						),
						array(
							'type' 						=> ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") && ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorNativeSelector == "true")) ? "iconpicker" : "icons_panel"),
							'heading' 					=> __( 'Rating Icon', 'ts_visual_composer_extend' ),
							'param_name' 				=> 'rating_icon',
							'value'						=> '',
							'height'					=> "60",
							'size'						=> "40",
							'margin'					=> "9",
							'custom'					=> "false",
							'fonts'						=> "false",
							'filter'					=> "false",
							'override'					=> "true",
							'default'					=> "ts-ecommerce-starfull1",
							'source'					=> ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") && ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorNativeSelector == "true")) ? "" : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_RatingScaleIconsCompliant),
							'settings' 					=> array(
								'emptyIcon' 					=> false,
								'type' 							=> 'extensions',
								'iconsPerPage' 					=> 200,
								'source' 						=> ((($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorIconFontsInternal == "true") && ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorNativeSelector == "true")) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_RatingScaleIconsCompliant : ""),
							),
							"description"       		=> __( "Select which icon should be used to reflect the rating.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "rating_symbol", 'value' => 'other' ),
							"group" 			        => "Rating",
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "RTL Alignment", "ts_visual_composer_extend" ),
							"param_name"        		=> "rating_rtl",
							"value"             		=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to show the rating in 'RTL' (Right-To-Left) alignment.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 			        => "Rating",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Rated Icon Fill Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "color_rated",
							"value"             		=> "#FFD800",
							"description"       		=> __( "Define the fill color for the rated icons.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 			        => "Rating",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Empty Icon Fill Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "color_empty",
							"value"             		=> "#e3e3e3",
							"description"       		=> __( "Define the fill color for the empty icons.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 			        => "Rating",
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Show Rating Caption", "ts_visual_composer_extend" ),
							"param_name"        		=> "caption_show",
							"value"             		=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you also want to show a caption with the rating as number.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 			        => "Rating",
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Position", "ts_visual_composer_extend" ),
							"param_name"        		=> "caption_position",
							"value"             		=> array(
								__( "Left", "ts_visual_composer_extend" )					=> "left",
								__( "Right", "ts_visual_composer_extend" )					=> "right",
							),
							"description"       		=> __( "Select where the numeric rating caption block should be placed.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "caption_show", 'value' => 'true' ),
							"group" 			        => "Rating",
						),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Decimals Seperator", "ts_visual_composer_extend" ),
							"param_name"        		=> "caption_digits",
							"width"             		=> 150,
							"value"             		=> array(
								__( 'Dot', "ts_visual_composer_extend" )          => ".",
								__( 'Comma', "ts_visual_composer_extend" )        => ",",                        
								__( 'Space', "ts_visual_composer_extend" )        => " ",
							),
							"description"       		=> __( "Select a character to seperate decimals in the rating value.", "ts_visual_composer_extend" ),
							"dependency"				=> array( 'element' => "caption_show", 'value' => 'true' ),
							"group" 			        => "Rating",
						),
						// Lightbox Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_7",
                            "value"                     => "",
							"seperator"					=> "Lightbox Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Lightbox",
                        ),
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Transition Effect", "ts_visual_composer_extend" ),
							"param_name"            	=> "lightbox_effect",
							"width"                 	=> 150,
							"value"                 	=> array(
								__( 'Random', "ts_visual_composer_extend" )       	=> "random",
								__( 'Swipe', "ts_visual_composer_extend" )        	=> "swipe",
								__( 'Fade & Swipe', "ts_visual_composer_extend" )	=> "fade",
								__( 'Scale', "ts_visual_composer_extend" )        	=> "scale",
								__( 'Slide Up', "ts_visual_composer_extend" )     	=> "slideUp",
								__( 'Slide Down', "ts_visual_composer_extend" )   	=> "slideDown",
								__( 'Flip', "ts_visual_composer_extend" )         	=> "flip",
								__( 'Skew', "ts_visual_composer_extend" )         	=> "skew",
								__( 'Bounce Up', "ts_visual_composer_extend" )    	=> "bounceUp",
								__( 'Bounce Down', "ts_visual_composer_extend" )  	=> "bounceDown",
								__( 'Break In', "ts_visual_composer_extend" )     	=> "breakIn",
								__( 'Rotate In', "ts_visual_composer_extend" )    	=> "rotateIn",
								__( 'Rotate Out', "ts_visual_composer_extend" )   	=> "rotateOut",
								__( 'Hang Left', "ts_visual_composer_extend" )    	=> "hangLeft",
								__( 'Hang Right', "ts_visual_composer_extend" )   	=> "hangRight",
								__( 'Cycle Up', "ts_visual_composer_extend" )     	=> "cicleUp",
								__( 'Cycle Down', "ts_visual_composer_extend" )   	=> "cicleDown",
								__( 'Zoom In', "ts_visual_composer_extend" )      	=> "zoomIn",
								__( 'Throw In', "ts_visual_composer_extend" )     	=> "throwIn",
								__( 'Fall', "ts_visual_composer_extend" )         	=> "fall",
								__( 'Jump', "ts_visual_composer_extend" )         	=> "jump",
							),
							"description"           	=> __( "Select the transition effect to be used for the image in the lightbox.", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
                            "group" 			        => "Lightbox",
						),
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Backlight Color", "ts_visual_composer_extend" ),
							"param_name"            	=> "lightbox_backlight_choice",
							"width"                 	=> 150,
							"value"                 	=> array(
								__( 'Predefined Color', "ts_visual_composer_extend" )	=> "predefined",
								__( 'Custom Color', "ts_visual_composer_extend" )		=> "customized",
							),
							"description"           	=> __( "Select the (backlight) color style for the popup box.", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
                            "group" 			        => "Lightbox",
						),
						array(
							"type"                  	=> "dropdown",
							"heading"               	=> __( "Select Backlight Color", "ts_visual_composer_extend" ),
							"param_name"            	=> "lightbox_backlight_color",
							"width"                 	=> 150,
							"value"                 	=> array(
								__( 'None', "ts_visual_composer_extend" )         		=> "#000000",
								__( 'Default', "ts_visual_composer_extend" )      		=> "#0084E2",
								__( 'Neutral', "ts_visual_composer_extend" )      		=> "#FFFFFF",
								__( 'Success', "ts_visual_composer_extend" )      		=> "#4CFF00",
								__( 'Warning', "ts_visual_composer_extend" )      		=> "#EA5D00",
								__( 'Error', "ts_visual_composer_extend" )        		=> "#CC0000",
							),
							"description"           	=> __( "Select the predefined backlight color for the modal popup.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "lightbox_backlight_choice", 'value' => 'predefined' ),
                            "group" 			        => "Lightbox",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Select Backlight Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "lightbox_backlight_custom",
							"value"             		=> "#000000",
							"description"       		=> __( "Define a custom backlight color for the modal popup.", "ts_visual_composer_extend" ),
							"dependency"            	=> array( 'element' => "lightbox_backlight_choice", 'value' => 'customized' ),
                            "group" 			        => "Lightbox",
						),
                        // Other Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_8",
                            "value"                     => "",
							"seperator"					=> "Other Controls",
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
							"value"             		=> "",
							"file_type"         		=> "css",
							"file_id"         			=> "ts-font-ecommerce",
							"file_path"         		=> "css/ts-font-ecommerce.css",
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),
                    ))
                );
            }
        }
	}
}
if (class_exists('WPBakeryShortCode')) {
    //class WPBakeryShortCode_TS_VCSC_WooCommerce_Grid_Basic extends WPBakeryShortCode {};
}
if (class_exists('TS_WooCommerce_Grid_Basic')) {
	$TS_WooCommerce_Grid_Basic = new TS_WooCommerce_Grid_Basic;
}