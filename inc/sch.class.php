<?php
/************************************************************
Escrito por: Yidier Rodr�guez Perez de Alejo.
A�o: 2005
Descripci�n: Clases que se utilizan para construir las consultas
						de busqueda en la base de datos de Cronos, asi como el 
						procesamiento de los resultados obtenidos, 
						con su correspondiente paginaci�n.
************************************************************/

class Search {
	var $keywords = '';
	var $words;
	var $keysjoined = '';
	var $nwords = 0;
	var $ncharacters = 0;
	var $field = array("title"=>"T&iacute;tulo",
										 "topic"=>"Palabras Clave",
										 "abstract"=>"Resumen",); 
	var $cid;
	var $sid;
	var $order = array('id', ' ASC');
	var $show = 10;
	var $nshow = 5;
	var $dshow = 10;
	var $extrafield = '';
	var $page = 1;
	var $npages = 0;
	var $nresults;
	var $filter = '';
	var $limits = array(0,10);
	var $status = 'recurso';
	var $query = '';
	var $results;
	var $format = array("PDF"=>"[pdf]",
									  	"DOC"=>"[doc]",
									  	"XSL"=>"[xsl]",
									  	"TXT"=>"[txt]",
									  	"RAR"=>"[rar]",
									  	"EXE"=>"[exe]",
									  	"ZIP"=>"[zip]",
									  	"JPG"=>"[jpg]",
									  	"PNG"=>"[png]",
									  	"GIF"=>"[gif]");
	var $message = '';
	var $parameters = array(0,0);
	var $url;
	var $paginate = '';
	var $call = 'direct';
	var $idfocus = '#results_box';
	var $user = 0;
	
	function Search($preferences, $user) {
		$this->setPreferences($preferences);
		$this->user = $user;
	}//end function
	
	function setPreferences($preferences) {
		$this->order[0] = $preferences['order'];
		$this->show = $preferences['show'];
		$this->page = $preferences['page'];
		if($preferences['default_show'])
			$this->dshow = $preferences['default_show'];
		
		$this->limits[0] = ($this->page-1)*$this->show;			
		if($this->show) {
			$this->limits[1] = $this->show;
		}//end if
		
		switch($preferences['order']) {
			case "topic":
				$this->extrafield = ", topic";
				break;
			case "category":
				$this->extrafield = ", category";
				break;
			case "subcategory":
				$this->extrafield = ", subcategory";
				break;
			case "counter":
				$this->extrafield = ", counter";
				break;
			case "rank":
				$this->extrafield = ", rank";
				$this->order[1] = " DESC";
				break;
		}//end switch
	}//end function
	
	function setKeywords($keywords) {
		$this->keysjoined = str_replace(" ", "+", $keywords);
		$this->ncharacters = strlen($keywords);
		$keywords = htmlentities($keywords);
		$this->keywords = trim($keywords);			
		$this->words = split(" ", $keywords);				
			
		$this->nwords = count($this->words);
	}//end function
	
	function setNResults($nresults) {
		$this->nresults = $nresults;
		
		$this->parameters[0] = ($this->show)*($this->page)-(($this->show)-1);
		$this->parameters[1] = ($this->show)*($this->page);
		
		if($nresults == 0)
			$this->parameters[0] = 0;
		if($this->parameters[1] > $nresults) {
			$this->parameters[1] = $nresults;
			$this->limits[1] = $nresults - $this->limits[0];
		}//end if
			
		$this->npages = ceil($nresults/($this->show));
		$this->nshow = ceil($nresults/$this->dshow);
		
		if($this->nshow > 4 && $this->dshow == 20)
			$this->nshow = 4;
		else if($this->nshow > 5 && $this->dshow == 10)
			$this->nshow = 5;
	}//end function
	
	function setFilter($filter) {
		if($filter[0])
			$sfilter = " AND format='".$filter[0]."'";
		if($filter[1])
			$sfilter .= " AND language='".$filter[1]."'";
		
		$this->filter = $sfilter;
	}//end function
	
	function setCall($call) {
		$this->call = $call;
	}//end function
	
	function setResults($results) {
		$this->results = $results;
	}//end function
	
	function schByKeyword() {
		$this->message = "<strong>Se busc&oacute; con: </strong>".$this->keywords.".";
		$this->url = "keywords=".$this->keysjoined;
		
		if(($this->nwords == 1) && ($this->ncharacters > 1)) {
			$title = "title LIKE '%$this->keywords%' ";
			$topic = "topic LIKE '%$this->keywords%' ";
			$abstract = "abstract LIKE '%$this->keywords%' ";
		}//end if
		
		if(($this->ncharacters == 2) || ($this->ncharacters == 3)) {
			$title = "title = '$this->keywords' ";
			$topic = "topic = '$this->keywords' ";
			$abstract = "abstract = '$this->keywords' ";
		}//end if
		
		if($this->nwords > 1) {
			$title = "title LIKE '%$this->keywords%' ";
			$topic = "topic LIKE '%$this->keywords%' ";
			$abstract = "abstract LIKE '%$this->keywords%' ";
			for ($i=0; $i < $this->nwords; $i++) {
		  	$ncharacters = strlen($this->words[$i]);
		  	if($ncharacters > 1){  //m�s de un caracter
		  		if(($ncharacters == 2) || ($ncharacters == 3)) {  //para 2 o 3 caracteres
		  			$title .= "OR title = '".$this->words[$i]."' ";
		  			$topic .= "OR topic = '".$this->words[$i]."' ";
		  			$abstract .= "OR abstract = '".$this->words[$i]."' ";
		  		}//end if
		  		else {
		  			$title .= "OR title LIKE '%".$this->words[$i]."%' ";   
		  			$topic .= "OR topic LIKE '%".$this->words[$i]."%' ";   
		  			$abstract .= "OR abstract LIKE '%".$this->words[$i]."%' ";
		  		}//end else
			  }//end if
		  }//end for
		}//end if
		
		//query
		$this->query[0] = "SELECT COUNT(*) FROM resources WHERE ($title OR $topic OR $abstract) AND status='".$this->status."'".$this->filter." ".$this->condition;
		$this->query[1] = "SELECT id, title, topic, abstract, format, url".$this->extrafield." FROM resources WHERE ($title OR $topic OR $abstract) AND status='".$this->status."'".$this->filter." ".$this->condition."GROUP BY id, title ORDER BY ".$this->order[0].$this->order[1]." LIMIT ".$this->limits[0].",".$this->limits[1]."";
		
		return $this->query;
	}//end function
	
	function schByField($field) {
		$this->message = "<strong>Se busc&oacute; con: </strong>".$this->keywords.".<br /><strong>En el campo: </strong>".$this->field[$field].".";
		$this->url = "keywords=".$this->keysjoined."&field=".$field;
		
		if(($this->nwords == 1) && ($this->ncharacters > 1)) {
			$condition = "$field LIKE '%$this->keywords%' ";
		}//end if
		
		if(($this->ncharacters == 2) || ($this->ncharacters == 3)) {
			$condition = "$field = '$this->keywords' ";
		}//end if
		
		if($this->nwords > 1) {
			$condition = "$field LIKE '%$this->keywords%' ";
			for ($i=0; $i < $this->nwords; $i++) {
		  	$ncharacters = strlen($this->words[$i]);
		  	if($ncharacters > 1){  //m�s de un caracter
		  		if(($ncharacters == 2) || ($ncharacters == 3)) {  //para 2 o 3 caracteres
		  			$condition .= "OR $field = '".$this->words[$i]."' ";
		  		}//end if
		  		else {
		  			$condition .= "OR $field LIKE '%".$this->words[$i]."%' ";
		  		}//end else
			  }//end if
		  }//end for
		}//end if
		
		//query  
		$this->query[0] = "SELECT COUNT(*) FROM resources WHERE ($condition) AND status='".$this->status."'".$this->filter." ".$this->condition;
		$this->query[1] = "SELECT id, title, topic, abstract, format, url".$this->extrafield." FROM resources WHERE ($condition) AND status='".$this->status."'".$this->filter." ".$this->condition."GROUP BY id, title ORDER BY ".$this->order[0].$this->order[1]." LIMIT ".$this->limits[0].",".$this->limits[1]."";
		
		return $this->query;
	}//end function
	
	function schByCategory($cdata, $sdata) {
		$this->cid = $cdata[1];
		$this->sid = $sdata[1];
		$this->idfocus = '#category_selected_box';
		
		$this->message = "<strong>Se busc&oacute; por: </strong>Categor&iacute;a y Subcategor&iacute;a.<br /><strong>Categor&iacute;a: </strong>".$cdata[0].".<br /><strong>Subacategor&iacute;a: </strong>".$sdata[0].".";
		$this->url = "cid=".$cdata[1]."&sid=".$sdata[1];
		
		//query
		$this->query[0] = "SELECT COUNT(*) FROM resources WHERE category='".$cdata[0]."' AND subcategory='".$sdata[0]."' AND status='".$this->status."'";  
		$this->query[1] = "SELECT id, title, abstract, format, url".$this->extrafield." FROM resources WHERE category='".$cdata[0]."' AND subcategory='".$sdata[0]."' AND status='".$this->status."' GROUP BY id, title ORDER BY ".$this->order[0].$this->order[1]." LIMIT ".$this->limits[0].",".$this->limits[1]."";
		
		return $this->query;
	}//end function
	
	function schBySubcategory($sarray) {
		$this->sid = $sarray[1];
		
		$this->message = "<strong>Se busc&oacute; por: </strong>Subcategor&iacute;a.<br /><strong>Subacategor&iacute;a: </strong>".$sarray[0].".";
		$this->url = "sid=".$sarray[1];
		
		//query
		$this->query[0] = "SELECT COUNT(*) FROM resources WHERE subcategory='".$sarray[0]."' AND status='".$this->status."'";  
		$this->query[1] = "SELECT id, title, abstract, format, url".$this->extrafield." FROM resources WHERE subcategory='".$sarray[0]."' AND status='".$this->status."' GROUP BY id, title ORDER BY ".$this->order[0].$this->order[1]." LIMIT ".$this->limits[0].",".$this->limits[1]."";
		
		return $this->query;
	}//end function
	
	function schByDirectory($ids) {
		$this->url = "keywords=mydirectory";
		
		$this->query[0] = "SELECT COUNT(*) FROM resources WHERE (id=$ids[0]";
		$this->query[1] = "SELECT id, title, abstract, format, url".$this->extrafield." FROM resources WHERE (id=$ids[0]";
	
		for($i=1; $i < count($ids); $i++) {
			$this->query[0] .= " OR id=$ids[$i]";
			$this->query[1] .= " OR id=$ids[$i]";
		}//end for
		
		$this->query[0] .= ") AND status='".$this->status."'";
		$this->query[1] .= ") AND status='".$this->status."' GROUP BY id, title ORDER BY ".$this->order[0].$this->order[1]." LIMIT ".$this->limits[0].",".$this->limits[1]."";
		
		return $this->query;
	}//end function
			
	function pageIn() {
		if($this->npages > 1) {
			if($this->page!=1)
	  		$this->paginate = "<a href=\"$_SERVER[PHP_SELF]?".$this->url."&order=".$this->order[0]."&show=".$this->show."&page=".($this->page-1).$this->idfocus."\" class=\"ast5\">&laquo;</a>"; 
	  	else
	  		$this->paginate = "&laquo;";
			
			for($i=1; $i<=$this->npages; $i++) {
		  	if($this->page == $i)
		  		$this->paginate .= " <span class=\"txtbu\">".$i."</span> ";
		  	else 
		  		$this->paginate .= " <a href=\"$_SERVER[PHP_SELF]?".$this->url."&order=".$this->order[0]."&show=".$this->show."&page=".$i.$this->idfocus."\" class=\"ast5\">".$i."</a> ";
		  }//end for
		  
		  if($this->page!=$this->npages)
		  	$this->paginate .= "<a href=\"$_SERVER[PHP_SELF]?".$this->url."&order=".$this->order[0]."&show=".$this->show."&page=".($this->page+1).$this->idfocus."\" class=\"ast5\">&raquo;</a>";
		  else
		  	$this->paginate .= "&raquo;";
		}//end if		
	}//end function
	
	function showResults() {
		$this->message .= "<br /><strong>Resultados de la B&uacute;squeda:</strong> ".$this->parameters[0]." - ".$this->parameters[1]." de ".$this->nresults." elemento(s) encontrado(s).";
		
		$this->pageIn();
		
		ob_start();
		if($this->user)			
			include('../../prints/user_search_results.php'); //No va
		else
			include('../../prints/search_results.php'); //No va
		$searchHTML = ob_get_contents();
		ob_end_clean();
		
		return $searchHTML;
	}//end function
	
	function showDirectory() {
		$this->message = "<strong>Directorio Personal </strong>";
		$this->message .= "<br /><strong>Resultados:</strong> ".$this->parameters[0]." - ".$this->parameters[1]." de ".$this->nresults." elemento(s) encontrado(s).";
		
		$this->pageIn();
		
		ob_start();
		include('../../prints/user_mydirectory.php'); //No va
		$mydirHTML = ob_get_contents();
		ob_end_clean();
		
		return $mydirHTML;
	}//end function	
}//end class

class aSearch extends Search {
	var $items = 0;
	var $condition = '';
	var $body = '';
  var $select = array();
  var $uid = 0;
  
	function setCondition($condition) {
		$this->condition = $condition;
	}//end function
	
	function setStatus($status) {
		$this->status = $status;
	}//end function
	
	function setBody($body) {
		$this->body = $body;
	}//end function
	
	function schGeneral() {
		$this->url = "body=".$this->body;
		$this->message = "<strong>Resultados:</strong>";
		
		//query
		$this->query[0] = "SELECT COUNT(*) FROM sld_practices".$this->condition;
		$this->query[1] = "SELECT id, sid, uid, ulogin, pname, pcname, date, tlogin, rdate, revisar FROM sld_practices".$this->condition." GROUP BY id, pname ORDER BY ".$this->order[0].$this->order[1]." LIMIT ".$this->limits[0].",".$this->limits[1]."";
		
		return $this->query;
	}//end function
	
	function schMyPractices() {
		$this->url = "body=".$this->body;
		$this->message = "<strong>Resultados:</strong>";
		
		//query
		$this->query[0] = "SELECT COUNT(*) FROM sld_practices".$this->condition;
		$this->query[1] = "SELECT id, sid, uid, ulogin, pname, pcname, date, tlogin, rdate FROM sld_practices".$this->condition." GROUP BY id, pname ORDER BY ".$this->order[0].$this->order[1]." LIMIT ".$this->limits[0].",".$this->limits[1]."";
		
		return $this->query;
	}//end function
	
	function schUsers($uid) {
		$this->uid = $uid;
		$this->message = "<strong>Resultados:</strong>";
		$this->url = "body=".$this->body;
		
		//query
		$this->query[0] = "SELECT COUNT(*) FROM sld_users WHERE (level<3 AND type!=2)";
		$this->query[1] = "SELECT * FROM sld_users  WHERE (level<3 AND type!=2) GROUP BY id, login ORDER BY ".$this->order[0].$this->order[1]." LIMIT ".$this->limits[0].",".$this->limits[1]."";
		
		return $this->query;
	}//end function
	
	function schProfiles() {
		$this->message = "<strong>Resultados:</strong>";
		$this->url = "body=".$this->body;
		
		//query
		$this->query[0] = "SELECT COUNT(*) FROM sld_users WHERE (level=3 AND type!=2)";
		$this->query[1] = "SELECT * FROM sld_users WHERE (level=3 AND type!=2) GROUP BY id, login ORDER BY ".$this->order[0].$this->order[1]." LIMIT ".$this->limits[0].",".$this->limits[1]."";
		
		return $this->query;
	}//end function
	
	function schSolicit() {
		$this->message = "<strong>Resultados:</strong>";
		$this->url = "body=".$this->body;
		
		//query
		$this->query[0] = "SELECT COUNT(*) FROM sld_users WHERE (type='2')";
		$this->query[1] = "SELECT * FROM sld_users WHERE (type='2') GROUP BY id, login ORDER BY ".$this->order[0].$this->order[1]." LIMIT ".$this->limits[0].",".$this->limits[1]."";
		
		return $this->query;
	}//end function

function schPconfig($pid) {
		$this->pid = $pid;
		$this->message = "<strong>Resultados:</strong>";
		$this->url = "body=".$this->body;
		
		//query
		$this->query[0] = "SELECT COUNT(*) FROM sld_practices_data WHERE (sid='1')";
		$this->query[1] = "SELECT * FROM sld_practices_data WHERE (sid='1') GROUP BY id, pcname ORDER BY ".$this->order[0].$this->order[1]." LIMIT ".$this->limits[0].",".$this->limits[1]."";
		
		return $this->query;
	}//end function
	
	function schWorkgroup() {
		$this->url = "body=groups";
		$this->message = "<strong>Resultados:</strong>";
		
		//query
		$this->query[0] = "SELECT COUNT(*) FROM sld_users_groups";
		$this->query[1] = "SELECT * FROM sld_users_groups GROUP BY id, name ORDER BY ".$this->order[0].$this->order[1]." LIMIT ".$this->limits[0].",".$this->limits[1]."";
		
		return $this->query;
	}//end function
	
	function schContacts() {
		$this->url = "body=contacts";
		$this->message = "<strong>Resultados:</strong>";
		
		//query
		$this->query[0] = "SELECT COUNT(*) FROM contacts";
		$this->query[1] = "SELECT * FROM contacts GROUP BY id, name ORDER BY ".$this->order[0].$this->order[1]." LIMIT ".$this->limits[0].",".$this->limits[1]."";
		
		return $this->query;
	}//end function
	
	function schULogs() {
		$this->message = "<strong>Resultados:</strong>";
		$this->url = "body=".$this->body;
	}//end function
	
	function showResults() {
		$this->message .= " ".$this->parameters[0]." - ".$this->parameters[1]." de ".$this->nresults." elemento(s) encontrado(s).";
		$this->idfocus = "";
		$this->pageIn();
		
		ob_start();
		if($this->body == 'revisadas' || $this->body == 'revisar' || $this->body == 'realizadas')
			include('../../prints/administrator_practices.php'); 
		else if($this->body == 'mypractices' || $this->body == 'mprevisadas' || $this->body == 'mprevisar')
			include('../../prints/user_mypractices.php'); 
		
		$schHTML = ob_get_contents();
		ob_end_clean();
		
		return $schHTML;
	}//end function
	
	function showUsers() {
		$this->message .= " ".$this->parameters[0]." - ".$this->parameters[1]." de ".$this->nresults." elemento(s) encontrado(s).";			
		$this->idfocus = "";
		$this->pageIn();
		
		ob_start();
		
		if($this->body == 'directories') {
			if($this->nresults) {
				for($i=0; $i < count($this->results); $i++) {
					if($this->results[$i]['rids']) {
						$rids = explode(";", $this->results[$i]['rids']);
						$this->results[$i]['items'] = count($rids);
					}//end if
					else
						$this->results[$i]['items'] = 0;
				}//end for
			}//end if
			
			include('../../prints/administrator_directories.php'); //No va
		}//end if
		else
			include('../../prints/administrator_users.php');
		
		$usrHTML = ob_get_contents();
		ob_end_clean();
		
		return $usrHTML;
	}//end function

function showConfigp() {
		$this->message .= " ".$this->parameters[0]." - ".$this->parameters[1]." de ".$this->nresults." elemento(s) encontrado(s).";			
		$this->idfocus = "";
		$this->pageIn();
		
		ob_start();
		
		if($this->body == 'directories') {
			if($this->nresults) {
				for($i=0; $i < count($this->results); $i++) {
					if($this->results[$i]['rids']) {
						$rids = explode(";", $this->results[$i]['rids']);
						$this->results[$i]['items'] = count($rids);
					}//end if
					else
						$this->results[$i]['items'] = 0;
				}//end for
			}//end if
			
			include('../../prints/administrator_directories.php'); //No va
		}//end if
		else
			include('../../prints/config_practices.php'); 
		
		$usrHTML = ob_get_contents();
		ob_end_clean();
		
		return $usrHTML;
	}//end function
	
	function showContacts() {
		$this->message .= " ".$this->parameters[0]." - ".$this->parameters[1]." de ".$this->nresults." elemento(s) encontrado(s).";			
		$this->idfocus = "";
		$this->pageIn();
		
		ob_start();
		include('../../prints/administrator_contacts.php'); //No va
		$usrHTML = ob_get_contents();
		ob_end_clean();
		
		return $usrHTML;
	}//end function
	
	function showULogs() {
		$this->message .= " ".$this->parameters[0]." - ".$this->parameters[1]." de ".$this->nresults." elemento(s) encontrado(s).";			
		$this->idfocus = "";
		$this->pageIn();
		
		ob_start();
		include('../../prints/administrator_logs.php'); //No va
		$usrHTML = ob_get_contents();
		ob_end_clean();
		
		return $usrHTML;
	}//end function
	

	function showGroups() {
		$this->message .= " ".$this->parameters[0]." - ".$this->parameters[1]." de ".$this->nresults." elemento(s) encontrado(s).";			
		$this->pageIn();
		
		if($this->nresults) {
			for($i=0; $i < count($this->results); $i++) {
				if($this->results[$i]['id']) {
					$cids = explode(";", $this->results[$i]['cids']);
					$this->results[$i]['items'] = count($cids);
				}//end if
				else
					$this->results[$i]['items'] = 0;
			}//end for
		}//end if
		
		ob_start();
		include('../../prints/administrator_groups.php');
		$usrHTML = ob_get_contents();
		echo $usrHTML;
		ob_end_clean();
		
		return $usrHTML;
	}//end function
}//end class
?>
