<?php
	include('../config/config.php');
	
	include('../inc/db.class.php');
	include('../inc/man.class.php');
	include('../inc/sch.class.php');
	include('../inc/useful.fns.php');
	include('../inc/user.class.php');
	
	$method = $_SERVER['REQUEST_METHOD'];
	
	if($method=='POST') {
		$name = htmlentities(trim((string)$_POST['uname']));
		$login = trim((string)$_POST['ulogin']);
		$password = (string)$_POST['upassword'];
		$mail = mailaddress(trim((string)$_POST['umail']));
		
		if($password != '')
			$password = md5($password);
		
		//Creando objeto Configuration
	  //$config = new ManageConfiguration();
	
	  //Cargando parámetros MySQL
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
			for($i=0, $j=0; $i<3; $i++) {
				$res = $sql->SQLQuery($query[$i]);
				$rid[$i] = $res[0]['id'];
				
				if($rid[$i]) {
					$efnum[$j] = $i;
					$j++;
				}//end if
			}//end for
			
			if(!$rid[0] && !$rid[1] && !$rid[2]) {
				//Creando consulta
				$query = "INSERT INTO sld_users (name, login, password, domain, mail, level, type, status)
									VALUES ('$name', '$login', '$password', 'db', '$mail', 3, 3, 'outline')";
				
				//Ejecutando consulta
				$sql->SQLQuery($query);
				
				//Tomando el ID resultante de la operación
				//$nuid = $sql->SQLInsertID();
				
				//Cerrando conexión
				$sql->SQLClose();
				
				if($query) {
					header('Location: ../addusers.php?alert=1');
					exit;
				}//end if
			}//end if
			else {
				$efnum = implode(":", $efnum);
				header('Location: ../addusers.php?alert=2&error='.$efnum);
			}//end else
		}//end if
		else {
			header('Location: ../addusers.php?alert=3');
			exit;
		}//end else
	}//end if
	else {
		header('Location: ../addusers.php?alert=4');
		exit;
	}//end else
?>