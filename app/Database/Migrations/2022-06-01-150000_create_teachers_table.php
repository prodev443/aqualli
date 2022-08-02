<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTeachersTable extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField('id');
        $this->forge->addField([
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'second_last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'phone_number' => [
                'type' => ' VARCHAR',
                'constraint' => '20',
            ],
			'mobile_number' => [
                'type' => ' VARCHAR',
                'constraint' => '20',
            ],
            'address_line' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'address_postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
            ],
            'address_city' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
            ],
            'address_state' => [
                'type' => 'TINYINT',
                'constraint' => '2',
            ],
            'address_country' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
                'default' => 'España'
            ],
            'birthdate' => [
                'type' => 'DATE',
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => true,
                'auto_increment' => false,
            ],
            'cv_name' => [
                'type' => ' VARCHAR',
                'constraint' => '100',
            ],
            'cv_path' => [
                'type' => ' VARCHAR',
                'constraint' => '100',
            ],
            'photo_path' => [
                'type' => ' VARCHAR',
                'constraint' => '100',
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
        $this->forge->createTable('teachers');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropTable('teachers');
    }
}
