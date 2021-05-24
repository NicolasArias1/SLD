<?php
	include('../../../config/config.php');
	
	include('../../../inc/db.class.php');
	include('../../../inc/sch.class.php');
	include('../../../inc/useful.fns.php');
	include('../../../inc/user.class.php');
	include('../../../utilities/user_practicas_creadas.mod.php');
	
	session_start();
	
	$session = $_SESSION['user'];

	if(empty($session)) {
		header('Location: ../../../index.php');
	}//end if
	
	$user = unserialize($session);
	$uid = $user->getUID();
	$name = $user->getName();
	$login = $user->getLogin();
	$mail = $user->getEMail();
	$domain = $user->getDomain();
	$level = $user->getPriority();
	
		
	$_SESSION['user'] = serialize($user);
	
	if($level > 1) {
		if($level == 2)
			header('Location: ../../operator/index.php');
		else if($level == 3)
			header('Location: ../../user/index.php');
		else
			header('Location: ../../../general/logout.php');
	}//end if
	
	$usrHTML = "<li><a href=\"../../user/index.php\" class=\"ast3\">Usar</a></li>";
	
	$btxt = "Servicio Pr&aacute;cticas Asistidas";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Pr&aacute;cticas</title>
  	<link href="../../../css/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="page">
		<div id="header">
			<div id="header_t">
				<div id="header_t_l"><img src="../../../img/logo.png" border="0" /></div>
				<div id="header_t_r"><?php echo Date_Time(); ?></div>
			</div>
			<div id="header_b">
				<div id="header_l"></div>
				<div id="header_c">
					<h1 class="logo">SLD<span class="w_txt">WEB</span></h1>
					<h4 class="txt">Sistema de Laboratorios a Distancia </h4>
				</div>
				<div id="header_r"></div>
			</div>
		</div>
		<div id="navigator">
			<div id="nav_l"></div>
			<div id="nav_c">
				<ul>
					<li><a href="../index.php">Inicio</a></li>
					<li><a href="../../user/theory.php">Teor&iacute;a</a></li>
					<li><a href="../../user/practices.php">Pr&aacute;cticas</a></li>
					<li><a href="../../user/platform.php">Plataforma</a></li>					
				</ul>
			</div>
			<div id="nav_r"></div>
		</div>
		<div id="content">
			<div id="content_l">
				<div id="content_l_t"></div>
				<div id="content_l_c">
					<h1 class="content_l_hst1">Usuario</h1>
					<ul>
						<li><?php echo $name; ?></li>
						<?php echo $usrHTML; ?>
						<li><a href="../../../general/logout.php" class="ast3">Logout</a></li>
					</ul>
					<h1 class="content_l_hst1">Navegaci&oacute;n</h1>
					<ul>
						<li><a href="../index.php" class="ast3">Inicio</a></li>
						<li><a href="practicas_creadas.php" class="ast3">Pr&aacute;cticas creadas</a></li>
						<li><a href="indexCreacion.php" class="ast3">Nueva pr&aacute;ctica</a></li>
						<li><a href="mailto:sldadm@hotmail.com">Contacto</a></li>
					</ul>
					
				</div>
				<div id="content_l_b"></div>
			</div>
			<div id="content_r">
				<?php
				if($res)
					echo $strHTML;
				else {
					?>
					<h1 class="content_r_hst1">Pr&aacute;cticas disponibles</h1>
					<h1 class="content_r_hst3">Los experimentos reales solo est&aacute;n disponibles de lunes a viernes entre las 9 y las 21 horas (GMT +01:00 Bruselas, Copenhague, Madrid, Par&iacute;s )</h1>
					<?php 
						echo $strHTML;
				}//end else
				?>
			</div>
				
			<div class="blank"></div>
		</div>
		<div id="footer">
			Copyright &copy; 2009 GARP - Facultad de Ingenier&iacute;a El&eacute;ctrica<br />
			Universidad Central &quot;Marta Abreu&quot; de Las Villas.
		</div>
	</div>
</body>
</html>
