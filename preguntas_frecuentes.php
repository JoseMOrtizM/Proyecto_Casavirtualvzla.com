<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/datos_nav_busq_externos.php"); ?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/seo_meta.php") ?>
	<?php require ("PHP_REQUIRES/head_principal.php"); ?>
	<title>Preguntas Frecuentes</title>
</head>
<body class="bg-secondary">
	<?php require ("PHP_REQUIRES/nav_principal.php"); ?>
	<section class="container pt-5 my-5">
		<h3 class="text-center py-3 bg-dark text-warning display-4 mb-0">Preguntas Frecuentes</h3>
		<div class="bg-light p-3">
			<table class="table table-hover TablaDinamicaOrderDesc w-100 bg-light">
				<thead>
					<tr class="text-center">
						<th class="align-middle"><b class="h6"></th>
					</tr>
				</thead>
				<tbody>
			<?php
				$datos_pregunta_frecuentes=M_blog_externo_R($conexion, 'PREGUNTA_FRECUENTE', 'SI', '', '', '', '');
				$i=0;
				while(isset($datos_pregunta_frecuentes['ID_COMENTARIO_EXT'][$i])){
					if($datos_pregunta_frecuentes['ID_COMENTARIO_EXT'][$i]<>""){
						$fecha_i=explode(" ",$datos_pregunta_frecuentes['FH_COMENTARIO'][$i]);
						echo "<tr class='px-1'><td class='text-left'>"; 
						echo "<b class='h5 text-primary'>Pregunta (Fecha: " . $fecha_i[0] . "):</b><br><b>" . $datos_pregunta_frecuentes['COMENTARIO'][$i] . "</b><br><b class='h5 text-success'>Respuesta:</b><br>" . $datos_pregunta_frecuentes['RESPUESTA'][$i] . "<hr></td></tr>";
					}
					$i=$i+1;
				}
			?>
			</table>
		</div>
	</section>
	<?php require ("PHP_REQUIRES/footer_principal.php"); ?>
</body>
</html>