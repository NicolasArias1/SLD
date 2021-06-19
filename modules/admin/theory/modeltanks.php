<?php
include('../../../inc/useful.fns.php');
include('../../../inc/user.class.php');

require_once('../../../libraries/Mobile_Detect.php');

$detect = new Mobile_Detect;

session_start();

$session = $_SESSION['user'];

if (empty($session)) {
    header('Location: ../../../index.php');
} //end if

$user = unserialize($session);
$uid = $user->getUID();
$name = $user->getName();
$login = $user->getLogin();
$mail = $user->getEMail();
$domain = $user->getDomain();
$level = $user->getPriority();
$_SESSION['user'] = serialize($user);

if ($level == 1)
    $usrHTML = "<li><a href=\"../../admin/index.php\" class=\"ast3\">Administrar</a></li>";
else if ($level == 2)
    $usrHTML = "<li>Operar</li>";
else if ($level == 3) {
    $usrHTML = "";
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once('../css/libcss.php'); ?>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../../theory/css/theory.css">

</head>

<body>
    <div id="wrapper">



        <!-- Sidebar -->

        <nav class="fixed-top align-top<?php if (!$detect->isMobile()) echo ' toggled' ?>" id="sidebar-wrapper" role="navigation">
            <div class="simplebar-content" style="padding: 0px;">

                <!-- Logo -->
                <div class="navbar-nav ps-4 pt-2">
                    <a class="navbar-brand" href="index.php">
                        <span class="fs-4 fw-bolder" style="color: orange;">SLD</span>
                        <span class="fs-4 fw-bolder" style="color: white;">WEB</span>
                    </a>
                </div>

                <ul class="navbar-nav align-self-stretch">

                    <li class="">
                        <a href="/modules/admin/index.php" class="nav-link text-left nosub" role="button">
                            <i class="fas fa-circle"></i>
                            Inicio
                        </a>
                    </li>

                    <li class="has-sub">
                        <a class="nav-link collapsed text-left nosub" href="#" role="button" data-toggle="collapse" data-target="#sech">
                            <i class="fas fa-calendar"></i> Horarios
                        </a>
                        <div class="collapse menu mega-dropdown" id="sech">
                            <div class="dropmenu" aria-labelledby="navbarDropdown">
                                <div class="container-fluid ">
                                    <div class="row">
                                        <div class="col-lg-12 px-2">
                                            <div class="submenu-box">
                                                <ul class="list-unstyled m-0">
                                                    <li><a href="/modules/admin/notavaible.php">Horarios reservados</a></li>
                                                    <li><a href="/modules/admin/notavaible.php"> Solicitud de horarios</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="has-sub">
                        <a class="nav-link collapsed text-left nosub" href="#collapseExample2" role="button" data-toggle="collapse" data-target="#secp">
                            <i class="fas fa-screwdriver"></i> Mis prácticas
                        </a>
                        <div class="collapse menu mega-dropdown" id="secp">
                            <div class="dropmenu" aria-labelledby="navbarDropdown">
                                <div class="container-fluid ">
                                    <div class="row">
                                        <div class="col-lg-12 px-2">
                                            <div class="submenu-box">
                                                <ul class="list-unstyled m-0">
                                                    <li><a href="/modules/admin/configp.php"> Administrar prácticas</a>
                                                    </li>
                                                    <li><a href="/modules/admin/index.php?body=realizadas"> Historial de
                                                            prácticas</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="has-sub">
                        <a class="nav-link collapsed text-left nosub" href="#collapseExample2" role="button" data-toggle="collapse" data-target="#secu">
                            <i class="fas fa-users"></i> Usuarios
                        </a>
                        <div class="collapse menu mega-dropdown" id="secu">
                            <div class="dropmenu" aria-labelledby="navbarDropdown">
                                <div class="container-fluid ">
                                    <div class="row">
                                        <div class="col-lg-12 px-2">
                                            <div class="submenu-box">
                                                <ul class="list-unstyled m-0">
                                                    <li><a href="/modules/admin/users.php?body=profiles">Administrar
                                                            usuarios</a></li>
                                                    <li><a href="/modules/admin/users.php?body=users">Usuarios
                                                            privilegiados</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="has-sub">
                        <a class="nav-link collapsed text-left nosub" href="#collapseExample2" role="button" data-toggle="collapse" data-target="#secas">
                            <i class="fas fa-book-open"></i> Asignaturas
                        </a>
                        <div class="collapse menu mega-dropdown" id="secas">
                            <div class="dropmenu" aria-labelledby="navbarDropdown">
                                <div class="container-fluid ">
                                    <div class="row">
                                        <div class="col-lg-12 px-2">
                                            <div class="submenu-box">
                                                <ul class="list-unstyled m-0">
                                                    <li><a href="/modules/admin/notavaible.php">Ver asignaturas</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="">
                        <a href="/modules/admin/theory.php" class="nav-link text-left nosub" role="button">
                            <i class="fas fa-journal-whills"></i>
                            Teoría
                        </a>
                    </li>

                    <li class="">
                        <a href="/modules/admin/platform.php" class="nav-link text-left nosub" role="button">
                            <i class="far fa-stop-circle"></i>
                            Plataforma
                        </a>
                    </li>

                    <li class="has-sub">
                        <a class="nav-link collapsed text-left nosub" role="button" data-toggle="collapse" data-target="#sece">
                            <i class="fas fa-users"></i> Estadísticas
                        </a>
                        <div class="collapse menu mega-dropdown" id="sece">
                            <div class="dropmenu" aria-labelledby="navbarDropdown">
                                <div class="container-fluid ">
                                    <div class="row">
                                        <div class="col-lg-12 px-2">
                                            <div class="submenu-box">
                                                <ul class="list-unstyled m-0">
                                                    <li><a href="/modules/admin/notavaible.php">Estadísticas generales</a></li>
                                                    <li><a href="/modules/admin/notavaible.php">Gráficos estadísticos</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="">
                        <a href="../../../general/logout.php" style="text-decoration:none;">
                            <div class="btnLogout">
                                <span class="mr-2 small">Cerrar sesión</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Page Content -->
        <div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>
            <!-- Topbar -->

            <nav class="navbar navbar-expand navbar-light my-navbar d-flex justify-content-between">

                <!-- Sidebar Toggle (Topbar) -->
                <div type="button" id="bar" class="nav-icon1 hamburger animated fadeInLeft is-closed<?php if (!$detect->isMobile()) echo ' open' ?>" data-toggle="offcanvas">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <!-- Date -->
                <div class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <span class="nav-link">
                            <span class="mr-2 d-none d-md-block small"><?php echo Date_Time(); ?></span>
                        </span>
                    </li>
                </div>

                <!-- User name -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link">
                            <div class="btnLog">
                                <span style="color:black;" class="mr-2 d-lg-inline small"><b><?php echo $name; ?></b></span>
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>


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

                                    <img class="img-fluid rounded mx-auto d-block" src="../../../../img/couptanks.jpg" />

                                    <h1 class="content_r_hst1"> <br />Modelo din&aacute;mico</h1>

                                    <div class="contentp">

                                        <p>Configurando el sistema para que quede como dos tanques en cascada (válvulas
                                            MVB,
                                            MV1 y MV2:
                                            abiertas, el resto cerradas), el proceso a modelar sería el siguiente:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../../img/tankscascada.jpg" />

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
                                        <img class="img-fluid rounded mx-auto d-block" src="../../../img/eqtank1.jpg" />

                                        <p>Para el estanque 2:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../../img/eqtank2.jpg" />

                                        <p>Las ecuaciones (1) y (2) constituyen un modelo no lineal de este sistema. En
                                            ellas k1 y k2 son las
                                            constantes de proporcionalidad entre el flujo y la ra&iacute;z cuadrada de
                                            la
                                            presi&oacute;n que
                                            est&aacute; asociada al factor de fricci&oacute;n, di&aacute;metro y largo
                                            de la
                                            tuber&iacute;a, el
                                            tipo de fluido y la aceleraci&oacute;n de la gravedad:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../../img/eqk.jpg" />
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
                                        <img class="img-fluid rounded mx-auto d-block" src="../../../img/eqh.jpg" />

                                        <p>Para peque&ntilde;as variaciones alrededor del punto de operaci&oacute;n se
                                            obtiene:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../../img/eqF.jpg" />

                                        <p>Poniendo en t&eacute;rminos de variaciones las ecuaciones (1) y (2) y
                                            utilizando
                                            la ecuaci&oacute;n
                                            (5) seg&uacute;n corresponda, se obtiene:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../../img/eqdeltah.jpg" />

                                        <p>Aplicando Transformada de Laplace en (6) se obtiene:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../../img/eqmodh1.jpg" />

                                        <p>Aplicando Transformada de Laplace en (7) seobtiene:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../../img/eqmodh2.jpg" />

                                        <p>En bloques, este modelo queda de la siguiente forma:</p>
                                        <img class="img-fluid rounded mx-auto d-block" src="../../../img/diagblk.jpg" />
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
                                        <p>Descargar datos de identificación.<a href="../../../download/downloadidentnivel.php?path=../../../download/&file=datanivel.mat"><img src="../../../../img/download.gif" vspace="2" alt="Descargar Modelo de Simulink enviado" /></p>

                                        <img class="img-fluid rounded mx-auto d-block" src="../../../img/codidentnivel.jpg" />
                                        <img class="img-fluid rounded mx-auto d-block" src="../../../img/grafidentnivel.jpg" />
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
</body>

<?php require_once('../js/libjs.php'); ?>
<script src="../js/index.js"></script>

</html>