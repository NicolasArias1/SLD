<?php
	include('../config/config.php');
	
	include('../inc/db.class.php');
	//include('../inc/man.class.php');
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
			
	$method = $_SERVER['REQUEST_METHOD'];
	
	if($method=='POST') {
		$id = $_POST['id'];
		$uname = htmlentities(trim((string)$_POST['name']));
		$ulogin = trim((string)$_POST['login']);
		$umail = mailaddress(trim((string)$_POST['mail']));
		$upassword = (string)$_POST['password'];
		
		if($upassword)
			$upassword = md5($upassword);
		
		$page = $_POST['page'];

		//Creando objeto SQL
		$sql = new SQL();
		
		//Conectando con el servidor
		$sql->SQLConnection();
		
		if($id && $id == $uid && $uname && $ulogin && $domain == 'db' && $level != 1 && $umail) {
			//Creando consultas
			$query[0] = "SELECT id FROM sld_users WHERE name='$uname' AND id!=$id";
			$query[1] = "SELECT id FROM sld_users WHERE login='$ulogin' AND id!=$id";
			$query[2] = "SELECT id FROM sld_users WHERE mail='$umail' AND id!=$id";
			
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
				if($upassword)
					$query = "UPDATE sld_users SET name='$uname', login='$ulogin', password='$upassword', mail='$mail' WHERE id=$id";
				else
					$query = "UPDATE sld_users SET name='$uname', login='$ulogin', mail='$umail' WHERE id=$id";
				
				//Ejecutando consulta
				$sql->SQLQuery($query);
				
				/*$query = "UPDATE comments SET ulogin='$ulogin' WHERE ulogin='$login'";
				
				//Ejecutando consulta
				$sql->SQLQuery($query);
				
				$query = "UPDATE comments SET publisher='$ulogin' WHERE publisher='$login'";
				
				//Ejecutando consulta
				$sql->SQLQuery($query);
				
				$query = "UPDATE resources SET sender='$ulogin' WHERE sender='$login'";
				
				//Ejecutando consulta
				$sql->SQLQuery($query);
				
				$query = "UPDATE resources SET publisher='$ulogin' WHERE publisher='$login'";
				
				//Ejecutando consulta
				$sql->SQLQuery($query);*/
								
				$ofilelog = $uid.".".$login.".log";
				$efilelog = $id.".".$ulogin.".log";
				
				/*$log = new ManageLog($ofilelog);
				
				if($log->exFile()) {
					$log->renameFile($efilelog);
				}//end if*/
				
				$login = $ulogin;
				
				$user->setName($uname);
				$user->setLogin($ulogin);
				$user->setEmail($umail);
				$_SESSION['user'] = serialize($user);
											
				include('setonline.mod.php');
				//include('writelog.mod.php');
				
				//Cerrando conexión
				$sql->SQLClose();
				
				header('Location: '.$page.'?alert=1');
			}//end if
			else {
				$efnum = implode(":", $efnum);
				header('Location: '.$page.'?alert=2&error='.$efnum);
			}//end else
		}//end if
		else {
			header('Location: '.$page.'?alert=3');
			exit;
		}//end else
	}//end if
	else {
		header('Location: '.$page.'?alert=4');
		exit;
	}//end else
?>
