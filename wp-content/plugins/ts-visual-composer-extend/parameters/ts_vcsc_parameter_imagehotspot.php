<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_ImageHotspot')) {
        class TS_Parameter_ImageHotspot {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('imagehotspot', array(&$this, 'imagehotspot_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('imagehotspot', array(&$this, 'imagehotspot_settings_field'));
				}
            }        
            function imagehotspot_settings_field($settings, $value) {
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
                $coordinates	= explode(",", $value);
                $output         = '';
                $required_vc 	= '4.3.0';
                if (defined('WPB_VC_VERSION')){
                    if (version_compare(WPB_VC_VERSION, $required_vc) >= 0) {
                        // Hotspot Image Preview
                        $output 		.= '<div class="ts-image-hotspot-container-preview" style="margin-top: 30px;">';
                            $output 		.= '<img class="ts-image-hotspot-image-preview" data-default="' . TS_VCSC_GetResourceURL('images/other/hotspot_raster.jpg') . '" src="">';
                            $output 		.= '<div class="ts-image-hotspot-holder-preview">';				
                                $output 		.= '<div class="ts-image-hotspot-single-preview" style="left: ' . $coordinates[0] . '%; top: ' . $coordinates[1] . '%;">';					
                                    $output 		.= '<div class="ts-image-hotspot-trigger-preview"><div class="ts-image-hotspot-trigger-pulse"></div><div class="ts-image-hotspot-trigger-dot"></div></div>';
                                $output 		.= '</div>';				
                            $output			.= '</div>';
                        $output 		.= '</div>';	
                        $output 		.= '<div class="vc_clearfix"></div>';
                        // Message
                        $output			.= '<div class="" style="text-align: justify; margin-top: 30px; font-size: 13px; font-style: italic; color: #999999;">' . __( "Use the sliders below or use your mouse to drag the hotspot to its desired spot on the image.", "ts_visual_composer_extend" ) . '</div>';
                    } else {
                        // Message
                        $output			.= '<div class="" style="text-align: justify; margin-top: 0px; font-size: 13px; font-style: italic; color: #999999;">' . __( "Use the sliders below to position the hotspot on its desired spot on the image.", "ts_visual_composer_extend" ) . '</div>';
                    }
                } else {
                    // Message
                    $output				.= '<div class="" style="text-align: justify; margin-top: 0px; font-size: 13px; font-style: italic; color: #999999;">' . __( "Use the sliders below to position the hotspot on its desired spot on the image.", "ts_visual_composer_extend" ) . '</div>';
                }
                // Hidden Input
                $output 		.= '<input name="' . $param_name . '" id="' . $param_name . '" class="ts-nouislider-hotspot-value wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="hidden" value="' . $value . '"/>';	
                // X-Position Slider
                $output 		.= '<div class="ts-nouislider-hotspot-slider" style="width: 100%; margin-top: 20px;">';
                    $output			.= '<div class="" style="font-weight: bold;">' . __( "Horizontal Position (X)", "ts_visual_composer_extend" ) . '</div>';
                    $output 		.= '<input id="ts-input-hotspot-horizontal" style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="" class="ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="text" value="' . $coordinates[0] . '"/>';
                        $output 		.= '<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">' . $unit . '</span>';
                    $output 		.= '<div id="ts-nouislider-hotspot-horizontal" class="ts-nouislider-input ts-nouislider-hotspot-element" data-position="horizontal" data-value="' . $coordinates[0] . '" data-min="' . $min . '" data-max="' . $max . '" data-decimals="' . $decimals . '" data-step="' . $step . '" style="width: 250px; float: left; margin-top: 10px;"></div>';
                $output 		.= '</div>';
                $output 		.= '<div class="vc_clearfix"></div>';
                // Y-Position Slider
                $output 		.= '<div class="ts-nouislider-hotspot-slider" style="width: 100%; margin-top: 20px;">';
                    $output			.= '<div class="" style="font-weight: bold;">' . __( "Vertical Position (Y)", "ts_visual_composer_extend" ) . '</div>';
                    $output 		.= '<input id="ts-input-hotspot-vertical" style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="" class="ts-nouislider-serial nouislider-input-selector nouislider-input-composer" type="text" value="' . $coordinates[1] . '"/>';
                        $output 		.= '<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">' . $unit . '</span>';
                    $output 		.= '<div id="ts-nouislider-hotspot-vertical" class="ts-nouislider-input ts-nouislider-hotspot-element" data-position="vertical" data-value="' . $coordinates[1] . '" data-min="' . $min . '" data-max="' . $max . '" data-decimals="' . $decimals . '" data-step="' . $step . '" style="width: 250px; float: left; margin-top: 10px;"></div>';
                $output 		.= '</div>';
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_ImageHotspot')) {
        $TS_Parameter_ImageHotspot = new TS_Parameter_ImageHotspot();
    }
?>