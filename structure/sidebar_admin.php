<?php
require_once('../../libraries/Mobile_Detect.php');

$detect = new Mobile_Detect;
?>

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
                                            <li><a href="/modules/admin/configp.php"> Administrar prácticas</a></li>
                                            <li><a href="/modules/admin/index.php?body=realizadas"> Historial de prácticas</a></li>
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
                                            <li><a href="/modules/admin/users.php?body=profiles">Administrar usuarios</a></li>
                                            <li><a href="/modules/admin/users.php?body=users">Usuarios privilegiados</a></li>
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