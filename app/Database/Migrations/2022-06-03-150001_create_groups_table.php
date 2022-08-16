<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroupsTable extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField('id');
        $this->forge->addField([
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 2,
                'null' => false,
            ],
            'observations' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 9,
            ],
            'assigned_to' => [
                'type' => 'INT',
                'constraint' => 9,
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
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('assigned_to', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addUniqueKey('name');
        $this->forge->createTable('groups');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('groups');
    }
}
