<?php 
function M_control_de_transacciones_micoin_C($conexion, $comprador_nombre, $comprador_apellido, $comprador_cedula_rif, $comprador_correo, $comprador_fecha_nacimiento, $comprador_empresa, $comprador_telefono, $comprador_direccion, $vendedor_nombre, $vendedor_apellido, $vendedor_cedula_rif, $vendedor_correo, $vendedor_fecha_nacimiento, $vendedor_empresa, $vendedor_telefono, $vendedor_direccion, $tipo_de_compra, $nombre_producto, $cantidad_comprada, $precio_unitario_micoin, $monto_bruto_micoin, $ranking, $porc_comision, $monto_comision, $monto_neto, $fh_pagado, $fh_entregado, $fh_transaccion_abandonada, $fh_evaluacion, $evaluacion_puntos, $evaluacion_comentario, $estatus){//CREA VERIFICANDO DUPLICADOS
	$fecha_ii=explode(" ", $fh_pagado);
	$consulta="SELECT * FROM `mc_control_de_transacciones_micoin` WHERE `COMPRADOR_CEDULA_RIF`='$comprador_cedula_rif' AND `VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif' AND `CANTIDAD_COMPRADA`='$cantidad_comprada' AND `NOMBRE_PRODUCTO`='$nombre_producto' AND `FH_PAGADO` LIKE '%" . $fecha_ii[0] . "%'";
	$resultado=mysqli_query($conexion,$consulta);
	if(($fila=mysqli_fetch_array($resultado))==true){
		return false;
	}else{
		$comprador_fecha_nacimiento=$comprador_fecha_nacimiento==''?'00-00-00 00:00:00':$comprador_fecha_nacimiento;
		$vendedor_fecha_nacimiento=$vendedor_fecha_nacimiento==''?'00-00-00 00:00:00':$vendedor_fecha_nacimiento;
		$fh_pagado=$fh_pagado==''?'00-00-00 00:00:00':$fh_pagado;
		$fh_entregado=$fh_entregado==''?'00-00-00 00:00:00':$fh_entregado;
		$fh_transaccion_abandonada=$fh_transaccion_abandonada==''?'00-00-00 00:00:00':$fh_transaccion_abandonada;
		$fh_evaluacion=$fh_evaluacion==''?'00-00-00 00:00:00':$fh_evaluacion;
		$consulta="INSERT INTO `mc_control_de_transacciones_micoin`(`COMPRADOR_NOMBRE`, `COMPRADOR_APELLIDO`, `COMPRADOR_CEDULA_RIF`, `COMPRADOR_CORREO`, `COMPRADOR_FECHA_NACIMIENTO`, `COMPRADOR_EMPRESA`, `COMPRADOR_TELEFONO`, `COMPRADOR_DIRECCION`, `VENDEDOR_NOMBRE`, `VENDEDOR_APELLIDO`, `VENDEDOR_CEDULA_RIF`, `VENDEDOR_CORREO`, `VENDEDOR_FECHA_NACIMIENTO`, `VENDEDOR_EMPRESA`, `VENDEDOR_TELEFONO`, `VENDEDOR_DIRECCION`, `TIPO_DE_COMPRA`, `NOMBRE_PRODUCTO`, `CANTIDAD_COMPRADA`, `PRECIO_UNITARIO_MICOIN`, `MONTO_BRUTO_MICOIN`, `RANKING`, `PORC_COMISION`, `MONTO_COMISION`, `MONTO_NETO`, `FH_PAGADO`, `FH_ENTREGADO`, `FH_TRANSACCION_ABANDONADA`, `FH_EVALUACION`, `EVALUACION_PUNTOS`, `EVALUACION_COMENTARIO`, `ESTATUS`) VALUES ('$comprador_nombre', '$comprador_apellido', '$comprador_cedula_rif', '$comprador_correo', '$comprador_fecha_nacimiento', '$comprador_empresa', '$comprador_telefono', '$comprador_direccion', '$vendedor_nombre', '$vendedor_apellido', '$vendedor_cedula_rif', '$vendedor_correo', '$vendedor_fecha_nacimiento', '$vendedor_empresa', '$vendedor_telefono', '$vendedor_direccion', '$tipo_de_compra', '$nombre_producto', '$cantidad_comprada', '$precio_unitario_micoin', '$monto_bruto_micoin', '$ranking', '$porc_comision', '$monto_comision', '$monto_neto', '$fh_pagado', '$fh_entregado', '$fh_transaccion_abandonada', '$fh_evaluacion', '$evaluacion_puntos', '$evaluacion_comentario', '$estatus')";
		$resultados=mysqli_query($conexion,$consulta);
		return true;
	}
}
function M_control_de_transacciones_cuenta($conexion){
	$consulta="SELECT SUM(CANTIDAD_COMPRADA) AS CANTIDAD, SUM(MONTO_BRUTO_MICOIN) AS MONTO FROM `mc_control_de_transacciones_micoin`";
	$resultados=mysqli_query($conexion,$consulta);
	$datos['CANTIDAD']=0;
	$datos['MONTO']=0;
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['CANTIDAD']=$fila['CANTIDAD'];
		$datos['MONTO']=$fila['MONTO'];
	}
	return $datos;
}
function M_c_d_t_cuenta_ventas_por_usuario($conexion, $cedula_vendedor){
	$consulta="SELECT COUNT(`ID_TRANSACCION`) AS CANTIDAD FROM `mc_control_de_transacciones_micoin` WHERE `VENDEDOR_CEDULA_RIF`='$cedula_vendedor'";
	$resultados=mysqli_query($conexion,$consulta);
	$datos['CANTIDAD']=0;
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['CANTIDAD']=$fila['CANTIDAD'];
	}
	return $datos;
}
function M_control_de_transacciones_compras_en_micoin_R($conexion, $f_1, $d_1, $f_2, $d_2, $f_3, $d_3){
	//ESTA FUNCION PERMITE LEER HASTA CON 3 FILTROS EJEMPLO: $f_1='NOMBRE DE LA COLUMNA' $d_1='DATO'
	$sql_f_1=($f_1=="" and $d_1=="") ? "" : "AND `mc_control_de_transacciones_micoin`.`$f_1`='$d_1'";
	$sql_f_2=($f_2=="" and $d_2=="") ? "" : "AND `mc_control_de_transacciones_micoin`.`$f_2`='$d_2'";
	$sql_f_3=($f_3=="" and $d_3=="") ? "" : "AND `mc_control_de_transacciones_micoin`.`$f_3`='$d_3'";
	$consulta="SELECT * FROM `mc_control_de_transacciones_micoin` WHERE 1 $sql_f_1 $sql_f_2 $sql_f_3 ORDER BY ID_TRANSACCION DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_TRANSACCION'][$i]='';
	$datos['COMPRADOR_NOMBRE'][$i]='';
	$datos['COMPRADOR_APELLIDO'][$i]='';
	$datos['COMPRADOR_CEDULA_RIF'][$i]='';
	$datos['COMPRADOR_CORREO'][$i]='';
	$datos['COMPRADOR_FECHA_NACIMIENTO'][$i]='';
	$datos['COMPRADOR_EMPRESA'][$i]='';
	$datos['COMPRADOR_TELEFONO'][$i]='';
	$datos['COMPRADOR_DIRECCION'][$i]='';
	$datos['VENDEDOR_NOMBRE'][$i]='';
	$datos['VENDEDOR_APELLIDO'][$i]='';
	$datos['VENDEDOR_CEDULA_RIF'][$i]='';
	$datos['VENDEDOR_CORREO'][$i]='';
	$datos['VENDEDOR_FECHA_NACIMIENTO'][$i]='';
	$datos['VENDEDOR_EMPRESA'][$i]='';
	$datos['VENDEDOR_TELEFONO'][$i]='';
	$datos['VENDEDOR_DIRECCION'][$i]='';
	$datos['TIPO_DE_COMPRA'][$i]='';
	$datos['CODIGO_DE_SEGURIDAD'][$i]='';
	$datos['NOMBRE_PRODUCTO'][$i]='';
	$datos['CANTIDAD_COMPRADA'][$i]='';
	$datos['PRECIO_UNITARIO_MICOIN'][$i]='';
	$datos['MONTO_BRUTO_MICOIN'][$i]='';
	$datos['RANKING'][$i]='';
	$datos['PORC_COMISION'][$i]='';
	$datos['MONTO_COMISION'][$i]='';
	$datos['MONTO_NETO'][$i]='';
	$datos['FH_PAGADO'][$i]='';
	$datos['FH_ENTREGADO'][$i]='';
	$datos['FH_TRANSACCION_ABANDONADA'][$i]='';
	$datos['FH_EVALUACION'][$i]='';
	$datos['EVALUACION_PUNTOS'][$i]='';
	$datos['EVALUACION_COMENTARIO'][$i]='';
	$datos['ESTATUS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_TRANSACCION'][$i]=$fila['ID_TRANSACCION'];
		$datos['COMPRADOR_NOMBRE'][$i]=$fila['COMPRADOR_NOMBRE'];
		$datos['COMPRADOR_APELLIDO'][$i]=$fila['COMPRADOR_APELLIDO'];
		$datos['COMPRADOR_CEDULA_RIF'][$i]=$fila['COMPRADOR_CEDULA_RIF'];
		$datos['COMPRADOR_CORREO'][$i]=$fila['COMPRADOR_CORREO'];
		$datos['COMPRADOR_FECHA_NACIMIENTO'][$i]=$fila['COMPRADOR_FECHA_NACIMIENTO'];
		$datos['COMPRADOR_EMPRESA'][$i]=$fila['COMPRADOR_EMPRESA'];
		$datos['COMPRADOR_TELEFONO'][$i]=$fila['COMPRADOR_TELEFONO'];
		$datos['COMPRADOR_DIRECCION'][$i]=$fila['COMPRADOR_DIRECCION'];
		$datos['VENDEDOR_NOMBRE'][$i]=$fila['VENDEDOR_NOMBRE'];
		$datos['VENDEDOR_APELLIDO'][$i]=$fila['VENDEDOR_APELLIDO'];
		$datos['VENDEDOR_CEDULA_RIF'][$i]=$fila['VENDEDOR_CEDULA_RIF'];
		$datos['VENDEDOR_CORREO'][$i]=$fila['VENDEDOR_CORREO'];
		$datos['VENDEDOR_FECHA_NACIMIENTO'][$i]=$fila['VENDEDOR_FECHA_NACIMIENTO'];
		$datos['VENDEDOR_EMPRESA'][$i]=$fila['VENDEDOR_EMPRESA'];
		$datos['VENDEDOR_TELEFONO'][$i]=$fila['VENDEDOR_TELEFONO'];
		$datos['VENDEDOR_DIRECCION'][$i]=$fila['VENDEDOR_DIRECCION'];
		$datos['TIPO_DE_COMPRA'][$i]=$fila['TIPO_DE_COMPRA'];
		$datos['CODIGO_DE_SEGURIDAD'][$i]=$fila['CODIGO_DE_SEGURIDAD'];
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$datos['CANTIDAD_COMPRADA'][$i]=$fila['CANTIDAD_COMPRADA'];
		$datos['PRECIO_UNITARIO_MICOIN'][$i]=$fila['PRECIO_UNITARIO_MICOIN'];
		$datos['MONTO_BRUTO_MICOIN'][$i]=$fila['MONTO_BRUTO_MICOIN'];
		$datos['RANKING'][$i]=$fila['RANKING'];
		$datos['PORC_COMISION'][$i]=$fila['PORC_COMISION'];
		$datos['MONTO_COMISION'][$i]=$fila['MONTO_COMISION'];
		$datos['MONTO_NETO'][$i]=$fila['MONTO_NETO'];
		$datos['FH_PAGADO'][$i]=$fila['FH_PAGADO'];
		$datos['FH_ENTREGADO'][$i]=$fila['FH_ENTREGADO'];
		$datos['FH_TRANSACCION_ABANDONADA'][$i]=$fila['FH_TRANSACCION_ABANDONADA'];
		$datos['FH_EVALUACION'][$i]=$fila['FH_EVALUACION'];
		$datos['EVALUACION_PUNTOS'][$i]=$fila['EVALUACION_PUNTOS'];
		$datos['EVALUACION_COMENTARIO'][$i]=$fila['EVALUACION_COMENTARIO'];
		$datos['ESTATUS'][$i]=$fila['ESTATUS'];
		$i=$i+1;
	}
	return $datos;
}
function M_control_de_transacciones_micoin_U_id($conexion, $id_transaccion, $comprador_nombre, $comprador_apellido, $comprador_cedula_rif, $comprador_correo, $comprador_fecha_nacimiento, $comprador_empresa, $comprador_telefono, $comprador_direccion, $vendedor_nombre, $vendedor_apellido, $vendedor_cedula_rif, $vendedor_correo, $vendedor_fecha_nacimiento, $vendedor_empresa, $vendedor_telefono, $vendedor_direccion, $tipo_de_compra, $nombre_producto, $cantidad_comprada, $precio_unitario_micoin, $monto_bruto_micoin, $ranking, $porc_comision, $monto_comision, $monto_neto, $fh_pagado, $fh_entregado, $fh_transaccion_abandonada, $fh_evaluacion, $evaluacion_puntos, $evaluacion_comentario, $estatus){//ACTUALIZA TODO
	$comprador_fecha_nacimiento=$comprador_fecha_nacimiento==''?'00-00-00 00:00:00':$comprador_fecha_nacimiento;
	$vendedor_fecha_nacimiento=$vendedor_fecha_nacimiento==''?'00-00-00 00:00:00':$vendedor_fecha_nacimiento;
	$fh_pagado=$fh_pagado==''?'00-00-00 00:00:00':$fh_pagado;
	$fh_entregado=$fh_entregado==''?'00-00-00 00:00:00':$fh_entregado;
	$fh_transaccion_abandonada=$fh_transaccion_abandonada==''?'00-00-00 00:00:00':$fh_transaccion_abandonada;
	$fh_evaluacion=$fh_evaluacion==''?'00-00-00 00:00:00':$fh_evaluacion;
	$consulta="UPDATE `mc_control_de_transacciones_micoin` SET 
	`COMPRADOR_NOMBRE`='$comprador_nombre', 
	`COMPRADOR_APELLIDO`='$comprador_apellido', 
	`COMPRADOR_CEDULA_RIF`='$comprador_cedula_rif', 
	`COMPRADOR_CORREO`='$comprador_correo', 
	`COMPRADOR_FECHA_NACIMIENTO`='$comprador_fecha_nacimiento', 
	`COMPRADOR_EMPRESA`='$comprador_empresa', 
	`COMPRADOR_TELEFONO`='$comprador_telefono', 
	`COMPRADOR_DIRECCION`='$comprador_direccion', 
	`VENDEDOR_NOMBRE`='$vendedor_nombre', 
	`VENDEDOR_APELLIDO`='$vendedor_apellido', 
	`VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif', 
	`VENDEDOR_CORREO`='$vendedor_correo', 
	`VENDEDOR_FECHA_NACIMIENTO`='$vendedor_fecha_nacimiento', 
	`VENDEDOR_EMPRESA`='$vendedor_empresa', 
	`VENDEDOR_TELEFONO`='$vendedor_telefono', 
	`VENDEDOR_DIRECCION`='$vendedor_direccion', 
	`TIPO_DE_COMPRA`='$tipo_de_compra', 
	`NOMBRE_PRODUCTO`='$nombre_producto', 
	`CANTIDAD_COMPRADA`='$cantidad_comprada', 
	`PRECIO_UNITARIO_MICOIN`='$precio_unitario_micoin', 
	`MONTO_BRUTO_MICOIN`='$monto_bruto_micoin', 
	`RANKING`='$ranking', 
	`PORC_COMISION`='$porc_comision', 
	`MONTO_COMISION`='$monto_comision', 
	`MONTO_NETO`='$monto_neto', 
	`FH_PAGADO`='$fh_pagado', 
	`FH_ENTREGADO`='$fh_entregado', 
	`FH_TRANSACCION_ABANDONADA`='$fh_transaccion_abandonada', 
	`FH_EVALUACION`='$fh_evaluacion', 
	`EVALUACION_PUNTOS`='$evaluacion_puntos', 
	`EVALUACION_COMENTARIO`='$evaluacion_comentario', 
	`ESTATUS`='$estatus' 
	WHERE `ID_TRANSACCION`='$id_transaccion'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_control_de_transacciones_micoin_U_id_y_estatus($conexion, $id_transaccion, $estatus, $fecha_entregado){//ACTUALIZA SOLO EL ESTATUS DADO UN ID
	$fh_entregado=$fh_entregado==''?'00-00-00 00:00:00':$fh_entregado;
	$consulta="UPDATE `mc_control_de_transacciones_micoin` SET 
	`FH_ENTREGADO`='$fecha_entregado', 
	`ESTATUS`='$estatus' 
	WHERE `ID_TRANSACCION`='$id_transaccion'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_control_de_transacciones_micoin_D_id($conexion, $id_transaccion){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_control_de_transacciones_micoin` WHERE `ID_TRANSACCION`='$id_transaccion'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_reputacion_por_usuario($conexion, $cedula_rif){
	//DEVUELVE EL PROMEDIO DEL PUNTAJE DADO UN USUARIO
	$datos['VENDEDOR_CEDULA_RIF'][0]='';
	$datos['PUNTOS'][0]='';
	$total_puntos=0;
	$promedio_puntos=0;
	$consulta="SELECT `VENDEDOR_CEDULA_RIF`, `CODIGO_DE_SEGURIDAD`, AVG(`EVALUACION_PUNTOS`) AS PUNTOS FROM `mc_control_de_transacciones_micoin` WHERE `VENDEDOR_CEDULA_RIF`='$cedula_rif' AND `FH_EVALUACION`<>'0000-00-00 00:00:00' GROUP BY `VENDEDOR_CEDULA_RIF`, `CODIGO_DE_SEGURIDAD`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$total_puntos=$total_puntos+$fila['PUNTOS'];
		$i=$i+1;
	}
	if($i==0){
		$promedio_puntos=0;
	}else{
		$promedio_puntos=$total_puntos/$i;
	}
	$datos['VENDEDOR_CEDULA_RIF'][0]=$cedula_rif;
	$datos['PUNTOS'][0]=$promedio_puntos;
	return $datos;
}
function M_reputacion_por_usuario_detalle($conexion, $cedula_rif){
	//DEVUELVE EL DETALLE DEL PUNTAJE DADO UN USUARIO
	$consulta="SELECT `VENDEDOR_CEDULA_RIF`, `CODIGO_DE_SEGURIDAD`, `COMPRADOR_NOMBRE`, `COMPRADOR_APELLIDO`, `FH_EVALUACION`, `EVALUACION_COMENTARIO`, AVG(`EVALUACION_PUNTOS`) AS EVALUACION_PUNTOS FROM `mc_control_de_transacciones_micoin` WHERE `VENDEDOR_CEDULA_RIF`='$cedula_rif' AND `FH_EVALUACION`<>'0000-00-00 00:00:00' GROUP BY `VENDEDOR_CEDULA_RIF`, `CODIGO_DE_SEGURIDAD`, `COMPRADOR_NOMBRE`, `COMPRADOR_APELLIDO`, `FH_EVALUACION`, `EVALUACION_COMENTARIO` ORDER BY `ID_TRANSACCION` DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['COMPRADOR_NOMBRE'][$i]='';
	$datos['COMPRADOR_APELLIDO'][$i]='';
	$datos['FH_EVALUACION'][$i]='';
	$datos['EVALUACION_PUNTOS'][$i]='';
	$datos['EVALUACION_COMENTARIO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['COMPRADOR_NOMBRE'][$i]=$fila['COMPRADOR_NOMBRE'];
		$datos['COMPRADOR_APELLIDO'][$i]=$fila['COMPRADOR_APELLIDO'];
		$datos['FH_EVALUACION'][$i]=$fila['FH_EVALUACION'];
		$datos['EVALUACION_PUNTOS'][$i]=$fila['EVALUACION_PUNTOS'];
		$datos['EVALUACION_COMENTARIO'][$i]=$fila['EVALUACION_COMENTARIO'];
		$i=$i+1;
	}
	return $datos;
}
function M_control_de_transacciones_obtener_id($conexion, $comprador_cedula_rif, $vendedor_cedula_rif, $cantidad_comprada, $nombre_producto, $fh_pagado){
	$consulta="SELECT `ID_TRANSACCION` FROM `mc_control_de_transacciones_micoin` WHERE `COMPRADOR_CEDULA_RIF`='$comprador_cedula_rif' AND `VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif' AND `CANTIDAD_COMPRADA`='$cantidad_comprada' AND `NOMBRE_PRODUCTO`='$nombre_producto' AND `FH_PAGADO`='$fh_pagado'";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_TRANSACCION'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_TRANSACCION'][$i]=$fila['ID_TRANSACCION'];
		$i=$i+1;
	}
	return $datos;
}
function M_control_de_transacciones_micoin_U_evaluacion($conexion, $id_transaccion, $fh_evaluacion, $evaluacion_puntos, $evaluacion_comentario){//ACTUALIZA TODO
	$fh_evaluacion=$fh_evaluacion==''?'00-00-00 00:00:00':$fh_evaluacion;
	$consulta="UPDATE `mc_control_de_transacciones_micoin` SET 
	`FH_EVALUACION`='$fh_evaluacion', 
	`EVALUACION_PUNTOS`='$evaluacion_puntos', 
	`EVALUACION_COMENTARIO`='$evaluacion_comentario' 
	WHERE `ID_TRANSACCION`='$id_transaccion'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_control_de_transacciones_micoin_rechazar_compra_cod_seg($conexion, $cod_seg){//abandono
	$fecha_abandono=date("Y-m-d h:m:s");
	$consulta="UPDATE `mc_control_de_transacciones_micoin` SET 
	`FH_TRANSACCION_ABANDONADA`='$fecha_abandono', 
	`ESTATUS`='ABANDONADO' 
	WHERE `CODIGO_DE_SEGURIDAD`='$cod_seg'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_control_de_transacciones_agrupa_x_codigo_seguridad($conexion, $f_1, $d_1, $f_2, $d_2, $f_3, $d_3){
	//ESTA FUNCION PERMITE LEER HASTA CON 3 FILTROS EJEMPLO: $f_1='NOMBRE DE LA COLUMNA' $d_1='DATO'
	$sql_f_1=($f_1=="" and $d_1=="") ? "" : "AND `mc_control_de_transacciones_micoin`.`$f_1`='$d_1'";
	$sql_f_2=($f_2=="" and $d_2=="") ? "" : "AND `mc_control_de_transacciones_micoin`.`$f_2`='$d_2'";
	$sql_f_3=($f_3=="" and $d_3=="") ? "" : "AND `mc_control_de_transacciones_micoin`.`$f_3`='$d_3'";
	$consulta="SELECT `CODIGO_DE_SEGURIDAD` FROM `mc_control_de_transacciones_micoin` WHERE 1 $sql_f_1 $sql_f_2 $sql_f_3 GROUP BY `CODIGO_DE_SEGURIDAD` ORDER BY `ID_TRANSACCION` DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['CODIGO_DE_SEGURIDAD'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['CODIGO_DE_SEGURIDAD'][$i]=$fila['CODIGO_DE_SEGURIDAD'];
		$i=$i+1;
	}
	return $datos;
}
function M_control_de_transacciones_agrupa_x_codigo_seguridad_sin_evaluar($conexion, $f_1, $d_1, $f_2, $d_2, $f_3, $d_3){
	//ESTA FUNCION PERMITE LEER HASTA CON 3 FILTROS EJEMPLO: $f_1='NOMBRE DE LA COLUMNA' $d_1='DATO'
	$sql_f_1=($f_1=="" and $d_1=="") ? "" : "AND `mc_control_de_transacciones_micoin`.`$f_1`='$d_1'";
	$sql_f_2=($f_2=="" and $d_2=="") ? "" : "AND `mc_control_de_transacciones_micoin`.`$f_2`='$d_2'";
	$sql_f_3=($f_3=="" and $d_3=="") ? "" : "AND `mc_control_de_transacciones_micoin`.`$f_3`='$d_3'";
	$consulta="SELECT `CODIGO_DE_SEGURIDAD` FROM `mc_control_de_transacciones_micoin` WHERE 1 $sql_f_1 $sql_f_2 $sql_f_3 AND `EVALUACION_PUNTOS`<'0.5' GROUP BY `CODIGO_DE_SEGURIDAD` ORDER BY `ID_TRANSACCION` DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['CODIGO_DE_SEGURIDAD'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['CODIGO_DE_SEGURIDAD'][$i]=$fila['CODIGO_DE_SEGURIDAD'];
		$i=$i+1;
	}
	return $datos;
}
?>