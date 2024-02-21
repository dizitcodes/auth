<?php

namespace App\Controllers\Admin;

class Configuracoes extends BaseController
{
    public function index(): string
    {
        $data = [
            'whatsappStatus' => setting('Whatsapp.Status')
        ];
        return view('admin/pages/configuracoes/index', $data);
    }

    public function create()
    {
        $post = $this->request->getVar();
        foreach ($post as $field => $value) :
            $field = str_replace('_', '.', $field);
            service('settings')->set($field, $value);
        endforeach;
        setToast('success', 'Configurações salvas.');
        return redirect()->to('admin/configuracoes');
    }
}
