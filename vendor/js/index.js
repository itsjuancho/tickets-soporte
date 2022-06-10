$(document).ready(function(){
  getSystems(document.getElementById('departamento').value);
});

$("#asunto").on("keypress", function(){
  validarTitulo(this.value);
});

$("#descripcion").on("keypress", function(){
  validarCuerpo(this.value);
});

$("#btnSubmit").on("click", function(){
	crearTicket();
});