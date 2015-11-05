<?php
class EM_ML_Options {
    public function __construct(){
		//When not in the admin area translatable values should be shown in the currently active language
		if( !is_admin() || (defined('DOING_AJAX') && DOING_AJAX) ){
			if( EM_ML::$current_language != EM_ML::$wplang ){
			 	foreach( EM_ML::$translatable_options as $option ){
			 	    add_filter('pre_option_'.$option, array(&$this, 'pre_option_'.$option), 1,1);
		 		}
			}
		}
    }
	
	/**
	 * Assumes calls are from the pre_option_ filter which were registered during the init() function. 
	 * This takes the filter name and searches for an equivalent translated option if it exists.
	 * 
	 * @param string $filter_name The name of the filter being applied.
	 * @param mixed $value Supplied filter value.
	 * @return mixed Returns either translated data or the supplied value.
	 */
	public function __call($filter_name, $value){
		if( strstr($filter_name, 'pre_option_') !== false ){
		    //we're calling an option to be overriden by the default language
		    $option_name = str_replace('pre_option_','',$filter_name);
		    //don't use EM_ML::get_option as it creates an endless loop for options without a translation
			$option_langs = get_option($option_name.'_ml', array());
			if( !empty($option_langs[EM_ML::$current_language]) ){
				return $option_langs[EM_ML::$current_language];
			}
		}
		return $value[0];
	}
}
$EM_ML_Options = new EM_ML_Options();