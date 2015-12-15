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
			<style>
				#filtro > .col-sm-4 > label {
					padding-left: 15px;
				}
			</style>
			<form id="filtro" method="POST">
				<div class="col-sm-4">
					<label>Fecha inicio</label>
					<div class="col-md-8">
						<input type="text" id="txtDesde" name="txtDesde" class="form-control" placeholder="Seleccione fecha" readonly>
					</div>
					<div class="col-md-4">
						<img id="calendar-desde" src="<?php echo get_template_directory_uri(). '/img/datepicker.png'; ?>" />
					</div>
				</div>
				<div class="col-sm-4">
					<label>Fecha fin</label>
					<div class="col-md-8">
						<input type="text" id="txtHasta" name="txtHasta" class="form-control" placeholder="Seleccione fecha" readonly>
					</div>
					<div class="col-md-4">
						<img id="calendar-hasta" src="<?php echo get_template_directory_uri(). '/img/datepicker.png'; ?>" />
					</div>
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

