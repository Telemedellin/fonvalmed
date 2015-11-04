<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_AudioSelect')) {
        class TS_Parameter_AudioSelect {
            function __construct() {	
                if (function_exists('vc_add_shortcode_param')) {
					vc_add_shortcode_param('audioselect', array(&$this, 'audioselect_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('audioselect', array(&$this, 'audioselect_settings_field'));
				}
            }        
            function audioselect_settings_field( $settings, $value ) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $audio_format	= isset($settings['audio_format']) ? $settings['audio_format'] : 'mpeg';			
                $audio_format	= explode(',', $audio_format);
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $output			= '';
                $args = array(
                    'post_type' 		=> 'attachment',
                    'post_mime_type' 	=> 'audio',
                    'post_status' 		=> 'inherit',
                    'posts_per_page' 	=> -1,
                );			
                if ($value != '') {
                    $metadata			= wp_get_attachment_metadata($value);
                    $disabled			= '';
                    $visible			= 'display: block;';
                    $query_audios 		= new WP_Query($args);
                    if ($query_audios->have_posts()) {
                        foreach ($query_audios->posts as $audio) {
                            if ($audio->ID == $value) {
                                $audio_id 		= $value;
                                $audio_title 	= $audio->post_title;
                                $audio_length	= (isset($metadata['length_formatted']) ? $metadata['length_formatted'] : 'N/A');
                                break;
                            }
                        }
                    }
                    wp_reset_postdata();
                } else {
                    $metadata			= array();
                    $disabled			= 'disabled="disabled"';
                    $visible			= 'display: none;';
                    $audio_id			= '';
                    $audio_title 		= '';
                    $audio_url			= '';
                    $audio_length		= '';
                }			
                $output 	.= '<div class="ts_vcsc_audio_select_block" data-format="' . implode(',', $audio_format) . '">';			
                    $output 	.= '<input style="display: none;" name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput audio_value ' . $param_name . ' ' . $type . '_field" type="text" value="' . $value . '" ' . $dependency . '/>';
                    $output 	.= '<input type="button" class="audio_select button" value="' . __( 'Select Audio', 'ts_visual_composer_extend' ) . '" style="width: 150px; text-align: center;">';
                    $output 	.= '<input type="button" class="audio_remove button" value="' . __( 'Remove Audio', 'ts_visual_composer_extend' ) . '" style="width: 150px; text-align: center; color: red; margin-left: 20px;" ' . $disabled . '>';
                    $output		.= '<div class="audio_metadata_frame" style="width: 100%; margin-top: 20px; ' .$visible . '">';
                        $output		.= '<div style="float: left; width: 92px; margin-right: 10px;">';
                            if ((in_array("mp3", $audio_format)) || (in_array("mpeg", $audio_format)) ){
                                $output		.= '<img src="' . TS_VCSC_GetResourceURL('images/mediatypes/mp3_audio.jpg') . '" style="width: 90px; height: auto; border: 1px solid #ededed;">';
                            } else if ((in_array("ogg", $audio_format)) || (in_array("ogv", $audio_format))) {
                                $output		.= '<img src="' . TS_VCSC_GetResourceURL('images/mediatypes/ogg_audio.jpg') . '" style="width: 90px; height: auto; border: 1px solid #ededed;">';
                            }
                        $output 	.= '</div>';
                        $output		.= '<div style="float: left;">';
                            $output		.= '<div style=""><span style="">' . __( 'Audio ID', 'ts_visual_composer_extend' ) . ': </span><span class="audio_metadata audio_id">' . $audio_id . '</span></div>';
                            $output		.= '<div style=""><span style="">' . __( 'Audio Name', 'ts_visual_composer_extend' ) . ': </span><span class="audio_metadata audio_name">' . $audio_title . '</span></div>';
                            $output		.= '<div style=""><span style="">' . __( 'Audio Duration', 'ts_visual_composer_extend' ) . ': </span><span class="audio_metadata audio_duration">' . ($audio_length != '' ? $audio_length : 'N/A') . '</span></div>';
                        $output 	.= '</div>';
                    $output 	.= '</div>';				
                $output 	.= '</div>';
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_AudioSelect')) {
        $TS_Parameter_AudioSelect = new TS_Parameter_AudioSelect();
    }
?>