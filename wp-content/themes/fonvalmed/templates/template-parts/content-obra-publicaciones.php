<?php
/**
 * Template part for displaying single posts.
 *
 * @package fonvalmed
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<table>
			<tr>
				<th>Nombre</th>
				<th>Fecha</th>
				<th>Descarga</th>
			</tr>
			<tr>
				<td>Prueba</td>
				<td>13-10-2015</td>
				<td>DESCARGA</td>
			</tr>
		</table>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
