<?php
/*
 * Fields options
 * 
 * type - field type: image, input, textarea, radio, select, checkbox
 * name - field name (unique)
 * label - field text
 * location - optional menu location or array of locations
 *
*/
function custom_menu_options_default(){
	$fields = array(
		array(
			'type' => 'checkbox',
			'name' => 'checkbox1',
			'label' => 'Checkbox',
		),
		
		array(
			'type' => 'select',
			'name' => 'select1',
			'options' => array(
							'' => 'Select value',
							'value1' => 'Option 1',
							'value2' => 'Option 2',
							'value3' => 'Option 3',
							),
			'label' => 'Select Options'
		),    
		
		array(
			'type' => 'radio',
			'name' => 'radio1',
			'options' => array(
							'value1' => 'Option 1',
							'value2' => 'Option 2',
							'value3' => 'Option 3',
							),
			'label' => 'Radio Options'
		),
		
		array(
			'type' => 'image',
			'name' => 'image3',
			'label' => 'Image'
		),
		
		array(
			'type' => 'text',
			'name' => 'text1',
			'label' => 'Text'
		),
		
		array(
			'type' => 'color',
			'name' => 'color1',
			'label' => 'Color'
		),			
		
		array(
			'type' => 'textarea',
			'name' => 'textarea1',
			'label' => 'Textarea',
		),
		
		/* Locations config example */
		array(
			'type' => 'textarea',
			'name' => 'textarea2',
			'label' => 'Textarea',
			'location' => array( 'primary', 'footer' )
		),
		
	);
	return $fields;
} 
add_filter( 'custom_menu_fields', 'custom_menu_options_default' );
