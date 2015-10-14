<?php $key = 0; ?>
<?php $class = ''; ?>
<?php $current = $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<!-- #menu -->
<aside class="ctn__menu-micro">
	<h3 class="menu-micro_title"><span>Menú</span> Proyectos Valorización</h3>
	<ul class="menu-micro">
		<?php foreach ($_posts as $_post): ?>
			<?php $class = ($current == get_permalink($_post->ID)) ? 'menu-micro_-active' : ''; ?>
			<?php if($key ==0): ?>
				<?php if (is_tax()): ?>
					<li>
						<a href="<?php echo $home; ?>" class="menu-micro_-active"><?php echo $terms->name; ?></a>
					</li>
					<li>
						<a href="<?php echo get_permalink($_post->ID); ?>"><?php echo $_post->post_title; ?></a>
					</li>
				<?php else: ?>
					<li>
						<a href="<?php echo $home; ?>"><?php echo $terms->name; ?></a>
					</li>
					<li>
						<a href="<?php echo get_permalink($_post->ID); ?>" class="<?php echo $class; ?>"><?php echo $_post->post_title; ?></a>
					</li>
				<?php endif; ?>
			<?php else: ?>
				<li>
					<a href="<?php echo get_permalink($_post->ID); ?>" class="<?php echo $class; ?>"><?php echo $_post->post_title; ?></a>
				</li>
			<?php endif; ?>
			<?php $key++; ?>
		<?php endforeach; ?>
	</ul>
</aside><!-- /ctn__sidebar-obras -->
<!-- #menu -->