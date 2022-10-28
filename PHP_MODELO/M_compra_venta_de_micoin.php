<?php 
function M_compra_venta_de_micoin_C($conexion, $nombre, $apellido, $cedula_rif, $correo, $fecha_nacimiento, $empresa, $telefono, $direccion, $banco_nombre, $banco_numero_cuenta, $banco_tipo_cuenta, $banco_telefono, $banco_cedula_rif, $tipo_de_transaccion, $tipo_de_moneda_real, $cantidad_micoin, $id_tasa_de_cambio, $monto_bruto, $porc_comision, $monto_comision, $monto_neto, $fh_solicitado, $cta_banco_desde, $cta_banco_hacia, $numero_transferencia, $fh_pagado, $fh_confirmado, $fh_transaccion_abandonada, $estatus){//CREA VERIFICANDO DUPLICADOS
	$fecha_ii=explode(" ", $fh_solicitado);
	$monto_bruto_sql=round($monto_bruto,2);
	if($tipo_de_transaccion=='COMPRA'){
		$consulta="SELECT * FROM `mc_compra_venta_de_micoin` WHERE (`CEDULA_RIF`='$cedula_rif' AND `TIPO_DE_TRANSACCION`='$tipo_de_transaccion' AND `MONTO_BRUTO`='$monto_bruto_sql' AND `FH_SOLICITADO` LIKE '%" . $fecha_ii[0] . "%')";
	}else{
		$consulta="SELECT * FROM `mc_compra_venta_de_micoin` WHERE `CEDULA_RIF`='$cedula_rif' AND `TIPO_DE_TRANSACCION`='$tipo_de_transaccion' AND `MONTO_BRUTO`='$monto_bruto_sql' AND `FH_SOLICITADO` LIKE '%" . $fecha_ii[0] . "%'";
	}
	$resultado=mysqli_query($conexion,$consulta);
	if(($fila=mysqli_fetch_array($resultado))==true){
		return false;
	}else{
		$fecha_nacimiento=$fecha_nacimiento==''?'00-00-00 00:00:00':$fecha_nacimiento;
		$fh_solicitado=$fh_solicitado==''?'00-00-00 00:00:00':$fh_solicitado;
		$fh_pagado=$fh_pagado==''?'00-00-00 00:00:00':$fh_pagado;
		$fh_confirmado=$fh_confirmado==''?'00-00-00 00:00:00':$fh_confirmado;
		$fh_transaccion_abandonada=$fh_transaccion_abandonada==''?'00-00-00 00:00:00':$fh_transaccion_abandonada;
		$consulta="INSERT INTO `mc_compra_venta_de_micoin`(`NOMBRE`, `APELLIDO`, `CEDULA_RIF`, `CORREO`, `FECHA_NACIMIENTO`, `EMPRESA`, `TELEFONO`, `DIRECCION`, `BANCO_NOMBRE`, `BANCO_NUMERO_CUENTA`, `BANCO_TIPO_CUENTA`, `BANCO_TELEFONO`, `BANCO_CEDULA_RIF`, `TIPO_DE_TRANSACCION`, `TIPO_DE_MONEDA_REAL`, `CANTIDAD_MICOIN`, `ID_TASA_DE_CAMBIO`, `MONTO_BRUTO`, `PORC_COMISION`, `MONTO_COMISION`, `MONTO_NETO`, `FH_SOLICITADO`, `CTA_BANCO_DESDE`, `CTA_BANCO_HACIA`, `NUMERO_TRANSFERENCIA`, `FH_PAGADO`, `FH_CONFIRMADO`, `FH_TRANSACCION_ABANDONADA`, `ESTATUS`) VALUES ('$nombre', '$apellido', '$cedula_rif', '$correo', '$fecha_nacimiento', '$empresa', '$telefono', '$direccion', '$banco_nombre', '$banco_numero_cuenta', '$banco_tipo_cuenta', '$banco_telefono', '$banco_cedula_rif', '$tipo_de_transaccion', '$tipo_de_moneda_real', '$cantidad_micoin', '$id_tasa_de_cambio', '$monto_bruto', '$porc_comision', '$monto_comision', '$monto_neto', '$fh_solicitado', '$cta_banco_desde', '$cta_banco_hacia', '$numero_transferencia', '$fh_pagado', '$fh_confirmado', '$fh_transaccion_abandonada', '$estatus')";
		$resultados=mysqli_query($conexion,$consulta);
		return true;
	}
}
function M_compra_venta_de_micoin_total($conexion, $compra_o_venta){
	$consulta="SELECT COUNT(`ID_COMPRA_VENTA`) AS CANTIDAD, SUM(`CANTIDAD_MICOIN`) AS MONTO FROM `mc_compra_venta_de_micoin` WHERE `TIPO_DE_TRANSACCION`='$compra_o_venta'";	
	$resultados=mysqli_query($conexion,$consulta);
	$datos['CANTIDAD']='';
	$datos['MONTO']='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['CANTIDAD']=$fila['CANTIDAD'];
		$datos['MONTO']=$fila['MONTO'];
	}
	return $datos;
}
function M_compra_venta_de_micoin_R($conexion, $f_1, $d_1, $f_2, $d_2, $f_3, $d_3){
	//ESTA FUNCION PERMITE LEER HASTA CON 3 FILTROS EJEMPLO: $f_1='NOMBRE DE LA COLUMNA' $d_1='DATO'
	$sql_f_1=($f_1=="" and $d_1=="") ? "" : "AND `mc_compra_venta_de_micoin`.`$f_1`='$d_1'";
	$sql_f_2=($f_2=="" and $d_2=="") ? "" : "AND `mc_compra_venta_de_micoin`.`$f_2`='$d_2'";
	$sql_f_3=($f_3=="" and $d_3=="") ? "" : "AND `mc_compra_venta_de_micoin`.`$f_3`='$d_3'";
	$consulta="SELECT * FROM `mc_compra_venta_de_micoin` WHERE 1 $sql_f_1 $sql_f_2 $sql_f_3";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_COMPRA_VENTA'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['CORREO'][$i]='';
	$datos['FECHA_NACIMIENTO'][$i]='';
	$datos['EMPRESA'][$i]='';
	$datos['TELEFONO'][$i]='';
	$datos['DIRECCION'][$i]='';
	$datos['BANCO_NOMBRE'][$i]='';
	$datos['BANCO_NUMERO_CUENTA'][$i]='';
	$datos['BANCO_TIPO_CUENTA'][$i]='';
	$datos['BANCO_TELEFONO'][$i]='';
	$datos['BANCO_CEDULA_RIF'][$i]='';
	$datos['TIPO_DE_TRANSACCION'][$i]='';
	$datos['TIPO_DE_MONEDA_REAL'][$i]='';
	$datos['CANTIDAD_MICOIN'][$i]='';
	$datos['ID_TASA_DE_CAMBIO'][$i]='';
	$datos['MONTO_BRUTO'][$i]='';
	$datos['PORC_COMISION'][$i]='';
	$datos['MONTO_COMISION'][$i]='';
	$datos['MONTO_NETO'][$i]='';
	$datos['FH_SOLICITADO'][$i]='';
	$datos['CTA_BANCO_DESDE'][$i]='';
	$datos['CTA_BANCO_HACIA'][$i]='';
	$datos['NUMERO_TRANSFERENCIA'][$i]='';
	$datos['FH_PAGADO'][$i]='';
	$datos['FH_CONFIRMADO'][$i]='';
	$datos['FH_TRANSACCION_ABANDONADA'][$i]='';
	$datos['ESTATUS'][$i]='';
	$datos['MARCAR_BORRADO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_COMPRA_VENTA'][$i]=$fila['ID_COMPRA_VENTA'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['CORREO'][$i]=$fila['CORREO'];
		$datos['FECHA_NACIMIENTO'][$i]=$fila['FECHA_NACIMIENTO'];
		$datos['EMPRESA'][$i]=$fila['EMPRESA'];
		$datos['TELEFONO'][$i]=$fila['TELEFONO'];
		$datos['DIRECCION'][$i]=$fila['DIRECCION'];
		$datos['BANCO_NOMBRE'][$i]=$fila['BANCO_NOMBRE'];
		$datos['BANCO_NUMERO_CUENTA'][$i]=$fila['BANCO_NUMERO_CUENTA'];
		$datos['BANCO_TIPO_CUENTA'][$i]=$fila['BANCO_TIPO_CUENTA'];
		$datos['BANCO_TELEFONO'][$i]=$fila['BANCO_TELEFONO'];
		$datos['BANCO_CEDULA_RIF'][$i]=$fila['BANCO_CEDULA_RIF'];
		$datos['TIPO_DE_TRANSACCION'][$i]=$fila['TIPO_DE_TRANSACCION'];
		$datos['TIPO_DE_MONEDA_REAL'][$i]=$fila['TIPO_DE_MONEDA_REAL'];
		$datos['CANTIDAD_MICOIN'][$i]=$fila['CANTIDAD_MICOIN'];
		$datos['ID_TASA_DE_CAMBIO'][$i]=$fila['ID_TASA_DE_CAMBIO'];
		$datos['MONTO_BRUTO'][$i]=$fila['MONTO_BRUTO'];
		$datos['PORC_COMISION'][$i]=$fila['PORC_COMISION'];
		$datos['MONTO_COMISION'][$i]=$fila['MONTO_COMISION'];
		$datos['MONTO_NETO'][$i]=$fila['MONTO_NETO'];
		$datos['FH_SOLICITADO'][$i]=$fila['FH_SOLICITADO'];
		$datos['CTA_BANCO_DESDE'][$i]=$fila['CTA_BANCO_DESDE'];
		$datos['CTA_BANCO_HACIA'][$i]=$fila['CTA_BANCO_HACIA'];
		$datos['NUMERO_TRANSFERENCIA'][$i]=$fila['NUMERO_TRANSFERENCIA'];
		$datos['FH_PAGADO'][$i]=$fila['FH_PAGADO'];
		$datos['FH_CONFIRMADO'][$i]=$fila['FH_CONFIRMADO'];
		$datos['FH_TRANSACCION_ABANDONADA'][$i]=$fila['FH_TRANSACCION_ABANDONADA'];
		$datos['ESTATUS'][$i]=$fila['ESTATUS'];
		$datos['MARCAR_BORRADO'][$i]=$fila['MARCAR_BORRADO'];
		$i=$i+1;
	}
	return $datos;
}
function M_compra_venta_de_micoin_U_id($conexion, $id_compra_venta, $nombre, $apellido, $cedula_rif, $correo, $fecha_nacimiento, $empresa, $telefono, $direccion, $banco_nombre, $banco_numero_cuenta, $banco_tipo_cuenta, $banco_telefono, $banco_cedula_rif, $tipo_de_transaccion, $tipo_de_moneda_real, $cantidad_micoin, $id_tasa_de_cambio, $monto_bruto, $porc_comision, $monto_comision, $monto_neto, $fh_solicitado, $cta_banco_desde, $cta_banco_hacia, $numero_transferencia, $fh_pagado, $fh_confirmado, $fh_transaccion_abandonada, $estatus){//ACTUALIZA TODO
	$fecha_nacimiento=$fecha_nacimiento==''?'00-00-00 00:00:00':$fecha_nacimiento;
	$fh_solicitado=$fh_solicitado==''?'00-00-00 00:00:00':$fh_solicitado;
	$fh_pagado=$fh_pagado==''?'00-00-00 00:00:00':$fh_pagado;
	$fh_confirmado=$fh_confirmado==''?'00-00-00 00:00:00':$fh_confirmado;
	$fh_transaccion_abandonada=$fh_transaccion_abandonada==''?'00-00-00 00:00:00':$fh_transaccion_abandonada;
	$consulta="UPDATE `mc_compra_venta_de_micoin` SET 
	`NOMBRE`='$nombre', 
	`APELLIDO`='$apellido', 
	`CEDULA_RIF`='$cedula_rif', 
	`CORREO`='$correo', 
	`FECHA_NACIMIENTO`='$fecha_nacimiento', 
	`EMPRESA`='$empresa', 
	`TELEFONO`='$telefono', 
	`DIRECCION`='$direccion', 
	`BANCO_NOMBRE`='$banco_nombre', 
	`BANCO_NUMERO_CUENTA`='$banco_numero_cuenta', 
	`BANCO_TIPO_CUENTA`='$banco_tipo_cuenta', 
	`BANCO_TELEFONO`='$banco_telefono', 
	`BANCO_CEDULA_RIF`='$banco_cedula_rif', 
	`TIPO_DE_TRANSACCION`='$tipo_de_transaccion', 
	`TIPO_DE_MONEDA_REAL`='$tipo_de_moneda_real', 
	`CANTIDAD_MICOIN`='$cantidad_micoin', 
	`ID_TASA_DE_CAMBIO`='$id_tasa_de_cambio', 
	`MONTO_BRUTO`='$monto_bruto', 
	`PORC_COMISION`='$porc_comision', 
	`MONTO_COMISION`='$monto_comision', 
	`MONTO_NETO`='$monto_neto', 
	`FH_SOLICITADO`='$fh_solicitado', 
	`CTA_BANCO_DESDE`='$cta_banco_desde', 
	`CTA_BANCO_HACIA`='$cta_banco_hacia', 
	`NUMERO_TRANSFERENCIA`='$numero_transferencia', 
	`FH_PAGADO`='$fh_pagado', 
	`FH_CONFIRMADO`='$fh_confirmado', 
	`FH_TRANSACCION_ABANDONADA`='$fh_transaccion_abandonada', 
	`ESTATUS`='$estatus' 
	WHERE `ID_COMPRA_VENTA`='$id_compra_venta'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_compra_venta_de_micoin_U_id_marcar_como_borrado($conexion, $id_compra_venta){//ACTUALIZA MARCAR_BORRADO
	$consulta="UPDATE `mc_compra_venta_de_micoin` SET 
	`MARCAR_BORRADO`='SI' 
	WHERE `ID_COMPRA_VENTA`='$id_compra_venta'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_compra_venta_de_micoin_D_id($conexion, $id_compra_venta){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_compra_venta_de_micoin` WHERE `ID_COMPRA_VENTA`='$id_compra_venta'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
?>