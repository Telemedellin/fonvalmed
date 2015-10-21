<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package fonvalmed
 */

get_header(); ?>
	<div class="row">
		<div class="col-md-7">
			<?php if (function_exists('soliloquy')) { soliloquy( '697' ); } ?>
		</div>
		<div class="col-md-5">
			<?php wp_nav_menu( array( 'menu' => '78' ) ); ?>
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
