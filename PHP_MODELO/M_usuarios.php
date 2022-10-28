<?php 
function M_usuarios_C($conexion, $ip_de_navegacion, $nombre, $apellido, $empresa, $fecha_nacimiento, $cedula_rif, $telefono, $correo, $foto_logo, $fecha_de_ingreso, $estado, $ciudad, $municipio, $parroquia, $direccion, $banco_nombre, $banco_numero_cuenta, $banco_tipo_cuenta, $banco_telefono, $banco_cedula_rif, $pregunta_seguridad_1, $respuesta_seguridad_1, $pregunta_seguridad_2, $respuesta_seguridad_2, $pregunta_seguridad_3, $respuesta_seguridad_3, $pregunta_seguridad_4, $respuesta_seguridad_4, $pregunta_seguridad_5, $respuesta_seguridad_5, $acceso, $estatus, $ranking, $aliado, $indicadores){//CREA VERIFICANDO DUPLICADOS
	$consulta="SELECT * FROM `mc_usuarios` WHERE `CEDULA_RIF`='$cedula_rif' OR `CORREO`='$correo'";
	$resultado=mysqli_query($conexion,$consulta);
	if(($fila=mysqli_fetch_array($resultado))==true){
		return false;
	}else{
		$fecha_nacimiento=$fecha_nacimiento==''?'00-00-00 00:00:00':$fecha_nacimiento;
		$fecha_de_ingreso=$fecha_de_ingreso==''?'00-00-00 00:00:00':$fecha_de_ingreso;
		$consulta="INSERT INTO `mc_usuarios`(`IP_DE_NAVEGAION`, `NOMBRE`, `APELLIDO`, `EMPRESA`, `FECHA_NACIMIENTO`, `CEDULA_RIF`, `TELEFONO`, `CORREO`, `FOTO_LOGO`, `FECHA_DE_INGRESO`, `ESTADO`, `CIUDAD`, `MUNICIPIO`, `PARROQUIA`, `DIRECCION`, `BANCO_NOMBRE`, `BANCO_NUMERO_CUENTA`, `BANCO_TIPO_CUENTA`, `BANCO_TELEFONO`, `BANCO_CEDULA_RIF`, `PREGUNTA_SEGURIDAD_1`, `RESPUESTA_SEGURIDAD_1`, `PREGUNTA_SEGURIDAD_2`, `RESPUESTA_SEGURIDAD_2`, `PREGUNTA_SEGURIDAD_3`, `RESPUESTA_SEGURIDAD_3`, `PREGUNTA_SEGURIDAD_4`, `RESPUESTA_SEGURIDAD_4`, `PREGUNTA_SEGURIDAD_5`, `RESPUESTA_SEGURIDAD_5`, `ACCESO`, `ESTATUS`, `RANKING`, `ALIADO`, `INDICADORES`) VALUES ('$ip_de_navegacion', '$nombre', '$apellido', '$empresa', '$fecha_nacimiento', '$cedula_rif', '$telefono', '$correo', '$foto_logo', '$fecha_de_ingreso', '$estado', '$ciudad', '$municipio', '$parroquia', '$direccion', '$banco_nombre', '$banco_numero_cuenta', '$banco_tipo_cuenta', '$banco_telefono', '$banco_cedula_rif', '$pregunta_seguridad_1', '$respuesta_seguridad_1', '$pregunta_seguridad_2', '$respuesta_seguridad_2', '$pregunta_seguridad_3', '$respuesta_seguridad_3', '$pregunta_seguridad_4', '$respuesta_seguridad_4', '$pregunta_seguridad_5', '$respuesta_seguridad_5', '$acceso', '$estatus', '$ranking', '$aliado', '$indicadores')";
		$resultados=mysqli_query($conexion,$consulta);
		return true;
	}
}
function M_usuarios_cuenta($conexion){
	$consulta="SELECT COUNT(ID_USUARIO) AS CANTIDAD FROM `mc_usuarios` WHERE ACCESO='COMPRADOR-VENDEDOR'";
	$resultados=mysqli_query($conexion,$consulta);
	$dato=0;
	if(($fila=mysqli_fetch_array($resultados))==true){
		$dato=$fila['CANTIDAD'];
	}
	return $dato;
}
function M_usuarios_R($conexion, $f_1, $d_1, $f_2, $d_2, $f_3, $d_3){
	//ESTA FUNCION PERMITE LEER HASTA CON 3 FILTROS EJEMPLO: $f_1='NOMBRE DE LA COLUMNA' $d_1='DATO'
	$sql_f_1=($f_1=="" and $d_1=="") ? "" : "AND `mc_usuarios`.`$f_1`='$d_1'";
	$sql_f_2=($f_2=="" and $d_2=="") ? "" : "AND `mc_usuarios`.`$f_2`='$d_2'";
	$sql_f_3=($f_3=="" and $d_3=="") ? "" : "AND `mc_usuarios`.`$f_3`='$d_3'";
	$consulta="SELECT * FROM `mc_usuarios` WHERE 1 $sql_f_1 $sql_f_2 $sql_f_3 ORDER BY `mc_usuarios`.`CORREO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
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
	$datos['ESTADO'][$i]='';
	$datos['CIUDAD'][$i]='';
	$datos['MUNICIPIO'][$i]='';
	$datos['PARROQUIA'][$i]='';
	$datos['DIRECCION'][$i]='';
	$datos['BANCO_NOMBRE'][$i]='';
	$datos['BANCO_NUMERO_CUENTA'][$i]='';
	$datos['BANCO_TIPO_CUENTA'][$i]='';
	$datos['BANCO_TELEFONO'][$i]='';
	$datos['BANCO_CEDULA_RIF'][$i]='';
	$datos['PREGUNTA_SEGURIDAD_1'][$i]='';
	$datos['RESPUESTA_SEGURIDAD_1'][$i]='';
	$datos['PREGUNTA_SEGURIDAD_2'][$i]='';
	$datos['RESPUESTA_SEGURIDAD_2'][$i]='';
	$datos['PREGUNTA_SEGURIDAD_3'][$i]='';
	$datos['RESPUESTA_SEGURIDAD_3'][$i]='';
	$datos['PREGUNTA_SEGURIDAD_4'][$i]='';
	$datos['RESPUESTA_SEGURIDAD_4'][$i]='';
	$datos['PREGUNTA_SEGURIDAD_5'][$i]='';
	$datos['RESPUESTA_SEGURIDAD_5'][$i]='';
	$datos['ACCESO'][$i]='';
	$datos['ESTATUS'][$i]='';
	$datos['RANKING'][$i]='';
	$datos['ALIADO'][$i]='';
	$datos['INDICADORES'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
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
		$datos['ESTADO'][$i]=$fila['ESTADO'];
		$datos['CIUDAD'][$i]=$fila['CIUDAD'];
		$datos['MUNICIPIO'][$i]=$fila['MUNICIPIO'];
		$datos['PARROQUIA'][$i]=$fila['PARROQUIA'];
		$datos['DIRECCION'][$i]=$fila['DIRECCION'];
		$datos['BANCO_NOMBRE'][$i]=$fila['BANCO_NOMBRE'];
		$datos['BANCO_NUMERO_CUENTA'][$i]=$fila['BANCO_NUMERO_CUENTA'];
		$datos['BANCO_TIPO_CUENTA'][$i]=$fila['BANCO_TIPO_CUENTA'];
		$datos['BANCO_TELEFONO'][$i]=$fila['BANCO_TELEFONO'];
		$datos['BANCO_CEDULA_RIF'][$i]=$fila['BANCO_CEDULA_RIF'];
		$datos['PREGUNTA_SEGURIDAD_1'][$i]=$fila['PREGUNTA_SEGURIDAD_1'];
		$datos['RESPUESTA_SEGURIDAD_1'][$i]=$fila['RESPUESTA_SEGURIDAD_1'];
		$datos['PREGUNTA_SEGURIDAD_2'][$i]=$fila['PREGUNTA_SEGURIDAD_2'];
		$datos['RESPUESTA_SEGURIDAD_2'][$i]=$fila['RESPUESTA_SEGURIDAD_2'];
		$datos['PREGUNTA_SEGURIDAD_3'][$i]=$fila['PREGUNTA_SEGURIDAD_3'];
		$datos['RESPUESTA_SEGURIDAD_3'][$i]=$fila['RESPUESTA_SEGURIDAD_3'];
		$datos['PREGUNTA_SEGURIDAD_4'][$i]=$fila['PREGUNTA_SEGURIDAD_4'];
		$datos['RESPUESTA_SEGURIDAD_4'][$i]=$fila['RESPUESTA_SEGURIDAD_4'];
		$datos['PREGUNTA_SEGURIDAD_5'][$i]=$fila['PREGUNTA_SEGURIDAD_5'];
		$datos['RESPUESTA_SEGURIDAD_5'][$i]=$fila['RESPUESTA_SEGURIDAD_5'];
		$datos['ACCESO'][$i]=$fila['ACCESO'];
		$datos['ESTATUS'][$i]=$fila['ESTATUS'];
		$datos['RANKING'][$i]=$fila['RANKING'];
		$datos['ALIADO'][$i]=$fila['ALIADO'];
		$datos['INDICADORES'][$i]=$fila['INDICADORES'];
		$i=$i+1;
	}
	return $datos;
}
function M_usuarios_U_indicadores($conexion, $id_usuario, $indicadores){
	$consulta="UPDATE `mc_usuarios` SET 
	`INDICADORES`='$indicadores' 
	WHERE `ID_USUARIO`='$id_usuario'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_usuarios_U_id($conexion, $id_usuario, $ip_de_navegacion, $nombre, $apellido, $empresa, $fecha_nacimiento, $cedula_rif, $telefono, $correo, $foto_logo, $fecha_de_ingreso, $estado, $ciudad, $municipio, $parroquia, $direccion, $banco_nombre, $banco_numero_cuenta, $banco_tipo_cuenta, $banco_telefono, $banco_cedula_rif, $pregunta_seguridad_1, $respuesta_seguridad_1, $pregunta_seguridad_2, $respuesta_seguridad_2, $pregunta_seguridad_3, $respuesta_seguridad_3, $pregunta_seguridad_4, $respuesta_seguridad_4, $pregunta_seguridad_5, $respuesta_seguridad_5, $acceso, $estatus, $ranking, $aliado, $indicadores){//MODIFICA TODOS LOS DATOS
	$fecha_nacimiento=$fecha_nacimiento==''?'00-00-00 00:00:00':$fecha_nacimiento;
	$fecha_de_ingreso=$fecha_de_ingreso==''?'00-00-00 00:00:00':$fecha_de_ingreso;
	$consulta="UPDATE `mc_usuarios` SET 
	`IP_DE_NAVEGAION`='$ip_de_navegacion', 
	`NOMBRE`='$nombre', 
	`APELLIDO`= '$apellido', 
	`EMPRESA`='$empresa',  
	`FECHA_NACIMIENTO`='$fecha_nacimiento', 
	`CEDULA_RIF`='$cedula_rif', 
	`TELEFONO`='$telefono', 
	`CORREO`='$correo',  
	`FOTO_LOGO`='$foto_logo',  
	`FECHA_DE_INGRESO`='$fecha_de_ingreso', 
	`ESTADO`='$estado',  
	`CIUDAD`='$ciudad', 
	`MUNICIPIO`='$municipio',  
	`PARROQUIA`='$parroquia', 
	`DIRECCION`='$direccion', 
	`BANCO_NOMBRE`='$banco_nombre',  
	`BANCO_NUMERO_CUENTA`='$banco_numero_cuenta', `BANCO_TIPO_CUENTA`='$banco_tipo_cuenta', 
	`BANCO_TELEFONO`='$banco_telefono', 
	`BANCO_CEDULA_RIF`='$banco_cedula_rif', `PREGUNTA_SEGURIDAD_1`='$pregunta_seguridad_1', `RESPUESTA_SEGURIDAD_1`='$respuesta_seguridad_1', `PREGUNTA_SEGURIDAD_2`='$pregunta_seguridad_2', `RESPUESTA_SEGURIDAD_2`='$respuesta_seguridad_2', `PREGUNTA_SEGURIDAD_3`='$pregunta_seguridad_3', `RESPUESTA_SEGURIDAD_3`='$respuesta_seguridad_3',  `PREGUNTA_SEGURIDAD_4`='$pregunta_seguridad_4', `RESPUESTA_SEGURIDAD_4`='$respuesta_seguridad_4', `PREGUNTA_SEGURIDAD_5`='$pregunta_seguridad_5', `RESPUESTA_SEGURIDAD_5`='$respuesta_seguridad_5', 
	`ACCESO`='$acceso', 
	`ESTATUS`='$estatus', 
	`RANKING`='$ranking', 
	`ALIADO`='$aliado', 
	`INDICADORES`='$indicadores' 
	WHERE `ID_USUARIO`='$id_usuario'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_usuarios_U_id_ip_nav($conexion, $id_usuario, $ip_de_navegacion){//MODIFICA LA IP_DE_NAVEGAION DADO EL ID_USUARIO
	$consulta="UPDATE `mc_usuarios` SET 
	`IP_DE_NAVEGAION`='$ip_de_navegacion' 
	WHERE `ID_USUARIO`='$id_usuario'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_usuarios_U_id_ip_contrasena($conexion, $id_usuario, $contra_nueva){//MODIFICA LA CONTRASENA DADO EL ID_USUARIO
	$consulta="UPDATE `mc_usuarios` SET 
	`CONTRASENA`='$contra_nueva' 
	WHERE `ID_USUARIO`='$id_usuario'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_usuarios_U_id_estatus($conexion, $id_usuario, $estatus){//MODIFICA EL ESTATUS DADO EL ID_USUARIO
	$consulta="UPDATE `mc_usuarios` SET 
	`ESTATUS`='$estatus' 
	WHERE `ID_USUARIO`='$id_usuario'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_usuarios_U_id_ranking($conexion, $id_usuario, $ranking){//MODIFICA EL RANKING DADO EL ID_USUARIO
	$consulta="UPDATE `mc_usuarios` SET 
	`RANKING`='$ranking' 
	WHERE `ID_USUARIO`='$id_usuario'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_usuarios_U_id_aliado($conexion, $id_usuario, $aliado){//MODIFICA ALIADO DADO EL ID_USUARIO
	$consulta="UPDATE `mc_usuarios` SET 
	`ALIADO`='$aliado' 
	WHERE `ID_USUARIO`='$id_usuario'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_usuarios_D_id($conexion, $id_usuario){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_usuarios` WHERE `ID_USUARIO`='$id_usuario'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_usuarios_R_portada_aliados($conexion){
	//ESTA FUNCION PERMITE LEER LOS DATOS EN EL FORMATO REQUERIDO POR LA SECCIÓN DE EMPRESAS DESTACADAS - ALIADOS DE LA PORTADA
	$consulta="SELECT * FROM `mc_usuarios` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_productos_y_servicios`.`CEDULA_RIF`=`mc_usuarios`.`CEDULA_RIF` 
	WHERE `mc_usuarios`.`ALIADO`='SI' ORDER BY `mc_usuarios`.`NOMBRE`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_PRODUCTO'][$i]='';	
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['EMPRESA'][$i]='';
	$datos['NOMBRE_PRODUCTO'][$i]='';
	$datos['NOMBRE_CATEGORIA'][$i]='';
	$datos['NOMBRE_ETIQUETA_1'][$i]='';
	$datos['NOMBRE_ETIQUETA_2'][$i]='';
	$datos['NOMBRE_ETIQUETA_3'][$i]='';
	$datos['NOMBRE_ETIQUETA_4'][$i]='';
	$datos['NOMBRE_ETIQUETA_5'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_PRODUCTO'][$i]=$fila['ID_PRODUCTO'];	
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['EMPRESA'][$i]=$fila['EMPRESA'];
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$datos['NOMBRE_CATEGORIA'][$i]=$fila['NOMBRE_CATEGORIA'];
		$datos['NOMBRE_ETIQUETA_1'][$i]=$fila['NOMBRE_ETIQUETA_1'];
		$datos['NOMBRE_ETIQUETA_2'][$i]=$fila['NOMBRE_ETIQUETA_2'];
		$datos['NOMBRE_ETIQUETA_3'][$i]=$fila['NOMBRE_ETIQUETA_3'];
		$datos['NOMBRE_ETIQUETA_4'][$i]=$fila['NOMBRE_ETIQUETA_4'];
		$datos['NOMBRE_ETIQUETA_5'][$i]=$fila['NOMBRE_ETIQUETA_5'];
		$i=$i+1;
	}
	$datos_corregidos['NOMBRE'][0]="";
	$datos_corregidos['CEDULA_RIF'][0]="";
	$datos_corregidos['NOMBRE_PRODUCTOS'][0]="";
	$datos_corregidos['NOMBRE_CATEGORIAS'][0]="";
	$datos_corregidos['NOMBRE_ETIQUETAS'][0]="";
	$i=0;
	$e=0;
	while(isset($datos['ID_PRODUCTO'][$i])){
		if($i==0){
			$datos_corregidos['NOMBRE'][$e]=$datos['NOMBRE'][$i];
			$datos_corregidos['CEDULA_RIF'][$e]=$datos['CEDULA_RIF'][$i];
			$datos_corregidos['NOMBRE_PRODUCTOS'][$e]=$datos['NOMBRE_PRODUCTO'][$i];
			$datos_corregidos['NOMBRE_CATEGORIAS'][$e]=$datos['NOMBRE_CATEGORIA'][$i];
			$datos_corregidos['NOMBRE_ETIQUETAS'][$e]=$datos['NOMBRE_ETIQUETA_1'][$i] . ", " . $datos['NOMBRE_ETIQUETA_2'][$i] . ", " . $datos['NOMBRE_ETIQUETA_3'][$i] . ", " . $datos['NOMBRE_ETIQUETA_4'][$i] . ", " . $datos['NOMBRE_ETIQUETA_5'][$i];
			if(isset($datos['CEDULA_RIF'][$i+1])){
				if($datos['CEDULA_RIF'][$i]<>$datos['CEDULA_RIF'][$i+1]){
					$e=$e+1;
				}
			}
		}else if($datos['CEDULA_RIF'][$i]==$datos['CEDULA_RIF'][$i-1]){
			$datos_corregidos['NOMBRE_PRODUCTOS'][$e]=$datos_corregidos['NOMBRE_PRODUCTOS'][$e] . ", " . $datos['NOMBRE_PRODUCTO'][$i];
			$datos_corregidos['NOMBRE_CATEGORIAS'][$e]=$datos_corregidos['NOMBRE_CATEGORIAS'][$e] . ", " . $datos['NOMBRE_CATEGORIA'][$i];
			$datos_corregidos['NOMBRE_ETIQUETAS'][$e]=$datos_corregidos['NOMBRE_ETIQUETAS'][$e] . ", " . $datos['NOMBRE_ETIQUETA_1'][$i] . ", " . $datos['NOMBRE_ETIQUETA_2'][$i] . ", " . $datos['NOMBRE_ETIQUETA_3'][$i] . ", " . $datos['NOMBRE_ETIQUETA_4'][$i] . ", " . $datos['NOMBRE_ETIQUETA_5'][$i];
		}else{
			$datos_corregidos['NOMBRE'][$e]=$datos['NOMBRE'][$i];
			$datos_corregidos['CEDULA_RIF'][$e]=$datos['CEDULA_RIF'][$i];
			$datos_corregidos['NOMBRE_PRODUCTOS'][$e]=$datos['NOMBRE_PRODUCTO'][$i];
			$datos_corregidos['NOMBRE_CATEGORIAS'][$e]=$datos['NOMBRE_CATEGORIA'][$i];
			$datos_corregidos['NOMBRE_ETIQUETAS'][$e]=$datos['NOMBRE_ETIQUETA_1'][$i] . ", " . $datos['NOMBRE_ETIQUETA_2'][$i] . ", " . $datos['NOMBRE_ETIQUETA_3'][$i] . ", " . $datos['NOMBRE_ETIQUETA_4'][$i] . ", " . $datos['NOMBRE_ETIQUETA_5'][$i];
			if(isset($datos['CEDULA_RIF'][$i+1])){
				if($datos['CEDULA_RIF'][$i]<>$datos['CEDULA_RIF'][$i+1]){
					$e=$e+1;
				}
			}
		}
		$i=$i+1;
	}
	$datos_finales['NOMBRE'][0]="";
	$i=0;
	//QUITANDO LAS COMAS, LAS CATEGORIAS REPETIDAS Y LAS ETIQUTAS REPETIDAS Y COVIRTIENDO LOS STRINGS EN ARRAY PARA HACER LA IMPRESION DE LOS DATOS DE FORMA SENCILLA
	while(isset($datos_corregidos['NOMBRE_PRODUCTOS'][$i])){
		$nombre_empresa_corregido[$i]=[$datos_corregidos['NOMBRE'][$i],0];
		$cedula_empresa_corregido[$i]=[$datos_corregidos['CEDULA_RIF'][$i],0];
		$prod_separado=explode(", ",$datos_corregidos['NOMBRE_PRODUCTOS'][$i]);
		$prod_corregido[$i]=(array_unique($prod_separado));
		$categorias_separado=explode(", ",$datos_corregidos['NOMBRE_CATEGORIAS'][$i]);
		$categorias_corregido[$i]=(array_unique($categorias_separado));
		$etiquetas_separado=explode(", ",$datos_corregidos['NOMBRE_ETIQUETAS'][$i]);
		$etiquetas_corregido[$i]=(array_unique($etiquetas_separado));
		$i=$i+1;
	}
	$datos_finales['EMPRESA']=$nombre_empresa_corregido;
	$datos_finales['CEDULA_RIF']=$cedula_empresa_corregido;
	$datos_finales['PRODUCTOS']=$prod_corregido;
	$datos_finales['CATEGORIAS']=$categorias_corregido;
	$datos_finales['ETIQUETAS']=$etiquetas_corregido;
	return $datos_finales; //ESTE ARRAY TIENE 3 DIMENSIONES [1°] ES PARA DIFERENCIAS ENTRE PRODUCTOS, CATEGORIAS y ETIQUETAS, [2°] ES PARA DIFERENCIAS POR EMPRESA Y EL [3°] TE DA LOS VALORES CORRESPONDIENTES A CADA EMPRESA ---OJO--- LA POSICIÓN DE EMPRESA TIENE SÓLO 2 DIMENSIONES
}
function M_dibuja_estrellas($puntos){//DIBUJA LAS ESTRELLAS DADOS LOS PUNTOS DE UN USAURIO
	if($puntos>=4.5){
		$string_estrellas="
		<b class='text-warning'><span class='fa fa-star'></span></b>
		<b class='text-warning'><span class='fa fa-star'></span></b>
		<b class='text-warning'><span class='fa fa-star'></span></b>
		<b class='text-warning'><span class='fa fa-star'></span></b>
		<b class='text-warning'><span class='fa fa-star'></span></b>
		";
	}else if($puntos>=3.5){
		$string_estrellas="
		<b class='text-warning'><span class='fa fa-star'></span></b>
		<b class='text-warning'><span class='fa fa-star'></span></b>
		<b class='text-warning'><span class='fa fa-star'></span></b>
		<b class='text-warning'><span class='fa fa-star'></span></b>
		<b class='text-warning'><span class='fa fa-star-o'></span></b>
		";
	}else if($puntos>=2.5){
		$string_estrellas="
		<b class='text-warning'><span class='fa fa-star'></span></b>
		<b class='text-warning'><span class='fa fa-star'></span></b>
		<b class='text-warning'><span class='fa fa-star'></span></b>
		<b class='text-warning'><span class='fa fa-star-o'></span></b>
		<b class='text-warning'><span class='fa fa-star-o'></span></b>
		";
	}else if($puntos>=1.5){
		$string_estrellas="
		<b class='text-warning'><span class='fa fa-star'></span></b>
		<b class='text-warning'><span class='fa fa-star'></span></b>
		<b class='text-warning'><span class='fa fa-star-o'></span></b>
		<b class='text-warning'><span class='fa fa-star-o'></span></b>
		<b class='text-warning'><span class='fa fa-star-o'></span></b>
		";
	}else if($puntos>=0.5){
		$string_estrellas="
		<b class='text-warning'><span class='fa fa-star'></span></b>
		<b class='text-warning'><span class='fa fa-star-o'></span></b>
		<b class='text-warning'><span class='fa fa-star-o'></span></b>
		<b class='text-warning'><span class='fa fa-star-o'></span></b>
		<b class='text-warning'><span class='fa fa-star-o'></span></b>
		";
	}else{
		$string_estrellas="<b class='text-danger'>&nbspSin Evaluar</b>";
	}
	return $string_estrellas;
}
function M_saldo_pm_bloqueado_usuario($conexion, $cedula_rif){//DEVUELVE LOS DATOS DE SALDO BLOQUEADO EN PEMOM PARA EL USUARIO
	$i=0;
	// TOTAL PEMON COMPRADO (NO APLICA)
	$datos['COMPRA_CANTIDAD_PEMON'][$i]=0;
	// TOTAL PEMON VENDIDO
	$consulta="SELECT SUM(`CANTIDAD_MICOIN`) AS VENTA_CANTIDAD_PEMON FROM `mc_compra_venta_de_micoin` WHERE `CEDULA_RIF`='$cedula_rif' AND `TIPO_DE_TRANSACCION`='VENTA' AND `ESTATUS`='SOLICITADO'";
	$resultados=mysqli_query($conexion,$consulta);
	$datos['VENTA_CANTIDAD_PEMON'][$i]=0;
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['VENTA_CANTIDAD_PEMON'][$i]=$fila['VENTA_CANTIDAD_PEMON'];
	}
	// TOTAL PEMON GANADO (NO APLICA)
	$datos['GANADO_CANTIDAD_PEMON'][$i]=0;
	// TOTAL PEMON GASTADO
	$consulta="SELECT SUM(`MONTO_BRUTO_MICOIN`) AS GASTADO_CANTIDAD_PEMON FROM `mc_control_de_transacciones_micoin` WHERE `COMPRADOR_CEDULA_RIF`='$cedula_rif' AND `ESTATUS`='PAGADO'";
	$resultados=mysqli_query($conexion,$consulta);
	$datos['GASTADO_CANTIDAD_PEMON'][$i]=0;
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['GASTADO_CANTIDAD_PEMON'][$i]=$fila['GASTADO_CANTIDAD_PEMON'];
	}
	// ENTONCES EL SALDO ES:
	$datos['SALDO_PEMON'][$i]=$datos['COMPRA_CANTIDAD_PEMON'][$i]-$datos['VENTA_CANTIDAD_PEMON'][$i]+$datos['GANADO_CANTIDAD_PEMON'][$i]-$datos['GASTADO_CANTIDAD_PEMON'][$i];
	if($datos['SALDO_PEMON'][$i]>-0.01 and $datos['SALDO_PEMON'][$i]<0.01){
		$datos['SALDO_PEMON'][$i]=0;
	}
	return $datos;
}
function M_saldo_pm_diferido_usuario($conexion, $cedula_rif){//DEVUELVE LOS DATOS DE SALDO DIFERIDO EN PEMOM PARA EL USUARIO
	$i=0;
	// TOTAL PEMON COMPRADO
	$consulta="SELECT SUM(`CANTIDAD_MICOIN`) AS COMPRA_CANTIDAD_PEMON FROM `mc_compra_venta_de_micoin` WHERE `CEDULA_RIF`='$cedula_rif' AND `TIPO_DE_TRANSACCION`='COMPRA' AND `ESTATUS`='PAGADO'";
	$resultados=mysqli_query($conexion,$consulta);
	$datos['COMPRA_CANTIDAD_PEMON'][$i]=0;
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['COMPRA_CANTIDAD_PEMON'][$i]=$fila['COMPRA_CANTIDAD_PEMON'];
	}
	// TOTAL PEMON VENDIDO (NO APLICA)
	$datos['VENTA_CANTIDAD_PEMON'][$i]=0;
	// TOTAL PEMON GANADO
	$consulta="SELECT SUM(`MONTO_NETO`) AS GANADO_CANTIDAD_PEMON FROM `mc_control_de_transacciones_micoin` WHERE `VENDEDOR_CEDULA_RIF`='$cedula_rif' AND `ESTATUS`='PAGADO'";
	$resultados=mysqli_query($conexion,$consulta);
	$datos['GANADO_CANTIDAD_PEMON'][$i]=0;
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['GANADO_CANTIDAD_PEMON'][$i]=$fila['GANADO_CANTIDAD_PEMON'];
	}
	// TOTAL PEMON GASTADO (NO APLICA)
	$datos['GASTADO_CANTIDAD_PEMON'][$i]=0;
	// ENTONCES EL SALDO ES:
	$datos['SALDO_PEMON'][$i]=$datos['COMPRA_CANTIDAD_PEMON'][$i]-$datos['VENTA_CANTIDAD_PEMON'][$i]+$datos['GANADO_CANTIDAD_PEMON'][$i]-$datos['GASTADO_CANTIDAD_PEMON'][$i];
	if($datos['SALDO_PEMON'][$i]>-0.01 and $datos['SALDO_PEMON'][$i]<0.01){
		$datos['SALDO_PEMON'][$i]=0;
	}
	return $datos;
}
function M_saldo_pm_disponible_usuario($conexion, $cedula_rif){//DEVUELVE LOS DATOS DE SALDO DISPONIBLE EN PEMOM PARA EL USUARIO
	$i=0;
	// TOTAL PEMON COMPRADO
	$consulta="SELECT SUM(`CANTIDAD_MICOIN`) AS COMPRA_CANTIDAD_PEMON FROM `mc_compra_venta_de_micoin` WHERE `CEDULA_RIF`='$cedula_rif' AND `TIPO_DE_TRANSACCION`='COMPRA' AND `ESTATUS`='CONFIRMADO'";
	$resultados=mysqli_query($conexion,$consulta);
	$datos['COMPRA_CANTIDAD_PEMON'][$i]=0;
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['COMPRA_CANTIDAD_PEMON'][$i]=$fila['COMPRA_CANTIDAD_PEMON'];
	}
	// TOTAL PEMON VENDIDO
	$consulta="SELECT SUM(`CANTIDAD_MICOIN`) AS VENTA_CANTIDAD_PEMON FROM `mc_compra_venta_de_micoin` WHERE `CEDULA_RIF`='$cedula_rif' AND `TIPO_DE_TRANSACCION`='VENTA' AND `ESTATUS`='CONFIRMADO'";
	$resultados=mysqli_query($conexion,$consulta);
	$datos['VENTA_CANTIDAD_PEMON'][$i]=0;
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['VENTA_CANTIDAD_PEMON'][$i]=$fila['VENTA_CANTIDAD_PEMON'];
	}
	// TOTAL PEMON GANADO
	$consulta="SELECT SUM(`MONTO_NETO`) AS GANADO_CANTIDAD_PEMON FROM `mc_control_de_transacciones_micoin` WHERE `VENDEDOR_CEDULA_RIF`='$cedula_rif' AND `ESTATUS`='ENTREGADO'";
	$resultados=mysqli_query($conexion,$consulta);
	$datos['GANADO_CANTIDAD_PEMON'][$i]=0;
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['GANADO_CANTIDAD_PEMON'][$i]=$fila['GANADO_CANTIDAD_PEMON'];
	}
	// TOTAL PEMON GASTADO
	$consulta="SELECT SUM(`MONTO_BRUTO_MICOIN`) AS GASTADO_CANTIDAD_PEMON FROM `mc_control_de_transacciones_micoin` WHERE `COMPRADOR_CEDULA_RIF`='$cedula_rif' AND `ESTATUS`='ENTREGADO'";
	$resultados=mysqli_query($conexion,$consulta);
	$datos['GASTADO_CANTIDAD_PEMON'][$i]=0;
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['GASTADO_CANTIDAD_PEMON'][$i]=$fila['GASTADO_CANTIDAD_PEMON'];
	}
	// TOTAL PEMON REINTEGRADO POR ABANDONO DE COMPRAS PREMIUN
	$consulta="SELECT SUM(`MONTO_COMISION`) AS COMPRA_RECHAZADA_MONTO_COMISION FROM `mc_control_de_transacciones_micoin` WHERE `COMPRADOR_CEDULA_RIF`='$cedula_rif' AND `ESTATUS`='ABANDONADO'";
	$resultados=mysqli_query($conexion,$consulta);
	$datos['COMPRA_RECHAZADA_MONTO_COMISION'][$i]=0;
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['COMPRA_RECHAZADA_MONTO_COMISION'][$i]=$fila['COMPRA_RECHAZADA_MONTO_COMISION'];
	}
	//DEBEMOS RESTAR LOS SALDOS BLOQUEADOS
		// TOTAL PEMON VENDIDO
		$consulta="SELECT SUM(`CANTIDAD_MICOIN`) AS VENTA_CANTIDAD_PEMON FROM `mc_compra_venta_de_micoin` WHERE `CEDULA_RIF`='$cedula_rif' AND `TIPO_DE_TRANSACCION`='VENTA' AND `ESTATUS`='SOLICITADO'";
		$resultados=mysqli_query($conexion,$consulta);
		$datos['BLOQUEADO_VENTA_CANTIDAD_PEMON'][$i]=0;
		if(($fila=mysqli_fetch_array($resultados))==true){
			$datos['BLOQUEADO_VENTA_CANTIDAD_PEMON'][$i]=$fila['VENTA_CANTIDAD_PEMON'];
		}
		// TOTAL PEMON GASTADO
		$consulta="SELECT SUM(`MONTO_BRUTO_MICOIN`) AS GASTADO_CANTIDAD_PEMON FROM `mc_control_de_transacciones_micoin` WHERE `COMPRADOR_CEDULA_RIF`='$cedula_rif' AND `ESTATUS`='PAGADO'";
		$resultados=mysqli_query($conexion,$consulta);
		$datos['BLOQUEADO_GASTADO_CANTIDAD_PEMON'][$i]=0;
		if(($fila=mysqli_fetch_array($resultados))==true){
			$datos['BLOQUEADO_GASTADO_CANTIDAD_PEMON'][$i]=$fila['GASTADO_CANTIDAD_PEMON'];
		}
		$total_saldo_bloqueado=$datos['BLOQUEADO_VENTA_CANTIDAD_PEMON'][$i]+$datos['BLOQUEADO_GASTADO_CANTIDAD_PEMON'][$i];
	// ENTONCES EL SALDO ES:
	$datos['SALDO_PEMON'][$i]=$datos['COMPRA_CANTIDAD_PEMON'][$i]-$datos['VENTA_CANTIDAD_PEMON'][$i]+$datos['GANADO_CANTIDAD_PEMON'][$i]-$datos['GASTADO_CANTIDAD_PEMON'][$i]-$total_saldo_bloqueado-$datos['COMPRA_RECHAZADA_MONTO_COMISION'][$i];
	if($datos['SALDO_PEMON'][$i]>-0.01 and $datos['SALDO_PEMON'][$i]<0.01){
		$datos['SALDO_PEMON'][$i]=0;
	}
	return $datos;
}
function M_usuarios_R_activos_ciudades($conexion){
	$consulta="SELECT `CIUDAD` FROM `mc_usuarios` WHERE `ACCESO`='COMPRADOR-VENDEDOR' AND `ESTATUS`='ACTIVO' GROUP BY `CIUDAD` ORDER BY `CIUDAD`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['CIUDAD'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['CIUDAD'][$i]=$fila['CIUDAD'];
		$i=$i+1;
	}
	return $datos;
}
function M_agrupa_usuarios($conexion){
	$consulta="SELECT * FROM `mc_usuarios` WHERE `mc_usuarios`.`ACCESO`='COMPRADOR-VENDEDOR' GROUP BY `mc_usuarios`.`CEDULA_RIF` ORDER BY `mc_usuarios`.`NOMBRE`, `mc_usuarios`.`APELLIDO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
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
	$datos['ESTADO'][$i]='';
	$datos['CIUDAD'][$i]='';
	$datos['MUNICIPIO'][$i]='';
	$datos['PARROQUIA'][$i]='';
	$datos['DIRECCION'][$i]='';
	$datos['BANCO_NOMBRE'][$i]='';
	$datos['BANCO_NUMERO_CUENTA'][$i]='';
	$datos['BANCO_TIPO_CUENTA'][$i]='';
	$datos['BANCO_TELEFONO'][$i]='';
	$datos['BANCO_CEDULA_RIF'][$i]='';
	$datos['PREGUNTA_SEGURIDAD_1'][$i]='';
	$datos['RESPUESTA_SEGURIDAD_1'][$i]='';
	$datos['PREGUNTA_SEGURIDAD_2'][$i]='';
	$datos['RESPUESTA_SEGURIDAD_2'][$i]='';
	$datos['PREGUNTA_SEGURIDAD_3'][$i]='';
	$datos['RESPUESTA_SEGURIDAD_3'][$i]='';
	$datos['PREGUNTA_SEGURIDAD_4'][$i]='';
	$datos['RESPUESTA_SEGURIDAD_4'][$i]='';
	$datos['PREGUNTA_SEGURIDAD_5'][$i]='';
	$datos['RESPUESTA_SEGURIDAD_5'][$i]='';
	$datos['ACCESO'][$i]='';
	$datos['ESTATUS'][$i]='';
	$datos['RANKING'][$i]='';
	$datos['ALIADO'][$i]='';
	$datos['INDICADORES'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
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
		$datos['ESTADO'][$i]=$fila['ESTADO'];
		$datos['CIUDAD'][$i]=$fila['CIUDAD'];
		$datos['MUNICIPIO'][$i]=$fila['MUNICIPIO'];
		$datos['PARROQUIA'][$i]=$fila['PARROQUIA'];
		$datos['DIRECCION'][$i]=$fila['DIRECCION'];
		$datos['BANCO_NOMBRE'][$i]=$fila['BANCO_NOMBRE'];
		$datos['BANCO_NUMERO_CUENTA'][$i]=$fila['BANCO_NUMERO_CUENTA'];
		$datos['BANCO_TIPO_CUENTA'][$i]=$fila['BANCO_TIPO_CUENTA'];
		$datos['BANCO_TELEFONO'][$i]=$fila['BANCO_TELEFONO'];
		$datos['BANCO_CEDULA_RIF'][$i]=$fila['BANCO_CEDULA_RIF'];
		$datos['PREGUNTA_SEGURIDAD_1'][$i]=$fila['PREGUNTA_SEGURIDAD_1'];
		$datos['RESPUESTA_SEGURIDAD_1'][$i]=$fila['RESPUESTA_SEGURIDAD_1'];
		$datos['PREGUNTA_SEGURIDAD_2'][$i]=$fila['PREGUNTA_SEGURIDAD_2'];
		$datos['RESPUESTA_SEGURIDAD_2'][$i]=$fila['RESPUESTA_SEGURIDAD_2'];
		$datos['PREGUNTA_SEGURIDAD_3'][$i]=$fila['PREGUNTA_SEGURIDAD_3'];
		$datos['RESPUESTA_SEGURIDAD_3'][$i]=$fila['RESPUESTA_SEGURIDAD_3'];
		$datos['PREGUNTA_SEGURIDAD_4'][$i]=$fila['PREGUNTA_SEGURIDAD_4'];
		$datos['RESPUESTA_SEGURIDAD_4'][$i]=$fila['RESPUESTA_SEGURIDAD_4'];
		$datos['PREGUNTA_SEGURIDAD_5'][$i]=$fila['PREGUNTA_SEGURIDAD_5'];
		$datos['RESPUESTA_SEGURIDAD_5'][$i]=$fila['RESPUESTA_SEGURIDAD_5'];
		$datos['ACCESO'][$i]=$fila['ACCESO'];
		$datos['ESTATUS'][$i]=$fila['ESTATUS'];
		$datos['RANKING'][$i]=$fila['RANKING'];
		$datos['ALIADO'][$i]=$fila['ALIADO'];
		$datos['INDICADORES'][$i]=$fila['INDICADORES'];
		$i=$i+1;
	}
	return $datos;
}
function M_obtener_ip_real(){
	$tablet_browser=0;
	$mobile_browser=0;
	$body_class="desktop";
	if(preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i',strtolower($_SERVER['HTTP_USER_AGENT']))){
		$tablet_browser++;
		$body_class="tablet";
	}
	if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i',strtolower($_SERVER['HTTP_USER_AGENT']))){
		$mobile_browser++;
		$body_class="mobile";
	}
	if((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml')>0) or isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])){
		$mobile_browser++;
		$body_class="mobile";
	}
	$mobile_ua=strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
	$mobile_agents=array(
						'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
						'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
						'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
						'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
						'newt','noki','palm','pana','pant','phil','play','port','prox',
						'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
						'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
						'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
						'wapr','webc','winw','xda ','xda-'
						);
	if(in_array($mobile_ua,$mobile_agents)){
		$mobile_browser++;
	}
	if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini')>0){
		$mobile_browser++;
		//Check for tablets on opera mini alternative headers
		$stock_ua=strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
		if(preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i',$stock_ua)){
			$tablet_browser++;
		}
	}
	if($tablet_browser>0){
		// Si es tablet has lo que necesites
		$dato='tablet';
	}else if($mobile_browser>0){
		// Si es dispositivo mobil has lo que necesites
		$dato='movil';
	}else{
		// Si es ordenador de escritorio has lo que necesites
		if(isset($_SERVER['HTTP_CLIENT_IP'])){
			$dato=$_SERVER['HTTP_CLIENT_IP'];
		}else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$dato=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}else if(isset($_SERVER['HTTP_X_FORWARDED'])){
			$dato=$_SERVER['HTTP_X_FORWARDED'];
		}else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$dato=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}else if(isset($_SERVER['HTTP_X_FORWARDED'])){
			$dato=$_SERVER['HTTP_X_FORWARDED'];
		}else if(isset($_SERVER['REMOTE_ADDR'])){
			$dato=$_SERVER['REMOTE_ADDR'];
		}
	}
	return $dato;
}
?>