<?php 
//ESTA SUB RUTINA IMPRIME LOS DATOS DE CANTIDAD DE DOLLARES O BOLIVARES DISPONIBLES PARA REALIZAR OPERACIONES DE COMPRA Y VENTA DE DOLLARES TANTO PARA LOS INGRESOS DE LA EMPRESA COMO PARA EL RESPALDO DE LA MONEDA VIRTUAL
if(isset($_POST['tipo_operacion'])){
	require_once ("M_todos.php");
	$tipo_operacion=$_POST['tipo_operacion'];
	$datos_ultimo_balance=M_balance_administrativo_lcv_R_ultimo($conexion);
	if($tipo_operacion=="COMPRA DOLLAR RESPALDO"){
		echo "
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Dollares:</span>
				</div>
				<input type='number' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='dollares' id='dollares' placeholder='Cantidad de dollares' required autocomplete='off' title='Introduzca la cantidad de dollares de la operación' step='0.01' min='0.01'>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Bolivares:</span>
				</div>
				<input type='number' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='bolivares' id='bolivares' placeholder='máximo: " . number_format($datos_ultimo_balance['RA_RES_MON_BS_PUROS'][0], 2,',','.') . "' required autocomplete='off' title='Introduzca la cantidad de bolívares de la operación' step='0.01' min='0.01' max='" . $datos_ultimo_balance['RA_RES_MON_BS_PUROS'][0] . "'>
			</div>
			<div class='input-group mb-2'>
				<span class='input-group-text rounded-0 w-100'>Descripción:</span>
				<textarea class='form-control p-0 m-0 px-2 rounded-0' name='descripcion' id='descripcion' placeholder='Introduzca una descripción (Opcional)' autocomplete='off' title='Introduzca una descripción (Opcional)' rows='2'></textarea>
			</div>
			<div class='input-group mb-2'>
				<span class='input-group-text rounded-0 w-100'>Observaciones:</span>
				<textarea class='form-control p-0 m-0 px-2 rounded-0' name='observacion' id='observacion' placeholder='Introduzca sus observaciones (Opcional)' autocomplete='off' title='Introduzca sus observaciones (Opcional)' rows='2'></textarea>
			</div>
		";
	}else if($tipo_operacion=="VENTA DOLLAR RESPALDO"){
		echo "
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Dollares:</span>
				</div>
				<input type='number' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='dollares' id='dollares' placeholder='máximo: " . number_format($datos_ultimo_balance['RA_RES_MON_DOLLARES_PUROS'][0], 2,',','.') . "' required autocomplete='off' title='Introduzca la cantidad de dollares de la operación' step='0.01' min='0.01' max='" . $datos_ultimo_balance['RA_RES_MON_DOLLARES_PUROS'][0] . "'>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Bolivares:</span>
				</div>
				<input type='number' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='bolivares' id='bolivares' placeholder='Cantidad de bolívares' required autocomplete='off' title='Introduzca la cantidad de bolívares de la operación' step='0.01' min='0.01'>
			</div>
			<div class='input-group mb-2'>
				<span class='input-group-text rounded-0 w-100'>Descripción:</span>
				<textarea class='form-control p-0 m-0 px-2 rounded-0' name='descripcion' id='descripcion' placeholder='Introduzca una descripción (Opcional)' autocomplete='off' title='Introduzca una descripción (Opcional)' rows='2'></textarea>
			</div>
			<div class='input-group mb-2'>
				<span class='input-group-text rounded-0 w-100'>Observaciones:</span>
				<textarea class='form-control p-0 m-0 px-2 rounded-0' name='observacion' id='observacion' placeholder='Introduzca sus observaciones (Opcional)' autocomplete='off' title='Introduzca sus observaciones (Opcional)' rows='2'></textarea>
			</div>
		";
	}else if($tipo_operacion=="COMPRA DOLLAR INGRESOS"){
		echo "
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Dollares:</span>
				</div>
				<input type='number' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='dollares' id='dollares' placeholder='Cantidad de dollares' required autocomplete='off' title='Introduzca la cantidad de dollares de la operación' step='0.01' min='0'>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Bolivares:</span>
				</div>
				<input type='number' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='bolivares' id='bolivares' placeholder='máximo: " . number_format($datos_ultimo_balance['RA_IE_BS_PUROS'][0], 2,',','.') . "' required autocomplete='off' title='Introduzca la cantidad de bolívares de la operación' step='0.01' min='0' max='" . $datos_ultimo_balance['RA_IE_BS_PUROS'][0] . "'>
			</div>
			<div class='input-group mb-2'>
				<span class='input-group-text rounded-0 w-100'>Descripción:</span>
				<textarea class='form-control p-0 m-0 px-2 rounded-0' name='descripcion' id='descripcion' placeholder='Introduzca una descripción (Opcional)' autocomplete='off' title='Introduzca una descripción (Opcional)' rows='2'></textarea>
			</div>
			<div class='input-group mb-2'>
				<span class='input-group-text rounded-0 w-100'>Observaciones:</span>
				<textarea class='form-control p-0 m-0 px-2 rounded-0' name='observacion' id='observacion' placeholder='Introduzca sus observaciones (Opcional)' autocomplete='off' title='Introduzca sus observaciones (Opcional)' rows='2'></textarea>
			</div>
		";
	}else if($tipo_operacion=="VENTA DOLLAR INGRESOS"){
		echo "
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Dollares:</span>
				</div>
				<input type='number' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='dollares' id='dollares' placeholder='máximo: " . number_format($datos_ultimo_balance['RA_IE_DOLLARES_PUROS'][0], 2,',','.') . "' required autocomplete='off' title='Introduzca la cantidad de dollares de la operación' step='0.01' min='0' max='" . $datos_ultimo_balance['RA_IE_DOLLARES_PUROS'][0] . "'>
			</div>
			<div class='input-group mb-2'>
				<div class='col-md-3 p-0 m-0'>
					<span class='input-group-text rounded-0 w-100'>Bolivares:</span>
				</div>
				<input type='number' class='form-control col-md-9 p-0 m-0 px-2 rounded-0' name='bolivares' id='bolivares' placeholder='Cantidad de bolívares' required autocomplete='off' title='Introduzca la cantidad de bolívares de la operación' step='0.01' min='0'>
			</div>
			<div class='input-group mb-2'>
				<span class='input-group-text rounded-0 w-100'>Descripción:</span>
				<textarea class='form-control p-0 m-0 px-2 rounded-0' name='descripcion' id='descripcion' placeholder='Introduzca una descripción (Opcional)' autocomplete='off' title='Introduzca una descripción (Opcional)' rows='2'></textarea>
			</div>
			<div class='input-group mb-2'>
				<span class='input-group-text rounded-0 w-100'>Observaciones:</span>
				<textarea class='form-control p-0 m-0 px-2 rounded-0' name='observacion' id='observacion' placeholder='Introduzca sus observaciones (Opcional)' autocomplete='off' title='Introduzca sus observaciones (Opcional)' rows='2'></textarea>
			</div>
		";
	}
}
?>