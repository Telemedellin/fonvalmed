<?php

/*
Plugin Name: Menu Fields
Plugin URI: http://www.psd2html.com/
Description: Create beautifully customizable menus right in your WordPress admin panel.
Version: 1.2.2
Author: psd2html.com
Author URI: http://psd2html.com
*/


if ( ! class_exists( 'MenuFields' ) ) {

	class MenuFields {
		
		function __construct() {
			
			include( dirname(__FILE__) . '/menu-walker.php' );
			include( dirname(__FILE__) . '/config.php' );
			
			add_action( 'wp_update_nav_menu_item',		array( $this, 'nav_update' ), 10, 3 ) ;
			add_action( 'admin_enqueue_scripts',		array( $this, 'menu_fields_admin_scripts' ) );
			add_action( 'wp_ajax_menu_fields_image',	array( $this, 'menu_fields_image' ) );		
			
			add_filter( 'wp_setup_nav_menu_item',		array( $this, 'custom_nav_item' ) );
			add_filter( 'wp_edit_nav_menu_walker',		array( $this, 'custom_nav_fields_edit_walker' ), 10, 2 );
		}
		
		static function plugin_url() {
			return plugin_dir_url( __FILE__ );
		}
		
		/*
		 * Saves new field to postmeta for navigation
		 */
		function nav_update( $menu_id, $menu_item_db_id, $args ) {
			$fields = $this->menu_field_get_fields();
			if( is_array( $fields ) ){
				foreach( $fields as $field ){
					if( isset( $_REQUEST[$field['name'] . '-menu-item-custom' ][$menu_item_db_id] ) ){
						if( $field['type'] == 'checkbox' ){
								$custom_value = $_REQUEST[$field['name'] . '-menu-item-custom'][$menu_item_db_id];
								if ( $custom_value == 'on' ){
									update_post_meta( $menu_item_db_id, $this->menu_fields_meta_name( $field['name'] ), 1 );
								}else{
									update_post_meta( $menu_item_db_id, $this->menu_fields_meta_name( $field['name'] ), 0 );
								}
						}else{
							if ( isset( $_REQUEST[$this->menu_fields_input_name( $field['name'] )] ) && is_array( $_REQUEST[$this->menu_fields_input_name( $field['name'] )] ) ) {
								$custom_value = $_REQUEST[$this->menu_fields_input_name( $field['name'] )][$menu_item_db_id];
								if( $custom_value || get_post_meta( $menu_item_db_id, $this->menu_fields_meta_name( $field['name'] ), true ) ){
									update_post_meta( $menu_item_db_id, $this->menu_fields_meta_name( $field['name'] ), $custom_value );
								}
							}
						}
					}
				}
			}
		}
		
		/*
		 * Adds value of new field to $item object that will be passed to     Walker_Nav_Menu_Fields_Edit_Custom
		 */
		function custom_nav_item( $menu_item ) {
			$fields = $this->menu_field_get_fields();
			$fields_array = array();
			if( is_array( $fields ) ){
				foreach( $fields as $field ){
					$fields_array[$field['name']] = get_post_meta( $menu_item->ID, $this->menu_fields_meta_name( $field['name'] ), true );
				}
			}
			$menu_item->custom = $fields_array;
			return $menu_item;
		}
		
		function custom_nav_fields_edit_walker( $walker ) {
			return 'Walker_Nav_Menu_Fields_Edit_Custom';
		}
		
		function menu_fields_admin_scripts() {
				wp_enqueue_media();
				wp_register_script( 'menu_feilds-js',  $this->plugin_url() . '/js/menu_feilds.js', array( 'jquery' ) );
				wp_enqueue_script( 'menu_feilds-js' );
		}
		
		function menu_fields_image( $image_id ) {
				$image_id = intval( $_POST['image_id'] );
				$image = wp_get_attachment_image_src( $image_id, 'thumbnail' );
				echo $image[0];
			die(); 
		}
		
		static function menu_field_get_fields(){
			return apply_filters( 'custom_menu_fields', true );
		}
		
		function menu_fields_meta_name( $field ){
			return '_' . $field . '_menu_item_custom';
		}
		
		static function menu_fields_input_name( $field ){
			return $field . '-menu-item-custom';
		}
		
		static function menu_fields_item_class( $field, $terms, $locations ){
		
			$field_class = '';
			
			if( isset($field['location']) ){
				if( is_array( $field['location'] ) ){
					$fiels_visible = false;
					foreach ( $field['location'] as $location_config ){
						if( array_key_exists( $location_config, $locations ) ){
							$fiels_visible = true;
						}				
						$field_class.= ' locations-' . $location_config;
					}
					
					if( !$fiels_visible ){
						$field_class.= ' hidden ';
					}
					
				}else{
					if( !array_key_exists( $field['location'], $locations ) ){
						$field_class.= ' hidden ';
					}
					$field_class.= $visible_item . ' locations-' . $field['location'];
				}
			}
			return $field_class;
		}
	}

}

$MenuFields = new MenuFields;

function get_menu_field( $name, $id ){
	return get_post_meta( $id, MenuFields::menu_fields_meta_name( $name ), true );
}