<?php 
//ESTA SUB RUTINA IMPRIME LOS DATOS DEL CLIENTE PARA EL FORMULARIO DE REGISTRO DE COMPRA-VENTA DE DOLLARES
if(isset($_POST['tipo_de_cliente'])){
	require_once ("M_todos.php");
	$tipo_de_cliente=$_POST['tipo_de_cliente']; 
	if($tipo_de_cliente=="Nuevo Cliente"){
		echo "<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Cédula o RIF:</span>
				</div>
				<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='cliente_cedula_rif' id='cliente_cedula_rif' placeholder='Indique cédula o RIF' required autocomplete='off' title='Introduzca su Cédula si es persona natural o el RIF si es una Empresa'>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Nombre:</span>
				</div>
				<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='cliente_nombre' id='cliente_nombre' placeholder='Ej: José Antonio' required autocomplete='off' title='Introduzca el nombre del cliente'>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Apellido:</span>
				</div>
				<input type='text' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='cliente_apellido' id='cliente_apellido' placeholder='Ej: Gonzalez Herrera' required autocomplete='off' title='Introduzca el apellido del cliente'>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Teléfono:</span>
				</div>
				<input type='tel' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='cliente_telefono' id='cliente_telefono' placeholder='Ej: 0414-1234567' required autocomplete='off' title='Introduzca el número de teléfono del cliente'>
			</div>
			<div class='input-group mb-2'>
				<span class='input-group-text rounded-0 w-100'>Dirección:</span>
				<textarea class='form-control p-0 m-0 px-2 rounded-0' name='cliente_direccion' id='cliente_direccion' placeholder='Introduzca su dirección' required autocomplete='off' title='Introduzca la dirección del cliente' rows='2'></textarea>
			</div>";
	}else if($tipo_de_cliente=="Cliente Registrado"){
		$datos=M_control_cambio_dollar_bolivar_R_agrupa_clientes($conexion);
		echo "<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100 rounded-0'>Cliente:</span>
				</div>
				<select class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='datos_cliente' id='datos_cliente' required autocomplete='off' title='Indique los datos del cliente (Existente)'>
					<option></option>";
		$i=0;
		if($datos['CEDULA_RIF'][$i]==""){
			echo "<option disabled>NO EXISTEN USUARIOS REGISTRADOS</option>";
		}else{
			while($datos['CEDULA_RIF'][$i]){
				echo "<option value='" . $datos['CEDULA_RIF'][$i] . "'>" . $datos['NOMBRE'][$i] . " " . $datos['APELLIDO'][$i] . "</option>";
				$i++;
			}
		}
		echo "</select>
			</div>";
	}
}
?>