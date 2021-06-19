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

									<h1 class="content_r_hst1">Control PD desacoplado de manipuladores</h1>
									<div class="contentp">

										<p>El control desacoplado de manipuladores se basa en la suposici&oacute;n de
											que no haya acoplamiento mec&aacute;nico entre los eslabones del
											manipulador, es decir, se analiza cada articulaci&oacute;n por separado y se
											ajustan los reguladores para cada actuador existente en el sistema
											(normalmente el mismo numero que el n&uacute;mero de grados de libertad del
											manipulador). Cada actuador de ve afectado por un torque de disturbio, que
											no es otra cosa mas que el torque generado por la articulaci&oacute;n
											acoplada al actuador en movimiento, y se calcula a trav&eacute;s de la
											soluci&oacute;n del problema din&aacute;mico inverso (ver <a href="#"
												class="ast1">Modelado din&aacute;mico de manipuladores</a>).</p>
										<p>El control PD (Proporcional-Derivativo) desacoplado es el esquema de control
											m&aacute;s simple y es adecuado para aplicaciones que no requieran
											movimientos muy r&aacute;pidos, especialmente en manipuladores que tengan
											una tasa de reducci&oacute;n grande entre los actuadores y las
											articulaciones. El diagrama de bloques en lazo cerrado de este esquema es
											presentado en la figura 1.</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/pddesac1.gif" />
										<p style="text-align:center;">Fig. 1. Esquema de lazo cerrado con control PD.
										</p>
										<p>donde:</p>
										<div class="content_simbo_p">
											<div class="content_simbo_pddesac1">
												<table width="100%" cellpadding="0" cellspacing="0" class="data">
													<tr>
														<td width="40">qm<sup>d</sup></td>
														<td width="320">&Aacute;ngulo deseado en el eje del motor
															(Grados o radianes).</td>
													</tr>
													<tr>
														<td>qm</td>
														<td>&Aacute;ngulo real en el eje del motor (Grados o radianes).
														</td>
													</tr>
													<tr>
														<td>K</td>
														<td>Ganancia del motor (Adimensional).</td>
													</tr>
													<tr>
														<td>J<sub>eff</sub></td>
														<td>Momento de inercia del eje del motor y la carga
															(Kgm<sup>2</sup>).</td>
													</tr>
													<tr>
														<td>B<sub>eff</sub></td>
														<td>Coeficiente de fricci&oacute;n del rotor (Nm).</td>
													</tr>
													<tr>
														<td>Kp</td>
														<td>Ganancia proporcional del controlador (Adimensional).</td>
													</tr>
													<tr>
														<td>Kd</td>
														<td>Ganancia derivativa del controlador (Adimensional).</td>
													</tr>
													<tr>
														<td>n</td>
														<td>Relaci&oacute;n de reducci&oacute;n de los engranes</td>
													</tr>
													<tr>
														<td>V(s)</td>
														<td>Voltaje aplicado al motor (Acci&oacute;n de control).</td>
													</tr>
													<tr>
														<td>t</td>
														<td>Torque de disturbio (N.m)</td>
													</tr>
												</table>
											</div>
										</div>
									</div>



									<h1 class="content_r_hst2">An&aacute;lisis de estabilidad</h1>

									<div class="contentp">


										<p>El sistema que nos representa la posici&oacute;n del eje del motor en
											funci&oacute;n del voltaje aplicado, es una ecuaci&oacute;n diferencial
											lineal invariante con el tiempo (ver <a href="#" class="ast1">Modelado de
												actuadores</a>) que esta representada por:</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/pddesac2.gif" />
										<p>Del diagrama de la figura 1 podemos ver que la acci&oacute;n de control V(s)
											esta dada por la ecuaci&oacute;n:</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/pddesac3.gif" />
										<p>Tomando la transformada de Laplace a ambos miembros de la ecuaci&oacute;n (1)
											y sustituyendo la ecuaci&oacute;n (2) en (1) tenemos que:</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/pddesac4.gif" />
										<p>donde:</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/pddesac5.gif" />
										<p>es el polinomio caracter&iacute;stico en lazo cerrado del sistema.</p>
										<p>Si aplicamos el criterio de estabilidad de Routh-Hurwitz al polinomio
											caracter&iacute;stico, tenemos el siguiente arreglo de Routh-Hurwitz:</p>
										<div class="content_simbo_p">

											<div class="content_simbo_pddesac2">
												<table width="100%" cellpadding="0" cellspacing="0" class="data">
													<tr>
														<td width="30">S<sup>2</sup></td>
														<td width="80">J<sub>eff</sub></td>
														<td width="80">KKp</td>
													</tr>
													<tr>
														<td>S<sup>1</sup></td>
														<td>(B<sub>eff</sub>+KKd)</td>
														<td>0</td>
													</tr>
													<tr>
														<td>S<sup>0</sup></td>
														<td>KKp</td>
														<td>&nbsp;</td>
													</tr>
												</table>
											</div>

										</div>
										<p>En el cual se ve que el sistema en lazo cerrado ser&aacute; estable para
											todos los valores positivos de Kp y Kd siempre y cuando los disturbios sean
											acotados.</p>
									</div>

									<h1 class="content_r_hst2">An&aacute;lisis del error en estado estable</h1>


									<div class="contentp">
										<p>El error de seguimiento esta dado por la siguiente ecuaci&oacute;n:</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/pddesac6.gif" />
										<p>Para una entrada de referencia paso y un disturbio constante:</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/pddesac7.gif" />
										<p>Podemos concluir ayud&aacute;ndonos del teorema del valor final que el error
											en estado estable para el sistema con control PD acoplado esta dado por:</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/pddesac8.gif" />
										<p>Se puede ver f&aacute;cilmente que el error en estado estable ser&aacute;
											peque&ntilde;o para un disturbio constante, si la tasa de reducci&oacute;n
											de engranes es grande, y que adem&aacute;s se puede hacer el error
											peque&ntilde;o, definiendo una ganancia proporcional (Kp) grande.</p>
										<h1 class="content_r_hst2">Sintonizado del regulador PD</h1>
									</div>



									<div class="contentp">
										<p>El sistema con controlador PD en lazo cerrado, es un sistema de segundo
											orden, por lo que la respuesta ante entradas de tipo paso, es determinada
											por la frecuencia natural wn y el factor de amortiguamiento relativo del
											sistema z.</p>
										<p>Normalmente en rob&oacute;tica se utiliza un factor de amortiguamiento z=1
											para tener un sistema cr&iacute;ticamente amortiguado, por lo que la
											frecuencia natural no amortiguada wn determina la velocidad de la respuesta.
										</p>
										<p>Una vez determinadas estas dos magnitudes para una respuesta deseada, las
											ganancias Kp y Kd pueden ser evaluadas a trav&eacute;s del polinomio
											caracter&iacute;stico del sistema de la siguiente manera:</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/pddesac9.gif" />
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/pddesac10.gif" />
									</div>



									<h1 class="content_r_hst2">Bibliograf&iacute;a</h1>

									<div class="contentp">
										<p>[1] B. C. Kuo, Automatic Control Systems.</p>
										<p>[2] K. Ogata, Modern Control Engineering.</p>
										<p>[3] M. W. Spong, Robot Dynamics and Control.</p>
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