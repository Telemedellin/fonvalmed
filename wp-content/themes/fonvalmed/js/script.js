/*jQuery(document).on("ready", function(){

	if( jQuery('.grid').length > 0 )
	{
		
		jQuery('.grid').masonry({
		  // options
		  itemSelector: '.grid-item',
		  columnWidth: '.grid-sizer',
		  percentPosition: true
		});

	}
 
});*/

jQuery(function($) {
	if($('#filtro').length)
	{
		var imagesUrl = window.location.origin+'/wp-content/themes/fonvalmed/img/';

		function validarRangos()
		{
			var fechaInicio = $('#txtDesde').val();
			var fechaFin = $('#txtHasta').val();

			if ((fechaInicio!=='') && (fechaFin!==''))
			{
				$('.error > ul > li#fechaInicio').remove();
				$('.error > ul > li#fechaFin').remove();
				$('.error > ul > li#fechas').remove();

				return true;
			}
			else
			{
				mostrarMensaje(fechaInicio, fechaFin);

				return false;
			}
		}

		function mostrarMensaje(fechaInicio, fechaFin)
		{
			if ((fechaInicio==='') && (!$('#fechaInicio').length))
			{
				$('.error > ul').css({
					color:'red',
					margin:'20px 0px 0px 0px'
				}).append("<li id='fechaInicio'>Por favor seleccione la fecha de inicio.</li>");
			}

			if ((fechaFin==='') && (!$('#fechaFin').length))
			{
				$('.error > ul').css({
					color:'red',
					margin:'20px 0px 0px 0px'
				}).append("<li id='fechaFin'>Por favor seleccione la fecha de fin.</li>");
			}
		}

		function validarFechas()
		{
			var fechaInicio = $('#txtDesde').val().split('-');
			fechaInicio = fechaInicio.join('');

			var fechaFin = $('#txtHasta').val().split('-');
			fechaFin = fechaFin.join('');

			if (fechaInicio > fechaFin)
			{
				$('.error > ul').css({
					color:'red',
					margin:'20px 0px 0px 0px'
				}).append("<li id='fechas'>La fecha de inicio no puede ser mayor a la fecha final.</li>");

				return false;
			}
			else
				return true;
		}

		$.datepicker.regional['es'] = {
			closeText: 'Cerrar',
			prevText: '<Ant',
			nextText: 'Sig>',
			currentText: 'Hoy',
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
			dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			weekHeader: 'Sm',
			dateFormat: 'dd/mm/yy',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''
		};
		$.datepicker.setDefaults($.datepicker.regional['es']);

		$('#filtro').on('keypress', function() {
			$('#btnFiltrar').trigger('click');
		});

		$('#txtDesde').datepicker({
			dateFormat: 'yy-mm-dd',
			buttonImage: imagesUrl + 'datepicker.png'
		});

		$('#txtHasta').datepicker({
			dateFormat: 'yy-mm-dd',
			buttonImage: imagesUrl + 'datepicker.png'
		});

		$('#btnFiltrar').on('click', function(evt)
		{
			if (validarRangos() && validarFechas())
			{
				$('.owl-stage').html('');
				$('.owl-stage-outer').css({height: '250px'});
				$('.vc_grid-pagination > ul').html('');
				
				var loading = $('<div>', {
					style: 'position: absolute;width: 100%; height: 100%;'
				}).append($('<span>',{
					id: 'postgrid-loading',
					style: 'display:block;width:100%;font-size:30px;color:#FF7F00;text-align:center;'
				}).text('CARGANDO...'));

				$('.owl-stage-outer').append(loading.html());

				$.ajax({
					method: "POST",
					url: window.location.origin + "/wp-content/themes/fonvalmed/ajax/noticias.php",
					data: $('#filtro').serialize(),
					success: function(data)
					{
						var obj = JSON.parse(data);
						$('#postgrid-loading').remove();
						$('.owl-stage-outer').css({height: 'initial'});
						$('.owl-stage').html(obj.content);
						$('.vc_grid-pagination > ul').html(obj.pag);
					},
					error: function(jqXHR, textStatus, errorThrown)
					{
						console.log(errorThrown);
					}
				});
			}
			else
				evt.stopPropagation();
		});
	}
});