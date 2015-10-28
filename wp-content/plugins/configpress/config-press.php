<?php

/**
  Plugin Name: Config Press
  Description: Website configurations
  Version: 0.3
  Author: Vasyl Martyniuk <vasyl@vasyltech.com>
  Author URI: http://vasyltech.com

  -------------
  Copyright (C) <2015>  Vasyl Martyniuk <vasyl@vasyltech.com>

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

 */

/**
 * Main Plugin Class
 *
 * Define and initialize plugin as well bootstrap the the admin UI
 *
 * @package ConfigPress
 * @author Vasyl Martyniuk <vasyl@vasyltech.com>
 * @copyright Copyright C 2015 Vasyl Martyniuk
 * @license GNU General Public License {@link http://www.gnu.org/licenses/}
 */
class ConfigPress {

    /**
     * ConfigPress option
     * 
     * Option name for wp_options table
     */
    const OPTION = 'config-press';

    /**
     * Single instance of itself
     * 
     * @var ConfigPress
     * 
     * @access private
     */
    private static $_instance = null;

    /**
     * Initialized configuration array
     * 
     * Completely initialized and parsed config array.
     * 
     * @var array
     * 
     * @access protected 
     */
    protected $config = null;
    
    /**
     * INI parsing error
     * 
     * @var string
     * 
     * @access protected 
     */
    protected $error = null;

    /**
     * Construct the ConfigPress
     * 
     * Initialize the ConfigPress and if dashboard, register all necessary
     * hooks and UI components
     * 
     * @return void
     * 
     * @access protected
     */
    protected function __construct() {
        if (is_admin()) {
            //manager Admin Menu
            if (is_multisite() && is_network_admin()) {
                add_action('network_admin_menu', array($this, 'addMenu'), 999);
            } else {
                add_action('admin_menu', array($this, 'addMenu'), 999);
            }

            //print required JS & CSS
            add_action('admin_print_scripts', array($this, 'printJavascript'));
            add_action('admin_print_styles', array($this, 'printStylesheet'));

            //ajax hook
            add_action('wp_ajax_configpress', array($this, 'ajax'));
        }
    }

    /**
     * Read option
     * 
     * Get the option "config-press" from the wp_options database table. This
     * function also takes in cosideration multisite setup (each site has it's
     * own configurations)
     * 
     * @return string
     * 
     * @access public
     */
    public function readOption() {
        if (is_multisite()) {
            $option = get_blog_option(get_current_blog_id(), self::OPTION, '');
        } else {
            $option = get_option(self::OPTION, '');
        }

        return $option;
    }

    /**
     * Write option
     * 
     * Write the "config-press" option to the wp_options database table. This
     * function also takes in cosideration multisite setup (each site has it's
     * own configurations)
     * 
     * @param string $content
     * 
     * @return boolean
     * 
     * @access protected
     */
    protected function writeOption($content) {
        if ($this->readOption() === false) {
            if (is_multisite()) {
                $result = add_blog_option(
                        get_current_blog_id(), self::OPTION, $content
                );
            } else {
                $result = add_option(self::OPTION, $content);
            }
        } else { //update
            if (is_multisite()) {
                $result = update_blog_option(
                        get_current_blog_id(), self::OPTION, $content
                );
            } else {
                $result = update_option(self::OPTION, $content);
            }
        }

        return $result;
    }

    /**
     * Get configuration option/setting
     * 
     * If $option is defined, return it, otherwise return the $default value
     * 
     * @param string $option
     * @param mixed  $default
     * 
     * @return mixed
     * 
     * @access public
     */
    public static function get($option = null, $default = null) {
        //init config only when requested and only one time
        self::getInstance()->initialize();
        
        if (is_null($option)) {
            $value = self::getInstance()->config;
        } else {
            $chunks = explode('.', $option);
            $value = self::getInstance()->config;
            foreach ($chunks as $chunk) {
                if (isset($value[$chunk])) {
                    $value = $value[$chunk];
                } else {
                    $value = $default;
                    break;
                }
            }
        }
        
        return $value;
    }
    
    /**
     * Initialize the ConfigPress
     * 
     * @param boolean $force
     * 
     * @return void
     * 
     * @access protected
     */
    protected function initialize($force = false) {
        if (is_null($this->config) || $force) {
            $config = $this->readOption();

            require_once(__DIR__ . '/application/Reader.php');
            try {
                $reader = new Reader;
                $this->config = $reader->parseString($config);
                $this->error  = null; //no errors, so clean any leftovers 
            } catch (Exception $e) {
                $this->error = $e->getMessage();
                $this->config = array();
            }
        }
    }
    
    /**
     * Check if INI configurations are valid
     * 
     * @return boolean
     * 
     * @access public
     */
    public function valid() {
        $this->initialize();
        
        return is_null($this->error);
    }

    /**
     * Get INI parsing error
     * 
     * @return string
     * 
     * @access public
     */
    public function getError() {
        return $this->error;
    }

    /**
     * Process ajax request
     * 
     * Save the configurations to the database
     * 
     * @return string
     * 
     * @access public
     */
    public function ajax() {
        check_ajax_referer(__FILE__, '_ajax_nonce');

        $result = null;

        if (get_current_user_id()) {
            $user = get_userdata(get_current_user_id());
            //check if user is an admin, otherwise refuse to save
            if (in_array('administrator', $user->roles)) {
                $result = $this->writeOption(
                        filter_input(INPUT_POST, 'config')
                );
                $this->initialize(true);
            }
        }

        echo json_encode(array(
            'status' => ($result ? 'success' : 'failure'),
            'error' => $this->getError()
        ));

        exit;
    }

    /**
     * Print javascript files
     * 
     * Insert all necessary javascript files to the page header
     * 
     * @access public
     * 
     * @return void
     * 
     * @access public
     */
    public function printJavascript() {
        if (filter_input(INPUT_GET, 'page') == CONFIGPRESS_KEY) {
            wp_enqueue_script(
                CONFIGPRESS_KEY, plugins_url('javascript/index.js', __FILE__)
            );
            wp_localize_script(CONFIGPRESS_KEY, 'configPress', array(
                'nonce' => wp_create_nonce(__FILE__),
                'baseurl' => admin_url('admin-ajax.php')
            ));

            wp_enqueue_script(
                'cp-cdm', plugins_url('javascript/codemirror.js', __FILE__)
            );
            wp_enqueue_script(
                'cp-cdm-ini', plugins_url('javascript/properties.js', __FILE__)
            );
        }
    }

    /**
     * Print stylesheet files
     * 
     * Insert all necessary stylesheet files to the page header
     * 
     * @access public
     * 
     * @return void
     * 
     * @access public
     */
    public function printStylesheet() {
        if (filter_input(INPUT_GET, 'page') == CONFIGPRESS_KEY) {
            wp_enqueue_style(
                CONFIGPRESS_KEY, plugins_url('stylesheet/index.css', __FILE__)
            );
            wp_enqueue_style(
                'cp-cdm', plugins_url('stylesheet/codemirror.css', __FILE__)
            );
        }
    }

    /**
     * Register ConfigPress menu
     * 
     * @return void
     * 
     * @access public
     */
    public function addMenu() {
        //register submenus
        add_submenu_page(
            'options-general.php',
            __('ConfigPress', CONFIGPRESS_KEY), 
            __('ConfigPress', CONFIGPRESS_KEY),
           'administrator', 
            CONFIGPRESS_KEY,
            array($this, 'renderUI')
        );
    }

    /**
     * Render ConfigPress page
     * 
     * @return void
     * 
     * @access public
     */
    public function renderUI() {
        require(__DIR__ . '/view/index.phtml');
    }
    
    /**
     * Get ConfigPress instance
     * 
     * This function accept one boolean parameter that indicates if 
     * configurations has to be re-initialized or not. By default it is false.
     * 
     * @param boolean $reinit
     * 
     * @return ConfigPress
     */
    public static function getInstance($reinit = false) {
        if (is_null(self::$_instance)) {
            self::bootstrap();
        }
        
        if ($reinit) {
            self::$_instance->initialize(true);
        }
        
        return self::$_instance;
    }

    /**
     * Bootstrap the ConfigPress plugin
     * 
     * Register language domain and create a single instance of ConfigPress
     * object
     * 
     * @return void
     * 
     * @access public
     */
    public static function bootstrap() {
        if (is_null(self::$_instance)) {
            //register language domain
            load_plugin_textdomain(CONFIGPRESS_KEY, false, __DIR__ . '/lang');
            //create an instance of itself
            self::$_instance = new self;
        }
    }
    
    /**
     * Activation Hook. Check for system requirements.
     *
     * @return void
     *
     * @access public
     */
    public static function activate() {
        //check PHP Version
        if (version_compare(PHP_VERSION, '5.3.0') == -1) {
            exit(__('PHP 5.3.0 or higher is required.', CONFIGPRESS_KEY));
        }
    }

}

if (defined('ABSPATH')) {
    //define ConfigPress constants
    define('CONFIGPRESS_KEY', 'configpress');
    
    //the lowest priority. Give possibility for other plugins to define the
    //environment first
    add_action('init', 'ConfigPress::bootstrap', 999);
    
    //activate & uninstall hook
    register_activation_hook(__FILE__, 'ConfigPress::activate');
}