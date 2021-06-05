<?php
include('../../config/config.php');

include('../../inc/db.class.php');
include('../../inc/sch.class.php');
include('../../inc/useful.fns.php');
include('../../inc/user.class.php');

require_once('../../libraries/Mobile_Detect.php');

$detect = new Mobile_Detect;

session_start();

$session = $_SESSION['user'];

if (empty($session)) {
	header('Location: ../../index.php');
} //end if

$user = unserialize($session);
$uid = $user->getUID();
$name = $user->getName();
$login = $user->getLogin();
$mail = $user->getEMail();
$domain = $user->getDomain();
$level = $user->getPriority();
$_SESSION['user'] = serialize($user);

if ($level > 1) {
	if ($level == 2)
		header('Location: ../operator/index.php');
	else if ($level == 3)
		header('Location: ../user/index.php');
	else
		header('Location: ../../general/logout.php');
} //end if

$alert = '';
$rid = '';
$res = '';

//if (isset($alert)){ $alert = $_GET['alert']; }
if (isset($rid)) {
	$alert = $rid = $_GET['rid'];
}
if (isset($res)) {
	$alert = $res = $_GET['res'];
}



$image = "../";
$advuser = TRUE;


$usrHTML = "<li><a href=\"../user/index.php\" class=\"ast3\">Usar</a></li>";

if ($alert) {
	switch ($alert) {
		case 1:
			$atxt = "<strong>La operaci&oacute;n se realiz&oacute; con &eacute;xito:</strong> Su comentario fue recibido, ser&aacute; publicado luego de ser revisado.";
			break;
		case 2:
			$atxt = "<strong>No se puede realizar la operaci&oacute;n:</strong> Verifique su comentario, hay campos vacios.";
			break;
		case 3:
			$atxt = "<strong>No se puede realizar la operaci&oacute;n:</strong> Sus datos no se recibieron correctamente.";
			break;
	} //end switch
} //end if

if ($res) {
	$path = "../results/" . $res . "/";
	ob_start();
	include($path . 'salida.html');
	$resHTML = ob_get_contents();
	ob_end_clean();
} //end if

include('../../utilities/details.mod.php');
?>

<!-- Realiza práctica desde perfil adm. -->
<?php if ($level == 1) {  ?>

	<!doctype html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php require_once('css/libcss.php') ?>
		<script language="JavaScript" src="../../js/sld.js" type="text/javascript"></script>
		<script language="JavaScript" src="../../js/osld.js" type="text/javascript"></script>
		<script language="JavaScript" src="../../js/asld.js" type="text/javascript"></script>
		<link rel="stylesheet" href="css/index.css">
	</head>

	<body>
		<div id="wrapper">
			<div class="overlay"></div>

			<?php require_once('../../structure/sidebar_admin.php') ?>

			<div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>

				<?php require_once('../../structure/navbar_admin.php') ?>

				<div class="container-fluid p-0 px-lg-0 px-md-0">
					<div class="container-fluid px-lg-4 content_g ">
						<div class="row">
							<div id="content3" class="col-md-12 mt-lg-4 mt-4">

								<div id="content_r">

									<?php if (!$res) { ?><h1 class="content_r_hst1"><?php echo $btxt; ?></h1><?php } ?>
									<div id="results_box">
										<?php echo $resHTML; ?>
									</div>


								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>

	<?php require_once('js/libjs.php') ?>
	<script src="js/index.js"></script>

	</html>


<?php }  ?>




<!-- Realiza práctica desde perfil profesor. -->
<?php if ($level == 2) {  ?>




<?php }  ?>


<!-- Realiza práctica desde perfil est. -->
<?php if ($level == 3) {  ?>




<?php }  ?>












<!--


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
					<li><a href="users.php">Usuarios</a></li>					
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
						<li><a href="../../general/logout.php" class="ast3">Logout</a></li>
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
		
				<?php if (!$res) { ?><h1 class="content_r_hst1"><?php echo $btxt; ?></h1><?php } ?>
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
-->