 <!-- Sidebar -->
 <nav class="fixed-top align-top toggled" id="sidebar-wrapper" role="navigation">
            <div class="simplebar-content" style="padding: 0px;">
                <a class="sidebar-brand" href="index.php">
                    <img src="../../img/sld.png" alt="">

                </a>

                <ul class="navbar-nav align-self-stretch">

                    <li class="">
                        <a  class="nav-link text-left nosub" role="button">
                            <i class="fas fa-circle"></i> Inicio
                        </a>
                    </li>

                    <li class="has-sub">
                        <a class="nav-link collapsed text-left nosub" href="#" role="button" data-toggle="collapse"
                            data-target="#sech">
                            <i class="fas fa-calendar"></i> Horarios
                        </a>
                        <div class="collapse menu mega-dropdown" id="sech">
                            <div class="dropmenu" aria-labelledby="navbarDropdown">
                                <div class="container-fluid ">
                                    <div class="row">
                                        <div class="col-lg-12 px-2">
                                            <div class="submenu-box">
                                                <ul class="list-unstyled m-0">
                                                    <li><a href="">Horarios reservados</a></li>
                                                    <li><a href=""> Solicitud de horarios</a></li>
                                                    <!-- <li><a href="">Asp.net</a></li> -->
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="has-sub">
                        <a class="nav-link collapsed text-left nosub" href="#collapseExample2" role="button"
                            data-toggle="collapse" data-target="#secp">
                            <i class="fas fa-screwdriver"></i> Mis prácticas
                        </a>
                        <div class="collapse menu mega-dropdown" id="secp">
                            <div class="dropmenu" aria-labelledby="navbarDropdown">
                                <div class="container-fluid ">
                                    <div class="row">
                                        <div class="col-lg-12 px-2">
                                            <div class="submenu-box">
                                                <ul class="list-unstyled m-0">
                                                    <li><a href=""> Administrar prácticas</a></li>
                                                    <li><a href=""> Historial de prácticas</a></li>
                                                    <!-- <li><a href="">Asp.net</a></li> -->
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="has-sub">
                        <a class="nav-link collapsed text-left nosub" href="#collapseExample2" role="button"
                            data-toggle="collapse" data-target="#secu">
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
                        <a class="nav-link collapsed text-left nosub" href="#collapseExample2" role="button"
                            data-toggle="collapse" data-target="#secas">
                            <i class="fas fa-book-open"></i> Asignaturas
                        </a>
                        <div class="collapse menu mega-dropdown" id="secas">
                            <div class="dropmenu" aria-labelledby="navbarDropdown">
                                <div class="container-fluid ">
                                    <div class="row">
                                        <div class="col-lg-12 px-2">
                                            <div class="submenu-box">
                                                <ul class="list-unstyled m-0">
                                                    <li><a href="">Ver asignaturas</a></li>

                                                    <!-- <li><a href="">Asp.net</a></li> -->
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
                    <li class="" >
                        <a href="/modules/admin/platform.php"  class="nav-link text-left nosub" role="button">
                            <i class="far fa-stop-circle"></i>
                            Plataforma
                        </a>
                    </li>


                    <li class="has-sub">
                        <a class="nav-link collapsed text-left nosub" role="button"
                            data-toggle="collapse" data-target="#sece">
                            <i class="fas fa-users"></i> Estadísticas
                        </a>
                        <div class="collapse menu mega-dropdown" id="sece">
                            <div class="dropmenu" aria-labelledby="navbarDropdown">
                                <div class="container-fluid ">
                                    <div class="row">
                                        <div class="col-lg-12 px-2">
                                            <div class="submenu-box">
                                                <ul class="list-unstyled m-0">
                                                    <li><a href="">Estadísticas generales</a></li>
                                                    <li><a href="">Gráficos estadísticos</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="">
                        <a href="../../general/logout.php" style="text-decoration:none;">
                            <div class="btnLogout">
                                <span class="mr-2 small">Cerrar sesión</span>
                            </div>
                        </a>
                        
                    </li>

                </ul>


            </div>


        </nav>
        <!-- /#sidebar-wrapper -->