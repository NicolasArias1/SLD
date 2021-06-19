<?php
	include('../../../inc/useful.fns.php');
	include('../../../inc/user.class.php');
	require_once('../../../libraries/Mobile_Detect.php');

$detect = new Mobile_Detect;

	session_start();
	
	$session = $_SESSION['user'];

	if(empty($session)) {
		header('Location: ../../../index.php');
	}//end if
	
	$user = unserialize($session);
	$uid = $user->getUID();
	$name = $user->getName();
	$login = $user->getLogin();
	$mail = $user->getEMail();
	$domain = $user->getDomain();
	$level = $user->getPriority();
	$_SESSION['user'] = serialize($user);
	
	if($level == 1)
		$usrHTML = "<li><a href=\"../../admin/index.php\" class=\"ast3\">Administrar</a></li>";
	else if($level == 2)
		$usrHTML = "<li>Operar</li>";
		else if($level == 3){
			$usrHTML = "";
		}
?>



<?php  if($level == 2){  ?>



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
                    <a class="navbar-brand" href="../index.php">
                        <span class="fs-4 fw-bolder" style="color: orange;">SLD</span>
                        <span class="fs-4 fw-bolder" style="color: white;">WEB</span>
                    </a>
                </div>

                <ul class="navbar-nav align-self-stretch">

                    <li class="">
                        <a href="../index.php" class="nav-link text-left nosub" role="button">
                            <i class="fas fa-circle"></i>
                            Inicio
                        </a>
                    </li>

                    <li class="has-sub">
                        <a class="nav-link collapsed text-left nosub" href="#collapseExample2" role="button"
                            data-toggle="collapse" data-target="#secp">
                            <i class="fas fa-calendar"></i>Horarios
                        </a>
                        <div class="collapse menu mega-dropdown" id="secp">
                            <div class="dropmenu" aria-labelledby="navbarDropdown">
                                <div class="container-fluid ">
                                    <div class="row">
                                        <div class="col-lg-12 px-2">
                                            <div class="submenu-box">
                                                <ul class="list-unstyled m-0">
                                                    <li><a href="/modules/user/notavaible.php"> Horarios reservados</a></li>
                                                    <li><a href="/modules/user/notavaible.php"> Mis solicitudes</a></li>
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
                            data-toggle="collapse" data-target="#secasig">
                            <i class="fas fa-screwdriver"></i>Mis asignaturas
                        </a>
                        <div class="collapse menu mega-dropdown" id="secasig">
                            <div class="dropmenu" aria-labelledby="navbarDropdown">
                                <div class="container-fluid ">
                                    <div class="row">
                                        <div class="col-lg-12 px-2">
                                            <div class="submenu-box">
                                                <ul class="list-unstyled m-0">
                                                    <li><a href="/modules/user/notavaible.php"> Gestionar asignaturas </a></li>
                                                    <li><a href="/modules/user/notavaible.php"> Historial de prácticas </a></li>
                                                    <li><a href="/modules/user/mypractices.php"> Prácticas disponibles </a></li>
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
                            data-toggle="collapse" data-target="#secEst">
                            <i class="fas fa-chart-area"></i>Estadísticas
                        </a>
                        <div class="collapse menu mega-dropdown" id="secEst">
                            <div class="dropmenu" aria-labelledby="navbarDropdown">
                                <div class="container-fluid ">
                                    <div class="row">
                                        <div class="col-lg-12 px-2">
                                            <div class="submenu-box">
                                                <ul class="list-unstyled m-0">
                                                    <li><a href="/modules/user/notavaible.php"> Estadísticas resumidas </a></li>
                                                    <li><a href="/modules/user/notavaible.php"> Gráficos estadísticos </a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="">
                        <a href="/modules/user/theory.php" class="nav-link text-left nosub" role="button">
                            <i class="fas fa-journal-whills"></i>
                            Teoría
                        </a>
                    </li>

                    <li class="">
                        <a href="/modules/user/platform.php" class="nav-link text-left nosub" role="button">
                            <i class="far fa-stop-circle"></i>
                            Plataforma
                        </a>
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

										<h1 class="content_r_hst1">Implementaci&oacute;n de controlador digital</h1>
										<h2 class="content_r_hst2">1.1 Controlador PID en Tiempo Continuo.</h2>
										<p>El control de sistemas f&iacute;sicos, qu&iacute;micos, el&eacute;ctricos y
											electr&oacute;nicos es muy importante en la industria, la medicina,
											transporte, comunicaci&oacute;n, donde cada vez el control digital va
											tomando m&aacute;s &eacute;nfasis.</p>
										<p> Herramientas computacionales como Matlab, Matlab Simulink y Octave permiten
											el an&aacute;lisis de los sistemas antes descritos, y hacen de la
											sintonizaci&oacute;n mucho m&aacute;s c&oacute;moda.</p>
										<p>Un controlador PID descrito en tiempo continuo y en funci&oacute;n de las
											ganancias de la acci&oacute;n proporcional, integral y derivativa de la
											forma <b>(1)</b> </p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn1.png" /></p>
										<p>de la misma forma, pero ahora en funci&oacute;n de las constantes de tiempo
											integrativa y derivativa <b>(2)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn2.png" /></p>
										<p>El control PID se caracteriza por su robustez y simplicidad en dise&ntilde;o,
											haciendo el control de sistemas lineales una tarea f&aacute;cil.</p>
										<p>Una de las formas m&aacute;s pr&aacute;cticas para la representaci&oacute;n
											del controlados est&aacute; dada por la relaci&oacute;n entrada salida del
											mismo, representada por su funci&oacute;n de transferencia en el dominio de
											Laplace. <b>(3)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn3.png" /></p>
										<p>Esta ultima es muy utilizada en el an&aacute;lisis del comportamiento de la
											respuesta en lazo cerrado.</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Fig.1.png" />
										<p style="text-align:center;">Fig.1. Diagrama en bloque de lazo de control
											realimentados (feedback)</p>
										<h2 class="content_r_hst2">1.2 M&eacute;todos de Sintonizaci&oacute;n.</h2>
										<h3 class="content_r_hst3">1.2.1 M&eacute;todo de Ziegler-Nichols.</h3>
										<p>Este es uno de los m&eacute;todos m&aacute;s conocidos para la
											sintonizaci&oacute;n de controladores de lazo cerrado como PID, Consiste en
											llevar al sistema, en lazo cerrado, a r&eacute;gimen oscilatorio aumentando
											la ganancia, a esta ganancia se le conoce como ganancia cr&iacute;tica (Ku)
											y es luego utilizada para obtener los par&aacute;metros del control desde la
											tabla que los relaciona. Adem&aacute;s, de este r&eacute;gimen se obtiene el
											periodo de oscilaci&oacute;n cr&iacute;tica (Tu) que, al igual que la
											ganancia cr&iacute;tica, es utilizado en la sintonizaci&oacute;n. </p>
										<p>El m&eacute;todo de la ganancia critica tiene como resultado una respuesta
											con un cuarto de raz&oacute;n de crecimiento.</p>
										<p>A modo de ejemplo se muestra la sintonizaci&oacute;n de una planta
											H<sub>p</sub>(s) por el m&eacute;todo de Ziegler-Nichols.</p>
										<p>Ejemplo 1: Se propone hacer control sobre la planta que se muestra a
											continuaci&oacute;n haciendo uso de Matlab y del m&eacute;todo antes
											se&ntilde;alado.</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Eg1.png" />
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Cod1.png" />
										<p>Tab.1. Parametros de control Ziegler-Nichols, ganancia cr&iacute;tica y
											Periodo cr&iacute;tico</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Tab.1.png" />
										<p>A continuaci&oacute;n, se muestran los resultados del c&oacute;digo anterior:
										</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Fig.2.png" />
										<p>Fig.2. Respuestas del Sistema Hp(s), a) Sistema en R&eacute;gimen
											Oscilatorio, llevado con ganancia critica Ku. b) Respuesta al escal&oacute;n
											del sistema Hp en lazo abierto.</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Fig.3.png" />
										<p style="text-align:center;">Fig.3. Respuesta ante referencia paso, sistema
											lazo cerrado sintonizado con
											Ziegler-Nichols.</p>
										<p>Se observa en la comparaci&oacute;n de las respuestas en lazo cerrado y lazo
											abierto que la respuesta mejora mucho en t&eacute;rminos de velocidad, y que
											es justamente lo que se espera con un control PID, pero, cabe se&ntilde;alar
											que cae su ganancia est&aacute;tica</p>
										<h3 class="content_r_hst3">1.2.2 Asignaci&oacute;n de Polos.</h3>
										<p>Hay plantas que, por el comportamiento de sus ra&iacute;ces, no es posible
											llevar a oscilaci&oacute;n, un ejemplo de esto son las plantas de primer
											orden, que son descritas por el modelo PORT como: <b>(4)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn4.png" /></p>
										<p>Por simplicidad para el an&aacute;lisis consideraremos e<sup>-Ls</sup>
											unitario, lo que significa que no habr&aacute; retardo de tiempo, si
											observamos su LGR y su margen de ganancia, se observa que no es posible
											llevar a oscilaci&oacute;n. Es ah&iacute; donde aparecen otros
											m&eacute;todos de control c&oacute;mo lo es asignaci&oacute;n de polos. </p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Fig.4.png" />
										<p style="text-align:center;">Fig.4. Lugar geom&eacute;trico de las
											ra&iacute;ces, planta de primer orden.
										</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Fig.5.png" />
										<p style="text-align:center;">Fig.5. Margen de ganancia y fase, sistema de
											primer orden.</p>
										<p>El m&eacute;todo en cuesti&oacute;n trata de ubicar los polos del lazo
											cerrado de tal manera que se pueda obtener una respuesta deseada.</p>
										<p>Se busca que el polinomio caracter&iacute;stico de la funci&oacute;n de
											transferencia del lazo que se muestra a continuaci&oacute;n se comporte como
											una respuesta t&iacute;pica de segundo orden
											P(s)=s<sup>2</sup>+2&xi;&omega;<sub>n</sub>+&omega;<sub>n</sub><sup>2</sup>.
										</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Fig.6.png" />
										<p style="text-align:center;">Fig.6. Diagrama en bloques del lazo de control PI
											para una planta de primer
											orden.</p>
										<p>As&iacute; la F. de T. del lazo ser&aacute;: <b>(5)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn5.png" /></p>
										<p>De ella despejando su polinomio caracter&iacute;stico se tiene que <b>(6)</b>
										</p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn6.png" /></p>
										<p>Luego igualando los coeficientes del polinomio caracter&iacute;stico del lazo
											cerrado con el que se busca tener se tiene que: <b>(7)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn7.png" /></p>
										<p>y <b>(8)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn8.png" /></p>
										<p>As&iacute; es posible determinar los coeficientes del control en
											funci&oacute;n de la frecuencia angular del lazo y su factor de
											amortiguamiento, obteniendo una respuesta deseada.</p>
										<p>Despejando se tiene que los par&aacute;metros del control son <b>(9)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn9.png" /></p>
										<p>y <b>(10)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn10.png" /></p>
										<p> Con: </p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/wn.png" /></p>
										<p>donde T<sub>ss</sub> es el tiempo de asentamiento de la respuesta, este se
											encuentra buscando evitar la saturaci&oacute;n del actuador de control.
											<p>Ejemplo 2: Se propone hacer control sobre la planta que se muestra a
												continuaci&oacute;n haciendo uso de Matlab y del m&eacute;todo antes
												se&ntilde;alado.</p>
											<img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eg2.png" />
											<img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Cod2.png" />
											<p>A partir del c&oacute;digo anterior se obtiene la respuesta del lazo
												cerrado ante un cambio tipo paso en la referencia, se busca que dicha
												respuesta tenga un sobrepaso de un 4%, y un tiempo de asentamiento de 1
												[s], esto junto a las igualdades que relacionan los par&aacute;metros
												del control con los par&aacute;metros de la planta, se obtiene la
												siguiente respuesta.</p>
											<img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Fig.7.png" />
											<p style="text-align:center;">Fig.7. Respuesta ante un paso de referencia
												del sistema en lazo cerrado.
											</p>
											<p>Como se puede observar en la Fig.7, la respuesta tiene un sobrepaso
												superior al 4%, esto se debe a que el control PI, pone un cero en el LGR
												el cual cambia la din&aacute;mica del sistema, esta repuesta puede
												mejorarse aplicando un filtro de cancelaci&oacute;n del cero del control
												en la referenciad de la forma siguiente.</p>
											<img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Fig.8.png" />
											<p style="text-align:center;">Fig.8. Diagrama en bloque del lazo de control
												con filtro de
												cancelaci&oacute;n de zero.</p>
											<p>Con esta implementaci&oacute;n se mejora la respuesta obteniendo el
												sobrepaso para el cual se ha dise&ntilde;ado en controlador.</p>
											<img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Fig.9.png" />
											<p style="text-align:center;">Fig.9. :"Comparaci&oacute;n de las respuestas
												con filtro de
												cancelaci&oacute;n de cero y sin filtro de cancelaci&oacute;n de cero.
											</p>
											<p>C&oacute;mo se puede observar en la Fig.9, la respuesta se hace
												m&aacute;s lenta por la ausencia del cero puesto por el controlador,
												pero a la vez se obtiene una respuesta dada por el factor de
												amortiguamiento seg&uacute;n dise&ntilde;o.</p>
											<h2 class="content_r_hst2">1.3 Modificaciones del Control PID.</h2>
											<h3 class="content_r_hst3">1.3.1 Anti-Windup.</h3>
											<img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Fig.10.png" />
											<p style="text-align:center;">Fig.10. Diagrama de simulaci&oacute;n del lazo
												cerrado con control PID
												modificado con Anti-windup.</p>
											<p>Con el objetivo de evitar la saturaci&oacute;n del actuador de control,
												se dise&ntilde;a el controlador PID con una modificaci&oacute;n, esta es
												conocida como Anti-windup, en la Ilustraci&oacute;n 10 se muestra su
												diagrama de simulaci&oacute;n para la implementaci&oacute;n del mismo en
												Matlab Simulink, esta modificaci&oacute;n lo que busca es saturar la
												se&ntilde;al de control cuando se produce un sobrepaso en la
												se&ntilde;al de mando, esto se consigue apagando la parte integrativa y
												as&iacute; evitar la sobre-integraci&oacute;n del erro y sacando en el
												mando el valor m&aacute;ximo de salida del mismo. En el c&oacute;digo
												para Matlab que se muestra a continuaci&oacute;n se observa c&oacute;mo
												se implementa el anti-windup, se satura la se&ntilde;al de mando para el
												actuador y se “apaga” la parte integrativa haciendo sw=0, donde sw se
												encuentra multiplicando a la parte integrativa en el c&oacute;digo que
												describe los par&aacute;metros del controlador.</p>
											<img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Cod3.png" />
											<p>Cabe destacar que esta modificaci&oacute;n saca al sistema de su zona
												lineal por lo que es preferible evitar la saturaci&oacute;n del mando
												cambiando el tiempo de asentamiento con el que se dise&ntilde;a el
												controlador, pero en el caso de que sea posible aplicarlo es conveniente
												para evitar la sobre-integraci&oacute;n del error y proteger al actuador
												de se&ntilde;ales muy altas de tensi&oacute;n.</p>
											<h3 class="content_r_hst3">1.3.2 Filtro Derivada.</h3>
											<img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Fig.11.png" />
											<p style="text-align:center;">Fig.11. Diagrama de simulaci&oacute;n
												controlador PID modificado con
												filtro Derivada</p>
											<p>La presencia de ruido y pendientes fuertes en las mediciones producen un
												efecto indeseado en las acciones de control, ya que la acci&oacute;n
												derivativa amplifica este efecto (amplificando ruido), es por esta
												raz&oacute;n que la acci&oacute;n derivativa no puede y no
												deber&iacute;a ser implementada sin modificaciones. Es posible modificar
												la acci&oacute;n derivativa como se muestra en el diagrama de
												simulaci&oacute;n de la Ilustraci&oacute;n 11 con el objetivo de reducir
												el efecto de estas pendientes fuertes.</p>
											<p>Mirando esta modificaci&oacute;n como una funci&oacute;n de
												transferencia, haciendo <b>(11)</b></p>
											<p> <img class="img-fluid rounded mx-auto d-block mbotom"
													src="../../../img/Control/Eqn11.png" /></p>
											<p>donde se mueve t&iacute;picamente entre 3 y 20 buscando reducir lo
												m&aacute;s posible el efecto derivativo, la nueva funci&oacute;n de
												transferencia del controlador PID se encuentra simplemente reemplazando
												la aproximaci&oacute;n de la ecuaci&oacute;n (11) en (3), finalmente el
												control ser&aacute; <b>(12)</b>
												<p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn12.png" /></p>
													<h2 class="content_r_hst2" style="margin-bottom:30px;">1.4
														Discretizaci&oacute;n.</h2>
													<img class="img-fluid rounded mx-auto d-block mbotom"
														src="../../../img/Control/Fig.12.png" />
													<p style="text-align:center;">Fig.12. Lazo cerrado con control
														digital, retentor de orden cero
														y planta en tiempo continuo.</p>
													<p>El control digital toma cada vez m&aacute;s &eacute;nfasis, los
														controladores antes dise&ntilde;ados en el mundo
														anal&oacute;gico pueden ser llevados al mundo digital por medio
														de la discretizaci&oacute;n de los mismos, para esto se
														presentan tres tipos de aproximaciones con diferentes
														caracter&iacute;sticas que cumplen con este objetivo.</p>
													<img class="img-fluid rounded mx-auto d-block mbotom"
														src="../../../img/Control/Fig.13.png" />
													<p>Fig.13. Aproximaciones num&eacute;ricas de integraci&oacute;n. a)
														aproximaci&oacute;n rectangular hacia adelante. b)
														Aproximaci&oacute;n rectangular hacia atr&aacute;s. c)
														Aproximaci&oacute;n trapezoidal.</p>
													<p>En la Fig.13 se ven los diferentes tipos de aproximaciones de la
														integraci&oacute;n, donde T corresponde al intervalo de
														muestreo, e(k) corresponde al error en el instante de tiempo kT,
														e(k+1) corresponde al error en el instante de tiempo siguiente y
														e(k-1) es el error en el instante de tiempo anterior.</p>
													<h3 class="content_r_hst3">1.4.1 Aproximaci&oacute;n rectangular
														hacia adelante</h3>
													<p>A partir de la Fig.13.a) se tiene lo siguiente: <b>(13)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn13.png" /></p>
													<p>luego separando <b>(14)</b> </p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn14.png" /></p>
													<p>aplicando la transformada <b>(15)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn15.png" /></p>
													<p>Finalmente, la funci&oacute;n de transferencia en el dominio z de
														un integrador quedara c&oacute;mo <b>(16)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn16.png" /></p>
													<h3 class="content_r_hst3">1.4.2 Aproximaci&oacute;n rectangular
														hacia atr&aacute;s</h3>
													<p>A partir de la Fig.13.b) se tiene que <b>(17)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn17.png" /></p>
													<p>Luego separando <b>(18)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn18.png" /></p>
													<p>aplicando la transformada <b>(19)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn19.png" /></p>
													<p>Finalmente, la funci&oacute;n de transferencia en el dominio z de
														un integrador quedara c&oacute;mo <b>(20)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn20.png" /></p>
													<h3 class="content_r_hst3">1.4.3 Aproximaci&oacute;n rectangular
														hacia atr&aacute;s</h3>
													<p>A partir de la Fig.13.c) se tiene que <b>(21)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn21.png" /></p>
													<p>Luego separando <b>(22)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn22.png" /></p>
													<p>aplicando la transformada <b>(23)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn23.png" /></p>
													<p>Finalmente, la funci&oacute;n de transferencia en el dominio z de
														un integrador quedara c&oacute;mo <b>(24)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn24.png" /></p>
													<h3 class="content_r_hst3">1.4.4 Mapeo al plano-z.</h3>
													<p>Las aproximaciones antes mostradas llevan de forma diferente el
														semiplano izquierdo al c&iacute;rculo unitario del plano-z, esto
														se debe tanto a la cantidad de polos y ceros que tiene su
														funci&oacute;n de transferencia, adem&aacute;s la
														ubicaci&oacute;n de los mismos. En la Ilustraci&oacute;n 14 se
														muestra la correspondencia entre el plano-s y el plano-z.</p>
													<img class="img-fluid rounded mx-auto d-block mbotom"
														src="../../../img/Control/Fig.14.png" />
													<p>Fig.14. Mapeo del semi-plano del plano-s al plano-z mediante las
														aproximaciones de integrales. a) Aproximaci&oacute;n rectangular
														hacia adelante. b) Aproximaci&oacute;n rectangular hacia
														atr&aacute;s. c) Aproximaci&oacute;n trapezoidal.</p>
													<h3 class="content_r_hst3">1.4.5 Control PID Discreto.</h3>
													<p>El uso de las aproximaciones descritas anteriormente va de la
														mano con la estabilidad del control, ya que las diferentes
														aproximaciones suponen un posicionamiento de los polos y ceros
														mas cercanos a la estabilidad o no. Es por esto que se muestra
														la estabilidad de la funci&oacute;n de transferencia del PID en
														el Lugar Geom&eacute;trico de las Ra&iacute;ces (LGR) en las
														siguientes ilustraciones. </p>
													<img class="img-fluid rounded mx-auto d-block mbotom"
														src="../../../img/Control/Fig.15.png" />
													<p>Estabilidad del Control PID. a) aproximaci&oacute;n Forward para
														la acci&oacute;n integrativa y forward para la acci&oacute;n
														derivativa. b) aproximaci&oacute;n backward para la
														acci&oacute;n integrativa y backward para la acci&oacute;n
														derivativa .c) aproximaci&oacute;n Forward para la acci&oacute;n
														integrativa y backward para la acci&oacute;n derivativa. d)
														aproximaci&oacute;n backward para la acci&oacute;n integrativa y
														forward para la acci&oacute;n derivativa.</p>
													<p></p>
													<p>La parte proporcional es la m&aacute;s simple, reemplazando t =
														kT se encuentra: <b>(25)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn25.png" /></p>
													<p>Como se observa en la Fig.15 la estabilidad del controlador
														cambia con la aproximaci&oacute;n con la que sea discretizado,
														el uso de la aproximaci&oacute;n hacia atr&aacute;s para la
														parte derivativa tiene como ventaja la estabilidad de la misma,
														ya que uno de los polos se ubica en cero, mientras que la
														aproximaci&oacute;n hacia adelante saca a los polos del circulo
														unidad. <b>(26)</b> </p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn26.png" /></p>
													<p>despejando el presente de la derivaci&oacute;n: <b>(27)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn27.png" /></p>
													<p>En cuanto a la parte integrativa, esta no tiene mayores problemas
														de estabilidad, pero en la literatura se ve usualmente la
														integraci&oacute;n hacia adelante para la discretizaci&oacute;n
														de esta acci&oacute;n. <b>(28)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn28.png" /></p>
													<p>Se busca la ecuaci&oacute;n en tiempo discreto: <b>(29)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn29.png" /></p>
													<p>A continuaci&oacute;n, se muestra un c&oacute;digo de ejemplo de
														implementaci&oacute;n discreta del control PID antes
														discretizado.</p>
													<img class="img-fluid rounded mx-auto d-block mbotom"
														src="../../../img/Control/Cod4.png" />

													<h2 class="content_r_hst2">Referencias</h2>
													<p>[1] Katsuhiko Ogata, "Ingenier&iacute;a de control Moderna," 3a
														ed., Minnesota, Tom Robbins,1998, pp. 147-154.</p>
													<p>[2] Anibal Ollero Baturone, Control por computador
														descripci&oacute;n y dise&ntilde;o optimo, 1a ed., 1991, pp.12.
													</p>
													<p>[3] Alan V. Oppenheim & Ronald W. Schafer, 2T&eacute;cnicas de
														dise&ntilde;o de filtros," en Tratamiento de se&ntilde;ales en
														tiempo discreto. 3a ed., Pearson Educaci&oacute;n, 2011.</p>
													<p>[4] Mario E. Salgado, Juan I. Yuz, Ricardo A. Rojas,
														"An&aacute;lisis en tiempo discreto," en An&aacute;lisis de
														sistemas lineales. 1a ed., Pearson Educaci&oacute;n, 2005.</p>







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





<?php  }  ?>





<?php  if($level == 3){  ?>





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
					<a class="navbar-brand" href="../index.php">
						<span class="fs-4 fw-bolder" style="color: orange;">SLD</span>
						<span class="fs-4 fw-bolder" style="color: white;">WEB</span>
					</a>
				</div>

				<ul class="navbar-nav align-self-stretch">

					<li class="">
						<a href="/modules/user/index.php" class="nav-link text-left nosub" role="button">
							<i class="fas fa-circle"></i>
							Inicio
						</a>
					</li>

					<li class="has-sub">
						<a class="nav-link collapsed text-left nosub" href="#collapseExample2" role="button"
							data-toggle="collapse" data-target="#secp">
							<i class="fas fa-screwdriver"></i> Mis asignaturas
						</a>
						<div class="collapse menu mega-dropdown" id="secp">
							<div class="dropmenu" aria-labelledby="navbarDropdown">
								<div class="container-fluid ">
									<div class="row">
										<div class="col-lg-12 px-2">
											<div class="submenu-box">
												<ul class="list-unstyled m-0">
													<li><a href="../mypractices.php"> Prácticas disponibles</a></li>
													<li><a href="/modules/user/notavaible.php"> Historial de prácticas</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>

					<li class="">
						<a href="/modules/user/notavaible.php" class="nav-link text-left nosub" role="button">
							<i class="fas fa-calendar"></i>
							Horarios reservados
						</a>
					</li>

					<li class="">
						<a href="/modules/user/theory.php" class="nav-link text-left nosub" role="button">
							<i class="fas fa-journal-whills"></i>
							Teoría
						</a>
					</li>

					<li class="">
						<a href="/modules/user/platform.php" class="nav-link text-left nosub" role="button">
							<i class="far fa-stop-circle"></i>
							Plataforma
						</a>
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

										<h1 class="content_r_hst1">Implementaci&oacute;n de controlador digital</h1>
										<h2 class="content_r_hst2">1.1 Controlador PID en Tiempo Continuo.</h2>
										<p>El control de sistemas f&iacute;sicos, qu&iacute;micos, el&eacute;ctricos y
											electr&oacute;nicos es muy importante en la industria, la medicina,
											transporte, comunicaci&oacute;n, donde cada vez el control digital va
											tomando m&aacute;s &eacute;nfasis.</p>
										<p> Herramientas computacionales como Matlab, Matlab Simulink y Octave permiten
											el an&aacute;lisis de los sistemas antes descritos, y hacen de la
											sintonizaci&oacute;n mucho m&aacute;s c&oacute;moda.</p>
										<p>Un controlador PID descrito en tiempo continuo y en funci&oacute;n de las
											ganancias de la acci&oacute;n proporcional, integral y derivativa de la
											forma <b>(1)</b> </p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn1.png" /></p>
										<p>de la misma forma, pero ahora en funci&oacute;n de las constantes de tiempo
											integrativa y derivativa <b>(2)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn2.png" /></p>
										<p>El control PID se caracteriza por su robustez y simplicidad en dise&ntilde;o,
											haciendo el control de sistemas lineales una tarea f&aacute;cil.</p>
										<p>Una de las formas m&aacute;s pr&aacute;cticas para la representaci&oacute;n
											del controlados est&aacute; dada por la relaci&oacute;n entrada salida del
											mismo, representada por su funci&oacute;n de transferencia en el dominio de
											Laplace. <b>(3)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn3.png" /></p>
										<p>Esta ultima es muy utilizada en el an&aacute;lisis del comportamiento de la
											respuesta en lazo cerrado.</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Fig.1.png" />
										<p style="text-align:center;">Fig.1. Diagrama en bloque de lazo de control
											realimentados (feedback)</p>
										<h2 class="content_r_hst2">1.2 M&eacute;todos de Sintonizaci&oacute;n.</h2>
										<h3 class="content_r_hst3">1.2.1 M&eacute;todo de Ziegler-Nichols.</h3>
										<p>Este es uno de los m&eacute;todos m&aacute;s conocidos para la
											sintonizaci&oacute;n de controladores de lazo cerrado como PID, Consiste en
											llevar al sistema, en lazo cerrado, a r&eacute;gimen oscilatorio aumentando
											la ganancia, a esta ganancia se le conoce como ganancia cr&iacute;tica (Ku)
											y es luego utilizada para obtener los par&aacute;metros del control desde la
											tabla que los relaciona. Adem&aacute;s, de este r&eacute;gimen se obtiene el
											periodo de oscilaci&oacute;n cr&iacute;tica (Tu) que, al igual que la
											ganancia cr&iacute;tica, es utilizado en la sintonizaci&oacute;n. </p>
										<p>El m&eacute;todo de la ganancia critica tiene como resultado una respuesta
											con un cuarto de raz&oacute;n de crecimiento.</p>
										<p>A modo de ejemplo se muestra la sintonizaci&oacute;n de una planta
											H<sub>p</sub>(s) por el m&eacute;todo de Ziegler-Nichols.</p>
										<p>Ejemplo 1: Se propone hacer control sobre la planta que se muestra a
											continuaci&oacute;n haciendo uso de Matlab y del m&eacute;todo antes
											se&ntilde;alado.</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Eg1.png" />
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Cod1.png" />
										<p>Tab.1. Parametros de control Ziegler-Nichols, ganancia cr&iacute;tica y
											Periodo cr&iacute;tico</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Tab.1.png" />
										<p>A continuaci&oacute;n, se muestran los resultados del c&oacute;digo anterior:
										</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Fig.2.png" />
										<p>Fig.2. Respuestas del Sistema Hp(s), a) Sistema en R&eacute;gimen
											Oscilatorio, llevado con ganancia critica Ku. b) Respuesta al escal&oacute;n
											del sistema Hp en lazo abierto.</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Fig.3.png" />
										<p style="text-align:center;">Fig.3. Respuesta ante referencia paso, sistema
											lazo cerrado sintonizado con
											Ziegler-Nichols.</p>
										<p>Se observa en la comparaci&oacute;n de las respuestas en lazo cerrado y lazo
											abierto que la respuesta mejora mucho en t&eacute;rminos de velocidad, y que
											es justamente lo que se espera con un control PID, pero, cabe se&ntilde;alar
											que cae su ganancia est&aacute;tica</p>
										<h3 class="content_r_hst3">1.2.2 Asignaci&oacute;n de Polos.</h3>
										<p>Hay plantas que, por el comportamiento de sus ra&iacute;ces, no es posible
											llevar a oscilaci&oacute;n, un ejemplo de esto son las plantas de primer
											orden, que son descritas por el modelo PORT como: <b>(4)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn4.png" /></p>
										<p>Por simplicidad para el an&aacute;lisis consideraremos e<sup>-Ls</sup>
											unitario, lo que significa que no habr&aacute; retardo de tiempo, si
											observamos su LGR y su margen de ganancia, se observa que no es posible
											llevar a oscilaci&oacute;n. Es ah&iacute; donde aparecen otros
											m&eacute;todos de control c&oacute;mo lo es asignaci&oacute;n de polos. </p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Fig.4.png" />
										<p style="text-align:center;">Fig.4. Lugar geom&eacute;trico de las
											ra&iacute;ces, planta de primer orden.
										</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Fig.5.png" />
										<p style="text-align:center;">Fig.5. Margen de ganancia y fase, sistema de
											primer orden.</p>
										<p>El m&eacute;todo en cuesti&oacute;n trata de ubicar los polos del lazo
											cerrado de tal manera que se pueda obtener una respuesta deseada.</p>
										<p>Se busca que el polinomio caracter&iacute;stico de la funci&oacute;n de
											transferencia del lazo que se muestra a continuaci&oacute;n se comporte como
											una respuesta t&iacute;pica de segundo orden
											P(s)=s<sup>2</sup>+2&xi;&omega;<sub>n</sub>+&omega;<sub>n</sub><sup>2</sup>.
										</p>
										<img class="img-fluid rounded mx-auto d-block mbotom"
											src="../../../img/Control/Fig.6.png" />
										<p style="text-align:center;">Fig.6. Diagrama en bloques del lazo de control PI
											para una planta de primer
											orden.</p>
										<p>As&iacute; la F. de T. del lazo ser&aacute;: <b>(5)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn5.png" /></p>
										<p>De ella despejando su polinomio caracter&iacute;stico se tiene que <b>(6)</b>
										</p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn6.png" /></p>
										<p>Luego igualando los coeficientes del polinomio caracter&iacute;stico del lazo
											cerrado con el que se busca tener se tiene que: <b>(7)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn7.png" /></p>
										<p>y <b>(8)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn8.png" /></p>
										<p>As&iacute; es posible determinar los coeficientes del control en
											funci&oacute;n de la frecuencia angular del lazo y su factor de
											amortiguamiento, obteniendo una respuesta deseada.</p>
										<p>Despejando se tiene que los par&aacute;metros del control son <b>(9)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn9.png" /></p>
										<p>y <b>(10)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eqn10.png" /></p>
										<p> Con: </p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/wn.png" /></p>
										<p>donde T<sub>ss</sub> es el tiempo de asentamiento de la respuesta, este se
											encuentra buscando evitar la saturaci&oacute;n del actuador de control.
											<p>Ejemplo 2: Se propone hacer control sobre la planta que se muestra a
												continuaci&oacute;n haciendo uso de Matlab y del m&eacute;todo antes
												se&ntilde;alado.</p>
											<img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Eg2.png" />
											<img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Cod2.png" />
											<p>A partir del c&oacute;digo anterior se obtiene la respuesta del lazo
												cerrado ante un cambio tipo paso en la referencia, se busca que dicha
												respuesta tenga un sobrepaso de un 4%, y un tiempo de asentamiento de 1
												[s], esto junto a las igualdades que relacionan los par&aacute;metros
												del control con los par&aacute;metros de la planta, se obtiene la
												siguiente respuesta.</p>
											<img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Fig.7.png" />
											<p style="text-align:center;">Fig.7. Respuesta ante un paso de referencia
												del sistema en lazo cerrado.
											</p>
											<p>Como se puede observar en la Fig.7, la respuesta tiene un sobrepaso
												superior al 4%, esto se debe a que el control PI, pone un cero en el LGR
												el cual cambia la din&aacute;mica del sistema, esta repuesta puede
												mejorarse aplicando un filtro de cancelaci&oacute;n del cero del control
												en la referenciad de la forma siguiente.</p>
											<img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Fig.8.png" />
											<p style="text-align:center;">Fig.8. Diagrama en bloque del lazo de control
												con filtro de
												cancelaci&oacute;n de zero.</p>
											<p>Con esta implementaci&oacute;n se mejora la respuesta obteniendo el
												sobrepaso para el cual se ha dise&ntilde;ado en controlador.</p>
											<img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Fig.9.png" />
											<p style="text-align:center;">Fig.9. :"Comparaci&oacute;n de las respuestas
												con filtro de
												cancelaci&oacute;n de cero y sin filtro de cancelaci&oacute;n de cero.
											</p>
											<p>C&oacute;mo se puede observar en la Fig.9, la respuesta se hace
												m&aacute;s lenta por la ausencia del cero puesto por el controlador,
												pero a la vez se obtiene una respuesta dada por el factor de
												amortiguamiento seg&uacute;n dise&ntilde;o.</p>
											<h2 class="content_r_hst2">1.3 Modificaciones del Control PID.</h2>
											<h3 class="content_r_hst3">1.3.1 Anti-Windup.</h3>
											<img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Fig.10.png" />
											<p style="text-align:center;">Fig.10. Diagrama de simulaci&oacute;n del lazo
												cerrado con control PID
												modificado con Anti-windup.</p>
											<p>Con el objetivo de evitar la saturaci&oacute;n del actuador de control,
												se dise&ntilde;a el controlador PID con una modificaci&oacute;n, esta es
												conocida como Anti-windup, en la Ilustraci&oacute;n 10 se muestra su
												diagrama de simulaci&oacute;n para la implementaci&oacute;n del mismo en
												Matlab Simulink, esta modificaci&oacute;n lo que busca es saturar la
												se&ntilde;al de control cuando se produce un sobrepaso en la
												se&ntilde;al de mando, esto se consigue apagando la parte integrativa y
												as&iacute; evitar la sobre-integraci&oacute;n del erro y sacando en el
												mando el valor m&aacute;ximo de salida del mismo. En el c&oacute;digo
												para Matlab que se muestra a continuaci&oacute;n se observa c&oacute;mo
												se implementa el anti-windup, se satura la se&ntilde;al de mando para el
												actuador y se “apaga” la parte integrativa haciendo sw=0, donde sw se
												encuentra multiplicando a la parte integrativa en el c&oacute;digo que
												describe los par&aacute;metros del controlador.</p>
											<img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Cod3.png" />
											<p>Cabe destacar que esta modificaci&oacute;n saca al sistema de su zona
												lineal por lo que es preferible evitar la saturaci&oacute;n del mando
												cambiando el tiempo de asentamiento con el que se dise&ntilde;a el
												controlador, pero en el caso de que sea posible aplicarlo es conveniente
												para evitar la sobre-integraci&oacute;n del error y proteger al actuador
												de se&ntilde;ales muy altas de tensi&oacute;n.</p>
											<h3 class="content_r_hst3">1.3.2 Filtro Derivada.</h3>
											<img class="img-fluid rounded mx-auto d-block mbotom"
												src="../../../img/Control/Fig.11.png" />
											<p style="text-align:center;">Fig.11. Diagrama de simulaci&oacute;n
												controlador PID modificado con
												filtro Derivada</p>
											<p>La presencia de ruido y pendientes fuertes en las mediciones producen un
												efecto indeseado en las acciones de control, ya que la acci&oacute;n
												derivativa amplifica este efecto (amplificando ruido), es por esta
												raz&oacute;n que la acci&oacute;n derivativa no puede y no
												deber&iacute;a ser implementada sin modificaciones. Es posible modificar
												la acci&oacute;n derivativa como se muestra en el diagrama de
												simulaci&oacute;n de la Ilustraci&oacute;n 11 con el objetivo de reducir
												el efecto de estas pendientes fuertes.</p>
											<p>Mirando esta modificaci&oacute;n como una funci&oacute;n de
												transferencia, haciendo <b>(11)</b></p>
											<p> <img class="img-fluid rounded mx-auto d-block mbotom"
													src="../../../img/Control/Eqn11.png" /></p>
											<p>donde se mueve t&iacute;picamente entre 3 y 20 buscando reducir lo
												m&aacute;s posible el efecto derivativo, la nueva funci&oacute;n de
												transferencia del controlador PID se encuentra simplemente reemplazando
												la aproximaci&oacute;n de la ecuaci&oacute;n (11) en (3), finalmente el
												control ser&aacute; <b>(12)</b>
												<p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn12.png" /></p>
													<h2 class="content_r_hst2" style="margin-bottom:30px;">1.4
														Discretizaci&oacute;n.</h2>
													<img class="img-fluid rounded mx-auto d-block mbotom"
														src="../../../img/Control/Fig.12.png" />
													<p style="text-align:center;">Fig.12. Lazo cerrado con control
														digital, retentor de orden cero
														y planta en tiempo continuo.</p>
													<p>El control digital toma cada vez m&aacute;s &eacute;nfasis, los
														controladores antes dise&ntilde;ados en el mundo
														anal&oacute;gico pueden ser llevados al mundo digital por medio
														de la discretizaci&oacute;n de los mismos, para esto se
														presentan tres tipos de aproximaciones con diferentes
														caracter&iacute;sticas que cumplen con este objetivo.</p>
													<img class="img-fluid rounded mx-auto d-block mbotom"
														src="../../../img/Control/Fig.13.png" />
													<p>Fig.13. Aproximaciones num&eacute;ricas de integraci&oacute;n. a)
														aproximaci&oacute;n rectangular hacia adelante. b)
														Aproximaci&oacute;n rectangular hacia atr&aacute;s. c)
														Aproximaci&oacute;n trapezoidal.</p>
													<p>En la Fig.13 se ven los diferentes tipos de aproximaciones de la
														integraci&oacute;n, donde T corresponde al intervalo de
														muestreo, e(k) corresponde al error en el instante de tiempo kT,
														e(k+1) corresponde al error en el instante de tiempo siguiente y
														e(k-1) es el error en el instante de tiempo anterior.</p>
													<h3 class="content_r_hst3">1.4.1 Aproximaci&oacute;n rectangular
														hacia adelante</h3>
													<p>A partir de la Fig.13.a) se tiene lo siguiente: <b>(13)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn13.png" /></p>
													<p>luego separando <b>(14)</b> </p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn14.png" /></p>
													<p>aplicando la transformada <b>(15)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn15.png" /></p>
													<p>Finalmente, la funci&oacute;n de transferencia en el dominio z de
														un integrador quedara c&oacute;mo <b>(16)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn16.png" /></p>
													<h3 class="content_r_hst3">1.4.2 Aproximaci&oacute;n rectangular
														hacia atr&aacute;s</h3>
													<p>A partir de la Fig.13.b) se tiene que <b>(17)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn17.png" /></p>
													<p>Luego separando <b>(18)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn18.png" /></p>
													<p>aplicando la transformada <b>(19)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn19.png" /></p>
													<p>Finalmente, la funci&oacute;n de transferencia en el dominio z de
														un integrador quedara c&oacute;mo <b>(20)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn20.png" /></p>
													<h3 class="content_r_hst3">1.4.3 Aproximaci&oacute;n rectangular
														hacia atr&aacute;s</h3>
													<p>A partir de la Fig.13.c) se tiene que <b>(21)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn21.png" /></p>
													<p>Luego separando <b>(22)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn22.png" /></p>
													<p>aplicando la transformada <b>(23)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn23.png" /></p>
													<p>Finalmente, la funci&oacute;n de transferencia en el dominio z de
														un integrador quedara c&oacute;mo <b>(24)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn24.png" /></p>
													<h3 class="content_r_hst3">1.4.4 Mapeo al plano-z.</h3>
													<p>Las aproximaciones antes mostradas llevan de forma diferente el
														semiplano izquierdo al c&iacute;rculo unitario del plano-z, esto
														se debe tanto a la cantidad de polos y ceros que tiene su
														funci&oacute;n de transferencia, adem&aacute;s la
														ubicaci&oacute;n de los mismos. En la Ilustraci&oacute;n 14 se
														muestra la correspondencia entre el plano-s y el plano-z.</p>
													<img class="img-fluid rounded mx-auto d-block mbotom"
														src="../../../img/Control/Fig.14.png" />
													<p>Fig.14. Mapeo del semi-plano del plano-s al plano-z mediante las
														aproximaciones de integrales. a) Aproximaci&oacute;n rectangular
														hacia adelante. b) Aproximaci&oacute;n rectangular hacia
														atr&aacute;s. c) Aproximaci&oacute;n trapezoidal.</p>
													<h3 class="content_r_hst3">1.4.5 Control PID Discreto.</h3>
													<p>El uso de las aproximaciones descritas anteriormente va de la
														mano con la estabilidad del control, ya que las diferentes
														aproximaciones suponen un posicionamiento de los polos y ceros
														mas cercanos a la estabilidad o no. Es por esto que se muestra
														la estabilidad de la funci&oacute;n de transferencia del PID en
														el Lugar Geom&eacute;trico de las Ra&iacute;ces (LGR) en las
														siguientes ilustraciones. </p>
													<img class="img-fluid rounded mx-auto d-block mbotom"
														src="../../../img/Control/Fig.15.png" />
													<p>Estabilidad del Control PID. a) aproximaci&oacute;n Forward para
														la acci&oacute;n integrativa y forward para la acci&oacute;n
														derivativa. b) aproximaci&oacute;n backward para la
														acci&oacute;n integrativa y backward para la acci&oacute;n
														derivativa .c) aproximaci&oacute;n Forward para la acci&oacute;n
														integrativa y backward para la acci&oacute;n derivativa. d)
														aproximaci&oacute;n backward para la acci&oacute;n integrativa y
														forward para la acci&oacute;n derivativa.</p>
													<p></p>
													<p>La parte proporcional es la m&aacute;s simple, reemplazando t =
														kT se encuentra: <b>(25)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn25.png" /></p>
													<p>Como se observa en la Fig.15 la estabilidad del controlador
														cambia con la aproximaci&oacute;n con la que sea discretizado,
														el uso de la aproximaci&oacute;n hacia atr&aacute;s para la
														parte derivativa tiene como ventaja la estabilidad de la misma,
														ya que uno de los polos se ubica en cero, mientras que la
														aproximaci&oacute;n hacia adelante saca a los polos del circulo
														unidad. <b>(26)</b> </p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn26.png" /></p>
													<p>despejando el presente de la derivaci&oacute;n: <b>(27)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn27.png" /></p>
													<p>En cuanto a la parte integrativa, esta no tiene mayores problemas
														de estabilidad, pero en la literatura se ve usualmente la
														integraci&oacute;n hacia adelante para la discretizaci&oacute;n
														de esta acci&oacute;n. <b>(28)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn28.png" /></p>
													<p>Se busca la ecuaci&oacute;n en tiempo discreto: <b>(29)</b></p>
													<p> <img class="img-fluid rounded mx-auto d-block mbotom"
															src="../../../img/Control/Eqn29.png" /></p>
													<p>A continuaci&oacute;n, se muestra un c&oacute;digo de ejemplo de
														implementaci&oacute;n discreta del control PID antes
														discretizado.</p>
													<img class="img-fluid rounded mx-auto d-block mbotom"
														src="../../../img/Control/Cod4.png" />

													<h2 class="content_r_hst2">Referencias</h2>
													<p>[1] Katsuhiko Ogata, "Ingenier&iacute;a de control Moderna," 3a
														ed., Minnesota, Tom Robbins,1998, pp. 147-154.</p>
													<p>[2] Anibal Ollero Baturone, Control por computador
														descripci&oacute;n y dise&ntilde;o optimo, 1a ed., 1991, pp.12.
													</p>
													<p>[3] Alan V. Oppenheim & Ronald W. Schafer, 2T&eacute;cnicas de
														dise&ntilde;o de filtros," en Tratamiento de se&ntilde;ales en
														tiempo discreto. 3a ed., Pearson Educaci&oacute;n, 2011.</p>
													<p>[4] Mario E. Salgado, Juan I. Yuz, Ricardo A. Rojas,
														"An&aacute;lisis en tiempo discreto," en An&aacute;lisis de
														sistemas lineales. 1a ed., Pearson Educaci&oacute;n, 2005.</p>







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





<?php  }  ?>








<!--

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Teor&iacute;a</title>
    <link href="../../../css/styles.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" src="../../../js/sld.js" type="text/javascript"></script>
</head>

<body>
	<div id="page">
		<div id="header">
			<div id="header_t">
				<div id="header_t_l"><img src="../../../img/logo.png" border="0" /></a></div>
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
					<li><a href="../index.php">Inicio</a></li>
					<li><a href="../theory.php">Teor&iacute;a</a></li>
					<li><a href="../practices.php">Pr&aacute;cticas</a></li>
					<li><a href="../platform.php">Plataforma</a></li>
					<li><a href="#">Foro</a></li>
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
						<li><a href="../../../general/logout.php" class="ast3">Logout</a></li>
					</ul>
					<h1 class="content_l_hst1">Navegaci&oacute;n</h1>
					<ul>
						<li><a href="../index.php" class="ast3">Inicio</a></li>
						<li><a href="../theory.php" class="ast3">Teoria</a></li>
						<li><a href="../practices.php" class="ast3">Pr&aacute;cticas</a></li>
						<li><a href="../platform.php" class="ast3">Plataforma</a></li>
						<li><a href="../mypractices.php" class="ast3">Mis Pr&aacute;cticas</a></li>
						<li><a href="mailto:ching@uclv.edu.cu;aerubio@ubiobio.cl">Contacto</a></li>
					</ul>
				</div>
				<div id="content_l_b"></div>
			</div>
			<div id="content_r">
				<h1 class="content_r_hst1">Implementaci&oacute;n de controlador digital</h1>
				<h2 class="content_r_hst2">1.1	Controlador PID en Tiempo Continuo.</h2>
				<p>El control de sistemas f&iacute;sicos, qu&iacute;micos, el&eacute;ctricos y electr&oacute;nicos es muy importante en la industria, la medicina, transporte, comunicaci&oacute;n, donde cada vez el control digital va tomando m&aacute;s &eacute;nfasis.</p>
				<p> Herramientas computacionales como Matlab, Matlab Simulink y Octave permiten el an&aacute;lisis de los sistemas antes descritos, y hacen de la sintonizaci&oacute;n mucho m&aacute;s c&oacute;moda.</p>
				<p>Un controlador PID descrito en tiempo continuo y en funci&oacute;n de las ganancias de la acci&oacute;n proporcional, integral y derivativa de la forma </p>
				<p> <img src="../../../img/Control/Eqn1.png" />, (1)</p> 
				<p>de la misma forma, pero ahora en funci&oacute;n de las constantes de tiempo integrativa y derivativa</p>
				<p> <img src="../../../img/Control/Eqn2.png" />. (2)</p>
				<p>El control PID se caracteriza por su robustez y simplicidad en dise&ntilde;o, haciendo el control de sistemas lineales una tarea f&aacute;cil.</p>
				<p>Una de las formas m&aacute;s pr&aacute;cticas para la representaci&oacute;n del controlados est&aacute; dada por la relaci&oacute;n entrada salida del mismo, representada por su funci&oacute;n de transferencia en el dominio de Laplace.</p>
				<p> <img src="../../../img/Control/Eqn3.png" />. (3)</p>
				<p>Esta ultima es muy utilizada en el an&aacute;lisis del comportamiento de la respuesta en lazo cerrado.</p>
				<img src="../../../img/Control/Fig.1.png" />
				<p>Fig.1. Diagrama en bloque de lazo de control realimentados (feedback)</p>
				<h2 class="content_r_hst1">1.2	M&eacute;todos de Sintonizaci&oacute;n.</h2>
				<h3 class="content_r_hst1">1.2.1	M&eacute;todo de Ziegler-Nichols.</h3>
				<p>Este es uno de los m&eacute;todos m&aacute;s conocidos para la sintonizaci&oacute;n de controladores de lazo cerrado como PID, Consiste en llevar al sistema, en lazo cerrado, a r&eacute;gimen oscilatorio aumentando la ganancia, a esta ganancia se le conoce como ganancia cr&iacute;tica (Ku) y es luego utilizada para obtener los par&aacute;metros del control desde la tabla que los relaciona. Adem&aacute;s, de este r&eacute;gimen se obtiene el periodo de oscilaci&oacute;n cr&iacute;tica (Tu) que, al igual que la ganancia cr&iacute;tica, es utilizado en la sintonizaci&oacute;n. </p>
				<p>El m&eacute;todo de la ganancia critica tiene como resultado una respuesta con un cuarto de raz&oacute;n de crecimiento.</p>
				<p>A modo de ejemplo se muestra la sintonizaci&oacute;n de una planta H<sub>p</sub>(s)  por el m&eacute;todo de Ziegler-Nichols.</p>
				<p>Ejemplo 1:	Se propone hacer control sobre la planta que se muestra a continuaci&oacute;n haciendo uso de Matlab y del m&eacute;todo antes se&ntilde;alado.</p>
				<img src="../../../img/Control/Eg1.png" />
				<img src="../../../img/Control/Cod1.png" />
				<p>Tab.1. Parametros de control Ziegler-Nichols, ganancia cr&iacute;tica y Periodo cr&iacute;tico</p>
				<img src="../../../img/Control/Tab.1.png" />
				<p>A continuaci&oacute;n, se muestran los resultados del c&oacute;digo anterior:</p>
				<img src="../../../img/Control/Fig.2.png" />
				<p>Fig.2. Respuestas del Sistema Hp(s), a) Sistema en R&eacute;gimen Oscilatorio, llevado con ganancia critica Ku. b) Respuesta al escal&oacute;n del sistema Hp en lazo abierto.</p>
				<img src="../../../img/Control/Fig.3.png" />
				<p>Fig.3. Respuesta ante referencia paso, sistema lazo cerrado sintonizado con Ziegler-Nichols.</p>
				<p>Se observa en la comparaci&oacute;n de las respuestas en lazo cerrado y lazo abierto que la respuesta mejora mucho en t&eacute;rminos de velocidad, y que es justamente lo que se espera con un control PID, pero, cabe se&ntilde;alar que cae su ganancia est&aacute;tica</p>
				<h3 class="content_r_hst1">1.2.2	Asignaci&oacute;n de Polos.</h3>
				<p>Hay plantas que, por el comportamiento de sus ra&iacute;ces, no es posible llevar a oscilaci&oacute;n, un ejemplo de esto son las plantas de primer orden, que son descritas por el modelo PORT como:</p>
				<p> <img src="../../../img/Control/Eqn4.png" />. (4)</p>
				<p>Por simplicidad para el an&aacute;lisis consideraremos e<sup>-Ls</sup> unitario, lo que significa que no habr&aacute; retardo de tiempo, si observamos su LGR y su margen de ganancia, se observa que no es posible llevar a oscilaci&oacute;n. Es ah&iacute; donde aparecen otros m&eacute;todos de control c&oacute;mo lo es asignaci&oacute;n de polos. </p>
				<img src="../../../img/Control/Fig.4.png" />
				<p>Fig.4. Lugar geom&eacute;trico de las ra&iacute;ces, planta de primer orden.</p>
				<img src="../../../img/Control/Fig.5.png" />
				<p>Fig.5. Margen de ganancia y fase, sistema de primer orden.</p>
				<p>El m&eacute;todo en cuesti&oacute;n trata de ubicar los polos del lazo cerrado de tal manera que se pueda obtener una respuesta deseada.</p>
				<p>Se busca que el polinomio caracter&iacute;stico de la funci&oacute;n de transferencia del lazo que se muestra a continuaci&oacute;n se comporte como una respuesta t&iacute;pica de segundo orden P(s)=s<sup>2</sup>+2&xi;&omega;<sub>n</sub>+&omega;<sub>n</sub><sup>2</sup>.</p>
				<img src="../../../img/Control/Fig.6.png" />
				<p>Fig.6. Diagrama en bloques del lazo de control PI para una planta de primer orden.</p>
				<p>As&iacute; la F. de T. del lazo ser&aacute;:</p>
				<p> <img src="../../../img/Control/Eqn5.png" />, (5)</p>
				<p>De ella despejando su polinomio caracter&iacute;stico se tiene que</p>
				<p> <img src="../../../img/Control/Eqn6.png" />, (6)</p>
				<p>Luego igualando los coeficientes del polinomio caracter&iacute;stico del lazo cerrado con el que se busca tener se tiene que:</p>
				<p> <img src="../../../img/Control/Eqn7.png" />, (7)</p>
				<p>y</p>
				<p> <img src="../../../img/Control/Eqn8.png" />, (8)</p>
				<p>As&iacute; es posible determinar los coeficientes del control en funci&oacute;n de la frecuencia angular del lazo y su factor de amortiguamiento, obteniendo una respuesta deseada.</p>
				<p>Despejando se tiene que los par&aacute;metros del control son</p>
				<p> <img src="../../../img/Control/Eqn9.png" />, (9)</p>
				<p>y</p>
				<p> <img src="../../../img/Control/Eqn10.png" />, (10)</p>
				<p> Con: </p>
				<p><img src="../../../img/Control/wn.png" />, </p>
				<p>donde T<sub>ss</sub> es el tiempo de asentamiento de la respuesta, este se encuentra buscando evitar la saturaci&oacute;n del actuador de control.
				<p>Ejemplo 2:	Se propone hacer control sobre la planta que se muestra a continuaci&oacute;n haciendo uso de Matlab y del m&eacute;todo antes se&ntilde;alado.</p>
				<img src="../../../img/Control/Eg2.png" />
				<img src="../../../img/Control/Cod2.png" />
				<p>A partir del c&oacute;digo anterior se obtiene la respuesta del lazo cerrado ante un cambio tipo paso en la referencia, se busca que dicha respuesta tenga un sobrepaso de un 4%, y un tiempo de asentamiento de 1 [s], esto junto a las igualdades que relacionan los par&aacute;metros del control con los par&aacute;metros de la planta, se obtiene la siguiente respuesta.</p>
				<img src="../../../img/Control/Fig.7.png" />
				<p>Fig.7. Respuesta ante un paso de referencia del sistema en lazo cerrado.</p>
				<p>Como se puede observar en la Fig.7, la respuesta tiene un sobrepaso superior al 4%, esto se debe a que el control PI, pone un cero en el LGR el cual cambia la din&aacute;mica del sistema, esta repuesta puede mejorarse aplicando un filtro de cancelaci&oacute;n del cero del control en la referenciad de la forma siguiente.</p>
				<img src="../../../img/Control/Fig.8.png" />
				<p>Fig.8. Diagrama en bloque del lazo de control con filtro de cancelaci&oacute;n de zero.</p>
				<p>Con esta implementaci&oacute;n se mejora la respuesta obteniendo el sobrepaso para el cual se ha dise&ntilde;ado en controlador.</p>
				<img src="../../../img/Control/Fig.9.png" />
				<p>Fig.9. :"Comparaci&oacute;n de las respuestas con filtro de cancelaci&oacute;n de cero y sin filtro de cancelaci&oacute;n de cero.</p>
				<p>C&oacute;mo se puede observar en la Fig.9, la respuesta se hace m&aacute;s lenta por la ausencia del cero puesto por el controlador, pero a la vez se obtiene una respuesta dada por el factor de amortiguamiento seg&uacute;n dise&ntilde;o.</p>
				<h2 class="content_r_hst1">1.3	Modificaciones del Control PID.</h2>
				<h3 class="content_r_hst1">1.3.1	Anti-Windup.</h3>
				<img src="../../../img/Control/Fig.10.png" />
				<p>Fig.10. Diagrama de simulaci&oacute;n del lazo cerrado con control PID modificado con Anti-windup.</p>
				<p>Con el objetivo de evitar la saturaci&oacute;n del actuador de control, se dise&ntilde;a el controlador PID con una modificaci&oacute;n, esta es conocida como Anti-windup, en la Ilustraci&oacute;n 10 se muestra su diagrama de simulaci&oacute;n para la implementaci&oacute;n del mismo en Matlab Simulink, esta modificaci&oacute;n lo que busca es saturar la se&ntilde;al de control cuando se produce un sobrepaso en la se&ntilde;al de mando, esto se consigue apagando la parte integrativa y as&iacute; evitar la sobre-integraci&oacute;n del erro y sacando en el mando el valor m&aacute;ximo de salida del mismo. En el c&oacute;digo para Matlab que se muestra a continuaci&oacute;n se observa c&oacute;mo se implementa el anti-windup, se satura la se&ntilde;al de mando para el actuador y se “apaga” la parte integrativa haciendo sw=0, donde sw se encuentra multiplicando a la parte integrativa en el c&oacute;digo que describe los par&aacute;metros del controlador.</p>
				<img src="../../../img/Control/Cod3.png" />
				<p>Cabe destacar que esta modificaci&oacute;n saca al sistema de su zona lineal por lo que es preferible evitar la saturaci&oacute;n del mando cambiando el tiempo de asentamiento con el que se dise&ntilde;a el controlador, pero en el caso de que sea posible aplicarlo es conveniente para evitar la sobre-integraci&oacute;n del error y proteger al actuador de se&ntilde;ales muy altas de tensi&oacute;n.</p>
				<h3 class="content_r_hst1">1.3.2	Filtro Derivada.</h3>
				<img src="../../../img/Control/Fig.11.png" />
				<p>Fig.11. Diagrama de simulaci&oacute;n controlador PID modificado con filtro Derivada</p>
				<p>La presencia de ruido y pendientes fuertes en las mediciones producen un efecto indeseado en las acciones de control, ya que la acci&oacute;n derivativa amplifica este efecto (amplificando ruido), es por esta raz&oacute;n que la acci&oacute;n derivativa no puede y no deber&iacute;a ser implementada sin modificaciones. Es posible modificar la acci&oacute;n derivativa como se muestra en el diagrama de simulaci&oacute;n de la Ilustraci&oacute;n 11 con el objetivo de reducir el efecto de estas pendientes fuertes.</p>
				<p>Mirando esta modificaci&oacute;n como una funci&oacute;n de transferencia, haciendo</p>
				<p> <img src="../../../img/Control/Eqn11.png" />, (11)</p>
				<p>donde   se mueve t&iacute;picamente entre 3 y 20 buscando reducir lo m&aacute;s posible el efecto derivativo, la nueva funci&oacute;n de transferencia del controlador PID se encuentra simplemente reemplazando la aproximaci&oacute;n de la ecuaci&oacute;n (11) en (3), finalmente el control ser&aacute;<p>
				<p> <img src="../../../img/Control/Eqn12.png" />. (12)</p>
				<h2 class="content_r_hst1">1.4	Discretizaci&oacute;n.</h2>
				<img src="../../../img/Control/Fig.12.png" />
				<p>Fig.12. Lazo cerrado con control digital, retentor de orden cero y planta en tiempo continuo.</p>
				<p>El control digital toma cada vez m&aacute;s &eacute;nfasis, los controladores antes dise&ntilde;ados en el mundo anal&oacute;gico pueden ser llevados al mundo digital por medio de la discretizaci&oacute;n de los mismos, para esto se presentan tres tipos de aproximaciones con diferentes caracter&iacute;sticas que cumplen con este objetivo.</p>
				<img src="../../../img/Control/Fig.13.png" />
				<p>Fig.13. Aproximaciones num&eacute;ricas de integraci&oacute;n. a) aproximaci&oacute;n rectangular hacia adelante. b) Aproximaci&oacute;n rectangular hacia atr&aacute;s. c) Aproximaci&oacute;n trapezoidal.</p>
				<p>En la Fig.13 se ven los diferentes tipos de aproximaciones de la integraci&oacute;n, donde T corresponde al intervalo de muestreo, e(k) corresponde al error en el instante de tiempo kT, e(k+1)  corresponde al error en el instante de tiempo siguiente y e(k-1)  es el error en el instante de tiempo anterior.</p>
				<h3 class="content_r_hst1">1.4.1	Aproximaci&oacute;n rectangular hacia adelante</h3>
				<p>A partir de la Fig.13.a) se tiene lo siguiente:</p>
				<p> <img src="../../../img/Control/Eqn13.png" />, (13)</p>
				<p>luego separando </p>
				<p> <img src="../../../img/Control/Eqn14.png" />, (14)</p>
				<p>aplicando la transformada  </p>
				<p> <img src="../../../img/Control/Eqn15.png" />. (15)</p>
				<p>Finalmente, la funci&oacute;n de transferencia en el dominio z de un integrador quedara c&oacute;mo</p>
				<p> <img src="../../../img/Control/Eqn16.png" />. (16)</p>
				<h3 class="content_r_hst1">1.4.2	Aproximaci&oacute;n rectangular hacia atr&aacute;s</h3>
				<p>A partir de la Fig.13.b) se tiene que </p>
				<p> <img src="../../../img/Control/Eqn17.png" />, (17)</p>
				<p>Luego separando</p>
				<p> <img src="../../../img/Control/Eqn18.png" />, (18)</p>
				<p>aplicando la transformada  </p>
				<p> <img src="../../../img/Control/Eqn19.png" />. (19)</p>
				<p>Finalmente, la funci&oacute;n de transferencia en el dominio z de un integrador quedara c&oacute;mo</p>
				<p> <img src="../../../img/Control/Eqn20.png" />. (20)</p>
				<h3 class="content_r_hst1">1.4.2	Aproximaci&oacute;n rectangular hacia atr&aacute;s</h3>
				<p>A partir de la Fig.13.c) se tiene que </p>
				<p> <img src="../../../img/Control/Eqn21.png" />, (21)</p>
				<p>Luego separando</p>
				<p> <img src="../../../img/Control/Eqn22.png" />, (22)</p>
				<p>aplicando la transformada  </p>
				<p> <img src="../../../img/Control/Eqn23.png" />. (23)</p>
				<p>Finalmente, la funci&oacute;n de transferencia en el dominio z de un integrador quedara c&oacute;mo</p>
				<p> <img src="../../../img/Control/Eqn24.png" />. (24)</p>
				<h3 class="content_r_hst1">1.4.4		Mapeo al plano-z.</h3>
				<p>Las aproximaciones antes mostradas llevan de forma diferente el semiplano izquierdo al c&iacute;rculo unitario del plano-z, esto se debe tanto a la cantidad de polos y ceros que tiene su funci&oacute;n de transferencia, adem&aacute;s la ubicaci&oacute;n de los mismos. En la Ilustraci&oacute;n 14 se muestra la correspondencia entre el plano-s y el plano-z.</p>
				<img src="../../../img/Control/Fig.14.png" />
				<p>Fig.14. Mapeo del semi-plano del plano-s al plano-z mediante las aproximaciones de integrales. a) Aproximaci&oacute;n rectangular hacia adelante. b) Aproximaci&oacute;n rectangular hacia atr&aacute;s. c) Aproximaci&oacute;n trapezoidal.</p>
				<h3 class="content_r_hst1">1.4.5	Control PID Discreto.</h3>
				<p>El uso de las aproximaciones descritas anteriormente va de la mano con la estabilidad del control, ya que las diferentes aproximaciones suponen un posicionamiento de los polos y ceros mas cercanos a la estabilidad o no. Es por esto que se muestra la estabilidad de la funci&oacute;n de transferencia del PID en el Lugar Geom&eacute;trico de las Ra&iacute;ces (LGR) en las siguientes ilustraciones. </p>
				<img src="../../../img/Control/Fig.15.png" />
				<p>Estabilidad del Control PID. a) aproximaci&oacute;n Forward para la acci&oacute;n integrativa y forward para la acci&oacute;n derivativa. b) aproximaci&oacute;n backward para la acci&oacute;n integrativa y backward para la acci&oacute;n derivativa .c) aproximaci&oacute;n Forward para la acci&oacute;n integrativa y backward para la acci&oacute;n derivativa. d) aproximaci&oacute;n backward para la acci&oacute;n integrativa y forward para la acci&oacute;n derivativa.</p>
				<p></p>	
				<p>La parte proporcional es la m&aacute;s simple, reemplazando t = kT se encuentra:</p>
				<p> <img src="../../../img/Control/Eqn25.png" />. (25)</p>
				<p>Como se observa en la Fig.15 la estabilidad del controlador cambia con la aproximaci&oacute;n con la que sea discretizado, el uso de la aproximaci&oacute;n hacia atr&aacute;s para la parte derivativa tiene como ventaja la estabilidad de la misma, ya que uno de los polos se ubica en cero, mientras que la aproximaci&oacute;n hacia adelante saca a los polos del circulo unidad. </p>
				<p> <img src="../../../img/Control/Eqn26.png" />, (26)</p>
				<p>despejando el presente de la derivaci&oacute;n:</p>
				<p> <img src="../../../img/Control/Eqn27.png" />. (27)</p>
				<p>En cuanto a la parte integrativa, esta no tiene mayores problemas de estabilidad, pero en la literatura se ve usualmente la integraci&oacute;n hacia adelante para la discretizaci&oacute;n de esta acci&oacute;n.</p>
				<p> <img src="../../../img/Control/Eqn28.png" />. (28)</p>
				<p>Se busca la ecuaci&oacute;n en tiempo discreto:</p>
				<p> <img src="../../../img/Control/Eqn29.png" />. (29)</p>
				<p>A continuaci&oacute;n, se muestra un c&oacute;digo de ejemplo de implementaci&oacute;n discreta del control PID antes discretizado.</p>
				<img src="../../../img/Control/Cod4.png" />
				<p></p>	
				<p></p>	
				<p></p>	
				<p></p>	
				<h2 class="content_r_hst2">Referencias</h2>
				<p>[1]	Katsuhiko Ogata, "Ingenier&iacute;a de control Moderna," 3a ed., Minnesota, Tom Robbins,1998, pp. 147-154.</p>
				<p>[2]	Anibal Ollero Baturone, Control por computador descripci&oacute;n y dise&ntilde;o optimo, 1a ed., 1991, pp.12.</p>
				<p>[3]	Alan V. Oppenheim & Ronald W. Schafer, 2T&eacute;cnicas de dise&ntilde;o de filtros," en Tratamiento de se&ntilde;ales en tiempo discreto. 3a ed., Pearson Educaci&oacute;n, 2011.</p>
				<p>[4]	Mario E. Salgado, Juan I. Yuz, Ricardo A. Rojas, "An&aacute;lisis en tiempo discreto," en An&aacute;lisis de sistemas lineales. 1a ed., Pearson Educaci&oacute;n, 2005.</p>
				
				
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