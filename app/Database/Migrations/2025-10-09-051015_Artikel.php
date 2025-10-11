<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Artikel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'judul'            => ['type' => 'VARCHAR', 'constraint' => '255'],
            'slug'             => ['type' => 'VARCHAR', 'constraint' => '255', 'unique' => true],
            'isi'              => ['type' => 'TEXT'],
            'gambar'           => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'kategori_id'      => ['type' => 'INT', 'unsigned' => true],
            'penulis_id'       => ['type' => 'INT', 'unsigned' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kategori_id', 'kategori_artikel', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('penulis_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('artikel');
    }

    public function down()
    {
        $this->forge->dropTable('artikel');
    }
}
