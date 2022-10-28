<?php 
function M_parroquia_C($conexion, $estado, $municipio, $parroquia){//CREA VERIF DUPLICADOS
	$consulta="SELECT * FROM `mc_parroquia` WHERE `ESTADO`='$estado' AND `MUNICIPIO`='$municipio' AND `PARROQUIA`='$parroquia'";
	$resultado=mysqli_query($conexion,$consulta);
	if(($fila=mysqli_fetch_array($resultado))==true){
		return false;
	}else{
		$consulta="INSERT INTO `mc_parroquia`(`ESTADO`, `MUNICIPIO`, `PARROQUIA`) VALUES ('$estado', '$municipio', '$parroquia')";
		$resultados=mysqli_query($conexion,$consulta);
		return true;
	}
}
function M_parroquia_R_todo($conexion){//LEE TODO
	$consulta="SELECT * FROM `mc_parroquia`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_PARROQUIA'][$i]='';
	$datos['ESTADO'][$i]='';
	$datos['MUNICIPIO'][$i]='';
	$datos['PARROQUIA'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_PARROQUIA'][$i]=$fila['ID_PARROQUIA'];
		$datos['ESTADO'][$i]=$fila['ESTADO'];
		$datos['MUNICIPIO'][$i]=$fila['MUNICIPIO'];
		$datos['PARROQUIA'][$i]=$fila['PARROQUIA'];
		$i=$i+1;
	}
	return $datos;
}
function M_parroquia_R_id($conexion, $id){//LEE DADO EL ID
	$consulta="SELECT * FROM `mc_parroquia` WHERE `ID_PARROQUIA`='$id'";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_PARROQUIA'][$i]='';
	$datos['ESTADO'][$i]='';
	$datos['MUNICIPIO'][$i]='';
	$datos['PARROQUIA'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_PARROQUIA'][$i]=$fila['ID_PARROQUIA'];
		$datos['ESTADO'][$i]=$fila['ESTADO'];
		$datos['MUNICIPIO'][$i]=$fila['MUNICIPIO'];
		$datos['PARROQUIA'][$i]=$fila['PARROQUIA'];
		$i=$i+1;
	}
	return $datos;
}
function M_parroquia_U_id($conexion, $id_parroquia, $estado, $municipio, $parroquia){//MODIFICA TODOS LOS DATOS
	$consulta="UPDATE `mc_parroquia` SET `ESTADO`= '$estado', `MUNICIPIO`='$municipio', `PARROQUIA`='$parroquia'	WHERE`ID_PARROQUIA`='$id_parroquia'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_parroquia_D_id($conexion, $id_parroquia){//BORRA DADO EL ID_PARROQUIA
	$consulta="DELETE FROM `mc_parroquia` WHERE `ID_PARROQUIA`='$id_parroquia'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_agrupa_municipio($conexion, $estado){//DA LAS MUNICIPIOS PARA UN ESTADO
	$consulta="SELECT `MUNICIPIO` FROM `mc_parroquia` WHERE `ESTADO`='$estado' GROUP BY `MUNICIPIO` ORDER BY `MUNICIPIO` ASC";
	$resultados=mysqli_query($conexion,$consulta);
	$datos[0]="";
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos[$i]=$fila['MUNICIPIO'];
		$i=$i+1;
	}
	return $datos;
}
function M_agrupa_parroquia($conexion, $municipio){//DA LAS PARROQUIAS PARA UN MUNICIPIO
	$consulta="SELECT `ID_PARROQUIA`, `PARROQUIA` FROM `mc_parroquia` WHERE `MUNICIPIO`='$municipio' GROUP BY `PARROQUIA` ORDER BY `PARROQUIA` ASC";
	$resultados=mysqli_query($conexion,$consulta);
	$datos[0]="";
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_PARROQUIA'][$i]=$fila['ID_PARROQUIA'];
		$datos['PARROQUIA'][$i]=$fila['PARROQUIA'];
		$i=$i+1;
	}
	return $datos;
}
?>