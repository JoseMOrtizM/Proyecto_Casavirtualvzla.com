<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>

<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Comprar Varios Producto</title>
</head>
<body class="bg-secondary img-fluid">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="my-3">
	<?php
		if(isset($_POST['FORM'])){
			if($_POST['FORM']=="COMPRAR"){//SI SE DECIDIÓ COMPRAR
				$tipo_de_compra=mysqli_real_escape_string($conexion, $_POST['tipo_de_compra']);
				$cedula_vendedor_i=M_usuarios_R($conexion, 'CEDULA_RIF', $_POST['vend_ceduda_rif'], '', '', '', '');
				$id_producto_a_comprar=$_POST['id_producto'];//array
				$cantidad_a_comprar=$_POST['cantidad'];//array
				$fecha_ahora=mysqli_real_escape_string($conexion, $_POST['fh_formulario']);
				if($tipo_de_compra=="EXPRESS"){
					$fh_pagado=$fecha_ahora;
					$fh_entregado=$fh_pagado;
					$estatus='ENTREGADO';
				}else{
					$fh_pagado=$fecha_ahora;
					$fh_entregado='';
					$estatus='PAGADO';
				}
				$e=0;
				while(isset($id_producto_a_comprar[$e])){
					$datos_de_la_compra=M_carrito_compra_R($conexion, 'mc_carrito_compra', 'ID_PRODUCTO', $id_producto_a_comprar[$e], '', '', '', '', '', '');
					$datos_del_producto=M_productos_y_servicios_R($conexion, 'ID_PRODUCTO', $id_producto_a_comprar[$e], '', '', '', '');
					$precio_unitario=$datos_de_la_compra['PRECIO_UNITARIO_MICOIN'][0];
					$subtotal=$precio_unitario*$cantidad_a_comprar[$e];
					$ranking=$cedula_vendedor_i['RANKING'][0];
					$porc_comision=M_porcentaje_comision_por_venta_producto($ranking);
					$monto_comision=$subtotal*$porc_comision/100;
					$monto_neto=$subtotal-$monto_comision;
					$fh_transaccion_abandonada='';
					$fh_evaluacion='';
					$evaluacion_puntos='';
					$evaluacion_comentario='';
					//INSERTANDO REGISTRO DE COMPRA EN LA BASE DE DATOS
					$verf_insert[$e]=M_control_de_transacciones_micoin_C($conexion, $datos_usuario_session['NOMBRE'][0], $datos_usuario_session['APELLIDO'][0], $datos_usuario_session['CEDULA_RIF'][0], $datos_usuario_session['CORREO'][0], $datos_usuario_session['FECHA_NACIMIENTO'][0], $datos_usuario_session['EMPRESA'][0], $datos_usuario_session['TELEFONO'][0], $datos_usuario_session['DIRECCION'][0], $datos_del_producto['NOMBRE'][0], $datos_del_producto['APELLIDO'][0], $datos_del_producto['CEDULA_RIF'][0], $datos_del_producto['CORREO'][0], $datos_del_producto['FECHA_NACIMIENTO'][0], $datos_del_producto['EMPRESA'][0], $datos_del_producto['TELEFONO'][0], $datos_del_producto['DIRECCION'][0], $tipo_de_compra, $datos_del_producto['NOMBRE_PRODUCTO'][0], $cantidad_a_comprar[$e], $precio_unitario, $subtotal, $ranking, $porc_comision, $monto_comision, $monto_neto, $fh_pagado, $fh_entregado, $fh_transaccion_abandonada, $fh_evaluacion, $evaluacion_puntos, $evaluacion_comentario, $estatus);
					//ACTUALIZANDO CODIGO DE VERIFICACIÓN SI EL REGISTRO ANTERIOR FUÉ EXITOSO
					if($verf_insert[$e]==true){
						$datos_id_de_la_transaccion[$e]= M_control_de_transacciones_obtener_id( $conexion, $datos_usuario_session['CEDULA_RIF'][0], $datos_del_producto['CEDULA_RIF'][0], $cantidad_a_comprar[$e], $datos_del_producto['NOMBRE_PRODUCTO'][0], $fh_pagado);
						if($e==0){
							$datos_seguridad=M_generar_codigo_seguridad($conexion, $datos_usuario_session['CEDULA_RIF'][0], $datos_id_de_la_transaccion[$e]['ID_TRANSACCION'][0]);
							$id_codigo_de_seguridad=$datos_seguridad['ID_TRANSACCION'];
							$codigo_de_seguridad=$datos_seguridad['CODIGO_DE_SEGURIDAD'];
						}else{
							M_copiar_codigo_seguridad($conexion, $id_codigo_de_seguridad, $datos_id_de_la_transaccion[$e]['ID_TRANSACCION'][0]);
						}
						//ACTUALIZANDO EL ESTATUS DEL PRODUTO A "COMPRADO" EN EL CARRITO EN CASO DE QUE EXISTA
						$datos_verficiar_carrito=M_carrito_compra_R($conexion, 'mc_usuarios', 'ID_USUARIO', $datos_usuario_session['ID_USUARIO'][0], 'mc_carrito_compra', 'ESTATUS', 'APARTADO', 'mc_carrito_compra', 'ID_PRODUCTO', $datos_del_producto['ID_PRODUCTO'][0]);
						if(isset($datos_verficiar_carrito['ID_CARRITO_COMPRA'][0])){
							M_carrito_actualizar_estatus($conexion, $datos_usuario_session['ID_USUARIO'][0], $datos_del_producto['ID_PRODUCTO'][0], 'COMPRADO');
						}
						//ACTUALIZANDO EL INVENTARIO DEL PRODUCTO COMPRADO
						$nueva_cantidad_disponible=$datos_del_producto['CANTIDAD_DISPONIBLE'][0]-$cantidad_a_comprar[$e];
						M_productos_y_servicios_U_id_inventario($conexion, $id_producto_a_comprar[$e], $nueva_cantidad_disponible);
						//IMPRIMINDO INFORMACIÓN PARA TRANSACCIÓN EXITOSA
						$datos_saldo_disponible_usuario[$e]=M_saldo_pm_disponible_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
						//insertando datos en MC_BALANCE ADMINISTRATIVO Y EN MC_PARIDAD_CAMBIARIA SI LA COMPRA ES EXPRESS
						if($tipo_de_compra=="EXPRESS"){
							$datos_previos_balance= M_balance_administrativo_lcv_R_ultimo($conexion);
							$verf_adm_y_pc= M_balance_administrativo_lcv_PRECALCULOS($conexion, $fh_pagado, "COMPRA PROD", "", "", $datos_previos_balance['TC_BS_DOLLAR'][0], "", $datos_id_de_la_transaccion[$e]['ID_TRANSACCION'][0]);
						}
						if(!isset($id_producto_a_comprar[$e+1])){
							if($tipo_de_compra=="PREMIUN"){
								echo "<br><br><br>
									<div class='bg-dark mx-5 px-0'>
										<h2 class='text-center bg-success px-3'>Compra Exitosa</h2>
										<h6 class='text-left text-light px-3'>Su Código de Seguiridad es: <b class='text-danger h4'><b>" . $datos_seguridad['CODIGO_DE_SEGURIDAD'] . "</b></b></h6>
										<h6 class='text-left text-light px-3 pb-3'>Por favor, guarde este código. Sólo deberá entregarlo al vendedor al momento de recibir los productos.</h6>
										<br>
										<div class='m-auto'><a href='zona_usuario_carrito_compra.php' class='btn btn-warning mb-2'><span class='fa fa-reply-all'></span> Volver</a></div>
									</div>
								";
							}else{
								echo "<br><br><br><br>
									<div class='bg-dark mx-5 px-0'>
										<h2 class='text-center bg-success px-3'>Compra Exitosa</h2>
										<br>
										<div class='text-center'><a href='zona_usuario_carrito_compra.php' class='btn btn-warning mb-2'><span class='fa fa-reply-all'></span> Volver</a></div>
									</div>
								";
							}
						}
					}else{
						$imp=$e+1;
						echo "<div class='col-md-12 col-lg-10 col-xl-9 mx-auto bg-danger my-3'>";
						echo "<h3 class='text-center bg-danger text-dark px-2 pt-2'>No se pudo registrar la Compra (" . $imp . "). Parece que está intentando realizar una operación que ya está registrada.</h3>";
						echo "</div>";
					}
					$e++;
				}
			}else{
				echo "<br><br><br>";
				echo "<div class='col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark my-3'>";
				echo "<h3 class='text-center text-warning px-2 pt-2'>ALGO ANDA MAL (" . $imp . ")....</h3>";
				echo "</div>";
			}
		}else{
			$cantidad_de_productos=0;
			//rescatar los productos que hay e el carrito para el usuario enviado por $_GET
			if(isset($_GET['vend_ceduda_rif']) or isset($_POST['vend_ceduda_rif'])){
				if(isset($_GET['vend_ceduda_rif'])){
					$vend_ceduda_rif=mysqli_real_escape_string($conexion, $_GET['vend_ceduda_rif']);
				}else if(isset($_POST['vend_ceduda_rif'])){
					$vend_ceduda_rif=mysqli_real_escape_string($conexion, $_POST['vend_ceduda_rif']);
				}
				$datos_saldo_disponible_usuario=M_saldo_pm_disponible_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
				//obteniendo datos de los productos en este carrito
				$datos_del_carrito=M_carrito_compra_R($conexion, 'mc_usuarios', 'ID_USUARIO', $datos_usuario_session['ID_USUARIO'][0], 'mc_carrito_compra', 'ESTATUS', 'APARTADO', 'mc_productos_y_servicios', 'CEDULA_RIF', $vend_ceduda_rif);
				//calculando monto total a pagar
				$total_a_pagar=0;
				$i=0;
				while(isset($datos_del_carrito['NOMBRE_PRODUCTO'][$i])){
					$precio_unitario[$i]=(float) $datos_del_carrito['PRECIO_UNITARIO_MICOIN'][$i];
					$cantidad[$i]=(float) $datos_del_carrito['CANTIDAD'][$i];
					$total_a_pagar=$total_a_pagar+($precio_unitario[$i]*$cantidad[$i]);
					$i++;
				}
				if($total_a_pagar>$datos_saldo_disponible_usuario['SALDO_PEMON'][0]){
					echo "<br><br><br>";
					echo "<div class='col-md-12 col-lg-10 col-xl-9 mx-auto bg-danger my-3'>";
					echo "<h3 class='text-center bg-danger text-dark px-2 pt-2'><b>SALDO INSUFICIENTE:</b> Tu saldo no es suficiente para realizar esta compra.</h3>";
					echo "</div>";
					echo "<br><br><br>";
				}else{
					//IMPRIMIENDO EL FORMULARIO PARA LA COMPRA DE TODOS LOS PRODUCTOS
					echo "
					<div class='container-fluid bg-dark'>
						<h3 class='text-center text-warning px-2 pt-2'><b>Comprar a: <i  class='text-light'>" . $datos_del_carrito['VEND_NOMBRE'][0] . "</i></b></h3>";
					echo "<h5 class='text-center text-success px-2'><b>(Saldo: <b class='text-light'>" . number_format($datos_saldo_disponible_usuario['SALDO_PEMON'][0], 2,',','.') . " Pm</b>)</b></h5>";
					echo "
						<form action='zona_usuario_comprar_varios.php' method='post' class='text-center bg-dark py-2 px-0 rounded'>
							<input type='hidden' name='fh_formulario' id='fh_formulario' value='" . date("Y-m-d h:m:s") . "'>
							<input type='hidden' name='FORM' id='FORM' value='COMPRAR'>
							<input type='hidden' name='vend_ceduda_rif' id='vend_ceduda_rif' value='" . $datos_del_carrito['VEND_CEDULA_RIF'][0] . "'>
							<input type='hidden' name='saldo' id='saldo' value='" . $datos_saldo_disponible_usuario['SALDO_PEMON'][0] . "'>
					";
					echo "
							<div class='input-group mb-2'>
								<div class='col-md-4 p-0 m-0'></div>
								<div class='col-md-2 p-0 m-0'>
									<span class='input-group-text rounded-0 w-100'><b class='text-danger'>Tipo de Compra:</b></span>
								</div>
								<select class='form-control col-md-2 p-0 m-0 px-2 rounded-0' name='tipo_de_compra' id='tipo_de_compra' required autocomplete='off' title='Indique el Tipo de Compra'>
									<option>EXPRESS</option>
									<option>PREMIUN</option>
								</select>
								<div class='col-md-4 p-0 m-0'></div>
							</div>
					";
					echo "
							<div class='bg-dark px-0'>
								<table class='bg-light table table-bordered table-hover'>
									<tr>
										<th colspan='4' class='bg-dark text-warning h4'><b>Detalle de Productos</b></th>
									</tr>
									<tr class='bg-warning'>
										<th class='w-25' title='Nombre del Producto'>Nombre</th>
										<th class='w-25' title='Cantidad a Comprar'>Cant</th>
										<th class='w-25' title='Precio Unitario del Producto'>P/U (Pm)</th>
										<th class='w-25' title='Sub-Total Importe'>Total (Pm)</th>
									</tr>
					";
					$i=0;
					while(isset($datos_del_carrito['NOMBRE_PRODUCTO'][$i])){
						if($datos_del_carrito['NOMBRE_PRODUCTO'][$i]<>""){
							$sub_total=$datos_del_carrito['CANTIDAD'][$i]*$datos_del_carrito['PRECIO_UNITARIO_MICOIN'][$i];
							echo "<tr>";
							echo "<input type='hidden' name='id_producto[]' id='id_producto_$i' value='" . $datos_del_carrito['ID_PRODUCTO'][$i] . "'>";
							echo "<td class='px-0'>" . $datos_del_carrito['NOMBRE_PRODUCTO'][$i] . "</td>";
							echo "<td><input type='number' name='cantidad[]' id='cantidad_$i' class='form-control p-0 m-0 px-0 rounded-0 w-100 m-auto text-center clase_cantidad' value='" . $datos_del_carrito['CANTIDAD'][$i] . "' required autocomplete='off' title='Introduzca la cantidad de productos que desea comprar' step='any' min='1'></td>";
							echo "<td class='px-0'><input type='hidden' id='precio_x_producto_$i' value='" . $datos_del_carrito['PRECIO_UNITARIO_MICOIN'][$i] . "'>" . number_format($datos_del_carrito['PRECIO_UNITARIO_MICOIN'][$i], 2,',','.') . "</td>";
							echo "<td class='px-0'><div class='sub_totales' id='subtotal_x_producto_$i'>" . number_format($sub_total, 2,',','.') . "</div></td>";
							echo "</tr>";
						}
		?>
		<script type="text/javascript">
			$("#<?php echo "cantidad_" . $i; ?>").on('change', function(){
				//ESTA FUNCIÓN SIRVE PARA COLOCAR EL SEPARADOR DE MILES ///
				var formatNumber = {
					separador: ".", // separador para los miles
					sepDecimal: ',', // separador para los decimales
					formatear:function (num){
						num +='';
						var splitStr = num.split('.');
						var splitLeft = splitStr[0];
						var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
						var regx = /(\d+)(\d{3})/;
						while (regx.test(splitLeft)) {
							splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
						}
						return this.simbol + splitLeft +splitRight;
					},
					new:function(num, simbol){
						this.simbol = simbol ||'';
						return this.formatear(num);
					}
				};
				var cantidad=$("#<?php echo "cantidad_" . $i; ?>").val();
				var precio_unitario=$("#<?php echo "precio_x_producto_" . $i; ?>").val();
				var precio_bruto=(cantidad*precio_unitario).toFixed(2);
				var precio_bruto_calculado=(cantidad*precio_unitario);
				$("#<?php echo "subtotal_x_producto_" . $i; ?>").html(formatNumber.new(precio_bruto));
				$("#<?php echo "subtotal_x_producto_calculo_" . $i; ?>").html(precio_bruto_calculado);
				var total_general=0;
				$(".sub_totales").each(function(indice, elemento){
					total_general=total_general+parseFloat($(elemento).text());
				});
				var total_general_imprimir=total_general.toFixed(2);
				$("#total_general").html(formatNumber.new(total_general_imprimir));
				if(total_general>$("#saldo").val()){
					$("#caja_observacion").html("<h5 class='text-danger bg-dark'><b>SALDO INSUFICIENTE:</b> Tu saldo no es suficiente para realizar estas compras.<br>(El Monto a Pagar (" + total_general_imprimir + "Pm) es Mayor que tu saldo (" + $("#saldo").val() + "Pm))</h5>");
					$("#comprar").attr("disabled", true);
				}else{
					$("#caja_observacion").html("");
					$('#comprar').attr("disabled", false);
				}
			});
		</script>
		<?php
						$i++;
					}
					$cantidad_de_productos=$i;
					echo "
						<tr>
							<th colspan='3' class='bg-dark text-center text-warning'>Total General:</th>
							<th><div id='total_general'>" . number_format($total_a_pagar, 2,',','.') . "</div></th>
						</tr>
					";
					echo "
								</table>
								<div id='caja_observacion'></div>
								<div class='m-auto'>
									<a href='zona_usuario_carrito_compra.php' class='btn btn-warning mb-2'><span class='fa fa-reply-all'></span> Volver</a>&nbsp;&nbsp;&nbsp;<input type='submit' name='comprar' id='comprar' value='Comprar' class='btn btn-warning mb-2'>
								</div>
							</div>
					";
					echo "
						</form>
					</div>
					";
				}
			}else{
				echo "<br><br><br>
				<div class='container'>
					<h3 class='bg-danger text-center'>NO SE SELECCIONÓ NINGÚN PRODUCTO:<br>Por favor vuelva al carrito e inténtelo de nuevo.</h3>
				</div>
				<br><br><br>";
			}
		}
	?>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	</section>	
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>