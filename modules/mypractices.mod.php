<?php
	if(!$call) {
		//Creando objeto SQL
		$sql = new SQL();
		
		//Conectando con el servidor
		$sql->SQLConnection();
		
		if($sql->errno)
			header('Location: ../logout.php');
	}//end if
	
	$preferences = array("order"=>$order,
											 "show"=>$show,
											 "default_show"=>20,
											 "page"=>$page);
	
	//Creando objeto aSearch
	$sch = new aSearch($preferences, $level);
	
	//Introduciendo estado
	$sch->setStatus($status);
	
	//Introduciendo body
	$sch->setBody($body);
	
	if($body == 'mprevisadas' || $body == 'mprevisar' || $body == 'mypractices') {
		if($body == 'mprevisadas')
			$condition = " WHERE (uid=$uid AND tlogin!='null' AND rdate!='null')";
		else if($body == 'mprevisar')
			$condition = " WHERE (uid=$uid AND tlogin='null' AND rdate='null' AND revisar='1')";
		else if($body == 'mypractices')
			$condition = " WHERE (uid=$uid)";
		
		//Introduciendo condición
		$sch->setCondition($condition);

   	//Búsqueda por practicas realizadas
		$query = $sch->schMyPractices();
		
		//Ejecutando consulta
		$nresults = $sql->SQLQuery($query[0]);
		
		//Introduciendo número de resultados
		$sch->setNResults($nresults[0]['COUNT(*)']);
		
		if($page != 1 && $call) {
			$prove = $show*($page-1);
			
			if(($nresults[0]['COUNT(*)']%$prove) == 0) {
				$preferences = array("order"=>$order,
														 "show"=>$show,
														 "default_show"=>20,
														 "page"=>$page-1);
				
				//Introduciendo preferencias
				$sch->setPreferences($preferences);

    		//Búsqueda por recursos publicados y sugeridos
				$query = $sch->schMyPractices();
				
				//Ejecutando consulta
				$nresults = $sql->SQLQuery($query[0]);
				
				//Introduciendo número de resultados
				$sch->setNResults($nresults[0]['COUNT(*)']);
			}//end if
		}//end if
		
		//Introduciendo resultados
		$sch->setResults($sql->SQLQuery($query[1]));
		
		//Resultados procesados y listos para mostrarlos
		$resHTML = $sch->showResults();
		
		if($call)
			echo $resHTML;
	}//end else if
	
	if(!$call) {
		include('setonline.mod.php');
		//include('writelog.mod.php');
		
		//Cerrando conexión
		$sql->SQLClose();
	}//end if
?>
