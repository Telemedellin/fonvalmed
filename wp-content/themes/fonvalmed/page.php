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

get_header();

	$post_id = (get_field('generar_automaticamente') == 'si') ? $post->ID : ((get_field('generar_automaticamente', $post->post_parent) == 'si') ? $post->post_parent : 0);
	if ($post_id != 0):
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
	<div class="col-md-9">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'templates/template-parts/content', 'page' ); ?>
					<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() ) :
							comments_template();
						endif;
					?>
				<?php endwhile; // End of the loop. ?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div>
	<?php else: ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'templates/template-parts/content', 'page' ); ?>
				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>
			<?php endwhile; // End of the loop. ?>
		</main><!-- #main -->
	</div><!-- #primary -->
	<?php endif; ?>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
