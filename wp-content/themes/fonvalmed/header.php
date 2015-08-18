<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package fonvalmed
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'fonvalmed' ); ?></a>
	<header id="masthead" class="site-header" role="banner">
		<div class="ctn_top-bar">
			<div class="top-bar container">
				<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_id' => 'top-bar-menu', 'menu_class' => 'l_inline' ) ); ?>
			</div>
		</div><!-- /ctn_top-bar -->
		<div class="header_container container">
			<div class="site-branding col-xs-6">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?><img class="logo img-responsive" src="<?php bloginfo("template_directory"); ?>/img/logo-fonvalmed.png" alt="Logo Fonvalmed"></a></h1>
			</div><!-- .site-branding -->
			<div class="ctn_logos-alcaldia col-xs-6">
				<a href="https://www.medellin.gov.co/irj/portal/medellin"><img src="<?php bloginfo("template_directory"); ?>/img/logos-alcaldia-medellin.jpg" alt="Logos Alcaldía de Medellín"></a>
			</div>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'fonvalmed' ); ?></button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', ) ); ?>
			</nav><!-- #site-navigation -->
		</div><!-- .header_container -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
