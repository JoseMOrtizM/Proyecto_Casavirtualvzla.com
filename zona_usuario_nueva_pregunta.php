<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	if(isset($_POST['pregunta'])){
		$pregunta_del_usuario=mysqli_real_escape_string($conexion,$_POST['pregunta']);
		$verf_carga=M_blog_interno_C($conexion, $datos_usuario_session['NOMBRE'][0], $datos_usuario_session['APELLIDO'][0], $datos_usuario_session['CEDULA_RIF'][0], $datos_usuario_session['CORREO'][0], $datos_usuario_session['FECHA_NACIMIENTO'][0], $pregunta_del_usuario, date("Y-m-d h:m:s"), '', '', '0', 'NO');
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Consultar</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid px-0 mx-0 mx-md-2 px-md-4 mt-2 mb-5 bg-transparent">
		<div class="container-fluid">
			<br><br>
			<?php
				if(isset($verf_carga)){
					if($verf_carga==true){
						echo "<h4 class='p-2 my-2 bg-dark text-center text-light'>Su pregunta fue cargada con <b class='text-success'>ÉXITO</b>. pronto le responderemos.</h4><br>";
					}else{
						echo "<h4 class='p-2 my-2 bg-dark text-center text-danger'>ERROR DUPLICADO: Su pregunta ya está registrada pronto le responderemos.</h4><br>";
					}
				}
			?>
			<h4 class='p-2 mt-2 mb-0 bg-dark text-center'><strong class='text-warning'>Hacer una Pregunta a la Casa Virtual:</strong></h4>
			<form action="zona_usuario_nueva_pregunta.php" method="post" class="text-center bg-dark p-2 rounded">
				<div class="input-group mb-2 text-left">
					<span class="input-group-text rounded-0 w-100">Pregunta:</span>
					<textarea class="form-control p-0 m-0 px-2 rounded-0" name="pregunta" id="pregunta" placeholder="Escribe tu pregunta aquí" required autocomplete="off" title="Introduzca su pregunta" rows="2"></textarea>
				</div>
				<script>
					$(document).ready(function() {
						$('#pregunta').summernote({
							placeholder: 'Introduzca su pregunta',
							tabsize: 1,
							height: 100								
						});
					});
				</script>
				<div class="m-auto">
					<input type="submit" value="Preguntar a CV" class="btn btn-warning mb-2">
				</div>
			</form>
		</div>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>