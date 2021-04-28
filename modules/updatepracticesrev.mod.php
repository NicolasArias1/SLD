<?php
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
	
	$date = date("dmyHis");
	
	$method = $_SERVER['REQUEST_METHOD'];
	
	if($method=='POST') {
		
		$prev = $_POST['prev'];
		
		$rid = $_POST['rid'];
		
		$page = $_POST['page'];

    if($sql->errno)
			header('Location: ../logout.php');
			
					
		//Creando objeto SQL
		$sql = new SQL();
		
		//Conectando con el servidor
		$sql->SQLConnection();
		
		if($prev) {		
	 		//Creando consulta
			$query = "SELECT name FROM sld_users WHERE id=".$uid;
			
			//Ejecutando consulta
			$results = $sql->SQLQuery($query);
	 		
			//Creando consulta
			$query = "UPDATE sld_practices SET rdate=('$date'), tlogin=('".$results[0]['name']."') WHERE id=".$rid;
			
			//Ejecutando consulta
			$sql->SQLQuery($query);
					
			header('Location: ../admin/index.php');		
		
	  }//end if
	  
	  else {
	  	
	  	//Creando consulta
			$query = "UPDATE sld_practices SET revisar=('1') WHERE id=".$rid;
			
			//Ejecutando consulta
			$sql->SQLQuery($query);
					
			header('Location: ../user/mypractices.php');	
			
		}//end else
				
		//Cerrando conexión
		$sql->SQLClose();
	}//end if
?>