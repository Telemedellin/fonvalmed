<?php $key = 0; ?>
<?php $class = ''; ?>
<?php $current = $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<!-- #menu -->
<aside class="ctn__menu-micro">
	<h3 class="menu-micro_title"><span>Menú</span></h3>
	<div class="menu-micro-toggle">Menú <?php echo $post->caption; ?></div>
	<ul class="menu-micro">
		<?php foreach ($_posts as $_post): ?>
			<?php $class = ($current == get_permalink($_post->ID)) ? 'menu-micro_-active' : ''; ?>
			<?php if($key ==0): ?>
				<?php if (is_tax()): ?>
					<li>
						<a href="<?php echo $home; ?>" class="menu-micro_-active">Obras del proyecto</a>
					</li>
					<li>
						<a href="<?php echo get_permalink($_post->ID); ?>"><?php echo $_post->post_title; ?></a>
					</li>
				<?php else: ?>
					<li>
						<a href="<?php echo $home; ?>">Obras del proyecto</a>
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
<script>
jQuery(function($) {
	$('.menu-micro-toggle').on('click', function(evt) {
		if ($(this).hasClass('menu-micro-open'))
		{
			$(this).removeClass('menu-micro-open');
			$(this).next().fadeOut();
		}
		else
		{
			$(this).addClass('menu-micro-open');
			$(this).next().fadeIn();
		}
	});
});
</script>
<!-- #menu -->