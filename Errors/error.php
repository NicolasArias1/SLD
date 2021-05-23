<?php
	include('../inc/useful.fns.php');
	include('../inc/user.class.php');
	
	session_start();
	
	$session = $_SESSION['user'];

	if(empty($session)) {
		header('Location: ../index.php');
	}//end if
	
	$user = unserialize($session);
	$uid = $user->getUID();
	$name = $user->getName();
	$login = $user->getLogin();
	$mail = $user->getEMail();
	$domain = $user->getDomain();
	$level = $user->getPriority();
	$_SESSION['user'] = serialize($user);
	
        $varerror = $_GET['err'];

	if($level == 1)
		$usrHTML = "<li><a href=\"../modules/admin/index.php\" class=\"ast3\">Administrar</a></li>";
	else if($level == 2)
		$usrHTML = "<li>Operar</li>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Inicio</title>
  <link href="../css/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="page">
		<div id="header">
			<div id="header_t">
				<div id="header_t_l"><img src="../img/logo.png" border="0" /></div>
				<div id="header_t_r"><?php echo Date_Time(); ?></div>
			</div>
			<div id="header_b">
				<div id="header_l"></div>
				<div id="header_c">
					<h1 class="logo">SLD<span class="w_txt">WEB</span></h1>
					<h4 class="txt">Sistema de Laboratorios a Distancia</h4>
				</div>
				<div id="header_r"></div>
			</div>
		</div>
		<div id="navigator">
			<div id="nav_l"></div>
			<div id="nav_c">
				<ul>
					<li><a href="../modules/user/index.php">Inicio</a></li>
					<li><a href="../modules/user/theory.php">Teoría</a></li>
					<li><a href="../modules/user/practices.php">Prácticas</a></li>
					<li><a href="../modules/user/platform.php ">Plataforma</a></li>					
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
						<li><a href="../logout.php class="ast3">Logout</a></li>
					</ul>
					<h1 class="content_l_hst1">Navegación</h1>
					<ul>
						<li><a href="../modules/user/index.php " class="ast3">Inicio</a></li>
						<li><a href="../modules/user/theory.php" class="ast3">Teoria</a></li>
						<li><a href="../modules/user/practices.php" class="ast3">Pr&aacute;cticas</a></li>
						<li><a href="../modules/user/platform.php" class="ast3">Plataforma</a></li>
						<li><a href="../modules/user/mypractices.php" class="ast3">Mis Pr&aacute;cticas</a></li>
					</ul>
				</div>
				<div id="content_l_b"></div>
			</div>
			<div id="content_r">
			    <h1 class="content_r_hst1">ERROR</h1>
			</div>	
			<div id="content_r">
			 <?php
				if($varerror)
					echo "\n".$varerror;
				?>             
			</div>
			<div align="center">
			   <p><a href="javascript:history.back()"><img name="Atras_r2_c2" src="../errors/images/Atras_r2_c2.jpg" width="71" height="21" border="0"></a>
			</div>			
		</div>
		<div class="blank"></div>
		<div id="footer">
			Copyright &copy; 2009 GARP - Facultad de Ingenier&iacute;a El&eacute;ctrica<br />
			Universidad Central &quot;Marta Abreu&quot; de Las Villas.
		</div>
	</div>
</body>
</html>
