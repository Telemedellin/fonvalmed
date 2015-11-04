<?php
/*
Plugin Name:    Composium - Visual Composer Extensions
Plugin URI:     http://codecanyon.net/item/visual-composer-extensions/7190695
Description:    A plugin to add new premium content elements, custom post types, a fully built-in lightbox solution, icon fonts, Google fonts, and much more to Visual Composer
Author:         Tekanewa Scripts
Author URI:     http://tekanewascripts.com/vcextensions
Version:        4.0.1
Text Domain:    ts_visual_composer_extend
Domain Path:	/locale
*/
if (!defined('ABSPATH')) exit;


// Define Global Variables
// -----------------------
if (!defined('COMPOSIUM_EXTENSIONS')){
	define('COMPOSIUM_EXTENSIONS', 			dirname(__FILE__));
}
if (!defined('COMPOSIUM_VERSION')){
	define('COMPOSIUM_VERSION', 			'4.0.1');
}
if (!defined('COMPOSIUM_SLUG')){
	define('COMPOSIUM_SLUG', 				plugin_basename(__FILE__));
}

// Ensure that Function for Network Activate is Ready
// --------------------------------------------------
if (!function_exists('is_plugin_active_for_network')) {
	require_once(ABSPATH . '/wp-admin/includes/plugin.php');
}


// Functions that need to be available immediately
// -----------------------------------------------
if (!function_exists('TS_VCSC_GetResourceURL')){
	function TS_VCSC_GetResourceURL($relativePath){
		return plugins_url($relativePath, plugin_basename(__FILE__));
	}
}
if (!function_exists('TS_VCSC_WordPressCheckup')) {
	function TS_VCSC_WordPressCheckup($version = '3.8') {
		global $wp_version;		
		if (version_compare($wp_version, $version, '>=')) {
			return "true";
		} else {
			return "false";
		}
	}
}
if (!function_exists('TS_VCSC_IsEditPagePost')){
	function TS_VCSC_IsEditPagePost($new_edit = null){
		global $pagenow, $typenow;
		$frontend = TS_VCSC_CheckFrontEndEditor();
		if (function_exists('vc_is_inline')){
			$vc_is_inline = vc_is_inline();
			if ((vc_is_inline() == false) && (vc_is_inline() != '') && (vc_is_inline() != true) && (!is_admin())) {
				return false;
			} else if ((vc_is_inline() == true) && (vc_is_inline() != '') && (vc_is_inline() != true) && (!is_admin())) {
				return true;
			} else if (((vc_is_inline() == NULL) || (vc_is_inline() == '')) && (!is_admin())) {
				if ($frontend == true) {
					$vc_is_inline = true;
					return true;
				} else {
					$vc_is_inline = false;
					return false;
				}
			}
		} else {
			$vc_is_inline = false;
			if (!is_admin()) return false;
		}
		if (($frontend == true) && (!is_admin())) {
			return true;
		} else if ($new_edit == "edit") {
			return in_array($pagenow, array('post.php'));
		} else if ($new_edit == "new") {
			return in_array($pagenow, array('post-new.php'));
		} else if ($vc_is_inline == true) {
			return true;
		} else {
			return in_array($pagenow, array('post.php', 'post-new.php'));
		}
	}
}
if (!function_exists('TS_VCSC_CheckFrontEndEditor')){
	function TS_VCSC_CheckFrontEndEditor() {
		$url 		= 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		if ((strpos($url, "vc_editable=true") !== false) || (strpos($url, "vc_action=vc_inline") !== false)) {
			return true;
		} else {
			return false;
		}
	}
}
if (!function_exists('TS_VCSC_GetPluginVersion')){
	function TS_VCSC_GetPluginVersion() {
		$plugin_data 		= get_plugin_data( __FILE__ );
		$plugin_version 	= $plugin_data['Version'];
		return $plugin_version;
	}
}
if (!function_exists('TS_VCSC_VersionCompare')){
	function TS_VCSC_VersionCompare($a, $b) {
		//Compare two sets of versions, where major/minor/etc. releases are separated by dots. 
		//Returns 0 if both are equal, 1 if A > B, and -1 if B < A. 
		$a = explode(".", rtrim($a, ".0")); //Split version into pieces and remove trailing .0 
		$b = explode(".", rtrim($b, ".0")); //Split version into pieces and remove trailing .0 
		//Iterate over each piece of A 
		foreach ($a as $depth => $aVal) {
			if (isset($b[$depth])) {
			//If B matches A to this depth, compare the values 
				if ($aVal > $b[$depth]) {
					return 1; //Return A > B
					//break;
				} else if ($aVal < $b[$depth]) {
					return -1; //Return B > A
					//break;
				}
			//An equal result is inconclusive at this point 
			} else  {
				//If B does not match A to this depth, then A comes after B in sort order 
				return 1; //so return A > B
				//break;
			} 
		} 
		//At this point, we know that to the depth that A and B extend to, they are equivalent. 
		//Either the loop ended because A is shorter than B, or both are equal. 
		return (count($a) < count($b)) ? -1 : 0; 
	}
}


// Main Class for Visual Composer Extensions
// -----------------------------------------
if (!class_exists('VISUAL_COMPOSER_EXTENSIONS')) {
	// Register / Remove Plugin Settings on Plugin Activation / Removal
	// ----------------------------------------------------------------
	require_once('assets/ts_vcsc_registrations_plugin.php');
	
	// WordPres Register Hooks
	// -----------------------
	register_activation_hook(__FILE__, 		array('VISUAL_COMPOSER_EXTENSIONS', 	'TS_VCSC_On_Activation'));
	register_deactivation_hook(__FILE__, 	array('VISUAL_COMPOSER_EXTENSIONS', 	'TS_VCSC_On_Deactivation'));
	register_uninstall_hook(__FILE__, 		array('VISUAL_COMPOSER_EXTENSIONS', 	'TS_VCSC_On_Uninstall'));	
	
	// Create Plugin Class
	// -------------------
	class VISUAL_COMPOSER_EXTENSIONS {
		// Functions for Plugin Activation / Deactivation / Uninstall
		// ----------------------------------------------------------
		public static function TS_VCSC_On_Activation($network_wide) {
			if (!isset($wpdb)) $wpdb = $GLOBALS['wpdb'];
			global $wpdb;
			if (!current_user_can('activate_plugins')) {
				return;
			}
			// Check if Plugin has been Activated Before
			if (!get_option('ts_vcsc_extend_settings_envatoInfo')) {
				$memory_required						= 20 * 1024 * 1024;
			} else {
				$memory_required						= 5 * 1024 * 1024;
			}
			$memory_provided							= ini_get('memory_limit');
			$memory_provided 							= preg_replace("/[^0-9]/", "", $memory_provided) * 1024 * 1024;
			$memory_peakusage 							= memory_get_peak_usage(true);
			if (($memory_provided - $memory_peakusage) <= $memory_required) {
				$part1 									= __("Unfortunately, and to prevent a potential system crash, the plugin 'Composium - Visual Composer Extensions' could not be activated. It seems your available PHP memory is already close to exhaustion and so there is not enough left for this plugin.", "ts_visual_composer_extend") . '<br/>';
				$part2 									= __('Available Memory:', 'ts_visual_composer_extend') . '' . ($memory_provided / 1024 / 1024) . 'MB / ' . __('Already Utilized Memory:', 'ts_visual_composer_extend') . '' . ($memory_peakusage / 1024 / 1024) . 'MB / ' . __('Required Memory:', 'ts_visual_composer_extend') . '' . ($memory_required / 1024 / 1024) . 'MB<br/>';
				$part3 									= __('Please contact our', 'ts_visual_composer_extend');
				error_log($part1 . ' ' . $part2, 0);
				trigger_error($part1 . ' ' . $part3 . ' <a href="http://helpdesk.tekanewascripts.com/">' . __('Plugin Support', 'ts_visual_composer_extend') . '</a> for assistance.', E_USER_ERROR);
			} else {				
				if (function_exists('is_multisite') && is_multisite()) {					
					if ($network_wide) {
						// Options for License Data
						add_site_option('ts_vcsc_extend_settings_demo',									1);
						add_site_option('ts_vcsc_extend_settings_updated', 				            	0);
						add_site_option('ts_vcsc_extend_settings_created', 				            	0);
						add_site_option('ts_vcsc_extend_settings_deleted', 				            	0);
						add_site_option('ts_vcsc_extend_settings_license', 				            	'');
						add_site_option('ts_vcsc_extend_settings_licenseUpdate',						0);
						add_site_option('ts_vcsc_extend_settings_licenseInfo',							'');
						add_site_option('ts_vcsc_extend_settings_licenseKeyed',							'emptydelimiterfix');
						add_site_option('ts_vcsc_extend_settings_licenseValid',							0);
						// Options for Update Data
						add_site_option('ts_vcsc_extend_settings_versionCurrent', 				    	'');
						add_site_option('ts_vcsc_extend_settings_versionLatest', 				    	'');
						add_site_option('ts_vcsc_extend_settings_updateAvailable', 				    	0);
						add_site_option('ts_vcsc_extend_settings_notificationCache', 				    '');
						add_site_option('ts_vcsc_extend_settings_notificationLast', 				    '');
						add_site_option('ts_vcsc_extend_settings_notificationTime', 				    43200);
						$old_blog 	= $wpdb->blogid;
						$blogids 	= $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
						foreach ($blogids as $blog_id) {
							switch_to_blog($blog_id);
							TS_VCSC_Set_Plugin_Options();
						}
						switch_to_blog($old_blog);
						return;
					}
				}
				if ((isset($network_wide)) && (!$network_wide)) {
					// Options for License Data
					add_option('ts_vcsc_extend_settings_demo', 					            			1);
					add_option('ts_vcsc_extend_settings_updated', 				            			0);
					add_option('ts_vcsc_extend_settings_created', 				            			0);
					add_option('ts_vcsc_extend_settings_deleted', 				            			0);
					add_option('ts_vcsc_extend_settings_license', 				            			'');
					add_option('ts_vcsc_extend_settings_licenseUpdate',									0);
					add_option('ts_vcsc_extend_settings_licenseInfo',									'');
					add_option('ts_vcsc_extend_settings_licenseKeyed',									'emptydelimiterfix');
					add_option('ts_vcsc_extend_settings_licenseValid',									0);
					// Options for Update Data
					add_option('ts_vcsc_extend_settings_versionCurrent', 				    			'');
					add_option('ts_vcsc_extend_settings_versionLatest', 				    			'');
					add_option('ts_vcsc_extend_settings_updateAvailable', 				    			0);
					add_option('ts_vcsc_extend_settings_notificationCache', 				    		'');
					add_option('ts_vcsc_extend_settings_notificationLast', 				    			'');
					add_option('ts_vcsc_extend_settings_notificationTime', 				    			43200);
				}
				TS_VCSC_Set_Plugin_Options();
				if (!$network_wide) {
					update_option('ts_vcsc_extend_settings_redirect',									1);
				}
			}
		}
		public static function TS_VCSC_On_Deactivation($network_wide) {
			global $wpdb;
			if (!current_user_can( 'activate_plugins')) {
				return;
			}
			if (function_exists('is_multisite') && is_multisite()) {
				if ($network_wide) {
					$old_blog 	= $wpdb->blogid;
					$blogids 	= $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
					foreach ($blogids as $blog_id) {
						switch_to_blog($blog_id);
						$roles = get_editable_roles();
						foreach ($GLOBALS['wp_roles']->role_objects as $key => $role) {
							if (isset($roles[$key]) && $role->has_cap('ts_vcsc_extend')) {
								$role->remove_cap('ts_vcsc_extend');
							}
						}
					}
					switch_to_blog($old_blog);
					return;
				}
			}
			$roles = get_editable_roles();
			foreach ($GLOBALS['wp_roles']->role_objects as $key => $role) {
				if (isset($roles[$key]) && $role->has_cap('ts_vcsc_extend')) {
					$role->remove_cap('ts_vcsc_extend');
				}
			}
		}
		public static function TS_VCSC_On_Uninstall($network_wide) {
			global $wpdb;
			if (!current_user_can( 'activate_plugins')) {
				return;
			}
			if ( __FILE__ != WP_UNINSTALL_PLUGIN) {
				return;
			}
			if (function_exists('is_multisite') && is_multisite()) {
				if ($network_wide) {
					$old_blog 	= $wpdb->blogid;
					$blogids 	= $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
					foreach ($blogids as $blog_id) {
						switch_to_blog($blog_id);
						//array('VISUAL_COMPOSER_EXTENSIONS', 	'TS_VCSC_Delete_Plugin_Options');
						TS_VCSC_Delete_Plugin_Options();
					}
					switch_to_blog($old_blog);
					return;
				}
			}
			//array('VISUAL_COMPOSER_EXTENSIONS', 	'TS_VCSC_Delete_Plugin_Options');
			TS_VCSC_Delete_Plugin_Options();
		}

		public $TS_VCSC_Icons_Compliant_Awesome			= array();
		public $TS_VCSC_Icons_Compliant_Brankic			= array();
		public $TS_VCSC_Icons_Compliant_Countricons		= array();
		public $TS_VCSC_Icons_Compliant_Currencies		= array();
		public $TS_VCSC_Icons_Compliant_Elegant			= array();
		public $TS_VCSC_Icons_Compliant_Entypo			= array();
		public $TS_VCSC_Icons_Compliant_Foundation		= array();
		public $TS_VCSC_Icons_Compliant_Genericons		= array();
		public $TS_VCSC_Icons_Compliant_IcoMoon			= array();
		public $TS_VCSC_Icons_Compliant_Ionicons		= array();
		public $TS_VCSC_Icons_Compliant_Metrize			= array();
		public $TS_VCSC_Icons_Compliant_Monuments		= array();
		public $TS_VCSC_Icons_Compliant_SocialMedia		= array();
		public $TS_VCSC_Icons_Compliant_Themify			= array();
		public $TS_VCSC_Icons_Compliant_Typicons		= array();
		public $TS_VCSC_Icons_Compliant_Dashicons		= array();
		public $TS_VCSC_Icons_Compliant_Custom			= array();
		
		public $TS_VCSC_Icons_Compliant_VC_Awesome		= array();
		public $TS_VCSC_Icons_Compliant_VC_OpenIconic	= array();
		public $TS_VCSC_Icons_Compliant_VC_Linecons		= array();
		public $TS_VCSC_Icons_Compliant_VC_Typicons		= array();
		public $TS_VCSC_Icons_Compliant_VC_Entypo		= array();
		
		public $TS_VCSC_VisualComposer_Version			= '';
		public $TS_VCSC_VisualComposer_Compliant		= 'false';
		public $TS_VCSC_VisualComposer_Posts			= array();
		public $TS_VCSC_PluginIsMultiSiteActive			= 'false';
		public $TS_VCSC_Extensions_PostTypes			= array();
		public $TS_VCSC_Extensions_VariablesPriority	= '6';
		
		public $TS_VCSC_CountTotalElements				= 0;
		public $TS_VCSC_CountActiveElements				= 0;
		
		public $TS_VCSC_tinymceAwesomeCount				= 0;
		public $TS_VCSC_tinymceBrankicCount				= 0;
		public $TS_VCSC_tinymceCountriconsCount			= 0;
		public $TS_VCSC_tinymceCurrenciesCount			= 0;
		public $TS_VCSC_tinymceElegantCount				= 0;
		public $TS_VCSC_tinymceEntypoCount				= 0;
		public $TS_VCSC_tinymceFoundationCount			= 0;
		public $TS_VCSC_tinymceGenericonsCount			= 0;
		public $TS_VCSC_tinymceIcoMoonCount				= 0;
		public $TS_VCSC_tinymceIoniconsCount			= 0;
		public $TS_VCSC_tinymceMetrizeCount				= 0;
		public $TS_VCSC_tinymceMonumentsCount			= 0;
		public $TS_VCSC_tinymceSocialMediaCount			= 0;
		public $TS_VCSC_tinymceThemifyCount				= 0;
		public $TS_VCSC_tinymceTypiconsCount			= 0;
		public $TS_VCSC_tinymceCustomCount				= 0;
		public $TS_VCSC_tinymceDashiconsCount			= 0;
		
		public $TS_VCSC_tinymceVC_AwesomeCount			= '';
		public $TS_VCSC_tinymceVC_OpenIconicCount		= '';
		public $TS_VCSC_tinymceVC_LineconsCount			= '';
		public $TS_VCSC_tinymceVC_TypiconsCount			= '';
		public $TS_VCSC_tinymceVC_EntypoCount			= '';
		
		public $TS_VCSC_LoadFrontEndForcable			= "false";
		public $TS_VCSC_LoadFrontEndJQuery				= "false";
		public $TS_VCSC_LoadFrontEndWaypoints			= "true";
		public $TS_VCSC_LoadFrontEndModernizr			= "true";
		public $TS_VCSC_LoadFrontEndCountTo				= "true";
		public $TS_VCSC_LoadFrontEndCountUp				= "true";
		public $TS_VCSC_LoadFrontEndMooTools			= "true";
		public $TS_VCSC_LoadFrontEndLightbox			= "false";
		public $TS_VCSC_LoadFrontEndTooltips			= "false";
		
		public $TS_VCSC_CustomPostTypesPositions		= "";
		public $TS_VCSC_CustomPostTypesWidgets			= "false";
		public $TS_VCSC_CustomPostTypesCheckup			= "true";
		public $TS_VCSC_CustomPostTypesClass			= "";
		public $TS_VCSC_CustomPostTypesInternal			= "true";
		public $TS_VCSC_CustomPostTypesLoaded			= "false";
		public $TS_VCSC_CustomPostTypesTeam				= "false";
		public $TS_VCSC_CustomPostTypesTestimonial		= "false";
		public $TS_VCSC_CustomPostTypesLogo				= "false";
		public $TS_VCSC_CustomPostTypesSkillset			= "false";
		public $TS_VCSC_CustomPostTypesTimeline			= "false";
		
		public $TS_VCSC_UserDeviceType					= "Desktop";
		public $TS_VCSC_PluginUsage						= "true";
		public $TS_VCSC_PluginLicense					= "";
		public $TS_VCSC_VCFrontEditMode					= "false";
		public $TS_VCSC_WooCommerceActive				= "false";
		public $TS_VCSC_WooCommerceRemove				= "false";
		public $TS_VCSC_WooCommerceVersion				= "";
		public $TS_VCSC_bbPressActive					= "false";
		public $TS_VCSC_bbPressVersion					= "";
		public $TS_VCSC_IconicumStandard				= "false";
		public $TS_VCSC_IconicumActivated				= "false";
		public $TS_VCSC_IconicumMenuGenerator			= "false";
		
		public $TS_VCSC_EditorFullWidthInternal			= "false";
		public $TS_VCSC_EditorIconFontsInternal			= "false";
		public $TS_VCSC_EditorLivePreview				= "false";
		public $TS_VCSC_EditorImagePreview				= "true";
		public $TS_VCSC_EditorBackgroundIndicator		= "true";
		public $TS_VCSC_EditorVisualSelector			= "true";
		public $TS_VCSC_EditorNativeSelector			= "true";
		public $TS_VCSC_EditorFrontEndEnabled			= "true";
		
		public $TS_VCSC_UseInternalLightbox				= "true";
		public $TS_VCSC_UseGoogleFontManager			= "true";
		public $TS_VCSC_UsePageNavigator				= "false";
		public $TS_VCSC_UseSmoothScroll					= "false";
		public $TS_VCSC_UseCodeEditors					= "true";
		public $TS_VCSC_UseEnlighterJS					= "false";
		public $TS_VCSC_UseThemeBuider					= "false";
		
		public $TS_VCSC_IconSelectorType				= '';
		public $TS_VCSC_IconSelectorValue				= array();
		public $TS_VCSC_IconSelectorSource				= array();
		public $TS_VCSC_IconSelectorString				= '';
		public $TS_VCSC_IconSelectorPager				= "200";
		
		public $TS_VCSC_PluginSlug						= "";
		public $TS_VCSC_PluginPath						= "";
		public $TS_VCSC_PluginDir						= "";
		
		function __construct() {
			$this->assets_js 							= plugin_dir_path( __FILE__ ) . 'js/';
			$this->assets_css 							= plugin_dir_path( __FILE__ ) . 'css/';
			$this->assets_dir 							= plugin_dir_path( __FILE__ ) . 'assets/';
			$this->classes_dir 							= plugin_dir_path( __FILE__ ) . 'classes/';
			$this->elements_dir 						= plugin_dir_path( __FILE__ ) . 'elements/';
			$this->shortcode_dir 						= plugin_dir_path( __FILE__ ) . 'shortcodes/';
			$this->plugins_dir 							= plugin_dir_path( __FILE__ ) . 'plugins/';
			$this->woocommerce_dir 						= plugin_dir_path( __FILE__ ) . 'woocommerce/';
			$this->bbpress_dir 							= plugin_dir_path( __FILE__ ) . 'bbpress/';
			$this->posttypes_dir 						= plugin_dir_path( __FILE__ ) . 'posttypes/';
			$this->images_dir 							= plugin_dir_path( __FILE__ ) . 'images/';
			$this->icons_dir 							= plugin_dir_path( __FILE__ ) . 'icons/';
			$this->detector_dir  						= plugin_dir_path( __FILE__ ) . 'detector/';
			$this->parameters_dir 						= plugin_dir_path( __FILE__ ) . 'parameters/';
			$this->widgets_dir 							= plugin_dir_path( __FILE__ ) . 'widgets/';
			$this->templates_dir 						= plugin_dir_path( __FILE__ ) . 'templates/';
			
			$this->TS_VCSC_PluginSlug					= plugin_basename(__FILE__);
			$this->TS_VCSC_PluginPath					= plugin_dir_url(__FILE__);
			$this->TS_VCSC_PluginDir 					= plugin_dir_path( __FILE__ );
			
			// Check and Store VC Version, Applicable Post Types and Icon Picker
			// -----------------------------------------------------------------
			if (function_exists('vc_editor_post_types')){
				$this->TS_VCSC_VisualComposer_Posts 			= vc_editor_post_types();
			}
			if (defined('WPB_VC_VERSION')){
				$this->TS_VCSC_VisualComposer_Version 			= WPB_VC_VERSION;
				if (TS_VCSC_VersionCompare(WPB_VC_VERSION, '4.3.0') >= 0) {
					if (get_option('ts_vcsc_extend_settings_backendPreview', 1) == 1) {
						$this->TS_VCSC_EditorLivePreview		= "true";
					} else {
						$this->TS_VCSC_EditorLivePreview		= "false";
					}
				} else {
					$this->TS_VCSC_EditorLivePreview			= "false";
				}
				if (TS_VCSC_VersionCompare(WPB_VC_VERSION, '4.4.0') >= 0) {
					$this->TS_VCSC_EditorIconFontsInternal		= "true";
					$this->TS_VCSC_VisualComposer_Compliant		= "true";
					$this->TS_VCSC_EditorFullWidthInternal		= "true";
				} else {
					$this->TS_VCSC_EditorIconFontsInternal		= "false";
					$this->TS_VCSC_VisualComposer_Compliant		= "false";
					$this->TS_VCSC_EditorFullWidthInternal		= "false";
				}
			} else {
				$this->TS_VCSC_EditorLivePreview				= "false";
				$this->TS_VCSC_EditorIconFontsInternal			= "false";
				$this->TS_VCSC_VisualComposer_Compliant			= "false";
				$this->TS_VCSC_EditorFullWidthInternal			= "false";
			}
			
			// Check and Set other Global Variables
			// ------------------------------------
			// Check if All Files should be loaded
			if (get_option('ts_vcsc_extend_settings_loadForcable', 0) == 0) 	        { $this->TS_VCSC_LoadFrontEndForcable = "false"; } 			else { $this->TS_VCSC_LoadFrontEndForcable = "true"; }
			// Check if Waypoints should be loaded
			if (get_option('ts_vcsc_extend_settings_loadWaypoints', 1) == 1) 	        { $this->TS_VCSC_LoadFrontEndWaypoints = "true"; } 			else { $this->TS_VCSC_LoadFrontEndWaypoints = "false"; }
			// Check if Modernizr should be loaded
			if (get_option('ts_vcsc_extend_settings_loadModernizr', 1) == 1) 	        { $this->TS_VCSC_LoadFrontEndModernizr = "true"; } 			else { $this->TS_VCSC_LoadFrontEndModernizr = "false"; }
			// Check if CountTo should be loaded
			if (get_option('ts_vcsc_extend_settings_loadCountTo', 1) == 1) 		        { $this->TS_VCSC_LoadFrontEndCountTo = "true"; }			else { $this->TS_VCSC_LoadFrontEndCountTo = "false"; }
			// Check if CountUp should be loaded
			if (get_option('ts_vcsc_extend_settings_loadCountUp', 1) == 1) 		        { $this->TS_VCSC_LoadFrontEndCountUp = "true"; }			else { $this->TS_VCSC_LoadFrontEndCountUp = "false"; }
			// Check if MooTools should be loaded
			if (get_option('ts_vcsc_extend_settings_loadMooTools', 1) == 1)				{ $this->TS_VCSC_LoadFrontEndMooTools = "true"; }			else { $this->TS_VCSC_LoadFrontEndMooTools = "false"; }
			// Check if Lightbox should be loaded
			if (get_option('ts_vcsc_extend_settings_loadLightbox', 0) == 1) 	        { $this->TS_VCSC_LoadFrontEndLightbox = "true"; } 			else { $this->TS_VCSC_LoadFrontEndLightbox = "false"; }
			// Check if Tooltips should be loaded
			if (get_option('ts_vcsc_extend_settings_loadTooltip', 0) == 1) 		        { $this->TS_VCSC_LoadFrontEndTooltips = "true"; } 			else { $this->TS_VCSC_LoadFrontEndTooltips = "false"; }
			// Check if ForceLoad of jQuery
			if (get_option('ts_vcsc_extend_settings_loadjQuery', 0) == 1) 		        { $this->TS_VCSC_LoadFrontEndJQuery = "true"; }				else { $this->TS_VCSC_LoadFrontEndJQuery = "false"; }
			// Check for Editor Image Preview
			if (get_option('ts_vcsc_extend_settings_previewImages', 1) == 1)	        { $this->TS_VCSC_EditorImagePreview = "true"; }				else { $this->TS_VCSC_EditorImagePreview = "false"; }
			// Check for Background Indicator
			if (get_option('ts_vcsc_extend_settings_backgroundIndicator', 1) == 1)	    { $this->TS_VCSC_EditorBackgroundIndicator = "true"; }		else { $this->TS_VCSC_EditorBackgroundIndicator = "false"; }   
			// Check for Visual Icon Selector
			if (get_option('ts_vcsc_extend_settings_visualSelector', 1) == 1)	        { $this->TS_VCSC_EditorVisualSelector = "true"; } 			else { $this->TS_VCSC_EditorVisualSelector = "false"; }
			// Check for Native Icon Selector
			if (get_option('ts_vcsc_extend_settings_nativeSelector', 1) == 1)	        { $this->TS_VCSC_EditorNativeSelector = "true"; } 			else { $this->TS_VCSC_EditorNativeSelector = "false"; }
			// Check for Built-In Lightbox
			if (get_option('ts_vcsc_extend_settings_builtinLightbox', 1) == 1)	        { $this->TS_VCSC_UseInternalLightbox = "true"; } 			else { $this->TS_VCSC_UseInternalLightbox = "false"; }
			// Google Font Manager
			if (get_option('ts_vcsc_extend_settings_allowGoogleManager', 1) == 1)		{ $this->TS_VCSC_UseGoogleFontManager = "true"; } 			else { $this->TS_VCSC_UseGoogleFontManager = "false"; }
			// Single Page Navigator Builder
			if (get_option('ts_vcsc_extend_settings_allowPageNavigator', 0) == 1)		{ $this->TS_VCSC_UsePageNavigator = "true"; } 				else { $this->TS_VCSC_UsePageNavigator = "false"; }
			// SmoothScroll Activation
			if (get_option('ts_vcsc_extend_settings_additionsSmoothScroll', 0) == 1)	{ $this->TS_VCSC_UseSmoothScroll = "true"; } 				else { $this->TS_VCSC_UseSmoothScroll = "false"; }
			// Provide Code Editors
			if (get_option('ts_vcsc_extend_settings_codeeditors', 1) == 1)				{ $this->TS_VCSC_UseCodeEditors = "true"; }					else { $this->TS_VCSC_UseCodeEditors = "false"; }
			// Enlighter JS
			if (get_option('ts_vcsc_extend_settings_allowEnlighterJS', 0) == 1)			{ $this->TS_VCSC_UseEnlighterJS = "true"; } 				else { $this->TS_VCSC_UseEnlighterJS = "false"; }
			// ThemeBuilder
			if ($this->TS_VCSC_UseEnlighterJS == "true") {
				if (get_option('ts_vcsc_extend_settings_allowThemeBuilder', 0) == 1)	{ $this->TS_VCSC_UseThemeBuider = "true"; } 				else { $this->TS_VCSC_UseThemeBuider = "false"; }
			} else {
				$this->TS_VCSC_UseThemeBuider = "false";
			}
			
			// Define Output Priority for JS Variables
			$this->TS_VCSC_Extensions_VariablesPriority = get_option('ts_vcsc_extend_settings_variablesPriority', '6');
			
			// Load Public Arrays that Define Element Settings
			// -----------------------------------------------
			require_once($this->assets_dir . 'ts_vcsc_arrays_public.php');
			
			// Load Arrays of Other Selection Items and Variables
			// --------------------------------------------------
			require_once($this->assets_dir . 'ts_vcsc_arrays_other.php');
			require_once($this->assets_dir . 'ts_vcsc_arrays_fonts.php');			
			
			// Define Menu Position for Post Types
			$this->TS_VCSC_CustomPostTypesPositions		= get_option('ts_vcsc_extend_settings_menuPositions', $this->TS_VCSC_Menu_Positions_Defaults);
			
			$this->TS_VCSC_PluginIsMultiSiteActive 		= (is_plugin_active_for_network(COMPOSIUM_SLUG) == true ? "true" : "false");			
			//ksort($this->TS_VCSC_Visual_Composer_Elements);			
			
			// EnlighterJS - Syntax Highlighter
			// --------------------------------
			if ($this->TS_VCSC_UseEnlighterJS == "true") {
				require_once($this->assets_dir . 'ts_vcsc_registrations_enlighterjs.php');
			}
			
			// Status of WooCommerce Elements
			// ------------------------------
			if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
				$this->TS_VCSC_WooCommerceVersion 			= $this->TS_VCSC_WooCommerceVersion();
				$this->TS_VCSC_WooCommerceActive 			= "true";				
				if (defined('WPB_VC_VERSION')){
					if (TS_VCSC_VersionCompare(WPB_VC_VERSION, '4.4.0') >= 0) {
						$this->TS_VCSC_WooCommerceRemove 	= "true";
					} else {
						$this->TS_VCSC_WooCommerceRemove 	= "false";
					}
				} else {
					$this->TS_VCSC_WooCommerceRemove 		= "false";
				}
				
			} else {
				$this->TS_VCSC_WooCommerceVersion 			= "";
				$this->TS_VCSC_WooCommerceActive 			= "false";
				$this->TS_VCSC_WooCommerceRemove 			= "false";
			}
			
			// Status of bbPress Elements
			// --------------------------
			if (in_array('bbpress/bbpress.php', apply_filters('active_plugins', get_option('active_plugins')))) {
				$this->TS_VCSC_bbPressVersion 			= "";
				$this->TS_VCSC_bbPressActive 			= "true";
			} else {
				$this->TS_VCSC_bbPressVersion 			= "";
				$this->TS_VCSC_bbPressActive 			= "false";
			}
			
			// Check for Standalone Iconicum Plugin
			// ------------------------------------
			if ((in_array('ts-iconicum-icon-fonts/ts-iconicum-icon-fonts.php', apply_filters('active_plugins', get_option('active_plugins')))) || (class_exists('ICONICUM_ICON_FONTS'))) {
				$this->TS_VCSC_IconicumStandard			= "true";
			} else {
				$this->TS_VCSC_IconicumStandard			= "false";
			}
			
			// Other Routine Checks
			// --------------------
			if ($this->TS_VCSC_PluginIsMultiSiteActive == "true") {
				$this->TS_VCSC_PluginLicense			= get_site_option('ts_vcsc_extend_settings_license', '');
			} else {
				$this->TS_VCSC_PluginLicense			= get_option('ts_vcsc_extend_settings_license', '');
			}
			if (($this->TS_VCSC_PluginLicense != '') && (in_array(base64_encode($this->TS_VCSC_PluginLicense), $this->TS_VCSC_Avoid_Duplications))) {
				$this->TS_VCSC_PluginUsage				= "false";
			} else {
				$this->TS_VCSC_PluginUsage				= "true";
			}
			if ($this->TS_VCSC_PluginUsage == "false") {
				if ($this->TS_VCSC_PluginIsMultiSiteActive == "true") {
					//update_site_option('ts_vcsc_extend_settings_license', '');
					update_site_option('ts_vcsc_extend_settings_demo', 1);
					update_site_option('ts_vcsc_extend_settings_licenseInfo', '');
					update_site_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix');
					update_site_option('ts_vcsc_extend_settings_licenseValid', 0);
				} else {
					//update_option('ts_vcsc_extend_settings_license', '');
					update_option('ts_vcsc_extend_settings_demo', 1);
					update_option('ts_vcsc_extend_settings_licenseInfo', '');
					update_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix');
					update_option('ts_vcsc_extend_settings_licenseValid', 0);
				}
			}
			
			// Load Icon Shortcode Generator
			// -----------------------------
			// Submenu Generator
			if ($this->TS_VCSC_PluginIsMultiSiteActive == "true") {
				if ((((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_iconicum', 1) == 1) && (get_option('ts_vcsc_extend_settings_useMenuGenerator', 0) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 0) && (get_option('ts_vcsc_extend_settings_useMenuGenerator', 0) == 1) && (get_site_option('ts_vcsc_extend_settings_demo', 1) == 0))) && ($this->TS_VCSC_PluginUsage == 'true')) {
					$this->TS_VCSC_IconicumMenuGenerator 	= "true";
				} else {
					$this->TS_VCSC_IconicumMenuGenerator 	= "false";
				}
			} else {
				if ((((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_iconicum', 1) == 1) && (get_option('ts_vcsc_extend_settings_useMenuGenerator', 0) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 0) && (get_option('ts_vcsc_extend_settings_useMenuGenerator', 0) == 1) && (get_option('ts_vcsc_extend_settings_demo', 1) == 0))) && ($this->TS_VCSC_PluginUsage == 'true')) {
					$this->TS_VCSC_IconicumMenuGenerator 	= "true";
				} else {
					$this->TS_VCSC_IconicumMenuGenerator 	= "false";
				}
			}
			// tinyMCE Editor Generator
			if ($this->TS_VCSC_PluginIsMultiSiteActive == "true") {
				if ((((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_iconicum', 1) == 1) && (get_option('ts_vcsc_extend_settings_useIconGenerator', 0) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 0) && (get_option('ts_vcsc_extend_settings_useIconGenerator', 0) == 1) && (get_site_option('ts_vcsc_extend_settings_demo', 1) == 0))) && ($this->TS_VCSC_PluginUsage == 'true')) {
					$this->TS_VCSC_IconicumActivated 	= "true";
				} else {
					$this->TS_VCSC_IconicumActivated 	= "false";
				}
			} else {
				if ((((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_iconicum', 1) == 1) && (get_option('ts_vcsc_extend_settings_useIconGenerator', 0) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 0) && (get_option('ts_vcsc_extend_settings_useIconGenerator', 0) == 1) && (get_option('ts_vcsc_extend_settings_demo', 1) == 0))) && ($this->TS_VCSC_PluginUsage == 'true')) {
					$this->TS_VCSC_IconicumActivated 	= "true";
				} else {
					$this->TS_VCSC_IconicumActivated 	= "false";
				}
			}
			if ($this->TS_VCSC_IconicumStandard == "false") {
				if ($this->TS_VCSC_IconicumActivated == "true") {					
					require_once($this->assets_dir . 'ts_vcsc_editor_button.php');
				}
			}
			
			// Load and Initialize the Auto-Update Class
			// -----------------------------------------
			if (get_option('ts_vcsc_extend_settings_allowNotification', 1) == 1) {
				require_once($this->assets_dir . 'ts_vcsc_notification.php');
			}
			if (get_option('ts_vcsc_extend_settings_allowAutoUpdate', 1) == 1) {
				if ($this->TS_VCSC_PluginUsage == "true") {
					if ($this->TS_VCSC_PluginIsMultiSiteActive == "true") {
						if ((get_site_option('ts_vcsc_extend_settings_demo', 1) == 0) && (get_option('ts_vcsc_extend_settings_extended', 0) == 0) && ((strpos(get_site_option('ts_vcsc_extend_settings_licenseInfo', ''), get_site_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix')) != FALSE))) {
							add_action('admin_init', 		array($this, 'TS_VCSC_ActivateAutoUpdate'));
						}
					} else {
						if ((get_option('ts_vcsc_extend_settings_demo', 1) == 0) && (get_option('ts_vcsc_extend_settings_extended', 0) == 0) && ((strpos(get_option('ts_vcsc_extend_settings_licenseInfo', ''), get_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix')) != FALSE))) {
							add_action('admin_init', 		array($this, 'TS_VCSC_ActivateAutoUpdate'));
						}
					}
				}
			}

			// Load Arrays of Font Settings
			// ----------------------------
			add_action('init', 							array($this, 	'TS_VCSC_IconFontArrays'), 					1);
			
			// Load Language / Translation Files
			// ---------------------------------
			if (get_option('ts_vcsc_extend_settings_translationsDomain', 1) == 1) {
				add_action('init',						array($this, 	'TS_VCSC_LoadTextDomains'), 				9);
			}
			
			$plugin = plugin_basename( __FILE__ );
			add_filter("plugin_action_links_$plugin", 	array($this, 	"TS_VCSC_PluginAddSettingsLink"));
			if ($this->TS_VCSC_PluginIsMultiSiteActive == "true") {
				if (((get_site_option('ts_vcsc_extend_settings_licenseValid', 0) == 1) && ((strpos(get_site_option('ts_vcsc_extend_settings_licenseInfo', ''), get_site_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix')) != FALSE))) || (get_option('ts_vcsc_extend_settings_extended', 0) == 1)) {
					update_site_option('ts_vcsc_extend_settings_demo', 	0);
				} else {
					update_site_option('ts_vcsc_extend_settings_demo', 	1);
				}
			} else {
				if (((get_option('ts_vcsc_extend_settings_licenseValid', 0) == 1) && ((strpos(get_option('ts_vcsc_extend_settings_licenseInfo', ''), get_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix')) != FALSE))) || (get_option('ts_vcsc_extend_settings_extended', 0) == 1)) {
					update_option('ts_vcsc_extend_settings_demo', 		0);
				} else {
					update_option('ts_vcsc_extend_settings_demo', 		1);
				}
			}
			
			// Register Custom CSS and JS Inputs
			// ---------------------------------
			if ($this->TS_VCSC_UseCodeEditors == "true") {
				add_action('admin_init', 				array($this, 	'TS_VCSC_RegisterCustomCSS_Setting'));
				add_action('admin_init', 				array($this, 	'TS_VCSC_RegisterCustomJS_Setting'));
			}
			
			// Function to Register / Load External Files on Back-End
			// ------------------------------------------------------
			add_action('admin_enqueue_scripts', 		array($this, 	'TS_VCSC_Extensions_Admin_Files'),			999999999);
			add_action('admin_head', 					array($this, 	'TS_VCSC_Extensions_Admin_Variables'),		999999999);
			add_action('admin_head', 					array($this, 	'TS_VCSC_Extensions_Admin_Head'),			999999999);
			
			// Function to Register / Load External Files on Front-End
			// -------------------------------------------------------
			add_action('wp_enqueue_scripts', 			array($this, 	'TS_VCSC_Extensions_Front_Main'), 			999999999);
			add_action('wp_head', 						array($this, 	'TS_VCSC_Extensions_Front_Variables'), 		$this->TS_VCSC_Extensions_VariablesPriority);
			add_action('wp_head', 						array($this, 	'TS_VCSC_Extensions_Front_Head'), 			8888);
			add_action('wp_footer', 					array($this, 	'TS_VCSC_Extensions_Front_Footer'), 		8888);
			
			// Add Dashboard Widget
			// --------------------
			if (get_option('ts_vcsc_extend_settings_dashboard', 1) == 1) {
				add_action('wp_dashboard_setup', 		array($this, 	'TS_VCSC_DashboardHelpWidget'));
			}			
			
			// Create Custom Post Types
			// ------------------------
			if ((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypes', 1) == 1)) {
				if ((get_option('ts_vcsc_extend_settings_posttypeWidget', 1) == 0) && (get_option('ts_vcsc_extend_settings_posttypeTeam', 1) == 0) && (get_option('ts_vcsc_extend_settings_posttypeTestimonial', 1) == 0) && (get_option('ts_vcsc_extend_settings_posttypeLogo', 1) == 0) && (get_option('ts_vcsc_extend_settings_posttypeSkillset', 1) == 0) && (get_option('ts_vcsc_extend_settings_posttypeTimeline', 1) == 0)) {
					update_option('ts_vcsc_extend_settings_posttypes', 0);
				}
			}
			if ((((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypes', 1) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 0))) && ($this->TS_VCSC_PluginUsage == "true")) {
				$this->TS_VCSC_CustomPostTypesCheckup																= "true";
				if (((get_option('ts_vcsc_extend_settings_extended', 0) == 0) && (get_option('ts_vcsc_extend_settings_customWidgets', 0) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypeWidget', 1) == 1)  && (get_option('ts_vcsc_extend_settings_customWidgets', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypes', 1) == 1))) {
					$this->TS_VCSC_CustomPostTypesWidgets 															= "true";
					$this->TS_VCSC_Extensions_PostTypes['Widgets'] 													= 1;
				} else {
					$this->TS_VCSC_CustomPostTypesWidgets 															= "false";
					$this->TS_VCSC_Extensions_PostTypes['Widgets'] 													= 0;
				}
				if (((get_option('ts_vcsc_extend_settings_extended', 0) == 0) && (get_option('ts_vcsc_extend_settings_customTeam', 0) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypeTeam', 1) == 1)  && (get_option('ts_vcsc_extend_settings_customTeam', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypes', 1) == 1))) {
					$this->TS_VCSC_CustomPostTypesTeam 																= "true";
					$this->TS_VCSC_Extensions_PostTypes['Teams'] 													= 1;
				} else {
					$this->TS_VCSC_CustomPostTypesTeam 																= "false";
					$this->TS_VCSC_Extensions_PostTypes['Teams'] 													= 0;
				}
				if (((get_option('ts_vcsc_extend_settings_extended', 0) == 0) && (get_option('ts_vcsc_extend_settings_customTestimonial', 0) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypeTestimonial', 1) == 1) && (get_option('ts_vcsc_extend_settings_customTestimonial', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypes', 1) == 1))) {
					$this->TS_VCSC_CustomPostTypesTestimonial 														= "true";
					$this->TS_VCSC_Extensions_PostTypes['Testimonials'] 											= 1;
				} else {
					$this->TS_VCSC_CustomPostTypesTestimonial 														= "false";
					$this->TS_VCSC_Extensions_PostTypes['Testimonials'] 											= 0;
				}
				if (((get_option('ts_vcsc_extend_settings_extended', 0) == 0) && (get_option('ts_vcsc_extend_settings_customLogo', 0) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypeLogo', 1) == 1) && (get_option('ts_vcsc_extend_settings_customLogo', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypes', 1) == 1))) {
					$this->TS_VCSC_CustomPostTypesLogo 																= "true";
					$this->TS_VCSC_Extensions_PostTypes['Logos'] 													= 1;
				} else {
					$this->TS_VCSC_CustomPostTypesLogo 																= "false";
					$this->TS_VCSC_Extensions_PostTypes['Logos'] 													= 0;
				}
				if (((get_option('ts_vcsc_extend_settings_extended', 0) == 0) && (get_option('ts_vcsc_extend_settings_customSkillset', 0) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypeSkillset', 1) == 1) && (get_option('ts_vcsc_extend_settings_customSkillset', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypes', 1) == 1))) {
					$this->TS_VCSC_CustomPostTypesSkillset 															= "true";
					$this->TS_VCSC_Extensions_PostTypes['Skillsets'] 												= 1;
				} else {
					$this->TS_VCSC_CustomPostTypesSkillset 															= "false";
					$this->TS_VCSC_Extensions_PostTypes['Skillsets'] 												= 0;
				}
				if (((get_option('ts_vcsc_extend_settings_extended', 0) == 0) && (get_option('ts_vcsc_extend_settings_customTimelines', 0) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypeTimeline', 1) == 1) && (get_option('ts_vcsc_extend_settings_customTimelines', 0) == 1) && (get_option('ts_vcsc_extend_settings_posttypes', 1) == 1))) {
					$this->TS_VCSC_CustomPostTypesTimeline 															= "true";
					$this->TS_VCSC_Extensions_PostTypes['Timelines'] 												= 1;
				} else {
					$this->TS_VCSC_CustomPostTypesTimeline 															= "false";
					$this->TS_VCSC_Extensions_PostTypes['Timelines'] 												= 0;
				}				
			} else {
				$this->TS_VCSC_CustomPostTypesWidgets 																= "false";
				$this->TS_VCSC_CustomPostTypesCheckup																= "false";
				$this->TS_VCSC_CustomPostTypesTeam 																	= "false";
				$this->TS_VCSC_CustomPostTypesTestimonial 															= "false";
				$this->TS_VCSC_CustomPostTypesLogo 																	= "false";
				$this->TS_VCSC_CustomPostTypesSkillset 																= "false";
				$this->TS_VCSC_CustomPostTypesTimeline 																= "false";
				$this->TS_VCSC_Extensions_PostTypes['Widgets'] 														= 0;
				$this->TS_VCSC_Extensions_PostTypes['Teams'] 														= 0;
				$this->TS_VCSC_Extensions_PostTypes['Testimonials'] 												= 0;
				$this->TS_VCSC_Extensions_PostTypes['Skillsets'] 													= 0;
				$this->TS_VCSC_Extensions_PostTypes['Logos'] 														= 0;
				$this->TS_VCSC_Extensions_PostTypes['Timelines'] 													= 0;
			}
			if (($this->TS_VCSC_CustomPostTypesWidgets == "true") || ($this->TS_VCSC_CustomPostTypesTeam == "true") || ($this->TS_VCSC_CustomPostTypesTestimonial == "true") || ($this->TS_VCSC_CustomPostTypesLogo == "true") || ($this->TS_VCSC_CustomPostTypesSkillset == "true") || ($this->TS_VCSC_CustomPostTypesTimeline == "true")) {
				require_once($this->posttypes_dir.'ts_vcsc_custom_post_registration.php');
				$this->TS_VCSC_CustomPostTypesLoaded																= "true";
				if (($this->TS_VCSC_CustomPostTypesTeam == "true") || ($this->TS_VCSC_CustomPostTypesTestimonial == "true") || ($this->TS_VCSC_CustomPostTypesLogo == "true") || ($this->TS_VCSC_CustomPostTypesSkillset == "true") || ($this->TS_VCSC_CustomPostTypesTimeline == "true")) {
					add_action('init', 							'TS_VCSC_CMBMetaBoxes', 							7777777777);
				}
				if ($this->TS_VCSC_CustomPostTypesWidgets == "true") {
					require_once($this->posttypes_dir . 'ts_vcsc_custom_post_elements.php');
					require_once($this->widgets_dir . 'ts_vcsc_widgets_elements.php');
					add_action('admin_menu', 					array($this, 'TS_VCSC_Remove_MetaBoxes_Widgets'));					
				}
				if ($this->TS_VCSC_CustomPostTypesTeam == "true") {
					require_once($this->posttypes_dir . 'ts_vcsc_custom_post_team.php');
					add_action('admin_menu', 					array($this, 'TS_VCSC_Remove_MetaBoxes_Teams'));
				}
				if ($this->TS_VCSC_CustomPostTypesTestimonial == "true") {
					require_once($this->posttypes_dir . 'ts_vcsc_custom_post_testimonials.php');
					add_action('admin_menu', 					array($this, 'TS_VCSC_Remove_MetaBoxes_Testimonials'));
				}
				if ($this->TS_VCSC_CustomPostTypesSkillset == "true") {
					require_once($this->posttypes_dir . 'ts_vcsc_custom_post_skillsets.php');
					add_action('admin_menu', 					array($this, 'TS_VCSC_Remove_MetaBoxes_Skillsets'));
				}
				if ($this->TS_VCSC_CustomPostTypesTimeline == "true") {
					require_once($this->posttypes_dir . 'ts_vcsc_custom_post_timeline.php');
					add_action('admin_menu', 					array($this, 'TS_VCSC_Remove_MetaBoxes_Timeline'));
				}
				if ($this->TS_VCSC_CustomPostTypesLogo == "true") {
					require_once($this->posttypes_dir . 'ts_vcsc_custom_post_logos.php');
					add_action('admin_menu', 					array($this, 'TS_VCSC_Remove_MetaBoxes_Logos'));
				}
			}
			
			// Create Custom Admin Menu for Plugin
			// -----------------------------------
			require_once($this->assets_dir . 'ts_vcsc_registrations_menu.php');			
			
			// Load Shortcode Definitions
			// --------------------------
			add_action('init', 							array($this, 	'TS_VCSC_RegisterAllShortcodes'), 			888888888);
			//add_action('vc_before_init', 				array($this, 	'TS_VCSC_RegisterAllShortcodes'), 			888888888);
			
			// Load Composer Elements
			// ----------------------
			add_action('init',							array($this, 	'TS_VCSC_RegisterWithComposer'), 			999999999);
			//add_action('after_setup_theme',			array($this,	'TS_VCSC_RegisterWithComposer'));
			//add_action('vc_before_init',				array($this, 	'TS_VCSC_RegisterWithComposer'), 			999999999);

			add_action('admin_init',					array($this, 	'TS_VCSC_ChangeDownloadsUploadDirectory'), 	999);
			add_action('admin_notices',					array($this, 	'TS_VCSC_CustomPackInstalledError'));
			add_action('wp_ajax_ts_delete_custom_pack',	array($this, 	'TS_VCSC_DeleteCustomPack_Ajax'));			
			add_action('wp_ajax_ts_savepostmetadata',	array($this, 	'TS_VCSC_SavePostMetaData'));
			add_action('wp_ajax_ts_system_download', 	array($this, 	'TS_VCSC_DownloadSystemInfoData'));
			add_action('wp_ajax_ts_export_settings', 	array($this, 	'TS_VCSC_ExportPluginSettings'));
			
			// Allow Shortcodes in Widgets / Sidebar
			// -------------------------------------
			add_filter('widget_text', 'do_shortcode');
			
			// Enable / Disable VC Frontend Editor
			// -----------------------------------
			if ((function_exists('vc_enabled_frontend')) && (function_exists('vc_disable_frontend'))) {
				if (get_option('ts_vcsc_extend_settings_frontendEditor', 1) == 0) {
					vc_disable_frontend(true);
				} else if (get_option('ts_vcsc_extend_settings_frontendEditor', 1) == 1) {
					vc_disable_frontend(false);
				}
			}
			
			// Redirect to "About Composium" Page After Activation
			// ---------------------------------------------------
			if ($this->TS_VCSC_PluginIsMultiSiteActive == "false") {
				add_action('admin_init',				array($this, 	'TS_VCSC_ActivationRedirect'), 				1);
			}
			
			// Lightbox Media Integrations
			// ---------------------------
			if ((get_option('ts_vcsc_extend_settings_lightboxIntegration', 0) == 1) && ($this->TS_VCSC_PluginUsage == "true")) {
				add_filter('image_send_to_editor', 		array($this, 	'TS_VCSC_AddLightboxClassMediaEditor'), 	10, 3);
			}
		}
		
		// Activation Redirect
		// -------------------
		function TS_VCSC_ActivationRedirect() {
			if (get_option('ts_vcsc_extend_settings_redirect', 0) == 1) {
				wp_redirect(admin_url('admin.php?page=TS_VCSC_About'));
				update_option('ts_vcsc_extend_settings_activation', 		1);
				update_option('ts_vcsc_extend_settings_redirect', 			0);
			}
		}
		
		
		// Lightbox Media Integrations
		// ---------------------------
		function TS_VCSC_AddLightboxClassMediaEditor($html, $id, $attachment) {
			$linkptrn 														= "/<a(.*?)href=('|\")(.*?).(bmp|BMP|gif|GIF|jpeg|JPEG|jpg|JPG|png|PNG)('|\")(.*?)>/i";
			$found 															= preg_match($linkptrn, $html, $a_elem);
			// If no Link, do nothing
			if ($found <= 0) {return $html;};
			$a_elem 														= $a_elem[0];
			// Check to see if the link is to an uploaded image
			$is_attachment_link 											= strstr($a_elem, "wp-content/uploads/");
			// If link is to external resource, do nothing
			if ($is_attachment_link === FALSE) {return $html;};
			// Add data-title Attribute
			$a_title 														= get_the_title($id); 
			$a_data  														= 'data-title="' . $a_title . '"';
			// Add Lightbox Class Name
			$html 															= str_replace( "<a ", "<a {$a_data} ", $html );
			if (strstr($a_elem, "class=\"") !== FALSE) {
				// If link already has class defined inject it to attribute
				$a_elem_new 												= str_replace("class=\"", "class=\"ts-lightbox-integration no-ajaxy", $a_elem);
				$html 														= str_replace($a_elem, $a_elem_new, $html);
			} else {
				// If no class defined, just add class attribute
				$html 														= str_replace("<a ", "<a class=\"ts-lightbox-integration no-ajaxy\" ", $html);
			}
			return $html;
		}
		
		
		// Load Language Domain
		// --------------------
		function TS_VCSC_LoadTextDomains(){
			load_plugin_textdomain('ts_visual_composer_extend', false, dirname(plugin_basename( __FILE__ )) . '/locale');
		}

		
		// Remove Metaboxes from Custom Post Types
		// ---------------------------------------
		function TS_VCSC_Remove_MetaBoxes_Widgets($category) {
			remove_meta_box('commentstatusdiv', 	'ts_widgets', 			'normal');
			remove_meta_box('commentsdiv', 			'ts_widgets', 			'normal');
			remove_meta_box('slugdiv', 				'ts_widgets', 			'normal');
		}
		function TS_VCSC_Remove_MetaBoxes_Teams($category) {
			remove_meta_box('commentstatusdiv', 	'ts_team', 				'normal');
			remove_meta_box('commentsdiv', 			'ts_team', 				'normal');
			remove_meta_box('slugdiv', 				'ts_team', 				'normal');
		}
		function TS_VCSC_Remove_MetaBoxes_Testimonials($category) {
			remove_meta_box('commentstatusdiv', 	'ts_testimonials', 		'normal');
			remove_meta_box('commentsdiv', 			'ts_testimonials', 		'normal');
			remove_meta_box('slugdiv', 				'ts_testimonials', 		'normal');
		}
		function TS_VCSC_Remove_MetaBoxes_Logos($category) {
			remove_meta_box('commentstatusdiv', 	'ts_logos', 			'normal');
			remove_meta_box('commentsdiv', 			'ts_logos', 			'normal');
			remove_meta_box('slugdiv', 				'ts_logos', 			'normal');
		}
		function TS_VCSC_Remove_MetaBoxes_Skillsets($category) {
			remove_meta_box('commentstatusdiv', 	'ts_skillsets', 		'normal');
			remove_meta_box('commentsdiv', 			'ts_skillsets', 		'normal');
			remove_meta_box('slugdiv', 				'ts_skillsets', 		'normal');
		}
		function TS_VCSC_Remove_MetaBoxes_Timeline($category) {
			remove_meta_box('commentstatusdiv', 	'ts_timeline', 			'normal');
			remove_meta_box('commentsdiv', 			'ts_timeline', 			'normal');
			remove_meta_box('slugdiv', 				'ts_timeline', 			'normal');
		}
		

		// Load and Initialize the Auto-Update Class
		// -----------------------------------------
		function TS_VCSC_ActivateAutoUpdate() {
			global $pagenow;
			if (($pagenow == "index.php") || ($pagenow == "plugins.php") || ($pagenow == "update-core.php")) {
				if ($this->TS_VCSC_PluginIsMultiSiteActive == "true") {
					if (is_admin() && (strlen(get_site_option('ts_vcsc_extend_settings_license')) != 0) && (function_exists('get_plugin_data'))) {
						if ((get_site_option('ts_vcsc_extend_settings_licenseValid', 0) == 1) && (get_option('ts_vcsc_extend_settings_extended', 0) == 0) && ((strpos(get_site_option('ts_vcsc_extend_settings_licenseInfo', ''), get_site_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix')) != FALSE))) {
							if (!class_exists('TS_VCSC_AutoUpdate')) {
								require_once ('assets/ts_vcsc_autoupdate.php');
							}
							// Define Path and Base File for Plugin
							$ts_vcsc_extend_plugin_slug 					= $this->TS_VCSC_PluginSlug;
							$ts_vcsc_extend_plugin_path						= $this->TS_VCSC_PluginPath;
							// Get the current version
							$ts_vcsc_extend_plugin_current_version	        = TS_VCSC_GetPluginVersion();
							// Define Path to Remote Update File
							$ts_vcsc_extend_plugin_remote_path 		        = 'http://www.tekanewascripts.com/updates/ts-update-vc-extensions-wp.php';
							// Initialize Update Check
							$ts_vcsc_extend_plugin_class 					= new TS_VCSC_AutoUpdate($ts_vcsc_extend_plugin_current_version, $ts_vcsc_extend_plugin_remote_path, $ts_vcsc_extend_plugin_slug);
							// Retrieve Newest Plugin Version Number
							$ts_vcsc_extend_plugin_latest_version			= $ts_vcsc_extend_plugin_class->getRemote_version();
							// Save Current and Latest Version in WordPress Options
							update_site_option('ts_vcsc_extend_settings_versionCurrent',	$ts_vcsc_extend_plugin_current_version);
							update_site_option('ts_vcsc_extend_settings_versionLatest',		$ts_vcsc_extend_plugin_latest_version);						
						}
					}
				} else {
					if (is_admin() && (strlen(get_option('ts_vcsc_extend_settings_license')) != 0) && (function_exists('get_plugin_data'))) {
						if ((get_option('ts_vcsc_extend_settings_licenseValid', 0) == 1) && (get_option('ts_vcsc_extend_settings_extended', 0) == 0) && ((strpos(get_option('ts_vcsc_extend_settings_licenseInfo', ''), get_option('ts_vcsc_extend_settings_licenseKeyed', 'emptydelimiterfix')) != FALSE))) {
							if (!class_exists('TS_VCSC_AutoUpdate')) {
								require_once ('assets/ts_vcsc_autoupdate.php');
							}
							// Define Path and Base File for Plugin
							$ts_vcsc_extend_plugin_slug 					= $this->TS_VCSC_PluginSlug;
							$ts_vcsc_extend_plugin_path						= $this->TS_VCSC_PluginPath;
							// Get the current version
							$ts_vcsc_extend_plugin_current_version	        = TS_VCSC_GetPluginVersion();
							// Define Path to Remote Update File
							$ts_vcsc_extend_plugin_remote_path 		        = 'http://www.tekanewascripts.com/updates/ts-update-vc-extensions-wp.php';
							// Initialize Update Check
							$ts_vcsc_extend_plugin_class 					= new TS_VCSC_AutoUpdate($ts_vcsc_extend_plugin_current_version, $ts_vcsc_extend_plugin_remote_path, $ts_vcsc_extend_plugin_slug);
							// Retrieve Newest Plugin Version Number
							$ts_vcsc_extend_plugin_latest_version			= $ts_vcsc_extend_plugin_class->getRemote_version();
							// Save Current and Latest Version in WordPress Options
							update_option('ts_vcsc_extend_settings_versionCurrent', 		$ts_vcsc_extend_plugin_current_version);
							update_option('ts_vcsc_extend_settings_versionLatest', 			$ts_vcsc_extend_plugin_latest_version);
						}
					}
				}
			}
		}

		
		// Declare Arrays with Icon Font Data
		// ----------------------------------
		function TS_VCSC_IconFontArrays() {
			// Define Arrays for Font Icons
			// ----------------------------
			$this->TS_VCSC_Active_Icon_Fonts          	= 0;
			$this->TS_VCSC_Active_Icon_Count          	= 0;
			$this->TS_VCSC_Total_Icon_Count           	= 0;
			$this->TS_VCSC_Default_Icon_Fonts         	= array();

			// Define Global Font Arrays
			$this->TS_VCSC_Icons_Blank 					= array(
				'' 						=> '',
			);
			$this->TS_VCSC_Fonts_Blank 					= array(
				'All Fonts' 			=> '',
			);
			
			// Set Array for Full Icon List based on Icon Picker
			if (($this->TS_VCSC_EditorIconFontsInternal == "true") && ($this->TS_VCSC_EditorNativeSelector == "true")) {
				unset($this->TS_VCSC_HoverEffectsIconsSelectionCompliant[0]["transparent"]);
				$this->TS_VCSC_List_Icons_Compliant		= array();
			} else {
				$this->TS_VCSC_List_Icons_Compliant		= array(
					array("transparent" 	=> ""),
				);
			}			
			
			$this->TS_VCSC_List_Active_Fonts          	= array();
			$this->TS_VCSC_List_Select_Fonts          	= $this->TS_VCSC_Fonts_Blank;
			
			$this->TS_VCSC_List_Initial_Icons         	= $this->TS_VCSC_Icons_Blank;
			
			$this->TS_VCSC_Name_Initial_Font          	= "";
			$this->TS_VCSC_Class_Initial_Font         	= "";
			
			$TS_VCSC_IconFont_Settings 					= get_option('ts_vcsc_extend_settings_IconFontSettings', 	'');
			$TS_VCSC_IconFont_Override					= get_option('ts_vcsc_extend_settings_tinymceFontsAll', 	0);
			
			// Add "Composium" Internal Fonts
			foreach ($this->TS_VCSC_Icon_Font_Settings as $Icon_Font => $iconfont) {
				if ($iconfont['setting'] != 'Custom') {
					$this->TS_VCSC_Default_Icon_Fonts[$Icon_Font] 								= $iconfont['setting'];
					// Check if Font is enabled
					$default 																	= ($iconfont['default'] == "true" ? 1 : 0);
					$this->{'TS_VCSC_tinymce' . $iconfont['setting'] . ''}              		= get_option('ts_vcsc_extend_settings_tinymce' . $iconfont['setting'], $default);
					// Load Font Arrays
					if ((!isset($this->{'TS_VCSC_Icons_' . $iconfont['setting'] . ''})) && (($this->{'TS_VCSC_tinymce' . $iconfont['setting'] . ''} == 1) || ($TS_VCSC_IconFont_Override == 1))) {
						require_once($this->assets_dir.('ts_vcsc_font_' . strtolower($iconfont['setting']) . '.php'));
					}
					// Get Icon Count in Font
					$this->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'}					= $iconfont['count'];
					// Add Font Icons to Global Arrays					
					if (($this->{'TS_VCSC_tinymce' . $iconfont['setting'] . ''} == 0) && ($TS_VCSC_IconFont_Override == 0)) {
						$this->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''} 		= array();
						$this->TS_VCSC_Icon_Font_Settings[$Icon_Font]['active'] 				= "false";
					} else {
						$this->TS_VCSC_Active_Icon_Fonts++;
						$this->TS_VCSC_List_Active_Fonts[$Icon_Font] 							= $iconfont['setting'];
						$this->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''} 		= $this->{'TS_VCSC_Compliant_Icons_' . $iconfont['setting'] . ''};
						$this->TS_VCSC_Icon_Font_Settings[$Icon_Font]['active'] 				= "true";
						uksort($this->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''}, "TS_VCSC_CaseInsensitiveSort");
						$this->TS_VCSC_Active_Icon_Count  										= $this->TS_VCSC_Active_Icon_Count + $this->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'};
						if ($this->TS_VCSC_Active_Icon_Fonts == 1) {
							$this->TS_VCSC_List_Initial_Icons 									= $this->TS_VCSC_List_Initial_Icons + $this->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''};
							$this->TS_VCSC_Name_Initial_Font 									= $Icon_Font;
							$this->TS_VCSC_Class_Initial_Font 									= $iconfont['setting'];
						}
					}
					$this->TS_VCSC_List_Icons_Compliant											= $this->TS_VCSC_List_Icons_Compliant + $this->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''};
					$this->TS_VCSC_Total_Icon_Count       										= $this->TS_VCSC_Total_Icon_Count + $this->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'};
				}
			}
			
			// Add Visual Composer Internal Fonts (VC v4.4.0+)
			if ($this->TS_VCSC_EditorIconFontsInternal == "true") {
				foreach ($this->TS_VCSC_Composer_Font_Settings as $Icon_Font => $iconfont) {
					$this->TS_VCSC_Default_Icon_Fonts[$Icon_Font] 								= $iconfont['setting'];
					// Check if Font is enabled
					$default 																	= ($iconfont['default'] == "true" ? 1 : 0);
					$this->{'TS_VCSC_tinymce' . $iconfont['setting'] . ''}              		= get_option('ts_vcsc_extend_settings_tinymce' . $iconfont['setting'], $default);
					// Load Font Arrays
					if ((!isset($this->{'TS_VCSC_Icons_' . $iconfont['setting'] . ''})) && (($this->{'TS_VCSC_tinymce' . $iconfont['setting'] . ''} == 1) || ($TS_VCSC_IconFont_Override == 1))) {
						require_once($this->assets_dir.('ts_vcsc_font_' . strtolower($iconfont['setting']) . '.php'));
					}
					// Get Icon Count in Font
					$this->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'}					= $iconfont['count'];
					// Add Font Icons to Global Arrays					
					if (($this->{'TS_VCSC_tinymce' . $iconfont['setting'] . ''} == 0) && ($TS_VCSC_IconFont_Override == 0)) {
						$this->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''} 		= array();
						$this->TS_VCSC_Composer_Font_Settings[$Icon_Font]['active'] 			= "false";
					} else {
						$this->TS_VCSC_Active_Icon_Fonts++;
						$this->TS_VCSC_List_Active_Fonts[$Icon_Font] 							= $iconfont['setting'];
						$this->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''} 		= $this->{'TS_VCSC_Compliant_Icons_' . $iconfont['setting'] . ''};
						$this->TS_VCSC_Composer_Font_Settings[$Icon_Font]['active'] 			= "true";
						uksort($this->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''}, "TS_VCSC_CaseInsensitiveSort");
						$this->TS_VCSC_Active_Icon_Count  										= $this->TS_VCSC_Active_Icon_Count + $this->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'};
						if ($this->TS_VCSC_Active_Icon_Fonts == 1) {
							$this->TS_VCSC_List_Initial_Icons 									= $this->TS_VCSC_List_Initial_Icons + $this->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''};
							$this->TS_VCSC_Name_Initial_Font 									= $Icon_Font;
							$this->TS_VCSC_Class_Initial_Font 									= $iconfont['setting'];
						}
					}
					$this->TS_VCSC_List_Icons_Compliant											= $this->TS_VCSC_List_Icons_Compliant + $this->{'TS_VCSC_Icons_Compliant_' . $iconfont['setting'] . ''};
					$this->TS_VCSC_Total_Icon_Count       										= $this->TS_VCSC_Total_Icon_Count + $this->{'TS_VCSC_tinymce' . $iconfont['setting'] . 'Count'};
				}
			}
			
			// Add Custom Font Icons to Global Arrays (if enabled)
			if (((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_fontimport', 1) == 1)) || (get_option('ts_vcsc_extend_settings_extended', 0) == 0)) {
				if ((get_option('ts_vcsc_extend_settings_tinymceCustom', 0) == 1) && (get_option('ts_vcsc_extend_settings_tinymceCustomArray', '') != '') && (get_option('ts_vcsc_extend_settings_tinymceCustomCount', 0) > 0)) {
					$this->TS_VCSC_Icons_Custom           										= get_option('ts_vcsc_extend_settings_tinymceCustomArray');
				} else {
					$this->TS_VCSC_Icons_Custom          										= array();
				}
				$this->TS_VCSC_Icons_Compliant_Custom = array(
					"Custom User Font" => array()
				);
				$font_path																		= get_option('ts_vcsc_extend_settings_tinymceCustomPath', '');
				$font_directory																	= get_option('ts_vcsc_extend_settings_tinymceCustomDirectory', '');
				if (file_exists($font_directory . '/style.css')) {
					$font_files_style															= true;
				} else if (file_exists($font_path)) {
					$font_files_style															= true;
				} else {
					$font_files_style															= false;
				}
				if ((get_option('ts_vcsc_extend_settings_tinymceCustom', 0) == 1) && ($font_files_style == true)) {
					$this->TS_VCSC_Default_Icon_Fonts[$Icon_Font] 								= $iconfont['setting'];
					$this->TS_VCSC_Active_Icon_Fonts++;
					$this->TS_VCSC_List_Active_Fonts['Custom User Font'] 						= 'Custom';
					$this->TS_VCSC_List_Icons_Custom          									= $this->TS_VCSC_Icons_Custom;
					if (count(($this->TS_VCSC_Icons_Custom)) > 1) {
						if (is_array($this->TS_VCSC_Icons_Custom)) {
							$this->TS_VCSC_tinymceCustomCount									= count(array_unique($this->TS_VCSC_Icons_Custom));
						} else {
							$this->TS_VCSC_tinymceCustomCount									= count($this->TS_VCSC_Icons_Custom);
						}
					} else {
						$this->TS_VCSC_tinymceCustomCount       								= count($this->TS_VCSC_Icons_Custom);
					}
					$this->TS_VCSC_Icon_Font_Settings['Custom User Font']['count'] 				= $this->TS_VCSC_tinymceCustomCount;
					$this->TS_VCSC_Total_Icon_Count           									= $this->TS_VCSC_Total_Icon_Count + $this->TS_VCSC_tinymceCustomCount;
					$this->TS_VCSC_Active_Icon_Count          									= $this->TS_VCSC_Active_Icon_Count + $this->TS_VCSC_tinymceCustomCount;
					if ($this->TS_VCSC_Active_Icon_Fonts == 1) {
						$this->TS_VCSC_List_Initial_Icons     									= $this->TS_VCSC_List_Initial_Icons + $this->TS_VCSC_Icons_Compliant_Custom;
						$this->TS_VCSC_Name_Initial_Font      									= 'Custom User Font';
						$this->TS_VCSC_Class_Initial_Font     									= 'Custom';
					}					
					foreach ($this->TS_VCSC_List_Icons_Custom as $key => $option) {
						$custom_array 															= array();
						$custom_array[$key] 													= $key; //$option
						array_push($this->TS_VCSC_Icons_Compliant_Custom["Custom User Font"], $custom_array);
					}						
					$this->TS_VCSC_List_Icons_Compliant											= $this->TS_VCSC_List_Icons_Compliant + $this->TS_VCSC_Icons_Compliant_Custom;
				} else if ($font_files_style == false) {					
					TS_VCSC_ResetCustomFont();
				}
			} else {
				$this->TS_VCSC_DeleteCustomPack_Ajax();
			}
			
			$this->TS_VCSC_List_Select_Fonts          											= $this->TS_VCSC_List_Select_Fonts + $this->TS_VCSC_List_Active_Fonts;
			
			// Define Icon Selector Settings
			$this->TS_VCSC_IconSelectorType				= ($this->TS_VCSC_EditorVisualSelector == "true" ? ((($this->TS_VCSC_EditorIconFontsInternal == "true") && ($this->TS_VCSC_EditorNativeSelector == "true")) 	? "iconpicker" : "icons_panel") : "textfield");
			$this->TS_VCSC_IconSelectorValue			= ($this->TS_VCSC_EditorVisualSelector == "true" ? ((($this->TS_VCSC_EditorIconFontsInternal == "true") && ($this->TS_VCSC_EditorNativeSelector == "true")) 	? array() : $this->TS_VCSC_List_Icons_Compliant) : array());
			$this->TS_VCSC_IconSelectorSource			= (($this->TS_VCSC_EditorVisualSelector == "true" && $this->TS_VCSC_EditorIconFontsInternal == "true" && $this->TS_VCSC_EditorNativeSelector == "true") 		? $this->TS_VCSC_List_Icons_Compliant : array());
			$this->TS_VCSC_IconSelectorPager			= intval(get_option('ts_vcsc_extend_settings_nativePaginator', '200'));
			$this->TS_VCSC_IconSelectorString			= __( "Manually enter the class name for the icon you want to use for this element.", "ts_visual_composer_extend" ) . '<br/><a href="' . site_url() . '/wp-admin/admin.php?page=TS_VCSC_Previews" target="_blank">' . __( "Find Icon Class Name", "ts_visual_composer_extend" ) . '</a>';
		}
		
		
		// Add additional "Settings" Link to Plugin Listing Page
		// -----------------------------------------------------
		function TS_VCSC_PluginAddSettingsLink($links) {
			$links[] = '<a href="admin.php?page=TS_VCSC_Extender" target="_parent">Settings</a>';
			$links[] = '<a href="http://tekanewascripts.com/vcextensions/documentation" target="_blank">Manual</a>';
			$links[] = '<a href="http://helpdesk.tekanewascripts.com/changelog-composium-visual-composer-extensions/" target="_blank">Changelog</a>';
			return $links;
		}
		
		
		// Register Custom CSS and JS Inputs
		// ---------------------------------
		function TS_VCSC_RegisterCustomCSS_Setting() {
			register_setting('ts_vcsc_extend_custom_css', 	'ts_vcsc_extend_custom_css', 	    	array($this, 'TS_VCSC_CustomCSS_Validation'));
		}
		function TS_VCSC_RegisterCustomJS_Setting() {
			register_setting('ts_vcsc_extend_custom_js', 	'ts_vcsc_extend_custom_js',          	array($this, 'TS_VCSC_CustomJS_Validation'));
		}
		function TS_VCSC_CustomCSS_Validation($input) {
			if (!empty($input['ts_vcsc_extend_custom_css'])) {
				$input['ts_vcsc_extend_custom_css'] = trim( $input['ts_vcsc_extend_custom_css'] );
			}
			return $input;
		}
		function TS_VCSC_CustomJS_Validation($input) {
			if (!empty($input['ts_vcsc_extend_custom_js'])) {
				$input['ts_vcsc_extend_custom_js'] = trim( $input['ts_vcsc_extend_custom_js'] );
			}
			return $input;
		}
		function TS_VCSC_DisplayCustomCSS() {
			if ((get_option('ts_vcsc_extend_settings_extended', 0) == 0) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && ($this->TS_VCSC_UseCodeEditors == "true"))) {
				$ts_vcsc_extend_custom_css = 				get_option('ts_vcsc_extend_custom_css');
				$ts_vcsc_extend_custom_css_default =		get_option('ts_vcsc_extend_settings_customCSS');
				if ((!empty($ts_vcsc_extend_custom_css)) && ($ts_vcsc_extend_custom_css != $ts_vcsc_extend_custom_css_default)) {
					echo '<style type="text/css" media="all">' . "\n";
						echo '/* Custom CSS for Visual Composer Extensions WP */' . "\n";
						echo $ts_vcsc_extend_custom_css . "\n";
					echo '</style>' . "\n";
				}
			}
		}
		function TS_VCSC_DisplayCustomJS() {
			if ((get_option('ts_vcsc_extend_settings_extended', 0) == 0) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && ($this->TS_VCSC_UseCodeEditors == "true"))) {
				$ts_vcsc_extend_custom_js = 				get_option('ts_vcsc_extend_custom_js');
				$ts_vcsc_extend_custom_js_default = 		get_option('ts_vcsc_extend_settings_customJS');
				if ((!empty($ts_vcsc_extend_custom_js)) && ($ts_vcsc_extend_custom_js != $ts_vcsc_extend_custom_js_default)) {
					echo '<script type="text/javascript">' . "\n";
						echo '(function ($) {' . "\n";
							echo '/* Custom JS for Visual Composer Extensions WP */' . "\n";
							echo $ts_vcsc_extend_custom_js . "\n";
						echo '})(jQuery);' . "\n";
					echo '</script>' . "\n";
				}
			}
		}
		
		
		// Function to register Scripts and Stylesheets
		// --------------------------------------------
		function TS_VCSC_Extensions_Registrations() {
			require_once($this->assets_dir . 'ts_vcsc_registrations_files.php');
		}
		// Function to translate PHP Settings into JS Variables
		// ----------------------------------------------------
		function TS_VCSC_Extensions_Create_Variables() {
			$TS_VCSC_Lightbox_Defaults 			= get_option('ts_vcsc_extend_settings_defaultLightboxSettings', '');
			if (($TS_VCSC_Lightbox_Defaults == false) || (empty($TS_VCSC_Lightbox_Defaults))) {
				$TS_VCSC_Lightbox_Defaults		= $this->TS_VCSC_Lightbox_Setting_Defaults;
			}
			$TS_VCSC_Countdown_Language			= get_option('ts_vcsc_extend_settings_translationsCountdown', '');
			if (($TS_VCSC_Countdown_Language == false) || (empty($TS_VCSC_Countdown_Language))) {
				$TS_VCSC_Countdown_Language		= $this->TS_VCSC_Countdown_Language_Defaults;
			}			
			$TS_VCSC_Magnify_Language			= get_option('ts_vcsc_extend_settings_translationsMagnify', '');
			if (($TS_VCSC_Magnify_Language == false) || (empty($TS_VCSC_Magnify_Language))) {
				$TS_VCSC_Magnify_Language		= $this->TS_VCSC_Magnify_Language_Defaults;
			}			
			$TS_VCSC_Google_Map_Language 		= get_option('ts_vcsc_extend_settings_translationsGoogleMap', '');
			if (($TS_VCSC_Google_Map_Language == false) || (empty($TS_VCSC_Google_Map_Language))) {
				$TS_VCSC_Google_Map_Language	= $this->TS_VCSC_Google_Map_Language_Defaults;
			}
			echo '<script type="text/javascript">';
				if ($this->TS_VCSC_UseInternalLightbox == "true") {
					// Lightbox Settings
					echo 'var $TS_VCSC_Lightbox_Activated = true;';
					echo 'var $TS_VCSC_Lightbox_Thumbs = "' . 				((array_key_exists('thumbs', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['thumbs'] : 					$this->TS_VCSC_Lightbox_Setting_Defaults['thumbs']) . '";';
					echo 'var $TS_VCSC_Lightbox_Thumbsize = ' . 			((array_key_exists('thumbsize', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['thumbsize'] : 				$this->TS_VCSC_Lightbox_Setting_Defaults['thumbsize']) . ';';
					echo 'var $TS_VCSC_Lightbox_Animation = "' . 			((array_key_exists('animation', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['animation'] : 				$this->TS_VCSC_Lightbox_Setting_Defaults['animation']) . '";';
					echo 'var $TS_VCSC_Lightbox_Captions = "' . 			((array_key_exists('captions', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['captions'] : 				$this->TS_VCSC_Lightbox_Setting_Defaults['captions']) . '";';
					echo 'var $TS_VCSC_Lightbox_Closer = ' . 				(((array_key_exists('closer', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['closer'] : 					$this->TS_VCSC_Lightbox_Setting_Defaults['closer']) == 1 ? 'true' : 'false') . ';';
					echo 'var $TS_VCSC_Lightbox_Durations = ' . 			((array_key_exists('duration', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['duration'] : 				$this->TS_VCSC_Lightbox_Setting_Defaults['duration']) . ';';
					echo 'var $TS_VCSC_Lightbox_Share = ' . 				(((array_key_exists('share', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['share'] : 					$this->TS_VCSC_Lightbox_Setting_Defaults['share']) == 1 ? 'true' : 'false') . ';';
					echo 'var $TS_VCSC_Lightbox_LoadAPIs = ' . 				(((array_key_exists('loadapis', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['loadapis'] : 				$this->TS_VCSC_Lightbox_Setting_Defaults['loadapis']) == 1 ? 'true' : 'false') . ';';
					echo 'var $TS_VCSC_Lightbox_Social = "' . 				((array_key_exists('social', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['social'] : 					$this->TS_VCSC_Lightbox_Setting_Defaults['social']) . '";';
					echo 'var $TS_VCSC_Lightbox_NoTouch = ' . 				(((array_key_exists('notouch', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['notouch'] : 				$this->TS_VCSC_Lightbox_Setting_Defaults['notouch']) == 1 ? 'false' : 'true') . ';';
					echo 'var $TS_VCSC_Lightbox_BGClose = ' . 				(((array_key_exists('bgclose', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['bgclose'] : 				$this->TS_VCSC_Lightbox_Setting_Defaults['bgclose']) == 1 ? 'true' : 'false') . ';';
					echo 'var $TS_VCSC_Lightbox_NoHashes = ' . 				(((array_key_exists('nohashes', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['nohashes'] : 				$this->TS_VCSC_Lightbox_Setting_Defaults['nohashes']) == 1 ? 'true' : 'false') . ';';
					echo 'var $TS_VCSC_Lightbox_Keyboard = ' . 				(((array_key_exists('keyboard', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['keyboard'] : 				$this->TS_VCSC_Lightbox_Setting_Defaults['keyboard']) == 1 ? 'true' : 'false') . ';';
					echo 'var $TS_VCSC_Lightbox_FullScreen = ' . 			(((array_key_exists('fullscreen', $TS_VCSC_Lightbox_Defaults)) ? 			$TS_VCSC_Lightbox_Defaults['fullscreen'] : 				$this->TS_VCSC_Lightbox_Setting_Defaults['fullscreen']) == 1 ? 'true' : 'false') . ';';
					echo 'var $TS_VCSC_Lightbox_Zoom = ' . 					(((array_key_exists('zoom', $TS_VCSC_Lightbox_Defaults)) ? 					$TS_VCSC_Lightbox_Defaults['zoom'] : 					$this->TS_VCSC_Lightbox_Setting_Defaults['zoom']) == 1 ? 'true' : 'false') . ';';
					echo 'var $TS_VCSC_Lightbox_FXSpeed = ' . 				((array_key_exists('fxspeed', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['fxspeed'] : 				$this->TS_VCSC_Lightbox_Setting_Defaults['fxspeed']) . ';';
					echo 'var $TS_VCSC_Lightbox_Scheme = "' . 				((array_key_exists('scheme', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['scheme'] : 					$this->TS_VCSC_Lightbox_Setting_Defaults['scheme']) . '";';
					echo 'var $TS_VCSC_Lightbox_Backlight = "' . 			((array_key_exists('backlight', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['backlight'] : 				$this->TS_VCSC_Lightbox_Setting_Defaults['backlight']) . '";';
					echo 'var $TS_VCSC_Lightbox_UseColor = ' . 				(((array_key_exists('usecolor', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['usecolor'] : 				$this->TS_VCSC_Lightbox_Setting_Defaults['usecolor']) == 1 ? 'true' : 'false') . ';';
					echo 'var $TS_VCSC_Lightbox_Overlay = "' . 				((array_key_exists('overlay', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['overlay'] : 				$this->TS_VCSC_Lightbox_Setting_Defaults['overlay']) . '";';				
					echo 'var $TS_VCSC_Lightbox_Background = "' . 			((array_key_exists('background', $TS_VCSC_Lightbox_Defaults)) ? 			$TS_VCSC_Lightbox_Defaults['background'] : 				$this->TS_VCSC_Lightbox_Setting_Defaults['background']) . '";';
					echo 'var $TS_VCSC_Lightbox_Repeat = "' . 				((array_key_exists('repeat', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['repeat'] : 					$this->TS_VCSC_Lightbox_Setting_Defaults['repeat']) . '";';				
					echo 'var $TS_VCSC_Lightbox_Noise = "' . 				((array_key_exists('noise', $TS_VCSC_Lightbox_Defaults)) ? 					$TS_VCSC_Lightbox_Defaults['noise'] : 					$this->TS_VCSC_Lightbox_Setting_Defaults['noise']) . '";';
					echo 'var $TS_VCSC_Lightbox_CORS = ' . 					(((array_key_exists('cors', $TS_VCSC_Lightbox_Defaults)) ? 					$TS_VCSC_Lightbox_Defaults['cors'] : 					$this->TS_VCSC_Lightbox_Setting_Defaults['cors']) == 1 ? 'true' : 'false') . ';';
					echo 'var $TS_VCSC_Lightbox_Tapping = ' . 				(((array_key_exists('tapping', $TS_VCSC_Lightbox_Defaults)) ? 				$TS_VCSC_Lightbox_Defaults['tapping'] : 				$this->TS_VCSC_Lightbox_Setting_Defaults['tapping']) == 1 ? 'true' : 'false') . ';';
					echo 'var $TS_VCSC_Lightbox_ScrollBlock = "' . 			((array_key_exists('scrollblock', $TS_VCSC_Lightbox_Defaults)) ? 			$TS_VCSC_Lightbox_Defaults['scrollblock'] : 			$this->TS_VCSC_Lightbox_Setting_Defaults['scrollblock']) . '";';
					echo 'var $TS_VCSC_Lightbox_LastScroll = 0;';
				} else {
					echo 'var $TS_VCSC_Lightbox_Activated = false;';
				}
				// Language Settings for Countdown
				if ($this->TS_VCSC_Visual_Composer_Elements['TS Countdown']['active'] == 'true') {
					echo 'var $TS_VCSC_Countdown_DaysLabel = "' . 			((array_key_exists('DayPlural', $TS_VCSC_Countdown_Language)) ? 			$TS_VCSC_Countdown_Language['DayPlural'] : 				$this->TS_VCSC_Countdown_Language_Defaults['DayPlural']) . '";';
					echo 'var $TS_VCSC_Countdown_DayLabel = "' . 			((array_key_exists('DaySingular', $TS_VCSC_Countdown_Language)) ? 			$TS_VCSC_Countdown_Language['DaySingular'] : 			$this->TS_VCSC_Countdown_Language_Defaults['DaySingular']) . '";';
					echo 'var $TS_VCSC_Countdown_HoursLabel = "' . 			((array_key_exists('HourPlural', $TS_VCSC_Countdown_Language)) ? 			$TS_VCSC_Countdown_Language['HourPlural'] : 			$this->TS_VCSC_Countdown_Language_Defaults['HourPlural']) . '";';
					echo 'var $TS_VCSC_Countdown_HourLabel = "' . 			((array_key_exists('HourSingular', $TS_VCSC_Countdown_Language)) ? 			$TS_VCSC_Countdown_Language['HourSingular'] : 			$this->TS_VCSC_Countdown_Language_Defaults['HourSingular']) . '";';
					echo 'var $TS_VCSC_Countdown_MinutesLabel = "' .		((array_key_exists('MinutePlural', $TS_VCSC_Countdown_Language)) ? 			$TS_VCSC_Countdown_Language['MinutePlural'] : 			$this->TS_VCSC_Countdown_Language_Defaults['MinutePlural']) . '";';
					echo 'var $TS_VCSC_Countdown_MinuteLabel = "' . 		((array_key_exists('MinuteSingular', $TS_VCSC_Countdown_Language)) ? 		$TS_VCSC_Countdown_Language['MinuteSingular'] : 		$this->TS_VCSC_Countdown_Language_Defaults['MinuteSingular']) . '";';
					echo 'var $TS_VCSC_Countdown_SecondsLabel = "' . 		((array_key_exists('SecondPlural', $TS_VCSC_Countdown_Language)) ? 			$TS_VCSC_Countdown_Language['SecondPlural'] : 			$this->TS_VCSC_Countdown_Language_Defaults['SecondPlural']) . '";';
					echo 'var $TS_VCSC_Countdown_SecondLabel = "' . 		((array_key_exists('SecondSingular', $TS_VCSC_Countdown_Language)) ? 		$TS_VCSC_Countdown_Language['SecondSingular'] : 		$this->TS_VCSC_Countdown_Language_Defaults['SecondSingular']) . '";';
				}
				// Language Settings for Image Magnify
				if ($this->TS_VCSC_Visual_Composer_Elements['TS Image Magnify']['active'] == 'true') {
					echo 'var $TS_VCSC_Magnify_ZoomIn = "' . 					((array_key_exists('ZoomIn', $TS_VCSC_Magnify_Language)) ? 					$TS_VCSC_Magnify_Language['ZoomIn'] : 					$this->TS_VCSC_Magnify_Language_Defaults['ZoomIn']) . '";';
					echo 'var $TS_VCSC_Magnify_ZoomOut = "' . 					((array_key_exists('ZoomOut', $TS_VCSC_Magnify_Language)) ? 				$TS_VCSC_Magnify_Language['ZoomOut'] : 					$this->TS_VCSC_Magnify_Language_Defaults['ZoomOut']) . '";';
					echo 'var $TS_VCSC_Magnify_ZoomLevel = "' . 				((array_key_exists('ZoomLevel', $TS_VCSC_Magnify_Language)) ? 				$TS_VCSC_Magnify_Language['ZoomLevel'] : 				$this->TS_VCSC_Magnify_Language_Defaults['ZoomLevel']) . '";';
					echo 'var $TS_VCSC_Magnify_ChangeLevel = "' . 				((array_key_exists('ChangeLevel', $TS_VCSC_Magnify_Language)) ? 			$TS_VCSC_Magnify_Language['ChangeLevel'] : 				$this->TS_VCSC_Magnify_Language_Defaults['ChangeLevel']) . '";';
					echo 'var $TS_VCSC_Magnify_Next = "' .						((array_key_exists('Next', $TS_VCSC_Magnify_Language)) ? 					$TS_VCSC_Magnify_Language['Next'] : 					$this->TS_VCSC_Magnify_Language_Defaults['Next']) . '";';
					echo 'var $TS_VCSC_Magnify_Previous = "' . 					((array_key_exists('Previous', $TS_VCSC_Magnify_Language)) ? 				$TS_VCSC_Magnify_Language['Previous'] : 				$this->TS_VCSC_Magnify_Language_Defaults['Previous']) . '";';
					echo 'var $TS_VCSC_Magnify_Reset = "' . 					((array_key_exists('Reset', $TS_VCSC_Magnify_Language)) ? 					$TS_VCSC_Magnify_Language['Reset'] : 					$this->TS_VCSC_Magnify_Language_Defaults['Reset']) . '";';
					echo 'var $TS_VCSC_Magnify_Rotate = "' . 					((array_key_exists('Rotate', $TS_VCSC_Magnify_Language)) ? 					$TS_VCSC_Magnify_Language['Rotate'] : 					$this->TS_VCSC_Magnify_Language_Defaults['Rotate']) . '";';
					echo 'var $TS_VCSC_Magnify_Lightbox = "' . 					((array_key_exists('Lightbox', $TS_VCSC_Magnify_Language)) ? 				$TS_VCSC_Magnify_Language['Lightbox'] : 				$this->TS_VCSC_Magnify_Language_Defaults['Lightbox']) . '";';
				}
				// Language Settings for Google Map
				if ($this->TS_VCSC_Visual_Composer_Elements['TS Google Maps (Deprecated)']['active'] == 'true') {
					echo 'var $TS_VCSC_GoogleMap_TextCalcShow = "' . 			((array_key_exists('TextCalcShow', $TS_VCSC_Google_Map_Language)) ? 		$TS_VCSC_Google_Map_Language['TextCalcShow'] : 			$this->TS_VCSC_Google_Map_Language_Defaults['TextCalcShow']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextCalcHide = "' .			((array_key_exists('TextCalcHide', $TS_VCSC_Google_Map_Language)) ? 		$TS_VCSC_Google_Map_Language['TextCalcHide'] : 			$this->TS_VCSC_Google_Map_Language_Defaults['TextCalcHide']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextDirectionShow = "' . 		((array_key_exists('TextDirectionShow', $TS_VCSC_Google_Map_Language)) ? 	$TS_VCSC_Google_Map_Language['TextDirectionShow'] : 	$this->TS_VCSC_Google_Map_Language_Defaults['TextDirectionShow']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextDirectionHide = "' . 		((array_key_exists('TextDirectionHide', $TS_VCSC_Google_Map_Language)) ? 	$TS_VCSC_Google_Map_Language['TextDirectionHide'] : 	$this->TS_VCSC_Google_Map_Language_Defaults['TextDirectionHide']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextResetMap = "' . 			((array_key_exists('TextResetMap', $TS_VCSC_Google_Map_Language)) ? 		$TS_VCSC_Google_Map_Language['TextResetMap'] : 			$this->TS_VCSC_Google_Map_Language_Defaults['TextResetMap']) . '";';
					echo 'var $TS_VCSC_GoogleMap_PrintRouteText = "' . 			((array_key_exists('PrintRouteText', $TS_VCSC_Google_Map_Language)) ? 		$TS_VCSC_Google_Map_Language['PrintRouteText'] : 		$this->TS_VCSC_Google_Map_Language_Defaults['PrintRouteText']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextDistance = "' . 			((array_key_exists('TextDistance', $TS_VCSC_Google_Map_Language)) ? 		$TS_VCSC_Google_Map_Language['TextDistance'] : 			$this->TS_VCSC_Google_Map_Language_Defaults['TextDistance']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextViewOnGoogle = "' . 		((array_key_exists('TextViewOnGoogle', $TS_VCSC_Google_Map_Language)) ? 	$TS_VCSC_Google_Map_Language['TextViewOnGoogle'] : 		$this->TS_VCSC_Google_Map_Language_Defaults['TextViewOnGoogle']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextButtonCalc = "' . 			((array_key_exists('TextButtonCalc', $TS_VCSC_Google_Map_Language)) ? 		$TS_VCSC_Google_Map_Language['TextButtonCalc'] : 		$this->TS_VCSC_Google_Map_Language_Defaults['TextButtonCalc']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextSetTarget = "' . 			((array_key_exists('TextSetTarget', $TS_VCSC_Google_Map_Language)) ? 		$TS_VCSC_Google_Map_Language['TextSetTarget'] : 		$this->TS_VCSC_Google_Map_Language_Defaults['TextSetTarget']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextGeoLocation = "' . 		((array_key_exists('TextGeoLocation', $TS_VCSC_Google_Map_Language)) ? 		$TS_VCSC_Google_Map_Language['TextGeoLocation'] : 		$this->TS_VCSC_Google_Map_Language_Defaults['TextGeoLocation']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextTravelMode = "' . 			((array_key_exists('TextTravelMode', $TS_VCSC_Google_Map_Language)) ? 		$TS_VCSC_Google_Map_Language['TextTravelMode'] : 		$this->TS_VCSC_Google_Map_Language_Defaults['TextTravelMode']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextDriving = "' . 			((array_key_exists('TextDriving', $TS_VCSC_Google_Map_Language)) ? 			$TS_VCSC_Google_Map_Language['TextDriving'] : 			$this->TS_VCSC_Google_Map_Language_Defaults['TextDriving']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextWalking = "' . 			((array_key_exists('TextWalking', $TS_VCSC_Google_Map_Language)) ? 			$TS_VCSC_Google_Map_Language['TextWalking'] : 			$this->TS_VCSC_Google_Map_Language_Defaults['TextWalking']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextBicy = "' . 				((array_key_exists('TextBicy', $TS_VCSC_Google_Map_Language)) ? 			$TS_VCSC_Google_Map_Language['TextBicy'] : 				$this->TS_VCSC_Google_Map_Language_Defaults['TextBicy']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextWP = "' . 					((array_key_exists('TextWP', $TS_VCSC_Google_Map_Language)) ? 				$TS_VCSC_Google_Map_Language['TextWP'] : 				$this->TS_VCSC_Google_Map_Language_Defaults['TextWP']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextButtonAdd = "' . 			((array_key_exists('TextButtonAdd', $TS_VCSC_Google_Map_Language)) ? 		$TS_VCSC_Google_Map_Language['TextButtonAdd'] : 		$this->TS_VCSC_Google_Map_Language_Defaults['TextButtonAdd']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextMapHome = "' . 			((array_key_exists('TextMapHome', $TS_VCSC_Google_Map_Language)) ? 			$TS_VCSC_Google_Map_Language['TextMapHome'] : 			$this->TS_VCSC_Google_Map_Language_Defaults['TextMapHome']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextMapBikes = "' . 			((array_key_exists('TextMapBikes', $TS_VCSC_Google_Map_Language)) ? 		$TS_VCSC_Google_Map_Language['TextMapBikes'] : 			$this->TS_VCSC_Google_Map_Language_Defaults['TextMapBikes']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextMapTraffic = "' . 			((array_key_exists('TextMapTraffic', $TS_VCSC_Google_Map_Language)) ? 		$TS_VCSC_Google_Map_Language['TextMapTraffic'] : 		$this->TS_VCSC_Google_Map_Language_Defaults['TextMapTraffic']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextMapSpeedMiles = "' . 		((array_key_exists('TextMapSpeedMiles', $TS_VCSC_Google_Map_Language)) ? 	$TS_VCSC_Google_Map_Language['TextMapSpeedMiles'] : 	$this->TS_VCSC_Google_Map_Language_Defaults['TextMapSpeedMiles']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextMapSpeedKM = "' . 			((array_key_exists('TextMapSpeedKM', $TS_VCSC_Google_Map_Language)) ? 		$TS_VCSC_Google_Map_Language['TextMapSpeedKM'] : 		$this->TS_VCSC_Google_Map_Language_Defaults['TextMapSpeedKM']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextMapNoData = "' . 			((array_key_exists('TextMapNoData', $TS_VCSC_Google_Map_Language)) ? 		$TS_VCSC_Google_Map_Language['TextMapNoData'] : 		$this->TS_VCSC_Google_Map_Language_Defaults['TextMapNoData']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextMapMiles = "' . 			((array_key_exists('TextMapMiles', $TS_VCSC_Google_Map_Language)) ? 		$TS_VCSC_Google_Map_Language['TextMapMiles'] : 			$this->TS_VCSC_Google_Map_Language_Defaults['TextMapMiles']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextMapKilometes = "' . 		((array_key_exists('TextMapKilometes', $TS_VCSC_Google_Map_Language)) ? 	$TS_VCSC_Google_Map_Language['TextMapKilometes'] : 		$this->TS_VCSC_Google_Map_Language_Defaults['TextMapKilometes']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextActivate = "' . 			((array_key_exists('TextMapActivate', $TS_VCSC_Google_Map_Language)) ? 		$TS_VCSC_Google_Map_Language['TextMapActivate'] : 		$this->TS_VCSC_Google_Map_Language_Defaults['TextMapActivate']) . '";';
					echo 'var $TS_VCSC_GoogleMap_TextDeactivate = "' . 			((array_key_exists('TextMapDeactivate', $TS_VCSC_Google_Map_Language)) ? 	$TS_VCSC_Google_Map_Language['TextMapDeactivate'] : 	$this->TS_VCSC_Google_Map_Language_Defaults['TextMapDeactivate']) . '";';
				}
				// Extended Row Effects (Breakpoint)
				if (get_option('ts_vcsc_extend_settings_additionsRows', 0) == 1) {
					echo 'var $TS_VCSC_RowEffects_Breakpoint = ' . 				get_option('ts_vcsc_extend_settings_additionsRowEffectsBreak', '600') . ';';
				}
				// Smooth Scroll Settings
				if ($this->TS_VCSC_VCFrontEditMode == "true") {
					echo 'var $TS_VCSC_SmoothScrollActive = false;';
				} else {
					if ($this->TS_VCSC_UseSmoothScroll == "true") {
						echo 'var $TS_VCSC_SmoothScrollActive = true;';
						echo 'var $TS_VCSC_SmoothScrollRange = 250;';
						echo 'var $TS_VCSC_SmoothScrollSpeed = 750;';
					} else {
						echo 'var $TS_VCSC_SmoothScrollActive = false;';
					}
				}
			echo '</script>';
		}
		function TS_VCSC_Extensions_Create_GoogleFontArray() {
			$parameter_selection				= array();
			$parameter_favorites				= array();
			if ($this->TS_VCSC_UseGoogleFontManager == "true") {
				$font_stored 					= get_option('ts_vcsc_extend_settings_fontDefaults', '');
				if (($font_stored == false) || (empty($font_stored)) || ($font_stored == "") || (!is_array($font_stored))) {
					$font_stored				= array();
				}
				foreach ($this->TS_VCSC_Fonts_Google as $Font_Network => $font) {
					$font_active				= (isset($font_stored[$Font_Network]['active']) ? ($font_stored[$Font_Network]['active'] == 'on' ? "true" : "false") : $font['active']);
					$font_favorite				= (isset($font_stored[$Font_Network]['favorite']) ? ($font_stored[$Font_Network]['favorite'] == 'on' ? "true" : "false") : $font['favorite']);
					if ($font['variants'] != '') {
						$Font_Variants			= ':' . $font['variants'];
					}
					if ($font_active == "true") {
						if ($font_favorite == "true") {
							$parameter_favorites[]	= $font['google'] . $Font_Variants;
						} else {
							$parameter_selection[]	= $font['google'] . $Font_Variants;
						}
					}
				}
			} else {
				foreach ($this->TS_VCSC_Fonts_Google as $Font_Network => $font) {
					if ($font['variants'] != '') {
						$Font_Variants			= ':' . $font['variants'];
					}
					$parameter_selection[]		= $font['google'] . $Font_Variants;
				}
			}
			echo '<script type="text/javascript">' . "\r\n";
				echo 'var $TS_VCSC_Google_Favorites = ' . json_encode($parameter_favorites) . ';';
				echo 'var $TS_VCSC_Google_Selection = ' . json_encode($parameter_selection) . ';';
			echo '</script>' . "\r\n";
		}
		
		
		// Function to load External Files on Back-End when Editing
		// --------------------------------------------------------
		function TS_VCSC_Extensions_Admin_Files($hook_suffix) {
			global $pagenow, $typenow;
			$screen 		= get_current_screen();
			require_once($this->assets_dir . 'ts_vcsc_registrations_files.php');
			if (empty($typenow) && !empty($_GET['post'])) {
				$post 		= get_post($_GET['post']);
				$typenow 	= $post->post_type;
			}
			$url			= plugin_dir_url( __FILE__ );
			// Files to be loaded on Widgets Page
			if ($pagenow == "widgets.php") {
				if ($this->TS_VCSC_CustomPostTypesWidgets == "true") {
					wp_enqueue_style('ts-visual-composer-extend-widgets');
					wp_enqueue_script('ts-visual-composer-extend-widgets');
				}
			}
			// Files to be loaded with Visual Composer
			if (TS_VCSC_IsEditPagePost()) {
				if ($this->TS_VCSC_CustomPostTypesLoaded == "true") {
					wp_enqueue_script('jquery-ui-sortable');
				}
				if (($this->TS_VCSC_EditorVisualSelector == "true") || ($this->TS_VCSC_IconicumActivated == "true") || ($this->TS_VCSC_IconicumMenuGenerator == "true")) {
					foreach ($this->TS_VCSC_Installed_Icon_Fonts as $Icon_Font => $iconfont) {
						$default = ($iconfont == "Awesome" ? 1 : 0);
						if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && ($iconfont != "Custom")) {
							wp_enqueue_style('ts-font-' . strtolower($iconfont));
						} else if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && ($iconfont == "Custom")) {
							$Custom_Font_CSS = get_option('ts_vcsc_extend_settings_tinymceCustomPath', '');
							wp_enqueue_style('ts-font-' . strtolower($iconfont) . 'vcsc');
						}
					}
					if ($this->TS_VCSC_EditorIconFontsInternal == "true") {
						foreach ($this->TS_VCSC_Composer_Icon_Fonts as $Icon_Font => $iconfont) {							
							if (get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, 0) == 1) {								
								if (strtolower($iconfont) == "vc_awesome") {
									wp_enqueue_style('font-awesome');
								} else {
									wp_enqueue_style(strtolower($iconfont));
								}
							}
						}
					}
				}
				wp_enqueue_style('ts-font-teammates');
				wp_enqueue_style('ts-visual-composer-extend-composer');
				if ($this->TS_VCSC_EditorLivePreview == "true") {
					wp_enqueue_style('ts-visual-composer-extend-preview');
				} else {
					wp_enqueue_style('ts-visual-composer-extend-basic');
				}
				wp_enqueue_style('ts-extend-nouislider');
				wp_enqueue_style('ts-extend-multiselect');
				wp_enqueue_script('ts-extend-nouislider');
				wp_enqueue_script('ts-extend-multiselect');
				wp_enqueue_script('ts-extend-toggles');
				wp_enqueue_script('ts-extend-picker');
				wp_enqueue_style('ts-visual-composer-extend-admin');
				wp_enqueue_style('ts-visual-composer-extend-elements');
				wp_enqueue_script('ts-visual-composer-extend-admin');
				// Load Custom Backbone View and Files for Rows
				if ($this->TS_VCSC_VCFrontEditMode == "false") {
					if (((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_additions', 1) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 0))) {
						if (get_option('ts_vcsc_extend_settings_additionsRows', 0) == 1) {
							wp_enqueue_script('ts-vcsc-backend-rows');
							wp_enqueue_style('ts-extend-colorpicker');
							wp_enqueue_script('ts-extend-colorpicker');
							wp_enqueue_style('ts-extend-classygradient');
							wp_enqueue_script('ts-extend-classygradient');
						}
					}
					if ((isset($this->TS_VCSC_Visual_Composer_Elements["TS Page Background"]) && ($this->TS_VCSC_Visual_Composer_Elements["TS Page Background"]["active"] == "true")) || (isset($this->TS_VCSC_Visual_Composer_Elements["TS SlitSlider"]) && ($this->TS_VCSC_Visual_Composer_Elements["TS SlitSlider"]["active"] == "true"))) {
						wp_enqueue_style('ts-extend-colorpicker');
						wp_enqueue_script('ts-extend-colorpicker');
						wp_enqueue_style('ts-extend-classygradient');
						wp_enqueue_script('ts-extend-classygradient');
					}
				} else if ($this->TS_VCSC_VCFrontEditMode == "true") {
					if (((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_additions', 1) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 0))) {
						if (get_option('ts_vcsc_extend_settings_additionsRows', 0) == 1) {
							wp_enqueue_style('ts-extend-colorpicker');
							wp_enqueue_script('ts-extend-colorpicker');
							wp_enqueue_style('ts-extend-classygradient');
							wp_enqueue_script('ts-extend-classygradient');
						}
					}
					if ((isset($this->TS_VCSC_Visual_Composer_Elements["TS Page Background"]) && ($this->TS_VCSC_Visual_Composer_Elements["TS Page Background"]["active"] == "true")) || (isset($this->TS_VCSC_Visual_Composer_Elements["TS SlitSlider"]) && ($this->TS_VCSC_Visual_Composer_Elements["TS SlitSlider"]["active"] == "true"))) {
						wp_enqueue_style('ts-extend-colorpicker');
						wp_enqueue_script('ts-extend-colorpicker');
						wp_enqueue_style('ts-extend-classygradient');
						wp_enqueue_script('ts-extend-classygradient');
					}
				}
				if ($this->TS_VCSC_VCFrontEditMode == "false") {
					// Load Custom Backbone View for Other Elements
					if ($this->TS_VCSC_EditorLivePreview == "true") {
						wp_enqueue_script('ts-vcsc-backend-other');
					} else if (($this->TS_VCSC_Visual_Composer_Elements['TS Fancy Tabs (BETA)']['active'] == 'true') || ($this->TS_VCSC_Visual_Composer_Elements['TS Image Hotspot']['active'] == 'true')) {
						wp_enqueue_script('ts-vcsc-backend-basic');
					}
				}
				if ($this->TS_VCSC_VCFrontEditMode == "true") {
					wp_enqueue_style('ts-visual-composer-extend-editor');
				}
				if ($this->TS_VCSC_IconicumStandard == "false") {
					if ($this->TS_VCSC_IconicumActivated == "true") {
						wp_enqueue_style('wp-color-picker');
						wp_enqueue_script('ts-extend-lightboxme');
						wp_enqueue_script('ts-extend-zclip');
						wp_enqueue_script('ts-extend-rainbow');
						wp_enqueue_style('ts-visual-composer-extend-generator');
					} else if ($this->TS_VCSC_IconicumMenuGenerator == "true") {
						wp_enqueue_style('ts-visual-composer-extend-generator');
					}
				}
			}
			// Files to be loaded for Plugin Settings
			global $ts_vcsc_main_page;
			global $ts_vcsc_settings_page;
			global $ts_vcsc_upload_page;
			global $ts_vcsc_preview_page;
			global $ts_vcsc_generator_page;
			global $ts_vcsc_customCSS_page;
			global $ts_vcsc_customJS_page;
			global $ts_vcsc_transfer_page;
			global $ts_vcsc_system_page;
			global $ts_vcsc_license_page;
			global $ts_vcsc_about_page;
			global $ts_vcsc_google_fonts;
			global $ts_vcsc_enlighterjs_page;
			global $ts_vcsc_update_page;
			if (($ts_vcsc_main_page == $hook_suffix) || ($ts_vcsc_settings_page == $hook_suffix) || ($ts_vcsc_upload_page == $hook_suffix) || ($ts_vcsc_preview_page == $hook_suffix) || ($ts_vcsc_customCSS_page == $hook_suffix) || ($ts_vcsc_customJS_page == $hook_suffix) || ($ts_vcsc_system_page == $hook_suffix) || ($ts_vcsc_transfer_page == $hook_suffix) || ($ts_vcsc_license_page == $hook_suffix) || ($ts_vcsc_about_page == $hook_suffix) || ($ts_vcsc_google_fonts == $hook_suffix) || ($ts_vcsc_enlighterjs_page == $hook_suffix)) {
				if (!wp_script_is('jquery')) {
					wp_enqueue_script('jquery');
				}
				if (($ts_vcsc_main_page == $hook_suffix) || ($ts_vcsc_settings_page == $hook_suffix) || ($ts_vcsc_enlighterjs_page == $hook_suffix)) {
					wp_enqueue_style('wp-color-picker');					
					//wp_enqueue_script('iris');
					//wp_enqueue_script('wp-color-picker');					
					wp_enqueue_script('wp-color-picker-alpha');					
					if ($ts_vcsc_enlighterjs_page != $hook_suffix) {
						wp_enqueue_script('ts-extend-dragsort');
					}
					wp_enqueue_style('ts-extend-nouislider');
					wp_enqueue_script('ts-extend-nouislider');
					wp_enqueue_style('ts-visual-composer-extend-admin');
					wp_enqueue_script('ts-extend-toggles');
				}
				if ($ts_vcsc_upload_page == $hook_suffix) {
					if (get_option('ts_vcsc_extend_settings_tinymceCustomPath', '') != '') {
						wp_enqueue_style('ts-font-customvcsc');
					}
					wp_enqueue_style('ts-visual-composer-extend-admin');
					wp_enqueue_script('ts-visual-composer-extend-admin');
				}
				if (($ts_vcsc_upload_page == $hook_suffix) || ($ts_vcsc_preview_page == $hook_suffix)) {
					wp_enqueue_style('ts-extend-dropdown');
					wp_enqueue_script('ts-extend-dropdown');
					wp_enqueue_script('ts-extend-freewall');
					wp_enqueue_style('ts-visual-composer-extend-admin');
				}
				if ($ts_vcsc_about_page == $hook_suffix) {
					wp_enqueue_script('ts-extend-slidesjs');
				}
				wp_enqueue_style('dashicons');
				wp_enqueue_style('ts-font-teammates');				
				wp_enqueue_style('ts-extend-messi');
				wp_enqueue_script('ts-extend-messi');
				wp_enqueue_style('ts-extend-uitotop');
				wp_enqueue_script('ts-extend-uitotop');
				wp_enqueue_script('jquery-easing');
				if ($ts_vcsc_enlighterjs_page != $hook_suffix) {
					wp_enqueue_style('ts-vcsc-extend');
					wp_enqueue_script('ts-vcsc-extend');
				}
				wp_enqueue_script('validation-engine');
				wp_enqueue_style('validation-engine');
				wp_enqueue_script('validation-engine-en');
			}
			if (($ts_vcsc_generator_page == $hook_suffix) && ($this->TS_VCSC_IconicumStandard == "false")) {
				foreach ($this->TS_VCSC_Installed_Icon_Fonts as $Icon_Font => $iconfont) {
					$default = ($iconfont == "Awesome" ? 1 : 0);
					if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && ($iconfont != "Custom") && ($iconfont != "Dashicons")) {
						wp_enqueue_style('ts-font-' . strtolower($iconfont));
					} else if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && ($iconfont != "Custom") && ($iconfont == "Dashicons")) {
						wp_enqueue_style('dashicons');
						wp_enqueue_style('ts-font-' . strtolower($iconfont));
					} else if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && ($iconfont == "Custom")) {
						$Custom_Font_CSS = get_option('ts_vcsc_extend_settings_tinymceCustomPath', '');
						wp_enqueue_style('ts-font-' . strtolower($iconfont) . 'vcsc');
					}
				}
				if ($this->TS_VCSC_EditorIconFontsInternal == "true") {
					foreach ($this->TS_VCSC_Composer_Icon_Fonts as $Icon_Font => $iconfont) {
						if (get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, 0) == 1) {
							if (strtolower($iconfont) == "vc_awesome") {
								wp_enqueue_style('font-awesome');
							} else {
								wp_enqueue_style(strtolower($iconfont));
							}
						}
					}
				}
				wp_enqueue_style('ts-vcsc-extend');
				wp_enqueue_script('ts-vcsc-extend');
				wp_enqueue_style('ts-visual-composer-extend-admin');
				wp_enqueue_style('ts-extend-uitotop');
				wp_enqueue_script('ts-extend-uitotop');
				wp_enqueue_script('jquery-easing');
				wp_enqueue_style('ts-extend-nouislider');
				wp_enqueue_script('ts-extend-nouislider');
				wp_enqueue_script('ts-extend-toggles');
				wp_enqueue_script('ts-extend-rainbow');
				wp_enqueue_script('ts-extend-zclip');
				wp_enqueue_style('wp-color-picker');
				wp_enqueue_style('ts-extend-simptip');
				wp_enqueue_style('ts-extend-animations');
				wp_enqueue_style('ts-visual-composer-extend-generator');
				wp_enqueue_script('ts-visual-composer-extend-generator');
			}
			if ($ts_vcsc_preview_page == $hook_suffix) {
				foreach ($this->TS_VCSC_Installed_Icon_Fonts as $Icon_Font => $iconfont) {
					$default = ($iconfont == "Awesome" ? 1 : 0);
					if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && ($iconfont != "Custom") && ($iconfont != "Dashicons")) {
						wp_enqueue_style('ts-font-' . strtolower($iconfont));
					} else if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && ($iconfont != "Custom") && ($iconfont == "Dashicons")) {
						wp_enqueue_style('dashicons');
						wp_enqueue_style('ts-font-' . strtolower($iconfont));
					} else if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && ($iconfont == "Custom")) {
						$Custom_Font_CSS = get_option('ts_vcsc_extend_settings_tinymceCustomPath', '');
						wp_enqueue_style('ts-font-' . strtolower($iconfont) . 'vcsc');
					}
				}
				if ($this->TS_VCSC_EditorIconFontsInternal == "true") {
					foreach ($this->TS_VCSC_Composer_Icon_Fonts as $Icon_Font => $iconfont) {
						if (get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, 0) == 1) {
							if (strtolower($iconfont) == "vc_awesome") {
								wp_enqueue_style('font-awesome');
							} else {
								wp_enqueue_style(strtolower($iconfont));
							}
						}
					}
				}
				wp_enqueue_style('ts-visual-composer-extend-admin');
				wp_enqueue_script('ts-visual-composer-extend-admin');
			}
			if (($ts_vcsc_system_page == $hook_suffix) || ($ts_vcsc_transfer_page == $hook_suffix) || ($ts_vcsc_about_page == $hook_suffix)) {
				wp_enqueue_style('ts-visual-composer-extend-admin');
				wp_enqueue_script('ts-visual-composer-extend-admin');				
			}
			if ($ts_vcsc_google_fonts == $hook_suffix) {
				wp_enqueue_style('ts-visual-composer-extend-admin');
				wp_enqueue_style('ts-visual-composer-extend-google');
				wp_enqueue_script('ts-visual-composer-extend-google');
			}
			if ($ts_vcsc_settings_page == $hook_suffix) {
				wp_enqueue_media();
			}
			if ($ts_vcsc_license_page == $hook_suffix) {
				wp_enqueue_style('ts-visual-composer-extend-admin');
			}
			if (($ts_vcsc_customCSS_page == $hook_suffix) || ($ts_vcsc_customJS_page == $hook_suffix)) {
				wp_enqueue_script('ace_code_highlighter_js', 	                $url.'assets/ACE/ace.js', '', false, true );
			}
			if ($ts_vcsc_customCSS_page == $hook_suffix) {
				wp_enqueue_script('ace_mode_css',                               $url.'assets/ACE/mode-css.js', array('ace_code_highlighter_js'), false, true );
				wp_enqueue_script('custom_css_js', 		                		$url.'assets/ACE/custom-css.js', array( 'jquery', 'ace_code_highlighter_js' ), false, true );
				wp_enqueue_style('ts-vcsc-extend');
				wp_enqueue_style('ts-visual-composer-extend-admin');
			}
			if ($ts_vcsc_customJS_page == $hook_suffix) {
				wp_enqueue_script('ace_mode_js',                                $url.'assets/ACE/mode-javascript.js', array('ace_code_highlighter_js'), false, true );
				wp_enqueue_script('custom_js_js',                               $url.'assets/ACE/custom-js.js', array( 'jquery', 'ace_code_highlighter_js' ), false, true );
				wp_enqueue_style('ts-vcsc-extend');
				wp_enqueue_style('ts-visual-composer-extend-admin');
			}
			if ($ts_vcsc_enlighterjs_page == $hook_suffix) {
				wp_enqueue_script('ts-library-mootools');
				wp_enqueue_style('ts-extend-enlighterjs');				
				wp_enqueue_script('ts-extend-enlighterjs');				
				wp_enqueue_style('ts-extend-syntaxinit');
				wp_enqueue_script('ts-extend-syntaxinit');
				wp_enqueue_style('ts-extend-themebuilder');	
				wp_enqueue_script('ts-extend-themebuilder');
			}
			// Files to be loaded for Update Notification
			if ($ts_vcsc_update_page == $hook_suffix) {
				wp_enqueue_style('dashicons');
				wp_enqueue_style('ts-visual-composer-extend-admin');
				wp_enqueue_script('ts-visual-composer-extend-admin');
				wp_enqueue_style('ts-vcsc-extend');
				wp_enqueue_script('ts-vcsc-extend');
			}
		}
		function TS_VCSC_Extensions_Admin_Variables() {
			$this->TS_VCSC_Extensions_Create_Variables();
			$this->TS_VCSC_Extensions_Create_GoogleFontArray();
		}
		function TS_VCSC_Extensions_Admin_Head() {
			global $pagenow, $typenow;
			$screen 		= get_current_screen();
			if (empty($typenow) && !empty($_GET['post'])) {
				$post 		= get_post($_GET['post']);
				$typenow 	= $post->post_type;
			}
			$url			= plugin_dir_url( __FILE__ );
			if (($this->TS_VCSC_UseEnlighterJS == "true") && ($this->TS_VCSC_UseThemeBuider == "true")) {
				if (strpos($screen->id, 'TS_VCSC_EnlighterJS') !== false) {
					echo '<script>';
						echo 'var $Theme_Template = "' . $this->templates_dir . 'ts-enlighter-template.css";';
					echo '</script>';
					echo '<style id="ts-enlighterjs-custom-theme-css" type="text/css">';
						TS_VCSC_GenerateCustomCSS();
					echo '</style>';
				}
			}
		}
		
		
		// Function to load External Files on Front-End
		// --------------------------------------------
		function TS_VCSC_Extensions_Front_Main() {
			global $post;
			global $wp_query;
			$url = plugin_dir_url( __FILE__ );
			require_once($this->assets_dir . 'ts_vcsc_registrations_files.php');
			// Check For Standard Frontend Page
			if (!is_404() && !is_search() && !is_archive()) {
				$TS_VCSC_StandardFrontendPage		= "true";
			} else {
				$TS_VCSC_StandardFrontendPage		= "false";
			}
			// Load Scripts As Needed
			if (!empty($post)){
				// Output of Custom CSS / JS
				$TS_VCSC_CustomCodeOutput			= "false";
				// Check for Standard Shortcodes
				if ((stripos($post->post_content, '[TS-VCSC-') !== FALSE) || (stripos($post->post_content, '[TS_VCSC_') !== FALSE)) {
					$TS_VCSC_StandardShorcodes		= "true";
				} else {
					$TS_VCSC_StandardShorcodes		= "false";
				}
				// Check for EnlighterJS Shortcodes
				if (stripos($post->post_content, '[TS_EnlighterJS_') !== FALSE) {
					$TS_VCSC_EnlighterShorcodes		= "true";
				} else {
					$TS_VCSC_EnlighterShorcodes		= "false";
				}
				// Define Ajax Path Variable
				/*if (stripos($post->post_content, '[TS_VCSC_Timeline_CSS_Container') !== FALSE) {
					wp_enqueue_style('ts-visual-composer-extend-ajax', 		$url . '/css/ts-visual-composer-extend-ajax.css', null, false, 'all');
					wp_enqueue_script('ts-visual-composer-extend-ajax', 	$url . '/js/ts-visual-composer-extend-ajax.js', array('jquery'), false, true);
					wp_localize_script('ts-visual-composer-extend-ajax', 	'$TS_VCSC_AjaxData', array(
						'ajaxurl' 		=> admin_url('admin-ajax.php'),
						'queryvars' 	=> json_encode($wp_query->query)
					));
				}*/
				if ($this->TS_VCSC_UseSmoothScroll == "true") {
					wp_enqueue_script('ts-extend-mousewheel');
				}
				if ((($this->TS_VCSC_LoadFrontEndLightbox == "true") || ((get_option('ts_vcsc_extend_settings_lightboxIntegration', 0) == 1))) && ($TS_VCSC_StandardFrontendPage == "true") && ($this->TS_VCSC_UseInternalLightbox == "true") && ($this->TS_VCSC_VCFrontEditMode == "false")) {
					wp_enqueue_script('ts-extend-hammer');
					wp_enqueue_script('ts-extend-nacho');
					wp_enqueue_style('ts-extend-nacho');
				}
				if (($this->TS_VCSC_LoadFrontEndTooltips == "true") && ($TS_VCSC_StandardFrontendPage == "true") && ($this->TS_VCSC_VCFrontEditMode == "false")) {
					wp_enqueue_style('ts-extend-simptip');
					wp_enqueue_style('ts-extend-tooltipster');
					wp_enqueue_script('ts-extend-tooltipster');	
				}
				if (get_option('ts_vcsc_extend_settings_loadFonts', 0) == 1) {
					// Add CSS for each enabled Font to WordPress Frontend
					foreach ($this->TS_VCSC_Installed_Icon_Fonts as $Icon_Font => $iconfont) {
						$default = ($iconfont == "Awesome" ? 1 : 0);
						if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && (get_option('ts_vcsc_extend_settings_load' . $iconfont, 0) == 1) && ($iconfont != "Custom") && ($iconfont != "Dashicons")) {
							wp_enqueue_style('ts-font-' . strtolower($iconfont));
						} else if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && (get_option('ts_vcsc_extend_settings_load' . $iconfont, 0) == 1) && ($iconfont != "Custom") && ($iconfont == "Dashicons")) {
							wp_enqueue_style('dashicons');
							wp_enqueue_style('ts-font-' . strtolower($iconfont));
						} else if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && (get_option('ts_vcsc_extend_settings_load' . $iconfont, 0) == 1) && ($iconfont == "Custom")) {
							$Custom_Font_CSS = get_option('ts_vcsc_extend_settings_tinymceCustomPath', '');
							wp_enqueue_style('ts-font-' . strtolower($iconfont) . 'vcsc');
						}
					}
					if ($this->TS_VCSC_EditorIconFontsInternal == "true") {
						foreach ($this->TS_VCSC_Composer_Icon_Fonts as $Icon_Font => $iconfont) {
							if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, 0) == 1) && (get_option('ts_vcsc_extend_settings_load' . $iconfont, 0) == 1)) {
								if (strtolower($iconfont) == "vc_awesome") {
									wp_enqueue_style('font-awesome');
								} else {
									wp_enqueue_style(strtolower($iconfont));
								}
							}
						}
					}
				}
				/* Force Load of Core Files */
				if (($this->TS_VCSC_LoadFrontEndForcable == "true") && ($TS_VCSC_StandardFrontendPage == "true")) {
					// Load jQuery (if not already loaded)
					if (($this->TS_VCSC_LoadFrontEndJQuery == "true") && (!wp_script_is('jquery'))) {
						wp_enqueue_script('jquery');
					}
					// Load Google Charts API
					if ((TS_VCSC_CheckShortcode('TS-VCSC-Google-Charts') == "true") || (TS_VCSC_CheckShortcode('TS-VCSC-Google-Tables') == "true")) {
						wp_enqueue_script('ts-extend-google-charts');
					}
					if ($this->TS_VCSC_VCFrontEditMode == "false") {
						// Load Modernizr
						if ($this->TS_VCSC_LoadFrontEndModernizr == "true") {
							wp_enqueue_script('ts-extend-modernizr');
						}
						// Load Waypoints
						if ($this->TS_VCSC_LoadFrontEndWaypoints == "true") {
							if (wp_script_is('waypoints', $list = 'registered')) {
								wp_enqueue_script('waypoints');
							} else {
								wp_enqueue_script('ts-extend-waypoints');
							}
						}
					}
					// Add CSS for each enabled Icon Font to Page
					$this->TS_VCSC_Extensions_Front_Fonts();
					// Add custom CSS / JS to Page
					if ($this->TS_VCSC_UseCodeEditors == "true") {
						add_action('wp_head', 		array($this, 'TS_VCSC_DisplayCustomCSS'));
						add_action('wp_footer', 	array($this, 'TS_VCSC_DisplayCustomJS'), 9999);
						$TS_VCSC_CustomCodeOutput	= "true";
					}
					// Load Other Required Files
					if ($this->TS_VCSC_VCFrontEditMode == "false") {
						wp_enqueue_style('ts-extend-simptip');
						wp_enqueue_style('ts-extend-animations');
						wp_enqueue_style('ts-extend-buttons');
						wp_enqueue_style('ts-extend-buttonsflat');
						wp_enqueue_style('ts-extend-tooltipster');
						wp_enqueue_script('ts-extend-tooltipster');	
						wp_enqueue_style('ts-visual-composer-extend-front');
						wp_enqueue_script('ts-visual-composer-extend-front');
					}
				}
				/* Files if Shortcode Detected or Widgets Activated */
				if ((($TS_VCSC_StandardShorcodes == "true" || $TS_VCSC_EnlighterShorcodes == "true") && ($TS_VCSC_StandardFrontendPage == "true")) || (($this->TS_VCSC_CustomPostTypesWidgets == "true") && ($TS_VCSC_StandardFrontendPage == "true"))) { 
					// Load jQuery (if not already loaded)
					if (($this->TS_VCSC_LoadFrontEndJQuery == "true") && (!wp_script_is('jquery'))) {
						wp_enqueue_script('jquery');
					}
					// Load MooTools (for EnlighterJS)
					if (($this->TS_VCSC_LoadFrontEndMooTools == "true") && ($TS_VCSC_EnlighterShorcodes == "true")) {
						wp_enqueue_script('ts-library-mootools');
					}
					// Load Google Charts API
					if ((TS_VCSC_CheckShortcode('TS-VCSC-Google-Charts') == "true") || (TS_VCSC_CheckShortcode('TS-VCSC-Google-Tables') == "true")) {
						wp_enqueue_script('ts-extend-google-charts');
					}
					// Add CSS for each enabled Icon Font to Page
					$this->TS_VCSC_Extensions_Front_Fonts();
					if ($this->TS_VCSC_VCFrontEditMode == "false") {
						// Load Modernizr
						if ($this->TS_VCSC_LoadFrontEndModernizr == "true") {
							wp_enqueue_script('ts-extend-modernizr');						
						}
						// Load Waypoints
						if ($this->TS_VCSC_LoadFrontEndWaypoints == "true") {
							if (wp_script_is('waypoints', $list = 'registered')) {
								wp_enqueue_script('waypoints');
							} else {
								wp_enqueue_script('ts-extend-waypoints');
							}
						}
					}
					// Add Custom CSS / JS to Page
					if ($this->TS_VCSC_UseCodeEditors == "true") {
						add_action('wp_head', 		array($this, 'TS_VCSC_DisplayCustomCSS'));
						add_action('wp_footer', 	array($this, 'TS_VCSC_DisplayCustomJS'), 9999);
						$TS_VCSC_CustomCodeOutput	= "true";
					}
				} else {
					// Add CSS for each enabled Font
					foreach ($this->TS_VCSC_Installed_Icon_Fonts as $Icon_Font => $iconfont) {
						$default = ($iconfont == "Awesome" ? 1 : 0);
						if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && (get_option('ts_vcsc_extend_settings_load' . $iconfont, 0) == 1) && ($iconfont != "Custom") && ($iconfont != "Dashicons")) {
							wp_enqueue_style('ts-font-' . strtolower($iconfont));
						} else if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && (get_option('ts_vcsc_extend_settings_load' . $iconfont, 0) == 1) && ($iconfont != "Custom") && ($iconfont == "Dashicons")) {
							wp_enqueue_style('dashicons');
							wp_enqueue_style('ts-font-' . strtolower($iconfont));
						} else if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && (get_option('ts_vcsc_extend_settings_load' . $iconfont, 0) == 1) && ($iconfont == "Custom")) {
							$Custom_Font_CSS = get_option('ts_vcsc_extend_settings_tinymceCustomPath', '');
							wp_enqueue_style('ts-font-' . strtolower($iconfont) . 'vcsc');
						}
					}
					if ($this->TS_VCSC_EditorIconFontsInternal == "true") {
						foreach ($this->TS_VCSC_Composer_Icon_Fonts as $Icon_Font => $iconfont) {
							if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, 0) == 1) && (get_option('ts_vcsc_extend_settings_load' . $iconfont, 0) == 1)) {
								if (strtolower($iconfont) == "vc_awesome") {
									wp_enqueue_style('font-awesome');
								} else {
									wp_enqueue_style(strtolower($iconfont));
								}
							}
						}
					}
				}
				if ($TS_VCSC_CustomCodeOutput == "false") {
					add_action('wp_head', 			array($this, 'TS_VCSC_DisplayCustomCSS'));
					add_action('wp_footer', 		array($this, 'TS_VCSC_DisplayCustomJS'), 9999);
					$TS_VCSC_CustomCodeOutput		= "true";
				}
			}
		}
		function TS_VCSC_Extensions_Front_Head() {
			global $post;
			// Check For Standard Frontend Page
			if (!is_404() && !is_search() && !is_archive()) {
				$TS_VCSC_StandardFrontendPage		= "true";
			} else {
				$TS_VCSC_StandardFrontendPage		= "false";
			}
			if ((!empty($post)) && (get_option('ts_vcsc_extend_settings_loadForcable', 0) == 1)){
				if ((stripos($post->post_content, '[TS-VCSC-') !== FALSE) || (stripos($post->post_content, '[TS_VCSC_') !== FALSE) || (get_option('ts_vcsc_extend_settings_loadForcable', 0) == 1)) { 
					$url 		= plugin_dir_url( __FILE__ );
					$includes 	= includes_url();
					if (get_option('ts_vcsc_extend_settings_loadjQuery', 0) == 1) {
						echo '<script data-cfasync="false" type="text/javascript" src="' . $includes . 'js/jquery/jquery.js"></script>';
						echo '<script data-cfasync="false" type="text/javascript" src="' . $includes . 'js/jquery/jquery-migrate.min.js"></script>';
					}
					if (get_option('ts_vcsc_extend_settings_loadEnqueue', 1) == 0) {
						echo '<link rel="stylesheet" id="ts-extend-simptip"  href="' .							$url . 'css/jquery.vcsc.simptip.min.css" type="text/css" media="all" />';
						echo '<link rel="stylesheet" id="ts-extend-tooltipster"  href="' .						$url . 'css/jquery.vcsc.tooltipster.min.css" type="text/css" media="all" />';
						echo '<link rel="stylesheet" id="ts-extend-animations"  href="' .						$url . 'css/ts-visual-composer-extend-animations.min.css" type="text/css" media="all" />';
						echo '<link rel="stylesheet" id="ts-visual-composer-extend-front"  href="' .			$url . 'css/ts-visual-composer-extend-front.min.css" type="text/css" media="all" />';
						if (get_option('ts_vcsc_extend_settings_loadHeader', 0) == 1) {
							echo '<script data-cfasync="false" type="text/javascript" src="' .					$url . 'js/jquery.vcsc.adipoli.min.js"></script>';
							echo '<script data-cfasync="false" type="text/javascript" src="' .					$url . 'js/jquery.vcsc.tooltipster.min,js"></script>';
							if (get_option('ts_vcsc_extend_settings_loadModernizr', 1) == 1) {
								echo '<script data-cfasync="false" type="text/javascript" src="' .				$url . 'js/jquery.vcsc.modernizr.min.js"></script>';
							}
							echo '<script data-cfasync="false" type="text/javascript" src="' .					$url . 'js/ts-visual-composer-extend-front.min.js"></script>';
						}
					}
				}
			}
			if (($this->TS_VCSC_UseEnlighterJS == "true") && ($this->TS_VCSC_UseThemeBuider == "true")) {
				if (!empty($post)) {
					if (((stripos($post->post_content, '[TS_EnlighterJS') !== FALSE)) && ($TS_VCSC_StandardFrontendPage == "true")) { 
						$url 		= plugin_dir_url( __FILE__ );
						$includes 	= includes_url();
						echo '<style id="ts-enlighterjs-custom-theme-css" type="text/css">';
							TS_VCSC_GenerateCustomCSS();
						echo '</style>';
					}
				}
			}
			if ((!empty($post)) && (get_option('ts_vcsc_extend_settings_lightboxIntegration', 0) == 1) && ($this->TS_VCSC_VCFrontEditMode == "false")){
				echo '<script type="text/javascript">' . "\r\n";
					echo '(function ($) { ' . "\r\n";
						echo '$(document).ready(function () {' . "\r\n";
							echo 'if (typeof jQuery.fn.nchlightbox !== "undefined") {' . "\r\n";	
								echo 'jQuery(".ts-lightbox-integration").nchlightbox();' . "\r\n";	
							echo '};' . "\r\n";
						echo '});' . "\r\n";
					echo '})(jQuery);' . "\r\n";
				echo '</script>' . "\r\n";
			}
		}
		function TS_VCSC_Extensions_Front_Footer() {
			global $post;
			$url 		= plugin_dir_url( __FILE__ );
			$includes 	= includes_url();
			if ((!empty($post)) || (get_option('ts_vcsc_extend_settings_loadForcable', 0) == 1)){
				if ((stripos($post->post_content, '[TS-VCSC-') !== FALSE) || (stripos($post->post_content, '[TS_VCSC_') !== FALSE) || (get_option('ts_vcsc_extend_settings_loadForcable', 0) == 1)) { 
					if (get_option('ts_vcsc_extend_settings_loadEnqueue', 1) == 0) {
						if (get_option('ts_vcsc_extend_settings_loadHeader', 0) == 0) {
							echo '<script data-cfasync="false" type="text/javascript" src="' .					$url . 'js/jquery.vcsc.adipoli.min.js"></script>';
							echo '<script data-cfasync="false" type="text/javascript" src="' .					$url . 'js/jquery.vcsc.tooltipster.min,js"></script>';
							if (get_option('ts_vcsc_extend_settings_loadModernizr', 1) == 1) {
								echo '<script data-cfasync="false" type="text/javascript" src="' .				$url . 'js/jquery.vcsc.modernizr.min.js"></script>';
							}
							echo '<script data-cfasync="false" type="text/javascript" src="' .					$url . 'js/ts-visual-composer-extend-front.min.js"></script>';
						}
					}
				}
			}
		}
		function TS_VCSC_Extensions_Front_Variables() {
			global $post;
			if (!empty($post)){
				$this->TS_VCSC_Extensions_Create_Variables();
			}
		}
		function TS_VCSC_Extensions_Front_Fonts() {
			// Add CSS for each enabled Font
			foreach ($this->TS_VCSC_Installed_Icon_Fonts as $Icon_Font => $iconfont) {
				$default = ($iconfont == "Awesome" ? 1 : 0);
				if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && ($iconfont != "Custom") && ($iconfont != "Dashicons")) {
					wp_enqueue_style('ts-font-' . strtolower($iconfont));
				} else if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && ($iconfont != "Custom") && ($iconfont == "Dashicons")) {
					wp_enqueue_style('dashicons');
					wp_enqueue_style('ts-font-' . strtolower($iconfont));
				} else if ((get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, $default) == 1) && ($iconfont == "Custom")) {
					$Custom_Font_CSS = get_option('ts_vcsc_extend_settings_tinymceCustomPath', '');
					wp_enqueue_style('ts-font-' . strtolower($iconfont) . 'vcsc');
				}
			}
			if ($this->TS_VCSC_EditorIconFontsInternal == "true") {
				foreach ($this->TS_VCSC_Composer_Icon_Fonts as $Icon_Font => $iconfont) {
					if (get_option('ts_vcsc_extend_settings_tinymce' . $iconfont, 0) == 1) {
						if (strtolower($iconfont) == "vc_awesome") {
							wp_enqueue_style('font-awesome');
						} else {
							wp_enqueue_style(strtolower($iconfont));
						}
					}
				}
			}
		}
		
		
		// Add Dashboard Widget
		// --------------------
		function TS_VCSC_DashboardHelpWidget() {
			global $wp_meta_boxes;
			wp_add_dashboard_widget('TS_VCSC_DashboardHelp', 'Composium - Visual Composer Extensions', array($this, 'TS_VCSC_DashboardHelpContent'));
		}
		function TS_VCSC_DashboardHelpContent() {
			$output = '';
			$output .= '<p><strong>Welcome to "Composium - Visual Composer Extensions"!</strong></p>';
			if ((function_exists('get_plugin_data'))) {
				$output .= '<p>Current Version: ' . TS_VCSC_GetPluginVersion();
			}
			if (function_exists('is_multisite') && is_multisite()) {
				$output .= '<p>Multisite Environment: Yes</p>';
				$output .= '<p>Plugin Activated Network Wide: ' . ($this->TS_VCSC_PluginIsMultiSiteActive == "true" ? "Yes" : "No") . '</p>';
			} else {
				$output .= '<p>Multisite Environment: No</p>';
			}			
			$output .= '<p>Available Elements: ' . $this->TS_VCSC_CountTotalElements . ' / <span style="font-weight: bold; color: #0078CE;">Active Elements: ' . $this->TS_VCSC_CountActiveElements . '</span></p>';			
			if ($this->TS_VCSC_EditorIconFontsInternal == "true") {
				$TS_VCSC_TotalIconFontsInstalled = (count($this->TS_VCSC_Installed_Icon_Fonts) + count($this->TS_VCSC_Composer_Icon_Fonts));
			} else {
				$TS_VCSC_TotalIconFontsInstalled = count($this->TS_VCSC_Installed_Icon_Fonts);
			}
			if (get_option('ts_vcsc_extend_settings_tinymceCustomArray', '') != '') {
				$output .= '<p>Available Fonts: ' . $TS_VCSC_TotalIconFontsInstalled . ' / <span style="font-weight: bold; color: #0078CE;">Active Fonts: ' . $this->TS_VCSC_Active_Icon_Fonts . '</span></p>';
			} else {
				$output .= '<p>Available Fonts: ' . ($TS_VCSC_TotalIconFontsInstalled - 1) . ' / <span style="font-weight: bold; color: #0078CE;">Active Fonts: ' . $this->TS_VCSC_Active_Icon_Fonts . '</span></p>';
			}
			$output .= '<p>Available Icons: ' . number_format($this->TS_VCSC_Total_Icon_Count) . ' / <span style="font-weight: bold; color: #0078CE;">Active Icons: ' . number_format($this->TS_VCSC_Active_Icon_Count) . '</span></p>';
			$output .= 'You will find the manual here:<br/><a href="http://tekanewascripts.com/vcextensions/documentation/" target="_blank">http://tekanewascripts.com/vcextensions/documentation/</a></p>';
			if (get_option('ts_vcsc_extend_settings_extended', 0) == 1) {
				$output .= '<p style="text-align: justify;">Need more help? Please contact the developer of your theme as it includes this plugin via extended license.<br/><br/>';
			} else {
				$output .= '<p style="text-align: justify;">Need more help? Please open a ticket in our support forum:<br/><a href="http://helpdesk.tekanewascripts.com/" target="_blank">http://helpdesk.tekanewascripts.com/</a><br/><br/>';
			}			
			echo $output;
		}
		
		
		// Load Composer Shortcodes + Elements + Add Custom Parameters
		// -----------------------------------------------------------
		function TS_VCSC_RegisterAllShortcodes() {
			if (function_exists('vc_is_inline')){
				if (vc_is_inline() == true) {
					$this->TS_VCSC_VCFrontEditMode 				= "true";
				} else {
					if ((vc_is_inline() == NULL) || (vc_is_inline() == '')) {
						if (TS_VCSC_CheckFrontEndEditor() == true) {
							$this->TS_VCSC_VCFrontEditMode 		= "true";
						} else {
							$this->TS_VCSC_VCFrontEditMode 		= "false";
						}	
					} else {
						$this->TS_VCSC_VCFrontEditMode 			= "false";
					}
				}
			} else {
				$this->TS_VCSC_VCFrontEditMode 					= "false";
			}
			// Standard Element Settings
			$TS_VCSC_Extension_Elements 			= get_option('ts_vcsc_extend_settings_StandardElements', '');
			if ($TS_VCSC_Extension_Elements == '') {
				$TS_VCSC_Options_Check 				= "true";
			} else {
				$TS_VCSC_Options_Check 				= "false";
			}
			foreach ($this->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
				$defaultstatus 	= ($element['default'] == "true" ? 1 : 0);
				$key 			= $element['setting'];
				$this->TS_VCSC_CountTotalElements++;
				if ($TS_VCSC_Options_Check == "true") {
					// Maintain backwards compatibility to settings stored prior to v2.5.0
					if (get_option('ts_vcsc_extend_settings_custom' . $element['setting'],	$defaultstatus) == 1) {
						$this->TS_VCSC_Visual_Composer_Elements[$ElementName]['active'] = "true";
						if (($element['type'] == 'internal') || ($element['type'] == 'demos')) {
							if ($this->TS_VCSC_VCFrontEditMode == "true") {
								require_once($this->shortcode_dir.'ts_vcsc_shortcode_' . $element['file'] . '.php');
							} else if (is_admin() == false) {
								require_once($this->shortcode_dir.'ts_vcsc_shortcode_' . $element['file'] . '.php');
							}							
						}
						$this->TS_VCSC_CountActiveElements++;
					} else {
						$this->TS_VCSC_Visual_Composer_Elements[$ElementName]['active'] = "false";
					}
				} else if ($TS_VCSC_Options_Check == "false") {
					// Retrieve settings stored since or after v2.5.0
					if (array_key_exists($key, $TS_VCSC_Extension_Elements)) {
						if ($TS_VCSC_Extension_Elements[$key] == "1") {							
							$this->TS_VCSC_Visual_Composer_Elements[$ElementName]['active'] = "true";
						} else {
							$this->TS_VCSC_Visual_Composer_Elements[$ElementName]['active'] = "false";
						}
					} else {
						if ($defaultstatus == 1) {$defaultstatus == "true";} else {$defaultstatus == "false";};
						$this->TS_VCSC_Visual_Composer_Elements[$ElementName]['active'] = $defaultstatus;
					}
					if ($this->TS_VCSC_Visual_Composer_Elements[$ElementName]['active'] == "true") {
						$this->TS_VCSC_CountActiveElements++;
						if (($element['type'] == 'internal') || ($element['type'] == 'demos')) {
							if ($this->TS_VCSC_VCFrontEditMode == "true") {
								require_once($this->shortcode_dir.'ts_vcsc_shortcode_' . $element['file'] . '.php');
							} else if (is_admin() == false) {
								require_once($this->shortcode_dir.'ts_vcsc_shortcode_' . $element['file'] . '.php');
							}							
						}
					}
				} else {
					$this->TS_VCSC_Visual_Composer_Elements[$ElementName]['active'] = "false";
				}
			}
			// WooCommerce Elements Settings
			if ($this->TS_VCSC_WooCommerceActive == "true") {
				$TS_VCSC_WooCommerce_Elements = get_option('ts_vcsc_extend_settings_WooCommerceElements', '');
				if ((!is_array($TS_VCSC_WooCommerce_Elements)) || ($TS_VCSC_WooCommerce_Elements == '')) {
					$TS_VCSC_WooCommerce_Elements = array();
				}
				foreach ($this->TS_VCSC_WooCommerce_Elements as $ElementName => $element) {
					$defaultstatus 	= ($element['default'] == "true" ? "true" : "false");
					$key 			= $element['setting'];
					$type			= $element['type'];
					if (($type == "class") || (($type == "internal") && ($this->TS_VCSC_WooCommerceRemove == "false"))) {
						$this->TS_VCSC_CountTotalElements++;
					}					
					if (array_key_exists($key, $TS_VCSC_WooCommerce_Elements)) {
						if ($TS_VCSC_WooCommerce_Elements[$key] == "1") {
							$this->TS_VCSC_WooCommerce_Elements[$ElementName]['active'] = "true";
							if (($type == "class") || (($type == "internal") && ($this->TS_VCSC_WooCommerceRemove == "false"))) {
								$this->TS_VCSC_CountActiveElements++;
							}
						} else {
							$this->TS_VCSC_WooCommerce_Elements[$ElementName]['active'] = "false";
						}
					} else {
						$this->TS_VCSC_WooCommerce_Elements[$ElementName]['active'] = $defaultstatus;
						if ($defaultstatus == "true") {
							if (($type == "class") || (($type == "internal") && ($this->TS_VCSC_WooCommerceRemove == "false"))) {
								$this->TS_VCSC_CountActiveElements++;
							}
						}
					}
				}
			}			
			// bbPress Elements Settings
			if ($this->TS_VCSC_bbPressActive == "true") {
				$TS_VCSC_bbPress_Elements = get_option('ts_vcsc_extend_settings_bbPressElements', '');
				if ((!is_array($TS_VCSC_bbPress_Elements)) || ($TS_VCSC_bbPress_Elements == '')) {
					$TS_VCSC_bbPress_Elements = array();
				}
				foreach ($this->TS_VCSC_bbPress_Elements as $ElementName => $element) {
					$defaultstatus 	= ($element['default'] == "true" ? "true" : "false");
					$key 			= $element['setting'];
					$this->TS_VCSC_CountTotalElements++;
					if (array_key_exists($key, $TS_VCSC_bbPress_Elements)) {
						if ($TS_VCSC_bbPress_Elements[$key] == "1") {
							$this->TS_VCSC_bbPress_Elements[$ElementName]['active'] = "true";
							$this->TS_VCSC_CountActiveElements++;
						} else {
							$this->TS_VCSC_bbPress_Elements[$ElementName]['active'] = "false";
						}
					} else {
						$this->TS_VCSC_bbPress_Elements[$ElementName]['active'] = $defaultstatus;
						if ($defaultstatus == "true") {
							$this->TS_VCSC_CountActiveElements++;
						}
					}
				}
			}			
			// Iconicum Settings
			if ($this->TS_VCSC_IconicumStandard == "false") {				
				if (($this->TS_VCSC_IconicumActivated == "true") || ($this->TS_VCSC_IconicumMenuGenerator == "true")) {					
					require_once($this->shortcode_dir . 'ts_vcsc_shortcode_icon_generator.php');
				}
			}
		}
		function TS_VCSC_RegisterWithComposer() {
			if (function_exists('vc_is_inline')){
				if ((vc_is_inline() == true) || is_admin()) {
					$this->TS_VCSC_AddParametersToComposer();
					$this->TS_VCSC_AddElementsToComposer();
				} else {
					if ((vc_is_inline() == NULL) || (vc_is_inline() == '')) {
						if (TS_VCSC_CheckFrontEndEditor() == true) {
							$this->TS_VCSC_AddParametersToComposer();
							$this->TS_VCSC_AddElementsToComposer();
						} else {
							$this->TS_VCSC_LoadClassElements();
						}	
					} else {
						$this->TS_VCSC_LoadClassElements();
					}
				}
			} else if (is_admin()) {
				$this->TS_VCSC_AddParametersToComposer();
				$this->TS_VCSC_AddElementsToComposer();
			} else {
				$this->TS_VCSC_LoadClassElements();
			}		
		}
		function TS_VCSC_AddParametersToComposer() {
			foreach ($this->TS_VCSC_ComposerParameters as $ParameterName => $parameter) {
				require_once($this->parameters_dir . 'ts_vcsc_parameter_' . $parameter['file'] . '.php');
			}
		}
		function TS_VCSC_AddElementsToComposer() {
			// Load Standard Elements
			foreach ($this->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
				if ($element['active'] == "true") {					
					if ($element['type'] == 'internal') {
						require_once($this->elements_dir . 'ts_vcsc_element_' . $element['file'] . '.php');
					} else if ($element['type'] == 'demos') {
						require_once($this->elements_dir . 'ts_vcsc_element_' . $element['file'] . '.php');
					} else if ($element['type'] == 'class') {						
						require_once($this->classes_dir . 'ts_vcsc_class_' . $element['file'] . '.php');
					} else if ($element['type'] == 'external') {
						require_once($this->plugins_dir . 'ts_vcsc_element_' . $element['file'] . '.php');
					}
				}
			}
			// Load WooCommerce Elements
			if ($this->TS_VCSC_WooCommerceActive == "true") {
				foreach ($this->TS_VCSC_WooCommerce_Elements as $ElementName => $element) {
					if ($element['active'] == "true") {
						if (($element['type'] == 'internal') && ($this->TS_VCSC_WooCommerceRemove == "false")) {							
							require_once($this->woocommerce_dir . 'ts_vcsc_woocommerce_' . $element['file'] . '.php');
						} else if ($element['type'] == 'class') {
							require_once($this->woocommerce_dir . 'ts_vcsc_woocommerce_' . $element['file'] . '.php');
						}
					}
				}
			}
			// Load bbPress Elements
			if ($this->TS_VCSC_bbPressActive == "true") {
				foreach ($this->TS_VCSC_bbPress_Elements as $ElementName => $element) {
					if ($element['active'] == "true") {
						if ($element['type'] == 'internal') {
							require_once($this->bbpress_dir . 'ts_vcsc_bbpress_' . $element['file'] . '.php');
						} else if ($element['type'] == 'class') {
							require_once($this->bbpress_dir . 'ts_vcsc_bbpress_' . $element['file'] . '.php');
						}
					}
				}
			}
			// Load Custom Post Type Elements
			if ($this->TS_VCSC_CustomPostTypesCheckup == "true") {
				// Load Teammate Settings
				if ($this->TS_VCSC_CustomPostTypesTeam == "true") {
					require_once($this->classes_dir . 'ts_vcsc_class_teammates.php');
					require_once($this->classes_dir . 'ts_vcsc_class_teampage.php');
				}
				// Load Testimonial Settings
				if ($this->TS_VCSC_CustomPostTypesTestimonial == "true") {
					require_once($this->classes_dir . 'ts_vcsc_class_testimonials.php');
				}
				// Load Logo Settings
				if ($this->TS_VCSC_CustomPostTypesLogo == "true") {
					require_once($this->classes_dir . 'ts_vcsc_class_logos.php');
				}
				// Load Skillset Settings
				if ($this->TS_VCSC_CustomPostTypesSkillset == "true") {
					require_once($this->classes_dir . 'ts_vcsc_class_skillsets.php');
				}
				// Load Timeline Settings
				if ($this->TS_VCSC_CustomPostTypesTimeline == "true") {
					require_once($this->classes_dir . 'ts_vcsc_class_timeline_css.php');
				}
			}
			// Single Page Navigator Builder
			if ($this->TS_VCSC_UsePageNavigator == "true") {
				require_once($this->classes_dir . 'ts_vcsc_class_singlepage.php');
			}
			if (((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_additions', 1) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 0))) {
				// Load Extended Row Settings
				if (get_option('ts_vcsc_extend_settings_additionsRows', 0) == 1) {
					require_once($this->elements_dir . 'ts_vcsc_element_row.php');
				}
				// Load Extended Column Settings
				if (get_option('ts_vcsc_extend_settings_additionsColumns', 0) == 1) {
					require_once($this->elements_dir . 'ts_vcsc_element_column.php');
				}
			}			
			// Load EnlighterJS Elements
			if ($this->TS_VCSC_UseEnlighterJS == "true") {
				require_once($this->classes_dir . 'ts_vcsc_class_enlighterjs.php');	
			}
		}
		function TS_VCSC_LoadClassElements() {
			// Load Standards Elements with Class Definitions
			foreach ($this->TS_VCSC_Visual_Composer_Elements as $ElementName => $element) {
				if ($element['active'] == "true") {
					if ($element['type'] == 'class') {						
						require_once($this->classes_dir . '/ts_vcsc_class_' . $element['file'] . '.php');
					}
				}
			}
			// Load WooCommerce Class Elements
			if ($this->TS_VCSC_WooCommerceActive == "true") {
				foreach ($this->TS_VCSC_WooCommerce_Elements as $ElementName => $element) {
					if ($element['active'] == "true") {
						if ($element['type'] == 'class') {
							require_once($this->woocommerce_dir . 'ts_vcsc_woocommerce_' . $element['file'] . '.php');
						}
					}
				}
			}
			// Load Custom Post Type Class Elements
			if ($this->TS_VCSC_CustomPostTypesCheckup == "true") {
				// Load Teammate Settings
				if ($this->TS_VCSC_CustomPostTypesTeam == "true") {
					require_once($this->classes_dir . 'ts_vcsc_class_teammates.php');
					require_once($this->classes_dir . 'ts_vcsc_class_teampage.php');
				}
				// Load Testimonial Settings
				if ($this->TS_VCSC_CustomPostTypesTestimonial == "true") {
					require_once($this->classes_dir . 'ts_vcsc_class_testimonials.php');
				}
				// Load Logo Settings
				if ($this->TS_VCSC_CustomPostTypesLogo == "true") {
					require_once($this->classes_dir . 'ts_vcsc_class_logos.php');
				}
				// Load Skillset Settings
				if ($this->TS_VCSC_CustomPostTypesSkillset == "true") {
					require_once($this->classes_dir . 'ts_vcsc_class_skillsets.php');
				}
				// Load Timeline Settings
				if ($this->TS_VCSC_CustomPostTypesTimeline == "true") {
					require_once($this->classes_dir . 'ts_vcsc_class_timeline_css.php');
				}
			}
			// Single Page Navigator Builder
			if ($this->TS_VCSC_UsePageNavigator == "true") {
				require_once($this->classes_dir . 'ts_vcsc_class_singlepage.php');
			}
			if (((get_option('ts_vcsc_extend_settings_extended', 0) == 1) && (get_option('ts_vcsc_extend_settings_additions', 1) == 1)) || ((get_option('ts_vcsc_extend_settings_extended', 0) == 0))) {
				// Load Extended Row Settings
				if (get_option('ts_vcsc_extend_settings_additionsRows', 0) == 1) {
					require_once($this->elements_dir . 'ts_vcsc_element_row.php');
				}
				// Load Extended Column Settings
				if (get_option('ts_vcsc_extend_settings_additionsColumns', 0) == 1) {
					require_once($this->elements_dir . 'ts_vcsc_element_column.php');
				}
			}
			// Load EnlighterJS Elements
			if ($this->TS_VCSC_UseEnlighterJS == "true") {
				require_once($this->classes_dir . 'ts_vcsc_class_enlighterjs.php');	
			}
		}
		
		
		/* Functions for Custom Font Upload */
		/* -------------------------------- */
		
		// Sets path to wp-content/uploads/ts-vcsc-icons/custom-pack
		function TS_VCSC_SetUploadDirectory($upload) {
			$upload['subdir'] 	= '/ts-vcsc-icons/custom-pack';
			$upload['path'] 	= $upload['basedir'] . $upload['subdir'];
			$upload['url']   	= $upload['baseurl'] . $upload['subdir'];
			return $upload;
		}
		// If you are on the Upload a Custom Icon Pack Page => set custom path for all uploads to wp-content/uploads/ts-vcsc-icons/custom-pack
		function TS_VCSC_ChangeDownloadsUploadDirectory() {
			$actual_link 		= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$actual_link 		= explode('/', $actual_link);
			$urlBasename 		= array_pop($actual_link);
			$upload_directory 	= wp_upload_dir();
			$font_directory		= $upload_directory['basedir'] . '/ts-vcsc-icons/custom-pack';
			update_option('ts_vcsc_extend_settings_tinymceCustomDirectory', $font_directory);
			if ($urlBasename == 'admin.php?page=TS_VCSC_Uploader') {
				add_filter('upload_dir', array($this, 'TS_VCSC_SetUploadDirectory'));
			}
		}
		// Register custom pack already installed error
		function TS_VCSC_CustomPackInstalledError(){
			//$TS_VCSC_Icons_Custom 			= get_option('ts_vcsc_extend_settings_tinymceCustomArray', '');
			//$TS_VCSC_tinymceCustomCount		= get_option('ts_vcsc_extend_settings_tinymceCustomCount', 0);
			if ((ini_get('allow_url_fopen') == '1') || (TS_VCSC_cURLcheckBasicFunctions() == true)) {
				$RemoteFileAccess = true;
			} else {
				$RemoteFileAccess = false;
			}
			$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$actual_link = explode('/', $actual_link);
			$urlBasename = array_pop($actual_link);
			if ($urlBasename == 'admin.php?page=TS_VCSC_Uploader' ) {
				$dest = wp_upload_dir();
				$dest_path = $dest['path'];
				// If a file exists display included icons
				if ((file_exists($dest_path.'/ts-vcsc-custom-pack.zip')) && ($RemoteFileAccess == true) && (get_option('ts_vcsc_extend_settings_tinymceCustomArray', '') != '')) {
					// Disable File Upload Field if custom font pack exists or system requirements are not met
					echo '<script>
						jQuery(document).ready(function() {
							jQuery(".ts-vcsc-custom-pack-preloader").hide();
							jQuery(".preview-icon-code-box").show();
							jQuery(".dropDownDownload").removeAttr("disabled");							
							jQuery("input#ts_vcsc_custom_pack_replace").attr("disabled", "disabled");
							jQuery("#ts_vcsc_custom_pack_replace_label").addClass("disabled");							
							jQuery("input#ts_vcsc_custom_pack_relative").attr("disabled", "disabled");
							jQuery("#ts_vcsc_custom_pack_relative_label").addClass("disabled");							
							jQuery("#ts_vcsc_custom_pack_field").attr("disabled", "disabled");
							jQuery("input[value=Import]").attr("disabled", "disabled");
						});
					</script>';
				} else if ($RemoteFileAccess == false) {
					TS_VCSC_ResetCustomFont();
					echo '<script>
						jQuery(document).ready(function() {
							jQuery(".ts-vcsc-custom-pack-preloader").hide();
							jQuery(".preview-icon-code-box").hide();
							jQuery("#ts_vcsc_custom_pack_field").attr("disabled", "disabled");
							jQuery("#uninstall-pack-button").attr("disabled", "disabled");
							jQuery(".dropDownDownload").attr("disabled", "disabled");
							jQuery("input[value=Import]").attr("disabled", "disabled");
							jQuery("input#ts_vcsc_custom_pack_replace").attr("disabled", "disabled");
							jQuery("#ts_vcsc_custom_pack_replace_label").addClass("disabled");
							jQuery("input#ts_vcsc_custom_pack_relative").attr("disabled", "disabled");
							jQuery("#ts_vcsc_custom_pack_relative_label").addClass("disabled");	
							jQuery(".ts-vcsc-custom-pack-buttons").after("<div class=error><p class=fontPackUploadedError>Your system does not fulfill the requirements to import a custom font.</p></div>");
						});
					</script>';	
				}
				if (($RemoteFileAccess == true) && (file_exists( $dest_path.'/ts-vcsc-custom-pack.json' )) && (file_exists($dest_path.'/style.css')) && (get_option('ts_vcsc_extend_settings_tinymceCustomArray', '') != '')) {
					// Create Preview of Imported Icons
					$output = "";
					$output .= "<div id='ts-vcsc-extend-preview' class=''>";
						$output .="<div id='ts-vcsc-extend-preview-name'>Font Name: " . 		get_option('ts_vcsc_extend_settings_tinymceCustomName', 'Custom User Font') . "</div>";
						$output .="<div id='ts-vcsc-extend-preview-author'>Font Author: " . 	get_option('ts_vcsc_extend_settings_tinymceCustomAuthor', 'Custom User') . "</div>";
						$output .="<div id='ts-vcsc-extend-preview-count'>Icon Count: " . 		get_option('ts_vcsc_extend_settings_tinymceCustomCount', 0) . "</div>";
						$output .="<div id='ts-vcsc-extend-preview-date'>Uploaded: " . 			get_option('ts_vcsc_extend_settings_tinymceCustomDate', '') . "</div>";
						$output .= "<div id='ts-vcsc-extend-preview-list' class=''>";
						$icon_counter = 0;
						foreach (get_option('ts_vcsc_extend_settings_tinymceCustomArray', '') as $key => $option ) {
							$font = explode('-', $key);
							$output .= "<div class='ts-vcsc-icon-preview ts-freewall-active' data-name='" . $key . "' data-code='" . $option . "' data-font='Custom' data-count='" . $icon_counter . "' rel='" . $key . "'><span class='ts-vcsc-icon-preview-icon'><i class='" . $key . "'></i></span><span class='ts-vcsc-icon-preview-name'>" . $key . "</span></div>";
							$icon_counter = $icon_counter + 1;
						}
						$output .= "</div>";
					$output .= "</div>";
					echo '<script>
						jQuery(document).ready(function() {
							jQuery("#current-font-pack-preview").html("' . $output. '");
						});
					</script>';
				} else if ((file_exists($dest_path.'/ts-vcsc-custom-pack.zip')) && ($RemoteFileAccess == true) && (get_option('ts_vcsc_extend_settings_tinymceCustom', 0) == 0) && (get_option('ts_vcsc_extend_settings_tinymceCustomArray', '') == '')) {
					TS_VCSC_ResetCustomFont();
					echo '<script>
						jQuery(document).ready(function() {
							jQuery("#ts_vcsc_custom_pack_field").attr("disabled", "disabled");
							jQuery("input[value=Import]").attr("disabled", "disabled");							
							jQuery("input#ts_vcsc_custom_pack_replace").attr("disabled", "disabled");
							jQuery("#ts_vcsc_custom_pack_replace_label").addClass("disabled");
							jQuery("input#ts_vcsc_custom_pack_relative").attr("disabled", "disabled");
							jQuery("#ts_vcsc_custom_pack_relative_label").addClass("disabled");	
							jQuery(".ts-vcsc-custom-pack-preloader").hide();
							jQuery(".preview-icon-code-box").hide();
							jQuery("#ts_vcsc_custom_pack_field").attr("disabled", "disabled");
							jQuery("#uninstall-pack-button").removeAttr("disabled").addClass("uninstallnow");
							jQuery("#dropDownDownload").attr("disabled", "disabled");
							jQuery(".ts-vcsc-custom-pack-buttons").after("<div class=error><p class=fontPackUploadedError>Hi there, something went wrong during your last font import. Please uninstall the current font package and try importing again (with a valid font package).</p></div>");
						});
					</script>';
				} else {
					TS_VCSC_ResetCustomFont();
					echo '<script>
						jQuery(document).ready(function() {
							jQuery(".ts-vcsc-custom-pack-preloader").hide();
							jQuery(".preview-icon-code-box").hide();
							jQuery("#uninstall-pack-button").attr("disabled", "disabled");
							jQuery("#ts_vcsc_custom_pack_field").removeAttr("disabled");
							jQuery("#dropDownDownload").attr("disabled", "disabled");
							jQuery("input#ts_vcsc_custom_pack_replace").attr("disabled", "disabled");
							jQuery("#ts_vcsc_custom_pack_replace_label").addClass("disabled");
							jQuery("input#ts_vcsc_custom_pack_relative").attr("disabled", "disabled");
							jQuery("#ts_vcsc_custom_pack_relative_label").addClass("disabled");	
						});
					</script>';
				}
			}	
		}
		// Function that handles the AJAX request of deleting files
		function TS_VCSC_DeleteCustomPack_Ajax() {
			$dest 					= wp_upload_dir();
			$dest_path 				= $dest['path'];	
			$this_year 				= date('Y');
			$this_month 			= date('m');
			$the_date_string 		= $this_year . '/' . $this_month.'/';
			$customFontPackPath 	= $dest_path . '/ts-vcsc-icons/custom-pack/';
			$newCustomFontPackPath 	= str_replace($the_date_string, '', $customFontPackPath);
			$fileName = 'ts-vcsc-custom-pack.zip';
			$deleteZip = TS_VCSC_RemoveDirectory($newCustomFontPackPath, false);
			TS_VCSC_RemoveDirectory($newCustomFontPackPath, false);
			TS_VCSC_ResetCustomFont();
			$this->TS_VCSC_tinymceCustomCount 	= 0;
			$this->TS_VCSC_Icons_Custom 		= array();
		}
		// Function to download System Information
		function TS_VCSC_DownloadSystemInfoData() {
            if (!isset($_GET['secret']) || $_GET['secret'] != md5( md5( AUTH_KEY . SECURE_AUTH_KEY ) . '-' . 'ts-vcsc-extend') ) {
                wp_die( 'Invalid Secret for options use' );
                exit;
            }			
			$content 	= get_option('ts_vcsc_extend_settings_systemInfo', '');
			$siteturl	= site_url();
			$find_h 	= '#^http(s)?://#';
			$find_w 	= '/^www\./';
			$siteturl 	= preg_replace($find_h, '', $siteturl);
			$siteturl 	= preg_replace($find_w, '', $siteturl);
			$siteturl 	= str_replace('/', '.', $siteturl);
			if (isset($_GET['action']) && $_GET['action'] == 'ts_system_download') {
				header( 'Content-Description: File Transfer' );
				header( 'Content-type: application/txt' );
				header( 'Content-Disposition: attachment; filename="' . $siteturl . '-systeminfo.txt"' );
				header( 'Content-Transfer-Encoding: binary' );
				header( 'Expires: 0' );
				header( 'Cache-Control: must-revalidate' );
				header( 'Pragma: public' );
				echo $content;
				/*echo '<script>';
					echo 'window.location="' . $_SERVER['REQUEST_URI'] . '";';
				echo '</script>';*/
				//Header('Location: '.$_SERVER['REQUEST_URI']);
				Exit();
			} else {
				header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
				header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
				header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
				header( 'Cache-Control: no-store, no-cache, must-revalidate' );
				header( 'Cache-Control: post-check=0, pre-check=0', false );
				header( 'Pragma: no-cache' );
				// Can't include the type. Thanks old Firefox and IE. BAH.
				//header("Content-type: application/json");
				echo $content;
				/*echo '<script>';
					echo 'window.location="' . $_SERVER['REQUEST_URI'] . '";';
				echo '</script>';*/
				//Header('Location: '.$_SERVER['REQUEST_URI']);
				Exit();
			}
		}
		// Function to export Plugin Settings
		function TS_VCSC_ExportPluginSettings() {
            if (!isset($_GET['secret']) || $_GET['secret'] != md5( md5( AUTH_KEY . SECURE_AUTH_KEY ) . '-' . 'ts-vcsc-extend') ) {
                wp_die( 'Invalid Secret for options use' );
                exit;
            }			
			$content 	= get_option('ts_vcsc_extend_settings_exportSettings', '');
			$siteturl	= site_url();
			$find_h 	= '#^http(s)?://#';
			$find_w 	= '/^www\./';
			$siteturl 	= preg_replace($find_h, '', $siteturl);
			$siteturl 	= preg_replace($find_w, '', $siteturl);
			$siteturl 	= str_replace('/', '.', $siteturl);
			if (isset($_GET['action']) && $_GET['action'] == 'ts_export_settings') {
				header( 'Content-Description: File Transfer' );
				header( 'Content-type: application/txt' );
				header( 'Content-Disposition: attachment; filename="' . $siteturl . '-vcextensions-settings.json"' );
				header( 'Content-Transfer-Encoding: binary' );
				header( 'Expires: 0' );
				header( 'Cache-Control: must-revalidate' );
				header( 'Pragma: public' );
				echo $content;
				Exit();
			} else {
				header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
				header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
				header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
				header( 'Cache-Control: no-store, no-cache, must-revalidate' );
				header( 'Cache-Control: post-check=0, pre-check=0', false );
				header( 'Pragma: no-cache' );
				// Can't include the type. Thanks old Firefox and IE. BAH.
				//header("Content-type: application/json");
				echo $content;
				Exit();
			}
		}
		// Function to retrieve WooCommerce Version
		function TS_VCSC_WooCommerceVersion() {
			// If get_plugins() isn't available, require it
			if (!function_exists('get_plugins')) {
				require_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}
			// Create the plugins folder and file variables
			$plugin_folder 	= get_plugins('/' . 'woocommerce');
			$plugin_file 	= 'woocommerce.php';
			// If the plugin version number is set, return it 
			if (isset($plugin_folder[$plugin_file]['Version'])) {
				return $plugin_folder[$plugin_file]['Version'];
			} else {
				return NULL;
			}
		}
	}
}
if (class_exists('VISUAL_COMPOSER_EXTENSIONS')) {
	$VISUAL_COMPOSER_EXTENSIONS = new VISUAL_COMPOSER_EXTENSIONS;
}


// Add Category Filters to Custom Post Types
// -----------------------------------------
if (!class_exists('TS_VCSC_Tax_CTP_Filter')){
    class TS_VCSC_Tax_CTP_Filter {
        /**
         * __construct 
         * @author Ohad Raz <admin@bainternet.info>
         * @since 0.1
         * @param array $cpt [description]
         */
        function __construct($cpt = array()){
            $this->cpt = $cpt;
            // Adding a Taxonomy Filter to Admin List for a Custom Post Type
            add_action( 'restrict_manage_posts', array($this, 'TS_VCSC_My_Restrict_Manage_Posts' ));
        }
        /**
         * TS_VCSC_My_Restrict_Manage_Posts  add the slelect dropdown per taxonomy
         * @author Ohad Raz <admin@bainternet.info>
         * @since 0.1
         * @return void
         */
        public function TS_VCSC_My_Restrict_Manage_Posts() {
            // only display these taxonomy filters on desired custom post_type listings
            global $typenow;
            $types = array_keys($this->cpt);
            if (in_array($typenow, $types)) {
                // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
                $filters = $this->cpt[$typenow];
                foreach ($filters as $tax_slug) {
                    // retrieve the taxonomy object
                    $tax_obj = get_taxonomy($tax_slug);
                    $tax_name = $tax_obj->labels->name;
                    // output html for taxonomy dropdown filter
                    echo "<select name='".strtolower($tax_slug)."' id='".strtolower($tax_slug)."' class='postform'>";
                    echo "<option value=''>Show All $tax_name</option>";
                    $this->TS_VCSC_Generate_Taxonomy_Options($tax_slug,0,0,(isset($_GET[strtolower($tax_slug)])? $_GET[strtolower($tax_slug)] : null));
                    echo "</select>";
                }
            }
        }
        /**
         * TS_VCSC_Generate_Taxonomy_Options generate dropdown
         * @author Ohad Raz <admin@bainternet.info>
         * @since 0.1
         * @param  string  $tax_slug 
         * @param  string  $parent   
         * @param  integer $level    
         * @param  string  $selected 
         * @return void            
         */
        public function TS_VCSC_Generate_Taxonomy_Options($tax_slug, $parent = '', $level = 0,$selected = null) {
            $args = array('show_empty' => 1);
            if(!is_null($parent)) {
                $args = array('parent' => $parent);
            }
            $terms = get_terms($tax_slug,$args);
            $tab='';
            for($i=0;$i<$level;$i++){
                $tab.='--';
            }
            foreach ($terms as $term) {
                // output each select option line, check against the last $_GET to show the current option selected
                echo '<option value='. $term->slug, $selected == $term->slug ? ' selected="selected"' : '','>' .$tab. $term->name .' (' . $term->count .')</option>';
                $this->TS_VCSC_Generate_Taxonomy_Options($tax_slug, $term->term_id, $level+1,$selected);
            }
        }
    }
}


// Load Library to create Custom Metaboxes
// ---------------------------------------
if (!function_exists('TS_VCSC_CMBMetaBoxes')){
	function TS_VCSC_CMBMetaBoxes() {
		global $VISUAL_COMPOSER_EXTENSIONS;
		if (!class_exists('cmb_Meta_Box')) {
			require_once('custom-metabox/init.php');
			if (defined('cmb_Meta_Box::CMB_VERSION')) {
				$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesClass 		= cmb_Meta_Box::CMB_VERSION;
				$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesInternal 	= "true";
			}
		} else {
			if (defined('cmb_Meta_Box::CMB_VERSION')) {
				$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesClass 		= cmb_Meta_Box::CMB_VERSION;
				$VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesInternal 	= "false";
			}
		}
	}
}


// Load Helper Functions
// ---------------------
require_once('assets/ts_vcsc_registrations_functions.php');
?>