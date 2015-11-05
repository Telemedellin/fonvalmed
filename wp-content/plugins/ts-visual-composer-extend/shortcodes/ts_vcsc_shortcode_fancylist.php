<?php
	add_shortcode('TS_VCSC_Fancy_List', 'TS_VCSC_Fancy_List_Function');
	function TS_VCSC_Fancy_List_Function ($atts, $content = null) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();

		wp_enqueue_style('ts-visual-composer-extend-front');
	
		extract( shortcode_atts( array(
			'list_type'					=> 'standard',
			'list_marker'				=> 'disc',
			'list_order'				=> 'decimal',
			'list_position'				=> 'outside',
			'line_height'				=> 18,
			
			'marker_margin'				=> 0,
			'marker_image'				=> '',
			'marker_icon'				=> '',
			'marker_position'			=> 'center',
			
			'order_start1'				=> 0,
			'order_start2'				=> 0,
			'marker_color'				=> '#000000',
			'marker_size'				=> 12,
			
			'content_intend'			=> 0,
			'content_margin'			=> 5,
			'content_color'				=> '#000000',
			'content_size'				=> 14,
			
			'frame_type'				=> '',
			'frame_position'			=> 'bottom',
			'frame_padding'				=> 5,
			'frame_thick'				=> 1,
			'frame_color'				=> '#cccccc',
			
			'margin_top'                => 0,
			'margin_bottom'             => 0,
			'el_id' 					=> '',
			'el_class'                  => '',
			'css'						=> '',
		), $atts ));
		
		$output 						= '';
		
		if (!empty($el_id)) {
			$list_id					= $el_id;
		} else {
			$list_id					= 'ts-fancy-list-' . mt_rand(999999, 9999999);
		}
		
		if (($list_type == "icon") || ($list_type == "image")) {
			$list_marker				= 'none';
		}
		if ($list_type == "image") {
			$list_image					= "list-style: none !important; background-image: url('" . $marker_image . "'); background-repeat: no-repeat; background-position: 0px " . $marker_position . "; background-size: " . $marker_size . "px " . $marker_size . "px; padding-left: " . ($marker_size + 10) . "px;";
		} else {
			$list_image					= "";
		}
		if ($list_type == "icon") {
			if ($marker_position == 'center') {
				$marker_position		= 'middle';
			}
		}		
		if ($frame_type != '') {
			$list_border				= 'border-' . $frame_position . ': ' . $frame_thick . 'px ' . $frame_type . ' ' . $frame_color . '; padding-' . $frame_position . ': ' . $frame_padding . 'px;';
		} else {
			$list_border				= "";
		}
		
		if (function_exists('vc_shortcode_custom_css_class')) {
			$css_class 					= apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . vc_shortcode_custom_css_class($css, ' '), 'TS_VCSC_Unordered_List', $atts);
		} else {
			$css_class					= '';
		}		
		
		$list_content					= (wpb_js_remove_wpautop(do_shortcode($content), true));
		$list_content 					= str_replace('<ol>', '<ul>', $list_content);
		$list_content 					= str_replace('</ol>', '</ul>', $list_content);
		$list_content 					= str_replace('<li></li>', '', $list_content);		
		$list_style 					= TS_VCSC_GetStringBetween($list_content, '<ul', '>');		
		$list_content 					= str_replace($list_style, '', $list_content);		
		$list_style 					= TS_VCSC_GetStringBetween($list_style, 'style="', '"');		
		$list_content					= preg_replace('/<ul>/i', '', $list_content, -1);
		$list_content 					= str_replace('</ul>', '', $list_content);
		$list_array 					= str_replace('<li', '<div', $list_content);
		$list_array 					= explode('</li>', $list_array);
		foreach ($list_array as $key => $value){
			if ((trim($value) == '<ul>') || (trim($value) == '</ul>') || (trim($value) == '')) {
				unset($list_array[$key]);
			}
		}
		$list_length					= count($list_array);
		$list_counter					= 0;
	
		// Create Inline CSS Style
		$output .= '<style id="' . $list_id . '-styling" type="text/css">';
			$output .= '#' . $list_id . ' .ts-fancy-list-wrapper {';
				$output .= 'margin: 0 0 0 ' . $marker_margin . 'px; list-style-type: ' . ($list_type == "ordered" ? $list_order : $list_marker) . '; list-style-position: ' . $list_position . '; color: ' . $marker_color . '; font-size: ' . $marker_size . 'px; line-height: ' . $line_height . 'px; ' . $list_style;
			$output .= '}';
			if ($list_type == "icon") {
				$output .= '#' . $list_id . ' .ts-fancy-list-wrapper li {';
					$output .= 'list-style: none !important; border: none; margin: ' . $content_margin . 'px 0; padding: 0; line-height: ' . $line_height . 'px;';
					if (($frame_type != '') && ($frame_position == "right")) {
						$output .= $list_border;
					}
				$output .= '}';
				$output .= '#' . $list_id . ' .ts-fancy-list-wrapper li i {';
					$output .= 'display: table-cell; margin: 0; padding: 0 10px 0 0; color: ' . $marker_color . '; font-size: ' . $marker_size . 'px; vertical-align: ' . $marker_position . ';';
				$output .= '}';
				$output .= '#' . $list_id . ' .ts-fancy-list-wrapper li div {';
					$output .= 'margin: 0; padding: 0; color: ' . $content_color . '; font-size: ' . $content_size . 'px; line-height: ' . $line_height . 'px; display: table-cell;';
					if (($frame_type != '') && ($frame_position == "left")) {
						$output .= $list_border;
					}
				$output .= '}';
			} else {
				$output .= '#' . $list_id . ' .ts-fancy-list-wrapper li {';
					$output .= 'border: none; margin: ' . $content_margin . 'px 0; padding: 0; line-height: ' . $line_height . 'px; ' . $list_image;
					if (($frame_type != '') && ($frame_position == "right")) {
						$output .= $list_border;
					}
				$output .= '}';
				$output .= '#' . $list_id . ' .ts-fancy-list-wrapper li div {';
					$output .= 'margin: 0; padding: 0; color: ' . $content_color . '; font-size: ' . $content_size . 'px; line-height: ' . $line_height . 'px; display: block;';
					if (($frame_type != '') && ($frame_position == "left")) {
						$output .= $list_border;
					}
				$output .= '}';
		}
		$output .= '</style>';
		// Create List Output
		$output .= '<div id="' . $list_id . '" class="ts-fancy-list-container ' . $css_class . '" style="margin-left: ' . $content_intend . 'px; margin-top: ' . $margin_top . 'px; margin-bottom: ' . $margin_bottom . 'px;">';
			if ($list_type != 'ordered') {
				$output .= '<ul class="ts-fancy-list-wrapper ts-fancy-list-unordered">';
			} else {
				$output .= '<ol class="ts-fancy-list-wrapper ts-fancy-list-ordered" start="' . ((($list_order == 'decimal') || ($list_order == 'decimal-leading-zero')) ? $order_start1 : $order_start2) . '">';
			}
				foreach ($list_array as $key => $value){
					$list_counter++;
					if (substr(trim($value), 0, 4) === "<div") {
						if ($list_type == "icon") {
							$output .= '<li data-count="' . $list_counter . '" style="' . (((($frame_position == "bottom")&& ($list_counter < $list_length)) || (($frame_position == "top")&& ($list_counter > 1))) ? $list_border : "") . '"><i class="' . $marker_icon . '"></i>' . $value . '</div></li>';
						} else {
							$output .= '<li data-count="' . $list_counter . '" style="' . (((($frame_position == "bottom")&& ($list_counter < $list_length)) || (($frame_position == "top")&& ($list_counter > 1))) ? $list_border : "") . '">' . $value . '</div></li>';
						}
					}
				}
			if ($list_type != 'ordered') {
				$output .= '</ul>';
			} else {
				$output .= '</ol>';
			}
		$output .='</div>';
		
		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>