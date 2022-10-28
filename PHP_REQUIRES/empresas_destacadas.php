<?php
	$datos_aliados=M_usuarios_R_portada_aliados($conexion);
	if(isset($datos_aliados['EMPRESA'][0][0])){
		if($datos_aliados['EMPRESA'][0][0]<>""){
?>
	<!-- EMPRESAS DESTACADAS-->
	<section class="my-5">
		<div class="bg-white pb-3">
			<h3 class="text-center py-3 bg-dark text-warning"><b>Nuestros Aliados</b></h3>
			<table class="TablaDinamica10 w-100">
				<thead>
					<tr class="text-center">
						<th class="align-middle"><b class="h6"></th>
					</tr>
				</thead>
				<tbody>
				<?php
					$i=0;
					$e=$i+1;
					while(isset($datos_aliados['EMPRESA'][$i][0])){
				?>
					<tr>
						<td>
							<div class='container'>
								<div class='row'>
									<div class='col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
										<h4 class='text-left' style='height: 2em;'><e class="text-light" style="font-size: 1px;"><?php echo $e; ?></e><a href='buscar.php?buscar=<?php echo $datos_aliados['EMPRESA'][$i][0]; ?>' class='text-dark'><b><?php echo $datos_aliados['EMPRESA'][$i][0]; ?></b></a></h4>
										<h6 class='text-warning'>
										<?php
											$estrellas=M_reputacion_por_usuario($conexion, $datos_aliados['CEDULA_RIF'][$i][0]);
											echo M_dibuja_estrellas($estrellas['PUNTOS'][0]);
										?>
										</h6>
										<p class='text-left'><strong class='text-success'>Categorías:</strong>
										<?php
											$e=0;
											while(isset($datos_aliados['CATEGORIAS'][$i][$e])){
												echo "<a href='buscar.php?buscar=" . $datos_aliados['CATEGORIAS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['CATEGORIAS'][$i][$e] . "</a>";
												if(isset($datos_aliados['CATEGORIAS'][$i][$e+1])){
													if($datos_aliados['CATEGORIAS'][$i][$e+1]<>""){
														echo ", ";
													}
												}else{
													echo ".";
												}
												$e=$e+1;
											}
										?>
										</p>
										<p class='text-left'><strong class='text-primary'>Etiquetas:</strong>
										<?php
											$e=0;
											while(isset($datos_aliados['ETIQUETAS'][$i][$e])){
												echo "<a href='buscar.php?buscar=" . $datos_aliados['ETIQUETAS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['ETIQUETAS'][$i][$e] . "</a>";
												if(isset($datos_aliados['ETIQUETAS'][$i][$e+1])){
													if($datos_aliados['ETIQUETAS'][$i][$e+1]<>""){
														echo ", ";
													}
												}else{
													echo ".";
												}
												$e=$e+1;
											}
										?>
										</p>
										<p class='text-left'><strong class='text-danger'>Productos:</strong>
										<?php
											$e=0;
											while(isset($datos_aliados['PRODUCTOS'][$i][$e])){
												echo "<a href='buscar.php?buscar=" . $datos_aliados['PRODUCTOS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['PRODUCTOS'][$i][$e] . "</a>";
												if(isset($datos_aliados['PRODUCTOS'][$i][$e+1])){
													if($datos_aliados['PRODUCTOS'][$i][$e+1]<>""){
														echo ", ";
													}
												}else{
													echo ".";
												}
												$e=$e+1;
											}
										?>
										</p>
									</div>
					<?php
							$i=$i+1;
							$e=$i+1;
							if(isset($datos_aliados['EMPRESA'][$i][0])){
					?>
									<div class='col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
										<h4 class='text-left' style='height: 2em;'><e class="text-light" style="font-size: 1px;"><?php echo $e; ?></e><a href='buscar.php?buscar=<?php echo $datos_aliados['EMPRESA'][$i][0]; ?>' class='text-dark'><b><?php echo $datos_aliados['EMPRESA'][$i][0]; ?></b></a></h4>
										<h6 class='text-warning'>
										<?php
											$estrellas=M_reputacion_por_usuario($conexion, $datos_aliados['CEDULA_RIF'][$i][0]);
											echo M_dibuja_estrellas($estrellas['PUNTOS'][0]);
										?>
										</h6>
										<p class='text-left'><strong class='text-success'>Categorías:</strong>
										<?php
											$e=0;
											while(isset($datos_aliados['CATEGORIAS'][$i][$e])){
												echo "<a href='buscar.php?buscar=" . $datos_aliados['CATEGORIAS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['CATEGORIAS'][$i][$e] . "</a>";
												if(isset($datos_aliados['CATEGORIAS'][$i][$e+1])){
													if($datos_aliados['CATEGORIAS'][$i][$e+1]<>""){
														echo ", ";
													}
												}else{
													echo ".";
												}
												$e=$e+1;
											}
										?>
										</p>
										<p class='text-left'><strong class='text-primary'>Etiquetas:</strong>
										<?php
											$e=0;
											while(isset($datos_aliados['ETIQUETAS'][$i][$e])){
												echo "<a href='buscar.php?buscar=" . $datos_aliados['ETIQUETAS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['ETIQUETAS'][$i][$e] . "</a>";
												if(isset($datos_aliados['ETIQUETAS'][$i][$e+1])){
													if($datos_aliados['ETIQUETAS'][$i][$e+1]<>""){
														echo ", ";
													}
												}else{
													echo ".";
												}
												$e=$e+1;
											}
										?>
										</p>
										<p class='text-left'><strong class='text-danger'>Productos:</strong>
										<?php
											$e=0;
											while(isset($datos_aliados['PRODUCTOS'][$i][$e])){
												echo "<a href='buscar.php?buscar=" . $datos_aliados['PRODUCTOS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['PRODUCTOS'][$i][$e] . "</a>";
												if(isset($datos_aliados['PRODUCTOS'][$i][$e+1])){
													if($datos_aliados['PRODUCTOS'][$i][$e+1]<>""){
														echo ", ";
													}
												}else{
													echo ".";
												}
												$e=$e+1;
											}
										?>
										</p>
									</div>
					<?php
							}
							$i=$i+1;
							$e=$i+1;
							if(isset($datos_aliados['EMPRESA'][$i][0])){
					?>
									<div class='col-md-4 px-2 mx-2 px-sm-5 px-md-0 mx-sm-5 mx-md-0'>
										<h4 class='text-left' style='height: 2em;'><e class="text-light" style="font-size: 1px;"><?php echo $e; ?></e><a href='buscar.php?buscar=<?php echo $datos_aliados['EMPRESA'][$i][0]; ?>' class='text-dark'><b><?php echo $datos_aliados['EMPRESA'][$i][0]; ?></b></a></h4>
										<h6 class='text-warning'>
										<?php
											$estrellas=M_reputacion_por_usuario($conexion, $datos_aliados['CEDULA_RIF'][$i][0]);
											echo M_dibuja_estrellas($estrellas['PUNTOS'][0]);
										?>
										</h6>
										<p class='text-left'><strong class='text-success'>Categorías:</strong>
										<?php
											$e=0;
											while(isset($datos_aliados['CATEGORIAS'][$i][$e])){
												echo "<a href='buscar.php?buscar=" . $datos_aliados['CATEGORIAS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['CATEGORIAS'][$i][$e] . "</a>";
												if(isset($datos_aliados['CATEGORIAS'][$i][$e+1])){
													if($datos_aliados['CATEGORIAS'][$i][$e+1]<>""){
														echo ", ";
													}
												}else{
													echo ".";
												}
												$e=$e+1;
											}
										?>
										</p>
										<p class='text-left'><strong class='text-primary'>Etiquetas:</strong>
										<?php
											$e=0;
											while(isset($datos_aliados['ETIQUETAS'][$i][$e])){
												echo "<a href='buscar.php?buscar=" . $datos_aliados['ETIQUETAS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['ETIQUETAS'][$i][$e] . "</a>";
												if(isset($datos_aliados['ETIQUETAS'][$i][$e+1])){
													if($datos_aliados['ETIQUETAS'][$i][$e+1]<>""){
														echo ", ";
													}
												}else{
													echo ".";
												}
												$e=$e+1;
											}
										?>
										</p>
										<p class='text-left'><strong class='text-danger'>Productos:</strong>
										<?php
											$e=0;
											while(isset($datos_aliados['PRODUCTOS'][$i][$e])){
												echo "<a href='buscar.php?buscar=" . $datos_aliados['PRODUCTOS'][$i][$e] . "' class='text-dark'>" . $datos_aliados['PRODUCTOS'][$i][$e] . "</a>";
												if(isset($datos_aliados['PRODUCTOS'][$i][$e+1])){
													if($datos_aliados['PRODUCTOS'][$i][$e+1]<>""){
														echo ", ";
													}
												}else{
													echo ".";
												}
												$e=$e+1;
											}
										?>
										</p>
									</div>
					<?php
							}
					?>
								</div>
							</div>
						</td>
					</tr>
				<?php
						$i=$i+1;
						$e=$i+1;

					}
				?>
				</tbody>
			</table>
		</div>
	</section>
<?php			
		}
	}
?>