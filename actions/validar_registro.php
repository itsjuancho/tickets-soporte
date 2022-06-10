<?php

if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['genero']) && isset($_POST['email']) && isset($_POST['password'])) {
	if (!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['genero']) && !empty($_POST['email']) && !empty($_POST['password'])) {
		include '../config/database.php';
		include '../config/funciones.php';

		$nombres = limpiarData($_POST['nombre']);
		$apellidos = limpiarData($_POST['apellido']);
		$genero = limpiarData($_POST['genero']);
		$email = limpiarData($_POST['email']);
		$password = limpiarData($_POST['password']);

		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$sqlVerifEmail = "SELECT correo FROM usuario WHERE correo = '$email'";
			$verEmail = mysqli_query($conexion,$sqlVerifEmail) or die(mysqli_error($conexion));
			if (mysqli_num_rows($verEmail) > 0) {
				echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
				  <b>Error 17:</b> Falló el registro. El email ingresado ya está en uso.
				  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				    <span aria-hidden='true'>&times;</span>
				  </button>
				</div>";
				exit();
			}
			$pw = password_hash($password, PASSWORD_BCRYPT);
			$sqlRegistro = "INSERT INTO usuario (nombres,apellidos,correo,pw,idGenero) VALUES ('$nombres','$apellidos','$email','$pw',$genero)";
			$registrar = mysqli_query($conexion,$sqlRegistro) or die(mysqli_error($conexion));

			if ($registrar) {
				/*echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
				  <b>¡Registrado!</b> <b><a href='login'>Click aquí</a></b> para acceder al sistema.
				  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				    <span aria-hidden='true'>&times;</span>
				  </button>
				</div>";*/
				session_start();
				$_SESSION['mensaje'] = "<b>¡Registrado!</b> Ya puedes acceder.";
				echo "<script>window.location.href = 'login'; </script>";
			}else{
				echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
				  <b>Error 11:</b> Falló el registro por motivos técnicos.
				  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				    <span aria-hidden='true'>&times;</span>
				  </button>
				</div>";
			}
		}else{
			echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
		  <b>Error 12:</b> Falló el registro. Revise que haya ingresado un email válido.
		  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		    <span aria-hidden='true'>&times;</span>
		  </button>
		</div>";
		}
	}else{
		echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
		  <b>Error 13:</b> Falló el registro. Hay campos vacíos, rellénelos.
		  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		    <span aria-hidden='true'>&times;</span>
		  </button>
		</div>";
	}
}else{
	session_start();
	$_SESSION['mensaje'] = "<b>Error 10:</b> Ha fallado la verificación. Rellena el formulario nuevamente.";
	header('location: ../registro');
}

?>