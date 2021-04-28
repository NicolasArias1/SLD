<?php
$file = $_GET['file']; 
$enlace = $_GET['path']."/".$file; 
//$enlace = "resources/".$file;

header ("Content-Disposition: attachment; filename=".$file."\n\n"); 
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($enlace));
readfile($enlace);
?>