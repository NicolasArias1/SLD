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
$pname = "m_CS_IDr"; //nombre de pr&aacute;ctica real actual

// Direccion IP de la estacion
$query = "SELECT ip, state, pcount FROM sld_stations WHERE (practices='" . $pname . "' OR practices LIKE '" . $pname . ";%' OR practices LIKE '%;" . $pname . ";%' OR practices LIKE '%;" . $pname . "') AND state!='off'";

//Ejecutando consulta
$result = $sql->SQLQuery($query);
$timeejec = 0;
$pcount = [];
$ip = '';

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

	$timeejec = ($pcount[$ip] * 2) + 2;
} //end if
else {
	$cantidad = 0;
}

//Restriccion por tiempo
$permbytime = 1; // activo todo el tiempo, para limitar poner a 0 y cambiar horas debajo
// $hora = Date(H);
// $diaweek = Date(w);
// if ($hora >= 9 && $hora < 21 && $diaweek > 0 && $diaweek < 6 ){
// 	$permbytime = 1;
// }
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
		<script language="JavaScript" src="../../../js/osld.js" type="text/javascript"></script>
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

									<h1 class="content_r_hst1">Identificaci&oacute;n al paso de la din&aacute;mica de un
										motor</h1>
									<div class="contentp">
										<p>A continuaci&oacute;n se muestra el esquema empleado para la
											identificaci&oacute;n al
											paso de la din&aacute;mica de un motor en lazo abierto:</p>

										<img src="../../../img/CS_ID.jpg" class="img-fluid rounded mx-auto d-block mbotom" />
										<p style="margin-bottom:40px;">Se puede modificar el per&iacute;odo de muestreo, el
											tiempo de
											experimentaci&oacute;n, y el voltaje inicial y final del paso as&iacute;
											como el instante en que ocurre.</p>

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
															<input name="Tm" type="text" value="0.1" size="15" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Te:</label>
														<div class="col-sm-8">
															<input name="Te" type="text" size="15" value="1" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Tp:</label>
														<div class="col-sm-8">
															<input name="Tp" type="text" size="15" value="0" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Vi:</label>
														<div class="col-sm-8">
															<input name="Vi" type="text" size="15" value="0" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Vf:</label>
														<div class="col-sm-8">
															<input name="Vf" type="text" size="15" value="1" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<div class="col-sm-8">
															<input type="hidden" id="mlmfile" name="mlmfile" value="m_CS_IDr" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<div class="col-sm-8" style="text-align:center;">
															<input id="execute-button" type="button" name="Submit" value="Ejecutar" <?php if (($cantidad == 0) || ($timeejec > 5) || ($permbytime == 0)) echo 'disabled= "disabled"'; ?> class="input_btn1" onClick="execute('m_CS_IDr')" />
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
																<td>Per&iacute;odo de
																	muestreo (0.001<=Tm[s]<=1).< /td>
															</tr>
															<tr>
																<td> Te:</td>
																<td> Tiempo de experimento (1<=Te[s]<=10).< /td>
															</tr>
															<tr>
																<td>Tp:</td>
																<td>Instante en que ocurre el paso
																	(Tp[s]<=Te).< /td>
															</tr>
															<tr>
																<td>Vi:</td>
																<td>Voltaje inicial del paso
																	(+-10V).</td>
															</tr>
															<tr>
																<td>Vf:</td>
																<td>Voltaje final del
																	paso(+-10V).</td>
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




<?php } ?>


<!-- Realiza práctica desde perfil profesor. -->
<?php if ($level == 2) {  ?>

	<!doctype html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php require_once('../../../modules/admin/css/libcss.php') ?>
		<script language="JavaScript" src="../../../js/sld.js" type="text/javascript"></script>
		<script language="JavaScript" src="../../../js/osld.js" type="text/javascript"></script>
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

									<h1 class="content_r_hst1">Identificaci&oacute;n al paso de la din&aacute;mica de un
										motor</h1>
									<div class="contentp">
										<p>A continuaci&oacute;n se muestra el esquema empleado para la
											identificaci&oacute;n al
											paso de la din&aacute;mica de un motor en lazo abierto:</p>

										<img src="../../../img/CS_ID.jpg" class="img-fluid rounded mx-auto d-block mbotom" />
										<p style="margin-bottom:40px;">Se puede modificar el per&iacute;odo de muestreo, el
											tiempo de
											experimentaci&oacute;n, y el voltaje inicial y final del paso as&iacute;
											como el instante en que ocurre.</p>

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
															<input name="Tm" type="text" value="0.1" size="15" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Te:</label>
														<div class="col-sm-8">
															<input name="Te" type="text" size="15" value="1" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Tp:</label>
														<div class="col-sm-8">
															<input name="Tp" type="text" size="15" value="0" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Vi:</label>
														<div class="col-sm-8">
															<input name="Vi" type="text" size="15" value="0" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Vf:</label>
														<div class="col-sm-8">
															<input name="Vf" type="text" size="15" value="1" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<div class="col-sm-8">
															<input type="hidden" id="mlmfile" name="mlmfile" value="m_CS_IDr" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<div class="col-sm-8" style="text-align:center;">
															<input id="execute-button" type="button" name="Submit" value="Ejecutar" <?php if (($cantidad == 0) || ($timeejec > 5) || ($permbytime == 0)) echo 'disabled= "disabled"'; ?> class="input_btn1" onClick="execute('m_CS_IDr')" />
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
																<td>Per&iacute;odo de
																	muestreo (0.001<=Tm[s]<=1).< /td>
															</tr>
															<tr>
																<td> Te:</td>
																<td> Tiempo de experimento (1<=Te[s]<=10).< /td>
															</tr>
															<tr>
																<td>Tp:</td>
																<td>Instante en que ocurre el paso
																	(Tp[s]<=Te).< /td>
															</tr>
															<tr>
																<td>Vi:</td>
																<td>Voltaje inicial del paso
																	(+-10V).</td>
															</tr>
															<tr>
																<td>Vf:</td>
																<td>Voltaje final del
																	paso(+-10V).</td>
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





<?php } ?>

<!-- Realiza práctica desde perfil estudiante. -->
<?php if ($level == 3) { ?>


	<!doctype html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php require_once('../../../modules/admin/css/libcss.php') ?>
		<script language="JavaScript" src="../../../js/sld.js" type="text/javascript"></script>
		<script language="JavaScript" src="../../../js/osld.js" type="text/javascript"></script>
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

									<h1 class="content_r_hst1">Identificaci&oacute;n al paso de la din&aacute;mica de un
										motor</h1>
									<div class="contentp">
										<p>A continuaci&oacute;n se muestra el esquema empleado para la
											identificaci&oacute;n al
											paso de la din&aacute;mica de un motor en lazo abierto:</p>

										<img src="../../../img/CS_ID.jpg" class="img-fluid rounded mx-auto d-block mbotom" />
										<p style="margin-bottom:40px;">Se puede modificar el per&iacute;odo de muestreo, el
											tiempo de
											experimentaci&oacute;n, y el voltaje inicial y final del paso as&iacute;
											como el instante en que ocurre.</p>
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
															<input name="Tm" type="text" value="0.1" size="15" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Te:</label>
														<div class="col-sm-8">
															<input name="Te" type="text" size="15" value="1" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Tp:</label>
														<div class="col-sm-8">
															<input name="Tp" type="text" size="15" value="0" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Vi:</label>
														<div class="col-sm-8">
															<input name="Vi" type="text" size="15" value="0" class="form-control">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-2 col-form-label">Vf:</label>
														<div class="col-sm-8">
															<input name="Vf" type="text" size="15" value="1" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<div class="col-sm-8">
															<input type="hidden" id="mlmfile" name="mlmfile" value="m_CS_IDr" class="form-control">
														</div>
													</div>

													<div class="form-group row">
														<div class="col-sm-8" style="text-align:center;">
															<input id="execute-button" type="button" name="Submit" value="Ejecutar" <?php if (($cantidad == 0) || ($timeejec > 5) || ($permbytime == 0)) echo 'disabled= "disabled"'; ?> class="input_btn1" onClick="execute('m_CS_IDr')" />
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
																<td>Per&iacute;odo de
																	muestreo (0.001<=Tm[s]<=1).< /td>
															</tr>
															<tr>
																<td> Te:</td>
																<td> Tiempo de experimento (1<=Te[s]<=10).< /td>
															</tr>
															<tr>
																<td>Tp:</td>
																<td>Instante en que ocurre el paso
																	(Tp[s]<=Te).< /td>
															</tr>
															<tr>
																<td>Vi:</td>
																<td>Voltaje inicial del paso
																	(+-10V).</td>
															</tr>
															<tr>
																<td>Vf:</td>
																<td>Voltaje final del
																	paso(+-10V).</td>
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


<?php } ?>

<script>
	var executeButton = document.getElementById("execute-button");

	executeButton.addEventListener("click", function() {
		var spinner = document.getElementById("spinner-container");
		spinner.style.display = "block";
	});
</script>