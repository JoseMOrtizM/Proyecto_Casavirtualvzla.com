<?php 
function M_categorias_C($conexion, $nombre_categoria){//CREA VERIFICANDO DUPLICADOS
	$consulta="SELECT * FROM `mc_categorias` WHERE `NOMBRE_CATEGORIA`='$nombre_categoria'";
	$resultado=mysqli_query($conexion,$consulta);
	if(($fila=mysqli_fetch_array($resultado))==true){
		return false;
	}else{
		$consulta="INSERT INTO `mc_categorias`(`NOMBRE_CATEGORIA`) VALUES ('$nombre_categoria')";
		$resultados=mysqli_query($conexion,$consulta);
		return true;
	}
}
function M_categorias_R_todo($conexion){//LEE TODO
	$consulta="SELECT * FROM `mc_categorias` ORDER BY NOMBRE_CATEGORIA";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_CATEGORIA'][$i]='';
	$datos['NOMBRE_CATEGORIA'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_CATEGORIA'][$i]=$fila['ID_CATEGORIA'];
		$datos['NOMBRE_CATEGORIA'][$i]=$fila['NOMBRE_CATEGORIA'];
		$i=$i+1;
	}
	return $datos;
}
function M_categorias_R_id($conexion, $id){//LEE DADO EL ID
	$consulta="SELECT * FROM `mc_categorias` WHERE `ID_CATEGORIA`='$id'";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_CATEGORIA'][$i]='';
	$datos['NOMBRE_CATEGORIA'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_CATEGORIA'][$i]=$fila['ID_CATEGORIA'];
		$datos['NOMBRE_CATEGORIA'][$i]=$fila['NOMBRE_CATEGORIA'];
		$i=$i+1;
	}
	return $datos;
}
function M_categorias_U_id($conexion, $id_categoria, $nombre_categoria){//MODIFICA TODOS LOS DATOS
	$consulta="UPDATE `mc_categorias` SET 
	`NOMBRE_CATEGORIA`='$nombre_categoria' 
	WHERE `ID_CATEGORIA`='$id_categoria'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_categorias_D_id($conexion, $id_categoria){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_categorias` WHERE `ID_CATEGORIA`='$id_categoria'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_categorias_disponibles($conexion){//LEE TODO
	$consulta="SELECT `mc_categorias`.`NOMBRE_CATEGORIA` AS CATEGORIA FROM `mc_categorias` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_categorias`.`NOMBRE_CATEGORIA`=`mc_productos_y_servicios`.`NOMBRE_CATEGORIA` 
	INNER JOIN `mc_usuarios` ON `mc_productos_y_servicios`.`CEDULA_RIF`=`mc_usuarios`.`CEDULA_RIF`
	WHERE 
	`mc_productos_y_servicios`.`CANTIDAD_DISPONIBLE`>'0' AND
	`mc_usuarios`.`ESTATUS`='ACTIVO' 
	GROUP BY CATEGORIA ORDER BY CATEGORIA";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['CATEGORIA'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['CATEGORIA'][$i]=$fila['CATEGORIA'];
		$i=$i+1;
	}
	return $datos;
}
?>