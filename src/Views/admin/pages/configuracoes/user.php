<?= $this->extend('admin/layout') ?>


<?= $this->section('content') ?>
<!--//Page Toolbar//-->
<div class="toolbar px-3 px-lg-6 pt-3 pb-3">
    <div class="position-relative container-fluid px-0">
        <div class="row align-items-center position-relative">
            <div class="col-md-7 mb-3 mb-md-0">
                <h3 class="mb-0">Meus dados</h3>
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
                            <input type="hidden" name="_method" value="PUT">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-lg-5">
                                    <label>Nome</label>
                                    <input class="form-control" name="nome" value="<?= userData('nome') ?>">
                                </div>
                                <div class="col-md-6 mb-3 mb-lg-5">
                                    <label>Email <i class="bi bi-lock-fill"></i></label>
                                    <input class="form-control" readonly value="<?= userData('email') ?>">
                                </div>
                            </div>
                            <div class="row">
                                <!--input-with-icon-->
                                <div class="col-md-6 mb-3">
                                    <label class="small form-label" for="signUpPassword">Senha</label>
                                    <input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" data-format="password" class="pass form-control" id="signUpPassword">
                                </div>
                                <!--input-with-icon-->
                                <div class="col-md-6 mb-3">
                                    <label class="small form-label" for="signUpConfirmPassword">Confirme a senha</label>
                                    <input type="password" name="password-confirm" data-format="password" class="pass form-control" id="signUpConfirmPassword">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-check ms-auto">
                                        <input class="form-check-input" type="checkbox" id="viewPass">
                                        <label class="form-check-label" for="viewPass">
                                            Mostrar senha
                                        </label>
                                    </div>
                                    <div id="message" class="ms-1 mt-3">
                                        <b>A senha deve ser composta por:</b>
                                        <ul class="mt-1 list-unstyled" style="columns: 2;">
                                            <li id="lower" class="small">Uma letra <b>minúscula</b></li>
                                            <li id="upper" class="small">Uma letra <b>maiúscula</b></li>
                                            <li id="number" class="small">Um <b>número</b></li>
                                            <li id="special" class="small">Um <b>caractere especial</b></li>
                                            <li id="min" class="small">Mímimo de <b>8 caracteres</b></li>
                                            <li id="max" class="small">Máximo de <b>20 caracteres</b></li>
                                            <li id="pass" class="small">As senhas <b>devem ser iguais</b></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php if (userType(false) == 0) : ?>
                                <div class="row">
                                    <div class="col-md-12r mb-3 mb-lg-5">
                                        <label>Token API</label>
                                        <input class="form-control" readonly value="<?= userToken() ?>">
                                    </div>
                                </div>
                            <?php endif ?>
                            <div class="row">
                                <div class="col-md-12 mb-3 mb-lg-5 text-end">
                                    <button type="submit" class="btn btn-primary">Atualizar dados</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--//Page content End//-->
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
    document.getElementById('viewPass').addEventListener('change', function() {
        var senhaInputs = document.querySelectorAll('.pass');
        senhaInputs.forEach(function(input) {
            if (document.getElementById('viewPass').checked) {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        });
    });
    //cleave form formats
    check = {};
    var inputFormatter = function() {
        var input = document.querySelectorAll('[data-format]');
        if (input.length === 0) return;

        for (var i = 0; i < input.length; i++) {
            var inputFormat = input[i].dataset.format,
                blocks = input[i].dataset.blocks,
                delimiter = input[i].dataset.delimiter;
            blocks = blocks !== undefined ? blocks.split(' ').map(Number) : '';
            delimiter = delimiter !== undefined ? delimiter : ' ';

            switch (inputFormat) {
                case 'password':

                    input[i].addEventListener('focus', function(e) {
                        var myInput = document.querySelector('input[name="password"]');


                        document.querySelector("#message").classList.remove('d-none');

                        var lower = document.getElementById("lower");
                        var upper = document.getElementById("upper");
                        var special = document.getElementById("special");
                        var number = document.getElementById("number");
                        var min = document.getElementById("min");
                        var max = document.getElementById("max");
                        var pass = document.getElementById("pass");

                        e.target.addEventListener('keyup', function() {
                            var passwordConfirm = document.querySelector('input[name="password-confirm"]');

                            var specialLetters = /[!@#$%^&*]/g;
                            if (myInput.value.match(specialLetters)) {
                                special.classList.remove("text-danger");
                                special.classList.add("text-success");
                                check['special'] = true;
                            } else {
                                special.classList.remove("text-success");
                                special.classList.add("text-danger");
                                check['special'] = false;
                            }

                            var lowerCaseLetters = /[a-z]/g;
                            if (myInput.value.match(lowerCaseLetters)) {
                                lower.classList.remove("text-danger");
                                lower.classList.add("text-success");
                                check['lower'] = true;
                            } else {
                                lower.classList.remove("text-success");
                                lower.classList.add("text-danger");
                                check['lower'] = false;
                            }

                            var upperCaseLetters = /[A-Z]/g;
                            if (myInput.value.match(upperCaseLetters)) {
                                upper.classList.remove("text-danger");
                                upper.classList.add("text-success");
                                check['upper'] = true;
                            } else {
                                upper.classList.remove("text-success");
                                upper.classList.add("text-danger");
                                check['upper'] = false;
                            }

                            var numbers = /[0-9]/g;
                            if (myInput.value.match(numbers)) {
                                number.classList.remove("text-danger");
                                number.classList.add("text-success");
                                check['number'] = true;
                            } else {
                                number.classList.remove("text-success");
                                number.classList.add("text-danger");
                                check['number'] = false;
                            }

                            if (myInput.value.length >= 8) {
                                min.classList.remove("text-danger");
                                min.classList.add("text-success");
                                check['min'] = true;
                            } else {
                                min.classList.remove("text-success");
                                min.classList.add("text-danger");
                                check['min'] = false;
                            }

                            if (myInput.value.length <= 20) {
                                max.classList.remove("text-danger");
                                max.classList.add("text-success");
                                check['max'] = true;
                            } else {
                                max.classList.remove("text-success");
                                max.classList.add("text-danger");
                                check['max'] = false;
                            }

                            if (passwordConfirm.value == myInput.value) {
                                pass.classList.remove("text-danger");
                                pass.classList.add("text-success");
                                check['check'] = true;
                            } else {
                                pass.classList.remove("text-success");
                                pass.classList.add("text-danger");
                                check['check'] = false;
                            }

                            const areTrue = Object.values(check).every(
                                value => value === true
                            );
                            inputCheck['password'] = areTrue;
                            inputCheck['password-confirm'] = areTrue;


                        });


                    });
                    break;

                default:
                    input[i].addEventListener('change', function(e) {
                        if (e.target.maxLength > -1 && e.target.value.length > e.target.maxLength) {
                            e.target.classList.add('is-invalid');
                            inputCheck[e.target.name] = false;
                        } else if (e.target.minLength > -1 && e.target.value.length < e.target.minLength) {
                            e.target.classList.add('is-invalid');
                            inputCheck[e.target.name] = false;
                        } else {
                            e.target.classList.remove('is-invalid');
                            inputCheck[e.target.name] = true;
                        }
                    });
                    break;
            }
        }

    }();
</script>
<?= $this->endSection() ?>