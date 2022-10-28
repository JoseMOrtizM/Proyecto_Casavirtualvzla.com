<?php
	//aqui va lo que debe hacer la pagina en caso de que se hayan introducido los datos de recuperación de usuario y se le de al boton de Validar Usuario
	require ("PHP_MODELO/M_todos.php");
	require ("PHP_REQUIRES/datos_nav_busq_externos.php"); 
	$verf_preg_resp_1="";
	$verf_preg_resp_2="";
	if(isset($_POST['usuario_cedula_rif'])){
		$cedula=mysqli_real_escape_string($conexion,$_POST['usuario_cedula_rif']);
		$pregunta_1=mysqli_real_escape_string($conexion,$_POST['pregunta_1']);
		$respuesta_1=mysqli_real_escape_string($conexion,$_POST['respuesta_1']);
		$pregunta_2=mysqli_real_escape_string($conexion,$_POST['pregunta_2']);
		$respuesta_2=mysqli_real_escape_string($conexion,$_POST['respuesta_2']);
		$datos_usuario_leidos=M_usuarios_R($conexion, 'CEDULA_RIF', $cedula, '', '', '', '');
		if(($pregunta_1==$datos_usuario_leidos['PREGUNTA_SEGURIDAD_1'][0] and 
			$respuesta_1==$datos_usuario_leidos['RESPUESTA_SEGURIDAD_1'][0]) or 
			($pregunta_1==$datos_usuario_leidos['PREGUNTA_SEGURIDAD_2'][0] and 
			$respuesta_1==$datos_usuario_leidos['RESPUESTA_SEGURIDAD_2'][0]) or 
			($pregunta_1==$datos_usuario_leidos['PREGUNTA_SEGURIDAD_3'][0] and 
			$respuesta_1==$datos_usuario_leidos['RESPUESTA_SEGURIDAD_3'][0]) or 
			($pregunta_1==$datos_usuario_leidos['PREGUNTA_SEGURIDAD_4'][0] and 
			$respuesta_1==$datos_usuario_leidos['RESPUESTA_SEGURIDAD_4'][0]) or 
			($pregunta_1==$datos_usuario_leidos['PREGUNTA_SEGURIDAD_5'][0] and 
			$respuesta_1==$datos_usuario_leidos['RESPUESTA_SEGURIDAD_5'][0])){
			$verf_preg_resp_1="ok";
		}else{
			$verf_preg_resp_1="error";
		}
		if(($pregunta_2==$datos_usuario_leidos['PREGUNTA_SEGURIDAD_1'][0] and 
			$respuesta_2==$datos_usuario_leidos['RESPUESTA_SEGURIDAD_1'][0]) or 
			($pregunta_2==$datos_usuario_leidos['PREGUNTA_SEGURIDAD_2'][0] and 
			$respuesta_2==$datos_usuario_leidos['RESPUESTA_SEGURIDAD_2'][0]) or 
			($pregunta_2==$datos_usuario_leidos['PREGUNTA_SEGURIDAD_3'][0] and 
			$respuesta_2==$datos_usuario_leidos['RESPUESTA_SEGURIDAD_3'][0]) or 
			($pregunta_2==$datos_usuario_leidos['PREGUNTA_SEGURIDAD_4'][0] and 
			$respuesta_2==$datos_usuario_leidos['RESPUESTA_SEGURIDAD_4'][0]) or 
			($pregunta_2==$datos_usuario_leidos['PREGUNTA_SEGURIDAD_5'][0] and 
			$respuesta_2==$datos_usuario_leidos['RESPUESTA_SEGURIDAD_5'][0])){
			$verf_preg_resp_2="ok";
		}else{
			$verf_preg_resp_2="error";
		}
		if($verf_preg_resp_1=="ok" and $verf_preg_resp_2=="ok"){
			$respuesta=M_generar_contrasena_temporal($conexion,$cedula);
		}
	}
?>
<!doctype html>
<html lang="es">
<head>
	<?php require ("PHP_REQUIRES/head_principal.php"); ?>
	<title>Recupera tus datos</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_principal.php") ?>
	<section class="my-5 pt-3 mx-0 mx-md-5">
		<div class="col-md-12 col-lg-9 col-xl-7 mx-auto bg-dark">
			<div class="row mt-4 rounded-top px-2">
			<?php
				if(isset($respuesta['CORREO'])){
					echo "<h1 class='text-warning text-center ml-5'><b>Los datos recuperados son:</b></h1>";
					echo "<h4 class='text-white text-center ml-5'>CORREO: <b class='text-success'>" . $respuesta['CORREO'] . "</b></h4>";
					echo "<h4 class='text-white text-center ml-5'>CONTRASEÑA TEMPORAL: <b class='text-success'>" . $respuesta['CONTRASENA'] . "</b></h4>";
				}else if($verf_preg_resp_1=="error" or $verf_preg_resp_2=="error"){
					echo "<h3 class='text-danger text-center ml-5'><b>Datos Invalidos.</b></h3>";
				}
			?>
				<h3 class="text-center text-md-left text-warning p-3 m-auto" title="Formulario para registro de Nuevos Usuarios"><b>Formulario para recuperación de datos</b></h3>
			</div>
			<p class="px-3 text-center text-light mb-0">Para recuperar su Correo y Contraseña, por favor, complete la siguiente información:</p>
			<form action="form_recuperar_datos.php" method="post" class="text-center bg-dark p-2 rounded">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cédula o RIF:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="usuario_cedula_rif" id="usuario_cedula_rif" placeholder="Indique cédula o RIF" required autocomplete="off" title="Introduzca su Cédula si es persona natural o su RIF si es una Empresa">
				</div>
				<div id="caja_preguntas">
					<div class='input-group mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100' style='height: 50px;'>Pregunta N°1:</span>
						</div>
						<div class='col-md-9 p-0 m-0 px-2 rounded-0 pt-1 text-left bg-light' style='height: 50px;'>
						</div>
					</div>
					<div class='input-group mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100'>Respuesta N°1:</span>
						</div>
						<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='respuesta_1' id='respuesta_1' placeholder='Indique su respuesta 1' required autocomplete='off' title='Indique su respuesta'>
					</div>
					<div class='input-group mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100' style='height: 50px;'>Pregunta N°2:</span>
						</div>
						<div class='col-md-9 p-0 m-0 px-2 rounded-0 pt-1 text-left bg-light' style='height: 50px;'>
						</div>
					</div>
					<div class='input-group mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100'>Respuesta N°2:</span>
						</div>
						<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='respuesta_2' id='respuesta_2' placeholder='Indique su respuesta 2' required autocomplete='off' title='Indique su respuesta'>
					</div>
					<div class='m-auto pt-2'>
						<a href='index.php' class='btn btn-warning text-dark mb-2'><span class='fa fa-reply-all'></span> Volver</a>&nbsp;&nbsp;<input type='submit' value='Validar Usuario &raquo;' class='btn btn-warning mb-2'>
					</div>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#usuario_cedula_rif").on('focusout', function(){
							var cedula=$("#usuario_cedula_rif").val();
							$.ajax("PHP_MODELO/S_pregunta_aleatoria_rec_datos.php",{data:{cedula:cedula}, type:'post'}).done(function(respuesta){
								$("#caja_preguntas").hide();
								$("#caja_preguntas").html(respuesta);
								$("#caja_preguntas").fadeIn(500);
							});
						});
					});
				</script>
			</form>
		</div>
	</section>
	<?php require("PHP_REQUIRES/footer_principal.php") ?>
</body>
</html>