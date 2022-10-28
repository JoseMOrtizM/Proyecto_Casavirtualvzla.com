<?php
require ("PHP_MODELO/M_todos.php");
require ("PHP_REQUIRES/datos_nav_busq_externos.php"); 
//EN CASO DE QUE EL CLIENTE AGREGUE UN NUEVO USUARIO AQUÍ SE RESCATAN LOS DATOS DEL FORMULARIO Y SE INSERTAN A LA BASE DE DATOS:
if(isset($_POST['usuario_nombre'])){
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
	$fecha_de_ingreso=date("Y-m-d h:m:s");
	if(isset($_POST['fecha_nacimiento'])){
		$fecha_nacimiento=$_POST['fecha_nacimiento'];
	}else{
		$fecha_nacimiento=$fecha_de_ingreso;
	}
	$acceso="COMPRADOR-VENDEDOR";
	$estatus="REGISTRADO";
	$ip_de_navegacion="movil tablet " . M_obtener_ip_real();
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
			M_usuarios_C($conexion, $ip_de_navegacion, $nombre, $apellido, $empresa, $fecha_nacimiento, $cedula_rif, $telefono, $correo, $foto_usuario, $fecha_de_ingreso, $estado, $ciudad, $municipio, $parroquia, $direccion, $banco_nombre, $banco_numero_cuenta, $banco_tipo_cuenta, $banco_telefono, $banco_cedula_rif, $pregunta_1, $respuesta_1, $pregunta_2, $respuesta_2, $pregunta_3, $respuesta_3, $pregunta_4, $respuesta_4, $pregunta_5, $respuesta_5, $acceso, $estatus, "HIERRO", "NO", "NO");
			//MOVIENDO IMAGEN A LA CARPETA DE FOTOS_DE_EMPLEADOS DEL PROYECTO
			move_uploaded_file($ruta_temporal,$ruta_destino_con_foto);
			//GENERANDO CONTRASEÑA TEMPORAL
			$correo_y_contasena=M_generar_contrasena_temporal($conexion, $cedula_rif);
		}else{
			$foto_usuario="vacio.png";
			//INSERTANDO SIN FOTO
			M_usuarios_C($conexion, $ip_de_navegacion, $nombre, $apellido, $empresa, $fecha_nacimiento, $cedula_rif, $telefono, $correo, $foto_usuario, $fecha_de_ingreso, $estado, $ciudad, $municipio, $parroquia, $direccion, $banco_nombre, $banco_numero_cuenta, $banco_tipo_cuenta, $banco_telefono, $banco_cedula_rif, $pregunta_1, $respuesta_1, $pregunta_2, $respuesta_2, $pregunta_3, $respuesta_3, $pregunta_4, $respuesta_4, $pregunta_5, $respuesta_5, $acceso, $estatus, "HIERRO", "NO", "NO");
			//no se mueve ninguna imagen ya que la imagen VACIO.PNG esta predeterminada en la carpeta de imagenes de usuarios
			//GENERANDO CONTRASEÑA TEMPORAL
			$correo_y_contasena=M_generar_contrasena_temporal($conexion, $cedula_rif);
		}
	}else{
		$foto_usuario="vacio.png";
		//INSERTANDO SIN FOTO
		M_usuarios_C($conexion, $ip_de_navegacion, $nombre, $apellido, $empresa, $fecha_nacimiento, $cedula_rif, $telefono, $correo, $foto_usuario, $fecha_de_ingreso, $estado, $ciudad, $municipio, $parroquia, $direccion, $banco_nombre, $banco_numero_cuenta, $banco_tipo_cuenta, $banco_telefono, $banco_cedula_rif, $pregunta_1, $respuesta_1, $pregunta_2, $respuesta_2, $pregunta_3, $respuesta_3, $pregunta_4, $respuesta_4, $pregunta_5, $respuesta_5, $acceso, $estatus, "HIERRO", "NO", "NO");
		//no se mueve ninguna imagen ya que la imagen VACIO.PNG esta predeterminada en la carpeta de imagenes de usuarios
		//GENERANDO CONTRASEÑA TEMPORAL
		$correo_y_contasena=M_generar_contrasena_temporal($conexion, $cedula_rif);
	}
	//INFORMANDO TODO OK
	$verf_datos_insertados="si";
}else{
	$verf_datos_insertados="no";
}
?>
<!doctype html>
<html>
<head>
	<?php require ("PHP_REQUIRES/head_principal.php"); ?>
	<title>Registro Usuario</title>
</head>
<body class="bg-secondary">
	<?php require ("PHP_REQUIRES/nav_principal.php"); ?>
	<?php
		//IMPRIMIENDO INFORMACIÓN EN CASO DE DATOS INSERTADOS CON ÉXITO
		if($verf_datos_insertados=="si"){
	?>
	<section class="my-5 pt-3 mx-0 mx-md-5">
		<div class="col-md-12 col-lg-9 col-xl-7 mx-auto bg-dark">
			<div class="row mt-4 align-items-center rounded-top px-2">
				<div class="col-md-9 mb-1 mt-3">
					<h3 class="text-center text-md-left text-warning"><b class="text-success">Registro EXITOSO</b></h3>
				</div>
				<div class="col-md-3 text-center text-md-right mb-1 mt-3">
					<a href="index.php" class="btn btn-danger text-light mb-2"><span class="fa fa-reply-all"></span> al Inicio</a>
				</div>
			</div>
			<div class="input-group mb-2">
				<div class="col-md-3 p-0 m-0">
					<span class="input-group-text rounded-0 w-100">Nombre:</span>
				</div>
				<div class="form-control col-md-9 p-0 m-0 px-2 rounded-0 pt-1">
					<?php echo $nombre; ?>
				</div>
			</div>
			<div class="input-group mb-2">
				<div class="col-md-3 p-0 m-0">
					<span class="input-group-text rounded-0 w-100">Apellido:</span>
				</div>
				<div class="form-control col-md-9 p-0 m-0 px-2 rounded-0 pt-1">
					<?php echo $apellido; ?>
				</div>
			</div>
			<div class="input-group mb-2">
				<div class="col-md-3 p-0 m-0">
					<span class="input-group-text rounded-0 w-100">Cédula o RIF:</span>
				</div>
				<div class="form-control col-md-9 p-0 m-0 px-2 rounded-0 pt-1">
					<?php echo $cedula_rif; ?>
				</div>
			</div>
			<div class="input-group mb-2">
				<div class="col-md-3 p-0 m-0">
					<span class="input-group-text rounded-0 w-100">Email:</span>
				</div>
				<div class="form-control col-md-9 p-0 m-0 px-2 rounded-0 pt-1">
					<?php echo $correo; ?>
				</div>
			</div>
			<h4 class="text-center text-warning">* Contraseña temporal:</h4>
			<h6 class="text-center text-light text-left">Recuerde esta contraseña hasta que pase nuestro Test de Activación e ingrese con su sesión donde podrá cambiarla en las opciones de su perfil de usuario</h6>
			<div class="input-group mb-2">
				<div class="col-md-3 p-0 m-0">
					<span class="input-group-text rounded-0 w-100">* Contraseña:</span>
				</div>
				<div class="form-control col-md-9 p-0 m-0 px-2 rounded-0 pt-1" title="Contraseña temporal"><?php echo $correo_y_contasena['CONTRASENA']; ?></div>
			</div>
			<h5 class="text-center text-warning" title="Adjunte su Foto de Perfil (en formato png y máximo 2 MegaBytes)">Foto/Logo del Perfil</h5>
			<div class="marco-ajustado hidden rounded border border-secondary w-25 m-auto">
				<img src="IMAGENES_USUARIOS/<?php echo $foto_usuario . "?a=" . rand(); ?>" class="imgFit">
			</div>
			<h6 class="text-center text-light text-left">Ahora desde ir al menu de navegación superior e ingresar tu usuario y contraseña para continuar con el proceso de activación de tu cuenta de usuario.</h6>
			<div class="text-center mb-1 mt-3">
				<a href="index.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Al Inicio</a>
			</div>
		</div>
	</section>
	<?php 
		}else{
	?>
	<section class="my-5 pt-3 mx-0 mx-md-5">
		<div class="col-md-12 col-lg-9 col-xl-7 mx-auto bg-dark">
			<div class="row mt-4 align-items-center rounded-top px-2">
				<div class="col-md-9 mb-1 mt-3">
					<h3 class="text-center text-md-left text-warning" title="Formulario para registro de Nuevos Usuarios">Registro de Usuario:</h3>
				</div>
				<div class="col-md-3 text-center text-md-right mb-1 mt-3">
					<a href="index.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> al Inicio</a>
				</div>
			</div>
			<div class="bg-light text-dark text-left mx-2 py-2 px-4">
				<h5><b class="text-danger h4"><b>IMPORTANTE: </b></b>Luego de registrar tus datos <b>activa tu cuenta</b> respondiendo nuestro <b>Test de Activación</b> que te ayudará a conocer mejor nuestras <a href="politicas.php">Políticas</a> y <a href="condiciones.php">Condiciones de Uso</a>.</h5>
			</div>
			<br>
			<!-- INICIO FORMULARIO DE REGISTRO-->
			
			
			<form action="form_registro_usuario.php" method="post" class="text-center bg-dark p-2 rounded" enctype="multipart/form-data">
				<h5 class="text-center text-warning">Datos Generales:</h5>
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
								$("#caja_para_fecha_nacimiento").fadeIn(500);
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
								$("#caja_para_fecha_nacimiento").fadeOut(500);
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
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_telefono" id="usuario_telefono" placeholder="Ej: 0414-1234567" required autocomplete="off" title="Introduzca su número de teléfono">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Email:</span>
					</div>
					<input type="email" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_correo" id="usuario_correo" placeholder="Ej: usuario@correo.com" required autocomplete="off" title="Introduzca su correo electrónico">
				</div>
				<h5 class="text-center text-warning">Datos de Ubicación:</h5>
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
				<div class="input-group mb-2">
					<span class="input-group-text rounded-0 w-100">Dirección:</span>
					<textarea class="form-control p-0 m-0 px-2 rounded-0" name="usuario_direccion" id="usuario_direccion" placeholder="Introduzca su dirección" required autocomplete="off" title="Introduzca su dirección" rows="2"></textarea>
				</div>
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
				<h6 class="text-center text-light py-2">Al registrarte estás aceptando las <a href="politicas.php" class="text-warning">políticas</a> y <a href="condiciones.php"  class="text-warning">condiciones de Uso</a> de nuestro Sitio Web.</h6>
					<a href="index.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> al Inicio</a>&nbsp;&nbsp;<input type="submit" value="Registrar Usuario &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
			
			
			
			<!-- final del formulario de registro -->
		</div>
	</section>
	<?php
		}
	?>
	<?php require ("PHP_REQUIRES/footer_principal.php"); ?>
</body>
</html>