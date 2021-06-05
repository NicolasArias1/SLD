<?php
include('inc/useful.fns.php');
require_once('libraries/Mobile_Detect.php');

$detect = new Mobile_Detect;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php require_once('general/css/libcss.php'); ?>
</head>

<body>
    <div id="wrapper">
        <!-- 
       Page Content -->
        <div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>

            <?php require_once('structure/mainHeader.php'); ?>

            <div id="content">

                <div id="content2" class="container-fluid p-0 px-lg-0 px-md-0">

                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid px-lg-4 content_g ">
                        <div class="row">
                            <div id="content3" class="col-md-12 mt-lg-4 mt-4">

                                <div id="content_r">
                                    <h1 class="content_r_hst1">Desarrollado por GARP (UCLV) <br />
                                        <span class="content_r_sst1">(Grupo de Automatización Robótica y
                                            Percepción)</span>
                                    </h1>
                                    <h1 class="content_r_hst1">En colaboración con DISAM (UPM)<br /><span class="content_r_sst1">(Departamento de Automática, Ingeniería
                                            Electrónica e Informática Industrial</a>)</span></h1>
                                    <h1 class="content_r_hst1">En colaboración con DIEE (UBB)<br /><span class="content_r_sst1">(Departamento de Ingeniería Eléctrica y
                                            Electrónica</a>)</span></h1>
                                    <div class="content_r_hst3">
                                        <p>Permite ejecutar experiencias de control tanto de forma virtual (simulando
                                            con el
                                            modelo correspondiente) como real (accionando un dispositivo en tiempo
                                            real).
                                        </p>
                                        <p style=" margin-top:50px;">

                                            <img class="img-fluid rounded mx-auto " width=100 height=100 alt="" hspace=1 vspace=1 src="img/uclv_logo.jpg">

                                            <img class="img-fluid rounded mx-auto " width=100 height=100 alt="" hspace=1 vspace=1 src="img/upm_logo.jpg">

                                            <img class="img-fluid rounded mx-auto " width=100 height=100 alt="" hspace=1 vspace=1 src="img/ubb_logo.jpg">
                                        </p>
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

<?php require_once('general/js/libjs.php'); ?>

</html>