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
                                    <h1 class="content_r_hst1">Maqueta de tanques acoplados</h1>
                                    <div class="contentp">
                                        <p>La unidad de tanques acoplados consiste en cuatro tanques interconectados
                                            como se
                                            muestra en la
                                            figura, y en cada uno hay un sensor de presión en el fondo que entrega un
                                            voltaje
                                            proporcional al nivel (0-5 volt).</p>

                                        <p>Un quinto tanque se encuentra en la parte inferior, en el cual hay dos bombas
                                            sumergibles que
                                            entregan un flujo proporcional a la acción de control que se les aplique
                                            (0-5
                                            volt).</p>

                                        <p>La forma en que el agua fluye se puede configurar de muchas maneras con las
                                            vílvulas
                                            manuales(MVAG, MV14). La configuración de las válvulas permite cambiar la
                                            dinámica y el acoplamiento, así como la generación de pasos de
                                            perturbaciones
                                            que da amplias posibilidades para evaluar el desempeño de numerosas
                                            estrategias
                                            de control.
                                        </p>
                                    </div>

                                    <img class="img-fluid rounded mx-auto d-block" src="../../img/couptanks.jpg" />

                                    <h1 class="content_r_hst1"> <br />Modelo din&aacute;mico</h1>

                                    <div class="contentp">

                                        <p>Configurando el sistema para que quede como dos tanques en cascada (válvulas
                                            MVB,
                                            MV1 y MV2:
                                            abiertas, el resto cerradas), el proceso a modelar sería el siguiente:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../img/tankscascada.jpg" />

                                        <p> Donde h1(t) y h2(t) son el nivel en cada tanque [cm], u(t) el voltaje
                                            aplicado a
                                            la bomba [v], &eta;
                                            es la constante de proporcionalidad de la misma [cm^3/min.v], A, a1 y a2 el
                                            área
                                            de la
                                            sección transversal de los tanques y las tuberías respectivamente [cm^2] y g
                                            la
                                            aceleración de la gravedad [cm/s^2]</p>
                                    </div>


                                    <h1 class="content_r_hst1"> <br />Modelo No lineal</h1>


                                    <div class="contentp">

                                        <p>De acuerdo con el diagrama presentado, las ecuaciones del modelo no lineal
                                            son
                                            las siguientes:</p>
                                        <p>Para el estanque 1:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../img/eqtank1.jpg" />

                                        <p>Para el estanque 2:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../img/eqtank2.jpg" />

                                        <p>Las ecuaciones (1) y (2) constituyen un modelo no lineal de este sistema. En
                                            ellas k1 y k2 son las
                                            constantes de proporcionalidad entre el flujo y la ra&iacute;z cuadrada de
                                            la
                                            presi&oacute;n que
                                            est&aacute; asociada al factor de fricci&oacute;n, di&aacute;metro y largo
                                            de la
                                            tuber&iacute;a, el
                                            tipo de fluido y la aceleraci&oacute;n de la gravedad:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../img/eqk.jpg" />
                                    </div>



                                    <h1 class="content_r_hst1"> <br />Modelo Lineal</h1>

                                    <div class="contentp">

                                        <p>Para determinar la funci&oacute;n de transferencia de este sistema es
                                            necesario
                                            linealizarlo
                                            alrededor de un punto de operaci&oacute;n. Igualando a cero las ecuaciones
                                            (1) y
                                            (2) y evaluando
                                            para un voltaje constante en la bomba uo, se obtienen los puntos de
                                            operaci&oacute;n h1o y h2o:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../img/eqh.jpg" />

                                        <p>Para peque&ntilde;as variaciones alrededor del punto de operaci&oacute;n se
                                            obtiene:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../img/eqF.jpg" />

                                        <p>Poniendo en t&eacute;rminos de variaciones las ecuaciones (1) y (2) y
                                            utilizando
                                            la ecuaci&oacute;n
                                            (5) seg&uacute;n corresponda, se obtiene:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../img/eqdeltah.jpg" />

                                        <p>Aplicando Transformada de Laplace en (6) se obtiene:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../img/eqmodh1.jpg" />

                                        <p>Aplicando Transformada de Laplace en (7) seobtiene:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../img/eqmodh2.jpg" />

                                        <p>En bloques, este modelo queda de la siguiente forma:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../img/diagblk.jpg" />
                                    </div>



                                    <h1 class="content_r_hst1"> <br />Identificación experimental</h1>

                                    <div class="contentp">

                                        <p>A continuación se muestra la respuesta temporal del sistema en lazo abierto,
                                            ante
                                            una entrada
                                            tipo paso escalón a 3v en t=0, luego a 3.3v en t=1000s y finalmente a 2.7v
                                            en
                                            t=2000s. Todas
                                            las mediciones se han hecho con un periodo de muestreo de 0.1s. A partir de
                                            estas
                                            gráficas pueden obtenerse las ganancias estáticas K1 y K2 y las constantes
                                            de
                                            tiempo
                                            &tau;1 y &tau;2.</p>
                                        <p>Los datos correspondientes a estas curvas pueden descargarse del siguiente
                                            enlace
                                            y obtenerse con el
                                            código para Matlab que se muestra:</p>
                                        <p>Descargar datos de identificación.<a href="../../../download/downloadidentnivel.php?path=../../../download/&file=datanivel.mat"><img src="../../../img/download.gif" vspace="2" alt="Descargar Modelo de Simulink enviado" /></p>

                                        <img class="img-fluid rounded mx-auto d-block" src="../../img/codidentnivel.jpg" />
                                        <img class="img-fluid rounded mx-auto d-block" src="../../img/grafidentnivel.jpg" />
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
<script src="js/general.js"></script>

</html>