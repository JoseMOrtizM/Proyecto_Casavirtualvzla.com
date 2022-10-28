<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
if(isset($_POST['FORM'])){
	if($_POST['FORM']=='INSERTAR'){
		$cedula=mysqli_real_escape_string($conexion,$_POST['cedula']);
		$solicitante=M_usuarios_R($conexion, 'CEDULA_RIF', $cedula, '', '', '', '');
		$tipo_de_transaccion=mysqli_real_escape_string($conexion, $_POST['tipo_de_transaccion']);
		$tipo_de_moneda_real=mysqli_real_escape_string($conexion, $_POST['tipo_de_moneda_real']);
		$cantidad_micoin=mysqli_real_escape_string($conexion, $_POST['cantidad_micoin']);
		$id_tasa_de_cambio=mysqli_real_escape_string($conexion, $_POST['id_tasa']);
		$monto_bruto=mysqli_real_escape_string($conexion, $_POST['monto_bruto']);
		$porc_comision=mysqli_real_escape_string($conexion, $_POST['porc_comision']);
		$monto_comision=mysqli_real_escape_string($conexion, $_POST['monto_comision']);
		$monto_neto=mysqli_real_escape_string($conexion, $_POST['monto_neto']);
		$fh_solicitado=mysqli_real_escape_string($conexion, $_POST['fh_solicitado']);
		$cta_banco_desde=mysqli_real_escape_string($conexion, $_POST['cta_banco_desde']);
		$cta_banco_hacia=mysqli_real_escape_string($conexion, $_POST['cta_banco_hacia']);
		$numero_transferencia=mysqli_real_escape_string($conexion, $_POST['numero_transferencia']);
		$fh_pagado=mysqli_real_escape_string($conexion, $_POST['fh_pagado']);
		$fh_confirmado=mysqli_real_escape_string($conexion, $_POST['fh_confirmado']);
		$fh_transaccion_abandonada=mysqli_real_escape_string($conexion, $_POST['fh_transaccion_abandonada']);
		$estatus=mysqli_real_escape_string($conexion, $_POST['estatus']);
		//INSERTANDO DATOS
		$verf_insert=M_compra_venta_de_micoin_C($conexion, $solicitante['NOMBRE'][0], $solicitante['APELLIDO'][0], $solicitante['CEDULA_RIF'][0], $solicitante['CORREO'][0], $solicitante['FECHA_NACIMIENTO'][0], $solicitante['EMPRESA'][0], $solicitante['TELEFONO'][0], $solicitante['DIRECCION'][0], $solicitante['BANCO_NOMBRE'][0], $solicitante['BANCO_NUMERO_CUENTA'][0], $solicitante['BANCO_TIPO_CUENTA'][0], $solicitante['BANCO_TELEFONO'][0], $solicitante['BANCO_CEDULA_RIF'][0], $tipo_de_transaccion, $tipo_de_moneda_real, $cantidad_micoin, $id_tasa_de_cambio, $monto_bruto, $porc_comision, $monto_comision, $monto_neto, $fh_solicitado, $cta_banco_desde, $cta_banco_hacia, $numero_transferencia, $fh_pagado, $fh_confirmado, $fh_transaccion_abandonada, $estatus);
	}else if($_POST['FORM']=='MODIFICAR'){
		$id_c_v=mysqli_real_escape_string($conexion,$_POST['id_c_v']);
		$cedula=mysqli_real_escape_string($conexion,$_POST['cedula']);
		$solicitante=M_usuarios_R($conexion, 'CEDULA_RIF', $cedula, '', '', '', '');
		$tipo_de_transaccion=mysqli_real_escape_string($conexion, $_POST['tipo_de_transaccion']);
		$tipo_de_moneda_real=mysqli_real_escape_string($conexion, $_POST['tipo_de_moneda_real']);
		$cantidad_micoin=mysqli_real_escape_string($conexion, $_POST['cantidad_micoin']);
		$id_tasa_de_cambio=mysqli_real_escape_string($conexion, $_POST['id_tasa']);
		$monto_bruto=mysqli_real_escape_string($conexion, $_POST['monto_bruto']);
		$porc_comision=mysqli_real_escape_string($conexion, $_POST['porc_comision']);
		$monto_comision=mysqli_real_escape_string($conexion, $_POST['monto_comision']);
		$monto_neto=mysqli_real_escape_string($conexion, $_POST['monto_neto']);
		$fh_solicitado=mysqli_real_escape_string($conexion, $_POST['fh_solicitado']);
		$cta_banco_desde=mysqli_real_escape_string($conexion, $_POST['cta_banco_desde']);
		$cta_banco_hacia=mysqli_real_escape_string($conexion, $_POST['cta_banco_hacia']);
		$numero_transferencia=mysqli_real_escape_string($conexion, $_POST['numero_transferencia']);
		$fh_pagado=mysqli_real_escape_string($conexion, $_POST['fh_pagado']);
		$fh_confirmado=mysqli_real_escape_string($conexion, $_POST['fh_confirmado']);
		$fh_transaccion_abandonada=mysqli_real_escape_string($conexion, $_POST['fh_transaccion_abandonada']);
		$estatus=mysqli_real_escape_string($conexion, $_POST['estatus']);
		//ACTUALIZANDO DATOS EN LA BD
		M_compra_venta_de_micoin_U_id($conexion, $id_c_v, $solicitante['NOMBRE'][0], $solicitante['APELLIDO'][0], $solicitante['CEDULA_RIF'][0], $solicitante['CORREO'][0], $solicitante['FECHA_NACIMIENTO'][0], $solicitante['EMPRESA'][0], $solicitante['TELEFONO'][0], $solicitante['DIRECCION'][0], $solicitante['BANCO_NOMBRE'][0], $solicitante['BANCO_NUMERO_CUENTA'][0], $solicitante['BANCO_TIPO_CUENTA'][0], $solicitante['BANCO_TELEFONO'][0], $solicitante['BANCO_CEDULA_RIF'][0], $tipo_de_transaccion, $tipo_de_moneda_real, $cantidad_micoin, $id_tasa_de_cambio, $monto_bruto, $porc_comision, $monto_comision, $monto_neto, $fh_solicitado, $cta_banco_desde, $cta_banco_hacia, $numero_transferencia, $fh_pagado, $fh_confirmado, $fh_transaccion_abandonada, $estatus);
	}else if($_POST['FORM']=='BORRAR'){
		$id_c_v=mysqli_real_escape_string($conexion,$_POST['id_c_v']);
		M_compra_venta_de_micoin_D_id($conexion, $id_c_v);
	}
}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>CRUD Compra-Venta Pm</title>
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
					<a href="CRUD_compra_venta_de_micoin.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
				</div>
			</div>
			<form action="CRUD_compra_venta_de_micoin.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="FORM" id="FORM" value="INSERTAR">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Solicitante:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cedula" id="cedula" required autocomplete="off" title="Indique la cedula del usuario solicitante">
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
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Transacción:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_de_transaccion" id="tipo_de_transaccion" required autocomplete="off" title="Indique el Tipo de Transacción">
						<option></option>
						<option>COMPRA</option>
						<option>VENTA</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Moneda:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_de_moneda_real" id="tipo_de_moneda_real" required autocomplete="off" title="Indique el Tipo de moneda a canjear">
						<option></option>
						<?php
							$tipo_de_monedas=M_tipos_de_moneda();
							$e=0;
							while(isset($tipo_de_monedas[$e])){
								echo "<option>" . $tipo_de_monedas[$e] . "</option>";
								$e=$e+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cantidad Pm:</span>
					</div>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cantidad_micoin" id="cantidad_micoin" placeholder="Introduzca el nombre del producto" required autocomplete="off" title="Introduzca la cantidad de monedas virtuales correspondiente a la transacción" step="any">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Tasa:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="id_tasa" id="id_tasa" required autocomplete="off" title="Indique la tasa de cambio Compra/Venta de la transacción (Fecha de tasa Vigente <<Y-m-d>> (Tasa para la Compra y Tasa para la Venta))">
						<option></option>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#tipo_de_moneda_real").on('change', function(){
							var moneda=$("#tipo_de_moneda_real").val();
							$.ajax("PHP_MODELO/S_agrupa_tasas_de_cambio.php",{data:{moneda:moneda}, type:'post'}).done(function(respuesta){
								$("#id_tasa").html(respuesta);
							});
						});
					});
				</script>
				<div id="caja_calculos"></div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#tipo_de_transaccion").on('change', function(){
							if($("#tipo_de_transaccion").val()!='' && $("#cantidad_micoin").val()!='' && $("#id_tasa").val()!=''){
								var tipo_de_transaccion=$("#tipo_de_transaccion").val();
								var cantidad=$("#cantidad_micoin").val();
								var id_tasa=$("#id_tasa").val();
								$.ajax("PHP_MODELO/S_calcula_tasa_transaccion.php",{data:{tipo_de_transaccion:tipo_de_transaccion, cantidad:cantidad, id_tasa:id_tasa}, type:'post'}).done(function(respuesta){
									$("#caja_calculos").hide(500);
									$("#caja_calculos").html(respuesta);
									$("#caja_calculos").fadeIn(500);
								});
							}else{
								$("#caja_calculos").hide(500);
								$("#caja_calculos").html("");
								$("#caja_calculos").fadeIn(500);
							}
						});
						$("#cantidad_micoin").on('change', function(){
							if($("#tipo_de_transaccion").val()!='' && $("#cantidad_micoin").val()!='' && $("#id_tasa").val()!=''){
								var tipo_de_transaccion=$("#tipo_de_transaccion").val();
								var cantidad=$("#cantidad_micoin").val();
								var id_tasa=$("#id_tasa").val();
								$.ajax("PHP_MODELO/S_calcula_tasa_transaccion.php",{data:{tipo_de_transaccion:tipo_de_transaccion, cantidad:cantidad, id_tasa:id_tasa}, type:'post'}).done(function(respuesta){
									$("#caja_calculos").hide(500);
									$("#caja_calculos").html(respuesta);
									$("#caja_calculos").fadeIn(500);
								});
							}else{
								$("#caja_calculos").hide(500);
								$("#caja_calculos").html("");
								$("#caja_calculos").fadeIn(500);
							}
						});
						$("#id_tasa").on('change', function(){
							if($("#tipo_de_transaccion").val()!='' && $("#cantidad_micoin").val()!='' && $("#id_tasa").val()!=''){
								var tipo_de_transaccion=$("#tipo_de_transaccion").val();
								var cantidad=$("#cantidad_micoin").val();
								var id_tasa=$("#id_tasa").val();
								$.ajax("PHP_MODELO/S_calcula_tasa_transaccion.php",{data:{tipo_de_transaccion:tipo_de_transaccion, cantidad:cantidad, id_tasa:id_tasa}, type:'post'}).done(function(respuesta){
									$("#caja_calculos").hide(500);
									$("#caja_calculos").html(respuesta);
									$("#caja_calculos").fadeIn(500);
								});
							}else{
								$("#caja_calculos").hide(500);
								$("#caja_calculos").html("");
								$("#caja_calculos").fadeIn(500);
							}
						});
					});
				</script>
				<div class="input-group">
					<div id='click01' class='input-group date pickers mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100' title="Fecha de Solicitud">Fecha Solic.:</span>
						</div>
						<input id='datepicker01' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fh_solicitado' placeholder='Fecha de Solicitud (Y-m-d)' required autocomplete='off' title='Introduzca su Fecha de Solicitud (Y-m-d)'>
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
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cta Origen:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cta_banco_desde" id="cta_banco_desde" placeholder="Banco de origen de transferencia" required autocomplete="off" title="Introduzca el Banco de origen de la transferencia">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cta Destino:</span>
					</div>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cta_banco_hacia" id="cta_banco_hacia" placeholder="número de cuenta destino de transferencia" required autocomplete="off" title="Introduzca el número de cuenta destino de la transferencia">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">N° Confirmación:</span>
					</div>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="numero_transferencia" id="numero_transferencia" placeholder="número de confirmación de transferencia" required autocomplete="off" title="Introduzca el número de confirmación de la transferencia">
				</div>
				<div class="input-group">
					<div id='click02' class='input-group date pickers mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100' title="Fecha de Pagado">Fecha Pagado:</span>
						</div>
						<input id='datepicker02' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fh_pagado' placeholder='Fecha de Pagado (Y-m-d)' autocomplete='off' title='Introduzca su Fecha de Pagado (Y-m-d)'>
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
							<span class='input-group-text rounded-0 w-100' title="Fecha de Confirmado">Fecha Confirmado:</span>
						</div>
						<input id='datepicker03' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fh_confirmado' placeholder='Fecha de Confirmado (Y-m-d)' autocomplete='off' title='Introduzca su Fecha de Confirmado (Y-m-d)'>
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
							<span class='input-group-text rounded-0 w-100' title="Fecha de Abandonado">Fecha Abandonado:</span>
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
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Estatus:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="estatus" id="estatus" required autocomplete="off" title="Indique el Estatus de la Transacción">
						<option></option>
						<option>SOLICITADO</option>
						<option>PAGADO</option>
						<option>CONFIRMADO</option>
						<option>RECHAZADO</option>
						<option>ABANDONADO</option>
					</select>
				</div>
				<div class="m-auto">
					<a href="CRUD_compra_venta_de_micoin.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Insertar Renglón &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
		</div>
		<?php
			// -------------    SI SE QUIERE MODIFICAR UN RENGLON ENTONCES --------------  :
			}else if($_GET["accion"]=='actualizar'){
				$datos_actualizar=M_compra_venta_de_micoin_R($conexion, 'ID_COMPRA_VENTA', $_GET['NA_Id'], '', '', '', '');
		?>
		<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
			<div class="row mt-4 align-items-center rounded-top px-2">
				<div class="col-md-9 mb-1 mt-3">
					<h3 class="text-center text-md-left text-warning">Modificar Transacción:</h3>
				</div>
				<div class="col-md-3 text-center text-md-right mb-1 mt-3">
					<a href="CRUD_compra_venta_de_micoin.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
				</div>
			</div>
			<form action="CRUD_compra_venta_de_micoin.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="FORM" id="FORM" value="MODIFICAR">
				<input type="hidden" name="id_c_v" id="id_c_v" value="<?php echo $datos_actualizar['ID_COMPRA_VENTA'][0]; ?>">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Solicitante:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cedula" id="cedula" required autocomplete="off" title="Indique la cedula del usuario solicitante">
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
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Transacción:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_de_transaccion" id="tipo_de_transaccion" required autocomplete="off" title="Indique el Tipo de Transacción">
						<option><?php echo $datos_actualizar['TIPO_DE_TRANSACCION'][0]; ?></option>
						<option>COMPRA</option>
						<option>VENTA</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Moneda:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_de_moneda_real" id="tipo_de_moneda_real" required autocomplete="off" title="Indique el Tipo de moneda a canjear">
						<option><?php echo $datos_actualizar['TIPO_DE_MONEDA_REAL'][0]; ?></option>
						<?php
							$tipo_de_monedas=M_tipos_de_moneda();
							$e=0;
							while(isset($tipo_de_monedas[$e])){
								echo "<option>" . $tipo_de_monedas[$e] . "</option>";
								$e=$e+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cantidad Pm:</span>
					</div>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cantidad_micoin" id="cantidad_micoin" placeholder="Introduzca el nombre del producto" required autocomplete="off" title="Introduzca la cantidad de monedas virtuales correspondiente a la transacción" step="any" value="<?php echo $datos_actualizar['CANTIDAD_MICOIN'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Tasa:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="id_tasa" id="id_tasa" required autocomplete="off" title="Indique la tasa de cambio Compra/Venta de la transacción (Fecha de tasa Vigente <<Y-m-d>> (Tasa para la Compra y Tasa para la Venta))">
						<?php
							//este es el option que proviene de la base de datos
							$tasa_id=M_paridad_cambiaria_R($conexion, 'ID_TASA_DE_CAMBIO', $datos_actualizar['ID_TASA_DE_CAMBIO'][0], '', '', '', '');
							$fecha_i=explode(" ",$tasa_id['FH_REGISTRO'][0]);
							echo "<option value='" . $tasa_id['ID_TASA_DE_CAMBIO'][0] . "'>" . $fecha_i[0] . ": " . $tasa_id['TIPO_DE_MONEDA_REAL'][0] . " C: " .  $tasa_id['TIPO_POR_MICOIN_COMPRA'][0] . "(" . $tasa_id['PORC_COMISION_POR_COMPRA'][0] . "%) V: " . $tasa_id['TIPO_POR_MICOIN_VENTA'][0] . "(" . $tasa_id['PORC_COMISION_POR_VENTA'][0] . "%)</option>";
							//este es el array de options para la moneda dada
							$tasas_i=M_paridad_cambiaria_R($conexion, 'TIPO_DE_MONEDA_REAL', $datos_actualizar['TIPO_DE_MONEDA_REAL'][0], '', '', '', '');
							$i=0;
							while(isset($tasas_i['ID_TASA_DE_CAMBIO'][$i])){
								$fecha_ii=explode(" ",$tasas_i['FH_REGISTRO'][$i]);
								echo "<option value='" . $tasas_i['ID_TASA_DE_CAMBIO'][$i] . "'>" . $fecha_ii[0] . ": " . $tasas_i['TIPO_DE_MONEDA_REAL'][$i] . " C: " .  $tasas_i['TIPO_POR_MICOIN_COMPRA'][$i] . "(" . $tasas_i['PORC_COMISION_POR_COMPRA'][$i] . "%) V: " . $tasas_i['TIPO_POR_MICOIN_VENTA'][$i] . "(" . $tasas_i['PORC_COMISION_POR_VENTA'][$i] . "%)</option>";
								$i=$i+1;
							}
						?>
					</select>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#tipo_de_moneda_real").on('change', function(){
							var moneda=$("#tipo_de_moneda_real").val();
							$.ajax("PHP_MODELO/S_agrupa_tasas_de_cambio.php",{data:{moneda:moneda}, type:'post'}).done(function(respuesta){
								$("#id_tasa").html(respuesta);
							});
						});
					});
				</script>
				<div id="caja_calculos">
					<?php
						if($datos_actualizar['TIPO_DE_TRANSACCION'][0]=='COMPRA'){
							$tasas_act=M_paridad_cambiaria_R($conexion, 'TIPO_DE_MONEDA_REAL', $datos_actualizar['TIPO_DE_MONEDA_REAL'][0], '', '', '', '');
							$moneda=$datos_actualizar['TIPO_DE_MONEDA_REAL'][0];

							$monto_bruto=$datos_actualizar['CANTIDAD_MICOIN'][0]*$tasas_act['TIPO_POR_MICOIN_COMPRA'][0];
							$porc_comision=$tasas_act['PORC_COMISION_POR_COMPRA'][0];
							$monto_comision=$monto_bruto*$porc_comision/100;
							$monto_neto=$monto_bruto+$monto_comision;
							
							$monto_bruto_imp=number_format($monto_bruto, 2,',','.');
							$porc_comision_imp=number_format($porc_comision, 2,',','.');
							$monto_comision_imp=number_format($monto_comision, 2,',','.');
							$monto_neto_imp=number_format($monto_neto, 2,',','.');
							echo "
								<div class='input-group mb-2'>
									<div class='col-md-3 p-0 m-0'>
										<span class='input-group-text rounded-0 w-100'>$moneda al Cambio:</span>
									</div>
									<input type='hidden' name='monto_bruto' id='monto_bruto' value='$monto_bruto'>
									<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0 text-dark' name='monto_bruto_imprimir' id='monto_bruto_imprimir' title='cantidad de $moneda sin incluir la comisión por compra' step='any' disabled value='$monto_bruto_imp'>
								</div>
								<div class='input-group mb-2'>
									<div class='col-md-3 p-0 m-0'>
										<span class='input-group-text rounded-0 w-100'>% Comisión:</span>
									</div>
									<input type='hidden' name='porc_comision' id='porc_comision' value='$porc_comision'>
									<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='porc_comision_imprimir' id='porc_comision_imprimir' title='Porcentaje de comisión agregado por compra de moneda virtual' step='any' disabled value='$porc_comision_imp'>
								</div>
								<div class='input-group mb-2'>
									<div class='col-md-3 p-0 m-0'>
										<span class='input-group-text rounded-0 w-100'>Monto Comisión:</span>
									</div>
									<input type='hidden' name='monto_comision' id='monto_comision' value='$monto_comision'>
									<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='monto_comision_imprimir' id='monto_comision_imprimir' title='Monto de comisión agregado por compra de moneda virtual' step='any' disabled value='$monto_comision_imp'>
								</div>
								<div class='input-group mb-2'>
									<div class='col-md-3 p-0 m-0'>
										<span class='input-group-text rounded-0 w-100'>Monto Neto:</span>
									</div>
									<input type='hidden' name='monto_neto' id='monto_neto' value='$monto_neto'>
									<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='monto_neto_imprimir' id='monto_neto_imprimir' title='Monto Neto a pagar por compra de moneda virtual' step='any' disabled value='$monto_neto_imp'>
								</div>
							";
						}else{
							$tasas_act=M_paridad_cambiaria_R($conexion, 'TIPO_DE_MONEDA_REAL', $datos_actualizar['TIPO_DE_MONEDA_REAL'][0], '', '', '', '');
							$moneda=$datos_actualizar['TIPO_DE_MONEDA_REAL'][0];

							$monto_bruto=$datos_actualizar['CANTIDAD_MICOIN'][0]*$tasas_act['TIPO_POR_MICOIN_VENTA'][0];
							$porc_comision=$tasas_act['PORC_COMISION_POR_VENTA'][0];
							$monto_comision=$monto_bruto*$porc_comision/100;
							$monto_neto=$monto_bruto-$monto_comision;
							$monto_bruto_imp=number_format($monto_bruto, 2,',','.');
							$porc_comision_imp=number_format($porc_comision, 2,',','.');
							$monto_comision_imp=number_format($monto_comision, 2,',','.');
							$monto_neto_imp=number_format($monto_neto, 2,',','.');
							echo "
								<div class='input-group mb-2'>
									<div class='col-md-3 p-0 m-0'>
										<span class='input-group-text rounded-0 w-100'>$moneda al Cambio:</span>
									</div>
									<input type='hidden' name='monto_bruto' id='monto_bruto' value='$monto_bruto'>
									<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='monto_bruto_imprimir' id='monto_bruto_imprimir' title='cantidad de $moneda sin incluir la comisión por venta' step='any' disabled value='$monto_bruto_imp'>
								</div>
								<div class='input-group mb-2'>
									<div class='col-md-3 p-0 m-0'>
										<span class='input-group-text rounded-0 w-100'>% Comisión:</span>
									</div>
									<input type='hidden' name='porc_comision' id='porc_comision' value='$porc_comision'>
									<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='porc_comision_imprimir' id='porc_comision_imprimir' title='Porcentaje de comisión agregado por venta de moneda virtual' step='any' disabled value='$porc_comision_imp'>
								</div>
								<div class='input-group mb-2'>
									<div class='col-md-3 p-0 m-0'>
										<span class='input-group-text rounded-0 w-100'>Monto Comisión:</span>
									</div>
									<input type='hidden' name='monto_comision' id='monto_comision' value='$monto_comision'>
									<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='monto_comision_imprimir' id='monto_comision_imprimir' title='Monto de comisión agregado por venta de moneda virtual' step='any' disabled value='$monto_comision_imp'>
								</div>
								<div class='input-group mb-2'>
									<div class='col-md-3 p-0 m-0'>
										<span class='input-group-text rounded-0 w-100'>Monto Neto:</span>
									</div>
									<input type='hidden' name='monto_neto' id='monto_neto' value='$monto_neto'>
									<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='monto_neto_imprimir' id='monto_neto_imprimir' title='Monto Neto a pagar por venta de moneda virtual' step='any' disabled value='$monto_neto_imp'>
								</div>
							";
						}
					?>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#tipo_de_transaccion").on('change', function(){
							if($("#tipo_de_transaccion").val()!='' && $("#cantidad_micoin").val()!='' && $("#id_tasa").val()!=''){
								var tipo_de_transaccion=$("#tipo_de_transaccion").val();
								var cantidad=$("#cantidad_micoin").val();
								var id_tasa=$("#id_tasa").val();
								$.ajax("PHP_MODELO/S_calcula_tasa_transaccion.php",{data:{tipo_de_transaccion:tipo_de_transaccion, cantidad:cantidad, id_tasa:id_tasa}, type:'post'}).done(function(respuesta){
									$("#caja_calculos").hide(500);
									$("#caja_calculos").html(respuesta);
									$("#caja_calculos").fadeIn(500);
								});
							}else{
								$("#caja_calculos").hide(500);
								$("#caja_calculos").html("");
								$("#caja_calculos").fadeIn(500);
							}
						});
						$("#cantidad_micoin").on('change', function(){
							if($("#tipo_de_transaccion").val()!='' && $("#cantidad_micoin").val()!='' && $("#id_tasa").val()!=''){
								var tipo_de_transaccion=$("#tipo_de_transaccion").val();
								var cantidad=$("#cantidad_micoin").val();
								var id_tasa=$("#id_tasa").val();
								$.ajax("PHP_MODELO/S_calcula_tasa_transaccion.php",{data:{tipo_de_transaccion:tipo_de_transaccion, cantidad:cantidad, id_tasa:id_tasa}, type:'post'}).done(function(respuesta){
									$("#caja_calculos").hide(500);
									$("#caja_calculos").html(respuesta);
									$("#caja_calculos").fadeIn(500);
								});
							}else{
								$("#caja_calculos").hide(500);
								$("#caja_calculos").html("");
								$("#caja_calculos").fadeIn(500);
							}
						});
						$("#id_tasa").on('change', function(){
							if($("#tipo_de_transaccion").val()!='' && $("#cantidad_micoin").val()!='' && $("#id_tasa").val()!=''){
								var tipo_de_transaccion=$("#tipo_de_transaccion").val();
								var cantidad=$("#cantidad_micoin").val();
								var id_tasa=$("#id_tasa").val();
								$.ajax("PHP_MODELO/S_calcula_tasa_transaccion.php",{data:{tipo_de_transaccion:tipo_de_transaccion, cantidad:cantidad, id_tasa:id_tasa}, type:'post'}).done(function(respuesta){
									$("#caja_calculos").hide(500);
									$("#caja_calculos").html(respuesta);
									$("#caja_calculos").fadeIn(500);
								});
							}else{
								$("#caja_calculos").hide(500);
								$("#caja_calculos").html("");
								$("#caja_calculos").fadeIn(500);
							}
						});
					});
				</script>
				<div class="input-group">
					<div id='click01' class='input-group date pickers mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100' title="Fecha de Solicitud">Fecha Solic.:</span>
						</div>
						<input id='datepicker01' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fh_solicitado' placeholder='Fecha de Solicitud (Y-m-d)' required autocomplete='off' title='Introduzca su Fecha de Solicitud (Y-m-d)' value="<?php echo $datos_actualizar['FH_SOLICITADO'][0]; ?>">
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
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cta Origen:</span>
					</div>
					<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cta_banco_desde" id="cta_banco_desde" placeholder="Banco de cuenta origen de transferencia" required autocomplete="off" title="Introduzca el Banco de origen de la transferencia" value="<?php echo $datos_actualizar['CTA_BANCO_DESDE'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cta Destino:</span>
					</div>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cta_banco_hacia" id="cta_banco_hacia" placeholder="número de cuenta destino de transferencia" required autocomplete="off" title="Introduzca el número de cuenta destino de la transferencia" value="<?php echo $datos_actualizar['CTA_BANCO_HACIA'][0]; ?>">
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">N° Confirmación:</span>
					</div>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="numero_transferencia" id="numero_transferencia" placeholder="número de confirmación de transferencia" required autocomplete="off" title="Introduzca el número de confirmación de la transferencia" value="<?php echo $datos_actualizar['NUMERO_TRANSFERENCIA'][0]; ?>">
				</div>
				<div class="input-group">
					<div id='click02' class='input-group date pickers mb-2'>
						<div class='col-md-3 p-0 m-0'>
							<span class='input-group-text rounded-0 w-100' title="Fecha de Pagado">Fecha Pagado:</span>
						</div>
						<input id='datepicker02' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fh_pagado' placeholder='Fecha de Pagado (Y-m-d)' autocomplete='off' title='Introduzca su Fecha de Pagado (Y-m-d)' value="<?php echo $datos_actualizar['FH_PAGADO'][0]; ?>">
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
							<span class='input-group-text rounded-0 w-100' title="Fecha de Confirmado">Fecha Confirmado:</span>
						</div>
						<input id='datepicker03' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fh_confirmado' placeholder='Fecha de Confirmado (Y-m-d)' autocomplete='off' title='Introduzca su Fecha de Confirmado (Y-m-d)' value="<?php echo $datos_actualizar['FH_CONFIRMADO'][0]; ?>">
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
							<span class='input-group-text rounded-0 w-100' title="Fecha de Abandonado">Fecha Abandonado:</span>
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
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Estatus:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="estatus" id="estatus" required autocomplete="off" title="Indique el Estatus de la Transacción">
						<option><?php echo $datos_actualizar['ESTATUS'][0]; ?></option>
						<option>SOLICITADO</option>
						<option>PAGADO</option>
						<option>CONFIRMADO</option>
						<option>RECHAZADO</option>
						<option>ABANDONADO</option>
					</select>
				</div>
				<div class="m-auto">
					<!-- SE DECIDIO BLOQUEAR LA OPCIÓN DE MODIFICAR DESABILITANDO EL BOTON-->
					<a href="CRUD_compra_venta_de_micoin.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input disabled type="submit" value="Modificar Renglón &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
		</div>
	<?php
		//SI SE QUIERE BORRAR UN RENGLON ENTONCES:
	}else if($_GET["accion"]=='borrar'){
		?>
		<br><br><br>
		<div class="col-md-12 col-lg-9 mx-auto">
			<form action="CRUD_compra_venta_de_micoin.php" method="post" class="text-center bg-dark p-2 rounded">
				<h3 class="text-center text-light pb-3" title="Borrar un Renglón">¿Seguro que desea Borrar el renglón de ID <?php echo $_GET['NA_Id']; ?>?</h3>
				<input type="hidden" name="FORM" id="FORM" value="BORRAR">
				<input type="hidden" name="id_c_v" id="id_c_v" value="<?php echo $_GET["NA_Id"]; ?>">
				<div class="m-auto">
					<a href="CRUD_compra_venta_de_micoin.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Borrar Renglón &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
			<br><br><br><br><br><br><br><br>
		</div>
		<?php
			//SI NO SE HIZO NINGUNA ACCIÓN:
		}else{
		?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_compra_venta_de_micoin.php">
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
			<h3 class='text-center'><span class="fa fa-database"></span> C-V Pemón:</h3>
		</div>
		<div class="card-body px-1 bg-white">
			<div class="table-responsive">
				<table class="table table-bordered table-hover TablaDinamica">
					<thead>
						<tr class="text-center">
							<th class="align-middle w-25"><b title="Apellido, Nombre y Correo del Usuario">Usuario</b></th>
							<th class="align-middle"><b title="Tipo de transacción (Compra o Venta de Moneda Virtual)-Moneda y * Tasa de Cambio">Transacción</b></th>
							<th class="align-middle"><b title="Cantidad de Monedas Virtuales, Monto Bruto, Comisión y Monto Neto implicados en la transacción">Montos</b></th>
							<!-- SE DECICIÓ BLOQUEAR ESTA OPCCIÓN -->
							<th class="align-middle"><b>Sólo Ver</b></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//obteniendo los datos de la tabla:
						$datos=M_compra_venta_de_micoin_R($conexion, '', '', '', '', '', '');
						$i=0;
						while(isset($datos['ID_COMPRA_VENTA'][$i])){
							if($datos['ID_COMPRA_VENTA'][$i]<>""){
								echo "<tr>";
								echo "<td class='text-left'><b>Apellido:</b> " . $datos['APELLIDO'][$i] . "<br><b>Nombre:</b> " . $datos['NOMBRE'][$i] . "<br><b>Cédula/RIF:</b> " . $datos['CEDULA_RIF'][$i] . "<br><b class='text-danger'>" . $datos['CORREO'][$i] . "</b></td>";
								echo "<td class='text-left'><b>Tipo:</b> " . $datos['TIPO_DE_TRANSACCION'][$i] . "<br><b>Moneda:</b> " . $datos['TIPO_DE_MONEDA_REAL'][$i] . "<br><b>Tasa:</b> ";
								if($datos['CANTIDAD_MICOIN'][$i]<=0){
									echo number_format(0, 2,',','.');
								}else{
									echo number_format($datos['MONTO_BRUTO'][$i]/$datos['CANTIDAD_MICOIN'][$i], 2,',','.'); 
								}
								echo "<br>" . $datos['ESTATUS'][$i] . "</td>";
								echo "<td class='text-left'><b>Pm:</b> " . number_format($datos['CANTIDAD_MICOIN'][$i], 2,',','.') . "<br><b>Bruto:</b> " . number_format($datos['MONTO_BRUTO'][$i], 2,',','.') . "<br><b>Comisión:</b> " . number_format($datos['MONTO_COMISION'][$i], 2,',','.') . "<br><b>Neto:</b> " . number_format($datos['MONTO_NETO'][$i], 2,',','.') . "</td>";
								/* SE DECICIÓ BLOQUEAR ESTA OPCCIÓN */
								echo "<td class='text-center h5'><a title='Ver' href='CRUD_compra_venta_de_micoin.php?accion=actualizar&NA_Id=" . $datos['ID_COMPRA_VENTA'][$i] . "' class='btn btn-transparent text-success fa fa-eye d-inline'></a>";
								/*
								echo "&nbsp;&nbsp;";
								echo "<a title='Eliminar' href='CRUD_compra_venta_de_micoin.php?accion=borrar&NA_Id=" . $datos['ID_COMPRA_VENTA'][$i] . "' class='btn btn-transparent text-danger fa fa-trash-o d-inline'></a></td>";
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
			<h3 class='text-center'><span class="fa fa-database"></span> C-V Pemón:</h3>
		</div>
		<div class="card-body px-1 bg-white">
			<div class="table-responsive">
				<table class="table table-bordered table-hover TablaDinamica">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b title="Información de la transacción">Transacción</b></th>
							<th class="align-middle"><b title="Cantidad de Monedas Virtuales, Monto Bruto, Comisión y Monto Neto implicados en la transacción">Montos</b></th>
							<!-- SE DECICIÓ BLOQUEAR ESTA OPCCIÓN -->
							<th class="align-middle"><b><span class="fa fa-arrow-down"></span></b></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//obteniendo los datos de la tabla:
						$datos=M_compra_venta_de_micoin_R($conexion, '', '', '', '', '', '');
						$i=0;
						while(isset($datos['ID_COMPRA_VENTA'][$i])){
							if($datos['ID_COMPRA_VENTA'][$i]<>""){
								$fecha_iii=explode(" ", $datos['FH_SOLICITADO'][$i]);
								echo "<tr>";
								echo "<td class='text-left'><b>" . $fecha_iii[0] . "</b><br><b>Usuario:</b> " . $datos['NOMBRE'][$i] . " " . $datos['APELLIDO'][$i] . "<br><b>" . $datos['TIPO_DE_TRANSACCION'][$i] . " en " . $datos['TIPO_DE_MONEDA_REAL'][$i] . "</b><br><b class='small'>" . $datos['ESTATUS'][$i] . "</b></td>";
								echo "</td>";
								echo "<td class='text-left'><b>Pm:</b> " . number_format($datos['CANTIDAD_MICOIN'][$i], 2,',','.') . "<br><b>Bruto:</b> " . number_format($datos['MONTO_BRUTO'][$i], 2,',','.') . "<br><b>Comisión:</b> " . number_format($datos['MONTO_COMISION'][$i], 2,',','.') . "<br><b>Neto:</b> " . number_format($datos['MONTO_NETO'][$i], 2,',','.') . "</td>";
								/* SE DECICIÓ BLOQUEAR ESTA OPCCIÓN */
								echo "<td class='text-center h5'><a title='Ver' href='CRUD_compra_venta_de_micoin.php?accion=actualizar&NA_Id=" . $datos['ID_COMPRA_VENTA'][$i] . "' class='btn btn-transparent text-success fa fa-eye d-inline'></a>";
								/*
								echo "&nbsp;&nbsp;";
								echo "<a title='Eliminar' href='CRUD_compra_venta_de_micoin.php?accion=borrar&NA_Id=" . $datos['ID_COMPRA_VENTA'][$i] . "' class='btn btn-transparent text-danger fa fa-trash-o d-inline'></a></td>";
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