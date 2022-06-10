<?php 
include '../config/database.php';
include '../config/config.php';
include '../config/funciones.php';
session_start();
isLoginAcp();
redireccionar("/ticketsTienda/acp/index.php","inicio");
$deptos = recuperarTodaInfoTabla('departamento');
$myTickets = getTicketsAttendByAdmin($_SESSION['id_user']);
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
<div class="alert alert-info mb-3" role="alert">
  <h5 class="alert-heading">Zona administrativa | <small>IP: <?php echo getUserIP(); ?> (CO)</small></h5>
  <hr>
  <p>Bienvenido. Aquí podrás visualizar todos los tickets abiertos en cualquiera de los departamentos disponibles en el sistema, también tienes a tu disposición los que has atendido o se te han asignado para que puedas realizar un mejor seguimiento a ellos.</p>
  <hr>
  <p class="mb-0">Recuerda mantener la postura de profesionalismo a la hora de dar atención al cliente.</p>
</div>
<?php if (mysqli_num_rows($myTickets) > 0): ?>
<div class="card mb-2">
	<div class="card-header bg-myTickets">Mis tickets atendidos</div>
	<div class="card-body border-greenlight">
		<div class="table-responsive">
			<table class="table table-bordered table-sm">
			<thead class="thead-dark">
				<tr>
	        <th scope="col">Sistema</th>
	        <th scope="col">Asunto</th>
	        <th scope="col">Prioridad</th>
	        <th scope="col">Fecha creado</th>
	        <th scope="col">Ultima respuesta</th>
	        <th scope="col">Estado</th>
	      </tr>
			</thead>
			<tbody>
				<?php while ($myTicket = mysqli_fetch_array($myTickets)) { ?>
	    	<tr>
		    	<td><?php echo $myTicket['sistema']; ?></td>
		    	<td><a href="soporte/ticket/<?php echo $myTicket['idTicket']; ?>">#<?php echo $myTicket['idTicket']." - ".$myTicket['asunto']; ?></a></td>
		    	<td><?php echo getPriority($myTicket['prioridad']); ?></td>
		    	<td><?php echo $myTicket['fechaCreacion']; ?></td>
		    	<td><?php echo getLastReply($myTicket['idTicket']); ?></td>
		    	<td><?php echo getStatus($myTicket['estadoTicket']); ?></td>
	    	</tr>
	    	<?php } ?>
			</tbody>
			</table>
		</div>
	</div>
</div>
<?php else: ?>
<div class="alert alert-warning" role="alert">
  No tienes tickets atendidos o asignados.
</div>
<?php endif ?>
<?php if (mysqli_num_rows($deptos) > 0): ?>
<?php while($depto = mysqli_fetch_array($deptos)){ ?>
<div class="card mb-2">
	<div class="card-header">Departamento <?php echo $depto['departamento']; ?></div>
	<div class="card-body">
		<?php 
		$tickets = getTicketsOpenByDpto($depto['idDepartamento']);
		?>
		<?php if (mysqli_num_rows($tickets) > 0): ?>
		<div class="table-responsive">
	    <table class="table table-bordered table-sm">
	    <thead class="thead-dark">
	      <tr>
	        <th scope="col">Sistema</th>
	        <th scope="col">Asunto</th>
	        <th scope="col">Prioridad</th>
	        <th scope="col">Fecha creado</th>
	        <th scope="col">Ultima respuesta</th>
	        <th scope="col">Estado</th>
	      </tr>
	    </thead>
	    <tbody>
	    	<?php while ($ticket = mysqli_fetch_array($tickets)) { ?>
	    	<tr>
		    	<td><?php echo $ticket['sistema']; ?></td>
		    	<td><a href="soporte/ticket/<?php echo $ticket['idTicket']; ?>">#<?php echo $ticket['idTicket']." - ".$ticket['asunto']; ?></a></td>
		    	<td><?php echo getPriority($ticket['prioridad']); ?></td>
		    	<td><?php echo $ticket['fechaCreacion']; ?></td>
		    	<td><?php echo getLastReply($ticket['idTicket']); ?></td>
		    	<td><?php echo getStatus($ticket['estadoTicket']); ?></td>
	    	</tr>
	    	<?php } ?>
	    </tbody>
	  </table>
	</div>
	<?php else: ?>
	<div class="alert alert-warning" role="alert">
  No hay tickets abiertos para este departamento.
	</div>		
	<?php endif ?>
	</div>
</div>
<?php } ?>
<?php else: ?>
<div class="alert alert-warning" role="alert">
  Este departamento no tiene tickets abiertos y/o creados.
</div>
<?php endif ?>
</div>

<?php require_once '../includes/footer.php'; ?>

<script src="https://getbootstrap.com/docs/4.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
<script src="../vendor/js/funciones.js"></script>
</body>
</html>