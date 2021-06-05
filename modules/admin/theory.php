<?php
include('../../inc/useful.fns.php');
include('../../inc/user.class.php');

require_once('../../libraries/Mobile_Detect.php');

$detect = new Mobile_Detect;

session_start();

$session = $_SESSION['user'];

if (empty($session)) {
    header('Location: ../../index.php');
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
    $usrHTML = "<li><a href=\"../admin/index.php\" class=\"ast3\">Administrar</a></li>";
else if ($level == 2)
    $usrHTML = "<li>Operar</li>";
else if ($level == 3) {
    $usrHTML = "";
}
//if($domain == 'db' && $level!=1) {
//	$usrHTML .= "<li><a href=\"users.php\" class=\"ast3\" title=\"Editar\">Editar Usuario</a></li>";
//}//end if
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once('css/libcss.php'); ?>
    <link rel="stylesheet" href="css/index.css">
    <link href="../../modules/theory/css/theory.css" rel="stylesheet" type="text/css" />

</head>

<body>
    <div id="wrapper">



        <!-- Sidebar -->
        <?php require_once('../../structure/sidebar_admin.php') ?>

        <!-- Page Content -->
        <div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>
            <!-- Topbar -->
            <?php require_once('../../structure/navbar_admin.php') ?>


            <div id="content">

                <div id="content2" class="container-fluid p-0 px-lg-0 px-md-0">

                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid px-lg-4 content_g ">
                        <div class="row">
                            <div id="content3" class="col-md-12 mt-lg-4 mt-4">
                                <div id="content_r">
                                    <h1 class="content_r_hst1">Consideraciones te&oacute;ricas:</h1>
                                    <table class="table table-bordered table-hover tsize">

                                        <thead>
                                            <tr class="bg-dark">
                                                <th class="col-sm-1" style="color:whitesmoke;" scope="col">N°</th>
                                                <th class="col-sm-8" style="color:whitesmoke;" scope="col">Teoría</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <tr>
                                                <th scope="row">1</th>
                                                <td><a href="../admin/theory/modeltanks.php" class="ast1">Modelado del sistema de tanques acoplados</a></td>

                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td><a href="../admin/theory/motorcd.php " class="ast1">Modelado de un motor de corriente directa</a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td><a href="../admin/theory/modeloport.php " class="ast1">Identificaci&oacute;n de Sistemas por modelo PORT</a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">4</th>
                                                <td><a href="../admin/theory/pddesac.php" class="ast1">PD
                                                        desacoplado para control de posici&oacute;n de motores</a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">5</th>
                                                <td><a href="../admin/theory/filtro.php " class="ast1">Implementaci&oacute;n de filtro digital</a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">6</th>
                                                <td><a href="../admin/theory/Control.php " class="ast1">Implementaci&oacute;n de controlador digital</a></td>
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
<script src="js/index.js"></script>

</html>