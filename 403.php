<?php 
	include 'config/funciones.php';
	date_default_timezone_set('America/Bogota');
	$ip = getUserIP();
	$info = geoDataUser($ip);
	$logFile = fopen("config/logs/logs_access.txt", "a+");
	$new = "[".date('d/m/Y - h:i:sA')."] Acceso denegado desde ".$info['geoplugin_city'].", ".$info['geoplugin_region'].". IP: ".$ip;
	fwrite($logFile, $new . PHP_EOL);
	fclose($logFile);
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="vendor/css/forbidden.css">
</head>
<body>

<div class="container">
  <h1>4<div class="lock"><div class="top"></div><div class="bottom"></div>
    </div>3</h1><p>Acceso denegado</p>
</div>

<script>
	const interval = 500;

	function generateLocks() {
	  const lock = document.createElement('div'),
	        position = generatePosition();
	  lock.innerHTML = '<div class="top"></div><div class="bottom"></div>';
	  lock.style.top = position[0];
	  lock.style.left = position[1];
	  lock.classList = 'lock'// generated';
	  document.body.appendChild(lock);
	  setTimeout(()=>{
	    lock.style.opacity = '1';
	    lock.classList.add('generated');
	  },100);
	  setTimeout(()=>{
	    lock.parentElement.removeChild(lock);
	  }, 2000);
	}

	function generatePosition() {
	  const x = Math.round((Math.random() * 100) - 10) + '%';
	  const y = Math.round(Math.random() * 100) + '%';
	  return [x,y];
	}

	setInterval(generateLocks,interval);
	generateLocks();
</script>

</body>
</html>