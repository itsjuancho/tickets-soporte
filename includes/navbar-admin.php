<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<div class="container">
	  <a class="navbar-brand" href="<?php echo url_entera; ?>/acp"><?php echo NOMBRE_APP; ?> <small><span class='badge badge-success'>ADMIN</span></small></a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarCollapse">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item">
	        <a class="nav-link" href="<?php echo url_entera; ?>/acp/inicio">Inicio</a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="<?php echo url_entera; ?>/acp/buscador" >Buscador</a>
	      </li>
	      <?php if ($_SESSION['nivel_rol'] >= 4): ?>
	      <li class="nav-item">
	      	<a class="nav-link" href="<?php echo url_entera; ?>/acp/settings">Configuración</a>
	      </li>
	      <?php endif ?>
	    </ul>
	    <div class="navbar-nav">
	    	<li class="nav-item">
	        	<a class="badge badge-light" href="<?php echo url_entera; ?>">Volver al ucp <span class="sr-only">(current)</span></a>
	    	</li>
	    </div>
	    <div class="form-inline mt-2 mt-md-0">
	    <ul class="navbar-nav">
	      <li class="nav-item dropdown">
	        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          Menú
	        </a>
	        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	          <a class="dropdown-item" href="../perfil">Mi perfil</a>
	          <a class="dropdown-item" href="../ajustes">Configuración</a>
	          <div class="dropdown-divider"></div>
		        <a class="dropdown-item" href="<?php echo url_entera; ?>/salir">Cerrar sesión</a>
		      </div>
	      </li>
	  	</ul>
	  	</div>
	  </div>
	</div>
</nav>
