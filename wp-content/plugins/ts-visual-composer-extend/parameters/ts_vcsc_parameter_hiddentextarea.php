<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_HiddenTextArea')) {
        class TS_Parameter_HiddenTextArea {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('hidden_textarea', array(&$this, 'hiddentextarea_setting_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('hidden_textarea', array(&$this, 'hiddentextarea_setting_field'));
				}
            }        
            function hiddentextarea_setting_field($settings, $value){
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $radios         = isset($settings['options']) ? $settings['options'] : '';
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $output 		= '';
                $output .= '<textarea name="' . $param_name . '" id="' . $param_name . '" class="wpb_vc_param_value ts_shortcode_hidden ' . $param_name . ' ' . $type . '" style="display: none !important;">' . $value . '</textarea>';
                return $output;
            }  
        }
    }
    if (class_exists('TS_Parameter_HiddenTextArea')) {
        $TS_Parameter_HiddenTextArea = new TS_Parameter_HiddenTextArea();
    }
?>