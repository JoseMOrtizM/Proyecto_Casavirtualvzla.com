<?php 
//ESTA SUB RUTINA IMPRIME: monto_bruto_micoin, ranking, porc_comision, monto_comision Y monto_neto, PARA UNA TRANSACCIÓN DADOS LA CEDULA DEL VENDEDOR, EL NOMBRE DEL PRODUCTO Y LA CANTIDAD_COMPRADA PARA EL CRUD DE CONTROL_DE_TRANSACCIONES_MICOIN
if(isset($_POST['cedula_vendedor']) and isset($_POST['nombre_producto']) and isset($_POST['cantidad_comprada']) and isset($_POST['saldo'])){
	$cedula_vendedor=$_POST['cedula_vendedor']; 
	$nombre_producto=$_POST['nombre_producto']; 
	$cantidad_comprada=$_POST['cantidad_comprada']; 
	$saldo=$_POST['saldo']; 
	require_once ("M_todos.php");
	$producto=M_productos_y_servicios_R($conexion, 'CEDULA_RIF', $cedula_vendedor, "NOMBRE_PRODUCTO", $nombre_producto, '', '');
	$comprador=M_usuarios_R($conexion, "CEDULA_RIF", $cedula_vendedor, '', '', '', '');
	//REALIZANDO LOS CALCULOS
	$monto_bruto_micoin=$producto['PRECIO_UNITARIO_MICOIN'][0]*$cantidad_comprada;
	$ranking=$comprador['RANKING'][0];
	$porc_comision=M_porcentaje_comision_por_venta_producto($ranking);
	$monto_comision=$monto_bruto_micoin*$porc_comision/100;
	$monto_neto=$monto_bruto_micoin-$monto_comision;
	//IMPRIMIENDO LOS RESULTADOS
	echo "<div class='input-group mb-2'>
		<div class='col-md-3 p-0 m-0'>
			<span class='input-group-text rounded-0 w-100'>Pm a Pagar:</span>
		</div>
		<input type='hidden' name='monto_bruto_micoin' id='monto_bruto_micoin' value='$monto_bruto_micoin'>
		<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='monto_bruto_micoin_print' id='monto_bruto_micoin_print' title='precio a Cancelar' min='0' disabled value='" . number_format($monto_bruto_micoin, 2,',','.') . "'>
	</div>";
	echo "
		<input type='hidden' name='ranking' id='ranking' value='$ranking'>
		<input type='hidden' name='porc_comision' id='porc_comision' value='$porc_comision'>
		<input type='hidden' name='monto_comision' id='monto_comision' value='$monto_comision'>
		<input type='hidden' name='monto_neto' id='monto_neto' value='$monto_neto'>
	";
	if($monto_bruto_micoin>$saldo){
		echo "<h5 class='text-danger bg-dark'><b>SALDO INSUFICIENTE:</b> Tu saldo no es suficiente para realizar esta compra.<br>(El Monto Bruto a Pagar (" . $monto_bruto_micoin . "Pm) es Mayor que tu saldo (" . $saldo . "Pm))</h5>";
		echo "<div class='m-auto'><a href='zona_usuario_carrito_compra.php' class='btn btn-warning mb-2'><span class='fa fa-reply-all'></span> Volver</a>&nbsp;&nbsp;&nbsp;<input type='submit' name='comprar' id='comprar' value='Comprar' class='btn btn-warning mb-2' disabled></div>";
	}else{
		echo "<div class='m-auto'><a href='zona_usuario_carrito_compra.php' class='btn btn-warning mb-2'><span class='fa fa-reply-all'></span> Volver</a>&nbsp;&nbsp;&nbsp;<input type='submit' name='comprar' id='comprar' value='Comprar' class='btn btn-warning mb-2'></div>";
	}
}else{
	echo "<div class='m-auto'><a href='zona_usuario_carrito_compra.php' class='btn btn-warning mb-2'><span class='fa fa-reply-all'></span> Volver</a>&nbsp;&nbsp;&nbsp;<input type='submit' name='comprar' id='comprar' value='Comprar' class='btn btn-warning mb-2'></div>";
}
?>