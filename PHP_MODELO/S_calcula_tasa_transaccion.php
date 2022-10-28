<?php 
//ESTA SUB RUTINA IMPRIME LOS RESULTADOS DE MONTOS A PAGAR PARA UN TIPO DE TRANSACCION. TIPO DE MONEDA, TASA DE CAMBIO Y CANTIDAD DE MICOIN DADOS
if(isset($_POST['tipo_de_transaccion'])){
	require_once ("M_todos.php");
	$tipo_de_transaccion=$_POST['tipo_de_transaccion']; 
	$id_tasa=$_POST['id_tasa']; 
	$tasa_i=M_paridad_cambiaria_R($conexion, 'ID_TASA_DE_CAMBIO', $id_tasa, '', '', '', '');
	if($tipo_de_transaccion=='COMPRA'){//este es para la vista zona_usuario_arca_comprar.php
		$monto_neto=$_POST['monto_neto']==''?0:$_POST['monto_neto']; 
		$moneda=$tasa_i['TIPO_DE_MONEDA_REAL'][0];
		$monto_bruto= $monto_neto / (1+($tasa_i['PORC_COMISION_POR_COMPRA'][0]/100));
		$porc_comision=$tasa_i['PORC_COMISION_POR_COMPRA'][0];
		$monto_comision=$monto_bruto*$porc_comision/100;
		$cantidad_micoin=$monto_bruto/$tasa_i['TIPO_POR_MICOIN_COMPRA'][0];
		
		$monto_bruto_imp=number_format($monto_bruto, 2,',','.');
		
		$porc_comision_imp=number_format($porc_comision, 2,',','.');
		$monto_comision_imp=number_format($monto_comision, 2,',','.');
		$cantidad_micoin_imp=number_format($cantidad_micoin, 2,',','.');
		echo "
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>% Comisión:</span>
				</div>
				<input type='hidden' name='porc_comision' id='porc_comision' value='$porc_comision'>
				<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='porc_comision_imprimir' id='porc_comision_imprimir' title='Porcentaje de comisión agregado por compra de moneda virtual' step='any' disabled value='$porc_comision_imp'>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Bs. Comisión:</span>
				</div>
				<input type='hidden' name='monto_comision' id='monto_comision' value='$monto_comision'>
				<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='monto_comision_imprimir' id='monto_comision_imprimir' title='Monto de comisión agregado por compra de moneda virtual' step='any' disabled value='$monto_comision_imp'>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Bs. a Convertir:</span>
				</div>
				<input type='hidden' name='monto_bruto' id='monto_bruto' value='$monto_bruto'>
				<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0 text-dark' name='monto_bruto_imprimir' id='monto_bruto_imprimir' title='cantidad de $moneda sin incluir la comisión por compra' step='any' disabled value='$monto_bruto_imp'>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'><b class='text-danger'>PEMÓNES:</b></span>
				</div>
				<input type='hidden' name='cantidad_micoin' id='cantidad_micoin' value='$cantidad_micoin'>
				<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='cantidad_micoin_imprimir' id='cantidad_micoin_imprimir' title='Pm a recibir' step='any' disabled value='$cantidad_micoin_imp'>
			</div>
		";
	}else{//este es para la vista zona_usuario_arca_vender.php
		$cantidad=$_POST['cantidad']; 
		
		$moneda=$tasa_i['TIPO_DE_MONEDA_REAL'][0];
		
		$monto_bruto=$cantidad*$tasa_i['TIPO_POR_MICOIN_VENTA'][0];
		$porc_comision=$tasa_i['PORC_COMISION_POR_VENTA'][0];
		$monto_comision=$monto_bruto*$porc_comision/100;
		$monto_neto=$monto_bruto-$monto_comision;
		
		$monto_bruto_imp=number_format($cantidad*$tasa_i['TIPO_POR_MICOIN_VENTA'][0], 2,',','.');
		$porc_comision_imp=number_format($tasa_i['PORC_COMISION_POR_VENTA'][0], 2,',','.');
		$monto_comision_imp=number_format($monto_bruto*$porc_comision/100, 2,',','.');
		$monto_neto_imp=number_format($monto_bruto-$monto_comision, 2,',','.');
		echo "
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>$moneda al Cambio:</span>
				</div>
				<input type='hidden' name='monto_bruto' id='monto_bruto' value='$monto_bruto'>
				<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='monto_bruto_imprimir' id='monto_bruto_imprimir' title='cantidad de $moneda sin incluir la comisión por venta' step='any' disabled value='$monto_bruto_imp'>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>% Comisión:</span>
				</div>
				<input type='hidden' name='porc_comision' id='porc_comision' value='$porc_comision'>
				<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='porc_comision_imprimir' id='porc_comision_imprimir' title='Porcentaje de comisión agregado por venta de moneda virtual' step='any' disabled value='$porc_comision_imp'>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Bs. Comisión:</span>
				</div>
				<input type='hidden' name='monto_comision' id='monto_comision' value='$monto_comision'>
				<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='monto_comision_imprimir' id='monto_comision_imprimir' title='Monto de comisión agregado por venta de moneda virtual' step='any' disabled value='$monto_comision_imp'>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'><b class='text-danger'>Bs. a Reintegrar:</b></span>
				</div>
				<input type='hidden' name='monto_neto' id='monto_neto' value='$monto_neto'>
				<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='monto_neto_imprimir' id='monto_neto_imprimir' title='Monto que será reintegrado a tu cuenta por la venta de la moneda virtual' step='any' disabled value='$monto_neto_imp'>
			</div>
		";
	}
}
?>