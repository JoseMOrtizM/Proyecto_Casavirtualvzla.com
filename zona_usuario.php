<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>Zona de Usuario</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<?php if($datos_usuario_session['ACCESO'][0]=='ADMINISTRADOR'){ ?>
	<section class="my-3">
		<div>
			<ul class="nav nav-pills">
				<li class="btn btn-dark mr-1 p-2 rounded-0 text-warning" id="titulo_tareas" title="Tareas"><b><span class="fa fa-check-square-o"></span></b></li>
				<li class="btn btn-dark mr-1 p-2 rounded-0 text-muted" id="titulo_informes" title="informes"><b><span class="fa fa-book"></span></b></li>
				<li class="btn btn-dark mr-1 p-2 rounded-0 text-muted" id="titulo_graficos" title="Indicadores"><b><span class="fa fa-bar-chart-o"></span></b></li>
				<li class="btn btn-dark mr-1 p-2 rounded-0 text-muted" id="titulo_transacciones" title="Transacciones"><b><span class="fa fa-table"></span></b></li>
			</ul>
			<script type="text/javascript">
				<?php
					if(isset($_POST['dias_form'])){
						echo "
							$(document).ready(function(){
								$('#cuerpo_tareas').hide();
								$('#cuerpo_informes').hide();
								$('#cuerpo_graficos').fadeIn();
								$('#cuerpo_transacciones').hide();
								
								$('#titulo_tareas').removeClass('text-muted');
								$('#titulo_tareas').removeClass('text-warning');
								$('#titulo_informes').removeClass('text-muted');
								$('#titulo_informes').removeClass('text-warning');
								$('#titulo_graficos').removeClass('text-muted');
								$('#titulo_graficos').removeClass('text-warning');
								$('#titulo_transacciones').removeClass('text-muted');
								$('#titulo_transacciones').removeClass('text-warning');
								$('#titulo_tareas').addClass('text-muted');
								$('#titulo_informes').addClass('text-muted');
								$('#titulo_graficos').addClass('text-warning');
								$('#titulo_transacciones').addClass('text-muted');
							});
						";
					}else{
						echo "
							$(document).ready(function(){
								$('#cuerpo_tareas').fadeIn();
								$('#cuerpo_informes').hide();
								$('#cuerpo_graficos').hide();
								$('#cuerpo_transacciones').hide();
							});
						";
					}
				?>
				$("#titulo_tareas").click(function(){
					$("#titulo_tareas").removeClass("text-muted");
					$("#titulo_tareas").removeClass("text-warning");
					$("#titulo_informes").removeClass("text-muted");
					$("#titulo_informes").removeClass("text-warning");
					$("#titulo_graficos").removeClass("text-muted");
					$("#titulo_graficos").removeClass("text-warning");
					$("#titulo_transacciones").removeClass("text-muted");
					$("#titulo_transacciones").removeClass("text-warning");
					$("#titulo_tareas").addClass("text-warning");
					$("#titulo_informes").addClass("text-muted");
					$("#titulo_graficos").addClass("text-muted");
					$("#titulo_transacciones").addClass("text-muted");
					$("#cuerpo_tareas").fadeIn(10);
					$("#cuerpo_informes").hide(10);
					$("#cuerpo_graficos").hide(10);
					$("#cuerpo_transacciones").hide(10);
				})			
				$("#titulo_informes").click(function(){
					$("#titulo_tareas").removeClass("text-muted");
					$("#titulo_tareas").removeClass("text-warning");
					$("#titulo_informes").removeClass("text-muted");
					$("#titulo_informes").removeClass("text-warning");
					$("#titulo_graficos").removeClass("text-muted");
					$("#titulo_graficos").removeClass("text-warning");
					$("#titulo_transacciones").removeClass("text-muted");
					$("#titulo_transacciones").removeClass("text-warning");
					$("#titulo_tareas").addClass("text-muted");
					$("#titulo_informes").addClass("text-warning");
					$("#titulo_graficos").addClass("text-muted");
					$("#titulo_transacciones").addClass("text-muted");
					$("#cuerpo_tareas").hide(10);
					$("#cuerpo_informes").fadeIn(10);
					$("#cuerpo_graficos").hide(10);
					$("#cuerpo_transacciones").hide(10);
				})			
				$("#titulo_graficos").click(function(){
					$("#titulo_tareas").removeClass("text-muted");
					$("#titulo_tareas").removeClass("text-warning");
					$("#titulo_informes").removeClass("text-muted");
					$("#titulo_informes").removeClass("text-warning");
					$("#titulo_graficos").removeClass("text-muted");
					$("#titulo_graficos").removeClass("text-warning");
					$("#titulo_transacciones").removeClass("text-muted");
					$("#titulo_transacciones").removeClass("text-warning");
					$("#titulo_tareas").addClass("text-muted");
					$("#titulo_informes").addClass("text-muted");
					$("#titulo_graficos").addClass("text-warning");
					$("#titulo_transacciones").addClass("text-muted");
					$("#cuerpo_tareas").hide(10);
					$("#cuerpo_informes").hide(10);
					$("#cuerpo_graficos").fadeIn(10);
					$("#cuerpo_transacciones").hide(10);
				})			
				$("#titulo_transacciones").click(function(){
					$("#titulo_tareas").removeClass("text-muted");
					$("#titulo_tareas").removeClass("text-warning");
					$("#titulo_informes").removeClass("text-muted");
					$("#titulo_informes").removeClass("text-warning");
					$("#titulo_graficos").removeClass("text-muted");
					$("#titulo_graficos").removeClass("text-warning");
					$("#titulo_transacciones").removeClass("text-muted");
					$("#titulo_transacciones").removeClass("text-warning");
					$("#titulo_tareas").addClass("text-muted");
					$("#titulo_informes").addClass("text-muted");
					$("#titulo_graficos").addClass("text-muted");
					$("#titulo_transacciones").addClass("text-warning");
					$("#cuerpo_tareas").hide(10);
					$("#cuerpo_informes").hide(10);
					$("#cuerpo_graficos").hide(10);
					$("#cuerpo_transacciones").fadeIn(10);
				});
			</script>
			<div id="cuerpo_tareas">
				<div class='col-md-12 bg-dark p-3 mb-4'>
					<h2 class="text-center text-warning"><b>Tareas</b></h2>
					<h5 class="text-left text-warning"><b>Diarias Administrador:</b></h5>
					<ul class="text-light">
						<li>Registrar Otras Operaciones (5:00pm / de Lunes a Viernes).</li>
						<li>Actualizar Tasa de Cambio Bs/$ (10:00am y 5:00pm / de Lunes a Domingo).</li>
						<li>Aprobar Compras y Ventas de Pemón (10:00am y 5:00pm / de Lunes a Domingo).</li>
						<li>Registrar Operaciones con Divisas (11:00am y 6:00pm / de Lunes a Domingo).</li>
					</ul>
					<h5 class="text-left text-warning"><b>Diarias Analista:</b></h5>
					<ul class="text-light">
						<li>Actualizar inventarios (7:00am / de Lunes a Domingo).</li>
						<li>Actualizar Rankings (7:00am / de Lunes a Domingo).</li>
						<li>Administrar Tabla de Categorias (de 7:00am y 7:30am / de Lunes a Viernes).</li>
						<li>Administrar Tabla de Etiquetas (de 7:30am y 8:00am / de Lunes a Viernes).</li>
						<li>Administrar Tabla de Blog Externo (de 8:00am y 8:30am / de Lunes a Viernes).</li>
						<li>Administrar Tabla de Blog Interno (de 8:30am y 9:00am / de Lunes a Viernes).</li>
						<li>Administrar Tabla de Productos (de 9:00am y 9:30am / de Lunes a Viernes).</li>
						<li>Administrar Tabla de Preguntas al Vendedor (de 9:30am y 10:00am / de Lunes a Viernes).</li>
						<li>Enviar notificaciones a los Usuarios (de 10:00am y 11:00am / de Lunes a Viernes).</li>
					</ul>
					<h5 class="text-left text-warning"><b>Semanales Administrador:</b></h5>
					<ul class="text-light">
						<li>Analisis de Indicadores (Lunes 8:00pm).</li>
						<li>Revisión de Balance Administrativo (Lunes 10:00pm).</li>
					</ul>
					<h5 class="text-left text-warning"><b>Mensuales Administrador y Analista:</b></h5>
					<ul class="text-light">
						<li>Mejoras al Sistema (dedicar 4 horas de la primera semana de cada mes).</li>
						<li>Actualización de Políticas (dedicar 4 horas de la segunda semana de cada mes).</li>
						<li>Realizar acciones de marketing (dedicar 4 horas de la tercera semana de cada mes).</li>
					</ul>
				</div>
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			</div>
			<div id="cuerpo_informes">
				<div class='col-md-12 bg-dark p-4'>
					<h2 class="bg-dark text-center text-warning"><b>Informes - Administrador</b></h2>
					<div class="row">
						<div class='col-xl-4 bg-dark p-2'>
							<form action="zona_adm_balance_excel.php" method="post">
								<div class="container-fluid">
									<div class="row">
										<div class='col-md-3 p-0 m-0'>
											<span class='input-group-text rounded-0 w-100'>Año:</span>
										</div>
										<select class="form-control col-md-3 p-0 m-0 px-2 rounded-0" name="ano_excel" id="ano_excel" required autocomplete="off" title="Indique el año que desea exportar">
											<option><?php echo date("Y"); ?></option>
											<?php
												$anos=M_balance_administrativo_lcv_agrupar_anos($conexion);
												$i=0;
												while(isset($anos[$i])){
													echo "<option>" . $anos[$i] . "</option>";
													$i++;
												}
											?>
										</select>
										<input type="submit" value="Descargar Excel &raquo;" class="col-md-6 btn btn-success p-0 m-0">
									</div>
								</div>
							</form>
						</div>
						<div class='col-xl-4 bg-dark p-2'>
							<form action="zona_adm_balance_pdf.php" method="post">
								<input type="hidden" name="ver" value="si">
								<div class="container-fluid">
									<div class="row">
										<div class='col-md-3 p-0 m-0'>
											<span class='input-group-text rounded-0 w-100'>Año:</span>
										</div>
										<select class="form-control col-md-3 p-0 m-0 px-2 rounded-0" name="ano_pdf" id="ano_pdf" required autocomplete="off" title="Indique el año que desea exportar">
											<option><?php echo date("Y"); ?></option>
											<?php
												$i=0;
												while(isset($anos[$i])){
													echo "<option>" . $anos[$i] . "</option>";
													$i++;
												}
											?>
										</select>
										<input type="submit" value="Ver PDF &raquo;" class="col-md-6 btn btn-danger p-0 m-0">
									</div>
								</div>
							</form>
						</div>
						<div class='col-xl-4 bg-dark p-2'>
							<form action="zona_adm_balance_pdf.php" method="post">
								<input type="hidden" name="ver" value="no">
								<div class="container-fluid">
									<div class="row">
										<div class='col-md-3 p-0 m-0'>
											<span class='input-group-text rounded-0 w-100'>Año:</span>
										</div>
										<select class="form-control col-md-3 p-0 m-0 px-2 rounded-0" name="ano_pdf" id="ano_pdf" required autocomplete="off" title="Indique el año que desea exportar">
											<option><?php echo date("Y"); ?></option>
											<?php
												$i=0;
												while(isset($anos[$i])){
													echo "<option>" . $anos[$i] . "</option>";
													$i++;
												}
											?>
										</select>
										<input type="submit" value="Descargar PDF &raquo;" class="col-md-6 btn btn-warning p-0 m-0">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			</div>
			<div id="cuerpo_graficos">
				<div class="bg-dark p-0">
					<div class="container">
						<!-- DATOS GENERALES -->
						<div class="row bg-dark">
							<div class="col-12 px-0">
								<h4 class="bg-dark text-warning text-center py-1 mb-0"><b>Datos generales</b></h4>
							</div>
							<!-- FILA 1 -->
							<div class="col-12 px-0">
								<div class="container-fluid">
									<div class="row">
										<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2"><a href="zona_usuario_directorio.php" class="text-dark">
											<?php
												$datos_paridad_y_tarifas= M_paridad_cambiaria_R_ultima($conexion);
											?>
											<h5><b><u>Usuarios:</u></b></h5>
											<h2><span class="fa fa-user-circle-o text-muted"></span> <b><?php echo M_usuarios_cuenta($conexion); ?></b></h2>
										</a></div>
										<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
											<h5><b><u>Ventas-Productos:</u></b></h5>
											<?php
												$datos_transacciones= M_control_de_transacciones_cuenta($conexion)
											?>
											<div class="container-fluid">
												<div class="row">
													<div class="col-6">
														<h6 class="mb-0"><b>
											<?php 
												if($datos_transacciones['CANTIDAD']<>''){
													echo $datos_transacciones['CANTIDAD'];
												}else{
													echo "0";
												}
											 ?>
													 	</b></h6>
														<h6 class="text-muted mb-0">Productos</h6>
													</div>
													<div class="col-6">
														<h6 class="mb-0"><b>
											<?php 
												if($datos_transacciones['MONTO']<>''){
													echo $datos_transacciones['MONTO'];
												}else{
													echo "0.00";
												}
											 ?>
														</b></h6>
														<h6 class="text-muted mb-0">Pemones</h6>
													</div>
												</div>
											</div>
										</div>
										<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
											<h5><b><u>Ventas de Pm:</u></b></h5>
											<div class="container-fluid">
												<?php
													$datos_venta=M_compra_venta_de_micoin_total($conexion, 'VENTA');
												?>
												<div class="row">
													<div class="col-4">
														<h6 class="mb-0"><b><?php echo $datos_venta['CANTIDAD']; ?></b></h6>
														<h6 class="text-muted mb-0">Ventas</h6>
													</div>
													<div class="col-8">
														<h6 class="mb-0"><b><?php echo number_format($datos_venta['MONTO'], 2,',','.'); ?></b></h6>
														<h6 class="text-muted mb-0">Pemones</h6>
													</div>
												</div>
											</div>
										</div>
										<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
											<h5><b><u>Compras de Pm:</u></b></h5>
											<div class="container-fluid">
												<?php
													$datos_compra=M_compra_venta_de_micoin_total($conexion, 'COMPRA');
												?>
												<div class="row">
													<div class="col-4">
														<h6 class="mb-0"><b><?php echo $datos_compra['CANTIDAD']; ?></b></h6>
														<h6 class="text-muted mb-0">Compras</h6>
													</div>
													<div class="col-8">
														<h6 class="mb-0"><b><?php echo number_format($datos_compra['MONTO'], 2,',','.'); ?></b></h6>
														<h6 class="text-muted mb-0">Pemones</h6>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- FILA 2 -->
							<div class="col-12 px-0">
								<div class="container-fluid">
									<div class="row">
										<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
											<?php
												$datos_comp_vendedor=M_usuarios_R($conexion, 'ACCESO', 'COMPRADOR-VENDEDOR', 'ESTATUS', 'ACTIVO', '', '');
												$cta_i=0;
												$total_saldos=0;
												while(isset($datos_comp_vendedor['ID_USUARIO'][$cta_i])){
													$datos_saldo_disp_user_i= M_saldo_pm_disponible_usuario($conexion, $datos_comp_vendedor['CEDULA_RIF'][$cta_i]);
													$datos_saldo_bloq_user_i= M_saldo_pm_bloqueado_usuario($conexion, $datos_comp_vendedor['CEDULA_RIF'][$cta_i]);
													$total_saldos= $total_saldos + $datos_saldo_disp_user_i['SALDO_PEMON'][0] - $datos_saldo_bloq_user_i['SALDO_PEMON'][0];
													$cta_i++;
												}
											?>
											<h5><b><u>Saldos:</u></b></h5>
											<h3><span class="fa fa-handshake-o text-muted"></span> <b><?php echo number_format($total_saldos, 2,',','.'); ?></b></h3>
											<div id="rep_verf_saldo" class="h3"></div>
											<script type="text/javascript">
												$(document).ready(function(){
													var guardar=$('#verf_saldos');
													$('#rep_verf_saldo').html(guardar);
													$('#verf_saldos').html(guardar);
												});
											</script>
										</div>
										<?php
											$datos_generales_lcv= M_balance_administrativo_lcv_R($conexion, '', '', '', '', '', '');
											$largo=count($datos_generales_lcv['ID_ADM'])-1;
										?>
										<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
											<h5><b><u>Inicio Respaldo:</u></b></h5>
											<div class="container-fluid">
												<div class="row">
													<div class="col-12">
														<?php
															echo "<b>Pm:</b> ";
															if($datos_generales_lcv['RA_RES_MON_CIRC'][$largo]<0){
																
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_RES_MON_CIRC'][$largo], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_RES_MON_CIRC'][$largo]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_RES_MON_CIRC'][$largo], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_RES_MON_CIRC'][$largo], 2,',','.') . "</e>";
															}
														?>
													</div>
													<div class="col-6">
														<?php		
															echo "<e class='small'><b>Bs:</b> ";
															if($datos_generales_lcv['RA_RES_MON_BS_PUROS'][$largo]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_RES_MON_BS_PUROS'][$largo], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_RES_MON_BS_PUROS'][$largo]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_RES_MON_BS_PUROS'][$largo], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_RES_MON_BS_PUROS'][$largo], 2,',','.') . "</e></e>";
															}
														?>		
													</div>
													<div class="col-6">
														<?php			
															echo "<e class='small'><b>$:</b> ";
															if($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][$largo]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][$largo], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][$largo]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][$largo], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][$largo], 2,',','.') . "</e></e>";
															}
														?>	
													</div>
													<div class="col-12">
														<?php			
															echo "<b>$ Eq:</b> ";
															if($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][$largo]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][$largo], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][$largo]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][$largo], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][$largo], 2,',','.') . "</e>";
															}
														?>	
													</div>
												</div>
											</div>
										</div>
										<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
											<h5><b><u>Respaldo Actual:</u></b></h5>
											<div class="container-fluid">
												<div class="row">
													<div class="col-12">
														<?php
															echo "<b>Pm:</b> ";
															if($datos_generales_lcv['RA_RES_MON_CIRC'][0]<0){
																
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_RES_MON_CIRC'][0], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_RES_MON_CIRC'][0]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_RES_MON_CIRC'][0], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_RES_MON_CIRC'][0], 2,',','.') . "</e>";
															}
															if(round($datos_generales_lcv['RA_RES_MON_CIRC'][0],0)<>round($total_saldos+$datos_generales_lcv['RA_RES_MON_CIRC'][$largo],0)){
																echo " <span id='verf_saldos' class='text-danger fa fa-exclamation-triangle' title='Saldos + Resp. Inicial <> Resp. Actual'></span>";
															}else{
																echo " <span id='verf_saldos' class='text-success fa fa-thumbs-o-up' title='Saldos + Resp. Inicial == Resp. Actual'></span>";
															}
														?>
													</div>
													<div class="col-6">
														<?php		
															echo "<e class='small'><b>Bs:</b> ";
															if($datos_generales_lcv['RA_RES_MON_BS_PUROS'][0]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_RES_MON_BS_PUROS'][0], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_RES_MON_BS_PUROS'][0]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_RES_MON_BS_PUROS'][0], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_RES_MON_BS_PUROS'][0], 2,',','.') . "</e></e>";
															}
														?>		
													</div>
													<div class="col-6">
														<?php			
															echo "<e class='small'><b>$:</b> ";
															if($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][0]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][0], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][0]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][0], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][0], 2,',','.') . "</e></e>";
															}
														?>	
													</div>
													<div class="col-12">
														<?php			
															echo "<b>$ Eq:</b> ";
															if($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][0]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][0], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][0]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][0], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][0], 2,',','.') . "</e>";
															}
														?>	
													</div>
												</div>
											</div>
										</div>
										<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
											<h5><b><u>Empresa Actual:</u></b></h5>
											<div class="container-fluid">
												<div class="row">
													<div class="col-6">
														<?php		
															echo "<e class='small'><b>Bs:</b> ";
															if($datos_generales_lcv['RA_IE_BS_PUROS'][0]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_IE_BS_PUROS'][0], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_IE_BS_PUROS'][0]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_IE_BS_PUROS'][0], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_IE_BS_PUROS'][0], 2,',','.') . "</e></e>";
															}
														?>		
													</div>
													<div class="col-6">
														<?php			
															echo "<e class='small'><b>$:</b> ";
															if($datos_generales_lcv['RA_IE_DOLLARES_PUROS'][0]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_IE_DOLLARES_PUROS'][0], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_IE_DOLLARES_PUROS'][0]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_IE_DOLLARES_PUROS'][0], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_IE_DOLLARES_PUROS'][0], 2,',','.') . "</e></e>";
															}
														?>	
													</div>
													<div class="col-12">
														<?php			
															echo "<b>$ Eq:</b> ";
															if($datos_generales_lcv['RA_IE_DOLLARES_EQV'][0]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_IE_DOLLARES_EQV'][0], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_IE_DOLLARES_EQV'][0]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_IE_DOLLARES_EQV'][0], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_IE_DOLLARES_EQV'][0], 2,',','.') . "</e>";
															}
														?>	
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- FILTROS PARA GRAFICOS-->
						<h2 class="bg-dark text-center text-warning mt-3 mb-0"><b>Indicadores</b></h2>
						<div class="row">
							<div class='col-md-8 col-lg-6 p-2 mx-auto mt-1'>
								<div class="container-fluid">
									<div class="row">
										<div class='col-3 col-md-2 p-0 m-0'>
											<span class='input-group-text rounded-0 w-100'>Dias:</span>
										</div>
										<select class="form-control col-9 col-md-4 p-0 m-0 px-2 rounded-0 text-center para_ajax" name="dias_form" id="dias_form" required autocomplete="off" title="Indique los días a mostrar">
											<option>
												<?php
													if(isset($_POST['dias_form'])){
														echo $_POST['dias_form']; 
													}else{
														echo "10";
													}
												?>
											</option>
											<option>5</option>
											<option>10</option>
											<option>15</option>
											<option>20</option>
											<option>30</option>
											<option>60</option>
											<option>90</option>
										</select>
										<div class='col-3 col-md-2 p-0 m-0'>
											<span class='input-group-text rounded-0 w-100' title="Fecha Fin">Fin:</span>
										</div>
										<div id='click01' class='col-9 col-md-4 input-group date pickers p-0 m-0 para_ajax'>
											<input id='datepicker01' type='text' class='form-control p-0 m-0 px-2 rounded-0 text-center para_ajax' name='fecha_filtro' required autocomplete='off' title='Ultima Fecha que se muestra en los gráficos (Y-m-d)' value='<?php
												if(isset($_POST['fecha_filtro'])){
													$fecha_filtro=mysqli_real_escape_string($conexion, $_POST['fecha_filtro']);
												}else{
													$fecha_filtro=date("Y-m-d");
												}
												echo $fecha_filtro;
											?>'>
										</div>
										<script type="text/javascript">
											$('#datepicker01').click(function(){
												Calendar.setup({
													inputField     :    'datepicker01',     // id of the input field
													ifFormat       :    '%Y-%m-%d',      // format of the input field
													button         :    'click01',  // trigger for the calendar (button ID)
													align          :    'Tl',           // alignment (defaults to 'Bl')
													singleClick    :    true
												});
											});
										</script>
									</div>
								</div>
							</div>
							<div id="cuerpo_graficas_ajax"></div>
							<script type="text/javascript">
								$(document).ready(function(){
									$("#cuerpo_graficas_ajax").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
									$.ajax("PHP_MODELO/S_graficos_administrativo.php",{data:{dias_form:$("#dias_form").val(), fecha_filtro:$("#datepicker01").val()}, type:'post'}).done(function(respuesta){
										$("#cuerpo_graficas_ajax").hide(5);
										$("#cuerpo_graficas_ajax").html(respuesta);
										$("#cuerpo_graficas_ajax").fadeIn(500);
									});
									$(".para_ajax").on('change', function(){
										$("#cuerpo_graficas_ajax").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
										$.ajax("PHP_MODELO/S_graficos_administrativo.php",{data:{dias_form:$("#dias_form").val(), fecha_filtro:$("#datepicker01").val()}, type:'post'}).done(function(respuesta){
											$("#cuerpo_graficas_ajax").hide(5);
											$("#cuerpo_graficas_ajax").html(respuesta);
											$("#cuerpo_graficas_ajax").fadeIn(500);
										});
									});
								});
							</script>
						</div>
					</div>
				</div>
			</div>
			<div id="cuerpo_transacciones">
				<h2 class="bg-dark text-center text-warning py-2 my-0"><b>Transacciones:</b></h2>
				<div class="bg-dark py-2">
					<div class="row">
						<div class="col-12 col-sm-7 col-lg-5 col-xl-4 mx-auto pb-2">
							<div class="input-group">
								<div class="col-12 p-0 m-0">
									<span class="input-group-text rounded-0 w-100">Filtrar por Tipo de Operación</span>
								</div>
								<select class="form-control col-12 p-0 m-0 px-2 rounded-0" name="tipo_de_péracion" id="tipo_de_péracion" required autocomplete="off" title="Indique la etiqueta del producto">
									<option>TODAS</option>
									<option>COMPRA PM</option>
									<option>VENTA PM</option>
									<option>COMPRA PROD</option>
									<option>COMPRA DOLLAR RESPALDO</option>
									<option>VENTA DOLLAR RESPALDO</option>
									<option>COMPRA DOLLAR INGRESOS</option>
									<option>VENTA DOLLAR INGRESOS</option>
									<option>GASTO</option>
									<option>PAGO DE IMPUESTO</option>
									<option>REINVERSION</option>
									<option>REPARTO DE DIVIDENDOS</option>
									<option>ACTUALIZAR INVENTARIO</option>
									<option>ACTUALIZAR RANKINGS</option>
									<option>RECHAZAR COMPRA PROD PREMIUN</option>
									<option>ACTUALIZAR TASA DE CAMBIO (Bs/$)</option>
									<option>INICIO DEL SISTEMA</option>
								</select>
							</div>
						</div>
					</div>
					<div id='cuerpo_de_transacciones_realizadas_ajax'>
						<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>
					</div>
					<script type="text/javascript">
						$("#titulo_transacciones").click(function(){
							$.ajax("PHP_MODELO/S_devuelve_tabla_balance_adm.php",{data:{adm:'adm',tipo_de_péracion:$("#tipo_de_péracion").val()}, type:'post'}).done(function(respuesta){
								$("#cuerpo_de_transacciones_realizadas_ajax").hide(5);
								$("#cuerpo_de_transacciones_realizadas_ajax").html(respuesta);
								$("#cuerpo_de_transacciones_realizadas_ajax").fadeIn(500);
							});
						});
						$("#tipo_de_péracion").change(function(){
							$.ajax("PHP_MODELO/S_devuelve_tabla_balance_adm.php",{data:{adm:'adm',tipo_de_péracion:$("#tipo_de_péracion").val()}, type:'post'}).done(function(respuesta){
								$("#cuerpo_de_transacciones_realizadas_ajax").hide(5);
								$("#cuerpo_de_transacciones_realizadas_ajax").html(respuesta);
								$("#cuerpo_de_transacciones_realizadas_ajax").fadeIn(500);
							});
						});
					</script>					
				</div>
			</div>
		</div>
	</section>
	<?php }else if($datos_usuario_session['ACCESO'][0]=='ANALISTA'){ ?>
	<section class="my-3">
		<div>
			<ul class="nav nav-pills">
				<li class="btn btn-dark mr-1 p-2 rounded-0 text-warning" id="titulo_tareas" title="Tareas"><b><span class="fa fa-check-square-o"></span></b></li>
				<li class="btn btn-dark mr-1 p-2 rounded-0 text-muted" id="titulo_graficos" title="Indicadores"><b><span class="fa fa-bar-chart-o"></span></b></li>
			</ul>
			<script type="text/javascript">
				<?php
					if(isset($_POST['dias_form'])){
						echo "
							$(document).ready(function(){
								$('#cuerpo_tareas').hide();
								$('#cuerpo_graficos').fadeIn();
								
								$('#titulo_tareas').removeClass('text-muted');
								$('#titulo_tareas').removeClass('text-warning');
								$('#titulo_graficos').removeClass('text-muted');
								$('#titulo_graficos').removeClass('text-warning');
								$('#titulo_tareas').addClass('text-muted');
								$('#titulo_graficos').addClass('text-warning');
							});
						";
					}else{
						echo "
							$(document).ready(function(){
								$('#cuerpo_tareas').fadeIn();
								$('#cuerpo_graficos').hide();
							});
						";
					}
				?>
				$("#titulo_tareas").click(function(){
					$("#titulo_tareas").removeClass("text-muted");
					$("#titulo_tareas").removeClass("text-warning");
					$("#titulo_informes").removeClass("text-muted");
					$("#titulo_informes").removeClass("text-warning");
					$("#titulo_graficos").removeClass("text-muted");
					$("#titulo_graficos").removeClass("text-warning");
					$("#titulo_transacciones").removeClass("text-muted");
					$("#titulo_transacciones").removeClass("text-warning");
					$("#titulo_tareas").addClass("text-warning");
					$("#titulo_informes").addClass("text-muted");
					$("#titulo_graficos").addClass("text-muted");
					$("#titulo_transacciones").addClass("text-muted");
					$("#cuerpo_tareas").fadeIn(10);
					$("#cuerpo_graficos").hide(10);
				})			
				$("#titulo_graficos").click(function(){
					$("#titulo_tareas").removeClass("text-muted");
					$("#titulo_tareas").removeClass("text-warning");
					$("#titulo_informes").removeClass("text-muted");
					$("#titulo_informes").removeClass("text-warning");
					$("#titulo_graficos").removeClass("text-muted");
					$("#titulo_graficos").removeClass("text-warning");
					$("#titulo_transacciones").removeClass("text-muted");
					$("#titulo_transacciones").removeClass("text-warning");
					$("#titulo_tareas").addClass("text-muted");
					$("#titulo_informes").addClass("text-muted");
					$("#titulo_graficos").addClass("text-warning");
					$("#titulo_transacciones").addClass("text-muted");
					$("#cuerpo_tareas").hide(10);
					$("#cuerpo_graficos").fadeIn(10);
				})
			</script>
			<div id="cuerpo_tareas">
				<div class='col-md-12 bg-dark p-3 mb-4'>
					<h2 class="text-center text-warning"><b>Tareas</b></h2>
					<h5 class="text-left text-warning"><b>Diarias Analista:</b></h5>
					<ul class="text-light">
						<li>Actualizar inventarios (7:00am / de Lunes a Domingo).</li>
						<li>Actualizar Rankings (7:00am / de Lunes a Domingo).</li>
						<li>Administrar Tabla de Categorias (de 7:00am y 7:30am / de Lunes a Viernes).</li>
						<li>Administrar Tabla de Etiquetas (de 7:30am y 8:00am / de Lunes a Viernes).</li>
						<li>Administrar Tabla de Blog Externo (de 8:00am y 8:30am / de Lunes a Viernes).</li>
						<li>Administrar Tabla de Blog Interno (de 8:30am y 9:00am / de Lunes a Viernes).</li>
						<li>Administrar Tabla de Productos (de 9:00am y 9:30am / de Lunes a Viernes).</li>
						<li>Administrar Tabla de Preguntas al Vendedor (de 9:30am y 10:00am / de Lunes a Viernes).</li>
						<li>Enviar notificaciones a los Usuarios (de 10:00am y 11:00am / de Lunes a Viernes).</li>
					</ul>
					<h5 class="text-left text-warning"><b>Mensuales Analista:</b></h5>
					<ul class="text-light">
						<li>Mejoras al Sistema (dedicar 4 horas de la primera semana de cada mes).</li>
						<li>Actualización de Políticas (dedicar 4 horas de la segunda semana de cada mes).</li>
						<li>Realizar acciones de marketing (dedicar 4 horas de la tercera semana de cada mes).</li>
					</ul>
				</div>
			</div>
			<div id="cuerpo_graficos">
				<div class="bg-dark p-0">
					<div class="container">
						<!-- DATOS GENERALES -->
						<div class="row bg-dark">
							<div class="col-12 px-0">
								<h4 class="bg-dark text-warning text-center py-1 mb-0"><b>Datos generales</b></h4>
							</div>
							<!-- FILA 1 -->
							<div class="col-12 px-0">
								<div class="container-fluid">
									<div class="row">
										<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2"><a href="zona_usuario_directorio.php" class="text-dark">
											<?php
												$datos_paridad_y_tarifas= M_paridad_cambiaria_R_ultima($conexion);
											?>
											<h5><b><u>Usuarios:</u></b></h5>
											<h2><span class="fa fa-user-circle-o text-muted"></span> <b><?php echo M_usuarios_cuenta($conexion); ?></b></h2>
										</a></div>
										<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
											<h5><b><u>Ventas-Productos:</u></b></h5>
											<?php
												$datos_transacciones= M_control_de_transacciones_cuenta($conexion)
											?>
											<div class="container-fluid">
												<div class="row">
													<div class="col-6">
														<h6 class="mb-0"><b>
											<?php 
												if($datos_transacciones['CANTIDAD']<>''){
													echo $datos_transacciones['CANTIDAD'];
												}else{
													echo "0";
												}
											 ?>
														</b></h6>
														<h6 class="text-muted mb-0">Productos</h6>
													</div>
													<div class="col-6">
														<h6 class="mb-0"><b>
											<?php 
												if($datos_transacciones['MONTO']<>''){
													echo $datos_transacciones['MONTO'];
												}else{
													echo "0.00";
												}
											 ?>
														</b></h6>
														<h6 class="text-muted mb-0">Pemones</h6>
													</div>
												</div>
											</div>
										</div>
										<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
											<h5><b><u>Ventas de Pm:</u></b></h5>
											<div class="container-fluid">
												<?php
													$datos_venta=M_compra_venta_de_micoin_total($conexion, 'VENTA')
												?>
												<div class="row">
													<div class="col-4">
														<h6 class="mb-0"><b><?php echo $datos_venta['CANTIDAD']; ?></b></h6>
														<h6 class="text-muted mb-0">Ventas</h6>
													</div>
													<div class="col-8">
														<h6 class="mb-0"><b><?php echo number_format($datos_venta['MONTO'], 2,',','.'); ?></b></h6>
														<h6 class="text-muted mb-0">Pemones</h6>
													</div>
												</div>
											</div>
										</div>
										<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
											<h5><b><u>Compras de Pm:</u></b></h5>
											<div class="container-fluid">
												<?php
													$datos_compra=M_compra_venta_de_micoin_total($conexion, 'COMPRA')
												?>
												<div class="row">
													<div class="col-4">
														<h6 class="mb-0"><b><?php echo $datos_compra['CANTIDAD']; ?></b></h6>
														<h6 class="text-muted mb-0">Compras</h6>
													</div>
													<div class="col-8">
														<h6 class="mb-0"><b><?php echo number_format($datos_compra['MONTO'], 2,',','.'); ?></b></h6>
														<h6 class="text-muted mb-0">Pemones</h6>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- FILA 2 -->
							<div class="col-12 px-0">
								<div class="container-fluid">
									<div class="row">
										<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
											<?php
												$datos_comp_vendedor=M_usuarios_R($conexion, 'ACCESO', 'COMPRADOR-VENDEDOR', 'ESTATUS', 'ACTIVO', '', '');
												$cta_i=0;
												$total_saldos=0;
												while(isset($datos_comp_vendedor['ID_USUARIO'][$cta_i])){
													$datos_saldo_disp_user_i= M_saldo_pm_disponible_usuario($conexion, $datos_comp_vendedor['CEDULA_RIF'][$cta_i]);
													$datos_saldo_bloq_user_i= M_saldo_pm_bloqueado_usuario($conexion, $datos_comp_vendedor['CEDULA_RIF'][$cta_i]);
													$total_saldos= $total_saldos + $datos_saldo_disp_user_i['SALDO_PEMON'][0] - $datos_saldo_bloq_user_i['SALDO_PEMON'][0];
													$cta_i++;
												}
											?>
											<h5><b><u>Saldos:</u></b></h5>
											<h3><span class="fa fa-handshake-o text-muted"></span> <b><?php echo number_format($total_saldos, 2,',','.'); ?></b></h3>
											<div id="rep_verf_saldo" class="h3"></div>
											<script type="text/javascript">
												$(document).ready(function(){
													var guardar=$('#verf_saldos');
													$('#rep_verf_saldo').html(guardar);
													$('#verf_saldos').html(guardar);
												});
											</script>
										</div>
										<?php
											$datos_generales_lcv= M_balance_administrativo_lcv_R($conexion, '', '', '', '', '', '');
											$largo=count($datos_generales_lcv['ID_ADM'])-1;
										?>
										<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
											<h5><b><u>Inicio Respaldo:</u></b></h5>
											<div class="container-fluid">
												<div class="row">
													<div class="col-12">
														<?php
															echo "<b>Pm:</b> ";
															if($datos_generales_lcv['RA_RES_MON_CIRC'][$largo]<0){
																
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_RES_MON_CIRC'][$largo], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_RES_MON_CIRC'][$largo]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_RES_MON_CIRC'][$largo], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_RES_MON_CIRC'][$largo], 2,',','.') . "</e>";
															}
														?>
													</div>
													<div class="col-6">
														<?php		
															echo "<e class='small'><b>Bs:</b> ";
															if($datos_generales_lcv['RA_RES_MON_BS_PUROS'][$largo]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_RES_MON_BS_PUROS'][$largo], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_RES_MON_BS_PUROS'][$largo]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_RES_MON_BS_PUROS'][$largo], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_RES_MON_BS_PUROS'][$largo], 2,',','.') . "</e></e>";
															}
														?>		
													</div>
													<div class="col-6">
														<?php			
															echo "<e class='small'><b>$:</b> ";
															if($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][$largo]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][$largo], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][$largo]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][$largo], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][$largo], 2,',','.') . "</e></e>";
															}
														?>	
													</div>
													<div class="col-12">
														<?php			
															echo "<b>$ Eq:</b> ";
															if($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][$largo]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][$largo], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][$largo]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][$largo], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][$largo], 2,',','.') . "</e>";
															}
														?>	
													</div>
												</div>
											</div>
										</div>
										<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
											<h5><b><u>Respaldo Actual:</u></b></h5>
											<div class="container-fluid">
												<div class="row">
													<div class="col-12">
														<?php
															echo "<b>Pm:</b> ";
															if($datos_generales_lcv['RA_RES_MON_CIRC'][0]<0){
																
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_RES_MON_CIRC'][0], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_RES_MON_CIRC'][0]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_RES_MON_CIRC'][0], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_RES_MON_CIRC'][0], 2,',','.') . "</e>";
															}
															if(round($datos_generales_lcv['RA_RES_MON_CIRC'][0],0)<>round($total_saldos+$datos_generales_lcv['RA_RES_MON_CIRC'][$largo],0)){
																echo " <span id='verf_saldos' class='text-danger fa fa-exclamation-triangle' title='Saldos + Resp. Inicial <> Resp. Actual'></span>";
															}else{
																echo " <span id='verf_saldos' class='text-success fa fa-thumbs-o-up' title='Saldos + Resp. Inicial == Resp. Actual'></span>";
															}
														?>
													</div>
													<div class="col-6">
														<?php		
															echo "<e class='small'><b>Bs:</b> ";
															if($datos_generales_lcv['RA_RES_MON_BS_PUROS'][0]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_RES_MON_BS_PUROS'][0], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_RES_MON_BS_PUROS'][0]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_RES_MON_BS_PUROS'][0], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_RES_MON_BS_PUROS'][0], 2,',','.') . "</e></e>";
															}
														?>		
													</div>
													<div class="col-6">
														<?php			
															echo "<e class='small'><b>$:</b> ";
															if($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][0]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][0], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][0]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][0], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_PUROS'][0], 2,',','.') . "</e></e>";
															}
														?>	
													</div>
													<div class="col-12">
														<?php			
															echo "<b>$ Eq:</b> ";
															if($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][0]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][0], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][0]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][0], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_RES_MON_DOLLARES_EQV'][0], 2,',','.') . "</e>";
															}
														?>	
													</div>
												</div>
											</div>
										</div>
										<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
											<h5><b><u>Empresa Actual:</u></b></h5>
											<div class="container-fluid">
												<div class="row">
													<div class="col-6">
														<?php		
															echo "<e class='small'><b>Bs:</b> ";
															if($datos_generales_lcv['RA_IE_BS_PUROS'][0]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_IE_BS_PUROS'][0], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_IE_BS_PUROS'][0]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_IE_BS_PUROS'][0], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_IE_BS_PUROS'][0], 2,',','.') . "</e></e>";
															}
														?>		
													</div>
													<div class="col-6">
														<?php			
															echo "<e class='small'><b>$:</b> ";
															if($datos_generales_lcv['RA_IE_DOLLARES_PUROS'][0]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_IE_DOLLARES_PUROS'][0], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_IE_DOLLARES_PUROS'][0]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_IE_DOLLARES_PUROS'][0], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_IE_DOLLARES_PUROS'][0], 2,',','.') . "</e></e>";
															}
														?>	
													</div>
													<div class="col-12">
														<?php			
															echo "<b>$ Eq:</b> ";
															if($datos_generales_lcv['RA_IE_DOLLARES_EQV'][0]<0){
																echo "<b class='text-danger'>" . number_format($datos_generales_lcv['RA_IE_DOLLARES_EQV'][0], 2,',','.') . "</b>";
															}else if($datos_generales_lcv['RA_IE_DOLLARES_EQV'][0]>0){
																echo "<b class='text-primary'>" . number_format($datos_generales_lcv['RA_IE_DOLLARES_EQV'][0], 2,',','.') . "</b>";
															}else{
																echo "<e>" . number_format($datos_generales_lcv['RA_IE_DOLLARES_EQV'][0], 2,',','.') . "</e>";
															}
														?>	
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- FILTROS PARA GRAFICOS-->
						<h2 class="bg-dark text-center text-warning mt-3 mb-0"><b>Indicadores</b></h2>
						<div class="row">
							<div class='col-md-8 col-lg-6 p-2 mx-auto mt-1'>
								<div class="container-fluid">
									<div class="row">
										<div class='col-3 col-md-2 p-0 m-0'>
											<span class='input-group-text rounded-0 w-100'>Dias:</span>
										</div>
										<select class="form-control col-9 col-md-4 p-0 m-0 px-2 rounded-0 text-center para_ajax" name="dias_form" id="dias_form" required autocomplete="off" title="Indique los días a mostrar">
											<option>
												<?php
													if(isset($_POST['dias_form'])){
														echo $_POST['dias_form']; 
													}else{
														echo "10";
													}
												?>
											</option>
											<option>5</option>
											<option>10</option>
											<option>15</option>
											<option>20</option>
											<option>30</option>
											<option>60</option>
											<option>90</option>
										</select>
										<div class='col-3 col-md-2 p-0 m-0'>
											<span class='input-group-text rounded-0 w-100' title="Fecha Fin">Fin:</span>
										</div>
										<div id='click01' class='col-9 col-md-4 input-group date pickers p-0 m-0 para_ajax'>
											<input id='datepicker01' type='text' class='form-control p-0 m-0 px-2 rounded-0 text-center para_ajax' name='fecha_filtro' required autocomplete='off' title='Ultima Fecha que se muestra en los gráficos (Y-m-d)' value='<?php
												if(isset($_POST['fecha_filtro'])){
													$fecha_filtro=mysqli_real_escape_string($conexion, $_POST['fecha_filtro']);
												}else{
													$fecha_filtro=date("Y-m-d");
												}
												echo $fecha_filtro;
											?>'>
										</div>
										<script type="text/javascript">
											$('#datepicker01').click(function(){
												Calendar.setup({
													inputField     :    'datepicker01',     // id of the input field
													ifFormat       :    '%Y-%m-%d',      // format of the input field
													button         :    'click01',  // trigger for the calendar (button ID)
													align          :    'Tl',           // alignment (defaults to 'Bl')
													singleClick    :    true
												});
											});
										</script>
									</div>
								</div>
							</div>
							<div id="cuerpo_graficas_ajax"></div>
							<script type="text/javascript">
								$(document).ready(function(){
									$("#cuerpo_graficas_ajax").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
									$.ajax("PHP_MODELO/S_graficos_administrativo.php",{data:{dias_form:$("#dias_form").val(), fecha_filtro:$("#datepicker01").val()}, type:'post'}).done(function(respuesta){
										$("#cuerpo_graficas_ajax").hide(5);
										$("#cuerpo_graficas_ajax").html(respuesta);
										$("#cuerpo_graficas_ajax").fadeIn(500);
									});
									$(".para_ajax").on('change', function(){
										$("#cuerpo_graficas_ajax").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
										$.ajax("PHP_MODELO/S_graficos_administrativo.php",{data:{dias_form:$("#dias_form").val(), fecha_filtro:$("#datepicker01").val()}, type:'post'}).done(function(respuesta){
											$("#cuerpo_graficas_ajax").hide(5);
											$("#cuerpo_graficas_ajax").html(respuesta);
											$("#cuerpo_graficas_ajax").fadeIn(500);
										});
									});
								});
							</script>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php }else{ /* ERES USUARIO COMPRADOR-VENDEDOR */ ?>
	<section class="my-3">
		<div class="container-fluid">
			<!-- FILA 1 (DATOS GENERALES) -->
			<div class="row bg-dark">
				<div class="col-12 px-0">
					<h4 class="bg-dark text-warning text-center py-1 mb-0"><b>Datos generales</b></h4>
				</div>
				<div class="col-12 px-0">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2"><a href="zona_usuario_directorio.php" class="text-dark">
								<?php
									$datos_paridad_y_tarifas= M_paridad_cambiaria_R_ultima($conexion);
								?>
								<h5><b><u>Usuarios:</u></b></h5>
								<h2><span class="fa fa-user-circle-o text-muted"></span> <b><?php echo M_usuarios_cuenta($conexion); ?></b></h2>
							</a></div>
							<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
								<h5><b><u>Ventas-Productos:</u></b></h5>
								<?php
									$datos_transacciones= M_control_de_transacciones_cuenta($conexion)
								?>
								<div class="container-fluid">
									<div class="row">
										<div class="col-6">
											<h6 class="mb-0"><b>
											<?php 
												if($datos_transacciones['CANTIDAD']<>''){
													echo $datos_transacciones['CANTIDAD'];
												}else{
													echo "0";
												}
											 ?>
											</b></h6>
											<h6 class="text-muted mb-0">Productos</h6>
										</div>
										<div class="col-6">
											<h6 class="mb-0"><b>
											<?php 
												if($datos_transacciones['MONTO']<>''){
													echo $datos_transacciones['MONTO'];
												}else{
													echo "0.00";
												}
											 ?>
											</b></h6>
											<h6 class="text-muted mb-0">Pemones</h6>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
								<h5><b><u>Compras de Pm:</u></b></h5>
								<div class="container-fluid">
									<?php
										$datos_compra=M_compra_venta_de_micoin_total($conexion, 'COMPRA');
									?>
									<div class="row">
										<div class="col-4">
											<h6 class="mb-0"><b><?php echo $datos_compra['CANTIDAD']; ?></b></h6>
											<h6 class="text-muted mb-0">Compras</h6>
										</div>
										<div class="col-8">
											<h6 class="mb-0"><b><?php echo number_format($datos_compra['MONTO'], 2,',','.'); ?></b></h6>
											<h6 class="text-muted mb-0">Pemones</h6>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
								<h5><b><u>Ventas de Pm:</u></b></h5>
								<div class="container-fluid">
									<?php
										$datos_venta=M_compra_venta_de_micoin_total($conexion, 'VENTA');
									?>
									<div class="row">
										<div class="col-4">
											<h6 class="mb-0"><b><?php echo $datos_venta['CANTIDAD']; ?></b></h6>
											<h6 class="text-muted mb-0">Ventas</h6>
										</div>
										<div class="col-8">
											<h6 class="mb-0"><b><?php echo number_format($datos_venta['MONTO'], 2,',','.'); ?></b></h6>
											<h6 class="text-muted mb-0">Pemones</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- FILA 2 (DATOS DE INTERES) -->
			<div class="row bg-dark mt-4">
				<div class="col-12 px-0">
					<h4 class="bg-warning text-dark text-center py-1 m-0"><b>Datos de interés</b></h4>
				</div>
				<div class="col-12 px-0">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
								<?php
									$datos_paridad_y_tarifas= M_paridad_cambiaria_R_ultima($conexion);
								?>				
								<h5><b><u>Tasa - Bs/Pm:</u></b></h5>
								<div class="container-fluid">
									<div class="row">
										<div class="col-6">
											<h6 class="mb-0"><?php echo number_format($datos_paridad_y_tarifas['TIPO_POR_MICOIN_COMPRA'][0], 2,',','.');?></h6>
											<h6 class="text-muted mb-0">Compra</h6>
										</div>
										<div class="col-6">
											<h6 class="mb-0"><?php echo number_format($datos_paridad_y_tarifas['TIPO_POR_MICOIN_VENTA'][0], 2,',','.');?></h6>
											<h6 class="text-muted mb-0">Venta</h6>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
								<h5><b><u>% Comisión:</u></b></h5>
								<div class="container-fluid">
									<div class="row">
										<div class="col-6">
											<h6 class="mb-0"><?php echo number_format($datos_paridad_y_tarifas['PORC_COMISION_POR_COMPRA'][0], 2,',','.');?>%</h6>
											<h6 class="text-muted mb-0" title="Comisión por compra de Pemón">C-Pm</h6>
										</div>
										<div class="col-6">
											<h6 class="mb-0"><?php echo number_format($datos_paridad_y_tarifas['PORC_COMISION_POR_VENTA'][0], 2,',','.');?>%</h6>
											<h6 class="text-muted mb-0" title="Comisión por venta de Pemón">V-Pm</h6>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2">
								<h5><b><u>Desempeño:</u></b></h5>
								<div class="container-fluid">
									<div class="row align-items-center">
										<div class="col-6">
											<h6 class="text-center text-warning" style="font-size: 0.75em;"><a href="zona_usuario_ver_mis_evaluaciones.php" class="text-warning">
												<?php
													$rep_user= M_reputacion_por_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
													echo M_dibuja_estrellas($rep_user['PUNTOS'][0]);
												?>
											</a></h6>							
										</div>
										<div class="col-6">
											<div class="marco-ajustado hidden rounded w-25 mx-auto">
												<a href="zona_usuario_tabla_ranking.php"><img src="img/ranking_<?php echo strtolower($datos_usuario_session['RANKING'][0]); ?>.png" alt="<?php echo $datos_usuario_session['RANKING'][0]; ?>" title="<?php echo $datos_usuario_session['RANKING'][0]; ?>" class="imgFit w-75"></a>
											</div>
											<h6 class="text-center text-dark"><a href="zona_usuario_tabla_ranking.php" class="text-dark" title="Ver Metas de Ranking"><?php echo $datos_usuario_session['RANKING'][0]; ?></a></h6>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-6 col-lg-3 bg-light rounded border border-dark text-center px-0 py-2"><a href="zona_usuario_arca_consolidado.php" class="text-dark">
								<h5><b><u>Saldo (Pm):</u></b></h5>
								<div class="container-fluid px-1">
									<div class="row">
										<div class="col-4">
											<?php
												$datos_saldo_disponible_usuario= M_saldo_pm_disponible_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											?>
											<h6 class="text-success mb-0" title="Saldo Disponible"><small>Disp.</small></h6>
											<h6 class="mb-0"><small><?php echo number_format($datos_saldo_disponible_usuario['SALDO_PEMON'][0], 2,',','.');?></small></h6>
										</div>
										<div class="col-4">
											<?php
												$datos_saldo_diferido_usuario= M_saldo_pm_diferido_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											?>
											<h6 class="text-primary mb-0" title="Saldo Diferido"><small>Dif.</small></h6>
											<h6 class="mb-0"><small><?php echo number_format($datos_saldo_diferido_usuario['SALDO_PEMON'][0], 2,',','.');?></small></h6>
										</div>
										<div class="col-4">
											<?php
												$datos_saldo_bloqueado_usuario= M_saldo_pm_bloqueado_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											?>
											<h6 class="text-danger mb-0" title="Saldo Bloqueado"><small>Bloq.</small></h6>
											<h6 class="mb-0"><small><?php echo number_format($datos_saldo_bloqueado_usuario['SALDO_PEMON'][0], 2,',','.');?></small></h6>
										</div>
									</div>
								</div>
							</a></div>
						</div>
					</div>
				</div>
			</div>
			<!-- FILA 3 (GRAFICAS TASA DE CAMBIO) -->
			<div id="caja_graficas_tasa_usuario_comp_vend">
				<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>
			</div>
			<script type="text/javascript">
				$(document).ready(function(){
					$.ajax("PHP_MODELO/S_graficos_tasas_para_usuarios.php",{data:{usuario:'SI'}, type:'post'}).done(function(respuesta){
						$("#caja_graficas_tasa_usuario_comp_vend").hide(5);
						$("#caja_graficas_tasa_usuario_comp_vend").html(respuesta);
						$("#caja_graficas_tasa_usuario_comp_vend").fadeIn(500);
					});
				});
			</script>
			<!-- FILA 4 (NUESTRAS CUENTAS) -->
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
			<!-- FILA 5 (ALIADOS) -->
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
			<!-- FILA 6 (TE PUEDE INTERESAR) -->
			<div class="row mt-4 bg-light">
				<?php
					$datos_historial_busqueda=M_historial_de_busqueda_R($conexion, 'CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], '', '', '', '');
					$i=0;
					while(isset($datos_historial_busqueda['TEXTO_BUSCADO'][$i])){
						$textos_buscados[$i]=$datos_historial_busqueda['TEXTO_BUSCADO'][$i];
						$i=$i+1;
					}
					$datos_de_productos_buscados_usuario= M_buscar_productos_te_puede_interesar($conexion, $textos_buscados);
					if(isset($datos_de_productos_buscados_usuario['ID_PRODUCTO'][0])){
						if($datos_de_productos_buscados_usuario['ID_PRODUCTO'][0]<>""){
				?>
				<div class="col-12 px-0 bg-white pb-3">
					<h3 class='bg-dark text-warning text-center py-1 mb-0'><b>Te Puede Interesar</b></h3>
					<table class="TablaDinamica1 w-100">
						<thead>
							<tr class="text-center">
								<th class="align-middle"><b class="h6"></th>
							</tr>
						</thead>
						<tbody>
					<?php
						$i=0;
						while(isset($datos_de_productos_buscados_usuario['ID_PRODUCTO'][$i])){
							echo "<tr><td><div class='container-fluid py-2'>
								<div class='row px-4'>
									<div class='col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
										<div class='m-1 border-bottom'>
											<h5 class='text-left' style='height: 2em;'><a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><strong>" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
											<div class='marco-ajustado hidden rounded border border-secondary w-75'>
												<a href='zona_usuario_detalle_producto.php?id_producto=" . $datos_de_productos_buscados_usuario['ID_PRODUCTO'][$i] . "' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_buscados_usuario['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
											</div>
											<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_buscados_usuario['UNIDAD_DE_VENTA'][$i] . "</h6>
											<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_buscados_usuario['DISPONIBLE'][$i] . "</h6>
											<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE'][$i] . " " . $datos_de_productos_buscados_usuario['APELLIDO'][$i] . "</a></h6>
											<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_CATEGORIA'][$i] . "</a></h6>
											<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
											 <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_1'][$i] . " </a>
											 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_2'][$i] . " </a>
											 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_3'][$i] . " </a>
											 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_4'][$i] . " </a>
											 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_5'][$i] . "</a>
											</h6>
											<h6 class='mb-3' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_buscados_usuario['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
											<br>
										</div>
									</div>
							";
							$i=$i+1;
							if(isset($datos_de_productos_buscados_usuario['ID_PRODUCTO'][$i])){
								echo "
									<div class='col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
										<div class='m-1 border-bottom'>
											<h5 class='text-left' style='height: 2em;'><a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><strong>" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
											<div class='marco-ajustado hidden rounded border border-secondary w-75'>
												<a href='zona_usuario_detalle_producto.php?id_producto=" . $datos_de_productos_buscados_usuario['ID_PRODUCTO'][$i] . "' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_buscados_usuario['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
											</div>
											<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_buscados_usuario['UNIDAD_DE_VENTA'][$i] . "</h6>
											<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_buscados_usuario['DISPONIBLE'][$i] . "</h6>
											<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE'][$i] . " " . $datos_de_productos_buscados_usuario['APELLIDO'][$i] . "</a></h6>
											<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_CATEGORIA'][$i] . "</a></h6>
											<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
											 <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_1'][$i] . " </a>
											 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_2'][$i] . " </a>
											 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_3'][$i] . " </a>
											 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_4'][$i] . " </a>
											 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_5'][$i] . "</a>
											</h6>
											<h6 class='mb-3' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_buscados_usuario['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
											<br>
										</div>
									</div>
								";
							}
							$i=$i+1;
							if(isset($datos_de_productos_buscados_usuario['ID_PRODUCTO'][$i])){
								echo "
									<div class='col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
										<div class='m-1 border-bottom'>
											<h5 class='text-left' style='height: 2em;'><a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><strong>" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
											<div class='marco-ajustado hidden rounded border border-secondary w-75'>
												<a href='zona_usuario_detalle_producto.php?id_producto=" . $datos_de_productos_buscados_usuario['ID_PRODUCTO'][$i] . "' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_buscados_usuario['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
											</div>
											<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_buscados_usuario['UNIDAD_DE_VENTA'][$i] . "</h6>
											<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_buscados_usuario['DISPONIBLE'][$i] . "</h6>
											<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE'][$i] . " " . $datos_de_productos_buscados_usuario['APELLIDO'][$i] . "</a></h6>
											<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_CATEGORIA'][$i] . "</a></h6>
											<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
											 <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_1'][$i] . " </a>
											 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_2'][$i] . " </a>
											 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_3'][$i] . " </a>
											 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_4'][$i] . " </a>
											 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_5'][$i] . "</a>
											</h6>
											<h6 class='mb-3' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_buscados_usuario['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
											<br>
										</div>
									</div>
								";
							}
							echo "
								</div></div></td></tr>
							";
							$i=$i+1;
						}
					?>
					</table>
				</div>
				<?php
						}
					}
				?>			
			</div>
		</div>
	</section>
	<?php } ?>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>