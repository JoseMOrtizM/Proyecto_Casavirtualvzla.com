<?php 
//EL ESTATUS ES: COMPRADO, APARTADO O ELIMINADO
function M_carrito_compra_C($conexion, $id_usuario, $id_producto, $cantidad, $fecha_agregado, $estatus){//no VERIFICA DUPLICADOS
	$fecha_agregado=$fecha_agregado==''?'00-00-00 00:00:00':$fecha_agregado;
	$consulta="INSERT INTO `mc_carrito_compra`(`ID_USUARIO`, `ID_PRODUCTO`, `CANTIDAD`, `FH_AGREGADO`, `ESTATUS`) VALUES ('$id_usuario', '$id_producto', '$cantidad', '$fecha_agregado', '$estatus')";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_carrito_compra_R($conexion, $t_1, $f_1, $d_1, $t_2, $f_2, $d_2, $t_3, $f_3, $d_3){
	//ESTA FUNCION PERMITE LEER HASTA CON 3 FILTROS EJEMPLO: $t_1='NOMBRE DE LA TABLA' $f_1='NOMBRE DE LA COLUMNA' $d_1='DATO'
	$sql_f_1=($f_1=="" and $d_1=="") ? "" : "AND `$t_1`.`$f_1`='$d_1'";
	$sql_f_2=($f_2=="" and $d_2=="") ? "" : "AND `$t_2`.`$f_2`='$d_2'";
	$sql_f_3=($f_3=="" and $d_3=="") ? "" : "AND `$t_3`.`$f_3`='$d_3'";
	$consulta="SELECT 
	`mc_carrito_compra`.`ID_CARRITO_COMPRA` AS ID_CARRITO_COMPRA, 
	`mc_carrito_compra`.`ID_USUARIO` AS ID_USUARIO, 
	`mc_carrito_compra`.`ID_PRODUCTO` AS ID_PRODUCTO, 
	`mc_carrito_compra`.`CANTIDAD` AS CANTIDAD, 
	`mc_carrito_compra`.`FH_AGREGADO` AS FH_AGREGADO, 
	`mc_carrito_compra`.`ESTATUS` AS ESTATUS, 
	`mc_usuarios`.`IP_DE_NAVEGAION` AS IP_DE_NAVEGAION, 
	`mc_usuarios`.`NOMBRE` AS NOMBRE, 
	`mc_usuarios`.`APELLIDO` AS APELLIDO, 
	`mc_usuarios`.`EMPRESA` AS EMPRESA, 
	`mc_usuarios`.`FECHA_NACIMIENTO` AS FECHA_NACIMIENTO, 
	`mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, 
	`mc_usuarios`.`TELEFONO` AS TELEFONO, 
	`mc_usuarios`.`CORREO` AS CORREO, 
	`mc_usuarios`.`CONTRASENA` AS CONTRASENA, 
	`mc_usuarios`.`FOTO_LOGO` AS FOTO_LOGO, 
	`mc_usuarios`.`FECHA_DE_INGRESO` AS FECHA_DE_INGRESO, 
	`mc_usuarios`.`RANKING` AS RANKING, 
	`mc_usuarios`.`ALIADO` AS ALIADO, 
	`mc_usuarios`.`INDICADORES` AS INDICADORES, 
	`mc_productos_y_servicios`.`NOMBRE` AS VEND_NOMBRE, 
	`mc_productos_y_servicios`.`APELLIDO` AS VEND_APELLIDO, 
	`mc_productos_y_servicios`.`CEDULA_RIF` AS VEND_CEDULA_RIF, 
	`mc_productos_y_servicios`.`CORREO` AS VEND_CORREO, 
	`mc_productos_y_servicios`.`EMPRESA` AS VEND_EMPRESA, 
	`mc_productos_y_servicios`.`TELEFONO` AS VEND_TELEFONO, 
	`mc_productos_y_servicios`.`DIRECCION` AS VEND_DIRECCION, 
	`mc_productos_y_servicios`.`NOMBRE_PRODUCTO` AS NOMBRE_PRODUCTO, 
	`mc_productos_y_servicios`.`DESCRIPCION_PRODUCTO` AS DESCRIPCION_PRODUCTO, 
	`mc_productos_y_servicios`.`CARACTERISTICAS_PRODUCTO` AS CARACTERISTICAS_PRODUCTO, 
	`mc_productos_y_servicios`.`PRECIO_UNITARIO_MICOIN` AS PRECIO_UNITARIO_MICOIN, 
	`mc_productos_y_servicios`.`NUEVO` AS NUEVO, 
	`mc_productos_y_servicios`.`FOTO_1` AS FOTO_1, 
	`mc_productos_y_servicios`.`FOTO_2` AS FOTO_2, 
	`mc_productos_y_servicios`.`FOTO_3` AS FOTO_3, 
	`mc_productos_y_servicios`.`FOTO_4` AS FOTO_4, 
	`mc_productos_y_servicios`.`FOTO_5` AS FOTO_5, 
	`mc_productos_y_servicios`.`NOMBRE_CATEGORIA` AS NOMBRE_CATEGORIA, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_1` AS NOMBRE_ETIQUETA_1, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_2` AS NOMBRE_ETIQUETA_2, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_3` AS NOMBRE_ETIQUETA_3, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_4` AS NOMBRE_ETIQUETA_4, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_5` AS NOMBRE_ETIQUETA_5, 
	`mc_productos_y_servicios`.`FH_CREACION` AS FH_CREACION, 
	`mc_productos_y_servicios`.`FH_MODIFICACION` AS FH_MODIFICACION, 
	`mc_productos_y_servicios`.`UNIDAD_DE_VENTA` AS UNIDAD_DE_VENTA, 
	`mc_productos_y_servicios`.`CANTIDAD_DISPONIBLE` AS CANTIDAD_DISPONIBLE, 
	`mc_productos_y_servicios`.`CANTIDAD_DISPONIBLE_PLAN` AS CANTIDAD_DISPONIBLE_PLAN 
	FROM `mc_carrito_compra` 
	INNER JOIN `mc_usuarios` ON `mc_carrito_compra`.`ID_USUARIO`=`mc_usuarios`.`ID_USUARIO` 
	INNER JOIN `mc_productos_y_servicios` ON `mc_carrito_compra`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` 
	WHERE 1 $sql_f_1 $sql_f_2 $sql_f_3 ORDER BY VEND_CORREO, NOMBRE_PRODUCTO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_CARRITO_COMPRA'][$i]='';
	$datos['ID_USUARIO'][$i]='';
	$datos['ID_PRODUCTO'][$i]='';
	$datos['CANTIDAD'][$i]='';
	$datos['FH_AGREGADO'][$i]='';
	$datos['ESTATUS'][$i]='';
	$datos['IP_DE_NAVEGAION'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['EMPRESA'][$i]='';
	$datos['FECHA_NACIMIENTO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['TELEFONO'][$i]='';
	$datos['CORREO'][$i]='';
	$datos['CONTRASENA'][$i]='';
	$datos['FOTO_LOGO'][$i]='';
	$datos['FECHA_DE_INGRESO'][$i]='';
	$datos['RANKING'][$i]='';
	$datos['ALIADO'][$i]='';
	$datos['INDICADORES'][$i]='';
	$datos['VEND_NOMBRE'][$i]='';
	$datos['VEND_APELLIDO'][$i]='';
	$datos['VEND_CEDULA_RIF'][$i]='';
	$datos['VEND_CORREO'][$i]='';
	$datos['VEND_EMPRESA'][$i]='';
	$datos['VEND_TELEFONO'][$i]='';
	$datos['VEND_DIRECCION'][$i]='';
	$datos['NOMBRE_PRODUCTO'][$i]='';
	$datos['DESCRIPCION_PRODUCTO'][$i]='';
	$datos['CARACTERISTICAS_PRODUCTO'][$i]='';
	$datos['PRECIO_UNITARIO_MICOIN'][$i]='';
	$datos['NUEVO'][$i]='';
	$datos['FOTO_1'][$i]='';
	$datos['FOTO_2'][$i]='';
	$datos['FOTO_3'][$i]='';
	$datos['FOTO_4'][$i]='';
	$datos['FOTO_5'][$i]='';
	$datos['NOMBRE_CATEGORIA'][$i]='';
	$datos['NOMBRE_ETIQUETA_1'][$i]='';
	$datos['NOMBRE_ETIQUETA_2'][$i]='';
	$datos['NOMBRE_ETIQUETA_3'][$i]='';
	$datos['NOMBRE_ETIQUETA_4'][$i]='';
	$datos['NOMBRE_ETIQUETA_5'][$i]='';
	$datos['FH_CREACION'][$i]='';
	$datos['FH_MODIFICACION'][$i]='';
	$datos['UNIDAD_DE_VENTA'][$i]='';
	$datos['CANTIDAD_DISPONIBLE'][$i]='';
	$datos['CANTIDAD_DISPONIBLE_PLAN'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_CARRITO_COMPRA'][$i]=$fila['ID_CARRITO_COMPRA'];
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['ID_PRODUCTO'][$i]=$fila['ID_PRODUCTO'];
		$datos['CANTIDAD'][$i]=$fila['CANTIDAD'];
		$datos['FH_AGREGADO'][$i]=$fila['FH_AGREGADO'];
		$datos['ESTATUS'][$i]=$fila['ESTATUS'];
		$datos['IP_DE_NAVEGAION'][$i]=$fila['IP_DE_NAVEGAION'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['EMPRESA'][$i]=$fila['EMPRESA'];
		$datos['FECHA_NACIMIENTO'][$i]=$fila['FECHA_NACIMIENTO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['TELEFONO'][$i]=$fila['TELEFONO'];
		$datos['CORREO'][$i]=$fila['CORREO'];
		$datos['CONTRASENA'][$i]=$fila['CONTRASENA'];
		$datos['FOTO_LOGO'][$i]=$fila['FOTO_LOGO'];
		$datos['FECHA_DE_INGRESO'][$i]=$fila['FECHA_DE_INGRESO'];
		$datos['RANKING'][$i]=$fila['RANKING'];
		$datos['ALIADO'][$i]=$fila['ALIADO'];
		$datos['INDICADORES'][$i]=$fila['INDICADORES'];
		$datos['VEND_NOMBRE'][$i]=$fila['VEND_NOMBRE'];
		$datos['VEND_APELLIDO'][$i]=$fila['VEND_APELLIDO'];
		$datos['VEND_CEDULA_RIF'][$i]=$fila['VEND_CEDULA_RIF'];
		$datos['VEND_CORREO'][$i]=$fila['VEND_CORREO'];
		$datos['VEND_EMPRESA'][$i]=$fila['VEND_EMPRESA'];
		$datos['VEND_TELEFONO'][$i]=$fila['VEND_TELEFONO'];
		$datos['VEND_DIRECCION'][$i]=$fila['VEND_DIRECCION'];
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$datos['DESCRIPCION_PRODUCTO'][$i]=$fila['DESCRIPCION_PRODUCTO'];
		$datos['CARACTERISTICAS_PRODUCTO'][$i]=$fila['CARACTERISTICAS_PRODUCTO'];
		$datos['PRECIO_UNITARIO_MICOIN'][$i]=$fila['PRECIO_UNITARIO_MICOIN'];
		$datos['NUEVO'][$i]=$fila['NUEVO'];
		$datos['FOTO_1'][$i]=$fila['FOTO_1'];
		$datos['FOTO_2'][$i]=$fila['FOTO_2'];
		$datos['FOTO_3'][$i]=$fila['FOTO_3'];
		$datos['FOTO_4'][$i]=$fila['FOTO_4'];
		$datos['FOTO_5'][$i]=$fila['FOTO_5'];
		$datos['NOMBRE_CATEGORIA'][$i]=$fila['NOMBRE_CATEGORIA'];
		$datos['NOMBRE_ETIQUETA_1'][$i]=$fila['NOMBRE_ETIQUETA_1'];
		$datos['NOMBRE_ETIQUETA_2'][$i]=$fila['NOMBRE_ETIQUETA_2'];
		$datos['NOMBRE_ETIQUETA_3'][$i]=$fila['NOMBRE_ETIQUETA_3'];
		$datos['NOMBRE_ETIQUETA_4'][$i]=$fila['NOMBRE_ETIQUETA_4'];
		$datos['NOMBRE_ETIQUETA_5'][$i]=$fila['NOMBRE_ETIQUETA_5'];
		$datos['FH_CREACION'][$i]=$fila['FH_CREACION'];
		$datos['FH_MODIFICACION'][$i]=$fila['FH_MODIFICACION'];
		$datos['UNIDAD_DE_VENTA'][$i]=$fila['UNIDAD_DE_VENTA'];
		$datos['CANTIDAD_DISPONIBLE'][$i]=$fila['CANTIDAD_DISPONIBLE'];
		$datos['CANTIDAD_DISPONIBLE_PLAN'][$i]=$fila['CANTIDAD_DISPONIBLE_PLAN'];
		$i=$i+1;
	}
	return $datos;
}
function M_carrito_compra_R_agrupa_vendedor($conexion, $t_1, $f_1, $d_1, $t_2, $f_2, $d_2, $t_3, $f_3, $d_3){
	//ESTA FUNCION PERMITE LEER HASTA CON 3 FILTROS EJEMPLO: $t_1='NOMBRE DE LA TABLA' $f_1='NOMBRE DE LA COLUMNA' $d_1='DATO'
	$sql_f_1=($f_1=="" and $d_1=="") ? "" : "AND `$t_1`.`$f_1`='$d_1'";
	$sql_f_2=($f_2=="" and $d_2=="") ? "" : "AND `$t_2`.`$f_2`='$d_2'";
	$sql_f_3=($f_3=="" and $d_3=="") ? "" : "AND `$t_3`.`$f_3`='$d_3'";
	$consulta="SELECT 
	`mc_productos_y_servicios`.`NOMBRE` AS VEND_NOMBRE, 
	`mc_productos_y_servicios`.`APELLIDO` AS VEND_APELLIDO, 
	`mc_productos_y_servicios`.`CEDULA_RIF` AS VEND_CEDULA_RIF, 
	`mc_productos_y_servicios`.`CORREO` AS VEND_CORREO, 
	`mc_productos_y_servicios`.`EMPRESA` AS VEND_EMPRESA, 
	`mc_productos_y_servicios`.`TELEFONO` AS VEND_TELEFONO, 
	`mc_productos_y_servicios`.`DIRECCION` AS VEND_DIRECCION 
	FROM `mc_carrito_compra` 
	INNER JOIN `mc_usuarios` ON `mc_carrito_compra`.`ID_USUARIO`=`mc_usuarios`.`ID_USUARIO` 
	INNER JOIN `mc_productos_y_servicios` ON `mc_carrito_compra`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` 
	WHERE 1 $sql_f_1 $sql_f_2 $sql_f_3 GROUP BY VEND_CEDULA_RIF ORDER BY VEND_CORREO, NOMBRE_PRODUCTO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['VEND_NOMBRE'][$i]='';
	$datos['VEND_APELLIDO'][$i]='';
	$datos['VEND_CEDULA_RIF'][$i]='';
	$datos['VEND_CORREO'][$i]='';
	$datos['VEND_EMPRESA'][$i]='';
	$datos['VEND_TELEFONO'][$i]='';
	$datos['VEND_DIRECCION'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['VEND_NOMBRE'][$i]=$fila['VEND_NOMBRE'];
		$datos['VEND_APELLIDO'][$i]=$fila['VEND_APELLIDO'];
		$datos['VEND_CEDULA_RIF'][$i]=$fila['VEND_CEDULA_RIF'];
		$datos['VEND_CORREO'][$i]=$fila['VEND_CORREO'];
		$datos['VEND_EMPRESA'][$i]=$fila['VEND_EMPRESA'];
		$datos['VEND_TELEFONO'][$i]=$fila['VEND_TELEFONO'];
		$datos['VEND_DIRECCION'][$i]=$fila['VEND_DIRECCION'];
		$i=$i+1;
	}
	return $datos;
}
function M_carrito_actualizar_estatus($conexion, $id_usuario, $id_producto, $estatus){
	$consulta="UPDATE `mc_carrito_compra` SET `ESTATUS`='$estatus' WHERE `ID_USUARIO`='$id_usuario' AND `ID_PRODUCTO`='$id_producto'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_carrito_actualizar_producto_borrado($conexion, $id_producto){
	$consulta="UPDATE `mc_carrito_compra` SET `ESTATUS`='BORRADO' WHERE `ID_PRODUCTO`='$id_producto'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_carrito_actualizar_id_carrito_borrado($conexion, $id_carrito_compra){
	$consulta="UPDATE `mc_carrito_compra` SET `ESTATUS`='BORRADO' WHERE `ID_CARRITO_COMPRA`='$id_carrito_compra'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_carrito_compra_D_id_usuario($conexion, $id){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_carrito_compra` WHERE `ID_USUARIO`='$id'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_carrito_compra_D_id_producto($conexion, $id){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_carrito_compra` WHERE `ID_PRODUCTO`='$id'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_carrito_compra_D_id_usuario_y_producto($conexion, $id_usuario, $id_producto){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_carrito_compra` WHERE `ID_USUARIO`='$id_usuario' AND `ID_PRODUCTO`='$id_producto'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
?>