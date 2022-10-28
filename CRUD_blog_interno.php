<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST['FORM'])){
		if($_POST['FORM']=='INSERTAR'){
			$cedula=mysqli_real_escape_string($conexion,$_POST['cedula']);
			$comentador=M_usuarios_R($conexion, 'CEDULA_RIF', $cedula, '', '', '', '');
			$comentario=mysqli_real_escape_string($conexion,$_POST['comentario']);
			$fh_comentario=mysqli_real_escape_string($conexion,$_POST['fecha']);
			$respuesta=mysqli_real_escape_string($conexion,$_POST['respuesta']);
			$fh_respuesta=mysqli_real_escape_string($conexion,$_POST['fecha_resp']);
			$clicks=mysqli_real_escape_string($conexion,$_POST['clicks']);
			$pregunta_frecuente=mysqli_real_escape_string($conexion, $_POST['pregunta_frecuente']);
			$verf_insert=M_blog_interno_C($conexion, $comentador['NOMBRE'][0], $comentador['APELLIDO'][0], $comentador['CEDULA_RIF'][0], $comentador['CORREO'][0], $comentador['FECHA_NACIMIENTO'][0], $comentario, $fh_comentario, $respuesta, $fh_respuesta, $clicks, $pregunta_frecuente);
		}else if($_POST['FORM']=='MODIFICAR'){
			$id_comentario_int=mysqli_real_escape_string($conexion, $_POST['id_comentario']);
			$cedula=mysqli_real_escape_string($conexion,$_POST['cedula']);
			$comentador=M_usuarios_R($conexion, 'CEDULA_RIF', $cedula, '', '', '', '');
			$comentario=mysqli_real_escape_string($conexion,$_POST['comentario']);
			$fh_comentario=mysqli_real_escape_string($conexion,$_POST['fecha']);
			$respuesta=mysqli_real_escape_string($conexion,$_POST['respuesta']);
			$fh_respuesta=mysqli_real_escape_string($conexion,$_POST['fecha_resp']);
			$clicks=mysqli_real_escape_string($conexion,$_POST['clicks']);
			$pregunta_frecuente=mysqli_real_escape_string($conexion,$_POST['pregunta_frecuente']);
			M_blog_interno_U_id($conexion, $id_comentario_int, $comentador['NOMBRE'][0], $comentador['APELLIDO'][0], $comentador['CEDULA_RIF'][0], $comentador['CORREO'][0], $comentador['FECHA_NACIMIENTO'][0], $comentario, $fh_comentario, $respuesta, $fh_respuesta, $clicks, $pregunta_frecuente);
		}else if($_POST['FORM']=='BORRAR'){
			$id_comentario_int=mysqli_real_escape_string($conexion, $_POST['id_comentario']);
			M_blog_interno_D_id($conexion, $id_comentario_int);
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
			//SI SE QUIERE INSERTAR UN NUEVO RENGLON ENTONCES:
		if($_GET["accion"]=='insertar'){
	?>
			<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
				<div class="row mt-4 align-items-center rounded-top px-2">
					<div class="col-md-9 mb-1 mt-3">
						<h3 class="text-center text-md-left text-warning">Insertar Comentario:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1 mt-3">
						<a href="CRUD_blog_interno.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_blog_interno.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="FORM" id="FORM" value="INSERTAR">
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Cedula/RIF</span>
						</div>
						<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cedula" id="cedula" required autocomplete="off" title="Indique la cedula del usuario">
							<option></option>
							<?php
								$usuarios=M_usuarios_R($conexion, '', '', '', '', '', '');
								$e=0;
								while($usuarios['CEDULA_RIF'][$e]){
									echo "<option VALUE='" . $usuarios['CEDULA_RIF'][$e] . "'>" . $usuarios['CEDULA_RIF'][$e] . " - " .  $usuarios['CORREO'][$e] . "</option>";
									$e=$e+1;
								}
							?>
						</select>
					</div>
					<div class="input-group mb-2 text-left">
						<span class="input-group-text rounded-0 w-100">Comentario:</span>
						<textarea class="form-control p-0 m-0 px-2 rounded-0" name="comentario" id="comentario" placeholder="Comentario" autocomplete="off" title="Introduzca su comentario" rows="2"></textarea>
					</div>
					<script type="text/javascript">
						$(document).ready(function() {
							$('#comentario').summernote({
								placeholder: 'Introduzca su comentario',
								tabsize: 1,
								height: 100								
							});
						});
					</script>
					<div class="input-group" id="caja_para_fecha_nacimiento">
						<div id='click01' class='input-group date pickers mb-2'>
							<div class='col-md-3 p-0 m-0'>
								<span class='input-group-text rounded-0 w-100' title="Fecha de comentario">Fecha Coment.:</span>
							</div>
							<input id='datepicker01' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fecha' placeholder='Fecha (Y-m-d)' autocomplete='off' title='Introduzca su Fecha de Comentario (Y-m-d)'>
						</div>
					</div>
					<script type="text/javascript">
						$('#datepicker01').click(function(){
							Calendar.setup({
								inputField     :    'datepicker01', 
								ifFormat       :    '%Y-%m-%d',  
								button         :    'click01', 
								align          :    'Tl',  
								singleClick    :    true
							});
						});
					</script>
					<div class="input-group mb-2 text-left">
						<span class="input-group-text rounded-0 w-100">Respuesta:</span>
						<textarea class="form-control p-0 m-0 px-2 rounded-0" name="respuesta" id="respuesta" placeholder="Respuesta" autocomplete="off" title="Introduzca su respuesta" rows="2" required></textarea>
					</div>
					<script type="text/javascript">
						$(document).ready(function() {
							$('#respuesta').summernote({
								placeholder: 'Introduzca su respuesta',
								tabsize: 1,
								height: 100								
							});
						});
					</script>
					<div class="input-group" id="caja_para_fecha_nacimiento">
						<div id='click02' class='input-group date pickers mb-2'>
							<div class='col-md-3 p-0 m-0'>
								<span class='input-group-text rounded-0 w-100' title="Fecha de comentario">Fecha Resp.:</span>
							</div>
							<input id='datepicker02' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fecha_resp' placeholder='Fecha (Y-m-d)' autocomplete='off' title='Introduzca su Fecha de Respuesta (Y-m-d)' required value="<?php echo date("Y-m-d"); ?>">
						</div>
					</div>
					<script type="text/javascript">
						$('#datepicker02').click(function(){
							Calendar.setup({
								inputField     :    'datepicker02', 
								ifFormat       :    '%Y-%m-%d',  
								button         :    'click02', 
								align          :    'Tl',  
								singleClick    :    true
							});
						});
					</script>
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Clicks:</span>
						</div>
						<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="clicks" id="clicks" placeholder="Cantidad de Clicks" required autocomplete="off" title="Introduzca la cantidad de Clicks que se han hecho al comentario" min="0" value="0">
					</div>
					<div class="input-group mb-2">
						<div class="col-md-5 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">¿Pregunta Frecuente?</span>
						</div>
						<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="pregunta_frecuente" id="pregunta_frecuente" required autocomplete="off" title="Indique si la pregunta se clasifica como frecuente o no">
							<option>NO</option>
							<option>SI</option>
						</select>
					</div>
					<div class="m-auto">
						<a href="CRUD_blog_interno.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Insertar Nuevo Renglón &raquo;" class="btn btn-warning mb-2">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE MODIFICAR UN RENGLON ENTONCES:
			}else if($_GET["accion"]=='actualizar'){
				$datos_actualizar=M_blog_interno_R($conexion, 'ID_COMENTARIO_INT', $_GET['NA_Id'], '', '', '', '');
		?>
			<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
				<div class="row mt-4 align-items-center rounded-top px-2">
					<div class="col-md-9 mb-1 mt-3">
						<h3 class="text-center text-md-left text-warning" title="MOdificar Comentario Interno">Modificar Comentario:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1 mt-3">
						<a href="CRUD_blog_interno.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_blog_interno.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="FORM" id="FORM" value="MODIFICAR">
					<input type="hidden" name="id_comentario" id="id_comentario" value="<?php echo $datos_actualizar['ID_COMENTARIO_INT'][0]; ?>">
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Cedula/RIF</span>
						</div>
						<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cedula" id="cedula" required autocomplete="off" title="Indique la cedula del usuario">
							<option value="<?php echo $datos_actualizar['CEDULA_RIF'][0]; ?>"><?php echo $datos_actualizar['CEDULA_RIF'][0]; ?> - <?php echo $datos_actualizar['CORREO'][0]; ?></option>
							<?php
								$usuarios=M_usuarios_R($conexion, '', '', '', '', '', '');
								$e=0;
								while($usuarios['CEDULA_RIF'][$e]){
									echo "<option VALUE='" . $usuarios['CEDULA_RIF'][$e] . "'>" . $usuarios['CEDULA_RIF'][$e] . " - " .  $usuarios['CORREO'][$e] . "</option>";
									$e=$e+1;
								}
							?>
						</select>
					</div>
					<div class="input-group mb-2 text-left">
						<span class="input-group-text rounded-0 w-100">Comentario:</span>
						<textarea class="form-control p-0 m-0 px-2 rounded-0" name="comentario" id="comentario" placeholder="Introduzca su comentario" required autocomplete="off" title="Introduzca su comentario" rows="2"><?php echo $datos_actualizar['COMENTARIO'][0]; ?></textarea>
					</div>
					<script type="text/javascript">
						$(document).ready(function() {
							$('#comentario').summernote({
								placeholder: 'Introduzca su comentario',
								tabsize: 1,
								height: 100								
							});
						});
					</script>
					<div class="input-group" id="caja_para_fecha_nacimiento">
						<div id='click01' class='input-group date pickers mb-2'>
							<div class='col-md-3 p-0 m-0'>
								<span class='input-group-text rounded-0 w-100' title="Fecha de comentario">Fecha Coment.:</span>
							</div>
							<input id='datepicker01' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fecha' placeholder='Fecha de Comentario (Y-m-d)' required autocomplete='off' title='Introduzca su Fecha de Comentario (Y-m-d)' value="<?php echo $datos_actualizar['FH_COMENTARIO'][0]; ?>">
						</div>
					</div>
					<script type="text/javascript">
						$('#datepicker01').click(function(){
							Calendar.setup({
								inputField     :    'datepicker01', 
								ifFormat       :    '%Y-%m-%d',  
								button         :    'click01', 
								align          :    'Tl',  
								singleClick    :    true
							});
						});
					</script>
					<div class="input-group mb-2 text-left">
						<span class="input-group-text rounded-0 w-100">Respuesta:</span>
						<textarea class="form-control p-0 m-0 px-2 rounded-0" name="respuesta" id="respuesta" placeholder="Introduzca su respuesta" autocomplete="off" title="Introduzca su respuesta" rows="2" required><?php echo $datos_actualizar['RESPUESTA'][0]; ?></textarea>
					</div>
					<script type="text/javascript">
						$(document).ready(function() {
							$('#respuesta').summernote({
								placeholder: 'Introduzca su respuesta',
								tabsize: 1,
								height: 100								
							});
						});
					</script>
					<div class="input-group" id="caja_para_fecha_nacimiento">
						<div id='click02' class='input-group date pickers mb-2'>
							<div class='col-md-3 p-0 m-0'>
								<span class='input-group-text rounded-0 w-100' title="Fecha de comentario">Fecha Resp.:</span>
							</div>
							<input id='datepicker02' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fecha_resp' placeholder='Fecha de Respuesta (Y-m-d)' autocomplete='off' title='Introduzca su Fecha de Respuesta (Y-m-d)' required value="<?php echo $datos_actualizar['FH_RESPUESTA'][0]; ?>">
						</div>
					</div>
					<script type="text/javascript">
						$('#datepicker02').click(function(){
							Calendar.setup({
								inputField     :    'datepicker02', 
								ifFormat       :    '%Y-%m-%d',  
								button         :    'click02', 
								align          :    'Tl',  
								singleClick    :    true
							});
						});
					</script>
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Clicks:</span>
						</div>
						<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="clicks" id="clicks" placeholder="Introduzca la cantidad de Clicks que se han hecho al comentario" required autocomplete="off" title="Introduzca la cantidad de Clicks que se han hecho al comentario" min="0" value="<?php echo $datos_actualizar['CLICKS'][0]; ?>">
					</div>
					<div class="input-group mb-2">
						<div class="col-md-5 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">¿Pregunta Frecuente?</span>
						</div>
						<select class="form-control col-md-7 p-0 m-0 px-2 rounded-0" name="pregunta_frecuente" id="pregunta_frecuente" required autocomplete="off" title="Indique si la pregunta se clasifica como frecuente o no">
							<option><?php echo $datos_actualizar['PREGUNTA_FRECUENTE'][0]; ?></option>
							<option>SI</option>
							<option>NO</option>
						</select>
					</div>
					<div class="m-auto">
						<a href="CRUD_blog_interno.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-warning mb-2">
					</div>
				</form>
			</div>
		<?php
		//SI SE QUIERE BORRAR UN RENGLON ENTONCES:
	}else if($_GET["accion"]=='borrar'){
		?>
		<br><br><br>
		<div class="col-md-12 col-lg-9 mx-auto">
			<form action="CRUD_blog_interno.php" method="post" class="text-center bg-dark p-2 rounded">
				<h3 class="text-center text-light pb-3" title="Borrar un Renglón">¿Seguro que desea Borrar el renglón de ID <?php echo $_GET['NA_Id']; ?>?</h3>
				<input type="hidden" name="FORM" id="FORM" value="BORRAR">
				<input type="hidden" name="id_comentario" id="id_comentario" value="<?php echo $_GET["NA_Id"]; ?>">
				<div class="m-auto">
					<a href="CRUD_blog_interno.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Borrar Renglón &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
			<br><br><br><br><br><br><br><br>
		</div>
		<?php
			//SI NO SE HIZO NINGUNA ACCIÓN:
		}else{
		?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_blog_interno.php">
	<?php
	//CIERRE DE LA ETIQUETA PARA EMBUTIR HTML EN PHP
	}
	}else{
	?>
	<!-- DataTables Example -->
	<?php
	if(isset($verf_insert)){
		if($verf_insert==false){
			echo "<h3 class='text-center text-dark bg-danger my-2 py-2'>El Renglón que está intentando agregar <b>YA EXISTE</b></h3>";
		}
	}
	?>
	<div class="card mb-3 bg-dark rounded-0 col-12 col-lg-9 mx-auto px-0">
		<div class="card-header text-center text-warning">
			<h3 class='text-center'><span class="fa fa-database"></span> Blog Interno:</h3>
			<h6 class='text-center small text-light'>Para ver productos sin respuesta Buscar por xxxxx:</h6>
		</div>
		<div class="card-body px-1 bg-white">
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover TablaDinamica">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b title="Información del Comentario">Comentario</b></th>
							<th class="align-middle h5 p-0"><a title="Insertar" href="CRUD_blog_interno.php?accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Insertar</a></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//obteniendo los datos de la tabla:
						$datos=M_blog_interno_R($conexion, '', '', '', '', '', '');
						$i=0;
						while(isset($datos['ID_COMENTARIO_INT'][$i])){
							if($datos['ID_COMENTARIO_INT'][$i]<>""){
								echo "<tr>";
								echo "<td class='text-left'><b title='¿Pregunta Frecuente?'>Frecuente:</b> " . $datos['PREGUNTA_FRECUENTE'][$i] . "<br><b>Usuario:</b> " . $datos['NOMBRE'][$i] . " " . $datos['APELLIDO'][$i] . "<br><b class='text-danger small'>" . $datos['CORREO'][$i] . "</b><br><b>Comentario:</b> " . $datos['COMENTARIO'][$i] . "<br><b>Respuesta: </b> ";
								if($datos['RESPUESTA'][$i]<>""){
									echo $datos['RESPUESTA'][$i];
								}else{
									echo "<b class='text-danger'>Sin Respuesta</b>";
								}
								echo "</td>";
								echo "<td class='text-center h5'><a title='Modificar' href='CRUD_blog_interno.php?accion=actualizar&NA_Id=" . $datos['ID_COMENTARIO_INT'][$i] . "' class='btn btn-transparent text-success fa fa-edit d-inline'></a>";
								echo "<br>";
								echo "<a title='Eliminar' href='CRUD_blog_interno.php?accion=borrar&NA_Id=" . $datos['ID_COMENTARIO_INT'][$i] . "' class='btn btn-transparent text-danger fa fa-trash-o d-inline'></a>";
								if($datos['RESPUESTA'][$i]==""){
									echo "<br><e class='text-light' style='font-size:1px;'>xxxxx</e>";
								}
								echo "</td>";
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
	<br><br><br><br><br><br><br><br><br><br><br><br><br>
	<?php
	//CIERRE DE LA ETIQUETA PARA EMBUTIR HTML EN PHP		
}
	?>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>