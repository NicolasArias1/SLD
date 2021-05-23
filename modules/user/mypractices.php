<?php
	include('../../config/config.php');
	
	include('../../inc/db.class.php');
	include('../../inc/sch.class.php');
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
	
	$method = $_SERVER['REQUEST_METHOD'];
	$body = isset($_GET['body']);
	$id = isset($_GET['id']);
	$body = isset($_GET['body']);
	$order = isset($_GET['order']);
	$show = isset($_GET['show']);
	$page = isset($_GET['page']);
	$type = isset($_GET['type']);
	$alert = isset($_GET['alert']);
	$res = isset($_GET['res']);
	
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
	
	if(!$body)
		$body = "mypractices";
	
	if($page==0 || $page==1)
		$page=1;
	
	if(!$show)
		$show = 20;
		
	if(!$order)
		$order = 'id';
	
	$btxt = "Pr&aacute;cticas Realizadas";
	
	switch($body) {
		case "mprevisadas":
			$status = "recurso";
			$btxt = "Pr&aacute;cticas Revisadas";
			$txtlog = "?body=mprevisadas";
			break;
		case "mprevisar":
			$status = "sugerencia";
			$btxt = "Pr&aacute;cticas por Revisar";
			$txtlog = "?body=mprevisar";
			break;
	}//end switch
	
	
	include('../../utilities/mypractices.mod.php');	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Inicio</title>
  <link href="../../css/styles.css" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="../../img/aicon.gif" />
	<script language="JavaScript" src="../../js/sld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../../js/osld.js" type="text/javascript"></script>
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
					<h1 class="content_l_hst1">Opciones</h1>
					<ul>
						<li><a href="mypractices.php?body=mprevisadas" class="ast3">Pr&aacute;cticas revisadas</a></li>
						<li><a href="mypractices.php?body=mprevisar" class="ast3">Pr&aacute;cticas por revisar</a></li>
					</ul>
				</div>
				<div id="content_l_b"></div>
			</div>
			<div id="content_r">
				<?php if(!$res) {?><h1 class="content_r_hst1"><?php echo $btxt; ?></h1><?php } ?>				
				<div id="results_box">				
					<?php echo $resHTML; ?>					
				</div>
			</div>
			<div class="blank"></div>
		</div>
		<div id="footer">
			Copyright &copy; 2017: GARP.UCLV-DIEE.UBB
		</div>
	</div>
</body>
</html>
