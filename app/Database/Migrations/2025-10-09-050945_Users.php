<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'username'       => ['type' => 'VARCHAR', 'constraint' => '100', 'unique' => true],
            'password'       => ['type' => 'VARCHAR', 'constraint' => '255'],
            'email'          => ['type' => 'VARCHAR', 'constraint' => '150', 'unique' => true],
            'nama_lengkap'   => ['type' => 'VARCHAR', 'constraint' => '150', 'null' => true],
            'role'           => ['type' => 'ENUM("admin","editor")', 'default' => 'admin'],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
