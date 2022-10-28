<?php 
//ESTA SUB RUTINA IMPRIME LAS GRAFICAS PARA INDICADORES-GANANCIAS
if(isset($_POST['desde']) and isset($_POST['hasta'])){
	require_once ("M_todos.php");
	require_once ("paleta_de_colores.php");
	echo "
		<div class='row py-2'>
			<div class='col-12'>
				<h2 class='text-center'><b>Zona Externa</b></h2>
			</div>
			<div class='col-lg-4'>
				<canvas id='ext_visitas_x_pg'></canvas>
			</div>
			<div class='col-lg-4'>
				<canvas id='ext_visitas_x_dia'></canvas>
			</div>
			<div class='col-lg-4'>
				<canvas id='ext_cta_x_palabras'></canvas>
			</div>
		</div>
		<div class='row py-2'>
			<div class='col-12'>
				<h2 class='text-center'><b>Zona Interna</b></h2>
			</div>
			<div class='col-lg-4'>
				<canvas id='int_visitas_x_pg'></canvas>
			</div>
			<div class='col-lg-4'>
				<canvas id='int_visitas_x_dia'></canvas>
			</div>
			<div class='col-lg-4'>
				<canvas id='int_cta_x_palabras'></canvas>
			</div>
		</div>
	";
	$datos_graf_1=M_historial_de_busqueda_visitas_x_pg($conexion, $_POST['desde'], $_POST['hasta'], "EXTERNO");
	echo "
		<script>
			var ctx = document.getElementById('ext_visitas_x_pg').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: [
	";
	$i=0;
	$paginas=0;
	while(isset($datos_graf_1['PAGINA'][$i])){
		$paginas=$paginas+1;
		echo "'" . $datos_graf_1['PAGINA'][$i] . "'";
		if(isset($datos_graf_1['PAGINA'][$i+1])){
			echo ",";
		}
		$i++;
	}
	echo "
					],
					datasets: [{
						label: 'Visitas por Pág.',
						borderColor: 'rgb(60, 100, 148, 1)',
						backgroundColor: 'rgb(60, 100, 148, 0.6)',
						data: [
	";
	$i=0;
	$visitas=0;
	while(isset($datos_graf_1['VISITAS'][$i])){
		$visitas=$visitas + (float) $datos_graf_1['VISITAS'][$i];
		echo "'" . $datos_graf_1['VISITAS'][$i] . "'";
		if(isset($datos_graf_1['VISITAS'][$i+1])){
			echo ",";
		}
		$i++;
	}
	echo "
						]
					}]
				},
				options: {
					responsive: true,
					title: {
						display: true,
						text: 'Total: " . $visitas . " Vts en " . $paginas . " Pág'
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
								labelString: 'Pag'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Visitas'
							}
						}]
					}
				}							
			});			
		</script>
	";
	$datos_graf_2=M_historial_de_busqueda_visitas_x_dia($conexion, $_POST['desde'], $_POST['hasta'], "EXTERNO");
	echo "
		<script>
			var ctx = document.getElementById('ext_visitas_x_dia').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: [
	";
	$i=0;
	while(isset($datos_graf_2['DIA'][$i])){
		echo "'" . $datos_graf_2['ANO'][$i] . "-". $datos_graf_2['MES'][$i] . "-" . $datos_graf_2['DIA'][$i] . "'";
		if(isset($datos_graf_2['DIA'][$i+1])){
			echo ",";
		}
		$i++;
	}
	echo "
					],
					datasets: [{
						label: 'Visitas por día',
						borderColor: 'rgb(147, 0, 0, 1)',
						backgroundColor: 'rgb(147, 0, 0, 0.6)',
						data: [
	";
	$i=0;
	$visitas=0;
	while(isset($datos_graf_2['VISITAS'][$i])){
		$visitas=$visitas + (float) $datos_graf_2['VISITAS'][$i];
		echo "'" . $datos_graf_2['VISITAS'][$i] . "'";
		if(isset($datos_graf_2['VISITAS'][$i+1])){
			echo ",";
		}
		$i++;
	}
	echo "
						]
					}]
				},
				options: {
					responsive: true,
					title: {
						display: true,
						text: 'Total: " . $visitas . " Visitas'
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
								labelString: 'días'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Visitas'
							}
						}]
					}
				}							
			});			
		</script>
	";
	$datos_graf_3=M_historial_de_busqueda_cta_x_palabra($conexion, $_POST['desde'], $_POST['hasta'], "EXTERNO");
	echo "
		<script>
			var ctx = document.getElementById('ext_cta_x_palabras').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: [
	";
	$i=0;
	$textos=0;
	while(isset($datos_graf_3['TEXTO_BUSCADO'][$i])){
		$textos=$textos+1;
		echo "'" . $datos_graf_3['TEXTO_BUSCADO'][$i] . "'";
		if(isset($datos_graf_3['TEXTO_BUSCADO'][$i+1])){
			echo ",";
		}
		$i++;
	}
	echo "
					],
					datasets: [{
						label: 'Visitas por Palabra',
						borderColor: 'rgb(10, 10, 10, 1)',
						backgroundColor: 'rgb(10, 10, 10, 0.6)',
						data: [
	";
	$i=0;
	$visitas=0;
	while(isset($datos_graf_3['VISITAS'][$i])){
		$visitas=$visitas + (float) $datos_graf_3['VISITAS'][$i];
		echo "'" . $datos_graf_3['VISITAS'][$i] . "'";
		if(isset($datos_graf_3['VISITAS'][$i+1])){
			echo ",";
		}
		$i++;
	}
	echo "
						]
					}]
				},
				options: {
					responsive: true,
					title: {
						display: true,
						text: 'Total: " . $visitas . " Visitas en " . $textos . " Palaras'
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
								labelString: 'Palabras'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Visitas'
							}
						}]
					}
				}							
			});			
		</script>
	";
	$datos_graf_4=M_historial_de_busqueda_visitas_x_pg($conexion, $_POST['desde'], $_POST['hasta'], "INTERNO");
	echo "
		<script>
			var ctx = document.getElementById('int_visitas_x_pg').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: [
	";
	$i=0;
	$paginas=0;
	while(isset($datos_graf_4['PAGINA'][$i])){
		$paginas=$paginas+1;
		echo "'" . $datos_graf_4['PAGINA'][$i] . "'";
		if(isset($datos_graf_4['PAGINA'][$i+1])){
			echo ",";
		}
		$i++;
	}
	echo "
					],
					datasets: [{
						label: 'Visitas por Pág.',
						borderColor: 'rgb(60, 100, 148, 1)',
						backgroundColor: 'rgb(60, 100, 148, 0.6)',
						data: [
	";
	$i=0;
	$visitas=0;
	while(isset($datos_graf_4['VISITAS'][$i])){
		$visitas=$visitas + (float) $datos_graf_4['VISITAS'][$i];
		echo "'" . $datos_graf_4['VISITAS'][$i] . "'";
		if(isset($datos_graf_4['VISITAS'][$i+1])){
			echo ",";
		}
		$i++;
	}
	echo "
						]
					}]
				},
				options: {
					responsive: true,
					title: {
						display: true,
						text: 'Total: " . $visitas . " Vts en " . $paginas . " Pág'
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
								labelString: 'Pag'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Visitas'
							}
						}]
					}
				}							
			});			
		</script>
	";
	$datos_graf_5=M_historial_de_busqueda_visitas_x_dia($conexion, $_POST['desde'], $_POST['hasta'], "INTERNO");
	echo "
		<script>
			var ctx = document.getElementById('int_visitas_x_dia').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: [
	";
	$i=0;
	while(isset($datos_graf_5['DIA'][$i])){
		echo "'" . $datos_graf_5['ANO'][$i] . "-". $datos_graf_5['MES'][$i] . "-" . $datos_graf_5['DIA'][$i] . "'";
		if(isset($datos_graf_5['DIA'][$i+1])){
			echo ",";
		}
		$i++;
	}
	echo "
					],
					datasets: [{
						label: 'Visitas por día',
						borderColor: 'rgb(147, 0, 0, 1)',
						backgroundColor: 'rgb(147, 0, 0, 0.6)',
						data: [
	";
	$i=0;
	$visitas=0;
	while(isset($datos_graf_5['VISITAS'][$i])){
		$visitas=$visitas + (float) $datos_graf_5['VISITAS'][$i];
		echo "'" . $datos_graf_5['VISITAS'][$i] . "'";
		if(isset($datos_graf_5['VISITAS'][$i+1])){
			echo ",";
		}
		$i++;
	}
	echo "
						]
					}]
				},
				options: {
					responsive: true,
					title: {
						display: true,
						text: 'Total: " . $visitas . " Visitas'
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
								labelString: 'días'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Visitas'
							}
						}]
					}
				}							
			});			
		</script>
	";
	$datos_graf_6=M_historial_de_busqueda_cta_x_palabra($conexion, $_POST['desde'], $_POST['hasta'], "INTERNO");
	echo "
		<script>
			var ctx = document.getElementById('int_cta_x_palabras').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: [
	";
	$i=0;
	$textos=0;
	while(isset($datos_graf_6['TEXTO_BUSCADO'][$i])){
		$textos=$textos+1;
		echo "'" . $datos_graf_6['TEXTO_BUSCADO'][$i] . "'";
		if(isset($datos_graf_6['TEXTO_BUSCADO'][$i+1])){
			echo ",";
		}
		$i++;
	}
	echo "
					],
					datasets: [{
						label: 'Visitas por Palabra',
						borderColor: 'rgb(10, 10, 10, 1)',
						backgroundColor: 'rgb(10, 10, 10, 0.6)',
						data: [
	";
	$i=0;
	$visitas=0;
	while(isset($datos_graf_6['VISITAS'][$i])){
		$visitas=$visitas + (float)$datos_graf_6['VISITAS'][$i];
		echo "'" . $datos_graf_6['VISITAS'][$i] . "'";
		if(isset($datos_graf_6['VISITAS'][$i+1])){
			echo ",";
		}
		$i++;
	}
	echo "
						]
					}]
				},
				options: {
					responsive: true,
					title: {
						display: true,
						text: 'Total: " . $visitas . " Visitas en " . $textos . " Palaras'
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
								labelString: 'Palabras'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Visitas'
							}
						}]
					}
				}							
			});			
		</script>
	";
}
?>