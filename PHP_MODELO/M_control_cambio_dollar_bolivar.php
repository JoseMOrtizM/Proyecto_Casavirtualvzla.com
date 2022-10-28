<?php 
function M_control_cambio_dollar_bolivar_C($conexion, $nombre, $apellido, $cedula_rif, $telefono, $direccion, $fh_registro, $tipo, $dollares, $bolivares, $descripcion_compra_venta, $observacion){//CREA VERIFICANDO DUPLICADOS
	$fecha_ii=explode(" ", $fh_registro);
	$consulta="SELECT * FROM `mc_control_cambio_dollar_bolivar` WHERE `TIPO`='$tipo' AND `DOLLARES`='$dollares' AND `BOLIVARES`='$bolivares' AND `CEDULA_RIF`='$cedula_rif' AND `FH_REGISTRO` LIKE '%" . $fecha_ii[0] . "%'";
	$resultado=mysqli_query($conexion,$consulta);
	if(($fila=mysqli_fetch_array($resultado))==true){
		return false;
	}else{
		$fh_registro=$fh_registro==''?'00-00-00 00:00:00':$fh_registro;
		$consulta="INSERT INTO `mc_control_cambio_dollar_bolivar`(`NOMBRE`, `APELLIDO`, `CEDULA_RIF`, `TELEFONO`, `DIRECCION`, `FH_REGISTRO`, `TIPO`, `DOLLARES`, `BOLIVARES`, `DESCRIPCION_COMPRA_VENTA`, `OBSERVACION`) VALUES ('$nombre','$apellido','$cedula_rif','$telefono','$direccion','$fh_registro','$tipo','$dollares','$bolivares','$descripcion_compra_venta','$observacion')";
		$resultados=mysqli_query($conexion,$consulta);
		return true;
	}
}
function M_control_cambio_dollar_bolivar_R($conexion, $f_1, $d_1, $f_2, $d_2, $f_3, $d_3){
	//ESTA FUNCION PERMITE LEER HASTA CON 3 FILTROS EJEMPLO: $f_1='NOMBRE DE LA COLUMNA' $d_1='DATO'
	$sql_f_1=($f_1=="" and $d_1=="") ? "" : "AND `mc_control_cambio_dollar_bolivar`.`$f_1`='$d_1'";
	$sql_f_2=($f_2=="" and $d_2=="") ? "" : "AND `mc_control_cambio_dollar_bolivar`.`$f_2`='$d_2'";
	$sql_f_3=($f_3=="" and $d_3=="") ? "" : "AND `mc_control_cambio_dollar_bolivar`.`$f_3`='$d_3'";
	$consulta="SELECT * FROM `mc_control_cambio_dollar_bolivar` WHERE 1 $sql_f_1 $sql_f_2 $sql_f_3 ORDER BY FH_REGISTRO DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_CV_DOLLAR'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['TELEFONO'][$i]='';
	$datos['DIRECCION'][$i]='';
	$datos['FH_REGISTRO'][$i]='';
	$datos['TIPO'][$i]='';
	$datos['DOLLARES'][$i]='';
	$datos['BOLIVARES'][$i]='';
	$datos['DESCRIPCION_COMPRA_VENTA'][$i]='';
	$datos['OBSERVACION'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_CV_DOLLAR'][$i]=$fila['ID_CV_DOLLAR'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['TELEFONO'][$i]=$fila['TELEFONO'];
		$datos['DIRECCION'][$i]=$fila['DIRECCION'];
		$datos['FH_REGISTRO'][$i]=$fila['FH_REGISTRO'];
		$datos['TIPO'][$i]=$fila['TIPO'];
		$datos['DOLLARES'][$i]=$fila['DOLLARES'];
		$datos['BOLIVARES'][$i]=$fila['BOLIVARES'];
		$datos['DESCRIPCION_COMPRA_VENTA'][$i]=$fila['DESCRIPCION_COMPRA_VENTA'];
		$datos['OBSERVACION'][$i]=$fila['OBSERVACION'];
		$i=$i+1;
	}
	return $datos;
}
function M_control_cambio_dollar_bolivar_R_periodo($conexion, $fecha_desde, $fecha_hasta){//LEE DADO UN INTERVALO DE FECHAS
	$consulta="SELECT * FROM `mc_control_cambio_dollar_bolivar` WHERE `FH_REGISTRO`>='$fecha_desde' AND `FH_REGISTRO`<='$fecha_hasta' ORDER BY `FH_REGISTRO` DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_CV_DOLLAR'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['TELEFONO'][$i]='';
	$datos['DIRECCION'][$i]='';
	$datos['FH_REGISTRO'][$i]='';
	$datos['TIPO'][$i]='';
	$datos['DOLLARES'][$i]='';
	$datos['BOLIVARES'][$i]='';
	$datos['DESCRIPCION_COMPRA_VENTA'][$i]='';
	$datos['OBSERVACION'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_CV_DOLLAR'][$i]=$fila['ID_CV_DOLLAR'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['TELEFONO'][$i]=$fila['TELEFONO'];
		$datos['DIRECCION'][$i]=$fila['DIRECCION'];
		$datos['FH_REGISTRO'][$i]=$fila['FH_REGISTRO'];
		$datos['TIPO'][$i]=$fila['TIPO'];
		$datos['DOLLARES'][$i]=$fila['DOLLARES'];
		$datos['BOLIVARES'][$i]=$fila['BOLIVARES'];
		$datos['DESCRIPCION_COMPRA_VENTA'][$i]=$fila['DESCRIPCION_COMPRA_VENTA'];
		$datos['OBSERVACION'][$i]=$fila['OBSERVACION'];
		$i=$i+1;
	}
	return $datos;
}
function M_control_cambio_dollar_bolivar_R_agrupa_clientes($conexion){//DEVUELVE LOS DATOS NECESARIOS PARA EL FORMULARIO DE COMPRA --VENTA DE DOLLARES DE LA SUBRUTINA "S_devuelve_datos_del_cliente.php"
	$consulta="SELECT `NOMBRE`, `APELLIDO`, `CEDULA_RIF`, `TELEFONO`, `DIRECCION` FROM `mc_control_cambio_dollar_bolivar` GROUP BY `CEDULA_RIF` ORDER BY `NOMBRE`, `APELLIDO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['TELEFONO'][$i]='';
	$datos['DIRECCION'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['TELEFONO'][$i]=$fila['TELEFONO'];
		$datos['DIRECCION'][$i]=$fila['DIRECCION'];
		$i=$i+1;
	}
	return $datos;
}
function M_control_cambio_dollar_bolivar_R_id_registro($conexion, $nombre, $apellido, $cedula_rif, $telefono, $direccion, $fh_registro, $tipo, $dollares, $bolivares, $descripcion, $observacion){
	$consulta="SELECT `ID_CV_DOLLAR` FROM `mc_control_cambio_dollar_bolivar` WHERE 1 
	AND `NOMBRE`='$nombre' 
	AND `APELLIDO`='$apellido' 
	AND `CEDULA_RIF`='$cedula_rif' 
	AND `TELEFONO`='$telefono' 
	AND `DIRECCION`='$direccion' 
	AND `FH_REGISTRO`='$fh_registro' 
	AND `TIPO`='$tipo' 
	AND `DOLLARES`='$dollares' 
	AND `BOLIVARES`='$bolivares' 
	AND `DESCRIPCION_COMPRA_VENTA`='$descripcion' 
	AND `OBSERVACION`='$observacion'";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_CV_DOLLAR'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_CV_DOLLAR'][$i]=$fila['ID_CV_DOLLAR'];
		$i=$i+1;
	}
	return $datos;
}
function M_control_cambio_dollar_bolivar_U_id($conexion, $id_cv_dollar, $nombre, $apellido, $cedula_rif, $telefono, $direccion, $fh_registro, $tipo, $dollares, $bolivares, $descripcion_compra_venta, $observacion){//MODIFICA TODOS LOS DATOS
	$fh_registro=$fh_registro==''?'00-00-00 00:00:00':$fh_registro;
	$consulta="UPDATE `mc_control_cambio_dollar_bolivar` SET 
	`NOMBRE`='$nombre', 
	`APELLIDO`='$apellido', 
	`CEDULA_RIF`='$cedula_rif', 
	`TELEFONO`='$telefono', 
	`DIRECCION`='$direccion', 
	`FH_REGISTRO`='$fh_registro', 
	`TIPO`='$tipo', 
	`DOLLARES`='$dollares', 
	`BOLIVARES`='$bolivares', 
	`DESCRIPCION_COMPRA_VENTA`='$descripcion_compra_venta', 
	`OBSERVACION`='$observacion' 
	WHERE `ID_CV_DOLLAR`='$id_cv_dollar'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_control_cambio_dollar_bolivar_D_id($conexion, $id_cv_dollar){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_control_cambio_dollar_bolivar` WHERE `ID_CV_DOLLAR`='$id_cv_dollar'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
?>