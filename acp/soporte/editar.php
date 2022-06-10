<?php
session_start();
include '../../config/database.php';
include '../../config/funciones.php';
isLogin();
redireccionar("/ticketsTienda/acp/soporte/editar.php","editar_ticket");
if (isset($_POST['tid']) && isset($_POST['t_id'])) {
	if (!empty($_POST['tid']) && !empty($_POST['t_id'])) {
		$tid = limpiarData($_POST['tid']);
		$t_id = limpiarData($_POST['t_id']);
		if (is_numeric($t_id)) {
			$sql = "SELECT unique_key,user_id FROM ticket WHERE idTicket = $t_id";
			$t = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
			if (mysqli_num_rows($t) > 0) {
				$p = mysqli_fetch_array($t);
				if ($_SESSION['nivel_rol'] < 2) {
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
				if ($tid == md5(sha1(md5(sha1($p['unique_key']))))) {
					$asunto = limpiarData($_POST['asunto']);
					$prioridad = limpiarData($_POST['prioridad']);
					$sistema = limpiarData($_POST['sistema']);
					$asigned_to = limpiarData($_POST['idAdmin']);
					if (varLong($asunto) > 60) {
						$_SESSION['msgReplyTicket'] = "Has excedido el límite de carácteres al editar el asunto del ticket. Vuelve a intentarlo.";
						$_SESSION['typeMsgReply'] = "warning";
						header('location: ticket/'.$t_id);
						exit();
					}
					if (!is_numeric($prioridad) && !is_numeric($sistema) && !is_numeric($asigned_to)) {
						$_SESSION['msgReplyTicket'] = "ID de valores no válidos para editar.";
						$_SESSION['typeMsgReply'] = "danger";
						header('location: ticket/'.$t_id);
						exit();
					}
					if ($asigned_to == "") {
						$sqlUpdateEstado = "UPDATE ticket SET asunto = '$asunto', prioridad = $prioridad, sistema = $sistema, id_admin = NULL, estadoTicket = 0 WHERE idTicket = $t_id";
					}else{
						$sqlUpdateEstado = "UPDATE ticket SET asunto = '$asunto', prioridad = $prioridad, sistema = $sistema, id_admin = $asigned_to, estadoTicket = 1 WHERE idTicket = $t_id";
					}
					$exeUpEt = mysqli_query($conexion,$sqlUpdateEstado) or die(mysqli_error($conexion));
					//echo $sqlUpdateEstado;
					//exit();
					if ($exeUpEt) {
						$_SESSION['msgReplyTicket'] = "<i class='far fa-check-circle'></i> Ticket editado correctamente!";
						$_SESSION['typeMsgReply'] = "success";
						header('location: ticket/'.$t_id);
						exit();
					}else{
						$_SESSION['msgReplyTicket'] = "No se pudo editar el ticket. Contáctanos a contacto@juanchoo.com adjuntando el numero del ticket para revisar el error.";
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