<?php
header("Content-Type: application/mdl");
header('Content-Disposition: attachment; filename="CS_Cr_simulado_v75R2010a.mdl"');
//nombre_imagen.gif es el nombre de la imagen tras la descarga 
readfile('CS_Cr_simulado_v75R2010a.mdl');
//leemos la imagen.
//nombre_imagen.gif debe ser la ruta para llegar a la imagen.
?>