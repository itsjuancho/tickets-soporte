<?php

function limpiarData($data){
	$data = trim($data);
   	$data = stripslashes($data);
   	$data = htmlspecialchars($data);
	return $data;
}

function isLogin(){
	global $_SESSION;
	if (!isset($_SESSION['id_user']) && !isset($_SESSION['nivel_rol'])) {
		header('location: ../login');
	}
}

function isLoginAcp(){
  global $_SESSION;
  if (!isset($_SESSION['id_user']) && !isset($_SESSION['nivel_rol'])) {
    header('location: ../login');
  }else{
    if ($_SESSION['nivel_rol'] < 2) {
      $_SESSION['msgError'] = "No tienes los permisos suficientes para acceder a esta página.";
      header('location: ../inicio');
    }
  }
}

function isLoginTwo(){
  global $_SESSION;
  if (!isset($_SESSION['id_user']) && !isset($_SESSION['nivel_rol'])) {
    header('location: ../../login');
  }
}

function redireccionar($url_relativa,$nueva_url){
	if ($_SERVER['REQUEST_URI'] == $url_relativa) {
		header('location: '.$nueva_url);
	}
}

function recuperarTodaInfoTabla($tabla){
	global $conexion;
	$sql = "SELECT * FROM $tabla";
	$data = mysqli_query($conexion,$sql);
	return $data;
}

function ultimosTickets($id_user){
	global $conexion;
	$id = limpiarData($id_user);
	$sql = "SELECT idTicket,asunto,fechaCreacion,estadoTicket FROM ticket WHERE user_id = $id ORDER BY idTicket DESC LIMIT 10";
	$tickets = mysqli_query($conexion,$sql);
	return $tickets;
}

function misTickets($idUser){
	global $conexion;
  $id = limpiarData($idUser);
  $sql = "SELECT idTicket,asunto,fechaCreacion,estadoTicket FROM ticket WHERE user_id = $id ORDER BY idTicket ASC";
  $tickets = mysqli_query($conexion,$sql);
  return $tickets;
}

function OldGetTicketsOpenByDpto($id_departamento){
  global $conexion;
  $id_depto = limpiarData($id_departamento);
  $sql = "SELECT ticket.idTicket,sistema.sistema,ticket.asunto,ticket.prioridad,ticket.fechaCreacion,ticket.estadoTicket,respuestasTicket.esAdmin,respuestasTicket.fechaRespuesta FROM (((ticket INNER JOIN respuestasTicket ON ticket.idTicket = respuestasTicket.idTicket) INNER JOIN sistema ON ticket.sistema = sistema.idSistema) INNER JOIN (SELECT esAdmin,fechaRespuesta FROM respuestasTicket ORDER BY idRespuesta DESC LIMIT 1) ON ticket.idTicket = respuestasTicket.idTicket) WHERE sistema.idDepartamento = 1 ORDER BY respuestasTicket.idRespuesta ASC LIMIT 1";
}

function getTicketsOpenByDpto($id_departamento){
  global $conexion;
  $id_depto = limpiarData($id_departamento);
  $sql = "SELECT ticket.idTicket,sistema.sistema,ticket.asunto,ticket.prioridad,ticket.fechaCreacion,ticket.estadoTicket FROM (ticket INNER JOIN sistema ON ticket.sistema = sistema.idSistema) WHERE sistema.idDepartamento = $id_departamento AND ticket.estadoTicket <= 1 ORDER BY idTicket ASC";
  $tbyDpt = mysqli_query($conexion,$sql);
  return $tbyDpt;
}

function getLastReply($id_ticket){
  global $conexion;
  $rep = "";
  $tid = limpiarData($id_ticket);
  $sql = "SELECT esAdmin,fechaRespuesta FROM respuestasTicket WHERE idTicket = $tid ORDER BY idRespuesta DESC LIMIT 1";
  $exeRep = mysqli_query($conexion,$sql);
  if (mysqli_num_rows($exeRep) > 0) {
    $r = mysqli_fetch_array($exeRep);
    switch ($r['esAdmin']) {
      case 1:
        $msg = "<span class='badge badge-dark'>".$r['fechaRespuesta']."</span>";
        return $msg;
        break;
      
      default:
        $msg = "<span class='badge badge-success'>".$r['fechaRespuesta']."</span>";
        return $msg;
        break;
    }
  }else{
    $msg = "<small><span class='badge badge-warning'>SIN RESPUESTAS</span></small>";
    return $msg;
  }
}

function getTicketsAttendByAdmin($id_user){
  global $conexion;
  $id_admin = limpiarData($id_user);
  $sql = "SELECT ticket.idTicket,sistema.sistema,ticket.asunto,ticket.prioridad,ticket.fechaCreacion,ticket.estadoTicket FROM (ticket INNER JOIN sistema ON ticket.sistema = sistema.idSistema) WHERE ticket.id_admin = $id_admin AND ticket.estadoTicket <= 1 ORDER BY idTicket ASC";
  $tAdmin = mysqli_query($conexion,$sql);
  return $tAdmin;
}

function varLong($str){
	$varx = iconv_strlen($str,"utf-8");
	return $varx;
}

function getUserIP(){
  $externalContent = file_get_contents('http://checkip.dyndns.com/');
  preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
  $externalIp = $m[1];
  return $externalIp;
}

function geoDataUser($ip){
	$informacionSolicitud = file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip);
	$dataSolicitud = json_decode($informacionSolicitud, true);
	return $dataSolicitud;
}

function getOS() { 
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
  $os_array =  array(
  	'/windows nt 10/i'      =>  'Windows 10',
    '/windows nt 6.3/i'     =>  'Windows 8.1',
    '/windows nt 6.2/i'     =>  'Windows 8',
    '/windows nt 6.1/i'     =>  'Windows 7',
    '/windows nt 6.0/i'     =>  'Windows Vista',
    '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
    '/windows nt 5.1/i'     =>  'Windows XP',
    '/windows xp/i'         =>  'Windows XP',
    '/windows nt 5.0/i'     =>  'Windows 2000',
    '/windows me/i'         =>  'Windows ME',
    '/win98/i'              =>  'Windows 98',
    '/win95/i'              =>  'Windows 95',
    '/win16/i'              =>  'Windows 3.11',
    '/macintosh|mac os x/i' =>  'Mac OS X',
    '/mac_powerpc/i'        =>  'Mac OS 9',
    '/linux/i'              =>  'Linux',
    '/ubuntu/i'             =>  'Ubuntu',
    '/iphone/i'             =>  'iPhone',
    '/ipod/i'               =>  'iPod',
    '/ipad/i'               =>  'iPad',
    '/android/i'            =>  'Android',
    '/blackberry/i'         =>  'BlackBerry',
    '/webos/i'              =>  'Mobile'
    );
  $os_platform = "Unknown OS Platform";
  foreach ($os_array as $regex => $value) { 
    if (preg_match($regex, $user_agent)) {
      $os_platform = $value;
    }
  }
  return $os_platform;
}

function getNav() {
  $user_agent = $_SERVER['HTTP_USER_AGENT'];
  $browser_array = array(
  	'/msie/i'       =>  'Internet Explorer',
  	'/firefox/i'    =>  'Firefox',
  	'/safari/i'     =>  'Safari',
  	'/chrome/i'     =>  'Chrome',
  	'/edge/i'       =>  'Edge',
  	'/opera/i'      =>  'Opera',
  	'/netscape/i'   =>  'Netscape',
  	'/maxthon/i'    =>  'Maxthon',
  	'/konqueror/i'  =>  'Konqueror',
  	'/mobile/i'     =>  'Handheld Browser'
  );
  $browser = "Unknown Browser";
  foreach ($browser_array as $regex => $value) { 
    if (preg_match($regex, $user_agent)) {
      $browser = $value;
    }
  }
  return $browser;
}

function getPriority($prioridad){
	switch ($prioridad) {
		case '1': return "Baja"; break;
		case '2': return "Media"; break;
		case '3': return "Alta"; break;
		case '4': return "Urgente"; break;
		default: return "Sin asignar"; break;
	}
}

function getStatus($estado){
	switch ($estado) {
		case '1': return "<span class='badge badge-success'>ATENDIDO</span>"; break;
		case '2': return "<span class='badge badge-danger'>CERRADO</span>"; break;
		case '3': return "<span class='badge badge-dark'>ARCHIVADO</span>"; break;
		default: return "<span class='badge badge-warning'>EN ESPERA</span>"; break;
	}
}

function getStatusT($estado){
  switch ($estado) {
    case '1': return "Atendido"; break;
    case '2': return "Cerrado"; break;
    case '3': return "Archivado"; break;
    default: return "En espera"; break;
  }
}

function getTicket($ticketId){
	global $conexion;
	$id = limpiarData($ticketId);
  //$sql = "SELECT * FROM ticket WHERE idTicket = $id";
  $sql = "SELECT ticket.idTicket,ticket.user_id,ticket.unique_key,usuario.nombres,usuario.apellidos,usuario.correo,usuario.tipoCuenta,usuario.fechaRegistro,ticket.fechaCreacion,sistema.sistema,sistema.idSistema,departamento.departamento,departamento.idDepartamento,ticket.ip,ticket.navegador,ticket.asunto,ticket.descripcion,ticket.prioridad,ticket.estadoTicket,ticket.id_admin FROM (((ticket INNER JOIN usuario ON ticket.user_id = usuario.user_id) INNER JOIN sistema ON ticket.sistema = sistema.idSistema) INNER JOIN departamento ON sistema.idDepartamento = departamento.idDepartamento) WHERE ticket.idTicket = $ticketId";
  $ticket = mysqli_query($conexion,$sql);
  return $ticket;
}

function getRepliesTicket($ticket_id){
  global $conexion;
  $id_ticket = limpiarData($ticket_id);
  $getReplies = "SELECT usuario.nombres,usuario.apellidos,respuestasTicket.esAdmin,respuestasTicket.respuesta,respuestasTicket.fechaRespuesta FROM (respuestasTicket INNER JOIN usuario ON respuestasTicket.user_id = usuario.user_id) WHERE respuestasTicket.idTicket = $id_ticket";
  $respsTicket = mysqli_query($conexion,$getReplies);
  return $respsTicket;
}

function getAdminName($adminId){
  global $conexion;
  $name = "";
  if ($adminId == NULL || $adminId == 0)  {
    $name = "Sin atender";
    return $name;
  }else{
    $sql = "SELECT nombres,apellidos FROM usuario WHERE user_id = $adminId";
    $getAdmin = mysqli_query($conexion,$sql);
    if (mysqli_num_rows($getAdmin) > 0) {
      $nF = mysqli_fetch_array($getAdmin);
      $name = $nF['nombres']." ".$nF['apellidos'];
      return $name;
    }else{
      $name = "Sin atender";
      return $name;
    }
  }
}

function getAdmins(){
  global $conexion;
  $sql = "SELECT user_id,nombres,apellidos FROM usuario WHERE tipoCuenta >= 2 ORDER BY user_id ASC";
  $exeAdmins = mysqli_query($conexion,$sql);
  return $exeAdmins; 
}

function genKey(){
  $alphabeth ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890";
  $token = "";
  for($i=0;$i<90;$i++){
      $token .= $alphabeth[rand(0,strlen($alphabeth)-1)];
  }
  return $token;
}

function typeUser($type){
  switch ($type) {
    case 0: echo "Usuario"; break;
    case 1: echo "Equipo Soporte Técnico <img src='http://localhost/ticketsTienda/img/verified-team.png' width='15px' heigth='15px'></img>"; break;
    default: echo "Desconocido"; break;
  }
}
?>