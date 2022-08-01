<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClassesTable extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField('id');
        $this->forge->addField([
            'start_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'end_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'course_id' => [
                'type' => 'INT',
                'constraint' => 9,
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
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('classes');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('classes');
    }
}
