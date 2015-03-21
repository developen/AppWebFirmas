function validarPasswd()
{
	var p1 = document.getElementById("nuevo_admin_password").value;
	var p2 = document.getElementById("nuevo_admin_password2").value;

	var espacios = false;
	var cont = 0;
		 
	while (!espacios && (cont < p1.length)) {
	  if (p1.charAt(cont) == " ")
		espacios = true;
	  cont++;
	}
		 
	if (espacios) {
	  alert ("La contraseña no puede contener espacios en blanco.");
	  return false;
	}

	if (p1.length == 0 || p2.length == 0) {
	  alert("Los campos de la nueva contraseña no pueden quedar vacios.");
	  return false;
	}

	if (p1 != p2) {
	  alert("Las contraseñas deben de coincidir.");
	  return false;
	}
}

