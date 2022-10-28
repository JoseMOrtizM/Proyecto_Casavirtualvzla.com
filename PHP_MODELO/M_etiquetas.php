<?php 
function M_etiquetas_C($conexion, $nombre_etiqueta){//CREA VERIFICANDO DUPLICADOS
	$consulta="SELECT * FROM `mc_etiquetas` WHERE `NOMBRE_ETIQUETA`='$nombre_etiqueta'";
	$resultado=mysqli_query($conexion,$consulta);
	if(($fila=mysqli_fetch_array($resultado))==true){
		return false;
	}else{
		$consulta="INSERT INTO `mc_etiquetas`(`NOMBRE_ETIQUETA`) VALUES ('$nombre_etiqueta')";
		$resultados=mysqli_query($conexion,$consulta);
		return true;
	}
}
function M_etiquetas_R_todo($conexion){//LEE TODO
	$consulta="SELECT * FROM `mc_etiquetas`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_ETIQUETA'][$i]='';
	$datos['NOMBRE_ETIQUETA'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_ETIQUETA'][$i]=$fila['ID_ETIQUETA'];
		$datos['NOMBRE_ETIQUETA'][$i]=$fila['NOMBRE_ETIQUETA'];
		$i=$i+1;
	}
	return $datos;
}
function M_etiquetas_R_id($conexion, $id){//LEE DADO EL ID
	$consulta="SELECT * FROM `mc_etiquetas` WHERE `ID_ETIQUETA`='$id'";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_ETIQUETA'][$i]='';
	$datos['NOMBRE_ETIQUETA'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_ETIQUETA'][$i]=$fila['ID_ETIQUETA'];
		$datos['NOMBRE_ETIQUETA'][$i]=$fila['NOMBRE_ETIQUETA'];
		$i=$i+1;
	}
	return $datos;
}
function M_etiquetas_U_id($conexion, $id_etiqueta, $nombre_etiqueta){//MODIFICA TODOS LOS DATOS
	$consulta="UPDATE `mc_etiquetas` SET  `NOMBRE_ETIQUETA`='$nombre_etiqueta' WHERE `ID_ETIQUETA`='$id_etiqueta'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_etiquetas_D_id($conexion, $id_etiqueta){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_etiquetas` WHERE `ID_ETIQUETA`='$id_etiqueta'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_etiquetas_disponibles($conexion){//LEE TODO
	$consulta="SELECT `mc_etiquetas`.`NOMBRE_ETIQUETA` AS ETIQUETA FROM `mc_etiquetas` 
	INNER JOIN `mc_productos_y_servicios` ON 
	(`mc_etiquetas`.`NOMBRE_ETIQUETA`=`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_1` OR
	`mc_etiquetas`.`NOMBRE_ETIQUETA`=`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_2` OR
	`mc_etiquetas`.`NOMBRE_ETIQUETA`=`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_3` OR
	`mc_etiquetas`.`NOMBRE_ETIQUETA`=`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_4` OR
	`mc_etiquetas`.`NOMBRE_ETIQUETA`=`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_5`) 
	INNER JOIN `mc_usuarios` ON `mc_productos_y_servicios`.`CEDULA_RIF`=`mc_usuarios`.`CEDULA_RIF`
	WHERE 
	`mc_productos_y_servicios`.`CANTIDAD_DISPONIBLE`>'0' AND
	`mc_usuarios`.`ESTATUS`='ACTIVO' 
	GROUP BY ETIQUETA ORDER BY ETIQUETA";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ETIQUETA'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ETIQUETA'][$i]=$fila['ETIQUETA'];
		$i=$i+1;
	}
	return $datos;
}
?>