<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	if(isset($_POST['id_producto'])){
		$id_producto=mysqli_real_escape_string($conexion,$_POST['id_producto']);
		$cantidad_al_carrito=mysqli_real_escape_string($conexion,$_POST['cantidad']);
		$verif_carga_en_carrito=M_carrito_compra_C($conexion, $datos_usuario_session['ID_USUARIO'][0], $id_producto, $cantidad_al_carrito, date("Y-m-d h:m:s"), 'APARTADO');
	}
	if(isset($_GET['accion'])){
		if($_GET['accion']=='borrar'){
			$id_carrito_producto_borrar=mysqli_real_escape_string($conexion,$_GET['NA_Id']);
			M_carrito_actualizar_id_carrito_borrado($conexion, $id_carrito_producto_borrar);
		}
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Carrito de Compra</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="my-3">
		<div class='mb-3 bg-warning rounded-0'>
			<div class='text-dark py-2'>
				<h3 class='text-center'><b>Carrito de Compra</b></h3>
			</div>
		</div>
		<?php
		$vendedores_agrupados=M_carrito_compra_R_agrupa_vendedor($conexion, 'mc_usuarios', 'ID_USUARIO', $datos_usuario_session['ID_USUARIO'][0], 'mc_carrito_compra', 'ESTATUS', 'APARTADO', '', '', '');
		$e=0;
		while(isset($vendedores_agrupados['VEND_CEDULA_RIF'][$e])){
			$datos[$e]=M_carrito_compra_R($conexion, 'mc_usuarios', 'ID_USUARIO', $datos_usuario_session['ID_USUARIO'][0], 'mc_carrito_compra', 'ESTATUS', 'APARTADO', 'mc_productos_y_servicios', 'CEDULA_RIF', $vendedores_agrupados['VEND_CEDULA_RIF'][$e]);
			$i=0;
			//NUEVA TABLA
			echo "
				<div class='card mb-3 bg-dark rounded-0'>
					<div class='card-header text-center text-warning'>
						<h3 class='text-center'>Vendedor:<br><b class='text-light'>" . $vendedores_agrupados['VEND_NOMBRE'][$e] . " " .  $vendedores_agrupados['VEND_APELLIDO'][$e] . "</b></h3>
					</div>
					<div class='card-body px-1 bg-white'>
						<div class='table-responsive'>
							<table class='table table-bordered table-hover TablaDinamica'>
								<thead>
									<tr class='text-center'>
										<th class='align-middle'><b title='Nombre del Producto, Foto, cantidad disponible y cantidad apartada'>Producto</b></th>
										<th class='align-middle'><b>Acciones</b></th>
									</tr>
								</thead>
								<tbody>
			";
			while(isset($datos[$e]['VEND_CEDULA_RIF'][$i])){
				if($datos[$e]['VEND_CEDULA_RIF'][$i]<>""){
					//NUEVO RENGLON
					echo "<tr>";
					echo "<td class='text-left align-middle w-50 pl-0 pl-md-5'><b>" . $datos[$e]['NOMBRE_PRODUCTO'][$i] . "</b><br><a href='zona_usuario_detalle_producto.php?id_producto=" . $datos[$e]['ID_PRODUCTO'][$i] . "'><img src='IMAGENES_PRODUCTOS/" . $datos[$e]['FOTO_1'][$i] . "?a=" . rand() . "' class='border border-secondary' style='height:5em;'></a><h6><b>Disponible:</b> " . $datos[$e]['CANTIDAD_DISPONIBLE'][$i] . " " . $datos[$e]['UNIDAD_DE_VENTA'][$i] . "</h6><h6><b>Apartado:</b> " . $datos[$e]['CANTIDAD'][$i] . "</h6></td>";
					echo "<td class='text-center align-middle w-50'>";
					echo "<div class='container-fluid'>
							<div class='row'>
								<div class='col-12'>
									<form action='zona_usuario_comprar_producto.php' method='post' class='d-inline'>
										<input type='hidden' name='id_producto' id='id_producto' value='" . $datos[$e]['ID_PRODUCTO'][$i] . "'>
										<input type='hidden' name='cantidad_comprada' id='cantidad_comprada' value='" . $datos[$e]['CANTIDAD'][$i] . "'>
										<div class='bg-transparent'>
											<span class='text-success fa fa-shopping-basket mx-0 px-0'></span>
											<input type='submit' value='Comprar' title='Comprar o Modificar' class='btn btn-transparent text-success mx-0 px-0 bg-transparent'>
										</div>
									</form>
								</div>
								<div class='col-12'>
									<a title='Eliminar' href='zona_usuario_carrito_compra.php?accion=borrar&NA_Id=" . $datos[$e]['ID_CARRITO_COMPRA'][$i] . "' class='btn btn-transparent text-danger'><span class='fa fa-trash-o mx-0 px-0'></span> Eliminar</a></td>
								</div>
							</div>
						</div>
					</tr>";
				}
				$i++;
			}
			if($i>1){
				echo "
								<tbody>
							</table>
						</div>
					</div>
					<div class='text-center m-auto mt-1'>
						<a href='zona_usuario_comprar_varios.php?vend_ceduda_rif=" . $vendedores_agrupados['VEND_CEDULA_RIF'][$e]. "'><h5 class='btn btn-success mt-1' title='Comprar todos los productos del carrito al Vendedor: " . $vendedores_agrupados['VEND_NOMBRE'][$e] . " " .  $vendedores_agrupados['VEND_APELLIDO'][$e] . "'>Comprar todo</h5></a>
					</div>
				</div>
				";
			}else{
				echo "
								<tbody>
							</table>
						</div>
					</div>
				</div>
				";
			}
			$e++;
		}
		?>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>