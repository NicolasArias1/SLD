<?php

$prevpage = $_SERVER['HTTP_REFERER'];

if ($prevpage == '') {
	header('Location: ../index.php');
	exit;
} //end if

include('../config/config.php');

include('../inc/db.class.php');
include('../inc/user.class.php');
include('../inc/man.class.php');
include('../inc/sch.class.php');
include('../inc/useful.fns.php');
include('../inc/upload.class.php');
include('../lib/nusoap.php');

session_start();

$session = $_SESSION['user'];

if (empty($session)) {
	header('Location: ../index.php');
} //end if

$user = unserialize($session);
$uid = $user->getUID();
$uname = $user->getName();
$login = $user->getLogin();
$mail = $user->getEMail();
$domain = $user->getDomain();
$level = $user->getPriority();
$_SESSION['user'] = serialize($user);
$fmdlname = "";
$fmatname = "";
$regpath = "";

set_time_limit(0);

$wsdl = "http://192.168.0.11/WebServices/Servidor.php?wsdl"; //el nombre delo archivo anterior
$client = new nusoap_client($wsdl, 'wsdl');

$err = $client->getError();

$vars = "";

/*** Recibiendo variables ***/
foreach ($_POST as $name => $value) {
	if ($name != "mlmfile") //if(is_numeric($value) && $name != "mlmfile")
		$vars .= "$name" . "=" . "$value" . ";";
	else if ($name == "mlmfile")
		$pname = (string)$value;
} //end foreach

if (isset($_FILES['filemdl']['name'])) {
	//$vars = "null";
	$fmdlname = trim($_FILES['filemdl']['name']);
	$fmdltmpn = $_FILES['filemdl']['tmp_name'];
	$fmdlsize = $_FILES['filemdl']['size'];
} //end if
else {
	$regurl = "null";
} //end else



/*** Gesti�n ficheros mat, nuevo incorporado***/
if (isset($_FILES['filemat']['name'])) {
	//$vars = "null";
	$fmatname = trim($_FILES['filemat']['name']);
	$fmattmpn = $_FILES['filemat']['tmp_name'];
	$fmatsize = $_FILES['filemat']['size'];
} //end if
else {
	$maturl = "null";
} //end else


/*** Creando carpeta de resultado ***/
$date = date("dmyHis");

$pfolder = $pname . $date;

$resurl = "http://192.168.0.11/results/" . $uid . "/" . $pfolder;

$rfolder1 = dirname(dirname(__FILE__)) . "/results";
$rfolder2 = dirname(dirname(__FILE__)) . "/results/" . $uid;

//Si no est� la carpeta results, se crea
if (!(is_dir($rfolder1)))
	mkdir($rfolder1, 0777);

//Si no est� la carpeta del usuario, se crea	
if (!(is_dir($rfolder2)))
	mkdir($rfolder2, 0777);

$rfolder = dirname(dirname(__FILE__)) . "/results/" . $uid . "/" . $pfolder;

mkdir($rfolder, 0777);

$rfolder = addslashes($rfolder);

/*** Subiendo regulador ***/
if ($fmdlname && $fmdltmpn && $fmdlsize) {
	//Creando objeto FileUpLoad
	$file = new FileUpload($fmdlname, $fmdltmpn, $fmdlsize);

	//Introduciendo extensiones permitidas
	$file->setAllowedType(".mdl");

	//Introduciendo m�ximo tama�o permitido
	$file->setMaxFileSize("1048576");

	if (!$file->error) {
		if ($file->getApprove()) {
			$file->setOverwrite("Y");

			$file->uploadFile($rfolder . "//", "ureg");

			$regpath = $file->filelocation;
			$regurl = $resurl . "//" . $file->filename;
		} //end if
	} //end if
} //end if

/*** Subiendo fichero mat, nuevo incorporado ***/
if ($fmatname && $fmattmpn && $fmatsize) {
	//Creando objeto FileUpLoad
	$file = new FileUpload($fmatname, $fmattmpn, $fmatsize);

	//Introduciendo extensiones permitidas
	$file->setAllowedType(".mat");

	//Introduciendo m�ximo tama�o permitido
	$file->setMaxFileSize("1048576");

	if (!$file->error) {
		if ($file->getApprove()) {
			$file->setOverwrite("Y");

			$file->uploadFile($rfolder . "//", "umat");

			$matpath = $file->filelocation;
			$maturl = $resurl . "//" . $file->filename;
		} //end if
	} //end if
} //end if

/*** Introduciendo practica en la base de datos ***/
//Creando objeto SQL
$sql = new SQL();

//Conectando con el servidor
$sql->SQLConnection();

//Creando consulta
$query = "SELECT pcname FROM sld_practices_data	WHERE pname='$pname'";

//Ejecutando consulta
$result = $sql->SQLQuery($query);

$pcname = $result[0]['pcname'];

//Creando consulta
$query = "INSERT INTO sld_practices (sid, uid, ulogin, pname, pcname, date, vars, regpath, regurl, resurl)
						VALUES ('1', '$uid', '$uname', '$pname', '$pcname', '$date', '$vars', '$regpath', '$regurl', '$resurl')"; // ulogin = $name X $login

//echo $query."<br>";

//Ejecutando consulta
$sql->SQLQuery($query);
//echo $sql->errstr;

//ejecutando consulta
$pid = $sql->SQLInsertID();

/*** Gestionar la estaci�n que ejecutar� la practica ***/
// Direccion IP de la estacion
$query = "SELECT ip, state, pcount FROM sld_stations WHERE (practices='" . $pname . "' OR practices LIKE '" . $pname . ";%' OR practices LIKE '%;" . $pname . ";%' OR practices LIKE '%;" . $pname . "') AND state!='off'";

//Ejecutando consulta
$result = $sql->SQLQuery($query);

if (count($result)) {
	for ($i = 0, $j = 0; $i < count($result); $i++) {
		if ($result[$i]['state'] == 'wait') {
			$wip[$j] = $result[$i]['ip'];
			$j++;
		} //end if
		$pcount[$result[$i]['ip']] = $result[$i]['pcount']; // Cuantas peticiones de hacer-práctica tiene por ip
	} //end for

	if ($wip) {
		shuffle($wip);
		$ip = $wip[0]; //si hay estaciones libre, realiza un barajeo y coge una
	} //end if
	else {
		asort($pcount);	//si no hay estaciones libres, escoge la de menor cantidad de pr�cticas ejecut�ndose		
		reset($pcount);
		$bip = key($pcount);
		$ip = $bip;
	} //end else
} //end if

//Creando consulta
$query = "UPDATE sld_stations SET state='busy', pcount=" . ($pcount[$ip] + 1) . " WHERE ip='$ip'";

//Ejecutando consulta
$sql->SQLQuery($query);

$pcount = $pcount[$ip] + 1;

//Creando consulta
$query = "SELECT stpath, path FROM sld_practices_data WHERE pname='" . $pname . "' AND sid=1";

//Ejecutando consulta
$result = $sql->SQLQuery($query);

$stpath = $result[0]['stpath'];
$path = $result[0]['path'];

// Cadena de entrada a la estacion (variables@ubicacion de la practica@practica)

$in = (string)$vars . "@" . $path . "@" . $regurl . "@" . $maturl . "@" . $pname . "@" . $ip . ";~";
/*echo "URL mat: ".$maturl;
	echo "   URL mdl: ".$regurl;
	echo "   in: ".$in;*/

//$in = (string)"1@".$pid."@".$pname."~";
$in = str_replace("0", "*", $in);

//echo "Cadena de entrada: ".$in;

$param = array('monto' => $in,);

//chequeo por error con el cliente
$response = $client->call('calcIVA', $param);

if ($client->fault) {
	echo '<h2>Fault</h2><pre>';
	//print_r($response);
	echo '</pre>';
} //end if
else {
	// Check for errors	
	$err = $client->getError();

	if ($err == "XML error parsing SOAP payload on line 2: Invalid document end") {
		$err = "Ha ocurrido un error en la conexión con la estación que ejecuta esta práctica. Por favor intente nuevamente en unos minutos.";
		header("Location: ../Errors/error.php?err=" . $err);
	}else if ($err) {
		$err = "Ha ocurrido un error desconocido.";
		header("Location: ../Errors/error.php?err=" . $err);
	}


	if (!$err) {
		$str .= $response;

		$str = str_replace("*", "0", $str);

		$ok = substr($str, 0, 2);
		$ok = substr($ok, 0, -1);

		$str = substr($str, 2);

		$files =  explode("@", $str);
		if ($str && $ok == 'T') {
			for ($i = 0, $j = 0; $i < count($files); $i++) {
				list($fname, $fsize) = explode(">", $files[$i]);

				//Creando consulta
				$query = "SELECT url FROM sld_stations WHERE ip='$ip'";

				//Ejecutando consulta
				$result = $sql->SQLQuery($query);
				$url = $result[0]['url'];

				$ofpath = "$url" . $stpath . "" . $fname;

				$dfpath = $rfolder . "//" . $fname;

				$fcontent = file_get_contents($ofpath);

				$int = file_put_contents($dfpath, $fcontent);

				if (file_exists($dfpath) && $int)
					$j++;
			} //end for

			//Creando consulta
			$query = "UPDATE sld_practices SET ok=1 WHERE id=" . $pid;

			//$fstr = '';

			//Ejecutando consulta
			$sql->SQLQuery($query);

			$edate = date("dmyHis");

			//Creando consulta
			$query = "UPDATE sld_practices SET edate=('$edate') WHERE id=" . $pid;

			//Ejecutando consulta
			$sql->SQLQuery($query);

			// Actualizar valor de pcount
			$query = "SELECT pcount FROM sld_stations WHERE ip='$ip'";
			//Ejecutando consulta
			$result = $sql->SQLQuery($query);
			$pcount = $result[0]['pcount'];

			//Consulta para insertar accesos a estaciones
			$query = "INSERT INTO uso_estaciones (pname, ip, pcount, date, edate) VALUES ('$pname', '$ip', '$pcount', '$date', '$edate')";

			//Ejecutando consulta
			$sql->SQLQuery($query);

			//if($j == $i)
			header("Location: details.php?res=" . $uid . "/" . $pfolder . "&rid=" . $pid);
		} //end if
		else {
			header("Location: ../Errors/error.php?err=" . $str);
			//if($str == 1 ) { header("Location: ../Errors/ValidateError.htm"); }  //esto es para la presentacion de pag de validacion de los errores....
			//elseif($str == 2 ) { header("Location: ../Errors/Error.htm"); }
			//elseif($str == 3 ) { header("Location: ../Errors/eupload.htm"); }
			//elseif($str == 4 ) { header("Location: ../Errors/ein.htm"); }
			//else 
			//echo $str;

			//Creando consulta
			//cambiado$query = "UPDATE sld_stations SET state='wait', pcount=".($pcount-1)." WHERE ip='$ip'";
			// actualizar estado off a wait con un tiempo de espera de 10 min por ejemplo
			// modificar estado busy a wait ante error en ejecucion de practicas

			//Ejecutando consulta
			//cambiado$sql->SQLQuery($query);

			//Creando consulta
			$query = "UPDATE sld_practices SET error=('$out') WHERE id=" . $pid;

			if (is_numeric($pid)) {
				$limit = 1;
				$where = "id=" . $pid;
			} //end if
			else if (is_string($pid)) {
				$ids = explode(":", $pid);

				$limit = count($ids);
				$where = "(id=" . $ids[0];
				for ($i = 1; $i < $limit; $i++) {
					$where .= " OR id=" . $ids[$i];
				} //end for
				$where .= ")";
			} //end else if

			//Creando consulta
			$query = "SELECT uid, pname, date FROM sld_practices WHERE $where LIMIT $limit";

			//Ejecutando consulta
			$results = $sql->SQLQuery($query);

			//Creando consulta
			$query = "DELETE FROM sld_practices WHERE $where LIMIT $limit";

			//Ejecutando consulta
			$sql->SQLQuery($query);

			for ($i = 0; $i < $limit; $i++) {
				$rfolder = dirname(dirname(__FILE__)) . "/results/" . $results[$i]['uid'] . "/" . $results[$i]['pname'] . $results[$i]['date'];

				remove_dir($rfolder);
			} //end for

		} //end else
	}
}

//Guardar �ltimo acceso
$uaccess = date("dmyHis");

//Actualizar valor de lastaccess
$query = "UPDATE sld_stations SET lastaccess=" . ($uaccess) . " WHERE ip='$ip'";

//Ejecutando consulta
$sql->SQLQuery($query);

// Actualizar valor de pcount
$query = "SELECT pcount FROM sld_stations WHERE ip='$ip'";

//Ejecutando consulta
$result = $sql->SQLQuery($query);

$pcount = $result[0]['pcount'];

if ($pcount > 1)
	$query = "UPDATE sld_stations SET state='busy', pcount=" . ($pcount - 1) . " WHERE ip='$ip'";
else
	$query = "UPDATE sld_stations SET state='wait', pcount = 0 WHERE ip='$ip'";


//si hay error en conexi�n pongo la estaci�n en off

if ($err)
	$query = "UPDATE sld_stations SET state='off', pcount = 0 WHERE ip='$ip'";

//Ejecutando consulta
$sql->SQLQuery($query);
	
	    /*$err = (string)$pcount;
		header("Location: ../Errors/error.php?err=".$err);
		exit;*/

?>