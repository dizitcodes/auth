<?php
function userType($returnText = true)
{
    $user = App\Libraries\UserLib::getByToken();
    if ($returnText) :
        switch ($user['tipo']):
            case 0:
                return 'Super Administrador';
                break;
            case 1:
                return 'Administrador';
                break;
            case 2:
                return 'Usuário';
                break;
        endswitch;
    else :
        return $user['tipo'];
    endif;
}
function userData($field = null)
{
    $user = App\Libraries\UserLib::getByToken();
    return $field ? ($user[$field] ?? null) : $user;
}
function userToken()
{
    return get_cookie('authToken');
}
