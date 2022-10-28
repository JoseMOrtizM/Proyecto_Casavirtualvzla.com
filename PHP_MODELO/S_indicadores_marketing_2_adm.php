<?php 
//ESTA SUB RUTINA IMPRIME LAS GRAFICAS PARA INDICADORES-GANANCIAS
if(isset($_POST['vendedor']) and isset($_POST['ano']) and isset($_POST['mes']) and isset($_POST['edad']) and isset($_POST['cliente']) and isset($_POST['producto'])){
	require_once ("M_todos.php");
	require_once ("paleta_de_colores.php");
	echo "
		<div class='row py-2 px-1'>
			<div class='col-lg-5 mx-auto'>
				<canvas id='clicks_prod_vistos_mes_a_mes'></canvas>
			</div>
		</div>
	";
	if(isset($_POST['user'])){
		echo "
			<div class='row py-2 px-1'>
				<div class='col-7 col-md-4 col-lg-3 mx-auto'>
					<canvas id='prod_vistos_torta_edades'></canvas>
				</div>
				<div class='col-7 col-md-4 col-lg-3 mx-auto'>
					<canvas id='prod_vistos_torta_clientes'></canvas>
				</div>
				<div class='col-7 col-md-4 col-lg-3 mx-auto'>
					<canvas id='prod_vistos_torta_productos'></canvas>
				</div>
			</div>
		";
	}else{
		echo "
			<div class='row py-2'>
				<div class='col-7 col-md-6 col-lg-3 mx-auto'>
					<canvas id='prod_vistos_torta_vendedores'></canvas>
				</div>
				<div class='col-7 col-md-6 col-lg-3 mx-auto'>
					<canvas id='prod_vistos_torta_edades'></canvas>
				</div>
				<div class='col-7 col-md-6 col-lg-3 mx-auto'>
					<canvas id='prod_vistos_torta_clientes'></canvas>
				</div>
				<div class='col-7 col-md-6 col-lg-3 mx-auto'>
					<canvas id='prod_vistos_torta_productos'></canvas>
				</div>
			</div>
		";
	}
	$datos_graf_1=M_indicadores_R_graf_4($conexion, $_POST['vendedor'], $_POST['ano'], $_POST['mes'], $_POST['edad'], $_POST['cliente'], $_POST['producto']);
	echo "
		<script>
			var ctx = document.getElementById('clicks_prod_vistos_mes_a_mes').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
					datasets: [{
						label: 'Vistas',
						borderColor: 'rgb(60, 100, 148, 1)',
						backgroundColor: 'rgb(60, 100, 148, 0.8)',
						data: [
	";
	$i=1;
	while($i<13){
		echo "'" . $datos_graf_1['VISTAS_MES_' . $i][0] . "'";
		if($i<12){
			echo ",";
		}
		$i=$i+1;
	}
	echo "
						]
					}]
				},
				options: {
					responsive: true,
					title: {
						display: true,
						text: 'Total: " . $datos_graf_1['TOTAL_VISTAS'][0] . " Vistas'
					},
					tooltips: {
						mode: 'index',
						intersect: false,
					},
					hover: {
						mode: 'nearest',
						intersect: true
					},
					scales: {
						xAxes: [{
							display: false,
							scaleLabel: {
								display: true,
								labelString: 'Mes'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Vistas'
							}
						}]
					}
				}							
			});			
		</script>
	";
	$datos_torta_3=M_indicadores_R_graf_4_torta_edades($conexion, $_POST['vendedor'], $_POST['ano'], $_POST['mes'], $_POST['edad'], $_POST['cliente'], $_POST['producto']);	
	echo "
		<script>
			var ctx = document.getElementById('prod_vistos_torta_edades').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'pie',
				data: {
					labels: [
	";
	echo "'Menos de 20', ";
	echo "'21 a 30', ";
	echo "'31 a 40', ";
	echo "'41 a 50', ";
	echo "'Más de 50'";
	echo "
					],
					datasets: [{
						data: [
	";
	$i=0;
	if($datos_torta_3['MENOS_DE_20'][0]>0){$i++;}
	if($datos_torta_3['MENOS_DE_30'][0]>0){$i++;}
	if($datos_torta_3['MENOS_DE_40'][0]>0){$i++;}
	if($datos_torta_3['MENOS_DE_50'][0]>0){$i++;}
	if($datos_torta_3['MAS_DE_50'][0]>0){$i++;}
	echo "'" . $datos_torta_3['MENOS_DE_20'][0] . "', ";
	echo "'" . $datos_torta_3['MENOS_DE_30'][0] . "', ";
	echo "'" . $datos_torta_3['MENOS_DE_40'][0] . "', ";
	echo "'" . $datos_torta_3['MENOS_DE_50'][0] . "', ";
	echo "'" . $datos_torta_3['MAS_DE_50'][0] . "'";
	echo "
						],
						backgroundColor: [
	";
	echo "'" . $paleta_de_colores[4] . "', ";
	echo "'" . $paleta_de_colores[5] . "', ";
	echo "'" . $paleta_de_colores[6] . "', ";
	echo "'" . $paleta_de_colores[7] . "', ";
	echo "'" . $paleta_de_colores[8] . "'";
	echo "
						],
					}]					
				},
				options: {
					legend: false,
					title: {
							display: true,
							text: '" . $datos_graf_1['TOTAL_VISTAS'][0] . " Vist / " . $i . " Edades',
							fontSize: 14,
							fontColor: '#333'
					}
				}
			});	
		</script>
	";
	$datos_torta_4=M_indicadores_R_graf_4_torta_clientes($conexion, $_POST['vendedor'], $_POST['ano'], $_POST['mes'], $_POST['edad'], $_POST['cliente'], $_POST['producto']);	
	echo "
		<script>
			var ctx = document.getElementById('prod_vistos_torta_clientes').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'pie',
				data: {
					labels: [
	";
	$i=0;
	while(isset($datos_torta_4['NOMBRE'][$i])){
		echo "'" . $datos_torta_4['NOMBRE'][$i] . "'";
		if(isset($datos_torta_4['NOMBRE'][$i+1])){
			echo ", ";
		}
		$i=$i+1;
	}
	echo "
					],
					datasets: [{
						data: [
	";
	$i=0;
	while(isset($datos_torta_4['TOTAL_VISTAS'][$i])){
		echo "'" . $datos_torta_4['TOTAL_VISTAS'][$i] . "'";
		if(isset($datos_torta_4['TOTAL_VISTAS'][$i+1])){
			echo ", ";
		}
		$i=$i+1;
	}
	echo "
						],
						backgroundColor: [
	";
	$i=0;
	while(isset($datos_torta_4['TOTAL_VISTAS'][$i])){
		echo "'" . $paleta_de_colores[$i+6] . "'";
		if(isset($datos_torta_4['TOTAL_VISTAS'][$i+1])){
			echo ", ";
		}
		$i=$i+1;
	}
	echo "
						],
					}]					
				},
				options: {
					legend: false,
					title: {
							display: true,
							text: '" . $datos_graf_1['TOTAL_VISTAS'][0] . " Vist / ";
	if($datos_graf_1['TOTAL_VISTAS'][0]==0){
		echo "0";
	}else{
		echo $i;
	}
	echo " Clientes',
							fontSize: 14,
							fontColor: '#333'
					}
				}
			});	
		</script>
	";
	$datos_torta_5=M_indicadores_R_graf_4_torta_productos($conexion, $_POST['vendedor'], $_POST['ano'], $_POST['mes'], $_POST['edad'], $_POST['cliente'], $_POST['producto']);	
	echo "
		<script>
			var ctx = document.getElementById('prod_vistos_torta_productos').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'pie',
				data: {
					labels: [
	";
	$i=0;
	while(isset($datos_torta_5['NOMBRE_PRODUCTO'][$i])){
		echo "'" . $datos_torta_5['NOMBRE_PRODUCTO'][$i] . "'";
		if(isset($datos_torta_5['NOMBRE_PRODUCTO'][$i+1])){
			echo ", ";
		}
		$i=$i+1;
	}
	echo "
					],
					datasets: [{
						data: [
	";
	$i=0;
	while(isset($datos_torta_5['TOTAL_VISTAS'][$i])){
		echo "'" . $datos_torta_5['TOTAL_VISTAS'][$i] . "'";
		if(isset($datos_torta_5['TOTAL_VISTAS'][$i+1])){
			echo ", ";
		}
		$i=$i+1;
	}
	echo "
						],
						backgroundColor: [
	";
	$i=0;
	while(isset($datos_torta_5['TOTAL_VISTAS'][$i])){
		echo "'" . $paleta_de_colores[$i+8] . "'";
		if(isset($datos_torta_5['TOTAL_VISTAS'][$i+1])){
			echo ", ";
		}
		$i=$i+1;
	}
	echo "
						],
					}]					
				},
				options: {
					legend: false,
					title: {
							display: true,
							text: '" . $datos_graf_1['TOTAL_VISTAS'][0] . " Vist / ";
	if($datos_graf_1['TOTAL_VISTAS'][0]==0){
		echo "0";
	}else{
		echo $i;
	}
	echo " Productos',
							fontSize: 14,
							fontColor: '#333'
					}
				}
			});	
		</script>
	";
}
	$datos_torta_6=M_indicadores_R_graf_4_torta_vendedores($conexion, $_POST['vendedor'], $_POST['ano'], $_POST['mes'], $_POST['edad'], $_POST['cliente'], $_POST['producto']);	
	echo "
		<script>
			var ctx = document.getElementById('prod_vistos_torta_vendedores').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'pie',
				data: {
					labels: [
	";
	$i=0;
	while(isset($datos_torta_6['NOMBRE'][$i])){
		echo "'" . $datos_torta_6['NOMBRE'][$i] . "'";
		if(isset($datos_torta_6['NOMBRE'][$i+1])){
			echo ", ";
		}
		$i=$i+1;
	}
	echo "
					],
					datasets: [{
						data: [
	";
	$i=0;
	while(isset($datos_torta_6['TOTAL_VISTAS'][$i])){
		echo "'" . $datos_torta_6['TOTAL_VISTAS'][$i] . "'";
		if(isset($datos_torta_6['TOTAL_VISTAS'][$i+1])){
			echo ", ";
		}
		$i=$i+1;
	}
	echo "
						],
						backgroundColor: [
	";
	$i=0;
	while(isset($datos_torta_6['TOTAL_VISTAS'][$i])){
		echo "'" . $paleta_de_colores[$i] . "'";
		if(isset($datos_torta_6['TOTAL_VISTAS'][$i+1])){
			echo ", ";
		}
		$i=$i+1;
	}
	echo "
						],
					}]					
				},
				options: {
					legend: false,
					title: {
							display: true,
							text: '" . $datos_graf_1['TOTAL_VISTAS'][0] . " Vist / ";
	if($datos_graf_1['TOTAL_VISTAS'][0]==0){
		echo "0";
	}else{
		echo $i;
	}
	echo " Vendedores',
							fontSize: 14,
							fontColor: '#333'
					}
				}
			});	
		</script>
	";
?>