<?php
include('../../../inc/useful.fns.php');
include('../../../inc/user.class.php');

require_once('../../../libraries/Mobile_Detect.php');

$detect = new Mobile_Detect;

session_start();

$session = $_SESSION['user'];

if (empty($session)) {
	header('Location: ../../../index.php');
} //end if

$user = unserialize($session);
$uid = $user->getUID();
$name = $user->getName();
$login = $user->getLogin();
$mail = $user->getEMail();
$domain = $user->getDomain();
$level = $user->getPriority();
$_SESSION['user'] = serialize($user);

if ($level == 1)
	$usrHTML = "<li><a href=\"../../admin/index.php\" class=\"ast3\">Administrar</a></li>";
else if ($level == 2)
	$usrHTML = "<li>Operar</li>";
else if ($level == 3) {
	$usrHTML = "";
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php require_once('../css/libcss.php'); ?>
	<link rel="stylesheet" href="../css/index.css">
	<link rel="stylesheet" href="../../theory/css/theory.css">

</head>

<body>
	<div id="wrapper">


		<nav class="fixed-top align-top<?php if (!$detect->isMobile()) echo ' toggled' ?>" id="sidebar-wrapper"
			role="navigation">
			<div class="simplebar-content" style="padding: 0px;">

				<!-- Logo -->
				<div class="navbar-nav ps-4 pt-2">
					<a class="navbar-brand" href="index.php">
						<span class="fs-4 fw-bolder" style="color: orange;">SLD</span>
						<span class="fs-4 fw-bolder" style="color: white;">WEB</span>
					</a>
				</div>

				<ul class="navbar-nav align-self-stretch">

					<li class="">
						<a href="/modules/admin/index.php" class="nav-link text-left nosub" role="button">
							<i class="fas fa-circle"></i>
							Inicio
						</a>
					</li>

					<li class="has-sub">
						<a class="nav-link collapsed text-left nosub" href="#" role="button" data-toggle="collapse"
							data-target="#sech">
							<i class="fas fa-calendar"></i> Horarios
						</a>
						<div class="collapse menu mega-dropdown" id="sech">
							<div class="dropmenu" aria-labelledby="navbarDropdown">
								<div class="container-fluid ">
									<div class="row">
										<div class="col-lg-12 px-2">
											<div class="submenu-box">
												<ul class="list-unstyled m-0">
													<li><a href="/modules/admin/notavaible.php">Horarios reservados</a></li>
													<li><a href="/modules/admin/notavaible.php"> Solicitud de horarios</a></li>
												</ul>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</li>

					<li class="has-sub">
						<a class="nav-link collapsed text-left nosub" href="#collapseExample2" role="button"
							data-toggle="collapse" data-target="#secp">
							<i class="fas fa-screwdriver"></i> Mis prácticas
						</a>
						<div class="collapse menu mega-dropdown" id="secp">
							<div class="dropmenu" aria-labelledby="navbarDropdown">
								<div class="container-fluid ">
									<div class="row">
										<div class="col-lg-12 px-2">
											<div class="submenu-box">
												<ul class="list-unstyled m-0">
													<li><a href="/modules/admin/configp.php"> Administrar prácticas</a>
													</li>
													<li><a href="/modules/admin/index.php?body=realizadas"> Historial de
															prácticas</a></li>
												</ul>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</li>

					<li class="has-sub">
						<a class="nav-link collapsed text-left nosub" href="#collapseExample2" role="button"
							data-toggle="collapse" data-target="#secu">
							<i class="fas fa-users"></i> Usuarios
						</a>
						<div class="collapse menu mega-dropdown" id="secu">
							<div class="dropmenu" aria-labelledby="navbarDropdown">
								<div class="container-fluid ">
									<div class="row">
										<div class="col-lg-12 px-2">
											<div class="submenu-box">
												<ul class="list-unstyled m-0">
													<li><a href="/modules/admin/users.php?body=profiles">Administrar
															usuarios</a></li>
													<li><a href="/modules/admin/users.php?body=users">Usuarios
															privilegiados</a></li>
												</ul>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</li>

					<li class="has-sub">
						<a class="nav-link collapsed text-left nosub" href="#collapseExample2" role="button"
							data-toggle="collapse" data-target="#secas">
							<i class="fas fa-book-open"></i> Asignaturas
						</a>
						<div class="collapse menu mega-dropdown" id="secas">
							<div class="dropmenu" aria-labelledby="navbarDropdown">
								<div class="container-fluid ">
									<div class="row">
										<div class="col-lg-12 px-2">
											<div class="submenu-box">
												<ul class="list-unstyled m-0">
													<li><a href="/modules/admin/notavaible.php">Ver asignaturas</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>

					<li class="">
						<a href="/modules/admin/theory.php" class="nav-link text-left nosub" role="button">
							<i class="fas fa-journal-whills"></i>
							Teoría
						</a>
					</li>

					<li class="">
						<a href="/modules/admin/platform.php" class="nav-link text-left nosub" role="button">
							<i class="far fa-stop-circle"></i>
							Plataforma
						</a>
					</li>

					<li class="has-sub">
						<a class="nav-link collapsed text-left nosub" role="button" data-toggle="collapse"
							data-target="#sece">
							<i class="fas fa-users"></i> Estadísticas
						</a>
						<div class="collapse menu mega-dropdown" id="sece">
							<div class="dropmenu" aria-labelledby="navbarDropdown">
								<div class="container-fluid ">
									<div class="row">
										<div class="col-lg-12 px-2">
											<div class="submenu-box">
												<ul class="list-unstyled m-0">
													<li><a href="/modules/admin/notavaible.php">Estadísticas generales</a></li>
													<li><a href="/modules/admin/notavaible.php">Gráficos estadísticos</a></li>
												</ul>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</li>

					<li class="">
						<a href="../../../general/logout.php" style="text-decoration:none;">
							<div class="btnLogout">
								<span class="mr-2 small">Cerrar sesión</span>
							</div>
						</a>
					</li>
				</ul>
			</div>
		</nav>

		<!-- Page Content -->
		<div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>
			<!-- Topbar -->

			<nav class="navbar navbar-expand navbar-light my-navbar d-flex justify-content-between">

				<!-- Sidebar Toggle (Topbar) -->
				<div type="button" id="bar"
					class="nav-icon1 hamburger animated fadeInLeft is-closed<?php if (!$detect->isMobile()) echo ' open' ?>"
					data-toggle="offcanvas">
					<span></span>
					<span></span>
					<span></span>
				</div>

				<!-- Date -->
				<div class="navbar-nav ml-auto">
					<li class="nav-item">
						<span class="nav-link">
							<span class="mr-2 d-none d-md-block small"><?php echo Date_Time(); ?></span>
						</span>
					</li>
				</div>

				<!-- User name -->
				<ul class="navbar-nav ml-auto">
					<li class="nav-item dropdown">
						<a class="nav-link">
							<div class="btnLog">
								<span style="color:black;"
									class="mr-2 d-lg-inline small"><b><?php echo $name; ?></b></span>
							</div>
						</a>
					</li>
				</ul>
			</nav>
			<div id="content">

				<div id="content2" class="container-fluid p-0 px-lg-0 px-md-0">

					<!-- End of Topbar -->

					<!-- Begin Page Content -->
					<div class="container-fluid px-lg-4 content_g ">
						<div class="row">
							<div id="content3" class="col-md-12 mt-lg-4 mt-4">

								<div class="content_theory">
									<div class="contentp">
										<h1 class="content_r_hst1">Identificaci&oacute;n de sistemas por modelo PORT
										</h1>
										<p>Muchos sistemas f&iacute;sicos pueden modelarse como un sistema de primer
											orden
											con retardo de tiempo (PORT), de forma que su funci&oacute;n transferencial
											queda:</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/port1.png" />
										<p>Si el sistema se somete a una entrada paso, la respuesta en funci&oacute;n
											del
											tiempo ser&iacute;a:</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/port2.png" />
										<p>La ganancia del sistema puede calcularse como la variaci&oacute;n total en la
											salida entre la variaci&oacute;n total a la entrada:</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/port3.png" />
										<p>Luego, dos puntos t&iacute;picos de la respuesta temporal son:</p>
										<p> - El tiempo que tarda en alcanzar el 28% del valor final. Esto ocurre en t =
											L+&tau;/3 dado que (1-e^-1/3) = 0.28, entonces se tiene una primera
											ecuaci&oacute;n: t28 = L + &tau;/3</p>
										<p> - El tiempo que tarda en alcanzar el 63% del valor final. Esto ocurre en t =
											L+&tau; dado que (1-e^-1) = 0.63, entonces se tiene una segunda
											ecuaci&oacute;n:
											t63 = L + &tau;</p>
										<p>Midiendo t28 y t63 se puede obtener L y &tau; despejando de las dos
											ecuaciones
											anteriores obteni&eacute;ndose:</p>
										<p> &tau; = (t63-t28)*3/2 </p>
										<p> L = t63 &tau; </p>
									</div>


								</div>


							</div>

						</div>

					</div>
					<!-- /.container-fluid -->

				</div>



			</div>

		</div>
		<!-- /#page-content-wrapper -->

	</div>
</body>

<?php require_once('../js/libjs.php'); ?>
<script src="../js/index.js"></script>

</html>