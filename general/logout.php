<?php
	include('../config/config.php');
	
	include('../inc/db.class.php');
	include('../inc/useful.fns.php');
	include('../inc/user.class.php');
	
	session_start();
	
	$session = $_SESSION['user'];
	$user = unserialize($session);
	$uid = $user->getUID();
	$name = $user->getName();
	$login = $user->getLogin();
	$mail = $user->getEMail();
	$domain = $user->getDomain();
	$_SESSION['user'] = serialize($user);
	
	//Creando objeto SQL
  $sql = new SQL();
	
	//Conectando con el servidor
	$sql->SQLConnection();
	
	//Creando consulta
	$query="SELECT COUNT(*) FROM sld_users WHERE id=$uid";
	
	//Ejecutando consulta
	$sql->SQLQuery($query);
	
	if($sql->count) {
		//Reportar en la BD como outline
		//Creando consulta
		$query="UPDATE sld_users SET status='outline', time=NOW() WHERE id=$uid";
		
		//Ejecutando consulta
		$sql->SQLQuery($query);
	}//end if
	
	include('../utilities/setoutline.mod.php');
	
	//Cerrando conexi�n
	$sql->SQLClose();
	
	session_destroy();
	
	//include('modules/writelog.mod.php');
	
	header('Location: ../index.php');
?>