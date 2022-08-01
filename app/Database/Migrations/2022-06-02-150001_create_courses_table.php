<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField('id');
        $this->forge->addField([
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'null' => false,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => true,
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
        $this->forge->createTable('courses');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('courses');
    }
}
