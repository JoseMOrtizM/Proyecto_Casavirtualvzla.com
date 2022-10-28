<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	$comentario="";
	if(isset($_POST['ACCION'])){
		if($_POST['ACCION']=='RECHAZAR'){
			$id_trans=mysqli_real_escape_string($conexion, $_POST['id_trans']);
			$cod_seg=mysqli_real_escape_string($conexion, $_POST['cod_seg']);
			$verf_i=M_control_de_transacciones_micoin_rechazar_compra_cod_seg($conexion, $cod_seg);
			if($verf_i==true){
				$comentario="<h2 class='text-center bg-success text-dark'>Operación Abandonada con ÉXITO</h2>";
				$datos_abandonados=M_control_de_transacciones_compras_en_micoin_R($conexion, 'CODIGO_DE_SEGURIDAD', $cod_seg, '', '', '', '');
				//insertando datos en MC_BALANCE ADMINISTRATIVO Y EN MC_PARIDAD_CAMBIARIA
				$datos_previos_balance=M_balance_administrativo_lcv_R_ultimo($conexion);
				$fecha_ii=date("Y-m-d h:m:s");
				$cta=0;
				while(isset($datos_abandonados['ID_TRANSACCION'][$cta])){
					M_balance_administrativo_lcv_PRECALCULOS($conexion, $fecha_ii, "RECHAZAR COMPRA PROD PREMIUN", "", "", $datos_previos_balance['TC_BS_DOLLAR'][0], "", $datos_abandonados['ID_TRANSACCION'][$cta]);
					$cta++;
				}
			}else{
				$comentario="<h2 class='text-center bg-danger text-dark'>La Operación No se pudo Abandonar... Intentelo más tarde</h2>";
			}
		}
	}
	if(isset($_POST['evaluacion_puntos'])){
		$id_trans=mysqli_real_escape_string($conexion, $_POST['id_trans']);
		$cod_seg=mysqli_real_escape_string($conexion, $_POST['cod_seg']);
		$eval_ptos=mysqli_real_escape_string($conexion, $_POST['evaluacion_puntos']);
		$eval_cmt=mysqli_real_escape_string($conexion, $_POST['evaluacion_comentario']);
		$datos_evaluados=M_control_de_transacciones_compras_en_micoin_R($conexion, 'CODIGO_DE_SEGURIDAD', $cod_seg, '', '', '', '');
		$fecha_ii=date("Y-m-d h:m:s");
		$cta=0;
		while(isset($datos_evaluados['ID_TRANSACCION'][$cta])){
			M_control_de_transacciones_micoin_U_evaluacion($conexion, $datos_evaluados['ID_TRANSACCION'][$cta], $fecha_ii, $eval_ptos, $eval_cmt);
			$cta++;
		}
		$comentario="<h2 class='text-center bg-success text-dark'>Evaluación registrada con ÉXITO</h2>";
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Prod Comprados</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid px-0 mx-0 mx-md-2 px-md-4 mt-2 mb-5 bg-secondary">
	<?php
	if(isset($_GET['OPER'])){
		$operacion=mysqli_real_escape_string($conexion, $_GET['OPER']);
		if($operacion=='EVALUAR'){
			if(isset($_GET['id_transaccion'])){
				$id_transaccion=mysqli_real_escape_string($conexion, $_GET['id_transaccion']);
				$datos_transaccion=M_control_de_transacciones_compras_en_micoin_R($conexion, 'ID_TRANSACCION', $id_transaccion, '', '', '', '');
				if($datos_transaccion['ID_TRANSACCION'][0]<>''){
					//formulario de evaluación
					$datos_vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $datos_transaccion['VENDEDOR_CEDULA_RIF'][0], '', '', '', '');
		?>
			<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
				<div class="row mt-4 align-items-center rounded-top px-2">
					<div class="col-md-9 mb-1 mt-3">
						<h3 class="text-center text-md-left text-warning">Evaluar Compra:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1 mt-3">
						<a href="zona_usuario_prod_comprados.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="zona_usuario_prod_comprados.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="ACCION" id="ACCION" value="EVALUAR">
					<input type="hidden" name="id_trans" id="id_trans" value="<?php echo $datos_transaccion['ID_TRANSACCION'][0]; ?>">
					<input type="hidden" name="cod_seg" id="cod_seg" value="<?php echo $datos_transaccion['CODIGO_DE_SEGURIDAD'][0]; ?>">
					<div class="input-group mb-2 bg-light">
						<div class="container-fluid p-0">
							<div class="row">
								<div class="col-md-3 pt-2">
									<img src="IMAGENES_USUARIOS/<?php echo $datos_vendedor['FOTO_LOGO'][0] . "?a=" . rand(); ?>" class="imgFit rounded-circle w-75">
								</div>
								<div class="col-md-9 text-left pl-3">
									<b>Vendedor: </b><?php echo $datos_vendedor['NOMBRE'][0] . " " . $datos_vendedor['APELLIDO'][0]; ?><br>
									<b>Correo: </b><b class="text-danger"><?php echo $datos_vendedor['CORREO'][0]; ?></b><br>
									<b>Reputación del Vendedor: </b><?php $puntaje=M_reputacion_por_usuario($conexion, $datos_transaccion['VENDEDOR_CEDULA_RIF'][0]); echo M_dibuja_estrellas($puntaje['PUNTOS'][0]); ?><br>
									<b>Producto: </b><?php echo $datos_transaccion['NOMBRE_PRODUCTO'][0]; ?><br>
									<b>Cantidad Comprada: </b><?php echo $datos_transaccion['CANTIDAD_COMPRADA'][0]; ?><br>
									<b>Monto Pagado: </b><?php echo $datos_transaccion['MONTO_BRUTO_MICOIN'][0]; ?>
								</div>
							</div>
						</div>
					</div>
					<h5 class="text-center text-warning">Datos de Evaluación:</h5>
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Puntos:</span>
						</div>
						<div class="form-control col-md-9 p-0 m-0 px-2 rounded-0">
							<?php
								if($datos_transaccion['EVALUACION_PUNTOS'][0]=='5'){
									echo "<h3 class='text-warning'>
										<span id='estrella_1' class='fa fa-star'></span>
										<span id='estrella_2' class='fa fa-star'></span>
										<span id='estrella_3' class='fa fa-star'></span>
										<span id='estrella_4' class='fa fa-star'></span>
										<span id='estrella_5' class='fa fa-star'></span>
									</h3>";
								}else if($datos_transaccion['EVALUACION_PUNTOS'][0]=='4'){
									echo "<h3 class='text-warning'>
										<span id='estrella_1' class='fa fa-star'></span>
										<span id='estrella_2' class='fa fa-star'></span>
										<span id='estrella_3' class='fa fa-star'></span>
										<span id='estrella_4' class='fa fa-star'></span>
										<span id='estrella_5' class='fa fa-star-o'></span>
									</h3>";
								}else if($datos_transaccion['EVALUACION_PUNTOS'][0]=='3'){
									echo "<h3 class='text-warning'>
										<span id='estrella_1' class='fa fa-star'></span>
										<span id='estrella_2' class='fa fa-star'></span>
										<span id='estrella_3' class='fa fa-star'></span>
										<span id='estrella_4' class='fa fa-star-o'></span>
										<span id='estrella_5' class='fa fa-star-o'></span>
									</h3>";
								}else if($datos_transaccion['EVALUACION_PUNTOS'][0]=='2'){
									echo "<h3 class='text-warning'>
										<span id='estrella_1' class='fa fa-star'></span>
										<span id='estrella_2' class='fa fa-star'></span>
										<span id='estrella_3' class='fa fa-star-o'></span>
										<span id='estrella_4' class='fa fa-star-o'></span>
										<span id='estrella_5' class='fa fa-star-o'></span>
									</h3>";
								}else if($datos_transaccion['EVALUACION_PUNTOS'][0]=='1'){
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
							if($datos_transaccion['EVALUACION_PUNTOS'][0]=='5'){
								echo "<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='5'>";
							}else if($datos_transaccion['EVALUACION_PUNTOS'][0]=='4'){
								echo "<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='4'>";
							}else if($datos_transaccion['EVALUACION_PUNTOS'][0]=='3'){
								echo "<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='3'>";
							}else if($datos_transaccion['EVALUACION_PUNTOS'][0]=='2'){
								echo "<input type='hidden' name='evaluacion_puntos' id='evaluacion_puntos' value='2'>";
							}else if($datos_transaccion['EVALUACION_PUNTOS'][0]=='1'){
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
						<textarea class="form-control p-0 m-0 px-2 rounded-0" name="evaluacion_comentario" id="evaluacion_comentario" placeholder="Comentario de la Evaluación (Opcional)" autocomplete="off" title="Introduzca el Comentario de la Evaluación del comprador (Opcional)" rows="3"><?php echo $datos_transaccion['EVALUACION_COMENTARIO'][0]; ?></textarea>
					</div>
					<div class="m-auto">
						<a href="zona_usuario_prod_comprados.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Registrar Evaluación" class="btn btn-warning mb-2">
					</div>
				</form>
			</div>
		<?php
				}else{
					//mensaje de error
					echo "EL INDICE INTRODUCIDO NO ES CORRECTO";
				}
			}
		}else if($operacion=='RECHAZAR'){
			if(isset($_GET['id_transaccion'])){
				$id_transaccion=mysqli_real_escape_string($conexion, $_GET['id_transaccion']);
				$datos_transaccion=M_control_de_transacciones_compras_en_micoin_R($conexion, 'ID_TRANSACCION', $id_transaccion, '', '', '', '');
				$datos_rechazar= M_control_de_transacciones_compras_en_micoin_R($conexion, 'CODIGO_DE_SEGURIDAD', $datos_transaccion['CODIGO_DE_SEGURIDAD'][0], '', '', '', '');
				if($datos_transaccion['ID_TRANSACCION'][0]<>''){
				?>	
					<br><br><br>
					<div class="col-md-12 col-lg-9 mx-auto">
						<form action="zona_usuario_prod_comprados.php" method="post" class="text-center bg-dark p-2 rounded">
							<h3 class="text-center text-warning" title="Rechazar Operación">¿Seguro que desea Rechazar esta compra?</h3>
								<?php
									echo "<h6 class='text-left text-light mb-3 px-4 mx-5'><b>Productos (Cantidad):</b><br>";
									$cta_prod=0;
									while(isset($datos_rechazar['NOMBRE_PRODUCTO'][$cta_prod])){
										echo $datos_rechazar['NOMBRE_PRODUCTO'][$cta_prod] . " (" . $datos_rechazar['CANTIDAD_COMPRADA'][$cta_prod] . ")<br>";
										$cta_prod++;
									}
									echo "<b>";
									if($datos_rechazar['TIPO_DE_COMPRA'][0]=="EXPRESS"){
										echo "Código de Transacción";
									}else{
										echo "Código de Segridad";
									}
									echo ":</b> <b class='text-success'>" . $datos_rechazar['CODIGO_DE_SEGURIDAD'][0] . "</b><br><b>Monto Total Pm:</b> " . number_format($datos_rechazar['MONTO_BRUTO_MICOIN'][0], 2,',','.') . "</h6>";
								?>
							<input type="hidden" name="ACCION" id="ACCION" value="RECHAZAR">
							<input type="hidden" name="id_trans" id="id_trans" value="<?php echo $datos_transaccion['ID_TRANSACCION'][0]; ?>">
							<input type="hidden" name="cod_seg" id="cod_seg" value="<?php echo $datos_rechazar['CODIGO_DE_SEGURIDAD'][0]; ?>">
							<div class="m-auto">
								<a href="zona_usuario_prod_comprados.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Rechazar Compra &raquo;" class="btn btn-warning mb-2">
							</div>
						</form>
						<br><br><br><br><br><br><br><br>
					</div>
				<?php
				}else{
					//mensaje de error
					echo "EL INDICE INTRODUCIDO NO ES CORRECTO";
				}
			}
		}else{
			//mensaje de error
			echo "LA OPERACION INTRODUCIDA NO ES CORRECTA";
		}
	}else{	
	?>
		<br>
			<?php echo $comentario; ?>
			<?php
				//obteniendo los datos de la tabla de productos pagados:
				$datos_productos_pagados= M_control_de_transacciones_agrupa_x_codigo_seguridad( $conexion, 'COMPRADOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'ESTATUS', 'PAGADO', '', '');
				if(isset($datos_productos_pagados['CODIGO_DE_SEGURIDAD'][0])){
					if($datos_productos_pagados['CODIGO_DE_SEGURIDAD'][0]<>""){
			?>
				<!-- TABLA CON LOS PRODUCTOS PREMIUN PENDIENTES POR RECIBIR -->
			<div class="card mb-3 bg-dark rounded-0">
				<div class="card-header text-center text-warning">
					<h3 class='text-center'>Productos que aún no Recibes:</h3>
				</div>
				<div class="card-body px-1 bg-white">
					<div class="table-responsive">
						<table class="table table-bordered table-hover TablaDinamica">
							<thead>
								<tr class="text-center">
									<th class="align-middle"><b title="Nombre del Producto, Cantidad, Código de Seguridad de la Compra y Monto Bruto implicado en la compra y Correo del Vendedor">Producto</b></th>
									<th class="align-middle"><b title="Fecha de Pago, Tipo de Compra, Estatus de la transacción y Evaluación (Estrellas)">Estatus</b></th>
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
											$datos_del_vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $datos['VENDEDOR_CEDULA_RIF'][0], '', '', '', '');
											echo "<tr>";
											echo "<td class='text-left'><e class='text-light' style='font-size:1px;'>" . $o . "</e><b>Productos (Cantidad):</b>";
											$sub_total_comprado=0;
											$i=0;
											while(isset($datos['ID_TRANSACCION'][$i])){
												if($datos['ID_TRANSACCION'][$i]<>""){
													echo "<br>" . $datos['NOMBRE_PRODUCTO'][$i] . " (" . $datos['CANTIDAD_COMPRADA'][$i] . ")";
													$sub_total_comprado= $sub_total_comprado+$datos['MONTO_BRUTO_MICOIN'][$i];
												}
												$i++;
											}
											echo "<br>";
											if($datos['TIPO_DE_COMPRA'][0]=="EXPRESS"){
												echo "<b title='Código de Transacción'>CdT:</b> ";
											}else{
												echo "<b title='Código de Segridad'>CdS:</b> ";
											}
											echo "<b class='text-success small'>" . $datos['CODIGO_DE_SEGURIDAD'][0] . "</b><br><b>Pm:</b> " . number_format($sub_total_comprado, 2,',','.') . "<br><b class='text-danger small'>" . $datos['VENDEDOR_CORREO'][0] . "</b></td>";

											$fecha_i=explode(" ",$datos['FH_PAGADO'][0]);
											echo "<td class='text-left'><b>Pagó el:</b> " . $fecha_i[0] . "<br><b>Compra: </b>" . $datos['TIPO_DE_COMPRA'][0] . "<br><b>Estatus:</b> " . $datos['ESTATUS'][0];
											if($datos['ESTATUS'][0]=='PAGADO'){
												echo " <span class='text-danger fa fa-bell' title='Entrega el código de seguridad de esta compra al vendedor para registrar el cobro'></span>";
												echo "<br><a class='text-danger' href='zona_usuario_prod_comprados.php?id_transaccion=" . $datos['ID_TRANSACCION'][0] . "&OPER=RECHAZAR'><b>Rechazar Compra</b></a>";
											}
											echo "<br><b>Evaluación:</b><br><div ";
											if(M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][0])=="<b class='text-danger'>&nbspSin Evaluar</b>"){
												echo "class='px-0'><a href='zona_usuario_prod_comprados.php?id_transaccion=" . $datos['ID_TRANSACCION'][0] . "&OPER=EVALUAR' class='mx-0 text-primary'><b>Evaluar</b></a>";
											}else{
												echo "class='px-1 small'>" .  M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][0]);
											}
											echo "</div></td>";
											echo "</tr>";

										}else{
											//PARA VENTAS DE UN SOLO PRODUCTO
											$datos_del_vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $datos['VENDEDOR_CEDULA_RIF'][0], '', '', '', '');
											echo "<tr>";
											echo "<td class='text-left'><e class='text-light' style='font-size:1px;'>" . $o . "</e><b>Productos (Cantidad):</b><br>" . $datos['NOMBRE_PRODUCTO'][0] . " (" . $datos['CANTIDAD_COMPRADA'][0] . ")<br>";
											if($datos['TIPO_DE_COMPRA'][0]=="EXPRESS"){
												echo "<b title='Código de Transacción'>CdT:</b> ";
											}else{
												echo "<b title='Código de Segridad'>CdS:</b> ";
											}
											echo "<b class='text-success'>" . $datos['CODIGO_DE_SEGURIDAD'][0] . "</b><br><b>Pm:</b> " . number_format($datos['MONTO_BRUTO_MICOIN'][0], 2,',','.') . "<br><b class='text-danger small'>" . $datos['VENDEDOR_CORREO'][0] . "</b></td>";
											$fecha_i=explode(" ",$datos['FH_PAGADO'][0]);
											echo "<td class='text-left'><b>Pagó el:</b> " . $fecha_i[0] . "<br><b>Compra: </b>" . $datos['TIPO_DE_COMPRA'][0] . "<br><b>Estatus:</b> " . $datos['ESTATUS'][0];
											if($datos['ESTATUS'][0]=='PAGADO'){
												echo " <span class='text-danger fa fa-bell' title='Entrega el código de seguridad de esta compra al vendedor para registrar el cobro'></span>";
												echo "<br><a class='text-danger' href='zona_usuario_prod_comprados.php?id_transaccion=" . $datos['ID_TRANSACCION'][0] . "&OPER=RECHAZAR'><b>Rechazar Compra</b></a>";
											}
											echo "<br><b>Evaluación:</b><br><div ";
											if(M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][0])=="<b class='text-danger'>&nbspSin Evaluar</b>"){
												echo "class='px-0'><a href='zona_usuario_prod_comprados.php?id_transaccion=" . $datos['ID_TRANSACCION'][0] . "&OPER=EVALUAR' class='mx-0 text-primary'><b>Evaluar</b></a>";
											}else{
												echo "class='px-1 small'>" .  M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][0]);
											}
											echo "</div></td>";
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
			</div>
			<?php
					}
				}
				//obteniendo los datos de la tabla de productos pagados:
				$datos_productos_sin_evaluar= M_control_de_transacciones_agrupa_x_codigo_seguridad_sin_evaluar( $conexion, 'COMPRADOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], '', '', '', '');
				if(isset($datos_productos_sin_evaluar['CODIGO_DE_SEGURIDAD'][0])){
					if($datos_productos_sin_evaluar['CODIGO_DE_SEGURIDAD'][0]<>""){
			?>
				<br>
			<div class="card mb-3 bg-dark rounded-0">
				<!-- TABLA CON TODOS LOS PRODUCTOS SIN EVALUAR -->
				<div class="card-header text-center text-warning">
					<h3 class='text-center'>Productos que aún no evalúas:</h3>
				</div>
				<div class="card-body px-1 bg-white">
					<div class="table-responsive">
						<table class="table table-bordered table-hover TablaDinamica">
							<thead>
								<tr class="text-center">
									<th class="align-middle"><b title="Nombre del Producto, Cantidad, Código de Seguridad de la Compra y Monto Bruto implicado en la compra y Correo del Vendedor">Producto</b></th>
									<th class="align-middle"><b title="Fecha de Pago, Tipo de Compra, Estatus de la transacción y Evaluación (Estrellas)">Estatus</b></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$o=0;
								while(isset($datos_productos_sin_evaluar['CODIGO_DE_SEGURIDAD'][$o])){
									if($datos_productos_sin_evaluar['CODIGO_DE_SEGURIDAD'][$o]<>""){
										$datos= M_control_de_transacciones_compras_en_micoin_R($conexion, 'CODIGO_DE_SEGURIDAD', $datos_productos_sin_evaluar['CODIGO_DE_SEGURIDAD'][$o], '', '', '', '');
										if(isset($datos['ID_TRANSACCION'][1])){
											//PARA VENTAS DE VARIOS PRODUCTOS
											$datos_del_vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $datos['VENDEDOR_CEDULA_RIF'][0], '', '', '', '');
											echo "<tr>";
											echo "<td class='text-left'><e class='text-light' style='font-size:1px;'>" . $o . "</e><b>Productos (Cantidad):</b>";
											$sub_total_comprado=0;
											$i=0;
											while(isset($datos['ID_TRANSACCION'][$i])){
												if($datos['ID_TRANSACCION'][$i]<>""){
													echo "<br>" . $datos['NOMBRE_PRODUCTO'][$i] . " (" . $datos['CANTIDAD_COMPRADA'][$i] . ")";
													$sub_total_comprado= $sub_total_comprado+$datos['MONTO_BRUTO_MICOIN'][$i];
												}
												$i++;
											}
											echo "<br>";
											if($datos['TIPO_DE_COMPRA'][0]=="EXPRESS"){
												echo "<b title='Código de Transacción'>CdT:</b> ";
											}else{
												echo "<b title='Código de Segridad'>CdS:</b> ";
											}
											echo "<b class='text-success small'>" . $datos['CODIGO_DE_SEGURIDAD'][0] . "</b><br><b>Pm:</b> " . number_format($sub_total_comprado, 2,',','.') . "<br><b class='text-danger small'>" . $datos['VENDEDOR_CORREO'][0] . "</b></td>";

											$fecha_i=explode(" ",$datos['FH_PAGADO'][0]);
											echo "<td class='text-left'><b>Pagó el:</b> " . $fecha_i[0] . "<br><b>Compra: </b>" . $datos['TIPO_DE_COMPRA'][0] . "<br><b>Estatus:</b> " . $datos['ESTATUS'][0];
											if($datos['ESTATUS'][0]=='PAGADO'){
												echo " <span class='text-danger fa fa-bell' title='Entrega el código de seguridad de esta compra al vendedor para registrar el cobro'></span>";
												echo "<br><a class='text-danger' href='zona_usuario_prod_comprados.php?id_transaccion=" . $datos['ID_TRANSACCION'][0] . "&OPER=RECHAZAR'><b>Rechazar Compra</b></a>";
											}
											echo "<br><b>Evaluación:</b><br><div ";
											if(M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][0])=="<b class='text-danger'>&nbspSin Evaluar</b>"){
												echo "class='px-0'><a href='zona_usuario_prod_comprados.php?id_transaccion=" . $datos['ID_TRANSACCION'][0] . "&OPER=EVALUAR' class='mx-0 text-primary'><b>Evaluar</b></a>";
											}else{
												echo "class='px-1 small'>" .  M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][0]);
											}
											echo "</div></td>";
											echo "</tr>";

										}else{
											//PARA VENTAS DE UN SOLO PRODUCTO
											$datos_del_vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $datos['VENDEDOR_CEDULA_RIF'][0], '', '', '', '');
											echo "<tr>";
											echo "<td class='text-left'><e class='text-light' style='font-size:1px;'>" . $o . "</e><b>Productos (Cantidad):</b><br>" . $datos['NOMBRE_PRODUCTO'][0] . " (" . $datos['CANTIDAD_COMPRADA'][0] . ")<br>";
											if($datos['TIPO_DE_COMPRA'][0]=="EXPRESS"){
												echo "<b title='Código de Transacción'>CdT:</b> ";
											}else{
												echo "<b title='Código de Segridad'>CdS:</b> ";
											}
											echo "<b class='text-success'>" . $datos['CODIGO_DE_SEGURIDAD'][0] . "</b><br><b>Pm:</b> " . number_format($datos['MONTO_BRUTO_MICOIN'][0], 2,',','.') . "<br><b class='text-danger small'>" . $datos['VENDEDOR_CORREO'][0] . "</b></td>";
											$fecha_i=explode(" ",$datos['FH_PAGADO'][0]);
											echo "<td class='text-left'><b>Pagó el:</b> " . $fecha_i[0] . "<br><b>Compra: </b>" . $datos['TIPO_DE_COMPRA'][0] . "<br><b>Estatus:</b> " . $datos['ESTATUS'][0];
											if($datos['ESTATUS'][0]=='PAGADO'){
												echo " <span class='text-danger fa fa-bell' title='Entrega el código de seguridad de esta compra al vendedor para registrar el cobro'></span>";
												echo "<br><a class='text-danger' href='zona_usuario_prod_comprados.php?id_transaccion=" . $datos['ID_TRANSACCION'][0] . "&OPER=RECHAZAR'><b>Rechazar Compra</b></a>";
											}
											echo "<br><b>Evaluación:</b><br><div ";
											if(M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][0])=="<b class='text-danger'>&nbspSin Evaluar</b>"){
												echo "class='px-0'><a href='zona_usuario_prod_comprados.php?id_transaccion=" . $datos['ID_TRANSACCION'][0] . "&OPER=EVALUAR' class='mx-0 text-primary'><b>Evaluar</b></a>";
											}else{
												echo "class='px-1 small'>" .  M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][0]);
											}
											echo "</div></td>";
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
			</div>
			<?php
					}
				}
			?>
			<br>
		<div class="card mb-3 bg-dark rounded-0">
			<!-- TABLA CON TODOS LOS PRODUCTOS COMPRADOS POR EL USUARIO -->
			<div class="card-header text-center text-warning">
				<h3 class='text-center'>Productos Comprados:</h3>
			</div>
			<div class="card-body px-1 bg-white">
				<div class="table-responsive">
					<table class="table table-bordered table-hover TablaDinamica">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b title="Nombre del Producto, Cantidad, Código de Seguridad de la Compra y Monto Bruto implicado en la compra y Correo del Vendedor">Producto</b></th>
								<th class="align-middle"><b title="Fecha de Pago, Tipo de Compra, Estatus de la transacción y Evaluación (Estrellas)">Estatus</b></th>
							</tr>
						</thead>
						<tbody>
							<?php
							//obteniendo los datos de la tabla:
							$datos_codigos= M_control_de_transacciones_agrupa_x_codigo_seguridad( $conexion, 'COMPRADOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], '', '', '', '');
							$o=0;
							while(isset($datos_codigos['CODIGO_DE_SEGURIDAD'][$o])){
								if($datos_codigos['CODIGO_DE_SEGURIDAD'][$o]<>""){
									$datos= M_control_de_transacciones_compras_en_micoin_R($conexion, 'CODIGO_DE_SEGURIDAD', $datos_codigos['CODIGO_DE_SEGURIDAD'][$o], '', '', '', '');
									if(isset($datos['ID_TRANSACCION'][1])){
										//PARA VENTAS DE VARIOS PRODUCTOS
										$datos_del_vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $datos['VENDEDOR_CEDULA_RIF'][0], '', '', '', '');
										echo "<tr>";
										echo "<td class='text-left'><e class='text-light' style='font-size:1px;'>" . $o . "</e><b>Productos (Cantidad):</b>";
										$sub_total_comprado=0;
										$i=0;
										while(isset($datos['ID_TRANSACCION'][$i])){
											if($datos['ID_TRANSACCION'][$i]<>""){
												echo "<br>" . $datos['NOMBRE_PRODUCTO'][$i] . " (" . $datos['CANTIDAD_COMPRADA'][$i] . ")";
												$sub_total_comprado= $sub_total_comprado+$datos['MONTO_BRUTO_MICOIN'][$i];
											}
											$i++;
										}
										echo "<br>";
										if($datos['TIPO_DE_COMPRA'][0]=="EXPRESS"){
											echo "<b title='Código de Transacción'>CdT:</b> ";
										}else{
											echo "<b title='Código de Segridad'>CdS:</b> ";
										}
										echo "<b class='text-success small'>" . $datos['CODIGO_DE_SEGURIDAD'][0] . "</b><br><b>Pm:</b> " . number_format($sub_total_comprado, 2,',','.') . "<br><b class='text-danger small'>" . $datos['VENDEDOR_CORREO'][0] . "</b></td>";
										
										$fecha_i=explode(" ",$datos['FH_PAGADO'][0]);
										echo "<td class='text-left'><b>Pagó el:</b> " . $fecha_i[0] . "<br><b>Compra: </b>" . $datos['TIPO_DE_COMPRA'][0] . "<br><b>Estatus:</b> " . $datos['ESTATUS'][0];
										if($datos['ESTATUS'][0]=='PAGADO'){
											echo " <span class='text-danger fa fa-bell' title='Entrega el código de seguridad de esta compra al vendedor para registrar el cobro'></span>";
											echo "<br><a class='text-danger' href='zona_usuario_prod_comprados.php?id_transaccion=" . $datos['ID_TRANSACCION'][0] . "&OPER=RECHAZAR'><b>Rechazar Compra</b></a>";
										}
										echo "<br><b>Evaluación:</b><br><div ";
										if(M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][0])=="<b class='text-danger'>&nbspSin Evaluar</b>"){
											echo "class='px-0'><a href='zona_usuario_prod_comprados.php?id_transaccion=" . $datos['ID_TRANSACCION'][0] . "&OPER=EVALUAR' class='mx-0 text-primary'><b>Evaluar</b></a>";
										}else{
											echo "class='px-1 small'>" .  M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][0]);
										}
										echo "</div></td>";
										echo "</tr>";
										
									}else{
										//PARA VENTAS DE UN SOLO PRODUCTO
										$datos_del_vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $datos['VENDEDOR_CEDULA_RIF'][0], '', '', '', '');
										echo "<tr>";
										echo "<td class='text-left'><e class='text-light' style='font-size:1px;'>" . $o . "</e><b>Productos (Cantidad):</b><br>" . $datos['NOMBRE_PRODUCTO'][0] . " (" . $datos['CANTIDAD_COMPRADA'][0] . ")<br>";
										if($datos['TIPO_DE_COMPRA'][0]=="EXPRESS"){
											echo "<b title='Código de Transacción'>CdT:</b> ";
										}else{
											echo "<b title='Código de Segridad'>CdS:</b> ";
										}
										echo "<b class='text-success'>" . $datos['CODIGO_DE_SEGURIDAD'][0] . "</b><br><b>Pm:</b> " . number_format($datos['MONTO_BRUTO_MICOIN'][0], 2,',','.') . "<br><b class='text-danger small'>" . $datos['VENDEDOR_CORREO'][0] . "</b></td>";
										$fecha_i=explode(" ",$datos['FH_PAGADO'][0]);
										echo "<td class='text-left'><b>Pagó el:</b> " . $fecha_i[0] . "<br><b>Compra: </b>" . $datos['TIPO_DE_COMPRA'][0] . "<br><b>Estatus:</b> " . $datos['ESTATUS'][0];
										if($datos['ESTATUS'][0]=='PAGADO'){
											echo " <span class='text-danger fa fa-bell' title='Entrega el código de seguridad de esta compra al vendedor para registrar el cobro'></span>";
											echo "<br><a class='text-danger' href='zona_usuario_prod_comprados.php?id_transaccion=" . $datos['ID_TRANSACCION'][0] . "&OPER=RECHAZAR'><b>Rechazar Compra</b></a>";
										}
										echo "<br><b>Evaluación:</b><br><div ";
										if(M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][0])=="<b class='text-danger'>&nbspSin Evaluar</b>"){
											echo "class='px-0'><a href='zona_usuario_prod_comprados.php?id_transaccion=" . $datos['ID_TRANSACCION'][0] . "&OPER=EVALUAR' class='mx-0 text-primary'><b>Evaluar</b></a>";
										}else{
											echo "class='px-1 small'>" .  M_dibuja_estrellas($datos['EVALUACION_PUNTOS'][0]);
										}
										echo "</div></td>";
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
		</div>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<?php
		}
	?>	
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>