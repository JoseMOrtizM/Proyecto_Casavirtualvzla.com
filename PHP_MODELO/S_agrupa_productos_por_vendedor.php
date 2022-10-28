<?php 
//ESTA SUB RUTINA IMPRIME LAS OPCIONES DE PRODUCTOS DISPONIBLES PARA SELECT DEDO UN VENDEDOR
if(isset($_POST['vendedor'])){
	$vendedor=$_POST['vendedor']; 
	require_once ("M_todos.php");
	$productos=M_agrupa_productos_disponibles($conexion, $vendedor);
	$i=0;
	echo "<option></option>";
	while(isset($productos['ID_PRODUCTO'][$i])){
		echo "<option>" . $productos['NOMBRE_PRODUCTO'][$i] . "</option>";
		$i=$i+1;
	}
}
?>