<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	//SI SE DECIDIÓ A MARCAR UN MENSAJE COMO LEIDO
	if(isset($_GET['id_leido'])){
		$id_leido=mysqli_real_escape_string($conexion,$_GET['id_leido']);
		$datos_id_leido=M_blog_interno_R($conexion, 'ID_COMENTARIO_INT', $id_leido, '', '', '', '');
		M_blog_interno_U_id($conexion, $datos_id_leido['ID_COMENTARIO_INT'][0], $datos_id_leido['NOMBRE'][0], $datos_id_leido['APELLIDO'][0], $datos_id_leido['CEDULA_RIF'][0], $datos_id_leido['CORREO'][0], $datos_id_leido['FECHA_NACIMIENTO'][0], 'LEIDO', date("Y-m-d h:m:s"), $datos_id_leido['RESPUESTA'][0], $datos_id_leido['FH_RESPUESTA'][0], $datos_id_leido['CLICKS'][0], $datos_id_leido['PREGUNTA_FRECUENTE'][0]);
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Respuestas</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="my-3">
		<?php
			$datos_pregunta_frecuentes=M_blog_interno_R($conexion, 'CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], '', '', '', '');
			$msg_blog_int_2=M_blog_interno_R($conexion, 'CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'COMENTARIO', '', '', '');
			if($msg_blog_int_2['ID_COMENTARIO_INT'][0]<>0){
		?>
				<h3 class="text-center py-3 bg-dark text-warning mb-0"><b>Mensajes Recibidos de la Casa Virtual</b></h3>
				<div class="bg-light p-3">
					<table class="TablaDinamica w-100 bg-light table-hover">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b class="h6"></th>
							</tr>
						</thead>
						<tbody>
					<?php
						$i=0;
						while(isset($datos_pregunta_frecuentes['ID_COMENTARIO_INT'][$i])){
							if($datos_pregunta_frecuentes['ID_COMENTARIO_INT'][$i]<>""){
								if($datos_pregunta_frecuentes['COMENTARIO'][$i]=="" and $datos_pregunta_frecuentes['RESPUESTA'][$i]<>""){
									$fecha_ii=explode(" ",$datos_pregunta_frecuentes['FH_RESPUESTA'][$i]);
									echo "<tr><td><div class='container-fluid m-1'>";
									echo "<h5 class='text-left'><b class='text-success'>Comentario (" . $fecha_ii[0] . "):</b> <a href='zona_usuario_respuestas_por_usuario.php?id_leido=" . $datos_pregunta_frecuentes['ID_COMENTARIO_INT'][$i] . "'>Marcar como leido</a></h5><div>" . $datos_pregunta_frecuentes['RESPUESTA'][$i] . "</div>";
									echo "</div><hr></td></tr>";
								}
							}
							$i=$i+1;
						}
					?>
					</table>
				</div>
		<?php
			}
		?>
		<h3 class="text-center py-3 bg-dark text-warning mb-0 mt-3"><b>Mis Consultas a la Casa Virtual</b></h3>
		<div class="bg-light p-3">
			<table class="TablaDinamica w-100 bg-light table-hover">
				<thead>
					<tr class="text-center">
						<th class="align-middle"><b class="h6"></th>
					</tr>
				</thead>
				<tbody>
			<?php
				$i=0;
				while(isset($datos_pregunta_frecuentes['ID_COMENTARIO_INT'][$i])){
					if($datos_pregunta_frecuentes['ID_COMENTARIO_INT'][$i]<>""){
						if($datos_pregunta_frecuentes['COMENTARIO'][$i]<>"LEIDO" and $datos_pregunta_frecuentes['COMENTARIO'][$i]<>"" and $datos_pregunta_frecuentes['RESPUESTA'][$i]<>""){
							$fecha_i=explode(" ",$datos_pregunta_frecuentes['FH_COMENTARIO'][$i]);
							$fecha_ii=explode(" ",$datos_pregunta_frecuentes['FH_RESPUESTA'][$i]);
							echo "<tr><td><div class='container-fluid m-1'>";
							echo "<h5 class='text-left'><b class='text-primary'>Consulta (" . $fecha_i[0] . "):</b></h5><div>" . $datos_pregunta_frecuentes['COMENTARIO'][$i] . "</div>";
							echo "<h5 class='text-left'><b class='text-success'>Respuesta (" . $fecha_ii[0] . "):</b></h5><div>" . $datos_pregunta_frecuentes['RESPUESTA'][$i] . "</div>";
							echo "</div><hr></td></tr>";
						}
					}
					$i=$i+1;
				}
			?>
			</table>
		</div>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>