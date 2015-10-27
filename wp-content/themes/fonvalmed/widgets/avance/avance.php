<?php

class WidgetAvanceProyecto extends WP_Widget 
{

	function WidgetAvanceProyecto()
	{
		parent::__construct( false, 'Avance Proyecto', array('description'=>'Permite ver el avance de tus proyectos.'));
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

	function script_chart()
	{
		
	}
	//add_action('wp_head','script_chart');

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
							if(isset($est['finalizada']))
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
		<h2>Recaudo</h2>
		<div class="ctn__recaudo">
			<div class="row">
				<div class="col-md-5">
					<div class="ctn__recaudo_texto">
						<p class="recaudo-texto">
							Con tu aporte estamos haciendo realidad las obras en El Poblado
						</p>
					</div>
				</div>
				<div class="col-md-7">
					<div class="ctn__recaudo_total">
						<?php
							$meses = array(
								"01" => "Enero",
								"02" => "Febrero",
								"03" => "Marzo",
								"04" => "Abril",
								"05" => "Mayo",
								"06" => "Junio",
								"07" => "Julio",
								"08" => "Agosto",
								"09" => "Septiembre",
								"10" => "Octubre",
								"11" => "Noviembre",
								"12" => "Diciembre"
							);

							$datos = array();
							foreach ($meses as $key => $value):
								$datos[date('Y')][$value] = 0;
							endforeach;
						?>
						<?php $term = $this->getProyecto(); ?>
						<?php $slug = $term[0]->taxonomy . '_' . $term[0]->term_id; ?>
						<?php $total_recaudo = get_field('recaudo', 5); ?>
						<?php if(have_rows('obra_recaudo', $slug)): ?>
							<?php while (have_rows('obra_recaudo', $slug)) : the_row(); ?>
								<?php $mes = get_sub_field('mes', $slug); ?>
								<?php $anho = get_sub_field('ano', $slug); ?>
								<?php $recaudo = get_sub_field('recaudo', $slug); ?>
								<?php if (date('Y') == $anho && $mes != $meses[date('m')]): ?>
									<?php $datos[$anho][$mes] = $recaudo; ?>
								<?php endif; ?>
							<?php endwhile; ?>
						<?php endif; ?>
						<p class="recaudo-total-texto">Recuado contribución de valorización - <span class="recaudo-total-fecha">Hoy <?php echo date('d'); ?> de <?php echo $meses[date('m')]; ?></span></p>
						<span class="recaudo-total-numero">$<?php echo number_format($total_recaudo,2,',','.'); ?></span>
					</div>
				</div>
			</div>
		</div><!-- /ctn__recaudo -->
		<div class="ctn__info-recaudo container-fluid">
			<div class="row">
				<div class="col-sm-9">
					<div class="ctn__infor-recaudo_grafico">
						<?php echo '<script type="text/javascript" src="' . get_template_directory_uri() . '/widgets/avance/js/chart.js?ver=1.0.0"></script>'; ?>
						<canvas id="chart-area" style="width: 90%;height: 190px;"></canvas>
						<?php
							$data_chart = '';
							$mes_index = 1;
							foreach ($datos[date('Y')] as $key => $value):
								if ($mes_index != 12):
									$data_chart .= '"'.number_format($value,0,',','.').'",';
								else:
									$data_chart .= '"'.number_format($value,0,',','.').'"';
								endif;
								$mes_index++;
							endforeach;
						?>
						<script>
							var barChartData = {
								labels : ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
								datasets : [
									{
										fillColor : "#CBC9CA",
										strokeColor : "#ffffff",
										highlightFill: "#898989",
										highlightStroke: "#ffffff",
										data : [<?php echo $data_chart; ?>]
									}
								]
							}
							var ctx3 = document.getElementById("chart-area").getContext("2d");
							window.myPie = new Chart(ctx3).Bar(barChartData, {
								responsive:true,
								scaleShowLabels: false,
								scaleIntegersOnly: false,
								tooltipTemplate: "<%if (label){%><%=label%>: $ <%}%><%= value %>"
							});
						</script>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="ctn__info-recaudo_propietarios">
						<h3 class="info-recaudo_propietarios_title">
							Propietarios que han pagado el total de la contribución
						</h3>
						<span class="info-recaudo_propietarios_total">
							<?php
								$pago_contribucion = get_field('pago_contribucion', $slug);
								if ((empty($pago_contribucion)) || (is_null($pago_contribucion)))
									$pago_contribucion = 0;
							?>
							<?php echo number_format($pago_contribucion,0,',','.'); ?>
						</span>
					</div>
				</div>
			</div>
		</div><!-- /ctn__info-recaudo -->
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
		$field = get_field($value, $term->taxonomy . '_' . $term->term_id);

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