<?php include('../inc/useful.fns.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once('css/libcss.php'); ?>
    <link rel="stylesheet" href="css/loging.css">
</head>

<body>
    <div id="wrapper">
        <div id="page-content-wrapper" class="toggled">
            <?php require_once('../structure/mainHeader.php'); ?>

            <div id="content" class="container-fluid p-0 px-lg-0 px-md-0">
                <div class="container-fluid px-lg-4 content_g ">
                    <div class="row">
                        <div id="login" class="col-md-12 ">
                            <div class="containerlg">
                                <div class="loging w400">
                                    <div class="headlg w400">
                                        <p>Autenticación</p>
                                    </div>
                                    <div class="form w400">
                                        <form action="login.php" method="post" enctype="multipart/form-data">
                                            <label for="">Nombre de usuario</label>
                                            <input name="login" type="text" size="15" placeholder="Nombre de usuario">
                                            <label for="">Contraseña</label>
                                            <input name="passwd" type="password" size="15" placeholder="Contraseña">
                                            <div style="display:none;" class="input_celd">Dominio<br />
                                                <select name="domain" id="domain" class="input_field">
                                                    <option>db</option>
                                                </select>
                                            </div>
                                            <input type="submit" name="Submit" value="Enviar" class="btnlg" />
                                        </form>

                                        <div class="addlg">
                                            <a href="addusers.php" class="ast3">● Registrarse</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php require_once('js/libjs.php'); ?>

</html>