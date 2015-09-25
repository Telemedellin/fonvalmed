<?php
	if (is_tax()):
		$terms = get_queried_object();
	else:
		$terms = get_the_terms(get_the_ID(), 'nombre');
		$terms = $terms[0];
	endif;

	$image_header = get_field('obra_cabezote', $terms->taxonomy.'_'.$terms->term_id);
?>

<!-- #header -->
<div class="obra-header" style="background-image:url(<?php echo $image_header['url']; ?>);">
	<div class="container">
		<!-- #titulo -->
		<h2 class="obra-titulo"><?php echo $terms->name; ?></h2>
		<!-- #titulo -->
	</div>
</div>
<!-- #header -->