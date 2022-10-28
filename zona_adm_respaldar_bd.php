<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
// SI SE DESEA EXPORTAR LA BASE DE DATOS
if(isset($_POST['accion'])){
	if($_POST['accion']=='exportar'){
		function Export_Database($host, $user, $pass, $name, $tables=false, $backup_name=false ){
			$mysqli = new mysqli($host,$user,$pass,$name); 
			$mysqli->select_db($name); 
			$mysqli->query("SET NAMES 'utf8'");
			$queryTables    = $mysqli->query('SHOW TABLES'); 
			while($row = $queryTables->fetch_row()){ 
				$target_tables[] = $row[0]; 
			}
			if($tables !== false){ 
				$target_tables = array_intersect( $target_tables, $tables); 
			}
			foreach($target_tables as $table){
				$result         =   $mysqli->query('SELECT * FROM '.$table);  
				$fields_amount  =   $result->field_count;  
				$rows_num=$mysqli->affected_rows;     
				$res            =   $mysqli->query('SHOW CREATE TABLE '.$table); 
				$TableMLine     =   $res->fetch_row();
				$content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";
				for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0){
					while($row = $result->fetch_row()){//when started (and every after 100 command cycle):
						if ($st_counter%100==0 || $st_counter==0){
							$content .= "\nINSERT INTO ".$table." VALUES";
						}
						$content .= "\n(";
						for($j=0; $j<$fields_amount; $j++){ 
							$row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
							if (isset($row[$j])){
								$content .= '"'.$row[$j].'"' ; 
							}else{   
								$content .= '""';
							} 
							if($j<($fields_amount-1)){
								$content.= ',';
							}
						}
						$content .=")";
						//every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
						if((($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num){
							$content .= ";";
						}else{
							$content .= ",";
						}
						$st_counter=$st_counter+1;
					}
				}
				$content .="\n\n\n";
			}
			//$backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
			$backup_name = $backup_name ? $backup_name : $name.".sql";
			header('Content-Type: application/octet-stream');   
			header("Content-Transfer-Encoding: Binary"); 
			header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
			echo $content; exit;
		}
		Export_Database($servidor_nombre, $servidor_usuario, $servidor_contrasena, $base_de_datos_nombre, $tables=false, $backup_name=false);
	}
}
//CONSULTANDO LOS NOMBRES DE LAS TABLAS DE LA BASE DE DATOS
$sql1="show tables from " . $base_de_datos_nombre;
$res1=mysqli_query($conexion, $sql1);
$i1=0;
while(($row1=mysqli_fetch_array($res1))==true){
	$tablas[$i1]=$row1[0];//[TABLA]
	//CONSULTANDO LAS COLUMNAS DE CADA TABLA
	$sql2="show columns from " . $tablas[$i1];
	$res2=mysqli_query($conexion, $sql2);
	$i2=0;
	while(($row2=mysqli_fetch_array($res2))==true){
		$columnas[$i1][$i2]=$row2[0];//[TABLA][COLUMNA]
		$columnas_tipos[$i1][$i2]=$row2[1];//[TABLA][COLUMNA]
		//CONSULTANADO LOS DATOS DE CADA TABLA
		$sql3="select `" . $columnas[$i1][$i2] . "` from " . $tablas[$i1];
		$res3=mysqli_query($conexion, $sql3);
		$i3=0;
		while(($row3=mysqli_fetch_array($res3))==true){
			$i4=0;
			while(isset($row3[$i4])){
				$datos[$i1][$i3][$i4]=$row3[$i4];//[TABLA][RENGLON][DATO]
				$i4=$i4+1;
			}
			$i3=$i3+1;
		}
		$filas[$i1]=$i3;//[TABLA]
		$i2=$i2+1;
	}
	$numero_columnas[$i1]=$i2;//[TABLA]
	$i1=$i1+1;
}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>Respaldar BD</title>
</head>
<body>
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<br>
	<section class="container-fluid px-0 mx-0 mt-2 mb-5 bg-dark p-2">
		<div class='text-center pb-2'>
			<form method="post" action="zona_adm_respaldar_bd.php">
				<input type="hidden" name="accion" value="exportar">
				<input type="submit" class="btn btn-danger" value="Exportar Datos &raquo;">
			</form>
		</div>
		<div class="bg-light text-dark p-1 m-1">
			<h4 class="text-center">Base de Datos: <b class="text-danger"><?php echo $base_de_datos_nombre; ?></b></h4>
			<h5 class='text-center'><b><?php echo $i1; ?> Tablas</b></h5>
			<hr>
			<div class="row mb-3">
				<?php
					$o1=0; 
					while(isset($tablas[$o1])){
						echo "<div class='col-md-6 col-lg-4'><b class='small'><b>" . $tablas[$o1] . " </b><br>(";
						$cta=0;
						while(isset($columnas[$o1][$cta])){
							$cta++;
						}
						$total_columnas_i=$cta;
						$cta=0;
						while(isset($datos[$o1][$cta][0])){
							$cta++;
						}
						$total_renglones_i=$cta;
						echo "$total_columnas_i Columnas y $total_renglones_i Renglones)</b></div>"; 
						$o1++;
					} 
				?>
			</div>
		</div>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>
