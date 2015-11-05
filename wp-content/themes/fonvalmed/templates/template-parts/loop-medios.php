<?php
/**
 * Template part for displaying single posts.
 *
 * @package fonvalmed
 */

?>

<article id="post-<?php echo $_post->ID ?>" class="article-medios" >
	<?php //print_r($_post); ?>
	<h2> <a href="<?php echo get_post_permalink( $_post->ID); ?>"> <?php echo $_post->post_title ?></a> </h2>
	<div class="ctn__meta-info">
		<span class="meta-info_medio">Medio: <?php the_field('medio',$_post->ID); ?></span>
		<span class="meta-info_fecha">Fecha: <?php the_field('fecha',$_post->ID); ?></span>
		<span class="meta-info_url"><a href="<?php the_field('publicacion_medio',$_post->ID); ?>" target="_blank">Fuente</a> </span>
		<?php //print_r(the_field('publicacion_medio',$_post->ID)) ?>
	</div> 
</article><!-- #post-## -->

