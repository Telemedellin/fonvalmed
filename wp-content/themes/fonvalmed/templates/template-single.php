	<!-- #contenido -->
	<div class="col-md-12">
		<!-- #primary -->
		<div id="primary" class="content-area">
			<!-- #main -->
			<main id="main" class="site-main" role="main">
			<?php if (is_tax()): ?>
				<?php include 'template-parts/content-category-obra.php'; ?>
			<?php else: ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php include 'template-parts/content-single.php'; ?>
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