<?php 
//ESTA FUNCIÓN GENERA UN CODIGO SECRETO Y DEVUELVE SU VALOR DESENCRIPTADO
function M_generar_contrasena_temporal($conexion, $cedula){
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
	$contrasena=$letras_y_numeros[rand(0,35)] . $letras_y_numeros[rand(0,35)] . $letras_y_numeros[rand(0,35)] . $letras_y_numeros[rand(0,35)] . $letras_y_numeros[rand(0,35)] . $letras_y_numeros[rand(0,35)];
	$nueva_contrasena_encryptada=password_hash($contrasena,PASSWORD_DEFAULT);
	$consulta="UPDATE `mc_usuarios` SET CONTRASENA='$nueva_contrasena_encryptada' WHERE CEDULA_RIF='$cedula'";
	$resultados=mysqli_query($conexion,$consulta);
	require_once ("M_todos.php");
	$datos_respuesta=M_usuarios_R($conexion, 'CEDULA_RIF', $cedula, '', '', '', '');
	$retorno['CORREO']=$datos_respuesta['CORREO'][0];
	$retorno['CONTRASENA']=$contrasena;
	return $retorno;
}
?>