<?php
	//Reportar como online en el sistema
	
	//Creando consulta
	$query = "UPDATE sld_users SET status='online', date=NOW(), time=NOW() WHERE id=$uid";
	
	//Ejecutando consulta
	$sql->SQLQuery($query);
?>