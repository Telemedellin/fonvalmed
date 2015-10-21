<?php
/**
 * Template part for displaying single posts.
 *
 * @package fonvalmed
 */

	$image_header = get_field('obra_cabezote', $terms->taxonomy.'_'.$terms->term_id);
	$location = get_field('obra_geolocalizacion', $terms->taxonomy.'_'.$terms->term_id);

	$obra_estado = get_field_object('obra_estado', $terms->taxonomy.'_'.$terms->term_id);
	$obra_estado_valor = get_field('obra_estado', $terms->taxonomy.'_'.$terms->term_id);
	$estado = $obra_estado['choices'][$obra_estado_valor];

	$avance = get_field('obra_avance', $terms->taxonomy.'_'.$terms->term_id);

	$obra_solucion = get_field_object('obra_solucion', $terms->taxonomy.'_'.$terms->term_id);
	$obra_solucion_valor = get_field('obra_solucion', $terms->taxonomy.'_'.$terms->term_id);
	$solucion = $obra_solucion['choices'][$obra_solucion_valor];
?>

<article id="obra-<?php echo $terms->term_id; ?>" class="obra type-obra status-publish hentry">
	<header class="entry-header">
		<h1 class="entry-title">Conoce la obra</h1>
		<!-- .entry-meta -->
	</header>
	<!-- .entry-header -->

	<div class="entry-content">
		<?php if(have_rows('imagen_antes_despues', $terms->taxonomy.'_'.$terms->term_id)): ?>
		<?php while (have_rows('imagen_antes_despues', $terms->taxonomy.'_'.$terms->term_id)) : the_row(); ?>
		<?php $antes_img = get_sub_field('antes', $terms->taxonomy.'_'.$terms->term_id); ?>
		<?php $antes_pie = get_sub_field('antes_pie', $terms->taxonomy.'_'.$terms->term_id); ?>
		<?php $despues_img = get_sub_field('despues', $terms->taxonomy.'_'.$terms->term_id); ?>
		<?php $despues_pie = get_sub_field('despues_pie', $terms->taxonomy.'_'.$terms->term_id); ?>
		
		<div class="ctn__img-obras">
			<div class="img-obras_antes">
				<figure>
					<img src="<?php echo $antes_img; ?>" alt="<?php echo $antes_pie; ?>">
					<figcaption>
						<?php echo $antes_pie ?>
					</figcaption>
				</figure>
			</div>
			<div class="img-obras_despues">
				<figure>
					<img src="<?php echo $despues_img; ?>" alt="<?php echo $despues_pie; ?>">
					<figcaption>
						<?php echo $despues_pie; ?>
					</figcaption>
				</figure>
			</div>
			<div class="ctn__img-obras_controles">
				<span id="antes" class="img-obras_controles active">Antes</span>
				<span id="despues" class="img-obras_controles">Ahora</span>
			</div>
		</div>
		<?php endwhile; ?>
		<?php endif; ?>
		<?php the_field('obra_contenido', $terms->taxonomy.'_'.$terms->term_id); ?>
	</div>
	<!-- .entry-content -->
</article>
<!-- #post-## -->

<style>
	#map {
		width: 100%;
		height: 400px;
	}
</style>
<div id="obra-map">
	<span class="solucion">
		Geolocalización de la obra
	</span>
	<div id="map"></div>
</div>

<script>
	jQuery(function($) {
		$('.ctn__img-obras_controles > span').on('click', function(evt)
		{
			$(this).parent().children().removeClass('active');
			$(this).addClass('active');
			var option = $(this).attr('id');

			switch (option)
			{
				case 'antes':
					$('.img-obras_antes').fadeIn();
					$('.img-obras_despues').hide();
					$('.img-obras_despues').fadeOut();
					break;
				case 'despues':
					$('.img-obras_despues').fadeIn();
					$('.img-obras_antes').hide();
					$('.img-obras_antes').fadeOut();
					break;
			}

			evt.stopPropagation();
		})
	});

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