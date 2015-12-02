<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_StandardPost')) {
        class TS_Parameter_StandardPost {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
                    vc_add_shortcode_param('standardpostcat', array(&$this, 'standardpostcat_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('standardpostcat', array(&$this, 'standardpostcat_settings_field'));
				}
            }        
            function standardpostcat_settings_field($settings, $value) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     	= vc_generate_dependencies_attributes($settings);
                $param_name     	= isset($settings['param_name']) ? $settings['param_name'] : '';
                $posttype			= isset($settings['posttype']) ? $settings['posttype'] : '';
                $posttaxonomy		= isset($settings['posttaxonomy']) ? $settings['posttaxonomy'] : '';
                $postsingle			= isset($settings['postsingle']) ? $settings['postsingle'] : '';
                $postplural			= isset($settings['postplural']) ? $settings['postplural'] : '';
                $postclass			= isset($settings['postclass']) ? $settings['postclass'] : '';
                $type           	= isset($settings['type']) ? $settings['type'] : '';
                $url            	= $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $output         	= '';
                $posts_fields 		= array();
                $categories			= '';
                $category_fields 	= array();
                $categories_count	= 0;
                $terms_slugs 		= array();
                $value_arr 			= $value;
                if (!is_array($value_arr)) {
                    $value_arr = array_map('trim', explode(',', $value_arr));
                }
                // Categories for Standard Post Type
                $args = array(
                    'type'                     => 'post',
                    'child_of'                 => 0,
                    'parent'                   => '',
                    'orderby'                  => 'name',
                    'order'                    => 'ASC',
                    'hide_empty'               => 1,
                    'hierarchical'             => 1,
                    'exclude'                  => '',
                    'include'                  => '',
                    'number'                   => '',
                    'taxonomy'                 => 'category',
                    'pad_counts'               => false 
                );
                $categories = get_categories($args);
                $output .= '<div class="ts-standardpost-categories-holder">';
                    $output .= '<textarea name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . '" style="display: none;">' . $value . '</textarea >';
                    $output .= '<select multiple="multiple" name="' . $param_name . '_multiple" id="' . $param_name . '_multiple" data-holder="' . $param_name . '" class="ts-standardpost-categories-selector wpb-input wpb-select dropdown ' . $param_name . '_multiple" value=" ' . $value . '" style="margin-bottom: 20px;" data-selectable="' . __( "Included Categories:", "ts_visual_composer_extend" ) . '" data-selection="' . __( "Excluded Categories:", "ts_visual_composer_extend" ) . '">';
                        foreach($categories as $category) { 
                            $output .= '<option id="" class="" name="" data-id="" data-author="" value="' . $category->slug . '" ' . selected(in_array($category->slug, $value_arr), true, false) . '>' . $category->name . ' (' . $category->count . ')</option>';
                        }
                    $output .= '</select>';
                    $output .= '<span style="font-size: 10px; margin-bottom: 20px; width: 100%; display: block; text-align: justify;">' . __( "Click on 'Included Categories' to exclude that category; click on 'Excluded Categories' to include a category again.", "ts_visual_composer_extend" ) . '</span>';
                $output .= '</div>';
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_StandardPost')) {
        $TS_Parameter_StandardPost = new TS_Parameter_StandardPost();
    }
?>