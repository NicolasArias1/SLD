<!-- NavBar -->
<nav class="navbar navbar-expand navbar-light my-navbar d-flex justify-content-between">

    <div class="navbar-nav ml-auto centra-head">
        <!-- Logo -->
        <div class="navbar-nav ps-4">
            <a class="navbar-brand" href="../../index.php">
                <span class="fs-4 fw-bolder" style="color: orange;">SLD</span>
                <span class="fs-4 fw-bolder" style="color: white;">WEB</span>
            </a>
        </div>

        <!-- Mobile menu -->
        <div class="d-sm-none ">
            <!-- Hide on wider than sm-->
            <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menú
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            <li><a class="dropdown-item" href="../index.php">Inicio</a></li>
                            <li><a class="dropdown-item" href="../general/theory.php">Teoría</a></li>
                            <li><a class="dropdown-item" href="../general/platform.php">Plataforma</a></li>
                            <li><a class="dropdown-item" href="../general/notavaible.php">Horarios</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/general/loging.php">Iniciar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="d-none d-sm-block">
        <!-- Hide on smaller than sm-->
        <div class="navbar-nav ml-auto">
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown ">
                <a class="nav-link " href="../index.php" role="button">
                    <span class=" mr-2 d-none d-sm-inline small hov">Inicio</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link " href="../general/theory.php" id="teoriag" role="button">
                    <span class="mr-2 d-none d-sm-inline small hov">Teoría</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link " href="../general/platform.php" id="plataformag" role="button">
                    <span class="mr-2 d-none d-sm-inline small hov">Plataforma</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link " href="../general/notavaible.php" id="horariosg" role="button">
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