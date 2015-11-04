<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_IconsPanel')) {
        class TS_Parameter_IconsPanel {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('icons_panel', array(&$this, 'iconspanel_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('icons_panel', array(&$this, 'iconspanel_settings_field'));
				}
            }        
            function iconspanel_settings_field($settings, $value) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $default		= isset($settings['default']) ? $settings['default'] : '';
                $height         = isset($settings['height']) ? $settings['height'] : "250";
                $size           = isset($settings['size']) ? $settings['size'] : "28";
                $margin         = isset($settings['margin']) ? $settings['margin'] : "4";
                $custom         = isset($settings['custom']) ? $settings['custom'] : 'true';
                $icon_select    = isset($settings['source']) ? $settings['source'] : '';
                $font_select	= isset($settings['fonts']) ? $settings['fonts'] : 'true';
                $icon_filter	= isset($settings['filter']) ? $settings['filter'] : 'true';
                $summary		= isset($settings['summary']) ? $settings['summary'] : 'true';
                $visual			= $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_EditorVisualSelector;
                $override		= isset($settings['override']) ? $settings['override'] : 'false';
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $output         = '';
                if (($visual == "true") || ($override == "true")) {
                    if (($value == "") && ($default == "")) {
                        $value	= "transparent";
                    } else if (($value == "") && ($default != "")) {
                        $value	= $default;
                    }
                    $output .= '<div class="ts-font-icons-selector-parent">';
                        if (($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Fonts > 1 ) && ($font_select == "true")) {
                            $output .= __( "Filter by Font:", "ts_visual_composer_extend" );
                        }
                        if ($font_select == "true") {
                            $output .= '<select name="ts-font-icons-fonts" id="ts-font-icons-fonts" class="ts-font-icons-fonts wpb_vc_param_value wpb-input wpb-select font dropdown" style="margin-bottom: 20px; ' . ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Fonts > 1 ? "display: block;" : "display: none;") . '">';
                                foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_List_Select_Fonts as $Icon_Font => $iconfont) {
                                    if (strlen($iconfont) != 0) {
                                        $font = str_replace("(", "", strtolower($Icon_Font));
                                        $font = str_replace(")", "", strtolower($font));
                                        $output .= '<option class="" value="' . $font . '">' . $Icon_Font . '</option>';
                                    } else {
                                        $output .= '<option class="" value="">' . $Icon_Font . '</option>';
                                    }
                                }
                            $output .= '</select>';
                        }
                        if ($icon_filter == "true") {
                            $output .= __( "Filter by Icon:", "ts_visual_composer_extend" );
                            $output .= '<input name="ts-font-icons-search" id="ts-font-icons-search" class="ts-font-icons-search" type="text" placeholder="' . __( "Search ...", "ts_visual_composer_extend" ) . '" />';				
                            $output .= '<div id="ts-font-icons-count" class="ts-font-icons-count" data-count="' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Count . '" style="margin-top: 10px; font-size: 10px;">' . __( "Icons Found:", "ts_visual_composer_extend" ) . ' <span id="ts-font-icons-found" class="ts-font-icons-found">' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Count . '</span> / ' . $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Active_Icon_Count . '</div>';				
                        }
                        if ($summary == "true") {
                            $output .= '<div id="ts-font-icons-preview" class="ts-font-icons-preview" style="border: 1px solid #ededed; float: left; width: 100%; display: block; padding: 0; margin: 10px auto; background: #ededed; ' . ((empty($value) || $value == "transparent") ? "display: none;" : "") . '">';
                                $output .= '<div style="float: left; text-align: left;">';
                                    $output .= '<span style="font-weight: bold; width: 100%; display: block; margin: 10px; padding: 0;">' . __( "Selected Icon:", "ts_visual_composer_extend" ) . '</span>';
                                    $output .= '<span style="width: 100%; display: block; margin: 10px; padding: 0;">' . __( "Class Name:", "ts_visual_composer_extend" ) . ' <span class="ts-font-icons-preview-class">' . $value . '</span></span>';
                                $output .= '</div>';
                                $output .= '<div style="float: right;">';
                                    $output .= '<i class="' . $value . '" style="display: inline-flex; font-size: 50px; height: 50px; line-height: 50px; color: #B24040; margin: 10px;"></i>';
                                $output .= '</div>';
                            $output .= '</div>';
                        }
                        $output .= '<div id="ts-font-icons-wrapper-' . $param_name . '" class="ts-visual-selector ts-font-icons-wrapper" style="height: ' . $height . 'px;">';
                            $output .= '<input name="' . $param_name . '" id="' . $param_name . '" class="ts-font-icons-input wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="hidden" value="' . $value . '"/>';
                            // Add Built-In Fonts (based on provided Source)              
                            foreach ($icon_select as $group => $icons) {
                                if (!is_array($icons) || !is_array(current($icons))) {
                                    $class_key      = key($icons);
                                    $class_group    = explode('-', esc_attr($class_key));
                                    if (($class_group[0] != "dashicons") && ($class_group[0] != "transparent")) {
                                        if ($value == esc_attr($class_key)) {
                                            $output .= '<a class="TS_VCSC_Icon_Taken TS_VCSC_Icon_Link current" href="#" title="' . __( "Icon Name:", "ts_visual_composer_extend" ) . ' ' . esc_attr($class_key) . '" data-group="" data-filter="false" data-font="font-' . $class_group[1] . '" data-icon="' . esc_attr($class_key) . '" rel="' . esc_html(current($icons)) . '" style="height: ' . $size . 'px; width: ' . $size . 'px; margin: ' . $margin . 'px ' . $margin . 'px 0 0;"><i style="font-size: ' . $size . 'px; line-height: ' . $size . 'px; height: ' . $size . 'px; width: ' . $size . 'px;" class="' . esc_attr($class_key) . '"></i><div class="selector-tick"></div></a>';
                                        } else {
                                            $output .= '<a class="TS_VCSC_Icon_Taken TS_VCSC_Icon_Link" href="#" title="' . __( "Icon Name:", "ts_visual_composer_extend" ) . ' ' . esc_attr($class_key) . '" data-group="" data-filter="false" data-font="font-' . $class_group[1] . '" data-icon="' . esc_attr($class_key) . '" rel="' . esc_html(current($icons)) . '" style="height: ' . $size . 'px; width: ' . $size . 'px; margin: ' . $margin . 'px ' . $margin . 'px 0 0;"><i style="font-size: ' . $size . 'px; line-height: ' . $size . 'px; height: ' . $size . 'px; width: ' . $size . 'px;" class="' . esc_attr($class_key) . '"></i></a>';
                                        }
                                    } else if ($class_group[0] == "transparent") {
                                        if ($value == 'transparent') {
                                            $output .= '<a class="TS_VCSC_Icon_Empty TS_VCSC_Icon_Link ts-no-icon current" href="#" title="' . __( "Icon Name:", "ts_visual_composer_extend" ) . ' ' . __( "No Icon", "ts_visual_composer_extend" ) . '" data-group="" rel="transparent" style="height: ' . $size . 'px; width: ' . $size . 'px; margin: ' . $margin . 'px ' . $margin . 'px 0 0;">r<div class="selector-tick"></div></a>';
                                        } else {
                                            $output .= '<a class="TS_VCSC_Icon_Empty TS_VCSC_Icon_Link ts-no-icon" href="#" title="' . __( "Icon Name:", "ts_visual_composer_extend" ) . ' ' . __( "No Icon", "ts_visual_composer_extend" ) . '" data-group="" rel="transparent" style="height: ' . $size . 'px; width: ' . $size . 'px; margin: ' . $margin . 'px ' . $margin . 'px 0 0;">r</a>';
                                        }
                                    } else {
                                        if ($value == esc_attr($class_key)) {
                                            $output .= '<a class="TS_VCSC_Icon_Taken TS_VCSC_Icon_Link current" href="#" title="' . __( "Icon Name:", "ts_visual_composer_extend" ) . ' ' . esc_attr($class_key) . '" data-group="" data-filter="false" data-font="font-' . $class_group[0] . '" data-icon="' . esc_attr($class_key) . '" rel="' . esc_html(current($icons)) . '" style="height: ' . $size . 'px; width: ' . $size . 'px; margin: ' . $margin . 'px ' . $margin . 'px 0 0;"><i style="font-size: ' . $size . 'px; line-height: ' . $size . 'px; height: ' . $size . 'px; width: ' . $size . 'px;" class="' . esc_attr($class_key) . '"></i><div class="selector-tick"></div></a>';
                                        } else {
                                            $output .= '<a class="TS_VCSC_Icon_Taken TS_VCSC_Icon_Link" href="#" title="' . __( "Icon Name:", "ts_visual_composer_extend" ) . ' ' . esc_attr($class_key) . '" data-group="" data-filter="false" data-font="font-' . $class_group[0] . '" data-icon="' . esc_attr($class_key) . '" rel="' . esc_html(current($icons)) . '" style="height: ' . $size . 'px; width: ' . $size . 'px; margin: ' . $margin . 'px ' . $margin . 'px 0 0;"><i style="font-size: ' . $size . 'px; line-height: ' . $size . 'px; height: ' . $size . 'px; width: ' . $size . 'px;" class="' . esc_attr($class_key) . '"></i></a>';
                                        }
                                    }
                                } else {
                                    foreach ($icons as $key => $label) {
                                        $class_key      = key($label);
                                        $class_group    = explode('-', esc_attr($class_key));
                                        $font           = str_replace("(", "", strtolower(strtolower(esc_attr($group))));
                                        $font           = str_replace(")", "", strtolower($font));
                                        if (($class_group[0] != "dashicons") && ($class_group[0] != "transparent")) {
                                            if ($value == esc_attr($class_key)) {
                                                $output .= '<a class="TS_VCSC_Icon_Taken TS_VCSC_Icon_Link current" href="#" title="' . __( "Icon Name:", "ts_visual_composer_extend" ) . ' ' . esc_attr($class_key) . '" data-group="' . $font . '" data-filter="false" data-font="font-' . $class_group[1] . '" data-icon="' . esc_attr($class_key) . '" rel="' . esc_html(current($label)) . '" style="height: ' . $size . 'px; width: ' . $size . 'px; margin: ' . $margin . 'px ' . $margin . 'px 0 0;"><i style="font-size: ' . $size . 'px; line-height: ' . $size . 'px; height: ' . $size . 'px; width: ' . $size . 'px;" class="' . esc_attr($class_key) . '"></i><div class="selector-tick"></div></a>';
                                            } else {
                                                $output .= '<a class="TS_VCSC_Icon_Taken TS_VCSC_Icon_Link" href="#" title="' . __( "Icon Name:", "ts_visual_composer_extend" ) . ' ' . esc_attr($class_key) . '" data-group="' . $font . '" data-filter="false" data-font="font-' . $class_group[1] . '" data-icon="' . esc_attr($class_key) . '" rel="' . esc_html(current($label)) . '" style="height: ' . $size . 'px; width: ' . $size . 'px; margin: ' . $margin . 'px ' . $margin . 'px 0 0;"><i style="font-size: ' . $size . 'px; line-height: ' . $size . 'px; height: ' . $size . 'px; width: ' . $size . 'px;" class="' . esc_attr($class_key) . '"></i></a>';
                                            }
                                        } else if ($class_group[0] == "transparent") {
                                            if ($value == 'transparent') {
                                                $output .= '<a class="TS_VCSC_Icon_Empty TS_VCSC_Icon_Link ts-no-icon current" href="#" title="' . __( "Icon Name:", "ts_visual_composer_extend" ) . ' ' . __( "No Icon", "ts_visual_composer_extend" ) . '" data-group="" rel="transparent" style="height: ' . $size . 'px; width: ' . $size . 'px; margin: ' . $margin . 'px ' . $margin . 'px 0 0;">r<div class="selector-tick"></div></a>';
                                            } else {
                                                $output .= '<a class="TS_VCSC_Icon_Empty TS_VCSC_Icon_Link ts-no-icon" href="#" title="' . __( "Icon Name:", "ts_visual_composer_extend" ) . ' ' . __( "No Icon", "ts_visual_composer_extend" ) . '" data-group="" rel="transparent" style="height: ' . $size . 'px; width: ' . $size . 'px; margin: ' . $margin . 'px ' . $margin . 'px 0 0;">r</a>';
                                            }
                                        } else {
                                            if ($value == esc_attr($class_key)) {
                                                $output .= '<a class="TS_VCSC_Icon_Taken TS_VCSC_Icon_Link current" href="#" title="' . __( "Icon Name:", "ts_visual_composer_extend" ) . ' ' . esc_attr($class_key) . '" data-group="' . $font . '" data-filter="false" data-font="font-' . $class_group[0] . '" data-icon="' . esc_attr($class_key) . '" rel="' . esc_html(current($label)) . '" style="height: ' . $size . 'px; width: ' . $size . 'px; margin: ' . $margin . 'px ' . $margin . 'px 0 0;"><i style="font-size: ' . $size . 'px; line-height: ' . $size . 'px; height: ' . $size . 'px; width: ' . $size . 'px;" class="' . esc_attr($class_key) . '"></i><div class="selector-tick"></div></a>';
                                            } else {
                                                $output .= '<a class="TS_VCSC_Icon_Taken TS_VCSC_Icon_Link" href="#" title="' . __( "Icon Name:", "ts_visual_composer_extend" ) . ' ' . esc_attr($class_key) . '" data-group="' . $font . '" data-filter="false" data-font="font-' . $class_group[0] . '" data-icon="' . esc_attr($class_key) . '" rel="' . esc_html(current($label)) . '" style="height: ' . $size . 'px; width: ' . $size . 'px; margin: ' . $margin . 'px ' . $margin . 'px 0 0;"><i style="font-size: ' . $size . 'px; line-height: ' . $size . 'px; height: ' . $size . 'px; width: ' . $size . 'px;" class="' . esc_attr($class_key) . '"></i></a>';
                                            }
                                        }
                                    }
                                }
                            }
                            // Add Custom Upload Font
                            if ((get_option('ts_vcsc_extend_settings_tinymceCustom', 0) == 1) && ($custom == "true")) {                       
                                foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Icons_Compliant_Custom as $group => $icons) {
                                    if (!is_array($icons) || !is_array(current($icons))) {
                                        $class_key      = key($icons);
                                        $class_group    = explode('-', esc_attr($class_key));
                                        if ($value == esc_attr($class_key)) {
                                            $output .= '<a class="TS_VCSC_Icon_Taken TS_VCSC_Icon_Link current" href="#" title="' . __( "Icon Name:", "ts_visual_composer_extend" ) . ' ' . esc_attr($class_key) . '" data-group="" data-filter="false" data-font="font-custom" data-icon="' . esc_attr($class_key) . '" rel="' . esc_attr($class_key) . '" style="height: ' . $size . 'px; width: ' . $size . 'px; margin: ' . $margin . 'px ' . $margin . 'px 0 0;"><i style="font-size: ' . $size . 'px; line-height: ' . $size . 'px; height: ' . $size . 'px; width: ' . $size . 'px;" class="' . esc_attr($class_key) . '"></i><div class="selector-tick"></div></a>';
                                        } else {
                                            $output .= '<a class="TS_VCSC_Icon_Taken TS_VCSC_Icon_Link" href="#" title="' . __( "Icon Name:", "ts_visual_composer_extend" ) . ' ' . esc_attr($class_key) . '" data-group="" data-filter="false" data-font="font-custom" data-icon="' . esc_attr($class_key) . '" rel="' . esc_attr($class_key) . '" style="height: ' . $size . 'px; width: ' . $size . 'px; margin: ' . $margin . 'px ' . $margin . 'px 0 0;"><i style="font-size: ' . $size . 'px; line-height: ' . $size . 'px; height: ' . $size . 'px; width: ' . $size . 'px;" class="' . esc_attr($class_key) . '"></i></a>';
                                        }
                                    } else {
                                        foreach ($icons as $key => $label) {
                                            $class_key      = key($label);
                                            $class_group    = explode('-', esc_attr($class_key));
                                            $font           = str_replace("(", "", strtolower(strtolower(esc_attr($group))));
                                            $font           = str_replace(")", "", strtolower($font));
                                            if ($value == esc_attr($class_key)) {
                                                $output .= '<a class="TS_VCSC_Icon_Taken TS_VCSC_Icon_Link current" href="#" title="' . __( "Icon Name:", "ts_visual_composer_extend" ) . ' ' . esc_attr($class_key) . '" data-group="' . $font . '" data-filter="false" data-font="font-custom" data-icon="' . esc_attr($class_key) . '" rel="' . esc_attr($class_key) . '" style="height: ' . $size . 'px; width: ' . $size . 'px; margin: ' . $margin . 'px ' . $margin . 'px 0 0;"><i style="font-size: ' . $size . 'px; line-height: ' . $size . 'px; height: ' . $size . 'px; width: ' . $size . 'px;" class="' . esc_attr($class_key) . '"></i><div class="selector-tick"></div></a>';
                                            } else {
                                                $output .= '<a class="TS_VCSC_Icon_Taken TS_VCSC_Icon_Link" href="#" title="' . __( "Icon Name:", "ts_visual_composer_extend" ) . ' ' . esc_attr($class_key) . '" data-group="' . $font . '" data-filter="false" data-font="font-custom" data-icon="' . esc_attr($class_key) . '" rel="' . esc_attr($class_key) . '" style="height: ' . $size . 'px; width: ' . $size . 'px; margin: ' . $margin . 'px ' . $margin . 'px 0 0;"><i style="font-size: ' . $size . 'px; line-height: ' . $size . 'px; height: ' . $size . 'px; width: ' . $size . 'px;" class="' . esc_attr($class_key) . '"></i></a>';
                                            }
                                        }
                                    }
                                }                            
                            }			
                        $output .= '</div>';
                    $output .= '</div>';
                } else {
                    $previewURL = site_url() . '/wp-admin/admin.php?page=TS_VCSC_Previews';			
                    $output .= '<input name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="text" value="' . $value . '"/>';
                    $output .= '<a href="' . $previewURL . '" target="_blank">' . __( "Find Icon Class Name", "ts_visual_composer_extend" ) . '</a>';
                }
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_IconsPanel')) {
        $TS_Parameter_IconsPanel = new TS_Parameter_IconsPanel();
    }
?>