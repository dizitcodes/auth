<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAnalyticsTable extends Migration
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
            'uri' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'method' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'ip' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
            ],
            'date' => [
                'type' => 'DATETIME',
            ],
            'navegador' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'versao_navegador' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'sistema_operacional' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'referencia' => [
                'type' => 'TEXT',
                'null' => true,
            ]
        ]);

        // Define a chave primária
        $this->forge->addKey('id', true);

        // Cria a tabela
        $this->forge->createTable('analytics');
    }

    public function down()
    {
        // Remove a tabela se ela existir
        $this->forge->dropTable('analytics');
    }
}
