<?php
	require ("PHP_MODELO/M_todos.php");
	require ("PHP_REQUIRES/datos_nav_busq_externos.php"); 
	if(isset($_POST['recibido'])){
		if($_POST['recibido']=='si'){
			$visitante_ip=M_obtener_ip_real();
			$visitante_nombre= mysqli_real_escape_string($conexion,$_POST['nombre']);
			$visitante_correo= mysqli_real_escape_string($conexion,$_POST['correo']);
			$comentario= mysqli_real_escape_string($conexion,$_POST['mensaje']);
			$fh_comentario=date("Y-m-d h:m:s");
			$verf=M_blog_externo_C($conexion, $visitante_ip, $visitante_nombre, $visitante_correo, $comentario, $fh_comentario, "", "0000-00-00 00:00:00", "0", "NO");
		}
	}
?>
<!doctype html>
<html lang="es">
<head>
	<?php require ("PHP_REQUIRES/head_principal.php"); ?>
	<title>Contáctanos</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_principal.php") ?>
	<section class="my-5 pt-3 mx-0 mx-md-5">
		<!--
		<div class="col-md-12 col-lg-9 col-xl-7 mx-auto bg-dark p-0">
			<h3 class="text-center text-warning p-3 m-auto"><b>¿Donde Ubicarnos?</b></h3>
			<h6 class="text-center text-md-left text-dark bg-light p-3 m-auto"><address><span class="text-danger fa fa-map-marker"></span> <?php echo $empresa_cv_direccion; ?></address></h6>
		</div>
		-->
		<br>
		<div class="col-md-12 col-lg-9 col-xl-7 mx-auto bg-dark p-0">
			<h3 class="text-center text-warning p-3 pt-0 m-auto"><b>Nuestros Representantes</b></h3>
			<table class="table table-hover text-center m-auto bg-light">
				<tr>
					<td class="align-middle"><img src='img/jimmy_cova.png?a=<?php echo rand(); ?>' alt='Foto Gerente Administrativo' title='Foto Gerente Administrativo' width='90px' height='85px' class='m-auto rounded'></td>
					<td class="align-middle"><b>Gerente Administrativo</b><br>Jimmy Cova<br><span class='text muted fa fa-phone'></span> <span class='text muted fa fa-whatsapp'></span> <b>+58 412-4641122</b></td>
				</tr>
				<tr>
					<td class="align-middle"><img src='img/jose_ortiz.png?a=<?php echo rand(); ?>' alt='Foto Gerente Operaciones' title='Foto Gerente Operaciones' width='90px' height='85px' class='m-auto rounded'></td>
					<td class="align-middle"><b>Gerente Operaciones</b><br>José Ortiz<br><span class='text muted fa fa-phone'></span> <span class='text muted fa fa-whatsapp'></span> <b>+58 414-8609152</b></td>
				</tr>
			</table>
		</div>
		<div class="col-md-12 col-lg-9 col-xl-7 mx-auto bg-dark">
			<?php
				if(isset($verf)){
					if($verf){
						echo "<h3 class='text-center text-success pt-2 pb-0 mb-0'>Tu mensaje fue recibido con ÉXITO.</h3>";
					}else{
						echo "<h5 class='text-center text-danger pt-2 pb-0 mb-0'>Tu mensaje no pudo ser procesado, inténtalo más tarde.</h5>";
					}
				}
			?>
			<div class="row mt-4 rounded-top px-2">
				<h3 class="text-center text-md-left text-warning p-3 pt-0 m-auto" title="Formulario para registro de Nuevos Usuarios"><b>Formulario de Contacto</b></h3>
			</div>
			<form action="form_contactanos.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" id="recibido" name="recibido" value="si">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Nombre:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="nombre" id="nombre" placeholder="Introduce tu Nombre" required autocomplete="off" title="Introduce tu Nombre">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Correo:</span>
					</div>
					<input type="email" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="correo" id="correo" placeholder="Introduce tu Correo" required autocomplete="off" title="Introduce tu Correo">
				</div>
				<div class="input-group mb-2">
					<span class="input-group-text rounded-0 w-100">Mensaje:</span>
					<textarea class="form-control p-0 m-0 px-2 rounded-0" name="mensaje" id="mensaje" placeholder="Escribe tu mensaje aquí" required autocomplete="off" title="Introduzca su mensaje" rows="4"></textarea>
				</div>
				<div class="m-auto pt-2">
					<a href="index.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Al inicio</a>&nbsp;&nbsp;<input type="submit" value="Enviar Comentario &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
		</div>
	</section>
	<?php require("PHP_REQUIRES/footer_principal.php") ?>
</body>
</html>