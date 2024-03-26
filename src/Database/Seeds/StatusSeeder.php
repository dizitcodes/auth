<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'table' => 'users',
                'uid' => 'active',
                'label' => 'Ativo',
                'style' => '{bg:success, text:white}',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'table' => 'users',
                'uid' => 'inative',
                'label' => 'Inativo',
                'style' => '{bg:danger, text:white}',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        $this->db->table('status')->ignore(true)->insertBatch($data);
    }
}
