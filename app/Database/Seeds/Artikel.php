<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Artikel extends Seeder
{
    public function run()
    {
        $data = [
            [
                'judul'        => 'Upacara Adat Pesta Panen di Nosu',
                'slug'         => 'upacara-adat-pesta-panen-di-nosu',
                'isi'          => 'Pesta panen adalah salah satu tradisi masyarakat Nosu untuk mensyukuri hasil bumi...',
                'gambar'       => null,
                'kategori_id'  => 1,
                'penulis_id'   => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'judul'        => 'Makna Simbolik Rumah Adat Nosu',
                'slug'         => 'makna-simbolik-rumah-adat-nosu',
                'isi'          => 'Rumah adat di Nosu memiliki filosofi mendalam yang mencerminkan hubungan manusia dengan alam...',
                'gambar'       => null,
                'kategori_id'  => 2,
                'penulis_id'   => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('artikel')->insertBatch($data);
    }
}
