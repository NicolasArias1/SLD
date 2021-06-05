<?php
require_once('../../../libraries/Mobile_Detect.php');

$detect = new Mobile_Detect;
?>

<nav class="navbar navbar-expand navbar-light my-navbar d-flex justify-content-between">

    <!-- Sidebar Toggle (Topbar) -->
    <div type="button" id="bar" class="nav-icon1 hamburger animated fadeInLeft is-closed<?php if (!$detect->isMobile()) echo ' open' ?>" data-toggle="offcanvas">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- Date -->
    <div class="navbar-nav ml-auto">
        <li class="nav-item">
            <span class="nav-link">
                <span class="mr-2 d-none d-md-block small"><?php echo Date_Time(); ?></span>
            </span>
        </li>
    </div>

    <!-- User name -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link">
                <div class="btnLog">
                    <span style="color:black;" class="mr-2 d-lg-inline small"><b><?php echo $name; ?></b></span>
                </div>
            </a>
        </li>
    </ul>
</nav>