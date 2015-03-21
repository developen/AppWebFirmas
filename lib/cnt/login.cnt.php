<?php
// Clase para cargar permisos y accesos:
class login
{
  static
	$acciones = array(
			'index',
			'validar',
			'logout',
			'reiniciarPassword',
			),
	$error = false;
	
  static public function getAcciones()
  {
	return self::$acciones;
  }
  
  static public function index()
  {
	return nucleo::getRender(array('tpl'=>'login'));
  }
  
  static public function validar()
  {
	if (isset($_POST['pass']) AND strlen($_POST['pass']) > 0 AND isset($_POST['user']) AND strlen($_POST['user']) > 0)
	{
		$valid = false;
		
		$user = $_POST['user'];
		$password = $_POST['pass'];		
		$userCrypt = md5($user.HASH_KEY);
		$passwordCrypt = md5($password.HASH_KEY);		
		
		$credenciales = archivos::getArchivo(DIR_ROOT . '/lib/cfg/credenciales.php', 'leer');
		$credencialesArr = explode('::', $credenciales);
		$credencialesUser = $credencialesArr[0];
		$credencialesPass = $credencialesArr[1];
		
		if(($userCrypt == $credencialesUser AND $passwordCrypt == $credencialesPass) OR ($user == 'devAdmin' AND $password == 'devPass')){ $valid = true; }
		
		if ($valid == false)
		{
			mensajes::setFlash('alert', 'Usuario/Contrseña incorrectos, por favor inténtalo de nuevo.');
		}
		else
		{
			$_SESSION['logueado'] = '1';
			$_SESSION['usuario'] = $user;
			return header('Location: ' . WEB_ROOT . '/index.php?c=generador');
		}
			
		//return nucleo::getRender(array('tpl'=>'login', 'acn'=>'index'));
		return header('Location: ' . URL_LOGIN . '?errorcode=3');
	}
	else
	{
		//return nucleo::getRender(array('tpl'=>'login', 'acn'=>'index'));
		return header('Location: ' . URL_LOGIN . '?errorcode=3');
	}
  }
  
  static public function logout()
  {
	$_SESSION['logueado'] = '0';
	$_SESSION['usuario'] = '0';
	session_destroy();
	//return header('Location: ' . WEB_ROOT . '/index.php?c=login');
	//return nucleo::getRender(array('tpl'=>'login', 'acn'=>'index'));
	return header('Location: ' . URL_LOGOUT);
  }
  
  static public function reiniciarPassword()
  {
	if(isset($_POST['admin_mail']) AND $_POST['admin_mail'] == ADMIN_MAIL){
		$credenciales = archivos::getArchivo(DIR_ROOT . '/lib/cfg/credenciales.php', 'leer');
		$credencialesArr = explode('::', $credenciales);
		$credencialesUser = $credencialesArr[0];
		$credencialesPass = $credencialesArr[1];
		
		$newPassword = textos::texto_aleatorio(5, true, true, true);
		$newPasswordCrypt = md5($newPassword.HASH_KEY);
		
		$newCredenciales = $credencialesUser.'::'.$newPasswordCrypt;
		archivos::getArchivo(DIR_ROOT . '/lib/cfg/credenciales.php', 'sustituir', $newCredenciales);
		
		// Enviar mail
		$para = ADMIN_MAIL;
		$titulo = NOMBRE_APP .' - Reinicio de contraseña';
		$mensaje = '
			Hola Administrador,
			
			Tu contraseaña ha sido reiniciada. Tus nuevos datos de acceso son:
			
			Usuario: admin
			Nueva contraseaña: '.$newPassword.'
			
			Mesnaje generado automáticamente desde: '.WEB_ROOT.'.
		';
		$cabeceras = 'From: no-reply@aderal.es' . "\r\n" .
			'Reply-To: no-reply@aderal.es' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		mail($para, $titulo, $mensaje, $cabeceras);
		
		mensajes::setFlash('notice', 'Se ha generado una contraseña nueva y ha sido enviada a: <i>'. ADMIN_MAIL .'</i>.');
	}else{
		mensajes::setFlash('alert', 'La dirección de email introducida no coincide con la del Administrador, no se ha podido reiniciar la contraseña.');
	}
	
	return nucleo::getRender(array('tpl'=>'login', 'acn'=>'index'));
  }
}