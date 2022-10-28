<?php 
//ESTA FUNCIÓN DEVUELVE UN ARRAY CON LOS NOMBRES DE LAS UNIDADES DE VENTA
function M_periodos_restablecer_inventario(){
	$unidades_reestablecer[0]='Ninguno';
	$unidades_reestablecer[1]='Diariamente';
	$unidades_reestablecer[2]='Todos los lunes';
	$unidades_reestablecer[3]='Todos los martes';
	$unidades_reestablecer[4]='Todos los miércoles';
	$unidades_reestablecer[5]='Todos los jueves';
	$unidades_reestablecer[6]='Todos los viernes';
	$unidades_reestablecer[7]='Todos los sábados';
	$unidades_reestablecer[8]='Todos los domingos';
	$unidades_reestablecer[9]='El día 1 del mes';
	$unidades_reestablecer[10]='El día 15 del mes';
	$unidades_reestablecer[11]='Los días 1 y 15 del mes';
	$unidades_reestablecer[12]='Anualmente';
	return $unidades_reestablecer;
}
?>