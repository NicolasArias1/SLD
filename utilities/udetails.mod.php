<?php
	//Creando objeto SQL
	$sql = new SQL();
  
  //Conectando con el servidor
	$sql->SQLConnection();
	
	if($sql->errno)
		header('Location: ../general/logout.php');
	
	$ulevel = array(1=>"Administrador", 2=>"Operador", 3=>"Usuario");
	
	//Creando consulta
	$query = "SELECT * FROM users WHERE id=$id";
	
	//Ejecutando consulta y creando objeto Record
	$results = new RecordSet($sql->SQLQuery($query));
	
	$recurso['Nombre'] = $results->Celd(0,'name');
	$recurso['Login'] = $results->Celd(0,'login');
	$recurso['Dominios'] = $results->Celd(0,'domain');
	$recurso['E-Mail'] = $results->Celd(0,'mail');
	$recurso['Nivel'] = $ulevel[$results->Celd(0,'level')];
	$recurso['Estado'] = ucfirst($results->Celd(0,'status'));
	
	$ulogin = $recurso['Login'];
	
	$rvalued = $results->Celd(0,'rvalued');
	
	//Creando consulta
	$query = "SELECT COUNT(*) FROM resources WHERE (sender='$ulogin' AND status='sugerencia')";
	
	//Ejecutando consulta
	$results = $sql->SQLQuery($query);
	
	$adetails['Recursos Sugeridos'] = $results[0]['COUNT(*)'];
	
	//Creando consulta
	$query = "SELECT COUNT(*) FROM resources WHERE (sender='$ulogin' AND publisher!='$ulogin' AND status='recurso')";
	
	//Ejecutando consulta
	$results = $sql->SQLQuery($query);
	
	$adetails['Recursos Publicados'] = $results[0]['COUNT(*)'];
	
	if($level < 3) {
		//Creando consulta
		$query = "SELECT COUNT(*) FROM resources WHERE (sender='$ulogin' AND publisher='$ulogin')";
		
		//Ejecutando consulta
		$results = $sql->SQLQuery($query);
		
		$adetails['Recursos Introducidos'] = $results[0]['COUNT(*)'];
		
		//Creando consulta
		$query = "SELECT COUNT(*) FROM resources WHERE (sender!='$ulogin' AND publisher='$ulogin')";
		
		//Ejecutando consulta
		$results = $sql->SQLQuery($query);
		
		$adetails['Recursos Revisados'] = $results[0]['COUNT(*)'];
		
		$diff = array();
		
		//Creando consulta
		$query = "SELECT sdate, pdate FROM resources WHERE (sender!='$ulogin' AND publisher='$ulogin')";
		
		//Ejecutando consulta
		$dresults = $sql->SQLQuery($query);
		
		for($i=0; $i < $sql->count; $i++) {
			$sdate = explode("-", $dresults[$i]['sdate']);
			$pdate = explode("-", $dresults[$i]['pdate']);
			
			$smd = $sdate[1].$sdate[2];
			$pmd = $pdate[1].$pdate[2];
			
			if($sdate[0] == $pdate[0]) {
				if(leap($sdate[0]))
					$diff[$i] = getLDay($pmd) - getLDay($smd);
				else
					$diff[$i] = getDay($pmd) - getDay($smd);
			}//end if
			else {
				$nyears = $pdate[0] - $sdate[0];
				
				if($nyears == 1) {
					if(leap($sdate[0]))
						$diff[$i] = 366 + getLDay($pmd) - getLDay($smd);
					else
						$diff[$i] = 365 + getDay($pmd) - getDay($smd);
				}//end if
				else {
					$pyear = $pdate[0];
					
					while($sdate[0] != $pyear) {
						if(leap($pyear))
							$ndays += 366;
						else
							$ndays += 365;
							
						$pyear--;
					}//end while
					
					if(leap($sdate[0]))
						$diff[$i] = $ndays + getLDay($pmd) - getLDay($smd);
					else
						$diff[$i] = $ndays + getDay($pmd) - getDay($smd);
				}//end else
			}//end else
		}//end for
		
		if(count($diff))
			$adetails['Tiempo de Revisi�n'] = number_format(array_sum($diff)/count($diff), 2, ".", "");
		else
			$adetails['Tiempo de Revisi�n'] = 0;
	}//end if
	
	if($rvalued)
		$nvalued = count(explode(";", $rvalued));
	else
		$nvalued;
	
	$adetails['Recursos Valorados'] = $nvalued;
	
	//Creando consulta
	$query = "SELECT COUNT(*) FROM comments WHERE ulogin='$ulogin'";
	
	//Ejecutando consulta
	$results = $sql->SQLQuery($query);
	
	$adetails['Comentarios Realizados'] = $results[0]['COUNT(*)'];
	
	if($level < 3) {
		//Creando consulta
		$query = "SELECT COUNT(*) FROM comments WHERE (ulogin!='$ulogin' AND publisher='$ulogin')";
		
		//Ejecutando consulta
		$results = $sql->SQLQuery($query);
		
		$adetails['Comentarios Publicados'] = $results[0]['COUNT(*)'];
		
		//Creando consulta
		$query = "SELECT COUNT(*) FROM comments WHERE (ulogin='$ulogin' AND publisher='$ulogin')";
		
		//Ejecutando consulta
		$results = $sql->SQLQuery($query);
		
		$adetails['Comentarios Introducidos'] = $results[0]['COUNT(*)'];
	}//end if
	
	include('setonline.mod.php');
	//include('writelog.mod.php');
			
	//Cerrando conexi�n
	$sql->SQLClose();
	
	//Procesamiento de los detalles del recurso
	ob_start();
	while($element = each($recurso)) {
	  if($element['value']) { 
		  if($element['key'] != 'URL') {
		  	?>
			  <div class="detail_celd">
			  	<div class="detail_field"><?php echo $element['key']; ?>:</div><div class="detail_text"><?php echo $element['value']; ?></div>
			  </div>
	    	<?php
	    }//end if
	    else {
	    	?>
			  <div class="detail_celd">
			  	<div class="detail_field"><?php echo $element['key']; ?>:</div><div class="detail_text"><a href="<?php echo $element['value']; ?>" target="_blank" class="linkb" onclick="resVisitCount(<?php echo $id; ?>, <?php echo $level; ?>)"><?php echo $element['value']; ?></a></div>
			  </div>
	    	<?php
	    }//end else
	  }//end if
  }//end while
  $detHTML = ob_get_contents();
	ob_end_clean();
		
	//Procesamiento de los detalles adicionales del recurso
	ob_start();
	while($element = each($adetails)) {
		if($element['value']) { 
			?>
	    <div class="detail_celd">
		  	<div class="adetail_field"><?php echo $element['key']; ?>:</div><div class="adetail_text"><?php echo $element['value']; ?></div>
		  </div>
		  <?php
		}//end if
  }//end while
  $adetHTML = ob_get_contents();
	ob_end_clean();
?>