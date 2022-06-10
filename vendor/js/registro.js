function registrarme() {
	let nombre = document.getElementById('nombres').value;
	let apellido = document.getElementById('apellidos').value;
	let genero = document.getElementById('sexo').value;
	let email = document.getElementById('correo').value;
	let password = document.getElementById('pw').value;

	if (nombre == "" || apellido == "" || genero == "Elegir" || email == "" || password == "") {
		document.getElementById('respuesta').innerHTML = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>" +
		  "<b>Error 13:</b> No has rellenado todos los campos." + 
		  "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
		    "<span aria-hidden='true'>&times;</span>" +
		  "</button>" +
		"</div>";
	}else{
		//alert(nombre + " " + apellido + " " + genero  + " " + email  + " " + password);
		$.ajax({
			url: "actions/validar_registro.php",
			type: "POST",
			data: {nombre,apellido,genero,email,password},
			success: function(respuesta) {
				$('#respuesta').html(respuesta);
			}
		});
	}
}