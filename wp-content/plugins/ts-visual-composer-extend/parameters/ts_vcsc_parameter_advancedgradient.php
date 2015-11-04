<?php
	/* 	External Ressources:
	 * 	http://www.class.pm/files/jquery/classygradient/
	 * 	http://www.eyecon.ro/colorpicker/
	 * 	https://developer.wordpress.org/resource/dashicons/
	 * 	http://refreshless.com/nouislider/
	 *
	 * 	Usage:
	 * 	array(
			"type" 				=> "advanced_gradient",
			"class" 			=> "",
			"heading" 			=> __("Gradient Controls", "ts_visual_composer_extend"),						
			"param_name" 		=> "gradient",
			"create_svg"		=> "false"
			"default_color"		=> "0% #0051FF, 100% #00C5FF",
			"default_type"		=> "linear",
			"default_shape"		=> "ellipse",
			"label_picker"		=> __("Define Gradient Colors", "ts_visual_composer_extend"),
			"label_type"		=> __("Define Gradient Type", "ts_visual_composer_extend"),
			"label_shape"		=> __("Define Radial Shape", "ts_visual_composer_extend"),
			"label_spread"		=> __("Define Gradient Direction", "ts_visual_composer_extend"),
			"label_preview"		=> __("Gradient Preview", "ts_visual_composer_extend"),
			"message_picker"	=> __('For a gradient, at least one starting and one end color should be defined.', 'ts_visual_composer_extend'),
		),
	*/
	if (!class_exists('TS_Parameter_Gradient')) {
		class TS_Parameter_Gradient {
			function __construct() {	
				if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('advanced_gradient' , array($this, 'gradient_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
					add_shortcode_param('advanced_gradient' , array($this, 'gradient_settings_field'));
				}
			}
			function gradient_settings_field($settings, $value) {
				global $VISUAL_COMPOSER_EXTENSIONS;
				$dependency 					= vc_generate_dependencies_attributes($settings);
				$param_name 					= isset($settings['param_name']) ? $settings['param_name'] : '';
				$type 							= isset($settings['type']) ? $settings['type'] : '';
				$class 							= isset($settings['class']) ? $settings['class'] : '';
				$trianglify						= isset($settings['trianglify']) ? $settings['trianglify'] : 'false';
				$create_svg						= isset($settings['create_svg']) ? $settings['create_svg'] : 'false';
				$default_color					= isset($settings['default_color']) ? $settings['default_color'] : '0% #0051FF, 100% #00C5FF';
				$default_type					= isset($settings['default_type']) ? $settings['default_type'] : 'linear';
				$default_shape					= isset($settings['default_shape']) ? $settings['default_shape'] : 'ellipse';
				$message_picker 				= isset($settings['message_picker']) ? $settings['message_picker'] : __("For a gradient, at least one starting and one end color should be defined.", "ts_visual_composer_extend");
				$label_picker 					= isset($settings['label_picker']) ? $settings['label_picker'] : __("Define Gradient Colors", "ts_visual_composer_extend");
				$label_type 					= isset($settings['label_type']) ? $settings['label_type'] : __("Define Gradient Type", "ts_visual_composer_extend");
				$label_shape					= isset($settings['label_shape']) ? $settings['label_shape'] : __("Define Radial Shape", "ts_visual_composer_extend");
				$label_spread 					= isset($settings['label_spread']) ? $settings['label_spread'] : __("Define Gradient Direction", "ts_visual_composer_extend");
				$label_preview 					= isset($settings['label_preview']) ? $settings['label_preview'] : __("Gradient Preview", "ts_visual_composer_extend");
				// Other Settings
				$random_id_number               = rand(100000, 999999);
				$url           	 				= $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
				$html = '<div class="ts-advanced-gradient" data-identifier="' . $random_id_number . '" data-trianglify="' . $trianglify . '" data-svg="' . $create_svg . '" data-default-color="' . $default_color . '" data-default-type="' . $default_type . '" data-default-shape="' . $default_shape . '">';
					// Classy Gradient Picker
					$html .= '<div class="wpb_element_label" style="padding-top: 10px; clear: both;">' . $label_picker . '</div>';
					$html .= '<div class="ts-advanced-gradient-icon"><i class="dashicons dashicons-art"></i></div>';
					$html .= '<div class="ts-advanced-gradient-picker" id="ts-advanced-gradient-picker-' . $random_id_number . '"></div>';
					$html .= '<div class="vc_description vc_clearfix">' . $message_picker . '</div>';
					if ($trianglify == "false") {
						// Gradient Type Selector
						$html .= '<div id="ts-advanced-gradient-type-label-' . $random_id_number . '" class="wpb_element_label" style="padding-top: 10px; clear: both;">' . $label_type . '</div>';
						$html .= '<select id="ts-advanced-gradient-type-' . $random_id_number . '" class="ts-advanced-gradient-type" data-identifier="' . $random_id_number . '">
							<option value="linear">' . __('Linear Gradiant', 'ts_visual_composer_extend') . '</option>
							<option value="radial">' . __('Radial Gradiant', 'ts_visual_composer_extend') . '</option>
						</select>';
						// Gradient Linear Direction Selector
						$html .= '<div id="ts-advanced-gradient-direction-label-' . $random_id_number . '" class="wpb_element_label" style="padding-top: 10px; clear: both;">' . $label_spread . '</div>';
						$html .= '<select id="ts-advanced-gradient-direction-' . $random_id_number . '" class="ts-advanced-gradient-direction" data-identifier="' . $random_id_number . '">
							<option value="top">' . __('Vertical Spread (Top to Bottom)', 'ts_visual_composer_extend') . '</option>
							<option value="left">' . __('Horizontal Spread (Left To Right)', 'ts_visual_composer_extend') . '</option>
							<option value="custom">' . __('Custom Angle Spread', 'ts_visual_composer_extend') . '</option>
						</select>';
						// Gradient Radial Shape Selector
						$html .= '<div id="ts-advanced-gradient-shape-label-' . $random_id_number . '" class="wpb_element_label" style="padding-top: 10px; clear: both;">' . $label_shape . '</div>';
						$html .= '<select id="ts-advanced-gradient-shape-' . $random_id_number . '" class="ts-advanced-gradient-shape" data-identifier="' . $random_id_number . '">
							<option value="ellipse">' . __('Ellipse', 'ts_visual_composer_extend') . '</option>
							<option value="circle">' . __('Circle', 'ts_visual_composer_extend') . '</option>
						</select>';
						// Gradient Custom Angle Input
						$html .= '<div id="ts-advanced-gradient-custom-' . $random_id_number . '" class="ts-advanced-gradient-custom" style="display: none;">';
							$html .= '<div class="wpb_element_label" style="margin-top: 10px; clear: both;">' . __('Define Custom Angle', 'ts_visual_composer_extend') . '</div>';
							$html .= '<div class="ts-nouislider-input-slider" style="margin: 10px auto; height: 35px;">';
								$html .= '<input style="width: 100px; float: left; margin-left: 0px; margin-right: 10px;" name="" id="ts-advanced-gradient-spread-' . $random_id_number . '" placeholder="0" data-identifier="' . $random_id_number . '" class="ts-advanced-gradient-spread" type="text" value="0"/>';
									$html .= '<span style="float: left; margin-right: 30px; margin-top: 10px;" class="unit">deg</span>';
								$html .= '<div class="ts-nouislider-input ts-nouislider-input-gradient" data-identifier="' . $random_id_number . '" data-value="0" data-min="0" data-max="360" data-decimals="0" data-step="1" style="width: 250px; float: left; margin-top: 10px;"></div>';
							$html .= '</div>';
						$html .= '</div>';
						// Gradient Preview Panel
						$html .= '<div class="wpb_element_label" style="margin-top: 10px; clear: both;">' . $label_preview . '</div>';
						$html .= '<div id="ts-advanced-gradient-preview-' . $random_id_number . '" class="ts-advanced-gradient-preview" style="width: 100%; height: 100px;"></div>';
					}
					// Hidden Input with Final Gradient Code
					$html .= '<input id="ts-advanced-gradient-value-' . $random_id_number . '" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . ' ts-advanced-gradient-value" name="' . $param_name . '"  style="display: none;"  value="' . $value . '" ' . $dependency . '/>';
				$html .= '</div>';
				return $html;
			}		
		}
	}
	if (class_exists('TS_Parameter_Gradient')) {
		$TS_Parameter_Gradient = new TS_Parameter_Gradient();
	}
?>