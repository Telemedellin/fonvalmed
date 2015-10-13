<?php
/**
 * Template part for displaying single posts.
 *
 * @package fonvalmed
 */

$galerias = array();
$indice = 0;

?>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jssor.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jssor.slider.js"></script>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<div id="main-galeria">
			<script language="javascript">
				jQuery(function($) {
					var _SlideshowTransitions = [
						{$Duration: 1200, x: 0.3, $During: { $Left: [0.3, 0.7] }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },
						{ $Duration: 1200, x: -0.3, $SlideOut: true, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },
						{ $Duration: 1200, x: -0.3, $During: { $Left: [0.3, 0.7] }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },
						{ $Duration: 1200, x: 0.3, $SlideOut: true, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },
						{ $Duration: 1200, y: 0.3, $During: { $Top: [0.3, 0.7] }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true },
						{ $Duration: 1200, y: -0.3, $SlideOut: true, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true },
						{ $Duration: 1200, y: -0.3, $During: { $Top: [0.3, 0.7] }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },
						{ $Duration: 1200, y: 0.3, $SlideOut: true, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },
						{ $Duration: 1200, x: 0.3, $Cols: 2, $During: { $Left: [0.3, 0.7] }, $ChessMode: { $Column: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true },
						{ $Duration: 1200, x: 0.3, $Cols: 2, $SlideOut: true, $ChessMode: { $Column: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true },
						{ $Duration: 1200, y: 0.3, $Rows: 2, $During: { $Top: [0.3, 0.7] }, $ChessMode: { $Row: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },
						{ $Duration: 1200, y: 0.3, $Rows: 2, $SlideOut: true, $ChessMode: { $Row: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },
						{ $Duration: 1200, y: 0.3, $Cols: 2, $During: { $Top: [0.3, 0.7] }, $ChessMode: { $Column: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true },
						{ $Duration: 1200, y: -0.3, $Cols: 2, $SlideOut: true, $ChessMode: { $Column: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },
						{ $Duration: 1200, x: 0.3, $Rows: 2, $During: { $Left: [0.3, 0.7] }, $ChessMode: { $Row: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true },
						{ $Duration: 1200, x: -0.3, $Rows: 2, $SlideOut: true, $ChessMode: { $Row: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },
						{ $Duration: 1200, x: 0.3, y: 0.3, $Cols: 2, $Rows: 2, $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] }, $ChessMode: { $Column: 3, $Row: 12 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true },
						{ $Duration: 1200, x: 0.3, y: 0.3, $Cols: 2, $Rows: 2, $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] }, $SlideOut: true, $ChessMode: { $Column: 3, $Row: 12 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true },
						{ $Duration: 1200, $Delay: 20, $Clip: 3, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },
						{ $Duration: 1200, $Delay: 20, $Clip: 3, $SlideOut: true, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseOutCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },
						{ $Duration: 1200, $Delay: 20, $Clip: 12, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 },
						{ $Duration: 1200, $Delay: 20, $Clip: 12, $SlideOut: true, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseOutCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
					];

					var options = {
						$AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
						$AutoPlayInterval: 1500,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
						$PauseOnHover: 1,                                //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1
						$DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
						$ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
						$SlideDuration: 800,                                //Specifies default duration (swipe) for slide in milliseconds
						$SlideshowOptions: {                                //[Optional] Options to specify and enable slideshow or not
							$Class: $JssorSlideshowRunner$,                 //[Required] Class to create instance of slideshow
							$Transitions: _SlideshowTransitions,            //[Required] An array of slideshow transitions to play slideshow
							$TransitionsOrder: 1,                           //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
							$ShowLink: true                                    //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
						},
						$ArrowNavigatorOptions: {                       //[Optional] Options to specify and enable arrow navigator or not
							$Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
							$ChanceToShow: 1                               //[Required] 0 Never, 1 Mouse Over, 2 Always
						},
						$ThumbnailNavigatorOptions: {                       //[Optional] Options to specify and enable thumbnail navigator or not
							$Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
							$ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
							$ActionMode: 1,                                 //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
							$SpacingX: 8,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
							$DisplayPieces: 10,                             //[Optional] Number of pieces to display, default value is 1
							$ParkingPosition: 360                          //[Optional] The offset position to park thumbnail
						}
					};

					var jssor_slider1 = new $JssorSlider$("gallery_container", options);

					//responsive code begin
					//you can remove responsive code if you don't want the slider scales while window resizes
					function ScaleSlider()
					{
						var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
						if (parentWidth)
							jssor_slider1.$ScaleWidth(Math.max(Math.min(parentWidth, 800), 300));
						else
							window.setTimeout(ScaleSlider, 30);
					}

					ScaleSlider();
					$(window).bind("load", ScaleSlider);
					$(window).bind("resize", ScaleSlider);
					$(window).bind("orientationchange", ScaleSlider);
					//responsive code end
				});
			</script>

			<div id="gallery_container" style="position: relative; top: 0px; left: 0px; width: 800px; height: 456px; background: transparent; overflow: hidden;">

				<!-- Loading Screen -->
				<div u="loading" style="position: absolute; top: 0px; left: 0px;">
					<div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
						background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
					</div>
					<div style="position: absolute; display: block; background: url(<?php echo get_template_directory_uri(); ?>/img/loading.gif) no-repeat center center;
						top: 0px; left: 0px;width: 100%;height:100%;">
					</div>
				</div>

				<!-- Slides Container -->
				<div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 800px; height: 356px; overflow: hidden;">
					<?php if(have_rows('galerias')): ?>
					<?php while (have_rows('galerias')) : the_row(); ?>
						<?php $imagenes = get_sub_field('imagenes'); ?>
						<?php $galerias[get_sub_field('titulo')] = $imagenes; ?>
						<?php if ($indice == 0): ?>
						<?php foreach ($imagenes as $imagen): ?>
						<div>
							<img u="image" src="<?php echo $imagen['sizes']['large']; ?>" alt="<?php echo $imagen['alt']; ?>"/>
							<img u="thumb" src="<?php echo $imagen['sizes']['thumbnail']; ?>" alt="<?php echo $imagen['alt']; ?>"/>
						</div>
						<?php endforeach; ?>
						<?php endif; ?>
						<?php $indice++; ?>
					<?php endwhile; ?>
					<?php endif; ?>
				</div>
				<!--#region Arrow Navigator Skin Begin -->
				<style>
					/* jssor slider arrow navigator skin 05 css */
					/*
					.jssora05l                  (normal)
					.jssora05r                  (normal)
					.jssora05l:hover            (normal mouseover)
					.jssora05r:hover            (normal mouseover)
					.jssora05l.jssora05ldn      (mousedown)
					.jssora05r.jssora05rdn      (mousedown)
					*/
					.jssora05l, .jssora05r {
						display: block;
						position: absolute;
						/* size of arrow element */
						width: 40px;
						height: 40px;
						cursor: pointer;
						background: url(<?php echo get_template_directory_uri(); ?>/img/a17.png) no-repeat;
						overflow: hidden;
					}
					.jssora05l { background-position: -10px -40px; }
					.jssora05r { background-position: -70px -40px; }
					.jssora05l:hover { background-position: -130px -40px; }
					.jssora05r:hover { background-position: -190px -40px; }
					.jssora05l.jssora05ldn { background-position: -250px -40px; }
					.jssora05r.jssora05rdn { background-position: -310px -40px; }
				</style>
				<!-- Arrow Left -->
				<span u="arrowleft" class="jssora05l" style="top: 158px; left: 8px;"></span>
				<!-- Arrow Right -->
				<span u="arrowright" class="jssora05r" style="top: 158px; right: 8px"></span>
				<!--#endregion Arrow Navigator Skin End -->
				<!--#region Thumbnail Navigator Skin Begin -->
				<!-- Help: http://www.jssor.com/development/slider-with-thumbnail-navigator-jquery.html -->
				<style>
					/* jssor slider thumbnail navigator skin 01 css */
					/*
					.jssort01 .p            (normal)
					.jssort01 .p:hover      (normal mouseover)
					.jssort01 .p.pav        (active)
					.jssort01 .p.pdn        (mousedown)
					*/
					.jssort01 {
						position: absolute;
						/* size of thumbnail navigator container */
						width: 800px;
						height: 100px;
					}
						.jssort01 .p {
							position: absolute;
							top: 0;
							left: 0;
							width: 70px;
							height: 70px;
						}
						.jssort01 .t {
							position: absolute;
							top: 0;
							left: 0;
							width: 100%;
							height: 100%;
							border: none;
						}
						.jssort01 .w {
							position: absolute;
							top: 0px;
							left: 0px;
							width: 100%;
							height: 100%;
						}
						.jssort01 .c {
							position: absolute;
							top: 0px;
							left: 0px;
							width: 68px;
							height: 68px;
							border: #000 0px solid;
							box-sizing: content-box;
							background: url(<?php echo get_template_directory_uri(); ?>/img/t01.png) -800px -800px no-repeat;
							_background: none;
						}
						.jssort01 .pav .c {
							top: 0px;
							_top: 0px;
							left: 0px;
							_left: 0px;
							width: 70px;
							height: 70px;
							border: #000 0px solid;
							_border: #fff 0px solid;
							background-position: 50% 50%;
						}
						.jssort01 .p:hover .c {
							top: 0px;
							left: 0px;
							width: 70px;
							height: 70px;
							border: #fff 1px solid;
							background-position: 50% 50%;
						}
						.jssort01 .p.pdn .c {
							background-position: 50% 50%;
							width: 68px;
							height: 68px;
							border: #000 0px solid;
						}
						* html .jssort01 .c, * html .jssort01 .pdn .c, * html .jssort01 .pav .c {
							/* ie quirks mode adjust */
							width /**/: 72px;
							height /**/: 72px;
						}
				</style>

				<!-- thumbnail navigator container -->
				<div u="thumbnavigator" class="jssort01" style="left: 0px; bottom: 0px;">
					<!-- Thumbnail Item Skin Begin -->
					<div u="slides" style="cursor: default;">
						<div u="prototype" class="p">
							<div class=w><div u="thumbnailtemplate" class="t"></div></div>
							<div class=c></div>
						</div>
					</div>
					<!-- Thumbnail Item Skin End -->
				</div>
			</div>
		</div>

		<div class="container-fluid">
			<div class="row">
			<?php foreach ($galerias as $titulo => $galeria): ?>
				<div id="galeria" class="col-md-4" rel="galeria-<?php echo $galeria[0]['ID']; ?>" style="text-align: center; cursor: pointer;">
					<div class="galeria-portada" style="background-image: url(<?php echo $galeria[0]['sizes']['thumbnail']; ?>); background-position: center; background-repeat: no-repeat; height: 165px;"></div>
					<span style="font-size: 20px;color: #FF7F00;"><?php echo $titulo; ?></span>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
		<script>
			jQuery(function($) {
				$('.row > #galeria').on('click', function(evt) {
					var post_id = <?php echo get_the_ID(); ?>;
					var galeria_id = jQuery(this).attr('rel').split('-')[1];
					
					$.ajax({
						'url': '<?php echo get_template_directory_uri(); ?>/ajax/galerias.php',
						'method': 'POST',
						'data': {post_id:post_id, galeria_id:galeria_id},
						success: function(galeria)
						{
							$('#main-galeria').html(galeria);
						}
					});

					evt.stopPropagation();
				});
			});
		</script>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
