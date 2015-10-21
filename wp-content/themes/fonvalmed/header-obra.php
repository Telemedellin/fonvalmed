<?php
	if (is_tax()):
		$terms = get_queried_object();
	else:
		if ($post_id == 0):
			$terms = get_the_terms(get_the_ID(), 'nombre');
			$terms = $terms[0];
		endif;
	endif;

	if ($post_id == 0):
		$image_header = get_field('obra_cabezote', $terms->taxonomy.'_'.$terms->term_id);
	else:
		$image_header['url'] = get_field('imagen_de_cabezote', $post_id);
	endif;
	
	$caption = !is_null($terms) ? $terms->name : get_the_title($post_id);
	$post->caption = $caption;
?>

<!-- #header -->
<div class="obra-header" style="background-image:url(<?php echo $image_header['url']; ?>);">
	<div class="container">
		<!-- #titulo -->
		<h2 class="obra-titulo"><?php echo $caption; ?></h2>
		<!-- #titulo -->
	</div>
</div>
<!-- #header -->