<?php 
// CUERPO DE GANANCIAS.....
//SECCIÓN DE FILTROS Y GRAFICAS DE LA PRIMERA PESTAÑA
function M_indicadores_R_ano_1_1($conexion, $vendedor_cedula_rif){
	//AGRUPA LOS AÑOS EXISTENTES PARA EL USUARIO VENDEDOR
	$sql_cedula_rif=($vendedor_cedula_rif=="") ? "" : "AND `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif'";
	$consulta="SELECT YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`) AS ANO FROM `mc_control_de_transacciones_micoin` WHERE 1 $sql_cedula_rif AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)<>'0' GROUP BY ANO ORDER BY ANO DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ANO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ANO'][$i]=$fila['ANO'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_compradores_1($conexion, $vendedor_cedula_rif){
	//AGRUPA LOS COMPRADORES EXISTENTES PARA EL USUARIO VENDEDOR
	$sql_cedula_rif=($vendedor_cedula_rif=="") ? "" : "AND `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif'";
	$consulta="SELECT 
	`mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF` AS CEDULA_RIF, 
	`mc_control_de_transacciones_micoin`.`COMPRADOR_NOMBRE` AS NOMBRE, 
	`mc_control_de_transacciones_micoin`.`COMPRADOR_APELLIDO` AS APELLIDO 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 $sql_cedula_rif AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)<>'0' GROUP BY CEDULA_RIF ORDER BY NOMBRE, APELLIDO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['NOMBRE_APELLIDO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['NOMBRE_APELLIDO'][$i]=$fila['NOMBRE'] . " " . $fila['APELLIDO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_vendedores_1($conexion, $comprador_cedula_rif){
	//AGRUPA LOS COMPRADORES EXISTENTES PARA EL USUARIO VENDEDOR
	$sql_cedula_rif=($comprador_cedula_rif=="") ? "" : "AND `mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF`='$comprador_cedula_rif'";
	$consulta="SELECT 
	`mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF` AS CEDULA_RIF, 
	`mc_control_de_transacciones_micoin`.`VENDEDOR_NOMBRE` AS NOMBRE, 
	`mc_control_de_transacciones_micoin`.`VENDEDOR_APELLIDO` AS APELLIDO 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 $sql_cedula_rif	AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)<>'0' GROUP BY CEDULA_RIF ORDER BY NOMBRE, APELLIDO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['NOMBRE_APELLIDO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['NOMBRE_APELLIDO'][$i]=$fila['NOMBRE'] . " " . $fila['APELLIDO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_productos_1_1($conexion, $vendedor_cedula_rif){
	//AGRUPA LOS PRODUCTOS EXISTENTES PARA EL USUARIO VENDEDOR
	$sql_cedula_rif=($vendedor_cedula_rif=="") ? "" : "AND `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif'";
	$consulta="SELECT 
	`mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO` AS PRODUCTO 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 $sql_cedula_rif	AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)<>'0' GROUP BY PRODUCTO ORDER BY PRODUCTO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['PRODUCTO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['PRODUCTO'][$i]=$fila['PRODUCTO'];
		$i=$i+1;
	}
	return $datos;
}
//SECCIÓN GANANCIAS GRAFICOS DE LA PRIMERA PARTE PRODUCTOS VENDIDOS
function M_indicadores_R_graf_1($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $comprador_cedula_rif, $producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_comp=($comprador_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF`='$comprador_cedula_rif'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($producto=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO`='$producto'";
	//consultando
	$consulta="SELECT 
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='1' then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as PEMONES_MES_1,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='2' then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as PEMONES_MES_2,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='3' then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as PEMONES_MES_3,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='4' then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as PEMONES_MES_4,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='5' then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as PEMONES_MES_5,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='6' then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as PEMONES_MES_6,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='7' then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as PEMONES_MES_7,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='8' then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as PEMONES_MES_8,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='9' then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as PEMONES_MES_9,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='10' then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as PEMONES_MES_10,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='11' then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as PEMONES_MES_11,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='12' then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as PEMONES_MES_12, 
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='1' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_1,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='2' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_2,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='3' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_3,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='4' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_4,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='5' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_5,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='6' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_6,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='7' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_7,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='8' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_8,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='9' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_9,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='10' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_10,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='11' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_11,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='12' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_12, 
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='1' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_1,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='2' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_2,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='3' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_3,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='4' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_4,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='5' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_5,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='6' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_6,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='7' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_7,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='8' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_8,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='9' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_9,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='10' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_10,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='11' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_11,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='12' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_12 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 
	AND `mc_control_de_transacciones_micoin`.`ESTATUS`='ENTREGADO' 
	$sql_ano
	$sql_mes 
	$sql_edad
	$sql_comp
	$sql_vend 
	$sql_prod";
	$resultados=mysqli_query($conexion,$consulta);
	$i=1;
	while($i<13){
		$datos['PEMONES_MES_' . $i][0]=0;
		$datos['PRODUCTOS_MES_' . $i][0]=0;
		$datos['VENTAS_MES_' . $i][0]=0;
		$datos['TOTAL_PEMONES'][0]=0;
		$datos['TOTAL_PRODUCTOS'][0]=0;
		$datos['TOTAL_VENTAS'][0]=0;
		$i=$i+1;
	}
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['PEMONES_MES_1'][0]=$fila['PEMONES_MES_1'];
		$datos['PRODUCTOS_MES_1'][0]=$fila['PRODUCTOS_MES_1'];
		$datos['VENTAS_MES_1'][0]=$fila['VENTAS_MES_1'];
		$datos['TOTAL_PEMONES'][0]=$fila['PEMONES_MES_1'];
		$datos['TOTAL_PRODUCTOS'][0]=$fila['PRODUCTOS_MES_1'];
		$datos['TOTAL_VENTAS'][0]=$fila['VENTAS_MES_1'];
		if($ano_hoy>$ano){
			$i=2;
			while($i<13){
				$datos['PEMONES_MES_' . $i][0]=$fila['PEMONES_MES_' . $i];
				$datos['PRODUCTOS_MES_' . $i][0]=$fila['PRODUCTOS_MES_' . $i];
				$datos['VENTAS_MES_' . $i][0]=$fila['VENTAS_MES_' . $i];
				$datos['TOTAL_PEMONES'][0]=$datos['TOTAL_PEMONES'][0] + $fila['PEMONES_MES_' . $i];
				$datos['TOTAL_PRODUCTOS'][0]=$datos['TOTAL_PRODUCTOS'][0] + $fila['PRODUCTOS_MES_' . $i];
				$datos['TOTAL_VENTAS'][0]=$datos['TOTAL_VENTAS'][0] + $fila['VENTAS_MES_' . $i];
				$i=$i+1;
			}
		}else{
			$i=2;
			while($i<13){
				$datos['PEMONES_MES_' . $i][0]=($mes_hoy>($i-1)) ? $fila['PEMONES_MES_' . $i] : "null";
				$datos['PRODUCTOS_MES_' . $i][0]=($mes_hoy>($i-1)) ? $fila['PRODUCTOS_MES_' . $i] : "null";
				$datos['VENTAS_MES_' . $i][0]=($mes_hoy>($i-1)) ? $fila['VENTAS_MES_' . $i] : "null";
				$datos['TOTAL_PEMONES'][0]=$datos['TOTAL_PEMONES'][0] + $fila['PEMONES_MES_' . $i];
				$datos['TOTAL_PRODUCTOS'][0]=$datos['TOTAL_PRODUCTOS'][0] + $fila['PRODUCTOS_MES_' . $i];
				$datos['TOTAL_VENTAS'][0]=$datos['TOTAL_VENTAS'][0] + $fila['VENTAS_MES_' . $i];
				$i=$i+1;
			}
		}
	}
	return $datos;
}
function M_indicadores_R_graf_1_torta_edades($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $comprador_cedula_rif, $producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_comp=($comprador_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF`='$comprador_cedula_rif'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($producto=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO`='$producto'";
	//consultando
	$ano_20=$ano_hoy-20;
	$ano_30=$ano_hoy-30;
	$ano_40=$ano_hoy-40;
	$ano_50=$ano_hoy-50;
	$consulta="SELECT 
	SUM(case when YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_20' then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as MENOS_DE_20, 
	SUM(case when (YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_20' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_30') then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as MENOS_DE_30, 
	SUM(case when (YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_30' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_40') then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as MENOS_DE_40, 
	SUM(case when (YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_40' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_50') then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as MENOS_DE_50, 
	SUM(case when YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_50' then `mc_control_de_transacciones_micoin`.`MONTO_NETO` end) as MAS_DE_50 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 
	AND `mc_control_de_transacciones_micoin`.`ESTATUS`='ENTREGADO' 
	$sql_ano 
	$sql_mes 
	$sql_edad
	$sql_comp 
	$sql_vend 
	$sql_prod";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['MENOS_DE_20'][$i]='';
	$datos['MENOS_DE_30'][$i]='';
	$datos['MENOS_DE_40'][$i]='';
	$datos['MENOS_DE_50'][$i]='';
	$datos['MAS_DE_50'][$i]='';
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['MENOS_DE_20'][$i]=$fila['MENOS_DE_20'];
		$datos['MENOS_DE_30'][$i]=$fila['MENOS_DE_30'];
		$datos['MENOS_DE_40'][$i]=$fila['MENOS_DE_40'];
		$datos['MENOS_DE_50'][$i]=$fila['MENOS_DE_50'];
		$datos['MAS_DE_50'][$i]=$fila['MAS_DE_50'];
	}
	return $datos;
}
function M_indicadores_R_graf_1_torta_compradores($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $comprador_cedula_rif, $producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_comp=($comprador_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF`='$comprador_cedula_rif'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($producto=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO`='$producto'";
	//consultando
	$consulta="SELECT 
	`mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF` AS COMPRADOR_CEDULA_RIF, 
	`mc_control_de_transacciones_micoin`.`COMPRADOR_NOMBRE` AS COMPRADOR_NOMBRE, 
	`mc_control_de_transacciones_micoin`.`COMPRADOR_APELLIDO` AS COMPRADOR_APELLIDO, 
	SUM(`mc_control_de_transacciones_micoin`.`MONTO_NETO`) as TOTAL_PEMON 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 
	AND `mc_control_de_transacciones_micoin`.`ESTATUS`='ENTREGADO' 
	$sql_ano 
	$sql_mes 
	$sql_edad
	$sql_comp 
	$sql_vend 
	$sql_prod 
	GROUP BY COMPRADOR_CEDULA_RIF ORDER BY COMPRADOR_NOMBRE, COMPRADOR_APELLIDO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['COMPRADOR_NOMBRE_APELLIDO'][$i]='';
	$datos['TOTAL_PEMON'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['COMPRADOR_NOMBRE_APELLIDO'][$i]=$fila['COMPRADOR_NOMBRE'];
		$datos['TOTAL_PEMON'][$i]=$fila['TOTAL_PEMON'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_graf_1_torta_productos($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $comprador_cedula_rif, $producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_comp=($comprador_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF`='$comprador_cedula_rif'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($producto=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO`='$producto'";
	//consultando
	$consulta="SELECT 
	`mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO` AS NOMBRE_PRODUCTO, 
	SUM(`mc_control_de_transacciones_micoin`.`MONTO_NETO`) as TOTAL_PEMON 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 
	AND `mc_control_de_transacciones_micoin`.`ESTATUS`='ENTREGADO' 
	$sql_ano 
	$sql_mes 
	$sql_edad
	$sql_comp 
	$sql_vend 
	$sql_prod
	GROUP BY NOMBRE_PRODUCTO ORDER BY NOMBRE_PRODUCTO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['NOMBRE_PRODUCTO'][$i]='';
	$datos['TOTAL_PEMON'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$datos['TOTAL_PEMON'][$i]=$fila['TOTAL_PEMON'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_graf_1_torta_vendedores($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $comprador_cedula_rif, $producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`COMPRADOR_FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_comp=($comprador_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF`='$comprador_cedula_rif'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($producto=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO`='$producto'";
	//consultando
	$consulta="SELECT 
	`mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF` AS VENDEDOR_CEDULA_RIF, 
	`mc_control_de_transacciones_micoin`.`VENDEDOR_NOMBRE` AS VENDEDOR_NOMBRE, 
	`mc_control_de_transacciones_micoin`.`VENDEDOR_APELLIDO` AS VENDEDOR_APELLIDO, 
	SUM(`mc_control_de_transacciones_micoin`.`MONTO_NETO`) as TOTAL_PEMON 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 
	AND `mc_control_de_transacciones_micoin`.`ESTATUS`='ENTREGADO' 
	$sql_ano 
	$sql_mes 
	$sql_edad
	$sql_comp 
	$sql_vend 
	$sql_prod
	GROUP BY VENDEDOR_CEDULA_RIF ORDER BY VENDEDOR_NOMBRE, VENDEDOR_APELLIDO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['VENDEDOR_NOMBRE_APELLIDO'][$i]='';
	$datos['TOTAL_PEMON'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['VENDEDOR_NOMBRE_APELLIDO'][$i]=$fila['VENDEDOR_NOMBRE'];
		$datos['TOTAL_PEMON'][$i]=$fila['TOTAL_PEMON'];
		$i=$i+1;
	}
	return $datos;
}
//SECCIÓN DE FILTROS Y GRAFICAS DE LA SEGUNDA PESTAÑA
function M_indicadores_R_ano_1_2($conexion, $comprador_cedula_rif){
	//AGRUPA LOS AÑOS EXISTENTES PARA EL USUARIO VENDEDOR
	$sql_cedula_rif=($comprador_cedula_rif=="") ? "" : "AND `mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF`='$comprador_cedula_rif'";
	$consulta="SELECT YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`) AS ANO FROM `mc_control_de_transacciones_micoin` WHERE 1 $sql_cedula_rif AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)<>'0' GROUP BY ANO ORDER BY ANO DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ANO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ANO'][$i]=$fila['ANO'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_productos_1_2($conexion, $comprador_cedula_rif){
	//AGRUPA LOS PRODUCTOS EXISTENTES PARA EL USUARIO VENDEDOR
	$sql_cedula_rif=($comprador_cedula_rif=="") ? "" : "AND `mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF`='$comprador_cedula_rif'";
	$consulta="SELECT 
	`mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO` AS PRODUCTO 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 $sql_cedula_rif	AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)<>'0' GROUP BY PRODUCTO ORDER BY PRODUCTO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['PRODUCTO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['PRODUCTO'][$i]=$fila['PRODUCTO'];
		$i=$i+1;
	}
	return $datos;
}
//SECCIÓN GANANCIAS GRAFICOS DE LA SEGUNDA PARTE PRODUCTOS COMPRADOS
function M_indicadores_R_graf_2($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $comprador_cedula_rif, $producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_comp=($comprador_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF`='$comprador_cedula_rif'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($producto=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO`='$producto'";
	//consultando
	$consulta="SELECT 
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='1' then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as PEMONES_MES_1,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='2' then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as PEMONES_MES_2,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='3' then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as PEMONES_MES_3,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='4' then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as PEMONES_MES_4,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='5' then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as PEMONES_MES_5,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='6' then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as PEMONES_MES_6,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='7' then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as PEMONES_MES_7,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='8' then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as PEMONES_MES_8,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='9' then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as PEMONES_MES_9,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='10' then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as PEMONES_MES_10,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='11' then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as PEMONES_MES_11,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='12' then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as PEMONES_MES_12, 
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='1' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_1,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='2' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_2,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='3' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_3,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='4' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_4,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='5' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_5,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='6' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_6,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='7' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_7,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='8' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_8,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='9' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_9,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='10' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_10,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='11' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_11,
	SUM(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='12' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as PRODUCTOS_MES_12, 
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='1' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_1,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='2' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_2,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='3' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_3,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='4' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_4,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='5' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_5,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='6' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_6,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='7' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_7,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='8' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_8,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='9' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_9,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='10' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_10,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='11' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_11,
	COUNT(case when MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='12' then `mc_control_de_transacciones_micoin`.`CANTIDAD_COMPRADA` end) as VENTAS_MES_12 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 
	AND `mc_control_de_transacciones_micoin`.`ESTATUS`='ENTREGADO' 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_comp 
	$sql_vend 
	$sql_prod";
	$resultados=mysqli_query($conexion,$consulta);
	$i=1;
	while($i<13){
		$datos['PEMONES_MES_' . $i][0]=0;
		$datos['PRODUCTOS_MES_' . $i][0]=0;
		$datos['VENTAS_MES_' . $i][0]=0;
		$datos['TOTAL_PEMONES'][0]=0;
		$datos['TOTAL_PRODUCTOS'][0]=0;
		$datos['TOTAL_VENTAS'][0]=0;
		$i=$i+1;
	}
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['PEMONES_MES_1'][0]=$fila['PEMONES_MES_1'];
		$datos['PRODUCTOS_MES_1'][0]=$fila['PRODUCTOS_MES_1'];
		$datos['VENTAS_MES_1'][0]=$fila['VENTAS_MES_1'];
		$datos['TOTAL_PEMONES'][0]=$fila['PEMONES_MES_1'];
		$datos['TOTAL_PRODUCTOS'][0]=$fila['PRODUCTOS_MES_1'];
		$datos['TOTAL_VENTAS'][0]=$fila['VENTAS_MES_1'];
		if($ano_hoy>$ano){
			$i=2;
			while($i<13){
				$datos['PEMONES_MES_' . $i][0]=$fila['PEMONES_MES_' . $i];
				$datos['PRODUCTOS_MES_' . $i][0]=$fila['PRODUCTOS_MES_' . $i];
				$datos['VENTAS_MES_' . $i][0]=$fila['VENTAS_MES_' . $i];
				$datos['TOTAL_PEMONES'][0]=$datos['TOTAL_PEMONES'][0] + $fila['PEMONES_MES_' . $i];
				$datos['TOTAL_PRODUCTOS'][0]=$datos['TOTAL_PRODUCTOS'][0] + $fila['PRODUCTOS_MES_' . $i];
				$datos['TOTAL_VENTAS'][0]=$datos['TOTAL_VENTAS'][0] + $fila['VENTAS_MES_' . $i];
				$i=$i+1;
			}
		}else{
			$i=2;
			while($i<13){
				$datos['PEMONES_MES_' . $i][0]=($mes_hoy>($i-1)) ? $fila['PEMONES_MES_' . $i] : "null";
				$datos['PRODUCTOS_MES_' . $i][0]=($mes_hoy>($i-1)) ? $fila['PRODUCTOS_MES_' . $i] : "null";
				$datos['VENTAS_MES_' . $i][0]=($mes_hoy>($i-1)) ? $fila['VENTAS_MES_' . $i] : "null";
				$datos['TOTAL_PEMONES'][0]=$datos['TOTAL_PEMONES'][0] + $fila['PEMONES_MES_' . $i];
				$datos['TOTAL_PRODUCTOS'][0]=$datos['TOTAL_PRODUCTOS'][0] + $fila['PRODUCTOS_MES_' . $i];
				$datos['TOTAL_VENTAS'][0]=$datos['TOTAL_VENTAS'][0] + $fila['VENTAS_MES_' . $i];
				$i=$i+1;
			}
		}
	}
	return $datos;
}
function M_indicadores_R_graf_2_torta_edades($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $comprador_cedula_rif, $producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_comp=($comprador_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF`='$comprador_cedula_rif'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($producto=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO`='$producto'";
	//consultando
	$ano_20=$ano_hoy-20;
	$ano_30=$ano_hoy-30;
	$ano_40=$ano_hoy-40;
	$ano_50=$ano_hoy-50;
	$consulta="SELECT 
	SUM(case when YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_20' then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as MENOS_DE_20, 
	SUM(case when (YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_20' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_30') then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as MENOS_DE_30, 
	SUM(case when (YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_30' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_40') then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as MENOS_DE_40, 
	SUM(case when (YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_40' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_50') then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as MENOS_DE_50, 
	SUM(case when YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_50' then `mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN` end) as MAS_DE_50 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 
	AND `mc_control_de_transacciones_micoin`.`ESTATUS`='ENTREGADO' 
	$sql_ano 
	$sql_mes 
	$sql_edad
	$sql_comp 
	$sql_vend 
	$sql_prod";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['MENOS_DE_20'][$i]='';
	$datos['MENOS_DE_30'][$i]='';
	$datos['MENOS_DE_40'][$i]='';
	$datos['MENOS_DE_50'][$i]='';
	$datos['MAS_DE_50'][$i]='';
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['MENOS_DE_20'][$i]=$fila['MENOS_DE_20'];
		$datos['MENOS_DE_30'][$i]=$fila['MENOS_DE_30'];
		$datos['MENOS_DE_40'][$i]=$fila['MENOS_DE_40'];
		$datos['MENOS_DE_50'][$i]=$fila['MENOS_DE_50'];
		$datos['MAS_DE_50'][$i]=$fila['MAS_DE_50'];
	}
	return $datos;
}
function M_indicadores_R_graf_2_torta_vendedores($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $comprador_cedula_rif, $producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_comp=($comprador_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF`='$comprador_cedula_rif'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($producto=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO`='$producto'";
	//consultando
	$consulta="SELECT 
	`mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF` AS VENDEDOR_CEDULA_RIF, 
	`mc_control_de_transacciones_micoin`.`VENDEDOR_NOMBRE` AS VENDEDOR_NOMBRE, 
	`mc_control_de_transacciones_micoin`.`VENDEDOR_APELLIDO` AS VENDEDOR_APELLIDO, 
	SUM(`mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN`) as TOTAL_PEMON 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 
	AND `mc_control_de_transacciones_micoin`.`ESTATUS`='ENTREGADO' 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_comp 
	$sql_vend 
	$sql_prod 
	GROUP BY VENDEDOR_CEDULA_RIF ORDER BY VENDEDOR_NOMBRE, VENDEDOR_APELLIDO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['VENDEDOR_NOMBRE_APELLIDO'][$i]='';
	$datos['TOTAL_PEMON'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['VENDEDOR_NOMBRE_APELLIDO'][$i]=$fila['VENDEDOR_NOMBRE'];
		$datos['TOTAL_PEMON'][$i]=$fila['TOTAL_PEMON'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_graf_2_torta_productos($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $comprador_cedula_rif, $producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_comp=($comprador_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF`='$comprador_cedula_rif'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($producto=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO`='$producto'";
	//consultando
	$consulta="SELECT 
	`mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO` AS NOMBRE_PRODUCTO, 
	SUM(`mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN`) as TOTAL_PEMON 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 
	AND `mc_control_de_transacciones_micoin`.`ESTATUS`='ENTREGADO' 
	$sql_ano 
	$sql_mes 
	$sql_edad
	$sql_comp 
	$sql_vend 
	$sql_prod
	GROUP BY NOMBRE_PRODUCTO ORDER BY NOMBRE_PRODUCTO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['NOMBRE_PRODUCTO'][$i]='';
	$datos['TOTAL_PEMON'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$datos['TOTAL_PEMON'][$i]=$fila['TOTAL_PEMON'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_graf_2_torta_compradores($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $comprador_cedula_rif, $producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_control_de_transacciones_micoin`.`VENDEDOR_FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_comp=($comprador_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF`='$comprador_cedula_rif'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($producto=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO`='$producto'";
	//consultando
	$consulta="SELECT 
	`mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF` AS COMPRADOR_CEDULA_RIF, 
	`mc_control_de_transacciones_micoin`.`COMPRADOR_NOMBRE` AS COMPRADOR_NOMBRE, 
	`mc_control_de_transacciones_micoin`.`COMPRADOR_APELLIDO` AS COMPRADOR_APELLIDO, 
	SUM(`mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN`) as TOTAL_PEMON 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 
	AND `mc_control_de_transacciones_micoin`.`ESTATUS`='ENTREGADO' 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_comp 
	$sql_vend 
	$sql_prod 
	GROUP BY COMPRADOR_CEDULA_RIF ORDER BY COMPRADOR_NOMBRE, COMPRADOR_APELLIDO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['COMPRADOR_NOMBRE_APELLIDO'][$i]='';
	$datos['TOTAL_PEMON'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['COMPRADOR_NOMBRE_APELLIDO'][$i]=$fila['COMPRADOR_NOMBRE'];
		$datos['TOTAL_PEMON'][$i]=$fila['TOTAL_PEMON'];
		$i=$i+1;
	}
	return $datos;
}
//SECCIÓN DE FILTROS DE LA TERCERA PESTAÑA
function M_indicadores_R_ano_cv_pm($conexion, $cedula_rif){
	//AGRUPA LOS AÑOS EXISTENTES PARA EL USUARIO VENDEDOR
	$sql_cedula_rif_1=($cedula_rif=="") ? "" : "AND `mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF`='$cedula_rif'";
	$consulta="SELECT YEAR(MIN(`mc_control_de_transacciones_micoin`.`FH_PAGADO`)) AS ANO FROM `mc_control_de_transacciones_micoin` WHERE 1 $sql_cedula_rif_1";
	$resultados=mysqli_query($conexion,$consulta);
	$datos_1['ANO'][0]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos_1['ANO'][0]=$fila['ANO'];
		$i=$i+1;
	}
	$sql_cedula_rif_2=($cedula_rif=="") ? "" : "AND `mc_compra_venta_de_micoin`.`CEDULA_RIF`='$cedula_rif'";
	$consulta="SELECT YEAR(MIN(`mc_compra_venta_de_micoin`.`FH_SOLICITADO`)) AS ANO FROM `mc_compra_venta_de_micoin` WHERE 1 $sql_cedula_rif_2";
	$resultados=mysqli_query($conexion,$consulta);
	$datos_2['ANO'][0]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos_2['ANO'][0]=$fila['ANO'];
		$i=$i+1;
	}
	$ano_actual=date("Y");
	if($datos_1['ANO'][0]==$datos_2['ANO'][0] and $datos_1['ANO'][0]==$ano_actual){
		$datos['ANO'][0]=0;
	}else if($datos_1['ANO'][0]==$datos_2['ANO'][0] and $datos_1['ANO'][0]<>$ano_actual){
		$i=0;
		$ano_i=$datos_2['ANO'][0];
		while($ano_i<=$ano_actual){
			$datos['ANO'][$i]=$ano_i;
			$i++;
			$ano_i++;
		}
	}else if($datos_1['ANO'][0]>$datos_2['ANO'][0]){
		$i=0;
		$ano_i=$datos_2['ANO'][0];
		while($ano_i<=$ano_actual){
			$datos['ANO'][$i]=$ano_i;
			$i++;
			$ano_i++;
		}
	}else{
		$i=0;
		$ano_i=$datos_1['ANO'][0];
		while($ano_i<=$ano_actual){
			$datos['ANO'][$i]=$ano_i;
			$i++;
			$ano_i++;
		}
	}
	return $datos;
}
//SECCIÓN GANANCIAS TABLA DE LA TERCERA PARTE
function M_indicadores_R_graf_3_invertido($conexion, $cedula_rif, $ano){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_compra_venta_de_micoin`.`FH_CONFIRMADO`)='$ano'";
	$sql_ced=($cedula_rif=="Todos") ? "" : "AND `mc_compra_venta_de_micoin`.`CEDULA_RIF`='$cedula_rif'";
	//consultando
	$consulta="SELECT 
	SUM(`mc_compra_venta_de_micoin`.`CANTIDAD_MICOIN`) as PEMONES, 
	SUM(`mc_compra_venta_de_micoin`.`MONTO_NETO`) as BOLIVARES 
	FROM `mc_compra_venta_de_micoin` 
	WHERE 1 
	AND `mc_compra_venta_de_micoin`.`ESTATUS`='CONFIRMADO' 
	AND `mc_compra_venta_de_micoin`.`TIPO_DE_TRANSACCION`='COMPRA' 
	$sql_ano 
	$sql_ced";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['PEMONES'][$i]='';
	$datos['BOLIVARES'][$i]='';
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['PEMONES'][$i]=$fila['PEMONES'];
		$datos['BOLIVARES'][$i]=$fila['BOLIVARES'];
	}
	return $datos;
}
function M_indicadores_R_graf_3_retirado($conexion, $cedula_rif, $ano){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_compra_venta_de_micoin`.`FH_CONFIRMADO`)='$ano'";
	$sql_ced=($cedula_rif=="Todos") ? "" : "AND `mc_compra_venta_de_micoin`.`CEDULA_RIF`='$cedula_rif'";
	//consultando
	$consulta="SELECT 
	SUM(`mc_compra_venta_de_micoin`.`CANTIDAD_MICOIN`) as PEMONES, 
	SUM(`mc_compra_venta_de_micoin`.`MONTO_NETO`) as BOLIVARES 
	FROM `mc_compra_venta_de_micoin` 
	WHERE 1 
	AND `mc_compra_venta_de_micoin`.`ESTATUS`='CONFIRMADO' 
	AND `mc_compra_venta_de_micoin`.`TIPO_DE_TRANSACCION`='VENTA' 
	$sql_ano 
	$sql_ced";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['PEMONES'][$i]='';
	$datos['BOLIVARES'][$i]='';
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['PEMONES'][$i]=$fila['PEMONES'];
		$datos['BOLIVARES'][$i]=$fila['BOLIVARES'];
	}
	return $datos;
}
function M_indicadores_R_graf_3_ganado($conexion, $cedula_rif, $ano){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$ano'";
	$sql_ced=($cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF`='$cedula_rif'";
	//consultando
	$consulta="SELECT 
	SUM(`mc_control_de_transacciones_micoin`.`MONTO_NETO`) as PEMONES 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 
	AND `mc_control_de_transacciones_micoin`.`ESTATUS`='ENTREGADO' 
	$sql_ano 
	$sql_ced";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['PEMONES'][$i]='';
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['PEMONES'][$i]=$fila['PEMONES'];
	}
	return $datos;
}
function M_indicadores_R_graf_3_gastado($conexion, $cedula_rif, $ano){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_control_de_transacciones_micoin`.`FH_ENTREGADO`)='$ano'";
	$sql_ced=($cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF`='$cedula_rif'";
	//consultando
	$consulta="SELECT 
	SUM(`mc_control_de_transacciones_micoin`.`MONTO_BRUTO_MICOIN`) as PEMONES 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 
	AND `mc_control_de_transacciones_micoin`.`ESTATUS`='ENTREGADO' 
	$sql_ano 
	$sql_ced";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['PEMONES'][$i]='';
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['PEMONES'][$i]=$fila['PEMONES'];
	}
	return $datos;
}
function M_indicadores_R_graf_3_rechazado_descuento($conexion, $cedula_rif, $ano){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_control_de_transacciones_micoin`.`FH_TRANSACCION_ABANDONADA`)='$ano'";
	$sql_ced=($cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF`='$cedula_rif'";
	//consultando
	$consulta="SELECT 
	SUM(`mc_control_de_transacciones_micoin`.`MONTO_COMISION`) as PEMONES 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 
	AND `mc_control_de_transacciones_micoin`.`ESTATUS`='ABANDONADO' 
	$sql_ano 
	$sql_ced";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['PEMONES'][$i]='';
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['PEMONES'][$i]=$fila['PEMONES'];
	}
	return $datos;
}
//SECCIÓN DE FILTROS PARA LA SEGUNDA PESTAÑA
function M_indicadores_R_ano_2($conexion, $vendedor_cedula_rif){
	//AGRUPA LOS AÑOS EXISTENTES PARA EL USUARIO VENDEDOR
	//armando pre-sql
	$sql_ced=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF`='$vendedor_cedula_rif'";
	//consultado
	$consulta="SELECT YEAR(`mc_control_de_transacciones_micoin`.`FH_EVALUACION`) AS ANO FROM `mc_control_de_transacciones_micoin` WHERE YEAR(`mc_control_de_transacciones_micoin`.`FH_EVALUACION`)<>'0' $sql_ced GROUP BY ANO ORDER BY ANO DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ANO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ANO'][$i]=$fila['ANO'];
		$i=$i+1;
	}
	return $datos;
}
function M_reputacion_por_usuario_mejores_evaluaciones($conexion, $cedula_rif, $ano){
	//DEVUELVE EL DETALLE DEL PUNTAJE DADO UN USUARIO
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`FH_EVALUACION`)='$ano'";
	$sql_ced=($cedula_rif=="Todos") ? "" : "AND `VENDEDOR_CEDULA_RIF`='$cedula_rif'";
	//consultado
	$consulta="SELECT * FROM `mc_control_de_transacciones_micoin` WHERE 1 AND `ESTATUS`='ENTREGADO' AND `EVALUACION_PUNTOS`>='3' $sql_ano $sql_ced GROUP BY `CODIGO_DE_SEGURIDAD` ORDER BY `EVALUACION_PUNTOS` DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['VENDEDOR_NOMBRE'][$i]='';
	$datos['VENDEDOR_APELLIDO'][$i]='';
	$datos['COMPRADOR_NOMBRE'][$i]='';
	$datos['COMPRADOR_APELLIDO'][$i]='';
	$datos['ESTATUS'][$i]='';
	$datos['FH_EVALUACION'][$i]='';
	$datos['EVALUACION_PUNTOS'][$i]='';
	$datos['EVALUACION_COMENTARIO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['VENDEDOR_NOMBRE'][$i]=$fila['VENDEDOR_NOMBRE'];
		$datos['VENDEDOR_APELLIDO'][$i]=$fila['VENDEDOR_APELLIDO'];
		$datos['COMPRADOR_NOMBRE'][$i]=$fila['COMPRADOR_NOMBRE'];
		$datos['COMPRADOR_APELLIDO'][$i]=$fila['COMPRADOR_APELLIDO'];
		$datos['ESTATUS'][$i]=$fila['ESTATUS'];
		$datos['FH_EVALUACION'][$i]=$fila['FH_EVALUACION'];
		$datos['EVALUACION_PUNTOS'][$i]=$fila['EVALUACION_PUNTOS'];
		$datos['EVALUACION_COMENTARIO'][$i]=$fila['EVALUACION_COMENTARIO'];
		$i=$i+1;
	}
	return $datos;
}
function M_reputacion_por_usuario_peores_evaluaciones($conexion, $cedula_rif, $ano){
	//DEVUELVE EL DETALLE DEL PUNTAJE DADO UN USUARIO
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`FH_EVALUACION`)='$ano'";
	$sql_ced=($cedula_rif=="Todos") ? "" : "AND `VENDEDOR_CEDULA_RIF`='$cedula_rif'";
	//consultado
	$consulta="SELECT * FROM `mc_control_de_transacciones_micoin` WHERE 1 AND `EVALUACION_PUNTOS`<'3' AND `FH_EVALUACION`<>'0000-00-00 00:00:00' $sql_ano $sql_ced GROUP BY `CODIGO_DE_SEGURIDAD` ORDER BY `EVALUACION_PUNTOS`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['VENDEDOR_NOMBRE'][$i]='';
	$datos['VENDEDOR_APELLIDO'][$i]='';
	$datos['COMPRADOR_NOMBRE'][$i]='';
	$datos['COMPRADOR_APELLIDO'][$i]='';
	$datos['ESTATUS'][$i]='';
	$datos['FH_EVALUACION'][$i]='';
	$datos['EVALUACION_PUNTOS'][$i]='';
	$datos['EVALUACION_COMENTARIO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['VENDEDOR_NOMBRE'][$i]=$fila['VENDEDOR_NOMBRE'];
		$datos['VENDEDOR_APELLIDO'][$i]=$fila['VENDEDOR_APELLIDO'];
		$datos['COMPRADOR_NOMBRE'][$i]=$fila['COMPRADOR_NOMBRE'];
		$datos['COMPRADOR_APELLIDO'][$i]=$fila['COMPRADOR_APELLIDO'];
		$datos['ESTATUS'][$i]=$fila['ESTATUS'];
		$datos['FH_EVALUACION'][$i]=$fila['FH_EVALUACION'];
		$datos['EVALUACION_PUNTOS'][$i]=$fila['EVALUACION_PUNTOS'];
		$datos['EVALUACION_COMENTARIO'][$i]=$fila['EVALUACION_COMENTARIO'];
		$i=$i+1;
	}
	return $datos;
}
//SECCIÓN DE FILTROS Y GRAFICAS DE LA TERCERA PESTAÑA 1
function M_indicadores_R_ano_3($conexion, $vendedor_cedula_rif){
	//AGRUPA LOS AÑOS EXISTENTES PARA EL USUARIO VENDEDOR
	//armando pre-sql
	$sql_ced=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	//consultado
	$consulta="SELECT YEAR(`FH_BUSQUEDA`) AS ANO FROM `mc_productos_buscados` INNER JOIN `mc_productos_y_servicios` ON `mc_productos_buscados`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` WHERE YEAR(`FH_BUSQUEDA`)<>'0' $sql_ced GROUP BY ANO ORDER BY ANO DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ANO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ANO'][$i]=$fila['ANO'];
		$i++;
	}
	return $datos;
}
function M_indicadores_R_productos_3($conexion, $vendedor_cedula_rif){
	//armando pre-sql
	$sql_ced=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	//consultado
	$consulta="SELECT `mc_productos_y_servicios`.`NOMBRE_PRODUCTO` AS NOMBRE_PRODUCTO, `mc_productos_buscados`.`ID_PRODUCTO` AS ID_PRODUCTO FROM `mc_productos_buscados` INNER JOIN `mc_productos_y_servicios` ON `mc_productos_buscados`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` WHERE 1 $sql_ced GROUP BY `NOMBRE_PRODUCTO` ORDER BY `NOMBRE_PRODUCTO`";
	$resultados=mysqli_query($conexion,$consulta);
	$o=0;
	$i=0;
	$datos['ID_PRODUCTO'][$i]='';
	$datos['NOMBRE_PRODUCTO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_PRODUCTO'][$i]=$fila['ID_PRODUCTO'];
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$i++;
	}
	return $datos;
}
function M_indicadores_R_clientes_3($conexion, $vendedor_cedula_rif){
	//armando pre-sql
	$sql_ced=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	//consultado
	$consulta="SELECT `mc_usuarios`.`ID_USUARIO` AS ID_USUARIO, `mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, `mc_usuarios`.`NOMBRE` AS NOMBRE, `mc_usuarios`.`APELLIDO` AS APELLIDO FROM `mc_productos_buscados` 
	INNER JOIN `mc_productos_y_servicios` ON `mc_productos_buscados`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_productos_buscados`.`ID_USUARIO`=`mc_usuarios`.`ID_USUARIO` 
	WHERE 1 $sql_ced GROUP BY `ID_USUARIO` ORDER BY `NOMBRE`, `APELLIDO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$i++;
	}
	return $datos;
}
function M_indicadores_R_vendedor_3($conexion, $vendedor_cedula_rif){
	//armando pre-sql
	$sql_ced=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	//consultado
	$consulta="SELECT `mc_usuarios`.`ID_USUARIO` AS ID_USUARIO, `mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, `mc_usuarios`.`NOMBRE` AS NOMBRE, `mc_usuarios`.`APELLIDO` AS APELLIDO FROM `mc_productos_buscados` 
	INNER JOIN `mc_productos_y_servicios` ON `mc_productos_buscados`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_productos_y_servicios`.`CEDULA_RIF`=`mc_usuarios`.`CEDULA_RIF` 
	WHERE 1 $sql_ced GROUP BY `ID_USUARIO` ORDER BY `NOMBRE`, `APELLIDO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$i++;
	}
	return $datos;
}
function M_indicadores_R_graf_3($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_productos_buscados`.`FH_BUSQUEDA`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_productos_buscados`.`ID_USUARIO`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_productos_buscados`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	COUNT(case when MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='1' then `mc_productos_buscados`.`ID_PRODUCTO` end) as BUSQUEDAS_MES_1,
	COUNT(case when MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='2' then `mc_productos_buscados`.`ID_PRODUCTO` end) as BUSQUEDAS_MES_2,
	COUNT(case when MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='3' then `mc_productos_buscados`.`ID_PRODUCTO` end) as BUSQUEDAS_MES_3,
	COUNT(case when MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='4' then `mc_productos_buscados`.`ID_PRODUCTO` end) as BUSQUEDAS_MES_4,
	COUNT(case when MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='5' then `mc_productos_buscados`.`ID_PRODUCTO` end) as BUSQUEDAS_MES_5,
	COUNT(case when MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='6' then `mc_productos_buscados`.`ID_PRODUCTO` end) as BUSQUEDAS_MES_6,
	COUNT(case when MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='7' then `mc_productos_buscados`.`ID_PRODUCTO` end) as BUSQUEDAS_MES_7,
	COUNT(case when MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='8' then `mc_productos_buscados`.`ID_PRODUCTO` end) as BUSQUEDAS_MES_8,
	COUNT(case when MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='9' then `mc_productos_buscados`.`ID_PRODUCTO` end) as BUSQUEDAS_MES_9,
	COUNT(case when MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='10' then `mc_productos_buscados`.`ID_PRODUCTO` end) as BUSQUEDAS_MES_10,
	COUNT(case when MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='11' then `mc_productos_buscados`.`ID_PRODUCTO` end) as BUSQUEDAS_MES_11,
	COUNT(case when MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='12' then `mc_productos_buscados`.`ID_PRODUCTO` end) as BUSQUEDAS_MES_12 
	FROM `mc_productos_buscados` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_productos_buscados`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_productos_buscados`.`ID_USUARIO`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod";
	$resultados=mysqli_query($conexion,$consulta);
	$i=1;
	while($i<13){
		$datos['BUSQUEDAS_MES_' . $i][0]=0;
		$datos['TOTAL_BUSQUEDAS'][0]=0;
		$i=$i+1;
	}
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['BUSQUEDAS_MES_1'][0]=$fila['BUSQUEDAS_MES_1'];
		$datos['TOTAL_BUSQUEDAS'][0]=$fila['BUSQUEDAS_MES_1'];
		if($ano_hoy>$ano){
			$i=2;
			while($i<13){
				$datos['BUSQUEDAS_MES_' . $i][0]=$fila['BUSQUEDAS_MES_' . $i];
				$datos['TOTAL_BUSQUEDAS'][0]=$datos['TOTAL_BUSQUEDAS'][0] + $fila['BUSQUEDAS_MES_' . $i];
				$i=$i+1;
			}
		}else{
			$i=2;
			while($i<13){
				$datos['BUSQUEDAS_MES_' . $i][0]=($mes_hoy>($i-1)) ? $fila['BUSQUEDAS_MES_' . $i] : "null";
				$datos['TOTAL_BUSQUEDAS'][0]=$datos['TOTAL_BUSQUEDAS'][0] + $fila['BUSQUEDAS_MES_' . $i];
				$i=$i+1;
			}
		}
	}
	return $datos;
}
function M_indicadores_R_graf_3_torta_categorias($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_productos_buscados`.`FH_BUSQUEDA`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_productos_buscados`.`ID_USUARIO`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_productos_buscados`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	`mc_productos_y_servicios`.`NOMBRE_CATEGORIA` AS NOMBRE_CATEGORIA, 
	COUNT(`mc_productos_buscados`.`ID_PRODUCTO`) AS TOTAL_BUSQUEDAS 
	FROM `mc_productos_buscados` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_productos_buscados`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_productos_buscados`.`ID_USUARIO`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod GROUP BY NOMBRE_CATEGORIA ORDER BY NOMBRE_CATEGORIA";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['NOMBRE_CATEGORIA'][$i]='';
	$datos['TOTAL_BUSQUEDAS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['NOMBRE_CATEGORIA'][$i]=$fila['NOMBRE_CATEGORIA'];
		$datos['TOTAL_BUSQUEDAS'][$i]=$fila['TOTAL_BUSQUEDAS'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_graf_3_torta_edades($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_productos_buscados`.`FH_BUSQUEDA`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_productos_buscados`.`ID_USUARIO`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_productos_buscados`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$ano_20=$ano_hoy-20;
	$ano_30=$ano_hoy-30;
	$ano_40=$ano_hoy-40;
	$ano_50=$ano_hoy-50;
	$consulta="SELECT 
	COUNT(case when YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_20' then `mc_productos_buscados`.`ID_PRODUCTO` end) as MENOS_DE_20, 
	COUNT(case when (YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_20' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_30') then `mc_productos_buscados`.`ID_PRODUCTO` end) as MENOS_DE_30, 
	COUNT(case when (YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_30' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_40') then `mc_productos_buscados`.`ID_PRODUCTO` end) as MENOS_DE_40, 
	COUNT(case when (YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_40' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_50') then `mc_productos_buscados`.`ID_PRODUCTO` end) as MENOS_DE_50, 
	COUNT(case when YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_50' then `mc_productos_buscados`.`ID_PRODUCTO` end) as MAS_DE_50 
	FROM `mc_productos_buscados` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_productos_buscados`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_productos_buscados`.`ID_USUARIO`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['MENOS_DE_20'][$i]='';
	$datos['MENOS_DE_30'][$i]='';
	$datos['MENOS_DE_40'][$i]='';
	$datos['MENOS_DE_50'][$i]='';
	$datos['MAS_DE_50'][$i]='';
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['MENOS_DE_20'][$i]=$fila['MENOS_DE_20'];
		$datos['MENOS_DE_30'][$i]=$fila['MENOS_DE_30'];
		$datos['MENOS_DE_40'][$i]=$fila['MENOS_DE_40'];
		$datos['MENOS_DE_50'][$i]=$fila['MENOS_DE_50'];
		$datos['MAS_DE_50'][$i]=$fila['MAS_DE_50'];
	}
	return $datos;
}
function M_indicadores_R_graf_3_torta_clientes($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_productos_buscados`.`FH_BUSQUEDA`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_productos_buscados`.`ID_USUARIO`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_productos_buscados`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	`mc_usuarios`.`ID_USUARIO` AS ID_USUARIO, 
	`mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, 
	`mc_usuarios`.`NOMBRE` AS NOMBRE, 
	`mc_usuarios`.`APELLIDO` AS APELLIDO, 
	COUNT(`mc_productos_buscados`.`ID_PRODUCTO`) AS TOTAL_BUSQUEDAS 
	FROM `mc_productos_buscados` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_productos_buscados`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_productos_buscados`.`ID_USUARIO`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod GROUP BY ID_USUARIO ORDER BY NOMBRE, APELLIDO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['TOTAL_BUSQUEDAS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['TOTAL_BUSQUEDAS'][$i]=$fila['TOTAL_BUSQUEDAS'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_graf_3_torta_productos($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_productos_buscados`.`FH_BUSQUEDA`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_productos_buscados`.`ID_USUARIO`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_productos_buscados`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	`mc_productos_y_servicios`.`NOMBRE_PRODUCTO` AS NOMBRE_PRODUCTO, 
	COUNT(`mc_productos_buscados`.`ID_PRODUCTO`) AS TOTAL_BUSQUEDAS 
	FROM `mc_productos_buscados` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_productos_buscados`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_productos_buscados`.`ID_USUARIO`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod GROUP BY NOMBRE_PRODUCTO ORDER BY NOMBRE_PRODUCTO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['NOMBRE_PRODUCTO'][$i]='';
	$datos['TOTAL_BUSQUEDAS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$datos['TOTAL_BUSQUEDAS'][$i]=$fila['TOTAL_BUSQUEDAS'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_graf_3_torta_vendedores($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_productos_buscados`.`FH_BUSQUEDA`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_productos_buscados`.`FH_BUSQUEDA`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_productos_buscados`.`ID_USUARIO`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_productos_buscados`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	`mc_usuarios`.`ID_USUARIO` AS ID_USUARIO, 
	`mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, 
	`mc_usuarios`.`NOMBRE` AS NOMBRE, 
	`mc_usuarios`.`APELLIDO` AS APELLIDO, 
	COUNT(`mc_productos_buscados`.`ID_PRODUCTO`) AS TOTAL_BUSQUEDAS 
	FROM `mc_productos_buscados` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_productos_buscados`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_productos_y_servicios`.`CEDULA_RIF`=`mc_usuarios`.`CEDULA_RIF`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod GROUP BY ID_USUARIO ORDER BY NOMBRE, APELLIDO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['TOTAL_BUSQUEDAS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['TOTAL_BUSQUEDAS'][$i]=$fila['TOTAL_BUSQUEDAS'];
		$i=$i+1;
	}
	return $datos;
}
//SECCIÓN DE FILTROS Y GRAFICAS DE LA TERCERA PESTAÑA 2
function M_indicadores_R_ano_4($conexion, $vendedor_cedula_rif){
	//AGRUPA LOS AÑOS EXISTENTES PARA EL USUARIO VENDEDOR
	//armando pre-sql
	$sql_ced=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$consulta="SELECT YEAR(`FH_VISTO`) AS ANO FROM `mc_productos_vitos` INNER JOIN `mc_productos_y_servicios` ON `mc_productos_vitos`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` WHERE 1 AND YEAR(`FH_VISTO`)<>'0' $sql_ced GROUP BY ANO ORDER BY ANO DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ANO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ANO'][$i]=$fila['ANO'];
		$i++;
	}
	return $datos;
}
function M_indicadores_R_productos_4($conexion, $vendedor_cedula_rif){
	$sql_ced=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$consulta="SELECT `mc_productos_y_servicios`.`NOMBRE_PRODUCTO` AS NOMBRE_PRODUCTO, `mc_productos_vitos`.`ID_PRODUCTO` AS ID_PRODUCTO FROM `mc_productos_vitos` INNER JOIN `mc_productos_y_servicios` ON `mc_productos_vitos`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` WHERE 1 $sql_ced GROUP BY `NOMBRE_PRODUCTO` ORDER BY `NOMBRE_PRODUCTO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_PRODUCTO'][$i]='';
	$datos['NOMBRE_PRODUCTO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_PRODUCTO'][$i]=$fila['ID_PRODUCTO'];
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$i++;
	}
	return $datos;
}
function M_indicadores_R_clientes_4($conexion, $vendedor_cedula_rif){
	$sql_ced=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$consulta="SELECT `mc_usuarios`.`ID_USUARIO` AS ID_USUARIO, `mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, `mc_usuarios`.`NOMBRE` AS NOMBRE, `mc_usuarios`.`APELLIDO` AS APELLIDO FROM `mc_productos_vitos` 
	INNER JOIN `mc_productos_y_servicios` ON `mc_productos_vitos`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_productos_vitos`.`ID_USUARIO`=`mc_usuarios`.`ID_USUARIO` 
	WHERE 1 $sql_ced GROUP BY `ID_USUARIO` ORDER BY `NOMBRE`, `APELLIDO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$i++;
	}
	return $datos;
}
function M_indicadores_R_vendedor_4($conexion, $vendedor_cedula_rif){
	//armando pre-sql
	$sql_ced=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	//consultado
	$consulta="SELECT `mc_usuarios`.`ID_USUARIO` AS ID_USUARIO, `mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, `mc_usuarios`.`NOMBRE` AS NOMBRE, `mc_usuarios`.`APELLIDO` AS APELLIDO FROM `mc_productos_vitos` 
	INNER JOIN `mc_productos_y_servicios` ON `mc_productos_vitos`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_productos_y_servicios`.`CEDULA_RIF`=`mc_usuarios`.`CEDULA_RIF` 
	WHERE 1 $sql_ced GROUP BY `ID_USUARIO` ORDER BY `NOMBRE`, `APELLIDO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$i++;
	}
	return $datos;
}
function M_indicadores_R_graf_4($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_productos_vitos`.`FH_VISTO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_productos_vitos`.`FH_VISTO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_productos_vitos`.`ID_USUARIO`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_productos_vitos`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	COUNT(case when MONTH(`mc_productos_vitos`.`FH_VISTO`)='1' then `mc_productos_vitos`.`ID_PRODUCTO` end) as VISTAS_MES_1,
	COUNT(case when MONTH(`mc_productos_vitos`.`FH_VISTO`)='2' then `mc_productos_vitos`.`ID_PRODUCTO` end) as VISTAS_MES_2,
	COUNT(case when MONTH(`mc_productos_vitos`.`FH_VISTO`)='3' then `mc_productos_vitos`.`ID_PRODUCTO` end) as VISTAS_MES_3,
	COUNT(case when MONTH(`mc_productos_vitos`.`FH_VISTO`)='4' then `mc_productos_vitos`.`ID_PRODUCTO` end) as VISTAS_MES_4,
	COUNT(case when MONTH(`mc_productos_vitos`.`FH_VISTO`)='5' then `mc_productos_vitos`.`ID_PRODUCTO` end) as VISTAS_MES_5,
	COUNT(case when MONTH(`mc_productos_vitos`.`FH_VISTO`)='6' then `mc_productos_vitos`.`ID_PRODUCTO` end) as VISTAS_MES_6,
	COUNT(case when MONTH(`mc_productos_vitos`.`FH_VISTO`)='7' then `mc_productos_vitos`.`ID_PRODUCTO` end) as VISTAS_MES_7,
	COUNT(case when MONTH(`mc_productos_vitos`.`FH_VISTO`)='8' then `mc_productos_vitos`.`ID_PRODUCTO` end) as VISTAS_MES_8,
	COUNT(case when MONTH(`mc_productos_vitos`.`FH_VISTO`)='9' then `mc_productos_vitos`.`ID_PRODUCTO` end) as VISTAS_MES_9,
	COUNT(case when MONTH(`mc_productos_vitos`.`FH_VISTO`)='10' then `mc_productos_vitos`.`ID_PRODUCTO` end) as VISTAS_MES_10,
	COUNT(case when MONTH(`mc_productos_vitos`.`FH_VISTO`)='11' then `mc_productos_vitos`.`ID_PRODUCTO` end) as VISTAS_MES_11,
	COUNT(case when MONTH(`mc_productos_vitos`.`FH_VISTO`)='12' then `mc_productos_vitos`.`ID_PRODUCTO` end) as VISTAS_MES_12 
	FROM `mc_productos_vitos` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_productos_vitos`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_productos_vitos`.`ID_USUARIO`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod";
	$resultados=mysqli_query($conexion,$consulta);
	$i=1;
	while($i<13){
		$datos['VISTAS_MES_' . $i][0]=0;
		$datos['TOTAL_VISTAS'][0]=0;
		$i=$i+1;
	}
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['VISTAS_MES_1'][0]=$fila['VISTAS_MES_1'];
		$datos['TOTAL_VISTAS'][0]=$fila['VISTAS_MES_1'];
		if($ano_hoy>$ano){
			$i=2;
			while($i<13){
				$datos['VISTAS_MES_' . $i][0]=$fila['VISTAS_MES_' . $i];
				$datos['TOTAL_VISTAS'][0]=$datos['TOTAL_VISTAS'][0] + $fila['VISTAS_MES_' . $i];
				$i=$i+1;
			}
		}else{
			$i=2;
			while($i<13){
				$datos['VISTAS_MES_' . $i][0]=($mes_hoy>($i-1)) ? $fila['VISTAS_MES_' . $i] : "null";
				$datos['TOTAL_VISTAS'][0]=$datos['TOTAL_VISTAS'][0] + $fila['VISTAS_MES_' . $i];
				$i=$i+1;
			}
		}
	}
	return $datos;
}
function M_indicadores_R_graf_4_torta_edades($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_productos_vitos`.`FH_VISTO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_productos_vitos`.`FH_VISTO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_productos_vitos`.`ID_USUARIO`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_productos_vitos`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$ano_20=$ano_hoy-20;
	$ano_30=$ano_hoy-30;
	$ano_40=$ano_hoy-40;
	$ano_50=$ano_hoy-50;
	$consulta="SELECT 
	COUNT(case when YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_20' then `mc_productos_vitos`.`ID_PRODUCTO` end) as MENOS_DE_20, 
	COUNT(case when (YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_20' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_30') then `mc_productos_vitos`.`ID_PRODUCTO` end) as MENOS_DE_30, 
	COUNT(case when (YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_30' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_40') then `mc_productos_vitos`.`ID_PRODUCTO` end) as MENOS_DE_40, 
	COUNT(case when (YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_40' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_50') then `mc_productos_vitos`.`ID_PRODUCTO` end) as MENOS_DE_50, 
	COUNT(case when YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_50' then `mc_productos_vitos`.`ID_PRODUCTO` end) as MAS_DE_50 
	FROM `mc_productos_vitos` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_productos_vitos`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_productos_vitos`.`ID_USUARIO`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['MENOS_DE_20'][$i]='';
	$datos['MENOS_DE_30'][$i]='';
	$datos['MENOS_DE_40'][$i]='';
	$datos['MENOS_DE_50'][$i]='';
	$datos['MAS_DE_50'][$i]='';
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['MENOS_DE_20'][$i]=$fila['MENOS_DE_20'];
		$datos['MENOS_DE_30'][$i]=$fila['MENOS_DE_30'];
		$datos['MENOS_DE_40'][$i]=$fila['MENOS_DE_40'];
		$datos['MENOS_DE_50'][$i]=$fila['MENOS_DE_50'];
		$datos['MAS_DE_50'][$i]=$fila['MAS_DE_50'];
	}
	return $datos;
}
function M_indicadores_R_graf_4_torta_clientes($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_productos_vitos`.`FH_VISTO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_productos_vitos`.`FH_VISTO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_productos_vitos`.`ID_USUARIO`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_productos_vitos`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	`mc_usuarios`.`ID_USUARIO` AS ID_USUARIO, 
	`mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, 
	`mc_usuarios`.`NOMBRE` AS NOMBRE, 
	`mc_usuarios`.`APELLIDO` AS APELLIDO, 
	COUNT(`mc_productos_vitos`.`ID_PRODUCTO`) AS TOTAL_VISTAS 
	FROM `mc_productos_vitos` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_productos_vitos`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_productos_vitos`.`ID_USUARIO`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod GROUP BY ID_USUARIO ORDER BY NOMBRE, APELLIDO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['TOTAL_VISTAS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['TOTAL_VISTAS'][$i]=$fila['TOTAL_VISTAS'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_graf_4_torta_productos($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_productos_vitos`.`FH_VISTO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_productos_vitos`.`FH_VISTO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_productos_vitos`.`ID_USUARIO`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_productos_vitos`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	`mc_productos_y_servicios`.`NOMBRE_PRODUCTO` AS NOMBRE_PRODUCTO, 
	COUNT(`mc_productos_vitos`.`ID_PRODUCTO`) AS TOTAL_VISTAS 
	FROM `mc_productos_vitos` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_productos_vitos`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_productos_vitos`.`ID_USUARIO`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod GROUP BY NOMBRE_PRODUCTO ORDER BY NOMBRE_PRODUCTO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['NOMBRE_PRODUCTO'][$i]='';
	$datos['TOTAL_VISTAS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$datos['TOTAL_VISTAS'][$i]=$fila['TOTAL_VISTAS'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_graf_4_torta_vendedores($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_productos_vitos`.`FH_VISTO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_productos_vitos`.`FH_VISTO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_productos_vitos`.`ID_USUARIO`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_productos_vitos`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	`mc_usuarios`.`ID_USUARIO` AS ID_USUARIO, 
	`mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, 
	`mc_usuarios`.`NOMBRE` AS NOMBRE, 
	`mc_usuarios`.`APELLIDO` AS APELLIDO, 
	COUNT(`mc_productos_vitos`.`ID_PRODUCTO`) AS TOTAL_VISTAS 
	FROM `mc_productos_vitos` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_productos_vitos`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_productos_y_servicios`.`CEDULA_RIF`=`mc_usuarios`.`CEDULA_RIF`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod GROUP BY NOMBRE_PRODUCTO ORDER BY NOMBRE_PRODUCTO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['TOTAL_VISTAS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['TOTAL_VISTAS'][$i]=$fila['TOTAL_VISTAS'];
		$i=$i+1;
	}
	return $datos;
}
//SECCIÓN DE FILTROS Y GRAFICAS DE LA TERCERA PESTAÑA 3
function M_indicadores_R_ano_5($conexion, $vendedor_cedula_rif){
	//AGRUPA LOS AÑOS EXISTENTES PARA EL USUARIO VENDEDOR
	$sql_ced=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$consulta="SELECT YEAR(`FH_AGREGADO`) AS ANO FROM `mc_carrito_compra` INNER JOIN `mc_productos_y_servicios` ON `mc_carrito_compra`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` WHERE 1 $sql_ced AND YEAR(`FH_AGREGADO`)<>'0' GROUP BY ANO ORDER BY ANO DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ANO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ANO'][$i]=$fila['ANO'];
		$i++;
	}
	return $datos;
}
function M_indicadores_R_productos_5($conexion, $vendedor_cedula_rif){
	$sql_ced=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$consulta="SELECT `mc_productos_y_servicios`.`NOMBRE_PRODUCTO` AS NOMBRE_PRODUCTO, `mc_carrito_compra`.`ID_PRODUCTO` AS ID_PRODUCTO FROM `mc_carrito_compra` INNER JOIN `mc_productos_y_servicios` ON `mc_carrito_compra`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` WHERE 1 $sql_ced GROUP BY `NOMBRE_PRODUCTO` ORDER BY `NOMBRE_PRODUCTO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_PRODUCTO'][$i]='';
	$datos['NOMBRE_PRODUCTO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_PRODUCTO'][$i]=$fila['ID_PRODUCTO'];
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$i++;
	}
	return $datos;
}
function M_indicadores_R_clientes_5($conexion, $vendedor_cedula_rif){
	$sql_ced=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$consulta="SELECT `mc_usuarios`.`ID_USUARIO` AS ID_USUARIO, `mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, `mc_usuarios`.`NOMBRE` AS NOMBRE, `mc_usuarios`.`APELLIDO` AS APELLIDO FROM `mc_carrito_compra` 
	INNER JOIN `mc_productos_y_servicios` ON `mc_carrito_compra`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_carrito_compra`.`ID_USUARIO`=`mc_usuarios`.`ID_USUARIO` 
	WHERE 1 $sql_ced GROUP BY `ID_USUARIO` ORDER BY `NOMBRE`, `APELLIDO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$i++;
	}
	return $datos;
}
function M_indicadores_R_vendedor_5($conexion, $vendedor_cedula_rif){
	//armando pre-sql
	$sql_ced=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	//consultado
	$consulta="SELECT `mc_usuarios`.`ID_USUARIO` AS ID_USUARIO, `mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, `mc_usuarios`.`NOMBRE` AS NOMBRE, `mc_usuarios`.`APELLIDO` AS APELLIDO FROM `mc_carrito_compra` 
	INNER JOIN `mc_productos_y_servicios` ON `mc_carrito_compra`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_productos_y_servicios`.`CEDULA_RIF`=`mc_usuarios`.`CEDULA_RIF` 
	WHERE 1 $sql_ced GROUP BY `ID_USUARIO` ORDER BY `NOMBRE`, `APELLIDO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$i++;
	}
	return $datos;
}
function M_indicadores_R_graf_5($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_carrito_compra`.`FH_AGREGADO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_carrito_compra`.`ID_USUARIO`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_carrito_compra`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	COUNT(case when MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='1' then `mc_carrito_compra`.`ID_PRODUCTO` end) as VISTAS_MES_1,
	COUNT(case when MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='2' then `mc_carrito_compra`.`ID_PRODUCTO` end) as VISTAS_MES_2,
	COUNT(case when MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='3' then `mc_carrito_compra`.`ID_PRODUCTO` end) as VISTAS_MES_3,
	COUNT(case when MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='4' then `mc_carrito_compra`.`ID_PRODUCTO` end) as VISTAS_MES_4,
	COUNT(case when MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='5' then `mc_carrito_compra`.`ID_PRODUCTO` end) as VISTAS_MES_5,
	COUNT(case when MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='6' then `mc_carrito_compra`.`ID_PRODUCTO` end) as VISTAS_MES_6,
	COUNT(case when MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='7' then `mc_carrito_compra`.`ID_PRODUCTO` end) as VISTAS_MES_7,
	COUNT(case when MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='8' then `mc_carrito_compra`.`ID_PRODUCTO` end) as VISTAS_MES_8,
	COUNT(case when MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='9' then `mc_carrito_compra`.`ID_PRODUCTO` end) as VISTAS_MES_9,
	COUNT(case when MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='10' then `mc_carrito_compra`.`ID_PRODUCTO` end) as VISTAS_MES_10,
	COUNT(case when MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='11' then `mc_carrito_compra`.`ID_PRODUCTO` end) as VISTAS_MES_11,
	COUNT(case when MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='12' then `mc_carrito_compra`.`ID_PRODUCTO` end) as VISTAS_MES_12 
	FROM `mc_carrito_compra` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_carrito_compra`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_carrito_compra`.`ID_USUARIO`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod";
	$resultados=mysqli_query($conexion,$consulta);
	$i=1;
	while($i<13){
		$datos['VISTAS_MES_' . $i][0]=0;
		$datos['TOTAL_VISTAS'][0]=0;
		$i=$i+1;
	}
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['VISTAS_MES_1'][0]=$fila['VISTAS_MES_1'];
		$datos['TOTAL_VISTAS'][0]=$fila['VISTAS_MES_1'];
		if($ano_hoy>$ano){
			$i=2;
			while($i<13){
				$datos['VISTAS_MES_' . $i][0]=$fila['VISTAS_MES_' . $i];
				$datos['TOTAL_VISTAS'][0]=$datos['TOTAL_VISTAS'][0] + $fila['VISTAS_MES_' . $i];
				$i=$i+1;
			}
		}else{
			$i=2;
			while($i<13){
				$datos['VISTAS_MES_' . $i][0]=($mes_hoy>($i-1)) ? $fila['VISTAS_MES_' . $i] : "null";
				$datos['TOTAL_VISTAS'][0]=$datos['TOTAL_VISTAS'][0] + $fila['VISTAS_MES_' . $i];
				$i=$i+1;
			}
		}
	}
	return $datos;
}
function M_indicadores_R_graf_5_torta_edades($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_carrito_compra`.`FH_AGREGADO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_carrito_compra`.`ID_USUARIO`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_carrito_compra`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$ano_20=$ano_hoy-20;
	$ano_30=$ano_hoy-30;
	$ano_40=$ano_hoy-40;
	$ano_50=$ano_hoy-50;
	$consulta="SELECT 
	COUNT(case when YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_20' then `mc_carrito_compra`.`ID_PRODUCTO` end) as MENOS_DE_20, 
	COUNT(case when (YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_20' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_30') then `mc_carrito_compra`.`ID_PRODUCTO` end) as MENOS_DE_30, 
	COUNT(case when (YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_30' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_40') then `mc_carrito_compra`.`ID_PRODUCTO` end) as MENOS_DE_40, 
	COUNT(case when (YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_40' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_50') then `mc_carrito_compra`.`ID_PRODUCTO` end) as MENOS_DE_50, 
	COUNT(case when YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_50' then `mc_carrito_compra`.`ID_PRODUCTO` end) as MAS_DE_50 
	FROM `mc_carrito_compra` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_carrito_compra`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_carrito_compra`.`ID_USUARIO`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['MENOS_DE_20'][$i]='';
	$datos['MENOS_DE_30'][$i]='';
	$datos['MENOS_DE_40'][$i]='';
	$datos['MENOS_DE_50'][$i]='';
	$datos['MAS_DE_50'][$i]='';
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['MENOS_DE_20'][$i]=$fila['MENOS_DE_20'];
		$datos['MENOS_DE_30'][$i]=$fila['MENOS_DE_30'];
		$datos['MENOS_DE_40'][$i]=$fila['MENOS_DE_40'];
		$datos['MENOS_DE_50'][$i]=$fila['MENOS_DE_50'];
		$datos['MAS_DE_50'][$i]=$fila['MAS_DE_50'];
	}
	return $datos;
}
function M_indicadores_R_graf_5_torta_clientes($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_carrito_compra`.`FH_AGREGADO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_carrito_compra`.`ID_USUARIO`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_carrito_compra`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	`mc_usuarios`.`ID_USUARIO` AS ID_USUARIO, 
	`mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, 
	`mc_usuarios`.`NOMBRE` AS NOMBRE, 
	`mc_usuarios`.`APELLIDO` AS APELLIDO, 
	COUNT(`mc_carrito_compra`.`ID_PRODUCTO`) AS TOTAL_VISTAS 
	FROM `mc_carrito_compra` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_carrito_compra`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_carrito_compra`.`ID_USUARIO`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod GROUP BY ID_USUARIO ORDER BY NOMBRE, APELLIDO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['TOTAL_VISTAS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['TOTAL_VISTAS'][$i]=$fila['TOTAL_VISTAS'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_graf_5_torta_productos($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_carrito_compra`.`FH_AGREGADO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_carrito_compra`.`ID_USUARIO`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_carrito_compra`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	`mc_productos_y_servicios`.`NOMBRE_PRODUCTO` AS NOMBRE_PRODUCTO, 
	COUNT(`mc_carrito_compra`.`ID_PRODUCTO`) AS TOTAL_VISTAS 
	FROM `mc_carrito_compra` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_carrito_compra`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_carrito_compra`.`ID_USUARIO`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod GROUP BY NOMBRE_PRODUCTO ORDER BY NOMBRE_PRODUCTO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['NOMBRE_PRODUCTO'][$i]='';
	$datos['TOTAL_VISTAS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$datos['TOTAL_VISTAS'][$i]=$fila['TOTAL_VISTAS'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_graf_5_torta_vendedores($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_carrito_compra`.`FH_AGREGADO`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_carrito_compra`.`FH_AGREGADO`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_carrito_compra`.`ID_USUARIO`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_carrito_compra`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	`mc_usuarios`.`ID_USUARIO` AS ID_USUARIO, 
	`mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, 
	`mc_usuarios`.`NOMBRE` AS NOMBRE, 
	`mc_usuarios`.`APELLIDO` AS APELLIDO, 
	COUNT(`mc_carrito_compra`.`ID_PRODUCTO`) AS TOTAL_VISTAS 
	FROM `mc_carrito_compra` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_carrito_compra`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_productos_y_servicios`.`CEDULA_RIF`=`mc_usuarios`.`CEDULA_RIF`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod GROUP BY NOMBRE_PRODUCTO ORDER BY NOMBRE_PRODUCTO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['TOTAL_VISTAS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['TOTAL_VISTAS'][$i]=$fila['TOTAL_VISTAS'];
		$i=$i+1;
	}
	return $datos;
}
//SECCIÓN DE FILTROS Y GRAFICAS DE LA CUARTA PESTAÑA 1
function M_indicadores_R_ano_6($conexion, $vendedor_cedula_rif){
	//AGRUPA LOS AÑOS EXISTENTES PARA EL USUARIO VENDEDOR
	$sql_ced=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$consulta="SELECT YEAR(`FH_PREGUNTA`) AS ANO FROM `mc_preguntas_al_vendedor` INNER JOIN `mc_productos_y_servicios` ON `mc_preguntas_al_vendedor`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` WHERE 1 $sql_ced AND YEAR(`FH_PREGUNTA`)<>'0' GROUP BY ANO ORDER BY ANO DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ANO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ANO'][$i]=$fila['ANO'];
		$i++;
	}
	return $datos;
}
function M_indicadores_R_productos_6($conexion, $vendedor_cedula_rif){
	$sql_ced=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$consulta="SELECT `mc_productos_y_servicios`.`NOMBRE_PRODUCTO` AS NOMBRE_PRODUCTO, `mc_preguntas_al_vendedor`.`ID_PRODUCTO` AS ID_PRODUCTO FROM `mc_preguntas_al_vendedor` INNER JOIN `mc_productos_y_servicios` ON `mc_preguntas_al_vendedor`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` WHERE 1 $sql_ced GROUP BY `NOMBRE_PRODUCTO` ORDER BY `NOMBRE_PRODUCTO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_PRODUCTO'][$i]='';
	$datos['NOMBRE_PRODUCTO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_PRODUCTO'][$i]=$fila['ID_PRODUCTO'];
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$i++;
	}
	return $datos;
}
function M_indicadores_R_clientes_6($conexion, $vendedor_cedula_rif){
	$sql_ced=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$consulta="SELECT `mc_usuarios`.`ID_USUARIO` AS ID_USUARIO, `mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, `mc_usuarios`.`NOMBRE` AS NOMBRE, `mc_usuarios`.`APELLIDO` AS APELLIDO FROM `mc_preguntas_al_vendedor` 
	INNER JOIN `mc_productos_y_servicios` ON `mc_preguntas_al_vendedor`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_preguntas_al_vendedor`.`ID_QUIEN_PREGUNTA`=`mc_usuarios`.`ID_USUARIO` 
	WHERE 1 $sql_ced GROUP BY `ID_USUARIO` ORDER BY `NOMBRE`, `APELLIDO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$i++;
	}
	return $datos;
}
function M_indicadores_R_vendedor_6($conexion, $vendedor_cedula_rif){
	//armando pre-sql
	$sql_ced=($vendedor_cedula_rif=="") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	//consultado
	$consulta="SELECT `mc_usuarios`.`ID_USUARIO` AS ID_USUARIO, `mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, `mc_usuarios`.`NOMBRE` AS NOMBRE, `mc_usuarios`.`APELLIDO` AS APELLIDO FROM `mc_preguntas_al_vendedor` 
	INNER JOIN `mc_productos_y_servicios` ON `mc_preguntas_al_vendedor`.`ID_PRODUCTO`=`mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_preguntas_al_vendedor`.`ID_QUIEN_PREGUNTA`=`mc_usuarios`.`ID_USUARIO` 
	WHERE 1 $sql_ced GROUP BY `ID_USUARIO` ORDER BY `CEDULA_RIF`, `NOMBRE`, `APELLIDO`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$i++;
	}
	return $datos;
}
function M_indicadores_R_graf_6($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_preguntas_al_vendedor`.`ID_QUIEN_PREGUNTA`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_preguntas_al_vendedor`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	COUNT(case when MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='1' then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as VISTAS_MES_1,
	COUNT(case when MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='2' then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as VISTAS_MES_2,
	COUNT(case when MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='3' then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as VISTAS_MES_3,
	COUNT(case when MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='4' then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as VISTAS_MES_4,
	COUNT(case when MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='5' then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as VISTAS_MES_5,
	COUNT(case when MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='6' then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as VISTAS_MES_6,
	COUNT(case when MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='7' then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as VISTAS_MES_7,
	COUNT(case when MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='8' then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as VISTAS_MES_8,
	COUNT(case when MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='9' then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as VISTAS_MES_9,
	COUNT(case when MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='10' then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as VISTAS_MES_10,
	COUNT(case when MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='11' then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as VISTAS_MES_11,
	COUNT(case when MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='12' then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as VISTAS_MES_12 
	FROM `mc_preguntas_al_vendedor` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_preguntas_al_vendedor`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_preguntas_al_vendedor`.`ID_QUIEN_PREGUNTA`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod";
	$resultados=mysqli_query($conexion,$consulta);
	$i=1;
	while($i<13){
		$datos['VISTAS_MES_' . $i][0]=0;
		$datos['TOTAL_VISTAS'][0]=0;
		$i=$i+1;
	}
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['VISTAS_MES_1'][0]=$fila['VISTAS_MES_1'];
		$datos['TOTAL_VISTAS'][0]=$fila['VISTAS_MES_1'];
		if($ano_hoy>$ano){
			$i=2;
			while($i<13){
				$datos['TOTAL_VISTAS'][0]=$datos['TOTAL_VISTAS'][0] + $fila['VISTAS_MES_' . $i];
				$datos['VISTAS_MES_' . $i][0]=$fila['VISTAS_MES_' . $i];
				$i=$i+1;
			}
		}else{
			$i=2;
			while($i<13){
				$datos['TOTAL_VISTAS'][0]=$datos['TOTAL_VISTAS'][0] + $fila['VISTAS_MES_' . $i];
				$datos['VISTAS_MES_' . $i][0]=($mes_hoy>($i-1)) ? $fila['VISTAS_MES_' . $i] : "null";
				$i=$i+1;
			}
		}
	}
	return $datos;
}
function M_indicadores_R_graf_6_torta_edades($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_preguntas_al_vendedor`.`ID_QUIEN_PREGUNTA`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_preguntas_al_vendedor`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$ano_20=$ano_hoy-20;
	$ano_30=$ano_hoy-30;
	$ano_40=$ano_hoy-40;
	$ano_50=$ano_hoy-50;
	$consulta="SELECT 
	COUNT(case when YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_20' then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as MENOS_DE_20, 
	COUNT(case when (YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_20' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_30') then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as MENOS_DE_30, 
	COUNT(case when (YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_30' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_40') then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as MENOS_DE_40, 
	COUNT(case when (YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_40' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_50') then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as MENOS_DE_50, 
	COUNT(case when YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_50' then `mc_preguntas_al_vendedor`.`ID_PRODUCTO` end) as MAS_DE_50 
	FROM `mc_preguntas_al_vendedor` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_preguntas_al_vendedor`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_preguntas_al_vendedor`.`ID_QUIEN_PREGUNTA`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['MENOS_DE_20'][$i]='';
	$datos['MENOS_DE_30'][$i]='';
	$datos['MENOS_DE_40'][$i]='';
	$datos['MENOS_DE_50'][$i]='';
	$datos['MAS_DE_50'][$i]='';
	if(($fila=mysqli_fetch_array($resultados))==true){
		$datos['MENOS_DE_20'][$i]=$fila['MENOS_DE_20'];
		$datos['MENOS_DE_30'][$i]=$fila['MENOS_DE_30'];
		$datos['MENOS_DE_40'][$i]=$fila['MENOS_DE_40'];
		$datos['MENOS_DE_50'][$i]=$fila['MENOS_DE_50'];
		$datos['MAS_DE_50'][$i]=$fila['MAS_DE_50'];
	}
	return $datos;
}
function M_indicadores_R_graf_6_torta_clientes($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_preguntas_al_vendedor`.`ID_QUIEN_PREGUNTA`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_preguntas_al_vendedor`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	`mc_usuarios`.`ID_USUARIO` AS ID_USUARIO, 
	`mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, 
	`mc_usuarios`.`NOMBRE` AS NOMBRE, 
	`mc_usuarios`.`APELLIDO` AS APELLIDO, 
	COUNT(`mc_preguntas_al_vendedor`.`ID_PRODUCTO`) AS TOTAL_VISTAS 
	FROM `mc_preguntas_al_vendedor` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_preguntas_al_vendedor`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_preguntas_al_vendedor`.`ID_QUIEN_PREGUNTA`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod GROUP BY ID_USUARIO ORDER BY NOMBRE, APELLIDO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['TOTAL_VISTAS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['TOTAL_VISTAS'][$i]=$fila['TOTAL_VISTAS'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_graf_6_torta_productos($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_preguntas_al_vendedor`.`ID_QUIEN_PREGUNTA`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_preguntas_al_vendedor`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	`mc_productos_y_servicios`.`NOMBRE_PRODUCTO` AS NOMBRE_PRODUCTO, 
	COUNT(`mc_preguntas_al_vendedor`.`ID_PRODUCTO`) AS TOTAL_VISTAS 
	FROM `mc_preguntas_al_vendedor` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_preguntas_al_vendedor`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_preguntas_al_vendedor`.`ID_QUIEN_PREGUNTA`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod GROUP BY NOMBRE_PRODUCTO ORDER BY NOMBRE_PRODUCTO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['NOMBRE_PRODUCTO'][$i]='';
	$datos['TOTAL_VISTAS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['NOMBRE_PRODUCTO'][$i]=$fila['NOMBRE_PRODUCTO'];
		$datos['TOTAL_VISTAS'][$i]=$fila['TOTAL_VISTAS'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_graf_6_torta_vendedores($conexion, $vendedor_cedula_rif, $ano, $mes, $edad, $id_cliente, $id_producto){
	//TRABAJANDO LA EDAD
	$ano_hoy=date("Y");
	$mes_hoy=date("m");
	if($edad=="Menos de 20"){
		$ano_i=$ano_hoy-20;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i'";
	}else if($edad=="21-30"){
		$ano_i_1=$ano_hoy-20;
		$ano_i_2=$ano_hoy-30;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="31-40"){
		$ano_i_1=$ano_hoy-30;
		$ano_i_2=$ano_hoy-40;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="41-50"){
		$ano_i_1=$ano_hoy-40;
		$ano_i_2=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i_1' AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)>='$ano_i_2'";
	}else if($edad=="Más de 50"){
		$ano_i=$ano_hoy-50;
		$edad_ii="AND YEAR(`mc_usuarios`.`FECHA_NACIMIENTO`)<'$ano_i'";
	}else{
		$edad_ii="";
	}
	//armando pre-sql
	$sql_ano=($ano=="Todos") ? "" : "AND YEAR(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='$ano'";
	$sql_mes=($mes=="Todos") ? "" : "AND MONTH(`mc_preguntas_al_vendedor`.`FH_PREGUNTA`)='$mes'";
	$sql_edad="$edad_ii";
	$sql_clie=($id_cliente=="Todos") ? "" : "AND `mc_preguntas_al_vendedor`.`ID_QUIEN_PREGUNTA`='$id_cliente'";
	$sql_vend=($vendedor_cedula_rif=="Todos") ? "" : "AND `mc_productos_y_servicios`.`CEDULA_RIF`='$vendedor_cedula_rif'";
	$sql_prod=($id_producto=="Todos") ? "" : "AND `mc_preguntas_al_vendedor`.`ID_PRODUCTO`='$id_producto'";
	//consultando
	$consulta="SELECT 
	`mc_usuarios`.`ID_USUARIO` AS ID_USUARIO, 
	`mc_usuarios`.`CEDULA_RIF` AS CEDULA_RIF, 
	`mc_usuarios`.`NOMBRE` AS NOMBRE, 
	`mc_usuarios`.`APELLIDO` AS APELLIDO, 
	COUNT(`mc_preguntas_al_vendedor`.`ID_PRODUCTO`) AS TOTAL_VISTAS 
	FROM `mc_preguntas_al_vendedor` 
	INNER JOIN `mc_productos_y_servicios` ON 
	`mc_preguntas_al_vendedor`.`ID_PRODUCTO`= `mc_productos_y_servicios`.`ID_PRODUCTO` 
	INNER JOIN `mc_usuarios` ON `mc_usuarios`.`ID_USUARIO`=`mc_preguntas_al_vendedor`.`ID_QUIEN_PREGUNTA`
	WHERE 1 
	$sql_ano 
	$sql_mes 
	$sql_edad 
	$sql_clie 
	$sql_vend 
	$sql_prod GROUP BY NOMBRE_PRODUCTO ORDER BY NOMBRE_PRODUCTO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_USUARIO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['TOTAL_VISTAS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_USUARIO'][$i]=$fila['ID_USUARIO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['TOTAL_VISTAS'][$i]=$fila['TOTAL_VISTAS'];
		$i=$i+1;
	}
	return $datos;
}
//SECCIÓN DE FILTROS Y GRAFICAS DE LA VISTA DE INDICADORES DEL ADMINISTRADOR
function M_indicadores_R_todos_los_compradores($conexion){
	//AGRUPA LOS COMPRADORES EXISTENTES PARA EL USUARIO VENDEDOR
	$consulta="SELECT 
	`mc_control_de_transacciones_micoin`.`COMPRADOR_CEDULA_RIF` AS CEDULA_RIF, 
	`mc_control_de_transacciones_micoin`.`COMPRADOR_NOMBRE` AS NOMBRE, 
	`mc_control_de_transacciones_micoin`.`COMPRADOR_APELLIDO` AS APELLIDO 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 
	GROUP BY CEDULA_RIF ORDER BY NOMBRE, APELLIDO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['NOMBRE_APELLIDO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['NOMBRE_APELLIDO'][$i]=$fila['NOMBRE'] . " " . $fila['APELLIDO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_todos_los_vendedores($conexion){
	//AGRUPA LOS COMPRADORES EXISTENTES PARA EL USUARIO VENDEDOR
	$consulta="SELECT 
	`mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF` AS CEDULA_RIF, 
	`mc_control_de_transacciones_micoin`.`VENDEDOR_NOMBRE` AS NOMBRE, 
	`mc_control_de_transacciones_micoin`.`VENDEDOR_APELLIDO` AS APELLIDO 
	FROM `mc_control_de_transacciones_micoin` 
	WHERE 1 
	GROUP BY CEDULA_RIF ORDER BY NOMBRE, APELLIDO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['NOMBRE_APELLIDO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['NOMBRE_APELLIDO'][$i]=$fila['NOMBRE'] . " " . $fila['APELLIDO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_todos_los_anos($conexion){
	//AGRUPA LOS AÑOS EXISTENTES PARA EL USUARIO VENDEDOR
	$consulta="SELECT YEAR(`FH_ENTREGADO`) AS ANO FROM `mc_control_de_transacciones_micoin` WHERE YEAR(`FH_ENTREGADO`)<>'0'  GROUP BY ANO ORDER BY ANO DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ANO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ANO'][$i]=$fila['ANO'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_todas_las_categorias($conexion){
	//AGRUPA LAS CATEGORIAS EXISTENTES PARA EL USUARIO VENDEDOR
	$consulta="SELECT `mc_productos_y_servicios`.`NOMBRE_CATEGORIA` AS CATEGORIA 
	FROM `mc_productos_y_servicios` 
	INNER JOIN `mc_control_de_transacciones_micoin` ON (`mc_productos_y_servicios`.`CEDULA_RIF`=`mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF` AND `mc_productos_y_servicios`.`NOMBRE_PRODUCTO`=`mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO`)
	WHERE 1 
	GROUP BY CATEGORIA ORDER BY CATEGORIA ASC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['CATEGORIA'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['CATEGORIA'][$i]=$fila['CATEGORIA'];
		$i=$i+1;
	}
	return $datos;
}
function M_indicadores_R_todas_las_etiquetas($conexion){
	//AGRUPA LAS ETIQUETAS EXISTENTES PARA EL USUARIO VENDEDOR
	$consulta="SELECT 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_1` AS ETIQUETA_1, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_2` AS ETIQUETA_2, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_3` AS ETIQUETA_3, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_4` AS ETIQUETA_4, 
	`mc_productos_y_servicios`.`NOMBRE_ETIQUETA_5` AS ETIQUETA_5 
	FROM `mc_productos_y_servicios` 
	INNER JOIN `mc_control_de_transacciones_micoin` ON 
	(`mc_productos_y_servicios`.`CEDULA_RIF`= `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF` AND `mc_productos_y_servicios`.`NOMBRE_PRODUCTO`=`mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO`) 
	WHERE 1 
	GROUP BY ETIQUETA_1, ETIQUETA_2, ETIQUETA_3, ETIQUETA_4, ETIQUETA_5 ORDER BY ETIQUETA_1, ETIQUETA_2, ETIQUETA_3, ETIQUETA_4, ETIQUETA_5";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ETIQUETA_1'][$i]='';
	$datos['ETIQUETA_2'][$i]='';
	$datos['ETIQUETA_3'][$i]='';
	$datos['ETIQUETA_4'][$i]='';
	$datos['ETIQUETA_5'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ETIQUETAS'][$i]=$fila['ETIQUETA_1'];
		$i=$i+1;
		$datos['ETIQUETAS'][$i]=$fila['ETIQUETA_2'];
		$i=$i+1;
		$datos['ETIQUETAS'][$i]=$fila['ETIQUETA_3'];
		$i=$i+1;
		$datos['ETIQUETAS'][$i]=$fila['ETIQUETA_4'];
		$i=$i+1;
		$datos['ETIQUETAS'][$i]=$fila['ETIQUETA_5'];
		$i=$i+1;
	}
	$resultado=array_unique($datos['ETIQUETAS']);
	$resultado=array_values($resultado);
	return $resultado;
}
function M_indicadores_R_todos_los_productos($conexion){
	//AGRUPA LOS PRODUCTOS EXISTENTES PARA EL USUARIO VENDEDOR
	$consulta="SELECT 
	`mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO` AS PRODUCTO 
	FROM `mc_productos_y_servicios` 
	INNER JOIN `mc_control_de_transacciones_micoin` ON 
	(`mc_productos_y_servicios`.`CEDULA_RIF`= `mc_control_de_transacciones_micoin`.`VENDEDOR_CEDULA_RIF` AND `mc_productos_y_servicios`.`NOMBRE_PRODUCTO`=`mc_control_de_transacciones_micoin`.`NOMBRE_PRODUCTO`) 
	WHERE 1 
	GROUP BY PRODUCTO ORDER BY PRODUCTO";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['PRODUCTO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['PRODUCTO'][$i]=$fila['PRODUCTO'];
		$i=$i+1;
	}
	return $datos;
}
?>