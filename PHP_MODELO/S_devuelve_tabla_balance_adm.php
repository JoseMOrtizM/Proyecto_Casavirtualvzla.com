<?php
if(isset($_POST['adm']) and isset($_POST['tipo_de_péracion'])){
	if($_POST['adm']=='adm'){
		require_once ("M_todos.php");
		//obteniendo los datos de la tabla:
		if($_POST['tipo_de_péracion']=="TODAS"){
			$datos=M_balance_administrativo_lcv_R($conexion, '', '', '', '', '', '');
		}else{
			$datos=M_balance_administrativo_lcv_R($conexion, 'DGO_TIPO_DE_OPERACION', $_POST['tipo_de_péracion'], '', '', '', '');
		}
?>
		<!-- TABLA PARA VISTA GRANDE -->
		<div class="bg-white py-2 d-none d-lg-block">
			<table class="table table-bordered table-hover table-striped TablaDinamicaOrderDesc bg-light" id='TablaDinamicaOrderDesc001'>
				<thead>
					<tr class="text-center bg-dark">
						<th class="align-middle text-light" style='width: 40%;'><b title="Número de Operación / Fecha y descripción de la transacción / Tasas de Cambio">N°) Fecha<br>Descripción</b></th>
						<th class="align-middle text-light"><b title="Ingresos Puntuales">Ingresos<br>Puntuales</b></th>
						<th class="align-middle text-light"><b title="Ingresos Acumulados">Ingresos<br>Acumulados</b></th>
						<th class="align-middle text-light"><b title="Respaldo Puntuales">Respaldo<br>Puntuales</b></th>
						<th class="align-middle text-light"><b title="Respaldo Acumulados">Respaldo<br>Acumulados</b></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=0;
					while(isset($datos['ID_ADM'][$i])){
						if($datos['ID_ADM'][$i]<>""){
							if($datos['ID_ADM'][$i]<10){
								$numero="0000000" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<100){
								$numero="000000" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<1000){
								$numero="00000" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<10000){
								$numero="0000" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<100000){
								$numero="000" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<1000000){
								$numero="00" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<10000000){
								$numero="0" . $datos['ID_ADM'][$i];
							}else{
								$numero=$datos['ID_ADM'][$i];
							}
							//tratando fecha
							$fecha_imp_2=explode(" ",$datos['FH_REGISTRO'][$i]);
							echo "<tr class='py-0'>";
							echo "<td class='text-left py-0' style='width: 40%;'><b class='text-danger'>" . $numero . ") " . $fecha_imp_2[0] . "</b><br><b>" . $datos['DGO_TIPO_DE_OPERACION'][$i] . "</b><br><i class='small'>" . $datos['DESCRIPCION'][$i] . "</i><br><i class='small'>(Bs/$=" . number_format($datos['TC_BS_DOLLAR'][$i], 2,',','.') . ", Bs/PmC=" . number_format($datos['TC_BS_PM_C'][$i], 2,',','.') . ", Bs/PmV=" . number_format($datos['TC_BS_PM_V'][$i], 2,',','.') . ", Pm/$=" . number_format($datos['TC_PM_DOLLAR'][$i], 2,',','.') . ")</i></td>";
							echo "<td class='text-left py-0'>";
								echo "<b>Bs:</b> ";
								if($datos['RP_IE_BS_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RP_IE_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RP_IE_BS_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RP_IE_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RP_IE_BS_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b>$:</b> ";
								if($datos['RP_IE_DOLLAR_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RP_IE_DOLLAR_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RP_IE_DOLLAR_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RP_IE_DOLLAR_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RP_IE_DOLLAR_PUROS'][$i], 2,',','.') . "</e>";
								}
							echo "</td>";
							echo "<td class='text-left py-0'>";
								echo "<b>Bs:</b> ";
								if($datos['RA_IE_BS_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_IE_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_IE_BS_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_IE_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_IE_BS_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b>$:</b> ";
								if($datos['RA_IE_DOLLARES_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_IE_DOLLARES_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_IE_DOLLARES_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_IE_DOLLARES_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_IE_DOLLARES_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b>$ Eq:</b> ";
								if($datos['RA_IE_DOLLARES_EQV'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_IE_DOLLARES_EQV'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_IE_DOLLARES_EQV'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_IE_DOLLARES_EQV'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_IE_DOLLARES_EQV'][$i], 2,',','.') . "</e>";
								}
							echo "</td>";
							echo "<td class='text-left py-0'>";
								echo "<b>Pm:</b> ";
								if($datos['RP_RES_MON_CIRC'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RP_RES_MON_CIRC'][$i], 2,',','.') . "</b>";
								}else if($datos['RP_RES_MON_CIRC'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RP_RES_MON_CIRC'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RP_RES_MON_CIRC'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b>Bs:</b> ";
								if($datos['RP_RES_MON_BS_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RP_RES_MON_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RP_RES_MON_BS_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RP_RES_MON_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RP_RES_MON_BS_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b>$:</b> ";
								if($datos['RP_RES_MON_DOLLAR_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RP_RES_MON_DOLLAR_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RP_RES_MON_DOLLAR_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RP_RES_MON_DOLLAR_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RP_RES_MON_DOLLAR_PUROS'][$i], 2,',','.') . "</e>";
								}
							echo "</td>";
							echo "<td class='text-left py-0'>";
								echo "<b>Pm:</b> ";
								if($datos['RA_RES_MON_CIRC'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_RES_MON_CIRC'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_RES_MON_CIRC'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_RES_MON_CIRC'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_RES_MON_CIRC'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b>Bs:</b> ";
								if($datos['RA_RES_MON_BS_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_RES_MON_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_RES_MON_BS_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_RES_MON_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_RES_MON_BS_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b>$:</b> ";
								if($datos['RA_RES_MON_DOLLARES_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_RES_MON_DOLLARES_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_RES_MON_DOLLARES_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_RES_MON_DOLLARES_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_RES_MON_DOLLARES_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b>$ Eq:</b> ";
								if($datos['RA_RES_MON_DOLLARES_EQV'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_RES_MON_DOLLARES_EQV'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_RES_MON_DOLLARES_EQV'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_RES_MON_DOLLARES_EQV'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_RES_MON_DOLLARES_EQV'][$i], 2,',','.') . "</e>";
								}
							echo "</td>";
							echo "</tr>";
						}
						$i=$i+1;
					}
					?>
				</tbody>
			</table>
		</div>
		<!-- TABLA PARA VISTA MEDIANAS -->
		<div class="bg-white py-2 d-none d-sm-block d-lg-none">
			<table class="table table-bordered table-hover table-striped TablaDinamicaOrderDesc bg-light" id='TablaDinamicaOrderDesc002'>
				<thead>
					<tr class="text-center bg-dark">
						<th class="align-middle text-light" style='width: 40%;'><b title="Número de Operación / Fecha y descripción de la transacción / Tasas de Cambio">N°) Fecha<br>Descripción</b></th>
						<th class="align-middle text-light"><b title="Información Puntual y Acumulada">Detalles</b></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=0;
					while(isset($datos['ID_ADM'][$i])){
						if($datos['ID_ADM'][$i]<>""){
							if($datos['ID_ADM'][$i]<10){
								$numero="0000000" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<100){
								$numero="000000" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<1000){
								$numero="00000" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<10000){
								$numero="0000" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<100000){
								$numero="000" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<1000000){
								$numero="00" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<10000000){
								$numero="0" . $datos['ID_ADM'][$i];
							}else{
								$numero=$datos['ID_ADM'][$i];
							}
							//tratando fecha
							$fecha_imp_2=explode(" ",$datos['FH_REGISTRO'][$i]);
							echo "<tr class='py-0'>";
							echo "<td class='text-left py-0' style='width: 40%;'><b class='text-danger'>" . $numero . ") " . $fecha_imp_2[0] . "</b><br><b>" . $datos['DGO_TIPO_DE_OPERACION'][$i] . "</b><br><i class='small'>" . $datos['DESCRIPCION'][$i] . "</i><br><i class='small'>(Bs/$=" . number_format($datos['TC_BS_DOLLAR'][$i], 2,',','.') . ", Bs/PmC=" . number_format($datos['TC_BS_PM_C'][$i], 2,',','.') . ", Bs/PmV=" . number_format($datos['TC_BS_PM_V'][$i], 2,',','.') . ", Pm/$=" . number_format($datos['TC_PM_DOLLAR'][$i], 2,',','.') . ")</i></td>";
							echo "<td class='text-left py-0' style='font-size:12px;'>";
								echo "<b class='text-success'>Ingr. Punt.</b>";
								echo "<br><b>Bs:</b> ";
								if($datos['RP_IE_BS_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RP_IE_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RP_IE_BS_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RP_IE_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RP_IE_BS_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo " <b>$:</b> ";
								if($datos['RP_IE_DOLLAR_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RP_IE_DOLLAR_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RP_IE_DOLLAR_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RP_IE_DOLLAR_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RP_IE_DOLLAR_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b class='text-success'>Ingr. Acum.</b>";
								echo "<br><b>Bs:</b> ";
								if($datos['RA_IE_BS_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_IE_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_IE_BS_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_IE_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_IE_BS_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo " <b>$:</b> ";
								if($datos['RA_IE_DOLLARES_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_IE_DOLLARES_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_IE_DOLLARES_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_IE_DOLLARES_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_IE_DOLLARES_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo " <b>$ Eq:</b> ";
								if($datos['RA_IE_DOLLARES_EQV'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_IE_DOLLARES_EQV'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_IE_DOLLARES_EQV'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_IE_DOLLARES_EQV'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_IE_DOLLARES_EQV'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b class='text-success'>Resp. Punt.</b>";
								echo "<br><b>Pm:</b> ";
								if($datos['RP_RES_MON_CIRC'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RP_RES_MON_CIRC'][$i], 2,',','.') . "</b>";
								}else if($datos['RP_RES_MON_CIRC'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RP_RES_MON_CIRC'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RP_RES_MON_CIRC'][$i], 2,',','.') . "</e>";
								}
								echo " <b>Bs:</b> ";
								if($datos['RP_RES_MON_BS_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RP_RES_MON_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RP_RES_MON_BS_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RP_RES_MON_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RP_RES_MON_BS_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo " <b>$:</b> ";
								if($datos['RP_RES_MON_DOLLAR_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RP_RES_MON_DOLLAR_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RP_RES_MON_DOLLAR_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RP_RES_MON_DOLLAR_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RP_RES_MON_DOLLAR_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b class='text-success'>Resp. Acum.</b>";
								echo "<br><b>Pm:</b> ";
								if($datos['RA_RES_MON_CIRC'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_RES_MON_CIRC'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_RES_MON_CIRC'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_RES_MON_CIRC'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_RES_MON_CIRC'][$i], 2,',','.') . "</e>";
								}
								echo " <b>Bs:</b> ";
								if($datos['RA_RES_MON_BS_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_RES_MON_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_RES_MON_BS_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_RES_MON_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_RES_MON_BS_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo " <b>$:</b> ";
								if($datos['RA_RES_MON_DOLLARES_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_RES_MON_DOLLARES_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_RES_MON_DOLLARES_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_RES_MON_DOLLARES_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_RES_MON_DOLLARES_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo " <b>$ Eq:</b> ";
								if($datos['RA_RES_MON_DOLLARES_EQV'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_RES_MON_DOLLARES_EQV'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_RES_MON_DOLLARES_EQV'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_RES_MON_DOLLARES_EQV'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_RES_MON_DOLLARES_EQV'][$i], 2,',','.') . "</e>";
								}
							echo "</td>";
							echo "</tr>";
						}
						$i=$i+1;
					}
					?>
				</tbody>
			</table>
		</div>
		<!-- TABLA PARA VISTA PEQUEÑA -->
		<div class="bg-white py-2 d-block d-sm-none">
			<table class="table table-bordered table-hover table-striped TablaDinamicaOrderDesc bg-light" id='TablaDinamicaOrderDesc003'>
				<thead>
					<tr class="text-center bg-dark">
						<th class="align-middle text-light" style='width: 40%;'><b title="Número de Operación / Fecha y descripción de la transacción / Tasas de Cambio">N°) Fecha<br>Descripción</b></th>
						<th class="align-middle text-light"><b title="Información Puntual y Acumulada">Detalles</b></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=0;
					while(isset($datos['ID_ADM'][$i])){
						if($datos['ID_ADM'][$i]<>""){
							if($datos['ID_ADM'][$i]<10){
								$numero="0000000" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<100){
								$numero="000000" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<1000){
								$numero="00000" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<10000){
								$numero="0000" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<100000){
								$numero="000" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<1000000){
								$numero="00" . $datos['ID_ADM'][$i];
							}else if($datos['ID_ADM'][$i]<10000000){
								$numero="0" . $datos['ID_ADM'][$i];
							}else{
								$numero=$datos['ID_ADM'][$i];
							}
							//tratando fecha
							$fecha_imp_2=explode(" ",$datos['FH_REGISTRO'][$i]);
							echo "<tr class='py-0'>";
							echo "<td class='text-left py-0' style='width: 40%;'><b class='text-danger'>" . $numero . ") " . $fecha_imp_2[0] . "</b><br><b>" . $datos['DGO_TIPO_DE_OPERACION'][$i] . "</b><br><i class='small'>" . $datos['DESCRIPCION'][$i] . "</i><br><i class='small'>(Bs/$=" . number_format($datos['TC_BS_DOLLAR'][$i], 2,',','.') . ", Bs/PmC=" . number_format($datos['TC_BS_PM_C'][$i], 2,',','.') . ", Bs/PmV=" . number_format($datos['TC_BS_PM_V'][$i], 2,',','.') . ", Pm/$=" . number_format($datos['TC_PM_DOLLAR'][$i], 2,',','.') . ")</i></td>";
							echo "<td class='text-left py-0' style='font-size:11px;'>";
								echo "<b class='text-success'>Ingr. Punt.</b>";
								echo "<br><b>Bs:</b> ";
								if($datos['RP_IE_BS_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RP_IE_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RP_IE_BS_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RP_IE_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RP_IE_BS_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b>$:</b> ";
								if($datos['RP_IE_DOLLAR_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RP_IE_DOLLAR_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RP_IE_DOLLAR_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RP_IE_DOLLAR_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RP_IE_DOLLAR_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b class='text-success'>Ingr. Acum.</b>";
								echo "<br><b>Bs:</b> ";
								if($datos['RA_IE_BS_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_IE_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_IE_BS_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_IE_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_IE_BS_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b>$:</b> ";
								if($datos['RA_IE_DOLLARES_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_IE_DOLLARES_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_IE_DOLLARES_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_IE_DOLLARES_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_IE_DOLLARES_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b>$ Eq:</b> ";
								if($datos['RA_IE_DOLLARES_EQV'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_IE_DOLLARES_EQV'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_IE_DOLLARES_EQV'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_IE_DOLLARES_EQV'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_IE_DOLLARES_EQV'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b class='text-success'>Resp. Punt.</b>";
								echo "<br><b>Pm:</b> ";
								if($datos['RP_RES_MON_CIRC'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RP_RES_MON_CIRC'][$i], 2,',','.') . "</b>";
								}else if($datos['RP_RES_MON_CIRC'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RP_RES_MON_CIRC'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RP_RES_MON_CIRC'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b>Bs:</b> ";
								if($datos['RP_RES_MON_BS_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RP_RES_MON_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RP_RES_MON_BS_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RP_RES_MON_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RP_RES_MON_BS_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b>$:</b> ";
								if($datos['RP_RES_MON_DOLLAR_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RP_RES_MON_DOLLAR_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RP_RES_MON_DOLLAR_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RP_RES_MON_DOLLAR_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RP_RES_MON_DOLLAR_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b class='text-success'>Resp. Acum.</b>";
								echo "<br><b>Pm:</b> ";
								if($datos['RA_RES_MON_CIRC'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_RES_MON_CIRC'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_RES_MON_CIRC'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_RES_MON_CIRC'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_RES_MON_CIRC'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b>Bs:</b> ";
								if($datos['RA_RES_MON_BS_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_RES_MON_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_RES_MON_BS_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_RES_MON_BS_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_RES_MON_BS_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b>$:</b> ";
								if($datos['RA_RES_MON_DOLLARES_PUROS'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_RES_MON_DOLLARES_PUROS'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_RES_MON_DOLLARES_PUROS'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_RES_MON_DOLLARES_PUROS'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_RES_MON_DOLLARES_PUROS'][$i], 2,',','.') . "</e>";
								}
								echo "<br><b>$ Eq:</b> ";
								if($datos['RA_RES_MON_DOLLARES_EQV'][$i]<0){
									echo "<b class='text-danger'>" . number_format($datos['RA_RES_MON_DOLLARES_EQV'][$i], 2,',','.') . "</b>";
								}else if($datos['RA_RES_MON_DOLLARES_EQV'][$i]>0){
									echo "<b class='text-primary'>" . number_format($datos['RA_RES_MON_DOLLARES_EQV'][$i], 2,',','.') . "</b>";
								}else{
									echo "<e>" . number_format($datos['RA_RES_MON_DOLLARES_EQV'][$i], 2,',','.') . "</e>";
								}
							echo "</td>";
							echo "</tr>";
						}
						$i=$i+1;
					}
					?>
				</tbody>
			</table>
		</div>
		<!-- ENLACES PARA LLAMAR AL PAGINADO Y BUSCADOR DE LA DATATABLE -->
		<script src="../jquery.dataTables.js"></script>
		<script src="../dataTables.bootstrap4.js"></script>
		<script>
		// LLAMANDO A LA FUNCIÓN DateTable() DE jquery.dataTables.js ORDEN DESENDENTE
			$(document).ready(function() {
				$('#TablaDinamicaOrderDesc001').DataTable({
					order: [[ 0, 'desc' ]]
				});
				$('#TablaDinamicaOrderDesc002').DataTable({
					order: [[ 0, 'desc' ]]
				});
				$('#TablaDinamicaOrderDesc003').DataTable({
					order: [[ 0, 'desc' ]]
				});
			});
		</script>	
<?php
	}
}
?>