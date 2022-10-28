<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Detalle Prod</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<?php
	if(isset($_GET['id_producto'])){
		$id_producto_a_detallar=mysqli_real_escape_string($conexion,$_GET['id_producto']);
	}else if(isset($_POST['id_producto'])){
		$id_producto_a_detallar=mysqli_real_escape_string($conexion,$_POST['id_producto']);
	}else{
		$id_producto_a_detallar='';
	}
	$datos_del_producto_a_detallar=M_productos_y_servicios_R($conexion, 'ID_PRODUCTO', $id_producto_a_detallar, '', '', '', ''); 
	//AGREGANDO A TABlA DE PRODUCTOS VISTOS
	if($id_producto_a_detallar<>''){
		M_producto_visto_C($conexion, $id_producto_a_detallar, $datos_usuario_session['ID_USUARIO'][0], date("Y-m-d h:m:s"));
	}
	//AGREGANDO CPREGUNTA A TABlA DE PREGUNTAS AL VENDEDOR
	$verf_quien_pregunta="error";
	if(isset($_POST['id_quien_pregunta'])){
		$pregunta_recibida=mysqli_real_escape_string($conexion,$_POST['pregunta']);
		M_pregunta_vendedor_C($conexion, $_POST['id_quien_pregunta'], $_POST['id_producto'], date("Y-m-d h:m:s"), $pregunta_recibida, '', 'NO');
		$verf_quien_pregunta="ok";
	}
	?>
	<section class="my-3">
	<?php
		if($verf_quien_pregunta=="ok"){
			echo "<h3 class='mx-5 mb-4 bg-success text-center text-dark'>Tu pregunta fue enviada con ÉXITO</h3>";
		}
	?>
		<div class="bg-white pb-3">
		<?php
			if($id_producto_a_detallar==''){//SI NO HAY PRODUCTO DE REFERENCIA
				echo "<h3 class='text-center py-3 bg-dark text-danger display-4'>No se Seleccionó ningún Producto</h3><h6 class='text-center py-3 bg-dark text-light'>Por Favor intente una nueva busqueda en la opción <b class='text-danger'>&laquo;Buscar Producto&raquo;</b> del menú lateral</h6>";
			}else{//SI EXISTE UN PRODUCTO DE REFERENCIA
		?>
			<h3 class="text-center py-3 bg-dark text-warning"><b><?php echo $datos_del_producto_a_detallar['NOMBRE_PRODUCTO'][0];?></b></h3>
			<div class="container-fluid">
				<div class="row">
					<!-- SECCIÓN DE INFORMACIÓN GENERAL DEL PRODUCTO-->
					<div class="col-md-9">
						<div class="container-fluid">
							<div class="row">
								<!-- SECCIÓN PARA COLOCAR LAS FOTOS-->
								<div class="col-md-6">
									<!------ INICIO DEL CARRUSEL DE FOTOS DEL PRODUCTO ----------->
									<?php
										if($datos_del_producto_a_detallar['FOTO_2'][0]=="vacio.png" and $datos_del_producto_a_detallar['FOTO_3'][0]=="vacio.png" and $datos_del_producto_a_detallar['FOTO_4'][0]=="vacio.png" and $datos_del_producto_a_detallar['FOTO_5'][0]=="vacio.png"){
									?>
										<div class='marco-ajustado-carrusel hidden' width='100%'>
											<a href="IMAGENES_PRODUCTOS/<?php echo $datos_del_producto_a_detallar['FOTO_1'][0] . "?a=" . rand(); ?>" target="_blank"><img  src='IMAGENES_PRODUCTOS/<?php echo $datos_del_producto_a_detallar['FOTO_1'][0] . "?a=" . rand(); ?>' alt='<?php echo $datos_del_producto_a_detallar['NOMBRE_PRODUCTO'][0];?>' class='imgFit-carrusel' width='100%'></a>
										</div>
										<div class='bg-dark'>
											<h5 class='text-center text-light pb-2'>Foto 1</h5>
										</div>
									<?php
										}else{
									?>
										<div id="myCarousel" class="carousel slide img-fluid" data-ride="carousel">
											<ol class="carousel-indicators">
												<li data-target='#myCarousel' data-slide-to='0' class='active'></li>
										<?php
											if($datos_del_producto_a_detallar['FOTO_2'][0]<>"vacio.png"){
										?>
												<li data-target='#myCarousel' data-slide-to='1'></li>
										<?php		
											}
											if($datos_del_producto_a_detallar['FOTO_3'][0]<>"vacio.png"){
										?>
												<li data-target='#myCarousel' data-slide-to='2'></li>
										<?php		
											}
											if($datos_del_producto_a_detallar['FOTO_4'][0]<>"vacio.png"){
										?>
												<li data-target='#myCarousel' data-slide-to='3'></li>
										<?php		
											}
											if($datos_del_producto_a_detallar['FOTO_5'][0]<>"vacio.png"){
										?>
												<li data-target='#myCarousel' data-slide-to='4'></li>
										<?php		
											}
										?>
											</ol>
											<div class="carousel-inner">
												<div class='carousel-item active'>
													<div class='marco-ajustado-carrusel hidden' width='100%'>
														<a href="IMAGENES_PRODUCTOS/<?php echo $datos_del_producto_a_detallar['FOTO_1'][0] . "?a=" . rand(); ?>" target="_blank"><img class='first-slide imgFit-carrusel' src='IMAGENES_PRODUCTOS/<?php echo $datos_del_producto_a_detallar['FOTO_1'][0] . "?a=" . rand(); ?>' width='100%' alt='<?php echo $datos_del_producto_a_detallar['NOMBRE_PRODUCTO'][0];?>'></a>
													</div>
													<div class='bg-dark mb-4'>
														<h1 class='text-center text-light pb-2'>Foto 1</h1>
													</div>
												</div>
											<?php
												if($datos_del_producto_a_detallar['FOTO_2'][0]<>"vacio.png"){
											?>
												<div class='carousel-item'>
													<div class='marco-ajustado-carrusel hidden' width='100%'>
														<a href="IMAGENES_PRODUCTOS/<?php echo $datos_del_producto_a_detallar['FOTO_2'][0] . "?a=" . rand(); ?>" target="_blank"><img class='second-slide imgFit-carrusel' src='IMAGENES_PRODUCTOS/<?php echo $datos_del_producto_a_detallar['FOTO_2'][0] . "?a=" . rand(); ?>' width='100%' alt='<?php echo $datos_del_producto_a_detallar['NOMBRE_PRODUCTO'][0];?>'></a>
													</div>
													<div class='bg-dark mb-4'>
														<h1 class='text-center text-light pb-2'>Foto 2</h1>
													</div>
												</div>
											<?php
												}
												if($datos_del_producto_a_detallar['FOTO_3'][0]<>"vacio.png"){
											?>
												<div class='carousel-item'>
													<div class='marco-ajustado-carrusel hidden' width='100%'>
														<a href="IMAGENES_PRODUCTOS/<?php echo $datos_del_producto_a_detallar['FOTO_3'][0] . "?a=" . rand(); ?>" target="_blank"><img class='second-slide imgFit-carrusel' src='IMAGENES_PRODUCTOS/<?php echo $datos_del_producto_a_detallar['FOTO_3'][0] . "?a=" . rand(); ?>' width='100%' alt='<?php echo $datos_del_producto_a_detallar['NOMBRE_PRODUCTO'][0];?>'></a>
													</div>
													<div class='bg-dark mb-4'>
														<h1 class='text-center text-light pb-2'>Foto 3</h1>
													</div>
												</div>
											<?php
												}
												if($datos_del_producto_a_detallar['FOTO_4'][0]<>"vacio.png"){
											?>
												<div class='carousel-item'>
													<div class='marco-ajustado-carrusel hidden' width='100%'>
														<a href="IMAGENES_PRODUCTOS/<?php echo $datos_del_producto_a_detallar['FOTO_4'][0] . "?a=" . rand(); ?>" target="_blank"><img class='second-slide imgFit-carrusel' src='IMAGENES_PRODUCTOS/<?php echo $datos_del_producto_a_detallar['FOTO_4'][0] . "?a=" . rand(); ?>' width='100%' alt='<?php echo $datos_del_producto_a_detallar['NOMBRE_PRODUCTO'][0];?>'></a>
													</div>
													<div class='bg-dark mb-4'>
														<h1 class='text-center text-light pb-2'>Foto 4</h1>
													</div>
												</div>
											<?php
												}
												if($datos_del_producto_a_detallar['FOTO_5'][0]<>"vacio.png"){
											?>
												<div class='carousel-item'>
													<div class='marco-ajustado-carrusel hidden' width='100%'>
														<a href="IMAGENES_PRODUCTOS/<?php echo $datos_del_producto_a_detallar['FOTO_5'][0] . "?a=" . rand(); ?>" target="_blank"><img class='second-slide imgFit-carrusel' src='IMAGENES_PRODUCTOS/<?php echo $datos_del_producto_a_detallar['FOTO_5'][0] . "?a=" . rand(); ?>' width='100%' alt='<?php echo $datos_del_producto_a_detallar['NOMBRE_PRODUCTO'][0];?>'></a>
													</div>
													<div class='bg-dark mb-4'>
														<h1 class='text-center text-light pb-2'>Foto 5</h1>
													</div>
												</div>
											<?php
												}
											?>
											</div>
											<a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
												<span class="carousel-control-prev-icon" aria-hidden="true"></span>
												<span class="sr-only">Anterior</span>
											</a>
											<a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
												<span class="carousel-control-next-icon" aria-hidden="true"></span>
												<span class="sr-only">Siguiente</span>
											</a>
										</div>			
									<?php
										}
									?>
									<!------- FIN DEL CARRUSEL DE FOTOS DEL PRODUCTO ------->
								</div>
								<!-- SECCIÓN PARA COLOCAR LA INF. GENERAL DEL PRODUCTO-->
								<div class="col-md-6">
									<h6 class='mb-2 mt-0'><strong title='Unidad de Medida'>Unidad: </strong><?php echo $datos_del_producto_a_detallar['UNIDAD_DE_VENTA'][0]; ?></h6>
									<h6 class='my-2'><strong title='Cantidad Vendida'>Vendido: </strong>
									<?php
										$dato_para_cantidad_vendida= M_control_de_transacciones_compras_en_micoin_R($conexion, 'ESTATUS', 'ENTREGADO', 'VENDEDOR_CEDULA_RIF', $datos_del_producto_a_detallar['CEDULA_RIF'][0], 'NOMBRE_PRODUCTO', $datos_del_producto_a_detallar['NOMBRE_PRODUCTO'][0]);
										$cta=0;
										$cantidad_vendida=0;
										while(isset($dato_para_cantidad_vendida['CANTIDAD_COMPRADA'][$cta])){
											$cantidad_vendida=$cantidad_vendida + (float) $dato_para_cantidad_vendida['CANTIDAD_COMPRADA'][$cta];
											$cta=$cta+1;
										}
										echo $cantidad_vendida; 
									?>
									</h6>
									<h6 class='my-2'><strong title='Cantidad Disponible'>Disponible: </strong><?php echo $datos_del_producto_a_detallar['CANTIDAD_DISPONIBLE'][0]; ?></h6>
									<h6 class='my-2'><strong title='Precio en Penmón'>Precio: <?php echo $datos_del_producto_a_detallar['PRECIO_UNITARIO_MICOIN'][0]; ?> Pm</strong></h6>
									<hr>
									<h6 class='my-2'><strong class='text-dark'>Descripción:</strong></h6>
									<p class='my-2'><?php echo $datos_del_producto_a_detallar['DESCRIPCION_PRODUCTO'][0]; ?></p>
									<hr>
									<h6 class='my-2'><strong class='text-danger'>Vendedor:</strong><br><?php echo $datos_del_producto_a_detallar['NOMBRE'][0]; ?> <?php echo $datos_del_producto_a_detallar['APELLIDO'][0]; ?></h6>
									<h6 class='my-2'><strong class='text-dark'>Reputación:</strong><br>
									<?php 
										$datos_reputacion=M_reputacion_por_usuario($conexion, $datos_del_producto_a_detallar['CEDULA_RIF'][0]);
										echo M_dibuja_estrellas($datos_reputacion['PUNTOS'][0]); 
									?>
									</h6>
								</div>
							</div>
						</div>
					</div>
					<!-- SECCIÓN DE DATOS PARA COMPRAR O AGREGAR AL CARRITO-->
					<div class="col-md-3">
						<!-- FORMULARIO CARRITO -->
						<?php
							if($datos_usuario_session['ACCESO'][0]=="COMPRADOR-VENDEDOR"){
								$datos_verificar_carrito=M_carrito_compra_R($conexion, 'mc_usuarios', 'ID_USUARIO', $datos_usuario_session['ID_USUARIO'][0], 'mc_carrito_compra', 'ESTATUS', 'APARTADO', 'mc_carrito_compra', 'ID_PRODUCTO', $datos_del_producto_a_detallar['ID_PRODUCTO'][0]);
								$datos_operaciones= M_control_de_transacciones_compras_en_micoin_R($conexion, 'COMPRADOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'NOMBRE_PRODUCTO', $datos_del_producto_a_detallar['NOMBRE_PRODUCTO'][0], '', '');
								//TRATANDO LA FECHA DE LA ULTIMA OPERACIÓN DE COMPRA PARA ESTE PRODUCTO Y PARA ESTE COMPRADOR
								$fecha_pagado=explode(" ",$datos_operaciones['FH_PAGADO'][0]);
								$fecha_entregado=explode(" ",$datos_operaciones['FH_ENTREGADO'][0]);
								if(isset($datos_verificar_carrito['ID_PRODUCTO'][0])){
									if($datos_verificar_carrito['ID_PRODUCTO'][0]<>""){
										echo "<h6 class='text-danger text-center'><br><br><br>Este Producto ya ha sido agregado al Carrito.<br><br><br><br></h6>";
									}else if($fecha_pagado[0]==date("Y-m-d") or $fecha_entregado[0]==date("Y-m-d")){
										echo "<h6 class='text-danger text-center'><br><br><br>Este Producto ya ha sido Comprado por usted el día de Hoy.<br><br><br><br></h6>";
									}else if($datos_del_producto_a_detallar['CEDULA_RIF'][0]==$datos_usuario_session['CEDULA_RIF'][0]){
										echo "<h6 class='text-danger text-center'><br><br><br>Este Producto es TUYO...<br><br><br><br></h6>";
									}else{
							?>
										<form action="zona_usuario_carrito_compra.php" method="post" class="text-center bg-dark p-2 rounded mb-2">
											<input type="hidden" name="id_producto" id="id_producto" value="<?php echo $datos_del_producto_a_detallar['ID_PRODUCTO'][0];?>">
											<div class="input-group mb-2">
												<span class="input-group-text rounded-0 w-100 text-center">Cantidad:</span>
												<input type="number" class="form-control p-0 m-0 px-2 rounded-0 text-center" name="cantidad" id="cantidad" placeholder="Carrito" required autocomplete="off" title="Cantidad para el carrito" min="1" max="<?php echo $datos_del_producto_a_detallar['CANTIDAD_DISPONIBLE'][0];?>">
											</div>
											<div class="m-auto">
												<input type='submit' value='Al carrito' class='btn btn-warning p-1'>
											</div>
										</form>
							<?php
									}
								}else{
									if($fecha_pagado[0]==date("Y-m-d") or $fecha_entregado[0]==date("Y-m-d")){
										echo "<h6 class='text-danger text-center'><br><br><br>Este Producto ya ha sido Comprado por usted el día de Hoy.<br><br><br><br></h6>";
									}else if($datos_del_producto_a_detallar['CEDULA_RIF'][0]==$datos_usuario_session['CEDULA_RIF'][0]){
										echo "<h6 class='text-danger text-center'><br><br><br>Este Producto es TUYO...<br><br><br><br></h6>";
									}else{
							?>
										<form action="zona_usuario_carrito_compra.php" method="post" class="text-center bg-dark p-2 rounded mb-2">
											<input type="hidden" name="id_producto" id="id_producto" value="<?php echo $datos_del_producto_a_detallar['ID_PRODUCTO'][0];?>">
											<div class="input-group mb-2">
												<span class="input-group-text rounded-0 w-100 text-center">Cantidad:</span>
												<input type="number" class="form-control p-0 m-0 px-2 rounded-0 text-center" name="cantidad" id="cantidad" placeholder="Carrito" required autocomplete="off" title="Cantidad para el carrito" min="1" max="<?php echo $datos_del_producto_a_detallar['CANTIDAD_DISPONIBLE'][0];?>">
											</div>
											<div class="m-auto">
												<input type='submit' value='Al carrito' class='btn btn-warning p-1'>
											</div>
										</form>
						<?php
									}
								}
							}else{
								echo "<h3 class='text-danger py-5'>" . $datos_usuario_session['ACCESO'][0] . "</h3>";
							}
						?>
						<!-- FORMULARIO COMPRAR -->
						<?php
							if($datos_usuario_session['ACCESO'][0]=="COMPRADOR-VENDEDOR"){
								$datos_oper2= M_control_de_transacciones_compras_en_micoin_R($conexion, 'COMPRADOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'NOMBRE_PRODUCTO', $datos_del_producto_a_detallar['NOMBRE_PRODUCTO'][0], '', '');
								//TRATANDO LA FECHA DE LA ULTIMA OPERACIÓN DE COMPRA PARA ESTE PRODUCTO Y PARA ESTE COMPRADOR
								$fecha_pagado2=explode(" ",$datos_oper2['FH_PAGADO'][0]);
								$fecha_entregado2=explode(" ",$datos_oper2['FH_ENTREGADO'][0]);
								if(isset($datos_verificar_carrito['ID_PRODUCTO'][0])){
									if($datos_verificar_carrito['ID_PRODUCTO'][0]<>""){
										echo "<h6 class='text-danger text-center'><br><br><br>Este Producto ya ha sido agregado al Carrito.<br><br><br><br></h6>";
									}else if($fecha_pagado[0]==date("Y-m-d") or $fecha_entregado[0]==date("Y-m-d")){
										echo "<h6 class='text-danger text-center'><br><br><br>Este Producto ya ha sido Comprado por usted el día de Hoy<br><br><br><br></h6>";
									}else if($datos_del_producto_a_detallar['CEDULA_RIF'][0]==$datos_usuario_session['CEDULA_RIF'][0]){
										echo "<h6 class='text-danger text-center'><br><br><br>Este Producto es TUYO...<br><br><br><br></h6>";
									}else{
							?>
										<form action="zona_usuario_comprar_producto.php" method="post" class="text-center bg-dark p-2 rounded mb-2">
											<input type="hidden" name="id_producto" id="id_producto" value="<?php echo $datos_del_producto_a_detallar['ID_PRODUCTO'][0];?>">
											<div class="input-group mb-2">
												<span class="input-group-text rounded-0 w-100 text-center">Cantidad:</span>
												<input type="number" class="form-control p-0 m-0 px-2 rounded-0 text-center" name="cantidad_comprada" id="cantidad_comprada" placeholder="Compra" required autocomplete="off" title="Cantidad para a comprar" min="1" max="<?php echo $datos_del_producto_a_detallar['CANTIDAD_DISPONIBLE'][0];?>">
											</div>
											<div class="m-auto">
												<input type="submit" value="Comprar" class="btn btn-warning p-1">
											</div>
										</form>
							<?php
									}
								}else{
									if($fecha_pagado[0]==date("Y-m-d") or $fecha_entregado[0]==date("Y-m-d")){
										echo "<h6 class='text-danger text-center'><br><br><br>Este Producto ya ha sido Comprado por usted el día de Hoy<br><br><br><br></h6>";
									}else if($datos_del_producto_a_detallar['CEDULA_RIF'][0]==$datos_usuario_session['CEDULA_RIF'][0]){
										echo "<h6 class='text-danger text-center'><br><br><br>Este Producto es TUYO...<br><br><br><br></h6>";
									}else{
							?>
										<form action="zona_usuario_comprar_producto.php" method="post" class="text-center bg-dark p-2 rounded mb-2">
											<input type="hidden" name="id_producto" id="id_producto" value="<?php echo $datos_del_producto_a_detallar['ID_PRODUCTO'][0];?>">
											<div class="input-group mb-2">
												<span class="input-group-text rounded-0 w-100 text-center">Cantidad:</span>
												<input type="number" class="form-control p-0 m-0 px-2 rounded-0 text-center" name="cantidad_comprada" id="cantidad_comprada" placeholder="Compra" required autocomplete="off" title="Cantidad para a comprar" min="1" max="<?php echo $datos_del_producto_a_detallar['CANTIDAD_DISPONIBLE'][0];?>">
											</div>
											<div class="m-auto">
												<input type="submit" value="Comprar" class="btn btn-warning p-1">
											</div>
										</form>
						<?php			
									}
								}
							}
						?>
					</div>
				</div>
			</div>
			<div class="container-fluid">
				<h4 class='p-2 my-2 bg-warning'><strong class='text-dark'>Detalles del Producto:</strong></h4>
				<p class='my-2 text-left'><?php echo $datos_del_producto_a_detallar['CARACTERISTICAS_PRODUCTO'][0]; ?></p>
				<div class="container">
					<div class="row border">
						<div class="col-md-4 border">
							<h6 class='my-2'><strong class='text-success'>Categoria: </strong><br><?php echo $datos_del_producto_a_detallar['NOMBRE_CATEGORIA'][0]; ?></h6>
						</div>
						<div class="col-md-8 border">
							<h6 class='my-2 mb-3'><strong class='text-primary'>Etiquetas:</strong><br>
							<?php echo $datos_del_producto_a_detallar['NOMBRE_ETIQUETA_1'][0]; ?> 
							<?php echo $datos_del_producto_a_detallar['NOMBRE_ETIQUETA_2'][0]; ?> 
							<?php echo $datos_del_producto_a_detallar['NOMBRE_ETIQUETA_3'][0]; ?> 
							<?php echo $datos_del_producto_a_detallar['NOMBRE_ETIQUETA_4'][0]; ?> 
							<?php echo $datos_del_producto_a_detallar['NOMBRE_ETIQUETA_5'][0]; ?> 
							</h6>
						</div>
					</div>
				</div>
			</div>
			<!-- SECCIÓN DE PRODUCTOS SIMILARES POR LA CATEGORÍA -->
			<div class="container-fluid">
				<h4 class='p-2 my-2 bg-dark'><strong class='text-light'>Productos Similares:</strong></h4>
				<?php
					$datos_de_productos_similares=M_buscar_productos($conexion, '', '', '', $datos_del_producto_a_detallar['NOMBRE_CATEGORIA'][0], '', '');
				?>
				<table class="TablaDinamica1 w-100">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b class="h6"></th>
						</tr>
					</thead>
					<tbody>
				<?php
					$i=0;
					while(isset($datos_de_productos_similares['ID_PRODUCTO'][$i])){
						echo "<tr><td><div class='container-fluid py-2 px-0 mx-0'>
							<div class='row px-4'>";
						$pos=1;
						while($pos<=6){
							if(isset($datos_de_productos_similares['ID_PRODUCTO'][$i])){
								echo "
									<div class='col-6 col-sm-4 col-lg-2 col-xl-2 my-2'>
										<b class='text-light' style='font-size:1px;'>" . $i . $pos . "</b><br>
										<a class='text-dark' href='zona_usuario_detalle_producto.php?id_producto=" . $datos_de_productos_similares['ID_PRODUCTO'][$i] . "'>
											<div class='marco-ajustado hidden rounded border border-secondary'>
												<img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_similares['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'>
											</div>
											<h6 class='text-left'><strong>" . $datos_de_productos_similares['NOMBRE_PRODUCTO'][$i] . "</strong></h6>
											<h6 class='my-1 text-left' title='Precio en Penmón'><strong class='text-danger'>" . number_format($datos_de_productos_similares['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
										</a>
									</div>
								";
							}
							if($pos<6){
								$i=$i+1;
							}
							$pos=$pos+1;
						}
						echo "
							</div></div></td></tr>
						";
						$i=$i+1;
					}
				?>
				</table>				
			</div>
			<!-- SECCIÓN DE PRODUCTOS DEL VENDEDOR -->
			<div class="container-fluid">
				<h4 class='p-2 my-2 bg-warning' title="Productos del Vendedor"><strong class='text-dark'>Del Vendedor:</strong></h4>
				<?php
					$datos_de_productos_del_vendedor=M_buscar_productos($conexion, '', $datos_del_producto_a_detallar['CEDULA_RIF'][0], '', '', '', '');
				?>
				<table class="TablaDinamica1 w-100">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b class="h6"></th>
						</tr>
					</thead>
					<tbody>
				<?php
					$i=0;
					while(isset($datos_de_productos_del_vendedor['ID_PRODUCTO'][$i])){
						echo "<tr><td><div class='container-fluid py-2 px-0 mx-0'>
							<div class='row px-4'>";
						$pos=1;
						while($pos<=6){
							if(isset($datos_de_productos_del_vendedor['ID_PRODUCTO'][$i])){
								echo "
									<div class='col-6 col-sm-4 col-lg-2 col-xl-2 my-2'>
										<b class='text-light' style='font-size:1px;'>" . $i . $pos . "</b><br>
										<a class='text-dark' href='zona_usuario_detalle_producto.php?id_producto=" . $datos_de_productos_del_vendedor['ID_PRODUCTO'][$i] . "'>
											<div class='marco-ajustado hidden rounded border border-secondary'>
												<img src='IMAGENES_PRODUCTOS/" . $datos_de_productos_del_vendedor['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'>
											</div>
											<h6 class='text-left'><strong>" . $datos_de_productos_del_vendedor['NOMBRE_PRODUCTO'][$i] . "</strong></h6>
											<h6 class='my-1' title='Cantidad Disponible'>" . $datos_de_productos_del_vendedor['DISPONIBLE'][$i] . " " . $datos_de_productos_del_vendedor['UNIDAD_DE_VENTA'][$i] . "</h6>
											<h6 class='my-1 text-left text-danger' title='Precio en Penmón'><strong>" . number_format($datos_de_productos_del_vendedor['PRECIO_UNITARIO'][$i], 2,',','.') . " Pm</strong></h6>
										</a>
									</div>
								";
							}
							if($pos<6){
								$i=$i+1;
							}
							$pos=$pos+1;
						}
						echo "
							</div></div></td></tr>
						";
						$i=$i+1;
					}
				?>
				</table>				
			</div>
			<!-- SECCIÓN DE REPUTACIÓN DEL VENDEDOR -->
			<div class="container-fluid">
				<h4 class='p-2 my-2 bg-dark'>
					<strong class='text-light' title="Reputación del Vendedor">Reputación: &nbsp;&nbsp;</strong><b class="small">
					<?php 
						if($datos_reputacion['PUNTOS'][0]>0){
							echo M_dibuja_estrellas($datos_reputacion['PUNTOS'][0]); 
						}
					?>
				</b></h4>
				<?php
					$datos_evaluaciones_del_vendedor=M_reputacion_por_usuario_detalle($conexion, $datos_del_producto_a_detallar['CEDULA_RIF'][0]);
					if($datos_evaluaciones_del_vendedor['COMPRADOR_NOMBRE'][0]<>''){
				?>
				<table class="TablaDinamica1 w-100">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b class="h6"></th>
						</tr>
					</thead>
					<tbody>
				<?php
					$i=0;
					while(isset($datos_evaluaciones_del_vendedor['COMPRADOR_NOMBRE'][$i])){
						echo "<tr><td><div class='container-fluid py-2 px-0 mx-0'>
							<div class='row px-4'>";
						$pos=1;
						while($pos<=3){
							if(isset($datos_evaluaciones_del_vendedor['COMPRADOR_NOMBRE'][$i])){
								echo "
									<div class='col-md-6 col-lg-4 my-2 border'>
										<b class='text-light' style='font-size:1px;'>" . $i . $pos . "</b><br>
										<h6 class='text-center'><strong>" . M_dibuja_estrellas($datos_evaluaciones_del_vendedor['EVALUACION_PUNTOS'][$i]) . "</strong></h6>
										<h6 class='my-1' title='Fecha de la evaluación'><strong>Fecha:</strong> ";
								$fecha_eval=explode(" ", $datos_evaluaciones_del_vendedor['FH_EVALUACION'][$i]);
								echo $fecha_eval[0];
								echo "
										</h6>
										<h6 class='my-1' title='Monbre del Evaluador'><strong>Comprador:</strong> " . $datos_evaluaciones_del_vendedor['COMPRADOR_NOMBRE'][$i] . " " . $datos_evaluaciones_del_vendedor['COMPRADOR_APELLIDO'][$i] . "
										</h6>
										<p class='my-1 text-left' title='Comentario'><strong>Comentario:</strong> " . $datos_evaluaciones_del_vendedor['EVALUACION_COMENTARIO'][$i] . "</p>
									</div>
								";
							}
							if($pos<3){
								$i=$i+1;
							}
							$pos=$pos+1;
						}
						echo "
							</div></div></td></tr>
						";
						$i=$i+1;
					}
				?>
				</table>				
				<?php		
					}else{
				?>
				<h3 class="text-center text-danger my-2"><b>Este vendedor no ha sido evaluado.</b></h3>
				<?php		
					}
				?>
			</div>
			<!-- SECCIÓN DE COMENTARIOS AL VENDEDOR -->
			<div class="container-fluid">
				<h4 class='p-2 my-2 bg-warning'><strong class='text-dark'>Preguntas al Vendedor:</strong></h4>
				<?php
					$datos_preguntas_al_vendedor=M_pregunta_vendedor_R($conexion, 'mc_preguntas_al_vendedor', 'ID_PRODUCTO', $id_producto_a_detallar, '', '', '', '', '', '');
					if($datos_preguntas_al_vendedor['PREGUNTA'][0]<>''){
				?>
				<table class="TablaDinamica10 w-100">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b class="h6"></th>
						</tr>
					</thead>
					<tbody>
				<?php
					$i=0;
					while(isset($datos_preguntas_al_vendedor['PREGUNTA_NOMBRE'][$i])){
						echo "<tr><td><div class='container-fluid py-2 px-0 mx-0'>
							<div class='row px-4'>";
						$pos=1;
						while($pos<=6){
							if(isset($datos_preguntas_al_vendedor['PREGUNTA_NOMBRE'][$i])){
								echo "
									<div class='col-12 my-2 border'>
										<h6 class='my-1'><strong title='Fecha de la pregunta'>Fecha:</strong> ";
								$fecha_pv=explode(" ", $datos_preguntas_al_vendedor['FH_PREGUNTA'][$i]);
								echo $fecha_pv[0];
								echo " &nbsp;&nbsp;<strong title='Monbre de quien pregunta'>Comprador:</strong> " . $datos_preguntas_al_vendedor['PREGUNTA_NOMBRE'][$i] . " " . $datos_preguntas_al_vendedor['PREGUNTA_APELLIDO'][$i] . "
										</h6>
										<p class='my-1 text-left' title='Pregunta'><strong>Pregunta:</strong><br>" . $datos_preguntas_al_vendedor['PREGUNTA'][$i] . "</p>
										<p class='my-1 text-left' title='Respuesta'><strong>Respuesta:</strong><br>" . $datos_preguntas_al_vendedor['RESPUESTA'][$i] . "</p>";
								if($datos_preguntas_al_vendedor['RESPUESTA'][$i]==""){
									echo "<p><b class='text-danger'>Sin Respuesta</b></p>";
								}
								echo "
									</div>
								";
							}
							if($pos<6){
								$i=$i+1;
							}
							$pos=$pos+1;
						}
						echo "
							</div></div></td></tr>
						";
						$i=$i+1;
					}
				?>
				</table>				
				<?php		
					}else{
				?>
				<h3 class="text-center text-danger my-2"><b>Este producto no ha recibido preguntas.</b></h3>
				<?php		
					}
				?>
			</div>
			<!-- SECCIÓN DE HACER UN NUEVO COMENTARIOP VENDEDOR -->
			<div class="container-fluid">
				<h4 class='p-2 my-2 bg-dark'><strong class='text-light'>Hacer una Pregunta:</strong></h4>
				<form action="zona_usuario_detalle_producto.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="id_producto" id="id_producto" value="<?php echo $datos_del_producto_a_detallar['ID_PRODUCTO'][0];?>">
					<input type="hidden" name="id_quien_pregunta" id="id_quien_pregunta" value="<?php echo $datos_usuario_session['ID_USUARIO'][0];?>">
					<div class="input-group mb-2 text-left">
						<span class="input-group-text rounded-0 w-100">Pregunta:</span>
						<textarea class="form-control p-0 m-0 px-2 rounded-0" name="pregunta" id="pregunta" placeholder="Escribe tu pregunta aquí" required autocomplete="off" title="Introduzca su pregunta" rows="2"></textarea>
					</div>
					<script>
						$(document).ready(function() {
							$('#pregunta').summernote({
								placeholder: 'Introduzca su pregunta',
								tabsize: 1,
								height: 100								
							});
						});
					</script>
					<div class="m-auto">
						<input type="submit" value="Preguntar" class="btn btn-warning mb-2">
					</div>
				</form>
			</div>
		<?php
			}
		?>
		</div>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>