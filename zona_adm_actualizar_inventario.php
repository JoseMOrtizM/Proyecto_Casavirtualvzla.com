<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_GET['FORM'])){
		if($_GET['FORM']=='ACTUALIZAR_INVENTARIO'){
			M_productos_y_servicios_actualizar_todo_el_inventario($conexion);
			//ENVIANDO MENSAJES AL BLOG INTERNO
			$datos_act=M_usuarios_R($conexion, 'ACCESO', 'COMPRADOR-VENDEDOR', 'ESTATUS', 'ACTIVO', '', '');
			$fecha_ahora=date("Y-m-d h:m:s");
			$i=0;
			$usuarios_actualizados[0]="<b class='text-danger'>No hubo cambios de Inventario.</b>";
			$cta_user_act=0;
			while(isset($datos_act['ID_USUARIO'][$i])){
				if($datos_act['ID_USUARIO'][$i]<>""){
					$datos_prod[$i]=M_productos_y_servicios_R($conexion, 'CEDULA_RIF', $datos_act['CEDULA_RIF'][$i], '', '', '', '');
					$e=0;
					$verf_usuario[$i]=0;
					$lista_prod_act[$i]="";
					while(isset($datos_prod[$i]['ID_PRODUCTO'][$e])){
						if($datos_prod[$i]['ID_PRODUCTO'][$e]<>""){
							$verf_i=M_productos_y_servicios_verf_inventario_prod_actualizao( $conexion, $datos_prod[$i]['REESTABLECER_INVENTARIO_PERIODICIDAD'][$e]);
							if($verf_i){
								$verf_usuario[$i]++;
								$lista_prod_act[$i]=$lista_prod_act[$i] . "<li><b>Producto:</b> " . $datos_prod[$i]['NOMBRE_PRODUCTO'][$e] . " (cantidad: " . $datos_prod[$i]['CANTIDAD_DISPONIBLE_PLAN'][$e] . ").</li>";
							}
						}
						$e++;
					}
					if($verf_usuario[$i]>0){
						$mensaje="<h6>Hemos Actualizado el inventario de los siguientes productos: </h6><ul>";
						$mensaje=$mensaje . $lista_prod_act[$i];
						$mensaje=$mensaje . "</ul>";
						$mensaje2="<ul>";
						$mensaje2=$mensaje2 . $lista_prod_act[$i];
						$mensaje2=$mensaje2 . "</ul>";
						M_blog_interno_C($conexion, $datos_act['NOMBRE'][$i], $datos_act['APELLIDO'][$i], $datos_act['CEDULA_RIF'][$i], $datos_act['CORREO'][$i], $datos_act['FECHA_NACIMIENTO'][$i], '', '0000-00-00 00:00:00', $mensaje, $fecha_ahora, '0', 'NO');
						$usuarios_actualizados[$cta_user_act]=$datos_act['NOMBRE'][$i] . ' ' . $datos_act['APELLIDO'][$i] . ' (' . $datos_act['CORREO'][$i] . '): ' . $mensaje2;
						$cta_user_act++;
					}
				}
				$i++;
			}
			//insertando registro en balance
			$datos_ultimo_balance_iii=M_balance_administrativo_lcv_R_ultimo($conexion);
			$verf_ba_iii=M_balance_administrativo_lcv_PRECALCULOS($conexion, date("Y-m-d h:m:s"), 'ACTUALIZAR INVENTARIO', '', '', $datos_ultimo_balance_iii['TC_BS_DOLLAR'][0], '', '');
		}
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>Actualizar Inventario</title>
</head>
<body>
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid mt-2 mb-5 bg-secondary px-0">
		<br>
		<div class="card mb-3 bg-dark rounded-0 col-12 col-md-9 col-lg-8 col-xl-7 mx-auto">
			<div class="card-header text-center text-warning">
				<h3 class='text-center'><a href="zona_adm_actualizar_inventario.php?FORM=ACTUALIZAR_INVENTARIO" class="btn btn-danger my-2"><b>Actualizar Inventario</b></a></h3>
			</div>
			<div class="px-md-5">
				<?php
					if(isset($usuarios_actualizados[0])){
						echo "<div class='bg-light text-dark text-left p-2 mb-3'>";
						echo "<h4 class='text-center'><b>ACTUALIZACIÓN EXITOSA.</b></h4>";
						if(isset($usuarios_actualizados[1])){
							echo "<h6>Estos son los Usuarios que cambiaron su inventario:</h6>";
						}
						echo "<ul>";
						$e=0;
						while(isset($usuarios_actualizados[$e])){
							echo "<li>" . $usuarios_actualizados[$e] . "</li>";
							$e++;
						}
						echo "</ul>";
						if(isset($usuarios_actualizados[1])){
							echo "<b>NOTA:</b> Se enviaron notificaciones (Vía Blog Interno) a todos estos usuarios.";
						}
						echo "</div>";

					}
				?>
			</div>
			<div class="card-body px-1 mb-3 bg-white">
				<div class="table-responsive">
					<table class="table table-bordered table-hover TablaDinamica">
						<thead>
							<tr class="text-center">
						<thead>
							<tr class="text-center">
								<th class="align-middle w-25" style="width: 15%;"><b title="Foto del Producto">Foto</b></th>
								<th class="align-middle" style="width: 85%;"><b title="Nombre del vendedor, nombre del producto, Inventario Plan / Restablecer en / Real">Producto</b></th>
							</tr>
						</thead>
						<tbody>
							<?php
							//obteniendo los datos de la tabla:
							$datos=M_productos_y_servicios_R($conexion, '', '', '', '', '', '');
							$i=0;
							while(isset($datos['ID_PRODUCTO'][$i])){
								if($datos['ID_PRODUCTO'][$i]<>""){
									echo "<tr>";
									echo "<td class='text-left'><img src='IMAGENES_PRODUCTOS/" . $datos['FOTO_1'][$i] . "?a=" . rand() . "' class='imgFit'></td>";
									echo "<td class='text-left'><b>Vendedor:</b> " . $datos['NOMBRE'][$i] . " " . $datos['APELLIDO'][$i] . "<br><b>Producto:</b> " . $datos['NOMBRE_PRODUCTO'][$i] . "<br><b>Plan:</b> " . $datos['CANTIDAD_DISPONIBLE_PLAN'][$i] . " (" . $datos['UNIDAD_DE_VENTA'][$i] . ")<br><b>Reponer:</b> " . $datos['REESTABLECER_INVENTARIO_PERIODICIDAD'][$i] . "<br><b>Actual:</b> " . $datos['CANTIDAD_DISPONIBLE'][$i] . " (" . $datos['UNIDAD_DE_VENTA'][$i] . ")</td>";
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
		<br><br><br>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>