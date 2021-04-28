<?php
	/* Esta pagina solo se usara para generar el archivo Excel para la opción del menu "Tabla prácticas exitosas"
	
	*/
	include('../config/config.php');
	
	include('../inc/db.class.php');
	include('../inc/sch.class.php');
	include('../inc/useful.fns.php');
	include('../inc/user.class.php');
	
	session_start();
	
	$session = $_SESSION['user'];

	if(empty($session)) {
		header('Location: ../index.php');
	}//end if
	
	$user = unserialize($session);
	$uid = $user->getUID();
	$name = $user->getName();
	$login = $user->getLogin();
	$mail = $user->getEMail();
	$domain = $user->getDomain();
	$level = $user->getPriority();
	$_SESSION['user'] = serialize($user);
	
	if($level > 1) {
		if($level == 2)
			header('Location: ../operator/index.php');
		else if($level == 3)
			header('Location: ../user/index.php');
		else
			header('Location: ../logout.php');
	}//end if
	
	$method = $_SERVER['REQUEST_METHOD'];
	$id = $_GET['id'];
	$body = $_GET['body'];
	$order = $_GET['order'];
	$show = $_GET['show'];
	$page = $_GET['page'];
	$type = $_GET['type'];
	$alert = $_GET['alert'];
	$res = $_GET['res'];
	
	
	
	
	
	
	//Generación de archivo a traves de la consulta.
	
	$sql = new SQL();
	
	//Conectando con el servidor
	$sql->SQLConnection();