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
?>




<?php  if($level == 2){  ?>


	<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<?php require_once('css/libcss.php') ?>
	<link rel="stylesheet" href="css/index.css">
	<link href="../admin/css/platform.css" rel="stylesheet" type="text/css" />


</head>




<body>


	<div id="wrapper">
		<div class="overlay"></div>

		<!-- Sidebar -->
		<?php require_once('../../structure/sidebar_profesor.php') ?>

		<div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>

			<!-- Topbar -->
			<?php require_once('../../structure/navbar_admin.php') ?>

			<div id="content">

				<div id="content2" class="container-fluid p-0 px-lg-0 px-md-0">

					<!-- End of Topbar -->

					<!-- Begin Page Content -->
					<div class="container-fluid px-lg-4 content_g ">
						<div class="row">
							<div id="content3" class="col-md-12 mt-lg-4 mt-4">


								<div class="content_platform">
									<h1 class="content_r_hst1">Sistema de laboratorios a distancia (SLD) </h1>

									<h1 class="content_r_hst2">Publicaciones recientes</h1>
									<div class="content_r_hst3">
										<p>"Remote laboratories for control education: Experience at the universidad del
											B&iacute;o-B&iacute;o"</p>
										<p>IEEE International Conference on Automatica (ICA-ACCA), Oct. 2016.</p>
										<p>DOI: 10.1109/ICA-ACCA.2016.7778444</p>
									</div>


									<h1 class="content_r_hst2">Proyectos asociados</h1>
									<div class="content_r_hst3">
										<p>IenDU No. 100 (DGI-UBB) &laquo;Sistema de pr&aacute;cticas remotas de control
											autom&aacute;tico en tiempo real para la formaci&oacute;n de estudiantes de
											Ingenier&iacute;a Civil en Automatizaci&oacute;n&raquo;</p>
										<p>FAPE No. 135 (DGPE-UBB) &laquo;Tra&iacute;da de un experto en el marco de un
											taller para el desarrollo de un sistema de pr&aacute;cticas remotas de
											control
											autom&aacute;tico en tiempo real para la formaci&oacute;n de estudiantes de
											Ingenier&iacute;a Civil en Automatizaci&oacute;n&raquo;</p>
										<p>FDD-2017 (VA-UBB) &laquo;Manual de teor&iacute;a y pr&aacute;cticas de
											laboratorios utilizando el Sistema de Laboratorios a Distancia implementado
											en
											el Laboratorio de Control del DIEE&raquo;</p>
										<p>FDE-ING2030 (CORFO) &laquo;Macrolaboratorio de formaci&oacute;n conjunta para
											sistemas de control autom&aacute;tico&raquo;</p>

									</div>

									<h1 class="content_r_hst2">Grupos de investigaci&oacute;n</h1>
									<div class="content_r_hst3">
										<p>GARP (UCLV) &laquo;Grupo de Automatizaci&oacute;n Rob&oacute;tice y
											Percepci&oacute;n&raquo;</p>
										<p>SAN (UBB) &laquo;Sensor and Actuator Networks Research Group&raquo;</p>
									</div>


									<h1 class="content_r_hst2">Motivaci&oacute;n</h1>
									<div class="content_r_hst3">
										<p>El ensayo con sistemas reales ha tenido una disminuci&oacute;n en los
											&uacute;ltimos a&ntilde;os y ha sido sustituido por herramientas de
											simulaci&oacute;n, debido principalmente al alto costo, mantenimiento y
											operaci&oacute;n de los laboratorios de pr&aacute;cticas. La
											pr&aacute;cticas
											simuladas, a pesar de presentar grandes ventajas por su facilidad de uso y
											relativo bajo costo, son deficientes en simular el ruido, la respuesta en
											frecuencia, la conversi&oacute;n anal&oacute;gica digital y otros
											fen&oacute;menos que caracterizan a los sistemas reales. En respuesta a este
											inconveniente se ha comenzado a usar Internet como un medio de apoyo a la
											ense&ntilde;anza y de compartir recursos de software y hardware costosos.
											Esto
											ha permitido que se hayan desarrollado laboratorios virtuales y remotos los
											cuales combinan la flexibilidad que ofrecen las simulaciones sin perder las
											caracter&iacute;sticas importantes que rigen a los sistemas f&iacute;sicos.
											Todas estas facilidades permiten experimentar en plantas reales en cualquier
											horario y d&iacute;a, sin necesidad de estar en el laboratorio.</p>
										<p>En el caso de los laboratorios para la ense&ntilde;anza del control
											autom&aacute;tico, la mayor&iacute;a presentan esquemas predefinidos de
											control,
											esto limita a escoger alg&uacute;n tipo de regulador (PI, PID, espacio de
											estado, etc.) y ajustar sus par&aacute;metros para lograr una respuesta
											deseada.
										</p>
										<p>El Dpto. de Autom&aacute;tica y Sistemas Computacionales de la Universidad
											Central Marta Abreu de Las Villas en cooperaci&oacute;n con el Dpto. de
											Autom&aacute;tica, Ingenier&iacute;a Electr&oacute;nica e Inform&aacute;tica
											Industrial de la Universidad Polit&eacute;cnica de Madrid y el Departamento
											de
											Ingenier&iacute;a El&eacute;ctrica y Electr&oacute;nica de la Universidad
											del
											B&iacute;o-B&iacute;o, desarrollaron este Sistema de Laboratorios a
											Distancia
											(SLD) que permite el ensayo de algoritmos de control de forma remota
											v&iacute;a
											Internet. Est&aacute; basado en Matlab/Simulink y se pueden realizar
											pr&aacute;cticas, tanto simuladas como reales, en un entorno Web sin
											necesidad
											de descargar software adicional. En la plataforma desarrollada los usuarios
											pueden realizar pr&aacute;cticas con esquemas predefinidos de control,
											as&iacute; como la creaci&oacute;n de sus propios controladores, usando
											software
											altamente conocido en el medio como lo es Matlab/Simulink.
										</p>
									</div>



									<h1 class="content_r_hst2"> Caracter&iacute;sticas del SLD</h1>
									<div class="content_r_hst3">
										<p>El SLD presenta las siguientes caracter&iacute;sticas: </p>
										<p><strong><em>Disponibilidad</em></strong>: El sistema est&aacute; disponible
											las
											24 horas del d&iacute;a, con su adecuada autoprotecci&oacute;n.</p>
										<p><strong><em>Accesibilidad</em></strong>: El SLD puede ser accedido desde
											cualquier parte del mundo. Para ello solo es necesaria una computadora con
											conexi&oacute;n a Internet y un navegador Web.</p>
										<p><strong><em>Facilidad de uso</em></strong>: Para usar el sistema solo se debe
											tener los conocimientos b&aacute;sicos de la disciplina objeto de
											pr&aacute;cticas.</p>
										<p><strong><em>Interfaz de usuario r&aacute;pida y f&aacute;cil</em></strong>:
											La
											interfaz de usuario del SLD est&aacute; basada en p&aacute;ginas HTML; esto
											permite que los usuarios puedan acceder al sistema de una forma
											r&aacute;pida y
											sin necesidad de descargar o instalar ning&uacute;n software adicional. </p>
										<p><strong><em>Administraci&oacute;n de m&uacute;ltiples pedidos en forma
													paralela</em></strong>: El SLD permite atender m&uacute;ltiples
											pedidos
											de forma paralela administrando de forma centralizada dispositivos similares
											que
											se encuentren geogr&aacute;ficamente separados pero unidos por redes de
											&aacute;rea extensa (WAN).</p>
										<p><strong><em>Desarrollo de controladores de forma remota usando Matlab y
													Simulink</em></strong>: Una de las caracter&iacute;sticas m&aacute;s
											importantes del SLD es que permite a los usuarios dise&ntilde;ar sus propios
											controladores utilizando el ambiente Matlab/Simulink.</p>
										<p><strong><em>Cambio de referencias</em></strong>: El sistema permite cambiar
											las
											referencias de los experimentos para comprobar el desempe&ntilde;o de un
											determinado sistema ante distintas se&ntilde;ales de entrada.
										</p>
									</div>


									<h1 class="content_r_hst2"> Arquitectura del SLD</h1>

									<div class="content_r_hst3">
										<p> El sistema presenta la siguiente arquitectura:</p>
										<p> <img class="img-fluid rounded mx-auto d-block" src="../../img/platform.jpg"
												width="562" height="358" /> </p>
										<p>La interfaz de usuario est&aacute; formada por p&aacute;ginas HTML con
											funcionalidades de PHP para el registro de usuarios y la
											administraci&oacute;n y
											gesti&oacute;n del sitio Web. El sistema tiene una realimentaci&oacute;n
											visual
											en tiempo real con el objetivo de que el usuario tenga informaci&oacute;n de
											la
											ejecuci&oacute;n de las pr&aacute;cticas. El sistema puede ser accedido
											desde
											cualquier computadora con conexi&oacute;n a Internet usado cualquier
											navegador
											para Web.</p>
										<p>El Servidor de Administraci&oacute;n de Pr&aacute;cticas (SAP) se localiza en
											el
											servidor Web y est&aacute; constituido por p&aacute;ginas PHP, lo cual hace
											al
											sistema m&aacute;s portable y seguro, pudiendo ejecutarse este nivel en
											sistemas
											operativos Windows o Linux.</p>
										<p>El otro elemento que conforma el sistema es el Cliente de
											Administraci&oacute;n
											de Pr&aacute;cticas (CAP), el cual se ha implementado con Web Services. El
											CAP
											se encarga de comunicarse con el Matlab/Simulink el cual ejecuta las
											pr&aacute;cticas tanto reales como simuladas. Debido a que la
											comunicaci&oacute;n del Web Services con el Matlab es por COM esto implica
											que
											el sistema operativo de las estaciones de trabajo sea Windows.</p>
										<p>El sistema realiza las pr&aacute;cticas con Matlab/Simulink y el Toolbox Real
											Time Windows Target debido a la facilidad de uso y potentes capacidades de
											este
											software. Real Time Workshop proporciona la conexi&oacute;n en tiempo real
											con
											el sistema de adquisici&oacute;n de datos, mientras que Real Time Windows
											Target
											permite la ejecuci&oacute;n del esquema Simulink en tiempo real sobre
											Windows.
										</p>
									</div>


									<h1 class="content_r_hst2"> Funcionamiento del SLD</h1>

									<div class="content_r_hst3">

										<p>Los usuarios interact&uacute;an con el sistema a trav&eacute;s de Internet.
											Al
											acceder al sitio Web el usuario ingresa con su cuenta, elige la
											pr&aacute;ctica
											que se desea realizar, llena correctamente todos los datos en el formulario
											asociado a la pr&aacute;ctica y finalmente escoge entre ejecutarla de manera
											simulada o real. </p>
										<p>Los datos de las pr&aacute;cticas son recibidos por el Servidor de
											Administraci&oacute;n de Pr&aacute;cticas (SAP) el cual se encarga de
											enviarlo
											al Cliente de Administraci&oacute;n de Pr&aacute;cticas (CAP) de una
											estaci&oacute;n que pueda ejecutarla y se encuentre disponible, en caso de
											todas
											estar ocupadas elige la que menor cola de pr&aacute;cticas por atender
											tenga.
										</p>
										<p>Cuando el pedido llega al Web Services CAP se identifica que tipo de
											pr&aacute;ctica es y dependiendo de esto se elige la forma en que se debe
											procesar, real o simulada. Una vez que la pr&aacute;ctica ha sido procesada
											se
											trasmite el resultado en sentido inverso al que trajo el pedido para que al
											final llegue hasta el usuario. La respuesta es una p&aacute;gina Web que
											muestra
											los resultados del procesamiento y la posibilidad de descargar los datos.
										</p>
									</div>


								</div>
								<div class="blank"></div>
							</div>

						</div>
					</div>

				</div>
				<!-- /.container-fluid -->

			</div>


		</div>
		<!-- /#page-content-wrapper -->

	</div>
	<!-- /#wrapper -->

</body>


<?php require_once('js/libjs.php') ?>
<script src="js/index.js"></script>


</html>





<?php  }  ?>







<?php  if($level == 3){  ?>


<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<?php require_once('css/libcss.php') ?>
	<link rel="stylesheet" href="css/index.css">
	<link href="../admin/css/platform.css" rel="stylesheet" type="text/css" />


</head>




<body>


	<div id="wrapper">
		<div class="overlay"></div>

		<!-- Sidebar -->
		<?php require_once('../../structure/sidebar_estudiante.php') ?>

		<div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>

			<!-- Topbar -->
			<?php require_once('../../structure/navbar_admin.php') ?>

			<div id="content">

				<div id="content2" class="container-fluid p-0 px-lg-0 px-md-0">

					<!-- End of Topbar -->

					<!-- Begin Page Content -->
					<div class="container-fluid px-lg-4 content_g ">
						<div class="row">
							<div id="content3" class="col-md-12 mt-lg-4 mt-4">


								<div class="content_platform">
									<h1 class="content_r_hst1">Sistema de laboratorios a distancia (SLD) </h1>

									<h1 class="content_r_hst2">Publicaciones recientes</h1>
									<div class="content_r_hst3">
										<p>"Remote laboratories for control education: Experience at the universidad del
											B&iacute;o-B&iacute;o"</p>
										<p>IEEE International Conference on Automatica (ICA-ACCA), Oct. 2016.</p>
										<p>DOI: 10.1109/ICA-ACCA.2016.7778444</p>
									</div>


									<h1 class="content_r_hst2">Proyectos asociados</h1>
									<div class="content_r_hst3">
										<p>IenDU No. 100 (DGI-UBB) &laquo;Sistema de pr&aacute;cticas remotas de control
											autom&aacute;tico en tiempo real para la formaci&oacute;n de estudiantes de
											Ingenier&iacute;a Civil en Automatizaci&oacute;n&raquo;</p>
										<p>FAPE No. 135 (DGPE-UBB) &laquo;Tra&iacute;da de un experto en el marco de un
											taller para el desarrollo de un sistema de pr&aacute;cticas remotas de
											control
											autom&aacute;tico en tiempo real para la formaci&oacute;n de estudiantes de
											Ingenier&iacute;a Civil en Automatizaci&oacute;n&raquo;</p>
										<p>FDD-2017 (VA-UBB) &laquo;Manual de teor&iacute;a y pr&aacute;cticas de
											laboratorios utilizando el Sistema de Laboratorios a Distancia implementado
											en
											el Laboratorio de Control del DIEE&raquo;</p>
										<p>FDE-ING2030 (CORFO) &laquo;Macrolaboratorio de formaci&oacute;n conjunta para
											sistemas de control autom&aacute;tico&raquo;</p>

									</div>

									<h1 class="content_r_hst2">Grupos de investigaci&oacute;n</h1>
									<div class="content_r_hst3">
										<p>GARP (UCLV) &laquo;Grupo de Automatizaci&oacute;n Rob&oacute;tice y
											Percepci&oacute;n&raquo;</p>
										<p>SAN (UBB) &laquo;Sensor and Actuator Networks Research Group&raquo;</p>
									</div>


									<h1 class="content_r_hst2">Motivaci&oacute;n</h1>
									<div class="content_r_hst3">
										<p>El ensayo con sistemas reales ha tenido una disminuci&oacute;n en los
											&uacute;ltimos a&ntilde;os y ha sido sustituido por herramientas de
											simulaci&oacute;n, debido principalmente al alto costo, mantenimiento y
											operaci&oacute;n de los laboratorios de pr&aacute;cticas. La
											pr&aacute;cticas
											simuladas, a pesar de presentar grandes ventajas por su facilidad de uso y
											relativo bajo costo, son deficientes en simular el ruido, la respuesta en
											frecuencia, la conversi&oacute;n anal&oacute;gica digital y otros
											fen&oacute;menos que caracterizan a los sistemas reales. En respuesta a este
											inconveniente se ha comenzado a usar Internet como un medio de apoyo a la
											ense&ntilde;anza y de compartir recursos de software y hardware costosos.
											Esto
											ha permitido que se hayan desarrollado laboratorios virtuales y remotos los
											cuales combinan la flexibilidad que ofrecen las simulaciones sin perder las
											caracter&iacute;sticas importantes que rigen a los sistemas f&iacute;sicos.
											Todas estas facilidades permiten experimentar en plantas reales en cualquier
											horario y d&iacute;a, sin necesidad de estar en el laboratorio.</p>
										<p>En el caso de los laboratorios para la ense&ntilde;anza del control
											autom&aacute;tico, la mayor&iacute;a presentan esquemas predefinidos de
											control,
											esto limita a escoger alg&uacute;n tipo de regulador (PI, PID, espacio de
											estado, etc.) y ajustar sus par&aacute;metros para lograr una respuesta
											deseada.
										</p>
										<p>El Dpto. de Autom&aacute;tica y Sistemas Computacionales de la Universidad
											Central Marta Abreu de Las Villas en cooperaci&oacute;n con el Dpto. de
											Autom&aacute;tica, Ingenier&iacute;a Electr&oacute;nica e Inform&aacute;tica
											Industrial de la Universidad Polit&eacute;cnica de Madrid y el Departamento
											de
											Ingenier&iacute;a El&eacute;ctrica y Electr&oacute;nica de la Universidad
											del
											B&iacute;o-B&iacute;o, desarrollaron este Sistema de Laboratorios a
											Distancia
											(SLD) que permite el ensayo de algoritmos de control de forma remota
											v&iacute;a
											Internet. Est&aacute; basado en Matlab/Simulink y se pueden realizar
											pr&aacute;cticas, tanto simuladas como reales, en un entorno Web sin
											necesidad
											de descargar software adicional. En la plataforma desarrollada los usuarios
											pueden realizar pr&aacute;cticas con esquemas predefinidos de control,
											as&iacute; como la creaci&oacute;n de sus propios controladores, usando
											software
											altamente conocido en el medio como lo es Matlab/Simulink.
										</p>
									</div>



									<h1 class="content_r_hst2"> Caracter&iacute;sticas del SLD</h1>
									<div class="content_r_hst3">
										<p>El SLD presenta las siguientes caracter&iacute;sticas: </p>
										<p><strong><em>Disponibilidad</em></strong>: El sistema est&aacute; disponible
											las
											24 horas del d&iacute;a, con su adecuada autoprotecci&oacute;n.</p>
										<p><strong><em>Accesibilidad</em></strong>: El SLD puede ser accedido desde
											cualquier parte del mundo. Para ello solo es necesaria una computadora con
											conexi&oacute;n a Internet y un navegador Web.</p>
										<p><strong><em>Facilidad de uso</em></strong>: Para usar el sistema solo se debe
											tener los conocimientos b&aacute;sicos de la disciplina objeto de
											pr&aacute;cticas.</p>
										<p><strong><em>Interfaz de usuario r&aacute;pida y f&aacute;cil</em></strong>:
											La
											interfaz de usuario del SLD est&aacute; basada en p&aacute;ginas HTML; esto
											permite que los usuarios puedan acceder al sistema de una forma
											r&aacute;pida y
											sin necesidad de descargar o instalar ning&uacute;n software adicional. </p>
										<p><strong><em>Administraci&oacute;n de m&uacute;ltiples pedidos en forma
													paralela</em></strong>: El SLD permite atender m&uacute;ltiples
											pedidos
											de forma paralela administrando de forma centralizada dispositivos similares
											que
											se encuentren geogr&aacute;ficamente separados pero unidos por redes de
											&aacute;rea extensa (WAN).</p>
										<p><strong><em>Desarrollo de controladores de forma remota usando Matlab y
													Simulink</em></strong>: Una de las caracter&iacute;sticas m&aacute;s
											importantes del SLD es que permite a los usuarios dise&ntilde;ar sus propios
											controladores utilizando el ambiente Matlab/Simulink.</p>
										<p><strong><em>Cambio de referencias</em></strong>: El sistema permite cambiar
											las
											referencias de los experimentos para comprobar el desempe&ntilde;o de un
											determinado sistema ante distintas se&ntilde;ales de entrada.
										</p>
									</div>


									<h1 class="content_r_hst2"> Arquitectura del SLD</h1>

									<div class="content_r_hst3">
										<p> El sistema presenta la siguiente arquitectura:</p>
										<p> <img class="img-fluid rounded mx-auto d-block" src="../../img/platform.jpg"
												width="562" height="358" /> </p>
										<p>La interfaz de usuario est&aacute; formada por p&aacute;ginas HTML con
											funcionalidades de PHP para el registro de usuarios y la
											administraci&oacute;n y
											gesti&oacute;n del sitio Web. El sistema tiene una realimentaci&oacute;n
											visual
											en tiempo real con el objetivo de que el usuario tenga informaci&oacute;n de
											la
											ejecuci&oacute;n de las pr&aacute;cticas. El sistema puede ser accedido
											desde
											cualquier computadora con conexi&oacute;n a Internet usado cualquier
											navegador
											para Web.</p>
										<p>El Servidor de Administraci&oacute;n de Pr&aacute;cticas (SAP) se localiza en
											el
											servidor Web y est&aacute; constituido por p&aacute;ginas PHP, lo cual hace
											al
											sistema m&aacute;s portable y seguro, pudiendo ejecutarse este nivel en
											sistemas
											operativos Windows o Linux.</p>
										<p>El otro elemento que conforma el sistema es el Cliente de
											Administraci&oacute;n
											de Pr&aacute;cticas (CAP), el cual se ha implementado con Web Services. El
											CAP
											se encarga de comunicarse con el Matlab/Simulink el cual ejecuta las
											pr&aacute;cticas tanto reales como simuladas. Debido a que la
											comunicaci&oacute;n del Web Services con el Matlab es por COM esto implica
											que
											el sistema operativo de las estaciones de trabajo sea Windows.</p>
										<p>El sistema realiza las pr&aacute;cticas con Matlab/Simulink y el Toolbox Real
											Time Windows Target debido a la facilidad de uso y potentes capacidades de
											este
											software. Real Time Workshop proporciona la conexi&oacute;n en tiempo real
											con
											el sistema de adquisici&oacute;n de datos, mientras que Real Time Windows
											Target
											permite la ejecuci&oacute;n del esquema Simulink en tiempo real sobre
											Windows.
										</p>
									</div>


									<h1 class="content_r_hst2"> Funcionamiento del SLD</h1>

									<div class="content_r_hst3">

										<p>Los usuarios interact&uacute;an con el sistema a trav&eacute;s de Internet.
											Al
											acceder al sitio Web el usuario ingresa con su cuenta, elige la
											pr&aacute;ctica
											que se desea realizar, llena correctamente todos los datos en el formulario
											asociado a la pr&aacute;ctica y finalmente escoge entre ejecutarla de manera
											simulada o real. </p>
										<p>Los datos de las pr&aacute;cticas son recibidos por el Servidor de
											Administraci&oacute;n de Pr&aacute;cticas (SAP) el cual se encarga de
											enviarlo
											al Cliente de Administraci&oacute;n de Pr&aacute;cticas (CAP) de una
											estaci&oacute;n que pueda ejecutarla y se encuentre disponible, en caso de
											todas
											estar ocupadas elige la que menor cola de pr&aacute;cticas por atender
											tenga.
										</p>
										<p>Cuando el pedido llega al Web Services CAP se identifica que tipo de
											pr&aacute;ctica es y dependiendo de esto se elige la forma en que se debe
											procesar, real o simulada. Una vez que la pr&aacute;ctica ha sido procesada
											se
											trasmite el resultado en sentido inverso al que trajo el pedido para que al
											final llegue hasta el usuario. La respuesta es una p&aacute;gina Web que
											muestra
											los resultados del procesamiento y la posibilidad de descargar los datos.
										</p>
									</div>


								</div>
								<div class="blank"></div>
							</div>

						</div>
					</div>

				</div>
				<!-- /.container-fluid -->

			</div>


		</div>
		<!-- /#page-content-wrapper -->

	</div>
	<!-- /#wrapper -->

</body>


<?php require_once('js/libjs.php') ?>
<script src="js/index.js"></script>


</html>



<?php  }  ?>



