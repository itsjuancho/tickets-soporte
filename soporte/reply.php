<?php
session_start();
include '../config/database.php';
include '../config/funciones.php';
isLogin();
redireccionar("/ticketsTienda/soporte/reply.php","validar_respuesta");
if (isset($_POST['tid']) && isset($_POST['t_id']) && isset($_POST['respuesta'])) {
	if (!empty($_POST['tid']) && !empty($_POST['t_id']) && !empty($_POST['respuesta'])) {
		$tid = limpiarData($_POST['tid']);
		$t_id = limpiarData($_POST['t_id']);
		$reply = nl2br(limpiarData($_POST['respuesta']));
		if (is_numeric($t_id)) {
			if (varLong($reply) <= 1000) {
				$sql = "SELECT unique_key,user_id FROM ticket WHERE idTicket = $t_id";
				$f = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
				if (mysqli_num_rows($f) > 0) {
					$p = mysqli_fetch_array($f);
					if ($_SESSION['id_user'] <> $p['user_id']) {
						$_SESSION['msgError'] = "Alto ahí, eso no es tuyo. No tienes permisos para realizar esta acción.";
						header('location: ../inicio');
						exit();
					}else{
						if ($p['unique_key'] == "0" || $p['unique_key'] == NULL) {
							$_SESSION['msgReplyTicket'] = "<b>Error</b> de seguridad. Envía un email a soporte@juanchoo.com adjuntando la ID del ticket para que lo solucionen.";
							$_SESSION['typeMsgReply'] = "danger";
							header('location: ticket/'.$t_id);
							exit();
						}
						if ($tid == md5(sha1($p['unique_key']))) {
							$ip = getUserIP();
							$idUser = $_SESSION['id_user'];
							$newReply = "INSERT INTO respuestasTicket (idTicket,user_id,respuesta,ip) VALUES ($t_id,$idUser,'$reply','$ip')";
							$eReply = mysqli_query($conexion,$newReply);
							if ($eReply) {
								$_SESSION['msgReplyTicket'] = "<i class='far fa-check-circle'></i> Ticket respondido correctamente.";
								$_SESSION['typeMsgReply'] = "success";
								header('location: ticket/'.$t_id);
								exit();
							}else{
								$_SESSION['msgReplyTicket'] = "Hubo un error al responder el ticket. Inténtalo de nuevo.";
								$_SESSION['typeMsgReply'] = "info";
								header('location: ticket/'.$t_id);
								exit();
							}
						}else{
							$_SESSION['msgReplyTicket'] = "<b>Error</b> al verificar el código de seguridad. Inténtalo de nuevo.";
							$_SESSION['typeMsgReply'] = "danger";
							header('location: ticket/'.$t_id);
							exit();
						}
					}
				}else{
					$_SESSION['msgError'] = "Error desconocido.";
					header('location: ../inicio');
					exit();
				}
			}else{
				$_SESSION['msgReplyTicket'] = "Excediste el número de carácteres permitidos en tu respuesta. Vuelve a formularla.";
				$_SESSION['typeMsgReply'] = "warning";
				header('location: ticket/'.$t_id);
				exit();
			}
		}else{
			$_SESSION['msgError'] = "ID de ticket inválido.";
			header('location: ../inicio');
			exit();
		}
	}else{
		$_SESSION['msgReplyTicket'] = "No has rellenado el campo 'respuesta'. Debes de hacerlo.";
		$_SESSION['typeMsgReply'] = "warning";
		header('location: ticket/'.$_POST['t_id']);
		exit();
	}
}else{
	header("location: ../inicio");
}
?>