<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/datos_nav_busq_externos.php"); ?>
<?php //SUMMARY: "https://api.covid19api.com/summary"
	$curl_1=curl_init();
	curl_setopt_array($curl_1, array(
		CURLOPT_URL => "https://api.covid19api.com/summary",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
	));
	$resp_1=curl_exec($curl_1);
	$error = curl_error($curl_1);
	$informacion=curl_getinfo($curl_1);
	curl_close($curl_1);
	$resp_decode_1=(array) json_decode($resp_1,true);
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
	<title>CV - COVID-19 - 2</title>
	<!-- SCRIPT PARA GENERAR MAPA-->
    <script type="text/javascript">
        $(function () {
				<?php
					echo "var data = {";
					echo '"1": { ';
					echo '"areas": { ';
					$i=0;
					while(isset($resp_decode_1["Countries"][$i])){
						echo '"' . $resp_decode_1["Countries"][$i]["CountryCode"] . '": { ';
						echo '"value": ' . $resp_decode_1["Countries"][$i]["TotalConfirmed"] . ', ';
						echo '"tooltip": {';
						echo '"content": "<span><b>' . $resp_decode_1["Countries"][$i]["Country"] . ' (' . $resp_decode_1["Countries"][$i]["CountryCode"] .')</b></span>';
						echo "<small>";
						echo '<br><b>Casos (C):</b> &nbsp;&nbsp;&nbsp;&nbsp;' . number_format($resp_decode_1["Countries"][$i]["TotalConfirmed"], 0,'.',',');
						echo '<br><b>Muerte (M):</b> ' . number_format($resp_decode_1["Countries"][$i]["TotalDeaths"], 0,'.',',') . " (M/C: ";
						if($resp_decode_1["Countries"][$i]["TotalConfirmed"]<>0){
							echo number_format($resp_decode_1["Countries"][$i]["TotalDeaths"]*100/$resp_decode_1["Countries"][$i]["TotalConfirmed"], 2,'.',',') . "%";
						}else{
							echo "0.00%";
						}
						echo ")";
						echo '<br><b>Recup. (R):</b> &nbsp;&nbsp;' . number_format($resp_decode_1["Countries"][$i]["TotalRecovered"], 0,'.',',') . " (R/C: ";
						if($resp_decode_1["Countries"][$i]["TotalConfirmed"]<>0){
							echo number_format($resp_decode_1["Countries"][$i]["TotalRecovered"]*100/$resp_decode_1["Countries"][$i]["TotalConfirmed"], 2,'.',',') . "%";
						}else{
							echo "0.00%";
						}
						echo ")";
						echo '<br><b>Activos (A):</b> &nbsp;' . number_format($resp_decode_1["Countries"][$i]["TotalConfirmed"]-$resp_decode_1["Countries"][$i]["TotalDeaths"]-$resp_decode_1["Countries"][$i]["TotalRecovered"], 0,'.',',') . " (A/C: ";
						if($resp_decode_1["Countries"][$i]["TotalConfirmed"]<>0){
							echo number_format(($resp_decode_1["Countries"][$i]["TotalConfirmed"]-$resp_decode_1["Countries"][$i]["TotalDeaths"]-$resp_decode_1["Countries"][$i]["TotalRecovered"])*100/$resp_decode_1["Countries"][$i]["TotalConfirmed"], 2,'.',',') . "%";
						}else{
							echo "0.00%";
						}
						echo ")";
						echo "</small>";
						echo '"';
						echo '}';
						if(isset($resp_decode_1["Countries"][$i+1])){
							echo '}, ';
						}else{
							echo '} ';
						}
						$i++;
					}
					echo '} ';
					echo "}};";
				?>

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
                areas: data[1]['areas']
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
			<div class="col-xl-2 px-0"></div>
			<div class="col-xl-8 px-0">
				<?php
					$fecha_i=explode("T", $resp_decode_1["Countries"][0]["Date"]);
				?>
				<h4 class="text-center"><b>Distribución Mundial</b> <br><small>(<i>actualizado al <?php echo $fecha_i[0]; ?></i>)</small></h4>
				<div class="world">
					<div class="map"></div>
					<div class="row">
						<div class="col-xl-11 px-0">
							<div class="areaLegend text-center"></div>
						</div>
						<div class="col-xl-1 px-0">
							<div class="knobContainer text-center">
								<input class="knob" data-width="1" data-height="1" data-min="1" data-max="1" data-cursor="true" data-fgColor="#454545" data-thickness=".25" value="1" data-bgColor="#c7e8ff" type="hidden"/>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-2 px-0"></div>
		</div>
		<br>
		<!-- graficos -->
		<div class="row mx-0 pb-3 bg-light">
			<div class="col-12">
				<h3 class="text-center pb-3"><b>Gráficos Diarios</b></h3>
			</div>
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="input-group my-1">
					<div class="col-12 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 px-2">Pais</span>
					</div>
					<select id="pais" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax">
						<option value="VE">Venezuela (Bolivarian Republic)</option>
						<?php
							$i=0;
							while(isset($resp_decode_1["Countries"][$i]["CountryCode"])){
								echo "<option value='" . $resp_decode_1["Countries"][$i]["CountryCode"] . "'>" . $resp_decode_1["Countries"][$i]["Country"] . "</option>";
								$i++;
							}
						?>
					</select>
				</div>
			</div>
			<div class="col-md-4"></div>
		</div>
		<div class="mx-0 p-2 bg-light" id="caja_grafico_01">
			<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#caja_grafico_01").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
				$.ajax("PHP_MODELO/S_covid_2.php",{data:{pais:$("#pais").val()}, type:'post'}).done(function(respuesta){
					$("#caja_grafico_01").hide(5);
					$("#caja_grafico_01").html(respuesta);
					$("#caja_grafico_01").fadeIn(500);
				});
				$(".para_ajax").on('change', function(){
					$("#caja_grafico_01").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
					$.ajax("PHP_MODELO/S_covid_2.php",{data:{pais:$("#pais").val()}, type:'post'}).done(function(respuesta){
						$("#caja_grafico_01").hide(5);
						$("#caja_grafico_01").html(respuesta);
						$("#caja_grafico_01").fadeIn(500);
					});
				});
			});
		</script>
		<br>
		<!-- tabla paises vista para pc -->
		<div class="p-2 rounded border border-secondary table-responsive d-none d-xl-block bg-light">
			<h3 class="text-center"><b>Detalle por Pais</b></h3>
			<table class="table table-bordered table-hover table-striped TablaDinamica">
				<thead>
					<tr class="text-center text-warning bg-dark">
						<th class="align-middle"><b>Pais</b></th>
						<th class="align-middle" title="Casos (Nuevos Casos)"><b>Casos<br>(C)</b></th>
						<th class="align-middle" title="Muertes (Nuevas Muertes)"><b>Muertes<br>(M)</b></th>
						<th class="align-middle" title="Casos Recuperados (Nuevos Casos Recuperados)"><b>Recup<br>(R)</b></th>
						<th class="align-middle" title="Casos Activos"><b>Activos<br>(A)</b></th>
						<th class="align-middle"><b>%<br>M/C</b></th>
						<th class="align-middle"><b>%<br>R/C</b></th>
						<th class="align-middle"><b>%<br>A/C</b></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=0;
					while(isset($resp_decode_1["Countries"][$i]["CountryCode"])){
						echo "<tr>";
						echo "<td class='text-left py-0 my-0'>" . $resp_decode_1["Countries"][$i]["Country"] . "</td>";
						echo "<td class='text-right py-0 my-0' title='" . number_format($resp_decode_1["Countries"][$i]["TotalConfirmed"], 0,'.',',') . "(" . number_format($resp_decode_1["Countries"][$i]["NewConfirmed"], 0,'.',',') . ")'>" . number_format($resp_decode_1["Countries"][$i]["TotalConfirmed"], 0,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0' title='" . number_format($resp_decode_1["Countries"][$i]["TotalDeaths"], 0,'.',',') . "(" . number_format($resp_decode_1["Countries"][$i]["NewDeaths"], 0,'.',',') . ")'>" . number_format($resp_decode_1["Countries"][$i]["TotalDeaths"], 0,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0' title='" . number_format($resp_decode_1["Countries"][$i]["TotalRecovered"], 0,'.',',') . "(" . number_format($resp_decode_1["Countries"][$i]["NewRecovered"], 0,'.',',') . ")'>" . number_format($resp_decode_1["Countries"][$i]["TotalRecovered"], 0,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($resp_decode_1["Countries"][$i]["TotalConfirmed"]-$resp_decode_1["Countries"][$i]["TotalDeaths"]-$resp_decode_1["Countries"][$i]["TotalRecovered"], 0,'.',',') . "</td>";
						if($resp_decode_1["Countries"][$i]["TotalConfirmed"]<>0){
							echo "<td class='text-right py-0 my-0'>" . number_format($resp_decode_1["Countries"][$i]["TotalDeaths"]*100/$resp_decode_1["Countries"][$i]["TotalConfirmed"], 2,'.',',') . "</td>";
						}else{
							echo "<td class='text-right py-0 my-0'>0.00</td>";
						}
						if($resp_decode_1["Countries"][$i]["TotalConfirmed"]<>0){
							echo "<td class='text-right py-0 my-0'>" . number_format($resp_decode_1["Countries"][$i]["TotalRecovered"]*100/$resp_decode_1["Countries"][$i]["TotalConfirmed"], 2,'.',',') . "</td>";
						}else{
							echo "<td class='text-right py-0 my-0'>0.00</td>";
						}
						if($resp_decode_1["Countries"][$i]["TotalConfirmed"]<>0){
							echo "<td class='text-right py-0 my-0'>" . number_format(($resp_decode_1["Countries"][$i]["TotalConfirmed"]-$resp_decode_1["Countries"][$i]["TotalDeaths"]-$resp_decode_1["Countries"][$i]["TotalRecovered"])*100/$resp_decode_1["Countries"][$i]["TotalConfirmed"], 2,'.',',') . "</td>";
						}else{
							echo "<td class='text-right py-0 my-0'>0.00</td>";
						}
						echo "</tr>";
						$i++;
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
			<table class="table table-bordered table-hover table-striped TablaDinamica px-1 mx-0">
				<thead>
					<tr class="text-center text-warning bg-dark">
						<th class="align-middle px-0 m-0" title="Código del País"><small class="fa fa-arrow-circle-down"></small></th>
						<th class="align-middle px-0 m-0"><small>C</small></th>
						<th class="align-middle px-0 m-0"><small>M</small></th>
						<th class="align-middle px-0 m-0"><small>R</small></th>
						<th class="align-middle px-0 m-0"><small>A</small></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=0;
					while(isset($resp_decode_1["Countries"][$i]["CountryCode"])){
						echo "<tr>";
						echo "<td class='text-left py-0 m-0 px-1 w-25' title='" . $resp_decode_1["Countries"][$i]["Country"] . "'><small>" . $resp_decode_1["Countries"][$i]["CountryCode"] . "</td>";
						echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($resp_decode_1["Countries"][$i]["TotalConfirmed"], 0,'.',',') . "</small></td>";
						echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($resp_decode_1["Countries"][$i]["TotalDeaths"], 0,'.',',') . "</small></td>";
						echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($resp_decode_1["Countries"][$i]["TotalRecovered"], 0,'.',',') . "</small></td>";
						echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($resp_decode_1["Countries"][$i]["TotalConfirmed"]-$resp_decode_1["Countries"][$i]["TotalDeaths"]-$resp_decode_1["Countries"][$i]["TotalRecovered"], 0,'.',',') . "</small></td>";
						echo "</tr>";
						$i++;
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