<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthLib
{
    static function checkHeaderToken()
    {
        try {
            $key = env('JWT.key', 'JWTKEY3ae92b9c2f845ebc689a');
            // Obtenha o cabeçalho da requisição
            $headers = getallheaders();
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            if ($token) :
                $decoded = JWT::decode($token, new Key($key, 'HS256'));
                if ($decoded->iss == base_url()) :
                    // token certo sem redirecionamento;
                    return true;
                else :
                    // Token não condiz com dominio
                    return false;
                endif;
            else :
                // Token não presento nos cookies
                return false;
            endif;
        } catch (\Throwable $th) {
            return false;
        }
    }
    static function checkLogin($redirectIfFalse = false)
    {
        helper('cookie');
        try {
            $key = env('JWT.key', 'JWTKEY3ae92b9c2f845ebc689a');
            $token = get_cookie('authToken');
            if ($token) :
                $decoded = JWT::decode($token, new Key($key, 'HS256'));
                if ($decoded->iss == base_url()) :
                    if ($redirectIfFalse) :
                        // token certo com redirecionamento
                        setToast('success', 'Bem vindo ' . $decoded->data->name . '!', 'top');
                        return redirect()->to('admin/dashboard')->withCookies();
                    else :
                        // token certo sem redirecionamento;
                        return true;
                    endif;
                else :
                    // Token não condiz com dominio
                    delete_cookie('authToken');
                    setToast('error', 'Ocorreu um problema tente novamente mais tarde.', 'bottom');
                    return false;
                endif;
            else :
                // Token não presento nos cookies
                return false;
            endif;
        } catch (\Throwable $th) {
            delete_cookie('authToken');
            if ($redirectIfFalse) :
                setToast('error', $th, 'bottom');
                return redirect()->to('auth?e')->withCookies();
            else :
                // setToast('error', $th, 'bottom');
                return false;
            endif;
        }
    }
}
