<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMediaToArtikelAndGaleri extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('artikel') && ! $this->db->fieldExists('video', 'artikel')) {
            $this->forge->addColumn('artikel', [
                'video' => ['type' => 'TEXT', 'null' => true],
            ]);
        }

        if ($this->db->tableExists('galeri') && ! $this->db->fieldExists('video', 'galeri')) {
            $this->forge->addColumn('galeri', [
                'video' => ['type' => 'TEXT', 'null' => true],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->tableExists('artikel') && $this->db->fieldExists('video', 'artikel')) {
            $this->forge->dropColumn('artikel', 'video');
        }

        if ($this->db->tableExists('galeri') && $this->db->fieldExists('video', 'galeri')) {
            $this->forge->dropColumn('galeri', 'video');
        }
    }
}
