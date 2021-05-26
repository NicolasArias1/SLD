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
				<h1 class="content_r_hst1">Implementaci&oacute;n de controlador digital</h1>
				<h2 class="content_r_hst1">1.1	Controlador PID en Tiempo Continuo.</h2>
				<p>El control de sistemas físicos, químicos, eléctricos y electrónicos es muy importante en la industria, la medicina, transporte, comunicación, donde cada vez el control digital va tomando más énfasis.</p>
				<p> Herramientas computacionales como Matlab, Matlab Simulink y Octave permiten el análisis de los sistemas antes descritos, y hacen de la sintonización mucho más cómoda.</p>
				<p>Un controlador PID descrito en tiempo continuo y en función de las ganancias de la acción proporcional, integral y derivativa de la forma </p>
				<p> <img src="../img/Control/Eqn1.png" />, (1)</p> 
				<p>de la misma forma, pero ahora en función de las constantes de tiempo integrativa y derivativa</p>
				<p> <img src="../img/Control/Eqn2.png" />. (2)</p>
				<p>El control PID se caracteriza por su robustez y simplicidad en diseño, haciendo el control de sistemas lineales una tarea fácil.</p>
				<p>Una de las formas más prácticas para la representación del controlados está dada por la relación entrada salida del mismo, representada por su función de transferencia en el dominio de Laplace.</p>
				<p> <img src="../img/Control/Eqn3.png" />. (3)</p>
				<p>Esta ultima es muy utilizada en el análisis del comportamiento de la respuesta en lazo cerrado.</p>
				<img src="../img/Control/Fig.1.png" />
				<p>Fig.1. Diagrama en bloque de lazo de control realimentados (feedback)</p>
				<h2 class="content_r_hst1">1.2	Métodos de Sintonización.</h2>
				<h3 class="content_r_hst1">1.2.1	Método de Ziegler-Nichols.</h3>
				<p>Este es uno de los métodos más conocidos para la sintonización de controladores de lazo cerrado como PID, Consiste en llevar al sistema, en lazo cerrado, a régimen oscilatorio aumentando la ganancia, a esta ganancia se le conoce como ganancia crítica (Ku) y es luego utilizada para obtener los parámetros del control desde la tabla que los relaciona. Además, de este régimen se obtiene el periodo de oscilación crítica (Tu) que, al igual que la ganancia crítica, es utilizado en la sintonización. </p>
				<p>El método de la ganancia critica tiene como resultado una respuesta con un cuarto de razón de crecimiento.</p>
				<p>A modo de ejemplo se muestra la sintonización de una planta H<sub>p</sub>(s)  por el método de Ziegler-Nichols.</p>
				<p>Ejemplo 1:	Se propone hacer control sobre la planta que se muestra a continuación haciendo uso de Matlab y del método antes señalado.</p>
				<img src="../img/Control/Eg1.png" />
				<img src="../img/Control/Cod1.png" />
				<p>Tab.1. Parametros de control Ziegler-Nichols, ganancia crítica y Periodo crítico</p>
				<img src="../img/Control/Tab.1.png" />
				<p>A continuación, se muestran los resultados del código anterior:</p>
				<img src="../img/Control/Fig.2.png" />
				<p>Fig.2. Respuestas del Sistema Hp(s), a) Sistema en Régimen Oscilatorio, llevado con ganancia critica Ku. b) Respuesta al escalón del sistema Hp en lazo abierto.</p>
				<img src="../img/Control/Fig.3.png" />
				<p>Fig.3. Respuesta ante referencia paso, sistema lazo cerrado sintonizado con Ziegler-Nichols.</p>
				<p>Se observa en la comparación de las respuestas en lazo cerrado y lazo abierto que la respuesta mejora mucho en términos de velocidad, y que es justamente lo que se espera con un control PID, pero, cabe señalar que cae su ganancia estática</p>
				<h3 class="content_r_hst1">1.2.2	Asignación de Polos.</h3>
				<p>Hay plantas que, por el comportamiento de sus raíces, no es posible llevar a oscilación, un ejemplo de esto son las plantas de primer orden, que son descritas por el modelo PORT como:</p>
				<p> <img src="../img/Control/Eqn4.png" />. (4)</p>
				<p>Por simplicidad para el análisis consideraremos e<sup>-Ls</sup> unitario, lo que significa que no habrá retardo de tiempo, si observamos su LGR y su margen de ganancia, se observa que no es posible llevar a oscilación. Es ahí donde aparecen otros métodos de control cómo lo es asignación de polos. </p>
				<img src="../img/Control/Fig.4.png" />
				<p>Fig.4. Lugar geométrico de las raíces, planta de primer orden.</p>
				<img src="../img/Control/Fig.5.png" />
				<p>Fig.5. Margen de ganancia y fase, sistema de primer orden.</p>
				<p>El método en cuestión trata de ubicar los polos del lazo cerrado de tal manera que se pueda obtener una respuesta deseada.</p>
				<p>Se busca que el polinomio característico de la función de transferencia del lazo que se muestra a continuación se comporte como una respuesta típica de segundo orden P(s)=s<sup>2</sup>+2&xi;&omega;<sub>n</sub>+&omega;<sub>n</sub><sup>2</sup>.</p>
				<img src="../img/Control/Fig.6.png" />
				<p>Fig.6. Diagrama en bloques del lazo de control PI para una planta de primer orden.</p>
				<p>Así la F. de T. del lazo será:</p>
				<p> <img src="../img/Control/Eqn5.png" />, (5)</p>
				<p>De ella despejando su polinomio característico se tiene que</p>
				<p> <img src="../img/Control/Eqn6.png" />, (6)</p>
				<p>Luego igualando los coeficientes del polinomio característico del lazo cerrado con el que se busca tener se tiene que:</p>
				<p> <img src="../img/Control/Eqn7.png" />, (7)</p>
				<p>y</p>
				<p> <img src="../img/Control/Eqn8.png" />, (8)</p>
				<p>Así es posible determinar los coeficientes del control en función de la frecuencia angular del lazo y su factor de amortiguamiento, obteniendo una respuesta deseada.</p>
				<p>Despejando se tiene que los parámetros del control son</p>
				<p> <img src="../img/Control/Eqn9.png" />, (9)</p>
				<p>y</p>
				<p> <img src="../img/Control/Eqn10.png" />, (10)</p>
				<p> Con: </p>
				<p><img src="../img/Control/wn.png" />, </p>
				<p>donde T<sub>ss</sub> es el tiempo de asentamiento de la respuesta, este se encuentra buscando evitar la saturación del actuador de control.
				<p>Ejemplo 2:	Se propone hacer control sobre la planta que se muestra a continuación haciendo uso de Matlab y del método antes señalado.</p>
				<img src="../img/Control/Eg2.png" />
				<img src="../img/Control/Cod2.png" />
				<p>A partir del código anterior se obtiene la respuesta del lazo cerrado ante un cambio tipo paso en la referencia, se busca que dicha respuesta tenga un sobrepaso de un 4%, y un tiempo de asentamiento de 1 [s], esto junto a las igualdades que relacionan los parámetros del control con los parámetros de la planta, se obtiene la siguiente respuesta.</p>
				<img src="../img/Control/Fig.7.png" />
				<p>Fig.7. Respuesta ante un paso de referencia del sistema en lazo cerrado.</p>
				<p>Como se puede observar en la Fig.7, la respuesta tiene un sobrepaso superior al 4%, esto se debe a que el control PI, pone un cero en el LGR el cual cambia la dinámica del sistema, esta repuesta puede mejorarse aplicando un filtro de cancelación del cero del control en la referenciad de la forma siguiente.</p>
				<img src="../img/Control/Fig.8.png" />
				<p>Fig.8. Diagrama en bloque del lazo de control con filtro de cancelación de zero.</p>
				<p>Con esta implementación se mejora la respuesta obteniendo el sobrepaso para el cual se ha diseñado en controlador.</p>
				<img src="../img/Control/Fig.9.png" />
				<p>Fig.9. :"Comparación de las respuestas con filtro de cancelación de cero y sin filtro de cancelación de cero.</p>
				<p>Cómo se puede observar en la Fig.9, la respuesta se hace más lenta por la ausencia del cero puesto por el controlador, pero a la vez se obtiene una respuesta dada por el factor de amortiguamiento según diseño.</p>
				<h2 class="content_r_hst1">1.3	Modificaciones del Control PID.</h2>
				<h3 class="content_r_hst1">1.3.1	Anti-Windup.</h3>
				<img src="../img/Control/Fig.10.png" />
				<p>Fig.10. Diagrama de simulación del lazo cerrado con control PID modificado con Anti-windup.</p>
				<p>Con el objetivo de evitar la saturación del actuador de control, se diseña el controlador PID con una modificación, esta es conocida como Anti-windup, en la Ilustración 10 se muestra su diagrama de simulación para la implementación del mismo en Matlab Simulink, esta modificación lo que busca es saturar la señal de control cuando se produce un sobrepaso en la señal de mando, esto se consigue apagando la parte integrativa y así evitar la sobre-integración del erro y sacando en el mando el valor máximo de salida del mismo. En el código para Matlab que se muestra a continuación se observa cómo se implementa el anti-windup, se satura la señal de mando para el actuador y se “apaga” la parte integrativa haciendo sw=0, donde sw se encuentra multiplicando a la parte integrativa en el código que describe los parámetros del controlador.</p>
				<img src="../img/Control/Cod3.png" />
				<p>Cabe destacar que esta modificación saca al sistema de su zona lineal por lo que es preferible evitar la saturación del mando cambiando el tiempo de asentamiento con el que se diseña el controlador, pero en el caso de que sea posible aplicarlo es conveniente para evitar la sobre-integración del error y proteger al actuador de señales muy altas de tensión.</p>
				<h3 class="content_r_hst1">1.3.2	Filtro Derivada.</h3>
				<img src="../img/Control/Fig.11.png" />
				<p>Fig.11. Diagrama de simulación controlador PID modificado con filtro Derivada</p>
				<p>La presencia de ruido y pendientes fuertes en las mediciones producen un efecto indeseado en las acciones de control, ya que la acción derivativa amplifica este efecto (amplificando ruido), es por esta razón que la acción derivativa no puede y no debería ser implementada sin modificaciones. Es posible modificar la acción derivativa como se muestra en el diagrama de simulación de la Ilustración 11 con el objetivo de reducir el efecto de estas pendientes fuertes.</p>
				<p>Mirando esta modificación como una función de transferencia, haciendo</p>
				<p> <img src="../img/Control/Eqn11.png" />, (11)</p>
				<p>donde   se mueve típicamente entre 3 y 20 buscando reducir lo más posible el efecto derivativo, la nueva función de transferencia del controlador PID se encuentra simplemente reemplazando la aproximación de la ecuación (11) en (3), finalmente el control será<p>
				<p> <img src="../img/Control/Eqn12.png" />. (12)</p>
				<h2 class="content_r_hst1">1.4	Discretización.</h2>
				<img src="../img/Control/Fig.12.png" />
				<p>Fig.12. Lazo cerrado con control digital, retentor de orden cero y planta en tiempo continuo.</p>
				<p>El control digital toma cada vez más énfasis, los controladores antes diseñados en el mundo analógico pueden ser llevados al mundo digital por medio de la discretización de los mismos, para esto se presentan tres tipos de aproximaciones con diferentes características que cumplen con este objetivo.</p>
				<img src="../img/Control/Fig.13.png" />
				<p>Fig.13. Aproximaciones numéricas de integración. a) aproximación rectangular hacia adelante. b) Aproximación rectangular hacia atrás. c) Aproximación trapezoidal.</p>
				<p>En la Fig.13 se ven los diferentes tipos de aproximaciones de la integración, donde T corresponde al intervalo de muestreo, e(k) corresponde al error en el instante de tiempo kT, e(k+1)  corresponde al error en el instante de tiempo siguiente y e(k-1)  es el error en el instante de tiempo anterior.</p>
				<h3 class="content_r_hst1">1.4.1	Aproximación rectangular hacia adelante</h3>
				<p>A partir de la Fig.13.a) se tiene lo siguiente:</p>
				<p> <img src="../img/Control/Eqn13.png" />, (13)</p>
				<p>luego separando </p>
				<p> <img src="../img/Control/Eqn14.png" />, (14)</p>
				<p>aplicando la transformada  </p>
				<p> <img src="../img/Control/Eqn15.png" />. (15)</p>
				<p>Finalmente, la función de transferencia en el dominio z de un integrador quedara cómo</p>
				<p> <img src="../img/Control/Eqn16.png" />. (16)</p>
				<h3 class="content_r_hst1">1.4.2	Aproximación rectangular hacia atrás</h3>
				<p>A partir de la Fig.13.b) se tiene que </p>
				<p> <img src="../img/Control/Eqn17.png" />, (17)</p>
				<p>Luego separando</p>
				<p> <img src="../img/Control/Eqn18.png" />, (18)</p>
				<p>aplicando la transformada  </p>
				<p> <img src="../img/Control/Eqn19.png" />. (19)</p>
				<p>Finalmente, la función de transferencia en el dominio z de un integrador quedara cómo</p>
				<p> <img src="../img/Control/Eqn20.png" />. (20)</p>
				<h3 class="content_r_hst1">1.4.2	Aproximación rectangular hacia atrás</h3>
				<p>A partir de la Fig.13.c) se tiene que </p>
				<p> <img src="../img/Control/Eqn21.png" />, (21)</p>
				<p>Luego separando</p>
				<p> <img src="../img/Control/Eqn22.png" />, (22)</p>
				<p>aplicando la transformada  </p>
				<p> <img src="../img/Control/Eqn23.png" />. (23)</p>
				<p>Finalmente, la función de transferencia en el dominio z de un integrador quedara cómo</p>
				<p> <img src="../img/Control/Eqn24.png" />. (24)</p>
				<h3 class="content_r_hst1">1.4.4		Mapeo al plano-z.</h3>
				<p>Las aproximaciones antes mostradas llevan de forma diferente el semiplano izquierdo al círculo unitario del plano-z, esto se debe tanto a la cantidad de polos y ceros que tiene su función de transferencia, además la ubicación de los mismos. En la Ilustración 14 se muestra la correspondencia entre el plano-s y el plano-z.</p>
				<img src="../img/Control/Fig.14.png" />
				<p>Fig.14. Mapeo del semi-plano del plano-s al plano-z mediante las aproximaciones de integrales. a) Aproximación rectangular hacia adelante. b) Aproximación rectangular hacia atrás. c) Aproximación trapezoidal.</p>
				<h3 class="content_r_hst1">1.4.5	Control PID Discreto.</h3>
				<p>El uso de las aproximaciones descritas anteriormente va de la mano con la estabilidad del control, ya que las diferentes aproximaciones suponen un posicionamiento de los polos y ceros mas cercanos a la estabilidad o no. Es por esto que se muestra la estabilidad de la función de transferencia del PID en el Lugar Geométrico de las Raíces (LGR) en las siguientes ilustraciones. </p>
				<img src="../img/Control/Fig.15.png" />
				<p>Estabilidad del Control PID. a) aproximación Forward para la acción integrativa y forward para la acción derivativa. b) aproximación backward para la acción integrativa y backward para la acción derivativa .c) aproximación Forward para la acción integrativa y backward para la acción derivativa. d) aproximación backward para la acción integrativa y forward para la acción derivativa.</p>
				<p></p>	
				<p>La parte proporcional es la más simple, reemplazando t = kT se encuentra:</p>
				<p> <img src="../img/Control/Eqn25.png" />. (25)</p>
				<p>Como se observa en la Fig.15 la estabilidad del controlador cambia con la aproximación con la que sea discretizado, el uso de la aproximación hacia atrás para la parte derivativa tiene como ventaja la estabilidad de la misma, ya que uno de los polos se ubica en cero, mientras que la aproximación hacia adelante saca a los polos del circulo unidad. </p>
				<p> <img src="../img/Control/Eqn26.png" />, (26)</p>
				<p>despejando el presente de la derivación:</p>
				<p> <img src="../img/Control/Eqn27.png" />. (27)</p>
				<p>En cuanto a la parte integrativa, esta no tiene mayores problemas de estabilidad, pero en la literatura se ve usualmente la integración hacia adelante para la discretización de esta acción.</p>
				<p> <img src="../img/Control/Eqn28.png" />. (28)</p>
				<p>Se busca la ecuación en tiempo discreto:</p>
				<p> <img src="../img/Control/Eqn29.png" />. (29)</p>
				<p>A continuación, se muestra un código de ejemplo de implementación discreta del control PID antes discretizado.</p>
				<img src="../img/Control/Cod4.png" />
				<p></p>	
				<p></p>	
				<p></p>	
				<p></p>	
				<h2 class="content_r_hst2">Referencias</h2>
				<p>[1]	Katsuhiko Ogata, “Ingeniería de control Moderna,” 3a ed., Minnesota, Tom Robbins,1998, pp. 147–154.</p>
				<p>[2]	Anibal Ollero Baturone, Control por computador descripción y diseño optimo, 1a ed., 1991, pp.12.</p>
				<p>[3]	Alan V. Oppenheim & Ronald W. Schafer, “Técnicas de diseño de filtros,” en Tratamiento de señales en tiempo discreto. 3a ed., Pearson Educación, 2011.</p>
				<p>[4]	Mario E. Salgado, Juan I. Yuz, Ricardo A. Rojas, “Análisis en tiempo discreto,” en Análisis de sistemas lineales. 1a ed., Pearson Educación, 2005.</p>
				
				
			
			</div>
			<div class="blank"></div>
		</div>
		<div id="footer">
			Copyright &copy; 2017: GARP.UCLV-DIEE.UBB
		</div>
	</div>
</body>
</html>
