<?php

class archivos
{
  // ## getArchivo ##
  static public function getArchivo($nombre, $tipo, $texto="", $tam="") {
    $tipo = strtolower ($tipo);
    $permiso = array ('leer'=>'r','sustituir'=>'w+','grabar'=>'a+', 'grabarprincipio'=>'c+', 'borrar'=>'0');
    if($permiso[$tipo] != '0'){
        if($permiso[$tipo] == 'r'){
            //leer
            $read = @file_get_contents ($nombre);
            return $read;
        } else {
            //grabar
            $fp = fopen ($nombre,$permiso[$tipo]);
            if($tam == '')
			{
			  $read = fwrite ($fp, $texto);
			}
			else
			{
              $read = fwrite ($fp, $texto, $tam);
			}
            fclose ($fp);
            return $read;
        }
    } else {
        $read = unlink ($nombre);
        return $read;
    }
  }
  
  static public function obtenerCadena($contenido, $inicio, $fin){
  $r = explode($inicio, $contenido);
  if (isset ($r[1])){
    $r = explode($fin, $r[1]);
    return $r[0];
  }
  return '';
  }
}