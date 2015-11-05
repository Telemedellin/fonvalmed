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
			<div id="obra-listado" class="container-fluid">
				<div class="row ctn__filtros">
					<div class="filtros col-md-5">
						<span class="filtro-title">Estado de la obra</span>
						<span class="fm-label" rel="estado:finalizada" onclick="javascript:filtrar(this)">Finalizadas</span>
						<span class="fm-label" rel="estado:en-ejecucion" onclick="javascript:filtrar(this)">En ejecuci&oacute;n</span>
						<span class="fm-label" rel="estado:por-ejecutar" onclick="javascript:filtrar(this)">Por ejecutar</span>
						<span class="fm-label" rel="estado:en-licitacion" onclick="javascript:filtrar(this)">En licitaci&oacute;n</span>
					</div>
					<div class="filtros col-md-7">
						<span class="filtro-title">Tipo de obra</span>
						<span class="fm-label" rel="tipo:puente" onclick="javascript:filtrar(this)">Puente</span>
						<span class="fm-label" rel="tipo:paso-a-desnivel-puente" onclick="javascript:filtrar(this)">Paso a desnivel: puente</span>
						<span class="fm-label" rel="tipo:paso-a-deprimido" onclick="javascript:filtrar(this)">Paso a desnivel: deprimido</span>
						<span class="fm-label" rel="tipo:via-nueva-o-mejorada" onclick="javascript:filtrar(this)">Vía nueva o mejorada</span>
						<span class="fm-label" rel="tipo:doble-calzada" onclick="javascript:filtrar(this)">Doble calzada</span>
					</div>
				</div><!-- /ctn_filtros -->
				<script type="text/javascript" src="http://masonry.desandro.com/masonry.pkgd.min.js"></script>
				<div class="obras">
					<div class="grid-sizer"></div>
					<?php $obras = array(); ?>
					<?php foreach(get_term_children($terms->term_id, $terms->taxonomy) as $term_id): ?>
						<?php
							$obra = get_term($term_id, $terms->taxonomy);

							$obra->cabezote = get_field('imagen_destacada', $terms->taxonomy.'_'.$term_id);

							$geolocalizacion = get_field('obra_geolocalizacion', $terms->taxonomy.'_'.$term_id);
							$obra->latitud = $geolocalizacion['lat'];
							$obra->longitud = $geolocalizacion['lng'];
							
							$obra_estado = get_field_object('obra_estado', $terms->taxonomy.'_'.$term_id);
							$obra_estado_valor = get_field('obra_estado', $terms->taxonomy.'_'.$term_id);
							$obra->estado = $obra_estado['choices'][$obra_estado_valor];

							$obra->avance = get_field('obra_avance', $terms->taxonomy.'_'.$term_id);
							$obra->enlace = get_term_link($term_id, $terms->taxonomy);

							$obras[] = $obra;
						?>
						<a href="<?php echo get_term_link($term_id, $terms->taxonomy); ?>" class="ctn__obra-preview">
							<div class="ctn__obra-preview_image" style="background: url(<?php echo $obra->cabezote; ?>) no-repeat; background-size: 100%; background-position: center center;">
								
							</div>
							<div class="ctn__obra-preview_contenido">
								<p><?php echo $obra->name; ?></p>
								<hr class="linea">
								<span class="obra-preview_estado"><?php echo $obra->estado; ?></span>
								<div class="obra-avance">
									<span class="obra-avance_texto"><?php echo $obra->avance; ?>%</span>
									<span class="obra-avance_porcentaje" style="width: <?php echo $obra->avance; ?>%;"></span>
								</div>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
				<script>
				// Pure JS
				var container = document.querySelector('.obras');
				var msnry = new Masonry(container, {
					columnWidth: '.grid-sizer',
					itemSelector: '.ctn__obra-preview',
					gutter: 10,
					percentPosition: true
				});
				</script>
			</div>
			<div id="obra-mapas" style="visibility:hidden;height:0px;overflow:auto;">
				<div class="row ctn__filtros" style="margin-left: 0px;margin-right: 0px;">
					<div class="filtros col-md-12">
						<span></span>
						<span class="fm-label" style="width:24%;" rel="estado:finalizada" onclick="javascript:filtrar(this)">Finalizadas</span>
						<span class="fm-label" style="width:24%;" rel="estado:en-ejecucion" onclick="javascript:filtrar(this)">En ejecuci&oacute;n</span>
						<span class="fm-label" style="width:24%;" rel="estado:por-ejecutar" onclick="javascript:filtrar(this)">Por ejecutar</span>
						<span class="fm-label" style="width:24%;" rel="estado:en-licitacion" onclick="javascript:filtrar(this)">En licitaci&oacute;n</span>
					</div>
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

        jQuery('.entry-content #obra-filtro-tipo').children().removeClass('active')
        jQuery(this).addClass('active');

        if (jQuery(this).attr('rel') == 'mapa')
        {
            jQuery('#obra-mapas').css({'visibility':'visible','height':'auto'});
            jQuery('#obra-listado').css({'display':'none'});
        }
        else
        {
            jQuery('#obra-listado').css({'display':'block'});
            jQuery('#obra-mapas').css({'visibility':'hidden','height':'0px'});
        }
    });

	function filtrar(element)
	{
		var tipo = jQuery(element).parent().parent().parent().attr('id') == 'obra-mapas' ? 'mapa' : 'listado';
		var filtro = [];
        var term_id = '<?php echo $terms->term_id; ?>';
        var taxonomy = '<?php echo $terms->taxonomy; ?>';
        var active = false;

        jQuery(element).hasClass('fm-label-active') ? jQuery(element).removeClass('fm-label-active') : jQuery(element).addClass('fm-label-active');

        if (jQuery('#obra-listado .ctn__filtros .filtros span.fm-label-active').length > 0 && tipo == 'listado')
        {
            jQuery.each(jQuery('#obra-listado .ctn__filtros .filtros span.fm-label-active'), function (k,v) { filtro[k] = jQuery(v).attr('rel'); });
            active = true;
        }
        else if (jQuery('#obra-mapas .ctn__filtros .filtros span.fm-label-active').length > 0 && tipo == 'mapa')
        {
            jQuery.each(jQuery('#obra-mapas .ctn__filtros .filtros span.fm-label-active'), function (k,v) { filtro[k] = jQuery(v).attr('rel'); });
            active = true;
        }

        jQuery.ajax({
            url: '<?php echo get_template_directory_uri(); ?>/ajax/filtros.php',
            method: 'POST',
            data: {tipo:tipo, filtro: filtro, term_id:term_id, taxonomy:taxonomy,active:active},
			beforeSend: function()
			{
				var overlay = jQuery('<div>', {
						'id':'obra-listado-overlay'
					}).css({
						'background-color':'#EEE',
						'width':'100%',
						'height':'400px',
						'z-index':'1'
					}).prepend(jQuery('<span>').css({
						'display':'block',
						'width':'100%',
						'padding-top':'21%',
						'text-align':'center',
						'font-size':'30px',
						'color':'#FF7F00',
						'font-family':'"Open Sans"'
					}).text('CARGANDO').append(jQuery('<img>', {
						'src':'http://www.samvernon.com/resources/img/loading2.gif'
					}).css({
						'margin-top':'-5px'
					})));

				if (jQuery('#obra-listado').is(':visible'))
				{
					jQuery('#obra-listado .obras').html('');
					jQuery('#obra-listado .obras').prepend(overlay);
				}
				else
				{
					jQuery('#map > div.gm-style').css({'z-index':'-1'});
					jQuery('#obra-map #map').prepend(overlay);
				}
			},
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
                            jQuery('#obra-listado > .obras').html('Busqueda sin resultados.').css('height','auto');
                            break;
                        default:
                            jQuery('#obra-listado > .obras').html(data);
							var container = document.querySelector('.obras');
							var msnry = new Masonry(container, {
								columnWidth: '.grid-sizer',
								itemSelector: '.ctn__obra-preview',
								gutter: 10,
								percentPosition: true
							});
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
			var content = '<a href="' + locations[i].enlace + '" target="_blank">' +
						'<div id="obra-detalle">' +
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
						'</div>' +
						'</a>';

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