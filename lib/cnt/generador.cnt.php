<?php
class generador
{
  static
	$acciones = array(
			'index',
			'validarExcel',
			'generarImagenes',
			'cambiarPassword',
			'cambiarConfiguracion',
			),
	$error = false;
	
  static public function getAcciones()
  {
	return self::$acciones;
  }
  
  static public function index()
  {	
	migas::setMigas(array(
		'Inicio'=>array('cnt'=>'generador', 'acn'=>'index'),
		'Cargar archivo'=>'',
	));
	
	date_default_timezone_set('Europe/Madrid');
	chmod(realpath(DIR_ROOT."/upload/tmp"), 0777);
	if(isset($_GET['f']) AND $_GET['f'] == 'subir')
	{
		if( $_FILES['file']['name'] != "" )
		{
			if (file_exists("upload/" . $_FILES["file"]["name"])){
				unlink(DIR_ROOT . "/upload/tmp/" . $_FILES["file"]["name"]);
			}
			//move_uploaded_file($_FILES["file"]["tmp_name"], DIR_ROOT."/upload/tmp/" . $_FILES["file"]["name"]);
			move_uploaded_file($_FILES["file"]["tmp_name"], DIR_ROOT."/upload/tmp/plantilla.xlsx");
			
			return header('Location: ' . WEB_ROOT . '/index.php?c=generador&e=index&f=subido');
		}
		else
		{
			mensajes::setFlash('alert', 'No has seleccionado ningún archivo.');
			//die("No file specified!");
		}
	}elseif(isset($_GET['f']) AND $_GET['f'] == 'subido'){
		mensajes::setFlash('notice', 'Archivo subido correctamente: <i>plantilla.xlsx ('.date("d-m-Y H:i:s", filectime(DIR_ROOT . "/upload/tmp/plantilla.xlsx")).')</i>.');
	}
	
	return nucleo::getRender(array(
								'tpl'=>'generador',
								'var'=>array(
										'prueba'=>'generador',
										),
								)
							);
  }
  
  static public function validarExcel()
  {
	migas::setMigas(array(
		'Inicio'=>array('cnt'=>'generador', 'acn'=>'index'),
		'Validar excel'=>'',
	));
	
	// En la Variable file ponemos direccion y nombre del Archivo a pasar a arreglo.
	//$file = DIR_ROOT . '/upload/plantilla/plantilla.xlsx';
	 
	// Instanciamos la Clase y le pasamos la ruta y nombre del archivo
	//$buscador = new ExcelToArray($file);
	 
	// Convertimos a un arreglo y le pasamos cual sera el titulo clave.
	//$buscador->loadExcel('usuario');
	 
	// Nos retorna el Arreglo del excel Completo
	//$arreglo = $buscador->getArray();
	 
	// Busca una fila por la columna identificadora y retorna el un arreglo con clave y valor para cada una de las columnas
	//$users = $buscador->findId('Nombre');
	 
	// Ordena el Arreglo por una de las columnas y lo retorna
	//$arregloOrdenado = $buscador->sort('usuario');
	 
	// Busqueda exacta por una columna determinada
	// Retorna un arreglo para una fila pasando como parámetros un titulo y un valor 
	// $buscador->findByColumn('usuario', 'objetivophp');
	 
	// Buscar en cualquier columna cualquier valor que contenga 'obj'.
	//$buscador->findByCount('obj');
	
	// Buscar en la columna usuario el usuario 'obj'
	//$buscador->findByCount('obj', 'usuario');
	
	date_default_timezone_set('Europe/Madrid');
	$file = DIR_ROOT . '/upload/tmp/plantilla.xlsx';	 
	$buscador = new ExcelToArray($file);	 
	$buscador->loadExcel('usuario');
	$excel = $buscador->getArray();
	unset($excel['']);
	
	return nucleo::getRender(array(
								'tpl'=>'generador',
								'acn'=>'validarExcel',
								'var'=>array(
										'excel'=>$excel,
										),
								)
							);
  }
  
  static public function generarImagenes()
  {
	migas::setMigas(array(
		'Inicio'=>array('cnt'=>'generador', 'acn'=>'index'),
		'Generar imágenes'=>'',
	));
	
	if(isset($_POST['empleados']) AND count($_POST['empleados'])>0){	
		array_map('unlink', glob(DIR_ROOT . '/upload/tmp/*.png'));
		date_default_timezone_set('Europe/Madrid');
		$file = DIR_ROOT . '/upload/tmp/plantilla.xlsx';	 
		$buscador = new ExcelToArray($file);	 
		$buscador->loadExcel('usuario');
		$excel = $buscador->getArray();
		unset($excel['']);
		
		foreach($_POST['empleados'] AS $idEmpleado):
		
			// verificar campos vacios
			$valido = 0;
			foreach($excel[$idEmpleado] as $clave=>$valor){
				if(!empty($valor)){ $valido++; }
			}
			if($valido > 0){ 

				// Crear la imagen
				$frima = imagecreatetruecolor(1000, 200);

				include(DIR_ROOT . '/lib/cfg/config_firma.php');
				if (file_exists(DIR_ROOT . '/lib/cfg/config_firma_custom.php')){
					include(DIR_ROOT . '/lib/cfg/config_firma_custom.php');
				}

				imagefilledrectangle($frima, 0, 0, $firma_ancho, $firma_alto, $firma_fondo);

				$nombre = $excel[$idEmpleado]['Nombre'];
				$cargo = $excel[$idEmpleado]['Cargo'];
				$funcion = $excel[$idEmpleado]['Funcion'];
				$direccion = $excel[$idEmpleado]['Direccion'];
				$telefono = $excel[$idEmpleado]['Telefono'];
				$fax = $excel[$idEmpleado]['Fax'];
				$movil = $excel[$idEmpleado]['Movil'];
				$ext = $excel[$idEmpleado]['Ext'];
				$email = $excel[$idEmpleado]['Email'];
				$web = $excel[$idEmpleado]['Web'];
				$aviso = $excel[$idEmpleado]['Aviso'];
				
				$nombre_margen_superior = $nombre_margen_superior+$nombre_tamano;
				$nombre_margen_superior = ($nombre<>'' ? $nombre_margen_superior : 0);
				$cargo_margen_superior = ($cargo<>'' ? $cargo_margen_superior : 0);
				$funcion_margen_superior = ($funcion<>'' ? $funcion_margen_superior : 0);
				$direccion_margen_superior = ($direccion<>'' ? $direccion_margen_superior : 0);
				$telefono_margen_superior = (($telefono<>'' OR $movil<>'' OR $fax<>'' OR $ext<>'') ? $telefono_margen_superior : 0);
				$email_margen_superior = ($email<>'' ? $email_margen_superior : 0);
				$web_margen_superior = ($web<>'' ? $web_margen_superior : 0);
				$aviso_margen_superior = ($aviso<>'' ? $aviso_margen_superior : 0);

				// Logo
				//imagecopy($frima, $logo_ibermutuamur, $logo_margen_izquierdo, $logo_margen_superior, 0, 0, $logo_ancho, $logo_alto);		
				$total_alto_firma =
					$nombre_margen_superior+
					$cargo_margen_superior+
					($funcion<>'' ? $funcion_margen_superior : 0)+
					$direccion_margen_superior+
					$telefono_margen_superior+
					$email_margen_superior+
					$web_margen_superior+
					$aviso_margen_superior
				;
				$diferencia_tamano = ($logo_alto+$logo_margen_superior)-$total_alto_firma;
				$pocentaje_diferencia_tamano = 1-round($diferencia_tamano/$logo_alto, 2);	
				//$pocentaje_diferencia_tamano = 1-number_format($diferencia_tamano/$logo_alto, 2, '.', '');
				$logo_alto_nuevo = $logo_alto * $pocentaje_diferencia_tamano;
				$logo_ancho_nuevo = $logo_ancho * $pocentaje_diferencia_tamano;
				
				$thumb_logo = imagecreatetruecolor($logo_ancho_nuevo, $logo_alto_nuevo);
				imagecopyresampled($thumb_logo, $logo_ibermutuamur, 0, 0, 0, 0, $logo_ancho_nuevo, $logo_alto_nuevo, $logo_ancho, $logo_alto);
				imagecopy($frima, $thumb_logo, $logo_margen_izquierdo, $logo_margen_superior, 0, 0, $logo_ancho_nuevo, $logo_alto_nuevo);

				// Firma
				/* imagettftext(
								imagen, 
								tamaño, 
								inclinacion, 
								margen_izquierda
								margen_superior, 
								color, 
								fuente, 
								texto
							);*/			
				$img_nombre = imagettftext(
								$frima, 
								$nombre_tamano, 
								0, 
								$logo_ancho_nuevo+$logo_margen_izquierdo+$nombre_margen_izquierdo, 
								$nombre_margen_superior, 
								$nombre_color, 
								$nombre_fuente, 
								$nombre
							);
				$img_cargo = imagettftext(
								$frima, 
								$cargo_tamano, 
								0, 
								$logo_ancho_nuevo+$logo_margen_izquierdo+$cargo_margen_izquierdo, 
								($nombre_margen_superior)+$cargo_margen_superior, 
								$cargo_color, 
								$cargo_fuente, 
								$cargo
							);
				$img_funcion = imagettftext(
								$frima, 
								$funcion_tamano, 
								0, 
								$logo_ancho_nuevo+$logo_margen_izquierdo+$funcion_margen_izquierdo, 
								($nombre_margen_superior+$cargo_margen_superior)+$funcion_margen_superior, 
								$funcion_color, 
								$funcion_fuente, 
								$funcion
							);
				$img_direccion = imagettftext(
								$frima, 
								$direccion_tamano, 
								0, 
								$logo_ancho_nuevo+$logo_margen_izquierdo+$direccion_margen_izquierdo, 
								($nombre_margen_superior+$cargo_margen_superior+$funcion_margen_superior)+$direccion_margen_superior, 
								$direccion_color, 
								$direccion_fuente, 
								$direccion
							);
				$img_telefono_label = imagettftext(
								$frima, 
								$telefono_label_tamano, 
								0, 
								$logo_ancho_nuevo+$logo_margen_izquierdo+$telefono_label_margen_izquierdo, 
								($nombre_margen_superior+$cargo_margen_superior+$funcion_margen_superior+$direccion_margen_superior)+$telefono_label_margen_superior, 
								$telefono_label_color, 
								$telefono_label_fuente, 
								($telefono<>'' ? $telefono_label : '')
							);
				$img_telefono = imagettftext(
								$frima, 
								$telefono_tamano, 
								0, 
								($telefono<>'' ? $img_telefono_label[2]+$telefono_margen_izquierdo : $img_telefono_label[2]), 
								($nombre_margen_superior+$cargo_margen_superior+$funcion_margen_superior+$direccion_margen_superior)+$telefono_margen_superior, 
								$telefono_color, 
								$telefono_fuente, 
								$telefono
							);
				$img_fax_label = imagettftext(
								$frima, 
								$fax_label_tamano, 
								0, 
								($fax<>'' ? $img_telefono[2]+$fax_label_margen_izquierdo : $img_telefono[2]), 
								($nombre_margen_superior+$cargo_margen_superior+$funcion_margen_superior+$direccion_margen_superior)+$fax_label_margen_superior, 
								$fax_label_color, 
								$fax_label_fuente, 
								(($telefono<>'' AND $fax<>'') ? ' - ' : '').($fax<>'' ? $fax_label : '')
							);
				$img_fax = imagettftext(
								$frima, 
								$fax_tamano, 
								0, 
								($fax<>'' ? $img_fax_label[2]+$fax_margen_izquierdo : $img_fax_label[2]), 
								($nombre_margen_superior+$cargo_margen_superior+$funcion_margen_superior+$direccion_margen_superior)+$fax_margen_superior, 
								$fax_color, 
								$fax_fuente, 
								$fax
							);
				$img_movil_label = imagettftext(
								$frima, 
								$movil_label_tamano, 
								0, 
								($movil<>'' ? $img_fax[2]+$movil_label_margen_izquierdo : $img_fax[2]), 
								($nombre_margen_superior+$cargo_margen_superior+$funcion_margen_superior+$direccion_margen_superior)+$movil_label_margen_superior, 
								$movil_label_color, 
								$movil_label_fuente, 
								((($telefono<>'' OR $fax<>'') AND $movil<>'') ? ' - ' : '').($movil<>'' ? $movil_label : '')
							);
				$img_movil = imagettftext(
								$frima, 
								$movil_tamano, 
								0, 
								($movil<>'' ? $img_movil_label[2]+$movil_margen_izquierdo : $img_movil_label[2]), 
								($nombre_margen_superior+$cargo_margen_superior+$funcion_margen_superior+$direccion_margen_superior)+$movil_margen_superior, 
								$movil_color, 
								$movil_fuente, 
								$movil
							);
				$img_ext_label = imagettftext(
								$frima, 
								$ext_label_tamano, 
								0, 
								($ext<>'' ? $img_movil[2]+$ext_label_margen_izquierdo : $img_movil[2]), 
								($nombre_margen_superior+$cargo_margen_superior+$funcion_margen_superior+$direccion_margen_superior)+$ext_label_margen_superior, 
								$ext_label_color, 
								$ext_label_fuente, 
								((($telefono<>'' OR $fax<>'' OR $movil<>'') AND $ext<>'') ? ' - ' : '').($ext<>'' ? $ext_label : '')
							);
				$img_ext = imagettftext(
								$frima, 
								$ext_tamano, 
								0, 
								($ext<>'' ? $img_ext_label[2]+$ext_margen_izquierdo : $img_ext_label[2]), 
								($nombre_margen_superior+$cargo_margen_superior+$funcion_margen_superior+$direccion_margen_superior)+$ext_margen_superior, 
								$ext_color, 
								$ext_fuente, 
								$ext
							);
				$img_email = imagettftext(
								$frima, 
								$email_tamano, 
								0, 
								$logo_ancho_nuevo+$logo_margen_izquierdo+$email_margen_izquierdo, 
								($nombre_margen_superior+$cargo_margen_superior+$funcion_margen_superior+$direccion_margen_superior+$telefono_margen_superior)+$email_margen_superior, 
								$email_color, 
								$email_fuente, 
								$email
							);
				$img_web = imagettftext(
								$frima, 
								$web_tamano, 
								0, 
								$logo_ancho_nuevo+$logo_margen_izquierdo+$web_margen_izquierdo, 
								($nombre_margen_superior+$cargo_margen_superior+$funcion_margen_superior+$direccion_margen_superior+$telefono_margen_superior+$email_margen_superior)+$web_margen_superior, 
								$web_color, 
								$web_fuente, 
								$web
							);
				$img_aviso = imagettftext(
								$frima, 
								$aviso_tamano, 
								0, 
								$logo_ancho_nuevo+$logo_margen_izquierdo+$aviso_margen_izquierdo, 
								($nombre_margen_superior+$cargo_margen_superior+$funcion_margen_superior+$direccion_margen_superior+$telefono_margen_superior+$email_margen_superior+$web_margen_superior)+$aviso_margen_superior, 
								$aviso_color, 
								$aviso_fuente, 
								$aviso
							);
				
				// Línea superior
				$img_linea = imagettftext($frima, $linea_tamano, 0, $linea_margen_izquierdo, $linea_margen_superior, $linea_color, $linea_fuente, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
				
				$ancho_filas = array($img_nombre[2],$img_cargo[2],$img_funcion[2],$img_direccion[2],$img_ext[2],$img_email[2],$img_web[2],$img_aviso[2]);
				//$thumb = imagecreatetruecolor(max($ancho_filas), $img_aviso[3]+5);
				//imagecopy($thumb, $frima, 0, 0, 0, 0, max($ancho_filas), $img_aviso[3]+5);
				$alto_corte = array($logo_alto_nuevo+$logo_margen_superior, $img_aviso[3]);
				//$thumb = imagecreatetruecolor(max($ancho_filas), $logo_alto_nuevo+$logo_margen_superior);
				$thumb = imagecreatetruecolor(max($ancho_filas), max($alto_corte));
				//imagecopy($thumb, $frima, 0, 0, 0, 0, max($ancho_filas), $logo_alto_nuevo+$logo_margen_superior);
				imagecopy($thumb, $frima, 0, 0, 0, 0, max($ancho_filas), max($alto_corte));
				imagepng($thumb, DIR_ROOT . "/upload/tmp/".$idEmpleado."-".textos::getLimpiaTexto($nombre).".png");
				
				//imagepng($frima, DIR_ROOT . "/upload/tmp/".$idEmpleado."-".textos::getLimpiaTexto($nombre).".png"); 
				imagedestroy($frima);
				imagedestroy($thumb);
				
				$img_firmas[] = DIR_ROOT . "/upload/tmp/".$idEmpleado."-".textos::getLimpiaTexto($nombre).".png";
			}else{ unset($_POST['empleados'][$idEmpleado]); }
		endforeach;
		
		// Crear Zip
		array_map('unlink', glob(DIR_ROOT . '/upload/tmp/*.zip'));
		$zipname = DIR_ROOT . "/upload/tmp/firmas-ibermutuamur-".date('d-m-Y').".zip";
		$zip = new ZipArchive;
		$zip->open($zipname, ZipArchive::CREATE);
		foreach ($img_firmas as $img_firma) {
		  $newFirma = str_replace(DIR_ROOT . "/upload/tmp/", '', $img_firma);
		  $zip->addFile($img_firma, $newFirma);
		}
		$zip->close();
		
		return nucleo::getRender(array(
								'tpl'=>'generador',
								'acn'=>'generarImagenes',
								'var'=>array(
										'excel'=>$excel,
										),
								)
							);
	}else{
		mensajes::setFlash('alert', 'No has seleccionado ninguna firma para generar.');
		
		return nucleo::getRender(array(
								'tpl'=>'generador',
								'acn'=>'generarImagenes',
								)
							);
	}
  }
  
  static public function cambiarPassword()
  {	
	migas::setMigas(array(
		'Inicio'=>array('cnt'=>'generador', 'acn'=>'index'),
		'Cambiar contraseña'=>'',
	));
	
	$credenciales = archivos::getArchivo(DIR_ROOT . '/lib/cfg/credenciales.php', 'leer');
	$credencialesArr = explode('::', $credenciales);
	$credencialesUser = $credencialesArr[0];
	$credencialesPass = $credencialesArr[1];
	
	if(!empty($_POST)){
		if(isset($_POST['admin_password']) AND md5($_POST['admin_password'].HASH_KEY) == $credencialesPass AND $_POST['nuevo_admin_password']<>''){
			$newPasswordCrypt = md5($_POST['nuevo_admin_password'].HASH_KEY);			
			$newCredenciales = $credencialesUser.'::'.$newPasswordCrypt;
			archivos::getArchivo(DIR_ROOT . '/lib/cfg/credenciales.php', 'sustituir', $newCredenciales);
			
			mensajes::setFlash('notice', 'Se ha anctualizado la contraseña correctamente.');
		}else{
			mensajes::setFlash('alert', 'La contraseña no ha podido editarse, hay algún error en los datos introducidos.');
		}
	}
	
	return nucleo::getRender(array('tpl'=>'generador', 'acn'=>'cambiarPassword'));
  }
  
  static public function cambiarConfiguracion()
  {	
	migas::setMigas(array(
		'Inicio'=>array('cnt'=>'generador', 'acn'=>'index'),
		'Cambiar configuracion de la firma'=>'',
	));
						
	if(!empty($_POST)){
		$new_cfgs_firma_custom = '
			<?php
			############ CONFIGURACIÓN CUSTOM ############
			#
			#
			// Logo
			$logo_margen_superior = '.$_POST["logo_margen_superior"].';

			// Nombre
			$nombre_margen_superior = '.$_POST["nombre_margen_superior"].';
			$nombre_margen_izquierdo = '.$_POST["campos_margen_izquierdo"].';

			// Cargo
			$cargo_margen_superior = '.$_POST["cargo_margen_superior"].';
			$cargo_margen_izquierdo = '.$_POST["campos_margen_izquierdo"].';

			// Funcion
			$funcion_margen_superior = '.$_POST["funcion_margen_superior"].';
			$funcion_margen_izquierdo = '.$_POST["campos_margen_izquierdo"].';

			// Direccion
			$direccion_margen_superior = '.$_POST["direccion_margen_superior"].';
			$direccion_margen_izquierdo = '.$_POST["campos_margen_izquierdo"].';

			// Telefono
			$telefono_margen_superior = '.$_POST["telefonos_margen_superior"].';
			$telefono_label_margen_superior = '.$_POST["telefonos_margen_superior"].';
			$telefono_label_margen_izquierdo = '.$_POST["campos_margen_izquierdo"].';

			// Fax
			$fax_margen_superior = '.$_POST["telefonos_margen_superior"].';
			$fax_label_margen_superior = '.$_POST["telefonos_margen_superior"].';

			// Movil
			$movil_margen_superior = '.$_POST["telefonos_margen_superior"].';
			$movil_label_margen_superior = '.$_POST["telefonos_margen_superior"].';

			// Ext
			$ext_margen_superior = '.$_POST["telefonos_margen_superior"].';
			$ext_label_margen_superior = '.$_POST["telefonos_margen_superior"].';

			// Email
			$email_margen_superior = '.$_POST["email_margen_superior"].';
			$email_margen_izquierdo = '.$_POST["campos_margen_izquierdo"].';

			// Web
			$web_margen_superior = '.$_POST["web_margen_superior"].';
			$web_margen_izquierdo = '.$_POST["campos_margen_izquierdo"].';

			// Aviso
			$aviso_margen_superior = '.$_POST["aviso_margen_superior"].';
			$aviso_margen_izquierdo = '.$_POST["campos_margen_izquierdo"].';
			#
			#
			############ CONFIGURACIÓN CUSTOM ############
		';
		
		archivos::getArchivo(DIR_ROOT . '/lib/cfg/config_firma_custom.php', 'sustituir', $new_cfgs_firma_custom);
	}
	
	if (file_exists(DIR_ROOT . '/lib/cfg/config_firma_custom.php') AND isset($_GET['f']) AND $_GET['f']=='default'){
		unlink(DIR_ROOT . '/lib/cfg/config_firma_custom.php');
		return header('Location: ' . WEB_ROOT . '/index.php?c=generador&e=cambiarConfiguracion');
	}
	
	if (file_exists(DIR_ROOT . '/lib/cfg/config_firma_custom.php')){
		include(DIR_ROOT . '/lib/cfg/config_firma_custom.php');
	}else{
		$frima = imagecreatetruecolor(1000, 200);
		include(DIR_ROOT . '/lib/cfg/config_firma.php');
	}
	
	$cfgs_firma_custom = array(
							array('campo'=>'logo_margen_superior', 'nombre_campo'=>'Margen superior del logo', 'valor'=>$logo_margen_superior),							
							array('campo'=>'campos_margen_izquierdo', 'nombre_campo'=>'Margen izquierdo del texto', 'valor'=>$nombre_margen_izquierdo),							
							array('campo'=>'nombre_margen_superior', 'nombre_campo'=>'Margen superior del nombre', 'valor'=>$nombre_margen_superior),									
							array('campo'=>'cargo_margen_superior', 'nombre_campo'=>'Margen superior del cargo', 'valor'=>$cargo_margen_superior),									
							array('campo'=>'funcion_margen_superior', 'nombre_campo'=>'Margen superior de la función', 'valor'=>$funcion_margen_superior),									
							array('campo'=>'direccion_margen_superior', 'nombre_campo'=>'Margen superior de la dirección postal', 'valor'=>$direccion_margen_superior),									
							array('campo'=>'telefonos_margen_superior', 'nombre_campo'=>'Margen superior de los teléfonos', 'valor'=>$telefono_margen_superior),									
							array('campo'=>'email_margen_superior', 'nombre_campo'=>'Margen superior del correo electrónico', 'valor'=>$email_margen_superior),								
							array('campo'=>'web_margen_superior', 'nombre_campo'=>'Margen superior de la web corporativa', 'valor'=>$web_margen_superior),									
							array('campo'=>'aviso_margen_superior', 'nombre_campo'=>'Margen superior del aviso', 'valor'=>$aviso_margen_superior),
						);
	
	return nucleo::getRender(array(
								'tpl'=>'generador', 
								'acn'=>'cambiarConfiguracion',
								'var'=>array(
										'cfgs_firma_custom'=>$cfgs_firma_custom,
										),
							));
  }
}