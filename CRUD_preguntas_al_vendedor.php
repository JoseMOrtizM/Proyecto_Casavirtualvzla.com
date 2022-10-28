<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST['FORM'])){
		if($_POST['FORM']=='MODIFICAR'){
			$id_preguntas_al_vendedor=mysqli_real_escape_string($conexion, $_POST['id']);
			$pregunta=mysqli_real_escape_string($conexion, $_POST['pregunta']);
			$respuesta=mysqli_real_escape_string($conexion, $_POST['respuesta']);
			$datos_a_modificar=M_pregunta_vendedor_R($conexion, 'mc_preguntas_al_vendedor', 'ID_PREGUNTAS_AL_VENDEDOR', $id_preguntas_al_vendedor, '', '', '', '', '', '');
			//actualizando revisado
			M_pregunta_vendedor_U_id_revisado($conexion, $id_preguntas_al_vendedor, $pregunta, $respuesta, 'SI');
		}else if($_POST['FORM']=='BORRAR'){
			$id_preguntas_al_vendedor=mysqli_real_escape_string($conexion, $_POST['id_preguntas_al_vendedor']);
			M_pregunta_vendedor_D_id($conexion, $id_preguntas_al_vendedor);
		}
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>BD-Blog Interno</title>
</head>
<body>
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid px-0 mx-0 mx-md-2 px-md-4 mt-2 mb-5 bg-secondary">
		<br>
	<?php
	//VERIFICANDO Si SE MARCO ALGUNA OPCION EN LA TABLA PRINCIPAL DEL CRUD
	if(isset($_GET["accion"])){
		//SI SE QUIERE ACTUALIZAR UN RENGLON ENTONCES:
		if($_GET["accion"]=='actualizar'){
			$datos_actualizar=M_pregunta_vendedor_R($conexion, 'mc_preguntas_al_vendedor', 'ID_PREGUNTAS_AL_VENDEDOR', $_GET['NA_Id'], '', '', '', '', '', '');
			?>
			<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
				<div class="row mt-4 align-items-center rounded-top px-2">
					<div class="col-md-9 mb-1 mt-3">
						<h3 class="text-center text-md-left text-warning">Modificar Pregunta:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1 mt-3">
						<a href="CRUD_preguntas_al_vendedor.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_preguntas_al_vendedor.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="FORM" id="FORM" value="MODIFICAR">
					<input type="hidden" name="id" id="id" value="<?php echo $datos_actualizar['ID_PREGUNTAS_AL_VENDEDOR'][0]; ?>">
					<div class="input-group mb-2 text-left">
						<?php
							// VERIFICANDO SI EXISTEN MALAS PALABRAS
							$verf_groceria=false;
							$grocerias=M_palabras_prohibidas();
							$palabras=explode(" ", str_replace(">", " ", str_replace("<", " ", $datos_actualizar['PREGUNTA'][0])));
							$contador_ii=0;
							while(isset($palabras[$contador_ii])){
								$contador_iii=0;
								while(isset($grocerias[$contador_iii])){
									if(strtolower($palabras[$contador_ii]) == strtolower($grocerias[$contador_iii])){
										$verf_groceria=true;
									}
									$contador_iii++;
								}
								$contador_ii++;
							}
						?>
						<span class="input-group-text rounded-0 w-100">
							Pregunta (<?php echo $datos_actualizar['PREGUNTA_NOMBRE'][0] . " " . $datos_actualizar['PREGUNTA_APELLIDO'][0]; ?>):
							<?php
								if($verf_groceria){
									echo " <b title='Existen Malas Palabras en esta Pregunta'><span class='btn btn-transparent text-danger fa fa-exclamation-triangle d-inline'></span></b>";
								}
							?>
						</span>
						<?php
							// VERIFICANDO SI EXISTEN MALAS PALABRAS
							$texto_a_imprimir="";
							$grocerias=M_palabras_prohibidas();
							$palabras=explode(" ", str_replace(">", html_entity_decode("> "), str_replace("<", html_entity_decode(" <"), $datos_actualizar['PREGUNTA'][0])));
							$contador_ii=0;
							while(isset($palabras[$contador_ii])){
								$contador_iii=0;
								$verf_groceria=false;
								while(isset($grocerias[$contador_iii])){
									if(strtolower($palabras[$contador_ii]) == strtolower($grocerias[$contador_iii])){
										$verf_groceria=true;
									}
									$contador_iii++;
								}
								if($verf_groceria){
									$texto_a_imprimir=$texto_a_imprimir . " <b class='bg-warning'>" . $palabras[$contador_ii] . "</b> ";
								}else{
									$texto_a_imprimir=$texto_a_imprimir . " " . $palabras[$contador_ii] . " ";
								}
								$contador_ii++;
							}
						?>
						<textarea class="form-control p-0 m-0 px-2 rounded-0" name="pregunta" id="pregunta" required autocomplete="off" title="Introduzca su Pregunta" rows="2"><?php echo $texto_a_imprimir; ?></textarea>
					</div>
					<script>
						$(document).ready(function() {
							$('#pregunta').summernote({
								placeholder: 'Introduzca la Pregunta',
								tabsize: 1,
								height: 100								
							});
						});
					</script>
					<div class="input-group mb-2 text-left">
						<?php
							// VERIFICANDO SI EXISTEN MALAS PALABRAS
							$verf_groceria=false;
							$grocerias=M_palabras_prohibidas();
							$palabras=explode(" ", str_replace(">", " ", str_replace("<", " ", $datos_actualizar['RESPUESTA'][0])));
							$contador_ii=0;
							while(isset($palabras[$contador_ii])){
								$contador_iii=0;
								while(isset($grocerias[$contador_iii])){
									if(strtolower($palabras[$contador_ii]) == strtolower($grocerias[$contador_iii])){
										$verf_groceria=true;
									}
									$contador_iii++;
								}
								$contador_ii++;
							}
						?>
						<span class="input-group-text rounded-0 w-100">
							Respuesta (<?php echo $datos_actualizar['RESPUESTA_NOMBRE'][0] . " " . $datos_actualizar['RESPUESTA_APELLIDO'][0]; ?>):
							<?php
								if($verf_groceria){
									echo " <b title='Existen Malas Palabras en esta Respuesta'><span class='btn btn-transparent text-danger fa fa-exclamation-triangle d-inline'></span></b>";
								}
							?>
						</span>
						<?php
							// VERIFICANDO SI EXISTEN MALAS PALABRAS
							$texto_a_imprimir="";
							$grocerias=M_palabras_prohibidas();
							$palabras=explode(" ", str_replace(">", html_entity_decode("> "), str_replace("<", html_entity_decode(" <"), $datos_actualizar['RESPUESTA'][0])));
							$contador_ii=0;
							while(isset($palabras[$contador_ii])){
								$contador_iii=0;
								$verf_groceria=false;
								while(isset($grocerias[$contador_iii])){
									if(strtolower($palabras[$contador_ii]) == strtolower($grocerias[$contador_iii])){
										$verf_groceria=true;
									}
									$contador_iii++;
								}
								if($verf_groceria){
									$texto_a_imprimir=$texto_a_imprimir . " <b class='bg-warning'>" . $palabras[$contador_ii] . "</b> ";
								}else{
									$texto_a_imprimir=$texto_a_imprimir . " " . $palabras[$contador_ii] . " ";
								}
								$contador_ii++;
							}
						?>
						<textarea class="form-control p-0 m-0 px-2 rounded-0" name="respuesta" id="respuesta" required autocomplete="off" title="Introduzca su Respuesta" rows="2"><?php echo $texto_a_imprimir; ?></textarea>
					</div>
					<script>
						$(document).ready(function() {
							$('#respuesta').summernote({
								placeholder: 'Introduzca la Respuesta',
								tabsize: 1,
								height: 100								
							});
						});
					</script>
					<div class="m-auto">
						<a href="CRUD_preguntas_al_vendedor.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-warning mb-2">
					</div>
				</form>
			</div>
			<br><br><br><br><br><br><br><br>
			<?php
		//SI SE QUIERE BORRAR UN RENGLON ENTONCES:
		}else if($_GET["accion"]=='borrar'){
			?>
			<br><br><br>
			<div class="col-md-12 col-lg-9 mx-auto">
				<form action="CRUD_preguntas_al_vendedor.php" method="post" class="text-center bg-dark p-2 rounded">
					<h3 class="text-center text-light pb-3" title="Borrar un Renglón">¿Seguro que desea Borrar el renglón de ID <?php echo $_GET['NA_Id']; ?>?</h3>
					<input type="hidden" name="FORM" id="FORM" value="BORRAR">
					<input type="hidden" name="id_preguntas_al_vendedor" id="id_preguntas_al_vendedor" value="<?php echo $_GET["NA_Id"]; ?>">
					<div class="m-auto">
						<a href="CRUD_preguntas_al_vendedor.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Borrar Renglón &raquo;" class="btn btn-warning mb-2">
					</div>
				</form>
				<br><br><br><br><br><br><br><br>
			</div>
			<?php
		//SI NO SE HIZO NINGUNA ACCIÓN:
		}else{
		?>
			<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_preguntas_al_vendedor.php">
		<?php
		//CIERRE DE LA ETIQUETA PARA EMBUTIR HTML EN PHP
		}
	}else{
	?>
	<?php
		//obteniendo los datos de los RENGLONES no revisados:
		$datos_sr=M_pregunta_vendedor_R($conexion, 'mc_preguntas_al_vendedor', 'REVISADO', 'NO', '', '', '', '', '', '');
		if(isset($datos_sr['ID_PREGUNTAS_AL_VENDEDOR'][0])){
			if($datos_sr['ID_PREGUNTAS_AL_VENDEDOR'][0]<>""){
	?>
	<!-- TABLA RENGLONES SIN REVISAR -->
	<div class="card mb-3 bg-dark rounded-0 col-12 col-lg-9 mx-auto px-0">
		<div class="card-header text-center text-danger">
			<h3 class='text-center'><span class="fa fa-database"></span> Sin Revisar:</h3>
			<h6 class='text-center small text-light'>Para ver productos con malas palabras Buscar por xxx:</h6>
		</div>
		<div class="card-body px-1 bg-white">
			<div class="table-responsive">
				<table class="table table-bordered table-hover TablaDinamica">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b title="Información de la pregunta">Pregunta</b></th>
							<th class="align-middle"><b><span class="fa fa-arrow-down"></span></b></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=0;
						while(isset($datos_sr['ID_PREGUNTAS_AL_VENDEDOR'][$i])){
							if($datos_sr['ID_PREGUNTAS_AL_VENDEDOR'][$i]<>""){
								//tratando la fecha
								$fecha_imp=explode(" ",$datos_sr['FH_PREGUNTA'][$i]);
								echo "<tr>";
								echo "<td class='text-left'>" . $datos_sr['ID_PREGUNTAS_AL_VENDEDOR'][$i] . " => " . $fecha_imp[0] . "<br><b>Cliente:</b> " . $datos_sr['PREGUNTA_NOMBRE'][$i] . " " . $datos_sr['PREGUNTA_APELLIDO'][$i] . "<br><b>Pregunta:</b> " . $datos_sr['PREGUNTA'][$i] . "<br><b>Vendedor:</b> " . $datos_sr['RESPUESTA_NOMBRE'][$i] . " " . $datos_sr['RESPUESTA_APELLIDO'][$i] . "<br>";
								if($datos_sr['RESPUESTA'][$i]==""){
									echo "<b>Respuesta:</b><br><b class='text-danger'>Sin Respuesta</b></td>";
								}else{
									echo "<b>Respuesta:<br></b> " . $datos_sr['RESPUESTA'][$i] . "</td>";
								}
								echo "<td class='text-center h5'>";
								// VERIFICANDO SI EXISTEN MALAS PALABRAS
								$verf_groceria=false;
								$grocerias=M_palabras_prohibidas();
								$palabras=explode(" ", str_replace(">", " ", str_replace("<", " ", $datos_sr['PREGUNTA'][$i] . " " . $datos_sr['RESPUESTA'][$i])));
								$contador_ii=0;
								while(isset($palabras[$contador_ii])){
									$contador_iii=0;
									while(isset($grocerias[$contador_iii])){
										if(strtolower($palabras[$contador_ii]) == strtolower($grocerias[$contador_iii])){
											$verf_groceria=true;
										}
										$contador_iii++;
									}
									$contador_ii++;
								}
								if($verf_groceria){
									echo "<b title='Existen Malas Palabras en este producto'><span class='text-danger fa fa-exclamation-triangle d-inline px-0'></span><b class='px-0' style='font-size:1px;'>xxx</b></b><br>";
								}
								echo "<a title='Modificar' href='CRUD_preguntas_al_vendedor.php?accion=actualizar&NA_Id=" . $datos_sr['ID_PREGUNTAS_AL_VENDEDOR'][$i] . "' class='btn btn-transparent text-success fa fa-edit d-inline'></a>";
								echo "<br>";
								echo "<a title='Eliminar' href='CRUD_preguntas_al_vendedor.php?accion=borrar&NA_Id=" . $datos_sr['ID_PREGUNTAS_AL_VENDEDOR'][$i] . "' class='btn btn-transparent text-danger fa fa-trash-o d-inline'></a></td>";
								echo "</tr>";
							}
							$i=$i+1;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br>
	<?php
			}
		}
	?>
	<!-- TABLA COMPLETA -->
	<div class="card mb-3 bg-dark rounded-0 col-12 col-lg-9 mx-auto px-0">
		<div class="card-header text-center text-warning">
			<h3 class='text-center'><span class="fa fa-database"></span> Preguntas al Vendedor:</h3>
			<h6 class='text-center small text-light'>Para ver los comentarios con malas palabras Buscar por xxx:</h6>
		</div>
		<div class="card-body px-1 bg-white">
			<div class="table-responsive">
				<table class="table table-bordered table-hover TablaDinamica">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b title="Información de la pregunta">Pregunta</b></th>
							<th class="align-middle"><b><span class="fa fa-arrow-down"></span></b></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//obteniendo los datos de la tabla:
						$datos=M_pregunta_vendedor_R($conexion, '', '', '', '', '', '', '', '', '');
						$i=0;
						while(isset($datos['ID_PREGUNTAS_AL_VENDEDOR'][$i])){
							if($datos['ID_PREGUNTAS_AL_VENDEDOR'][$i]<>""){
								//tratando la fecha
								$fecha_imp=explode(" ",$datos['FH_PREGUNTA'][$i]);
								echo "<tr>";
								echo "<td class='text-left'>" . $datos['ID_PREGUNTAS_AL_VENDEDOR'][$i] . " => " . $fecha_imp[0] . "<br><b>Cliente:</b> " . $datos['PREGUNTA_NOMBRE'][$i] . " " . $datos['PREGUNTA_APELLIDO'][$i] . "<br><b>Pregunta:</b> " . $datos['PREGUNTA'][$i] . "<br><b>Vendedor:</b> " . $datos['RESPUESTA_NOMBRE'][$i] . " " . $datos['RESPUESTA_APELLIDO'][$i] . "<br>";
								if($datos['RESPUESTA'][$i]==""){
									echo "<b>Respuesta:</b><br><b class='text-danger'>Sin Respuesta</b></td>";
								}else{
									echo "<b>Respuesta:<br></b> " . $datos['RESPUESTA'][$i] . "</td>";
								}
								echo "<td class='text-center h5'>";
								// VERIFICANDO SI EXISTEN MALAS PALABRAS
								$verf_groceria=false;
								$grocerias=M_palabras_prohibidas();
								$palabras=explode(" ", str_replace(">", " ", str_replace("<", " ", $datos['PREGUNTA'][$i] . " " . $datos['RESPUESTA'][$i])));
								$contador_ii=0;
								while(isset($palabras[$contador_ii])){
									$contador_iii=0;
									while(isset($grocerias[$contador_iii])){
										if(strtolower($palabras[$contador_ii]) == strtolower($grocerias[$contador_iii])){
											$verf_groceria=true;
										}
										$contador_iii++;
									}
									$contador_ii++;
								}
								if($verf_groceria){
									echo "<b title='Existen Malas Palabras en este producto'><span class='text-danger fa fa-exclamation-triangle d-inline px-0'></span><b class='px-0' style='font-size:1px;'>xxx</b></b><br>";
								}
								echo "<a title='Modificar' href='CRUD_preguntas_al_vendedor.php?accion=actualizar&NA_Id=" . $datos['ID_PREGUNTAS_AL_VENDEDOR'][$i] . "' class='btn btn-transparent text-success fa fa-edit d-inline'></a>";
								echo "<br>";
								echo "<a title='Eliminar' href='CRUD_preguntas_al_vendedor.php?accion=borrar&NA_Id=" . $datos['ID_PREGUNTAS_AL_VENDEDOR'][$i] . "' class='btn btn-transparent text-danger fa fa-trash-o d-inline'></a></td>";
								echo "</tr>";
							}
							$i=$i+1;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br><br><br>
	<?php
	//CIERRE DE LA ETIQUETA PARA EMBUTIR HTML EN PHP		
}
	?>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>