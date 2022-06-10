<?php 
include '../config/database.php';
include '../config/config.php';
include '../config/funciones.php';
session_start();
isLoginAcp();
redireccionar("/ticketsTienda/acp/buscar.php","buscador");
$deptos = recuperarTodaInfoTabla('departamento');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sistema de tickets para tienda</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../vendor/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../vendor/css/estilos.css">
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

<?php require_once '../includes/navbar-admin.php'; ?>

<div class="container">
	<div class="custom-control custom-switch">
	  <input type="checkbox" class="custom-control-input" id="customSwitch1">
	  <label class="custom-control-label" for="customSwitch1">Activado</label>
	</div>
</div>

<?php require_once '../includes/footer.php'; ?>

<script src="https://getbootstrap.com/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
<script src="../vendor/js/funciones.js"></script>
</body>
</html>