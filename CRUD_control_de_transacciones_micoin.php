<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
if(isset($_POST['FORM'])){
	if($_POST['FORM']=='INSERTAR'){
		$cedula_comprador=mysqli_real_escape_string($conexion,$_POST['cedula_comprador']);
		$datos_comprador=M_usuarios_R($conexion, 'CEDULA_RIF', $cedula_comprador, '', '', '', '');
		$cedula_vendedor=mysqli_real_escape_string($conexion,$_POST['cedula_vendedor']);
		$datos_vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $cedula_vendedor, '', '', '', '');
		$tipo_de_compra=mysqli_real_escape_string($conexion, $_POST['tipo_de_compra']);
		$nombre_producto=mysqli_real_escape_string($conexion, $_POST['nombre_producto']);
		$cantidad_comprada=mysqli_real_escape_string($conexion, $_POST['cantidad_comprada']);
		$precio_unitario_micoin=mysqli_real_escape_string($conexion, $_POST['precio_unitario_micoin']);
		$monto_bruto_micoin=mysqli_real_escape_string($conexion, $_POST['monto_bruto_micoin']);
		$ranking=mysqli_real_escape_string($conexion, $_POST['ranking']);
		$porc_comision=mysqli_real_escape_string($conexion, $_POST['porc_comision']);
		$monto_comision=mysqli_real_escape_string($conexion, $_POST['monto_comision']);
		$monto_neto=mysqli_real_escape_string($conexion, $_POST['monto_neto']);
		$fh_pagado=mysqli_real_escape_string($conexion, $_POST['fh_pagado']);
		$fh_entregado=mysqli_real_escape_string($conexion, $_POST['fh_entregado']);
		$fh_transaccion_abandonada=mysqli_real_escape_string($conexion, $_POST['fh_transaccion_abandonada']);
		$fh_evaluacion=mysqli_real_escape_string($conexion, $_POST['fh_evaluacion']);
		$evaluacion_puntos=mysqli_real_escape_string($conexion, $_POST['evaluacion_puntos']);
		$evaluacion_comentario=mysqli_real_escape_string($conexion, $_POST['evaluacion_comentario']);
		$estatus=mysqli_real_escape_string($conexion, $_POST['estatus']);
		//INSERTANDO DATOS
		$verf_insert=M_control_de_transacciones_micoin_C($conexion, $datos_comprador['NOMBRE'][0], $datos_comprador['APELLIDO'][0], $datos_comprador['CEDULA_RIF'][0], $datos_comprador['CORREO'][0], $datos_comprador['FECHA_NACIMIENTO'][0], $datos_comprador['EMPRESA'][0], $datos_comprador['TELEFONO'][0], $datos_comprador['DIRECCION'][0], $datos_vendedor['NOMBRE'][0], $datos_vendedor['APELLIDO'][0], $datos_vendedor['CEDULA_RIF'][0], $datos_vendedor['CORREO'][0], $datos_vendedor['FECHA_NACIMIENTO'][0], $datos_vendedor['EMPRESA'][0], $datos_vendedor['TELEFONO'][0], $datos_vendedor['DIRECCION'][0], $tipo_de_compra, $nombre_producto, $cantidad_comprada, $precio_unitario_micoin, $monto_bruto_micoin, $ranking, $porc_comision, $monto_comision, $monto_neto, $fh_pagado, $fh_entregado, $fh_transaccion_abandonada, $fh_evaluacion, $evaluacion_puntos, $evaluacion_comentario, $estatus);
	}else if($_POST['FORM']=='MODIFICAR'){
		$id_trans=mysqli_real_escape_string($conexion,$_POST['id_trans']);
		$cedula_comprador=mysqli_real_escape_string($conexion,$_POST['cedula_comprador']);
		$datos_comprador=M_usuarios_R($conexion, 'CEDULA_RIF', $cedula_comprador, '', '', '', '');
		$cedula_vendedor=mysqli_real_escape_string($conexion,$_POST['cedula_vendedor']);
		$datos_vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $cedula_vendedor, '', '', '', '');
		$tipo_de_compra=mysqli_real_escape_string($conexion, $_POST['tipo_de_compra']);
		$nombre_producto=mysqli_real_escape_string($conexion, $_POST['nombre_producto']);
		$cantidad_comprada=mysqli_real_escape_string($conexion, $_POST['cantidad_comprada']);
		$precio_unitario_micoin=mysqli_real_escape_string($conexion, $_POST['precio_unitario_micoin']);
		$monto_bruto_micoin=mysqli_real_escape_string($conexion, $_POST['monto_bruto_micoin']);
		$ranking=mysqli_real_escape_string($conexion, $_POST['ranking']);
		$porc_comision=mysqli_real_escape_string($conexion, $_POST['porc_comision']);
		$monto_comision=mysqli_real_escape_string($conexion, $_POST['monto_comision']);
		$monto_neto=mysqli_real_escape_string($conexion, $_POST['monto_neto']);
		$fh_pagado=mysqli_real_escape_string($conexion, $_POST['fh_pagado']);
		$fh_entregado=mysqli_real_escape_string($conexion, $_POST['fh_entregado']);
		$fh_transaccion_abandonada=mysqli_real_escape_string($conexion, $_POST['fh_transaccion_abandonada']);
		$fh_evaluacion=mysqli_real_escape_string($conexion, $_POST['fh_evaluacion']);
		$evaluacion_puntos=mysqli_real_escape_string($conexion, $_POST['evaluacion_puntos']);
		$evaluacion_comentario=mysqli_real_escape_string($conexion, $_POST['evaluacion_comentario']);
		$estatus=mysqli_real_escape_string($conexion, $_POST['estatus']);
		//ACTUALIZANDO DATOS EN LA BD
		M_control_de_transacciones_micoin_U_id($conexion, $id_trans, $datos_comprador['NOMBRE'][0], $datos_comprador['APELLIDO'][0], $datos_comprador['CEDULA_RIF'][0], $datos_comprador['CORREO'][0], $datos_comprador['FECHA_NACIMIENTO'][0], $datos_comprador['EMPRESA'][0], $datos_comprador['TELEFONO'][0], $datos_comprador['DIRECCION'][0], $datos_vendedor['NOMBRE'][0], $datos_vendedor['APELLIDO'][0], $datos_vendedor['CEDULA_RIF'][0], $datos_vendedor['CORREO'][0], $datos_vendedor['FECHA_NACIMIENTO'][0], $datos_vendedor['EMPRESA'][0], $datos_vendedor['TELEFONO'][0], $datos_vendedor['DIRECCION'][0], $tipo_de_compra, $nombre_producto, $cantidad_comprada, $precio_unitario_micoin, $monto_bruto_micoin, $ranking, $porc_comision, $monto_comision, $monto_neto, $fh_pagado, $fh_entregado, $fh_transaccion_abandonada, $fh_evaluacion, $evaluacion_puntos, $evaluacion_comentario, $estatus);
	}else if($_POST['FORM']=='BORRAR'){
		$id_trans=mysqli_real_escape_string($conexion,$_POST['id_trans']);
		M_compra_venta_de_micoin_D_id($conexion, $id_trans);
	}
}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>CRUD Compra-Venta Productos</title>
</head>
<body class="bg-secondary">
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
					<h3 class="text-center text-md-left text-warning">Agregar nueva Transacción:</h3>
				</div>
				<div class="col-md-3 text-center text-md-right mb-1 mt-3">
					<a href="CRUD_control_de_transacciones_micoin.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
				</div>
			</div>
			<form action="CRUD_control_de_transacciones_micoin.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="FORM" id="FORM" value="INSERTAR">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Comprador:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cedula_comprador" id="cedula_comprador" required autocomplete="off" title="Indique la cedula del usuario comprador">
						<option></option>
						<?php
							$usuario=M_usuarios_R($conexion, 'ESTATUS', 'ACTIVO', '', '', '', '');
							$e=0;
							while($usuario['CEDULA_RIF'][$e]){
								echo "<option value='" . $usuario['CEDULA_RIF'][$e] . "'>" . $usuario['CEDULA_RIF'][$e] . " - " .  $usuario['CORREO'][$e] . "</option>";
								$e=$e+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Vendedor:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cedula_vendedor" id="cedula_vendedor" required autocomplete="off" title="Indique la cedula del usuario vendedor">
						<option></option>
						<?php
							$e=0;
							while($usuario['CEDULA_RIF'][$e]){
								echo "<option value='" . $usuario['CEDULA_RIF'][$e] . "'>" . $usuario['CEDULA_RIF'][$e] . " - " .  $usuario['CORREO'][$e] . "</option>";
								$e=$e+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Tipo de Compra:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_de_compra" id="tipo_de_compra" required autocomplete="off" title="Indique el Tipo de Compra">
						<option></option>
						<option>EXPRESS</option>
						<option>PREMIUN</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Producto:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="nombre_producto" id="nombre_producto" required autocomplete="off" title="Indique el producto a comprar">
						<option></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#cedula_vendedor").on('change', function(){
							var vendedor=$("#cedula_vendedor").val();
							$.ajax("PHP_MODELO/S_agrupa_productos_por_vendedor.php",{data:{vendedor:vendedor}, type:'post'}).done(function(respuesta){
								$("#nombre_producto").html(respuesta);
							});
						});
					});
				</script>
				<div id="caja_para_precio_unitario"></div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#cedula_vendedor").on('change', function(){
							if($("#cedula_vendedor").val()!='' && $("#nombre_producto").val()!=''){
								var cedula_vendedor=$("#cedula_vendedor").val();
								var nombre_producto=$("#nombre_producto").val();
								$.ajax("PHP_MODELO/S_devuelve_precio_unitario.php",{data:{cedula_vendedor:cedula_vendedor, nombre_producto:nombre_producto}, type:'post'}).done(function(respuesta){
									$("#caja_para_precio_unitario").hide(500);
									$("#caja_para_precio_unitario").html(respuesta);
									$("#caja_para_precio_unitario").fadeIn(500);
								});
							}else{
								$("#caja_para_precio_unitario").hide(500);
								$("#caja_para_precio_unitario").html("");
								$("#caja_para_precio_unitario").fadeIn(500);
							}
						});
						$("#nombre_producto").on('change', function(){
							if($("#cedula_vendedor").val()!='' && $("#nombre_producto").val()!=''){
								var cedula_vendedor=$("#cedula_vendedor").val();
								var nombre_producto=$("#nombre_producto").val();
								$.ajax("PHP_MODELO/S_devuelve_precio_unitario.php",{data:{cedula_vendedor:cedula_vendedor, nombre_producto:nombre_producto}, type:'post'}).done(function(respuesta){
									$("#caja_para_precio_unitario").hide(500);
									$("#caja_para_precio_unitario").html(respuesta);
									$("#caja_para_precio_unitario").fadeIn(500);
								});
							}else{
								$("#caja_para_precio_unitario").hide(500);
								$("#caja_para_precio_unitario").html("");
								$("#caja_para_precio_unitario").fadeIn(500);
							}
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cantidad:</span>
					</div>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cantidad_comprada" id="cantidad_comprada" placeholder="Cantidad de productos" required autocomplete="off" title="Introduzca la cantidad de unidades del produto correspondientes a la comprar" min="1">
				</div>
				<div id="caja_para_calculos_de_la_compra"></div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#cedula_vendedor").on('change', function(){
							if($("#cedula_vendedor").val()!='' && $("#nombre_producto").val()!='' && $("#cantidad_comprada").val()!=''){
								var cedula_vendedor=$("#cedula_vendedor").val();
								var nombre_producto=$("#nombre_producto").val();
								var cantidad_comprada=$("#cantidad_comprada").val();
								$.ajax("PHP_MODELO/S_devuelve_calculos_de_la_compra.php",{data:{cedula_vendedor:cedula_vendedor, nombre_producto:nombre_producto, cantidad_comprada:cantidad_comprada}, type:'post'}).done(function(respuesta){
									$("#caja_para_calculos_de_la_compra").hide(500);
									$("#caja_para_calculos_de_la_compra").html(respuesta);
									$("#caja_para_calculos_de_la_compra").fadeIn(500);
								});
							}else{
								$("#caja_para_calculos_de_la_compra").hide(500);
								$("#caja_para_calculos_de_la_compra").html("");
								$("#caja_para_calculos_de_la_compra").fadeIn(500);
							}
						});
						$("#nombre_producto").on('change', function(){
							if($("#cedula_vendedor").val()!='' && $("#nombre_producto").val()!='' && $("#cantidad_comprada").val()!=''){
								var cedula_vendedor=$("#cedula_vendedor").val();
								var nombre_producto=$("#nombre_producto").val();
								var cantidad_comprada=$("#cantidad_comprada").val();
								$.ajax("PHP_MODELO/S_devuelve_calculos_de_la_compra.php",{data:{cedula_vendedor:cedula_vendedor, nombre_producto:nombre_producto, cantidad_comprada:cantidad_comprada}, type:'post'}).done(function(respuesta){
									$("#caja_para_calculos_de_la_compra").hide(500);
									$("#caja_para_calculos_de_la_compra").html(respuesta);
									$("#caja_para_calculos_de_la_compra").fadeIn(500);
								});
							}else{
								$("#caja_para_calculos_de_la_compra").hide(500);
								$("#caja_para_calculos_de_la_compra").html("");
								$("#caja_para_calculos_de_la_compra").fadeIn(500);
							}
						});
						$("#cantidad_comprada").on('change', function(){
							if($("#cedula_vendedor").val()!='' && $("#nombre_producto").val()!='' && $("#cantidad_comprada").val()!=''){
								var cedula_vendedor=$("#cedula_vendedor").val();
								var nombre_producto=$("#nombre_producto").val();
								var cantidad_comprada=$("#cantidad_comprada").val();
								$.ajax("PHP_MODELO/S_devuelve_calculos_de_la_compra.php",{data:{cedula_vendedor:cedula_vendedor, nombre_producto:nombre_producto, cantidad_comprada:cantidad_comprada}, type:'post'}).done(function(respuesta){
									$("#caja_para_calculos_de_la_compra").hide(500);
									$("#caja_para_calculos_de_la_compra").html(respuesta);
									$("#caja_para_calculos_de_la_compra").fadeIn(500);
								});
							}else{
								$("#caja_para_calculos_de_la_compra").hide(500);
								$("#caja_para_calculos_de_la_compra").html("");
								$("#caja_para_calculos_de_la_compra").fadeIn(500);
							}
						});
					});
				</script>
				<div class="input-group">
					<div id='click02' class='input-group date pickers mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100' title="Fecha de Pagado">Fecha Pagado:</span>
						</div>
						<input id='datepicker02' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fh_pagado' placeholder='Fecha de Pagado (Y-m-d)' autocomplete='off' title='Introduzca su Fecha de Pagado (Y-m-d)' required>
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
				<div class="input-group">
					<div id='click03' class='input-group date pickers mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100' title="Fecha de Entregado">Fecha Entregado:</span>
						</div>
						<input id='datepicker03' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fh_entregado' placeholder='Fecha de Entregado (Y-m-d)' autocomplete='off' title='Introduzca su Fecha de Entregado (Y-m-d)'>
					</div>
				</div>
				<script type="text/javascript">
					$('#datepicker03').click(function(){
						Calendar.setup({
							inputField     :    'datepicker03', 
							ifFormat       :    '%Y-%m-%d',  
							button         :    'click03', 
							align          :    'Tl',  
							singleClick    :    true
						});
					});
				</script>
				<div class="input-group">
					<div id='click04' class='input-group date pickers mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100' title="Fecha de Transacción Abandonado (si aplica)">Fecha Abandonado:</span>
						</div>
						<input id='datepicker04' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fh_transaccion_abandonada' placeholder='Fecha de Abandonado (Y-m-d)' autocomplete='off' title='Introduzca su Fecha de Abandonado (Y-m-d)'>
					</div>
				</div>
				<script type="text/javascript">
					$('#datepicker04').click(function(){
						Calendar.setup({
							inputField     :    'datepicker04', 
							ifFormat       :    '%Y-%m-%d',  
							button         :    'click04', 
							align          :    'Tl',  
							singleClick    :    true
						});
					});
				</script>
				<h5 class="text-center text-warning">Datos de Evaluación (Opcional):</h5>
				<div class="input-group">
					<div id='click05' class='input-group date pickers mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100' title="Fecha de Transacción Abandonado (si aplica)">Fecha Evaluación:</span>
						</div>
						<input id='datepicker05' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fh_evaluacion' placeholder='Fecha de Evaluación (Y-m-d)' autocomplete='off' title='Introduzca su Fecha de Evaluación (Y-m-d)'>
					</div>
				</div>
				<script type="text/javascript">
					$('#datepicker05').click(function(){
						Calendar.setup({
							inputField     :    'datepicker05', 
							ifFormat       :    '%Y-%m-%d',  
							button         :    'click05', 
							align          :    'Tl',  
							singleClick    :    true
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Puntos:</span>
					</div>
					<div class="form-control col-md-9 p-0 m-0 px-2 rounded-0">
						<h3 class="text-warning">
							<span id="estrella_1" class="fa fa-star-o"></span>
							<span id="estrella_2" class="fa fa-star-o"></span>
							<span id="estrella_3" class="fa fa-star-o"></span>
							<span id="estrella_4" class="fa fa-star-o"></span>
							<span id="estrella_5" class="fa fa-star-o"></span>
						</h3>
					</div>
				</div>
				<div id="caja_para_puntos_evaluacion">
					<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='0'>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#estrella_1").on('click', function(){
							$("#estrella_1").removeClass();
							$("#estrella_2").removeClass();
							$("#estrella_3").removeClass();
							$("#estrella_4").removeClass();
							$("#estrella_5").removeClass();
							$("#estrella_1").addClass("fa fa-star");
							$("#estrella_2").addClass("fa fa-star-o");
							$("#estrella_3").addClass("fa fa-star-o");
							$("#estrella_4").addClass("fa fa-star-o");
							$("#estrella_5").addClass("fa fa-star-o");
							$("#caja_para_puntos_evaluacion").html("<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='1'>");
						});
						$("#estrella_2").on('click', function(){
							$("#estrella_1").removeClass();
							$("#estrella_2").removeClass();
							$("#estrella_3").removeClass();
							$("#estrella_4").removeClass();
							$("#estrella_5").removeClass();
							$("#estrella_1").addClass("fa fa-star");
							$("#estrella_2").addClass("fa fa-star");
							$("#estrella_3").addClass("fa fa-star-o");
							$("#estrella_4").addClass("fa fa-star-o");
							$("#estrella_5").addClass("fa fa-star-o");
							$("#caja_para_puntos_evaluacion").html("<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='2'>");
						});
						$("#estrella_3").on('click', function(){
							$("#estrella_1").removeClass();
							$("#estrella_2").removeClass();
							$("#estrella_3").removeClass();
							$("#estrella_4").removeClass();
							$("#estrella_5").removeClass();
							$("#estrella_1").addClass("fa fa-star");
							$("#estrella_2").addClass("fa fa-star");
							$("#estrella_3").addClass("fa fa-star");
							$("#estrella_4").addClass("fa fa-star-o");
							$("#estrella_5").addClass("fa fa-star-o");
							$("#caja_para_puntos_evaluacion").html("<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='3'>");
						});
						$("#estrella_4").on('click', function(){
							$("#estrella_1").removeClass();
							$("#estrella_2").removeClass();
							$("#estrella_3").removeClass();
							$("#estrella_4").removeClass();
							$("#estrella_5").removeClass();
							$("#estrella_1").addClass("fa fa-star");
							$("#estrella_2").addClass("fa fa-star");
							$("#estrella_3").addClass("fa fa-star");
							$("#estrella_4").addClass("fa fa-star");
							$("#estrella_5").addClass("fa fa-star-o");
							$("#caja_para_puntos_evaluacion").html("<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='4'>");
						});
						$("#estrella_5").on('click', function(){
							$("#estrella_1").removeClass();
							$("#estrella_2").removeClass();
							$("#estrella_3").removeClass();
							$("#estrella_4").removeClass();
							$("#estrella_5").removeClass();
							$("#estrella_1").addClass("fa fa-star");
							$("#estrella_2").addClass("fa fa-star");
							$("#estrella_3").addClass("fa fa-star");
							$("#estrella_4").addClass("fa fa-star");
							$("#estrella_5").addClass("fa fa-star");
							$("#caja_para_puntos_evaluacion").html("<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='5'>");
						});
					});
				</script>
				<div class="input-group mb-2">
					<span class="input-group-text rounded-0 w-100">Comentario:</span>
					<textarea class="form-control p-0 m-0 px-2 rounded-0" name="evaluacion_comentario" id="evaluacion_comentario" placeholder="Comentario de la Evaluación (Opcional)" autocomplete="off" title="Introduzca el Comentario de la Evaluación del comprador (Opcional)" rows="2"></textarea>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Estatus:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="estatus" id="estatus" required autocomplete="off" title="Indique el Estatus de la Transacción">
						<option></option>
						<option>PAGADO</option>
						<option>ENTREGADO</option>
						<option>ABANDONADO</option>
					</select>
				</div>
				<div class="m-auto">
					<a href="CRUD_control_de_transacciones_micoin.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Insertar Renglón &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
		</div>
		<?php
			// -------------    SI SE QUIERE MODIFICAR UN RENGLON ENTONCES --------------  :
			}else if($_GET["accion"]=='actualizar'){
				$datos_actualizar=M_control_de_transacciones_compras_en_micoin_R($conexion, 'ID_TRANSACCION', $_GET['NA_Id'], '', '', '', '');
		?>
		<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
			<div class="row mt-4 align-items-center rounded-top px-2">
				<div class="col-md-9 mb-1 mt-3">
					<h3 class="text-center text-md-left text-warning">Modificar Transacción:</h3>
				</div>
				<div class="col-md-3 text-center text-md-right mb-1 mt-3">
					<a href="CRUD_control_de_transacciones_micoin.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
				</div>
			</div>
			<div class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="FORM" id="FORM" value="MODIFICAR">
				<input type="hidden" name="id_trans" id="id_trans" value="<?php echo $datos_actualizar['ID_TRANSACCION'][0]; ?>">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Comprador:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cedula_comprador" id="cedula_comprador" required autocomplete="off" title="Indique la cedula del usuario comprador">
						<option value="<?php echo $datos_actualizar['COMPRADOR_CEDULA_RIF'][0]; ?>"><?php echo $datos_actualizar['COMPRADOR_CEDULA_RIF'][0]; ?> - <?php echo $datos_actualizar['COMPRADOR_CORREO'][0]; ?></option>
						<?php
							$usuario=M_usuarios_R($conexion, 'ESTATUS', 'ACTIVO', '', '', '', '');
							$e=0;
							while($usuario['CEDULA_RIF'][$e]){
								echo "<option value='" . $usuario['CEDULA_RIF'][$e] . "'>" . $usuario['CEDULA_RIF'][$e] . " - " .  $usuario['CORREO'][$e] . "</option>";
								$e=$e+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Vendedor:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cedula_vendedor" id="cedula_vendedor" required autocomplete="off" title="Indique la cedula del usuario vendedor">
						<option value="<?php echo $datos_actualizar['VENDEDOR_CEDULA_RIF'][0]; ?>"><?php echo $datos_actualizar['VENDEDOR_CEDULA_RIF'][0]; ?> - <?php echo $datos_actualizar['VENDEDOR_CORREO'][0]; ?></option>
						<?php
							$e=0;
							while($usuario['CEDULA_RIF'][$e]){
								echo "<option value='" . $usuario['CEDULA_RIF'][$e] . "'>" . $usuario['CEDULA_RIF'][$e] . " - " .  $usuario['CORREO'][$e] . "</option>";
								$e=$e+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Tipo de Compra:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_de_compra" id="tipo_de_compra" required autocomplete="off" title="Indique el Tipo de Compra">
						<option><?php echo $datos_actualizar['TIPO_DE_COMPRA'][0]; ?></option>
						<option>EXPRESS</option>
						<option>PREMIUN</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Producto:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="nombre_producto" id="nombre_producto" required autocomplete="off" title="Indique el producto a comprar">
						<option><?php echo $datos_actualizar['NOMBRE_PRODUCTO'][0]; ?></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#cedula_vendedor").on('change', function(){
							var vendedor=$("#cedula_vendedor").val();
							$.ajax("PHP_MODELO/S_agrupa_productos_por_vendedor.php",{data:{vendedor:vendedor}, type:'post'}).done(function(respuesta){
								$("#nombre_producto").html(respuesta);
							});
						});
					});
				</script>
				<div id="caja_para_precio_unitario">
					<div class='input-group mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100'>Precio/Unidad:</span>
						</div>
						<input type='hidden' name='precio_unitario_micoin' id='precio_unitario_micoin' value='<?php echo $datos_actualizar['PRECIO_UNITARIO_MICOIN'][0]; ?>'>
						<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='precio_unitario_micoin_print' id='precio_unitario_micoin_print'  title='precio unitario del producto' min='0' disabled value='<?php echo number_format($datos_actualizar['PRECIO_UNITARIO_MICOIN'][0], 2,',','.'); ?>'>
					</div>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#cedula_vendedor").on('change', function(){
							if($("#cedula_vendedor").val()!='' && $("#nombre_producto").val()!=''){
								var cedula_vendedor=$("#cedula_vendedor").val();
								var nombre_producto=$("#nombre_producto").val();
								$.ajax("PHP_MODELO/S_devuelve_precio_unitario.php",{data:{cedula_vendedor:cedula_vendedor, nombre_producto:nombre_producto}, type:'post'}).done(function(respuesta){
									$("#caja_para_precio_unitario").hide(500);
									$("#caja_para_precio_unitario").html(respuesta);
									$("#caja_para_precio_unitario").fadeIn(500);
								});
							}else{
								$("#caja_para_precio_unitario").hide(500);
								$("#caja_para_precio_unitario").html("");
								$("#caja_para_precio_unitario").fadeIn(500);
							}
						});
						$("#nombre_producto").on('change', function(){
							if($("#cedula_vendedor").val()!='' && $("#nombre_producto").val()!=''){
								var cedula_vendedor=$("#cedula_vendedor").val();
								var nombre_producto=$("#nombre_producto").val();
								$.ajax("PHP_MODELO/S_devuelve_precio_unitario.php",{data:{cedula_vendedor:cedula_vendedor, nombre_producto:nombre_producto}, type:'post'}).done(function(respuesta){
									$("#caja_para_precio_unitario").hide(500);
									$("#caja_para_precio_unitario").html(respuesta);
									$("#caja_para_precio_unitario").fadeIn(500);
								});
							}else{
								$("#caja_para_precio_unitario").hide(500);
								$("#caja_para_precio_unitario").html("");
								$("#caja_para_precio_unitario").fadeIn(500);
							}
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cantidad:</span>
					</div>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cantidad_comprada" id="cantidad_comprada" placeholder="Cantidad de productos" required autocomplete="off" title="Introduzca la cantidad de unidades del produto correspondientes a la comprar" min="0" value="<?php echo $datos_actualizar['CANTIDAD_COMPRADA'][0]; ?>">
				</div>
				<div id="caja_para_calculos_de_la_compra">
					<div class='input-group mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100'>Monto Bruto:</span>
						</div>
						<input type='hidden' name='monto_bruto_micoin' id='monto_bruto_micoin' value='<?php echo $datos_actualizar['MONTO_BRUTO_MICOIN'][0]; ?>'>
						<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='monto_bruto_micoin_print' id='monto_bruto_micoin_print' title='precio bruto de la compra' min='0' disabled value='<?php echo number_format($datos_actualizar['MONTO_BRUTO_MICOIN'][0], 2,',','.'); ?>'>
					</div>
					<div class='input-group mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100'>Ranking Vendedor:</span>
						</div>
						<input type='hidden' name='ranking' id='ranking' value='<?php echo $datos_actualizar['RANKING'][0]; ?>'>
						<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='ranking_print' id='ranking_print' title='ranking del vendedor' min='0' disabled value='<?php echo $datos_actualizar['RANKING'][0]; ?>'>
					</div>
					<div class='input-group mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100'>% Comisión:</span>
						</div>
						<input type='hidden' name='porc_comision' id='porc_comision' value='<?php echo $datos_actualizar['PORC_COMISION'][0]; ?>'>
						<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='porc_comision_print' id='porc_comision_print' title='Porcentaje de Comisión descontado al vendedor para el sitio web' min='0' disabled value='<?php echo number_format($datos_actualizar['PORC_COMISION'][0], 2,',','.'); ?>'>
					</div>
					<div class='input-group mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100'>Monto Comisión:</span>
						</div>
						<input type='hidden' name='monto_comision' id='monto_comision' value='<?php echo $datos_actualizar['MONTO_COMISION'][0]; ?>'>
						<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='monto_comision_print' id='monto_comision_print' title='Monto por Comisión descontado al vendedor para el sitio web' min='0' disabled value='<?php echo number_format($datos_actualizar['MONTO_COMISION'][0], 2,',','.'); ?>'>
					</div>
					<div class='input-group mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100'>Monto Neto:</span>
						</div>
						<input type='hidden' name='monto_neto' id='monto_neto' value='<?php echo $datos_actualizar['MONTO_NETO'][0]; ?>'>
						<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='monto_neto_print' id='monto_neto_print' title='Monto neto que recibe el vendedor' min='0' disabled value='<?php echo number_format($datos_actualizar['MONTO_NETO'][0], 2,',','.'); ?>'>
					</div>					
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#cedula_vendedor").on('change', function(){
							if($("#cedula_vendedor").val()!='' && $("#nombre_producto").val()!='' && $("#cantidad_comprada").val()!=''){
								var cedula_vendedor=$("#cedula_vendedor").val();
								var nombre_producto=$("#nombre_producto").val();
								var cantidad_comprada=$("#cantidad_comprada").val();
								$.ajax("PHP_MODELO/S_devuelve_calculos_de_la_compra.php",{data:{cedula_vendedor:cedula_vendedor, nombre_producto:nombre_producto, cantidad_comprada:cantidad_comprada}, type:'post'}).done(function(respuesta){
									$("#caja_para_calculos_de_la_compra").hide(500);
									$("#caja_para_calculos_de_la_compra").html(respuesta);
									$("#caja_para_calculos_de_la_compra").fadeIn(500);
								});
							}else{
								$("#caja_para_calculos_de_la_compra").hide(500);
								$("#caja_para_calculos_de_la_compra").html("");
								$("#caja_para_calculos_de_la_compra").fadeIn(500);
							}
						});
						$("#nombre_producto").on('change', function(){
							if($("#cedula_vendedor").val()!='' && $("#nombre_producto").val()!='' && $("#cantidad_comprada").val()!=''){
								var cedula_vendedor=$("#cedula_vendedor").val();
								var nombre_producto=$("#nombre_producto").val();
								var cantidad_comprada=$("#cantidad_comprada").val();
								$.ajax("PHP_MODELO/S_devuelve_calculos_de_la_compra.php",{data:{cedula_vendedor:cedula_vendedor, nombre_producto:nombre_producto, cantidad_comprada:cantidad_comprada}, type:'post'}).done(function(respuesta){
									$("#caja_para_calculos_de_la_compra").hide(500);
									$("#caja_para_calculos_de_la_compra").html(respuesta);
									$("#caja_para_calculos_de_la_compra").fadeIn(500);
								});
							}else{
								$("#caja_para_calculos_de_la_compra").hide(500);
								$("#caja_para_calculos_de_la_compra").html("");
								$("#caja_para_calculos_de_la_compra").fadeIn(500);
							}
						});
						$("#cantidad_comprada").on('change', function(){
							if($("#cedula_vendedor").val()!='' && $("#nombre_producto").val()!='' && $("#cantidad_comprada").val()!=''){
								var cedula_vendedor=$("#cedula_vendedor").val();
								var nombre_producto=$("#nombre_producto").val();
								var cantidad_comprada=$("#cantidad_comprada").val();
								$.ajax("PHP_MODELO/S_devuelve_calculos_de_la_compra.php",{data:{cedula_vendedor:cedula_vendedor, nombre_producto:nombre_producto, cantidad_comprada:cantidad_comprada}, type:'post'}).done(function(respuesta){
									$("#caja_para_calculos_de_la_compra").hide(500);
									$("#caja_para_calculos_de_la_compra").html(respuesta);
									$("#caja_para_calculos_de_la_compra").fadeIn(500);
								});
							}else{
								$("#caja_para_calculos_de_la_compra").hide(500);
								$("#caja_para_calculos_de_la_compra").html("");
								$("#caja_para_calculos_de_la_compra").fadeIn(500);
							}
						});
					});
				</script>
				<div class="input-group">
					<div id='click02' class='input-group date pickers mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100' title="Fecha de Pagado">Fecha Pagado:</span>
						</div>
						<input id='datepicker02' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fh_pagado' placeholder='Fecha de Pagado (Y-m-d)' autocomplete='off' title='Introduzca su Fecha de Pagado (Y-m-d)' required value="<?php echo $datos_actualizar['FH_PAGADO'][0]; ?>">
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
				<div class="input-group">
					<div id='click03' class='input-group date pickers mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100' title="Fecha de Entregado">Fecha Entregado:</span>
						</div>
						<input id='datepicker03' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fh_entregado' placeholder='Fecha de Entregado (Y-m-d)' autocomplete='off' title='Introduzca su Fecha de Entregado (Y-m-d)' value="<?php echo $datos_actualizar['FH_ENTREGADO'][0]; ?>">
					</div>
				</div>
				<script type="text/javascript">
					$('#datepicker03').click(function(){
						Calendar.setup({
							inputField     :    'datepicker03', 
							ifFormat       :    '%Y-%m-%d',  
							button         :    'click03', 
							align          :    'Tl',  
							singleClick    :    true
						});
					});
				</script>
				<div class="input-group">
					<div id='click04' class='input-group date pickers mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100' title="Fecha de Transacción Abandonado (si aplica)">Fecha Abandonado:</span>
						</div>
						<input id='datepicker04' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fh_transaccion_abandonada' placeholder='Fecha de Abandonado (Y-m-d)' autocomplete='off' title='Introduzca su Fecha de Abandonado (Y-m-d)' value="<?php echo $datos_actualizar['FH_TRANSACCION_ABANDONADA'][0]; ?>">
					</div>
				</div>
				<script type="text/javascript">
					$('#datepicker04').click(function(){
						Calendar.setup({
							inputField     :    'datepicker04', 
							ifFormat       :    '%Y-%m-%d',  
							button         :    'click04', 
							align          :    'Tl',  
							singleClick    :    true
						});
					});
				</script>
				<h5 class="text-center text-warning">Datos de Evaluación (Opcional):</h5>
				<div class="input-group">
					<div id='click05' class='input-group date pickers mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100' title="Fecha de Transacción Abandonado (si aplica)">Fecha Evaluación:</span>
						</div>
						<input id='datepicker05' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fh_evaluacion' placeholder='Fecha de Evaluación (Y-m-d)' autocomplete='off' title='Introduzca su Fecha de Evaluación (Y-m-d)' value="<?php echo $datos_actualizar['FH_EVALUACION'][0]; ?>">
					</div>
				</div>
				<script type="text/javascript">
					$('#datepicker05').click(function(){
						Calendar.setup({
							inputField     :    'datepicker05', 
							ifFormat       :    '%Y-%m-%d',  
							button         :    'click05', 
							align          :    'Tl',  
							singleClick    :    true
						});
					});
				</script>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Puntos:</span>
					</div>
					<div class="form-control col-md-9 p-0 m-0 px-2 rounded-0">
						<?php
							if($datos_actualizar['EVALUACION_PUNTOS'][0]=='5'){
								echo "<h3 class='text-warning'>
									<span id='estrella_1' class='fa fa-star'></span>
									<span id='estrella_2' class='fa fa-star'></span>
									<span id='estrella_3' class='fa fa-star'></span>
									<span id='estrella_4' class='fa fa-star'></span>
									<span id='estrella_5' class='fa fa-star'></span>
								</h3>";
							}else if($datos_actualizar['EVALUACION_PUNTOS'][0]=='4'){
								echo "<h3 class='text-warning'>
									<span id='estrella_1' class='fa fa-star'></span>
									<span id='estrella_2' class='fa fa-star'></span>
									<span id='estrella_3' class='fa fa-star'></span>
									<span id='estrella_4' class='fa fa-star'></span>
									<span id='estrella_5' class='fa fa-star-o'></span>
								</h3>";
							}else if($datos_actualizar['EVALUACION_PUNTOS'][0]=='3'){
								echo "<h3 class='text-warning'>
									<span id='estrella_1' class='fa fa-star'></span>
									<span id='estrella_2' class='fa fa-star'></span>
									<span id='estrella_3' class='fa fa-star'></span>
									<span id='estrella_4' class='fa fa-star-o'></span>
									<span id='estrella_5' class='fa fa-star-o'></span>
								</h3>";
							}else if($datos_actualizar['EVALUACION_PUNTOS'][0]=='2'){
								echo "<h3 class='text-warning'>
									<span id='estrella_1' class='fa fa-star'></span>
									<span id='estrella_2' class='fa fa-star'></span>
									<span id='estrella_3' class='fa fa-star-o'></span>
									<span id='estrella_4' class='fa fa-star-o'></span>
									<span id='estrella_5' class='fa fa-star-o'></span>
								</h3>";
							}else if($datos_actualizar['EVALUACION_PUNTOS'][0]=='1'){
								echo "<h3 class='text-warning'>
									<span id='estrella_1' class='fa fa-star'></span>
									<span id='estrella_2' class='fa fa-star-o'></span>
									<span id='estrella_3' class='fa fa-star-o'></span>
									<span id='estrella_4' class='fa fa-star-o'></span>
									<span id='estrella_5' class='fa fa-star-o'></span>
								</h3>";
							}else{
								echo "<h3 class='text-warning'>
									<span id='estrella_1' class='fa fa-star-o'></span>
									<span id='estrella_2' class='fa fa-star-o'></span>
									<span id='estrella_3' class='fa fa-star-o'></span>
									<span id='estrella_4' class='fa fa-star-o'></span>
									<span id='estrella_5' class='fa fa-star-o'></span>
								</h3>";
							}
						?>
					</div>
				</div>
				<div id="caja_para_puntos_evaluacion">
					<?php
						if($datos_actualizar['EVALUACION_PUNTOS'][0]=='5'){
							echo "<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='5'>";
						}else if($datos_actualizar['EVALUACION_PUNTOS'][0]=='4'){
							echo "<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='4'>";
						}else if($datos_actualizar['EVALUACION_PUNTOS'][0]=='3'){
							echo "<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='3'>";
						}else if($datos_actualizar['EVALUACION_PUNTOS'][0]=='2'){
							echo "<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='2'>";
						}else if($datos_actualizar['EVALUACION_PUNTOS'][0]=='1'){
							echo "<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='1'>";
						}else{
							echo "<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='0'>";
						}
					?>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#estrella_1").on('click', function(){
							$("#estrella_1").removeClass();
							$("#estrella_2").removeClass();
							$("#estrella_3").removeClass();
							$("#estrella_4").removeClass();
							$("#estrella_5").removeClass();
							$("#estrella_1").addClass("fa fa-star");
							$("#estrella_2").addClass("fa fa-star-o");
							$("#estrella_3").addClass("fa fa-star-o");
							$("#estrella_4").addClass("fa fa-star-o");
							$("#estrella_5").addClass("fa fa-star-o");
							$("#caja_para_puntos_evaluacion").html("<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='1'>");
						});
						$("#estrella_2").on('click', function(){
							$("#estrella_1").removeClass();
							$("#estrella_2").removeClass();
							$("#estrella_3").removeClass();
							$("#estrella_4").removeClass();
							$("#estrella_5").removeClass();
							$("#estrella_1").addClass("fa fa-star");
							$("#estrella_2").addClass("fa fa-star");
							$("#estrella_3").addClass("fa fa-star-o");
							$("#estrella_4").addClass("fa fa-star-o");
							$("#estrella_5").addClass("fa fa-star-o");
							$("#caja_para_puntos_evaluacion").html("<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='2'>");
						});
						$("#estrella_3").on('click', function(){
							$("#estrella_1").removeClass();
							$("#estrella_2").removeClass();
							$("#estrella_3").removeClass();
							$("#estrella_4").removeClass();
							$("#estrella_5").removeClass();
							$("#estrella_1").addClass("fa fa-star");
							$("#estrella_2").addClass("fa fa-star");
							$("#estrella_3").addClass("fa fa-star");
							$("#estrella_4").addClass("fa fa-star-o");
							$("#estrella_5").addClass("fa fa-star-o");
							$("#caja_para_puntos_evaluacion").html("<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='3'>");
						});
						$("#estrella_4").on('click', function(){
							$("#estrella_1").removeClass();
							$("#estrella_2").removeClass();
							$("#estrella_3").removeClass();
							$("#estrella_4").removeClass();
							$("#estrella_5").removeClass();
							$("#estrella_1").addClass("fa fa-star");
							$("#estrella_2").addClass("fa fa-star");
							$("#estrella_3").addClass("fa fa-star");
							$("#estrella_4").addClass("fa fa-star");
							$("#estrella_5").addClass("fa fa-star-o");
							$("#caja_para_puntos_evaluacion").html("<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='4'>");
						});
						$("#estrella_5").on('click', function(){
							$("#estrella_1").removeClass();
							$("#estrella_2").removeClass();
							$("#estrella_3").removeClass();
							$("#estrella_4").removeClass();
							$("#estrella_5").removeClass();
							$("#estrella_1").addClass("fa fa-star");
							$("#estrella_2").addClass("fa fa-star");
							$("#estrella_3").addClass("fa fa-star");
							$("#estrella_4").addClass("fa fa-star");
							$("#estrella_5").addClass("fa fa-star");
							$("#caja_para_puntos_evaluacion").html("<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='5'>");
						});
					});
				</script>
				<div class="input-group mb-2">
					<span class="input-group-text rounded-0 w-100">Comentario:</span>
					<textarea class="form-control p-0 m-0 px-2 rounded-0" name="evaluacion_comentario" id="evaluacion_comentario" placeholder="Comentario de la Evaluación (Opcional)" autocomplete="off" title="Introduzca el Comentario de la Evaluación del comprador (Opcional)" rows="2"><?php echo $datos_actualizar['EVALUACION_COMENTARIO'][0]; ?></textarea>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Estatus:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="estatus" id="estatus" required autocomplete="off" title="Indique el Estatus de la Transacción">
						<option><?php echo $datos_actualizar['ESTATUS'][0]; ?></option>
						<option>PAGADO</option>
						<option>ENTREGADO</option>
						<option>ABANDONADO</option>
					</select>
				</div>
				<div class="m-auto">
					<!-- SE DECIDIO BLOQUEAR LA OPCIÓN DE MODIFICAR DESABILITANDO EL BOTON-->
					<a href="CRUD_control_de_transacciones_micoin.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input disabled type="submit" value="Modificar Renglón &raquo;" class="btn btn-warning mb-2">
				</div>
			</div>
		</div>
	<?php
		//SI SE QUIERE BORRAR UN RENGLON ENTONCES:
	}else if($_GET["accion"]=='borrar'){
		?>
		<br><br><br>
		<div class="col-md-12 col-lg-9 mx-auto">
			<form action="CRUD_control_de_transacciones_micoin.php" method="post" class="text-center bg-dark p-2 rounded">
				<h3 class="text-center text-light pb-3" title="Borrar un Renglón">¿Seguro que desea Borrar el renglón de ID <?php echo $_GET['NA_Id']; ?>?</h3>
				<input type="hidden" name="FORM" id="FORM" value="BORRAR">
				<input type="hidden" name="id_trans" id="id_trans" value="<?php echo $_GET["NA_Id"]; ?>">
				<div class="m-auto">
					<a href="CRUD_control_de_transacciones_micoin.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Borrar Renglón &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
			<br><br><br><br><br><br><br><br>
		</div>
		<?php
			//SI NO SE HIZO NINGUNA ACCIÓN:
		}else{
		?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_control_de_transacciones_micoin.php">
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
	<!-- VISTA PARA PANTALLAS GRANDES -->
	<div class="card mb-3 bg-dark rounded-0 d-none d-lg-block">
		<div class="card-header text-center text-warning">
			<h3 class='text-center'><span class="fa fa-database"></span> C-V Productos:</h3>
		</div>
		<div class="card-body px-1 bg-white">
			<div class="table-responsive">
				<table class="table table-bordered table-hover TablaDinamica">
					<thead>
						<tr class="text-center">
							<th class="align-middle w-25"><b title="Apellido, Nombre, Cédula y Correo del Comprador">Comprador</b></th>
							<th class="align-middle"><b title="Nombre del Producto, Cantidad, tipo de compra,Estatus y correo del vendedor">Producto</b></th>
							<th class="align-middle"><b title="Monto Bruto, Ranking del vendedor, Monto Comisión y Monto Neto implicados en la transacción">Montos</b></th>
							<th class="align-middle"><b title="Fecha de Pago, Estatus de la transacción y Evaluación (Estrellas)">Estatus</b></th>
							<!-- SE DECICIÓ BLOQUEAR ESTA OPCCIÓN -->
							<th class="align-middle"><b>Sólo Ver</b></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//obteniendo los datos de la tabla:
						$datos=M_control_de_transacciones_compras_en_micoin_R($conexion, '', '', '', '', '', '');
						$i=0;
						while(isset($datos['ID_TRANSACCION'][$i])){
							if($datos['ID_TRANSACCION'][$i]<>""){
								echo "<tr>";
								echo "<td class='text-left'><b>Apellido:</b> " . $datos['COMPRADOR_APELLIDO'][$i] . "<br><b>Nombre:</b> " . $datos['COMPRADOR_NOMBRE'][$i] . "<br><b>Cédula/RIF:</b> " . $datos['COMPRADOR_CEDULA_RIF'][$i] . "<br><b class='text-danger'>" . $datos['COMPRADOR_CORREO'][$i] . "</b></td>";
								$datos_del_vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $datos['COMPRADOR_CEDULA_RIF'][$i], '', '', '', '');
								echo "<td class='text-left'><b>Producto:</b> " . $datos['NOMBRE_PRODUCTO'][$i] . " (" . $datos['CANTIDAD_COMPRADA'][$i] . ")<br><b>Venta:</b> " . $datos['TIPO_DE_COMPRA'][$i] . "<br><b>Estatus-Vendedor:</b> " . $datos_del_vendedor['ESTATUS'][0] . "<br><b class='text-danger'>" . $datos['VENDEDOR_CORREO'][$i] . "</b></td>";
								echo "<td class='text-left'><b>Bruto:</b> " . number_format($datos['MONTO_BRUTO_MICOIN'][$i], 2,',','.') . "<br><b>Ranking:</b> " . $datos['RANKING'][$i] . "<br><b>Comisión:</b> " . number_format($datos['MONTO_COMISION'][$i], 2,',','.') . "<br><b>Neto:</b> " . number_format($datos['MONTO_NETO'][$i], 2,',','.') . "</td>";
								$fecha_i=explode(" ",$datos['FH_PAGADO'][$i]);
								echo "<td class='text-left'><b>Pagó el:</b> " . $fecha_i[0] . "<br><b>Estatus:</b> " . $datos['ESTATUS'][$i] . "<br><b>Evaluación:</b><br><div class='px-4'>";
								echo M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][$i]);
								echo "</div></td>";
								/* SE DECICIÓ BLOQUEAR ESTA OPCCIÓN */
								echo "<td class='text-center h5'><a title='Modificar' href='CRUD_control_de_transacciones_micoin.php?accion=actualizar&NA_Id=" . $datos['ID_TRANSACCION'][$i] . "' class='btn btn-transparent text-success fa fa-eye d-inline'></a>";
								/*
								echo "&nbsp;&nbsp;";
								echo "<a title='Eliminar' href='CRUD_control_de_transacciones_micoin.php?accion=borrar&NA_Id=" . $datos['ID_TRANSACCION'][$i] . "' class='btn btn-transparent text-danger fa fa-trash-o d-inline'></a></td>";
								*/
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
	<!-- VISTA PARA PANTALLAS PEQUEÑAS -->
	<div class="card mb-3 bg-dark rounded-0 d-block d-lg-none">
		<div class="card-header text-center text-warning">
			<h3 class='text-center'><span class="fa fa-database"></span> C-V Productos:</h3>
		</div>
		<div class="card-body px-1 bg-white">
			<div class="table-responsive">
				<table class="table table-bordered table-hover TablaDinamica">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b title="Información de la Transacción">Transacción</b></th>
							<th class="align-middle"><b title="Monto Bruto, Ranking del vendedor, Monto Comisión y Monto Neto implicados en la transacción">Montos</b></th>
							<!-- SE DECICIÓ BLOQUEAR ESTA OPCCIÓN -->
							<th class="align-middle"><b><span class="fa fa-arrow-down"></span></b></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//obteniendo los datos de la tabla:
						$datos=M_control_de_transacciones_compras_en_micoin_R($conexion, '', '', '', '', '', '');
						$i=0;
						while(isset($datos['ID_TRANSACCION'][$i])){
							if($datos['ID_TRANSACCION'][$i]<>""){
								$fecha_i=explode(" ",$datos['FH_PAGADO'][$i]);
								echo "<tr>";
								echo "<td class='text-left'>" . $fecha_i[0] . "<br><b>Producto:</b> " . $datos['NOMBRE_PRODUCTO'][$i] . "<br><b>Comprador:</b> " . $datos['COMPRADOR_NOMBRE'][$i] . " " . $datos['COMPRADOR_APELLIDO'][$i] . "<br><b>Vendedor:</b> " . $datos['VENDEDOR_NOMBRE'][$i] . " " . $datos['VENDEDOR_APELLIDO'][$i] . "<br><b>Tipo:</b> " . $datos['TIPO_DE_COMPRA'][$i] . "</td>";
								echo "<td class='text-left'><b>Bruto:</b> " . number_format($datos['MONTO_BRUTO_MICOIN'][$i], 2,',','.') . "<br><b>Ranking:</b> " . $datos['RANKING'][$i] . "<br><b>Comisión:</b> " . number_format($datos['MONTO_COMISION'][$i], 2,',','.') . "<br><b>Neto:</b> " . number_format($datos['MONTO_NETO'][$i], 2,',','.') . "<br><b>Estatus:</b> " . $datos['ESTATUS'][$i] . "</td>";
								/* SE DECICIÓ BLOQUEAR ESTA OPCCIÓN */
								echo "<td class='text-center h5'><a title='Modificar' href='CRUD_control_de_transacciones_micoin.php?accion=actualizar&NA_Id=" . $datos['ID_TRANSACCION'][$i] . "' class='btn btn-transparent text-success fa fa-eye d-inline'></a>";
								/*
								echo "&nbsp;&nbsp;";
								echo "<a title='Eliminar' href='CRUD_control_de_transacciones_micoin.php?accion=borrar&NA_Id=" . $datos['ID_TRANSACCION'][$i] . "' class='btn btn-transparent text-danger fa fa-trash-o d-inline'></a></td>";
								*/
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