<?php
	include '../config/database.php';
	include '../config/config.php';
	include '../config/funciones.php';
	redireccionar("/suportick/soporte/tickets.php","mtickets");
	session_start();
	if (!isset($_SESSION['id_user']) && !isset($_SESSION['nivel_rol'])) {
		header('location: ../login');
	}
	$tickets = misTickets($_SESSION['id_user']);
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
	        <a class="nav-link" href="../">Inicio <span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="mistickets">Mis tickets</a>
	      </li>
	      <?php if ($_SESSION['nivel_rol'] >= 2): ?>
	      <li class="nav-item">
	        <a class="nav-link" href="../acp">Zona Admin</a>
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
	          <a class="dropdown-item" href="../ajustes">Configuración</a>
	          <div class="dropdown-divider"></div>
		        <a class="dropdown-item" href="../salir">Cerrar sesión</a>
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
    <div class="alert alert-warning mb-3" role="alert">
	  <h5 class="alert-heading">Mis tickets</h5>
	  <hr>
	  <p>Aquí podrás encontrar todos tus tickets, visualizando el estado y su última fecha de respuesta. Si en algún momento cierras un ticket por error, deberás de crear uno nuevo adjuntando el ID del mismo o enviar un correo a <b>contacto@juanchoo.com</b> solicitando la apertura del mismo.</p>
	</div>

    <?php if (!empty($tickets) && mysqli_num_rows($tickets) > 0): ?>
    <div class="table-responsive">
	    <table class="table table-bordered table-striped table-hover">
	        <thead class="thead-dark">
	          <tr>
	            <th scope="col">N°</th>
	            <th scope="col">Asunto</th>
	            <th scope="col">Fecha creado</th>
	            <th scope="col">Fecha últ. respuesta</th>
	            <th scope="col">Estado</th>
	          </tr>
	        </thead>
	        <tbody>
	          <?php while ($tInfo = mysqli_fetch_array($tickets)) { ?>
	          <tr>
	            <td>#<?php echo $tInfo['idTicket']; ?></td>
	            <td><a href="ticket/<?php echo $tInfo['idTicket']; ?>"><?php echo $tInfo['asunto']; ?></a></td>
	            <td><?php echo $tInfo['fechaCreacion']; ?></td>
	            <td><?php echo getLastReply($tInfo['idTicket']); ?></td>
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

<?php include '../includes/footer.php'; ?>

  <script src="https://getbootstrap.com/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
</body>
</html>