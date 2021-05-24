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
	
	if($level > 1) {
		if($level == 2)
			header('Location: ../operator/index.php');
		else
			header('Location: ../modules/user/index.php');
	}//end if	
	
	$method = $_SERVER['REQUEST_METHOD'];
	
	if($method == "POST") {
		$action = $_POST['action'];

		
		//Creando objeto Configuration
  	//$config = new ManageConfiguration();
		
		if($action) {
//			if($action == 'mysql') {
//				$mysql['server'] = $_POST['server'];
//				$mysql['user'] = $_POST['user_name'];
//				$mysql['passwd'] = $_POST['user_password'];
//				$mysql['db'] = $_POST['db_name'];
//				
//				if($mysql['server'] && $mysql['user'] && $mysql['db']) {
//					//Cargando par�metros MySQL
//		  		$config->getMySQLParameters();
//					
//					//Creando objeto SQL
//					$sql = new SQL();
//					
//					if($uid) {
//						//Conectando con el servidor
//						$sql->SQLConnection();
//						
//						//Cargando las tablas existentes
//						$vtables = $sql->SQLTables();
//						
//						//Cerrando conexi�n
//						$sql->SQLClose();
//					}//end if
//					else
//						$vtables = $config->getMySQLTables();
//					
//					//Introduciendo par�metros
//				  $sql->SQLParameters($mysql['server'], $mysql['db'], $mysql['user'], $mysql['passwd']);
//				  
//					//Conectando con el servidor
//					$sql->SQLConnection();
//					
//					if(!$sql->errno && $sql->connect && $sql->db) {
//						//Cargando las tablas existentes
//						$ntables = $sql->SQLTables();
//						
//						$valid = true;
//						for($i=0; $i < $sql->count; $i++) {
//				    	if(!in_array($vtables[$i], $ntables)) {
//				    		$i = $sql->count;
//				    		$valid = false;
//				    	}//end if
//						}//end for
//						
//						if($valid || $uid == 0) {
//							//Introduciendo par�metros MySQL
//						  $config->setMySQLParameters($mysql);
//						  
//						  //Salvando archivo
//						  $config->saveFile();
//						  
//						  $alert = "&alert=1";
//						}//end if
//						else
//							$alert = "&alert=2";
//					}//end if
//					else {
//						$alert = "&alert=3";
//					}//end else
//					
//					//Cerrando conexi�n
//					$sql->SQLClose();
//				}//end if
//				else
//					$alert = "&alert=4";
//				
//				$body = "servers";
//			}//end if
//			
//			if($action == 'ldap') {
//				$myldap['server'] = $_POST['server'];
//				$myldap['port'] = $_POST['port'];
//				$myldap['dn'] = $_POST['dn'];
//				
//				
//				if($myldap['server'] && $myldap['port'] && $myldap['dn']) {
//					//Creando objeto LDAP
//					$ldap = new LDAP();
//					
//					//Introduciendo par�metros
//					$ldap->LDAPParameters($myldap['server'], $myldap['port'], $myldap['dn']);
//					
//					//Conectando LDAP
//					$ldap->LDAPConnection();
//					
//					if(!$ldap->errno && $ldap->ds) {
//						//Introduciendo par�metros LDAP
//					  $config->setLdapParam($myldap);
//					  
//					  //Salvando archivo
//					  $config->saveFile();
//					  $alert = "&alert=5";
//					}//end if
//					else {
//						$alert = "&alert=6";
//					}//end else
//				}//end if
//				else
//					$alert = "&alert=7";
//				
//				$body = "servers";
//			}//end if
//			
//			if($action == 'domains') {
//				$domain = array();
//				
//				//Cargando dominios
//				$domains = $config->getDomains();
//				
//				if($_POST['new_domain'] || count($_POST['delete_domain'])) {
//					if($_POST['new_domain']) {
//						$domain[0] =  strtolower((string)$_POST['new_domain']);
//						
//						if($domain[0] && !in_array($domain[0], $domains)) {
//							$domains = array_merge($domain[0], $domains);
//							
//							sort($domains);
//							
//							//Introduciendo dominios
//							$config->setDomains($domains);
//							
//							//Salvando archivo
//						  $config->saveFile();
//						  
//						  $alert = "&alert=1";
//						}//end if
//					}//end if
//					
//					if(count($_POST['delete_domain'])) {
//						$delete_domain = $_POST['delete_domain'];
//						
//						$diff_domains = array_diff($domains, $delete_domain);
//						
//						for($i=0, $j=0; $i < count($domains); $i++) {
//							if($diff_domains[$i]) {
//								$domain[$j] = $diff_domains[$i];
//								$j++;
//							}//end if
//						}//end for
//						
//						$domains = $domain;
//						
//						sort($domains);
//						
//						//Introduciendo dominios
//						$config->setDomains($domains);
//						
//						//Salvando archivo
//					  $config->saveFile();
//					  
//					  $alert = "&alert=1";
//					}//end if
//				}//end if
//				else
//					$alert = "&alert=8";
//				
//				$body = "authenticate";
//			}//end if
//			
//			//Cargando par�metros MySQL
//	  	$config->getMySQLParameters();
//			
			//Creando objeto SQL
			$sql = new SQL();
		  
		  //Conectando con el servidor
			$sql->SQLConnection();
//			
//			if($action == 'formats') {
//				if($_POST['new_format'] || count($_POST['delete_format'])) {
//					if($_POST['new_format']) {
//						$format =  strtolower((string)$_POST['new_format']);
//						
//						//Creando consulta
//						$query = "SELECT COUNT(*) FROM formats WHERE format='$format'";
//						
//						//Ejecutando consulta
//						$results = $sql->SQLQuery($query);
//						$nexist = $results[0]['COUNT(*)'];
//						
//						if(!$nexist) {
//							//Creando consulta
//							$query = "INSERT INTO formats (format) VALUES ('$format')";
//							
//							//Ejecutando consulta
//							$sql->SQLQuery($query);
//							
//							$alert = "&alert=1";
//						}//end if
//					}//end if
//					
//					if(count($_POST['delete_format'])) {
//						$delete_format = $_POST['delete_format'];
//						
//						for($i=0; $i < count($delete_format); $i++) {
//							//Creando consulta
//							$query = "DELETE FROM formats WHERE format='".$delete_format[$i]."'";						
//							
//							//Ejecutando consulta
//							$sql->SQLQuery($query);
//						}//end for
//						
//					  $alert = "&alert=1";
//					}//end if
//				}//end if
//				else
//					$alert = "&alert=12";
//				
//				$body = "contents";
//			}//end if
//			
//			if($action == 'languages') {
//				if($_POST['new_language'] || count($_POST['delete_language'])) {
//					if($_POST['new_language']) {
//						$string =  (string)$_POST['new_language'];
//						
//						$language = explode(" ", $string);
//						
//						if(count($language) == 2 && $language[1] != "") {
//							$language[0] = ucfirst($language[0]);
//							$language[1] = substr($language[1],1,2);
//							
//							//Creando consulta
//							$query = "SELECT COUNT(*) FROM languages WHERE (lid='".$language[1]."' AND language='".$language[0]."')";
//							
//							//Ejecutando consulta
//							$results = $sql->SQLQuery($query);
//							$nexist = $results[0]['COUNT(*)'];
//							
//							if(!$nexist) {
//								//Creando consulta
//								$query = "INSERT INTO languages (lid, language) VALUES ('".$language[1]."', '".$language[0]."')";
//								
//								//Ejecutando consulta
//								$sql->SQLQuery($query);
//								
//								$alert = "&alert=1";
//							}//end if
//						}//end if
//						else {
//							$alert = "&alert=13";
//						}//end else
//					}//end if
//					
//					if(count($_POST['delete_language'])) {
//						$delete_language = $_POST['delete_language'];
//						
//						for($i=0; $i < count($delete_language); $i++) {
//							//Creando consulta
//							$query = "DELETE FROM languages WHERE language='".$delete_language[$i]."'";						
//							
//							//Ejecutando consulta
//							$sql->SQLQuery($query);
//						}//end for
//						
//					  $alert = "&alert=1";
//					}//end if
//				}//end if
//				else
//					$alert = "&alert=14";
//				
//				$body = "contents";
//			}//end if
			
			if($action == 'groups') {
				
				$id = $_POST['id'];
				$name = (string)tildes(xmlspecialchars(trim($_POST['name'])));
				$description = (string)tildes(xmlspecialchars(trim($_POST['description'])));
				
				if($name) {
					//Creando consulta
					$query = "SELECT id FROM sld_users_groups WHERE name='$name'";
					
					//Ejecutando consulta
					$results = $sql->SQLQuery($query);
					
					if(!$results[0]['id'] || $id == $results[0]['id']) {
						//Creando consulta
						$query = "SELECT COUNT(*) FROM sld_users";
						
						//Ejecutando consulta
						$results = $sql->SQLQuery($query);
						
						for($i=1, $j=0; $i <= $results[0]['COUNT(*)']; $i++) {
							if($_POST["$i"]) {
								$cid[$j] = $_POST["$i"];
								$j++;
							}//end if
						}//end for
						
						$cids = implode(";", $cid);
						
						if(!$id) {
							//Creando consulta
							$query = "INSERT INTO sld_users_groups (name, cids, description) VALUES ('$name', '$cids', '$description')";
						}//end if
						else if($id) {
							//Creando consulta
							$query = "UPDATE sld_users_groups SET name='$name', cids='$cids', description='$description' WHERE id=$id LIMIT 1";
						}//end else
						
						//Ejecutando consulta
						$sql->SQLQuery($query);
						
						$alert = "&alert=1";
					}//end if
					else
						$alert = "&alert=9";
				}//end if
				else
					$alert = "&alert=10";
				
				$body = "groups";
			}//end if
			
			if($uid) {
				include('setonline.mod.php');
				//include('writelog.mod.php');
			}//end if
			
			//Cerrando conexi�n
			$sql->SQLClose();
		}//end if
		else
			$alert = "&alert=11";
		
		if($uid)
			header('Location: ../modules/admin/users.php?body='.$body.$alert);
		else if($uid == 0)
			header('Location: ../install/users.php?body='.$body.$alert);
	}//end if
	if($method == 'GET') {
		$id = $_GET['id'];
		$action = $_GET['action'];
		$type = $_GET['type'];
		$auth = array();
		
		if($uid) {	
		  //Creando objeto SQL
			$sql = new SQL();
			
			//Conectando con el servidor
			$sql->SQLConnection();
		}//end if
//		
//		if($action == 'enable') {
//			if($type == 'db') {
//				$auth['db'] = 1;
//				$auth['ldap'] = LDAP_AUTH;
//				$auth['register'] = REGISTER_AUTH;
//				$auth['solicit'] = SOLICIT_AUTH;
//			}//end if
//			if($type == 'ldap') {
//				$auth['db'] = DB_AUTH;
//				$auth['ldap'] = 1;
//				$auth['register'] = REGISTER_AUTH;
//				$auth['solicit'] = SOLICIT_AUTH;
//			}//end if
//			if($type == 'register') {
//				$nn = strtok($_GET['nn'], "");
//				$auth['db'] = DB_AUTH;
//				$auth['ldap'] = LDAP_AUTH;
//				$auth['register'] = $nn[0];
//				$auth['solicit'] = $nn[1];
//			}//end if
//			if($type == 'suggestions') {
//				$cont['suggestions'] = 1;
//				$cont['votes'] = VOT_CONT;
//				$cont['comments'] = COM_CONT;
//			}//end if
//			if($type == 'votes') {
//				$cont['suggestions'] = SUG_CONT;
//				$cont['votes'] = 1;
//				$cont['comments'] = COM_CONT;
//			}//end if
//			if($type == 'comments') {
//				$cont['suggestions'] = SUG_CONT;
//				$cont['votes'] = VOT_CONT;
//				$cont['comments'] = 1;
//			}//end if
//		}//end if
//		else if($action == 'unable') {
//			if($type == 'db') {
//				$auth['db'] = 0;
//				$auth['ldap'] = LDAP_AUTH;
//				$auth['register'] = REGISTER_AUTH;
//				$auth['solicit'] = SOLICIT_AUTH;
//			}//end if
//			if($type == 'ldap') {
//				$auth['db'] = DB_AUTH;
//				$auth['ldap'] = 0;
//				$auth['register'] = REGISTER_AUTH;
//				$auth['solicit'] = SOLICIT_AUTH;
//			}//end if
//			if($type == 'suggestions') {
//				$cont['suggestions'] = 0;
//				$cont['votes'] = VOT_CONT;
//				$cont['comments'] = COM_CONT;
//			}//end if
//			if($type == 'votes') {
//				$cont['suggestions'] = SUG_CONT;
//				$cont['votes'] = 0;
//				$cont['comments'] = COM_CONT;
//			}//end if
//			if($type == 'comments') {
//				$cont['suggestions'] = SUG_CONT;
//				$cont['votes'] = VOT_CONT;
//				$cont['comments'] = 0;
//			}//end if
//		}//end else if
//		
//		if(count($auth)) {
//			//Introduciendo par�metros de autentificaci�n
//			$config->setAuthenticate($auth);
//		}//end if
//		
//		if(count($cont)) {
//			//Introduciendo par�metros de autentificaci�n
//			$config->setContribution($cont);
//		}//end if
//		
//		if(count($auth) || count($cont)) {
//			//Salvando archivo
//			$config->saveFile();
//		}//end if
		
		if($action == 'select' && $uid) {
			//Creando consulta
			$query = "SELECT cids FROM sld_users_groups WHERE id=$id";
			
			//Ejecutando consulta
			$results = $sql->SQLQuery($query);
			
			$ids = explode(";", $results[0]['cids']);
			
			//Creando consulta
			$query = "SELECT * FROM sld_users ORDER BY id";
			
			//Ejecutando consulta y creando objeto Record
			$results = new RecordSet($sql->SQLQuery($query));
			
			$nusers = $results->Rows(); 
			
			for($i=0; $i < $nusers; $i++) {		
				$users[$results->Celd($i,'id')] = $results->Celd($i,'name');		
			}//end for
			
			for($i=0, $j=0, $k=0; $i < ceil(count($users)/2); $i++) {
				$ulsHTML .= "<tr>";
				
				$element = each($users);
				
				if($element['key'] == $ids[$j]) {
					$j++;
					$chkcu = "checked=\"checked\" ";
				}//end if
				
				$k++;
				$ulsHTML .= "<td width=\"50%\" class=\"users\"><input name=\"".$k."\" id=\"c_".$k."\" type=\"checkbox\" value=\"".$element['key']."\" class=\"input_checkbox\" ".$chkcu."/> ".$element['value']."</td>";
				$chkcu = "";
				
				$element = each($users);
				
				$ulsHTML .= "<td height=\"20\" class=\"users\">";
				
				if($element['key'] == $ids[$j]) {
					$j++;
					$chkcd = "checked=\"checked\" "; 
				}//end if
				
				if($element['key']) {
					$k++;
		  		$ulsHTML .= "<input name=\"".$k."\" id=\"c_".$k."\" type=\"checkbox\" value=\"".$element['key']."\" class=\"input_checkbox\" ".$chkcd."/> ".$element['value'];
		  	}//end if
		  	else
			  		$ulsHTML .= "&nbsp;";
			  	
		  	$ulsHTML .= "</td>";
		  	$ulsHTML .= "</tr>";
				
				$chkcd = "";	
			}//end for
			
			echo $ulsHTML;
		}//end if
		
		if($action == 'delete' && $uid) {
			if(is_numeric($id)) {
				$limit = 1;
				$where[0] = "id=".$id;
			}//end if
			else if(is_string($id)) {
				$ids = explode(":", $id);
				$limit = count($ids);
				$where[0] = "(id=".$ids[0];
				for($i=1; $i < $limit; $i++) {
					$where[0] .= " OR id=".$ids[$i];
				}//end for
				$where[0] .= ")";
			}//end else if
			
			//Creando consulta
			$query = "DELETE FROM sld_users_groups WHERE $where[0] LIMIT $limit";
			
			//Ejecutando consulta
			$sql->SQLQuery($query);
			
			$body = "groups";
			$order = $_GET['order'];
			$show = $_GET['show'];
			$page = $_GET['page'];
			$call = "indirect";
			
			include('users.mod.php');
		}//end if
		
		if($uid) {
			include('setonline.mod.php');
			//include('writelog.mod.php');
			
			//Cerrando conexi�n
			$sql->SQLClose();
		}//end if
	}//end if
?>