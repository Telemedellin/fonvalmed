<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_Separator')) {
        class TS_Parameter_Separator {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
                    vc_add_shortcode_param('seperator', array(&$this, 'seperator_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('seperator', array(&$this, 'seperator_settings_field'));
				}
            }        
            function seperator_settings_field($settings, $value) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $seperator		= isset($settings['seperator']) ? $settings['seperator'] : '';
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $output         = '';
                if ($seperator != '') {
                    $output		.= '<div id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . '" name="' . $param_name . '" style="border-bottom: 2px solid #DDDDDD; margin-bottom: 10px; margin-top: 10px; padding-bottom: 10px; font-size: 20px; font-weight: bold; color: #BFBFBF;">' . $seperator . '</div>';
                } else {
                    $output		.= '<div id="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . '" name="' . $param_name . '" style="border-bottom: 2px solid #DDDDDD; margin-bottom: 10px; margin-top: 10px; padding-bottom: 10px; font-size: 20px; font-weight: bold; color: #BFBFBF;">' . $value . '</div>';
                }
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_Separator')) {
        $TS_Parameter_Separator = new TS_Parameter_Separator();
    }
?>