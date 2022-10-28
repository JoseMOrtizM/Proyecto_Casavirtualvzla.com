<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
if(isset($_POST['FORM'])){
	if($_POST['FORM']=='APROBAR'){
		$id_c_v=mysqli_real_escape_string($conexion,$_POST['id_c_v']);
		$bs_por_dollar_compra=mysqli_real_escape_string($conexion, $_POST['bs_por_dollar_compra']);
		$datos_transaccion=M_compra_venta_de_micoin_R($conexion, 'ID_COMPRA_VENTA', $id_c_v, '', '', '', '');
		if($datos_transaccion['TIPO_DE_TRANSACCION'][0]=='VENTA'){
			$numero_transferencia=mysqli_real_escape_string($conexion, $_POST['numero_transferencia']);
		}else{
			$numero_transferencia=$datos_transaccion['NUMERO_TRANSFERENCIA'][0];
		}
		//ACTUALIZANDO DATOS
		$fecha_del_registro=mysqli_real_escape_string($conexion,$_POST['fecha_del_registro']);
		$verf_aprobar=M_compra_venta_de_micoin_U_id($conexion, $id_c_v, $datos_transaccion['NOMBRE'][0], $datos_transaccion['APELLIDO'][0], $datos_transaccion['CEDULA_RIF'][0], $datos_transaccion['CORREO'][0], $datos_transaccion['FECHA_NACIMIENTO'][0], $datos_transaccion['EMPRESA'][0], $datos_transaccion['TELEFONO'][0], $datos_transaccion['DIRECCION'][0], $datos_transaccion['BANCO_NOMBRE'][0], $datos_transaccion['BANCO_NUMERO_CUENTA'][0], $datos_transaccion['BANCO_TIPO_CUENTA'][0], $datos_transaccion['BANCO_TELEFONO'][0], $datos_transaccion['BANCO_CEDULA_RIF'][0], $datos_transaccion['TIPO_DE_TRANSACCION'][0], $datos_transaccion['TIPO_DE_MONEDA_REAL'][0], $datos_transaccion['CANTIDAD_MICOIN'][0], $datos_transaccion['ID_TASA_DE_CAMBIO'][0], $datos_transaccion['MONTO_BRUTO'][0], $datos_transaccion['PORC_COMISION'][0], $datos_transaccion['MONTO_COMISION'][0], $datos_transaccion['MONTO_NETO'][0], $datos_transaccion['FH_SOLICITADO'][0], $datos_transaccion['CTA_BANCO_DESDE'][0], $datos_transaccion['CTA_BANCO_HACIA'][0], $numero_transferencia, $datos_transaccion['FH_PAGADO'][0], $fecha_del_registro, $datos_transaccion['FH_TRANSACCION_ABANDONADA'][0], 'CONFIRMADO');
		$verf_adm_y_pc=false;
		if($verf_aprobar){
			//insertando datos en MC_BALANCE ADMINISTRATIVO Y EN MC_PARIDAD_CAMBIARIA
			$verf_adm_y_pc=M_balance_administrativo_lcv_PRECALCULOS($conexion, $fecha_del_registro, $datos_transaccion['TIPO_DE_TRANSACCION'][0] . " PM", "", "", $bs_por_dollar_compra, "", $id_c_v);
		}
		if($verf_adm_y_pc){
			header("location:zona_adm_aprobar_pemon.php?accion_redir=aprobada");
		}
	}else if($_POST['FORM']=='RECHAZAR'){
		$id_c_v=mysqli_real_escape_string($conexion,$_POST['id_c_v']);
		$datos_transaccion=M_compra_venta_de_micoin_R($conexion, 'ID_COMPRA_VENTA', $id_c_v, '', '', '', '');
		//ACTUALIZANDO DATOS
		$verf_rechazar=M_compra_venta_de_micoin_U_id($conexion, $id_c_v, $datos_transaccion['NOMBRE'][0], $datos_transaccion['APELLIDO'][0], $datos_transaccion['CEDULA_RIF'][0], $datos_transaccion['CORREO'][0], $datos_transaccion['FECHA_NACIMIENTO'][0], $datos_transaccion['EMPRESA'][0], $datos_transaccion['TELEFONO'][0], $datos_transaccion['DIRECCION'][0], $datos_transaccion['BANCO_NOMBRE'][0], $datos_transaccion['BANCO_NUMERO_CUENTA'][0], $datos_transaccion['BANCO_TIPO_CUENTA'][0], $datos_transaccion['BANCO_TELEFONO'][0], $datos_transaccion['BANCO_CEDULA_RIF'][0], $datos_transaccion['TIPO_DE_TRANSACCION'][0], $datos_transaccion['TIPO_DE_MONEDA_REAL'][0], $datos_transaccion['CANTIDAD_MICOIN'][0], $datos_transaccion['ID_TASA_DE_CAMBIO'][0], $datos_transaccion['MONTO_BRUTO'][0], $datos_transaccion['PORC_COMISION'][0], $datos_transaccion['MONTO_COMISION'][0], $datos_transaccion['MONTO_NETO'][0], $datos_transaccion['FH_SOLICITADO'][0], $datos_transaccion['CTA_BANCO_DESDE'][0], $datos_transaccion['CTA_BANCO_HACIA'][0], $datos_transaccion['NUMERO_TRANSFERENCIA'][0], $datos_transaccion['FH_PAGADO'][0], $datos_transaccion['FH_CONFIRMADO'][0], date("Y-m-d h:m:s"), 'RECHAZADO');
		if($verf_rechazar){
			header("location:zona_adm_aprobar_pemon.php?accion_redir=rechazada");
		}
	}
}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>Aprobar Transacciones</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid mt-2 mb-5 bg-secondary px-0">
		<br>
	<?php
	//VERIFICANDO Si SE MARCO ALGUNA OPCION EN LA TABLA PRINCIPAL DEL CRUD
	if(isset($_GET["accion"])){
			//SI SE QUIERE INSERTAR UN NUEVO RENGLON ENTONCES:
		if($_GET["accion"]=='aprobar'){
		?>
			<br>
			<div class="col-12 col-md-9 col-lg-8 col-xl-7 mx-auto px-0">
				<form action="zona_adm_aprobar_pemon.php" method="post" class="text-center bg-dark p-2 rounded">
					<h4 class="text-center text-light pb-3" title="Aprobar Operación">¿Seguro que desea Aprobar esta operación? (ID <?php echo $_GET['NA_Id']; ?>)</h4>
					<div class="m-2 bg-light text-dark text-left p-2">
					<?php
						$datos_compra_venta=M_compra_venta_de_micoin_R($conexion, 'ID_COMPRA_VENTA', $_GET['NA_Id'], '', '', '', '');
					?>
					<?php
						echo "
							<b>Usuario:</b> " . $datos_compra_venta['NOMBRE'][0] . " " . $datos_compra_venta['APELLIDO'][0] . "<br><b>CI/RIF:</b> " . $datos_compra_venta['CEDULA_RIF'][0] . "<br><b>" . $datos_compra_venta['TIPO_DE_TRANSACCION'][0] . "</b><br><b>" . $datos_compra_venta['TIPO_DE_MONEDA_REAL'][0] . ":</b> " . number_format($datos_compra_venta['MONTO_NETO'][0], 2,',','.') . "<br><b>Pm:</b> " . number_format($datos_compra_venta['CANTIDAD_MICOIN'][0], 2,',','.') . "<br><b>Cta:</b> " . $datos_compra_venta['CTA_BANCO_HACIA'][0] . "<br><b>N°:</b> " . $datos_compra_venta['NUMERO_TRANSFERENCIA'][0];
					?>
					</div>
					<input type="hidden" name="FORM" id="FORM" value="APROBAR">
					<input type="hidden" name="fecha_del_registro" id="fecha_del_registro" value="<?php echo date("Y-m-d h:m:s"); ?>">
					<input type="hidden" name="id_c_v" id="id_c_v" value="<?php echo $_GET["NA_Id"]; ?>">
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Bs/$ (Compra):</span>
						</div>
						<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="bs_por_dollar_compra" id="bs_por_dollar_compra" required title="Introduzca Tasa de cambio Bs/$">
							<?php
								$datos_ultimo_balance_i=M_balance_administrativo_lcv_R_ultimo($conexion);
							?>
							<option value="<?php echo $datos_ultimo_balance_i['TC_BS_DOLLAR'][0]; ?>"><?php echo number_format($datos_ultimo_balance_i['TC_BS_DOLLAR'][0], 2,',','.'); ?> Bs/$</option>
						</select>
					</div>
					<?php
						if($datos_compra_venta['TIPO_DE_TRANSACCION'][0]=='VENTA'){
					?>
						<div class="input-group mb-2">
							<div class="col-md-3 p-0 m-0">
								<span class="input-group-text rounded-0 w-100">N° Confirmación:</span>
							</div>
							<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="numero_transferencia" id="numero_transferencia" placeholder="Número de Transferencia" required autocomplete="off" title="Introduzca el Número de Transferencia" step="any">
						</div>
					<?php
						}
					?>
					<div class="m-auto">
						<a href="zona_adm_aprobar_pemon.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Aprobar Operación &raquo;" class="btn btn-warning mb-2">
					</div>
				</form>
				<br><br><br><br><br><br><br>
			</div>
		<?php
			//SI SE QUIERE BORRAR UN RENGLON ENTONCES:
		}else if($_GET["accion"]=='rechazar'){
		?>
			<br>
			<div class="col-12 col-lg-9 mx-auto px-0">
				<form action="zona_adm_aprobar_pemon.php" method="post" class="text-center bg-dark p-2 rounded">
					<h3 class="text-center text-light pb-3" title="Rechazar Operación">¿Seguro que desea rechazar esta operación? (ID <?php echo $_GET['NA_Id']; ?>)</h3>
					<div class="m-2 bg-light text-dark text-left p-2">
					<?php
						$datos_compra_venta=M_compra_venta_de_micoin_R($conexion, 'ID_COMPRA_VENTA', $_GET['NA_Id'], '', '', '', '');
					?>
					<?php
						echo "
							<b>Usuario:</b> " . $datos_compra_venta['NOMBRE'][0] . " " . $datos_compra_venta['APELLIDO'][0] . "<br><b>CI/RIF:</b> " . $datos_compra_venta['CEDULA_RIF'][0] . "<br><b>" . $datos_compra_venta['TIPO_DE_TRANSACCION'][0] . "</b>";
					?>	
					</div>
					<input type="hidden" name="FORM" id="FORM" value="RECHAZAR">
					<input type="hidden" name="id_c_v" id="id_c_v" value="<?php echo $_GET["NA_Id"]; ?>">
					<div class="m-auto">
						<a href="zona_adm_aprobar_pemon.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Rechazar Operación &raquo;" class="btn btn-warning mb-2">
					</div>
				</form>
				<br><br><br><br><br><br><br><br>
			</div>
		<?php
			//SI NO SE HIZO NINGUNA ACCIÓN:
		}else{
		?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=zona_adm_aprobar_pemon.php">
	<?php
	//CIERRE DE LA ETIQUETA PARA EMBUTIR HTML EN PHP
		}
	}else{
	?>
	<?php
	if(isset($verf_aprobar)){
		if($verf_aprobar==true){
			echo "<h3 class='text-center text-dark bg-success my-2 py-2'>La transacción fue <b>APROBADA</b></h3>";
		}else{
			echo "<h3 class='text-center text-dark bg-danger my-2 py-2'>No se pudo realizar la operación, por favor intente más tarde</h3>";
		}
	}
	?>
	<?php
	if(isset($verf_rechazar)){
		if($verf_rechazar==true){
			echo "<h3 class='text-center text-dark bg-warning my-2 py-2'>La transacción fue <b>RECHAZADA</b></h3>";
		}else{
			echo "<h3 class='text-center text-dark bg-danger my-2 py-2'>No se pudo realizar la operación, por favor intente más tarde</h3>";
		}
	}
	?>
	<?php
	if(isset($_GET['accion_redir'])){
		if($_GET['accion_redir']=='aprobada'){
			echo "<h3 class='text-center text-dark bg-success my-2 py-2'>La transacción fue <b>APROBADA</b></h3>";
		}
	}
	if(isset($_GET['accion_redir'])){
		if($_GET['accion_redir']=='rechazada'){
			echo "<h3 class='text-center text-dark bg-warning my-2 py-2'>La transacción fue <b>RECHAZADA</b></h3>";
		}
	}
	?>
	<div class="card mb-3 bg-dark rounded-0">
		<div class="card-header text-center text-warning">
			<h6 class='text-dark text-left bg-light my-0 p-1'>Aprueba Primero las <b>Compras</b> y luego las <b>Ventas</b>.</h6>
			<h6 class='text-dark text-left bg-light my-0 p-1'>Si requiere vender $, aparecerá un <b>mensaje</b> en la tabla <b>Ventas</b>.</h6>
			<h6 class='text-dark text-left bg-light my-0 p-1 text-danger'>REALIZA EL <b>DEPÓSITO ANTES</b> DE APROBAR LA <b>VENTA</b>.</h6>
			<h3 class='text-center mt-2'>1° Compras de <b>Pm</b>:</h3>
		</div>
		<div class="card-body px-1 bg-white">
			<div class="table-responsive">
				<table class="table table-bordered table-hover TablaDinamica bg-light">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b title="Información del usuario y datos de la Transacción">Transacción</b></th>
							<th class="align-middle"><b class="fa fa-arrow-down"></b></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//obteniendo los datos de la tabla:
						$datos=M_compra_venta_de_micoin_R($conexion, 'ESTATUS', 'PAGADO', '', '', '', '');
						$i=0;
						while(isset($datos['ID_COMPRA_VENTA'][$i])){
							if($datos['ID_COMPRA_VENTA'][$i]<>""){
								echo "<tr>";
								echo "<td class='text-left'><b>Nombre:</b> " . $datos['NOMBRE'][$i] . " " . $datos['APELLIDO'][$i] . "<br><b>CI/RIF:</b> " . $datos['CEDULA_RIF'][$i] . "<br><e class='small'>" . $datos['TIPO_DE_TRANSACCION'][$i] . "<br><b>" . $datos['TIPO_DE_MONEDA_REAL'][$i] . ":</b> " . number_format($datos['MONTO_NETO'][$i], 2,',','.') . "<br><b>Pm:</b> " . number_format($datos['CANTIDAD_MICOIN'][$i], 2,',','.') . "<br><b>Cta:</b> " . $datos['CTA_BANCO_HACIA'][$i] . "<br><b>N°:</b> " . $datos['NUMERO_TRANSFERENCIA'][$i] . "</e><br>";
								$fecha_ii=explode(" ",$datos['FH_PAGADO'][$i]);
								echo "(" . $fecha_ii[0] . ")<br>";
								$fecha_registro=date($datos['FH_PAGADO'][$i]);
								$dia_semana=date("w",strtotime($fecha_registro));//0 para domingo hasta 6 para sabado
								$fecha_fin = new DateTime($fecha_registro);
								if($dia_semana==4 or $dia_semana==5 or $dia_semana==6){
									$imprimir=date("Y-m-d h:m:s",strtotime($fecha_registro."+ 3 days"));
								}else if($dia_semana==0){
									$imprimir=date("Y-m-d h:m:s",strtotime($fecha_registro."+ 2 days"));
								}else{
									$imprimir=date("Y-m-d h:m:s",strtotime($fecha_registro."+ 1 days"));
								}
								echo "<div class='pt-2' id='cronometro_1_" . $i . "'></div>";
								echo "
									<script type='text/javascript'>
										$('#cronometro_1_" . $i . "').timeTo(new Date('" . $imprimir . "'));
									</script>
								";
								
								echo "</td>";
								echo "<td class='text-center h4'><a title='Aprobar' href='zona_adm_aprobar_pemon.php?accion=aprobar&NA_Id=" . $datos['ID_COMPRA_VENTA'][$i] . "' class='btn btn-transparent text-success fa fa-check-square-o d-inline'></a>";
								echo "<br>";
								echo "<a title='Rechazar' href='zona_adm_aprobar_pemon.php?accion=rechazar&NA_Id=" . $datos['ID_COMPRA_VENTA'][$i] . "' class='btn btn-transparent text-danger fa fa-window-close-o d-inline'></a>";
								$verf_rep=M_compra_venta_de_micoin_R($conexion, 'NUMERO_TRANSFERENCIA', $datos['NUMERO_TRANSFERENCIA'][$i], 'ESTATUS', 'CONFIRMADO', '', '');
								if(isset($verf_rep['NUMERO_TRANSFERENCIA'][0])){
									if($verf_rep['NUMERO_TRANSFERENCIA'][0]<>""){
										echo "<br><b title='Este Número de Transferencia ya se encuentra CONFIRMADO en el sistema' class='text-danger pt-1'>Rep.</b>";
									}
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
	<br>
	<div class="card mb-3 bg-dark rounded-0">
		<div class="card-header text-center text-warning">
			<?php
				$datos_ultimo_balance=M_balance_administrativo_lcv_R_ultimo($conexion);
				$datos_ventas_solicitadas=M_compra_venta_de_micoin_R($conexion, 'ESTATUS', 'SOLICITADO', '', '', '', '');
				$ventas_acum=0;
				$i=0;
				while(isset($datos_ventas_solicitadas['ID_COMPRA_VENTA'][$i])){
					if($datos_ventas_solicitadas['ID_COMPRA_VENTA'][$i]<>""){
						$ventas_acum=$ventas_acum+$datos_ventas_solicitadas['MONTO_NETO'][$i];
					}
					$i=$i+1;
				}
				$diferencia_bs=$datos_ultimo_balance['RA_RES_MON_BS_PUROS'][0] - $ventas_acum;
				$diferencia_dollares=$diferencia_bs/$datos_ultimo_balance['TC_BS_DOLLAR'][0];
				if($diferencia_bs<0){
					echo "<h3 class='text-dark text-left bg-danger my-0 p-1 text-center'>Hay que vender " . number_format($diferencia_dollares, 2,',','.') . " dollares que equivales a " . number_format($diferencia_bs, 2,',','.') . " Bs</h3>";
				}else{
					echo "<h3 class='text-dark text-left bg-primary my-0 p-1 text-center'>No hace falta vender</h3>";
				}
			?>
			<h3 class='text-center'>2° Ventas de <b>Pm</b>:</h3>
		</div>
		<div class="card-body px-1 bg-white">
			<div class="table-responsive">
				<table class="table table-bordered table-hover TablaDinamica bg-light">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b title="Información del usuario y datos de la Transacción">Transacción</b></th>
							<th class="align-middle"><b class="fa fa-arrow-down"></b></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//obteniendo los datos de la tabla:
						unset($datos);
						$datos=M_compra_venta_de_micoin_R($conexion, 'ESTATUS', 'SOLICITADO', '', '', '', '');
						$i=0;
						while(isset($datos['ID_COMPRA_VENTA'][$i])){
							if($datos['ID_COMPRA_VENTA'][$i]<>""){
								echo "<tr>";
								echo "<td class='text-left'><b>Nombre:</b> " . $datos['NOMBRE'][$i] . " " . $datos['APELLIDO'][$i] . "<br><b>CI/RIF:</b> " . $datos['CEDULA_RIF'][$i] . "</br><e class='small'>" . $datos['TIPO_DE_TRANSACCION'][$i] . "</b><br><b>" . $datos['TIPO_DE_MONEDA_REAL'][$i] . ":</b> " . number_format($datos['MONTO_NETO'][$i], 2,',','.') . "<br><b>Pm:</b> " . number_format($datos['CANTIDAD_MICOIN'][$i], 2,',','.') . "<br><b>Banco:</b> " . $datos['BANCO_NOMBRE'][$i] . "<br><b>Cta N°:</b> " . $datos['BANCO_NUMERO_CUENTA'][$i] . "</e></br>";
								$fecha_iii=explode(" ",$datos['FH_SOLICITADO'][$i]);
								echo "(" . $fecha_iii[0] . ")<br>";
								$fecha_registro=date($datos['FH_SOLICITADO'][$i]);
								$dia_semana=date("w",strtotime($fecha_registro));//0 para domingo hasta 6 para sabado
								$fecha_fin = new DateTime($fecha_registro);
								if($dia_semana==4 or $dia_semana==5 or $dia_semana==6){
									$imprimir=date("Y-m-d h:m:s",strtotime($fecha_registro."+ 4 days"));
								}else if($dia_semana==0){
									$imprimir=date("Y-m-d h:m:s",strtotime($fecha_registro."+ 3 days"));
								}else{
									$imprimir=date("Y-m-d h:m:s",strtotime($fecha_registro."+ 2 days"));
								}
								echo "<div class='pt-2 my-0' id='cronometro_2_" . $i . "'></div>";
								echo "
									<script type='text/javascript'>
										$('#cronometro_2_" . $i . "').timeTo(new Date('" . $imprimir . "'));
									</script>
								";
								echo "</td>";
								echo "<td class='text-center h4'><a title='Aprobar' href='zona_adm_aprobar_pemon.php?accion=aprobar&NA_Id=" . $datos['ID_COMPRA_VENTA'][$i] . "' class='btn btn-transparent text-success fa fa-check-square-o d-inline'></a>";
								echo "<br>";
								echo "<a title='Rechazar' href='zona_adm_aprobar_pemon.php?accion=rechazar&NA_Id=" . $datos['ID_COMPRA_VENTA'][$i] . "' class='btn btn-transparent text-danger fa fa-window-close-o d-inline'></a>";
								$verf_rep=M_compra_venta_de_micoin_R($conexion, 'NUMERO_TRANSFERENCIA', $datos['NUMERO_TRANSFERENCIA'][$i], 'ESTATUS', 'CONFIRMADO', '', '');
								if(isset($verf_rep['NUMERO_TRANSFERENCIA'][0])){
									if($verf_rep['NUMERO_TRANSFERENCIA'][0]<>""){
										echo "<br><b title='Este Número de Transferencia ya se encuentra CONFIRMADO en el sistema' class='text-danger pt-1'>Rep.</b>";
									}
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
	<br><br><br><br><br><br><br><br><br><br><br><br>
	<?php
	//CIERRE DE LA ETIQUETA PARA EMBUTIR HTML EN PHP		
	}
	?>	
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>