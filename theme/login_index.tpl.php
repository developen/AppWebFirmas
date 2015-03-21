<body>
	<?php echo mensajes::getFlash(); ?>	
	<div id="content">
		<?php echo migas::getMigas(); ?>
		
		<div id="box_form_login">
		  <h1>App Firmas</h1>
		  <h2>Ibermutuamur</h2>
		  <form name="form_login" method="post" action="<?php echo WEB_ROOT; ?>/index.php?c=login&e=validar" id="form_login">
			<table>
			  <tr>
				<td class="form_login_label">Usuario:</td>
				<td><input type="text" name="user" value="" /></td>
			  </tr>
			  <tr>
				<td class="form_login_label">Contraseña:</td>
				<td><input type="password" name="pass" value=""  /></td>
			  </tr>
			  <tr>
				<td style="text-align:center;" colspan="2"><input type="submit" name="login" value="Entrar" /></td>
			  </tr>
			</table>
		  </form>
		  <div class="recuperar_login"><a href="#" onclick="muestra_oculta('reiniciar_password')">Reiniciar contraseña</a></div>
		  <div id="reiniciar_password">
			<p>Por seguridad, escribe aquí la dirección de email del Administrador</p>
			<form name="form_reiniciar_password" method="post" action="<?php echo WEB_ROOT; ?>/index.php?c=login&e=reiniciarPassword" id="form_reiniciar_password">
			  <table>
				<tr>
				  <td class="form_admin_mail_label">Email del Administrador:</td>
				  <td><input type="text" name="admin_mail" value="" /></td>
				</tr>
				<tr>
				  <td><input type="submit" name="reset" value="Reiniciar contraseña" /></td>
				</tr>
			  </table>
			</form>
		  </div>
		</div>

	</div>
</body>
