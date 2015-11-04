<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_LoadFile')) {
        class TS_Parameter_LoadFile {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('load_file', array(&$this, 'loadfile_setting_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('load_file', array(&$this, 'loadfile_setting_field'));
				}
            }        
            function loadfile_setting_field($settings, $value){
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $file_type      = isset($settings['file_type']) ? $settings['file_type'] : '';
                $file_id      	= isset($settings['file_id']) ? $settings['file_id'] : '';
                $file_path      = isset($settings['file_path']) ? $settings['file_path'] : '';
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $output         = '';
                if (!empty($file_path)) {
                    if ($file_type == "js") {
                        $output .= '<script type="text/javascript" src="' . $url.$file_path . '"></script>';
                    } else if ($file_type == "css") {
                        $output .= '<link rel="stylesheet" id="' . $file_id . '" type="text/css" href="' . $url.$file_path . '" media="all">';
                    }
                }
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_LoadFile')) {
        $TS_Parameter_LoadFile = new TS_Parameter_LoadFile();
    }
?>