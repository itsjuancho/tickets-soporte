<?php
	include 'config/database.php';
	include 'config/config.php';
	include 'config/funciones.php';
	redireccionar("/ticketsTienda/index.php","inicio");
	session_start();
	if (!isset($_SESSION['id_user']) && !isset($_SESSION['nivel_rol'])) {
		header('location: login');
	}
	$tickets = ultimosTickets($_SESSION['id_user']);
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
	  <a class="navbar-brand" href="#">SoporTICK</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarCollapse">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item active">
	        <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="soporte/mtickets">Mis tickets</a>
	      </li>
	      <?php if ($_SESSION['nivel_rol'] >= 2): ?>
	      <li class="nav-item">
	        <a class="nav-link" href="acp">Zona Admin</a>
	      </li>
	      <?php endif ?>
	      <li class="nav-item">
	        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
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
		        <a class="dropdown-item" href="salir">Cerrar sesión</a>
		      </div>
	      </li>
	  	</ul>
	  	</div>
	    <?php /* ?><form class="form-inline mt-2 mt-md-0">
	      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
	      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
	    </form><?php */ ?>

	  </div>
	</div>
</nav>

<div class="container">
	<?php if (isset($_SESSION['msgError'])) { ?>
		<div id="resultado" class="alert alert-danger alert-dismissible fade show" role="alert">
		  <?php echo $_SESSION['msgError']; ?>
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
	<?php unset($_SESSION['msgError']); } ?>
    <div class="jumbotron">
    	<h1 class="display-5">Centro de soporte</h1>
    	<p>¿Tienes un problema en el que podamos ayudar a resolverlo? ¡Esta es la sección correcta!</p>
    	<a class="btn btn-primary btn-lg" href="soporte/nuevo" role="button">Crear nuevo ticket &raquo;</a>
    </div>

    <div class="card">
    	<div class="card-header">
    		Últimos 10 tickets generados
    	</div>
    	<div class="card-body">
    		<?php if (mysqli_num_rows($tickets) > 0): ?>
    		<div class="table-responsive">
	        <table class="table table-bordered">
	          <thead>
	            <tr>
	              <th scope="col">N°</th>
	              <th scope="col">Asunto</th>
	              <th scope="col">Fecha</th>
	              <th scope="col">Estado</th>
	            </tr>
	          </thead>
	          <tbody>
	          	<?php while ($tInfo = mysqli_fetch_array($tickets)) { ?>
	            <tr>
	              <td>#<?php echo $tInfo['idTicket']; ?></td>
	              <td><a href="soporte/ticket/<?php echo $tInfo['idTicket']; ?>"><?php echo $tInfo['asunto']; ?></a></td>
	              <td><?php echo $tInfo['fechaCreacion']; ?></td>
	              <td><?php echo getStatus($tInfo['estadoTicket']); ?></td>
	            </tr>
	            <?php } ?>
	          </tbody>
	        </table>
	    </div>
	    <?php else: ?>
	    <div class="alert alert-warning alert-dismissible fade show" role="alert">
			No tienes tickets creados aún.
		</div>
	    <?php endif ?>
    	</div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

  <script src="https://getbootstrap.com/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
</body>
</html>