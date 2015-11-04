<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_BackgroundPanel')) {
        class TS_Parameter_BackgroundPanel {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('background', array(&$this, 'background_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('background', array(&$this, 'background_settings_field'));
				}
            }        
            function background_settings_field($settings, $value) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $pattern_select	= isset($settings['pattern']) ? $settings['pattern'] : '';
                $encoding       = isset($settings['encoding']) ? $settings['encoding'] : '';
                $asimage		= isset($settings['asimage']) ? $settings['asimage'] : 'true';
                $empty		    = isset($settings['empty']) ? $settings['empty'] : 'true';
                $thumbsize		= isset($settings['thumbsize']) ? $settings['thumbsize'] : 34;
                $height		    = isset($settings['height']) ? $settings['height'] : 200;
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $output         = '';            
                if (($value == "") && ($empty == "true")) {
                    $value		= "transparent";
                } else if (($value == "") && ($empty == "false")) {
                    $value      = $url . reset($pattern_select);
                }
                $output .= '<div class="ts-visual-selector ts-font-background-wrapper" style="height: ' . $height . 'px;">';
                $output .= '<input name="'.$param_name.'" id="'.$param_name.'" class="wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="hidden" value="' . $value . '"/>';
                $selectsize	= "height: " . $thumbsize . "px; width: " . $thumbsize . "px;";
                if ($encoding == 'true') {
                    foreach ($pattern_select as $key => $option ) {
                        if ($key) {
                            if ($value == $key) {
                                $output .= '<a class="TS_VCSC_Back_Link current" style="' . $selectsize . '" href="#" title="' . __( "Background Name:", "ts_visual_composer_extend" ) . ': ts-vcsc-' . $key . '" rel="' . $key . '">';
                                    if ($asimage == "true") {
                                        $output .= '<img src="' . $url.$option . '" style="' . $selectsize . '"><div class="selector-tick"></div>';
                                    } else {
                                        $output .= '<div style="background-image: url(' . $url.$option . '); background-repeat: repeat; ' . $selectsize . '"></div><div class="selector-tick"></div>';
                                    }
                                $output .= '</a>';
                            } else {
                                $output .= '<a class="TS_VCSC_Back_Link" style="' . $selectsize . '" href="#" title="' . __( "Background Name:", "ts_visual_composer_extend" ) . ': ts-vcsc-' . $key . '" rel="' . $key . '">';
                                    if ($asimage == "true") {
                                        $output .= '<img src="' . $url.$option . '" style="' . $selectsize . '">';
                                    } else {
                                        $output .= '<div style="background-image: url(' . $url.$option . '); background-repeat: repeat; ' . $selectsize . '"></div>';
                                    }
                                $output .= '</a>';
                            }
                        } else {
                            if ($value == 'transparent') {
                                $output .= '<a class="TS_VCSC_Back_Link ts-no-background current" style="' . $selectsize . '" href="#" title="' . __( "Background Name:", "ts_visual_composer_extend" ) . ': ts-vcsc-transparent" rel="transparent">r<div class="selector-tick"></div></a>';
                            } else {
                                $output .= '<a class="TS_VCSC_Back_Link ts-no-background" style="' . $selectsize . '" href="#" title="' . __( "Background Name:", "ts_visual_composer_extend" ) . ': ts-vcsc-transparent" rel="transparent">r</a>';
                            }
                        }
                    }
                } else {
                    foreach ($pattern_select as $key => $option) {
                        if ($key) {
                            if ($value == $url.$option) {
                                $output .= '<a class="TS_VCSC_Back_Link current" style="' . $selectsize . '" href="#" title="' . __( "Background Name:", "ts_visual_composer_extend" ) . ': ts-vcsc-' . $key . '" rel="' . $url.$option . '">';
                                    if ($asimage == "true") {
                                        $output .= '<img src="' . $url.$option . '" style="' . $selectsize . '"><div class="selector-tick"></div>';
                                    } else {
                                        $output .= '<div style="background-image: url(' . $url.$option . '); background-repeat: repeat; ' . $selectsize . '"></div><div class="selector-tick"></div>';
                                    }
                                $output .= '</a>';
                            } else {
                                $output .= '<a class="TS_VCSC_Back_Link" style="' . $selectsize . '" href="#" title="' . __( "Background Name:", "ts_visual_composer_extend" ) . ': ts-vcsc-' . $key . '" rel="' . $url.$option . '">';
                                    if ($asimage == "true") {
                                        $output .= '<img src="' . $url.$option . '" style="' . $selectsize . '">';
                                    } else {
                                        $output .= '<div style="background-image: url(' . $url.$option . '); background-repeat: repeat; ' . $selectsize . '"></div>';
                                    }
                                $output .= '</a>';
                            }
                        } else {
                            if ($value == 'transparent') {
                                $output .= '<a class="TS_VCSC_Back_Link ts-no-background current" style="' . $selectsize . '" href="#" title="' . __( "Background Name:", "ts_visual_composer_extend" ) . ': ts-vcsc-transparent" rel="transparent">r<div class="selector-tick"></div></a>';
                            } else {
                                $output .= '<a class="TS_VCSC_Back_Link ts-no-background" data-value="' . $value . '" style="' . $selectsize . '" href="#" title="' . __( "Background Name:", "ts_visual_composer_extend" ) . ': ts-vcsc-transparent" rel="transparent">r</a>';
                            }
                        }
                    }
                }
                $output .= '</div>'; 
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_BackgroundPanel')) {
        $TS_Parameter_BackgroundPanel = new TS_Parameter_BackgroundPanel();
    }
?>