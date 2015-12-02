=== Menu Fields ===
Contributors: psd2html
Donate link: http://psd2html.com
Tags: menu, wordpress, admin, field, 
Requires at least: 4.0.1
Tested up to: 4.3.1
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create customizable menus right in your WordPress admin panel.

== Description ==

The Menu Fields plugin is an easy-to-use extension of the basic WordPress functionality allowing you to create fully customizable menus by adding extra fields to the menu items. 

With Menu Fields, you can add fields of the following types:

* image
* input
* textarea
* radio
* select
* checkbox
* color


You can also assign each field to a theme location and specify where this field should appear. 

After the plugin has been activated, all fields are enabled by default for demonstration purposes.
You can easily modify the configuration by specifying fields in the file functions.php in your theme.

== Installation ==

Installing the plugin is simple and intuitive:

1. From the dashboard of your site, navigate to Plugins → Add New.
2. Select the Upload option and hit "Choose File".
3. When the popup appears, select the menu_fields.zip file from your computer.
4. Follow the on-screen instructions and wait until the upload completes.
5. When it's finished, activate the plugin via the prompt. A message will confirm whether the activation was successful.

The plugin folder contains a default configuration file called config.php. It has examples of how to enable any field type supported. The order of fields and their number is set by the configuration array.
Note: If you need to create your own configuration, do not modify config.php!
Create your array of fields in functions.php and enable it via a filter just like in config.php.

Example:
Let's add two fields: textarea and text.

Add the following code to functions.php in your theme:
`<?php
function mytheme_menu_fields(){
      $fields = array(
          array(
              'type' => 'textarea',
              'name' => 'textarea',
              'label' => 'Textarea',
          ),

          array(
              'type' => 'text',
              'name' => 'text',
              'label' => 'Text'
          ),
      );
      return $fields;
}
add_filter( 'custom_menu_fields', 'mytheme_menu_fields' );
?>`

Use the following code to display these fields in the front-end:

`<?php
if( function_exists( 'get_menu_field' ) ){
   $item_output .= get_menu_field( 'textarea', $id );
   $item_output .= get_menu_field( 'text', $id );
}
?>`

== Changelog ==

= Version 1.2.1 =
* Initial release

== Upgrade Notice ==

= 1.2.1 =
* Initial release


== Frequently Asked Questions ==
There are no questions yet


== Screenshots ==

1. Back-end View

