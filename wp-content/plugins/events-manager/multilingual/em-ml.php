<?php
/**
 * Abstract layer allowing for certain aspects of Events Manager to be translateable. Useful for translation plugins to hook into.
 */
class EM_ML{
    /**
     * @var boolean Flag confirming whether this class has been initialized yet.
     */
    static public $init;
	/**
	 * @var array Array of option keys in wp_options that can be translated.
	 */
	static public $translatable_options;
	/**
	 * @var array Array of available languages, where keys are the locales and the values are the displayable names of the language e.g. array('fr_FR' => 'French');
	 */
	static public $langs = array();
	/**
	 * @var string The main language of this blog, meaning the language used should no multilingual plugin be installed. Example: 'en_US' for American English.
	 */
	static public $wplang;
	/**
	 * @var string The currently active language of this site, meaning the language being displayed to the user. Example: 'en_US' for American English.
	 */
	static public $current_language;
	/**
	 * @var boolean Flag for whether EM is multilingual ready, false by default, set after init() has been executed first time.
	 */
	static public $is_ml = false;

	public static function init(){
	    if( !empty(self::$init) ) return;
		
		//Determine the available languages and the currently displayed locale for this site.
		self::$langs = apply_filters('em_ml_langs', array());
		self::$wplang = apply_filters('em_ml_wplang',get_locale());
		self::$current_language = !empty($_REQUEST['em_lang']) && array_key_exists($_REQUEST['em_lang'], self::$langs) ? $_REQUEST['em_lang']:get_locale();
		self::$current_language = apply_filters('em_ml_current_language',self::$current_language);
		
		//proceed with loading the plugin, we don't need to deal with the rest of this if no languages were defined by an extending class
		if( count(self::$langs) > 0 ) {
		    //set flag to prevent unecessary counts
		    self::$is_ml = true;
		    		    
    	    //define the translatable options for the plugin
    		self::$translatable_options = apply_filters('em_ml_translatable_options', array(
    			//GENERAL TAB
    				//event submission forms
    				'dbem_events_anonymous_result_success',
    				'dbem_events_form_result_success',
    				'dbem_events_form_result_success_updated',
    			//FORMATTING TAB
    				//events
    				'dbem_event_list_groupby_format',
    				'dbem_event_list_item_format_header',
    				'dbem_event_list_item_format',
    				'dbem_event_list_item_format_footer',
    				'dbem_no_events_message',
    				'dbem_list_date_title',
    				'dbem_single_event_format',
    		        'dbem_event_excerpt_format',
    		        'dbem_event_excerpt_alt_format',
    				//Search Form
    				'dbem_search_form_submit',
    				'dbem_search_form_advanced_hide',
    				'dbem_search_form_advanced_show',
    				'dbem_search_form_text_label',
    				'dbem_search_form_categories_label',
    				'dbem_search_form_category_label',
    				'dbem_search_form_countries_label',
    				'dbem_search_form_country_label',
    				'dbem_search_form_regions_label',
    				'dbem_search_form_region_label',
    				'dbem_search_form_states_label',
    				'dbem_search_form_state_label',
    				'dbem_search_form_towns_label',
    				'dbem_search_form_town_label',
    				'dbem_search_form_geo_label',
    				'dbem_search_form_geo_units_label',
    				'dbem_search_form_dates_label',
    				'dbem_search_form_dates_separator',
    				//Date/Time
    				'dbem_date_format',
    				'dbem_date_format_js',
    				'dbem_dates_separator',
    				'dbem_time_format',
    				'dbem_times_separator',
    				'dbem_event_all_day_message',
    				//Calendar
    				'dbem_small_calendar_month_format',
    				'dbem_small_calendar_event_title_format',
    				'dbem_small_calendar_event_title_separator',
    				'dbem_full_calendar_month_format',
    				'dbem_full_calendar_event_format',
    				'dbem_display_calendar_events_limit_msg',
    				//Ical
    				'dbem_ical_description_format',
    				'dbem_ical_real_description_format',
    				'dbem_ical_location_format',				
    				//Locations
    				'dbem_location_list_item_format_header',
    				'dbem_location_list_item_format',
    				'dbem_location_list_item_format_footer',
    				'dbem_no_locations_message',
    				'dbem_location_page_title_format',
    				'dbem_single_location_format',
    				'dbem_location_event_list_item_header_format',
    				'dbem_location_event_list_item_format',
    				'dbem_location_event_list_item_footer_format',
    				'dbem_location_no_events_message',
    				'dbem_location_event_single_format',
    				'dbem_location_no_event_message',
    				//Categories
    				'dbem_categories_list_item_format_header',
    				'dbem_categories_list_item_format',
    				'dbem_categories_list_item_format_footer',
    				'dbem_no_categories_message',
    				'dbem_category_page_title_format',
    				'dbem_category_page_format',
    				'dbem_category_event_list_item_header_format',
    				'dbem_category_event_list_item_format',
    				'dbem_category_event_list_item_footer_format',
    				'dbem_category_no_events_message',
    				'dbem_category_no_event_message',
    				'dbem_category_event_single_format',
    				//Tags
    				'dbem_tags_list_item_format_header',
    				'dbem_tags_list_item_format',
    				'dbem_tags_list_item_format_footer',
    				'dbem_no_tags_message',
    				'dbem_tag_page_title_format',
    				'dbem_tag_page_format',
    				'dbem_tag_event_list_item_header_format',
    				'dbem_tag_event_list_item_format',
    				'dbem_tag_event_list_item_footer_format',
    				'dbem_tag_no_events_message',
    				'dbem_tag_event_single_format',
    				'dbem_tag_no_event_message',
    				//RSS
    				'dbem_rss_main_description',
    				'dbem_rss_main_title',
    				'dbem_rss_title_format',
    				'dbem_rss_description_format',
    				//Maps
    				'dbem_map_text_format',
    				'dbem_location_baloon_format',
    			//Bookings
    				//Pricing Options
    				'dbem_bookings_currency_thousands_sep',
    				'dbem_bookings_currency_decimal_point',
    				'dbem_bookings_currency_format',
    				//booking feedback messages
    				'dbem_booking_feedback_cancelled',
    				'dbem_booking_warning_cancel',
    				'dbem_bookings_form_msg_disabled',
    				'dbem_bookings_form_msg_closed',
    				'dbem_bookings_form_msg_full',
    				'dbem_bookings_form_msg_attending',
    				'dbem_bookings_form_msg_bookings_link',
    				'dbem_booking_feedback',
    				'dbem_booking_feedback_pending',
    				'dbem_booking_feedback_full',
    				'dbem_booking_feedback_error',
    				'dbem_booking_feedback_email_exists',
    				'dbem_booking_feedback_log_in',
    				'dbem_booking_feedback_nomail',
    				'dbem_booking_feedback_already_booked',
    				'dbem_booking_feedback_min_space',
    				'dbem_booking_feedback_spaces_limit',
    				'dbem_booking_button_msg_book',
    				'dbem_booking_button_msg_booking',
    				'dbem_booking_button_msg_booked',
    				'dbem_booking_button_msg_already_booked',
    				'dbem_booking_button_msg_error',
    				'dbem_booking_button_msg_full',
    				'dbem_booking_button_msg_cancel',
    				'dbem_booking_button_msg_canceling',
    				'dbem_booking_button_msg_cancelled',
    				'dbem_booking_button_msg_cancel_error',
    				//booking form options
    				'dbem_bookings_submit_button',
    			//Emails
    				//booking email templates
    				'dbem_bookings_contact_email_pending_subject',
        			'dbem_bookings_contact_email_pending_body',
        			'dbem_bookings_contact_email_confirmed_subject',
        			'dbem_bookings_contact_email_confirmed_body',
        			'dbem_bookings_contact_email_rejected_subject',
        			'dbem_bookings_contact_email_rejected_body',
        			'dbem_bookings_contact_email_cancelled_subject',
        			'dbem_bookings_contact_email_cancelled_body',
    				'dbem_bookings_email_confirmed_subject',
    				'dbem_bookings_email_confirmed_body',
    				'dbem_bookings_email_pending_subject',
    				'dbem_bookings_email_pending_body',
    				'dbem_bookings_email_rejected_subject',
    				'dbem_bookings_email_rejected_body',
    				'dbem_bookings_email_cancelled_subject',
    				'dbem_bookings_email_cancelled_body',
    				//event submission templates
    				'dbem_event_submitted_email_subject',
    				'dbem_event_submitted_email_body',
    				'dbem_event_resubmitted_email_subject',
    				'dbem_event_resubmitted_email_body',
    				'dbem_event_published_email_subject',
    				'dbem_event_published_email_body',
    				'dbem_event_approved_email_subject',
    				'dbem_event_approved_email_body',
    				'dbem_event_reapproved_email_subject',
    				'dbem_event_reapproved_email_body',
    				//Registration Emails
    				'dbem_bookings_email_registration_subject',
    				'dbem_bookings_email_registration_body'
    		));
    		
    		//load all the extra ML helper classes
    	    if( is_admin() ){
    	        include(EM_DIR.'/multilingual/em-ml-admin.php');
    	    }
    	    include(EM_DIR.'/multilingual/em-ml-bookings.php');
    	    include(EM_DIR.'/multilingual/em-ml-io.php');
    	    include(EM_DIR.'/multilingual/em-ml-options.php');
    	    include(EM_DIR.'/multilingual/em-ml-placeholders.php');
    	    include(EM_DIR.'/multilingual/em-ml-search.php');
    	    
    	    //Switch EM page IDs to translated versions if they exist, so e.g. the events page in another language grabs the right translated page format if available
            if( !is_admin() ){
    	        add_filter('option_dbem_events_page','EM_ML::get_translated_page');
    	        add_filter('option_dbem_locations_page','EM_ML::get_translated_page');
    	        add_filter('option_dbem_categories_page','EM_ML::get_translated_page');
    	        add_filter('option_dbem_tags_page','EM_ML::get_translated_page');
    	        add_filter('option_dbem_edit_events_page','EM_ML::get_translated_page');
    	        add_filter('option_dbem_edit_locations_page','EM_ML::get_translated_page');
    	        add_filter('option_dbem_edit_bookings_page','EM_ML::get_translated_page');
    	        add_filter('option_dbem_my_bookings_page','EM_ML::get_translated_page');
            }
    		//change some localized script vars
    		add_filter('em_wp_localize_script', 'EM_ML::em_wp_localize_script');
		}
		self::$init = true;
	}
    
    /**
     * Localizes the script variables
     * @param array $em_localized_js
     * @return array
     */
    public static function em_wp_localize_script($em_localized_js){
        $em_localized_js['ajaxurl'] = admin_url('admin-ajax.php?em_lang='.self::$current_language);
        $em_localized_js['locationajaxurl'] = admin_url('admin-ajax.php?action=locations_search&em_lang='.self::$current_language);
		if( get_option('dbem_rsvp_enabled') ){
		    $em_localized_js['bookingajaxurl'] = admin_url('admin-ajax.php?em_lang='.self::$current_language);
		}
        return $em_localized_js;
    }

    /**
     * Takes a post id for a Page CPT, checks if the current language isn't the default language and returns a translated post id if it exists, used to switch our overriding pages.
     * Override with em_ml_get_translated_page filter 
     * @param int $post_id
     * @return int
     * @uses EM_ML::get_translated_post_id()
     */
    public static function get_translated_page($post_id){
    	return self::get_translated_post_id($post_id, 'page');
    }
    
    /**
     * Takes a post id for a post or CPT, checks if the current language isn't the default language and returns a translated post id if it exists, used to switch our overriding pages.
     * @param unknown $post_id
     * @param unknown $post_type
     * @return mixed
     */
    public static function get_translated_post_id($post_id, $post_type){
        return apply_filters('em_ml_get_translated_post_id',$post_id, $post_type);
    }
	
	/**
	 * Returns the language of the object or ID being passed. If an ID is passed, $type should be defined.
	 * @param mixed $object_or_id
	 * @param string $type Can be event, location, category or tag - refers to EM objects and taxonomies
	 * @return mixed
	 */
	public static function get_the_language($object_or_id, $type = 'event'){
	    return apply_filters('em_ml_get_the_language',self::$wplang, $object_or_id, $type);
	}
	
	public static function get_the_translation_id($lang, $object_or_id, $type = 'event'){
	    return apply_filters('em_ml_get_the_translation_id', $object_or_id, $lang, $type);
	}
    
	/* START wp_options hooks */
	/**
	 * Gets an option in a specific language. Similar to get_option but will return either the translated option if it exists
	 * @param string $option
	 * @param string $lang
	 * @param boolean $return_original
	 * @return mixed
	 */
	public static function get_option($option, $lang = false, $return_original = true){
		if( self::is_option_translatable($option) ){
			$option_langs = get_option($option.'_ml', array());
			if( empty($lang) ) $lang = self::$current_language;
			if( !empty($option_langs[$lang]) ){
				return $option_langs[$lang];
			}
		}
		return $return_original ? get_option($option):'';
	}

	/**
	 * Returns whether or not this option name is translatable.
	 * @param string $option Option Name
	 * @return boolean
	 */
	public static function is_option_translatable($option){
		return count(self::$langs) > 0 && in_array($option, self::$translatable_options);
	}
	
	/* END wp_options functions */

	/* START original event determining functions - These must be overriden for any functionality to truly work. */
	/**
	 * Returns the original Event ID from the provided EM_Event object, Event ID or Post ID.
	 * Must be overriden to work properly.
	 * @param EM_Event $EM_Event
	 * @return int
	 */
	public static function get_original_event_id( $EM_Event ){
	    return self::get_original_event($EM_Event)->event_id;
	}
	
	/**
	 * Returns the original EM_Event object from the provided EM_Event object, Event ID or Post ID.
	 * Will always return same event object or blank event object if not filtered via em_ml_get_original_event
	 * @param EM_Event $EM_Event
	 * @return EM_Event
	 */
	public static function get_original_event( $EM_Event ){
	    $event = $EM_Event;
	    if( !is_object($EM_Event) ) $event = new EM_Event();
	    return apply_filters('em_ml_get_original_event', $event, $EM_Event);
	}
	
	/**
	 * Checks if this EM_Event object is the 'original' event, accounts for empty/new event objects
	 * Will always return true if not filtered via em_ml_is_original_event
	 * @param EM_Event $EM_Event
	 * @return boolean
	 */
	public static function is_original_event( $EM_Event ){
		return apply_filters('em_ml_is_original_event',true, $EM_Event);
	}	
	/* END original event determining functions */
	
	/* START original location determining functions - These must be overriden for any functionality to truly work. */
	/**
	 * Returns the original Location ID from the provided EM_Location object, Location ID or Post ID.
	 * Must be overriden to work properly.
	 * @param EM_Location $EM_Location
	 * @return int
	 */
	public static function get_original_location_id( $EM_Location ){
	    return self::get_original_location($EM_Location)->location_id;
	}
	
	/**
	 * Returns the original EM_Location object from the provided EM_Location object, Location ID or Post ID.
	 * Will always return same location object or blank location object if not filtered via em_ml_get_original_location
	 * @param EM_Location $EM_Location
	 * @return EM_Location
	 */
	public static function get_original_location( $EM_Location ){
	    $location = $EM_Location;
	    if( !is_object($EM_Location) ) $location = new EM_Location();
	    return apply_filters('em_ml_get_original_location', $location, $EM_Location);
	}
	
	/**
	 * Checks if this EM_Location object is the 'original' location, accounts for empty/new location objects
	 * Will always return true if not filtered via em_ml_is_original_location
	 * @param EM_Location $EM_Location
	 * @return boolean
	 */
	public static function is_original_location( $EM_Location ){
		return apply_filters('em_ml_is_original_location',true, $EM_Location);
	}	
	/* END original location determining functions */
	
	/**
	 * Gets the available languages this site can display.
	 * @return array EM_ML::$langs;
	 */
	public static function get_langs(){
		return self::$langs;
	}
}
add_action('init','EM_ML::init'); //other plugins may want to do this before we do, that's ok!