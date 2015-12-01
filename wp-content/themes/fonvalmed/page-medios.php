<?php
/*
Template Name: Fonvalmed en los medios
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
				<?php 
				    $the_query = get_posts(array(
                            'posts_per_page' => -1,
                            'category_name' => 'en-los-medios'
                        )
                    );

				    foreach ($the_query as $_post)
                    {
					    include 'templates/template-parts/loop-medios.php';
				    }
				?>
			</main><!-- #main -->
			<div class="pagination">
			</div>
			<style>
				.pagination {
					text-align: center;
				}
				.pagination > a {
					display: inline-block;
					box-sizing: border-box;
					min-width: 28px;
					min-height: 22px;
					background-color: #f7be68!important;
					border-color: #f7be68!important;
					color: #fff!important;
					z-index: 2;
					opacity: .5;
					cursor: default;
					transition: opacity .3s ease-in 0s;
					position: relative;
					padding: 3px 10px;
					line-height: 1.42857143;
					text-decoration: none;
					margin-left: -1px;
					font-size: 10px;
				}
				.pagination > a:hover {
					opacity: 1;
				}
				.pagination > a.jp-current {
					opacity: 1;
				}
				.pagination > a.jp-previous:before {
					content: "<";
				}
				.pagination > a.jp-next:before {
					content: ">";
				}
				.pagination > a.jp-disabled {
					display: none;
				}
			</style>
			<script type="text/javascript">
				jQuery(function ($) {
					$(".pagination").jPages({
						containerID: "main",
						previous: " ",
						next: " ",
						links: "numeric",
						startPage: 1,
						perPage: 2,
						keyBrowse: false,
						scrollBrowse: false,
						animation: false
					});
				});
			</script>
			<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.paginate.js"></script>
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
