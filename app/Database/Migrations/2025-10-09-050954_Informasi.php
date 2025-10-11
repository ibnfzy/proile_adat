<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Informasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'judul'        => ['type' => 'VARCHAR', 'constraint' => '255'],
            'slug'         => ['type' => 'VARCHAR', 'constraint' => '255', 'unique' => true],
            'konten'       => ['type' => 'TEXT'],
            'gambar'       => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('informasi');
    }

    public function down()
    {
        $this->forge->dropTable('informasi');
    }
}
