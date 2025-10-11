<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KategoriArtikel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => '100'],
            'slug'       => ['type' => 'VARCHAR', 'constraint' => '150', 'unique' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kategori_artikel');
    }

    public function down()
    {
        $this->forge->dropTable('kategori_artikel');
    }
}
