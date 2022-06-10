function acceder() {
	var correo = document.getElementById('inputEmail').value;
	var pw = document.getElementById('inputPassword').value;
	if (correo == "" || pw == "") {
		document.getElementById('respuesta').innerHTML = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>" +
		  "<b>Error 13:</b> No has rellenado los campos." + 
		  "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
		    "<span aria-hidden='true'>&times;</span>" +
		  "</button>" +
		"</div>";
	}else{
		$.ajax({
			url: "actions/validar_login.php",
			type: "POST",
			data: {correo,pw},
			success: function(reply){
				var json = JSON.parse(reply);
				if (json.status == 1) {
					window.location.href = json.goto;
				}else{
				document.getElementById('respuesta').innerHTML = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>" +
		  		"<b>Error "+json.code+":</b> "+json.msg+"" + 
		  		"<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
		    		"<span aria-hidden='true'>&times;</span>" +
		  		"</button>" +
				"</div>";
				}
			}
		});
	}
}