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


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once('css/libcss.php'); ?>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="../../prints/css/admin_mypractices.css">


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
                                    <h1 class="content_r_hst1">Prácticas disponibles</h1>

                                    <a style="text-decoration: none;margin:0;color: whitesmoke; font-size: 13px;"
                                        href="/modules/user/practices.php">
                                        <div class="btnAddPractice" style="width:250px; justify-content:center">
                                            <i class="fas fa-arrow-circle-right"></i>
                                            <p style="margin:0;">Realizar práctica</p>
                                        </div>
                                    </a>
                                    
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