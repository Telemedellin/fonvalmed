<?php $key = 0; ?>
<?php $class = ''; ?>
<?php $current = $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<!-- #menu -->
<div id="obras-menu">
	<ul>
		<?php foreach ($posts as $post): ?>
			<?php $class = ($current == get_permalink($post->ID)) ? 'active' : ''; ?>
			<?php if($key ==0): ?>
				<?php if (is_tax()): ?>
					<li class="active">
						<a href="<?php echo $home; ?>">Inicio</a>
					</li>
					<li>
						<a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a>
					</li>
				<?php else: ?>
					<li>
						<a href="<?php echo $home; ?>">Inicio</a>
					</li>
					<li class="<?php echo $class; ?>">
						<a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a>
					</li>
				<?php endif; ?>
			<?php else: ?>
				<li class="<?php echo $class; ?>">
					<a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a>
				</li>
			<?php endif; ?>
			<?php $key++; ?>
		<?php endforeach; ?>
	</ul>
</div>
<!-- #menu -->

<!-- #menu-test -->

<!-- #menu-test -->