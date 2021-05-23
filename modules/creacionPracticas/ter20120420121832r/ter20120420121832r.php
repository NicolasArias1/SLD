<?php
		
	include('../../../config/config.php');	
	include('../../../inc/db.class.php');
	include('../../../inc/user.class.php');
	include('../../../inc/useful.fns.php');
	
		
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
		
	
	//Para informaci�n de las estaciones
	
	//Creando objeto SQL
	$sql = new SQL();
	
	//Conectando con el servidor
	$sql->SQLConnection();
	$pname = "m_ter20120420121832r" ;    //"m_termicor"; //nombre de pr�ctica real actual
	
	// Direccion IP de la estacion
	$query = "SELECT ip, state, pcount FROM sld_stations WHERE (practices='".$pname."' OR practices LIKE '".$pname.";%' OR practices LIKE '%;".$pname.";%' OR practices LIKE '%;".$pname."') AND state!='off'";
	
	//Ejecutando consulta
	$result = $sql->SQLQuery($query);
	
	if(is_array($result)){
		$cantidad = count($result);
		for($i=0, $j=0; $i < count($result); $i++) {
			if($result[$i]['state'] == 'wait') {
				$wip[$j] = $result[$i]['ip'];								
				$j++;
			}//end if
			$pcount[$result[$i]['ip']] = $result[$i]['pcount'];			
		}//end for
		
		$cantfree = count($wip);
		if($wip) {
			shuffle($wip);			
			$ip = $wip[0]; //si hay estaciones libre, realiza un barajeo y coge una
		}//end if
		else {
			rsort($pcount);	//si no hay estaciones libres busca la peor		
			reset($pcount);			
			$bip = key($pcount);			
			$ip = $bip;
		}//end else
		} //end if
	else
		$cantidad = 0;
		
	$timeejec = ($pcount[$ip] * 2) + 2;
		
	//Restriccion por tiempo
	$permbytime = 0;
	$hora = Date(H);
	$diaweek = Date(w);
	if ($hora >= 9 && $hora < 21 && $diaweek > 0 && $diaweek < 6 ){
		$permbytime = 1;}
	
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Pr&aacute;cticas</title>
	<link href="../../../css/styles.css" rel="stylesheet" type="text/css" />
  <script language="JavaScript" src="../../../js/sld.js" type="text/javascript"></script>
  <style type="text/css">
<!--
.Estilo3 {font-size: 11px}
-->
  </style>
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
					<h4 class="txt">Sistema de Laboratorios a Distancia <?php //echo $permbytime; ?></h4>
				</div>
				<div id="header_r"></div>
			</div>
		</div>
		<div id="navigator">
			<div id="nav_l"></div>
			<div id="nav_c">
				<ul>
					<li><a href="../../user/index.php">Inicio</a></li>
					<li><a href="../../user/theory.php">Teor&iacute;a</a></li>
					<li><a href="../../user/practices.php">Pr&aacute;cticas</a></li>
					<li><a href="../../user/platform.php">Plataforma</a></li>					
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
						<li><a href="../../user/index.php" class="ast3">Inicio</a></li>
						<li><a href="../../user/theory.php" class="ast3">Teoria</a></li>
						<li><a href="../../user/practices.php" class="ast3">Pr&aacute;cticas</a></li>
						<li><a href="../../user/platform.php" class="ast3">Plataforma</a></li>
						<li><a href="../../user/mypractices.php" class="ast3">Mis Pr&aacute;cticas</a></li>						
					</ul>
				</div>
				<div id="content_l_b"></div>
			</div>
			<div id="content_r">
				<h1 class="content_r_hst1">prueba_r</h1>
				<p>Descripci�n buena2.</p>
				<img src="../../../img/sist_term.jpg" />
				<p>Introduzca los par�metros abcd. La ejecuci�n REAL del sistema tiene una duraci�n de 2 minutos. <?php if ($cantidad) echo "	En estos momentos hay $cantidad estacion(es) que puede(n) ejecutar de forma REAL esta pr�ctica."; ?></p>
				<?php if ($cantfree) echo '<h1 class="content_r_hst2">	Hay estaciones libres. La ejecuci�n de la pr�ctica de forma REAL demorar� aproximadamente 2 minutos en mostrar los resultados.</h1>'; ?>
				<?php if (($timeejec > 2) && ($timeejec < 5)) echo '<h1 class="content_r_hst2">	Las estaciones que pueden ejecutar esta pr�ctica de forma REAL est�n ocupadas, demorar� aproximadamente '.$timeejec.' minutos en mostrar los resultados. Si lo prefiere pruebe en unos minutos.</h1>'; ?>
				<?php if ($timeejec > 5) echo '<h1 class="content_r_hst2">	Las estaciones que pueden ejecutar esta pr�ctica de forma REAL est�n muy ocupadas, demorar� m�s de '.$timeejec.' minutos en mostrar los resultados. Por favor pruebe en otro momento.</h1>'; ?>
				<?php if (!$cantidad) echo '<h1 class="content_r_hst2">	Lo sentimos mucho pero no hay estaciones que puedan ejecutar esta pr�ctica de forma REAL. Por favor pruebe en otro momento.</h1>';?>
				<form id="practice" name="practice" action="../../user/client.php" method="post" enctype="multipart/form-data">
					<div class="content_r_data">
						<div class="content_r_data_t"></div>
						<div class="content_r_data_c">
							<h1 class="content_r_hst3">Datos de la Pr&aacute;ctica:</h1>
							<table width="100%" cellpadding="0" cellspacing="0" class="form">
							 <tr><td>a</td><td><input name='a' type='text' class='input_field' value='0.7' size='15' /></td></tr> <tr><td>b</td><td><input name='b' type='text' class='input_field' value='3' size='15' /></td></tr> <tr><td>c</td><td><input name='c' type='text' class='input_field' value='6' size='15' /></td></tr> <tr><td>d</td><td><input name='d' type='text' class='input_field' value='5' size='15' /></td></tr>
							</table>							
							
							<table width="100%" cellpadding="0" cellspacing="0" class="form">
							  
							  <tr>
								  <td class="buttons"><input type="hidden" id="mlmfile" name="mlmfile" value="m_ter20120420121832s"></td>
							    <td class="buttons"><input type="button" name="Submit" value="Simular" class="input_button" onClick="execute('m_ter20120420121832s')" /></td>
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
							<tr><td width='20'><span class='Estilo3'>a:</span></td><td width='175'><span class='Estilo3'>Valor%20de%20a</span></td></tr><tr><td width='20'><span class='Estilo3'>b:</span></td><td width='175'><span class='Estilo3'>Valor%20de%20b</span></td></tr><tr><td width='20'><span class='Estilo3'>c:</span></td><td width='175'><span class='Estilo3'>Valor%20de%20c</span></td></tr><tr><td width='20'><span class='Estilo3'>d:</span></td><td width='175'><span class='Estilo3'>Valor%20de%20d</span></td></tr>
							</table>
						</div>
						<div class="content_r_data_b"></div>
					</div>
				</form>
					 </div>
			<div class="blank"></div>
		</div>
		<div id="footer">
			Copyright &copy; 2009 GARP - Facultad de Ingenier&iacute;a El&eacute;ctrica<br />
			Universidad Central &quot;Marta Abreu&quot; de Las Villas.
		</div>
	</div>
</body>
</html>
