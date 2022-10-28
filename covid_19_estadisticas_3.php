<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/datos_nav_busq_externos.php"); ?>
<?php //obteniendo datos
	//CALCULANDO LAS FECHAS DE LOS LUNES DE CADA SEMANA PR EL MAPA
	for($i=strtotime("2020-01-22"); $i<=strtotime(date("Y-m-d")); $i+=86400){
		$dia=date("d" , $i);
		if($dia==1){
			$fechas_mapa[]=date("Y-m-d", $i);
		}
	}
	if(strtotime($fechas_mapa[count($fechas_mapa)-1])<>strtotime(date("Y-m-d"))){
		$fechas_mapa[]=date("Y-m-d");
		//EJEMPLO: $fechas_mapa[0]="fecha 1";
	}
	//OBTENIENDO NOMBRES DE PAISES POR CODIGO:
	$curl=curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://covid19-api.org/api/countries",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
	));
	$resp=curl_exec($curl);
	$error = curl_error($curl);
	$informacion=curl_getinfo($curl);
	curl_close($curl);
	$resp_pais=(array) json_decode($resp,true);
	for($i=0; $i<=count($resp_pais)-1; $i++){
		$nombres_paises[$resp_pais[$i]['alpha2']]=$resp_pais[$i]['name'];
		//EJEMPLO: $nombres_paises["VE"]="Venezuela";
	}
	//OBTENIENDO DATOS DEL MAPA PARA TODAS LAS SEMANAS:
	for($i=0; $i<=count($fechas_mapa)-1; $i++){
		$curl=curl_init();
		$fecha_consulta=date("Y-m-d", strtotime($fechas_mapa[$i] . "+ 1 days"));
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://covid19-api.org/api/status?date=" . $fecha_consulta . "",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
		));
		$resp=curl_exec($curl);
		curl_close($curl);
		$resp_datos[$i]=(array) json_decode($resp,true);
		//EJEMPLO:
		//$resp_datos[0]="TODA LA INFORMACIÓN DE LA FECHA 1";
		//$resp_datos[0][0]="TODA LA INFORMACIÓN DEL PRIMER PAIS DE LA FECHA 1";
		//$resp_datos[0][0]['country']="NOMBR COMPLETO DEL PAIS";
		//$resp_datos[0][0]['last_update']="ULTIMA FECHA DE ACTUALIZACIÓN";
		//$resp_datos[0][0]['cases']="CASOS CONFIRMADOS";
		//$resp_datos[0][0]['deaths']="MUERTES";
		//$resp_datos[0][0]['recovered']="RECUPERADOS";
	}
	

/*
	//rellenando el array
	for($pais_max_dia=0; $pais_max_dia<count($resp_datos[count($fechas_mapa)-1]); $pais_max_dia++){
		for($dia_i=0; $dia_i<count($fechas_mapa)-1; $dia_i++){
			$verf=false;
			for($pais_i=0; $pais_i<count($resp_datos[$dia_i]); $pais_i++){
				if($resp_datos[count($fechas_mapa)-1][$pais_max_dia]['country']==$resp_datos[$dia_i][$pais_i]['country']){
					$verf=true;
				}
				if(!$verf){
					$resp_datos[$dia_i][count($resp_datos[$dia_i])]['country']=$resp_datos[count($fechas_mapa)-1][$pais_max_dia]['country'];
					$resp_datos[$dia_i][count($resp_datos[$dia_i])]['cases']=0;
					$resp_datos[$dia_i][count($resp_datos[$dia_i])]['deaths']=0;
					$resp_datos[$dia_i][count($resp_datos[$dia_i])]['recovered']=0;
				}
			}
		}
	}

	echo "<br><br><br><br>";
	for($i=0; $i<=count($fechas_mapa)-1; $i++){
		echo "Largo de " . $fechas_mapa[$i] . " = " . count($resp_datos[$i]) . "<br>";
	}
	
*/
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
					$i=0;
					while(isset($resp_datos[$i][0]['country'])){
						$sem=$i+1;
						echo '"' . $sem . '": { ';
						echo '"areas": { ';
						$cod=0;
						while(isset($resp_datos[$i][$cod]['country'])){
							echo '"' . $resp_datos[$i][$cod]['country'] . '": { ';
							echo '"value": ' . $resp_datos[$i][$cod]['cases'] . ', ';
							echo '"tooltip": {';
							echo '"content": "<span><b>' . $nombres_paises[$resp_datos[$i][$cod]['country']] . '</b></span>';
							echo "<small>";
							echo '<br><b>C: </b>' . number_format($resp_datos[$i][$cod]['cases'], 0,'.',',');
							echo '<br><b>M: </b>' . number_format($resp_datos[$i][$cod]['deaths'], 0,'.',',') . " (M/C: ";
							if($resp_datos[$i][$cod]['cases']<>0){
								echo number_format($resp_datos[$i][$cod]['deaths']*100/$resp_datos[$i][$cod]['cases'], 2,'.',',') . "%";
							}else{
								echo "0.00%";
							}
							echo ")";
							echo '<br><b>R: </b>' . number_format($resp_datos[$i][$cod]['recovered'], 0,'.',',') . " (R/C: ";
							if($resp_datos[$i][$cod]['cases']<>0){
								echo number_format($resp_datos[$i][$cod]['recovered']*100/$resp_datos[$i][$cod]['cases'], 2,'.',',') . "%";
							}else{
								echo "0.00%";
							}
							echo ")";
							$activos=$resp_datos[$i][$cod]['cases']-$resp_datos[$i][$cod]['deaths']-$resp_datos[$i][$cod]['recovered'];
							echo '<br><b>A: </b>' . number_format($activos, 0,'.',',') . " (A/C: ";
							if($resp_datos[$i][$cod]['cases']<>0){
								echo number_format($activos*100/$resp_datos[$i][$cod]['cases'], 2,'.',',') . "%";
							}else{
								echo "0.00%";
							}
							echo ")";
							echo "</small>";
							echo '"';
							echo '} ';
							if(isset($resp_datos[$i][$cod+1]['country'])){
								echo '}, ';
							}else{
								echo '} ';
							}
							$cod++;
						}
						
						echo '} ';
						if(isset($resp_datos[$i+1][0]['country'])){
							echo '}, ';
						}else{
							echo '} ';
						}
						$i++;
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
                areas: data[<?php echo count($fechas_mapa); ?>]['areas']
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
	<!-- mapa -->
	<div class="container-fluid py-5 mt-5">
		<div class="row px-1 bg-light">
			<h1 class="col-12 text-danger text-center p-2"><i><b>COVID-19</b></i></h1>
			<div class="col-xl-1 px-0"></div>
			<div class="col-xl-10 px-0">
				<h4 class="text-center"><b>Distribución Mundial de Contagios por mes</b><br><small>(<i>actualizado al <?php echo $fechas_mapa[count($fechas_mapa)-1]; ?></i>)</small></h4>
				<div class="world">
					<div class="map"></div>
					<div class="row">
						<div class="col-xl-9 px-0">
							<div class="areaLegend text-center"></div>
						</div>
						<div class="col-xl-3 px-0">
							<h6 class="text-center"><small>Cambia el mes</small></h6>
							<div class="knobContainer text-center">
								<input class="knob" data-width="60" data-height="60" data-min="1" data-max="<?php echo count($fechas_mapa); ?>" data-cursor="true" data-fgColor="#454545" data-thickness=".25" value="<?php echo count($fechas_mapa); ?>" data-bgColor="#c7e8ff"/>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-1 px-0"></div>
		</div>
	</div>
	<br>
	<!-- graficos -->
	<div class="container-fluid py-5 mt-5">
		<div class="row pb-3 bg-light">
			<div class="col-12">
				<h3 class="text-center pb-3"><b>Gráficos Por País</b></h3>
			</div>
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="input-group my-1">
					<div class="col-12 p-0 m-0">
						<span class="input-group-text rounded-0 w-100 px-2">Pais</span>
					</div>
					<select id="pais" class="form-control col-12 p-0 m-0 px-2 rounded-0 para_ajax">
						<option value="WW">All World</option>
						<?php
							$i=0;
							while(isset($resp_datos[count($fechas_mapa)-1][$i]["country"])){
								echo "<option value='" . $resp_datos[count($fechas_mapa)-1][$i]["country"] . "'>" . $nombres_paises[$resp_datos[count($fechas_mapa)-1][$i]["country"]] . " (" . $resp_datos[count($fechas_mapa)-1][$i]["country"] . ")</option>";
								$i++;
							}
						?>
					</select>
				</div>
			</div>
			<div class="col-md-4"></div>
			<div class="col-12 p-1 bg-light" id="caja_grafico_01">
				<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>
			</div>
			<script type="text/javascript">
				$(document).ready(function(){
					$("#caja_grafico_01").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
					$.ajax("PHP_MODELO/S_covid_3.php",{data:{pais:$("#pais").val()}, type:'post'}).done(function(respuesta){
						$("#caja_grafico_01").hide(5);
						$("#caja_grafico_01").html(respuesta);
						$("#caja_grafico_01").fadeIn(500);
					});
					$(".para_ajax").on('change', function(){
						$("#caja_grafico_01").html("<h3 class='text-muted text-center py-5'><span class='fa fa-spinner fa-spin'></span> Cargando...</h3>");
						$.ajax("PHP_MODELO/S_covid_3.php",{data:{pais:$("#pais").val()}, type:'post'}).done(function(respuesta){
							$("#caja_grafico_01").hide(5);
							$("#caja_grafico_01").html(respuesta);
							$("#caja_grafico_01").fadeIn(500);
						});
					});
				});
			</script>
		</div>
	</div>
	<br>
	<!-- tabla paises vista para pc -->
	<div class="container-fluid px-0">
		<div class="p-2 rounded border border-secondary table-responsive d-none d-xl-block bg-light">
			<h3 class="text-center"><b>Detalle por Pais</b></h3>
			<table class="table table-bordered table-hover table-striped TablaDinamicaOrderDesc2">
				<thead>
					<tr class="text-center text-warning bg-dark">
						<th class="align-middle"><b>Pais</b></th>
						<th class="align-middle" title="Casos Confirmados"><b>C</b></th>
						<th class="align-middle" title="Muertes Registradas"><b>M</b></th>
						<th class="align-middle" title="Casos Recuperados"><b>R</b></th>
						<th class="align-middle" title="Casos Activos"><b>A</b></th>
						<th class="align-middle"><b>%<br>M/C</b></th>
						<th class="align-middle"><b>%<br>R/C</b></th>
						<th class="align-middle"><b>%<br>A/C</b></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$acum_casos=0;
					$acum_muertes=0;
					$acum_recuperados=0;
					$i=0;
					while(isset($resp_datos[count($fechas_mapa)-1][$i]["country"])){
						echo "<tr>";
						echo "<td class='text-left py-0 my-0'>" . $nombres_paises[$resp_datos[count($fechas_mapa)-1][$i]["country"]] . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($resp_datos[count($fechas_mapa)-1][$i]["cases"], 0,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($resp_datos[count($fechas_mapa)-1][$i]["deaths"], 0,'.',',') . "</td>";
						echo "<td class='text-right py-0 my-0'>" . number_format($resp_datos[count($fechas_mapa)-1][$i]["recovered"], 0,'.',',') . "</td>";
						$activos=$resp_datos[count($fechas_mapa)-1][$i]["cases"]-$resp_datos[count($fechas_mapa)-1][$i]["deaths"]-$resp_datos[count($fechas_mapa)-1][$i]["recovered"];
						echo "<td class='text-right py-0 my-0'>" . number_format($activos, 0,'.',',') . "</td>";
						if($resp_datos[count($fechas_mapa)-1][$i]["cases"]<>0){
							echo "<td class='text-right py-0 my-0'>" . number_format($resp_datos[count($fechas_mapa)-1][$i]["deaths"]*100/$resp_datos[count($fechas_mapa)-1][$i]["cases"], 2,'.',',') . "</td>";
						}else{
							echo "<td class='text-right py-0 my-0'>0.00</td>";
						}
						if($resp_datos[count($fechas_mapa)-1][$i]["cases"]<>0){
							echo "<td class='text-right py-0 my-0'>" . number_format($resp_datos[count($fechas_mapa)-1][$i]["recovered"]*100/$resp_datos[count($fechas_mapa)-1][$i]["cases"], 2,'.',',') . "</td>";
						}else{
							echo "<td class='text-right py-0 my-0'>0.00</td>";
						}
						if($resp_datos[count($fechas_mapa)-1][$i]["cases"]<>0){
							echo "<td class='text-right py-0 my-0'>" . number_format($activos*100/$resp_datos[count($fechas_mapa)-1][$i]["cases"], 2,'.',',') . "</td>";
						}else{
							echo "<td class='text-right py-0 my-0'>0.00</td>";
						}
						echo "</tr>";
						$acum_casos+=$resp_datos[count($fechas_mapa)-1][$i]["cases"];
						$acum_muertes+=$resp_datos[count($fechas_mapa)-1][$i]["deaths"];
						$acum_recuperados+=$resp_datos[count($fechas_mapa)-1][$i]["recovered"];
						
						$i++;
					}
					//TOTAL MUNDIAL
					echo "<tr>";
					echo "<td class='text-left py-0 my-0'>World</td>";
					echo "<td class='text-right py-0 my-0'>" . number_format($acum_casos, 0,'.',',') . "</td>";
					echo "<td class='text-right py-0 my-0'>" . number_format($acum_muertes, 0,'.',',') . "</td>";
					echo "<td class='text-right py-0 my-0'>" . number_format($acum_recuperados, 0,'.',',') . "</td>";
					$activos=$acum_casos-$acum_muertes-$acum_recuperados;
					echo "<td class='text-right py-0 my-0'>" . number_format($activos, 0,'.',',') . "</td>";
					echo "<td class='text-right py-0 my-0'>" . number_format($acum_muertes*100/$acum_casos, 2,'.',',') . "</td>";
					echo "<td class='text-right py-0 my-0'>" . number_format($acum_recuperados*100/$acum_casos, 2,'.',',') . "</td>";
					echo "<td class='text-right py-0 my-0'>" . number_format($activos*100/$acum_casos, 2,'.',',') . "</td>";
					
					echo "</tr>";
					?>
				</tbody>
			</table>
		</div>
	</div>
	<br>
	<!-- tabla paises vista para movil 1 -->
	<div class="container-fluid px-0">
		<div class="table-responsive d-block d-xl-none px-0 mx-0 bg-light">
			<h3 class="text-center"><b>Detalle por Pais</b></h3>
			<table class="table table-bordered table-hover table-striped TablaDinamica px-0 mx-0">
				<thead>
					<tr class="text-center text-warning bg-dark">
						<th class="align-middle px-0 m-0"><b>Pais</b></th>
						<th class="align-middle px-0 m-0"><b>C</b></th>
						<th class="align-middle px-0 m-0"><b>M</b></th>
						<th class="align-middle px-0 m-0"><b>R</b></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$acum_casos=0;
					$acum_muertes=0;
					$acum_recuperados=0;
					$i=0;
					while(isset($resp_datos[count($fechas_mapa)-1][$i]["country"])){
						echo "<tr>";
						echo "<td class='text-left py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . $nombres_paises[$resp_datos[count($fechas_mapa)-1][$i]["country"]] . "</small></td>";
						echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($resp_datos[count($fechas_mapa)-1][$i]["cases"], 0,'.',',') . "</small></td>";
						echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($resp_datos[count($fechas_mapa)-1][$i]["deaths"], 0,'.',',') . "</small></td>";
						echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($resp_datos[count($fechas_mapa)-1][$i]["recovered"], 0,'.',',') . "</small></td>";
						echo "</tr>";
						$acum_casos+=$resp_datos[count($fechas_mapa)-1][$i]["cases"];
						$acum_muertes+=$resp_datos[count($fechas_mapa)-1][$i]["deaths"];
						$acum_recuperados+=$resp_datos[count($fechas_mapa)-1][$i]["recovered"];
						
						$i++;
					}
					//TOTAL MUNDIAL
					echo "<tr>";
					echo "<td class='text-left py-0 m-0 px-1 w-25'><small class='py-0 my-0'>World</small></td>";
					echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($acum_casos, 0,'.',',') . "</small></td>";
					echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($acum_muertes, 0,'.',',') . "</small></td>";
					echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($acum_recuperados, 0,'.',',') . "</small></td>";
					echo "</tr>";
					?>
				</tbody>
			</table>
		</div>
	</div>
	<br>
	<!-- tabla paises vista para movil 2 -->
	<div class="container-fluid px-0">
		<div class="table-responsive d-block d-xl-none px-0 mx-0 bg-light">
			<h3 class="text-center"><b>Detalle por (%)</b></h3>
			<table class="table table-bordered table-hover table-striped TablaDinamica px-0 mx-0">
				<thead>
					<tr class="text-center text-warning bg-dark">
						<th class="align-middle px-0 m-0"><b>Pais</b></th>
						<th class="align-middle px-0 m-0"><b>M/C</b></th>
						<th class="align-middle px-0 m-0"><b>R/C</b></th>
						<th class="align-middle px-0 m-0"><b>A/C</b></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=0;
					while(isset($resp_datos[count($fechas_mapa)-1][$i]["country"])){
						echo "<tr>";
						echo "<td class='text-left py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . $nombres_paises[$resp_datos[count($fechas_mapa)-1][$i]["country"]] . "</small></td>";
						if($resp_datos[count($fechas_mapa)-1][$i]["cases"]==0){
							echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>0,00</small></td>";
							echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>0,00</small></td>";
							echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>0,00</small></td>";
						}else{
							echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($resp_datos[count($fechas_mapa)-1][$i]["deaths"]*100/$resp_datos[count($fechas_mapa)-1][$i]["cases"], 2,'.',',') . "</small></td>";
							echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($resp_datos[count($fechas_mapa)-1][$i]["recovered"]*100/$resp_datos[count($fechas_mapa)-1][$i]["cases"], 2,'.',',') . "</small></td>";
							echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format(($resp_datos[count($fechas_mapa)-1][$i]["cases"]-$resp_datos[count($fechas_mapa)-1][$i]["deaths"]-$resp_datos[count($fechas_mapa)-1][$i]["recovered"])*100/$resp_datos[count($fechas_mapa)-1][$i]["cases"], 2,'.',',') . "</small></td>";
						}
						echo "</tr>";
						$i++;
					}
					//TOTAL MUNDIAL
					echo "<tr>";
					echo "<td class='text-left py-0 m-0 px-1 w-25'><small class='py-0 my-0'>World</small></td>";
					echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($acum_muertes*100/$acum_casos, 2,'.',',') . "</small></td>";
					echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format($acum_recuperados*100/$acum_casos, 2,'.',',') . "</small></td>";
					echo "<td class='text-right py-0 m-0 px-1 w-25'><small class='py-0 my-0'>" . number_format(($acum_casos-$acum_muertes-$acum_recuperados)*100/$acum_casos, 2,'.',',') . "</small></td>";
					echo "</tr>";
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