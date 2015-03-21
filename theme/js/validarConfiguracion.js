function validarConfiguracion()
{
	var logo_margen_superior = document.getElementById("logo_margen_superior").value;
	var campos_margen_izquierdo = document.getElementById("campos_margen_izquierdo").value;
	var nombre_margen_superior = document.getElementById("nombre_margen_superior").value;
	var cargo_margen_superior = document.getElementById("cargo_margen_superior").value;
	var funcion_margen_superior = document.getElementById("funcion_margen_superior").value;
	var direccion_margen_superior = document.getElementById("direccion_margen_superior").value;
	var telefonos_margen_superior = document.getElementById("telefonos_margen_superior").value;
	var email_margen_superior = document.getElementById("email_margen_superior").value;
	var web_margen_superior = document.getElementById("web_margen_superior").value;
	var aviso_margen_superior = document.getElementById("aviso_margen_superior").value;

	if(validarCampo(logo_margen_superior) == 'vacio'){ alert("Los campos no pueden quedar vacios."); return false; }else if(validarCampo(logo_margen_superior) == 'espacios'){ alert ("Los campos no pueden contener espacios en blanco."); return false; }else if(validarCampo(logo_margen_superior) == 'nonumero'){ alert("Los campos deben contener sólo números enteros."); return false; }
}

function validarCampo(campo) {
	var espacios = false;
	var cont = 0;
		 
	while (!espacios && (cont < campo.length)) {
	  if (campo.charAt(cont) == " ")
		espacios = true;
	  cont++;
	}
		 
	if (espacios) {
	  return 'espacios';
	}
	
	if (campo.length == 0) {
	  return 'vacio';
	}
	
	var patron = /^\d*$/;
	if ( !patron .test(campo)) {
	  return 'nonumero';
	}
}