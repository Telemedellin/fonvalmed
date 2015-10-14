<?php
	get_header();

	$layout = ($layout = get_field('es_video', get_the_ID())) == false ? null : $layout;

	if (is_tax()):
		$terms = get_queried_object();
	else:
		$terms = get_the_terms(get_the_ID(), 'nombre');
		$terms = $terms[0];
	endif;

	$home = get_term_link($terms->term_id, $terms->taxonomy);

	if ($terms->parent != 0):
		$_posts = get_posts(
			array(
				'posts_per_page' => -1,
				'post_type' => 'obra',
				'orderby' => 'post_date',
				'order'   => 'ASC',
				'tax_query' => array(
					array(
						'taxonomy' => 'nombre',
						'field' => 'term_id',
						'terms' => $terms->term_id,
						'include_children'	=> false
					)
				)
			)
		);

		include 'navigation-obra.php';

		if (!is_null($layout) || !empty($layout))
			include 'templates/template-'.$layout.'.php';
		else
			include 'templates/template-2col-D.php';
	else:
		$_posts = get_posts(
			array(
				'posts_per_page' => -1,
				'post_type' => 'obra',
				'orderby' => 'post_date',
				'order'   => 'ASC',
				'tax_query' => array(
					array(
						'taxonomy' => 'nombre',
						'field' => 'term_id',
						'terms' => $terms->term_id,
						'include_children'	=> false
					)
				)
			)
		);

		include 'templates/template-2col-I.php';
	endif;

	get_footer();
?>
