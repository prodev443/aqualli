<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateModulesTable extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField('id');
        $this->forge->addField([
            'module' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'module_tag' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->createTable('modules');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('modules');
    }
}
