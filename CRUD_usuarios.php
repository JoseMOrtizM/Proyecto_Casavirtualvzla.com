<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
if(isset($_POST['FORM'])){
	if($_POST['FORM']=='INSERTAR'){
		$nombre=mysqli_real_escape_string($conexion,$_POST['usuario_nombre']);
		$apellido=mysqli_real_escape_string($conexion,$_POST['usuario_apellido']);
		$empresa=mysqli_real_escape_string($conexion,$_POST['usuario_empresa']);
		$cedula_rif=mysqli_real_escape_string($conexion,$_POST['usuario_cedula_rif']);
		$telefono=mysqli_real_escape_string($conexion,$_POST['usuario_telefono']);
		$correo=mysqli_real_escape_string($conexion,$_POST['usuario_correo']);
		$direccion=mysqli_real_escape_string($conexion,$_POST['usuario_direccion']);
		$estado=mysqli_real_escape_string($conexion,$_POST['usuario_estado']);
		$ciudad=mysqli_real_escape_string($conexion,$_POST['usuario_ciudad']);
		$municipio=mysqli_real_escape_string($conexion,$_POST['usuario_municipio']);
		$parroquia=mysqli_real_escape_string($conexion,$_POST['usuario_parroquia']);
		$pregunta_1=mysqli_real_escape_string($conexion,$_POST['pregunta_1']);
		$respuesta_1=mysqli_real_escape_string($conexion,$_POST['respuesta_1']);
		$pregunta_2=mysqli_real_escape_string($conexion,$_POST['pregunta_2']);
		$respuesta_2=mysqli_real_escape_string($conexion,$_POST['respuesta_2']);
		$pregunta_3=mysqli_real_escape_string($conexion,$_POST['pregunta_3']);
		$respuesta_3=mysqli_real_escape_string($conexion,$_POST['respuesta_3']);
		$pregunta_4=mysqli_real_escape_string($conexion,$_POST['pregunta_4']);
		$respuesta_4=mysqli_real_escape_string($conexion,$_POST['respuesta_4']);
		$pregunta_5=mysqli_real_escape_string($conexion,$_POST['pregunta_5']);
		$respuesta_5=mysqli_real_escape_string($conexion,$_POST['respuesta_5']);
		$banco_nombre=mysqli_real_escape_string($conexion,$_POST['banco_nombre']);
		$banco_tipo_cuenta=mysqli_real_escape_string($conexion,$_POST['banco_tipo']);
		$banco_cedula_rif=mysqli_real_escape_string($conexion,$_POST['banco_cedula_rif']);
		$banco_telefono=mysqli_real_escape_string($conexion,$_POST['banco_telefono']);
		$banco_numero_cuenta=mysqli_real_escape_string($conexion,$_POST['banco_cuenta']);
		$acceso=mysqli_real_escape_string($conexion,$_POST['acceso']);
		$estatus=mysqli_real_escape_string($conexion,$_POST['estatus']);
		$ranking=mysqli_real_escape_string($conexion,$_POST['ranking']);
		$ip_de_navegacion=mysqli_real_escape_string($conexion,$_POST['ip_de_navegacion']);
		$fecha_de_ingreso=date("Y-m-d h:m:s");
		if(isset($_POST['fecha_nacimiento'])){
			$fecha_nacimiento=$_POST['fecha_nacimiento'];
		}else{
			$fecha_nacimiento=$fecha_de_ingreso;
		}
		//VERIFICANDO SI EXITE UN IMAGEN
		if(isset($_FILES['usuario_foto']['type'])){
			//PROCESAMIENTO DE IMAGEN
			$foto_type=$_FILES['usuario_foto']['type'];
			$foto_size=$_FILES['usuario_foto']['size'];
			$ruta_temporal=$_FILES['usuario_foto']['tmp_name'];
			$ruta_destino_con_foto=$url_sitio . "IMAGENES_USUARIOS/" . $cedula_rif . ".png";
			$ruta_destino_sin_foto=$url_sitio . "IMAGENES_USUARIOS/vacio.png";
			//VERIFICANDO TAMAÑO DE LA IMAGEN
			if($foto_size>2000000){$verf_foto_size="error";}else{$verf_foto_size="ok";}
			//VERIFICANDO FORMATO DE LA IMAGEN
			if(strpos($foto_type,"png") or strpos($foto_type,"gif") or strpos($foto_type,"jpeg") or strpos($foto_type,"jpg")){$verf_foto_type="ok";}else{$verf_foto_type="error";}
			//CARGANDO CURRICULUM EN BASE DE DATOS
			if($verf_foto_size=='ok' and $verf_foto_type=='ok'){
				$foto_usuario=$cedula_rif . ".png";
				//INSERTANDO CON FOTO
				$verf_insert=M_usuarios_C($conexion, $ip_de_navegacion, $nombre, $apellido, $empresa, $fecha_nacimiento, $cedula_rif, $telefono, $correo, $foto_usuario, $fecha_de_ingreso, $estado, $ciudad, $municipio, $parroquia, $direccion, $banco_nombre, $banco_numero_cuenta, $banco_tipo_cuenta, $banco_telefono, $banco_cedula_rif, $pregunta_1, $respuesta_1, $pregunta_2, $respuesta_2, $pregunta_3, $respuesta_3, $pregunta_4, $respuesta_4, $pregunta_5, $respuesta_5, $acceso, $estatus, $ranking, 'NO', 'NO');
				if($verf_insert){
					//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
					move_uploaded_file($ruta_temporal,$ruta_destino_con_foto);
				}
			}else{
				$foto_usuario="vacio.png";
				//INSERTANDO SIN FOTO
				$verf_insert=M_usuarios_C($conexion, $ip_de_navegacion, $nombre, $apellido, $empresa, $fecha_nacimiento, $cedula_rif, $telefono, $correo, $foto_usuario, $fecha_de_ingreso, $estado, $ciudad, $municipio, $parroquia, $direccion, $banco_nombre, $banco_numero_cuenta, $banco_tipo_cuenta, $banco_telefono, $banco_cedula_rif, $pregunta_1, $respuesta_1, $pregunta_2, $respuesta_2, $pregunta_3, $respuesta_3, $pregunta_4, $respuesta_4, $pregunta_5, $respuesta_5, $acceso, $estatus, $ranking, 'NO', 'NO');
				//no se mueve ninguna imagen ya que la imagen VACIO.PNG esta predeterminada en la carpeta de imagenes de usuarios

			}
		}else{
			$foto_usuario="vacio.png";
			//INSERTANDO SIN FOTO
			$verf_insert=M_usuarios_C($conexion, $ip_de_navegacion, $nombre, $apellido, $empresa, $fecha_nacimiento, $cedula_rif, $telefono, $correo, $foto_usuario, $fecha_de_ingreso, $estado, $ciudad, $municipio, $parroquia, $direccion, $banco_nombre, $banco_numero_cuenta, $banco_tipo_cuenta, $banco_telefono, $banco_cedula_rif, $pregunta_1, $respuesta_1, $pregunta_2, $respuesta_2, $pregunta_3, $respuesta_3, $pregunta_4, $respuesta_4, $pregunta_5, $respuesta_5, $acceso, $estatus, $ranking, 'NO', 'NO', 'NO');
			//no se mueve ninguna imagen ya que la imagen VACIO.PNG esta predeterminada en la carpeta de imagenes de usuarios
		}
	}else if($_POST['FORM']=='MODIFICAR'){
		$id_usuario=mysqli_real_escape_string($conexion,$_POST['id_usuario']);
		$nombre=mysqli_real_escape_string($conexion,$_POST['usuario_nombre']);
		$apellido=mysqli_real_escape_string($conexion,$_POST['usuario_apellido']);
		$empresa=mysqli_real_escape_string($conexion,$_POST['usuario_empresa']);
		$cedula_rif=mysqli_real_escape_string($conexion,$_POST['usuario_cedula_rif']);
		$telefono=mysqli_real_escape_string($conexion,$_POST['usuario_telefono']);
		$correo=mysqli_real_escape_string($conexion,$_POST['usuario_correo']);
		$direccion=mysqli_real_escape_string($conexion,$_POST['usuario_direccion']);
		$estado=mysqli_real_escape_string($conexion,$_POST['usuario_estado']);
		$ciudad=mysqli_real_escape_string($conexion,$_POST['usuario_ciudad']);
		$municipio=mysqli_real_escape_string($conexion,$_POST['usuario_municipio']);
		$parroquia=mysqli_real_escape_string($conexion,$_POST['usuario_parroquia']);
		$pregunta_1=mysqli_real_escape_string($conexion,$_POST['pregunta_1']);
		$respuesta_1=mysqli_real_escape_string($conexion,$_POST['respuesta_1']);
		$pregunta_2=mysqli_real_escape_string($conexion,$_POST['pregunta_2']);
		$respuesta_2=mysqli_real_escape_string($conexion,$_POST['respuesta_2']);
		$pregunta_3=mysqli_real_escape_string($conexion,$_POST['pregunta_3']);
		$respuesta_3=mysqli_real_escape_string($conexion,$_POST['respuesta_3']);
		$pregunta_4=mysqli_real_escape_string($conexion,$_POST['pregunta_4']);
		$respuesta_4=mysqli_real_escape_string($conexion,$_POST['respuesta_4']);
		$pregunta_5=mysqli_real_escape_string($conexion,$_POST['pregunta_5']);
		$respuesta_5=mysqli_real_escape_string($conexion,$_POST['respuesta_5']);
		$banco_nombre=mysqli_real_escape_string($conexion,$_POST['banco_nombre']);
		$banco_tipo_cuenta=mysqli_real_escape_string($conexion,$_POST['banco_tipo']);
		$banco_cedula_rif=mysqli_real_escape_string($conexion,$_POST['banco_cedula_rif']);
		$banco_telefono=mysqli_real_escape_string($conexion,$_POST['banco_telefono']);
		$banco_numero_cuenta=mysqli_real_escape_string($conexion,$_POST['banco_cuenta']);
		$acceso=mysqli_real_escape_string($conexion,$_POST['acceso']);
		$estatus=mysqli_real_escape_string($conexion,$_POST['estatus']);
		$aliado=mysqli_real_escape_string($conexion,$_POST['aliado']);
		$ranking=mysqli_real_escape_string($conexion,$_POST['ranking']);
		$indicadores=mysqli_real_escape_string($conexion,$_POST['indicadores']);
		$ip_de_navegacion=mysqli_real_escape_string($conexion,$_POST['ip_de_navegacion']);
		$datos_user=M_usuarios_R($conexion, 'ID_USUARIO', $id_usuario, '', '', '', '');
		$fecha_de_ingreso=$datos_user['FECHA_DE_INGRESO'][0];
		if(isset($_POST['fecha_nacimiento'])){
			$fecha_nacimiento=$_POST['fecha_nacimiento'];
		}else{
			$fecha_nacimiento=$fecha_de_ingreso;
		}
		//VERIFICANDO SI EXITE UN IMAGEN
		if(isset($_FILES['usuario_foto']['type'])){
			//PROCESAMIENTO DE IMAGEN
			$foto_type=$_FILES['usuario_foto']['type'];
			$foto_size=$_FILES['usuario_foto']['size'];
			$ruta_temporal=$_FILES['usuario_foto']['tmp_name'];
			$ruta_destino_con_foto=$url_sitio . "IMAGENES_USUARIOS/" . $cedula_rif . ".png";
			$ruta_destino_sin_foto=$url_sitio . "IMAGENES_USUARIOS/vacio.png";
			//VERIFICANDO TAMAÑO DE LA IMAGEN
			if($foto_size>2000000){$verf_foto_size="error";}else{$verf_foto_size="ok";}
			//VERIFICANDO FORMATO DE LA IMAGEN
			if(strpos($foto_type,"png") or strpos($foto_type,"gif") or strpos($foto_type,"jpeg") or strpos($foto_type,"jpg")){$verf_foto_type="ok";}else{$verf_foto_type="error";}
			//CARGANDO CURRICULUM EN BASE DE DATOS
			if($verf_foto_size=='ok' and $verf_foto_type=='ok'){
				$foto_usuario=$cedula_rif . ".png";
				//INSERTANDO CON FOTO
				M_usuarios_U_id($conexion, $id_usuario, $ip_de_navegacion, $nombre, $apellido, $empresa, $fecha_nacimiento, $cedula_rif, $telefono, $correo, $foto_usuario, $fecha_de_ingreso, $estado, $ciudad, $municipio, $parroquia, $direccion, $banco_nombre, $banco_numero_cuenta, $banco_tipo_cuenta, $banco_telefono, $banco_cedula_rif, $pregunta_1, $respuesta_1, $pregunta_2, $respuesta_2, $pregunta_3, $respuesta_3, $pregunta_4, $respuesta_4, $pregunta_5, $respuesta_5, $acceso, $estatus, $ranking, $aliado, $indicadores);
				//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
				move_uploaded_file($ruta_temporal,$ruta_destino_con_foto);
			}else{
				$foto_usuario=$datos_user['FOTO_LOGO'][0];
				//INSERTANDO SIN FOTO
				M_usuarios_U_id($conexion, $id_usuario, $ip_de_navegacion, $nombre, $apellido, $empresa, $fecha_nacimiento, $cedula_rif, $telefono, $correo, $foto_usuario, $fecha_de_ingreso, $estado, $ciudad, $municipio, $parroquia, $direccion, $banco_nombre, $banco_numero_cuenta, $banco_tipo_cuenta, $banco_telefono, $banco_cedula_rif, $pregunta_1, $respuesta_1, $pregunta_2, $respuesta_2, $pregunta_3, $respuesta_3, $pregunta_4, $respuesta_4, $pregunta_5, $respuesta_5, $acceso, $estatus, $ranking, $aliado, $indicadores);
				//no se mueve ninguna imagen ya que la imagen VACIO.PNG esta predeterminada en la carpeta de imagenes de usuarios

			}
		}else{
			$foto_usuario=$datos_user['FOTO_LOGO'][0];
			//INSERTANDO SIN FOTO
			M_usuarios_U_id($conexion, $id_usuario, $ip_de_navegacion, $nombre, $apellido, $empresa, $fecha_nacimiento, $cedula_rif, $telefono, $correo, $foto_usuario, $fecha_de_ingreso, $estado, $ciudad, $municipio, $parroquia, $direccion, $banco_nombre, $banco_numero_cuenta, $banco_tipo_cuenta, $banco_telefono, $banco_cedula_rif, $pregunta_1, $respuesta_1, $pregunta_2, $respuesta_2, $pregunta_3, $respuesta_3, $pregunta_4, $respuesta_4, $pregunta_5, $respuesta_5, $acceso, $estatus, $ranking, $aliado, $indicadores);
			//no se mueve ninguna imagen ya que la imagen VACIO.PNG esta predeterminada en la carpeta de imagenes de usuarios
		}
	}else if($_POST['FORM']=='BORRAR'){
		$id_usuario=mysqli_real_escape_string($conexion,$_POST['id_usuario']);
		$datos_userD=M_usuarios_R($conexion, 'ID_USUARIO', $id_usuario, '', '', '', '');
		M_usuarios_D_id($conexion, $id_usuario);
		if($datos_userD['FOTO_LOGO'][0]=='vacio.png'){
			//no haga nada
		}else{
			unlink('IMAGENES_USUARIOS/' . $datos_userD['FOTO_LOGO'][0]);
		}
	}
	if(isset($verf_insert)){
		if($verf_insert==false){
			?>
			<script>
				alert("El Renglón que está intentando agregar YA EXISTE");
			</script>
			<?php
		}
	}
	//REFRESCAR LA PAGINA
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=CRUD_usuarios.php'>";
}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>CRUD Usuarios</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid px-0 mx-0 mx-md-2 px-md-4 mt-2 mb-5 bg-secondary">
	<br>
	<?php
	//VERIFICANDO Si SE MARCO ALGUNA OPCION EN LA TABLA PRINCIPAL DEL CRUD
	if(isset($_GET["accion"])){
			//SI SE QUIERE INSERTAR UN NUEVO RENGLON ENTONCES:
		if($_GET["accion"]=='insertar'){
	?>
		<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
			<div class="row mt-4 align-items-center rounded-top px-2">
				<div class="col-md-9 mb-1 mt-3">
					<h3 class="text-center text-md-left text-warning">Agregar nuevo Usuario:</h3>
				</div>
				<div class="col-md-3 text-center text-md-right mb-1 mt-3">
					<a href="CRUD_usuarios.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
				</div>
			</div>
			<form action="CRUD_usuarios.php" method="post" class="text-center bg-dark p-2 rounded" enctype="multipart/form-data">
				<input type="hidden" name="FORM" id="FORM" value="INSERTAR">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Nombre:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_nombre" id="usuario_nombre" placeholder="Ej: José Antonio" required autocomplete="off" title="Introduzca su nombre">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Apellido:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_apellido" id="usuario_apellido" placeholder="Ej: Gonzalez Herrera" required autocomplete="off" title="Introduzca su apellido">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">¿Es una Empresa?</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_empresa" id="usuario_empresa" required autocomplete="off" title="Indique si el usuario es una Empresa">
						<option></option>
						<option>SI</option>
						<option>NO</option>
					</select>
				</div>
				<div id="caja_para_fecha_nacimiento"></div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#usuario_empresa").on('change', function(){
							var empresa=$("#usuario_empresa").val();
							if(empresa=='NO'){
								var caja_fecha="<div id='click01' class='input-group date pickers mb-2'><div class='col-md-3 p-0 m-0'><span class='input-group-text rounded-0 w-100'>Fecha Nacimiento:</span></div><input id='datepicker01' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fecha_nacimiento' placeholder='Fecha de Nacimiento (Y-m-d)' required autocomplete='off' title='Introduzca su Fecha de Nacimiento (Y-m-d)'><div>";
								$("#caja_para_fecha_nacimiento").hide();
								$("#caja_para_fecha_nacimiento").html(caja_fecha);
								$("#caja_para_fecha_nacimiento").slideDown(500);
								$('#datepicker01').click(function(){
									Calendar.setup({
										inputField     :    'datepicker01',     // id of the input field
										ifFormat       :    '%Y-%m-%d',      // format of the input field
										button         :    'click01',  // trigger for the calendar (button ID)
										align          :    'Tl',           // alignment (defaults to 'Bl')
										singleClick    :    true
									});
								});
							}else{
								$("#caja_para_fecha_nacimiento").slideUp(500);
								$("#caja_para_fecha_nacimiento").html("");
							}
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cédula o RIF:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_cedula_rif" id="usuario_cedula_rif" placeholder="Indique cédula o RIF" required autocomplete="off" title="Introduzca su Cédula si es persona natural o su RIF si es una Empresa">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Teléfono:</span>
					</div>
					<input type="tel" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_telefono" id="usuario_telefono" placeholder="Ej: 0414-1234567" required autocomplete="off" title="Introduzca su número de teléfono">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Email:</span>
					</div>
					<input type="email" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_correo" id="usuario_correo" placeholder="Ej: usuario@correo.com" required autocomplete="off" title="Introduzca su correo electrónico">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">IP usuario:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="ip_de_navegacion" id="ip_de_navegacion" placeholder="IP del usuario" required autocomplete="off" title="Introduzca IP de navegación del usuario">
				</div>
				<h5 class="text-center text-warning">Privilegios:</h5>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Acceso:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="acceso" id="acceso" required autocomplete="off" title="Indique el nivel de acceso">
						<option></option>
						<option>COMPRADOR-VENDEDOR</option>
						<option>ANALISTA</option>
						<option>ADMINISTRADOR</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Estatus:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="estatus" id="estatus" required autocomplete="off" title="Indique el Estatus del Usuario">
						<option></option>
						<option>REGISTRADO</option>
						<option>ACTIVO</option>
						<option>SUSPENDIDO</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Ranking:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="ranking" id="ranking" required autocomplete="off" title="Indique el Ranking del Usuario">
						<option></option>
						<option>HIERRO</option>
						<option>PLATA</option>
						<option>ORO</option>
						<option>PLATINO</option>
						<option>DIAMANTE</option>
					</select>
				</div>
				<h5 class="text-center text-warning">Datos de Ubicación:</h5>
				<div class="input-group mb-2">
					<span class="input-group-text rounded-0 w-100">Dirección:</span>
					<textarea class="form-control p-0 m-0 px-2 rounded-0" name="usuario_direccion" id="usuario_direccion" placeholder="Introduzca su dirección" required autocomplete="off" title="Introduzca su dirección" rows="2"></textarea>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Estado:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_estado" id="usuario_estado" required autocomplete="off" title="Indique el Estado">
						<option></option>
						<?php
							$datos_estados=M_agrupa_estados($conexion);
							$i=0;
							while(isset($datos_estados[$i])){
								echo "<option>" . $datos_estados[$i] . "</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Ciudad:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_ciudad" id="usuario_ciudad" required autocomplete="off" title="Indique la ciudad">
						<option></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#usuario_estado").on('change', function(){
							var estado=$("#usuario_estado").val();
							$.ajax("PHP_MODELO/S_agrupa_ciudad.php",{data:{estado:estado}, type:'post'}).done(function(respuesta){
								$("#usuario_ciudad").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Municipio:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_municipio" id="usuario_municipio" required autocomplete="off" title="Indique el municipio" onChange="actualiza_parroquia">
						<option></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#usuario_estado").on('change', function(){
							var estado=$("#usuario_estado").val();
							$.ajax("PHP_MODELO/S_agrupa_municipio.php",{data:{estado:estado}, type:'post'}).done(function(respuesta){
								$("#usuario_municipio").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Parroquia:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_parroquia" id="usuario_parroquia" required autocomplete="off" title="Indique la parroquia">
						<option></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#usuario_municipio").on('change', function(){
							var municipio=$("#usuario_municipio").val();
							$.ajax("PHP_MODELO/S_agrupa_parroquia.php",{data:{municipio:municipio}, type:'post'}).done(function(respuesta){
								$("#usuario_parroquia").html(respuesta);
							});
						});
					});
				</script>
				<h5 class="text-center text-warning">Preguntas de Seguridad:</h5>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Pregunta N°1:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="pregunta_1" id="pregunta_1" required autocomplete="off" title="Seleccione una pregunta">
						<option></option>
						<?php
							$preguntas_devueltas=M_preguntas_seguridad();
							$i=0;
							while(isset($preguntas_devueltas[$i])){
								echo "<option>" . $preguntas_devueltas[$i] . "</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Respuesta N°1:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="respuesta_1" id="respuesta_1" placeholder="Indique su respuesta 1" required autocomplete="off" title="Indique su respuesta">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Pregunta N°2:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="pregunta_2" id="pregunta_2" required autocomplete="off" title="Seleccione una pregunta">
						<option></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#pregunta_1").on('change', function(){
							var preg_1=$("#pregunta_1").val();
							$.ajax("PHP_MODELO/S_preguntas_seguridad.php",{data:{preg_1:preg_1, preg_2:"", preg_3:"", preg_4:""}, type:'post'}).done(function(respuesta){
								$("#pregunta_2").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Respuesta N°2:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="respuesta_2" id="respuesta_2" placeholder="Indique su respuesta 2" required autocomplete="off" title="Indique su respuesta">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Pregunta N°3:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="pregunta_3" id="pregunta_3" required autocomplete="off" title="Seleccione una pregunta">
						<option></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#pregunta_2").on('change', function(){
							var preg_1=$("#pregunta_1").val();
							var preg_2=$("#pregunta_2").val();
							$.ajax("PHP_MODELO/S_preguntas_seguridad.php",{data:{preg_1:preg_1, preg_2:preg_2, preg_3:"", preg_4:""}, type:'post'}).done(function(respuesta){
								$("#pregunta_3").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Respuesta N°3:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="respuesta_3" id="respuesta_3" placeholder="Indique su respuesta 3" required autocomplete="off" title="Indique su respuesta">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Pregunta N°4:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="pregunta_4" id="pregunta_4" required autocomplete="off" title="Seleccione una pregunta">
						<option></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#pregunta_3").on('change', function(){
							var preg_1=$("#pregunta_1").val();
							var preg_2=$("#pregunta_2").val();
							var preg_3=$("#pregunta_3").val();
							$.ajax("PHP_MODELO/S_preguntas_seguridad.php",{data:{preg_1:preg_1, preg_2:preg_2, preg_3:preg_3, preg_4:""}, type:'post'}).done(function(respuesta){
								$("#pregunta_4").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Respuesta N°4:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="respuesta_4" id="respuesta_4" placeholder="Indique su respuesta 4" required autocomplete="off" title="Indique su respuesta">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Pregunta N°5:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="pregunta_5" id="pregunta_5" required autocomplete="off" title="Seleccione una pregunta">
						<option></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#pregunta_4").on('change', function(){
							var preg_1=$("#pregunta_1").val();
							var preg_2=$("#pregunta_2").val();
							var preg_3=$("#pregunta_3").val();
							var preg_4=$("#pregunta_4").val();
							$.ajax("PHP_MODELO/S_preguntas_seguridad.php",{data:{preg_1:preg_1, preg_2:preg_2, preg_3:preg_3, preg_4:preg_4}, type:'post'}).done(function(respuesta){
								$("#pregunta_5").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Respuesta N°5:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="respuesta_5" id="respuesta_5" placeholder="Indique su respuesta 5" required autocomplete="off" title="Indique su respuesta">
				</div>
				<h5 class="text-center text-warning">Datos Bancarios:</h5>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Nombre del Banco:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="banco_nombre" id="banco_nombre" required autocomplete="off" title="Seleccione un Banco">
						<option></option>
						<?php
							$datos_bancos=M_nombres_de_bancos();
							$i=0;
							while(isset($datos_bancos[$i])){
								echo "<option>" . $datos_bancos[$i] . "</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Tipo de Cuenta:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="banco_tipo" id="banco_tipo" required autocomplete="off" title="Seleccione un tipo de cuenta">
						<option></option>
						<option>Corriente</option>
						<option>Ahorro</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cedula o RIF:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="banco_cedula_rif" id="banco_cedula_rif" placeholder="Indique la cedula o RIF" required autocomplete="off" title="Indique la cedula o RIF correspondiente a la cuenta Bancaria">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Teléfono:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="banco_telefono" id="banco_telefono" placeholder="Indique el Teléfono" required autocomplete="off" title="Indique el Teléfono correspondiente a la cuenta Bancaria">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Número de Cuenta:</span>
					</div>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="banco_cuenta" id="banco_cuenta" placeholder="Sólo números" required autocomplete="off" title="Indique su Número de Cuenta sin guiónes ni espacios">
				</div>
				<h5 class="text-center text-warning" title="Adjunte su Foto de Perfil (en formato png y máximo 2 MegaBytes)">Foto/Logo del Perfil</h5>
				<h6 class="text-center text-light small">Sólo archivos jpg, jpeg, gif o png y máximo 2 MegaBytes</h6>
				<h6 class="text-center text-light small">Puedes convertir imágenes a formato png <a class="text-warning" href="https://convertio.co/es/jpg-png/" target="_blank">AQUÍ</a></h6>
				<input type='file' name='usuario_foto' id='usuario_foto' class="mb-2 w-100 bg-light text-dark p-2 rounded" title="Adjunte su Foto o Logo para el Perfil (en formato png y máximo 2 MegaBytes)">
				<div class="m-auto">
					<a href="CRUD_usuarios.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Insertar Renglón &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
		</div>
		<?php
			// -------------    SI SE QUIERE MODIFICAR UN RENGLON ENTONCES --------------  :
			}else if($_GET["accion"]=='actualizar'){
				$datos_actualizar=M_usuarios_R($conexion, 'ID_USUARIO', $_GET['NA_Id'], '', '', '', '');
		?>
		<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
			<div class="row mt-4 align-items-center rounded-top px-2">
				<div class="col-md-9 mb-1 mt-3">
					<h3 class="text-center text-md-left text-warning" title="Formulario para Actualización de datos de Usuarios">Modificar Usuario:</h3>
				</div>
				<div class="col-md-3 text-center text-md-right mb-1 mt-3">
					<a href="CRUD_usuarios.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
				</div>
			</div>
			<form action="CRUD_usuarios.php" method="post" class="text-center bg-dark p-2 rounded" enctype="multipart/form-data">
				<input type="hidden" name="FORM" id="FORM" value="MODIFICAR">
				<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $datos_actualizar['ID_USUARIO'][0]; ?>">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Nombre:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_nombre" id="usuario_nombre" placeholder="Ej: José Antonio" required autocomplete="off" title="Introduzca su nombre" value="<?php echo $datos_actualizar['NOMBRE'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Apellido:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_apellido" id="usuario_apellido" placeholder="Ej: Gonzalez Herrera" required autocomplete="off" title="Introduzca su apellido" value="<?php echo $datos_actualizar['APELLIDO'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">¿Es una Empresa?</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_empresa" id="usuario_empresa" required autocomplete="off" title="Indique si el usuario es una Empresa">
						<option><?php echo $datos_actualizar['EMPRESA'][0]; ?></option>
						<option>SI</option>
						<option>NO</option>
					</select>
				</div>
				<div id="caja_para_fecha_nacimiento"></div>
				<script type="text/javascript">
					$(document).ready(function(){
						var empresa=$("#usuario_empresa").val();
						if(empresa=='NO'){
							var caja_fecha="<div id='click01' class='input-group date pickers mb-2'><div class='col-md-3 p-0 m-0'><span class='input-group-text rounded-0 w-100'>Fecha Nacimiento:</span></div><input id='datepicker01' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fecha_nacimiento' placeholder='Fecha de Nacimiento (Y-m-d)' required autocomplete='off' title='Introduzca su Fecha de Nacimiento (Y-m-d)' value='<?php echo $datos_actualizar['FECHA_NACIMIENTO'][0]; ?>'><div>";
							$("#caja_para_fecha_nacimiento").html(caja_fecha);
							$('#datepicker01').click(function(){
								Calendar.setup({
									inputField     :    'datepicker01',     // id of the input field
									ifFormat       :    '%Y-%m-%d',      // format of the input field
									button         :    'click01',  // trigger for the calendar (button ID)
									align          :    'Tl',           // alignment (defaults to 'Bl')
									singleClick    :    true
								});
							});
						}
						$("#usuario_empresa").on('change', function(){
							var empresa=$("#usuario_empresa").val();
							if(empresa=='NO'){
								var caja_fecha="<div id='click01' class='input-group date pickers mb-2'><div class='col-md-3 p-0 m-0'><span class='input-group-text rounded-0 w-100'>Fecha Nacimiento:</span></div><input id='datepicker01' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fecha_nacimiento' placeholder='Fecha de Nacimiento (Y-m-d)' required autocomplete='off' title='Introduzca su Fecha de Nacimiento (Y-m-d)'  value='<?php echo $datos_actualizar['FECHA_NACIMIENTO'][0]; ?>'><div>";
								$("#caja_para_fecha_nacimiento").hide();
								$("#caja_para_fecha_nacimiento").html(caja_fecha);
								$("#caja_para_fecha_nacimiento").slideDown(500);
								$('#datepicker01').click(function(){
									Calendar.setup({
										inputField     :    'datepicker01',     // id of the input field
										ifFormat       :    '%Y-%m-%d',      // format of the input field
										button         :    'click01',  // trigger for the calendar (button ID)
										align          :    'Tl',           // alignment (defaults to 'Bl')
										singleClick    :    true
									});
								});
							}else{
								$("#caja_para_fecha_nacimiento").slideUp(500);
								$("#caja_para_fecha_nacimiento").html("");
							}
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cédula o RIF:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_cedula_rif" id="usuario_cedula_rif" placeholder="Indique cédula o RIF" required autocomplete="off" title="Introduzca su Cédula si es persona natural o su RIF si es una Empresa" value="<?php echo $datos_actualizar['CEDULA_RIF'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Teléfono:</span>
					</div>
					<input type="tel" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_telefono" id="usuario_telefono" placeholder="Ej: 0414-1234567" required autocomplete="off" title="Introduzca su número de teléfono" value="<?php echo $datos_actualizar['TELEFONO'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Email:</span>
					</div>
					<input type="email" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_correo" id="usuario_correo" placeholder="Ej: usuario@correo.com" required autocomplete="off" title="Introduzca su correo electrónico" value="<?php echo $datos_actualizar['CORREO'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">IP usuario:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="ip_de_navegacion" id="ip_de_navegacion" placeholder="Introduzca IP de navegación del usuario" required autocomplete="off" title="Introduzca IP de navegación del usuario" value="<?php echo $datos_actualizar['IP_DE_NAVEGAION'][0]; ?>">
				</div>
				<h5 class="text-center text-warning">Privilegios:</h5>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Acceso:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="acceso" id="acceso" required autocomplete="off" title="Indique el nivel de acceso">
						<option><?php echo $datos_actualizar['ACCESO'][0]; ?></option>
						<option>COMPRADOR-VENDEDOR</option>
						<option>ANALISTA</option>
						<option>ADMINISTRADOR</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Estatus:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="estatus" id="estatus" required autocomplete="off" title="Indique el Estatus del Usuario">
						<option><?php echo $datos_actualizar['ESTATUS'][0]; ?></option>
						<option>REGISTRADO</option>
						<option>ACTIVO</option>
						<?php
							$datos_saldo_disp_i=M_saldo_pm_disponible_usuario($conexion, $datos_actualizar['CEDULA_RIF'][0]);
							$datos_saldo_dife_i=M_saldo_pm_diferido_usuario($conexion, $datos_actualizar['CEDULA_RIF'][0]);
							$datos_saldo_bloq_i=M_saldo_pm_bloqueado_usuario($conexion, $datos_actualizar['CEDULA_RIF'][0]);
							$datos_vendido_premiun_i= M_control_de_transacciones_compras_en_micoin_R($conexion, 'VENDEDOR_CEDULA_RIF', $datos_actualizar['CEDULA_RIF'][0], 'ESTATUS', 'PAGADO', 'TIPO_DE_COMPRA', 'PREMIUN');
							$datos_comprado_premiun_i= M_control_de_transacciones_compras_en_micoin_R($conexion, 'COMPRADOR_CEDULA_RIF', $datos_actualizar['CEDULA_RIF'][0], 'ESTATUS', 'PAGADO', 'TIPO_DE_COMPRA', 'PREMIUN');

							$premiun="NO";
							if(isset($datos_vendido_premiun_i['ESTATUS'][0])){
								if($datos_vendido_premiun_i['ESTATUS'][0]<>''){
									$premiun="SI";
								}
							}
							if(isset($datos_comprado_premiun_i['ESTATUS'][0])){
								if($datos_comprado_premiun_i['ESTATUS'][0]<>''){
									$premiun="SI";
								}
							}
							if(round($datos_saldo_disp_i['SALDO_PEMON'][0],2)<>0 or round($datos_saldo_dife_i['SALDO_PEMON'][0],2)<>0 or round($datos_saldo_bloq_i['SALDO_PEMON'][0],2)<>0 or $premiun=="SI"){
								$verf_usuario_borrar="NO";
							}else{
								$verf_usuario_borrar="SI";
							}
							if($verf_usuario_borrar=="SI"){
								echo "<option>SUSPENDIDO</option>";
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Ranking:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="ranking" id="ranking" required autocomplete="off" title="Indique el Ranking del Usuario">
						<option><?php echo $datos_actualizar['RANKING'][0]; ?></option>
						<option>HIERRO</option>
						<option>PLATA</option>
						<option>ORO</option>
						<option>PLATINO</option>
						<option>DIAMANTE</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">¿Aliado?</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="aliado" id="aliado" required autocomplete="off" title="Indique si el usuario es aliado o no para ser publicado en la portada">
						<option><?php echo $datos_actualizar['ALIADO'][0]; ?></option>
						<option>SI</option>
						<option>NO</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">¿Indicadores?</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="indicadores" id="indicadores" required autocomplete="off" title="Indique si el usuario tiene acceso a los indicadores o no">
						<option><?php echo $datos_actualizar['INDICADORES'][0]; ?></option>
						<option>SI</option>
						<option>NO</option>
					</select>
				</div>
				<h5 class="text-center text-warning">Datos de Ubicación:</h5>
				<div class="input-group mb-2">
					<span class="input-group-text rounded-0 w-100">Dirección:</span>
					<textarea class="form-control p-0 m-0 px-2 rounded-0" name="usuario_direccion" id="usuario_direccion" placeholder="Introduzca su dirección" required autocomplete="off" title="Introduzca su dirección" rows="2"><?php echo $datos_actualizar['DIRECCION'][0]; ?></textarea>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Estado:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_estado" id="usuario_estado" required autocomplete="off" title="Indique el Estado">
						<option><?php echo $datos_actualizar['ESTADO'][0]; ?></option>
						<?php
							$datos_estados=M_agrupa_estados($conexion);
							$i=0;
							while(isset($datos_estados[$i])){
								echo "<option>" . $datos_estados[$i] . "</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Ciudad:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_ciudad" id="usuario_ciudad" required autocomplete="off" title="Indique la ciudad">
						<option><?php echo $datos_actualizar['CIUDAD'][0]; ?></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#usuario_estado").on('change', function(){
							var estado=$("#usuario_estado").val();
							$.ajax("PHP_MODELO/S_agrupa_ciudad.php",{data:{estado:estado}, type:'post'}).done(function(respuesta){
								$("#usuario_ciudad").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Municipio:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_municipio" id="usuario_municipio" required autocomplete="off" title="Indique el municipio" onChange="actualiza_parroquia">
						<option><?php echo $datos_actualizar['MUNICIPIO'][0]; ?></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#usuario_estado").on('change', function(){
							var estado=$("#usuario_estado").val();
							$.ajax("PHP_MODELO/S_agrupa_municipio.php",{data:{estado:estado}, type:'post'}).done(function(respuesta){
								$("#usuario_municipio").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Parroquia:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_parroquia" id="usuario_parroquia" required autocomplete="off" title="Indique la parroquia">
						<option><?php echo $datos_actualizar['PARROQUIA'][0]; ?></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#usuario_municipio").on('change', function(){
							var municipio=$("#usuario_municipio").val();
							$.ajax("PHP_MODELO/S_agrupa_parroquia.php",{data:{municipio:municipio}, type:'post'}).done(function(respuesta){
								$("#usuario_parroquia").html(respuesta);
							});
						});
					});
				</script>
				<h5 class="text-center text-warning">Preguntas de Seguridad:</h5>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Pregunta N°1:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="pregunta_1" id="pregunta_1" required autocomplete="off" title="Seleccione una pregunta">
						<option><?php echo $datos_actualizar['PREGUNTA_SEGURIDAD_1'][0]; ?></option>
						<?php
							$preguntas_devueltas=M_preguntas_seguridad();
							$i=0;
							while(isset($preguntas_devueltas[$i])){
								echo "<option>" . $preguntas_devueltas[$i] . "</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Respuesta N°1:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="respuesta_1" id="respuesta_1" placeholder="Indique su respuesta 1" required autocomplete="off" title="Indique su respuesta" value="<?php echo $datos_actualizar['RESPUESTA_SEGURIDAD_1'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Pregunta N°2:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="pregunta_2" id="pregunta_2" required autocomplete="off" title="Seleccione una pregunta">
						<option><?php echo $datos_actualizar['PREGUNTA_SEGURIDAD_2'][0]; ?></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#pregunta_1").on('change', function(){
							var preg_1=$("#pregunta_1").val();
							$.ajax("PHP_MODELO/S_preguntas_seguridad.php",{data:{preg_1:preg_1, preg_2:"", preg_3:"", preg_4:""}, type:'post'}).done(function(respuesta){
								$("#pregunta_2").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Respuesta N°2:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="respuesta_2" id="respuesta_2" placeholder="Indique su respuesta 2" required autocomplete="off" title="Indique su respuesta" value="<?php echo $datos_actualizar['RESPUESTA_SEGURIDAD_2'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Pregunta N°3:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="pregunta_3" id="pregunta_3" required autocomplete="off" title="Seleccione una pregunta">
						<option><?php echo $datos_actualizar['PREGUNTA_SEGURIDAD_3'][0]; ?></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#pregunta_2").on('change', function(){
							var preg_1=$("#pregunta_1").val();
							var preg_2=$("#pregunta_2").val();
							$.ajax("PHP_MODELO/S_preguntas_seguridad.php",{data:{preg_1:preg_1, preg_2:preg_2, preg_3:"", preg_4:""}, type:'post'}).done(function(respuesta){
								$("#pregunta_3").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Respuesta N°3:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="respuesta_3" id="respuesta_3" placeholder="Indique su respuesta 3" required autocomplete="off" title="Indique su respuesta" value="<?php echo $datos_actualizar['RESPUESTA_SEGURIDAD_3'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Pregunta N°4:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="pregunta_4" id="pregunta_4" required autocomplete="off" title="Seleccione una pregunta">
						<option><?php echo $datos_actualizar['PREGUNTA_SEGURIDAD_4'][0]; ?></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#pregunta_3").on('change', function(){
							var preg_1=$("#pregunta_1").val();
							var preg_2=$("#pregunta_2").val();
							var preg_3=$("#pregunta_3").val();
							$.ajax("PHP_MODELO/S_preguntas_seguridad.php",{data:{preg_1:preg_1, preg_2:preg_2, preg_3:preg_3, preg_4:""}, type:'post'}).done(function(respuesta){
								$("#pregunta_4").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Respuesta N°4:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="respuesta_4" id="respuesta_4" placeholder="Indique su respuesta 4" required autocomplete="off" title="Indique su respuesta" value="<?php echo $datos_actualizar['RESPUESTA_SEGURIDAD_4'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Pregunta N°5:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="pregunta_5" id="pregunta_5" required autocomplete="off" title="Seleccione una pregunta">
						<option><?php echo $datos_actualizar['PREGUNTA_SEGURIDAD_5'][0]; ?></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#pregunta_4").on('change', function(){
							var preg_1=$("#pregunta_1").val();
							var preg_2=$("#pregunta_2").val();
							var preg_3=$("#pregunta_3").val();
							var preg_4=$("#pregunta_4").val();
							$.ajax("PHP_MODELO/S_preguntas_seguridad.php",{data:{preg_1:preg_1, preg_2:preg_2, preg_3:preg_3, preg_4:preg_4}, type:'post'}).done(function(respuesta){
								$("#pregunta_5").html(respuesta);
							});
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Respuesta N°5:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="respuesta_5" id="respuesta_5" placeholder="Indique su respuesta 5" required autocomplete="off" title="Indique su respuesta" value="<?php echo $datos_actualizar['RESPUESTA_SEGURIDAD_5'][0]; ?>">
				</div>
				<h5 class="text-center text-warning">Datos Bancarios:</h5>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Nombre del Banco:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="banco_nombre" id="banco_nombre" required autocomplete="off" title="Seleccione un Banco">
						<option><?php echo $datos_actualizar['BANCO_NOMBRE'][0]; ?></option>
						<?php
							$datos_bancos=M_nombres_de_bancos();
							$i=0;
							while(isset($datos_bancos[$i])){
								echo "<option>" . $datos_bancos[$i] . "</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Tipo de Cuenta:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="banco_tipo" id="banco_tipo" required autocomplete="off" title="Seleccione un tipo de cuenta">
						<option><?php echo $datos_actualizar['BANCO_TIPO_CUENTA'][0]; ?></option>
						<option>Corriente</option>
						<option>Ahorro</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cedula o RIF:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="banco_cedula_rif" id="banco_cedula_rif" placeholder="Indique la cedula o RIF" required autocomplete="off" title="Indique la cedula o RIF correspondiente a la cuenta Bancaria" value="<?php echo $datos_actualizar['BANCO_CEDULA_RIF'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Teléfono:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="banco_telefono" id="banco_telefono" placeholder="Indique el Teléfono" required autocomplete="off" title="Indique el Teléfono correspondiente a la cuenta Bancaria" value="<?php echo $datos_actualizar['BANCO_TELEFONO'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Número de Cuenta:</span>
					</div>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="banco_cuenta" id="banco_cuenta" placeholder="Sólo números" required autocomplete="off" title="Indique su Número de Cuenta sin guiónes ni espacios" value="<?php echo $datos_actualizar['BANCO_NUMERO_CUENTA'][0]; ?>">
				</div>
				<h5 class="text-center text-warning" title="Adjunte su Foto de Perfil (en formato png y máximo 2 MegaBytes)">Foto/Logo del Perfil</h5>
				<h6 class="text-center text-light small">Sólo archivos jpg, jpeg, gif o png y máximo 2 MegaBytes</h6>
				<h6 class="text-center text-light small">Puedes convertir imágenes a formato png <a class="text-warning" href="https://convertio.co/es/jpg-png/" target="_blank">AQUÍ</a></h6>
				<div class="row">
					<div class="col-md-3">
						<img src="IMAGENES_USUARIOS/<?php echo $datos_actualizar['FOTO_LOGO'][0] . "?a=" . rand(); ?>" class="imgFit">
					</div>
					<div class="col-md-9">
						<input type='file' name='usuario_foto' id='usuario_foto' class="mb-2 w-100 bg-light text-dark p-2 rounded" title="Adjunte su Foto o Logo para el Perfil (en formato png y máximo 2 MegaBytes)">
					</div>
				</div>
				<div class="m-auto">
					<a href="CRUD_usuarios.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
		</div>
	<?php
		//SI SE QUIERE BORRAR UN RENGLON ENTONCES:
	}else if($_GET["accion"]=='borrar'){
		?>
		<br><br><br>
		<div class="col-md-12 col-lg-9 mx-auto">
			<form action="CRUD_usuarios.php" method="post" class="text-center bg-dark p-2 rounded">
				<h3 class="text-center text-light pb-3" title="Borrar un Renglón">¿Seguro que desea Borrar el renglón de ID <?php echo $_GET['NA_Id']; ?>?</h3>
				<input type="hidden" name="FORM" id="FORM" value="BORRAR">
				<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_GET["NA_Id"]; ?>">
				<div class="m-auto">
					<a href="CRUD_usuarios.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Borrar Renglón &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
			<br><br><br><br><br><br><br><br>
		</div>
		<?php
			//SI NO SE HIZO NINGUNA ACCIÓN:
		}else{
		?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_usuarios.php">
	<?php
	//CIERRE DE LA ETIQUETA PARA EMBUTIR HTML EN PHP
		}
	}else{
	?>
	<!-- DataTables Example -->
	<?php
	if(isset($verf_insert)){
		if($verf_insert==false){
			echo "<h3 class='text-center text-dark bg-danger my-2 py-2'>El Renglón que está intentando agregar <b>YA EXISTE</b></h3>";
		}
	}
	?>
	<div class="card mb-3 bg-dark rounded-0 col-12 col-lg-9 mx-auto px-0">
		<div class="card-header text-center text-warning">
			<h3 class='text-center'><span class="fa fa-database"></sapn> Registrados:</h3>
		</div>
		<div class="card-body px-1 bg-white">
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover TablaDinamica">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b title="Datos del Usuario">Usuario</b></th>
							<th class="align-middle h5 p-0"><a title="Insertar" href="CRUD_usuarios.php?accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Insertar</a></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//obteniendo los datos de la tabla:
						$datos=M_usuarios_R($conexion, '', '', '', '', '', '');
						$i=0;
						while(isset($datos['ID_USUARIO'][$i])){
							if($datos['ID_USUARIO'][$i]<>""){
								$datos_saldo_disp_i=M_saldo_pm_disponible_usuario($conexion, $datos['CEDULA_RIF'][$i]);
								$datos_saldo_dife_i=M_saldo_pm_diferido_usuario($conexion, $datos['CEDULA_RIF'][$i]);
								$datos_saldo_bloq_i=M_saldo_pm_bloqueado_usuario($conexion, $datos['CEDULA_RIF'][$i]);
								$datos_vendido_premiun_i= M_control_de_transacciones_compras_en_micoin_R($conexion, 'VENDEDOR_CEDULA_RIF', $datos['CEDULA_RIF'][$i], 'ESTATUS', 'PAGADO', 'TIPO_DE_COMPRA', 'PREMIUN');
								$datos_comprado_premiun_i= M_control_de_transacciones_compras_en_micoin_R($conexion, 'COMPRADOR_CEDULA_RIF', $datos['CEDULA_RIF'][$i], 'ESTATUS', 'PAGADO', 'TIPO_DE_COMPRA', 'PREMIUN');
								
								$premiun="NO";
								if(isset($datos_vendido_premiun_i['ESTATUS'][0])){
									if($datos_vendido_premiun_i['ESTATUS'][0]<>''){
										$premiun="SI";
									}
								}
								if(isset($datos_comprado_premiun_i['ESTATUS'][0])){
									if($datos_comprado_premiun_i['ESTATUS'][0]<>''){
										$premiun="SI";
									}
								}
								if(round($datos_saldo_disp_i['SALDO_PEMON'][0],2)<>0 or round($datos_saldo_dife_i['SALDO_PEMON'][0],2)<>0 or round($datos_saldo_bloq_i['SALDO_PEMON'][0],2)<>0 or $premiun=="SI"){
									$verf_usuario_borrar="NO";
								}else{
									$verf_usuario_borrar="SI";
								}
								echo "<tr>";
								echo "<td class='text-left'><div class='Container'><div class='row'><div class='col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2 ml-0'><img src='IMAGENES_USUARIOS/" . $datos['FOTO_LOGO'][$i] . "?a=" . rand() . "' class='w-100 imgFit'></div><div class='col-12 col-sm-7 col-md-8 col-lg-9 col-xl-10 ml-0'><b>Usuario: </b>" . $datos['NOMBRE'][$i] . " " . $datos['APELLIDO'][$i];
								if($datos['ACCESO'][$i]=="COMPRADOR-VENDEDOR"){
									echo "<br><e class='small'><b>" . $datos['BANCO_NOMBRE'][$i] . "</b>";
									echo "<br><b>Cta N°:</b> " . $datos['BANCO_NUMERO_CUENTA'][$i];
									echo "<br><b>C.I:</b> " . $datos['BANCO_CEDULA_RIF'][$i];
									echo "<br><b>Telf:</b> " . $datos['BANCO_TELEFONO'][$i] . "</e>";
								}else{
									echo "<br><b class='text-primary'>" . $datos['ACCESO'][$i] . "</b>";
								}
								echo "<br><b>Estatus:</b> " . $datos['ESTATUS'][$i] . "<br><b title='Saldo Disponible'>Saldo: </b>" . number_format($datos_saldo_disp_i['SALDO_PEMON'][0], 2,',','.') . "<br><b title='Saldo Diferido'>Dif: </b>" . number_format($datos_saldo_dife_i['SALDO_PEMON'][0], 2,',','.') . "<br><b title='Saldo Bloqueado'>Bloq: </b>" . number_format($datos_saldo_bloq_i['SALDO_PEMON'][0], 2,',','.') . "<br><b title='¿Tiene Ventas PREMIUN Pendientes?'>Pendientes: </b>" . $premiun . "</div></div></td>";
								if($verf_usuario_borrar=="SI"){
									echo "<td class='text-center h5'><a title='Modificar' href='CRUD_usuarios.php?accion=actualizar&NA_Id=" . $datos['ID_USUARIO'][$i] . "' class='btn btn-transparent text-success fa fa-edit d-inline'></a>";
									echo "<br>";
									echo "<a title='Eliminar' href='CRUD_usuarios.php?accion=borrar&NA_Id=" . $datos['ID_USUARIO'][$i] . "' class='btn btn-transparent text-danger fa fa-trash-o d-inline'></a></td>";
								}else{
									echo "<td class='text-center h5'><a title='Modificar' href='CRUD_usuarios.php?accion=actualizar&NA_Id=" . $datos['ID_USUARIO'][$i] . "' class='btn btn-transparent text-success fa fa-edit d-inline'></a>";
									echo "<br>";
									echo "<b class='text-danger small' title='No se puede Borrar este usuario por presentar saldo disponible u operaciones de venta de productos penientes'>No Borrar</b></td>";
								}
								echo "</tr>";
							}
							$i=$i+1;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	//CIERRE DE LA ETIQUETA PARA EMBUTIR HTML EN PHP		
	}
	?>	
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>