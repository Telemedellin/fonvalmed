<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_NoUiSlider')) {
        class TS_Parameter_NoUiSlider {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
                    vc_add_shortcode_param('nouislider', array(&$this, 'nouislider_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('nouislider', array(&$this, 'nouislider_settings_field'));
				}
            }        
            function nouislider_settings_field($settings, $value) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $min            = isset($settings['min']) ? $settings['min'] : '';
                $max            = isset($settings['max']) ? $settings['max'] : '';
                $step           = isset($settings['step']) ? $settings['step'] : '';
                $unit           = isset($settings['unit']) ? $settings['unit'] : '';
                $decimals		= isset($settings['decimals']) ? $settings['decimals'] : 0;
                $suffix         = isset($settings['suffix']) ? $settings['suffix'] : '';
                $class          = isset($settings['class']) ? $settings['class'] : '';
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $output         = '';
                $output 		.= '<div class="ts-nouislider-input-slider">';
                    $output 		.= '<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="' . $param_name . '"  class="ts-nouislider-serial nouislider-input-selector nouislider-input-composer wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="number" min="' . $min . '" max="' . $max . '" step="' . $step . '" value="' . $value . '"/>';
                        $output 		.= '<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">' . $unit . '</span>';
                    $output 		.= '<div class="ts-nouislider-input ts-nouislider-input-element" data-value="' . $value . '" data-min="' . $min . '" data-max="' . $max . '" data-decimals="' . $decimals . '" data-step="' . $step . '" style="width: 250px; float: left; margin-top: 10px;"></div>';
                $output 		.= '</div>';
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_NoUiSlider')) {
        $TS_Parameter_NoUiSlider = new TS_Parameter_NoUiSlider();
    }
?>