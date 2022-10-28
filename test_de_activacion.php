<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php 
	session_start();
	// VERIFICANDO SESSION
	if(!isset($_SESSION["usuario"])){
		header("location:salir.php");
	}
	// COMPROBANDO USUARIO
	// RESCATANDO DATOS DE USUARIO
	unset($datos_usuario_session);
	$datos_usuario_session=M_usuarios_R($conexion, 'CORREO', $_SESSION["usuario"], '', '', '', '');
	//VERIFICANDO USUARIO ACTIVO
	if($datos_usuario_session['ESTATUS'][0]<>'REGISTRADO'){
		header("location:salir.php");
	}
?>
<?php require ("PHP_REQUIRES/datos_nav_busq_externos.php"); ?>
<?php
	//VERIFICANDO ACCIONES:
	if(isset($_POST['p_r_1'])){
		//RESCATANDO DATOS DEL FORMULARIO
		$i=0;
		$e=1;
		while($i<10){
			$p[$i]=$_POST['p_' . $e];
			$e=$e+1;
			$i=$i+1;
		}
		$i=0;
		$e=1;
		while($i<10){
			$p_r[$i]=$_POST['p_r_' . $e];
			$e=$e+1;
			$i=$i+1;
		}
		//LLAMANDO A TODAS LAS PREGUNTAS
		$preg_resp=M_test_preguntas_y_respuestas();
		//PREPARANDO VERIFICADORES DE RESPUESTA
		$verf_todo="error";
		$i=0;
		while($i<10){
			$verf_repuestas[$i]=0;
			$i=$i+1;
		}
		//VERIFICANDO RESPUESTAS
		$i=0;
		while($i<10){
			$e=0;
			while($e<count($preg_resp['PREGUNTA'])){//EN ESTE BUCLE HAY UN ERROR
				if($p[$i]==$preg_resp['PREGUNTA'][$e]){
					$respuesta_correcta[$i]=$preg_resp['OPCION_CORRECTA'][$e];
					if($p_r[$i]==$preg_resp['OPCION_CORRECTA'][$e]){
						$verf_repuestas[$i]=1;
					}
				}
				$e=$e+1;
			}
			$i=$i+1;
		}
		if(($verf_repuestas[0] + $verf_repuestas[1] + $verf_repuestas[2] + $verf_repuestas[3] + $verf_repuestas[4] + $verf_repuestas[5] + $verf_repuestas[6] + $verf_repuestas[7] + $verf_repuestas[8] + $verf_repuestas[9]) >= 7){
			$verf_todo="ok";
			M_usuarios_U_id_estatus($conexion, $datos_usuario_session['ID_USUARIO'][0], 'ACTIVO');
		}
	}
?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/seo_meta.php") ?>
	<?php require ("PHP_REQUIRES/head_principal.php"); ?>
	<title>Test de Activación</title>
</head>
<body class="bg-secondary">
	<?php require ("PHP_REQUIRES/nav_principal.php"); ?>
	<section class="container pt-5 mt-5">
	<?php
		//IMPRIMIENDO RESULTADOS DEL EXAMEN
		if(isset($_POST['p_r_1'])){
			//si aprobó
			if($verf_todo=="ok"){
	?>
		<div class="col-md-12 col-lg-9 col-xl-7 mx-auto bg-dark pb-2 mb-4">
			<div class="row mt-4 align-items-center rounded-top px-2">
				<div class="col-md-9 mb-1 mt-3">
					<h3 class="text-center text-md-left text-success"><b>Test APROBADO</b></h3>
				</div>
				<div class="col-md-3 text-center text-md-right mb-1 mt-3">
					<a href="index.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
				</div>
			</div>
			<div class="px-2 text-light">
				<p class="px-2 py-1 text-left">Su cuenta de Usuario ha sido Activada con éxito, ahora puede ingresar a su zona de usuario desde la opción "Ingresa" de la barra de navegación de arriba.</p>
			</div>
		</div>
	<?php			
			//si reprobó
			}else{
	?>
		<div class="col-md-12 col-lg-11 col-xl-10 mx-auto bg-dark pb-2 mb-4">
			<div class="row mt-4 align-items-center rounded-top px-2">
				<div class="col-md-8 mb-1 mt-3">
					<h3 class="text-center text-md-left text-danger"><b>Test REPROBADO</b></h3>
				</div>
				<div class="col-md-4 text-center text-md-right mb-1 mt-3">
					<a href="test_de_activacion.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver a Intentarlo</a>
				</div>
			</div>
			<div class="px-2 text-light">
				<p class="px-2 py-1 text-left">Debe responder correctamnte al menos 7 de las 10 preguntas del test para aprobar. Estos fueron sus resultados:</p>
			</div>
	<?php
		//IMPRIMIENDO RESULTADOS
		$i=0;
		$e=1;
		while($i<10){
			echo "
				<div class='input-group mb-2'>
					<div class='container-fluid text-left bg-light text-dark py-2'>
						<div class='row'>
							<div class='col-12'>
								<h5><b>P-$e) " . $_POST['p_' . $e] . "</b></h5>
							</div>
						</div>
			";
			if($verf_repuestas[$i]==1){
				echo "
						<div class='row'>
							<div class='col-1'>
								<span class='text-success fa fa-check'></span>
							</div>
							<div class='col-11 text-jutify'>
								<label><b class='text-success'>Tu Respuesta:</b> " . $_POST['p_r_' . $e] . "</label>
							</div>
						</div>
					</div>
				</div>
				";
			}else{
				echo "
						<div class='row'>
							<div class='col-1'>
								<span class='text-danger fa fa-remove'></span>
							</div>
							<div class='col-11 text-jutify'>
								<label><b class='text-danger'>Tu Respuesta:</b> " . $_POST['p_r_' . $e] . "</label>
								<br>
								<label><b class='text-success'>Respuesta Correcta:</b> " . $respuesta_correcta[$i] . "</label>
							</div>
						</div>
					</div>
				</div>
				";
			}
			$e=$e+1;
			$i=$i+1;
		}
	?>
		</div>
	<?php			
			}
		//si no ha llenado el examen aún
		}else{
			//LLAMANDO A TODAS LAS PREGUNTAS
			$preg_resp_i=M_test_preguntas_y_respuestas();

	?>
		<div class="col-md-12 col-lg-11 col-xl-10 mx-auto bg-dark pb-2 mb-4">
			<div class="row mt-4 align-items-center rounded-top px-2">
				<div class="col-md-9 mb-1 mt-3">
					<h3 class="text-center text-md-left text-warning"><b>Test para Activación de Cuenta</b></h3>
				</div>
				<div class="col-md-3 text-center text-md-right mb-1 mt-3">
					<a href="index.php" class="btn btn-warning text-dark mb-2"><span class="fa fa-reply-all"></span> Volver</a>
				</div>
			</div>
			<div class="px-2 text-light">
				<p class="px-2 py-1 text-left">Para Activar la cuenta de correo con la que está intentando acceder debe responder correctamnte al menos 7 de 10 preguntas, sobre el funcionamiento y políticas del sitio, que se plantean a continuación...</p>
			</div>
			<form action="test_de_activacion.php" method="post" class="text-center bg-dark p-2 rounded">
				<?php
					//PREPARANDO NUMERO ALATORIO PARA LLAMAR A LAS PREGUNTAS DEL TEST
					$aleatorio[0]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					$aleatorio[1]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					while($aleatorio[1]==$aleatorio[0]){
						$aleatorio[1]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					}
					$aleatorio[2]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					while($aleatorio[2]==$aleatorio[0] or 
						  $aleatorio[2]==$aleatorio[1]){
						$aleatorio[2]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					}
					$aleatorio[3]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					while($aleatorio[3]==$aleatorio[0] or 
						  $aleatorio[3]==$aleatorio[1] or 
						  $aleatorio[3]==$aleatorio[2]){
						$aleatorio[3]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					}
					$aleatorio[4]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					while($aleatorio[4]==$aleatorio[0] or 
						  $aleatorio[4]==$aleatorio[1] or 
						  $aleatorio[4]==$aleatorio[2] or 
						  $aleatorio[4]==$aleatorio[3]){
						$aleatorio[4]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					}
					$aleatorio[5]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					while($aleatorio[5]==$aleatorio[0] or 
						  $aleatorio[5]==$aleatorio[1] or 
						  $aleatorio[5]==$aleatorio[2] or 
						  $aleatorio[5]==$aleatorio[3] or 
						  $aleatorio[5]==$aleatorio[4]){
						$aleatorio[5]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					}
					$aleatorio[6]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					while($aleatorio[6]==$aleatorio[0] or 
						  $aleatorio[6]==$aleatorio[1] or 
						  $aleatorio[6]==$aleatorio[2] or 
						  $aleatorio[6]==$aleatorio[3] or 
						  $aleatorio[6]==$aleatorio[4] or 
						  $aleatorio[6]==$aleatorio[5]){
						$aleatorio[6]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					}
					$aleatorio[7]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					while($aleatorio[7]==$aleatorio[0] or 
						  $aleatorio[7]==$aleatorio[1] or 
						  $aleatorio[7]==$aleatorio[2] or 
						  $aleatorio[7]==$aleatorio[3] or 
						  $aleatorio[7]==$aleatorio[4] or 
						  $aleatorio[7]==$aleatorio[5] or 
						  $aleatorio[7]==$aleatorio[6]){
						$aleatorio[7]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					}
					$aleatorio[8]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					while($aleatorio[8]==$aleatorio[0] or 
						  $aleatorio[8]==$aleatorio[1] or 
						  $aleatorio[8]==$aleatorio[2] or 
						  $aleatorio[8]==$aleatorio[3] or 
						  $aleatorio[8]==$aleatorio[4] or 
						  $aleatorio[8]==$aleatorio[5] or 
						  $aleatorio[8]==$aleatorio[6] or 
						  $aleatorio[8]==$aleatorio[7]){
						$aleatorio[8]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					}
					$aleatorio[9]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					while($aleatorio[9]==$aleatorio[0] or 
						  $aleatorio[9]==$aleatorio[1] or 
						  $aleatorio[9]==$aleatorio[2] or 
						  $aleatorio[9]==$aleatorio[3] or 
						  $aleatorio[9]==$aleatorio[4] or 
						  $aleatorio[9]==$aleatorio[5] or 
						  $aleatorio[9]==$aleatorio[6] or 
						  $aleatorio[9]==$aleatorio[7] or 
						  $aleatorio[9]==$aleatorio[8]){
						$aleatorio[9]=rand(0,count($preg_resp_i['PREGUNTA'])-1);
					}
					//LLAMANDO A TODAS LAS PREGUNTAS
					$preg_resp_i=M_test_preguntas_y_respuestas();
					//IMPRIMIENDO PREGUNTAS
					$i=0;
					$e=1;
					while($i<10){
						//PREPARANDO NUMERO ALATORIO PARA LLAMAR A LAS OPCIONES DE LA PREGUNTA
						$aleat_preg[0]=rand(1,4);
						$aleat_preg[1]=rand(1,4);
						while($aleat_preg[1]==$aleat_preg[0]){
							$aleat_preg[1]=rand(1,4);
						}
						$aleat_preg[2]=rand(1,4);
						while($aleat_preg[2]==$aleat_preg[0] or $aleat_preg[2]==$aleat_preg[1]){
							$aleat_preg[2]=rand(1,4);
						}
						$aleat_preg[3]=rand(1,4);
						while($aleat_preg[3]==$aleat_preg[0] or $aleat_preg[3]==$aleat_preg[1] or $aleat_preg[3]==$aleat_preg[2]){
							$aleat_preg[3]=rand(1,4);
						}
						echo "
							<div class='input-group mb-2'>
								<div class='container-fluid text-left bg-light text-dark py-2'>
									<div class='row'>
										<div class='col-12'>
											<input type='hidden' name='p_$e' value='" . $preg_resp_i['PREGUNTA'][$aleatorio[$i]] . "'>
											<h6><b>P-$e) " . $preg_resp_i['PREGUNTA'][$aleatorio[$i]] . "</b></h6>
										</div>
									</div>
						";
						$u=0;
						while($u<4){
							echo "
									<div class='row mx-0 px-0'>
										<div class='col-1 text-center mx-0 px-0'>
											<input type='radio' name='p_r_$e' value='" . $preg_resp_i['OPCION_' . $aleat_preg[$u]][$aleatorio[$i]] . "' required>
										</div>
										<div class='col-11 text-left mx-0 px-0 pl-1'>
											<label>" . $preg_resp_i['OPCION_' . $aleat_preg[$u]][$aleatorio[$i]] . "</label>
										</div>
									</div>
							";
							$u=$u+1;
						}
						echo "
								</div>
							</div>
						";
						$e=$e+1;
						$i=$i+1;
					}
				?>
				<div class="m-auto">
					<a href="index.php" class="btn btn-warning text-dark my-2"><span class="fa fa-reply-all"></span> Volver</a>&nbsp;&nbsp;<input type="submit" value="Verificar Respuestas &raquo;" class="btn btn-warning my-2">
				</div>
			</form>
		</div>
	<?php			
		}
	?>
	</section>
	<?php require ("PHP_REQUIRES/footer_principal.php"); ?>
</body>
</html>