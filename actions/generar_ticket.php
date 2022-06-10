<?php

session_start();
if (isset($_SESSION['id_user']) && isset($_SESSION['nivel_rol'])) {
	if (!empty($_SESSION['id_user'])) {
		if ($_SESSION['nivel_rol'] > 0) {
			if (isset($_POST['descripcion']) && isset($_POST['asunto']) && isset($_POST['sistema'])) {
				include '../config/funciones.php';
				$descripcion = nl2br(limpiarData($_POST['descripcion']));
				$asunto = limpiarData($_POST['asunto']);
				$sistema = limpiarData($_POST['sistema']);
				if (is_numeric($sistema)) {
					if (varLong($asunto) <= 60 && varLong($descripcion) <= 1500){
						$ip = getUserIP();
						$nav = getNav();
						$key = genKey();
						include '../config/database.php';
						$new = "INSERT INTO ticket (user_id,unique_key,sistema,ip,navegador,asunto,descripcion,prioridad,estadoTicket,ultimaRespuestaId) VALUES (".$_SESSION['id_user'].",'$key',$sistema,'$ip','$nav','$asunto','$descripcion',0,0,0)";
						$sqlTicket = mysqli_query($conexion,$new) or die(mysqli_error($conexion));
						if ($sqlTicket) {
							$result['status'] = 1;
							echo json_encode($result);
						}else{
							$result['status'] = 2;
							echo json_encode($result);
						}
					}else{
						$result['status'] = 3;
						$result['msg'] = "Los campos se exceden en lo permitido.";
						echo json_encode($result);
						//var_dump($descripcion);
						//var_dump($asunto);
					}
				}else{
					$result['status'] = 4;
					$result['msg'] = "ID de sistema no válida.";
					echo json_encode($result);
				}
			}else{
				$result['status'] = 5;
				$result['msg'] = "No están definidas las variables de campo.";
				echo json_encode($result);
			}
		}else{
			$result['status'] = 6;
			$result['msg'] = "No posees los permisos necesarios para generar un ticket.";
			echo json_encode($result);
		}
	}else{
		$result['status'] = 7;
		$result['msg'] = "Ha ocurrido un error, inicia sesión de nuevo.";
		$result['goto'] = "login";
		echo json_encode($result);
	}
}else{
	header('location: ../login');
}

?>