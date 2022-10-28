<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Directorio</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid px-0 mx-0 mx-md-2 px-md-4 mt-2 mb-5 bg-secondary">
		<br>
		<div class="card mb-3 bg-dark rounded-0 col-12 col-lg-7 mx-auto px-0">
			<div class="card-header text-center text-warning">
				<h3 class='text-center'>Directorio:</h3>
			</div>
			<div class="card-body px-1 bg-white">
				<div class="table-responsive">
					<table class="table table-bordered table-hover TablaDinamica">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b title="Foto del Usuario">Foto</b></th>
								<th class="align-middle"><b title="Nombre, Apellido, Correo Electrónico, Estatus, Ranking, Estado donde vive y Teléfono del usuario">Usuario</b></th>
							</tr>
						</thead>
						<tbody>
							<?php
							//obteniendo los datos de la tabla:
							$datos=M_usuarios_R($conexion, 'ACCESO', 'COMPRADOR-VENDEDOR', '', '', '', '');
							$i=0;
							while(isset($datos['ID_USUARIO'][$i])){
								if($datos['ID_USUARIO'][$i]<>""){
									echo "<tr>";
									echo "<td class='text-left' style='width:15%;'><img src='IMAGENES_USUARIOS/" . $datos['FOTO_LOGO'][$i] . "?a=" . rand() . "' class='imgFit'></td>";
									echo "<td class='text-left'>" . $datos['NOMBRE'][$i] . " " . $datos['APELLIDO'][$i] . "<br><b class='text-danger small'>" . $datos['CORREO'][$i] . "</b><br>" . $datos['ESTATUS'][$i] . " - " . $datos['RANKING'][$i] . "<br>" . $datos['ESTADO'][$i] . "<br>" . $datos['TELEFONO'][$i] . "</td>";
								}
								$i=$i+1;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>