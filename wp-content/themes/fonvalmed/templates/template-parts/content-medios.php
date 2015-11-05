<?php
/**
 * Template part for displaying single posts.
 *
 * @package fonvalmed
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="ctn__meta-info">
			<span class="meta-info_medio">Medio: <?php the_field('medio',$_post->ID); ?></span>
			<span class="meta-info_fecha">Fecha: <?php the_field('fecha',$_post->ID); ?></span>
			<span class="meta-info_url"><a href="<?php the_field('publicacion_medio',$_post->ID); ?>" target="_blank">Fuente</a> </span>
			<?php //print_r(the_field('publicacion_medio',$_post->ID)) ?>
		</div> 
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fonvalmed' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<!--<footer class="entry-footer">
		<?php fonvalmed_entry_footer(); ?>
	</footer> .entry-footer -->
</article><!-- #post-## -->

