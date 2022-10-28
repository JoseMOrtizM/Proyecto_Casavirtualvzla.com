<?php 
function M_ciudades_C($conexion, $estado, $ciudad){//CREA VERIFICANDO DUPLICADOS
	$consulta="SELECT * FROM `mc_ciudades` WHERE `ESTADO`='$estado' AND `CIUDAD`='$ciudad'";
	$resultado=mysqli_query($conexion,$consulta);
	if(($fila=mysqli_fetch_array($resultado))==true){
		return false;
	}else{
		$consulta="INSERT INTO `mc_ciudades`(`ESTADO`, `CIUDAD`) VALUES ('$estado', '$ciudad')";
		$resultados=mysqli_query($conexion,$consulta);
		return true;
	}
}
function M_ciudades_R_todo($conexion){//LEE TODO
	$consulta="SELECT * FROM `mc_ciudades`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_CIUDAD'][$i]='';
	$datos['ESTADO'][$i]='';
	$datos['CIUDAD'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_CIUDAD'][$i]=$fila['ID_CIUDAD'];
		$datos['ESTADO'][$i]=$fila['ESTADO'];
		$datos['CIUDAD'][$i]=$fila['CIUDAD'];
		$i=$i+1;
	}
	return $datos;
}
function M_ciudades_R_id($conexion, $id){//LEE DADO EL ID
	$consulta="SELECT * FROM `mc_ciudades` WHERE `ID_CIUDAD`='$id'";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_CIUDAD'][$i]='';
	$datos['ESTADO'][$i]='';
	$datos['CIUDAD'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_CIUDAD'][$i]=$fila['ID_CIUDAD'];
		$datos['ESTADO'][$i]=$fila['ESTADO'];
		$datos['CIUDAD'][$i]=$fila['CIUDAD'];
		$i=$i+1;
	}
	return $datos;
}
function M_ciudades_U_id($conexion, $id, $estado, $ciudad){//MODIFICA TODOS LOS DATOS
	$consulta="UPDATE `mc_ciudades` SET `ESTADO`='$estado',`CIUDAD`='$ciudad' WHERE `ID_CIUDAD`='$id'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_ciudades_D_id($conexion, $id){//BORRA DADO EL ID_CIUDAD
	$consulta="DELETE FROM `mc_ciudades` WHERE `ID_CIUDAD`='$id'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_agrupa_estados($conexion){//DA LOS ESTADOS RESUMIDOS
	$consulta="SELECT `ESTADO` FROM `mc_ciudades` WHERE 1 GROUP BY `ESTADO` ORDER BY `ESTADO` ASC ";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos[0]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos[$i]=$fila['ESTADO'];
		$i=$i+1;
	}
	return $datos;
}
function M_agrupa_ciudad($conexion, $estado){//DA LAS CIUDADES PARA UN ESTADO
	$consulta="SELECT `ID_CIUDAD`, `CIUDAD` FROM `mc_ciudades` WHERE `ESTADO`='$estado' GROUP BY `CIUDAD` ORDER BY `CIUDAD` ASC";
	$resultados=mysqli_query($conexion,$consulta);
	$datos[0]="";
	$i=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_CIUDAD'][$i]=$fila['ID_CIUDAD'];
		$datos['CIUDAD'][$i]=$fila['CIUDAD'];
		$i=$i+1;
	}
	return $datos;
}
?>