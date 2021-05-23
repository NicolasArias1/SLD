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
			$id = $_POST['id'];
			$title = htmlentities(trim((string)$_POST['title']));
			$author = htmlentities(trim((string)$_POST['author']));
			$topic = htmlentities(trim((string)$_POST['topic']));
			$abstract = htmlentities(trim((string)$_POST['abstract']));
			$editor = htmlentities(trim((string)$_POST['editor']));
			$collaborators = htmlentities(trim((string)$_POST['collaborators']));
			$date = (string)$_POST['date'];
			$format = (string)$_POST['format'];
			$url = (string)$_POST['url'];
			$language = (string)$_POST['language'];
			$relation = htmlentities(trim((string)$_POST['relation']));
			$coverage = htmlentities(trim((string)$_POST['coverage']));
			$rights = htmlentities(trim((string)$_POST['rights']));
			$category = htmlentities((string)$_POST['category']);
			$subcategory = htmlentities((string)$_POST['subcategory']);
			$status = (string)$_POST['status'];
			
			if($status == 'sugerencia' && !SUG_CONT) {
				header('Location: ../modules/user/index.php');
				exit;
			}//end if
			
			if($title && $topic && $abstract && $url && $url != 'http://' && $category && $subcategory) {
				//Creando consulta
				$query = "SELECT id FROM resources WHERE (title='$title' AND topic='$topic' AND abstract='$abstract' AND url='$url' AND category='$category' AND subcategory='$subcategory')";
				
				//Ejecutando consulta
				$exist = $sql->SQLQuery($query);
				$nexist = $sql->count;
				
				if($action == 'new' && !$nexist && !$exist[0]['id']) {
					if($status == 'recurso') {
						//Creando consulta
						$query = "INSERT INTO resources (title, author, topic, abstract, editor, collaborators, date, format, url, language, relation, coverage, rights, category, subcategory, status, sender, sdate, publisher, pdate) 
										  VALUES ('$title', '$author', '$topic', '$abstract', '$editor', '$collaborators', '$date', '$format', '$url', '$language', '$relation', '$coverage', '$rights', '$category', '$subcategory', 'recurso', '$login', NOW(), '$login', NOW())";
					}//end if
					else if($status == 'sugerencia') {
						//Creando consulta
						$query = "INSERT INTO resources (title, author, topic, abstract, editor, collaborators, date, format, url, language, relation, coverage, rights, category, subcategory, status, sender, sdate) 
											VALUES ('$title', '$author', '$topic', '$abstract', '$editor', '$collaborators', '$date', '$format', '$url', '$language', '$relation', '$coverage', '$rights', '$category', '$subcategory', 'sugerencia', '$login', NOW())";
					}//end else
					
					//Ejecutando consulta
					$sql->SQLQuery($query);
					
					$txtlog = "?nid=".$sql->SQLInsertID();					
				}//end if
				else if($action == 'new') {
					header('Location: '.$rpage.'&alert=2');
					exit;
				}//end else if
				
				if(($action == 'edit' && $id && !$nexist) || ($action == 'edit' && $id && $nexist && $id == $exist[0]['id'])) {
					if($status == 'recurso') {
						//Creando consulta
						$query = "UPDATE resources SET title='$title', author='$author', topic='$topic', abstract='$abstract', editor='$editor', collaborators='$collaborators', date='$date', format='$format', 
											url='$url', language='$language', relation='$relation', coverage='$coverage', rights='$rights', category='$category', subcategory='$subcategory', status='recurso', publisher='$login', pdate=NOW() WHERE id=$id LIMIT 1";
					}//end if
					else if($status == 'sugerencia') {
						//Creando consulta
						$query = "UPDATE resources SET title='$title', author='$author', topic='$topic', abstract='$abstract', editor='$editor', collaborators='$collaborators', date='$date', format='$format', 
											url='$url', language='$language', relation='$relation', coverage='$coverage', rights='$rights', category='$category', subcategory='$subcategory', status='sugerencia' WHERE id=$id LIMIT 1";
					}//end else if
					
					$txtlog = "?eid=".$id;
					
					//Ejecutando consulta
					$sql->SQLQuery($query);
				}//end if
				else if($action == 'edit' && $id) {
					header('Location: '.$rpage.'&alert=2');
					exit;
				}//end else	if
				
				if($status == 'recurso') {
					//Creando consulta
					$query = "SELECT DISTINCT(url) AS url FROM resources WHERE status='recurso'";
					
					//Ejecutando consulta
					$urls = $sql->SQLQuery($query);
					
					for($i=0; $i<count($urls); $i++) {
						$data .= $urls[$i]['url'];
						if($i < (count($urls)-1))
							$data .= "\n";
					}//end for
						
					$fp = fopen('../urls.txt','w');
					fwrite($fp, $data);
				   	fclose($fp);
				}//end if
				
				include('setonline.mod.php');
				include('writelog.mod.php');
				
				//Cerrando conexi�n
				$sql->SQLClose();
				
				header('Location: '.$rpage.'&alert=1');
				exit;
			}//end if
			else {
				header('Location: '.$rpage.'&alert=3');
				exit;
			}//end else
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
		$level = $_GET['level'];
		$call = "indirect";
		
		//Creando objeto SQL
		$sql = new SQL();
		
		//Conectando con el servidor
		$sql->SQLConnection();
		
		if(is_numeric($id)) {
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
			$query = "SELECT uid, pname, date FROM sld_practices WHERE $where LIMIT $limit";
			
			//Ejecutando consulta
			$results = $sql->SQLQuery($query);
			
			//Creando consulta
			$query = "DELETE FROM sld_practices WHERE $where LIMIT $limit";
			
			//Ejecutando consulta
			$sql->SQLQuery($query);
			
			for($i=0; $i < $limit; $i++) {
				$rfolder = dirname(dirname(__FILE__))."/results/".$results[$i]['uid']."/".$results[$i]['pname'].$results[$i]['date'];
				//echo $limit;
				remove_dir($rfolder);
			}//end for
			
			$txtlog = "?did=".$id;
		}//end else if
		
		include('setonline.mod.php');
		//include('writelog.mod.php');
		
		if($body == 'revisadas' || $body == 'revisar' || $body == 'realizadas')
			include('practices.mod.php');
		else if($body == 'mprevisadas' || $body == 'mprevisar' || $body == 'mypractices')
			include('mypractices.mod.php');
		
		//Cerrando conexi�n
		$sql->SQLClose();
	}//end if	
?>