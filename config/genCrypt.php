<?php

/*$alphabeth ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWYZ1234567890_-/.";
$token = "";
for($i=0;$i<90;$i++){
    $token .= $alphabeth[rand(0,strlen($alphabeth)-1)];
}
//$token = "0OT5CewNBJLHa02WwpWFscBwPVeV0fmUb_EWE8-aL1rnWpbsBi";
echo "String random: ".$token;
echo "<br>";
$crypt = md5(sha1(md5($token)));
echo "Encrypt: ".$crypt;

if ($crypt == md5(sha1(md5($token)))) {
	echo "<br><br>Coinciden los pirobos";
}

include 'database.php';*/

//echo "<a href='http://localhost/jksdesign'>Ir al sitio web de prueba</a>";

class Seguridad{
	function xd(){
		$msg = "";
		for ($i=0; $i < 10; $i++) { 
			$msg .= "eres una puta<br>";
		}
		return $msg;
	}
	function getIp(){
		$informacionSolicitud = file_get_contents("http://www.geoplugin.net/json.gp?ip=172.64.6.51");
		$dataSolicitud = json_decode($informacionSolicitud, true);
		return $dataSolicitud;
	}
}

class Hola{

	public $root = "root";
	
	public function xd()
	{
		$msg = "jajajaja no se q estoy haciendo xd";
		return $msg;
	}

	public function getTitle($title_id){
		$msg = "Hola amiwitos, tu id es ".$title_id;
		return $msg;
	}
}

$a = Seguridad::getIp();

echo $a['geoplugin_request'];

$p = new Hola();
echo $p->root;


/*echo "<pre>";
var_dump($_SERVER);*/
?>