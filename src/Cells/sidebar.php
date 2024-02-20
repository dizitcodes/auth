<!--Simplebar css-->
<link rel="stylesheet" href="<?= base_url('admin/vendor/css/simplebar.min.css') ?>">

<!--///////////Page sidebar begin///////////////-->
<aside class="page-sidebar">
    <div class="h-100 flex-column d-flex justify-content-start">

        <!--Aside-logo-->
        <div class="aside-logo d-flex align-items-center flex-shrink-0 justify-content-start px-4 position-relative">
            <a href="<?= base_url() ?>" class="d-block">
                <div class="d-flex align-items-center flex-no-wrap text-truncate">
                    <!--Logo-icon-->
                    <img src="<?= base_url('admin/img/logo.svg') ?>" class="logo">
                    <!-- <span class="sidebar-icon size-40 d-flex align-items-center justify-content-center fs-4 lh-1 text-white rounded-3 bg-success fw-bolder"> Pd </span> -->
                    <span class="sidebar-text">
                        <!--Sidebar-text-->
                        <span class="sidebar-text text-truncate fs-3 fw-bold">

                        </span>
                    </span>
                </div>
            </a>
        </div>
        <!--Sidebar-Menu-->
        <div class="aside-menu px-3 my-auto" data-simplebar>
            <nav class="flex-grow-1 h-100" id="page-navbar">
                <!--:Sidebar nav-->
                <ul class="nav flex-column collapse-group collapse d-flex">

                    <li class="nav-item sidebar-title text-truncate opacity-50 small">
                        <i class="bi bi-three-dots"></i>
                        <span>Principal</span>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= ACTIVE == 'admin/dashboard' ? 'active' : '' ?> d-flex align-items-center text-truncate ">
                            <span class="sidebar-icon">
                                <span class="material-symbols-rounded">
                                    monitoring
                                </span>
                            </span>
                            <!--Sidebar nav text-->
                            <span class="sidebar-text">Dashboard</span>
                        </a>
                    </li>
                    <?php /* LEADS ?>
                    <li class="nav-item ">
                        <a href="<?= base_url('admin/leads') ?>" class="nav-link <?= ACTIVE == 'admin/leads' ? 'active' : '' ?> d-flex align-items-center text-truncate ">
                            <span class="sidebar-icon">
                                <span class="material-symbols-rounded">
                                    group
                                </span>
                            </span>
                            <!--Sidebar nav text-->
                            <span class="sidebar-text">Contatos</span>
                        </a>
                    </li>
                    <?php /* */ ?>
                    <li class="nav-item sidebar-title text-truncate opacity-50 small">
                        <i class="bi bi-three-dots"></i>
                        <span>Gerenciamento</span>
                    </li>
                    <li class="nav-item ">
                        <a href="<?= base_url('admin/configuracoes') ?>" class="nav-link <?= ACTIVE == 'admin/configuracoes' ? 'active' : '' ?> d-flex align-items-center text-truncate ">
                            <span class="sidebar-icon">
                                <span class="material-symbols-rounded">
                                    settings
                                </span>
                            </span>
                            <!--Sidebar nav text-->
                            <span class="sidebar-text">Configurações</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</aside>
<!--///////////Page Sidebar End///////////////-->

<!--///Sidebar close button for 991px or below devices///-->
<div class="sidebar-close d-lg-none">
    <a href="#"></a>
</div>
<!--///.Sidebar close end///-->