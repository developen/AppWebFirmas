<?php
class firma
{  
  // ## getEstilos ##
  static public function getEstilos()
  {
    $estilos = '
		<style>
		div.box_firma{
			height: auto;
			clear: both;
			float: left;
		}

		div.box_firma hr{
			border:#000 1px;
			border-style: none none dashed;
		}

		div.box_firma > div.logo{
			height: 100%;
			float: left;
		}

		div.box_firma > div.firma{
			height: 100%;
			float: left;
		}
		</style>
	';
	
	return $estilos;
  }
  
  // ## getScript ##
  static public function getScript()
  {
	$script = '
		<script>
			$(document).ready(function(){
				$(".logo").height( $(".firma").height() );
			});
		</script>
	';
	
	return $script;
  }
  
  // ## getFirma ##
  static public function getFirma($empleados, $idEmpleado)
  {
	$firma = self::getEstilos();
	$firma .= self::getScript();
	$firma .= '
		<div class="box_firma">
			<hr>
			<div class="logo"><img src="'.WEB_ROOT.'/theme/images/logo_ibermutuamur.png" height="100%"></div>
			<div class="firma">
				<div class="firma_nombre">'.$empleados[$idEmpleado]['Nombre'].'</div>
				<div class="firma_cargo">'.$empleados[$idEmpleado]['Cargo'].'</div>
				<div class="firma_ibermutuamur">'.$empleados[$idEmpleado]['Ibermutuamur'].'</div>
				<div class="firma_direccion">'.$empleados[$idEmpleado]['Direccion'].'</div>
				<div class="firma_telefonos">Teléfono: <span class="firma_telefono">'.$empleados[$idEmpleado]['Telefono'].'</span> - Fax: <span class="firma_fax">'.$empleados[$idEmpleado]['Fax'].'</span> - Móvil. <span class="firma_movil">'.$empleados[$idEmpleado]['Movil'].'</span> - Ext: <span class="firma_ext">'.$empleados[$idEmpleado]['Ext'].'</span></div>
				<div class="firma_email">'.$empleados[$idEmpleado]['Email'].'</div>
				<div class="firma_web">www.ibermutuamur.es</div>
				<div class="firma_pie">Mutua de accidentes de trabajo y enfermedades profesionales de la Seguridad Social nº 274.</div>
			</div>
		</div>
	';
	
	return $firma;
	//return self::getGenerarImagen($firma);
  }
  
  
  // ## getGenerarImagen ##
  static public function getGenerarImagen($firma)  
  {
	// Crear la imagen 
	$im = imagecreatetruecolor(400, 400); 

	// Crear algunos colores 
	$blanco = imagecolorallocate($im, 255, 255, 255);
	$gris   = imagecolorallocate($im, 128, 128, 128);
	$negro  = imagecolorallocate($im, 0, 0, 0);
	imagefilledrectangle($im, 0, 0, 399, 399, $blanco);

	// El texto a pintar 
	$texto = $firma; 
	// Reemplaze la ruta con su propio ruta a la fuente 
	$fuente = DIR_ROOT . '/theme/fonts/times.ttf'; 

	// Agregar el texto
	imagettftext($im, 20, 0, 10, 20, $negro, $fuente, $texto);

	// Usar imagepng() resulta en texto más claro, en comparación con imagejpeg() 
	imagepng($im, DIR_ROOT . "/upload/tmp/prueba.png"); 
	imagedestroy($im);
  }
}