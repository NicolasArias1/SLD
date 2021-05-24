<?php
	include('../../inc/db.class.php');
	include('../../inc/man.class.php');
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
	
	if($level > 1) {
		if($level == 2)
			header('Location: ../operator/index.php');
		else if($level == 3)
			header('Location: ../user/index.php');
		else
			header('Location: ../../general/logout.php');
	}//end if
	
	$id = $_GET['id'];
	
	include('../../utilities/udetails.mod.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Cronos : : Administrador : : Detalles</title>
		<link href="../../css/styles1.css " rel="stylesheet" type="text/css" />
		<link href="../../css/acronos.css " rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="../../img/aicon.gif" />
	</head>

	<body>
		<div id="header_box">
			<div class="header_image"><img src=" ../../img/acdict.jpg" alt="CDICT" /></div>
			<div class="header_date"><?php Date_Time(); ?></div>
			<div class="header_navigator"></div>
		</div>
		<div id="banner_box">
			<div id="details_message">
				<p class="header">Contribuci&oacute;n</p>
				<p class="text_middle">
					Usted puede contribuir activamente con el sistema aportando sus comentarios acerca de cada recurso o emitiendo su valoraci&oacute;n del mismo.
				</p>
			</div>
		</div>
		<div id="details_box">
			<p class="header">Detalles del Usuario</p>
			<?php
			  echo $detHTML;
		  ?>
		</div>
		<?php
		if($adetHTML) {
			?>
			<div id="adetails_box">
				<p class="header">Detalles Adicionales del Usuario</p>
				<?php
				  echo $adetHTML;
			  ?>
			</div>
			<?php
		}//end if
		?>
		<div id="footer_box">
			<p class="footer_text">
		  	Copyright &copy; 2007 Biblioteca de Ingenier&iacute;a El&eacute;ctrica.<br />
		    CDICT Universidad Central &quot;Marta Abreu&quot; de Las Villas.<br />
		  	Dise&ntilde;o y Programaci&oacute;n: Yidier Rodr&iacute;guez P&eacute;rez de Alejo.
		  </p>
			<p class="footer_realized">
				Realizado por:<br />
				<img src="../img/aepsilon.jpg" alt="Grupo Epsilon" />
			</p>
		</div>
	</body>
</html>