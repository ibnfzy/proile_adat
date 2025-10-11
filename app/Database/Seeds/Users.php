<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'     => 'admin',
                'password'     => password_hash('admin', PASSWORD_DEFAULT),
                'email'        => 'admin@nosu.local',
                'nama_lengkap' => 'Administrator',
                'role'         => 'admin',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
