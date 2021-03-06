<?php
/**
 * Template part for displaying single posts.
 *
 * @package fonvalmed
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php the_content(); ?>
		<div class="wpb_content_element tabs_fonvalmed">
			<div class="ctn__wpb_tabs_nav">
				<ul class="wpb_tabs_nav">
					<li id="circulares" class="ui-tabs-active"><a href="#tab">Circulares de obra</a></li>
					<li id="boletines"><a href="#tab">Boletín así va la obra</a></li>
					<li id="noticias"><a href="#tab">Noticias</a></li>
				</ul>
			</div>
			<div class="ctn__wpb_tab">
				<div class="wpb_tab">
					<table>
						<tr>
							<th>Nombre</th>
							<th>Fecha</th>
							<th>Descarga</th>
						</tr>
						<?php if(have_rows('circulares')): ?>
						<?php while (have_rows('circulares')) : the_row(); ?>
						<tr>
							<td><?php the_sub_field('titulo'); ?></td>
							<td><?php the_sub_field('fecha'); ?></td>
							<td><a href="<?php the_sub_field('archivo'); ?>" download>Descargar</a></td>
						</tr>
						<?php endwhile; ?>
						<?php else: ?>
						<tr>
							<td colspan="3">No se encontraron resultados.</td>
						</tr>
						<?php endif; ?>
					</table>
				</div>
			</div>
		</div>
	</div><!-- .entry-content -->
	<script>
		jQuery(function($) {
			$('.wpb_tabs_nav > li').on('click', function(evt) {
				var filtro = $(this).attr('id');
				var post_id = <?php the_ID(); ?>;

				$(this).parent().children().removeAttr('class');
				$(this).attr('class', 'ui-tabs-active');

				$.ajax({
					url: '<?php echo get_template_directory_uri(); ?>/ajax/publicaciones.php',
					method: 'POST',
					data: {
						filtro:filtro,
						post_id:post_id
					},
					success: function(publicaciones)
					{
						var tbody = jQuery('table').children();
						$.each(tbody.children(), function(index, tr) {
							if (index != 0)
								tr.remove();
						});
						tbody.append(publicaciones);
					}
				});

				evt.stopPropagation();
			});
		});
	</script>
</article><!-- #post-## -->