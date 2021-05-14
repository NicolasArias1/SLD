<?php
	include('../config/config.php');
	
	include('../inc/db.class.php');
	include('../inc/frm.class.php');
	include('../inc/sch.class.php');
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
	$id = '';
	$body = '';
	$rbody = '';
	$alert = '';
	$page = '';
	$order = '';
	$show = '';
	$type = '';
	
	if($level > 1) {
		if($level == 2)
			header('Location: ../operator/index.php');
		else if($level == 3)
			header('Location: ../user/index.php');
		else
			header('Location: ../logout.php');
	}//end if


	if (isset($_GET['id'])){ $id = $_GET['id']; }
	if (isset($_GET['body'])){ $body = $_GET['body']; }
	if (isset($_GET['rbody'])){ $rbody = $_GET['rbody']; }
	if (isset($_GET['alert'])){ $alert = $_GET['alert']; }
	if (isset($_GET['page'])){ $page = $_GET['page']; }
	if (isset($_GET['order'])){ $order = $_GET['order']; }
	if (isset($_GET['show'])){ $show = $_GET['show']; }
	if (isset($_GET['type'])){ $type = $_GET['type']; }

		

	$usrHTML = "<li><a href=\"../user/index.php\" class=\"ast3\">Usar</a></li>";
	
	if($name == '')
		$name = $login;
	
	if($page==0 || $page==1)
		$page=1;
	
	if(!$body)
		$body = "configp";
		
	if(!$show)
		$show = 20;
	
	if(!$order)
		$order = 'id';
	
	if($alert) {
		switch($alert) {
			case 1:
				$atxt = "La operaci&oacute;n se realiz&oacute; con &eacute;xito: <span class=\"text\">Los datos se introdujeron correctamente.</span>";
				break;
			case 2:
				$atxt = "No se puede realizar la operaci&oacute;n: <span class=\"text\">Verifique sus datos, existen datos repetidos.</span>";
				break;
			case 3:
				$atxt = "No se puede realizar la operaci&oacute;n: <span class=\"text\">Verifique sus datos, hay campos vac&iacute;os.</span>";
				break;
			case 4:
				$atxt = "No se puede realizar la operaci&oacute;n: <span class=\"text\">Sus datos no se recibieron correctamente.</span>";
				break;
		}//end switch
	}//end if
	
	switch($body) {
		case "configp":
			$btxt = "Pr&aacute;cticas Disponibles";
			$txtlog = "?body=configp";
			break;
		case "profiles":
			$btxt = "Perfiles de Usuarios";
			$txtlog = "?body=profiles";
			break;
		case "solicit":
			$btxt = "Solicitudes de Usuarios";
			$txtlog = "?body=solicit";
			break;
		case "new":
			$btxt = "Nueva Pr&aacute;ctica";
			$txtlog = "?body=newp";
			$rpage = "../admin/configp.php?body=newp";
			break;
		case "edit":
			$btxt = "Editar Pr&aacute;ctica";
			$txtlog = "?body=editp";
			$rpage = "../admin/configp.php?body=".$rbody."&order=".$order."&show=".$show."&page=".$page;
			break;
	}//end switch
	
	include('../modules/configp.mod.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Administraci&oacute;n : : Usuarios</title>
  <link href="../styles.css" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="../img/aicon.gif" />
	<script language="JavaScript" src="../js/sld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../js/osld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../js/asld.js" type="text/javascript"></script>
</head>

<body <?php if($body == 'newp' || $body == 'editp') { ?> onLoad="usersLevel('<?php echo $usrdata['level']; ?>')"<?php }//end if ?>>
	<div id="page">
		<div id="header">
			<div id="header_t">
				<div id="header_t_l"><img src="../img/logo.png" border="0" /></a></div>
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
					<li><a href="configp.php">Configurar Pr&aacute;cticas</a></li>
					
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
						<li><strong><?php echo $name; ?></strong></li>
						<?php echo $usrHTML; ?>
						<li><a href="../logout.php" class="ast3">Logout</a></li>
					</ul>
					<h1 class="content_l_hst1">Navegaci&oacute;n</h1>
					<ul>
						<li><a href="index.php" class="ast3">Inicio</a></li>
						<li><a href="configp.php" class="ast3">Configurar Pr&aacute;cticas</a></li>
						
					</ul>
					<h1 class="content_l_hst1">Opciones</h1>
					<ul>
						<li><a href="configp.php?body=configp" class="ast3">Editar Pr&aacute;cticas</a></li>
						<li><a href="configp.php?body=new" class="ast3">Subir Pr&aacute;cticas</a></li>
					</ul>
				</div>
				<div id="content_l_b"></div>
			</div>
			<div id="content_r">
				<?php
					if($alert) {
						?>
						<p class="alert"><?php echo $atxt; ?></p>
						<?php
					}//end if
				?>
				<h1 class="content_r_hst1"><?php echo $btxt; ?></h1>
				<div id="results_box">
					<?php echo $resHTML; ?>
				</div>
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
