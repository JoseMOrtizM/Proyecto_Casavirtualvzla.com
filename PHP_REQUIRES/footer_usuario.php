	<!------------------------MENU DESPLGABLE EN PANTALLAS PEQUEÑAS-------------->
			<div class="d-inline d-md-none" id="menu_lateral_arreglo">
				<br><hr>
			</div>
			<div class="d-inline d-md-none">
				<div class="bg-dark px-5 py-1 mb-2">
					<h4 class="text-center text-warning"><b>Menú</b></h4>
					<?php require("PHP_REQUIRES/menu_lateral.php") ?>
				</div>
			</div>
	<!------------------ FINAL DEL ARREGLO PARA ASIDE Y SECCIÓN------------------>
		</div>
	</div>
</section>
<!------------------------------- FOOTER ------------------------------------->
<footer id="footer_con_ajuste_usuario" class="bg-dark pt-2 pb-1 px-5 my-0 fixed-bottom text-dark border-top border-warning">
	<!-- Copy right -->
	<div class="row align-items-center">
		<div class="col text-center h6 text-secondary">© 2020 - Derechos Reservados&nbsp;&nbsp;<a href="#nav_usuario" id="ir_arriba" class="text-warning"><span class="fa fa-chevron-circle-up"></span></a></div>
	</div>
	<script>
		//MOSTRANDO EL CUERPO DEL DOCUMENTO
		$('section').hide();
		//AJUSTANDO PIE DE PAGINA
		$(window).ready(function(){
			if($("body").height()+20<screen.height){
				$("#footer_con_ajuste_usuario").addClass("fixed-bottom");
			}else{
				$("#footer_con_ajuste_usuario").removeClass("fixed-bottom");
			}
		});
	</script>
	<!-- ENLACES PARA LLAMAR AL PAGINADO Y BUSCADOR DE LA DATATABLE -->
	<script src="js/jquery.dataTables.js"></script>
	<script src="js/dataTables.bootstrap4.js"></script>
	<script>
	// LLAMANDO A LA FUNCIÓN DateTable() DE jquery.dataTables.js
		$(document).ready(function() {
			$('.TablaDinamica').DataTable();
		});
	// LLAMANDO A LA FUNCIÓN DateTable() DE jquery.dataTables.js ORDEN DESENDENTE
		$(document).ready(function() {
			$('.TablaDinamicaOrderDesc').DataTable({
				order: [[ 0, 'desc' ]]
			});
		});
	// LLAMANDO A LA FUNCIÓN DateTable() DE jquery.dataTables.js SIN BUSCADOR
		$(document).ready(function() {
			$('.TablaDinamica1').DataTable({
				pageLength: 1, 
				dom: '<"top"i>rt<"bottom"fp><"clear">', 
				searching: false, 
				paging: true, 
				info: false 
			});
			$('.TablaDinamica2').DataTable({
				pageLength: 2, 
				dom: '<"top"i>rt<"bottom"fp><"clear">', 
				searching: false, 
				paging: true, 
				info: false 
			});
			$('.TablaDinamica3').DataTable({
				pageLength: 3, 
				dom: '<"top"i>rt<"bottom"fp><"clear">', 
				searching: false, 
				paging: true, 
				info: false 
			});
			$('.TablaDinamica10').DataTable({
				pageLength: 10, 
				dom: '<"top"i>rt<"bottom"fp><"clear">', 
				searching: false, 
				paging: true, 
				info: false 
			});
		});
	</script>	
</footer>
<?php mysqli_close($conexion); /*SOLO SE DESCONECTA AQUI Y LLAMAMOS A ESTE FOOTER EN TODO A LOS DEMAS*/ ?>