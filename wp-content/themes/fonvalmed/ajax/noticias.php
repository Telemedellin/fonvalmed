<?php

$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once $parse_uri[0] . 'wp-load.php';

extract($_POST);

$txtDesde = explode("-", $txtDesde);
$txtHasta = explode("-", $txtHasta);

$query = array(
	'cat' => 'noticias',
	'date_query' => array(
		array(
			'year' => $txtDesde[0],
			'month' => $txtDesde[1],
			'day' => $txtDesde[2],
			'compare' => '>='
		),
		array(
			'year' => $txtHasta[0],
			'month' => $txtHasta[1],
			'day' => $txtHasta[2],
			'compare' => '<='
		)
	)
);

query_posts($query);

$datos = array();

$container_active = '<div class="owl-item active" style="width: 825px; margin-right: 10px;"><div class="vc_pageable-slide-wrapper">';
$container = '<div class="owl-item" style="width: 825px; margin-right: 10px;"><div class="vc_pageable-slide-wrapper">';

$datos['content'] = '';
$datos['pag'] = '';
$cont = 0;
$pag = 1;

if (have_posts()):
	while ( have_posts() ) : the_post() ?>
	<?php
		if ($cont == 0):
			$datos['content'] .= $container_active;
			$datos['pag'] .= '<li class="vc_grid-page vc_grid-active"><a href="javascript:void(0);">1</a></li>';
		endif;

		if ($cont == 9):
			$pag++;
			$datos['content'] .= '</div></div>' . $container;
			$datos['pag'] .= '<li class="vc_grid-page"><a href="javascript:void(0);">'.$pag.'</a></li>';
			$cont = 0;
		endif;

		$image = '';
		if (has_post_thumbnail(get_the_ID())):
			$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), "single-post-thumbnail");
			$image = $image[0];
		endif;

		$datos['content'] .= '<div class="vc_grid-item vc_clearfix vc_col-sm-4 vc_grid-item-zone-c-bottom vc_visible-item">';
		$datos['content'] .= '<div class="vc_grid-item-mini vc_clearfix">';
		$datos['content'] .= '<div class="vc_gitem-animated-block  vc_gitem-animate vc_gitem-animate-scaleRotateIn" data-vc-animation="scaleRotateIn">';
		$datos['content'] .= '<div class="vc_gitem-zone vc_gitem-zone-a vc-gitem-zone-height-mode-auto vc-gitem-zone-height-mode-auto-1-1 vc_gitem-is-link" style="background-image: url('.$image.') !important;">';
		$datos['content'] .= '<a href="'.esc_url(get_permalink()).'" title="'.get_the_title().'" class="vc_gitem-link vc-zone-link"></a>';
		$datos['content'] .= '<img src="'.$image.'" class="vc_gitem-zone-img" alt="">';
		$datos['content'] .= '<div class="vc_gitem-zone-mini"></div>';
		$datos['content'] .= '</div>';
		$datos['content'] .= '<div class="vc_gitem-zone vc_gitem-zone-b vc_custom_1419240793832 vc-gitem-zone-height-mode-auto vc_gitem-is-link">';
		$datos['content'] .= '<a href="'.esc_url(get_permalink()).'" title="'.get_the_title().'" class="vc_gitem-link vc-zone-link"></a>';
		$datos['content'] .= '<div class="vc_gitem-zone-mini"></div>';
		$datos['content'] .= '</div>';
		$datos['content'] .= '</div>';
		$datos['content'] .= '<div class="vc_gitem-zone vc_gitem-zone-c vc_custom_1445724277939">';
		$datos['content'] .= '<div class="vc_gitem-zone-mini">';
		$datos['content'] .= '<div class="vc_gitem_row vc_row vc_gitem-row-position-top">';
		$datos['content'] .= '<div class="vc_col-sm-12 vc_gitem-col vc_gitem-col-align-left vc_custom_1445724101414">';
		$datos['content'] .= '<div class="vc_custom_heading vc_custom_1445724123007 vc_gitem-post-data vc_gitem-post-data-source-post_title">';
		$datos['content'] .= '<h4 style="text-align: left">';
		$datos['content'] .= '<a href="'.esc_url(get_permalink()).'" class="vc_gitem-link" title="'.get_the_title().'">'.get_the_title().'</a>';
		$datos['content'] .= '</h4>';
		$datos['content'] .= '</div>';
		$datos['content'] .= '<div class="vc_custom_heading vc_gitem-post-data vc_gitem-post-data-source-post_date">';
		$datos['content'] .= '<div style="font-size: 14px;color: #afafaf;text-align: left">'.get_the_date().'</div>';
		$datos['content'] .= '</div>';
		$datos['content'] .= '</div>';
		$datos['content'] .= '</div>';
		$datos['content'] .= '</div>';
		$datos['content'] .= '</div>';
		$datos['content'] .= '</div>';
		$datos['content'] .= '<div class="vc_clearfix"></div>';
		$datos['content'] .= '</div>';

		$cont++;
	?>
	<?php 
	endwhile;

	if ($cont != 0 && $cont < 9):
		$datos['content'] .= '</div></div>';
	endif;

else:
	$datos['content'] = '<h1>No existe contenido relacionado</h1>';
endif;

echo json_encode($datos);

?>