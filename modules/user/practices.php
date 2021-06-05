<?php
include('../../config/config.php');
include('../../inc/db.class.php');
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

include('../../utilities/user_practices.mod.php');

if ($level == 1)
	$usrHTML = "<li><a href=\"../admin/index.php\" class=\"ast3\">Administrar</a></li>";
else if ($level == 2)
	$usrHTML = "<li>Operar</li>";
else if ($level == 3) {
	$usrHTML = "";
}
//if($domain == 'db' && $level!=1) {
//	$usrHTML .= "<li><a href=\"users.php\" class=\"ast3\" title=\"Editar\">Editar Usuario</a></li>";
//}//end if


//Para actualizar estaciones apagadas	
$ahora = date("dmyHis");

//5 minutos antes
$ahora = $ahora - 500;

//Creando objeto SQL
$sql = new SQL();

//Conectando con el servidor
$sql->SQLConnection();

// Direccion IP de la estacion
$query = "SELECT ip, pcount, lastaccess FROM sld_stations WHERE state ='off'";

//Ejecutando consulta
$result = $sql->SQLQuery($query);

if (is_array($result)) {
	$cantoff = count($result);
	for ($i = 0; $i < count($result); $i++) {
		if ($result[$i]['lastaccess'] < $ahora) {
			$wip = $result[$i]['ip'];
			$query = "UPDATE sld_stations SET state='wait', pcount = 0 WHERE ip='$wip'";
			$sql->SQLQuery($query);
		} //end if						
	} //end for		
} //end if	

?>

<!-- Realiza práctica desde perfil admin. -->
<?php if ($level == 1) {  ?>



	<!doctype html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php require_once('../../modules/admin/css/libcss.php') ?>
		<script language="JavaScript" src="../../js/sld.js" type="text/javascript"></script>
		<script language="JavaScript" src="../../js/osld.js" type="text/javascript"></script>
		<link rel="stylesheet" href="../../modules/admin/css/index.css">
		<link rel="stylesheet" href="css/practices.css">

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


									<h1 class="content_r_hst1">Pr&aacute;cticas disponibles</h1>
									<?php
									echo $strHTML;
									?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>

	<?php require_once('../../modules/admin/js/libjs.php') ?>
	<script src="../../modules/admin/js/index.js"></script>

	</html>






<?php } ?>


<!-- Realiza práctica desde perfil profesor. -->
<?php if ($level == 2) {  ?>

<?php } ?>

<!-- Realiza práctica desde perfil estudiante. -->
<?php if ($level == 3) { ?>

	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Sistema de Laboratorios a Distancia : : Pr&aacute;cticas</title>
		<link href="../../css/styles.css" rel="stylesheet" type="text/css" />
	</head>

	<body>
		<div id="page">
			<div id="header">
				<div id="header_t">
					<div id="header_t_l"><img src="../../img/logo.png" /></div>
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
				<div id="content_r">

					<h1 class="content_r_hst1">Pr&aacute;cticas disponibles</h1>
					<?php
					echo $strHTML;
					?>
				</div>

				<div class="blank"></div>
			</div>
			<div id="footer">
				Copyright &copy; 2017: GARP.UCLV-DIEE.UBB
			</div>
		</div>
	</body>

	</html>

<?php } ?>




<!--
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Pr&aacute;cticas</title>
	<link href="../../css/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="page">
		<div id="header">
			<div id="header_t">
				<div id="header_t_l"><img src="../../img/logo.png" /></div>
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
			<div id="content_r">

				<h1 class="content_r_hst1">Pr&aacute;cticas disponibles</h1>
				<?php
				echo $strHTML;
				?>
			</div>

			<div class="blank"></div>
		</div>
		<div id="footer">
			Copyright &copy; 2017: GARP.UCLV-DIEE.UBB
		</div>
	</div>
</body>

</html>

 -->