<?php
require ("PHP_MODELO/M_todos.php");
require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php");
require('fpdf/fpdf.php');
//RESCATANDO ID
if(isset($_GET['id'])){
	$id=mysqli_real_escape_string($conexion,$_GET['id']);
	//VERIFICANDO ID VÁLIDO
	$datos_factura=M_compra_venta_de_micoin_R($conexion, 'ID_COMPRA_VENTA', $id, '', '', '', '');
	if($datos_factura['ID_COMPRA_VENTA'][0]<>''){
		//ARMANDO FACTURA
		//NO APLICA EXTRAER LOS DATOS PORQUE YA ESTAN CARGADOS EN EL ARRAY $datos_factura
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
				$this->Cell(0,10,utf8_decode('Dirección: Transversal III, N° 4, Doña Menca, Sector Boquerón, Maturín, Venezuela. Telf: 0414-8609152 y 0412-4641122'),0,0,'C');
			}
		}
		//CREANDO LA INSTANCIA FPDF
		$pdf = new PDF();
		$pdf->AliasNbPages();
		//--------------------------------------------//
		//IMPRIMIENDO PAGINA 1
		$pdf->AddPage();
		$pdf->Ln(5);
		$pdf->SetFont('Arial','BU',14);
		$pdf->Cell(190,10,utf8_decode('RECIBO DE PAGO:'), false,0,'C');
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);
		$pdf->SetTextColor(150,0,0); //Letra color
		$pdf->Cell(190,10,utf8_decode('----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------'), false,0,'C');
		$pdf->Ln(6);
		$pdf->SetTextColor(0,0,0); //Letra color
		$pdf->SetFont('Arial','B',20);
		$pdf->SetFillColor(255,255,255);//Fondo de celda
		$pdf->SetTextColor(0,0,0); //Letra color
		$pdf->Cell(130,10,utf8_decode(""),0,0,'C', true);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(35,5,utf8_decode('Factura N°:'),0,0,'R', true);
		//TRATANDO NÚMERO DE FACTURA
			if($datos_factura['ID_COMPRA_VENTA'][0]<10){
				$numero="0000000" . $datos_factura['ID_COMPRA_VENTA'][0];
			}else if($datos_factura['ID_COMPRA_VENTA'][0]<100){
				$numero="000000" . $datos_factura['ID_COMPRA_VENTA'][0];
			}else if($datos_factura['ID_COMPRA_VENTA'][0]<1000){
				$numero="00000" . $datos_factura['ID_COMPRA_VENTA'][0];
			}else if($datos_factura['ID_COMPRA_VENTA'][0]<10000){
				$numero="0000" . $datos_factura['ID_COMPRA_VENTA'][0];
			}else if($datos_factura['ID_COMPRA_VENTA'][0]<100000){
				$numero="000" . $datos_factura['ID_COMPRA_VENTA'][0];
			}else if($datos_factura['ID_COMPRA_VENTA'][0]<1000000){
				$numero="00" . $datos_factura['ID_COMPRA_VENTA'][0];
			}else if($datos_factura['ID_COMPRA_VENTA'][0]<10000000){
				$numero="0" . $datos_factura['ID_COMPRA_VENTA'][0];
			}else{
				$numero=$datos_factura['ID_COMPRA_VENTA'][0];
			}
		$pdf->Cell(25,5,utf8_decode("MV-" . $numero),0,0,'L', true);
		$pdf->Ln();
		$pdf->SetX(140);
		$pdf->Cell(35,5,utf8_decode('Fecha:'),0,0,'R', true);
		//TRATANDO FECHA
		$fecha_imp=explode(" ",$datos_factura['FH_CONFIRMADO'][0]);
		$pdf->Cell(25,5,utf8_decode($fecha_imp[0]),0,0,'L', true);
		$pdf->Ln(0);
		$pdf->SetTextColor(150,0,0); //Letra color
		$pdf->Cell(190,10,utf8_decode('----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------'), false,0,'C');
		$pdf->SetTextColor(0,0,0); //Letra color
		$pdf->Ln(6);
		//TRATANDO EMPRESA
		if($datos_factura['EMPRESA'][0]=='SI'){
			$es_empresa="Empresa";
		}else{
			$es_empresa="Persona Natural";
		}
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,5,utf8_decode('Usuario:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(170,5,utf8_decode($datos_factura['NOMBRE'][0] . ' ' . $datos_factura['APELLIDO'][0]),0,0,'L', true);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,5,utf8_decode('Cedula / RIF:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(170,5,utf8_decode($datos_factura['CEDULA_RIF'][0]),0,0,'L', true);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,5,utf8_decode('Dirección:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(170,5,utf8_decode($datos_factura['DIRECCION'][0]),0,0,'L', true);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,5,utf8_decode('Teléfono:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(170,5,utf8_decode($datos_factura['TELEFONO'][0]),0,0,'L', true);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,5,utf8_decode('Correo:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(170,5,utf8_decode($datos_factura['CORREO'][0]),0,0,'L', true);
		$pdf->Ln(1);
		$pdf->SetFont('Arial','B',9);
		$pdf->SetTextColor(150,0,0); //Letra color
		$pdf->Cell(190,10,utf8_decode('----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------'), false,0,'C');
		$pdf->Ln(20);
		//CUERPO DEL RECIBO
		$pdf->SetFillColor(255,255,255);//Fondo de celda
		$pdf->SetTextColor(0,0,0); //Letra color
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(27,5,utf8_decode('He Recibido de:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(163,5,utf8_decode('La Casa Virtual'),0,0,'L', true);
		$pdf->Ln(0);
		$pdf->SetX(37);
		$pdf->Cell(163,10,utf8_decode('------------------------------------------------------------------------------------------------------------------------------------------------------'), false,0,'L');
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(27,5,utf8_decode('La Cantidad de:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		//TRATANDO LA DESCRIPCIÓN DE LA CANTIDAD DE:
		if($datos_factura['TIPO_DE_TRANSACCION'][0]=='COMPRA'){
			$descripcion_cantidad_imp=number_format($datos_factura['CANTIDAD_MICOIN'][0], 2,',','.') . "Pm";
		}else{
			$descripcion_cantidad_imp=number_format($datos_factura['MONTO_BRUTO'][0], 2,',','.') . "Bs";
		}
		$pdf->Cell(163,5,utf8_decode($descripcion_cantidad_imp),0,0,'L', true);
		$pdf->Ln(0);
		$pdf->SetX(37);
		$pdf->Cell(163,10,utf8_decode('------------------------------------------------------------------------------------------------------------------------------------------------------'), false,0,'L');
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(27,5,utf8_decode('Por Concepto de:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		//TRATANDO LA DESCRIPCIÓN DEL CONCEPTO DE:
		if($datos_factura['TIPO_DE_TRANSACCION'][0]=='COMPRA'){
			$descripcion_concepto_imp="Compra Pemón (Importe=Bs" .  number_format($datos_factura['MONTO_BRUTO'][0], 2,',','.') . ") + (Comisión=Bs" . number_format($datos_factura['MONTO_COMISION'][0], 2,',','.') . ") => (Pagado=Bs" . number_format($datos_factura['MONTO_NETO'][0], 2,',','.') . ")";
		}else{
			$descripcion_concepto_imp="Venta: " . number_format($datos_factura['CANTIDAD_MICOIN'][0], 2,',','.') . "Pm (Importe=Bs" .  number_format($datos_factura['MONTO_NETO'][0], 2,',','.') . ") + (Comisión=Bs" . number_format($datos_factura['MONTO_COMISION'][0], 2,',','.') . ") => (Pagado=Bs" . number_format($datos_factura['MONTO_BRUTO'][0], 2,',','.') . ")";
		}
		$pdf->Cell(163,5,utf8_decode($descripcion_concepto_imp),0,0,'L', true);
		$pdf->Ln(0);
		$pdf->SetX(37);
		$pdf->Cell(163,10,utf8_decode('------------------------------------------------------------------------------------------------------------------------------------------------------'), false,0,'L');
		if($datos_factura['TIPO_DE_TRANSACCION'][0]=='VENTA'){
			$pdf->Ln();
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(27,5,utf8_decode('Otros Detalles:'),0,0,'L', true);
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(163,5,utf8_decode('N° Conf.: ' . $datos_factura['NUMERO_TRANSFERENCIA'][0] . ' // Banco: ' . $datos_factura['BANCO_NOMBRE'][0] . ' // N° Cta: ' . $datos_factura['CTA_BANCO_HACIA'][0]),0,0,'L', true);
			$pdf->Ln(0);
			$pdf->SetX(37);
			$pdf->Cell(163,10,utf8_decode('------------------------------------------------------------------------------------------------------------------------------------------------------'), false,0,'L');
		}
		$pdf->Ln(20);
		$pdf->SetFillColor(255,255,255);//Fondo de celda
		$pdf->SetTextColor(0,0,0); //Letra color
		$pdf->SetFont('Arial','B',20);
		$pdf->Cell(190,5,utf8_decode('Gracias por Preferirnos'),0,0,'C', true);
		$pdf->Ln(12);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(190,5,utf8_decode('La Casa Virtual'),0,0,'C', true);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',10);
		$pdf->SetTextColor(150,150,150); //Letra color
		$pdf->Cell(190,5,utf8_decode('Adios a la Inflación...'),0,0,'C', true);
		$pdf->Ln();
		
		$pdf->SetTextColor(0,0,0); //Letra color
		if(isset($_GET['ver'])){
			if($_GET['ver']=="no"){
				//CERRANDO DOCUMENTO Y DESCARGANDLO
				$pdf->Output("D","recibo.pdf","true");
			}else{
				//CERRANDO DOCUMENTO Y ENVIANDOLO AL NAVEGADOR
				$pdf->Output();
			}
		}else{
			//CERRANDO DOCUMENTO Y ENVIANDOLO AL NAVEGADOR
			$pdf->Output();
		}
	}else{
		//mensaje id no valido
		?>
			<!doctype html>
			<html>
			<head>
				<?php require("PHP_REQUIRES/head_principal.php"); ?>
				<title>ZU-id Invalido</title>
			</head>
			<body class="bg-secondary">
				<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
				<section class="my-3">
					<div class="bg-white pb-3">
						<h2 class="text-center py-3 mb-3 bg-dark text-danger"><b>Datos Invalidos.</b></h2>
						<h5 class="text-left px-5 bg-lighr text-dark">Esta intentando acceder a una factura que no existe.</h5>
						<h5 class="text-left px-5 bg-lighr text-dark">Por favor vuelva al <a href='zona_usuario_arca_consolidado.php'>Arca Consolidado</a> y seleccione alguno de los detalles de la tabla de Saldo Disponible e intente imprimir su factura nuevamente.</h5>
					</div>
				</section>
				<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
			</body>
			</html>
		<?php
	}
}else{
	//mensaje id no valido
	?>
		<!doctype html>
		<html>
		<head>
			<?php require("PHP_REQUIRES/head_principal.php"); ?>
			<title>ZU-id Invalido</title>
		</head>
		<body class="bg-secondary">
			<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
			<section class="my-3">
				<div class="bg-white pb-3">
					<h2 class="text-center py-3 mb-3 bg-dark text-danger"><b>Datos Invalidos.</b></h2>
					<h5 class="text-left px-5 bg-lighr text-dark">Esta intentando acceder a una factura que no existe.</h5>
					<h5 class="text-left px-5 bg-lighr text-dark">Por favor vuelva al <a href='zona_usuario_arca_consolidado.php'>Arca Consolidado</a> y seleccione alguno de los detalles de la tabla de Saldo Disponible e intente imprimir su factura nuevamente.</h5>
				</div>
			</section>
			<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
		</body>
		</html>
	<?php
}
?>