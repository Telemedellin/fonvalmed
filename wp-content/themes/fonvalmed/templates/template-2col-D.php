	<!-- #contenido -->
	<div class="col-md-9">
		<!-- #primary -->
		<div id="primary" class="content-area">
			<!-- #main -->
			<main id="main" class="site-main" role="main">
			<?php if (is_tax()): ?>
				<?php include 'template-parts/content-category-obra.php'; ?>
			<?php else: ?>
				<?php while (have_posts()) : the_post(); ?>
					<?php
						switch ($tipo_plantilla_obra):
							case 'galeria':
								include 'template-parts/content-obra-gallery.php';
								break;
							case 'publicaciones':
								include 'template-parts/content-obra-publicaciones.php';
								break;
							default:
								include 'template-parts/content-obra.php';
							break;
						endswitch;
					?>
					<?php //the_post_navigation(); ?>
					<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>
				<?php endwhile; // End of the loop. ?>
			<?php endif; ?>
			</main>
			<!-- #main -->
		</div>
		<!-- #primary -->
	</div>
	<!-- #contenido -->

	<!-- #sidebar -->
	<div class="col-md-3">
		<?php
			$obra_estado = get_field_object('obra_estado', $terms->taxonomy.'_'.$terms->term_id);
			$obra_estado_valor = get_field('obra_estado', $terms->taxonomy.'_'.$terms->term_id);
			$estado = $obra_estado['choices'][$obra_estado_valor];
			$avance = get_field('obra_avance', $terms->taxonomy.'_'.$terms->term_id);
		?>
		<div id="obra-estado" class="sidebar">
			<?php echo $estado; ?>
			<div id="obra-detalle">
				<div class="obra-avance">
					<span class="texto"><?php echo $avance; ?>%</span>
					<span class="porcentaje" style="width: <?php echo $avance; ?>%;"></span>
				</div>
			</div>
		</div>
		<?php
			$obra_tipo = get_field_object('obra_tipo', $terms->taxonomy.'_'.$terms->term_id);
			$obra_tipo_valor = get_field('obra_tipo', $terms->taxonomy.'_'.$terms->term_id);
			$tipo = $obra_tipo['choices'][$obra_tipo_valor];

			$direccion = get_field('obra_direccion', $terms->taxonomy.'_'.$terms->term_id);
			$fecha_a = get_field('obra_fecha_inicio', $terms->taxonomy.'_'.$terms->term_id);
			$fecha_inicio = substr($fecha_a,0,4).'-'.substr($fecha_a,4,2);
			$fecha_b = get_field('obra_fecha_finalizacion', $terms->taxonomy.'_'.$terms->term_id);
			$fecha_fin = substr($fecha_b,0,4).'-'.substr($fecha_b,4,2);
		?>
		<div id="obra-descripcion" class="sidebar">
			<span>Tipo de obra:</span> <?php echo $tipo; ?> <br>
			<span>Dirección:</span> <?php echo $direccion; ?> <br>
			<span>Fecha de inicio:</span> <?php echo $fecha_inicio; ?> <br>
			<span>Fecha de fin:</span> <?php echo $fecha_fin; ?> <br>
		</div>
		<aside class="ctn__sidebar">
			<section class="sidebar-block documentacion">
				<h2 class="sidebar_block_title">Documentación de la obra</h2>
				<div class="ctn__sidebar_content">
					<ul class="l_icon">
						<?php if(have_rows('obra_documentacion', $terms->taxonomy.'_'.$terms->term_id)): ?>
						<?php while (have_rows('obra_documentacion', $terms->taxonomy.'_'.$terms->term_id)) : the_row(); ?>
						<li><a href="<?php the_sub_field('archivo', $terms->taxonomy.'_'.$terms->term_id); ?>" download><?php the_sub_field('titulo', $terms->taxonomy.'_'.$terms->term_id); ?></a></li>
						<?php endwhile; ?>
						<?php else: ?>
						<li>No hay documentación.</li>
						<?php endif; ?>
					</ul>
				</div>
			</section><!-- /documentacion -->
			<section class="sidebar_block sharer">
				<h2 class="sidebar_block_title">Comparte</h2>
				<div class="ctn__sidebar_content">
					<ul class="l_inline">
						<li><a href="https://www.facebook.com/sharer/sharer.php?u=http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&display=popup" target="_blank" class="icon-facebook sharer-icon"></a></li>
						<li><a href="https://twitter.com/share?url=<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&text=<?php echo $terms->name; ?>" target="_blank" class="icon-twitter sharer-icon"></a></li>
					</ul>
				</div>
			</section><!-- /sharer -->
			<section class="sidebar-block obras-relacionadas">
				<h2 class="sidebar_block_title">Obras relacionadas</h2>
				<div class="ctn__sidebar_content">
					<?php $obras_relacionadas = get_field('obras_relacionadas', $terms->taxonomy.'_'.$terms->term_id); ?>
					<?php if (count($obras_relacionadas) > 0 && !empty($obras_relacionadas)): ?>
					<?php foreach($obras_relacionadas as $term_id): ?>
					<?php if ($terms->term_id != $term_id): ?>
					<?php $obra = get_term($term_id, $terms->taxonomy); ?>
					<?php $obra->cabezote = get_field('imagen_destacada', $terms->taxonomy.'_'.$term_id); ?>
					<a href="<?php echo get_term_link($term_id, $terms->taxonomy); ?>" class="ctn__obra-preview_sidebar">
						<figure class="ctn__obra-preview_sidebar_image" style="background: url(<?php echo $obra->cabezote; ?>) no-repeat; background-size: 100%; background-position: center center;">
							<img src="<?php echo $obra->cabezote; ?>" alt="" class="obra-preview_sidebar_image">
						</figure>
						<h3 class="obra-preview_sidebar_title"><?php echo $obra->name; ?></h3>
					</a>
					<?php endif; ?>
					<?php endforeach; ?>
					<?php else: ?>
					<center>No se encontraron obras relacionadas</center>
					<?php endif; ?>
				</div>
			</section><!-- /obras-relacionadas -->
		</aside><!-- /ctn__sidebar-obras -->
	</div>
	<!-- #sidebar -->