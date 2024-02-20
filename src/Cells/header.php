<!--//page-header//-->
<header class="navbar mb-3 px-3 px-lg-6 px-3 px-lg-6 align-items-center page-header navbar-expand navbar-light">
    <a href="<?= base_url() ?>" class="navbar-brand d-block d-lg-none">
        <div class="d-flex align-items-center flex-no-wrap text-truncate">
            <!--Sidebar-icon-->
            <span class="sidebar-icon bg-gradient-primary rounded-3 size-40 fw-bolder text-white">
                d
            </span>
        </div>
    </a>
    <ul class="navbar-nav d-flex align-items-center h-100">
        <li class="nav-item d-none d-lg-flex flex-column h-100 me-2 align-items-center justify-content-center" data-tippy-placement="bottom-start" data-tippy-content="Toggle Sidebar">
            <a href="javascript:void(0)" class="sidebar-trigger nav-link size-40 d-flex align-items-center justify-content-center p-0">
                <span class="material-symbols-rounded">
                    menu_open
                </span>
            </a>
        </li>
        <?= view_cell('ShortcutsCell::show') ?>

    </ul>
    <ul class="navbar-nav ms-auto d-flex align-items-center h-100">
        <!--:Dark Mode:-->
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="bs-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static">
                <span class="theme-icon-active d-flex align-items-center">
                    <span class="material-symbols-rounded align-middle"></span>
                </span>
            </a>
            <!--:Dark Mode Options:-->
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bs-theme" style="--bs-dropdown-min-width: 9rem;">
                <li class="mb-1">
                    <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="light">
                        <span class="theme-icon d-flex align-items-center">
                            <span class="material-symbols-rounded align-middle me-2">
                                lightbulb
                            </span>
                        </span>
                        Light
                    </button>
                </li>
                <li class="mb-1">
                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark">
                        <span class="theme-icon d-flex align-items-center">
                            <span class="material-symbols-rounded align-middle me-2">
                                dark_mode
                            </span>
                        </span>
                        Dark
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto">
                        <span class="theme-icon d-flex align-items-center">
                            <span class="material-symbols-rounded align-middle me-2">
                                invert_colors
                            </span>
                        </span>
                        Auto
                    </button>
                </li>
            </ul>
        </li>
        <?= view_cell('NotificationsCell::show') ?>
        <li class="nav-item dropdown d-flex align-items-center justify-content-center flex-column h-100">
            <a href="#" class="nav-link dropdown-toggle height-40 px-2 d-flex align-items-center justify-content-center" aria-expanded="false" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                <div class="d-flex align-items-center">

                    <!--Avatar with status-->
                    <div class="avatar-status status-online me-sm-2 avatar xs">
                        <img src="<?= avatar(userData('nome')) ?>" class="rounded-circle img-fluid" alt="">
                    </div>
                    <span class="d-none d-md-inline-block"><?= explode(' ', userData('nome'))[0] ?></span>
                </div>
            </a>

            <div class="dropdown-menu mt-0 p-0 dropdown-menu-end overflow-hidden">
                <!--User meta-->
                <div class="position-relative overflow-hidden px-3 pt-4 pb-7 bg-gradient-primary text-white">
                    <!--Divider-->
                    <svg style="transform: rotate(-180deg)" preserveAspectRatio="none" class="position-absolute start-0 bottom-0 w-100 dropdown-wave" fill="currentColor" height="24" viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0v46.29c47.79 22.2 103.59 32.17 158 28 70.36-5.37 136.33-33.31 206.8-37.5 73.84-4.36 147.54 16.88 218.2 35.26 69.27 18 138.3 24.88 209.4 13.08 36.15-6 69.85-17.84 104.45-29.34C989.49 25 1113-14.29 1200 52.47V0z" opacity=".25" />
                        <path d="M0 0v15.81c13 21.11 27.64 41.05 47.69 56.24C99.41 111.27 165 111 224.58 91.58c31.15-10.15 60.09-26.07 89.67-39.8 40.92-19 84.73-46 130.83-49.67 36.26-2.85 70.9 9.42 98.6 31.56 31.77 25.39 62.32 62 103.63 73 40.44 10.79 81.35-6.69 119.13-24.28s75.16-39 116.92-43.05c59.73-5.85 113.28 22.88 168.9 38.84 30.2 8.66 59 6.17 87.09-7.5 22.43-10.89 48-26.93 60.65-49.24V0z" opacity=".5" />
                        <path d="M0 0v5.63C149.93 59 314.09 71.32 475.83 42.57c43-7.64 84.23-20.12 127.61-26.46 59-8.63 112.48 12.24 165.56 35.4C827.93 77.22 886 95.24 951.2 90c86.53-7 172.46-45.71 248.8-84.81V0z" />
                    </svg>
                    <div class="position-relative">
                        <h5 class="mb-1"><?= userData('nome') ?></h5>
                        <p class="text-white text-opacity-75 small mb-0 lh-1"><?= userType(true) ?></p>
                    </div>
                </div>
                <div class="py-2 px-1">
                    <a href="<?= base_url() ?>" target="_blank" class="dropdown-item d-flex align-items-center">
                        <span class="material-symbols-rounded align-middle me-2 size-30 fs-5 d-flex align-items-center justify-content-center bg-secondary text-white rounded-2">
                            link
                        </span>
                        <span class="flex-grow-1">Abrir site</span>
                    </a>
                    <a href="<?= base_url('admin/usuario') ?>" class="dropdown-item d-flex align-items-center">
                        <span class="material-symbols-rounded align-middle me-2 size-30 fs-5 d-flex align-items-center justify-content-center bg-primary text-white rounded-2">
                            account_circle
                        </span>
                        <span class="flex-grow-1">Meus dados</span>
                    </a>
                    <a href="<?= base_url('admin/configuracoes') ?>" class="dropdown-item d-flex align-items-center">
                        <span class="material-symbols-rounded align-middle me-2 size-30 fs-5 d-flex align-items-center justify-content-center bg-danger text-white rounded-2">
                            settings
                        </span>
                        <span class="flex-grow-1">Configurações</span>
                    </a>
                    <hr class="my-2">
                    <a href="<?= base_url('auth/logout') ?>" class="dropdown-item d-flex align-items-center">
                        <span class="material-symbols-rounded align-middle me-2 size-30 fs-5 d-flex align-items-center justify-content-center bg-warning text-white rounded-2">
                            logout
                        </span>
                        <span class="flex-grow-1">Sair</span>
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item dropdown ms-3 d-flex d-lg-none align-items-center justify-content-center flex-column h-100">
            <a href="javascript:void(0)" class="nav-link sidebar-trigger-lg-down size-40 p-0 d-flex align-items-center justify-content-center">
                <span class="material-symbols-rounded align-middle">menu</span>
            </a>
        </li>
    </ul>
</header>
<!--Main Header End-->