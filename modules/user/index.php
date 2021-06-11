<?php
	include('../../inc/useful.fns.php');
	include('../../inc/user.class.php');
	
	require_once('../../libraries/Mobile_Detect.php');

	$detect = new Mobile_Detect;
	
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
		
	if($level == 1){
		$usrHTML = "<li><a href=\"../admin/index.php\" class=\"ast3\">Administrar</a></li>";
		header('Location: ../admin/index.php');
	}
		

	else if($level == 2)
		$usrHTML = "<li>Operar</li>";
	else if($level == 3){
		$usrHTML = "";
	}
	//if($domain == 'db' && $level!=1) {
		//$usrHTML .= "<li><a href=\"users.php\" class=\"ast3\" title=\"Editar\">Editar Usuario</a></li>";
	//}//end if
		
?>

<?php if ($level == 2) {  ?>





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
		<div class="overlay"></div>

		<?php require_once('../../structure/sidebar_profesor.php') ?>

		<div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>

			<?php require_once('../../structure/navbar_admin.php') ?>

			<div class="container-fluid p-0 px-lg-0 px-md-0">
				<div class="container-fluid px-lg-4 content_g ">
					<div class="row">
						<div id="content3" class="col-md-12 mt-lg-4 mt-4">

							<div id="content_r">



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
												<img class="img-fluid rounded mx-auto " width=100 height=100 alt="" hspace=1
													vspace=1 src="../../img/uclv_logo.jpg">
												<img class="img-fluid rounded mx-auto " width=100 height=100 alt="" hspace=1
													vspace=1 src="../../img/upm_logo.jpg">
												<img class="img-fluid rounded mx-auto " width=100 height=100 alt="" hspace=1
													vspace=1 src="../../img/ubb_logo.jpg">
											</p>
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
		<div class="overlay"></div>

		<?php require_once('../../structure/sidebar_estudiante.php') ?>

		<div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>

			<?php require_once('../../structure/navbar_admin.php') ?>

			<div class="container-fluid p-0 px-lg-0 px-md-0">
				<div class="container-fluid px-lg-4 content_g ">
					<div class="row">
						<div id="content3" class="col-md-12 mt-lg-4 mt-4">

							<div id="content_r">



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
												<img class="img-fluid rounded mx-auto " width=100 height=100 alt="" hspace=1
													vspace=1 src="../../img/uclv_logo.jpg">
												<img class="img-fluid rounded mx-auto " width=100 height=100 alt="" hspace=1
													vspace=1 src="../../img/upm_logo.jpg">
												<img class="img-fluid rounded mx-auto " width=100 height=100 alt="" hspace=1
													vspace=1 src="../../img/ubb_logo.jpg">
											</p>
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







