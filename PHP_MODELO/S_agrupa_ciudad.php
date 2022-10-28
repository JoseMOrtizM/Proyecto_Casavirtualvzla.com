<?php 
//ESTA SUB RUTINA IMPRIME LAS OPCIONES DE CIUDAD PARA UNA ETIQUETA SELECT
if(isset($_POST['estado'])){
	$estado=$_POST['estado']; 
	require_once ("M_todos.php");
	$ciudades=M_agrupa_ciudad($conexion, $estado);
	$i=0;
	echo "<option></option>";
	while(isset($ciudades['ID_CIUDAD'][$i])){
		echo "<option>" . $ciudades['CIUDAD'][$i] . "</option>";
		$i=$i+1;
	}
}
?>