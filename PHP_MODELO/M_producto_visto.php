<?php 
function M_producto_visto_C($conexion, $id_producto, $id_usuario, $fecha_visto){//CREA VERIFICANDO DUPLICADOS
	$consulta="SELECT * FROM `mc_productos_vitos` WHERE `ID_PRODUCTO`='$id_producto' AND `ID_USUARIO`='$id_usuario' AND `FH_VISTO`='$fecha_visto'";
	$resultado=mysqli_query($conexion,$consulta);
	if(($fila=mysqli_fetch_array($resultado))==true){
		return false;
	}else{
		$fecha_visto=$fecha_visto==''?'00-00-00 00:00:00':$fecha_visto;
		$consulta="INSERT INTO `mc_productos_vitos`(`ID_PRODUCTO`, `ID_USUARIO`, `FH_VISTO`) VALUES ('$id_producto', '$id_usuario', '$fecha_visto')";
		$resultados=mysqli_query($conexion,$consulta);
		return true;
	}
}
function M_producto_visto_R($conexion, $t_1, $f_1, $d_1, $t_2, $f_2, $d_2, $t_3, $f_3, $d_3){
	//ESTA FUNCION PERMITE LEER HASTA CON 3 FILTROS EJEMPLO: $t_1='NOMBRE DE LA TABLA' $f_1='NOMBRE DE LA COLUMNA' $d_1='DATO'
	$sql_f_1=($f_1=="" and $d_1=="") ? "" : "AND `$t_1`.`$f_1`='$d_1'";
	$sql_f_2=($f_2=="" and $d_2=="") ? "" : "AND `$t_2`.`$f_2`='$d_2'";
	$sql_f_3=($f_3=="" and $d_3=="") ? "" : "AND `$t_3`.`$f_3`='$d_3'";
	$consulta="SELECT * FROM `mc_productos_vitos` 
	INNER JOIN `mc_usuarios` ON `mc_productos_vitos`.`ID_USUARIO`=`mc_usuarios`.`ID_USUARIO` 
	INNER JOIN `mc_productos_y_servicios` ON `mc_productos_vitos`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` 
	WHERE 1 $sql_f_1 $sql_f_2 $sql_f_3";
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
	$datos['REESTABLECER_INVENTARIO_PERIODICIDAD'][$i]='';
	$datos['FH_VISTO'][$i]='';
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
		$datos['REESTABLECER_INVENTARIO_PERIODICIDAD'][$i]=$fila['REESTABLECER_INVENTARIO_PERIODICIDAD'];
		$datos['FH_VISTO'][$i]=$fila['FH_VISTO'];
		$i=$i+1;
	}
	return $datos;
}
function M_producto_visto_D_id_usuario($conexion, $id){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_productos_vitos` WHERE `ID_USUARIO`='$id'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_producto_visto_D_id_producto($conexion, $id){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_productos_vitos` WHERE `ID_PRODUCTO`='$id'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_producto_visto_D_id_usuario_y_producto($conexion, $id_usuario, $id_producto){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_productos_vitos` WHERE `ID_USUARIO`='$id_usuario' AND `ID_PRODUCTO`='$id_producto'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
?>