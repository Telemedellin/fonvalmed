<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package fonvalmed
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area col-sm-3" role="complementary">
	<?php dynamic_sidebar(); ?>
</aside><!-- #secondary -->
