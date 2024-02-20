<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<!--//content//-->
<div class="content vh-100 p-1 d-flex flex-column-fluid position-relative">
    <div class="container py-4">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-md-8 col-sm-10 col-lg-6 col-xl-5">
                <!--Card-->
                <div class="card card-body border-0 shadow-lg py-5 px-4">
                    <div class="text-center">
                        <div class="size-60 mx-auto mb-5 bg-success rounded-circle d-flex align-items-center justify-content-center text-white">
                            <span class="material-symbols-rounded fs-2 align-middle">check</span>
                        </div>
                        <div>
                            <h2 class="mb-3">Desconectado com sucesso!</h2>
                            <p class="mb-5 text-body-secondary">
                                Você será redirecionado em aproximadamente 3 segundos.
                            </p>
                            <a href="<?= base_url('auth') ?>" class="btn btn-primary">Voltar para o login <span class="material-symbols-rounded align-middle me-2">arrow_forward</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
    // Aguardar por 1 segundo (ou o tempo desejado)
    setTimeout(function() {
        window.location.href = "<?php echo base_url('auth'); ?>";
    }, 3000); // 1000 milissegundos = 1 segundo
</script>
<?= $this->endSection() ?>