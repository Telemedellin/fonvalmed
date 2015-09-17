<!-- #menu -->
<div class="obra-navigation">
	<ul>
		<li><a href="<?php echo $home; ?>">Inicio</a></li>
		<?php foreach ($posts as $post): ?>
		<li><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></li>
		<?php endforeach; ?>
	</ul>
</div>
<!-- #menu -->