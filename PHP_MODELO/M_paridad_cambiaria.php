<?php 
function M_paridad_cambiaria_C($conexion, $fh_registro, $tipo_de_moneda_real, $tipo_por_micoin_compra, $tipo_por_micoin_venta, $porc_comision_por_compra, $porc_comision_por_venta){//CREA VERIFICANDO DUPLICADOS
	$consulta="SELECT * FROM `mc_paridad_cambiaria` WHERE `FH_REGISTRO`='$fh_registro' AND `TIPO_DE_MONEDA_REAL`='$tipo_de_moneda_real' AND `TIPO_POR_MICOIN_COMPRA`='$tipo_por_micoin_compra' AND `TIPO_POR_MICOIN_VENTA`='$tipo_por_micoin_venta' AND `PORC_COMISION_POR_COMPRA`='$porc_comision_por_compra' AND `PORC_COMISION_POR_VENTA`='$porc_comision_por_venta'";
	$resultado=mysqli_query($conexion,$consulta);
	if(($fila=mysqli_fetch_array($resultado))==true){
		return false;
	}else{
		$fh_registro=$fh_registro==''?'00-00-00 00:00:00':$fh_registro;
		$consulta="INSERT INTO `mc_paridad_cambiaria`(`FH_REGISTRO`, `TIPO_DE_MONEDA_REAL`, `TIPO_POR_MICOIN_COMPRA`, `TIPO_POR_MICOIN_VENTA`, `PORC_COMISION_POR_COMPRA`, `PORC_COMISION_POR_VENTA`) VALUES ('$fh_registro', '$tipo_de_moneda_real', '$tipo_por_micoin_compra', '$tipo_por_micoin_venta', '$porc_comision_por_compra', '$porc_comision_por_venta')";
		$resultados=mysqli_query($conexion,$consulta);
		return true;
	}
}
function M_paridad_cambiaria_R($conexion, $f_1, $d_1, $f_2, $d_2, $f_3, $d_3){
	//ESTA FUNCION PERMITE LEER HASTA CON 3 FILTROS EJEMPLO: $f_1='NOMBRE DE LA COLUMNA' $d_1='DATO'
	$sql_f_1=($f_1=="" and $d_1=="") ? "" : "AND `mc_paridad_cambiaria`.`$f_1`='$d_1'";
	$sql_f_2=($f_2=="" and $d_2=="") ? "" : "AND `mc_paridad_cambiaria`.`$f_2`='$d_2'";
	$sql_f_3=($f_3=="" and $d_3=="") ? "" : "AND `mc_paridad_cambiaria`.`$f_3`='$d_3'";
	$consulta="SELECT * FROM `mc_paridad_cambiaria` WHERE 1 $sql_f_1 $sql_f_2 $sql_f_3 ORDER BY FH_REGISTRO DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_TASA_DE_CAMBIO'][$i]='';
	$datos['FH_REGISTRO'][$i]='';
	$datos['TIPO_DE_MONEDA_REAL'][$i]='';
	$datos['TIPO_POR_MICOIN_COMPRA'][$i]='';
	$datos['TIPO_POR_MICOIN_VENTA'][$i]='';
	$datos['PORC_COMISION_POR_COMPRA'][$i]='';
	$datos['PORC_COMISION_POR_VENTA'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_TASA_DE_CAMBIO'][$i]=$fila['ID_TASA_DE_CAMBIO'];
		$datos['FH_REGISTRO'][$i]=$fila['FH_REGISTRO'];
		$datos['TIPO_DE_MONEDA_REAL'][$i]=$fila['TIPO_DE_MONEDA_REAL'];
		$datos['TIPO_POR_MICOIN_COMPRA'][$i]=$fila['TIPO_POR_MICOIN_COMPRA'];
		$datos['TIPO_POR_MICOIN_VENTA'][$i]=$fila['TIPO_POR_MICOIN_VENTA'];
		$datos['PORC_COMISION_POR_COMPRA'][$i]=$fila['PORC_COMISION_POR_COMPRA'];
		$datos['PORC_COMISION_POR_VENTA'][$i]=$fila['PORC_COMISION_POR_VENTA'];
		$i=$i+1;
	}
	return $datos;
}
function M_paridad_cambiaria_R_ultima($conexion){//LEE DADO UN INTERVALO DE FECHAS
	$consulta="SELECT * FROM `mc_paridad_cambiaria` WHERE `ID_TASA_DE_CAMBIO`=(SELECT MAX(`ID_TASA_DE_CAMBIO`) FROM `mc_paridad_cambiaria`)";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_TASA_DE_CAMBIO'][$i]='';
	$datos['FH_REGISTRO'][$i]='';
	$datos['TIPO_DE_MONEDA_REAL'][$i]='';
	$datos['TIPO_POR_MICOIN_COMPRA'][$i]='';
	$datos['TIPO_POR_MICOIN_VENTA'][$i]='';
	$datos['PORC_COMISION_POR_COMPRA'][$i]='';
	$datos['PORC_COMISION_POR_VENTA'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_TASA_DE_CAMBIO'][$i]=$fila['ID_TASA_DE_CAMBIO'];
		$datos['FH_REGISTRO'][$i]=$fila['FH_REGISTRO'];
		$datos['TIPO_DE_MONEDA_REAL'][$i]=$fila['TIPO_DE_MONEDA_REAL'];
		$datos['TIPO_POR_MICOIN_COMPRA'][$i]=$fila['TIPO_POR_MICOIN_COMPRA'];
		$datos['TIPO_POR_MICOIN_VENTA'][$i]=$fila['TIPO_POR_MICOIN_VENTA'];
		$datos['PORC_COMISION_POR_COMPRA'][$i]=$fila['PORC_COMISION_POR_COMPRA'];
		$datos['PORC_COMISION_POR_VENTA'][$i]=$fila['PORC_COMISION_POR_VENTA'];
		$i=$i+1;
	}
	return $datos;
}
function M_paridad_cambiaria_R_ultima_x_fecha($conexion, $fecha){//LEE ULTIMO REGISTRO DE UNA FECHA
	$consulta="SELECT * FROM `mc_paridad_cambiaria` WHERE `FH_REGISTRO` LIKE '%" . $fecha . "%' ORDER BY `ID_TASA_DE_CAMBIO` DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_TASA_DE_CAMBIO'][$i]='';
	$datos['FH_REGISTRO'][$i]='';
	$datos['TIPO_DE_MONEDA_REAL'][$i]='';
	$datos['TIPO_POR_MICOIN_COMPRA'][$i]='';
	$datos['TIPO_POR_MICOIN_VENTA'][$i]='';
	$datos['PORC_COMISION_POR_COMPRA'][$i]='';
	$datos['PORC_COMISION_POR_VENTA'][$i]='';
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_TASA_DE_CAMBIO'][$i]=$fila['ID_TASA_DE_CAMBIO'];
		$datos['FH_REGISTRO'][$i]=$fila['FH_REGISTRO'];
		$datos['TIPO_DE_MONEDA_REAL'][$i]=$fila['TIPO_DE_MONEDA_REAL'];
		$datos['TIPO_POR_MICOIN_COMPRA'][$i]=$fila['TIPO_POR_MICOIN_COMPRA'];
		$datos['TIPO_POR_MICOIN_VENTA'][$i]=$fila['TIPO_POR_MICOIN_VENTA'];
		$datos['PORC_COMISION_POR_COMPRA'][$i]=$fila['PORC_COMISION_POR_COMPRA'];
		$datos['PORC_COMISION_POR_VENTA'][$i]=$fila['PORC_COMISION_POR_VENTA'];
		$i=$i+1;
	}
	return $datos;
}
function M_paridad_cambiaria_U_id($conexion, $id_tasa_de_cambio, $fh_registro, $tipo_de_moneda_real, $tipo_por_micoin_compra, $tipo_por_micoin_venta, $porc_comision_por_compra, $porc_comision_por_venta){//MODIFICA TODOS LOS DATOS
	$fh_registro=$fh_registro==''?'00-00-00 00:00:00':$fh_registro;
	$consulta="UPDATE `mc_paridad_cambiaria` SET 
	`FH_REGISTRO`='$fh_registro', 
	`TIPO_DE_MONEDA_REAL`='$tipo_de_moneda_real', 
	`TIPO_POR_MICOIN_COMPRA`='$tipo_por_micoin_compra', 
	`TIPO_POR_MICOIN_VENTA`='$tipo_por_micoin_venta', 
	`PORC_COMISION_POR_COMPRA`='$porc_comision_por_compra', 
	`PORC_COMISION_POR_VENTA`='$porc_comision_por_venta' 
	WHERE `ID_TASA_DE_CAMBIO`='$id_tasa_de_cambio'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_paridad_cambiaria_D_id($conexion, $id_tasa_de_cambio){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_paridad_cambiaria` WHERE `ID_TASA_DE_CAMBIO`='$id_tasa_de_cambio'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
?>