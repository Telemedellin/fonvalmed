<?php
    global $VISUAL_COMPOSER_EXTENSIONS;	
	
	// Class to Retrieve Design Options CSS Settings
	class TS_VCSC_Element_Widget_CSS {
		static $styles;	
		static function load() {
			self::$styles = array();
			add_action('wp_footer', __class__.'::output');
			add_action('wp_enqueue_scripts', __class__.'::enqueue');
		}	
		static function exists($id) {
			return isset(self::$styles[$id]);
		}	
		static function enqueue($id) {
			wp_enqueue_style('js_composer_front');
			wp_enqueue_script('js_composer_front');
		}	
		static function add($css, $id='default') {
			if ($css) {
				if(!self::exists($id)) {
					self::$styles[$id] = '';
				}
				self::$styles[$id] .= $css;
			}
		}		
		static function output() {
			$style_string = '';
			if (is_array(self::$styles)) {
				foreach (self::$styles as $style) {
					$style_string .= $style;
				}
				if ($style_string != '') {
					echo '<style type="text/css">' . $style_string . '</style>';
				}
			} else {
				if (self::$styles != '') {
					echo '<style type="text/css">' . self::$styles . '</style>';
				}
			}			
			/*$css = implode('\n', self::$styles);
			if ($css) {
				$css = str_replace('\n', '', $css);
				echo '<style type="text/css">' . $css . '</style>';
			}*/
		}
	}
	if (!function_exists('TS_VCSC_Element_Widget_GetPost')) {
		function TS_VCSC_Element_Widget_GetPost($id) {
			if (function_exists('icl_object_id')) {
				$id = icl_object_id($id, 'post', true, ICL_LANGUAGE_CODE);
			}
			return get_post($id);
		}
	}
	if (!function_exists('TS_VCSC_Element_Widget_GetMeta')) {
		function TS_VCSC_Element_Widget_GetMeta($id, $key) {
			if (function_exists('icl_object_id')) {
				$id = icl_object_id($id, 'post', true, ICL_LANGUAGE_CODE);
			}
			return get_post_meta($id, $key, true);
		}
	}
	
	// Class for "VC Widgets" Post Type Widget
	class TS_VCSC_Element_Widget_Single extends WP_Widget {
		// Define Widget
		function __construct() {
			global $wp_version;
			$widget_ops 								= array('classname' => 'TS_VCSC_Element_Widget_Single', 'description' => __('Show Visual Composer and add-on element in your sidebar via widget.', 'ts_visual_composer_extend'));
			$control_ops 								= array();
			if (version_compare($wp_version, '4.3', '>=')) {
				parent::__construct(false, $name = __('VCE - Visual Composer Elements', 'ts_visual_composer_extend'), $widget_ops, $control_ops);
			} else {
				parent::WP_Widget(false, $name = __('VCE - Visual Composer Elements', 'ts_visual_composer_extend'), $widget_ops, $control_ops);
			}
			TS_VCSC_Element_Widget_CSS::load();
		}
		
		// Define Widget Default Values
		var $TS_VCSC_Element_Widget_Single_Defaults = array(
			'title'										=> '',
			'widget'									=> '',
			'posttitle'									=> 1,
        );
		
		// Create Widget Front-End
		public function widget($args, $instance) {
			global $VISUAL_COMPOSER_EXTENSIONS;
			extract($args);
			$title 										= apply_filters('widget_title', $instance['title']);			
			$widget 									= (isset($instance['widget']) ? esc_attr($instance['widget']) : "");
			$posttitle 									= (isset($instance['posttitle']) ? ($instance['posttitle'] ? "true" : "false") : "true");
			$post 										= TS_VCSC_Element_Widget_GetPost($widget);
			if ($post) {
				$output = $args['before_widget'];
				if ((!empty($title)) && ($posttitle == "false")) {
					$output.= $args['before_title'] . $title . $args['after_title'];
				} else if ($posttitle == "true") {
					$posttitle 							= apply_filters('the_content', $post->post_title);
					$output.= $args['before_title'] . $posttitle . $args['after_title'];
				}
				if ($VISUAL_COMPOSER_EXTENSIONS->TS_VCSC_VCFrontEditMode == "false") {
					$content 							= apply_filters('the_content', $post->post_content);
				} else {
					$content							= '<div class="ts-composer-frontedit-message">' . __( "This widget has been created with elements from Visual Composer and can not be edited with the frontend editor. Please use the custom post type 'VC Widgets' to make changes to individual widget elements, utilizing the standard WordPress backend editor.", "ts_visual_composer_extend" ) . '</div>';
				}
				$output.= $content;				
				$post_id 								= "$widget";
				if (!TS_VCSC_Element_Widget_CSS::exists($post_id)) {
					$design_options = TS_VCSC_Element_Widget_GetMeta($widget, '_wpb_post_custom_css');
					$design_options.= TS_VCSC_Element_Widget_GetMeta($widget, '_wpb_shortcodes_custom_css');					
					TS_VCSC_Element_Widget_CSS::add($design_options, $post_id);
				}	
				$output.= $args['after_widget'];
				echo $output;
			}
			
		}

		// Create Widget Backend 
		public function form( $instance ) {
			$instance 									= wp_parse_args((array) $instance, $this->TS_VCSC_Element_Widget_Single_Defaults);
			echo '<div class="ts-vcsc-widget-title-input">';
				echo '<p>';
					echo '<label class="ts-vcsc-widget-label-block" for="' . $this->get_field_id('title') . '">' . __('Title:', 'ts_visual_composer_extend') . '</label>';
					echo '<input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . esc_attr($instance['title']) . '"/>';
				echo '</p>';
			echo '</div>';
			echo '<p class="ts-vcsc-widget-title"><i class="dashicons-index-card" style="font-size: 20px; line-height: 20px; top: 2px;"></i>Widget Item:</p>';
			echo '<p>';
				$posts_count							= 0;
				$posts_fields 							= array();
				$categories								= '';
				$category_fields 						= array();
				$categories_count						= 0;
				$terms_slugs 							= array();
				$args = array(
					'no_found_rows' 					=> 1,
					'ignore_sticky_posts' 				=> 1,
					'posts_per_page' 					=> -1,
					'post_type' 						=> 'ts_widgets',
					'post_status' 						=> 'publish',
					'orderby' 							=> 'title',
					'order' 							=> 'ASC',
				);
				$widgetpost_nocategory_name				= 'ts-widget-none-applied';
				$widgetpost_nocategory					= 0;
				$widgetpost_query 						= new WP_Query($args);
				if ($widgetpost_query->have_posts()) {
					foreach($widgetpost_query->posts as $p) {
						// Get Categories
						$categories 					= TS_VCSC_GetTheCategoryByTax($p->ID, 'ts_widgets_category');							
						if ($categories && !is_wp_error($categories)) {
							$category_slugs_arr 		= array();
							foreach ($categories as $category) {
								$category_slugs_arr[] 	= $category->slug;
								$category_data = array(
									'slug'		=> $category->slug,
									'name'		=> $category->cat_name,
									'count'		=> $category->count,
								);
								$category_fields[] = $category_data;
							}
							$categories_slug_str 		= join(",", $category_slugs_arr);
						} else {
							$widgetpost_nocategory++;
							$categories_slug_str = '';
						};                            
						// Create Post Data
						$posts_data = array(
							'postid'					=> $p->ID,
							'posttitle'					=> $p->post_title,
							'postdate'					=> $p->post_date,
							'categories'				=> $categories_slug_str,
						);			
						$posts_fields[] 				= $posts_data;
						$posts_count++;
					}
				}
				wp_reset_postdata();
				$category_fields 						= array_map("unserialize", array_unique(array_map("serialize", $category_fields)));
				if ($posts_count > 1) {
					echo '<label class="ts-vcsc-widget-label-block" for="ts-vcsc-widget-filter" style="font-weight: normal; font-style: italic;">' . __('Widgets Filter:', 'ts_visual_composer_extend') . '</label>';
					echo '<input class="ts-vcsc-widget-filter" name="ts-vcsc-widget-filter" type="text" value="" style="margin-bottom: 5px;" placeholder="' . __('Enter Keyword to Filter Widgets', 'ts_visual_composer_extend') . '"/>';
				}
				echo '<div class="ts-vcsc-widget-element-select">';
				echo '<label class="ts-vcsc-widget-label-block" for="' . $this->get_field_id('widget'). '">' . __('Select Widget:', 'ts_visual_composer_extend') . '</label>';
					echo '<select id="' . $this->get_field_id('widget') . '" class="ts-vcsc-widget-select-full" name="' . $this->get_field_name('widget') . '">';
						foreach ($posts_fields as $index => $array) {
							echo '<option data-title="' . $posts_fields[$index]['posttitle'] . '" data-id="' . $posts_fields[$index]['postid'] . '" data-categories="' . $posts_fields[$index]['categories'] . '" value="' . $posts_fields[$index]['postid'] . '" ' . selected(esc_attr($instance['widget']), $posts_fields[$index]['postid'], false) . '>' . $posts_fields[$index]['posttitle'] . ' (ID: ' . $posts_fields[$index]['postid'] . ')</option>';
						}
					echo '</select>';
				echo '</div>';
				echo '<span class="ts-vcsc-widget-noresult">No widget items matching your search criteria could be found!</span>';
				echo '<div class="ts-vcsc-widget-title-checkbox">';
					echo '<p>';
						echo '<label class="ts-vcsc-widget-label-inline" for="' . $this->get_field_id('posttitle') . '">Post Title as Widget Title:</label>';
						echo '<input class="checkbox" type="checkbox" value="1" ' . checked('1', esc_attr($instance['posttitle']), false) . ' id="' . $this->get_field_id('posttitle') . '" name="' . $this->get_field_name('posttitle') . '" />';
					echo '</p>';
				echo '</div>';
			echo '</p>';
		}

		// Update Widget
		public function update($new_instance, $old_instance) {
			$instance 									= $old_instance;
			$instance['title'] 							= (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
			$instance['widget'] 						= strip_tags($new_instance['widget']);
			$instance['posttitle'] 						= strip_tags($new_instance['posttitle']);
			return $instance;
		}
	}	

	// Register and Load Widgets
	function TS_VCSC_Element_Widget_Single_Register() {
		register_widget('TS_VCSC_Element_Widget_Single');
	}	
	add_action('widgets_init', 'TS_VCSC_Element_Widget_Single_Register');

	// Custom Template Registration for "VC Widgets" Post Type
	add_filter('template_include', 'TS_VCSC_WidgetsTemplate_Chooser');
	if (!function_exists('TS_VCSC_WidgetsTemplate_Chooser')) {
		function TS_VCSC_WidgetsTemplate_Chooser($template) {		 
			// Post ID
			$post_id = get_the_ID();		 
			// For all other Custom Post Types
			if (get_post_type($post_id) != 'ts_widgets') {
				return $template;
			}		 
			// Use Custom Template
			if (is_single()) {
				return TS_VCSC_WidgetsTemplate_Hierarchy('ts_vcsc_widgets_template');
			}		 
		}
	}
	if (!function_exists('TS_VCSC_WidgetsTemplate_Hierarchy')) {
		function TS_VCSC_WidgetsTemplate_Hierarchy($template) {		 
			// Get the Template Slug
			$template_slug 		= rtrim($template, '.php');
			$template 			= $template_slug . '.php';		 
			// Check if a Custom Template exists in the Theme Folder, if not, load the Plugin Template File
			if	(file_exists(get_stylesheet_directory() . '/single.php')) {
				$file 			= get_stylesheet_directory() . '/single.php';
			} else {
				$file 			= COMPOSIUM_EXTENSIONS . '/widgets/' . $template;
			}		 
			return apply_filters('ts_vcsc_widgets_template_' . $template, $file);
		}
	}
?>