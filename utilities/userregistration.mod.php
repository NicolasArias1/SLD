<?php
	include('../config/config.php');
	
	include('../inc/db.class.php');
	include('../inc/man.class.php');
	include('../inc/sch.class.php');
	include('../inc/useful.fns.php');
	include('../inc/user.class.php');
	
	$method = $_SERVER['REQUEST_METHOD'];
	
		
	if(($method=='POST') || ($method=='GET')) {
		if($method=='POST'){
			$name = htmlentities(trim((string)$_POST['uname']));
			$login = trim((string)$_POST['ulogin']);
			$password = (string)$_POST['upassword'];
			$mail = mailaddress(trim((string)$_POST['umail'])); //quito chequeo de email
			//$mail = (string)$_POST['umail'];
			$domain = (string)$_POST['udomain'];}
		/*else{
			$name = htmlentities(trim((string)$_GET['uname']));
			$login = trim((string)$_GET['ulogin']);
			$password = (string)$_GET['upassword'];
			$mail = mailaddress(trim((string)$_GET['umail']));
			$domain = (string)$_GET['udomain'];}*/
		
		if($password != '') //si ubb  no md5 entonces if($password != '' || $domain == 'ubb')    && $domain != 'ubb'
			$password = password_hash($password, PASSWORD_DEFAULT);
			
		/*if ($domain == 'ubb') // password de ubb con md5
			$password = (string)$_POST['upassword_md5'];*/
		
            if ($domain == 'uclv') // password de uclv con md5
			$password = (string)$_POST['upassword'];
		
		
		//Creando objeto Configuration
	  //$config = new ManageConfiguration();
	
	  //Cargando par�metros MySQL
  	//$config->getMySQLParameters();
	  
	  //Creando objeto SQL
		$sql = new SQL();
		
		//Conectando con el servidor
		$sql->SQLConnection();
		
		if($name && $login && $mail && $password) {
			//Creando consultas
			$query[0] = "SELECT id FROM sld_users WHERE name='$name'";
			$query[1] = "SELECT id FROM sld_users WHERE login='$login'";
			$query[2] = "SELECT id FROM sld_users WHERE mail='$mail'";
			
			//Ejecutando consulta
			for($i=1, $j=1; $i<3; $i++) {
				$res = $sql->SQLQuery($query[$i]);
				$rid[$i] = $res[0]['id'];
				
				if($rid[$i]) {
					$efnum[$j] = $i;
					$j++;
				}//end if
			}//end for
			
			if(!$rid[1] && !$rid[2] || ($domain == 'ubb') || ($domain == 'uclv')) { //!$rid[0] pueden haber nombres iguales
				//Creando consulta
				if(!$rid[1] && !$rid[2]){
					$query = "INSERT INTO sld_users (name, login, password, domain, mail, level, type, status, date, time )
									VALUES ('$name', '$login', '$password', 'db', '$mail', 3, 3, 'online', NOW(), NOW())";									
									
				
					//Ejecutando consulta
					$sql->SQLQuery($query);
				
					//Tomando el ID resultante de la operaci�n
					$nuid = $sql->SQLInsertID();}
					
				if($domain == 'ubb' || $domain == 'uclv') {
					$query = "UPDATE sld_users SET name ='$name', mail = '$mail', password = '$password' WHERE ( login = '$login')";
					
					//Ejecutando consulta
					$sql->SQLQuery($query);
					
					$query = "SELECT id FROM sld_users WHERE (login = '$login')";
					
					//Ejecutando consulta y creando objeto Record
					$results = new RecordSet($sql->SQLQuery($query));
					
					//Tomando el ID resultante de la operaci�n					
					$nuid = $results->Celd(0,'id');	
					}					
									
				
				//Cerrando conexi�n
				$sql->SQLClose();
				
				if($nuid) {
					session_start();
					
					//Creando objeto User
					$user = new UserSession();
					
					$user->setUID($nuid);
					$user->setName($name);
					$user->setLogin($login);
					$user->setEmail($mail);
					$user->setPriority('3');
					$user->setDomain('db');
					
					//include('modules/setoutline.mod.php'); comentandolo funciona
					//include('modules/setonline.mod.php'); comentandolo funciona					
					
					$_SESSION['user'] = serialize($user);
					
					header('Location: ../modules/user/index.php');
					//header('Location: ../addusers.php?alert=1');
					exit;
				}//end if
			}//end if
			else {
				$efnum = implode(":", $efnum);
				header('Location: ../general/addusers.php?alert=2&error='.$efnum);
			}//end else
		}//end if
		else {
			header('Location: ../general/addusers.php?alert=3');
			exit;
		}//end else
	}//end if
	else {
		header('Location: ../general/addusers.php?alert=4');
		exit;
	}//end else
?>
