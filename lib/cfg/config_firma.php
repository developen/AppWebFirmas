<?php
############ CONFIGURACION ############
#
#
// Firma
$firma_alto = 200;
$firma_ancho = 1000;
$firma_fondo = imagecolorallocate($frima, 255, 255, 255);

// Fuentes
$helvetica_regular = DIR_ROOT . '/theme/fonts/helvetica_regular.ttf';
$helvetica_bold = DIR_ROOT . '/theme/fonts/helvetica_bold.ttf';
$helvetica_italic = DIR_ROOT . '/theme/fonts/helvetica_italic.ttf';
$helvetica_bold_italic = DIR_ROOT . '/theme/fonts/helvetica_bold_italic.ttf';

// Linea
$linea_fuente = $helvetica_regular;
$linea_color = imagecolorallocate($frima, 0, 152, 212);
$linea_tamano = 12;
$linea_margen_superior = 5;
$linea_margen_izquierdo = 0;

// Logo
$logo_ibermutuamur = imagecreatefrompng(DIR_ROOT . '/theme/images/logo.png');
$logo_ancho = 400;
$logo_alto = 279;
$logo_margen_superior = 11;
$logo_margen_izquierdo = 0;

// Nombre
$nombre_fuente = $helvetica_regular;
$nombre_color = imagecolorallocate($frima, 0, 152, 212);
$nombre_tamano = 14;
$nombre_margen_superior = 11;
$nombre_margen_izquierdo = 20;

// Cargo
$cargo_fuente = $helvetica_bold;
$cargo_color = imagecolorallocate($frima, 0, 0, 0);
$cargo_tamano = 10;
$cargo_margen_superior = 20;
$cargo_margen_izquierdo = 20;

// Funcion
$funcion_fuente = $helvetica_regular;
$funcion_color = imagecolorallocate($frima, 0, 0, 0);
$funcion_tamano = 10;
$funcion_margen_superior = 14;
$funcion_margen_izquierdo = 20;

// Direccion
$direccion_fuente = $helvetica_regular;
$direccion_color = imagecolorallocate($frima, 0, 0, 0);
$direccion_tamano = 10;
$direccion_margen_superior = 14;
$direccion_margen_izquierdo = 20;

// Telefono
$telefono_fuente = $helvetica_bold;
$telefono_color = imagecolorallocate($frima, 0, 0, 0);
$telefono_tamano = 10;
$telefono_margen_superior = 14;
$telefono_margen_izquierdo = 5;
$telefono_label = 'Teléfono:';
$telefono_label_fuente = $helvetica_regular;
$telefono_label_color = imagecolorallocate($frima, 0, 0, 0);
$telefono_label_tamano = 9;
$telefono_label_margen_superior = 14;
$telefono_label_margen_izquierdo = 20;

// Fax
$fax_fuente = $helvetica_bold;
$fax_color = imagecolorallocate($frima, 0, 0, 0);
$fax_tamano = 10;
$fax_margen_superior = 14;
$fax_margen_izquierdo = 5;
$fax_label = 'Fax:';
$fax_label_fuente = $helvetica_regular;
$fax_label_color = imagecolorallocate($frima, 0, 0, 0);
$fax_label_tamano = 9;
$fax_label_margen_superior = 14;
$fax_label_margen_izquierdo = 0;

// Movil
$movil_fuente = $helvetica_bold;
$movil_color = imagecolorallocate($frima, 0, 0, 0);
$movil_tamano = 10;
$movil_margen_superior = 14;
$movil_margen_izquierdo = 5;
$movil_label = 'Móvil.';
$movil_label_fuente = $helvetica_regular;
$movil_label_color = imagecolorallocate($frima, 0, 0, 0);
$movil_label_tamano = 9;
$movil_label_margen_superior = 14;
$movil_label_margen_izquierdo = 0;

// Ext
$ext_fuente = $helvetica_bold;
$ext_color = imagecolorallocate($frima, 0, 0, 0);
$ext_tamano = 10;
$ext_margen_superior = 14;
$ext_margen_izquierdo = 5;
$ext_label = 'Ext:';
$ext_label_fuente = $helvetica_regular;
$ext_label_color = imagecolorallocate($frima, 0, 0, 0);
$ext_label_tamano = 9;
$ext_label_margen_superior = 14;
$ext_label_margen_izquierdo = 0;

// Email
$email_fuente = $helvetica_bold;
$email_color = imagecolorallocate($frima, 0, 0, 0);
$email_tamano = 10;
$email_margen_superior = 14;
$email_margen_izquierdo = 20;

// Web
$web_fuente = $helvetica_regular;
$web_color = imagecolorallocate($frima, 0, 0, 0);
$web_tamano = 10;
$web_margen_superior = 14;
$web_margen_izquierdo = 20;

// Aviso
$aviso_fuente = $helvetica_regular;
$aviso_color = imagecolorallocate($frima, 0, 0, 0);
$aviso_tamano = 8;
$aviso_margen_superior = 14;
$aviso_margen_izquierdo = 20;
#
#
############ CONFIGURACION ############