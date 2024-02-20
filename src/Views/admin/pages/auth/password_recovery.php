<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<!--//content//-->
<div class="content vh-100 p-1 d-flex flex-column-fluid position-relative">
    <div class="container py-4">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-md-8 col-lg-5 col-xl-4">
                <!--Logo-->
                <a href="<?= base_url() ?>" class="d-flex position-relative mb-4 z-1 align-items-center justify-content-center">
                    <span class="sidebar-icon size-60 bg-gradient-primary text-white rounded-3">
                        <b class="fw-bolder fs-3">A</b>
                    </span>
                </a>
                <!--Card-->
                <div class="card card-body border-0 shadow-lg p-4">
                    <h4 class="mb-1">Recuperar senha</h4>
                    <p class="mb-4 text-body-secondary">
                        Digite seu e-mail para obter um link de redefinição de senha.
                    </p>
                    <form class=" z-1 position-relative needs-validation" method="post" novalidate="">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" required="" id="floatingInputEmail" value="<?= get_cookie('authEmail') ?? null ?>" <?= (get_cookie('authEmail') ?? null) ? 'readonly' : '' ?>>
                            <label for="floatingInputEmail">Endereço de e-mail</label>
                            <span class="invalid-feedback">Por favor insira um endereço de e-mail válido</span>
                        </div>
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Redefinir senha</button>
                        <hr class="mt-4 mb-3">
                        <p class="text-body-secondary mb-0">
                            Lembra da sua senha? <a href="<?= base_url('auth') ?>" class="ms-2">Entrar</a>

                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>