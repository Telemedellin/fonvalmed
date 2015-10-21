 <?php
setlocale(LC_ALL, 'es_ES.UTF8');
class WidgetConsistencia extends WP_Widget 
{

	function WidgetConsistencia()
	{
		parent::__construct( false, 'Consistencia Proyecto', array('description'=>'Permite ver la tipificacion de las obras segun su estado (depende de API de Google Maps).'));
	}

	function widget( $args, $instance )
	{
		$this->consistenciaView($args, $instance);
	}

	function update( $new_instance, $old_instance )
	{
		return $new_instance;
	}

	function form( $instance ) {

	}
	
	function consistenciaView($args, $instance)
	{

		extract($args);																					
		echo $before_widget;

		if ( post_type_exists( 'obra' ) ):

			wp_enqueue_script( 'widget-consistencia-script', get_template_directory_uri() . '/widgets/consistencia/js/script.js', array(), true );

			/**
			* Pasando los datos a los script
			**/
			$data = array(
				'url' =>  get_template_directory_uri() . '/widgets/consistencia/',
			);

			wp_localize_script( 'widget-consistencia-script', 'consistencia_script', $data);
			$pro_id = get_the_ID();

		?>
		<div class="ctn__contador-obras container-fluid">
			<div class="row">
				<div class="contador-obras-consistencia col-md-10" rel="<?php echo $pro_id ?>">
					<div class="contador-obras-consistencia-header">
						<ul>
							<li class="puente">puente</li>
							<li class="paso-a-desnivel-puente">Paso a desnivel - puente</li>
							<li class="paso-a-deprimido">Paso a desnivel - deprimido</li>
							<li class="via-nueva-o-mejorada">Vía nueva o mejorada</li>
							<li class="doble-calzada">Doble calzada</li>
							<li class="todas">Todas</li>
						</ul>
					</div>
					<div class="contador-obras-consistencia-content col-md-10">
						<div class="consistencia-content-title">
							<h3 class="title">puente</h3>
						</div>
						<div class="consistencia-content-body">
							<div id="consistencia-map">
								<div id="map" style="width: 100%; height: 400px" >
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script async defer src="https://maps.googleapis.com/maps/api/js?callback=initMap"></script>
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



}
