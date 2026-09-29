<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTaskAuthFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'full_name',
            ],
        ]);

        $this->forge->addColumn('tasks', [
            'is_archived' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'created_at',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tasks', 'is_archived');
        $this->forge->dropColumn('users', 'password');
    }
}

