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
				<h1 class="content_r_hst1">Control PD desacoplado de manipuladores</h1>
				<p>El control desacoplado de manipuladores se basa en la suposici&oacute;n de que no haya acoplamiento mec&aacute;nico entre los eslabones del manipulador, es decir, se analiza cada articulaci&oacute;n por separado y se ajustan los reguladores para cada actuador existente en el sistema (normalmente el mismo numero que el n&uacute;mero de grados de libertad del manipulador). Cada actuador de ve afectado por un torque de disturbio, que no es otra cosa mas que el torque generado por la articulaci&oacute;n acoplada al actuador en movimiento, y se calcula  a trav&eacute;s de la soluci&oacute;n del problema din&aacute;mico inverso (ver <a href="#" class="ast1">Modelado din&aacute;mico de manipuladores</a>).</p>
				<p>El control PD (Proporcional-Derivativo) desacoplado es el esquema de control m&aacute;s simple y es adecuado para aplicaciones que no requieran movimientos muy r&aacute;pidos, especialmente en manipuladores que tengan una tasa de reducci&oacute;n grande entre los actuadores y las articulaciones. El diagrama de bloques en lazo cerrado de este esquema es presentado en la figura 1.</p>
				<img src="../img/pddesac1.gif" />
				<p>Fig. 1. Esquema de lazo cerrado con control PD.</p>
				<p>donde:</p>
				<div class="content_r_data2">
					<div class="content_r_data_t2"></div>
					<div class="content_r_data_c">
						<table width="100%" cellpadding="0" cellspacing="0" class="data">
						  <tr>
								<td width="40">qm<sup>d</sup></td>
							  <td width="320">&Aacute;ngulo deseado en el eje del motor (Grados o radianes).</td>
							</tr>
							<tr>
							  <td>qm</td>
						    <td>&Aacute;ngulo real en el eje del motor (Grados o radianes).</td>
						  </tr>
						  <tr>
							  <td>K</td>
						    <td>Ganancia del motor (Adimensional).</td>
						  </tr>
						  <tr>
							  <td>J<sub>eff</sub></td>
						    <td>Momento de inercia del eje del motor y la carga (Kgm<sup>2</sup>).</td>
						  </tr>
						  <tr>
							  <td>B<sub>eff</sub></td>
						    <td>Coeficiente de fricci&oacute;n del rotor (Nm).</td>
						  </tr>
						  <tr>
							  <td>Kp</td>
						    <td>Ganancia proporcional del controlador (Adimensional).</td>
						  </tr>
						  <tr>
							  <td>Kd</td>
						    <td>Ganancia derivativa del controlador (Adimensional).</td>
						  </tr>
						  <tr>
							  <td>n</td>
						    <td>Relaci&oacute;n de reducci&oacute;n de los engranes</td>
						  </tr>
						  <tr>
							  <td>V(s)</td>
						    <td>Voltaje aplicado al motor (Acci&oacute;n de control).</td>
						  </tr>
						  <tr>
							  <td>t</td>
						    <td>Torque de disturbio (N.m)</td>
						  </tr>
						</table>
					</div>
					<div class="content_r_data_b2"></div>
				</div>
				<p />
				<h1 class="content_r_hst2">An&aacute;lisis de estabilidad</h1>
				<p>El sistema que nos representa la posici&oacute;n del eje del motor en funci&oacute;n del voltaje aplicado, es una ecuaci&oacute;n diferencial lineal invariante con el tiempo (ver <a href="#" class="ast1">Modelado de actuadores</a>) que esta representada por:</p>
				<img src="../img/pddesac2.gif" />
				<p>Del diagrama de la figura 1 podemos ver que la acci&oacute;n de control V(s)  esta dada por la ecuaci&oacute;n:</p>
				<img src="../img/pddesac3.gif" />
				<p>Tomando la transformada de Laplace a ambos miembros de la ecuaci&oacute;n (1) y sustituyendo la ecuaci&oacute;n (2) en (1) tenemos que:</p>
				<img src="../img/pddesac4.gif" />
				<p>donde:</p>
				<img src="../img/pddesac5.gif" />
				<p>es el polinomio caracter&iacute;stico en lazo cerrado del sistema.</p>
				<p>Si aplicamos el criterio de estabilidad de Routh-Hurwitz al polinomio caracter&iacute;stico, tenemos el siguiente arreglo de Routh-Hurwitz:</p>
				<div class="content_r_data">
					<div class="content_r_data_t"></div>
					<div class="content_r_data_c">
						<table width="100%" cellpadding="0" cellspacing="0" class="data">
						  <tr>
								<td width="30">S<sup>2</sup></td>
							  <td width="80">J<sub>eff</sub></td>
							  <td width="80">KKp</td>
							</tr>
							<tr>
							  <td>S<sup>1</sup></td>
						    <td>(B<sub>eff</sub>+KKd)</td>
						    <td>0</td>
						  </tr>
						  <tr>
							  <td>S<sup>0</sup></td>
						    <td>KKp</td>
						    <td>&nbsp;</td>
						  </tr>
						</table>
					</div>
					<div class="content_r_data_b"></div>
				</div>
				<p>En el cual se ve que el sistema en lazo cerrado ser&aacute; estable para todos los valores positivos de Kp y Kd siempre y cuando los disturbios sean acotados.</p>
				<h1 class="content_r_hst2">An&aacute;lisis del error en estado estable</h1>
				<p>El error de seguimiento esta dado por la siguiente ecuaci&oacute;n:</p>
				<img src="../img/pddesac6.gif" />
				<p>Para una entrada de referencia paso y un disturbio constante:</p>
				<img src="../img/pddesac7.gif" />
				<p>Podemos concluir ayud&aacute;ndonos del teorema del valor final que el error en estado estable para el sistema con control PD acoplado esta dado por:</p>
				<img src="../img/pddesac8.gif" />
				<p>Se puede ver f&aacute;cilmente que el error en estado estable ser&aacute; peque&ntilde;o para un disturbio constante, si la tasa de reducci&oacute;n de engranes es grande, y que adem&aacute;s se puede hacer el error peque&ntilde;o, definiendo una ganancia proporcional (Kp) grande.</p>
				<h1 class="content_r_hst2">Sintonizado del regulador PD</h1>
				<p>El sistema con controlador PD en lazo cerrado, es un sistema de segundo orden, por lo que la respuesta ante entradas de tipo paso, es determinada por la frecuencia natural wn y el factor de amortiguamiento relativo del sistema z.</p>
				<p>Normalmente en rob&oacute;tica se utiliza un factor de amortiguamiento z=1  para tener un sistema cr&iacute;ticamente amortiguado, por lo que la frecuencia natural no amortiguada wn determina la velocidad de la respuesta.</p>
				<p>Una vez determinadas estas dos magnitudes para una respuesta deseada, las ganancias Kp y Kd pueden ser evaluadas a trav&eacute;s del polinomio caracter&iacute;stico del sistema de la siguiente manera:</p>
				<img src="../img/pddesac9.gif" />
				<img src="../img/pddesac10.gif" />
				<h1 class="content_r_hst2">Bibliograf&iacute;a</h1>
				<p>[1] B. C. Kuo, Automatic Control Systems.</p>
				<p>[2] K. Ogata, Modern Control Engineering.</p>
				<p>[3] M. W. Spong, Robot Dynamics and Control.</p>
			</div>
			<div class="blank"></div>
		</div>
		<div id="footer">
			Copyright &copy; 2017: GARP.UCLV-DIEE.UBB
		</div>
	</div>
</body>
</html>
