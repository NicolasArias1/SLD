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
				<h1 class="content_r_hst1">El motor de corriente directa</h1>
				<h1 class="content_r_hst2">Obtenci&oacute;n del modelo</h1>
				<p>El motor de corriente directa resulta un actuador com&uacute;n en sistemas de control. El mismo suministra de forma directa movimiento rotatorio y acoplado a trav&eacute;s de dispositivos mec&aacute;nicos simples, puede proveer movimiento traslacional. El circuito el&eacute;ctrico de la armadura y el campo se muestran en la siguiente figura:</p>
				<img src="../../../img/motorcd1.png" align="left" />
				<div class="content_r_data">
					<div class="content_r_data_t"></div>
					<div class="content_r_data_c">
						<h1 class="content_r_hst3">Simbolog&iacute;a:</h1>
						<table width="100%" cellpadding="0" cellspacing="0" class="data">
						  <tr>
								<td width="30">Ea:</td>
							  <td width="175">Voltaje de armadura (Acci&oacute;n de control)</td>
							</tr>
							<tr>
							  <td>Ra:</td>
						    <td>Resistencia de armadura</td>
						  </tr>
						  <tr>
							  <td>La:</td>
						    <td>Inductancia de armadura</td>
						  </tr>
						  <tr>
							  <td>Ia:</td>
						    <td>Corriente del armadura</td>
						  </tr>
						  <tr>
							  <td>Eb:</td>
						    <td>Fuerza contraelectromotriz</td>
						  </tr>
						  <tr>
							  <td>J:</td>
						    <td>Momento de inercia</td>
						  </tr>
						  <tr>
							  <td>F:</td>
						    <td>Fricci&oacute;n viscosa</td>
						  </tr>
						</table>
					</div>
					<div class="content_r_data_b"></div>
				</div>
				<p>La fuerza contraelectromotriz es proporcional a la velocidad de rotaci&oacute;n del eje (Eb=Kb.w). Por otra parte, si el campo es constante, el momento que ejerce el eje sobre la carga es proporcional a la corriente de armadura (T=Ka.Ia). Y se sabe que las constantes Ka y Kb son num&eacute;ricamente iguales si ambas se expresan en el sistema internacional de unidades (K=Kb=Ka). Conociendo lo anterior y aplicando las leyes de Newton y de Kirchhoff's, las ecuaciones del modelo en transformada de Laplace quedan:</p>
				<p>(La.s + Ra).Ia(s) + K.w(s) = Ea(s)<br />(J.s + F).w(s) + Td(s) = K.Ia(s)</p>
				<p>Teniendo en cuenta el momento disturbio (Td), la relaci&oacute;n de engrane entre el eje y la carga (Re) y que el sensor disponible es el de posici&oacute;n (q), el diagrama en bloque queda como se muestra a continuaci&oacute;n:</p>
				<img src="../../../img/motorcd2.png" />
				<p>Despreciando la inductancia de armadura, que por lo general es peque&ntilde;a, este modelo puede reducirse a:</p>
				<img src="../../../img/motorcd3.png" />
				<p>Donde:</p>
				<img src="../../../img/motorcd4.png" />
				<p>No todos los par&aacute;metros del modelo m&aacute;s completo son f&aacute;ciles de obtener por lo que en la pr&aacute;ctica el modelo m&aacute;s utilizado es el reducido ya que se puede deducir sin grandes dificultades, mediante la identificaci&oacute;n experimental del sistema ante una entrada paso.</p>
				<p>Para ello, se aplica una variaci&oacute;n tipo paso en el voltaje de entrada y se registra la variaci&oacute;n de velocidad en el tiempo. Luego Km*Re = VarVel/VarVolt mientras Tm ser&aacute; el tiempo que tarda la velocidad en alcanzar el 63% del valor final.</p>
			</div>
			<div class="blank"></div>
		</div>
		<div id="footer">
			Copyright &copy; 2017: GARP.UCLV-DIEE.UBB
		</div>
	</div>
</body>
</html>
