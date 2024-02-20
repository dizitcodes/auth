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
                    <form class="z-1 position-relative needs-validation" method="post" novalidate="">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <!--input-with-icon-->
                        <div class="mb-3">
                            <label class="small form-label" for="signUpPassword">Senha</label>
                            <input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" data-format="password" required class="pass form-control" id="signUpPassword">
                        </div>
                        <!--input-with-icon-->
                        <div class="mb-3">
                            <label class="small form-label" for="signUpConfirmPassword">Confirme a senha</label>
                            <input type="password" name="password-confirm" data-format="password" required class="pass form-control" id="signUpConfirmPassword">
                        </div>
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
                        <div class="d-grid">
                            <button id="formSubmit" class="btn btn-primary" type="submit">
                                Salvar
                            </button>
                            <hr class="mt-4">
                            <p class="text-muted text-center">
                                Lembra da sua senha?
                                <a href="<?= base_url('auth') ?>" class="ms-2 text-body">
                                    Clique aqui para entrar
                                </a>
                            </p>
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
                case 'cpf':
                    var cpf = new Cleave(input[i], {
                        numericOnly: true,
                        blocks: [3, 3, 3, 2],
                        delimiters: [".", ".", "-"],
                        onValueChanged: function(e) {
                            var cpf = e.target.rawValue
                            var cpfInput = document.querySelector('input[name="' + e.target.name + '"]');
                            if (cpfCheck(cpf) == false) {
                                console.log('CPF inválido');
                                cpfInput.classList.add('is-invalid');
                                inputCheck['cpf'] = false;
                            } else {
                                cpfInput.classList.remove('is-invalid');
                                cpfInput.classList.add('is-valid');
                                inputCheck['cpf'] = true;
                            }
                        }
                    });
                    break;
                case 'cnpj':
                    var cnpj = new Cleave(input[i], {
                        numericOnly: true,
                        blocks: [2, 3, 3, 4, 2],
                        delimiters: [".", ".", "/", "-"],
                        onValueChanged: function(e) {
                            var cnpj = e.target.rawValue
                            var cnpjInput = document.querySelector('input[name="' + e.target.name + '"]');
                            if (cnpjCheck(cnpj) == false) {
                                console.log('CPF inválido');
                                cnpjInput.classList.remove('is-valid');
                                cnpjInput.classList.add('is-invalid');
                                inputCheck['cnpj'] = true;
                            } else {
                                console.log('CPF válido');
                                cnpjInput.classList.remove('is-invalid');
                                cnpjInput.classList.add('is-valid');
                                inputCheck['cnpj'] = true;
                            }
                        }
                    });
                    break;
                case 'email':
                    input[i].addEventListener('change', function(e) {
                        if (emailCheck(e.target.value) == false) {
                            e.target.classList.add('is-invalid');
                            inputCheck['email'] = true;
                        } else {
                            e.target.classList.remove('is-invalid');
                            inputCheck['email'] = true;
                        }
                    });
                    break;

                case 'phone':
                    var phone = new Cleave(input[i], {
                        numericOnly: true,
                        blocks: [0, 2, 5, 4],
                        delimiters: ["(", ") ", "-"],
                        onValueChanged: function(e) {
                            var myInput = document.querySelector('input[name="' + e.target.name + '"]');
                            if (e.target.rawValue.length == 11) {
                                myInput.classList.remove('is-invalid');
                                inputCheck[e.target.name] = true;
                            } else {
                                myInput.classList.add('is-invalid');
                                inputCheck[e.target.name] = false;
                            }
                        }
                    });
                    break;

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
    inputCheck = {};
    document.querySelectorAll('input[required]').forEach(function(currentValue) {
        var name = currentValue.name;
        inputCheck[name] = false;
        console.log(inputCheck);

        currentValue.addEventListener('change', function(e) {
            console.log(inputCheck);
            const areTrue = Object.values(inputCheck).every(
                value => value === true
            );
            if (areTrue == true) {
                document.querySelector('#formSubmit').disabled = false;
            } else {
                document.querySelector('#formSubmit').disabled = true;
            }
        });
    });


    function cpfCheck(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf == '') return false;
        // Elimina CPFs invalidos conhecidos	
        if (cpf.length != 11 ||
            cpf == "00000000000" ||
            cpf == "11111111111" ||
            cpf == "22222222222" ||
            cpf == "33333333333" ||
            cpf == "44444444444" ||
            cpf == "55555555555" ||
            cpf == "66666666666" ||
            cpf == "77777777777" ||
            cpf == "88888888888" ||
            cpf == "99999999999")
            return false;
        // Valida 1o digito	
        add = 0;
        for (i = 0; i < 9; i++)
            add += parseInt(cpf.charAt(i)) * (10 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(9)))
            return false;
        // Valida 2o digito	
        add = 0;
        for (i = 0; i < 10; i++)
            add += parseInt(cpf.charAt(i)) * (11 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(10)))
            return false;
        return true;
    }

    function cnpjCheck(cnpj) {

        cnpj = cnpj.replace(/[^\d]+/g, '');

        if (cnpj == '') return false;

        if (cnpj.length != 14)
            return false;

        // Elimina CNPJs invalidos conhecidos
        if (cnpj == "00000000000000" ||
            cnpj == "11111111111111" ||
            cnpj == "22222222222222" ||
            cnpj == "33333333333333" ||
            cnpj == "44444444444444" ||
            cnpj == "55555555555555" ||
            cnpj == "66666666666666" ||
            cnpj == "77777777777777" ||
            cnpj == "88888888888888" ||
            cnpj == "99999999999999")
            return false;

        // Valida DVs
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0, tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;

        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;

        return true;

    }


    function emailCheck(email) {
        {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (email.match(mailformat)) {
                return true;
            } else {
                return false;
            }
        }
    }
</script>
<?= $this->endSection() ?>