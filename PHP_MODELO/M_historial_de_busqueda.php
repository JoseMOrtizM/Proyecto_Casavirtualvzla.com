<?php 
function M_historial_de_busqueda_C($conexion, $tipo, $navegacion_ip, $nombre, $apellido, $cedula_rif, $correo, $fecha_nacimiento, $fh_navegacion, $pagina, $texto_buscado){//CREA SIN VERIFICAR DUPLICADOS
	$fecha_nacimiento=$fecha_nacimiento==''?'00-00-00 00:00:00':$fecha_nacimiento;
	$fh_navegacion=$fh_navegacion==''?'00-00-00 00:00:00':$fh_navegacion;
	$consulta="INSERT INTO `mc_historial_busq_nav`(`TIPO`, `NAVEGACION_IP`, `NOMBRE`, `APELLIDO`, `CEDULA_RIF`, `CORREO`, `FECHA_NACIMIENTO`, `FH_NAVEGACION`, `PAGINA`, `TEXTO_BUSCADO`) VALUES ('$tipo', '$navegacion_ip', '$nombre', '$apellido', '$cedula_rif', '$correo', '$fecha_nacimiento', '$fh_navegacion', '$pagina', '$texto_buscado')";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_historial_de_busqueda_R($conexion, $f_1, $d_1, $f_2, $d_2, $f_3, $d_3){
	//ESTA FUNCION PERMITE LEER HASTA CON 3 FILTROS EJEMPLO: $f_1='NOMBRE DE LA COLUMNA' $d_1='DATO'
	$sql_f_1=($f_1=="" and $d_1=="") ? "" : "AND `mc_historial_busq_nav`.`$f_1`='$d_1'";
	$sql_f_2=($f_2=="" and $d_2=="") ? "" : "AND `mc_historial_busq_nav`.`$f_2`='$d_2'";
	$sql_f_3=($f_3=="" and $d_3=="") ? "" : "AND `mc_historial_busq_nav`.`$f_3`='$d_3'";
	$consulta="SELECT * FROM `mc_historial_busq_nav` WHERE 1 $sql_f_1 $sql_f_2 $sql_f_3";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_HIST_NAV'][$i]='';
	$datos['TIPO'][$i]='';
	$datos['NAVEGACION_IP'][$i]='';
	$datos['NOMBRE'][$i]='';
	$datos['APELLIDO'][$i]='';
	$datos['CEDULA_RIF'][$i]='';
	$datos['CORREO'][$i]='';
	$datos['FECHA_NACIMIENTO'][$i]='';
	$datos['FH_NAVEGACION'][$i]='';
	$datos['PAGINA'][$i]='';
	$datos['TEXTO_BUSCADO'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_HIST_NAV'][$i]=$fila['ID_HIST_NAV'];
		$datos['TIPO'][$i]=$fila['TIPO'];
		$datos['NAVEGACION_IP'][$i]=$fila['NAVEGACION_IP'];
		$datos['NOMBRE'][$i]=$fila['NOMBRE'];
		$datos['APELLIDO'][$i]=$fila['APELLIDO'];
		$datos['CEDULA_RIF'][$i]=$fila['CEDULA_RIF'];
		$datos['CORREO'][$i]=$fila['CORREO'];
		$datos['FECHA_NACIMIENTO'][$i]=$fila['FECHA_NACIMIENTO'];
		$datos['FH_NAVEGACION'][$i]=$fila['FH_NAVEGACION'];
		$datos['PAGINA'][$i]=$fila['PAGINA'];
		$datos['TEXTO_BUSCADO'][$i]=$fila['TEXTO_BUSCADO'];
		$i=$i+1;
	}
	return $datos;
}
function M_historial_de_busqueda_U_id($conexion, $id_hist_nav, $tipo, $navegacion_ip, $nombre, $apellido, $cedula_rif, $correo, $fecha_nacimiento, $fh_navegacion, $pagina, $texto_buscado){//MODIFICA TODOS LOS DATOS
	$fecha_nacimiento=$fecha_nacimiento==''?'00-00-00 00:00:00':$fecha_nacimiento;
	$fh_navegacion=$fh_navegacion==''?'00-00-00 00:00:00':$fh_navegacion;
	$consulta="UPDATE `mc_historial_busq_nav` SET 
	`TIPO`='$tipo', 
	`NAVEGACION_IP`='$navegacion_ip', 
	`NOMBRE`='$nombre', 
	`APELLIDO`='$apellido', 
	`CEDULA_RIF`='$cedula_rif', 
	`CORREO`='$correo', 
	`FECHA_NACIMIENTO`='$fecha_nacimiento', 
	`FH_NAVEGACION`='$fh_navegacion', 
	`PAGINA`='$pagina', 
	`TEXTO_BUSCADO`='$texto_buscado' 
	WHERE `ID_HIST_NAV`='$id_hist_nav'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_historial_de_busqueda_D_id($conexion, $id_hist_nav){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_historial_busq_nav` WHERE `ID_HIST_NAV`='$id_hist_nav'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_historial_de_busqueda_visitas_x_pg($conexion, $desde, $hasta, $tipo){
	$consulta="SELECT `PAGINA` AS PAGINA, COUNT(`ID_HIST_NAV`) AS VISITAS FROM `mc_historial_busq_nav` WHERE `FH_NAVEGACION`>='$desde' AND `FH_NAVEGACION`<='$hasta' AND `TIPO`='$tipo' GROUP BY PAGINA ORDER BY VISITAS DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['PAGINA'][$i]='';
	$datos['VISITAS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['PAGINA'][$i]=$fila['PAGINA'];
		$datos['VISITAS'][$i]=$fila['VISITAS'];
		$i=$i+1;
	}
	return $datos;
}
function M_historial_de_busqueda_visitas_x_dia($conexion, $desde, $hasta, $tipo){
	$consulta="SELECT YEAR(`FH_NAVEGACION`) AS ANO, MONTH(`FH_NAVEGACION`) AS MES, DAY(`FH_NAVEGACION`) AS DIA, COUNT(`ID_HIST_NAV`) AS VISITAS FROM `mc_historial_busq_nav` WHERE `FH_NAVEGACION`>='$desde' AND `FH_NAVEGACION`<='$hasta' AND `TIPO`='$tipo' GROUP BY ANO, MES, DIA ORDER BY ANO, MES, DIA";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ANO'][$i]='';
	$datos['MES'][$i]='';
	$datos['DIA'][$i]='';
	$datos['VISITAS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ANO'][$i]=$fila['ANO'];
		$datos['MES'][$i]=$fila['MES'];
		$datos['DIA'][$i]=$fila['DIA'];
		$datos['VISITAS'][$i]=$fila['VISITAS'];
		$i=$i+1;
	}
	return $datos;
}
function M_historial_de_busqueda_cta_x_palabra($conexion, $desde, $hasta, $tipo){
	$consulta="SELECT `TEXTO_BUSCADO` AS TEXTO_BUSCADO, COUNT(`ID_HIST_NAV`) AS VISITAS FROM `mc_historial_busq_nav` WHERE `TEXTO_BUSCADO`<>'' AND`FH_NAVEGACION`>='$desde' AND `FH_NAVEGACION`<='$hasta' AND `TIPO`='$tipo' GROUP BY TEXTO_BUSCADO ORDER BY VISITAS DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['TEXTO_BUSCADO'][$i]='';
	$datos['VISITAS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['TEXTO_BUSCADO'][$i]=$fila['TEXTO_BUSCADO'];
		$datos['VISITAS'][$i]=$fila['VISITAS'];
		$i=$i+1;
	}
	return $datos;
}
?>