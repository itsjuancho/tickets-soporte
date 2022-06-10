<?php
include '../../config/database.php';
include '../../config/config.php';
include '../../config/funciones.php';
session_start();
isLoginTwo();
redireccionar("/ticketsTienda/acp/soporte/viewTicket.php","../inicio");
redireccionar("/ticketsTienda/acp/soporte/viewTicket.php?ticket_id=".$_GET['ticket_id'],"ticket/".$_GET['ticket_id']);

if (isset($_GET)) {
	if(is_numeric($_GET['ticket_id'])){
		$a = getTicket($_GET['ticket_id']);
		if (mysqli_num_rows($a) > 0) {
			$fila = mysqli_fetch_array($a);
			if ($_SESSION['nivel_rol'] < 2) {
				$_SESSION['msgError'] = "No tienes los permisos suficientes para ver este ticket.";
				header('location: ../../inicio');
			}
			$replies = getRepliesTicket($_GET['ticket_id']);
			$deptos = recuperarTodaInfoTabla('departamento');
			$admins = getAdmins();
		}else{
			$_SESSION['msgError'] = "No existe este ticket.";
			header('location: ../../inicio');
		}
	}else{
		echo "No es una ID";
	}
}else{
	echo "No Hay";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sistema de tickets para tienda</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../../../vendor/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../../../vendor/css/estilos.css">
	<script src="https://kit.fontawesome.com/56717898b6.js" crossorigin="anonymous"></script>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<style>
		body {
  font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif; 
}
	</style>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
  	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.css" id="theme-styles">
</head>
<body>

<?php require_once '../../includes/navbar-admin.php'; ?>

<div class="container">
	<?php if (isset($_SESSION['msgReplyTicket']) && isset($_SESSION['typeMsgReply'])) { ?>
		<div id="resultado" class="alert alert-<?php echo $_SESSION['typeMsgReply']; ?> alert-dismissible fade show" role="alert">
		  <?php echo $_SESSION['msgReplyTicket']; ?>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
	<?php unset($_SESSION['msgReplyTicket']); unset($_SESSION['typeMsgReply']); } ?>
	<div class="card border-dark mb-3">
	  <div class="card-header bg-dark text-white">Información técnica (ticket #<?php echo $fila['idTicket']; ?>) | <?php echo getStatus($fila['estadoTicket']); ?></div>
	  <div class="card-body">
	    <div class="form-row">
		    <div class="form-group col-md-4">
		    	<label id="correoElectronico" class="col-form-label-sm">Correo electrónico</label>
		    	<input type="text" class="form-control form-control-sm" id="correoElectronico" value="<?php echo $fila['correo']; ?>" disabled readonly>
		    </div>
		    <div class="form-group col-md-4">
		    	<label id="asuntoTicket" class="col-form-label-sm">Asunto</label>
		    	<input type="text" class="form-control form-control-sm" id="asuntoTicket" value="<?php echo $fila['asunto']; ?>" disabled readonly>
		    </div>
		    <div class="form-group col-md-4">
		    	<label id="fechaEnvio" class="col-form-label-sm">Fecha enviado</label>
		      <input type="text" class="form-control form-control-sm" id="fechaEnvio" value="<?php echo $fila['fechaCreacion']; ?>" disabled readonly>
		    </div>
		  </div>
		  <div class="form-row">
		  	<div class="form-group col-md-3">
		  		<label id="dptoTicket" class="col-form-label-sm">Departamento</label>
		  		<input type="text" class="form-control form-control-sm" id="dptoTicket" value="<?php echo $fila['departamento']; ?>" disabled readonly>
		  	</div>
		  	<div class="form-group col-md-3">
		  		<label id="sistemaTicket" class="col-form-label-sm">Sistema</label>
		  		<input type="text" class="form-control form-control-sm" id="sistemaTicket" value="<?php echo $fila['sistema']; ?>" disabled readonly>
		  	</div>
		  	<div class="form-group col-md-3">
		  		<label id="prioridadTicket" class="col-form-label-sm">Prioridad</label>
		  		<input type="text" class="form-control form-control-sm" id="prioridadTicket" value="<?php echo getPriority($fila['prioridad']); ?>" disabled readonly>
		  	</div>
		  	<div class="form-group col-md-3">
		  		<label id="atendidoAdmin" class="col-form-label-sm">Atendido por</label>
		  		<input type="text" class="form-control form-control-sm" id="atendidoAdmin" value="<?php echo getAdminName($fila['id_admin']); ?>" disabled readonly>
		  	</div>
		  </div>
		<div class="form-row">
		<?php if ($fila['estadoTicket'] <= 1): ?>
		<div class="form-group col-md-4 mb-1">
			<?php if ($fila['id_admin'] == NULL): ?>
			<form action="../atender_ticket" method="post">
			  <input type="hidden" name="tid" id="attend_tid" value="<?php echo sha1(sha1(md5(sha1(md5($fila['unique_key']))))); ?>">
			  <input type="hidden" name="t_id" id="attend_tickid" value="<?php echo $fila['idTicket']; ?>">
			  <input type="submit" class="btn btn-success btn-sm btn-block" value="Atender">
			</form>
			<?php else: ?>
			<button class="btn btn-success btn-sm btn-block" disabled>Atendido</button>
			<?php endif ?>
		</div>
		<div class="form-group col-md-4 mb-1">
			<form action="../cerrar_ticket" method="post">
			  <input type="hidden" name="tid" value="<?php echo md5(sha1(md5(sha1(md5($fila['unique_key']))))); ?>">
			  <input type="hidden" name="t_id" value="<?php echo $fila['idTicket']; ?>">
			  <input type="submit" class="btn btn-danger btn-sm btn-block" value="Cerrar">
			</form>
		</div>
		<!--<div class="form-group col-md-3 mb-0">
			<button type="button" class="btn btn-dark btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="Para archivarlo, debes cerrarlo primero.">
			  Archivar
			</button>
		</div>-->
		<div class="form-group col-md-4 mb-1">
			<button type="button" class="btn btn-editar btn-sm btn-block" data-toggle="modal" data-target=".bd-example-modal-lg" id="btnEditar">Editar</button>
		</div>
		<?php else: ?>
		<div class="form-group col-md-6 mb-1">
			<form action="../abrir_ticket" method="post">
			  <input type="hidden" name="tid" value="<?php echo sha1(md5(sha1(md5($fila['unique_key'])))); ?>">
			  <input type="hidden" name="t_id" value="<?php echo $fila['idTicket']; ?>">
			  <input type="submit" class="btn btn-success btn-sm btn-block" value="Abrir ticket">
			</form>
		</div>
		<!--<div class="form-group col-md-3 mb-0">
			<button type="button" class="btn btn-danger btn-sm btn-block" disabled>Cerrado</button>
		</div>-->
		<div class="form-group col-md-6 mb-1">
			<form action="../archivar_ticket" method="post">
			  <input type="hidden" name="tid" value="<?php echo md5(sha1(md5($fila['unique_key']))); ?>">
			  <input type="hidden" name="t_id" value="<?php echo $fila['idTicket']; ?>">
			  <input type="submit" class="btn btn-dark btn-sm btn-block" value="Archivar">
			</form>
		</div>
		<?php endif ?>
		</div>
	  </div>
	</div>
	<div class="card mb-3">
	  <h6 class="card-header"><?php echo $fila['nombres']." ".$fila['apellidos']; ?> | Usuario</h6>
	  <div class="card-body">
	    <h6 class="card-title">Descripción del problema:</h6>
	    <hr>
	    <p class="card-text"><?php echo $fila['descripcion']; ?></p>
	  </div>
	</div>
	<?php if (mysqli_num_rows($replies) > 0): ?>
	<?php while ($reply = mysqli_fetch_array($replies)) { ?>
	<div class="card mb-3<?php if($reply['esAdmin'] == "1"){ echo " border-greenlight"; } ?>">
		<h6 class="card-header <?php if($reply['esAdmin'] == "1"){ echo "bg-greenlight"; } ?>"><?php echo $reply['nombres']." ".$reply['apellidos']; ?> | <?php typeUser($reply['esAdmin']); ?></h6>
	  <div class="card-body">
	    <p class="card-text"><?php echo $reply['respuesta']; ?></p>
	  </div>
	  <div class="card-footer<?php if($reply['esAdmin'] == "1"){ echo " bg-greenlight"; } ?>"><small>Fecha de respuesta: <?php echo $reply['fechaRespuesta']; ?></small></div>
	</div>
	<?php } ?>
	<?php endif ?>
	<?php if ($fila['estadoTicket'] == 1 || $fila['estadoTicket'] == 0): ?>
	<div class="card border-dark">
		<form action="../validar_respuesta" method="post">
		<div class="card-header bg-dark text-white"><small><i class="far fa-edit"></i> Realizar nueva respuesta</small></div>
		<div class="card-body"><textarea class="form-control" rows="4" placeholder="Escribe aquí..." name="respuesta" id="respuesta" maxlength="1000"></textarea></div>
		<input type="hidden" name="tid" value="<?php echo md5(md5(sha1($fila['unique_key']))); ?>">
		<input type="hidden" name="t_id" value="<?php echo $fila['idTicket']; ?>">
		<div class="card-footer">
    	<input type="submit" class="btn btn-dark btn-sm btn-block " value="Responder" id="btnSubmit"></input>
    </div>
  	</form>
	</div>
	<?php else: ?>
	<div class="alert alert-danger" role="alert">
  	<b><small>El ticket ha sido cerrado y no admite más respuestas, si el problema no está resuelto crea otro ticket indicando el número de este.</small></b>
	</div>
	<?php endif ?>
	<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
		    <div class="modal-header">
		    <h5>Editando ticket #<?php echo $fila['idTicket']; ?></h5>
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
		    </div>
		    <div class="modal-body">
		    	<form action="../editar_ticket" method="post">
		    	<div class="form-row">
		    		<div class="form-group col-md-10 mb-1">
		    			<label for="editarAsunto" class="col-form-label-sm">Asunto</label>
		    			<input type="text" name="asunto" id="editarAsunto" class="form-control form-control-sm" value="<?php echo $fila['asunto']; ?>" maxlength="60">
		    		</div>
		    		<div class="form-group col-md-2 mb-1">
		    			<label for="editarPrioridad" class="col-form-label-sm">Prioridad</label>
		    			<select name="prioridad" id="editarPrioridad" class="form-control form-control-sm">
		    				<option value="0">Sin asignar</option>
		    				<option value="1">Baja</option>
		    				<option value="2">Media</option>
		    				<option value="3">Alta</option>
		    				<option value="4">Urgente</option>
		    			</select>
		    		</div>
		    	</div>
		    	<div class="form-row mb-3">
		    		<div class="form-group col-md-4 mb-1">
		    			<label for="editarDepto" class="col-form-label-sm">Departamento</label>
		    			<select id="editarDepto" class="form-control form-control-sm" name="depto" onchange="llenaSistemas(this.value);">
		    			<?php while($d = mysqli_fetch_array($deptos)){ ?>
		    				<option value="<?php echo $d['idDepartamento']; ?>"><?php echo $d['departamento']; ?></option>
		    			<?php } ?>
		    			</select>
		    		</div>
		    		<div class="form-group col-md-4 mb-1">
		    			<label for="editarSis" class="col-form-label-sm">Sistema</label>
		    			<select name="sistema" id="editarSis" class="form-control form-control-sm">
		    			</select>
		    		</div>
		    		<div class="form-group col-md-4 mb-1">
		    			<label for="editarAdmin" class="col-form-label-sm">Atendido / asignado</label>
		    			<select id="editarAdmin" class="form-control form-control-sm" name="idAdmin">
		    				<option value="">Sin atender</option>
		    			<?php while($adm = mysqli_fetch_array($admins)){ ?>
		    				<option value="<?php echo $adm['user_id'] ?>"><?php echo $adm['nombres']." ".$adm['apellidos']; ?></option>
		    			<?php } ?>
		    			</select>
		    		</div>
		    	</div>
		    	<input type="hidden" name="tid" value="<?php echo md5(sha1(md5(sha1($fila['unique_key'])))); ?>">
			  	<input type="hidden" name="t_id" value="<?php echo $fila['idTicket']; ?>">
			  	<input type="submit" class="btn btn-editar btn-sm btn-block" value="Editar ticket">
		    	</form>
		    </div>
	    </div>
	  </div>
	</div>
</div>

<?php require_once '../../includes/footer.php'; ?>


<script src="https://getbootstrap.com/docs/4.5/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../../vendor/js/funciones.js"></script>
<script>
	function llenaSistemas(id) {
		if (id != 0) {
			$.ajax({
				url: "../../../actions/obtenerSistemas.php",
				type: "POST",
				data: {id},
				success: function(resp) {
					var json = JSON.parse(resp);
					let salida = '';
					if (json.status == 1) {
						for (var i = 0; i < json.data.length; i++) {
							//console.log(json.data[i].sistema);
							salida += "<option value='"+json.data[i].idSistema+"'>"+json.data[i].sistema+"</option>"
						}
						$('#editarSis').html(salida);
					}else{
						actionError(json.mensaje,json.code_error);
					}
				}
			});
		}
	}

	$(document).ready(function(){
		$("#editarPrioridad option[value=<?php echo $fila['prioridad']; ?>]").attr("selected",true);
		$("#editarDepto option[value=<?php echo $fila['idDepartamento']; ?>]").attr("selected",true);
		llenaSistemas(document.getElementById('editarDepto').value);
		$("#editarAdmin option[value=<?php echo $fila['id_admin']; ?>]").attr("selected",true);
	});

	$("#editarAsunto").on("keypress", function(){
  		validarTitulo(this.value);
	});

	$("#respuesta").on("keypress", function(){
  		validarReply(this.value);
	});

	$("#btnEditar").on("click", function(){
  		$("#editarSis option[value=<?php echo $fila['idSistema']; ?>]").attr("selected",true);
	});

	//$('[data-toggle="tooltip"]').tooltip();
</script>
</body>
</html>