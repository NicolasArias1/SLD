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

		<?php require_once('../../structure/sidebar_profesor.php') ?>

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

<!-- Realiza práctica desde perfil estudiante. -->
<?php if ($level == 3) { ?>

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

		<?php require_once('../../structure/sidebar_estudiante.php') ?>

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