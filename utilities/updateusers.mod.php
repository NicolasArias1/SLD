<?php
	include('../config/config.php');
	
	include('../inc/db.class.php');
	include('../inc/man.class.php');
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
	$login = $user->getLogin();
	$mail = $user->getEMail();
	$domain = $user->getDomain();
	$level = $user->getPriority();
	$_SESSION['user'] = serialize($user);
	
	if($level > 1) {
		if($level == 2)
			header('Location: ../operator/index.php');
		else
			header('Location: ../modules/user/index.php');
	}//end if
	
	$method = $_SERVER['REQUEST_METHOD'];
	
	if($method == 'POST') {
		$action = $_POST['action'];
		$rpage = $_POST['rpage'];
	
		//Creando objeto SQL
		$sql = new SQL();
		
		//Conectando con el servidor
		$sql->SQLConnection();
		
		if($sql->errno)
			header('Location: ../general/logout.php');
		
		if($action == 'edit' || $action == 'new') {
			$eid = $_POST['id'];
			$ename = tildes(xmlspecialchars(trim((string)$_POST['name'])));
			$elogin = trim((string)$_POST['login']);
			$epassword = (string)$_POST['password'];
			$email = mailaddress(trim((string)$_POST['mail']));
			$edomain = $_POST['domain'];
			$elevel = $_POST['level'];
			$etype = $_POST['type'];
			
			if($epassword != '')
				$epassword = password_hash($epassword,PASSWORD_DEFAULT);
			
			if($elevel == 2) {
				//Creando consulta
				$query = "SELECT COUNT(*) FROM categories";
				
				//Ejecutando consulta
				$results = $sql->SQLQuery($query);
				
				for($i=1, $j=0; $i <= $results[0]['COUNT(*)']; $i++) {
					if($_POST["$i"]) {
						$cid[$j] = $_POST["$i"];
						$j++;
					}//end if
				}//end for
			}//end if
			
			if($ename && $elogin && $email && $edomain && $elevel) {
				//Creando consulta
				$query = "SELECT id FROM sld_users WHERE ((name='$ename' OR login='$elogin') AND domain='$edomain')";
				
				//Ejecutando consulta
				$exist = $sql->SQLQuery($query);
				$nexist = $sql->count;
				
				if($action == 'new' && !$nexist && !$exist[0]['id']) {
					//Creando consulta
					if($edomain == 'db' && $epassword && $etype) {
						$query = "INSERT INTO sld_users (name, login, password, domain, mail, level, type, status)
											VALUES ('$ename', '$elogin', '$epassword', 'db', '$email', $elevel, $etype, 'outline')";
					}//end if
					
					//Ejecutando consulta
					$sql->SQLQuery($query);
					
					$nuid = $sql->SQLInsertID();
					
					//Asignar privilegios a operadores
					if($elevel == 2) {
						$cids = implode(";", $cid);
						
						//Creando consulta
						$query = "INSERT INTO area (uid, cids) VALUES ($nuid, '$cids')";
						
						//Ejecutando consulta
						$sql->SQLQuery($query);
					}//end if
					
					$txtlog = "?nid=".$nuid;
				}//end if
				else if($action == 'new') {
					header('Location: '.$rpage.'&alert=2');
					exit;
				}//end else
				
				if(($action == 'edit' && $eid && !$nexist) || ($action == 'edit' && $eid && $nexist && $eid == $exist[0]['id'])) {
					//Creando consulta
					$query = "SELECT login, domain, level, type, status FROM sld_users WHERE id=$eid LIMIT 1";
					
					//Ejecutando consulta y creando objeto Record
					$results = new RecordSet($sql->SQLQuery($query));
					
					$ologin = $results->Celd(0,'login');
					$odomain = $results->Celd(0,'domain');
					$olevel = $results->Celd(0,'level');
					$otype = $results->Celd(0,'type');
					$status = $results->Celd(0,'status');
					
					if(($otype == 3 && $odomain != 'db' && $edomain == 'db') || ($otype == 2))
						$etype = 1;
					
					if($uid == $eid || $status == 'outline') {
						//Creando consulta
						if($edomain == 'db' && $epassword)
							$query = "UPDATE sld_users SET name='$ename', login='$elogin', password='$epassword', domain='db', mail='$email', level='$elevel', type=$etype WHERE id=$eid LIMIT 1";
						else
							$query = "UPDATE sld_users SET name='$ename', login='$elogin', domain='$edomain', mail='$email', level='$elevel', type=$etype WHERE id=$eid LIMIT 1";
						
						//Ejecutando consulta
						$sql->SQLQuery($query);
						
						//Actualizar privilegios de operadores.
						if($elevel == 2) {
							$cids = implode(";", $cid);
							
							//Creando consulta
							$query = "SELECT id FROM area WHERE uid=$eid";
							
							//Ejecutando consulta
							$sql->SQLQuery($query);
							
							if(!$sql->count) {
								//Creando consulta
								$query = "INSERT INTO area (uid) VALUES ($eid)";
								
								//Ejecutando consulta
								$sql->SQLQuery($query);
							}//end if
							
							//Creando consulta
							$query = "UPDATE area SET cids='$cids' WHERE uid=$eid";
							
							//Ejecutando consulta
							$sql->SQLQuery($query);
						}//end if
						
						//Eliminar privilegios si el usuario era operador y deja de serlo.
						if($olevel == 2 && $elevel != 2) {
							//Creando consulta
							$query = "UPDATE area SET cids='' WHERE uid=$eid";
							
							//Ejecutando consulta
							$sql->SQLQuery($query);
						}//end if
						
						//Cambiar login de comentarios y logs
						if($elogin != $ologin) {
							//Creando consulta
							$query = "UPDATE comments SET ulogin='$elogin' WHERE ulogin='$ologin'";
							
							//Ejecutando consulta
							$sql->SQLQuery($query);
							
							$ofilelog = $eid.".".$ologin.".log";
							$efilelog = $eid.".".$elogin.".log";
														
							$log = new ManageLog($ofilelog);
							
							if($log->exFile()) {
								$log->renameFile($efilelog);
							}//end if
						}//end if
						
						//Actualizar los datos de la sessi�n en caso de que se este editando sus
						//propios datos.
						if($uid == $eid) {
							
							$user = unserialize($session);
							$user->setLogin($elogin);
							$user->setName($ename);
							$user->setEmail($email);
							$user->setPriority($elevel);
							$user->setDomain($edomain);
							$_SESSION['user'] = serialize($user);
							
							$login = $elogin;
							$domain = $edomain;
							
							if($elevel==2) {
								header('Location: ../operator/index.php');
								exit;
							}//end if
							else if($elevel==3){
							
								header('Location: ../modules/user/index.php');
								exit;
							}//end else if
						}//end if
									
						$txtlog = "?eid=".$eid;
					}//end if
					
				}//end if
				
				else if($action == 'edit') {
					
					header('Location: '.$rpage.'&alert=2');
					exit;
				}//end else
			}//end if
			else {
				
				header('Location: '.$rpage.'&alert=3');
				exit;
			}//end else
			
			include('setonline.mod.php');
			//include('writelog.mod.php');
			
			//Cerrando conexi�n
			$sql->SQLClose();
		
			header('Location: '.$rpage.'&alert=1');

			
		}//end if
		else {
			header('Location: '.$rpage.'&alert=4');
			exit;
		}//end else
	}//end if
	
	if($method == 'GET') {
		$body = $_GET['body'];
		$order = $_GET['order'];
		$show = $_GET['show'];
		$page = $_GET['page'];
		$action = $_GET['action'];
		$id = $_GET['id'];
		$call = "indirect";
		
		//Creando objeto SQL
		$sql = new SQL();
		
		//Conectando con el servidor
		$sql->SQLConnection();
		
		if(is_numeric($id)) {
			$limit = 1;
			$where[0] = "id=".$id;
			$where[1] = "uid=".$id;
		}//end if
		else if(is_string($id)) {
			$ids = explode(":", $id);
			$limit = count($ids);
			$where[0] = "(id=".$ids[0];
			$where[1] = "(uid=".$ids[0];
			for($i=1; $i < $limit; $i++) {
				$where[0] .= " OR id=".$ids[$i];
				$where[1] .= " OR uid=".$ids[$i];
			}//end for
			$where[0] .= ")";
			$where[1] .= ")";
		}//end else if
		
		if($action == 'delete') {
			//Creando consulta
			$query = "DELETE FROM sld_users WHERE $where[0] LIMIT $limit";
			
			//Ejecutando consulta
			$sql->SQLQuery($query);
			
			//Creando consulta
			$query = "DELETE FROM sld_practices WHERE $where[1] LIMIT $limit";
			
			//Ejecutando consulta
			$sql->SQLQuery($query);
			
			$txtlog = "?did=".$id;
		}//end if
		
		if($action == 'accept') {
			//Creando consulta
			$query = "UPDATE sld_users SET type=1 WHERE $where[0] LIMIT $limit";
			
			//Ejecutando consulta
			$sql->SQLQuery($query);
			
			$txtlog = "?aid=".$id;
		}//end else if
		
			include('setonline.mod.php');
		//include('writelog.mod.php');
		
		if($action != 'select')
			include('users.mod.php');
		
		//Cerrando conexi�n
		$sql->SQLClose();
		
		//Salir de la sessi�n si el administrador se elimina a si mismo;
		if($uid == $id) {
			header('Location: ../general/logout.php');
		}//end if
	}//end if
?>