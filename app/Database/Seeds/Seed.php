<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Seed extends Seeder
{
    public function run()
    {
        $this->call("Users");
        $this->call("Informasi");
        $this->call("KategoriArtikel");
        $this->call("Artikel");
        $this->call("Pengaturan");
    }
}
