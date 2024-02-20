<?php

namespace App\Libraries;

use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserLib
{

    static function getByToken()
    {
        helper('cookie');
        try {
            $key = env('JWT.key', 'JWTKEY3ae92b9c2f845ebc689a');
            $token = get_cookie('authToken');
            if ($token) :
                $decoded = JWT::decode($token, new Key($key, 'HS256'));
                if ($decoded->iss == base_url()) :
                    $data = (array) $decoded->data;
                    $data['id'] = $decoded->sub;
                    $cacheKey = $data['id'];
                    if (!$return = cache($cacheKey)) :
                        $userModel = new UserModel();
                        $return = $userModel->where('md5(id)', $data['id'])->first();
                        cache()->save($cacheKey, $return, 60 * 60 * 24 * 5);
                    endif;
                    $return['id'] = $data['id'];
                    return $return;
                endif;
            else :
                // Token não condiz com dominio
                delete_cookie('authToken');
                return null;
            endif;
        } catch (\Throwable $th) {
            // delete_cookie('authToken');
            return false;
        }
    }

    static function getUserByEmail($email = null)
    {
        if ($email) :
            $userModel = new UserModel();
            return $userModel->where('email', $email)->first();
        else :
            return false;
        endif;
    }

    static function updateUserPassword($user_id, $password)
    {
        if ($user_id && $password) :
            $userModel = new UserModel();
            return $userModel->update($user_id, ['senha' => password_hash($password, PASSWORD_DEFAULT)]);
        else :
            return false;
        endif;
    }

    static function update($data)
    {
        $userModel = new UserModel();
        $userModel->where('md5(id)', userData('id'))->set($data)->update();
        cache()->delete(userData('id'));
    }
}
