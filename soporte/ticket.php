<?php
include '../config/database.php';
include '../config/config.php';
include '../config/funciones.php';
session_start();
isLoginTwo();
redireccionar("/ticketsTienda/soporte/ticket.php","../inicio");
redireccionar("/ticketsTienda/soporte/ticket.php?ticket_id=".$_GET['ticket_id'],"ticket/".$_GET['ticket_id']);

if (isset($_GET)) {
	if(is_numeric($_GET['ticket_id'])){
		if (isset($_GET['action'])) {
			if ($_GET['action'] == "cerrar") {
				echo "<script>alert('Se ha enviado el parámetro'); window.location = '../../ticket/".$_GET['ticket_id']."';</script>";
			}
		}
		$a = getTicket($_GET['ticket_id']);
		if (mysqli_num_rows($a) > 0) {
			$fila = mysqli_fetch_array($a);
			if ($fila['user_id'] <> $_SESSION['id_user']) {
				$_SESSION['msgError'] = "No tienes los permisos suficientes para ver este ticket.";
				header('location: ../../inicio');
			}
			$replies = getRepliesTicket($_GET['ticket_id']);
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
	<link rel="stylesheet" type="text/css" href="../../vendor/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../../vendor/css/estilos.css">
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

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<div class="container">
	  <a class="navbar-brand" href="../../inicio"><?php echo NOMBRE_APP; ?></a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarCollapse">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item">
	        <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="../mtickets">Mis tickets</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Estás creando un nuevo ticket.</a>
	      </li>
	    </ul>
	    <div class="form-inline mt-2 mt-md-0">
	    <ul class="navbar-nav">
	      <li class="nav-item dropdown">
	        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          Menú
	        </a>
	        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	          <a class="dropdown-item" href="../../ajustes">Configuración</a>
	          <div class="dropdown-divider"></div>
		        <a class="dropdown-item" href="../../salir">Cerrar sesión</a>
		      </div>
	      </li>
	  	</ul>
	  	</div>
	  </div>
	</div>
</nav>

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
		  <?php if ($fila['estadoTicket'] <= 1): ?>
		  <form action="http://localhost/ticketsTienda/soporte/cerrar_ticket" method="post">
		  <input type="hidden" name="tid" value="<?php echo md5(sha1(md5($fila['unique_key']))); ?>">
		  <input type="hidden" name="t_id" value="<?php echo $fila['idTicket']; ?>">
		  <input type="submit" class="btn btn-danger btn-sm btn-block" value="Cerrar">
			</form>
		  <?php else: ?>
		  <button type="button" class="btn btn-danger btn-sm btn-block" disabled>Cerrado</button>
		  <?php endif ?>
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
		<input type="hidden" name="tid" value="<?php echo md5(sha1($fila['unique_key'])); ?>">
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
</div>

<?php include '../includes/footer.php'; ?>

  <script src="https://getbootstrap.com/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
 	<script src="../../vendor/js/funciones.js"></script>
</body>
</html>