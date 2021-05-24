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
	
	$datetime = date('Y')."-".date('m')."-".date('d')." ".date('H').":".date('i').":".date('s');
	
	$method = $_SERVER['REQUEST_METHOD'];
	
	if($method=='POST') {
		$id = $_POST['id'];
		$rid = $_POST['rid'];
		$advuser = $_POST['advuser'];
		$page = $_POST['page'];
		$action = $_POST['action'];
		//$vote = $_POST['vote'];
		$comment = (string)$_POST['comment_txt'];
//		echo $id."\n";
//		echo $rid."\n";
//		echo $advuser."\n";
//		echo $page."\n";
//		echo $action."\n";
//		echo $comment."\n";
//		exit;
		
//		//Creando objeto Configuration
//  	$config = new ManageConfiguration();
//		
//		//Cargando par�metros de contribuci�n
//		$config->getContribution();
//	  
//	  //Cargando par�metros MySQL
//	  $config->getMySQLParameters();
	  
	  //Creando objeto SQL
		$sql = new SQL();
	  
		//Conectando con el servidor
		$sql->SQLConnection();
		
		if($sql->errno)
			header('Location: ../general/logout.php');
		
		if($action == 'new' || $action == 'edit') {
			if(!COM_CONT) {
				header('Location: '.$page);
				exit;
			}//end if
			
			if($comment && $rid) {
				//Creando consulta
				$query = "SELECT comments, ncomments FROM sld_practices WHERE id=$rid";
				
				//Ejecutando consulta
				$results = $sql->SQLQuery($query);
				
				if($results[0]['comments'])
					$cids = explode(";", $results[0]['comments']);
				else
					$cids = array();
				
				if($results[0]['ncomments'])
					$ncids = explode(";", $results[0]['ncomments']);
				else
					$ncids = array();
				
				if($action == 'new') {
					//Creando consulta
					if($advuser) {
						$query = "INSERT INTO comments (rid, uid, ulogin, comment, sdate, publisher, pdate, new)
											VALUES ($rid, $uid, '$login', '$comment', '$datetime', '$login', '$datetime', 0)";
					}//end if
					else {
						$query = "INSERT INTO comments (rid, uid, ulogin, comment, sdate, new)
											VALUES ($rid, $uid, '$login', '$comment', '$datetime', 1)";
					}//end else
					
					//Ejecutando consulta
					$sql->SQLQuery($query);
					
					//Tomando el ID resultante de la operaci�n
					$ncid[0] = $sql->SQLInsertID();
					
					$cids = array_merge($cids, $ncid);
					
					if(!$advuser)
						$ncids = array_merge($ncids, $ncid);
					
					$txtlog = "?ncid=".$ncid[0];
				}//end if			
				else if($id && $action == 'edit') {
					$cid[0] = $id;
					
					if($advuser) {
						//Creando consulta
						$query = "UPDATE comments SET comment='$comment', publisher='$login', pdate='$datetime', new=0 WHERE (id=$id AND rid=$rid)";
						
						$ncids = array_diff($ncids, $cid);
					}//end if
					else {
						//Creando consulta
						$query = "UPDATE comments SET comment='$comment', new=1 WHERE (id=$id AND rid=$rid)";
						
						$ncids = array_merge($ncids, $cid);
					}//end else
					
					//Ejecutando consulta
					$sql->SQLQuery($query);
					
					$txtlog = "?ecid=".$id;
				}//end if
				
				sort($cids);
				sort($ncids);
				
				$strids = implode(";", $cids);
				$strnids = implode(";", $ncids);
				
				//Creando consulta
				$query = "UPDATE sld_practices SET comments='$strids', ncomments='$strnids' WHERE id=$rid LIMIT 1";
				
				//Ejecutando consulta
				$sql->SQLQuery($query);
			}//end if
			else {
				header('Location: '.$page.'&alert=2');
				exit;
			}//end if
		}//end if
		else if(!$vote) {
			header('Location: '.$page.'&alert=3');
			exit;
		}//end if
		
//		if($vote) {
//			if(!VOT_CONT) {
//				header('Location: '.$page);
//				exit;
//			}//end if
//			
//			//Creando consulta
//			$query = "SELECT rvalued FROM users WHERE (login='$login' AND domain='$domain')";
//			
//			//Ejecutando consulta
//			$results = $sql->SQLQuery($query);
//			
//			$rvotes = $results[0]['rvalued'];
//			$arvotes = explode(";", $rvotes);
//			
//			if(!in_array($rid, $arvotes)) {
//				//Creando consulta
//				$query = "SELECT votes FROM resources WHERE id=$rid";
//				
//				//Ejecutando consulta
//				$results = $sql->SQLQuery($query);
//				
//				if($results[0]['votes']!='') {
//					$votes = $results[0]['votes'].";".$vote;
//					$arvotes = explode(";", $votes);
//				}//end if
//				else {
//					$votes = $vote;
//					$arvotes[0] = $vote;
//				}//end else
//				
//				$rank = round(array_sum($arvotes)/count($arvotes));
//				
//				//Creando consulta
//				$query = "UPDATE resources SET votes='$votes', rank=$rank WHERE id=$rid";
//				
//				//Ejecutando consulta
//				$sql->SQLQuery($query);
//				
//				if($rvotes!='')
//					$rvotes = $rvotes.";".$rid;
//				else
//					$rvotes = $rid;
//				
//				//Creando consulta
//				$query = "UPDATE users SET rvalued='$rvotes' WHERE (login='$login' AND domain='$domain')";
//				
//				//Ejecutando consulta
//				$res = $sql->SQLQuery($query);
//				
//				if($txtlog)
//					$txtlog .= "&vot=".$vote;
//				else
//					$txtlog = "?vot=".$vote;
//			}//end if
//		}//end if
		
		include('setonline.mod.php');
		
		if($txtlog) {
			//include('writelog.mod.php');
		}//end if
		
		//Cerrando conexi�n
		$sql->SQLClose();	
		
		if(!$vote)
			header('Location: '.$page.'&alert=1');
		else
			header('Location: '.$page);
	}//end if
	
	if($method == 'GET') {
		$id = $_GET['id'];
		$rid = $_GET['rid'];
		$action = $_GET['action'];
		$advuser = $_GET['advuser'];
		$call = "indirect";
		
//		//Cargando configuraci�n
//	  $config = new ManageConfiguration();
//	
//	  //Cargando par�metros MySQL
//	  $config->getMySQLParameters();
	  
	  //Creando objeto SQL
		$sql = new SQL();
		
		//Conectando con el servidor
		$sql->SQLConnection();
		
		if($action == 'select') {
			//Creando consulta
			$query = "SELECT * FROM comments WHERE id=$id";
			
			//Ejecutando consulta
			$results = $sql->SQLQuery($query);
			
			echo $results[0]['comment'];			
		}//end if
		
		if($action == 'delete' || $action == 'accept') {
			//Creando consulta
			$query = "SELECT comments, ncomments FROM sld_practices WHERE id=$rid";
			
			//Ejecutando consulta
			$results = $sql->SQLQuery($query);
			
			$cids = explode(";", $results[0]['comments']);
						
			if($results[0]['ncomments'])
				$ncids = explode(";", $results[0]['ncomments']);
			else
				$ncids = array();
			
			if(is_numeric($id)) {
				$ids[0] = $id;
				
				$limit = 1;
				$where = "id=".$id;						
			}//end if
			else if(is_string($id)) {
				$ids = explode(":", $id);
				
				$limit = count($ids);
				$where = "(id=".$ids[0];
				for($i=1; $i < $limit; $i++) {
					$where .= " OR id=".$ids[$i];
				}//end for
				$where .= ")";
			}//end else if
			
			if($action == 'delete') {
				//Creando consulta
				$query = "DELETE FROM comments WHERE $where LIMIT $limit";
				
				$cids = array_diff($cids, $ids);
				$ncids = array_diff($ncids, $ids);
				
				$txtlog = "?action=delete&id=".$id;
			}//end if
			else if($action == 'accept') {
				//Creando consulta
				$query = "UPDATE comments SET publisher='$login', pdate='$datetime', new=0 WHERE $where LIMIT $limit";
				
				$ncids = array_diff($ncids, $ids);
				
				$txtlog = "?action=accept&id=".$id;
			}//end else if
			
			//Ejecutando consulta
			$sql->SQLQuery($query);
			
			sort($cids);
			sort($ncids);
			
			$strids = implode(";", $cids);
			$strnids = implode(";", $ncids);
			
			//Creando consulta
			$query = "UPDATE sld_practices SET comments='$strids', ncomments='$strnids' WHERE id=$rid LIMIT 1";
			
			//Ejecutando consulta
			$sql->SQLQuery($query);
			
			include('setonline.mod.php');
			//include('writelog.mod.php');
		}//end if
		
		$id = $rid;
		include('details.mod.php');
		
		//Cerrando conexi�n
		$sql->SQLClose();
	}//end if
?>