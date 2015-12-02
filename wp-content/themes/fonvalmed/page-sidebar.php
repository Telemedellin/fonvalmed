<?php
/*
Template Name: Página con sidebars
*/

get_header(); ?>

	<div id="primary" class="content-area row-fluid">
		<div class="row-fluid">
			<div class="col-md-9">
				<main id="main" class="site-main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'templates/template-parts/content-page-sidebar', 'page' ); ?>

						<?php
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
						?>

					<?php endwhile; // End of the loop. ?>

				</main><!-- #main -->
			</div>
				<?php get_sidebar(); ?>
		</div>
	</div><!-- #primary -->

<?php get_footer(); ?>
