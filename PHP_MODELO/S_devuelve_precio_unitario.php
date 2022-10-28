<?php 
//ESTA SUB RUTINA IMPRIME EL PRECIO UNITARIO DE UN PRODUCTO DADOS LA CEDULA DEL VENDEDOR Y EL NOMBRE DEL PRODUCTO PARA EL CRUD DE CONTROL_DE_TRANSACCIONES_MICOIN
if(isset($_POST['cedula_vendedor']) and isset($_POST['nombre_producto'])){
	$cedula_vendedor=$_POST['cedula_vendedor']; 
	$nombre_producto=$_POST['nombre_producto']; 
	require_once ("M_todos.php");
	$producto=M_productos_y_servicios_R($conexion, "CEDULA_RIF", $cedula_vendedor, "NOMBRE_PRODUCTO", $nombre_producto, '', '');
	if(isset($producto['ID_PRODUCTO'][0])){
		if($producto['PRECIO_UNITARIO_MICOIN'][0]>0){
			echo "<div class='input-group mb-2'>
			<div class='col-md-3 p-0 m-0'>
				<span class='input-group-text rounded-0 w-100'>Precio/Unidad:</span>
			</div>
			<input type='hidden' name='precio_unitario_micoin' id='precio_unitario_micoin' value='" . $producto['PRECIO_UNITARIO_MICOIN'][0] . "'>
			<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='precio_unitario_micoin_print' id='precio_unitario_micoin_print'  title='precio unitario del producto' min='0' disabled value='" . number_format($producto['PRECIO_UNITARIO_MICOIN'][0], 2,',','.') . "'>
			</div>";
		}
	}
}
?>