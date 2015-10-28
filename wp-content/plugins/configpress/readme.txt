=== ConfigPress ===
Contributors: vasyltech
Tags: settings, options, development tool, plugin
Requires at least: 3.2
Tested up to: 4.3.1
Stable tag: 0.3

An easy way to manage all your website custom settings.

== Description ==
ConfigPress is a development tool with the main intent to avoid any hard-coding and give an easy and flexible interface to manage all your website custom settings (options).

With ConfigPress you can define your own custom option or group of options and retrieve them in your code by simply calling ConfigPress::get('option_name') method. This way you do not have to hard-code any sensitive or environment specific options in your custom code.

For more information check [ConfigPress Reference](http://vasyltech.com/config-press)

== Installation ==

1. Upload "configpress" folder to the "/wp-content/plugins" directory
2. Activate the plugin through the "Plugins" menu in WordPress
3. ConfigPress can be found under Settings menu

== Frequently Asked Questions ==

= How to use ConfigPress? =
ConfigPress is based on [INI configuration format](https://en.wikipedia.org/wiki/INI_file). Define your custom options or group of options and get them in your code with ConfigPress::get('option_name') method. 

= What is configuration section? =
The section appears on a line by itself, in square brackets ([ and ]) and is used to group options. In order to get an option in a section call ConfigPress::get('section_name.option_name') method.

== Screenshots ==
1. Simple configurations example
2. Simple configurations example with error

== Changelog ==

= 0.3 =
* Fixed small issue with default option so no more "Array" as default value
* Fixed plugin's language domain
* Fixed a small bug with INI validation
* Updated language file
* Changed color-palette for INI editor 
* Updated Codemirror library to 5.7.0
* Updated screenshots

= 0.2 =
* Added extra check for the PHP version

= 0.1 =
* Initial version 