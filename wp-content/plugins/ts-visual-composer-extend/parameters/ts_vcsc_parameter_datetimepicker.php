<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_DateTimePicker')) {
        class TS_Parameter_DateTimePicker {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('datetime_picker', array(&$this, 'datetimepicker_setting_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('datetime_picker', array(&$this, 'datetimepicker_setting_field'));
				}
            }        
            function datetimepicker_setting_field($settings, $value){
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $radios         = isset($settings['options']) ? $settings['options'] : '';
                $period         = isset($settings['period']) ? $settings['period'] : '';
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $output 		= '';
                if ($period == "datetime") {
                    $output 		.= '<div class="ts-datetime-picker-element">';
                        $output 	.= '<input name="' . $param_name . '" id="' . $param_name . '" class="ts-datetimepicker-value wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="hidden" value="' . $value . '"/>';
                        //$output		.= '<input class="ts-datetimepicker-clear" type="button" value="Clear" style="width: 150px; text-align: center; display: block; height: 30px; padding: 5px; font-size: 12px; line-height: 12px; margin-bottom: 10px;">';
                        $output 	.= '<input class="ts-datetimepicker" type="text" placeholder="" value="' . $value . '"/>';
                    $output 		.= '</div>';
                } else if ($period == "date") {
                    $output 		.= '<div class="ts-date-picker-element">';
                        $output 	.= '<input name="' . $param_name . '" id="' . $param_name . '" class="ts-datepicker-value wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="hidden" value="' . $value . '"/>';
                        //$output		.= '<input class="ts-datetimepicker-clear" type="button" value="Clear" style="width: 150px; text-align: center; display: block; height: 30px; padding: 5px; font-size: 12px; line-height: 12px; margin-bottom: 10px;">';
                        $output 	.= '<input class="ts-datepicker" type="text" placeholder="" value="' . $value . '"/>';
                    $output 		.= '</div>';
                } else if ($period == "time") {
                    $output 		.= '<div class="ts-time-picker-element">';
                        $output 	.= '<input name="' . $param_name . '" id="' . $param_name . '" class="ts-timepicker-value wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="hidden" value="' . $value . '"/>';
                        //$output		.= '<input class="ts-datetimepicker-clear" type="button" value="Clear" style="width: 150px; text-align: center; display: block; height: 30px; padding: 5px; font-size: 12px; line-height: 12px; margin-bottom: 10px;">';
                        $output 	.= '<input class="ts-timepicker" type="text" placeholder="" value="' . $value . '"/>';
                    $output 		.= '</div>';
                }
                return $output;
            }  
        }
    }
    if (class_exists('TS_Parameter_DateTimePicker')) {
        $TS_Parameter_DateTimePicker = new TS_Parameter_DateTimePicker();
    }
?>