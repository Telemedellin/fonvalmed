<?php

$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once $parse_uri[0] . 'wp-load.php';

if ((isset($_POST['tipo']) && isset($_POST['filtro'])) || (isset($_POST['tipo'])))
{
	$tipo = $_POST['tipo'];
	$filtros = $_POST['filtro'];
    $term_id = $_POST['term_id'];
    $taxonomy = $_POST['taxonomy'];
    $active = $_POST['active'];
	$estado = '';
	$html = null;
	$obras = array();
    $obra_name = array();

    if ($active == 'true'):
        foreach ($filtros as $value):
            $filtro = explode(":", $value);
            $filtro_a = $filtro[1];
            $opcion = $filtro[0];
            foreach (get_term_children($term_id, $taxonomy) as $termid):
                $obra = get_term($termid, $taxonomy);

                switch ($opcion):
                    case 'estado':
                        $filtro_b = sanitize_title(get_field('obra_estado', $taxonomy.'_'.$termid));
                        break;
                    case 'zona':
                        $filtro_b = sanitize_title(get_field('obra_zona', $taxonomy.'_'.$termid));
                        break;
                    case 'tipo':
                        $filtro_b = sanitize_title(get_field('obra_tipo', $taxonomy.'_'.$termid));
                        break;
                endswitch;

                if ($filtro_a == $filtro_b):
                    if (!in_array($obra->name, $obra_name)):
                        $obra_name[] = $obra->name;
                        if ($tipo == 'mapa'):
                            $cabezote = get_field('obra_cabezote', $taxonomy.'_'.$termid);
                            $obra->cabezote = $cabezote['url'];
                            $geolocalizacion = get_field('obra_geolocalizacion', $taxonomy.'_'.$termid);
                            $obra->latitud = $geolocalizacion['lat'];
                            $obra->longitud = $geolocalizacion['lng'];
                            $obra->estado = get_field('obra_estado', $taxonomy.'_'.$termid);
                            $obra->avance = get_field('obra_avance', $taxonomy.'_'.$termid);
                            $obras[] = $obra;
                        else:
                            $html .= '<div class="col-md-4">';
                                $html .= '<div>';
                                    $html .= '<div></div>';
                                    $html .= '<p>'.$obra->name.'</p>';
                                    $html .= '<p>'.get_field('obra_estado', $taxonomy.'_'.$termid).'</p>';
                                    $html .= '<hr class="linea">';
                                    $html .= '<div class="obra-avance">';
                                        $html .= '<span class="texto">'.get_field('obra_avance', $taxonomy.'_'.$termid).'%</span>';
                                        $html .= '<span class="porcentaje" style="width: '.get_field('obra_avance', $taxonomy.'_'.$termid).'%;"></span>';
                                    $html .= '</div>';
                                $html .= '</div>';
                            $html .= '</div>';
                        endif;
                    endif;
                endif;
            endforeach;
        endforeach;
    else:
        foreach (get_term_children($term_id, $taxonomy) as $termid):
            $obra = get_term($termid, $taxonomy);
            if ($tipo == 'mapa'):
                $cabezote = get_field('obra_cabezote', $taxonomy.'_'.$termid);
                $obra->cabezote = $cabezote['url'];
                $geolocalizacion = get_field('obra_geolocalizacion', $taxonomy.'_'.$termid);
                $obra->latitud = $geolocalizacion['lat'];
                $obra->longitud = $geolocalizacion['lng'];
                $obra->estado = get_field('obra_estado', $taxonomy.'_'.$termid);
                $obra->avance = get_field('obra_avance', $taxonomy.'_'.$termid);
                $obras[] = $obra;
            else:
                $html .= '<div class="col-md-4">';
                    $html .= '<div>';
                        $html .= '<div></div>';
                        $html .= '<p>'.$obra->name.'</p>';
                        $html .= '<p>'.get_field('obra_estado', $taxonomy.'_'.$termid).'</p>';
                        $html .= '<hr class="linea">';
                        $html .= '<div class="obra-avance">';
                            $html .= '<span class="texto">'.get_field('obra_avance', $taxonomy.'_'.$termid).'%</span>';
                            $html .= '<span class="porcentaje" style="width: '.get_field('obra_avance', $taxonomy.'_'.$termid).'%;"></span>';
                        $html .= '</div>';
                    $html .= '</div>';
                $html .= '</div>';
            endif;
        endforeach;
    endif;

	if ($tipo == 'listado'):
		echo $html;
	else:
        header('Content-Type: application/json');
		echo json_encode($obras);
    endif;
}

?>