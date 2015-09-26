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

		if ( post_type_exists( 'obra' ) ) 
		{
			echo  get_the_ID();
			$term = wp_get_post_terms(get_the_ID() , 'nombre');

   			if( empty($term[0]->parent) )
   			{
   				$opt = array('parent'=> $term[0]->term_id);
   			}
   			else
   			{
				$opt = array('parent'=> $term[0]->parent);
   			}

   			$term_child = get_terms('nombre', $opt);
   		//	print_r($term_child);
   			/** Que chimba
   			**/
   			print_r(get_field('obra_contenido', 'nombre'.'_'.$term_child[0]->term_id));
echo '<br><br>';
   		
   			
		}

		?>
		<div class="ctn__contador-obras container-fluid">
			<div class="row">
				<div class="col-xs-6 col-md-3">
					<div class="contador-obra contador-obras-finalizadas">
						<h3 class="contador-obra-titulo">
							Obras finalizadas
						</h3>
						<span class="contador-obra-numero">
							10
						</span>
					</div>
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="contador-obra contador-obras-ejecucion">
						<h3 class="contador-obra-titulo">
							Obras en ejecución
						</h3>
						<span class="contador-obra-numero">
							10
						</span>
					</div>
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="contador-obra contador-obras-licitacion">
						<h3 class="contador-obra-titulo">
							Obras en licitación
						</h3>
						<span class="contador-obra-numero">
							10
						</span>
					</div>
				</div>
				<div class="col-xs-6 col-md-3">
					<div class="contador-obra contador-obras-ejecutar">
						<h3 class="contador-obra-titulo">
							Obras ejecutadas
						</h3>
						<span class="contador-obra-numero">
							10
						</span>
					</div>
				</div>
			</div>
		</div><!-- /ctn__contador-obras -->
		<?php	
			echo $after_widget;
	}

	/**
	 * Devuelve el id del proyecto actual.
	 *
	 * @return int id del proyecto  
	 * @author Telemedellìn
	 **/

	private function getProyecto()
	{

	}
}
