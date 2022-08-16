<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSchedulesTable extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField('id');
        $this->forge->addField([
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'startTime' => [
                'type' => 'TIME',
                'null' => false
            ],
            'daysOfWeek' => [
                'type' => 'TINYINT',
                'default' => 1,
                'null' => false
            ],
            'className' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'default' => 'bg-info'
            ],
            'course_id' => [
                'type' => 'INT',
                'constraint' => 9,
            ],
            'group_id' => [
                'type' => 'INT',
                'constraint' => 9
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
        $this->forge->createTable('schedules');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('schedules');
    }
}
