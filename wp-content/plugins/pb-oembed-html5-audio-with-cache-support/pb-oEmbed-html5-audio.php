<?php
/*
Plugin Name: PB oEmbed HTML5 Audio - with Cache Support
Plugin URI: http://wordpress.org/extend/plugins/pb-oembed-html5-audio-with-cache-support/
Description: This plugin converts URLs to audio files (MP3, OGG, WAV) into HTML5 audio with Flash-based player backup - This special Version supports Cache Systems like WP Super Cache and W3 Total Cache additionally this Plugin offers you a Shortcode to get the full control of your HTML5 Audio - based on oEmbed HTML5 Audio by Honza Skypala.
Version: 2.5.1
Author: Pascal Bajorat
Author URI: http://www.pascal-bajorat.com
License: GNU General Public License v.3
*/

class PBoEmbedHTML5Audio {
	var $flash_player = '';

	function __construct(){
		// Load Localization
		add_action('plugins_loaded', array(&$this, 'lang'));

		// Flash Player URL
		$this->flash_player = plugins_url('3523697345-audio-player.swf', __FILE__);

		// oEmbed Handler for mp3, ogg and wav
		wp_embed_register_handler('html5_audio', '#^http://.+\.(mp3|ogg|wav)$#i', array(&$this, 'pbwp_embed_handler_html5_audio'));
		
		// Enqueue Scripts
		//add_action('wp_enqueue_scripts', array(&$this, 'pbwp_embed_handler_html5_audio_jquery'));
		
		// Register Metabox
		add_action('add_meta_boxes', array(&$this, 'pbwp_register_metabox'));

		// Register Shortcode
		add_action('wp', array(&$this, 'pbwp_register_audio'));
		//add_shortcode('audio', array(&$this, 'pbwp_html5_audio_shortcode'));

		if( is_admin() ){
			add_action('admin_print_scripts', array(&$this, 'pbwp_admin_scripts'));
			add_action('admin_print_styles', array(&$this, 'pbwp_admin_styles'));
		}
	}

	function lang(){
		load_plugin_textdomain('PBoEmbedHTML5Audio', false, dirname(plugin_basename( __FILE__ )).'/lang/');
	}

	function pbwp_register_audio(){
		remove_shortcode('audio');
		add_shortcode('audio', array(&$this, 'pbwp_html5_audio_shortcode'));
	}

	function pbwp_embed_handler_html5_audio_jquery(){
		// Enqueue jQuery in the Frontend
		wp_enqueue_script('jquery');
	}

	function pbwp_admin_scripts(){
		// Enqueue Scripts for WP-Admin
		wp_enqueue_script('jquery');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
	}

	function pbwp_admin_styles(){
		// Enqueue Styles for WP-Admin
		wp_enqueue_style('thickbox');
	}

	function pbwp_html5_audio_shortcode($atts){
		extract( shortcode_atts( array(
            'id' => false,
            'class' => 'pb-html5-audio-element',
			'ogg' => false,
			'mp3' => false,
			'wav' => false,
			'autoplay' => false,
			'controls' => 'on',
			'loop' => false,
			'preload' => 'on',
			'flash_fallback' => 'on'
		), $atts ) );

		$flash_player 	= $this->flash_player;
		$autoplay 		= strtolower(trim($autoplay));
		$controls 		= strtolower(trim($controls));
		$loop 			= strtolower(trim($loop));
		$preload 		= strtolower(trim($preload));
		$flash_fallback = strtolower(trim($flash_fallback));

        if( $id == false ){
            $audioID = 'audioplayer-'.md5(microtime().rand(1, 1000));
        } else {
            $audioID = $id;
        }

		$html5audio = '<audio id="'.$audioID.'" '.(($autoplay=='on')?'autoplay="autoplay"':'').' '.(($controls=='on')?'controls="controls"':'').' '.(($loop=='on')?'loop="loop"':'').' '.(($preload=='on')?'preload="preload"':'').' class="'.$class.'">';
		if( !empty($ogg) ){
			$html5audio .= '<source src="'.$ogg.'" type="audio/ogg">';
		}
		if( !empty($mp3) ){
			$html5audio .= '<source src="'.$mp3.'" type="audio/mpeg">';
		}
		if( !empty($wav) ){
			$html5audio .= '<source src="'.$wav.'" type="audio/wav">';
		}
		if( !empty($mp3) && $flash_fallback == 'on' ){
			$html5audio .= '<embed type="application/x-shockwave-flash" flashvars="audioUrl='.$mp3.'" src="'.$flash_player.'" width="400" height="27" quality="best"></embed>';
		}else{
			$html5audio .= 'Your Browser does not support the new HTML5 Audio-Tag, sorry!';
		}
		$html5audio .= '</audio>';

		if(!empty($mp3) && $flash_fallback == 'on'){
			if( empty($ogg) && empty($wav) ):
				$html5audio .='<script type="text/javascript">
				agent = navigator.userAgent.toLowerCase();
				name_ff = "firefox";
				name_op = "opera";
				if (agent.indexOf(name_ff.toLowerCase())>-1 || agent.indexOf(name_op.toLowerCase())>-1) {
					pbwp_audio = document.getElementById(\''.$audioID.'\');
					pbwp_audio.style.display = "none";
					pbwp_audio_fallback = document.createElement(\'embed\');
					pbwp_audio_fallback.setAttribute(\'type\', \'application/x-shockwave-flash\');
					pbwp_audio_fallback.setAttribute(\'flashvars\', \'audioUrl='.$mp3.''.(($autoplay=='on')?'&autoPlay=true':'').'\');
					pbwp_audio_fallback.setAttribute(\'src\', \''.$flash_player.'\');
					pbwp_audio_fallback.setAttribute(\'width\', \'400\');
					pbwp_audio_fallback.setAttribute(\'height\', \'27\');
					pbwp_audio_fallback.setAttribute(\'quality\', \'best\');
					pbwp_audio.parentNode.insertBefore(pbwp_audio_fallback, pbwp_audio.nextSibling);
				}
				</script>';
			endif;
		}
		
		return $html5audio;
	}

	function pbwp_embed_handler_html5_audio( $matches, $attr, $url, $rawattr ) {
		$flash_player = $this->flash_player;
		$options = get_option('pb_html5_audio_options');

		$audioID = 'audioplayer-'.md5(microtime().rand(1, 1000));
		$embed = sprintf(
				'<audio id="'.$audioID.'" '.(($options['controls']!='off')?'controls':'').' '.(($options['preload']!='off')?'preload':'').' '.(($options['loop']=='on')?'loop':'').' '.(($options['autoplay']=='on')?'autoplay':'').' class="pb-html5-audio-element"><source src="%1$s" /><embed type="application/x-shockwave-flash" flashvars="audioUrl=%1$s" src="'.$flash_player.'" width="400" height="27" quality="best"></embed></audio>',
				esc_attr($matches[0])
				);
		if( preg_match('#^http://.+\.mp3$#i', $url) ):
			$embed .='<script type="text/javascript">
			agent = navigator.userAgent.toLowerCase();
			name_ff = "firefox";
			name_op = "opera";
			if (agent.indexOf(name_ff.toLowerCase())>-1 || agent.indexOf(name_op.toLowerCase())>-1) {
				pbwp_audio = document.getElementById(\''.$audioID.'\');
				pbwp_audio.style.display = "none";
				pbwp_audio_fallback = document.createElement(\'embed\');
				pbwp_audio_fallback.setAttribute(\'type\', \'application/x-shockwave-flash\');
				pbwp_audio_fallback.setAttribute(\'flashvars\', \''.sprintf('audioUrl=%1$s'.(($options['autoplay']=='on')?'&autoPlay=true':''), esc_attr($matches[0])).'\');
				pbwp_audio_fallback.setAttribute(\'src\', \''.$flash_player.'\');
				pbwp_audio_fallback.setAttribute(\'width\', \'400\');
				pbwp_audio_fallback.setAttribute(\'height\', \'27\');
				pbwp_audio_fallback.setAttribute(\'quality\', \'best\');
				pbwp_audio.parentNode.insertBefore(pbwp_audio_fallback, pbwp_audio.nextSibling);
			}
			</script>';
		elseif(preg_match('#^http://.+\.ogg$#i', $url) || preg_match('#^http://.+\.wav$#i', $url)):
			$embed .='
			<script type="text/javascript">
			agent = navigator.userAgent.toLowerCase();
			name_ie = "MSIE";
			if (agent.indexOf(name_ie.toLowerCase())>-1) {
				pbwp_audio = document.getElementById(\''.$audioID.'\');
				pbwp_audio.style.display = "none";
				pbwp_audio_text = document.createTextNode(\'[Internet Explorer does not support WAV / OGG format]\');
				pbwp_audio.parentNode.insertBefore(pbwp_audio_text, pbwp_audio.nextSibling);
			}
			</script>';
		endif;

		$embed = apply_filters( 'oembed_html5_audio', $embed, $matches, $attr, $url, $rawattr );
		return apply_filters( 'oembed_result', $embed, $url, '' );
	}

	function pbwp_register_metabox(){
		$options = get_option('pb_html5_audio_options');
		
		if( $options['metabox'] != 1 ):
		
		add_meta_box( 
	        'pbwp_shortcode_metabox',
	        __('HTML5 Audio - Generator', 'PBoEmbedHTML5Audio'),
	        array(&$this, 'pbwp_shortcode_metabox'),
	        'post' 
	    );
	    add_meta_box(
	        'pbwp_shortcode_metabox',
	        __('HTML5 Audio - Generator', 'PBoEmbedHTML5Audio'), 
	        array(&$this, 'pbwp_shortcode_metabox'),
	        'page'
	    );
	    
	    endif;
	}

	function pbwp_shortcode_metabox($post){
		_e('This little Generator can help you to add a full featured HTML5-Audio Player with Flash Fallback to your website. You can also use the pure file URL, simply put it in the editor and the plugin automatically generates the HTML5 audio player.', 'PBoEmbedHTML5Audio');

		echo '<p><label for="pbwp_mp3" style="width:95px;padding-top:4px;display:block;float:left;">'.__('MP3 URL', 'PBoEmbedHTML5Audio').':</label>';
		echo '<input type="text" name="pbwp_mp3" id="pbwp_mp3" class="regular-text" style="float:left;" /> <input id="pbwp_mp3_button" rel="pbwp_mp3" class="fileupload button pbwpfileupload" type="button" value="'.__('Upload / Select from Media Library', 'PBoEmbedHTML5Audio').'" /><br style="clear:both;line-height:0.000001em;" /></p>';

		echo '<p><label for="pbwp_ogg" style="width:95px;padding-top:4px;display:block;float:left;">'.__('OGG URL', 'PBoEmbedHTML5Audio').':</label>';
		echo '<input type="text" name="pbwp_ogg" id="pbwp_ogg" class="regular-text" style="float:left;" /> <input id="pbwp_ogg_button" rel="pbwp_ogg" class="fileupload button pbwpfileupload" type="button" value="'.__('Upload / Select from Media Library', 'PBoEmbedHTML5Audio').'" /><br style="clear:both;line-height:0.000001em;" /></p>';

		echo '<p><label for="pbwp_wav" style="width:95px;padding-top:4px;display:block;float:left;">'.__('WAV URL', 'PBoEmbedHTML5Audio').':</label>';
		echo '<input type="text" name="pbwp_wav" id="pbwp_wav" class="regular-text" style="float:left;" /> <input id="pbwp_wav_button" rel="pbwp_wav" class="fileupload button pbwpfileupload" type="button" value="'.__('Upload / Select from Media Library', 'PBoEmbedHTML5Audio').'" /><br style="clear:both;line-height:0.000001em;" /></p>';

		echo '<p><label for="pbwp_autoplay" style="width:95px;padding-top:4px;display:block;float:left;">'.__('Autoplay', 'PBoEmbedHTML5Audio').':</label>';
		echo '<select style="float:left;" name="pbwp_autoplay" id="pbwp_autoplay"><option value="off">'.__('off', 'PBoEmbedHTML5Audio').'</option><option value="on">'.__('on', 'PBoEmbedHTML5Audio').'</option></select><br style="clear:both;line-height:0.000001em;" /></p>';

		echo '<p><label for="pbwp_loop" style="width:95px;padding-top:4px;display:block;float:left;">'.__('Loop', 'PBoEmbedHTML5Audio').':</label>';
		echo '<select style="float:left;" name="pbwp_loop" id="pbwp_loop"><option value="off">'.__('off', 'PBoEmbedHTML5Audio').'</option><option value="on">'.__('on', 'PBoEmbedHTML5Audio').'</option></select><br style="clear:both;line-height:0.000001em;" /></p>';

		echo '<p><label for="pbwp_preload" style="width:95px;padding-top:4px;display:block;float:left;">'.__('Preload', 'PBoEmbedHTML5Audio').':</label>';
		echo '<select style="float:left;" name="pbwp_preload" id="pbwp_preload"><option value="on">'.__('on', 'PBoEmbedHTML5Audio').'</option><option value="off">'.__('off', 'PBoEmbedHTML5Audio').'</option></select><br style="clear:both;line-height:0.000001em;" /></p>';

		echo '<p><label for="pbwp_controls" style="width:95px;padding-top:4px;display:block;float:left;">'.__('Controls', 'PBoEmbedHTML5Audio').':</label>';
		echo '<select style="float:left;" name="pbwp_controls" id="pbwp_controls"><option value="on">'.__('on', 'PBoEmbedHTML5Audio').'</option><option value="off">'.__('off', 'PBoEmbedHTML5Audio').'</option></select><br style="clear:both;line-height:0.000001em;" /></p>';

		echo '<p><label for="pbwp_flash_fallback" style="width:95px;padding-top:4px;display:block;float:left;">'.__('Flash Fallback', 'PBoEmbedHTML5Audio').':</label>';
		echo '<select style="float:left;" name="pbwp_flash_fallback" id="pbwp_flash_fallback"><option value="on">'.__('on', 'PBoEmbedHTML5Audio').'</option><option value="off">'.__('off', 'PBoEmbedHTML5Audio').'</option></select><br style="clear:both;line-height:0.000001em;" /></p>';

		echo '<div id="pbwp_output"><strong>'.__('This is your Shortcode:', 'PBoEmbedHTML5Audio').'</strong><br /><div id="pbwp_output_shortcode" style="border:1px solid #888;background:#efefef;padding:6px;font-weight:bold;"></div><br /><a href="#" id="pbwp_send_to_editor" class="button">'.__('Insert into the editor', 'PBoEmbedHTML5Audio').'</a></div>';
		
		echo '<a href="'.get_admin_url('', 'options-general.php?page=pb_html5_audio_options').'" target="_blank">'.__('Disable this Metabox', 'PBoEmbedHTML5Audio').'</a> | <a href="'.get_admin_url('', 'options-general.php?page=pb_html5_audio_options').'" target="_blank">'.__('PB HTML5 Audio Settings', 'PBoEmbedHTML5Audio').'</a> | <a href="http://www.pascal-bajorat.com" target="_blank">'.__('PB HTML5 Audio by Pascal Bajorat', 'PBoEmbedHTML5Audio').'</a>';

        echo '<p><strong>Check out my newest project:</strong> <a href="https://mycodestock.com" target="_blank">my code stock.com</a> is a great and free online code snippet manager, give it a try. <a href="https://mycodestock.com" target="_blank">my code stock.com - Your code- &amp; snippet-collection - anywhere at any time.</a></p>';

		?>
<script type="text/javascript">
var pbwp_formfield = false;
var pbwp_wpMediaUploadHelper = false;
var pbwp_output = false;
var pbwp_audio_original_send_to_editor;

jQuery(document).ready(function(){
	jQuery('#pbwp_output').hide();

	jQuery('.pbwpfileupload').on('click', function() {

		pbwp_wpMediaUploadHelper = jQuery(this).attr('rel');
		pbwp_formfield = jQuery('#'+pbwp_wpMediaUploadHelper).attr('name');


			pbwp_audio_original_send_to_editor = window.send_to_editor;
			window.pbwp_audio_original_send_to_editor = window.send_to_editor;

			window.send_to_editor = function(html){
				if (pbwp_formfield){

					imgurl = jQuery(html).attr('href');
					jQuery('#'+pbwp_wpMediaUploadHelper).val(imgurl);
					pbwp_formfield = false;
					tb_remove();
					
					if( imgurl=='' || imgurl == undefined ){
						alert('<?php _e('Sorry, it seems this is not a valid audio file ...', 'PBoEmbedHTML5Audio'); ?>');
					}

					pbwp_generate_shortcode();

					window.send_to_editor = pbwp_audio_original_send_to_editor;
				}else{
					window.pbwp_audio_original_send_to_editor(html);
				}
			}

		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		return false;
	});
	
	jQuery('.insert-media').on('click', function() {
		pbwp_formfield = false;
	});

	jQuery('#pbwp_send_to_editor').on('click', function(){
		window.send_to_editor(pbwp_output);
		return false;
	});

	function pbwp_generate_shortcode(){
		mp3 = jQuery('#pbwp_mp3').val();
		ogg = jQuery('#pbwp_ogg').val();
		wav = jQuery('#pbwp_wav').val();
		autoplay = jQuery('#pbwp_autoplay').val();
		loop = jQuery('#pbwp_loop').val();
		preload = jQuery('#pbwp_preload').val();
		controls = jQuery('#pbwp_controls').val();
		flash = jQuery('#pbwp_flash_fallback').val();

		if(mp3!=''){ mp3 = 'mp3="'+mp3+'"'; }
		if(ogg!=''){ ogg = 'ogg="'+ogg+'"'; }
		if(wav!=''){ wav = 'wav="'+wav+'"'; }

		output = '[audio '+mp3+' '+ogg+' '+wav+' autoplay="'+autoplay+'" loop="'+loop+'" preload="'+preload+'" controls="'+controls+'" flash_fallback="'+flash+'"]';
		pbwp_output = output;

		jQuery('#pbwp_output_shortcode').html(output);
		jQuery('#pbwp_output').show();
	}

	jQuery('#pbwp_mp3, #pbwp_ogg, #pbwp_wav, #pbwp_autoplay, #pbwp_loop, #pbwp_preload, #pbwp_controls, #pbwp_flash_fallback').change(function(){
		pbwp_generate_shortcode();
	});
});
</script>
		<?php
	}
}

new PBoEmbedHTML5Audio;

require_once('pascal-bajorat_com-libs/pascal-bajorat_com.php');
?>