<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	//VERIFICANDO DURACIÓN DEL SERVICIO Y ANULANDOLO EN CASO DE SER NECESARIO
	if($datos_usuario_session['ALIADO'][0]=='SI'){
		$datos_serv_ali_i= M_control_de_transacciones_compras_en_micoin_R($conexion, 'COMPRADOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'NOMBRE_PRODUCTO', 'ALIADO - CASA VIRTUAL', '', '');
		$i=0;
		$fh_ultima_compra_i="";
		while(isset($datos_serv_ali_i['ID_TRANSACCION'][$i])){
			if($datos_serv_ali_i['ID_TRANSACCION'][$i]<>""){
				$fh_ultima_compra=$datos_serv_ali_i['FH_PAGADO'][$i];
			}
			$i++;
		}
		if($fh_ultima_compra<>""){
			$fecha_compra_mas=date("Y-m-d",strtotime($fh_ultima_compra."+ 365 days"));
			$fecha_compra=explode(" ", $fecha_compra_mas);
			$datetime1 = new DateTime(date("Y-m-d"));
			$datetime2 = new DateTime($fecha_compra[0]);
			$interval = $datetime1->diff($datetime2);
			$diferencia=$interval->format('%R%a');
			if($diferencia<=0){
				// como no queda tiempo entonces eliminanos la suscripción
				M_usuarios_U_id_aliado($conexion, $datos_usuario_session['ID_USUARIO'][0], 'NO');
				header("location:zona_usuario_aliados.php");
			}
		}
	}
?>
<?php
	//SI SE QUIERE COMPRAR EL SERVICIO DE ALIADOS ENTONCES:
	$verf_1=false;
	$verf_2=false;
	$verf_compra_aliados=false;
	$costo_del_servicio_de_aliados=10;
	if(isset($_POST['FORM'])){
		if($_POST['FORM']=='COMPRAR_ALIADO'){
			$fecha_ii=$_POST['fh_registro'];
			//CARGANDO UNA TRANSACCIÓN AL REGISTRO
			$verf_1=M_control_de_transacciones_micoin_C($conexion, $datos_usuario_session['NOMBRE'][0], $datos_usuario_session['APELLIDO'][0], $datos_usuario_session['CEDULA_RIF'][0], $datos_usuario_session['CORREO'][0], $datos_usuario_session['FECHA_NACIMIENTO'][0], $datos_usuario_session['EMPRESA'][0], $datos_usuario_session['TELEFONO'][0], $datos_usuario_session['DIRECCION'][0], 'CASA', 'VIRTUAL', 'N/A', 'N/A', '2020-01-01', 'SI', 'N/A', 'N/A', 'EXPRESS', $_POST['nombre_producto'], '1', $_POST['precio_unitario_micoin'], $_POST['precio_unitario_micoin'], 'DIAMANTE', '100', $_POST['precio_unitario_micoin'], '0', $fecha_ii, $fecha_ii, '0000-00-00 00:00:00', $fecha_ii, '5', 'COMPRA DE ALIADO', 'ENTREGADO');
			//ACTUALIZANDO LOS DATOS DEL USUARIO
			if($verf_1){
				$verf_2=M_usuarios_U_id_aliado($conexion, $datos_usuario_session['ID_USUARIO'][0], 'SI');
			}
			if($verf_1 and $verf_2){
				//ACTUALIZANDO CODIGO DE VERIFICACIÓN SI EL REGISTRO ANTERIOR FUÉ EXITOSO
				$datos_id_de_la_transaccion=M_control_de_transacciones_obtener_id($conexion, $datos_usuario_session['CEDULA_RIF'][0], 'N/A', "1", $_POST['nombre_producto'], $fecha_ii);
				$datos_seguridad=M_generar_codigo_seguridad($conexion, $datos_usuario_session['CEDULA_RIF'][0], $datos_id_de_la_transaccion['ID_TRANSACCION'][0]);
				//insertando datos en MC_BALANCE ADMINISTRATIVO Y EN MC_PARIDAD_CAMBIARIA
				$datos_previos_balance=M_balance_administrativo_lcv_R_ultimo($conexion);
				$verf_adm_y_pc=M_balance_administrativo_lcv_PRECALCULOS($conexion, $fecha_ii, "COMPRA PROD", "", "", $datos_previos_balance['TC_BS_DOLLAR'][0], "", $datos_id_de_la_transaccion['ID_TRANSACCION'][0]);
				$verf_compra_aliados="<h3 class='text-center text-dark bg-success px-2 pt-2'><b>Su Compra se ha registrado con ÉXITO</b></h3><br><br>";
			}
		}
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Aliados</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="my-3">
	<?php
		$datos_usuario_session_i=M_usuarios_R($conexion, 'CORREO', $_SESSION["usuario"], '', '', '', '');
		if($datos_usuario_session_i['ALIADO'][0]<>'SI' and !isset($_GET['comprar_aliado'])){
	?>
		<br><br><br>
		<div class="container my-2 px-5">
			<div class="row">
				<h3 class="bg-danger text-dark text-center w-100 py-2 mb-0"><b>AÚN NO TIENES ACCESO A ESTE SERVICIO...</b></h3>
			</div>
			<div class="row bg-light">
				<div class="col-12 h5 p-3">Nuestro servicio de <b>ALIADO</b> le permitirá a tus productos aparecer preferentemente en las búsquedas de productos que otros usuarios realicen asi como en la sección de Aliados en la portada de nuestro sitio.<br>Lo que en poco tiempo te ayudará a incrementar tus ganancias.<br>Puedes suscribirte a este servicio haciendo click <a href="zona_usuario_aliados.php?comprar_aliado=SI">&laquo; aquí &raquo;</a></div>
			</div>
		</div>
	<?php
		}else if(isset($_GET['comprar_aliado'])){
			if($_GET['comprar_aliado']=='SI'){
				$datos_saldo_disponible_usuario=M_saldo_pm_disponible_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
	?>
		<br><br><br>
		<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
			<?php echo $verf_compra_aliados; ?>
			<h3 class="text-center text-warning px-2 pt-2"><b>Comprar Servicio "ALIADO"</b> (<i class="text-success"><b>Disponible: </b></i><b class="text-light"><?php echo number_format($datos_saldo_disponible_usuario['SALDO_PEMON'][0], 2,',','.');?> Pm</b>)</h3>
			<form action="zona_usuario_aliados.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="FORM" id="FORM" value="COMPRAR_ALIADO">
				<input type="hidden" name="fh_registro" id="fh_registro" value="<?php echo date("Y-m-d h:m:s"); ?>">
				<input type="hidden" name="saldo" id="saldo" value="<?php echo $datos_saldo_disponible_usuario['SALDO_PEMON'][0]; ?>">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Producto:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="nombre_producto" id="nombre_producto" required autocomplete="off" title="Indique el producto a comprar">
						<option>ALIADO - CASA VIRTUAL</option>
					</select>
				</div>
				<div class='input-group mb-2'>
					<div class='col-md-3 p-0 m-0'>
						<span class='input-group-text rounded-0 w-100'>Precio:</span>
					</div>
					<input type='hidden' name='precio_unitario_micoin' id='precio_unitario_micoin' value='<?php echo $costo_del_servicio_de_aliados; ?>'>
					<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='precio_unitario_micoin_print' id='precio_unitario_micoin_print'  title='precio unitario del producto' min='0' disabled value='<?php echo number_format($costo_del_servicio_de_aliados, 2,',','.'); ?>'>
				</div>
					<?php
						if($datos_saldo_disponible_usuario['SALDO_PEMON'][0]<$costo_del_servicio_de_aliados){
							echo "<div><h5 class='text-danger bg-dark'><b>SALDO INSUFICIENTE:</b> Tu saldo no es suficiente para realizar esta compra.</h5></div>";
							echo "<div class='m-auto'><input type='submit' name='comprar' id='comprar' value='Comprar' class='btn btn-warning mb-2' disabled></div>";
						}else{
							echo "<div class='m-auto'><input type='submit' name='comprar' id='comprar' value='Comprar' class='btn btn-warning mb-2'></div>";
						}
					?>
			</form>
		</div>
	<?php			
			}
		}else{
	?>
		<!-- MOSTRANDO TIEMPO RESTANTE DE SERVICIO -->
		<?php
			$datos_serv_ali= M_control_de_transacciones_compras_en_micoin_R($conexion, 'COMPRADOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'NOMBRE_PRODUCTO', 'ALIADO - CASA VIRTUAL', '', '');
			$i=0;
			$fh_ultima_compra="";
			while(isset($datos_serv_ali['ID_TRANSACCION'][$i])){
				if($datos_serv_ali['ID_TRANSACCION'][$i]<>""){
					$fh_ultima_compra=$datos_serv_ali['FH_PAGADO'][$i];
				}
				$i++;
			}
			if($fh_ultima_compra<>""){
				$reloj=date("Y-m-d",strtotime($fh_ultima_compra."+ 365 days"));
				echo "<div style='width:160px;' class='text-center text-secondary ml-auto bg-dark mb-1 pt-1 pb-0'><b title='Tiempo restante del servicio (días Hr:min:seg)' id='cronometro_aliados'></b></div>";
				echo "<script>
						$('#cronometro_aliados').timeTo(new Date('" . $reloj . "'));
					  </script>";
				
			}
		?>
		<!-- MOSTRANDO LOS ALIADOS -->
		<h3 class="bg-primary text-center p-2 mb-3"><b>Ya eres nuestro Aliado...</b></h3>
		<div class="container-fluid">
			<div class="row mt-4 bg-light">
			<?php
				$datos_aliados=M_usuarios_R_portada_aliados($conexion);
			?>
			<div class="col-12 px-0">
				<h3 class="bg-dark text-warning text-center py-1 mb-0"><b>Nuestros Aliados</b></h3>
				<table class="TablaDinamica10 w-100 mx-1">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b class="h6"></th>
						</tr>
					</thead>
					<tbody>
					<?php
						$i=0;
						$e=$i+1;
						while(isset($datos_aliados['EMPRESA'][$i][0])){
					?>
						<tr>
							<td>
								<div class='container-fluid'>
									<div class='row'>
										<div class='col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
											<h4 class='text-left' style='height: 2em;'><b class="text-light"><?php echo $e; ?></b><a href='zona_usuario_buscar.php?buscar=<?php echo $datos_aliados['EMPRESA'][$i][0]; ?>' class='text-dark'><b><?php echo $datos_aliados['EMPRESA'][$i][0]; ?></b></a></h4>
											<h6 class='text-warning'>
											<?php
												$estrellas=M_reputacion_por_usuario($conexion, $datos_aliados['CEDULA_RIF'][$i][0]);
												echo M_dibuja_estrellas($estrellas['PUNTOS'][0]);
											?>
											</h6>
											<p class='text-left'><strong class='text-success'>Categorías:</strong>
											<?php
												$e=0;
												while(isset($datos_aliados['CATEGORIAS'][$i][$e])){
													echo "<a href='zona_usuario_buscar.php?buscar=" . $datos_aliados['CATEGORIAS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['CATEGORIAS'][$i][$e] . "</a>";
													if(isset($datos_aliados['CATEGORIAS'][$i][$e+1])){
														if($datos_aliados['CATEGORIAS'][$i][$e+1]<>""){
															echo ", ";
														}
													}else{
														echo ".";
													}
													$e=$e+1;
												}
											?>
											</p>
											<p class='text-left'><strong class='text-primary'>Etiquetas:</strong>
											<?php
												$e=0;
												while(isset($datos_aliados['ETIQUETAS'][$i][$e])){
													echo "<a href='zona_usuario_buscar.php?buscar=" . $datos_aliados['ETIQUETAS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['ETIQUETAS'][$i][$e] . "</a>";
													if(isset($datos_aliados['ETIQUETAS'][$i][$e+1])){
														if($datos_aliados['ETIQUETAS'][$i][$e+1]<>""){
															echo ", ";
														}
													}else{
														echo ".";
													}
													$e=$e+1;
												}
											?>
											</p>
											<p class='text-left'><strong class='text-danger'>Productos:</strong>
											<?php
												$e=0;
												while(isset($datos_aliados['PRODUCTOS'][$i][$e])){
													echo "<a href='zona_usuario_buscar.php?buscar=" . $datos_aliados['PRODUCTOS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['PRODUCTOS'][$i][$e] . "</a>";
													if(isset($datos_aliados['PRODUCTOS'][$i][$e+1])){
														if($datos_aliados['PRODUCTOS'][$i][$e+1]<>""){
															echo ", ";
														}
													}else{
														echo ".";
													}
													$e=$e+1;
												}
											?>
											</p>
											<hr>
										</div>
						<?php
								$i=$i+1;
								$e=$i+1;
								if(isset($datos_aliados['EMPRESA'][$i][0])){
						?>
										<div class='col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
											<h4 class='text-left' style='height: 2em;'><b class="text-light"><?php echo $e; ?></b><a href='zona_usuario_buscar.php?buscar=<?php echo $datos_aliados['EMPRESA'][$i][0]; ?>' class='text-dark'><b><?php echo $datos_aliados['EMPRESA'][$i][0]; ?></b></a></h4>
											<h6 class='text-warning'>
											<?php
												$estrellas=M_reputacion_por_usuario($conexion, $datos_aliados['CEDULA_RIF'][$i][0]);
												echo M_dibuja_estrellas($estrellas['PUNTOS'][0]);
											?>
											</h6>
											<p class='text-left'><strong class='text-success'>Categorías:</strong>
											<?php
												$e=0;
												while(isset($datos_aliados['CATEGORIAS'][$i][$e])){
													echo "<a href='zona_usuario_buscar.php?buscar=" . $datos_aliados['CATEGORIAS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['CATEGORIAS'][$i][$e] . "</a>";
													if(isset($datos_aliados['CATEGORIAS'][$i][$e+1])){
														if($datos_aliados['CATEGORIAS'][$i][$e+1]<>""){
															echo ", ";
														}
													}else{
														echo ".";
													}
													$e=$e+1;
												}
											?>
											</p>
											<p class='text-left'><strong class='text-primary'>Etiquetas:</strong>
											<?php
												$e=0;
												while(isset($datos_aliados['ETIQUETAS'][$i][$e])){
													echo "<a href='zona_usuario_buscar.php?buscar=" . $datos_aliados['ETIQUETAS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['ETIQUETAS'][$i][$e] . "</a>";
													if(isset($datos_aliados['ETIQUETAS'][$i][$e+1])){
														if($datos_aliados['ETIQUETAS'][$i][$e+1]<>""){
															echo ", ";
														}
													}else{
														echo ".";
													}
													$e=$e+1;
												}
											?>
											</p>
											<p class='text-left'><strong class='text-danger'>Productos:</strong>
											<?php
												$e=0;
												while(isset($datos_aliados['PRODUCTOS'][$i][$e])){
													echo "<a href='zona_usuario_buscar.php?buscar=" . $datos_aliados['PRODUCTOS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['PRODUCTOS'][$i][$e] . "</a>";
													if(isset($datos_aliados['PRODUCTOS'][$i][$e+1])){
														if($datos_aliados['PRODUCTOS'][$i][$e+1]<>""){
															echo ", ";
														}
													}else{
														echo ".";
													}
													$e=$e+1;
												}
											?>
											</p>
											<hr>
										</div>
						<?php
								}
								$i=$i+1;
								$e=$i+1;
								if(isset($datos_aliados['EMPRESA'][$i][0])){
						?>
										<div class='col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
											<h4 class='text-left' style='height: 2em;'><b class="text-light"><?php echo $e; ?></b><a href='zona_usuario_buscar.php?buscar=<?php echo $datos_aliados['EMPRESA'][$i][0]; ?>' class='text-dark'><b><?php echo $datos_aliados['EMPRESA'][$i][0]; ?></b></a></h4>
											<h6 class='text-warning'>
											<?php
												$estrellas=M_reputacion_por_usuario($conexion, $datos_aliados['CEDULA_RIF'][$i][0]);
												echo M_dibuja_estrellas($estrellas['PUNTOS'][0]);
											?>
											</h6>
											<p class='text-left'><strong class='text-success'>Categorías:</strong>
											<?php
												$e=0;
												while(isset($datos_aliados['CATEGORIAS'][$i][$e])){
													echo "<a href='zona_usuario_buscar.php?buscar=" . $datos_aliados['CATEGORIAS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['CATEGORIAS'][$i][$e] . "</a>";
													if(isset($datos_aliados['CATEGORIAS'][$i][$e+1])){
														if($datos_aliados['CATEGORIAS'][$i][$e+1]<>""){
															echo ", ";
														}
													}else{
														echo ".";
													}
													$e=$e+1;
												}
											?>
											</p>
											<p class='text-left'><strong class='text-primary'>Etiquetas:</strong>
											<?php
												$e=0;
												while(isset($datos_aliados['ETIQUETAS'][$i][$e])){
													echo "<a href='zona_usuario_buscar.php?buscar=" . $datos_aliados['ETIQUETAS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['ETIQUETAS'][$i][$e] . "</a>";
													if(isset($datos_aliados['ETIQUETAS'][$i][$e+1])){
														if($datos_aliados['ETIQUETAS'][$i][$e+1]<>""){
															echo ", ";
														}
													}else{
														echo ".";
													}
													$e=$e+1;
												}
											?>
											</p>
											<p class='text-left'><strong class='text-danger'>Productos:</strong>
											<?php
												$e=0;
												while(isset($datos_aliados['PRODUCTOS'][$i][$e])){
													echo "<a href='zona_usuario_buscar.php?buscar=" . $datos_aliados['PRODUCTOS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['PRODUCTOS'][$i][$e] . "</a>";
													if(isset($datos_aliados['PRODUCTOS'][$i][$e+1])){
														if($datos_aliados['PRODUCTOS'][$i][$e+1]<>""){
															echo ", ";
														}
													}else{
														echo ".";
													}
													$e=$e+1;
												}
											?>
											</p>
											<hr>
										</div>
						<?php
								}
						?>
									</div>
								</div>
							</td>
						</tr>
					<?php
							$i=$i+1;
							$e=$i+1;
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
		</div>
	<?php			
		}
	?>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>