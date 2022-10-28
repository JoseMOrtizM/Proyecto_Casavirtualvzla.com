<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>ZU-Rankings</title>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid px-0 mx-0 mx-md-2 px-md-4 mt-2 mb-5 bg-transparent">
		<br>
		<h4 class="text-center py-3 bg-dark text-warning mb-0" title="Rankings de Venta"><b>Rankings</b></h4>
		<div class="container-fluid bg-white pt-3">
			<p class="text-left">Por cada venta que realices en <b>La Casa Virtual</b> se realizará un descuento del precio de venta del producto.</p>
			<p class="text-left"><b>Por ejemplo:</b></p>
			<p class="text-left">Si eres Ranking <b>HIERRO</b> y realizas una venta por <b>Pm 100,00</b>, El comprador pagará <b>Pm 100,00</b> de los cuales se descontará un porcentaje del 10%; lo que significa que percibirás <b>Pm 90,00</b>; mientras que si alcanzas el Ranking <b>DIAMANTE</b> percibirás <b>Pm 98,00</b> dado que en este caso el descuento es sólo del 2%.</p>
			<div class="row text-center py-1 align-items-center">
				<div class="col-4 col-md-2 text-center">
					<b class="h4">Ranking</b>
				</div>
				<div class="col-2 col-md-2 text-center">
					<b class="h4">%</b>
				</div>
				<div class="col-6 col-md-8 text-center">
					<b class="h4">Meta</b>
				</div>
			</div>
			<div class="row text-center py-1 align-items-center">
				<div class="col-4 col-md-2">
					<div class="marco-ajustado hidden rounded w-25 mx-auto"><img src="img/ranking_hierro.png" alt="Hierro" title="Hierro" class="imgFit"></div><b>Hierro</b>
				</div>
				<div class="col-2 col-md-2 text-center">
					<h6><b><?php echo M_porcentaje_comision_por_venta_producto('HIERRO'); ?>%</b></h6>
				</div>
				<div class="col-6 col-md-8 text-left">
					<h6 title="Obtén este Ranking al registrar y activar tu cuenta">Resgístrate y Activa tu cuenta</h6>
				</div>
			</div>
			<div class="row text-center py-1 align-items-center">
				<div class="col-4 col-md-2">
					<div class="marco-ajustado hidden rounded w-25 mx-auto"><img src="img/ranking_plata.png" alt="Plata" title="Plata" class="imgFit"></div><b>Plata</b>
				</div>
				<div class="col-2 col-md-2">
					<h6><b><?php echo M_porcentaje_comision_por_venta_producto('PLATA'); ?>%</b></h6>
				</div>
				<div class="col-6 col-md-8 text-left">
					<h6 title="Vende 50 Productos para alcanzar este Ranking">Obtén 50 Ventas o más</h6>
				</div>
			</div>
			<div class="row text-center py-1 align-items-center">
				<div class="col-4 col-md-2">
					<div class="marco-ajustado hidden rounded w-25 mx-auto"><img src="img/ranking_oro.png" alt="Oro" title="Oro" class="imgFit"></div><b>Oro</b>
				</div>
				<div class="col-2 col-md-2">
					<h6><b><?php echo M_porcentaje_comision_por_venta_producto('ORO'); ?>%</b></h6>
				</div>
				<div class="col-6 col-md-8 text-left">
					<h6 title="Vende al menos 100 Productos">Consigue 100 Ventas</h6>
				</div>
			</div>
			<div class="row text-center py-1 align-items-center">
				<div class="col-4 col-md-2">
					<div class="marco-ajustado hidden rounded w-25 mx-auto"><img src="img/ranking_platino.png" alt="Platino" title="Platino" class="imgFit"></div><b>Platino</b>
				</div>
				<div class="col-2 col-md-2">
					<h6><b><?php echo M_porcentaje_comision_por_venta_producto('PLATINO'); ?>%</b></h6>
				</div>
				<div class="col-6 col-md-8 text-left">
					<h6 class="my-0" title="Vende al menos 100 Productos y manten una reputación de 4 estrellas o más">Alcanza una reputación de 4 Estrellas o más... (<span class="text-warning fa fa-star"></span><span class="text-warning fa fa-star"></span><span class="text-warning fa fa-star"></span><span class="text-warning fa fa-star"></span><span class="text-warning fa fa-star-o"></span>)</h6>
				</div>
			</div>
			<div class="row text-center py-1 align-items-center">
				<div class="col-4 col-md-2">
					<div class="marco-ajustado hidden rounded w-25 mx-auto"><img src="img/ranking_diamante.png" alt="Diamante" title="Diamante" class="imgFit"></div><b>Diamante</b>
				</div>
				<div class="col-2 col-md-2">
					<h6><b><?php echo M_porcentaje_comision_por_venta_producto('DIAMANTE'); ?>%</b></h6>
				</div>
				<div class="col-6 col-md-8 text-left">
					<h6 title="Acumula 100.000 Pemones en el saldo de tu cuenta">Acumula 100.000 Pm en tu cuenta</h6>
				</div>
			</div>
			<p class="text-muted text-left py-3"><b>*%: </b>Porcentaje a descontar por venta de productos según el ranking del vendedor.</p>
		</div>
		<br><br><br>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>