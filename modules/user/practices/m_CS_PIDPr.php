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
$pname = "m_CS_PIDPr"; //nombre de pr&aacute;ctica real actual

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

									<h1 class="content_r_hst1">Ajuste de PID para control de posici&oacute;n</h1>
									<div class="contentp">
										<p>A continuaci&oacute;n se muestra el esquema empleado para controlar la
											posici&oacute;n durante 10 segundos. La posici&oacute;n deseada comienza en -50
											grados y a los 5 segundos pasa a 50 grados:</p>
										<img src="../../../img/CS_PIDP.jpg" class="img-fluid rounded mx-auto d-block mbotom" />
										<p>El controlador PID implementado se corresponde con el siguiente diagrama en
											bloques:</p>
										<img src="../../../img/CS_PIDP_PID.jpg" class="img-fluid rounded mx-auto d-block mbotom" />
										<p>N&oacute;tese que el PID responde a la estructura paralela: man = P + I/s + Ds.
											Los valores P, I y D son las constantes proporcional, integral y derivativa
											respectivamente, Tm es el per&iacute;odo de muestreo, Kb la constante de
											realimentaci&oacute;n de la diferencia entre el mando calculado y el saturado
											para eliminar el windup y N la frecuencia de corte en rad/segundos del filtro
											derivativo de primero orden (N=2*pi*Fcd).</p>
										<p style="margin-bottom:40px;">En este experimento se pueden modificar los
											par&aacute;metros antes mencionados del PID as&iacute; como el orden y
											frecuencia de corte del filtro (Butterworth) de posici&oacute;n.</p>

										<?php
										if ($cantidad) {
											echo '<h1 class="content_r_hst2">	Hay estaciones libres para ejecutar esta pr&aacute;ctica de forma REAL.</h1>';
										} else {
											echo '<h1 class="content_r_hst2">	Lo sentimos, no hay estaciones que puedan ejecutar esta pr&aacute;ctica de forma REAL. Por favor pruebe en otro momento.</h1>';
										}
										?>

										<form id="practice" name="practice" action="../client.php" method="post" enctype="multipart/form-data">
											<div class="row" style="margin-top:30px;">
												<div class="col-sm-6 paramExp">
													<h1 class="content_r_hst6" style="margin:0; margin-bottom:20px;">
														Par&aacute;metros para el experimento:
													</h1>
													<hr>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Tm:</label>
														<div class="col-sm-8">
															<input name="Tm" type="text" value="0.5" size="15" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">P:</label>
														<div class="col-sm-8">
															<input name="P" type="text" size="15" value="0.1" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">I:</label>
														<div class="col-sm-8">
															<input name="I" type="text" size="15" value="0" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">D:</label>
														<div class="col-sm-8">
															<input name="D" type="text" size="15" value="0" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Kb:</label>
														<div class="col-sm-8">
															<input name="Kb" type="text" size="15" value="0" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Fcd:</label>
														<div class="col-sm-8">
															<input name="Fcd" type="text" size="15" value="1" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">SW:</label>
														<div class="col-sm-8">
															<input name="SW" type="text" size="15" value="0" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Np:</label>
														<div class="col-sm-8">
															<input name="Np" type="text" size="15" value="1" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Fcp:</label>
														<div class="col-sm-8">
															<input name="Fcp" type="text" size="15" value="0.1" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<div class="col-sm-8">
															<input type="hidden" id="mlmfile" name="mlmfile" value="m_CS_PIDPs" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<div class="col-sm-8" style="text-align:center;">
															<input id="execute-button" type="button" name="Submit" value="Ejecutar" <?php if (($cantidad == 0) || ($timeejec > 5) || ($permbytime == 0)) echo 'disabled= "disabled"'; ?> class="input_btn1" onClick="execute('m_CS_PIDPr')" />
														</div>
													</div>




												</div>

												<div class="col-sm-5 paramSim">
													<h1 class="content_r_hst6" style="margin:0;">Simbolog&iacute;a:</h1>
													<hr>
													<table class="table table-borderless">
														<tbody class="tbodyA">
															<tr>
																<td>Tm:</td>
																<td>Per&iacute;odo de muestreo (0.001<=Tm[s]<=1).< /td>
															</tr>
															<tr>
																<td> P:</td>
																<td> Ganancia proporcional.</td>
															</tr>
															<tr>
																<td>I:</td>
																<td>Ganancia integral.</td>
															</tr>

															<tr>
																<td>D:</td>
																<td>Ganancia derivativa.</td>
															</tr>
															<tr>
																<td>Kb:</td>
																<td>Ganancia anti-windup.</td>
															</tr>
															<tr>
																<td>Fcd:</td>
																<td>Frecuencia de corte (Hz).</td>
															</tr>
															<tr>
																<td>SW:</td>
																<td>Selector del Filtro de la medici&oacute;n (0:No, 1:Si).
																</td>
															</tr>
															<tr>
																<td>Np:</td>
																<td>Orden del Filtro de la medici&oacute;n.</td>
															</tr>
															<tr>
																<td>Fcp:</td>
																<td>Frecuencia de corte del Filtro de la medici&oacute;n
																	(Fc[Hz]&lt;Fm/2).</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>

										</form>
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

									<h1 class="content_r_hst1">Ajuste de PID para control de posici&oacute;n</h1>
									<div class="contentp">
										<p>A continuaci&oacute;n se muestra el esquema empleado para controlar la
											posici&oacute;n durante 10 segundos. La posici&oacute;n deseada comienza en -50
											grados y a los 5 segundos pasa a 50 grados:</p>
										<img src="../../../img/CS_PIDP.jpg" class="img-fluid rounded mx-auto d-block mbotom" />
										<p>El controlador PID implementado se corresponde con el siguiente diagrama en
											bloques:</p>
										<img src="../../../img/CS_PIDP_PID.jpg" class="img-fluid rounded mx-auto d-block mbotom" />
										<p>N&oacute;tese que el PID responde a la estructura paralela: man = P + I/s + Ds.
											Los valores P, I y D son las constantes proporcional, integral y derivativa
											respectivamente, Tm es el per&iacute;odo de muestreo, Kb la constante de
											realimentaci&oacute;n de la diferencia entre el mando calculado y el saturado
											para eliminar el windup y N la frecuencia de corte en rad/segundos del filtro
											derivativo de primero orden (N=2*pi*Fcd).</p>
										<p style="margin-bottom:40px;">En este experimento se pueden modificar los
											par&aacute;metros antes mencionados del PID as&iacute; como el orden y
											frecuencia de corte del filtro (Butterworth) de posici&oacute;n.</p>

										<?php
										if ($cantidad) {
											echo '<h1 class="content_r_hst2">	Hay estaciones libres para ejecutar esta pr&aacute;ctica de forma REAL.</h1>';
										} else {
											echo '<h1 class="content_r_hst2">	Lo sentimos, no hay estaciones que puedan ejecutar esta pr&aacute;ctica de forma REAL. Por favor pruebe en otro momento.</h1>';
										}
										?>

										<form id="practice" name="practice" action="../client.php" method="post" enctype="multipart/form-data">
											<div class="row" style="margin-top:30px;">
												<div class="col-sm-6 paramExp">
													<h1 class="content_r_hst6" style="margin:0; margin-bottom:20px;">
														Par&aacute;metros para el experimento:
													</h1>
													<hr>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Tm:</label>
														<div class="col-sm-8">
															<input name="Tm" type="text" value="0.5" size="15" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">P:</label>
														<div class="col-sm-8">
															<input name="P" type="text" size="15" value="0.1" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">I:</label>
														<div class="col-sm-8">
															<input name="I" type="text" size="15" value="0" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">D:</label>
														<div class="col-sm-8">
															<input name="D" type="text" size="15" value="0" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Kb:</label>
														<div class="col-sm-8">
															<input name="Kb" type="text" size="15" value="0" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Fcd:</label>
														<div class="col-sm-8">
															<input name="Fcd" type="text" size="15" value="1" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">SW:</label>
														<div class="col-sm-8">
															<input name="SW" type="text" size="15" value="0" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Np:</label>
														<div class="col-sm-8">
															<input name="Np" type="text" size="15" value="1" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Fcp:</label>
														<div class="col-sm-8">
															<input name="Fcp" type="text" size="15" value="0.1" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<div class="col-sm-8">
															<input type="hidden" id="mlmfile" name="mlmfile" value="m_CS_PIDPs" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<div class="col-sm-8" style="text-align:center;">
															<input id="execute-button" type="button" name="Submit" value="Ejecutar" <?php if (($cantidad == 0) || ($timeejec > 5) || ($permbytime == 0)) echo 'disabled= "disabled"'; ?> class="input_btn1" onClick="execute('m_CS_PIDPr')" />
														</div>
													</div>




												</div>

												<div class="col-sm-5 paramSim">
													<h1 class="content_r_hst6" style="margin:0;">Simbolog&iacute;a:</h1>
													<hr>
													<table class="table table-borderless">
														<tbody class="tbodyA">
															<tr>
																<td>Tm:</td>
																<td>Per&iacute;odo de muestreo (0.001<=Tm[s]<=1).< /td>
															</tr>
															<tr>
																<td> P:</td>
																<td> Ganancia proporcional.</td>
															</tr>
															<tr>
																<td>I:</td>
																<td>Ganancia integral.</td>
															</tr>

															<tr>
																<td>D:</td>
																<td>Ganancia derivativa.</td>
															</tr>
															<tr>
																<td>Kb:</td>
																<td>Ganancia anti-windup.</td>
															</tr>
															<tr>
																<td>Fcd:</td>
																<td>Frecuencia de corte (Hz).</td>
															</tr>
															<tr>
																<td>SW:</td>
																<td>Selector del Filtro de la medici&oacute;n (0:No, 1:Si).
																</td>
															</tr>
															<tr>
																<td>Np:</td>
																<td>Orden del Filtro de la medici&oacute;n.</td>
															</tr>
															<tr>
																<td>Fcp:</td>
																<td>Frecuencia de corte del Filtro de la medici&oacute;n
																	(Fc[Hz]&lt;Fm/2).</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>

										</form>
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

									<h1 class="content_r_hst1">Ajuste de PID para control de posici&oacute;n</h1>
									<div class="contentp">
										<p>A continuaci&oacute;n se muestra el esquema empleado para controlar la
											posici&oacute;n durante 10 segundos. La posici&oacute;n deseada comienza en -50
											grados y a los 5 segundos pasa a 50 grados:</p>
										<img src="../../../img/CS_PIDP.jpg" class="img-fluid rounded mx-auto d-block mbotom" />
										<p>El controlador PID implementado se corresponde con el siguiente diagrama en
											bloques:</p>
										<img src="../../../img/CS_PIDP_PID.jpg" class="img-fluid rounded mx-auto d-block mbotom" />
										<p>N&oacute;tese que el PID responde a la estructura paralela: man = P + I/s + Ds.
											Los valores P, I y D son las constantes proporcional, integral y derivativa
											respectivamente, Tm es el per&iacute;odo de muestreo, Kb la constante de
											realimentaci&oacute;n de la diferencia entre el mando calculado y el saturado
											para eliminar el windup y N la frecuencia de corte en rad/segundos del filtro
											derivativo de primero orden (N=2*pi*Fcd).</p>
										<p style="margin-bottom:40px;">En este experimento se pueden modificar los
											par&aacute;metros antes mencionados del PID as&iacute; como el orden y
											frecuencia de corte del filtro (Butterworth) de posici&oacute;n.</p>

										<?php
										if ($cantidad) {
											echo '<h1 class="content_r_hst2">	Hay estaciones libres para ejecutar esta pr&aacute;ctica de forma REAL.</h1>';
										} else {
											echo '<h1 class="content_r_hst2">	Lo sentimos, no hay estaciones que puedan ejecutar esta pr&aacute;ctica de forma REAL. Por favor pruebe en otro momento.</h1>';
										}
										?>

										<form id="practice" name="practice" action="../client.php" method="post" enctype="multipart/form-data">
											<div class="row" style="margin-top:30px;">
												<div class="col-sm-6 paramExp">
													<h1 class="content_r_hst6" style="margin:0; margin-bottom:20px;">
														Par&aacute;metros para el experimento:
													</h1>
													<hr>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Tm:</label>
														<div class="col-sm-8">
															<input name="Tm" type="text" value="0.5" size="15" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">P:</label>
														<div class="col-sm-8">
															<input name="P" type="text" size="15" value="0.1" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">I:</label>
														<div class="col-sm-8">
															<input name="I" type="text" size="15" value="0" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">D:</label>
														<div class="col-sm-8">
															<input name="D" type="text" size="15" value="0" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Kb:</label>
														<div class="col-sm-8">
															<input name="Kb" type="text" size="15" value="0" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Fcd:</label>
														<div class="col-sm-8">
															<input name="Fcd" type="text" size="15" value="1" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">SW:</label>
														<div class="col-sm-8">
															<input name="SW" type="text" size="15" value="0" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Np:</label>
														<div class="col-sm-8">
															<input name="Np" type="text" size="15" value="1" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Fcp:</label>
														<div class="col-sm-8">
															<input name="Fcp" type="text" size="15" value="0.1" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<div class="col-sm-8">
															<input type="hidden" id="mlmfile" name="mlmfile" value="m_CS_PIDPs" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<div class="col-sm-8" style="text-align:center;">
															<input id="execute-button" type="button" name="Submit" value="Ejecutar" <?php if (($cantidad == 0) || ($timeejec > 5) || ($permbytime == 0)) echo 'disabled= "disabled"'; ?> class="input_btn1" onClick="execute('m_CS_PIDPr')" />
														</div>
													</div>




												</div>

												<div class="col-sm-5 paramSim">
													<h1 class="content_r_hst6" style="margin:0;">Simbolog&iacute;a:</h1>
													<hr>
													<table class="table table-borderless">
														<tbody class="tbodyA">
															<tr>
																<td>Tm:</td>
																<td>Per&iacute;odo de muestreo (0.001<=Tm[s]<=1).< /td>
															</tr>
															<tr>
																<td> P:</td>
																<td> Ganancia proporcional.</td>
															</tr>
															<tr>
																<td>I:</td>
																<td>Ganancia integral.</td>
															</tr>

															<tr>
																<td>D:</td>
																<td>Ganancia derivativa.</td>
															</tr>
															<tr>
																<td>Kb:</td>
																<td>Ganancia anti-windup.</td>
															</tr>
															<tr>
																<td>Fcd:</td>
																<td>Frecuencia de corte (Hz).</td>
															</tr>
															<tr>
																<td>SW:</td>
																<td>Selector del Filtro de la medici&oacute;n (0:No, 1:Si).
																</td>
															</tr>
															<tr>
																<td>Np:</td>
																<td>Orden del Filtro de la medici&oacute;n.</td>
															</tr>
															<tr>
																<td>Fcp:</td>
																<td>Frecuencia de corte del Filtro de la medici&oacute;n
																	(Fc[Hz]&lt;Fm/2).</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>

										</form>
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