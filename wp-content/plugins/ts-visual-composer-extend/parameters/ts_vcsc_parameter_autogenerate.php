<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_AutoGenerate')) {
        class TS_Parameter_AutoGenerate {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('auto_generate', array(&$this, 'autogenerate_setting_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('auto_generate', array(&$this, 'autogenerate_setting_field'));
				}
            }        
            function autogenerate_setting_field($settings, $value){
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $prefix         = isset($settings['prefix']) ? $settings['prefix'] : '';
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
				$output 		= '';
				$time			= time() * 1000;
				$random 		= mt_rand (0, 1000000);				
				if ($value == '') {
					$value		= $prefix . '' . $time . '-' . $random;
				}
				$output .= '<div class="my_param_block"><input name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $param_name . ' ' . $type . '_field" type="hidden" value="' . $value . '" /><label>' . $value . '</label></div>';
				return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_AutoGenerate')) {
        $TS_Parameter_AutoGenerate = new TS_Parameter_AutoGenerate();
    }
?>