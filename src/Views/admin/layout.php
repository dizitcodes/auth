<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <title>Painel de Gerenciamento</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">

    <!--Google web fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@100..900&family=IBM+Plex+Mono:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />

    <!--Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- STYLES -->
    <?= $this->renderSection('style') ?>

    <link rel="stylesheet" href="<?= base_url('admin/css/style.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('admin/css/custom.css') ?>">

</head>

<body>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    </script>
    <?= getAlert() ?>
    <?= view_cell('LoaderCell') ?>
    <?= view_cell('DarkmodeCell', $header ?? true) ?>
    <?= ($sidebar ?? true) ?  null : view_cell('OnlyLogoCell') ?>

    <div class="d-flex flex-column flex-root">
        <!--Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <?= ($sidebar ?? true) ? view_cell('SidebarCell::type') : null ?>

            <!--///////////Page content wrapper///////////////-->
            <main class="<?= ($sidebar ?? true) ? 'page-content' : null ?> d-flex flex-column flex-row-fluid">
                <?= ($header ?? true) ? view_cell('HeaderCell::type') : null ?>
                <?= $this->renderSection('content') ?>
                <?= ($footer ?? true) ? view_cell('FooterCell') : null ?>
            </main>
            <!--///////////Page content wrapper End///////////////-->
        </div>
    </div>

    <?= $this->renderSection('modals') ?>

    <!--////////////Theme Core scripts Start/////////////////-->
    <script src="<?= base_url('admin/js/theme.bundle.min.js') ?>"></script>
    <script src="<?= base_url('admin/js/custom.js') ?>"></script>

    <!--////////////Theme Core scripts End/////////////////-->

    <?= $this->renderSection('javascript') ?>

</body>

</html>