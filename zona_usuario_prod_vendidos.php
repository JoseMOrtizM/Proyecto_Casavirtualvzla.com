<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php 
	$mensaje_verf_entregado="";
	//VERIFICANDO INTRODUCCIÓN DE CODIGO DE SEGUIRDAD
	if(isset($_POST['id_transaccion']) and isset($_POST['codigo_seguridad'])){
		$id_transaccion_verf=mysqli_real_escape_string($conexion,$_POST['id_transaccion']);
		$codigo_seguridad_verf=mysqli_real_escape_string($conexion,$_POST['codigo_seguridad']);
		
		//VOY POR AQUI ... HAY QUE CONFIRMAR EL CODIGO DE SEGURIDAD Y ACTUALIZAR TODOS LOS IDS QUE POSEAN ESE MISMO CODIGO
		
		$datos_id_x_codigo=M_control_de_transacciones_compras_en_micoin_R( $conexion, 'CODIGO_DE_SEGURIDAD', $codigo_seguridad_verf, 'ESTATUS', 'PAGADO', '', '');
		
		if($datos_id_x_codigo['ID_TRANSACCION'][0]<>""){
			if(isset($datos_id_x_codigo['ID_TRANSACCION'][1])){
				// actualizar varios renglones
				$fh_entregado=date("Y-m-d h:m:s");
				$i=0;
				while(isset($datos_id_x_codigo['ID_TRANSACCION'][$i])){
					if($datos_id_x_codigo['ID_TRANSACCION'][$i]<>""){
						$datos_de_confirmación_de_codigo= M_control_de_transacciones_compras_en_micoin_R( $conexion, 'ID_TRANSACCION', $datos_id_x_codigo['ID_TRANSACCION'][$i], 'CODIGO_DE_SEGURIDAD', $codigo_seguridad_verf, '', '');
						if($datos_de_confirmación_de_codigo['ID_TRANSACCION'][0]<>''){
							M_control_de_transacciones_micoin_U_id_y_estatus($conexion, $datos_id_x_codigo['ID_TRANSACCION'][$i], 'ENTREGADO', $fh_entregado);
							$mensaje_verf_entregado="<div class='col-md-12 col-lg-10 col-xl-9 mx-auto bg-success'>
							<h6 class='text-center text-dark px-2 pt-2'><b class='h3'>Codigo de Seguridad validado con ÉXITO.</b><br>Se ha añadido a su saldo la ganancia por esta venta.</h6></div>";
							//insertando datos en MC_BALANCE ADMINISTRATIVO Y EN MC_PARIDAD_CAMBIARIA SI LA COMPRA ES premiun
							$datos_previos_balance= M_balance_administrativo_lcv_R_ultimo($conexion);
							$verf_adm_y_pc= M_balance_administrativo_lcv_PRECALCULOS($conexion, $fh_entregado, "COMPRA PROD", "", "", $datos_previos_balance['TC_BS_DOLLAR'][0], "", $datos_id_x_codigo['ID_TRANSACCION'][$i]);
						}else{
							$mensaje_verf_entregado="<div class='col-md-12 col-lg-10 col-xl-9 mx-auto bg-danger'>
							<h6 class='text-center text-dark px-2 pt-2'><b class='h3'>ERROR EN CODIGO DE SEGURIDAD.</b><br>Por favor verifique su código e inténtelo nuevamente.</h6></div>";
						}
					}
					$i++;
				}
			}else{
				// actualizar un solo renglon
				$datos_de_confirmación_de_codigo= M_control_de_transacciones_compras_en_micoin_R( $conexion, 'ID_TRANSACCION', $id_transaccion_verf, 'CODIGO_DE_SEGURIDAD', $codigo_seguridad_verf, '', '');
				if($datos_de_confirmación_de_codigo['ID_TRANSACCION'][0]<>''){
					$fh_entregado=date("Y-m-d h:m:s");
					M_control_de_transacciones_micoin_U_id_y_estatus($conexion, $id_transaccion_verf, 'ENTREGADO', $fh_entregado);
					$mensaje_verf_entregado="<div class='col-md-12 col-lg-10 col-xl-9 mx-auto bg-success'>
					<h6 class='text-center text-dark px-2 pt-2'><b class='h3'>Codigo de Seguridad validado con ÉXITO.</b><br>Se ha añadido a su saldo la ganancia por esta venta.</h6></div>";
					//insertando datos en MC_BALANCE ADMINISTRATIVO Y EN MC_PARIDAD_CAMBIARIA SI LA COMPRA ES premiun
					$datos_previos_balance= M_balance_administrativo_lcv_R_ultimo($conexion);
					$verf_adm_y_pc= M_balance_administrativo_lcv_PRECALCULOS($conexion, $fh_entregado, "COMPRA PROD", "", "", $datos_previos_balance['TC_BS_DOLLAR'][0], "", $id_transaccion_verf);
				}else{
					$mensaje_verf_entregado="<div class='col-md-12 col-lg-10 col-xl-9 mx-auto bg-danger'>
					<h6 class='text-center text-dark px-2 pt-2'><b class='h3'>ERROR EN CODIGO DE SEGURIDAD.</b><br>Por favor verifique su código e inténtelo nuevamente.</h6></div>";
				}
			}
		}else{
				// el codigo introducido es incorrecto
				$mensaje_verf_entregado="<div class='col-md-12 col-lg-10 col-xl-9 mx-auto bg-danger'>
				<h6 class='text-center text-dark px-2 pt-2'><b class='h3'>ERROR EN CODIGO DE SEGURIDAD.</b><br>Por favor verifique su código e inténtelo nuevamente.</h6></div>";
		}
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Prod. Vendidos</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid px-0 mx-0 mx-md-2 px-md-4 mt-2 mb-5 bg-secondary">
	<?php
		if(isset($_GET['accion'])){
			if($_GET['accion']=='confirmar'){
				if(isset($_GET['id_transaccion'])){
	?>
		<br><br><br>
		<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
			<h3 class="text-center text-warning px-2 pt-2"><b>Confirmar Entrega de Productos Vendidos</b></h3>
			<br>
			<form action="zona_usuario_prod_vendidos.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="id_transaccion" id="id_transaccion" value="<?php echo $_GET['id_transaccion']; ?>">
				<div class="input-group mb-2">
					<div class="col-md-6 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Código Seguridad:</span>
					</div>
					<input type="text" class="form-control col-md-6 p-0 m-0 px-2 rounded-0" name="codigo_seguridad" id="codigo_seguridad" placeholder="Código de seguridad" required autocomplete="off" title="Introduzca el código de seguridad para confirmar la vente">
				</div>
				<br>
				<div class="m-auto">
					<a href="zona_usuario_prod_vendidos.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Confirmar &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
		</div>
	<?php		
				}
			}
		}else{
	?>
		<br>
		<?php echo $mensaje_verf_entregado; ?>
			<?php
				//obteniendo los datos de la tabla de productos pagados:
				$datos_productos_pagados= M_control_de_transacciones_agrupa_x_codigo_seguridad( $conexion, 'COMPRADOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'ESTATUS', 'PAGADO', '', '');
				if(isset($datos_productos_pagados['CODIGO_DE_SEGURIDAD'][0])){
					if($datos_productos_pagados['CODIGO_DE_SEGURIDAD'][0]<>""){
			?>
				<!-- TABLA CON LOS PRODUCTOS PREMIUN PENDIENTES POR RECIBIR -->
			<div class="card mb-3 bg-dark rounded-0">
				<div class="card-header text-center text-warning">
					<h3 class='text-center'>Productos que aún no entregas:</h3>
				</div>
				<div class="card-body px-1 bg-white">
					<div class="table-responsive">
						<table class="table table-bordered table-hover TablaDinamica">
							<thead>
								<tr class="text-center">
									<th class="align-middle"><b title="Nombre del Producto, Cantidad, Monto Importe, Ranking del vendedor, Monto Comisión y Monto Recibido implicados en la transacción y Correo del Comprador">Producto</b></th>
									<th class="align-middle"><b title="Fecha de Pago, tipo de Venta, Estatus de la transacción y Evaluación (Estrellas)">Estatus</b></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$o=0;
								while(isset($datos_productos_pagados['CODIGO_DE_SEGURIDAD'][$o])){
									if($datos_productos_pagados['CODIGO_DE_SEGURIDAD'][$o]<>""){
										$datos= M_control_de_transacciones_compras_en_micoin_R($conexion, 'CODIGO_DE_SEGURIDAD', $datos_productos_pagados['CODIGO_DE_SEGURIDAD'][$o], '', '', '', '');
										if(isset($datos['ID_TRANSACCION'][1])){
											//PARA VENTAS DE VARIOS PRODUCTOS
											$datos_del_comprador=M_usuarios_R($conexion, 'CEDULA_RIF', $datos['COMPRADOR_CEDULA_RIF'][0], '', '', '', '');
											echo "<tr>";
											echo "<td class='text-left'><e class='text-light' style='font-size:1px;'>" . $o . "</e><b>Productos (Cantidad):</b> ";
											$sub_total_bruto=0;
											$sub_total_comision=0;
											$sub_total_neto=0;
											$i=0;
											while(isset($datos['ID_TRANSACCION'][$i])){
												if($datos['ID_TRANSACCION'][$i]<>""){
													echo "<br>" . $datos['NOMBRE_PRODUCTO'][$i] . " (" . $datos['CANTIDAD_COMPRADA'][$i] . ")";
													$sub_total_bruto= $sub_total_bruto+$datos['MONTO_BRUTO_MICOIN'][$i];
													$sub_total_comision= $sub_total_comision+$datos['MONTO_COMISION'][$i];
													$sub_total_neto= $sub_total_neto+$datos['MONTO_NETO'][$i];
												}
												$i++;
											}

											if($datos['ESTATUS'][0]=="ABANDONADO"){
												echo "<br><b class='text-danger'>No Aplica:</b><br>Venta abandonada<br>por el comprador";
											}else{
												echo "<br><b>Importe Pm:</b> " . number_format($sub_total_bruto, 2,',','.') . "<br><b>Ranking:</b> " . $datos['RANKING'][0] . "<br><b>Comisión Pm:</b> " . number_format($sub_total_comision, 2,',','.') . "<br><b>Pm Recibidos:</b> " . number_format($sub_total_neto, 2,',','.');
											}
											echo "<br><b class='text-danger small'>" . $datos['COMPRADOR_CORREO'][0] . "</b></td>";

											$fecha_i=explode(" ",$datos['FH_PAGADO'][0]);
											echo "<td class='text-left'><b>Pagó:</b> " . $fecha_i[0] . "<br><b>Venta:</b> " . $datos['TIPO_DE_COMPRA'][0] . "<br><b>Estatus:</b> " . $datos['ESTATUS'][0] . " ";
											if($datos['ESTATUS'][0]=='PAGADO'){
												echo "<br>(<a href='zona_usuario_prod_vendidos.php?accion=confirmar&id_transaccion=" . $datos['ID_TRANSACCION'][0] . "'>Ingresar Código</a>)";
											}
											echo "<br><b>Evaluación:</b><br><div class='px-1 small'>";
											echo M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][0]);
											echo "</div></td>";
											echo "</tr>";
										}else{
											//PARA VENTAS CON UN SOLO PRODUCTO
											$i=0;
											while(isset($datos['ID_TRANSACCION'][$i])){
												if($datos['ID_TRANSACCION'][$i]<>""){
													$datos_del_comprador=M_usuarios_R($conexion, 'CEDULA_RIF', $datos['COMPRADOR_CEDULA_RIF'][$i], '', '', '', '');
													echo "<tr>";
													echo "<td class='text-left'><e class='text-light' style='font-size:1px;'>" . $o . "</e><b>Productos (Cantidad):<br></b> " . $datos['NOMBRE_PRODUCTO'][$i] . " (" . $datos['CANTIDAD_COMPRADA'][$i] . ")<br><b>Importe Pm:</b> " . number_format($datos['MONTO_BRUTO_MICOIN'][$i], 2,',','.') . "<br><b>Ranking:</b> " . $datos['RANKING'][$i] . "<br><b>Comisión Pm:</b> " . number_format($datos['MONTO_COMISION'][$i], 2,',','.') . "<br><b>Pm Recibidos:</b> " . number_format($datos['MONTO_NETO'][$i], 2,',','.') . "<br><b class='text-danger'>" . $datos['COMPRADOR_CORREO'][$i] . "</b></td>";
													$fecha_i=explode(" ",$datos['FH_PAGADO'][$i]);
													echo "<td class='text-left'><b>Pagó:</b> " . $fecha_i[0] . "<br><b>Venta:</b> " . $datos['TIPO_DE_COMPRA'][$i] . "<br><b>Estatus:</b> " . $datos['ESTATUS'][$i] . " ";
													if($datos['ESTATUS'][$i]=='PAGADO'){
														echo "<br>(<a href='zona_usuario_prod_vendidos.php?accion=confirmar&id_transaccion=" . $datos['ID_TRANSACCION'][$i] . "'>Ingresar Código</a>)";
													}
													echo "<br><b>Evaluación:</b><br><div class='px-1 small'>";
													echo M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][$i]);
													echo "</div></td>";
													echo "</tr>";
												}
												$i=$i+1;
											}
										}
									}
									$o++;
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php
					}
				}
			?>
		
		
		
		
		
		<br>
		<div class="card mb-3 bg-dark rounded-0">
			<div class="card-header text-center text-warning">
				<h3 class='text-center'>Productos Vendidos:</h3>
			</div>
			<div class="card-body px-1 bg-white">
				<div class="table-responsive">
					<table class="table table-bordered table-hover TablaDinamica">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b title="Nombre del Producto, Cantidad, Monto Importe, Ranking del vendedor, Monto Comisión y Monto Recibido implicados en la transacción y Correo del Comprador">Producto</b></th>
								<th class="align-middle"><b title="Fecha de Pago, tipo de Venta, Estatus de la transacción y Evaluación (Estrellas)">Estatus</b></th>
							</tr>
						</thead>
						<tbody>
							<?php
							//obteniendo los datos de la tabla:
							$datos_codigos= M_control_de_transacciones_agrupa_x_codigo_seguridad( $conexion, 'VENDEDOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], '', '', '', '');
							$o=0;
							while(isset($datos_codigos['CODIGO_DE_SEGURIDAD'][$o])){
								if($datos_codigos['CODIGO_DE_SEGURIDAD'][$o]<>""){
									$datos= M_control_de_transacciones_compras_en_micoin_R($conexion, 'CODIGO_DE_SEGURIDAD', $datos_codigos['CODIGO_DE_SEGURIDAD'][$o], '', '', '', '');
									if(isset($datos['ID_TRANSACCION'][1])){
										//PARA VENTAS DE VARIOS PRODUCTOS
										$datos_del_comprador=M_usuarios_R($conexion, 'CEDULA_RIF', $datos['COMPRADOR_CEDULA_RIF'][0], '', '', '', '');
										echo "<tr>";
										echo "<td class='text-left'><e class='text-light' style='font-size:1px;'>" . $o . "</e><b>Productos (Cantidad):</b> ";
										$sub_total_bruto=0;
										$sub_total_comision=0;
										$sub_total_neto=0;
										$i=0;
										while(isset($datos['ID_TRANSACCION'][$i])){
											if($datos['ID_TRANSACCION'][$i]<>""){
												echo "<br>" . $datos['NOMBRE_PRODUCTO'][$i] . " (" . $datos['CANTIDAD_COMPRADA'][$i] . ")";
												$sub_total_bruto= $sub_total_bruto+$datos['MONTO_BRUTO_MICOIN'][$i];
												$sub_total_comision= $sub_total_comision+$datos['MONTO_COMISION'][$i];
												$sub_total_neto= $sub_total_neto+$datos['MONTO_NETO'][$i];
											}
											$i++;
										}
										
										if($datos['ESTATUS'][0]=="ABANDONADO"){
											echo "<br><b class='text-danger'>No Aplica:</b><br>Venta abandonada<br>por el comprador";
										}else{
											echo "<br><b>Importe Pm:</b> " . number_format($sub_total_bruto, 2,',','.') . "<br><b>Ranking:</b> " . $datos['RANKING'][0] . "<br><b>Comisión Pm:</b> " . number_format($sub_total_comision, 2,',','.') . "<br><b>Pm Recibidos:</b> " . number_format($sub_total_neto, 2,',','.');
										}
										echo "<br><b class='text-danger small'>" . $datos['COMPRADOR_CORREO'][0] . "</b></td>";
										
										$fecha_i=explode(" ",$datos['FH_PAGADO'][0]);
										echo "<td class='text-left'><b>Pagó:</b> " . $fecha_i[0] . "<br><b>Venta:</b> " . $datos['TIPO_DE_COMPRA'][0] . "<br><b>Estatus:</b> " . $datos['ESTATUS'][0] . " ";
										if($datos['ESTATUS'][0]=='PAGADO'){
											echo "<br>(<a href='zona_usuario_prod_vendidos.php?accion=confirmar&id_transaccion=" . $datos['ID_TRANSACCION'][0] . "'>Ingresar Código</a>)";
										}
										echo "<br><b>Evaluación:</b><br><div class='px-1 small'>";
										echo M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][0]);
										echo "</div></td>";
										echo "</tr>";
									}else{
										//PARA VENTAS CON UN SOLO PRODUCTO
										$i=0;
										while(isset($datos['ID_TRANSACCION'][$i])){
											if($datos['ID_TRANSACCION'][$i]<>""){
												$datos_del_comprador=M_usuarios_R($conexion, 'CEDULA_RIF', $datos['COMPRADOR_CEDULA_RIF'][$i], '', '', '', '');
												echo "<tr>";
												echo "<td class='text-left'><e class='text-light' style='font-size:1px;'>" . $o . "</e><b>Productos (Cantidad):<br></b> " . $datos['NOMBRE_PRODUCTO'][$i] . " (" . $datos['CANTIDAD_COMPRADA'][$i] . ")<br><b>Importe Pm:</b> " . number_format($datos['MONTO_BRUTO_MICOIN'][$i], 2,',','.') . "<br><b>Ranking:</b> " . $datos['RANKING'][$i] . "<br><b>Comisión Pm:</b> " . number_format($datos['MONTO_COMISION'][$i], 2,',','.') . "<br><b>Pm Recibidos:</b> " . number_format($datos['MONTO_NETO'][$i], 2,',','.') . "<br><b class='text-danger'>" . $datos['COMPRADOR_CORREO'][$i] . "</b></td>";
												$fecha_i=explode(" ",$datos['FH_PAGADO'][$i]);
												echo "<td class='text-left'><b>Pagó:</b> " . $fecha_i[0] . "<br><b>Venta:</b> " . $datos['TIPO_DE_COMPRA'][$i] . "<br><b>Estatus:</b> " . $datos['ESTATUS'][$i] . " ";
												if($datos['ESTATUS'][$i]=='PAGADO'){
													echo "<br>(<a href='zona_usuario_prod_vendidos.php?accion=confirmar&id_transaccion=" . $datos['ID_TRANSACCION'][$i] . "'>Ingresar Código</a>)";
												}
												echo "<br><b>Evaluación:</b><br><div class='px-1 small'>";
												echo M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][$i]);
												echo "</div></td>";
												echo "</tr>";
											}
											$i=$i+1;
										}
									}
								}
								$o++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<?php		
		}
	?>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>