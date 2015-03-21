<?php $cfgs_firma_custom = $var['cfgs_firma_custom']; ?>

<body>
	<?php echo mensajes::getFlash(); ?>	
	<div id="content">
		<?php echo migas::getMigas(); ?>
		
		<h1>Cambiar configuración de la firma</h1>

		<div id="box_cambiar_configuracion">
		
			<a href="<?php echo WEB_ROOT; ?>/index.php?c=generador&e=cambiarConfiguracion&f=default">Reiniciar configuración por defecto</a>

			<form name="form_cambiar_configuracion" method="post" onSubmit="return validarConfiguracion()"  action="<?php echo WEB_ROOT; ?>/index.php?c=generador&e=cambiarConfiguracion" id="form_cambiar_configuracion">

				<?php foreach($cfgs_firma_custom AS $cfg_firma_custom): ?>
				
				<div class="form_<?php echo $cfg_firma_custom['campo']; ?>_label"><?php echo $cfg_firma_custom['nombre_campo']; ?>:</div>
				<div class="form_<?php echo $cfg_firma_custom['campo']; ?>"><input type="text" id="<?php echo $cfg_firma_custom['campo']; ?>" name="<?php echo $cfg_firma_custom['campo']; ?>" value="<?php echo $cfg_firma_custom['valor']; ?>" /></div>
				
				<?php endforeach; ?>
				
				<div class="form_boton"><input type="submit" name="change" value="Generar nueva configuración de la firma" /></div>
			</form>

		</div>

	</div>
</body>						




