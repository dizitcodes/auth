<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to CodeIgniter 4!</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">

    <!--Google web fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@100..900&family=IBM+Plex+Mono:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />

    <!--Bootstrap icons-->
    <link href="<?= base_url('admin/fonts/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('admin/css/style.min.css') ?>">
    <!-- STYLES -->
</head>

<body>
    <div class="container px-0">
        <div class="row vh-100 align-items-center justify-content-center">
            <div class="col-12 col-md-10 col-lg-6 mx-auto">
                <div class="card">
                    <div class="card-body p-md-5 p-lg-7">
                        <div class="d-flex">
                            <h2 class="lh-1 mb-0 flex-shrink-0 me-4">
                                <span class="material-symbols-rounded fs-1 align-middle">bug_report</span>
                            </h2>
                            <div>
                                <h3 class="h2"><?= esc($title ?? 'Erro 404') ?></h3>
                                <p class="fs-6"><?= esc($message ?? 'Essa página não existe.') ?></p>
                                <a href="<?= base_url('auth') ?>" class="btn btn-light btn-sm">Voltar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>