<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package fonvalmed
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="ctn_footer-cols container">
			<div class="row-fluid">
				<div class="footer-col-1 footer-col col-md-3">
					<?php dynamic_sidebar( 'sidebar-footer-1' ); ?>
				</div>
				<div class="footer-col-2 footer-col col-md-3">
					<?php dynamic_sidebar( 'sidebar-footer-2' ); ?>
				</div>
				<div class="footer-col-3 footer-col col-md-3">
					<?php dynamic_sidebar( 'sidebar-footer-3' ); ?>
				</div>
				<div class="footer-col-4 footer-col col-md-3">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<figure class="ctn_edificios">
							<img class="edificios" src="<?php bloginfo("template_directory"); ?>/img/edificios.png" alt="Logo de Fonvalmed acompañado de édificios">
						</figure>
					</a>
				</div>
			</div>
		</div>
		<div class="ctn_footer-logos">
			<div class="footer-logos-plugin container">
				<?php kw_sc_logo_carousel('logos-footer'); ?>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->
<div class="ctn_fixed-bar">
	<div class="fixed-bar container">
		<div class="row">
			<div class="ctn_search-form col-xs-7 col-sm-6 col-md-4">
				<?php get_search_form(); ?>
			</div>
			<div class="ctn_iconos-footer col-xs-5 col-sm-6 col-md-8">
				<ul class="l_inline">
					<li><a class="icon-facebook" href="http://www.facebook.com/pages/#!/pages/Fonval-Fondo-de-Valorizacion-Municipio-de-Medellin/183667628320342" target="_blank"></a></li>
					<li><a class="icon-twitter" href="http://twitter.com/fonvalmed" target="_blank"></a></li>
					<li class="hidden-xs"><a class="icon-youtube" href="http://www.youtube.com/user/fonvalmed" target="_blank"></a></li>
					<li class="hidden-xs"><a class="icon-talk-chat-2" href="#" target="_blank"></a></li>
					<li class="hidden-xs"><a class="icon-mail" href="#" target="_blank"></a></li>
					<li><a class="icon-call-phone" href="tel:0346048533"></a><span class="txt-phone hidden-xs hidden-sm">Línea gratuita: 01 8000 18 03 03</span></li>
					<li class="hidden-xs"><a href="#">Conoce las obras</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php wp_footer(); ?>

</body>
</html>
