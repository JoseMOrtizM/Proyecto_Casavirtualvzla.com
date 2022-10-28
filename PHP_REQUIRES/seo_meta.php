<!---------------- ETIQUETAS METAS PARA SEO --------------------------------------->
<!-- META CANONICAL PARA INDEX -->
<link rel='canonical' href='<?php echo $_SERVER["REQUEST_URI"]; ?>' />
<!-- TIPO DE IDIOMA Y TIPO DE DOCUMENTO -->
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<!-- META DESCRIPCION -->
<meta name='description' content='Compra y venta de productos con moneda virtual'/>
<!-- META ROBOTS PARA PÁGINA INDEX Y BUSQUEDA LIKE O VISIBLE AL BUSCADOR -->
<meta name='robots' content='index, follow'>
<!-- META ROBOTS PARA PÁGINAS INTERNAS INVISIBLES AL BUSCADOR PERO RASTREABLES -->
<!--  <meta name='robots' content='noindex, follow'> -->
<!-- META KEYS WORDS SACADAS DE LA LISTA DE CATEGORIAS DE LA BD -->
<meta name='keywords' content='Casa Virtual, Pemón, Arca, Bolívares, Dólares, Compra, Venta, Inversión, Inflación, Productos, Servicios, Venezuela, <?php 
	$datos_de_categorias_seo=M_categorias_disponibles($conexion);
	$datos_de_etiquetas_seo=M_etiquetas_disponibles($conexion);
	$i=0;
	while(isset($datos_de_categorias_seo['CATEGORIA'][$i])){
		echo $datos_de_categorias_seo['CATEGORIA'][$i];
		if(isset($datos_de_categorias_seo['CATEGORIA'][$i+1])){
			echo ", ";
		}
		$i++;
	}
	$i=0;
	while(isset($datos_de_etiquetas_seo['ETIQUETA'][$i])){
		echo $datos_de_etiquetas_seo['ETIQUETA'][$i];
		if(isset($datos_de_etiquetas_seo['ETIQUETA'][$i+1])){
			echo ", ";
		}
		$i++;
	}
	?>'/>
<!-- META TITULO -->
<meta property='og:title' content='¡Casa Virtual Venezuela! y dile adios a la inflación'/>
<!-- Compatibilidad con Internet Explorer -->
<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
<!-- Schema.org para Google -->
<meta itemprop='name' content='Casa Virtual Venezuela'>
<!-- Schema.org para Google -->
<meta itemprop='description' content='Compra y venta de productos con moneda virtual'>
<!-- IMAGEN EN EL BUSCADOR -->
<meta itemprop='image' content='https://www.casavirtual.com/MiCoin/img/logoanimado.png'>
