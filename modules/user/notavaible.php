<?php
include('../../inc/useful.fns.php');
include('../../inc/user.class.php');

require_once('../../libraries/Mobile_Detect.php');

$detect = new Mobile_Detect;

session_start();

$session = $_SESSION['user'];

if (empty($session)) {
	header('Location: ../../index.php');
}

$user = unserialize($session);
$uid = $user->getUID();
$name = $user->getName();
$login = $user->getLogin();
$mail = $user->getEMail();
$domain = $user->getDomain();
$level = $user->getPriority();
$_SESSION['user'] = serialize($user);

if ($level == 1) {
	$usrHTML = "<li><a href=\"../admin/index.php\" class=\"ast3\">Administrar</a></li>";
	header('Location: ../admin/index.php');
} else if ($level == 2) {
	$usrHTML = "<li>Operar</li>";
} else if ($level == 3) {
	$usrHTML = "";
}
?>

<?php if ($level == 2 ) {  ?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php require_once('css/libcss.php') ?>
	<script language="JavaScript" src="../../js/sld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../../js/osld.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../../modules/admin/css/index.css">
	<link rel="stylesheet" href="css/practices.css">

</head>

<body>
	<div id="wrapper">
		<?php require_once('../../structure/sidebar_profesor.php') ?>

		<div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>

			<?php require_once('../../structure/navbar_admin.php') ?>

			<div class="container-fluid p-0 px-lg-0 px-md-0">
				<div class="container-fluid px-lg-4 content_g ">
					<div class="row">
						<div id="content3" class="col-md-12 mt-lg-4 mt-4">


								<div class="alert alert-danger" role="alert" style="width:80%;text-align:center">
									<h4 class="alert-heading text-uppercase" style="font-weight:900;">Módulo en desarrollo
									</h4>
									<p>El módulo seleccionado no se encuentra disponible.</p>
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


<?php if ($level == 3) {  ?>


<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php require_once('css/libcss.php') ?>
	<script language="JavaScript" src="../../js/sld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../../js/osld.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../../modules/admin/css/index.css">
	<link rel="stylesheet" href="css/practices.css">

</head>

<body>
	<div id="wrapper">
		<?php require_once('../../structure/sidebar_estudiante.php') ?>

		<div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>

			<?php require_once('../../structure/navbar_admin.php') ?>

			<div class="container-fluid p-0 px-lg-0 px-md-0">
				<div class="container-fluid px-lg-4 content_g ">
					<div class="row">
						<div id="content3" class="col-md-12 mt-lg-4 mt-4">

							<div class="alert alert-danger" role="alert" style="width:80%;text-align:center">
								<h4 class="alert-heading text-uppercase" style="font-weight:900;">Módulo en desarrollo
								</h4>
								<p>El módulo seleccionado no se encuentra disponible.</p>
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