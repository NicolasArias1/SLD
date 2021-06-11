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
$usrHTML = '';

if (!$level)
	header('Location: ../../general/logout.php');

if ($level == 1)
	$usrHTML = "<li><a href=\"../admin/index.php\" class=\"ast3\">Administrar</a></li>";
else if ($level == 2)
	$usrHTML = "<li>Operar</li>";
if ($domain == 'db' && $level != 1) {
	$usrHTML .= "<li><a href=\"users.php\" class=\"ast3\" title=\"Editar\">Editar Usuario</a></li>";
} //end if

if (isset($_GET['rid'])) $rid = $_GET['rid'];
$image = "../";
$advuser = FALSE;

if (isset($_GET['alert'])) {
	$alert = $_GET['alert'];

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
		}
	}
}

if (isset($_GET['res'])) {
	$res = $_GET['res'];

	if ($res) {
		$path = "../results/" . $res . "/";
		ob_start();
		include($path . 'salida.html');
		$resHTML = ob_get_contents();
		ob_end_clean();
	}
}

include('../../utilities/details.mod.php');

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
	<script language="JavaScript" src="../../js/asld.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../../modules/admin/css/index.css">


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
								<?php if (isset($alert) && $alert) { ?>
								<p class="alert"><?php echo $atxt; ?></p>
								<?php }	?>

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
	</div>
</body>

<?php require_once('../../modules/admin/js/libjs.php') ?>
<script src="../../modules/admin/js/index.js"></script>

</html>



<?php }  ?>

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
	<script language="JavaScript" src="../../js/asld.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../../modules/admin/css/index.css">


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
								<?php if (isset($alert) && $alert) { ?>
								<p class="alert"><?php echo $atxt; ?></p>
								<?php }	?>

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
	</div>
</body>

<?php require_once('../../modules/admin/js/libjs.php') ?>
<script src="../../modules/admin/js/index.js"></script>

</html>


<?php }  ?>

<!-- Realiza práctica desde perfil est. -->
<?php if ($level == 3) {  ?>


<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php require_once('../../modules/admin/css/libcss.php') ?>
	<script language="JavaScript" src="../../js/sld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../../js/osld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../../js/asld.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../../modules/admin/css/index.css">


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
								<?php if (isset($alert) && $alert) { ?>
								<p class="alert"><?php echo $atxt; ?></p>
								<?php }	?>

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
	</div>
</body>

<?php require_once('../../modules/admin/js/libjs.php') ?>
<script src="../../modules/admin/js/index.js"></script>

</html>



<?php }  ?>