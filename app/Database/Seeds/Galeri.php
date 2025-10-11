<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Galeri extends Seeder
{
    public function run()
    {
        $data = [
            [
                'judul'      => 'Upacara Adat Nosu',
                'gambar'     => 'upacara.jpg',
                'deskripsi'  => 'Kegiatan tahunan masyarakat Nosu untuk memperingati warisan leluhur.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'judul'      => 'Tarian Tradisional',
                'gambar'     => 'tarian.jpg',
                'deskripsi'  => 'Tarian khas Nosu yang dibawakan dalam berbagai acara adat.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('galeri')->insertBatch($data);
    }
}
