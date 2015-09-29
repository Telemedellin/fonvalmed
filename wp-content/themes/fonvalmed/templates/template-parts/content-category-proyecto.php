<?php
/**
 * Template part for displaying single posts.
 *
 * @package fonvalmed
 */

?>

<article id="obra-<?php echo $terms->term_id; ?>" class="obra type-obra status-publish hentry">
	<header class="entry-header">
		<h1 class="entry-title">Obras</h1>
		<!-- .entry-meta -->
	</header>
	<!-- .entry-header -->

	<div class="entry-content">
		<?php //the_field('obra_contenido', $terms->taxonomy.'_'.$terms->term_id); ?>
		<div id="obra-filtro-tipo">
			<a href="#">Listado</a>
		</div>
		<div id="obra-filtro-tipo">
			<a href="#">Mapa</a>
		</div>
		<p>
			Utiliza los siguientes filtros para conocer las obras.
		</p>
		<div>
			<div id="obra-listado" class="container-fluid">
				<div class="row ctn__filtros">
					<div class="filtros col-md-4">
						<span class="filtro-title">Estado de la obra</span>
						<span class="fm-label fm-label-active">Finalizados</span>
						<span class="fm-label">En ejecución</span>
						<span class="fm-label">Por ejecutar</span>
						<span class="fm-label">En licitación</span>
					</div>
					<div class="filtros col-md-4">
						<span class="filtro-title">Zona de influencia</span>
					</div>
					<div class="filtros col-md-4">
						<span class="filtro-title">Tipo de obra</span>
						<span class="fm-label">Ampliación</span>
						<span class="fm-label">Apertura</span>
						<span class="fm-label">Paso a desnivel</span>
						<span class="fm-label">Otras obras</span>
					</div>
				</div><!-- /ctn_filtros -->
				<div class="obras grid">
					<div class="grid-sizer"></div>
					<?php $index = 0; ?>
					<?php foreach(get_term_children($terms->term_id, $terms->taxonomy) as $term_id): ?>
						<a class="ctn__obra-preview grid-item">
							<div class="ctn__obra-preview_image" style="background: url(http://lorempixel.com/400/400/) no-repeat; background-size: 100%; background-position: center center;">
								
							</div>
							<div class="ctn__obra-preview_contenido">
								<?php $obra = get_term($term_id, $terms->taxonomy); ?>
								<h3><?php echo $obra->name; ?></h3>
								<hr class="linea">
								<span class="obra-preview_estado"><?php echo get_field('obra_estado', $terms->taxonomy.'_'.$term_id); ?></span>
								<div class="obra-avance">
									<span class="obra-avance_texto"><?php echo get_field('obra_avance', $terms->taxonomy.'_'.$term_id); ?>%</span>
									<span class="obra-avance_porcentaje" style="width: <?php echo get_field('obra_avance', $terms->taxonomy.'_'.$term_id); ?>%;"></span>
								</div>
							</div>
						</a>
						<?php $index++; ?>
					<?php endforeach; ?>
				</div>
			</div>
			<div style="clear: both;display: -webkit-inline-box;"></div>
			<div id="obra-mapas" class="col-md-12">
				<div id="obra-mapas-filtros" class="col-md-12">
					<a href="">Finalizados</a>
					<a href="">En ejecución</a>
					<a href="">Por ejecutar</a>
					<a href="">En licitación</a>
				</div>
				<style>
					#map {
						width: 100%;
						height: 400px;
					}
				</style>
				<div id="obra-map">
					<div id="map"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- .entry-content -->
</article>
<!-- #post-## -->

<script>
	function initMap()
	{
		var location = {lat: 0, lng: 0};
		var content = '<div id="obra-detalle">' +
					'<div class="obra-imagen" style="background-image:url(<?php echo $image_header['url']; ?>);"></div>' +
						'<br />' +
						'<span class="obra-titulo"><?php echo $terms->name; ?></span>' +
						'<br />' +
						'<br />' +
						'<hr class="linea">' +
						'<span class="obra-estado"><?php echo $estado; ?></span>' +
						'<br />' +
						'<div class="obra-avance">' +
							'<span class="texto"><?php echo $avance; ?>%</span>' +
							'<span class="porcentaje" style="width: <?php echo $avance; ?>%;"></span>' +
						'</div>' +
					'</div>';

		var map = new google.maps.Map(document.getElementById('map'), {
			center: location,
			zoom: 17,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		var infowindow = new google.maps.InfoWindow({
			content: content
		});
		var marker = new google.maps.Marker({
			position: location,
			map: map
			//title: ''
			//icon: ''
		});
		marker.addListener('click', function() {
			infowindow.open(map, marker);
		});
	}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?callback=initMap"></script>