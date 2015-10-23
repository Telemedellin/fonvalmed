<?php

/*
Template Name: Plantilla para el home
*/

get_header();

$menu = preg_replace( "/\r|\n/", "", wp_nav_menu( array( 'menu' => get_field('menu'), 'echo' => false ) ) );
$meses = array(
	"01" => "Enero",
	"02" => "Febrero",
	"03" => "Marzo",
	"04" => "Abril",
	"05" => "Mayo",
	"06" => "Junio",
	"07" => "Julio",
	"08" => "Agosto",
	"09" => "Septiembre",
	"10" => "Octubre",
	"11" => "Noviembre",
	"12" => "Diciembre"
);

$date = DateTime::createFromFormat("m", date('m'));

?>
	<div class="row">
		<div class="col-md-7">
			<?php if (function_exists('soliloquy')) { soliloquy( get_field('slider') ); } ?>
		</div>
		<div class="col-md-5">
			<script>
				jQuery(function($) {
					var menu = '<?php echo $menu; ?>';
					var parser = new DOMParser();
					var menu = parser.parseFromString(menu, "text/xml");

					$(menu).find('ul').children().each(function (k, v) {
						var link = $(v).children().get(0);
						var link_text = link.innerHTML;
						var span_icon = $('<span>').css({'float':'left','font-size':'40px','margin-top':'5px','width':'100%'});
						var span_text = $('<span>').css({'float':'left','width':'100%'}).html(link.innerHTML);

						link.innerHTML = '';

						switch (link_text)
						{
							case 'Paga tu factura':
								$(link).append(span_icon.attr('class','fa fa-barcode').css({'color':'#F60'})).append(span_text);
								break;
							case 'Movilidad durante la construcción de las obras':
								$(link).append(span_icon.attr('class','fa fa-road').css({'color':'#F4C247'})).append(span_text);
								break;
							case 'Proyecto de valorización El Poblado':
								$(link).append(span_icon.attr('class','fa fa-map-o').css({'color':'#CDCC00'})).append(span_text);
								break;
							case 'Escribenos':
								$(link).append(span_icon.attr('class','fa fa-envelope-o').css({'color':'#C7A039'})).append(span_text);
								break;
							case 'Trámites y servicios':
								$(link).append(span_icon.attr('class','fa fa-barcode').css({'color':'#99CC01'})).append(span_text);
								break;
							case 'Acompañamiento social':
								$(link).append(span_icon.attr('class','fa fa-users').css({'color':'#BC8660'})).append(span_text);
								break;
							case 'Chat':
								$(link).append(span_icon.attr('class','fa fa-commenting-o').css({'color':'#FFCE00'})).append(span_text);
								break;
							case 'Suscríbete a nuestro boletín':
								$(link).append(span_icon.attr('class','fa fa-user-plus').css({'color':'#C3C96F'})).append(span_text);
								break;
							case 'Contratación':
								$(link).append(span_icon.attr('class','fa fa-file-text-o').css({'color':'#F29248'})).append(span_text);
								break;
						}
					});

					$('.menu-menu-home-container').html($(menu).find('div').html());
				});
			</script>
			<div class="menu-menu-home-container">
			</div>
			<?php
				$recaudo = 0;
				if(have_rows('obra_recaudo','nombre_8')):
					while (have_rows('obra_recaudo','nombre_8')) : the_row();
						$recaudo = $recaudo + get_sub_field('recaudo','nombre_8');
					endwhile;
				endif;
			?>
			<div class="recaudo-home">
				<span class="recaudo-titulo">Recaudo contribución de valorización</span>
				<span class="recaudo-fecha">Hoy <?php echo date('d'); ?> de <?php echo $meses[date('m')]; ?></span>
				<span class="recaudo-dinero">$<?php echo number_format($recaudo,2,',','.'); ?></span>
			</div>
		</div>
	</div>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'templates/template-parts/content', 'page-home' ); ?>
			<?php endwhile; // End of the loop. ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
