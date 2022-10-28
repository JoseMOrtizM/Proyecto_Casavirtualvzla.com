<?php 
function M_blog_interno_C($conexion, $nombre, $apellido, $cedula_rif, $correo, $fecha_nacimiento, $comentario, $fh_comentario, $respuesta, $fh_respuesta, $clicks, $pregunta_frecuente){//CREA VERIFICANDO DUPLICADOS
	$consulta="SELECT * FROM `mc_blog_interno` WHERE `CEDULA_RIF`='$cedula_rif' AND `COMENTARIO`='$comentario'";
	$resultados=mysqli_query($conexion,$consulta);
	if(($fila=mysqli_fetch_array($resultados))==true){
		return false;
	}else{
		$fecha_nacimiento=$fecha_nacimiento==''?'00-00-00 00:00:00':$fecha_nacimiento;
		$fh_comentario=$fh_comentario==''?'00-00-00 00:00:00':$fh_comentario;
		$fh_respuesta=$fh_respuesta==''?'00-00-00 00:00:00':$fh_respuesta;
		$consulta="INSERT INTO `mc_blog_interno`(`NOMBRE`, `APELLIDO`, `CEDULA_RIF`, `CORREO`, `FECHA_NACIMIENTO`, `COMENTARIO`, `FH_COMENTARIO`, `RESPUESTA`, `FH_RESPUESTA`, `CLICKS`, `PREGUNTA_FRECUENTE`) VALUES ('$nombre', '$apellido', '$cedula_rif', '$correo', '$fecha_nacimiento', '$comentario', '$fh_comentario', '$respuesta', '$fh_respuesta', '$clicks', '$pregunta_frecuente')";
		$resultados=mysqli_query($conexion,$consulta);
		return true;
	}
}
function M_blog_interno_R($conexion, $f_1, $d_1, $f_2, $d_2, $f_3, $d_3){
	//ESTA FUNCION PERMITE LEER HASTA CON 3 FILTROS EJEMPLO: $f_1='NOMBRE DE LA COLUMNA' $d_1='DATO'
	$sql_f_1=($f_1=="" and $d_1=="") ? "" : "AND `mc_blog_interno`.`$f_1`='$d_1'";
	$sql_f_2=($f_2=="" and $d_2=="") ? "" : "AND `mc_blog_interno`.`$f_2`='$d_2'";
	$sql_f_3=($f_3=="" and $d_3=="") ? "" : "AND `mc_blog_interno`.`$f_3`='$d_3'";
	$consulta="SELECT * FROM `mc_blog_interno` WHERE 1 $sql_f_1 $sql_f_2 $sql_f_3";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_COMENTARIO_INT'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['CORREO'][$i]='';
	$datos['FECHA_NACIMIENTO'][$i]='';
	$datos['COMENTARIO'][$i]='';
	$datos['FH_COMENTARIO'][$i]='';
	$datos['RESPUESTA'][$i]='';
	$datos['FH_RESPUESTA'][$i]='';
	$datos['CLICKS'][$i]='';
	$datos['PREGUNTA_FRECUENTE'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_COMENTARIO_INT'][$i]=$fila['ID_COMENTARIO_INT'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['CORREO'][$i]=$fila['CORREO'];
		$datos['FECHA_NACIMIENTO'][$i]=$fila['FECHA_NACIMIENTO'];
		$datos['COMENTARIO'][$i]=$fila['COMENTARIO'];
		$datos['FH_COMENTARIO'][$i]=$fila['FH_COMENTARIO'];
		$datos['RESPUESTA'][$i]=$fila['RESPUESTA'];
		$datos['FH_RESPUESTA'][$i]=$fila['FH_RESPUESTA'];
		$datos['CLICKS'][$i]=$fila['CLICKS'];
		$datos['PREGUNTA_FRECUENTE'][$i]=$fila['PREGUNTA_FRECUENTE'];
		$i=$i+1;
	}
	return $datos;
}
function M_blog_interno_U_id($conexion, $id_comentario_int, $nombre, $apellido, $cedula_rif, $correo, $fecha_nacimiento, $comentario, $fh_comentario, $respuesta, $fh_respuesta, $clicks, $pregunta_frecuente){//MODIFICA TODOS LOS DATOS
	$fecha_nacimiento=$fecha_nacimiento==''?'00-00-00 00:00:00':$fecha_nacimiento;
	$fh_comentario=$fh_comentario==''?'00-00-00 00:00:00':$fh_comentario;
	$fh_respuesta=$fh_respuesta==''?'00-00-00 00:00:00':$fh_respuesta;
	$consulta="UPDATE `mc_blog_interno` SET 
	`NOMBRE`='$nombre', 
	`APELLIDO`='$apellido', 
	`CEDULA_RIF`='$cedula_rif', 
	`CORREO`='$correo', 
	`FECHA_NACIMIENTO`='$fecha_nacimiento', 
	`COMENTARIO`= '$comentario', 
	`FH_COMENTARIO`= '$fh_comentario', 
	`RESPUESTA`='$respuesta', 
	`FH_RESPUESTA`='$fh_respuesta', 
	`CLICKS`='$clicks', 
	`PREGUNTA_FRECUENTE`='$pregunta_frecuente' 
	WHERE `ID_COMENTARIO_INT`='$id_comentario_int'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_blog_interno_D_id($conexion, $id_comentario_int){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_blog_interno` WHERE `ID_COMENTARIO_INT`='$id_comentario_int'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
?>