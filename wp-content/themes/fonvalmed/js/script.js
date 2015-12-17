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

		$('#filtro').on('keypress', function() {
			$('#btnFiltrar').trigger('click');
		});

		$.datepick.setDefaults($.datepick.regionalOptions['es']);

		$('#txtDesde').datepick({
			dateFormat: 'yyyy-mm-dd'
		});

		$('#txtHasta').datepick({
			dateFormat: 'yyyy-mm-dd'
		});

		$('#calendar-desde').on('click', function() {
			$('#txtDesde').trigger("focus");
		});

		$('#calendar-hasta').on('click', function() {
			$('#txtHasta').trigger("focus");
		});

		$('#btnFiltrar').on('click', function(evt)
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

			evt.stopPropagation();
		});
	}
});