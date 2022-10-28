<?php
if(isset($_POST['usuario'])){
	if($_POST['usuario']=='SI'){
		require_once ("M_todos.php");
?>
		<div class="row bg-dark mt-4">
			<div class="col-12 px-0">
				<h4 class="bg-dark text-warning text-center py-1 m-0"><b>Bs/Pm (Últimos 15 días)</b></h4>
			</div>
			<div class="col-12 col-md-6 bg-light rounded border border-dark text-center p-2">
				<canvas id="graf_tasa_cambio_compra"></canvas>
			</div>
			<div class="col-12 col-md-6 bg-light rounded border border-dark text-center p-2">
				<canvas id="graf_tasa_cambio_venta"></canvas>
			</div>
			<?php
				//UBICANDO LOS DATOS PARA LA GRAFICA
				//1 ESTABLECIENDO LOS DÍAS DEL EJE X
				$dias[0]=date("Y-m-d");
				$i=1;
				while($i<15){
					$dias[$i]=date("Y-m-d",strtotime($dias[$i-1]."- 1 days"));
					$i=$i+1;
				}
				//2 ESTABLECIENDO LOS DATOS DE TASA PARA ESOS DÍAS
				$paridad_ultima=M_paridad_cambiaria_R_ultima($conexion);
				$tasa_compra[0]=$paridad_ultima['TIPO_POR_MICOIN_COMPRA'][0];
				$tasa_venta[0]=$paridad_ultima['TIPO_POR_MICOIN_VENTA'][0];
				$i=1;
				while($i<15){
					$paridad_i=M_paridad_cambiaria_R_ultima_x_fecha($conexion, $dias[$i]);
					$tasa_compra[$i]=$paridad_i['TIPO_POR_MICOIN_COMPRA'][0];
					$tasa_venta[$i]=$paridad_i['TIPO_POR_MICOIN_VENTA'][0];
					if($tasa_compra[$i]==''){
						$tasa_compra[$i]=$tasa_compra[$i-1];
					}
					if($tasa_venta[$i]==''){
						$tasa_venta[$i]=$tasa_venta[$i-1];
					}
					$i=$i+1;
				}
			?>
			<script>
				var ctx = document.getElementById('graf_tasa_cambio_compra').getContext('2d');
				var chart = new Chart(ctx, {
					// The type of chart we want to create
					type: 'line',
					// The data for our dataset
					data: {
						labels: [
							<?php
								$i=14;
								while(isset($dias[$i])){
									$dia_i=explode("-",$dias[$i]);
									echo "'" . $dia_i[0] . "-" . $dia_i[1] . "-" . $dia_i[2] . "'";
									if(isset($dias[$i-1])){
										echo ",";
									}
									$i=$i-1;
								}
							?>
						],
						datasets: [{
							label: 'Compra',
							borderColor: 'rgb(60, 100, 148)',
							backgroundColor: 'rgb(60, 100, 148, 0.1)',
							data: [
								<?php
									$i=14;
									while(isset($tasa_compra[$i])){
										echo "'" . $tasa_compra[$i] . "'";
										if(isset($tasa_compra[$i-1])){
											echo ",";
										}
										$i=$i-1;
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
			<script>
				var ctx = document.getElementById('graf_tasa_cambio_venta').getContext('2d');
				var chart = new Chart(ctx, {
					// The type of chart we want to create
					type: 'line',
					// The data for our dataset
					data: {
						labels: [
							<?php
								$i=14;
								while(isset($dias[$i])){
									$dia_i=explode("-",$dias[$i]);
									echo "'" . $dia_i[0] . "-" . $dia_i[1] . "-" . $dia_i[2] . "'";
									if(isset($dias[$i-1])){
										echo ",";
									}
									$i=$i-1;
								}
							?>
						],
						datasets: [{
							label: 'Venta',
							borderColor: 'rgb(150, 61, 59)',
							backgroundColor: 'rgb(150, 61, 59, 0.1)',
							data: [
								<?php
									$i=14;
									while(isset($tasa_venta[$i])){
										echo "'" . $tasa_venta[$i] . "'";
										if(isset($tasa_venta[$i-1])){
											echo ",";
										}
										$i=$i-1;
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
		</div>
<?php		
	}
}
?>
