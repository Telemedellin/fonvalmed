<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_GoogleFonts')) {
        class TS_Parameter_GoogleFonts {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('fontsmanager', array(&$this, 'fonts_setting_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('fontsmanager', array(&$this, 'fonts_setting_field'));
				}
            }        
            function fonts_setting_field($settings, $value){
                global $VISUAL_COMPOSER_EXTENSIONS;
                // Main Settings
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $preview        = isset($settings['preview']) ? $settings['preview'] : 'true';
                $search         = isset($settings['search']) ? $settings['search'] : 'true';
                $filter         = isset($settings['filter']) ? $settings['filter'] : 'true';
                $manager        = isset($settings['manager']) ? $settings['manager'] : 'false';
                $default        = isset($settings['default']) ? $settings['default'] : 'true';
                $connector      = isset($settings['connector']) ? $settings['connector'] : 'font_type';
                // Text Strings
                $textswitch     = isset($settings['textswitch']) ? $settings['textswitch'] : __( "Show Font Manager:", "ts_visual_composer_extend" );
                $textholder     = isset($settings['textholder']) ? $settings['textholder'] : __( "Select a Font", "ts_visual_composer_extend" );
                $textsearch     = isset($settings['textsearch']) ? $settings['textsearch'] : __( "Search Fonts:", "ts_visual_composer_extend" );
                $textfilter     = isset($settings['textfilter']) ? $settings['textfilter'] : __( "Filter Fonts:", "ts_visual_composer_extend" );
                $textvariants   = isset($settings['textvariants']) ? $settings['textvariants'] : __( "Select Font Variant:", "ts_visual_composer_extend" );
                $textfavorite   = isset($settings['textfavorite']) ? $settings['textfavorite'] : __( "Favorite Fonts", "ts_visual_composer_extend" );
                $textdefault    = isset($settings['textdefault']) ? $settings['textdefault'] : __( "Default Font", "ts_visual_composer_extend" );
                $textstandard   = isset($settings['textstandard']) ? $settings['textstandard'] : __( "Websave Fonts", "ts_visual_composer_extend" );
                $textgoogle     = isset($settings['textgoogle']) ? $settings['textgoogle'] : __( "Google Fonts", "ts_visual_composer_extend" );
                $textpreviewer  = isset($settings['textpreviewer']) ? $settings['textpreviewer'] : __( "Autoload CSS font files for live preview while scrolling list.", "ts_visual_composer_extend" );
                // Switch Settings
                $on            	= isset($settings['on']) ? $settings['on'] : __( "Yes", "ts_visual_composer_extend" );
                $off            = isset($settings['off']) ? $settings['off'] : __( "No", "ts_visual_composer_extend" );
                $style			= isset($settings['style']) ? $settings['style'] : 'select';
                $design			= isset($settings['design']) ? $settings['design'] : 'toggle-light';
                $width			= isset($settings['width']) ? $settings['width'] : '80';
                // Other Variables
                $identifier     = mt_rand(999999, 9999999);
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $image          = TS_VCSC_GetResourceURL('images/other/google_fonts.jpg');
                /*if (($value != '') && ($value != 'Default:regular')) {
                    $toggle     = 'true';
                    $display    = 'block';
                } else {*/
                    $toggle     = 'false';
                    $display    = 'none';
                //}
                $output			= '';
                $output .= '<div id="ts-font-selector-' . $identifier . '" class="ts-font-selector" data-manager="' . $manager . '" data-identifier="' . $identifier . '" data-toggle="ts-font-selector-toggle-' . $identifier . '" data-fontello="ts-font-selector-fontello-' . $identifier . '" data-connector="' . $connector . '" data-text-holder="' . $textholder . '" data-text-search="' . $textsearch . '" data-text-filter="' . $textfilter . '" data-text-favorite="' . $textfavorite . '" data-text-default="' . $textdefault . '" data-text-standard="' . $textstandard . '" data-text-google="' . $textgoogle . '" data-text-variants="' . $textvariants . '" data-text-previewer="' . $textpreviewer . '" data-preview="' . $preview . '" data-search="' . $search . '" data-filter="' . $filter . '">';
                    $output .= '<div id="ts-font-selector-switcheroo-' . $identifier . '" class="ts-font-selector-switcheroo">';
                        $output .= '<label for="ts-font-selector-toggle-' . $identifier . '">' . $textswitch . '</label>';
                        $output .= '<div id="ts-font-selector-toggle-' . $identifier . '" class="ts-switch-button ts-font-selector-toggle" data-value="' . $toggle . '" data-width="' . $width . '" data-style="' . $style . '" data-on="' . $on . '" data-off="' . $off . '">';
                            $output .= '<input type="hidden" style="display: none; " class="toggle-input" value="' . $toggle . '" name="ts-font-selector-toggle"/>';
                            $output .= '<div class="toggle ' . $design . '" style="width: ' . $width . 'px; height: 20px;">';
                                $output .= '<div class="toggle-slide">';
                                    $output .= '<div class="toggle-inner">';
                                        $output .= '<div class="toggle-on ' . ($toggle == 'true' ? 'active' : '') . '">' . $on . '</div>';
                                        $output .= '<div class="toggle-blob"></div>';
                                        $output .= '<div class="toggle-off ' . ($toggle == 'false' ? 'active' : '') . '">' . $off . '</div>';
                                    $output .= '</div>';
                                $output .= '</div>';
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</div>';
                    $output .= '<div id="ts-font-selector-fontello-' . $identifier . '" class="ts-font-selector-fontello" style="display: ' . $display . ';">';
                        $output .= '<div class="ts-font-selector-block"><img src="' . $image . '" class="ts-font-selector-image"></div>';
                        $output .= '<input name="' . $param_name . '" id="' . $param_name . '" class="ts-font-selector-list wpb-select wpb_vc_param_value ' . $param_name . ' ' . $type . '" type="text" value="' . $value . '"/>';
                    $output .= '</div>';
                $output .= '</div>';
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_GoogleFonts')) {
        $TS_Parameter_GoogleFonts = new TS_Parameter_GoogleFonts();
    }
?>