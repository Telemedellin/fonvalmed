<?php
	if (!defined('WP_UNINSTALL_PLUGIN')) {
		header('Status: 403 Forbidden');
		header('HTTP/1.1 403 Forbidden');
		exit();
	}
	global $wpdb;
	
	if (!function_exists('TS_VCSC_DeleteOptionsPrefixed')){
		function TS_VCSC_DeleteOptionsPrefixed($prefix) {
			global $wpdb;
			$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '{$prefix}%'" );
		}
	}
	if (!function_exists('TS_VCSC_RemoveCap')){
		function TS_VCSC_RemoveCap() {
			$roles = get_editable_roles();
			foreach ($GLOBALS['wp_roles']->role_objects as $key => $role) {
				if (isset($roles[$key]) && $role->has_cap('ts_vcsc_extend')) {
					$role->remove_cap('ts_vcsc_extend');
				}
			}
		}
	}
	if (!function_exists('TS_VCSC_RemoveDirectory')){
		function TS_VCSC_RemoveDirectory($dir) { 
			if (is_dir($dir)) { 
				$objects = scandir($dir); 
				foreach ($objects as $object) { 
					if ($object != "." && $object != "..") { 
						if (filetype($dir . "/" . $object) == "dir") {
							TS_VCSC_RemoveDirectory($dir . "/" . $object);
						} else {
							unlink($dir . "/" . $object);
						}
					} 
				} 
				reset($objects); 
				rmdir($dir); 
			}
		}
	}
	if (!function_exists('TS_VCSC_DeleteCustomPack')){
		function TS_VCSC_DeleteCustomPack() {
			$dest 					= wp_upload_dir();
			$dest_path 				= $dest['path'];	
			$this_year 				= date('Y');
			$this_month 			= date('m');
			$the_date_string 		= $this_year . '/' . $this_month.'/';
			$customFontPackPath 	= $dest_path . '/ts-vcsc-icons/';
			$newCustomFontPackPath 	= str_replace($the_date_string, '', $customFontPackPath);
			$fileName = 'ts-vcsc-custom-pack.zip';
			$deleteZip = TS_VCSC_RemoveDirectory($newCustomFontPackPath);
			TS_VCSC_RemoveDirectory($newCustomFontPackPath);
		}
	}
	if (!function_exists('TS_VCSC_Delete_Plugin_Settings_Uninstall')){
		function TS_VCSC_Delete_Plugin_Settings_Uninstall() {
			if (get_option('ts_vcsc_extend_settings_retain') != 2) {
				TS_VCSC_DeleteOptionsPrefixed('ts_vcsc_extend_settings_');
				unregister_setting('ts_vcsc_extend_custom_css', 	'ts_vcsc_extend_custom_css', 		'TS_VCSC_CustomCSS_Validation');
				unregister_setting('ts_vcsc_extend_custom_js', 		'ts_vcsc_extend_custom_js', 		'TS_VCSC_CustomJS_Validation');
				delete_option("ts_vcsc_extend_custom_css");
				delete_option("ts_vcsc_extend_custom_js");
				TS_VCSC_RemoveCap();
				TS_VCSC_DeleteCustomPack();
			}
		}
	}
	
	if ((!function_exists('is_user_logged_in')) && (!is_user_logged_in())) {
		wp_die('You must be logged in to run this script.');
	}

	if (!current_user_can('install_plugins')) {
		wp_die('You do not have permission to run this script.');
	}

	
	if (function_exists('is_multisite') && is_multisite()) {
		if ($networkwide) {
			$old_blog 	= $wpdb->blogid;
			$blogids 	= $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
				delete_site_option('ts_vcsc_extend_settings_demo');
				delete_site_option('ts_vcsc_extend_settings_updated');
				delete_site_option('ts_vcsc_extend_settings_created');
				delete_site_option('ts_vcsc_extend_settings_deleted');
				delete_site_option('ts_vcsc_extend_settings_license');
				delete_site_option('ts_vcsc_extend_settings_licenseUpdate');
				delete_site_option('ts_vcsc_extend_settings_licenseInfo');
				delete_site_option('ts_vcsc_extend_settings_licenseKeyed');
				delete_site_option('ts_vcsc_extend_settings_licenseValid');
				delete_site_option('ts_vcsc_extend_settings_versionCurrent');
				delete_site_option('ts_vcsc_extend_settings_versionLatest');
				delete_site_option('ts_vcsc_extend_settings_updateAvailable');
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				TS_VCSC_Delete_Plugin_Settings_Uninstall();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	TS_VCSC_Delete_Plugin_Settings_Uninstall();
?>
