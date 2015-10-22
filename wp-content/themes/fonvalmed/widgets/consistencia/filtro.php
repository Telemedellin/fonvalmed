<?php

$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once $parse_uri[0] . 'wp-load.php';

if ( isset($_POST['id_proyecto']) && isset($_POST['filtro']) )
{

	$tipo          = $_POST['filtro'];
	$id_proyecto   = $_POST['id_proyecto'];
    $term          = null;
    $elements      = null;
    $fields        = array();

    $term       = getProyecto($id_proyecto);
    $elements   = getElements($term[0]); 



    foreach ($elements as $key => $element) 
    {
        if( $tipo == 'todas')
        {
            $field = null;
            $field['name']    = $element->name;
            $field['estado']    = getElementField($element, 'obra_estado', true);
            $field['cabezote']  = getElementField($element, 'obra_cabezote');
            $geolocalizacion    = getElementField($element, 'obra_geolocalizacion');
            $field['latitud']   = $geolocalizacion['lat'];
            $field['longitud'] = $geolocalizacion['lng'];
            $field['avance']   = getElementField($element, 'obra_avance');
            $field['enlace']   = get_term_link($element);

        }
        else
        { 
            if(getElementField($element, 'obra_tipo') == $tipo)
            {
                $field = null;
                $field['name']    = $element->name;
                $field['estado']    = getElementField($element, 'obra_estado', true);
                $field['cabezote']  = getElementField($element, 'obra_cabezote');
                $geolocalizacion    = getElementField($element, 'obra_geolocalizacion');
                $field['latitud']   = $geolocalizacion['lat'];
                $field['longitud']  = $geolocalizacion['lng'];
                $field['avance']    = getElementField($element, 'obra_avance');
                $field['enlace']    = get_term_link($element);
            }

        }

        if( !empty($field) )
        {
            $fields[] = $field;
        }

    }
    header('Content-Type: application/json');
    echo json_encode($fields);
}

   function getProyecto($id_proyecto)
    {
        if( empty($id_proyecto) )
          {
            $id_proyecto  = get_the_ID();
          }  

        $term   = wp_get_post_terms($id_proyecto , 'nombre');
        return $term;
    }


    function getElements($term)
    {
        if( empty($term->parent) )
        {
            $opt = array('parent'=> $term->term_id, 'hide_empty' => 0);
        }
        else
        {
            $opt = array('parent'=> $term->parent, 'hide_empty' => 0);
        }

        $term_child = get_terms('nombre', $opt);

        return $term_child;
    }


    function getElementField($term, $value, $choice = false)
    {
        $field = null;

        if($choice)
        {
            $opt                = get_field_object($value, $term);
            $opt_value          = get_field($value, $term);
            $field              = $opt['choices'][$opt_value];
        }
        else
        {
            $field = get_field($value, $term);
        }



        if(empty($field))
        {
            return 0;
        }
        else
        {
            return $field;
        }
    }
    





?>