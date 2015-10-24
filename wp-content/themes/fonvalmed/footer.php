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
					<h3 class="widget-title-footer">Suscríbete al boletín</h3>
					<!-- Begin MailChimp Signup Form -->
					<div id="mc_embed_signup">
					<form action="//fonvalmed.us11.list-manage.com/subscribe/post?u=17bd135742395ca590c4f5e90&amp;id=10d88d9dca" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					    <div id="mc_embed_signup_scroll">
						
					<div class="indicates-required"><span class="asterisk">*</span> Campos obligatorios</div>
					<div class="mc-field-group">
						<!-- <label for="mce-EMAIL">Correo Electrónico  <span class="asterisk">*</span>
					</label>
 -->						<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="*Correo elecrónico">
					</div>
					<div class="mc-field-group">
						<!-- <label for="mce-NOMBRES">Nombres </label> -->
						<input type="text" value="" name="NOMBRES" class="" id="mce-NOMBRES" placeholder="*Nombres">
					</div>
					<div class="mc-field-group">
						<!-- <label for="mce-APELLIDOS">Apellidos  <span class="asterisk">*</span>
					</label> -->
						<input type="text" value="" name="APELLIDOS" class="required" id="mce-APELLIDOS" placeholder="*Apellidos">
					</div>
					<div class="mc-terminos-condiciones">
						<label for="checkbox-input"><input id="checkbox-input" type="checkbox" required="required"> Acepto <a href="#">Términos y condiciones</a></label>
					</div>
						<div id="mce-responses" class="clear">
							<div class="response" id="mce-error-response" style="display:none"></div>
							<div class="response" id="mce-success-response" style="display:none"></div>
						</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
					    <div style="position: absolute; left: -5000px;"><input type="text" name="b_17bd135742395ca590c4f5e90_10d88d9dca" tabindex="-1" value=""></div>
					    <div class="clear"><input type="submit" value="Subscribete" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
					    </div>
					</form>
					</div>

					<!--End mc_embed_signup-->
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
