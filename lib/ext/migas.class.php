<?php
class migas
{  
  static
	$arrMigas = array();
  
  static public function setMigas($arrMigas)
  {
    self::$arrMigas = $arrMigas;
  }
  
  // ## getMigas ##
  static public function getMigas($cInicio = 'generador', $nInicio = 'Inicio')
  {	
	$migas = '';
	if (!empty(self::$arrMigas))
	{
		$migas .= '<div id="migasPan">';	
		$migas .= '<ul>';
	  
		foreach(self::$arrMigas AS $nombreMiga => $linkMiga){
			if($linkMiga <> ''){
				$migas .= '<li><a href="'.WEB_ROOT.'/index.php?c='.$linkMiga['cnt'].'&e='.$linkMiga['acn'].'">'.$nombreMiga.'</a></li>';
			}else{
				$migas .= '<li>'.$nombreMiga.'</li>';
			}
		}
		
		$migas .= '</ul>';
		$migas .= '</div>';
	}
	
	return $migas;	
  }
}