<?php 
function M_productos_y_servicios_C($conexion, $nombre, $apellido, $cedula_rif, $correo, $fecha_nacimiento, $empresa, $telefono, $direccion, $nombre_producto, $descripcion_producto, $caracteristicas_producto, $precio_unitario_micoin, $nuevo, $foto_1, $foto_2, $foto_3, $foto_4, $foto_5, $nombre_categoria, $nombre_etiqueta_1, $nombre_etiqueta_2, $nombre_etiqueta_3, $nombre_etiqueta_4, $nombre_etiqueta_5, $fh_creacion, $fh_modificacion, $unidad_de_venta, $cantidad_disponible, $cantidad_disponible_plan, $reestablecer_inventario_periodicidad, $revisado){//CREA VERIFICANDO DUPLICADOS
	$consulta="SELECT * FROM `mc_productos_y_servicios` WHERE `CEDULA_RIF`='$cedula_rif' AND `NOMBRE_PRODUCTO`='$nombre_producto'";
	$resultado=mysqli_query($conexion,$consulta);
	if(($fila=mysqli_fetch_array($resultado))==true){
		return false;
	}else{
		$fecha_nacimiento=$fecha_nacimiento==''?'00-00-00 00:00:00':$fecha_nacimiento;
		$fh_creacion=$fh_creacion==''?'00-00-00 00:00:00':$fh_creacion;
		$fh_modificacion=$fh_modificacion==''?'00-00-00 00:00:00':$fh_modificacion;
		$consultas="INSERT INTO `mc_productos_y_servicios`(`NOMBRE`, `APELLIDO`, `CEDULA_RIF`, `CORREO`, `FECHA_NACIMIENTO`, `EMPRESA`, `TELEFONO`, `DIRECCION`, `NOMBRE_PRODUCTO`, `DESCRIPCION_PRODUCTO`, `CARACTERISTICAS_PRODUCTO`, `PRECIO_UNITARIO_MICOIN`, `NUEVO`, `FOTO_1`, `FOTO_2`, `FOTO_3`, `FOTO_4`, `FOTO_5`, `NOMBRE_CATEGORIA`, `NOMBRE_ETIQUETA_1`, `NOMBRE_ETIQUETA_2`, `NOMBRE_ETIQUETA_3`, `NOMBRE_ETIQUETA_4`, `NOMBRE_ETIQUETA_5`, `FH_CREACION`, `FH_MODIFICACION`, `UNIDAD_DE_VENTA`, `CANTIDAD_DISPONIBLE`, `CANTIDAD_DISPONIBLE_PLAN`, `REESTABLECER_INVENTARIO_PERIODICIDAD`, `REVISADO`) VALUES ('$nombre', '$apellido', '$cedula_rif', '$correo', '$fecha_nacimiento', '$empresa', '$telefono', '$direccion', '$nombre_producto', '$descripcion_producto', '$caracteristicas_producto', '$precio_unitario_micoin', '$nuevo', '$foto_1', '$foto_2', '$foto_3', '$foto_4', '$foto_5', '$nombre_categoria', '$nombre_etiqueta_1', '$nombre_etiqueta_2', '$nombre_etiqueta_3', '$nombre_etiqueta_4', '$nombre_etiqueta_5', '$fh_creacion', '$fh_modificacion', '$unidad_de_venta', '$cantidad_disponible', '$cantidad_disponible_plan', '$reestablecer_inventario_periodicidad', '$revisado')";
		$resultados=mysqli_query($conexion,$consultas);
		return true;
	}
}
function M_productos_y_servicios_R($conexion, $f_1, $d_1, $f_2, $d_2, $f_3, $d_3){
	//ESTA FUNCION PERMITE LEER HASTA CON 3 FILTROS EJEMPLO: $f_1='NOMBRE DE LA COLUMNA' $d_1='DATO'
	$sql_f_1=($f_1=="" and $d_1=="") ? "" : "AND `mc_productos_y_servicios`.`$f_1`='$d_1'";
	$sql_f_2=($f_2=="" and $d_2=="") ? "" : "AND `mc_productos_y_servicios`.`$f_2`='$d_2'";
	$sql_f_3=($f_3=="" and $d_3=="") ? "" : "AND `mc_productos_y_servicios`.`$f_3`='$d_3'";
	$consulta="SELECT * FROM `mc_productos_y_servicios` WHERE 1 $sql_f_1 $sql_f_2 $sql_f_3";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_PRODUCTO'][$i]='';	
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['CORREO'][$i]='';
	$datos['FECHA_NACIMIENTO'][$i]='';
	$datos['EMPRESA'][$i]='';
	$datos['TELEFONO'][$i]='';
	$datos['DIRECCION'][$i]='';
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
	$datos['REESTABLECER_INVENTARIO_PERIODICIDAD'][$i]='';
	$datos['REVISADO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_PRODUCTO'][$i]=$fila['ID_PRODUCTO'];	
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['CORREO'][$i]=$fila['CORREO'];
		$datos['FECHA_NACIMIENTO'][$i]=$fila['FECHA_NACIMIENTO'];
		$datos['EMPRESA'][$i]=$fila['EMPRESA'];
		$datos['TELEFONO'][$i]=$fila['TELEFONO'];
		$datos['DIRECCION'][$i]=$fila['DIRECCION'];
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
		$datos['REESTABLECER_INVENTARIO_PERIODICIDAD'][$i]=$fila['REESTABLECER_INVENTARIO_PERIODICIDAD'];
		$datos['REVISADO'][$i]=$fila['REVISADO'];
		$i=$i+1;
	}
	return $datos;
}
function M_productos_y_servicios_U_id($conexion, $id_producto, $nombre, $apellido, $cedula_rif, $correo, $fecha_nacimiento, $empresa, $telefono, $direccion, $nombre_producto, $descripcion_producto, $caracteristicas_producto, $precio_unitario_micoin, $nuevo, $foto_1, $foto_2, $foto_3, $foto_4, $foto_5, $nombre_categoria, $nombre_etiqueta_1, $nombre_etiqueta_2, $nombre_etiqueta_3, $nombre_etiqueta_4, $nombre_etiqueta_5, $fh_creacion, $fh_modificacion, $unidad_de_venta, $cantidad_disponible, $cantidad_disponible_plan, $reestablecer_inventario_periodicidad){//ACTUALIZA TODA LA TABLA
	$fecha_nacimiento=$fecha_nacimiento==''?'00-00-00 00:00:00':$fecha_nacimiento;
	$fh_creacion=$fh_creacion==''?'00-00-00 00:00:00':$fh_creacion;
	$fh_modificacion=$fh_modificacion==''?'00-00-00 00:00:00':$fh_modificacion;
	$consulta="UPDATE `mc_productos_y_servicios` SET 
	`NOMBRE`='$nombre', 
	`APELLIDO`='$apellido', 
	`CEDULA_RIF`='$cedula_rif', 
	`CORREO`='$correo', 
	`FECHA_NACIMIENTO`='$fecha_nacimiento', 
	`EMPRESA`='$empresa', 
	`TELEFONO`='$telefono', 
	`DIRECCION`='$direccion', 
	`NOMBRE_PRODUCTO`='$nombre_producto', 
	`DESCRIPCION_PRODUCTO`='$descripcion_producto', 
	`CARACTERISTICAS_PRODUCTO`='$caracteristicas_producto', 
	`PRECIO_UNITARIO_MICOIN`='$precio_unitario_micoin', 
	`NUEVO`='$nuevo', 
	`FOTO_1`='$foto_1', 
	`FOTO_2`='$foto_2', 
	`FOTO_3`='$foto_3', 
	`FOTO_4`='$foto_4', 
	`FOTO_5`='$foto_5', 
	`NOMBRE_CATEGORIA`='$nombre_categoria', 
	`NOMBRE_ETIQUETA_1`='$nombre_etiqueta_1', 
	`NOMBRE_ETIQUETA_2`='$nombre_etiqueta_2', 
	`NOMBRE_ETIQUETA_3`='$nombre_etiqueta_3', 
	`NOMBRE_ETIQUETA_4`='$nombre_etiqueta_4', 
	`NOMBRE_ETIQUETA_5`='$nombre_etiqueta_5', 
	`FH_CREACION`='$fh_creacion', 
	`FH_MODIFICACION`='$fh_modificacion', 
	`UNIDAD_DE_VENTA`='$unidad_de_venta', 
	`CANTIDAD_DISPONIBLE`='$cantidad_disponible', 
	`CANTIDAD_DISPONIBLE_PLAN`='$cantidad_disponible_plan', 
	`REESTABLECER_INVENTARIO_PERIODICIDAD`='$reestablecer_inventario_periodicidad'	
	WHERE `ID_PRODUCTO`='$id_producto'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_productos_y_servicios_D_id($conexion, $id_producto){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_productos_y_servicios` WHERE `ID_PRODUCTO`='$id_producto'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_agrupa_productos_disponibles($conexion, $cedula_vendedor){
	//ESTA DEVUELVE UNA LISTA DE LOS PRODUCTOS DISPOIBLES DADO UN USUARIO REVISANDO QUE EL MISMO TENGA ESTATUS DE ACTIVO Y QUE LOS PRODUCTOS TENGAN DISPONIBILIDAD DE INVENTARIO
	$consulta="SELECT 
	`mc_productos_y_servicios`.`ID_PRODUCTO` AS ID_PRODUCTO, 
	`mc_productos_y_servicios`.`NOMBRE_PRODUCTO` AS NOMBRE_PRODUCTO, 
	`mc_productos_y_servicios`.`CANTIDAD_DISPONIBLE` AS CANTIDAD_DISPONIBLE 
	FROM `mc_productos_y_servicios` 
	INNER JOIN `mc_usuarios` ON `mc_productos_y_servicios`.`CEDULA_RIF`=`mc_usuarios`.`CEDULA_RIF` 
	WHERE 
	`mc_usuarios`.`CEDULA_RIF`='$cedula_vendedor' AND 
	`mc_productos_y_servicios`.`CANTIDAD_DISPONIBLE`>'0' AND
	`mc_usuarios`.`ESTATUS`='ACTIVO'
	ORDER BY NOMBRE_PRODUCTO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_PRODUCTO'][$i]='';	
	$datos['NOMBRE_PRODUCTO'][$i]='';
	$datos['CANTIDAD_DISPONIBLE'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_PRODUCTO'][$i]=$fila['ID_PRODUCTO'];	
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$datos['CANTIDAD_DISPONIBLE'][$i]=$fila['CANTIDAD_DISPONIBLE'];
		$i=$i+1;
	}
	return $datos;
}
function M_nuevos_productos($conexion){
	//ESTA DEVUELVE UNA LISTA DE LOS 12 PRODUCTOS MÁS NUEVOS 
	$consulta="SELECT 
	`mc_productos_y_servicios`.`ID_PRODUCTO` AS ID_PRODUCTO, 
	`mc_productos_y_servicios`.`NOMBRE` AS NOMBRE, 
	`mc_productos_y_servicios`.`APELLIDO` AS APELLIDO, 
	`mc_productos_y_servicios`.`NOMBRE_PRODUCTO` AS NOMBRE_PRODUCTO, 
	`mc_productos_y_servicios`.`PRECIO_UNITARIO_MICOIN` AS PRECIO_UNITARIO, 
	`mc_productos_y_servicios`.`FOTO_1` AS FOTO_1, 
	`mc_productos_y_servicios`.`NOMBRE_CATEGORIA` AS NOMBRE_CATEGORIA, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_1` AS NOMBRE_ETIQUETA_1, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_2` AS NOMBRE_ETIQUETA_2, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_3` AS NOMBRE_ETIQUETA_3, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_4` AS NOMBRE_ETIQUETA_4, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_5` AS NOMBRE_ETIQUETA_5, 
	`mc_productos_y_servicios`.`CANTIDAD_DISPONIBLE` AS DISPONIBLE, 
	`mc_productos_y_servicios`.`UNIDAD_DE_VENTA` AS UNIDAD_DE_VENTA 
	FROM `mc_productos_y_servicios` 
	INNER JOIN `mc_usuarios` ON `mc_productos_y_servicios`.`CEDULA_RIF`=`mc_usuarios`.`CEDULA_RIF` 
	WHERE 
	`mc_productos_y_servicios`.`CANTIDAD_DISPONIBLE`>'0' AND
	`mc_usuarios`.`ESTATUS`='ACTIVO'
	ORDER BY ID_PRODUCTO DESC limit 0,12";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_PRODUCTO'][$i]='';	
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['NOMBRE_PRODUCTO'][$i]='';
	$datos['PRECIO_UNITARIO'][$i]='';
	$datos['FOTO_1'][$i]='';
	$datos['NOMBRE_CATEGORIA'][$i]='';
	$datos['NOMBRE_ETIQUETA_1'][$i]='';
	$datos['NOMBRE_ETIQUETA_2'][$i]='';
	$datos['NOMBRE_ETIQUETA_3'][$i]='';
	$datos['NOMBRE_ETIQUETA_4'][$i]='';
	$datos['NOMBRE_ETIQUETA_5'][$i]='';
	$datos['DISPONIBLE'][$i]='';
	$datos['UNIDAD_DE_VENTA'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_PRODUCTO'][$i]=$fila['ID_PRODUCTO'];	
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['PRECIO_UNITARIO'][$i]=$fila['PRECIO_UNITARIO'];
		$datos['FOTO_1'][$i]=$fila['FOTO_1'];
		$datos['NOMBRE_CATEGORIA'][$i]=$fila['NOMBRE_CATEGORIA'];
		$datos['NOMBRE_ETIQUETA_1'][$i]=$fila['NOMBRE_ETIQUETA_1'];
		$datos['NOMBRE_ETIQUETA_2'][$i]=$fila['NOMBRE_ETIQUETA_2'];
		$datos['NOMBRE_ETIQUETA_3'][$i]=$fila['NOMBRE_ETIQUETA_3'];
		$datos['NOMBRE_ETIQUETA_4'][$i]=$fila['NOMBRE_ETIQUETA_4'];
		$datos['NOMBRE_ETIQUETA_5'][$i]=$fila['NOMBRE_ETIQUETA_5'];
		$datos['DISPONIBLE'][$i]=$fila['DISPONIBLE'];
		$datos['UNIDAD_DE_VENTA'][$i]=$fila['UNIDAD_DE_VENTA'];
		$i=$i+1;
	}
	return $datos;
}
function M_buscar_productos($conexion, $texto_buscado, $vendedor_cedula_rif, $ciudad, $categoria, $orden, $aliado){
	//ESTA DEVUELVE UNA LISTA DE LOS PRODUCTOS DE ACUERDO A LA BUSQUEDA, BUSCA POR NOMBRE DEL PRODUCTO, NOMBRE DEL VENDEDOR, CATEGORIA, ETIQUECAS Y PRECIOS. 
	$texto_buscado=($texto_buscado=="") ? "" : $texto_buscado;
	$sql_vendedor=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_ciudad=($ciudad=="") ? "" : "AND `mc_usuarios`.`CIUDAD`='$ciudad'";
	$sql_categoria=($categoria=="") ? "" : "AND `mc_productos_y_servicios`.`NOMBRE_CATEGORIA`='$categoria'";
	$sql_aliado=($aliado=="") ? "" : "AND `mc_usuarios`.`ALIADO`='$aliado'";
	if($orden=='Mayor Precio'){
		$sql_orden=" ORDER BY PRECIO_UNITARIO DESC, NOMBRE_PRODUCTO ";
	}else if($orden=='Menor Precio'){
		$sql_orden=" ORDER BY PRECIO_UNITARIO, NOMBRE_PRODUCTO ";
	}else if($orden=='Más Reciente'){
		$sql_orden=" ORDER BY ID_PRODUCTO DESC ";
	}else if($orden=='Menos Reciente'){
		$sql_orden=" ORDER BY ID_PRODUCTO ";
	}else{
		$sql_orden=" ORDER BY NOMBRE_PRODUCTO ";
	}
	$consulta="SELECT 
	`mc_productos_y_servicios`.`ID_PRODUCTO` AS ID_PRODUCTO, 
	`mc_productos_y_servicios`.`NOMBRE` AS NOMBRE, 
	`mc_productos_y_servicios`.`APELLIDO` AS APELLIDO, 
	`mc_productos_y_servicios`.`CEDULA_RIF` AS CEDULA_RIF, 
	`mc_productos_y_servicios`.`NOMBRE_PRODUCTO` AS NOMBRE_PRODUCTO, 
	`mc_productos_y_servicios`.`PRECIO_UNITARIO_MICOIN` AS PRECIO_UNITARIO, 
	`mc_productos_y_servicios`.`FOTO_1` AS FOTO_1, 
	`mc_productos_y_servicios`.`NOMBRE_CATEGORIA` AS NOMBRE_CATEGORIA, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_1` AS NOMBRE_ETIQUETA_1, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_2` AS NOMBRE_ETIQUETA_2, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_3` AS NOMBRE_ETIQUETA_3, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_4` AS NOMBRE_ETIQUETA_4, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_5` AS NOMBRE_ETIQUETA_5, 
	`mc_productos_y_servicios`.`CANTIDAD_DISPONIBLE` AS DISPONIBLE, 
	`mc_productos_y_servicios`.`UNIDAD_DE_VENTA` AS UNIDAD_DE_VENTA 
	FROM `mc_productos_y_servicios` 
	INNER JOIN `mc_usuarios` ON `mc_productos_y_servicios`.`CEDULA_RIF`=`mc_usuarios`.`CEDULA_RIF` 
	WHERE 
	`mc_productos_y_servicios`.`CANTIDAD_DISPONIBLE`>'0' 
	AND	`mc_usuarios`.`ESTATUS`='ACTIVO' 
	AND	(`mc_productos_y_servicios`.`NOMBRE_PRODUCTO` LIKE '%$texto_buscado%' 
	OR `mc_productos_y_servicios`.`NOMBRE` LIKE '%$texto_buscado%' 
	OR `mc_productos_y_servicios`.`APELLIDO` LIKE '%$texto_buscado%' 
	OR `mc_productos_y_servicios`.`NOMBRE_CATEGORIA` LIKE '%$texto_buscado%' 
	OR `mc_productos_y_servicios`.`NOMBRE_ETIQUETA_1` LIKE '%$texto_buscado%' 
	OR `mc_productos_y_servicios`.`NOMBRE_ETIQUETA_2` LIKE '%$texto_buscado%' 
	OR `mc_productos_y_servicios`.`NOMBRE_ETIQUETA_3` LIKE '%$texto_buscado%' 
	OR `mc_productos_y_servicios`.`NOMBRE_ETIQUETA_4` LIKE '%$texto_buscado%' 
	OR `mc_productos_y_servicios`.`NOMBRE_ETIQUETA_5` LIKE '%$texto_buscado%' 
	OR `mc_productos_y_servicios`.`UNIDAD_DE_VENTA` LIKE '%$texto_buscado%' 
	OR `mc_productos_y_servicios`.`PRECIO_UNITARIO_MICOIN` LIKE '%$texto_buscado%')  
	$sql_vendedor 
	$sql_ciudad 
	$sql_categoria 
	$sql_aliado
	$sql_orden ";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_PRODUCTO'][$i]='';	
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE_PRODUCTO'][$i]='';
	$datos['PRECIO_UNITARIO'][$i]='';
	$datos['FOTO_1'][$i]='';
	$datos['NOMBRE_CATEGORIA'][$i]='';
	$datos['NOMBRE_ETIQUETA_1'][$i]='';
	$datos['NOMBRE_ETIQUETA_2'][$i]='';
	$datos['NOMBRE_ETIQUETA_3'][$i]='';
	$datos['NOMBRE_ETIQUETA_4'][$i]='';
	$datos['NOMBRE_ETIQUETA_5'][$i]='';
	$datos['DISPONIBLE'][$i]='';
	$datos['UNIDAD_DE_VENTA'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_PRODUCTO'][$i]=$fila['ID_PRODUCTO'];	
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['PRECIO_UNITARIO'][$i]=$fila['PRECIO_UNITARIO'];
		$datos['FOTO_1'][$i]=$fila['FOTO_1'];
		$datos['NOMBRE_CATEGORIA'][$i]=$fila['NOMBRE_CATEGORIA'];
		$datos['NOMBRE_ETIQUETA_1'][$i]=$fila['NOMBRE_ETIQUETA_1'];
		$datos['NOMBRE_ETIQUETA_2'][$i]=$fila['NOMBRE_ETIQUETA_2'];
		$datos['NOMBRE_ETIQUETA_3'][$i]=$fila['NOMBRE_ETIQUETA_3'];
		$datos['NOMBRE_ETIQUETA_4'][$i]=$fila['NOMBRE_ETIQUETA_4'];
		$datos['NOMBRE_ETIQUETA_5'][$i]=$fila['NOMBRE_ETIQUETA_5'];
		$datos['DISPONIBLE'][$i]=$fila['DISPONIBLE'];
		$datos['UNIDAD_DE_VENTA'][$i]=$fila['UNIDAD_DE_VENTA'];
		$i=$i+1;
	}
	return $datos;
}
function M_contar_productos($conexion){
	//ESTA DEVUELVE UNA LISTA DE LOS PRODUCTOS DE ACUERDO A LA BUSQUEDA, BUSCA POR NOMBRE DEL PRODUCTO, NOMBRE DEL VENDEDOR, CATEGORIA, ETIQUECAS Y PRECIOS. 
	$consulta="SELECT 
	COUNT(`mc_productos_y_servicios`.`ID_PRODUCTO`) AS PRODUCTOS 
	FROM `mc_productos_y_servicios` 
	INNER JOIN `mc_usuarios` ON `mc_productos_y_servicios`.`CEDULA_RIF`=`mc_usuarios`.`CEDULA_RIF` 
	WHERE 
	`mc_productos_y_servicios`.`CANTIDAD_DISPONIBLE`>'0' 
	AND	`mc_usuarios`.`ESTATUS`='ACTIVO' 
	ORDER BY ID_PRODUCTO DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['PRODUCTOS'][$i]='';	
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['PRODUCTOS'][$i]=$fila['PRODUCTOS'];	
		$i=$i+1;
	}
	return $datos;
}
function M_buscar_productos_te_puede_interesar($conexion, $textos_buscados){
	//ESTA DEVUELVE UNA LISTA DE LOS PRODUCTOS DE ACUERDO A LA BUSQUEDA, BUSCA LOS PRODUCTOS DE UN ARRAY POR NOMBRE DEL PRODUCTO, NOMBRE DEL VENDEDOR, CATEGORIA, ETIQUECAS Y PRECIOS. 
	$consulta="SELECT 
	`mc_productos_y_servicios`.`ID_PRODUCTO` AS ID_PRODUCTO, 
	`mc_productos_y_servicios`.`NOMBRE` AS NOMBRE, 
	`mc_productos_y_servicios`.`APELLIDO` AS APELLIDO, 
	`mc_productos_y_servicios`.`NOMBRE_PRODUCTO` AS NOMBRE_PRODUCTO, 
	`mc_productos_y_servicios`.`PRECIO_UNITARIO_MICOIN` AS PRECIO_UNITARIO, 
	`mc_productos_y_servicios`.`FOTO_1` AS FOTO_1, 
	`mc_productos_y_servicios`.`NOMBRE_CATEGORIA` AS NOMBRE_CATEGORIA, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_1` AS NOMBRE_ETIQUETA_1, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_2` AS NOMBRE_ETIQUETA_2, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_3` AS NOMBRE_ETIQUETA_3, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_4` AS NOMBRE_ETIQUETA_4, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_5` AS NOMBRE_ETIQUETA_5, 
	`mc_productos_y_servicios`.`CANTIDAD_DISPONIBLE` AS DISPONIBLE, 
	`mc_productos_y_servicios`.`UNIDAD_DE_VENTA` AS UNIDAD_DE_VENTA 
	FROM `mc_productos_y_servicios` 
	INNER JOIN `mc_usuarios` ON `mc_productos_y_servicios`.`CEDULA_RIF`=`mc_usuarios`.`CEDULA_RIF` 
	WHERE 
	`mc_productos_y_servicios`.`CANTIDAD_DISPONIBLE`>'0' 
	AND	`mc_usuarios`.`ESTATUS`='ACTIVO' 
	AND	('2'='1' "; 
	$i=0;
	while(isset($textos_buscados[$i])){
		if($textos_buscados[$i]<>""){
			$consulta=$consulta . "
			OR `mc_productos_y_servicios`.`NOMBRE_PRODUCTO` LIKE '%" . $textos_buscados[$i] . "%' 
			OR `mc_productos_y_servicios`.`NOMBRE` LIKE '%" . $textos_buscados[$i] . "%' 
			OR `mc_productos_y_servicios`.`APELLIDO` LIKE '%" . $textos_buscados[$i] . "%' 
			OR `mc_productos_y_servicios`.`NOMBRE_CATEGORIA` LIKE '%" . $textos_buscados[$i] . "%' 
			OR `mc_productos_y_servicios`.`NOMBRE_ETIQUETA_1` LIKE '%" . $textos_buscados[$i] . "%' 
			OR `mc_productos_y_servicios`.`NOMBRE_ETIQUETA_2` LIKE '%" . $textos_buscados[$i] . "%' 
			OR `mc_productos_y_servicios`.`NOMBRE_ETIQUETA_3` LIKE '%" . $textos_buscados[$i] . "%' 
			OR `mc_productos_y_servicios`.`NOMBRE_ETIQUETA_4` LIKE '%" . $textos_buscados[$i] . "%' 
			OR `mc_productos_y_servicios`.`NOMBRE_ETIQUETA_5` LIKE '%" . $textos_buscados[$i] . "%' 
			OR `mc_productos_y_servicios`.`PRECIO_UNITARIO_MICOIN` LIKE '%" . $textos_buscados[$i] . "%' ";
		}
		$i=$i+1;
	}
	$consulta=$consulta . ") ORDER BY ID_PRODUCTO DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_PRODUCTO'][$i]='';	
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['NOMBRE_PRODUCTO'][$i]='';
	$datos['PRECIO_UNITARIO'][$i]='';
	$datos['FOTO_1'][$i]='';
	$datos['NOMBRE_CATEGORIA'][$i]='';
	$datos['NOMBRE_ETIQUETA_1'][$i]='';
	$datos['NOMBRE_ETIQUETA_2'][$i]='';
	$datos['NOMBRE_ETIQUETA_3'][$i]='';
	$datos['NOMBRE_ETIQUETA_4'][$i]='';
	$datos['NOMBRE_ETIQUETA_5'][$i]='';
	$datos['DISPONIBLE'][$i]='';
	$datos['UNIDAD_DE_VENTA'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_PRODUCTO'][$i]=$fila['ID_PRODUCTO'];	
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['PRECIO_UNITARIO'][$i]=$fila['PRECIO_UNITARIO'];
		$datos['FOTO_1'][$i]=$fila['FOTO_1'];
		$datos['NOMBRE_CATEGORIA'][$i]=$fila['NOMBRE_CATEGORIA'];
		$datos['NOMBRE_ETIQUETA_1'][$i]=$fila['NOMBRE_ETIQUETA_1'];
		$datos['NOMBRE_ETIQUETA_2'][$i]=$fila['NOMBRE_ETIQUETA_2'];
		$datos['NOMBRE_ETIQUETA_3'][$i]=$fila['NOMBRE_ETIQUETA_3'];
		$datos['NOMBRE_ETIQUETA_4'][$i]=$fila['NOMBRE_ETIQUETA_4'];
		$datos['NOMBRE_ETIQUETA_5'][$i]=$fila['NOMBRE_ETIQUETA_5'];
		$datos['DISPONIBLE'][$i]=$fila['DISPONIBLE'];
		$datos['UNIDAD_DE_VENTA'][$i]=$fila['UNIDAD_DE_VENTA'];
		$i=$i+1;
	}
	return $datos;
}
function M_productos_y_servicios_U_id_inventario($conexion, $id_producto, $cantidad_disponible){//ACTUALIZA INVENTARIO CUANDO HAY UNA COMPRA
	$consulta="UPDATE `mc_productos_y_servicios` SET 
	`CANTIDAD_DISPONIBLE`='$cantidad_disponible' 
	WHERE `ID_PRODUCTO`='$id_producto'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_productos_y_servicios_U_id_revisado($conexion, $id_producto, $revisado){
	$consulta="UPDATE `mc_productos_y_servicios` SET 
	`REVISADO`='$revisado' 
	WHERE `ID_PRODUCTO`='$id_producto'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_productos_y_servicios_actualizar_todo_el_inventario($conexion){//ACTUALIZA INVENTARIO GENERAL PARA TODOS LOS PRODUCTOS DEL SISTEMA DE ACUERDO A COMO SE DEFINIO SU REESTABLECIMIENTO
	$consulta="UPDATE `mc_productos_y_servicios` SET 
	`CANTIDAD_DISPONIBLE`=`CANTIDAD_DISPONIBLE_PLAN` 
	WHERE `REESTABLECER_INVENTARIO_PERIODICIDAD`='Diariamente'";
	$resultados=mysqli_query($conexion,$consulta);
	if(date("d-n")=="1-1"){//anualmente
		$consulta="UPDATE `mc_productos_y_servicios` SET 
		`CANTIDAD_DISPONIBLE`=`CANTIDAD_DISPONIBLE_PLAN` 
		WHERE `REESTABLECER_INVENTARIO_PERIODICIDAD`='Anualmente'";
		$resultados=mysqli_query($conexion,$consulta);
	}
	if(date("d")=="1" or date("d")=="15"){
		$consulta="UPDATE `mc_productos_y_servicios` SET 
		`CANTIDAD_DISPONIBLE`=`CANTIDAD_DISPONIBLE_PLAN` 
		WHERE `REESTABLECER_INVENTARIO_PERIODICIDAD`='Los días 1 y 15 del mes'";
		$resultados=mysqli_query($conexion,$consulta);
	}
	if(date("d")=="1"){
		$consulta="UPDATE `mc_productos_y_servicios` SET 
		`CANTIDAD_DISPONIBLE`=`CANTIDAD_DISPONIBLE_PLAN` 
		WHERE `REESTABLECER_INVENTARIO_PERIODICIDAD`='El día 1 del mes'";
		$resultados=mysqli_query($conexion,$consulta);
	}
	if(date("d")=="15"){
		$consulta="UPDATE `mc_productos_y_servicios` SET 
		`CANTIDAD_DISPONIBLE`=`CANTIDAD_DISPONIBLE_PLAN` 
		WHERE `REESTABLECER_INVENTARIO_PERIODICIDAD`='El día 15 del mes'";
		$resultados=mysqli_query($conexion,$consulta);
	}
	if(date("N")=="1"){
		$consulta="UPDATE `mc_productos_y_servicios` SET 
		`CANTIDAD_DISPONIBLE`=`CANTIDAD_DISPONIBLE_PLAN` 
		WHERE `REESTABLECER_INVENTARIO_PERIODICIDAD`='Todos los lunes'";
		$resultados=mysqli_query($conexion,$consulta);
	}
	if(date("N")=="2"){
		$consulta="UPDATE `mc_productos_y_servicios` SET 
		`CANTIDAD_DISPONIBLE`=`CANTIDAD_DISPONIBLE_PLAN` 
		WHERE `REESTABLECER_INVENTARIO_PERIODICIDAD`='Todos los martes'";
		$resultados=mysqli_query($conexion,$consulta);
	}
	if(date("N")=="3"){
		$consulta="UPDATE `mc_productos_y_servicios` SET 
		`CANTIDAD_DISPONIBLE`=`CANTIDAD_DISPONIBLE_PLAN` 
		WHERE `REESTABLECER_INVENTARIO_PERIODICIDAD`='Todos los miércoles'";
		$resultados=mysqli_query($conexion,$consulta);
	}
	if(date("N")=="4"){
		$consulta="UPDATE `mc_productos_y_servicios` SET 
		`CANTIDAD_DISPONIBLE`=`CANTIDAD_DISPONIBLE_PLAN` 
		WHERE `REESTABLECER_INVENTARIO_PERIODICIDAD`='Todos los jueves'";
		$resultados=mysqli_query($conexion,$consulta);
	}
	if(date("N")=="5"){
		$consulta="UPDATE `mc_productos_y_servicios` SET 
		`CANTIDAD_DISPONIBLE`=`CANTIDAD_DISPONIBLE_PLAN` 
		WHERE `REESTABLECER_INVENTARIO_PERIODICIDAD`='Todos los viernes'";
		$resultados=mysqli_query($conexion,$consulta);
	}
	if(date("N")=="6"){
		$consulta="UPDATE `mc_productos_y_servicios` SET 
		`CANTIDAD_DISPONIBLE`=`CANTIDAD_DISPONIBLE_PLAN` 
		WHERE `REESTABLECER_INVENTARIO_PERIODICIDAD`='Todos los sábados'";
		$resultados=mysqli_query($conexion,$consulta);
	}
	if(date("N")=="7"){
		$consulta="UPDATE `mc_productos_y_servicios` SET 
		`CANTIDAD_DISPONIBLE`=`CANTIDAD_DISPONIBLE_PLAN` 
		WHERE `REESTABLECER_INVENTARIO_PERIODICIDAD`='Todos los domingos'";
		$resultados=mysqli_query($conexion,$consulta);
	}
}
function M_productos_y_servicios_verf_inventario_prod_actualizao($conexion, $res_inv_periodo){ //VERIFICA SI LE TOCA ACTUALIZACIÓN AL PRODUCTO
	$verf=false;
	if($res_inv_periodo=='Diariamente'){
		$verf=true;
	}
	if(date("d-n")=="1-1" and $res_inv_periodo=='Anualmente'){//anualmente
		$verf=true;
	}
	if((date("d")=="1" or date("d")=="15") and $res_inv_periodo=='Los días 1 y 15 del mes'){
		$verf=true;
	}
	if(date("d")=="1" and $res_inv_periodo=='El día 1 del mes'){
		$verf=true;
	}
	if(date("d")=="15" and $res_inv_periodo=='El día 15 del mes'){
		$verf=true;
	}
	if(date("N")=="1" and $res_inv_periodo=='Todos los lunes'){
		$verf=true;
	}
	if(date("N")=="2" and $res_inv_periodo=='Todos los martes'){
		$verf=true;
	}
	if(date("N")=="3" and $res_inv_periodo=='Todos los miércoles'){
		$verf=true;
	}
	if(date("N")=="4" and $res_inv_periodo=='Todos los jueves'){
		$verf=true;
	}
	if(date("N")=="5" and $res_inv_periodo=='Todos los viernes'){
		$verf=true;
	}
	if(date("N")=="6" and $res_inv_periodo=='Todos los sábados'){
		$verf=true;
	}
	if(date("N")=="7" and $res_inv_periodo=='Todos los domingos'){
		$verf=true;
	}
	return $verf;
}
?>