<?php 
//ESTA SUB RUTINA IMPRIME LAS OPCIONES DE MUNICIPIO SIN ID PARA UNA ETIQUETA SELECT
if(isset($_POST['estado'])){
	$estado=$_POST['estado']; 
	require_once ("M_todos.php");
	$municipios=M_agrupa_municipio($conexion, $estado);
	$i=0;
	echo "<option></option>";
	while(isset($municipios[$i])){
		echo "<option>" . $municipios[$i] . "</option>";
		$i=$i+1;
	}
}
?>