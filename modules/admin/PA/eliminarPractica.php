<?php
include('../../../inc/useful.fns.php');
include('../../../inc/user.class.php');
include('../../../config/config.php');	
include('../../../inc/db.class.php');
 
 
if(isset($_GET["valor"]))
{
	ob_start();
	$valor=$_GET["valor"];
	eliminarPractica($valor);
	ob_end_flush();
	echo 'Pr�ctica borrada correctamente';
}

function eliminarPractica($valor){
	
	$sql = new SQL();
	$sql->SQLConnection();
	$query = "SELECT * FROM sld_practices_data_2 where pname= '$valor' ";
	$result = $sql->SQLQuery($query);
	$practicaExistente= $sql->count;

	if($practicaExistente != 0 ){
		$valor = substr($valor, 0, -1);
		$valor = $valor.'s';
		$directorioAeliminar = substr($valor, 2); // Corto el m_ al nombre de la pr�ctica
		eliminarDir("../../creacionPracticas/".$directorioAeliminar);
		$query="DELETE FROM sld_practices_data_2 WHERE pname = '$valor'";
		queryEnBaseDatos($tabla,$query);
		$query="DELETE FROM sld_practices_data WHERE pname = '$valor'";
		queryEnBaseDatos($tabla,$query);
	}
	
	$real = substr($valor, 0, -1);
    $real = $real."r";
	
	$aBorrar = substr($real, 0, -1);
    $aBorrar = $aBorrar.'s';
	
	borrarPracticaDelServidor($aBorrar);
	
	$sql = new SQL();
	$sql->SQLConnection();
	$query = "SELECT * FROM sld_practices_data_2 where pname= '$real' ";
	$result = $sql->SQLQuery($query);
	$practicaExistente= $sql->count;
	
	//if($practicaExistente != 0 ){
	    $directorioAeliminar = substr($real, 2);
		eliminarDir("../../creacionPracticas/".$directorioAeliminar);
		
		$query="DELETE FROM sld_practices_data_2 WHERE pname = '$real'";
		queryEnBaseDatos($tabla,$query);
		$query="DELETE FROM sld_practices_data WHERE pname = '$real'";
		queryEnBaseDatos($tabla,$query);
	
	//}
	header ('refresh:3; url=http://138.100.76.170/admin/PA/practicas_creadas.php');

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
	$sql = new SQL();
	
	//Conectando con el servidor
	$sql->SQLConnection();
	$sql->SQLQuery($query);
}

function borrarPracticaDelServidor($aBorrar){
	$sql = new SQL();
	$sql->SQLConnection();
	$query = "SELECT * FROM sld_stations where sname='ServerUPM' ";
	$result = $sql->SQLQuery($query);
	$practicaExistente= $sql->count;
	$practicasServidor = $result[0]['practices'];

	$resultado    = str_replace (";".$aBorrar, "", $practicasServidor);
	
	
	$query="UPDATE sld_stations SET practices='$resultado' WHERE sname= 'ServerUPM'";
	queryEnBaseDatos($tabla,$query);
}

if(!empty($_POST['campos'])) {
  //echo 'Entrando en Borrado multiple';
  ob_start();
  $aLista=array_keys($_POST['campos']);
  foreach($aLista as $iId) {
	eliminarPractica($iId);
  }
  ob_end_flush();
  echo 'Pr�cticas borradas correctamente';
  //echo 'Borrado multiple';
}

if(!isset($_GET["valor"]) && empty($_POST['campos'])){
	ob_start();
	header ('refresh:3; url=http://138.100.76.170/admin/PA/practicas_creadas.php');
	ob_end_flush();
	echo 'No ha seleccionado ninguna pr�ctica para borrar';
}
?>
