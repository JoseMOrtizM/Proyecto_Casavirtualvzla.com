<?php 
	//OBTENIENDO NOMBRE DEL ARCHIVO PHP ACTUAL
	$ruta_actual=$_SERVER["REQUEST_URI"];
	$partes1=explode("/",$ruta_actual);
	$i=0;
	while(isset($partes1[$i])==true){
		$ruta_actual=$partes1[$i];
		$i=$i+1;
	}
	$partes2=explode("?",$ruta_actual);
	$ruta_actual=$partes2[0];
	//INSERTANDO DATOS DE NAVEGACIÓN Y BÚSQUEDA EN LA BASE DE DATOS PARA POST
	if(isset($_POST['buscar'])){
		if($_POST['buscar']<>''){
			M_historial_de_busqueda_C($conexion, 'EXTERNO', 
				M_obtener_ip_real(), 
				null, 
				null, 
				null, 
				null, 
				null, 
				date("Y-m-d h:m:s"), 
				$ruta_actual, 
				mysqli_real_escape_string($conexion,$_POST['buscar']));
		}else{
			M_historial_de_busqueda_C($conexion, 'EXTERNO', 
				M_obtener_ip_real(), 
				null, 
				null, 
				null, 
				null, 
				null, 
				date("Y-m-d h:m:s"), 
				$ruta_actual, 
				'');
		}
	}else{
		M_historial_de_busqueda_C($conexion, 'EXTERNO', 
			M_obtener_ip_real(), 
			null, 
			null, 
			null, 
			null, 
			null, 
			date("Y-m-d h:m:s"), 
			$ruta_actual, 
			'');
	}
	//INSERTANDO DATOS DE NAVEGACIÓN Y BÚSQUEDA EN LA BASE DE DATOS PARA GET
	if(isset($_GET['buscar'])){
		if($_GET['buscar']<>''){
			M_historial_de_busqueda_C($conexion, 'EXTERNO', 
				M_obtener_ip_real(), 
				null, 
				null, 
				null, 
				null, 
				null, 
				date("Y-m-d h:m:s"), 
				$ruta_actual, 
				mysqli_real_escape_string($conexion,$_GET['buscar']));
		}else{
			M_historial_de_busqueda_C($conexion, 'EXTERNO', 
				M_obtener_ip_real(), 
				null, 
				null, 
				null, 
				null, 
				null, 
				date("Y-m-d h:m:s"), 
				$ruta_actual, 
				'');
		}
	}else{
		M_historial_de_busqueda_C($conexion, 'EXTERNO', 
			M_obtener_ip_real(), 
			null, 
			null, 
			null, 
			null, 
			null, 
			date("Y-m-d h:m:s"), 
			$ruta_actual, 
			'');
	}
?>