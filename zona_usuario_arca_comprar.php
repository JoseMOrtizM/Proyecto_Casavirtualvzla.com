<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	//VERIFICANDO OPERACIÓN DE COMPRA
	if(isset($_POST['tipo_de_moneda_real'])){
		$cedula=$datos_usuario_session['CEDULA_RIF'][0];
		$solicitante=M_usuarios_R($conexion, 'CEDULA_RIF', $cedula, '', '', '', '');
		$tipo_de_transaccion='COMPRA';
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
		$fh_pagado=$fh_solicitado;
		$fh_confirmado='';
		$fh_transaccion_abandonada='';
		$estatus='PAGADO';
		//INSERTANDO DATOS
		$verf_insert=M_compra_venta_de_micoin_C($conexion, $solicitante['NOMBRE'][0], $solicitante['APELLIDO'][0], $solicitante['CEDULA_RIF'][0], $solicitante['CORREO'][0], $solicitante['FECHA_NACIMIENTO'][0], $solicitante['EMPRESA'][0], $solicitante['TELEFONO'][0], $solicitante['DIRECCION'][0], $solicitante['BANCO_NOMBRE'][0], $solicitante['BANCO_NUMERO_CUENTA'][0], $solicitante['BANCO_TIPO_CUENTA'][0], $solicitante['BANCO_TELEFONO'][0], $solicitante['BANCO_CEDULA_RIF'][0], $tipo_de_transaccion, $tipo_de_moneda_real, $cantidad_micoin, $id_tasa_de_cambio, $monto_bruto, $porc_comision, $monto_comision, $monto_neto, $fh_solicitado, $cta_banco_desde, $cta_banco_hacia, $numero_transferencia, $fh_pagado, $fh_confirmado, $fh_transaccion_abandonada, $estatus);
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Comprar Pm</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="my-3">
		<?php
			if(isset($verf_insert)){
				if($verf_insert==true){
					echo "<div class='col-md-12 col-lg-10 col-xl-9 mx-auto bg-success'>";
					echo "<h3 class='bg-success text-dark p-2 mb-0 text-center'>Su Compra Ha sido registrada con ÉXITO.</h3>";
					echo "<h6 class='bg-success text-dark p-2 mb-4 text-center'>En las próximas 24 horas estaremos verificando su operación y la cantidad comprada será transferida de su saldo diferido a su saldo disponible.</h6>";
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
			<h3 class="text-center text-warning px-2 pt-2"><b>Comprar Pemón</b></h3>
			<h5 class="text-center text-success px-2"><b>(Saldo: <b class="text-light"><?php echo number_format($datos_saldo_disponible_usuario['SALDO_PEMON'][0], 2,',','.');?> Pm</b>)</b></h5>
			<h6 class="text-center text-light pn-2 small"><b>mín: 10Pm/día - max: 100Pm/día</b></h6>
			<form name="formulario" id="formulario" action="zona_usuario_arca_comprar.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="fh_solicitado" id="fh_solicitado" value="<?php echo date("Y-m-d h:m:s"); ?>">
				<div class="input-group mb-2 d-none">
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
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Tasa:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="id_tasa" id="id_tasa" required autocomplete="off" title="Indique la tasa de cambio Compra/Venta de la transacción (Fecha de tasa Vigente <<Y-m-d>> (Tasa para la Compra y Tasa para la Venta))">
					<?php
						$datos_paridad_y_tarifas= M_paridad_cambiaria_R_ultima($conexion);
						$fecha_i=explode(" ",$datos_paridad_y_tarifas['FH_REGISTRO'][0]);
						echo "<option value='" . $datos_paridad_y_tarifas['ID_TASA_DE_CAMBIO'][0] . "'>" . $datos_paridad_y_tarifas['TIPO_DE_MONEDA_REAL'][0] . "/Pm: " .  number_format($datos_paridad_y_tarifas['TIPO_POR_MICOIN_COMPRA'][0], 2,',','.') . " (" . number_format($datos_paridad_y_tarifas['PORC_COMISION_POR_COMPRA'][0], 2,',','.') . "%)</option>";
					?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Bs. Transferidos:</span>
					</div>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0 ajax_y_boton_comprar_1" name="monto_neto" id="monto_neto" title="Indique la cantidad de bolívares involucrados en la compra (se muestran el mínimo - máximo permitido)" required autocomplete="off" placeholder="<?php
						$pemones_comprados_hoy=M_compra_venta_de_micoin_R($conexion, 'CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'TIPO_DE_TRANSACCION', 'COMPRA', '', '');
						$cta_reng=0;
						$suma_pm_comprado_hoy=0;
						while(isset($pemones_comprados_hoy['ID_COMPRA_VENTA'][$cta_reng])){
							$fecha_iii[$cta_reng]=explode(" ", $pemones_comprados_hoy['FH_SOLICITADO'][$cta_reng]);
							if($fecha_iii[$cta_reng][0]==date("Y-m-d")){
								$suma_pm_comprado_hoy= $suma_pm_comprado_hoy+ $pemones_comprados_hoy['CANTIDAD_MICOIN'][$cta_reng];
							}
							$cta_reng++;
						}
						//// OJO: CANTIDAD MÁXIMA PUESTA A MANO ES DE 100PM DIARIOS ////
						$monto_maximo_pm_i=(100-$suma_pm_comprado_hoy)<0?0:(100-$suma_pm_comprado_hoy);
						$monto_maximo=
						$monto_maximo_pm_i* $datos_paridad_y_tarifas['TIPO_POR_MICOIN_COMPRA'][0] +($monto_maximo_pm_i* $datos_paridad_y_tarifas['TIPO_POR_MICOIN_COMPRA'][0])* $datos_paridad_y_tarifas['PORC_COMISION_POR_COMPRA'][0]/100;
						if($monto_maximo>=10){
							$monto_minimo=10*$datos_paridad_y_tarifas['TIPO_POR_MICOIN_COMPRA'][0] +(10*$datos_paridad_y_tarifas['TIPO_POR_MICOIN_COMPRA'][0]* $datos_paridad_y_tarifas['PORC_COMISION_POR_COMPRA'][0]/100);
						}else{
							$monto_minimo=$monto_maximo;
						}
						echo number_format($monto_minimo, 2,',','.') . " - " . number_format($monto_maximo, 2,',','.');
					?>" step="0.01" min="0" max="<?php echo $monto_maximo; ?>">
					<input type="hidden" id="cant_min" value="<?php echo $monto_minimo; ?>">
					<input type="hidden" id="cant_max" value="<?php echo $monto_maximo; ?>">
				</div>
				<div id="caja_calculos"></div>
				<h5 class="text-center text-warning">Datos de la Tranferencia electrónica</h5>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Banco Origen:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0 ajax_y_boton_comprar_2" name="cta_banco_desde" id="cta_banco_desde" required autocomplete="off" title="Introduzca el número de cuenta origen de la transferencia">
						<option></option>
						<?php
							$bancos_i=M_nombres_de_bancos();
							$cta_i=0;
							while(isset($bancos_i[$cta_i])){
								echo "<option>" . $bancos_i[$cta_i] . "</option>";
								$cta_i++;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Cta Destino:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0 ajax_y_boton_comprar_2" name="cta_banco_hacia" id="cta_banco_hacia" required autocomplete="off" title="Indique el número de cuenta destino de la transferencia">
						<option></option>
						<?php
							$cuentas_arca=M_datos_bancos_tranferencia();
							$e=0;
							while(isset($cuentas_arca[$e]['NOMBRE'])){
								echo "<option value='" . $cuentas_arca[$e]['NUMERO_CUENTA'] . "'>" . $cuentas_arca[$e]['NOMBRE'] . ", N°: " . $cuentas_arca[$e]['NUMERO_CUENTA'] . "</option>";
								$e=$e+1;
							}
						?>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">N° Confirmación:</span>
					</div>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0 ajax_y_boton_comprar_2" name="numero_transferencia" id="numero_transferencia" placeholder="Número de Confirmación" required autocomplete="off" title="Introduzca el número de confirmación de la transferencia">
				</div>
				<div class="m-auto">
					<input type="button" value="Comprar &raquo;" id="comprar" disabled class="btn btn-warning mb-2" onclick="pregunta()">
					<script language="JavaScript">
						function pregunta(){
							if(confirm('¿Seguro que deseas comprar ' + $("#cantidad_micoin_imprimir").val() + ' Pemones?')){
								document.formulario.submit();
							}
						}
					</script>				
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$(".ajax_y_boton_comprar_1").on('change', function(){
							var monto_neto=$("#monto_neto").val();
							var id_tasa=$("#id_tasa").val();
							var cant_min=$("#cant_min").val();
							var cant_max=$("#cant_max").val();
							$.ajax("PHP_MODELO/S_calcula_tasa_transaccion.php",{data:{tipo_de_transaccion:'COMPRA', monto_neto:monto_neto, id_tasa:id_tasa}, type:'post'}).done(function(respuesta){
								$("#caja_calculos").hide(50);
								$("#caja_calculos").html(respuesta);
								$("#caja_calculos").fadeIn(50);
								if(parseFloat(monto_neto)>parseFloat(cant_max) || parseFloat(monto_neto)<=parseFloat(cant_min) || $("#monto_neto").val()=="" || $("#numero_transferencia").val()=="" || $("#cta_banco_hacia").val()=="" || $("#cta_banco_desde").val()==""){
									$("#comprar").attr("disabled", true);
									if(parseFloat(monto_neto)>parseFloat(cant_max)){
										alert("IMPORTANTE: Los Bs. Transferidos superan el máximo permitido");
									}
									if(parseFloat(monto_neto)<=parseFloat(cant_min)){
										alert("IMPORTANTE: Los Bs. Transferidos no deben ser menores de la cantidad mínima establecida...");
									}
								}else{
									$("#comprar").attr("disabled", false);
								}
							});
						});
						$(".ajax_y_boton_comprar_2").on('change', function(){
							var monto_neto=$("#monto_neto").val();
							var id_tasa=$("#id_tasa").val();
							var cant_min=$("#cant_min").val();
							var cant_max=$("#cant_max").val();
							if(parseFloat(monto_neto)>parseFloat(cant_max) || parseFloat(monto_neto)<=parseFloat(cant_min) || $("#monto_neto").val()=="" || $("#numero_transferencia").val()=="" || $("#cta_banco_hacia").val()=="" || $("#cta_banco_desde").val()==""){
								$("#comprar").attr("disabled", true);
								if(parseFloat(monto_neto)>parseFloat(cant_max)){
									alert("IMPORTANTE: Los Bs. Transferidos superan el máximo permitido");
								}
								if(parseFloat(monto_neto)<=0){
									alert("IMPORTANTE: Los Bs. Transferidos no deben ser menores de la cantidad mínima establecida...");
								}
							}else{
								$("#comprar").attr("disabled", false);
							}
						});
					});
				</script>
			</form>
			<br>
			<!-- NUESTRAS CUENTAS -->
			<div class="row mt-4 bg-light">
				<?php
					$datos_aliados=M_usuarios_R_portada_aliados($conexion);
				?>
				<div class="col-12 px-0">
					<h3 class="bg-dark text-warning text-center py-1 mb-0"><b>Cuentas Disponibles</b></h3>
					<div class="pt-3">
						<ul class='row'>
						<?php
							$datos_bancos=M_datos_bancos_tranferencia();
							$i=0;
							while(isset($datos_bancos[$i]['NOMBRE'])){
								echo "<li class='col-md-6'>";
								echo "<a href='" . $datos_bancos[$i]['LINK'] . "'' target='_blank'>" . $datos_bancos[$i]['NOMBRE'] . "</a>";
								echo 	"<ul>";
								echo 		"<li><b>" . $datos_bancos[$i]['USUARIO'] . "</b></li>";
								echo 		"<li>C.I.: " . $datos_bancos[$i]['CEDULA'] . "</li>";
								echo 		"<li>" . $datos_bancos[$i]['TIPO_CUENTA'] . "</li>";
								echo 		"<li>N°: " . $datos_bancos[$i]['NUMERO_CUENTA'] . "</li>";
								echo 		"<li>Telf: " . $datos_bancos[$i]['TELEFONO'] . "</li>";
								echo 		"<li><e class='text-danger'>" . $datos_bancos[$i]['CORREO'] . "</e></li>";
								echo 		"<li><i class='text-success'>" . $datos_bancos[$i]['OBSERVACION'] . "</i></li>";
								echo 	"</ul>";
								echo "</li>";
								$i++;
							}
						?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<br><br><br><br><br><br><br><br><br><br><br>
		<br><br><br><br><br><br><br><br><br><br><br>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>