<?php
	if(!isset($call)) {
		//Creando objeto SQL
		$sql = new SQL();
		
		//Conectando con el servidor
		$sql->SQLConnection();
		
		if($sql->errno)
			header('Location: ../general/logout.php');
	}//end if
	
	$preferences = array("order"=>$order,
											 "show"=>$show,
											 "default_show"=>20,
											 "page"=>$page);
	
	//Creando objeto aSearch
	$sch = new aSearch($preferences, $level);
	
	//Introduciendo estado
	$sch->setStatus(isset($status));
	
	//Introduciendo body
	$sch->setBody($body);
	
	if($body != 'new' && $body != 'edit') {
		if($body == 'configp') {
			//Búsqueda por usuarios
			$query = $sch->schPconfig(isset($pid));
		}//end if
		else if($body == 'profiles') {
			//Búsqueda por perfiles
			$query = $sch->schProfiles();
		}//end else if
		else if($body == 'solicit') {
			//Búsqueda por solicitudes
			$query = $sch->schSolicit();
		}//end else if
		else if($body == 'directories') {
			//Búsqueda por directorios
			$query = $sch->schDirectories();
		}//end else if
		
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
				
				if($body == 'configp') {
					//Búsqueda por usuarios
					$query = $sch->schPconfig($pid);
				}//end if
				else if($body == 'profiles') {
					//Búsqueda por perfiles
					$query = $sch->schProfiles();
				}//end else if
				else if($body == 'solicit') {
					//Búsqueda por solicitudes
					$query = $sch->schSolicit();
				}//end else if
				else if($body == 'directories') {
					//Búsqueda por directorios
					$query = $sch->schDirectories();
				}//end else if
				
				//Ejecutando consulta
				$nresults = $sql->SQLQuery($query[0]);
				
				//Introduciendo número de resultados
				$sch->setNResults($nresults[0]['COUNT(*)']);
			}//end if
		}//end if
		
		//Introduciendo resultados
		$sch->setResults($sql->SQLQuery($query[1]));
		
		//Resultados procesados y listos para mostrarlos
		$resHTML = $sch->showConfigp();
		
		if(isset($call))
			echo $resHTML;
	}//end if
	else if($body == 'new') {
		ob_start();
		include('../../utilities/configpdata.mod.php');
		include('../../prints/configp_form.php');
		$resHTML = ob_get_contents();
		ob_end_clean();
	}//end else if
	else if($body == 'edit') {
		ob_start();
		include('../../utilities/configpdata.mod.php');
		include('../../prints/configp_form.php');
		$resHTML = ob_get_contents();
		ob_end_clean();
	}//end else if
	
	if(!isset($call)) {
		include('setonline.mod.php');
		//include('writelog.mod.php');
		
		//Cerrando conexión
		$sql->SQLClose();
	}//end if
?>
