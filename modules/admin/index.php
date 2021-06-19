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
}

$user = unserialize($session);
$uid = $user->getUID();
$name = $user->getName();
$login = $user->getLogin();
$mail = $user->getEMail();
$domain = $user->getDomain();
$level = $user->getPriority();
$_SESSION['user'] = serialize($user);
$user_tipe = 'ADM | ';
$id = '';
$body = '';
$order = '';
$show = '';
$page = '';
$type = '';
$alert = '';
$res = '';
$resHTML = '';

if ($level > 1) {
	if ($level == 2)
		header('Location: ../operator/index.php');
	else if ($level == 3) {
		header('Location: ../user/index.php');
	} else {
		header('Location: ../../general/logout.php');
	}
}

$method = $_SERVER['REQUEST_METHOD'];
if (isset($_GET['id'])) {
	$id = $_GET['id'];
}
if (isset($_GET['body'])) {
	$body = $_GET['body'];
}
if (isset($_GET['order'])) {
	$order = $_GET['order'];
}
if (isset($_GET['show'])) {
	$show = $_GET['show'];
}
if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
if (isset($_GET['type'])) {
	$type = $_GET['type'];
}
if (isset($_GET['alert'])) {
	$alert = $_GET['type'];
}
if (isset($_GET['res'])) {
	$res = $_GET['res'];
}

$usrHTML = "<li><a href=\"../user/index.php\" class=\"ast3\">Usar</a></li>";

if (!$body) $body = "revisadas";

if ($page == 0 || $page == 1) $page = 1;

if (!$show) $show = 20;

if (!$order) $order = 'id';

switch ($body) {
	case "revisadas":
		$status = "recurso";
		$btxt = "Pr&aacute;cticas Revisadas";
		$txtlog = "?body=revisadas";
		break;
	case "revisar":
		$status = "sugerencia";
		$btxt = "Pr&aacute;cticas por Revisar";
		$txtlog = "?body=revisar";
		break;
	case "realizadas":
		$status = "recurso";
		$btxt = "Pr&aacute;cticas Realizadas";
		$txtlog = "?body=realizadas";
		break;
	case "tablaprom":
		$sql = new SQL();
		$sql->SQLConnection();

		$query = "	SELECT ulogin, pname, COUNT( pname ) AS TOTAL
						FROM sld_practices
						WHERE ok =1
						GROUP BY pname
						ORDER BY ulogin";
		$result = $sql->SQLQuery($query);

		$status = "tablaprom";
		$btxt = "Tabla pr&aacute;cticas exitosas";
		$txtlog = "?body=tablaprom";
		$data = $result;

		break;
}



if ($res) {
	$path = "../../results/" . $res . "/";
	ob_start();
	include($path . 'salida.html');
	$resHTML = ob_get_contents();
	ob_end_clean();

	include('../../utilities/setonline.mod.php');
} else {
	include('../../utilities/practices.mod.php');
}

?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php require_once('css/libcss.php') ?>
	<script language="JavaScript" src="../../js/sld.js" type="text/javascript"></script>
	<script language="JavaScript" src="../../js/osld.js" type="text/javascript"></script>
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

								<?php if ($btxt == 'Pr&aacute;cticas Revisadas') { ?>

									<h1 class="content_r_hst1">
										Desarrollado por GARP (UCLV)

										<br />
										<span class="content_r_sst1">
											(Grupo de Automatización Robótica y Percepción)
										</span>
									</h1>
									<h1 class="content_r_hst1">
										En colaboración con DISAM (UPM)
										<br />
										<span class="content_r_sst1">
											(Departamento de Automática, Ingeniería Electrónica e Informática Industrial)
										</span>
									</h1>
									<h1 class="content_r_hst1">
										En colaboraci&oacute;n con DIEE (UBB)
										<br />
										<span class="content_r_sst1">
											(Departamento de Ingenier&iacute;a El&eacute;ctrica y Electr&oacute;nica)
										</span>
									</h1>

									<div class="content_r_hst3">
										<p>
											Permite ejecutar experiencias de control tanto de forma virtual (simulando con
											el modelo correspondiente) como real (accionando un dispositivo en tiempo real).
										</p>
										<p style="margin-top:50px;">
											<img class="img-fluid rounded mx-auto " width=100 height=100 alt="" hspace=1 vspace=1 src="../../img/uclv_logo.jpg">
											<img class="img-fluid rounded mx-auto " width=100 height=100 alt="" hspace=1 vspace=1 src="../../img/upm_logo.jpg">
											<img class="img-fluid rounded mx-auto " width=100 height=100 alt="" hspace=1 vspace=1 src="../../img/ubb_logo.jpg">
										</p>
									</div>
								<?php } ?>


								<?php if ($btxt == 'Pr&aacute;cticas Realizadas') { ?>

									<?php if (!$res) { ?><h1 class="content_r_hst1"><?php echo $btxt; ?></h1><?php } ?>
									<div id="results_box">
										<?php
										echo $resHTML;

										if (!empty($data)) {
											echo "<table id='tablapractica' cellspacing='0' width='100%'";
											echo "<thead>
												<tr>								
													<th>Usuario</th>
													<th>Prueba</th>
													<th>Pruebas exitosas</th>	
													<th></th>
												</tr>
												</thead>";
											for ($i = 0; $i < count($data); $i++) {

												$row = $data[$i];
												echo "<tr><td>" . $row['ulogin'] . "</td><td>" . $row['pname'] . "</td><td>" . $row['TOTAL'] . "</td></tr>";
											}
											echo "<tr></tr>";
											echo "</table>";
										}

										?>

									</div>

								<?php } ?>

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