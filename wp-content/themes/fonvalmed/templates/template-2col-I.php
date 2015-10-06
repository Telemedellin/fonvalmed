	<!-- #sidebar -->
	<div class="col-md-3">
		<?php if ($terms->parent == 0): ?>
			<?php include get_template_directory().DIRECTORY_SEPARATOR.'navigation-proyecto.php'; ?>
		<?php else: ?>

		<?php endif; ?>
	</div>
	<!-- #sidebar -->

	<!-- #contenido -->
	<div class="col-md-9">
		<!-- #primary -->
		<div id="primary" class="content-area">
			<!-- #main -->
			<main id="main" class="site-main" role="main">
			<?php if (is_tax()): ?>
				<?php if ($terms->parent != 0): ?>
					<?php include 'template-parts/content-category-obra.php'; ?>
				<?php else: ?>
					<?php include 'template-parts/content-category-proyecto.php'; ?>
				<?php endif; ?>
			<?php else: ?>
				<?php if($terms->parent == 0): ?>
				<?php $posts = new WP_Query(array('p' => $post_id, 'post_type' => 'obra')); ?>
				<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
					<?php include 'template-parts/content-obra.php'; ?>
					<?php //the_post_navigation(); ?>
					<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>
				<?php endwhile; // End of the loop. ?>
				<?php else: ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php include 'template-parts/content-obra.php'; ?>
					<?php //the_post_navigation(); ?>
					<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>
				<?php endwhile; // End of the loop. ?>
				<?php endif; ?>
			<?php endif; ?>
			</main>
			<!-- #main -->
		</div>
		<!-- #primary -->
	</div>
	<!-- #contenido -->