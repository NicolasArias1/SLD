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
		$strHTML .= "<h1 class=\"content_r_hst2\">".$cat."</h1>";
		
		$query = "SELECT pname, pcname, tipoSistema, parametros, tipoEjecucion FROM sld_practices_data_2 WHERE visibilidad='visible' and enEdicion=0 and ulogin='$login'";
				
		$result = $sql->SQLQuery($query);
		$numpract= $sql->count;

		
		// ZIP
		$ordenPhp='<?php echo "valor=1"; ?>';
		for($j=0; $j < $numpract; $j++) {
			
		
			$strHTML .= "<li><a href= ../../creacionPracticas/".$result[$j]['pname']."/".$result[$j]['pname'].".php class=\"ast1\">".tildes($result[$j]['pcname'])."                 </a>".'<a href="../creacionPracticas/'.$result[$j]['pname'].'/'.$result[$j]['pname'].'.zip" class="ast3">Descargar archivo ZIP</a>'.'<a href="eliminarPractica.php?valor='.$result[$j]['pname'].'">Borrar práctica</a>';
			
			}
			
		$cat= "PRÁCTICAS EN EDICION";//$result1[$i]['categoria'];
		$strHTML .= "<h1 class=\"content_r_hst2\">".$cat."</h1>";
		
		$query = "SELECT pname, pcname, tipoSistema, parametros, tipoEjecucion FROM sld_practices_data_2 WHERE visibilidad='visible' and enEdicion=1 and ulogin='$login'";
				
		$result = $sql->SQLQuery($query);
		$numpract= $sql->count;

		
		// ZIP

		for($j=0; $j < $numpract; $j++) {
			
		
			$strHTML .= "<li>".$result[$j]['pcname']."                 </a>".'<a href="../PA/indexCreacion.php?nombreEdit='.$result[$j]['pname'].'&tipoSistema='.$result[$j]['tipoSistema'].'&parametros='.$result[$j]['parametros'].'&tipoEjecucion='.$result[$j]['tipoEjecucion'].'" class="ast3">Editar esta práctica</a></li>';
			
			}


	
	include('setonline.mod.php');
?>