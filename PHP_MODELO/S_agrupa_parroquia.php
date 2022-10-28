<?php 
//ESTA SUB RUTINA IMPRIME LAS OPCIONES DE CIUDAD PARA UNA ETIQUETA SELECT
if(isset($_POST['municipio'])){
	$municipio=$_POST['municipio']; 
	require_once ("M_todos.php");
	$parroquias=M_agrupa_parroquia($conexion, $municipio);
	$i=0;
	echo "<option></option>";
	while(isset($parroquias['ID_PARROQUIA'][$i])){
		echo "<option>" . $parroquias['PARROQUIA'][$i] . "</option>";
		$i=$i+1;
	}
}
?>