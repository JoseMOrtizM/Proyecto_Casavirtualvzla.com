<?php 
//ESTA FUNCIÓN DEVUELVE UN ARRAY CON LOS DATOS DE LAS CUENTAS DE BANCO DISPONIBLES PARA REALIZAR OPERACIONES DE COMPRA DE MONEDA VIRTUAL
function M_datos_bancos_tranferencia(){
	$i=0;
	$bancos[$i]['NOMBRE']='Banco de Venezuela S.A.C.A. Banco Universal';
	$bancos[$i]['NUMERO_CUENTA']='01020616270000290726';
	$bancos[$i]['TIPO_CUENTA']='CUENTA CORRIENTE';
	$bancos[$i]['CEDULA']='J-500028016';
	$bancos[$i]['USUARIO']='JJ EVOLUCION C.A.';
	$bancos[$i]['TELEFONO']='0414-8609152';
	$bancos[$i]['CORREO']='covajrcm@gmail.com';
	$bancos[$i]['LINK']='http://www.bancodevenezuela.com/';
	$bancos[$i]['FOTO']='img/banco_venezuela.png';
	$bancos[$i]['OBSERVACION']='Sólo Depósitos y Transferencias';
	/*
	$i++;
	$bancos[$i]['NOMBRE']='Banco Activo, Banco Universal';
	$bancos[$i]['NUMERO_CUENTA']='01710017306002386521';
	$bancos[$i]['TIPO_CUENTA']='CUENTA CORRIENTE';
	$bancos[$i]['CEDULA']='10.946.827';
	$bancos[$i]['USUARIO']='JIMMY COVA';
	$bancos[$i]['TELEFONO']='0414-8609152';
	$bancos[$i]['CORREO']='covajrcm@gmail.com';
	$bancos[$i]['LINK']='http://www.bancoactivo.com/';
	$bancos[$i]['FOTO']='img/banco_activo.png';
	$bancos[$i]['OBSERVACION']='Sólo Depósitos y Transferencias';
	$i++;
	$bancos[$i]['NOMBRE']='Banco de Venezuela S.A.C.A. Banco Universal';
	$bancos[$i]['NUMERO_CUENTA']='01020653760100003223';
	$bancos[$i]['TIPO_CUENTA']='CUENTA DE AHORRO';
	$bancos[$i]['CEDULA']='10.946.827';
	$bancos[$i]['USUARIO']='JIMMY COVA';
	$bancos[$i]['TELEFONO']='0414-8609152';
	$bancos[$i]['CORREO']='covajrcm@gmail.com';
	$bancos[$i]['LINK']='http://www.bancodevenezuela.com/';
	$bancos[$i]['FOTO']='img/banco_venezuela.png';
	$bancos[$i]['OBSERVACION']='Sólo Depósitos y Transferencias';
	$i++;
	$bancos[$i]['NOMBRE']='Banco Provincial, S.A. Banco Universal';
	$bancos[$i]['NUMERO_CUENTA']='01080153200100117145';
	$bancos[$i]['TIPO_CUENTA']='CUENTA CORRIENTE';
	$bancos[$i]['CEDULA']='10.946.827';
	$bancos[$i]['USUARIO']='JIMMY COVA';
	$bancos[$i]['TELEFONO']='0414-8609152';
	$bancos[$i]['CORREO']='covajrcm@gmail.com';
	$bancos[$i]['LINK']='https://www.provincial.com/';
	$bancos[$i]['FOTO']='img/banco_provincial.png';
	$bancos[$i]['OBSERVACION']='Sólo Depósitos y Transferencias';
	$i++;
	$bancos[$i]['NOMBRE']='Banco Mercantil, C.A. Banco Universal';
	$bancos[$i]['NUMERO_CUENTA']='0105-xxxxxxxxxxxxxxxx';
	$bancos[$i]['TIPO_CUENTA']='CUENTA CORRIENTE';
	$bancos[$i]['CEDULA']='15.117.259';
	$bancos[$i]['USUARIO']='JOSE ORTIZ';
	$bancos[$i]['TELEFONO']='0412-4641122';
	$bancos[$i]['CORREO']='josemortizm@gmail.com';
	$bancos[$i]['LINK']='https://www.mercantilbanco.com/mercprod/index.html';
	$bancos[$i]['FOTO']='img/banco_mercantil.png';
	$bancos[$i]['OBSERVACION']='Sólo Depósitos y Transferencias';
	*/
	return $bancos;
}
?>