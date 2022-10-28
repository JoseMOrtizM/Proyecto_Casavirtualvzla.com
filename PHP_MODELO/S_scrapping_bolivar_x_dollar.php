<?php
	//set_time_limit(30);

	//AQUI PODEMOS AGREGAR MÁS DIRECCIONES SIEMPRE QUE RECORDEMOS USAR LAS FUNCIONES EPLODE PARA UBICAR EL DATO EM LA VARIABLE $resultado
	$i=-1;
	$cta=0;
	$fuente[0]="";
	$bs_x_dolar[0]=0;

	//OTRA DIRECCIÓN: VARIAS RESPUESTAS A LA VEZ
	//usando curl
	$url='https://enparalelovzla.com/';
	$ch=curl_init();
	//ajustando las opciones del curl
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
	//curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);//esta no se puede desactivar sin permiso de administrador
	curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 2);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  0);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	//guardando los resultados del curl en variables por si necesitamos más adelante revisar algun error .... si queremos ver toda la información rescatada solo debemos imprimir las siguientes 3 variables
	$resultado=curl_exec($ch);
	$informacion=curl_getinfo($ch);
	$error=curl_error($ch);
	//cerramos el curl
	curl_close($ch);
	//partiendo el string resutante para hallar el dato que queremos rescatar OTRO
	$parte1=explode('var tasa = ', $resultado);
	$parte1A=explode(';', $parte1[1]);
	$parte2=explode('</p>', $parte1A[0]);
	if(str_replace(",",".",str_replace(".","",$parte2[0]))>1){
		$i++;
		$fuente[$i]="<e title='EnParaleloVzla.com'>@EnParaleloVzla</e>";
		$bs_x_dolar[$i]= (float) str_replace(",",".",str_replace(".","",$parte2[0]));
	}
	
	$cta++;


	//OTRA DIRECCIÓN: VARIAS RESPUESTAS A LA VEZ
	//usando curl
	$url='https://monitordolarvenezuela.com/inicio-amp';
	//$url='http://localhost:8080/mis_sitios/SERSUPRIN/sin_titulo.html';
	$ch=curl_init();
	//ajustando las opciones del curl
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPGET, 1);
	//curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);//esta no se puede desactivar sin permiso de administrador
	curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 2);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  0);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	//guardando los resultados del curl en variables por si necesitamos más adelante revisar algun error .... si queremos ver toda la información rescatada solo debemos imprimir las siguientes 3 variables
	$resultado=curl_exec($ch);
	$informacion=curl_getinfo($ch);
	$error=curl_error($ch);
	//cerramos el curl
	curl_close($ch);
	//partiendo el string resutante para hallar el dato que queremos rescatar OTRO
	$parte1=explode('<b>MonitorDólar:</', $resultado);
	$parte2=isset($parte1[1])?explode('> ', $parte1[1]):0;
	$parte3=isset($parte2[1])?explode('Bs.S</div>', $parte2[1]):0;
	if(str_replace(",",".",str_replace(".","",$parte3[0]))>1){
		$i++;
		$fuente[$i]="<e>@MonitorDolar</e>";
		$bs_x_dolar[$i]= (float) str_replace(",",".",str_replace(".","",$parte3[0]));
	}
	$cta++;
	//partiendo el string resutante para hallar el dato que queremos rescatar OTRO
	$parte1=explode('>Dolar Today</div>', $resultado);
	$parte2=isset($parte1[1])?explode('>', $parte1[1]):0;
	$parte3=isset($parte2[1])?explode('Bs.S</div>', $parte2[1]):0;
	if(str_replace(",",".",str_replace(".","",$parte3[0]))>1){
		$i++;
		$fuente[$i]="<e>@DolarToday</e>";
		$bs_x_dolar[$i]= (float) str_replace(",",".",str_replace(".","",$parte3[0]));
	}
	$cta++;
	//partiendo el string resutante para hallar el dato que queremos rescatar OTRO
	$parte1=explode('>LocalBitcoin (BTC)</div>', $resultado);
	$parte2=isset($parte1[1])?explode('>', $parte1[1]):0;
	$parte3=isset($parte2[1])?explode('Bs.S</div>', $parte2[1]):0;
	if(str_replace(",",".",str_replace(".","",$parte3[0]))>1){
		$i++;
		$fuente[$i]="<e>@LocalBc</e>";
		$bs_x_dolar[$i]= (float) str_replace(",",".",str_replace(".","",$parte3[0]));
	}
	$cta++;
	//partiendo el string resutante para hallar el dato que queremos rescatar OTRO
	$parte1=explode('>Yadio.io</div>', $resultado);
	$parte2=isset($parte1[1])?explode('>', $parte1[1]):0;
	$parte3=isset($parte2[1])?explode('Bs.S</div>', $parte2[1]):0;
	if(str_replace(",",".",str_replace(".","",$parte3[0]))>1){
		$i++;
		$fuente[$i]="<e>@Yadio.io</e>";
		$bs_x_dolar[$i]= (float) str_replace(",",".",str_replace(".","",$parte3[0]));
	}
	$cta++;
	//partiendo el string resutante para hallar el dato que queremos rescatar OTRO
	$parte1=explode('>AIRTM</div>', $resultado);
	$parte2=isset($parte1[1])?explode('>', $parte1[1]):0;
	$parte3=isset($parte2[1])?explode('Bs.S</div>', $parte2[1]):0;
	if(str_replace(",",".",str_replace(".","",$parte3[0]))>1){
		$i++;
		$fuente[$i]="<e>@AIRTM</e>";
		$bs_x_dolar[$i]= (float) str_replace(",",".",str_replace(".","",$parte3[0]));
	}
	$cta++;
	//partiendo el string resutante para hallar el dato que queremos rescatar OTRO
	$parte1=explode('>Bolivar Cucuta</div>', $resultado);
	$parte2=isset($parte1[1])?explode('>', $parte1[1]):0;
	$parte3=isset($parte2[1])?explode('Bs.S</div>', $parte2[1]):0;
	if(str_replace(",",".",str_replace(".","",$parte3[0]))>1){
		$i++;
		$fuente[$i]="<e>@B_Cucuta</e>";
		$bs_x_dolar[$i]= (float) str_replace(",",".",str_replace(".","",$parte3[0]));
	}
	$cta++;
	//partiendo el string resutante para hallar el dato que queremos rescatar OTRO
	$parte1=explode('>American KryptosBank</div>', $resultado);
	$parte2=isset($parte1[1])?explode('>', $parte1[1]):0;
	$parte3=isset($parte2[1])?explode('Bs.S</div>', $parte2[1]):0;
	if(str_replace(",",".",str_replace(".","",$parte3[0]))>1){
		$i++;
		$fuente[$i]="<e>@KryptosBank</e>";
		$bs_x_dolar[$i]= (float) str_replace(",",".",str_replace(".","",$parte3[0]));
	}
	$cta++;
	//partiendo el string resutante para hallar el dato que queremos rescatar OTRO
	$parte1=explode('>Mkambio</div>', $resultado);
	$parte2=isset($parte1[1])?explode('>', $parte1[1]):0;
	$parte3=isset($parte2[1])?explode('Bs.S</div>', $parte2[1]):0;
	if(str_replace(",",".",str_replace(".","",$parte3[0]))>1){
		$i++;
		$fuente[$i]="<e>@Mkambio</e>";
		$bs_x_dolar[$i]= (float) str_replace(",",".",str_replace(".","",$parte3[0]));
	}
	$cta++;


	//IMPRIMIENDO DATOS
	echo "<table class='table table-bordered table-hover'>";
	echo $error;
	//RESUMEN
	echo "
	<tr>
		<td class='py-1 my-0'><b>Promedio</b></td>
		<td class='py-1 my-0'><b>" . number_format(array_sum($bs_x_dolar)/count($bs_x_dolar), 2,',','.') . "</b></td>
	</tr>";
	echo "
	<tr>
		<td class='py-1 my-0'><b>Mayor</b></td>
		<td class='py-1 my-0'><b class='text-success'>" . number_format(max($bs_x_dolar), 2,',','.') . "</b></td>
	</tr>";
	echo "
	<tr>
		<td class='py-1 my-0'><b>Menor</b></td>
		<td class='py-1 my-0'><b class='text-danger'>" . number_format(min($bs_x_dolar), 2,',','.') . "</b></td>
	</tr>";
	//DATOS POR CADA PAGINA
	echo "<tr>
			<th class='bg-warning text-dark py-1 my-0'>Fuente:</th>
			<th class='bg-warning text-dark py-1 my-0'>Bs/$</th>
		<tr>";
	$e=0;
	while(isset($bs_x_dolar[$e])){
		if($bs_x_dolar[$e]>0){
			echo "<tr>";
			echo "<td class='py-0 my-0'>" . $fuente[$e] . "</td>";
			if($bs_x_dolar[$e]==max($bs_x_dolar)){
				$class='text-success';
			}else if($bs_x_dolar[$e]==min($bs_x_dolar)){
				$class='text-danger';
			}else{
				$class='';
			}
			echo "<td class='py-0 my-0 $class'>" . number_format($bs_x_dolar[$e], 2,',','.') . "</td>";
			echo "</tr>";
		}
		$e++;
	}
	echo "<tr>
			<th colspan='2' class='py-0 my-0'>
				<b class='text-center text-danger small'>
					<b>Busquedas: $cta / Resultados: $e</b>
				</b>
			</th>
		<tr>";
	echo "</table>";
?>