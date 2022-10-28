<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<?php
	//VERIFICANDO ACCIONES DE INSERTAR, MODIFICAR Y BORRAR:
	if(isset($_POST['FORM'])){
		if($_POST['FORM']=='INSERTAR'){
			$categoria=mysqli_real_escape_string($conexion,$_POST['categoria']);
			$verf_insert=M_categorias_C($conexion, $categoria);
		}else if($_POST['FORM']=='MODIFICAR'){
			$id=mysqli_real_escape_string($conexion, $_POST['id']);
			$categoria=mysqli_real_escape_string($conexion,$_POST['categoria']);
			M_categorias_U_id($conexion, $id, $categoria);
		}else if($_POST['FORM']=='BORRAR'){
			$id=mysqli_real_escape_string($conexion, $_POST['id']);
			M_categorias_D_id($conexion, $id);
		}
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>BD-Categorias</title>
</head>
<body>
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid px-0 mx-0 mx-md-2 px-md-4 mt-2 mb-5 bg-secondary">
		<br>
	<?php
	//VERIFICANDO Si SE MARCO ALGUNA OPCION EN LA TABLA PRINCIPAL DEL CRUD
	if(isset($_GET["accion"])){
			//SI SE QUIERE INSERTAR UN NUEVO RENGLON ENTONCES:
		if($_GET["accion"]=='insertar'){
	?>
			<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
				<div class="row mt-4 align-items-center rounded-top px-2">
					<div class="col-md-9 mb-1 mt-3">
						<h3 class="text-center text-md-left text-warning" title="Insertar nueva Categoria">Insertar Categoria:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1 mt-3">
						<a href="CRUD_categorias.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_categorias.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="FORM" id="FORM" value="INSERTAR">
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Categoria:</span>
						</div>
						<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="categoria" id="categoria" placeholder="Introduzca la categoria" required autocomplete="off" title="Introduzca la categoria">
					</div>
					<div class="m-auto">
						<a href="CRUD_categorias.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Insertar Nuevo Renglón &raquo;" class="btn btn-warning mb-2">
					</div>
				</form>
			</div>
			<br><br><br><br><br><br><br><br>
		<?php
			//SI SE QUIERE MODIFICAR UN RENGLON ENTONCES:
			}else if($_GET["accion"]=='actualizar'){
				$datos_actualizar=M_categorias_R_id($conexion, $_GET['NA_Id']);
		?>
			<div class="col-md-12 col-lg-10 col-xl-9 mx-auto bg-dark">
				<div class="row mt-4 align-items-center rounded-top px-2">
					<div class="col-md-9 mb-1 mt-3">
						<h3 class="text-center text-md-left text-warning" title="Modificar Categoria">Modificar Categoria:</h3>
					</div>
					<div class="col-md-3 text-center text-md-right mb-1 mt-3">
						<a href="CRUD_categorias.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
					</div>
				</div>
				<form action="CRUD_categorias.php" method="post" class="text-center bg-dark p-2 rounded">
					<input type="hidden" name="FORM" id="FORM" value="MODIFICAR">
					<input type="hidden" name="id" id="id" value="<?php echo $datos_actualizar['ID_CATEGORIA'][0]; ?>">
					<div class="input-group mb-2">
						<div class="col-md-3 p-0 m-0">
							<span class="input-group-text rounded-0 w-100">Categoria:</span>
						</div>
						<input type="text" class="form-control col-md-9 p-0 m-0 px-2 rounded-0" name="categoria" id="categoria" placeholder="Introduzca la categoria" required autocomplete="off" title="Introduzca la categoria" value="<?php echo $datos_actualizar['NOMBRE_CATEGORIA'][0]; ?>">
					</div>
					<div class="m-auto">
						<a href="CRUD_categorias.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Modificar Renglón &raquo;" class="btn btn-warning mb-2">
					</div>
				</form>
			</div>
			<br><br><br><br><br><br><br><br>
		<?php
		//SI SE QUIERE BORRAR UN RENGLON ENTONCES:
	}else if($_GET["accion"]=='borrar'){
		?>
		<br><br><br>
		<div class="col-md-12 col-lg-9 mx-auto">
			<form action="CRUD_categorias.php" method="post" class="text-center bg-dark p-2 rounded">
				<h3 class="text-center text-light pb-3" title="Borrar un Renglón">¿Seguro que desea Borrar el renglón de ID <?php echo $_GET['NA_Id']; ?>?</h3>
				<input type="hidden" name="FORM" id="FORM" value="BORRAR">
				<input type="hidden" name="id" id="id" value="<?php echo $_GET["NA_Id"]; ?>">
				<div class="m-auto">
					<a href="CRUD_categorias.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Borrar Renglón &raquo;" class="btn btn-warning mb-2">
				</div>
			</form>
			<br><br><br><br><br><br><br><br>
		</div>
		<?php
			//SI NO SE HIZO NINGUNA ACCIÓN:
		}else{
		?>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=CRUD_categorias.php">
	<?php
	//CIERRE DE LA ETIQUETA PARA EMBUTIR HTML EN PHP
	}
	}else{
	?>
	<!-- DataTables Example -->
	<?php
	if(isset($verf_insert)){
		if($verf_insert==false){
			echo "<h3 class='text-center text-dark bg-danger my-2 py-2'>El Renglón que está intentando agregar <b>YA EXISTE</b></h3>";
		}
	}
	?>
	<div class="card mb-3 bg-dark rounded-0 col-12 col-lg-9 mx-auto px-0">
		<div class="card-header text-center text-warning">
			<h3 class='text-center'><span class="fa fa-database"></span> Categorías:</h3>
		</div>
		<div class="card-body px-1 bg-white">
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover TablaDinamica">
					<thead>
						<tr class="text-center">
							<th class="align-middle w-75"><b title="Nombre de la Categoría">Categoría</th>
							<th class="align-middle h5 p-0"><a title="Insertar" href="CRUD_categorias.php?accion=insertar" class="h3 btn btn-transparent text-primary fa fa-share-square-o"><br>Insertar</a></th>
						</tr>
					</thead>
					<tbody>
						<?php
						//obteniendo los datos de la tabla:
						$datos=M_categorias_R_todo($conexion);
						$i=0;
						while(isset($datos['ID_CATEGORIA'][$i])){
							if($datos['ID_CATEGORIA'][$i]<>""){
								echo "<tr>";
								echo "<td class='text-left'>" . $datos['NOMBRE_CATEGORIA'][$i] . "</td>";
								echo "<td class='text-center h5'><a title='Modificar' href='CRUD_categorias.php?accion=actualizar&NA_Id=" . $datos['ID_CATEGORIA'][$i] . "' class='btn btn-transparent text-success fa fa-edit d-inline'></a>";
								echo "&nbsp;&nbsp;";
								echo "<a title='Eliminar' href='CRUD_categorias.php?accion=borrar&NA_Id=" . $datos['ID_CATEGORIA'][$i] . "' class='btn btn-transparent text-danger fa fa-trash-o d-inline'></a></td>";
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
	<br><br><br><br><br><br><br><br><br><br><br><br><br>
	<?php
	//CIERRE DE LA ETIQUETA PARA EMBUTIR HTML EN PHP		
}
	?>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>