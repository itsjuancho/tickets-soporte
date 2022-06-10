<?php

if (isset($_POST['correo']) && isset($_POST['pw'])) {
	if (!empty($_POST['correo']) && !empty($_POST['pw'])) {
		include '../config/funciones.php';
		$email = limpiarData($_POST['correo']);
		$passLogin = limpiarData($_POST['pw']);
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			include '../config/database.php';
			$buscarUser = "SELECT * FROM usuario WHERE correo = '$email'";
			$login = mysqli_query($conexion,$buscarUser) or die(mysqli_error($conexion));
			if (mysqli_num_rows($login) > 0) {
				$s = mysqli_fetch_array($login);
				if (password_verify($passLogin, $s['pw'])) {
					session_start();
					$_SESSION['id_user'] = $s['user_id'];
					$_SESSION['nivel_rol'] = $s['tipoCuenta'];
					//echo "<script>window.location.href = 'inicio'; </script>";
					//echo json_encode($_SESSION);
					//header('location: ../inicio');
					$result['status'] = 1;
					$result['goto'] = "inicio";
					echo json_encode($result);
				}else{
					$result['status'] = 2;
					$result['code'] = 22;
					$result['msg'] = "Contraseña incorrecta.";
					echo json_encode($result);
				}
			}else{
				$result['status'] = 2;
				$result['code'] = 23;
				$result['msg'] = "No existe este usuario.";
				echo json_encode($result);
			}
		}else{
			$result['status'] = 2;
			$result['code'] = 12;
			$result['msg'] = "El email es inválido.";
			echo json_encode($result);
		}
	}else{
		$result['status'] = 2;
		$result['code'] = 13;
		$result['msg'] = "Los campos están vacíos.";
		echo json_encode($result);
	}
}else{
	header('location: ../login');
}

?>