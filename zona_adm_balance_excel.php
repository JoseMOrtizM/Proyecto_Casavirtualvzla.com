<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	if(isset($_POST["ano_excel"])){
		$ano=mysqli_real_escape_string($conexion,$_POST["ano_excel"]);
	}else{
		$ano=date("Y");
	}
?>
<?php
	//Inicio de la instancia para la exportación en Excel
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=Balance_excel.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Balance a Excel</title>
</head>
<body>
	<section>
		<table>
			<tr>
				<th style="border: solid 1px #000">ID_ADM</th>
				<th style="border: solid 1px #000">FH_REGISTRO</th>
				<th style="border: solid 1px #000">DESCRIPCION</th>
				<th style="border: solid 1px #000">DGO_TIPO_DE_OPERACION</th>
				<th style="border: solid 1px #000">DGO_COMISION</th>
				<th style="border: solid 1px #000">DGO_PM</th>
				<th style="border: solid 1px #000">DGO_BS</th>
				<th style="border: solid 1px #000">DGO_DOLLAR</th>
				<th style="border: solid 1px #000">PRE_CO_BS_DEP_RET</th>
				<th style="border: solid 1px #000">PRE_CO_GAN_PM_EQV</th>
				<th style="border: solid 1px #000">PRE_CO_GAN_DOLLAR_EQV</th>
				<th style="border: solid 1px #000">PRE_CO_GAN_BS_EQV</th>
				<th style="border: solid 1px #000">PRE_CO_PM_AL_RESPALDO</th>
				<th style="border: solid 1px #000">PRE_CO_DOLLAR_AL_RESPALDO</th>
				<th style="border: solid 1px #000">PRE_CO_BS_AL_RESPALDO</th>
				<th style="border: solid 1px #000">TC_BS_DOLLAR</th>
				<th style="border: solid 1px #000">TC_PM_DOLLAR</th>
				<th style="border: solid 1px #000">TC_BS_PM_C</th>
				<th style="border: solid 1px #000">TC_BS_PM_V</th>
				<th style="border: solid 1px #000">RP_IE_BS_PUROS</th>
				<th style="border: solid 1px #000">RP_IE_DOLLAR_PUROS</th>
				<th style="border: solid 1px #000">RP_RES_MON_CIRC</th>
				<th style="border: solid 1px #000">RP_RES_MON_BS_PUROS</th>
				<th style="border: solid 1px #000">RP_RES_MON_DOLLAR_PUROS</th>
				<th style="border: solid 1px #000">RA_IE_BS_PUROS</th>
				<th style="border: solid 1px #000">RA_IE_DOLLARES_PUROS</th>
				<th style="border: solid 1px #000">RA_IE_DOLLARES_EQV</th>
				<th style="border: solid 1px #000">RA_RES_MON_CIRC</th>
				<th style="border: solid 1px #000">RA_RES_MON_BS_PUROS</th>
				<th style="border: solid 1px #000">RA_RES_MON_DOLLARES_PUROS</th>
				<th style="border: solid 1px #000">RA_RES_MON_DOLLARES_EQV</th>
			</tr>
			<?php
			//obteniendo los datos de la tabla:
			$datos=M_balance_administrativo_lcv_R_ano($conexion, $ano);
			$i=0;
			while(isset($datos['ID_ADM'][$i])){
				if($datos['ID_ADM'][$i]<>""){
					echo "<tr>";
					echo "<td style='border: solid 1px #000'>" . $datos['ID_ADM'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['FH_REGISTRO'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['DESCRIPCION'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['DGO_TIPO_DE_OPERACION'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['DGO_COMISION'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['DGO_PM'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['DGO_BS'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['DGO_DOLLAR'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['PRE_CO_BS_DEP_RET'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['PRE_CO_GAN_PM_EQV'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['PRE_CO_GAN_DOLLAR_EQV'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['PRE_CO_GAN_BS_EQV'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['PRE_CO_PM_AL_RESPALDO'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['PRE_CO_DOLLAR_AL_RESPALDO'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['PRE_CO_BS_AL_RESPALDO'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['TC_BS_DOLLAR'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['TC_PM_DOLLAR'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['TC_BS_PM_C'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['TC_BS_PM_V'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['RP_IE_BS_PUROS'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['RP_IE_DOLLAR_PUROS'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['RP_RES_MON_CIRC'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['RP_RES_MON_BS_PUROS'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['RP_RES_MON_DOLLAR_PUROS'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['RA_IE_BS_PUROS'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['RA_IE_DOLLARES_PUROS'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['RA_IE_DOLLARES_EQV'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['RA_RES_MON_CIRC'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['RA_RES_MON_BS_PUROS'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['RA_RES_MON_DOLLARES_PUROS'][$i] . "</td>";
					echo "<td style='border: solid 1px #000'>" . $datos['RA_RES_MON_DOLLARES_EQV'][$i] . "</td>";
					echo "</tr>";
				}
				$i=$i+1;
			}
			?>
		</table>
	</section>
</body>
</html>