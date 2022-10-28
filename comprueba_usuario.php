<?php
require ("PHP_MODELO/M_todos.php");
require ("PHP_REQUIRES/datos_nav_busq_externos.php");
//COMPROBANDO USUARIO
$login=mysqli_real_escape_string($conexion,$_POST['correo']);
$password=mysqli_real_escape_string($conexion,$_POST["contrasena"]);
$datos_logging=M_usuarios_R($conexion, 'CORREO', $login, '', '', '', '');
if(password_verify($password,$datos_logging['CONTRASENA'][0])){
	if($datos_logging['ESTATUS'][0]=='SUSPENDIDO'){
		header("location:zona_usuario_suspendido.php");
	}else if($datos_logging['ESTATUS'][0]=='REGISTRADO'){
		session_start();
		$_SESSION["usuario"]=$login;
		header("location:test_de_activacion.php");
	}else if($datos_logging['ESTATUS'][0]==''){
		header("location:index.php");
	}else{
		$ips_de_navegacion=explode(" ", $datos_logging['IP_DE_NAVEGAION'][0]);
		$e=0;
		$verf_ip=false;
		while(isset($ips_de_navegacion[$e])){
			if($ips_de_navegacion[$e]==M_obtener_ip_real()){
				$verf_ip=true;
			}
			$e++;
		}
		if($verf_ip){
			session_start();
			$_SESSION["usuario"]=$login;
			header("location:zona_usuario.php");
		}else{
			//echo "<br><br><br><br>LAS IP SON DISTINTAS";
			if(isset($_POST['usuario_cedula_rif'])){
				//echo "<br><br><br><br>LA CEDULA EXISTE";
				$cedula=mysqli_real_escape_string($conexion,$_POST['usuario_cedula_rif']);
				$pregunta_1=mysqli_real_escape_string($conexion,$_POST['pregunta_1']);
				$respuesta_1=mysqli_real_escape_string($conexion,$_POST['respuesta_1']);
				$pregunta_2=mysqli_real_escape_string($conexion,$_POST['pregunta_2']);
				$respuesta_2=mysqli_real_escape_string($conexion,$_POST['respuesta_2']);
				$confirma_ip=mysqli_real_escape_string($conexion,$_POST['confirma_ip']);
				//OBTENIENDO DATOS DE USUARIO
				$datos_usuario_leidos=M_usuarios_R($conexion, 'CEDULA_RIF', $cedula, '', '', '', '');
				//VERIFICANDO RESPUESTAS
				//echo "<br><br><br><br>VERIFICANDO RESPUESTAS";
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
					//echo "<br><br><br><br>RESPUESTA 1 OK";
					$verf_preg_resp_1="ok";
				}else{
					//echo "<br><br><br><br>RESPUESTA 1 ERROR";
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
					//echo "<br><br><br><br>RESPUESTA 2 OK";
					$verf_preg_resp_2="ok";
				}else{
					//echo "<br><br><br><br>RESPUESTA 2 ERROR";
					$verf_preg_resp_2="error";
				}
				//ACCIONANDO EN FUNCION DE LAS RESPUESTAS CORRECTAS
				if($verf_preg_resp_1=="ok" and $verf_preg_resp_2=="ok"){
					//echo "<br><br><br><br>AMBAS RESPUESTAS OK";
					//SI EL USUARIO DESIDIÓ CAMBIAR SU IP HABITUAL
					if($confirma_ip=='SI'){
						//echo "<br><br><br><br>MANDÓ A CAMBIAR LA IP";
						//CAMBIANDO IP_NAVEGAION EN LA BASE DE DATOS
						$pi_temp=$datos_logging['IP_DE_NAVEGAION'][0] . " " . M_obtener_ip_real();
						M_usuarios_U_id_ip_nav($conexion, $datos_usuario_leidos['ID_USUARIO'][0], $pi_temp);
						session_start();
						$_SESSION["usuario"]=$login;
						header("location:zona_usuario.php?");
					//SI EL USUARIO DESIDIÓ NO CAMBIAR SU IP HABITUAL
					}else{
						//echo "<br><br><br><br>NO MANDÓ A CAMBIAR LA IP";
						session_start();
						$_SESSION["usuario"]=$login;
						header("location:zona_usuario.php");
					}
				//ACCIONANDO EN FUNCION DE LAS RESPUESTAS INCORRECTAS CORRECTAS
				}else{
					//echo "<br><br><br><br>ALGUNA DE LAS RESPUESTAS ERROR";
					session_start();
					session_destroy();
					header("location:index.php?user=invalido"); 
				}
			}else{
				//echo "<br><br><br><br>NO EXISTE LA CEDULA AUN";
				//NO EJECUTAR NINGUNA ACCIÓN PARA QUE SE PUEDA VER EL FORMULARIO DE ESTA HOJA
			}
		}		
	}
}else{
	//echo "<br><br><br><br>CONTRASEÑA INVALIDO";
	header("location:index.php?user=invalido");
}
?>
<!doctype html>
<html lang="es">
<head>
	<?php require ("PHP_REQUIRES/head_principal.php"); ?>
	<title>Autenticación de IP</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_principal.php") ?>
	<section class="my-5 pt-3 mx-0 mx-md-5">
		<div class="col-md-12 col-lg-9 col-xl-7 mx-auto bg-dark">
			<div class="row mt-4 rounded-top px-2">
				<h3 class="text-center text-md-left text-warning p-3 m-auto"><b>Autenticación de Usuario</b></h3>
			</div>
			<p class="px-3 text-light mb-0 text-left">Hemos detectado que está ingresando desde un equipo distinto al de uso habitual.</p>
			<p class="px-3 text-light mb-0 text-left">Por favor reponda las siguientes preguntas de Seguridad.</p>
			<form action="comprueba_usuario.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="correo" id="correo" value="<?php echo $login; ?>">
				<input type="hidden" name="contrasena" id="contrasena" value="<?php echo $password; ?>">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cédula o RIF:</span>
					</div>
					<?php
						$datos_usuario=M_usuarios_R($conexion, 'CORREO', $login, '', '', '', '');
					?>
					<input type="hidden" name="usuario_cedula_rif" id="usuario_cedula_rif" value="<?php echo $datos_usuario['CEDULA_RIF'][0]; ?>">
					<input type="text" disabled class="form-control col-md-9 p-0 m-0 px-2 rounded-0 bg-light text-dark" value="<?php echo $datos_usuario['CEDULA_RIF'][0]; ?>">
				</div>
				<div id="caja_preguntas"></div>
				<script type="text/javascript">
					$(document).ready(function(){
						var cedula=$("#usuario_cedula_rif").val();
						$.ajax("PHP_MODELO/S_pregunta_aleatoria_comp_usuario.php",{data:{cedula:cedula}, type:'post'}).done(function(respuesta){
							$("#caja_preguntas").hide();
							$("#caja_preguntas").html(respuesta);
							$("#caja_preguntas").fadeIn(500);
						});
					});
				</script>
			</form>
		</div>
		<br><br><br><br>
	</section>
	<?php require("PHP_REQUIRES/footer_principal.php") ?>
</body>
</html>