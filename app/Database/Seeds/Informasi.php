<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Informasi extends Seeder
{
    public function run()
    {
        $data = [
            [
                'judul'      => 'Profil Kecamatan Nosu',
                'slug'       => 'profil-kecamatan-nosu',
                'konten'     => 'Kecamatan Nosu terletak di Kabupaten Mamasa, Sulawesi Barat. Dikenal dengan adat istiadat yang kental dan keindahan alam pegunungan.',
                'gambar'     => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('informasi')->insertBatch($data);
    }
}
