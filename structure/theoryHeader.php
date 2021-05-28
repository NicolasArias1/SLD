<!-- NavBar -->
<nav class="navbar navbar-expand navbar-light my-navbar d-flex justify-content-between">

    <div class="navbar-nav ml-auto">
        <!-- Logo -->
        <?php require_once('logo.php')?>

        <!-- Mobile menu -->
        <?php require_once('mobileMenu.php')?>
    </div>

    <div class="d-none d-sm-block"> <!-- Hide on smaller than sm-->
        <div class="navbar-nav ml-auto">
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown ">
                <a class="nav-link " href="../../index.php" role="button">
                    <span class=" mr-2 d-none d-sm-inline small hov">Inicio</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link " href="../../general/theory.php" id="teoriag" role="button">
                    <span class="mr-2 d-none d-sm-inline small hov">Teoría</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link " href="../../general/platform.php" id="plataformag" role="button">
                    <span class="mr-2 d-none d-sm-inline small hov">Plataforma</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link " href="../../general/horarios.php" id="horariosg" role="button">
                    <span class="mr-2 d-none d-sm-inline small hov">Horarios</span>
                </a>
            </li>
        </div>
    </div>



    <!-- Login button -->
    <div class="d-none d-sm-block">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link " href="/general/loging.php">
                    <div class="btnLog" id="btnLogin">
                        <span class="mr-2 small">Iniciar sesión</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>

</nav>