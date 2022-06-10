<?php
/* https://gist.github.com/giobeatle1794/bd6f47f83a708b217afdc320b358217b */
//echo var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR'])));

function get_client_ip() {
  $ipaddress = '';
  if (getenv('HTTP_CLIENT_IP'))
      $ipaddress = getenv('HTTP_CLIENT_IP');

  else if(getenv('HTTP_X_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_X_FORWARDED_FOR');

  else if(getenv('HTTP_X_FORWARDED'))
      $ipaddress = getenv('HTTP_X_FORWARDED');

  else if(getenv('HTTP_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_FORWARDED_FOR');

  else if(getenv('HTTP_FORWARDED'))
     $ipaddress = getenv('HTTP_FORWARDED');

  else if(getenv('REMOTE_ADDR'))
      $ipaddress = getenv('REMOTE_ADDR');
  else
      $ipaddress = 'UNKNOWN';
  if (strpos($ipaddress, ",") !== false) :
    $ipaddress = strtok($ipaddress, ",");
  endif;
  return $ipaddress;
}

function get_public_ip(){
  $externalContent = file_get_contents('http://checkip.dyndns.com/');
  preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
  $externalIp = $m[1];
  return $externalIp;
}

$theIP = get_client_ip();
$theExternalIP = get_public_ip();
//echo $theExternalIP;
// o haz la prueba con una IP de Google
//$ip = '74.125.224.72';

// Contiene el texto como JSON que retorna geoplugin a partir de la IP
// Puedes usar un método más sofisticado para hacer un llamado a geoplugin 
// usando librerias como UNIREST etc
$informacionSolicitud = file_get_contents("http://www.geoplugin.net/json.gp?ip=".$theExternalIP);

// Convertir el texto JSON en un array
$dataSolicitud = json_decode($informacionSolicitud, true);

// Ver contenido del array
//var_dump($dataSolicitud);

$pais = $dataSolicitud['geoplugin_countryCode'];

// Serealizar los datos y poder iniciarlos en caso de utilizar buffering (de igual manera no es factible que lo usemos dentro del proyecto)
//$m = file_get_contents('http://www.geoplugin.net/php.gp?ip='.$theExternalIP);
$m = var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$theExternalIP)));
var_dump($m);
//echo $xf;

// Imprimiria algo similar a (dependiendo de la IP proporcionada) :
// geoplugin_countryCode => "DE",
// geoplugin_countryName => "Germany"
// geoplugin_continentCode => "EU"

?>