<?php 
//ESTA SUB RUTINA IMPRIME LAS OPCIONES DE PREGUNTAS DE SEGURIDAD PARA UNA ETIQUETA SELECT DADAS HASTA 4 PREGUNTAS PRE SELECCIONADAS
if(isset($_POST['preg_1']) and isset($_POST['preg_2']) and isset($_POST['preg_3']) and isset($_POST['preg_4'])){
	$preg_1=$_POST['preg_1']; 
	$preg_2=$_POST['preg_2']; 
	$preg_3=$_POST['preg_3']; 
	$preg_4=$_POST['preg_4'];
	require_once ("M_todos.php");
	$preguntas_seguridad=M_preguntas_seguridad();
	$i=0;
	$e=0;
	while(isset($preguntas_seguridad[$i])){
		if($preguntas_seguridad[$i]==$preg_1 or $preguntas_seguridad[$i]==$preg_2 or $preguntas_seguridad[$i]==$preg_3 or $preguntas_seguridad[$i]==$preg_4){
			//nada
		}else{
			$preguntas_corregidas[$e]=$preguntas_seguridad[$i];
			$e=$e+1;
		}
		$i=$i+1;
	}
	$i=0;
	echo "<option></option>";
	while(isset($preguntas_corregidas[$i])){
		echo "<option>" . $preguntas_corregidas[$i] . "</option>";
		$i=$i+1;
	}
}
?>