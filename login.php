<?php
	include 'config/database.php';
	include 'config/config.php';
	include 'config/funciones.php';
	redireccionar("/ticketsTienda/login.php","login");
	session_start();
	if (isset($_SESSION['id_user']) && isset($_SESSION['nivel_rol'])) {
		header('location: inicio');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ingresar</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?php echo url_entera; ?>/vendor/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="vendor/css/login.css">
	<script src="https://kit.fontawesome.com/56717898b6.js" crossorigin="anonymous"></script>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>

<form class="form-signin text-center" onsubmit="return false;">
	<div id="respuesta"></div>
	<?php if (isset($_SESSION['mensaje'])) { ?>
		<div id="resultado" class="alert alert-success alert-dismissible fade show" role="alert">
		  <?php echo $_SESSION['mensaje']; ?>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
	<?php session_unset(); } ?>
	<div class="card">
		<div class="card-header">
			<i class="fas fa-desktop"></i> Ingresar
		</div>
		<div class="card-body">
			<label for="inputEmail" class="sr-only">Correo electrónico</label>
  			<input type="email" id="inputEmail" class="form-control" placeholder="Correo electrónico" name="email" required autofocus>

  			<label for="inputPassword" class="sr-only">Password</label>
  			<input type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required name="password">
  			<input class="btn btn-lg btn-success btn-block" type="button" id="ingresar" value="Acceder" onclick="acceder()">
		</div>
		<div class="card-footer">
			<small>¿No tienes cuenta? <a href="registro">¡Regístrate!</a></small>
		</div>
	</div>
	<br>
	<small class="text-muted"><?php echo NOMBRE_APP; ?> by <?php echo DESIGNED_BY; ?> &copy; <?php echo YEAR; ?><p>Todos los derechos reservados</p></small>
</form>

<script src="https://getbootstrap.com/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
<script src="vendor/js/login.js"></script>

</body>
</html>