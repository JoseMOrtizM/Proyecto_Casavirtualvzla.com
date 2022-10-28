<?php 
function M_pregunta_vendedor_C($conexion, $id_quien_pregunta, $id_producto, $fh_pregunta, $pregunta, $respuesta, $revisado){//CREA VERIFICANDO DUPLICADOS
	$consulta="SELECT * FROM `mc_preguntas_al_vendedor` WHERE `PREGUNTA`='$pregunta' AND `ID_PRODUCTO`='$id_producto' AND `ID_QUIEN_PREGUNTA`='$id_quien_pregunta'";
	$resultado=mysqli_query($conexion,$consulta);
	if(($fila=mysqli_fetch_array($resultado))==true){
		return false;
	}else{
		$fh_pregunta=$fh_pregunta==''?'00-00-00 00:00:00':$fh_pregunta;
		$consulta="INSERT INTO `mc_preguntas_al_vendedor`(`ID_QUIEN_PREGUNTA`, `ID_PRODUCTO`, `FH_PREGUNTA`, `PREGUNTA`, `RESPUESTA`, `REVISADO`) VALUES ('$id_quien_pregunta', '$id_producto', '$fh_pregunta', '$pregunta', '$respuesta', '$revisado')";
		$resultados=mysqli_query($conexion,$consulta);
		return true;
	}
}
function M_pregunta_vendedor_R($conexion, $t_1, $f_1, $d_1, $t_2, $f_2, $d_2, $t_3, $f_3, $d_3){
	//ESTA FUNCION PERMITE LEER HASTA CON 3 FILTROS EJEMPLO: $t_1='NOMBRE DE LA TABLA' $f_1='NOMBRE DE LA COLUMNA' $d_1='DATO'
	$sql_f_1=($f_1=="" and $d_1=="") ? "" : "AND `$t_1`.`$f_1`='$d_1'";
	$sql_f_2=($f_2=="" and $d_2=="") ? "" : "AND `$t_2`.`$f_2`='$d_2'";
	$sql_f_3=($f_3=="" and $d_3=="") ? "" : "AND `$t_3`.`$f_3`='$d_3'";
	$consulta="SELECT 
	`mc_preguntas_al_vendedor`.`ID_PREGUNTAS_AL_VENDEDOR` AS ID_PREGUNTAS_AL_VENDEDOR, 
	`mc_preguntas_al_vendedor`.`ID_PRODUCTO` AS ID_PRODUCTO, 
	`mc_productos_y_servicios`.`NOMBRE_PRODUCTO` AS NOMBRE_PRODUCTO, 
	`mc_preguntas_al_vendedor`.`ID_QUIEN_PREGUNTA` AS ID_QUIEN_PREGUNTA, 
	`mc_usuarios`.`NOMBRE` AS PREGUNTA_NOMBRE, 
	`mc_usuarios`.`APELLIDO` AS PREGUNTA_APELLIDO, 
	`mc_usuarios`.`CEDULA_RIF` AS PREGUNTA_CEDULA_RIF, 
	`mc_usuarios`.`CORREO` AS PREGUNTA_CORREO, 
	`mc_usuarios`.`TELEFONO` AS PREGUNTA_TELEFONO, 
	`mc_usuarios`.`DIRECCION` AS PREGUNTA_DIRECCION, 
	`mc_preguntas_al_vendedor`.`FH_PREGUNTA` AS FH_PREGUNTA, 
	`mc_preguntas_al_vendedor`.`PREGUNTA` AS PREGUNTA, 
	`mc_productos_y_servicios`.`NOMBRE` AS RESPUESTA_NOMBRE, 
	`mc_productos_y_servicios`.`APELLIDO` AS RESPUESTA_APELLIDO, 
	`mc_productos_y_servicios`.`CEDULA_RIF` AS RESPUESTA_CEDULA_RIF, 
	`mc_productos_y_servicios`.`CORREO` AS RESPUESTA_CORREO, 
	`mc_productos_y_servicios`.`TELEFONO` AS RESPUESTA_TELEFONO, 
	`mc_productos_y_servicios`.`DIRECCION` AS RESPUESTA_DIRECCION, 
	`mc_preguntas_al_vendedor`.`RESPUESTA` AS RESPUESTA, 
	`mc_preguntas_al_vendedor`.`REVISADO` AS REVISADO 
	FROM `mc_preguntas_al_vendedor` 
	INNER JOIN `mc_usuarios` ON `mc_preguntas_al_vendedor`.`ID_QUIEN_PREGUNTA`=`mc_usuarios`.`ID_USUARIO` 
	INNER JOIN `mc_productos_y_servicios` ON `mc_preguntas_al_vendedor`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` 
	WHERE 1 $sql_f_1 $sql_f_2 $sql_f_3 ORDER BY `ID_PREGUNTAS_AL_VENDEDOR` DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_PREGUNTAS_AL_VENDEDOR'][$i]='';
	$datos['ID_PRODUCTO'][$i]=''; 
	$datos['NOMBRE_PRODUCTO'][$i]='';
	$datos['ID_QUIEN_PREGUNTA'][$i]='';
	$datos['PREGUNTA_NOMBRE'][$i]='';
	$datos['PREGUNTA_APELLIDO'][$i]='';
	$datos['PREGUNTA_CEDULA_RIF'][$i]='';
	$datos['PREGUNTA_CORREO'][$i]='';
	$datos['PREGUNTA_TELEFONO'][$i]='';
	$datos['PREGUNTA_DIRECCION'][$i]='';
	$datos['FH_PREGUNTA'][$i]='';
	$datos['PREGUNTA'][$i]='';
	$datos['RESPUESTA_NOMBRE'][$i]='';
	$datos['RESPUESTA_APELLIDO'][$i]='';
	$datos['RESPUESTA_CEDULA_RIF'][$i]='';
	$datos['RESPUESTA_CORREO'][$i]='';
	$datos['RESPUESTA_TELEFONO'][$i]='';
	$datos['RESPUESTA_DIRECCION'][$i]='';
	$datos['RESPUESTA'][$i]='';
	$datos['REVISADO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_PREGUNTAS_AL_VENDEDOR'][$i]=$fila['ID_PREGUNTAS_AL_VENDEDOR'];
		$datos['ID_PRODUCTO'][$i]=$fila['ID_PRODUCTO'];
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$datos['ID_QUIEN_PREGUNTA'][$i]=$fila['ID_QUIEN_PREGUNTA'];
		$datos['PREGUNTA_NOMBRE'][$i]=$fila['PREGUNTA_NOMBRE'];
		$datos['PREGUNTA_APELLIDO'][$i]=$fila['PREGUNTA_APELLIDO'];
		$datos['PREGUNTA_CEDULA_RIF'][$i]=$fila['PREGUNTA_CEDULA_RIF'];
		$datos['PREGUNTA_CORREO'][$i]=$fila['PREGUNTA_CORREO'];
		$datos['PREGUNTA_TELEFONO'][$i]=$fila['PREGUNTA_TELEFONO'];
		$datos['PREGUNTA_DIRECCION'][$i]=$fila['PREGUNTA_DIRECCION'];
		$datos['FH_PREGUNTA'][$i]=$fila['FH_PREGUNTA'];
		$datos['PREGUNTA'][$i]=$fila['PREGUNTA'];
		$datos['RESPUESTA_NOMBRE'][$i]=$fila['RESPUESTA_NOMBRE'];
		$datos['RESPUESTA_APELLIDO'][$i]=$fila['RESPUESTA_APELLIDO'];
		$datos['RESPUESTA_CEDULA_RIF'][$i]=$fila['RESPUESTA_CEDULA_RIF'];
		$datos['RESPUESTA_CORREO'][$i]=$fila['RESPUESTA_CORREO'];
		$datos['RESPUESTA_TELEFONO'][$i]=$fila['RESPUESTA_TELEFONO'];
		$datos['RESPUESTA_DIRECCION'][$i]=$fila['RESPUESTA_DIRECCION'];
		$datos['RESPUESTA'][$i]=$fila['RESPUESTA'];
		$datos['REVISADO'][$i]=$fila['REVISADO'];
		$i=$i+1;
	}
	return $datos;
}
function M_pregunta_vendedor_U_id($conexion, $id_preguntas_al_vendedor, $id_quien_pregunta, $id_producto, $fh_pregunta, $pregunta, $respuesta){//MODIFICA TODOS LOS DATOS
	$fh_pregunta=$fh_pregunta==''?'00-00-00 00:00:00':$fh_pregunta;
	$consulta="UPDATE `mc_preguntas_al_vendedor` SET 
	`ID_QUIEN_PREGUNTA`='$id_quien_pregunta', 
	`ID_PRODUCTO`='$id_producto', 
	`FH_PREGUNTA`='$fh_pregunta', 
	`PREGUNTA`='$pregunta', 
	`RESPUESTA`='$respuesta' 
	WHERE `ID_PREGUNTAS_AL_VENDEDOR`='$id_preguntas_al_vendedor'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_pregunta_vendedor_U_id_revisado($conexion, $id_preguntas_al_vendedor, $pregunta, $respuesta, $revisado){
	$consulta="UPDATE `mc_preguntas_al_vendedor` SET 
	`PREGUNTA`='$pregunta', 
	`RESPUESTA`='$respuesta', 
	`REVISADO`='$revisado' 
	WHERE `ID_PREGUNTAS_AL_VENDEDOR`='$id_preguntas_al_vendedor'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_pregunta_vendedor_D_id($conexion, $id){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_preguntas_al_vendedor` WHERE `ID_PREGUNTAS_AL_VENDEDOR`='$id'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_pregunta_vendedor_D_id_usuario($conexion, $id){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_preguntas_al_vendedor` WHERE `ID_QUIEN_PREGUNTA`='$id'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_pregunta_vendedor_D_id_producto($conexion, $id){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_preguntas_al_vendedor` WHERE `ID_PRODUCTO`='$id'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_pregunta_vendedor_D_id_usuario_y_producto($conexion, $id_quien_pregunta, $id_producto){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_preguntas_al_vendedor` WHERE `ID_QUIEN_PREGUNTA`='$id_quien_pregunta' AND `ID_PRODUCTO`='$id_producto'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
?>