<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/datos_nav_busq_externos.php"); ?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/seo_meta.php") ?>
	<?php require ("PHP_REQUIRES/head_principal.php"); ?>
	<title>Autenticación</title>
</head>
<body class="bg-secondary">
	<?php require ("PHP_REQUIRES/nav_principal.php"); ?>
	<section class="my-5 pt-5">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-sm-8 col-md-6 col-lg-4 text-warning text-center bg-dark border-secondary mx-auto py-2">
					<form id="form_comp" name="form_comp" action="comprueba_usuario.php" method="post">
						<input class="form-control mb-2" type="email" id="correo" name="correo" required placeholder="Correo Electrónico" title="Introduzca su Email"/>
						<input class="form-control mb-2" type="password" id="contrasena" name="contrasena" required placeholder="Contraseña" title="Introduzca su Contraseña"/>
						<input class="btn btn-warning text-center p-0 pb-1 m-0 px-1 mb-1 mt-1" style="color: #000;" type="submit" value="Ingresar"/>
					</form>
					<a class="text-center m-2 text-light" href="form_recuperar_datos.php" title="Recuperar Correo y Contraseña">Mis datos</a>&nbsp;&nbsp;&nbsp;
					<a class="text-center m-2 text-light" href="form_registro_usuario.php" title="Recuperar Correo y Contraseña">Regístrate</a>
				</div>
			</div>
		</div>
		<br><br><br><br>
	</section>
</body>
</html>