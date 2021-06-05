<?php
include('../../inc/useful.fns.php');

require_once('../../libraries/Mobile_Detect.php');

$detect = new Mobile_Detect;
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
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


									<h1 class="content_r_hst1">El motor de corriente directa</h1>
									<h1 class="content_r_hst2">Obtenci&oacute;n del modelo</h1>
									<div class="contentp">

										<p>El motor de corriente directa resulta un actuador com&uacute;n en sistemas de
											control. El mismo suministra de forma directa movimiento rotatorio y acoplado a
											trav&eacute;s de dispositivos mec&aacute;nicos simples, puede proveer movimiento
											traslacional. El circuito el&eacute;ctrico de la armadura y el campo se muestran
											en la siguiente figura:</p>
										<img class="img-fluid rounded mx-auto d-block" src="../../img/motorcd1.png" />
										<div class="content_simbo_p">
											<div class="content_simbo_motorcd">
												<h1 class="title_simbology">Simbología:</h1>
												<hr class="linehr">
												<table width="100%" cellpadding="0" cellspacing="0" class="data">
													<tr>
														<td width="30">Ea:</td>
														<td width="175">Voltaje de armadura (Acción de control)</td>
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
										</div>
										<p>La fuerza contraelectromotriz es proporcional a la velocidad de rotaci&oacute;n
											del eje (Eb=Kb.w). Por otra parte, si el campo es constante, el momento que
											ejerce el eje sobre la carga es proporcional a la corriente de armadura
											(T=Ka.Ia). Y se sabe que las constantes Ka y Kb son num&eacute;ricamente iguales
											si ambas se expresan en el sistema internacional de unidades (K=Kb=Ka).
											Conociendo lo anterior y aplicando las leyes de Newton y de Kirchhoff's, las
											ecuaciones del modelo en transformada de Laplace quedan:</p>
										<p>(La.s + Ra).Ia(s) + K.w(s) = Ea(s)<br />(J.s + F).w(s) + Td(s) = K.Ia(s)</p>
										<p>Teniendo en cuenta el momento disturbio (Td), la relaci&oacute;n de engrane entre
											el eje y la carga (Re) y que el sensor disponible es el de posici&oacute;n (q),
											el diagrama en bloque queda como se muestra a continuaci&oacute;n:</p>
										<img class="img-fluid rounded mx-auto d-block" src="../../img/motorcd2.png" />
										<p>Despreciando la inductancia de armadura, que por lo general es peque&ntilde;a,
											este modelo puede reducirse a:</p>
										<img class="img-fluid rounded mx-auto d-block" src="../../img/motorcd3.png" />
										<p>Donde:</p>
										<img class="img-fluid rounded mx-auto d-block" src="../../img/motorcd4.png" />
										<p>No todos los par&aacute;metros del modelo m&aacute;s completo son f&aacute;ciles
											de obtener por lo que en la pr&aacute;ctica el modelo m&aacute;s utilizado es el
											reducido ya que se puede deducir sin grandes dificultades, mediante la
											identificaci&oacute;n experimental del sistema ante una entrada paso.</p>
										<p>Para ello, se aplica una variaci&oacute;n tipo paso en el voltaje de entrada y se
											registra la variaci&oacute;n de velocidad en el tiempo. Luego Km*Re =
											VarVel/VarVolt mientras Tm ser&aacute; el tiempo que tarda la velocidad en
											alcanzar el 63% del valor final.</p>
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