<?php
if (!class_exists('TS_Testimonials')){
	class TS_Testimonials {
		function __construct() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				add_action('init',                              		array($this, 'TS_VCSC_Add_Testimonial_Elements'), 9999999);
			} else {
				add_action('admin_init',		                		array($this, 'TS_VCSC_Add_Testimonial_Elements'), 9999999);
			}
            add_shortcode('TS_VCSC_Testimonial_Standalone', 			array($this, 'TS_VCSC_Testimonial_Standalone'));
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements++;
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements++;
            add_shortcode('TS_VCSC_Testimonial_Single',                	array($this, 'TS_VCSC_Testimonial_Single'));
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements++;
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements++;
            add_shortcode('TS_VCSC_Testimonial_Slider_Custom',         	array($this, 'TS_VCSC_Testimonial_Slider_Custom'));
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements++;
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements++;
            add_shortcode('TS_VCSC_Testimonial_Slider_Category',        array($this, 'TS_VCSC_Testimonial_Slider_Category'));
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements++;
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements++;			
            add_shortcode('TS_VCSC_Testimonial_Frontend_Form',        	array($this, 'TS_VCSC_Testimonial_Frontend_Form'));
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements++;
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements++;
		}
        
        // Standalone Testimonial
        function TS_VCSC_Testimonial_Standalone ($atts, $content = null) {
            global $VISUAL_COMPOSER_EXTENSIONS;
            ob_start();

            wp_enqueue_style('ts-visual-composer-extend-front');
        
            extract( shortcode_atts( array(
                'testimonial'					=> '',
                'style'							=> 'style1',
				'show_author'					=> 'true',
				'show_avatar'					=> 'true',
                'margin_top'                    => 0,
                'margin_bottom'                 => 0,
                'el_id'                         => '',
                'el_class'                      => '',
				'css'							=> '',
            ), $atts ));
            
            $output								= '';
    
            // Check for Testimonial and End Shortcode if Empty
            if (empty($testimonial)) {
                $output .= '<div style="text-align: justify; font-weight: bold; font-size: 14px; color: red;">Please select a testimonial in the element settings!</div>';
                echo $output;
                $myvariable = ob_get_clean();
                return $myvariable;
            }
	
            if (!empty($el_id)) {
                $testimonial_block_id			= $el_id;
            } else {
                $testimonial_block_id			= 'ts-vcsc-testimonial-' . mt_rand(999999, 9999999);
            }
            
            // Retrieve Testimonial Post Main Content
            $testimonial_array					= array();
            $args = array(
                'no_found_rows' 				=> 1,
                'ignore_sticky_posts' 			=> 1,
                'posts_per_page' 				=> -1,
                'post_type' 					=> 'ts_testimonials',
                'post_status' 					=> 'publish',
                'orderby' 						=> 'title',
                'order' 						=> 'ASC',
            );
            $testimonial_query = new WP_Query($args);
            if ($testimonial_query->have_posts()) {
                foreach($testimonial_query->posts as $p) {
                    if ($p->ID == $testimonial) {
                        $testimonial_data = array(
                            'author'			=> $p->post_author,
                            'name'				=> $p->post_name,
                            'title'				=> $p->post_title,
                            'id'				=> $p->ID,
                            'content'			=> $p->post_content,
                        );
                        $testimonial_array[] = $testimonial_data;
                    }
                }
            }
            wp_reset_postdata();
            
            // Build Testimonial Post Main Content
            foreach ($testimonial_array as $index => $array) {
                //$Testimonial_Author			= $testimonial_array[$index]['author'];
                //$Testimonial_Name 			= $testimonial_array[$index]['name'];
                $Testimonial_Title 				= $testimonial_array[$index]['title'];
                $Testimonial_ID 				= $testimonial_array[$index]['id'];
                $Testimonial_Content 			= $testimonial_array[$index]['content'];
                $Testimonial_Image				= wp_get_attachment_image_src(get_post_thumbnail_id($Testimonial_ID), 'full');
                if ($Testimonial_Image == false) {
                    $Testimonial_Image          = TS_VCSC_GetResourceURL('images/defaults/default_person.jpg');
                } else {
                    $Testimonial_Image          = $Testimonial_Image[0];
                }
    
                // Retrieve Testimonial Post Meta Content
                $custom_fields 						= get_post_custom($Testimonial_ID);
                $custom_fields_array				= array();
                foreach ($custom_fields as $field_key => $field_values) {
                    if (!isset($field_values[0])) continue;
                    if (in_array($field_key, array("_edit_lock", "_edit_last"))) continue;
                    if (strpos($field_key, 'ts_vcsc_testimonial_') !== false) {
                        $field_key_split 			= explode("_", $field_key);
                        $field_key_length 			= count($field_key_split) - 1;
                        $custom_data = array(
                            'group'					=> $field_key_split[$field_key_length - 1],
                            'name'					=> 'Testimonial_' . ucfirst($field_key_split[$field_key_length]),
                            'value'					=> $field_values[0],
                        );
                        $custom_fields_array[] = $custom_data;
                    }
                }
                foreach ($custom_fields_array as $index => $array) {
                    ${$custom_fields_array[$index]['name']} = $custom_fields_array[$index]['value'];
                }
                if (isset($Testimonial_Position)) {
                    $Testimonial_Position 			= $Testimonial_Position;
                } else {
                    $Testimonial_Position 			= '';
                }
                if (isset($Testimonial_Author)) {
                    $Testimonial_Author 			= $Testimonial_Author;
                } else {
                    $Testimonial_Author 			= '';
                }

				if (function_exists('vc_shortcode_custom_css_class')) {
					$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-testimonial-main clearFixMe ' . $style . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Testimonial_Standalone', $atts);
				} else {
					$css_class	= 'ts-testimonial-main clearFixMe ' . $style . ' ' . $el_class;
				}
				
                // Create Output
                if ($style == "style1") {
                    $output .= '<div id="' . $testimonial_block_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
                        $output .= '<div class="ts-testimonial-content">';
							if (($show_avatar == "true") || ($show_author == "true")) {
								$output .= '<span class="ts-testimonial-arrow"></span>';
							}
                            if (function_exists('wpb_js_remove_wpautop')){
                                $output .= '' . wpb_js_remove_wpautop(do_shortcode($Testimonial_Content), true) . '';
                            } else {
                                $output .= '' . do_shortcode($Testimonial_Content) . '';
                            }
                        $output .= '</div>';
						if (($show_avatar == "true") || ($show_author == "true")) {
							$output .= '<div class="ts-testimonial-user">';
								if ($show_avatar == "true") {
									$output .= '<div class="ts-testimonial-user-thumb"><img src="' . $Testimonial_Image . '" alt=""></div>';
								}
								if ($show_author == "true") {
									$output .= '<div class="ts-testimonial-user-name">' . $Testimonial_Author . '</div>';
									$output .= '<div class="ts-testimonial-user-meta">' . $Testimonial_Position . '</div>';
								}
							$output .= '</div>';
						}
                    $output .= '</div>';
                }
				if ($style == "style2") {
                    $output .= '<div id="' . $testimonial_block_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
                        $output .= '<div class="blockquote">';
                            $output .= '<span class="leftq quotes"></span>';
                                if (function_exists('wpb_js_remove_wpautop')){
                                    $output .= '' . wpb_js_remove_wpautop(do_shortcode($Testimonial_Content), true) . '';
                                } else {
                                    $output .= '' . do_shortcode($Testimonial_Content) . '';
                                }
                            $output .= '<span class="rightq quotes"></span>';
                        $output .= '</div>';
						if (($show_avatar == "true") || ($show_author == "true")) {
							$output .= '<div class="information">';
								if ($show_avatar == "true") {
									$output .= '<img src="' . $Testimonial_Image . '" style="width: 150px; height: auto; " width="150" height="auto" />';
								}
								if ($show_author == "true") {
									$output .= '<div class="author" style="' . ($show_avatar == "false" ? "margin-left: 15px;" : "") . '">' . $Testimonial_Author . '</div>';
									$output .= '<div class="metadata">' . $Testimonial_Position . '</div>';
								}
							$output .= '</div>';
						}
                    $output .= '</div>';
                }
				if ($style == "style3") {
                    $output .= '<div id="' . $testimonial_block_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
						if ($show_avatar == "true") {
							$output .= '<div class="photo">';
								$output .= '<img src="' . $Testimonial_Image . '" alt=""/>';
							$output .= '</div>';
						}
                        $output .= '<div class="content" style="' . ($show_avatar == "false" ? "margin-left: 0;" : "") . '">';
                            $output .= '<span class="laquo"></span>';
                                if (function_exists('wpb_js_remove_wpautop')){
                                    $output .= '' . wpb_js_remove_wpautop(do_shortcode($Testimonial_Content), true) . '';
                                } else {
                                    $output .= '' . do_shortcode($Testimonial_Content) . '';
                                }
                            $output .= '<span class="raquo"></span>';
                        $output .= '</div>';
						if ($show_author == "true") {
							$output .= '<div class="sign">';
								$output .= '<span class="author">' . $Testimonial_Author . '</span>';
								$output .= '<span class="metadata">' . $Testimonial_Position . '</span>';
							$output .= '</div>';
						}
                    $output .= '</div>';
                }
				if ($style == "style4") {
					$output .= '<div id="' . $testimonial_block_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . ($margin_bottom + 32) . 'px;">';
						if (($show_avatar == "true") || ($show_author == "true")) {
							$output .= '<div class="ts-testimonial-author-info clearfix">';
								if ($show_avatar == "true") {
									$output .= '<div class="ts-testimonial-author-image">';
										$output .= '<img src="' . $Testimonial_Image . '" alt="">';
										$output .= '<span class="ts-testimonial-author-overlay"></span>';
									$output .= '</div>';
								}
								if ($show_author == "true") {
									$output .= '<span class="ts-testimonial-author-name">' . $Testimonial_Author . '</span>';
									$output .= '<span class="ts-testimonial-author-position">' . $Testimonial_Position . '</span>';
								}
							$output .= '</div>';
						}
						$output .= '<div class="ts-testimonial-statement clearfix">';
							if (function_exists('wpb_js_remove_wpautop')){
								$output .= '' . wpb_js_remove_wpautop(do_shortcode($Testimonial_Content), true) . '';
							} else {
								$output .= '' . do_shortcode($Testimonial_Content) . '';
							}
						$output .= '</div>';			
						$output .= '<div class="ts-testimonial-bottom-arrow"></div>';
					$output .= '</div>';
				}
            
                break;
            }
            
            echo $output;
            
            $myvariable = ob_get_clean();
            return $myvariable;
        }
    
        // Single Testimonial for Custom Slider
        function TS_VCSC_Testimonial_Single($atts, $content = null) {
            global $VISUAL_COMPOSER_EXTENSIONS;
            ob_start();

            wp_enqueue_style('ts-visual-composer-extend-front');
        
            extract( shortcode_atts( array(
                'testimonial'					=> '',
                'style'							=> 'style1',
				'show_author'					=> 'true',
				'show_avatar'					=> 'true',
                'el_id'                         => '',
                'el_class'                      => '',
				'css'							=> '',
            ), $atts ));
            
            $output								= '';
			
			// Check for Front End Editor
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$frontend_edit					= 'true';
			} else {
				$frontend_edit					= 'false';
			}

            // Check for Testimonial and End Shortcode if Empty
            if (empty($testimonial)) {
                $output .= '<div style="text-align: justify; font-weight: bold; font-size: 14px; color: red;">Please select a testimonial in the element settings!</div>';
                echo $output;
                $myvariable = ob_get_clean();
                return $myvariable;
            }
			
            $testimonial_item_id				= 'ts-vcsc-testimonial-item-' . mt_rand(999999, 9999999);
            
            // Retrieve Testimonial Post Main Content
            $testimonial_array					= array();
            $category_fields 	                = array();
            $args = array(
                'no_found_rows' 				=> 1,
                'ignore_sticky_posts' 			=> 1,
                'posts_per_page' 				=> -1,
                'post_type' 					=> 'ts_testimonials',
                'post_status' 					=> 'publish',
                'orderby' 						=> 'title',
                'order' 						=> 'ASC',
            );
            $testimonial_query = new WP_Query($args);
            if ($testimonial_query->have_posts()) {
                foreach($testimonial_query->posts as $p) {
                    if ($p->ID == $testimonial) {
                        $testimonial_data = array(
                            'author'			=> $p->post_author,
                            'name'				=> $p->post_name,
                            'title'				=> $p->post_title,
                            'id'				=> $p->ID,
                            'content'			=> $p->post_content,
                        );
                        $testimonial_array[] = $testimonial_data;
                    }
                }
            }
            wp_reset_postdata();
			
            // Build Testimonial Post Main Content
            foreach ($testimonial_array as $index => $array) {
                //$Testimonial_Author			= $testimonial_array[$index]['author'];
                //$Testimonial_Name 			= $testimonial_array[$index]['name'];
                $Testimonial_Title 				= $testimonial_array[$index]['title'];
                $Testimonial_ID 				= $testimonial_array[$index]['id'];
                $Testimonial_Content 			= $testimonial_array[$index]['content'];
                $Testimonial_Image				= wp_get_attachment_image_src(get_post_thumbnail_id($Testimonial_ID), 'full');
                if ($Testimonial_Image == false) {
                    $Testimonial_Image          = TS_VCSC_GetResourceURL('images/defaults/default_person.jpg');
                } else {
                    $Testimonial_Image          = $Testimonial_Image[0];
                }
            }
			
            // Retrieve Testimonial Post Meta Content
            $custom_fields 						= get_post_custom($Testimonial_ID);
            $custom_fields_array				= array();
            foreach ($custom_fields as $field_key => $field_values) {
                if (!isset($field_values[0])) continue;
                if (in_array($field_key, array("_edit_lock", "_edit_last"))) continue;
                if (strpos($field_key, 'ts_vcsc_testimonial_') !== false) {
                    $field_key_split 			= explode("_", $field_key);
                    $field_key_length 			= count($field_key_split) - 1;
                    $custom_data = array(
                        'group'					=> $field_key_split[$field_key_length - 1],
                        'name'					=> 'Testimonial_' . ucfirst($field_key_split[$field_key_length]),
                        'value'					=> $field_values[0],
                    );
                    $custom_fields_array[] = $custom_data;
                }
            }
            foreach ($custom_fields_array as $index => $array) {
                ${$custom_fields_array[$index]['name']} = $custom_fields_array[$index]['value'];
            }
			if (isset($Testimonial_Position)) {
				$Testimonial_Position 			= $Testimonial_Position;
			} else {
				$Testimonial_Position 			= '';
			}
			if (isset($Testimonial_Author)) {
				$Testimonial_Author 			= $Testimonial_Author;
			} else {
				$Testimonial_Author 			= '';
			}
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-testimonial-main clearFixMe ' . $style . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Testimonial_Single', $atts);
            } else {
				$css_class	= 'ts-testimonial-main clearFixMe ' . $style . ' ' . $el_class;
			}
			
			// Create Output
			if ($style == "style1") {
				$output .= '<div id="' . $testimonial_item_id . '" class="' . $css_class . '" style="width: 99%; margin: 0 auto;">';
					$output .= '<div class="ts-testimonial-content">';
						if (($show_avatar == "true") || ($show_author == "true")) {
							$output .= '<span class="ts-testimonial-arrow"></span>';
						}
						if (function_exists('wpb_js_remove_wpautop')){
							$output .= '' . wpb_js_remove_wpautop(do_shortcode($Testimonial_Content), true) . '';
						} else {
							$output .= '' . do_shortcode($Testimonial_Content) . '';
						}
					$output .= '</div>';
					if (($show_avatar == "true") || ($show_author == "true")) {
						$output .= '<div class="ts-testimonial-user">';
							if ($show_avatar == "true") {
								$output .= '<div class="ts-testimonial-user-thumb"><img src="' . $Testimonial_Image . '" alt=""></div>';
							}
							if ($show_author == "true") {
								$output .= '<div class="ts-testimonial-user-name">' . $Testimonial_Author . '</div>';
								$output .= '<div class="ts-testimonial-user-meta">' . $Testimonial_Position . '</div>';
							}
						$output .= '</div>';
					}
				$output .= '</div>';
			}
			if ($style == "style2") {
				$output .= '<div id="' . $testimonial_item_id . '" class="' . $css_class . '" style="width: 99%; margin: 0 auto;">';
					$output .= '<div class="blockquote">';
						$output .= '<span class="leftq quotes"></span>';
							if (function_exists('wpb_js_remove_wpautop')){
								$output .= '' . wpb_js_remove_wpautop(do_shortcode($Testimonial_Content), true) . '';
							} else {
								$output .= '' . do_shortcode($Testimonial_Content) . '';
							}
						$output .= '<span class="rightq quotes"></span>';
					$output .= '</div>';
					if (($show_avatar == "true") || ($show_author == "true")) {
						$output .= '<div class="information">';
							if ($show_avatar == "true") {
								$output .= '<img src="' . $Testimonial_Image . '" style="width: 150px; height: auto;" width="150" height="auto" />';
							}
							if ($show_author == "true") {
								$output .= '<div class="author" style="' . ($show_avatar == "false" ? "margin-left: 15px;" : "") . '">' . $Testimonial_Author . '</div>';
								$output .= '<div class="metadata">' . $Testimonial_Position . '</div>';
							}
						$output .= '</div>';
					}
				$output .= '</div>';				
			}
			if ($style == "style3") {
				$output .= '<div id="' . $testimonial_item_id . '" class="' . $css_class . '" style="width: 99%; margin: 0 auto;">';
					if ($show_avatar == "true") {
						$output .= '<div class="photo">';
							$output .= '<img src="' . $Testimonial_Image . '" alt=""/>';
						$output .= '</div>';
					}
					$output .= '<div class="content" style="' . ($show_avatar == "false" ? "margin-left: 0;" : "") . '">';
						$output .= '<span class="laquo"></span>';
							if (function_exists('wpb_js_remove_wpautop')){
								$output .= '' . wpb_js_remove_wpautop(do_shortcode($Testimonial_Content), true) . '';
							} else {
								$output .= '' . do_shortcode($Testimonial_Content) . '';
							}
						$output .= '<span class="raquo"></span>';
					$output .= '</div>';
					if ($show_author == "true") {
						$output .= '<div class="sign">';
							$output .= '<span class="author">' . $Testimonial_Author . '</span>';
							$output .= '<span class="metadata">' . $Testimonial_Position . '</span>';
						$output .= '</div>';
					}
				$output .= '</div>';
			}
			if ($style == "style4") {
				$output .= '<div id="' . $testimonial_item_id . '" class="' . $css_class . '" style="width: 99%; margin: 0 auto 32px auto;">';
					if (($show_avatar == "true") || ($show_author == "true")) {
						$output .= '<div class="ts-testimonial-author-info clearfix">';
							if ($show_avatar == "true") {
								$output .= '<div class="ts-testimonial-author-image">';
									$output .= '<img src="' . $Testimonial_Image . '" alt="">';
									$output .= '<span class="ts-testimonial-author-overlay"></span>';
								$output .= '</div>';
							}
							if ($show_author == "true") {
								$output .= '<span class="ts-testimonial-author-name">' . $Testimonial_Author . '</span>';
								$output .= '<span class="ts-testimonial-author-position">' . $Testimonial_Position . '</span>';
							}
						$output .= '</div>';
					}
					$output .= '<div class="ts-testimonial-statement clearfix">';
						if (function_exists('wpb_js_remove_wpautop')){
							$output .= '' . wpb_js_remove_wpautop(do_shortcode($Testimonial_Content), true) . '';
						} else {
							$output .= '' . do_shortcode($Testimonial_Content) . '';
						}
					$output .= '</div>';			
					$output .= '<div class="ts-testimonial-bottom-arrow"></div>';
				$output .= '</div>';
			}
                
            echo $output;
            
            $myvariable = ob_get_clean();
            return $myvariable;
        }

        // Custom Testimonial Slider
        function TS_VCSC_Testimonial_Slider_Custom($atts, $content = null){
            global $VISUAL_COMPOSER_EXTENSIONS;
            ob_start();
    
            wp_enqueue_style('ts-extend-owlcarousel2');
            wp_enqueue_script('ts-extend-owlcarousel2');
			wp_enqueue_style('ts-font-ecommerce');
			wp_enqueue_style('ts-extend-animations');
            wp_enqueue_style('ts-visual-composer-extend-front');
            wp_enqueue_script('ts-visual-composer-extend-front');
            
            extract( shortcode_atts( array(
				'testimonials_slide'			=> 1,
                'auto_height'                   => 'true',
				'page_rtl'						=> 'false',
                'auto_play'                     => 'false',
				'show_playpause'				=> 'true',
                'show_bar'                      => 'true',				
                'bar_color'                     => '#dd3333',
                'show_speed'                    => 5000,
                'stop_hover'                    => 'true',
                'show_navigation'               => 'true',
				'show_dots'						=> 'true',
                'page_numbers'                  => 'false',
				'items_loop'					=> 'true',				
				'animation_in'					=> 'ts-viewport-css-flipInX',
				'animation_out'					=> 'ts-viewport-css-slideOutDown',
				'animation_mobile'				=> 'false',
                'margin_top'                    => 0,
                'margin_bottom'                 => 0,
                'el_id'                         => '',
                'el_class'                      => '',
				'css'							=> '',
            ), $atts ));
            
            $testimonial_random                 = mt_rand(999999, 9999999);
            
            if (!empty($el_id)) {
                $testimonial_slider_id			= $el_id;
            } else {
                $testimonial_slider_id			= 'ts-vcsc-testimonial-slider-' . $testimonial_random;
            }
			
			// Check for Front End Editor
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$slider_class					= 'owl-carousel2-edit';
				$slider_message					= '<div class="ts-composer-frontedit-message">' . __( 'The slider is currently viewed in front-end edit mode; slider features are disabled for performance and compatibility reasons.', "ts_visual_composer_extend" ) . '</div>';
				$testimonial_style				= 'width: ' . (100 / $testimonials_slide) . '%; height: 100%; float: left; margin: 0; padding: 0;';
				$frontend_edit					= 'true';
			} else {
				$slider_class					= 'ts-owlslider-parent owl-carousel2';
				$slider_message					= '';
				$testimonial_style				= '';
				$frontend_edit					= 'false';
			}
            
            $output = '';
            
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-testimonials-slider ' . $slider_class . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Testimonial_Slider_Custom', $atts);
			} else {
				$css_class	= 'ts-testimonials-slider ' . $slider_class . ' ' . $el_class;
			}
			
			$output .= '<div id="' . $testimonial_slider_id . '-container" class="ts-testimonials-slider-container" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
				// Front-Edit Message
				if ($frontend_edit == "true") {
					$output .= $slider_message;
				}
				// Add Progressbar
				if (($auto_play == "true") && ($show_bar == "true") && ($frontend_edit == "false")) {
					$output .= '<div id="ts-owlslider-progressbar-' . $testimonial_random . '" class="ts-owlslider-progressbar-holder" style=""><div class="ts-owlslider-progressbar" style="background: ' . $bar_color . '; height: 100%; width: 0%;"></div></div>';
				}
				// Add Navigation Controls
				if ($frontend_edit == "false") {
					$output .= '<div id="ts-owlslider-controls-' . $testimonial_random . '" class="ts-owlslider-controls" style="' . (((($auto_play == "true") && ($show_playpause == "true")) || ($show_navigation == "true")) ? "display: block;" : "display: none;") . '">';
						$output .= '<div id="ts-owlslider-controls-next-' . $testimonial_random . '" style="' . (($show_navigation == "true") ? "display: block;" : "display: none;") . '" class="ts-owlslider-controls-next"><span class="ts-ecommerce-arrowright5"></span></div>';
						$output .= '<div id="ts-owlslider-controls-prev-' . $testimonial_random . '" style="' . (($show_navigation == "true") ? "display: block;" : "display: none;") . '" class="ts-owlslider-controls-prev"><span class="ts-ecommerce-arrowleft5"></span></div>';
						if (($auto_play == "true") && ($show_playpause == "true")) {
							$output .= '<div id="ts-owlslider-controls-play-' . $testimonial_random . '" class="ts-owlslider-controls-play active"><span class="ts-ecommerce-pause"></span></div>';
						}
					$output .= '</div>';
				}
				// Add Slider
				$output .= '<div id="' . $testimonial_slider_id . '" class="' . $css_class . '" data-id="' . $testimonial_random . '" data-items="' . $testimonials_slide . '" data-rtl="' . $page_rtl . '" data-loop="' . $items_loop . '" data-navigation="' . $show_navigation . '" data-dots="' . $show_dots . '" data-mobile="' . $animation_mobile . '" data-animationin="' . $animation_in . '" data-animationout="' . $animation_out . '" data-height="' . $auto_height . '" data-play="' . $auto_play . '" data-bar="' . $show_bar . '" data-color="' . $bar_color . '" data-speed="' . $show_speed . '" data-hover="' . $stop_hover . '">';
					$output .= do_shortcode($content);
				$output .= '</div>';
            $output .= '</div>';
			
            echo $output;
            
            $myvariable = ob_get_clean();
            return $myvariable;
        }
        // Category Testimonial Slider
        function TS_VCSC_Testimonial_Slider_Category($atts, $content = null){
            global $VISUAL_COMPOSER_EXTENSIONS;
            ob_start();

            wp_enqueue_style('ts-extend-owlcarousel2');
            wp_enqueue_script('ts-extend-owlcarousel2');
			wp_enqueue_style('ts-font-ecommerce');
			wp_enqueue_style('ts-extend-animations');
            wp_enqueue_style('ts-visual-composer-extend-front');
            wp_enqueue_script('ts-visual-composer-extend-front');
            
            extract( shortcode_atts( array(
                'testimonialcat'                => '',
                'style'							=> 'style1',
				'show_author'					=> 'true',
				'show_avatar'					=> 'true',
				'testimonials_slide'			=> 1,
                'auto_height'                   => 'true',
				'page_rtl'						=> 'false',
                'auto_play'                     => 'false',
				'show_playpause'				=> 'true',
                'show_bar'                      => 'true',
                'bar_color'                     => '#dd3333',
                'show_speed'                    => 5000,
                'stop_hover'                    => 'true',
                'show_navigation'               => 'true',
				'show_dots'						=> 'true',
                'page_numbers'                  => 'false',
				'items_loop'					=> 'true',				
				'animation_in'					=> 'ts-viewport-css-flipInX',
				'animation_out'					=> 'ts-viewport-css-slideOutDown',
				'animation_mobile'				=> 'false',
                'margin_top'                    => 0,
                'margin_bottom'                 => 0,
                'el_id'                         => '',
                'el_class'                      => '',
				'css'							=> '',
            ), $atts ));
            
            $testimonial_random                 = mt_rand(999999, 9999999);
            
            if (!empty($el_id)) {
                $testimonial_slider_id			= $el_id;
            } else {
                $testimonial_slider_id			= 'ts-vcsc-testimonial-slider-' . $testimonial_random;
            }
            
            if (!is_array($testimonialcat)) {
                $testimonialcat 				= array_map('trim', explode(',', $testimonialcat));
            }
			
			// Check for Front End Editor
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				$slider_class					= 'owl-carousel2-edit';
				$slider_message					= '<div class="ts-composer-frontedit-message">' . __( 'The slider is currently viewed in front-end edit mode; slider features are disabled for performance and compatibility reasons.', "ts_visual_composer_extend" ) . '</div>';
				$testimonial_style				= 'width: ' . (100 / $testimonials_slide) . '%; height: 100%; float: left; margin: 0; padding: 0;';
				$frontend_edit					= 'true';
			} else {
				$slider_class					= 'ts-owlslider-parent owl-carousel2';
				$slider_message					= '';
				$testimonial_style				= '';
				$frontend_edit					= 'false';
			}
            
            $output = '';
            
            // Retrieve Testimonial Post Main Content
            $testimonial_array					= array();
            $category_fields 	                = array();
            $args = array(
                'no_found_rows' 				=> 1,
                'ignore_sticky_posts' 			=> 1,
                'posts_per_page' 				=> -1,
                'post_type' 					=> 'ts_testimonials',
                'post_status' 					=> 'publish',
                'orderby' 						=> 'title',
                'order' 						=> 'ASC',
            );
            $testimonial_query = new WP_Query($args);
            if ($testimonial_query->have_posts()) {
                foreach($testimonial_query->posts as $p) {
                    $categories = TS_VCSC_GetTheCategoryByTax($p->ID, 'ts_testimonials_category');
                    if ($categories && !is_wp_error($categories)) {
                        $category_slugs_arr     = array();
                        $arrayMatch             = 0;
                        foreach ($categories as $category) {
                            if (in_array($category->slug, $testimonialcat)) {
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
                        if (in_array("ts-testimonial-none-applied", $testimonialcat)) {
                            $arrayMatch++;
                        }
                        $category_slugs_arr[]   = '';
                        $categories_slug_str    = join(",", $category_slugs_arr);
                    }
                    if ($arrayMatch > 0) {
                        $testimonial_data = array(
                            'author'			=> $p->post_author,
                            'name'				=> $p->post_name,
                            'title'				=> $p->post_title,
                            'id'				=> $p->ID,
                            'content'			=> $p->post_content,
                            'categories'        => $categories_slug_str,
                        );
                        $testimonial_array[] 	= $testimonial_data;
                    }
                }
            }
            wp_reset_postdata();
            
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-testimonials-slider ' . $slider_class . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Testimonial_Slider_Category', $atts);
			} else {
				$css_class	= 'ts-testimonials-slider ' . $slider_class . ' ' . $el_class;
			}
			
			$output .= '<div id="' . $testimonial_slider_id . '-container" class="ts-testimonials-slider-container" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
				// Front-Edit Message
				if ($frontend_edit == "true") {
					$output .= $slider_message;
				}
				// Add Progressbar
				if (($auto_play == "true") && ($show_bar == "true") && ($frontend_edit == "false")) {
					$output .= '<div id="ts-owlslider-progressbar-' . $testimonial_random . '" class="ts-owlslider-progressbar-holder" style=""><div class="ts-owlslider-progressbar" style="background: ' . $bar_color . '; height: 100%; width: 0%;"></div></div>';
				}
				// Add Navigation Controls
				if ($frontend_edit == "false") {
					$output .= '<div id="ts-owlslider-controls-' . $testimonial_random . '" class="ts-owlslider-controls" style="' . (((($auto_play == "true") && ($show_playpause == "true")) || ($show_navigation == "true")) ? "display: block;" : "display: none;") . '">';
						$output .= '<div id="ts-owlslider-controls-next-' . $testimonial_random . '" style="' . (($show_navigation == "true") ? "display: block;" : "display: none;") . '" class="ts-owlslider-controls-next"><span class="ts-ecommerce-arrowright5"></span></div>';
						$output .= '<div id="ts-owlslider-controls-prev-' . $testimonial_random . '" style="' . (($show_navigation == "true") ? "display: block;" : "display: none;") . '" class="ts-owlslider-controls-prev"><span class="ts-ecommerce-arrowleft5"></span></div>';
						if (($auto_play == "true") && ($show_playpause == "true")) {
							$output .= '<div id="ts-owlslider-controls-play-' . $testimonial_random . '" class="ts-owlslider-controls-play active"><span class="ts-ecommerce-pause"></span></div>';
						}
					$output .= '</div>';
				}
				// Add Slider
				$output .= '<div id="' . $testimonial_slider_id . '" class="' . $css_class . '" data-id="' . $testimonial_random . '" data-items="' . $testimonials_slide . '" data-rtl="' . $page_rtl . '" data-loop="' . $items_loop . '" data-navigation="' . $show_navigation . '" data-dots="' . $show_dots . '" data-mobile="' . $animation_mobile . '" data-animationin="' . $animation_in . '" data-animationout="' . $animation_out . '" data-height="' . $auto_height . '" data-play="' . $auto_play . '" data-bar="' . $show_bar . '" data-color="' . $bar_color . '" data-speed="' . $show_speed . '" data-hover="' . $stop_hover . '">';
					// Build Testimonial Post Main Content
					foreach ($testimonial_array as $index => $array) {
						//$Testimonial_Author				= $testimonial_array[$index]['author'];
						//$Testimonial_Name 				= $testimonial_array[$index]['name'];
						$Testimonial_Title 				= $testimonial_array[$index]['title'];
						$Testimonial_ID 				= $testimonial_array[$index]['id'];
						$Testimonial_Content 			= $testimonial_array[$index]['content'];
						//$Testimonial_Category 		= $testimonial_array[$index]['categories'];
						$Testimonial_Image				= wp_get_attachment_image_src(get_post_thumbnail_id($Testimonial_ID), 'full');
						if ($Testimonial_Image == false) {
							$Testimonial_Image          = TS_VCSC_GetResourceURL('images/defaults/default_person.jpg');
						} else {
							$Testimonial_Image          = $Testimonial_Image[0];
						}
						
						// Retrieve Testimonial Post Meta Content
						$custom_fields 						= get_post_custom($Testimonial_ID);
						$custom_fields_array				= array();
						foreach ($custom_fields as $field_key => $field_values) {
							if (!isset($field_values[0])) continue;
							if (in_array($field_key, array("_edit_lock", "_edit_last"))) continue;
							if (strpos($field_key, 'ts_vcsc_testimonial_') !== false) {
								$field_key_split 			= explode("_", $field_key);
								$field_key_length 			= count($field_key_split) - 1;
								$custom_data = array(
									'group'					=> $field_key_split[$field_key_length - 1],
									'name'					=> 'Testimonial_' . ucfirst($field_key_split[$field_key_length]),
									'value'					=> $field_values[0],
								);
								$custom_fields_array[] = $custom_data;
							}
						}
						foreach ($custom_fields_array as $index => $array) {
							${$custom_fields_array[$index]['name']} = $custom_fields_array[$index]['value'];
						}
						if (isset($Testimonial_Position)) {
							$Testimonial_Position 			= $Testimonial_Position;
						} else {
							$Testimonial_Position 			= '';
						}
						if (isset($Testimonial_Author)) {
							$Testimonial_Author 			= $Testimonial_Author;
						} else {
							$Testimonial_Author 			= '';
						}
	
						if ($style == "style1") {
							$output .= '<div class="ts-testimonial-main style1 clearFixMe" style="width: 99%; margin: 0 auto;">';
								$output .= '<div class="ts-testimonial-content">';
									if (($show_avatar == "true") || ($show_author == "true")) {
										$output .= '<span class="ts-testimonial-arrow"></span>';
									}
									if (function_exists('wpb_js_remove_wpautop')){
										$output .= '' . wpb_js_remove_wpautop(do_shortcode($Testimonial_Content), true) . '';
									} else {
										$output .= '' . do_shortcode($Testimonial_Content) . '';
									}
								$output .= '</div>';
								if (($show_avatar == "true") || ($show_author == "true")) {
									$output .= '<div class="ts-testimonial-user">';
										if ($show_avatar == "true") {
											$output .= '<div class="ts-testimonial-user-thumb"><img src="' . $Testimonial_Image . '" alt=""></div>';
										}
										if ($show_author == "true") {
											$output .= '<div class="ts-testimonial-user-name">' . $Testimonial_Author . '</div>';
											$output .= '<div class="ts-testimonial-user-meta">' . $Testimonial_Position . '</div>';
										}
									$output .= '</div>';
								}
							$output .= '</div>';
						}
						if ($style == "style2") {
							$output .= '<div class="ts-testimonial-main style2 clearFixMe" style="width: 99%; margin: 0 auto;">';
								$output .= '<div class="blockquote">';
									$output .= '<span class="leftq quotes"></span>';
										if (function_exists('wpb_js_remove_wpautop')){
											$output .= '' . wpb_js_remove_wpautop(do_shortcode($Testimonial_Content), true) . '';
										} else {
											$output .= '' . do_shortcode($Testimonial_Content) . '';
										}
									$output .= '<span class="rightq quotes"></span>';
								$output .= '</div>';
								if (($show_avatar == "true") || ($show_author == "true")) {
									$output .= '<div class="information">';
										if ($show_avatar == "true") {
											$output .= '<img src="' . $Testimonial_Image . '" style="width: 150px; height: auto; " width="150" height="auto" />';
										}
										if ($show_author == "true") {
											$output .= '<div class="author" style="' . ($show_avatar == "false" ? "margin-left: 15px;" : "") . '">' . $Testimonial_Author . '</div>';
											$output .= '<div class="metadata">' . $Testimonial_Position . '</div>';
										}
									$output .= '</div>';
								}
							$output .= '</div>';
						}
						if ($style == "style3") {
							$output .= '<div class="ts-testimonial-main style3 clearFixMe" style="width: 99%; margin: 0 auto;">';
								if ($show_avatar == "true") {
									$output .= '<div class="photo">';
										$output .= '<img src="' . $Testimonial_Image . '" alt=""/>';
									$output .= '</div>';
								}
								$output .= '<div class="content" style="' . ($show_avatar == "false" ? "margin-left: 0;" : "") . '">';
									$output .= '<span class="laquo"></span>';
										if (function_exists('wpb_js_remove_wpautop')){
											$output .= '' . wpb_js_remove_wpautop(do_shortcode($Testimonial_Content), true) . '';
										} else {
											$output .= '' . do_shortcode($Testimonial_Content) . '';
										}
									$output .= '<span class="raquo"></span>';
								$output .= '</div>';
								if ($show_author == "true") {
									$output .= '<div class="sign">';
										$output .= '<span class="author">' . $Testimonial_Author . '</span>';
										$output .= '<span class="metadata">' . $Testimonial_Position . '</span>';
									$output .= '</div>';
								}
							$output .= '</div>';
						}
						if ($style == "style4") {
							$output .= '<div class="ts-testimonial-main style4 clearFixMe" style="width: 99%; margin: 0 auto 32px auto;">';
								if (($show_avatar == "true") || ($show_author == "true")) {
									$output .= '<div class="ts-testimonial-author-info clearfix">';
										if ($show_avatar == "true") {
											$output .= '<div class="ts-testimonial-author-image">';
												$output .= '<img src="' . $Testimonial_Image . '" alt="">';
												$output .= '<span class="ts-testimonial-author-overlay"></span>';
											$output .= '</div>';
										}
										if ($show_author == "true") {
											$output .= '<span class="ts-testimonial-author-name">' . $Testimonial_Author . '</span>';
											$output .= '<span class="ts-testimonial-author-position">' . $Testimonial_Position . '</span>';
										}
									$output .= '</div>';
								}
								$output .= '<div class="ts-testimonial-statement clearfix">';
									if (function_exists('wpb_js_remove_wpautop')){
										$output .= '' . wpb_js_remove_wpautop(do_shortcode($Testimonial_Content), true) . '';
									} else {
										$output .= '' . do_shortcode($Testimonial_Content) . '';
									}
								$output .= '</div>';			
								$output .= '<div class="ts-testimonial-bottom-arrow"></div>';
							$output .= '</div>';
						}
						
						foreach ($custom_fields_array as $index => $array) {
							unset(${$custom_fields_array[$index]['name']});
						}
						if ($frontend_edit == 'true') {
							break;
						}
					}
				
				$output .= '</div>';
            $output .= '</div>';
			
            echo $output;
            
            $myvariable = ob_get_clean();
            return $myvariable;
        }
	
		// Frontend Submission Form
		function TS_VCSC_Testimonial_Frontend_Form($atts, $content = null) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			ob_start();			
			
			wp_enqueue_style('dashicons');
			wp_enqueue_style('ts-visual-composer-extend-forms');
			wp_enqueue_script('ts-visual-composer-extend-forms');
			
			extract( shortcode_atts( array(
				'form_active'			=> 'true',
				'form_title'			=> 'Submit your Testimonials here!',
				'form_complete'			=> 'true',
				'post_status'			=> 'draft',
				'post_featured'			=> 'false',
				'post_allowable'		=> 'jpg,jpeg,gif,png',
				'post_category'			=> 'all', // all, single, group, none
				'category_single' 		=> '',
				'category_group'		=> '',
				'category_none'			=> 'true',
				'button_style'			=> '',
				'button_hover'			=> '',
				'button_submit'			=> 'Submit',
				'string_title'			=> 'Title:',
				'string_author'			=> 'Author:',
				'string_position'		=> 'Note:',
				'string_content'		=> 'Testimonial:',
				'string_featured'		=> 'Avatar:',
				'string_category'		=> 'Category:',
				'string_selectbox'		=> 'No Category',				
				'string_confirm'		=> 'Thank you for your submission!',
				'message_title'			=> 'Enter the title for the testimonial here.',
				'message_author'		=> 'Enter the name of the author for the testimonial here.',
				'message_position'		=> 'Enter an optional title or position for the testimonial author here.',
				'message_featured'		=> 'Upload an optional image to be used as avatar; image should be square and at least 150x150 pixels in size.',
				'message_content'		=> 'Enter the actual testimonial content here.',
				'message_category'		=> 'Select an optional category for the testimonial here.',
				'error_nonce'			=> 'Sorry, your NONCE did not verify!',
				'error_title'			=> 'Please enter a title for the testimonial!',
				'error_author'			=> 'Please enter an author for the testimonial!',
				'error_content'			=> 'Please enter the actual testimonial content!',
				'error_featured'		=> 'Please use only ONE single image file in any of the following formats:',
                'margin_top'			=> 0,
                'margin_bottom'			=> 0,
                'el_id'					=> '',
                'el_class'				=> '',
				'css'					=> '',
			), $atts ));
			
			$testimonial_random			= mt_rand(999999, 9999999);
			$output 					= '';
			
            if (!empty($el_id)) {
                $testimonial_form_id	= $el_id;
            } else {
                $testimonial_form_id	= 'ts-testimonial-frontend-submission-wrapper-' . $testimonial_random;
            }
			
			// Contingency Check
			if (($post_category == "group") && ($category_group == "")) {
				$post_category			= 'none';
				$category_single		= '';
			} else if (($post_category == "group") && ($category_none == "false")) {
				$category_check			= explode(",", $category_group);
				array_walk($category_check, 'trim');
				$category_count			= count($category_check);
				if ($category_count == 1) {
					$post_category		= 'single';
					$category_group		= '';
					$category_single	= $category_check[0];
				} else if ($category_count == 0) {
					$post_category		= 'none';
					$category_group		= '';
					$category_single	= '';
				}
			}
			
			if (isset($_POST['submit'])) {
				echo '<div id="ts-testimonial-frontend-submission-messages-' . $testimonial_random . '" class="ts-testimonial-frontend-submission-messages">';
					TS_VCSC_Testimonial_Frontend_Submit($form_active, $post_status, $post_featured, $post_allowable, $post_category, $category_single, $string_confirm, $error_nonce, $error_title, $error_author, $error_content, $error_featured);
				echo '</div>';
			};
			
			if ($form_complete == "true") {
				$form_complete			= "on";
			} else {
				$form_complete			= "off";
			}
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 				= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-testimonial-frontend-submission-wrapper clearFixMe  ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Testimonial_Frontend_Form', $atts);
			} else {
				$css_class				= 'ts-testimonial-frontend-submission-wrapper clearFixMe ' . $el_class;
			}
			
			$output .= '<div id="' . $testimonial_form_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . ';">';
				$output .= '<form id="ts-testimonial-frontend-submission-form-' . $testimonial_random . '" class="ts-testimonial-frontend-submission-form" name="ts-testimonial-frontend-submission-form" autocomplete="' . $form_complete . '" enctype="multipart/form-data" method="POST" action="">';
					$output .= '<h1>' . $form_title . '</h1>';
					$output .= '<ul>';
						// Title
						$output .= '<li>';
							$output .= '<label class="ts-testimonial-form-label-title" for="title">' . $string_title . '</label>';	 
							$output .= '<input class="ts-testimonial-form-input" type="text" id="title" value="" tabindex="1" size="20" name="title" data-required="true" data-normal="' . $message_title . '" data-error="' . $error_title . '" />';
							$output .= '<span class="ts-testimonial-form-label-text">' . $message_title . '</span>';
						$output .= '</li>';						
						// Author
						$output .= '<li>';
							$output .= '<label class="ts-testimonial-form-label-author" for="author">' . $string_author . '</label>';	 
							$output .= '<input class="ts-testimonial-form-input" type="text" id="author" value="" tabindex="2" size="20" name="author" data-required="true" data-normal="' . $message_author . '" data-error="' . $error_author . '" />';
							$output .= '<span class="ts-testimonial-form-label-text">' . $message_author . '</span>';
						$output .= '</li>';						
						// Note / Position
						$output .= '<li>';
							$output .= '<label class="ts-testimonial-form-label-position" for="position">' . $string_position . '</label>';
							$output .= '<input class="ts-testimonial-form-input" type="text" id="position" value="" tabindex="3" size="20" name="position" data-required="false" />';
							$output .= '<span class="ts-testimonial-form-label-text">' . $message_position . '</span>';
						$output .= '</li>';						 
						// Testimonial
						$output .= '<li>';
							$output .= '<label class="ts-testimonial-form-label-content" for="description">' . $string_content . '</label>';	 
							$output .= '<textarea class="ts-testimonial-form-input" id="content" tabindex="4" name="content" cols="50" rows="1" data-required="true" data-normal="' . $message_content . '" data-error="' . $error_content . '"></textarea>';
							$output .= '<span class="ts-testimonial-form-label-text">' . $message_content . '</span>';
						$output .= '</li>';
						// Featured Image
						if ($post_featured == "true") {
							$post_allowable = preg_replace('/\s+/', '', $post_allowable);
							$post_allowable = preg_replace('/\.+/', '', $post_allowable);
							$post_allowable = rtrim($post_allowable, ',');
							$output .= '<li>';
								$output .= '<label class="ts-testimonial-form-label-featured" for="description">' . $string_featured . '</label>';
								$output .= '<input class="ts-testimonial-form-input" id="avatar" type="file" name="avatar" accept="image/*" multiple="false" data-required="false" data-allowable="' . $post_allowable . '" data-normal="' . $message_featured . '" data-error="' . $error_featured . '">';
								$output .= '<span class="ts-testimonial-form-label-text">' . $message_featured . '</span>';
							$output .= '</li>';
						}
						// Category Selector
						if ($post_category == "all") {
							$terms = get_terms("ts_testimonials_category",'order_by=name&hide_empty=0&show_count=1');
							if (!empty($terms) && !is_wp_error($terms)){
								$output .= '<li>';
									$output .= '<label class="ts-testimonial-form-label-category" for="category">' . $string_category . '</label>';								
									
									$output .= '<select class="ts-testimonial-form-input" value="-1" name="category" tabindex="5" data-required="false">';
										$output .= '<option selected="selected">' . $string_selectbox . '</option>';					
										foreach ($terms as $term) {
											$output .= '<option value="' . $term->term_id . '">' . $term->name . ' (' . $term->count . ')</option>';							
										}
									$output .= '</select>';
									$output .= '<span class="ts-testimonial-form-label-text">' . $message_category . '</span>';
								$output .= '</li>';
							}
						} else if (($post_category == "group") && (!empty($category_group))) {
							$output .= '<li>';
								$output .= '<label class="ts-testimonial-form-label-category" for="category">' . $string_category . '</label>';
									$output .= '<select class="ts-testimonial-form-input" value="-1" name="category" tabindex="5" data-required="false">';
										$output .= '<option selected="selected">' . $string_selectbox . '</option>';
										$category_group = explode(",", $category_group);
										foreach ($category_group as $category) {
											$term = get_term_by("id", $category, "ts_testimonials_category");
											$output .= '<option value="' . $term->term_id . '">' . $term->name . ' (' . $term->count . ')</option>';
										}										
									$output .= '</select>';
								$output .= '<span class="ts-testimonial-form-label-text">' . $message_category . '</span>';
							$output .= '</li>';
						}
					$output .= '</ul>';
					// Submit Button
					$output .= '<input class="' . $button_style . ' ' . $button_hover . '" type="submit" value="' . $button_submit . '" tabindex="6" id="submit" name="submit" />';
					// NONCE + Action
					$output .= '<input type="hidden" name="action" value="ts_testimonials" />';
					$output .= wp_nonce_field('ts-testimonial-submission', 'ts-testimonial-submission-nonce', false);
				$output .= '</form>';
			$output .= '</div>';
			
			echo $output;
	
			$myvariable = ob_get_clean();
			return $myvariable;
		}		
		
		// Add Testimonial Elements
        function TS_VCSC_Add_Testimonial_Elements() {
			global $VISUAL_COMPOSER_EXTENSIONS;
            // Add Standalone Testimonial
            if (function_exists('vc_map')) {
                vc_map( array(
                    "name"                              => __( "TS Single Testimonial", "ts_visual_composer_extend" ),
                    "base"                              => "TS_VCSC_Testimonial_Standalone",
                    "icon" 	                            => "icon-wpb-ts_vcsc_testimonial_standalone",
                    "class"                             => "",
                    "category"                          => __( 'VC Extensions', "ts_visual_composer_extend" ),
                    "description"                       => __("Place a single testimonial element", "ts_visual_composer_extend"),
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
                    "params"                            => array(
                        // Testimonial Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_1",
							"value"						=> "",
                            "seperator"					=> "Main Content",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
                        array(
                            "type"                      => "custompost",
                            "heading"                   => __( "Testimonial", "ts_visual_composer_extend" ),
                            "param_name"                => "testimonial",
                            "posttype"                  => "ts_testimonials",
                            "posttaxonomy"              => "ts_testimonials_category",
							"taxonomy"              	=> "ts_testimonials_category",
							"postsingle"				=> "Testimonial",
							"postplural"				=> "Testimonials",
							"postclass"					=> "testimonial",
                            "value"                     => "",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
                        array(
                            "type"                      => "hidden_input",
                            "heading"                   => __( "Testimonial Name", "ts_visual_composer_extend" ),
                            "param_name"                => "custompost_name",
                            "value"                     => "",
                            "admin_label"		        => true,
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
                        // Testimonial Design
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_2",
							"value"						=> "",
                            "seperator"					=> "Testimonial Style",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
                        array(
                            "type"                      => "dropdown",
                            "heading"                   => __( "Design", "ts_visual_composer_extend" ),
                            "param_name"                => "style",
                            "value"                     => array(
                                __( 'Style 1', "ts_visual_composer_extend" )          => "style1",
                                __( 'Style 2', "ts_visual_composer_extend" )          => "style2",
                                __( 'Style 3', "ts_visual_composer_extend" )          => "style3",
								__( 'Style 4', "ts_visual_composer_extend" )          => "style4",
                            ),
                            "description"               => __( "", "ts_visual_composer_extend" ),
                            "admin_label"               => true,
                            "dependency"                => ""
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Autor Name", "ts_visual_composer_extend" ),
                            "param_name"                => "show_author",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to show the author name for the testimonial.", "ts_visual_composer_extend" ),
                            "dependency"                => ""
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Avatar", "ts_visual_composer_extend" ),
                            "param_name"                => "show_avatar",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to show the user avatar for the testimonial.", "ts_visual_composer_extend" ),
                            "dependency"                => ""
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
                    ))
                );
            }
            // Add Single Testimonial (for Custom Slider)
            if (function_exists('vc_map')) {
                vc_map(array(
                    "name"                           	=> __("TS Testimonial Slide", "ts_visual_composer_extend"),
                    "base"                           	=> "TS_VCSC_Testimonial_Single",
                    "class"                          	=> "",
                    "icon"                           	=> "icon-wpb-ts_vcsc_testimonial",
                    "category"                       	=> __("VC Extensions", "ts_visual_composer_extend"),
                    "content_element"                	=> true,
                    "as_child"                       	=> array('only' => 'TS_VCSC_Testimonial_Slider_Custom'),
                    "description"                    	=> __("Add a testimonial slide element", "ts_visual_composer_extend"),
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
                    "params"                         	=> array(
                        // Testimonial Select
                        array(
                            "type"                  	=> "seperator",
                            "heading"               	=> __( "", "ts_visual_composer_extend" ),
                            "param_name"            	=> "seperator_1",
							"value"						=> "",
                            "seperator"					=> "Selections",
                            "description"           	=> __( "", "ts_visual_composer_extend" )
                        ),
                        array(
                            "type"                      => "custompost",
                            "heading"                   => __( "Testimonial", "ts_visual_composer_extend" ),
                            "param_name"                => "testimonial",
                            "posttype"                  => "ts_testimonials",
                            "posttaxonomy"              => "ts_testimonials_category",
							"taxonomy"              	=> "ts_testimonials_category",
							"postsingle"				=> "Testimonial",
							"postplural"				=> "Testimonials",
							"postclass"					=> "testimonial",
                            "value"                     => "",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
                        array(
                            "type"                  	=> "hidden_input",
                            "heading"               	=> __( "Testimonial", "ts_visual_composer_extend" ),
                            "param_name"            	=> "custompost_name",
                            "value"                 	=> "",
                            "admin_label"		    	=> true,
                            "description"           	=> __( "", "ts_visual_composer_extend" )
                        ),
                        // Testimonial Design
                        array(
                            "type"                  	=> "seperator",
                            "heading"               	=> __( "", "ts_visual_composer_extend" ),
                            "param_name"            	=> "seperator_2",
							"value"						=> "",
                            "seperator"					=> "Testimonial Style",
                            "description"           	=> __( "", "ts_visual_composer_extend" )
                        ),
                        array(
                            "type"                  	=> "dropdown",
                            "heading"               	=> __( "Design", "ts_visual_composer_extend" ),
                            "param_name"            	=> "style",
                            "value"             => array(
                                __( 'Style 1', "ts_visual_composer_extend" )          => "style1",
                                __( 'Style 2', "ts_visual_composer_extend" )          => "style2",
                                __( 'Style 3', "ts_visual_composer_extend" )          => "style3",
								__( 'Style 4', "ts_visual_composer_extend" )          => "style4",
                            ),
                            "description"           	=> __( "", "ts_visual_composer_extend" ),
                            "admin_label"           	=> true,
                            "dependency"            	=> ""
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Autor Name", "ts_visual_composer_extend" ),
                            "param_name"                => "show_author",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to show the author name for the testimonial.", "ts_visual_composer_extend" ),
                            "dependency"                => ""
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Avatar", "ts_visual_composer_extend" ),
                            "param_name"                => "show_avatar",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to show the user avatar for the testimonial.", "ts_visual_composer_extend" ),
                            "dependency"                => ""
                        ),
                        // Load Custom CSS/JS File
                        array(
                            "type"                  	=> "load_file",
                            "heading"               	=> __( "", "ts_visual_composer_extend" ),
                            "param_name"            	=> "el_file",
                            "value"                 	=> "",
                            "file_type"             	=> "js",
                            "file_path"             	=> "js/ts-visual-composer-extend-element.min.js",
                            "description"           	=> __( "", "ts_visual_composer_extend" )
                        ),
                    ))
                );
            }
            // Add Testimonials Slider 1 (Custom Build)
            if (function_exists('vc_map')) {
                vc_map(array(
					"name"                              => __("TS Testimonials Slider 1", "ts_visual_composer_extend"),
					"base"                              => "TS_VCSC_Testimonial_Slider_Custom",
					"class"                             => "",
					"icon"                              => "icon-wpb-ts_vcsc_testimonial_slider_custom",
					"category"                          => __("VC Extensions", "ts_visual_composer_extend"),
					"as_parent"                         => array('only' => 'TS_VCSC_Testimonial_Single'),
					"description"                       => __("Build a custom Testimonial Slider", "ts_visual_composer_extend"),
					"controls" 							=> "full",
					"content_element"                   => true,
					"is_container" 						=> true,
					"container_not_allowed" 			=> false,
					"show_settings_on_create"           => true,
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
					"params"                            => array(
                        // Slider Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_1",
							"value"						=> "",
                            "seperator"					=> "Slider Settings",
                            "description"               => __( "", "ts_visual_composer_extend" )
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
						),
						array(
							"type"                      => "hidden_input",
							"heading"                   => __( "In-Animation Type", "ts_visual_composer_extend" ),
							"param_name"                => "css3animations_in",
							"value"                     => "",
							"admin_label"		        => true,
							"description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
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
						),
						array(
							"type"                      => "hidden_input",
							"heading"                   => __( "Out-Animation Type", "ts_visual_composer_extend" ),
							"param_name"                => "css3animations_out",
							"value"                     => "",
							"admin_label"		        => true,
							"description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
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
                            "dependency"                => ""
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
							"dependency"                => ""
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
                            "dependency"                => ""
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
                            "dependency" 				=> array("element" 	=> "auto_play", "value" => "true"),
                        ),
                        array(
                            "type"                      => "colorpicker",
                            "heading"                   => __( "Progressbar Color", "ts_visual_composer_extend" ),
                            "param_name"                => "bar_color",
                            "value"                     => "#dd3333",
                            "description"               => __( "Define the color of the animated progressbar.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "auto_play", "value" 	=> "true"),
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
                            "dependency"                => array( 'element' => "auto_play", 'value' => 'true' )
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
                            "dependency"                => ""
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
							"dependency"                => ""
						),
                        // Other Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_2",
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
                    ),
                    "js_view"                           => 'VcColumnView'
                ));
            }
            // Add Testimonials Slider 2 (by Categories)
            if (function_exists('vc_map')) {
                vc_map( array(
                   "name"                               => __("TS Testimonials Slider 2", "ts_visual_composer_extend"),
                   "base"                               => "TS_VCSC_Testimonial_Slider_Category",
                   "class"                              => "",
                   "icon"                               => "icon-wpb-ts_vcsc_testimonial_slider_category",
                   "category"                           => __("VC Extensions", "ts_visual_composer_extend"),
                   "description"                        => __("Place a Testimonial Slider (by Category)", "ts_visual_composer_extend"),
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
                   "params"                             => array(
                        // Content Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_1",
							"value"						=> "",
                            "seperator"					=> "Content Settings",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
                        array(
                            "type"                      => "custompostcat",
                            "heading"                   => __( "Testimonial Categories", "ts_visual_composer_extend" ),
                            "param_name"                => "testimonialcat",
                            "posttype"                  => "ts_testimonials",
                            "posttaxonomy"              => "ts_testimonials_category",
							"taxonomy"              	=> "ts_testimonials_category",
							"postsingle"				=> "Testimonial",
							"postplural"				=> "Testimonials",
							"postclass"					=> "testimonial",
                            "value"                     => "",
                            "description"               => __( "Please select the testimonial categories you want to use for the slider.", "ts_visual_composer_extend" )
                        ),
                        array(
                            "type"                      => "dropdown",
                            "heading"                   => __( "Design", "ts_visual_composer_extend" ),
                            "param_name"                => "style",
                            "value"                     => array(
                                __( 'Style 1', "ts_visual_composer_extend" )          => "style1",
                                __( 'Style 2', "ts_visual_composer_extend" )          => "style2",
                                __( 'Style 3', "ts_visual_composer_extend" )          => "style3",
								__( 'Style 4', "ts_visual_composer_extend" )          => "style4",
                            ),
                            "description"               => __( "", "ts_visual_composer_extend" ),
                            "admin_label"               => true,
                            "dependency"                => ""
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Autor Name", "ts_visual_composer_extend" ),
                            "param_name"                => "show_author",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to show the author name for the testimonial.", "ts_visual_composer_extend" ),
                            "dependency"                => ""
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Show Avatar", "ts_visual_composer_extend" ),
                            "param_name"                => "show_avatar",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to show the user avatar for the testimonial.", "ts_visual_composer_extend" ),
                            "dependency"                => ""
                        ),
						// Slider Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_2",
							"value"						=> "",
                            "seperator"					=> "Slider Settings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
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
							"dependency"            	=> "",
							"group" 			        => "Slider Settings",
						),
						array(
							"type"                      => "hidden_input",
							"heading"                   => __( "In-Animation Type", "ts_visual_composer_extend" ),
							"param_name"                => "css3animations_in",
							"value"                     => "",
							"admin_label"		        => true,
							"description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
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
							"dependency"            	=> "",
							"group" 			        => "Slider Settings",
						),
						array(
							"type"                      => "hidden_input",
							"heading"                   => __( "Out-Animation Type", "ts_visual_composer_extend" ),
							"param_name"                => "css3animations_out",
							"value"                     => "",
							"admin_label"		        => true,
							"description"               => __( "", "ts_visual_composer_extend" ),
							"dependency"            	=> "",
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
                            "dependency"                => "",
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
							"dependency"                => "Slider Settings"
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
							"group" 			        => "Slider Settings",
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
                            "dependency" 				=> array("element" 	=> "auto_play", "value" 	=> "true"),
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
							"group" 			        => "Slider Settings",
                        ),
                        array(
                            "type"                      => "colorpicker",
                            "heading"                   => __( "Progressbar Color", "ts_visual_composer_extend" ),
                            "param_name"                => "bar_color",
                            "value"                     => "#dd3333",
                            "description"               => __( "Define the color of the animated progressbar.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "auto_play", "value" 	=> "true"),
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
                            "description"               => __( "Switch the toggle if you want the stop the auto-play while hovering over the slider.", "ts_visual_composer_extend" ),
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
                            "dependency"                => "",
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
							"dependency"                => "Slider Settings"
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
                    ),
                ));
            }

			// Add Testimonial Frontend Form
			if (function_exists('vc_map')) {
                vc_map( array(
                    "name"                              => __( "TS Testimonial Form", "ts_visual_composer_extend" ),
                    "base"                              => "TS_VCSC_Testimonial_Frontend_Form",
                    "icon" 	                            => "icon-wpb-ts_vcsc_testimonial_form",
                    "class"                             => "",
                    "category"                          => __( 'VC Extensions', "ts_visual_composer_extend" ),
                    "description"                       => __("Place a testimonial frontend submission form", "ts_visual_composer_extend"),
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
                    "params"                            => array(
                        // Testimonial Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_1",
							"value"						=> "",
                            "seperator"					=> "General Settings",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),		
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Live Form", "ts_visual_composer_extend" ),
                            "param_name"                => "form_active",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to have the form actually submit testimonials; otherwise, the submission will only be simulated.", "ts_visual_composer_extend" ),
                            "dependency"                => ""
                        ),						
                        array(
                            "type"                      => "dropdown",
                            "heading"                   => __( "Post Status", "ts_visual_composer_extend" ),
                            "param_name"                => "post_status",
                            "value"                     => array(
                                __( 'Draft', "ts_visual_composer_extend" )          					=> "draft",
                                __( 'Publish', "ts_visual_composer_extend" )							=> "publish",
								__( 'Pending', "ts_visual_composer_extend" )							=> "pending",
                            ),
                            "description"               => __( "Define what status should be used when sending the post to WordPress.", "ts_visual_composer_extend" ),
                            "admin_label"               => true,
                            "dependency" 				=> array("element" 	=> "form_active", "value" => "true"),
                        ),						
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Form Auto-Complete", "ts_visual_composer_extend" ),
                            "param_name"                => "form_complete",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to the form to allow the browser auto-complete feature.", "ts_visual_composer_extend" ),
                            "dependency"                => ""
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Form Title", "ts_visual_composer_extend" ),
                            "param_name"                => "form_title",
                            "value"                     => "Submit your Testimonials here!",
                            "description"               => __( "Enter a title to be used for the submission form.", "ts_visual_composer_extend" ),
                        ),
						// Featured / Avatar Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_2",
							"value"						=> "",
                            "seperator"					=> "Avatar Settings",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Allow Avatar Upload", "ts_visual_composer_extend" ),
                            "param_name"                => "post_featured",
                            "value"                     => "false",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want the user to upload an avatar image for the testimonial (featured image).", "ts_visual_composer_extend" ),
                            "dependency"                => ""
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Allowable Formats", "ts_visual_composer_extend" ),
                            "param_name"                => "post_allowable",
                            "value"                     => "jpg,jpeg,gif,png",
							"dependency" 				=> array("element" 	=> "post_featured", "value" => "true"),
                            "description"               => __( "Enter the allowed image format extensions; separate each format by comma.", "ts_visual_composer_extend" ),
                        ),
						// Category Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_3",
							"value"						=> "",
                            "seperator"					=> "Category Settings",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),	
                        array(
                            "type"                      => "dropdown",
                            "heading"                   => __( "Category Options", "ts_visual_composer_extend" ),
                            "param_name"                => "post_category",
                            "value"                     => array(
                                __( 'Allow All Categories', "ts_visual_composer_extend" )          		=> "all",
                                __( 'Allow Group of Categories', "ts_visual_composer_extend" )			=> "group",
                                __( 'Always Assign Same Category', "ts_visual_composer_extend" )		=> "single",
								__( 'Do Not Use Categories', "ts_visual_composer_extend" )          	=> "none",
                            ),
                            "description"               => __( "Define if and what categories the submitting user can use for the testimonial.", "ts_visual_composer_extend" ),
                            "admin_label"               => true,
                            "dependency"                => ""
                        ),
                        array(
                            "type"              	    => "switch_button",
                            "heading"                   => __( "Allow 'No Category' Option", "ts_visual_composer_extend" ),
                            "param_name"                => "category_none",
                            "value"                     => "true",
                            "on"					    => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"					    => __( 'No', "ts_visual_composer_extend" ),
                            "style"					    => "select",
                            "design"				    => "toggle-light",
                            "description"               => __( "Switch the toggle if you also want to provide a 'No Category' option.", "ts_visual_composer_extend" ),
                            "dependency" 				=> array("element" 	=> "post_category", "value" => array("all", "group")),
                        ),
                        array(
                            "type"                      => "custompostcatid",
                            "heading"                   => __( "Testimonial Categories", "ts_visual_composer_extend" ),
                            "param_name"                => "category_group",
                            "posttype"                  => "ts_testimonials",
                            "posttaxonomy"              => "ts_testimonials_category",
							"taxonomy"              	=> "ts_testimonials_category",
							"postsingle"				=> "Testimonial",
							"postplural"				=> "Testimonials",
							"postclass"					=> "testimonial",
							"postmulti"					=> "true",
							"postempty"					=> "true",
                            "value"                     => "",							
                            "description"               => __( "Please select the testimonial categories that should be available to the submitting user.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "post_category", "value" => "group"),
                        ),
                        array(
                            "type"                      => "custompostcatid",
                            "heading"                   => __( "Testimonial Category", "ts_visual_composer_extend" ),
                            "param_name"                => "category_single",
                            "posttype"                  => "ts_testimonials",
                            "posttaxonomy"              => "ts_testimonials_category",
							"taxonomy"              	=> "ts_testimonials_category",
							"postsingle"				=> "Testimonial",
							"postplural"				=> "Testimonials",
							"postclass"					=> "testimonial",
							"postmulti"					=> "false",
							"postempty"					=> "true",
                            "value"                     => "",							
                            "description"               => __( "Please select the category that all testimonials should be assigned to.", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "post_category", "value" => "single"),
                        ),						
						// Title Text Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_4",
							"value"						=> "",
                            "seperator"					=> "Title Input",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Title Label", "ts_visual_composer_extend" ),
                            "param_name"                => "string_title",
                            "value"                     => "Title:",
                            "description"               => "",
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Title Message", "ts_visual_composer_extend" ),
                            "param_name"                => "message_title",
                            "value"                     => "Enter the title for the testimonial here.",
                            "description"               => "",
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Title Error", "ts_visual_composer_extend" ),
                            "param_name"                => "error_title",
                            "value"                     => "Please enter a title for the testimonial!",
                            "description"               => "",
							"group" 			        => "Text Settings",
                        ),
						// Author Text Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_5",
							"value"						=> "",
                            "seperator"					=> "Author Input",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Author Label", "ts_visual_composer_extend" ),
                            "param_name"                => "string_author",
                            "value"                     => "Author:",
                            "description"               => "",
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Author Message", "ts_visual_composer_extend" ),
                            "param_name"                => "message_author",
                            "value"                     => "Enter the name of the author for the testimonial here.",
                            "description"               => "",
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Author Error", "ts_visual_composer_extend" ),
                            "param_name"                => "error_author",
                            "value"                     => "Please enter an author for the testimonial!",
                            "description"               => "",							
							"group" 			        => "Text Settings",
                        ),
						// Note Text Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_6",
							"value"						=> "",
                            "seperator"					=> "Note Input",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Note Label", "ts_visual_composer_extend" ),
                            "param_name"                => "string_position",
                            "value"                     => "Note:",
                            "description"               => "",
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Note Message", "ts_visual_composer_extend" ),
                            "param_name"                => "message_position",
                            "value"                     => "Enter an optional title or position for the testimonial author here.",
                            "description"               => "",
							"group" 			        => "Text Settings",
                        ),
						// Testimonial Text Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_7",
							"value"						=> "",
                            "seperator"					=> "Testimonial Input",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Testimonial Label", "ts_visual_composer_extend" ),
                            "param_name"                => "string_content",
                            "value"                     => "Testimonial:",
                            "description"               => "",
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Testimonial Message", "ts_visual_composer_extend" ),
                            "param_name"                => "message_content",
                            "value"                     => "Enter the actual testimonial content here.",
                            "description"               => "",
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Testimonial Error", "ts_visual_composer_extend" ),
                            "param_name"                => "error_content",
                            "value"                     => "Please enter the actual testimonial content!",
                            "description"               => "",
							"group" 			        => "Text Settings",
                        ),
						// Featured Image Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_8",
							"value"						=> "",
                            "seperator"					=> "Avatar Input",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "post_featured", "value" => "true"),
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Avatar Upload", "ts_visual_composer_extend" ),
                            "param_name"                => "string_featured",
                            "value"                     => "Avatar:",
                            "description"               => "",
							"dependency" 				=> array("element" 	=> "post_featured", "value" => "true"),
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Avatar Message", "ts_visual_composer_extend" ),
                            "param_name"                => "message_featured",
                            "value"                     => "Upload an optional image to be used as avatar; image should be square and at least 150x150 pixels in size.",
                            "description"               => "",
							"dependency" 				=> array("element" 	=> "post_featured", "value" => "true"),
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Avatar Error", "ts_visual_composer_extend" ),
                            "param_name"                => "error_featured",
                            "value"                     => "Please use only ONE single image file in any of the following formats:",
                            "description"               => "",
							"dependency" 				=> array("element" 	=> "post_featured", "value" => "true"),
							"group" 			        => "Text Settings",
                        ),
						// Category Text Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_9",
							"value"						=> "",
                            "seperator"					=> "Category Input",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"dependency" 				=> array("element" 	=> "post_category", "value" => array("all", "group")),
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Category Input", "ts_visual_composer_extend" ),
                            "param_name"                => "string_category",
                            "value"                     => "Category:",
                            "description"               => "",
							"dependency" 				=> array("element" 	=> "post_category", "value" => array("all", "group")),
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: No Category", "ts_visual_composer_extend" ),
                            "param_name"                => "string_selectbox",
                            "value"                     => "No Category",
                            "description"               => "",
							"dependency" 				=> array("element" 	=> "post_category", "value" => array("all", "group")),
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Category Message", "ts_visual_composer_extend" ),
                            "param_name"                => "message_category",
                            "value"                     => "Select an optional category for the testimonial here.",
                            "description"               => "",
							"dependency" 				=> array("element" 	=> "post_category", "value" => array("all", "group")),
							"group" 			        => "Text Settings",
                        ),
						// Other Text Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_10",
							"value"						=> "",
                            "seperator"					=> "Other Text Strings",
                            "description"               => __( "", "ts_visual_composer_extend" ),
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Submit Button", "ts_visual_composer_extend" ),
                            "param_name"                => "button_submit",
                            "value"                     => "Submit",
                            "description"               => "",
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: Submission Success", "ts_visual_composer_extend" ),
                            "param_name"                => "string_confirm",
                            "value"                     => "Thank you for your submission!",
                            "description"               => "",
							"group" 			        => "Text Settings",
                        ),
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Text: NONCE Error", "ts_visual_composer_extend" ),
                            "param_name"                => "error_nonce",
                            "value"                     => "Sorry, your NONCE did not verify!",
                            "description"               => "",
							"group" 			        => "Text Settings",
                        ),
                        // Other Settings
                        array(
                            "type"                      => "seperator",
                            "heading"                   => __( "", "ts_visual_composer_extend" ),
                            "param_name"                => "seperator_11",
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

// Register Container and Child Shortcode with Visual Composer
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_TS_VCSC_Testimonial_Slider_Custom extends WPBakeryShortCodesContainer {};
}
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_TS_VCSC_Testimonial_Standalone extends WPBakeryShortCode {};
    class WPBakeryShortCode_TS_VCSC_Testimonial_Single extends WPBakeryShortCode {};
	class WPBakeryShortCode_TS_VCSC_Testimonial_Slider_Category extends WPBakeryShortCode {};
}

// Initialize "TS Testimonials" Class
if (class_exists('TS_Testimonials')) {
	$TS_Testimonials = new TS_Testimonials;
}

// Function to Process Form Submission
if (!function_exists('TS_VCSC_Testimonial_Frontend_Submit')){
	function TS_VCSC_Testimonial_Frontend_Submit($form_active, $post_status, $post_featured, $post_allowable, $post_category, $category_single, $string_confirm, $error_nonce, $error_title, $error_author, $error_content, $error_featured) {
		$error_pass 				= "true";
		$error_code					= '';
		// Check for NONCE Compliance
		if (empty($_POST) || !wp_verify_nonce($_POST['ts-testimonial-submission-nonce'], 'ts-testimonial-submission')) {
		   print $error_nonce;
		   exit;
		} else { 
			// Error Check for Mandatory Fields
			if ((isset($_POST['title'])) && ($_POST['title'] != '')) {
				$title 				= $_POST['title'];
			} else {
				$error_code 		.= '<div class="ts-testimonial-frontend-submission-error">' . $error_title . '</div>';
				$error_pass 		= "false";
			}
			if ((isset($_POST['author'])) && ($_POST['author'] != '')) {
				$author 			= $_POST['author'];
			} else {
				$error_code 		.= '<div class="ts-testimonial-frontend-submission-error">' . $error_author . '</div>';
				$error_pass 		= "false";
			}
			if ((isset($_POST['content'])) && ($_POST['content'] != '')) {
				$content 			= $_POST['content'];
			} else {
				$error_code 		.= '<div class="ts-testimonial-frontend-submission-error">' . $error_content . '</div>';
				$error_pass 		= "false";
			}
			if (($post_featured == "true") && (isset($_FILES['avatar'])) && ($_FILES['avatar'] != '')) {
				$post_allowable 	= preg_replace('/\s+/', '', $post_allowable);
				$post_allowable 	= preg_replace('/\.+/', '', $post_allowable);
				$post_allowable 	= rtrim($post_allowable, ',');
				$file_pass			= explode(",", $post_allowable);
				$file_name 			= $_FILES['avatar']['name'];
				$file_type			= pathinfo($file_name, PATHINFO_EXTENSION);
				if ((!in_array($file_type, $file_pass)) && ($file_type != '') && ($file_name != '')) {
					$error_code 	.= '<div class="ts-testimonial-frontend-submission-error">' . $error_featured . '</div>';
					$error_pass 	= "false";
				}
			}
			if ($error_pass == "false") {
				echo $error_code;
			}
			
			// Add Data to Post Type
			if (($form_active == "true") && ($error_pass == "true")) {
				// Build Post
				$post = array(
					'post_title' 		=> wp_strip_all_tags($title),
					'post_content' 		=> $content,
					'post_category' 	=> '',
					'post_status' 		=> $post_status,
					'post_type' 		=> 'ts_testimonials',
				);
				$testimonial 			= wp_insert_post($post);
				
				// Set Category
				if (($post_category == "all") || ($post_category == "group")) {					
					$cat_ids 			= array($_POST['category']);					
					$cat_ids 			= array_map('intval', $cat_ids);
					$cat_ids 			= array_unique($cat_ids);				
					$term_taxonomy_ids 	= wp_set_object_terms($testimonial, $cat_ids, 'ts_testimonials_category', true);
				} else if ($post_category == "single") {
					$cat_ids 			= array($category_single);					
					$cat_ids 			= array_map('intval', $cat_ids);
					$cat_ids 			= array_unique($cat_ids);				
					$term_taxonomy_ids 	= wp_set_object_terms($testimonial, $cat_ids, 'ts_testimonials_category', true);
				}
				
				// Post Meta-Data
				update_post_meta($testimonial, 'ts_vcsc_testimonial_basic_author', 		$author);
				update_post_meta($testimonial, 'ts_vcsc_testimonial_basic_position', 	$_POST['position']);
				
				// Featured Image
				if (($post_featured == "true") && (isset($_FILES['avatar']))) {
					require_once(ABSPATH . 'wp-admin/includes/image.php');
					require_once(ABSPATH . 'wp-admin/includes/file.php');
					require_once(ABSPATH . 'wp-admin/includes/media.php');
					$attachment_id 		= media_handle_upload('avatar', $testimonial);
					if (!is_wp_error($attachment_id)) {
						set_post_thumbnail($testimonial, $attachment_id);
					}
				}
				
				echo '<div class="ts-testimonial-frontend-submission-success">' . $string_confirm . '</div>';
			} else if (($form_active == "false") && ($error_pass == "true")) {
				echo '<div class="ts-testimonial-frontend-submission-success">' . $string_confirm . '</div>';
			}
			
			$link_actual 				= $_SERVER['REQUEST_URI'];
			$link_home 					= home_url();
			
			/*echo "<meta http-equiv='refresh' content='0;url=$link_home' />";			
			echo '<script>';
				echo 'window.location="' . $link_actual . '";';
			echo '</script>';			
			exit;*/
		}
	}
}