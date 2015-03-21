<?php
class nucleo
{
	static 
		$variables;
  
	static public function getCargarPermisos()
	{
		session_start();
		
		if(!isset($_SESSION['logueado']))
		{
			/*if(self::getCntName() <> 'login' AND self::getAcnName() <> 'logout'){
				//return header('Location: ' . WEB_ROOT . '/index.php?c=login');
				return header('Location: ' . URL_LOGIN);
			}*/
			return header('Location: ' . URL_LOGIN);
		}elseif(isset($_SESSION['logueado']) AND $_SESSION['logueado'] == 1)
		{
			if(self::getCntName() == 'login' AND self::getAcnName() <> 'logout'){
				return header('Location: ' . WEB_ROOT . '/index.php?c=generador');
			}
		}
	}
	
	static public function getCnt()
	{
		$controlador = self::getCntName();
		
		if(file_exists(DIR_ROOT .'/lib/cnt/'. $controlador . '.cnt.php'))
		{
		  include_once(DIR_ROOT .'/lib/cnt/'. $controlador . '.cnt.php');
		  $instancia_clase = new $controlador;
		}else{
		  //echo 'La acción "' . $controlador . '" que intentas cargar no existe.<br />';
		  return header('Location: ' . WEB_ROOT . '/index.php');
		}
	}
	
	static public function getCntName()
	{
		if(isset($_GET['c']) AND $_GET['c']<>''){ $controlador = $_GET['c']; }else{ $controlador = 'generador'; }
		return $controlador;
	}
	
	static public function getAcn()
	{
		$controlador = self::getCntName();
		$accion = self::getAcnName();
		$cntAcciones = call_user_func($controlador . '::getAcciones', '');
		if(in_array($accion, $cntAcciones))		{
			call_user_func($controlador . '::' . $accion, '');
		}else{
			return header('Location: ' . WEB_ROOT . '/index.php?c='.$controlador);
		}
	}
	
	static public function getAcnName()
	{
		if(isset($_GET['e']) AND $_GET['e']<>''){ $estado = $_GET['e']; }else{ $estado = 'index'; }
		return $estado;
	}
	
	static public function getRender($render)
	{
		if(!isset($render['tpl'])){ $render['tpl'] = self::getCntName(); }
		if(!isset($render['acn'])){ $render['acn'] = self::getAcnName(); }
		if(!isset($render['var'])){ $render['var'] = array(); }
		self::getTpl($render['tpl'], $render['acn'], $render['var']);
	}
	
	static public function getTpl($cnt = '', $acn = '', $var = '')
	{		
		if($cnt == ''){ $cnt = self::getCntName(); }
		if($acn == ''){ $acn = self::getAcnName(); }
		if($var == ''){ $var = array(); }
		if(file_exists(DIR_ROOT . '/theme/'.$cnt.'_'.$acn.'.tpl.php'))
		{
		  include_once(DIR_ROOT . '/theme/header.tpl.php');
		  include_once(DIR_ROOT . '/theme/'.$cnt.'_'.$acn.'.tpl.php');
		  include_once(DIR_ROOT . '/theme/foot.tpl.php');
		}
		else{
		  echo 'Falta el theme "'.$cnt.'_'.$acn.'".<br />';
		}
	}
	
	static public function getCargarClase($claseUrl, $instancia = true)
	{
		$clase = explode('::', $claseUrl);
		$clase_categoria = $clase[0];
		$clase_nombre = $clase[1];
		if(file_exists(DIR_ROOT . '/lib/'.$clase_categoria.'/'.$clase_nombre.'.class.php'))
		{
		  include_once(DIR_ROOT .'/lib/'.$clase_categoria.'/'.$clase_nombre.'.class.php');
		  if($instancia == true){
			$instancia_clase = new $clase_nombre;
		  }
		}
		else{
		  echo 'Falta la clase: '. DIR_ROOT .'/lib/'.$clase_categoria.'/'.$clase_nombre.'.class.php <br />';
		}
		
		if($instancia == true){
			return $instancia_clase;
		}
	}
	
	static public function getCargarClases()
	{
		self::getCargarClase('ext::mensajes');
		self::getCargarClase('ext::migas');
		self::getCargarClase('ext::textos');
		self::getCargarClase('ext::archivos');
		self::getCargarClase('ext::ExcelToArray', false);
		self::getCargarClase('ext::firma');
	}

}