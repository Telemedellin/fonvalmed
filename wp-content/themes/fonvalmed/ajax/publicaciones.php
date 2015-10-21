<?php

$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once $parse_uri[0] . 'wp-load.php';

$filtro = $_POST['filtro'];
$post_id = $_POST['post_id'];

?>
<?php if(have_rows($filtro, $post_id)): ?>
<?php while (have_rows($filtro, $post_id)) : the_row(); ?>
<tr>
	<td><?php the_sub_field('titulo'); ?></td>
	<td><?php the_sub_field('fecha'); ?></td>
	<td><a href="<?php the_sub_field('archivo'); ?>" download>Descargar</a></td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
	<td colspan="3">No se encontraron resultados.</td>
</tr>
<?php endif; ?>