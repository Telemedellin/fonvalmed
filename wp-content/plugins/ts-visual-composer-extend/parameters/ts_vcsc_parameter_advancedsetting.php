<?php
    /*
     *  Use in Shortcode:
     *  $element_paramter = str_replace('|', '', $element_paramter);
     *  
     *
     *  Use in Element Settings:
     * 	array(
            "type" 					=> "advanced_styling",
            "style_type"			=> "border", // border, margin, padding
            "show_main"				=> "true",
            "show_preview"          => "true",
            "show_style"			=> "true",
            "show_radius" 			=> "true",					
            "show_color"			=> "true",
            "show_unit_width"		=> "true",
            "show_unit_radius"		=> "true",				
            "default_positions"     => array(
				__("All", "ts_visual_composer_extend")     		    => array("width" => "1", "unitwidth" => "px", "style" => "solid", "color" => "#cccccc", "radius" => "0", "unitradius" => "px"),
				__("Top", "ts_visual_composer_extend")     			=> array("width" => "1", "unitwidth" => "px", "style" => "solid", "color" => "#cccccc", "radius" => "0", "unitradius" => "px"),
				__("Right", "ts_visual_composer_extend")   			=> array("width" => "1", "unitwidth" => "px", "style" => "solid", "color" => "#cccccc", "radius" => "0", "unitradius" => "px"),
				__("Bottom", "ts_visual_composer_extend")  			=> array("width" => "1", "unitwidth" => "px", "style" => "solid", "color" => "#cccccc", "radius" => "0", "unitradius" => "px"),
				__("Left", "ts_visual_composer_extend")    			=> array("width" => "1", "unitwidth" => "px", "style" => "solid", "color" => "#cccccc", "radius" => "0", "unitradius" => "px"),
            ),
            "label_preview"         => "Border Preview",
            "label_width"           => "Border Width",
            "label_border"          => "Border Style",
            "label_radius"          => "Border Radius",
            "label_color"           => "Border Color",
        ),
     */
    if (!class_exists('TS_Parameter_AdvancedStyling')) {
        class TS_Parameter_AdvancedStyling {
            function __construct() { 
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('advanced_styling', array($this, 'advanced_styling_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('advanced_styling', array($this, 'advanced_styling_settings_field'));
				}
            }            
            function advanced_styling_settings_field($settings, $value) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency                     = vc_generate_dependencies_attributes($settings);
                $style_type                     = isset($settings['style_type']) ? $settings['style_type'] : 'border';
                // Activated Section
                $show_main                      = isset($settings['show_main']) ? $settings['show_main'] : 'true';
                $show_preview                   = isset($settings['show_preview']) ? $settings['show_preview'] : 'true';
                $show_width                     = isset($settings['show_width']) ? $settings['show_width'] : 'true';
                $show_style                     = isset($settings['show_style']) ? $settings['show_style'] : 'true';
                $show_color                     = isset($settings['show_color']) ? $settings['show_color'] : 'true';
                $show_radius                    = isset($settings['show_radius']) ? $settings['show_radius'] : 'true';
                $show_unit_width                = isset($settings['show_unit_width']) ? $settings['show_unit_width'] : 'false';
                $show_unit_radius               = isset($settings['show_unit_radius']) ? $settings['show_unit_radius'] : 'false';
                // Default Settings
                $default_positions              = isset($settings['default_positions']) ? $settings['default_positions'] : array();
                $default_radius                 = isset($settings['default_radius']) ? $settings['default_radius'] : array();              
                // Label Settings
                $label_preview                  = isset($settings['label_preview']) ? $settings['label_preview'] : 'Border Preview';
                $label_width                    = isset($settings['label_width']) ? $settings['label_width'] : 'Border Width';
                $label_border                   = isset($settings['label_border']) ? $settings['label_border'] : 'Border Style';
                $label_radius                   = isset($settings['label_radius']) ? $settings['label_radius'] : 'Border Radius';
                $label_color                    = isset($settings['label_color']) ? $settings['label_color'] : 'Border Color';
                $label_auto                     = isset($settings['label_auto']) ? $settings['label_auto'] : 'Auto';
                $label_unit_width               = isset($settings['label_unit_width']) ? $settings['label_unit_width'] : 'Width Unit';
                $label_unit_radius              = isset($settings['label_unit_radius']) ? $settings['label_unit_radius'] : 'Radius Unit';
                $label_button_show              = isset($settings['label_button_show']) ? $settings['label_button_show'] : 'Show Settings';
                $label_button_hide              = isset($settings['label_button_hide']) ? $settings['label_button_hide'] : 'Hide Settings';
                // Other Settings
                $random_id_number               = rand(100000, 999999);
                $random_id_container            = 'ts-advanced-styling-container-' . $random_id_number;
                $random_id_input                = 'ts-advanced-styling-input-' . $random_id_number;
				$url            				= $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
				$container_style				= '';
                // Checkups
                $all_container                  = (array_key_exists("All", $default_positions) ? 'true' : 'false');
                if ($show_preview == 'false') {$show_main = 'true';}
                if ($style_type != "border") {
                    $show_main                  = 'true';
                    $show_preview               = 'false';
                    $show_style                 = 'false';
                    $show_radius                = 'false';
                    $show_color                 = 'false';
                    $show_unit_radius           = 'false';
					if ($show_unit_width == "false") {
						$container_style		= 'display: inline-block; width: 25%; border-bottom: none;';
					}
                }
                // Build Parameter
                $html = '<div id="' . $random_id_container . '" class="ts-advanced-styling" data-type="' . $style_type . '" data-show-main="' . $show_main . '" data-show-preview="' . $show_preview . '" data-show-side="true" data-show-radius="' . $show_radius . '" data-show-style="' . $show_style . '" data-show-color="' . $show_color . '" data-show-unit-width="' . $show_unit_width . '" data-show-unit-radius="' . $show_unit_radius . '">';
                    // Preview Container
                    if (($style_type == "border") && ($show_preview == 'true')) {
                        $html .= '<div class="ts-advanced-styling-preview-container">';
                            $html .= '<div class="ts-advanced-styling-preview-label">' . $label_preview . '</div>';
                            $html .= '<div class="ts-advanced-styling-preview-button" data-label-show="' . $label_button_show . '" data-label-hide="' . $label_button_hide . '"><div class="vc_btn vc_btn-primary">' . ($show_main == 'true' ? $label_button_hide : $label_button_show) . '</div></div>';
                        $html .= '</div>';
                    }
                    // Settings Container
                    $html .= '<div class="ts-advanced-styling-main-container ' . ($show_main == 'true' ? 'ts-advanced-styling-main-container-show' : 'ts-advanced-styling-main-container-hide') . '">';                        
                        if ($style_type == "border") {
                            $string_part1       = "border";
                            $string_part2       = "-";
                            $string_part3       = "-";
                            $string_part4       = "width";
                            $string_part5       = "style";
                            $string_part6       = "color";
                        } else if ($style_type == "margin") {
                            $string_part1       = "margin";
                            if ($all_container == 'true') {
                                $string_part2   = "";
                            } else {
                                $string_part2   = "-";
                            }
                            $string_part3       = "";
                            $string_part4       = "";
                            $string_part5       = "";
                            $string_part6       = "";
                        } else if ($style_type == "padding") {
                            $string_part1       = "padding";
                            if ($all_container == 'true') {
                                $string_part2   = "";
                            } else {
                                $string_part2   = "-";
                            }
                            $string_part3       = "";
                            $string_part4       = "";
                            $string_part5       = "";
                            $string_part6       = "";
                        }
                        foreach ($default_positions as $position => $default_value) {
                            if ((($all_container == 'true') && ($position == 'All')) || ($all_container == 'false')) {
                                if (($all_container == 'true') && ($position == 'All')) {
                                    $id_width           = $string_part1 . $string_part2 . $string_part4;
                                    $id_style           = $string_part1 . $string_part2 . $string_part5;
                                    $id_color           = $string_part1 . $string_part2 . $string_part6;
                                } else {
                                    $id_width           = $string_part1 . $string_part2 . strtolower($position) . $string_part3 . $string_part4;
                                    $id_style           = $string_part1 . $string_part2 . strtolower($position) . $string_part3 . $string_part5;
                                    $id_color           = $string_part1 . $string_part2 . strtolower($position) . $string_part3 . $string_part6;
                                }
                                switch (strtolower($position)) {
                                    case 'all':
                                        $corner         = 'radius';
                                        if ($style_type == "border") {
                                            $icon_side  = 'dashicons dashicons-minus';
                                        } else {
                                            $icon_side  = 'dashicons dashicons-editor-expand';
                                        }
                                        $icon_corner    = 'dashicons dashicons-marker';
                                        $placeholder    = 'All';
                                        break;
                                    case 'top':
                                        $corner         = 'top-left-radius';
                                        $icon_side      = 'dashicons dashicons-arrow-up-alt';
                                        $icon_corner    = 'dashicons dashicons-arrow-up-alt2 ts-advanced-styling-corner-top-left';
                                        $placeholder    = 'T.L.';
                                        break;
                                    case 'right':
                                        $corner         = 'top-right-radius';
                                        $icon_side      = 'dashicons dashicons-arrow-right-alt';
                                        $icon_corner    = 'dashicons dashicons-arrow-right-alt2 ts-advanced-styling-corner-top-right';
                                        $placeholder    = 'T.R.';
                                        break;
                                    case 'bottom':
                                        $corner         = 'bottom-right-radius';
                                        $icon_side      = 'dashicons dashicons-arrow-down-alt';
                                        $icon_corner    = 'dashicons dashicons-arrow-down-alt2 ts-advanced-styling-corner-bottom-left';
                                        $placeholder    = 'B.L.';
                                        break;
                                    case 'left':
                                        $corner         = 'bottom-left-radius';
                                        $icon_side      = 'dashicons dashicons-arrow-left-alt';
                                        $icon_corner    = 'dashicons dashicons-arrow-left-alt2 ts-advanced-styling-corner-bottom-right';
                                        $placeholder    = 'B.R.';
                                        break;
                                }
                                if ($all_container == 'true') {$position = '';}
                                $html .= '<div class="ts-advanced-styling-side-container" style="' . $container_style . '" data-type="' . $style_type . '" data-group="' . $string_part1 . $string_part2 . strtolower($position) . '" data-side="' . strtolower($position) . '" data-radius="' . $corner . '">';
                                    $html .= '<div class="ts-advanced-styling-side-trigger" >';
                                        if ($show_width == 'true') {
                                            $default_width          = (isset($default_value['width']) ? $default_value['width'] : '0');
                                            $default_unit_width     = (isset($default_value['unitwidth']) ? $default_value['unitwidth'] : 'px');
                                            $html .= '<div class="ts-advanced-styling-side-width" >';                                            
                                                $html .= $this->TS_VCSC_AdvancedSetting_Width_Side($icon_side, $default_unit_width, $default_width, $label_width, $position, $id_width);
                                                $html .= $this->TS_VCSC_AdvancedSetting_Get_Unit('width', $default_unit_width, $id_width);
                                            $html .= '</div>';
                                        }
                                        if ($show_radius == 'true') {
                                            $default_radius         = (isset($default_value['radius']) ? $default_value['radius'] : '0');
                                            $default_unit_radius    = (isset($default_value['unitradius']) ? $default_value['unitradius'] : 'px');
                                            $html .= '<div class="ts-advanced-styling-side-radius" >';                                            
                                                $html .= $this->TS_VCSC_AdvancedSetting_Border_Radius($icon_corner, $default_unit_radius, $default_radius, $label_radius, $corner, $placeholder);
                                                $html .= $this->TS_VCSC_AdvancedSetting_Get_Unit('radius', $default_unit_radius, $corner);
                                            $html .= '</div>';
                                        }
                                    $html .= '</div>';
                                    $html .= '<div class="ts-advanced-styling-side-content" >';
                                        if ($show_width == 'true') {
                                            if ($show_unit_width == 'true') {
                                                $html .= $this->TS_VCSC_AdvancedSetting_Unit_Selector('width', $label_unit_width, $default_unit_width, $id_width);
                                            }
                                            if (($style_type == "margin") && ((strtolower($position) == "left") || (strtolower($position) == "right"))) {
                                                $default_auto  = (isset($default_value['auto']) ? $default_value['auto'] : 'false');
                                                $html .= $this->TS_VCSC_AdvancedSetting_Auto_Checkbox($label_auto, $default_auto, $style_type, $id_width);
                                            }
                                            if ($show_style == 'true') {
                                                $default_style = (isset($default_value['style']) ? $default_value['style'] : 'solid');
                                                $html .= $this->TS_VCSC_AdvancedSetting_Border_Style($label_border, $default_style, $id_style, 'false');
                                            }
                                            if ($show_color == 'true') {
                                                $default_color = (isset($default_value['color']) ? $default_value['color'] : '#cccccc');
                                                $html .= $this->TS_VCSC_AdvancedSetting_Border_Color($default_color, $label_color, $id_color);
                                            }
                                        }
                                        if (($show_radius == 'true') && ($show_unit_radius == 'true')) {
                                            $html .= $this->TS_VCSC_AdvancedSetting_Unit_Selector('radius', $label_unit_radius, $default_unit_radius, $corner);
                                        }
                                    $html .= '</div>';
                                $html .= '</div>';
                            }
                        }
                    $html .= '</div>';
                    // Add Hidden Input to Store Data
                    $html .= '<input id="' . $random_id_input . '" type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value ts-advanced-styling-value ' . $settings['param_name'] . ' ' . $settings['type'] . '_field" value="' . $value . '" ' . $dependency . ' />';
                $html .= '</div>';
                // Return Parameter
                return $html;
            }
            // Function to Create Input for Single Width / Margin / Padding (Side)
            function TS_VCSC_AdvancedSetting_Width_Side($font_icon, $default_unit, $default_value, $label_width, $position, $id) {
                $html = '<div class="ts-advanced-styling-label ts-advanced-styling-tooltip">' . ($label_width != '' ? $label_width : $position) . '<i class="dashicons dashicons-editor-help"><span class="ts-element-settings-tooltip">' . $id . '</span></i></div>';
                $html .= '<div class="ts-advanced-styling-input-block">';
                    $html .= '<span class="ts-advanced-styling-icon"><i class="' . $font_icon . '"></i></span>';
                    $html .= '<input type="number" class="ts-advanced-styling-inputs ts-advanced-styling-input" min="0" max="100" data-type="width" data-unit="' . $default_unit . '" data-default="' . $default_value . '" data-group="' . $id . '" placeholder="' . $position . '" />';
                $html .= '</div>';
                return $html;
            }
            // Function to Create Input for Single Border Radius (Corner)
            function TS_VCSC_AdvancedSetting_Border_Radius($font_icon, $default_unit, $default_value, $label_radius, $corner, $placeholder) {
                $html = '<div class="ts-advanced-styling-label ts-advanced-styling-tooltip">' . $label_radius . '<i class="dashicons dashicons-editor-help"><span class="ts-element-settings-tooltip">border-' . $corner . '</span></i></div>';
                $html .= '<div class="ts-advanced-styling-radius-block">';
                    $html .= '<span class="ts-advanced-styling-icon"><i class="' . $font_icon . '"></i></span>';
                    $html .= '<input type="number" class="ts-advanced-styling-inputs ts-advanced-styling-input" min="0" max="100" data-type="radius" data-unit="' . $default_unit . '" data-default="' . $default_value . '" data-group="border-' . $corner . '" placeholder="' . $placeholder . '" />';
                $html .= '</div>';
                return $html;
            }
            // Function to Create Checkbox for Auto-Margin / Padding
            function TS_VCSC_AdvancedSetting_Auto_Checkbox($label_auto, $default_value, $type, $id) {
                $html = '<div class="ts-advanced-styling-auto-section">';
                    $html .= '<div class="ts-advanced-styling-label">' . $label_auto . '<i class="ts-advanced-styling-tooltip dashicons dashicons-editor-help"><span class="ts-element-settings-tooltip">' . $id . '</span></i></div>';
                    $html .= '<div class="ts-advanced-styling-auto-block">';
                        $html .= '<input type="checkbox" class="ts-advanced-styling-inputs ts-advanced-styling-input" data-type="margin" data-default="' . $default_value . '" data-auto="checkbox-' . $id. '" data-group="' . $id. '" ' . checked($default_value, 'true', true) . '>';
                    $html .= '</div>';
                $html .= '</div>';
                return $html;
            }
            // Function to Create Single Style Picker (Border)
            function TS_VCSC_AdvancedSetting_Border_Style($label_border, $default, $id, $section) {
                $html = '<div class="ts-advanced-styling-style-section">';
                    $html .= '<div class="ts-advanced-styling-label ts-advanced-styling-tooltip">' . $label_border . '<i class="dashicons dashicons-editor-help"><span class="ts-element-settings-tooltip">' . $id . '</span></i></div>';
                    $html .= '<div class="ts-advanced-styling-select-block">';
                        $html .= '<select data-placeholder="Border Style" class="ts-advanced-styling-style-selector" data-group="' . $id . '">';                                    
                            $html .= '<option value="solid" ' . selected($default, "solid") . '>' . __('Solid','ts_visual_composer_extend') . '</option>';
                            $html .= '<option value="dashed" ' . selected($default, "dashed") . '>' . __('Dashed','ts_visual_composer_extend') . '</option>';
                            $html .= '<option value="dotted" ' . selected($default, "dotted") . '>' . __('Dotted','ts_visual_composer_extend') . '</option>';
                            $html .= '<option value="double" ' . selected($default, "double") . '>' . __('Double','ts_visual_composer_extend') . '</option>';
                            $html .= '<option value="inset" ' . selected($default, "inset") . '>' . __('Inset','ts_visual_composer_extend') . '</option>';
                            $html .= '<option value="outset" ' . selected($default, "outset") . '>' . __('Outset','ts_visual_composer_extend') . '</option>';
                            $html .= '<option value="none" ' . selected($default, "none") . '>' . __('None','ts_visual_composer_extend') . '</option>';
                        $html .= '</select>';
                    $html .= '</div>';
                $html .= '</div>';
                return $html;
            }
            // Function to Create Single ColorPicker (Border)
            function TS_VCSC_AdvancedSetting_Border_Color($default_color, $label_color, $id) {
                $html = '<div class="ts-advanced-styling-color-section">';
                    $html .= '<div class="ts-advanced-styling-label ts-advanced-styling-tooltip">' . $label_color . '<i class="dashicons dashicons-editor-help"><span class="ts-element-settings-tooltip">' . $id . '</span></i></div>';
                    $html  .= '<div class="ts-advanced-styling-color-block">';
                        $html .= '<input class="ts-advanced-styling-colorpicker vc_color-control" type="text" data-group="' . $id . '" data-default="' . $default_color . '" value="' . $default_color . '" />';
                    $html .= '</div>';
                $html .= '</div>';
                return $html;
            }
            // Function to Create Unit Selector
            function TS_VCSC_AdvancedSetting_Unit_Selector($type, $label, $default, $id) {
                if ($type == 'radius') {$pretext = 'border-';} else {$pretext = '';}
                $html = '<div class="ts-advanced-styling-unit-' . $type . '-section">';
                    $html .= '<div class="ts-advanced-styling-label ts-advanced-styling-tooltip">' . $label . '<i class="dashicons dashicons-editor-help"><span class="ts-element-settings-tooltip">' . $pretext . $id . '</span></i></div>';
                    $html .= '<div class="ts-advanced-styling-select-block" data-group="' . $pretext . $id . '" data-default="' . $default . '">';
                        $html .= '<select data-placeholder="Width Units" class="ts-advanced-styling-unit-' . $type . '-selector" data-group="' . $pretext . $id . '">';
                            $html .= '<option value="px" ' . selected($default, "px") . '>' . __('Pixels (px)','ts_visual_composer_extend') . '</option>';
                            $html .= '<option value="%" ' . selected($default, "%") . '>' . __('Percent (%)','ts_visual_composer_extend') . '</option>';
                            $html .= '<option value="em" ' . selected($default, "em") . '>' . __('EM (em)','ts_visual_composer_extend') . '</option>';
                            $html .= '<option value="rem" ' . selected($default, "rem") . '>' . __('REM (rem)','ts_visual_composer_extend') . '</option>';
                        $html .= '</select>';
                    $html .= '</div>';
                $html .= '</div>';
                return $html;
            }
            // Function to Create Label Border Units
            function TS_VCSC_AdvancedSetting_Get_Unit($type, $default_unit, $id) {
                if ($type == 'radius') {$pretext = 'border-';} else {$pretext = '';}
                $html = '<div class="ts-advanced-styling-unit-' . $type . '-label" data-group="' . $pretext . $id . '"><label>' . $default_unit . '</label></div>';
                return $html;
            }
        }
    }
    if (class_exists('TS_Parameter_AdvancedStyling')) {
        $TS_Parameter_AdvancedStyling = new TS_Parameter_AdvancedStyling();
    }
?>