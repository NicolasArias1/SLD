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
$pname = "m_CS_FILr"; //nombre de pr&aacute;ctica real actual

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
		<script language="JavaScript" src="../../../js/sld.js" type="text/javascript"></script>
		<link rel="stylesheet" href="../../../modules/admin/css/index.css">
		<link rel="stylesheet" href="../css/m_cs.css">

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
									<h1 class="content_r_hst1">Ajuste de los filtros para las mediciones</h1>
									<div class="contentp">
										<img src="../../../img/CS_FIL.jpg" class="img-fluid rounded mx-auto d-block mbotom" />
										<p>El experimento tendr&aacute; una duraci&oacute;n de 10 segundos. Se comienza
											aplicando un
											voltaje de -5V al motor y a los 5 segundos de pasa a +5V. </p>
										<p>Se puede modificar el per&iacute;odo de muestreo, y el orden y frecuencia de
											corte de los
											filtros (Butterworth) de velocidad y posici&oacute;n.</p>
										<p style="margin-bottom:40px;">Nota: El video tiene un retardo de 10 segundos
											aproximadamente.</p>
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
														<label class="col-sm-2 col-form-label">Nv:</label>
														<div class="col-sm-8">
															<input name="Nv" type="text" size="15" value="1" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Fcv:</label>
														<div class="col-sm-8">
															<input name="Fcv" type="text" value="0.1" size="15" class="form-control">
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
															<input type="hidden" id="mlmfile" name="mlmfile" value="m_CS_FILs" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<div class="col-sm-8" style="text-align:center;">
															<input id="execute-button" type="button" name="Submit" value="Ejecutar" <?php if (($cantidad == 0) || ($timeejec > 5) || ($permbytime == 0)) echo 'disabled= "disabled"'; ?> class="input_btn1" onClick="execute('m_CS_FILr')" />
														</div>
													</div>

												</div>
												<div class="col-sm-5 paramSim">
													<h1 class="content_r_hst6" style="margin:0;">Simbolog&iacute;a:</h1>
													<hr>

													<table width="100%" cellpadding="0" cellspacing="0" class="table table-borderless">
														<tbody class="tbodyA">
															<tr>
																<td>Tm:</td>
																<td>Per&iacute;odo de muestreo (0.001
																	<=Tm[s]<=1).< /td>
															</tr>
															<tr>
																<td>Nv:</td>
																<td>Orden del Filtro de velocidad</td>
															</tr>
															<tr>
																<td>Fcv:</td>
																<td>Frecuencia de corte (Fc[Hz]&lt;Fm/2)</td>
															</tr>
															<tr>
																<td>Np:</td>
																<td>Orden del Filtro de posici&oacute;n</td>
															</tr>
															<tr>
																<td>Fcp:</td>
																<td>Frecuencia de corte (Fc[Hz]&lt;Fm/2)</td>
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
		<script language="JavaScript" src="../../../js/sld.js" type="text/javascript"></script>
		<link rel="stylesheet" href="../../../modules/admin/css/index.css">
		<link rel="stylesheet" href="../css/m_cs.css">

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
									<h1 class="content_r_hst1">Ajuste de los filtros para las mediciones</h1>
									<div class="contentp">
										<img src="../../../img/CS_FIL.jpg" class="img-fluid rounded mx-auto d-block mbotom" />
										<p>El experimento tendr&aacute; una duraci&oacute;n de 10 segundos. Se comienza
											aplicando un
											voltaje de -5V al motor y a los 5 segundos de pasa a +5V. </p>
										<p>Se puede modificar el per&iacute;odo de muestreo, y el orden y frecuencia de
											corte de los
											filtros (Butterworth) de velocidad y posici&oacute;n.</p>
										<p style="margin-bottom:40px;">Nota: El video tiene un retardo de 10 segundos
											aproximadamente.</p>
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
														<label class="col-sm-2 col-form-label">Nv:</label>
														<div class="col-sm-8">
															<input name="Nv" type="text" size="15" value="1" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Fcv:</label>
														<div class="col-sm-8">
															<input name="Fcv" type="text" value="0.1" size="15" class="form-control">
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
															<input type="hidden" id="mlmfile" name="mlmfile" value="m_CS_FILs" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<div class="col-sm-8" style="text-align:center;">
															<input  id="execute-button" type="button" name="Submit" value="Ejecutar" <?php if (($cantidad == 0) || ($timeejec > 5) || ($permbytime == 0)) echo 'disabled= "disabled"'; ?> class="input_btn1" onClick="execute('m_CS_FILr')" />
														</div>
													</div>

												</div>
												<div class="col-sm-5 paramSim">
													<h1 class="content_r_hst6" style="margin:0;">Simbolog&iacute;a:</h1>
													<hr>

													<table width="100%" cellpadding="0" cellspacing="0" class="table table-borderless">
														<tbody class="tbodyA">
															<tr>
																<td>Tm:</td>
																<td>Per&iacute;odo de muestreo (0.001
																	<=Tm[s]<=1).< /td>
															</tr>
															<tr>
																<td>Nv:</td>
																<td>Orden del Filtro de velocidad</td>
															</tr>
															<tr>
																<td>Fcv:</td>
																<td>Frecuencia de corte (Fc[Hz]&lt;Fm/2)</td>
															</tr>
															<tr>
																<td>Np:</td>
																<td>Orden del Filtro de posici&oacute;n</td>
															</tr>
															<tr>
																<td>Fcp:</td>
																<td>Frecuencia de corte (Fc[Hz]&lt;Fm/2)</td>
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
		<script language="JavaScript" src="../../../js/sld.js" type="text/javascript"></script>
		<link rel="stylesheet" href="../../../modules/admin/css/index.css">
		<link rel="stylesheet" href="../css/m_cs.css">

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
									<h1 class="content_r_hst1">Ajuste de los filtros para las mediciones</h1>
									<div class="contentp">
										<img src="../../../img/CS_FIL.jpg" class="img-fluid rounded mx-auto d-block mbotom" />
										<p>El experimento tendr&aacute; una duraci&oacute;n de 10 segundos. Se comienza
											aplicando un
											voltaje de -5V al motor y a los 5 segundos de pasa a +5V. </p>
										<p>Se puede modificar el per&iacute;odo de muestreo, y el orden y frecuencia de
											corte de los
											filtros (Butterworth) de velocidad y posici&oacute;n.</p>
										<p style="margin-bottom:40px;">Nota: El video tiene un retardo de 10 segundos
											aproximadamente.</p>
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
														<label class="col-sm-2 col-form-label">Nv:</label>
														<div class="col-sm-8">
															<input name="Nv" type="text" size="15" value="1" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Fcv:</label>
														<div class="col-sm-8">
															<input name="Fcv" type="text" value="0.1" size="15" class="form-control">
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
															<input type="hidden" id="mlmfile" name="mlmfile" value="m_CS_FILs" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<div class="col-sm-8" style="text-align:center;">
															<input id="execute-button" type="button" name="Submit" value="Ejecutar" <?php if (($cantidad == 0) || ($timeejec > 5) || ($permbytime == 0)) echo 'disabled= "disabled"'; ?> class="input_btn1" onClick="execute('m_CS_FILr')" />
														</div>
													</div>

												</div>
												<div class="col-sm-5 paramSim">
													<h1 class="content_r_hst6" style="margin:0;">Simbolog&iacute;a:</h1>
													<hr>

													<table width="100%" cellpadding="0" cellspacing="0" class="table table-borderless">
														<tbody class="tbodyA">
															<tr>
																<td>Tm:</td>
																<td>Per&iacute;odo de muestreo (0.001
																	<=Tm[s]<=1).< /td>
															</tr>
															<tr>
																<td>Nv:</td>
																<td>Orden del Filtro de velocidad</td>
															</tr>
															<tr>
																<td>Fcv:</td>
																<td>Frecuencia de corte (Fc[Hz]&lt;Fm/2)</td>
															</tr>
															<tr>
																<td>Np:</td>
																<td>Orden del Filtro de posici&oacute;n</td>
															</tr>
															<tr>
																<td>Fcp:</td>
																<td>Frecuencia de corte (Fc[Hz]&lt;Fm/2)</td>
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