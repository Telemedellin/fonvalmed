<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_bbPress')) {
        class TS_Parameter_bbPress {
            function __construct() {
				global $VISUAL_COMPOSER_EXTENSIONS;
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_bbPressActive == "true") {
					if (function_exists('vc_add_shortcode_param')) {
						vc_add_shortcode_param('bbpress_forumslist', 	array(&$this, 'bbpress_forumslist_settings_field'));
						vc_add_shortcode_param('bbpress_topicslist', 	array(&$this, 'bbpress_topicslist_settings_field'));
						vc_add_shortcode_param('bbpress_replieslist', 	array(&$this, 'bbpress_replieslist_settings_field'));
						vc_add_shortcode_param('bbpress_tagslist', 		array(&$this, 'bbpress_tagslist_settings_field'));
					} else if (function_exists('add_shortcode_param')) {					
						add_shortcode_param('bbpress_forumslist', 	array(&$this, 'bbpress_forumslist_settings_field'));
						add_shortcode_param('bbpress_topicslist', 	array(&$this, 'bbpress_topicslist_settings_field'));
						add_shortcode_param('bbpress_replieslist', 	array(&$this, 'bbpress_replieslist_settings_field'));
						add_shortcode_param('bbpress_tagslist', 	array(&$this, 'bbpress_tagslist_settings_field'));
					}
                }
            }        
            function bbpress_forumslist_settings_field($settings, $value) {
				global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $allforums		= isset($settings['allforums']) ? $settings['allforums'] : 'false';
				$url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $value_arr 		= $value;
                $args = array(
                    'post_type' 	=> bbp_get_forum_post_type(),
                    'orderby' 		=> 'title',
                    'order' 		=> 'ASC'
                );
                $forums 		= new WP_Query($args);
                $output			= '';
                $output .= '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'].'">';
                if ($allforums == "true") {
                    $output .= "<option value=''>" . __("All Forums", "ts_visual_composer_extend") . "</option>";
                }
                while ($forums->have_posts()) { 
                    $forums->the_post(); 
                    if ($value!='' && get_the_ID() == $value) {
                        $selected = ' selected="selected"';
                    } else {
                        $selected = "";
                    }
                    $output .= '<option class="' . get_the_ID() . '" data-id="' . get_the_ID() . '" data-value="' . get_the_title() . '" value="' . get_the_ID() . '"' . $selected . '>' . get_the_title() . '</option>';
                }
                wp_reset_query();
                $output .= '</select>';
                return $output;
            }
            // Function to generate param type "bbpress_topicslist"
            function bbpress_topicslist_settings_field($settings, $value) {
				global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
				$url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $args = array(
                    'post_type' 	=> bbp_get_topic_post_type(),
                    'orderby' 		=> 'title',
                    'order' 		=> 'ASC'
                );
                $forums 		= new WP_Query($args);
                $output			= '';
                $output .= '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';
                while ($forums->have_posts()) { 
                    $forums->the_post(); 
                    if ($value!='' && get_the_ID() == $value) {
                        $selected = ' selected="selected"';
                    } else {
                        $selected = "";
                    }
                    $output .= '<option class="' . get_the_ID() . '" data-id="' . get_the_ID() . '" data-value="' . get_the_title() . '" value="' . get_the_ID() . '"' . $selected . '>' . get_the_title() . '</option>';
                }
                wp_reset_query();
                $output .= '</select>';
                return $output;
            }
            // Function to generate param type "bbpress_replieslist"
            function bbpress_replieslist_settings_field($settings, $value) {
				global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
				$url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $args = array(
                    'post_type' 	=> bbp_get_reply_post_type(),
                    'orderby' 		=> 'title',
                    'order' 		=> 'ASC'
                );
                $forums 		= new WP_Query($args);
                $output			= '';
                $output .= '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';
                while ($forums->have_posts()) { 
                    $forums->the_post(); 
                    if ($value!='' && get_the_ID() == $value) {
                        $selected = ' selected="selected"';
                    } else {
                        $selected = "";
                    }
                    $output .= '<option class="' . get_the_ID() . '" data-id="' . get_the_ID() . '" data-value="' . get_the_title() . '" value="' . get_the_ID() . '"' . $selected . '>' . get_the_title() . '</option>';
                }
                wp_reset_query();
                $output .= '</select>';
                return $output;
            }
            // Function to generate param type "bbpress_tagslist"            
            function bbpress_tagslist_settings_field($settings, $value) {
				global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
				$url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $tags 			= get_terms('topic-tag');
                $output			= '';
                $output .= '<select name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '">';
                foreach ($tags as $item) {  
                    if ($value!='' && $item->term_id == $value) {
                        $selected = ' selected="selected"';
                    } else {
                        $selected = "";
                    }
                    $output .= '<option class="' . $item->term_id . '" value="' . $item->term_id . '"' . $selected . '>' . $item->name . '</option>';
                }
                $output .= '</select>';
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_bbPress')) {
        $TS_Parameter_bbPress = new TS_Parameter_bbPress();
    }
?>