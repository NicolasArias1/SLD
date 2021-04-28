<?php
	//Reportar como outline a los usuarios que llevan 30 minutos sin moverse en el sistema
	
	//Creando consulta
	$query = "UPDATE sld_users SET status='outline' WHERE (date!=NOW() AND (time > DATE_SUB(NOW(), INTERVAL 1800 SECOND) OR (time < DATE_SUB(NOW(), INTERVAL 1800 SECOND) AND type != 2)))";
	
	//Ejecutando consulta
	$sql->SQLQuery($query);
?>