<?php get_header(); ?>

<?php if (!is_singular(array('page', 'attachment', 'post'))): ?>
	<?php
		$layout =  ($layout = get_field('es_video', get_the_ID())) == false ? null : $layout;

		if (is_tax()):
			$terms = get_queried_object();
		else:
			$terms = get_the_terms(get_the_ID(), 'nombre');
			$terms = $terms[0];
		endif;

		$home = get_term_link($terms->term_id, $terms->taxonomy);

		$posts = get_posts(
			array(
				'posts_per_page' => -1,
				'post_type' => 'obra',
				'tax_query' => array(
					array(
						'taxonomy' => 'nombre',
						'field' => 'term_id',
						'terms' => $terms->term_id,
					)
				)
			)
		);

		include 'navigation-obra.php';

		if (!is_null($layout) || !empty($layout))
			include 'templates/template-'.$layout.'.php';
		else
			include 'templates/template-single.php';
	?>
<?php else: ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'templates/template-parts/content', 'single' ); ?>
			<?php the_post_navigation(); ?>
			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>
		<?php endwhile; // End of the loop. ?>
		</main>
		<!-- #main -->
	</div>
	<!-- #primary -->
	<?php get_sidebar(); ?>
<?php endif; ?>

<?php get_footer(); ?>