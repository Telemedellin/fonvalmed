<?php
	add_shortcode('TS-VCSC-Shortcode', 'TS_VCSC_Shortcode_Function');
	function TS_VCSC_Shortcode_Function($atts) {
		global $VISUAL_COMPOSER_EXTENSIONS;
		ob_start();
	
		extract( shortcode_atts( array(
			'tscode'				=> '',
			'tscodenormal'			=> '',
		), $atts ));
		
		$output 					= '';
	
		$code 						= rawurldecode(base64_decode(strip_tags($tscode)));
		$fullurl 					= "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		if (strpos($fullurl, 'vc_action=vc_inline') !== false) {
			$code					= str_replace("[", "&#91;", $code);
			$code					= str_replace("]", "&#93;", $code);
			$output 				= do_shortcode($code);
		} else {
			$output 				= do_shortcode($code);
		}

		echo $output;
		
		$myvariable = ob_get_clean();
		return $myvariable;
	}
?>