<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/datos_nav_busq_externos.php"); ?>
<?php //obteniendo datos
//TOTAL DE DIAS, CASOS Y MUERTES
$consulta="SELECT MAX(`DIA`) AS DIAS, SUM(`CASOS`) AS CASOS, SUM(`MUERTES`) AS MUERTES, SUM(`RECUPERADOS`) AS RECUPERADOS FROM `datos_diarios`";
$resultados=mysqli_query($conexion,$consulta);
while(($fila=mysqli_fetch_array($resultados))==true){
	$total_de_dias=$fila['DIAS'];
	$total_casos=$fila['CASOS'];
	$total_muertes=$fila['MUERTES'];
	$total_recuperados=$fila['RECUPERADOS'];
	$total_activos=$fila['CASOS']-$fila['RECUPERADOS']-$fila['MUERTES'];
}
//TOTALES POR CONTINENTE
$consulta="SELECT `datos_paises`.`CONTINENTE` AS CONTINENTE, SUM(`datos_diarios`.`CASOS`) AS CASOS, SUM(`datos_diarios`.`MUERTES`) AS MUERTES, SUM(`datos_diarios`.`RECUPERADOS`) AS RECUPERADOS FROM `datos_diarios` INNER JOIN `datos_paises` ON `datos_diarios`.`COD`=`datos_paises`.`COD` WHERE `datos_diarios`.`DIA`>='1' AND `datos_diarios`.`DIA`<='" . $total_de_dias . "' GROUP BY `CONTINENTE` ORDER BY `CASOS` DESC, `CONTINENTE` ASC";
$resultados=mysqli_query($conexion,$consulta);
$cont=0;
while(($fila=mysqli_fetch_array($resultados))==true){
	$continenetes[$cont]['CONTINENTE']=$fila['CONTINENTE'];
	$continenetes[$cont]['CASOS']=$fila['CASOS'];
	$continenetes[$cont]['MUERTES']=$fila['MUERTES'];
	$continenetes[$cont]['RECUPERADOS']=$fila['RECUPERADOS'];
	$continenetes[$cont]['ACTIVOS']=$fila['CASOS']-$fila['RECUPERADOS']-$fila['MUERTES'];
	$consulta2="SELECT SUM(`datos_paises`.`POBLACION`) AS POBLACION FROM `datos_paises`WHERE `datos_paises`.`CONTINENTE`='" . $continenetes[$cont]['CONTINENTE'] . "'";
	$resultados2=mysqli_query($conexion,$consulta2);
	while(($fila2=mysqli_fetch_array($resultados2))==true){
		$continenetes[$cont]['POBLACION']=$fila2['POBLACION'];
	}
	$consulta2="SELECT SUM(`datos_paises`.`SUPERFICIE`) AS SUPERFICIE FROM `datos_paises`WHERE `datos_paises`.`CONTINENTE`='" . $continenetes[$cont]['CONTINENTE'] . "'";
	$resultados2=mysqli_query($conexion,$consulta2);
	while(($fila2=mysqli_fetch_array($resultados2))==true){
		$continenetes[$cont]['SUPERFICIE']=$fila2['SUPERFICIE'];
	}
	$cont++;
}
//TOTALES POR paises
$consulta="SELECT `datos_paises`.`PAIS` AS PAIS, `datos_paises`.`CONTINENTE` AS CONTINENTE, SUM(`datos_diarios`.`CASOS`) AS CASOS, SUM(`datos_diarios`.`MUERTES`) AS MUERTES, SUM(`datos_diarios`.`RECUPERADOS`) AS RECUPERADOS FROM `datos_diarios` INNER JOIN `datos_paises` ON `datos_diarios`.`COD`=`datos_paises`.`COD` WHERE `datos_diarios`.`DIA`>='1' AND `datos_diarios`.`DIA`<='" . $total_de_dias . "' GROUP BY `PAIS` ORDER BY `CASOS` DESC, `PAIS` ASC";
$resultados=mysqli_query($conexion,$consulta);
$cont=0;
while(($fila=mysqli_fetch_array($resultados))==true){
	$pais[$cont]['PAIS']=$fila['PAIS'];
	$pais[$cont]['CONTINENTE']=$fila['CONTINENTE'];
	$pais[$cont]['CASOS']=$fila['CASOS'];
	$pais[$cont]['MUERTES']=$fila['MUERTES'];
	$pais[$cont]['RECUPERADOS']=$fila['RECUPERADOS'];
	$pais[$cont]['ACTIVOS']=$fila['CASOS']-$fila['RECUPERADOS']-$fila['MUERTES'];
	$consulta2="SELECT SUM(`datos_paises`.`POBLACION`) AS POBLACION FROM `datos_paises`WHERE `datos_paises`.`PAIS`='" . $pais[$cont]['PAIS'] . "'";
	$resultados2=mysqli_query($conexion,$consulta2);
	while(($fila2=mysqli_fetch_array($resultados2))==true){
		$pais[$cont]['POBLACION']=$fila2['POBLACION'];
	}
	$consulta2="SELECT SUM(`datos_paises`.`SUPERFICIE`) AS SUPERFICIE FROM `datos_paises`WHERE `datos_paises`.`PAIS`='" . $pais[$cont]['PAIS'] . "'";
	$resultados2=mysqli_query($conexion,$consulta2);
	while(($fila2=mysqli_fetch_array($resultados2))==true){
		$pais[$cont]['SUPERFICIE']=$fila2['SUPERFICIE'];
	}
	$cont++;
}
//datos para mapa
$sem=1;
$mapa[$sem]['COD']='';
$mapa[$sem]['PAIS']='';
$mapa[$sem]['CASOS']='';
$mapa[$sem]['MUERTES']='';
while($sem<=$total_de_dias/7){
	$consulta="SELECT `datos_diarios`.`COD` AS COD, `datos_paises`.`PAIS` AS PAIS, MAX(`datos_paises`.`POBLACION`) AS POBLACION, MAX(`datos_paises`.`SUPERFICIE`) AS SUPERFICIE, SUM(`datos_diarios`.`CASOS`) AS CASOS, SUM(`datos_diarios`.`MUERTES`) AS MUERTES, SUM(`datos_diarios`.`RECUPERADOS`) AS RECUPERADOS FROM `datos_diarios` INNER JOIN `datos_paises` ON `datos_diarios`.`COD`=`datos_paises`.`COD` WHERE `datos_diarios`.`DIA`>='1' AND `datos_diarios`.`DIA`<='" . $sem*7 . "' GROUP BY `COD` ORDER BY `COD` ASC";
	$resultados=mysqli_query($conexion,$consulta);
	$cod=1;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$mapa[$sem][$cod]['COD']=$fila['COD'];
		$mapa[$sem][$cod]['PAIS']=$fila['PAIS'];
		$mapa[$sem][$cod]['POBLACION']=$fila['POBLACION'];
		$mapa[$sem][$cod]['SUPERFICIE']=$fila['SUPERFICIE'];
		$mapa[$sem][$cod]['CASOS']=$fila['CASOS'];
		$mapa[$sem][$cod]['MUERTES']=$fila['MUERTES'];
		$mapa[$sem][$cod]['RECUPERADOS']=$fila['RECUPERADOS'];
		$mapa[$sem][$cod]['ACTIVOS']=$fila['CASOS']-$fila['RECUPERADOS']-$fila['MUERTES'];
		$cod++;
	}
	$sem++;
}
if($sem-1<>$total_de_dias/7){
	$consulta="SELECT `datos_diarios`.`COD` AS COD, `datos_paises`.`PAIS` AS PAIS, MAX(`datos_paises`.`POBLACION`) AS POBLACION, MAX(`datos_paises`.`SUPERFICIE`) AS SUPERFICIE, SUM(`datos_diarios`.`CASOS`) AS CASOS, SUM(`datos_diarios`.`MUERTES`) AS MUERTES, SUM(`datos_diarios`.`RECUPERADOS`) AS RECUPERADOS FROM `datos_diarios` INNER JOIN `datos_paises` ON `datos_diarios`.`COD`=`datos_paises`.`COD` WHERE `datos_diarios`.`DIA`>='1' AND `datos_diarios`.`DIA`<='" . $total_de_dias . "' GROUP BY `COD` ORDER BY `COD` ASC";
	$resultados=mysqli_query($conexion,$consulta);
	$cod=1;
	while(($fila=mysqli_fetch_array($resultados))==true){
		$mapa[$sem][$cod]['COD']=$fila['COD'];
		$mapa[$sem][$cod]['PAIS']=$fila['PAIS'];
		$mapa[$sem][$cod]['POBLACION']=$fila['POBLACION'];
		$mapa[$sem][$cod]['SUPERFICIE']=$fila['SUPERFICIE'];
		$mapa[$sem][$cod]['CASOS']=$fila['CASOS'];
		$mapa[$sem][$cod]['MUERTES']=$fila['MUERTES'];
		$mapa[$sem][$cod]['RECUPERADOS']=$fila['RECUPERADOS'];
		$mapa[$sem][$cod]['ACTIVOS']=$fila['CASOS']-$fila['RECUPERADOS']-$fila['MUERTES'];
		$cod++;
	}
	$total_de_semanas=$sem;
}else{
	$total_de_semanas=$sem-1;
}
//MAXIMO DE CASOS
$consulta="SELECT `COD`, SUM(`CASOS`) AS CASOS FROM `datos_diarios` WHERE `DIA`>='1' AND `DIA`<='" . $total_de_dias . "' GROUP BY `COD` ORDER BY `CASOS` ASC";
$resultados=mysqli_query($conexion,$consulta);
while(($fila=mysqli_fetch_array($resultados))==true){
	$max_de_casos=$fila['CASOS'];
}
//MAXIMO DE CASOS
$consulta="SELECT `FECHA` FROM `datos_diarios` WHERE `DIA`='" . $total_de_dias . "' GROUP BY `FECHA`";
$resultados=mysqli_query($conexion,$consulta);
while(($fila=mysqli_fetch_array($resultados))==true){
	$fecha_max=$fila['FECHA'];
}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/seo_meta.php") ?>
	<?php require ("PHP_REQUIRES/head_principal.php"); ?>
	<!-- ENLACES PARA GRAFICO DE MAPA "MAPAEL"-->
    <script src="js/jquery.min.js" charset="utf-8"></script>
    <script src="js/jquery.mousewheel.min.js" charset="utf-8"></script>
    <script src="js/raphael.min.js" charset="utf-8"></script>
    <script src="js/jquery.mapael.js" charset="utf-8"></script>
    <script src="js/jquery.knob.min.js" charset="utf-8"></script>
    <script src="js/maps/world_countries.js" charset="utf-8"></script>
	<title>CV - COVID-19</title>
	<!-- SCRIPT PARA GENERAR MAPA-->
    <script type="text/javascript">
        $(function () {
            var data = {
				<?php
					$sem=1;
					while(isset($mapa[$sem][1]['COD'])){
						echo '"' . $sem . '": { ';
						echo '"areas": { ';
						$cod=1;
						while(isset($mapa[$sem][$cod]['COD'])){
							echo '"' . $mapa[$sem][$cod]['COD'] . '": { ';
							echo '"value": ' . $mapa[$sem][$cod]['CASOS'] . ', ';
							echo '"tooltip": {';
							echo '"content": "<span><b>' . $mapa[$sem][$cod]['PAIS'] . '</b></span>';
							echo "<small>";
							echo '<br><b>Casos (C):</b> &nbsp;&nbsp;&nbsp;&nbsp;' . number_format($mapa[$sem][$cod]['CASOS'], 0,'.',',');
							echo '<br><b>Muerte (M):</b> ' . number_format($mapa[$sem][$cod]['MUERTES'], 0,'.',',') . " (M/C: ";
							if($mapa[$sem][$cod]['CASOS']<>0){
								echo number_format($mapa[$sem][$cod]['MUERTES']*100/$mapa[$sem][$cod]['CASOS'], 2,'.',',') . "%";
							}else{
								echo "0.00%";
							}
							echo ")";
							echo '<br><b>Recup. (R):</b> &nbsp;&nbsp;' . number_format($mapa[$sem][$cod]['RECUPERADOS'], 0,'.',',') . " (R/C: ";
							if($mapa[$sem][$cod]['CASOS']<>0){
								echo number_format($mapa[$sem][$cod]['RECUPERADOS']*100/$mapa[$sem][$cod]['CASOS'], 2,'.',',') . "%";
							}else{
								echo "0.00%";
							}
							echo ")";
							echo '<br><b>Activos (A):</b> &nbsp;' . number_format($mapa[$sem][$cod]['ACTIVOS'], 0,'.',',') . " (A/C: ";
							if($mapa[$sem][$cod]['CASOS']<>0){
								echo number_format($mapa[$sem][$cod]['ACTIVOS']*100/$mapa[$sem][$cod]['CASOS'], 2,'.',',') . "%";
							}else{
								echo "0.00%";
							}
							echo ")";
							echo "</small>";
							echo '"';
							echo '} ';
							if(isset($mapa[$sem][$cod+1]['COD'])){
								echo '}, ';
							}else{
								echo '} ';
							}
							$cod++;
						}
						
						echo '} ';
						if(isset($mapa[$sem+1][1]['COD'])){
							echo '}, ';
						}else{
							echo '} ';
						}
						$sem++;
					}
				?>
            };

            // Knob initialisation (for selecting a year)
            $(".knob").knob({
                release: function (value) {
                    $(".world").trigger('update', [{
                        mapOptions: data[value],
                        animDuration: 300
                    }]);
                }
            });

            // Mapael initialisation
            $world = $(".world");
            $world.mapael({
                map: {
                    name: "world_countries",
                    defaultArea: {
                        attrs: {
                            fill: "#fff",
                            stroke: "#232323",
                            "stroke-width": 0.3
                        }
                    },
                    defaultPlot: {
                        text: {
                            attrs: {
                                fill: "#b4b4b4",
                                "font-weight": "normal"
                            },
                            attrsHover: {
                                fill: "#fff",
                                "font-weight": "bold"
                            }
                        }
                    }
                    , zoom: {
                        enabled: true
                        , step: 0.25
                        , maxLevel: 20
                    }
                },
                legend: {
                    area: {
                        mode: "horizontal",
                        display: true,
                        marginBottom: 7,
                        slices: [
                            {
                                max: 50,
                                attrs: {
                                    fill: "#C4BD97"
                                },
                                label: ">0"
                            },
                            {
                                min: 50,
                                max: 500,
                                attrs: {
                                    fill: "#A9F5B2"
                                },
                                label: ">50"
                            },
                            {
                                min: 500,
                                max: 5000,
                                attrs: {
                                    fill: "#92D050"
                                },
                                label: ">500"
                            },
                            {
                                min: 5000,
                                max: 50000,
                                attrs: {
                                    fill: "#FFFF00"
                                },
                                label: ">5M"
                            },
                            {
                                min: 50000,
                                max: 500000,
                                attrs: {
                                    fill: "#E46C0A"
                                },
                                label: ">50M"
                            },
                            {
                                min: 500000,
                                attrs: {
                                    fill: "#AA0000"
                                },
                                label: ">500M Casos"
                            }
                        ]
                    }
                },
                areas: data[<?php echo $total_de_semanas; ?>]['areas']
            });
        });
    </script>	
	<style>
		/* ESTILOS DEL MAPAEL */
		.knobContainer {
			text-align: center;
			margin: 10px;
		}
		.knobContainer canvas {
			cursor: pointer;
		}
		.mapael .mapTooltip {
			position: absolute;
			background-color: #fff;
			moz-opacity: 0.80;
			opacity: 0.80;
			filter: alpha(opacity=80);
			border-radius: 4px;
			padding: 10px;
			z-index: 1000;
			display: none;
			color: #232323;
		}
		.mapael .map {
			overflow: hidden;
			position: relative;
			background-color: #aaf;
			border-radius: 5px;
		}
		/* For all zoom buttons */
		.mapael .zoomButton {
			background-color: #fff;
			border: 1px solid #ccc;
			color: #000;
			width: 15px;
			height: 15px;
			line-height: 15px;
			text-align: center;
			border-radius: 3px;
			cursor: pointer;
			position: absolute;
			top: 0;
			font-weight: bold;
			left: 10px;

			-webkit-user-select: none;
			-khtml-user-select : none;
			-moz-user-select: none;
			-o-user-select : none;
			user-select: none;
		}
		/* Reset Zoom button first */
		.mapael .zoomReset {
			top: 10px;
		}
		/* Then Zoom In button */
		.mapael .zoomIn {
			top: 30px;
		}
		/* Then Zoom Out button */
		.mapael .zoomOut {
			top: 50px;
		}
	</style>	
</head>
<body class="bg-secondary">
	<?php require ("PHP_REQUIRES/nav_principal.php"); ?>
	<div class="container-fluid py-5 mt-5">
		<!-- mapa -->
		<div class="row px-1 bg-light">
			<h1 class="col-12 text-danger text-center p-2"><i><b>COVID-19</b></i></h1>
			<div class="col-xl-9 px-0">
				<h4 class="text-center"><b>Distribución Mundial de Contagio en <?php echo $total_de_semanas; ?> Semanas</b> <small>(<i>actualizado al <?php echo $fecha_max; ?></i>)</small></h4>
				<div class="world">
					<div class="map"></div>
					<div class="row">
						<div class="col-xl-9 px-0">
							<div class="areaLegend text-center"></div>
						</div>
						<div class="col-xl-3 px-0">
							<h6 class="text-center"><small>Cambia la semana</small></h6>
							<div class="knobContainer text-center">
								<input class="knob" data-width="60" data-height="60" data-min="1" data-max="<?php echo $total_de_semanas; ?>" data-cursor="true" data-fgColor="#454545" data-thickness=".25" value="<?php echo $total_de_semanas; ?>" data-bgColor="#c7e8ff"/>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 px-0">
				<div>
					<h4 class="text-center"><b>Resumen por Continente</b></h4>
					<h6 class="text-center bg-dark text-light my-0 border border-light pt-3 pb-2">Casos = (C) Muertes = (M)<br>Recuperados = (R)</h6>
					<table class="table table-bordered table-striped">
						<thead>
							<tr class="text-center text-warning bg-dark">
								<th class="align-middle"><span class="fa fa-arrow-circle-down"></span></th>
								<th class="align-middle"><b>(C)</b></th>
								<th class="align-middle"><b>(M)</b></th>
								<th class="align-middle"><b>(R)</b></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$cont=0;
							while(isset($continenetes[$cont]['CONTINENTE'])){
								echo "<tr>";
								echo "<td class='text-left mx-0 px-1'>" . $continenetes[$cont]['CONTINENTE'] . "</td>";
								echo "<td class='text-right mx-0 px-1'>" . number_format($continenetes[$cont]['CASOS'], 0,'.',',') . "</td>";
								echo "<td class='text-right mx-0 px-1'>" . number_format($continenetes[$cont]['MUERTES'], 0,'.',',') . "</td>";
								echo "<td class='text-right mx-0 px-1'>" . number_format($continenetes[$cont]['RECUPERADOS'], 0,'.',',') . "</td>";
								echo "</tr>";
								$cont++;
							}
							//Totales
							echo "<tr class='bg-dark text-light'>";
							echo "<td class='text-center text-warning mx-0 px-1'><b>Total:</b></td>";
							echo "<td class='text-right mx-0 px-1'><b>" . number_format($total_casos, 0,'.',',') . "</b></td>";
							echo "<td class='text-right mx-0 px-1'><b>" . number_format($total_muertes, 0,'.',',') . "</b></td>";
							echo "<td class='text-right mx-0 px-1'><b>" . number_format($total_recuperados, 0,'.',',') . "</b></td>";
							echo "</tr>";
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<br>
		<!-- graficos -->
		<div class="row mx-0 pb-3 bg-light">
			<div class="col-12">
				<h3 class="text-center pb-3"><b>Gráficos Diarios</b></h3>
			</div>
			<div class="col-md-3"></div>
			<div class="col-md-3">
				<div class="input-group my-1">
					<div class="col-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 px-2">Región</span>
					</div>
					<select id="continente" class="form-control col-9 p-0 m-0 px-2 rounded-0 para_ajax">
						<option>Todos</option>
						<?php
							$cont=0;
							while(isset($continenetes[$cont]['CONTINENTE'])){
								echo "<option>" . $continenetes[$cont]['CONTINENTE'] . "</option>";
								$cont++;
							}
						?>
					</select>
				</div>
			</div>
			<div class="col-md-3">
				<div class="input-group my-1">
					<div class="col-3 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 px-2">Pais</span>
					</div>
					<select id="pais" class="form-control col-9 p-0 m-0 px-2 rounded-0 para_ajax">
						<option>Todos</option>
						<?php
							$cont=0;
							while(isset($pais[$cont]['PAIS'])){
								$parte_ii[$cont]=explode(" ", $pais[$cont]['PAIS']);
								$xxx=str_replace(",","",$parte_ii[$cont][0]);
								echo "<option value='" . $pais[$cont]['PAIS'] . "'>" . $pais[$cont]['PAIS'] . "</option>";
								$cont++;
							}
						?>
					</select>
				</div>
			</div>
			<div class="col-md-3"></div>
		</div>
		<div class="mx-0 p-2 bg-light" id="caja_grafico_01">
			<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#caja_grafico_01").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
				$.ajax("PHP_MODELO/S_covid_1.php",{data:{continente:$("#continente").val(), pais:$("#pais").val()}, type:'post'}).done(function(respuesta){
					$("#caja_grafico_01").hide(5);
					$("#caja_grafico_01").html(respuesta);
					$("#caja_grafico_01").fadeIn(500);
				});
				$(".para_ajax").on('change', function(){
					$("#caja_grafico_01").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
					$.ajax("PHP_MODELO/S_covid_1.php",{data:{continente:$("#continente").val(), pais:$("#pais").val()}, type:'post'}).done(function(respuesta){
						$("#caja_grafico_01").hide(5);
						$("#caja_grafico_01").html(respuesta);
						$("#caja_grafico_01").fadeIn(500);
					});
				});
			});
		</script>
		<br>
		<!-- tabla continentes vista para pc -->
		<div class="p-2 rounded border border-secondary table-responsive d-none d-xl-block bg-light">
			<h3 class="text-center d-none d-xl-block"><b>Detalle por Continente</b></h3>
			<table class="table table-bordered table-hover table-striped TablaDinamica">
				<thead>
					<tr class="text-center text-warning bg-dark">
						<th class="align-middle"><b>Continente</b></th>
						<th class="align-middle"><b>Casos<br>(C)</b></th>
						<th class="align-middle"><b>Muertes<br>(M)</b></th>
						<th class="align-middle" title="Casos Recuperados"><b>Recup<br>(R)</b></th>
						<th class="align-middle" title="Casos Activos"><b>Activos<br>(A)</b></th>
						<th class="align-middle"><b>%<br>M/C</b></th>
						<th class="align-middle"><b>%<br>R/C</b></th>
						<th class="align-middle"><b>%<br>A/C</b></th>
						<th class="align-middle"><b>C por<br>MMHab</b></th>
						<th class="align-middle"><b>M por<br>MMHab</b></th>
						<th class="align-middle"><b>R por<br>MMHab</b></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$cont=0;
					while(isset($continenetes[$cont]['CONTINENTE'])){
						echo "<tr>";
						echo "<td class='text-left py-0 my-0'>" . $continenetes[$cont]['CONTINENTE'] . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($continenetes[$cont]['CASOS'], 0,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($continenetes[$cont]['MUERTES'], 0,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($continenetes[$cont]['RECUPERADOS'], 0,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($continenetes[$cont]['ACTIVOS'], 0,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($continenetes[$cont]['MUERTES']*100/$continenetes[$cont]['CASOS'], 2,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($continenetes[$cont]['RECUPERADOS']*100/$continenetes[$cont]['CASOS'], 2,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($continenetes[$cont]['ACTIVOS']*100/$continenetes[$cont]['CASOS'], 2,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($continenetes[$cont]['CASOS']*1000000/$continenetes[$cont]['POBLACION'], 3,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($continenetes[$cont]['MUERTES']*1000000/$continenetes[$cont]['POBLACION'], 3,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($continenetes[$cont]['RECUPERADOS']*1000000/$continenetes[$cont]['POBLACION'], 3,'.',',') . "</td>";
						echo "</tr>";
						$cont++;
					}
					?>
				</tbody>
			</table>
		</div>
		<br>
		<!-- tabla paises vista para pc -->
		<div class="p-2 rounded border border-secondary table-responsive d-none d-xl-block bg-light">
			<h3 class="text-center"><b>Detalle por Pais</b></h3>
			<table class="table table-bordered table-hover table-striped TablaDinamica">
				<thead>
					<tr class="text-center text-warning bg-dark">
						<th class="align-middle"><b>Pais</b></th>
						<th class="align-middle"><b>Continente</b></th>
						<th class="align-middle"><b>Casos<br>(C)</b></th>
						<th class="align-middle"><b>Muertes<br>(M)</b></th>
						<th class="align-middle" title="Casos Recuperados"><b>Recup<br>(R)</b></th>
						<th class="align-middle" title="Casos Activos"><b>Activos<br>(A)</b></th>
						<th class="align-middle"><b>%<br>M/C</b></th>
						<th class="align-middle"><b>%<br>R/C</b></th>
						<th class="align-middle"><b>%<br>A/C</b></th>
						<th class="align-middle"><b>C por<br>MMHab</b></th>
						<th class="align-middle"><b>M por<br>MMHab</b></th>
						<th class="align-middle"><b>R por<br>MMHab</b></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$cont=0;
					while(isset($pais[$cont]['PAIS'])){
						echo "<tr>";
						echo "<td class='text-left py-0 my-0'>" . $pais[$cont]['PAIS'] . "</td>";
						echo "<td class='text-left py-0 my-0'>" . $pais[$cont]['CONTINENTE'] . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($pais[$cont]['CASOS'], 0,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($pais[$cont]['MUERTES'], 0,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($pais[$cont]['RECUPERADOS'], 0,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($pais[$cont]['ACTIVOS'], 0,'.',',') . "</td>";
						if($pais[$cont]['CASOS']<>0){
							echo "<td class='text-right py-0 my-0'>" . number_format($pais[$cont]['MUERTES']*100/$pais[$cont]['CASOS'], 2,'.',',') . "</td>";
						}else{
							echo "<td class='text-right py-0 my-0'>0.00</td>";
						}
						if($pais[$cont]['CASOS']<>0){
							echo "<td class='text-right py-0 my-0'>" . number_format($pais[$cont]['RECUPERADOS']*100/$pais[$cont]['CASOS'], 2,'.',',') . "</td>";
						}else{
							echo "<td class='text-right py-0 my-0'>0.00</td>";
						}
						if($pais[$cont]['CASOS']<>0){
							echo "<td class='text-right py-0 my-0'>" . number_format($pais[$cont]['ACTIVOS']*100/$pais[$cont]['CASOS'], 2,'.',',') . "</td>";
						}else{
							echo "<td class='text-right py-0 my-0'>0.00</td>";
						}
						if($pais[$cont]['POBLACION']<>0){
							echo "<td class='text-right py-0 my-0'>" . number_format($pais[$cont]['CASOS']*1000000/$pais[$cont]['POBLACION'], 3,'.',',') . "</td>";
						}else{
							echo "<td class='text-right py-0 my-0'>0.00</td>";
						}
						if($pais[$cont]['POBLACION']<>0){
							echo "<td class='text-right py-0 my-0'>" . number_format($pais[$cont]['MUERTES']*1000000/$pais[$cont]['POBLACION'], 3,'.',',') . "</td>";
						}else{
							echo "<td class='text-right py-0 my-0'>0.00</td>";
						}
						if($pais[$cont]['POBLACION']<>0){
							echo "<td class='text-right py-0 my-0'>" . number_format($pais[$cont]['RECUPERADOS']*1000000/$pais[$cont]['POBLACION'], 3,'.',',') . "</td>";
						}else{
							echo "<td class='text-right py-0 my-0'>0.00</td>";
						}
						echo "</tr>";
						$cont++;
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<br>
	<!-- tabla paises vista para movil -->
	<div class="container-fluid px-0">
		<div class="table-responsive d-block d-xl-none px-0 mx-0 bg-light">
			<h3 class="text-center"><b>Detalle por Pais</b></h3>
			<table class="table table-bordered table-hover table-striped TablaDinamica px-0 mx-0">
				<thead>
					<tr class="text-center text-warning bg-dark">
						<th class="align-middle px-0 m-0"><b>Pais</b></th>
						<th class="align-middle px-0 m-0"><b>(C)</b></th>
						<th class="align-middle px-0 m-0"><b>(M)</b></th>
						<th class="align-middle px-0 m-0"><b>(R)</b></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$cont=0;
					while(isset($pais[$cont]['PAIS'])){
						echo "<tr>";
						echo "<td class='text-left py-0 m-0 px-1 w-25'><small>" . $pais[$cont]['PAIS'] . "</td>";
						echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($pais[$cont]['CASOS'], 0,'.',',') . "</small></td>";
						echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($pais[$cont]['MUERTES'], 0,'.',',') . "</small></td>";
						echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($pais[$cont]['RECUPERADOS'], 0,'.',',') . "</small></td>";
						echo "</tr>";
						$cont++;
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<?php require ("PHP_REQUIRES/carrusel_principal.php"); ?>
	<?php require ("PHP_REQUIRES/categorias_y_etiquetas.php"); ?>
	<?php require ("PHP_REQUIRES/footer_principal.php"); ?>
</body>
</html>