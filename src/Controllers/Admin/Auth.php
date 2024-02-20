<?php

namespace App\Controllers\Admin;

use App\Libraries\AuthLib;
use App\Libraries\UserLib;
use Firebase\JWT\JWT;

class Auth extends BaseController
{
    public $data;
    public function __construct()
    {
        $this->data = [
            'sidebar' => false,
            'header' => false,
            'footer' => false,
        ];
    }
    public function login()
    {
        $redirect = AuthLib::checkLogin(true);
        if ($redirect == true) :
            return $redirect;
        endif;

        // Verifica se existe um email no cookie
        if ($email = get_cookie('authEmail')) :
            // Se exite abre o metodo signin informando o email presente no cookie
            return $this->signin($email);
        else :
            // se não existe abre a view que captura o email
            return view('admin/pages/auth/getEmail', $this->data);
        endif;
    }

    public function signin($emailCookie = null)
    {
        // Obtém o número de tentativas de login a partir da sessão ou define como 0 se não existir
        $login_attempts = $this->session->get('login_attempts') ?? 0;
        $limit_attmpts = 4; // Define o limite de tentativas

        if ($login_attempts < $limit_attmpts) {
            // Permite tentar validar o email

            // Verifica se o email foi enviado no corpo da requisição POST
            $emailPost = $this->request->getPost('email');

            // Define o email como sendo o email do cookie, se disponível, caso contrário, usa o email do POST
            $email = $emailCookie ?? $emailPost;

            // Verifica se o usuário com o email fornecido existe
            if ($user = UserLib::getUserByEmail($email)) :
                // Pega a senha do corpo da requisição POST
                $senha = (string) $this->request->getPost('senha');

                // Se a senha não foi fornecida
                if (!$senha) :
                    // Se o email foi enviado no corpo da requisição POST, define um cookie de autenticação
                    if ($emailPost) :
                        set_cookie('authEmail', $email, 86400, '', '/', '', '', false, null);
                        $this->session->setTempdata('login_attempts', 0, 600); // Reseta o número de tentativas
                    endif;

                    // Define os dados do usuário e retorna a view para obter a senha
                    $this->data['usuario'] = $user;
                    return view('admin/pages/auth/getPassword', $this->data);

                // Se a senha foi fornecida, verifica se é válida
                elseif (password_verify($senha, $user['senha'])) :

                    // Monta o array do Token JWT e a Key
                    $key = env('JWT.key', 'JWTKEY3ae92b9c2f845ebc689a');
                    $dataToken = [
                        'iss' => base_url(),
                        'sub' => md5($user['id']),
                        'data' => ['email' => $user['email'], 'name' => $user['nome'], 'type' => $user['tipo']],
                        'iat' => time()
                    ];

                    // Verifica se o "manter conectado" foi enviado no corpo da requisição POST
                    $remember = $this->request->getPost('remember');
                    if ($remember) :
                        $dataToken['exp'] = strtotime('+1 year');
                        $token = JWT::encode($dataToken, $key, 'HS256');
                        set_cookie('authToken', $token, $dataToken['exp'] - time() - (60 * 60 * 3), '', '/', '', '', true, null);
                    else :
                        $dataToken['exp'] = $dataToken['iat'] + config('Session')->expiration;
                        $token = JWT::encode($dataToken, $key, 'HS256');
                        set_cookie('authToken', $token, $dataToken['exp'], '', '/', '', '', true, null);
                    endif;
                    // Retorna a view de login bem-sucedido
                    $this->data['user'] = $user;
                    $this->session->setTempdata('login_attempts', 0, 600); // Reseta o número de tentativas
                    return view('admin/pages/auth/successLogin', $this->data);
                else :
                    // Se a senha não for válida, redireciona de volta à página de autenticação com uma mensagem de alerta
                    $this->session->setTempdata('login_attempts', $login_attempts + 1, 600); // Incrementa o número de tentativas
                    setToast('error', 'Senha inválida, após ' . ($limit_attmpts - ($login_attempts + 1)) . ' tentativas inválidas,<br> você será impedido de logar por alguns minutos.', 'bottom');
                    return redirect()->to('auth');
                endif;

            // Se o email não foi encontrado, exclui o cookie e redireciona de volta à página de autenticação com uma mensagem de alerta
            else :
                delete_cookie('authEmail');
                $this->session->setTempdata('login_attempts', $login_attempts + 1, 600); // Incrementa o número de tentativas
                setToast('error', 'Email inválido, após ' . ($limit_attmpts - ($login_attempts + 1)) . ' tentativas inválidas,<br> você será impedido de logar por alguns minutos.', 'bottom');
                return redirect()->to('auth')->withCookies();
            endif;
        } else {
            // Muitas tentativas. Bloquear, exclui o cookie e redireciona de volta à página de autenticação com uma mensagem de alerta
            delete_cookie('authEmail');
            setToast('error', 'Muitas tentativas de login. Por favor, aguarde e tente novamente mais tarde.', 'bottom');
            return redirect()->to('auth')->withCookies();
        }
    }



    public function password_recovery(): string
    {
        return view('admin/pages/auth/password_recovery', $this->data);
    }

    public function send_recovery_link()
    {
        $email = (string) $this->request->getPost('email');

        $msg = "Acesse o link abaixo para alterar usa senha: <br />" . anchor(base_url('auth/password-reset/' . base64_encode($email) . date('dym') . md5(date('myd'))));

        // Carrega a biblioteca Email
        $mail = \Config\Services::email();

        // Configurações específicas para este e-mail
        $mail->setTo($email);
        $mail->setSubject('Redefinição de senha');
        $mail->setMessage($msg);

        // Envia o e-mail
        if ($mail->send()) {
            setToast('success', 'E-mail enviado com sucesso!', 'bottom');
        } else {
            setToast('error', 'Erro ao enviar o e-mail: ' . $mail->printDebugger(), 'bottom');
        }
        return redirect()->to('auth');

        return;
    }

    public function reset_password($token)
    {
        $token = explode(date('dym'), $token);
        $email = base64_decode($token[0]);
        if (($token[1] ?? null) == null) :
            setToast('error', 'Há um problema com seu link de redefinição de senha. Solicite novamente.', 'bottom');
            return redirect()->to(base_url('auth/password-recovery'));
        endif;
        $token = $token[1];
        // d(UserLib::getUserByEmail($email));
        // d(password_verify(date('myd'), $token[1]));
        if (UserLib::getUserByEmail($email) && md5(date('myd')) == $token) :
            return view('admin/pages/auth/password_create', $this->data);
        endif;
        setToast('error', 'Houve um problema ao solicitar <br>o link de recuperação de senha.<br>Verifique se o email está correto.', 'bottom');
        return redirect()->to(base_url('auth/password-recovery'));
    }

    public function update_password($token)
    {
        $token = explode(date('dym'), $token);
        $email = base64_decode($token[0]);
        if (($token[1] ?? null) == null) :
            setToast('error', 'Há um problema com seu link de redefinição de senha. Solicite novamente.', 'bottom');
            return redirect()->to(base_url('auth/password-recovery'));
        endif;
        $token = $token[1];
        $post = $this->request->getPost();
        if (($user = UserLib::getUserByEmail($email)) && md5(date('myd')) == $token && $post['password'] == $post['password-confirm']) :
            UserLib::updateUserPassword($user['id'], $post['password']);
            setToast('success', 'Sua senha foi alterada com sucesso!', 'bottom');
        else :
            setToast('error', 'Sua senha foi não alterada! Tente novamente mais tarde.', 'bottom');
        endif;
        return redirect()->to('auth');
    }

    public function logout()
    {
        helper('cookie');
        delete_cookie('authToken');
        delete_cookie('authEmail');

        return view('admin/pages/auth/logout', $this->data);
    }
}
