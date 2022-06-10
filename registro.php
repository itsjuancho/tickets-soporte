<?php
	include 'config/database.php';
	include 'config/config.php';
	session_start();
	if (isset($_SESSION['id_user']) && isset($_SESSION['nivel_rol'])) {
		header('location: inicio');
	}
	$sexSQL = "SELECT * FROM genero";
	$sexos = mysqli_query($conexion,$sexSQL) or die(mysqli_error($conexion));
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sistema de tickets para tienda</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="vendor/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="vendor/css/estilos.css">
	<script src="https://kit.fontawesome.com/56717898b6.js" crossorigin="anonymous"></script>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<div class="container">
	  <a class="navbar-brand" href="inicio">SoporTICK</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarCollapse">
	    <ul class="navbar-nav mr-auto">
	    </ul>
	    <div class="form-inline mt-2 mt-md-0">
	 		<div style="color: #ffffff;">Para ingresar, debes de registrarte primero.</div>
	  	</div>
	  </div>
	</div>
</nav>

<div class="container">
	<?php if (isset($_SESSION['mensaje'])) { ?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
		  <?php echo $_SESSION['mensaje']; ?>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
	<?php session_unset(); } ?>
	<div id="respuesta"></div>
	<div class="card">
	  <div class="card-header">
	    <i class="fas fa-user-edit"></i> Registrarme en <?php echo NOMBRE_APP; ?>
	  </div>
	  <div class="card-body">
	    <form class="needs-validation" onsubmit="return false;">
		  <div class="form-row">
		    <div class="col-md-5 mb-3">
		      <label for="nombres">Nombre(s)</label>
		      <input type="text" class="form-control" id="nombres" placeholder="Nombre" name="nombres" required>
		      <div class="invalid-feedback">
		        Debes de ingresar tu(s) nombre(s).
		      </div>
		    </div>
		    <div class="col-md-5 mb-3">
		      <label for="apellidos">Apellidos</label>
		      <input type="text" class="form-control" id="apellidos" placeholder="Apellidos" name="apellidos" required>
		      <div class="invalid-feedback">
		        Debes de ingresar tus apellidos.
		      </div>
		    </div>
		    <div class="col-md-2 mb-3">
		      <label>Sexo</label>
		      <select class="custom-select" name="sexo" id="sexo">
		      		<option disabled selected>Elegir</option>
		      <?php while ($sexo = mysqli_fetch_array($sexos)) { ?>
		      		<option value="<?php echo $sexo['id_genero']; ?>" ><?php echo $sexo['genero']; ?></option>
		      <?php } ?>
		        </select>
		    </div>
		    <div class="col-md-6 mb-3">
		      <label for="correo">Correo electrónico</label>
		      <div class="input-group">
		      	<input type="email" class="form-control" id="correo" placeholder="Correo electrónico" name="correo" aria-describedby="inputGroupPrepend" required>
		        <div class="invalid-feedback">
		          Debes de ingresar tu usuario de correo electrónico.
		        </div>
		      </div>
		    </div>
		    <div class="col-md-6 mb-3">
		    	<label for="password">Contraseña</label>
		    	<input type="password" class="form-control" placeholder="Debe de contener dígitos, números." name="pw" id="pw" required>
		    	<div class="invalid-feedback">
		          Debes de ingresar tu número de celular.
		        </div>
		    </div>
		  </div>
		  <input type="button" class="btn btn-success btn-lg btn-block " value="Registrarse" onclick="registrarme()"></input>
		</form>
	  </div>
	  <div class="card-footer">
	  	<small><center>¿Ya tienes una cuenta? <a href="login">Inicia sesión</a></center></small>
	  </div>
	</div>
</div>

<script src="vendor/js/registro.js"></script>
<?php include 'includes/footer.php'; ?>

<script src="https://getbootstrap.com/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>

</body>
</html>