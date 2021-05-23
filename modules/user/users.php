<?php
	include('../../config/config.php');	
	include('../../inc/db.class.php');
	include('../../inc/man.class.php');
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
	$alert = '';
	$error = '';
	$user_navigator = '';

	if(isset($_GET['alert'])) { $alert = $_GET['alert']; }
	if(isset($_GET['error'])) { $error = explode(":", $_GET['error']); }

	
	
	if($level == 1)
		$user_navigator = "<img src=\"../../img/uarrow.gif\" alt=\"Navegaci&oacute;n\" /> <a href=\"../admin/index.php\" class=\"linkb\" title=\"Administrar\">Administrar</a><br />";
	else if($level == 2)
		$user_navigator = "<img src=\"../../img/uarrow.gif\" alt=\"Navegaci&oacute;n\" /> <a href=\"../operator/index.php\" class=\"linkb\" title=\"Operar\">Operar</a><br />";
	
	if($domain == 'db') { //&& $level!=1
		$user_navigator .= "<img src=\"../../img/uarrow.gif\" alt=\"Navegaci&oacute;n\" /> <a href=\"users.php\" class=\"linkb\" title=\"Editar\">Editar</a><br />";
	}//end if
	
	if($name == '')
		$name = $login;
	
	if($alert) {
		switch($alert) {
			case 1:
				$atxt = "La operaci&oacute;n se realiz� con &eacute;xito: <span class=\"text\">Los datos se introdujeron correctamente.</span>";
				break;
			case 2:
				$efname = array('Nombre', 'Login', 'EMail');
				$atxt = "No se puede realizar la operaci&oacute;n: <span class=\"text\">Verifique sus datos, ya existe un usuario con los mismos.</span><br />Datos iguales: <span class=\"text\">";
				for($i=0; $i < count($error); $i++) {
					$atxt .= $efname[$error[$i]];
					if($i < (count($error)-1))
						$atxt .= ", ";
					else
						$atxt .= ".";
				}//end for
				$atxt .= "</span>";
				break;
			case 3:
				$atxt = "No se puede realizar la operaci&oacute;n: <span class=\"text\">Verifique sus datos, hay campos vacios.</span>";
				break;
			case 4:
				$atxt = "No se puede realizar la operaci&oacute;n: <span class=\"text\">Sus datos no se recibieron correctamente.</span>";
				break;
		}//end switch
	}//end if
	
	//Creando objeto SQL
	$sql = new SQL();
	
	//Conectando con el servidor
	$sql->SQLConnection();
	
	include('../../utilities/setonline.mod.php');		
	//include('../modules/writelog.mod.php');
	
	//Cerrando conexi�n
	$sql->SQLClose();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Inicio</title>
    <link href="../../css/styles.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="../../js/sld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../../js/osld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../../js/asld.js" type="text/javascript"></script>
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
				<h1 class="content_r_hst1">Editar</h1>
				<form id="frmuser" name="frmuser" method="post" action="../../utilities/updatepersonaldata.mod.php" enctype="multipart/form-data">
				  <div class="user_celd">
						<p class="user_field"><img src="../../img/uarrow.gif" alt="Obligatorio" /> Nombre:
						  <input id="name" name="name" type="text" class="form_field" size="30" value="<?php echo $name; ?>" autocomplete="off" />
						</p>
					</div>
					<div class="user_celd">
						<p class="user_field"><img src="../../img/uarrow.gif" alt="Obligatorio" /> Nombre de Usuario:
						  <input id="login2" name="login" type="text" class="form_field" size="30" value="<?php echo $login; ?>" autocomplete="off" />
						</p>
					</div>
					<div class="user_celd">
						<p class="user_field"><img src="../../img/uarrow.gif" alt="Obligatorio" /> EMail:
						  <input id="mail2" name="mail" type="text" class="form_field" size="30" value="<?php echo $mail; ?>" autocomplete="off" />
						</p>
					</div>
					<div class="user_celd">
						<p class="user_field">&nbsp;&nbsp; Contrase&ntilde;a:
						  <input id="password2" name="password" type="password" class="form_field" size="30" maxlength="12" autocomplete="off" />
						</p>
					</div>
					<div class="user_celd">
						<p class="user_field">&nbsp;&nbsp; Confirmar:
						  <input id="confirm2" name="confirm" type="password" class="form_field" size="30" maxlength="12" autocomplete="off" />
						</p>
					</div>
					<div class="user_celd">
						<p class="user_field">
							<input id="id" name="id" type="hidden" value="<?php echo $uid; ?>">
							<input id="page" name="page" type="hidden" value="../user/users.php">
                            <input id="save2" name="save" type="button" class="form_button" value="Guardar" onclick="savePersonalData()" />
</p>
					</div>
				</form>
			</div>
			<div class="blank"></div>
		</div>
		<div id="footer">
			Copyright &copy; 2017: GARP.UCLV-DIEE.UBB
		</div>
	</div>
</body>
</html>
