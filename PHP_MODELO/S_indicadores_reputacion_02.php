<?php
//ESTA SUB RUTINA IMPRIME LA TABLA PARA INDICADORES-REPUTACIÓN MEJORES EVALUACIONES
if(isset($_POST['vendedor_cedula_rif']) and isset($_POST['ano'])){
	require_once ("M_todos.php");
	$datos_evaluaciones_del_vendedor=M_reputacion_por_usuario_peores_evaluaciones($conexion, $_POST['vendedor_cedula_rif'], $_POST['ano']);
	if($datos_evaluaciones_del_vendedor['COMPRADOR_NOMBRE'][0]<>''){
		echo "<table class='TablaDinamica3 w-100'>";
		echo "
			<thead>
				<tr class='text-center'>
					<th class='align-middle'><b class='h6'></th>
				</tr>
			</thead>
			<tbody>
		";
		$i=0;
		while(isset($datos_evaluaciones_del_vendedor['COMPRADOR_NOMBRE'][$i]) and $i<6){
			echo "<tr><td>";
			if(isset($datos_evaluaciones_del_vendedor['COMPRADOR_NOMBRE'][$i])){
				if($datos_evaluaciones_del_vendedor['COMPRADOR_NOMBRE'][$i]<>""){
					$fecha_eval=explode(" ", $datos_evaluaciones_del_vendedor['FH_EVALUACION'][$i]);
					echo "
						<tr><td>
							<h6 class='text-left'><b title='Fecha de la evaluación'>Fecha:</b> " . $fecha_eval[0] . "<br><b>" . M_dibuja_estrellas($datos_evaluaciones_del_vendedor['EVALUACION_PUNTOS'][$i]) . "</b><br><b>Comprador:</b> " . $datos_evaluaciones_del_vendedor['COMPRADOR_NOMBRE'][$i] . " " . $datos_evaluaciones_del_vendedor['COMPRADOR_APELLIDO'][$i] . "<br><b>Estatus:</b> " . $datos_evaluaciones_del_vendedor['ESTATUS'][$i] . "<br><b>Comentario:</b> " . $datos_evaluaciones_del_vendedor['EVALUACION_COMENTARIO'][$i] . "</h6>
							<hr>
						</td></tr>
					";
				}
			}
			$i++;
		}
		echo "</tbody></table>";
	}else{
		echo "<br><h3 class='text-center text-danger my-2'><b>No tienes evaluaciones para mostrar en esta sección.</b></h3><br>";
	}
}
?>