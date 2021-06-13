<?php


include('../../../config/config.php');
include('../../../inc/db.class.php');
include('../../../inc/user.class.php');
include('../../../inc/useful.fns.php');

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
$pname = "m_CS_PVr"; //nombre de pr&aacute;ctica real actual

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

$timeejec = ($pcount[$ip] * 2) + 2;

//Restriccion por tiempo
$permbytime = 1; // activo todo el tiempo, para limitar poner a 0 y cambiar horas debajo
$hora = Date('H');
$diaweek = Date('w');
if ($hora >= 9 && $hora < 21 && $diaweek > 0 && $diaweek < 6) {
	$permbytime = 1;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Pr&aacute;cticas</title>
	<link href="../../../css/styles.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" src="../../../js/sld.js" type="text/javascript"></script>
	<style type="text/css">
		.Estilo3 {
			font-size: 11px
		}
	</style>
</head>

<body>
	<div id="page">
		<?php require_once('../../../structure/spinner.php') ?>

		<div id="header">
			<div id="header_t">
				<div id="header_t_l"><img src="../../../img/logo.png" /></div>
				<div id="header_t_r"><?php echo Date_Time(); ?></div>
			</div>
			<div id="header_b">
				<div id="header_l"></div>
				<div id="header_c">
					<h1 class="logo">SLD<span class="w_txt">WEB</span></h1>
					<h4 class="txt">Sistema de Laboratorios a Distancia <?php //echo $permbytime; 
																		?></h4>
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
				<h1 class="content_r_hst1">Ajuste de dos PID para control de posici&oacute;n en cascada</h1>
				<p>A continuaci&oacute;n se muestra el esquema empleado para controlar la posici&oacute;n durante 10 segundos. La posici&oacute;n deseada comienza en -50 grados y a los 5 segundos pasa a 50 grados:</p>
				<div align="center">
					<img src="../../../img/CS_PV.jpg" />
					<div align="left">
						<p>Se dispone de un controlador PID para el lazo de velocidad (lazo interno) y otro PID para el lazo de posici&oacute;n (lazo externo). El esquema de control implementado se corresponde con el siguiente diagrama en bloques:</p>
						<div align="center">
							<img src="../../../img/CS_PV_PID.jpg" />
							<div align="left">
								<p>N&oacute;tese que los PIDs responde a la estructura paralela: man = P + I/s + Ds. Los valores P, I y D son las constantes proporcional, integral y derivativa respectivamente, Tm es el per&iacute;odo de muestreo, Kb la constante de realimentaci&oacute;n de la diferencia entre el mando calculado y el saturado para eliminar el windup y N la frecuencia de corte en rad/segundos del filtro derivativo de primero orden (N=2*pi*Fcd).</p>
								<p>En este experimento se pueden modificar los par&aacute;metros antes mencionados tanto para el PID de velocidad como para el PID de posici&oacute;n. Tambi&eacute;n se puede modificar el orden y la frecuencia de corte de los filtros (Butterworth) de ambas mediciones.</p>

								<?php
								if ($cantidad) {
									echo '<h1 class="content_r_hst2">	Hay estaciones libres para ejecutar esta pr&aacute;ctica de forma REAL.</h1>';
								} else {
									echo '<h1 class="content_r_hst2">	Lo sentimos, no hay estaciones que puedan ejecutar esta pr&aacute;ctica de forma REAL. Por favor pruebe en otro momento.</h1>';
								}
								?>
								<form id="practice" name="practice" action="../client.php" method="post" enctype="multipart/form-data">
									<div class="content_r_data">
										<div class="content_r_data_t"></div>
										<div class="content_r_data_c">
											<h1 class="content_r_hst3">Par&aacute;metros para el experimento:</h1>
											<table width="100%" cellpadding="0" cellspacing="0" class="form">
												<tr>
													<td>Tm:</td>
													<td><input name="Tm" type="text" class="input_field" value="0.5" size="15" /></td>
												</tr>
												<tr>
													<td>Pp:</td>
													<td><input name="Pp" type="text" size="15" value="0.1" class="input_field" /></td>
												</tr>
												<tr>
													<td>Ip:</td>
													<td><input name="Ip" type="text" size="15" value="0" class="input_field" /></td>
												</tr>
												<tr>
													<td>Dp:</td>
													<td><input name="Dp" type="text" size="15" value="0" class="input_field" /></td>
												</tr>
												<tr>
													<td>Kbp:</td>
													<td><input name="Kbp" type="text" size="15" value="0" class="input_field" /></td>
												</tr>
												<tr>
													<td>Fcdp:</td>
													<td><input name="Fcdp" type="text" size="15" value="1" class="input_field" /></td>
												</tr>
												<tr>
													<td>SWp:</td>
													<td><input name="SWp" type="text" size="15" value="0" class="input_field" /></td>
												</tr>
												<tr>
													<td>Np:</td>
													<td><input name="Np" type="text" size="15" value="1" class="input_field" /></td>
												</tr>
												<tr>
													<td>Fcp:</td>
													<td><input name="Fcp" type="text" size="15" value="0.1" class="input_field" /></td>
												</tr>
												<tr>
													<td>Pv:</td>
													<td><input name="Pv" type="text" size="15" value="0.1" class="input_field" /></td>
												</tr>
												<tr>
													<td>Iv:</td>
													<td><input name="Iv" type="text" size="15" value="0" class="input_field" /></td>
												</tr>
												<tr>
													<td>Dv:</td>
													<td><input name="Dv" type="text" size="15" value="0" class="input_field" /></td>
												</tr>
												<tr>
													<td>Kbv:</td>
													<td><input name="Kbv" type="text" size="15" value="0" class="input_field" /></td>
												</tr>
												<tr>
													<td>Fcdv:</td>
													<td><input name="Fcdv" type="text" size="15" value="1" class="input_field" /></td>
												</tr>
												<tr>
													<td>SWv:</td>
													<td><input name="SWv" type="text" size="15" value="0" class="input_field" /></td>
												</tr>
												<tr>
													<td>Nv:</td>
													<td><input name="Nv" type="text" size="15" value="1" class="input_field" /></td>
												</tr>
												<tr>
													<td>Fcv:</td>
													<td><input name="Fcv" type="text" size="15" value="0.1" class="input_field" /></td>
												</tr>
											</table>

											<table width="100%" cellpadding="0" cellspacing="0" class="form">

												<tr>
													<td class="buttons"><input type="hidden" id="mlmfile" name="mlmfile" value="m_CS_PVs"></td>
													<td class="buttons"><input id="execute-button" type="button" name="Submit" value="Ejecutar" <?php if (($cantidad == 0) || ($timeejec > 5) || ($permbytime == 0)) echo 'disabled= "disabled"'; ?> class="input_button" onClick="execute('m_CS_PVr')" /></td>
												</tr>

											</table>

										</div>

										<div class="content_r_data_b"></div>
									</div>
									<div class="content_r_data">
										<div class="content_r_data_t"></div>
										<div class="content_r_data_c">
											<h1 class="content_r_hst3">Simbolog&iacute;a:</h1>
											<table width="100%" cellpadding="0" cellspacing="0" class="data">
												<tr>
													<td width="20"><span class="Estilo3">Tm:</span></td>
													<td width="175"><span class="Estilo3">Per&iacute;odo de muestreo (0.001<=Tm[s]<=1)< /span>
													</td>
												</tr>
												<tr>
													<td><span class="Estilo3">P_pv:</span></td>
													<td><span class="Estilo3">Ganancia proporcional</span></td>
												</tr>
												<tr>
													<td><span class="Estilo3">I_pv:</span></td>
													<td><span class="Estilo3">Ganancia integral</span></td>
												</tr>
												<tr>
													<td><span class="Estilo3">D_pv:</span></td>
													<td><span class="Estilo3">Ganancia derivativa</span></td>
												</tr>
												<tr>
													<td><span class="Estilo3">Kb_pv:</span></td>
													<td><span class="Estilo3">Ganancia anti-windup</span></td>
												</tr>
												<tr>
													<td><span class="Estilo3">Fcd_pv:</span></td>
													<td><span class="Estilo3">Frecuencia de corte (Hz)</span></td>
												</tr>
												<tr>
													<td><span class="Estilo3">SW_pv:</span></td>
													<td><span class="Estilo3">Selector del Filtro de la medici&oacute;n (0:No, 1:Si)</span></td>
												</tr>
												<tr>
													<td><span class="Estilo3">N_pv:</span></td>
													<td><span class="Estilo3">Orden del Filtro de la medici&oacute;n</span></td>
												</tr>
												<tr>
													<td><span class="Estilo3">Fc_pv:</span></td>
													<td><span class="Estilo3">Frecuencia de corte (Fc[Hz]&lt;Fm/2)</span></td>
												</tr>
											</table>
										</div>
										<div class="content_r_data_b"></div>
									</div>


								</form>
							</div>
							<div class="blank"></div>
						</div>
						<div id="footer">
							Copyright &copy; 2017: GARP.UCLV-DIEE.UBB
						</div>
					</div>
</body>

</html>

<script>
	var executeButton = document.getElementById("execute-button");

	executeButton.addEventListener("click", function() {
		var spinner = document.getElementById("spinner-container");
		spinner.style.display = "block";
	});
</script>