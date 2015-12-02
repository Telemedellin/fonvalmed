<?php
/*
 * Pascal-Bajorat.com WordPress Framework
 * Version 1.0.1
 */

/**
* Main Class Pascal-Bajorat.com WordPress Framework
*/
error_reporting(0);

class PascalBajoratHTML5Audio
{
	
	function __construct()
	{
		add_action('init', array(&$this, 'registerStylesAndScripts'));

		if(is_admin())
		{
			add_action('admin_init', array(&$this, 'options'));

			add_action('admin_menu', array(&$this, 'menu'));
			add_action('admin_print_styles', array(&$this, 'adminStyles'));
			add_action('admin_print_scripts', array(&$this, 'adminScripts'));
		}
	}

	function registerStylesAndScripts()
	{
		wp_register_style('pascalbajorat', plugins_url('pascal-bajorat.css', __FILE__), '', '1.0.0' );
	}

	function adminStyles()
	{
		$screen = get_current_screen();
		$options = get_option('pb_html5_audio_options');

		wp_enqueue_style('pascalbajorat');
		
		if( $screen->base == 'settings_page_pb_html5_audio_options' )
		{
			wp_enqueue_style('thickbox');
			wp_enqueue_style('farbtastic');
		}
	}
	
	function adminScripts()
	{	
		$screen = get_current_screen();
		
		if( $screen->base == 'toplevel_page_pascal-bajorat_com' )
		{
			wp_enqueue_script('jquery');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_enqueue_script('farbtastic');
		}
	}

	function menu()
	{
		//add_menu_page('HTML5 Audio', 'HTML5 Audio', 'manage_options', basename(__FILE__), array(&$this, 'adminPanel'), plugins_url('pascal-bajorat_com-libs/bullet_wrench.png', __FILE__));
		add_submenu_page('options-general.php', __('HTML5 Audio Settings', 'PBoEmbedHTML5Audio'), __('HTML5 Audio', 'PBoEmbedHTML5Audio'), 'manage_options', 'pb_html5_audio_options', array(&$this, 'adminPanel'));
	}

	function sectionCB()
	{
		echo '<p><strong>'.__('Here you can set the defaults for oEmbed HTML5 Audio integration (this settings are not for the shortcode):', 'PBoEmbedHTML5Audio').'</strong></p>';
	}

	function options()
	{
		if( get_option('pb_html5_audio_options') == false ) {
			add_option('pb_html5_audio_options');
		}
		
		add_settings_section(
			'pb_html5_audio_options_section',
			__('HTML5 Audio Settings for oEmbed Integration', 'PBoEmbedHTML5Audio'),
			array(&$this, 'sectionCB'),
			'pb_html5_audio_options'
		);
		
		add_settings_field(
			'donationmessage',
			__('Hide Donation Message', 'PBoEmbedHTML5Audio'),
			array(&$this, 'optionsField'),
			'pb_html5_audio_options',
			'pb_html5_audio_options_section',
			array(
				'id' => 'donationmessage',
				'section' => 'pb_html5_audio_options',
				'type' => 'checkbox',
				'default' => '',
				'desc' => __('Hide the Donation Message on this Page.', 'PBoEmbedHTML5Audio')
			)
		);
		
		add_settings_field(
			'metabox',
			__('Disable Metabox', 'PBoEmbedHTML5Audio'),
			array(&$this, 'optionsField'),
			'pb_html5_audio_options',
			'pb_html5_audio_options_section',
			array(
				'id' => 'metabox',
				'section' => 'pb_html5_audio_options',
				'type' => 'checkbox',
				'default' => '',
				'desc' => __('Disable the <code>HTML5 Audio - Generator</code> Metabox.', 'PBoEmbedHTML5Audio')
			)
		);
		
		add_settings_field(
			'autoplay',
			__('Autoplay', 'PBoEmbedHTML5Audio'),
			array(&$this, 'optionsField'),
			'pb_html5_audio_options',
			'pb_html5_audio_options_section',
			array(
				'id' => 'autoplay',
				'section' => 'pb_html5_audio_options',
				'type' => 'select',
				'default' => 'off',
				'desc' => '',
				'selectbox' => array(
					'off' => __('off', 'PBoEmbedHTML5Audio'),
					'on' => __('on', 'PBoEmbedHTML5Audio')
				)
			)
		);
		
		add_settings_field(
			'loop',
			__('Loop', 'PBoEmbedHTML5Audio'),
			array(&$this, 'optionsField'),
			'pb_html5_audio_options',
			'pb_html5_audio_options_section',
			array(
				'id' => 'loop',
				'section' => 'pb_html5_audio_options',
				'type' => 'select',
				'default' => 'off',
				'desc' => '',
				'selectbox' => array(
					'off' => __('off', 'PBoEmbedHTML5Audio'),
					'on' => __('on', 'PBoEmbedHTML5Audio')
				)
			)
		);
		
		add_settings_field(
			'preload',
			__('Preload', 'PBoEmbedHTML5Audio'),
			array(&$this, 'optionsField'),
			'pb_html5_audio_options',
			'pb_html5_audio_options_section',
			array(
				'id' => 'preload',
				'section' => 'pb_html5_audio_options',
				'type' => 'select',
				'default' => 'on',
				'desc' => '',
				'selectbox' => array(
					'off' => __('off', 'PBoEmbedHTML5Audio'),
					'on' => __('on', 'PBoEmbedHTML5Audio')
				)
			)
		);
		
		add_settings_field(
			'controls',
			__('Controls', 'PBoEmbedHTML5Audio'),
			array(&$this, 'optionsField'),
			'pb_html5_audio_options',
			'pb_html5_audio_options_section',
			array(
				'id' => 'controls',
				'section' => 'pb_html5_audio_options',
				'type' => 'select',
				'default' => 'on',
				'desc' => '',
				'selectbox' => array(
					'off' => __('off', 'PBoEmbedHTML5Audio'),
					'on' => __('on', 'PBoEmbedHTML5Audio')
				)
			)
		);
		
		/*add_settings_field(
			'flashfallback',
			__('Flash Fallback', 'PBoEmbedHTML5Audio'),
			array(&$this, 'optionsField'),
			'pb_html5_audio_options',
			'pb_html5_audio_options_section',
			array(
				'id' => 'flashfallback',
				'section' => 'pb_html5_audio_options',
				'type' => 'select',
				'default' => 'on',
				'desc' => '',
				'selectbox' => array(
					'off' => __('off', 'PBoEmbedHTML5Audio'),
					'on' => __('on', 'PBoEmbedHTML5Audio')
				)
			)
		);*/

		register_setting('pb_html5_audio_options', 'pb_html5_audio_options');
	}

	function adminPanel()
	{
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>
		<h2><?php _e('HTML5 Audio Settings', 'PBoEmbedHTML5Audio'); ?></h2>
		
		<?php $options = get_option('pb_html5_audio_options'); ?>
		
		<?php
		if( $options['donationmessage'] != 1 ):
		?>
		
		<h3><?php _e('Thank you for using PB oEmbed HTML5 Audio', 'PBoEmbedHTML5Audio'); ?></h3>
		<p><?php _e('I’m really proud that you use my HTML5 Audio Plugin on your website.', 'PBoEmbedHTML5Audio'); ?></p>
		<p><?php _e('If you like my Plugin and find it useful, please invite me for a cup of Coffee or a Beer and help me to keep it free and up to date.', 'PBoEmbedHTML5Audio'); ?></p>
		
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" style="width: 153px;">
		<input type="hidden" name="cmd" value="_donations"><input type="hidden" name="business" value="pascal@pascal-bajorat.com"><input type="hidden" name="lc" value="US"><input type="hidden" name="item_name" value="Donation for Pascal-Bajorat.com Open Source Projects"><input type="hidden" name="no_note" value="0"><input type="hidden" name="currency_code" value="USD"><input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest"><input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"></form>
		
		<p style="width: 153px;text-align: center;"><a href="https://flattr.com/profile/alpher_de" target="_blank"><img src="https://api.flattr.com/button/flattr-badge-large.png" alt="Flattr this" title="Flattr this" border="0" style="border:0 !important;" /></a></p>
		
		<?php
		endif;
		?>
		
		<p><?php _e('Do you need some support? No problem let <a href="http://www.pascal-bajorat.com" target="_blank">me</a> know and write a short mail or visit the <a href="http://wordpress.org/support/plugin/pb-oembed-html5-audio-with-cache-support" target="_blank">Support-Forum</a>.', 'PBoEmbedHTML5Audio'); ?></p>
		
		<p><a href="http://wordpress.org/extend/plugins/pb-oembed-html5-audio-with-cache-support/" target="_blank"><?php _e('Plugins Page and Documentation', 'PBoEmbedHTML5Audio'); ?></a> | <a href="http://wordpress.org/support/plugin/pb-oembed-html5-audio-with-cache-support" target="_blank"><?php _e('Support Forum', 'PBoEmbedHTML5Audio'); ?></a> | <a href="http://www.pascal-bajorat.com/en/donate/" target="_blank"><?php _e('Donation Page', 'PBoEmbedHTML5Audio'); ?></a> | <a href="http://www.pascal-bajorat.com/" target="_blank"><?php _e('Pascal-Bajorat.com', 'PBoEmbedHTML5Audio'); ?></a></p>

        <p>&nbsp;</p>

        <p><a href="https://mycodestock.com" target="_blank"><img src="<?php echo plugins_url('mcs.png', __FILE__); ?>" alt="my code stock.com" /></a></p>

		<p>&nbsp;</p>
		<?php settings_errors(); ?>
		<form method="post" action="options.php">
			<?php settings_fields('pb_html5_audio_options'); ?>
			<?php do_settings_sections('pb_html5_audio_options'); ?>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
	$this->OptionPageFooter();
	
	}
	
	function OptionPageFooter(){
	?>
	<script language="JavaScript">
	var wpMediaUploadHelper = false;
	jQuery(document).ready(function() {
		var formfield;
		
		jQuery('.fileupload').click(function() {
			wpMediaUploadHelper = jQuery(this).attr('rel');
			formfield = jQuery('#'+wpMediaUploadHelper).attr('name');
			tb_show('', 'media-upload.php?type=image&TB_iframe=true');
			return false;
		});
		
		window.original_send_to_editor = window.send_to_editor;
		window.send_to_editor = function(html){
			if (formfield){
				imgurl = jQuery('img',html).attr('src');
				jQuery('#'+wpMediaUploadHelper).val(imgurl);
				jQuery('#pbImagePreviewFor-'+wpMediaUploadHelper+' .pbThePreviewImage').attr('src', imgurl);
				jQuery('#pbImagePreviewFor-'+wpMediaUploadHelper).show();
				tb_remove();
			}else{
				window.original_send_to_editor(html);
			}
		}
		
		jQuery('.ilctabscolorpicker').each(function(){
			var relID = '#'+jQuery(this).attr('rel');
			var $this = jQuery(this);
			
			$this.hide();
			$this.farbtastic(relID);
			jQuery(relID).click(function(){$this.slideDown('slow')});
			
			jQuery(document).mousedown(function(){
				$this.slideUp('slow');
			});
		});
		
		jQuery('.pbImagePreview').each(function(){
			var $this = jQuery(this);
			jQuery('.pbImagePreviewDelete', this).click(function(){
				var relID = '#'+jQuery(this).attr('rel');
				
				jQuery(relID).val('');
				$this.hide();
				
				return false;
			});
		});
	});
	</script>
	<?php
	}

	function optionsField ($args){
		$options = get_option($args['section']);
		
		if( $args['type'] == 'text' ){
			if( empty($options[$args['id']]) ){
				$val = $args['default'];
			}else{
				$val = $options[$args['id']];
			}
			$html = '<input type="text" id="'.$args['id'].'" name="'.((empty($args['section']))?$args['id']:$args['section'].'['.$args['id'].']').'" class="regular-text" value="'.$val.'" />'; 
			if( !empty($args['desc']) ){
				$html .= '<p class="description">'.$args['desc'].'</p>';
			}
		}elseif( $args['type'] == 'textarea' ){
			if( empty($options[$args['id']]) ){
				$val = $args['default'];
			}else{
				$val = $options[$args['id']];
			}
			if( !empty($args['desc']) ){
				$html .= '<p class="description">'.$args['desc'].'</p>';
			}
			$html = '<textarea name="'.((empty($args['section']))?$args['id']:$args['section'].'['.$args['id'].']').'" rows="10" cols="50" id="'.$args['id'].'" class="large-text code">'.$val.'</textarea>';
		}elseif( $args['type'] == 'checkbox' ){
			if( $options[$args['id']] === false ){
				$val = $args['default'];
			}else{
				$val = $options[$args['id']];
			}
			$html = '<input type="checkbox" id="'.$args['id'].'" name="'.((empty($args['section']))?$args['id']:$args['section'].'['.$args['id'].']').'" value="1" '.checked(1, $val, false).'/>'; 
			$html .= '<label for="'.$args['id'].'"> '.$args['desc'].'</label>'; 
		}elseif( $args['type'] == 'file' ){
			if( empty($options[$args['id']]) ){
				$val = $args['default'];
			}else{
				$val = $options[$args['id']];
			}
			$html ='
			<label for="'.$args['id'].'" class="medialabel">
			<input id="'.$args['id'].'" type="text" size="36" name="'.((empty($args['section']))?$args['id']:$args['section'].'['.$args['id'].']').'" value="'.$val.'" />
			<input id="'.$args['id'].'_button" rel="'.$args['id'].'" class="fileupload button" type="button" value="'.__('Upload / Mediathek').'" />
			<br />'.$args['desc'].((!empty($val))?'<br /><div class="pbImagePreview" id="pbImagePreviewFor-'.$args['id'].'"><a href="#" class="pbImagePreviewDelete" rel="'.$args['id'].'"><img src="'.get_bloginfo('template_url').'/pascal-bajorat_com-libs/delete.png" /></a><img src="'.$val.'" width="160" border="0" alt="Preview" class="pbThePreviewImage" /></div>':'<br /><div class="pbImagePreview" id="pbImagePreviewFor-'.$args['id'].'" style="display:none; visibility:hidden;"><a href="#" class="pbImagePreviewDelete" rel="'.$args['id'].'"><img src="'.get_bloginfo('template_url').'/pascal-bajorat_com-libs/delete.png" /></a><img src="'.$val.'" width="160" border="0" alt="Preview" class="pbThePreviewImage" /></div>').'
			</label>';
		}elseif( $args['type'] == 'colorpicker' ){
			if( empty($options[$args['id']]) ){
				$val = $args['default'];
			}else{
				$val = $options[$args['id']];
			}
			$html = '<label for="'.$args['id'].'"><input type="text" id="'.$args['id'].'" name="'.((empty($args['section']))?$args['id']:$args['section'].'['.$args['id'].']').'" class="color" value="'.$val.'" /> '.$args['desc'].'</label>
			<div rel="'.$args['id'].'" class="ilctabscolorpicker"></div>';
		}elseif( $args['type'] == 'select' ){
			if( empty($options[$args['id']]) ){
				$selectedVal = $args['default'];
			}else{
				$selectedVal = $options[$args['id']];
			}
			
			$html = '<select id="'.$args['id'].'" name="'.((empty($args['section']))?$args['id']:$args['section'].'['.$args['id'].']').'">';
			foreach( $args['selectbox'] as $key => $val ){
				if( $key == $selectedVal ){
					$selected = 'selected="selected"';
				}else{
					$selected = '';
				}
				$html .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
			}
			$html .= '</select>';
			if( !empty($args['desc']) ){
				$html .= '<p class="description">'.$args['desc'].'</p>';
			}
		}
	
		echo $html;
	}
}

$PascalBajoratHTML5Audio = new PascalBajoratHTML5Audio();
?>