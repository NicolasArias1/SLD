<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Sistema de Laboratorios a Distancia : : Plataforma</title>
  <link href="styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="page">
		<div id="header">
			<div id="header_t">
				<div id="header_t_l"><a href="http://garp.fie.uclv.edu.cu" target="_blank"><img src="img/logo.png" border="0" /></a></div>
				<div id="header_t_r">Domingo 01 de Marzo del 2009 10:13 PM</div>
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
					<li><a href="theory.php">Teor&iacute;a</a></li>
					<li><a href="practices.php">Pr&aacute;cticas</a></li>
					<li><a href="platform.php">Plataforma</a></li>
					<li><a href="#">Foro</a></li>
				</ul>
			</div>
			<div id="nav_r"></div>
		</div>
		<div id="content">
			<div id="content_l">
				<div id="content_l_t"></div>
				<div id="content_l_c">
					<form action="login.php" method="post" enctype="multipart/form-data">
						<h1 class="content_l_hst1">Autentificaci&oacute;n</h1>
						<div class="input_celd">Nombre<br />
						  <input name="login" type="text" size="15" class="input_field" />
						</div>
						<div class="input_celd">Contrase&ntilde;a<br />
						  <input name="passwd" type="password" size="15" class="input_field" />
						</div>
						<div class="input_celd">Dominio<br />
						  <select name="domain" id="domain" class="input_field">
						    <option>uclv</option>
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
				<h1 class="content_r_hst1">Plataforma para la elaboraci&oacute;n de pr&aacute;cticas de control en tiempo real a trav&eacute;s de Internet utilizando Matlab</h1>
				<h1 class="content_r_hst2">Introducci&oacute;n</h1>
				<p>Con el objetivo de dar respuesta a la necesidad de compartir recursos materiales costosos, disponibles en los laboratorios de diferentes centros de educaci&oacute;n superior cubanos, el Ministerio de Educaci&oacute;n Superior aprob&oacute; un proyecto para la creaci&oacute;n de la infraestructura t&eacute;cnica y did&aacute;ctico-metodol&oacute;gica necesaria que permita de forma remota, a trav&eacute;s de Internet, compartir estos recursos usando las nuevas t&eacute;cnicas de ense&ntilde;anza a distancia.</p>
				<p>Este trabajo propone una plataforma gen&eacute;rica para la realizaci&oacute;n de laboratorios remotos en los que se har&aacute;n pr&aacute;cticas de Control en Tiempo Real utilizando el Simulink Real Time Workshop con el Real Time Windows Target de Matlab. Dicha plataforma se basa en los principios del Matlab Web Server, pero a dem&aacute;s de las facilidades ya brindadas por dicho sistema, la nuestra permite que la estaci&oacute;n de trabajo est&eacute; sobre Windows 9x, que se pueda correr la misma pr&aacute;ctica en varias estaciones de forma transparente para el usuario y que el cliente pueda transferir ficheros hacia la estaci&oacute;n de trabajo con lo cual se garantizan cosas tales como que el usuario pruebe en la estaci&oacute;n sus propias estrategias de control y no solo las que est&eacute;n preestablecidas.</p>
				<h1 class="content_r_hst2">El Sistema de Laboratorios a Distancia</h1>
				<p>En el SLD las pr&aacute;cticas de Control en Tiempo Real se realizan con el Simulink Real Time Workshop, que junto a la Real Time Windows Target de Matlab garantiza Tiempo Real sobre Windows. Con este sistema se han montado pr&aacute;cticas de identificaci&oacute;n y control de velocidad y posici&oacute;n de un motor DC, comparaci&oacute;n de estrategias de control ante seguimiento de trayectoria para un robot Asea IRB-6 y por &uacute;ltimo el control con cambio de estrategia para el motor DC, un Robot ASEA IRB-6 y un sistema electroneum&aacute;tico. La configuraci&oacute;n Cliente - Servidor - Estaci&oacute;n de trabajo se muestra en la siguiente figura:</p>
				<img src="img/platform1.jpg" />
				<p>Para el env&iacute;o del mando anal&oacute;gico y la lectura de la posici&oacute;n del encoder se utiliza una tarjeta de fabricaci&oacute;n nacional cuyos drivers solo est&aacute;n disponibles para Windows 9x, por lo que la PC que est&eacute; conectada al proceso debe tener ese sistema operativo y no otro. Por esta raz&oacute;n se descart&oacute; la utilizaci&oacute;n en su totalidad del paquete Matlab Web Server, pero se tomaron de &eacute;l su filosof&iacute;a de trabajo y algunas funciones. Fue necesario, por tanto, la implementaci&oacute;n de un CGI para ubicarlo en la PC que lleve el Servidor Web. Dicho CGI extrae los datos del documento html de la misma forma que lo hace el matweb y se comunica con un servidor OLE-Automation (tambi&eacute;n implementado por nosotros) que se registra en la PC conectada al proceso donde radica el Matlab con el Real Time Windows Target sobre Windows 9x. Este servidor instancia un controlador de automation que se comunica con el servidor de automation del Matlab y corre en &eacute;l, el matlabfile que se especifique en la web que a su vez ejecuta el modelo en simulink que corre en tiempo real la pr&aacute;ctica requerida. Este funcionamiento se esquematiza en la siguiente figura:</p>
				<img src="img/platform2.jpg" />
				<p>En el caso de las pr&aacute;cticas con cambio de estrategias, el usuario se baja del servidor un mdl base que puede ejecutar de forma simulada en su PC con el Simulink de Matlab. Sobre este mdl, espec&iacute;ficamente dentro del bloque en que se define la estrategia de control, el usuario hace los cambios que quiera siempre que no modifique el n&uacute;mero de entradas y salidas de este bloque y otros que tambi&eacute;n puede modificar. Una ves hecho estos cambios pone el path de el nuevo mdl creado por &eacute;l en la web y al mandar a ejecuta la pr&aacute;ctica el CGI se encarga de transferir este fichero al servidor de la estaci&oacute;n que lo copia en esta m&aacute;quina y lo manda a ejecutar agreg&aacute;ndole los componentes necesarios para que se comunique con el proceso real.</p>
				<p>El sistema desarrollado mantiene la idea del Matlab Web Server en cuanto al uso de los ficheros de configuraci&oacute;n y su formato, de forma tal que para los usuarios que est&eacute;n habituados a trabajar con &eacute;l resulta muy c&oacute;modo pasarte a este nuevo sistema y aprovechar las nuevas posibilidades que implementa.</p>
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
