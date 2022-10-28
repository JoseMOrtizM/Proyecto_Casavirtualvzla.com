<?php
//LINKS DE ADMINISTRACIÓN
if($datos_usuario_session['ACCESO'][0]=='ADMINISTRADOR'){
?>
	<h5 class="text-light text-center border-secondary mt-3 mb-3 pb-3 border-bottom">ADMINISTRADOR</h5>
	<form class="form-inline my-2" action="zona_usuario_buscar.php" method="post">
		<div class="input-group my-1">
			<div class="col-1 btn btn-warning rounded-0 w-100 px-0">
				<a href="zona_usuario_buscar.php" class="text-dark" title="Búsqueda Avanzada"><b>+</b></a>
			</div>
			<input class="col-10 form-control p-0 m-0 px-2 rounded-0" type="text" id="buscar" name="buscar" title="Buscar Productos para Comprar" placeholder=" Buscar Productos" required/>
			<input class="col-1 btn btn-warning rounded-0 w-100 px-0" type="submit" title="Buscar" value="&raquo;">
		</div>
	</form>
	<h5 class="text-warning text-center"><span class="text-light fa fa-clock-o d-inline"></span> <i class='text-light' style="text-decoration: underline;">Tareas:</i></h5>
	<ul class="px-1 text-warning border-secondary mb-3 pb-3 border-bottom">
		<li><a href="zona_usuario_directorio.php" class="text-warning text-left" title="Políticas de Privacidad">Directorio</a></li>
		<li><a href="zona_adm_indicadores.php" class="text-warning">Indicadores</a></li>
		<li>
			<a href="zona_adm_actualizar_inventario.php" class="text-warning">
				Act. Inventario
				<?php
					$inventario_hoy=M_balance_administrativo_lcv_R_fecha_tipo_transaccion($conexion, date("Y-m-d h:m:s"), 'ACTUALIZAR INVENTARIO');
					if($inventario_hoy['CANTIDAD_REGISTROS'][0]<1){
						echo "<span class='text-danger fa fa-bell' title='No se ha actualizado el inventario Hoy'></span>";
					}
				?>
			</a>
		</li>
		<li>
			<a href="zona_adm_actualizar_rankings.php" class="text-warning">
				Act. Ranking
				<?php
					$ranking_hoy=M_balance_administrativo_lcv_R_fecha_tipo_transaccion($conexion, date("Y-m-d h:m:s"), 'ACTUALIZAR RANKINGS');
					if($ranking_hoy['CANTIDAD_REGISTROS'][0]<1){
						echo "<span class='text-danger fa fa-bell' title='No se ha actualizado el ranking de usuarios Hoy'></span>";
					}
				?>
			</a>
		</li>
		<li>
			<a href="zona_adm_aprobar_pemon.php" class="text-warning">
				Aprobar Pemón
				<?php
					$solicitados=M_compra_venta_de_micoin_R($conexion, 'ESTATUS', 'SOLICITADO', '', '', '', '');
					$pagados=M_compra_venta_de_micoin_R($conexion, 'ESTATUS', 'PAGADO', '', '', '', '');
					if($solicitados['ID_COMPRA_VENTA'][0]>0 or $pagados['ID_COMPRA_VENTA'][0]>0){
						echo "<span class='text-danger fa fa-bell' title='Tienes operaciones pendientes por aprobar'></span>";
						$verf_dollares=false;
					}else{
						$verf_dollares=true;
					}
				?>
			</a>
		</li>
		<li>
			<a href="zona_adm_operaciones_con_dollar.php" class="text-warning">
				Operaciones $
				<?php
					if($verf_dollares){
						$datos_ultimo_balance_ii=M_balance_administrativo_lcv_R_ultimo($conexion);
						$datos_ventas_solicitadas_ii=M_compra_venta_de_micoin_R($conexion, 'ESTATUS', 'SOLICITADO', '', '', '', '');
						$ventas_acum_ii=0;
						$i=0;
						while(isset($datos_ventas_solicitadas_ii['ID_COMPRA_VENTA'][$i])){
							if($datos_ventas_solicitadas_ii['ID_COMPRA_VENTA'][$i]<>""){
								$ventas_acum_ii= $ventas_acum_ii+$datos_ventas_solicitadas_ii['MONTO_NETO'][$i];
							}
							$i++;
						}
						$diferencia_bs_ii=$datos_ultimo_balance_ii['RA_RES_MON_BS_PUROS'][0] - $ventas_acum_ii;
						$diferencia_dollares_ii= $diferencia_bs_ii/$datos_ultimo_balance_ii['TC_BS_DOLLAR'][0];
						if($diferencia_bs_ii<0){
							echo "<span class='text-danger fa fa-bell' title='Hay que vender " . number_format($diferencia_dollares_ii, 2,',','.') . " dollares que equivalen a " . number_format($diferencia_bs_ii, 2,',','.') . " Bs'></span>";
						}
					}
				?>
			</a>
		</li>
		<li><a href="zona_adm_otras_operaciones.php" class="text-warning">Otras Operaciones</a></li>
		<li>
			<a href="zona_adm_cambio_bs_x_dollar.php" class="text-warning">
				Actualizar Bs/$
				<?php
					$tasa_cambio_hoy= M_balance_administrativo_lcv_R_fecha_tipo_transaccion($conexion, date("Y-m-d h:m:s"), 'ACTUALIZAR TASA DE CAMBIO (Bs/$)');
					if($tasa_cambio_hoy['CANTIDAD_REGISTROS'][0]<1){
						echo "<span class='text-danger fa fa-bell' title='No se ha actualizado la paridad Bs/$ Hoy'></span>";
					}
				?>
			</a>
		</li>
		<li><a href="zona_adm_editar_imagen.php" class="text-warning">Editar Imagen</a></li>
		<li><a href="zona_adm_respaldar_bd.php" class="text-warning">Respaldar BD</a></li>
	</ul>
	<h5 class="text-warning text-center"><span class="text-light fa fa-database d-inline"></span> <i class='text-light' style="text-decoration: underline;">Base de Datos:</i></h5>
	<ul class="px-1 text-warning border-secondary mb-2 pb-2 border-bottom">
		<li><a class="text-warning text-left" href="CRUD_usuarios.php" title="Administrar datos de Usuarios">Usuarios</a></li>
		<li>
			<a class="text-warning text-left" href="CRUD_productos.php" title="Administrar Productos y/o Servicios">
				Productos
				<?php
					//ALERTA DE NUEVOS PRODUCTOS
					$prod_sin_revisar=M_productos_y_servicios_R($conexion, 'REVISADO', 'NO', '', '', '', '');
					if(isset($prod_sin_revisar['ID_PRODUCTO'][0])){
						if($prod_sin_revisar['ID_PRODUCTO'][0]<>""){
							echo "<span class='text-danger fa fa-bell' title='Hay Productos Sin Revisar'></span>";
						}
					}
					// VERIFICANDO SI EXISTEN MALAS PALABRAS
					$todos_los_prod=M_productos_y_servicios_R($conexion, '', '', '', '', '', '');
					$i=0;
					$cadena_de_texto="";
					while(isset($todos_los_prod['NOMBRE_PRODUCTO'][$i])){
						$cadena_de_texto=$cadena_de_texto . " " . $todos_los_prod['NOMBRE_PRODUCTO'][$i] . " " . $todos_los_prod['DESCRIPCION_PRODUCTO'][$i] . " " . $todos_los_prod['CARACTERISTICAS_PRODUCTO'][$i] . " ";
						$i++;
					}
					$verf_groceria=false;
					$grocerias=M_palabras_prohibidas();
					$palabras=explode(" ", str_replace(">", " ", str_replace("<", " ", $cadena_de_texto)));
					$contador_ii=0;
					while(isset($palabras[$contador_ii])){
						$contador_iii=0;
						while(isset($grocerias[$contador_iii])){
							if(strtolower($palabras[$contador_ii]) == strtolower($grocerias[$contador_iii])){
								$verf_groceria=true;
							}
							$contador_iii++;
						}
						$contador_ii++;
					}
					if($verf_groceria){
						echo "<span class='text-danger fa fa-exclamation-triangle' title='Hay Productos Con malas Palabras'></span>";
					}
				?>
			</a>
		</li>
		<li><a class="text-warning text-left" href="CRUD_categorias.php" title="Administrar Categorias para Productos">Categorías</a></li>
		<li><a class="text-warning text-left" href="CRUD_etiquetas.php" title="Administrar Etiquetas para Productos">Etiquetas</a></li>
		<li>
			<a class="text-warning text-left" href="CRUD_blog_externo.php" title="Administrar Información del Blog Externo">
				Blog Externo
				<?php
					$pendiente_blog_ext=M_blog_externo_R($conexion, 'RESPUESTA', '', '', '', '', '');
					if($pendiente_blog_ext['ID_COMENTARIO_EXT'][0]<>0){
						echo "<span class='text-danger fa fa-bell' title='Hay mensajes pendientes por responder'></span>";
					}
				?>
			</a>
		</li>
		<li>
			<a class="text-warning text-left" href="CRUD_blog_interno.php" title="Administrar Información del Blog Interno">
				Blog Interno
				<?php
					$pendiente_blog_int=M_blog_interno_R($conexion, 'RESPUESTA', '', '', '', '', '');
					if($pendiente_blog_int['ID_COMENTARIO_INT'][0]<>0){
						echo "<span class='text-danger fa fa-bell' title='Hay mensajes pendientes por responder'></span>";
					}
				?>
			</a>
		</li>
		<li>
			<a class="text-warning text-left" href="CRUD_preguntas_al_vendedor.php" title="Administrar Preguntas al Vendedor">
				Preg. Vendedor
				<?php
					//ALERTA DE NUEVOS PRODUCTOS
					$datos_sr=M_pregunta_vendedor_R($conexion, 'mc_preguntas_al_vendedor', 'REVISADO', 'NO', '', '', '', '', '', '');
					if(isset($datos_sr['ID_PREGUNTAS_AL_VENDEDOR'][0])){
						if($datos_sr['ID_PREGUNTAS_AL_VENDEDOR'][0]<>""){
							echo "<span class='text-danger fa fa-bell' title='Hay Comentarios Sin Revisar'></span>";
						}
					}
					// VERIFICANDO SI EXISTEN MALAS PALABRAS
					$todas_las_preg=M_pregunta_vendedor_R($conexion, '', '', '', '', '', '', '', '', '');
					$i=0;
					$cadena_de_texto="";
					while(isset($todas_las_preg['PREGUNTA'][$i])){
						$cadena_de_texto=$cadena_de_texto . " " . $todas_las_preg['PREGUNTA'][$i] . " " . $todas_las_preg['RESPUESTA'][$i] . " ";
						$i++;
					}
					$verf_groceria=false;
					$grocerias=M_palabras_prohibidas();
					$palabras=explode(" ", str_replace(">", " ", str_replace("<", " ", $cadena_de_texto)));
					$contador_ii=0;
					while(isset($palabras[$contador_ii])){
						$contador_iii=0;
						while(isset($grocerias[$contador_iii])){
							if(strtolower($palabras[$contador_ii]) == strtolower($grocerias[$contador_iii])){
								$verf_groceria=true;
							}
							$contador_iii++;
						}
						$contador_ii++;
					}
					if($verf_groceria){
						echo "<span class='text-danger fa fa-exclamation-triangle' title='Hay Productos Con malas Palabras'></span>";
					}
				?>
			</a>
		</li>
		<li><a class="text-warning text-left" href="CRUD_compra_venta_de_micoin.php" title="Administrar Compras y Ventas de Pemón">C-V Pemón</a></li>
		<li><a class="text-warning text-left" href="CRUD_control_de_transacciones_micoin.php" title="Administrar Compras y Ventas de Productos">C-V Productos</a></li>
		<li><a class="text-warning text-left" href="CRUD_paridad_cambiaria.php" title="Administrar Tasa de Cambio">Tasa de Cambio</a></li>
		<li><a class="text-warning text-left" href="CRUD_ciudades.php" title="Administrar Ciudades">Ciudades</a></li>
		<li><a class="text-warning text-left" href="CRUD_parroquias.php" title="Administrar Municipios y Parroquias">Parroquias</a></li>
		<li><a class="text-warning text-left" href="CRUD_historial_de_busqueda.php" title="Administrar historial de busqueda de Usuarios">Hist. Busqueda</a></li>
	</ul>
	<h5 class="text-warning text-center"><span class="text-light d-inline fa fa-book"></span> <i class='text-light' style="text-decoration: underline;">Políticas:</i></h5>
	<ul class="px-1 text-warning">
		<li><a href="politicas.php" class="text-warning text-left" title="Políticas de Privacidad" target="_blank">Políticas</a></li>
		<li><a href="condiciones.php" class="text-warning text-left" title="Condiciones de Uso" target="_blank">Condiciones</a></li>
		<li><a href="cookies.php" class="text-warning text-left" title="Uso de Cookies" target="_blank">Cookies</a></li>
	</ul>
<?php
//LINKS DE ANALISTA
}else if($datos_usuario_session['ACCESO'][0]=='ANALISTA'){
?>
	<h5 class="text-light text-center border-secondary mt-3 mb-3 pb-3 border-bottom">ANALISTA</h5>
	<h5 class="text-warning text-center"><span class="text-light fa fa-clock-o d-inline"></span> <i class='text-light' style="text-decoration: underline;">Tareas:</i></h5>
	<ul class="px-1 text-warning border-secondary mb-3 pb-3 border-bottom">
		<li><a href="zona_adm_actualizar_inventario.php" class="text-warning">Actualizar Inventarios</a></li>
		<li><a href="zona_adm_actualizar_rankings.php" class="text-warning">Actualizar Rankings</a></li>
	</ul>
	<h5 class="text-warning text-center"><span class="text-light fa fa-database d-inline"></span> <i class='text-light' style="text-decoration: underline;">Base de Datos:</i></h5>
	<ul class="px-1 text-warning border-secondary mb-2 pb-2 border-bottom">
		<li><a class="text-warning text-left" href="CRUD_usuarios.php" title="Ver, cargar, modificar o eliminar datos de Usuarios">Usuarios</a></li>
		<li>
			<a class="text-warning text-left" href="CRUD_productos.php" title="Ver, cargar, modificar o eliminar Productos y/o Servicios">
				Productos
				<?php
					$prod_sin_revisar=M_productos_y_servicios_R($conexion, 'REVISADO', 'NO', '', '', '', '');
					if(isset($prod_sin_revisar['ID_PRODUCTO'][0])){
						if($prod_sin_revisar['ID_PRODUCTO'][0]<>""){
						echo "<span class='text-danger fa fa-bell' title='Hay Productos Sin Revisar'></span>";
						}
					}
				?>
			</a>
		</li>
		<li><a class="text-warning text-left" href="CRUD_categorias.php" title="Ver, cargar, modificar o eliminar Categorias para Productos">Categorías</a></li>
		<li><a class="text-warning text-left" href="CRUD_etiquetas.php" title="Ver, cargar, modificar o eliminar Etiquetas para Productos">Etiquetas</a></li>
		<li>
			<a class="text-warning text-left" href="CRUD_blog_externo.php" title="Administrar Información del Blog Externo">
				Blog Externo
				<?php
					$pendiente_blog_ext=M_blog_externo_R($conexion, 'RESPUESTA', '', '', '', '', '');
					if($pendiente_blog_ext['ID_COMENTARIO_EXT'][0]<>0){
						echo "<span class='text-danger fa fa-bell' title='Hay mensajes pendientes por responder'></span>";
					}
				?>
			</a>
		</li>
		<li>
			<a class="text-warning text-left" href="CRUD_blog_interno.php" title="Administrar Información del Blog Interno">
				Blog Interno
				<?php
					$pendiente_blog_int=M_blog_interno_R($conexion, 'RESPUESTA', '', '', '', '', '');
					if($pendiente_blog_int['ID_COMENTARIO_INT'][0]<>0){
						echo "<span class='text-danger fa fa-bell' title='Hay mensajes pendientes por responder'></span>";
					}
				?>
			</a>
		</li>
		<li><a class="text-warning text-left" href="CRUD_preguntas_al_vendedor.php" title="Administrar Preguntas al Vendedor">Preg. Vendedor</a></li>
		<li><a class="text-warning text-left" href="CRUD_ciudades.php" title="Ver, cargar, modificar o eliminar Ciudades">Ciudades</a></li>
		<li><a class="text-warning text-left" href="CRUD_parroquias.php" title="Ver, cargar, modificar o eliminar Municipios y Parroquias">Parroquias</a></li>
		<li><a class="text-warning text-left" href="CRUD_historial_de_busqueda.php" title="Ver, cargar, modificar o eliminar historial de busqueda de Usuarios">Hist. Busqueda</a></li>
	</ul>
	<h5 class="text-warning text-center"><span class="text-light d-inline fa fa-book"></span> <i class='text-light' style="text-decoration: underline;">Políticas:</i></h5>
	<ul class="px-1 text-warning">
		<li><a href="politicas.php" class="text-warning text-left" title="Políticas de Privacidad" target="_blank">Políticas</a></li>
		<li><a href="condiciones.php" class="text-warning text-left" title="Condiciones de Uso" target="_blank">Condiciones</a></li>
		<li><a href="cookies.php" class="text-warning text-left" title="Uso de Cookies" target="_blank">Cookies</a></li>
	</ul>
<?php
//LINKS DE COMPRADOR-VENDEDOR
}else{
?>
	<div class="text-center my-2 h3">
		<span class="text-warning fa fa-shopping-cart"></span> 
		<a href="zona_usuario_carrito_compra.php" class="h6 text-light" title="Ver Carrito de la Compra">
		<?php
			$datos_carrito_menu_lateral=M_carrito_compra_R($conexion, 'mc_usuarios', 'ID_USUARIO', $datos_usuario_session['ID_USUARIO'][0], 'mc_carrito_compra', 'ESTATUS', 'APARTADO', '', '', '');
			$cta_car=0;
			while(isset($datos_carrito_menu_lateral['ID_CARRITO_COMPRA'][$cta_car])){
				$cta_car=$cta_car+1;
			}
			if(isset($datos_carrito_menu_lateral['ID_CARRITO_COMPRA'][0])){
				if($datos_carrito_menu_lateral['ID_CARRITO_COMPRA'][0]==""){
					if($cta_car==1){
						$cta_car=0;
					}
				}
			}
			echo $cta_car;
		?>
		 Productos
	</a>
	</div>
	<form class="form-inline my-2" action="zona_usuario_buscar.php" method="post">
		<div class="input-group my-1">
			<div class="col-1 btn btn-warning rounded-0 w-100 px-0">
				<a href="zona_usuario_buscar.php" class="text-dark" title="Búsqueda Avanzada"><b>+</b></a>
			</div>
			<input class="col-10 form-control p-0 m-0 px-2 rounded-0" type="text" id="buscar" name="buscar" title="Buscar Productos para Comprar" placeholder=" Buscar Productos" required/>
			<input class="col-1 btn btn-warning rounded-0 w-100 px-0" type="submit" title="Buscar" value="&raquo;">
		</div>
	</form>
	<h5 class="text-warning text-center"><i class='text-light' style="text-decoration: underline;">El Arca:</i></h5>
	<ul class="px-1 text-warning border-secondary mb-2 pb-2 border-bottom">
		<li><a href="zona_usuario_arca_consolidado.php" class="text-warning" title="Ver Posición Consolidada">Consolidado</a></li>
		<li><a href="zona_usuario_arca_comprar.php" class="text-warning" title="Adquirir Moneda Virtual">Comprar <b>Pm</b></a></li>
		<li><a href="zona_usuario_arca_vender.php" class="text-warning" title="Canjear Pm por Bs.">Vender <b>Pm</b></a></li>
	</ul>
	<h5 class="text-warning text-center"><i class='text-light' style="text-decoration: underline;">Mis Productos:</i></h5>
	<ul class="px-1 text-warning border-secondary mb-2 pb-2 border-bottom">
		<li><a href="zona_usuario_prod_publicados.php" class="text-warning" title="Ver Productos Publicados">Publicados</a></li>
		<li>
			<a href="zona_usuario_prod_preguntas_al_vendedor.php" class="text-warning" title="Ver y responder Preguntas de Clientes">Pregunta/Resp.
			<?php
				$preg_sin_cont_notif=M_pregunta_vendedor_R($conexion, 'mc_productos_y_servicios', 'CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'mc_preguntas_al_vendedor', 'RESPUESTA', '', '', '', '');
				if($preg_sin_cont_notif['PREGUNTA'][0]<>''){
					echo "<span class='text-danger fa fa-bell' title='Tienes preguntas pendientes por contestar'></span>";
				}
			?>
			</a>
		</li>
		<li>
			<a href="zona_usuario_prod_vendidos.php" class="text-warning" title="Ver Productos Vendidos">Vendidos 
			<?php
				$datos=M_control_de_transacciones_compras_en_micoin_R($conexion, 'VENDEDOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], '', '', '', '');
				$verf_entregas_pendientes=false;
				for($i=0;$i<count($datos['ESTATUS']);$i++){
					if($datos['ESTATUS'][$i]=='PAGADO' and $datos['TIPO_DE_COMPRA'][$i]=='PREMIUN'){
						$verf_entregas_pendientes=true;
					}
				}
				if($verf_entregas_pendientes){
					echo "<span class='text-primary fa fa-bell' title='Tienes entregas PREMIUN pendientes por confirmar (Introduce el código de seguridad que te facilitará el cliente para registrar el cobro)'></span>";
				}
			?>
			</a>
		</li>
		<li>
			<a href="zona_usuario_prod_comprados.php" class="text-warning" title="Ver Productos Comprados">Comprados 
			<?php
				//COLOCANDO ALERTAS PARA COMPRAS PREMIUN PENDIENTES POR RECIBIR Y EVALUACIONES PENDIENTES POR REALIZAR
				$datos=M_control_de_transacciones_compras_en_micoin_R($conexion, 'COMPRADOR_CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], '', '', '', '');
				$verf_entregas_pendientes=false;
				$verf_evaluaciones_pendientes=false;
				for($i=0;$i<count($datos['ESTATUS']);$i++){
					if($datos['ESTATUS'][$i]=='PAGADO' and $datos['TIPO_DE_COMPRA'][$i]=='PREMIUN'){
						$verf_entregas_pendientes=true;
					}
					if($datos['FH_EVALUACION'][$i]=='0000-00-00 00:00:00'){
						$verf_evaluaciones_pendientes=true;
					}
				}
				if($verf_entregas_pendientes){
					echo "<span class='text-danger fa fa-bell' title='Tienes compras PREMIUN pendientes por confirmar (Entrega el código de seguridad de tu compra al vendedor para registrar el cobro)'></span>";
				}
				if($verf_evaluaciones_pendientes){
					echo "<span class='text-primary fa fa-bell' title='Tienes compras pendientes por Evaluar'></span>";
				}
			?>
			</a>
		</li>
	</ul>
	<h5 class="text-warning text-center"><i class='text-light' style="text-decoration: underline;">Adicionales:</i></h5>
	<ul class="px-1 text-warning border-secondary mb-2 pb-2 border-bottom">
		<li><a href="zona_usuario_directorio.php" class="text-warning" title="Directorio de Usuarios Registrados">Directorio</a></li>
		<li><a href="zona_usuario_preguntas_frecuentes.php" class="text-warning" title="Consultar Preguntas Frecuentes">Dudas Frecuentes</a></li>
		<li><a href="zona_usuario_nueva_pregunta.php" class="text-warning" title="Hacer una Pregunta al equipo de la Casa Virtual">CV- Consultar</a></li>
		<li>
			<a href="zona_usuario_respuestas_por_usuario.php" class="text-warning" title="Ver mis Consultas a la Casa Virtual">
				CV- Mis Consultas
				<?php
					$msg_blog_int=M_blog_interno_R($conexion, 'CEDULA_RIF', $datos_usuario_session['CEDULA_RIF'][0], 'COMENTARIO', '', '', '');
					if($msg_blog_int['ID_COMENTARIO_INT'][0]<>0){
						echo "<span class='text-danger fa fa-bell' title='tienes mensaje de la Casa Virtual'></span>";
					}
				?>
			</a>
		</li>
		<li>
			<a href="zona_usuario_indicadores.php" class="text-warning" title="Ver Mis Estadísticas">
				Mis Indicadores
				<?php
					if($datos_usuario_session['INDICADORES'][0]=='NO'){
						echo "<span class='text-danger fa fa-bell' title='Aún no dispones de nuestro servicio de Indicadores'></span>";
					}
				?>
			</a>
		</li>
		<li>
			<a href="zona_usuario_aliados.php" class="text-warning" title="Conviertete en nuestro Aliado">
				Nuestros Aliados
				<?php
					if($datos_usuario_session['ALIADO'][0]=='NO'){
						echo "<span class='text-danger fa fa-bell' title='Aún no eres nuestro Aliado'></span>";
					}
				?>
			</a>
		</li>
	</ul>
	<h5 class="text-warning text-center"><span class="text-light d-inline fa fa-book"></span> <i class='text-light' style="text-decoration: underline;">Políticas:</i></h5>
	<ul class="px-1 text-warning">
		<li><a href="politicas.php" class="text-warning text-left" title="Políticas de Privacidad" target="_blank">Políticas</a></li>
		<li><a href="condiciones.php" class="text-warning text-left" title="Condiciones de Uso" target="_blank">Condiciones</a></li>
		<li><a href="cookies.php" class="text-warning text-left" title="Uso de Cookies" target="_blank">Cookies</a></li>
	</ul>
<?php
}
?>
<p class="text-dark">xxxxxxx xxxxxxx xxxxxxx</p>
