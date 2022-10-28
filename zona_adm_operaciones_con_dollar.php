<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
//VERIFICANDO ACCIÓN DE INSERTAR:
if(isset($_POST['FORM'])){
	if($_POST['FORM']=='REGISTRAR'){
		$fh_registro=mysqli_real_escape_string($conexion,$_POST['fh_registro']);
		if(isset($_POST['cliente_nombre'])){
			$nombre=mysqli_real_escape_string($conexion,$_POST['cliente_nombre']);
			$apellido=mysqli_real_escape_string($conexion,$_POST['cliente_apellido']);
			$cedula_rif=mysqli_real_escape_string($conexion,$_POST['cliente_cedula_rif']);
			$telefono=mysqli_real_escape_string($conexion,$_POST['cliente_telefono']);
			$direccion=mysqli_real_escape_string($conexion,$_POST['cliente_direccion']);
		}else{
			$cedula_rif=mysqli_real_escape_string($conexion,$_POST['datos_cliente']);
			$otros_datos=M_control_cambio_dollar_bolivar_R($conexion, 'CEDULA_RIF', $cedula_rif, '', '', '', '');
			$nombre=$otros_datos['NOMBRE'][0];
			$apellido=$otros_datos['APELLIDO'][0];
			$telefono=$otros_datos['TELEFONO'][0];
			$direccion=$otros_datos['DIRECCION'][0];
		}
		$tipo=mysqli_real_escape_string($conexion,$_POST['tipo_operacion']);
		$dollares=mysqli_real_escape_string($conexion,$_POST['dollares']);
		$bolivares=mysqli_real_escape_string($conexion,$_POST['bolivares']);
		if(isset($_POST['descripcion'])){
			$descripcion=mysqli_real_escape_string($conexion,$_POST['descripcion']);
		}else{
			$descripcion="";
		}
		if(isset($_POST['observacion'])){
			$observacion=mysqli_real_escape_string($conexion,$_POST['observacion']);
		}else{
			$observacion="";
		}
		$bs_por_dollar_compra=mysqli_real_escape_string($conexion, $_POST['bs_por_dollar_compra']);
		//insertando datos en MC_CONTROL_CAMBIO_DOLLAR_BOLIVAR
		$verf_insert=M_control_cambio_dollar_bolivar_C($conexion, $nombre, $apellido, $cedula_rif, $telefono, $direccion, $fh_registro, $tipo, $dollares, $bolivares, $descripcion, $observacion);
		if($verf_insert){
			//obteniendo el id del registro recien insertado
			$dato_id=M_control_cambio_dollar_bolivar_R_id_registro($conexion, $nombre, $apellido, $cedula_rif, $telefono, $direccion, $fh_registro, $tipo, $dollares, $bolivares, $descripcion, $observacion);
			//insertando datos en MC_BALANCE ADMINISTRATIVO Y EN MC_PARIDAD_CAMBIARIA
			$verf_adm_y_pc=M_balance_administrativo_lcv_PRECALCULOS($conexion, $fh_registro, $tipo, $bolivares, $dollares, $bs_por_dollar_compra, "", $dato_id['ID_CV_DOLLAR'][0]);
		}
	}
}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>Operaciones en $</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid mt-2 mb-5 bg-secondary px-0">
		<br>
		<div class="col-12 col-lg-9 mx-auto px-0">
		<?php
			if(isset($_POST['FORM'])){
				if($_POST['FORM']=='REGISTRAR_PREVIO'){
		?>
			<form action="zona_adm_operaciones_con_dollar.php" method="post" class="text-center bg-dark p-2 rounded" name="formulario_dollar_1">
				<h5 class="text-center text-warning pb-3"><b>Confirmar Operación en $</b></h5>
				<input type="hidden" name="FORM" id="FORM" value="REGISTRAR">
				<input type="hidden" name="fh_registro" id="fh_registro" value="<?php echo $_POST['fh_registro']; ?>">
				<input type="hidden" name="tipo_de_cliente" id="tipo_de_cliente" value="<?php echo $_POST['tipo_de_cliente']; ?>">
				<?php
					if(isset($_POST['cliente_nombre'])){
				?>
					<input type="hidden" name="cliente_nombre" id="cliente_nombre" value="<?php echo $_POST['cliente_nombre']; ?>">
					<input type="hidden" name="cliente_apellido" id="cliente_apellido" value="<?php echo $_POST['cliente_apellido']; ?>">
					<input type="hidden" name="cliente_cedula_rif" id="cliente_cedula_rif" value="<?php echo $_POST['cliente_cedula_rif']; ?>">
					<input type="hidden" name="cliente_telefono" id="cliente_telefono" value="<?php echo $_POST['cliente_telefono']; ?>">
					<input type="hidden" name="cliente_direccion" id="cliente_direccion" value="<?php echo $_POST['cliente_direccion']; ?>">
				<?php
					}else{
				?>
					<input type="hidden" name="datos_cliente" id="datos_cliente" value="<?php echo $_POST['datos_cliente']; ?>">
				<?php
					}
				?>
				<input type="hidden" name="tipo_operacion" id="tipo_operacion" value="<?php echo $_POST['tipo_operacion']; ?>">
				<input type="hidden" name="dollares" id="dollares" value="<?php echo $_POST['dollares']; ?>">
				<input type="hidden" name="bolivares" id="bolivares" value="<?php echo $_POST['bolivares']; ?>">
				<?php
					if(isset($_POST['descripcion'])){
						echo "<input type='hidden' name='descripcion' id='descripcion' value='" . $_POST['descripcion'] . "'>";
					}
					if(isset($_POST['observacion'])){
						echo "<input type='hidden' name='observacion' id='observacion' value='" . $_POST['observacion'] . "'>";
					}
				?>
				<input type="hidden" name="bs_por_dollar_compra" id="bs_por_dollar_compra" value="<?php echo $_POST['bs_por_dollar_compra']; ?>">
				<div class="m-1 p-1 bg-light text-dark text-center">
					<h6><b><?php echo $_POST['tipo_operacion']; ?></b></h6>
					<h6><b>$:</b> <?php echo number_format($_POST['dollares'], 2,',','.'); ?> vs. <b>Bs:</b> <?php echo number_format($_POST['bolivares'], 2,',','.'); ?></h6>
					<?php
						$del_sistema=$_POST['bs_por_dollar_compra'];
						$calculado=$_POST['bolivares']/$_POST['dollares'];
						if($calculado>$del_sistema*.9 and $calculado<$del_sistema*1.1){
							//Esta dentro de lo esperado
						}else{
							echo "<h1 class='text-danger text-center'><b>¡ALERTA!</b></h1>";
						}
					?>
					<h6><b>Bs/$ - Sistema:</b> <?php echo number_format($_POST['bs_por_dollar_compra'], 2,',','.'); ?></h6>
					<h6><b>Bs/$ Calculados:</b> <?php echo number_format($_POST['bolivares']/$_POST['dollares'], 2,',','.'); ?></h6>
				</div>
				<div class="m-auto">
					<a href='zona_adm_operaciones_con_dollar.php' class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;
					<input type="submit" value="Confirmar Operación &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
		<?php
				}else{
					echo "<br><br><br>";
					echo "<div class='text-center bg-dark p-2 rounded'>";
					if(isset($verf_insert)){
						if($verf_insert and $verf_adm_y_pc){
							echo "<h3 class='text-center text-light bg-success'>REGISTRO EXITOSO</h3>
							<div class='m-auto text-center'>
								<a href='zona_adm_operaciones_con_dollar.php' class='btn btn-warning text-dark mb-2'><span class='fa fa-reply-all'></span> Volver</a>
							</div>";
						}else if($verf_insert==false or $verf_adm_y_pc==false){
							echo "<h3 class='text-center text-light bg-danger'>REGISTRO NO EXITOSO</h3>
							<h6 class='text-center text-light pb-3'>(Verifique que el registro no se esté cargando por duplicado)</h6>
							<div class='m-auto text-center'>
								<a href='zona_adm_operaciones_con_dollar.php' class='btn btn-warning text-dark mb-2'><span class='fa fa-reply-all'></span> Volver</a>
							</div>";
						}else{
							echo "<h3 class='text-center text-light pb-3 bg-danger'>ALGO ANDA MAL...</h3>
							<div class='m-auto text-center'>
								<a href='zona_adm_operaciones_con_dollar.php' class='btn btn-warning text-dark mb-2'><span class='fa fa-reply-all'></span> Volver</a>
							</div>";
						}
					}
					echo "</div>";
				}
			}else{
		?>
			<?php
			?>
			<form action="zona_adm_operaciones_con_dollar.php" method="post" class="text-center bg-dark p-2 rounded" name="formulario_dollar">
				<h3 class="text-center text-warning pb-3">Operaciones en $</h3>
				<input type="hidden" name="FORM" id="FORM" value="REGISTRAR_PREVIO">
				<input type="hidden" name="fh_registro" id="fh_registro" value="<?php echo date("Y-m-d h:m:s"); ?>">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Tipo de Cliente:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_de_cliente" id="tipo_de_cliente" required autocomplete="off" title="Indique el Tipo de Cliente (Nuevo o Existente)">
						<option></option>
						<option>Nuevo Cliente</option>
						<option>Cliente Registrado</option>
					</select>
				</div>
				<div id="caja_cliente"></div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#tipo_de_cliente").on('change', function(){
							var tipo_de_cliente=$("#tipo_de_cliente").val();
							$.ajax("PHP_MODELO/S_devuelve_datos_del_cliente.php",{data:{tipo_de_cliente:tipo_de_cliente}, type:'post'}).done(function(respuesta){
								$("#caja_cliente").hide(500);
								$("#caja_cliente").html(respuesta);
								$("#caja_cliente").fadeIn(500);
							});
						});
					});
				</script>
				<h5 class="text-center text-warning">Datos de la Operación:</h5>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Tipo de Operación:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_operacion" id="tipo_operacion" required autocomplete="off" title="Indique el Tipo de Operación a registrar">
						<option></option>
						<option>COMPRA DOLLAR RESPALDO</option>
						<option>VENTA DOLLAR RESPALDO</option>
						<option>COMPRA DOLLAR INGRESOS</option>
						<option>VENTA DOLLAR INGRESOS</option>
					</select>
				</div>
				<div id="caja_tipo_de_operacion"></div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#tipo_operacion").on('change', function(){
							var tipo_operacion=$("#tipo_operacion").val();
							$.ajax("PHP_MODELO/S_devuelve_datos_c_v_dollares.php",{data:{tipo_operacion:tipo_operacion}, type:'post'}).done(function(respuesta){
								$("#caja_tipo_de_operacion").hide(500);
								$("#caja_tipo_de_operacion").html(respuesta);
								$("#caja_tipo_de_operacion").fadeIn(500);
							});
						});
					});
				</script>
				<h5 class="text-center text-warning">Datos Tasa de Cambio:</h5>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Bs/$ (Compra):</span>
					</div>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="bs_por_dollar_compra" id="bs_por_dollar_compra" placeholder="Tasa de cambio Bs/$" required autocomplete="off" title="Introduzca Tasa de cambio Bs/$" step="any"
					<?php
						$datos_ultimo_balance_ii=M_balance_administrativo_lcv_R_ultimo($conexion);
						echo "value='" . $datos_ultimo_balance_ii['TC_BS_DOLLAR'][0]. "'";
					?>
					>
				</div>
				<div class="m-auto">
					<input type="submit" value="Registrar Operación &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
		<?php		
			}
		?>
		</div>
		<br><br><br><br><br><br>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>