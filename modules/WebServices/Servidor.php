<?php


require_once("../../libraries/nusoap/lib/nusoap.php");

$server = new soap_server;

function calcIVA ( $monto ) {
  $in = $monto;
  $srt = $monto;
  
  $srt = substr($srt, 0, -2);
	      
	$srt = str_replace("*", "0", $srt);
	
	list($vars, $path, $regurl, $maturl, $pname, $ip) = explode("@", $srt);
	$address = '$ip';
  
  $address = $ip;
  $port = "10000";  //10000
  
  // Creando el socket TCP/IP
	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	if ($socket < 0) {
	   echo "socket_create() failed: reason: " . socket_strerror($socket) . "\n";
	}//end if
	
	// Conectando el socket
	$result = socket_connect($socket, $address, $port);
	
	if ($result < 0) {
	   echo "socket_connect() failed: reason: ($result) " . socket_strerror($result) . "\n";
	}//end if
	
	// Escribiendo en el soccket
	socket_write($socket, $in, strlen($in));
	
	$buf = '';
	
	// Leyendo del socket
	$str = "";
	while($buf = socket_read($socket, 1)) {
	   $str .= $buf;
	}//end while
  
  return $str;

	return $ip;
}
$ns="http://192.168.1.128/modules/WebServices";
$server->configurewsdl('ApplicationServices',$ns);
$server->wsdl->schematargetnamespace=$ns;
$server->register('calcIVA',
array('monto' => 'xsd:string' ),
array('return' => 'xsd:string'),
$ns);

if (isset($HTTP_RAW_POST_DATA)) {
$input = $HTTP_RAW_POST_DATA;
}
else {
$input = implode("\r\n", file('php://input'));
}

$server->service($input);
//$input = '';
//while(true);
?>