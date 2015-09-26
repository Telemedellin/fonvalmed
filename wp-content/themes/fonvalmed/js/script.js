jQuery(document).on("ready", function(){

	if( jQuery('.grid').length > 0 )
	{
		jQuery('.grid').ready(function(){
			$('.grid').masonry({
			  // options
			  itemSelector: '.grid-item',
			  columnWidth: 200
			});
		});
	}
 
});