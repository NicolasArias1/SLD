<?php
include('../../inc/useful.fns.php');
include('../../inc/user.class.php');
include('../../config/config.php');	
include('../../inc/db.class.php');

if(isset($_GET["valor"]))
{
	ob_start();
	$valor=$_GET["valor"];
   eliminarDir("../creacionPracticas/".$_GET["valor"]);
   $query="DELETE FROM sld_practices_data_2 WHERE pname = '$valor'";
	queryEnBaseDatos($tabla,$query);
	
	header ('refresh:2; url=http://localhost/xampp/modules/user/practicas_creadas.php');
	ob_end_flush();
	echo 'Pr�ctica borrada correctamente';
}

function eliminarDir($carpeta){
	foreach(glob($carpeta."/*") as $archivos_carpeta) {
		//echo $archivos_carpeta;
		if(is_dir($archivos_carpeta))
			eliminarDir($archivos_carpeta);
		else
			unlink($archivos_carpeta);
	}
	rmdir($carpeta);
	
}

// Funcion de querys sobre la base de datos
function queryEnBaseDatos($tabla,$query){	
	require_once('../connections/ajax_form.php'); 		
	mysql_query($query);
}
?>
