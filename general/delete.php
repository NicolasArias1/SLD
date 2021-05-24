<?php
	include('../config/config.php');
	
	include('../inc/db.class.php');
	include('../inc/useful.fns.php');
	
	//Creando objeto SQL
  $sql = new SQL();
	
	//Conectando con el servidor
	$sql->SQLConnection();
	
	$path = dirname(__FILE__)."/results/";
	
	echo "<h2>Ruta de los resultados: ".$path."</h2>";
	
	//Creando consulta
	$query = "SELECT COUNT(*) FROM sld_practices";
	
	//Ejecutando consulta y creando objeto Record
	$results = $sql->SQLQuery($query);
	
	echo "<h3>Cantidad de practicas en bd: ".$results[0]['COUNT(*)']."</h3>";
	
	$dir = dir($path);
	
	echo "<h3>Practicas en la carpeta de resultados:</h3>";
	
	$i = 0;
	$j = 0;
	$k = 0;
	
	while($entry = $dir->read()) {
		if($entry != '.' && $entry != '..') {
			echo $entry."<br>";
			
			$dir2 = dir($path.$entry);
			
			while($entry2 = $dir2->read()) {
				if($entry2 != '.' && $entry2 != '..') {
					//echo "&nbsp;&nbsp;&nbsp;&nbsp;".$entry2."<br />";
					
					$i++;
					
					$strl = strlen($entry2);
					
					$pname = substr($entry2, 0, -12);
					
					$largo = $strl-12;
					
					$date = substr($entry2, $largo);
					
					echo "&nbsp;&nbsp;&nbsp;&nbsp;".$pname." - ".$date."<br />";
					
					//Creando consulta
					$query = "SELECT COUNT(*) FROM sld_practices WHERE ((uid=$entry) AND (pname='$pname') AND (date='$date'))";
					
					//Ejecutando consulta y creando objeto Record
					$results = $sql->SQLQuery($query);
					
					if($results[0]['COUNT(*)']) {
						//echo "&nbsp;&nbsp;TRUE<br />";
						
						$j++;
					}//end if
					else {
						//echo "&nbsp;&nbsp;FALSE&nbsp;&nbsp;".$path.$entry."\\".$entry2."<br />";
						
						$k++;
						
						remove_dir($path.$entry."/".$entry2);
					}//end else
				}//end if
			}//end while
			
			$dir2->close();
			
		}//end if
	}//end while
	
	$dir->close();
	
	//Cerrando conexi�n
	$sql->SQLClose();
	
	echo "<h3>Total de practicas en la carpeta: ".$i."</h3>";
	echo "<h3>Total de practicas dejadas: ".$j."</h3>";
	echo "<h3>Total de practicas borradas: ".$k."</h3>";
?>