<?php
    /*
    Additional Setting Options:
        array(
            "type"          => "switch_button",
			"value"         => "true",
			"on"            => __( 'Yes', "ts_visual_composer_extend" ),
			"off"           => __( 'No', "ts_visual_composer_extend" ),
			"style"         => "select",
			"design"        => "toggle-light",
			"width"         => 80,
        )
    */
    if (!class_exists('TS_Parameter_Switch')) {
        class TS_Parameter_Switch {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
                    vc_add_shortcode_param('switch_button', array(&$this, 'switch_button_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
					add_shortcode_param('switch_button', array(&$this, 'switch_button_settings_field'));
				}
            }        
            function switch_button_settings_field($settings, $value) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name'])    ? $settings['param_name']   : '';
                $type           = isset($settings['type'])          ? $settings['type']         : '';
                $on            	= isset($settings['on'])            ? $settings['on']           : __( "On", "ts_visual_composer_extend" );
                $off            = isset($settings['off'])           ? $settings['off']          : __( "Off", "ts_visual_composer_extend" );
                $style			= isset($settings['style'])         ? $settings['style']        : 'select'; 			// 'compact' or 'select'
                $design			= isset($settings['design'])        ? $settings['design']       : 'toggle-light'; 	    // 'toggle-light', 'toggle-modern' or 'toggle'soft'
                $width			= isset($settings['width'])         ? $settings['width']        : '80';
                $suffix         = isset($settings['suffix'])        ? $settings['suffix']       : '';
                $class          = isset($settings['class'])         ? $settings['class']        : '';
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $output         = '';
                $output .= '<div class="ts-switch-button ts-composer-switch" data-value="' . $value . '" data-width="' . $width . '" data-style="' . $style . '" data-on="' . $on . '" data-off="' . $off . '">';
                    $output .= '<input type="hidden" style="display: none; " class="toggle-input wpb_vc_param_value ' . $param_name . ' ' . $type . '" value="' . $value . '" name="' . $param_name . '"/>';
                    $output .= '<div class="toggle ' . $design . '" style="width: ' . $width . 'px; height: 20px;">';
                        $output .= '<div class="toggle-slide">';
                            $output .= '<div class="toggle-inner">';
                                $output .= '<div class="toggle-on ' . ($value == 'true' ? 'active' : '') . '">' . $on . '</div>';
                                $output .= '<div class="toggle-blob"></div>';
                                $output .= '<div class="toggle-off ' . ($value == 'false' ? 'active' : '') . '">' . $off . '</div>';
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</div>';
                $output .= '</div>';
                return $output;
            }            
        }
    }
    if (class_exists('TS_Parameter_Switch')) {
        $TS_Parameter_Switch = new TS_Parameter_Switch();
    }
?>