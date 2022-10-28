<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST['FORM'])){
		if($_POST['FORM']=='BORRAR'){
			$id_historial=mysqli_real_escape_string($conexion, $_POST['id_historial']);
			M_historial_de_busqueda_D_id($conexion, $id_historial);
		}
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>BD-Busqueda</title>
</head>
<body>
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid px-0 mx-0 mx-md-2 px-md-4 mt-2 mb-5 bg-secondary">
		<br>
	<?php
	//VERIFICANDO Si SE MARCO ALGUNA OPCION EN LA TABLA PRINCIPAL DEL CRUD
	if(isset($_GET["accion"])){
		//SI SE QUIERE BORRAR UN RENGLON ENTONCES:
		if($_GET["accion"]=='borrar'){
		?>
		<br><br><br>
		<div class="col-md-12 col-lg-9 mx-auto">
			<form action="CRUD_historial_de_busqueda.php" method="post" class="text-center bg-dark p-2 rounded">
				<h3 class="text-center text-light pb-3" title="Borrar un Renglón">¿Seguro que desea Borrar el renglón de ID <?php echo $_GET['NA_Id']; ?>?</h3>
				<input type="hidden" name="FORM" id="FORM" value="BORRAR">
				<input type="hidden" name="id_historial" id="id_historial" value="<?php echo $_GET["NA_Id"]; ?>">
				<div class="m-auto">
					<a href="CRUD_historial_de_busqueda.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Borrar Renglón &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
			<br><br><br><br><br><br><br><br>
		</div>
		<?php
			//SI NO SE HIZO NINGUNA ACCIÓN:
		}else{
		?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_historial_de_busqueda.php">
	<?php
	//CIERRE DE LA ETIQUETA PARA EMBUTIR HTML EN PHP
	}
	}else{
	?>
	<!-- DataTables Example -->
	<div class="card mb-3 bg-dark rounded-0 col-12 col-lg-9 mx-auto px-0">
		<div class="card-header text-center text-warning">
			<h3 class='text-center'><span class="fa fa-database"></span> Navegación:</h3>
		</div>
		<div class="card-body px-1 bg-white">
			<div class="table-responsive">
				<table class="table table-bordered table-hover TablaDinamica">
					<thead>
						<tr class="text-center">
							<th class="align-middle"><b title="Información de navegación">Información<br>Navegación</b></th>
							<th class="align-middle"><b title="Descripción del texto buscado"><span class="fa fa-arrow-down"></span></b></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//obteniendo los datos de la tabla:
						$datos=M_historial_de_busqueda_R($conexion, '', '', '', '', '', '');
						$i=0;
						while(isset($datos['ID_HIST_NAV'][$i])){
							if($datos['ID_HIST_NAV'][$i]<>""){
								echo "<tr>";
								echo "<td class='text-left'><b title='Donde fue la navegación'>Tipo:</b> " . $datos['TIPO'][$i]  . "<br>";
								if($datos['TIPO'][$i]=='EXTERNO'){
									echo "<b>IP:</b> " . $datos['NAVEGACION_IP'][$i] . "<br>";
								}else{
									echo "<b>Usuario:</b>" . $datos['NOMBRE'][$i] . " " . $datos['APELLIDO'][$i] . "<br>";
								}
								echo "<b>Fecha:</b> " . $datos['FH_NAVEGACION'][$i] . "<br>";
								echo "<b>Página:</b> " . $datos['PAGINA'][$i] . "<br>";
								echo "<b>Busqueda:</b> " . $datos['TEXTO_BUSCADO'][$i] . "</td>";
								echo "<td class='text-center h5'><a title='Eliminar' href='CRUD_historial_de_busqueda.php?accion=borrar&NA_Id=" . $datos['ID_HIST_NAV'][$i] . "' class='btn btn-transparent text-danger fa fa-trash-o d-inline'></a></td>";
								echo "</tr>";
							}
							$i=$i+1;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	//CIERRE DE LA ETIQUETA PARA EMBUTIR HTML EN PHP		
}
	?>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>