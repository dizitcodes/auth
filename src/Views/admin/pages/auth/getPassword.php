<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<!--//content//-->
<div class="content vh-100 p-1 d-flex flex-column-fluid position-relative">
    <div class="container py-4">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-sm-8 col-11 col-lg-5 col-xl-4">
                <!--Lockscreen Card-->
                <div class="card card-body pt-10">
                    <!--Lockscreen avatar-->
                    <img src="<?= avatar($usuario['nome']) ?>" class="avatar xxl p-1 p-lg-2 bg-body z-1 mt-n7 d-block mx-auto rounded-circle position-absolute top-0 start-50 translate-middle-x" alt="">

                    <h4 class="mb-3 pt-4 text-center"><?= $usuario['email'] ?>
                        <a href="javascript:clearEmail();" class="text-primary"><span class="material-symbols-rounded align-middle">sync</span></a>
                    </h4>
                    <form class="z-1 position-relative needs-validation" novalidate="" method="post">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <div class="position-relative mb-3">
                            <?= form_hidden('email', $usuario['email']) ?>
                            <input type="password" name="senha" class="form-control form-control-lg bg-transparent" required="" id="floatingLockscreenPass" placeholder="Password">

                            <button class="btn btn-primary p-0 d-flex align-items-center justify-content-center shadow-none border-0 position-absolute end-0 top-50 translate-middle-y me-1 h-75 width-40" type="submit">
                                <span class="material-symbols-rounded align-middle">
                                    arrow_forward
                                </span>
                            </button>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input me-1" id="remember" name="remember" type="checkbox" value="1">
                                <label class="form-check-label" for="remember">Manter conectado</label>
                            </div>
                            <div>
                                <a href="<?= base_url('auth/password-recovery') ?>" class="small text-body-secondary">Esqueceu sua senha?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
    function clearEmail() {
        var nomeCookie = 'authEmail';
        document.cookie = nomeCookie + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; domain=localhost; path=/;';
        location.reload();
    }
</script>
<?= $this->endSection() ?>