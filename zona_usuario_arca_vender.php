<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	//VERIFICANDO OPERACIÓN DE COMPRA
	if(isset($_POST['tipo_de_moneda_real'])){
		$cedula=$datos_usuario_session['CEDULA_RIF'][0];
		$solicitante=M_usuarios_R($conexion, 'CEDULA_RIF', $cedula, '', '', '', '');
		$tipo_de_transaccion='VENTA';
		$tipo_de_moneda_real=mysqli_real_escape_string($conexion, $_POST['tipo_de_moneda_real']);
		$cantidad_micoin=mysqli_real_escape_string($conexion, $_POST['cantidad_micoin']);
		$id_tasa_de_cambio=mysqli_real_escape_string($conexion, $_POST['id_tasa']);
		$monto_bruto=mysqli_real_escape_string($conexion, $_POST['monto_bruto']);
		$porc_comision=mysqli_real_escape_string($conexion, $_POST['porc_comision']);
		$monto_comision=mysqli_real_escape_string($conexion, $_POST['monto_comision']);
		$monto_neto=mysqli_real_escape_string($conexion, $_POST['monto_neto']);
		$fh_solicitado=mysqli_real_escape_string($conexion, $_POST['fh_solicitado']);
		$cta_banco_desde='';
		$cta_banco_hacia=$datos_usuario_session['BANCO_NUMERO_CUENTA'][0];
		$numero_transferencia=$fh_solicitado;
		$fh_pagado='';
		$fh_confirmado='';
		$fh_transaccion_abandonada='';
		$estatus='SOLICITADO';
		//INSERTANDO DATOS
		$verf_insert=M_compra_venta_de_micoin_C($conexion, $solicitante['NOMBRE'][0], $solicitante['APELLIDO'][0], $solicitante['CEDULA_RIF'][0], $solicitante['CORREO'][0], $solicitante['FECHA_NACIMIENTO'][0], $solicitante['EMPRESA'][0], $solicitante['TELEFONO'][0], $solicitante['DIRECCION'][0], $solicitante['BANCO_NOMBRE'][0], $solicitante['BANCO_NUMERO_CUENTA'][0], $solicitante['BANCO_TIPO_CUENTA'][0], $solicitante['BANCO_TELEFONO'][0], $solicitante['BANCO_CEDULA_RIF'][0], $tipo_de_transaccion, $tipo_de_moneda_real, $cantidad_micoin, $id_tasa_de_cambio, $monto_bruto, $porc_comision, $monto_comision, $monto_neto, $fh_solicitado, $cta_banco_desde, $cta_banco_hacia, $numero_transferencia, $fh_pagado, $fh_confirmado, $fh_transaccion_abandonada, $estatus);
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Vender Pm</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="my-3">
		<?php
			if(isset($verf_insert)){
				if($verf_insert==true){
					echo "<div class='col-md-12 col-lg-10 col-xl-9 mx-auto bg-success'>";
					echo "<h3 class='bg-success text-dark p-2 mb-4 text-center'>Su Venta Ha sido registrada con ÉXITO.</h3>";
					echo "<h6 class='bg-success text-dark p-2 mb-4 text-center'>El monto de esta transacción a sido transferido a su saldo Bloqueado y permanecerá registrado allí por los próximos 2 días (días hábiles) mientras realizamos la transferencia correspondiente a la cuenta bancaria registrada en su perfil de usuario.</h6>";
					echo "</div>";
				}else{
					echo "<div class='col-md-12 col-lg-10 col-xl-9 mx-auto bg-danger'>";
					echo "<h3 class='bg-danger text-dark p-2 mb-4 text-center'>ERROR DUPLICADO:<br>La Operación que está intentando realizar ya está registrada.</h3>";
					echo "</div>";
				}
			}
		?>
		<?php
			$datos_saldo_disponible_usuario= M_saldo_pm_disponible_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
		?>
		<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
			<h3 class="text-center text-warning px-2 pt-2"><b>Vender Pemón</b></h3>
			<h5 class="text-center text-success px-2"><b>(Saldo: <b class="text-light"><?php echo number_format($datos_saldo_disponible_usuario['SALDO_PEMON'][0], 2,',','.');?> Pm</b>)</b></h5>
			<h6 class="text-center text-light pn-2 small"><b>mínino 10Pm</b></h6>
			<form name="formulario" id="formulario" action="zona_usuario_arca_vender.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="fh_solicitado" id="fh_solicitado" value="<?php echo date("Y-m-d h:m:s"); ?>">
				<input type="hidden" id="saldo_i" value="<?php echo $datos_saldo_disponible_usuario['SALDO_PEMON'][0]; ?>">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cantidad Pm:</span>
					</div>
					<?php 
						if($datos_saldo_disponible_usuario['SALDO_PEMON'][0]<=10){
							$retiro_minimo=$datos_saldo_disponible_usuario['SALDO_PEMON'][0];
						}else{
							$retiro_minimo=10;
						}
					?>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cantidad_micoin" id="cantidad_micoin" placeholder="Mín <?php echo number_format($retiro_minimo, 2,',','.'); ?> - Máx <?php echo number_format($datos_saldo_disponible_usuario['SALDO_PEMON'][0], 2,',','.'); ?>" required autocomplete="off" title="Introduzca la cantidad de monedas virtuales correspondiente a la transacción" step="0.01" min="<?php echo $retiro_minimo; ?>" max="<?php echo $datos_saldo_disponible_usuario['SALDO_PEMON'][0]; ?>">
				</div>
				<input type="hidden" id="retiro_minimo" value="<?php echo $retiro_minimo; ?>">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Tasa:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="id_tasa" id="id_tasa" required autocomplete="off" title="Indique la tasa de cambio Compra/Venta de la transacción (Fecha de tasa Vigente <<Y-m-d>> (Tasa para la Compra y Tasa para la Venta))">
					<?php
						$datos_paridad_y_tarifas=M_paridad_cambiaria_R_ultima($conexion);
						$fecha_i=explode(" ",$datos_paridad_y_tarifas['FH_REGISTRO'][0]);
						echo "<option value='" . $datos_paridad_y_tarifas['ID_TASA_DE_CAMBIO'][0] . "'>" . $datos_paridad_y_tarifas['TIPO_DE_MONEDA_REAL'][0] . "/Pm: " .  $datos_paridad_y_tarifas['TIPO_POR_MICOIN_VENTA'][0] . " (" . $datos_paridad_y_tarifas['PORC_COMISION_POR_VENTA'][0] . "%)</option>";
					?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Moneda:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_de_moneda_real" id="tipo_de_moneda_real" required autocomplete="off" title="Indique el Tipo de moneda a canjear">
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
				<div id="caja_calculos">
					<div class='input-group mb-2'>
						<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0 bg-dark border border-dark' name='monto_bruto_imprimir'>
					</div>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#cantidad_micoin").on('change', function(){
							if($("#cantidad_micoin").val()!='' && $("#id_tasa").val()!=''){
								var cantidad=$("#cantidad_micoin").val();
								var id_tasa=$("#id_tasa").val();
								var retiro_minimo=$("#retiro_minimo").val();
								var saldo_i=$("#saldo_i").val();
								$.ajax("PHP_MODELO/S_calcula_tasa_transaccion.php",{data:{tipo_de_transaccion:'VENTA', cantidad:cantidad, id_tasa:id_tasa}, type:'post'}).done(function(respuesta){
									$("#caja_calculos").hide(500);
									$("#caja_calculos").html(respuesta);
									$("#caja_calculos").fadeIn(500);
									if(parseFloat(saldo_i)>=parseFloat(cantidad) && parseFloat(cantidad)>=parseFloat(retiro_minimo)){
										$("#vender").attr("disabled", false);
									}else{
										$("#vender").attr("disabled", true);
									}
								});
							}else{
								$("#caja_calculos").hide(500);
								$("#caja_calculos").html("");
								$("#caja_calculos").fadeIn(500);
								$("#vender").attr("disabled", true);
							}
						});
						$("#id_tasa").on('change', function(){
							if($("#cantidad_micoin").val()!='' && $("#id_tasa").val()!=''){
								var cantidad=$("#cantidad_micoin").val();
								var id_tasa=$("#id_tasa").val();
								var retiro_minimo=$("#retiro_minimo").val();
								var saldo_i=$("#saldo_i").val();
								$.ajax("PHP_MODELO/S_calcula_tasa_transaccion.php",{data:{tipo_de_transaccion:'VENTA', cantidad:cantidad, id_tasa:id_tasa}, type:'post'}).done(function(respuesta){
									$("#caja_calculos").hide(500);
									$("#caja_calculos").html(respuesta);
									$("#caja_calculos").fadeIn(500);
									if(parseFloat(saldo_i)>=parseFloat(cantidad) && parseFloat(cantidad)>=parseFloat(retiro_minimo)){
										$("#vender").attr("disabled", false);
									}else{
										$("#vender").attr("disabled", true);
									}
								});
							}else{
								$("#caja_calculos").hide(500);
								$("#caja_calculos").html("");
								$("#caja_calculos").fadeIn(500);
								$("#vender").attr("disabled", true);
							}
						});
					});
				</script>
				<div class="m-auto">
					<input type="button" value="Vender &raquo;" id="vender" disabled class="btn btn-warning mb-2" onclick="pregunta()">
				</div>
				<script language="JavaScript">
					function pregunta(){
						var verf=confirm('¿Seguro que deseas comprar ' + $("#cantidad_micoin").val() + ' Pemones?')
						if(verf==true){
							document.formulario.submit();
						}
					}
				</script>
			</form>
		</div>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		<br><br><br><br><br><br><br><br><br><br><br><br>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>