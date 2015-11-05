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
                        $filtro_b = get_field('obra_estado', $taxonomy.'_'.$termid);
                        break;
                    case 'zona':
                        $filtro_b = get_field('obra_zona', $taxonomy.'_'.$termid);
                        break;
                    case 'tipo':
                        $filtro_b = get_field('obra_tipo', $taxonomy.'_'.$termid);
                        break;
                endswitch;

                if ($filtro_a == $filtro_b):
                    if (!in_array($obra->name, $obra_name)):
                        $obra_name[] = $obra->name;

						$obra->cabezote = get_field('imagen_destacada', $taxonomy.'_'.$termid);
						$geolocalizacion = get_field('obra_geolocalizacion', $taxonomy.'_'.$termid);
						$obra->latitud = $geolocalizacion['lat'];
						$obra->longitud = $geolocalizacion['lng'];

						$obra_estado = get_field_object('obra_estado', $taxonomy.'_'.$termid);
						$obra_estado_valor = get_field('obra_estado', $taxonomy.'_'.$termid);
						$obra->estado = $obra_estado['choices'][$obra_estado_valor];

						$obra->avance = get_field('obra_avance', $taxonomy.'_'.$termid);
						$obra->enlace = get_term_link($termid, $taxonomy);

                        if ($tipo == 'mapa'):
                            $obras[] = $obra;
                        else:
							if (is_null($html))
								$html = '<div class="grid-sizer"></div>';

                            $html .= '<a href="'.get_term_link($termid, $taxonomy).'" class="ctn__obra-preview">';
                                $html .= '<div class="ctn__obra-preview_image" style="background: url('.$obra->cabezote.') no-repeat; background-size: 100%; background-position: center center;"></div>';
                                    $html .= '<div class="ctn__obra-preview_contenido">';
										$html .= '<p>'.$obra->name.'</p>';
										$html .= '<hr class="linea">';
										$html .= '<span class="obra-preview_estado">'.$obra->estado.'</span>';
										$html .= '<div class="obra-avance">';
											$html .= '<span class="obra-avance_texto">'.$obra->avance.'%</span>';
											$html .= '<span class="obra-avance_porcentaje" style="width: '.$obra->avance.'%;"></span>';
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

			$obra->cabezote = get_field('imagen_destacada', $taxonomy.'_'.$termid);
			$geolocalizacion = get_field('obra_geolocalizacion', $taxonomy.'_'.$termid);
			$obra->latitud = $geolocalizacion['lat'];
			$obra->longitud = $geolocalizacion['lng'];

			$obra_estado = get_field_object('obra_estado', $taxonomy.'_'.$termid);
			$obra_estado_valor = get_field('obra_estado', $taxonomy.'_'.$termid);
			$obra->estado = $obra_estado['choices'][$obra_estado_valor];

			$obra->avance = get_field('obra_avance', $taxonomy.'_'.$termid);
			$obra->enlace = get_term_link($termid, $taxonomy);

            if ($tipo == 'mapa'):
                $obras[] = $obra;
            else:
				if (is_null($html))
					$html = '<div class="grid-sizer"></div>';
                $html .= '<a href="'.get_term_link($termid, $taxonomy).'" class="ctn__obra-preview">';
                    $html .= '<div class="ctn__obra-preview_image" style="background: url('.$obra->cabezote.') no-repeat; background-size: 100%; background-position: center center;"></div>';
                        $html .= '<div class="ctn__obra-preview_contenido">';
							$html .= '<p>'.$obra->name.'</p>';
							$html .= '<hr class="linea">';
							$html .= '<span class="obra-preview_estado">'.$obra->estado.'</span>';
							$html .= '<div class="obra-avance">';
								$html .= '<span class="obra-avance_texto">'.$obra->avance.'%</span>';
								$html .= '<span class="obra-avance_porcentaje" style="width: '.$obra->avance.'%;"></span>';
							$html .= '</div>';
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</a>';
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