function getSystems(id){
	if (id == "" || id == 0 || id == "0" || id == 'undefined') {
		actionError("El campo requerido no es válido",17);
	}else{
		$.ajax({
			url: "../actions/obtenerSistemas.php",
			type: "POST",
			data: {id},
			success: function(resp){
				//console.log(resp);
				var json = JSON.parse(resp);
				let salida = '';
				console.log(json);
				if (json.status == 1) {
					for (var i = 0; i < json.data.length; i++) {
						//console.log(json.data[i].sistema);
						salida += "<option value='"+json.data[i].idSistema+"'>"+json.data[i].sistema+"</option>"
					}
					$('#sistema').html(salida);
				}else{
					actionError(json.mensaje,json.code_error);
					console.log(id-1);
					//document.getElementById('departamento').
				}
				//console.log(Object.keys(json.resp.data).length);
				//console.log(salida);
			}
		});
	}
}

function actionError(msg,status){
	if (msg != "" && status != "") {
		Swal.fire({
		  icon: 'error',
		  title: 'Error '+status,
		  text: msg,
		});
	}
}

function actionOk(msg,title,status){
	if (msg == undefined) {
		console.log("Hola");
	}
	if (msg != "" && status != "" && title != "") {
		Swal.fire({
		  icon: status,
		  title: title,
		  text: msg,
		});
	}
}

function validarTitulo(titulo){
	if (titulo.length >= 60) {
		actionError("Has llegado al total de líneas permitidas. No puedes ingresar más.",20);
	}
}

function validarCuerpo(descripcion){
	if (descripcion.length >= 1500) {
		actionError("Has llegado al total de líneas permitidas. No puedes ingresar más.",20);
	}
}

function validarReply(reply) {
	if (reply.length >= 1000) {
		actionError("Has llegado al total de líneas permitidas. No puedes ingresar más.",20);
	}
}

function crearTicket() {
	let sistema = document.getElementById('sistema').value;
	let asunto = document.getElementById('asunto').value;
	let descripcion = document.getElementById('descripcion').value;

	if (sistema.length == 0 || asunto.length == 0 || descripcion.length == 0) {
		actionError("Tienes que rellenar los campos del ticket!",25);
	}else{
		let timerInterval;
		Swal.fire({
		  title: 'Generando ticket...',
		  //html: 'I will close in <b></b> milliseconds.',
		  html: 'No tardará mucho, espera.',
		  timer: 3000,
		  timerProgressBar: true,
		  onBeforeOpen: () => {
		    Swal.showLoading()
		    timerInterval = setInterval(() => {
		      const content = Swal.getContent()
		    }, 100)
		  },
		  onClose: () => {
		    clearInterval(timerInterval)
		  }
		}).then((result) => {
		  // Read more about handling dismissals below 
		  if (result.dismiss === Swal.DismissReason.timer) {
		  	$.ajax({
					url: "../actions/generar_ticket.php",
					type: "POST",
					data: {sistema,asunto,descripcion},
					success: function(reply) {
						var rep = JSON.parse(reply);
						console.log(rep)
						if (rep.status == 1) {
				    	Swal.fire({
						  	icon: 'success',
						  	title: 'Hecho!',
						  	text: 'Ticket creado correctamente'
							}).then(function() {
								location.href = 'tickets';
							});
				    }else{
				    	Swal.fire({
				    		icon: 'error',
								title: 'Ups!',
								text: rep.msg,
								confirmButtonText: 'Revisar contenido'
				    	});
				    }
					}
				});
		  }
		});
	}
}

function actConfig() {
		const Toast = Swal.mixin({
  		toast: true,
  		position: 'botton',
  		showConfirmButton: false,
  		timer: 3500,
  		timerProgressBar: true,
  		onOpen: (toast) => {
    		toast.addEventListener('mouseenter', Swal.stopTimer)
    		toast.addEventListener('mouseleave', Swal.resumeTimer)
  		}
		})

		Toast.fire({
		  icon: 'success',
		  title: 'Perfil actualizado!'
		})
}