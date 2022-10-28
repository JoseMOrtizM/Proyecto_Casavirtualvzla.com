<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/datos_nav_busq_externos.php"); ?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/seo_meta.php") ?>
	<?php require ("PHP_REQUIRES/head_principal.php"); ?>
	<title>Nosotros</title>
</head>
<body class="bg-secondary">
	<?php require ("PHP_REQUIRES/nav_principal.php"); ?>
	<section class="container pt-5 mt-5">
		<h2 class="px-2 py-2 bg-warning text-center text-dark mb-0 rounded-top"><b>Quienes Somos</b></h2>
		<div class="bg-white text-dark px-2 py-2 rounded-bottom">
			<p class="px-2 py-2">Somos una empresa Venezolana fundada en 2020 por un grupo de Venezolanos, quienes afectados por la difícil situación económica que vive nuestro país, se dieron a la tarea de crear una herramienta Web que sirva a los Venezolanos y Venezolanas como una alternativa para la preservación de su poder adquisitivo, implementando el uso de una moneda virtual de fácil acceso, que no dependa de los índices inflacionarios del País.</p>
		</div>
		<br>
		<h2 class="px-2 py-2 bg-dark text-center text-warning mb-0 rounded-top"><b>Nuestro Objetivo</b></h2>
		<div class="bg-white text-dark px-2 py-2 rounded-bottom">
			<p class="px-2 py-2">Proporcionar un mecanismo que permita minimizar la inflación, preservando el poder adquisitivo y brindando una gama de oportunidades de negocio a nuestros usuarios y empresarios.</p>
		</div>
		<br>
		<h2 class="px-2 py-2 bg-warning text-center text-dark mb-0 rounded-top"><b>Misión</b></h2>
		<div class="bg-white text-dark px-2 py-2 rounded-bottom">
			<ol>
				<li>Disminuir la inflación galopante en Venezuela.</li>
				<li>Convertir este sitio Web en el mejor lugar para trabajar y ofrecer sus Servicios, Productos y Artículos.</li>
				<li>Inspirar la creatividad y proactividad de nuestros usuarios.</li>
			</ol>
		</div>
		<br>
		<h2 class="px-2 py-2 bg-dark text-center text-warning mb-0 rounded-top"><b>Visión</b></h2>
		<div class="bg-white text-dark px-2 py-2 rounded-bottom">
			<ol>
				<li>Preservar el poder adquisitivo de nuestros Usuarios.</li>
				<li>Hacer de éste Sitio Web un medio confiable para el crecimiento de todos nuestros usuarios.</li>
				<li>Generar un amplio portafolio de productos y servicios de alta calidad para satisfacer los deseos y necesidades de nuestros usuarios.</li>
				<li>Impulsar la competitividad e innovación entre nuestros vendedores en pro de mejorar la calidad de sus productos y servicios.</li>
				<li>Traspasar nuestra frontera y ser reconocida a nivel internacional.</li>
				<li>Ser una organización eficaz, eficiente y dinámica.</li>
			</ol>
		</div>
		<br>
		<h2 class="px-2 py-2 bg-warning text-center text-dark mb-0 rounded-top"><b>Valores</b></h2>
		<div class="bg-white text-dark px-2 py-2 rounded-bottom">
			<ol>
				<li>Responsabilidad.</li>
				<li>Transparencia.</li>
				<li>Compromiso.</li>
				<li>Esfuerzo.</li>
				<li>Búsqueda constante de mejora de la calidad.</li>
				<li>Preocupados por la excelencia.</li>
				<li>Calidad Humana.</li>
				<li>Profesionalismo.</li>
				<li>Pasión por lo que hacemos.</li>
				<li>Respeto por el cliente.</li>
			</ol>
		</div>	
		<br>
		<h2 id="que_es_esto" class="px-2 py-2 bg-dark text-center text-warning mb-0 rounded-top"><b>Antes de registrarte lee esto:</b></h2>
		<div class="bg-white text-dark px-2 py-2 rounded-bottom">
			<p class="px-2 py-2">Este sitio web le ofrece a todos los Venezolanos una alternativa para la <b>preservación de su poder adquisitivo</b>, implementando el uso de una moneda virtual que denominamos <b>“Pemón” (Pm)</b> de fácil acceso, que no se devalúa como el bolívar ni depende de los índices inflacionarios de la nación.</p>
			<p class="px-2 py-2">Nuestra plataforma promueve la libre competencia, que resulta de la concurrencia libre de ofertantes que producen bienes o servicios similares y a su vez, consumidores que toman decisiones libres sobre sus compras, con información suficiente sobre las características de precios y calidad de los productos, sin que en estas decisiones intervengan fuerzas distintas a las del mercado generado en esta web.</p>
			<p class="px-2 py-2">Toda persona mayor de edad puede participar en esta plataforma, registrándose como usuario y activando su cuenta, siempre que respete los términos, condiciones y políticas establecidas.</p>
			<p class="px-2 py-2"><b>Te ofrecemos un sin fin de oportunidades</b> donde podrás publicar tus productos, bienes y servicios, estamos abiertos a todos los servicios profesionales, técnicos así como también oficios, entre otros.</p>
			<p class="px-2 py-2"><b>El Pemón (Pm):</b> Es la moneda que manejamos en esta plataforma con la que podrás comprar y vender los productos que quieras y hacer crecer tu propio negocio. <b>El Pemón</b> sólo puede ser adquirido en <b>El Arca</b> y puedes canjearlo de vuelta por Bolívares cuando quieras.</p>
			<p class="px-2 py-2"><b>El Arca:</b> Es el instrumento que te permitirá comprar y vender la moneda virtual <b>Pemón</b>. Este es el único sitio web que te permite adquirir y realizar transacciones con esta moneda virtual.</p>
			<p class="px-2 py-2"><b>Comprar Pemón:</b> Podrás adquirir tus Pemones realizando transferencias bancarias en Bolívares a alguna de nuestras cuentas disponibles:</p>
			<ul class="row">
			<?php
				$datos_bancos=M_datos_bancos_tranferencia();
				$i=0;
				while(isset($datos_bancos[$i]['NOMBRE'])){
					echo "<li class='col-md-6'>";
					echo "<a href='" . $datos_bancos[$i]['LINK'] . "' target='_blank'>" . $datos_bancos[$i]['NOMBRE'] . "</a>";
					echo 	"<ul>";
					echo 		"<li>" . $datos_bancos[$i]['USUARIO'] . "</li>";
					echo 		"<li>C.I.: " . $datos_bancos[$i]['CEDULA'] . "</li>";
					echo 		"<li>" . $datos_bancos[$i]['TIPO_CUENTA'] . "</li>";
					echo 		"<li>N°: " . $datos_bancos[$i]['NUMERO_CUENTA'] . "</li>";
					echo 		"<li>Telf: " . $datos_bancos[$i]['TELEFONO'] . "</li>";
					echo 		"<li>Email: " . $datos_bancos[$i]['CORREO'] . "</li>";
					echo 		"<li><i class='text-success'>" . $datos_bancos[$i]['OBSERVACION'] . "</i></li>";
					echo 	"</ul>";
					echo "</li>";
					$i++;
				}
			?>
			</ul>
			<p class="px-2 py-2">Luego regístrala en <b>El Arca</b> y tendrás tu saldo disponible en un lapso no mayor a <b>2 días hábiles</b> después de realizado tu registro.</p>
			<p class="px-2 py-2"><b>Vender Pemón:</b> Parcial o totalmente, podrás convertir tus Pemones a Bolívares en cualquier momento realizando la solicitud a través de la opción <b>Vender Pemón en El Arca. Recibirás tus fondos en Bolívares en un lapso no mayor a los 3 días hábiles</b> de realizada tu solicitud. Los fondos se depositarán en la cuenta bancaria que hayas registrado en tu perfil de usuario.</p>
			<p class="px-2 py-2">La cantidad de Bolívares que recibirás por tus ventas de Pemón son calculadas en el momento que realizas la solicitud y es el monto exacto que depositaremos en tu cuenta bancaria.</p>
			<p class="px-2 py-2"><b>IMPORTANTE:</b></p>
			<ul>
				<li>Antes de realizar transferencias bancarias para compras de Pemón, verifica cuanto es el máximo de Bolívares que puedes transferir ese día <b>RECUERDA QUE NO PODRÁS COMPRAR MÁS DE 100 Pm/diarios.</b></li>
				<li>Tanto para la compra como para la venta de Pemón se te realizará un descuento de 2% sobre el monto de la transacción.</li>
				<li>Si no logramos verificar los datos de tu solicitud de compra de Pemón en el lapso estipulado de 2 días hábiles, la transacción será rechazada y aparecerá en tu información consolidada en El Arca, para que verifiques tus datos y vuelvas a intentar la compra posteriormente.</li>
			</ul>
			<p class="px-2 py-2"><b>Compra de productos:</b> Contamos con <b>dos formas de pago</b> para adquirir productos o servicios. <b>Compra EXPRESS y Compra PREMIUN</b>, de libre elección entre comprador y vendedor.</p>
			<p class="px-2 py-2">En la <b>Compra EXPRESS</b>; el pago es inmediato se descuenta el monto al comprador y se acredita al vendedor automáticamente, la <b>Compra PREMIUN</b>; entrega al comprador un código secreto que una vez recibido el producto debe entregarse al vendedor para que este último pueda registrarlo y recibir el pago. En caso de no recibir satisfactoriamente el producto, el comprador puede revertir la compra y obtener su dinero de vuelta (en el proceso se descuenta la comisión por compra según el ranking del vendedor).</p>
			<p class="px-2 py-2"><b>Ranking del Vendedor:</b> Es una forma de clasificar a los usuarios vendedores de acuerdo con su desempeño dentro de esta web. A medida que mejora tu desempeño como vendedor irás aumentando de Ranking y se te cobrará cada vez menos por concepto de comisión en tus ventas. Existen 5 Rankings los cuales son:</p>
			<ul>
				<li><b>Ranking HIERRO:</b> Que obtienes al <b>registrar y activar tu cuenta</b>. Con ese Ranking se descuenta un <b>5%</b> de la venta.</li>
				<li><b>Ranking PLATA:</b> Alcanzarás este Ranking una vez que realices <b>50 ventas o más</b>. En este caso  descuenta un <b>4%</b> de la venta. </li>
				<li><b>Ranking ORO:</b> Que obtienes al realizar <b>100 ventas o más</b>. Con ese Ranking se descuenta un <b>3%</b> de la venta.</li>
				<li><b>Ranking PLATINO:</b> Si ya eres <b>Ranking ORO</b> y mantienes una <b>reputación de 4 estrellas o más</b> alcanzarás este Ranking y se te descontará <b>2%</b> de tus ventas.</li>
				<li><b>Ranking DIAMANTE:</b> Si mantienes un <b>Ranking PLATINO</b> y mantienes un acumulado de <b>100.000 Pm de saldo disponible</b> en tu cuenta de usuario alcanzarás este Ranking con el que tan sólo se descontará un <b>1%</b> de comisión sobre tus ventas.</li>
				<li>Los Rankings de todos los usuarios serán actualizados todos los días antes de las 10:00am.</li>
			</ul>
			<p class="px-2 py-2"><b>Reputación del Vendedor:</b> Es otra forma de medir el desempeño de los usuarios vendedores. Cada vez que realices una venta el usuario comprador podrá realizar una evaluación de tu producto calificando la venta del 1 al 5 (en estrellas) donde las estrellas representan el puntaje alcanzado en dicha evaluación, siendo 1 punto o una estrella el puntaje más bajo y 5 estrellas o 5 puntos la máxima calificación.</p>
			<p class="px-2 py-2">Es importante tener en cuenta lo siguiente:</p>
			<ul>
				<li>Alcanzarás una reputación de 5 Estrellas cuando el promedio de tus evaluaciones sea mayor o igual a 4,5 Puntos.</li>
				<li>Alcanzarás una reputación de 4 Estrellas cuando el promedio de tus evaluaciones sea mayor o igual a 3,5 Puntos y menor que 4,5 Puntos.</li>
				<li>Alcanzarás una reputación de 3 Estrellas cuando el promedio de tus evaluaciones sea mayor o igual a 2,5 Puntos y menor que 3,5 Puntos.</li>
				<li>Alcanzarás una reputación de 2 Estrellas cuando el promedio de tus evaluaciones sea mayor o igual a 1,5 Puntos y menor que 2,5 Puntos.</li>
				<li>Alcanzarás una reputación de 1 Estrella cuando el promedio de tus evaluaciones sea menor que 1,5 Puntos.</li>
				<li>Mientras no tengas evaluaciones registradas por tus compradores tu reputación mostrará el mensaje “Sin Evaluar”.</li>
				<li>Las compras que no reciban evaluaciones no serán tomadas en consideración para el cálculo de tu reputación como vendedor.</li>
			</ul>
			<p class="px-2 py-2"><b>Servicios de Mensajería:</b> En tu perfil de usuario contarás con un sistema de mensajes que podrás utilizar para realizar tus consultas a nuestros analistas. También dispondrás de otro sistema de mensajes donde podrás preguntar a otros usuarios acerca de productos que te interesen y de igual manera tus potenciales compradores podrán aclarar sus dudas contigo (Este último servicio de mensajes está integrado a la vista donde se muestra el detalle del producto, donde se muestran todas las consultas que han realizado tus potenciales compradores).</p>
			<p class="px-2 py-2"><b>Control de Inventario Automático:</b> Puedes programar periodos para restablecer tus inventarios de producto a diario, semanal o mensualmente. Dicho inventario será repuesto automáticamente el día de tu elección antes de las 10:00am.</p>
			<p class="px-2 py-2"><b>Servicios de Indicadores de Gestión:</b> A través de nuestro servicio puedes medir tu desempeño y analizar tu estrategia que es <b>primordial para cualquier negocio</b>. Este servicio está disponible por un costo anual.<br>
			Sin medir ni analizar nuestras acciones no podemos descubrir cuáles han sido nuestros fallos, en qué aspectos podemos mejorar o qué procesos no han sido óptimos. Todo este análisis se vuelve <b>indispensable si nuestro negocio o empresa es digital</b>.</p>
			<p class="px-2 py-2"><b>Servicios de Aliados:</b> También te ofrecemos este servicio con el que tus productos serán puestos en una sección especial al principio de cada búsqueda que realicen potenciales compradores. Este servicio está disponible por un costo anual.<br>
			Es conocido que los usuarios interesados en comprar un producto rara vez buscan más allá de los 10 primeros productos que se muestran en los resultados de búsqueda.</p>
			<p class="px-2 py-2"><i><b>Esta es la oportunidad de hacer tus negocios sin preocuparte por la inflación. Compra o Publica Productos, Artículos y Servicios en nuestra página y verás multiplicados tus ingresos en poco tiempo.</b></i></p>
		</div>
		<br><br>
	</section>
	<?php require ("PHP_REQUIRES/footer_principal.php"); ?>
</body>
</html>