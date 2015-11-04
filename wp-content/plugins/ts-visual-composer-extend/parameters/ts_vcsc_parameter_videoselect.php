<?php
    /*
     No Additional Setting Options
    */
    if (!class_exists('TS_Parameter_VideoSelect')) {
        class TS_Parameter_VideoSelect {
            function __construct() {	
				if (function_exists('vc_add_shortcode_param')) {
                    vc_add_shortcode_param('videoselect', array(&$this, 'videoselect_settings_field'));
				} else if (function_exists('add_shortcode_param')) {
                    add_shortcode_param('videoselect', array(&$this, 'videoselect_settings_field'));
				}
            }        
            function videoselect_settings_field( $settings, $value ) {
                global $VISUAL_COMPOSER_EXTENSIONS;
                $dependency     = vc_generate_dependencies_attributes($settings);
                $param_name     = isset($settings['param_name']) ? $settings['param_name'] : '';
                $type           = isset($settings['type']) ? $settings['type'] : '';
                $video_format	= isset($settings['video_format']) ? $settings['video_format'] : 'mp4';
                $url            = $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginPath;
                $video_format	= explode(',', $video_format);
                $output			= '';
                $args = array(
                    'post_type' 		=> 'attachment',
                    'post_mime_type' 	=> 'video',
                    'post_status' 		=> 'inherit',
                    'posts_per_page' 	=> -1,
                );			
                if ($value != '') {
                    $metadata			= wp_get_attachment_metadata($value);
                    $disabled			= '';
                    $visible			= 'display: block;';
                    $query_videos 		= new WP_Query($args);
                    if ($query_videos->have_posts()) {
                        foreach ($query_videos->posts as $video) {
                            if ($video->ID == $value) {
                                $video_id 		= $value;
                                $video_title 	= $video->post_title;
                                $video_width	= (isset($metadata['width']) ? $metadata['width'] : 'N/A');
                                $video_height	= (isset($metadata['height']) ? $metadata['height'] : 'N/A');
                                $video_length	= (isset($metadata['length_formatted']) ? $metadata['length_formatted'] : 'N/A');
                                break;
                            }
                        }
                    }
                    wp_reset_postdata();
                } else {
                    $metadata			= array();
                    $disabled			= 'disabled="disabled"';
                    $visible			= 'display: none;';
                    $video_id			= '';
                    $video_title 		= '';
                    $video_url			= '';
                    $video_width		= '';
                    $video_height		= '';
                    $video_length		= '';
                }			
                $output 	.= '<div class="ts_vcsc_video_select_block" data-format="' . implode(',', $video_format) . '">';			
                    $output 	.= '<input style="display: none;" name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput video_value ' . $param_name . ' ' . $type . '_field" type="text" value="' . $value . '" ' . $dependency . '/>';
                    $output 	.= '<input type="button" class="video_select button" value="' . __( 'Select Video', 'ts_visual_composer_extend' ) . '" style="width: 150px; text-align: center;">';
                    $output 	.= '<input type="button" class="video_remove button" value="' . __( 'Remove Video', 'ts_visual_composer_extend' ) . '" style="width: 150px; text-align: center; color: red; margin-left: 20px;" ' . $disabled . '>';
                    $output		.= '<div class="video_metadata_frame" style="width: 100%; margin-top: 20px; ' .$visible . '">';
                        $output		.= '<div style="float: left; width: 92px; margin-right: 10px;">';
                            if (in_array("mp4", $video_format)) {
                                $output		.= '<img src="' . TS_VCSC_GetResourceURL('images/mediatypes/mp4_video.jpg') . '" style="width: 90px; height: auto; border: 1px solid #ededed;">';
                            } else if ((in_array("ogg", $video_format)) || (in_array("ogv", $video_format))) {
                                $output		.= '<img src="' . TS_VCSC_GetResourceURL('images/mediatypes/ogg_video.jpg') . '" style="width: 90px; height: auto; border: 1px solid #ededed;">';
                            } else if (in_array("webm", $video_format)) {
                                $output		.= '<img src="' . TS_VCSC_GetResourceURL('images/mediatypes/webm_video.jpg') . '" style="width: 90px; height: auto; border: 1px solid #ededed;">';
                            }
                        $output 	.= '</div>';
                        $output		.= '<div style="float: left;">';
                            $output		.= '<div style=""><span style="">' . __( 'Video ID', 'ts_visual_composer_extend' ) . ': </span><span class="video_metadata video_id">' . $video_id . '</span></div>';
                            $output		.= '<div style=""><span style="">' . __( 'Video Name', 'ts_visual_composer_extend' ) . ': </span><span class="video_metadata video_name">' . $video_title . '</span></div>';
                            $output		.= '<div style=""><span style="">' . __( 'Video Duration', 'ts_visual_composer_extend' ) . ': </span><span class="video_metadata video_duration">' . ($video_length != '' ? $video_length : 'N/A') . '</span></div>';
                            $output		.= '<div style=""><span style="">' . __( 'Video Width', 'ts_visual_composer_extend' ) . ': </span><span class="video_metadata video_width">' . ($video_width != '' ? $video_width : 'N/A') . '</span></div>';
                            $output		.= '<div style=""><span style="">' . __( 'Video Height', 'ts_visual_composer_extend' ) . ': </span><span class="video_metadata video_height">' . ($video_height != '' ? $video_height : 'N/A') . '</span></div>';
                        $output 	.= '</div>';
                    $output 	.= '</div>';				
                $output 	.= '</div>';
                return $output;
            }
        }
    }
    if (class_exists('TS_Parameter_VideoSelect')) {
        $TS_Parameter_VideoSelect = new TS_Parameter_VideoSelect();
    }
?>