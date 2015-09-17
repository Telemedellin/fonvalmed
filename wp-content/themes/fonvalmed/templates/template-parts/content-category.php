<?php
/**
 * Template part for displaying single posts.
 *
 * @package fonvalmed
 */
?>

<article id="obra-<?php echo $terms->term_id; ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php echo $terms->name; ?></h1>
		<?php the_field('obra_contenido', $terms->taxonomy.'_'.$terms->term_id); ?>
		<div class="entry-meta"></div>
		<!-- .entry-meta -->
	</header>
	<!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<!-- .entry-content -->
</article>
<!-- #post-## -->