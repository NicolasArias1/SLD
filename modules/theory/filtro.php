<?php
include('../../inc/useful.fns.php');

require_once('../../libraries/Mobile_Detect.php');

$detect = new Mobile_Detect;
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php require_once('../../general/css/libcss.php'); ?>
	<link rel="stylesheet" href="css/theory.css">
</head>

<body>
	<div id="wrapper">
		<!-- 
       Page Content -->
		<div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>

			<?php require_once('../../structure/theoryHeader.php'); ?>

			<div id="content">

				<div id="content2" class="container-fluid p-0 px-lg-0 px-md-0">

					<!-- End of Topbar -->

					<!-- Begin Page Content -->
					<div class="container-fluid px-lg-4 content_g ">
						<div class="row">
							<div id="content3" class="col-md-12 mt-lg-4 mt-4">
								<div class="content_theory">



									<h1 class="content_r_hst1">Implementaci&oacute;n de filtro digital</h1>


									<div class="contentp">
										<p> El filtrado es una parte muy importante de los sistemas de control, a
											trav&eacute;s de un filtro adecuadamente dise&ntilde;ado es posible obtener
											informaci&oacute;n de las variables de estado y c&oacute;mo se comportan en
											el
											proceso. Estos se encargan de filtrar la informaci&oacute;n que es
											fundamental,
											atenuando frecuencias no deseadas y eliminado en gran parte el ruido, el
											cual
											puede ser generado por el mismo proceso o a&ntilde;adido de forma externa a
											la
											se&ntilde;al.</p>
										<p> Los filtros se dividen principalmente en anal&oacute;gicos y digitales, cuya
											diferencia est&aacute; en la forma de implementarse; Los filtros
											anal&oacute;gicos se pueden dise&ntilde;ar e implementar de forma
											f&iacute;sica,
											un ejemplo de estos son los filtros pasivos (RLC). De la misma manera, pero
											haciendo uso de amplificadores operacionales y capacitores es posible
											dise&ntilde;ar filtros activos usados com&uacute;nmente en la
											electr&oacute;nica.</p>
										<p> Cuando se habla de filtros digitales se habla de filtros en tiempo discreto
											que
											son implementados a trav&eacute;s de c&oacute;digos en DSPs y que son
											posibles
											de dise&ntilde;ar a partir de los filtros anal&oacute;gicos con herramientas
											matem&aacute;ticas que permiten la transformaci&oacute;n de tiempo continuo
											al
											discreto, como lo es la aproximaci&oacute;n de Tustin, la derivada discreta
											y la
											invariancia.</p>
										<p> El objetivo de esta gu&iacute;a es mostrar algunos m&eacute;todos para el
											dise&ntilde;o de filtros digitales y la implementaci&oacute;n de estos a
											trav&eacute;s de la plataforma de laboratorios a distancia en la maqueta de
											estanques presente en la p&aacute;gina web.</p>
									</div>


									<h2 class="content_r_hst2">1. Propiedades de Filtros LTI</h2>

									<div class="contentp">
										<p> Un filtro LTI es un sistema SISO din&aacute;mico lineal, gobernado por una
											ecuaci&oacute;n diferencial con coeficientes constantes. algunas de las
											propiedades elementales de los sistemas LTI son:</p>
										<h3 class="content_r_hst3"> a) Principio de Superposici&oacute;n:</h3>
										<p> Esta es la propiedad elemental de los sistemas lineales. Para un sistema en
											reposo a tiempo <td width="30">t=0</td>, si la respuesta a una entrada <td width="30">f<sub>1</sub>(t)</td> es <td width="30">y<sub>1</sub>(t)</td>
											, y
											la respuesta de <td width="30">f<sub>2</sub>(t)</td> = <td width="30">
												y<sub>2</sub>(t)</td>, entonces para una entrada compuesta como <td width="30">f<sub>3</sub>(t)</td> = a<td width="30">f<sub>1</sub>(t)</td>
											+ b
											<td width="30">f<sub>2</sub>(t)</td> (a y b constantes) la respuesta debe
											ser: <b>(1)</b>
										</p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn1.png" /> </p>
										<h3 class="content_r_hst3"> b) Propiedad de Diferenciaci&oacute;n:</h3>
										<p> Si la respuesta a la entrada f(t) es y(t), entonces la respuesta a la
											derivada
											de f(t), <td width="30">f<sub>1</sub>(t)</td> = df(t)/dt, es <b>(2)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn2.png" /> </p>
										<h3 class="content_r_hst3"> c)Propiedad de la Integraci&oacute;n:</h3>
										<p> Si la respuesta a la entrada f(t) es y(t), entonces la respuesta a la
											integral
											de f(t), es: <b>(3)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn3.2.png" /> </p>
										<h3 class="content_r_hst3"> d) Causalidad:</h3>
										<p> Un sistema causal es no-anticipatorio, lo que quiere decir que no responde a
											una
											entrada sin esta haber ocurrido antes. Los sistemas LTI f&iacute;sicos son
											por
											naturaleza causales.</p>
									</div>




									<h2 class="content_r_hst2">Fase no Lineal y Retardo de Grupo</h2>

									<div class="contentp">

										<p> Los filtros del tipo FIR se destacan por tener una fase lineal, lo que los
											hace
											muy buenos para el filtrado de audio y comunicaciones. Conseguir un retardo
											que
											se comporte linealmente no es siempre posible y esto trae consigo algunas
											consecuencias. Un sistema cuya respuesta frecuencial con una fase lineal se
											representa en (4), donde &alpha; ser&aacute; finalmente el retardo en el
											dominio
											temporal <b>(4)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn4.png" /></p>
										<p> o en el tiempo: <b>(5)</b></p>
										<p> <img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn5.png" /></p>

										<img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Fig.1.png" />
										<p style="text-align:center;"> Fig.1. Representaci&oacute;n de una fase no lineal</p>
										<p>Se muestra en la Fig.1. el que ser&iacute;a el comportamiento de una fase no
											lineal en el dominio frecuencial. se puede observar claramente que la fase
											del
											sistema produce atrasos &oacute; adelantos (esto sin considerar el futuro de
											la
											se&ntilde;al) de la respuesta temporal, lo que trae como consecuencia
											distorsiones. Es por esto que se busca hacer un an&aacute;lisis en torno a
											peque&ntilde;as frecuencias en donde la fase del sistema se comporte
											linealmente.</p>
										<p>Suponemos un sistema H(j&omega;) pasa todo, es decir |H( j&omega;) | = 1
											donde su
											respuesta en frecuencia queda representada por: <b>(6)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn6.png" /></p>
										<p>acotando un rango de frecuencias tal que &Delta;&omega; = (&omega; -
											&omega;0),
											dentro de este “grupo” de frecuencias la fase se comporta de manera lineal,
											al
											retardo ligado a esta fase lo llamaremos Retardo de Grupo, que ser&aacute;
											an&aacute;logo a a pero en un vecindario de frecuencia alrededor de
											&omega;0, se
											observa lo anterior en la Fig.2.</p>
										<img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Fig.2.png" />
										<p style="text-align:center;"> Fig.2. Representaci&oacute;n de una fase no lineal y su retargo de grupo</p>
										<p>El Retardo de Grupo (&tau;g) se puede definir como un retardo lineal que se
											tiene
											en un vecindario de frecuencias muy cercanas una de otras y es posible
											representarlo matem&aacute;ticamente como: <b>(7)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn7.png" /></p>
										<p> con: <b>(8)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn8.png" /></p>

										<p> En la Fig.3. y la Fig.4. que se muestran a continuaci&oacute;n se observa el
											efecto de una fase no lineal tanto en el dominio frecuencial como en el
											dominio
											temporal </p>
										<img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Fig.3.png" />
										<p style="text-align:center;"> Fig.3. Ejemplo de Retardo de Grupo</p>
										<p>En estas se puede observar que en si &tau;g no es m&aacute;s que un retardo
											dado
											por la “linealizaci&oacute;n” de una fase no lineal, que depende del valor
											de
											esta pendiente. Producto de este retardo se observa una distorsi&oacute;n en
											la
											respuesta temporal del sistema. En la Fig.3. es posible observar que el
											Retardo
											de Grupo es mayor alrededor de los 1200 [Hz], lo que significa que cerca de
											esta
											frecuencia la respuesta aparecer&aacute; m&aacute;s tarde en
											comparaci&oacute;n
											a otras, este efecto se observa en la figura siguiente.</p>
										<img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Fig.4.png" />
										<p style="text-align:center;"> Fig.4. Efecto del retardo de grupo en la respuesta temporal</p>
									</div>

									<h2 class="content_r_hst2">2. Selecci&oacute;n y Dise&ntilde;o de un Filtro</h2>

									<div class="contentp">
										<p>Para partir con el dise&ntilde;o de filtros es necesario saber qu&eacute;
											tipo de
											filtro es el adecuado, para esto se muestran algunas caracter&iacute;sticas.
										</p>
										<p style="text-align:center;">Tab.1. Caracter&iacute;sticas Filtros IIR y FIR</p>
										<img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Tab.1.png" />
									</div>


									<h2 class="content_r_hst3">2.1. Tiempo de Muestreo</h2>

									<div class="contentp">
										<p>Existen dos criterios que pueden ser aplicados para definir un periodo de
											muestreo acorde al sistema que se busca filtrar o analizar. ambos tienen que
											ver
											con la respuesta del sistema y su ancho de banda. uno de los criterios
											est&aacute; definido como <b>(9)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn9.png" /></p>
										<p> Donde Tr se define como el tiempo de subida del sistema.</p>
										<p> Otro criterio est&aacute; definido en funci&oacute;n del ancho de banda del
											sistema por muestrear. quedando: <b>(10)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn10.png" /> </p>
										<p>o de otra forma <b>(11)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn11.png" /></p>
										<p>Aplicando estos criterios se puede obtener un tiempo de muestreo con tal que
											la
											perdida de informaci&oacute;n sea m&iacute;nima.</p>
										<img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Fig.5.png" />
										<p style="text-align:center;"> Fig.5. Tiempo de muestreo para el criterio Tm = Tr/10</p>
									</div>

									<h2 class="content_r_hst3">2.2. Transformaciones de Tiempo Continuo a Tiempo
										Discreto.</h2>

									<div class="contentp">
										<p>Hay muchos m&eacute;todos para el dise&ntilde;o de filtros del tipo IIR, a
											continuaci&oacute;n de muestran distintos m&eacute;todos para hacer la
											conversi&oacute;n de filtros dise&ntilde;ados en tiempo continuo a tiempo
											discreto</p>
										<p>Ya que el dise&ntilde;o de filtros Anal&oacute;gicos es una materia bien
											conocida, se hace l&oacute;gico hacer uso de estos para el dise&ntilde;o de
											filtros digitales.</p>
										<p>Un filtro en el dominio anal&oacute;gico puede ser descrito por su
											funci&oacute;n
											de transferencia en el dominio de la frecuencia <b>(12)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn12.png" /></p>
										<p>donde a y ß son coeficientes del filtro. De otra manera puede ser descrito
											por su
											respuesta al impulso, la cual esta´ relacionada con la transformada de
											Laplace. <b>(13)</b>
										</p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn13.png" /></p>
										<p>De forma alternativa podr&iacute;amos escribir la funci&oacute;n de
											trasferencia
											Ha(s), como una ecuaci&oacute;n diferencial en tiempo continuo de la
											siguiente
											manera <b>(14)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn14.png" /></p>
										<p>As&iacute; los u(t) ser&aacute;n las entradas del filtro e y(t) ser&aacute;n
											las
											salidas. Cada una de las tres formas anteriores son equivalentes al momento
											de
											dise&ntilde;ar filtros anal&oacute;gicos, pero adem&aacute;s llevan a
											diferentes
											m&eacute;todos de discretizaci&oacute;n de filtros, y dise&ntilde;os de
											estos en
											el mundo digital. En vista de que los filtros se comportan como sistemas LTI
											es
											necesario tener en consideraci&oacute;n la ubicaci&oacute;n de los polos y
											zeros
											que describen su din&aacute;mica, es por esto que se hace necesario que se
											cumpla con algunos requisitos para hacer el mapeo del plano-s al plano-z.
										</p>

										<p>1. Que el eje j&omega; del plano s sea posible de mapear en su totalidad
											dentro
											del circulo unitario del plano-z. cumpli&eacute;ndose esto se hace posible
											hacer
											una relaci&oacute;n directa entra las frecuencias en el dominio continuo y
											el
											discreto.</p>
										<p>2. Que el lado izquierdo del lugar geom&eacute;trico de las ra&iacute;ces del
											plano-s sea posible de mapear dentro del circulo unitario del plano-z. con
											esto
											se consigue que la estabilidad del filtro no sea afectada por la
											conversi&oacute;n del tiempo continuo al tiempo discreto. </p>

									</div>

									<h3 class="content_r_hst3">2.2.1. Aproximaci&oacute;n de la Derivada hacia
										atr&aacute;s.</h3>

									<div class="contentp">
										<p>Esta es una de las aproximaciones m&aacute;s simples para convertir filtros
											previamente dise&ntilde;ados en tiempo continuo a filtros digitales. Se
											trabaja
											con la definici&oacute;n de la derivada discreta. De la siguiente manera: <b>(15)</b>
										</p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn15.png" /></p>
										<p>donde T representa el periodo de muestreo. Conociendo que: <b>(16)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn16.png" /></p>
										<p>y <b>(17)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn17.png" /></p>
										<p>De esta manera se tiene que igualando (16) y (17) se obtiene un reemplazo de
											<b>(18)</b>
										</p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn18.png" /></p>
										<p> Ejemplo 1: Teniendo la funci&oacute;n de transferencia de un filtro pasa
											bajos
											de primer orden. <b>(19)</b> </p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn19.png" /></p>
										<p>Reemplazando la aproximaci&oacute;n de la derivada en la funci&oacute;n de
											transferencia del filtro anal&oacute;gico previamente dise&ntilde;ado,
											quedando
											de la forma: <b>(20)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn20.png" /></p>
										<p>La ecuaci&oacute;n de diferencias de un filtro discreto de primer orden
											dise&ntilde;ado a partir de un filtro anal&oacute;gico con la
											aproximaci&oacute;n de la derivada hacia atr&aacute;s es: <b>(21)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn21.png" /></p>
										<p>A modo de ejemplo, a continuaci&oacute;n, se muestra un fragmento de
											c&oacute;digo en Matlab que corresponde al filtro previamente discretizado:
										</p>
										<img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Cod1.png" />
									</div>

									<h3 class="content_r_hst3">2.2.2. Aproximaci&oacute;n por la Transformaci&oacute;n
										Bilineal (Tustin).</h3>

									<div class="contentp">
										<p>Una de las m&aacute;s conocidas y utilizadas para el dise&ntilde;o de filtros
											discretos es la transformaci&oacute;n de Tustin. Esta tiene como
											caracter&iacute;stica principal que mapea todos los puntos pertenecientes al
											lado izquierdo del LGR en el plano-s, dentro del circulo unitario y los del
											lado
											derecho los mapea fuera de este, con esto se asegura de no afectar la
											estabilidad del filtro. Adem&aacute;s, esta transformaci&oacute;n mapea solo
											una
											vez el eje j&omega; en el c&iacute;rculo unitario del plano-z evitando la
											aparici&oacute;n de frecuencias alias. <b>(22)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn22.png" /></p>
										<p>Ejemplo 2: Teniendo la funci&oacute;n de transferencia de un filtro pasa
											bajos de
											primer orden. <b>(23)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn19.png" /></p>
										<p>Reemplazando (22) en (23) la funci&oacute;n de transferencia del filtro
											digital
											queda: <b>(24)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn24.png" /></p>
										<p>se encuentra una ecuaci&oacute;n de diferencias que es implementarle en
											Matlab. <b>(25)</b>
										</p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn25.png" /></p>
										<p>A continuaci&oacute;n, se muestra un fragmento de c&oacute;digo implementado
											en
											Matlab:</p>
										<img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Cod2.png" />
									</div>

									<div class="contentp">
										<h2 class="content_r_hst3">2.3. Dise&ntilde;o Filtros FIR Mediante Enventanado
										</h2>
										<p>Es el m&eacute;todo m&aacute;s simple para el dise&ntilde;o de filtros FIR.
											Este
											m&eacute;todo parte generalmente de una respuesta en frecuencia deseada
											ideal
											que se puede representar como <b>(26)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn26.png" /></p>
										<p>siendo hd(n) la correspondiente secuencia de respuesta al impulso, que se
											puede
											expresar en funci&oacute;n de hd(e<sup>j&omega;</sup>) como <b>(27)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn27.png" /></p>
										<p>siendo una forma particularmente simple de obtener un FIR. <b>(28)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn28.png" /></p>
										<p>de forma general se puede representar como el producto entre la respuesta
											impulso
											deseada y una ventana de longitud finita w(n); es decir: <b>(29)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn29.png" /></p>
										<h3 class="content_r_hst3">2.3.1. Ventana Rectangular.</h3>
										<p>El largo para un filtro Ventana Rectangular ser&aacute; <b>(30)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn30.png" /></p>
										<p>Para motivos de aplicaci&oacute;n de esta pr&aacute;ctica se tiene que la
											funci&oacute;n de transferencia <b>(31)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn31.png" /></p>
										<p>finalmente, la ecuaci&oacute;n de diferencias implemetable se encuentra como <b>(32) </b>
										</p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn32.png" /></p>
										<p>donde N es un n&uacute;mero entero que corresponde al largo del filtro y se
											obtiene <b>(33)</b></p>
										<p><img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Eqn33.png" /></p>
										<p>A continuaci&oacute;n, se muestra una fracci&oacute;n de c&oacute;digo
											implementado en Matlab</p>
										<img class="img-fluid rounded mx-auto d-block mbotom" src="../../../img/Cod3.png" />
										<p></p>
										<p></p>
										<p></p>
										<p></p>
										<h2 class="content_r_hst2">Referencias</h2>
										<p>[1] Katsuhiko Ogata, "Ingenier&iacute;a de control Moderna," 3a ed.,
											Minnesota,
											Tom Robbins,1998, pp. 147-154.</p>
										<p>[2] Anibal Ollero Baturone, Control por computador descripci&oacute;n y
											dise&ntilde;o optimo, 1a ed., 1991, pp.12.</p>
										<p>[3] Alan V. Oppenheim & Ronald W. Schafer, "T&eacute;cnicas de dise&ntilde;o
											de
											filtros," en Tratamiento de se&ntilde;ales en tiempo discreto. 3a ed.,
											Pearson
											Educaci&oacute;n, 2011.</p>
										<p>[4] Mario E. Salgado, Juan I. Yuz, Ricardo A. Rojas, "An&aacute;lisis en
											tiempo
											discreto," en An&aacute;lisis de sistemas lineales. 1a ed., Pearson
											Educaci&oacute;n, 2005.</p>
									</div>



								</div>
							</div>

						</div>

					</div>
					<!-- /.container-fluid -->

				</div>



			</div>
		</div>
		<!-- /#page-content-wrapper -->

	</div>
	<!-- /#wrapper -->
</body>
<?php require_once('js/libjs.php'); ?>

</html>