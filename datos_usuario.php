<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
$verf_contrasena="";
if(isset($_POST['FORM'])){
	if($_POST['FORM']=='MODIFICAR'){
		$id_usuario=mysqli_real_escape_string($conexion,$_POST['id_usuario']);
		$nombre=mysqli_real_escape_string($conexion,$_POST['usuario_nombre']);
		$apellido=mysqli_real_escape_string($conexion,$_POST['usuario_apellido']);
		$empresa=$datos_usuario_session['EMPRESA'][0];
		$cedula_rif=$datos_usuario_session['CEDULA_RIF'][0];
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
		$acceso=$datos_usuario_session['ACCESO'][0];
		$ip_de_navegacion=$datos_usuario_session['IP_DE_NAVEGAION'][0];
		$fecha_de_ingreso=$datos_usuario_session['FECHA_DE_INGRESO'][0];
		$fecha_nacimiento=$datos_usuario_session['FECHA_NACIMIENTO'][0];
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
				M_usuarios_U_id($conexion, $id_usuario, $ip_de_navegacion, $nombre, $apellido, $empresa, $fecha_nacimiento, $cedula_rif, $telefono, $correo, $foto_usuario, $fecha_de_ingreso, $estado, $ciudad, $municipio, $parroquia, $direccion, $banco_nombre, $banco_numero_cuenta, $banco_tipo_cuenta, $banco_telefono, $banco_cedula_rif, $pregunta_1, $respuesta_1, $pregunta_2, $respuesta_2, $pregunta_3, $respuesta_3, $pregunta_4, $respuesta_4, $pregunta_5, $respuesta_5, $acceso, $datos_usuario_session['ESTATUS'][0], $datos_usuario_session['RANKING'][0], $datos_usuario_session['ALIADO'][0], $datos_usuario_session['INDICADORES'][0]);
				//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
				//copy($ruta_temporal,$ruta_destino_con_foto);
				move_uploaded_file($ruta_temporal,$ruta_destino_con_foto);
			}else{
				$foto_usuario=$datos_usuario_session['FOTO_LOGO'][0];
				//INSERTANDO SIN FOTO
				M_usuarios_U_id($conexion, $id_usuario, $ip_de_navegacion, $nombre, $apellido, $empresa, $fecha_nacimiento, $cedula_rif, $telefono, $correo, $foto_usuario, $fecha_de_ingreso, $estado, $ciudad, $municipio, $parroquia, $direccion, $banco_nombre, $banco_numero_cuenta, $banco_tipo_cuenta, $banco_telefono, $banco_cedula_rif, $pregunta_1, $respuesta_1, $pregunta_2, $respuesta_2, $pregunta_3, $respuesta_3, $pregunta_4, $respuesta_4, $pregunta_5, $respuesta_5, $acceso, $datos_usuario_session['ESTATUS'][0], $datos_usuario_session['RANKING'][0], $datos_usuario_session['ALIADO'][0], $datos_usuario_session['INDICADORES'][0]);
				//no se mueve ninguna imagen ya que la imagen VACIO.PNG esta predeterminada en la carpeta de imagenes de usuarios
			}
		}else{
			$foto_usuario=$datos_usuario_session['FOTO_LOGO'][0];
			//INSERTANDO SIN FOTO
			M_usuarios_U_id($conexion, $id_usuario, $ip_de_navegacion, $nombre, $apellido, $empresa, $fecha_nacimiento, $cedula_rif, $telefono, $correo, $foto_usuario, $fecha_de_ingreso, $estado, $ciudad, $municipio, $parroquia, $direccion, $banco_nombre, $banco_numero_cuenta, $banco_tipo_cuenta, $banco_telefono, $banco_cedula_rif, $pregunta_1, $respuesta_1, $pregunta_2, $respuesta_2, $pregunta_3, $respuesta_3, $pregunta_4, $respuesta_4, $pregunta_5, $respuesta_5, $acceso, $datos_usuario_session['ESTATUS'][0], $datos_usuario_session['RANKING'][0], $datos_usuario_session['ALIADO'][0], $datos_usuario_session['INDICADORES'][0]);
			//no se mueve ninguna imagen ya que la imagen VACIO.PNG esta predeterminada en la carpeta de imagenes de usuarios
		}
	}
	//VERIFICANDO CAMBIO DE CONTRASEÑA
	if(isset($_POST['contrasena_anterior'])){
		if($_POST['contrasena_anterior']<>'' and $_POST['contrasena_nueva']<>''){
			if(password_verify($_POST['contrasena_anterior'],$datos_usuario_session['CONTRASENA'][0])){
				$nueva_contrasena2=mysqli_real_escape_string($conexion,$_POST['contrasena_nueva']);
				$nueva_contrasena_encryptada2=password_hash($nueva_contrasena2,PASSWORD_DEFAULT);
				M_usuarios_U_id_ip_contrasena($conexion, $datos_usuario_session['ID_USUARIO'][0], $nueva_contrasena_encryptada2);
				$verf_contrasena="<h3 class='text-center text-dark bg-success'>Contraseña cambiada con EXITO</h3>";
				?>
				<script type="text/javascript">
					alert("Contraseña cambiada con EXITO");
				</script>
				<?php
			}else{
				$verf_contrasena="<h3 class='text-center text-dark bg-danger'>No se pudo cambiar su Contraseña</h3>";
				?>
				<script type="text/javascript">
					alert("No se pudo cambiar su Contraseña");
				</script>
				<?php
			}
		}
	}
	//REFRESCAR LA PAGINA
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=datos_usuario.php'>";
}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Mis Datos</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid px-0 mx-0 mx-md-2 px-md-4 mt-2 mb-5 bg-secondary">
		<br>
		<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark pt-2">
			<?php echo $verf_contrasena; ?>
			<div class="row mt-1 align-items-center rounded-top px-2">
				<div class="col-md-9 mb-1 mt-0">
					<h3 class="text-center text-md-left text-warning" title="Formulario para Actualización de datos de Usuario">Modificar mis datos:</h3>
				</div>
				<div class="col-md-3 text-center text-md-right mb-1 mt-3">
					<a href="zona_usuario.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver al Inicio</a>
				</div>
			</div>
			<?php
				if($datos_usuario_session['ACCESO'][0]=="COMPRADOR-VENDEDOR"){
			?>
				<h5 class="text-center text-light"><e class='text-muted'>Otros usuarios te ven como:</e><br><?php echo "" . $datos_usuario_session['NOMBRE'][0] . " " . $datos_usuario_session['APELLIDO'][0] . " (V-" . str_pad($datos_usuario_session['ID_USUARIO'][0], 4, "0", STR_PAD_LEFT) . ")"; ?></h5>
			<?php
				}
			?>
			<form action="datos_usuario.php" method="post" class="text-center bg-dark p-2 rounded" enctype="multipart/form-data">
				<input type="hidden" name="FORM" id="FORM" value="MODIFICAR">
				<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $datos_usuario_session['ID_USUARIO'][0]; ?>">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cédula o RIF:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_cedula_rif" id="usuario_cedula_rif" placeholder="Indique cédula o RIF" required autocomplete="off" title="Introduzca su Cédula si es persona natural o su RIF si es una Empresa" value="<?php echo $datos_usuario_session['CEDULA_RIF'][0]; ?>" disabled>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Nombre:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_nombre" id="usuario_nombre" placeholder="Ej: José Antonio" required autocomplete="off" title="Introduzca su nombre" value="<?php echo $datos_usuario_session['NOMBRE'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Apellido:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_apellido" id="usuario_apellido" placeholder="Ej: Gonzalez Herrera" required autocomplete="off" title="Introduzca su apellido" value="<?php echo $datos_usuario_session['APELLIDO'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Teléfono:</span>
					</div>
					<input type="tel" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_telefono" id="usuario_telefono" placeholder="Ej: 0414-1234567" required autocomplete="off" title="Introduzca su número de teléfono" value="<?php echo $datos_usuario_session['TELEFONO'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Email:</span>
					</div>
					<input type="email" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_correo" id="usuario_correo" placeholder="Ej: usuario@correo.com" required autocomplete="off" title="Introduzca su correo electrónico" value="<?php echo $datos_usuario_session['CORREO'][0]; ?>">
				</div>
				<h5 class="text-center text-warning">Cambio de Contraseña (Opcional):</h5>
				<div class="input-group mb-2">
					<div class="col-md-6 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Contraseña Anterior:</span>
					</div>
					<input type="password" class="form-control col-md-6 p-0 m-0 px-2 rounded-0" name="contrasena_anterior" id="contrasena_anterior" placeholder="Contraseña anterior" autocomplete="off" title="Contraseña anterior">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-6 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Nueva Contraseña:</span>
					</div>
					<input type="password" class="form-control col-md-6 p-0 m-0 px-2 rounded-0" name="contrasena_nueva" id="contrasena_nueva" placeholder="Contraseña nueva" autocomplete="off" title="Contraseña nueva">
				</div>
				<h5 class="text-center text-warning">Datos de Ubicación:</h5>
				<div class="input-group mb-2">
					<span class="input-group-text rounded-0 w-100">Dirección:</span>
					<textarea class="form-control p-0 m-0 px-2 rounded-0" name="usuario_direccion" id="usuario_direccion" placeholder="Introduzca su dirección" required autocomplete="off" title="Introduzca su dirección" rows="2"><?php echo $datos_usuario_session['DIRECCION'][0]; ?></textarea>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Estado:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_estado" id="usuario_estado" required autocomplete="off" title="Indique el Estado">
						<option><?php echo $datos_usuario_session['ESTADO'][0]; ?></option>
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
						<option><?php echo $datos_usuario_session['CIUDAD'][0]; ?></option>
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
						<option><?php echo $datos_usuario_session['MUNICIPIO'][0]; ?></option>
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
						<option><?php echo $datos_usuario_session['PARROQUIA'][0]; ?></option>
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
						<option><?php echo $datos_usuario_session['PREGUNTA_SEGURIDAD_1'][0]; ?></option>
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
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="respuesta_1" id="respuesta_1" placeholder="Indique su respuesta 1" required autocomplete="off" title="Indique su respuesta" value="<?php echo $datos_usuario_session['RESPUESTA_SEGURIDAD_1'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Pregunta N°2:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="pregunta_2" id="pregunta_2" required autocomplete="off" title="Seleccione una pregunta">
						<option><?php echo $datos_usuario_session['PREGUNTA_SEGURIDAD_2'][0]; ?></option>
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
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="respuesta_2" id="respuesta_2" placeholder="Indique su respuesta 2" required autocomplete="off" title="Indique su respuesta" value="<?php echo $datos_usuario_session['RESPUESTA_SEGURIDAD_2'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Pregunta N°3:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="pregunta_3" id="pregunta_3" required autocomplete="off" title="Seleccione una pregunta">
						<option><?php echo $datos_usuario_session['PREGUNTA_SEGURIDAD_3'][0]; ?></option>
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
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="respuesta_3" id="respuesta_3" placeholder="Indique su respuesta 3" required autocomplete="off" title="Indique su respuesta" value="<?php echo $datos_usuario_session['RESPUESTA_SEGURIDAD_3'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Pregunta N°4:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="pregunta_4" id="pregunta_4" required autocomplete="off" title="Seleccione una pregunta">
						<option><?php echo $datos_usuario_session['PREGUNTA_SEGURIDAD_4'][0]; ?></option>
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
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="respuesta_4" id="respuesta_4" placeholder="Indique su respuesta 4" required autocomplete="off" title="Indique su respuesta" value="<?php echo $datos_usuario_session['RESPUESTA_SEGURIDAD_4'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Pregunta N°5:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="pregunta_5" id="pregunta_5" required autocomplete="off" title="Seleccione una pregunta">
						<option><?php echo $datos_usuario_session['PREGUNTA_SEGURIDAD_5'][0]; ?></option>
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
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="respuesta_5" id="respuesta_5" placeholder="Indique su respuesta 5" required autocomplete="off" title="Indique su respuesta" value="<?php echo $datos_usuario_session['RESPUESTA_SEGURIDAD_5'][0]; ?>">
				</div>
				<h5 class="text-center text-warning">Datos Bancarios:</h5>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Nombre del Banco:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="banco_nombre" id="banco_nombre" required autocomplete="off" title="Seleccione un Banco">
						<option><?php echo $datos_usuario_session['BANCO_NOMBRE'][0]; ?></option>
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
						<option><?php echo $datos_usuario_session['BANCO_TIPO_CUENTA'][0]; ?></option>
						<option>Corriente</option>
						<option>Ahorro</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cedula o RIF:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="banco_cedula_rif" id="banco_cedula_rif" placeholder="Indique la cedula o RIF" required autocomplete="off" title="Indique la cedula o RIF correspondiente a la cuenta Bancaria" value="<?php echo $datos_usuario_session['BANCO_CEDULA_RIF'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Teléfono:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="banco_telefono" id="banco_telefono" placeholder="Indique el Teléfono" required autocomplete="off" title="Indique el Teléfono correspondiente a la cuenta Bancaria" value="<?php echo $datos_usuario_session['BANCO_TELEFONO'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Número de Cuenta:</span>
					</div>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="banco_cuenta" id="banco_cuenta" placeholder="Sólo números" required autocomplete="off" title="Indique su Número de Cuenta sin guiónes ni espacios" value="<?php echo $datos_usuario_session['BANCO_NUMERO_CUENTA'][0]; ?>">
				</div>
				<h5 class="text-center text-warning" title="Adjunte su Foto de Perfil (en formato png y máximo 2 MegaBytes)">Foto/Logo del Perfil</h5>
				<h6 class="text-center text-light small">Sólo archivos jpg, jpeg, gif o png y máximo 2 MegaBytes</h6>
				<h6 class="text-center text-light small">Puedes convertir imágenes a formato png <a class="text-warning" href="https://convertio.co/es/jpg-png/" target="_blank">AQUÍ</a></h6>
				<div class="row">
					<div class="col-md-3">
						<img src="IMAGENES_USUARIOS/<?php echo $datos_usuario_session['FOTO_LOGO'][0] . "?a=" . rand(); ?>" class="imgFit">
					</div>
					<div class="col-md-9">
						<input type='file' name='usuario_foto' id='usuario_foto' class="mb-2 w-100 bg-light text-dark p-2 rounded" title="Adjunte su Foto o Logo para el Perfil (en formato png y máximo 2 MegaBytes)">
					</div>
				</div>
				<div class="m-auto">
					<a href="zona_usuario.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver al Inicio</a>&nbsp;&nbsp;<input type="submit" value="Actualizar Datos" class="btn btn-warning mb-2">
				</div>
			</form>
		</div>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>