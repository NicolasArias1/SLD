<?php
header("Content-Type: application/mdl"); 
header('Content-Disposition: attachment; filename="CT_T1_nivel.mdl"');
//nombre_imagen.gif es el nombre de la imagen tras la descarga 
readfile('CT_T1_nivel.mdl'); 
//leemos la imagen.
//nombre_imagen.gif debe ser la ruta para llegar a la imagen.
?>