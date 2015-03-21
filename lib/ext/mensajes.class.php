<?php

class mensajes
{
  static
	$flash = array();
  
  static public function setFlash($TFlash, $MFlash)
  {
    self::$flash['TFlash'] = $TFlash;
    self::$flash['MFlash'] = $MFlash;
  }
  
  static public function getFlash()
  {
    if (!empty(self::$flash['TFlash']))
	{
	  return '<div class="'.self::$flash['TFlash'].'">' . self::$flash['MFlash'] . '</div>';
	}
  }
}