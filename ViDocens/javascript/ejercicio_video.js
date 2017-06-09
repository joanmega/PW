// Función que controla los campos dia, mes y año de la fecha de nacimiento para no introducir fechas erróneas
function adjustDateForm (DayForm,MonthForm,YearForm){
	// Por defecto ponemos el valor de los días a 31.
	var Days = 31;  
	// Tomamos el valor del campo del año del formulario
	var Year = YearForm.options[YearForm.selectedIndex].value; 
	// Si el mes elegido es el de febrero
	if (MonthForm.options[2].selected){
		// Si el año es bisiesto
		if ((((Year % 4) == 0) && ((Year % 100) != 0)) || ((Year % 400) == 0)){ 
			Days = 29;
		}else{ // Si no lo es
			Days = 28;
		}
	}else{
		// Si el mes seleccionado tiene 30 dias
		if (MonthForm.options[4].selected || MonthForm.options[6].selected || MonthForm.options[9].selected || MonthForm.options[11].selected){
			Days = 30;
		}
	}
	// Si hemos seleccionado un día que mayor al que tiene el mes se selecciona por defecto el último día correcto de ese mes
	if (DayForm.selectedIndex > Days){
		DayForm.options[Days].selected = true;
	}
	// Introducimos todos los días del mes hasta el numero de días calculado anteriormente
	for (var i=DayForm.options.length; i<=Days; i++){
		var x = String (i);
		DayForm.options[i] = new Option(x,x); 
	}
	// Eliminamos los días que no están comprendidos en el mes seleccionado.
	for (var i=DayForm.options.length-1; i>Days; i--){
		DayForm.options[i] = null;
	}
}

// Función que controla que en campos que deben ser de tipo texto no se introduzcan caracteres
function validacion(campo)  {
	// Si el campo no es un número no salimos de él hasta tener un número.
	if (isNaN(campo.value)) {
		alert("Error:\nEste campo debe tener sólo números.");
		campo.focus();
		return (false);
	}else{
		// Si el campo está vacío automáticamente se pone a 0 al perder el foco.
		if(campo.value == ''){
			campo.value = 0;
		}
	}
}

// Función que nos permite validar un correo electrónico basándonos en una expresion regular
function validarEmail(campo ) {
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (campo.value != ''){
		if ( !expr.test(campo.value) ){
			alert("Error: La dirección de correo " + campo.value + " es incorrecta.");
			campo.focus();
		}
	}
}

// Función que comprueba si el dni introducido es correcto.

function nif(campo) {
	var dni = campo.value;
	var numero
	var let
	var letra
	var expresion_regular_dni
	 
		// Creamos la expresion regular.
	 
	expresion_regular_dni = /^\d{8}[a-zA-Z]$/;
	 
	if(expresion_regular_dni.test (dni) == true){
	  
		 // Ahora vamos a calcular si la letra es correcta.
		 numero = dni.substr(0,dni.length-1);
		 let = (dni.substr(dni.length-1,1)).toUpperCase();
		 numero = numero % 23;
		 letra='TRWAGMYFPDXBNJZSQVHLCKET';
		 letra=letra.substring(numero,numero+1);
		if (letra!=let) {
			campo.focus();
			alert('Dni erroneo, la letra del NIF no se corresponde');
		}
	}else{
		campo.focus();
		alert('Dni erroneo, formato no válido');
	}
}			