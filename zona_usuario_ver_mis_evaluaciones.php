<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Mi Reputación</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid px-0 mx-0 mx-md-2 px-md-4 mt-2 mb-5 bg-transparent">
		<br>
		<h4 class='p-4 mt-2 mb-0 bg-dark text-center'>
			<?php 
				$datos_evaluacion_gral=M_reputacion_por_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
				if($datos_evaluacion_gral['PUNTOS'][0]>0){
					echo M_dibuja_estrellas($datos_evaluacion_gral['PUNTOS'][0]); 
				}
			?>
		</h4>
		<?php
			$datos_evaluaciones_del_vendedor=M_reputacion_por_usuario_detalle($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
			if($datos_evaluaciones_del_vendedor['COMPRADOR_NOMBRE'][0]<>''){
		?>
		<div class="bg-light py-2 my-0">
			<table class="my-0 TablaDinamica10 w-100">
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
					while($pos<=6){
						if(isset($datos_evaluaciones_del_vendedor['COMPRADOR_NOMBRE'][$i])){
							echo "
								<div class='col-md-6 col-lg-4 my-2 border'>
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
		<?php		
			}else{
		?>
		<h3 class="text-center text-danger py-2 bg-light"><b>No has sido evaluado.</b></h3>
		<?php		
			}
		?>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>