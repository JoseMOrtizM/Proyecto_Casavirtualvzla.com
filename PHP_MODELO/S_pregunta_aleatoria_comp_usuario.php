<?php 
//ESTA SUB RUTINA IMPRIME LA primera pregunta aleatoria dado una cedula de usuario
if(isset($_POST['cedula'])){
	$cedula=$_POST['cedula']; 
	require_once ("M_todos.php");
	$datos_usuario=M_usuarios_R($conexion, 'CEDULA_RIF', $cedula, '', '', '', '');
	//OBTENIENDO PREGUNTA 1
	$pregunta_1=$datos_usuario['PREGUNTA_SEGURIDAD_' . rand(1,5)][0];
	// BTENIENDO PREGUNTA 2
	if($pregunta_1==$datos_usuario['PREGUNTA_SEGURIDAD_1'][0]){
		$pregunta_2=$datos_usuario['PREGUNTA_SEGURIDAD_' . rand(2,5)][0];
	}else if($pregunta_1==$datos_usuario['PREGUNTA_SEGURIDAD_5'][0]){
		$pregunta_2=$datos_usuario['PREGUNTA_SEGURIDAD_' . rand(1,4)][0];
	}else if($pregunta_1==$datos_usuario['PREGUNTA_SEGURIDAD_2'][0]){
		$var_var=rand(3,6);
		if($var_var==6){
			$pregunta_2=$datos_usuario['PREGUNTA_SEGURIDAD_1'][0];
		}else{
			$pregunta_2=$datos_usuario['PREGUNTA_SEGURIDAD_' . $var_var][0];
		}
	}else if($pregunta_1==$datos_usuario['PREGUNTA_SEGURIDAD_3'][0]){
		$var_var=rand(4,7);
		if($var_var==6){
			$pregunta_2=$datos_usuario['PREGUNTA_SEGURIDAD_1'][0];
		}else if($var_var==7){
			$pregunta_2=$datos_usuario['PREGUNTA_SEGURIDAD_2'][0];
		}else{
			$pregunta_2=$datos_usuario['PREGUNTA_SEGURIDAD_' . $var_var][0];
		}
	}else{// LÓGICAMENTE $_post['preg_1'] TIENE QUE SER LA PREGUNTA 4
		$var_var=rand(5,8);
		if($var_var==6){
			$pregunta_2=$datos_usuario['PREGUNTA_SEGURIDAD_1'][0];
		}else if($var_var==7){
			$pregunta_2=$datos_usuario['PREGUNTA_SEGURIDAD_2'][0];
		}else if($var_var==8){
			$pregunta_2=$datos_usuario['PREGUNTA_SEGURIDAD_3'][0];
		}else{
			$pregunta_2=$datos_usuario['PREGUNTA_SEGURIDAD_' . $var_var][0];
		}
	}
	if($pregunta_1<>"" and $pregunta_2<>""){
		echo "
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100' style='height: 50px;'>Pregunta N°1:</span>
				</div>
				<input type='hidden' name='pregunta_1' id='pregunta_1' value='" . $pregunta_1 . "'>
				<div class='col-md-9 p-0 m-0 px-2 rounded-0 pt-1 text-left bg-light' style='height: 50px;'>" . $pregunta_1 . "
				</div>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Respuesta N°1:</span>
				</div>
				<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='respuesta_1' id='respuesta_1' placeholder='Indique su respuesta 1' required autocomplete='off' title='Indique su respuesta'>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100' style='height: 50px;'>Pregunta N°2:</span>
				</div>
				<input type='hidden' name='pregunta_2' id='pregunta_2' value='" . $pregunta_2 . "'>
				<div class='col-md-9 p-0 m-0 px-2 rounded-0 pt-1 text-left bg-light' style='height: 50px;'>" . $pregunta_2 . "
				</div>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Respuesta N°2:</span>
				</div>
				<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='respuesta_2' id='respuesta_2' placeholder='Indique su respuesta 2' required autocomplete='off' title='Indique su respuesta'>
			</div>
			<h5 class='text-center text-warning'>IP de usuario:</h5>
			<div class='input-group mb-2'>
				<div class='col-md-10 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100 rounded-0' title='¿Quieres agregar este equipo a la lista de tus equipos de uso frecuente?'>¿Equipo de uso frecuente?</span>
				</div>
				<select class='form-control col-md-2 p-0 m-0 px-2 rounded-0' name='confirma_ip' id='confirma_ip' required autocomplete='off'>
					<option></option>
					<option>SI</option>
					<option>NO</option>
				</select>
			</div>
			<div class='m-auto pt-2'>
				<a href='index.php' class='btn btn-warning text-dark mb-2'><span class='fa fa-reply-all'></span> Volver</a>&nbsp;&nbsp;<input type='submit' value='Validar Usuario &raquo;' class='btn btn-warning mb-2'>
			</div>
		";
	}else{
		echo "<b class='text-danger mb-2'>Cédula Inválida</b>";
		echo "
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100' style='height: 50px;'>Pregunta N°1:</span>
				</div>
				<div class='col-md-9 p-0 m-0 px-2 rounded-0 pt-1 text-left bg-light' style='height: 50px;'>
				</div>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Respuesta N°1:</span>
				</div>
				<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='respuesta_1' id='respuesta_1' placeholder='Indique su respuesta 1' required autocomplete='off' title='Indique su respuesta'>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100' style='height: 50px;'>Pregunta N°2:</span>
				</div>
				<div class='col-md-9 p-0 m-0 px-2 rounded-0 pt-1 text-left bg-light' style='height: 50px;'>
				</div>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Respuesta N°2:</span>
				</div>
				<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='respuesta_2' id='respuesta_2' placeholder='Indique su respuesta 2' required autocomplete='off' title='Indique su respuesta'>
			</div>
			<h5 class='text-center text-warning'>IP de usuario:</h5>
			<div class='input-group mb-2'>
				<div class='col-md-10 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100 rounded-0' title='¿Quieres agregar este equipo a la lista de tus equipos de uso frecuente?'>¿Equipo de uso frecuente?</span>
				</div>
				<select class='form-control col-md-2 p-0 m-0 px-2 rounded-0' name='confirma_ip' id='confirma_ip' required autocomplete='off'>
					<option></option>
					<option>SI</option>
					<option>NO</option>
				</select>
			</div>
			<div class='m-auto pt-2'>
				<a href='index.php' class='btn btn-warning text-dark mb-2'><span class='fa fa-reply-all'></span> Volver</a>&nbsp;&nbsp;<input type='submit' value='Validar Usuario &raquo;' class='btn btn-warning mb-2'>
			</div>
		";
	}
}
?>