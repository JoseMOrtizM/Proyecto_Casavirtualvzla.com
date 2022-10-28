<?php 
//DATOS PARA CONFIGURAR LA CONEXXION
$url_sitio=$_SERVER['DOCUMENT_ROOT'] . '/mis_sitios/MiCoin/';
$servidor_nombre="localhost";
$servidor_usuario="root";//casa1220
$servidor_contrasena="";//
$base_de_datos_nombre="micoin";//casa1220_micoin
$suspender_sitio=false;
//conectando
$conexion=mysqli_connect($servidor_nombre,$servidor_usuario,$servidor_contrasena);
if(mysqli_connect_errno()){echo "Fallo al conectar con la BBDD";exit();}
mysqli_select_db($conexion,$base_de_datos_nombre) or die ("No se encuentra la BBDD");
mysqli_set_charset($conexion,"utf8");
//SETEANDO HORA LOCAL
date_default_timezone_set('America/Caracas');
//EN CASO DE QUE ALGO ANDE MAL DESDE AQUÍ PODEMOS REDIRECCIONAR EL SITIO A UNA PAGINA DE FALLO TEMPORAL
if($suspender_sitio){
	//OBTENIENDO NOMBRE DEL ARCHIVO PHP ACTUAL
	$partes1_i=explode("/",$_SERVER["REQUEST_URI"]);
	$partes2_i=explode("?",$partes1_i[count($partes1_i)-1]);
	if($partes2_i[0]<>'fallo_temporal.php'){
		header("location:fallo_temporal.php");
	}
}
?>