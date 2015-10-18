<?php 

require_once 'class-wonderplugin-gallery-list-table.php';
require_once 'class-wonderplugin-gallery-creator.php';

class WonderPlugin_Gallery_View {

	private $controller;
	private $list_table;
	private $creator;
	
	function __construct($controller) {
		
		$this->controller = $controller;
	}
	
	function add_metaboxes() {
		add_meta_box('overview_features', __('WonderPlugin Gallery Features', 'wonderplugin_gallery'), array($this, 'show_features'), 'wonderplugin_gallery_overview', 'features', '');
		add_meta_box('overview_upgrade', __('Upgrade to Commercial Version', 'wonderplugin_gallery'), array($this, 'show_upgrade_to_commercial'), 'wonderplugin_gallery_overview', 'upgrade', '');
		add_meta_box('overview_news', __('WonderPlugin News', 'wonderplugin_gallery'), array($this, 'show_news'), 'wonderplugin_gallery_overview', 'news', '');
		add_meta_box('overview_contact', __('Contact Us', 'wonderplugin_gallery'), array($this, 'show_contact'), 'wonderplugin_gallery_overview', 'contact', '');
	}
	
	function show_upgrade_to_commercial() {
		?>
		<ul class="wonderplugin-feature-list">
			<li>Use on commercial websites</li>
			<li>Remove the wonderplugin.com watermark</li>
			<li>Priority techincal support</li>
			<li><a href="http://www.wonderplugin.com/order/?product=gallery" target="_blank">Buy Commercial Version</a></li>
		</ul>
		<?php
	}
	
	function show_news() {
		
		include_once( ABSPATH . WPINC . '/feed.php' );
		
		$rss = fetch_feed( 'http://www.wonderplugin.com/feed/' );
		
		$maxitems = 0;
		if ( ! is_wp_error( $rss ) )
		{
			$maxitems = $rss->get_item_quantity( 5 );
			$rss_items = $rss->get_items( 0, $maxitems );
		}
		?>
		
		<ul class="wonderplugin-feature-list">
		    <?php if ( $maxitems > 0 ) {
		        foreach ( $rss_items as $item )
		        {
		        	?>
		        	<li>
		                <a href="<?php echo esc_url( $item->get_permalink() ); ?>" target="_blank" 
		                    title="<?php printf( __( 'Posted %s', 'wonderplugin_gallery' ), $item->get_date('j F Y | g:i a') ); ?>">
		                    <?php echo esc_html( $item->get_title() ); ?>
		                </a>
		                <p><?php echo esc_html( $item->get_description() ); ?></p>
		            </li>
		        	<?php 
		        }
		    } ?>
		</ul>
		<?php
	}
	
	function show_features() {
		?>
		<ul class="wonderplugin-feature-list">
			<li>Support images, YouTube, Vimeo, Dailymotion and MP4/WebM videos</li>
			<li>Support extra high quality video files to create an HD video player</li>
			<li>Works on mobile, tablets and all major web browsers, including iPhone, iPad, Android, Firefox, Safari, Chrome, Internet Explorer 7/8/9/10/11 and Opera</li>
			<li>Pre-defined professional skins</li>
			<li>Fully responsive</li>
			<li>Easy-to-use wizard style user interface</li>
			<li>Instantly preview</li>
			<li>Provide shortcode and PHP code to insert the gallery to pages, posts or templates</li>
		</ul>
		<?php
	}
	
	function show_contact() {
		?>
		<p>Technical support is available for Commercial Version users at support@wonderplugin.com. Please include your license information, WordPress version, link to your gallery, all related error messages in your email.</p> 
		<?php
	}
	
	function print_overview() {
		
		?>
		<div class="wrap">
		<div id="icon-wonderplugin-gallery" class="icon32"><br /></div>
			
		<h2><?php echo __( 'WonderPlugin Gallery', 'wonderplugin_gallery' ) . ( (WONDERPLUGIN_GALLERY_VERSION_TYPE == "C") ? " Commercial Version" : " Free Version") . " " . WONDERPLUGIN_GALLERY_VERSION; ?> </h2>
		 
		<div id="welcome-panel" class="welcome-panel">
			<div class="welcome-panel-content">
				<h3>WordPress Photo and Video Gallery Plugin</h3>
				<div class="welcome-panel-column-container">
					<div class="welcome-panel-column">
						<h4>Get Started</h4>
						<a class="button button-primary button-hero" href="<?php echo admin_url('admin.php?page=wonderplugin_gallery_add_new'); ?>">Create A New Gallery</a>
					</div>
					<div class="welcome-panel-column">
						<h4>More Actions</h4>
						<ul>
							<li><a href="<?php echo admin_url('admin.php?page=wonderplugin_gallery_show_items'); ?>" class="welcome-icon welcome-widgets-menus">Manage Existing Galleries</a></li>
							<?php  if (WONDERPLUGIN_GALLERY_VERSION_TYPE !== "C") { ?>
							<li><a href="http://www.wonderplugin.com/order/?product=gallery" target="_blank" class="welcome-icon welcome-view-site">Buy Commercial Version</a></li>
							<?php } ?>
						</ul>
					</div>
					<div class="welcome-panel-column welcome-panel-last">
						<h4>Help Document</h4>
						<ul>
							<li><a href="http://www.wonderplugin.com/wordpress-gallery/help/" target="_blank" class="welcome-icon welcome-learn-more">Quick Start</a></li>
							<li><a href="http://www.wonderplugin.com/wordpress-tutorials/how-to-upgrade-to-wonderplugin-commercial-version/" target="_blank" class="welcome-icon welcome-learn-more">How to Upgrade to Commercial or New Version</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<div id="dashboard-widgets-wrap">
			<div id="dashboard-widgets" class="metabox-holder columns-2">
	 
	                 <div class="postbox-container">
	                    <?php 
	                    do_meta_boxes( 'wonderplugin_gallery_overview', 'features', '' ); 
	                    do_meta_boxes( 'wonderplugin_gallery_overview', 'contact', '' ); 
	                    ?>
	                </div>
	 
	                <div class="postbox-container">
	                    <?php 
	                    if (WONDERPLUGIN_GALLERY_VERSION_TYPE != "C")
	                    	do_meta_boxes( 'wonderplugin_gallery_overview', 'upgrade', ''); 
	                    do_meta_boxes( 'wonderplugin_gallery_overview', 'news', ''); 
	                    ?>
	                </div>
	 
	        </div>
        </div>
            
		<?php
	}
	
	function print_edit_settings() {
		?>
				<div class="wrap">
				<div id="icon-wonderplugin-gallery" class="icon32"><br /></div>
					
				<h2><?php _e( 'Settings', 'wonderplugin_gallery' ); ?></h2>
				<?php

				if ( isset($_POST['save-gallery-options']) && check_admin_referer('wonderplugin-gallery', 'wonderplugin-gallery-settings') )
				{		
					unset($_POST['save-gallery-options']);
					
					$this->controller->save_settings($_POST);
					
					echo '<div class="updated"><p>Settings saved.</p></div>';
				}
								
				$settings = $this->controller->get_settings();
				$userrole = $settings['userrole'];
				$keepdata = $settings['keepdata'];
				$disableupdate = $settings['disableupdate'];
				$supportwidget = $settings['supportwidget'];
				$addjstofooter = $settings['addjstofooter'];
				$jsonstripcslash = $settings['jsonstripcslash'];
				
				?>
				
				<h3>The settings page is only available for users of Administrator role.</h3>						
		        <form method="post">
		        
		        <?php wp_nonce_field('wonderplugin-gallery', 'wonderplugin-gallery-settings'); ?>
		        
		        <table class="form-table">
		        
		        <tr valign="top">
					<th scope="row">Set minimum user role of plugin administration</th>
					<td>
						<select name="userrole">
						  <option value="Administrator" <?php echo ($userrole == 'manage_options') ? 'selected="selected"' : ''; ?>>Administrator</option>
						  <option value="Editor" <?php echo ($userrole == 'moderate_comments') ? 'selected="selected"' : ''; ?>>Editor</option>
						  <option value="Author" <?php echo ($userrole == 'upload_files') ? 'selected="selected"' : ''; ?>>Author</option>
						</select>
					</td>
				</tr>

				<tr>
					<th>Data option</th>
					<td><label><input name='keepdata' type='checkbox' id='keepdata' <?php echo ($keepdata == 1) ? 'checked' : ''; ?> /> Keep data when deleting the plugin</label>
					</td>
				</tr>
				
				<tr>
					<th>Update option</th>
					<td><label><input name='disableupdate' type='checkbox' id='disableupdate' <?php echo ($disableupdate == 1) ? 'checked' : ''; ?> /> Disable plugin version check and update</label>
					</td>
				</tr>
			
				<tr>
					<th>Display gallery in widget</th>
					<td><label><input name='supportwidget' type='checkbox' id='supportwidget' <?php echo ($supportwidget == 1) ? 'checked' : ''; ?> /> Support shortcode in text widget</label>
					</td>
				</tr>
				
				<tr>
					<th>Scripts position</th>
					<td><label><input name='addjstofooter' type='checkbox' id='addjstofooter' <?php echo ($addjstofooter == 1) ? 'checked' : ''; ?> /> Add gallery js scripts to the footer</label>
					</td>
				</tr>
				
				<tr>
					<th>JSON options</th>
					<td><label><input name='jsonstripcslash' type='checkbox' id='jsonstripcslash' <?php echo ($jsonstripcslash == 1) ? 'checked' : ''; ?> /> Remove backslashes in JSON string</label>
					</td>
				</tr>
		
				</table>
		        
		        <p class="submit"><input type="submit" name="save-gallery-options" id="save-gallery-options" class="button button-primary" value="Save Changes"  /></p>
		        
		        </form>
		        
				</div>
				<?php
	}
	
	function print_register() {
		?>
		<div class="wrap">
		<div id="icon-wonderplugin-gallery" class="icon32"><br /></div>
			
		<h2><?php _e( 'Register', 'wonderplugin_gallery' ); ?></h2>
		<?php
				
		if (isset($_POST['save-gallery-license']) && check_admin_referer('wonderplugin-gallery', 'wonderplugin-gallery-register') )
		{		
			unset($_POST['save-gallery-license']);

			$ret = $this->controller->check_license($_POST);
			
			if ($ret['status'] == 'valid')
				echo '<div class="updated"><p>The key has been saved.</p></div>';
			else if ($ret['status'] == 'expired')
				echo '<div class="error"><p>Your free upgrade period has expired, please renew your license.</p></div>';
			else if ($ret['status'] == 'invalid')
				echo '<div class="error"><p>The key is invalid.</p></div>';
			else if ($ret['status'] == 'abnormal')
				echo '<div class="error"><p>There is abnormal usage with your license key, please contact support@wonderplugin.com for more information.</p></div>';
			else if ($ret['status'] == 'timeout')
				echo '<div class="error"><p>The license server can not be reached, please try again later.</p></div>';
			else if ($ret['status'] == 'empty')
				echo '<div class="error"><p>Please enter your license key.</p></div>';
		}
		else if (isset($_POST['deregister-gallery-license']) && check_admin_referer('wonderplugin-gallery', 'wonderplugin-gallery-register') )
		{	
			$ret = $this->controller->deregister_license($_POST);
			
			if ($ret['status'] == 'success')
				echo '<div class="updated"><p>The key has been deregistered.</p></div>';
			else if ($ret['status'] == 'timeout')
				echo '<div class="error"><p>The license server can not be reached, please try again later.</p></div>';
			else if ($ret['status'] == 'empty')
				echo '<div class="error"><p>The license key is empty.</p></div>';
		}
		
		$settings = $this->controller->get_settings();
		$disableupdate = $settings['disableupdate'];
		
		$key = '';
		$info = $this->controller->get_plugin_info();
		if (!empty($info->key) && ($info->key_status == 'valid' || $info->key_status == 'expired'))
			$key = $info->key;
		
		?>
		
		<?php 
		if ($disableupdate == 1)
		{
			echo "<h3 style='padding-left:10px;'>The plugin version check and update is currently disabled. You can enable it in the Settings menu.</h3>";
		}
		else
		{
			if (empty($key)) { ?>
				<form method="post">
				<?php wp_nonce_field('wonderplugin-gallery', 'wonderplugin-gallery-register'); ?>
				<table class="form-table">
				<tr>
					<th>Enter Your License Key:</th>
					<td><input name="wonderplugin-gallery-key" type="text" id="wonderplugin-gallery-key" value="" class="regular-text" /> <input type="submit" name="save-gallery-license" id="save-gallery-license" class="button button-primary" value="Register License Key"  />
					</td>
				</tr>
				</table>
				</form>
			<?php } else { ?>
				<form method="post">
				<?php wp_nonce_field('wonderplugin-gallery', 'wonderplugin-gallery-register'); ?>
				<table class="form-table">
				<tr>
					<th>Your License Key is:</th>
					<td><?php echo esc_html($key); ?> &nbsp;&nbsp;&nbsp;&nbsp;<input name="wonderplugin-gallery-key" type="hidden" id="wonderplugin-gallery-key" value="<?php echo esc_html($key); ?>" class="regular-text" /><input type="submit" name="deregister-gallery-license" id="deregister-gallery-license" class="button button-primary" value="Deregister the License Key"  /></label></td>
				</tr>
				</table>
				</form>
				
				<form method="post">
				<?php wp_nonce_field('wonderplugin-gallery', 'wonderplugin-gallery-register'); ?>
				<table class="form-table">
				<?php if ($info->key_status == 'valid') { ?>
				<tr>
					<th></th>
					<td>
					<p><strong>Your license key is valid.</strong> The key has been successfully registered with this domain.</p></td>
				</tr>
				<?php } else if ($info->key_status == 'expired') { ?>
				<tr>
					<th></th>
					<td>
					<p><strong>Your free upgrade period has expired.</strong> To get upgrades, please <a href="https://www.wonderplugin.com/renew/" target="_blank">renew your license</a>.</p>
				</tr>
				<?php } ?>
				</table>
				</form>
			<?php } ?>

		<?php } ?>
		
		<div style="padding-left:10px;padding-top:30px;">
		<a href="<?php echo admin_url('update-core.php?force-check=1'); ?>"><button class="button-primary">Force WordPress To Check For Plugin Updates</button></a>
		</div>
					
		<div style="padding-left:10px;padding-top:20px;">
        <h3><a href="https://www.wonderplugin.com/register-faq/" target="_blank">Where can I find my license key and other frequently asked questions</a></h3>
        </div>
        
		</div>
		
		<?php
	}
	
	function print_items() {
		
		?>
		<div class="wrap">
		<div id="icon-wonderplugin-gallery" class="icon32"><br /></div>
			
		<h2><?php _e( 'Manage Galleries', 'wonderplugin_gallery' ); ?> <a href="<?php echo admin_url('admin.php?page=wonderplugin_gallery_add_new'); ?>" class="add-new-h2"> <?php _e( 'New Gallery', 'wonderplugin_gallery' ); ?></a> </h2>
		
		<?php $this->process_actions(); ?>
		
		<form id="slider-list-table" method="post">
		<input type="hidden" name="page" value="<?php echo esc_html($_REQUEST['page']); ?>" />
		<?php 
		
		if ( !is_object($this->list_table) )
			$this->list_table = new WonderPlugin_Gallery_List_Table($this);
		
		$this->list_table->list_data = $this->controller->get_list_data();
		$this->list_table->prepare_items();
		$this->list_table->display();		
		?>								
        </form>
        
		</div>
		<?php
	}
	
	function print_item()
	{
		if ( !isset( $_REQUEST['itemid'] ) || !is_numeric( $_REQUEST['itemid'] ) )
			return;
		
		?>
		<div class="wrap">
		<div id="icon-wonderplugin-gallery" class="icon32"><br /></div>
					
		<h2><?php _e( 'View Gallery', 'wonderplugin_gallery' ); ?> <a href="<?php echo admin_url('admin.php?page=wonderplugin_gallery_edit_item') . '&itemid=' . $_REQUEST['itemid']; ?>" class="add-new-h2"> <?php _e( 'Edit Gallery', 'wonderplugin_gallery' ); ?>  </a> </h2>
		
		<div class="updated"><p style="text-align:center;">  <?php _e( 'To embed the gallery into your page, use shortcode: ', 'wonderplugin_gallery' ); ?> <?php echo esc_attr('[wonderplugin_gallery id="' . $_REQUEST['itemid'] . '"]'); ?></p></div>

		<div class="updated"><p style="text-align:center;">  <?php _e( 'To embed the gallery into your template, use php code: ', 'wonderplugin_gallery' ); ?> <?php echo esc_attr('<?php echo do_shortcode(\'[wonderplugin_gallery id="' . $_REQUEST['itemid'] . '"]\'); ?>'); ?></p></div>
		
		<?php
		if (WONDERPLUGIN_GALLERY_VERSION_TYPE !== "C")
			echo '<div class="updated"><p style="text-align:center;">To remove the Free Version watermark, please <a href="https://www.wonderplugin.com/order/?product=gallery" target="_blank">Upgrade to Commercial Version</a>.</p></div>';
		
		echo $this->controller->generate_body_code( $_REQUEST['itemid'], true ); 
		?>	 
		
		</div>
		<?php
	}
	
	function process_actions()
	{
		
		if ( isset($_REQUEST['action']) && ($_REQUEST['action'] == 'delete') && isset( $_REQUEST['itemid'] ) )
		{
			$deleted = 0;
			
			if ( is_array( $_REQUEST['itemid'] ) )
			{
				foreach( $_REQUEST['itemid'] as $id)
				{
					if ( is_numeric($id) )
					{
						$ret = $this->controller->delete_item($id);
						if ($ret > 0)
							$deleted += $ret;
					}
				}
			}
			else if ( is_numeric($_REQUEST['itemid']) )
			{
				$deleted = $this->controller->delete_item( $_REQUEST['itemid'] );
			}
			
			if ($deleted > 0)
			{
				echo '<div class="updated"><p>';
				printf( _n('%d gallery deleted.', '%d galleries deleted.', $deleted), $deleted );
				echo '</p></div>';
			}
		}
		
		if ( isset($_REQUEST['action']) && ($_REQUEST['action'] == 'clone') && isset( $_REQUEST['itemid'] ) && is_numeric( $_REQUEST['itemid'] ))
		{
			$cloned_id = $this->controller->clone_item( $_REQUEST['itemid'] );
			if ($cloned_id > 0)
			{
				echo '<div class="updated"><p>';
				printf( 'New gallery created with ID: %d', $cloned_id );
				echo '</p></div>';
			}
			else
			{
				echo '<div class="error"><p>';
				printf( 'The gallery cannot be cloned.' );
				echo '</p></div>';
			}
		}
	}

	function print_add_new() {
		
		if ( !empty($_POST['wonderplugin-gallery-save-item-post-value']) && !empty($_POST['wonderplugin-gallery-save-item-post']) && check_admin_referer('wonderplugin-gallery', 'wonderplugin-gallery-saveform') )
		{
			$this->save_item_post($_POST['wonderplugin-gallery-save-item-post-value']);
			return;
		}
		
		?>
		<div class="wrap">
		<div id="icon-wonderplugin-gallery" class="icon32"><br /></div>
			
		<h2><?php _e( 'New Gallery', 'wonderplugin_gallery' ); ?> <a href="<?php echo admin_url('admin.php?page=wonderplugin_gallery_show_items'); ?>" class="add-new-h2"> <?php _e( 'Manage Galleries', 'wonderplugin_gallery' ); ?>  </a> </h2>
		
		<?php 
		$this->creator = new WonderPlugin_Gallery_Creator($this);		
		echo $this->creator->render( -1, null);
	}
	
	function print_edit_item()
	{
		if ( !empty($_POST['wonderplugin-gallery-save-item-post-value']) && !empty($_POST['wonderplugin-gallery-save-item-post']) && check_admin_referer('wonderplugin-gallery', 'wonderplugin-gallery-saveform') )
		{
			$this->save_item_post($_POST['wonderplugin-gallery-save-item-post-value']);
			return;
		}
		
		if ( !isset( $_REQUEST['itemid'] ) || !is_numeric( $_REQUEST['itemid'] ) )
			return;
	
		?>
		<div class="wrap">
		<div id="icon-wonderplugin-gallery" class="icon32"><br /></div>
			
		<h2><?php _e( 'Edit Gallery', 'wonderplugin_gallery' ); ?> <a href="<?php echo admin_url('admin.php?page=wonderplugin_gallery_show_item') . '&itemid=' . $_REQUEST['itemid']; ?>" class="add-new-h2"> <?php _e( 'View Gallery', 'wonderplugin_gallery' ); ?>  </a> </h2>
		
		<?php 
		$this->creator = new WonderPlugin_Gallery_Creator($this);
		echo $this->creator->render( $_REQUEST['itemid'], $this->controller->get_item_data( $_REQUEST['itemid'] ) );
	}
	
	function save_item_post($item_post) {
	
		$jsonstripcslash = get_option( 'wonderplugin_gallery_jsonstripcslash', 1 );
		if ($jsonstripcslash == 1)
			$json_post = trim(stripcslashes($item_post));
		else
			$json_post = trim($item_post);
		
		$items = json_decode($json_post, true);
			
		if ( empty($items) )
		{
			$json_error = "json_decode error";
			if ( function_exists('json_last_error_msg') )
				$json_error .= ' - ' . json_last_error_msg();
			else if ( function_exists('json_last_error') )
				$json_error .= 'code - ' . json_last_error();
		
			$ret = array(
					"success" => false,
					"id" => -1,
					"message" => $json_error . ". <b>To fix the problem, in the Plugin Settings menu, please uncheck the option Remove backslashes in JSON string and try again.</b>",
					"errorcontent"	=> $json_post
			);
		}
		else
		{
			foreach ($items as $key => &$value)
			{
				if ($value === true)
					$value = "true";
				else if ($value === false)
					$value = "false";
				else if ( is_string($value) )
					$value = wp_kses_post($value);
			}
		
			if (isset($items["slides"]) && count($items["slides"]) > 0)
			{
				foreach ($items["slides"] as $key => &$slide)
				{
					foreach ($slide as $key => &$value)
					{
						if ($value === true)
							$value = "true";
						else if ($value === false)
							$value = "false";
						else if ( is_string($value) )
							$value = wp_kses_post($value);
					}
				}
			}
		
			$ret = $this->controller->save_item($items);
		}
		?>
				
		<div class="wrap">
		<div id="icon-wonderplugin-gallery" class="icon32"><br /></div>
		
		<?php 
		if (isset($ret['success']) && $ret['success'] && isset($ret['id']) && $ret['id'] >= 0) 
		{
			echo "<h2>Gallery Saved.";
			echo "<a href='" . admin_url('admin.php?page=wonderplugin_gallery_edit_item') . '&itemid=' . $ret['id'] . "' class='add-new-h2'>Edit Gallery</a>";
			echo "<a href='" . admin_url('admin.php?page=wonderplugin_gallery_show_item') . '&itemid=' . $ret['id'] . "' class='add-new-h2'>View Gallery</a>";
			echo "</h2>";
					
			echo "<div class='updated'><p>The gallery has been saved and published.</p></div>";
			echo "<div class='updated'><p>To embed the gallery into your page or post, use shortcode:  [wonderplugin_gallery id=\"" . $ret['id'] . "\"]</p></div>";
			echo "<div class='updated'><p>To embed the gallery into your template, use php code:  &lt;?php echo do_shortcode('[wonderplugin_gallery id=\"" . $ret['id'] . "\"]'); ?&gt;</p></div>"; 
		}
		else
		{
			echo "<h2>WonderPlugin Gallery</h2>";
			echo "<div class='error'><p>The gallery can not be saved.</p></div>";
			echo "<div class='error'><p>Error Message: " . ((isset($ret['message'])) ? $ret['message'] : "") . "</p></div>";
			echo "<div class='error'><p>Error Content: " . ((isset($ret['errorcontent'])) ? $ret['errorcontent'] : "") . "</p></div>";
		}	
	}
}