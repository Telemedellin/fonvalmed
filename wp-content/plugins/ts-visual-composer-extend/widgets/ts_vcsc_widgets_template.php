<?php get_header(); ?>	
	<?php while (have_posts() ) : the_post(); ?>
		<div id="ts-widgets-preview-title" class="ts-widgets-preview-title" style="margin: 0 0 20px 0; padding: 0; width: 100%; padding: 0 0 20px 0; border-bottom: 1px solid #ededed;">
			<h2><?php the_title(); ?></h2>
		</div>
		<div id="ts-widgets-preview-message" class="ts-widgets-preview-message" style="margin: 0 0 20px 0; padding: 0 0 20px 0; border-bottom: 1px solid #ededed; text-align: justify; width: 100%; font-size: 14px;">
			<?php echo __('This is an approximate rendering of a "VC Widgets" custom post type, using 30% of the available page width (or 300px maximum) to better emulate a sidebar. Depending upon your theme,
			the actual width of your sidebar might be more or less than that, but this should still give you a good idea as to how your widgets will look like. Not all theme styling usually applied
			to standard pages or posts will be applied to this custom post type.', 'ts_visual_composer_extend'); ?>
		</div>
		<div id="ts-widgets-preview-content" class="ts-widgets-preview-content" style="width: 30%; max-width: 300px; margin: 0 auto; padding: 0;">
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>
<?php get_footer(); ?>
<?php //include get_stylesheet_directory() . '/single.php'; ?>