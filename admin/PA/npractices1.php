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
	
	if($level > 1) {
		if($level == 2)
			header('Location: ../../operator/index.php');
		else if($level == 3)
			header('Location: ../../user/index.php');
		else
			header('Location: ../../logout.php');
	}//end if
	
	$usrHTML = "<li><a href=\"../../user/index.php\" class=\"ast3\">Usar</a></li>";
	
	$btxt = "Pr&aacute;cticas Param&eacute;tricas";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Administraci&oacute;n : : Pr&aacute;cticas Asistidas</title>
  <link href="../../styles.css" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="../../img/aicon.gif" />
	<script language="JavaScript" src="../../js/sld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../../js/osld.js" type="text/javascript"></script>
</head>

<body>
	<div id="page">
		<div id="header">
			<div id="header_t">
				<div id="header_t_l"><a href="http://garp.fie.uclv.edu.cu" target="_blank"><img src="../../img/logo.png" border="0" /></a></div>
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
					<li><a href="users.php">Usuarios</a></li>
					<li><a href="#">Estad&iacute;sticas</a></li>
					<li><a href="#">Configuraci&oacute;n</a></li>
					<li><a href="TM/calendar.php">Reserva</a></li>
          <li><a href="configp.php">Configurar</a></li>
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
						<li><a href="users.php" class="ast3">Usuarios</a></li>
						<li>Estad&iacute;sticas</li>
						<li>Configuraci&oacute;n</li>
						<li><a href="TM/calendar.php" class="ast3">Reserva</a></li>
            <li><a href="configp.php" class="ast3">Configurar Pr&aacute;cticas</a></li>
					</ul>
					<h1 class="content_l_hst1">Opciones</h1>
					<ul>
						<li><a href="index.php?body=revisadas" class="ast3">Pr&aacute;cticas revisadas</a></li>
						<li><a href="index.php?body=revisar" class="ast3">Pr&aacute;cticas por revisar</a></li>
						<li>Nueva pr&aacute;ctica</li>
					</ul>
				</div>
				<div id="content_l_b"></div>
			</div>
			<div id="content_r">
				<h1 class="content_r_hst1"><?php echo $btxt; ?></h1>
				<form id="frmuser" name="frmuser" method="post" action="" enctype="multipart/form-data">
					<div class="user_celd">
						<p class="user_field"><img src="../../img/uarrow.gif" alt="Obligatorio" /> Texto de Introducci&oacute;n a la Pr&aacute;ctica:</p>
						<textarea id="comment_txt" name="comment_txt" size="500%" class="form_field"></textarea>
					</div>
					<div class="user_celd">
						<p class="user_field"><img src="../../img/uarrow.gif" alt="Obligatorio" /> Diagrama de la pr&aacute;ctica:</p>
						<input type="file" name="file" />
					</div>
					<div class="user_celd">
						<p class="user_field"><img src="../../img/uarrow.gif" alt="Obligatorio" /> Par&aacute;metros (Nombre-Etiqueta-LVI-LVS):</p>
						<input id="name" name="name" type="text" class="form_field" size="5" maxlength="12" autocomplete="off" />
						<input id="name" name="name" type="text" class="form_field" size="5" maxlength="12" autocomplete="off" />
						<input id="name" name="name" type="text" class="form_field" size="5" maxlength="12" autocomplete="off" />
						<input id="name" name="name" type="text" class="form_field" size="5" maxlength="12" autocomplete="off" />
						<input id="comsend" name="comsend" type="button" class="form_button" value="Nuevo Par&aacute;metro" />
					</div>
					
					<div class="user_celd">
						<p class="user_field">
							<input id="id" name="id" type="hidden" value="">
							<input id="page" name="page" type="hidden" value="">
						</p>
						<input id="save" name="save" type="button" class="form_button" value="Finalizar" />
					</div>
				</form>
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
