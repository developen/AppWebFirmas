<?php

### Clase para cargar las funciones del nucleo del programa para su arranque ###
require_once(DIR_ROOT.'/lib/core/nucleo.class.php');

class loader extends nucleo
{  
  ## loadControlador ##
  static public function loadControlador()
  {
	return self::getCnt();
  }
  
  ## loadControlador ##
  static public function loadAccion()
  {
	return self::getAcn();
  }
  
  ## loadExtClases ##
  static public function loadExtClases()
  {
	return self::getCargarClases();
  }
  
  ## loadApp ##
  static public function loadApp()
  {
	self::getCargarPermisos();
	self::loadExtClases();
	self::loadControlador();
	self::loadAccion();
  }
}