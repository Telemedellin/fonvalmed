<?php
if (!class_exists('TS_WooCommerce_Ticker_Basic')){
	class TS_WooCommerce_Ticker_Basic {
		function __construct() {
			global $VISUAL_COMPOSER_EXTENSIONS;
            if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
                add_action('init',                                  	array($this, 'TS_VCSC_WooCommerce_Ticker_Basic_Elements'), 9999999);
            } else {
                add_action('admin_init',		                    	array($this, 'TS_VCSC_WooCommerce_Ticker_Basic_Elements'), 9999999);
            }
            add_shortcode('TS_VCSC_WooCommerce_Ticker_Basic',			array($this, 'TS_VCSC_WooCommerce_Ticker_Basic_Function'));
		}
        
        // Recent Products Slider
        function TS_VCSC_WooCommerce_Ticker_Basic_Function ($atts, $content = null) {
            global $VISUAL_COMPOSER_EXTENSIONS;
			global $product;
			global $woocommerce;
            ob_start();

            wp_enqueue_script('ts-extend-newsticker');				
			wp_enqueue_style('ts-font-ecommerce');
			wp_enqueue_style('ts-font-teammatess');
			wp_enqueue_style('ts-extend-animations');
            wp_enqueue_style('ts-visual-composer-extend-front');
            wp_enqueue_script('ts-visual-composer-extend-front');
            
			extract(shortcode_atts(array(
				'selection'						=> 'recent_products',
				'category'						=> '',
				'ids'							=> '',
				'orderby'						=> 'date',
				'order'							=> 'desc',
				'products_total'				=> 12,
				'exclude_outofstock'			=> 'false',
				
				'post_type'						=> 'product',
				'date_format'					=> 'F j, Y',
				'time_format'					=> 'l, g:i A',
				
				'limit_posts'					=> 'false',
				'limit_by'						=> 'category',							// post_tag, cust_tax
				'limit_term'					=> '',
				
				'filter_menu'					=> 'true',
				'layout_menu'					=> 'true',
				'sort_menu'						=> 'false',
				'directions_menu'				=> 'false',
				
				'filter_by'						=> 'category', 							// post_tag, cust_tax
				
				'ticker_direction'				=> 'up',
				'ticker_speed'					=> 3000,
				'ticker_break'					=> 480,				
				
				'ticker_border_type'			=> '',
				'ticker_border_thick'			=> 1,
				'ticker_border_color'			=> '#ededed',
				'ticker_border_radius'			=> '',
				'ticker_auto'					=> 'true',
				'ticker_hover'					=> 'true',
				'ticker_controls'				=> 'true',				
				'ticker_symbol'					=> 'false',
				'ticker_icon'					=> '',
				'ticker_paint'					=> '#ffffff',
				'ticker_title'					=> 'true',
				'ticker_header'					=> 'Latest Products',
				'ticker_background'				=> '#D10000',
				'ticker_color'					=> '#ffffff',
				'ticker_type'					=> 'true',
				'ticker_image'					=> 'true',
				'ticker_price'					=> 'true',
				'ticker_cart'					=> 'true',
				'ticker_add_item'				=> 'Add This Item',
				'ticker_remove_item'			=> 'Remove This Item',
				'ticker_rating'					=> 'true',
				'ticker_stock'					=> 'false',
				'ticker_side'					=> 'left',
				'ticker_fixed'					=> 'false',
				'ticker_position'				=> 'top',
				'ticker_adjustment'				=> 0,
				'ticker_target'					=> '_parent',
				
				'posts_limit'					=> 25,
				
				// Rating Settings
				'rating_maximum'				=> 5,
				'rating_size'					=> 20,
				'rating_quarter'				=> 'true',
				'rating_name'					=> 'true',
				'rating_auto'					=> 'true',
				'rating_position'				=> 'top',
				'rating_rtl'					=> 'false',
				'rating_symbol'					=> 'other',
				'rating_icon'					=> 'ts-ecommerce-starfull1',
				'color_rated'					=> '#FFD800',
				'color_empty'					=> '#e3e3e3',
				'caption_show'					=> 'true',
				'caption_position'				=> 'left',
				'caption_digits'				=> '.',
				'caption_danger'				=> '#d9534f',
				'caption_warning'				=> '#f0ad4e',
				'caption_info'					=> '#5bc0de',
				'caption_primary'				=> '#428bca',
				'caption_success'				=> '#5cb85c',
				
                'margin_top'					=> 0,
                'margin_bottom'					=> 0,
                'el_id' 						=> '',
                'el_class'              		=> '',
				'css'							=> '',
			), $atts));
			
			$woo_random                    		= mt_rand(999999, 9999999);
			
			if (!empty($el_id)) {
				$woo_ticker_id			    	= $el_id;
			} else {
				$woo_ticker_id			    	= 'ts-vcsc-woocommerce-ticker-' . $woo_random;
			}
			
			$output								= '';
			
			// Check for Front End Editor
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend_edit					= 'true';
				$ticker_fixed					= 'false';
				$ticker_auto					= 'false';
			} else {
				$frontend_edit					= 'false';
				$ticker_fixed					= $ticker_fixed;
				$ticker_auto					= $ticker_auto;
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

			// Start WordPress Query
			$loop = new WP_Query($args);
			
			if ($ticker_fixed == "true") {
				$newsticker_class		= 'ts-newsticker-fixed';
				$newsticker_position	= 'ts-newsticker-' . $ticker_position;
				if ($ticker_position == "top") {
					$newsticker_style	= 'top: ' . $ticker_adjustment . 'px;';
				} else {
					$newsticker_style	= 'bottom: ' . $ticker_adjustment . 'px;';
				}
				$margin_top				= 0;
				$margin_bottom			= 0;
			} else {
				$newsticker_class		= 'ts-newsticker-standard';
				$newsticker_position	= '';
				$newsticker_style		= '';
			}
			
			if ($ticker_border_type != '') {
				$newsticker_border		= 'border: ' . $ticker_border_thick . 'px ' . $ticker_border_type . ' ' . $ticker_border_color . ';';
			} else {
				$newsticker_border		= '';
			}
			
			if ($ticker_side == "left") {
				$newsticker_elements	= 'ts-newsticker-elements-left';
			} else {
				$newsticker_elements	= 'ts-newsticker-elements-right';
			}
			
			if ($ticker_title == "false") {
				$newsticker_header		= 'left: 0;';
				$newsticker_controls	= 'right: 10px;';
			} else {
				$newsticker_header		= '';
				$newsticker_controls	= '';
			}
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_WooCommerce_Ticker_Basic', $atts);
			} else {
				$css_class	= $slider_class . ' ' . $el_class;
			}
			
			$output .= '<div id="' . $woo_ticker_id . '" class="ts-newsticker-parent ' . $css_class . '" style="margin-top: ' . $margin_top. 'px; margin-bottom: ' . $margin_bottom . ';">';
				// Create Individual Post Output
				$postCounter 	= 0;
				$postMonths 	= array();
				if ($loop->have_posts()) {
					$output .= '<div id="ts-newsticker-oneliner-' . $woo_random . '"
						class="ts-newsticker-oneliner ' . $newsticker_class . ' ' . $newsticker_position . ' ' . $ticker_border_radius . '"
						style="' . $newsticker_style . ' ' . $newsticker_border . '"
						data-ticker="ts-newsticker-ticker-' . $woo_random . '"
						data-controls="ts-newsticker-controls-' . $woo_random . '"
						data-navigation="' . $ticker_controls . '"
						data-break="' . $ticker_break . '"
						data-auto="' . $ticker_auto . '"
						data-speed="' . $ticker_speed . '"
						data-hover="' . $ticker_hover . '"
						data-direction="' . $ticker_direction . '"
						data-parent="' . $woo_ticker_id . '"
						data-side="' . $ticker_side . '"
						data-header="ts-newsticker-header-' . $woo_random . '"
						data-next="ts-newsticker-controls-next-' . $woo_random . '"
						data-prev="ts-newsticker-controls-prev-' . $woo_random . '"
						data-play="ts-newsticker-controls-play-' . $woo_random . '"
						data-stop="ts-newsticker-controls-stop-' . $woo_random . '">';						
						$output .= '<div class="ts-newsticker-elements-frame ' . $newsticker_elements . ' ' . $ticker_border_radius . '" style="">';
							// Add Navigation Controls
							$output .= '<div id="ts-newsticker-controls-' . $woo_random . '" class="ts-newsticker-controls" style="' . (($ticker_controls == "true") ? "display: block;" : "display: none;") . ' ' . $newsticker_controls . '">';
								$output .= '<div id="ts-newsticker-controls-next-' . $woo_random . '" style="' . (($ticker_controls == "true") ? "display: block;" : "display: none;") . '" class="ts-newsticker-controls-next"><span class="ts-ecommerce-arrowright5"></span></div>';
								$output .= '<div id="ts-newsticker-controls-prev-' . $woo_random . '" style="' . (($ticker_controls == "true") ? "display: block;" : "display: none;") . '" class="ts-newsticker-controls-prev"><span class="ts-ecommerce-arrowleft5"></span></div>';
								$output .= '<div id="ts-newsticker-controls-stop-' . $woo_random . '" class="ts-newsticker-controls-play" style="' . ($ticker_auto == "true" ? "display: block;" : "display: none;") . '"><span class="ts-ecommerce-pause"></span></div>';
								$output .= '<div id="ts-newsticker-controls-play-' . $woo_random . '" class="ts-newsticker-controls-play" style="' . ($ticker_auto == "true" ? "display: none;" : "display: block;") . '"><span class="ts-ecommerce-play"></span></div>';
							$output .= '</div>';
							if (($ticker_side == "left") && ($ticker_title == "true")) {
								$output .= '<div id="ts-newsticker-header-' . $woo_random . '" class="header ' . $ticker_border_radius . '" style="background: ' . $ticker_background .'; color: ' . $ticker_color . '; left: 0;">';
									if (($ticker_icon != '') && ($ticker_icon != 'transparent') && ($ticker_symbol == "true")) {
										$output .= '<i class="ts-font-icon ' . $ticker_icon . '" style="color: ' . $ticker_paint . '"></i>';
									}
									$output .= '<span>' . $ticker_header . '</span>';
								$output .= '</div>';
							}
							$output .= '<ul id="ts-newsticker-ticker-' . $woo_random . '" class="newsticker ' . $ticker_border_radius . '" style="' . $newsticker_header . '">';
								while ($loop->have_posts()) : $loop->the_post();
									$postCounter++;
									if ($postCounter < $posts_limit + 1) {
										$postAttributes = 'data-full="' . get_post_time($date_format) . '" data-time="' . get_post_time($time_format) . '" data-author="' . get_the_author() . '" data-date="' . get_post_time('U') . '" data-modified="' . get_the_modified_time('U') . '" data-title="' . get_the_title() . '" data-comments="' . get_comments_number() . '" data-id="' .  get_the_ID() . '"';
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
										// Check if Product already in Cart
										$cart_page_id		= wc_get_page_id('cart');
										$already_added		= "false";
										if (is_object($woocommerce->cart)) {
											if (sizeof($woocommerce->cart->get_cart()) > 0){												
												foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
													if ($product_id == $cart_item['product_id']) {
														$already_added = "true";
														$cart_link = apply_filters('woocommerce_cart_item_remove_link', sprintf('<a class="ts-newsticker-product-remove" href="%s" title="%s" rel="" data-id="' . $product_id . '" data-sku="' . $product_sku . '"><i style="" class="ts-newsticker-product-cart ts-woocommerce-product-cart ts-ecommerce-cross2"></i></a>', esc_url($woocommerce->cart->get_remove_url($cart_item_key)), $ticker_remove_item), $cart_item_key );
													}
												}												
											}
										}
										if ($already_added == "false") {
											$cart_link = '<span class="ts-woocommerce-link-wrapper"><a class="ts-newsticker-product-purchase" href="?add-to-cart=' . $product_id . '" title="' . $ticker_add_item . '" rel="" data-id="' . $product_id . '" data-sku="' . $product_sku . '"><i style="" class="ts-newsticker-product-cart ts-woocommerce-product-cart ts-ecommerce-cart4"></i></a></span>';
										}
										$output .= '<li ' . $postAttributes . '>';
											if ($ticker_image == 'true') {
												if ('' != get_the_post_thumbnail()) { 
													$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
													$output .= '<img class="ts-newsticker-image" src="' . $thumbnail[0] .'" style="">';
												}
											}
											$output .= '<span class="ts-woocommerce-link-wrapper"><a href="' . get_permalink() . '" target="' . $ticker_target . '">';
												$output .= get_the_title();											
											$output .= '</a></span>';
											// Product Price
											if ($ticker_price == "true") {
												$output .= '<span class="ts-newsticker-pricetag" style="">';
													if ($product->price > 0) {
														if ($product->price && isset($product->regular_price)) {
															$from 	= $product->regular_price;
															$to 	= $product->price;
															if ($from != $to) {
																$output .= '<span class="ts-newsticker-product-regular" style="float: none;"><del>' . ((is_numeric($from)) ? woocommerce_price($from) : $from) . '</del> | </span><span class="ts-newsticker-product-special" style="float: none;">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</span>';
															} else {
																$output .= '<span class="ts-newsticker-product-current" style="float: none;">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</span>';
															}
														} else {
															$to = $product->price;
															$output .= '<span class="ts-newsticker-product-current" style="float: none;">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</span>';
														}
													} else {
														$to = $product->price;
														$output .= '<span class="ts-newsticker-product-current" style="float: none;">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</span>';
													}
												$output .= '</span>';											
											}
											// Sale Ribbon
											if ($onsale == "true") {
												$output .= '<i style="position: inherit" class="ts-newsticker-product-sale ts-woocommerce-product-sale ts-ecommerce-tagsale"></i>';
											}												
											// Product Rating
											if ($ticker_rating == "true") {
												$output .= '<span class="ts-rating-stars-frame" data-auto="false" data-size="' . $rating_size . '" data-width="' . ($rating_size * 5) . '" data-rating="' . $rating_value . '" style="margin: 10px 0 0 10px; float: none;">';
													$output .= '<span class="ts-star-rating' . ($rating_rtl == "false" ? "" : "-rtl") . ' ts-rating-active " style="font-size: ' . $rating_size . 'px; line-height: ' . ($rating_size + 5) . 'px;">';
														if (($caption_show == "true") && ($caption_position == "left")) {
															$output .= '<span class="ts-rating-caption" style="margin-right: 10px;">';
																if ($rating_rtl == "false") {
																	$output .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . $rating_value . ' / ' . number_format($rating_maximum, 2, $caption_digits, '') . '</span>';
																} else {
																	$output .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . number_format($rating_maximum, 2, $caption_digits, '') . ' / ' . $rating_value . '</span>';
																}
															$output .= '</span>';
														}
														$output .= '<span class="ts-rating-container' . ($rating_rtl == "false" ? "" : "-rtl") . ' ts-rating-glyph-holder ' . $rating_class . '" style="color: ' . ($rating_rtl == "false" ? $color_empty : $color_rated) . ';">';
															$output .= '<span class="ts-rating-stars ' . $rating_class . '" style="color: ' . ($rating_rtl == "false" ? $color_rated : $color_empty) . '; width: ' . $rating_width . '%;"></span>';
														$output .= '</span>';
														if (($caption_show == "true") && ($caption_position == "right")) {
															$output .= '<span class="ts-rating-caption" style="margin-left: 10px;">';
																if ($rating_rtl == "false") {
																	$output .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . $rating_value . ' / ' . number_format($rating_maximum, 2, $caption_digits, '') . '</span>';
																} else {
																	$output .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . number_format($rating_maximum, 2, $caption_digits, '') . ' / ' . $rating_value . '</span>';
																}
															$output .= '</span>';
														}
													$output .= '</span>';
												$output .= '</span>';
											}	
											// Add to Cart Icon
											if (($ticker_cart == "true")) {
												//$output .= '<a class="ts-newsticker-product-purchase" href="?add-to-cart=' . $product_id . '" rel="nofollow" data-id="' . $product_id . '" data-sku="' . $product_sku . '"><i style="" class="ts-newsticker-product-cart ts-woocommerce-product-cart ts-ecommerce-cart4"></i></a>';
												$output .= $cart_link;
											}																		
											// Product In-Stock or Unavailable
											if ($ticker_stock == "true") {
												$output .= '<span class="ts-woocommerce-product-status" style="margin-left: 10px;">';
													if ($stock == 'false') {
														$output .= '<span class="ts-woocommerce-product-stock" style="position: inherit;"><span class="ts-woocommerce-product-outofstock">' . __('Out of Stock', 'woocommerce') . '</span></span>';							
													} else if ($stock == 'true') {
														$output .= '<span class="ts-woocommerce-product-stock" style="position: inherit;"><span class="ts-woocommerce-product-instock">' . __('In Stock', 'woocommerce') . '</span></span>';
													}
												$output .='</span>';
											}									
										$output .= '</li>';										
									}
								endwhile;
							$output .= '</ul>';
							if (($ticker_side == "right") && ($ticker_title == "true")) {
								$output .= '<div id="ts-newsticker-header-' . $woo_random . '" class="header ' . $ticker_border_radius . '" style="background: ' . $ticker_background .'; color: ' . $ticker_color . '; right: 0;">';
									if (($ticker_icon != '') && ($ticker_icon != 'transparent') && ($ticker_symbol == "true")) {
										$output .= '<i class="ts-font-icon ' . $ticker_icon . '" style="color: ' . $ticker_paint . '"></i>';
									}
									$output .= '<span>' . $ticker_header . '</span>';
								$output .= '</div>';
							}
						$output .= '</div>';
					$output .= '</div>';
				} else {
					echo __( "No products could be found.", "ts_visual_composer_extend" );
				}
			$output .= '</div>';
			
			wp_reset_postdata();
			wp_reset_query();
			echo $output;   
            
            $myvariable = ob_get_clean();
            return $myvariable;
        }
    
        // Add WooCommerce Basic Slider Elements
        function TS_VCSC_WooCommerce_Ticker_Basic_Elements() {
            global $VISUAL_COMPOSER_EXTENSIONS;
            // Add Basic Products Slider
            if (function_exists('vc_map')) {
                vc_map( array(
                    "name"                              => __( "Basic Products Ticker", "ts_visual_composer_extend" ),
                    "base"                              => "TS_VCSC_WooCommerce_Ticker_Basic",
                    "icon" 	                            => "icon-wpb-ts_vcsc_icon_commerce_ticker_basic",
                    "class"                             => "",
                    "category"                          => __( 'VC WooCommerce', "ts_visual_composer_extend" ),
                    "description"                       => __("Place a basic products ticker", "ts_visual_composer_extend"),
                    "admin_enqueue_js"                	=> "",
                    "admin_enqueue_css"               	=> "",
                    "params"                            => array(
                        // General Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_1",
                            "value"                     => "",
							"seperator"					=> "General Settings",
                            "description"               => __( "", "ts_visual_composer_extend" )
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
                            "description"               => __( "Select which products should be shown in the ticker.", "ts_visual_composer_extend" ),
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
							"max"                       => "30",
							"step"                      => "1",
							"unit"                      => '',
							"description"               => __( "Define the total number of products to be used for the ticker.", "ts_visual_composer_extend" ),
							"dependency" 				=> ""
						),
						array(
							"type" 						=> "dropdown",
							"heading" 					=> __("Order By", "ts_visual_composer_extend"),
							"param_name" 				=> "orderby",
							"value" 					=> array(
								__("Date", "ts_visual_composer_extend")				=>	'date',
								__("Title", "ts_visual_composer_extend")			=>	'title',
								__("ID", "ts_visual_composer_extend")				=>	'id',
								__("Menu Order", "ts_visual_composer_extend")		=>	'menu_order',
								__("Random", "ts_visual_composer_extend")			=>	'rand',
							),
							"admin_label"       		=> true,
							"description"       		=> __( "Select in by which order criterium the products should be sorted.", "ts_visual_composer_extend" )
						),
						array(
							"type" 						=> "dropdown",
							"heading" 					=> __("Order", "ts_visual_composer_extend"),
							"param_name" 				=> "order",
							"value" 					=> array(
								__("Descending", "ts_visual_composer_extend")		=>	'desc',
								__("Ascending", "ts_visual_composer_extend")		=>	'asc',
							),
							"admin_label"       		=> true,
							"description"       		=> __( "Select in which order the products should be sorted.", "ts_visual_composer_extend" )
						),
                        // General Settings
                        array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Total Number of Products", "ts_visual_composer_extend" ),
                            "param_name"                => "posts_limit",
                            "value"                     => "25",
                            "min"                       => "1",
                            "max"                       => "100",
                            "step"                      => "1",
                            "unit"                      => '',
							"admin_label"		        => true,
                            "description"               => __( "Select the total number of products to be retrieved from WooCommerce.", "ts_visual_composer_extend" ),
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Link Target", "ts_visual_composer_extend" ),
							"param_name"        		=> "ticker_target",
							"value"             		=> array(
								__( "Same Window", "ts_visual_composer_extend" )                    => "_parent",
								__( "New Window", "ts_visual_composer_extend" )                     => "_blank"
							),
							"description"       		=> __( "Define how the link should be opened.", "ts_visual_composer_extend" ),
							"dependency"        		=> array("element" 	=> "show_button", "value" 	=> "true"),
						),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Product Image", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_image",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the product image in the ticker.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Product Price", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_price",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the product price in the ticker.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Product Rating", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_rating",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the product rating in the ticker.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Add to Cart", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_cart",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show an add to cart icon in the ticker.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                        ),
						array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Product Stock", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_stock",
                            "value"                     => "false",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the product stock status in the ticker.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                        ),
                        // Header Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_2",
                            "value"                     => "",
							"seperator"					=> "Header Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Header Settings",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Header", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_title",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the header section for the ticker.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                            "group" 			        => "Header Settings",
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Header Position", "ts_visual_composer_extend" ),
							"param_name"        		=> "ticker_side",
							"value"             		=> array(
								__( "Left", "ts_visual_composer_extend" )                    	=> "left",
								__( "Right", "ts_visual_composer_extend" )                     	=> "right"
							),
							"description"       		=> __( "Define how the link should be opened.", "ts_visual_composer_extend" ),
							"dependency"        		=> array("element" 	=> "ticker_title", "value" 	=> "true"),
							"group" 			        => "Header Settings",
						),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Header Text", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_header",
                            "value"                     => "Latest Products",
                            "description"               => __( "Enter the text to be used in the header section.", "ts_visual_composer_extend" ),
							"dependency"        		=> array("element" 	=> "ticker_title", "value" 	=> "true"),
                            "group" 			        => "Header Settings",
                        ),
                        array(
                            "type"                      => "colorpicker",
                            "heading"                   => __( "Header Background", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_background",
                            "value"                     => "#D10000",
                            "description"               => __( "Define the background color for the ticker header.", "ts_visual_composer_extend" ),
                            "dependency"        		=> array("element" 	=> "ticker_title", "value" 	=> "true"),
                            "group" 			        => "Header Settings",
                        ),
                        array(
                            "type"                      => "colorpicker",
                            "heading"                   => __( "Header Color", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_color",
                            "value"                     => "#ffffff",
                            "description"               => __( "Define the text color for the ticker header.", "ts_visual_composer_extend" ),
                            "dependency"        		=> array("element" 	=> "ticker_title", "value" 	=> "true"),
                            "group" 			        => "Header Settings",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Add Icon to Header", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_symbol",
                            "value"                     => "false",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to add an icon to the header text.", "ts_visual_composer_extend" ),
                            "dependency"        		=> array("element" 	=> "ticker_title", "value" 	=> "true"),
                            "group" 			        => "Header Settings",
                        ),
						array(
							'type' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorType,
							'heading' 					=> __( 'Ticker Icon', 'ts_visual_composer_extend' ),
							'param_name' 				=> 'ticker_icon',
							'value'						=> '',
							'source'					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorValue,
							'settings' 					=> array(
								'emptyIcon' 					=> true,
								'type' 							=> 'extensions',
								'iconsPerPage' 					=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorPager,
								'source' 						=> $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorSource,
							),
							"description"       		=> ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector == "true" ? __( "Select the icon for your info / notice panel.", "ts_visual_composer_extend" ) : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_IconSelectorString),
							"dependency"        		=> array( 'element' => "ticker_symbol", 'value' => 'true' ),
							"group" 			        => "Header Settings",
						),
                        array(
                            "type"                      => "colorpicker",
                            "heading"                   => __( "Icon Color", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_paint",
                            "value"                     => "#ffffff",
                            "description"               => __( "Define the color for the icon.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array( 'element' => "ticker_symbol", 'value' => 'true' ),
                            "group" 			        => "Header Settings",
                        ),
                        // Ticker Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_3",
                            "value"                     => "",
							"seperator"					=> "General Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Ticker Settings",
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Ticker Direction", "ts_visual_composer_extend" ),
							"param_name"        		=> "ticker_direction",
							"value"             		=> array(
								__( "Up", "ts_visual_composer_extend" )                    		=> "up",
								__( "Down", "ts_visual_composer_extend" )                     	=> "down"
							),
							"description"       		=> __( "Define in which direction the ticker should be animated to.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 			        => "Ticker Settings",
						),						
						array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Ticker Break-Point", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_break",
                            "value"                     => "480",
                            "min"                       => "360",
                            "max"                       => "1980",
                            "step"                      => "1",
                            "unit"                      => 'px',
                            "description"               => __( "Define the the breakpoint at which the ticker should switch to a two-row layout.", "ts_visual_composer_extend" ),
                            "dependency" 				=> "",
                            "group" 			        => "Ticker Settings",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Auto-Play", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_auto",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to auto-play the ticker on page load.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                            "group" 			        => "Ticker Settings",
                        ),
						array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Auto-Play Speed", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_speed",
                            "value"                     => "3000",
                            "min"                       => "1000",
                            "max"                       => "20000",
                            "step"                      => "100",
                            "unit"                      => 'ms',
                            "description"               => __( "Define the speed used to auto-play the ticker.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "ticker_auto", "value" 	=> "true"),
                            "group" 			        => "Ticker Settings",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Stop on Hover", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_hover",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to stop the auto-play while hovering over the ticker.", "ts_visual_composer_extend" ),
                            "dependency"                => array("element" 	=> "ticker_auto", "value" 	=> "true"),
                            "group" 			        => "Ticker Settings",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Navigation", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_controls",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show left/right navigation buttons for the ticker.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                            "group" 			        => "Ticker Settings",
                        ),
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_4",
                            "value"                     => "",
							"seperator"					=> "Fixed Ticker",
                            "description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Ticker Settings",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Fixed Ticker", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_fixed",
                            "value"                     => "false",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show the ticker fixed on the screen.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
							"admin_label"		        => true,
                            "group" 			        => "Ticker Settings",
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Ticker Position", "ts_visual_composer_extend" ),
							"param_name"        		=> "ticker_position",
							"value"             		=> array(
								__( "Top", "ts_visual_composer_extend" )                    		=> "top",
								__( "Bottom", "ts_visual_composer_extend" )                     	=> "bottom"
							),
							"description"       		=> __( "Define in which direction the ticker should be animated to.", "ts_visual_composer_extend" ),
							"dependency"        		=> array("element" 	=> "ticker_fixed", "value" 	=> "true"),
							"group" 			        => "Ticker Settings",
						),
                        array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Position Adjustment", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_adjustment",
                            "value"                     => "0",
                            "min"                       => "0",
                            "max"                       => "100",
                            "step"                      => "1",
                            "unit"                      => 'px',
                            "description"               => __( "Define an optional position adjustment to acccount for things such as a fixed menu.", "ts_visual_composer_extend" ),
							"dependency"        		=> array("element" 	=> "ticker_fixed", "value" 	=> "true"),
                            "group" 			        => "Ticker Settings",
                        ),
						// Ticker Border
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_5",
                            "value"                     => "",
							"seperator"					=> "Ticker Border",
                            "description"               => __( "", "ts_visual_composer_extend" ),
                            "group" 			        => "Ticker Settings",
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Border Type", "ts_visual_composer_extend" ),
							"param_name"        		=> "ticker_border_type",
							"width"             		=> 300,
							"value"             		=> array(
								__( "None", "ts_visual_composer_extend" )                          => "",
								__( "Solid Border", "ts_visual_composer_extend" )                  => "solid",
								__( "Dotted Border", "ts_visual_composer_extend" )                 => "dotted",
								__( "Dashed Border", "ts_visual_composer_extend" )                 => "dashed",
								__( "Double Border", "ts_visual_composer_extend" )                 => "double",
								__( "Grouve Border", "ts_visual_composer_extend" )                 => "groove",
								__( "Ridge Border", "ts_visual_composer_extend" )                  => "ridge",
								__( "Inset Border", "ts_visual_composer_extend" )                  => "inset",
								__( "Outset Border", "ts_visual_composer_extend" )                 => "outset",
							),
							"description"      	 		=> __( "Select the type of border around the ticker.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
                            "group" 			        => "Ticker Settings",
						),
						array(
							"type"              		=> "nouislider",
							"heading"           		=> __( "Border Thickness", "ts_visual_composer_extend" ),
							"param_name"        		=> "ticker_border_thick",
							"value"             		=> "1",
							"min"               		=> "1",
							"max"               		=> "10",
							"step"              		=> "1",
							"unit"              		=> 'px',
							"description"       		=> __( "Define the thickness of the icon / image border.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "ticker_border_type", 'value' => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Border_Type_Values ),
                            "group" 			        => "Ticker Settings",
						),
                        array(
                            "type"                      => "colorpicker",
                            "heading"                   => __( "Border Color", "ts_visual_composer_extend" ),
                            "param_name"                => "ticker_border_color",
                            "value"                     => "#ededed",
                            "description"               => __( "Define the border color around the ticker.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array( 'element' => "ticker_border_type", 'value' => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Border_Type_Values ),
                            "group" 			        => "Ticker Settings",
                        ),
						array(
							"type"              		=> "dropdown",
							"heading"           		=> __( "Ticker Border Radius", "ts_visual_composer_extend" ),
							"param_name"        		=> "ticker_border_radius",
							"value"             		=> array(
								__( "None", "ts_visual_composer_extend" )                          => "",
								__( "Small Radius", "ts_visual_composer_extend" )                  => "ts-radius-small",
								__( "Medium Radius", "ts_visual_composer_extend" )                 => "ts-radius-medium",
								__( "Large Radius", "ts_visual_composer_extend" )                  => "ts-radius-large",
							),
							"description"       		=> __( "Define the optional radius for the ticker border.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "ticker_border_type", 'value' => $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Border_Type_Values ),
							"group" 			        => "Ticker Settings",
						),
                        // Rating Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_6",
                            "value"                     => "",
							"seperator"					=> "Rating Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Rating Settings",
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
							"group" 			        => "Rating Settings",
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
							"group" 			        => "Rating Settings",
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
							"group" 			        => "Rating Settings",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Rated Icon Fill Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "color_rated",
							"value"             		=> "#FFD800",
							"description"       		=> __( "Define the fill color for the rated icons.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 			        => "Rating Settings",
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Empty Icon Fill Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "color_empty",
							"value"             		=> "#e3e3e3",
							"description"       		=> __( "Define the fill color for the empty icons.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 			        => "Rating Settings",
						),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Show Rating Caption", "ts_visual_composer_extend" ),
							"param_name"        		=> "caption_show",
							"value"             		=> "true",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you also want to show a caption with the rating as number.", "ts_visual_composer_extend" ),
							"dependency"        		=> "",
							"group" 			        => "Rating Settings",
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
							"group" 			        => "Rating Settings",
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
							"group" 			        => "Rating Settings",
						),
                        // Other Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_7",
                            "value"                     => "",
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
							"value"             		=> "",
							"file_type"         		=> "css",
							"file_id"         			=> "ts-extend-animations",
							"file_path"         		=> "css/ts-visual-composer-extend-animations.min.css",
							"description"       		=> __( "", "ts_visual_composer_extend" )
						),
						array(
							"type"              		=> "load_file",
							"heading"           		=> __( "", "ts_visual_composer_extend" ),
							"param_name"        		=> "el_file3",
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
	class WPBakeryShortCode_TS_VCSC_WooCommerce_Ticker_Basic extends WPBakeryShortCode {};
}
// Initialize "WooCommerce Basic Slider" Class
if (class_exists('TS_WooCommerce_Ticker_Basic')) {
	$TS_WooCommerce_Ticker_Basic = new TS_WooCommerce_Ticker_Basic;
}