<?php
include '../config/database.php';
include '../config/config.php';
include '../config/funciones.php';
session_start();
isLogin();
redireccionar("/ticketsTienda/soporte/nuevo.php","nuevo");
$departamentos = recuperarTodaInfoTabla('departamento');
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

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<div class="container">
	  <a class="navbar-brand" href="../inicio">SoporTICK</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarCollapse">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item">
	        <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="mis">Mis tickets</a>
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
	          <a class="dropdown-item" href="ajustes">Configuración</a>
	          <div class="dropdown-divider"></div>
		        <a class="dropdown-item" href="../salir">Cerrar sesión</a>
		      </div>
	      </li>
	  	</ul>
	  	</div>
	  </div>
	</div>
</nav>

<div class="container">
    <div>
    	<center><h3>Crear nuevo ticket</h3></center>
    	<hr>
    	<div class="card">
    		<div class="card-header">Rellene por favor todos los campos. *</div>
    		<div class="card-body">
    			<form id="formTicket" onsubmit="return false;">
    				<div class="form-row">
    					<div class="col-md-6 mb-3">
    						<label for="departamento">Seleccione un departamento</label>
    						<select class="custom-select" id="departamento" onchange="getSystems(this.value)">
    					<?php while ($d = mysqli_fetch_array($departamentos)) { ?>
    							<option value="<?php echo $d['idDepartamento']; ?>"><?php echo $d['departamento']; ?></option>
    					<?php } ?>
    						</select>
    					</div>
    					<div class="col-md-6 mb-3">
    						<label for="sistema">Seleccione un sistema</label>
    						<select class="custom-select" id="sistema">
    						</select>
    					</div>
    					<div class="col-md-12 mb-3">
    						<label for="asunto">Escriba el título o asunto del ticket <small>(60 caracteres máx)</small></label>
    						<input type="text" class="form-control" id="asunto" maxlength="60"></input>
    					</div>
    					<div class="col-md-12 mb-3">
    						<label for="asunto">Describa su problema <small>(1500 caracteres máx)</small></label>
    						<textarea class="form-control" id="descripcion" rows="6" maxlength="1500"></textarea>
    					</div>
    				</div>
    		</div>
    		<div class="card-footer">
    			<input type="button" class="btn btn-success btn-lg btn-block " value="Crear" id="btnSubmit"></input>
    		</div>
    		</form>
    	</div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

  <script src="https://getbootstrap.com/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
  <script src="../vendor/js/index.js"></script>
  <script src="../vendor/js/funciones.js"></script>
</body>
</html>