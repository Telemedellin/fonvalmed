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
			<a href="#">Listado<span></span></a>
		</div>
		<div id="obra-filtro-tipo">
			<a href="#">Mapa<span></span></a>
		</div>
		<p>
			Utiliza los siguientes filtros para conocer las obras.
		</p>
		<div>
			<div id="obra-listado" class="col-md-12">
				<div class="filtros col-md-4">
					<span>Estado de la obra</span>
					<span>Finalizados</span>
					<span>En ejecución</span>
					<span>Por ejecutar</span>
					<span>En licitación</span>
				</div>
				<div class="filtros col-md-4">
					<span>Zona de influencia</span>
				</div>
				<div class="filtros col-md-4">
					<span>Tipo de obra</span>
					<span>Ampliación</span>
					<span>Apertura</span>
					<span>Paso a desnivel</span>
					<span>Otras obras</span>
				</div>
				<div class="obras col-md-12">
					<?php $index = 0; ?>
					<?php foreach(get_term_children($terms->term_id, $terms->taxonomy) as $term_id): ?>
						<div class="col-md-4">
							<div>
								<?php $obra = get_term($term_id, $terms->taxonomy); ?>
								<div></div>
								<p><?php echo $obra->name; ?></p>
								<p><?php echo get_field('obra_estado', $terms->taxonomy.'_'.$term_id); ?></p>
								<hr class="linea">
								<div class="obra-avance">
									<span class="texto"><?php echo get_field('obra_avance', $terms->taxonomy.'_'.$term_id); ?>%</span>
									<span class="porcentaje" style="width: <?php echo get_field('obra_avance', $terms->taxonomy.'_'.$term_id); ?>%;"></span>
								</div>
							</div>
						</div>
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
		var location = {lat: <?php echo $location['lat']; ?>, lng: <?php echo $location['lng']; ?>};
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