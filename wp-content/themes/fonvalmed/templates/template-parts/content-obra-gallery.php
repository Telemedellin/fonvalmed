<?php
/**
 * Template part for displaying single posts.
 *
 * @package fonvalmed
 */

$galerias = array();
$indice = 0;

?>

<link type="text/css" href="<?php echo get_template_directory_uri(); ?>/gallery/gallery.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.pikachoose.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.touchwipe.min.js"></script>
<script language="javascript">
	jQuery(function($) {
		$(document).ready(function (){
			$("#gallery").PikaChoose({
				hoverPause:true,
				text: {
					previous: "",
					next: ""
				},
				showTooltips:false,
				autoPlay:false,
				transition:[0],
				thumbOpacity:0.7
			});
		});
	});
</script>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<div class="pikachoose">
			<ul id="gallery">
			<?php if(have_rows('galerias')): ?>
			<?php while (have_rows('galerias')) : the_row(); ?>
				<?php $imagenes = get_sub_field('imagenes'); ?>
				<?php if ($indice == 0): ?>
				<?php foreach ($imagenes as $imagen): ?>
				<li>
					<a href="#<?php //echo $imagen['url']; ?>">
						<img src="<?php echo $imagen['sizes']['large']; ?>" alt="<?php echo $imagen['alt']; ?>"/>
					</a>
					<span><?php echo $imagen['caption']; ?></span>
				</li>
				<?php endforeach; ?>
				<?php else: ?>
				<?php $galerias[get_sub_field('titulo')] = $imagenes; ?>
				<?php endif; $indice++; ?>
			<?php endwhile; $indice = 0; ?>
			<?php endif; ?>
			</ul>
		</div>
		<?php foreach ($galerias as $titulo => $galeria): ?>
			<?php echo $titulo; ?>
			<?php echo $galeria[$indice]['url']; ?>
			<?php $indice++; ?>
		<?php endforeach; ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
