<?php
	include('../inc/useful.fns.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Teor&iacute;a</title>
    <link href="../styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="page">
		<div id="header">
			<div id="header_t">
				<div id="header_t_l"><img src="../img/logo.png" border="0" /></a></div>
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
					<form action="../login.php" method="post" enctype="multipart/form-data">
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
				</div>
				<div id="content_l_b"></div>
			</div>
			<div id="content_r">
				<h1 class="content_r_hst1">Identificaci&oacute;n de sistemas por modelo PORT</h1>
				<p>Muchos sistemas f&iacute;sicos pueden modelarse como un sistema de primer orden con retardo de tiempo (PORT), de forma que su funci&oacute;n transferencial queda:</p>
				<img src="../img/port1.png" />
				<p>Si el sistema se somete a una entrada paso, la respuesta en funci&oacute;n del tiempo ser&iacute;a:</p>
				<img src="../img/port2.png" />
				<p>La ganancia del sistema puede calcularse como la variaci&oacute;n total en la salida entre la variaci&oacute;n total a la entrada:</p>
				<img src="../img/port3.png" />
				<p>Luego, dos puntos t&iacute;picos de la respuesta temporal son:</p>
				<p>   -	El tiempo que tarda en alcanzar el 28% del valor final. Esto ocurre en t = L+&tau;/3 dado que (1-e^-1/3) = 0.28, entonces se tiene una primera ecuaci&oacute;n: t28 = L + &tau;/3</p>
				<p>   -	El tiempo que tarda en alcanzar el 63% del valor final. Esto ocurre en t = L+&tau; dado que     (1-e^-1) = 0.63, entonces se tiene una segunda ecuaci&oacute;n: t63 = L + &tau;</p>
				<p>Midiendo t28 y t63 se puede obtener L y &tau; despejando de las dos ecuaciones anteriores obteni&eacute;ndose:</p>
				<p>  &tau; = (t63-t28)*3/2 </p>
				<p>  L = t63 – &tau; </p>				
			</div>
			<div class="blank"></div>
		</div>
		<div id="footer">
			Copyright &copy; 2017: GARP.UCLV-DIEE.UBB
		</div>
	</div>
</body>
</html>
