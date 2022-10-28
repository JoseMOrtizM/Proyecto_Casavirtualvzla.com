<?php
	$datos_paridad_y_tarifas=M_paridad_cambiaria_R_ultima($conexion);
?>
<!-- PARIDAD CAMBIARIA-->	
<section class="my-5">
	<div class="bg-white">
		<h3 class="text-center py-3 bg-dark text-warning"><b>Nuestras Tarifas</b></h3>
		<div class="container-fluid">
			<!-- CUERPO -->
			<div class="row py-2">
				<div class="col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0">
					<div class="bg-dark py-4 text-center">
						<i class="bg-warning text-dark p-2"><b>Paridad Cambiaria</b></i>
					</div>
					<div class="container-fluid">
						<div id="cuerpo_grafico_para_paridad"></div>
						<script type="text/javascript">
							$(document).ready(function(){
								$.ajax("PHP_MODELO/S_devuelve_grafico_para_paridad.php",{data:{ver:"si"}, type:'post'}).done(function(respuesta){
									$("#cuerpo_grafico_para_paridad").html(respuesta);
								});
							});
						</script>
						<p class="text-muted text-left small d-block d-md-none">Tasa de cambio del Bolivar respecto al <b>Pemón</b> al día de hoy (<?php echo date("d-m-Y"); ?>).</p>
					</div>
				</div>
				<div class="col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0">
					<div class="bg-warning py-4 text-center">
						<i class="bg-dark text-warning p-2" title="% de comisión según el ranking del vendedor"><b>Rankings de Venta</b></i>
					</div>
					<div class="container-fluid mt-2 mx-0 px-0">
						<div class="row text-center py-1 align-items-center">
							<div class="col-5 h5 text-center">
								<b>Ranking</b>
							</div>
							<div class="col-2 h5 text-center">
								<b>%</b>
							</div>
							<div class="col-5 h5 text-center">
								<b>Meta</b>
							</div>
						</div>
						<div class="row text-center py-1 align-items-center">
							<div class="col-5">
								<div class="marco-ajustado hidden rounded mx-auto" style='width: 10%;'><img src="img/ranking_hierro.png" alt="Hierro" title="Hierro" class="imgFit"></div><b>Hierro</b>
							</div>
							<div class="col-2">
								<h6><b><?php echo M_porcentaje_comision_por_venta_producto('HIERRO'); ?></b></h6>
							</div>
							<div class="col-5 text-center">
								<h6 title="Obtén este Ranking al registrar y activar tu cuenta">Resgístrate</h6>
							</div>
						</div>
						<div class="row text-center py-1 align-items-center">
							<div class="col-5">
								<div class="marco-ajustado hidden rounded mx-auto" style='width: 10%;'><img src="img/ranking_plata.png" alt="Plata" title="Plata" class="imgFit"></div><b>Plata</b>
							</div>
							<div class="col-2">
								<h6><b><?php echo M_porcentaje_comision_por_venta_producto('PLATA'); ?></b></h6>
							</div>
							<div class="col-5 text-center">
								<h6 title="Vende 50 Productos para alcanzar este Ranking">50 Ventas</h6>
							</div>
						</div>
						<div class="row text-center py-1 align-items-center">
							<div class="col-5">
								<div class="marco-ajustado hidden rounded mx-auto" style='width: 10%;'><img src="img/ranking_oro.png" alt="Oro" title="Oro" class="imgFit"></div><b>Oro</b>
							</div>
							<div class="col-2">
								<h6><b><?php echo M_porcentaje_comision_por_venta_producto('ORO'); ?></b></h6>
							</div>
							<div class="col-5 text-center">
								<h6 title="Vende al menos 100 Productos">100 Ventas</h6>
							</div>
						</div>
						<div class="row text-center py-1 align-items-center">
							<div class="col-5">
								<div class="marco-ajustado hidden rounded mx-auto" style='width: 10%;'><img src="img/ranking_platino.png" alt="Platino" title="Platino" class="imgFit"></div><b>Platino</b>
							</div>
							<div class="col-2">
								<h6><b><?php echo M_porcentaje_comision_por_venta_producto('PLATINO'); ?></b></h6>
							</div>
							<div class="col-5 text-center">
								<h6 class="my-0" title="Vende al menos 100 Productos y manten una reputación de 4 estrellas o más"><span class="text-warning fa fa-star"></span><span class="text-warning fa fa-star"></span><span class="text-warning fa fa-star"></span><span class="text-warning fa fa-star"></span><span class="text-warning fa fa-star-o"></span></h6>
							</div>
						</div>
						<div class="row text-center py-1 align-items-center">
							<div class="col-5">
								<div class="marco-ajustado hidden rounded mx-auto" style='width: 10%;'><img src="img/ranking_diamante.png" alt="Diamante" title="Diamante" class="imgFit"></div><b>Diamante</b>
							</div>
							<div class="col-2">
								<h6><b><?php echo M_porcentaje_comision_por_venta_producto('DIAMANTE'); ?></b></h6>
							</div>
							<div class="col-5 text-center">
								<h6 title="Acumula 100.000 Pemones en el saldo de tu cuenta"><b>Pm</b>. 100.000</h6>
							</div>
						</div>
						<p class="text-muted text-left small d-block d-md-none">Comisiones por venta de productos de acuerdo al ranking del vendedor.</p>
					</div>
				</div>
				<div class="col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0">
					<div class="bg-dark py-4 text-center">
						<i class="bg-warning text-dark p-2"><b>% Compra/Venta</b></i>
					</div>
					<div class="container-fluid">
						<h1 class="text-center pt-5 pb-4"><b>Comisión</b></h1>					
						<h5 class="text-center pt-2">Compra</h5>					
						<h1 class="text-center pb-2"><b><?php echo number_format($datos_paridad_y_tarifas['PORC_COMISION_POR_COMPRA'][0], 2,',','.');?>%</b></h1>
						<h5 class="text-center pt-2">Venta</h5>					
						<h1 class="text-center pb-4 mb-2"><b><?php echo number_format($datos_paridad_y_tarifas['PORC_COMISION_POR_VENTA'][0], 2,',','.');?>%</b></h1>
						<p class="text-muted text-left small d-block d-md-none">Porcentaje de comisión descontada por compra/venta de moneda virtual.</p>
					</div>
				</div>
			</div>			
			<!-- NOTAS FINALES -->
			<div class="d-none d-md-block container-fluid">
				<div class="row pt-0 pb-2">
					<div class="col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0">
						<div class="container-fluid">
							<p class="text-muted text-left small">Tasa de cambio del Bolivar respecto al <b>Pemón</b> al día de hoy (<?php echo date("d-m-Y"); ?>).</p>
						</div>
					</div>
					<div class="col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0">
						<div class="container-fluid">
							<p class="text-muted text-left small">Comisiones por venta de productos de acuerdo al ranking del vendedor.</p>
						</div>
					</div>
					<div class="col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0">
						<div class="container-fluid">
							<p class="text-muted text-left small">Porcentaje de comisión descontada por compra/venta de moneda virtual.</p>
						</div>
					</div>
				</div>			
			</div>
		</div>
	</div>
</section>
