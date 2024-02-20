<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id' => 1,
            'nome' => 'Super Administrador',
            'email' => 'dev@leomaciel.com',
            'senha' => password_hash('D@3gM1a7', PASSWORD_DEFAULT),
            'tipo' => 0,
            'json' => null,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('users')->ignore(true)->insert($data);
    }
}
