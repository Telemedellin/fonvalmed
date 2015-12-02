<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_SocialNetworks')) {
        class TS_Parameter_SocialNetworks {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('social_networks', array(&$this, 'socialnetworks_setting_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('social_networks', array(&$this, 'socialnetworks_setting_field'));
				}
            }        
            function socialnetworks_setting_field($settings, $value){
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $default        = isset($settings['default']) ? $settings['default'] : '';
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $output 		= '';                
                if (($value == '') && ($default != '')) {
                    $value      = $default;
                }
                $output .= '<input name="' . $param_name . '" id="' . $param_name . '" data-default="' . $default . '" class="wpb_vc_param_value ts_shortcode_hidden ' . $param_name . ' ' . $type . '" type="text" value="' . $value . '"/>';
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_SocialNetworks')) {
        $TS_Parameter_SocialNetworks = new TS_Parameter_SocialNetworks();
    }
?>