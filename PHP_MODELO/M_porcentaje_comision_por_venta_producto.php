<?php 
//ESTA FUNCION DEVUELVE EL PORCENTAJE DE COMSIÓN DADO EL NKING DEL USUARIO
function M_porcentaje_comision_por_venta_producto($ranking){
	$porc_comision['HIERRO']=5;
	$porc_comision['PLATA']=4;
	$porc_comision['ORO']=3;
	$porc_comision['PLATINO']=2;
	$porc_comision['DIAMANTE']=1;
	return $porc_comision[$ranking];
}
?>