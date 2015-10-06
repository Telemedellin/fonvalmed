<?php $key = 0; ?>
<?php $class = ''; ?>
<?php $current = $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<!-- #menu -->
<aside class="ctn__menu-micro">
	<h3 class="menu-micro_title"><span>Menú</span> Proyectos Valorización</h3>
	<ul class="menu-micro">
		<?php while ($posts->have_posts()): $posts->the_post(); ?>
			<?php $class = ($current == get_permalink(get_the_ID())) ? 'menu-micro_-active' : ''; ?>
			<?php if($key ==0): ?>
				<?php if (is_tax()): ?>
					<li>
						<a href="<?php echo $home; ?>" class="menu-micro_-active"><?php echo $terms->name; ?></a>
					</li>
					<li>
						<a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a>
					</li>
				<?php else: ?>
					<li>
						<a href="<?php echo $home; ?>"><?php echo $terms->name; ?></a>
					</li>
					<li>
						<a href="<?php echo get_permalink(get_the_ID()); ?>" class="<?php echo $class; ?>"><?php the_title(); ?></a>
					</li>
				<?php endif; ?>
			<?php else: ?>
				<li>
					<a href="<?php echo get_permalink(get_the_ID()); ?>" class="<?php echo $class; ?>"><?php the_title(); ?></a>
				</li>
			<?php endif; ?>
			<?php $key++; ?>
		<?php endwhile; ?>
	</ul>
</aside><!-- /ctn__sidebar-obras -->
<!-- #menu -->