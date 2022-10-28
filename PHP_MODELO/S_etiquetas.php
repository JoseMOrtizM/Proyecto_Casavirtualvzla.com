<?php 
//ESTA SUB RUTINA IMPRIME LAS OPCIONES DE ETQUETAS DADAS HASTA 4 ETIQUETAS PRE SELECCIONADAS
//IMPORTANTE QUE EL SISTEMA TENGA SIEMPRE 5 ETIQUETAS COMO MINIMO PARA QUE ESTE SCRIPT FUNCIONE CORRECTAMENTE
if(isset($_POST['etq_1']) and isset($_POST['etq_2']) and isset($_POST['etq_3']) and isset($_POST['etq_4'])){
	$etq_1=$_POST['etq_1']; 
	$etq_2=$_POST['etq_2']; 
	$etq_3=$_POST['etq_3']; 
	$etq_4=$_POST['etq_4'];
	require_once ("M_todos.php");
	$datos_etiquetas=M_etiquetas_R_todo($conexion);
	$i=0;
	$e=0;
	while(isset($datos_etiquetas['ID_ETIQUETA'][$i])){
		if($datos_etiquetas['NOMBRE_ETIQUETA'][$i]==$etq_1 or $datos_etiquetas['NOMBRE_ETIQUETA'][$i]==$etq_2 or $datos_etiquetas['NOMBRE_ETIQUETA'][$i]==$etq_3 or $datos_etiquetas['NOMBRE_ETIQUETA'][$i]==$etq_4){
			//nada
		}else{
			$etiquetas_corregidas['ID_ETIQUETA'][$e]=$datos_etiquetas['ID_ETIQUETA'][$i];
			$etiquetas_corregidas['NOMBRE_ETIQUETA'][$e]=$datos_etiquetas['NOMBRE_ETIQUETA'][$i];
			$e=$e+1;
		}
		$i=$i+1;
	}
	$i=0;
	echo "<option></option>";
	while(isset($etiquetas_corregidas['ID_ETIQUETA'][$i])){
		echo "<option>" . $etiquetas_corregidas['NOMBRE_ETIQUETA'][$i] . "</option>";
		$i=$i+1;
	}
}
?>