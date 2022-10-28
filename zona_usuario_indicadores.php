<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	//VERIFICANDO DURACIÓN DEL SERVICIO Y ANULANDOLO EN CASO DE SER NECESARIO
	if($datos_usuario_session['INDICADORES'][0]=='SI'){
		$datos_serv_ind_i= M_control_de_transacciones_compras_en_micoin_R($conexion, 'COMPRADOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'NOMBRE_PRODUCTO', 'INDICADORES - CASA VIRTUAL', '', '');
		$i=0;
		$fh_ultima_compra_i="";
		while(isset($datos_serv_ind_i['ID_TRANSACCION'][$i])){
			if($datos_serv_ind_i['ID_TRANSACCION'][$i]<>""){
				$fh_ultima_compra=$datos_serv_ind_i['FH_PAGADO'][$i];
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
				M_usuarios_U_indicadores($conexion, $datos_usuario_session['ID_USUARIO'][0], 'NO');
				header("location:zona_usuario_indicadores.php");
			}
		}
	}
?>
<?php
	//SI SE QUIERE COMPRAR EL SERVICIO DE INDICADORES ENTONCES:
	$verf_1=false;
	$verf_2=false;
	$verf_compra_indicadores=false;
	$costo_del_servicio_de_indicadores=10;
	if(isset($_POST['FORM'])){
		if($_POST['FORM']=='COMPRAR_INDICADORES'){
			$fecha_ii=$_POST['fh_registro'];
			//CARGANDO UNA TRANSACCIÓN AL REGISTRO
			$verf_1=M_control_de_transacciones_micoin_C($conexion, $datos_usuario_session['NOMBRE'][0], $datos_usuario_session['APELLIDO'][0], $datos_usuario_session['CEDULA_RIF'][0], $datos_usuario_session['CORREO'][0], $datos_usuario_session['FECHA_NACIMIENTO'][0], $datos_usuario_session['EMPRESA'][0], $datos_usuario_session['TELEFONO'][0], $datos_usuario_session['DIRECCION'][0], 'CASA', 'VIRTUAL', 'N/A', 'N/A', '2020-01-01', 'SI', 'N/A', 'N/A', 'EXPRESS', $_POST['nombre_producto'], '1', $_POST['precio_unitario_micoin'], $_POST['precio_unitario_micoin'], 'DIAMANTE', '100', $_POST['precio_unitario_micoin'], '0', $fecha_ii, $fecha_ii, '0000-00-00 00:00:00', $fecha_ii, '5', 'COMPRA DE INDICADORES', 'ENTREGADO');
			
			//ACTUALIZANDO LOS DATOS DEL USUARIO
			if($verf_1){
				$verf_2=M_usuarios_U_indicadores($conexion, $datos_usuario_session['ID_USUARIO'][0], 'SI');
			}
			if($verf_1 and $verf_2){
				//ACTUALIZANDO CODIGO DE VERIFICACIÓN SI EL REGISTRO ANTERIOR FUÉ EXITOSO
				$datos_id_de_la_transaccion=M_control_de_transacciones_obtener_id($conexion, $datos_usuario_session['CEDULA_RIF'][0], 'N/A', "1", $_POST['nombre_producto'], $fecha_ii);
				$datos_seguridad=M_generar_codigo_seguridad($conexion, $datos_usuario_session['CEDULA_RIF'][0], $datos_id_de_la_transaccion['ID_TRANSACCION'][0]);
				//insertando datos en MC_BALANCE ADMINISTRATIVO Y EN MC_PARIDAD_CAMBIARIA
				$datos_previos_balance=M_balance_administrativo_lcv_R_ultimo($conexion);
				$verf_adm_y_pc=M_balance_administrativo_lcv_PRECALCULOS($conexion, $fecha_ii, "COMPRA PROD", "", "", $datos_previos_balance['TC_BS_DOLLAR'][0], "", $datos_id_de_la_transaccion['ID_TRANSACCION'][0]);
				$verf_compra_indicadores="<h3 class='text-center text-dark bg-success px-2 pt-2'><b>Su Compra se ha registrado con ÉXITO</b></h3><br><br>";
			}
		}
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Indicadores</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="my-3">
	<?php
		$datos_usuario_session_i=M_usuarios_R($conexion, 'CORREO', $_SESSION["usuario"], '', '', '', '');
		if($datos_usuario_session_i['INDICADORES'][0]<>'SI' and !isset($_GET['comprar_indicadores'])){
	?>
		<br><br><br>
		<!-- AUN NO HA COMPRADO EL SERVICIO -->
		<div class="container my-2 px-5">
			<div class="row">
				<h3 class="bg-danger text-dark text-center w-100 py-2 mb-0"><b>AÚN NO TIENES ACCESO A ESTE SERVICIO...</b></h3>
			</div>
			<div class="row bg-light">
				<div class="col-12 h5 p-3">Nuestro servicio de indicadores te permitirá ver y analizar tu desempeño dentro de nuestro sitio web.<br>Puedes suscribirte a nuestro servicio de indicadores y estadísticas haciendo click <a href="zona_usuario_indicadores.php?comprar_indicadores=SI">&laquo; aquí &raquo;</a></div>
			</div>
		</div>
	<?php
		}else if(isset($_GET['comprar_indicadores'])){
			if($_GET['comprar_indicadores']=='SI'){
				$datos_saldo_disponible_usuario=M_saldo_pm_disponible_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
	?>
		<br><br><br>
		<!-- FORMULARIO PARA COMPRAR INDICADORES -->
		<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
			<?php echo $verf_compra_indicadores; ?>
			<h3 class="text-center text-warning px-2 pt-2"><b>Comprar Indicadores</b> (<i class="text-success"><b>Disponible: </b></i><b class="text-light"><?php echo number_format($datos_saldo_disponible_usuario['SALDO_PEMON'][0], 2,',','.');?> Pm</b>)</h3>
			<form action="zona_usuario_indicadores.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="FORM" id="FORM" value="COMPRAR_INDICADORES">
				<input type="hidden" name="fh_registro" id="fh_registro" value="<?php echo date("Y-m-d h:m:s"); ?>">
				<input type="hidden" name="saldo" id="saldo" value="<?php echo $datos_saldo_disponible_usuario['SALDO_PEMON'][0]; ?>">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Producto:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="nombre_producto" id="nombre_producto" required autocomplete="off" title="Indique el producto a comprar">
						<option>INDICADORES - CASA VIRTUAL</option>
					</select>
				</div>
				<div class='input-group mb-2'>
					<div class='col-md-3 p-0 m-0'>
						<span class='input-group-text rounded-0 w-100'>Precio:</span>
					</div>
					<input type='hidden' name='precio_unitario_micoin' id='precio_unitario_micoin' value='<?php echo $costo_del_servicio_de_indicadores; ?>'>
					<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='precio_unitario_micoin_print' id='precio_unitario_micoin_print'  title='precio unitario del producto' min='0' disabled value='<?php echo number_format($costo_del_servicio_de_indicadores, 2,',','.'); ?>'>
				</div>
					<?php
						if($datos_saldo_disponible_usuario['SALDO_PEMON'][0]<$costo_del_servicio_de_indicadores){
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
			$datos_serv_ind= M_control_de_transacciones_compras_en_micoin_R($conexion, 'COMPRADOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'NOMBRE_PRODUCTO', 'INDICADORES - CASA VIRTUAL', '', '');
			$i=0;
			$fh_ultima_compra="";
			while(isset($datos_serv_ind['ID_TRANSACCION'][$i])){
				if($datos_serv_ind['ID_TRANSACCION'][$i]<>""){
					$fh_ultima_compra=$datos_serv_ind['FH_PAGADO'][$i];
				}
				$i++;
			}
			if($fh_ultima_compra<>""){
				$reloj=date("Y-m-d",strtotime($fh_ultima_compra."+ 365 days"));
				echo "<div style='width:160px;' class='text-center text-secondary ml-auto bg-dark mb-1 pt-1 pb-0'><b title='Tiempo restante del servicio (días Hr:min:seg)' id='cronometro_indicadores'></b></div>";
				echo "<script>
						$('#cronometro_indicadores').timeTo(new Date('" . $reloj . "'));
					  </script>";
				
			}
		?>
		<!-- MOSTRANDO LOS INDICADORES -->
		<ul class="nav nav-pills">
			<li class="btn btn-dark mr-1 p-2 rounded-0 text-warning" id="titulo_ganancias" title="Ganancias"><b><span class="fa fa-money"></span></b></li>
			<li class="btn btn-dark mr-1 p-2 rounded-0 text-muted" id="titulo_reputacion" title="Reputación"><b><span class="fa fa-thumbs-o-up"></span></b></li>
			<li class="btn btn-dark mr-1 p-2 rounded-0 text-muted" id="titulo_marketing" title="Marketing"><b><span class="fa fa-eye"></span></b></li>
			<li class="btn btn-dark mr-1 p-2 rounded-0 text-muted" id="titulo_preg_resp" title="Preguntas al Vendedor"><b><span class="fa fa-question-circle-o"></span></b></li>
		</ul>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#cuerpo_ganancias").fadeIn();
				$("#cuerpo_reputacion").hide();
				$("#cuerpo_marketing").hide();
				$("#cuerpo_preg_resp").hide();
			});
			$("#titulo_ganancias").click(function(){
				$("#titulo_ganancias").removeClass("text-muted");
				$("#titulo_ganancias").removeClass("text-warning");
				$("#titulo_reputacion").removeClass("text-muted");
				$("#titulo_reputacion").removeClass("text-warning");
				$("#titulo_marketing").removeClass("text-muted");
				$("#titulo_marketing").removeClass("text-warning");
				$("#titulo_preg_resp").removeClass("text-muted");
				$("#titulo_preg_resp").removeClass("text-warning");
				$("#titulo_ganancias").addClass("text-warning");
				$("#titulo_reputacion").addClass("text-muted");
				$("#titulo_marketing").addClass("text-muted");
				$("#titulo_preg_resp").addClass("text-muted");
				$("#cuerpo_ganancias").fadeIn(500);
				$("#cuerpo_reputacion").hide(500);
				$("#cuerpo_marketing").hide(500);
				$("#cuerpo_preg_resp").hide(500);
			})			
			$("#titulo_reputacion").click(function(){
				$("#titulo_ganancias").removeClass("text-muted");
				$("#titulo_ganancias").removeClass("text-warning");
				$("#titulo_reputacion").removeClass("text-muted");
				$("#titulo_reputacion").removeClass("text-warning");
				$("#titulo_marketing").removeClass("text-muted");
				$("#titulo_marketing").removeClass("text-warning");
				$("#titulo_preg_resp").removeClass("text-muted");
				$("#titulo_preg_resp").removeClass("text-warning");
				$("#titulo_ganancias").addClass("text-muted");
				$("#titulo_reputacion").addClass("text-warning");
				$("#titulo_marketing").addClass("text-muted");
				$("#titulo_preg_resp").addClass("text-muted");
				$("#cuerpo_ganancias").hide(500);
				$("#cuerpo_reputacion").fadeIn(500);
				$("#cuerpo_marketing").hide(500);
				$("#cuerpo_preg_resp").hide(500);
			})			
			$("#titulo_marketing").click(function(){
				$("#titulo_ganancias").removeClass("text-muted");
				$("#titulo_ganancias").removeClass("text-warning");
				$("#titulo_reputacion").removeClass("text-muted");
				$("#titulo_reputacion").removeClass("text-warning");
				$("#titulo_marketing").removeClass("text-muted");
				$("#titulo_marketing").removeClass("text-warning");
				$("#titulo_preg_resp").removeClass("text-muted");
				$("#titulo_preg_resp").removeClass("text-warning");
				$("#titulo_ganancias").addClass("text-muted");
				$("#titulo_reputacion").addClass("text-muted");
				$("#titulo_marketing").addClass("text-warning");
				$("#titulo_preg_resp").addClass("text-muted");
				$("#cuerpo_ganancias").hide(500);
				$("#cuerpo_reputacion").hide(500);
				$("#cuerpo_marketing").fadeIn(500);
				$("#cuerpo_preg_resp").hide(500);
			})			
			$("#titulo_preg_resp").click(function(){
				$("#titulo_ganancias").removeClass("text-muted");
				$("#titulo_ganancias").removeClass("text-warning");
				$("#titulo_reputacion").removeClass("text-muted");
				$("#titulo_reputacion").removeClass("text-warning");
				$("#titulo_marketing").removeClass("text-muted");
				$("#titulo_marketing").removeClass("text-warning");
				$("#titulo_preg_resp").removeClass("text-muted");
				$("#titulo_preg_resp").removeClass("text-warning");
				$("#titulo_ganancias").addClass("text-muted");
				$("#titulo_reputacion").addClass("text-muted");
				$("#titulo_marketing").addClass("text-muted");
				$("#titulo_preg_resp").addClass("text-warning");
				$("#cuerpo_ganancias").hide(500);
				$("#cuerpo_reputacion").hide(500);
				$("#cuerpo_marketing").hide(500);
				$("#cuerpo_preg_resp").fadeIn(500);
			});
		</script>
		<!-- MOSTRANDO CUERPOS CON LA INFORMACIÓN -->
		<div class="bg-dark p-3">
			<!-- CUERPO GANANCIAS-->
			<div id="cuerpo_ganancias">
				<!-- PRODUCTOS VENDIDOS -->
				<div class="container bg-light my-2">
					<div id="titulo_graficos_ganancia_01" class="row">
						<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0"><span class="btn btn-success m-0 p-1 fa fa-plus"></span> <b>Productos vendidos</b></h5>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
							$("#cuerpo_graficos_ganancia_01").hide();
						});
						$("#titulo_graficos_ganancia_01").click(function(){
							var mas='<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0"><span class="btn btn-success m-0 p-1 fa fa-plus"></span> <b>Productos vendidos</b></h5>';
							var menos='<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0"><span class="btn btn-danger m-0 p-1 fa fa-minus"></span> <b>Productos vendidos</b></h5>';
							if($("#titulo_graficos_ganancia_01").html()==mas){
								$("#titulo_graficos_ganancia_01").html(menos);
								$("#cuerpo_graficos_ganancia_01").fadeIn(1000);
							}else{
								$("#titulo_graficos_ganancia_01").html(mas);
								$("#cuerpo_graficos_ganancia_01").hide(1000);
							}
						});
					</script>
					<div id="cuerpo_graficos_ganancia_01">
						<div class="row bg-secondary my-0 pt-1">
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Vendedor:</span>
									</div>
									<select id="vendedor" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax">
										<option value="<?php echo $datos_usuario_session['CEDULA_RIF'][0]; ?>">Yo</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Comprador:</span>
									</div>
									<select id="comprador" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el comprador que desea visualizar">
										<option value="Todos">Todos</option>
										<?php
											$filtro_comp_1= M_indicadores_R_compradores_1($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($filtro_comp_1['NOMBRE_APELLIDO'][$i])){
												echo "<option value='" . $filtro_comp_1['CEDULA_RIF'][$i] . "'>" . $filtro_comp_1['NOMBRE_APELLIDO'][$i] . "</option>";
												$i=$i+1;
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Año:</span>
									</div>
									<select id="ano" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el año que desea visualizar">
										<?php
											$filtro_ano_1=M_indicadores_R_ano_1_1($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($filtro_ano_1['ANO'][$i])){
												echo "<option>" . $filtro_ano_1['ANO'][$i] . "</option>";
												$i=$i+1;
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row bg-secondary my-0 pt-1">
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Mes:</span>
									</div>
									<select id="mes" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el mes a visualizar">
										<option value="Todos">Todos</option>
										<option value="1">Enero</option>
										<option value="2">Febrero</option>
										<option value="3">Marzo</option>
										<option value="4">Abril</option>
										<option value="5">Mayo</option>
										<option value="6">Junio</option>
										<option value="7">Julio</option>
										<option value="8">Agosto</option>
										<option value="9">Septiembre</option>
										<option value="10">Octubre</option>
										<option value="11">Noviembre</option>
										<option value="12">Diciembre</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Edad:</span>
									</div>
									<select id="edad" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el rango de edades del comprador">
										<option>Todas</option>
										<option>Menos de 20</option>
										<option>21-30</option>
										<option>31-40</option>
										<option>41-50</option>
										<option>Más de 50</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Producto:</span>
									</div>
									<select id="producto" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el Producto que desea visualizar">
										<option>Todos</option>
										<?php
											$filtro_prod_1= M_indicadores_R_productos_1_1($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($filtro_prod_1['PRODUCTO'][$i])){
												if($filtro_prod_1['PRODUCTO'][$i]<>""){
													echo "<option>" . $filtro_prod_1['PRODUCTO'][$i] . "</option>";
												}
												$i=$i+1;
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div id="caja_grafico_01">
							<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>
						</div>
						<script type="text/javascript">
							$(document).ready(function(){
								$("#caja_grafico_01").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
								$.ajax("PHP_MODELO/S_indicadores_ganancias_1_adm.php",{data:{vendedor:$("#vendedor").val(), ano:$("#ano").val(), mes:$("#mes").val(), edad:$("#edad").val(), comprador:$("#comprador").val(), producto:$("#producto").val(), user:"si"}, type:'post'}).done(function(respuesta){
									$("#caja_grafico_01").hide(5);
									$("#caja_grafico_01").html(respuesta);
									$("#caja_grafico_01").fadeIn(500);
								});
								$(".para_ajax").on('change', function(){
									$("#caja_grafico_01").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
									$.ajax("PHP_MODELO/S_indicadores_ganancias_1_adm.php",{data:{vendedor:$("#vendedor").val(), ano:$("#ano").val(), mes:$("#mes").val(), edad:$("#edad").val(), comprador:$("#comprador").val(), producto:$("#producto").val(), user:"si"}, type:'post'}).done(function(respuesta){
										$("#caja_grafico_01").hide(5);
										$("#caja_grafico_01").html(respuesta);
										$("#caja_grafico_01").fadeIn(500);
									});
								});
							});
						</script>
					</div>
				</div>
				<!-- PRODUCTOS COMPRADOS -->
				<div class="container bg-light my-2">
					<div id="titulo_graficos_ganancia_02" class="row">
						<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0"><span class="btn btn-success m-0 p-1 fa fa-plus"></span> <b>Productos comprados</b></h5>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
							$("#cuerpo_graficos_ganancia_02").hide();
						});
						$("#titulo_graficos_ganancia_02").click(function(){
							var mas='<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0"><span class="btn btn-success m-0 p-1 fa fa-plus"></span> <b>Productos comprados</b></h5>';
							var menos='<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0"><span class="btn btn-danger m-0 p-1 fa fa-minus"></span> <b>Productos comprados</b></h5>';
							if($("#titulo_graficos_ganancia_02").html()==mas){
								$("#titulo_graficos_ganancia_02").html(menos);
								$("#cuerpo_graficos_ganancia_02").fadeIn(1000);
							}else{
								$("#titulo_graficos_ganancia_02").html(mas);
								$("#cuerpo_graficos_ganancia_02").hide(1000);
							}
						});
					</script>
					<div id="cuerpo_graficos_ganancia_02">
						<div class="row bg-secondary my-0 pt-1">
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Comprador:</span>
									</div>
									<select id="comprador2" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el comprador que desea visualizar">
										<option value="<?php echo $datos_usuario_session['CEDULA_RIF'][0]; ?>">Yo</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Vendedor:</span>
									</div>
									<select id="vendedor2" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax">
										<option value="Todos">Todos</option>
										<?php
											$filtro_vend_1= M_indicadores_R_vendedores_1($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($filtro_vend_1['NOMBRE_APELLIDO'][$i])){
												echo "<option value='" . $filtro_vend_1['CEDULA_RIF'][$i] . "'>" . $filtro_vend_1['NOMBRE_APELLIDO'][$i] . "</option>";
												$i=$i+1;
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Año:</span>
									</div>
									<select id="ano2" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el año que desea visualizar">
										<?php
											$filtro_ano_1=M_indicadores_R_ano_1_2($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($filtro_ano_1['ANO'][$i])){
												echo "<option>" . $filtro_ano_1['ANO'][$i] . "</option>";
												$i=$i+1;
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row bg-secondary my-0 pt-1">
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Mes:</span>
									</div>
									<select id="mes2" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el mes a visualizar">
										<option value="Todos">Todos</option>
										<option value="1">Enero</option>
										<option value="2">Febrero</option>
										<option value="3">Marzo</option>
										<option value="4">Abril</option>
										<option value="5">Mayo</option>
										<option value="6">Junio</option>
										<option value="7">Julio</option>
										<option value="8">Agosto</option>
										<option value="9">Septiembre</option>
										<option value="10">Octubre</option>
										<option value="11">Noviembre</option>
										<option value="12">Diciembre</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Edad:</span>
									</div>
									<select id="edad2" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el rango de edades del comprador">
										<option>Todas</option>
										<option>Menos de 20</option>
										<option>21-30</option>
										<option>31-40</option>
										<option>41-50</option>
										<option>Más de 50</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Producto:</span>
									</div>
									<select id="producto2" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el Producto que desea visualizar">
										<option>Todos</option>
										<?php
											$filtro_prod_1= M_indicadores_R_productos_1_2($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($filtro_prod_1['PRODUCTO'][$i])){
												if($filtro_prod_1['PRODUCTO'][$i]<>""){
													echo "<option>" . $filtro_prod_1['PRODUCTO'][$i] . "</option>";
												}
												$i=$i+1;
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div id="caja_grafico_02">
							<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>
						</div>
						<script type="text/javascript">
							$(document).ready(function(){
								$("#caja_grafico_02").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
								$.ajax("PHP_MODELO/S_indicadores_ganancias_2_adm.php",{data:{vendedor:$("#vendedor2").val(), ano:$("#ano2").val(), mes:$("#mes2").val(), edad:$("#edad2").val(), comprador:$("#comprador2").val(), producto:$("#producto2").val(), user:"si"}, type:'post'}).done(function(respuesta){
									$("#caja_grafico_02").hide(5);
									$("#caja_grafico_02").html(respuesta);
									$("#caja_grafico_02").fadeIn(500);
								});
								$(".para_ajax").on('change', function(){
									$("#caja_grafico_02").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
									$.ajax("PHP_MODELO/S_indicadores_ganancias_2_adm.php",{data:{vendedor:$("#vendedor2").val(), ano:$("#ano2").val(), mes:$("#mes2").val(), edad:$("#edad2").val(), comprador:$("#comprador2").val(), producto:$("#producto2").val(), user:"si"}, type:'post'}).done(function(respuesta){
										$("#caja_grafico_02").hide(5);
										$("#caja_grafico_02").html(respuesta);
										$("#caja_grafico_02").fadeIn(500);
									});
								});
							});
						</script>
					</div>
				</div>
				<!-- COMPRA-VENTA PEMON -->
				<div class="container bg-light my-2">
					<div id="titulo_graficos_ganancia_03" class="row">
						<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0"><span class="btn btn-success m-0 p-1 fa fa-plus"></span> <b>Compra-Venta (Pm)</b></h5>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
							$("#cuerpo_graficos_ganancia_03").hide();
						});
						$("#titulo_graficos_ganancia_03").click(function(){
							var mas='<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0"><span class="btn btn-success m-0 p-1 fa fa-plus"></span> <b>Compra-Venta (Pm)</b></h5>';
							var menos='<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0"><span class="btn btn-danger m-0 p-1 fa fa-minus"></span> <b>Compra-Venta (Pm)</b></h5>';
							if($("#titulo_graficos_ganancia_03").html()==mas){
								$("#titulo_graficos_ganancia_03").html(menos);
								$("#cuerpo_graficos_ganancia_03").fadeIn(1000);
							}else{
								$("#titulo_graficos_ganancia_03").html(mas);
								$("#cuerpo_graficos_ganancia_03").hide(1000);
							}
						});
					</script>
					<div id="cuerpo_graficos_ganancia_03">
						<div class="row bg-secondary my-0 pt-1">
							<div class="col-md-6 mx-auto">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Usuario:</span>
									</div>
									<select id="cedula_vendedor3" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax">
										<option value="<?php echo $datos_usuario_session['CEDULA_RIF'][0]; ?>">Yo</option>
									</select>
								</div>
							</div>
						</div>
						<div id="caja_grafico_03">
							<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>
						</div>
						<script type="text/javascript">
							$(document).ready(function(){
								$("#caja_grafico_03").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
								$.ajax("PHP_MODELO/S_indicadores_ganancias_3_adm.php",{data:{vendedor_cedula_rif:$("#cedula_vendedor3").val(), ano:'Todos'}, type:'post'}).done(function(respuesta){
									$("#caja_grafico_03").hide(5);
									$("#caja_grafico_03").html(respuesta);
									$("#caja_grafico_03").fadeIn(500);
								});
								$(".para_ajax").on('change', function(){
									$("#caja_grafico_03").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
									$.ajax("PHP_MODELO/S_indicadores_ganancias_3_adm.php",{data:{vendedor_cedula_rif:$("#cedula_vendedor3").val(), ano:'Todos'}, type:'post'}).done(function(respuesta){
										$("#caja_grafico_03").hide(5);
										$("#caja_grafico_03").html(respuesta);
										$("#caja_grafico_03").fadeIn(500);
									});
								});
							});
						</script>
					</div>
				</div>
			</div>
			<!-- CUERPO REPUTACION-->
			<div id="cuerpo_reputacion">
				<!-- MEJORES EVALUACIONES -->
				<div class="container bg-light my-2">
					<div id="titulo_graficos_reputacion_01" class="row">
						<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0" title="Evaluaciones con 3 estrellas o más"><span class="btn btn-success m-0 p-1 fa fa-plus"></span> <b>Mejores evaluaciones</b></h5>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
							$("#cuerpo_graficos_reputacion_01").hide();
						});
						$("#titulo_graficos_reputacion_01").click(function(){
							var mas='<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0" title="Evaluaciones con 3 estrellas o más"><span class="btn btn-success m-0 p-1 fa fa-plus"></span> <b>Mejores evaluaciones</b></h5>';
							var menos='<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0" title="Evaluaciones con 3 estrellas o más"><span class="btn btn-danger m-0 p-1 fa fa-minus"></span> <b>Mejores evaluaciones</b></h5>';
							if($("#titulo_graficos_reputacion_01").html()==mas){
								$("#titulo_graficos_reputacion_01").html(menos);
								$("#cuerpo_graficos_reputacion_01").fadeIn(1000);
							}else{
								$("#titulo_graficos_reputacion_01").html(mas);
								$("#cuerpo_graficos_reputacion_01").hide(1000);
							}
						});
					</script>
					<div id="cuerpo_graficos_reputacion_01">
						<div class="row bg-secondary my-0 pt-1">
							<div class="col-lg-6">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Vendedor:</span>
									</div>
									<select id="cedula_vendedor4" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax">
										<option value="<?php echo $datos_usuario_session['CEDULA_RIF'][0]; ?>">Yo</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Año:</span>
									</div>
									<select id="ano4" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el año que desea visualizar">
										<option value="Todos">Todos</option>
										<?php
											$filtro_ano_1=M_indicadores_R_ano_2($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($filtro_ano_1['ANO'][$i])){
												echo "<option>" . $filtro_ano_1['ANO'][$i] . "</option>";
												$i=$i+1;
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div id="caja_grafico_reputacion_01">
							<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>
						</div>
						<script type="text/javascript">
							$(document).ready(function(){
								$("#caja_grafico_reputacion_01").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
								$.ajax("PHP_MODELO/S_indicadores_reputacion_01.php",{data:{vendedor_cedula_rif:$("#cedula_vendedor4").val(), ano:$("#ano4").val()}, type:'post'}).done(function(respuesta){
									$("#caja_grafico_reputacion_01").hide(5);
									$("#caja_grafico_reputacion_01").html(respuesta);
									$("#caja_grafico_reputacion_01").fadeIn(500);
								});
								$(".para_ajax").on('change', function(){
									$("#caja_grafico_reputacion_01").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
									$.ajax("PHP_MODELO/S_indicadores_reputacion_01.php",{data:{vendedor_cedula_rif:$("#cedula_vendedor4").val(), ano:$("#ano4").val()}, type:'post'}).done(function(respuesta){
										$("#caja_grafico_reputacion_01").hide(5);
										$("#caja_grafico_reputacion_01").html(respuesta);
										$("#caja_grafico_reputacion_01").fadeIn(500);
									});
								});
							});
						</script>
					</div>
				</div>				
				<!-- PEORES EVALUACIONES -->
				<div class="container bg-light my-2">
					<div id="titulo_graficos_reputacion_02" class="row">
						<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0" title="Evaluaciones con menos de 3 estrellas"><span class="btn btn-success m-0 p-1 fa fa-plus"></span> <b>Peores evaluaciones</b></h5>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
							$("#cuerpo_graficos_reputacion_02").hide();
						});
						$("#titulo_graficos_reputacion_02").click(function(){
							var mas='<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0" title="Evaluaciones con menos de 3 estrellas"><span class="btn btn-success m-0 p-1 fa fa-plus"></span> <b>Peores evaluaciones</b></h5>';
							var menos='<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0" title="Evaluaciones con menos de 3 estrellas"><span class="btn btn-danger m-0 p-1 fa fa-minus"></span> <b>Peores evaluaciones</b></h5>';
							if($("#titulo_graficos_reputacion_02").html()==mas){
								$("#titulo_graficos_reputacion_02").html(menos);
								$("#cuerpo_graficos_reputacion_02").fadeIn(1000);
							}else{
								$("#titulo_graficos_reputacion_02").html(mas);
								$("#cuerpo_graficos_reputacion_02").hide(1000);
							}
						});
					</script>
					<div id="cuerpo_graficos_reputacion_02">
						<div class="row bg-secondary my-0 pt-1">
							<div class="col-lg-6">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Vendedor:</span>
									</div>
									<select id="cedula_vendedor5" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax">
										<option value="<?php echo $datos_usuario_session['CEDULA_RIF'][0]; ?>">Yo</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Año:</span>
									</div>
									<select id="ano5" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el año que desea visualizar">
										<option value="Todos">Todos</option>
										<?php
											$filtro_ano_1=M_indicadores_R_ano_2($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($filtro_ano_1['ANO'][$i])){
												echo "<option>" . $filtro_ano_1['ANO'][$i] . "</option>";
												$i=$i+1;
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div id="caja_grafico_reputacion_02">
							<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>
						</div>
						<script type="text/javascript">
							$(document).ready(function(){
								$("#caja_grafico_reputacion_02").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
								$.ajax("PHP_MODELO/S_indicadores_reputacion_02.php",{data:{vendedor_cedula_rif:$("#cedula_vendedor5").val(), ano:$("#ano5").val()}, type:'post'}).done(function(respuesta){
									$("#caja_grafico_reputacion_02").hide(5);
									$("#caja_grafico_reputacion_02").html(respuesta);
									$("#caja_grafico_reputacion_02").fadeIn(500);
								});
								$(".para_ajax").on('change', function(){
									$("#caja_grafico_reputacion_02").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
									$.ajax("PHP_MODELO/S_indicadores_reputacion_02.php",{data:{vendedor_cedula_rif:$("#cedula_vendedor5").val(), ano:$("#ano5").val()}, type:'post'}).done(function(respuesta){
										$("#caja_grafico_reputacion_02").hide(5);
										$("#caja_grafico_reputacion_02").html(respuesta);
										$("#caja_grafico_reputacion_02").fadeIn(500);
									});
								});
							});
						</script>
					</div>
				</div>
				<!-- COMENTARIO SOBRE EVALUACIONES PENDIENTES -->
				<?php
					$datos_eval_pendientes= M_control_de_transacciones_compras_en_micoin_R($conexion, 'FH_EVALUACION', '0000-00-00 00:00:00', 'VENDEDOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], '', '');
					$xxx=0;
					$contar_eval_pendientes=0;
					while(isset($datos_eval_pendientes['ID_TRANSACCION'][$xxx])){
						if($datos_eval_pendientes['ID_TRANSACCION'][$xxx]<>""){
							$contar_eval_pendientes++;
						}
						$xxx++;
					}
					if($contar_eval_pendientes>0){
						echo "<div class='container bg-light my-2'><div class='row'><h6 class='bg-dark text-light text-left w-100 p-2 mb-0'><b class='text-danger h4'>IMPORTANTE:</b> Se Tienen " . $contar_eval_pendientes . " productos vendidos sin evaluación.</h6></div></div>";
					}
				?>
			</div>
			<!-- CUERPO MARKETING-->
			<div id="cuerpo_marketing">
				<!-- PRODUCTOS BUSCADOS-->
				<div class="container bg-light my-2">
					<div id="titulo_graficos_marketing_01" class="row">
						<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0" title="Recuento de la cantidad de veces que tus productos han aparecido en busquedas"><span class="btn btn-success m-0 p-1 fa fa-plus"></span> <b>Productos buscados</b></h5>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
							$("#cuerpo_graficos_marketing_01").hide();
						});
						$("#titulo_graficos_marketing_01").click(function(){
							var mas='<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0" title="Recuento de la cantidad de veces que tus productos han aparecido en busquedas"><span class="btn btn-success m-0 p-1 fa fa-plus"></span> <b>Productos buscados</b></h5>';
							var menos='<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0" title="Recuento de la cantidad de veces que tus productos han aparecido en busquedas"><span class="btn btn-danger m-0 p-1 fa fa-minus"></span> <b>Productos buscados</b></h5>';
							if($("#titulo_graficos_marketing_01").html()==mas){
								$("#titulo_graficos_marketing_01").html(menos);
								$("#cuerpo_graficos_marketing_01").fadeIn(1000);
							}else{
								$("#titulo_graficos_marketing_01").html(mas);
								$("#cuerpo_graficos_marketing_01").hide(1000);
							}
						});
					</script>
					<div id="cuerpo_graficos_marketing_01">
						<div class="row bg-secondary my-0 pt-1">
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Vendedor:</span>
									</div>
									<select id="vendedor6" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el vendedor que desea visualizar">
										<option value="<?php echo $datos_usuario_session['CEDULA_RIF'][0]; ?>">Yo</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group mt-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Cliente:</span>
									</div>
									<select id="cliente6" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el cliente que desea visualizar">
										<option value="Todos">Todos</option>
										<?php
											$cliente_i= M_indicadores_R_clientes_3($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($cliente_i['CEDULA_RIF'][$i])){
												echo "<option value='" . $cliente_i['ID_USUARIO'][$i] . "'>" . $cliente_i['NOMBRE'][$i] . " " . $cliente_i['APELLIDO'][$i] .  "</option>";
												$i++;
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Año:</span>
									</div>
									<select id="ano6" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el año que desea visualizar">
										<?php
											$anos_i=M_indicadores_R_ano_3($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($anos_i['ANO'][$i])){
												echo "<option>" . $anos_i['ANO'][$i] . "</option>";
												$i=$i+1;
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row bg-secondary my-0 pt-1">
							<div class="col-lg-4">
								<div class="input-group mt-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Mes:</span>
									</div>
									<select id="mes6" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el mes a visualizar">
										<option value="Todos">Todos</option>
										<option value="1">Enero</option>
										<option value="2">Febrero</option>
										<option value="3">Marzo</option>
										<option value="4">Abril</option>
										<option value="5">Mayo</option>
										<option value="6">Junio</option>
										<option value="7">Julio</option>
										<option value="8">Agosto</option>
										<option value="9">Septiembre</option>
										<option value="10">Octubre</option>
										<option value="11">Noviembre</option>
										<option value="12">Diciembre</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Edad:</span>
									</div>
									<select id="edad6" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el rango de edades del comprador">
										<option>Todas</option>
										<option>Menos de 20</option>
										<option>21-30</option>
										<option>31-40</option>
										<option>41-50</option>
										<option>Más de 50</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Producto:</span>
									</div>
									<select id="producto6" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el Producto que desea visualizar">
										<option>Todos</option>
										<?php
											$productos_i=M_indicadores_R_productos_3($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($productos_i['NOMBRE_PRODUCTO'][$i])){
												if($productos_i['NOMBRE_PRODUCTO'][$i]<>""){
													echo "<option value='" . $productos_i['ID_PRODUCTO'][$i] . "'>" . $productos_i['NOMBRE_PRODUCTO'][$i] . "</option>";
												}
												$i=$i+1;
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div id="caja_grafico_06">
							<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>
						</div>
						<script type="text/javascript">
							$(document).ready(function(){
								$("#caja_grafico_06").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
								$.ajax("PHP_MODELO/S_indicadores_marketing_1_adm.php",{data:{vendedor:$("#vendedor6").val(), ano:$("#ano6").val(), mes:$("#mes6").val(), edad:$("#edad6").val(), cliente:$("#cliente6").val(), producto:$("#producto6").val(), user:"si"}, type:'post'}).done(function(respuesta){
									$("#caja_grafico_06").hide(5);
									$("#caja_grafico_06").html(respuesta);
									$("#caja_grafico_06").fadeIn(500);
								});
								$(".para_ajax").on('change', function(){
									$("#caja_grafico_06").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
									$.ajax("PHP_MODELO/S_indicadores_marketing_1_adm.php",{data:{vendedor:$("#vendedor6").val(), ano:$("#ano6").val(), mes:$("#mes6").val(), edad:$("#edad6").val(), cliente:$("#cliente6").val(), producto:$("#producto6").val(), user:"si"}, type:'post'}).done(function(respuesta){
										$("#caja_grafico_06").hide(5);
										$("#caja_grafico_06").html(respuesta);
										$("#caja_grafico_06").fadeIn(500);
									});
								});
							});
						</script>
					</div>
				</div>
				<!-- PRODUCTOS VISTOS-->
				<div class="container bg-light my-2">
					<div id="titulo_graficos_marketing_02" class="row">
						<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0" title="Recuento de la cantidad de veces que tus productos han sido vistos"><span class="btn btn-success m-0 p-1 fa fa-plus"></span> <b>Productos vistos</b></h5>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
							$("#cuerpo_graficos_marketing_02").hide();
						});
						$("#titulo_graficos_marketing_02").click(function(){
							var mas='<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0" title="Recuento de la cantidad de veces que tus productos han sido vistos"><span class="btn btn-success m-0 p-1 fa fa-plus"></span> <b>Productos vistos</b></h5>';
							var menos='<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0" title="Recuento de la cantidad de veces que tus productos han sido vistos"><span class="btn btn-danger m-0 p-1 fa fa-minus"></span> <b>Productos vistos</b></h5>';
							if($("#titulo_graficos_marketing_02").html()==mas){
								$("#titulo_graficos_marketing_02").html(menos);
								$("#cuerpo_graficos_marketing_02").fadeIn(1000);
							}else{
								$("#titulo_graficos_marketing_02").html(mas);
								$("#cuerpo_graficos_marketing_02").hide(1000);
							}
						});
					</script>
					<div id="cuerpo_graficos_marketing_02">
						<div class="row bg-secondary my-0 pt-1">
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Vendedor:</span>
									</div>
									<select id="vendedor7" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el vendedor que desea visualizar">
										<option value="<?php echo $datos_usuario_session['CEDULA_RIF'][0]; ?>">Yo</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group mt-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Cliente:</span>
									</div>
									<select id="cliente7" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el cliente que desea visualizar">
										<option value="Todos">Todos</option>
										<?php
											$cliente_i= M_indicadores_R_clientes_4($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($cliente_i['CEDULA_RIF'][$i])){
												echo "<option value='" . $cliente_i['ID_USUARIO'][$i] . "'>" . $cliente_i['NOMBRE'][$i] . " " . $cliente_i['APELLIDO'][$i] .  "</option>";
												$i++;
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Año:</span>
									</div>
									<select id="ano7" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el año que desea visualizar">
										<?php
											$anos_i=M_indicadores_R_ano_4($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($anos_i['ANO'][$i])){
												echo "<option>" . $anos_i['ANO'][$i] . "</option>";
												$i=$i+1;
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row bg-secondary my-0 pt-1">
							<div class="col-lg-4">
								<div class="input-group mt-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Mes:</span>
									</div>
									<select id="mes7" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el mes a visualizar">
										<option value="Todos">Todos</option>
										<option value="1">Enero</option>
										<option value="2">Febrero</option>
										<option value="3">Marzo</option>
										<option value="4">Abril</option>
										<option value="5">Mayo</option>
										<option value="6">Junio</option>
										<option value="7">Julio</option>
										<option value="8">Agosto</option>
										<option value="9">Septiembre</option>
										<option value="10">Octubre</option>
										<option value="11">Noviembre</option>
										<option value="12">Diciembre</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Edad:</span>
									</div>
									<select id="edad7" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el rango de edades del comprador">
										<option>Todas</option>
										<option>Menos de 20</option>
										<option>21-30</option>
										<option>31-40</option>
										<option>41-50</option>
										<option>Más de 50</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Producto:</span>
									</div>
									<select id="producto7" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el Producto que desea visualizar">
										<option>Todos</option>
										<?php
											$productos_i=M_indicadores_R_productos_4($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($productos_i['NOMBRE_PRODUCTO'][$i])){
												if($productos_i['NOMBRE_PRODUCTO'][$i]<>""){
													echo "<option value='" . $productos_i['ID_PRODUCTO'][$i] . "'>" . $productos_i['NOMBRE_PRODUCTO'][$i] . "</option>";
												}
												$i=$i+1;
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div id="caja_grafico_07">
							<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>
						</div>
						<script type="text/javascript">
							$(document).ready(function(){
								$("#caja_grafico_07").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
								$.ajax("PHP_MODELO/S_indicadores_marketing_2_adm.php",{data:{vendedor:$("#vendedor7").val(), ano:$("#ano7").val(), mes:$("#mes7").val(), edad:$("#edad7").val(), cliente:$("#cliente7").val(), producto:$("#producto7").val(), user:"si"}, type:'post'}).done(function(respuesta){
									$("#caja_grafico_07").hide(5);
									$("#caja_grafico_07").html(respuesta);
									$("#caja_grafico_07").fadeIn(500);
								});
								$(".para_ajax").on('change', function(){
									$("#caja_grafico_07").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
									$.ajax("PHP_MODELO/S_indicadores_marketing_2_adm.php",{data:{vendedor:$("#vendedor7").val(), ano:$("#ano7").val(), mes:$("#mes7").val(), edad:$("#edad7").val(), cliente:$("#cliente7").val(), producto:$("#producto7").val(), user:"si"}, type:'post'}).done(function(respuesta){
										$("#caja_grafico_07").hide(5);
										$("#caja_grafico_07").html(respuesta);
										$("#caja_grafico_07").fadeIn(500);
									});
								});
							});
						</script>
					</div>
				</div>
				<!-- PRODUCTOS APARTADOS-->
				<div class="container bg-light my-2">
					<div id="titulo_graficos_marketing_03" class="row">
						<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0" title="Recuento de la cantidad de veces que tus productos han sido colocados en el carrito de la compra"><span class="btn btn-success m-0 p-1 fa fa-plus"></span> <b>Productos apartados</b></h5>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
							$("#cuerpo_graficos_marketing_03").hide();
						});
						$("#titulo_graficos_marketing_03").click(function(){
							var mas='<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0" title="Recuento de la cantidad de veces que tus productos han sido colocados en el carrito de la compra"><span class="btn btn-success m-0 p-1 fa fa-plus"></span> <b>Productos apartados</b></h5>';
							var menos='<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0" title="Recuento de la cantidad de veces que tus productos han sido colocados en el carrito de la compra"><span class="btn btn-danger m-0 p-1 fa fa-minus"></span> <b>Productos apartados</b></h5>';
							if($("#titulo_graficos_marketing_03").html()==mas){
								$("#titulo_graficos_marketing_03").html(menos);
								$("#cuerpo_graficos_marketing_03").fadeIn(1000);
							}else{
								$("#titulo_graficos_marketing_03").html(mas);
								$("#cuerpo_graficos_marketing_03").hide(1000);
							}
						});
					</script>
					<div id="cuerpo_graficos_marketing_03">
						<div class="row bg-secondary my-0 pt-1">
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Vendedor:</span>
									</div>
									<select id="vendedor8" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el vendedor que desea visualizar">
										<option value="<?php echo $datos_usuario_session['CEDULA_RIF'][0]; ?>">Yo</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group mt-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Cliente:</span>
									</div>
									<select id="cliente8" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el cliente que desea visualizar">
										<option value="Todos">Todos</option>
										<?php
											$cliente_i= M_indicadores_R_clientes_5($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($cliente_i['CEDULA_RIF'][$i])){
												echo "<option value='" . $cliente_i['ID_USUARIO'][$i] . "'>" . $cliente_i['NOMBRE'][$i] . " " . $cliente_i['APELLIDO'][$i] .  "</option>";
												$i++;
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Año:</span>
									</div>
									<select id="ano8" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el año que desea visualizar">
										<?php
											$anos_i=M_indicadores_R_ano_5($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($anos_i['ANO'][$i])){
												echo "<option>" . $anos_i['ANO'][$i] . "</option>";
												$i=$i+1;
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row bg-secondary my-0 pt-1">
							<div class="col-lg-4">
								<div class="input-group mt-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Mes:</span>
									</div>
									<select id="mes8" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el mes a visualizar">
										<option value="Todos">Todos</option>
										<option value="1">Enero</option>
										<option value="2">Febrero</option>
										<option value="3">Marzo</option>
										<option value="4">Abril</option>
										<option value="5">Mayo</option>
										<option value="6">Junio</option>
										<option value="7">Julio</option>
										<option value="8">Agosto</option>
										<option value="9">Septiembre</option>
										<option value="10">Octubre</option>
										<option value="11">Noviembre</option>
										<option value="12">Diciembre</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Edad:</span>
									</div>
									<select id="edad8" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el rango de edades del comprador">
										<option>Todas</option>
										<option>Menos de 20</option>
										<option>21-30</option>
										<option>31-40</option>
										<option>41-50</option>
										<option>Más de 50</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Producto:</span>
									</div>
									<select id="producto8" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el Producto que desea visualizar">
										<option>Todos</option>
										<?php
											$productos_i=M_indicadores_R_productos_5($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($productos_i['NOMBRE_PRODUCTO'][$i])){
												if($productos_i['NOMBRE_PRODUCTO'][$i]<>""){
													echo "<option value='" . $productos_i['ID_PRODUCTO'][$i] . "'>" . $productos_i['NOMBRE_PRODUCTO'][$i] . "</option>";
												}
												$i=$i+1;
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div id="caja_grafico_08">
							<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>
						</div>
						<script type="text/javascript">
							$(document).ready(function(){
								$("#caja_grafico_08").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
								$.ajax("PHP_MODELO/S_indicadores_marketing_3_adm.php",{data:{vendedor:$("#vendedor8").val(), ano:$("#ano8").val(), mes:$("#mes8").val(), edad:$("#edad8").val(), cliente:$("#cliente8").val(), producto:$("#producto8").val(), user:"si"}, type:'post'}).done(function(respuesta){
									$("#caja_grafico_08").hide(5);
									$("#caja_grafico_08").html(respuesta);
									$("#caja_grafico_08").fadeIn(500);
								});
								$(".para_ajax").on('change', function(){
									$("#caja_grafico_08").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
									$.ajax("PHP_MODELO/S_indicadores_marketing_3_adm.php",{data:{vendedor:$("#vendedor8").val(), ano:$("#ano8").val(), mes:$("#mes8").val(), edad:$("#edad8").val(), cliente:$("#cliente8").val(), producto:$("#producto8").val(), user:"si"}, type:'post'}).done(function(respuesta){
										$("#caja_grafico_08").hide(5);
										$("#caja_grafico_08").html(respuesta);
										$("#caja_grafico_08").fadeIn(500);
									});
								});
							});
						</script>
					</div>
				</div>
			</div>
			<!-- CUERPO PREGUNTAS Y RESPUESTAS-->
			<div id="cuerpo_preg_resp">
				<!-- PREGUNTAS RECIBIDAS-->
				<div class="container bg-light my-2">
					<div id="titulo_graficos_marketing_05" class="row">
						<h5 class="bg-warning text-dark text-left w-100 p-2 mb-0" title="Recuento de la cantidad de preguntas que has recibido de tus clientes"><span class="btn btn-danger m-0 p-1 fa fa-minus"></span> <b>Preguntas Recibidas</b></h5>
					</div>
					<div id="cuerpo_graficos_marketing_05">
						<div class="row bg-secondary my-0 pt-1">
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Vendedor:</span>
									</div>
									<select id="vendedor10" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el vendedor que desea visualizar">
										<option value="<?php echo $datos_usuario_session['CEDULA_RIF'][0]; ?>">Yo</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group mt-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Cliente:</span>
									</div>
									<select id="cliente10" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el cliente que desea visualizar">
										<option value="Todos">Todos</option>
										<?php
											$cliente_i= M_indicadores_R_clientes_6($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($cliente_i['CEDULA_RIF'][$i])){
												echo "<option value='" . $cliente_i['ID_USUARIO'][$i] . "'>" . $cliente_i['NOMBRE'][$i] . " " . $cliente_i['APELLIDO'][$i] .  "</option>";
												$i++;
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Año:</span>
									</div>
									<select id="ano10" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el año que desea visualizar">
										<?php
											$anos_i=M_indicadores_R_ano_6($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($anos_i['ANO'][$i])){
												echo "<option>" . $anos_i['ANO'][$i] . "</option>";
												$i=$i+1;
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row bg-secondary my-0 pt-1">
							<div class="col-lg-4">
								<div class="input-group mt-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Mes:</span>
									</div>
									<select id="mes10" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el mes a visualizar">
										<option value="Todos">Todos</option>
										<option value="1">Enero</option>
										<option value="2">Febrero</option>
										<option value="3">Marzo</option>
										<option value="4">Abril</option>
										<option value="5">Mayo</option>
										<option value="6">Junio</option>
										<option value="7">Julio</option>
										<option value="8">Agosto</option>
										<option value="9">Septiembre</option>
										<option value="10">Octubre</option>
										<option value="11">Noviembre</option>
										<option value="12">Diciembre</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Edad:</span>
									</div>
									<select id="edad10" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el rango de edades del comprador">
										<option>Todas</option>
										<option>Menos de 20</option>
										<option>21-30</option>
										<option>31-40</option>
										<option>41-50</option>
										<option>Más de 50</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group my-1">
									<div class="col-12 p-0 m-0">
										<span class="input-group-text rounded-0 w-100">Producto:</span>
									</div>
									<select id="producto10" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax" title="Seleccione el Producto que desea visualizar">
										<option>Todos</option>
										<?php
											$productos_i=M_indicadores_R_productos_6($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											$i=0;
											while(isset($productos_i['NOMBRE_PRODUCTO'][$i])){
												if($productos_i['NOMBRE_PRODUCTO'][$i]<>""){
													echo "<option value='" . $productos_i['ID_PRODUCTO'][$i] . "'>" . $productos_i['NOMBRE_PRODUCTO'][$i] . "</option>";
												}
												$i=$i+1;
											}
										?>
									</select>
								</div>
							</div>
						</div>
						<div id="caja_grafico_10">
							<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>
						</div>
						<script type="text/javascript">
							$(document).ready(function(){
								$("#caja_grafico_10").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
								$.ajax("PHP_MODELO/S_indicadores_preg_resp_1_adm.php",{data:{vendedor:$("#vendedor10").val(), ano:$("#ano10").val(), mes:$("#mes10").val(), edad:$("#edad10").val(), cliente:$("#cliente10").val(), producto:$("#producto10").val(), user:"si"}, type:'post'}).done(function(respuesta){
									$("#caja_grafico_10").hide(5);
									$("#caja_grafico_10").html(respuesta);
									$("#caja_grafico_10").fadeIn(500);
								});
								$(".para_ajax").on('change', function(){
									$("#caja_grafico_10").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
									$.ajax("PHP_MODELO/S_indicadores_preg_resp_1_adm.php",{data:{vendedor:$("#vendedor10").val(), ano:$("#ano10").val(), mes:$("#mes10").val(), edad:$("#edad10").val(), cliente:$("#cliente10").val(), producto:$("#producto10").val(), user:"si"}, type:'post'}).done(function(respuesta){
										$("#caja_grafico_10").hide(5);
										$("#caja_grafico_10").html(respuesta);
										$("#caja_grafico_10").fadeIn(500);
									});
								});
							});
						</script>
					</div>
				</div>
			</div>
		</div>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<?php			
		}
	?>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>