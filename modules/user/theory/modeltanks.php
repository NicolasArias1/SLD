<?php
	include('../../../inc/useful.fns.php');
	include('../../../inc/user.class.php');
	
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
				<div id="header_t_l"><a href="http://garp.fie.uclv.edu.cu" target="_blank"><img src="../../../img/logo.png" border="0" /></a></div>
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
				<h1 class="content_r_hst1">Maqueta de tanques acoplados</h1>
				<p>La unidad de tanques acoplados consiste en cuatro tanques interconectados como se muestra en la figura, y en cada uno hay un sensor de presi&oacute;n en el fondo que entrega un voltaje proporcional al nivel (0-5 volt).</p>
				
				<p>Un quinto tanque se encuentra en la parte inferior, en el cual hay dos bombas sumergibles que entregan un flujo proporcional a la acci&oacute;n de control que se les aplique (0-5 volt).</p>
				
				<p>La forma en que el agua fluye se puede configurar de muchas maneras con las v&aacute;lvulas manuales(MVA�G, MV1�4). La configuraci&oacute;n de las v&aacute;lvulas permite cambiar la din&aacute;mica y el acoplamiento, as&iacute; como la generaci&oacute;n de pasos de perturbaciones que da amplias posibilidades para evaluar el desempe&ntilde;o de numerosas estrategias de control.</p>
				<center><img src="../../../img/couptanks.jpg" /></center>
				
				<h1 class="content_r_hst1"> <br />Modelo din&aacute;mico</h1>
				<p>Configurando el sistema para que quede como dos tanques en cascada (v&aacute;lvulas MVB, MV1 y MV2: abiertas, el resto cerradas), el proceso a modelar ser&iacute;a el siguiente:</p>
				<center><img src="../../../img/tankscascada.jpg"/></center>
				
				<p>   Donde h1(t) y h2(t) son el nivel en cada tanque [cm], u(t) el voltaje aplicado a la bomba [v], &eta; es la constante de proporcionalidad de la misma [cm^3/min.v], A, a1 y a2 el &aacute;rea de la secci&oacute;n transversal de los tanques y las tuber&iacute;as respectivamente [cm^2] y g la aceleraci&oacute;n de la gravedad [cm/s^2]</p>
				
				<h1 class="content_r_hst1"> <br />Modelo No lineal</h1>
				
				<p>De acuerdo con el diagrama presentado, las ecuaciones del modelo no lineal son las siguientes:</p>
				<p>Para el estanque 1:</p>
				<center><img src="../../../img/eqtank1.jpg"/></center>
				
				<p>Para el estanque 2:</p>
				<center><img src="../../../img/eqtank2.jpg"/></center>
				
				<p>Las ecuaciones (1) y (2) constituyen un modelo no lineal de este sistema. En ellas k1 y k2 son las constantes de proporcionalidad entre el flujo y la ra&iacute;z cuadrada de la presi&oacute;n que est&aacute; asociada al factor de fricci&oacute;n, di&aacute;metro y largo de la tuber&iacute;a, el tipo de fluido y la aceleraci&oacute;n de la gravedad:</p>
				<center><img src="../../../img/eqk.jpg"/></center>
				
				<h1 class="content_r_hst1"> <br />Modelo Lineal</h1>
				
				<p>Para determinar la funci&oacute;n de transferencia de este sistema es necesario linealizarlo alrededor de un punto de operaci&oacute;n. Igualando a cero las ecuaciones (1) y (2) y evaluando para un voltaje constante en la bomba uo, se obtienen los puntos de operaci&oacute;n h1o y h2o:</p>				
				<center><img src="../../../img/eqh.jpg"/></center>
				
				<p>Para peque&ntilde;as variaciones alrededor del punto de operaci&oacute;n se obtiene:</p>
				<center><img src="../../../img/eqF.jpg"/></center>
				
				<p>Poniendo en t&eacute;rminos de variaciones las ecuaciones (1) y (2) y utilizando la ecuaci&oacute;n (5) seg&uacute;n corresponda, se obtiene:</p>
				<center><img src="../../../img/eqdeltah.jpg"/></center>
				
				<p>Aplicando Transformada de Laplace en (6) se obtiene:</p>
				<center><img src="../../../img/eqmodh1.jpg"/></center>
				
				<p>Aplicando Transformada de Laplace en (7) seobtiene:</p>
				<center><img src="../../../img/eqmodh2.jpg"/></center>
				
				<p>En bloques, este modelo queda de la siguiente forma:</p>
				<center><img src="../../../img/diagblk.jpg"/></center>
				
				<h1 class="content_r_hst1"> <br />Identificaci&oacute;n experimental</h1>
				<p>A continuaci&oacute;n se muestra la respuesta temporal del sistema en lazo abierto, ante una entrada tipo paso escal&oacute;n a 3v en t=0, luego a 3.3v en t=1000s y finalmente a 2.7v en t=2000s. Todas las mediciones se han hecho con un per&iacute;odo de muestreo de 0.1s. A partir de estas gr&aacute;ficas pueden obtenerse las ganancias est&aacute;ticas K1 y K2 y las constantes de tiempo &tau;1 y &tau;2.</p>
				<p>Los datos correspondientes a estas curvas pueden descargarse del siguiente enlace y obtenerse con el c&oacute;digo para Matlab que se muestra:</p>
				<p>Descargar datos de identificaci&oacute;n.<a href="../../../download/downloadidentnivel.php?path=../../../download/&file=datanivel.mat"><img src="../../../img/download.gif" vspace="2" alt="Descargar Modelo de Simulink enviado" border="0" /></p>
				
				<center><img src="../../../img/codidentnivel.jpg"/></center>
				<center><img src="../../../img/grafidentnivel.jpg"/></center>				
				
				
			</div>
			<div class="blank"></div>
		</div>
		<div id="footer">
			Copyright &copy; 2017: GARP.UCLV-DIEE.UBB
		</div>
	</div>
</body>
</html>
