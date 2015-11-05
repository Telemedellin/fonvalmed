<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_Animations')) {
        class TS_Parameter_Animations {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('css3animations', array(&$this, 'css3animations_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('css3animations', array(&$this, 'css3animations_settings_field'));
				}
            }        
            function css3animations_settings_field($settings, $value){
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name 	= isset($settings['param_name']) ? $settings['param_name'] : '';
                $type 			= isset($settings['type']) ? $settings['type'] : '';
                $class 			= isset($settings['class']) ? $settings['class'] : '';
                $noneselect		= isset($settings['noneselect']) ? $settings['noneselect'] : 'false';
                $standard		= isset($settings['standard']) ? $settings['standard'] : 'true';
                $prefix			= isset($settings['prefix']) ? $settings['prefix'] : '';
                $default		= isset($settings['default']) ? $settings['default'] : '';
                $connector		= isset($settings['connector']) ? $settings['connector'] : '';
                $effectgroups	= array();
                $selectedclass	= '';
                $selectedgroup	= '';
                $output 		= '';
                $css3animations = '';
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                if (empty($value)) {
                    $value		= $prefix . $default;
                }
                // Check for Conversion of VC Animations
                $animation_old  = array(
                    "top-to-bottom"			=> "ts-viewport-css-slideInDown",
                    "bottom-to-top"			=> "ts-viewport-css-slideInUp",
                    "left-to-right"			=> "ts-viewport-css-slideInLeft",
                    "right-to-left"			=> "ts-viewport-css-slideInRight",
                    "appear"				=> "ts-viewport-css-fadeIn"
                );
                if (array_key_exists($value, $animation_old)) {
                    $value	    = $animation_old[$value];
                } else {
                    $value	    = $value;
                };
                // Create "None" Option if requested
                if ($noneselect == 'true') {
                    $css3animations .= '<option class="" value="" data-name=""data-group="" data-prefix="" data-value="">' . __( "None", "ts_visual_composer_extend" ) . '</option>';
                };
                foreach ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CSS_Animations_Array as $Animation_Class => $animations) {
                    if ($animations) {
                        if (!in_array($animations['group'], $effectgroups)) {
                            if ((($animations['group'] == 'Standard Visual Composer') && ($standard == 'true')) || ($animations['group'] != 'Standard Visual Composer')) {
                                array_push($effectgroups, $animations['group']);
                                $css3animations .= '<optgroup label="' . $animations['group'] . '">';
                            }
                        }
                        if ($value == $prefix . $animations['class']) {
                            if ((($animations['group'] == 'Standard Visual Composer') && ($standard == 'true')) || ($animations['group'] != 'Standard Visual Composer')) {
                                $css3animations .= '<option class="' . $animations['class'] . '" value="' . $prefix . $animations['class'] . '" data-name="' . $Animation_Class . '" data-group="' . $animations['group'] . '" data-prefix="' . $prefix . '" data-value="' . $animations['class'] . '" selected="selected">' . $Animation_Class . '</option>';
                                $selectedgroup 	= $animations['group'];
                                if ($selectedgroup == 'Standard Visual Composer') {
                                    $selectedclass	= 'wpb_hover_animation wpb_' . $animations['class'];
                                } else {
                                    $selectedclass	= 'ts-animation-frame ts-hover-css-' . $animations['class'];
                                }
                            }
                        } else {
                            if ((($animations['group'] == 'Standard Visual Composer') && ($standard == 'true')) || ($animations['group'] != 'Standard Visual Composer')) {
                                $css3animations .= '<option class="' . $animations['class'] . '" value="' . $prefix . $animations['class'] . '" data-name="' . $Animation_Class . '"data-group="' . $animations['group'] . '" data-prefix="' . $prefix . '" data-value="' . $animations['class'] . '">' . $Animation_Class . '</option>';
                            }
                        }
                    }
                }
                unset($effectgroups);
                $output .= '<div class="ts-css3-animations-wrapper" style="width: 100%; display: block;" data-connector="' . $connector . '" data-prefix="' . $prefix . '">';
                    $output .= '<div class="ts-css3-animations-selector" style="width: 50%; float: left; margin-bottom: 10px;">';
                        $output .= '<select name="' . $param_name . '" class="wpb_vc_param_value wpb-input wpb-select dropdown ' . $param_name . ' ' . $type . ' ' . $class . ' ' . $value . '" data-class="' . $class . '" data-type="' . $type . '" data-name="' . $param_name . '" data-option="' . $value . '" value="' . $value . '">';
                            $output .= $css3animations;
                        $output .= '</select>';
                    $output .= '</div>';
                    $output .= '<div class="ts-css3-animations-preview" style="padding: 0px; width: 40%; float: right; text-align: right; margin-left: 10%;">';
                        $output .= '<span class="' . $selectedclass . '" style="padding: 10px; background: #C60000; color: #FFFFFF; border: 1px solid #dddddd; display: inline-block;">' . __( "Animation Preview", "ts_visual_composer_extend" ) . '</span>';
                    $output .= '</div>';
                $output .= '</div>';
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_Animations')) {
        $TS_Parameter_Animations = new TS_Parameter_Animations();
    }
?>