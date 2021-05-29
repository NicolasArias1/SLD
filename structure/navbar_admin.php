<nav class="navbar navbar-expand navbar-light my-navbar d-flex justify-content-between">

    <!-- Sidebar Toggle (Topbar) -->
    <div type="button" id="bar" class="nav-icon1 hamburger animated fadeInLeft is-closed" data-toggle="offcanvas">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="navbar-nav ml-auto">


        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown">
            <a class="nav-link " href="#" id="fechat" role="button" data-toggle="dropdown">
                <span class="mr-2 d-none d-lg-inline small"><?php echo Date_Time(); ?></span>
            </a>
        </li>

    </div>


    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">


        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown">
            <a class="nav-link " href="#" id="userDropdown" role="button" data-toggle="dropdown">
                <div class="btnLog">
                    <span class="mr-2 d-lg-inline small"><b><?php echo $name; ?></b></span>
                </div>



            </a>
        </li>

    </ul>

</nav>