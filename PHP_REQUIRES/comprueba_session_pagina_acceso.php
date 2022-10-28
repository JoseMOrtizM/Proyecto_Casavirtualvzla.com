<?php
	session_start();
	//AQUI SE GENERAN LOS DATOS DE LA SESION DE USUARIO, NOMBRE DE PAGINA Y RESTRICCIONES DE ACCESO
	//VERIFICANDO SESSION
	if(!isset($_SESSION["usuario"])){
		header("location:salir.php");
	}
	//CERRANDO SESSION POR TIEMPO DE INACTIVIDAD
	$tiempo_maximo_de_inactividad=900;
	if (!isset($_SESSION['tiempo'])) {
		$_SESSION['tiempo']=time();
	}
	else if (time()-$_SESSION['tiempo']>$tiempo_maximo_de_inactividad) {
		header("location:salir.php");
	}
	$_SESSION['tiempo']=time(); //Si hay actividad seteamos el valor al tiempo actual
	//OBTENIENDO NOMBRE DEL ARCHIVO PHP ACTUAL
	$ruta_actual=$_SERVER["REQUEST_URI"];
	$partes1=explode("/",$ruta_actual);
	$i=0;
	while(isset($partes1[$i])==true){
		$ruta_actual=$partes1[$i];
		$i=$i+1;
	}
	$partes2=explode("?",$ruta_actual);
	$ruta_actual=$partes2[0];
	// RESCATANDO DATOS DE USUARIO
	unset($datos_usuario_session);
	$datos_usuario_session=M_usuarios_R($conexion, 'CORREO', $_SESSION["usuario"], '', '', '', '');
	//VERIFICANDO USUARIO ACTIVO
	if($datos_usuario_session['ESTATUS'][0]<>'ACTIVO'){
		header("location:salir.php");
	}
	//AQUI VAN LAS EXCLUSIONES POR NIVEL DE ACCESO SEGÚN EL NOMBRE DE LA PÁGINA
	if($ruta_actual=='CRUD_compra_venta_de_micoin.php' or 
	   $ruta_actual=='CRUD_control_de_transacciones_micoin.php' or 
	   $ruta_actual=='CRUD_paridad_cambiaria.php' or 
	   $ruta_actual=='zona_adm_aprobar_pemon.php' or 
	   $ruta_actual=='zona_adm_balance_excel.php' or 
	   $ruta_actual=='zona_adm_balance_pdf.php' or 
	   $ruta_actual=='zona_adm_cambio_bs_x_dollar.php' or 
	   $ruta_actual=='zona_adm_indicadores.php' or 
	   $ruta_actual=='zona_adm_operaciones_con_dollar.php' or 
	   $ruta_actual=='zona_adm_otras_operaciones.php' or 
	   $ruta_actual=='CRUD_blog_externo.php' or 
	   $ruta_actual=='CRUD_blog_interno.php' or 
	   $ruta_actual=='CRUD_categorias.php' or 
	   $ruta_actual=='CRUD_ciudades.php' or 
	   $ruta_actual=='CRUD_etiquetas.php' or 
	   $ruta_actual=='CRUD_historial_de_busqueda.php' or 
	   $ruta_actual=='CRUD_parroquias.php' or 
	   $ruta_actual=='CRUD_productos.php' or 
	   $ruta_actual=='CRUD_usuarios.php' or 
	   $ruta_actual=='CRUD_preguntas_al_vendedor.php' or 
	   $ruta_actual=='zona_adm_actualizar_inventario.php' or 
	   $ruta_actual=='zona_adm_actualizar_rankings.php' or 
	   $ruta_actual=='zona_adm_editar_imagen.php' or 
	   $ruta_actual=='zona_adm_respaldar_bd.php'){
		if($datos_usuario_session['ACCESO'][0]=='ADMINISTRADOR'){
			//PERMITIR EL ACCESO
		}else{
			if($ruta_actual=='CRUD_blog_externo.php' or 
			   $ruta_actual=='CRUD_blog_interno.php' or 
			   $ruta_actual=='CRUD_categorias.php' or 
			   $ruta_actual=='CRUD_ciudades.php' or 
			   $ruta_actual=='CRUD_etiquetas.php' or 
			   $ruta_actual=='CRUD_historial_de_busqueda.php' or 
			   $ruta_actual=='CRUD_parroquias.php' or 
			   $ruta_actual=='CRUD_productos.php' or 
			   $ruta_actual=='CRUD_usuarios.php' or 
			   $ruta_actual=='CRUD_preguntas_al_vendedor.php' or 
			   $ruta_actual=='zona_adm_actualizar_inventario.php' or 
			   $ruta_actual=='zona_adm_actualizar_rankings.php'){
				if($datos_usuario_session['ACCESO'][0]=='ANALISTA'){
					//PERMITIR EL ACCESO
				}else{
					header("location:salir.php");
				}
			}
			header("location:salir.php");
		}
	}
	//INSERTANDO DATOS DE NAVEGACIÓN Y BÚSQUEDA EN LA BASE DE DATOS
	if(isset($_GET['id_producto'])){
		$id_prod_i=mysqli_real_escape_string($conexion,$_GET['id_producto']);
		$ruta_actual=$ruta_actual . "?id_producto=" . $id_prod_i;
	}
	if(isset($_POST['buscar'])){
		if($_POST['buscar']<>''){
			M_historial_de_busqueda_C($conexion, 'INTERNO', 
				M_obtener_ip_real(), 
				$datos_usuario_session['NOMBRE'][0], 
				$datos_usuario_session['APELLIDO'][0], 
				$datos_usuario_session['CEDULA_RIF'][0], 
				$datos_usuario_session['CORREO'][0], 
				$datos_usuario_session['FECHA_NACIMIENTO'][0], 
				date("Y-m-d h:m:s"), 
				$ruta_actual, 
				mysqli_real_escape_string($conexion,$_POST['buscar']));
		}else{
			M_historial_de_busqueda_C($conexion, 'INTERNO', 
				M_obtener_ip_real(), 
				$datos_usuario_session['NOMBRE'][0], 
				$datos_usuario_session['APELLIDO'][0], 
				$datos_usuario_session['CEDULA_RIF'][0], 
				$datos_usuario_session['CORREO'][0], 
				$datos_usuario_session['FECHA_NACIMIENTO'][0], 
				date("Y-m-d h:m:s"), 
				$ruta_actual, 
				'');
		}
	}else{
		M_historial_de_busqueda_C($conexion, 'INTERNO', 
			M_obtener_ip_real(), 
			$datos_usuario_session['NOMBRE'][0], 
			$datos_usuario_session['APELLIDO'][0], 
			$datos_usuario_session['CEDULA_RIF'][0], 
			$datos_usuario_session['CORREO'][0], 
			$datos_usuario_session['FECHA_NACIMIENTO'][0], 
			date("Y-m-d h:m:s"), 
			$ruta_actual, 
			'');
	}
?>
