<?php

setlocale(LC_ALL, 'es_ES.UTF8');
class WidgetAvanceProyecto extends WP_Widget 
{

	function WidgetAvanceProyecto()
	{
		parent::__construct( false, 'Avance Preoyecto', array('description'=>'Permite ver el avance de tus proyectos.'));
	}

	function widget( $args, $instance )
	{
		$this->avanceView($args, $instance);
	}

	function update( $new_instance, $old_instance )
	{
		return $new_instance;
	}

	function form( $instance ) {

	}
	
	function avanceView($args, $instance)
	{
		extract($args);																					
		echo $before_widget;

		if ( post_type_exists( 'p-valorizacion' ) ):

   			$est 	= $this->estadisticasObras();

		?>
		<div class="ctn__contador-obras container-fluid">
			<div class="row">
				<div class="col-xs-6 col-md-3">
					<div class="contador-obra contador-obras-finalizadas">
						<h3 class="contador-obra-titulo">
							Obras finalizadas
						</h3>
						<span class="contador-obra-numero">
							<?php 
							if( isset($est['finalizada']) )
							{
								echo $est['finalizada'];
							} 
								
							else 
							{
								echo 0 ;
							}
								
							?>
						</span>
					</div>
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="contador-obra contador-obras-ejecucion">
						<h3 class="contador-obra-titulo">
							Obras en ejecución
						</h3>
						<span class="contador-obra-numero">
							<?php 
							if( isset($est['en-ejecucion']) )
							{
								echo $est['en-ejecucion'] ;
							} 
								
							else 
							{
								echo 0 ;
							}
								
							?>
						</span>
					</div>
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="contador-obra contador-obras-licitacion">
						<h3 class="contador-obra-titulo">
							Obras en licitación
						</h3>
						<span class="contador-obra-numero">
							<?php 
							if( isset($est['en-licitacion']) ) 
							{
								echo $est['en-licitacion'] ;
							}
							else 
							{
								echo 0  ;
							}
								
							?>
						</span>
					</div>
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="contador-obra contador-obras-ejecutar">
						<h3 class="contador-obra-titulo">
							Obras por ejecutar
						</h3>
						<span class="contador-obra-numero">
							<?php 
							if( isset($est['por-ejecutar']) ) 
							{
								echo $est['por-ejecutar'] ;
							}
							else
							{
								echo 0 ;
							} 
								
							?>
						</span>
					</div>
				</div>
			</div>
		</div><!-- /ctn__contador-obras -->
		<?php else: ?>

		<div class="ctn__contador-obras container-fluid">
			<div class="row">
				<div>
					Widget disponible solo para la sesión de obras.
				</div>
			</div>
		</div><!-- /ctn__contador-obras -->

		<?php 
		endif;

			echo $after_widget;
	}


	/**
	 * Devuelve un array con las estadisticas de las obras por proyecto
	 *
	 * @return array con estadisticas
	 * @author Telemedellìn
	 **/

	private function estadisticasObras()
	{
		$term 		= null;
		$elements 	= null;
		$fields 	= array();

		$term 		= $this->getProyecto();
		$elements 	= $this->getElements($term[0]); 

		foreach ($elements as $key => $element) 
		{
			$field = $this->getElementField($element, 'obra_estado');

			if( !empty($field) )
			{
				if( isset($fields[$field]) )
				{
					$fields[$field] += 1 ;		
				}
				else
				{
					$fields[$field] =  1 ;			
				}

			}
			
		}

		return $fields;

	}

	/**
	 * Devuelve el id del proyecto actual.
	 *
	 * @return int id del proyecto  
	 * @author Telemedellìn
	 **/

	private function getProyecto()
	{
		$id 	= get_the_ID();
		$term 	= wp_get_post_terms($id , 'nombre');

		return $term;
	}


	private function getElements($term)
	{
		/**
		* hide_empty es la propiedad que permite tomar en cuenta los post que 
		* no tienen contenido relacionado.
		**/

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


	private function getElementField($term, $value)
	{
		$field = null;
		$field = get_field($value, $term);

		if(empty($field))
		{
			return 0;
		}
		else
		{
			return $field;
		}
	}
}