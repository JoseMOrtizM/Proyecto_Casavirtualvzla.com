<?php
	$datos_de_categorias=M_categorias_disponibles($conexion);
	$datos_de_etiquetas=M_etiquetas_disponibles($conexion);
?>
<!-- CATEGORIAS y ETIQUETAS-->
<section class="my-5">
	<div class="bg-white">
		<h3 class="text-center py-3 bg-dark text-warning"><b>Tags Disponible</b></h3>
		<div class="container-fluid py-2">
			<div class='row px-4'>
				<div class='col-md-6 text-success border'>
					<h4 class='text-center text-success'><strong>Categorías:</strong></h4>
					<p>
					<?php
						$i=0;
						while(isset($datos_de_categorias['CATEGORIA'][$i])){
							echo "<a href='buscar.php?buscar=" . $datos_de_categorias['CATEGORIA'][$i] . "' class='text-dark'>" . $datos_de_categorias['CATEGORIA'][$i] . "</a>&nbsp;&nbsp; ";
							$i=$i+1;
						}
					?>
					</p>
				</div>
				<div class='col-md-6 text-primary border'>
					<h4 class='text-center text-primary'><strong>Etiquetas:</strong></h4>
					<p>
					<?php
						$i=0;
						while(isset($datos_de_etiquetas['ETIQUETA'][$i])){
							echo "<a href='buscar.php?buscar=" . $datos_de_etiquetas['ETIQUETA'][$i] . "' class='text-dark'>" . $datos_de_etiquetas['ETIQUETA'][$i] . "</a>&nbsp;&nbsp; ";
							$i=$i+1;
						}
					?>
					</p>
				</div>
			</div>
		</div>
	</div>
</section>
