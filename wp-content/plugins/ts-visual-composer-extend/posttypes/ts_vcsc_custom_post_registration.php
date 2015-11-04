<?php
	global $VISUAL_COMPOSER_EXTENSIONS;

	// Create "VC Widgets" Post Type and Custopm Taxonomies
	if ($this->TS_VCSC_CustomPostTypesWidgets == "true") {
		function TS_VCSC_Widgets_Post_Type() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			$MenuPosition_Widgets			= (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions)) && (array_key_exists('ts_widgets', $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions['ts_widgets'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Menu_Positions_Defaults['ts_widgets']);
			$labels = array(
				'name'                  	=> __( 'VC Widgets', 'ts_visual_composer_extend' ),
				'singular_name'         	=> __( 'VC Widget', 'ts_visual_composer_extend' ),
				'add_new'               	=> __( 'Add New', 'ts_visual_composer_extend' ),
				'add_new_item'          	=> __( 'Add New VC Widget', 'ts_visual_composer_extend' ),
				'edit_item'             	=> __( 'Edit VC Widget', 'ts_visual_composer_extend' ),
				'new_item'              	=> __( 'New VC Widget', 'ts_visual_composer_extend' ),
				'view_item'             	=> __( 'View VC Widget', 'ts_visual_composer_extend' ),
				'search_items'          	=> __( 'Search VC Widget', 'ts_visual_composer_extend' ),
				'not_found'             	=> __( 'No VC Widget(s) found', 'ts_visual_composer_extend' ),
				'not_found_in_trash'    	=> __( 'No VC Widget(s) found in the Trash', 'ts_visual_composer_extend' ), 
				'parent_item_colon'     	=> '',
				'menu_name'             	=> 'VC Widgets'
			);
			$args = array(
				'labels'                	=> $labels,
				'description'           	=> __( 'Add VC Widgets to be used in sidebars with the "Composium - Visual Composer Extensions" plugin.', 'ts_visual_composer_extend' ),
				'public'                	=> true, //false
				'publicly_queryable'    	=> true, //false
				'menu_icon' 				=> TS_VCSC_GetResourceURL("css/other/ts_widgets_admin.png"),
				'rewrite'               	=> true, //array('slug' => 'ts_widgets', 'with_front' => true),
				'exclude_from_search'		=> true,
				'show_ui'               	=> true,
				'show_in_menu'          	=> true, 
				'query_var'             	=> true,
				'capability_type'       	=> 'post',
				'has_archive'           	=> false, 
				'hierarchical'          	=> false,
				'menu_position'         	=> $MenuPosition_Widgets,
				'supports'              	=> array('title', 'editor'),
			);
			register_post_type('ts_widgets', $args);
			
			$labels = array(
				'name'                  	=> __( 'Categories', 'ts_visual_composer_extend' ),
				'singular_name'         	=> __( 'Category', 'ts_visual_composer_extend' ),
				'search_items'          	=> __( 'Search in Categories', 'ts_visual_composer_extend' ),
				'all_items'             	=> __( 'Categories', 'ts_visual_composer_extend' ),
				'parent_item'           	=> __( 'Parent Category', 'ts_visual_composer_extend' ),
				'parent_item_colon'     	=> __( 'Parent Category:', 'ts_visual_composer_extend' ),
				'edit_item'             	=> __( 'Edit Category', 'ts_visual_composer_extend' ), 
				'update_item'           	=> __( 'Update Category', 'ts_visual_composer_extend' ),
				'add_new_item'          	=> __( 'Add New Category', 'ts_visual_composer_extend' ),
				'new_item_name'         	=> __( 'New Category', 'ts_visual_composer_extend' ),
				'menu_name'             	=> __( 'Categories', 'ts_visual_composer_extend' )
			);
			
			register_taxonomy(
				'ts_widgets_category',
				array('ts_widgets'),
				array(
					'hierarchical'          => true,
					'public'                => false,
					'labels'                => $labels,
					'show_ui'               => true,
					'rewrite'               => true,
					'show_admin_column'		=> true,
				)
			);
			
			new TS_VCSC_Tax_CTP_Filter(array('ts_widgets' => array('ts_widgets_category')));
		}
		add_action('init', 'TS_VCSC_Widgets_Post_Type');
		
		// Register Post Type with Visual Composer
		function TS_VCSC_Widgets_Post_Compooser() {
			if ((function_exists('vc_editor_post_types')) && (function_exists('vc_set_default_editor_post_types')) && (function_exists('vc_settings'))) {
				$TS_VCSC_ComposerContentTypes 		= vc_editor_post_types();
				$TS_VCSC_ComposerDefaultTypes 		= array();
				if (!in_array('ts_widgets', $TS_VCSC_ComposerContentTypes, true)) {
					foreach ($TS_VCSC_ComposerContentTypes as $value) {
						array_push($TS_VCSC_ComposerDefaultTypes, $value);
					}
					array_push($TS_VCSC_ComposerDefaultTypes, 'ts_widgets');
					vc_set_default_editor_post_types($TS_VCSC_ComposerDefaultTypes);
					vc_settings()->set('content_types', $TS_VCSC_ComposerDefaultTypes);
				}
			}
		}
		add_action('init', 'TS_VCSC_Widgets_Post_Compooser', 777777777);
		
		// Remove Standard Filters
		function TS_VCSC_Widgets_Remove_Filter_Drops(){
			global $post_type;
			if ('ts_widgets' == $post_type) {
				//add_filter('months_dropdown_results', '__return_empty_array');
				add_filter('wp_dropdown_cats', '__return_false' );
			}
		}
		add_action('admin_head', 'TS_VCSC_Widgets_Remove_Filter_Drops');
	}

	// Create "VC Timelines" Post Type and Custom Taxonomies
	if ($this->TS_VCSC_CustomPostTypesTimeline == "true") {
		function TS_VCSC_Timeline_Post_Type() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			$MenuPosition_Timeline			= (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions)) && (array_key_exists('ts_timeline', $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions['ts_timeline'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Menu_Positions_Defaults['ts_timeline']);
			$labels = array(
				'name'                  	=> __( 'Timeline Sections', 'ts_visual_composer_extend' ),
				'singular_name'         	=> __( 'Timeline Section', 'ts_visual_composer_extend' ),
				'add_new'               	=> __( 'Add New', 'ts_visual_composer_extend' ),
				'add_new_item'          	=> __( 'Add New Timeline Section', 'ts_visual_composer_extend'  ),
				'edit_item'             	=> __( 'Edit Timeline Section', 'ts_visual_composer_extend'  ),
				'new_item'              	=> __( 'New Timeline Section', 'ts_visual_composer_extend'  ),
				'view_item'             	=> __( 'View Timeline Section', 'ts_visual_composer_extend'  ),
				'search_items'          	=> __( 'Search Timeline Section', 'ts_visual_composer_extend'  ),
				'not_found'             	=> __( 'No Timeline Section(s) found', 'ts_visual_composer_extend'  ),
				'not_found_in_trash'    	=> __( 'No Timeline Section(s) found in the Trash', 'ts_visual_composer_extend'  ), 
				'parent_item_colon'     	=> '',
				'menu_name'             	=> 'VC Timelines'
			);
			$args = array(
				'labels'                	=> $labels,
				'description'           	=> __( 'Add Timeline sections to be used with the "Composium - Visual Composer Extensions" plugin.', 'ts_visual_composer_extend' ),
				'public'                	=> false,
				'menu_icon' 				=> TS_VCSC_GetResourceURL("css/other/ts_timeline_admin.png"),
				'rewrite'               	=> true,
				'exclude_from_search'		=> true,
				'publicly_queryable'    	=> false,
				'show_ui'               	=> true,
				'show_in_menu'          	=> true, 
				'query_var'             	=> true,
				'capability_type'       	=> 'post',
				'has_archive'           	=> false, 
				'hierarchical'          	=> false,
				'menu_position'         	=> $MenuPosition_Timeline,
				'supports'              	=> array('title'),
				'taxonomies' 				=> array('ts_timeline_category', 'ts_timeline_tags'),
			);
			register_post_type('ts_timeline', $args);
			
			$labels = array(
				'name'                  	=> __( 'Timelines / Categories', 'ts_visual_composer_extend' ),
				'singular_name'         	=> __( 'Timeline', 'ts_visual_composer_extend' ),
				'search_items'          	=> __( 'Search in Timelines / Categories', 'ts_visual_composer_extend' ),
				'all_items'             	=> __( 'Timelines / Categories', 'ts_visual_composer_extend' ),
				'parent_item'           	=> __( 'Parent Timeline / Category', 'ts_visual_composer_extend' ),
				'parent_item_colon'     	=> __( 'Parent Timeline / Category:', 'ts_visual_composer_extend' ),
				'edit_item'             	=> __( 'Edit Timeline / Category', 'ts_visual_composer_extend' ), 
				'update_item'           	=> __( 'Update Timeline / Category', 'ts_visual_composer_extend' ),
				'add_new_item'          	=> __( 'Add New Timeline / Category', 'ts_visual_composer_extend' ),
				'new_item_name'         	=> __( 'New Timeline / Category', 'ts_visual_composer_extend' ),
				'menu_name'             	=> __( 'Categories', 'ts_visual_composer_extend' )
			);
			
			register_taxonomy(
				'ts_timeline_category',
				array('ts_timeline'),
				array(
					'hierarchical'          => true,
					'public'                => false,
					'labels'                => $labels,
					'show_ui'               => true,
					'rewrite'               => true,
					'show_admin_column'		=> true,
				)
			);
			
			new TS_VCSC_Tax_CTP_Filter(array('ts_timeline' => array('ts_timeline_category')));
			
			$labels = array(
				'name' 							=> __( 'Timeline Section Tags', 'ts_visual_composer_extend' ),
				'singular_name' 				=> __( 'Timeline Section Tag', 'ts_visual_composer_extend' ),
				'search_items' 					=>  __( 'Search Timeline Section Tags' ),
				'popular_items' 				=> __( 'Popular Timeline Section Tags' ),
				'all_items' 					=> __( 'All Timeline Section Tags' ),
				'parent_item' 					=> null,
				'parent_item_colon' 			=> null,
				'edit_item' 					=> __( 'Edit Tag' ), 
				'update_item' 					=> __( 'Update Tag' ),
				'add_new_item' 					=> __( 'Add New Tag' ),
				'new_item_name' 				=> __( 'New Tag Name' ),
				'separate_items_with_commas' 	=> __( 'Separate tags with commas' ),
				'add_or_remove_items' 			=> __( 'Add or remove tags' ),
				'choose_from_most_used' 		=> __( 'Choose from the most used tags' ),
				'menu_name' 					=> __( 'Section Tags' ),
			); 
		
			register_taxonomy(
				'ts_timeline_tags',
				array('ts_timeline'),
				array(
					'hierarchical' 				=> false,
					'labels' 					=> $labels,
					'show_ui' 					=> true,
					'update_count_callback' 	=> '_update_post_term_count',
					'query_var' 				=> true,
					'rewrite' 					=> array('slug' => 'tag'),
				)
			);
		}
		add_action('init', 'TS_VCSC_Timeline_Post_Type');
		
		// Remove Standard Filters
		function TS_VCSC_Timeline_Remove_Filter_Drops(){
			global $post_type;
			if ('ts_timeline' == $post_type) {
				//add_filter('months_dropdown_results', '__return_empty_array');
				add_filter('wp_dropdown_cats', '__return_false' );
			}
		}
		add_action('admin_head', 'TS_VCSC_Timeline_Remove_Filter_Drops');
	
		function TS_VCSC_Timeline_Post_Parents() {
			global $post_type;
			if ('ts_timeline' != $post_type) {
				return;
			} else {
				echo '<script type="text/javascript">';
					echo 'jQuery(".form-field.term-parent-wrap").hide();';
				echo '</script>';
			}
		}
		add_action('admin_footer-edit-tags.php',     	'TS_VCSC_Timeline_Post_Parents');
		
		// Create Custom Column "Section Tags"
		function TS_VCSC_Timeline_Set_CustomColumn_PostType($columns) {
			unset($columns['date']);
			unset($columns['tags']);
			$columns['cb'] 									= '<input type="checkbox" />';		 
			$columns['title'] 								= _x('Title', 'ts_visual_composer_extend');
			$columns['taggs'] 								= __('Section Tags', 'ts_visual_composer_extend');	
			$columns['date'] 								= _x('Post Date', 'ts_visual_composer_extend');
			return $columns;
		}
		add_filter('manage_edit-ts_timeline_columns', 'TS_VCSC_Timeline_Set_CustomColumn_PostType');
		
		
		// Pull Tag Data for Custom Column
		function TS_VCSC_Timeline_Get_CustomColumn_Tags($column, $post_id) {
			switch ($column) {
				case 'taggs' :
					$admin_url								= get_admin_url();
					$sections_tags							= get_the_terms($post_id, 'ts_timeline_tags');
					$array_string							= '';
					$array_tags								= array();
					$array_data								= array();
					if ($sections_tags != false) {
						foreach ($sections_tags as $tag) {
							$array_data = array(
								'id' 		=> $tag->term_id,
								'name' 		=> $tag->name,
								'slug' 		=> $tag->slug,
								'link' 		=> $admin_url . 'edit.php?post_type=ts_timeline&ts_timeline_tags=' . $tag->slug,
							);
							$array_tags[] 					= $array_data;
						}
						foreach ($array_tags as $index => $array) {
							$array_string .= '<a id="ts-timeline-tags-' . $array['id'] . '" data-slug="' . $array['slug'] . '" href="' . $array['link'] . '">' . $array['name'] . '</a>, ';
						}
					}
					if ($array_string != '') {
						echo substr($array_string, 0, -2);
					} else {
						echo '&mdash;';
					}
					break;
			}
		}
		add_action('manage_ts_timeline_posts_custom_column' , 'TS_VCSC_Timeline_Get_CustomColumn_Tags', 10, 2);
	}
	
    // Create "VC Team" Post Type and Custom Taxonomies
	if ($this->TS_VCSC_CustomPostTypesTeam == "true") {
		function TS_VCSC_Team_Post_Type() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			$MenuPosition_Team				= (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions)) && (array_key_exists('ts_team', $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions['ts_team'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Menu_Positions_Defaults['ts_team']);
			$labels = array(
				'name'                  	=> __( 'Members', 'ts_visual_composer_extend' ),
				'singular_name'         	=> __( 'Team Member', 'ts_visual_composer_extend' ),
				'add_new'               	=> __( 'Add New', 'ts_visual_composer_extend' ),
				'add_new_item'          	=> __( 'Add New Teammate', 'ts_visual_composer_extend'  ),
				'edit_item'             	=> __( 'Edit Teammate', 'ts_visual_composer_extend'  ),
				'new_item'              	=> __( 'New Teammate', 'ts_visual_composer_extend'  ),
				'view_item'             	=> __( 'View Teammate', 'ts_visual_composer_extend'  ),
				'search_items'          	=> __( 'Search Teammates', 'ts_visual_composer_extend'  ),
				'not_found'             	=> __( 'No Teammate(s) found', 'ts_visual_composer_extend'  ),
				'not_found_in_trash'    	=> __( 'No Teammate(s) found in the Trash', 'ts_visual_composer_extend'  ), 
				'parent_item_colon'     	=> '',
				'menu_name'             	=> 'VC Team'
			);
			$args = array(
				'labels'                	=> $labels,
				'description'           	=> __( 'Add Team Information to be used with the "Composium - Visual Composer Extensions" plugin.', 'ts_visual_composer_extend' ),
				'public'                	=> false,
				'menu_icon' 				=> TS_VCSC_GetResourceURL("css/other/ts_team_admin.png"),
				'rewrite'               	=> true,
				'exclude_from_search'		=> true,
				'publicly_queryable'    	=> false,
				'show_ui'               	=> true,
				'show_in_menu'          	=> true, 
				'query_var'             	=> true,
				'capability_type'       	=> 'post',
				'has_archive'           	=> false, 
				'hierarchical'          	=> false,
				'menu_position'         	=> $MenuPosition_Team,
				'supports'              	=> array('title', 'editor', 'thumbnail'),
			);
			register_post_type('ts_team', $args);
			
			$labels = array(
				'name'                  	=> __( 'Team / Group', 'ts_visual_composer_extend' ),
				'singular_name'         	=> __( 'Team / Group', 'ts_visual_composer_extend' ),
				'search_items'          	=> __( 'Search in Teams / Groups', 'ts_visual_composer_extend' ),
				'all_items'             	=> __( 'Teams / Groups', 'ts_visual_composer_extend' ),
				'parent_item'           	=> __( 'Parent Team / Group', 'ts_visual_composer_extend' ),
				'parent_item_colon'     	=> __( 'Parent Team / Group:', 'ts_visual_composer_extend' ),
				'edit_item'             	=> __( 'Edit Team / Group', 'ts_visual_composer_extend' ), 
				'update_item'           	=> __( 'Update Team / Group', 'ts_visual_composer_extend' ),
				'add_new_item'          	=> __( 'Add New Team / Group', 'ts_visual_composer_extend' ),
				'new_item_name'         	=> __( 'New Team / Group Name', 'ts_visual_composer_extend' ),
				'menu_name'             	=> __( 'Teams / Groups', 'ts_visual_composer_extend' )
			);
			
			register_taxonomy(
				'ts_team_category',
				array('ts_team'),
				array(
					'hierarchical'          => true,
					'public'                => false,
					'labels'                => $labels,
					'show_ui'               => true,
					'rewrite'               => true,
					'show_admin_column'		=> true,
				)
			);
			
			new TS_VCSC_Tax_CTP_Filter(array('ts_team' => array('ts_team_category')));
		}
		add_action('init', 'TS_VCSC_Team_Post_Type');
	
		// Remove Standard Filters
		function TS_VCSC_Team_Remove_Filter_Drops(){
			global $post_type;
			if ('ts_team' == $post_type) {
				//add_filter('months_dropdown_results', '__return_empty_array');
				add_filter('wp_dropdown_cats', '__return_false' );
			}
		}
		add_action('admin_head', 'TS_VCSC_Team_Remove_Filter_Drops');
	}

    // Create "VC Testimonials" Post Type and Custom Taxonomies
	if ($this->TS_VCSC_CustomPostTypesTestimonial == "true") {
		function TS_VCSC_Testimonials_Post_Type() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			$MenuPosition_Testimonials		= (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions)) && (array_key_exists('ts_testimonials', $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions['ts_testimonials'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Menu_Positions_Defaults['ts_testimonials']);
			$labels = array(
				'name'                  	=> __( 'Testimonials', 'ts_visual_composer_extend' ),
				'singular_name'         	=> __( 'Testimonial', 'ts_visual_composer_extend' ),
				'add_new'               	=> __( 'Add New', 'ts_visual_composer_extend' ),
				'add_new_item'          	=> __( 'Add New Testimonial', 'ts_visual_composer_extend' ),
				'edit_item'             	=> __( 'Edit Testimonial', 'ts_visual_composer_extend' ),
				'new_item'              	=> __( 'New Testimonial', 'ts_visual_composer_extend' ),
				'view_item'             	=> __( 'View Testimonial', 'ts_visual_composer_extend' ),
				'search_items'          	=> __( 'Search Testimonials', 'ts_visual_composer_extend' ),
				'not_found'             	=> __( 'No Testimonial(s) found', 'ts_visual_composer_extend' ),
				'not_found_in_trash'    	=> __( 'No Testimonial(s) found in the Trash', 'ts_visual_composer_extend' ), 
				'parent_item_colon'     	=> '',
				'menu_name'             	=> 'VC Testimonials'
			);
			$args = array(
				'labels'                	=> $labels,
				'description'           	=> __( 'Add Testimonials to be used with the "Composium - Visual Composer Extensions" plugin.', 'ts_visual_composer_extend' ),
				'public'                	=> false,
				'menu_icon' 				=> TS_VCSC_GetResourceURL("css/other/ts_testimonial_admin.png"),
				'rewrite'               	=> true,
				'exclude_from_search'		=> true,
				'publicly_queryable'    	=> false,
				'show_ui'               	=> true,
				'show_in_menu'          	=> true, 
				'query_var'             	=> true,
				'capability_type'       	=> 'post',
				'has_archive'           	=> false, 
				'hierarchical'          	=> false,
				'menu_position'         	=> $MenuPosition_Testimonials,
				'supports'              	=> array('title', 'editor', 'thumbnail'),
				'taxonomies' 				=> array('ts_testimonials_category'),
			);
			register_post_type('ts_testimonials', $args);
			
			$labels = array(
				'name'                  	=> __( 'Categories', 'ts_visual_composer_extend' ),
				'singular_name'         	=> __( 'Category', 'ts_visual_composer_extend' ),
				'search_items'          	=> __( 'Search in Categories', 'ts_visual_composer_extend' ),
				'all_items'             	=> __( 'Categories', 'ts_visual_composer_extend' ),
				'parent_item'           	=> __( 'Parent Category', 'ts_visual_composer_extend' ),
				'parent_item_colon'     	=> __( 'Parent Category:', 'ts_visual_composer_extend' ),
				'edit_item'             	=> __( 'Edit Category', 'ts_visual_composer_extend' ), 
				'update_item'           	=> __( 'Update Category', 'ts_visual_composer_extend' ),
				'add_new_item'          	=> __( 'Add New Category', 'ts_visual_composer_extend' ),
				'new_item_name'         	=> __( 'New Category', 'ts_visual_composer_extend' ),
				'menu_name'             	=> __( 'Categories', 'ts_visual_composer_extend' )
			);
			
			register_taxonomy(
				'ts_testimonials_category',
				array('ts_testimonials'),
				array(
					'hierarchical'          => true,
					'public'                => false,
					'labels'                => $labels,
					'show_ui'               => true,
					'rewrite'               => true,
					'show_admin_column'		=> true,
				)
			);
			
			new TS_VCSC_Tax_CTP_Filter(array('ts_testimonials' => array('ts_testimonials_category')));
		}
		add_action('init', 'TS_VCSC_Testimonials_Post_Type');
	
		// Remove Standard Filters
		function TS_VCSC_Testimonials_Remove_Filter_Drops(){
			global $post_type;
			if ('ts_testimonials' == $post_type) {
				//add_filter('months_dropdown_results', '__return_empty_array');
				add_filter('wp_dropdown_cats', '__return_false' );
			}
		}
		add_action('admin_head', 'TS_VCSC_Testimonials_Remove_Filter_Drops');
	}
	
    // Create "VC Skillsets" Post Type and Custom Taxonomies
	if ($this->TS_VCSC_CustomPostTypesSkillset == "true") {
		function TS_VCSC_Skillsets_Post_Type() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			$MenuPosition_Skillsets			= (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions)) && (array_key_exists('ts_skillsets', $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions['ts_skillsets'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Menu_Positions_Defaults['ts_skillsets']);
			$labels = array(
				'name'                  	=> __( 'Skillsets', 'ts_visual_composer_extend' ),
				'singular_name'         	=> __( 'Skillset', 'ts_visual_composer_extend' ),
				'add_new'               	=> __( 'Add New', 'ts_visual_composer_extend' ),
				'add_new_item'          	=> __( 'Add New Skillset', 'ts_visual_composer_extend'  ),
				'edit_item'             	=> __( 'Edit Skillset', 'ts_visual_composer_extend'  ),
				'new_item'              	=> __( 'New Skillset', 'ts_visual_composer_extend'  ),
				'view_item'             	=> __( 'View Skillset', 'ts_visual_composer_extend'  ),
				'search_items'          	=> __( 'Search Skillsets', 'ts_visual_composer_extend'  ),
				'not_found'             	=> __( 'No Skillset(s) found', 'ts_visual_composer_extend'  ),
				'not_found_in_trash'    	=> __( 'No Skillset(s) found in the Trash', 'ts_visual_composer_extend'  ), 
				'parent_item_colon'     	=> '',
				'menu_name'             	=> 'VC Skillsets'
			);
			$args = array(
				'labels'                	=> $labels,
				'description'           	=> __( 'Add Skillsets to be used with the "Composium - Visual Composer Extensions" plugin.', 'ts_visual_composer_extend' ),
				'public'                	=> false,
				'menu_icon' 				=> TS_VCSC_GetResourceURL("css/other/ts_skillset_admin.png"),
				'rewrite'               	=> true,
				'exclude_from_search'		=> true,
				'publicly_queryable'    	=> false,
				'show_ui'               	=> true,
				'show_in_menu'          	=> true, 
				'query_var'             	=> true,
				'capability_type'       	=> 'post',
				'has_archive'           	=> false, 
				'hierarchical'          	=> false,
				'menu_position'         	=> $MenuPosition_Skillsets,
				'supports'              	=> array('title'),
			);
			register_post_type('ts_skillsets', $args);
			
			$labels = array(
				'name'                  	=> __( 'Categories', 'ts_visual_composer_extend' ),
				'singular_name'         	=> __( 'Category', 'ts_visual_composer_extend' ),
				'search_items'          	=> __( 'Search in Categories', 'ts_visual_composer_extend' ),
				'all_items'             	=> __( 'Categories', 'ts_visual_composer_extend' ),
				'parent_item'           	=> __( 'Parent Category', 'ts_visual_composer_extend' ),
				'parent_item_colon'     	=> __( 'Parent Category:', 'ts_visual_composer_extend' ),
				'edit_item'             	=> __( 'Edit Category', 'ts_visual_composer_extend' ), 
				'update_item'           	=> __( 'Update Category', 'ts_visual_composer_extend' ),
				'add_new_item'          	=> __( 'Add New Category', 'ts_visual_composer_extend' ),
				'new_item_name'         	=> __( 'New Category', 'ts_visual_composer_extend' ),
				'menu_name'             	=> __( 'Categories', 'ts_visual_composer_extend' )
			);
			
			register_taxonomy(
				'ts_skillsets_category',
				array('ts_skillsets'),
				array(
					'hierarchical'          => true,
					'public'                => false,
					'labels'                => $labels,
					'show_ui'               => true,
					'rewrite'               => true,
					'show_admin_column'		=> true,
				)
			);
			
			new TS_VCSC_Tax_CTP_Filter(array('ts_skillsets' => array('ts_skillsets_category')));
		}
		add_action('init', 'TS_VCSC_Skillsets_Post_Type');
		
		// Remove Standard Filters
		function TS_VCSC_Skillsets_Remove_Filter_Drops(){
			global $post_type;
			if ('ts_skillsets' == $post_type) {
				//add_filter('months_dropdown_results', '__return_empty_array');
				add_filter('wp_dropdown_cats', '__return_false' );
			}
		}
		add_action('admin_head', 'TS_VCSC_Skillsets_Remove_Filter_Drops');
	}
	
    // Create "VC Logos" Post Type and Custom Taxonomies
	if ($this->TS_VCSC_CustomPostTypesLogo == "true") {
		function TS_VCSC_Logos_Post_Type() {
			global $VISUAL_COMPOSER_EXTENSIONS;
			$MenuPosition_Logos				= (((is_array($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions)) && (array_key_exists('ts_logos', $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions))) ? $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_CustomPostTypesPositions['ts_logos'] : $VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_Menu_Positions_Defaults['ts_logos']);
			$labels = array(
				'name'                  	=> __( 'Logos', 'ts_visual_composer_extend' ),
				'singular_name'         	=> __( 'Logo', 'ts_visual_composer_extend' ),
				'add_new'               	=> __( 'Add New', 'ts_visual_composer_extend' ),
				'add_new_item'          	=> __( 'Add New Logo', 'ts_visual_composer_extend'  ),
				'edit_item'             	=> __( 'Edit Logo', 'ts_visual_composer_extend'  ),
				'new_item'              	=> __( 'New Logo', 'ts_visual_composer_extend'  ),
				'view_item'             	=> __( 'View Logo', 'ts_visual_composer_extend'  ),
				'search_items'          	=> __( 'Search Logos', 'ts_visual_composer_extend'  ),
				'not_found'             	=> __( 'No Logo(s) found', 'ts_visual_composer_extend'  ),
				'not_found_in_trash'    	=> __( 'No Logo(s) found in the Trash', 'ts_visual_composer_extend'  ), 
				'parent_item_colon'     	=> '',
				'menu_name'             	=> 'VC Logos'
			);
			$args = array(
				'labels'                	=> $labels,
				'description'           	=> __( 'Add Logos to be used with the "Composium - Visual Composer Extensions" plugin.', 'ts_visual_composer_extend' ),
				'public'                	=> false,
				'menu_icon' 				=> TS_VCSC_GetResourceURL("css/other/ts_logo_admin.png"),
				'rewrite'               	=> true,
				'exclude_from_search'		=> true,
				'publicly_queryable'    	=> false,
				'show_ui'               	=> true,
				'show_in_menu'          	=> true, 
				'query_var'             	=> true,
				'capability_type'       	=> 'post',
				'has_archive'           	=> false, 
				'hierarchical'          	=> false,
				'menu_position'         	=> $MenuPosition_Logos,
				'supports'              	=> array('title', 'thumbnail'),
			);
			register_post_type('ts_logos', $args);
			
			$labels = array(
				'name'                  	=> __( 'Categories', 'ts_visual_composer_extend' ),
				'singular_name'         	=> __( 'Category', 'ts_visual_composer_extend' ),
				'search_items'          	=> __( 'Search in Categories', 'ts_visual_composer_extend' ),
				'all_items'             	=> __( 'Categories', 'ts_visual_composer_extend' ),
				'parent_item'           	=> __( 'Parent Category', 'ts_visual_composer_extend' ),
				'parent_item_colon'     	=> __( 'Parent Category:', 'ts_visual_composer_extend' ),
				'edit_item'             	=> __( 'Edit Category', 'ts_visual_composer_extend' ), 
				'update_item'           	=> __( 'Update Category', 'ts_visual_composer_extend' ),
				'add_new_item'          	=> __( 'Add New Category', 'ts_visual_composer_extend' ),
				'new_item_name'         	=> __( 'New Category', 'ts_visual_composer_extend' ),
				'menu_name'             	=> __( 'Categories', 'ts_visual_composer_extend' )
			);
			
			register_taxonomy(
				'ts_logos_category',
				array('ts_logos'),
				array(
					'hierarchical'          => true,
					'public'                => false,
					'labels'                => $labels,
					'show_ui'               => true,
					'rewrite'               => true,
					'show_admin_column'		=> true,
				)
			);
			
			new TS_VCSC_Tax_CTP_Filter(array('ts_logos' => array('ts_logos_category')));
		}
		add_action('init', 'TS_VCSC_Logos_Post_Type');
	
		// Remove Standard Filters
		function TS_VCSC_Logos_Remove_Filter_Drops(){
			global $post_type;
			if ('ts_logos' == $post_type) {
				//add_filter('months_dropdown_results', '__return_empty_array');
				add_filter('wp_dropdown_cats', '__return_false' );
			}
		}
		add_action('admin_head', 'TS_VCSC_Logos_Remove_Filter_Drops');
	}
?>