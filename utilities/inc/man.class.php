<?php
	class ManageConfiguration {
		var $domDoc;
		var $root;
		var $filename = "";
	
	  function ManageConfiguration() {
	  	$this->filename = dirname(dirname(__FILE__))."\xml\cfg\system.cfg.xml";
	  	
	  	//Cargando archivo
	  	$showfile = implode("",file($this->filename));
	  	if($this->domDoc = domxml_open_mem($showfile)) {
	    	$this->root = $this->domDoc->document_element();
	  	}//end if
	  }//end function
	 	
	 	function getAccount() {
	    $element = $this->root->get_elements_by_tagname('account');
	    $child = $element[0]->get_elements_by_tagname('user');
	    $result['user'] = $child[0]->get_content();
	    $child = $element[0]->get_elements_by_tagname('passwd');
	    $result['passwd'] = $child[0]->get_content();
	    	    
	    //Definici�n de los parametros como constantes.
			define("ACC_USER", $result['user']);
			define("ACC_PASSWD", $result['passwd']);
			
	  	return $result;	
	 	}//end function
	 	
	 	function getAuthenticate() {
	    $element = $this->root->get_elements_by_tagname('authenticate');
	    $child = $element[0]->get_elements_by_tagname('db');
	    $result['db'] = $child[0]->get_content();
	    $child = $element[0]->get_elements_by_tagname('nt');
	    $result['nt'] = $child[0]->get_content();
	    $child = $element[0]->get_elements_by_tagname('solicit');
	    $result['solicit'] = $child[0]->get_content();
	    $child = $element[0]->get_elements_by_tagname('register');
	    $result['register'] = $child[0]->get_content();
	    
	    //Definici�n de los parametros como constantes.
			define("DB_AUTH", $result['db']);
			define("LDAP_AUTH", $result['nt']);
			define("SOLICIT_AUTH", $result['solicit']);
			define("REGISTER_AUTH", $result['register']);
			
	  	return $result;	
	 	}//end function
	 	
	 	function getContribution() {
	    $element = $this->root->get_elements_by_tagname('contribution');
	    $child = $element[0]->get_elements_by_tagname('suggestions');
	    $result['suggestions'] = $child[0]->get_content();
	    $child = $element[0]->get_elements_by_tagname('votes');
	    $result['votes'] = $child[0]->get_content();
	    $child = $element[0]->get_elements_by_tagname('comments');
	    $result['comments'] = $child[0]->get_content();
	    
	    //Definici�n de los parametros como constantes.
			define("SUG_CONT", $result['suggestions']);
			define("VOT_CONT", $result['votes']);
			define("COM_CONT", $result['comments']);
			
	  	return $result;	
	 	}//end function
	 	
	 	function getLDAPParameters() {
	    $element = $this->root->get_elements_by_tagname('ldap');
	    $child = $element[0]->get_elements_by_tagname('server');
	    $result['server'] = $child[0]->get_content();
	    $child = $element[0]->get_elements_by_tagname('port');
	    $result['port'] = $child[0]->get_content();
	    $child = $element[0]->get_elements_by_tagname('dn');
	    $result['dn'] = $child[0]->get_content();
	   
	    //Definici�n de los parametros como constantes.
			define("LDAP_SERVER", $result['server']);
			define("LDAP_PORT", $result['port']);
			define("LDAP_DN", $result['dn']);
					   	
	  	return $result;	
	 	}//end function
	
	 	function getMySQLParameters() {
	    $element = $this->root->get_elements_by_tagname('mysql');
	    $child = $element[0]->get_elements_by_tagname('server');
	    $result['server'] = $child[0]->get_content();
	    $child = $element[0]->get_elements_by_tagname('user');
	    $result['user'] = $child[0]->get_content();
	    $child = $element[0]->get_elements_by_tagname('passwd');
	    $result['passwd'] = $child[0]->get_content();
	    $child = $element[0]->get_elements_by_tagname('db');
	    $result['db'] = $child[0]->get_content(); 	
			
			//Definici�n de los parametros como constantes.
			define("DB_SERVER", $result['server']);
			define("DB_NAME", $result['db']);
			define("DB_USER", $result['user']);
			define("DB_PASSWD", $result['passwd']);
					 
	    return $result;	
	 	}//end function
	 
	 	function getPath() {
	    $element = $this->root->get_elements_by_tagname('path');
	    $child = $element[0]->get_elements_by_tagname('root');
	    $result['root'] = $child[0]->get_content();
	    		
	    return $result;	
		}//end function
	
		function getDomains() {
			$element = $this->root->get_elements_by_tagname('domain');
			$child = $element[0]->get_elements_by_tagname('name');
			
			for($i=0; $i < count($child); $i++) {
				$node = $child[$i];
				$result[$i] = $node->get_content();
			}//end for 
			
			return $result; 
		}//end function
		
		function getMySQLTables() {
			$element = $this->root->get_elements_by_tagname('mysql');
			$child = $element[0]->get_elements_by_tagname('table');
			for($i=0; $i<count($child); $i++) {
				$node = $child[$i];
				$result[$i] = $node->get_content();
			}//end for
			
			return $result; 
		}//end function
		
		function setLDAPParameters($ldap) {
			//LDAP param
	    $element = $this->root->get_elements_by_tagname('ldap');
	    
	    //LDAP server
	    $child = $element[0]->get_elements_by_tagname('server');
	    $child = $element[0]->remove_child($child[0]);
	    $dom = $element[0]->owner_document();
	    $child = $dom->create_element('server');
	    $child = $element[0]->append_child($child);
	    $child->set_content($ldap['server']);
	
	    //LDAP port
	    $child = $element[0]->get_elements_by_tagname('port');
	    $child = $element[0]->remove_child($child[0]);
	    $dom = $element[0]->owner_document();
	    $child = $dom->create_element('port');
	    $child = $element[0]->append_child($child);
	    $child->set_content($ldap['port']);    
	
	    //LDAP dn
	    $child = $element[0]->get_elements_by_tagname('dn');
	    $child = $element[0]->remove_child($child[0]);
	    $dom = $element[0]->owner_document();
	    $child = $dom->create_element('dn');
	    $child = $element[0]->append_child($child);
	    $child->set_content($ldap['dn']);
		}//end function
		
		function setMySQLParameters($mysql) {
	    //MySQL param
	    $element = $this->root->get_elements_by_tagname('mysql');
	    
	    //Mysql server
	    $child = $element[0]->get_elements_by_tagname('server');
	    $child = $element[0]->remove_child($child[0]);
	    $dom = $element[0]->owner_document();
	    $child = $dom->create_element('server');
	    $child = $element[0]->append_child($child);
	    $child->set_content($mysql['server']);
			
		//Mysql db
	    $child = $element[0]->get_elements_by_tagname('db');
	    $child = $element[0]->remove_child($child[0]);
	    $dom = $element[0]->owner_document();
	    $child = $dom->create_element('db');
	    $child = $element[0]->append_child($child);
	    $child->set_content($mysql['db']);
			
	    //Mysql user
	    $child = $element[0]->get_elements_by_tagname('user');
	    $child = $element[0]->remove_child($child[0]);
	    $dom = $element[0]->owner_document();
	    $child = $dom->create_element('user');
	    $child = $element[0]->append_child($child);
	    $child->set_content($mysql['user']);    
	
	    //Mysql passwd
	    $child = $element[0]->get_elements_by_tagname('passwd');
	    $child = $element[0]->remove_child($child[0]);
	    $dom = $element[0]->owner_document();
	    $child = $dom->create_element('passwd');
	    $child = $element[0]->append_child($child);
	    $child->set_content($mysql['passwd']);
		}//end function
		
		function setAuthenticate($auth) {
		//LDAP param
	    $element = $this->root->get_elements_by_tagname('authenticate');
	    
	    //DB
	    $child = $element[0]->get_elements_by_tagname('db');
	    $child = $element[0]->remove_child($child[0]);
	    $dom = $element[0]->owner_document();
	    $child = $dom->create_element('db');
	    $child = $element[0]->append_child($child);
	    $child->set_content($auth['db']);
	
	    //LDAP
	    $child = $element[0]->get_elements_by_tagname('nt');
	    $child = $element[0]->remove_child($child[0]);
	    $dom = $element[0]->owner_document();
	    $child = $dom->create_element('nt');
	    $child = $element[0]->append_child($child);
	    $child->set_content($auth['ldap']);
	    
	    //Register
	    $child = $element[0]->get_elements_by_tagname('register');
	    $child = $element[0]->remove_child($child[0]);
	    $dom = $element[0]->owner_document();
	    $child = $dom->create_element('register');
	    $child = $element[0]->append_child($child);
	    $child->set_content($auth['register']);
	    
	    $child = $element[0]->get_elements_by_tagname('solicit');
	    $child = $element[0]->remove_child($child[0]);
	    $dom = $element[0]->owner_document();
	    $child = $dom->create_element('solicit');
	    $child = $element[0]->append_child($child);
	    $child->set_content($auth['solicit']);
		}//end function
		
		function setDomains($domains) {
			//Domain name
	    $element = $this->root->get_elements_by_tagname('domain');
			$child = $element[0]->get_elements_by_tagname('name');
	    exit;
	    for($i=0; $i < count($child); $i++) {
	    	$rm = $element[0]->remove_child($child[$i]);	
	    }//end for
	    
	    $dom = $element[0]->owner_document();
	    
	    for($i=0; $i < count($domains); $i++) {  
				$child = $dom->create_element('name');
				$child = $element[0]->append_child($child);
				$child->set_content($domains[$i]);
	    }//end for
		}//end function
		
		function setAccount($data) {
			//LDAP param
	    $element = $this->root->get_elements_by_tagname('account');
	    
	    //User
	    $child = $element[0]->get_elements_by_tagname('user');
	    $child = $element[0]->remove_child($child[0]);
	    $dom = $element[0]->owner_document();
	    $child = $dom->create_element('user');
	    $child = $element[0]->append_child($child);
	    $child->set_content($data['user']);
	
	    //Passwd
	    $child = $element[0]->get_elements_by_tagname('passwd');
	    $child = $element[0]->remove_child($child[0]);
	    $dom = $element[0]->owner_document();
	    $child = $dom->create_element('passwd');
	    $child = $element[0]->append_child($child);
	    $child->set_content($data['passwd']);
		}//end function
		
		function setContribution($cont) {
			//LDAP param
	    $element = $this->root->get_elements_by_tagname('contribution');
	    
	    //Sugerencias
	    $child = $element[0]->get_elements_by_tagname('suggestions');
	    $child = $element[0]->remove_child($child[0]);
	    $dom = $element[0]->owner_document();
	    $child = $dom->create_element('suggestions');
	    $child = $element[0]->append_child($child);
	    $child->set_content($cont['suggestions']);
	
	    //Valoraciones
	    $child = $element[0]->get_elements_by_tagname('votes');
	    $child = $element[0]->remove_child($child[0]);
	    $dom = $element[0]->owner_document();
	    $child = $dom->create_element('votes');
	    $child = $element[0]->append_child($child);
	    $child->set_content($cont['votes']);
	    
	    //Comentarios
	    $child = $element[0]->get_elements_by_tagname('comments');
	    $child = $element[0]->remove_child($child[0]);
	    $dom = $element[0]->owner_document();
	    $child = $dom->create_element('comments');
	    $child = $element[0]->append_child($child);
	    $child->set_content($cont['comments']);
		}//end function
		
		function saveFile() {
	  	//Save file
		  if($this->domDoc->dump_file($this->filename, false, true))
			 	return true;
			else 
				return false;
	  }//end function
	}//end class
	
	class ManageLog {
		var $fileptr;
		var $path = "";
		var $filename = "";
		
		function ManageLog($filename) {
	  	//Cargando archivo
	  	//Para Windows se escribe chr(92) y para Linux chr(47)
	  	$this->filename = dirname(dirname(__FILE__))."\logs".chr(92).$filename;
	  	$this->path = dirname(dirname(__FILE__))."\logs".chr(92);
	  }//end function
	  
	  function exFile() {
	  	if(file_exists($this->filename))
	  		return TRUE;
	  	else
	  		return FALSE;
	  }//end function
	  
	  function createFile($data) {
	  	$this->fileptr = fopen($this->filename, "w");
	  	
	  	for($i=0; $i < count($data); $i++) {
	  		$element = each($data);
	  		
	  		$txt .= $element['key'].": ".$element['value']."\n";
	  	}//end for
	  	
	  	$txt .= "\n";
	  	
	  	fwrite($this->fileptr, $txt);
	  }//end function
	  
	  function openFile($mode) {  	
	  	$this->fileptr = fopen($this->filename, $mode);
	  }//end function
	  
	  function writeFile($string) {
	  	$day = date("d");
	  	$month = date("m");	  
		  $year = date("Y");
		  $hour = date("h:i A");
		  
		  $txtroot = "http://cronos.cdict.uclv.edu.cu$_SERVER[PHP_SELF]".$string."\n";
		  $txt = "[".$day."-".$month."-".$year." / ".$hour." / ".$_SERVER['REMOTE_ADDR']."] ".$txtroot;
	  	
	  	$file = file($this->filename);
	  	$i = count($file)-1;
	  	$line = split("(\[)|( / )|(\] )", $file[$i]);
	  	
	  	if($line[4] != $txtroot)
	  		fwrite($this->fileptr, $txt);
	  }//end function
	  
	  function renameFile($newname) {
	  	$newname = $this->path.$newname;
	  	if(rename($this->filename, $newname))
	  		$this->filename = $newname;
	  }//end function
	  
	  function closeFile() {
	  	fclose($this->fileptr);
	  }//end function
	}//end class
?>