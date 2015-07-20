<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package fonvalmed
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function fonvalmed_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'fonvalmed_infinite_scroll_render',
		'footer'    => 'page',
	) );
} // end function fonvalmed_jetpack_setup
add_action( 'after_setup_theme', 'fonvalmed_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function fonvalmed_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
} // end function fonvalmed_infinite_scroll_render
