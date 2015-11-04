<?php
    global $VISUAL_COMPOSER_EXTENSIONS;

	add_action('admin_init',				'TS_VCSC_Init_Addon');
	function TS_VCSC_Init_Addon() {
		$required_vc 	= '4.5.9';
		if (defined('WPB_VC_VERSION')){
			if (version_compare($required_vc, WPB_VC_VERSION, '>')) {
				add_action('admin_notices', 'TS_VCSC_Admin_Notice_Version');
			}
		} else {
			add_action('admin_notices', 	'TS_VCSC_Admin_Notice_Activation');
		}
	}
	function TS_VCSC_Admin_Notice_Version() {
		echo '<div class="updated"><p>The <strong>Composium - Visual Composer Extensions</strong> add-on requires <strong>Visual Composer</strong> version 4.6.0 or greater.</p></div>';	
	}
	function TS_VCSC_Admin_Notice_Activation() {
		echo '<div class="updated"><p>The <strong>Composium - Visual Composer Extensions</strong> add-on requires the <strong>Visual Composer</strong> Plugin installed and activated.</p></div>';
	}
	function TS_VCSC_Admin_Notice_Network() {
		echo '<div class="updated"><p>The <strong>Composium - Visual Composer Extensions</strong> add-on can not be activated network-wide but only on individual sub-sites.</p></div>';
	}
	
	
	// Function to run if new Blog created on MutliSite
	// ------------------------------------------------	
	add_action('wpmu_new_blog', 			'TS_VCSC_On_New_BlogSite', 10, 6);
	function TS_VCSC_On_New_BlogSite($blog_id, $user_id, $domain, $path, $site_id, $meta) {
		global $wpdb;
		if (function_exists('is_multisite') && is_multisite()) {
			if (is_plugin_active_for_network('ts-visual-composer-extend/ts-visual-composer-extend.php')) {
				$old_blog = $wpdb->blogid;
				switch_to_blog($blog_id);
				TS_VCSC_Set_Plugin_Options();
				switch_to_blog($old_blog);
			}
		}
	}
	

	// Functions to Set / Delete Plugin Options
	// ----------------------------------------
	function TS_VCSC_Set_Plugin_Options() {
		// Redirect Option
		add_option('ts_vcsc_extend_settings_redirect', 							0);
		add_option('ts_vcsc_extend_settings_activation', 						0);
		// Options for Theme Authors
		add_option('ts_vcsc_extend_settings_posttypes', 				        1);
		add_option('ts_vcsc_extend_settings_posttypeWidget',					1);
		add_option('ts_vcsc_extend_settings_posttypeTeam',						1);
		add_option('ts_vcsc_extend_settings_posttypeTestimonial',				1);
		add_option('ts_vcsc_extend_settings_posttypeLogo', 						1);
		add_option('ts_vcsc_extend_settings_posttypeSkillset',					1);
		add_option('ts_vcsc_extend_settings_additions', 				        1);
		add_option('ts_vcsc_extend_settings_codeeditors', 				        1);
		add_option('ts_vcsc_extend_settings_fontimport', 				        1);
		add_option('ts_vcsc_extend_settings_iconicum', 				        	1);
		add_option('ts_vcsc_extend_settings_dashboard', 						1);
		// Options for Custom CSS/JS Editor
		add_option('ts_vcsc_extend_settings_customCSS',							'/* Welcome to the Custom CSS Editor! Please add all your Custom CSS here. */');
		add_option('ts_vcsc_extend_settings_customJS', 				            '/* Welcome to the Custom JS Editor! Please add all your Custom JS here. */');
		// Other Options
		add_option('ts_vcsc_extend_settings_frontendEditor', 					1);
		add_option('ts_vcsc_extend_settings_buffering', 						1);
		add_option('ts_vcsc_extend_settings_mainmenu', 							1);
		add_option('ts_vcsc_extend_settings_translationsDomain', 				1);
		add_option('ts_vcsc_extend_settings_previewImages',						1);
		add_option('ts_vcsc_extend_settings_visualSelector',					1);
        add_option('ts_vcsc_extend_settings_nativeSelector',					1);
        add_option('ts_vcsc_extend_settings_nativePaginator',					'200');
		add_option('ts_vcsc_extend_settings_backendPreview',					1);
		add_option('ts_vcsc_extend_settings_extended', 				            0);
		add_option('ts_vcsc_extend_settings_systemInfo',						'');
		add_option('ts_vcsc_extend_settings_socialDefaults', 					'');
		add_option('ts_vcsc_extend_settings_builtinLightbox', 					1);
		add_option('ts_vcsc_extend_settings_lightboxIntegration', 				0);
		add_option('ts_vcsc_extend_settings_allowAutoUpdate', 					1);
		add_option('ts_vcsc_extend_settings_allowNotification', 				1);
		// Font Active / Inactive
		add_option('ts_vcsc_extend_settings_tinymceMedia',						1);
		add_option('ts_vcsc_extend_settings_tinymceIcon',						1);
		add_option('ts_vcsc_extend_settings_tinymceAwesome',					1);
		add_option('ts_vcsc_extend_settings_tinymceBrankic',					0);
		add_option('ts_vcsc_extend_settings_tinymceCountricons',				0);
		add_option('ts_vcsc_extend_settings_tinymceCurrencies',					0);
		add_option('ts_vcsc_extend_settings_tinymceElegant',					0);
		add_option('ts_vcsc_extend_settings_tinymceEntypo',						0);
		add_option('ts_vcsc_extend_settings_tinymceFoundation',					0);
		add_option('ts_vcsc_extend_settings_tinymceGenericons',					0);
		add_option('ts_vcsc_extend_settings_tinymceIcoMoon',					0);
		add_option('ts_vcsc_extend_settings_tinymceMonuments',					0);
		add_option('ts_vcsc_extend_settings_tinymceSocialMedia',				0);
		add_option('ts_vcsc_extend_settings_tinymceTypicons',					0);
		add_option('ts_vcsc_extend_settings_tinymceFontsAll',					0);		
		add_option('ts_vcsc_extend_settings_tinymceVC_Awesome',					0);
		add_option('ts_vcsc_extend_settings_tinymceVC_Entypo',					0);
		add_option('ts_vcsc_extend_settings_tinymceVC_Linecons',				0);
		add_option('ts_vcsc_extend_settings_tinymceVC_OpenIconic',				0);
		add_option('ts_vcsc_extend_settings_tinymceVC_Typicons',				0);		
		// Custom Font Data
		add_option('ts_vcsc_extend_settings_IconFontSettings',					'');
		add_option('ts_vcsc_extend_settings_tinymceCustom',						0);
		add_option('ts_vcsc_extend_settings_tinymceCustomArray',				'');
		add_option('ts_vcsc_extend_settings_tinymceCustomJSON',					'');
		add_option('ts_vcsc_extend_settings_tinymceCustomPath',					'');
		add_option('ts_vcsc_extend_settings_tinymceCustomPHP', 					'');
		add_option('ts_vcsc_extend_settings_tinymceCustomName',					'Custom User Font');
		add_option('ts_vcsc_extend_settings_tinymceCustomAuthor',				'Custom User');
		add_option('ts_vcsc_extend_settings_tinymceCustomCount',				0);
		add_option('ts_vcsc_extend_settings_tinymceCustomDate',					'');
		add_option('ts_vcsc_extend_settings_tinymceCustomDirectory',			'');
		// Row + Column Extensions
		add_option('ts_vcsc_extend_settings_additionsRows',						0);
		add_option('ts_vcsc_extend_settings_additionsColumns',					0);
		add_option('ts_vcsc_extend_settings_additionsRowEffectsBreak',			'600');
		add_option('ts_vcsc_extend_settings_additionsSmoothScroll',				0);
		add_option('ts_vcsc_extend_settings_additionsSmoothSpeed',				'30');
		// Custom Post Types
		add_option('ts_vcsc_extend_settings_customWidgets',						0);
		add_option('ts_vcsc_extend_settings_customTeam',						0);
		add_option('ts_vcsc_extend_settings_customTestimonial',					0);		
		add_option('ts_vcsc_extend_settings_customSkillset',					0);		
		add_option('ts_vcsc_extend_settings_customTimelines', 					0);
		add_option('ts_vcsc_extend_settings_customLogo', 						0);
		// tinyMCE Icon Shortcode Generator
		add_option('ts_vcsc_extend_settings_useIconGenerator',					0);
		add_option('ts_vcsc_extend_settings_useTinyMCEMedia', 					1);
		// Standard Elements
		add_option('ts_vcsc_extend_settings_StandardElements',					'');
		// WooCommerce Elements
		add_option('ts_vcsc_extend_settings_WooCommerceUse',					0);
		add_option('ts_vcsc_extend_settings_WooCommerceElements',				'');
		// bbPress Elements
		add_option('ts_vcsc_extend_settings_bbPressUse',						0);
		add_option('ts_vcsc_extend_settings_bbPressElements',					'');
		// Options for External Files
		add_option('ts_vcsc_extend_settings_loadForcable',						0);
		add_option('ts_vcsc_extend_settings_loadLightbox', 						0);
		add_option('ts_vcsc_extend_settings_loadTooltip', 						0);
		add_option('ts_vcsc_extend_settings_loadFonts', 						0);
		add_option('ts_vcsc_extend_settings_loadEnqueue',						1);
		add_option('ts_vcsc_extend_settings_loadHeader',						0);
		add_option('ts_vcsc_extend_settings_loadjQuery', 						0);
		add_option('ts_vcsc_extend_settings_loadModernizr',						1);
		add_option('ts_vcsc_extend_settings_loadWaypoints', 					1);
		add_option('ts_vcsc_extend_settings_loadCountTo', 						1);
		add_option('ts_vcsc_extend_settings_loadMooTools', 						1);
		add_option('ts_vcsc_extend_settings_loadDetector', 						0);
		// Google Font Manager Settings
		add_option('ts_vcsc_extend_settings_allowGoogleManager', 				1);
		// Single Page Navigator
		add_option('ts_vcsc_extend_settings_allowPageNavigator', 				0);
		// EnlighterJS - Syntax Highlighter
		add_option('ts_vcsc_extend_settings_allowEnlighterJS',					0);
		add_option('ts_vcsc_extend_settings_allowThemeBuilder',					0);
		// Post Type Menu Positions
		$TS_VCSC_Menu_Positions_Defaults_Init = array(
			'ts_widgets'					=> 50,
			'ts_timeline'					=> 51,
			'ts_team'						=> 52,
			'ts_testimonials'				=> 53,
			'ts_skillsets'					=> 54,
			'ts_logos'						=> 55,
		);
		add_option('ts_vcsc_extend_settings_menuPositions',						$TS_VCSC_Menu_Positions_Defaults_Init);
		// Row Toggle Settings
		$TS_VCSC_Row_Toggle_Defaults_Init = array(
			'Large Devices'                 => 1200,
			'Medium Devices'                => 992,
			'Small Devices'                 => 768,
		);
		add_option('ts_vcsc_extend_settings_rowVisibilityLimits', 				$TS_VCSC_Row_Toggle_Defaults_Init);
		// Language Settings: Countdown
		$TS_VCSC_Countdown_Language_Defaults_Init = array(
			'DayPlural'                     => 'Days',
			'DaySingular'                   => 'Day',
			'HourPlural'                    => 'Hours',
			'HourSingular'                  => 'Hour',
			'MinutePlural'                  => 'Minutes',
			'MinuteSingular'                => 'Minute',
			'SecondPlural'                  => 'Seconds',
			'SecondSingular'                => 'Second',
		);
		add_option('ts_vcsc_extend_settings_translationsCountdown', 			$TS_VCSC_Countdown_Language_Defaults_Init);
		// Language Settings: Google Map
		$TS_VCSC_Google_Map_Language_Defaults_Init = array(
			'TextCalcShow'                  => 'Show Address Input',
			'TextCalcHide'                  => 'Hide Address Input',
			'TextDirectionShow'             => 'Show Directions',
			'TextDirectionHide'             => 'Hide Directions',
			'TextResetMap'                  => 'Reset Map',
			'PrintRouteText' 			    => 'Print Route',
			'TextViewOnGoogle'              => 'View on Google',
			'TextButtonCalc'                => 'Show Route',
			'TextSetTarget'                 => 'Please enter your Start Address:',
			'TextGeoLocation'               => 'Get My Location',
			'TextTravelMode'                => 'Travel Mode',
			'TextDriving'                   => 'Driving',
			'TextWalking'                   => 'Walking',
			'TextBicy'                      => 'Bicycling',
			'TextWP'                        => 'Optimize Waypoints',
			'TextButtonAdd'                 => 'Add Stop on the Way',
			'TextDistance'                  => 'Total Distance:',
			'TextMapHome'                   => 'Home',
			'TextMapBikes'                  => 'Bicycle Trails',
			'TextMapTraffic'                => 'Traffic',
			'TextMapSpeedMiles'             => 'Miles Per Hour',
			'TextMapSpeedKM'                => 'Kilometers Per Hour',
			'TextMapNoData'                 => 'No Data Available!',
			'TextMapMiles'                  => 'Miles',
			'TextMapKilometes'              => 'Kilometers',
			'TextMapActivate'               => 'Show Google Map',
			'TextMapDeactivate'             => 'Hide Google Map',
		);
		add_option('ts_vcsc_extend_settings_translationsGoogleMap', 			$TS_VCSC_Google_Map_Language_Defaults_Init);
		// Language Settings: Isotope Posts
		$TS_VCSC_Isotope_Posts_Language_Defaults_Init = array(
			'ButtonFilter'		            => 'Filter Posts',        
			'ButtonLayout'		            => 'Change Layout',
			'ButtonSort'		            => 'Sort Criteria',
			// Standard Post Strings
			'Date' 				            => 'Post Date',        
			'Modified' 			            => 'Post Modified',        
			'Title' 			            => 'Post Title',        
			'Author' 			            => 'Post Author',        
			'PostID' 			            => 'Post ID',        
			'Comments' 			            => 'Number of Comments',
			// Layout Strings
			'SeeAll'			            => 'See All',
			'Timeline' 			            => 'Timeline',
			'Masonry' 			            => 'Centered Masonry',
			'FitRows'			            => 'Fit Rows',
			'StraightDown' 		            => 'Straigt Down',
			// WooCommerce Strings
			'WooFilterProducts'             => 'Filter Products',
			'WooTitle'                      => 'Product Title',
			'WooPrice'                      => 'Product Price',
			'WooRating'                     => 'Product Rating',
			'WooDate'                       => 'Product Date',
			'WooModified'                   => 'Product Modified',
			// General Strings
			'Categories'                    => 'Categories',
			'Tags'                          => 'Tags',
		);
		add_option('ts_vcsc_extend_settings_translationsIsotopePosts', 			$TS_VCSC_Isotope_Posts_Language_Defaults_Init);
		// Options for Lightbox Settings
		$TS_VCSC_Lightbox_Setting_Defaults_Init = array(
			'thumbs'                        => 'bottom',
			'thumbsize'                     => 50,
			'animation'                     => 'random',
			'captions'                      => 'data-title',
			'closer'                        => 1, // true/false
			'duration'                      => 5000,
			'share'                         => 0, // true/false
			'social' 	                    => 'fb,tw,gp,pin',
			'notouch'                       => 1, // true/false
			'bgclose'			            => 1, // true/false
			'nohashes'			            => 1, // true/false
			'keyboard'			            => 1, // 0/1
			'fullscreen'		            => 1, // 0/1
			'zoom'				            => 1, // 0/1
			'fxspeed'			            => 300,
			'scheme'			            => 'dark',
			'removelight'                   => 0,
			'customlight'                   => 0,
			'customcolor'		            => '#ffffff',
			'backlight' 		            => '#ffffff',
			'usecolor' 		                => 0, // true/false
			'background'                    => '',
			'repeat'                        => 'no-repeat',
			'overlay'                       => '#000000',
			'noise'                         => '',
			'cors'                          => 0, // true/false
			'scrollblock'                   => 'css',
		);
		add_option('ts_vcsc_extend_settings_defaultLightboxSettings',			$TS_VCSC_Lightbox_Setting_Defaults_Init);
		// Options for Envato Sales Data
		add_option('ts_vcsc_extend_settings_envatoData', 					    '');
		add_option('ts_vcsc_extend_settings_envatoInfo', 					    '');
		add_option('ts_vcsc_extend_settings_envatoLink', 					    '');
		add_option('ts_vcsc_extend_settings_envatoPrice', 					    '');
		add_option('ts_vcsc_extend_settings_envatoRating', 					    '');
		add_option('ts_vcsc_extend_settings_envatoSales', 					    '');
		add_option('ts_vcsc_extend_settings_envatoCheck', 					    0);
		$roles 								= get_editable_roles();
		foreach ($GLOBALS['wp_roles']->role_objects as $key => $role) {
			if (isset($roles[$key]) && $role->has_cap('edit_pages') && !$role->has_cap('ts_vcsc_extend')) {
				$role->add_cap('ts_vcsc_extend');
			}
		}
	}
	function TS_VCSC_Delete_Plugin_Options() {
		if (function_exists('TS_VCSC_DeleteOptionsPrefixed')) {
			TS_VCSC_DeleteOptionsPrefixed('ts_vcsc_extend_settings_');
		}
		unregister_setting('ts_vcsc_extend_custom_css', 	'ts_vcsc_extend_custom_css', 		array($this, 	'TS_VCSC_CustomCSS_Validation'));
		unregister_setting('ts_vcsc_extend_custom_js', 		'ts_vcsc_extend_custom_js', 		array($this, 	'TS_VCSC_CustomJS_Validation'));
		delete_option("ts_vcsc_extend_custom_css");
		delete_option("ts_vcsc_extend_custom_js");
		$roles = get_editable_roles();
		foreach ($GLOBALS['wp_roles']->role_objects as $key => $role) {
			if (isset($roles[$key]) && $role->has_cap('ts_vcsc_extend')) {
				$role->remove_cap('ts_vcsc_extend');
			}
		}
	}    
?>