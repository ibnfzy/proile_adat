<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriArtikel extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Budaya', 'slug' => 'budaya', 'created_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Adat', 'slug' => 'adat', 'created_at' => date('Y-m-d H:i:s')],
            ['nama' => 'Kegiatan Masyarakat', 'slug' => 'kegiatan-masyarakat', 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('kategori_artikel')->insertBatch($data);
    }
}
