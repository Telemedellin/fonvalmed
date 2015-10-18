<?php $key = 0; ?>
<?php $class = ''; ?>
<?php $current = $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<!-- #menu -->
<aside class="ctn__menu-micro">
	<h3 class="menu-micro_title"><?php echo get_the_title($post_id); ?></h3>
	<ul class="menu-micro">
	<?php foreach ($_pages as $_page): ?>
		<?php $class = ($current == get_permalink($_page->ID)) ? 'menu-micro_-active' : ''; ?>
		<li>
			<a href="<?php echo get_permalink($_page->ID); ?>" class="<?php echo $class; ?>"><?php echo $_page->post_title; ?></a>
		</li>
	<?php endforeach; ?>
	</ul>
</aside><!-- /ctn__sidebar-obras -->
<!-- #menu -->