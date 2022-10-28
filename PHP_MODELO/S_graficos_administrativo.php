<?php 
//ESTA SUB RUTINA IMPRIME LAS GRAFICAS PARA INDICADORES-GANANCIAS
if(isset($_POST['dias_form']) and isset($_POST['fecha_filtro'])){
	require_once ("M_todos.php");
?>
	<div class="bg-dark">
		<div class="container">
			<div class="row">
				<div class="col-12 px-0">
					<h4 class="bg-dark text-warning text-center py-1 m-0"><b>Tasas de Cambio</b></h4>
				</div>
			</div>
		</div>
	</div>
	<div class="bg-dark px-2 pb-2">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-4 bg-light rounded border border-dark text-center p-2 mx-auto">
					<canvas id="graf_tasa_cambio_compra_venta"></canvas>
					<h6 class="small">Ser similar a <b class='text-success'>Bs/$</b></h6>
				</div>
				<div class="col-12 col-md-4 bg-light rounded border border-dark text-center p-2 mx-auto">
					<canvas id="graf_tasa_cambio_bs_dollar"></canvas>
					<h6 class="small">Ser similar a <b class='text-primary'>Bs/Pm</b></h6>
				</div>
				<div class="col-12 col-md-4 bg-light rounded border border-dark text-center p-2 mx-auto">
					<canvas id="graf_tasa_cambio_pm_dollar"></canvas>
					<h6 class="small">Entre <b class='text-dark'>4,0</b> y <b class='text-danger'>4,6</b></h6>
				</div>
			</div>
		</div>
	</div>
	<div class="bg-dark">
		<div class="container">
			<div class="row">
				<div class="col-12 px-0">
					<h4 class="bg-dark text-warning text-center py-1 m-0"><b>Respaldo Acumulado</b></h4>
				</div>
			</div>
		</div>
	</div>
	<div class="bg-dark px-2 pb-2">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-4 bg-light rounded border border-dark text-center mx-auto">
					<canvas id="graf_pemon_circ_acum"></canvas>
					<h6 class="small">= <b class='text-dark'>Saldos</b> + <e class='text-primary'>Resp. Inicial</e></h6>
				</div>
				<div class="col-12 col-md-4 bg-light rounded border border-dark text-center mx-auto">
					<canvas id="graf_resp_acum_bs"></canvas>
					<h6 class="small">Menor que <b class='text-dark'>1.0000.000</b></h6>
				</div>
				<div class="col-12 col-md-4 bg-light rounded border border-dark text-center mx-auto">
					<canvas id="graf_resp_acum_dollares_y_dollares_equiv"></canvas>
					<h6 class="small"><b class='text-danger'>$ Puros</b> = <b class='text-success'>$Eq</b></h6>
				</div>
			</div>
		</div>
	</div>
	<div class="bg-dark">
		<div class="container">
			<div class="row">
				<div class="col-12 px-0">
					<h4 class="bg-dark text-warning text-center py-1 m-0"><b>Ingresos Acumulados</b></h4>
				</div>
			</div>
		</div>
	</div>
	<div class="bg-dark px-2 pb-2">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-4 bg-light rounded border border-dark text-center p-2 mx-auto">
					<canvas id="graf_ingr_acum_bs"></canvas>
				</div>
				<div class="col-12 col-md-4 bg-light rounded border border-dark text-center p-2 mx-auto">
					<canvas id="graf_ingr_acum_dollares"></canvas>
				</div>
				<div class="col-12 col-md-4 bg-light rounded border border-dark text-center p-2 mx-auto">
					<canvas id="graf_ingr_acum_dollares_equiv"></canvas>
				</div>
			</div>
		</div>
	</div>
	<?php
		//UBICANDO LOS DATOS PARA LA GRAFICA
		// primera fecha de registros
		$datos_primer_id=M_balance_administrativo_primero_id($conexion);
		$datos_inicio_sistema=M_balance_administrativo_lcv_R($conexion, 'ID_ADM', $datos_primer_id['ID_ADM'][0], '', '', '', '');
		$fecha_inicio_sistema=explode(" ",$datos_inicio_sistema['FH_REGISTRO'][0]);
		//1 ESTABLECIENDO LOS DÍAS DEL EJE X
		if(isset($_POST['dias_form'])){
			$max=$_POST['dias_form']-1;
		}else{
			$max=89;
		}
		$dias[$max]=$_POST['fecha_filtro'];
		$i=$max-1;
		while($i>=0){
			$dias[$i]=date("Y-m-d",strtotime($dias[$i+1]."- 1 days"));
			$i--;
		}
		//2 ESTABLECIENDO LOS DATOS DE TASA PARA ESOS DÍAS
		$ultimo_balance=M_balance_administrativo_lcv_R_ultimo($conexion);
		$tasa_compra[$max]=$ultimo_balance['TC_BS_PM_C'][0];
		$tasa_venta[$max]=$ultimo_balance['TC_BS_PM_V'][0];
		$tasa_bs_dollar[$max]=$ultimo_balance['TC_BS_DOLLAR'][0];
		$tasa_pm_dollar[$max]=$ultimo_balance['TC_PM_DOLLAR'][0];
		$ra_res_mon_circ[$max]=$ultimo_balance['RA_RES_MON_CIRC'][0];
		$ra_res_mon_dollares_eqv[$max]=$ultimo_balance['RA_RES_MON_DOLLARES_EQV'][0];
		$ra_res_mon_bs_puros[$max]=$ultimo_balance['RA_RES_MON_BS_PUROS'][0];
		$ra_res_mon_dollares_puros[$max]=$ultimo_balance['RA_RES_MON_DOLLARES_PUROS'][0];
		$ra_ie_bs_puros[$max]=$ultimo_balance['RA_IE_BS_PUROS'][0];
		$ra_ie_dollares_puros[$max]=$ultimo_balance['RA_IE_DOLLARES_PUROS'][0];
		$ra_ie_dollares_eqv[$max]=$ultimo_balance['RA_IE_DOLLARES_EQV'][0];
		$i=$max-1;
		while($i>=0){
			$balance_i=M_balance_administrativo_lcv_R_ultimo_x_fecha($conexion, $dias[$i]);
			$tasa_compra[$i]=round($balance_i['TC_BS_PM_C'][0],2);
			$tasa_venta[$i]=round($balance_i['TC_BS_PM_V'][0],2);
			$tasa_bs_dollar[$i]=round($balance_i['TC_BS_DOLLAR'][0],2);
			$tasa_pm_dollar[$i]=round($balance_i['TC_PM_DOLLAR'][0],2);
			$ra_res_mon_circ[$i]=round($balance_i['RA_RES_MON_CIRC'][0],2);
			$ra_res_mon_dollares_eqv[$i]= round($balance_i['RA_RES_MON_DOLLARES_EQV'][0],2);
			$ra_res_mon_bs_puros[$i]= round($balance_i['RA_RES_MON_BS_PUROS'][0],2);
			$ra_res_mon_dollares_puros[$i]= round($balance_i['RA_RES_MON_DOLLARES_PUROS'][0],2);
			$ra_ie_bs_puros[$i]=round($balance_i['RA_IE_BS_PUROS'][0],2);
			$ra_ie_dollares_puros[$i]=round($balance_i['RA_IE_DOLLARES_PUROS'][0],2);
			$ra_ie_dollares_eqv[$i]=round($balance_i['RA_IE_DOLLARES_EQV'][0],2);
			if($tasa_compra[$i]==''){
				if(strtotime($dias[$i])<strtotime($fecha_inicio_sistema[0])){
					$tasa_compra[$i]=0;
				}else{
					$tasa_compra[$i]=$tasa_compra[$i+1];
				}
			}
			if($tasa_venta[$i]==''){
				if(strtotime($dias[$i])<strtotime($fecha_inicio_sistema[0])){
					$tasa_venta[$i]=0;
				}else{
					$tasa_venta[$i]=$tasa_venta[$i+1];
				}
			}
			if($tasa_bs_dollar[$i]==''){
				if(strtotime($dias[$i])<strtotime($fecha_inicio_sistema[0])){
					$tasa_bs_dollar[$i]=0;
				}else{
					$tasa_bs_dollar[$i]=$tasa_bs_dollar[$i+1];
				}
			}
			if($tasa_pm_dollar[$i]==''){
				if(strtotime($dias[$i])<strtotime($fecha_inicio_sistema[0])){
					$tasa_pm_dollar[$i]=0;
				}else{
					$tasa_pm_dollar[$i]=$tasa_pm_dollar[$i+1];
				}
			}
			if($ra_res_mon_circ[$i]==''){
				if(strtotime($dias[$i])<strtotime($fecha_inicio_sistema[0])){
					$ra_res_mon_circ[$i]=0;
				}else{
					$ra_res_mon_circ[$i]=$ra_res_mon_circ[$i+1];
				}
			}
			if($ra_res_mon_dollares_eqv[$i]==''){
				if(strtotime($dias[$i])<strtotime($fecha_inicio_sistema[0])){
					$ra_res_mon_dollares_eqv[$i]=0;
				}else{
					$ra_res_mon_dollares_eqv[$i]=$ra_res_mon_dollares_eqv[$i+1];
				}
			}
			if($ra_res_mon_bs_puros[$i]==''){
				if(strtotime($dias[$i])<strtotime($fecha_inicio_sistema[0])){
					$ra_res_mon_bs_puros[$i]=0;
				}else{
					$ra_res_mon_bs_puros[$i]=$ra_res_mon_bs_puros[$i+1];
				}
			}
			if($ra_res_mon_dollares_puros[$i]==''){
				if(strtotime($dias[$i])<strtotime($fecha_inicio_sistema[0])){
					$ra_res_mon_dollares_puros[$i]=0;
				}else{
					$ra_res_mon_dollares_puros[$i]=$ra_res_mon_dollares_puros[$i+1];
				}
			}
			if($ra_ie_bs_puros[$i]==''){
				if(strtotime($dias[$i])<strtotime($fecha_inicio_sistema[0])){
					$ra_ie_bs_puros[$i]=0;
				}else{
					$ra_ie_bs_puros[$i]=$ra_ie_bs_puros[$i+1];
				}
			}
			if($ra_ie_dollares_puros[$i]==''){
				if(strtotime($dias[$i])<strtotime($fecha_inicio_sistema[0])){
					$ra_ie_dollares_puros[$i]=0;
				}else{
					$ra_ie_dollares_puros[$i]=$ra_ie_dollares_puros[$i+1];
				}
			}
			if($ra_ie_dollares_eqv[$i]==''){
				if(strtotime($dias[$i])<strtotime($fecha_inicio_sistema[0])){
					$ra_ie_dollares_eqv[$i]=0;
				}else{
					$ra_ie_dollares_eqv[$i]=$ra_ie_dollares_eqv[$i+1];
				}
			}
			$i--;
		}
	?>
	<!-- INICIO DE LOS GRÁFICOS QUE TIENEN QUE VER CON LA TABLA MC_BALANCE_ADMINISTRATIVO-->
	<script type="text/javascript">
		var ctx_1 = document.getElementById('graf_tasa_cambio_compra_venta').getContext('2d');
		var chart = new Chart(ctx_1, {
			// The type of chart we want to create
			type: 'line',
			// The data for our dataset
			data: {
				labels: [
					<?php
						$i=0;
						while(isset($dias[$i])){
							$dia_i=explode("-",$dias[$i]);
							echo "'mes: " . $dia_i[1] . ", día: " . $dia_i[2] . "'";
							if(isset($dias[$i+1])){
								echo ",";
							}
							$i++;
						}
					?>
				],
				datasets: [{
					label: 'C',
					borderColor: 'rgb(60, 100, 148)',
					backgroundColor: 'rgb(60, 100, 148, 0.1)',
					data: [
						<?php
							$i=0;
							while(isset($tasa_compra[$i])){
								echo "'" . $tasa_compra[$i] . "'";
								if(isset($tasa_compra[$i+1])){
									echo ",";
								}
								$i++;
							}
						?>
					]
					},{
					label: 'V',
					borderColor: 'rgb(150, 61, 59)',
					backgroundColor: 'rgb(150, 61, 59, 0.1)',
					data: [
						<?php
							$i=0;
							while(isset($tasa_venta[$i])){
								echo "'" . $tasa_venta[$i] . "'";
								if(isset($tasa_venta[$i+1])){
									echo ",";
								}
								$i++;
							}
						?>
					]
					}
				]
			},
			// Configuration options go here
			options: {
				responsive: true,
				title: {
					display: false,
					text: 'tendencia de la tasa de cambio'
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
							display: false,
							labelString: 'dias'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Bs/Pm'
						}
					}]
				}
			}							
		});			
	</script>
	<script type="text/javascript">
		var ctx_2 = document.getElementById('graf_tasa_cambio_bs_dollar').getContext('2d');
		var chart = new Chart(ctx_2, {
			// The type of chart we want to create
			type: 'line',
			// The data for our dataset
			data: {
				labels: [
					<?php
						$i=0;
						while(isset($dias[$i])){
							$dia_i=explode("-",$dias[$i]);
							echo "'mes: " . $dia_i[1] . ", día: " . $dia_i[2] . "'";
							if(isset($dias[$i+1])){
								echo ",";
							}
							$i++;
						}
					?>
				],
				datasets: [{
					label: 'Bs/$',
					borderColor: 'rgb(61, 150, 59)',
					backgroundColor: 'rgb(61, 150, 59, 0.1)',
					data: [
						<?php
							$i=0;
							while(isset($tasa_bs_dollar[$i])){
								echo "'" . $tasa_bs_dollar[$i] . "'";
								if(isset($tasa_bs_dollar[$i+1])){
									echo ",";
								}
								$i++;
							}
						?>
					]
					}
				]
			},
			// Configuration options go here
			options: {
				responsive: true,
				title: {
					display: false,
					text: 'tendencia de la tasa de cambio'
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
							display: false,
							labelString: 'dias'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Bs/$'
						}
					}]
				}
			}							
		});			
	</script>
	<script type="text/javascript">
		var ctx_3 = document.getElementById('graf_tasa_cambio_pm_dollar').getContext('2d');
		var chart = new Chart(ctx_3, {
			// The type of chart we want to create
			type: 'line',
			// The data for our dataset
			data: {
				labels: [
					<?php
						$i=0;
						while(isset($dias[$i])){
							$dia_i=explode("-",$dias[$i]);
							echo "'mes: " . $dia_i[1] . ", día: " . $dia_i[2] . "'";
							if(isset($dias[$i+1])){
								echo ",";
							}
							$i++;
						}
					?>
				],
				datasets: [{
					label: 'Pm/$',
					borderColor: 'rgb(30, 30, 30)',
					backgroundColor: 'rgb(30, 30, 30, 0.1)',
					data: [
						<?php
							$i=0;
							while(isset($tasa_pm_dollar[$i])){
								echo "'" . $tasa_pm_dollar[$i] . "'";
								if(isset($tasa_pm_dollar[$i+1])){
									echo ",";
								}
								$i++;
							}
						?>
					]
					}
				]
			},
			// Configuration options go here
			options: {
				responsive: true,
				title: {
					display: false,
					text: 'tendencia de la tasa de cambio'
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
							display: false,
							labelString: 'dias'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Pm/$'
						}
					}]
				}
			}							
		});			
	</script>
	<script type="text/javascript">
		var ctx_4 = document.getElementById('graf_pemon_circ_acum').getContext('2d');
		var chart = new Chart(ctx_4, {
			// The type of chart we want to create
			type: 'line',
			// The data for our dataset
			data: {
				labels: [
					<?php
						$i=0;
						while(isset($dias[$i])){
							$dia_i=explode("-",$dias[$i]);
							echo "'mes: " . $dia_i[1] . ", día: " . $dia_i[2] . "'";
							if(isset($dias[$i+1])){
								echo ",";
							}
							$i++;
						}
					?>
				],
				datasets: [{
					label: 'Pm Circ',
					borderColor: 'rgb(30, 30, 30)',
					backgroundColor: 'rgb(30, 30, 30, 0.1)',
					data: [
						<?php
							$i=0;
							while(isset($ra_res_mon_circ[$i])){
								echo "'" . $ra_res_mon_circ[$i] . "'";
								if(isset($ra_res_mon_circ[$i+1])){
									echo ",";
								}
								$i++;
							}
						?>
					]
					}
				]
			},
			// Configuration options go here
			options: {
				responsive: true,
				title: {
					display: false,
					text: 'tendencia de la tasa de cambio'
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
							display: false,
							labelString: 'dias'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Pm'
						}
					}]
				}
			}							
		});			
	</script>
	<script type="text/javascript">
		var ctx_5 = document.getElementById('graf_resp_acum_bs').getContext('2d');
		var chart = new Chart(ctx_5, {
			// The type of chart we want to create
			type: 'line',
			// The data for our dataset
			data: {
				labels: [
					<?php
						$i=0;
						while(isset($dias[$i])){
							$dia_i=explode("-",$dias[$i]);
							echo "'mes: " . $dia_i[1] . ", día: " . $dia_i[2] . "'";
							if(isset($dias[$i+1])){
								echo ",";
							}
							$i++;
						}
					?>
				],
				datasets: [{
					label: 'Bs Puros',
					borderColor: 'rgb(60, 100, 148)',
					backgroundColor: 'rgb(60, 100, 148, 0.1)',
					data: [
						<?php
							$i=0;
							while(isset($ra_res_mon_bs_puros[$i])){
								echo "'" . $ra_res_mon_bs_puros[$i] . "'";
								if(isset($ra_res_mon_bs_puros[$i+1])){
									echo ",";
								}
								$i++;
							}
						?>
					]
					}
				]
			},
			// Configuration options go here
			options: {
				responsive: true,
				title: {
					display: false,
					text: 'tendencia de la tasa de cambio'
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
							display: false,
							labelString: 'dias'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Bs'
						}
					}]
				}
			}							
		});			
	</script>
	<script type="text/javascript">
		var ctx_6 = document.getElementById('graf_resp_acum_dollares_y_dollares_equiv').getContext('2d');
		var chart = new Chart(ctx_6, {
			// The type of chart we want to create
			type: 'line',
			// The data for our dataset
			data: {
				labels: [
					<?php
						$i=0;
						while(isset($dias[$i])){
							$dia_i=explode("-",$dias[$i]);
							echo "'mes: " . $dia_i[1] . ", día: " . $dia_i[2] . "'";
							if(isset($dias[$i+1])){
								echo ",";
							}
							$i++;
						}
					?>
				],
				datasets: [{
					label: '$',
					borderColor: 'rgb(150, 61, 59)',
					backgroundColor: 'rgb(150, 61, 59, 0.1)',
					data: [
						<?php
							$i=0;
							while(isset($ra_res_mon_dollares_puros[$i])){
								echo "'" . $ra_res_mon_dollares_puros[$i] . "'";
								if(isset($ra_res_mon_dollares_puros[$i+1])){
									echo ",";
								}
								$i++;
							}
						?>
					]
					},{
					label: '$Eq',
					borderColor: 'rgb(61, 150, 59)',
					backgroundColor: 'rgb(61, 150, 59, 0.1)',
					data: [
						<?php
							$i=0;
							while(isset($ra_res_mon_dollares_eqv[$i])){
								echo "'" . $ra_res_mon_dollares_eqv[$i] . "'";
								if(isset($ra_res_mon_dollares_eqv[$i+1])){
									echo ",";
								}
								$i++;
							}
						?>
					]
					}
				]
			},
			// Configuration options go here
			options: {
				responsive: true,
				title: {
					display: false,
					text: 'tendencia de la tasa de cambio'
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
							display: false,
							labelString: 'dias'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: '$'
						}
					}]
				}
			}							
		});			
	</script>
	<script type="text/javascript">
		var ctx_7 = document.getElementById('graf_ingr_acum_bs').getContext('2d');
		var chart = new Chart(ctx_7, {
			// The type of chart we want to create
			type: 'line',
			// The data for our dataset
			data: {
				labels: [
					<?php
						$i=0;
						while(isset($dias[$i])){
							$dia_i=explode("-",$dias[$i]);
							echo "'mes: " . $dia_i[1] . ", día: " . $dia_i[2] . "'";
							if(isset($dias[$i+1])){
								echo ",";
							}
							$i++;
						}
					?>
				],
				datasets: [{
					label: 'Bs Puros',
					borderColor: 'rgb(60, 100, 148)',
					backgroundColor: 'rgb(60, 100, 148, 0.1)',
					data: [
						<?php
							$i=0;
							while(isset($ra_ie_bs_puros[$i])){
								echo "'" . $ra_ie_bs_puros[$i] . "'";
								if(isset($ra_ie_bs_puros[$i+1])){
									echo ",";
								}
								$i++;
							}
						?>
					]
					}
				]
			},
			// Configuration options go here
			options: {
				responsive: true,
				title: {
					display: false,
					text: 'tendencia de la tasa de cambio'
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
							display: false,
							labelString: 'dias'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Bs'
						}
					}]
				}
			}							
		});			
	</script>
	<script type="text/javascript">
		var ctx_8 = document.getElementById('graf_ingr_acum_dollares').getContext('2d');
		var chart = new Chart(ctx_8, {
			// The type of chart we want to create
			type: 'line',
			// The data for our dataset
			data: {
				labels: [
					<?php
						$i=0;
						while(isset($dias[$i])){
							$dia_i=explode("-",$dias[$i]);
							echo "'mes: " . $dia_i[1] . ", día: " . $dia_i[2] . "'";
							if(isset($dias[$i+1])){
								echo ",";
							}
							$i++;
						}
					?>
				],
				datasets: [{
					label: '$ Puros',
					borderColor: 'rgb(150, 61, 59)',
					backgroundColor: 'rgb(150, 61, 59, 0.1)',
					data: [
						<?php
							$i=0;
							while(isset($ra_ie_dollares_puros[$i])){
								echo "'" . $ra_ie_dollares_puros[$i] . "'";
								if(isset($ra_ie_dollares_puros[$i+1])){
									echo ",";
								}
								$i++;
							}
						?>
					]
					}
				]
			},
			// Configuration options go here
			options: {
				responsive: true,
				title: {
					display: false,
					text: 'tendencia de la tasa de cambio'
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
							display: false,
							labelString: 'dias'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: '$'
						}
					}]
				}
			}							
		});			
	</script>
	<script type="text/javascript">
		var ctx_9 = document.getElementById('graf_ingr_acum_dollares_equiv').getContext('2d');
		var chart = new Chart(ctx_9, {
			// The type of chart we want to create
			type: 'line',
			// The data for our dataset
			data: {
				labels: [
					<?php
						$i=0;
						while(isset($dias[$i])){
							$dia_i=explode("-",$dias[$i]);
							echo "'mes: " . $dia_i[1] . ", día: " . $dia_i[2] . "'";
							if(isset($dias[$i+1])){
								echo ",";
							}
							$i++;
						}
					?>
				],
				datasets: [{
					label: '$ Equiv',
					borderColor: 'rgb(61, 150, 59)',
					backgroundColor: 'rgb(61, 150, 59, 0.1)',
					data: [
						<?php
							$i=0;
							while(isset($ra_ie_dollares_eqv[$i])){
								echo "'" . $ra_ie_dollares_eqv[$i] . "'";
								if(isset($ra_ie_dollares_eqv[$i+1])){
									echo ",";
								}
								$i++;
							}
						?>
					]
					}
				]
			},
			// Configuration options go here
			options: {
				responsive: true,
				title: {
					display: false,
					text: 'tendencia de la tasa de cambio'
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
							display: false,
							labelString: 'dias'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: '$ Eq'
						}
					}]
				}
			}							
		});			
	</script>
	<!-- FIN DE LOS GRÁFICOS -->

<?php
}
?>