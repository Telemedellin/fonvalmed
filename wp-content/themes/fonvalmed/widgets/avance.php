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
		$galerias = '';

		?>
			<div>
				<H1>Avance</H1>
			</div>
		<?php	
			echo $after_widget;
	}
}
