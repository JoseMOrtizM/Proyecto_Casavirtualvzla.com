<?php 
//ESTA SUB RUTINA IMPRIME LAS GRAFICAS PARA INDICADORES-GANANCIAS
if(isset($_POST['vendedor_cedula_rif']) and isset($_POST['ano'])){
	require_once ("M_todos.php");
	require_once ("paleta_de_colores.php");
	$paridad_ultima=M_paridad_cambiaria_R_ultima($conexion);
	$invertido=M_indicadores_R_graf_3_invertido($conexion, $_POST['vendedor_cedula_rif'], $_POST['ano']);
	$retirado=M_indicadores_R_graf_3_retirado($conexion, $_POST['vendedor_cedula_rif'], $_POST['ano']);
	$ganado=M_indicadores_R_graf_3_ganado($conexion, $_POST['vendedor_cedula_rif'], $_POST['ano']);
	$gastado=M_indicadores_R_graf_3_gastado($conexion, $_POST['vendedor_cedula_rif'], $_POST['ano']);
	$descontado=M_indicadores_R_graf_3_rechazado_descuento($conexion, $_POST['vendedor_cedula_rif'], $_POST['ano']);
	$pemones_por_retirar=$invertido['PEMONES'][0]-$retirado['PEMONES'][0]+$ganado['PEMONES'][0]-$gastado['PEMONES'][0]-$descontado['PEMONES'][0];
	$bolivares_por_retirar= round($pemones_por_retirar*$paridad_ultima['TIPO_POR_MICOIN_VENTA'][0],2);
	echo "
		<div class='row py-2'>
			<div class='col-12 col-sm-12 col-md-10 col-lg-10 col-xl-7 mx-auto'>
				<h3 class='text-center bg-dark text-warning py-1 m-0'>Total Año (<b class='text-light'>" . $_POST['ano'] . "</b>)</h3>
				<div class='container-fluid'>
					<div class='row text-center'>
						<div class='col-6 bg-success text-dark align-middle border border-dark' title='Total de (Bs., Pm y Bs/Pm) Comprados en el Año'><b>Compra Pm<br>(Inversión)</b></div>
						<div class='col-6 bg-warning text-dark align-middle border border-dark' title='Total de (Bs., Pm y Bs/Pm) Vendidos en el Año'><b>Venta Pm<br>(Retiros)</b></div>

						<div class='col-6 bg-light text-dark text-right border border-dark small'>" . number_format($invertido['BOLIVARES'][0], 2,',','.') . "<b>Bs</b><br>" . number_format($invertido['PEMONES'][0], 2,',','.') . "<b>Pm</b><br>";
						if($invertido['PEMONES'][0]==0){
							echo number_format(0, 2,',','.');
						}else{
							echo number_format($invertido['BOLIVARES'][0]/$invertido['PEMONES'][0], 2,',','.');
						}
	echo "<b>Bs/Pm</b></div>";
	echo "
						<div class='col-6 bg-light text-dark text-right border border-dark small'>" . number_format($retirado['BOLIVARES'][0], 2,',','.') . "<b>Bs</b><br>" . number_format($retirado['PEMONES'][0], 2,',','.') . "<b>Pm</b><br>";
	if($retirado['PEMONES'][0]==0){
		echo number_format(0, 2,',','.');
	}else{
		echo number_format($retirado['BOLIVARES'][0]/$retirado['PEMONES'][0], 2,',','.');
	}
	echo "<b>Bs/Pm</b></div>";
	
	echo "
						<div class='col-6 bg-danger text-dark align-middle border border-dark' title='Total de Pemones Gastados en el Año dentro de la Casa Virtual'><b>Pm Gastado<br>(Compra de Productos)</b></div>
						<div class='col-6 bg-secondary text-dark align-middle border border-dark' title='Total de Pemones Descontados por compras de Productos Rechazadas por usted'><b>Pm Descontados<br>(Compras de Productos Rechazadas)</b></div>";
	
	echo "
						<div class='col-6 bg-light text-dark text-right border border-dark small'>" . number_format($gastado['PEMONES'][0], 2,',','.') . "<b>Pm</b></div>";
	echo "
						<div class='col-6 bg-light text-dark text-right border border-dark small'>" . number_format($descontado['PEMONES'][0], 2,',','.') . "<b>Pm</b></div>";
						
	echo "					
						<div class='col-6 bg-primary text-dark align-middle border border-dark' title='Total de Pemones Ganados en el Año por venta de Productos'><b>Pm Ganado<br>(Venta de Productos)</b></div>
						<div class='col-6 bg-light text-dark align-middle border border-dark' title='Total de (Bs., Pm y Bs/Pm) Comprados en el Año'><b>Pm por Retirar</b></div>";
	echo "
						<div class='col-6 bg-light text-dark text-right border border-dark small'><br>" . number_format($ganado['PEMONES'][0], 2,',','.') . "<b>Pm</b></div>";
	echo "
						<div class='col-6 bg-light text-dark text-right border border-dark small'>" . number_format($bolivares_por_retirar, 2,',','.') . "<b>Bs</b><br>" . number_format($pemones_por_retirar, 2,',','.') . "<b>Pm</b><br>" . number_format($paridad_ultima['TIPO_POR_MICOIN_VENTA'][0], 2,',','.') . "<b>Bs/Pm</b></div>";
	echo "					
					</div>";
	$verf_ahorro=$bolivares_por_retirar-($invertido['BOLIVARES'][0]-$retirado['BOLIVARES'][0]);
	if($verf_ahorro>0){
		echo "<div class='row text-center'><div class='col-12 h5 text-center bg-light text-dark'><b>¡¡¡FELICIDADES!!!</b> Has Ganado: " . number_format($verf_ahorro, 2,',','.'). "<b>Bs</b></div></div>";
	}
	echo "
				</div>
			</div>
		</div>
	";
	
}
?>