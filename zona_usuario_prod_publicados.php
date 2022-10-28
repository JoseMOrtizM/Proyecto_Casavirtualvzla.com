<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
if(isset($_POST['FORM'])){
	if($_POST['FORM']=='INSERTAR'){
		$cedula=mysqli_real_escape_string($conexion,$_POST['cedula']);
		$vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $cedula, '', '', '', '');
		$nombre_prod=mysqli_real_escape_string($conexion,$_POST['nombre_prod']);
		$descripcion_prod=mysqli_real_escape_string($conexion,$_POST['descripcion_prod']);
		$caracteristicas_prod=mysqli_real_escape_string($conexion,$_POST['caracteristicas_prod']);
		$precio=mysqli_real_escape_string($conexion,$_POST['precio']);
		$nuevo=mysqli_real_escape_string($conexion,$_POST['nuevo']);
		$nombre_categoria=mysqli_real_escape_string($conexion,$_POST['nombre_categoria']);
		$nombre_etiqueta_1=mysqli_real_escape_string($conexion,$_POST['nombre_etiqueta_1']);
		$nombre_etiqueta_2=mysqli_real_escape_string($conexion,$_POST['nombre_etiqueta_2']);
		$nombre_etiqueta_3=mysqli_real_escape_string($conexion,$_POST['nombre_etiqueta_3']);
		$nombre_etiqueta_4=mysqli_real_escape_string($conexion,$_POST['nombre_etiqueta_4']);
		$nombre_etiqueta_5=mysqli_real_escape_string($conexion,$_POST['nombre_etiqueta_5']);
		$fh_creacion=date("Y-m-d h:m:s");
		$fh_modificacion=null;
		$und_venta=mysqli_real_escape_string($conexion,$_POST['und_venta']);	
		$cant_disponible=mysqli_real_escape_string($conexion,$_POST['cant_disponible']);
		$cant_disponible_plan=mysqli_real_escape_string($conexion,$_POST['cant_disponible_plan']);	
		$periodicidad_inv=mysqli_real_escape_string($conexion,$_POST['periodicidad_inv']);
		//VERIFICANDO SI EXITE UN IMAGEN 1
		$verf_foto_size_1="error";
		$verf_foto_type_1="error";
		if(isset($_FILES['foto_1']['type'])){
			//PROCESAMIENTO DE IMAGEN 1
			$foto_type_1=$_FILES['foto_1']['type'];
			$foto_size_1=$_FILES['foto_1']['size'];
			$ruta_temporal_1=$_FILES['foto_1']['tmp_name'];
			$ruta_destino_con_foto_1=$url_sitio . "IMAGENES_PRODUCTOS/" . $cedula . "_" . $nombre_prod . "_1.png";
			$ruta_destino_sin_foto_1=$url_sitio . "IMAGENES_PRODUCTOS/vacio.png";
			//VERIFICANDO TAMAÑO DE LA IMAGEN
			if($foto_size_1>2000000){$verf_foto_size_1="error";}else{$verf_foto_size_1="ok";}
			//VERIFICANDO FORMATO DE LA IMAGEN
			if(strpos($foto_type_1,"png") or strpos($foto_type_1,"gif") or strpos($foto_type_1,"jpeg") or strpos($foto_type_1,"jpg")){$verf_foto_type_1="ok";}else{$verf_foto_type_1="error";}
			if($verf_foto_size_1=='ok' and $verf_foto_type_1=='ok'){
				$foto_1=$cedula . "_" . $nombre_prod . "_1.png";
			}else{
				$foto_1="vacio.png";
			}
		}
		//VERIFICANDO SI EXITE UN IMAGEN 2
		$verf_foto_size_2="error";
		$verf_foto_type_2="error";
		if(isset($_FILES['foto_2']['type'])){
			//PROCESAMIENTO DE IMAGEN 2
			$foto_type_2=$_FILES['foto_2']['type'];
			$foto_size_2=$_FILES['foto_2']['size'];
			$ruta_temporal_2=$_FILES['foto_2']['tmp_name'];
			$ruta_destino_con_foto_2=$url_sitio . "IMAGENES_PRODUCTOS/" . $cedula . "_" . $nombre_prod . "_2.png";
			$ruta_destino_sin_foto_2=$url_sitio . "IMAGENES_PRODUCTOS/vacio.png";
			//VERIFICANDO TAMAÑO DE LA IMAGEN
			if($foto_size_2>2000000){$verf_foto_size_2="error";}else{$verf_foto_size_2="ok";}
			//VERIFICANDO FORMATO DE LA IMAGEN
			if(strpos($foto_type_2,"png") or strpos($foto_type_2,"gif") or strpos($foto_type_2,"jpeg") or strpos($foto_type_2,"jpg")){$verf_foto_type_2="ok";}else{$verf_foto_type_2="error";}
			if($verf_foto_size_2=='ok' and $verf_foto_type_2=='ok'){
				$foto_2=$cedula . "_" . $nombre_prod . "_2.png";
			}else{
				$foto_2="vacio.png";
			}
		}
		//VERIFICANDO SI EXITE UN IMAGEN 3
		$verf_foto_size_3="error";
		$verf_foto_type_3="error";
		if(isset($_FILES['foto_3']['type'])){
			//PROCESAMIENTO DE IMAGEN 3
			$foto_type_3=$_FILES['foto_3']['type'];
			$foto_size_3=$_FILES['foto_3']['size'];
			$ruta_temporal_3=$_FILES['foto_3']['tmp_name'];
			$ruta_destino_con_foto_3=$url_sitio . "IMAGENES_PRODUCTOS/" . $cedula . "_" . $nombre_prod . "_3.png";
			$ruta_destino_sin_foto_3=$url_sitio . "IMAGENES_PRODUCTOS/vacio.png";
			//VERIFICANDO TAMAÑO DE LA IMAGEN
			if($foto_size_3>2000000){$verf_foto_size_3="error";}else{$verf_foto_size_3="ok";}
			//VERIFICANDO FORMATO DE LA IMAGEN
			if(strpos($foto_type_3,"png") or strpos($foto_type_3,"gif") or strpos($foto_type_3,"jpeg") or strpos($foto_type_3,"jpg")){$verf_foto_type_3="ok";}else{$verf_foto_type_3="error";}
			if($verf_foto_size_3=='ok' and $verf_foto_type_3=='ok'){
				$foto_3=$cedula . "_" . $nombre_prod . "_3.png";
			}else{
				$foto_3="vacio.png";
			}
		}
		//VERIFICANDO SI EXITE UN IMAGEN 4
		$verf_foto_size_4="error";
		$verf_foto_type_4="error";
		if(isset($_FILES['foto_4']['type'])){
			//PROCESAMIENTO DE IMAGEN 4
			$foto_type_4=$_FILES['foto_4']['type'];
			$foto_size_4=$_FILES['foto_4']['size'];
			$ruta_temporal_4=$_FILES['foto_4']['tmp_name'];
			$ruta_destino_con_foto_4=$url_sitio . "IMAGENES_PRODUCTOS/" . $cedula . "_" . $nombre_prod . "_4.png";
			$ruta_destino_sin_foto_4=$url_sitio . "IMAGENES_PRODUCTOS/vacio.png";
			//VERIFICANDO TAMAÑO DE LA IMAGEN
			if($foto_size_4>2000000){$verf_foto_size_4="error";}else{$verf_foto_size_4="ok";}
			//VERIFICANDO FORMATO DE LA IMAGEN
			if(strpos($foto_type_4,"png") or strpos($foto_type_4,"gif") or strpos($foto_type_4,"jpeg") or strpos($foto_type_4,"jpg")){$verf_foto_type_4="ok";}else{$verf_foto_type_4="error";}
			if($verf_foto_size_4=='ok' and $verf_foto_type_4=='ok'){
				$foto_4=$cedula . "_" . $nombre_prod . "_4.png";
			}else{
				$foto_4="vacio.png";
			}
		}
		//VERIFICANDO SI EXITE UN IMAGEN 5
		$verf_foto_size_5="error";
		$verf_foto_type_5="error";
		if(isset($_FILES['foto_5']['type'])){
			//PROCESAMIENTO DE IMAGEN 5
			$foto_type_5=$_FILES['foto_5']['type'];
			$foto_size_5=$_FILES['foto_5']['size'];
			$ruta_temporal_5=$_FILES['foto_5']['tmp_name'];
			$ruta_destino_con_foto_5=$url_sitio . "IMAGENES_PRODUCTOS/" . $cedula . "_" . $nombre_prod . "_5.png";
			$ruta_destino_sin_foto_5=$url_sitio . "IMAGENES_PRODUCTOS/vacio.png";
			//VERIFICANDO TAMAÑO DE LA IMAGEN
			if($foto_size_5>2000000){$verf_foto_size_5="error";}else{$verf_foto_size_5="ok";}
			//VERIFICANDO FORMATO DE LA IMAGEN
			if(strpos($foto_type_5,"png") or strpos($foto_type_5,"gif") or strpos($foto_type_5,"jpeg") or strpos($foto_type_5,"jpg")){$verf_foto_type_5="ok";}else{$verf_foto_type_5="error";}
			if($verf_foto_size_5=='ok' and $verf_foto_type_5=='ok'){
				$foto_5=$cedula . "_" . $nombre_prod . "_5.png";
			}else{
				$foto_5="vacio.png";
			}
		}
		//INSERTANDO DATOS
		$verf_insert=M_productos_y_servicios_C($conexion, $vendedor['NOMBRE'][0], $vendedor['APELLIDO'][0], $vendedor['CEDULA_RIF'][0], $vendedor['CORREO'][0], $vendedor['FECHA_NACIMIENTO'][0], $vendedor['EMPRESA'][0], $vendedor['TELEFONO'][0], $vendedor['DIRECCION'][0], $nombre_prod, $descripcion_prod, $caracteristicas_prod, $precio, $nuevo, $foto_1, $foto_2, $foto_3, $foto_4, $foto_5, $nombre_categoria, $nombre_etiqueta_1, $nombre_etiqueta_2, $nombre_etiqueta_3, $nombre_etiqueta_4, $nombre_etiqueta_5, $fh_creacion, $fh_modificacion, $und_venta, $cant_disponible, $cant_disponible_plan, $periodicidad_inv, "NO");
		//MOVIENDO FOTOS A LA CARPETA IMAGENES_PRODUCTOS
		if($verf_foto_size_1=='ok' and $verf_foto_type_1=='ok'){
			//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
			move_uploaded_file($ruta_temporal_1,$ruta_destino_con_foto_1);
		}
		if($verf_foto_size_2=='ok' and $verf_foto_type_2=='ok'){
			//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
			move_uploaded_file($ruta_temporal_2,$ruta_destino_con_foto_2);
		}
		if($verf_foto_size_3=='ok' and $verf_foto_type_3=='ok'){
			//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
			move_uploaded_file($ruta_temporal_3,$ruta_destino_con_foto_3);
		}
		if($verf_foto_size_4=='ok' and $verf_foto_type_4=='ok'){
			//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
			move_uploaded_file($ruta_temporal_4,$ruta_destino_con_foto_4);
		}
		if($verf_foto_size_5=='ok' and $verf_foto_type_5=='ok'){
			//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
			move_uploaded_file($ruta_temporal_5,$ruta_destino_con_foto_5);
		}
	}else if($_POST['FORM']=='MODIFICAR'){
		$id_producto=mysqli_real_escape_string($conexion,$_POST['id_producto']);
		$cedula=mysqli_real_escape_string($conexion,$_POST['cedula']);
		$vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $cedula, '', '', '', '');
		$nombre_prod=mysqli_real_escape_string($conexion,$_POST['nombre_prod']);
		$descripcion_prod=mysqli_real_escape_string($conexion,$_POST['descripcion_prod']);
		$caracteristicas_prod=mysqli_real_escape_string($conexion,$_POST['caracteristicas_prod']);
		$precio=mysqli_real_escape_string($conexion,$_POST['precio']);
		$nuevo=mysqli_real_escape_string($conexion,$_POST['nuevo']);
		$nombre_categoria=mysqli_real_escape_string($conexion,$_POST['nombre_categoria']);
		$nombre_etiqueta_1=mysqli_real_escape_string($conexion,$_POST['nombre_etiqueta_1']);
		$nombre_etiqueta_2=mysqli_real_escape_string($conexion,$_POST['nombre_etiqueta_2']);
		$nombre_etiqueta_3=mysqli_real_escape_string($conexion,$_POST['nombre_etiqueta_3']);
		$nombre_etiqueta_4=mysqli_real_escape_string($conexion,$_POST['nombre_etiqueta_4']);
		$nombre_etiqueta_5=mysqli_real_escape_string($conexion,$_POST['nombre_etiqueta_5']);
		$fh_creacion=mysqli_real_escape_string($conexion,$_POST['fh_creacion']);
		$fh_modificacion=date("Y-m-d h:m:s");
		$und_venta=mysqli_real_escape_string($conexion,$_POST['und_venta']);	
		$cant_disponible=mysqli_real_escape_string($conexion,$_POST['cant_disponible']);
		$cant_disponible_plan=mysqli_real_escape_string($conexion,$_POST['cant_disponible_plan']);	
		$periodicidad_inv=mysqli_real_escape_string($conexion,$_POST['periodicidad_inv']);
		//VERIFICANDO SI EXITE UN IMAGEN 1
		$verf_foto_size_1="error";
		$verf_foto_type_1="error";
		if(isset($_FILES['foto_1']['type'])){
			//PROCESAMIENTO DE IMAGEN 1
			$foto_type_1=$_FILES['foto_1']['type'];
			$foto_size_1=$_FILES['foto_1']['size'];
			$ruta_temporal_1=$_FILES['foto_1']['tmp_name'];
			$ruta_destino_con_foto_1=$url_sitio . "IMAGENES_PRODUCTOS/" . $cedula . "_" . $nombre_prod . "_1.png";
			$ruta_destino_sin_foto_1=$url_sitio . "IMAGENES_PRODUCTOS/vacio.png";
			//VERIFICANDO TAMAÑO DE LA IMAGEN
			if($foto_size_1>2000000){$verf_foto_size_1="error";}else{$verf_foto_size_1="ok";}
			//VERIFICANDO FORMATO DE LA IMAGEN
			if(strpos($foto_type_1,"png") or strpos($foto_type_1,"gif") or strpos($foto_type_1,"jpeg") or strpos($foto_type_1,"jpg")){$verf_foto_type_1="ok";}else{$verf_foto_type_1="error";}
			if($verf_foto_size_1=='ok' and $verf_foto_type_1=='ok'){
				$foto_1=$cedula . "_" . $nombre_prod . "_1.png";
			}else{
				$foto_1=mysqli_real_escape_string($conexion,$_POST['foto_1_previa']);
			}
		}else{
			$foto_1=mysqli_real_escape_string($conexion,$_POST['foto_1_previa']);
		}
		//VERIFICANDO SI EXITE UN IMAGEN 2
		$verf_foto_size_2="error";
		$verf_foto_type_2="error";
		if(isset($_FILES['foto_2']['type'])){
			//PROCESAMIENTO DE IMAGEN 2
			$foto_type_2=$_FILES['foto_2']['type'];
			$foto_size_2=$_FILES['foto_2']['size'];
			$ruta_temporal_2=$_FILES['foto_2']['tmp_name'];
			$ruta_destino_con_foto_2=$url_sitio . "IMAGENES_PRODUCTOS/" . $cedula . "_" . $nombre_prod . "_2.png";
			$ruta_destino_sin_foto_2=$url_sitio . "IMAGENES_PRODUCTOS/vacio.png";
			//VERIFICANDO TAMAÑO DE LA IMAGEN
			if($foto_size_2>2000000){$verf_foto_size_2="error";}else{$verf_foto_size_2="ok";}
			//VERIFICANDO FORMATO DE LA IMAGEN
			if(strpos($foto_type_2,"png") or strpos($foto_type_2,"gif") or strpos($foto_type_2,"jpeg") or strpos($foto_type_2,"jpg")){$verf_foto_type_2="ok";}else{$verf_foto_type_2="error";}
			if($verf_foto_size_2=='ok' and $verf_foto_type_2=='ok'){
				$foto_2=$cedula . "_" . $nombre_prod . "_2.png";
			}else{
				$foto_2=mysqli_real_escape_string($conexion,$_POST['foto_2_previa']);
			}
		}else{
			$foto_2=mysqli_real_escape_string($conexion,$_POST['foto_2_previa']);
		}
		//VERIFICANDO SI EXITE UN IMAGEN 3
		$verf_foto_size_3="error";
		$verf_foto_type_3="error";
		if(isset($_FILES['foto_3']['type'])){
			//PROCESAMIENTO DE IMAGEN 3
			$foto_type_3=$_FILES['foto_3']['type'];
			$foto_size_3=$_FILES['foto_3']['size'];
			$ruta_temporal_3=$_FILES['foto_3']['tmp_name'];
			$ruta_destino_con_foto_3=$url_sitio . "IMAGENES_PRODUCTOS/" . $cedula . "_" . $nombre_prod . "_3.png";
			$ruta_destino_sin_foto_3=$url_sitio . "IMAGENES_PRODUCTOS/vacio.png";
			//VERIFICANDO TAMAÑO DE LA IMAGEN
			if($foto_size_3>2000000){$verf_foto_size_3="error";}else{$verf_foto_size_3="ok";}
			//VERIFICANDO FORMATO DE LA IMAGEN
			if(strpos($foto_type_3,"png") or strpos($foto_type_3,"gif") or strpos($foto_type_3,"jpeg") or strpos($foto_type_3,"jpg")){$verf_foto_type_3="ok";}else{$verf_foto_type_3="error";}
			if($verf_foto_size_3=='ok' and $verf_foto_type_3=='ok'){
				$foto_3=$cedula . "_" . $nombre_prod . "_3.png";
			}else{
				$foto_3=mysqli_real_escape_string($conexion,$_POST['foto_3_previa']);
			}
		}else{
			$foto_3=mysqli_real_escape_string($conexion,$_POST['foto_3_previa']);
		}
		//VERIFICANDO SI EXITE UN IMAGEN 4
		$verf_foto_size_4="error";
		$verf_foto_type_4="error";
		if(isset($_FILES['foto_4']['type'])){
			//PROCESAMIENTO DE IMAGEN 4
			$foto_type_4=$_FILES['foto_4']['type'];
			$foto_size_4=$_FILES['foto_4']['size'];
			$ruta_temporal_4=$_FILES['foto_4']['tmp_name'];
			$ruta_destino_con_foto_4=$url_sitio . "IMAGENES_PRODUCTOS/" . $cedula . "_" . $nombre_prod . "_4.png";
			$ruta_destino_sin_foto_4=$url_sitio . "IMAGENES_PRODUCTOS/vacio.png";
			//VERIFICANDO TAMAÑO DE LA IMAGEN
			if($foto_size_4>2000000){$verf_foto_size_4="error";}else{$verf_foto_size_4="ok";}
			//VERIFICANDO FORMATO DE LA IMAGEN
			if(strpos($foto_type_4,"png") or strpos($foto_type_4,"gif") or strpos($foto_type_4,"jpeg") or strpos($foto_type_4,"jpg")){$verf_foto_type_4="ok";}else{$verf_foto_type_4="error";}
			if($verf_foto_size_4=='ok' and $verf_foto_type_4=='ok'){
				$foto_4=$cedula . "_" . $nombre_prod . "_4.png";
			}else{
				$foto_4=mysqli_real_escape_string($conexion,$_POST['foto_4_previa']);
			}
		}else{
			$foto_4=mysqli_real_escape_string($conexion,$_POST['foto_4_previa']);
		}
		//VERIFICANDO SI EXITE UN IMAGEN 5
		$verf_foto_size_5="error";
		$verf_foto_type_5="error";
		if(isset($_FILES['foto_5']['type'])){
			//PROCESAMIENTO DE IMAGEN 5
			$foto_type_5=$_FILES['foto_5']['type'];
			$foto_size_5=$_FILES['foto_5']['size'];
			$ruta_temporal_5=$_FILES['foto_5']['tmp_name'];
			$ruta_destino_con_foto_5=$url_sitio . "IMAGENES_PRODUCTOS/" . $cedula . "_" . $nombre_prod . "_5.png";
			$ruta_destino_sin_foto_5=$url_sitio . "IMAGENES_PRODUCTOS/vacio.png";
			//VERIFICANDO TAMAÑO DE LA IMAGEN
			if($foto_size_5>2000000){$verf_foto_size_5="error";}else{$verf_foto_size_5="ok";}
			//VERIFICANDO FORMATO DE LA IMAGEN
			if(strpos($foto_type_5,"png") or strpos($foto_type_5,"gif") or strpos($foto_type_5,"jpeg") or strpos($foto_type_5,"jpg")){$verf_foto_type_5="ok";}else{$verf_foto_type_5="error";}
			if($verf_foto_size_5=='ok' and $verf_foto_type_5=='ok'){
				$foto_5=$cedula . "_" . $nombre_prod . "_5.png";
			}else{
				$foto_5=mysqli_real_escape_string($conexion,$_POST['foto_5_previa']);
			}
		}else{
			$foto_5=mysqli_real_escape_string($conexion,$_POST['foto_5_previa']);
		}
		//ACTUALIZANDO DATOS EN LA BD
		M_productos_y_servicios_U_id($conexion, $id_producto, $vendedor['NOMBRE'][0], $vendedor['APELLIDO'][0], $vendedor['CEDULA_RIF'][0], $vendedor['CORREO'][0], $vendedor['FECHA_NACIMIENTO'][0], $vendedor['EMPRESA'][0], $vendedor['TELEFONO'][0], $vendedor['DIRECCION'][0], $nombre_prod, $descripcion_prod, $caracteristicas_prod, $precio, $nuevo, $foto_1, $foto_2, $foto_3, $foto_4, $foto_5, $nombre_categoria, $nombre_etiqueta_1, $nombre_etiqueta_2, $nombre_etiqueta_3, $nombre_etiqueta_4, $nombre_etiqueta_5, $fh_creacion, $fh_modificacion, $und_venta, $cant_disponible, $cant_disponible_plan, $periodicidad_inv);
		//PONIENDO PRODUCTO COMO no REVISADO
		M_productos_y_servicios_U_id_revisado($conexion, $id_producto, "NO");
		//MOVIENDO FOTOS A LA CARPETA IMAGENES_PRODUCTOS
		if($verf_foto_size_1=='ok' and $verf_foto_type_1=='ok'){
			//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
			if($_POST['foto_1_previa']<>"vacio.png"){
				unlink('IMAGENES_PRODUCTOS/' . $_POST['foto_1_previa']);
			}
			move_uploaded_file($ruta_temporal_1,$ruta_destino_con_foto_1);
		}
		if($verf_foto_size_2=='ok' and $verf_foto_type_2=='ok'){
			//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
			if($_POST['foto_2_previa']<>"vacio.png"){
				unlink('IMAGENES_PRODUCTOS/' . $_POST['foto_2_previa']);
			}
			move_uploaded_file($ruta_temporal_2,$ruta_destino_con_foto_2);
		}
		if($verf_foto_size_3=='ok' and $verf_foto_type_3=='ok'){
			//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
			if($_POST['foto_3_previa']<>"vacio.png"){
				unlink('IMAGENES_PRODUCTOS/' . $_POST['foto_3_previa']);
			}
			move_uploaded_file($ruta_temporal_3,$ruta_destino_con_foto_3);
		}
		if($verf_foto_size_4=='ok' and $verf_foto_type_4=='ok'){
			//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
			if($_POST['foto_4_previa']<>"vacio.png"){
				unlink('IMAGENES_PRODUCTOS/' . $_POST['foto_4_previa']);
			}
			move_uploaded_file($ruta_temporal_4,$ruta_destino_con_foto_4);
		}
		if($verf_foto_size_5=='ok' and $verf_foto_type_5=='ok'){
			//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
			if($_POST['foto_5_previa']<>"vacio.png"){
				unlink('IMAGENES_PRODUCTOS/' . $_POST['foto_5_previa']);
			}
			move_uploaded_file($ruta_temporal_5,$ruta_destino_con_foto_5);
		}
	}else if($_POST['FORM']=='BORRAR'){
		$id_producto=mysqli_real_escape_string($conexion,$_POST['id_producto']);
		$datos_prod_D=M_productos_y_servicios_R($conexion, 'ID_PRODUCTO', $id_producto, '', '', '', '');
		M_productos_y_servicios_D_id($conexion, $id_producto);
		if(isset($datos_prod_D['FOTO_1'][0])){
			if($datos_prod_D['FOTO_1'][0]<>'vacio.png'){
				unlink('IMAGENES_PRODUCTOS/' . $datos_prod_D['FOTO_1'][0]);
			}
		}
		if(isset($datos_prod_D['FOTO_2'][0])){
			if($datos_prod_D['FOTO_2'][0]<>'vacio.png'){
				unlink('IMAGENES_PRODUCTOS/' . $datos_prod_D['FOTO_2'][0]);
			}
		}
		if(isset($datos_prod_D['FOTO_3'][0])){
			if($datos_prod_D['FOTO_3'][0]<>'vacio.png'){
				unlink('IMAGENES_PRODUCTOS/' . $datos_prod_D['FOTO_3'][0]);
			}
		}
		if(isset($datos_prod_D['FOTO_4'][0])){
			if($datos_prod_D['FOTO_4'][0]<>'vacio.png'){
				unlink('IMAGENES_PRODUCTOS/' . $datos_prod_D['FOTO_4'][0]);
			}
		}
		if(isset($datos_prod_D['FOTO_5'][0])){
			if($datos_prod_D['FOTO_5'][0]<>'vacio.png'){
				unlink('IMAGENES_PRODUCTOS/' . $datos_prod_D['FOTO_5'][0]);
			}
		}
	//QUITANDO EL PRODUCTO DE TODOS LOS CARRITOS
	M_carrito_actualizar_producto_borrado($conexion, $id_producto);
	}
}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>Mis Productos</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid px-0 mx-0 mx-md-2 px-md-4 mt-2 mb-5 bg-secondary">
	<?php
	//VERIFICANDO Si SE MARCO ALGUNA OPCION EN LA TABLA PRINCIPAL DEL CRUD
	if(isset($_GET["accion"])){
			//SI SE QUIERE INSERTAR UN NUEVO RENGLON ENTONCES:
		if($_GET["accion"]=='insertar'){
	?>
		<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
			<div class="row mt-4 align-items-center rounded-top px-2">
				<div class="col-md-9 mb-1 mt-3">
					<h3 class="text-center text-md-left text-warning">Publicar nuevo Producto:</h3>
				</div>
				<div class="col-md-3 text-center text-md-right mb-1 mt-3">
					<a href="zona_usuario_prod_publicados.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
				</div>
			</div>
			<form action="zona_usuario_prod_publicados.php" method="post" class="text-center bg-dark p-2 rounded" enctype="multipart/form-data">
				<input type="hidden" name="FORM" id="FORM" value="INSERTAR">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Vendedor:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cedula" id="cedula" required autocomplete="off" title="Indique la cedula del usuario vendedor">
						<option value="<?php echo $datos_usuario_session['CEDULA_RIF'][0]; ?>"><?php echo $datos_usuario_session['CEDULA_RIF'][0]; ?> - <?php echo $datos_usuario_session['CORREO'][0]; ?></option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Nombre:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="nombre_prod" id="nombre_prod" placeholder="Introduzca el nombre del producto" required autocomplete="off" title="Introduzca el nombre del producto">
				</div>
				<div class="input-group mb-2 text-left">
					<span class="input-group-text rounded-0 w-100">Descripción:</span>
					<textarea class="form-control p-0 m-0 px-2 rounded-0" name="descripcion_prod" id="descripcion_prod" placeholder="Introduzca la Descripción del Producto" required autocomplete="off" title="Introduzca la Descripción del Producto" rows="2"></textarea>
				</div>
				<script>
					$(document).ready(function() {
						$('#descripcion_prod').summernote({
							placeholder: 'Introduzca la Descripción del Producto',
							tabsize: 1,
							height: 100								
						});
					});
				</script>
				<div class="input-group mb-2 text-left">
					<span class="input-group-text rounded-0 w-100">Características:</span>
					<textarea class="form-control p-0 m-0 px-2 rounded-0" name="caracteristicas_prod" id="caracteristicas_prod" placeholder="Introduzca las Características del Producto" autocomplete="off" title="Introduzca las Características del Producto" rows="2"></textarea>
				</div>
				<script>
					$(document).ready(function() {
						$('#caracteristicas_prod').summernote({
							placeholder: 'Introduzca las Características del Producto',
							tabsize: 1,
							height: 100								
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Precio Pm:</span>
					</div>
					<input type="number" class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="precio" id="precio" placeholder="Precio del Producto" required autocomplete="off" title="Introduzca Precio del Producto en Moneda Virtual" step="any" min="0">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">¿Producto Nuevo?</span>
					</div>
					<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="nuevo" id="nuevo" required autocomplete="off" title="Indique si el producto es nuevo o no">
						<option></option>
						<option>SI</option>
						<option>NO</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Unidad de Venta:</span>
					</div>
					<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="und_venta" id="und_venta" required autocomplete="off" title="Indique la unidad en la que se va a vender el producto">
						<option></option>
						<?php
							$unidades_venta=M_unidades_de_venta();
							$i=0;
							while(isset($unidades_venta[$i])){
								echo "<option>" . $unidades_venta[$i] . "</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cantidad Disponible:</span>
					</div>
					<input type="number" class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="cant_disponible" id="cant_disponible" placeholder="Cantidad disponible para la venta" required autocomplete="off" title="Cantidad disponible para la venta">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-6 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Restablecer Inventario (Periodo):</span>
					</div>
					<select class="form-control col-md-6 p-0 m-0 px-2 rounded-0" name="periodicidad_inv" id="periodicidad_inv" required autocomplete="off" title="Indique el periodo en el que se debe restablecer su inventario para este producto de forma automática">
						<option></option>
						<?php
							$unidades_periodo=M_periodos_restablecer_inventario();
							$i=0;
							while(isset($unidades_periodo[$i])){
								echo "<option>" . $unidades_periodo[$i] . "</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cantidad a Restablecer:</span>
					</div>
					<input type="number" class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="cant_disponible_plan" id="cant_disponible_plan" placeholder="Cantidad a restablecer" required autocomplete="off" title="Cantidad que quedará disponible al restablecer el inventario">
				</div>
				<h4 class="text-center text-warning">Categoría y Etiquetas:</h4>
				<h6 class="text-center text-light" title="Indique la categoría y etiquetas que se asociarán al producto">(Puede elegir hasta 5 etiquetas)</h6>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Categoria:</span>
					</div>
					<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="nombre_categoria" id="nombre_categoria" required autocomplete="off" title="Indique la categoria del producto">
						<option></option>
						<?php
							$categorias_disponibles=M_categorias_R_todo($conexion);
							$i=0;
							while(isset($categorias_disponibles['ID_CATEGORIA'][$i])){
								echo "<option>" . $categorias_disponibles['NOMBRE_CATEGORIA'][$i] . "</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Etiqueta 1 (<b class="text-danger">Requerida</b>):</span>
					</div>
					<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="nombre_etiqueta_1" id="nombre_etiqueta_1" required autocomplete="off" title="Indique la etiqueta del producto">
						<option></option>
						<?php
							$etiquetas_disponibles=M_etiquetas_R_todo($conexion);
							$i=0;
							while(isset($etiquetas_disponibles['ID_ETIQUETA'][$i])){
								echo "<option>" . $etiquetas_disponibles['NOMBRE_ETIQUETA'][$i] . "</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Etiqueta 2 (Opcional):</span>
					</div>
					<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="nombre_etiqueta_2" id="nombre_etiqueta_2" autocomplete="off" title="Indique la etiqueta del producto">
						<option></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#nombre_etiqueta_1").on('change', function(){
							var etq_1=$("#nombre_etiqueta_1").val();
							$.ajax("PHP_MODELO/S_etiquetas.php",{data:{etq_1:etq_1, etq_2:"", etq_3:"", etq_4:""}, type:'post'}).done(function(respuesta){
								$("#nombre_etiqueta_2").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Etiqueta 3 (Opcional):</span>
					</div>
					<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="nombre_etiqueta_3" id="nombre_etiqueta_3" autocomplete="off" title="Indique la etiqueta del producto">
						<option></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#nombre_etiqueta_2").on('change', function(){
							var etq_1=$("#nombre_etiqueta_1").val();
							var etq_2=$("#nombre_etiqueta_2").val();
							$.ajax("PHP_MODELO/S_etiquetas.php",{data:{etq_1:etq_1, etq_2:etq_2, etq_3:"", etq_4:""}, type:'post'}).done(function(respuesta){
								$("#nombre_etiqueta_3").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Etiqueta 4 (Opcional):</span>
					</div>
					<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="nombre_etiqueta_4" id="nombre_etiqueta_4" autocomplete="off" title="Indique la etiqueta del producto">
						<option></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#nombre_etiqueta_3").on('change', function(){
							var etq_1=$("#nombre_etiqueta_1").val();
							var etq_2=$("#nombre_etiqueta_2").val();
							var etq_3=$("#nombre_etiqueta_3").val();
							$.ajax("PHP_MODELO/S_etiquetas.php",{data:{etq_1:etq_1, etq_2:etq_2, etq_3:etq_3, etq_4:""}, type:'post'}).done(function(respuesta){
								$("#nombre_etiqueta_4").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Etiqueta 5 (Opcional):</span>
					</div>
					<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="nombre_etiqueta_5" id="nombre_etiqueta_5" autocomplete="off" title="Indique la etiqueta del producto">
						<option></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#nombre_etiqueta_4").on('change', function(){
							var etq_1=$("#nombre_etiqueta_1").val();
							var etq_2=$("#nombre_etiqueta_2").val();
							var etq_3=$("#nombre_etiqueta_3").val();
							var etq_4=$("#nombre_etiqueta_4").val();
							$.ajax("PHP_MODELO/S_etiquetas.php",{data:{etq_1:etq_1, etq_2:etq_2, etq_3:etq_3, etq_4:etq_4}, type:'post'}).done(function(respuesta){
								$("#nombre_etiqueta_5").html(respuesta);
							});
						});
					});
				</script>
				<h4 class="text-center text-warning">Fotos del Producto:</h4>
				<h6 class="text-center text-light small" title="Adjunte las Foto del Producto (Hasta 5 fotos en formato jpg, jpej, gif o png y máximo 2 MegaBytes)">Hasta 5 fotos. Sólo archivos jpg, jpeg, gif o png y máximo 2 MegaBytes</h6>
				<h6 class="text-center text-light small">Puedes convertir imágenes a formato png <a class="text-warning" href="https://convertio.co/es/jpg-png/" target="_blank">AQUÍ</a></h6>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Foto Principal (<b class="text-danger">Requerida</b>):</span>
					</div>
					<div class="form-control col-md-7 p-0 m-0 px-2 rounded-0">
						<input type='file' name='foto_1' id='foto_1' class="w-100 bg-light text-dark rounded-0 pt-1" title="Adjunte Foto Principal del Producto (en formato png y máximo 2 MegaBytes)" required>
					</div>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Foto Adicional 1 (Opcional):</span>
					</div>
					<div class="form-control col-md-7 p-0 m-0 px-2 rounded-0">
						<input type='file' name='foto_2' id='foto_2' class="w-100 bg-light text-dark rounded-0 pt-1" title="Adjunte Foto 2 del Producto (en formato png y máximo 2 MegaBytes)">
					</div>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Foto Adicional 2 (Opcional):</span>
					</div>
					<div class="form-control col-md-7 p-0 m-0 px-2 rounded-0">
						<input type='file' name='foto_3' id='foto_3' class="w-100 bg-light text-dark rounded-0 pt-1" title="Adjunte Foto 3 del Producto (en formato png y máximo 2 MegaBytes)">
					</div>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Foto Adicional 3 (Opcional):</span>
					</div>
					<div class="form-control col-md-7 p-0 m-0 px-2 rounded-0">
						<input type='file' name='foto_4' id='foto_4' class="w-100 bg-light text-dark rounded-0 pt-1" title="Adjunte Foto 4 del Producto (en formato png y máximo 2 MegaBytes)">
					</div>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Foto Adicional 4 (Opcional):</span>
					</div>
					<div class="form-control col-md-7 p-0 m-0 px-2 rounded-0">
						<input type='file' name='foto_5' id='foto_5' class="w-100 bg-light text-dark rounded-0 pt-1" title="Adjunte Foto 5 del Producto (en formato png y máximo 2 MegaBytes)">
					</div>
				</div>
				<div class="m-auto">
					<a href="zona_usuario_prod_publicados.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Insertar Producto" class="btn btn-warning mb-2">
				</div>
			</form>
		</div>
		<?php
			// -------------    SI SE QUIERE MODIFICAR UN RENGLON ENTONCES --------------  :
			}else if($_GET["accion"]=='actualizar'){
				$datos_actualizar=M_productos_y_servicios_R($conexion, 'ID_PRODUCTO', $_GET['NA_Id'], '', '', '', '');
		?>
		<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
			<div class="row mt-4 align-items-center rounded-top px-2">
				<div class="col-md-9 mb-1 mt-3">
					<h3 class="text-center text-md-left text-warning">Modificar Producto:</h3>
				</div>
				<div class="col-md-3 text-center text-md-right mb-1 mt-3">
					<a href="zona_usuario_prod_publicados.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
				</div>
			</div>
			<form action="zona_usuario_prod_publicados.php" method="post" class="text-center bg-dark p-2 rounded" enctype="multipart/form-data">
				<input type="hidden" name="FORM" id="FORM" value="MODIFICAR">
				<input type="hidden" name="id_producto" id="id_producto" value="<?php echo $datos_actualizar['ID_PRODUCTO'][0]; ?>">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Vendedor:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cedula" id="cedula" required autocomplete="off" title="Indique la cedula del usuario vendedor">
						<option value="<?php echo $datos_actualizar['CEDULA_RIF'][0]; ?>"><?php echo $datos_actualizar['CEDULA_RIF'][0]; ?> - <?php echo $datos_actualizar['CORREO'][0]; ?></option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Nombre:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="nombre_prod" id="nombre_prod" placeholder="Introduzca el nombre del producto" required autocomplete="off" title="Introduzca el nombre del producto" value="<?php echo $datos_actualizar['NOMBRE_PRODUCTO'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Fecha Creado:</span>
					</div>
					<input type="hidden" name="fh_creacion" id="fh_creacion" value="<?php echo $datos_actualizar['FH_CREACION'][0]; ?>">
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="fh_creacion_vista" id="fh_creacion_vista" placeholder="Fecha de Creación" required autocomplete="off" title="Fecha de Creación" value="<?php echo $datos_actualizar['FH_CREACION'][0]; ?>" disabled>
				</div>
				<div class="input-group mb-2 text-left">
					<span class="input-group-text rounded-0 w-100">Descripción:</span>
					<textarea class="form-control p-0 m-0 px-2 rounded-0" name="descripcion_prod" id="descripcion_prod" placeholder="Introduzca la Descripción del Producto" required autocomplete="off" title="Introduzca la Descripción del Producto" rows="2"><?php echo $datos_actualizar['DESCRIPCION_PRODUCTO'][0]; ?></textarea>
				</div>
				<script>
					$(document).ready(function() {
						$('#descripcion_prod').summernote({
							placeholder: 'Introduzca la Descripción del Producto',
							tabsize: 1,
							height: 100								
						});
					});
				</script>
				<div class="input-group mb-2 text-left">
					<span class="input-group-text rounded-0 w-100">Características:</span>
					<textarea class="form-control p-0 m-0 px-2 rounded-0" name="caracteristicas_prod" id="caracteristicas_prod" placeholder="Introduzca las Características del Producto" autocomplete="off" title="Introduzca las Características del Producto" rows="2"><?php echo $datos_actualizar['CARACTERISTICAS_PRODUCTO'][0]; ?></textarea>
				</div>
				<script>
					$(document).ready(function() {
						$('#caracteristicas_prod').summernote({
							placeholder: 'Introduzca las Características del Producto',
							tabsize: 1,
							height: 100								
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Precio Pm:</span>
					</div>
					<input type="number" class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="precio" id="precio" placeholder="Precio del Producto" required autocomplete="off" title="Introduzca Precio del Producto" step="any" min="0" value="<?php echo $datos_actualizar['PRECIO_UNITARIO_MICOIN'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">¿Producto Nuevo?</span>
					</div>
					<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="nuevo" id="nuevo" required autocomplete="off" title="Indique si el producto es nuevo o no">
						<option><?php echo $datos_actualizar['NUEVO'][0]; ?></option>
						<option>SI</option>
						<option>NO</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Unidad de Venta:</span>
					</div>
					<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="und_venta" id="und_venta" required autocomplete="off" title="Indique la unidad en la que se va a vender el producto">
						<option><?php echo $datos_actualizar['UNIDAD_DE_VENTA'][0]; ?></option>
						<?php
							$unidades_venta=M_unidades_de_venta();
							$i=0;
							while(isset($unidades_venta[$i])){
								echo "<option>" . $unidades_venta[$i] . "</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cantidad Disponible:</span>
					</div>
					<input type="number" class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="cant_disponible" id="cant_disponible" placeholder="Cantidad disponible para la venta" required autocomplete="off" title="Cantidad disponible para la venta" value="<?php echo $datos_actualizar['CANTIDAD_DISPONIBLE'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-6 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Restablecer Inventario (Periodo):</span>
					</div>
					<select class="form-control col-md-6 p-0 m-0 px-2 rounded-0" name="periodicidad_inv" id="periodicidad_inv" required autocomplete="off" title="Indique el periodo en el que se debe restablecer su inventario para este producto de forma automática">
						<option><?php echo $datos_actualizar['REESTABLECER_INVENTARIO_PERIODICIDAD'][0]; ?></option>
						<?php
							$unidades_periodo=M_periodos_restablecer_inventario();
							$i=0;
							while(isset($unidades_periodo[$i])){
								echo "<option>" . $unidades_periodo[$i] . "</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cantidad a Restablecer:</span>
					</div>
					<input type="number" class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="cant_disponible_plan" id="cant_disponible_plan" placeholder="Cantidad a restablecer" required autocomplete="off" title="Cantidad que quedará disponible al restablecer el inventario" value="<?php echo $datos_actualizar['CANTIDAD_DISPONIBLE_PLAN'][0]; ?>">
				</div>
				<h4 class="text-center text-warning">Categoría y Etiquetas:</h4>
				<h6 class="text-center text-light" title="Indique la categoría y etiquetas que se asociarán al producto">(Puede elegir hasta 5 etiquetas)</h6>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Categoria:</span>
					</div>
					<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="nombre_categoria" id="nombre_categoria" required autocomplete="off" title="Indique la categoria del producto">
						<option><?php echo $datos_actualizar['NOMBRE_CATEGORIA'][0]; ?></option>
						<?php
							$categorias_disponibles=M_categorias_R_todo($conexion);
							$i=0;
							while(isset($categorias_disponibles['ID_CATEGORIA'][$i])){
								echo "<option>" . $categorias_disponibles['NOMBRE_CATEGORIA'][$i] . "</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Etiqueta 1 (<b class="text-danger">Requerida</b>):</span>
					</div>
					<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="nombre_etiqueta_1" id="nombre_etiqueta_1" required autocomplete="off" title="Indique la etiqueta del producto">
						<option><?php echo $datos_actualizar['NOMBRE_ETIQUETA_1'][0]; ?></option>
						<?php
							$etiquetas_disponibles=M_etiquetas_R_todo($conexion);
							$i=0;
							while(isset($etiquetas_disponibles['ID_ETIQUETA'][$i])){
								echo "<option>" . $etiquetas_disponibles['NOMBRE_ETIQUETA'][$i] . "</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Etiqueta 2 (Opcional):</span>
					</div>
					<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="nombre_etiqueta_2" id="nombre_etiqueta_2" autocomplete="off" title="Indique la etiqueta del producto">
						<option><?php echo $datos_actualizar['NOMBRE_ETIQUETA_2'][0]; ?></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#nombre_etiqueta_1").on('change', function(){
							var etq_1=$("#nombre_etiqueta_1").val();
							$.ajax("PHP_MODELO/S_etiquetas.php",{data:{etq_1:etq_1, etq_2:"", etq_3:"", etq_4:""}, type:'post'}).done(function(respuesta){
								$("#nombre_etiqueta_2").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Etiqueta 3 (Opcional):</span>
					</div>
					<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="nombre_etiqueta_3" id="nombre_etiqueta_3" autocomplete="off" title="Indique la etiqueta del producto">
						<option><?php echo $datos_actualizar['NOMBRE_ETIQUETA_3'][0]; ?></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#nombre_etiqueta_2").on('change', function(){
							var etq_1=$("#nombre_etiqueta_1").val();
							var etq_2=$("#nombre_etiqueta_2").val();
							$.ajax("PHP_MODELO/S_etiquetas.php",{data:{etq_1:etq_1, etq_2:etq_2, etq_3:"", etq_4:""}, type:'post'}).done(function(respuesta){
								$("#nombre_etiqueta_3").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Etiqueta 4 (Opcional):</span>
					</div>
					<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="nombre_etiqueta_4" id="nombre_etiqueta_4" autocomplete="off" title="Indique la etiqueta del producto">
						<option><?php echo $datos_actualizar['NOMBRE_ETIQUETA_4'][0]; ?></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#nombre_etiqueta_3").on('change', function(){
							var etq_1=$("#nombre_etiqueta_1").val();
							var etq_2=$("#nombre_etiqueta_2").val();
							var etq_3=$("#nombre_etiqueta_3").val();
							$.ajax("PHP_MODELO/S_etiquetas.php",{data:{etq_1:etq_1, etq_2:etq_2, etq_3:etq_3, etq_4:""}, type:'post'}).done(function(respuesta){
								$("#nombre_etiqueta_4").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-5 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Etiqueta 5 (Opcional):</span>
					</div>
					<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="nombre_etiqueta_5" id="nombre_etiqueta_5" autocomplete="off" title="Indique la etiqueta del producto">
						<option><?php echo $datos_actualizar['NOMBRE_ETIQUETA_5'][0]; ?></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#nombre_etiqueta_4").on('change', function(){
							var etq_1=$("#nombre_etiqueta_1").val();
							var etq_2=$("#nombre_etiqueta_2").val();
							var etq_3=$("#nombre_etiqueta_3").val();
							var etq_4=$("#nombre_etiqueta_4").val();
							$.ajax("PHP_MODELO/S_etiquetas.php",{data:{etq_1:etq_1, etq_2:etq_2, etq_3:etq_3, etq_4:etq_4}, type:'post'}).done(function(respuesta){
								$("#nombre_etiqueta_5").html(respuesta);
							});
						});
					});
				</script>
				<h4 class="text-center text-warning">Fotos del Producto:</h4>
				<h6 class="text-center text-light small" title="Adjunte las Foto del Producto (Hasta 5 fotos en formato jpg, jpej, gif o png y máximo 2 MegaBytes)">Hasta 5 fotos. Sólo archivos jpg, jpeg, gif o png y máximo 2 MegaBytes</h6>
				<h6 class="text-center text-light small">Puedes convertir imágenes a formato png <a class="text-warning" href="https://convertio.co/es/jpg-png/" target="_blank">AQUÍ</a></h6>
				<div class="row mb-2">
					<div class="col-2">
						<img src="IMAGENES_PRODUCTOS/<?php echo $datos_actualizar['FOTO_1'][0] . "?a=" . rand(); ?>" class="imgFit">
					</div>
					<div class="col-10">
						<div class="input-group mb-2">
							<div class="col-md-5 p-0 m-0">
								<span class="input-group-text rounded-0 w-100">Foto Principal:</span>
							</div>
							<div class="form-control col-md-7 p-0 m-0 px-2 rounded-0">
								<input type="hidden" name='foto_1_previa' id='foto_1_previa' value="<?php echo $datos_actualizar['FOTO_1'][0]; ?>">
								<input type='file' name='foto_1' id='foto_1' class="w-100 bg-light text-dark rounded-0 pt-1" title="Adjunte Foto Principal del Producto (en formato png y máximo 2 MegaBytes)">
							</div>
						</div>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-2">
						<img src="IMAGENES_PRODUCTOS/<?php echo $datos_actualizar['FOTO_2'][0] . "?a=" . rand(); ?>" class="imgFit">
					</div>
					<div class="col-10">
						<div class="input-group mb-2">
							<div class="col-md-5 p-0 m-0">
								<span class="input-group-text rounded-0 w-100">Foto Adicional 1 (Opcional):</span>
							</div>
							<div class="form-control col-md-7 p-0 m-0 px-2 rounded-0">
								<input type="hidden" name='foto_2_previa' id='foto_2_previa' value="<?php echo $datos_actualizar['FOTO_2'][0]; ?>">
								<input type='file' name='foto_2' id='foto_2' class="w-100 bg-light text-dark rounded-0 pt-1" title="Adjunte Foto 2 del Producto (en formato png y máximo 2 MegaBytes)">
							</div>
						</div>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-2">
						<img src="IMAGENES_PRODUCTOS/<?php echo $datos_actualizar['FOTO_3'][0] . "?a=" . rand(); ?>" class="imgFit">
					</div>
					<div class="col-10">
						<div class="input-group mb-2">
							<div class="col-md-5 p-0 m-0">
								<span class="input-group-text rounded-0 w-100">Foto Adicional 2 (Opcional):</span>
							</div>
							<div class="form-control col-md-7 p-0 m-0 px-2 rounded-0">
								<input type="hidden" name='foto_3_previa' id='foto_3_previa' value="<?php echo $datos_actualizar['FOTO_3'][0]; ?>">
								<input type='file' name='foto_3' id='foto_3' class="w-100 bg-light text-dark rounded-0 pt-1" title="Adjunte Foto 3 del Producto (en formato png y máximo 2 MegaBytes)">
							</div>
						</div>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-2">
						<img src="IMAGENES_PRODUCTOS/<?php echo $datos_actualizar['FOTO_4'][0] . "?a=" . rand(); ?>" class="imgFit">
					</div>
					<div class="col-10">
						<div class="input-group mb-2">
							<div class="col-md-5 p-0 m-0">
								<span class="input-group-text rounded-0 w-100">Foto Adicional 3 (Opcional):</span>
							</div>
							<div class="form-control col-md-7 p-0 m-0 px-2 rounded-0">
								<input type="hidden" name='foto_4_previa' id='foto_4_previa' value="<?php echo $datos_actualizar['FOTO_4'][0]; ?>">
								<input type='file' name='foto_4' id='foto_4' class="w-100 bg-light text-dark rounded-0 pt-1" title="Adjunte Foto 4 del Producto (en formato png y máximo 2 MegaBytes)">
							</div>
						</div>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-2">
						<img src="IMAGENES_PRODUCTOS/<?php echo $datos_actualizar['FOTO_5'][0] . "?a=" . rand(); ?>" class="imgFit">
					</div>
					<div class="col-10">
						<div class="input-group mb-2">
							<div class="col-md-5 p-0 m-0">
								<span class="input-group-text rounded-0 w-100">Foto Adicional 4 (Opcional):</span>
							</div>
							<div class="form-control col-md-7 p-0 m-0 px-2 rounded-0">
								<input type="hidden" name='foto_5_previa' id='foto_5_previa' value="<?php echo $datos_actualizar['FOTO_5'][0]; ?>">
								<input type='file' name='foto_5' id='foto_5' class="w-100 bg-light text-dark rounded-0 pt-1" title="Adjunte Foto 5 del Producto (en formato png y máximo 2 MegaBytes)">
							</div>
						</div>
					</div>
				</div>
				<div class="m-auto">
					<a href="zona_usuario_prod_publicados.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Modificar Producto" class="btn btn-warning mb-2">
				</div>
			</form>
		</div>
	<?php
		//SI SE QUIERE BORRAR UN RENGLON ENTONCES:
	}else if($_GET["accion"]=='borrar'){
		?>
		<br><br><br>
		<div class="col-md-12 col-lg-9 mx-auto">
			<form action="zona_usuario_prod_publicados.php" method="post" class="text-center bg-dark p-2 rounded">
				<h3 class="text-center text-light pb-3">¿Seguro que desea Borrar este Producto?</h3>
				<input type="hidden" name="FORM" id="FORM" value="BORRAR">
				<input type="hidden" name="id_producto" id="id_producto" value="<?php echo $_GET["NA_Id"]; ?>">
				<div class="m-auto">
					<a href="zona_usuario_prod_publicados.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Borrar Producto" class="btn btn-warning mb-2">
				</div>
			</form>
			<br><br><br><br><br><br><br><br>
		</div>
		<?php
			//SI NO SE HIZO NINGUNA ACCIÓN:
		}else{
		?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=zona_usuario_prod_publicados.php">
	<?php
	//CIERRE DE LA ETIQUETA PARA EMBUTIR HTML EN PHP
		}
	}else{
	?>
	<!-- DataTables Example -->
	<?php
	if(isset($verf_insert)){
		if($verf_insert==false){
			echo "<h3 class='text-center text-dark bg-danger my-2 py-2'>El Producto que está intentando agregar <b>YA EXISTE</b></h3>";
		}
	}
	?>
	<div class="card mb-3 bg-dark rounded-0">
		<div class="card-header text-center text-warning">
			<h3 class='text-center'>Mis Productos Publicados:</h3>
		</div>
		<div class="card-body px-1 bg-white">
			<div class="table-responsive">
				<table class="table table-bordered table-hover TablaDinamica">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b title="Foto, Nombre, Precio Unitario, Cantidad Disponible y Categoría del Producto">Producto</b></th>
							<th class="align-middle h5 p-0"><a title="Publicar Nuevo Producto" href="zona_usuario_prod_publicados.php?accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Publicar</a></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//obteniendo los datos de la tabla:
						$datos=M_productos_y_servicios_R($conexion, 'CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], '', '', '', '');
						$i=0;
						while(isset($datos['ID_PRODUCTO'][$i])){
							if($datos['ID_PRODUCTO'][$i]<>""){
								echo "<tr>";
								echo "<td class='text-left'><div class='Container'><div class='row'><div class='col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2 ml-0'><img src='IMAGENES_PRODUCTOS/" . $datos['FOTO_1'][$i] . "?a=" . rand() . "' class='w-100 imgFit'></div><div class='col-12 col-sm-7 col-md-8 col-lg-9 col-xl-10 ml-0'><b class='text-danger'>" . $datos['NOMBRE_PRODUCTO'][$i] . "</b><br>";
								echo "<b>P/U:</b> " . $datos['PRECIO_UNITARIO_MICOIN'][$i] . " Pm/" . $datos['UNIDAD_DE_VENTA'][$i] . "<br><b>Disponible:</b> " . $datos['CANTIDAD_DISPONIBLE'][$i] . "<br><b>Categoría:</b> " . $datos['NOMBRE_CATEGORIA'][$i] . "</div></div></td>";
								echo "<td class='text-center h5'><a title='Ver publicación' href='zona_usuario_detalle_producto.php?id_producto=" . $datos['ID_PRODUCTO'][$i] . "' class='btn btn-transparent text-primary fa fa-eye d-inline'></a>";
								echo "<br>";
								echo "<a title='Modificar' href='zona_usuario_prod_publicados.php?accion=actualizar&NA_Id=" . $datos['ID_PRODUCTO'][$i] . "' class='btn btn-transparent text-success fa fa-edit d-inline'></a>";
								echo "<br>";
								echo "<a title='Eliminar' href='zona_usuario_prod_publicados.php?accion=borrar&NA_Id=" . $datos['ID_PRODUCTO'][$i] . "' class='btn btn-transparent text-danger fa fa-trash-o d-inline'></a>";
								echo "</td></tr>";
							}
							$i=$i+1;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<?php
	//CIERRE DE LA ETIQUETA PARA EMBUTIR HTML EN PHP		
	}
	?>	
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>