<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateModulesAccessTable extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField('id');
        $this->forge->addField([
            'role_id' => [
                'type' => 'INT',
                'constraint' => 9,
            ],
            'module_id' => [
                'type' => 'INT',
                'constraint' => 9,
            ],
            'see' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => false,
                'default' => 1
            ],
            'create' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => false,
                'default' => 1
            ],
            'edit' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => false,
                'default' => 1
            ],
            'delete' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => false,
                'default' => 1
            ],
            'propietary_only' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => false,
                'default' => 1
            ],
            'assigned_only' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => false,
                'default' => 1
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('module_id', 'modules', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addUniqueKey(['role_id', 'module_id']);
        $this->forge->createTable('modules_access');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('modules_access');
    }
}
