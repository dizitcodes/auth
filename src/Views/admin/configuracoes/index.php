<?= $this->extend('admin/layout') ?>


<?= $this->section('style') ?>
<style>
    .checkmark-circle {
        width: 6rem;
        height: 6rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .checkmark__circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: green;
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .checkmark {
        width: 6rem;
        height: 6rem;
    }

    .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        stroke-width: 2;
        stroke: green;
        fill: none;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.6s forwards;
    }

    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!--//Page Toolbar//-->
<div class="toolbar px-3 px-lg-6 pt-3 pb-3">
    <div class="position-relative container-fluid px-0">
        <div class="row align-items-center position-relative">
            <div class="col-md-7 mb-3 mb-md-0">
                <h3 class="mb-0">Configurações</h3>
            </div>
        </div>
    </div>
</div>
<!--//Page Toolbar End//-->

<!--//Page content//-->
<div class="content pt-3 px-3 px-lg-6 d-flex flex-column-fluid position-relative">
    <div class="container-fluid px-0">

        <div class="row">
            <div class="col-md-12 mb-3 mb-lg-5">
                <!--Card-->
                <div class="card overflow-hidden h-100">
                    <!--Card body-->
                    <div class="card-body">
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-lg-5">
                                    <label>Nome da empresa</label>
                                    <input class="form-control" name="App.SiteName" value="<?= setting('App.SiteName') ?>">
                                </div>
                                <div class="col-md-6 mb-3 mb-lg-5">
                                    <label>Tempo de expiração para cotações</label>
                                    <select class="form-select" name="Budget.Expirate">
                                        <option value="+ 12 hours" <?= setting('Budget.Expirate') == '+ 12 hours' ? 'selected' : '' ?>>12 horas</option>
                                        <option value="+ 24 hours" <?= setting('Budget.Expirate') == '+ 24 hours' ? 'selected' : '' ?>>24 horas</option>
                                        <option value="+ 48 hours" <?= setting('Budget.Expirate') == '+ 48 hours' ? 'selected' : '' ?>>48 horas</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3 mb-lg-5">
                                    <label>Email</label>
                                    <input class="form-control" name="App.Email" value="<?= setting('App.Email') ?>">
                                </div>
                                <div class="col-md-6 mb-3 mb-lg-5">
                                    <label>Número do Whatsapp</label>
                                    <input class="form-control" name="App.Whatsapp" value="<?= setting('App.Whatsapp') ?>">
                                </div>
                                <div class="col-md-6 mb-3 mb-lg-5">
                                    <label>Link do Instagram</label>
                                    <input class="form-control" name="App.Instagram" value="<?= setting('App.Instagram') ?>">
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#wpApiJS_QrCodeModal" class="btn <?= $whatsappStatus != 'open' ? 'btn-info' : 'btn-success' ?>"><i class="bi bi-whatsapp"></i> <?= $whatsappStatus != 'open' ? 'Conectar' : 'Conectado' ?></button>
                                <button type="submit" class="btn btn-dark"><i class="bi bi-save"></i> Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($whatsappStatus == 'open') : ?>
    <div class="toolbar px-3 px-lg-6 pt-3 pb-3">
        <div class="position-relative container-fluid px-0">
            <div class="row align-items-center position-relative">
                <div class="col-md-7 mb-3 mb-md-0">
                    <h3 class="mb-0">Whatsapp</h3>
                    <a href="<?= base_url('admin/whatsapp/disconnect') ?>" class="badge badge-sm bg-danger">Desconectar</a>
                </div>
            </div>
        </div>
    </div>
    <div class="content pt-3 px-3 px-lg-6 d-flex flex-column-fluid position-relative">
        <div class="container-fluid px-0">

            <div class="row">
                <div class="col-md-12 mb-3 mb-lg-5">
                    <!--Card-->
                    <div class="card overflow-hidden h-100">
                        <!--Card body-->
                        <div class="card-body">
                            <form id="wpApiJS_SendText" action="<?= base_url('admin/whatsapp/send') ?>">
                                <div class="row">
                                    <div class="col-md-5 mb-3 mb-lg-5">
                                        <label>Enviar para:</label>
                                        <input class="form-control phoneMask" id="wppCheck" name="number" value="" placeholder="Número do contato." required>
                                    </div>
                                    <div class="col-md-2 mb-3 mb-lg-5">
                                        <label>Agendar o envio?</label>
                                        <select class="form-select" id="delay">
                                            <option>Não</option>
                                            <option>Sim</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3 mb-lg-5">
                                        <label>Enviar no dia:</label>
                                        <input class="form-control bg-light" type="date" id="delayDate" name="delay[date]" min="<?= date('Y-m-d') ?>" value="" disabled>
                                    </div>
                                    <div class="col-md-2 mb-3 mb-lg-5">
                                        <label>Enviar às:</label>
                                        <input class="form-control bg-light" type="time" id="delayTime" name="delay[time]" step="1" value="" disabled>
                                    </div>
                                    <div class="col-md mb-3 mb-lg-5">
                                        <label>Mensagem:</label>
                                        <input class="form-control" name="text" placeholder="Mensagem a ser enviada." required>
                                    </div>
                                    <div class="col-md-auto mb-3 mb-lg-5 d-flex align-items-end">
                                        <button type="submit" class="btn btn-success"><i class="bi bi-send"></i> Enviar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
<!--//Page content End//-->
<?= $this->endSection() ?>
<?= $this->section('modals') ?>
<div class="modal fade text-left" id="wpApiJS_QrCodeModal" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document" autofocus>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Conectar ao whatsapp</h5>
            </div>
            <div class="qrcode py-3 d-flex justify-content-center">
                <div id="wpApiJS_QrCodeImageContainer" class="d-flex align-items-center justify-content-center" style="width: 17rem; height:17rem; background:#fefefe">
                    <img src="<?= base_url('admin/img/load.gif') ?>" class="w-25">
                </div>
            </div>
            <div class="px-3 pb-3 lh-1 text-center">
                <small>Alguns QRCodes podem não funcionar, caso aconteça clique em atualizar.</small>
            </div>
            <div class="modal-footer py-1 d-flex justify-content-center">
                <button id="updateButton" type="button" onclick="updateQRCodeFromAPI()" class="btn btn-info">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Atualizar</span>
                </button>
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Fechar</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
    document.querySelectorAll('.phoneMask').forEach(input => {
        input.addEventListener('input', function() {
            var number = this.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
            var countryCode = '+55'; // Define o código do país

            // Verifica se o número já começa com o código do país
            var hasCountryCode = number.startsWith('55');
            if (hasCountryCode) {
                number = number.substr(2); // Remove o código do país para aplicar a máscara corretamente
            }

            if (number.length > 11) {
                number = number.substr(0, 11); // Limita a 11 dígitos
            }

            var formatted;
            if (number.length <= 10) { // Máscara para 10 dígitos
                formatted = number.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else { // Máscara para 11 dígitos
                formatted = number.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
            }

            // Adiciona o código do país apenas se não estava presente inicialmente
            // if (!hasCountryCode) {
            formatted = countryCode + ' ' + formatted;
            // }

            this.value = formatted;
        });
    });

    if (wppCheck = document.getElementById('wppCheck') ?? null) {
        wppCheck.addEventListener('change', (e) => {

            var number = e.target.value.replace(/\D/g, '');


            const apiUrl = '<?= base_url('admin/whatsapp/check') ?>/' + number;

            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json(); // Convertendo a resposta para JSON
                })
                .then(data => {
                    if (data.status == 'exist') {
                        e.target.classList.add('is-valid');
                        e.target.classList.remove('is-invalid');
                    } else {
                        e.target.classList.remove('is-valid');
                        e.target.classList.add('is-invalid');
                    }
                })

        });
    }


    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('wpApiJS_SendText');
        if (form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Evita o envio padrão do formulário

                // Preparando os dados para envio
                const formData = new FormData(form);

                // Opção selecionada para agendamento
                const delayOption = document.getElementById('delay').value;

                // Endereço para onde o formulário será enviado
                const actionUrl = form.getAttribute('action');

                // Usando fetch para enviar os dados do formulário, ignorando a resposta
                fetch(actionUrl, {
                    method: 'POST',
                    body: formData,
                }).then(() => {
                    // Este bloco é intencionalmente deixado vazio pois não estamos tratando a resposta
                }).catch((error) => {
                    // Mesmo em caso de erro, optamos por não tratar explicitamente aqui
                    console.error('Error:', error);
                });

                // Limpa os campos do formulário
                form.reset();

                // Exibe o SweetAlert2 com a mensagem apropriada
                if (delayOption === 'Não') {
                    Swal.fire('Enviado!', 'Sua mensagem foi encaminhada.', 'success');
                } else {
                    // Assumimos que qualquer envio com agendamento será tratado como agendado com sucesso
                    Swal.fire('Agendado!', 'Sua mensagem foi agendada.', 'info');
                }
            });
        }
    });

    const selectDelay = document.getElementById('delay');
    if (selectDelay) {
        selectDelay.addEventListener('change', (e) => {
            if (e.target.value == 'Sim') {
                document.getElementById('delayDate').classList.remove('bg-light');
                document.getElementById('delayDate').removeAttribute('disabled');
                document.getElementById('delayTime').classList.remove('bg-light');
                document.getElementById('delayTime').removeAttribute('disabled');
            } else if (e.target.value == 'Não') {
                document.getElementById('delayDate').classList.add('bg-light');
                document.getElementById('delayDate').setAttribute('disabled', true);
                document.getElementById('delayTime').classList.add('bg-light');
                document.getElementById('delayTime').setAttribute('disabled', true);
            }
        })
    }

    const modal = document.getElementById('wpApiJS_QrCodeModal')
    if (modal) {
        modal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            // const recipient = button.getAttribute('data-bs-whatever')
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.

            // Update the modal's content.
            const qrCodeImageContainer = modal.querySelector('#wpApiJS_QrCodeImageContainer');
            getQRCodeFromAPI(qrCodeImageContainer);

        })
    }

    function updateQRCodeFromAPI() {
        const qrCodeImageContainer = modal.querySelector('#wpApiJS_QrCodeImageContainer');
        getQRCodeFromAPI(qrCodeImageContainer);
    }

    function getQRCodeFromAPI(CONTAINER) {

        CONTAINER.innerHTML = '';
        CONTAINER.innerHTML = '<img src="<?= base_url('admin/img/load.gif') ?>" class="w-25">';

        const apiUrl = '<?= base_url('admin/whatsapp/connect') ?>';

        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Convertendo a resposta para JSON
            })
            .then(data => {
                if (data.status == 'await' || data.status == 'created') {
                    const qrCodeURL = data.qrcode; // Ajuste 'qrcode' conforme a estrutura do seu retorno

                    const img = document.createElement('img');
                    img.src = qrCodeURL;
                    img.alt = 'QR Code';
                    img.style.width = '17rem';
                    img.style.height = '17rem';

                    CONTAINER.innerHTML = '';
                    CONTAINER.appendChild(img);

                    // Aqui, agendamos a função updateQRCodeFromAPI para ser executada após 15 segundos
                    setTimeout(function() {
                        updateQRCodeFromAPI();
                    }, 15000); // 15000 milissegundos = 15 segundos

                } else if (data.status == 'open') {
                    CONTAINER.innerHTML = '';
                    CONTAINER.innerHTML = '<div class="checkmark-circle"><svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg></div>';
                    modal.querySelector('#updateButton').innerHTML = 'Conectado';
                    modal.querySelector('#updateButton').classList.replace('btn-info', 'btn-success');
                    modal.querySelector('#updateButton').removeAttribute('onclick');
                    modal.querySelector('#updateButton').setAttribute('data-bs-dismiss', "modal");
                    // Fechando a modal 
                    setTimeout(() => {
                        var modalInstance = bootstrap.Modal.getInstance(modal);
                        location.reload();
                    }, 3000);

                } else {
                    console.log(data.status);
                }
            })
            .catch(error => {
                console.error('There was a problem with your fetch operation:', error);
            });
    }

    /*** MASK */
    document.addEventListener('DOMContentLoaded', function() {
        // Adiciona eventos de input para campos com máscaras
        const inputs = document.querySelectorAll('[data-mask]');
        inputs.forEach(input => {
            input.addEventListener('input', aplicarMascara);
        });
    });

    function aplicarMascara(event) {
        let valor = event.target.value.replace(/\D/g, ''); // Remove tudo o que não é dígito
        const mascara = event.target.getAttribute('data-mask');

        let valorMascarado = '';
        let indiceValor = 0;

        for (let i = 0; i < mascara.length && indiceValor < valor.length; i++) {
            if (mascara[i] === '#') {
                valorMascarado += valor[indiceValor];
                indiceValor++;
            } else if (mascara[i] === '?') {
                if (valor.length >= 11 && indiceValor === 2) {
                    valorMascarado += valor[indiceValor];
                    indiceValor++;
                }
            } else {
                valorMascarado += mascara[i];
            }
        }

        event.target.value = valorMascarado;
    }
</script>
<?= $this->endSection() ?>