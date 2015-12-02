<?php

/*
Template Name: Plantilla para las noticias
*/

get_header();

	$post_id = (get_field('generar_automaticamente') == 'si') ? $post->ID : ((get_field('generar_automaticamente', $post->post_parent) == 'si') ? $post->post_parent : 0);
	$_pages = get_pages(
		array(
			'post_type' => 'page',
			'child_of' => 0,
			'sort_order' => 'asc',
			'sort_column' => 'post_date',
			'parent' => $post_id,
		)
	); ?>

	<div class="col-md-3">
		<?php include get_template_directory().DIRECTORY_SEPARATOR.'navigation-page.php'; ?>
	</div>

	<!-- #contenido -->
	<div class="col-md-9"
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'templates/template-parts/content', 'page-noticias' ); ?>
				<?php endwhile; // End of the loop. ?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
