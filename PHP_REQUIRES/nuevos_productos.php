<?php
	$datos_de_productos_nuevos=M_nuevos_productos($conexion);
?>
<!-- PRODUCTOS NUEVOS-->
<section class="my-5">
	<div class="bg-white pb-3">
		<h3 class="text-center py-3 bg-dark text-warning"><b>Nuevos Productos</b></h3>
		<table class="TablaDinamica1 w-100">
			<thead>
				<tr class="text-center">
					<th class="align-middle"><b class="h6"></th>
				</tr>
			</thead>
			<tbody>
		<?php
			$i=0;
			while(isset($datos_de_productos_nuevos['ID_PRODUCTO'][$i])){
				$e=$i+1;
				echo "<tr><td><div class='container-fluid py-2'>
					<div class='row px-4'>
						<div class='col-md-3 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
							<div class='m-1'>
								<h5 class='text-left' style='height: 2em;'><e class='text-light' style='font-size:1px;'>" . $e . "</e><a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><b class='text-light'></b><strong>" . $datos_de_productos_nuevos['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
								<div class='marco-ajustado hidden rounded border border-secondary'>
									<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_nuevos['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
								</div>
								<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_nuevos['UNIDAD_DE_VENTA'][$i] . "</h6>
								<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_nuevos['DISPONIBLE'][$i] . "</h6>
								<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE'][$i] . " " . $datos_de_productos_nuevos['APELLIDO'][$i] . "</a></h6>
								<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_CATEGORIA'][$i] . "</a></h6>
								<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
								 <a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_1'][$i] . " </a>
								 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_2'][$i] . " </a>
								 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_3'][$i] . " </a>
								 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_4'][$i] . " </a>
								 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_5'][$i] . "</a>
								</h6>
								<h6 class='mb-3 h4' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_nuevos['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
							</div>
						</div>
				";
				$i=$i+1;
				$e=$i+1;
				if(isset($datos_de_productos_nuevos['ID_PRODUCTO'][$i])){
					echo "
						<div class='col-md-3 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
							<div class='m-1'>
								<h5 class='text-left' style='height: 2em;'><e class='text-light' style='font-size:1px;'>" . $e . "</e><a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><b class='text-light'></b><strong>" . $datos_de_productos_nuevos['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
								<div class='marco-ajustado hidden rounded border border-secondary'>
									<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_nuevos['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
								</div>
								<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_nuevos['UNIDAD_DE_VENTA'][$i] . "</h6>
								<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_nuevos['DISPONIBLE'][$i] . "</h6>
								<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE'][$i] . " " . $datos_de_productos_nuevos['APELLIDO'][$i] . "</a></h6>
								<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_CATEGORIA'][$i] . "</a></h6>
								<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
								 <a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_1'][$i] . " </a>
								 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_2'][$i] . " </a>
								 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_3'][$i] . " </a>
								 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_4'][$i] . " </a>
								 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_5'][$i] . "</a>
								</h6>
								<h6 class='mb-3 h4' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_nuevos['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
							</div>
						</div>
					";
				}
				$i=$i+1;
				$e=$i+1;
				if(isset($datos_de_productos_nuevos['ID_PRODUCTO'][$i])){
					echo "
						<div class='col-md-3 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
							<div class='m-1'>
								<h5 class='text-left' style='height: 2em;'><e class='text-light' style='font-size:1px;'>" . $e . "</e><a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><b class='text-light'></b><strong>" . $datos_de_productos_nuevos['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
								<div class='marco-ajustado hidden rounded border border-secondary'>
									<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_nuevos['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
								</div>
								<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_nuevos['UNIDAD_DE_VENTA'][$i] . "</h6>
								<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_nuevos['DISPONIBLE'][$i] . "</h6>
								<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE'][$i] . " " . $datos_de_productos_nuevos['APELLIDO'][$i] . "</a></h6>
								<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_CATEGORIA'][$i] . "</a></h6>
								<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
								 <a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_1'][$i] . " </a>
								 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_2'][$i] . " </a>
								 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_3'][$i] . " </a>
								 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_4'][$i] . " </a>
								 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_5'][$i] . "</a>
								</h6>
								<h6 class='mb-3 h4' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_nuevos['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
							</div>
						</div>
					";
				}
				$i=$i+1;
				$e=$i+1;
				if(isset($datos_de_productos_nuevos['ID_PRODUCTO'][$i])){
					echo "
						<div class='col-md-3 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
							<div class='m-1'>
								<h5 class='text-left' style='height: 2em;'><e class='text-light' style='font-size:1px;'>" . $e . "</e><a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><b class='text-light'></b><strong>" . $datos_de_productos_nuevos['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
								<div class='marco-ajustado hidden rounded border border-secondary'>
									<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_nuevos['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
								</div>
								<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_nuevos['UNIDAD_DE_VENTA'][$i] . "</h6>
								<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_nuevos['DISPONIBLE'][$i] . "</h6>
								<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE'][$i] . " " . $datos_de_productos_nuevos['APELLIDO'][$i] . "</a></h6>
								<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_CATEGORIA'][$i] . "</a></h6>
								<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
								 <a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_1'][$i] . " </a>
								 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_2'][$i] . " </a>
								 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_3'][$i] . " </a>
								 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_4'][$i] . " </a>
								 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_nuevos['NOMBRE_ETIQUETA_5'][$i] . "</a>
								</h6>
								<h6 class='mb-3 h4' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_nuevos['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
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
</section>
