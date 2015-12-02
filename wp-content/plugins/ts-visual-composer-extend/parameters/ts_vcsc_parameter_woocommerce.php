<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_WooCommerce')) {
        class TS_Parameter_WooCommerce {
            function __construct() {
                global $VISUAL_COMPOSER_EXTENSIONS;
                if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_WooCommerceActive == "true") {
                    if (function_exists('vc_add_shortcode_param')) {
                        vc_add_shortcode_param('wc_single_product',                array(&$this, 'wc_single_product_settings_field'));
                        vc_add_shortcode_param('wc_multiple_products',             array(&$this, 'wc_multiple_products_settings_field'));
                        vc_add_shortcode_param('wc_single_product_category',       array(&$this, 'wc_single_product_category_settings_field'));
                        vc_add_shortcode_param('wc_multiple_product_categories',   array(&$this, 'wc_multiple_product_categories_settings_field'));
                        vc_add_shortcode_param('wc_product_attributes',            array(&$this, 'wc_product_attributes_settings_field'));
                        vc_add_shortcode_param('wc_product_terms',                 array(&$this, 'wc_product_terms_settings_field'));  
                    } else if (function_exists('add_shortcode_param')) {                    
                        add_shortcode_param('wc_single_product',                    array(&$this, 'wc_single_product_settings_field'));
                        add_shortcode_param('wc_multiple_products',                 array(&$this, 'wc_multiple_products_settings_field'));
                        add_shortcode_param('wc_single_product_category',           array(&$this, 'wc_single_product_category_settings_field'));
                        add_shortcode_param('wc_multiple_product_categories',       array(&$this, 'wc_multiple_product_categories_settings_field'));
                        add_shortcode_param('wc_product_attributes',                array(&$this, 'wc_product_attributes_settings_field'));
                        add_shortcode_param('wc_product_terms',                     array(&$this, 'wc_product_terms_settings_field'));  
                    }
                }
            }        
            // Function to generate param type "wc_single_product"
            function wc_single_product_settings_field($settings, $value) {
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $attr 			= array("post_type" => "product", "orderby" => "name", "order" => "asc", 'posts_per_page' => -1);
                $categories 	= get_posts($attr);
                $output			= '';
                $output .= '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';
                foreach($categories as $category) {
                    $selected 	= '';
                    if ($value!=='' && $category->ID === $value) {
                        $selected = ' selected="selected"';
                    }
                    $output .= '<option class="' . $category->ID . '" value="' . $category->ID . '" data-name="' . $category->post_title . '" ' . $selected . '>' . $category->post_title . ' (ID: ' . $category->ID . ')</option>';
                }
                $output .= '</select>';
                return $output;
            }
            // Function to generate param type "wc_multiple_products"
            function wc_multiple_products_settings_field($settings, $value) {
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $value_arr 		= $value;
                $output			= '';
                if (!is_array($value_arr)) {
                    $value_arr = array_map('trim', explode(',', $value_arr));
                }			
                $attr 			= array("post_type" => "product", "orderby" => "name", "order" => "asc", 'posts_per_page' => -1);
                $categories 	= get_posts($attr);
                $output .= '<div class="ts-woocommerce-products-holder">';
                    $output .= '<textarea name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . '" style="display: none;">' . $value . '</textarea >';
                    $output .= '<select multiple="multiple" name="' . $param_name . '_multiple" id="' . $param_name . '_multiple" data-holder="' . $param_name . '" class="ts-woocommerce-products-selector wpb-input wpb-select dropdown ' . $param_name . '_multiple" value=" ' . $value . '" style="margin-bottom: 20px;" data-selectable="' . __( "Available Products:", "ts_visual_composer_extend" ) . '" data-selection="' . __( "Selected Products:", "ts_visual_composer_extend" ) . '">';
                        foreach($categories as $category) { 
                            $output .= '<option id="" class="" name="" data-id="" data-author="" value="' . $category->ID . '" ' . selected(in_array($category->ID, $value_arr), true, false) . '>' . $category->post_title . ' (ID: ' . $category->ID . ')</option>';
                        }
                    $output .= '</select>';
                    $output .= '<span style="font-size: 10px; margin-bottom: 10px; width: 100%; display: block; text-align: justify;">' . __( "Click on 'Available Products' to add that product; click on 'Selected Products' to remove a product from selection.", "ts_visual_composer_extend" ) . '</span>';
                $output .= '</div>';			
                return $output;
            }
            // Function to generate param type "wc_single_product_category"
            function wc_single_product_category_settings_field($settings, $value) {
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $categories 	= get_terms('product_cat');
                $output			= '';
                $output .= '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
                foreach ($categories as $category) {
                    $selected 	= '';
                    if ($value!=='' && $category->slug === $value) {
                        $selected = ' selected="selected"';
                    }
                    $output .= '<option class="' . $category->slug . '" value="' . $category->slug . '" data-name="' . $category->name . '" ' . $selected . '>' . $category->name . '</option>';
                }
                $output .= '</select>';
                return $output;
            }
            // Function to generate param type "wc_multiple_product_categories"
            function wc_multiple_product_categories_settings_field($settings, $value) {
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $value_arr 		= $value;
                $output			= '';
                if (!is_array($value_arr)) {
                    $value_arr = array_map('trim', explode(',', $value_arr));
                }			
                $categories 	= get_terms('product_cat');
                $output .= '<div class="ts-woocommerce-categories-holder">';
                    $output .= '<textarea name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . '" style="display: none;">' . $value . '</textarea >';
                    $output .= '<select multiple="multiple" name="' . $param_name . '_multiple" id="' . $param_name . '_multiple" data-holder="' . $param_name . '" class="ts-woocommerce-categories-selector wpb-input wpb-select dropdown ' . $param_name . '_multiple" value=" ' . $value . '" style="margin-bottom: 20px;" data-selectable="' . __( "Available Categories:", "ts_visual_composer_extend" ) . '" data-selection="' . __( "Selected Categories:", "ts_visual_composer_extend" ) . '">';
                        foreach($categories as $category) { 
                            $output .= '<option id="" class="' . $category->slug . '" data-id="' . $category->term_id . '" data-count="' . $category->count . '" data-parent="' . $category->parent . '" value="' . $category->term_id . '" ' . selected(in_array($category->term_id, $value_arr), true, false) . '>' . $category->name . ' (&Sigma; ' . $category->count . ')</option>';
                        }
                    $output .= '</select>';
                    $output .= '<span style="font-size: 10px; margin-bottom: 10px; width: 100%; display: block; text-align: justify;">' . __( "Click on 'Available Categories' to add that category; click on 'Selected Categories' to remove a category from selection.", "ts_visual_composer_extend" ) . '</span>';
                $output .= '</div>';			
                return $output;
            }
            // Function to generate param type "wc_product_attributes"        
            function wc_product_attributes_settings_field($settings, $value) {
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $taxonomies 	= wc_get_attribute_taxonomies();
                $output			= '';
                $output .= '<select name="'.$settings['param_name'].'" data-connector="ts-woocommerce-terms-selector" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
                foreach ($taxonomies as $taxonomy) {
                    $selected = '';
                    if ($value!=='' && $taxonomy->attribute_name === $value) {
                        $selected = ' selected="selected"';
                    }
                    $output .= '<option class="' . $taxonomy->attribute_name . '" data-taxonomy="pa_' . $taxonomy->attribute_name . '" value="' . $taxonomy->attribute_name . '"' . $selected . '>' . $taxonomy->attribute_label . '</option>';
                }
                $output .= '</select>';
                return $output;
            }
            // Function to generate param type "wc_product_terms"            
            function wc_product_terms_settings_field($settings, $value) {
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $value_arr 		= $value;
                $output			= '';
                if (!is_array($value_arr)) {
                    $value_arr 	= array_map('trim', explode(',', $value_arr));
                }
                $taxonomies 	= wc_get_attribute_taxonomies();
                $taxonomy_terms = array();
                if ($taxonomies) {
                    foreach ($taxonomies as $taxonomy) {
                        if (taxonomy_exists(wc_attribute_taxonomy_name($taxonomy->attribute_name))) {
                            $taxonomy_terms[$taxonomy->attribute_name] = get_terms(wc_attribute_taxonomy_name($taxonomy->attribute_name), 'orderby=name&hide_empty=0');
                        }
                    };
                };
                $output .= '<div class="ts-woocommerce-terms-holder">';
                    $output .= '<textarea name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . '" style="display: none;">' . $value . '</textarea >';
                    $output .= '<select multiple="multiple" name="' . $param_name . '_multiple" id="' . $param_name . '_multiple" data-holder="' . $param_name . '" class="ts-woocommerce-terms-selector wpb-input wpb-select dropdown ' . $param_name . '_multiple" value=" ' . $value . '" style="margin-bottom: 20px;" data-selectable="' . __( "Available Terms:", "ts_visual_composer_extend" ) . '" data-selection="' . __( "Selected Terms:", "ts_visual_composer_extend" ) . '">';
                        foreach ($taxonomy_terms as $taxonomy_term) {
                            foreach ($taxonomy_term as $term) {
                                if (intval($term->count) > 0) {
                                    $output .= '<option id="" class="' . $term->slug . '" data-id="' . $term->term_id . '" data-taxonomy="' . $term->taxonomy . '" data-term="' . $term->slug . '" value="' . $term->slug . '" ' . selected(in_array($term->slug, $value_arr), true, false) . '>' . $term->name . ' (&Sigma; ' . $term->count . ')</option>';
                                }
                            }
                        }
                    $output .= '</select>';
                    $output .= '<span style="font-size: 10px; margin-bottom: 10px; width: 100%; display: block; text-align: justify;">' . __( "Click on 'Available Terms' to add that term; click on 'Selected Terms' to remove a term from selection.", "ts_visual_composer_extend" ) . '</span>';
                $output .= '</div>';
                return $output;
            }        
        }
    }
    if (class_exists('TS_Parameter_WooCommerce')) {
        $TS_Parameter_WooCommerce = new TS_Parameter_WooCommerce();
    }
?>