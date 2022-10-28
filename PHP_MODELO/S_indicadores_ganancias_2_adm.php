<?php 
//ESTA SUB RUTINA IMPRIME LAS GRAFICAS PARA INDICADORES-GANANCIAS
if(isset($_POST['comprador']) and isset($_POST['ano']) and isset($_POST['mes']) and isset($_POST['edad']) and isset($_POST['vendedor']) and isset($_POST['producto'])){
	require_once ("M_todos.php");
	require_once ("paleta_de_colores.php");
	echo "
		<div class='row py-2 px-1'>
			<div class='col-lg-4'>
				<canvas id='ganancias_pemon_mes_a_mes2'></canvas>
			</div>
			<div class='col-lg-4'>
				<canvas id='ventas_mes_a_mes2'></canvas>
			</div>
			<div class='col-lg-4'>
				<canvas id='productos_vendidos_mes_a_mes2'></canvas>
			</div>
		</div>
	";
	if(isset($_POST['user'])){
		echo "
			<div class='row py-2 px-1'>
				<div class='col-7 col-md-4 col-lg-3 mx-auto'>
					<canvas id='ganancias_torta_edades2'></canvas>
				</div>
				<div class='col-7 col-md-4 col-lg-3 mx-auto'>
					<canvas id='ganancias_torta_compradores2'></canvas>
				</div>
				<div class='col-7 col-md-4 col-lg-3 mx-auto'>
					<canvas id='ganancias_torta_productos2'></canvas>
				</div>
			</div>
		";
	}else{
		echo "
			<div class='row py-2'>
				<div class='col-7 col-md-6 col-lg-3 mx-auto'>
					<canvas id='ganancias_torta_vendedores2'></canvas>
				</div>
				<div class='col-7 col-md-6 col-lg-3 mx-auto'>
					<canvas id='ganancias_torta_edades2'></canvas>
				</div>
				<div class='col-7 col-md-6 col-lg-3 mx-auto'>
					<canvas id='ganancias_torta_compradores2'></canvas>
				</div>
				<div class='col-7 col-md-6 col-lg-3 mx-auto'>
					<canvas id='ganancias_torta_productos2'></canvas>
				</div>
			</div>
		";
	}
	$datos_graf_1=M_indicadores_R_graf_2($conexion, $_POST['vendedor'], $_POST['ano'], $_POST['mes'], $_POST['edad'], $_POST['comprador'], $_POST['producto']);
	echo "
		<script>
			var ctx = document.getElementById('ganancias_pemon_mes_a_mes2').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
					datasets: [{
						label: 'Ganancia (Pm)',
						borderColor: 'rgb(60, 100, 148, 1)',
						backgroundColor: 'rgb(60, 100, 148, 0.8)',
						data: [
	";
	$i=1;
	while($i<13){
		echo "'" . $datos_graf_1['PEMONES_MES_' . $i][0] . "'";
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
						text: 'Total: " . number_format($datos_graf_1['TOTAL_PEMONES'][0], 2,',','.') . " Pemones'
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
								labelString: 'Pemones'
							}
						}]
					}
				}							
			});			
		</script>
	";
	echo "
		<script>
			var ctx = document.getElementById('ventas_mes_a_mes2').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
					datasets: [{
						label: 'Ventas',
						borderColor: 'rgb(150, 61, 59, 1)',
						backgroundColor: 'rgb(150, 61, 59, 0.8)',
						data: [
	";
	$i=1;
	while($i<13){
		echo "'" . $datos_graf_1['VENTAS_MES_' . $i][0] . "'";
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
						text: 'Total: " . $datos_graf_1['TOTAL_VENTAS'][0] . " Ventas'
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
								labelString: 'Ventas'
							}
						}]
					}
				}							
			});			
		</script>
	";
	echo "
		<script>
			var ctx = document.getElementById('productos_vendidos_mes_a_mes2').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
					datasets: [{
						label: 'Productos',
						borderColor: 'rgb(121, 146, 68, 1)',
						backgroundColor: 'rgb(121, 146, 68, 0.8)',
						data: [
	";
	$i=1;
	while($i<13){
		echo "'" . $datos_graf_1['PRODUCTOS_MES_' . $i][0] . "'";
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
						text: 'Total: " . $datos_graf_1['TOTAL_PRODUCTOS'][0] . " Productos'
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
								labelString: 'Productos'
							}
						}]
					}
				}							
			});	
		</script>
	";
	$datos_torta_3=M_indicadores_R_graf_2_torta_edades($conexion, $_POST['vendedor'], $_POST['ano'], $_POST['mes'], $_POST['edad'], $_POST['comprador'], $_POST['producto']);	
	echo "
		<script>
			var ctx = document.getElementById('ganancias_torta_edades2').getContext('2d');
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
	if($datos_torta_3['MENOS_DE_20'][0]<>''){$i++;}
	if($datos_torta_3['MENOS_DE_30'][0]<>''){$i++;}
	if($datos_torta_3['MENOS_DE_40'][0]<>''){$i++;}
	if($datos_torta_3['MENOS_DE_50'][0]<>''){$i++;}
	if($datos_torta_3['MAS_DE_50'][0]<>''){$i++;}
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
							text: '" . number_format($datos_graf_1['TOTAL_PEMONES'][0], 2,',','.') . " Pm / " . $i . " Edades',
							fontSize: 14,
							fontColor: '#333'
					}
				}
			});	
		</script>
	";
	$datos_torta_4=M_indicadores_R_graf_2_torta_vendedores($conexion, $_POST['vendedor'], $_POST['ano'], $_POST['mes'], $_POST['edad'], $_POST['comprador'], $_POST['producto']);	
	echo "
		<script>
			var ctx = document.getElementById('ganancias_torta_compradores2').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'pie',
				data: {
					labels: [
	";
	$i=0;
	while(isset($datos_torta_4['VENDEDOR_NOMBRE_APELLIDO'][$i])){
		echo "'" . $datos_torta_4['VENDEDOR_NOMBRE_APELLIDO'][$i] . "'";
		if(isset($datos_torta_4['VENDEDOR_NOMBRE_APELLIDO'][$i+1])){
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
	while(isset($datos_torta_4['TOTAL_PEMON'][$i])){
		echo "'" . $datos_torta_4['TOTAL_PEMON'][$i] . "'";
		if(isset($datos_torta_4['TOTAL_PEMON'][$i+1])){
			echo ", ";
		}
		$i=$i+1;
	}
	echo "
						],
						backgroundColor: [
	";
	$i=0;
	while(isset($datos_torta_4['TOTAL_PEMON'][$i])){
		echo "'" . $paleta_de_colores[$i+6] . "'";
		if(isset($datos_torta_4['TOTAL_PEMON'][$i+1])){
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
							text: '" . number_format($datos_graf_1['TOTAL_PEMONES'][0], 2,',','.') . " Pm / ";
	if($datos_graf_1['TOTAL_PEMONES'][0]==0){
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
	$datos_torta_5=M_indicadores_R_graf_2_torta_productos($conexion, $_POST['vendedor'], $_POST['ano'], $_POST['mes'], $_POST['edad'], $_POST['comprador'], $_POST['producto']);	
	echo "
		<script>
			var ctx = document.getElementById('ganancias_torta_productos2').getContext('2d');
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
	while(isset($datos_torta_5['TOTAL_PEMON'][$i])){
		echo "'" . $datos_torta_5['TOTAL_PEMON'][$i] . "'";
		if(isset($datos_torta_5['TOTAL_PEMON'][$i+1])){
			echo ", ";
		}
		$i=$i+1;
	}
	echo "
						],
						backgroundColor: [
	";
	$i=0;
	while(isset($datos_torta_5['TOTAL_PEMON'][$i])){
		echo "'" . $paleta_de_colores[$i+8] . "'";
		if(isset($datos_torta_5['TOTAL_PEMON'][$i+1])){
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
							text: '" . number_format($datos_graf_1['TOTAL_PEMONES'][0], 2,',','.') . " Pm / ";
	if($datos_graf_1['TOTAL_PEMONES'][0]==0){
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
	$datos_torta_6=M_indicadores_R_graf_2_torta_compradores($conexion, $_POST['vendedor'], $_POST['ano'], $_POST['mes'], $_POST['edad'], $_POST['comprador'], $_POST['producto']);	
	echo "
		<script>
			var ctx = document.getElementById('ganancias_torta_vendedores2').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'pie',
				data: {
					labels: [
	";
	$i=0;
	while(isset($datos_torta_6['COMPRADOR_NOMBRE_APELLIDO'][$i])){
		echo "'" . $datos_torta_6['COMPRADOR_NOMBRE_APELLIDO'][$i] . "'";
		if(isset($datos_torta_6['COMPRADOR_NOMBRE_APELLIDO'][$i+1])){
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
	while(isset($datos_torta_6['TOTAL_PEMON'][$i])){
		echo "'" . $datos_torta_6['TOTAL_PEMON'][$i] . "'";
		if(isset($datos_torta_6['TOTAL_PEMON'][$i+1])){
			echo ", ";
		}
		$i=$i+1;
	}
	echo "
						],
						backgroundColor: [
	";
	$i=0;
	while(isset($datos_torta_6['TOTAL_PEMON'][$i])){
		echo "'" . $paleta_de_colores[$i+8] . "'";
		if(isset($datos_torta_6['TOTAL_PEMON'][$i+1])){
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
							text: '" . number_format($datos_graf_1['TOTAL_PEMONES'][0], 2,',','.') . " Pm / ";
	if($datos_graf_1['TOTAL_PEMONES'][0]==0){
		echo "0";
	}else{
		echo $i;
	}
	echo " Compradores',
							fontSize: 14,
							fontColor: '#333'
					}
				}
			});	
		</script>
	";	
}
?>