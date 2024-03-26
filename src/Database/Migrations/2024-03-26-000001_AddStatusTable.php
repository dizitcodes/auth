<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusTable extends Migration
{
    public function up()
    {
        // Define a estrutura da tabela
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'table' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'uid' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'label' => [
                'type' => 'VARCHAR',
                'constraint' => '120',
            ],
            'style' => [
                'type' => 'JSON',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Define a chave primária
        $this->forge->addKey('id', true);

        // Cria a tabela
        $this->forge->createTable('status');
    }

    public function down()
    {
        // Remove a tabela se ela existir
        $this->forge->dropTable('status');
    }
}
