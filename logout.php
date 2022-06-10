<?php

include 'config/funciones.php';
redireccionar("/ticketsTienda/logout.php","salir");

session_start();
session_destroy();
header('location: login');

?>