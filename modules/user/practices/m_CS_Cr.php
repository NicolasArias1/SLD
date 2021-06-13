<?php
include('../../../config/config.php');
include('../../../inc/db.class.php');
include('../../../inc/user.class.php');
include('../../../inc/useful.fns.php');

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
$ip = '';

if ($level == 1)
	$usrHTML = "<li><a href=\"../../admin/index.php\" class=\"ast3\">Administrar</a></li>";
else if ($level == 2)
	$usrHTML = "<li>Operar</li>";
else if ($level == 3) {
	$usrHTML = "";
}

//Para informaci&oacute;n de las estaciones

//Creando objeto SQL
$sql = new SQL();

//Conectando con el servidor
$sql->SQLConnection();
$pname = "m_CS_Cr"; //nombre de pr&aacute;ctica real actual

// Direccion IP de la estacion
$query = "SELECT ip, state, pcount FROM sld_stations WHERE (practices='" . $pname . "' OR practices LIKE '" . $pname . ";%' OR practices LIKE '%;" . $pname . ";%' OR practices LIKE '%;" . $pname . "') AND state!='off'";

//Ejecutando consulta
$result = $sql->SQLQuery($query);

if (is_array($result)) {
	$cantidad = count($result);
	for ($i = 0, $j = 0; $i < count($result); $i++) {
		if ($result[$i]['state'] == 'wait') {
			$wip[$j] = $result[$i]['ip'];
			$j++;
		} //end if
		$pcount[$result[$i]['ip']] = $result[$i]['pcount'];
	} //end for

	$cantfree = count($wip);
	if ($wip) {
		shuffle($wip);
		$ip = $wip[0]; //si hay estaciones libre, realiza un barajeo y coge una
	} //end if
	else {
		rsort($pcount);	//si no hay estaciones libres busca la peor		
		reset($pcount);
		$bip = key($pcount);
		$ip = $bip;
	} //end else
} //end if
else
	$cantidad = 0;

$timeejec = (isset($pcount[$ip]) * 2) + 2;

//Restriccion por tiempo
$permbytime = 1; // activo todo el tiempo, para limitar poner a 0 y cambiar horas debajo
$hora = Date('H');
$diaweek = Date('w');
if ($hora >= 9 && $hora < 21 && $diaweek > 0 && $diaweek < 6) {
	$permbytime = 1;
}


?>




<!-- Realiza práctica desde perfil admin. -->
<?php if ($level == 1) {  ?>


	<!doctype html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php require_once('../../../modules/admin/css/libcss.php') ?>
		<link rel="stylesheet" href="../../../modules/admin/css/index.css">
		<link rel="stylesheet" href="../css/m_cs.css">
		<script language="JavaScript" src="../../../js/sld.js" type="text/javascript"></script>
	</head>

	<body>
		<div id="wrapper">
			<?php require_once('../../../structure/spinner.php') ?>

			<div class="overlay"></div>

			<?php require_once('../../../structure/sidebar_practices.php') ?>

			<div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>

				<?php require_once('../../../structure/navbar_practices.php') ?>

				<div class="container-fluid p-0 px-lg-0 px-md-0">
					<div class="container-fluid px-lg-4 content_g ">
						<div class="row">
							<div id="content3" class="col-md-12 mt-lg-4 mt-4">
								<div class="content_practices">

									<h1 class="content_r_hst1">Control de Velocidad y Posici&oacute;n</h1>
									<div class="contentp">
										<p>A continuaci&oacute;n se muestra el esquema que se ejecutar&aacute; para la
											realizaci&oacute;n de esta experiencia:</p>
										<img src="../../../img/CS_C.jpg" class="img-fluid rounded mx-auto d-block mbotom" />
										<p>En esta pr&aacute;ctica usted podr&aacute; dise&ntilde;ar la estrategia de
											control y poner la referencia deseada.
											Para ello dispone de la medici&oacute;n de la velocidad y la posici&oacute;n
											as&iacute; como la salida de control.
											Para evaluar el algoritmo y los resultados puede mostrar las se&ntilde;ales que
											desee mediante tres graficadores auxiliares.
											Puede poner un tiempo de ejecuci&oacute;n de hasta 60 segundos y el
											per&iacute;odo de muestreo en el rango de 0.001s a 1s.</p>
										<p>Descarge el modelo virtual de la planta, programe el Controlador y salve el
											modelo modificado. Luego debe subirlo a la plataforma pulsando Examinar y
											pulsando Ejecutar obtendr&aacute; el comportamiento del sistema real.</p>
										<p>Opcionalmente puede subir un .mat en el que puede ir, por ejemplo, la referencia
											u otras constantes que se necesten en el bloque Controlador. La referencia puede
											generarla, guardarla en el .mat y, dentro del bloque controlador, cargarla con
											un FromWorkspace.</p>
										<p>Importante:</p>
										<ol>
											<li>El modelo que se descarga es un .mdl Simulink Versi&oacute;n 7.5 (R2010a).
												<b>Si usted utiliza una versi&oacute;n inferior, puede que no le sea
													compatible</b>.
											</li>
											<li>S&oacute;lo debe modificar el interior del subsistema
												&quot;Controlador&quot; <b>sin alterar su nombre ni sus conexiones de
													entrada y salida</b>.</li>
											<li>El modelo que se env&iacute;e tiene que ser en <b>.mdl Simulink
													Versi&oacute;n 8.4 (R2014b) o inferior</b>. Si usted utiliza una
												versi&oacute;n superior s&aacute;lvelo con la opci&oacute;n Export Model to
												Previous Version.</li>
										</ol>

										<p style="margin-bottom:40px;">La duraci&oacute;n del ensayo depender&aacute; del
											tiempo de ejecuci&oacute;n ajustado en el modelo de
											Simulink.<?php if ($cantidad) echo "	En estos momentos hay $cantidad estacion(es) que puede(n) ejecutar esta pr&aacute;ctica."; ?>
										</p>

										<?php
										if ($cantidad) {
											echo '<h1 class="content_r_hst2">	Hay estaciones libres para ejecutar esta pr&aacute;ctica de forma REAL.</h1>';
										} else {
											echo '<h1 class="content_r_hst2">	Lo sentimos, no hay estaciones que puedan ejecutar esta pr&aacute;ctica de forma REAL. Por favor pruebe en otro momento.</h1>';
										}
										?>

										<div class="row justify-content-center mt-5">
											<div class="col-sm-9 paramFic">

												<form name="down" action="../../../download/downloadcs.php " method="post" enctype="multipart/form-data">
													<div class="form-group row">
														<label class="col-sm-6 col-form-label content_r_hst6" style="font-size:13px;">Descargar el fichero .mdl:</label>
														<div class="col-sm-6">
															<input type="submit" name="Submit" value="Descargar" class="input_btn2" />
														</div>
													</div>
												</form>
												<form id="practice" name="practice" action="../client.php" method="post" enctype="multipart/form-data">
													<div class="form-group row" style="margin-top:20px;">
														<label class="col-sm-6 col-form-label content_r_hst6" style="font-size:13px;">Fichero Simulink en .mdl:</label>
														<div class="col-sm-6">
															<input name="filemdl" type="file" size="15" value="0.08" class="form-control " style="font-size:12px;" />
														</div>
													</div>
													<div class="form-group row" style="margin-top:20px;">
														<label class="col-sm-6 col-form-label content_r_hst6" style="font-size:13px;">Fichero .mat (opcional):</label>
														<div class="col-sm-6">
															<input name="filemat" type="file" size="15" value="0.08" class="form-control " style="font-size:12px;" />
														</div>
													</div>

													<div class="form-group row" style="margin-top:20px;">
														<div class="col-sm-12" style="text-align:center;">
															<input type="hidden" id="mlmfile" name="mlmfile" value="m_CS_Cs">
															<input id="execute-button" type="button" name="Submit" value="Ejecutar" <?php if (($cantidad == 0) || ($timeejec > 5) || ($permbytime == 0)) echo 'disabled= "disabled"'; ?> class="input_btn3" onClick="execute('m_CS_Cr')" />
														</div>
													</div>

												</form>




											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
	</body>

	<?php require_once('../../../modules/admin/js/libjs.php') ?>
	<script src="../../../modules/admin/js/index.js"></script>

	</html>



<?php  }  ?>


<!-- Realiza práctica desde perfil profe. -->
<?php if ($level == 2) {  ?>


	<!doctype html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php require_once('../../../modules/admin/css/libcss.php') ?>
		<link rel="stylesheet" href="../../../modules/admin/css/index.css">
		<link rel="stylesheet" href="../css/m_cs.css">
		<script language="JavaScript" src="../../../js/sld.js" type="text/javascript"></script>
	</head>

	<body>
		<div id="wrapper">
			<?php require_once('../../../structure/spinner.php') ?>

			<div class="overlay"></div>

			<?php require_once('../../../structure/sidebar_practice_profesor.php') ?>

			<div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>

				<?php require_once('../../../structure/navbar_practices.php') ?>

				<div class="container-fluid p-0 px-lg-0 px-md-0">
					<div class="container-fluid px-lg-4 content_g ">
						<div class="row">
							<div id="content3" class="col-md-12 mt-lg-4 mt-4">
								<div class="content_practices">

									<h1 class="content_r_hst1">Control de Velocidad y Posici&oacute;n</h1>
									<div class="contentp">
										<p>A continuaci&oacute;n se muestra el esquema que se ejecutar&aacute; para la
											realizaci&oacute;n de esta experiencia:</p>
										<img src="../../../img/CS_C.jpg" class="img-fluid rounded mx-auto d-block mbotom" />
										<p>En esta pr&aacute;ctica usted podr&aacute; dise&ntilde;ar la estrategia de
											control y poner la referencia deseada.
											Para ello dispone de la medici&oacute;n de la velocidad y la posici&oacute;n
											as&iacute; como la salida de control.
											Para evaluar el algoritmo y los resultados puede mostrar las se&ntilde;ales que
											desee mediante tres graficadores auxiliares.
											Puede poner un tiempo de ejecuci&oacute;n de hasta 60 segundos y el
											per&iacute;odo de muestreo en el rango de 0.001s a 1s.</p>
										<p>Descarge el modelo virtual de la planta, programe el Controlador y salve el
											modelo modificado. Luego debe subirlo a la plataforma pulsando Examinar y
											pulsando Ejecutar obtendr&aacute; el comportamiento del sistema real.</p>
										<p>Opcionalmente puede subir un .mat en el que puede ir, por ejemplo, la referencia
											u otras constantes que se necesten en el bloque Controlador. La referencia puede
											generarla, guardarla en el .mat y, dentro del bloque controlador, cargarla con
											un FromWorkspace.</p>
										<p>Importante:</p>
										<ol>
											<li>El modelo que se descarga es un .mdl Simulink Versi&oacute;n 7.5 (R2010a).
												<b>Si usted utiliza una versi&oacute;n inferior, puede que no le sea
													compatible</b>.
											</li>
											<li>S&oacute;lo debe modificar el interior del subsistema
												&quot;Controlador&quot; <b>sin alterar su nombre ni sus conexiones de
													entrada y salida</b>.</li>
											<li>El modelo que se env&iacute;e tiene que ser en <b>.mdl Simulink
													Versi&oacute;n 8.4 (R2014b) o inferior</b>. Si usted utiliza una
												versi&oacute;n superior s&aacute;lvelo con la opci&oacute;n Export Model to
												Previous Version.</li>
										</ol>

										<p style="margin-bottom:40px;">La duraci&oacute;n del ensayo depender&aacute; del
											tiempo de ejecuci&oacute;n ajustado en el modelo de
											Simulink.<?php if ($cantidad) echo "	En estos momentos hay $cantidad estacion(es) que puede(n) ejecutar esta pr&aacute;ctica."; ?>
										</p>

										<?php
										if ($cantidad) {
											echo '<h1 class="content_r_hst2">	Hay estaciones libres para ejecutar esta pr&aacute;ctica de forma REAL.</h1>';
										} else {
											echo '<h1 class="content_r_hst2">	Lo sentimos, no hay estaciones que puedan ejecutar esta pr&aacute;ctica de forma REAL. Por favor pruebe en otro momento.</h1>';
										}
										?>
										
										<div class="row justify-content-center mt-5">
											<div class="col-sm-9 paramFic">

												<form name="down" action="../../../download/downloadcs.php " method="post" enctype="multipart/form-data">
													<div class="form-group row">
														<label class="col-sm-6 col-form-label content_r_hst6" style="font-size:13px;">Descargar el fichero .mdl:</label>
														<div class="col-sm-6">
															<input type="submit" name="Submit" value="Descargar" class="input_btn2" />
														</div>
													</div>
												</form>
												<form id="practice" name="practice" action="../client.php" method="post" enctype="multipart/form-data">
													<div class="form-group row" style="margin-top:20px;">
														<label class="col-sm-6 col-form-label content_r_hst6" style="font-size:13px;">Fichero Simulink en .mdl:</label>
														<div class="col-sm-6">
															<input name="filemdl" type="file" size="15" value="0.08" class="form-control " style="font-size:12px;" />
														</div>
													</div>
													<div class="form-group row" style="margin-top:20px;">
														<label class="col-sm-6 col-form-label content_r_hst6" style="font-size:13px;">Fichero .mat (opcional):</label>
														<div class="col-sm-6">
															<input name="filemat" type="file" size="15" value="0.08" class="form-control " style="font-size:12px;" />
														</div>
													</div>

													<div class="form-group row" style="margin-top:20px;">
														<div class="col-sm-12" style="text-align:center;">
															<input type="hidden" id="mlmfile" name="mlmfile" value="m_CS_Cs">
															<input id="execute-button" type="button" name="Submit" value="Ejecutar" <?php if (($cantidad == 0) || ($timeejec > 5) || ($permbytime == 0)) echo 'disabled= "disabled"'; ?> class="input_btn3" onClick="execute('m_CS_Cr')" />
														</div>
													</div>

												</form>




											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
	</body>

	<?php require_once('../../../modules/admin/js/libjs.php') ?>
	<script src="../../../modules/admin/js/index.js"></script>

	</html>






<?php  }  ?>



<!-- Realiza práctica desde perfil estudiante. -->
<?php if ($level == 3) {  ?>



	<!doctype html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php require_once('../../../modules/admin/css/libcss.php') ?>
		<link rel="stylesheet" href="../../../modules/admin/css/index.css">
		<link rel="stylesheet" href="../css/m_cs.css">
		<script language="JavaScript" src="../../../js/sld.js" type="text/javascript"></script>
	</head>

	<body>
		<div id="wrapper">
			<?php require_once('../../../structure/spinner.php') ?>

			<div class="overlay"></div>

			<?php require_once('../../../structure/sidebar_practice_estudiante.php') ?>

			<div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>

				<?php require_once('../../../structure/navbar_practices.php') ?>

				<div class="container-fluid p-0 px-lg-0 px-md-0">
					<div class="container-fluid px-lg-4 content_g ">
						<div class="row">
							<div id="content3" class="col-md-12 mt-lg-4 mt-4">
								<div class="content_practices">

									<h1 class="content_r_hst1">Control de Velocidad y Posici&oacute;n</h1>
									<div class="contentp">
										<p>A continuaci&oacute;n se muestra el esquema que se ejecutar&aacute; para la
											realizaci&oacute;n de esta experiencia:</p>
										<img src="../../../img/CS_C.jpg" class="img-fluid rounded mx-auto d-block mbotom" />
										<p>En esta pr&aacute;ctica usted podr&aacute; dise&ntilde;ar la estrategia de
											control y poner la referencia deseada.
											Para ello dispone de la medici&oacute;n de la velocidad y la posici&oacute;n
											as&iacute; como la salida de control.
											Para evaluar el algoritmo y los resultados puede mostrar las se&ntilde;ales que
											desee mediante tres graficadores auxiliares.
											Puede poner un tiempo de ejecuci&oacute;n de hasta 60 segundos y el
											per&iacute;odo de muestreo en el rango de 0.001s a 1s.</p>
										<p>Descarge el modelo virtual de la planta, programe el Controlador y salve el
											modelo modificado. Luego debe subirlo a la plataforma pulsando Examinar y
											pulsando Ejecutar obtendr&aacute; el comportamiento del sistema real.</p>
										<p>Opcionalmente puede subir un .mat en el que puede ir, por ejemplo, la referencia
											u otras constantes que se necesten en el bloque Controlador. La referencia puede
											generarla, guardarla en el .mat y, dentro del bloque controlador, cargarla con
											un FromWorkspace.</p>
										<p>Importante:</p>
										<ol>
											<li>El modelo que se descarga es un .mdl Simulink Versi&oacute;n 7.5 (R2010a).
												<b>Si usted utiliza una versi&oacute;n inferior, puede que no le sea
													compatible</b>.
											</li>
											<li>S&oacute;lo debe modificar el interior del subsistema
												&quot;Controlador&quot; <b>sin alterar su nombre ni sus conexiones de
													entrada y salida</b>.</li>
											<li>El modelo que se env&iacute;e tiene que ser en <b>.mdl Simulink
													Versi&oacute;n 8.4 (R2014b) o inferior</b>. Si usted utiliza una
												versi&oacute;n superior s&aacute;lvelo con la opci&oacute;n Export Model to
												Previous Version.</li>
										</ol>

										<p style="margin-bottom:40px;">La duraci&oacute;n del ensayo depender&aacute; del
											tiempo de ejecuci&oacute;n ajustado en el modelo de
											Simulink.<?php if ($cantidad) echo "	En estos momentos hay $cantidad estacion(es) que puede(n) ejecutar esta pr&aacute;ctica."; ?>
										</p>

										<?php
										if ($cantidad) {
											echo '<h1 class="content_r_hst2">	Hay estaciones libres para ejecutar esta pr&aacute;ctica de forma REAL.</h1>';
										} else {
											echo '<h1 class="content_r_hst2">	Lo sentimos, no hay estaciones que puedan ejecutar esta pr&aacute;ctica de forma REAL. Por favor pruebe en otro momento.</h1>';
										}
										?>

										<div class="row justify-content-center mt-5">
											<div class="col-sm-9 paramFic">

												<form name="down" action="../../../download/downloadcs.php " method="post" enctype="multipart/form-data">
													<div class="form-group row">
														<label class="col-sm-6 col-form-label content_r_hst6" style="font-size:13px;">Descargar el fichero .mdl:</label>
														<div class="col-sm-6">
															<input type="submit" name="Submit" value="Descargar" class="input_btn2" />
														</div>
													</div>
												</form>
												<form id="practice" name="practice" action="../client.php" method="post" enctype="multipart/form-data">
													<div class="form-group row" style="margin-top:20px;">
														<label class="col-sm-6 col-form-label content_r_hst6" style="font-size:13px;">Fichero Simulink en .mdl:</label>
														<div class="col-sm-6">
															<input name="filemdl" type="file" size="15" value="0.08" class="form-control " style="font-size:12px;" />
														</div>
													</div>
													<div class="form-group row" style="margin-top:20px;">
														<label class="col-sm-6 col-form-label content_r_hst6" style="font-size:13px;">Fichero .mat (opcional):</label>
														<div class="col-sm-6">
															<input name="filemat" type="file" size="15" value="0.08" class="form-control " style="font-size:12px;" />
														</div>
													</div>

													<div class="form-group row" style="margin-top:20px;">
														<div class="col-sm-12" style="text-align:center;">
															<input type="hidden" id="mlmfile" name="mlmfile" value="m_CS_Cs">
															<input id="execute-button" type="button" name="Submit" value="Ejecutar" <?php if (($cantidad == 0) || ($timeejec > 5) || ($permbytime == 0)) echo 'disabled= "disabled"'; ?> class="input_btn3" onClick="execute('m_CS_Cr')" />
														</div>
													</div>

												</form>




											</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
	</body>

	<?php require_once('../../../modules/admin/js/libjs.php') ?>
	<script src="../../../modules/admin/js/index.js"></script>

	</html>





<?php  }  ?>

<script>
	var executeButton = document.getElementById("execute-button");

	executeButton.addEventListener("click", function() {
		var spinner = document.getElementById("spinner-container");
		spinner.style.display = "block";
	});
</script>