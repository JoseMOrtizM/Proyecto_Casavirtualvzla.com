<?php 
function M_balance_administrativo_lcv_C($conexion, $fh_registro, $descripcion, $dgo_tipo_de_operacion, $dgo_comision, $dgo_pm, $dgo_bs, $dgo_dollar, $pre_co_bs_dep_ret, $pre_co_gan_pm_eqv, $pre_co_gan_dollar_eqv, $pre_co_gan_bs_eqv, $pre_co_pm_al_respaldo, $pre_co_dollar_al_respaldo, $pre_co_bs_al_respaldo, $tc_bs_dollar, $tc_pm_dollar, $tc_bs_pm_c, $tc_bs_pm_v, $rp_ie_bs_puros, $rp_ie_dollar_puros, $rp_res_mon_circ, $rp_res_mon_bs_puros, $rp_res_mon_dollar_puros, $ra_ie_bs_puros, $ra_ie_dollares_puros, $ra_ie_dollare_eqv, $ra_res_mon_circ, $ra_res_mon_bs_puros, $ra_res_mon_dollares_puros, $ra_res_mon_dollares_eqv){//CREA VERIFICANDO DUPLICADOS
	$consulta="SELECT * FROM `mc_balance_administrativo_lcv` WHERE `DESCRIPCION`='$descripcion' AND `DGO_TIPO_DE_OPERACION`='$dgo_tipo_de_operacion' AND `DGO_PM`='$dgo_pm' AND `DGO_BS`='$dgo_bs' AND `FH_REGISTRO`='$fh_registro'";
	$resultado=mysqli_query($conexion,$consulta);
	if(($fila=mysqli_fetch_array($resultado))==true){
		return false;
	}else{
		$fh_registro=$fh_registro==''?'00-00-00 00:00:00':$fh_registro;
		$consulta="INSERT INTO `mc_balance_administrativo_lcv` (`FH_REGISTRO`, `DESCRIPCION`, `DGO_TIPO_DE_OPERACION`, `DGO_COMISION`, `DGO_PM`, `DGO_BS`, `DGO_DOLLAR`, `PRE_CO_BS_DEP_RET`, `PRE_CO_GAN_PM_EQV`, `PRE_CO_GAN_DOLLAR_EQV`, `PRE_CO_GAN_BS_EQV`, `PRE_CO_PM_AL_RESPALDO`, `PRE_CO_DOLLAR_AL_RESPALDO`, `PRE_CO_BS_AL_RESPALDO`, `TC_BS_DOLLAR`, `TC_PM_DOLLAR`, `TC_BS_PM_C`, `TC_BS_PM_V`, `RP_IE_BS_PUROS`, `RP_IE_DOLLAR_PUROS`, `RP_RES_MON_CIRC`, `RP_RES_MON_BS_PUROS`, `RP_RES_MON_DOLLAR_PUROS`, `RA_IE_BS_PUROS`, `RA_IE_DOLLARES_PUROS`, `RA_IE_DOLLARES_EQV`, `RA_RES_MON_CIRC`, `RA_RES_MON_BS_PUROS`, `RA_RES_MON_DOLLARES_PUROS`, `RA_RES_MON_DOLLARES_EQV`) VALUES ('$fh_registro','$descripcion','$dgo_tipo_de_operacion','$dgo_comision', '$dgo_pm', '$dgo_bs', '$dgo_dollar', '$pre_co_bs_dep_ret', '$pre_co_gan_pm_eqv', '$pre_co_gan_dollar_eqv', '$pre_co_gan_bs_eqv', '$pre_co_pm_al_respaldo', '$pre_co_dollar_al_respaldo', '$pre_co_bs_al_respaldo', '$tc_bs_dollar', '$tc_pm_dollar', '$tc_bs_pm_c', '$tc_bs_pm_v', '$rp_ie_bs_puros', '$rp_ie_dollar_puros', '$rp_res_mon_circ', '$rp_res_mon_bs_puros', '$rp_res_mon_dollar_puros', '$ra_ie_bs_puros', '$ra_ie_dollares_puros', '$ra_ie_dollare_eqv', '$ra_res_mon_circ', '$ra_res_mon_bs_puros', '$ra_res_mon_dollares_puros', '$ra_res_mon_dollares_eqv')";
		$resultados=mysqli_query($conexion,$consulta);
		return true;
	}
}
function M_balance_administrativo_lcv_pdf($conexion, $ano){
	//ESTA FUNCION PERMITE LEER LOS DATOS PÁRA EL BALANCE PDF DADO UN AÑO ESPECÍFICO'
	$consulta="SELECT * FROM `mc_balance_administrativo_lcv` WHERE YEAR(`FH_REGISTRO`)='$ano' ORDER BY `ID_ADM`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_ADM'][$i]='';
	$datos['FH_REGISTRO'][$i]='';
	$datos['DESCRIPCION'][$i]='';
	$datos['DGO_TIPO_DE_OPERACION'][$i]='';
	$datos['DGO_COMISION'][$i]='';
	$datos['DGO_PM'][$i]='';
	$datos['DGO_BS'][$i]='';
	$datos['DGO_DOLLAR'][$i]='';
	$datos['PRE_CO_BS_DEP_RET'][$i]='';
	$datos['PRE_CO_GAN_PM_EQV'][$i]='';
	$datos['PRE_CO_GAN_DOLLAR_EQV'][$i]='';
	$datos['PRE_CO_GAN_BS_EQV'][$i]='';
	$datos['PRE_CO_PM_AL_RESPALDO'][$i]='';
	$datos['PRE_CO_DOLLAR_AL_RESPALDO'][$i]='';
	$datos['PRE_CO_BS_AL_RESPALDO'][$i]='';
	$datos['TC_BS_DOLLAR'][$i]='';
	$datos['TC_PM_DOLLAR'][$i]='';
	$datos['TC_BS_PM_C'][$i]='';
	$datos['TC_BS_PM_V'][$i]='';
	$datos['RP_IE_BS_PUROS'][$i]='';
	$datos['RP_IE_DOLLAR_PUROS'][$i]='';
	$datos['RP_RES_MON_CIRC'][$i]='';
	$datos['RP_RES_MON_BS_PUROS'][$i]='';
	$datos['RP_RES_MON_DOLLAR_PUROS'][$i]='';
	$datos['RA_IE_BS_PUROS'][$i]='';
	$datos['RA_IE_DOLLARES_PUROS'][$i]='';
	$datos['RA_IE_DOLLARES_EQV'][$i]='';
	$datos['RA_RES_MON_CIRC'][$i]='';
	$datos['RA_RES_MON_BS_PUROS'][$i]='';
	$datos['RA_RES_MON_DOLLARES_PUROS'][$i]='';
	$datos['RA_RES_MON_DOLLARES_EQV'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_ADM'][$i]=$fila['ID_ADM'];
		$datos['FH_REGISTRO'][$i]=$fila['FH_REGISTRO'];
		$datos['DESCRIPCION'][$i]=$fila['DESCRIPCION'];
		$datos['DGO_TIPO_DE_OPERACION'][$i]=$fila['DGO_TIPO_DE_OPERACION'];
		$datos['DGO_COMISION'][$i]=$fila['DGO_COMISION'];
		$datos['DGO_PM'][$i]=$fila['DGO_PM'];
		$datos['DGO_BS'][$i]=$fila['DGO_BS'];
		$datos['DGO_DOLLAR'][$i]=$fila['DGO_DOLLAR'];
		$datos['PRE_CO_BS_DEP_RET'][$i]=$fila['PRE_CO_BS_DEP_RET'];
		$datos['PRE_CO_GAN_PM_EQV'][$i]=$fila['PRE_CO_GAN_PM_EQV'];
		$datos['PRE_CO_GAN_DOLLAR_EQV'][$i]=$fila['PRE_CO_GAN_DOLLAR_EQV'];
		$datos['PRE_CO_GAN_BS_EQV'][$i]=$fila['PRE_CO_GAN_BS_EQV'];
		$datos['PRE_CO_PM_AL_RESPALDO'][$i]=$fila['PRE_CO_PM_AL_RESPALDO'];
		$datos['PRE_CO_DOLLAR_AL_RESPALDO'][$i]=$fila['PRE_CO_DOLLAR_AL_RESPALDO'];
		$datos['PRE_CO_BS_AL_RESPALDO'][$i]=$fila['PRE_CO_BS_AL_RESPALDO'];
		$datos['TC_BS_DOLLAR'][$i]=$fila['TC_BS_DOLLAR'];
		$datos['TC_PM_DOLLAR'][$i]=$fila['TC_PM_DOLLAR'];
		$datos['TC_BS_PM_C'][$i]=$fila['TC_BS_PM_C'];
		$datos['TC_BS_PM_V'][$i]=$fila['TC_BS_PM_V'];
		$datos['RP_IE_BS_PUROS'][$i]=$fila['RP_IE_BS_PUROS'];
		$datos['RP_IE_DOLLAR_PUROS'][$i]=$fila['RP_IE_DOLLAR_PUROS'];
		$datos['RP_RES_MON_CIRC'][$i]=$fila['RP_RES_MON_CIRC'];
		$datos['RP_RES_MON_BS_PUROS'][$i]=$fila['RP_RES_MON_BS_PUROS'];
		$datos['RP_RES_MON_DOLLAR_PUROS'][$i]=$fila['RP_RES_MON_DOLLAR_PUROS'];
		$datos['RA_IE_BS_PUROS'][$i]=$fila['RA_IE_BS_PUROS'];
		$datos['RA_IE_DOLLARES_PUROS'][$i]=$fila['RA_IE_DOLLARES_PUROS'];
		$datos['RA_IE_DOLLARES_EQV'][$i]=$fila['RA_IE_DOLLARES_EQV'];
		$datos['RA_RES_MON_CIRC'][$i]=$fila['RA_RES_MON_CIRC'];
		$datos['RA_RES_MON_BS_PUROS'][$i]=$fila['RA_RES_MON_BS_PUROS'];
		$datos['RA_RES_MON_DOLLARES_PUROS'][$i]=$fila['RA_RES_MON_DOLLARES_PUROS'];
		$datos['RA_RES_MON_DOLLARES_EQV'][$i]=$fila['RA_RES_MON_DOLLARES_EQV'];
		$i=$i+1;
	}
	return $datos;
}
function M_balance_administrativo_lcv_R($conexion, $f_1, $d_1, $f_2, $d_2, $f_3, $d_3){
	//ESTA FUNCION PERMITE LEER HASTA CON 3 FILTROS EJEMPLO: $f_1='NOMBRE DE LA COLUMNA' $d_1='DATO'
	$sql_f_1=($f_1=="" and $d_1=="") ? "" : "AND `mc_balance_administrativo_lcv`.`$f_1`='$d_1'";
	$sql_f_2=($f_2=="" and $d_2=="") ? "" : "AND `mc_balance_administrativo_lcv`.`$f_2`='$d_2'";
	$sql_f_3=($f_3=="" and $d_3=="") ? "" : "AND `mc_balance_administrativo_lcv`.`$f_3`='$d_3'";
	$consulta="SELECT * FROM `mc_balance_administrativo_lcv` WHERE 1 $sql_f_1 $sql_f_2 $sql_f_3 ORDER BY `ID_ADM` DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_ADM'][$i]='';
	$datos['FH_REGISTRO'][$i]='';
	$datos['DESCRIPCION'][$i]='';
	$datos['DGO_TIPO_DE_OPERACION'][$i]='';
	$datos['DGO_COMISION'][$i]='';
	$datos['DGO_PM'][$i]='';
	$datos['DGO_BS'][$i]='';
	$datos['DGO_DOLLAR'][$i]='';
	$datos['PRE_CO_BS_DEP_RET'][$i]='';
	$datos['PRE_CO_GAN_PM_EQV'][$i]='';
	$datos['PRE_CO_GAN_DOLLAR_EQV'][$i]='';
	$datos['PRE_CO_GAN_BS_EQV'][$i]='';
	$datos['PRE_CO_PM_AL_RESPALDO'][$i]='';
	$datos['PRE_CO_DOLLAR_AL_RESPALDO'][$i]='';
	$datos['PRE_CO_BS_AL_RESPALDO'][$i]='';
	$datos['TC_BS_DOLLAR'][$i]='';
	$datos['TC_PM_DOLLAR'][$i]='';
	$datos['TC_BS_PM_C'][$i]='';
	$datos['TC_BS_PM_V'][$i]='';
	$datos['RP_IE_BS_PUROS'][$i]='';
	$datos['RP_IE_DOLLAR_PUROS'][$i]='';
	$datos['RP_RES_MON_CIRC'][$i]='';
	$datos['RP_RES_MON_BS_PUROS'][$i]='';
	$datos['RP_RES_MON_DOLLAR_PUROS'][$i]='';
	$datos['RA_IE_BS_PUROS'][$i]='';
	$datos['RA_IE_DOLLARES_PUROS'][$i]='';
	$datos['RA_IE_DOLLARES_EQV'][$i]='';
	$datos['RA_RES_MON_CIRC'][$i]='';
	$datos['RA_RES_MON_BS_PUROS'][$i]='';
	$datos['RA_RES_MON_DOLLARES_PUROS'][$i]='';
	$datos['RA_RES_MON_DOLLARES_EQV'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_ADM'][$i]=$fila['ID_ADM'];
		$datos['FH_REGISTRO'][$i]=$fila['FH_REGISTRO'];
		$datos['DESCRIPCION'][$i]=$fila['DESCRIPCION'];
		$datos['DGO_TIPO_DE_OPERACION'][$i]=$fila['DGO_TIPO_DE_OPERACION'];
		$datos['DGO_COMISION'][$i]=$fila['DGO_COMISION'];
		$datos['DGO_PM'][$i]=$fila['DGO_PM'];
		$datos['DGO_BS'][$i]=$fila['DGO_BS'];
		$datos['DGO_DOLLAR'][$i]=$fila['DGO_DOLLAR'];
		$datos['PRE_CO_BS_DEP_RET'][$i]=$fila['PRE_CO_BS_DEP_RET'];
		$datos['PRE_CO_GAN_PM_EQV'][$i]=$fila['PRE_CO_GAN_PM_EQV'];
		$datos['PRE_CO_GAN_DOLLAR_EQV'][$i]=$fila['PRE_CO_GAN_DOLLAR_EQV'];
		$datos['PRE_CO_GAN_BS_EQV'][$i]=$fila['PRE_CO_GAN_BS_EQV'];
		$datos['PRE_CO_PM_AL_RESPALDO'][$i]=$fila['PRE_CO_PM_AL_RESPALDO'];
		$datos['PRE_CO_DOLLAR_AL_RESPALDO'][$i]=$fila['PRE_CO_DOLLAR_AL_RESPALDO'];
		$datos['PRE_CO_BS_AL_RESPALDO'][$i]=$fila['PRE_CO_BS_AL_RESPALDO'];
		$datos['TC_BS_DOLLAR'][$i]=$fila['TC_BS_DOLLAR'];
		$datos['TC_PM_DOLLAR'][$i]=$fila['TC_PM_DOLLAR'];
		$datos['TC_BS_PM_C'][$i]=$fila['TC_BS_PM_C'];
		$datos['TC_BS_PM_V'][$i]=$fila['TC_BS_PM_V'];
		$datos['RP_IE_BS_PUROS'][$i]=$fila['RP_IE_BS_PUROS'];
		$datos['RP_IE_DOLLAR_PUROS'][$i]=$fila['RP_IE_DOLLAR_PUROS'];
		$datos['RP_RES_MON_CIRC'][$i]=$fila['RP_RES_MON_CIRC'];
		$datos['RP_RES_MON_BS_PUROS'][$i]=$fila['RP_RES_MON_BS_PUROS'];
		$datos['RP_RES_MON_DOLLAR_PUROS'][$i]=$fila['RP_RES_MON_DOLLAR_PUROS'];
		$datos['RA_IE_BS_PUROS'][$i]=$fila['RA_IE_BS_PUROS'];
		$datos['RA_IE_DOLLARES_PUROS'][$i]=$fila['RA_IE_DOLLARES_PUROS'];
		$datos['RA_IE_DOLLARES_EQV'][$i]=$fila['RA_IE_DOLLARES_EQV'];
		$datos['RA_RES_MON_CIRC'][$i]=$fila['RA_RES_MON_CIRC'];
		$datos['RA_RES_MON_BS_PUROS'][$i]=$fila['RA_RES_MON_BS_PUROS'];
		$datos['RA_RES_MON_DOLLARES_PUROS'][$i]=$fila['RA_RES_MON_DOLLARES_PUROS'];
		$datos['RA_RES_MON_DOLLARES_EQV'][$i]=$fila['RA_RES_MON_DOLLARES_EQV'];
		$i=$i+1;
	}
	return $datos;
}
function M_balance_administrativo_lcv_R_ano($conexion, $ano){
	$consulta="SELECT * FROM `mc_balance_administrativo_lcv` WHERE YEAR(`FH_REGISTRO`)='$ano' ORDER BY `ID_ADM`";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_ADM'][$i]='';
	$datos['FH_REGISTRO'][$i]='';
	$datos['DESCRIPCION'][$i]='';
	$datos['DGO_TIPO_DE_OPERACION'][$i]='';
	$datos['DGO_COMISION'][$i]='';
	$datos['DGO_PM'][$i]='';
	$datos['DGO_BS'][$i]='';
	$datos['DGO_DOLLAR'][$i]='';
	$datos['PRE_CO_BS_DEP_RET'][$i]='';
	$datos['PRE_CO_GAN_PM_EQV'][$i]='';
	$datos['PRE_CO_GAN_DOLLAR_EQV'][$i]='';
	$datos['PRE_CO_GAN_BS_EQV'][$i]='';
	$datos['PRE_CO_PM_AL_RESPALDO'][$i]='';
	$datos['PRE_CO_DOLLAR_AL_RESPALDO'][$i]='';
	$datos['PRE_CO_BS_AL_RESPALDO'][$i]='';
	$datos['TC_BS_DOLLAR'][$i]='';
	$datos['TC_PM_DOLLAR'][$i]='';
	$datos['TC_BS_PM_C'][$i]='';
	$datos['TC_BS_PM_V'][$i]='';
	$datos['RP_IE_BS_PUROS'][$i]='';
	$datos['RP_IE_DOLLAR_PUROS'][$i]='';
	$datos['RP_RES_MON_CIRC'][$i]='';
	$datos['RP_RES_MON_BS_PUROS'][$i]='';
	$datos['RP_RES_MON_DOLLAR_PUROS'][$i]='';
	$datos['RA_IE_BS_PUROS'][$i]='';
	$datos['RA_IE_DOLLARES_PUROS'][$i]='';
	$datos['RA_IE_DOLLARES_EQV'][$i]='';
	$datos['RA_RES_MON_CIRC'][$i]='';
	$datos['RA_RES_MON_BS_PUROS'][$i]='';
	$datos['RA_RES_MON_DOLLARES_PUROS'][$i]='';
	$datos['RA_RES_MON_DOLLARES_EQV'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_ADM'][$i]=$fila['ID_ADM'];
		$datos['FH_REGISTRO'][$i]=$fila['FH_REGISTRO'];
		$datos['DESCRIPCION'][$i]=$fila['DESCRIPCION'];
		$datos['DGO_TIPO_DE_OPERACION'][$i]=$fila['DGO_TIPO_DE_OPERACION'];
		$datos['DGO_COMISION'][$i]=$fila['DGO_COMISION'];
		$datos['DGO_PM'][$i]=$fila['DGO_PM'];
		$datos['DGO_BS'][$i]=$fila['DGO_BS'];
		$datos['DGO_DOLLAR'][$i]=$fila['DGO_DOLLAR'];
		$datos['PRE_CO_BS_DEP_RET'][$i]=$fila['PRE_CO_BS_DEP_RET'];
		$datos['PRE_CO_GAN_PM_EQV'][$i]=$fila['PRE_CO_GAN_PM_EQV'];
		$datos['PRE_CO_GAN_DOLLAR_EQV'][$i]=$fila['PRE_CO_GAN_DOLLAR_EQV'];
		$datos['PRE_CO_GAN_BS_EQV'][$i]=$fila['PRE_CO_GAN_BS_EQV'];
		$datos['PRE_CO_PM_AL_RESPALDO'][$i]=$fila['PRE_CO_PM_AL_RESPALDO'];
		$datos['PRE_CO_DOLLAR_AL_RESPALDO'][$i]=$fila['PRE_CO_DOLLAR_AL_RESPALDO'];
		$datos['PRE_CO_BS_AL_RESPALDO'][$i]=$fila['PRE_CO_BS_AL_RESPALDO'];
		$datos['TC_BS_DOLLAR'][$i]=$fila['TC_BS_DOLLAR'];
		$datos['TC_PM_DOLLAR'][$i]=$fila['TC_PM_DOLLAR'];
		$datos['TC_BS_PM_C'][$i]=$fila['TC_BS_PM_C'];
		$datos['TC_BS_PM_V'][$i]=$fila['TC_BS_PM_V'];
		$datos['RP_IE_BS_PUROS'][$i]=$fila['RP_IE_BS_PUROS'];
		$datos['RP_IE_DOLLAR_PUROS'][$i]=$fila['RP_IE_DOLLAR_PUROS'];
		$datos['RP_RES_MON_CIRC'][$i]=$fila['RP_RES_MON_CIRC'];
		$datos['RP_RES_MON_BS_PUROS'][$i]=$fila['RP_RES_MON_BS_PUROS'];
		$datos['RP_RES_MON_DOLLAR_PUROS'][$i]=$fila['RP_RES_MON_DOLLAR_PUROS'];
		$datos['RA_IE_BS_PUROS'][$i]=$fila['RA_IE_BS_PUROS'];
		$datos['RA_IE_DOLLARES_PUROS'][$i]=$fila['RA_IE_DOLLARES_PUROS'];
		$datos['RA_IE_DOLLARES_EQV'][$i]=$fila['RA_IE_DOLLARES_EQV'];
		$datos['RA_RES_MON_CIRC'][$i]=$fila['RA_RES_MON_CIRC'];
		$datos['RA_RES_MON_BS_PUROS'][$i]=$fila['RA_RES_MON_BS_PUROS'];
		$datos['RA_RES_MON_DOLLARES_PUROS'][$i]=$fila['RA_RES_MON_DOLLARES_PUROS'];
		$datos['RA_RES_MON_DOLLARES_EQV'][$i]=$fila['RA_RES_MON_DOLLARES_EQV'];
		$i=$i+1;
	}
	return $datos;
}
function M_balance_administrativo_lcv_R_ultimo($conexion){
	$consulta="SELECT * FROM `mc_balance_administrativo_lcv` WHERE `ID_ADM`=(SELECT MAX(`ID_ADM`) FROM `mc_balance_administrativo_lcv`)";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_ADM'][$i]='';
	$datos['FH_REGISTRO'][$i]='';
	$datos['DESCRIPCION'][$i]='';
	$datos['DGO_TIPO_DE_OPERACION'][$i]='';
	$datos['DGO_COMISION'][$i]='';
	$datos['DGO_PM'][$i]='';
	$datos['DGO_BS'][$i]='';
	$datos['DGO_DOLLAR'][$i]='';
	$datos['PRE_CO_BS_DEP_RET'][$i]='';
	$datos['PRE_CO_GAN_PM_EQV'][$i]='';
	$datos['PRE_CO_GAN_DOLLAR_EQV'][$i]='';
	$datos['PRE_CO_GAN_BS_EQV'][$i]='';
	$datos['PRE_CO_PM_AL_RESPALDO'][$i]='';
	$datos['PRE_CO_DOLLAR_AL_RESPALDO'][$i]='';
	$datos['PRE_CO_BS_AL_RESPALDO'][$i]='';
	$datos['TC_BS_DOLLAR'][$i]='';
	$datos['TC_PM_DOLLAR'][$i]='';
	$datos['TC_BS_PM_C'][$i]='';
	$datos['TC_BS_PM_V'][$i]='';
	$datos['RP_IE_BS_PUROS'][$i]='';
	$datos['RP_IE_DOLLAR_PUROS'][$i]='';
	$datos['RP_RES_MON_CIRC'][$i]='';
	$datos['RP_RES_MON_BS_PUROS'][$i]='';
	$datos['RP_RES_MON_DOLLAR_PUROS'][$i]='';
	$datos['RA_IE_BS_PUROS'][$i]='';
	$datos['RA_IE_DOLLARES_PUROS'][$i]='';
	$datos['RA_IE_DOLLARES_EQV'][$i]='';
	$datos['RA_RES_MON_CIRC'][$i]='';
	$datos['RA_RES_MON_BS_PUROS'][$i]='';
	$datos['RA_RES_MON_DOLLARES_PUROS'][$i]='';
	$datos['RA_RES_MON_DOLLARES_EQV'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_ADM'][$i]=$fila['ID_ADM'];
		$datos['FH_REGISTRO'][$i]=$fila['FH_REGISTRO'];
		$datos['DESCRIPCION'][$i]=$fila['DESCRIPCION'];
		$datos['DGO_TIPO_DE_OPERACION'][$i]=$fila['DGO_TIPO_DE_OPERACION'];
		$datos['DGO_COMISION'][$i]=$fila['DGO_COMISION'];
		$datos['DGO_PM'][$i]=$fila['DGO_PM'];
		$datos['DGO_BS'][$i]=$fila['DGO_BS'];
		$datos['DGO_DOLLAR'][$i]=$fila['DGO_DOLLAR'];
		$datos['PRE_CO_BS_DEP_RET'][$i]=$fila['PRE_CO_BS_DEP_RET'];
		$datos['PRE_CO_GAN_PM_EQV'][$i]=$fila['PRE_CO_GAN_PM_EQV'];
		$datos['PRE_CO_GAN_DOLLAR_EQV'][$i]=$fila['PRE_CO_GAN_DOLLAR_EQV'];
		$datos['PRE_CO_GAN_BS_EQV'][$i]=$fila['PRE_CO_GAN_BS_EQV'];
		$datos['PRE_CO_PM_AL_RESPALDO'][$i]=$fila['PRE_CO_PM_AL_RESPALDO'];
		$datos['PRE_CO_DOLLAR_AL_RESPALDO'][$i]=$fila['PRE_CO_DOLLAR_AL_RESPALDO'];
		$datos['PRE_CO_BS_AL_RESPALDO'][$i]=$fila['PRE_CO_BS_AL_RESPALDO'];
		$datos['TC_BS_DOLLAR'][$i]=$fila['TC_BS_DOLLAR'];
		$datos['TC_PM_DOLLAR'][$i]=$fila['TC_PM_DOLLAR'];
		$datos['TC_BS_PM_C'][$i]=$fila['TC_BS_PM_C'];
		$datos['TC_BS_PM_V'][$i]=$fila['TC_BS_PM_V'];
		$datos['RP_IE_BS_PUROS'][$i]=$fila['RP_IE_BS_PUROS'];
		$datos['RP_IE_DOLLAR_PUROS'][$i]=$fila['RP_IE_DOLLAR_PUROS'];
		$datos['RP_RES_MON_CIRC'][$i]=$fila['RP_RES_MON_CIRC'];
		$datos['RP_RES_MON_BS_PUROS'][$i]=$fila['RP_RES_MON_BS_PUROS'];
		$datos['RP_RES_MON_DOLLAR_PUROS'][$i]=$fila['RP_RES_MON_DOLLAR_PUROS'];
		$datos['RA_IE_BS_PUROS'][$i]=$fila['RA_IE_BS_PUROS'];
		$datos['RA_IE_DOLLARES_PUROS'][$i]=$fila['RA_IE_DOLLARES_PUROS'];
		$datos['RA_IE_DOLLARES_EQV'][$i]=$fila['RA_IE_DOLLARES_EQV'];
		$datos['RA_RES_MON_CIRC'][$i]=$fila['RA_RES_MON_CIRC'];
		$datos['RA_RES_MON_BS_PUROS'][$i]=$fila['RA_RES_MON_BS_PUROS'];
		$datos['RA_RES_MON_DOLLARES_PUROS'][$i]=$fila['RA_RES_MON_DOLLARES_PUROS'];
		$datos['RA_RES_MON_DOLLARES_EQV'][$i]=$fila['RA_RES_MON_DOLLARES_EQV'];
		$i=$i+1;
	}
	return $datos;
}
function M_balance_administrativo_lcv_R_ultimo_x_fecha($conexion, $fecha){
	$consulta="SELECT * FROM `mc_balance_administrativo_lcv` WHERE `FH_REGISTRO` LIKE '%" . $fecha . "%' ORDER BY `ID_ADM` DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_ADM'][$i]='';
	$datos['FH_REGISTRO'][$i]='';
	$datos['DESCRIPCION'][$i]='';
	$datos['DGO_TIPO_DE_OPERACION'][$i]='';
	$datos['DGO_COMISION'][$i]='';
	$datos['DGO_PM'][$i]='';
	$datos['DGO_BS'][$i]='';
	$datos['DGO_DOLLAR'][$i]='';
	$datos['PRE_CO_BS_DEP_RET'][$i]='';
	$datos['PRE_CO_GAN_PM_EQV'][$i]='';
	$datos['PRE_CO_GAN_DOLLAR_EQV'][$i]='';
	$datos['PRE_CO_GAN_BS_EQV'][$i]='';
	$datos['PRE_CO_PM_AL_RESPALDO'][$i]='';
	$datos['PRE_CO_DOLLAR_AL_RESPALDO'][$i]='';
	$datos['PRE_CO_BS_AL_RESPALDO'][$i]='';
	$datos['TC_BS_DOLLAR'][$i]='';
	$datos['TC_PM_DOLLAR'][$i]='';
	$datos['TC_BS_PM_C'][$i]='';
	$datos['TC_BS_PM_V'][$i]='';
	$datos['RP_IE_BS_PUROS'][$i]='';
	$datos['RP_IE_DOLLAR_PUROS'][$i]='';
	$datos['RP_RES_MON_CIRC'][$i]='';
	$datos['RP_RES_MON_BS_PUROS'][$i]='';
	$datos['RP_RES_MON_DOLLAR_PUROS'][$i]='';
	$datos['RA_IE_BS_PUROS'][$i]='';
	$datos['RA_IE_DOLLARES_PUROS'][$i]='';
	$datos['RA_IE_DOLLARES_EQV'][$i]='';
	$datos['RA_RES_MON_CIRC'][$i]='';
	$datos['RA_RES_MON_BS_PUROS'][$i]='';
	$datos['RA_RES_MON_DOLLARES_PUROS'][$i]='';
	$datos['RA_RES_MON_DOLLARES_EQV'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_ADM'][$i]=$fila['ID_ADM'];
		$datos['FH_REGISTRO'][$i]=$fila['FH_REGISTRO'];
		$datos['DESCRIPCION'][$i]=$fila['DESCRIPCION'];
		$datos['DGO_TIPO_DE_OPERACION'][$i]=$fila['DGO_TIPO_DE_OPERACION'];
		$datos['DGO_COMISION'][$i]=$fila['DGO_COMISION'];
		$datos['DGO_PM'][$i]=$fila['DGO_PM'];
		$datos['DGO_BS'][$i]=$fila['DGO_BS'];
		$datos['DGO_DOLLAR'][$i]=$fila['DGO_DOLLAR'];
		$datos['PRE_CO_BS_DEP_RET'][$i]=$fila['PRE_CO_BS_DEP_RET'];
		$datos['PRE_CO_GAN_PM_EQV'][$i]=$fila['PRE_CO_GAN_PM_EQV'];
		$datos['PRE_CO_GAN_DOLLAR_EQV'][$i]=$fila['PRE_CO_GAN_DOLLAR_EQV'];
		$datos['PRE_CO_GAN_BS_EQV'][$i]=$fila['PRE_CO_GAN_BS_EQV'];
		$datos['PRE_CO_PM_AL_RESPALDO'][$i]=$fila['PRE_CO_PM_AL_RESPALDO'];
		$datos['PRE_CO_DOLLAR_AL_RESPALDO'][$i]=$fila['PRE_CO_DOLLAR_AL_RESPALDO'];
		$datos['PRE_CO_BS_AL_RESPALDO'][$i]=$fila['PRE_CO_BS_AL_RESPALDO'];
		$datos['TC_BS_DOLLAR'][$i]=$fila['TC_BS_DOLLAR'];
		$datos['TC_PM_DOLLAR'][$i]=$fila['TC_PM_DOLLAR'];
		$datos['TC_BS_PM_C'][$i]=$fila['TC_BS_PM_C'];
		$datos['TC_BS_PM_V'][$i]=$fila['TC_BS_PM_V'];
		$datos['RP_IE_BS_PUROS'][$i]=$fila['RP_IE_BS_PUROS'];
		$datos['RP_IE_DOLLAR_PUROS'][$i]=$fila['RP_IE_DOLLAR_PUROS'];
		$datos['RP_RES_MON_CIRC'][$i]=$fila['RP_RES_MON_CIRC'];
		$datos['RP_RES_MON_BS_PUROS'][$i]=$fila['RP_RES_MON_BS_PUROS'];
		$datos['RP_RES_MON_DOLLAR_PUROS'][$i]=$fila['RP_RES_MON_DOLLAR_PUROS'];
		$datos['RA_IE_BS_PUROS'][$i]=$fila['RA_IE_BS_PUROS'];
		$datos['RA_IE_DOLLARES_PUROS'][$i]=$fila['RA_IE_DOLLARES_PUROS'];
		$datos['RA_IE_DOLLARES_EQV'][$i]=$fila['RA_IE_DOLLARES_EQV'];
		$datos['RA_RES_MON_CIRC'][$i]=$fila['RA_RES_MON_CIRC'];
		$datos['RA_RES_MON_BS_PUROS'][$i]=$fila['RA_RES_MON_BS_PUROS'];
		$datos['RA_RES_MON_DOLLARES_PUROS'][$i]=$fila['RA_RES_MON_DOLLARES_PUROS'];
		$datos['RA_RES_MON_DOLLARES_EQV'][$i]=$fila['RA_RES_MON_DOLLARES_EQV'];
		$i=$i+1;
	}
	return $datos;
}
function M_balance_administrativo_lcv_R_fecha_tipo_transaccion($conexion, $fecha, $tipo_transaccion){
	$fecha_ii=explode(" ",$fecha);
	$consulta="SELECT COUNT(`ID_ADM`) AS CANTIDAD_REGISTROS FROM `mc_balance_administrativo_lcv` WHERE  `DGO_TIPO_DE_OPERACION`='$tipo_transaccion' AND `FH_REGISTRO` LIKE '%" . $fecha_ii[0] . "%'";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['CANTIDAD_REGISTROS'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['CANTIDAD_REGISTROS'][$i]=$fila['CANTIDAD_REGISTROS'];
		$i=$i+1;
	}
	return $datos;
}
function M_balance_administrativo_lcv_agrupar_anos($conexion){
	$consulta="SELECT YEAR(`FH_REGISTRO`) AS ANO FROM `mc_balance_administrativo_lcv` WHERE YEAR(`FH_REGISTRO`) GROUP BY YEAR(`FH_REGISTRO`) ORDER BY YEAR(`FH_REGISTRO`) DESC";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos[$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos[$i]=$fila['ANO'];
		$i=$i+1;
	}
	return $datos;
}
function M_balance_administrativo_lcv_U_id($conexion, $id_adm, $fh_registro, $descripcion, $dgo_tipo_de_operacion, $dgo_comision, $dgo_pm, $dgo_bs, $dgo_dollar, $pre_co_bs_dep_ret, $pre_co_gan_pm_eqv, $pre_co_gan_dollar_eqv, $pre_co_gan_bs_eqv, $pre_co_pm_al_respaldo, $pre_co_dollar_al_respaldo, $pre_co_bs_al_respaldo, $tc_bs_dollar, $tc_pm_dollar, $tc_bs_pm_c, $tc_bs_pm_v, $rp_ie_bs_puros, $rp_ie_dollar_puros, $rp_res_mon_circ, $rp_res_mon_bs_puros, $rp_res_mon_dollar_puros, $ra_ie_bs_puros, $ra_ie_dollares_puros, $ra_ie_dollare_eqv, $ra_res_mon_circ, $ra_res_mon_bs_puros, $ra_res_mon_dollares_puros, $ra_res_mon_dollares_eqv){//MODIFICA TODOS LOS DATOS
	$fh_registro=$fh_registro==''?'00-00-00 00:00:00':$fh_registro;
	$consulta="UPDATE `mc_balance_administrativo_lcv` SET 
	`FH_REGISTRO`='$fh_registro', 
	`DESCRIPCION`='$descripcion', 
	`DGO_TIPO_DE_OPERACION`='$dgo_tipo_de_operacion', 
	`DGO_COMISION`='$dgo_comision', 
	`DGO_PM`='$dgo_pm', 
	`DGO_BS`='$dgo_bs', 
	`DGO_DOLLAR`='$dgo_dollar', 
	`PRE_CO_BS_DEP_RET`='$pre_co_bs_dep_ret', 
	`PRE_CO_GAN_PM_EQV`='$pre_co_gan_pm_eqv', 
	`PRE_CO_GAN_DOLLAR_EQV`='$pre_co_gan_dollar_eqv', 
	`PRE_CO_GAN_BS_EQV`='$pre_co_gan_bs_eqv', 
	`PRE_CO_PM_AL_RESPALDO`='$pre_co_pm_al_respaldo', 
	`PRE_CO_DOLLAR_AL_RESPALDO`='$pre_co_dollar_al_respaldo', 
	`PRE_CO_BS_AL_RESPALDO`='$pre_co_bs_al_respaldo', 
	`TC_BS_DOLLAR`='$tc_bs_dollar', 
	`TC_PM_DOLLAR`='$tc_pm_dollar', 
	`TC_BS_PM_C`='$tc_bs_pm_c', 
	`TC_BS_PM_V`='$tc_bs_pm_v', 
	`RP_IE_BS_PUROS`='$rp_ie_bs_puros', 
	`RP_IE_DOLLAR_PUROS`='$rp_ie_dollar_puros', 
	`RP_RES_MON_CIRC`='$rp_res_mon_circ', 
	`RP_RES_MON_BS_PUROS`='$rp_res_mon_bs_puros', 
	`RP_RES_MON_DOLLAR_PUROS`='$rp_res_mon_dollar_puros', 
	`RA_IE_BS_PUROS`='$ra_ie_bs_puros', 
	`RA_IE_DOLLARES_PUROS`='$ra_ie_dollares_puros', 
	`RA_IE_DOLLARES_EQV`='$ra_ie_dollares_eqv', 
	`RA_RES_MON_CIRC`='$ra_res_mon_circ', 
	`RA_RES_MON_BS_PUROS`='$ra_res_mon_bs_puros', 
	`RA_RES_MON_DOLLARES_PUROS`='$ra_res_mon_dollares_puros', 
	`RA_RES_MON_DOLLARES_EQV`='$ra_res_mon_dollares_eqv' 
	WHERE `ID_ADM`='$id_adm'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_balance_administrativo_lcv_D_id($conexion, $id_adm){//BORRA DADO EL ID
	$consulta="DELETE FROM `mc_balance_administrativo_lcv` WHERE `ID_CV_DOLLAR`='$id_adm'";
	$resultados=mysqli_query($conexion,$consulta);
	return true;
}
function M_balance_administrativo_lcv_PRECALCULOS($conexion, $fh_registro, $dgo_tipo_de_operacion, $dgo_bs, $dgo_dollar, $tc_bs_dollar, $descripcion_otros, $ID_REGISTRO){
	/* 
		LA FUNCIÓN SIGUIENTE REGISTRA TODAS LAS OPERACIONES QUE PEDEN ALTERAR EL VALOR DE LA MONEDA VIRTUAL:
		1- POR LO QUE LUEGO DE REALIZADOS LOS CALCULOS PERTINENTES LA FUNCIÓN REGISTRA VALORES EN LAS TABLAS MC_BALANCE_ADMINISTRATIVO Y MC_PARIDAD_CAMBIARIA.
		2- DEPENDIENDO DEL CASO, PREVIAMENTE EL SISTEMA DEBE REALIZAR LOS REGISTROS EN LAS TABLAS DE:
			- MC_COMPRA_VENTA_DE_MICOIN (PARA COMPRA O VENTA DE PEMÓN).
			- MC_CONTROL_DE_TRANSACCIONES_MICON (PARA COMPRA DE PRODUCTOS ENTRE USUARIOS).
			- MC_CONTROL_CAMBIO_DOLLAR_BOLIVAR (PARA CUANDO SE REALIZAN COMPRAS O VENTAS DE DOLLARES BIEN SEA PARA RESPALDAR A LA MONEDA VIRTUAL O PARA RESPALDAR LOS INGRESOS DE LA EMPRESA).
			- EL RESTO DE LAS OPERACIONES QUE ALTERAN EL VALOR DEL PEMON RESPECTO DEL DOLLAR NO SE REGISTRAN EN NINGUNA TABLA PREVIAMENTE. SOLO SE REGISTRAN EN LAS 2 TABLAS MENCIONANDAS EN EL PUNTO 1.
	*/
	
	//OJO $ID_REGISTRO SIRVE PARA SABER LOS DATOS DE LA TRANSACCIÓN EN CASO DE SER UNA COMPRA-VENTA DE PEMON O DE PRODUCTO, PARA EL RESTO DE LOS CASOS COLOCAR ""... 
	//LOS VALORES DE $dgo_bs, $dgo_dollar APLICAN SOLO PARA COMPRA-VENTA_DOLLARES, GASTO, PAGO DE IMPUESTO, REINVERSIÓN O REPARTO DE DIVIDENDOS PORQUE LOS DEMAS CASOS SE TRAEN ESTOS DATOS DESDE EL $ID_REGISTRO, PARA EL RESTO DE LOS CASOS COLOCAR ""... 
	//LA $tc_bs_dollar TIENE QUE VENIR COLOCADA SIEMPRE (CALCULADA DESDE PAGINAS EXTERNAS Y PREVIO AVISO EN PANTALLA DE CUAL SERÁ SU VALOR FINAL)... 
	//LA VARIABLE $descripcion_otros SIRVE PARA DESCRIBIR GASTO, PAGOS DE IMPUESTOS, REINVERSIONES Y REPARTO DE DIVIDENDOS (para el resto de los casos usar "")...
	//VALORES A CALCULAR:
	$descripcion="Descripción: ";
	$dgo_comision=0;
	$dgo_pm=0; 
	$dgo_bs=$dgo_bs==""?0:$dgo_bs;
	$dgo_dollar=$dgo_dollar==""?0:$dgo_dollar;
	$pre_co_bs_dep_ret=0;
	$pre_co_gan_pm_eqv=0;
	$pre_co_gan_dollar_eqv=0;
	$pre_co_gan_bs_eqv=0;
	$pre_co_pm_al_respaldo=0;
	$pre_co_dollar_al_respaldo=0;
	$pre_co_bs_al_respaldo=0;
	$tc_pm_dollar=0;
	$tc_bs_pm_c=0;
	$tc_bs_pm_v=0;
	$rp_ie_bs_puros=0;
	$rp_ie_dollar_puros=0;
	$rp_res_mon_circ=0;
	$rp_res_mon_bs_puros=0;
	$rp_res_mon_dollar_puros=0;
	$ra_ie_bs_puros=0;
	$ra_ie_dollares_puros=0;
	$ra_ie_dollare_eqv=0;
	$ra_res_mon_circ=0;
	$ra_res_mon_bs_puros=0;
	$ra_res_mon_dollares_puros=0;
	$ra_res_mon_dollares_eqv=0;
	//CONSIDERACIONES
	if($dgo_tipo_de_operacion=="COMPRA PM"){
		//CALCULANDO:
		$datos_transaccion=M_compra_venta_de_micoin_R($conexion, 'ID_COMPRA_VENTA', $ID_REGISTRO, '', '', '', '');
		$descripcion=$datos_transaccion['NOMBRE'][0] . " " . $datos_transaccion['APELLIDO'][0] . " CI/RIF: " . $datos_transaccion['CEDULA_RIF'][0] . " (" . $datos_transaccion['CANTIDAD_MICOIN'][0] . " Pm)";
		$dgo_comision=$datos_transaccion['PORC_COMISION'][0];
		$dgo_pm=$datos_transaccion['CANTIDAD_MICOIN'][0]; 
		$pre_co_bs_dep_ret=$datos_transaccion['MONTO_NETO'][0];
		$pre_co_gan_pm_eqv=0;
		$pre_co_gan_dollar_eqv=0;
		$pre_co_gan_bs_eqv=$datos_transaccion['MONTO_COMISION'][0];
		$pre_co_pm_al_respaldo=$dgo_pm;
		$pre_co_dollar_al_respaldo=0;
		$pre_co_bs_al_respaldo=$datos_transaccion['MONTO_BRUTO'][0];
	}else if($dgo_tipo_de_operacion=="VENTA PM"){
		//CALCULANDO:
		$datos_transaccion=M_compra_venta_de_micoin_R($conexion, 'ID_COMPRA_VENTA', $ID_REGISTRO, '', '', '', '');
		$descripcion=$datos_transaccion['NOMBRE'][0] . " " . $datos_transaccion['APELLIDO'][0] . " CI/RIF: " . $datos_transaccion['CEDULA_RIF'][0] . " (" . $datos_transaccion['CANTIDAD_MICOIN'][0] . " Pm)";
		$dgo_comision=$datos_transaccion['PORC_COMISION'][0];
		$dgo_pm=$datos_transaccion['CANTIDAD_MICOIN'][0]; 
		$pre_co_bs_dep_ret=$datos_transaccion['MONTO_NETO'][0];
		///  MODIFICAR LOS VALORES DE ABAJO PARA QUE SE AJUSTEN AUTOMÁTICAMENTE LOS PM/$  A 4,30 ///
		$datos_inicio_sistema=M_balance_administrativo_lcv_R($conexion, 'DESCRIPCION', 'INICIO DEL SISTEMA', '', '', '', '');
		$datos_ultimo_balance=M_balance_administrativo_lcv_R_ultimo($conexion);
		if($datos_inicio_sistema['TC_PM_DOLLAR'][0]<=$datos_ultimo_balance['TC_PM_DOLLAR'][0]){
			$pre_co_gan_pm_eqv=$dgo_pm*$dgo_comision/100;
			$pre_co_gan_dollar_eqv=0;
			$pre_co_gan_bs_eqv=$datos_transaccion['MONTO_COMISION'][0];
			$pre_co_pm_al_respaldo=-$dgo_pm;
			$pre_co_dollar_al_respaldo=0;
			$pre_co_bs_al_respaldo=-$datos_transaccion['MONTO_BRUTO'][0];
			$descripcion=$descripcion . " (IMPORTANTE: Se dejó la diferencia de C-V Pemón en el respaldo para esta transacción)";
		}else{
			//aqui QUITAMOS EL EXESO DE PLATA EN EL RESPALDO ----
			$pre_co_gan_pm_eqv=$dgo_pm*$dgo_comision/100;
			$pre_co_gan_dollar_eqv=0;
			$pre_co_gan_bs_eqv=$datos_transaccion['MONTO_COMISION'][0] + $datos_ultimo_balance['TC_BS_PM_C'][0]*$datos_transaccion['CANTIDAD_MICOIN'][0] - $datos_transaccion['MONTO_BRUTO'][0];
			$pre_co_pm_al_respaldo=-$dgo_pm;
			$pre_co_dollar_al_respaldo=0;
			$pre_co_bs_al_respaldo=-$datos_ultimo_balance['TC_BS_PM_C'][0]*$datos_transaccion['CANTIDAD_MICOIN'][0];
			$descripcion=$descripcion . " (IMPORTANTE: Se pasó la diferencia de C-V Pemón a los ingresos para esta transacción)";
		}
		//////////  ------------    /////////////
	}else if($dgo_tipo_de_operacion=="COMPRA PROD"){
		//CALCULANDO:
		//CUANDO SE REALIZA LA SUSTRCCIÓN DE BOLIVARES DESDE EL RESPLDO DE LA MONEDA HACIA LOS INGRESOS DE LA EMPRESA, Y NO HAY BOLIVARES SUFICIENTES EN EL RESPALDO EL VALOR DE BOLIVARES EN EL RESPALDO ERÁ NEGATIVO Y LO COMPENSAREMOS AL FINAL DEL DIA CON VENTA DE DOLARES DE SER NECESARIO
		$datos_transaccion=M_control_de_transacciones_compras_en_micoin_R($conexion, 'ID_TRANSACCION', $ID_REGISTRO, '', '', '', '');
		$descripcion=$datos_transaccion['COMPRADOR_NOMBRE'][0] . " " . $datos_transaccion['COMPRADOR_APELLIDO'][0] . " CI/RIF: " . $datos_transaccion['COMPRADOR_CEDULA_RIF'][0] . " compró " . $datos_transaccion['NOMBRE_PRODUCTO'][0] . " a " . $datos_transaccion['VENDEDOR_NOMBRE'][0] . " " . $datos_transaccion['VENDEDOR_APELLIDO'][0] . " CI/RIF: " . $datos_transaccion['VENDEDOR_CEDULA_RIF'][0] . " por " . $datos_transaccion['MONTO_BRUTO_MICOIN'][0] . " Pm (Comisión: " . $datos_transaccion['MONTO_COMISION'][0] . " Pm / Ingreso vendedor: " . $datos_transaccion['MONTO_NETO'][0] . " Pm).";
		$dgo_comision= (float) $datos_transaccion['PORC_COMISION'][0];
		$dgo_pm= (float) $datos_transaccion['MONTO_BRUTO_MICOIN'][0]; 
		$pre_co_bs_dep_ret=0;
		$pre_co_gan_pm_eqv=$dgo_pm*$dgo_comision/100;
		$pre_co_gan_dollar_eqv=0;
		$datos_ultima_paridad=M_paridad_cambiaria_R_ultima($conexion);
		$ultimo_bs_x_pm_compra=$datos_ultima_paridad['TIPO_POR_MICOIN_COMPRA'][0];
		$pre_co_gan_bs_eqv=$pre_co_gan_pm_eqv*$ultimo_bs_x_pm_compra;
		$pre_co_pm_al_respaldo=-$pre_co_gan_pm_eqv;
		$pre_co_dollar_al_respaldo=0;
		$pre_co_bs_al_respaldo=-$pre_co_gan_bs_eqv;
	}else if($dgo_tipo_de_operacion=="COMPRA DOLLAR RESPALDO"){
		$datos_transaccion=M_control_cambio_dollar_bolivar_R($conexion, 'ID_CV_DOLLAR', $ID_REGISTRO, '', '', '', '');
		$descripcion="Cliente: " . $datos_transaccion['NOMBRE'][0] . " " . $datos_transaccion['APELLIDO'][0] . " CI/RIF: " . $datos_transaccion['CEDULA_RIF'][0] . " (" . $datos_transaccion['DOLLARES'][0] . " $ - " . $datos_transaccion['BOLIVARES'][0] . " Bs)";
		$dgo_comision=0;
		$dgo_pm=0; 
		$pre_co_bs_dep_ret=$dgo_bs;
		$pre_co_gan_pm_eqv=0;
		$pre_co_gan_dollar_eqv=0;
		$pre_co_gan_bs_eqv=0;
		$pre_co_pm_al_respaldo=0;
		$pre_co_dollar_al_respaldo=$dgo_dollar;
		$pre_co_bs_al_respaldo=-$dgo_bs;
	}else if($dgo_tipo_de_operacion=="VENTA DOLLAR RESPALDO"){
		$datos_transaccion=M_control_cambio_dollar_bolivar_R($conexion, 'ID_CV_DOLLAR', $ID_REGISTRO, '', '', '', '');
		$descripcion="Cliente " . $datos_transaccion['NOMBRE'][0] . " " . $datos_transaccion['APELLIDO'][0] . " CI/RIF: " . $datos_transaccion['CEDULA_RIF'][0] . " (" . $datos_transaccion['DOLLARES'][0] . " $ - " . $datos_transaccion['BOLIVARES'][0] . " Bs)";
		$dgo_comision=0;
		$dgo_pm=0; 
		$pre_co_bs_dep_ret=$dgo_bs;
		$pre_co_gan_pm_eqv=0;
		$pre_co_gan_dollar_eqv=0;
		$pre_co_gan_bs_eqv=0;
		$pre_co_pm_al_respaldo=0;
		$pre_co_dollar_al_respaldo=-$dgo_dollar;
		$pre_co_bs_al_respaldo=$dgo_bs;
	}else if($dgo_tipo_de_operacion=="COMPRA DOLLAR INGRESOS"){
		$datos_transaccion=M_control_cambio_dollar_bolivar_R($conexion, 'ID_CV_DOLLAR', $ID_REGISTRO, '', '', '', '');
		$descripcion="Cliente " . $datos_transaccion['NOMBRE'][0] . " " . $datos_transaccion['APELLIDO'][0] . " CI/RIF: " . $datos_transaccion['CEDULA_RIF'][0] . " (" . $datos_transaccion['DOLLARES'][0] . " $ - " . $datos_transaccion['BOLIVARES'][0] . " Bs)";
		$dgo_comision=0;
		$dgo_pm=0; 
		$pre_co_bs_dep_ret=$dgo_bs;
		$pre_co_gan_pm_eqv=0;
		$pre_co_gan_dollar_eqv=$dgo_dollar;
		$pre_co_gan_bs_eqv=-$dgo_bs;
		$pre_co_pm_al_respaldo=0;
		$pre_co_dollar_al_respaldo=0;
		$pre_co_bs_al_respaldo=0;
	}else if($dgo_tipo_de_operacion=="VENTA DOLLAR INGRESOS"){
		$datos_transaccion=M_control_cambio_dollar_bolivar_R($conexion, 'ID_CV_DOLLAR', $ID_REGISTRO, '', '', '', '');
		$descripcion="Cliente " . $datos_transaccion['NOMBRE'][0] . " " . $datos_transaccion['APELLIDO'][0] . " CI/RIF: " . $datos_transaccion['CEDULA_RIF'][0] . " (" . $datos_transaccion['DOLLARES'][0] . " $ - " . $datos_transaccion['BOLIVARES'][0] . " Bs)";
		$dgo_comision=0;
		$dgo_pm=0; 
		$pre_co_bs_dep_ret=$dgo_bs;
		$pre_co_gan_pm_eqv=0;
		$pre_co_gan_dollar_eqv=-$dgo_dollar;
		$pre_co_gan_bs_eqv=$dgo_bs;
		$pre_co_pm_al_respaldo=0;
		$pre_co_dollar_al_respaldo=0;
		$pre_co_bs_al_respaldo=0;
	}else if($dgo_tipo_de_operacion=="GASTO"){
		$descripcion="Gasto por: " . $descripcion_otros;
		$dgo_comision=0;
		$dgo_pm=0; 
		$pre_co_bs_dep_ret=$dgo_bs;
		$pre_co_gan_pm_eqv=0;
		$pre_co_gan_dollar_eqv=-$dgo_dollar;
		$pre_co_gan_bs_eqv=-$dgo_bs;
		$pre_co_pm_al_respaldo=0;
		$pre_co_dollar_al_respaldo=0;
		$pre_co_bs_al_respaldo=0;
	}else if($dgo_tipo_de_operacion=="PAGO DE IMPUESTO"){
		$descripcion="Impuesto por: " . $descripcion_otros;
		$dgo_comision=0;
		$dgo_pm=0; 
		$pre_co_bs_dep_ret=$dgo_bs;
		$pre_co_gan_pm_eqv=0;
		$pre_co_gan_dollar_eqv=-$dgo_dollar;
		$pre_co_gan_bs_eqv=-$dgo_bs;
		$pre_co_pm_al_respaldo=0;
		$pre_co_dollar_al_respaldo=0;
		$pre_co_bs_al_respaldo=0;
	}else if($dgo_tipo_de_operacion=="REINVERSION"){
		$descripcion="Reinversión por: " . $descripcion_otros;
		$dgo_comision=0;
		$dgo_pm=0; 
		$pre_co_bs_dep_ret=$dgo_bs;
		$pre_co_gan_pm_eqv=0;
		$pre_co_gan_dollar_eqv=-$dgo_dollar;
		$pre_co_gan_bs_eqv=-$dgo_bs;
		$pre_co_pm_al_respaldo=0;
		$pre_co_dollar_al_respaldo=$dgo_dollar;
		$pre_co_bs_al_respaldo=$dgo_bs;
	}else if($dgo_tipo_de_operacion=="REPARTO DE DIVIDENDOS"){
		$descripcion="Reparto de Dividendos por: " . $descripcion_otros;
		$dgo_comision=0;
		$dgo_pm=0; 
		$pre_co_bs_dep_ret=$dgo_bs;
		$pre_co_gan_pm_eqv=0;
		$pre_co_gan_dollar_eqv=-$dgo_dollar;
		$pre_co_gan_bs_eqv=-$dgo_bs;
		$pre_co_pm_al_respaldo=0;
		$pre_co_dollar_al_respaldo=0;
		$pre_co_bs_al_respaldo=0;
	}else if($dgo_tipo_de_operacion=="ACTUALIZAR INVENTARIO"){
		$descripcion="Se Actualizó el inventario de produtos";
		$dgo_comision=0;
		$dgo_pm=0; 
		$pre_co_bs_dep_ret=0;
		$pre_co_gan_pm_eqv=0;
		$pre_co_gan_dollar_eqv=0;
		$pre_co_gan_bs_eqv=0;
		$pre_co_pm_al_respaldo=0;
		$pre_co_dollar_al_respaldo=0;
		$pre_co_bs_al_respaldo=0;
	}else if($dgo_tipo_de_operacion=="ACTUALIZAR RANKINGS"){
		$descripcion="Se Actualizaron los Rankings de usuarios";
		$dgo_comision=0;
		$dgo_pm=0; 
		$pre_co_bs_dep_ret=0;
		$pre_co_gan_pm_eqv=0;
		$pre_co_gan_dollar_eqv=0;
		$pre_co_gan_bs_eqv=0;
		$pre_co_pm_al_respaldo=0;
		$pre_co_dollar_al_respaldo=0;
		$pre_co_bs_al_respaldo=0;
	}else if($dgo_tipo_de_operacion=="RECHAZAR COMPRA PROD PREMIUN"){
		$datos_transaccion=M_control_de_transacciones_compras_en_micoin_R($conexion, 'ID_TRANSACCION', $ID_REGISTRO, '', '', '', '');
		$descripcion=$datos_transaccion['COMPRADOR_NOMBRE'][0] . " " . $datos_transaccion['COMPRADOR_APELLIDO'][0] . " CI/RIF: " . $datos_transaccion['COMPRADOR_CEDULA_RIF'][0] . " rechazó una compra PREMIUN de " . $datos_transaccion['NOMBRE_PRODUCTO'][0] . " a " . $datos_transaccion['VENDEDOR_NOMBRE'][0] . " " . $datos_transaccion['VENDEDOR_APELLIDO'][0] . " CI/RIF: " . $datos_transaccion['VENDEDOR_CEDULA_RIF'][0] . " por " . $datos_transaccion['MONTO_BRUTO_MICOIN'][0] . " Pm (Comisión: " . $datos_transaccion['MONTO_COMISION'][0] . " Pm).";
		$dgo_comision=$datos_transaccion['PORC_COMISION'][0];
		$dgo_pm=$datos_transaccion['MONTO_BRUTO_MICOIN'][0]; 
		$pre_co_bs_dep_ret=0;
		$pre_co_gan_pm_eqv=$dgo_pm*$dgo_comision/100;
		$pre_co_gan_dollar_eqv=0;
		$datos_ultima_paridad=M_paridad_cambiaria_R_ultima($conexion);
		$ultimo_bs_x_pm_compra=$datos_ultima_paridad['TIPO_POR_MICOIN_COMPRA'][0];
		$pre_co_gan_bs_eqv=$pre_co_gan_pm_eqv*$ultimo_bs_x_pm_compra;
		$pre_co_pm_al_respaldo=-$pre_co_gan_pm_eqv;
		$pre_co_dollar_al_respaldo=0;
		$pre_co_bs_al_respaldo=-$pre_co_gan_bs_eqv;
	}else{//LA OPCIÓN QUE QUEDA QUE ES if($dgo_tipo_de_operacion=="REGISTRO VALOR BS POR DOLLAR"):
		$descripcion="Se Actualizó la tasa de Bs/Dollar a: " . $tc_bs_dollar;
		$dgo_comision=0;
		$dgo_pm=0; 
		$pre_co_bs_dep_ret=0;
		$pre_co_gan_pm_eqv=0;
		$pre_co_gan_dollar_eqv=0;
		$pre_co_gan_bs_eqv=0;
		$pre_co_pm_al_respaldo=0;
		$pre_co_dollar_al_respaldo=0;
		$pre_co_bs_al_respaldo=0;
	}
	//ESTOS CALCULOS SON IGUALES EN TODOS LOS CASOS
	$rp_ie_bs_puros=$pre_co_gan_bs_eqv;
	$rp_ie_dollar_puros=$pre_co_gan_dollar_eqv;
	$rp_res_mon_circ=$pre_co_pm_al_respaldo;
	$rp_res_mon_bs_puros=$pre_co_bs_al_respaldo;
	$rp_res_mon_dollar_puros=$pre_co_dollar_al_respaldo;
	$datos_previos_balance=M_balance_administrativo_lcv_R_ultimo($conexion);
	$ra_ie_bs_puros=$datos_previos_balance['RA_IE_BS_PUROS'][0]+$rp_ie_bs_puros;
	$ra_ie_dollares_puros=$datos_previos_balance['RA_IE_DOLLARES_PUROS'][0]+$rp_ie_dollar_puros;
	if($tc_bs_dollar==0){
		$ra_ie_dollare_eqv=$ra_ie_dollares_puros;
	}else{
		$ra_ie_dollare_eqv=($ra_ie_bs_puros/$tc_bs_dollar)+$ra_ie_dollares_puros;
	}
	$ra_res_mon_circ=$datos_previos_balance['RA_RES_MON_CIRC'][0]+$rp_res_mon_circ;
	$ra_res_mon_bs_puros=$datos_previos_balance['RA_RES_MON_BS_PUROS'][0]+$rp_res_mon_bs_puros;
	$ra_res_mon_dollares_puros=$datos_previos_balance['RA_RES_MON_DOLLARES_PUROS'][0]+$rp_res_mon_dollar_puros;
	if($tc_bs_dollar==0){
		$ra_res_mon_dollares_eqv=$ra_res_mon_dollares_puros;
	}else{
		$ra_res_mon_dollares_eqv=($ra_res_mon_bs_puros/$tc_bs_dollar)+$ra_res_mon_dollares_puros;
	}
	if($ra_res_mon_dollares_eqv==0){
		$tc_pm_dollar=0;
	}else{
		$tc_pm_dollar=$ra_res_mon_circ/$ra_res_mon_dollares_eqv;
	}
	if($tc_pm_dollar==0){
		$tc_bs_pm_c=0;
	}else{
		$tc_bs_pm_c=$tc_bs_dollar/$tc_pm_dollar;
	}
	$tc_bs_pm_v=$tc_bs_pm_c*0.995;//LA TASA DE CAMBIO PARA LA VENTA ES EL 99,5% DE LA TASA PARA LA COMPRA ---
	//INSERTANDO EN LA TBLA DE MC_BALANCE ADMINISTRATIVO
	$verf_balance=M_balance_administrativo_lcv_C($conexion, $fh_registro, $descripcion, $dgo_tipo_de_operacion, $dgo_comision, $dgo_pm, $dgo_bs, $dgo_dollar, $pre_co_bs_dep_ret, $pre_co_gan_pm_eqv, $pre_co_gan_dollar_eqv, $pre_co_gan_bs_eqv, $pre_co_pm_al_respaldo, $pre_co_dollar_al_respaldo, $pre_co_bs_al_respaldo, $tc_bs_dollar, $tc_pm_dollar, $tc_bs_pm_c, $tc_bs_pm_v, $rp_ie_bs_puros, $rp_ie_dollar_puros, $rp_res_mon_circ, $rp_res_mon_bs_puros, $rp_res_mon_dollar_puros, $ra_ie_bs_puros, $ra_ie_dollares_puros, $ra_ie_dollare_eqv, $ra_res_mon_circ, $ra_res_mon_bs_puros, $ra_res_mon_dollares_puros, $ra_res_mon_dollares_eqv);
	//INSERTANDO EN LA TABLA DE MC_PARIDAD_CAMBIARIA
	$datos_ultima_paridad2=M_paridad_cambiaria_R_ultima($conexion);
	$ultimo_comision_compra=$datos_ultima_paridad2['PORC_COMISION_POR_COMPRA'][0];
	$ultimo_comision_venta=$datos_ultima_paridad2['PORC_COMISION_POR_VENTA'][0];
	$verf_paridad=M_paridad_cambiaria_C($conexion, $fh_registro, 'Bs', $tc_bs_pm_c, $tc_bs_pm_v, $ultimo_comision_compra, $ultimo_comision_venta);
	if($verf_balance and $verf_paridad){
		return true;
	}else if(!$verf_balance and $verf_paridad){
		return "error al insertar en balance_administrativo";
	}else if($verf_balance and !$verf_paridad){
		return "error al insertar en paridad_cambiaria";
	}else{//la opcion que queda en if(!$verf_balance and !$verf_paridad):
		return false;
	}
}
function M_balance_administrativo_primero_id($conexion){//BORRA DADO EL ID
	$consulta="SELECT `ID_ADM` FROM `mc_balance_administrativo_lcv` WHERE `ID_ADM`=(SELECT MIN(`ID_ADM`) FROM `mc_balance_administrativo_lcv`)";
	$resultados=mysqli_query($conexion,$consulta);
	$i=0;
	$datos['ID_ADM'][$i]='';
	while(($fila=mysqli_fetch_array($resultados))==true){
		$datos['ID_ADM'][$i]=$fila['ID_ADM'];
		$i=$i+1;
	}
	return $datos;
}
?>