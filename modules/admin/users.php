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
	$body = "users";

if (!$show)
	$show = 20;

if (!$order)
	$order = 'id';

if ($alert) {
	switch ($alert) {
		case 1:
			$atxt = "<strong>La operaci&oacute;n se realiz&oacute; con &eacute;xito:</strong> Los datos se introdujeron correctamente.";
			break;
		case 2:
			$atxt = "<strong>No se puede realizar la operaci&oacute;n:</strong> Verifique su usuario, ya existe un usuario con esos datos.";
			break;
		case 3:
			$atxt = "<strong>No se puede realizar la operaci&oacute;n:</strong> Verifique su usuario, hay campos vac&iacute;os.";
			break;
		case 4:
			$atxt = "<strong>No se puede realizar la operaci&oacute;n:</strong> Sus datos no se recibieron correctamente.";
			break;
	} //end switch
} //end if

switch ($body) {
	case "users":
		$btxt = "Usuarios Privilegiados";
		$txtlog = "?body=users";
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
		$btxt = "Nuevo Usuario";
		$txtlog = "?body=new";
		$rpage = "../modules/admin/users.php?body=new";
		break;
	case "edit":
		$btxt = "Editar Usuario";
		$txtlog = "?body=edit";
		$rpage = "../modules/admin/users.php?body=" . $rbody . "&order=" . $order . "&show=" . $show . "&page=" . $page;
		break;
	case "groups":
		$btxt = "Grupos de Usuarios";
		$txtlog = "?body=groups";
		break;
} //end switch

include('../../utilities/users.mod.php');
?>



<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<?php require_once('css/libcss.php') ?>
	<link rel="stylesheet" href="css/index.css">
</head>


<body <?php if ($body == 'new' || $body == 'edit') { ?> onLoad="usersLevel('<?php echo $usrdata['level']; ?>')" <?php } ?>>


	<div id="wrapper">
		<div class="overlay"></div>

		<!-- Sidebar -->
		<?php require_once('../../structure/sidebar_admin.php') ?>

		<div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>

			<!-- Topbar -->
			<?php require_once('../../structure/navbar_admin.php') ?>


			<!-- Begin Page Content -->
			<div class="container-fluid px-lg-4 content_g ">
				<div class="row" style="text-align:center;justify-content:center;align-items:center;">
					<div id="content3" style="width:700px;" class="col-md-12 mt-lg-4 mt-4">

						<div id="content_r">


							<div class="content_r_hst3">
								<?php if ($alert) {  ?>
									<p class="alert alert-secondary" role="alert"><?php echo $atxt; ?></p>
								<?php } ?>
								<br>

								<h1 class="content_r_hst1"><?php echo $btxt; ?></h1>
								<br>
								<div id="results_box">
									<?php echo $resHTML; ?>
								</div>

							</div>

						</div>
					</div>




				</div>

			</div>
			<!-- /.container-fluid -->

		</div>
		<!-- /#page-content-wrapper -->

	</div>
	<!-- /#wrapper -->

</body>


<?php require_once('js/libjs.php') ?>
<script src="js/index.js"></script>
<script language="javascript" src="../../js/sld.js" type="text/javascript"></script>
<script language="javascript" src="../../js/osld.js" type="text/javascript"></script>
<script language="javascript" src="../../js/asld.js" type="text/javascript"></script>


</html>