<?php
/**
 * fonvalmed functions and definitions
 *
 * @package fonvalmed
 */

if ( ! function_exists( 'fonvalmed_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function fonvalmed_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on fonvalmed, use a find and replace
	 * to change 'fonvalmed' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'fonvalmed', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Menú principal', 'fonvalmed' ),
		'footer' => esc_html__( 'Menú footer', 'fonvalmed' ),
		'secondary' => esc_html__( 'Menú superior', 'fonvalmed' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'fonvalmed_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // fonvalmed_setup
add_action( 'after_setup_theme', 'fonvalmed_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fonvalmed_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fonvalmed_content_width', 640 );
}
add_action( 'after_setup_theme', 'fonvalmed_content_width', 0 );

function get_admin_path() {
	// Replace the site base URL with the absolute path to its installation directory. 
	$admin_path = str_replace( get_bloginfo( 'url' ) . '/', ABSPATH, get_admin_url() );
	
	// Make it filterable, so other plugins can hook into it.
	$admin_path = apply_filters( 'my_plugin_get_admin_path', $admin_path );
	return $admin_path;
}

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function fonvalmed_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'fonvalmed' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'fonvalmed' ),
		'id'            => 'sidebar-footer-1',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget ctn_widget-footer">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title-footer">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'fonvalmed' ),
		'id'            => 'sidebar-footer-2',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget ctn_widget-footer">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title-footer">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'fonvalmed' ),
		'id'            => 'sidebar-footer-3',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget ctn_widget-footer">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title-footer">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 4', 'fonvalmed' ),
		'id'            => 'sidebar-footer-4',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget ctn_widget-footer">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title-footer">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Proyecto', 'proyecto' ),
		'id'            => 'proyecto',
		'description'   => 'Widget relacionado con la informacion de las obras de cada proyecto ',
		'before_widget' => '<div id="%1$s" class="widget ctn_widget-proyecto">',
		'after_widget'  => '</div>',
	) );
}
add_action( 'widgets_init', 'fonvalmed_widgets_init' );


/**
* Funcion adicional para instanciar los Widgets creados
**/

function creaWidgets()
{
	// Widget Avance de la obra 
	 register_widget( 'WidgetAvanceProyecto' );

}
add_action( 'widgets_init', 'creaWidgets' );




/**
 * Enqueue scripts and styles.
 */
function fonvalmed_scripts() {
	wp_enqueue_style( 'fonvalmed-style', get_stylesheet_uri() );

	wp_enqueue_script( 'fonvalmed-masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array(), true );

	wp_enqueue_script( 'fonvalmed-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'fonvalmed-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	wp_enqueue_script( 'fonvalmed-script', get_template_directory_uri() . '/js/script.js', array(), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'fonvalmed_scripts' );

// Register Custom Taxonomy
function custom_taxonomy_obras() {

	$labels = array(
		'name'                       => _x( 'Nombre obras', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Nombre obra', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Nombre obra', 'text_domain' ),
		'all_items'                  => __( 'Todas los nombres de las obras', 'text_domain' ),
		'parent_item'                => __( 'Superior', 'text_domain' ),
		'parent_item_colon'          => __( 'Superior:', 'text_domain' ),
		'new_item_name'              => __( 'Nuevo nombre obra', 'text_domain' ),
		'add_new_item'               => __( 'Añadir nuevo nombre', 'text_domain' ),
		'edit_item'                  => __( 'Editar nombre', 'text_domain' ),
		'update_item'                => __( 'Actualizar nombre', 'text_domain' ),
		'view_item'                  => __( 'Ver nombre', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                       => '/%nombre%/',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'nombre', array( 'p-valorizacion' ), $args );

}
add_action( 'init', 'custom_taxonomy_obras', 0 );

function add_custom_rewrite_rule() {

    // First, try to load up the rewrite rules. We do this just in case
    // the default permalink structure is being used.
    if( ($current_rules = get_option('rewrite_rules')) ) {

        // Next, iterate through each custom rule adding a new rule
        // that replaces 'p-valorizacion' with 'films' and give it a higher
        // priority than the existing rule.
        foreach($current_rules as $key => $val) {
            if(strpos($key, 'p-valorizacion') !== false) {
                add_rewrite_rule(str_ireplace('p-valorizacion', 'proyecto-de-valorizacion', $key), $val, 'top');   
            } // end if
        } // end foreach

    } // end if/else

    // ...and we flush the rules
    flush_rewrite_rules();

} // end add_custom_rewrite_rule
add_action('init', 'add_custom_rewrite_rule');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
* avance widgets
*/
require get_template_directory() . '/widgets/avance.php';