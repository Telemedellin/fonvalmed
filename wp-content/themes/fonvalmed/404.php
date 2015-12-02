<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package fonvalmed
 */
 
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title">Lo sentimos, la página que buscas no está disponible - Error404</h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p>Te invitamos a qué navegues por nuestro menú para encontrar la información que estás buscando</p>
					<p>Si todavía no encuentras la información que necesitas, puedes utilizar nuestro buscador o ponerte en <a href="http://fonvalmed.gov.co/atencion-al-ciudadano/canales-de-atencion/">contacto</a> con nosotros</p>

					<?php get_search_form(); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
