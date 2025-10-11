<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Pengaturan extends Seeder
{
    public function run()
    {
        $data = [
            [
                'key'        => 'site_name',
                'value'      => 'Profil Adat Istiadat Kecamatan Nosu',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'key'        => 'site_description',
                'value'      => 'Website resmi yang menampilkan kekayaan adat dan budaya Kecamatan Nosu, Kabupaten Mamasa, Sulawesi Barat.',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'key'        => 'contact_email',
                'value'      => 'info@nosu.local',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'key'        => 'contact_phone',
                'value'      => '1234567890',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('pengaturan')->insertBatch($data);
    }
}
