<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <?php if ($__session->get("loggedin")) : ?>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#  " class="nav-link">Contact</a>
            </li>
        <?php endif ?>
    </ul>
    <?php if ($__session->get("loggedin")) : ?>
        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" XXXdata-toggle="dropdown" href="#">
                    <i class="far fa-comments"></i>
                    <!--span class="badge badge-danger navbar-badge">3</span-->
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <!-- Message Start ->
                        <div class="media">
                            <img src="<?= base_url(); ?>/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Brad Diesel
                                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        < Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start ->
                        <div class="media">
                            <img src="<?= base_url(); ?>/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">I got your message bro</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        <Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start >
                        <div class="media">
                            <img src="<?= base_url(); ?>/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">The subject goes here</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                        < Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <!--span class="badge badge-warning navbar-badge">15</span-->
                </a>
                <!--div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div-->
            </li>
        </ul>
    <?php endif ?>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="<?= base_url(); ?>/dist/img/logo.png" alt="INTIMES" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">INTIMES</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <?php if ($__session->get("loggedin")) : ?>
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info nav-link">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item has-treeview menu-open">
                                <a href="#" class="nav-link">
                                    <i style="font-size:30px;float:left;margin-right:10px;" class="nav-icon far fa-user-circle"></i>
                                    <p><?= $__session->get("user")->name; ?></p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        <?php endif ?>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <?php if (isset($__mainmenu) && count($__mainmenu) > 0) : ?>
                    <?php foreach ($__mainmenu as $mainmenu) : ?>
                        <li id="menu_<?= $mainmenu->id; ?>" class="nav-item has-treeview">
                            <a <?= (!@$__submenu[$mainmenu->id] != "") ? "href='" . base_url() . "/" . $mainmenu->url . "'" : "href='#'"; ?> class="nav-link">
                                <i class="nav-icon <?= $mainmenu->icon; ?>"></i>
                                <p>
                                    <?= $mainmenu->name; ?>
                                    <?php if (isset($__submenu[$mainmenu->id])) : ?> <i class="right fas fa-angle-left"></i> <?php endif ?>
                                </p>
                            </a>
                            <?php if (isset($__submenu[$mainmenu->id])) : ?>
                                <ul class="nav nav-treeview">
                                    <?php foreach ($__submenu[$mainmenu->id] as $submenu) : ?>
                                        <?php if (in_array($submenu->id, $__menu_ids)) : ?>
                                            <script>
                                                document.getElementById("menu_<?= $mainmenu->id; ?>").classList.add("menu-open");
                                            </script>
                                        <?php endif ?>
                                        <li class="nav-item">
                                            <a href="<?= base_url(); ?>/<?= $submenu->url; ?>" class="nav-link <?= (in_array($submenu->id, $__menu_ids)) ? "active" : ""; ?>" style="padding-left:50px;">
                                                <i class="<?= $submenu->icon; ?> nav-icon"></i>
                                                <p><?= $submenu->name; ?></p>
                                            </a>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            <?php endif ?>
                        </li>
                    <?php endforeach ?>
                <?php endif ?>
                <?php if ($__session->get("loggedin")) : ?>
                    <li class="nav-item has-treeview">
                        <a href="<?= base_url(); ?>/logout" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i> LOGOUT
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?= $__modulename; ?>
                    </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->