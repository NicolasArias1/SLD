<?php
	// Permitir que el script se ejecute por tiempo indefinido
	set_time_limit(0);
	
	$address = '192.168.0.11';
	$port = 10000;   //10000
	$str = '';
	
	$matlab = new COM('MATLAB.application');
	
	if(($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
	  echo "socket_create() failed: reason: " . socket_strerror($sock) . "\n";
	}//end if
	
	if(($ret = socket_bind($sock, $address, $port)) < 0) {
	  echo "socket_bind() failed: reason: " . socket_strerror($ret) . "\n";
	}//end if
	
	if(($ret = socket_listen($sock, 5)) < 0) {
		echo "socket_listen() failed: reason: " . socket_strerror($ret) . "\n";
	}//end if
	
	echo "ok";
	
	do {
	  if(($msgsock = socket_accept($sock)) < 0) {
	    echo "socket_accept() failed: reason: " . socket_strerror($msgsock) . "\n";
	    break;
	  }//end if
	   
	  echo "\nConexion aceptada: ".date("h:i:s A")."\n";
	  
	  do {
	  	if(false === ($buf = socket_read($msgsock, 1, PHP_NORMAL_READ))) {
	  		echo $buf;
	      echo "socket_read() failed: reason: " . socket_strerror($ret) . "\n";
	      break 2;
	    }//end if
	       
	    if(!$buf = trim($buf)) {
	      continue;
	    }//end if
	       
	    if($buf == 'quit') {
	      break;
	    }//end if
	    
	    if($buf == 'shutdown') {
	      socket_close($msgsock);
	      break 2;
	    }//end if
	    
	    if(!strstr($buf, "~")) {
	      $str .= $buf;
	    }//end if
	    else {
	     	$str .= $buf;
	      
	      echo "Datos leidos: ".date("h:i:s A")."\n";
	      echo $str."\n";
	      
	      $str = substr($str, 0, -1);
	      
	      $str = str_replace("*", "0", $str);
	      
	      list($vars, $path, $regurl, $maturl, $pname) = explode("@", $str);
				
				$template = file_get_contents($path."\salida.html");
				
				echo "Ejecucion en Matlab: ".date("h:i:s A")."\n";
				$command = "clear all;";
				
				echo $path."\n";
				
				$matlab->Execute($command);
				
				$command = "cd ".$path;
				
				$matlab->Execute($command);
				
							
				if($vars != "null") {
					$strvarray = explode(";", substr($vars, 0, -1));
					
					for($i=0; $i < count($strvarray); $i++) {
						list($key, $value) = explode("=", $strvarray[$i]);
						
						$strrep = "$".$key."$";
						
						$template = str_ireplace($strrep, $value, $template);
					}//end for
					
					$matlab->Execute($vars);
				}//end if
				if($regurl!="null") {
					$dfpath = $path."\\regulador\ureg.mdl";
					
					$fcontent = file_get_contents($regurl);
					
					$int = file_put_contents($dfpath, $fcontent);
				}//end if
				
				//cambios incorporar fichero mat
				
				if($maturl!="null") {
					$dfpath = $path."\\ficheromat\umat.mat";
					
					$fcontent = file_get_contents($maturl);
					
					$int = file_put_contents($dfpath, $fcontent);
				}//end if
				
				
				$matlab->Execute($pname);
				
				// cambios
				$real = $pname[strlen($pname)-1];
				echo $real."\n";
				
				if ($real == 'r'){
				    $varerror = $matlab->GetCharArray("varerror","base");
					if($varerror == '0'){
				      sleep(2);
				      $command = "onexec = get_param(gcs,'SimulationStatus')";
					  $matlab->Execute($command);
					  $onexec = $matlab->GetCharArray("onexec","base");
					  while ($onexec != "stopped")
					   {
					    sleep(2);					  
					    $matlab->Execute($command);
					    $onexec = $matlab->GetCharArray("onexec","base");
					   }
			        }
				}
				//cambios
				echo "Fin de la ejecucion en Matlab: ".date("h:i:s A")."\n";
				
				// con esto leo una variable varerror que debe estar en las pr�cticas del matlab
				$varerror = $matlab->GetCharArray("varerror","base");
				//$varerror = '0';
				
				if($varerror == '0') { //si cero no hay problema
					//$out = "T@".$out;
					$out = "T@";
					
					file_put_contents($path."\out\salida.html", $template);
					
					$dir = dir($path."\out");
					
					while($entry = $dir->read()) {
						if($entry != '.' && $entry != '..') {
							$fpath = $path."\out\\".$entry;
							//echo $fpath."\n";
							$fp = file($fpath);
							
							$out .= $entry."@";
						}//end if
					}//end while
					
					$out = substr($out, 0, -1);
					
					$out = str_replace("0", "*", $out);
				}//end if
				else
					$out = "F@".$varerror;
					echo $out."\n";
				
				echo "Respuesta enviada: ".date("h:i:s A")."\n";
				
				socket_write($msgsock, $out, strlen($out));
	      
	      $str = '';
				break; 
	    }//end else 
	  }//end do
	  
	  while(true);
	  
	  socket_close($msgsock);
	}//end do 
	
	while(true);
	
	socket_close($sock);
	//while(true);
?>