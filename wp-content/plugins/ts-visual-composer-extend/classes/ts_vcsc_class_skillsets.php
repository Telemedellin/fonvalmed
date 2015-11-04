<?php
if (!class_exists('TS_Skillsets')){
	class TS_Skillsets {
		function __construct() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "true") {
				add_action('init',                                  	array($this, 'TS_VCSC_Add_Skillsets_Elements'), 9999999);
			} else {
				add_action('admin_init',		                    	array($this, 'TS_VCSC_Add_Skillsets_Elements'), 9999999);
			}
            add_shortcode('TS_VCSC_Skill_Sets_Standalone',              array($this, 'TS_VCSC_Skill_Sets_Standalone'));
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements++;
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements++;
			add_shortcode('TS_VCSC_Skill_Sets_Raphael',              	array($this, 'TS_VCSC_Skill_Sets_Raphael'));
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountTotalElements++;
			$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CountActiveElements++;
		}
        
        // Standalone Skillset
        function TS_VCSC_Skill_Sets_Standalone ($atts, $content = null) {
            global $VISUAL_COMPOSER_EXTENSIONS;
            ob_start();
            wp_enqueue_style('ts-visual-composer-extend-front');
            wp_enqueue_script('ts-visual-composer-extend-front');
            
            extract( shortcode_atts( array(
                'skillset_id'			=> '',
                'custompost_name'		=> '',
				'bar_style'				=> 'style1',
				'bar_tooltip'			=> 'false',
                'bar_height'            => 2,
				'bar_height_2'			=> 35,
				'bar_height_3'			=> 40,
				'bar_label_width'		=> 110,
                'bar_stripes'           => 'false',
                'bar_animation'         => 'false',
				'bar_delay'				=> 250,
                'tooltip_style'			=> '',
                'animation_view'		=> '',
                'margin_top'			=> 0,
                'margin_bottom'			=> 0,
                'el_id' 				=> '',
                'el_class'              => '',
				'css'					=> '',
            ), $atts ));
			
			$output 							= '';

            // Check for Skillset and End Shortcode if Empty
            if (empty($skillset_id)) {
                $output .= '<div style="text-align: justify; font-weight: bold; font-size: 14px; color: red;">Please select a skillset in the element settings!</div>';
                echo $output;
                $myvariable = ob_get_clean();
                return $myvariable;
            }
            
            $output                             = '';
            $bar_classes                        = '';
            
            if ($bar_stripes == "true") {
                $bar_classes                    .= ' striped';
                if ($bar_animation == "true") {
                    $bar_classes                .= ' animated';
                }
            }
        
            if (!empty($el_id)) {
                $skill_block_id					= $el_id;
            } else {
                $skill_block_id					= 'ts-vcsc-skillset-' . mt_rand(999999, 9999999);
            }
        
            if ($animation_view != '') {
                $animation_css              	= TS_VCSC_GetCSSAnimation($animation_view);
            } else {
                $animation_css					= '';
            }
        
            // Retrieve Skillset Post Main Content
            $skill_array						= array();
            $args = array(
                'no_found_rows' 				=> 1,
                'ignore_sticky_posts' 			=> 1,
                'posts_per_page' 				=> -1,
                'post_type' 					=> 'ts_skillsets',
                'post_status' 					=> 'publish',
                'orderby' 						=> 'title',
                'order' 						=> 'ASC',
            );
            $skill_query = new WP_Query($args);
            if ($skill_query->have_posts()) {
                foreach($skill_query->posts as $p) {
                    if ($p->ID == $skillset_id) {
                        $skill_data = array(
                            'author'			=> $p->post_author,
                            'name'				=> $p->post_name,
                            'title'				=> $p->post_title,
                            'id'				=> $p->ID,
                            'content'			=> $p->post_content,
                        );
                        $skill_array[] = $skill_data;
                    }
                }
            }
            wp_reset_postdata();
            
            // Build Skillset Post Main Content
            foreach ($skill_array as $index => $array) {
                $Skill_Title 					= $skill_array[$index]['title'];
                $Skill_ID 						= $skill_array[$index]['id'];
            }
            
            // Retrieve Skillset Post Meta Content
            $custom_fields 						= get_post_custom($Skill_ID);
            $custom_fields_array				= array();
            foreach ($custom_fields as $field_key => $field_values) {
                if (!isset($field_values[0])) continue;
                if (in_array($field_key, array("_edit_lock", "_edit_last"))) continue;
                if (strpos($field_key, 'ts_vcsc_skillset_') !== false) {
                    $field_key_split 			= explode("_", $field_key);
                    $field_key_length 			= count($field_key_split) - 1;
                    $custom_data = array(
                        'group'					=> $field_key_split[$field_key_length - 1],
                        'name'					=> 'Skill_' . ucfirst($field_key_split[$field_key_length]),
                        'value'					=> $field_values[0],
                    );
                    $custom_fields_array[] = $custom_data;
                }
            }
            foreach ($custom_fields_array as $index => $array) {
                ${$custom_fields_array[$index]['name']} = $custom_fields_array[$index]['value'];
            }
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-post-skills ' . $animation_css . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Skill_Sets_Standalone', $atts);
			} else {
				$css_class	= 'ts-post-skills ' . $animation_css . ' ' . $el_class;
			}
			
            // Build Skillset
            $team_skills 		= '';
            $team_skills_count	= 0;
			if ($bar_style == "style1") {
				if (isset($Skill_Group)) {
					$skill_entries      = get_post_meta( $Skill_ID, 'ts_vcsc_skillset_basic_group', true);
					$skill_background 	= '';
					$team_skills		.= '<div id="' . $skill_block_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
						foreach ((array) $skill_entries as $key => $entry) {
							$skill_name = $skill_value = $skill_color = '';
							if (isset($entry['skillname'])) {
								$skill_name      = esc_html($entry['skillname']);
							}
							if (isset($entry['skillvalue'])) {
								$skill_value     = esc_html($entry['skillvalue']);
							}
							if (isset($entry['skillcolor'])) {
								$skill_color     = esc_html($entry['skillcolor']);
							}
							if ((strlen($skill_name) != 0) && (strlen($skill_value) != 0)) {
								$team_skills_count++;
								if ((strlen($skill_color) != 0) && ($skill_color != '#')) {
									$skill_background = 'background-color: ' . $skill_color . ';';
								} else {
									$skill_background = 'background-color: #00afd1;';
								}
								if ($bar_tooltip == "true") {
									$line_height		= 'line-height: 25px;';	
								} else {
									$line_height		= '';
								}
								$team_skills .= '<div class="ts-skillbars-style1-wrapper clearfix">';
									$team_skills .= '<div class="ts-skillbars-style1-name" style="' . $line_height . '">' . $skill_name . '';
										if ($bar_tooltip == "false") {
											$team_skills .= '<span>(' . $skill_value . '%)</span>';
										}
									$team_skills .= '</div>';
									$team_skills .= '<div class="ts-skillbars-style1-skillbar" style="height: ' . $bar_height . 'px;">';
										$team_skills .= '<div class="ts-skillbars-style1-value' . $bar_classes . '" data-color="' . $skill_color . '" data-level="' . $skill_value . '%" style="width: ' . $skill_value . '%; ' . $skill_background . '">';
											if ($bar_tooltip == "true") {
												$team_skills .= '<span class="ts-skillbars-style1-tooltip">' . $skill_value . '%</span>';
											}
										$team_skills .= '</div>';
									$team_skills .= '</div>';
								$team_skills .= '</div>';
							}
						}
					$team_skills		.= '</div>';
				}
			}
			if ($bar_style == "style2") {
				if (isset($Skill_Group)) {
					$skill_entries      = get_post_meta( $Skill_ID, 'ts_vcsc_skillset_basic_group', true);
					$skill_background 	= '';
					$team_skills		.= '<div id="' . $skill_block_id . '" class="' . $css_class . ' progress-bars" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
						foreach ((array) $skill_entries as $key => $entry) {
							$skill_name = $skill_value = $skill_color = '';
							if (isset($entry['skillname'])) {
								$skill_name      = esc_html($entry['skillname']);
							}
							if (isset($entry['skillvalue'])) {
								$skill_value     = esc_html($entry['skillvalue']);
							}
							if (isset($entry['skillcolor'])) {
								$skill_color     = esc_html($entry['skillcolor']);
							}
							if ((strlen($skill_name) != 0) && (strlen($skill_value) != 0)) {
								$team_skills_count++;
								if ((strlen($skill_color) != 0) && ($skill_color != '#')) {
									$skill_background = 'background-color: ' . $skill_color . ';';
								} else {
									$skill_background = 'background-color: #00afd1;';
								}					
								if (($team_skills_count == 1) && ($bar_tooltip == "true")) {
									$margin_adjust	= 'margin-top: 30px;';
								} else if ($bar_tooltip == "true") {
									$margin_adjust	= 'margin-top: 20px;';
								} else {
									$margin_adjust	= '';
								}
								$team_skills .= '<div class="ts-skillbars-style2-wrapper clearfix" style="height: ' . $bar_height_2 . 'px; ' . $margin_adjust . '">';
									$team_skills .= '<div class="ts-skillbars-style2-title" style="height: ' . $bar_height_2 . 'px; width: ' . $bar_label_width . 'px;' . $skill_background . '"><span style="line-height: ' . $bar_height_2 . 'px; height: ' . $bar_height_2 . 'px;">' . $skill_name . '</span></div>';
									$team_skills .= '<div class="ts-skillbars-style2-area" style="">';
										$team_skills .= '<div class="ts-skillbars-style2-skillbar' . $bar_classes . '" style="width: ' . $skill_value . '%; height: ' . $bar_height_2 . 'px; ' . $skill_background . '" data-level="' . $skill_value . '">';
											if ($bar_tooltip == "true") {
												$team_skills .= '<span class="ts-skillbars-style2-tooltip">' . $skill_value . '%</span>';
											}
										$team_skills .= '</div>';
									$team_skills .= '</div>';
									if ($bar_tooltip == "false") {
										$team_skills .= '<div class="ts-skillbars-style2-percent" style="line-height: ' . $bar_height_2 . 'px; height: ' . $bar_height_2 . 'px;">' . $skill_value . '%</div>';
									}
								$team_skills .= '</div>';
							}
						}
					$team_skills		.= '</div>';
				}
			}
			if ($bar_style == "style3") {
				if (isset($Skill_Group)) {
					$skill_entries      = get_post_meta( $Skill_ID, 'ts_vcsc_skillset_basic_group', true);
					$skill_background 	= '';
					$team_skills		.= '<div id="' . $skill_block_id . '" class="' . $css_class . ' progress-bars" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
						foreach ((array) $skill_entries as $key => $entry) {
							$skill_name = $skill_value = $skill_color = '';
							if (isset($entry['skillname'])) {
								$skill_name      = esc_html($entry['skillname']);
							}
							if (isset($entry['skillvalue'])) {
								$skill_value     = esc_html($entry['skillvalue']);
							}
							if (isset($entry['skillcolor'])) {
								$skill_color     = esc_html($entry['skillcolor']);
							}
							if ((strlen($skill_name) != 0) && (strlen($skill_value) != 0)) {
								$team_skills_count++;
								if ((strlen($skill_color) != 0) && ($skill_color != '#')) {
									$skill_background = 'background-color: ' . $skill_color . ';';
								} else {
									$skill_background = 'background-color: #00afd1;';
								}					
								if (($team_skills_count == 1) && ($bar_tooltip == "true")) {
									$margin_adjust	= 'margin-top: 30px;';
								} else if ($bar_tooltip == "true") {
									$margin_adjust	= 'margin-top: 20px;';
								} else {
									$margin_adjust	= '';
								}
								$team_skills .= '<div class="ts-skillbars-style3-wrapper clearfix" style="height: ' . $bar_height_3 . 'px;">';
									$team_skills .= '<div class="ts-skillbars-style3-skillbar" style="height: ' . $bar_height_3 . 'px;">';
										$team_skills .= '<div class="ts-skillbars-style3-countbar' . $bar_classes . '" data-level="' . $skill_value . '" style="height: ' . $bar_height_3 . 'px; width: ' . $skill_value . '%; ' . $skill_background . '">';
											$team_skills .= '<div class="ts-skillbars-style3-title" style="line-height: ' . ($bar_height_3 - 10) . 'px;">' . $skill_name . '</div>';
											if ($bar_tooltip == "true") {
												$team_skills .= '<span class="ts-skillbars-style3-tooltip">' . $skill_value . '%</span>';
											} else {
												$team_skills .= '<div class="ts-skillbars-style3-value style="line-height: ' . ($bar_height_3 - 10) . 'px;""><span>' . $skill_value . '%</span></div>';
											}
											$team_skills .= '<div class="ts-skillbars-style3-indicator"></div>';
										$team_skills .= '</div>';
									$team_skills .= '</div>';
								$team_skills .= '</div>';	
							}
						}
					$team_skills		.= '</div>';
				}
			}
    
            // Create Output
            $output = $team_skills;

            echo $output;
            
            $myvariable = ob_get_clean();
            return $myvariable;
        }
    
        
        // Raphaël Skillset
        function TS_VCSC_Skill_Sets_Raphael ($atts, $content = null) {
            global $VISUAL_COMPOSER_EXTENSIONS;
            ob_start();

			wp_enqueue_script('ts-extend-raphael');
            wp_enqueue_style('ts-visual-composer-extend-front');
            wp_enqueue_script('ts-visual-composer-extend-front');
            
            extract( shortcode_atts( array(
                'skillset_id'			=> '',
                'custompost_name'		=> '',
				
				'circle_custom'			=> 'false',
				'circle_color' 			=> '#ffffff',
				'text_default' 			=> '',
				'text_color' 			=> '#000000',
				'text_size'				=> 16,
				'max_stroke'			=> 40,
				'space_stroke'			=> 2,
				'random_start'			=> 'true',

                'animation_view'		=> '',
                'margin_top'			=> 0,
                'margin_bottom'			=> 0,
                'el_id' 				=> '',
                'el_class'              => '',
				'css'					=> '',
            ), $atts ));

            // Check for Skillset and End Shortcode if Empty
            if (empty($skillset_id)) {
                $output .= '<div style="text-align: justify; font-weight: bold; font-size: 14px; color: red;">Please select a skillset in the element settings!</div>';
                echo $output;
                $myvariable = ob_get_clean();
                return $myvariable;
            }
            
            $output                             = '';
            $bar_classes                        = '';
        
            if (!empty($el_id)) {
                $skill_block_id					= $el_id;
            } else {
                $skill_block_id					= 'ts-vcsc-skillset-raphael-' . mt_rand(999999, 9999999);
            }
        
            if ($animation_view != '') {
                $animation_css              	= TS_VCSC_GetCSSAnimation($animation_view);
            } else {
                $animation_css					= '';
            }
        
            // Retrieve Skillset Post Main Content
            $skill_array						= array();
            $args = array(
                'no_found_rows' 				=> 1,
                'ignore_sticky_posts' 			=> 1,
                'posts_per_page' 				=> -1,
                'post_type' 					=> 'ts_skillsets',
                'post_status' 					=> 'publish',
                'orderby' 						=> 'title',
                'order' 						=> 'ASC',
            );
            $skill_query = new WP_Query($args);
            if ($skill_query->have_posts()) {
                foreach($skill_query->posts as $p) {
                    if ($p->ID == $skillset_id) {
                        $skill_data = array(
                            'author'			=> $p->post_author,
                            'name'				=> $p->post_name,
                            'title'				=> $p->post_title,
                            'id'				=> $p->ID,
                            'content'			=> $p->post_content,
                        );
                        $skill_array[] = $skill_data;
                    }
                }
            }
            wp_reset_postdata();
            
            // Build Skillset Post Main Content
            foreach ($skill_array as $index => $array) {
                $Skill_Title 					= $skill_array[$index]['title'];
                $Skill_ID 						= $skill_array[$index]['id'];
            }
            
            // Retrieve Team Post Meta Content
            $custom_fields 						= get_post_custom($Skill_ID);
            $custom_fields_array				= array();
            foreach ($custom_fields as $field_key => $field_values) {
                if (!isset($field_values[0])) continue;
                if (in_array($field_key, array("_edit_lock", "_edit_last"))) continue;
                if (strpos($field_key, 'ts_vcsc_skillset_') !== false) {
                    $field_key_split 			= explode("_", $field_key);
                    $field_key_length 			= count($field_key_split) - 1;
                    $custom_data = array(
                        'group'					=> $field_key_split[$field_key_length - 1],
                        'name'					=> 'Skill_' . ucfirst($field_key_split[$field_key_length]),
                        'value'					=> $field_values[0],
                    );
                    $custom_fields_array[] = $custom_data;
                }
            }
            foreach ($custom_fields_array as $index => $array) {
                ${$custom_fields_array[$index]['name']} = $custom_fields_array[$index]['value'];
            }
			
			if (function_exists('vc_shortcode_custom_css_class')) {
				$css_class 	= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ts-skillset-raphael-container ' . $animation_css . ' ' . $el_class . ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Skill_Sets_Raphael', $atts);
			} else {
				$css_class	= 'ts-skillset-raphael-container ' . $animation_css . ' ' . $el_class;
			}
			
            // Build Skillset
            $team_skills 		= '';
            $team_skills_count	= 0;
            if (isset($Skill_Group)) {
                $skill_entries      = get_post_meta( $Skill_ID, 'ts_vcsc_skillset_basic_group', true);
                $skill_background 	= '';
                $team_skills		.= '<div id="' . $skill_block_id . '" class="' . $css_class . '" style="margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
                    foreach ((array) $skill_entries as $key => $entry) {
                        $skill_name = $skill_value = $skill_color = '';
                        if (isset($entry['skillname'])) {
                            $skill_name      = esc_html($entry['skillname']);
                        }
                        if (isset($entry['skillvalue'])) {
                            $skill_value     = esc_html($entry['skillvalue']);
                        }
                        if (isset($entry['skillcolor'])) {
                            $skill_color     = esc_html($entry['skillcolor']);
                        }
                        if ((strlen($skill_name) != 0) && (strlen($skill_value) != 0)) {
                            $team_skills_count++;
							$team_skills .= '<div class="ts-skillset-raphael-arch">
								<input type="hidden" class="name" value="' . $skill_name . '" />
								<input type="hidden" class="percent" value="' . $skill_value . '" />
								<input type="hidden" class="color" value="' . $skill_color . '" />
							</div>';						
						}
                    }
					$team_skills .= '<div id="" class="ts-skillset-raphael-chart" data-raphael="' . $skill_block_id . '" data-randomstart="' . $random_start . '" data-spacestroke="' . $space_stroke . '" data-maxstroke="' . $max_stroke . '" data-circlecustom="' . $circle_custom . '" data-circlecolor="' . $circle_color . '" data-textsize="' . $text_size . '" data-textcolor="' . $text_color . '" data-textdefault="' . $text_default . '"></div>';
                $team_skills		.= '</div>';
            }
    
            // Create Output
            $output = $team_skills;

            echo $output;
            
            $myvariable = ob_get_clean();
            return $myvariable;
        }
		
		// Add Skillset Elements
        function TS_VCSC_Add_Skillsets_Elements() {
            global $VISUAL_COMPOSER_EXTENSIONS;
            // Add Standalone Skillset
            if (function_exists('vc_map')) {
                vc_map( array(
                    "name"                              => __( "TS Skillsets Bars", "ts_visual_composer_extend" ),
                    "base"                              => "TS_VCSC_Skill_Sets_Standalone",
                    "icon" 	                            => "icon-wpb-ts_vcsc_skillset_standalone",
                    "class"                             => "",
                    "category"                          => __( 'VC Extensions', "ts_visual_composer_extend" ),
                    "description"                       => __("Place a skillsets element", "ts_visual_composer_extend"),
					"admin_enqueue_js"            		=> "",
					"admin_enqueue_css"           		=> "",
                    "params"                            => array(
                        // Skillset Selection
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
                            "heading"                   => __( "Skillset", "ts_visual_composer_extend" ),
                            "param_name"                => "skillset_id",
                            "posttype"                  => "ts_skillsets",
                            "posttaxonomy"              => "ts_skillsets_category",
							"taxonomy"              	=> "ts_skillsets_category",
							"postsingle"				=> "Skillset",
							"postplural"				=> "Skillsets",
							"postclass"					=> "skillset",
                            "value"                     => "",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
                        array(
                            "type"                      => "hidden_input",
                            "heading"                   => __( "Skillset Name", "ts_visual_composer_extend" ),
                            "param_name"                => "custompost_name",
                            "value"                     => "",
                            "admin_label"		        => true,
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),						
                        array(
                            "type"                      => "dropdown",
                            "heading"                   => __( "Bar Style", "ts_visual_composer_extend" ),
                            "param_name"                => "bar_style",
                            "value"                     => array(
                                "Style 1"							=> "style1",
                                "Style 2"                     		=> "style2",
								"Style 3"                     		=> "style3",
                            ),
							"admin_label"		        => true,
                            "description"               => __( "Select the style for the skill bars.", "ts_visual_composer_extend" ),
                        ),						
                        array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Bar Height", "ts_visual_composer_extend" ),
                            "param_name"                => "bar_height",
                            "value"                     => "2",
                            "min"                       => "2",
                            "max"                       => "75",
                            "step"                      => "1",
                            "unit"                      => 'px',
                            "description"               => __( "Define the height for each individual skill bar.", "ts_visual_composer_extend" ),
							"dependency"                => array( 'element' => "bar_style", 'value' => 'style1')
                        ),
                        array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Bar Height", "ts_visual_composer_extend" ),
                            "param_name"                => "bar_height_2",
                            "value"                     => "35",
                            "min"                       => "20",
                            "max"                       => "75",
                            "step"                      => "1",
                            "unit"                      => 'px',
                            "description"               => __( "Define the height for each individual skill bar.", "ts_visual_composer_extend" ),
							"dependency"                => array( 'element' => "bar_style", 'value' => 'style2')
                        ),
                        array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Bar Label Width", "ts_visual_composer_extend" ),
                            "param_name"                => "bar_label_width",
                            "value"                     => "110",
                            "min"                       => "100",
                            "max"                       => "300",
                            "step"                      => "1",
                            "unit"                      => 'px',
                            "description"               => __( "If necessary, define the width for the skill labels before the skill bars to account for longer skill names.", "ts_visual_composer_extend" ),
							"dependency"                => array( 'element' => "bar_style", 'value' => 'style2')
                        ),		
                        array(
                            "type"				        => "switch_button",
                            "heading"                   => __( "Use Tooltip", "ts_visual_composer_extend" ),
                            "param_name"                => "bar_tooltip",
                            "value"                     => "false",
                            "on"				        => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"				        => __( 'No', "ts_visual_composer_extend" ),
                            "style"				        => "select",
                            "design"			        => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to show the skill value as tooltip.", "ts_visual_composer_extend" ),
                            "dependency"                => ""
                        ),
                        array(
                            "type"				        => "switch_button",
                            "heading"                   => __( "Add Stripes", "ts_visual_composer_extend" ),
                            "param_name"                => "bar_stripes",
                            "value"                     => "false",
                            "on"				        => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"				        => __( 'No', "ts_visual_composer_extend" ),
                            "style"				        => "select",
                            "design"			        => "toggle-light",
                            "admin_label"		        => true,
                            "description"               => __( "Switch the toggle if you want to add a stripes to the skill bar.", "ts_visual_composer_extend" ),
                            "dependency"                => ""
                        ),
                        array(
                            "type"				        => "switch_button",
                            "heading"                   => __( "Add Stripes Animation", "ts_visual_composer_extend" ),
                            "param_name"                => "bar_animation",
                            "value"                     => "false",
                            "on"				        => __( 'Yes', "ts_visual_composer_extend" ),
                            "off"				        => __( 'No', "ts_visual_composer_extend" ),
                            "style"				        => "select",
                            "design"			        => "toggle-light",
                            "description"               => __( "Switch the toggle if you want to add an animation to the striped skill bar.", "ts_visual_composer_extend" ),
                            "dependency"                => array( 'element' => "bar_stripes", 'value' => 'true')
                        ),
                        // Other Skillset Settings
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
                            "type"                      => "dropdown",
                            "heading"                   => __( "Viewport Animation", "ts_visual_composer_extend" ),
                            "param_name"                => "animation_view",
                            "value"                     => array(
                                "None"                              => "",
                                "Top to Bottom"                     => "top-to-bottom",
                                "Bottom to Top"                     => "bottom-to-top",
                                "Left to Right"                     => "left-to-right",
                                "Right to Left"                     => "right-to-left",
                                "Appear from Center"                => "appear",
                            ),
                            "description"               => __( "Select the viewport animation for the element.", "ts_visual_composer_extend" ),
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
            // Add Raphael Skillset
            if (function_exists('vc_map')) {
                vc_map( array(
                    "name"                              => __( "TS Skillsets Raphael", "ts_visual_composer_extend" ),
                    "base"                              => "TS_VCSC_Skill_Sets_Raphael",
                    "icon" 	                            => "icon-wpb-ts_vcsc_skillset_raphael",
                    "class"                             => "",
                    "category"                          => __( 'VC Extensions', "ts_visual_composer_extend" ),
                    "description"                       => __("Place a raphael skillsets element", "ts_visual_composer_extend"),
                    "admin_enqueue_js"                	=> "",
                    "admin_enqueue_css"               	=> "",
                    "params"                            => array(
                        // Skillset Selection
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
                            "heading"                   => __( "Skillset", "ts_visual_composer_extend" ),
                            "param_name"                => "skillset_id",
                            "posttype"                  => "ts_skillsets",
                            "posttaxonomy"              => "ts_skillsets_category",
							"taxonomy"              	=> "ts_skillsets_category",
							"postsingle"				=> "Skillset",
							"postplural"				=> "Skillsets",
							"postclass"					=> "skillset",
                            "value"                     => "",
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),
                        array(
                            "type"                      => "hidden_input",
                            "heading"                   => __( "Skillset Name", "ts_visual_composer_extend" ),
                            "param_name"                => "custompost_name",
                            "value"                     => "",
                            "admin_label"		        => true,
                            "description"               => __( "", "ts_visual_composer_extend" )
                        ),						
                        array(
                            "type"                      => "textfield",
                            "heading"                   => __( "Default Label Text", "ts_visual_composer_extend" ),
                            "param_name"                => "text_default",
                            "value"                     => "",
                            "description"               => __( "Enter a default text for the inner circle label.", "ts_visual_composer_extend" ),
                        ),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Label Text Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "text_color",
							"value"             		=> "#000000",
							"description"       		=> __( "Define the text color for the inner circle label.", "ts_visual_composer_extend" ),
						),		
                        array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Label Font Size", "ts_visual_composer_extend" ),
                            "param_name"                => "text_size",
                            "value"                     => "16",
                            "min"                       => "10",
                            "max"                       => "50",
                            "step"                      => "1",
                            "unit"                      => 'px',
							"admin_label"		        => true,
                            "description"               => __( "Select the font size for the inner circle label.", "ts_visual_composer_extend" ),
                        ),
						array(
							"type"						=> "switch_button",
							"heading"           		=> __( "Custom Label Background", "ts_visual_composer_extend" ),
							"param_name"        		=> "circle_custom",
							"value"             		=> "false",
							"on"						=> __( 'Yes', "ts_visual_composer_extend" ),
							"off"						=> __( 'No', "ts_visual_composer_extend" ),
							"style"						=> "select",
							"design"					=> "toggle-light",
							"description"       		=> __( "Switch the toggle if you want to apply a custom background color to the inner circle label.", "ts_visual_composer_extend" ),
							"dependency"        		=> ""
						),
						array(
							"type"              		=> "colorpicker",
							"heading"           		=> __( "Label Background Color", "ts_visual_composer_extend" ),
							"param_name"        		=> "circle_color",
							"value"             		=> "#ffffff",
							"description"       		=> __( "Define the background color for the inner circle label.", "ts_visual_composer_extend" ),
							"dependency"        		=> array( 'element' => "circle_custom", 'value' => 'true' )
						),						
                        array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Max. Circle Stroke Width", "ts_visual_composer_extend" ),
                            "param_name"                => "max_stroke",
                            "value"                     => "40",
                            "min"                       => "10",
                            "max"                       => "80",
                            "step"                      => "1",
                            "unit"                      => 'px',
                            "description"               => __( "Select the maximum stroke width for the individual skill circles.", "ts_visual_composer_extend" ),
                        ),
                        array(
                            "type"                      => "nouislider",
                            "heading"                   => __( "Stroke Spacing", "ts_visual_composer_extend" ),
                            "param_name"                => "space_stroke",
                            "value"                     => "2",
                            "min"                       => "0",
                            "max"                       => "10",
                            "step"                      => "1",
                            "unit"                      => 'px',
                            "description"               => __( "Select the spacing between the individual skill circles.", "ts_visual_composer_extend" ),
                        ),
                        // Other Skillset Settings
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
                            "type"                      => "dropdown",
                            "heading"                   => __( "Viewport Animation", "ts_visual_composer_extend" ),
                            "param_name"                => "animation_view",
                            "value"                     => array(
                                "None"                              => "",
                                "Top to Bottom"                     => "top-to-bottom",
                                "Bottom to Top"                     => "bottom-to-top",
                                "Left to Right"                     => "left-to-right",
                                "Right to Left"                     => "right-to-left",
                                "Appear from Center"                => "appear",
                            ),
                            "description"               => __( "Select the viewport animation for the element.", "ts_visual_composer_extend" ),
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
if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_TS_VCSC_Skill_Sets_Standalone extends WPBakeryShortCode {};
	class WPBakeryShortCode_TS_VCSC_Skill_Sets_Raphael extends WPBakeryShortCode {};
}
// Initialize "TS Skillsets" Class
if (class_exists('TS_Skillsets')) {
	$TS_Skillsets = new TS_Skillsets;
}