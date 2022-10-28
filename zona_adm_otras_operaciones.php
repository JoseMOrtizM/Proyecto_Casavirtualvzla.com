<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
//VERIFICANDO ACCIÓN DE INSERTAR:
if(isset($_POST['FORM'])){
	if($_POST['FORM']=='REGISTRAR'){
		$fh_registro=mysqli_real_escape_string($conexion,$_POST['fh_registro']);
		$tipo=mysqli_real_escape_string($conexion,$_POST['tipo_operacion']);
		$dollares=mysqli_real_escape_string($conexion,$_POST['dollares']);
		$bolivares=mysqli_real_escape_string($conexion,$_POST['bolivares']);
		$descripcion=mysqli_real_escape_string($conexion,$_POST['descripcion']);
		$bs_por_dollar_compra=mysqli_real_escape_string($conexion, $_POST['bs_por_dollar_compra']);
		//insertando datos en MC_BALANCE ADMINISTRATIVO Y EN MC_PARIDAD_CAMBIARIA
		$verf_adm_y_pc=M_balance_administrativo_lcv_PRECALCULOS($conexion, $fh_registro, $tipo, $bolivares, $dollares, $bs_por_dollar_compra, $descripcion, "");
	}
}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>Otras Operaciones</title>
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
			<form action="zona_adm_otras_operaciones.php" method="post" class="text-center bg-dark p-2 rounded" name="formulario_otros">
				<h4 class="text-center text-warning pb-3">Confirmar Operación</h4>
				<input type="hidden" name="FORM" id="FORM" value="REGISTRAR">
				<input type="hidden" name="fh_registro" id="fh_registro" value="<?php echo $_POST['fh_registro']; ?>">
				<input type="hidden" name="tipo_operacion" id="tipo_operacion" value="<?php echo $_POST['tipo_operacion']; ?>">
				<input type="hidden" name="bolivares" id="bolivares" value="<?php echo $_POST['bolivares']; ?>">
				<input type="hidden" name="dollares" id="dollares" value="<?php echo $_POST['dollares']; ?>">
				<?php
					if(isset($_POST['descripcion'])){
						echo "<input type='hidden' name='descripcion' id='descripcion' value='" . $_POST['descripcion'] . "'>";
					}else{
						echo "<input type='hidden' name='descripcion' id='descripcion' value=''>";
					}
				?>
				<input type="hidden" name="bs_por_dollar_compra" id="bs_por_dollar_compra" value="<?php echo $_POST['bs_por_dollar_compra']; ?>">
				<div class="m-1 p-1 bg-light text-dark text-center">
					<h6><b><?php echo $_POST['tipo_operacion']; ?></b></h6>
					<h6><b>$:</b> <?php echo number_format($_POST['dollares'], 2,',','.'); ?> + <b>Bs:</b> <?php echo number_format($_POST['bolivares'], 2,',','.'); ?></h6>
				</div>
				<div class="m-auto">
					<a href='zona_adm_otras_operaciones.php' class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;
					<input type="submit" value="Confirmar Operación &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
		<?php
				}else{
					echo "<br><br><br>";
					echo "<div class='text-center bg-dark p-2 rounded'>";
					if(isset($verf_adm_y_pc)){
						if($verf_adm_y_pc){
							echo "<h3 class='text-center text-light pb-3 bg-success'>REGISTRO EXITOSO</h3>
							<div class='m-auto text-center'>
								<a href='zona_adm_otras_operaciones.php' class='btn btn-warning text-dark mb-2'><span class='fa fa-reply-all'></span> Volver</a>
							</div>";
						}else if($verf_adm_y_pc==false){
							echo "<h3 class='text-center text-light bg-danger'>REGISTRO NO EXITOSO</h3>
							<h6 class='text-center text-light pb-3'>(Verifique que el registro no se esté cargando por duplicado)</h6>
							<div class='m-auto text-center'>
								<a href='zona_adm_otras_operaciones.php' class='btn btn-warning text-dark mb-2'><span class='fa fa-reply-all'></span> Volver</a>
							</div>";
						}else{
							echo "<h3 class='text-center text-light pb-3 bg-danger'>ALGO ANDA MAL...</h3>
							<div class='m-auto text-center'>
								<a href='zona_adm_otras_operaciones.php' class='btn btn-warning text-dark mb-2'><span class='fa fa-reply-all'></span> Volver</a>
							</div>";
						}
					}
					echo "</div>";
				}
			}else{
		?>
			<form action="zona_adm_otras_operaciones.php" method="post" class="text-center bg-dark p-2 rounded" name="formulario_otros">
				<h4 class="text-center text-warning pb-3">Otras Operaciones</h4>
				<input type="hidden" name="FORM" id="FORM" value="REGISTRAR_PREVIO">
				<input type="hidden" name="fh_registro" id="fh_registro" value="<?php echo date("Y-m-d h:m:s"); ?>">
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Tipo de Operación:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_operacion" id="tipo_operacion" required autocomplete="off" title="Indique el Tipo de Operación a registrar">
						<option></option>
						<option>GASTO</option>
						<option>PAGO DE IMPUESTO</option>
						<option>REINVERSION</option>
						<option>REPARTO DE DIVIDENDOS</option>
					</select>
				</div>
				<?php
					$datos_ultimo_balance_ii=M_balance_administrativo_lcv_R_ultimo($conexion);
				?>
				<div class='input-group mb-2'>
					<div class='col-md-3 p-0 m-0'>
						<span class='input-group-text rounded-0 w-100'>Bolivares:</span>
					</div>
					<input type='number' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='bolivares' id='bolivares' placeholder='máximo: <?php echo number_format($datos_ultimo_balance_ii['RA_IE_BS_PUROS'][0], 2,',','.'); ?>' required autocomplete='off' title='Introduzca la cantidad de bolívares de la operación' step='0.01' min='0' max='<?php echo $datos_ultimo_balance_ii['RA_IE_BS_PUROS'][0]; ?>'>
				</div>
				<div class='input-group mb-2'>
					<div class='col-md-3 p-0 m-0'>
						<span class='input-group-text rounded-0 w-100'>Dollares:</span>
					</div>
					<input type='number' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='dollares' id='dollares' placeholder='máximo: <?php echo number_format($datos_ultimo_balance_ii['RA_IE_DOLLARES_PUROS'][0], 2,',','.'); ?>' required autocomplete='off' title='Introduzca la cantidad de dollares de la operación' step='0.01' min='0' max='<?php echo $datos_ultimo_balance_ii['RA_IE_DOLLARES_PUROS'][0]; ?>'>
				</div>
				<div class="input-group mb-2">
					<span class="input-group-text rounded-0 w-100">Descripción:</span>
					<textarea class="form-control p-0 m-0 px-2 rounded-0" name="descripcion" id="descripcion" placeholder="Introduzca una descripción (Opcional)" autocomplete="off" title="Introduzca una descripción (Opcional)" rows="2"></textarea>
				</div>
				<h5 class="text-center text-warning">Datos Tasa de Cambio:</h5>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Bs/$ (Compra):</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="bs_por_dollar_compra" id="bs_por_dollar_compra">
						<option value="<?php echo $datos_ultimo_balance_ii['TC_BS_DOLLAR'][0]; ?>"><?php echo number_format($datos_ultimo_balance_ii['TC_BS_DOLLAR'][0], 2,',','.'); ?></option>
					</select>
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