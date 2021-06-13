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

$timeejec = ($pcount[$ip] * 2) + 2;

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


<?php  }  ?>


<!-- Realiza práctica desde perfil profe. -->
<?php if ($level == 2) {  ?>


<?php  }  ?>



<!-- Realiza práctica desde perfil estudiante. -->
<?php if ($level == 3) {  ?>


<?php  }  ?>








<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Pr&aacute;cticas</title>
	<link href="../../../css/styles.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" src="../../../js/sld.js" type="text/javascript"></script>
</head>

<body>
	<div id="page">
		<div id="header">
			<div id="header_t">
				<div id="header_t_l"><img src="../../../img/logo.png" border="0" /></div>
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
						<li><a href="../theory.php" class="ast3">Teor&iacutea</a></li>
						<li><a href="../practices.php" class="ast3">Pr&aacute;cticas</a></li>
						<li><a href="../platform.php" class="ast3">Plataforma</a></li>
						<li><a href="../mypractices.php" class="ast3">Mis Pr&aacute;cticas</a></li>
						<li><a href="mailto:ching@uclv.edu.cu;aerubio@ubiobio.cl">Contacto</a></li>
					</ul>


				</div>
				<div id="content_l_b"></div>
			</div>
			<div id="content_r">
				<h1 class="content_r_hst1">Control de Velocidad y Posici&oacute;n</h1>
				<p>A continuaci&oacute;n se muestra el esquema que se ejecutar&aacute; para la realizaci&oacute;n de esta experiencia:</p>
				<div align="center"><img src="../../../img/CS_C.jpg" /> </div>
				<p>En esta pr&aacute;ctica usted podr&aacute; dise&ntilde;ar la estrategia de control y poner la referencia deseada.
					Para ello dispone de la medici&oacute;n de la velocidad y la posici&oacute;n as&iacute; como la salida de control.
					Para evaluar el algoritmo y los resultados puede mostrar las se&ntilde;ales que desee mediante tres graficadores auxiliares.
					Puede poner un tiempo de ejecuci&oacute;n de hasta 60 segundos y el per&iacute;odo de muestreo en el rango de 0.001s a 1s.</p>
				<p>Descarge el modelo virtual de la planta, programe el Controlador y salve el modelo modificado. Luego debe subirlo a la plataforma pulsando Examinar y pulsando Ejecutar obtendr&aacute; el comportamiento del sistema real.</p>
				<p>Opcionalmente puede subir un .mat en el que puede ir, por ejemplo, la referencia u otras constantes que se necesten en el bloque Controlador. La referencia puede generarla, guardarla en el .mat y, dentro del bloque controlador, cargarla con un FromWorkspace.</p>
				<p>Importante:</p>
				<ol>
					<li>El modelo que se descarga es un .mdl Simulink Versi&oacute;n 7.5 (R2010a). <b>Si usted utiliza una versi&oacute;n inferior, puede que no le sea compatible</b>.</li>
					<li>S&oacute;lo debe modificar el interior del subsistema &quot;Controlador&quot; <b>sin alterar su nombre ni sus conexiones de entrada y salida</b>.</li>
					<li>El modelo que se env&iacute;e tiene que ser en <b>.mdl Simulink Versi&oacute;n 8.4 (R2014b) o inferior</b>. Si usted utiliza una versi&oacute;n superior s&aacute;lvelo con la opci&oacute;n Export Model to Previous Version.</li>
				</ol>
				<p>La duraci&oacute;n del ensayo depender&aacute; del tiempo de ejecuci&oacute;n ajustado en el modelo de Simulink.<?php if ($cantidad) echo "	En estos momentos hay $cantidad estacion(es) que puede(n) ejecutar esta pr&aacute;ctica."; ?></p>

				<?php
				if ($cantidad) {
					echo '<h1 class="content_r_hst2">	Hay estaciones libres para ejecutar esta pr&aacute;ctica de forma REAL.</h1>';
				} else {
					echo '<h1 class="content_r_hst2">	Lo sentimos, no hay estaciones que puedan ejecutar esta pr&aacute;ctica de forma REAL. Por favor pruebe en otro momento.</h1>';
				}
				?>

				<form name="down" action="../../../download/downloadcs.php " method="post" enctype="multipart/form-data">
					<div class="content_r_data">
						<div class="content_r_data_t"></div>
						<div class="content_r_data_c">

							<h1 class="content_r_hst3">Descargar el fichero .mdl:</h1>
							<table width="100%" cellpadding="0" cellspacing="0" class="form">
								<tr>
									<td class="buttons"><input type="submit" name="Submit" value="Descargar" class="input_button" /></td>
								</tr>
							</table>
				</form>
				<form id="practice" name="practice" action="../client.php" method="post" enctype="multipart/form-data">

					<h1 class="content_r_hst4">Fichero Simulink en .mdl:</h1>
					<table width="100%" cellpadding="0" cellspacing="0" class="form">
						<tr>
							<td width="205" colspan="2"><input name="filemdl" type="file" size="15" value="0.08" class="input_field" /></td>
						</tr>

						<table width="100%" cellpadding="0" cellspacing="0" class="form">

							<h1 class="content_r_hst4">Fichero .mat (opcional):</h1>
							<table width="100%" cellpadding="0" cellspacing="0" class="form">
								<tr>
									<td width="205" colspan="2"><input name="filemat" type="file" size="15" value="0.08" class="input_field" /></td>
								</tr>

								<table width="100%" cellpadding="0" cellspacing="0" class="form">

				</form>


				<tr>
					<td class="buttons"><input type="hidden" id="mlmfile" name="mlmfile" value="m_CS_Cs"></td>
					<td class="buttons"><input type="button" name="Submit" value="Ejecutar" <?php if (($cantidad == 0) || ($timeejec > 5) || ($permbytime == 0)) echo 'disabled= "disabled"'; ?> class="input_button" onClick="execute('m_CS_Cr')" /></td>
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