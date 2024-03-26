<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddLogTable extends Migration
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
            'user' => [
                'type' => 'INT',
                'constraint' => '5',
            ],
            'table' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'action' => [
                'type' => 'VARCHAR',
                'constraint' => '120',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '120',
            ],
            'context' => [
                'type' => 'VARCHAR',
                'constraint' => '300',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        // Define a chave primária
        $this->forge->addKey('id', true);

        // Cria a tabela
        $this->forge->createTable('logs');
    }

    public function down()
    {
        // Remove a tabela se ela existir
        $this->forge->dropTable('logs');
    }
}
