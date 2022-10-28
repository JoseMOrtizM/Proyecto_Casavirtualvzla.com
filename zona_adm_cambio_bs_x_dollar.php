<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
//VERIFICANDO ACCIÓN DE INSERTAR:
if(isset($_POST['FORM'])){
	if($_POST['FORM']=='REGISTRAR'){
		$fh_registro=mysqli_real_escape_string($conexion,$_POST['fh_registro']);
		$tipo=mysqli_real_escape_string($conexion,$_POST['tipo_operacion']);
		$bs_por_dollar_compra=mysqli_real_escape_string($conexion, $_POST['bs_por_dollar_compra']);
		//insertando datos en MC_BALANCE ADMINISTRATIVO Y EN MC_PARIDAD_CAMBIARIA
		$verf_adm_y_pc=M_balance_administrativo_lcv_PRECALCULOS($conexion, $fh_registro, $tipo, "", "", $bs_por_dollar_compra, "", "");
	}
}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>Actualizar Bs/$</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid mt-2 mb-5 bg-secondary px-0">
		<br>
		<div class="col-12 col-lg-9 mx-auto px-0">
			<?php
				if(isset($verf_adm_y_pc)){
					if($verf_adm_y_pc){
						echo "<h3 class='text-center text-light pb-3 bg-success'>REGISTRO EXITOSO</h3>";
					}else{
						echo "<h3 class='text-center text-light pb-3 bg-danger'>REGISTRO NO EXITOSO</h3>
						<h6 class='text-center text-light pb-3 bg-danger'>(Verifique que el registro no se esté cargando por duplicado)</h6>";
					}
				}
			?>
			<br>
			<?php
				if(isset($_POST['FORM'])){
					if($_POST['FORM']=='REGISTRAR_PREVIO'){
			?>
			<form action="zona_adm_cambio_bs_x_dollar.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="FORM" id="FORM" value="REGISTRAR">
				<input type="hidden" name="fh_registro" id="fh_registro" value="<?php echo date("Y-m-d h:m:s"); ?>">
				<input type="hidden" name="tipo_operacion" id="tipo_operacion" value="ACTUALIZAR TASA DE CAMBIO (Bs/$)">
				<input type="hidden" name="bs_por_dollar_compra" id="bs_por_dollar_compra" value="<?php echo $_POST['bs_por_dollar_compra']; ?>">
				<h3 class="text-center text-warning">Confirmar Tasa de Cambio</h3>
				<div class="bg-light text-dark p-1 m-1">
					<?php
						$datos_ultimo_balance_ii= M_balance_administrativo_lcv_R_ultimo($conexion);
					?>
					<h6><b>Bs/$ Anterior:</b> <?php echo number_format($datos_ultimo_balance_ii['TC_BS_DOLLAR'][0], 2,',','.'); ?></h6>
					<h6><b>Bs/$ Nuevo:</b> <?php echo number_format($_POST['bs_por_dollar_compra'], 2,',','.');?></h6>
					<?php
						$viejo=$datos_ultimo_balance_ii['TC_BS_DOLLAR'][0];
						$nuevo=$_POST['bs_por_dollar_compra'];
						if($viejo*1.05<$nuevo or $viejo*.95>$nuevo){
							echo "<h1 class='text-danger text-center'><b>¡ALERTA!</b></h1>";
							echo "<h6 class='text-dark text-center small'>Hay mucha diferencia entre las tasas...</h6>";
						}else{
							//Esta dentro de lo esperado
						}
					?>
				</div>
				<div class="m-auto">
					<a href='zona_adm_cambio_bs_x_dollar.php' class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;&nbsp;
					<input type="submit" value="Confirmar Operación &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
			<?php			
					}
				}else{// AQUI VA EL FORMULARIO POR DEFECTO QUE MUESTRA LA PAGINA CUANDO SE ENTRA POR PRIMERA VEZ
			?>
			<form action="zona_adm_cambio_bs_x_dollar.php" method="post" class="text-center bg-dark p-2 rounded">
				<input type="hidden" name="FORM" id="FORM" value="REGISTRAR_PREVIO">
				<input type="hidden" name="fh_registro" id="fh_registro" value="<?php echo date("Y-m-d h:m:s"); ?>">
				<h3 class="text-center text-warning">Actualizar Bs/$</h3>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 rounded-0">Tipo de Operación:</span>
					</div>
					<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_operacion" id="tipo_operacion" required autocomplete="off" title="Indique el Tipo de Operación a registrar">
						<option value='ACTUALIZAR TASA DE CAMBIO (Bs/$)'>Actualizar Bs/$</option>
					</select>
				</div>
				<div class="input-group mb-2">
					<div class="col-md-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100">Bs/$ (Compra):</span>
					</div>
					<?php
						$datos_ultimo_balance_ii= M_balance_administrativo_lcv_R_ultimo($conexion);
					?>
					<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="bs_por_dollar_compra" id="bs_por_dollar_compra" placeholder="Última Tasa: <?php echo number_format($datos_ultimo_balance_ii['TC_BS_DOLLAR'][0], 2,',','.'); ?>" required autocomplete="off" title="Introduzca Tasa de cambio Bs/$ para la Compra" step="any">
				</div>
				<div class="m-auto">
					<input type="submit" value="Registrar Operación &raquo;" class="btn btn-warning mb-2">
				</div>
				<h5 class="text-center text-danger">Tasas de Cambio Sugeridas:</h5>
				<div id="caja_scrapping" class="bg-light">
					<h3 class="text-muted"><span class="fa fa-spinner fa-spin"></span> Cargando...</h3>
				</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$.ajax("PHP_MODELO/S_scrapping_bolivar_x_dollar.php",{data:{ninguna:0}, type:'post'}).done(function(respuesta){
							$("#caja_scrapping").html(respuesta);
							$("#caja_scrapping").fadeIn(500);
						});
					});
				</script>
			</form>
			<?php		
				}
			?>
		</div>
		<br><br><br><br><br><br><br><br><br><br>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>