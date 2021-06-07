<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require_once('css/libcss.php');
    require_once('../libraries/Mobile_Detect.php');

    $detect = new Mobile_Detect;
    ?>

</head>

<body>
    <div id="wrapper">
        <!-- Page Content -->
        <div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>

            <?php require_once('../structure/mainHeader.php'); ?>

            <div id="content">

                <div id="content2" class="container-fluid p-0 px-lg-0 px-md-0">

                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid px-lg-4 content_g ">
                        <div class="row">
                            <div id="content3" class="col-md-12 mt-lg-4 mt-4">
                                <div id="content_r" style="width:500px;">
                                    <h1 class="content_r_hst1">Consideraciones te&oacute;ricas:</h1>
                                    <table style="font-size:14px;" class="table table-bordered table-hover tsize">

                                        <thead>
                                            <tr class="bg-dark">
                                                <th class="col-sm-1" style="color:whitesmoke;" scope="col">N°</th>
                                                <th class="col-sm-8" style="color:whitesmoke;" scope="col">Teoría</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <tr>
                                                <th scope="row">1</th>
                                                <td><a style="text-decoration:none;" href="../modules/theory/modeltanks.php" class="ast1">Modelado del sistema de tanques acoplados</a></td>

                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td><a style="text-decoration:none;" href="../modules/theory/motorcd.php " class="ast1">Modelado de un motor de corriente directa</a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td><a style="text-decoration:none;" href="../modules/theory/modeloport.php " class="ast1">Identificaci&oacute;n de Sistemas por modelo PORT</a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">4</th>
                                                <td><a style="text-decoration:none;" href="../modules/theory/pddesac.php" class="ast1">PD
                                                        desacoplado para control de posici&oacute;n de motores</a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">5</th>
                                                <td><a style="text-decoration:none;" href="../modules/theory/filtro.php " class="ast1">Implementaci&oacute;n de filtro digital</a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">6</th>
                                                <td><a style="text-decoration:none;" href="../modules/theory/Control.php " class="ast1">Implementaci&oacute;n de controlador digital</a></td>
                                            </tr>
                                        </tbody>


                                    </table>

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

<?php require_once('js/libjs.php'); ?>


</html>