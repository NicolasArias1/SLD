

<?php
    

header("Content-Type: text/html;charset=iso-8859-1");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified 
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache"); // HTTP/1.0 


$content = $_GET['content'];
$fieldName = $_GET['fieldname'];


$fieldname = $_GET['fieldname']; 
$variable = stripslashes($content);

echo stripslashes($content);

?>