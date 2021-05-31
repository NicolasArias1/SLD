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
		if($body == 'users') {
			//B�squeda por usuarios
			$query = $sch->schUsers($uid);
		}//end if
		else if($body == 'profiles') {
			//B�squeda por perfiles
			$query = $sch->schProfiles();
		}//end else if
		else if($body == 'solicit') {
			//B�squeda por solicitudes
			$query = $sch->schSolicit();
		}//end else if
		else if($body == 'directories') {
			//B�squeda por directorios
			$query = $sch->schDirectories();
		}//end else if
		else if($body == 'groups') {
			//B�squeda por grupo de trabajo
			$query = $sch->schWorkgroup();
		}//end else if
		
		//Ejecutando consulta
		$nresults = $sql->SQLQuery($query[0]);
		
		//Introduciendo n�mero de resultados
		$sch->setNResults($nresults[0]['COUNT(*)']);
		
		if($page != 1 && isset($call)) {
			$prove = $show*($page-1);
			
			if(($nresults[0]['COUNT(*)']%$prove) == 0) {
				$preferences = array("order"=>$order,
														 "show"=>$show,
														 "default_show"=>20,
														 "page"=>$page-1);
				
				//Introduciendo preferencias
				$sch->setPreferences($preferences);
				
				if($body == 'users') {
					//B�squeda por usuarios
					$query = $sch->schUsers($uid);
				}//end if
				else if($body == 'profiles') {
					//B�squeda por perfiles
					$query = $sch->schProfiles();
				}//end else if
				else if($body == 'solicit') {
					//B�squeda por solicitudes
					$query = $sch->schSolicit();
				}//end else if
				else if($body == 'directories') {
					//B�squeda por directorios
					$query = $sch->schDirectories();
				}//end else if
				else if($body == 'groups') {
					//B�squeda por grupo de trabajo
					$query = $sch->schWorkgroup();
				}//end else if
				
				//Ejecutando consulta
				$nresults = $sql->SQLQuery($query[0]);
				
				//Introduciendo n�mero de resultados
				$sch->setNResults($nresults[0]['COUNT(*)']);
			}//end if
		}//end if
		
		//Introduciendo resultados
		$sch->setResults($sql->SQLQuery($query[1]));
		
		if($body == 'groups') {
			//Resultados procesados y listos para mostrarlos
			$resHTML = $sch->showGroups();
			
			if(!$call) {
				//Creando consulta
				$query = "SELECT * FROM sld_users ORDER BY id";
				
				//Ejecutando consulta y creando objeto Record
				$results = new RecordSet($sql->SQLQuery($query));
				
				$nusers = $results->Rows(); 
				
				for($i=0; $i < $nusers; $i++) {		
					$users[$results->Celd($i,'id')] = $results->Celd($i,'name');		
				}//end for
				
				for($i=0, $k=0; $i < ceil(count($users)/2); $i++) {
					$ulsHTML .= "<tr>";					
					
					$element = each($users);
					
					$k++;
					$ulsHTML .= "<td width=\"50%\" class=\"users\"><input name=\"".$k."\" id=\"c_".$k."\" type=\"checkbox\" value=\"".$element['key']."\" class=\"input_checkbox\" /> ".$element['value']."</td>";
					
					$element = each($users);
					
					$ulsHTML .= "<td height=\"20\" class=\"users\">";
					
					if($element['key']) {
						$k++;
			  		$ulsHTML .= "<input name=\"".$k."\" id=\"c_".$k."\" type=\"checkbox\" value=\"".$element['key']."\" class=\"input_checkbox\" /> ".$element['value'];
			  	}//end if
			  	else
			  		$ulsHTML .= "&nbsp;";
			  	
			  	$ulsHTML .= "</td>";
			  	$ulsHTML .= "</tr>";
				}//end for
			}//end if
		}//end if
		else {
			//Resultados procesados y listos para mostrarlos
			$resHTML = $sch->showUsers();
		}//end else
		
		if(isset($call))
			echo $resHTML;
	}//end if
	else if($body == 'new') {
		ob_start();
		include('../../utilities/userdata.mod.php');
		include('../../prints/user_form.php');
		$resHTML = ob_get_contents();
		ob_end_clean();
	}//end else if
	else if($body == 'edit') {
		ob_start();
		include('../../utilities/userdata.mod.php');
		include('../../prints/user_form.php');
		$resHTML = ob_get_contents();
		ob_end_clean();
	}//end else if
	
	if(!isset($call)) {
		include('setonline.mod.php');
		//include('writelog.mod.php');
		
		//Cerrando conexi�n
		$sql->SQLClose();
	}//end if
?>