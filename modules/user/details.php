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




<?php }  ?>

<!-- Realiza práctica desde perfil est. -->
<?php if ($level == 3) {  ?>




<?php }  ?>



<!--


<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
					<h1 class="content_l_hst1">Opciones</h1>
					<ul>
						<li><a href="mypractices.php?body=mprevisadas" class="ast3">Pr&aacute;cticas revisadas</a></li>
						<li><a href="mypractices.php?body=mprevisar" class="ast3">Pr&aacute;cticas por revisar</a></li>
					</ul>
				</div>
				<div id="content_l_b"></div>
			</div>
			<div id="content_r">
				<?php
				if (isset($alert) && $alert) {
				?>
				<p class="alert"><?php echo $atxt; ?></p>
				<?php
				}
				?>
				<?php if (!$res) { ?><h1 class="content_r_hst1"><?php echo $btxt; ?></h1><?php } ?>
				<div id="results_box">
					<?php echo $resHTML; ?>
				</div>
				<?php
				if ($ncomments) {
				?>
				<div id="comments_box">
					<?php
					echo $comHTML;
					?>
				</div>
				<?php
				} //end if

				?>
				<div id="comment_form_box">
					<h1 class="content_r_hst2">Comentario</h1>
					<p>
						Los comentarios que emitir&aacute; ser&aacute;n revisados por los profesores.
					</p>
					<form id="comment_form" name="comment_form" method="post"
						action="../../utilities/updatecontribution.mod.php" enctype="multipart/form-data">
						<input id="action" name="action" type="hidden" value="new">
						<input id="id" name="id" type="hidden">
						<input id="rid" name="rid" type="hidden" value="<?php echo $rid; ?>">
						<input id="advuser" name="advuser" type="hidden" value="<?php echo $advuser; ?>">
						<input id="page" name="page" type="hidden"
							value="../user/details.php?res=<?php echo $res; ?>&rid=<?php echo $rid; ?>">
						<textarea id="comment_txt" name="comment_txt" cols="68" rows="3" class="input_field"></textarea>
						<input id="comsend" name="comsend" type="button" class="form_button" value="Guardar"
							onclick="saveComment()" />
						<input id="comreset" name="comreset" type="reset" class="form_button" value="Nuevo"
							onclick="newComment()" />
					</form>
				</div>
				<?php

				?>
				<div id="comment_form_box">

					<p>
						Para mandar a revisar la practica oprima el boton Revisar.
					</p>
					<form id="revisar_form" name="revisar_form" method="post"
						action="../../utilities/updatepracticesrev.mod.php" enctype="multipart/form-data">


						<input id="rid" name="rid" type="hidden" value="<?php echo $rid; ?>">

						<input id="page" name="page" type="hidden"
							value="../user/details.php?res=<?php echo $res; ?>&rid=<?php echo $rid; ?>">

						<input id="comsend" name="comsend" type="button" class="form_button" value="Revisar"
							onclick="revisar()" />

					</form>
				</div>
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