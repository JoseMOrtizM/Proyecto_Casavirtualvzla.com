<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST['FORM'])){
		if($_POST['FORM']=='INSERTAR'){
			$fh_registro=mysqli_real_escape_string($conexion,$_POST['fh_registro']);
			$tipo_de_moneda_real=mysqli_real_escape_string($conexion,$_POST['tipo']);
			$tipo_por_micoin_compra=mysqli_real_escape_string($conexion,$_POST['tipo_por_micoin_compra']);
			$tipo_por_micoin_venta=mysqli_real_escape_string($conexion,$_POST['tipo_por_micoin_venta']);
			$porc_comision_por_compra=mysqli_real_escape_string($conexion,$_POST['porc_comision_por_compra']);
			$porc_comision_por_venta=mysqli_real_escape_string($conexion,$_POST['porc_comision_por_venta']);
			$verf_insert=M_paridad_cambiaria_C($conexion, $fh_registro, $tipo_de_moneda_real, $tipo_por_micoin_compra, $tipo_por_micoin_venta, $porc_comision_por_compra, $porc_comision_por_venta);
		}else if($_POST['FORM']=='MODIFICAR'){
			$id_tasa_de_cambio=mysqli_real_escape_string($conexion, $_POST['id_tasa_de_cambio']);
			$fh_registro=mysqli_real_escape_string($conexion,$_POST['fh_registro']);
			$tipo_de_moneda_real=mysqli_real_escape_string($conexion,$_POST['tipo']);
			$tipo_por_micoin_compra=mysqli_real_escape_string($conexion,$_POST['tipo_por_micoin_compra']);
			$tipo_por_micoin_venta=mysqli_real_escape_string($conexion,$_POST['tipo_por_micoin_venta']);
			$porc_comision_por_compra=mysqli_real_escape_string($conexion,$_POST['porc_comision_por_compra']);
			$porc_comision_por_venta=mysqli_real_escape_string($conexion,$_POST['porc_comision_por_venta']);
			M_paridad_cambiaria_U_id($conexion, $id_tasa_de_cambio, $fh_registro, $tipo_de_moneda_real, $tipo_por_micoin_compra, $tipo_por_micoin_venta, $porc_comision_por_compra, $porc_comision_por_venta);
		}else if($_POST['FORM']=='BORRAR'){
			$id_tasa_de_cambio=mysqli_real_escape_string($conexion, $_POST['id_tasa_de_cambio']);
			M_paridad_cambiaria_D_id($conexion, $id_tasa_de_cambio);
		}
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>BD-Tasa de Cambio</title>
</head>
<body>
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid px-0 mx-0 mx-md-2 px-md-4 mt-2 mb-5 bg-secondary">
		<br>
	<?php
	//VERIFICANDO Si SE MARCO ALGUNA OPCION EN LA TABLA PRINCIPAL DEL CRUD
	if(isset($_GET["accion"])){
			//SI SE QUIERE INSERTAR UN NUEVO RENGLON ENTONCES:
		if($_GET["accion"]=='insertar'){
	?>
			<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
				<div class="row mt-4 align-items-center rounded-top px-2">
					<div class="col-md-9 mb-1 mt-3">
						<h3 class="text-center text-md-left text-warning">Insertar Tasa de Cambio:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1 mt-3">
						<a href="CRUD_paridad_cambiaria.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_paridad_cambiaria.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="FORM" id="FORM" value="INSERTAR">
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Tipo Cambio:</span>
						</div>
						<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo" id="tipo" required autocomplete="off" title="Indique la moneda de transacción">
							<option></option>
							<?php
								$monedas=M_tipos_de_moneda();
								$e=0;
								while($monedas[$e]){
									echo "<option>" . $monedas[$e] . "</option>";
									$e=$e+1;
								}
							?>
						</select>
					</div>
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Tipo/Pm Compra:</span>
						</div>
						<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_por_micoin_compra" id="tipo_por_micoin_compra" placeholder="Introduzca Tipo de Moneda/Pm Compra" required autocomplete="off" title="Introduzca Tipo de Moneda/Pm Compra" step="any">
					</div>
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Tipo/Pm Venta:</span>
						</div>
						<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_por_micoin_venta" id="tipo_por_micoin_venta" placeholder="Introduzca Tipo de Moneda/Pm Venta" required autocomplete="off" title="Introduzca Tipo de Moneda/Pm Venta" step="any">
					</div>
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">%Comisión Compra:</span>
						</div>
						<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="porc_comision_por_compra" id="porc_comision_por_compra" placeholder="Introduzca el % de comisión por compra de moneda virtual" required autocomplete="off" title="Introduzca el % de comisión por compra de moneda virtual" step="any">
					</div>
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">%Comisión Venta:</span>
						</div>
						<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="porc_comision_por_venta" id="porc_comision_por_venta" placeholder="Introduzca el % de comisión por venta de moneda virtual" required autocomplete="off" title="Introduzca el % de comisión por venta de moneda virtual" step="any">
					</div>
					<div class="input-group" id="caja_para_fecha_nacimiento">
						<div id='click01' class='input-group date pickers mb-2'>
							<div class='col-md-3 p-0 m-0'>
								<span class='input-group-text rounded-0 w-100' title="Fecha de Registro">Fecha Reg.:</span>
							</div>
							<input id='datepicker01' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fh_registro' placeholder='Fecha de Registro (Y-m-d)' required autocomplete='off' title='Introduzca su Fecha de Registro (Y-m-d)'>
						</div>
					</div>
					<script type="text/javascript">
						$('#datepicker01').click(function(){
							Calendar.setup({
								inputField     :    'datepicker01', 
								ifFormat       :    '%Y-%m-%d',  
								button         :    'click01', 
								align          :    'Tl',  
								singleClick    :    true
							});
						});
					</script>
					<div class="m-auto">
						<a href="CRUD_paridad_cambiaria.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Insertar Nuevo Renglón &raquo;" class="btn btn-warning mb-2">
					</div>
				</form>
			</div>
		<?php
			//SI SE QUIERE MODIFICAR UN RENGLON ENTONCES:
			}else if($_GET["accion"]=='actualizar'){
				$datos_actualizar=M_paridad_cambiaria_R($conexion, 'ID_TASA_DE_CAMBIO', $_GET['NA_Id'], '', '', '', '');
		?>
			<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
				<div class="row mt-4 align-items-center rounded-top px-2">
					<div class="col-md-9 mb-1 mt-3">
						<h3 class="text-center text-md-left text-warning">Modificar Tasa de Cambio:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1 mt-3">
						<a href="CRUD_paridad_cambiaria.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_paridad_cambiaria.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="FORM" id="FORM" value="MODIFICAR">
					<input type="hidden" name="id_tasa_de_cambio" id="id_tasa_de_cambio" value="<?php echo $datos_actualizar['ID_TASA_DE_CAMBIO'][0]; ?>">
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Tipo Cambio:</span>
						</div>
						<select class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo" id="tipo" required autocomplete="off" title="Indique la moneda de transacción">
							<option><?php echo $datos_actualizar['TIPO_DE_MONEDA_REAL'][0]; ?></option>
							<?php
								$monedas=M_tipos_de_moneda();
								$e=0;
								while($monedas[$e]){
									echo "<option>" . $monedas[$e] . "</option>";
									$e=$e+1;
								}
							?>
						</select>
					</div>
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Tipo/Pm Compra:</span>
						</div>
						<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_por_micoin_compra" id="tipo_por_micoin_compra" placeholder="Introduzca Tipo de Moneda/Pm Compra" required autocomplete="off" title="Introduzca Tipo de Moneda/Pm Compra" step="any" value="<?php echo $datos_actualizar['TIPO_POR_MICOIN_COMPRA'][0]; ?>">
					</div>
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Tipo/Pm Venta:</span>
						</div>
						<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="tipo_por_micoin_venta" id="tipo_por_micoin_venta" placeholder="Introduzca Tipo de Moneda/Pm Venta" required autocomplete="off" title="Introduzca Tipo de Moneda/Pm Venta" step="any" value="<?php echo $datos_actualizar['TIPO_POR_MICOIN_VENTA'][0]; ?>">
					</div>
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">%Comisión Compra:</span>
						</div>
						<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="porc_comision_por_compra" id="porc_comision_por_compra" placeholder="Introduzca el % de comisión por compra de moneda virtual" required autocomplete="off" title="Introduzca el % de comisión por compra de moneda virtual" step="any" value="<?php echo $datos_actualizar['PORC_COMISION_POR_COMPRA'][0]; ?>">
					</div>
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">%Comisión Venta:</span>
						</div>
						<input type="number" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="porc_comision_por_venta" id="porc_comision_por_venta" placeholder="Introduzca el % de comisión por venta de moneda virtual" required autocomplete="off" title="Introduzca el % de comisión por venta de moneda virtual" step="any" value="<?php echo $datos_actualizar['PORC_COMISION_POR_VENTA'][0]; ?>">
					</div>
					<div class="input-group" id="caja_para_fecha_nacimiento">
						<div id='click01' class='input-group date pickers mb-2'>
							<div class='col-md-3 p-0 m-0'>
								<span class='input-group-text rounded-0 w-100' title="Fecha de Registro">Fecha Reg.:</span>
							</div>
							<input id='datepicker01' type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='fh_registro' placeholder='Fecha de Registro (Y-m-d)' required autocomplete='off' title='Introduzca su Fecha de Registro (Y-m-d)' value="<?php echo $datos_actualizar['FH_REGISTRO'][0]; ?>">
						</div>
					</div>
					<script type="text/javascript">
						$('#datepicker01').click(function(){
							Calendar.setup({
								inputField     :    'datepicker01', 
								ifFormat       :    '%Y-%m-%d',  
								button         :    'click01', 
								align          :    'Tl',  
								singleClick    :    true
							});
						});
					</script>
					<div class="m-auto">
						<a href="CRUD_paridad_cambiaria.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-warning mb-2">
					</div>
				</form>
			</div>
		<?php
		//SI SE QUIERE BORRAR UN RENGLON ENTONCES:
	}else if($_GET["accion"]=='borrar'){
		?>
		<br><br><br>
		<div class="col-md-12 col-lg-9 mx-auto">
			<form action="CRUD_paridad_cambiaria.php" method="post" class="text-center bg-dark p-2 rounded">
				<h3 class="text-center text-light pb-3" title="Borrar un Renglón">¿Seguro que desea Borrar el renglón de ID <?php echo $_GET['NA_Id']; ?>?</h3>
				<input type="hidden" name="FORM" id="FORM" value="BORRAR">
				<input type="hidden" name="id_tasa_de_cambio" id="id_tasa_de_cambio" value="<?php echo $_GET["NA_Id"]; ?>">
				<div class="m-auto">
					<a href="CRUD_paridad_cambiaria.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Borrar Renglón &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
			<br><br><br><br><br><br><br><br>
		</div>
		<?php
			//SI NO SE HIZO NINGUNA ACCIÓN:
		}else{
		?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_paridad_cambiaria.php">
	<?php
	//CIERRE DE LA ETIQUETA PARA EMBUTIR HTML EN PHP
	}
	}else{
	?>
	<!-- DataTables Example -->
	<?php
	if(isset($verf_insert)){
		if($verf_insert==false){
			echo "<h3 class='text-center text-dark bg-danger my-2 py-2'>El Renglón que está intentando agregar <b>YA EXISTE</b></h3>";
		}
	}
	?>
	<div class="card mb-3 bg-dark rounded-0 col-12 col-lg-9 mx-auto px-0">
		<div class="card-header text-center text-warning">
			<h3 class='text-center'><span class="fa fa-database"></span> Tasas de Cambio:</h3>
		</div>
		<div class="card-body px-1 bg-white">
			<div class="table-responsive">
				<table class="table table-bordered table-hover TablaDinamica">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b title="Fecha de Registro y Tipo de moneda de cambio">Fecha<br>Moneda</b></th>
							<th class="align-middle"><b title="Tasa de Cambio para la Compra y Venta">?/Pm</b></th>
							<th class="align-middle"><b title="% de comisión a favor del sitio web por compra y venta">%Com</th>
							<!-- SE DECICIÓ BLOQUEAR ESTA OPCCIÓN
							<th class="align-middle h5 p-0"><a title="Insertar" href="CRUD_paridad_cambiaria.php?accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Insertar</a></th>
							-->
						</tr>
					</thead>
					<tbody>
						<?php
						//obteniendo los datos de la tabla:
						$datos=M_paridad_cambiaria_R($conexion, '', '', '', '', '', '');
						$i=0;
						while(isset($datos['ID_TASA_DE_CAMBIO'][$i])){
							if($datos['ID_TASA_DE_CAMBIO'][$i]<>""){
								$fecha_i=explode(" ", $datos['FH_REGISTRO'][$i]);
								echo "<tr>";
								echo "<td class='text-left'>" . $fecha_i[0] . "<br>";
								echo "<b>Tipo:</b> " . $datos['TIPO_DE_MONEDA_REAL'][$i] . "</td>";
								echo "<td class='text-left'><b>C:</b> " . $datos['TIPO_POR_MICOIN_COMPRA'][$i] . "<br>";
								echo "<b>V:</b> " . $datos['TIPO_POR_MICOIN_VENTA'][$i] . "</td>";
								echo "<td class='text-left'><b>C:</b> " . $datos['PORC_COMISION_POR_COMPRA'][$i] . "<br>";
								echo "<b>V:</b> " . $datos['PORC_COMISION_POR_VENTA'][$i] . "</td>";
								/* SE DECICIÓ BLOQUEAR ESTA OPCCIÓN
								echo "<td class='text-center h5'><a title='Modificar' href='CRUD_paridad_cambiaria.php?accion=actualizar&NA_Id=" . $datos['ID_TASA_DE_CAMBIO'][$i] . "' class='btn btn-transparent text-success fa fa-edit d-inline'></a>";
								echo "&nbsp;&nbsp;";
								echo "<a title='Eliminar' href='CRUD_paridad_cambiaria.php?accion=borrar&NA_Id=" . $datos['ID_TASA_DE_CAMBIO'][$i] . "' class='btn btn-transparent text-danger fa fa-trash-o d-inline'></a></td>";
								*/
								echo "</tr>";
							}
							$i=$i+1;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br><br><br><br><br><br><br><br><br><br><br><br><br>
	<?php
	//CIERRE DE LA ETIQUETA PARA EMBUTIR HTML EN PHP		
}
	?>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>