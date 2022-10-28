<!------------------ NAV BAR PARA INDEX---------------------------------->
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top py-0 pl-1 pr-2 my-0 border-bottom border-warning">
	<!-- LOGO ANIMADO COM "amazingslider"-->
	<a class="navbar-text ml-1 d-block" style="width: 150px" href="zona_usuario.php">
		<div id="amazingslider-wrapper-1" style="max-width:150px; height: 38px; margin:0px auto 0px;border:#000 0px solid; overflow:hidden; background-color:transparent" class="bg-dark">
			<div id="amazingslider-1" style="margin:0 auto;">
				<ul class="amazingslider-slides" style="display:none;">
					<li><img src="img/logoanimado.png"/>
					</li>
					<li><img src="img/logoanimado.png"/>
					</li>
				</ul>
			</div>
		</div>
	</a>
	<!-- LINK PREGUNTAS FRECUENTES-->
	<a class="text-warning h4 mx-1 mt-2 d-block d-md-none" href="zona_usuario_preguntas_frecuentes.php" title="Preguntas Frecuentes"><span class="fa fa-question-circle d-inline d-md-none"></span></a>
	<!-- LINK END-->
	<a class="text-warning h4 mx-1 mt-2 d-block d-md-none" href="#menu_lateral_arreglo" title="Ir al menú de opciones"><span class="fa fa-plus-square-o d-inline d-md-none"></span></a>
	<!-- LINK HOME-->
	<a class="text-warning h4 mx-1 mt-2 d-block d-md-none" href="zona_usuario.php" title="Inicio"><span class="fa fa-home d-inline d-md-none"></a>
	<button class="navbar-toggler border border-warning text-warning" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="true" aria-label="Toggle navigation">
		<span class="text-warning fa fa-bars"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarsExample04">
		<ul class="navbar-nav ml-auto mr-1 py-2">
			<li class="nav-item dropdown d-inline">
				<?php 
					$primer_nombre=explode(" ",$datos_usuario_session['NOMBRE'][0]);
					$primer_apellido=explode(" ",$datos_usuario_session['APELLIDO'][0]);
					$cantidad_letras_usuario=strlen($primer_nombre[0])+strlen($primer_apellido[0]);
					$string_de_ajuste="";
					//ARRAY DE LETRAS PARA AJUSTE
					$ie=0;
					$io=32;
					while($ie<=28){
						$array_ajuste[$ie]=$io;
						$ie=$ie+1;
						$io=$io-1;
					}
					//creando el string_de_ajuste para que se vea bien el nav en nombres cortos
					if($cantidad_letras_usuario>27){
						$string_de_ajuste="";
					}else{
						$contador_letra=0;
						while($contador_letra<$array_ajuste[$cantidad_letras_usuario]){
							$string_de_ajuste=$string_de_ajuste . "&nbsp;";
							$contador_letra=$contador_letra+1;
						}
					}
				?>
				<a class="nav-link dropdown-toggle text-warning px-1" href="" id="dropdown05" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Mostrar opciones de usuario"><b class="text-light ml-2"><?php echo "<b class='d-none d-md-inline'>" . $string_de_ajuste . "</b>"; ?>Hola:</b>&nbsp;&nbsp; <?php echo $primer_nombre[0]; ?> <?php echo $primer_apellido[0]; ?>
				</a>
				<div class="dropdown-menu px-3 py-0 bg-dark w-100" aria-labelledby="dropdown05">
					<div class="d-block">
						<?php
							//LINKS DE ADMINISTRACIÓN
							if($datos_usuario_session['ACCESO'][0]=='ADMINISTRADOR'){
						?>
						<div class="container-fluid pt-3 pb-2">
							<div class="my-2 text-center pb-3 border-secondary border-bottom d-none d-md-block">
								<img src="IMAGENES_USUARIOS/<?php echo $datos_usuario_session['FOTO_LOGO'][0] . "?a=" . rand(); ?>" class="imgFit border border-secondary rounded w-50" title="<?php echo $datos_usuario_session['NOMBRE'][0] . ", " . $datos_usuario_session['APELLIDO'][0]; ?>">
							</div>
							<div class="row mt-2">
								<div class="col-6 text-left">
									<a class="text-warning" href="datos_usuario.php" title="Ver o modificar tus datos personales"><span class="fa fa-user-circle-o"></span>&nbsp;Datos</a>
								</div>
								<div class="col-6 pb-2 text-right">
									<a class="text-warning" href="salir.php" title="Salir del sistema" onclick="return confirmar2('salir.php')">
										<span class="fa fa-power-off">&nbsp;</span>Salir
									</a>
									<script>
										function confirmar2(url){
											if(confirm('¿Seguro que deseas Salir del Sistema?')){
												window.location=url;
											}else{
												return false;
											}	
										}
									</script>
								</div>
							</div>
						</div>
						<?php
							//LINKS DE ANALISTA
							}else if($datos_usuario_session['ACCESO'][0]=='ANALISTA'){
						?>
						<div class="container-fluid pt-3 pb-2">
							<div class="my-2 text-center pb-3 border-secondary border-bottom d-none d-md-block">
								<img src="IMAGENES_USUARIOS/<?php echo $datos_usuario_session['FOTO_LOGO'][0] . "?a=" . rand(); ?>" class="imgFit border border-secondary rounded w-50" title="<?php echo $datos_usuario_session['NOMBRE'][0] . ", " . $datos_usuario_session['APELLIDO'][0]; ?>">
							</div>
							<div class="row mt-2">
								<div class="col-6 text-left">
									<a class="text-warning" href="datos_usuario.php" title="Ver o modificar tus datos personales"><span class="fa fa-user-circle-o"></span>&nbsp;Datos</a>
								</div>
								<div class="col-6 pb-2 text-right">
									<a class="text-warning" href="salir.php" title="Salir del sistema" onclick="return confirmar2('salir.php')">
										<span class="fa fa-power-off">&nbsp;</span>Salir
									</a>
									<script>
										function confirmar2(url){
											if(confirm('¿Seguro que deseas Salir del Sistema?')){
												window.location=url;
											}else{
												return false;
											}	
										}
									</script>
								</div>
							</div>
						</div>
						<?php
							//LINKS DE COMPRADOR-VENDEDOR
							}else{
						?>
						<div class="container-fluid pt-3 pb-2">
							<div class="row">
								<div class="col-md-5 my-2 text-center pb-3 border-secondary border-bottom d-none d-md-block">
									<img src="IMAGENES_USUARIOS/<?php echo $datos_usuario_session['FOTO_LOGO'][0] . "?a=" . rand(); ?>" class="imgFit border border-secondary rounded w-100" title="<?php echo $datos_usuario_session['NOMBRE'][0] . ", " . $datos_usuario_session['APELLIDO'][0]; ?>">
								</div>
								<div class="col-md-7 my-2 text-center pb-3 border-secondary border-bottom d-none d-md-block">
									<h6 class="text-center text-warning"><a href="zona_usuario_ver_mis_evaluaciones.php" class="text-warning">
										<?php
											$rep_user=M_reputacion_por_usuario($conexion, $datos_usuario_session['CEDULA_RIF'][0]);
											echo M_dibuja_estrellas($rep_user['PUNTOS'][0]);
										?>
									</a></h6>
									<h5 class="text-warning text-center"><i class='text-light' style="text-decoration: underline;">Ranknig:</i></h5>
									<div class="marco-ajustado hidden rounded w-25 mx-auto">
										<a href="zona_usuario_tabla_ranking.php"><img src="img/ranking_<?php echo strtolower($datos_usuario_session['RANKING'][0]); ?>.png" alt="<?php echo $datos_usuario_session['RANKING'][0]; ?>" title="<?php echo $datos_usuario_session['RANKING'][0]; ?>" class="imgFit w-75"></a>
									</div>
									<h6 class="text-center text-warning"><a href="zona_usuario_tabla_ranking.php" class="text-warning" title="Ver Metas de Ranking"><?php echo $datos_usuario_session['RANKING'][0]; ?></a></h6>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col-6 text-left">
									<a class="text-warning" href="datos_usuario.php" title="Ver o modificar tus datos personales"><span class="fa fa-user-circle-o"></span>&nbsp;Datos</a>
								</div>
								<div class="col-6 pb-2 text-right">
									<a class="text-warning" href="salir.php" title="Salir del sistema" onclick="return confirmar2('salir.php')">
										<span class="fa fa-power-off">&nbsp;</span>Salir
									</a>
									<script>
										function confirmar2(url){
											if(confirm('¿Seguro que deseas Salir del Sistema?')){
												window.location=url;
											}else{
												return false;
											}	
										}
									</script>
								</div>
							</div>
						</div>
						<?php
							}
						?>
					</div>
				</div>
			</li>
			<!-- PREGUNTAS FRECUENTES -->
			<li class="nav-item h4 d-none d-md-block"><strong><a class="nav-link text-warning fa fa-question-circle px-1" href="zona_usuario_preguntas_frecuentes.php" title="Preguntas Frecuentes"></a></strong></li>
			<!-- ZONA DE CONTACTANOS -->
			<li class="nav-item h4 d-none d-md-block"><strong><a class="nav-link text-warning fa fa-envelope px-1" href="zona_usuario_nueva_pregunta.php" title="Contáctanos"></a></strong></li>
			<!-- IR AL FINAL DE LA PÁGINA -->
			<li class="nav-item h4 d-none d-md-block"><strong><a class="nav-link text-warning fa fa-chevron-circle-down px-1" href="#footer_con_ajuste_usuario" title="Ir al final"></a></strong></li>
			<!-- HOME -->
			<li class="nav-item h4 d-none d-md-block"><strong><a class="nav-link text-warning fa fa-home px-1" href="zona_usuario.php" title="Inicio"></a></strong></li>
		</ul>
	</div>
</nav>
<div id="nav_usuario"></div>
<!-------------------- BARRA ASIDE ------------------------------------>
<section class="container-fluid pt-2 mt-5 mb-0">
	<div class="row">
		<!-- Sidebar  -->
		<aside class="col-0 col-md-3 col-lg-2 d-none d-md-inline-block bg-dark text-light border-warning border-right">
			<?php require("PHP_REQUIRES/menu_lateral.php") ?>
		</aside>
		<!------------ INICIO DE LA SECCION DE CONTENIDO DE LA PAGINA -------------------->
		<!-- Page Content  -->
		<div class="col-12 col-md-9 col-lg-10 border-left border-dark bg-secondary">
			