<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/datos_nav_busq_externos.php"); ?>
<!doctype html>
<html>
<head>
	<?php require ("PHP_REQUIRES/seo_meta.php") ?>
	<?php require ("PHP_REQUIRES/head_principal.php"); ?>
	<title>Principal Buscar</title>
</head>
<body class="bg-secondary">
	<?php require ("PHP_REQUIRES/nav_principal.php"); ?>
	<?php
	//ENCONTRANDO TEXTO BUSCADO SIN FILTROS
	if(isset($_GET['buscar'])){
		$texto_buscado=mysqli_real_escape_string($conexion,$_GET['buscar']);
	}else if(isset($_POST['buscar'])){
		$texto_buscado=mysqli_real_escape_string($conexion,$_POST['buscar']);
	}else{
		$texto_buscado='';
	}
	//ENCONTRANDO TEXTO BUSCADO SI EXISTEN FILTROS
	if(isset($_POST['buscar_vendedor'])){
		$buscar_vendedor=mysqli_real_escape_string($conexion,$_POST['buscar_vendedor']);
	}else{
		$buscar_vendedor="";
	}
	if(isset($_POST['buscar_ciudad'])){
		$buscar_ciudad=mysqli_real_escape_string($conexion,$_POST['buscar_ciudad']);
	}else{
		$buscar_ciudad="";
	}
	if(isset($_POST['buscar_categoria'])){
		$buscar_categoria=mysqli_real_escape_string($conexion,$_POST['buscar_categoria']);
	}else{
		$buscar_categoria="";
	}
	if(isset($_POST['buscar_orden'])){
		$buscar_orden=mysqli_real_escape_string($conexion,$_POST['buscar_orden']);
	}else{
		$buscar_orden="";
	}
	$datos_de_productos_buscados=M_buscar_productos($conexion, $texto_buscado, $buscar_vendedor, $buscar_ciudad, $buscar_categoria, $buscar_orden, ''); 
	$datos_de_productos_aliados=M_buscar_productos($conexion, $texto_buscado, $buscar_vendedor, $buscar_ciudad, $buscar_categoria, $buscar_orden, 'SI');
	?>
	<br><br><br>
	<section class="my-3 px-2">
		<div class="pb-3">
			<h2 class="text-center py-3 bg-dark text-warning mb-0"><b>Filtros de Búsqueda</b></h2>
			<form action="buscar.php" method="post">
				<div class="row bg-dark mx-0 pb-4 px-1">
					<div class="col-sm-6 px-0">
						<span class="input-group-text rounded-0 w-100">Palabras:</span>
						<input type="text" name="buscar" class="form-control col-md-12 p-0 m-0 px-2 rounded-0" value="<?php if(isset($_POST['buscar'])){echo $_POST['buscar']; } ?>">
					</div>
					<div class="col-sm-6 px-0">
						<span class="input-group-text rounded-0 w-100">Vendedor:</span>
						<select name="buscar_vendedor" class="form-control col-md-12 p-0 m-0 px-2 rounded-0">
							<?php
								if(isset($_POST['buscar_vendedor'])){
									$datos_del_vendedor=M_usuarios_R($conexion, 'CEDULA_RIF', $_POST['buscar_vendedor'], '', '', '', '');
									echo "<option value='" . $_POST['buscar_vendedor'] . "'>" . $datos_del_vendedor['NOMBRE'][0] . " " . $datos_del_vendedor['APELLIDO'][0] . " (V-" . str_pad($datos_del_vendedor['ID_USUARIO'][0], 4, "0", STR_PAD_LEFT) . ")</option>";
								}else{
									echo "<option></option>";
								}
							?>
							<?php
								$filtro_vend_1= $datos_del_vendedor=M_usuarios_R($conexion, 'ESTATUS', 'ACTIVO', 'ACCESO', 'COMPRADOR-VENDEDOR', '', '');
								$i=0;
								while(isset($filtro_vend_1['NOMBRE'][$i])){
									echo "<option value='" . $filtro_vend_1['CEDULA_RIF'][$i] . "'>" . $filtro_vend_1['NOMBRE'][$i] . " " . $filtro_vend_1['APELLIDO'][$i] . " (V-" . str_pad($filtro_vend_1['ID_USUARIO'][$i], 4, "0", STR_PAD_LEFT) . ")</option>";
									$i=$i+1;
								}
							?>
						</select>
					</div>
					<div class="col-sm-4 px-0">
						<span class="input-group-text rounded-0 w-100">Ubicación:</span>
						<select name="buscar_ciudad" class="form-control col-md-12 p-0 m-0 px-2 rounded-0">
							<?php
								if(isset($_POST['buscar_ciudad'])){
									echo "<option>" . $_POST['buscar_ciudad'] . "</option>";
								}else{
									echo "<option></option>";
								}
							?>
							<?php
								$filtro_ubic_1= M_usuarios_R_activos_ciudades($conexion);
								$i=0;
								while(isset($filtro_ubic_1['CIUDAD'][$i])){
									echo "<option>" . $filtro_ubic_1['CIUDAD'][$i] . "</option>";
									$i=$i+1;
								}
							?>
						</select>
					</div>
					<div class="col-sm-3 px-0">
						<span class="input-group-text rounded-0 w-100">Categoría:</span>
						<select name="buscar_categoria" class="form-control col-md-12 p-0 m-0 px-2 rounded-0">
							<?php
								if(isset($_POST['buscar_categoria'])){
									echo "<option>" . $_POST['buscar_categoria'] . "</option>";
								}else{
									echo "<option></option>";
								}
							?>
							<?php
								$filtro_cat_1= M_categorias_disponibles($conexion);
								$i=0;
								while(isset($filtro_cat_1['CATEGORIA'][$i])){
									echo "<option>" . $filtro_cat_1['CATEGORIA'][$i] . "</option>";
									$i=$i+1;
								}
							?>
						</select>
					</div>
					<div class="col-sm-3 px-0">
						<span class="input-group-text rounded-0 w-100">Ordenar por:</span>
						<select name="buscar_orden" class="form-control col-md-12 p-0 m-0 px-2 rounded-0">
							<?php
								if(isset($_POST['buscar_orden'])){
									echo "<option>" . $_POST['buscar_orden'] . "</option>";
								}
							?>
							<option>Menor Precio</option>
							<option>Mayor Precio</option>
							<option>Más Reciente</option>
							<option>Menos Reciente</option>
							<option>Nombre de Producto</option>
						</select>
					</div>
					<div class="col-sm-2 px-0">
						<input type="submit" class="p-0 m-0 px-2 btn btn-warning rounded-0 h-100 w-100 border border-dark" value="Buscar &raquo;">
					</div>
				</div>
			</form>
			<?php
				if(isset($datos_de_productos_aliados['ID_PRODUCTO'][0])){
					if($datos_de_productos_aliados['ID_PRODUCTO'][0]==''){
						//no debe salir la tabla de aliados
					}else{
			?>
				<!-- PRODUCTOS ALIADOS -->
				<div class="my-5">
					<div class="bg-white pb-3">
						<h3 class="text-center py-3 bg-dark text-warning display-4">Nuestros Aliados</h3>
						<table class="TablaDinamica1 w-100">
							<thead>
								<tr class="text-center">
									<th class="align-middle"><b class="h6"></th>
								</tr>
							</thead>
							<tbody>
						<?php
							$i=0;
							while(isset($datos_de_productos_aliados['ID_PRODUCTO'][$i])){
								$e=$i+1;
								if($datos_de_productos_aliados['ID_PRODUCTO'][$i]<>""){
									echo "<tr><td><div class='container-fluid py-2'>
										<div class='row px-4'>
											<div class='col-md-3 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
												<div class='m-1'>
													<h5 class='text-left' style='height: 2em;'><a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><b class='text-light'>" . $e . "</b><strong>" . $datos_de_productos_aliados['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
													<div class='marco-ajustado hidden rounded border border-secondary'>
														<a href='autenticacion.php' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_aliados['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
													</div>
													<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_aliados['UNIDAD_DE_VENTA'][$i] . "</h6>
													<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_aliados['DISPONIBLE'][$i] . "</h6>
													<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE'][$i] . " " . $datos_de_productos_aliados['APELLIDO'][$i] . "</a></h6>
													<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_CATEGORIA'][$i] . "</a></h6>
													<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
													 <a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_1'][$i] . " </a>
													 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_2'][$i] . " </a>
													 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_3'][$i] . " </a>
													 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_4'][$i] . " </a>
													 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_5'][$i] . "</a>
													</h6>
													<h6 class='mb-3 h4' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_aliados['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
												</div>
											</div>
									";
								}
								$i=$i+1;
								$e=$i+1;
								if(isset($datos_de_productos_aliados['ID_PRODUCTO'][$i])){
									echo "
										<div class='col-md-3 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
											<div class='m-1'>
												<h5 class='text-left' style='height: 2em;'><a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><b class='text-light'>" . $e . "</b><strong>" . $datos_de_productos_aliados['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
												<div class='marco-ajustado hidden rounded border border-secondary'>
													<a href='autenticacion.php' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_aliados['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
												</div>
												<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_aliados['UNIDAD_DE_VENTA'][$i] . "</h6>
												<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_aliados['DISPONIBLE'][$i] . "</h6>
												<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE'][$i] . " " . $datos_de_productos_aliados['APELLIDO'][$i] . "</a></h6>
												<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_CATEGORIA'][$i] . "</a></h6>
												<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
												 <a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_1'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_2'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_3'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_4'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_5'][$i] . "</a>
												</h6>
												<h6 class='mb-3 h4' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_aliados['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
											</div>
										</div>
									";
								}
								$i=$i+1;
								$e=$i+1;
								if(isset($datos_de_productos_aliados['ID_PRODUCTO'][$i])){
									echo "
										<div class='col-md-3 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
											<div class='m-1'>
												<h5 class='text-left' style='height: 2em;'><a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><b class='text-light'>" . $e . "</b><strong>" . $datos_de_productos_aliados['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
												<div class='marco-ajustado hidden rounded border border-secondary'>
													<a href='autenticacion.php' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_aliados['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
												</div>
												<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_aliados['UNIDAD_DE_VENTA'][$i] . "</h6>
												<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_aliados['DISPONIBLE'][$i] . "</h6>
												<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE'][$i] . " " . $datos_de_productos_aliados['APELLIDO'][$i] . "</a></h6>
												<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_CATEGORIA'][$i] . "</a></h6>
												<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
												 <a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_1'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_2'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_3'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_4'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_5'][$i] . "</a>
												</h6>
												<h6 class='mb-3 h4' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_aliados['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
											</div>
										</div>
									";
								}
								$i=$i+1;
								$e=$i+1;
								if(isset($datos_de_productos_aliados['ID_PRODUCTO'][$i])){
									echo "
										<div class='col-md-3 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
											<div class='m-1'>
												<h5 class='text-left' style='height: 2em;'><a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><b class='text-light'>" . $e . "</b><strong>" . $datos_de_productos_aliados['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
												<div class='marco-ajustado hidden rounded border border-secondary'>
													<a href='autenticacion.php' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_aliados['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
												</div>
												<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_aliados['UNIDAD_DE_VENTA'][$i] . "</h6>
												<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_aliados['DISPONIBLE'][$i] . "</h6>
												<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE'][$i] . " " . $datos_de_productos_aliados['APELLIDO'][$i] . "</a></h6>
												<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_CATEGORIA'][$i] . "</a></h6>
												<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
												 <a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_1'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_2'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_3'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_4'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados['NOMBRE_ETIQUETA_5'][$i] . "</a>
												</h6>
												<h6 class='mb-3 h4' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_aliados['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
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
				</div>
				<br><br>
			<?php
					}
				}
			?>
				<!-- PRODUCTOS ENCONTRADOS -->
				<div class="my-5">
					<div class="bg-white pb-3">
						<h3 class="text-center py-3 bg-dark text-warning display-4">Resultados de la Búsqueda</h3>
						<table class="TablaDinamica10 w-100">
							<thead>
								<tr class="text-center">
									<th class="align-middle"><b class="h6"></th>
								</tr>
							</thead>
							<tbody>
						<?php
							$i=0;
							while(isset($datos_de_productos_buscados['ID_PRODUCTO'][$i])){
								$e=$i+1;
								if($datos_de_productos_buscados['ID_PRODUCTO'][$i]<>""){
									echo "<tr><td><div class='container-fluid py-2'>
										<div class='row px-4'>
											<div class='col-md-3 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
												<div class='m-1'>
													<h5 class='text-left' style='height: 2em;'><a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><b class='text-light'>" . $e . "</b><strong>" . $datos_de_productos_buscados['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
													<div class='marco-ajustado hidden rounded border border-secondary'>
														<a href='autenticacion.php' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_buscados['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
													</div>
													<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_buscados['UNIDAD_DE_VENTA'][$i] . "</h6>
													<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_buscados['DISPONIBLE'][$i] . "</h6>
													<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE'][$i] . " " . $datos_de_productos_buscados['APELLIDO'][$i] . "</a></h6>
													<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_CATEGORIA'][$i] . "</a></h6>
													<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
													 <a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_1'][$i] . " </a>
													 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_2'][$i] . " </a>
													 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_3'][$i] . " </a>
													 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_4'][$i] . " </a>
													 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_5'][$i] . "</a>
													</h6>
													<h6 class='mb-3 h4' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_buscados['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
												</div>
											</div>
									";
								}
								$i=$i+1;
								$e=$i+1;
								if(isset($datos_de_productos_buscados['ID_PRODUCTO'][$i])){
									echo "
										<div class='col-md-3 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
											<div class='m-1'>
												<h5 class='text-left' style='height: 2em;'><a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><b class='text-light'>" . $e . "</b><strong>" . $datos_de_productos_buscados['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
												<div class='marco-ajustado hidden rounded border border-secondary'>
													<a href='autenticacion.php' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_buscados['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
												</div>
												<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_buscados['UNIDAD_DE_VENTA'][$i] . "</h6>
												<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_buscados['DISPONIBLE'][$i] . "</h6>
												<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE'][$i] . " " . $datos_de_productos_buscados['APELLIDO'][$i] . "</a></h6>
												<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_CATEGORIA'][$i] . "</a></h6>
												<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
												 <a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_1'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_2'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_3'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_4'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_5'][$i] . "</a>
												</h6>
												<h6 class='mb-3 h4' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_buscados['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
											</div>
										</div>
									";
								}
								$i=$i+1;
								$e=$i+1;
								if(isset($datos_de_productos_buscados['ID_PRODUCTO'][$i])){
									echo "
										<div class='col-md-3 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
											<div class='m-1'>
												<h5 class='text-left' style='height: 2em;'><a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><b class='text-light'>" . $e . "</b><strong>" . $datos_de_productos_buscados['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
												<div class='marco-ajustado hidden rounded border border-secondary'>
													<a href='autenticacion.php' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_buscados['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
												</div>
												<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_buscados['UNIDAD_DE_VENTA'][$i] . "</h6>
												<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_buscados['DISPONIBLE'][$i] . "</h6>
												<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE'][$i] . " " . $datos_de_productos_buscados['APELLIDO'][$i] . "</a></h6>
												<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_CATEGORIA'][$i] . "</a></h6>
												<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
												 <a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_1'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_2'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_3'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_4'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_5'][$i] . "</a>
												</h6>
												<h6 class='mb-3 h4' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_buscados['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
											</div>
										</div>
									";
								}
								$i=$i+1;
								$e=$i+1;
								if(isset($datos_de_productos_buscados['ID_PRODUCTO'][$i])){
									echo "
										<div class='col-md-3 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
											<div class='m-1'>
												<h5 class='text-left' style='height: 2em;'><a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><b class='text-light'>" . $e . "</b><strong>" . $datos_de_productos_buscados['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
												<div class='marco-ajustado hidden rounded border border-secondary'>
													<a href='autenticacion.php' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_buscados['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
												</div>
												<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_buscados['UNIDAD_DE_VENTA'][$i] . "</h6>
												<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_buscados['DISPONIBLE'][$i] . "</h6>
												<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE'][$i] . " " . $datos_de_productos_buscados['APELLIDO'][$i] . "</a></h6>
												<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_CATEGORIA'][$i] . "</a></h6>
												<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
												 <a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_1'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_2'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_3'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_4'][$i] . " </a>
												 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_5'][$i] . "</a>
												</h6>
												<h6 class='mb-3 h4' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_buscados['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
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
				</div>
			
		</div>
		<br><br><br>
	</section>
	<?php require ("PHP_REQUIRES/footer_principal.php"); ?>
</body>
</html>