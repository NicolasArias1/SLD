<?php
	include('../../inc/useful.fns.php');
	include('../../inc/user.class.php');
	
	session_start();
	
	$session = $_SESSION['user'];

	if(empty($session)) {
		header('Location: ../../index.php');
	}//end if
	
	$user = unserialize($session);
	$uid = $user->getUID();
	$name = $user->getName();
	$login = $user->getLogin();
	$mail = $user->getEMail();
	$domain = $user->getDomain();
	$level = $user->getPriority();
	$_SESSION['user'] = serialize($user);
	
	if($level == 1)
		$usrHTML = "<li><a href=\"../admin/index.php\" class=\"ast3\">Administrar</a></li>";
	else if($level == 2)
		$usrHTML = "<li>Operar</li>";
		else if($level == 3){
			$usrHTML = "";
		}
	//if($domain == 'db' && $level!=1) {
	//	$usrHTML .= "<li><a href=\"users.php\" class=\"ast3\" title=\"Editar\">Editar Usuario</a></li>";
	//}//end if
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Teor&iacute;a</title>
  <link href="../../css/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="page">
		<div id="header">
			<div id="header_t">
				<div id="header_t_l"><img src="../../img/logo.png" border="0" /></div>
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
					<li><a href="index.php">Inicio</a></li>
					<li><a href="theory.php">Teor&iacute;a</a></li>
					<li><a href="practices.php">Pr&aacute;cticas</a></li>
					<li><a href="platform.php">Plataforma</a></li>					
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
						<li><a href="../../general/logout.php" class="ast3">Logout</a></li>
					</ul>
					<h1 class="content_l_hst1">Navegaci&oacute;n</h1>
					<ul>
						<li><a href="index.php" class="ast3">Inicio</a></li>
						<li><a href="theory.php" class="ast3">Teoria</a></li>
						<li><a href="practices.php" class="ast3">Pr&aacute;cticas</a></li>
						<li><a href="platform.php" class="ast3">Plataforma</a></li>
						<li><a href="mypractices.php" class="ast3">Mis Pr&aacute;cticas</a></li>
						<li><a href="mailto:ching@uclv.edu.cu;aerubio@ubiobio.cl">Contacto</a></li>
					</ul>
				</div>
				<div id="content_l_b"></div>
			</div>
				
			</div>
			<div id="content_r">
				<h1 class="content_r_hst1">Consideraciones te&oacute;ricas:</h1>
				<ol class="practices">
					<li class="practice"><a href="theory/modeltanks.php" class="ast1">Modelado del sistema de tanques acoplados</a></li>
					<li class="practice"><a href="theory/motorcd.php" class="ast1">Modelado de un motor de corriente directa</a></li>
					<li class="practice"><a href="theory/modeloport.php" class="ast1">Identificaci&oacute;n de Sistemas por modelo PORT</a></li>
					<li class="practice"><a href="theory/pddesac.php" class="ast1">PD desacoplado para control de posici&oacute;n de motores</a></li>
					<li class="practice"><a href="theory/filtro.php" class="ast1">Implementaci&oacute;n de filtro digital</a></li>
				<li class="practice"><a href="theory/Control.php" class="ast1">Implementaci&oacute;n de control digital</a></li>
				</ol>
			</div>
			<div class="blank"></div>
		</div>
		<div id="footer">
			Copyright &copy; 2017: GARP.UCLV-DIEE.UBB
		</div>
	</div>
</body>
</html>
