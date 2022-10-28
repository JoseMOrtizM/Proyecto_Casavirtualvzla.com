<?php 
//ESTA FUNCIÓN GENERA UN CODIGO SECRETO Y DEVUELVE SU VALOR DESENCRIPTADO
function M_generar_codigo_seguridad($conexion, $cedula_comprador, $id_transaccion){
	$consulta="SELECT `ID_USUARIO` FROM `mc_usuarios` WHERE `CEDULA_RIF`='$cedula_comprador'";
	$resultados=mysqli_query($conexion,$consulta);
	$id_usuario=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$id_usuario=$fila['ID_USUARIO'];
	}
	//ACTUALIZANDO CONTRASEÑA AL AZAR
	$letras_y_numeros[0]="a";
	$letras_y_numeros[1]="b";
	$letras_y_numeros[2]="c";
	$letras_y_numeros[3]="d";
	$letras_y_numeros[4]="e";
	$letras_y_numeros[5]="f";
	$letras_y_numeros[6]="g";
	$letras_y_numeros[7]="h";
	$letras_y_numeros[8]="i";
	$letras_y_numeros[9]="j";
	$letras_y_numeros[10]="k";
	$letras_y_numeros[11]="l";
	$letras_y_numeros[12]="m";
	$letras_y_numeros[13]="n";
	$letras_y_numeros[14]="o";
	$letras_y_numeros[15]="p";
	$letras_y_numeros[16]="q";
	$letras_y_numeros[17]="r";
	$letras_y_numeros[18]="s";
	$letras_y_numeros[19]="t";
	$letras_y_numeros[20]="u";
	$letras_y_numeros[21]="v";
	$letras_y_numeros[22]="w";
	$letras_y_numeros[23]="x";
	$letras_y_numeros[24]="y";
	$letras_y_numeros[25]="z";
	$letras_y_numeros[26]="0";
	$letras_y_numeros[27]="1";
	$letras_y_numeros[28]="2";
	$letras_y_numeros[29]="3";
	$letras_y_numeros[30]="4";
	$letras_y_numeros[31]="5";
	$letras_y_numeros[32]="6";
	$letras_y_numeros[33]="7";
	$letras_y_numeros[34]="8";
	$letras_y_numeros[35]="9";
	$codigo_seguridad=$id_transaccion . $letras_y_numeros[rand(0,35)] . date("y") . $letras_y_numeros[rand(0,35)] . date("m") . $letras_y_numeros[rand(0,35)] . date("d") . $letras_y_numeros[rand(0,35)];
	$consulta="UPDATE `mc_control_de_transacciones_micoin` SET `CODIGO_DE_SEGURIDAD`='$codigo_seguridad' WHERE `ID_TRANSACCION`='$id_transaccion'";
	$resultados=mysqli_query($conexion,$consulta);
	$retorno['ID_TRANSACCION']=$id_transaccion;
	$retorno['CODIGO_DE_SEGURIDAD']=$codigo_seguridad;
	return $retorno;
}
function M_copiar_codigo_seguridad($conexion, $id_transaccion_anterior, $id_transaccion_a_actualizar){
	$consulta="SELECT `CODIGO_DE_SEGURIDAD` FROM `mc_control_de_transacciones_micoin` WHERE `ID_TRANSACCION`='$id_transaccion_anterior'";
	$resultados=mysqli_query($conexion,$consulta);
	$codigo_seguridad=0;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$codigo_seguridad=$fila['CODIGO_DE_SEGURIDAD'];
	}
	$consulta="UPDATE `mc_control_de_transacciones_micoin` SET `CODIGO_DE_SEGURIDAD`='$codigo_seguridad' WHERE `ID_TRANSACCION`='$id_transaccion_a_actualizar'";
	$resultados=mysqli_query($conexion,$consulta);
	$retorno['ID_TRANSACCION_ANTERIOR']=$id_transaccion_anterior;
	$retorno['ID_TRANSACCION_ACTUALIZADO']=$id_transaccion_a_actualizar;
	$retorno['CODIGO_DE_SEGURIDAD']=$codigo_seguridad;
	return $retorno;
}
?>