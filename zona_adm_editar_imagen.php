<?php require ("PHP_MODELO/M_todos.php"); ?>
<?php require ("PHP_REQUIRES/comprueba_session_pagina_acceso.php"); ?>
<!doctype html>
<html>
<head>
	<?php require("PHP_REQUIRES/head_principal.php"); ?>
	<title>Editar Imagen</title>
	<script type="text/javascript" >
	 document.addEventListener('DOMContentLoaded', () => {
		 // Input File
		 const inputImage = document.querySelector('#image');
		 // Nodo donde estará el editor
		 const editor = document.querySelector('#editor');
		 // El canvas donde se mostrará la previa
		 const miCanvas = document.querySelector('#preview');
		 // Contexto del canvas
		 const contexto = miCanvas.getContext('2d');
		 // Ruta de la imagen seleccionada
		 let urlImage = undefined;
		 // Evento disparado cuando se adjunte una imagen
		 inputImage.addEventListener('change', abrirEditor, false);
		 /**
		  * Método que abre el editor con la imagen seleccionada
		  */
		 function abrirEditor(e) {
			 // Obtiene la imagen
			 urlImage = URL.createObjectURL(e.target.files[0]);
			 // Borra editor en caso que existiera una imagen previa
			 editor.innerHTML = '';
			 let cropprImg = document.createElement('img');
			 cropprImg.setAttribute('id', 'croppr');
			 editor.appendChild(cropprImg);
			 // Limpia la previa en caso que existiera algún elemento previo
			 contexto.clearRect(0, 0, miCanvas.width, miCanvas.height);
			 // Envia la imagen al editor para su recorte
			 document.querySelector('#croppr').setAttribute('src', urlImage);
			 // Crea el editor
			 new Croppr('#croppr', {
				 aspectRatio: 1,
				 startSize: [70, 70],
				 onCropEnd: recortarImagen
			 })
		 }
		 /**
		  * Método que recorta la imagen con las coordenadas proporcionadas con croppr.js
		  */
		 function recortarImagen(data) {
			 // Variables
			 const inicioX = data.x;
			 const inicioY = data.y;
			 const nuevoAncho = data.width;
			 const nuevaAltura = data.height;
			 const zoom = 1;
			 let imagenEn64 = '';
			 // La imprimo
			 miCanvas.width = nuevoAncho;
			 miCanvas.height = nuevaAltura;
			 // La declaro
			 let miNuevaImagenTemp = new Image();
			 // Cuando la imagen se carge se procederá al recorte
			 miNuevaImagenTemp.onload = function() {
				 // Se recorta
				 contexto.drawImage(miNuevaImagenTemp, inicioX, inicioY, nuevoAncho * zoom, nuevaAltura * zoom, 0, 0, nuevoAncho, nuevaAltura);
				 // Se transforma a base64
				 imagenEn64 = miCanvas.toDataURL("image/jpeg");
				 // Mostramos el código generado
				 document.querySelector('#base64').textContent = imagenEn64;
			 }
			 // Proporciona la imagen cruda, sin editarla por ahora
			 miNuevaImagenTemp.src = urlImage;
		 }
	 });
	</script>
</head>
<body class="bg-secondary">
	<?php require("PHP_REQUIRES/nav_usuarios.php"); ?>
	<section class="container-fluid mt-2 mb-5 bg-secondary px-0">
		<br>
		<div class="col-12 col-md-9 col-lg-8 col-xl-7 bg-dark mx-auto px-0 text-center p-2 text-light">
			<h4 class="text-warning mt-2"><b>1° Carga tu imagen</b></h4>
			<input type="file" id="image">
			<h4 class="text-warning mt-4"><b>2° Recórtala</b></h4>
			<div id="editor"></div>
			<h4 class="text-warning mt-4"><b>3° Visualízala y guardala</b></h4>
			<h6 class="small">(Click derecho sobre la imagen y <b>guardar imagen como...</b>)</h6>
			<canvas id="preview"></canvas>
			<br>
		</div>
		<code id="base64" class="text-secondary"></code>
		<br><br><br>
	</section>
	<?php require("PHP_REQUIRES/footer_usuario.php"); ?>
</body>
</html>