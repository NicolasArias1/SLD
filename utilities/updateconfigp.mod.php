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
			$esid = htmlentities(trim((string)$_POST['sid']));
			$epname = trim((string)$_POST['pname']);
			$epcname = (string)$_POST['pcname'];
			$epath = trim((string)$_POST['path']);
			$estpath = (string)$_POST['stpath'];
			
			$etype = $_POST['type'];
			$evisibilidad = $_POST['visibilidad'];
			
			//echo $esid."<br>".$epname."<br>".$epcname."<br>".$epath."<br>".$estpath."<br>".$etype; exit;
			if($esid && $epname && $epcname && $epath && $estpath && $etype && $evisibilidad) {
				//Creando consulta
				$query = "SELECT id FROM sld_practices_data WHERE ((pname='$epname' OR pcname='$epcname') AND type='$etype')";
				
				//Ejecutando consulta
				$exist = $sql->SQLQuery($query);
				$nexist = $sql->count;
				
				if($action == 'new' && !$nexist && !$exist[0]['id']) {
					//Creando consulta
					if($edomain == 'db' && $epassword && $etype) {
						$query = "INSERT INTO sld_practices_data (sid, pname, pcname, path, stpath, type, visibilidad)
											VALUES ('$esid', '$epname', '$epcname', 'epath', '$estpathi', 'etype')";
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
					$query = "UPDATE sld_practices_data SET sid='$esid', pname='$epname', pcname='$epcname', path='$epath', stpath='$estpath', type='$etype' WHERE id=$eid LIMIT 1";
					
					//Ejecutando consulta
					$sql->SQLQuery($query);
					
					//$txtlog = "?eid=".$eid;
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
			$where[1] = "pid=".$id;
		}//end if
		else if(is_string($id)) {
			$ids = explode(":", $id);
			$limit = count($ids);
			$where[0] = "(id=".$ids[0];
			$where[1] = "(pid=".$ids[0];
			for($i=1; $i < $limit; $i++) {
				$where[0] .= " OR id=".$ids[$i];
				$where[1] .= " OR pid=".$ids[$i];
			}//end for
			$where[0] .= ")";
			$where[1] .= ")";
		}//end else if
		
		if($action == 'delete') {
			//Creando consulta
			$query = "DELETE FROM sld_practices_data WHERE $where[0] LIMIT $limit";
			
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
			$query = "UPDATE sld_practices_data SET type=1 WHERE $where[0] LIMIT $limit";
			
			//Ejecutando consulta
			$sql->SQLQuery($query);
			
			$txtlog = "?aid=".$id;
		}//end else if
		
		include('setonline.mod.php');
		//include('writelog.mod.php');
		
		if($action != 'select')
			include('configp.mod.php');
		
		//Cerrando conexi�n
		$sql->SQLClose();
		
		//Salir de la sessi�n si el administrador se elimina a si mismo;
		if($uid == $id) {
			header('Location: ../general/logout.php');
		}//end if
	}//end if
?>
