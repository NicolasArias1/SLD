<?php
include('../../config/config.php');

include('../../inc/db.class.php');
include('../../inc/frm.class.php');
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
$id = '';
$body = '';
$rbody = '';
$alert = '';
$page = '';
$order = '';
$show = '';
$type = '';

if ($level > 1) {
	if ($level == 2)
		header('Location: ../operator/index.php');
	else if ($level == 3)
		header('Location: ../user/index.php');
	else
		header('Location: ../../general/logout.php');
} //end if


if (isset($_GET['id'])) {
	$id = $_GET['id'];
}
if (isset($_GET['body'])) {
	$body = $_GET['body'];
}
if (isset($_GET['rbody'])) {
	$rbody = $_GET['rbody'];
}
if (isset($_GET['alert'])) {
	$alert = $_GET['alert'];
}
if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
if (isset($_GET['order'])) {
	$order = $_GET['order'];
}
if (isset($_GET['show'])) {
	$show = $_GET['show'];
}
if (isset($_GET['type'])) {
	$type = $_GET['type'];
}



$usrHTML = "<li><a href=\"../user/index.php\" class=\"ast3\">Usar</a></li>";

if ($name == '')
	$name = $login;

if ($page == 0 || $page == 1)
	$page = 1;

if (!$body)
	$body = "configp";

if (!$show)
	$show = 20;

if (!$order)
	$order = 'id';

if ($alert) {
	switch ($alert) {
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
	} //end switch
} //end if

switch ($body) {
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
		$rpage = "../modules/admin/configp.php?body=newp";
		break;
	case "edit":
		$btxt = "Editar Pr&aacute;ctica";
		$txtlog = "?body=editp";
		$rpage = "../modules/admin/configp.php?body=" . $rbody . "&order=" . $order . "&show=" . $show . "&page=" . $page;
		break;
} //end switch

include('../../utilities/configp.mod.php');
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php require_once('css/libcss.php') ?>
	<link rel="stylesheet" href="css/index.css">
	<script language="JavaScript" src="../../js/sld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../../js/osld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../../js/asld.js" type="text/javascript"></script>
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
								<?php if ($alert) {  ?>
									<p class="alert alert-secondary" role="alert"><?php echo $atxt; ?></p>
								<?php } ?>
								<br>
								<h1 class="content_r_hst1"><?php echo $btxt; ?></h1>
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