<body>
	<?php echo mensajes::getFlash(); ?>	
	<div id="content">
		<?php echo migas::getMigas(); ?>
		
		<!--<h1>Generar imágenes</h1>-->

		<div id="box_generador_preview">

		<?php if(isset($var['excel'])): ?>

		<!-- ############# Si se ha seleccionado alguna firma para generar ############# -->
		<br />
		<div class="descargar_firmas"><a href="<?php echo WEB_ROOT . "/upload/tmp/firmas-ibermutuamur-".date('d-m-Y').".zip"; ?>">Descargar las firmas</a></div>

		<?php foreach($_POST['empleados'] AS $idEmpleado): ?>

		<div class="img_preview"><img src="<?php echo WEB_ROOT . "/upload/tmp/".$idEmpleado."-".textos::getLimpiaTexto($var['excel'][$idEmpleado]['Nombre']).".png"; ?>"></div>

		<?php endforeach; ?>

		<?php else: ?>

		<!-- ############# Si 'NO' se ha seleccionado alguna firma para generar ############# -->
		<div class="img_no_preview">Sin firmas para mostrar.</div>

		<?php endif; ?>

		</div>

	</div>
</body>