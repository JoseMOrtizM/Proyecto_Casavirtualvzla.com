<?php
require ("PHP_MODELO/M_todos.php");
require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php");
require('fpdf/fpdf.php');
//RESCATANDO AÑO
if(isset($_POST['ano_pdf'])){
	$ano=mysqli_real_escape_string($conexion,$_POST['ano_pdf']);
}else{
	$ano=date("Y");
}
//EXTRAYENDO INFORMACIÓN DE LA BASE DE DATOS
$datos=M_balance_administrativo_lcv_pdf($conexion, $ano);
//REALIZANDO CÁLCULOS NECESARIOS
//tablas resumen 1
$ing_venta_pm_bs=0;
$ing_venta_pm_usd=0;
$ing_compra_pm_bs=0;
$ing_compra_pm_usd=0;
$ing_prod_vendido_bs=0;
$ing_prod_vendido_usd=0;
$ing_prod_aband_bs=0;
$ing_prod_aband_usd=0;
$ing_venta_dollar_bs=0;
$ing_venta_dollar_usd=0;
$ing_compra_dollar_bs=0;
$ing_compra_dollar_usd=0;
$gastos_bs=0;
$gastos_usd=0;
$impuestos_bs=0;
$impuestos_usd=0;
$reinversion_bs=0;
$reinversion_usd=0;
$dividendos_bs=0;
$dividendos_usd=0;
$total_ingresos_bs=0;
$total_ingresos_usd=0;
$total_ganacia_neta_bs=0;
$total_ganacia_neta_usd=0;
//tablas resumen 2
$tc_bs_pm_c=0;
$tc_bs_pm_v=0;
$tc_pm_usd=0;
$tc_bs_usd=0;
$circ_mv=0;
$circ_bs=0;
$circ_usd=0;
$circ_usd_eqv=0;
//cuentas de operaciones
$cta_venta_pm=0;
$cta_compra_pm=0;
$cta_prod_vendido=0;
$cta_prod_aband=0;
$cta_venta_dollar_ing=0;
$cta_compra_dollar_ing=0;
$cta_venta_dollar_resp=0;
$cta_compra_dollar_resp=0;
$cta_gastos=0;
$cta_impuestos=0;
$cta_reinversion=0;
$cta_dividendos=0;
$cta_tasa_cambio=0;
$cta_ranking=0;
$cta_inventario=0;
//otros
$resp_venta_dollar_bs=0;
$resp_venta_dollar_usd=0;
$resp_compra_dollar_bs=0;
$resp_compra_dollar_usd=0;

$cta=0;
while(isset($datos['ID_ADM'][$cta])){
	if($datos['DGO_TIPO_DE_OPERACION'][$cta]=='COMPRA PM'){
		
		$ing_compra_pm_bs=$ing_compra_pm_bs+$datos['RP_IE_BS_PUROS'][$cta];
		$ing_compra_pm_usd=$ing_compra_pm_usd+$datos['RP_IE_DOLLAR_PUROS'][$cta];
		$cta_compra_pm++;
		
	}else if($datos['DGO_TIPO_DE_OPERACION'][$cta]=='VENTA PM'){
		
		$ing_venta_pm_bs=$ing_venta_pm_bs+$datos['RP_IE_BS_PUROS'][$cta];
		$ing_venta_pm_usd=$ing_venta_pm_usd+$datos['RP_IE_DOLLAR_PUROS'][$cta];
		$cta_venta_pm++;
		
	}else if($datos['DGO_TIPO_DE_OPERACION'][$cta]=='COMPRA PROD'){
		
		$ing_prod_vendido_bs=$ing_prod_vendido_bs+$datos['RP_IE_BS_PUROS'][$cta];
		$ing_prod_vendido_usd=$ing_prod_vendido_usd+$datos['RP_IE_DOLLAR_PUROS'][$cta];
		$cta_prod_vendido++;
		
	}else if($datos['DGO_TIPO_DE_OPERACION'][$cta]=='COMPRA DOLLAR RESPALDO'){
		
		$resp_compra_dollar_bs=$resp_compra_dollar_bs+$datos['RP_RES_MON_BS_PUROS'][$cta];
		$resp_compra_dollar_usd=$resp_compra_dollar_usd+$datos['RP_RES_MON_DOLLAR_PUROS'][$cta];
		$cta_compra_dollar_resp++;
		
	}else if($datos['DGO_TIPO_DE_OPERACION'][$cta]=='VENTA DOLLAR RESPALDO'){
		
		$resp_venta_dollar_bs=$resp_venta_dollar_bs+$datos['RP_RES_MON_BS_PUROS'][$cta];
		$resp_venta_dollar_usd=$resp_venta_dollar_usd+$datos['RP_RES_MON_DOLLAR_PUROS'][$cta];
		$cta_venta_dollar_resp++;
		
	}else if($datos['DGO_TIPO_DE_OPERACION'][$cta]=='COMPRA DOLLAR INGRESOS'){
		
		$ing_compra_dollar_bs=$ing_compra_dollar_bs+$datos['RP_IE_BS_PUROS'][$cta];
		$ing_compra_dollar_usd=$ing_compra_dollar_usd+$datos['RP_IE_DOLLAR_PUROS'][$cta];
		$cta_compra_dollar_ing++;
		
	}else if($datos['DGO_TIPO_DE_OPERACION'][$cta]=='VENTA DOLLAR INGRESOS'){
		
		$ing_venta_dollar_bs=$ing_venta_dollar_bs+$datos['RP_IE_BS_PUROS'][$cta];
		$ing_venta_dollar_usd=$ing_venta_dollar_usd+$datos['RP_IE_DOLLAR_PUROS'][$cta];
		$cta_venta_dollar_ing++;
		
	}else if($datos['DGO_TIPO_DE_OPERACION'][$cta]=='GASTO'){
		
		$gastos_bs=$gastos_bs+$datos['RP_IE_BS_PUROS'][$cta];
		$gastos_usd=$gastos_usd+$datos['RP_IE_DOLLAR_PUROS'][$cta];
		$cta_gastos++;
		
	}else if($datos['DGO_TIPO_DE_OPERACION'][$cta]=='PAGO DE IMPUESTO'){
		
		$impuestos_bs=$impuestos_bs+$datos['RP_IE_BS_PUROS'][$cta];
		$impuestos_usd=$impuestos_usd+$datos['RP_IE_DOLLAR_PUROS'][$cta];
		$cta_impuestos++;
		
	}else if($datos['DGO_TIPO_DE_OPERACION'][$cta]=='REINVERSION'){
		
		$reinversion_bs=$reinversion_bs+$datos['RP_IE_BS_PUROS'][$cta];
		$reinversion_usd=$reinversion_usd+$datos['RP_IE_DOLLAR_PUROS'][$cta];
		$cta_reinversion++;
		
	}else if($datos['DGO_TIPO_DE_OPERACION'][$cta]=='REPARTO DE DIVIDENDOS'){
		
		$dividendos_bs=$dividendos_bs+$datos['RP_IE_BS_PUROS'][$cta];
		$dividendos_usd=$dividendos_usd+$datos['RP_IE_DOLLAR_PUROS'][$cta];
		$cta_dividendos;
		
	}else if($datos['DGO_TIPO_DE_OPERACION'][$cta]=='ACTUALIZAR INVENTARIO'){
		
		$cta_inventario++;
		
	}else if($datos['DGO_TIPO_DE_OPERACION'][$cta]=='ACTUALIZAR RANKINGS'){
		
		$cta_ranking++;
		
	}else if($datos['DGO_TIPO_DE_OPERACION'][$cta]=='RECHAZAR COMPRA PROD PREMIUN'){
		
		$ing_prod_aband_bs=$ing_prod_aband_bs+$datos['RP_IE_BS_PUROS'][$cta];
		$ing_prod_aband_usd=$ing_prod_aband_usd+$datos['RP_IE_DOLLAR_PUROS'][$cta];
		$cta_prod_aband++;
		
	}else if($datos['DGO_TIPO_DE_OPERACION'][$cta]=='ACTUALIZAR TASA DE CAMBIO (Bs/$)'){
		
		$cta_tasa_cambio++;
		
	}
	//OBTENIENDO LAS TASAS DE CAMBIO AL CIERRE DEL AÑO
	if(!isset($datos['ID_ADM'][$cta+1])){
		$tc_bs_pm_c=$datos['TC_BS_PM_C'][$cta];
		$tc_bs_pm_v=$datos['TC_BS_PM_V'][$cta];
		$tc_pm_usd=$datos['TC_PM_DOLLAR'][$cta];
		$tc_bs_usd=$datos['TC_BS_DOLLAR'][$cta];
		$circ_mv=$datos['RA_RES_MON_CIRC'][$cta];
		$circ_bs=$datos['RA_RES_MON_BS_PUROS'][$cta];
		$circ_usd=$datos['RA_RES_MON_DOLLARES_PUROS'][$cta];
		$circ_usd_eqv=$datos['RA_RES_MON_DOLLARES_EQV'][$cta];
	}
	$cta++;
}
$total_ingresos_bs=$ing_venta_pm_bs+$ing_compra_pm_bs+$ing_prod_vendido_bs+$ing_prod_aband_bs+$ing_venta_dollar_bs+$ing_compra_dollar_bs;
$total_ingresos_usd=$ing_venta_pm_usd+$ing_compra_pm_usd+$ing_prod_vendido_usd+$ing_prod_aband_usd+$ing_venta_dollar_usd+$ing_compra_dollar_usd;
$total_ganacia_neta_bs=$total_ingresos_bs+$gastos_bs+$impuestos_bs+$reinversion_bs+$dividendos_bs;
$total_ganacia_neta_usd=$total_ingresos_usd+$gastos_usd+$impuestos_usd+$reinversion_usd+$dividendos_usd;
//ingresos años anteriores
$emp_ingreso_bs_ant=$datos['RA_IE_BS_PUROS'][0]-$datos['RP_IE_BS_PUROS'][0];
$emp_ingreso_usd_ant=$datos['RA_IE_DOLLARES_PUROS'][0]-$datos['RP_IE_DOLLAR_PUROS'][0];
$emp_ingreso_usd_eqv_ant=($emp_ingreso_bs_ant/$datos['TC_BS_DOLLAR'][0]) + $emp_ingreso_usd_ant;

//EXTRAYENDO DATOS DE USUARIOS
$usuarios=M_usuarios_R($conexion, '', '', '', '', '', '');
//CUENTAS USUARIOS
$cta_usuarios=0;
$cta_usuarios_activos=0;
$cta_usuarios_otros=0;
$cta_usuarios_hierro=0;
$cta_usuarios_plata=0;
$cta_usuarios_oro=0;
$cta_usuarios_platino=0;
$cta_usuarios_diamante=0;

$cta=0;
while(isset($usuarios['ID_USUARIO'][$cta])){
	if($usuarios['ESTATUS'][$cta]=='ACTIVO'){
		$cta_usuarios_activos++;
	}
	if($usuarios['RANKING'][$cta]=='HIERRO' and $usuarios['ESTATUS'][$cta]=='ACTIVO'){
		$cta_usuarios_hierro++;
	}
	if($usuarios['RANKING'][$cta]=='PLATA' and $usuarios['ESTATUS'][$cta]=='ACTIVO'){
		$cta_usuarios_plata++;
	}
	if($usuarios['RANKING'][$cta]=='ORO' and $usuarios['ESTATUS'][$cta]=='ACTIVO'){
		$cta_usuarios_oro++;
	}
	if($usuarios['RANKING'][$cta]=='PLATINO' and $usuarios['ESTATUS'][$cta]=='ACTIVO'){
		$cta_usuarios_platino++;
	}
	if($usuarios['RANKING'][$cta]=='DIAMANTE' and $usuarios['ESTATUS'][$cta]=='ACTIVO'){
		$cta_usuarios_diamante++;
	}
	$cta++;
}
$cta_usuarios_otros=$cta-$cta_usuarios_activos;

//EXTRAYENDO DATOS DE PRODUCTOS
$productos=M_contar_productos($conexion);

/////////// ---- INICIO DE DOCUMENTO PDF ---------  ///////////
class pdf extends FPDF{
	// Cabecera de página
	function Header(){
		// imprimiendo imagen
		$this->Image('img/logo_pdf.png',10,5,190);
		// Salto de línea
		$this->Ln(18);
	}
	// Pie de página
	function Footer(){
		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Número de página
		$this->Cell(0,10,utf8_decode('Maturín, ' . date('d-m-Y') . ' // Página ') . $this->PageNo() . ' de {nb}',0,0,'C');
	}
}
//CREANDO LA INSTANCIA FPDF
$pdf = new PDF();
$pdf->AliasNbPages();
//--------------------------------------------//
//IMPRIMIENDO PAGINA 1
$pdf->AddPage();
$pdf->SetFont('Arial','BU',14);
$pdf->Cell(190,10,utf8_decode('BALANCE ADMINITRATIVO DEL AÑO ' . $ano . ':'), false,0,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(190,5,utf8_decode('Durante el año ' . $ano . ' la empresa generó ingresos por Bs ' . number_format($total_ingresos_bs, 2,',','.') . ' y $ ' . number_format($total_ingresos_usd, 2,',','.') . ', los cuales luego de Gastos, pago de impuestos entre otros, se convirtieron en una ganancia neta Bs ' . number_format($total_ganacia_neta_bs, 2,',','.') . ' y $ ' . number_format($total_ganacia_neta_usd, 2,',','.') . '.

Asimismo, la moneda virtual Pemón alcanzó un valor de Bs/Pm ' . number_format($tc_bs_pm_c, 2,',','.') . ' para la Compra y Bs/Pm ' . number_format($tc_bs_pm_v, 2,',','.') . ' para la Venta (Pm/$ ' . number_format($tc_pm_usd, 2,',','.') . '), valores que se obtienen por un total de moneda virtual circulante de ' . number_format($circ_mv, 2,',','.') . ' respaldada por Bs ' . number_format($circ_bs, 2,',','.') . ' y $ ' . number_format($circ_usd, 2,',','.') . ' los cuales a una tasa de cambio de Bs/$ ' . number_format($tc_bs_usd, 2,',','.') . ' representan $ equiv ' . number_format($circ_usd_eqv, 2,',','.') . '. Los resultados de este balance se muestran a continuación:'), false);
$pdf->Ln();
//TABLA RESUMEN EMPRESA
//TÍTULO DE LA TABLA
$pdf->SetFont('Arial','B',11);
$pdf->SetFillColor(0,0,120);//Fondo de celda
$pdf->SetTextColor(255,255,255); //Letra color blanco
$pdf->Cell(190,5,utf8_decode("RESUMEN DEL BALANCE PARA LA EMPRESA"),1,0,'C', true);
$pdf->Ln();
//CONTENIDO DE LA TABLA
$pdf->SetFont('Arial','B',8);
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Venta de Pemones:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Bs ' . number_format($ing_venta_pm_bs, 2,',','.') . ' y $ ' . number_format($ing_venta_pm_usd, 2,',','.')),1,0,'R', true);
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Compra de Pemones:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Bs ' . number_format($ing_compra_pm_bs, 2,',','.') . ' y $ ' . number_format($ing_compra_pm_usd, 2,',','.')),1,0,'R', true);
$pdf->Ln();
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Compra de Dollares:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Bs ' . number_format($ing_compra_dollar_bs, 2,',','.') . ' y $ ' . number_format($ing_compra_dollar_usd, 2,',','.')),1,0,'R', true);
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Venta de Dollares:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Bs ' . number_format($ing_venta_dollar_bs, 2,',','.') . ' y $ ' . number_format($ing_venta_dollar_usd, 2,',','.')),1,0,'R', true);
$pdf->Ln();
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Venta de Productos:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Bs ' . number_format($ing_prod_vendido_bs, 2,',','.') . ' y $ ' . number_format($ing_prod_vendido_usd, 2,',','.')),1,0,'R', true);
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Ventas de Prod. Abandonadas:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Bs ' . number_format($ing_prod_aband_bs, 2,',','.') . ' y $ ' . number_format($ing_prod_aband_usd, 2,',','.')),1,0,'R', true);
$pdf->Ln();
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Gastos:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Bs ' . number_format($gastos_bs, 2,',','.') . ' y $ ' . number_format($gastos_usd, 2,',','.')),1,0,'R', true);
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Pago de Impuestos:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Bs ' . number_format($impuestos_bs, 2,',','.') . ' y $ ' . number_format($impuestos_usd, 2,',','.')),1,0,'R', true);
$pdf->Ln();
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Reinversiones:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Bs ' . number_format($reinversion_bs, 2,',','.') . ' y $ ' . number_format($reinversion_usd, 2,',','.')),1,0,'R', true);
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Reparto de Dividendos:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Bs ' . number_format($dividendos_bs, 2,',','.') . ' y $ ' . number_format($dividendos_usd, 2,',','.')),1,0,'R', true);
$pdf->Ln();
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Total Ingresos:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Bs ' . number_format($total_ingresos_bs, 2,',','.') . ' y $ ' . number_format($total_ingresos_usd, 2,',','.')),1,0,'R', true);
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Total Ganancias Netas:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Bs ' . number_format($total_ganacia_neta_bs, 2,',','.') . ' y $ ' . number_format($total_ganacia_neta_usd, 2,',','.')),1,0,'R', true);
$pdf->Ln(6);
//TABLA RESUMEN MONEDA VIRTUAL
//TÍTULO DE LA TABLA
$pdf->SetFont('Arial','B',11);
$pdf->SetFillColor(120,0,0);//Fondo de celda
$pdf->SetTextColor(255,255,255); //Letra color blanco
$pdf->Cell(190,5,utf8_decode("RESUMEN DEL BALANCE PARA LA MONEDA VIRTUAL PEMÓN"),1,0,'C', true);
$pdf->Ln();
//CONTENIDO DE LA TABLA
$pdf->SetFont('Arial','B',8);
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Bolívares Puros:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Bs ' . number_format($circ_bs, 2,',','.')),1,0,'R', true);
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Dolares Puros:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('$ ' . number_format($circ_usd, 2,',','.')),1,0,'R', true);
$pdf->Ln();
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Pemones Circulantes:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Pm ' . number_format($circ_mv, 2,',','.')),1,0,'R', true);
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Dolares Equivalentes:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('$ ' . number_format($circ_usd_eqv, 2,',','.')),1,0,'R', true);
$pdf->Ln();
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Tasa de Cambio Bs/$:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Bs/$ ' . number_format($tc_bs_usd, 2,',','.')),1,0,'R', true);
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Tasa de Cambio Pm/$:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Pm/$ ' . number_format($tc_pm_usd, 2,',','.')),1,0,'R', true);
$pdf->Ln();
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Tasa de Cambio Bs/Pm C:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Bs/Pm ' . number_format($tc_bs_pm_c, 2,',','.')),1,0,'R', true);
$pdf->SetFillColor(150,150,150);//Fondo gris de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(47,5, utf8_decode('Tasa de Cambio Bs/Pm V:'),1,0,'L', true);
$pdf->SetFillColor(255,255,255);//Fondo blanco
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->CellFitSpace(48,5, utf8_decode('Bs/Pm ' . number_format($tc_bs_pm_v, 2,',','.')),1,0,'R', true);
$pdf->Ln();
$pdf->Ln();
//COMENTARIO FINAL
$pdf->SetFont('Arial','',11);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(190,5,utf8_decode('Durante este año se realizaron un total de:

- ' . $cta_compra_pm . ' Operaciones de Compra de Pemón.
- ' . $cta_venta_pm . ' Operaciones de Venta de Pemón.
- ' . $cta_prod_vendido . ' Operaciones de Compra de Productos.
- ' . $cta_prod_aband . ' Operaciones Abandonadas de Compra Productos.
- ' . $cta_compra_dollar_ing . ' Operaciones de Compra de dollares para los ingresos de la empresa.
- ' . $cta_venta_dollar_ing . ' Operaciones de Venta de dollares para los ingresos de la empresa.
- ' . $cta_compra_dollar_resp . ' Operaciones de Compra de dollares para respaldo del Pemón (Bs ' . number_format($resp_compra_dollar_bs, 2,',','.') . ' y $ ' . number_format($resp_compra_dollar_usd, 2,',','.') .').
- ' . $cta_venta_dollar_resp . ' Operaciones de Venta de dollares para respaldo del Pemón (Bs ' . number_format($resp_venta_dollar_bs, 2,',','.') . ' y $ ' . number_format($resp_venta_dollar_usd, 2,',','.') .').
- ' . $cta_tasa_cambio . ' Operaciones de Actualización de la tasa de Cambio Bs/$.
- ' . $cta_gastos . ' Operaciones de Gastos.
- ' . $cta_impuestos . ' Operaciones de Pago de Impuestos.
- ' . $cta_reinversion . ' Operaciones de Reinversión (Empresa => Pemón).
- ' . $cta_dividendos . ' Operaciones de Reparto de Dividendos.
- Se alcanzó un total de ' . $cta_usuarios_activos . ' Usuarios Activos y ' . $cta_usuarios_otros . ' en otras condiciones.
- ' . $cta_ranking . ' Operaciones de Actualización de Rankings de Vendedores.
- Usuarios Activos por Ranking: ' . $cta_usuarios_hierro . ' Hierro, ' . $cta_usuarios_plata . ' Plata, ' . $cta_usuarios_oro . ' Oro, ' . $cta_usuarios_platino . ' Platino y ' . $cta_usuarios_diamante . ' Diamante.
- ' . $cta_inventario . ' Operaciones de Actualización de Inventarios Virtuales.
- Existen ' . number_format($productos['PRODUCTOS'][0], 0,',','.') . ' Productos Publicados para los Usuarios Activos.

El detalle de cada operación se muestra cronológicamente en las pagínas anexas.'), false);

//IMPRIMIENDO PAGINA 2
$pdf->AddPage();
//TÍTULO DE LA TABLA
$pdf->SetFont('Arial','B',11);
$pdf->SetFillColor(120,0,0);//Fondo de celda
$pdf->SetTextColor(255,255,255); //Letra color blanco
$pdf->Cell(190,5,utf8_decode("DETALLE DEL BALANCE"),1,0,'C', true);
$pdf->Ln(6);
//renglón años anteriores
$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(0,0,150);//Fondo de celda
$pdf->SetTextColor(255,255,255); //Letra color blanco
$pdf->Cell(94,5,utf8_decode("Descripción"),1,0,'C', true);
$pdf->Cell(32,5,utf8_decode('Ing. Acum. Bs'),1,0,'C', true);
$pdf->Cell(32,5,utf8_decode('Ing. Acum. $'),1,0,'C', true);
$pdf->Cell(32,5,utf8_decode('Ing. Acum. $ Eqv'),1,0,'C', true);
$pdf->Ln();
$pdf->SetFont('Arial','',8);
$pdf->SetFillColor(190,190,190);//Fondo BLANCO de celda
$pdf->SetTextColor(0,0,0); //Letra color negro
$pdf->Cell(94,5,utf8_decode("INGRESOS AÑOS ANTERIORES"),1,0,'C', true);
$pdf->SetFillColor(250,250,250);//Fondo BLANCO de celda
$pdf->Cell(32,5,utf8_decode(number_format($emp_ingreso_bs_ant, 2,',','.')),1,0,'R', true);
$pdf->Cell(32,5,utf8_decode(number_format($emp_ingreso_usd_ant, 2,',','.')),1,0,'R', true);
$pdf->Cell(32,5,utf8_decode(number_format($emp_ingreso_usd_eqv_ant, 2,',','.')),1,0,'R', true);
$pdf->Ln(9);
$cta=0;
while(isset($datos['ID_ADM'][$cta])){
	//CONTENIDO DE LA TABLA
	//TRATANDO LA FECHA
	$fecha_imp=explode(" ", $datos['FH_REGISTRO'][$cta]);
	$pdf->SetFont('Arial','B',8);
	$pdf->SetFillColor(250,250,250);//Fondo BLANCO de celda
	$pdf->SetTextColor(0,0,0); //Letra color negro
	$pdf->MultiCell(190,5,utf8_decode('Operacion: ' . $datos['DGO_TIPO_DE_OPERACION'][$cta] . ' (' . $fecha_imp[0] . ') ' . $datos['DESCRIPCION'][$cta]),1, false);
	$pdf->SetFont('Arial','B',9);
	$pdf->SetFillColor(150,150,150);//Fondo de celda
	$pdf->SetTextColor(0,0,0); //Letra color blanco
	$pdf->Cell(38,5,utf8_decode("Paridades"),1,0,'C', true);
	$pdf->Cell(38,5,utf8_decode("Ingreso Puntual"),1,0,'C', true);
	$pdf->Cell(38,5,utf8_decode("Ingreso Acumulado"),1,0,'C', true);
	$pdf->Cell(38,5,utf8_decode("Respaldo Puntual"),1,0,'C', true);
	$pdf->Cell(38,5,utf8_decode("Respaldo Acumulado"),1,0,'C', true);
	$pdf->Ln();
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(250,250,250);//Fondo BLANCO de celda
	$pdf->SetTextColor(0,0,0); //Letra color negro
	$pdf->Cell(38,4,utf8_decode('Bs/$ ' . number_format($datos['TC_BS_DOLLAR'][$cta], 2,',','.')),1,0,'L', true);
	$pdf->Cell(38,4,utf8_decode('Bs ' . number_format($datos['RP_IE_BS_PUROS'][$cta], 2,',','.')),1,0,'L', true);
	$pdf->Cell(38,4,utf8_decode('Bs ' . number_format($datos['RA_IE_BS_PUROS'][$cta], 2,',','.')),1,0,'L', true);
	$pdf->Cell(38,4,utf8_decode('Pm ' . number_format($datos['RP_RES_MON_CIRC'][$cta], 2,',','.')),1,0,'L', true);
	$pdf->Cell(38,4,utf8_decode('Pm ' . number_format($datos['RA_RES_MON_CIRC'][$cta], 2,',','.')),1,0,'L', true);
	$pdf->Ln();
	$pdf->Cell(38,4,utf8_decode('Pm/$ ' . number_format($datos['TC_PM_DOLLAR'][$cta], 2,',','.')),1,0,'L', true);
	$pdf->Cell(38,4,utf8_decode('$ ' . number_format($datos['RP_IE_DOLLAR_PUROS'][$cta], 2,',','.')),1,0,'L', true);
	$pdf->Cell(38,4,utf8_decode('$ ' . number_format($datos['RA_IE_DOLLARES_PUROS'][$cta], 2,',','.')),1,0,'L', true);
	$pdf->Cell(38,4,utf8_decode('Bs ' . number_format($datos['RP_RES_MON_BS_PUROS'][$cta], 2,',','.')),1,0,'L', true);
	$pdf->Cell(38,4,utf8_decode('Bs ' . number_format($datos['RA_RES_MON_BS_PUROS'][$cta], 2,',','.')),1,0,'L', true);
	$pdf->Ln();
	$pdf->Cell(38,4,utf8_decode('Bs/Pm-C ' . number_format($datos['TC_BS_PM_C'][$cta], 2,',','.')),1,0,'L', true);
	$pdf->Cell(38,4,utf8_decode(' '),1,0,'L', true);
	$pdf->Cell(38,4,utf8_decode('$ Eq ' . number_format($datos['RA_IE_DOLLARES_EQV'][$cta], 2,',','.')),1,0,'L', true);
	$pdf->Cell(38,4,utf8_decode('$ ' . number_format($datos['RP_RES_MON_DOLLAR_PUROS'][$cta], 2,',','.')),1,0,'L', true);
	$pdf->Cell(38,4,utf8_decode('$ ' . number_format($datos['RA_RES_MON_DOLLARES_PUROS'][$cta], 2,',','.')),1,0,'L', true);
	$pdf->Ln();
	$pdf->Cell(38,4,utf8_decode('Bs/Pm-V ' . number_format($datos['TC_BS_PM_V'][$cta], 2,',','.')),1,0,'L', true);
	$pdf->Cell(38,4,utf8_decode(' '),1,0,'L', true);
	$pdf->Cell(38,4,utf8_decode(' '),1,0,'L', true);
	$pdf->Cell(38,4,utf8_decode(' '),1,0,'L', true);
	$pdf->Cell(38,4,utf8_decode('$ Eq ' . number_format($datos['RA_RES_MON_DOLLARES_EQV'][$cta], 2,',','.')),1,0,'L', true);
	
	$pdf->Ln(6);

	$cta++;
}
if(isset($_POST['ver'])){
	if($_POST['ver']=="no"){
		//CERRANDO DOCUMENTO Y DESCARGANDLO
		$pdf->Output("D","informe_" . $ano . ".pdf","true");
	}else{
		//CERRANDO DOCUMENTO Y ENVIANDOLO AL NAVEGADOR
		$pdf->Output();
	}
}else{
	//CERRANDO DOCUMENTO Y ENVIANDOLO AL NAVEGADOR
	$pdf->Output();
}
?>