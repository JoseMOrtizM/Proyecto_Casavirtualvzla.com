<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	if(isset($_GET['MARCAR_RECHAZO_COMO_LEIDO'])){
		$id_leido=mysqli_real_escape_string($conexion, $_GET['MARCAR_RECHAZO_COMO_LEIDO']);
		$datos_leido=M_compra_venta_de_micoin_R($conexion, 'ID_COMPRA_VENTA', $id_leido, '', '', '', '');
		if($datos_leido['ID_COMPRA_VENTA'][0]<>""){
			M_compra_venta_de_micoin_U_id_marcar_como_borrado($conexion, $id_leido);
		}
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Consolidado</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="my-3">
		<!-- APARTADO DE LAS TABLAS -->
		<div class="bg-white pb-3">
			<h2 class="text-center py-3 bg-dark text-warning">Estado de Cuenta</h2>
			<!-- INFORMACIÓN GENERAL -->
			<div class="container-fluid">
				<div class="row align-items-center text-center">
					<div class="col-md-3 my-2">
						<h5><i class="text-success"><b>Disponible</b></i></h5>
						<?php
							$datos_saldo_disponible_usuario= M_saldo_pm_disponible_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
						?>
						<h6>
							<b><?php echo number_format($datos_saldo_disponible_usuario['SALDO_PEMON'][0], 2,',','.');?>Pm</b>
						</h6>
					</div>
					<div class="col-md-3 my-2">
						<h5><i class="text-primary"><b>Diferido</b></i></h5>
						<?php
							$datos_saldo_diferido_usuario= M_saldo_pm_diferido_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
						?>
						<h6>
							<b><?php echo number_format($datos_saldo_diferido_usuario['SALDO_PEMON'][0], 2,',','.');?>Pm</b>
						</h6>
					</div>
					<div class="col-md-3 my-2">
						<h5><i class="text-danger"><b>Bloqueado</b></i></h5>
						<?php
							$datos_saldo_bloqueado_usuario= M_saldo_pm_bloqueado_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
						?>
						<h6>
							<b><?php echo number_format($datos_saldo_bloqueado_usuario['SALDO_PEMON'][0], 2,',','.');?>Pm</b>
						</h6>
					</div>
					<div class="col-md-3 my-2 text-center">
						<div class="m-auto">
							<a href="zona_usuario_arca_comprar.php" class="btn btn-dark text-warning p-2 my-1"><span class="fa fa-mail-forward"></span> Comprar</a>
							<br>
							<a href="zona_usuario_arca_vender.php" class="btn btn-warning p-2 my-1"><span class="fa fa-mail-reply"></span> Vender</a>
						</div>
					</div>
				</div>
			</div>
			<br><hr><br>
			<!-- TABLA DE SALDO DISPONIBLE -->
			<div class="container-fluid">
				<h4 class="text-center py-1 bg-success text-dark">Disponible</h4>
				<div class="table-responsive p-1 text-dark">
					<table class="table table-bordered table-hover TablaDinamicaOrderDesc bg-light text-dark">
						<thead>
							<tr class="text-center bg-dark text-white-50">
								<th class="align-middle"><b title="Fecha, Hora y Descripción de la Operación">Descripción</b></th>
								<th class="align-middle"><b title="Monto en Pemón y Ver detalle de la transacción">Detalle</b></th>
							</tr>
						</thead>
						<tbody>
							<?php
							//obteniendo los datos de la tabla para C-V_Pemón:
							$datos_1=M_compra_venta_de_micoin_R($conexion, 'CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'ESTATUS', 'CONFIRMADO', '', '');
							$i=0;
							while(isset($datos_1['ID_COMPRA_VENTA'][$i])){
								if($datos_1['ID_COMPRA_VENTA'][$i]<>""){
									echo "<tr>";
									echo "<td class='text-center w-50'>" . $datos_1['FH_CONFIRMADO'][$i] . "<br>";
									if($datos_1['TIPO_DE_TRANSACCION'][$i]=='COMPRA'){
										echo "Compra de Pemón</td>";
									}else{
										echo "Venta de Pemón</td>";
									}
									if($datos_1['TIPO_DE_TRANSACCION'][$i]=='COMPRA'){
										echo "<td class='text-center text-primary w-25'>Pm " . number_format($datos_1['CANTIDAD_MICOIN'][$i], 2,',','.') . "<br>";
									}else{
										echo "<td class='text-center text-danger w-50'>Pm -" . number_format($datos_1['CANTIDAD_MICOIN'][$i], 2,',','.') . "<br>";
									}
									if($datos_1['TIPO_DE_TRANSACCION'][$i]=='COMPRA'){
										$color="primary";
									}else{
										$color="danger";
									}
									echo "<a title='Ver Detalle de la operación' href='' class='btn btn-transparent text-$color fa fa-book d-inline' aria-hidden='true' data-toggle='modal' data-target='#modal_detalle_operacion_1_$i'> Detalle</a></td>";
								echo "</tr>";
								}
								$i=$i+1;
							}
							?>
							<?php
							//obteniendo los datos de la tabla para Compra_Productos:
							$datos_codigos_2= M_control_de_transacciones_agrupa_x_codigo_seguridad( $conexion, 'COMPRADOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'ESTATUS', 'ENTREGADO', '', '');
							$o=0;
							while(isset($datos_codigos_2['CODIGO_DE_SEGURIDAD'][$o])){
								if($datos_codigos_2['CODIGO_DE_SEGURIDAD'][$o]<>""){
									unset($datos_2);
									$datos_2= M_control_de_transacciones_compras_en_micoin_R( $conexion, 'CODIGO_DE_SEGURIDAD', $datos_codigos_2['CODIGO_DE_SEGURIDAD'][$o], '', '', '', '');
									if(isset($datos_2['ID_TRANSACCION'][1])){
										//tiene varios renglones
										echo "<tr>";
										echo "<td class='text-center w-50'>" . $datos_2['FH_ENTREGADO'][0] . "<br>";
										echo "Compra de Productos varios</td>";
										$cta=0;
										$total_i=0;
										while(isset($datos_2['ID_TRANSACCION'][$cta])){
											if($datos_2['ID_TRANSACCION'][$cta]<>""){
												$total_i=$total_i+$datos_2['MONTO_BRUTO_MICOIN'][$cta];
											}
											$cta++;
										}
										echo "<td class='text-center text-danger w-50'>Pm -" . number_format($total_i, 2,',','.') . "<br>";
										echo "<a title='Ver Detalle de la operación' href='' class='btn btn-transparent text-danger fa fa-book d-inline' aria-hidden='true' data-toggle='modal' data-target='#modal_detalle_operacion_2_$o'> Detalle</a></td>";
										echo "</tr>";
									}else{
										//tiene un solo renglon
										echo "<tr>";
										echo "<td class='text-center w-50'>" . $datos_2['FH_ENTREGADO'][0] . "<br>";
										echo "Compra de Producto</td>";
										echo "<td class='text-center text-danger w-50'>Pm -" . number_format($datos_2['MONTO_BRUTO_MICOIN'][0], 2,',','.') . "<br>";
										echo "<a title='Ver Detalle de la operación' href='' class='btn btn-transparent text-danger fa fa-book d-inline' aria-hidden='true' data-toggle='modal' data-target='#modal_detalle_operacion_2_$o'> Detalle</a></td>";
										echo "</tr>";
									}
								}
								$o++;
							}
							?>
							<?php
							//obteniendo los datos de la tabla para Venta_Productos:
							$datos_codigos_3= M_control_de_transacciones_agrupa_x_codigo_seguridad(  $conexion, 'VENDEDOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'ESTATUS', 'ENTREGADO', '', '');
							$o=0;
							while(isset($datos_codigos_3['CODIGO_DE_SEGURIDAD'][$o])){
								if($datos_codigos_3['CODIGO_DE_SEGURIDAD'][$o]<>""){
									unset($datos_3);
									$datos_3= M_control_de_transacciones_compras_en_micoin_R( $conexion, 'CODIGO_DE_SEGURIDAD', $datos_codigos_3['CODIGO_DE_SEGURIDAD'][$o], '', '', '', '');
									if(isset($datos_3['ID_TRANSACCION'][1])){
										//tiene varios renglones
										echo "<tr>";
										echo "<td class='text-center w-50'>" . $datos_3['FH_ENTREGADO'][0] . "<br>";
										echo "Venta de Productos varios</td>";
										$cta=0;
										$total_i=0;
										while(isset($datos_3['ID_TRANSACCION'][$cta])){
											if($datos_3['ID_TRANSACCION'][$cta]<>""){
												$total_i=$total_i+$datos_3['MONTO_NETO'][$cta];
											}
											$cta++;
										}
										echo "<td class='text-center text-primary w-50'>" . number_format($total_i, 2,',','.') . "<br>";
										echo "<a title='Ver Detalle de la operación' href='' class='btn btn-transparent text-primary fa fa-book d-inline' aria-hidden='true' data-toggle='modal' data-target='#modal_detalle_operacion_3_$o'> Detalle</a></td>";
										echo "</tr>";
									}else{
										//tiene un solo renglon
										echo "<tr>";
										echo "<td class='text-center w-50'>" . $datos_3['FH_ENTREGADO'][0] . "<br>";
										echo "Venta de Producto</td>";
										echo "<td class='text-center text-primary w-50'>Pm " . number_format($datos_3['MONTO_NETO'][0], 2,',','.') . "<br>";
										echo "<a title='Ver Detalle de la operación' href='' class='btn btn-transparent text-primary fa fa-book d-inline' aria-hidden='true' data-toggle='modal' data-target='#modal_detalle_operacion_3_$o'> Detalle</a></td>";
										echo "</tr>";
									}
								}
								$o++;
							}
							?>
							<?php
							//obteniendo los datos de DESCUENTO POR ABANDONO DE Compra_Productos PREMIUN:
							$datos_codigos_3_rechazo= M_control_de_transacciones_agrupa_x_codigo_seguridad(  $conexion, 'COMPRADOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'ESTATUS', 'ABANDONADO', '', '');
							$o=0;
							while(isset($datos_codigos_3_rechazo['CODIGO_DE_SEGURIDAD'][$o])){
								if($datos_codigos_3_rechazo['CODIGO_DE_SEGURIDAD'][$o]<>""){
									unset($datos_3_rechazo);
									$datos_3_rechazo= M_control_de_transacciones_compras_en_micoin_R( $conexion, 'CODIGO_DE_SEGURIDAD', $datos_codigos_3_rechazo['CODIGO_DE_SEGURIDAD'][$o], '', '', '', '');
									if(isset($datos_3_rechazo['ID_TRANSACCION'][1])){
										//tiene varios renglones
										echo "<tr>";
										echo "<td class='text-center w-50'>" . $datos_3_rechazo['FH_TRANSACCION_ABANDONADA'][0] . "<br>";
										echo "Comisión descontada por compra de Varios productos rechazada por usted)</td>";
										$cta=0;
										$total_i=0;
										while(isset($datos_3_rechazo['ID_TRANSACCION'][$cta])){
											if($datos_3_rechazo['ID_TRANSACCION'][$cta]<>""){
												$total_i=$total_i+$datos_3_rechazo['MONTO_COMISION'][$cta];
											}
											$cta++;
										}
										echo "<td class='text-center text-danger w-50'>Pm -" . number_format($total_i, 2,',','.') . "<br>";
										echo "<a title='Ver Detalle de la operación' href='' class='btn btn-transparent text-danger fa fa-book d-inline' aria-hidden='true' data-toggle='modal' data-target='#modal_detalle_operacion_3_rechazo_$o'> Detalle</a></td>";
										echo "</tr>";
									}else{
										//tiene un solo renglon
										echo "<tr>";
										echo "<td class='text-center w-50'>" . $datos_3_rechazo['FH_TRANSACCION_ABANDONADA'][0] . "<br>";
										echo "Comisión descontada por compra rechazada por Usted)</td>";
										echo "<td class='text-center text-danger w-50'>Pm -" . number_format($datos_3_rechazo['MONTO_COMISION'][0], 2,',','.') . "<br>";
										echo "<a title='Ver Detalle de la operación' href='' class='btn btn-transparent text-danger fa fa-book d-inline' aria-hidden='true' data-toggle='modal' data-target='#modal_detalle_operacion_3_rechazo_$o'> Detalle</a></td>";
										echo "</tr>";
									}
								}
								$o++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<br><hr><br>
			<!-- TABLA DE SALDO DIFERIDO -->
			<div class="container-fluid">
				<h4 class="text-center py-1 bg-primary text-dark">Diferido</h4>
				<div class="table-responsive p-3 text-dark">
					<table class="table table-bordered table-hover TablaDinamicaOrderDesc bg-light text-dark">
						<thead>
							<tr class="text-center bg-dark text-white-50">
								<th class="align-middle"><b title="Fecha, Hora y Descripción de la Operación">Descripción</b></th>
								<th class="align-middle"><b title="Monto en Pemón y Ver detalle de la transacción">Detalle</b></th>
							</tr>
						</thead>
						<tbody>
							<?php
							//obteniendo los datos de la tabla para C-V_Pemón:
							$datos_4=M_compra_venta_de_micoin_R($conexion, 'CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'ESTATUS', 'PAGADO', 'TIPO_DE_TRANSACCION', 'COMPRA');
							$i=0;
							while(isset($datos_4['ID_COMPRA_VENTA'][$i])){
								if($datos_4['ID_COMPRA_VENTA'][$i]<>""){
									echo "<tr>";
									echo "<td class='text-center w-50'>" . $datos_4['FH_PAGADO'][$i] . "<br>Compra de Pemón</td>";
									echo "<td class='text-center text-primary w-50'>" . number_format($datos_4['CANTIDAD_MICOIN'][$i], 2,',','.') . "<br><a title='Ver Detalle de la operación' href='' class='btn btn-transparent text-primary fa fa-book d-inline' aria-hidden='true' data-toggle='modal' data-target='#modal_detalle_operacion_4_$i'> Detalle</a></td>";
								echo "</tr>";
								}
								$i=$i+1;
							}
							?>
							<?php
							//obteniendo los datos de la tabla para Venta_Productos:
							$datos_codigos_5= M_control_de_transacciones_agrupa_x_codigo_seguridad(  $conexion, 'VENDEDOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'ESTATUS', 'PAGADO', '', '');
							$o=0;
							while(isset($datos_codigos_5['CODIGO_DE_SEGURIDAD'][$o])){
								if($datos_codigos_5['CODIGO_DE_SEGURIDAD'][$o]<>""){
									unset($datos_5);
									$datos_5= M_control_de_transacciones_compras_en_micoin_R( $conexion, 'CODIGO_DE_SEGURIDAD', $datos_codigos_5['CODIGO_DE_SEGURIDAD'][$o], '', '', '', '');
									if(isset($datos_5['ID_TRANSACCION'][1])){
										//tiene varios renglones
										echo "<tr>";
										echo "<td class='text-center w-50'>" . $datos_5['FH_PAGADO'][0] . "<br>Venta de Productos Varios</td>";
										$cta=0;
										$total_i=0;
										while(isset($datos_5['ID_TRANSACCION'][$cta])){
											if($datos_5['ID_TRANSACCION'][$cta]<>""){
												$total_i=$total_i+$datos_5['MONTO_NETO'][$cta];
											}
											$cta++;
										}
										echo "<td class='text-center text-primary w-50'>" . number_format($total_i, 2,',','.') . "<br><a title='Ver Detalle de la operación' href='' class='btn btn-transparent text-primary fa fa-book d-inline' aria-hidden='true' data-toggle='modal' data-target='#modal_detalle_operacion_5_$o'> Detalle</a></td>";
										echo "</tr>";
									}else{
										//tiene un solo renglon
										echo "<tr>";
										echo "<td class='text-center w-50'>" . $datos_5['FH_PAGADO'][0] . "<br>Venta de Producto</td>";
										echo "<td class='text-center text-primary w-50'>" . number_format($datos_5['MONTO_NETO'][0], 2,',','.') . "<br><a title='Ver Detalle de la operación' href='' class='btn btn-transparent text-primary fa fa-book d-inline' aria-hidden='true' data-toggle='modal' data-target='#modal_detalle_operacion_5_$o'> Detalle</a></td>";
										echo "</tr>";
									}
								}
								$o++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<br><hr><br>
			<!-- TABLA DE SALDO BLOQUEADO -->
			<div class="container-fluid">
				<h4 class="text-center py-1 bg-danger text-dark">Bloqueado</h4>
				<div class="table-responsive p-3 text-dark">
					<table class="table table-bordered table-hover TablaDinamicaOrderDesc bg-light text-dark">
						<thead>
							<tr class="text-center bg-dark text-white-50">
								<th class="align-middle"><b title="Fecha, Hora y Descripción de la Operación">Descripción</b></th>
								<th class="align-middle"><b title="Monto en Pemón y Ver detalle de la transacción">Detalle</b></th>
							</tr>
						</thead>
						<tbody>
							<?php
							//obteniendo los datos de la tabla para C-V_Pemón:
							$datos_6=M_compra_venta_de_micoin_R($conexion, 'CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'ESTATUS', 'SOLICITADO', 'TIPO_DE_TRANSACCION', 'VENTA');
							$i=0;
							while(isset($datos_6['ID_COMPRA_VENTA'][$i])){
								if($datos_6['ID_COMPRA_VENTA'][$i]<>""){
									echo "<tr>";
									echo "<td class='text-center w-50'>" . $datos_6['FH_SOLICITADO'][$i] . "<br>Venta de Pemón</td>";
									echo "<td class='text-center text-danger w-50'>-" . number_format($datos_6['CANTIDAD_MICOIN'][$i], 2,',','.') . "<br><a title='Ver Detalle de la operación' href='' class='btn btn-transparent text-danger fa fa-book d-inline' aria-hidden='true' data-toggle='modal' data-target='#modal_detalle_operacion_6_$i'> Detalle</a></td>";
								echo "</tr>";
								}
								$i=$i+1;
							}
							?>
							<?php
							//obteniendo los datos de la tabla para Compra_Productos:
							$datos_codigos_7= M_control_de_transacciones_agrupa_x_codigo_seguridad( $conexion, 'COMPRADOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'ESTATUS', 'PAGADO', '', '');
							$o=0;
							while(isset($datos_codigos_7['CODIGO_DE_SEGURIDAD'][$o])){
								if($datos_codigos_7['CODIGO_DE_SEGURIDAD'][$o]<>""){
									unset($datos_7);
									$datos_7= M_control_de_transacciones_compras_en_micoin_R( $conexion, 'CODIGO_DE_SEGURIDAD', $datos_codigos_7['CODIGO_DE_SEGURIDAD'][$o], '', '', '', '');
									if(isset($datos_7['ID_TRANSACCION'][1])){
										//tiene varios renglones
										echo "<tr>";
										echo "<td class='text-center w-50'>" . $datos_7['FH_ENTREGADO'][0] . "<br>Compra de Productos varios</td>";
										$cta=0;
										$total_i=0;
										while(isset($datos_7['ID_TRANSACCION'][$cta])){
											if($datos_7['ID_TRANSACCION'][$cta]<>""){
												$total_i=$total_i+$datos_7['MONTO_BRUTO_MICOIN'][$cta];
											}
											$cta++;
										}
										echo "<td class='text-center text-danger w-50'>-" . number_format($total_i, 2,',','.') . "<br><a title='Ver Detalle de la operación' href='' class='btn btn-transparent text-danger fa fa-book d-inline' aria-hidden='true' data-toggle='modal' data-target='#modal_detalle_operacion_7_$o'> Detalle</a></td>";
										echo "</tr>";
									}else{
										//tiene un solo renglon
										echo "<tr>";
										echo "<td class='text-center w-50'>" . $datos_7['FH_PAGADO'][0] . "<br>Compra de Producto</td>";
										echo "<td class='text-center text-danger w-50'>-" . number_format($datos_7['MONTO_BRUTO_MICOIN'][0], 2,',','.') . "<br><a title='Ver Detalle de la operación' href='' class='btn btn-transparent text-danger fa fa-book d-inline' aria-hidden='true' data-toggle='modal' data-target='#modal_detalle_operacion_7_$o'> Detalle</a></td>";
										echo "</tr>";
									}
								}
								$o++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<br><hr><br>
			<!-- TABLA DE C-V PEMON RECAZADAS -->
			<div class="container-fluid">
				<h4 class="text-center py-1 bg-warning text-dark" title="Aquí se detallan todas las operaciones de Compra y/o Venta de Pemón que han sido rechazadas por la casa virtual (para hacer efectivas estas transacciones debe volver a registrar la operación)">C-V Pm Rechazadas</h4>
				<div class="table-responsive p-3 text-dark">
					<table class="table table-bordered table-hover TablaDinamicaOrderDesc bg-light text-dark">
						<thead>
							<tr class="text-center bg-dark text-white-50">
								<th class="align-middle"><b title="Fecha, Hora y Descripción de la Operación">Descripción</b></th>
								<th class="align-middle"><b title="Monto en Pemón y Ver detalle de la transacción">Detalle</b></th>
							</tr>
						</thead>
						<tbody>
							<?php
							//obteniendo los datos de la tabla para C-V_Pemón:
							$datos_8=M_compra_venta_de_micoin_R($conexion, 'CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'ESTATUS', 'RECHAZADO', '', '');
							$i=0;
							while(isset($datos_8['ID_COMPRA_VENTA'][$i])){
								if($datos_8['ID_COMPRA_VENTA'][$i]<>"" and $datos_8['MARCAR_BORRADO'][$i]<>"SI"){
									echo "<tr>";
									if($datos_8['TIPO_DE_TRANSACCION'][$i]=='COMPRA'){
										echo "<td class='text-center w-50'>" . $datos_8['FH_TRANSACCION_ABANDONADA'][$i] . "<br>Compra de Pemón Rechazada (id=" . $datos_8['ID_COMPRA_VENTA'][$i] . ")</td>";
									}else if($datos_8['TIPO_DE_TRANSACCION'][$i]=='VENTA'){
										echo "<td class='text-center w-50'>" . $datos_8['FH_TRANSACCION_ABANDONADA'][$i] . "<br>Venta de Pemón Rechazada (id=" . $datos_8['ID_COMPRA_VENTA'][$i] . ")</td>";
									}
									echo "<td class='text-center text-dark w-50'>" . number_format($datos_8['CANTIDAD_MICOIN'][$i], 2,',','.') . "<br><a title='Ver Detalle de la operación' href='' class='btn btn-transparent text-dark fa fa-book d-inline' aria-hidden='true' data-toggle='modal' data-target='#modal_detalle_operacion_8_$i'> Detalle</a></td>";
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
		<!-- APARTADO DE LOS MODALES DE LAS TABLAS -->
		<?php
		//MODAL 1 - datos de la tabla para C-V_Pemón:
		$i=0;
		while(isset($datos_1['ID_COMPRA_VENTA'][$i])){
			if($datos_1['ID_COMPRA_VENTA'][$i]<>""){
				//INICIO DEL MODAL
				$datos_modal_1= M_compra_venta_de_micoin_R($conexion, 'ID_COMPRA_VENTA', $datos_1['ID_COMPRA_VENTA'][$i], '', '', '', '');
				echo "<div class='modal fade bd-example-modal-lg' id='modal_detalle_operacion_1_$i' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_detalle_operacion_1_$i' aria-hidden='true'>";
				echo "<div class='modal-dialog modal-lg' role='document'>
						<div class='modal-content text-left px-0 py-1'>
							<div class='modal-header'>
								<div class='container'>
									<div class='row align-items-center text-center'>
										<div class='col-10 my-1 bg-secondary'>
											<h4 class='modal-title text-dark p-1 w-100 text-center' id='Modal_Title_detalle_operacion_1_$i'><b>Detalle</b></h4>
										</div>
										<div class='col-2 my-1 text-center'>
											<button type='button' class='close' data-dismiss='modal' aria-label='Close'>X</button>
										</div>
									</div>
								</div>
							</div>
							<div class='modal-body'>
								<div class='text-center'><b class='h5'><b>Detalle Recibo</b></b><br><a href='zona_usuario_factura_cv_pemon.php?id=" . $datos_1['ID_COMPRA_VENTA'][$i]. "&ver=si'><b class='h5'>Ver</b></a> o <a href='zona_usuario_factura_cv_pemon.php?id=" . $datos_1['ID_COMPRA_VENTA'][$i]. "&ver=no'><b class='h5'>Descargar</b></a></div>
								<div class='table-responsive'>
									<table class='table table-bordered TablaDinamica1'>
										<thead>
											<tr class='text-center'>
												<th class='align-middle'><b title='Apellido, Nombre y Correo del Usuario, Tipo de transacción (Compra o Venta de Moneda Virtual)-Moneda y * Tasa de Cambio'>Transacción</b></th>
												<th class='align-middle'><b title='Cantidad de Monedas Virtuales, Monto Bruto, Comisión y Monto Neto implicados en la transacción'>Montos</b></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class='text-left w-50'>";
				if($datos_usuario_session['ACCESO'][0]<>'COMPRADOR-VENDEDOR'){
					echo "
												<b>Apellido:</b> " . $datos_modal_1['APELLIDO'][0] . "<br><b>Nombre:</b> " . $datos_modal_1['NOMBRE'][0] . "<br><b>Cédula/RIF:</b> " . $datos_modal_1['CEDULA_RIF'][0] . "<br><b class='text-danger'>" . $datos_modal_1['CORREO'][0] . "</b><br>
					";
				}
				echo "
												<b>Tipo:</b> " . $datos_modal_1['TIPO_DE_TRANSACCION'][0] . "<br><b>Moneda:</b> " . $datos_modal_1['TIPO_DE_MONEDA_REAL'][0] . "<br><b>Tasa:</b> ";
				if($datos_modal_1['CANTIDAD_MICOIN'][0]==0){
					$imprimir_tc=0;
				}else{
					$imprimir_tc=$datos_modal_1['MONTO_BRUTO'][0]/$datos_modal_1['CANTIDAD_MICOIN'][0];
				}
				echo 
												number_format($imprimir_tc, 2,',','.') . "<br><b title='Número de Transferencia'>N° Conf:</b> " . $datos_modal_1['NUMERO_TRANSFERENCIA'][0] . "</td>
												<td class='text-left w-50'><b>Pm:</b> " . number_format($datos_modal_1['CANTIDAD_MICOIN'][0], 2,',','.') . "<br><b>Importe Bs:</b> " . number_format($datos_modal_1['MONTO_BRUTO'][0], 2,',','.') . "<br><b title='Comisión descontada'>Comis. Bs:</b> " . number_format($datos_modal_1['MONTO_COMISION'][0], 2,',','.') . "<br><b>Total Bs:</b> " . number_format($datos_modal_1['MONTO_NETO'][0], 2,',','.') . "</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>";
				//FIN DEL MODAL
			}
			$i=$i+1;
		}
		?>
		<?php
		//MODAL 2 - datos de la tabla para Compra_Productos:
		$o=0;
		while(isset($datos_codigos_2['CODIGO_DE_SEGURIDAD'][$o])){
			if($datos_codigos_2['CODIGO_DE_SEGURIDAD'][$o]<>""){
				unset($datos_2);
				$datos_2= M_control_de_transacciones_compras_en_micoin_R( $conexion, 'CODIGO_DE_SEGURIDAD', $datos_codigos_2['CODIGO_DE_SEGURIDAD'][$o], '', '', '', '');
				if(isset($datos_2['ID_TRANSACCION'][1])){
					//tiene varios renglones
					//INICIO DEL MODAL
					$datos_del_vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $datos_2['VENDEDOR_CEDULA_RIF'][0], '', '', '', '');
					echo "<div class='modal fade bd-example-modal-lg' id='modal_detalle_operacion_2_$o' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_detalle_operacion_2_$o' aria-hidden='true'>";
					echo "<div class='modal-dialog modal-lg' role='document'>
							<div class='modal-content text-left px-0 py-1'>
								<div class='modal-header'>
									<div class='container'>
										<div class='row align-items-center text-center'>
											<div class='col-10 my-1 bg-secondary'>
												<h4 class='modal-title text-dark p-1 w-100 text-center' id='Modal_Title_detalle_operacion_2_$o'><b>Detalle</b></h4>
											</div>
											<div class='col-2 my-1 text-center'>
												<button type='button' class='close' data-dismiss='modal' aria-label='Close'>X</button>
											</div>
										</div>
									</div>
								</div>
								<div class='modal-body'>
									<div class='text-center mb-2'><b class='h5'><b>Detalle Recibo</b></b><br><a href='zona_usuario_factura_cv_prod.php?id=" . $datos_2['ID_TRANSACCION'][0]. "&ver=si'><b class='h5'>Ver</b> o <a href='zona_usuario_factura_cv_prod.php?id=" . $datos_2['ID_TRANSACCION'][0]. "&ver=no'><b class='h5'>Descargar</b></a></div>
									<div class='text-center mb-2'><b>Vendedor: </b> " . $datos_2['VENDEDOR_NOMBRE'][0] . " " . $datos_2['VENDEDOR_APELLIDO'][0] . "<br>(<b class='text-danger'>" . $datos_2['VENDEDOR_CORREO'][0] . "</b>)<br><b>Estatus: </b>" . $datos_del_vendedor['ESTATUS'][0] . "<br><b>Tipo de Compra: </b>" . $datos_2['TIPO_DE_COMPRA'][0] . "</div>
									<div class='table-responsive'>
										<table class='table table-bordered TablaDinamica'>
											<thead>
												<tr class='text-center'>
													<th class='align-middle'><b title='Nombre del Producto y Cantidad Comprada'>Producto (Cantidad)</b></th>
													<th class='align-middle'><b title='Monto Bruto Total implicado en la transacción'>Monto Pm</b></th>
												</tr>
											</thead>
											<tbody>
					";
					$cta_2=0;
					while(isset($datos_2['NOMBRE_PRODUCTO'][$cta_2])){
						if($datos_2['NOMBRE_PRODUCTO'][$cta_2]<>""){
							echo "
												<tr>
													<td class='text-left'>" . $datos_2['NOMBRE_PRODUCTO'][$cta_2] . " (" . $datos_2['CANTIDAD_COMPRADA'][$cta_2] . ")</td>
													<td class='text-center'>" . number_format($datos_2['MONTO_BRUTO_MICOIN'][$cta_2], 2,',','.') . "</td>
												</tr>
							";
						}
						$cta_2++;
					}
					echo "
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>";
					//FIN DEL MODAL
				}else{
					//tiene un solo renglon
					//INICIO DEL MODAL
					echo "<div class='modal fade bd-example-modal-lg' id='modal_detalle_operacion_2_$o' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_detalle_operacion_2_$o' aria-hidden='true'>";
					echo "<div class='modal-dialog modal-lg' role='document'>
							<div class='modal-content text-left px-0 py-1'>
								<div class='modal-header'>
									<div class='container'>
										<div class='row align-items-center text-center'>
											<div class='col-10 my-1 bg-secondary'>
												<h4 class='modal-title text-dark p-1 w-100 text-center' id='Modal_Title_detalle_operacion_2_$o'><b>Detalle</b></h4>
											</div>
											<div class='col-2 my-1 text-center'>
												<button type='button' class='close' data-dismiss='modal' aria-label='Close'>X</button>
											</div>
										</div>
									</div>
								</div>
								<div class='modal-body'>
									<div class='text-center'><b class='h5'><b>Detalle Recibo</b></b><br><a href='zona_usuario_factura_cv_prod.php?id=" . $datos_2['ID_TRANSACCION'][0]. "&ver=si'><b class='h5'>Ver</b></a> o <a href='zona_usuario_factura_cv_prod.php?id=" . $datos_2['ID_TRANSACCION'][0]. "&ver=no'><b class='h5'>Descargar</b></a></div>
									<div class='table-responsive'>
										<table class='table table-bordered TablaDinamica1'>
											<thead>
												<tr class='text-center'>
													<th class='align-middle'><b title='Nombre del Producto, tipo de compra, Cantidad, Estatus del Vendedor y Correo del Vendedor'>Producto</b></th>
													<th class='align-middle'><b title='Monto Bruto Total implicado en la transacción'>Monto Pm:</b></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td class='text-left'><b>Producto:</b> " . $datos_2['NOMBRE_PRODUCTO'][0] . "<br><b>Venta:</b> " . $datos_2['TIPO_DE_COMPRA'][0] . "<br><b>Cantidad:</b> " . $datos_2['CANTIDAD_COMPRADA'][0] . "<br>";
													$datos_del_vendedor= M_usuarios_R($conexion, 'CEDULA_RIF', $datos_2['COMPRADOR_CEDULA_RIF'][0], '', '', '', '');
													echo "<b>Vendedor:</b> " . $datos_del_vendedor['ESTATUS'][0] . "<br><b class='text-danger small'>" . $datos_2['VENDEDOR_CORREO'][0] . "</b></td>
													<td class='text-center'>" . number_format($datos_2['MONTO_BRUTO_MICOIN'][0], 2,',','.') . "</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>";
					//FIN DEL MODAL
				}
			}
			$o++;
		}
		?>
		<?php
		//MODAL 3 - datos de la tabla para Venta_Productos:
		$o=0;
		while(isset($datos_codigos_3['CODIGO_DE_SEGURIDAD'][$o])){
			if($datos_codigos_3['CODIGO_DE_SEGURIDAD'][$o]<>""){
				unset($datos_3);
				$datos_3= M_control_de_transacciones_compras_en_micoin_R( $conexion, 'CODIGO_DE_SEGURIDAD', $datos_codigos_3['CODIGO_DE_SEGURIDAD'][$o], '', '', '', '');
				if(isset($datos_3['ID_TRANSACCION'][1])){
					//tiene varios renglones
					//INICIO DEL MODAL
					$datos_del_comprador=M_usuarios_R($conexion, 'CEDULA_RIF', $datos_3['COMPRADOR_CEDULA_RIF'][0], '', '', '', '');
					echo "<div class='modal fade bd-example-modal-lg' id='modal_detalle_operacion_3_$o' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_detalle_operacion_3_$o' aria-hidden='true'>";
					echo "<div class='modal-dialog modal-lg' role='document'>
							<div class='modal-content text-left px-0 py-1'>
								<div class='modal-header'>
									<div class='container'>
										<div class='row align-items-center text-center'>
											<div class='col-10 my-1 bg-secondary'>
												<h4 class='modal-title text-dark p-1 w-100 text-center' id='Modal_Title_detalle_operacion_3_$o'><b>Detalle</b></h4>
											</div>
											<div class='col-2 my-1 text-center'>
												<button type='button' class='close' data-dismiss='modal' aria-label='Close'>X</button>
											</div>
										</div>
									</div>
								</div>
								<div class='modal-body'>
									<div class='text-center'><b class='h5'><b>Detalle Recibo</b></b><br><a href='zona_usuario_factura_cv_prod.php?id=" . $datos_3['ID_TRANSACCION'][0]. "&ver=si'><b class='h5'>Ver</b></a> o <a href='zona_usuario_factura_cv_prod.php?id=" . $datos_3['ID_TRANSACCION'][0]. "&ver=no'><b class='h5'>Descargar</b></a></div>
									<div class='text-center mb-2'><b>Comprador: </b> " . $datos_3['COMPRADOR_NOMBRE'][0] . " " . $datos_3['COMPRADOR_APELLIDO'][0] . "<br>(<b class='text-danger'>" . $datos_3['COMPRADOR_CORREO'][0] . "</b>)<br><b>Estatus: </b>" . $datos_del_comprador['ESTATUS'][0] . "<br><b>Tipo de Compra: </b>" . $datos_3['TIPO_DE_COMPRA'][0] . "</div>
									<div class='table-responsive'>
										<table class='table table-bordered TablaDinamica'>
											<thead>
												<tr class='text-center'>
													<th class='align-middle'><b title='Nombre,  Precio Unitario y Cantidad Vendida del Producto'>Producto</b></th>
													<th class='align-middle'><b title='Monto Pagado por el Comprador'>Importe</b></th>
												</tr>
											</thead>
											<tbody>
					";
					$cta_2=0;
					$sub_total=0;
					while(isset($datos_3['NOMBRE_PRODUCTO'][$cta_2])){
						if($datos_3['NOMBRE_PRODUCTO'][$cta_2]<>""){
							echo "
												<tr>
													<td class='text-left py-0 my-0'>" . $datos_3['NOMBRE_PRODUCTO'][$cta_2] . "<br><b>P/U: </b>" . number_format($datos_3['PRECIO_UNITARIO_MICOIN'][$cta_2], 2,',','.') . "Pm<br><b>Cantidad: </b>" . $datos_3['CANTIDAD_COMPRADA'][$cta_2] . "</td>
													<td class='text-center py-0 my-0'>" . number_format($datos_3['MONTO_BRUTO_MICOIN'][$cta_2], 2,',','.') . "
													</td>
												</tr>
							";
							$sub_total=$sub_total+$datos_3['MONTO_BRUTO_MICOIN'][$cta_2];
						}
						$cta_2++;
					}
					echo "
												<tr>
													<td colspan='2' class='text-left py-0 my-0'><b>Pms Pagados por el Comprador:</b> <b>" . number_format($sub_total, 2,',','.') . "</b></td>
												</tr>
												<tr>
													<td colspan='2' class='text-left py-0 my-0'>% Comisión: " . number_format($datos_3['PORC_COMISION'][0], 2,',','.') . "</td>
												</tr>
												<tr>
													<td colspan='2' class='text-left py-0 my-0'>Pms Comisión Casa Virtual: " . number_format($sub_total*$datos_3['PORC_COMISION'][0]/100, 2,',','.') . "</td>
												</tr>
												<tr>
													<td colspan='2' class='text-left py-0 my-0'><b>Pms Recibidos por Vendedor:</b> <b>" . number_format($sub_total-$sub_total*$datos_3['PORC_COMISION'][0]/100, 2,',','.') . "</b></td>
												</tr>
					";
					echo "
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>";
					//FIN DEL MODAL
				}else{
					//tiene un solo renglon
					//INICIO DEL MODAL
					echo "<div class='modal fade bd-example-modal-lg' id='modal_detalle_operacion_3_$o' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_detalle_operacion_3_$o' aria-hidden='true'>";
					echo "<div class='modal-dialog modal-lg' role='document'>
							<div class='modal-content text-left px-0 py-1'>
								<div class='modal-header'>
									<div class='container'>
										<div class='row align-items-center text-center'>
											<div class='col-10 my-1 bg-secondary'>
												<h4 class='modal-title text-dark p-1 w-100 text-center' id='Modal_Title_detalle_operacion_3_$o'><b>Detalle</b></h4>
											</div>
											<div class='col-2 my-1 text-center'>
												<button type='button' class='close' data-dismiss='modal' aria-label='Close'>X</button>
											</div>
										</div>
									</div>
								</div>
								<div class='modal-body'>
									<div class='text-center'><b class='h5'><b>Detalle Recibo</b></b><br><a href='zona_usuario_factura_cv_prod.php?id=" . $datos_3['ID_TRANSACCION'][0]. "&ver=si'><b class='h5'>Ver</b></a> o <a href='zona_usuario_factura_cv_prod.php?id=" . $datos_3['ID_TRANSACCION'][0]. "&ver=no'><b class='h5'>Descargar</b></a></div>
									<div class='table-responsive'>
										<table class='table table-bordered TablaDinamica'>
											<thead>
												<tr class='text-center'>
													<th class='align-middle'><b title='Nombre del Producto, Cantidad, tipo de compra, Estatus y correo del vendedor'>Producto</b></th>
													<th class='align-middle'><b title='Monto Bruto, Ranking del vendedor, Monto Comisión y Monto Neto implicados en la transacción'>Montos</b></th>
												</tr>
											</thead>
											<tbody>
												<tr>
					";
													$datos_del_vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $datos_3['COMPRADOR_CEDULA_RIF'][0], '', '', '', '');
					echo "
													<td class='text-left'><b>Producto:</b> " . $datos_3['NOMBRE_PRODUCTO'][0] . " <br><b>Cantidad: </b>" . $datos_3['CANTIDAD_COMPRADA'][0] . "<br><b>Venta:</b> " . $datos_3['TIPO_DE_COMPRA'][0] . "<br><b>Comprador:</b> " . $datos_del_vendedor['ESTATUS'][0] . "<br><b class='text-danger small'>" . $datos_3['COMPRADOR_CORREO'][0] . "</b></td>
													<td class='text-left''><b>Importe Pm:</b> " . number_format($datos_3['MONTO_BRUTO_MICOIN'][0], 2,',','.') . "<br><b>Ranking:</b> " . $datos_3['RANKING'][0] . "<br><b>Comisión Pm:</b> " . number_format($datos_3['MONTO_COMISION'][0], 2,',','.') . "<br><b>Total Pm:</b> " . number_format($datos_3['MONTO_NETO'][0], 2,',','.') . "</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>";
					//FIN DEL MODAL
				}
			}
			$o++;
		}
		?>
		<?php
		//MODAL 3_RECHAZADO - datos de REINTEGRO POR ABANDONO DE Compra_Productos PREMIUN:
		$o=0;
		while(isset($datos_codigos_3_rechazo['CODIGO_DE_SEGURIDAD'][$o])){
			if($datos_codigos_3_rechazo['CODIGO_DE_SEGURIDAD'][$o]<>""){
				unset($datos_3_rechazo);
				$datos_3_rechazo= M_control_de_transacciones_compras_en_micoin_R( $conexion, 'CODIGO_DE_SEGURIDAD', $datos_codigos_3_rechazo['CODIGO_DE_SEGURIDAD'][$o], '', '', '', '');
				if(isset($datos_3_rechazo['ID_TRANSACCION'][1])){
					//tiene varios renglones
					//INICIO DEL MODAL
					$datos_del_vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $datos_3_rechazo['VENDEDOR_CEDULA_RIF'][0], '', '', '', '');
					echo "<div class='modal fade bd-example-modal-lg' id='modal_detalle_operacion_3_rechazo_$o' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_detalle_operacion_3_rechazo_$o' aria-hidden='true'>";
					echo "<div class='modal-dialog modal-lg' role='document'>
							<div class='modal-content text-left px-0 py-1'>
								<div class='modal-header'>
									<div class='container'>
										<div class='row align-items-center text-center'>
											<div class='col-10 my-1 bg-secondary'>
												<h4 class='modal-title text-dark p-1 w-100 text-center' id='Modal_Title_detalle_operacion_3_rechazo_$o'><b>Detalle</b></h4>
											</div>
											<div class='col-2 my-1 text-center'>
												<button type='button' class='close' data-dismiss='modal' aria-label='Close'>X</button>
											</div>
										</div>
									</div>
								</div>
								<div class='modal-body'>
									<div class='text-center mb-2'><b class='h5'><b>Detalle Recibo</b></b><br><a href='zona_usuario_factura_c_prod_abandonada.php?id=" . $datos_3_rechazo['ID_TRANSACCION'][0]. "&ver=si'><b class='h5'>Ver</b></a> o <a href='zona_usuario_factura_c_prod_abandonada.php?id=" . $datos_3_rechazo['ID_TRANSACCION'][0]. "&ver=no'><b class='h5'>Descargar</b></a></div>
									<div class='text-center mb-2'><b>Vendedor: </b> " . $datos_3_rechazo['VENDEDOR_NOMBRE'][0] . " " . $datos_3_rechazo['VENDEDOR_APELLIDO'][0] . "<br>(<b class='text-danger'>" . $datos_3_rechazo['VENDEDOR_CORREO'][0] . "</b>)<br><b>Estatus: </b>" . $datos_del_vendedor['ESTATUS'][0] . "<br><b>Tipo de Compra: </b>" . $datos_3_rechazo['TIPO_DE_COMPRA'][0] . "</div>
									<div class='table-responsive'>
										<table class='table table-bordered TablaDinamica'>
											<thead>
												<tr class='text-center'>
													<th class='align-middle'><b title='Nombre del Producto y Cantidad Comprada'>Producto</b></th>
													<th class='align-middle'><b title='Monto Neto Descontado'>Pms Desc.:</b></th>
												</tr>
											</thead>
											<tbody>
					";
					$cta_2=0;
					while(isset($datos_3_rechazo['NOMBRE_PRODUCTO'][$cta_2])){
						if($datos_3_rechazo['NOMBRE_PRODUCTO'][$cta_2]<>""){
							echo "
												<tr>
													<td class='text-left'>" . $datos_3_rechazo['NOMBRE_PRODUCTO'][$cta_2] . " (" . $datos_3_rechazo['CANTIDAD_COMPRADA'][$cta_2] . ")</td>
													<td class='text-center'>-" . number_format($datos_3_rechazo['MONTO_COMISION'][$cta_2], 2,',','.') . "</td>
												</tr>
							";
						}
						$cta_2++;
					}
					echo "
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>";
					//FIN DEL MODAL
				}else{
					//tiene un solo renglon
					//INICIO DEL MODAL
					echo "<div class='modal fade bd-example-modal-lg' id='modal_detalle_operacion_3_rechazo_$o' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_detalle_operacion_3_rechazo_$o' aria-hidden='true'>";
					echo "<div class='modal-dialog modal-lg' role='document'>
							<div class='modal-content text-left px-0 py-1'>
								<div class='modal-header'>
									<div class='container'>
										<div class='row align-items-center text-center'>
											<div class='col-10 my-1 bg-secondary'>
												<h4 class='modal-title text-dark p-1 w-100 text-center' id='Modal_Title_detalle_operacion_3_rechazo_$o'><b>Detalle</b></h4>
											</div>
											<div class='col-2 my-1 text-center'>
												<button type='button' class='close' data-dismiss='modal' aria-label='Close'>X</button>
											</div>
										</div>
									</div>
								</div>
								<div class='modal-body'>
									<div class='text-center'><b class='h5'><b>Detalle Recibo</b></b><br><a href='zona_usuario_factura_c_prod_abandonada.php?id=" . $datos_3_rechazo['ID_TRANSACCION'][0]. "&ver=si'><b class='h5'>Ver</b></a> o <a href='zona_usuario_factura_c_prod_abandonada.php?id=" . $datos_3_rechazo['ID_TRANSACCION'][0]. "&ver=no'><b class='h5'>Descargar</b></a></div>
									<div class='table-responsive'>
										<table class='table table-bordered TablaDinamica1'>
											<thead>
												<tr class='text-center'>
													<th class='align-middle'><b title='Nombre del Producto, tipo de compra, Cantidad, Estatus del Vendedor y Correo del Vendedor'>Producto</b></th>
													<th class='align-middle'><b title='Monto Descontado'>Pms Desc.:</b></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td class='text-left'><b>Producto:</b> " . $datos_3_rechazo['NOMBRE_PRODUCTO'][0] . "<br><b>Venta:</b> " . $datos_3_rechazo['TIPO_DE_COMPRA'][0] . "<br><b>Cantidad:</b> " . $datos_3_rechazo['CANTIDAD_COMPRADA'][0] . "<br>";
													$datos_del_vendedor= M_usuarios_R($conexion, 'CEDULA_RIF', $datos_3_rechazo['COMPRADOR_CEDULA_RIF'][0], '', '', '', '');
													echo "<b>Vendedor:</b> " . $datos_del_vendedor['ESTATUS'][0] . "<br><b class='text-danger small'>" . $datos_3_rechazo['VENDEDOR_CORREO'][0] . "</b></td>
													<td class='text-center'>-" . number_format($datos_3_rechazo['MONTO_COMISION'][0], 2,',','.') . "</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>";
					//FIN DEL MODAL
				}
			}
			$o++;
		}
		?>
		<?php
		//MODAL 4 - datos de la tabla para C-V_Pemón:
		$i=0;
		while(isset($datos_4['ID_COMPRA_VENTA'][$i])){
			if($datos_4['ID_COMPRA_VENTA'][$i]<>""){
				//INICIO DEL MODAL
				$datos_modal_4= M_compra_venta_de_micoin_R($conexion, 'ID_COMPRA_VENTA', $datos_4['ID_COMPRA_VENTA'][$i], '', '', '', '');
				echo "<div class='modal fade bd-example-modal-lg' id='modal_detalle_operacion_4_$i' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_detalle_operacion_4_$i' aria-hidden='true'>";
				echo "<div class='modal-dialog modal-lg' role='document'>
						<div class='modal-content text-left px-0 py-1'>
							<div class='modal-header'>
								<div class='container'>
									<div class='row align-items-center text-center'>
										<div class='col-10 my-1 bg-secondary'>
											<h4 class='modal-title text-dark p-1 w-100 text-center' id='Modal_Title_detalle_operacion_4_$i'><b>Detalle</b></h4>
										</div>
										<div class='col-2 my-1 text-center'>
											<button type='button' class='close' data-dismiss='modal' aria-label='Close'>X</button>
										</div>
									</div>
								</div>
							</div>
							<div class='modal-body'>
								<div class='table-responsive'>
									<table class='table table-bordered TablaDinamica1'>
										<thead>
											<tr class='text-center'>
												<th class='align-middle'><b title='Tipo de transacción (Compra o Venta de Moneda Virtual)-Moneda y * Tasa de Cambio'>Operación</b></th>
												<th class='align-middle'><b title='Cantidad de Monedas Virtuales, Monto Bruto, Comisión y Monto Neto implicados en la transacción'>Montos</b></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class='text-left'><b>Tipo:</b> " . $datos_modal_4['TIPO_DE_TRANSACCION'][0] . "<br><b>Moneda:</b> " . $datos_modal_4['TIPO_DE_MONEDA_REAL'][0] . "<br><b>Tasa:</b> ";
												if($datos_modal_4['CANTIDAD_MICOIN'][0]<=0){
													echo number_format(0, 2,',','.');
												}else{
													echo number_format($datos_modal_4['MONTO_BRUTO'][0]/$datos_modal_4['CANTIDAD_MICOIN'][0], 2,',','.');
												}
											echo "</td>
												<td class='text-left'><b>Pm:</b> " . number_format($datos_modal_4['CANTIDAD_MICOIN'][0], 2,',','.') . "<br><b>Importe Bs:</b> " . number_format($datos_modal_4['MONTO_BRUTO'][0], 2,',','.') . "<br><b>Comisión Bs:</b> " . number_format($datos_modal_4['MONTO_COMISION'][0], 2,',','.') . "<br><b>Total Bs:</b> " . number_format($datos_modal_4['MONTO_NETO'][0], 2,',','.') . "</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>";
				//FIN DEL MODAL
			}
			$i=$i+1;
		}
		?>
		<?php
		//MODAL 5 - datos de la tabla para Venta_Productos:
		$o=0;
		while(isset($datos_codigos_5['CODIGO_DE_SEGURIDAD'][$o])){
			if($datos_codigos_5['CODIGO_DE_SEGURIDAD'][$o]<>""){
				unset($datos_5);
				$datos_5= M_control_de_transacciones_compras_en_micoin_R( $conexion, 'CODIGO_DE_SEGURIDAD', $datos_codigos_5['CODIGO_DE_SEGURIDAD'][$o], '', '', '', '');
				if(isset($datos_5['ID_TRANSACCION'][1])){
					//tiene varios renglones
					//INICIO DEL MODAL
					$datos_del_comprador=M_usuarios_R($conexion, 'CEDULA_RIF', $datos_5['COMPRADOR_CEDULA_RIF'][0], '', '', '', '');
					echo "<div class='modal fade bd-example-modal-lg' id='modal_detalle_operacion_5_$o' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_detalle_operacion_5_$o' aria-hidden='true'>";
					echo "<div class='modal-dialog modal-lg' role='document'>
							<div class='modal-content text-left px-0 py-1'>
								<div class='modal-header'>
									<div class='container'>
										<div class='row align-items-center text-center'>
											<div class='col-10 my-1 bg-primary'>
											<h4 class='modal-title text-dark p-1 w-100 text-center' id='Modal_Title_detalle_operacion_5_$i'><b>Detalle</b></h4>
											</div>
											<div class='col-2 my-1 text-center'>
												<button type='button' class='close' data-dismiss='modal' aria-label='Close'>X</button>
											</div>
										</div>
									</div>
								</div>
								<div class='modal-body'>
									<div class='text-center mb-2'><b>Comprador: </b> " . $datos_5['COMPRADOR_NOMBRE'][0] . " " . $datos_5['COMPRADOR_APELLIDO'][0] . "<br>(<b class='text-danger'>" . $datos_5['COMPRADOR_CORREO'][0] . "</b>)<br><b>Estatus: </b>" . $datos_del_comprador['ESTATUS'][0] . "<br><b>Tipo de Compra: </b>" . $datos_5['TIPO_DE_COMPRA'][0] . "</div>
									<div class='table-responsive'>
										<table class='table table-bordered TablaDinamica'>
											<thead>
												<tr class='text-center'>
													<th class='align-middle'><b title='Nombre del Producto, Precio Unitario y Cantidad Vendida'>Producto</b></th>
													<th class='align-middle'><b title='Monto Pagado por el Comprador'>Importe</b></th>
												</tr>
											</thead>
											<tbody>
					";
					$cta_2=0;
					$sub_total=0;
					while(isset($datos_5['NOMBRE_PRODUCTO'][$cta_2])){
						if($datos_5['NOMBRE_PRODUCTO'][$cta_2]<>""){
							echo "
												<tr>
													<td class='text-left'>" . $datos_5['NOMBRE_PRODUCTO'][$cta_2] . "<br><b>P/U: </b>" . number_format($datos_5['PRECIO_UNITARIO_MICOIN'][$cta_2], 2,',','.') . "<br><b>Cantidad</b>: " . $datos_5['CANTIDAD_COMPRADA'][$cta_2] . "</td>
													<td class='text-center'>" . number_format($datos_5['MONTO_BRUTO_MICOIN'][$cta_2], 2,',','.') . "
													</td>
												</tr>
							";
							$sub_total=$sub_total+$datos_5['MONTO_BRUTO_MICOIN'][$cta_2];
						}
						$cta_2++;
					}
					echo "
												<tr>
													<td colspan='2' class='text-left py-0 my-0'><b>Pms Pagados por el Comprador:</b> <b>" . number_format($sub_total, 2,',','.') . "</b></td>
												</tr>
												<tr>
													<td colspan='2' class='text-left py-0 my-0'>% Comisión: " . number_format($datos_5['PORC_COMISION'][0], 2,',','.') . "</td>
												</tr>
												<tr>
													<td colspan='2' class='text-left py-0 my-0'>Pms Comisión: " . number_format($sub_total*$datos_5['PORC_COMISION'][0]/100, 2,',','.') . "</td>
												</tr>
												<tr>
													<td colspan='2' class='text-left py-0 my-0'><b>Pms Recibido por Vendedor:</b> <b>" . number_format($sub_total-$sub_total*$datos_5['PORC_COMISION'][0]/100, 2,',','.') . "</b></td>
												</tr>
					";
					echo "
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>";
					//FIN DEL MODAL
				}else{
					//tiene un solo renglon
					//INICIO DEL MODAL
					echo "<div class='modal fade bd-example-modal-lg' id='modal_detalle_operacion_5_$o' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_detalle_operacion_5_$o' aria-hidden='true'>";
					echo "<div class='modal-dialog modal-lg' role='document'>
							<div class='modal-content text-left px-0 py-1'>
								<div class='modal-header'>
									<div class='container'>
										<div class='row align-items-center text-center'>
											<div class='col-10 my-1 bg-secondary'>
											<h4 class='modal-title text-dark p-1 w-100 text-center' id='Modal_Title_detalle_operacion_5_$i'><b>Detalle</b></h4>
											</div>
											<div class='col-2 my-1 text-center'>
												<button type='button' class='close' data-dismiss='modal' aria-label='Close'>X</button>
											</div>
										</div>
									</div>
								</div>
								<div class='modal-body'>
									<div class='table-responsive'>
										<table class='table table-bordered TablaDinamica'>
											<thead>
												<tr class='text-center'>
													<th class='align-middle'><b title='Nombre del Producto, Cantidad, tipo de compra, Estatus y correo del vendedor'>Producto</b></th>
													<th class='align-middle'><b title='Monto Bruto, Ranking del vendedor, Monto Comisión y Monto Neto implicados en la transacción'>Montos</b></th>
												</tr>
											</thead>
											<tbody>
												<tr>
					";
													$datos_del_vendedor= M_usuarios_R($conexion, 'CEDULA_RIF', $datos_5['COMPRADOR_CEDULA_RIF'][0], '', '', '', '');
													echo "<td class='text-left'><b>Producto:</b> " . $datos_5['NOMBRE_PRODUCTO'][0] . " (" . $datos_5['CANTIDAD_COMPRADA'][0] . ")<br><b>Venta:</b> " . $datos_5['TIPO_DE_COMPRA'][0] . "<br><b>Vendedor:</b> " . $datos_del_vendedor['ESTATUS'][0] . "<br><b class='text-danger small'>" . $datos_5['VENDEDOR_CORREO'][0] . "</b></td>
													<td class='text-left'><b>Importe Pm:</b> " . number_format($datos_5['MONTO_BRUTO_MICOIN'][0], 2,',','.') . "<br><b>Ranking:</b> " . $datos_5['RANKING'][0] . "<br><b>Comisión Pm:</b> " . number_format($datos_5['MONTO_COMISION'][0], 2,',','.') . "<br><b>Total Pm:</b> " . number_format($datos_5['MONTO_NETO'][0], 2,',','.') . "</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>";
					//FIN DEL MODAL
				}
			}
			$o++;
		}
		?>
		<?php
		//MODAL 6 - datos de la tabla para C-V_Pemón:
		$i=0;
		while(isset($datos_6['ID_COMPRA_VENTA'][$i])){
			if($datos_6['ID_COMPRA_VENTA'][$i]<>""){
				//INICIO DEL MODAL
				$datos_modal_6= M_compra_venta_de_micoin_R($conexion, 'ID_COMPRA_VENTA', $datos_6['ID_COMPRA_VENTA'][$i], '', '', '', '');
				echo "<div class='modal fade bd-example-modal-lg' id='modal_detalle_operacion_6_$i' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_detalle_operacion_6_$i' aria-hidden='true'>";
				echo "<div class='modal-dialog modal-lg' role='document'>
						<div class='modal-content text-left px-0 py-1'>
							<div class='modal-header'>
								<div class='container'>
									<div class='row align-items-center text-center'>
										<div class='col-10 my-1 bg-secondary'>
											<h4 class='modal-title text-dark p-1 w-100 text-center' id='Modal_Title_detalle_operacion_6_$i'><b>Detalle</b></h4>
										</div>
										<div class='col-2 my-1 text-center'>
											<button type='button' class='close' data-dismiss='modal' aria-label='Close'>X</button>
										</div>
									</div>
								</div>
							</div>
							<div class='modal-body'>
								<div class='table-responsive'>
									<table class='table table-bordered TablaDinamica1'>
										<thead>
											<tr class='text-center'>
												<th class='align-middle'><b title='Tipo de transacción (Compra o Venta de Moneda Virtual)-Moneda y * Tasa de Cambio'>Operación</b></th>
												<th class='align-middle'><b title='Cantidad de Monedas Virtuales, Monto Bruto, Comisión y Monto Neto implicados en la transacción'>Montos</b></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class='text-left'><b>Tipo:</b> " . $datos_modal_6['TIPO_DE_TRANSACCION'][0] . "<br><b>Moneda:</b> " . $datos_modal_6['TIPO_DE_MONEDA_REAL'][0] . "<br><b>Tasa:</b> " . number_format($datos_modal_6['MONTO_BRUTO'][0]/$datos_modal_6['CANTIDAD_MICOIN'][0], 2,',','.') . "</td>
												<td class='text-left'><b>Pm:</b> " . number_format($datos_modal_6['CANTIDAD_MICOIN'][0], 2,',','.') . "<br><b>Importe Bs:</b> " . number_format($datos_modal_6['MONTO_BRUTO'][0], 2,',','.') . "<br><b>Comisión Bs:</b> " . number_format($datos_modal_6['MONTO_COMISION'][0], 2,',','.') . "<br><b>Total Bs:</b> " . number_format($datos_modal_6['MONTO_NETO'][0], 2,',','.') . "</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>";
				//FIN DEL MODAL
			}
			$i=$i+1;
		}
		?>
		<?php
		//MODAL 7 - datos de la tabla para Compra_Productos:
		$o=0;
		while(isset($datos_codigos_7['CODIGO_DE_SEGURIDAD'][$o])){
			if($datos_codigos_7['CODIGO_DE_SEGURIDAD'][$o]<>""){
				unset($datos_7);
				$datos_7= M_control_de_transacciones_compras_en_micoin_R( $conexion, 'CODIGO_DE_SEGURIDAD', $datos_codigos_7['CODIGO_DE_SEGURIDAD'][$o], '', '', '', '');
				if(isset($datos_7['ID_TRANSACCION'][1])){
					//tiene varios renglones
					//INICIO DEL MODAL
					$datos_del_vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $datos_7['VENDEDOR_CEDULA_RIF'][0], '', '', '', '');
					echo "<div class='modal fade bd-example-modal-lg' id='modal_detalle_operacion_7_$o' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_detalle_operacion_7_$o' aria-hidden='true'>";
					echo "<div class='modal-dialog modal-lg' role='document'>
							<div class='modal-content text-left px-0 py-1'>
								<div class='modal-header'>
									<div class='container'>
										<div class='row align-items-center text-center'>
											<div class='col-10 my-1 bg-secondary'>
												<h4 class='modal-title text-dark p-1 w-100 text-center' id='Modal_Title_detalle_operacion_7_$o'><b>Detalle</b></h4>
											</div>
											<div class='col-2 my-1 text-center'>
												<button type='button' class='close' data-dismiss='modal' aria-label='Close'>X</button>
											</div>
										</div>
									</div>
								</div>
								<div class='modal-body'>
									<div class='text-center mb-2'><b>Vendedor: </b> " . $datos_7['VENDEDOR_NOMBRE'][0] . " " . $datos_7['VENDEDOR_APELLIDO'][0] . "<br>(<b class='text-danger'>" . $datos_7['VENDEDOR_CORREO'][0] . "</b>)<br><b>Estatus: </b>" . $datos_del_vendedor['ESTATUS'][0] . " <b>Tipo de Compra: </b>" . $datos_7['TIPO_DE_COMPRA'][0] . " <br>(Código Seguridad: <b class='text-success'>" . $datos_7['CODIGO_DE_SEGURIDAD'][0] . "</b>)</div>
									<div class='table-responsive'>
										<table class='table table-bordered TablaDinamica'>
											<thead>
												<tr class='text-center'>
													<th class='align-middle'><b title='Nombre del Producto y Cantidad Comprada'>Producto</b></th>
													<th class='align-middle'><b title='Monto Bruto Total implicado en la transacción'>Monto Pm</b></th>
												</tr>
											</thead>
											<tbody>
					";
					$cta_2=0;
					while(isset($datos_7['NOMBRE_PRODUCTO'][$cta_2])){
						if($datos_7['NOMBRE_PRODUCTO'][$cta_2]<>""){
							echo "
												<tr>
													<td class='text-left'>" . $datos_7['NOMBRE_PRODUCTO'][$cta_2] . "<br><b>Cantidad: </b>" . $datos_7['CANTIDAD_COMPRADA'][$cta_2] . "</td>
													<td class='text-center'>" . number_format($datos_7['MONTO_BRUTO_MICOIN'][$cta_2], 2,',','.') . "</td>
												</tr>
							";
						}
						$cta_2++;
					}
					echo "
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>";
					//FIN DEL MODAL
				}else{
					//tiene un solo renglon
					//INICIO DEL MODAL
					echo "<div class='modal fade bd-example-modal-lg' id='modal_detalle_operacion_7_$o' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_detalle_operacion_7_$o' aria-hidden='true'>";
					echo "<div class='modal-dialog modal-lg' role='document'>
							<div class='modal-content text-left px-0 py-1'>
								<div class='modal-header'>
									<div class='container'>
										<div class='row align-items-center text-center'>
											<div class='col-10 my-1 bg-secondary'>
												<h4 class='modal-title text-dark p-1 w-100 text-center' id='Modal_Title_detalle_operacion_7_$o'><b>Detalle</b></h4>
											</div>
											<div class='col-2 my-1 text-center'>
												<button type='button' class='close' data-dismiss='modal' aria-label='Close'>X</button>
											</div>
										</div>
									</div>
								</div>
								<div class='modal-body'>
									<div class='table-responsive'>
										<table class='table table-bordered TablaDinamica1'>
											<thead>
												<tr class='text-center'>
													<th class='align-middle'><b title='Nombre del Producto, tipo de compra, Cantidad, Estatus del Vendedor y Correo del Vendedor'>Producto</b></th>
													<th class='align-middle'><b title='Monto Bruto Total implicado en la transacción'>Monto Pm:</b></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td class='text-left'><b>Producto:</b> " . $datos_7['NOMBRE_PRODUCTO'][0] . "<br><b>Venta:</b> " . $datos_7['TIPO_DE_COMPRA'][0] . "<br><b>Cantidad:</b> " . $datos_7['CANTIDAD_COMPRADA'][0] . "<br>";
													$datos_del_vendedor= M_usuarios_R($conexion, 'CEDULA_RIF', $datos_7['COMPRADOR_CEDULA_RIF'][0], '', '', '', '');
													echo "<b>Vendedor:</b> " . $datos_del_vendedor['ESTATUS'][0] . "<br><b class='text-danger small'>" . $datos_7['VENDEDOR_CORREO'][0] . "</b><br>(CS: <b class='text-success small'>" . $datos_7['CODIGO_DE_SEGURIDAD'][0] . "</b>)</td>
													<td class='text-center'>" . number_format($datos_7['MONTO_BRUTO_MICOIN'][0], 2,',','.') . "</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>";
					//FIN DEL MODAL
				}
			}
			$o++;
		}
		?>
		<?php
		//MODAL 8 - datos de la tabla para C-V_Pemón:
		$i=0;
		while(isset($datos_8['ID_COMPRA_VENTA'][$i])){
			if($datos_8['ID_COMPRA_VENTA'][$i]<>""){
				//INICIO DEL MODAL
				$datos_modal_8= M_compra_venta_de_micoin_R($conexion, 'ID_COMPRA_VENTA', $datos_8['ID_COMPRA_VENTA'][$i], '', '', '', '');
				echo "<div class='modal fade bd-example-modal-lg' id='modal_detalle_operacion_8_$i' tabindex='-1' role='dialog' aria-labelledby='Modal_Title_detalle_operacion_8_$i' aria-hidden='true'>";
				echo "<div class='modal-dialog modal-lg' role='document'>
						<div class='modal-content text-left px-0 py-1'>
							<div class='modal-header'>
								<div class='container'>
									<div class='row align-items-center text-center'>
										<div class='col-10 my-1 bg-secondary'>
											<h4 class='modal-title text-dark p-1 w-100 text-center' id='Modal_Title_detalle_operacion_8_$i'><b>Detalle</b></h4>
										</div>
										<div class='col-2 my-1 text-center'>
											<button type='button' class='close' data-dismiss='modal' aria-label='Close'>X</button>
										</div>
									</div>
								</div>
							</div>
							<div class='modal-body'>
								<div class='table-responsive'>
									<table class='table table-bordered TablaDinamica1'>
										<thead>
											<tr class='text-center'>
												<th class='align-middle'><b title='Tipo de transacción (Compra o Venta de Moneda Virtual)-Moneda y * Tasa de Cambio'>Transacción</b></th>
												<th class='align-middle'><b title='Cantidad de Monedas Virtuales, Monto Bruto, Comisión y Monto Neto implicados en la transacción'>Montos</b></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class='text-left'><b>Tipo:</b> " . $datos_modal_8['TIPO_DE_TRANSACCION'][0] . "<br><b>Tasa:</b> ";
												if($datos_modal_8['CANTIDAD_MICOIN'][0]<=0){
													echo number_format(0, 2,',','.');
												}else{
													echo number_format($datos_modal_8['MONTO_BRUTO'][0]/$datos_modal_8['CANTIDAD_MICOIN'][0], 2,',','.');
												}
												echo "Bs/Pm<br><b>N° transferencia:</b> " . $datos_modal_8['NUMERO_TRANSFERENCIA'][0] . "</td>
												<td class='text-left'><b>Pm:</b> " . number_format($datos_modal_8['CANTIDAD_MICOIN'][0], 2,',','.') . "<br><b>Importe Bs:</b> " . number_format($datos_modal_8['MONTO_BRUTO'][0], 2,',','.') . "<br><b>Comisión Bs:</b> " . number_format($datos_modal_8['MONTO_COMISION'][0], 2,',','.') . "<br><b>Total Bs:</b> " . number_format($datos_modal_8['MONTO_NETO'][0], 2,',','.') . "</td>
											</tr>
				";
				if($datos_modal_8['TIPO_DE_TRANSACCION'][0]=='COMPRA'){
					echo "
											<tr>
												<td colspan='2' class='text-center'><b class='text-danger'>No se pudo confirmar su transferencia Bancaria...</b><br><b>Por favor verifique los datos de la transferencia y vuelva a realizar la compra.</b><br>Si desea quitar este renglón de la Tabla <<C-V Pm Rechazadas>> haga click <a href='zona_usuario_arca_consolidado.php?MARCAR_RECHAZO_COMO_LEIDO=" . $datos_modal_8['ID_COMPRA_VENTA'][0] . "'>AQUÍ</a>.</td>
											</tr>
					";
				}else if($datos_modal_8['TIPO_DE_TRANSACCION'][0]=='VENTA'){
					echo "
											<tr>
												<td colspan='2' class='text-center'><b class='text-danger'>No se pudo confirmar su Operación...</b><br><b>Por favor comuníquese con  <a href='zona_usuario_nueva_pregunta.php'>nosotros</a> o llame a nuestros <a href='form_contactanos.php' target='_blank'>representantes</a>.</b><br>Si desea quitar este renglón de la Tabla <<C-V Pm Rechazadas>> haga click <a href='zona_usuario_arca_consolidado.php?MARCAR_RECHAZO_COMO_LEIDO=" . $datos_modal_8['ID_COMPRA_VENTA'][0] . "'>AQUÍ</a>.</td>
											</tr>
					";
				}
				echo "
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>";
				//FIN DEL MODAL
			}
			$i=$i+1;
		}
		?>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>