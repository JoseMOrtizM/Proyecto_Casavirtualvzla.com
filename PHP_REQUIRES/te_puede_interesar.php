<?php
	$datos_historial_busqueda=M_historial_de_busqueda_R($conexion, 'NAVEGACION_IP', M_obtener_ip_real(), '', '', '', '');
	$i=0;
	while(isset($datos_historial_busqueda['TEXTO_BUSCADO'][$i])){
		$textos_buscados[$i]=$datos_historial_busqueda['TEXTO_BUSCADO'][$i];
		$i=$i+1;
	}
	$datos_de_productos_buscados_usuario=M_buscar_productos_te_puede_interesar($conexion, $textos_buscados);
?>
<?php
	if(isset($datos_de_productos_buscados_usuario['ID_PRODUCTO'][0])){
		if($datos_de_productos_buscados_usuario['ID_PRODUCTO'][0]<>""){
?>
		<section class="my-5">
			<div class="bg-white pb-3">
				<h3 class='text-center py-3 bg-dark text-warning'><b>Te Puede Interesar</b></h3>
				<table class="TablaDinamica1 w-100">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b class="h6"></th>
						</tr>
					</thead>
					<tbody>
				<?php
					$i=0;
					while(isset($datos_de_productos_buscados_usuario['ID_PRODUCTO'][$i])){
						echo "<tr><td><div class='container-fluid py-2'>
							<div class='row px-4'>
								<div class='col-md-3 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
									<div class='m-1'>
										<h5 class='text-left' style='height: 2em;'><e class='text-light' style='font-size:1px;'>" . $i . "</e><a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><strong>" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
										<div class='marco-ajustado hidden rounded border border-secondary'>
											<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_buscados_usuario['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
										</div>
										<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_buscados_usuario['UNIDAD_DE_VENTA'][$i] . "</h6>
										<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_buscados_usuario['DISPONIBLE'][$i] . "</h6>
										<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE'][$i] . " " . $datos_de_productos_buscados_usuario['APELLIDO'][$i] . "</a></h6>
										<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_CATEGORIA'][$i] . "</a></h6>
										<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
										 <a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_1'][$i] . " </a>
										 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_2'][$i] . " </a>
										 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_3'][$i] . " </a>
										 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_4'][$i] . " </a>
										 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_5'][$i] . "</a>
										</h6>
										<h6 class='mb-3 h4' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_buscados_usuario['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
									</div>
								</div>
						";
						$i=$i+1;
						if(isset($datos_de_productos_buscados_usuario['ID_PRODUCTO'][$i])){
							echo "
								<div class='col-md-3 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
									<div class='m-1'>
										<h5 class='text-left' style='height: 2em;'><a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><strong>" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
										<div class='marco-ajustado hidden rounded border border-secondary'>
											<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_buscados_usuario['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
										</div>
										<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_buscados_usuario['UNIDAD_DE_VENTA'][$i] . "</h6>
										<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_buscados_usuario['DISPONIBLE'][$i] . "</h6>
										<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE'][$i] . " " . $datos_de_productos_buscados_usuario['APELLIDO'][$i] . "</a></h6>
										<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_CATEGORIA'][$i] . "</a></h6>
										<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
										 <a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_1'][$i] . " </a>
										 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_2'][$i] . " </a>
										 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_3'][$i] . " </a>
										 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_4'][$i] . " </a>
										 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_5'][$i] . "</a>
										</h6>
										<h6 class='mb-3 h4' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_buscados_usuario['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
									</div>
								</div>
							";
						}
						$i=$i+1;
						if(isset($datos_de_productos_buscados_usuario['ID_PRODUCTO'][$i])){
							echo "
								<div class='col-md-3 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
									<div class='m-1'>
										<h5 class='text-left' style='height: 2em;'><a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><strong>" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
										<div class='marco-ajustado hidden rounded border border-secondary'>
											<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_buscados_usuario['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
										</div>
										<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_buscados_usuario['UNIDAD_DE_VENTA'][$i] . "</h6>
										<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_buscados_usuario['DISPONIBLE'][$i] . "</h6>
										<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE'][$i] . " " . $datos_de_productos_buscados_usuario['APELLIDO'][$i] . "</a></h6>
										<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_CATEGORIA'][$i] . "</a></h6>
										<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
										 <a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_1'][$i] . " </a>
										 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_2'][$i] . " </a>
										 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_3'][$i] . " </a>
										 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_4'][$i] . " </a>
										 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_5'][$i] . "</a>
										</h6>
										<h6 class='mb-3 h4' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_buscados_usuario['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
									</div>
								</div>
							";
						}
						$i=$i+1;
						if(isset($datos_de_productos_buscados_usuario['ID_PRODUCTO'][$i])){
							echo "
								<div class='col-md-3 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
									<div class='m-1'>
										<h5 class='text-left' style='height: 2em;'><a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><strong>" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "</strong></a></h5>
										<div class='marco-ajustado hidden rounded border border-secondary'>
											<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_PRODUCTO'][$i] . "' class='text-dark'><img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_buscados_usuario['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></a>
										</div>
										<h6 class='my-2' title='Unidad de Medida'><strong>Unidad:</strong> " . $datos_de_productos_buscados_usuario['UNIDAD_DE_VENTA'][$i] . "</h6>
										<h6 class='my-2' title='Cantidad Disponible'><strong>Disponible:</strong> " . $datos_de_productos_buscados_usuario['DISPONIBLE'][$i] . "</h6>
										<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE'][$i] . " " . $datos_de_productos_buscados_usuario['APELLIDO'][$i] . "</a></h6>
										<h6 class='my-2'><strong class='text-success'>Categoría:</strong> <a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_CATEGORIA'][$i] . "</a></h6>
										<h6 class='my-2' style='height: 70px'><strong class='text-primary'>Etiquetas:</strong>
										 <a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_1'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_1'][$i] . " </a>
										 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_2'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_2'][$i] . " </a>
										 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_3'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_3'][$i] . " </a>
										 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_4'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_4'][$i] . " </a>
										 &nbsp;&nbsp;<a href='buscar.php?buscar=" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_5'][$i] . "' class='text-dark'>" . $datos_de_productos_buscados_usuario['NOMBRE_ETIQUETA_5'][$i] . "</a>
										</h6>
										<h6 class='mb-3 h4' title='Precio en Penmón'><strong>Precio: " . number_format($datos_de_productos_buscados_usuario['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
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
<?php
		}
	}
?>