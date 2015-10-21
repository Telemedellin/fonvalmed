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
		<div class="ctn__contador-obras container-fluid">
			<div class="row">
				<div class="col-xs-6 col-md-3">
					<div class="contador-obra contador-obras-finalizadas">
						<h3 class="contador-obra-titulo">
							Obras finalizadas
						</h3>
						<span class="contador-obra-numero">
							10
						</span>
					</div>
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="contador-obra contador-obras-ejecucion">
						<h3 class="contador-obra-titulo">
							Obras en ejecución
						</h3>
						<span class="contador-obra-numero">
							10
						</span>
					</div>
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="contador-obra contador-obras-licitacion">
						<h3 class="contador-obra-titulo">
							Obras en licitación
						</h3>
						<span class="contador-obra-numero">
							10
						</span>
					</div>
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="contador-obra contador-obras-ejecutar">
						<h3 class="contador-obra-titulo">
							Obras ejecutadas
						</h3>
						<span class="contador-obra-numero">
							10
						</span>
					</div>
				</div>
			</div>
		</div><!-- /ctn__contador-obras -->
		<h2 class="subtitulos">Recaudo</h2>
		<div class="ctn__recaudo container-fluid">
			<div class="row">
				<div class="col-md-5">
					<div class="ctn__recaudo_texto">
						<p class="recaudo-texto">
							Con tu aporte estamos haciendo realidad las obras en El Poblado
						</p>
					</div>
				</div>
				<div class="col-md-7">
					<div class="ctn__recaudo_total">
						<p class="recaudo-total-texto">Recuado contribución de valorización - <span class="recaudo-total-fecha">Hoy 04 de junio</span></p>
						<span class="recaudo-total-numero">$100.897.9000.009</span>
					</div>
				</div>
			</div>
		</div><!-- /ctn__recaudo -->
		<div class="ctn__info-recaudo container-fluid">
			<div class="row">
				<div class="col-sm-9">
					<div class="ctn__infor-recaudo_grafico">
						Gráficos
					</div>
				</div>
				<div class="col-sm-3">
					<div class="ctn__info-recaudo_propietarios">
						<h3 class="info-recaudo_propietarios_title">
							Propietarios que han pagado el total de la contibución
						</h3>
						<span class="info-recaudo_propietarios_total">
							10.999
						</span>
					</div>
				</div>
			</div>
		</div><!-- /ctn__info-recaudo -->
		
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php fonvalmed_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
