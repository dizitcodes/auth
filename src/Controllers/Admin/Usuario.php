<?php

namespace App\Controllers\Admin;

use App\Libraries\UserLib;

class Usuario extends BaseController
{
    public function show($uid = null): string
    {
        return view('admin/pages/configuracoes/user');
    }

    public function update()
    {
        $raw = $this->request->getVar();
        $raw = array_filter($raw);
        if (($raw['nome'] ?? NULL) && $raw['nome'] != '') :
            $data['nome'] = $raw['nome'];
        endif;
        if (($raw['password'] ?? NULL) && $raw['password'] != '' && $raw['password'] == $raw['password-confirm']) :
            $data['senha'] = password_hash($raw['password'], PASSWORD_DEFAULT);
        endif;
        UserLib::update($data);
        setToast('success', 'Dados atualizados com sucesso.');
        return redirect()->to('admin/usuario');
    }
}
