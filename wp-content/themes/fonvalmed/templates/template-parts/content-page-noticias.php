<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package fonvalmed
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
	<div class="row">
		<div class="col-md-12">
			<form id="filtro" method="POST">
				<div class="col-sm-4">
					<label>Fecha inicio</label>
					<input type="text" id="txtDesde" name="txtDesde" class="form-control" placeholder="Desde" readonly>
				</div>
				<div class="col-sm-4">
					<label>Fecha fin</label>
					<input type="text" id="txtHasta" name="txtHasta" class="form-control" placeholder="Hasta" readonly>
				</div>
				<div class="col-md-4">
					<label>&nbsp;</label>
					<input type="button" id="btnFiltrar" class="btn btn-warning form-control" value="Filtrar" >
				</div>
			</form>
		</div>
	</div>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fonvalmed' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php edit_post_link( esc_html__( 'Edit', 'fonvalmed' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

