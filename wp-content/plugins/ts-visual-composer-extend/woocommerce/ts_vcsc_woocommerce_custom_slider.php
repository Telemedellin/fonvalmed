<?php
if (!class_exists('TS_WooCommerce_Slider_Basic')){
	class TS_WooCommerce_Slider_Basic {
		function __construct() {
			global $VISUAL_COMPOSER_EXTENSIONS;
            if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
                add_action('init',                                  	array($this, 'TS_VCSC_WooCommerce_Slider_Basic_Elements'), 9999999);
            } else {
                add_action('admin_init',		                    	array($this, 'TS_VCSC_WooCommerce_Slider_Basic_Elements'), 9999999);
            }
            add_shortcode('TS_VCSC_WooCommerce_Slider_Basic',			array($this, 'TS_VCSC_WooCommerce_Slider_Basic_Function'));
		}
        
        // Recent Products Slider
        function TS_VCSC_WooCommerce_Slider_Basic_Function ($atts, $content = null) {
            global $VISUAL_COMPOSER_EXTENSIONS;
			global $product;
			global $woocommerce;
            ob_start();

            wp_enqueue_script('ts-extend-hammer');
            wp_enqueue_script('ts-extend-nacho');
            wp_enqueue_style('ts-extend-nacho');
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_LoadFrontEndWaypoints == "true") {
				if (wp_script_is('waypoints', $list = 'registered')) {
					wp_enqueue_script('waypoints');
				} else {
					wp_enqueue_script('ts-extend-waypoints');
				}
			}
			wp_enqueue_style('ts-extend-owlcarousel2');
			wp_enqueue_script('ts-extend-owlcarousel2');				
			wp_enqueue_style('ts-font-ecommerce');
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
				
				'show_image'					=> 'true',
				'link_page'						=> 'false',
				'link_target'					=> '_parent',
				'show_rating'					=> 'true',
				'show_stock'					=> 'true',
				'show_price'					=> 'true',
				'show_link'						=> 'true',
				'show_cart'						=> 'true',
				'show_info'						=> 'true',
				'show_content'					=> 'excerpt',
				'cutoff_characters'				=> 400,
				
				'products_slide'				=> 4,
				'breakpoints_custom'			=> 'false',
				'breakpoints_items'				=> '1,2,3,4,5,6,7,8',
                'auto_height'                   => 'false',
				'page_rtl'						=> 'false',
                'auto_play'                     => 'false',
                'show_bar'                      => 'false',
                'bar_color'                     => '#dd3333',
                'show_speed'                    => 5000,
                'stop_hover'                    => 'true',
                'show_navigation'               => 'true',
				'show_dots'						=> 'true',
				'items_loop'					=> 'false',
				
				'animation_in'					=> 'ts-viewport-css-flipInX',
				'animation_out'					=> 'ts-viewport-css-slideOutDown',
				'animation_mobile'				=> 'false',
				
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
				'rating_quarter'				=> 'true',
				'rating_dynamic'				=> '',
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
				
                'margin_top'                    => 0,
                'margin_bottom'                 => 0,
                'el_id' 						=> '',
                'el_class'              		=> '',
				'css'							=> '',
			), $atts));
			
			$woo_random                    		= mt_rand(999999, 9999999);
			
			if (!empty($el_id)) {
				$woo_slider_id			    	= $el_id;
			} else {
				$woo_slider_id			    	= 'ts-vcsc-woocommerce-slider-' . $woo_random;
			}
			
			$output								= '';
			
			// Backlight Color
			if ($lightbox_backlight_choice == "predefined") {
				$lightbox_backlight_selection	= $lightbox_backlight_color;
			} else {
				$lightbox_backlight_selection	= $lightbox_backlight_custom;
			}
			
			// Check for Front End Editor
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$slider_class					= 'owl-carousel2-edit';
				$slider_message					= '<div class="ts-composer-frontedit-message">' . __( 'The slider is currently viewed in front-end edit mode; slider features are disabled for performance and compatibility reasons.', "ts_visual_composer_extend" ) . '</div>';
				$product_style					= 'width: ' . (100 / $products_slide) . '%; height: 100%; float: left; margin: 0; padding: 0;';
				$frontend_edit					= 'true';
				$description_style				= 'display: none; padding: 15px;';
			} else {
				$slider_class					= 'ts-owlslider-parent owl-carousel2';
				$slider_message					= '';
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
				'posts_per_page' 	   			=> ($frontend_edit == "true" ? $products_slide : $products_total),
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
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $slider_class . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_WooCommerce_Slider_Basic', $atts);
			} else {
				$css_class	= $slider_class . ' ' . $el_class;
			}
			
			$output .= '<div id="' . $woo_slider_id . '-container" class="ts-woocommerce-slider-container">';
				// Add Progressbar
				if (($auto_play == "true") && ($show_bar == "true") && ($frontend_edit == "false")) {
					$output .= '<div id="ts-owlslider-progressbar-' . $woo_random . '" class="ts-owlslider-progressbar-holder" style=""><div class="ts-owlslider-progressbar" style="background: ' . $bar_color . '; height: 100%; width: 0%;"></div></div>';
				}
				// Add Navigation Controls
				if ($frontend_edit == "false") {
					$output .= '<div id="ts-owlslider-controls-' . $woo_random . '" class="ts-owlslider-controls" style="' . ((($auto_play == "true") || ($show_navigation == "true")) ? "display: block;" : "display: none;") . '">';
						$output .= '<div id="ts-owlslider-controls-next-' . $woo_random . '" style="' . (($show_navigation == "true") ? "display: block;" : "display: none;") . '" class="ts-owlslider-controls-next"><span class="ts-ecommerce-arrowright5"></span></div>';
						$output .= '<div id="ts-owlslider-controls-prev-' . $woo_random . '" style="' . (($show_navigation == "true") ? "display: block;" : "display: none;") . '" class="ts-owlslider-controls-prev"><span class="ts-ecommerce-arrowleft5"></span></div>';
						if ($auto_play == "true") {
							$output .= '<div id="ts-owlslider-controls-play-' . $woo_random . '" class="ts-owlslider-controls-play active"><span class="ts-ecommerce-pause"></span></div>';
						}
					$output .= '</div>';
				}				
				// Front-Edit Message
				if ($frontend_edit == "true") {
					$output .= $slider_message;
				}
				// Add Slider
				$output .= '<div id="' . $woo_slider_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;" data-id="' . $woo_random . '" data-items="' . $products_slide . '" data-breakpointscustom="' . $breakpoints_custom . '" data-breakpointitems="' . $breakpoints_items . '" data-rtl="' . $page_rtl . '" data-loop="' . $items_loop . '" data-navigation="' . $show_navigation . '" data-dots="' . $show_dots . '" data-mobile="' . $animation_mobile . '" data-animationin="' . $animation_in . '" data-animationout="' . $animation_out . '" data-height="' . $auto_height . '" data-play="' . $auto_play . '" data-bar="' . $show_bar . '" data-color="' . $bar_color . '" data-speed="' . $show_speed . '" data-hover="' . $stop_hover . '">';
					if ($loop->have_posts()) {
						while ($loop->have_posts()) : $loop->the_post();
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
								$rating_width				= $rating_value / $rating_maximum * 100;
							} else {
								$rating_width				= 100 - ($rating_value / $rating_maximum * 100);
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
							if ((($exclude_outofstock == "true") && ($stock == "true")) || ($exclude_outofstock == "false")) {
								$output .= '<div class="ts-woocommerce-product-slide" style="' . $product_style . '" data-hash="' . $product_id . '">';
									$output .= '<div id="ts-woocommerce-product-' . $product_id . '" class="ts-image-hover-frame ' . $image_position . ' ts-trigger-hover-adjust" style="width: 100%;">';
										$output .= '<div id="ts-woocommerce-product-' . $product_id . '-counter" class="ts-fluid-wrapper " style="width: 100%; height: auto;">';
												$output .= '<div id="ts-woocommerce-product-' . $product_id . '-mask" class="ts-imagehover ' . $hover_type . ' ts-trigger-hover" data-trigger="ts-trigger-hover" data-closer="" style="width: 100%; height: auto;">';
													// Product Thumbnail
													$output .= '<div class="ts-woocommerce-product-preview">';
														$output .= '<img class="ts-woocommerce-product-image" src="' . $featured . '" alt="" />';
													$output .='</div>';
													// Sale Ribbon
													if ($onsale == "true") {
														$output .= '<div class="ts-woocommerce-product-ribbon"></div>';
														$output .= '<i style="" class="ts-woocommerce-product-icon ts-woocommerce-product-sale ts-ecommerce-tagsale"></i>';
													}
													$output .= '<div class="ts-woocommerce-product-main">';
													$output .= '<div class="mask" style="width: 100%; display: block;">';													
														$output .= '<div id="ts-woocommerce-product-' . $product_id . '-maskcontent" class="maskcontent" style="margin: 0; padding: 0;">';
															// Product Thubmnail
															if ($show_image == "true") {
																if ($link_page == "false") {
																	$output .= '<div class="ts-woocommerce-link-wrapper"><a id="" class="nch-lightbox-media no-ajaxy" data-title="' . $title . '" rel="" href="' . $featured . '" target="' . $link_target . '">';
																		$output .= '<div class="ts-woocommerce-product-thumbnail" style="background-image: url(' . $thumbnail . ');"></div>';
																	$output .= '</a></div>';
																} else {
																	$output .= '<div class="ts-woocommerce-link-wrapper"><a id="" class="" data-title="' . $title . '" rel="" href="' . get_permalink() . '" target="' . $link_target . '">';
																		$output .= '<div class="ts-woocommerce-product-thumbnail" style="background-image: url(' . $thumbnail . ');"></div>';
																	$output .= '</a></div>';
																}
															}															
															// Product Page Link
															if ($show_link == "true") {
																$output .= '<div class="ts-woocommerce-link-wrapper"><a href="' . get_permalink() . '" class="ts-woocommerce-product-link" target="' . $link_target . '"><i style="" class="ts-woocommerce-product-icon ts-woocommerce-product-view ts-ecommerce-forward"></i></a></div>';
															}
															// Product Rating
															if ($show_rating == "true") {
																$output .= '<div class="ts-rating-stars-frame" data-auto="' . $rating_auto . '" data-size="' . $rating_size . '" data-width="' . ($rating_size * 5) . '" data-rating="' . $rating_value . '" style="margin: 10px 0 0 10px; float: left;">';
																	$output .= '<div class="ts-star-rating' . ($rating_rtl == "false" ? "" : "-rtl") . ' ts-rating-active " style="font-size: ' . $rating_size . 'px; line-height: ' . ($rating_size + 5) . 'px;">';
																		if (($caption_show == "true") && ($caption_position == "left")) {
																			$output .= '<div class="ts-rating-caption" style="margin-right: 10px;">';
																				if ($rating_rtl == "false") {
																					$output .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . $rating_value . ' / ' . number_format($rating_maximum, 2, $caption_digits, '') . '</span>';
																				} else {
																					$output .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . number_format($rating_maximum, 2, $caption_digits, '') . ' / ' . $rating_value . '</span>';
																				}
																			$output .= '</div>';
																		}
																		$output .= '<div class="ts-rating-container' . ($rating_rtl == "false" ? "" : "-rtl") . ' ts-rating-glyph-holder ' . $rating_class . '" style="color: ' . ($rating_rtl == "false" ? $color_empty : $color_rated) . ';">';
																			$output .= '<div class="ts-rating-stars ' . $rating_class . '" style="color: ' . ($rating_rtl == "false" ? $color_rated : $color_empty) . '; width: ' . $rating_width . '%;"></div>';
																		$output .= '</div>';
																		if (($caption_show == "true") && ($caption_position == "right")) {
																			$output .= '<div class="ts-rating-caption" style="margin-left: 10px;">';
																				if ($rating_rtl == "false") {
																					$output .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . $rating_value . ' / ' . number_format($rating_maximum, 2, $caption_digits, '') . '</span>';
																				} else {
																					$output .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . number_format($rating_maximum, 2, $caption_digits, '') . ' / ' . $rating_value . '</span>';
																				}
																			$output .= '</div>';
																		}
																	$output .= '</div>';
																$output .= '</div>';
															}
															// Product Price
															if ($show_price == "true") {
																$output .= '<div class="ts-woocommerce-product-price">';
																	$output .= '<i style="" class="ts-woocommerce-product-icon ts-woocommerce-product-cost ts-ecommerce-pricetag3"></i>';
																	if ($product->price > 0) {
																		if ($product->price && isset($product->regular_price)) {
																			$from 	= $product->regular_price;
																			$to 	= $product->price;
																			if ($from != $to) {
																				$output .= '<div class="ts-woocommerce-product-regular"><del>' . ((is_numeric($from)) ? woocommerce_price($from) : $from) . '</del> | </div><div class="ts-woocommerce-product-special">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</div>';
																			} else {
																				$output .= '<div class="ts-woocommerce-product-current">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</div>';
																			}
																		} else {
																			$to = $product->price;
																			$output .= '<div class="ts-woocommerce-product-current">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</div>';
																		}
																	} else {
																		$to = $product->price;
																		$output .= '<div class="ts-woocommerce-product-current">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</div>';
																	}
																$output .='</div>';
															}															
															$output .= '<div class="ts-woocommerce-product-line"></div>';
															// Add to Cart Button (Icon)
															if ($show_cart == "true") {
																$output .= '<div class="ts-woocommerce-link-wrapper"><a class="ts-woocommerce-product-purchase" href="?add-to-cart=' . $product_id . '" rel="nofollow" data-id="' . $product_id . '" data-sku="' . $product_sku . '"><i style="" class="ts-woocommerce-product-icon ts-woocommerce-product-cart ts-ecommerce-cart4"></i></a></div>';
															}
															// View Description Button
															if ($show_info == "true") {
																$output .= '<div id="ts-vcsc-modal-' . $product_id . '-trigger" style="" class="ts-vcsc-modal-' . $product_id . '-parent nch-holder ts-vcsc-font-icon ts-font-icons ts-shortcode ts-icon-align-center" style="">';
																	$output .= '<a href="#ts-vcsc-modal-' . $product_id . '" class="nch-lightbox-modal" data-title="" data-open="false" data-delay="0" data-type="html" rel="" data-effect="' . $lightbox_effect . '" data-share="0" data-duration="' . $lightbox_speed . '" data-color="' . $lightbox_backlight_selection . '">';
																		$output .= '<span class="">';
																			$output .= '<i class="ts-font-icon ts-woocommerce-product-icon ts-woocommerce-product-info ts-ecommerce-information1" style=""></i>';
																		$output .= '</span>';
																	$output .= '</a>';
																$output .= '</div>';
															}
															// Product In-Stock or Unavailable
															if ($show_stock == "true") {
																$output .= '<div class="ts-woocommerce-product-status">';
																	if ($stock == 'false') {
																		$output .= '<div class="ts-woocommerce-product-stock"><span class="ts-woocommerce-product-outofstock">' . __('Out of Stock', 'woocommerce') . '</span></div>';							
																	} else if ($stock == 'true') {
																		$output .= '<div class="ts-woocommerce-product-stock"><span class="ts-woocommerce-product-instock">' . __('In Stock', 'woocommerce') . '</span></div>';
																	}
																$output .='</div>';
															}
														$output .= '</div>';
													$output .= '</div>';
													$output .= '</div>';
												$output .= '</div>';
										$output .= '</div>';
									$output .= '</div>';
									// Product Title
									$output .='<h2 class="ts-woocommerce-product-title">';
										$output .= $title;
									$output .='</h2>';
									// Product Description
									if ($show_info == "true") {
										$output .= '<div id="ts-vcsc-modal-' . $product_id . '" class="ts-modal-content nch-hide-if-javascript" style="' . $description_style . '">';
											$output .= '<div class="ts-modal-white-header"></div>';
											$output .= '<div class="ts-modal-white-frame">';
												$output .= '<div class="ts-modal-white-inner">';
													$output .= '<h2 style="border-bottom: 1px solid #eeeeee; padding-bottom: 10px; line-height: 32px; font-size: 24px; text-align: left;">' . $title . '</h2>';											
													$output .= '<div class="ts-woocommerce-lightbox-frame" style="width: 100%; height: 32px; margin: 10px auto; padding: 0;">';
														$output .= '<a style="position: inherit; margin-left: 10px; float: right;" class="ts-woocommerce-product-purchase" href="?add-to-cart=' . $product_id . '" rel="nofollow" data-id="' . $product_id . '" data-sku="' . $product_sku . '"><i style="color: #000000;" class="ts-woocommerce-product-icon ts-woocommerce-product-cart ts-ecommerce-cart4"></i></a>';
														$output .= '<a href="' . get_permalink() . '" target="_parent" style="position: inherit; margin-left: 10px; float: right;" class="ts-woocommerce-product-link"><i style="color: #000000;" class="ts-woocommerce-product-icon ts-woocommerce-product-view ts-ecommerce-forward"></i></a>';
														$output .= '<div class="ts-rating-stars-frame" data-auto="' . $rating_auto . '" data-size="' . $rating_size . '" data-width="' . ($rating_size * 5) . '" data-rating="' . $rating_value . '" style="margin: 0; float: right;">';
															$output .= '<div class="ts-star-rating' . ($rating_rtl == "false" ? "" : "-rtl") . ' ts-rating-active " style="font-size: ' . $rating_size . 'px; line-height: ' . ($rating_size + 5) . 'px;">';
																if (($caption_show == "true") && ($caption_position == "left")) {
																	$output .= '<div class="ts-rating-caption" style="margin-right: 10px;">';
																		if ($rating_rtl == "false") {
																			$output .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . $rating_value . ' / ' . number_format($rating_maximum, 2, $caption_digits, '') . '</span>';
																		} else {
																			$output .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . number_format($rating_maximum, 2, $caption_digits, '') . ' / ' . $rating_value . '</span>';
																		}
																	$output .= '</div>';
																}
																$output .= '<div class="ts-rating-container' . ($rating_rtl == "false" ? "" : "-rtl") . ' ts-rating-glyph-holder ' . $rating_class . '" style="color: ' . ($rating_rtl == "false" ? $color_empty : $color_rated) . ';">';
																	$output .= '<div class="ts-rating-stars ' . $rating_class . '" style="color: ' . ($rating_rtl == "false" ? $color_rated : $color_empty) . '; width: ' . $rating_width . '%;"></div>';
																$output .= '</div>';
																if (($caption_show == "true") && ($caption_position == "right")) {
																	$output .= '<div class="ts-rating-caption" style="margin-left: 10px;">';
																		if ($rating_rtl == "false") {
																			$output .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . $rating_value . ' / ' . number_format($rating_maximum, 2, $caption_digits, '') . '</span>';
																		} else {
																			$output .= '<span class="label ' . $caption_class . '" style="' . $caption_background . '">' . number_format($rating_maximum, 2, $caption_digits, '') . ' / ' . $rating_value . '</span>';
																		}
																	$output .= '</div>';
																}
															$output .= '</div>';
														$output .= '</div>';
														$output .= '<div class="ts-woocommerce-product-price" style="position: inherit; margin-right: 10px; float: left; width: auto; margin-top: 0;">';
															$output .= '<i style="color: #000000; margin: 0 10px 0 0;" class="ts-woocommerce-product-icon ts-woocommerce-product-cost ts-ecommerce-pricetag3"></i>';
															if ($product->price > 0) {
																if ($product->price && isset($product->regular_price)) {
																	$from 	= $product->regular_price;
																	$to 	= $product->price;
																	if ($from != $to) {
																		$output .= '<div class="ts-woocommerce-product-regular"><del style="color: #7F0000;">' . ((is_numeric($from)) ? woocommerce_price($from) : $from) . '</del> | </div><div class="ts-woocommerce-product-special">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</div>';
																	} else {
																		$output .= '<div class="ts-woocommerce-product-current">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</div>';
																	}
																} else {
																	$to = $product->price;
																	$output .= '<div class="ts-woocommerce-product-current">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</div>';
																}
															} else {
																$to = $product->price;
																$output .= '<div class="ts-woocommerce-product-current">' . ((is_numeric($to)) ? woocommerce_price($to) : $to) . '</div>';
															}
														$output .='</div>';											
													$output .='</div>';
													$output .= '<div class="ts-woocommerce-product-seperator" style="border-bottom: 1px solid #eeeeee; margin: 10px auto 20px auto; width: 100%;"></div>';	
														$output .= '<img style="width: 100%; max-width: 250px; height: auto; margin: 10px auto;" class="ts-woocommerce-product-image" src="' . $featured . '" alt="" />';												
														$output .= '<div class="ts-woocommerce-product-seperator" style="border-bottom: 1px solid #eeeeee; margin: 20px auto 10px auto; width: 100%;"></div>';													
														$output .= '<div style="margin-top: 20px; text-align: justify;">';
															if ($show_content == "excerpt") {
																$output .= get_the_excerpt();
															} else if ($show_content == "cutcharacters") {
																$content = apply_filters('the_content', get_the_content());
																$excerpt = TS_VCSC_TruncateHTML($content, $cutoff_characters, '...', false, true);
																$output .= $excerpt;
															} else if ($show_content == "complete") {
																$output .= get_the_content();
															}
														$output .='</div>';											
												$output .= '</div>';
											$output .= '</div>';
										$output .= '</div>';
									}
									
								$output .= '</div>';
							}
						endwhile;
					} else {
						echo __( "No products could be found.", "ts_visual_composer_extend" );
					}
				$output .= '</div>';
			$output .= '</div>';
			
			wp_reset_postdata();
			wp_reset_query();
			echo $output;   
            
            $myvariable = ob_get_clean();
            return $myvariable;
        }
    
        // Add WooCommerce Basic Slider Elements
        function TS_VCSC_WooCommerce_Slider_Basic_Elements() {
            global $VISUAL_COMPOSER_EXTENSIONS;
            // Add Basic Products Slider
            if (function_exists('vc_map')) {
                vc_map( array(
                    "name"                              => __( "Basic Products Slider", "ts_visual_composer_extend" ),
                    "base"                              => "TS_VCSC_WooCommerce_Slider_Basic",
                    "icon" 	                            => "icon-wpb-ts_vcsc_icon_commerce_slider_basic",
                    "class"                             => "",
                    "category"                          => __( 'VC WooCommerce', "ts_visual_composer_extend" ),
                    "description"                       => __("Place a basic products slider", "ts_visual_composer_extend"),
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
							"max"                       => "50",
							"step"                      => "1",
							"unit"                      => '',
							"description"               => __( "Define the total number of products to be used for the slider.", "ts_visual_composer_extend" ),
							"dependency" 				=> ""
						),
						array(
							"type"                      => "nouislider",
							"heading"                   => __( "Max Number of Products per Slide", "ts_visual_composer_extend" ),
							"param_name"                => "products_slide",
							"value"                     => "4",
							"min"                       => "1",
							"max"                       => "10",
							"step"                      => "1",
							"unit"                      => '',
							"description"               => __( "Define the maximum number of products per slide.", "ts_visual_composer_extend" ),
							"dependency" 				=> ""
						),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Custom Items per Breakpoint", "ts_visual_composer_extend" ),
                            "param_name"                => "breakpoints_custom",
                            "value"                     => "false",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to customize the number of products displayed per breakpoint.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Number of Items per Breakpoint", "ts_visual_composer_extend" ),
                            "param_name"                => "breakpoints_items",
                            "value"                     => "1,2,3,4,5,6,7,8",
                            "description"               => __( "Define the number of products for EACH of the 8 breakpoints, separated by comma. Breakpoints are defined as 0/360/720/960/1280/1440/1600/1920.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "breakpoints_custom", "value" 	=> "true"),
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
                        // General Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_2",
                            "value"                     => "",
							"seperator"					=> "Layout Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Layout",
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
                            "group" 			        => "Layout",
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
                            "group" 			        => "Layout",
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
                            "group" 			        => "Layout",
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
                            "group" 			        => "Layout",
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
                            "group" 			        => "Layout",
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
                            "group" 			        => "Layout",
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
                            "group" 			        => "Layout",
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
                            "group" 			        => "Layout",
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
                            "group" 			        => "Layout",
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
                            "group" 			        => "Layout",
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
                            "group" 			        => "Layout",
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
                            "group" 			        => "Layout",
                        ),
                        // Rating Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_3",
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
						// Slider Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_4",
                            "value"                     => "",
							"seperator"					=> "Slider Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Slider",
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
							"dependency"            	=> "",
                            "group" 			        => "Slider",
						),
						array(
							"type"                      => "hidden_input",
							"heading"                   => __( "In-Animation Type", "ts_visual_composer_extend" ),
							"param_name"                => "css3animations_in",
							"value"                     => "",
							"admin_label"		        => true,
							"description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
                            "group" 			        => "Slider",
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
							"dependency"            	=> "",
                            "group" 			        => "Slider",
						),
						array(
							"type"                      => "hidden_input",
							"heading"                   => __( "Out-Animation Type", "ts_visual_composer_extend" ),
							"param_name"                => "css3animations_out",
							"value"                     => "",
							"admin_label"		        => true,
							"description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
                            "group" 			        => "Slider",
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
                            "dependency"                => "",
                            "group" 			        => "Slider",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Auto-Height", "ts_visual_composer_extend" ),
                            "param_name"                => "auto_height",
                            "value"                     => "false",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want the slider to auto-adjust its height.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                            "group" 			        => "Slider",
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
                            "group" 			        => "Slider",
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
                            "description"               => __( "Switch the toggle if you want the auto-play the slider on page load.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                            "group" 			        => "Slider",
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
                            "group" 			        => "Slider",
                        ),
                        array(
                            "type"                      => "colorpicker",
                            "heading"                   => __( "Progressbar Color", "ts_visual_composer_extend" ),
                            "param_name"                => "bar_color",
                            "value"                     => "#dd3333",
                            "description"               => __( "Define the color of the animated progressbar.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "show_bar", "value" 	=> "true"),
                            "group" 			        => "Slider",
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
                            "group" 			        => "Slider",
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
                            "group" 			        => "Slider",
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Navigation", "ts_visual_composer_extend" ),
                            "param_name"                => "show_navigation",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to show left/right navigation buttons for the slider.", "ts_visual_composer_extend" ),
                            "dependency"                => "",
                            "group" 			        => "Slider",
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
							"description"               => __( "Switch the toggle if you want to show the dot navigation buttons below the slider.", "ts_visual_composer_extend" ),
							"dependency"                => "",
							"group" 			        => "Slider",
						),
						// Lightbox Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_5",
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
                            "param_name"                => "seperator_6",
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
	//class WPBakeryShortCode_TS_VCSC_WooCommerce_Slider_Basic extends WPBakeryShortCode {};
}
// Initialize "WooCommerce Basic Slider" Class
if (class_exists('TS_WooCommerce_Slider_Basic')) {
	$TS_WooCommerce_Slider_Basic = new TS_WooCommerce_Slider_Basic;
}