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
	$body = '';
	$order = '';
	$show = '';
	$page = '';
	$type = '';
	$alert = '';
	$res = '';


	
	$method = $_SERVER['REQUEST_METHOD'];
	$body = isset($_GET['body']);
	$id = isset($_GET['id']);
	if(isset($_GET['body'])) { $body = $_GET['body']; }
	if(isset($_GET['order'])) { $order = $_GET['order']; }
	if(isset($_GET['show'])) { $show = $_GET['show']; }
	if(isset($_GET['page'])) { $page = $_GET['page']; }
	if(isset($_GET['type'])) { $type = $_GET['type']; }
	if(isset($_GET['alert'])) { $alert = $_GET['alert']; }
	if(isset($_GET['res'])) { $res = $_GET['res']; }

	if($level == 1)
		$usrHTML = "<li><a href=\"../admin/index.php\" class=\"ast3\">Administrar</a></li>";
	else if($level == 2)
		$usrHTML = "<li>Operar</li>";
		else if($level == 3){
			$usrHTML = "";
		}
	//if($domain == 'db' && $level!=1) {
	//	$usrHTML .= "<li><a href=\"users.php\" class=\"ast3\" title=\"Editar\">Editar Usuario</a></li>";
	//}//end if
	
	if(!$body)
		$body = "mypractices";
	
	if($page==0 || $page==1)
		$page=1;
	
	if(!$show)
		$show = 20;
		
	if(!$order)
		$order = 'id';
	
	$btxt = "Pr&aacute;cticas Realizadas";
	
	switch($body) {
		case "mprevisadas":
			$status = "recurso";
			$btxt = "Pr&aacute;cticas Revisadas";
			$txtlog = "?body=mypractices";
			break;
		case "mprevisar":
			$status = "sugerencia";
			$btxt = "Pr&aacute;cticas por Revisar";
			$txtlog = "?body=mprevisar";
			break;
	}//end switch
	
	
	include('../../utilities/mypractices.mod.php');	
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

							<div id="content_r" style="width:700px;">





							<?php  if(!$res) {?><h1 class="content_r_hst1"><?php echo $btxt; ?></h1><?php } ?>

							
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

							<div id="content_r" style="width:700px;">





							<?php  if(!$res) {?><h1 class="content_r_hst1"><?php echo $btxt; ?></h1><?php } ?>

							
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

<?php require_once('../../modules/admin/js/libjs.php') ?>
<script src="../../modules/admin/js/index.js"></script>

</html>









<?php }  ?>







