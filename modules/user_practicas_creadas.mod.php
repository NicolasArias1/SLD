<?php

	session_start();
	
	$session = $_SESSION['user'];

	if(empty($session)) {
		header('Location: index.php');
	}//end if
	
	$user = unserialize($session);
	$uid = $user->getUID();
	$name = $user->getName();
	$login = $user->getLogin();
	$mail = $user->getEMail();
	$domain = $user->getDomain();
	$level = $user->getPriority();
	$_SESSION['user'] = serialize($user);

	//Creando objeto SQL
	$sql = new SQL();
	
	//Conectando con el servidor
	$sql->SQLConnection();
	
	//Creando consulta
	//$query = "SELECT pname, pcname FROM sld_practices_data WHERE type='Simulada'";
	
	$strHTML = "";
	// FOR HECHO POR MI
	$query1 = "SELECT DISTINCT id FROM sld_practices_data_2 ORDER BY id ASC";
	$result1 = $sql->SQLQuery($query1);
	$numcat= $sql->count;
	
	//$strHTML = "";
	
		//$strHTML .= "<li class=\"practice\"><a href=\"practices/".$result[$i]['pname'].".php\" class=\"ast1\">".tildes($result[$i]['pcname'])."</a></li>";
		$cat= "PRÁCTICAS CREADAS";//$result1[$i]['categoria'];
		$strHTML .= "<td><h1 class=\"content_r_hst2\">".$cat."</h1></td>";
		
		$query = "SELECT pname, pcname, tipoSistema, parametros, tipoEjecucion FROM sld_practices_data_2 WHERE visibilidad='visible' and enEdicion=0 and ulogin='$login' ORDER BY id ASC";
				
		$result = $sql->SQLQuery($query);
		$numpract= $sql->count;

		
		// ZIP
		$ordenPhp='<?php echo "valor=1"; ?>';
		$strHTML .='<form id="practice" name="practice" action="../PA/eliminarPractica.php" method="post" enctype="multipart/form-data">';
		$strHTML .='<table width="100%" border="0"> ';
		
		
		for($j=0; $j < $numpract; $j++) {
			$strHTML .='<tr>';
			//$rutaNueva = substr($result[$j]['pname'], 2, 0); // Corto el m_ al nombre de la práctica
			$strHTML .= "<td><a href= ../../creacionPracticas/".substr($result[$j]['pname'], 2)."/".substr($result[$j]['pname'], 2).".php class=\"ast1\">".tildes($result[$j]['pcname'])."                 </a></td>".'<td><a href= ../../creacionPracticas/'.substr($result[$j]['pname'], 2).'/'.substr($result[$j]['pname'], 2).'.zip class="ast3">Descargar archivo ZIP</a></td>'.'<td><a href="../PA/eliminarPractica.php?valor='.$result[$j]['pname'].'">Borrar práctica</a></td>'."<td><input type='checkbox' name='campos[".$result[$j]['pname']."]'></td>";
			
			}
			$strHTML .='</tr>';
		$cat= "PRÁCTICAS EN EDICION";//$result1[$i]['categoria'];
		$strHTML .= "<td><h1 class=\"content_r_hst2\">".$cat."</h1></td>";

		$query = "SELECT pname, pcname, tipoSistema, parametros, tipoEjecucion FROM sld_practices_data_2 WHERE visibilidad='visible' and enEdicion=1 and ulogin='$login' ORDER BY id ASC";
				
		$result = $sql->SQLQuery($query);
		$numpract= $sql->count;

		
		// ZIP

		for($j=0; $j < $numpract; $j++) {
			
			$strHTML .='<tr>';
			$strHTML .= "<td>".$result[$j]['pcname']."                 </a></td>".'<td><a href="../PA/IndexCreacion.php?nombreEdit='.$result[$j]['pname'].'&tipoSistema='.$result[$j]['tipoSistema'].'&parametros='.$result[$j]['parametros'].'&tipoEjecucion='.$result[$j]['tipoEjecucion'].'" class="ast3">Editar esta práctica</a></td>'.'<td><a href="../PA/eliminarPractica.php?valor='.$result[$j]['pname'].'">Borrar práctica</a></td>'."<td><input type='checkbox' name='campos[".$result[$j]['pname']."]'></td>";
			$strHTML .='</tr>';
			}
		
		$strHTML .='<td></td><td></td><td></td><td><input type="submit" value="Borrado múltiple"" ></td>';
		$strHTML .='</table>';
		
		$strHTML .='</form>';
	
	include('setonline.mod.php');
?>