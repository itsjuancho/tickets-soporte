<?php

	$servidor = "localhost";
	$user = "root";
	$pass = "";
	$database = "soporte";

	$conexion = mysqli_connect($servidor,$user,$pass,$database) or die(mysqli_error($conexion));
	mysqli_set_charset($conexion,"utf8");
	date_default_timezone_set('America/Bogota');

	if (!$conexion) {
	 	echo "No se pudo establecer una conexión con el servidor o base de datos.";
	}

	//echo date("d-m-Y_h-i-A");

?>