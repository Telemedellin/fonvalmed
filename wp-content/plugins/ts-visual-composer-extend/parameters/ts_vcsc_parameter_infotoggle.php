<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_InfoToggle')) {
        class TS_Parameter_InfoToggle {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('infotoggle', array(&$this, 'infotoggle_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('infotoggle', array(&$this, 'infotoggle_settings_field'));
				}
            }        
            function infotoggle_settings_field($settings, $value) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';                
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $content        = isset($settings['content']) ? $settings['content'] : '';
                $title          = isset($settings['title']) ? $settings['title'] : '';
                $opened         = isset($settings['opened']) ? $settings['opened'] : 'true';
                $color			= isset($settings['color']) ? $settings['color'] : '#000000';
                $weight			= isset($settings['weight']) ? $settings['weight'] : 'normal';
                $size			= isset($settings['size']) ? $settings['size'] : '12';            
                $margin_top     = isset($settings['margin_top']) ? $settings['margin_top'] : '10';
                $margin_bottom  = isset($settings['margin_bottom']) ? $settings['margin_bottom'] : '10';
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $output         = '';
                if ($content != '') {
                    $output 	.= '<div id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . '" name="' . $param_name . '" style="text-align: justify; ' . ($border_top == "true" ? "border-top: 1px solid #dddddd;" : "") . ' ' . ($border_bottom == "true" ? "border-bottom: 1px solid #dddddd;" : "") . ' color: ' . $color . '; margin: ' . $margin_top . 'px 0 ' . $margin_bottom . 'px 0; padding: ' . $padding_top . 'px 0 ' . $padding_bottom . 'px 0; font-size: ' . $size . 'px; font-weight: ' . $weight . ';">' . $message . '</div>';
                } else {
                    $output 	.= '<div id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . '" name="' . $param_name . '" style="text-align: justify; ' . ($border_top == "true" ? "border-top: 1px solid #dddddd;" : "") . ' ' . ($border_bottom == "true" ? "border-bottom: 1px solid #dddddd;" : "") . ' color: ' . $color . '; margin: ' . $margin_top . 'px 0 ' . $margin_bottom . 'px 0; padding: ' . $padding_top . 'px 0 ' . $padding_bottom . 'px 0; font-size: ' . $size . 'px; font-weight: ' . $weight . ';">' . $value . '</div>';
                }
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_InfoToggle')) {
        $TS_Parameter_InfoToggle = new TS_Parameter_InfoToggle();
    }
?>