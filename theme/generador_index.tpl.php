<body>
	<?php echo mensajes::getFlash(); ?>	
	<div id="content">
		<?php echo migas::getMigas(); ?>
		
		<div id="box_generador">
		  <h1>Carga de archivo para generar firmas</h1>
		   <div class="uno">
		  <div class="ico_logout"><a href="<?php echo WEB_ROOT . '/index.php?c=login&e=logout'; ?>">Salir</a></div>
		  <div class="ico_password"><a href="<?php echo WEB_ROOT . '/index.php?c=generador&e=cambiarPassword'; ?>">Cambiar contraseña</a></div>
		  <div class="ico_configuracion"><a href="<?php echo WEB_ROOT . '/index.php?c=generador&e=cambiarConfiguracion'; ?>">Cambiar configuración de la firma</a></div>
			<div class="ico_descargar"><a href="<?php echo WEB_ROOT . '/upload/plantilla/plantilla.xlsx'; ?>">Descargar plantilla</a></div>
		</div>
		  <hr />
		   <div class="dos">
		  <div class="ico_excel">  <p>Vd. puede cargar el último excel subido</p><br />

			<?php if (file_exists(DIR_ROOT . "/upload/tmp/plantilla.xlsx")): ?>
			<a href="<?php echo WEB_ROOT ?>/index.php?c=generador&e=validarExcel">Cargar último excel subido (<?php echo date("d-m-Y H:i:s", filectime(DIR_ROOT . "/upload/tmp/plantilla.xlsx")); ?>)</a> <a href="<?php echo WEB_ROOT . '/upload/tmp/plantilla.xlsx'; ?>">Descargar</a>
			<?php else: ?>
			No hay subido ningún archivo antiguo.
			<?php endif; ?>
		  </div></div><hr />
		  <div class="tres">
			  <p>O cargar uno nuevo:</p>
			  <form action="<?php echo WEB_ROOT; ?>/index.php?c=generador&e=index&f=subir" method="post" enctype="multipart/form-data">
				<input type="file" name="file" size="50" />
				<br />
				<input type="submit" value="Subir archivo" />
			  </form>
			</div>
		</div>

	</div>
</body>
