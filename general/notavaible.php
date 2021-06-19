<?php
require_once('../libraries/Mobile_Detect.php');

$detect = new Mobile_Detect;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php require_once('css/libcss.php'); ?>
</head>

<body>
    <div id="wrapper">
        <div id="page-content-wrapper" <?php if (!$detect->isMobile()) echo 'class="toggled"' ?>>

            <?php require_once('../structure/mainHeader.php'); ?>

            <div id="content" class="container-fluid p-0 px-lg-0 px-md-0">
                <div class="container-fluid px-lg-4 content_g ">
                    <div class="row">
                        <div id="content3" class="col-md-12 mt-lg-4 mt-4">
                            <h3>Módulo no disponible</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php require_once('js/libjs.php'); ?>

</html>