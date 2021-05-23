<?php

if($_POST['mlmfile'] == "m_controlvs" && $_POST['kp'] <= 0.01 && $_POST['kp'] > 0 && $_POST['ki'] <= 0.03 && $_POST['ki'] > 0 && $_POST['kd'] > 0 && $_POST['kd'] <= 0.00001 && $_POST['fc'] > 0 && $_POST['fc'] <= 50 && $_POST['fi'] > 0 && $_POST['fi'] <= 10 && $_POST['T'] >= 0.001 && $_POST['T'] <= 1);
	
else {
  header("Location: errors/validateerror.html");
  exit;
}//end else
	
	
?>  