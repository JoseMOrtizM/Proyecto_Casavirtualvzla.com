<!-- NAV BAR PARA INDEX-->
<nav class="navbar navbar-expand-sm bg-dark fixed-top text-warning py-0 pt-1 px-1 my-0 border-bottom border-warning">
	<!-- LOGO ANIMADO COM "amazingslider"-->
	<a class="navbar-text ml-1 d-block" style="width: 150px" href="index.php">
		<div id="amazingslider-wrapper-1" style="max-width: 150px; height: 38px; margin:0px auto 0px;border:#000 0px solid; overflow:hidden; background-color:transparent" class="bg-dark">
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
	<a class="text-warning h4 mx-1 mt-2 d-block d-sm-none" href="preguntas_frecuentes.php" title="Preguntas Frecuentes"><span class="fa fa-question-circle d-inline d-md-none"></span></a>
	<!-- LINK END-->
	<a class="text-warning h4 mx-1 mt-2 d-block d-sm-none" href="#footer_con_ajuste" title="Ir al final"><span class="fa fa-chevron-circle-down d-inline d-md-none"></span></a>
	<!-- LINK HOME-->
	<a class="text-warning h4 mx-1 mt-2 d-block d-sm-none" href="index.php" title="Inicio"><span class="fa fa-home d-inline d-md-none"></a>
	<!-- BOTON DE COLAPSO-->
	<button class="navbar-toggler border border-warning mr-2" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
		<span id="boton_del_nav" class="text-warning fa fa-bars"></span>
	</button>
	<div class="collapse navbar-collapse pb-1" id="navbarsExample04">
		<ul class="navbar-nav ml-auto pt-1">
			<!-- ZONA DE LOGGING -->
			<li class="nav-item dropdown d-inline">
					<?php
						if(isset($_GET['user'])){
							if($_GET['user']=='invalido'){
								echo "
									<a class='nav-link dropdown-toggle text-danger px-1' href='#' id='dropdown01' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' title='Los datos de usuario introducidos no son válidos'>
								";
							}else{
								echo "
									<a class='nav-link dropdown-toggle text-warning px-1' href='#' id='dropdown01' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' title='Autenticación para Usuarios'>
								";
							}
						}else{
							echo "
								<a class='nav-link dropdown-toggle text-warning px-1' href='#' id='dropdown01' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' title='Autenticación para Usuarios'>
							";
						}
					?>
					<b>Ingresa</b>
				</a>
				<div class="dropdown-menu p-2 text-warning text-center bg-dark border-secondary" style="width: 290px" aria-labelledby="dropdown01">
					<form id="form_comp" name="form_comp" action="comprueba_usuario.php" method="post">
						<input class="form-control mb-1" type="email" id="correo" name="correo" required placeholder="Correo Electrónico" title="Introduzca su Email"/>
						<input class="form-control mb-1" type="password" id="contrasena" name="contrasena" required placeholder="Contraseña" title="Introduzca su Contraseña"/>
						<input class="btn btn-warning text-center p-0 pb-1 m-0 px-1 mb-1" style="color: #000;" type="submit" value="Ingresar"/>
					</form>
					<div class="row mb-1">
						<div class="col-md-12 m-auto">
							<a class="text-center text-light" href="form_recuperar_datos.php" title="Recuperar Correo y Contraseña">Mis datos</a>&nbsp;&nbsp;&nbsp;
							<a class="text-center text-light" href="form_registro_usuario.php" title="Regístrate con nosotros de forma Gratuita">Regístrate</a>
						</div>
					</div>
				</div>
			</li>
			<!-- PREGUNTAS FRECUENTES -->
			<li class="nav-item h4 d-none d-sm-block"><strong><a class="nav-link text-warning fa fa-question-circle px-1" href="preguntas_frecuentes.php" title="Preguntas Frecuentes"></a></strong></li>
			<!-- ZONA DE CONTACTANOS -->
			<li class="nav-item h4 d-none d-sm-block"><strong><a class="nav-link text-warning fa fa-envelope px-1" href="form_contactanos.php" title="Contáctanos"></a></strong></li>
			<!-- IR AL FINAL DE LA PÁGINA -->
			<li class="nav-item h4 d-none d-sm-block"><strong><a class="nav-link text-warning fa fa-chevron-circle-down px-1" href="#footer_con_ajuste" title="Ir al final"></a></strong></li>
			<!-- NOSOTROS -->
			<li class="nav-item h4 d-none d-sm-block"><strong><a class="nav-link text-warning fa fa-sitemap px-1" href="nosotros.php" title="Conócenos"></a></strong></li>
			<!-- HOME -->
			<li class="nav-item h4 d-none d-sm-block"><strong><a class="nav-link text-warning fa fa-home px-1" href="index.php" title="Inicio"></a></strong></li>
			<!-- BUSCAR -->
			<li class="nav-item pt-0 pl-3 pr-4 d-inline">
				<form class="form-inline" action="buscar.php" method="post">
					<div class="row">
						<input class="col-10 my-1 px-1 py-1" type="text" id="buscar" name="buscar" title="Buscar" placeholder="Buscar Productos" required style="width: 150px;"/>
						<input class="col-2 my-1 px-0 my-1 px-1 border border-dark bg-warning" type="submit" title="Buscar" value="&raquo;">
					</div>
				</form>
			</li>
		</ul>
	</div>
</nav>
<div id="nav_principal"></div>
