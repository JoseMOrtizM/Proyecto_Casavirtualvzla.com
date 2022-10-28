<?php 
function M_blog_externo_C($conexion, $visitante_ip, $visitante_nombre, $visitante_correo, $comentario, $fh_comentario, $respuesta, $fh_respuesta, $clicks, $pregunta_frecuente){//CREA VERIFICANDO DUPLICADOS
	$consulta="SELECT * FROM `mc_blog_externo` WHERE `VISITANTE_IP`='$visitante_ip' AND `VISITANTE_CORREO`='$visitante_correo' AND `COMENTARIO`='$comentario'";
	$resultado=mysqli_query($conexion,$consulta);
	if(($fila=mysqli_fetch_array($resultado))==true){
		return false;
	}else{
		$fh_comentario=$fh_comentario==''?'00-00-00 00:00:00':$fh_comentario;
		$fh_respuesta=$fh_respuesta==''?'00-00-00 00:00:00':$fh_respuesta;
		$consulta="INSERT INTO `mc_blog_externo`(`VISITANTE_IP`, `VISITANTE_NOMBRE`, `VISITANTE_CORREO`, `COMENTARIO`, `FH_COMENTARIO`, `RESPUESTA`, `FH_RESPUESTA`, `CLICKS`, `PREGUNTA_FRECUENTE`) VALUES ('$visitante_ip', '$visitante_nombre', '$visitante_correo', '$comentario', '$fh_comentario', '$respuesta', '$fh_respuesta', '$clicks', '$pregunta_frecuente')";
		$resultados=mysqli_query($conexion,$consulta);
		return true;
	}
}
function M_blog_externo_R($conexion, $f_1, $d_1, $f_2, $d_2, $f_3, $d_3){
	//ESTA FUNCION PERMITE LEER HASTA CON 3 FILTROS EJEMPLO: $f_1='NOMBRE DE LA COLUMNA' $d_1='DATO'
	$sql_f_1=($f_1=="" and $d_1=="") ? "" : "AND `mc_blog_externo`.`$f_1`='$d_1'";
	$sql_f_2=($f_2=="" and $d_2=="") ? "" : "AND `mc_blog_externo`.`$f_2`='$d_2'";
	$sql_f_3=($f_3=="" and $d_3=="") ? "" : "AND `mc_blog_externo`.`$f_3`='$d_3'";
	$consulta="SELECT * FROM `mc_blog_externo` WHERE 1 $sql_f_1 $sql_f_2 $sql_f_3";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_COMENTARIO_EXT'][$i]='';
	$datos['VISITANTE_IP'][$i]='';
	$datos['VISITANTE_NOMBRE'][$i]='';
	$datos['VISITANTE_CORREO'][$i]='';
	$datos['COMENTARIO'][$i]='';
	$datos['FH_COMENTARIO'][$i]='';
	$datos['RESPUESTA'][$i]='';
	$datos['FH_RESPUESTA'][$i]='';
	$datos['CLICKS'][$i]='';
	$datos['PREGUNTA_FRECUENTE'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_COMENTARIO_EXT'][$i]=$fila['ID_COMENTARIO_EXT'];
		$datos['VISITANTE_IP'][$i]=$fila['VISITANTE_IP'];
		$datos['VISITANTE_NOMBRE'][$i]=$fila['VISITANTE_NOMBRE'];
		$datos['VISITANTE_CORREO'][$i]=$fila['VISITANTE_CORREO'];
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
function M_blog_externo_U_id($conexion, $id_comentario_ext, $visitante_ip, $visitante_nombre, $visitante_correo, $comentario, $fh_comentario, $respuesta, $fh_respuesta, $clicks, $pregunta_frecuente){//MODIFICA TODOS LOS DATOS
	$fh_comentario=$fh_comentario==''?'00-00-00 00:00:00':$fh_comentario;
	$fh_respuesta=$fh_respuesta==''?'00-00-00 00:00:00':$fh_respuesta;
	$consulta="UPDATE `mc_blog_externo` SET 
	`VISITANTE_IP`='$visitante_ip', 
	`VISITANTE_NOMBRE`='$visitante_nombre', 
	`VISITANTE_CORREO`= '$visitante_correo', 
	`COMENTARIO`= '$comentario', 
	`FH_COMENTARIO`='$fh_comentario', 
	`RESPUESTA`= '$respuesta', 
	`FH_RESPUESTA`='$fh_respuesta', 
	`CLICKS`='$clicks', 
	`PREGUNTA_FRECUENTE`='$pregunta_frecuente' 
	WHERE `ID_COMENTARIO_EXT`='$id_comentario_ext'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_blog_externo_D_id($conexion, $id){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_blog_externo` WHERE `ID_COMENTARIO_EXT`='$id'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
?>