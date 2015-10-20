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
<link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,600italic,300italic,600,700italic,400italic' rel='stylesheet' type='text/css'>

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
				<h1 class="site-title"><a class="ctn_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img class="logo" src="<?php bloginfo("template_directory"); ?>/img/logo-fonvalmed.png" alt="Logo Fonvalmed"></a></h1>
			</div><!-- .site-branding -->
			<div class="ctn_logos-alcaldia col-xs-6">
				<a href="https://www.medellin.gov.co/irj/portal/medellin"><img class="logos-alcaldia" src="<?php bloginfo("template_directory"); ?>/img/logos-alcaldia.png" alt="Logos Alcaldía de Medellín"></a>
			</div>
		</div><!-- .header_container -->
		<div class="ctn_navigation">
			<nav id="site-navigation" class="main-navigation container" role="navigation">
				<!--<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Ver navegación', 'fonvalmed' ); ?></button>-->
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', ) ); ?>
			</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->

	<?php
		$post_id = 0;
		$term = get_the_terms(get_the_ID(), 'nombre');
		$post_id = (get_field('generar_automaticamente') == 'si') ? $post->ID : ((get_field('generar_automaticamente', $post->post_parent) == 'si') ? $post->post_parent : 0);
	?>
	<?php if (is_tax() || $term[0]->taxonomy == 'nombre' || ($post_id != 0 && !is_null(get_field('imagen_de_cabezote', $post_id)))): ?>
		<?php include 'header-obra.php'; ?>
	<?php endif; ?>

	<div id="content" class="site-content container">
		<!-- #breadcrumbs -->
		<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
			<?php if(function_exists('bcn_display'))
			{
				bcn_display();
			}?>
		</div>
		<!-- #breadcrumbs -->
