<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Buscar</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
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
	<section class="my-3">
		<div class="pb-3">
			<h2 class="text-center py-3 bg-dark text-warning mb-0"><b>Filtros de Búsqueda</b></h2>
			<form action="zona_usuario_buscar.php" method="post">
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
									if($filtro_vend_1['CEDULA_RIF'][$i]<>$datos_usuario_session['CEDULA_RIF'][0]){
										echo "<option value='" . $filtro_vend_1['CEDULA_RIF'][$i] . "'>" . $filtro_vend_1['NOMBRE'][$i] . " " . $filtro_vend_1['APELLIDO'][$i] . " (V-" . str_pad($filtro_vend_1['ID_USUARIO'][$i], 4, "0", STR_PAD_LEFT) . ")</option>";
									}
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
							<option value="Menor Precio" class="px-1">Mayor Precio</option>
							<option value="Mayor Precio" class="px-1">Mayor Precio</option>
							<option value="Más Reciente" class="px-1">Más Reciente</option>
							<option value="Menos Reciente" class="px-1">Menos Reciente</option>
							<option value="Nombre de Producto" class="px-1">Producto</option>
						</select>
					</div>
					<div class="col-sm-2 px-0">
						<input type="submit" class="p-0 m-0 px-2 btn btn-warning rounded-0 h-100 w-100 border border-dark small" value="Buscar &raquo;">
					</div>
				</div>
			</form>
			<?php
				if(isset($datos_de_productos_aliados['ID_PRODUCTO'][0])){
					if($datos_de_productos_aliados['ID_PRODUCTO'][0]==''){
						//no debe salir la tabla de aliados
					}else{
			?>
			<div class="container-fluid">
				<div class="row mt-4 bg-light">
					<div class="col-12 px-0 bg-white pb-3">
						<h3 class='bg-success text-dark text-center py-1 mb-0'><b>Nuestros Aliados</b></h3>
						<table class="TablaDinamica1 w-100">
							<thead>
								<tr class="text-center">
									<th class="align-middle"><b class="h6"></th>
								</tr>
							</thead>
							<tbody>
						<?php
							//CORRIGIENDO ALIADOS SIN TUS PROPIOS PRODUCTOS
							$datos_de_productos_aliados_corregidos['ID_PRODUCTO'][0]='';
							$datos_de_productos_aliados_corregidos['NOMBRE_PRODUCTO'][0]='';
							$datos_de_productos_aliados_corregidos['FOTO_1'][0]='';
							$datos_de_productos_aliados_corregidos['UNIDAD_DE_VENTA'][0]='';
							$datos_de_productos_aliados_corregidos['DISPONIBLE'][0]='';
							$datos_de_productos_aliados_corregidos['CEDULA_RIF'][0]='';
							$datos_de_productos_aliados_corregidos['NOMBRE'][0]='';
							$datos_de_productos_aliados_corregidos['APELLIDO'][0]='';
							$datos_de_productos_aliados_corregidos['NOMBRE_CATEGORIA'][0]='';
							$datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_1'][0]='';
							$datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_2'][0]='';
							$datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_3'][0]='';
							$datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_4'][0]='';
							$datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_5'][0]='';
							$datos_de_productos_aliados_corregidos['PRECIO_UNITARIO'][0]='';
							$i=0;
							$e=0;
							while(isset($datos_de_productos_aliados['ID_PRODUCTO'][$i])){
								if($datos_de_productos_aliados['CEDULA_RIF'][$i]<>$datos_usuario_session['CEDULA_RIF'][0]){
									$datos_de_productos_aliados_corregidos['ID_PRODUCTO'][$e]=$datos_de_productos_aliados['ID_PRODUCTO'][$i];
									$datos_de_productos_aliados_corregidos['NOMBRE_PRODUCTO'][$e]=$datos_de_productos_aliados['NOMBRE_PRODUCTO'][$i];
									$datos_de_productos_aliados_corregidos['FOTO_1'][$e]=$datos_de_productos_aliados['FOTO_1'][$i];
									$datos_de_productos_aliados_corregidos['UNIDAD_DE_VENTA'][$e]=$datos_de_productos_aliados['UNIDAD_DE_VENTA'][$i];
									$datos_de_productos_aliados_corregidos['DISPONIBLE'][$e]=$datos_de_productos_aliados['DISPONIBLE'][$i];
									$datos_de_productos_aliados_corregidos['CEDULA_RIF'][$e]=$datos_de_productos_aliados['CEDULA_RIF'][$i];
									$datos_de_productos_aliados_corregidos['NOMBRE'][$e]=$datos_de_productos_aliados['NOMBRE'][$i];
									$datos_de_productos_aliados_corregidos['APELLIDO'][$e]=$datos_de_productos_aliados['APELLIDO'][$i];
									$datos_de_productos_aliados_corregidos['NOMBRE_CATEGORIA'][$e]=$datos_de_productos_aliados['NOMBRE_CATEGORIA'][$i];
									$datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_1'][$e]=$datos_de_productos_aliados['NOMBRE_ETIQUETA_1'][$i];
									$datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_2'][$e]=$datos_de_productos_aliados['NOMBRE_ETIQUETA_2'][$i];
									$datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_3'][$e]=$datos_de_productos_aliados['NOMBRE_ETIQUETA_3'][$i];
									$datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_4'][$e]=$datos_de_productos_aliados['NOMBRE_ETIQUETA_4'][$i];
									$datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_5'][$e]=$datos_de_productos_aliados['NOMBRE_ETIQUETA_5'][$i];
									$datos_de_productos_aliados_corregidos['PRECIO_UNITARIO'][$e]=$datos_de_productos_aliados['PRECIO_UNITARIO'][$i];
									$e++;
								}
								$i++;
							}
							//IMPRIMIENDO ALIADOS SIN TUS PROPIOS PRODUCTOS
							$i=0;
							while(isset($datos_de_productos_aliados_corregidos['ID_PRODUCTO'][$i])){
								if($datos_de_productos_aliados_corregidos['ID_PRODUCTO'][$i]<>""){
									echo "<tr><td><div class='container-fluid py-2'>
										<div class='row px-4'>
											<div class='col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
												<div class='m-1 border-bottom'>
													<h5 class='text-left' style='height: 2em;'><b class='text-light' style='font-size:1px;'>" . $i . "</b><a href='zona_usuario_detalle_producto.php?id_producto=" . $datos_de_productos_aliados_corregidos['ID_PRODUCTO'][$i] . "' class='text-dark'><strong>" . $datos_de_productos_aliados_corregidos['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
													<div class='marco-ajustado hidden rounded border border-secondary w-75'>
														<a href='zona_usuario_detalle_producto.php?id_producto=" . $datos_de_productos_aliados_corregidos['ID_PRODUCTO'][$i] . "' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_aliados_corregidos['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
													</div>
													<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_aliados_corregidos['UNIDAD_DE_VENTA'][$i] . "</h6>
													<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_aliados_corregidos['DISPONIBLE'][$i] . "</h6>
													<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE'][$i] . " " . $datos_de_productos_aliados_corregidos['APELLIDO'][$i] . "</a></h6>
													<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_CATEGORIA'][$i] . "</a></h6>
													<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
													 <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_1'][$i] . " </a>
													 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_2'][$i] . " </a>
													 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_3'][$i] . " </a>
													 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_4'][$i] . " </a>
													 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_5'][$i] . "</a>
													</h6>
													<h6 class='mb-3' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_aliados_corregidos['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
													<br>
												</div>
											</div>
									";
									$i=$i+1;
									if(isset($datos_de_productos_aliados_corregidos['ID_PRODUCTO'][$i])){
										echo "
											<div class='col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
												<div class='m-1 border-bottom'>
													<h5 class='text-left' style='height: 2em;'><b class='text-light' style='font-size:1px;'>" . $i . "</b><a href='zona_usuario_detalle_producto.php?id_producto=" . $datos_de_productos_aliados_corregidos['ID_PRODUCTO'][$i] . "' class='text-dark'><strong>" . $datos_de_productos_aliados_corregidos['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
													<div class='marco-ajustado hidden rounded border border-secondary w-75'>
														<a href='zona_usuario_detalle_producto.php?id_producto=" . $datos_de_productos_aliados_corregidos['ID_PRODUCTO'][$i] . "' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_aliados_corregidos['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
													</div>
													<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_aliados_corregidos['UNIDAD_DE_VENTA'][$i] . "</h6>
													<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_aliados_corregidos['DISPONIBLE'][$i] . "</h6>
													<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE'][$i] . " " . $datos_de_productos_aliados_corregidos['APELLIDO'][$i] . "</a></h6>
													<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_CATEGORIA'][$i] . "</a></h6>
													<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
													 <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_1'][$i] . " </a>
													 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_2'][$i] . " </a>
													 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_3'][$i] . " </a>
													 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_4'][$i] . " </a>
													 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_5'][$i] . "</a>
													</h6>
													<h6 class='mb-3' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_aliados_corregidos['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
													<br>
												</div>
											</div>
										";
									}
									$i=$i+1;
									if(isset($datos_de_productos_aliados_corregidos['ID_PRODUCTO'][$i])){
										echo "
											<div class='col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
												<div class='m-1 border-bottom'>
													<h5 class='text-left' style='height: 2em;'><b class='text-light' style='font-size:1px;'>" . $i . "</b><a href='zona_usuario_detalle_producto.php?id_producto=" . $datos_de_productos_aliados_corregidos['ID_PRODUCTO'][$i] . "' class='text-dark'><strong>" . $datos_de_productos_aliados_corregidos['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
													<div class='marco-ajustado hidden rounded border border-secondary w-75'>
														<a href='zona_usuario_detalle_producto.php?id_producto=" . $datos_de_productos_aliados_corregidos['ID_PRODUCTO'][$i] . "' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_aliados_corregidos['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
													</div>
													<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_aliados_corregidos['UNIDAD_DE_VENTA'][$i] . "</h6>
													<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_aliados_corregidos['DISPONIBLE'][$i] . "</h6>
													<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE'][$i] . " " . $datos_de_productos_aliados_corregidos['APELLIDO'][$i] . "</a></h6>
													<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_CATEGORIA'][$i] . "</a></h6>
													<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
													 <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_1'][$i] . " </a>
													 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_2'][$i] . " </a>
													 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_3'][$i] . " </a>
													 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_4'][$i] . " </a>
													 &nbsp;&nbsp;<a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_aliados_corregidos['NOMBRE_ETIQUETA_5'][$i] . "</a>
													</h6>
													<h6 class='mb-3' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_aliados_corregidos['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
													<br>
												</div>
											</div>
										";
									}
									echo "
										</div></div></td></tr>
									";
								}
								$i=$i+1;
							}
						?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php
					}
				}
			?>
			<div class="bg-light">
				<table class="TablaDinamica10 w-100 bg-light">
				<thead>
					<tr class="text-center bg-dark text-warning">
						<th class="align-middle py-2"><b class="h3"><b>Productos encontrados</b></b></th>
					</tr>
				</thead>
				<tbody>
			<?php
				if(isset($datos_de_productos_buscados['ID_PRODUCTO'][0])){
					if($datos_de_productos_buscados['ID_PRODUCTO'][0]==''){
						echo "<tr><td><h2 class='text-danger text-center'>SIN RESULTADOS:<h2>";
						echo "<h5 class='px-3 text-center'>No se encontraron resultados, intente con una busqueda diferente</h5></td></tr>";
					}
				}
				$i=0;
				while(isset($datos_de_productos_buscados['ID_PRODUCTO'][$i])){
					if($datos_de_productos_buscados['ID_PRODUCTO'][$i]<>"" and $datos_de_productos_buscados['CEDULA_RIF'][$i]<>$datos_usuario_session["CEDULA_RIF"][0]){
						$e=$i+1;
						M_producto_buscado_C($conexion, $datos_de_productos_buscados['ID_PRODUCTO'][$i], $datos_usuario_session['ID_USUARIO'][0], date("Y-m-d h:m:s"));
						echo "
							<tr><td><div class='container-fluid m-1'>
								<div class='row'>
									<div class='col-4 col-sm-3 ml-0'>
										<div class='marco-ajustado hidden rounded border border-secondary'>
											<a href='zona_usuario_detalle_producto.php?id_producto=" . $datos_de_productos_buscados['ID_PRODUCTO'][$i] . "'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_buscados['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
										</div>
									</div>
									<div class='col-8 col-sm-6'>
										<h5 class='text-left'><strong><b class='text-light' style='font-size:1px;'>$e</b><a href='zona_usuario_detalle_producto.php?id_producto=" . $datos_de_productos_buscados['ID_PRODUCTO'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_PRODUCTO'][$i] . "</a></strong></h5>
										<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE'][$i] . " " . $datos_de_productos_buscados['APELLIDO'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE'][$i] . " " . $datos_de_productos_buscados['APELLIDO'][$i] . "</a></h6>
										<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_CATEGORIA'][$i] . "</a></h6>
										<h6 class='my-2'><strong class='text-primary'>Etiquetas:</strong>";
										if($datos_de_productos_buscados['NOMBRE_ETIQUETA_1'][$i]<>""){
											echo " <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_1'][$i] . "</a>";
										}
										if($datos_de_productos_buscados['NOMBRE_ETIQUETA_2'][$i]<>""){
											echo " <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_2'][$i] . "</a>";
										}
										if($datos_de_productos_buscados['NOMBRE_ETIQUETA_3'][$i]<>""){
											echo " <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_3'][$i] . "</a>";
										}
										if($datos_de_productos_buscados['NOMBRE_ETIQUETA_4'][$i]<>""){
											echo " <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_4'][$i] . "</a>";
										}
										if($datos_de_productos_buscados['NOMBRE_ETIQUETA_5'][$i]<>""){
											echo " <a href='zona_usuario_buscar.php?buscar=" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados['NOMBRE_ETIQUETA_5'][$i] . "</a>";
										}
										echo "</h6>";
										echo "<h6 class='my-2'><strong title='Unidad de Medida'>Unidad:</strong> " . $datos_de_productos_buscados['UNIDAD_DE_VENTA'][$i] . "
										</h6><h6 class='my-2'><strong title='Cantidad Disponible'>Disponible:</strong> " . $datos_de_productos_buscados['DISPONIBLE'][$i] . "
										</h6>
										<h5 class='my-2'><strong title='Precio en Penmón'>Precio: " . number_format($datos_de_productos_buscados['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h5>
									</div>
									<div class='col-3 col-sm-3 text-center d-none d-sm-block'>
										<a href='zona_usuario_detalle_producto.php?id_producto=" . $datos_de_productos_buscados['ID_PRODUCTO'][$i] . "' class='btn btn-warning my-2 text-dark'>Detalles</a>
									</div>
								</div>
							</div><hr></td></tr>
						";
					}
					$i=$i+1;
				}
				?>
				</table>
			</div>
		</div>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>