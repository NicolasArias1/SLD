<?php
	include('inc/useful.fns.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Inicio</title>
  <link href="css/styles.css" rel="stylesheet" type="text/css" />
  <script language="JavaScript" src="js/sld.js" type="text/javascript"></script>
	<script language="JavaScript" src="js/osld.js" type="text/javascript"></script>
	<script language="JavaScript" src="js/asld.js" type="text/javascript"></script>
</head>

<body>
	<div id="page">
		<div id="header">
			<div id="header_t">
				<div id="header_t_l"><img src="img/logo.png" border="0" /></div>
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
					<li><a href="index.php">Inicio</a></li>
					<li><a href="general/theory.php">Teor&iacute;a</a></li>
					<li><a href="general/practices.php">Pr&aacute;cticas</a></li>
					<li><a href="general/platform.php">Plataforma</a></li>					
				</ul>
			</div>
			<div id="nav_r"></div>
		</div>
		<div id="content">
			<div id="content_l">
				<div id="content_l_t"></div>
				<div id="content_l_c">
					<form action="general/login.php" method="post" enctype="multipart/form-data">
						<h1 class="content_l_hst1">Autentificaci&oacute;n</h1>
						<div class="input_celd">Nombre de usuario<br />
						  <input name="login" type="text" size="15" class="input_field" />
						</div>
						<div class="input_celd">Contrase&ntilde;a<br />
						  <input name="passwd" type="password" size="15" class="input_field" />						  					  
						</div>
						<div style="display:none;" class="input_celd">Dominio<br />
						  <select name="domain" id="domain" class="input_field">						    
						    <option>db</option>
					    </select>
						</div>
						<div class="input_celd">
						  <input type="submit" name="Submit" value="Enviar" class="input_button" />
						</div>
					</form>
						<div>
						  <ul>
								<li><a href="general/addusers.php" class="ast3">Registrarse</a></li>
						  </ul>
						</div>
				</div>
				<div id="content_l_b"></div>
			</div>
			
			<div id="content_r">
				<h1 class="content_r_hst1">Desarrollado por GARP (UCLV) <br /><span class="content_r_sst1">(Grupo de Automatizaci&oacute;n R&oacute;botica y Percepci&oacute;n)</span></h1>
				<h1 class="content_r_hst1">En colaboraci&oacute;n con DISAM (UPM)<br /><span class="content_r_sst1">(Departamento de Autom&aacute;tica, Ingenier&iacute;a Electr&oacute;nica e Inform&aacute;tica Industrial</a>)</span></h1>
				<h1 class="content_r_hst1">En colaboraci&oacute;n con DIEE (UBB)<br /><span class="content_r_sst1">(Departamento de Ingenier&iacute;a El&eacute;ctrica y Electr&oacute;nica</a>)</span></h1>
				<p>Permite ejecutar experiencias de control tanto de forma virtual (simulando con el modelo correspondiente) como real (accionando un dispositivo en tiempo real).</p>
				<p style=" text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;">
					<img width=100 height=100 alt="" hspace=1 vspace=1 src="img/blank.png">
					<img width=100 height=100 alt="" hspace=1 vspace=1 src="img/uclv_logo.jpg">
					<img width=30  height=100 alt="" hspace=1 vspace=1 src="img/blank.png">
					<img width=100 height=100 alt="" hspace=1 vspace=1 src="img/upm_logo.jpg">
					<img width=25  height=100 alt="" hspace=1 vspace=1 src="img/blank.png">
					<img width=100 height=100 alt="" hspace=1 vspace=1 src="img/ubb_logo.jpg">
				</p>
			</div>
			<div class="blank"></div>
		</div>
		<div id="footer">
			Copyright &copy; 2017: GARP.UCLV-DIEE.UBB
		</div>
	</div>
</body>
</html>