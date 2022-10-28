<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Preguntas al Vendedor</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<?php
		//VERIFICANDO ACCIONES DE RESPONDER, MODIFICAR Y BORRAR:
		if(isset($_POST['FORM'])){
			if($_POST['FORM']=='RESPONDER'){
				$datos_para_actuaizar=M_pregunta_vendedor_R($conexion, 'mc_preguntas_al_vendedor', 'ID_PREGUNTAS_AL_VENDEDOR', $_POST['id'], '', '', '', '', '', '');
				$respuesta=mysqli_real_escape_string($conexion,$_POST['respuesta']);
				M_pregunta_vendedor_U_id($conexion, $datos_para_actuaizar['ID_PREGUNTAS_AL_VENDEDOR'][0], $datos_para_actuaizar['ID_QUIEN_PREGUNTA'][0], $datos_para_actuaizar['ID_PRODUCTO'][0], $datos_para_actuaizar['FH_PREGUNTA'][0], $datos_para_actuaizar['PREGUNTA'][0], $respuesta);
				//marcando como no revisaro
				M_pregunta_vendedor_U_id_revisado($conexion, $datos_para_actuaizar['ID_PREGUNTAS_AL_VENDEDOR'][0], $datos_para_actuaizar['PREGUNTA'][0], $respuesta, 'NO');
			}else if($_POST['FORM']=='MODIFICAR'){
				$datos_para_actuaizar=M_pregunta_vendedor_R($conexion, 'mc_preguntas_al_vendedor', 'ID_PREGUNTAS_AL_VENDEDOR', mysqli_real_escape_string($conexion,$_POST['id']), '', '', '', '', '', '');
				$respuesta=mysqli_real_escape_string($conexion,$_POST['respuesta']);
				M_pregunta_vendedor_U_id($conexion, $datos_para_actuaizar['ID_PREGUNTAS_AL_VENDEDOR'][0], $datos_para_actuaizar['ID_QUIEN_PREGUNTA'][0], $datos_para_actuaizar['ID_PRODUCTO'][0], $datos_para_actuaizar['FH_PREGUNTA'][0], $datos_para_actuaizar['PREGUNTA'][0], $respuesta);
				//marcando como no revisaro
				M_pregunta_vendedor_U_id_revisado($conexion, $datos_para_actuaizar['ID_PREGUNTAS_AL_VENDEDOR'][0], $datos_para_actuaizar['PREGUNTA'][0], $respuesta, 'NO');
			}else if($_POST['FORM']=='BORRAR'){
				$id=mysqli_real_escape_string($conexion, $_POST['id']);
				M_pregunta_vendedor_D_id($conexion, $id);
			}
		}
	?>
	<section class="my-3">
		<?php
		if(isset($_GET["accion"])){
			if($_GET["accion"]=='responder'){
			$datos_responder=M_pregunta_vendedor_R($conexion, 'mc_preguntas_al_vendedor', 'ID_PREGUNTAS_AL_VENDEDOR', mysqli_real_escape_string($conexion, $_GET['NA_Id']), '', '', '', '', '', '');
		?>
		<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
			<div class="row mt-4 align-items-center rounded-top px-2">
				<div class="col-md-9 mb-1 mt-3">
					<h3 class="text-center text-md-left text-warning">Responder Pregunta:</h3>
				</div>
				<div class="col-md-3 text-center text-md-right mb-1 mt-3">
					<a href="zona_usuario_prod_preguntas_al_vendedor.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
				</div>
			</div>
			<form action="zona_usuario_prod_preguntas_al_vendedor.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="FORM" id="FORM" value="RESPONDER">
				<input type="hidden" name="id" id="id" value="<?php echo $datos_responder['ID_PREGUNTAS_AL_VENDEDOR'][0]; ?>">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Fecha:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="fec" id="fec" disabled value="<?php $fecha_ii=explode(" ", $datos_responder['FH_PREGUNTA'][0]); echo $fecha_ii[0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cliente:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="nom" id="nom" disabled value="<?php echo $datos_responder['PREGUNTA_NOMBRE'][0] . " ". $datos_responder['PREGUNTA_APELLIDO'][0]; ?>">
				</div>
				<div class="input-group mb-2 text-left">
					<span class="input-group-text rounded-0 w-100">Pregunta:</span>
					<div class="p-0 m-0 px-2 rounded-0 bg-light text-dark w-100"><?php echo $datos_responder['PREGUNTA'][0]; ?></div>
				</div>
				<div class="input-group mb-2 text-left">
					<span class="input-group-text rounded-0 w-100">Responder:</span>
					<textarea class="form-control p-0 m-0 px-2 rounded-0" name="respuesta" id="respuesta" placeholder="Escribe tu respuesta aquí" required autocomplete="off" title="Introduzca su respuesta" rows="2"></textarea>
				</div>
				<script>
					$(document).ready(function() {
						$('#respuesta').summernote({
							placeholder: 'Introduzca su respuesta',
							tabsize: 1,
							height: 100								
						});
					});
				</script>
				<div class="m-auto">
					<input type="submit" value="Responder" class="btn btn-warning mb-2">
				</div>
			</form>
		</div>
		<br><br><br><br><br><br>
		<?php
			}else if($_GET["accion"]=='modificar'){
			$datos_modificar=M_pregunta_vendedor_R($conexion, 'mc_preguntas_al_vendedor', 'ID_PREGUNTAS_AL_VENDEDOR', mysqli_real_escape_string($conexion, $_GET['NA_Id']), '', '', '', '', '', '');
		?>
		<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
			<div class="row mt-4 align-items-center rounded-top px-2">
				<div class="col-md-9 mb-1 mt-3">
					<h3 class="text-center text-md-left text-warning">Modificar Respuesta:</h3>
				</div>
				<div class="col-md-3 text-center text-md-right mb-1 mt-3">
					<a href="zona_usuario_prod_preguntas_al_vendedor.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
				</div>
			</div>
			<form action="zona_usuario_prod_preguntas_al_vendedor.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="FORM" id="FORM" value="MODIFICAR">
				<input type="hidden" name="id" id="id" value="<?php echo $datos_modificar['ID_PREGUNTAS_AL_VENDEDOR'][0]; ?>">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Fecha:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="fec" id="fec" disabled value="<?php $fecha_ii=explode(" ", $datos_modificar['FH_PREGUNTA'][0]); echo $fecha_ii[0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cliente:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="nom" id="nom" disabled value="<?php echo $datos_modificar['PREGUNTA_NOMBRE'][0] . " ". $datos_modificar['PREGUNTA_APELLIDO'][0]; ?>">
				</div>
				<div class="input-group mb-2 text-left">
					<span class="input-group-text rounded-0 w-100">Pregunta:</span>
					<div class="p-0 m-0 px-2 rounded-0 bg-light text-dark w-100"><?php echo $datos_modificar['PREGUNTA'][0]; ?></div>
				</div>
				<div class="input-group mb-2 text-left">
					<span class="input-group-text rounded-0 w-100">Responder:</span>
					<textarea class="form-control p-0 m-0 px-2 rounded-0" name="respuesta" id="respuesta" placeholder="Escribe tu respuesta aquí" required autocomplete="off" title="Introduzca su respuesta" rows="2"><?php echo $datos_modificar['RESPUESTA'][0]; ?></textarea>
				</div>
				<script>
					$(document).ready(function() {
						$('#respuesta').summernote({
							placeholder: 'Introduzca su respuesta',
							tabsize: 1,
							height: 100								
						});
					});
				</script>
				<div class="m-auto">
					<input type="submit" value="Responder" class="btn btn-warning mb-2">
				</div>
			</form>
		</div>
		<br><br><br><br><br><br>
		<?php
			}else if($_GET["accion"]=='borrar'){
		?>
		<br><br><br>
		<div class="col-md-12 col-lg-9 mx-auto">
			<form action="zona_usuario_prod_preguntas_al_vendedor.php" method="post" class="text-center bg-dark p-2 rounded">
				<h3 class="text-center text-light pb-3" title="Borrar un Renglón">¿Seguro que deseas Borrar esta pregunta?>?</h3>
				<input type="hidden" name="FORM" id="FORM" value="BORRAR">
				<input type="hidden" name="id" id="id" value="<?php echo $_GET["NA_Id"]; ?>">
				<div class="m-auto">
					<a href="zona_usuario_prod_preguntas_al_vendedor.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Borrar Pregunta" class="btn btn-warning mb-2">
				</div>
			</form>
			<br><br><br><br><br><br><br><br>
		</div>
		<?php
			}else{
				?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=zona_usuario_prod_preguntas_al_vendedor.php">
				<?php
			}
		}else{
			$preguntas_sin_contestar=M_pregunta_vendedor_R($conexion, 'mc_productos_y_servicios', 'CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'mc_preguntas_al_vendedor', 'RESPUESTA', '', '', '', ''); 
			$todas_las_preg_y_resp=M_pregunta_vendedor_R($conexion, 'mc_productos_y_servicios', 'CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], '', '', '', '', '', ''); 
		?>
		<div class="bg-white pb-3">
			<h2 class="text-center py-3 bg-dark text-warning">Mis Preguntas y Respuestas</h2>
			<div class="container-fluid">
				<h4 class='p-2 my-2 bg-warning text-center' title="Preguntas que aún no contestas"><strong class='text-dark'>Sin Contestar:</strong></h4>
				<?php
					if($preguntas_sin_contestar['PREGUNTA'][0]==''){
						echo "<div class='mx-5 text-left py-3'><h4><b class='text-success'>No tienes preguntas pendientes por contestar</b></h4></div>";
					}else{
				?>
					<table class="table table-bordered table-hover TablaDinamica w-100">
						<thead>
							<tr class="text-center">
								<th class="align-middle" title='Fecha, Nombre, Producto y Pregunta hecha por el Comprador'>Pregunta</th>
								<th class="align-middle" title='Responder o Borrar Consulta'>Acción</th>
							</tr>
						</thead>
						<tbody>
					<?php
						$i=0;
						while(isset($preguntas_sin_contestar['PREGUNTA'][$i])){
							if($preguntas_sin_contestar['PREGUNTA'][$i]<>""){
								echo "<tr>";
								$fecha_preg=explode(" ", $preguntas_sin_contestar['FH_PREGUNTA'][$i]);
								echo "<td class='text-left'><b class='text-danger'>Fecha:</b> " . $fecha_preg[0] . " <b class='text-danger'>Cliente:</b> " . $todas_las_preg_y_resp['PREGUNTA_NOMBRE'][$i] . " " . $todas_las_preg_y_resp['PREGUNTA_APELLIDO'][$i] . " <b class='text-danger'>Nombre del Producto:</b> " . $todas_las_preg_y_resp['NOMBRE_PRODUCTO'][$i] . "<br><b>Pregunta:</b> " . $todas_las_preg_y_resp['PREGUNTA'][$i] . "</td>";
								echo "<td class='text-center h5'><a title='Responder' href='zona_usuario_prod_preguntas_al_vendedor.php?accion=responder&NA_Id=" . $preguntas_sin_contestar['ID_PREGUNTAS_AL_VENDEDOR'][$i] . "' class='btn btn-transparent text-primary fa fa-mail-forward d-inline'></a>";
								echo "<br>";
								echo "<a title='Borrar Pregunta' href='zona_usuario_prod_preguntas_al_vendedor.php?accion=borrar&NA_Id=" . $preguntas_sin_contestar['ID_PREGUNTAS_AL_VENDEDOR'][$i] . "' class='btn btn-transparent text-danger fa fa-trash-o d-inline'></a></td>";
								echo "</tr>";
							}
							$i=$i+1;
						}
					?>
					</table>
					<br>				
				<?php
					}
				?>
			</div>
			<div class="container-fluid">
				<h4 class='p-2 my-2 bg-primary'><strong class='text-dark text-center'>Preguntas Contestadas:</strong></h4>
				<?php
					if($todas_las_preg_y_resp['PREGUNTA'][0]==''){
						echo "<div class='mx-5 py-3 text-left'><h4><b class='text-success'>No tienes preguntas</b></h4></div>";
					}else{
				?>
					<table class="table table-bordered table-hover TablaDinamica w-100">
						<thead>
							<tr class="text-center">
								<th class="align-middle" title='Fecha, Nombre, Producto y Pregunta hecha por el Comprador y Tu Respuesta'>Pregunta</th>
								<th class="align-middle" title='Borrar Pregunta'>Acción</th>
							</tr>
						</thead>
						<tbody>
					<?php
						$i=0;
						while(isset($todas_las_preg_y_resp['PREGUNTA'][$i])){
							if($todas_las_preg_y_resp['PREGUNTA'][$i]<>"" and $todas_las_preg_y_resp['RESPUESTA'][$i]<>""){
								echo "<tr>";
								$fecha_preg_resp=explode(" ", $todas_las_preg_y_resp['FH_PREGUNTA'][$i]);
								echo "<td class='text-left'><b class='text-danger'>Fecha:</b> " . $fecha_preg_resp[0] . " <b class='text-danger'>Cliente:</b> " . $todas_las_preg_y_resp['PREGUNTA_NOMBRE'][$i] . " " . $todas_las_preg_y_resp['PREGUNTA_APELLIDO'][$i] . "<br><b>Nombre del Producto:</b> " . $todas_las_preg_y_resp['NOMBRE_PRODUCTO'][$i] . "<br><b>Pregunta:</b> " . $todas_las_preg_y_resp['PREGUNTA'][$i] . "<br>";
								echo "<b>Respuesta: </b>" . $todas_las_preg_y_resp['RESPUESTA'][$i] . "</td>";
								echo "<td class='text-center h5'><a title='Responder' href='zona_usuario_prod_preguntas_al_vendedor.php?accion=modificar&NA_Id=" . $todas_las_preg_y_resp['ID_PREGUNTAS_AL_VENDEDOR'][$i] . "' class='btn btn-transparent text-success fa fa-edit d-inline'></a>";
								echo "<br>";
								echo "<a title='Borrar Pregunta' href='zona_usuario_prod_preguntas_al_vendedor.php?accion=borrar&NA_Id=" . $todas_las_preg_y_resp['ID_PREGUNTAS_AL_VENDEDOR'][$i] . "' class='btn btn-transparent text-danger fa fa-trash-o d-inline'></a></td>";
								echo "</tr>";
							}
							$i=$i+1;
						}
					?>
					</table>				
				<?php
					}
				?>
			</div>
		</div>
		<?php
		}
		?>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>