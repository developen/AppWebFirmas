<body>
	<?php echo mensajes::getFlash(); ?>	
	<div id="content">
		<?php echo migas::getMigas(); ?>
		
		<h1>Cambiar contraseña</h1>

		<div id="box_cambiar_password">

			<form name="form_cambiar_password" method="post" onSubmit="return validarPasswd()"  action="<?php echo WEB_ROOT; ?>/index.php?c=generador&e=cambiarPassword" id="form_cambiar_password">
				<table>
					<tr>
						<td class="form_password_label">Contraseña actual:</td>
						<td><input type="password" name="admin_password" value="" /></td>
					</tr>
					<tr>
						<td class="form_cambiar_password_label">Nueva contraseña:</td>
						<td><input type="password" id="nuevo_admin_password" name="nuevo_admin_password" value="" /></td>
					</tr>
					<tr>
						<td class="form_cambiar_password2_label">Repite la nueva contraseña:</td>
						<td><input type="password" id="nuevo_admin_password2" name="nuevo_admin_password2" value="" /></td>
					</tr>
					<tr>
						<td><input type="submit" name="change" value="Cambiar contraseña" /></td>
					</tr>
				</table>
			</form>

		</div>

	</div>
</body>