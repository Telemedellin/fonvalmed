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
		<div id="obra-filtro-tipo">
			<span rel="listado" class="active">Listado<span></span></a>
		</div>
		<div id="obra-filtro-tipo">
			<span rel="mapa">Mapa<span></span></a>
		</div>
		<p>
			Utiliza los siguientes filtros para conocer las obras.
		</p>
		<div>
			<div id="obra-listado" class="col-md-12">
				<div class="filtros col-md-4">
					<span>Estado de la obra</span>
					<span rel="estado:finalizados" onclick="javascript:filtrar(this)">Finalizados</span>
					<span rel="estado:en-ejecucion" onclick="javascript:filtrar(this)">En ejecuci&oacute;n</span>
					<span rel="estado:por-ejecutar" onclick="javascript:filtrar(this)">Por ejecutar</span>
					<span rel="estado:en-licitacion" onclick="javascript:filtrar(this)">En licitaci&oacute;n</span>
				</div>
				<div class="filtros col-md-4">
					<span>Zona de influencia</span>
				</div>
				<div class="filtros col-md-4">
					<span>Tipo de obra</span>
					<span rel="tipo:ampliacion" onclick="javascript:filtrar(this)">Ampliaci&oacute;n</span>
					<span rel="tipo:apertura" onclick="javascript:filtrar(this)">Apertura</span>
					<span rel="tipo:paso-a-desnivel" onclick="javascript:filtrar(this)">Paso a desnivel</span>
					<span rel="tipo:otras-obras" onclick="javascript:filtrar(this)">Otras obras</span>
				</div>
				<div class="obras col-md-12">
					<?php $obras = array(); ?>
					<?php foreach(get_term_children($terms->term_id, $terms->taxonomy) as $term_id): ?>
						<div class="col-md-4">
							<div>
								<?php
									$obra = get_term($term_id, $terms->taxonomy);

									$cabezote = get_field('obra_cabezote', $terms->taxonomy.'_'.$term_id);
									$obra->cabezote = $cabezote['url'];

									$geolocalizacion = get_field('obra_geolocalizacion', $terms->taxonomy.'_'.$term_id);
									$obra->latitud = $geolocalizacion['lat'];
									$obra->longitud = $geolocalizacion['lng'];

									$obra->estado = get_field('obra_estado', $terms->taxonomy.'_'.$term_id);
									$obra->avance = get_field('obra_avance', $terms->taxonomy.'_'.$term_id);

									$obras[] = $obra;
								?>
								<div></div>
								<p><?php echo $obra->name; ?></p>
								<p><?php echo $obra->estado; ?></p>
								<hr class="linea">
								<div class="obra-avance">
									<span class="texto"><?php echo $obra->avance; ?>%</span>
									<span class="porcentaje" style="width: <?php echo $obra->avance; ?>%;"></span>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div id="obra-mapas" class="col-md-12" style="visibility:hidden">
				<div id="obra-mapas-filtros" class="col-md-12">
					<span rel="estado:finalizados" onclick="javascript:filtrar(this)">Finalizados</span>
					<span rel="estado:en-ejecucion" onclick="javascript:filtrar(this)">En ejecuci&oacute;n</span>
					<span rel="estado:por-ejecutar" onclick="javascript:filtrar(this)">Por ejecutar</span>
					<span rel="estado:en-licitacion" onclick="javascript:filtrar(this)">En licitaci&oacute;n</span>
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
    jQuery('#obra-filtro-tipo > span').on('click', function () {

        jQuery('.entry-content #obra-filtro-tipo').children().removeAttr('class')
        jQuery(this).attr('class','active');

        if (jQuery(this).attr('rel') == 'mapa')
        {
            jQuery('#obra-mapas').css({'visibility':'visible'});
            jQuery('#obra-listado').css({'display':'none'});
        }
        else
        {
            jQuery('#obra-listado').css({'display':'block'});
            jQuery('#obra-mapas').css({'visibility':'hidden'});
        }
    });

	function filtrar(element)
	{
		var tipo = jQuery(element).parent().parent().attr('id') == 'obra-mapas' ? 'mapa' : 'listado';
		var filtro = [];
        var term_id = '<?php echo $terms->term_id; ?>';
        var taxonomy = '<?php echo $terms->taxonomy; ?>';
        var active = false;

        jQuery(element).hasClass('active') ? jQuery(element).removeAttr('class') : jQuery(element).attr('class','active');

        if (jQuery('#obra-listado .filtros span.active').length > 0 && tipo == 'listado')
        {
            jQuery.each(jQuery('#obra-listado .filtros span.active'), function (k,v) { filtro[k] = jQuery(v).attr('rel'); });
            active = true;
        }
        else if (jQuery('#obra-mapas #obra-mapas-filtros span.active').length > 0 && tipo == 'mapa')
        {
            jQuery.each(jQuery('#obra-mapas #obra-mapas-filtros span.active'), function (k,v) { filtro[k] = jQuery(v).attr('rel'); });
            active = true;
        }

        jQuery.ajax({
            url: '<?php echo get_template_directory_uri(); ?>/ajax/filtros.php',
            method: 'POST',
            data: {tipo:tipo, filtro: filtro, term_id:term_id, taxonomy:taxonomy,active:active},
            success: function(data) {
                if (typeof data == 'object')
                {
                    if (data.length != 0)
                    {
                        if (jQuery('#not-found').is(':visible'))
                        {
                            jQuery('#map > div.gm-style').css({'z-index':'0'});
                            jQuery('#not-found').remove();
                        }
                        rebuildMap(data);
                    }
                    else
                    {
                        if (!jQuery('#not-found').is(':visible'))
                        {
                            jQuery('#map > div.gm-style').css({'z-index':'-1'});
                            jQuery('#map').prepend(jQuery('<div>', {
                                id: 'not-found'
                            }).css({
                                'width':'100%',
                                'height':'100%',
                                'background-color':'#eee',
                                'z-index':'1',
                                'opacity':'0.5'
                            }).prepend(jQuery('<h3>',{
                                id: 'msg'
                            }).css({
                                'color':'#FF7F00',
                                'padding-top': '25%',
                                'text-align':'center',
                                'font-weight':'bold',
                                'font-size':'49px',
                                'margin':'0px'
                            }).text('Busqueda sin resultados.')));
                        }
                    }
                }
                else
                {
                    switch (data)
                    {
                        case null:
                        case "":
                            jQuery('#obra-listado > .obras').html('Busqueda sin resultados.');
                            break;
                        default:
                            jQuery('#obra-listado > .obras').html(data);
                            break;
                    }
                }
            }
        });
	}

	function initMap()
	{
		var locations = <?php echo json_encode($obras); ?>;
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 16,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});

		setMarkers(map,locations);
	}

	function rebuildMap(locations)
	{
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 16,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});

		setMarkers(map,locations);
	}

	function setMarkers(map,locations)
	{
		var marker, i;
		for (i = 0; i < locations.length; i++)
		{
			latlngset = new google.maps.LatLng(locations[i].latitud, locations[i].longitud);

			var marker = new google.maps.Marker({
				map: map, title: locations[i].name, position: latlngset
			});

			map.setCenter(marker.getPosition());
			var content = '<div id="obra-detalle">' +
						'<div class="obra-imagen" style="background-image:url(' + locations[i].cabezote + ');"></div>' +
							'<br />' +
							'<span class="obra-titulo">'  + locations[i].name + '</span>' +
							'<br />' +
							'<br />' +
							'<hr class="linea">' +
							'<span class="obra-estado">' + locations[i].estado + '</span>' +
							'<br />' +
							'<div class="obra-avance">' +
								'<span class="texto">' + locations[i].avance + '%</span>' +
								'<span class="porcentaje" style="width: ' + locations[i].avance + '%;"></span>' +
							'</div>' +
						'</div>';

			var infowindow = new google.maps.InfoWindow();

			google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){
				return function() {
					infowindow.setContent(content);
					infowindow.open(map,marker);
				};
			})(marker,content,infowindow));
		}
	}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?callback=initMap"></script>