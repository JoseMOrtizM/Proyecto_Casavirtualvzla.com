<?php
require ("PHP_MODELO/M_todos.php");
require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php");
require('fpdf/fpdf.php');
//RESCATANDO ID
if(isset($_GET['id'])){
	$id=mysqli_real_escape_string($conexion,$_GET['id']);
	//VERIFICANDO ID VÁLIDO
	$datos_previos=M_control_de_transacciones_compras_en_micoin_R($conexion, 'ID_TRANSACCION', $id, '', '', '', '');
	if($datos_previos['ID_TRANSACCION'][0]<>''){
		$datos_factura=M_control_de_transacciones_compras_en_micoin_R($conexion, 'CODIGO_DE_SEGURIDAD', $datos_previos['CODIGO_DE_SEGURIDAD'][0], '', '', '', '');
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
		$pdf->SetFont('Arial','BU',14);
		$pdf->Ln(5);
		$pdf->Cell(190,10,utf8_decode('RECIBO DE REINTEGRO COMPRA-RECHAZADA POR USTED:'), false,0,'C');
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
			if($datos_factura['ID_TRANSACCION'][0]<10){
				$numero="0000000" . $datos_factura['ID_TRANSACCION'][0];
			}else if($datos_factura['ID_TRANSACCION'][0]<100){
				$numero="000000" . $datos_factura['ID_TRANSACCION'][0];
			}else if($datos_factura['ID_TRANSACCION'][0]<1000){
				$numero="00000" . $datos_factura['ID_TRANSACCION'][0];
			}else if($datos_factura['ID_TRANSACCION'][0]<10000){
				$numero="0000" . $datos_factura['ID_TRANSACCION'][0];
			}else if($datos_factura['ID_TRANSACCION'][0]<100000){
				$numero="000" . $datos_factura['ID_TRANSACCION'][0];
			}else if($datos_factura['ID_TRANSACCION'][0]<1000000){
				$numero="00" . $datos_factura['ID_TRANSACCION'][0];
			}else if($datos_factura['ID_TRANSACCION'][0]<10000000){
				$numero="0" . $datos_factura['ID_TRANSACCION'][0];
			}else{
				$numero=$datos_factura['ID_TRANSACCION'][0];
			}
		$pdf->Cell(25,5,utf8_decode("CR-" . $numero),0,0,'L', true);
		$pdf->Ln();
		$pdf->SetX(140);
		$pdf->Cell(35,5,utf8_decode('Fecha:'),0,0,'R', true);
		//TRATANDO FECHA
		$fecha_imp=explode(" ",$datos_factura['FH_TRANSACCION_ABANDONADA'][0]);
		$pdf->Cell(25,5,utf8_decode($fecha_imp[0]),0,0,'L', true);
		$pdf->Ln(0);
		$pdf->SetTextColor(150,0,0); //Letra color
		$pdf->Cell(190,10,utf8_decode('----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------'), false,0,'C');
		$pdf->SetTextColor(0,0,0); //Letra color
		$pdf->Ln(6);
		//TRATANDO EMPRESA COMPRADOR
		if($datos_factura['COMPRADOR_EMPRESA'][0]=='SI'){
			$es_empresa_c="Empresa";
		}else{
			$es_empresa_c="Persona Natural";
		}
		//TRATANDO EMPRESA VENDEDOR
		if($datos_factura['VENDEDOR_EMPRESA'][0]=='SI'){
			$es_empresa_v="Empresa";
		}else{
			$es_empresa_v="Persona Natural";
		}
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,5,utf8_decode('Comprador:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(75,5,utf8_decode($datos_factura['COMPRADOR_NOMBRE'][0] . ' ' . $datos_factura['COMPRADOR_APELLIDO'][0]),0,0,'L', true);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,5,utf8_decode('Vendedor:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(75,5,utf8_decode($datos_factura['VENDEDOR_NOMBRE'][0] . ' ' . $datos_factura['VENDEDOR_APELLIDO'][0]),0,0,'L', true);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,5,utf8_decode('Cedula / RIF:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(75,5,utf8_decode($datos_factura['COMPRADOR_CEDULA_RIF'][0]),0,0,'L', true);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,5,utf8_decode('Cedula / RIF:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(75,5,utf8_decode($datos_factura['VENDEDOR_CEDULA_RIF'][0]),0,0,'L', true);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,5,utf8_decode('Teléfono:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(75,5,utf8_decode($datos_factura['COMPRADOR_TELEFONO'][0]),0,0,'L', true);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,5,utf8_decode('Teléfono:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(75,5,utf8_decode($datos_factura['VENDEDOR_TELEFONO'][0]),0,0,'L', true);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,5,utf8_decode('Correo:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(75,5,utf8_decode($datos_factura['COMPRADOR_CORREO'][0]),0,0,'L', true);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,5,utf8_decode('Correo:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(75,5,utf8_decode($datos_factura['VENDEDOR_CORREO'][0]),0,0,'L', true);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,5,utf8_decode('Dirección:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		$pdf->MultiCell(75,5,utf8_decode($datos_factura['COMPRADOR_DIRECCION'][0]), false);
		//$pdf->Cell(75,5,utf8_decode($datos_factura['COMPRADOR_DIRECCION'][0]),0,0,'L', true);
		//AJUSTANDO CURSOR
		$pdf->SetXY(105,80);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(20,5,utf8_decode('Dirección:'),0,0,'L', true);
		$pdf->SetFont('Arial','',9);
		$pdf->MultiCell(75,5,utf8_decode($datos_factura['VENDEDOR_DIRECCION'][0]), false);
		//$pdf->Cell(75,5,utf8_decode($datos_factura['VENDEDOR_DIRECCION'][0]),0,0,'L', true);
		//AJUSTANDO CURSOR A RAZON DE 44 CARACTERES POR CADA LINEA DE LAS DIRECCIONES
		if(strlen($datos_factura['VENDEDOR_DIRECCION'][0])>=strlen($datos_factura['COMPRADOR_DIRECCION'][0])){
			$salto=round(strlen($datos_factura['VENDEDOR_DIRECCION'][0])/44,0);
		}else{
			$salto=round(strlen($datos_factura['COMPRADOR_DIRECCION'][0])/44,0);
		}
		if($salto<=1){
			$salto=1;
		}
		$salto=75+$salto*5;
		$pdf->SetXY(10,$salto);
		//pintando linea
		$pdf->Ln(1);
		$pdf->SetFont('Arial','B',9);
		$pdf->SetTextColor(150,0,0); //Letra color
		$pdf->Cell(190,10,utf8_decode('----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------'), false,0,'C');
		$pdf->Ln();
		//ENCABEZADO DE LA TABLA
		$pdf->SetFillColor(200,200,200);//Fondo de celda
		$pdf->SetTextColor(0,0,0); //Letra color
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(7,5,utf8_decode('N°'),1,0,'C', true);
		$pdf->Cell(98,5,utf8_decode('Descripción'),1,0,'C', true);
		$pdf->Cell(25,5,utf8_decode('Cantidad'),1,0,'C', true);
		$pdf->Cell(25,5,utf8_decode('Precio Unit'),1,0,'C', true);
		$pdf->Cell(35,5,utf8_decode('IMPORTE'),1,0,'C', true);
		$pdf->Ln();
		//CUERPO DE LA TABLA
		$pdf->SetFillColor(255,255,255);//Fondo de celda
		$pdf->SetTextColor(0,0,0); //Letra color
		$pdf->SetFont('Arial','',9);
		$subtotal=0;
		$cta=0;
		while(isset($datos_factura['ID_TRANSACCION'][$cta])){
			$pdf->Cell(7,5,$cta+1,1,0,'C', true);
			$pdf->Cell(98,5,utf8_decode($datos_factura['NOMBRE_PRODUCTO'][$cta]),1,0,'L', true);
			$pdf->Cell(25,5,utf8_decode(number_format($datos_factura['CANTIDAD_COMPRADA'][$cta], 2,',','.')),1,0,'R', true);
			$pdf->Cell(25,5,utf8_decode(number_format($datos_factura['PRECIO_UNITARIO_MICOIN'][$cta], 2,',','.')),1,0,'R', true);
			$pdf->Cell(35,5,utf8_decode(number_format($datos_factura['MONTO_BRUTO_MICOIN'][$cta], 2,',','.')),1,0,'R', true);
			$pdf->Ln();
			//salvando el subtotal
			$subtotal=$subtotal+$datos_factura['MONTO_BRUTO_MICOIN'][$cta];
			$cta++;
		}
		//rellenando la factura con al menos 10 renglones
		if($cta<10){
			while($cta<10){
				$pdf->Cell(7,5,"",1,0,'C', true);
				$pdf->Cell(98,5,"",1,0,'L', true);
				$pdf->Cell(25,5,"",1,0,'R', true);
				$pdf->Cell(25,5,"",1,0,'R', true);
				$pdf->Cell(35,5,"",1,0,'R', true);
				$pdf->Ln();
				$cta++;
			}
		}
		//RESUMEN FINAL DE LA TABLA
		$comision_cv=$subtotal*$datos_factura['PORC_COMISION'][0]/100;
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(155,5,utf8_decode("Sub Total Pm:"),0,0,'R', true);
		$pdf->Cell(35,5,utf8_decode(number_format($subtotal, 2,',','.')),1,0,'R', true);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(155,5,utf8_decode("% Comisión:"),0,0,'R', true);
		$pdf->Cell(35,5,utf8_decode(number_format($datos_factura['PORC_COMISION'][0], 2,',','.')),1,0,'R', true);
		$pdf->Ln();
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(155,5,utf8_decode("Comisión Casa Virtual Pm:"),0,0,'R', true);
		$pdf->Cell(35,5,utf8_decode(number_format($comision_cv, 2,',','.')),1,0,'R', true);
		$pdf->Ln();
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(155,5,utf8_decode("Total Reintegrado al Comprador Pm:"),0,0,'R', true);
		$pdf->Cell(35,5,utf8_decode(number_format($subtotal-$comision_cv, 2,',','.')),1,0,'R', true);
		$pdf->Ln();
		
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