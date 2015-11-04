<?php
    class TS_VCSC_AutoUpdate {
		/**
		 * The plugin current version
		 * @var string
		 */
		public $current_version;
		
		/**
		 * The plugin remote update path
		 * @var string
		 */
		public $update_path;
		
		/**
		 * Plugin Slug (plugin_directory/plugin_file.php)
		 * @var string
		 */
		public $plugin_slug;
		
		/**
		 * Plugin name (plugin_file)
		 * @var string
		 */
		public $slug;
		
		/**
		 * Initialize a new instance of the WordPress Auto-Update class
		 * @param string $current_version
		 * @param string $update_path
		 * @param string $plugin_slug
		 */
		function __construct($current_version, $update_path, $plugin_slug) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			// Set the class public variables
			$this->current_version 	= $current_version;
			$this->update_path 		= $update_path;
			$this->plugin_slug		= $plugin_slug;
			list ($t1, $t2) 		= explode('/', $plugin_slug);
			$this->slug 			= str_replace('.php', '', $t2);
			// define the alternative API for updating checking
			add_filter('pre_set_site_transient_update_plugins', array(&$this, 'check_update'));
			// Define the alternative response for information checking
			add_filter('plugins_api', array(&$this, 'check_info'), 10, 3);
		}
		
		/**
		 * Add our self-hosted autoupdate plugin to the filter transient
		 *
		 * @param $transient
		 * @return object $ transient
		 */
		public function check_update($transient) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			// Get the remote version
			$remote_version     = $this->getRemote_version();
			$current_version    = $this->current_version;
		
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
				update_site_option('ts_vcsc_extend_settings_versionCurrent', 		$current_version);
				update_site_option('ts_vcsc_extend_settings_versionLatest', 		$remote_version);
			} else {
				update_option('ts_vcsc_extend_settings_versionCurrent', 			$current_version);
				update_option('ts_vcsc_extend_settings_versionLatest', 				$remote_version);
			}
		
			if (empty($transient->checked)) {
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
					update_site_option('ts_vcsc_extend_settings_updateAvailable', 	0);
				} else {
					update_option('ts_vcsc_extend_settings_updateAvailable', 		0);
				}
				return $transient;
			}
			
			if ((TS_VCSC_VersionCompare($current_version, $remote_version) != -1)) {
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
					update_site_option('ts_vcsc_extend_settings_updateAvailable', 	0);
				} else {
					update_option('ts_vcsc_extend_settings_updateAvailable', 		0);
				}
				return $transient;
			}
			if ((TS_VCSC_VersionCompare($current_version, $remote_version) == -1)) {
			if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_PluginIsMultiSiteActive == "true") {
				if ((strlen(get_site_option('ts_vcsc_extend_settings_licenseInfo', '')) != 0) && (strlen(get_site_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix')) != 0)) {
				if ((strpos(get_site_option('ts_vcsc_extend_settings_licenseInfo', ''), get_site_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix')) != FALSE)) {
					update_site_option('ts_vcsc_extend_settings_updateAvailable', 	1);
					$obj                = new stdClass();
					$obj->slug          = $this->slug;
					$obj->new_version   = $remote_version;
					$obj->url           = $this->update_path;
					$obj->package       = $this->update_path;
					$transient->response[$this->plugin_slug] = $obj;
				} else {
					update_site_option('ts_vcsc_extend_settings_updateAvailable', 	0);
				}
				} else {
				update_site_option('ts_vcsc_extend_settings_updateAvailable', 		0);
				}
			} else {
				if ((strlen(get_option('ts_vcsc_extend_settings_licenseInfo', '')) != 0) && (strlen(get_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix')) != 0)) {
				if ((strpos(get_option('ts_vcsc_extend_settings_licenseInfo', ''), get_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix')) != FALSE)) {
					update_option('ts_vcsc_extend_settings_updateAvailable', 		1);
					$obj                = new stdClass();
					$obj->slug          = $this->slug;
					$obj->new_version   = $remote_version;
					$obj->url           = $this->update_path;
					$obj->package       = $this->update_path;
					$transient->response[$this->plugin_slug] = $obj;
				} else {
					update_option('ts_vcsc_extend_settings_updateAvailable', 		0);
				}
				} else {
				update_option('ts_vcsc_extend_settings_updateAvailable', 			0);
				}
			}
			}
			return $transient;
		}
		
		/**
		 * Add our self-hosted description to the filter
		 *
		 * @param boolean $false
		 * @param array $action
		 * @param object $arg
		 * @return bool|object
		 */
		public function check_info($false, $action, $arg) {
			if (isset($arg->slug)) {
				if ($arg->slug === $this->slug) {
					$information = $this->getRemote_information();
					return $information;
				}
			}
			return false;
		}
		
		/**
		 * Return the remote version
		 * @return string $remote_version
		 */
		public function getRemote_version() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			$request = wp_remote_post($this->update_path, array('body' => array('action' => 'version')));
			if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
				return $request['body'];
			}
			return false;
		}
		
		/**
		 * Get information about the remote version
		 * @return bool|object
		 */
		public function getRemote_information() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			$request = wp_remote_post($this->update_path, array('body' => array('action' => 'info')));
			if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
				return unserialize($request['body']);
			}
			return false;
		}
		
		/**
		 * Return the status of the plugin licensing
		 * @return boolean $remote_license
		 */
		public function getRemote_license() {
			$request = wp_remote_post($this->update_path, array('body' => array('action' => 'license')));
			if (!is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200) {
				return $request['body'];
			}
			return false;
		}
    }
?>