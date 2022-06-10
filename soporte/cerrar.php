<?php
session_start();
include '../config/database.php';
include '../config/funciones.php';
isLogin();
redireccionar("/ticketsTienda/soporte/cerrar.php","cerrar_ticket");
if (isset($_POST['tid']) && isset($_POST['t_id'])) {
	if (!empty($_POST['tid']) && !empty($_POST['t_id'])) {
		$tid = limpiarData($_POST['tid']);
		$t_id = limpiarData($_POST['t_id']);
		if (is_numeric($t_id)) {
			$sql = "SELECT unique_key,user_id FROM ticket WHERE idTicket = $t_id";
			$t = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
			if (mysqli_num_rows($t) > 0) {
				$p = mysqli_fetch_array($t);
				if ($_SESSION['id_user'] <> $p['user_id']) {
					$_SESSION['msgError'] = "Alto ahí, eso no es tuyo. No tienes permisos para realizar esta acción.";
					header('location: ../inicio');
					exit();
					//var_dump($_POST);
					//var_dump($_SESSION);
				}else{
					if ($p['unique_key'] == "0" || $p['unique_key'] == NULL) {
						$_SESSION['msgReplyTicket'] = "<b>Error</b> de seguridad. Envía un email a soporte@juanchoo.com adjuntando la ID del ticket para que lo solucionen.";
						$_SESSION['typeMsgReply'] = "danger";
						header('location: ticket/'.$t_id);
						exit();
					}
				if ($tid == md5(sha1(md5($p['unique_key'])))) {
					$sqlUpdateEstado = "UPDATE ticket SET estadoTicket = 2 WHERE idTicket = $t_id";
					$exeUpEt = mysqli_query($conexion,$sqlUpdateEstado);
					if ($exeUpEt) {
						$_SESSION['msgReplyTicket'] = "<i class='far fa-check-circle'></i> Has cerrado el ticket! No puedes volver a abrirlo.";
						$_SESSION['typeMsgReply'] = "success";
						header('location: ticket/'.$t_id);
						exit();
					}else{
						$_SESSION['msgReplyTicket'] = "No se pudo cerrar el ticket. Contáctanos a contacto@juanchoo.com adjuntando el numero del ticket para revisar el error.";
						$_SESSION['typeMsgReply'] = "danger";
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
		$_SESSION['msgError'] = "ID de ticket inválido.";
		header('location: ../inicio');
		exit();
	}
}else{
	$_SESSION['msgError'] = "Campos inválidos y/o no establecidos. Inténtalo de nuevo.";
	header('location: ../inicio');
	exit();
}
}else{
	header("location: ../inicio");
}
?>