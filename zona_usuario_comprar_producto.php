<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Comprar Producto</title>
</head>
<body class="bg-secondary img-fluid">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="my-3">
	<?php
	if(isset($_POST['FORM'])){
		if($_POST['FORM']=="COMPRAR"){//SI SE DECIDIÓ COMPRAR
			$id_producto_a_comprar=mysqli_real_escape_string($conexion, $_POST['id_producto']);
			$datos_del_producto=M_productos_y_servicios_R($conexion, 'ID_PRODUCTO', $id_producto_a_comprar, '', '', '', '');
			$tipo_de_compra=mysqli_real_escape_string($conexion, $_POST['tipo_de_compra']);
			$cantidad_comprada=mysqli_real_escape_string($conexion, $_POST['cantidad_comprada']);
			$precio_unitario_micoin=mysqli_real_escape_string($conexion, $_POST['precio_unitario_micoin']);
			$monto_bruto_micoin=mysqli_real_escape_string($conexion, $_POST['monto_bruto_micoin']);
			$ranking=mysqli_real_escape_string($conexion, $_POST['ranking']);
			$porc_comision=mysqli_real_escape_string($conexion, $_POST['porc_comision']);
			$monto_comision=mysqli_real_escape_string($conexion, $_POST['monto_comision']);
			$monto_neto=mysqli_real_escape_string($conexion, $_POST['monto_neto']);
			if($tipo_de_compra=="EXPRESS"){
				$fh_pagado=mysqli_real_escape_string($conexion, $_POST['fh_pagado']);
				$fh_entregado=$fh_pagado;
				$estatus='ENTREGADO';
			}else{
				$fh_pagado=mysqli_real_escape_string($conexion, $_POST['fh_pagado']);
				$fh_entregado='';
				$estatus='PAGADO';
			}
			$fh_transaccion_abandonada='';
			$fh_evaluacion='';
			$evaluacion_puntos='';
			$evaluacion_comentario='';
			//INSERTANDO REGISTRO DE COMPRA EN LA BASE DE DATOS
			$verf_insert=M_control_de_transacciones_micoin_C($conexion, $datos_usuario_session['NOMBRE'][0], $datos_usuario_session['APELLIDO'][0], $datos_usuario_session['CEDULA_RIF'][0], $datos_usuario_session['CORREO'][0], $datos_usuario_session['FECHA_NACIMIENTO'][0], $datos_usuario_session['EMPRESA'][0], $datos_usuario_session['TELEFONO'][0], $datos_usuario_session['DIRECCION'][0], $datos_del_producto['NOMBRE'][0], $datos_del_producto['APELLIDO'][0], $datos_del_producto['CEDULA_RIF'][0], $datos_del_producto['CORREO'][0], $datos_del_producto['FECHA_NACIMIENTO'][0], $datos_del_producto['EMPRESA'][0], $datos_del_producto['TELEFONO'][0], $datos_del_producto['DIRECCION'][0], $tipo_de_compra, $datos_del_producto['NOMBRE_PRODUCTO'][0], $cantidad_comprada, $precio_unitario_micoin, $monto_bruto_micoin, $ranking, $porc_comision, $monto_comision, $monto_neto, $fh_pagado, $fh_entregado, $fh_transaccion_abandonada, $fh_evaluacion, $evaluacion_puntos, $evaluacion_comentario, $estatus);
			//ACTUALIZANDO CODIGO DE VERIFICACIÓN SI EL REGISTRO ANTERIOR FUÉ EXITOSO
			if($verf_insert==true){
				$datos_id_de_la_transaccion=M_control_de_transacciones_obtener_id($conexion, $datos_usuario_session['CEDULA_RIF'][0], $datos_del_producto['CEDULA_RIF'][0], $cantidad_comprada, $datos_del_producto['NOMBRE_PRODUCTO'][0], $fh_pagado);
				$datos_seguridad=M_generar_codigo_seguridad($conexion, $datos_usuario_session['CEDULA_RIF'][0], $datos_id_de_la_transaccion['ID_TRANSACCION'][0]);
				//ACTUALIZANDO EL ESTATUS DEL PRODUTO A "COMPRADO" EN EL CARRITO EN CASO DE QUE EXISTA
				$datos_verficiar_carrito=M_carrito_compra_R($conexion, 'mc_usuarios', 'ID_USUARIO', $datos_usuario_session['ID_USUARIO'][0], 'mc_carrito_compra', 'ESTATUS', 'APARTADO', 'mc_productos_y_servicios', 'ID_PRODUCTO', $datos_del_producto['ID_PRODUCTO'][0]);
				if(isset($datos_verficiar_carrito['ID_CARRITO_COMPRA'][0])){
					M_carrito_actualizar_estatus($conexion, $datos_usuario_session['ID_USUARIO'][0], $datos_del_producto['ID_PRODUCTO'][0], 'COMPRADO');
				}
				//ACTUALIZANDO EL INVENTARIO DEL PRODUCTO COMPRADO
				$nueva_cantidad_disponible=$datos_del_producto['CANTIDAD_DISPONIBLE'][0]-$cantidad_comprada;
				M_productos_y_servicios_U_id_inventario($conexion, $id_producto_a_comprar, $nueva_cantidad_disponible);
				//IMPRIMINDO INFORMACIÓN PARA TRANSACCIÓN EXITOSA
				$datos_saldo_disponible_usuario= M_saldo_pm_disponible_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
				//insertando datos en MC_BALANCE ADMINISTRATIVO Y EN MC_PARIDAD_CAMBIARIA SI LA COMPRA ES EXPRESS
				if($tipo_de_compra=="EXPRESS"){
					$datos_previos_balance=M_balance_administrativo_lcv_R_ultimo($conexion);
					$verf_adm_y_pc=M_balance_administrativo_lcv_PRECALCULOS($conexion, $fh_pagado, "COMPRA PROD", "", "", $datos_previos_balance['TC_BS_DOLLAR'][0], "", $datos_id_de_la_transaccion['ID_TRANSACCION'][0]);
				}
		?>
				<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark py-3">
					<h3 class='text-center bg-success text-dark p-2 mb-3'>Transacción EXITOSA.</h3>
					<h5 class="text-center text-warning px-2 pt-2"><b>Detalle de la Compra</b></h3>
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Vendedor:</span>
						</div>
						<input type='text' class="form-control col-md-9 p-0 m-0 px-2 rounded-0" disabled value="<?php echo $datos_del_producto['NOMBRE'][0] . " " . $datos_del_producto['APELLIDO'][0]; ?>">
					</div>
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0" title="Tipo de Compra">
							<span class="input-group-text rounded-0 w-100"><b class="text-danger">Compra:</b></span>
						</div>
						<input type='text' class="form-control col-md-9 p-0 m-0 px-2 rounded-0" disabled value="<?php echo $tipo_de_compra; ?>">
					</div>
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Producto:</span>
						</div>
						<input type='text' class="form-control col-md-9 p-0 m-0 px-2 rounded-0" disabled value="<?php echo $datos_del_producto['NOMBRE_PRODUCTO'][0]; ?>">
					</div>
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100 text"><b class="text-danger">Cantidad:</b></span>
						</div>
						<input type='text' class="form-control col-md-9 p-0 m-0 px-2 rounded-0" disabled value="<?php echo $cantidad_comprada; ?>">
					</div>
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Total Pagado:</span>
						</div>
						<input type='text' class="form-control col-md-9 p-0 m-0 px-2 rounded-0" disabled value="<?php echo $monto_bruto_micoin; ?>">
					</div>
					<?php
						if($tipo_de_compra=="PREMIUN"){
					?>
						<div class="px-5">
							<h6 class="text-left text-light">Su Código de Seguiridad es: <b class='text-danger h4'><b><?php echo $datos_seguridad['CODIGO_DE_SEGURIDAD']; ?></b></b></h6>
							<h6 class="text-left text-light">Por favor, guarde este código. Sólo deberá entregarlo al vendedor al momento de recibir el producto.</h6>
						</div>
					<?php		
						}
					?>
					<div class='text-center'>
						<a href='zona_usuario_carrito_compra.php' class='btn btn-warning mb-2'><span class='fa fa-reply-all'></span> Volver al Carrito</a>
					</div>
				</div>
		<?php
			}else{
				echo "<br><br><br>";
				echo "<div class='col-md-12 col-lg-10 col-xl-9 mx-auto bg-danger my-3'>";
				echo "<h3 class='text-center bg-danger text-dark px-2 pt-2'>No se pudo registrar la Compra. Parece que está intentando realizar una operación que ya está registrada.</h3>";
				echo "</div>";
			}
		}else{
			echo "<br><br><br>";
			echo "<div class='col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark my-3'>";
			echo "<h3 class='text-center text-warning px-2 pt-2'>ALGO ANDA MAL....</h3>";
			echo "</div>";
		}
	}else{
		if(isset($_POST['id_producto'])){//SI SE PASO POR POST LA INTENSIÓN DE COMPRA
			$id_producto_a_comprar=mysqli_real_escape_string($conexion, $_POST['id_producto']);
			$cantidad_a_comprar=mysqli_real_escape_string($conexion, $_POST['cantidad_comprada']);
			$datos_saldo_disponible_usuario=M_saldo_pm_disponible_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
			$datos_del_producto=M_productos_y_servicios_R($conexion, 'ID_PRODUCTO', $id_producto_a_comprar, '', '', '', '');
			//VERIFICANDO SALDO INSUFICIENTE
			$monto_bruto_a_comprar=$datos_del_producto['PRECIO_UNITARIO_MICOIN'][0]*$cantidad_a_comprar;
			if($monto_bruto_a_comprar>$datos_saldo_disponible_usuario['SALDO_PEMON'][0]){
				echo "<br><br><br>";
				echo "<div class='col-md-12 col-lg-10 col-xl-9 mx-auto bg-danger my-3'>";
				echo "<h3 class='text-center bg-danger text-dark px-2 pt-2'><b>SALDO INSUFICIENTE:</b> Tu saldo no es suficiente para realizar esta compra.</h3>";
				echo "</div>";
			}else{
		?>
		<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
			<h3 class="text-center text-warning px-2 pt-2"><b>Comprar Producto</b></h3>
			<h5 class="text-center text-success px-2"><b>(Saldo: <b class="text-light"><?php echo number_format($datos_saldo_disponible_usuario['SALDO_PEMON'][0], 2,',','.');?> Pm</b>)</b></h5>
			<form action="zona_usuario_comprar_producto.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="fh_pagado" id="fh_pagado" value="<?php echo date("Y-m-d h:m:s"); ?>">
				<input type="hidden" name="FORM" id="FORM" value="COMPRAR">
				<input type="hidden" name="id_producto" id="id_producto" value="<?php echo $id_producto_a_comprar; ?>">
				<input type="hidden" name="saldo" id="saldo" value="<?php echo $datos_saldo_disponible_usuario['SALDO_PEMON'][0]; ?>">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Comprador:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cedula_comprador" id="cedula_comprador" required autocomplete="off" title="Indique la cedula del usuario comprador">
						<option value="<?php echo $datos_usuario_session['CEDULA_RIF'][0]; ?>"><?php echo $datos_usuario_session['CORREO'][0]; ?></option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Vendedor:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cedula_vendedor" id="cedula_vendedor" required autocomplete="off" title="Indique la cedula del usuario vendedor">
						<option value="<?php echo $datos_del_producto['CEDULA_RIF'][0]; ?>"><?php echo $datos_del_producto['CORREO'][0]; ?></option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Producto:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="nombre_producto" id="nombre_producto" required autocomplete="off" title="Indique el producto a comprar">
						<option><?php echo $datos_del_producto['NOMBRE_PRODUCTO'][0]; ?></option>
					</select>
				</div>
				<div class='input-group mb-2'>
					<div class='col-md-3 p-0 m-0'>
						<span class='input-group-text rounded-0 w-100'>Precio/Unidad:</span>
					</div>
					<input type='hidden' name='precio_unitario_micoin' id='precio_unitario_micoin' value='<?php echo $datos_del_producto['PRECIO_UNITARIO_MICOIN'][0]; ?>'>
					<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='precio_unitario_micoin_print' id='precio_unitario_micoin_print'  title='precio unitario del producto' min='0' disabled value='<?php echo number_format($datos_del_producto['PRECIO_UNITARIO_MICOIN'][0], 2,',','.'); ?>'>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0" title="Tipo de Compra">
						<span class="input-group-text rounded-0 w-100"><b class="text-danger">Compra:</b></span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_de_compra" id="tipo_de_compra" required autocomplete="off" title="Indique el Tipo de Compra">
						<option>EXPRESS</option>
						<option>PREMIUN</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100"><b class="text-danger">Cantidad:</b></span>
					</div>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cantidad_comprada" id="cantidad_comprada" placeholder="Cantidad de productos" required autocomplete="off" title="Introduzca la cantidad de unidades del produto correspondientes a la comprar" min="0" value="<?php echo $cantidad_a_comprar; ?>" max="<?php echo $datos_del_producto['CANTIDAD_DISPONIBLE'][0]; ?>">
				</div>
				<div id="caja_para_calculos_de_la_compra"></div>
				<script type="text/javascript">
					$(document).ready(function(){
						var cedula_vendedor=$("#cedula_vendedor").val();
						var nombre_producto=$("#nombre_producto").val();
						var cantidad_comprada=$("#cantidad_comprada").val();
						var saldo=$("#saldo").val();
						$.ajax("PHP_MODELO/S_devuelve_calculos_de_la_compra_vista_usuario.php",{data:{cedula_vendedor:cedula_vendedor, nombre_producto:nombre_producto, cantidad_comprada:cantidad_comprada, saldo:saldo}, type:'post'}).done(function(respuesta){
							$("#caja_para_calculos_de_la_compra").html(respuesta);
							$("#caja_para_calculos_de_la_compra").fadeIn(500);
						});
						$("#cantidad_comprada").on('change', function(){
							if($("#cantidad_comprada").val()!=''){
								var cedula_vendedor=$("#cedula_vendedor").val();
								var nombre_producto=$("#nombre_producto").val();
								var cantidad_comprada=$("#cantidad_comprada").val();
								var saldo=$("#saldo").val();
								$.ajax("PHP_MODELO/S_devuelve_calculos_de_la_compra_vista_usuario.php",{data:{cedula_vendedor:cedula_vendedor, nombre_producto:nombre_producto, cantidad_comprada:cantidad_comprada, saldo:saldo}, type:'post'}).done(function(respuesta){
									$("#caja_para_calculos_de_la_compra").html(respuesta);
									$("#caja_para_calculos_de_la_compra").fadeIn(500);
								});
							}else{
								$("#caja_para_calculos_de_la_compra").hide(500);
								$("#caja_para_calculos_de_la_compra").html("");
								$("#caja_para_calculos_de_la_compra").fadeIn(500);
							}
						});
					});
				</script>
			</form>
		</div>
		<?php
			}
		?>
		<?php
			}else if(isset($_GET['id_producto'])){//SI SE PASO POR GET LA INTENSIÓN DE COMPRA
				$id_producto_a_comprar=mysqli_real_escape_string($conexion, $_GET['id_producto']);
				$cantidad_a_comprar=mysqli_real_escape_string($conexion, $_GET['cantidad']);
				$datos_saldo_disponible_usuario= M_saldo_pm_disponible_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
				$datos_del_producto=M_productos_y_servicios_R($conexion, 'ID_PRODUCTO', $id_producto_a_comprar, '', '', '', '');
			//VERIFICANDO SALDO INSUFICIENTE
			$monto_bruto_a_comprar=$datos_del_producto['PRECIO_UNITARIO_MICOIN'][0]*$cantidad_a_comprar;
			if($monto_bruto_a_comprar>$datos_saldo_disponible_usuario['SALDO_PEMON'][0]){
				echo "<br><br><br>";
				echo "<div class='col-md-12 col-lg-10 col-xl-9 mx-auto bg-danger my-3'>";
				echo "<h3 class='text-center bg-danger text-dark px-2 pt-2'><b>SALDO INSUFICIENTE:</b> Tu saldo no es suficiente para realizar esta compra.</h3>";
				echo "</div>";
			}else{
		?>
		<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
			<h3 class="text-center text-warning px-2 pt-2"><b>Comprar Producto</b> (<i class="text-success"><b>Disponible: </b></i><b class="text-light"><?php echo number_format($datos_saldo_disponible_usuario['SALDO_PEMON'][0], 2,',','.');?> Pm</b>) <a href="zona_usuario_carrito_compra.php" class="btn btn-warning text-dark p-1"><span class="fa fa-reply-all"></span> Volver</a></h3>
			<form action="zona_usuario_comprar_producto.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="FORM" id="FORM" value="COMPRAR">
				<input type="hidden" name="id_producto" id="id_producto" value="<?php echo $id_producto_a_comprar; ?>">
				<input type="hidden" name="saldo" id="saldo" value="<?php echo $datos_saldo_disponible_usuario['SALDO_PEMON'][0];?>">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Comprador:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0 input-group-text text-left" name="cedula_comprador" id="cedula_comprador" required autocomplete="off" title="Indique la cedula del usuario comprador">
						<option value="<?php echo $datos_usuario_session['CEDULA_RIF'][0]; ?>"><?php echo $datos_usuario_session['CEDULA_RIF'][0]; ?> - <?php echo $datos_usuario_session['CORREO'][0]; ?></option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Vendedor:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0 input-group-text text-left" name="cedula_vendedor" id="cedula_vendedor" required autocomplete="off" title="Indique la cedula del usuario vendedor">
						<option value="<?php echo $datos_del_producto['CEDULA_RIF'][0]; ?>"><?php echo $datos_del_producto['CEDULA_RIF'][0]; ?> - <?php echo $datos_del_producto['CORREO'][0]; ?></option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Producto:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0 input-group-text text-left" name="nombre_producto" id="nombre_producto" required autocomplete="off" title="Indique el producto a comprar">
						<option><?php echo $datos_del_producto['NOMBRE_PRODUCTO'][0]; ?></option>
					</select>
				</div>
				<div class='input-group mb-2'>
					<div class='col-md-3 p-0 m-0'>
						<span class='input-group-text rounded-0 w-100'>Precio/Unidad:</span>
					</div>
					<input type='hidden' name='precio_unitario_micoin' id='precio_unitario_micoin' value='<?php echo $datos_del_producto['PRECIO_UNITARIO_MICOIN'][0]; ?>'>
					<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='precio_unitario_micoin_print' id='precio_unitario_micoin_print'  title='precio unitario del producto' min='0' disabled value='<?php echo number_format($datos_del_producto['PRECIO_UNITARIO_MICOIN'][0], 2,',','.'); ?>'>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 text-danger"><b>Tipo de Compra:</b></span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_de_compra" id="tipo_de_compra" required autocomplete="off" title="Indique el Tipo de Compra">
						<option>EXPRESS</option>
						<option>PREMIUN</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 text-danger"><b>Cantidad:</b></span>
					</div>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="cantidad_comprada" id="cantidad_comprada" placeholder="Cantidad de productos" required autocomplete="off" title="Introduzca la cantidad de unidades del produto correspondientes a la comprar" min="0" value="<?php echo $cantidad_a_comprar; ?>">
				</div>
				<div id="caja_para_calculos_de_la_compra"></div>
				<div id="caja_observacion"></div>
				<script type="text/javascript">
					$(document).ready(function(){
						var cedula_vendedor=$("#cedula_vendedor").val();
						var nombre_producto=$("#nombre_producto").val();
						var cantidad_comprada=$("#cantidad_comprada").val();
						var saldo=$("#saldo").val();
						$.ajax("PHP_MODELO/S_devuelve_calculos_de_la_compra_vista_usuario.php",{data:{cedula_vendedor:cedula_vendedor, nombre_producto:nombre_producto, cantidad_comprada:cantidad_comprada, saldo:saldo}, type:'post'}).done(function(respuesta){
							$("#caja_para_calculos_de_la_compra").html(respuesta);
							$("#caja_para_calculos_de_la_compra").fadeIn(500);
							var monto_bruto=$("#monto_bruto_micoin").val();
							var saldo=$("#saldo").val();
							if(monto_bruto>saldo){
								$("#caja_observacion").html("<h5 class='text-danger bg-dark'><b>SALDO INSUFICIENTE:</b> Tu saldo no es suficiente para realizar esta compra.<br>(El Monto Bruto a Pagar (" + $("#monto_bruto_micoin").val() + "Pm) es Mayor que tu saldo (" + $("#saldo").val() + "Pm))</h5>");
								$("#comprar").attr("disabled", true);
							}else{
								$("#caja_observacion").html("");
								$('#comprar').attr("disabled", false);
							}
							$("#caja_observacion").fadeIn(500);
						});
						$("#cantidad_comprada").on('change', function(){
							if($("#cantidad_comprada").val()!=''){
								var cedula_vendedor=$("#cedula_vendedor").val();
								var nombre_producto=$("#nombre_producto").val();
								var cantidad_comprada=$("#cantidad_comprada").val();
								$.ajax("PHP_MODELO/S_devuelve_calculos_de_la_compra_vista_usuario.php",{data:{cedula_vendedor:cedula_vendedor, nombre_producto:nombre_producto, cantidad_comprada:cantidad_comprada}, type:'post'}).done(function(respuesta){
									$("#caja_para_calculos_de_la_compra").html(respuesta);
									$("#caja_para_calculos_de_la_compra").fadeIn(500);
									var monto_bruto=$("#monto_bruto_micoin").val();
									var saldo=$("#saldo").val();
									if(monto_bruto>saldo){
										$("#caja_observacion").html("<h5 class='text-danger bg-dark'><b>SALDO INSUFICIENTE:</b> Tu saldo no es suficiente para realizar esta compra.<br>(El Monto Bruto a Pagar (" + $("#monto_bruto_micoin").val() + "Pm) es Mayor que tu saldo (" + $("#saldo").val() + "Pm))</h5>");
										$("#comprar").attr("disabled", true);
									}else{
										$("#caja_observacion").html("");
										$('#comprar').attr("disabled", false);
									}
									$("#caja_observacion").fadeIn(500);
								});
							}else{
								$("#caja_para_calculos_de_la_compra").hide(500);
								$("#caja_para_calculos_de_la_compra").html("");
								$("#caja_para_calculos_de_la_compra").fadeIn(500);
							}
						});
					});
				</script>
				<div class="m-auto">
					<input type="submit" name="comprar" id="comprar" value="Comprar" class="btn btn-warning mb-2">
				</div>
			</form>
		</div>
		<?php
			}
		?>
		<?php
			}else{
				echo "<br><br><br>";
				echo "<div class='col-md-12 col-lg-10 col-xl-9 mx-auto bg-danger'>";
				echo "<h2 class='text-left py-3 bg-danger text-dark'>No se seleccionó ningún Producto para la Compra. Vuelva al <b><a href='zona_usuario_carrito_compra.php' class='text-dark'>Carrito de la Compra</a></b> o <b><a href='zona_usuario_buscar.php' class='text-dark'>Seleccione un Producto</a></b> nuevamente.</h2>";
				echo "</div>";
				echo "<br><br><br>";
			}
		?>
	<?php
		}
	?>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		<br><br><br><br><br><br><br><br><br><br><br>
	</section>	
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>