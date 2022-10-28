<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_GET['FORM'])){
		if($_GET['FORM']=='ACTUALIZAR_RANKINGS'){
			$datos_act=M_usuarios_R($conexion, 'ACCESO', 'COMPRADOR-VENDEDOR', 'ESTATUS', 'ACTIVO', '', '');
			$fecha_ahora=date("Y-m-d h:m:s");
			$i=0;
			$usuarios_actualizados[0]="<b class='text-danger'>No hubo cambios de Ranking.</b>";
			$cta_user_act=0;
			while(isset($datos_act['ID_USUARIO'][$i])){
				if($datos_act['ID_USUARIO'][$i]<>""){
					//rescatando datos del usuario para calcular su ranking
					$datos_ventas= M_c_d_t_cuenta_ventas_por_usuario($conexion, $datos_act['CEDULA_RIF'][$i]);
					$rep_user= M_reputacion_por_usuario($conexion, $datos_act['CEDULA_RIF'][$i]);
					$datos_saldo_disponible_usuario= M_saldo_pm_disponible_usuario($conexion, $datos_act['CEDULA_RIF'][$i]);
					//actualizando ranking
					if($datos_ventas['CANTIDAD']>='100' and $rep_user['PUNTOS'][0]>='3.5' and $datos_saldo_disponible_usuario['SALDO_PEMON'][0]>='100000'){
						if($datos_act['RANKING'][$i]<>'DIAMANTE'){
							M_blog_interno_C($conexion, $datos_act['NOMBRE'][$i], $datos_act['APELLIDO'][$i], $datos_act['CEDULA_RIF'][$i], $datos_act['CORREO'][$i], $datos_act['FECHA_NACIMIENTO'][$i], '', '0000-00-00 00:00:00', "Hemos Actualizado tu ranking como vendedor a: <b>DIAMANTE</b>.", $fecha_ahora, '0', 'NO');
							$usuarios_actualizados[$cta_user_act]=$datos_act['RANKING'][$i] . ' => DIAMANTE: ' . $datos_act['NOMBRE'][$i] . ' ' . $datos_act['APELLIDO'][$i] . ' (' . $datos_act['CORREO'][$i] . ').';
							$cta_user_act++;
						}
						M_usuarios_U_id_ranking($conexion, $datos_act['ID_USUARIO'][$i], 'DIAMANTE');
					}else if($datos_ventas['CANTIDAD']>='100' and $rep_user['PUNTOS'][0]>='3.5' and $datos_saldo_disponible_usuario['SALDO_PEMON'][0]<'100000'){
						if($datos_act['RANKING'][$i]<>'PLATINO'){
							M_blog_interno_C($conexion, $datos_act['NOMBRE'][$i], $datos_act['APELLIDO'][$i], $datos_act['CEDULA_RIF'][$i], $datos_act['CORREO'][$i], $datos_act['FECHA_NACIMIENTO'][$i], '', '0000-00-00 00:00:00', "Hemos Actualizado tu ranking como vendedor a: <b>PLATINO</b>.", $fecha_ahora, '0', 'NO');
							$usuarios_actualizados[$cta_user_act]=$datos_act['RANKING'][$i] . ' => PLATINO: ' . $datos_act['NOMBRE'][$i] . ' ' . $datos_act['APELLIDO'][$i] . ' (' . $datos_act['CORREO'][$i] . ').';
							$cta_user_act++;
						}
						M_usuarios_U_id_ranking($conexion, $datos_act['ID_USUARIO'][$i], 'PLATINO');
					}else if($datos_ventas['CANTIDAD']>='100' and $rep_user['PUNTOS'][0]<'3.5'){
						if($datos_act['RANKING'][$i]<>'ORO'){
							M_blog_interno_C($conexion, $datos_act['NOMBRE'][$i], $datos_act['APELLIDO'][$i], $datos_act['CEDULA_RIF'][$i], $datos_act['CORREO'][$i], $datos_act['FECHA_NACIMIENTO'][$i], '', '0000-00-00 00:00:00', "Hemos Actualizado tu ranking como vendedor a: <b>ORO</b>.", $fecha_ahora, '0', 'NO');
							$usuarios_actualizados[$cta_user_act]=$datos_act['RANKING'][$i] . ' => ORO: ' . $datos_act['NOMBRE'][$i] . ' ' . $datos_act['APELLIDO'][$i] . ' (' . $datos_act['CORREO'][$i] . ').';
							$cta_user_act++;
						}
						M_usuarios_U_id_ranking($conexion, $datos_act['ID_USUARIO'][$i], 'ORO');
					}else if($datos_ventas['CANTIDAD']>='50'){
						if($datos_act['RANKING'][$i]<>'PLATA'){
							M_blog_interno_C($conexion, $datos_act['NOMBRE'][$i], $datos_act['APELLIDO'][$i], $datos_act['CEDULA_RIF'][$i], $datos_act['CORREO'][$i], $datos_act['FECHA_NACIMIENTO'][$i], '', '0000-00-00 00:00:00', "Hemos Actualizado tu ranking como vendedor a: <b>PLATA</b>.", $fecha_ahora, '0', 'NO');
							$usuarios_actualizados[$cta_user_act]=$datos_act['RANKING'][$i] . ' => PLATA: ' . $datos_act['NOMBRE'][$i] . ' ' . $datos_act['APELLIDO'][$i] . ' (' . $datos_act['CORREO'][$i] . ').';
							$cta_user_act++;
						}
						M_usuarios_U_id_ranking($conexion, $datos_act['ID_USUARIO'][$i], 'PLATA');
					}else{
						if($datos_act['RANKING'][$i]<>'HIERRO'){
							M_blog_interno_C($conexion, $datos_act['NOMBRE'][$i], $datos_act['APELLIDO'][$i], $datos_act['CEDULA_RIF'][$i], $datos_act['CORREO'][$i], $datos_act['FECHA_NACIMIENTO'][$i], '', '0000-00-00 00:00:00', "Hemos Actualizado tu ranking como vendedor a: <b>HIERRO</b>.", $fecha_ahora, '0', 'NO');
							$usuarios_actualizados[$cta_user_act]=$datos_act['RANKING'][$i] . ' => HIERRO: ' . $datos_act['NOMBRE'][$i] . ' ' . $datos_act['APELLIDO'][$i] . ' (' . $datos_act['CORREO'][$i] . ').';
							$cta_user_act++;
						}
						M_usuarios_U_id_ranking($conexion, $datos_act['ID_USUARIO'][$i], 'HIERRO');
					}
				}
				$i=$i+1;
			}
			//insertando registro en blanace
			$datos_ultimo_balance_iii=M_balance_administrativo_lcv_R_ultimo($conexion);
			M_balance_administrativo_lcv_PRECALCULOS($conexion, date("Y-m-d h:m:s"), 'ACTUALIZAR RANKINGS', '', '', $datos_ultimo_balance_iii['TC_BS_DOLLAR'][0], '', '');
		}
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>Actualizar Rankings</title>
</head>
<body>
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid mt-2 mb-5 bg-secondary px-0">
	<br>
	<div class="card mb-3 bg-dark rounded-0 col-12 col-md-9 col-lg-8 col-xl-7 mx-auto">
		<div class="card-header text-center text-warning">
			<h3 class='text-center'><a href="zona_adm_actualizar_rankings.php?FORM=ACTUALIZAR_RANKINGS" class="btn btn-danger my-2"><b>Actualizar Rankings</b></a></h3>
		</div>
		<div class="px-md-5">
			<?php
				if(isset($usuarios_actualizados[0])){
					echo "<div class='bg-light text-dark text-left p-2 mb-3'>";
					echo "<h4 class='text-center'><b>ACTUALIZACIÓN EXITOSA.</b></h4>";
					if(isset($usuarios_actualizados[1])){
						echo "<h6>Estos son los Usuarios que cambiaron de Ranking:</h6>";
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
							<th class="align-middle" style="width: 15%"><b title="Foto del Usuario">Foto</b></th>
							<th class="align-middle" style="width: 85%"><b title="Información del Usuario y su Ranking Actual">Usuario</b></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//obteniendo los datos de la tabla:
						$datos=M_usuarios_R($conexion, 'ACCESO', 'COMPRADOR-VENDEDOR', 'ESTATUS', 'ACTIVO', '', '');
						$i=0;
						while(isset($datos['ID_USUARIO'][$i])){
							if($datos['ID_USUARIO'][$i]<>""){
								echo "<tr>";
								echo "<td class='text-left'><img src='IMAGENES_USUARIOS/" . $datos['FOTO_LOGO'][$i] . "?a=" . rand() . "' class='imgFit w-100'></td>";
								echo "<td class='text-left'><b>Nombre: </b>" . $datos['NOMBRE'][$i] . " " . $datos['APELLIDO'][$i] . "<br><e class='small'><b class='text-danger'>" . $datos['CORREO'][$i] . "</b></e><br>";
								echo "<div class='py-0 my-0 pt-1 text-left'><img src='img/ranking_" . strtolower($datos['RANKING'][$i]) . ".png?a=" . rand() . "' alt='" . $datos['RANKING'][$i] . "' title='" . $datos['RANKING'][$i] . "' class='imgFit mt-0 pt-0' style='width: 30px'> " . $datos['RANKING'][$i] . "</div>";
							
									echo "<b>Ventas:</b> ";
									$datos_ventas= M_c_d_t_cuenta_ventas_por_usuario($conexion, $datos['CEDULA_RIF'][$i]);
									echo $datos_ventas['CANTIDAD'];

									echo "<br><b title='Reputación'>Rep:</b> ";
									$rep_user= M_reputacion_por_usuario($conexion, $datos['CEDULA_RIF'][$i]);
									echo M_dibuja_estrellas($rep_user['PUNTOS'][0]);

									echo "<br><b title='Saldo Disponible'>Saldo (Pm):</b> ";
									$datos_saldo_disponible_usuario= M_saldo_pm_disponible_usuario($conexion, $datos['CEDULA_RIF'][$i]);
									echo number_format( $datos_saldo_disponible_usuario['SALDO_PEMON'][0], 2,',','.');
								
								echo "</td>";
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