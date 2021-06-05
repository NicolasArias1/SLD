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
									<div class="contentp">
										<h1 class="content_r_hst1">Identificaci&oacute;n de sistemas por modelo PORT
										</h1>
										<p>Muchos sistemas f&iacute;sicos pueden modelarse como un sistema de primer
											orden
											con retardo de tiempo (PORT), de forma que su funci&oacute;n transferencial
											queda:</p>
										<img class="img-fluid rounded mx-auto d-block mbotom" src="../../img/port1.png" />
										<p>Si el sistema se somete a una entrada paso, la respuesta en funci&oacute;n
											del
											tiempo ser&iacute;a:</p>
										<img class="img-fluid rounded mx-auto d-block mbotom" src="../../img/port2.png" />
										<p>La ganancia del sistema puede calcularse como la variaci&oacute;n total en la
											salida entre la variaci&oacute;n total a la entrada:</p>
										<img class="img-fluid rounded mx-auto d-block mbotom" src="../../img/port3.png" />
										<p>Luego, dos puntos t&iacute;picos de la respuesta temporal son:</p>
										<p> - El tiempo que tarda en alcanzar el 28% del valor final. Esto ocurre en t =
											L+&tau;/3 dado que (1-e^-1/3) = 0.28, entonces se tiene una primera
											ecuaci&oacute;n: t28 = L + &tau;/3</p>
										<p> - El tiempo que tarda en alcanzar el 63% del valor final. Esto ocurre en t =
											L+&tau; dado que (1-e^-1) = 0.63, entonces se tiene una segunda
											ecuaci&oacute;n:
											t63 = L + &tau;</p>
										<p>Midiendo t28 y t63 se puede obtener L y &tau; despejando de las dos
											ecuaciones
											anteriores obteni&eacute;ndose:</p>
										<p> &tau; = (t63-t28)*3/2 </p>
										<p> L = t63 &tau; </p>
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