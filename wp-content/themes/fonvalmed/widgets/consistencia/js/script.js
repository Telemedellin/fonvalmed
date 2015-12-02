jQuery(document).on("ready", function(){

	if( jQuery('.contador-obras-consistencia').length > 0 )
	{
		jQuery('.contador-obras-consistencia-header ul li').click(function(){
			var id_proyecto = jQuery('.contador-obras-consistencia').attr('rel');
			var tipo 		= jQuery(this).attr('class');
			var tipoDisplay = jQuery(this).html();

			jQuery.ajax({
            url: consistencia_script.url+'filtro.php',
            method: 'POST',
            data: {id_proyecto:id_proyecto, filtro: tipo},
				beforeSend: function()
				{
					var overlay = jQuery('<div>', {
							'id':'obra-listado-overlay'
						}).css({
							'background-color':'#EEE',
							'width':'100%',
							'height':'400px',
							'z-index':'1'
						}).prepend(jQuery('<sapn>').css({
							'display':'block',
							'width':'100%',
							'padding-top':'21%',
							'text-align':'center',
							'font-size':'30px',
							'color':'red'
						}).text('CARGANDO...').append(jQuery('<img>', {
							'src': consistencia_script.url+'loading.gif'
						}).css({
							'margin-top':'-5px'
						})));

					if (jQuery('#map').is(':visible'))
					{
						jQuery('#map').html(overlay);
					}
				},
	            success: function(data) {
	                if (typeof data == 'object')
	                {
	                    if (data.length != 0)
	                    {
	                    	jQuery('.consistencia-content-title .title').html(tipoDisplay);
	                        rebuildMap(data);
	                    }
	                    else
	                    {
	                        if (!jQuery('#not-found').is(':visible'))
	                        {
	                        	jQuery('#map').html('<div class="not-found">Sin Resultados</div>');
	                        }
	                    }
	                }
	                else
	                {
	                    switch (data)
	                    {
	                        case null:
	                        case "":
	                            jQuery('#map').html('Busqueda sin resultados.');
	                            break;
	                        default:
	                            jQuery('#map').html(data);
	                            break;
	                    }
	                }
	            }
        	});


		});

	}

	/**function initMap()
	{
		//var locations = <?php echo json_encode($obras); ?>;
	
	}**/

	function rebuildMap(locations)
	{
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 16,
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
				map: map, title: locations[i].estado, position: latlngset
			});

			//console.log(locations[i].cabezote.sizes.thumbnail);
			map.setCenter(marker.getPosition());
			var content = '<a href="' + locations[i].enlace + '" target="_blank">' +
						'<div id="obra-detalle">' +
						'<div class="obra-imagen" style="background-image:url(' + locations[i].cabezote.sizes.thumbnail + ');"></div>' +
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

	jQuery('.contador-obras-consistencia-header ul li.puente').trigger('click');
});

function initMap() {
	  var map = new google.maps.Map(document.getElementById('map'), {
	    center: {lat: 6.3403950163742815, lng: -75.5534559488296},
	    scrollwheel: false,
	    zoom: 16
	  });
	}

