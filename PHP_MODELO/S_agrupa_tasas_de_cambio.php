<?php 
//ESTA SUB RUTINA IMPRIME LAS OPCIONES DE TASA DE CAMBIO PARA UNA MONEDA DADA
if(isset($_POST['moneda'])){
	$moneda=$_POST['moneda']; 
	require_once ("M_todos.php");
	$tasas=M_paridad_cambiaria_R($conexion, 'TIPO_DE_MONEDA_REAL', $moneda, '', '', '', '');
	$i=0;
	echo "<option></option>";
	while(isset($tasas['ID_TASA_DE_CAMBIO'][$i])){
		$fecha_i=explode(" ",$tasas['FH_REGISTRO'][$i]);
		echo "<option value='" . $tasas['ID_TASA_DE_CAMBIO'][$i] . "'>" . $fecha_i[0] . ": " . $tasas['TIPO_DE_MONEDA_REAL'][$i] . " C: " .  $tasas['TIPO_POR_MICOIN_COMPRA'][$i] . "(" . $tasas['PORC_COMISION_POR_COMPRA'][$i] . "%) V: " . $tasas['TIPO_POR_MICOIN_VENTA'][$i] . "(" . $tasas['PORC_COMISION_POR_VENTA'][$i] . "%)</option>";
		$i=$i+1;
	}
}
?>