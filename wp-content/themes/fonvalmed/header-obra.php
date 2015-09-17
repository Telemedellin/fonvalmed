<?php
	$image_header = get_field('obra_cabezote', $terms->taxonomy.'_'.$terms->term_id);
?>

<!-- #header -->
<div class="obra-header">
	<img src="<?php echo $image_header['url']; ?>" >
	<!-- #titulo -->
	<h2 class="obra-titulo"><?php echo $terms->name; ?></h2>
	<!-- #titulo -->
</div>
<!-- #header -->