<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField('id');
        $this->forge->addField([
            'student_id' => [
                'type' => 'INT',
                'constraint' => 9,
            ],
            'course_id' => [
                'type' => 'INT',
                'constraint' => 9,
            ],
            'score' => [
                'type' => 'DECIMAL',
                'constraint' => '3,1',
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
        $this->forge->addForeignKey('student_id', 'students', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addUniqueKey(['student_id', 'course_id']);
        $this->forge->createTable('payments');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('payments');
    }
}
